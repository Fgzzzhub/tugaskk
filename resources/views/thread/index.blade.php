@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Form buat thread --}}
    <form action="{{ route('threads.store') }}" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Judul" class="form-control mb-2">
        <textarea name="content" placeholder="Tulis isi thread..." class="form-control mb-2"></textarea>
        <button type="submit" class="btn btn-primary">Post</button>
    </form>

    <hr>

    {{-- List thread --}}
    @foreach($threads as $thread)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $thread->title }}</h5>
                <p>{{ $thread->content }}</p>
                <small>by {{ $thread->user->name }}</small>

                {{-- Like --}}
                <form action="{{ route('threads.like', $thread) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        👍 {{ $thread->likes->count() }}
                    </button>
                </form>

                {{-- Comments --}}
                <div class="mt-2">
                    <form action="{{ route('comments.store', $thread) }}" method="POST">
                        @csrf
                        <input type="text" name="content" class="form-control mb-1" placeholder="Tulis komentar...">
                    </form>

                    @foreach($thread->comments as $comment)
                        <p><b>{{ $comment->user->name }}</b>: {{ $comment->content }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection
