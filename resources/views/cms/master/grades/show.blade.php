<div class="table table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Dibuat Pada</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>{{ $grade->name . '-' . $grade->major }}</td>
        <td>{{ $grade->created_at }}</td>
      </tr>
    </tbody>
  </table>
</div>