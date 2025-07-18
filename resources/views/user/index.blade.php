@extends('layouts.app')

@section('title', 'User')
@section('judul', 'User Page')

@section('content')
    <div class="container mt-5">
        <div class="card" style="background:#fff;box-shadow:0 6px 24px 0 rgba(61,33,26,0.12);border-radius:1.25rem;padding:2rem 1.5rem;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0" style="color:#3D211A;font-weight:800;">Daftar User</h4>
                <a href="{{ route('user.create') }}" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.75rem;padding:0.5rem 1.5rem;">Tambah User</a>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center" style="background:#F5F5DC;border-radius:1rem;overflow:hidden;">
                    <thead style="background:#CBB799;color:#3D211A;font-weight:700;">
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td style="color:#3D211A;font-weight:600;">{{ $user->user_name }}</td>
                                <td style="color:#3D211A;">{{ $user->role }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.5rem;padding:0.3rem 1rem;font-size:0.95rem;">Edit</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn" style="background:#3D211A;color:#fff;font-weight:600;border-radius:0.5rem;padding:0.3rem 1rem;font-size:0.95rem;">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Tangkap semua form dengan class 'delete-form'
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Cegah submit langsung

                Swal.fire({
                    title: 'Yakin ingin menghapus menu ini?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user konfirmasi, submit form secara manual
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
