@extends('layouts.cms')

@section('title', 'Pembayaran')
@section('header-title', 'Pembayaran Management')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">
                    Pembayaran
                </h3>
                <a
                    href="{{ route('payments.create') }}"
                    class="btn btn-sm btn-success"
                    title="Buat Pembayaran Baru">
                    <em class="fas fa-plus"></em> Buat Pembayaran Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-striped" id="datatables">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Petugas</th>
                        <th>NISN</th>
                        <th>Tanggal Bayar</th>
                        <th>Bulan Dibayar</th>
                        <th>SPP</th>
                        <th>Jumlah Bayar</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function () {
            $('#datatables').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: "{{route('payments.datatables')}}",
                columns: [
                    {name: 'id', data: 'DT_RowIndex'},
                    {name: 'user', data: 'user'},
                    {name: 'nisn', data: 'nisn'},
                    {name: 'created_at', data: 'created_at'},
                    {name: 'month', data: 'month'},
                    {name: 'spp', data: 'spp'},
                    {name: 'amount', data: 'amount'},
                    {name: 'action', data: 'action'}
                ],
                columnDefs: [
                    {
                        targets: "_all",
                        createdCell: function (td) {
                            $(td).css("white-space", "nowrap");
                        },
                    },
                ],
            });
        })
    </script>
@endpush
