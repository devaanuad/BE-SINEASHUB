@extends('layouts.dashboardAdmin')

@section('content')
    <div class="content">

    <form action="{{ route('genre.update',$genre->id) }}" method="post">
        @method('put')
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
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" class="form-control" name="name" value="{{ $genre->name }}" placeholder="Teuku FUad Maulana">
        </div>

        <div class="mb-3">
            <button class="btn btn-info form-control">Ubah</button>
        </div>
    </form>

    </div>
@endsection
