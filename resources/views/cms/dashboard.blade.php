@extends('layouts.cms')

@section('title', 'Dashboard')
@section('header-title', 'Dashboard')

@section('content')
  {{-- SPP Payment - For All --}}
  @include('cms._transactions')
  @if(auth()->user()->role->name === "High Admin") 
    {{-- Registered User - For Admin Only --}}
    @include('cms._registered_user')
  @endif
@endsection

@push('script')
  <script src="{{ asset('js/cms/datatables.js') }}"></script>
  <script src="{{ asset('js/cms/dashboard/registeredUser.js') }}"></script>
@endpush