@extends('layouts.dashboardAdmin')

@section('content')
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Data Aktor</h1>
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
                <form action="{{route('aktor.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="Film">Film</label>
                        <select name="film_id" id="Film" class="form-control">
                            <option value="">Pilih Film</option>
                            @foreach ($films as $film)
                                <option value="{{$film->id}}">{{$film->judul}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" placeholder="Masukkan nama Aktor" value="{{ old('nama') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="gambar">Foto</label>
                        <input type="file" name="gambar" id="gambar" value="{{ old('gambar') }}" class="form-control">
                    </div>


                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>

                </form>
            </div>
        </div>
    </div>
@endsection
