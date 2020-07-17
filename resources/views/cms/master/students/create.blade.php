{!!
  Form::model($student, [
    'route' => $student->exists 
      ? ['students.update', $student->id]
      : 'students.store',
    'method' => $student->exists ? 'PUT' : 'POST'
  ])
!!}
  <div class="form-group">
    {{ Form::label('nisn', 'NISN') }}
    {{ Form::text('nisn', $student ? $student->nisn : null,  ['class' => 'form-control']) }}
  </div>

  <div class="form-group">
    {{ Form::label('nis', 'NIS') }}
    {{ Form::text('nis', $student ? $student->nis : null, ['class' => 'form-control']) }}
  </div>

  <div class="form-group">
    {{ Form::label('nama', 'Nama') }}
    {{ Form::text('nama', $student ? $student->name : null, ['class' => 'form-control']) }}
  </div>

  <div class="form-group">
    {{ Form::label('kelas', 'Kelas') }}
    <select name="kelas" id="kelas" class="form-control">
      <option value="" selected disabled>-Pilih Kelas-</option>
      @foreach($grades as $grade)
        @if($student && $grade->id == $student->grade_id)
          <option value="{{ $grade->id }}" selected>{{ $grade->name . '-' . $grade->major }}</option>
        @else 
          <option value="{{ $grade->id }}">{{ $grade->name . '-' . $grade->major }}</option>
        @endif
      @endForeach
    </select>
  </div>

  <div class="form-group">
    {{ Form::label('alamat', 'Alamat') }}
    {{ Form::textarea('alamat', $student ? $student->address : null, ['class' => 'form-control']) }}
  </div>

  <div class="form-group">
    {{ Form::label('telepon', 'Telepon') }}
    {{ Form::text('telepon', $student ? $student->phone : null, ['class' => 'form-control']) }}
  </div>

  <div class="form-group">
    {{ Form::label('spp', 'SPP') }}
    <select name="spp" id="spp" class="form-control">
      <option value="" selected disabled>-Pilih Spp-</option>
      @foreach($spps as $spp)
        @if($student && $spp->id == $student->spp_id)
          <option value="{{ $spp->id }}" selected>{{ $spp->year . ' - Rp. ' . number_format($spp->nominal) }}</option>
        @else 
          <option value="{{ $spp->id }}">{{ $spp->year . ' - Rp. ' . number_format($spp->nominal) }}</option>
        @endif
      @endForeach
    </select>
  </div>
{!! Form::close() !!}