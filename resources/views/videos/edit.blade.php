@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Video</h1>
    <form action="{{ route('videos.update', $video) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" class="form-control" value="{{ $video->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" required>{{ $video->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="video">Archivo de Video (opcional)</label>
            <input type="file" name="video" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Actualizar Video</button>
    </form>
</div>
@endsection

