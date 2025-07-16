@extends('layouts.app')

@section('title', 'Daftar - Transaksi')
@section('judul', 'Daftar Transaksi Page')

@section('content')
    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Transaksi</h4>
                <a href="{{ route('kasir.create_order') }}" class="btn btn-success">
                    Tambah Order
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive" id="table-container">
                    @include('order._table')

                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                if (e.target.closest('.pagination a')) {
                    e.preventDefault();
                    const url = e.target.closest('a').getAttribute('href');

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            document.querySelector('#table-container').innerHTML = html;
                            window.history.pushState({}, '', url); // optional: update URL
                        })
                        .catch(err => console.error(err));
                }
            });
        });
    </script>
@endsection
