@extends('layouts.dashboardAdmin')

@section('content')
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Transaction pending</h1>
            <div class="d-sm-flex align-items-center justify-content-end mt-4">
                <form action="" method="GET">
                    <input type="text" name="cari" value="{{ old('cari')}}">
                    <input type="submit" value="cari">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Film</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->transaction->user->name }}</td>
                                <td>{{ $transaction->transaction->user->email }}</td>
                                <td>{{ $transaction->nama_film }}</td>
                                <td>{{ $transaction->total_harga ?? '' }}</td>
                                <td>{{ $transaction->status }}</td>
                                <td class="d-flex justify-content-center">
                                    <form action="{{ route('transaction.update', $transaction->transaction_id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-info">
                                            <i class="fa fa-dollar-sign"></i> Sudah Bayar
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

        {{-- {{ $transaction->links() }} --}}
    </div>
    <!-- /.container-fluid -->
@endsection
