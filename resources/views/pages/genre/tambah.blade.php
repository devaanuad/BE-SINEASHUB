@extends('layouts.dashboardAdmin')

@section('content')
    <div class="content">

        <form action="{{ route('genre.store') }}" method="post">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="nama" class="form-label">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}"
                    placeholder="Action">
            </div>
            <div class="mb-3">
                <button class="btn btn-info form-control">Tambah</button>
            </div>
        </form>

    </div>
@endsection
