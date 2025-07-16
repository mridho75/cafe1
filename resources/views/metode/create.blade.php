@extends('layouts.app')

@section('title', 'Metode - Create')
@section('judul', 'Metode Create Page')

@section('content')
<div class="container-fluid mt-6">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Create Metode</h3>
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

                    <form method="POST" action="{{ route('metode.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_metode">Nama Metode</label>
                            <input type="text" class="form-control" id="nama_metode" name="nama_metode" value="{{ old('nama_metode') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="ikon">Ikon (Opsional)</label>
                            <input type="file" class="form-control" id="ikon" name="ikon" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('metode.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
