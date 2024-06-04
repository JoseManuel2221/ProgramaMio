@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Main Video Content -->
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">{{ $video->user->name }}'s Video</div>

                <div class="card-body">
                    <h5 class="card-title">{{ $video->title }}</h5>
                    <p class="card-text">{{ $video->description }}</p>
                    <video width="640" height="480" controls class="mx-auto d-block">
                        <source src="{{ Storage::url($video->video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    
                    
                    <div class="mt-3 d-flex justify-content-center gap-2">
                        @if ($video->user_id === Auth::id())
                            <a href="{{ route('videos.edit', $video) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('videos.destroy', $video) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('like', $video->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-thumbs-up"></i> ({{ $video->likes()->count() }})
                            </button>
                        </form>

                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#shareModal">
                            <i class="fas fa-share"></i>
                        </button>

                        <button class="btn btn-info" onclick="document.getElementById('comment-form-{{ $video->id }}').style.display='block'">
                            <i class="fas fa-comment"></i>
                        </button>
                    </div>

                    <div id="comment-form-{{ $video->id }}" style="display:none;" class="mt-3">
                        <form action="{{ route('comment.store', $video->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" placeholder="Escribe un comentario..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                        </form>
                    </div>

                    <div class="mt-3">
                        <h5>Comentarios</h5>
                        @foreach ($video->comments as $comment)
                            <div class="card mt-2 text-start">
                                <div class="card-body">
                                    <p>{{ $comment->content }}</p>
                                    <small>{{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Videos -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Más videos de {{ $video->user->name }}</div>
                <div class="card-body">
                    @foreach ($otherVideos as $otherVideo)
                        <div class="mb-3">
                            <h5 class="card-title">{{ $otherVideo->title }}</h5>
                            @if ($otherVideo->thumbnail_path)
                                <img src="{{ asset('storage/' . $otherVideo->thumbnail_path) }}" alt="{{ $otherVideo->title }} thumbnail" class="img-fluid mb-2">
                            @endif
                            <a href="{{ route('videos.show', $otherVideo->id) }}" class="btn btn-primary btn-sm">Ver Video</a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Google AdSense -->
            <div class="mt-3">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6155608798275997"
                     crossorigin="anonymous"></script>
                <!-- JoseManuel -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-6155608798275997"
                     data-ad-slot="2762949345"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Compartir Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <input type="text" id="videoLink" class="form-control" value="{{ route('videos.show', $video->id) }}" readonly>
                <div id="copySuccess" class="mt-2" style="display:none; color: green;">
                    <i class="fas fa-check-circle"></i> Copiado exitosamente
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="copyToClipboard()">Copiar Enlace</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("videoLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999);  // For mobile devices

        navigator.clipboard.writeText(copyText.value).then(function() {
            var copySuccess = document.getElementById("copySuccess");
            copySuccess.style.display = "block";
            setTimeout(function() {
                copySuccess.style.display = "none";
            }, 2000);
        }, function(err) {
            console.error('Error al copiar el enlace: ', err);
        });
    }
</script>
@endsection
