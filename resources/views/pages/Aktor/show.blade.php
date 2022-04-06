@extends('layouts.dashboardAdmin')

@section('content')
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Film</h1>
        </div>

        {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <form action="" method="GET">
            <input type="text" name="cari" value="{{ old('cari')}}">
            <input type="submit" value="cari">
            </form>
        </div> --}}

        <div class="row">
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Url Film</th>
                            <th>Rating</th>
                            <th>Tahun</th>
                            <th>Tanggal Terbit</th>
                            <th>Harga</th>
                            <th>Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $film->url_film }}</td>
                            <td>{{ $film->rating }}</td>
                            <td>{{ $film->tahun }}</td>
                            <td>{{ $film->tanggal_terbit }}</td>
                            <td>{{ $film->harga }}</td>
                            <td>{{ $film->kunjungan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
