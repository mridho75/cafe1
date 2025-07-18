@extends('layouts.app')

@section('title', 'Daftar - Transaksi')
@section('judul', 'Daftar Transaksi Page')

@section('content')
    <div class="container mt-5">

        <style>
            .order-card {
                background: #fff;
                box-shadow: 0 8px 32px 0 rgba(61,33,26,0.13);
                border-radius: 1.25rem;
                border: 1.5px solid #CBB799;
                padding: 2rem 1.5rem;
            }
            .order-header {
                color: #3D211A;
                font-weight: 800;
                letter-spacing: 0.5px;
            }
            .order-btn-add {
                background: #A07856;
                color: #fff;
                font-weight: 600;
                border-radius: 0.75rem;
                padding: 0.5rem 1.5rem;
                box-shadow: 0 2px 8px #A0785611;
                transition: background 0.18s;
            }
            .order-btn-add:hover {
                background: #7a5a3a;
            }
        </style>
        <div class="card order-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 order-header">Daftar Transaksi</h4>
                <a href="{{ route('kasir.create_order') }}" class="btn order-btn-add">Tambah Order</a>
            </div>
            <div class="table-responsive" id="table-container">
                @include('order._table')
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
