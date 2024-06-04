@extends('layouts.app')

@section('title', 'Videos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">Mis Videos</h1>
            <hr>
            @foreach ($videos as $video)
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->title }}</h5>
                        <p class="card-text">{{ $video->description }}</p>
                        <video width="320" height="240" controls class="mx-auto d-block">
                            <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="mt-3">
                            <a href="{{ route('videos.show', $video) }}" class="btn btn-info">Ver</a>
                            @if ($video->user_id === Auth::id())
                                <a href="{{ route('videos.edit', $video) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('videos.destroy', $video) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection



