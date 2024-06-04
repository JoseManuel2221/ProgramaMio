@extends('layouts.app')

@section('content')
<div class="container">
    <style>
        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">{{ $user->name }}'s Profile</div>

                <div class="card-body">
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="profile-picture img-fluid mb-3 mx-auto d-block">
                    @endif
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Description:</strong> {{ $user->description }}</p>
                    <p><strong>Suscriptores:</strong> {{ $user->subscribers->count() }}</p>

                    @if ($user->whatsapp)
                        <p>
                            <a href="https://wa.me/{{ $user->whatsapp }}" target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </p>
                    @endif

                    @if ($user->facebook)
                        <p>
                            <a href="https://facebook.com/{{ $user->facebook }}" target="_blank" class="btn btn-primary">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                        </p>
                    @endif

                    @if ($user->gmail)
                        <p>
                            <a href="mailto:{{ $user->gmail }}" target="_blank" class="btn btn-danger">
                                <i class="fas fa-envelope"></i> Gmail
                            </a>
                        </p>
                    @endif

                    @if (Auth::id() !== $user->id)
                        @if (Auth::user()->subscriptions->contains('user_id', $user->id))
                            <form action="{{ route('unsubscribe', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Desuscribirse</button>
                            </form>
                        @else
                            <form action="{{ route('subscribe', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Suscribirse</button>
                            </form>
                        @endif
                    @endif

                    <h4>Uploaded Videos</h4>
                    <div class="list-group">
                        @foreach ($videos as $video)
                            <div class="card mb-3 text-center">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $video->title }}</h5>
                                    <a href="{{ route('videos.show', $video) }}">
                                        <video width="640" height="480" class="mx-auto d-block">
                                            <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </a>
                                    <p class="card-text"> <strong>Descripción del video:</strong>  {{ $video->description }}</p>
                                    <p><strong>Views:</strong> {{ $video->views }}</p> <!-- Show views -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyToClipboard(linkId, successId) {
        var copyText = document.getElementById(linkId);
        copyText.select();
        copyText.setSelectionRange(0, 99999);  // For mobile devices

        navigator.clipboard.writeText(copyText.value).then(function() {
            var copySuccess = document.getElementById(successId);
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
