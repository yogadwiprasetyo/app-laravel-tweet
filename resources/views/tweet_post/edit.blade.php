@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row align-items-center mb-2">
      <div style="display: inline-block" class="mx-3">
          <img src="{{ asset('/testing/'.$resource['profile']->p_image) }}" alt="Photo Profile" class="rounded-circle" width="50px" height="50px">
      </div>
      <div>
          <p style="font-size: 18px; padding: 0; margin: 0;">{{ Auth::user()->name }}</p>
          <small>{{ $resource['profile']->p_username }}</small>
      </div>
    </div>
    <form action="{{ route('tweet.update', ['id' => $resource['tweet']->tweet_id]) }}" method="POST">
      @csrf
      @method('PUT')
      
      <div class="form-group">
          <textarea class="form-control" id="content" name="content" rows="3" required>{{ $resource['tweet']->content }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
@endsection