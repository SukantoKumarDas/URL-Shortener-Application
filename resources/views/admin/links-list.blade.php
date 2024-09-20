@extends('admin.layouts.app')

@push('header-additional-css')
<style>
    p {
        margin: 0px;
    }
</style>
@endpush

@section('main-content')
<!-- Main content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow" style="margin-top: 100px;">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">List of Links</h3>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Original Link</th>
                                    <th scope="col">Shortened Link</th>
                                    <th scope="col">Is Private</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($links as $link)
                                <tr>
                                    <td><a href="{{ $link->original_url }}" target="_blank">{{ $link->original_url }}</a></td>
                                    <td><a href="{{ url($link->shortened_alias) }}" target="_blank">{{ url($link->shortened_alias) }}</a></td>
                                    <td>{{ $link->is_private ? 'Yes' : 'No' }}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($links->isEmpty())
                        <p class="text-center">No links available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-additional-js')
@endpush