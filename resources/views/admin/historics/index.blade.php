@extends('admin.layouts.app_admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">Lista de banners</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Orden</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($historics as $historic)
                    <?php /** @var \App\Models\Historic $historic */ ?>
                    <tr>
                        <td>{{ $historic->name }}</td>
                        <td>
                          <button class="btn btn-dark btn-rounded btn-sm" data-target="#historic_preview_{{ $historic->id }}" data-toggle="modal">
                              <i class="fa fa-eye"></i> Ver imagen
                          </button>
                        </td>
                        <td>{{ $historic->order }}</td>
                        <td>
                          <a href="{{ route('historics.edit', $historic->id) }}" class="btn btn-dark btn-rounded btn-sm">
                            <i class="fa fa-pencil"></i> Editar
                          </a>
                        </td>
                    </tr>
                    @include('admin.partials.historic_preview', ['id' => $historic->id, 'image' => $historic->photo])
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection