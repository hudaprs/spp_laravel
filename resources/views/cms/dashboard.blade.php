@extends('layouts.cms')

@section('title', 'Dashboard')
@section('header-title', 'Dashboard')

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Welcome
      </h3>
    </div>
    <div class="card-body">
      Welcome to Laravel starter.
    </div>
  </div>

  {{-- Registered User --}}
  @include('cms.registered_user')
@endsection

@push('script')
  <script src="{{ asset('js/cms/datatables.js') }}"></script>
  <script src="{{ asset('js/cms/dashboard/registeredUser.js') }}"></script>
@endpush