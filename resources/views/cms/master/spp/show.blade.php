<div class="table table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Tahun</th>
        <th>Nominal</th>
        <th>Dibuat Pada</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>{{ $spp->year }}</td>
        <td>Rp. {{ number_format($spp->nominal) }}</td>
        <td>{{ $spp->created_at }}</td>
      </tr>
    </tbody>
  </table>
</div>