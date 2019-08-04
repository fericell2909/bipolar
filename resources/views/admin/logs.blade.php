@extends('admin.layouts.app_admin')
@section('title', 'Log de actividades')
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        {{ $logs->links() }}
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Tipo de cambio</th>
              <th>Elemento</th>
              <th>Usuario</th>
              <th>Cambios</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $log)
              <tr>
                <td class="align-middle">{{ $log->id }}</td>
                <td class="align-middle">{{ ucfirst($log->description) }}</td>
                <td class="align-middle">@dump(class_basename($log->subject))</td>
                <td class="align-middle"><pre>{{ optional($log->causer)->email }}</pre></td>
                <td class="align-middle"><code>@dump($log->changes()->toArray())</code></td>
                <td class="align-middle">{{ $log->created_at->toDayDateTimeString() }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection