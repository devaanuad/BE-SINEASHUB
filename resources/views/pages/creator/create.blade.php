@extends('layouts.dashboardAdmin')

@section('content')
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Data Creator</h1>
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
                <form action="{{route('creator.store')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="Sutradara">Sutradara</label>
                        <input type="text" name="sutradara" id="Sutradara" placeholder="Masukkan nama Sutradara" value="{{ old('Sutradara') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input type="text" name="penulis" id="penulis" placeholder="Masukkan nama penulis" value="{{ old('penulis') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="perusahaan_produksi">Perusahaan Produksi</label>
                        <input type="text" name="perusahaan_produksi" id="perusahaan_produksi" placeholder="Masukkan nama perusahan produksi" value="{{ old('perusahaan_produksi') }}" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>

                </form>
            </div>
        </div>
    </div>
@endsection
