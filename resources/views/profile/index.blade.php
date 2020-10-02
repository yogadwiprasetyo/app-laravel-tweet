@extends('layouts.app')

@section('content')

<div class="container">
    <section>
        {{-- ALERT SUCCESS --}}
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        
        {{-- PROFILE --}}
        <div class="row">
            <div class="col-md-8">
                <div class="row mt-2" style="color: black;">
                    <div style="display: inline-block" class="ml-3">
                        <img src="{{ asset('/images/'.$resource['profile']->p_image) }}" 
                            alt="Photo Profile" class="rounded-circle" 
                            width="80px" height="80px">
                    </div>
                    <div style="line-height: 1.5" class="col-8">
                        <p style="font-size: 1.2rem; padding: 0; margin: 0;">
                            {{ $resource['profile']->name }}
                        </p>
                        <p style="font-size: 1rem; padding: 0; margin: 0;color:#6c757d">
                            {{ $resource['profile']->p_username }}
                        </p>
                    </div>
                </div>
                <div class="description pt-2">
                    <p>{{ $resource['profile']->p_status }}</p>
                </div>
            </div>

            {{-- Authorization Profile --}}
            @if (Gate::allows('isOwner', $resource['profile']))
                {{-- Link to Change password and Edit profile --}}
                <div class="py-3 col-md-4">
                    <div class="mb-2">
                        <a  href="{{ route('profile.change', ['id' => Auth::user()->id]) }}" 
                            class="btn btn-secondary posting">
                            Change Password
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('profile.edit', ['id' => $resource['profile']->pk_user]) }}" 
                            class="btn btn-primary posting">
                            Edit profile
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

<hr>

<div class="container">
    {{-- TWEET --}}
    <section class="py-3">
        <h2 class="mt-2 mb-4 text-center title-tweet">
            Tweet
        </h2>

        {{-- IF TWEET IS EMPTY --}}
        {{-- SHOW POSTING TWEET IS OWNER AND SHOW MESSAGE IS NOT OWNER --}}
        @empty(count($resource['tweet']))

            {{-- Authorization Tweet --}}
            @if (Gate::allows('isOwner', $resource['profile']))
                {{-- POSTING TWEET  --}}
                <form action="{{ route('tweet.store') }}" method="POST">
                    @csrf
                    <input 
                        type="hidden" 
                        name="id_user" 
                        value="{{ Auth::user()->id }}"
                    >
                    <div class="form-group">
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                            id="content" name="content" rows="3" 
                            placeholder="What's on your mind ?" required>
                        </textarea>
                        @error('content')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-custom posting">
                        Posting
                    </button>
                </form>

            @else
                {{-- MESSAGE --}}
                <div class="w-75 m-auto">
                    <div class="my-4">
                        <img src="{{ asset('/images/posting.svg') }}" alt="No post"
                        width="100%" height="100%" class="img-fluid">
                    </div>
                    <h4 class="text-center"
                        style="letter-spacing: 2px;">
                        The user hasn't posted yet.
                    </h4>
                </div>
            @endif
        @endempty

        {{-- ALL TWEET FROM THIS OWNER --}}
        <div class="row">
            @foreach ($resource['tweet'] as $tweet)
                <div class="col-sm-12 col-md-6">
                    {{-- card tweet --}}
                    <div class="card mb-3">
                        <div class="my-1 mx-3">
                            <small class="text-muted">
                                posted on {{ date("d F Y", strtotime($tweet->created_at)) }} 
                                at {{ date("H:i", strtotime($tweet->created_at)) }}
                            </small>
                        </div>
                        <hr style="margin: auto;width:98%;">

                        {{-- card-body-tweet profile USE-COMPONENT --}}
                        <div class="ml-3 mt-2">
                            <x-profile :resource="$resource['profile']"/>
                        </div>
                        
                        {{-- card-body-tweet content --}}
                        <div class="mx-3 mb-2">
                            <p class="card-text py-2"
                               style="margin: 0">
                               {{ $tweet->content }}
                            </p>
                            
                            <div>
                                <a href="#" class="mr-4">Like</a>

                                {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
                                @auth
                                    {{-- Collapse Form Reply --}}
                                    <a  class="mr-4"
                                        data-toggle="collapse" 
                                        href="#tweet-{{$tweet->tweet_id}}"
                                        role="button" aria-expanded="false" 
                                        aria-controls="tweet-{{$tweet->tweet_id}}">
                                        Reply
                                    </a>
                                    
                                    {{-- Authorization Tweet --}}
                                    @if (Gate::allows('isOwner', $tweet))
                                        {{-- Collapse Form Edit --}}
                                        <a  class="mr-2"
                                            data-toggle="collapse" 
                                            href="#edit-{{$tweet->tweet_id}}"
                                            role="button" aria-expanded="false" 
                                            aria-controls="edit-{{$tweet->tweet_id}}">
                                            Edit
                                        </a>

                                        {{-- Form delete / Button Delete --}}
                                        <form style="display: inline-block;" 
                                            action="{{ route('tweet.delete', ['id' => $tweet->tweet_id]) }}" 
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-link" type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth

                                {{-- Show detail tweet --}}
                                <a href="{{ route('tweet.show', ['id' => $tweet->tweet_id]) }}">
                                    Show
                                </a>
                            </div>

                            {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
                            @auth
                                {{-- Form collapse edit card tweet --}}
                                <div class="collapse mt-2" id="edit-{{$tweet->tweet_id}}">
                                    <form 
                                        action="{{route('tweet.update', ['id' => $tweet->tweet_id])}}" 
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="form-group">
                                            <textarea class="form-control" 
                                            id="content" name="content" rows="3" 
                                            placeholder="Edit reply" required>{{ $tweet->content }}</textarea>
                                        </div>
                                        <button type="submit" 
                                            class="btn btn-primary posting">
                                            Update
                                        </button>
                                    </form>
                                </div>

                                {{-- Form collapse reply card tweet --}}
                                <div class="collapse mt-2" id="tweet-{{$tweet->tweet_id}}">
                                    <form 
                                        action="{{ route('reply.store', ['id' => $tweet->tweet_id]) }}" method="POST">
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
                </div>
            @endforeach
        </div>
    </section>
</div>
{{-- @php
    var_dump($resource['profile']);
@endphp
<br><br>
@php
    var_dump($resource['tweet']);
@endphp --}}
@endsection