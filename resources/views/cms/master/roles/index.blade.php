@extends('layouts.cms')

@section('title', 'Roles')
@section('header-title', 'Roles Management')

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <h3 class="card-title">
          Roles
        </h3>
        <a 
          href="{{ route('roles.create') }}" 
          class="btn btn-sm btn-success btn-show-modal lg"
          title="Create New User">
          <em class="fas fa-plus"></em> Create New Role
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="table table-responsive">
        <table class="table table-striped" id="datatables">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script src="{{ asset('js/cms/datatables.js') }}"></script>
  <script src="{{ asset('js/cms/master/roles/index.js') }}"></script>
@endpush