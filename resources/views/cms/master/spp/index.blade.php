@extends('layouts.cms')

@section('title', 'Spp')
@section('header-title', 'Spp Management')

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <h3 class="card-title">
          Spp
        </h3>
        <a
          href="{{ route('spp.create') }}"
          class="btn btn-sm btn-success btn-show-modal lg"
          title="Buat SPP Baru">
          <em class="fas fa-plus"></em> Buat Spp Baru
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="table table-responsive">
        <table class="table table-striped" id="datatables">
          <thead>
            <tr>
              <th>#</th>
              <th>Tahun</th>
              <th>Nominal</th>
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
        $(function() {
           $('#datatables').DataTable({
              processing: true,
              responsive: true,
              serverSide: true,
              ajax: "{{route('spp.datatables')}}",
              columns: [
                {name: 'id', data: 'DT_RowIndex'},
                {name: 'year', data: 'year'},
                {name: 'nominal', data: 'nominal'},
                {name: 'action', data: 'action'}
              ]
          });
        })
    </script>
@endpush
