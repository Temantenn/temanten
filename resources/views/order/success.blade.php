@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="card-title">Pembayaran Berhasil</h2>
                    <p class="mt-3 text-muted">
                        Selamat! Order <strong>{{ $order->order_number ?? '#' . $order->id }}</strong> Anda berhasil diproses.
                    </p>
                    <p class="text-muted">
                        Terima kasih sudah mempercayakan kami untuk membuat undangan pernikahan Anda.
                        Informasi selanjutnya akan dikirim melalui email.
                    </p>
                    <hr class="my-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection