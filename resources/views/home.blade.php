@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0"> 
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-light vh-100 p-3">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h3 >Welcome, <strong class="mb-3 text-primary">{{ Auth::user()->name }}</strong> </h3>
                    <p class="fs-5">
                        Your role: 
                        <span class="badge bg-success">{{ ucfirst(Auth::user()->role) }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

