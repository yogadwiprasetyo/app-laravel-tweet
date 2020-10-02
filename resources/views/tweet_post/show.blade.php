@extends('layouts.app')

@section('content')
<div class="container">
    {{-- ALERT SUCCESS --}}
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Go home --}}
    <div class="mb-2">
        <a href="{{ route('home') }}" 
           class="h3 text-dark text-decoration-none w-50">
           &larr;
        </a href="{{ route('home') }}">
    </div>

    {{-- card tweet --}}
    <div class="card mb-3">
        <div class="my-1 mx-3">
            <small class="text-muted">
                posted on {{ date("d F Y", strtotime($resource['tweet']->created_at)) }} 
                at {{ date("H:i", strtotime($resource['tweet']->created_at)) }}
            </small>
        </div>
        <hr style="margin: auto;width:98%;">

        {{-- card-body-tweet profile USE-COMPONENT --}}
        <a href="{{ route('profile.index', ['id' => $resource['tweet']->pk_user]) }}"
           class="ml-3 mt-2">
           <x-profile :resource="$resource['tweet']"/>
        </a>
        
        {{-- card-body-tweet content --}}
        <div class="mx-3 mb-2">
            <p class="card-text py-2"
               style="margin: 0">
               {{ $resource['tweet']->content }}
            </p>
            
            <div>
                <a href="#" class="mr-4">Like</a>

                {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
                @auth
                    {{-- Collapse Form Reply --}}
                    <a  class="mr-4"
                        data-toggle="collapse" 
                        href="#tweet-{{$resource['tweet']->tweet_id}}"
                        role="button" aria-expanded="false" 
                        aria-controls="tweet-{{$resource['tweet']->tweet_id}}">
                        Reply
                    </a>
                    
                    {{-- Authorization Tweet --}}
                    @if (Gate::allows('isOwner', $resource['tweet']))
                        {{-- Collapse Form Edit --}}
                        <a  class="mr-2"
                            data-toggle="collapse" 
                            href="#edit-{{$resource['tweet']->tweet_id}}"
                            role="button" aria-expanded="false" 
                            aria-controls="edit-{{$resource['tweet']->tweet_id}}">
                            Edit
                        </a>

                        {{-- Form delete / Button Delete --}}
                        <form style="display: inline-block;" 
                            action="{{ route('tweet.delete', ['id' => $resource['tweet']->tweet_id]) }}" 
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-link" type="submit">
                                Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
            @auth
                {{-- Form collapse edit card tweet --}}
                <div class="collapse mt-2" id="edit-{{$resource['tweet']->tweet_id}}">
                    <form 
                        action="{{route('tweet.update', ['id' => $resource['tweet']->tweet_id])}}" 
                        method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <textarea class="form-control" 
                            id="content" name="content" rows="3" 
                            placeholder="Edit reply" required>{{ $resource['tweet']->content }}</textarea>
                        </div>
                        <button type="submit" 
                            class="btn btn-primary posting">
                            Update
                        </button>
                    </form>
                </div>

                {{-- Form collapse reply card tweet --}}
                <div class="collapse mt-2" id="tweet-{{$resource['tweet']->tweet_id}}">
                    <form 
                        action="{{ route('reply.store', ['id' => $resource['tweet']->tweet_id]) }}" method="POST">
                        @csrf
                        <input 
                            type="hidden" name="id" 
                            value="{{ Auth::user()->id }}"
                        >
                        
                        <div class="form-group">
                            <textarea class="form-control" 
                            id="content" name="content" rows="3" 
                            placeholder="Replying tweet" required>
                            </textarea>
                        </div>
                        <button type="submit" 
                            class="btn btn-primary posting">
                            Reply
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    {{-- IF CONTENT REPLY IS EMPTY --}}
    {{-- SHOW MESSAGE --}}
    @empty(count($resource['reply']))
        <div class="w-75 m-auto py-4">
            <div>
                <img src="{{ asset('/images/reply.svg') }}" alt="No replies"
                width="100%" height="100%" class="img-fluid">
            </div>
            <h4 class="text-center"
                style="letter-spacing: 2px;">
                No replies.
            </h4>
        </div>
    @else
        <h3 class="ml-4 mt-5">{{ count($resource['reply']) }} Reply</h3>
    @endempty

    {{-- CONTENT REPLY --}}
    @foreach ($resource['reply'] as $reply)
        {{-- card reply --}}
        <div class="card mb-3 ml-4">
            <div class="my-1 mx-3">
                <small class="text-muted">
                    replied to 
                    <a href="{{ route('profile.index', ['id' => $resource['tweet']->pk_user]) }}">
                        {{ $resource['tweet']->p_username }}
                    </a>
                    on {{ date("d F Y", strtotime($reply->created_at)) }}
                    at {{ date("H:i", strtotime($reply->created_at)) }}
                </small>
            </div>
            <hr style="margin: auto;width:98%;">

            {{-- card-body-reply profile --}}
            <a href="{{ route('profile.index', ['id' => $reply->pk_user]) }}" 
            class="ml-3 mt-2">
                <div class="row" style="color: black;">
                    <div style="display: inline-block" class="ml-3">
                        <img src="{{ asset('/images/'.$reply->p_image) }}" 
                            alt="Photo Profile" class="rounded-circle" 
                            width="50px" height="50px">
                    </div>
                    <div style="line-height: 1.3" class="col-8">
                        <p style="font-size: 18px; padding: 0;">
                            {{ $reply->name }}
                        </p>
                        <p style="font-size: 80%; padding: 0;color:#6c757d">
                            {{ $reply->p_username }}
                        </p>
                    </div>
                </div>
            </a>
            
            {{-- card-body-reply content --}}
            <div class="mx-3 mb-2">
                <p class="card-text py-2"
                style="margin: 0">
                {{ $reply->comment }}
                </p>
                
                <div>
                    <a href="#" class="mr-4">Like</a>

                    {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
                    @auth
                        {{-- Authorization Reply --}}
                        @if (Gate::allows('isOwner', $reply))
                            {{-- Collapse Form Edit --}}
                            <a  class="mr-2"
                                data-toggle="collapse" 
                                href="#edit-{{$reply->comment_id}}"
                                role="button" aria-expanded="false" 
                                aria-controls="edit-{{$reply->comment_id}}">
                                Edit
                            </a>

                            {{-- Form delete / Button Delete --}}
                            <form style="display: inline-block;" 
                                action="{{ route('reply.delete', ['id' => $reply->comment_id]) }}" 
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link" type="submit">
                                    Delete
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

                {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
                @auth
                    {{-- Form collapse edit card reply --}}
                    <div class="collapse mt-2" id="edit-{{$reply->comment_id}}">
                        <form 
                            action="{{route('reply.update', ['id' => $reply->comment_id])}}" 
                            method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <textarea class="form-control" 
                                id="content" name="content" rows="3" 
                                placeholder="Edit reply" required>{{ $reply->comment }}</textarea>
                            </div>
                            <button type="submit" 
                                class="btn btn-primary posting">
                                Update
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    @endforeach
</div>
@endsection
{{-- @php
        var_dump($resource['tweet']);
    @endphp
    <br><br>
    @php
        var_dump($resource['reply']);
        echo count($resource['reply'])
    @endphp  --}}


{{-- FEATURE POSTPONE --}}
{{-- Reply post
<a  class="mr-4"
    data-toggle="collapse" 
    href="#reply-{{$reply->comment_id}}"
    role="button" aria-expanded="false" 
    aria-controls="reply-{{$reply->comment_id}}">
    Reply
</a> --}}

{{-- Form reply
<div class="collapse mt-2" id="reply-{{$reply->comment_id}}">
<form 
    action="" method="POST">
    @csrf
    <input 
        type="hidden" name="id_profile" 
        value="{{ $reply->profile_id }}"
    >
    
    <div class="form-group">
        <textarea class="form-control" 
        id="content" name="content" rows="3" 
        placeholder="Replying tweet" required>
        </textarea>
    </div>
    <button type="submit" 
        class="btn btn-primary float-right">
        Reply
    </button>
</form>
</div> --}}