@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <form action="{{ route('profile.update', ['id' => Auth::user()->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- !!! PENDING FEATURES. update user image profile. --}}
        {{-- <div class="form-group row">
          <label for="name" class="col-md-4 col-form-label text-md-right">Image Profile</label>

          <div class="col-md-6">
            <input type="file" name="profile_image" id="profile_image" accept="image/*">
          </div>
        </div> --}}

        <div class="form-group row">
          <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

          <div class="col-md-6">
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}">

              @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
        </div>

        <div class="form-group row">
          <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

          <div class="col-md-6">
              <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $profile->p_username }}">

              @error('username')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
        </div>
        
        <div class="form-group row">
          <label for="status" class="col-md-4 col-form-label text-md-right">Description</label>

          <div class="col-md-6">
              <input id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ $profile->p_status }}">

              @error('status')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
        </div>

        <div class="form-group row">
          <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

          <div class="col-md-6">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}">

              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
        </div>

        <div class="form-group row">
          <label for="email" class="col-md-4 col-form-label text-md-right"></label>

          <div class="col-md-6">
            <button class="btn btn-primary posting" type="submit">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection