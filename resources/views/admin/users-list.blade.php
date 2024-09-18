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
        <div class="col-md-4">
            <div class="card shadow" style="margin-top: 150px;">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">List of Users</h3>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-additional-js')
@endpush