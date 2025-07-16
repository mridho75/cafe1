@extends('layouts.app')

@section('title', 'Edit Metode Pembayaran')
@section('judul', 'Edit Metode Pembayaran Page')

@section('content')
<div class="container-fluid mt-6">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Edit Metode Pembayaran</h3>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('metode.update', $metode->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_metode">Nama Metode</label>
                            <input type="text" class="form-control" id="nama_metode" name="nama_metode" value="{{ old('nama_metode', $metode->nama_metode) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="ikon">Ganti Ikon</label><br>
                            @if($metode->ikon)
                                <img src="{{ asset($metode->ikon) }}" width="70" class="mb-2" alt="Ikon Saat Ini"><br>
                            @endif
                            <input type="file" class="form-control" id="ikon" name="ikon" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('metode.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
