@extends('layouts.cms')

@section('title', 'Buat Pembayaran')
@section('header-title', 'Buat Pembayaran Management')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">
                    Pembayaran
                </h3>
                <a
                    href="{{ route('payments.index') }}"
                    class="btn btn-sm btn-default"
                    title="Buat Pembayaran Baru">
                    <em class="fas fa-chevron-left"></em> Kembali
                </a>
            </div>
        </div>
        {!! Form::model($payment, [ 'route' => 'payments.store', 'method' => 'POST']) !!}
        <div class="card-body">
            <div class="form-group">
                {{ Form::label('siswa', 'Siswa') }}
                <select name="siswa" id="siswa" class="form-control {{ $errors->has('siswa') ? 'is-invalid' : '' }}"
                        style="width: 100%;">
                    <option value="">-Pilih Siswa-</option>
                    @foreach($students as $student)
                        <option
                            value="{{ $student->id }}">{{ $student->name . ' | ' . $student->grade->name . '-' . $student->grade->major }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('siswa') }}
                </div>
            </div>

            <div class="form-group" id="nisn-field" style="display: none;">
                {{ Form::label('nisn', 'NISN') }}
                {{ Form::number('nisn', null, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) }}
            </div>

            <div class="form-group">
                {{ Form::label('spp', 'SPP') }}
                <select name="spp" id="spp" class="form-control {{ $errors->has('spp') ? 'is-invalid' : '' }}"
                        style="width: 100%;">
                    <option value="" selected disabled>-Pilih Spp-</option>
                    @foreach($spps as $spp)
                        @if($payment && $spp->id == $payment->spp_id)
                            <option value="{{ $spp->id }}"
                                    selected>{{ $spp->year . ' - Rp. ' . number_format($spp->nominal) }}</option>
                        @else
                            <option
                                value="{{ $spp->id }}">{{ $spp->year . ' - Rp. ' . number_format($spp->nominal) }}</option>
                        @endif
                    @endForeach
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('spp') }}
                </div>
            </div>

            <div class="form-group" id="bulan-dibayar-field">
                {{ Form::label('bulan_dibayar', 'Bulan Dibayar') }}
                {{ Form::number('bulan_dibayar', null, ['class' => $errors->has('bulan_dibayar') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Pilih Spp Terlebih Dahulu', 'autocomplete' => 'off', 'readonly' => false]) }}
                <div class="invalid-feedback">
                    {{ $errors->first('bulan_dibayar') }}
                </div>
            </div>

            <div class="form-group" id="tahun-dibayar-field">
                {{ Form::label('tahun_dibayar', 'Tahun Dibayar') }}
                {{ Form::number('tahun_dibayar', null, ['class' => $errors->has('tahun_dibayar') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Pilih Spp Terlebih Dahulu', 'autocomplete' => 'off', 'readonly']) }}
                <div class="invalid-feedback">
                    {{ $errors->first('tahun_dibayar') }}
                </div>
            </div>

            <div class="form-group" id="jumlah-bayar-field">
                {{ Form::label('jumlah_bayar', 'Jumlah Bayar') }}
                {{ Form::number('jumlah_bayar', null, ['class' => $errors->has('jumlah_bayar') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Pilih Spp Terlebih Dahulu', 'autocomplete' => 'off', 'readonly']) }}
                <div class="invalid-feedback">
                    {{ $errors->first('jumlah_bayar') }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary float-right">
                <em class="fas fa-check"></em> Simpan
            </button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('script')
    <script>
        $(function () {
            let nominalState = 0

            $('#siswa').select2()
            $("#spp").select2()

            // Siswa onchange method
            $('#siswa').on('change', async function () {
                const studentDetail = await fetch(`/cms/master/students/detail/${$(this).val()}`)
                const toJson = await studentDetail.json()
                const {nisn} = toJson

                $('#nisn').val(nisn)
                $('#nisn-field').css('display', 'block')
            })

            // Spp onchange method
            $('#spp').on('change', async function () {
                const sppDetail = await fetch(`/cms/master/spp/detail/${$(this).val()}`)
                const toJson = await sppDetail.json()
                const {year, nominal} = toJson

                $('#tahun_dibayar').val(year)
                $('#bulan_dibayar').prop('placeholder', '')
                $('#bulan_dibayar').prop('readonly', false)
                nominalState = nominal

                const amountVal = $('#jumlah_bayar').val()
                if (!amountVal) {
                    $('#jumlah_bayar').prop('placeholder', 'Silahkan isi Bulan Dibayar')
                }
            })

            // Jumlah bayar onChange method
            $('#bulan_dibayar').on('keyup', function () {
                let sum = $(this).val() * nominalState

                $('#jumlah_bayar').val(sum)
            })
        })
    </script>
@endpush
