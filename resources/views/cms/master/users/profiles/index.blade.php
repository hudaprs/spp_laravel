@extends('layouts.cms')

@section('title', 'Profile Management')
@section('header-title', 'Profile Management')

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img 
              class="profile-user-img img-fluid img-circle" 
              src="{{ $user->image === null 
                ? Avatar::create($user->name)->toBase64()
                : asset('storage/images/users/' . $user->image) }}" 
              alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">{{ $user->name }}</h3>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <strong>Email</strong> <a class="float-right">{{ $user->email }}</a>
            </li>
          </ul>

          {!! 
            Form::open([
              'route' => ['users.delete-photo-profile', $user->id],
              'method' => 'PUT',
              'onSubmit' => 'return confirm("Delete photo profile?")'
            ]) 
          !!}
            {{ Form::submit('Delete Photo Profile', ['class' => 'btn btn-block btn-warning']) }}
          {!! Form::close() !!}
          <hr>
          {!! 
            Form::open([
              'route' => ['users.delete-account', $user->id],
              'method' => 'DELETE',
              'onSubmit' => 'return confirm("Delete account?")'
            ]) 
          !!}
            {{ Form::submit('Delete Acccount', ['class' => 'btn btn-block btn-danger']) }}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card card-primary card-solid">
        <div class="card-header">
          <div class="card-title">
            Your profile
          </div>
        </div>
        <div class="card-body">
          {!! Form::open([
              'route' => ['users.profile-update', $user->id],
              'method' => 'PUT',
              'enctype' => 'multipart/form-data'
            ]) 
          !!} 
            <div class="form-group">
              {{ Form::label('image', 'Gambar') }}
              <br>
              {{ Form::file('image') }}  
              <div class="text-danger">
                {{ $errors->first('image') }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('name', 'Name') }}
              {{ Form::text('name', $user->name, ['class' => 'form-control ' . ($errors->first('name') ? 'is-invalid' : null), 'placeholder' => 'Full Name']) }}
              <div class="text-danger">
                {{ $errors->first('name') }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('email', 'Email') }}
              {{ Form::email('email', $user->email, ['class' => 'form-control ' . ($errors->first('email') ? 'is-invalid' : null), 'placeholder' => 'Email']) }}
              <div class="text-danger">
                {{ $errors->first('email') }}
              </div>
            </div>

            <div class="d-flex justify-content-between">
              {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}

              <a href="{{ route('users.edit-password', $user->id) }}" class="btn btn-info">
                Change Password
              </a>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection