
@extends('user.layouts.app')

@section('main-content')
    <!-- Main content -->
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 50px;">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">URL Shortener</h3>
                        
                        <!-- Place to display the shortened URL -->
                        <div id="shortenedUrlResult"></div>

                        <form id="urlShortenerForm">
                            @csrf
                            <div class="mb-3">
                                <label for="url" class="form-label">Enter URL <span class="text-muted">( url to be shortened )</span>:</label>
                                <input type="url" class="form-control" id="url" name="url" placeholder="Enter your URL" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Is Private? <span class="text-muted">( only you can access )</span></label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="privateYes" name="is_private" value="1">
                                        <label class="form-check-label" for="privateYes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="privateNo" name="is_private" value="0" checked>
                                        <label class="form-check-label" for="privateNo">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Custom Yourself?</label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="customYourselfYes" name="custom_yourself" value="1">
                                        <label class="form-check-label" for="customYourselfYes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="customYourselfNo" name="custom_yourself" value="0" checked>
                                        <label class="form-check-label" for="customYourselfNo">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" id="customUrlField" style="display: none;">
                                <label for="custom_alias" class="form-label">Custom URL:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="baseUrlSpan">base_url</span>
                                    <input type="text" class="form-control" id="custom_alias" name="custom_alias" placeholder="Enter custom URL">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                </div>
                                <div id="urlError" class="text-danger mt-2"></div>
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
            var baseUrl = window.location.origin;
            $('#baseUrlSpan').text(baseUrl);

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
            $('#urlError').text('input the custom url');
            // check if the customurl is available or not
            $('#custom_alias').on('blur', function() {  
                var customAlias = $(this).val();
                if (customAlias) {
                    $.ajax({
                        url: '/check-url-available',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            custom_alias: customAlias
                        },
                        success: function(response) {
                            if (response.valid) {
                                $('#urlError').text('');
                            } else {
                                $('#urlError').text('URL not available'); 
                            }
                        },
                        error: function() {
                            $('#urlError').text('An error occurred while checking the URL');
                        }
                    });
                } else {
                    $('#urlError').text('Iinput the custom url');
                }
            });

            // Handle form submission via AJAX
            $('#urlShortenerForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous results
                $('#shortenedUrlResult').html('');
                $('#urlError').html('');

                // Gather form data
                var formData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    url: $('#url').val(),
                    is_private: $('input[name="is_private"]:checked').val(),
                    custom_alias: $('#custom_alias').val(),
                    expires_after: $('#expires_after').val()
                };

                // AJAX request to create the shortened URL
                $.ajax({
                    url: '{{ route("create-custom-url") }}', // Ensure the route is correctly set in your web.php
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        $('#shortenedUrlResult').html(`
                            <div class="alert alert-success">
                                Shortened URL: <a href="${response.shortened_url}" target="_blank">${response.shortened_url}</a>
                            </div>
                        `);
                    },
                    error: function(xhr) {
                        // Handle validation errors or other server errors
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.custom_alias) {
                                $('#urlError').text(errors.custom_alias[0]);
                            }
                        } else {
                            $('#shortenedUrlResult').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                        }
                    }
                });
            });
        });
    </script>
@endpush