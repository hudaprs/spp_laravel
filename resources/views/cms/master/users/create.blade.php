{!!
  Form::model($user, [
    'route' => $user->exists 
      ? ['users.update', $user->id]
      : 'users.store',
    'method' => $user->exists ? 'PUT' : 'POST'
  ])
!!}

  <div class="form-group">
    {{ Form::label('name', 'Name') }}
    {{ Form::text('name', null,  ['class' => 'form-control']) }}
  </div>

  <div class="form-group">
    {{ Form::label('email', 'Email') }}
    {{ Form::email('email', null, ['class' => 'form-control']) }}
  </div>

  @if(!$user->exists)
    <div class="form-group">
      {{ Form::label('password', 'Password') }}
      {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
      {{ Form::label('password_confirmation', 'Password Confirmation') }}
      {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
    </div>
  @endif

  <div class="form-group">
    {{ Form::label('role', 'Role') }}
    <select name="role" id="role" class="form-control {{ $user->exists ? 'role-edit' : 'role-create' }}"></select>
  </div>

{!! Form::close() !!}

<script>
  $(function() {
    var user = {!! $user !!}

    // Role List
    ajaxSelect2(`${$.isEmptyObject(user) ? '.role-create' : '.role-edit'}`, "/cms/master/roles/all");

    /*
    ** Change select option when data not null
    */
    if(user) {
      var changeRole = user.role ? new Option(user.role.name, user.role.id, true, true) : null
      $('.role-edit').append(changeRole).trigger('change')
    }
  })
</script>