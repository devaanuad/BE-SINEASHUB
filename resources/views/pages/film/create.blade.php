@extends('layouts.dashboardAdmin')

@section('content')
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Data Film</h1>
        </div>


    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif

        <div class="card">
            <div class="card-body">
                <form action="{{route('genre.store')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Judul</label>
                        <input type="text" name="name" id="name" placeholder="Masukkan nama pasien" value="{{ old('name') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" placeholder="Masukkan nama pasien" value="{{ old('deskripsi') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="tumbnail">Tumbnail</label>
                        <input type="file" name="tumbnail" id="tumbnail" placeholder="Masukkan nama pasien" value="{{ old('tumbnail') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="url_trailer">Url Trailer</label>
                        <input type="file" name="url_trailer" id="url_trailer" placeholder="Masukkan nama pasien" value="{{ old('url_trailer') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="Status">Url Status</label>
                        <select name="status" id="Status">
                            <option value="coming soon">Coming Soon</option>
                            <option value="rilis">Rilis</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>

                </form>
            </div>
        </div>
    </div>
@endsection
