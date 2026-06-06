<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Undangan - TEMANTEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
        }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 8px; height: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        /* T-Spinner Animation */
        .pl-t {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }
        .pl__ring {
            stroke: rgba(255, 255, 255, 0.1);
            stroke-width: 4;
            stroke-linecap: round;
        }
        .pl__worm {
            stroke: #4F46E5;
            stroke-width: 4;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 40 140;
            animation: worm-t 2s cubic-bezier(0.42, 0, 0.58, 1) infinite;
        }
        @keyframes worm-t {
            0% { stroke-dashoffset: 40; }
            100% { stroke-dashoffset: -140; }
        }
        
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out; }
        .animate-scaleIn { animation: scaleIn 0.5s ease-out; }
        
        /* Loading shimmer effect */
        .shimmer {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
        
        /* Step indicator */
        .step-line {
            position: relative;
        }
        
        .step-line::before {
            content: '';
            position: absolute;
            top: 24px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e5e7eb;
            z-index: 0;
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Input focus glow */
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-indigo-50/30 min-h-screen">

    <!-- Header Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl overflow-hidden shadow-md group-hover:rotate-12 transition-all duration-300">
                    <img src="{{ asset('assets/mini-logo.jpg') }}" alt="Logo Temanten" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-lg text-gray-900 leading-none">TEMANTEN</span>
                    <span class="text-[9px] text-gray-600 font-semibold tracking-wider uppercase">Digital Invitation</span>
                </div>
            </a>
            
            <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto py-12 px-4 md:px-6 lg:px-8">
        
        <!-- Hero Header -->
        <div class="text-center mb-12 animate-fadeInUp">
            <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-full text-indigo-700 text-sm font-semibold mb-6">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span>Proses Mudah & Cepat</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Langkah Terakhir Menuju <br class="hidden md:block"/>
                <span class="font-serif italic gradient-text">Undangan Impianmu</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Isi data pemesan untuk membuat pesanan. Akun akan dibuatkan otomatis dan langsung bisa diakses.
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-12 animate-scaleIn">
            <div class="step-line relative flex justify-between items-center max-w-3xl mx-auto">
                <div class="flex flex-col items-center z-10 relative">
                    <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-200 mb-3">
                        1
                    </div>
                    <span class="text-xs md:text-sm font-semibold text-gray-900">Pilih Tema</span>
                </div>
                <div class="flex flex-col items-center z-10 relative">
                    <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-200 mb-3">
                        2
                    </div>
                    <span class="text-xs md:text-sm font-semibold text-gray-900">Data Diri</span>
                </div>
                <div class="flex flex-col items-center z-10 relative">
                    <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-200 mb-3">
                        3
                    </div>
                    <span class="text-xs md:text-sm font-semibold text-gray-900">Info Acara</span>
                </div>
                <div class="flex flex-col items-center z-10 relative">
                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold mb-3">
                        4
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-500">Pembayaran</span>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-6 mb-8 shadow-sm animate-fadeInUp">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-red-800 text-lg mb-2">Oops! Ada kesalahan input</h3>
                    <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Form -->
        <form action="{{ route('order.store') }}" method="POST" class="space-y-6 animate-fadeInUp" onsubmit="return showLoading(this);">
            @csrf

            <!-- Section 1: Theme Selection -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 card-hover">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 md:p-8 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                            1
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Pilih Tema Undangan</h2>
                            <p class="text-sm text-gray-600 mt-1">Pilih desain yang paling sesuai dengan kepribadian Anda</p>
                        </div>
                    </div>
                </div>
                
                @php $selectedThemeSlug = request('theme'); @endphp

                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[500px] overflow-y-auto custom-scrollbar pr-2">
                        @foreach($themes as $theme)
                        <div class="relative">
                            <input type="radio" name="theme_id" id="theme_{{ $theme->id }}" value="{{ $theme->id }}"
                                   class="sr-only theme-radio"
                                   {{ (old('theme_id') == $theme->id || $selectedThemeSlug == $theme->slug) ? 'checked' : '' }}
                                   required>

                            <label for="theme_{{ $theme->id }}"
                                   class="theme-card-label group flex items-center gap-4 border-2 border-gray-200 rounded-2xl cursor-pointer p-3.5 transition-all hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-100/70 bg-white hover:-translate-y-0.5">
                                {{-- Thumbnail --}}
                                <div class="relative h-24 w-20 bg-gray-100 rounded-2xl overflow-hidden flex-shrink-0 shadow-md ring-1 ring-gray-100">
                                    @php
                                        $thumbFile = $theme->thumbnail ?: ($theme->slug . '.png');
                                        $thumbExists = file_exists(public_path('assets/thumbnail/' . $thumbFile));
                                    @endphp
                                    @if($thumbExists)
                                        <img src="{{ asset('assets/thumbnail/' . $thumbFile) }}"
                                             alt="{{ $theme->name }}"
                                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100 text-xs text-indigo-500 font-semibold text-center px-1">
                                            {{ $theme->name }}
                                        </div>
                                    @endif
                                </div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <h3 class="font-extrabold text-gray-900 text-base truncate">{{ $theme->name }}</h3>
                                            <p class="text-xs text-gray-500 mt-0.5">Premium Theme • Mobile ready</p>
                                        </div>
                                        @if($theme->has_promo)
                                            <span class="shrink-0 rounded-full bg-amber-100 text-amber-700 border border-amber-200 px-2 py-0.5 text-[10px] font-black uppercase tracking-wide">Promo</span>
                                        @endif
                                    </div>
                                    @if($theme->has_promo)
                                        <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-amber-50 border border-amber-100 px-3 py-1">
                                            <p class="text-xs text-gray-400 line-through">{{ $theme->short_original_price }}</p>
                                            <p class="text-sm text-amber-600 font-extrabold">{{ $theme->short_price }}</p>
                                        </div>
                                    @else
                                        <p class="mt-2 inline-flex rounded-full bg-indigo-50 border border-indigo-100 px-3 py-1 text-sm text-indigo-600 font-extrabold">{{ $theme->short_price }}</p>
                                    @endif
                                    <p class="mt-2 text-[11px] font-semibold text-gray-400">Preview, RSVP, galeri, musik</p>
                                </div>
                                {{-- Radio indicator --}}
                                <div class="flex-shrink-0">
                                    <div class="radio-indicator w-7 h-7 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                        <svg class="radio-check w-4 h-4 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Section 2: Customer Data -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 card-hover">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 md:p-8 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                            2
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Data Pemesan & Akun</h2>
                            <p class="text-sm text-gray-600 mt-1">Informasi kontak dan link undangan yang Anda inginkan</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 md:p-8">
                    <div class="space-y-6">
                        <!-- WhatsApp Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                Nomor WhatsApp (Aktif)
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500">+62</span>
                                </div>
                                <input type="number" name="client_whatsapp" value="{{ old('client_whatsapp') }}" class="w-full pl-14 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 input-glow transition-all text-lg" placeholder="8123456789" required>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                Digunakan untuk notifikasi dan akses dashboard
                            </p>
                        </div>

                        <!-- Invitation Link -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                Link Undangan yang Diinginkan
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="flex rounded-xl overflow-hidden border-2 border-gray-200 focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-100 transition-all">
                                <span class="inline-flex items-center px-4 bg-gray-50 text-gray-600 text-sm font-semibold border-r border-gray-200">
                                    undangan.com/
                                </span>
                                <input type="text" name="slug" value="{{ old('slug') }}" class="flex-1 px-4 py-3.5 focus:outline-none lowercase text-lg" placeholder="romeo-juliet" required pattern="[a-z0-9-]+" title="Gunakan huruf kecil, angka, dan tanda strip (-)">
                            </div>
                            <div class="mt-2 flex items-start gap-2">
                                <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <div class="text-xs text-gray-600 space-y-1">
                                    <p class="font-semibold">Aturan penulisan link:</p>
                                    <ul class="list-disc pl-4 space-y-0.5">
                                        <li>Gunakan huruf kecil, angka, dan tanda strip (-)</li>
                                        <li>Contoh: <span class="font-mono bg-gray-100 px-2 py-0.5 rounded">rudi-siti</span> atau <span class="font-mono bg-gray-100 px-2 py-0.5 rounded">wedding2025</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Event Information -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 card-hover">
                <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-6 md:p-8 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                            3
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Informasi Acara</h2>
                            <p class="text-sm text-gray-600 mt-1">Data dasar untuk judul undangan Anda</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Groom Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                Nama Panggilan Pria
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="groom_name" value="{{ old('groom_name') }}" class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 input-glow transition-all text-lg" placeholder="Contoh: Romeo" required>
                            <input type="hidden" name="groom_father" value="-">
                            <input type="hidden" name="groom_mother" value="-">
                        </div>

                        <!-- Bride Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                Nama Panggilan Wanita
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="bride_name" value="{{ old('bride_name') }}" class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 input-glow transition-all text-lg" placeholder="Contoh: Juliet" required>
                            <input type="hidden" name="bride_father" value="-">
                            <input type="hidden" name="bride_mother" value="-">
                        </div>
                        
                        <!-- Event Date -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Tanggal Acara
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="event_date" value="{{ old('event_date') }}" class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 input-glow transition-all text-lg" required>
                            <input type="hidden" name="location_address" value="Alamat belum diisi">
                        </div>
                    </div>
                    
                    <!-- Info Note -->
                    <div class="mt-8 p-6 bg-gradient-to-r from-amber-50 to-yellow-50 border-2 border-amber-200 rounded-xl">
                        <div class="flex gap-4 items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-amber-900 text-lg mb-2">Informasi Penting</h4>
                                <p class="text-amber-800 text-sm leading-relaxed">
                                    Tenang saja! Data lengkap seperti <strong>Foto Pasangan, Galeri, Cerita Cinta, Lokasi Detail, Rekening Bank</strong>, dan informasi lainnya dapat Anda lengkapi nanti di <strong>Dashboard Client</strong> setelah pendaftaran berhasil. Anda akan memiliki akses penuh untuk mengedit semua konten undangan.
                                </p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1 bg-white px-3 py-1 rounded-full text-xs font-semibold text-amber-700 border border-amber-200">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Upload Foto
                                    </span>
                                    <span class="inline-flex items-center gap-1 bg-white px-3 py-1 rounded-full text-xs font-semibold text-amber-700 border border-amber-200">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Tambah Galeri
                                    </span>
                                    <span class="inline-flex items-center gap-1 bg-white px-3 py-1 rounded-full text-xs font-semibold text-amber-700 border border-amber-200">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Edit Data Lengkap
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="sticky bottom-0 z-40 bg-gradient-to-t from-white via-white to-transparent pt-8 pb-6">
                <div class="bg-white rounded-[1.75rem] shadow-2xl shadow-indigo-100 border-2 border-gray-100 p-5 md:p-7">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="text-center md:text-left">
                            <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 border border-indigo-100 px-3 py-1 text-[11px] font-black uppercase tracking-widest text-indigo-600 mb-3">Ringkasan Order</div>
                            <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Siap Membuat Undangan?</h3>
                            <p class="text-gray-600">Total pembayaran: <span class="text-2xl font-extrabold text-indigo-600" id="totalHarga">Rp {{ number_format(config('app.default_price'), 0, ',', '.') }}</span></p>
                            <p class="text-sm text-gray-500 mt-1">Akses mudah • Unlimited tamu • Edit kapan saja • QRIS otomatis</p>
                        </div>
                        <button id="btnSubmit" type="submit" data-testid="order-submit" class="group relative bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-5 px-10 rounded-xl shadow-2xl shadow-indigo-300 transition-all transform hover:scale-105 active:scale-95 w-full md:w-auto text-lg flex items-center justify-center gap-3 overflow-hidden">
                            <span class="relative z-10 flex items-center gap-3">
                                Buat Pesanan & Lanjut Pembayaran
                                <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-gray-900/95 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="text-center space-y-6 max-w-md px-6">
                <div class="relative">
                    <svg class="pl-t" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path class="pl__ring" d="M15,16 L33,16 M24,16 L24,36" fill="none" />
                        <path class="pl__worm" d="M15,16 L33,16 L24,16 L24,36" fill="none" />
                    </svg>
                </div>
            <div class="space-y-3">
                <h3 class="text-2xl font-bold text-white">Memproses Pesanan Anda...</h3>
                <p class="text-gray-300">Mohon tunggu sebentar, jangan tutup halaman ini.</p>
            </div>
        </div>
    </div>

    <script>
        function showLoading(form) {
            if (!form.checkValidity()) {
                return true; 
            }

            const btn = document.getElementById('btnSubmit'); 
            const overlay = document.getElementById('loadingOverlay');
            
            if(btn) {
                btn.innerHTML = `
                    <svg class="animate-spin h-6 w-6 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="ml-3">Memproses...</span>
                `;
                btn.classList.add('opacity-75', 'cursor-not-allowed');
                btn.disabled = true;
            }

            if(overlay) {
                overlay.classList.remove('hidden');
            }

            return true; 
        }

        const waInput = document.querySelector('input[name="client_whatsapp"]');
        if(waInput) {
            waInput.addEventListener('input', function(e) {
                if(e.target.value.startsWith('0')) {
                    e.target.value = e.target.value.substring(1);
                }
            });
        }

        const slugInput = document.querySelector('input[name="slug"]');
        if(slugInput) {
            slugInput.addEventListener('input', function(e) {
                e.target.value = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9-]/g, '-')
                    .replace(/-+/g, '-');
            });
            slugInput.addEventListener('blur', function(e) {
                e.target.value = e.target.value.replace(/^-|-$/g, '');
            });
        }

        window.addEventListener('load', function() {
            const errorElement = document.querySelector('.bg-red-50');
            if(errorElement) {
                errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        const themePrices = {
            @foreach($themes as $theme)
            {{ $theme->id }}: {{ $theme->effective_price }},
            @endforeach
        };

        function formatRupiah(n) {
            return 'Rp\u00a0' + n.toLocaleString('id-ID');
        }

        function selectTheme(radio) {
            document.querySelectorAll('.theme-card-label').forEach(function(lbl) {
                lbl.classList.remove('border-indigo-600', 'bg-indigo-50', 'ring-4', 'ring-indigo-100');
                lbl.classList.add('border-gray-200');
                const ind = lbl.querySelector('.radio-indicator');
                const chk = lbl.querySelector('.radio-check');
                if (ind) { ind.classList.remove('bg-indigo-600', 'border-indigo-600'); ind.classList.add('border-gray-300'); }
                if (chk) { chk.classList.add('hidden'); }
            });
            const label = document.querySelector('label[for="' + radio.id + '"]');
            if (label) {
                label.classList.add('border-indigo-600', 'bg-indigo-50', 'ring-4', 'ring-indigo-100');
                label.classList.remove('border-gray-200');
                const ind = label.querySelector('.radio-indicator');
                const chk = label.querySelector('.radio-check');
                if (ind) { ind.classList.add('bg-indigo-600', 'border-indigo-600'); ind.classList.remove('border-gray-300'); }
                if (chk) { chk.classList.remove('hidden'); }
            }
            const el = document.getElementById('totalHarga');
            const price = themePrices[radio.value];
            if (el && price) {
                el.textContent = formatRupiah(price);
                el.classList.add('scale-110');
                setTimeout(() => el.classList.remove('scale-110'), 300);
            }
        }

        document.querySelectorAll('.theme-radio').forEach(function(radio) {
            radio.addEventListener('change', function() { selectTheme(this); });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const checked = document.querySelector('.theme-radio:checked');
            if (checked) selectTheme(checked);
        });

    </script>

</body>
</html>