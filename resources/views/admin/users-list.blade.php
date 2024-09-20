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
                    <h3 class="card-title text-center mb-4">List of Users</h3>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nmae</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($users->isEmpty())
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