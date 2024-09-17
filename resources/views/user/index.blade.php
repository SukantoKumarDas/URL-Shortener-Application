
@extends('user.layouts.app')

@push('footer-additional-js')
@endpush

@section('main-content')
    <!-- Main content -->
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 250px;">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">URL Shortener</h3>
                        @if(session('shortened_url'))
                            <div class="alert alert-success">
                                Shortened URL: <a href="{{ session('shortened_url') }}">{{ session('shortened_url') }}</a>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('shorten-url') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="url" class="form-label">Enter URL:</label>
                                <input type="url" class="form-control" id="url" name="url" placeholder="Enter your URL" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Shorten URL</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('header-additional-css')
@endpush
