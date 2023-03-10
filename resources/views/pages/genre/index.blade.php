@extends('layouts.dashboardAdmin')

@section('content')
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Genre</h1>
            <a href="{{ route("genre.create") }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Genre
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
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($genres as $genre)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $genre->name }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('genre.edit', $genre->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('genre.destroy', $genre->id) }}" method="post" class="d-inline">
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
                                <td class="text-center" colspan="5">
                                    Data Kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
