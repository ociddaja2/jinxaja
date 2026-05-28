@extends('layouts.app')

@section('header', 'Edit Loan')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pinjamans.update', $pinjaman->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="book_id" class="form-label">Book</label>
                        <select class="form-select @error('book_id') is-invalid @enderror" id="book_id" name="book_id"
                            required>
                            <option value="">Select Book</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}"
                                    {{ old('book_id', $pinjaman->book_id) == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}</option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="member_id" class="form-label">Member</label>
                        <select class="form-select @error('member_id') is-invalid @enderror" id="member_id" name="member_id"
                            required>
                            <option value="">Select Member</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id', $pinjaman->member_id) == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}</option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="borrow_date" class="form-label">Borrow Date</label>
                        <input type="date" class="form-control @error('borrow_date') is-invalid @enderror"
                            id="borrow_date" name="borrow_date" value="{{ old('borrow_date', $pinjaman->borrow_date) }}"
                            required>
                        @error('borrow_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="return_date" class="form-label">Return Date</label>
                        <input type="date" class="form-control @error('return_date') is-invalid @enderror"
                            id="return_date" name="return_date" value="{{ old('return_date', $pinjaman->return_date) }}">
                        @error('return_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pinjamans.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update Loan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
