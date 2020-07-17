@extends('layouts.cms')

@section('title', 'Kelas')
@section('header-title', 'Kelas Management')

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <h3 class="card-title">
          Kelas
        </h3>
        <a
          href="{{ route('grades.create') }}"
          class="btn btn-sm btn-success btn-show-modal lg"
          title="Create New User">
          <em class="fas fa-plus"></em> Buat Kelas Baru
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="table table-responsive">
        <table class="table table-striped" id="datatables">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
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
              ajax: "{{route('grades.datatables')}}",
              columns: [
                {name: 'id', data: 'DT_RowIndex'},
                {name: 'concat', data: 'concat'},
                {name: 'action', data: 'action'}
              ]
          });
        })
    </script>
@endpush
