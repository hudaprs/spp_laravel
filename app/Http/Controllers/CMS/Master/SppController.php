<?php

namespace App\Http\Controllers\CMS\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Spp;
use DB;
use DataTables;

class SppController extends Controller
{
    public function __construct()
    {
        // Only high admin can access this resource
        $this->middleware(function($request, $next) {
            if(Gate::allows('is_high_admin')) return $next($request);
            abort(403, config('globalvar.high_admin_gate_message'));
        }, ['except' => ['sppDataTables']]);
    }
    
    public function sppDataTables(Request $request)
    {
        $spps = Spp::query();

        // Check if request is ajax
        if($request->ajax()) {
            return DataTables::of($spps)
                ->addColumn('action', function($spp) {
                    return view('inc.cms._action', [
                        'model' => $spp,
                        'url_show' => route('spp.show', $spp->id),
                        'url_edit' => route('spp.edit', $spp->id),
                        'url_destroy' => route('spp.destroy', $spp->id)
                    ]);
                })
                ->editColumn('nominal', function($spp) {
                    return "Rp. " . number_format($spp->nominal);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return response()->json(['message' => 'This request accept ajax only'], 400);
        }
    }

    public function sppRequest(Request $request, $id = null)
    {
        $request->validate([
            'tahun' => 'required|max:11',
            'nominal' => 'required|max:11'
        ]);

        DB::beginTransaction();
        try {
            $spp = $id ? Spp::findOrFail($id) : new Spp;
            $spp->year = $request->tahun;
            $spp->nominal = $request->nominal;
            $spp->save();

            DB::commit();
            return response()->json([
                'message' => $id ? 'Spp berhasil diubah' : 'Spp berhasil dibuat'
            ], $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.master.spp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $spp = new Spp;
        return view('cms.master.spp.create', compact('spp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->sppRequest($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $spp = Spp::findOrFail($id);
        return view('cms.master.spp.show', compact('spp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spp = Spp::findOrFail($id);
        return view('cms.master.spp.create', compact('spp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->sppRequest($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $spp = Spp::findOrFail($id);
            $spp->delete();

            DB::commit();
            return response()->json(['message' => 'Spp berhasil dihapus'], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=> $e->getMessage()], 500);
        }
    }
}
