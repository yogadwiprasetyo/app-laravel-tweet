@extends('layouts.app')

@section('content')

<div class="container">
    {{-- ALERT SUCCESS --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
    @auth
        <div>
            {{-- PROFILE USER LOGIN --}}
            <div class="row" style="color: black;">
                <div style="display: inline-block" class="ml-3">
                    <img src="{{ asset('/images/'.$resource['profile']->p_image) }}" 
                        alt="Photo Profile" class="rounded-circle" 
                        width="50px" height="50px">
                </div>
                <div style="line-height: 1.3" class="col-8">
                    <p style="font-size: 18px; padding: 0;">
                        {{ Auth::user()->name }}
                    </p>
                    <p style="font-size: 80%; padding: 0;color:#6c757d">
                        {{ $resource['profile']->p_username }}
                    </p>
                </div>
            </div>

            {{-- POSTING TWEET --}}
            <form class="mt-3" action="{{ route('tweet.store') }}" method="POST">
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
        </div>
    @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h3>
                <a href="{{ route('register') }}" 
                   style="color: #1d643b; font-weight: bold; text-decoration: underline;">
                   register
                </a> 
                account to get more access.
            </h3>
        </div>
    @endauth

    {{-- ALL TWEET --}}
    <section class="pt-5 mt-3">
        {{-- Title --}}
        <h1 class="h1 text-center mb-4 title-tweet">Tweet</h1>

        {{-- Content --}}
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
                        <a href="{{ route('profile.index', ['id' => $tweet->pk_user]) }}" 
                           class="ml-3 mt-2">
                            <x-profile :resource="$tweet"/>
                        </a>
                        
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
