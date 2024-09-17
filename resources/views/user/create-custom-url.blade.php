
@extends('user.layouts.app')

@section('main-content')
    <!-- Main content -->
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 50px;">
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

                            <div class="mb-3">
                                <label class="form-label">Is Private?</label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="privateYes" name="is_private" value="1">
                                        <label class="form-check-label" for="privateYes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="privateNo" name="is_private" value="0" checked>
                                        <label class="form-check-label" for="privateNo">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Custom Yourself?</label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="customYourselfYes" name="custom_yourself" value="1">
                                        <label class="form-check-label" for="customYourselfYes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="customYourselfNo" name="custom_yourself" value="0" checked>
                                        <label class="form-check-label" for="customYourselfNo">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" id="customUrlField">
                                <label for="custom_url" class="form-label">Custom URL:</label>
                                <input type="text" class="form-control" id="custom_url" name="custom_url" placeholder="Enter custom URL">
                            </div>

                            <div class="mb-3">
                                <label for="expires_after" class="form-label">Expires After (hours):</label>
                                <input type="number" class="form-control" id="expires_after" name="expires_after" value="6" min="1" required>
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

@push('footer-additional-js')
    <script>
        $(document).ready(function() {
            $('input[name="custom_yourself"]').on('change', function() {
                if ($('#customYourselfYes').is(':checked')) {
                    $('#customUrlField').show();
                } else {
                    $('#customUrlField').hide();
                }
            });

            // Initial check
            if ($('#customYourselfYes').is(':checked')) {
                $('#customUrlField').show();
            } else {
                $('#customUrlField').hide();
            }
        });
    </script>
@endpush