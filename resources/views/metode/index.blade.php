@extends('layouts.app')

@section('title', 'Payment Methods')
@section('judul', 'Payment Methods Page')

@section('content')
    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Pembayaran</h4>
                <a href="{{ route('metode.create') }}" class="btn btn-success">
                    Tambah Metode
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">

                            <tr>
                                <th>Nama Metode</th>
                                <th>Ikon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($metodes as $metode)
                                <tr>
                                    <td>{{ $metode->nama_metode }}</td>
                                    <td>
                                        @if ($metode->ikon)
                                            <img src="{{ asset($metode->ikon) }}" width="50" alt="Ikon">
                                        @else
                                            Tidak ada ikon
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('metode.edit', $metode->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('metode.destroy', $metode->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus metode ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
