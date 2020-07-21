@extends('layouts.cms')

@section('title', 'Pembayaran')
@section('header-title', 'Detail Pembayaran')

@section('content')
    <div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> Invoice SPP.
                <small class="float-right">Date: {{ date('d-M-Y') }}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>Payment Management.</strong><br>
                Jl Kebon Gedang XI, RT 04 RW 08<br>
                Bandung, Indonesia 40123<br>
                Phone: 022-321123<br>
                Email: paymentmanagement@pm.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>{{ $payment->student->name }}</strong><br>
                {!! $payment->student->address ? $payment->student->address . "<br>" : '' !!}
                NISN: {{ $payment->student->nisn }} <br>
                NIS: {{ $payment->student->nis }} <br>
                Phone: {{ $payment->student->phone }}<br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice #{{ $payment->id }}</b><br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="table table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Petugas</th>
                    <th>Siswa</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->student->name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- /.col -->
        <div class="col-6">
            <div class="table-responsive">
                <p class="lead">
                    Transaksi Pada {{ date('d-M-Y', strtotime($payment->created_at)) }}
                </p>
                <table class="table">
                    <tr>
                        <th>Bulan Dibayar</th>
                        <td>{{ $payment->month }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Dibayar</th>
                        <td>{{ $payment->year }}</td>
                    </tr>
                    <tr>
                        <th>Spp</th>
                        <td>Rp. {{ number_format($payment->spp->nominal) }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Bayar</th>
                        <td>Rp. {{ number_format($payment->amount) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <a href="{{ route('payments.print', $payment->id) }}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
        </div>
    </div>
    </div>
@endsection
