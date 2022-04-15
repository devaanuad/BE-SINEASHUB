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
                <form action="{{route('film.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" id="judul" placeholder="Masukkan Judul film" value="{{ old('judul') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" placeholder="Masukkan deskirpsi film" value="{{ old('deskripsi') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="tumbnail">Tumbnail</label>
                        <input type="file" name="tumbnail" id="tumbnail" value="{{ old('tumbnail') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="url_trailer">Url Trailer</label>
                        <input type="text" name="url_trailer" id="url_trailer" placeholder="Masukkan url thrailer" value="{{ old('url_trailer') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="Status">Status</label>
                        <select name="status" id="Status" class="form-control">
                            <option value="coming soon">Coming Soon</option>
                            <option value="rilis">Rilis</option>
                        </select>
                    </div>

                    {{-- detail film --}}
                    <div class="form-group">
                        <label for="url_film">Url Film</label>
                        <input type="text" name="url_film" id="url_film" placeholder="Masukkan url film" value="{{ old('url_film') }}" class="form-control">
                    </div>
                    {{-- <div class="form-group col-lg-5 col-xl-5 d-inline-block">
                        <label for="tahun">Tahun</label>
                        <input type="date" name="tahun" id="tahun" value="{{ old('tahun') }}" class="form-control">
                    </div> --}}
                    <div class="form-group">
                        <label for="tanggal_terbit">Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="{{ old('tanggal_terbit') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" placeholder="Masukkan jumlah harga film" value="{{ old('harga') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        @foreach ($genres as $genre)
                            <div class="form-check">
                                <input class="form-check-input" name="genre_id[]" type="checkbox" value="{{$genre->id}}" id="flexCheck{{$genre->name}}">
                                <label class="form-check-label" for="flexCheck{{$genre->name}}">
                                    {{$genre->name}} checkbox
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>

                </form>
            </div>
        </div>
    </div>
@endsection
