<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEMANTEN - Undangan Digital Elegan untuk Momen Istimewa Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --secondary: #EC4899;
            --accent: #F59E0B;
        }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        
        /* Smooth Blob Animations */
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(40px, -60px) scale(1.15); }
            50% { transform: translate(-30px, 40px) scale(0.95); }
            75% { transform: translate(50px, 20px) scale(1.08); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .animate-blob { animation: blob 8s infinite ease-in-out; }
        .animate-float { animation: float 6s infinite ease-in-out; }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-scaleIn { animation: scaleIn 0.6s ease-out; }
        
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #4F46E5; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4338CA; }
        
        /* Smooth transitions */
        * { transition-property: transform, opacity, background-color, border-color, color, box-shadow; }
        
        /* Phone mockup improvements */
        .phone-shadow {
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(0, 0, 0, 0.1);
        }
        
        /* Button hover effects */
        .btn-primary {
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }
        
        /* Card hover effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-12px) scale(1.02);
        }
        
        /* Premium badge pulse */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(251, 191, 36, 0.5); }
            50% { box-shadow: 0 0 30px rgba(251, 191, 36, 0.8); }
        }
        
        .premium-badge {
            animation: pulse-glow 2s infinite;
        }
        
        /* Nav blur effect on scroll */
        .nav-scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased overflow-x-hidden">

    <!-- Preview Modal - Enhanced -->
    <div id="previewModal" class="fixed inset-0 z-[100] hidden bg-gray-900/98 backdrop-blur-xl transition-all duration-500 opacity-0 flex flex-col">
    
        <!-- Modal Header - Enhanced -->
        <div class="w-full h-20 bg-gray-900/95 backdrop-blur-xl border-b border-white/20 shadow-xl flex justify-between items-center px-6 md:px-10 z-50 shrink-0">
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-3">
                    <span class="text-white text-sm font-semibold">Mode Tampilan:</span>
                    <div class="flex bg-black/40 rounded-xl p-1.5 border border-white/20 gap-1">
                        <button onclick="setDevice('mobile')" id="btnMobile" class="group p-3 rounded-lg text-white bg-indigo-600 transition-all shadow-lg shadow-indigo-500/30 bg-indigo-700" title="Tampilan Mobile">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </button>
                        <button onclick="setDevice('desktop')" id="btnDesktop" class="group p-3 rounded-lg text-white/70 hover:text-white/90 hover:bg-white/15 transition-all" title="Tampilan Desktop">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a id="btnOrderTheme" href="javascript:void(0)" class="btn-primary relative flex bg-indigo-600 hover:bg-indigo-700 text-white px-6 md:px-8 py-3 md:py-3.5 rounded-full text-sm md:text-base font-bold transition-all shadow-2xl shadow-indigo-500/40 hover:shadow-indigo-500/60 items-center gap-2 hover:scale-105">
                    <span class="relative z-10">Pilih Tema Ini</span>
                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </a>
                <button onclick="closePreview()" class="group text-white/70 hover:text-white transition bg-white/10 hover:bg-red-500/80 rounded-xl p-3 border border-white/20 hover:border-red-500">
                    <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Modal Content - Enhanced -->
        <div class="flex-1 flex items-center justify-center overflow-hidden relative p-6" onclick="closePreview()">
            
            <!-- Loader - Enhanced -->
            <div id="loader" class="absolute inset-0 flex flex-col items-center justify-center z-20 pointer-events-none gap-4 bg-gray-900/80 backdrop-blur-sm">
                <div class="relative">
                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-indigo-500/30 border-t-indigo-500"></div>
                    <div class="absolute inset-0 animate-ping rounded-full h-16 w-16 border-4 border-indigo-500/20"></div>
                </div>
                <p class="text-white/60 text-sm font-medium">Memuat preview...</p>
            </div>

            <!-- Frame Wrapper - Enhanced -->
            <div id="frameWrapper" class="relative bg-white shadow-2xl transition-all duration-700 ease-in-out z-10 rounded-3xl" onclick="event.stopPropagation()">
                
                <div id="phoneNotch" class="absolute top-0 left-1/2 transform -translate-x-1/2 w-[140px] h-[32px] bg-gray-900 rounded-b-3xl z-30 pointer-events-none transition-opacity duration-300"></div>

                <iframe id="previewFrame" src="" class="w-full h-full bg-white rounded-3xl" frameborder="0" onload="if(window.onFrameLoad) window.onFrameLoad()"></iframe>

            </div>
        </div>
    </div>

    <!-- Navigation - Enhanced -->
    <nav id="mainNav" class="fixed w-full z-50 glass border-b border-gray-100/50 transition-all duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex justify-between items-center">
            
            <!-- Logo - Enhanced -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl overflow-hidden shadow-md group-hover:rotate-12 group-hover:scale-110 transition-all duration-300 drop-shadow-lg">
                    <img src="{{ asset('assets/mini-logo.jpg') }}" alt="Logo Temanten" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-xl text-gray-900 tracking-tight leading-none">TEMANTEN</span>
                    <span class="text-[10px] text-gray-600 font-semibold tracking-wider uppercase">Digital Invitation</span>
                </div>
            </a>

            <!-- Nav Links - Desktop -->
            <div class="hidden md:flex items-center gap-10 text-sm font-semibold text-gray-600">
                <a href="#fitur" class="hover:text-indigo-600 transition-all duration-300 hover:scale-105 relative group">
                    Fitur
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('themes.index') }}" class="hover:text-indigo-600 transition-all duration-300 hover:scale-105 relative group">
                    Katalog Tema
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <div class="flex items-center gap-2 sm:gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-700 hover:text-indigo-600 hidden md:block transition-all duration-300 hover:scale-105">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-indigo-600 hidden md:block transition-all duration-300 hover:scale-105">Masuk</a>
                @endauth
                <a href="{{ route('order.create') }}" class="btn-primary relative bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 sm:px-5 sm:py-2.5 md:px-6 md:py-3 rounded-full text-[10px] sm:text-xs md:text-sm font-bold shadow-xl shadow-indigo-200 hover:shadow-2xl hover:shadow-indigo-300 hover:scale-105 transition-all duration-300 whitespace-nowrap">
                    <span class="relative z-10">Buat Undangan</span>
                </a>
                <!-- Mobile Menu Button -->
                <button type="button" id="mobileMenuBtn" class="md:hidden text-gray-700 hover:text-indigo-600 p-1 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobileMenuPanel" class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 origin-top transform transition-all duration-300 opacity-0 -translate-y-2">
            <div class="px-6 py-4 space-y-4">
                <a href="#fitur" class="block w-full text-gray-700 font-semibold hover:text-indigo-600 py-2 mobile-link">Fitur Unggulan</a>
                <a href="{{ route('themes.index') }}" class="block w-full text-gray-700 font-semibold hover:text-indigo-600 py-2">Katalog Tema</a>
                <div class="h-px bg-gray-100 my-2"></div>
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full text-center text-gray-700 font-bold hover:text-indigo-600 py-2 border-2 border-gray-200 rounded-full">Dashboard Menu</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center text-gray-700 font-bold hover:text-indigo-600 py-2 border-2 border-gray-200 rounded-full">Masuk Akun</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section - Enhanced -->
    <section class="pt-40 pb-28 px-6 relative overflow-hidden">
        <!-- Animated Background Blobs - Enhanced -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute top-10 left-1/4 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
            <div class="absolute top-20 right-1/4 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/3 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Hero Text - Enhanced -->
            <div class="text-center lg:text-left z-10 space-y-8 animate-fadeInUp">
                <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-full text-indigo-700 text-sm font-semibold shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <span>Platform Undangan Digital Terpercaya</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl lg:text-7xl font-extrabold text-gray-900 leading-[1.1] tracking-tight">
                    Bagikan Momen<br>
                    <span class="font-serif italic text-indigo-600">Bahagiamu</span>
                </h1>
                
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                    Ciptakan undangan pernikahan digital yang <span class="text-indigo-600 font-bold">elegan & modern</span> dalam hitungan menit. Fitur lengkap, desain premium, harga terjangkau.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-5 justify-center lg:justify-start pt-4">
                    <a href="#tema" class="group btn-primary relative bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-5 rounded-full font-bold text-lg shadow-2xl shadow-indigo-300 hover:shadow-indigo-400 hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                        <span class="relative z-10">Pilih Tema Favorit</span>
                        <svg class="w-6 h-6 group-hover:translate-y-1 transition-transform relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </a>
                    <a href="#fitur" class="group bg-white text-gray-900 px-10 py-5 rounded-full font-bold text-lg border-2 border-gray-200 hover:border-indigo-600 hover:text-indigo-600 transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl hover:scale-105">
                        <span>Lihat Fitur</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <!-- Stats - New -->
                <div class="grid grid-cols-3 gap-6 pt-8 max-w-lg mx-auto lg:mx-0">
                    <div class="text-center lg:text-left">
                        <div class="text-3xl font-extrabold text-indigo-600">100%</div>
                        <div class="text-sm text-gray-500 font-medium mt-1">Digital & Paperless</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-3xl font-extrabold text-indigo-600">RSVP</div>
                        <div class="text-sm text-gray-500 font-medium mt-1">Konfirmasi Kehadiran Online</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-3xl font-extrabold text-indigo-600">Music</div>
                        <div class="text-sm text-gray-500 font-medium mt-1">Auto-Play Backsound Romantis</div>
                    </div>
                </div>
            </div>
            
            <!-- Hero Phone Mockup - Enhanced -->
            <div class="relative z-10 flex justify-center lg:justify-end animate-scaleIn">
                <div class="relative animate-float">
                    <!-- Decorative Elements -->
                    <div class="absolute -top-8 -right-8 w-24 h-24 bg-pink-300 rounded-full opacity-20 blur-2xl"></div>
                    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-indigo-300 rounded-full opacity-20 blur-2xl"></div>
                    
                    <!-- Phone Device -->
                    <div class="relative mx-auto border-gray-800 bg-gray-900 border-[14px] rounded-[3rem] h-[650px] w-[320px] phone-shadow hover:scale-105 transition-all duration-700 group">
                        <!-- Side Buttons -->
                        <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
                        <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
                        <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
                        
                    <!-- Screen Content -->
                    @php $heroTheme = \App\Models\Theme::where('is_active', true)->first(); @endphp
                    <div class="rounded-[2.5rem] overflow-hidden w-full h-full bg-white relative">
                        <img src="{{ asset('assets/thumbnail/' . ($heroTheme->slug ?? 'floral-pastel') . '.png') }}" 
                            alt="Preview {{ $heroTheme->name ?? 'Tema' }}" 
                            class="w-full h-full object-cover">

                        <!-- Overlay on Hover -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-end p-8">
                            <button onclick="openPreview('{{ route('demo.show', $heroTheme->slug ?? 'floral-pastel') }}')" class="bg-white text-gray-900 px-8 py-3.5 rounded-full font-bold text-base shadow-2xl hover:scale-105 transition-all transform flex items-center gap-3 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Lihat Demo Interaktif
                            </button>
                            <p class="text-white/90 text-sm font-medium">Klik untuk preview lengkap</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Theme Gallery Section - Enhanced -->
    <section id="tema" class="py-32 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Section Header - Enhanced -->
            <div class="text-center mb-28 md:mb-32 space-y-5 animate-fadeInUp">
                <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-full text-indigo-700 text-sm font-semibold">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                    <span>Koleksi Tema Premium</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                    Tema <span class="font-serif italic text-indigo-600">Eksklusif</span> untuk Anda
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Desain mobile-first yang memukau di setiap layar smartphone. Pilih tema yang mencerminkan kepribadian Anda.
                </p>
            </div>

            <!-- Theme Cards Grid — Dynamic dari Database -->
            @php
                $catalogThemes = \App\Models\Theme::where('is_active', true)->orderBy('id')->take(3)->get();
                $rotations = ['-rotate-3 md:-rotate-6 group-hover:rotate-0', '', 'rotate-3 md:rotate-6 group-hover:rotate-0'];
                $delays = ['', 'animation-delay-200', 'animation-delay-400'];
                $featured = [false, true, false];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16 place-items-center mt-16 md:mt-32">
                @foreach($catalogThemes as $i => $theme)
                @php
                    $rotation = $rotations[$i] ?? '';
                    $delay    = $delays[$i] ?? '';
                    $isFeatured = $featured[$i] ?? false;
                    $thumbnail = asset('assets/thumbnail/' . $theme->slug . '.png');
                @endphp
                <div class="flex flex-col items-center group w-full max-w-sm {{ $isFeatured ? 'relative md:-top-16' : '' }} animate-fadeInUp {{ $delay }}">
                    <div class="relative card-hover w-full">
                        <div class="relative mx-auto border-gray-900 bg-gray-900 border-[14px] rounded-[3rem] h-[560px] w-[280px] phone-shadow transform {{ $rotation }} {{ $isFeatured ? 'scale-110 hover:scale-[1.15] ring-4 ring-indigo-200/50' : '' }}">
                            <!-- Side Buttons -->
                            <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
                            <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
                            <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>

                            <!-- Screen -->
                            <div class="rounded-[2.5rem] overflow-hidden w-full h-full bg-white relative">
                                <img src="{{ $thumbnail }}" alt="{{ $theme->name }}" class="w-full h-full object-cover">

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-indigo-900/80 backdrop-blur-[2px] flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 gap-4 p-6">
                                    <div class="text-white text-center space-y-2 mb-4">
                                        <div class="text-2xl font-bold">{{ $theme->name }}</div>
                                        <div class="text-sm opacity-90">Klik untuk melihat preview</div>
                                    </div>
                                    <button onclick="openPreview('{{ route('demo.show', $theme->slug) }}')" class="bg-white text-gray-900 px-8 py-3 rounded-full font-bold text-sm hover:bg-indigo-50 transition-all transform hover:scale-105 flex items-center gap-2 shadow-2xl">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Live Preview
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if($isFeatured)
                        <!-- Premium Badge -->
                        <div class="absolute -top-6 -right-6 bg-amber-500 text-white text-xs font-black px-4 py-2 rounded-full shadow-2xl rotate-12 z-20 premium-badge flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            POPULER
                        </div>
                        @endif
                    </div>

                    <!-- Theme Info -->
                    <div class="mt-10 text-center px-4 relative z-10 space-y-4 w-full">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $theme->name }}</h3>
                        <div class="flex items-center justify-center gap-6 pt-2">
                            <div class="text-center">
                                @if($theme->has_promo)
                                    <div class="text-sm text-gray-400 line-through mb-1 font-bold">{{ $theme->short_original_price }}</div>
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="text-3xl font-extrabold text-amber-500 tracking-tight">{{ $theme->short_price }}</div>
                                    </div>
                                    <div class="text-[0.65rem] text-amber-600 font-bold mt-1 bg-amber-50 rounded-full px-2 py-0.5 inline-block border border-amber-200 uppercase tracking-widest shadow-sm">Promo Spesial</div>
                                @else
                                    <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $theme->short_price }}</div>
                                    <div class="text-xs text-gray-500 mt-1 font-medium">{{ $isFeatured ? 'Tema terpopuler' : 'Harga spesial' }}</div>
                                @endif
                            </div>
                            <a href="{{ route('order.create') }}?theme={{ $theme->slug }}" class="text-sm font-bold border-2 {{ $isFeatured ? 'border-indigo-600 bg-indigo-600 text-white hover:bg-indigo-700 hover:border-indigo-700' : 'border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white' }} px-6 py-3 rounded-full transition-all duration-300 uppercase tracking-widest hover:scale-105 shadow-lg hover:shadow-xl">
                                Pilih Tema
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- View More CTA - Enhanced -->
            <div class="mt-24 text-center relative z-20 space-y-6">
                <a href="{{ route('themes.index') }}" class="group inline-flex items-center gap-4 bg-white border-2 border-gray-200 px-10 py-5 rounded-full font-bold text-gray-700 hover:border-indigo-600 hover:text-indigo-600 transition-all duration-500 shadow-xl hover:shadow-2xl hover:scale-105">
                    <span class="text-lg">Jelajahi Koleksi Lengkap</span>
                    <div class="bg-indigo-100 group-hover:bg-indigo-600 rounded-full p-2 transition-all duration-300">
                        <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform duration-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
                <p class="text-base text-gray-500 font-medium">
                    Menampilkan <span class="font-bold text-indigo-600">3 dari {{ \App\Models\Theme::count() }}+</span> Tema Premium Eksklusif
                </p>
            </div>

        </div>
    </section>

    <!-- Features Section - Tailblocks -->
    <section id="fitur" class="text-gray-600 body-font bg-white">
      <div class="container px-5 py-24 mx-auto">
        <div class="text-center mb-20">
          <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-full text-indigo-700 text-sm font-semibold mb-4 animate-fadeInUp">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
              <span>Fitur Unggulan</span>
          </div>
          <h1 class="sm:text-5xl text-4xl font-extrabold title-font text-gray-900 mb-4 animate-fadeInUp">Semua yang Anda <span class="font-serif italic text-indigo-600">Butuhkan</span></h1>
          <p class="text-lg leading-relaxed max-w-2xl mx-auto text-gray-600 animate-fadeInUp">Platform lengkap dengan fitur premium untuk undangan pernikahan digital yang sempurna, cepat, dan modern.</p>
          <div class="flex mt-6 justify-center">
            <div class="w-16 h-1 rounded-full bg-indigo-500 inline-flex"></div>
          </div>
        </div>
        <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4 md:space-y-0 space-y-6">
          <div class="p-4 md:w-1/3 flex flex-col text-center items-center">
            <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
              </svg>
            </div>
            <div class="flex-grow">
              <h2 class="text-gray-900 text-xl title-font font-bold mb-3">Proses Super Cepat</h2>
              <p class="leading-relaxed text-gray-600">Undangan langsung aktif setelah pembayaran terverifikasi. Edit data kapan saja tanpa batasan waktu.</p>
            </div>
          </div>
          <div class="p-4 md:w-1/3 flex flex-col text-center items-center">
            <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                <path d="M12 18h.01"></path>
              </svg>
            </div>
            <div class="flex-grow">
              <h2 class="text-gray-900 text-xl title-font font-bold mb-3">100% Mobile Friendly</h2>
              <p class="leading-relaxed text-gray-600">Tampilan responsif sempurna di semua perangkat. Loading cepat dan pengalaman browsing yang mulus bagi seluruh tamu undangan Anda.</p>
            </div>
          </div>
          <div class="p-4 md:w-1/3 flex flex-col text-center items-center">
            <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow">
              <h2 class="text-gray-900 text-xl title-font font-bold mb-3">Unlimited Undangan</h2>
              <p class="leading-relaxed text-gray-600">Bagikan ke sebanyak mungkin teman, relasi, dan keluarga tanpa ada batasan kuota nama tamu sama sekali.</p>
            </div>
          </div>
        </div>
        <div class="flex justify-center mt-16 animate-fadeInUp animation-delay-400">
            <a href="{{ route('order.create') }}" class="btn-primary inline-flex text-white bg-indigo-600 border-0 py-3 px-8 mx-auto focus:outline-none hover:bg-indigo-700 rounded-full font-bold text-lg transition-transform hover:-translate-y-1 shadow-xl shadow-indigo-300">
                Mulai Buat Undangan
            </a>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="cara-kerja" class="py-24 bg-slate-50 relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <div class="inline-flex items-center gap-2 bg-white border border-indigo-100 px-4 py-2 rounded-full text-indigo-700 text-sm font-semibold mb-4 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    Cara Kerja
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">Dari pilih tema sampai siap dibagikan dalam alur yang rapi</h2>
                <p class="mt-4 text-lg text-gray-600">Alur sederhana ala automation: pilih, bayar, lengkapi konten, lalu kirim undangan ke semua tamu.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-4">
                @foreach([
                    ['01', 'Pilih Tema', 'Bandingkan katalog, preview mobile/desktop, lalu pilih desain favorit.'],
                    ['02', 'Buat Order', 'Isi data dasar dan lanjutkan pembayaran QRIS dengan nominal unik.'],
                    ['03', 'Lengkapi Konten', 'Masuk dashboard untuk upload foto, galeri, cerita, lokasi, dan amplop digital.'],
                    ['04', 'Bagikan Link', 'Kelola tamu, copy link personal, dan kirim via WhatsApp.'],
                ] as $step)
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black mb-5">{{ $step[0] }}</div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2">{{ $step[1] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $step[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trust Benefit Section -->
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="rounded-[2rem] border border-gray-100 bg-gradient-to-br from-gray-950 via-indigo-950 to-gray-900 p-8 md:p-10 text-white shadow-2xl overflow-hidden relative">
                <div class="absolute -right-16 -top-16 w-56 h-56 bg-indigo-500/30 rounded-full blur-3xl"></div>
                <div class="relative grid lg:grid-cols-[1.2fr_.8fr] gap-8 items-center">
                    <div>
                        <p class="text-indigo-200 text-sm font-bold uppercase tracking-[0.2em] mb-3">Dipercaya untuk momen penting</p>
                        <h2 class="text-3xl md:text-4xl font-extrabold leading-tight">Undangan digital yang cepat dibuat, mudah dirawat, dan nyaman dibuka tamu.</h2>
                    </div>
                    <div class="grid sm:grid-cols-3 lg:grid-cols-1 gap-3">
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-4"><strong class="block text-lg">Responsive</strong><span class="text-sm text-white/70">Rapi di HP dan desktop.</span></div>
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-4"><strong class="block text-lg">Dashboard</strong><span class="text-sm text-white/70">Edit konten dan tamu mandiri.</span></div>
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-4"><strong class="block text-lg">QRIS</strong><span class="text-sm text-white/70">Pembayaran praktis dan jelas.</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section - New -->
    <section class="py-28 bg-indigo-600 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-10">
            <h2 class="text-4xl md:text-6xl font-extrabold text-white leading-tight">
                Siap Membuat Undangan <br class="hidden md:block"/>
                <span class="font-serif italic">Impian Anda?</span>
            </h2>
            <p class="text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
                Bergabunglah dengan ratusan pasangan yang telah mempercayai kami untuk momen spesial mereka
            </p>
            <div class="flex flex-col sm:flex-row gap-5 justify-center pt-6">
                <a href="#tema" class="bg-white text-indigo-600 px-10 py-5 rounded-full font-bold text-lg shadow-2xl hover:shadow-white/30 hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                    <span>Mulai Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <a href="#tema" class="bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-white/20 transition-all duration-300 flex items-center justify-center gap-3 hover:scale-105">
                    <span>Lihat Demo</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </a>
            </div>
            
            <!-- Trust Indicators -->
            <div class="grid grid-cols-3 gap-8 pt-12 max-w-3xl mx-auto border-t border-white/20">
                <div class="text-center">
                    <div class="text-3xl font-extrabold text-white">Premium</div>
                    <div class="text-white/70 text-sm mt-2">Pilihan Desain Eksklusif</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-extrabold text-white">Aman</div>
                    <div class="text-white/70 text-sm mt-2">Data Privasi Terjaga</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-extrabold text-white">Fast Respon</div>
                    <div class="text-white/70 text-sm mt-2">Siap Membantu Anda</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section - New -->
    <section id="faq" class="bg-white dark:bg-gray-900 py-24">
        <div class="container max-w-4xl px-6 mx-auto">
            <h1 class="text-3xl font-bold text-center text-gray-800 lg:text-4xl dark:text-white animate-fadeInUp">
                Pertanyaan Seputar <span class="text-indigo-600">Temanten</span>
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto text-center mt-4 mb-16 dark:text-gray-300 animate-fadeInUp">Kami merangkum pertanyaan yang sering ditanyakan oleh calon pengantin. Jika ada pertanyaan lain, jangan ragu hubungi kami!</p>

            <div class="mt-12 space-y-8">
                <!-- FAQ Item 1 -->
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700 animate-fadeInUp transition-colors hover:border-indigo-100 dark:hover:border-indigo-900">
                    <button class="flex items-center justify-between w-full p-8 text-left group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <h1 class="font-semibold text-gray-700 dark:text-white group-hover:text-indigo-600 transition-colors">Berapa lama proses pembuatan undangan?</h1>

                        <span class="text-white bg-indigo-500 rounded-full flex-shrink-0 ml-4 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>

                    <div class="hidden transition-all duration-300">
                        <hr class="border-gray-200 dark:border-gray-700">
                        <p class="p-8 text-sm md:text-base text-gray-500 dark:text-gray-300 leading-relaxed">
                            Proses pembuatan undangan sangat cepat! Anda hanya perlu memilih tema, mengisi form data diri dan acara, lalu melakukan pembayaran. Setelah pembayaran terverifikasi otomatis, akun & undangan Anda langsung aktif dan siap disebarkan saat itu juga.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700 animate-fadeInUp animation-delay-200 transition-colors hover:border-indigo-100 dark:hover:border-indigo-900">
                    <button class="flex items-center justify-between w-full p-8 text-left group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <h1 class="font-semibold text-gray-700 dark:text-white group-hover:text-indigo-600 transition-colors">Apakah saya bisa mengubah data undangan setelah selesai dibuat?</h1>

                        <span class="text-white bg-indigo-500 rounded-full flex-shrink-0 ml-4 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>

                    <div class="hidden transition-all duration-300">
                        <hr class="border-gray-200 dark:border-gray-700">
                        <p class="p-8 text-sm md:text-base text-gray-500 dark:text-gray-300 leading-relaxed">
                            Tentu saja! Setelah Anda mendaftar dan membayar, Anda akan mendapatkan akses ke Dashboard khusus. Di sana Anda bisa mengedit nama, tanggal, lokasi, hingga foto galeri kapanpun tanpa batasan revisi.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700 animate-fadeInUp animation-delay-400 transition-colors hover:border-indigo-100 dark:hover:border-indigo-900">
                    <button class="flex items-center justify-between w-full p-8 text-left group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <h1 class="font-semibold text-gray-700 dark:text-white group-hover:text-indigo-600 transition-colors">Berapa batas maksimal foto yang bisa di-upload?</h1>

                        <span class="text-white bg-indigo-500 rounded-full flex-shrink-0 ml-4 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                    </button>

                    <div class="hidden transition-all duration-300">
                        <hr class="border-gray-200 dark:border-gray-700">
                        <p class="p-8 text-sm md:text-base text-gray-500 dark:text-gray-300 leading-relaxed">
                            Kami tidak membatasi jumlah foto yang dapat Anda unggah! Anda bisa memasukkan puluhan foto pre-wedding Anda ke dalam galeri undangan digital selama akun masih aktif.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center text-sm font-medium text-gray-500 dark:text-gray-400 animate-fadeInUp animation-delay-600">
                Masih punya pertanyaan? <a href="https://wa.me/6282220312195" target="_blank" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 font-bold underline decoration-2 decoration-indigo-200 dark:decoration-indigo-800 underline-offset-4">Tanya Admin via WhatsApp</a>
            </div>
        </div>
    </section>

    <!-- Footer - Enhanced -->
    <footer class="bg-gray-900 text-white relative overflow-hidden">
        <!-- Decorative Top Border -->
        <div class="h-1 bg-indigo-600"></div>
        
        <div class="max-w-7xl mx-auto px-6 py-16 relative z-10">
            <!-- Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                
                <!-- Brand Column -->
                <div class="space-y-6 md:col-span-2">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl overflow-hidden shadow-lg border border-white/10">
                            <img src="{{ asset('assets/mini-logo.jpg') }}" alt="Logo Temanten" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h2 class="font-extrabold text-2xl tracking-tight">TEMANTEN</h2>
                            <p class="text-[0.65rem] text-gray-400 font-bold tracking-[0.2em] uppercase">Digital Invitation</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                        Platform pembuatan undangan pernikahan digital elegan, modern, dan mudah digunakan. Bagikan kebahagiaan Anda hanya dalam beberapa menit bersama Temanten.
                    </p>
                    <!-- Social Media -->
                    <div class="flex gap-4 pt-2">
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-indigo-600 rounded-full flex items-center justify-center transition-all hover:scale-110 border border-white/10">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-pink-600 rounded-full flex items-center justify-center transition-all hover:scale-110 border border-white/10">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-blue-500 rounded-full flex items-center justify-center transition-all hover:scale-110 border border-white/10">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Navigasi Utama -->
                <div class="space-y-6">
                    <h3 class="font-bold text-white text-lg tracking-wide uppercase text-sm border-b border-white/10 pb-3 inline-block">Menu Utama</h3>
                    <ul class="space-y-4">
                        <li><a href="#fitur" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center gap-2 text-sm"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span> Fitur Unggulan</a></li>
                        <li><a href="{{ route('themes.index') }}" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center gap-2 text-sm"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span> Katalog Tema</a></li>
                        <li><a href="#faq" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center gap-2 text-sm"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span> Tanya Jawab (FAQ)</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center gap-2 text-sm"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span> Login Dashboard</a></li>
                    </ul>
                </div>

                <!-- Hubungi Kami -->
                <div class="space-y-6">
                    <h3 class="font-bold text-white text-lg tracking-wide uppercase text-sm border-b border-white/10 pb-3 inline-block">Hubungi Kami</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-start gap-4 text-gray-400">
                            <div class="bg-white/5 p-2 rounded-lg text-indigo-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-white/90 mb-0.5">WhatsApp Admin</div>
                                <a href="https://wa.me/6282220312195" target="_blank" class="hover:text-indigo-400 transition-colors">+62 822-2031-2195</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 text-gray-400">
                            <div class="bg-white/5 p-2 rounded-lg text-indigo-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-white/90 mb-0.5">Email Dukungan</div>
                                <a href="mailto:hello@temanten.com" class="hover:text-indigo-400 transition-colors">hello@temanten.com</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 text-gray-400">
                            <div class="bg-white/5 p-2 rounded-lg text-indigo-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-white/90 mb-0.5">Jam Operasional</div>
                                <span>Senin - Sabtu (09.00 - 17.00)</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-white/10">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm text-center md:text-left">
                        &copy; {{ date('Y') }} <span class="font-bold text-white tracking-widest">TEMANTEN</span>. Seluruh hak cipta dilindungi.
                    </p>
                    <div class="flex items-center gap-6 text-sm text-gray-500 font-medium">
                        <!-- <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                        <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a> -->
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
    const modal = document.getElementById('previewModal');
    const frame = document.getElementById('previewFrame');
    const loader = document.getElementById('loader');
    const frameWrapper = document.getElementById('frameWrapper');
    const phoneNotch = document.getElementById('phoneNotch');
    const btnMobile = document.getElementById('btnMobile');
    const btnDesktop = document.getElementById('btnDesktop');
    const btnOrder = document.getElementById('btnOrderTheme');
    const mainNav = document.getElementById('mainNav');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenuPanel = document.getElementById('mobileMenuPanel');
    const mobileLinks = document.querySelectorAll('.mobile-link');

    // Mobile Menu Toggle
    if (mobileMenuBtn && mobileMenuPanel) {
        mobileMenuBtn.addEventListener('click', () => {
            const isHidden = mobileMenuPanel.classList.contains('hidden');
            if (isHidden) {
                mobileMenuPanel.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenuPanel.classList.remove('opacity-0', '-translate-y-2');
                    mobileMenuPanel.classList.add('opacity-100', 'translate-y-0');
                }, 10);
                mobileMenuBtn.innerHTML = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            } else {
                mobileMenuPanel.classList.add('opacity-0', '-translate-y-2');
                mobileMenuPanel.classList.remove('opacity-100', 'translate-y-0');
                setTimeout(() => {
                    mobileMenuPanel.classList.add('hidden');
                }, 300);
                mobileMenuBtn.innerHTML = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
            }
        });

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenuBtn.click();
            });
        });
    }

    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            mainNav.classList.add('nav-scrolled', 'py-3');
            mainNav.classList.remove('py-5');
        } else {
            mainNav.classList.remove('nav-scrolled', 'py-3');
            mainNav.classList.add('py-5');
        }
        
        lastScroll = currentScroll;
    });

    window.hideLoader = function () {
        if (loader) {
            loader.classList.add('opacity-0');
            setTimeout(() => loader.classList.add('hidden'), 150);
        }
    };

    window.onFrameLoad = function () {
        window.hideLoader();
    };

    window.openPreview = function (url) {
        if (loader) {
            loader.classList.remove('hidden', 'opacity-0');
        }

        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => modal.classList.remove('opacity-0'), 10);
        }

        if (frame) {
            frame.src = url;
        }

        if (btnOrder && url) {
            const slug = url.split('/').pop();
            btnOrder.href = "{{ route('order.create') }}?theme=" + slug;
        }

        setDevice('mobile');
    };

    window.closePreview = function () {
        if (modal) {
            modal.classList.add('opacity-0');
            document.body.style.overflow = '';
            setTimeout(() => {
                modal.classList.add('hidden');
                if (frame) frame.src = '';
            }, 300);
        }
    };

    window.setDevice = function (type) {
        if (!frameWrapper || !frame) return;

        if (type === 'mobile') {
            frameWrapper.className =
                "relative transition-all duration-700 ease-in-out shadow-2xl bg-gray-800 border-[8px] sm:border-[14px] border-gray-900 rounded-[2rem] sm:rounded-[3rem] overflow-hidden flex flex-col";
            frameWrapper.style.width = "min(375px, 95vw)";
            frameWrapper.style.height = "min(812px, calc(100vh - 130px))";
            frameWrapper.style.maxWidth = "none";
            frame.className = "w-full h-full bg-white rounded-[1.5rem] sm:rounded-[2rem] flex-grow";
            if (phoneNotch) phoneNotch.classList.remove('hidden');
            highlightBtn(btnMobile, btnDesktop);
        } else {
            frameWrapper.className =
                "relative transition-all duration-700 ease-in-out shadow-2xl bg-white border-0 rounded-2xl overflow-hidden flex flex-col";
            frameWrapper.style.width = "90%";
            frameWrapper.style.height = "calc(100vh - 130px)";
            frameWrapper.style.maxWidth = "1400px";
            frame.className = "w-full h-full bg-white flex-grow";
            if (phoneNotch) phoneNotch.classList.add('hidden');
            highlightBtn(btnDesktop, btnMobile);
        }
    };

    // Highlight active button
    function highlightBtn(active, inactive) {
        if (active) {
            active.className = "group p-3 rounded-lg text-indigo-300 bg-white/15 transition-all";
        }
        if (inactive) {
            inactive.className = "group p-3 rounded-lg text-white/50 hover:text-white/90 hover:bg-white/10 transition-all";
        }
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function (event) {
        if (event.key === "Escape") closePreview();
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#') && href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Intersection Observer for animations on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fadeInUp');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('section > div > div').forEach(el => {
        observer.observe(el);
    });
    </script>

</body>
</html>