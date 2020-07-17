<?php

namespace App\Http\Controllers\CMS\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Spp;
use DB;
use DataTables;

class StudentController extends Controller
{
    public function __construct()
    {
        // Only high admin can access this resource
        $this->middleware(function($request, $next) {
            if(Gate::allows('is_high_admin')) return $next($request);
            abort(403, config('globalvar.high_admin_gate_message'));
        }, ['except' => ['studentsDataTables']]);
    }
    
    public function studentDataTables(Request $request)
    {
        $students = Student::query();

        // Check if request is ajax
        if($request->ajax()) {
            return DataTables::of($students)
                ->addColumn('action', function($student) {
                    return view('inc.cms._action', [
                        'model' => $student,
                        'url_show' => route('students.show', $student->id),
                        'url_edit' => route('students.edit', $student->id),
                        'url_destroy' => route('students.destroy', $student->id)
                    ]);
                })
                ->addColumn('grade', function($student) {
                    return $student->grade->name . '-' . $student->grade->major;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return response()->json(['message' => 'This request accept ajax only'], 400);
        }
    }

    public function studentRequest(Request $request, $id = null)
    {
        $request->validate([
            'nisn' => 'required',
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'spp' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $student = $id ? Student::findOrFail($id) : new Student;
            $student->nisn = $request->nisn;
            $student->nis = $request->nis;
            $student->name = $request->nama;
            $student->grade_id = $request->kelas;
            $student->address = $request->alamat;
            $student->phone = $request->telepon;
            $student->spp_id = $request->spp;
            $student->save();

            DB::commit();
            return response()->json([
                'message' => $id ? 'Siswa berhasil diubah' : 'Siswa berhasil dibuat'
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
        return view('cms.master.students.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student = new Student;
        $grades = Grade::orderBy('name', 'asc')->get();
        $spps = Spp::orderBy('year', 'asc')->get();
        return view('cms.master.students.create', compact('student', 'grades', 'spps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->studentRequest($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('cms.master.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $grades = Grade::orderBy('name', 'asc')->get();
        $spps = Spp::orderBy('year', 'asc')->get();
        return view('cms.master.students.create', compact('student', 'grades', 'spps'));
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
        return $this->studentRequest($request, $id);
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
            $student = Student::findOrFail($id);
            $student->delete();

            DB::commit();
            return response()->json(['message' => 'Siswa berhasil dihapus'], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=> $e->getMessage()], 500);
        }
    }
}
