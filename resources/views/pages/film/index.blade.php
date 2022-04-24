@extends('layouts.dashboardAdmin')

@section('content')
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Film</h1>
            <a href="{{ route("film.create") }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Film
            </a>
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
                            <th>ID</th>
                            <th>judul</th>
                            <th>Deskripsi</th>
                            <th>Tumbnail</th>
                            <th>Url Trailer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($films as $film)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $film->judul }}</td>
                                <td>{{ $film->deskripsi }}</td>
                                <td> <img src="{{ Storage::url($film->tumbnail) }}" alt="tumbnail" style="width: 150px" class="img-thumbnail"> </td>
                                <td>{{ $film->url_trailer }}</td>
                                <td class="{{ $film->status == 'coming soon' ? 'text-warning' : 'text-primary' }}">{{ $film->status }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('film.edit', $film->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <a href="{{ route('film.show', $film->id) }}" class="btn btn-warning">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form action="{{ route('film.destroy', $film->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')

                                        <button class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">
                                    Data Kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $films->links() }}
    </div>
    <!-- /.container-fluid -->
@endsection
