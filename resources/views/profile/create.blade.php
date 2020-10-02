@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id" value="{{ Auth::user()->id }}">

          <div class="form-group">
            <div style="width: 100px;height: 100px;margin: auto;margin-bottom: 1rem;">
              <img src="{{ asset('/images/profile.jpeg') }}" alt="profile image" 
              width="100%" height="100%" class="rounded-circle">
            </div>

            {{-- !!! PENDING FEATURES. set user image profile. --}}
            {{-- <div style="width: 200px;margin: auto;">
              <input type="file" name="profile_image" 
              id="profile_image" accept="image/*">
            </div> --}}
          </div>
  
          <div class="form-group row">
            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

            <div class="col-md-6">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" autofocus>

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
                <input id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}">

                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>

            <div class="col-md-6">
                <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="others">Others</option>
                </select>

                @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="status" class="col-md-4 col-form-label text-md-right"></label> 
            <div class="col-md-6 row ml-1" style="text-align: center;">
              <button type="submit" class="btn btn-secondary" 
              style="width: 45%;margin: 0 5px;">Next</button> 
              <button type="submit" class="btn btn-primary" 
              style="width: 45%;margin: 0 5px;">Create</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
    {{-- @php
        var_dump(Auth::user());
    @endphp --}}
@endsection