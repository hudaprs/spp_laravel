<div class="table table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>NISN</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>SPP</th>
        <th>Dibuat Pada</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>{{ $student->nisn }}</td>
        <td>{{ $student->nis }}</td>
        <td>{{ $student->name }}</td>
        <td>{{ $student->grade->name . '-' . $student->grade->major }}</td>
        <td>{{ $student->spp->year . ' - Rp. ' . number_format($student->spp->nominal) }}</td>
        <td>{{ $student->created_at }}</td>
      </tr>
    </tbody>
  </table>
</div>

<h6>Alamat: </h6>
<p>
  {{ $student->address }}
</p>