<?php

namespace App\Http\Controllers\CMS\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Grade;
use DB;
use DataTables;


class GradeController extends Controller
{
    public function __construct()
    {
        // Only high admin can access this resource
        $this->middleware(function($request, $next) {
            if(Gate::allows('is_high_admin')) return $next($request);
            abort(403, config('globalvar.high_admin_gate_message'));
        }, ['except' => ['gradeDataTables']]);
    }

    public function gradeDataTables(Request $request)
    {
        $grades = Grade::query();

        // Check if request is ajax
        if($request->ajax()) {
            return DataTables::of($grades)
                ->addColumn('action', function($grade) {
                    return view('inc.cms._action', [
                        'model' => $grade,
                        'url_show' => route('grades.show', $grade->id),
                        'url_edit' => route('grades.edit', $grade->id),
                        'url_destroy' => route('grades.destroy', $grade->id)
                    ]);
                })
                ->addColumn('concat', function($grade) {
                    return $grade->name . '-' . $grade->major;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return response()->json(['message' => 'This request accept ajax only'], 400);
        }
    }

    public function gradeRequest(Request $request, $id = null)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $grade = $id ? Grade::findOrFail($id) : new Grade;
            $grade->name = $request->nama;
            $grade->major = $request->jurusan;
            $grade->save();

            DB::commit();
            return response()->json([
                'message' => $id ? 'Kelas berhasil diubah' : 'Kelas berhasil dibuat'
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
        return view('cms.master.grades.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grade = new Grade;
        return view('cms.master.grades.create', compact('grade'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->gradeRequest($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grade = Grade::findOrFail($id);
        return view('cms.master.grades.index', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        return view('cms.master.grades.create', compact('grade'));
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
        return $this->gradeRequest($request, $id);
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
            $grade = Grade::findOrFail($id);
            $grade->delete();

            DB::commit();
            return response()->json(['message' => 'Kelas berhasil dihapus'], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=> $e->getMessage()], 500);
        }
    }
}
