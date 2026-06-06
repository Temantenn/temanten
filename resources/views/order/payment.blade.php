<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Payment - Temanten</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-[#f8fafc] dark:bg-gray-950">
    <div class="min-h-[100dvh] w-full flex flex-col justify-start md:justify-center items-center py-12 md:py-16 px-4" x-data="paymentTimer('{{ $order->expired_at->toIso8601String() }}')">
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-indigo-100/30 via-transparent to-pink-100/30 dark:from-indigo-900/10 dark:to-pink-900/10"></div>

        <div class="w-full max-w-[360px] md:max-w-3xl mx-auto animate-in fade-in zoom-in duration-500">
            <div class="bg-white dark:bg-gray-900 rounded-[2rem] shadow-[0_15px_40px_rgba(79,70,229,0.08)] dark:shadow-none border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col md:flex-row relative">
                
                <div class="w-full md:w-1/2 p-6 md:p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-800 z-10">
                    <div>
                        <div class="pb-4 md:pb-6 border-b md:border-b border-gray-50 dark:border-gray-800/50 mb-4 md:mb-6 flex flex-col md:items-start items-center">
                            <h2 class="text-2xl font-black tracking-tighter text-indigo-600 dark:text-indigo-400 leading-none">TEMANTEN<span class="text-pink-500">.</span></h2>
                            <p class="text-[9px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-1.5 px-0.5">Official Payment Gateway</p>
                        </div>

                        <div class="md:hidden flex flex-col items-center justify-center w-full">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 mt-1">Total Tagihan</span>
                            <div class="text-4xl font-black text-indigo-600 dark:text-white tracking-tighter">
                                <span class="text-sm opacity-40 font-bold mr-0.5">Rp</span>{{ number_format($order->total_amount, 0, ',', '.') }}
                            </div>
                            <div class="mt-2 text-[10px] font-bold text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 px-3 py-1 rounded-full border border-gray-100 dark:border-gray-700">Order ID: <span class="text-indigo-500">#{{ substr($order->order_number, -8) }}</span></div>
                        </div>

                        <div class="hidden md:block">
                            <div class="mb-6 rounded-2xl border border-indigo-100 dark:border-indigo-900/40 bg-gradient-to-br from-indigo-50 via-white to-pink-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-pink-950/20 p-4 shadow-sm">
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status Pembayaran</span>
                                        <p class="text-base font-black text-gray-900 dark:text-white mt-1">Menunggu Pembayaran</p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/80 dark:bg-gray-800 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-pink-500 animate-pulse"></span>
                                        QRIS Aktif
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <div class="rounded-xl bg-white/75 dark:bg-gray-800/70 border border-white dark:border-gray-700 p-3">
                                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Order ID</span>
                                        <span class="font-black text-gray-800 dark:text-gray-200">#{{ substr($order->order_number, -8) }}</span>
                                    </div>
                                    <div class="rounded-xl bg-white/75 dark:bg-gray-800/70 border border-white dark:border-gray-700 p-3">
                                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Metode</span>
                                        <span class="font-black text-gray-800 dark:text-gray-200">QRIS</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-5 mb-6">
                                <div class="flex justify-between items-center">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Detail Pesanan</span>
                                        <span class="text-sm font-black text-gray-800 dark:text-gray-200 mt-0.5">{{ $order->theme->name }}</span>
                                    </div>
                                    <div class="bg-indigo-50 dark:bg-indigo-900/30 px-2.5 py-1 rounded text-[9px] font-bold text-indigo-600 dark:text-indigo-400 uppercase">Premium</div>
                                </div>
                            </div>

                            <div class="space-y-3 mb-8 rounded-2xl bg-gray-50/80 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 p-4">
                                <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                                    <span class="text-gray-400">Harga Layanan</span>
                                    <span class="text-gray-500 line-through">Rp {{ number_format($order->theme->effective_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs font-bold uppercase tracking-tight">
                                    <span class="text-indigo-600 dark:text-indigo-400">Promo Spesial</span>
                                    <span class="text-pink-500 font-black">-Rp {{ number_format($order->unique_code, 0, ',', '.') }}</span>
                                </div>
                                <div class="pt-3 flex justify-between items-end border-t border-dashed border-gray-200 dark:border-gray-700">
                                    <span class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1.5">Total Akhir</span>
                                    <div class="text-3xl font-black text-indigo-600 dark:text-white tracking-tighter">
                                        <span class="text-sm opacity-40 font-bold mr-0.5">Rp</span>{{ number_format($order->total_amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:block space-y-3 mt-auto">
                        @php
                            $waNumber = env('ADMIN_WHATSAPP', '628123456789');
                            $waMessage = "Konfirmasi Pembayaran TEMANTEN\nOrder: {$order->order_number}\nNominal: Rp " . number_format($order->total_amount, 0, ',', '.') . "\nPromo Spesial: -Rp {$order->unique_code}\n\nTerima kasih!";
                            $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);
                        @endphp
                        
                        <a href="{{ $waLink }}" target="_blank" 
                           class="flex items-center justify-center gap-2 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-100 dark:shadow-none active:scale-95 group">
                            <span class="text-sm">Konfirmasi via WA</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>

                        <a href="{{ route('home') }}" 
                           class="flex items-center justify-center w-full text-gray-400 hover:text-indigo-600 font-bold py-2 text-[10px] uppercase tracking-widest transition-colors duration-300">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>

                <div class="w-full md:w-1/2 p-6 md:p-8 flex flex-col items-center justify-center bg-gray-50/50 dark:bg-gray-800/30">
                    <div class="mb-6 md:mb-8 w-full flex flex-col items-center select-none">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 text-center">Selesaikan Pembayaran Dalam</span>
                        <div class="flex items-center gap-2 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700/50 px-4 py-2 rounded-xl shadow-sm">
                            <div class="w-2 h-2 rounded-full bg-pink-500 animate-pulse"></div>
                            <span class="text-xl font-mono font-black text-indigo-600 dark:text-indigo-400 tracking-wider">
                                <span x-text="hours">00</span>:<span x-text="minutes">00</span>:<span x-text="seconds">00</span>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-center mb-6 md:mb-8 w-full group select-none">
                        <div class="relative p-2.5 bg-white rounded-2xl border-2 border-indigo-50/50 dark:border-gray-700 shadow-xl shadow-indigo-50 dark:shadow-none hover:scale-[1.02] transition-transform duration-300">
                            <div class="absolute inset-x-0 h-1 bg-indigo-500/50 top-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-t-xl" style="animation: scan 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;"></div>
                            
                            <div id="qris-svg-container" class="relative bg-white rounded-xl overflow-hidden p-1.5 flex align-center justify-center">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->margin(0)->color(31, 41, 55)->generate($order->dynamic_qris) !!}
                            </div>
                        </div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="h-4 md:h-5 mt-5 md:mt-6 opacity-80 mix-blend-multiply dark:mix-blend-normal">
                        
                        <button onclick="downloadQR()" type="button" class="mt-5 flex items-center justify-center gap-1.5 w-full max-w-[160px] bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 font-bold py-2 rounded-xl transition-all duration-300 shadow-sm active:scale-95 group focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            <svg class="w-3.5 h-3.5 text-indigo-500 transform group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            <span class="text-[10px] uppercase tracking-widest mt-0.5">Simpan QRIS</span>
                        </button>
                    </div>

                    <div class="w-full mb-4 grid grid-cols-3 gap-2 text-center">
                        <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 p-2">
                            <span class="block text-[8px] font-black uppercase tracking-widest text-gray-400">Step 1</span>
                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300">Scan</span>
                        </div>
                        <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 p-2">
                            <span class="block text-[8px] font-black uppercase tracking-widest text-gray-400">Step 2</span>
                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300">Bayar Tepat</span>
                        </div>
                        <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 p-2">
                            <span class="block text-[8px] font-black uppercase tracking-widest text-gray-400">Step 3</span>
                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300">Konfirmasi</span>
                        </div>
                    </div>

                    <div class="text-center mt-auto w-full px-2 lg:px-6">
                        <div class="inline-flex items-center justify-center gap-1.5 mb-2 px-3 py-1 bg-pink-50 dark:bg-pink-900/30 rounded-full border border-pink-100 dark:border-pink-800/50">
                            <svg class="w-3.5 h-3.5 text-pink-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="text-[9px] font-black text-pink-600 dark:text-pink-400 uppercase tracking-widest">Penting</span>
                        </div>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 font-bold leading-relaxed tracking-tight">
                            Pastikan transfer <span class="text-indigo-500 dark:text-indigo-400 font-black uppercase">TEPAT</span> memuat <span class="text-pink-500 font-black border-b border-pink-500 border-dashed pb-0.5">3 digit angka</span> unik di akhir nominal tagihan.
                        </p>
                    </div>
                </div>

                <div class="w-full p-6 bg-white dark:bg-gray-900 block md:hidden border-t border-gray-100 dark:border-gray-800">
                    <div class="max-w-md mx-auto space-y-3">
                        @php
                            $waNumber = env('ADMIN_WHATSAPP', '6282220312195');
                            $waMessage = "Konfirmasi Pembayaran TEMANTEN\nOrder: {$order->order_number}\nNominal: Rp " . number_format($order->total_amount, 0, ',', '.') . "\nPromo Spesial: -Rp {$order->unique_code}\n\nTerima kasih!";
                            $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);
                        @endphp
                        
                        <a href="{{ $waLink }}" target="_blank" 
                           class="flex items-center justify-center gap-2 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-100 dark:shadow-none active:scale-95 group">
                            <span class="text-sm">Konfirmasi via WA</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>

                        <a href="{{ route('home') }}" 
                           class="flex items-center justify-center w-full text-gray-400 hover:text-indigo-600 font-bold py-2 text-[10px] uppercase tracking-widest transition-colors duration-300">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest opacity-60">
                    © {{ date('Y') }} PT. TEMANTEN DIGITAL INVITATION
                </p>
            </div>
        </div>
    </div>

<style>
@keyframes scan {
  0% { transform: translateY(0); opacity: 0; }
  10% { opacity: 1; }
  90% { opacity: 1; }
  100% { transform: translateY(220px); opacity: 0; }
}
</style>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('paymentTimer', (expiredAt) => ({
            hours: '00',
            minutes: '00',
            seconds: '00',
            endTime: new Date(expiredAt).getTime(),
            init() {
                this.updateTimer();
                setInterval(() => this.updateTimer(), 1000);
            },
            updateTimer() {
                const now = new Date().getTime();
                const distance = this.endTime - now;
                if (distance < 0) {
                    this.hours = '00'; this.minutes = '00'; this.seconds = '00';
                    return;
                }
                this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
            }
        }));
    });

    function downloadQR() {
        const svg = document.querySelector('#qris-svg-container svg');
        if(!svg) return;
        
        // Ensure SVG has proper XML namespace for conversion
        if(!svg.getAttribute('xmlns')) {
            svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        }
        
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        // Define padding and calculate final size
        const padding = 20;
        // The QR code is generated with size 200 (defined in Laravel)
        const size = 200 + (padding * 2); 
        canvas.width = size;
        canvas.height = size;
        
        // Fill background with white to avoid transparent PNG issues in galleries
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Serialize the SVG to string
        const svgData = new XMLSerializer().serializeToString(svg);
        const blob = new Blob([svgData], {type: 'image/svg+xml;charset=utf-8'});
        const URL = window.URL || window.webkitURL || window;
        const blobURL = URL.createObjectURL(blob);
        
        const img = new Image();
        img.onload = function() {
            // Draw image on canvas with padding
            ctx.drawImage(img, padding, padding);
            
            // Convert to PNG data URL
            const pngUrl = canvas.toDataURL('image/png');
            
            // Create a temporary link to trigger download
            const downloadLink = document.createElement('a');
            downloadLink.href = pngUrl;
            downloadLink.download = 'QRIS_TEMANTEN_{{ $order->order_number }}.png';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            
            // Clean up memory
            URL.revokeObjectURL(blobURL);
        };
        img.src = blobURL;
    }
</script>
</body>
</html>