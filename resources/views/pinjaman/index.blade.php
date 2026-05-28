@extends('layouts.app')

@section('header', 'Loan Records')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Loan History</h5>
            <a href="{{ route('pinjamans.create') }}" class="btn btn-primary btn-sm">New Loan</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Book</th>
                        <th>Member</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pinjamans as $pinjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pinjaman->book->title ?? 'N/A' }}</td>
                            <td>{{ $pinjaman->member->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pinjaman->borrow_date)->format('d M Y') }}</td>
                            <td>{{ $pinjaman->return_date ? \Carbon\Carbon::parse($pinjaman->return_date)->format('d M Y') : '-' }}
                            </td>
                            <td>
                                @if ($pinjaman->return_date)
                                    <span class="badge bg-success">Returned</span>
                                @else
                                    <span class="badge bg-warning">Borrowed</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pinjamans.edit', $pinjaman->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pinjamans.destroy', $pinjaman->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No loan records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
