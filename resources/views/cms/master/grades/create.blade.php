{!!
  Form::model($grade, [
    'route' => $grade->exists 
      ? ['grades.update', $grade->id]
      : 'grades.store',
    'method' => $grade->exists ? 'PUT' : 'POST'
  ])
!!}
  <div class="form-group">
    {{ Form::label('nama', 'Nama') }}
    {{ Form::text('nama', $grade ? $grade->name : null,  ['class' => 'form-control']) }}
  </div>

  <div class="form-group">
    {{ Form::label('jurusan', 'Jurusan') }}
    {{ Form::text('jurusan', $grade ? $grade->major : null, ['class' => 'form-control']) }}
  </div>
{!! Form::close() !!}