@extends('layouts.app')

@section('title', 'Configuracion del perfil')

@section('content')
<div class="container">
    <h1>Configuraciones</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nuevo nombre del Canal</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        
        <div class="form-group">
            <label for="description">Nueva descripción del Canal</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="profile_picture">Foto de Perfil</label>
            <input type="file" name="profile_picture" class="form-control">
            @if ($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="img-fluid mt-2" width="150">
            @endif
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Actualizar Configuraciones</button>
    </form>
</div>
@endsection



