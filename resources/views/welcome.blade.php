@extends('layouts.app')

@section('header', 'Library Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Books</h6>
                            <h2 class="mb-0">{{ $stats['books'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-book fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="{{ route('books.index') }}">View Details</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Members</h6>
                            <h2 class="mb-0">{{ $stats['members'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="{{ route('members.index') }}">View Details</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Active Loans</h6>
                            <h2 class="mb-0">{{ $stats['loans'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-hand-holding fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-dark stretched-link" href="{{ route('pinjamans.index') }}">View Details</a>
                    <div class="text-dark"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Authors</h6>
                            <h2 class="mb-0">{{ $stats['authors'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-user-edit fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="{{ route('authors.index') }}">View Details</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Recent Activities</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">Welcome to the Jinx Library Management System. Use the sidebar to manage books, members,
                and tracking loans.</p>
        </div>
    </div>
@endsection
