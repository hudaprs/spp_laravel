<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Spp;
use DB;
use DataTables;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Only high admin can access this resource
        $this->middleware(function ($request, $next) {
            if (Gate::allows('admin_and_petugas')) return $next($request);
            abort(403, config('globalvar.unauthorized'));
        }, ['except' => ['paymentDataTables']]);
    }

    public function paymentDataTables(Request $request)
    {
        $payments = Payment::query();

        // Check if request is ajax
        if ($request->ajax()) {
            return DataTables::of($payments)
                ->addColumn('action', function ($payment) {
                    return "<a href='/cms/payments/$payment->id' class='btn btn-sm btn-info'><em class='fas fa-eye'></em></a>" . " " . "<a href=\"/cms/payments/$payment->id\" class=\"btn btn-sm btn-danger btn-destroy\" title=\"Delete?\"><em class=\"fas fa-trash\"></em></a>";
                })
                ->addColumn('user', function ($payment) {
                    return $payment->user->name;
                })
                ->addColumn('nisn', function ($payment) {
                    return $payment->student->nisn;
                })
                ->addColumn('spp', function ($payment) {
                    return $payment->spp->year . ' - Rp. ' . number_format($payment->spp->nominal);
                })
                ->addColumn('amount', function ($payment) {
                    return "Rp. " . number_format($payment->amount);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return response()->json(['message' => 'This request accept ajax only'], 400);
        }
    }

    public function paymentPDF($id)
    {
        $payment = Payment::with('user', 'student', 'spp')->findOrFail($id);
        return view('cms.payments.print', compact('payment'));
    }

    public function paymentRequest(Request $request)
    {
        $request->validate([
            'siswa' => 'required',
            'bulan_dibayar' => 'required|digits_between:1,36',
            'tahun_dibayar' => 'required|digits_between:1,4',
            'spp' => 'required',
            'jumlah_bayar' => 'required|digits_between:1, 9000000'
        ]);


        DB::beginTransaction();
        try {
            $payment = new Payment;
            $payment->user_id = auth()->user()->id;
            $payment->student_id = $request->siswa;
            $payment->month = $request->bulan_dibayar;
            $payment->year = $request->tahun_dibayar;
            $payment->spp_id = $request->spp;
            $payment->amount = $request->jumlah_bayar;
            $payment->save();

            DB::commit();
            return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dibuat');
        } catch (\Exception $e) {
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
        return view('cms.payments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment = new Payment;
        $students = Student::orderBy('name', 'asc')->with('grade')->get();
        $spps = Spp::orderBy('year', 'asc')->get();
        return view('cms.payments.create', compact('payment', 'students', 'spps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->paymentRequest($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::with('user', 'student', 'spp')->findOrFail($id);
        return view('cms.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $payment = Payment::findOrFail($id);
//        return view('cms.payments.create', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        return $this->paymentRequest($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();

            DB::commit();
            return response()->json(['message' => 'Pembayaran berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
