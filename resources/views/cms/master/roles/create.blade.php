{!!
  Form::model($role, [
    'route' => $role->exists 
      ? ['roles.update', $role->id]
      : 'roles.store',
    'method' => $role->exists ? 'PUT' : 'POST'
  ])
!!}

  <div class="form-group">
    {{ Form::label('name', 'Name') }}
    {{ Form::text('name', null,  ['class' => 'form-control']) }}
  </div>

{!! Form::close() !!}