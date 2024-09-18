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
        <div class="row justify-content-center" style="margin-top: 100px;">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="w-100 text-center">
                            <p>Total Number Of Registered Users : 100</p>
                            <p>Total Number Of Generated Linke : 100</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-additional-js')
@endpush