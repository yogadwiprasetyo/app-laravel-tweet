@extends('layouts.app')

@section('content')
<div class="container">
  @if ($errors->any())
    <div class="alert alert-danger">
      {{ $errors }}
    </div>
  @endif

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Change Password') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('profile.password', ['id' => Auth::user()->id]) }}">
            @csrf

            <div class="form-group row">
              <label for="password1" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

              <div class="col-md-6">
                <input id="password1" type="password" class="form-control @error('password1') is-invalid @enderror" name="password1" required>

                @error('password1')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password2" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

              <div class="col-md-6">
                <input id="password2" type="password" class="form-control @error('password2') is-invalid @enderror" name="password2" required>

                @error('password2')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-warning">
                  {{ __('Change') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection