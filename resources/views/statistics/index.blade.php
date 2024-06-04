<!-- resources/views/statistics/index.blade.php -->

@extends('layouts.app')

@section('title', 'Estadísticas')


@section('content')
<div class="container">
    <h1>Estadísticas</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Suscriptores</div>
                <div class="card-body">
                    <h5>{{ $subscriberCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Visualizaciones Totales</div>
                <div class="card-body">
                    <h5>{{ $viewsCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Ganancias</div>
                <div class="card-body">
                    <h5>${{ number_format($earnings, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mt-4">Detalles por Video</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Likes</th>
                <th>Comentarios</th>
                <th>Visualizaciones</th>
                <th>Ganancias</th>
            </tr>
        </thead>
        <tbody>
            @foreach($videos as $video)
            <tr>
                <td>{{ $video->title }}</td>
                <td>{{ $video->likes_count }}</td>
                <td>{{ $video->comments_count }}</td>
                <td>{{ $video->views }}</td>
                <td>${{ number_format(($video->likes_count * .5) + ($video->comments_count * .2) + ($video->views * 1.5), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('statistics.reset') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success mt-3">Cobrar</button>
    </form>
</div>
@endsection





