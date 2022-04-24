@extends('layouts.dashboardAdmin')

@section('content')
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit {{ $film->name }}</h1>
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
                <form action="{{route('film.update', $film->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                     <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" id="judul" placeholder="Masukkan Judul film" value="{{ $film->judul }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" placeholder="Masukkan deskirpsi film" value="{{ $film->deskripsi }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="tumbnail">Tumbnail</label>
                        <input type="file" name="tumbnail" id="tumbnail" value="{{ $film->tumbnail }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="url_trailer">Url Trailer</label>
                        <input type="text" name="url_trailer" id="url_trailer" placeholder="Masukkan url thrailer" value="{{ $film->url_trailer }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="Status">Status</label>
                        <select name="status" id="Status" class="form-control">
                            <option value="coming soon" {{ $film->status =="coming soon"  ? 'checked' : ''  }}>Coming Soon</option>
                            <option value="rilis" {{ $film->status =="rilis"  ? 'checked' : ''  }}>Rilis</option>
                        </select>
                    </div>

                    {{-- detail film --}}
                    <div class="form-group">
                        <label for="url_film">Url Film</label>
                        <input type="text" name="url_film" id="url_film" placeholder="Masukkan url film" value="{{ $film->detail->url_film }}" class="form-control">
                    </div>

                    <div class="form-group col-lg-6 col-xl-6 d-inline-block">
                        <label for="sutradara">Sutradara</label>
                        <input type="text" name="sutradara" id="sutradara" value="{{ $film->detail->sutradara }}" class="form-control">
                    </div>

                    <div class="form-group col-lg-5 col-xl-5 d-inline-block">
                        <label for="tanggal_terbit">Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="{{ $film->detail->tanggal_terbit }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" placeholder="Masukkan jumlah harga film" value="{{ $film->detail->harga }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        @foreach ($genres as $genre)
                           @foreach ($film->genres as $filmGenre)
                                @if ($genre->id == $filmGenre->id)
                                    <div class="form-check">
                                    <input class="form-check-input"
                                            name="genre_id[]"
                                            type="checkbox"
                                            value="{{$genre->id}}"
                                            id="flexCheck{{$genre->name}}"
                                            {{ $genre->id == $filmGenre->id ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="flexCheck{{$genre->name}}">
                                        {{$genre->name}}
                                    </label>
                                </div>
                                @else
                                     <div class="form-check">
                                    <input class="form-check-input"
                                            name="genre_id[]"
                                            type="checkbox"
                                            value="{{$genre->id}}"
                                            id="flexCheck{{$genre->name}}"
                                    >
                                    <label class="form-check-label" for="flexCheck{{$genre->name}}">
                                        {{$genre->name}}
                                    </label>
                                </div>
                                @endif
                           @endforeach
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Ubah</button>

                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
