@extends('layouts.app')

@section('title', 'Member')
@section('judul', 'Member Page')

@section('content')
    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Member</h4>
                <a href="{{ route('member.create') }}" class="btn btn-success">
                    Tambah Member
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Kode</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Tgl Dibuat</th>
                                <th scope="col">HP</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $member->kode_member }}</td>
                                    <td>{{ $member->nama_members }}</td>
                                    <td>{{ $member->ttl }}</td>
                                    <td>{{ $member->hp }}</td>
                                    <td>{{ $member->alamat }}</td>
                                    <td>{{ ucfirst($member->status) }}</td>
                                    <td>
                                        <a href="{{ route('member.edit', $member->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('member.destroy', $member->id) }}" method="POST"
                                            style="display:inline-block;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                Hapus
                                            </button>
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

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin hapus?',
                    text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
