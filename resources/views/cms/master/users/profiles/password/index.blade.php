@extends('layouts.cms')

@section('title', 'Edit Password')
@section('header-title', 'Edit Password')

@section('content')
  <div class="card card-primary card-solid">
    <div class="card-header">
      <div class="card-title float-left">
        Edit Password
      </div>

      <div class="float-right">
        <a href="{{ route('users.profile', $user->id) }}" class="btn btn-default btn-sm text-dark">
          Kembali
        </a>
      </div>
    </div>

    <div class="card-body">
      {!! Form::open([
          'route' => ['users.update-password', $user->id],
          'method' => 'PUT'
        ])
      !!}

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              {{ Form::label('password', 'New Password') }}
              {{ Form::password('password', ['class' => 'form-control ' . ($errors->first('password') ? 'is-invalid' : null)]) }}
              <div class="text-danger">
                {{ $errors->first('password') }}
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              {{ Form::label('password_confirmation', 'Password Confirmation') }}
              {{ Form::password('password_confirmation', ['class' => 'form-control ' . ($errors->first('password_confirmation') ? 'is-invalid' : null)]) }}
              <div class="text-danger">
                {{ $errors->first('password_confirmation') }}
              </div>
            </div>
          </div>
        </div>

        {{ Form::submit('Change Password', ['class' => 'btn btn-primary']) }}
       
      {!! Form::close() !!}
    </div>
  </div>
@endsection