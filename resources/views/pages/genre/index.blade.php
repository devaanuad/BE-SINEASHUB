@extends('layouts.dashboardAdmin')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Genre</h1>
                    <a href="{{ route("genre.create") }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Genre
                    </a>
                </div>
            </div>
            <div class="card-body--">
                <div class="table-stats order-table ov-h">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="serial">#</th>
                                <th>Name</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($genres as $genre)
                                <tr>
                                    <td class="serial">{{ $loop->iteration }}</td>
                                    <td>  <span class="name">{{ $genre->name }}</span> </td>
                                    <td>
                                        <a href="{{ route('genre.edit',$genre->id) }}" class="btn btn-info">edit</a>
                                        <form action="{{ route('genre.destroy',$genre->id) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center h4">DATA MASIH KOSONG</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> <!-- /.table-stats -->
            </div>
        </div>
    </div>
@endsection


