@extends('layouts.cms')

@section('title', 'Siswa')
@section('header-title', 'Siswa Management')

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <h3 class="card-title">
          Siswa
        </h3>
        <a
          href="{{ route('students.create') }}"
          class="btn btn-sm btn-success btn-show-modal lg"
          title="Buat Siswa Baru">
          <em class="fas fa-plus"></em> Buat Siswa Baru
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="table table-responsive">
        <table class="table table-striped" id="datatables">
          <thead>
            <tr>
              <th>#</th>
              <th>NISN</th>
              <th>NIS</th>
              <th>Name</th>
              <th>Siswa</th>
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
              ajax: "{{route('students.datatables')}}",
              columns: [
                {name: 'id', data: 'DT_RowIndex'},
                {name: 'nisn', data: 'nisn'},
                {name: 'nis', data: 'nis'},
                {name: 'name', data: 'name'},
                {name: 'grade', data: 'grade'},
                {name: 'action', data: 'action'}
              ]
          });
        })
    </script>
@endpush
