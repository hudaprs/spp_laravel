{!!
  Form::model($spp, [
    'route' => $spp->exists 
      ? ['spp.update', $spp->id]
      : 'spp.store',
    'method' => $spp->exists ? 'PUT' : 'POST'
  ])
!!}
  <div class="form-group">
    {{ Form::label('tahun', 'Tahun') }}
    {{ Form::number('tahun', $spp ? $spp->year : null,  ['class' => 'form-control']) }}
  </div>

  <div class="form-group">
    {{ Form::label('nominal', 'Nominal') }}
    {{ Form::number('nominal', $spp ? $spp->nominal : null, ['class' => 'form-control']) }}
  </div>
{!! Form::close() !!}