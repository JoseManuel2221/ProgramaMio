@extends('layouts.app')

@section('title', 'Buscar Usuarios')

@section('content')
<div class="container">
    <h1>Buscar Usuarios</h1>
    <form action="{{ route('profiles.search') }}" method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Buscar usuario...">
    </form>
    @if(isset($users))
        @foreach ($users as $user)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <a href="{{ route('profile.show', $user->id) }}" class="btn btn-primary">Ver Perfil</a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
