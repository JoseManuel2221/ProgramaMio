<!-- resources/views/videos/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Subir Nuevo Video</h1>
    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="video">Archivo de Video</label>
            <input type="file" name="video" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Subir Video</button>
    </form>
</div>
@endsection
