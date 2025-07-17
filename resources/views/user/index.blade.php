@extends('layouts.app')

@section('title', 'User')
@section('judul', 'User Page')

@section('content')
    <div class="container mt-5">

        <div class="card-cafe">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0" style="color:var(--cafe-coffee);font-weight:700;">Daftar User</h4>
                <a href="{{ route('user.create') }}" class="btn-cafe">Tambah User</a>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center" style="background:var(--cafe-beige);">
                    <thead style="background:var(--cafe-khaki);color:var(--cafe-bistre);">
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->user_name }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn-cafe" style="background:var(--cafe-chamoisee);color:var(--cafe-beige);padding:0.3rem 1rem;font-size:0.95rem;">Edit</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-cafe" style="background:var(--cafe-bistre);color:var(--cafe-beige);padding:0.3rem 1rem;font-size:0.95rem;">Hapus</button>
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
