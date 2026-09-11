<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wedding Invitation {{ $invitation->bride_nickname }} & {{ $invitation->groom_nickname }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            black: "#15130F",
                            gold: "#AD8A54",
                            lightGold: "#D7BD8B",
                            cream: "#F6F1E7",
                            brown: "#3A3023",
                            ink: "#2A241C"
                        }
                    },
                    fontFamily: {
                        serif: ["Playfair Display", "serif"],
                        script: ["Great Vibes", "cursive"],
                        sans: ["Inter", "sans-serif"],
                        arabic: ["Amiri", "serif"]
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <!-- AOS (Animate On Scroll) Library & SweetAlert2 -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        body {
            background: #F6F1E7;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }

        .gold-line {
            background: linear-gradient(90deg, transparent, #AD8A54, transparent);
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
        }

        summary::-webkit-details-marker {
            display: none;
        }

        summary {
            list-style: none;
        }

        details[open] summary .chevron-icon {
            transform: rotate(180deg);
        }

        .flourish {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .icon-line {
            stroke: currentColor;
            fill: none;
            stroke-width: 1.4;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .eyebrow-italic {
            font-family: "Playfair Display", serif;
            font-style: italic;
            font-size: 0.8rem;
            color: #AD8A54;
            letter-spacing: 0.02em;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        @keyframes gentle-pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.55;
            }
        }

        .animate-gentle-pulse {
            animation: gentle-pulse 2.4s ease-in-out infinite;
        }

        #account-number,
        .account-number {
            word-break: break-all;
        }

        img,
        iframe,
        svg {
            max-width: 100%;
        }

        @media (max-width: 340px) {
            .countdown-num {
                font-size: 1.5rem;
            }
        }

        /* Custom SweetAlert2 for Mobile */
        @media (max-width: 600px) {
            .swal-mobile-sm {
                width: 85% !important;
                font-size: 0.85em !important;
                padding: 1.5em !important;
                border-radius: 12px !important;
            }
        }
    </style>
</head>

<body id="body" class="font-sans text-luxury-ink overflow-y-hidden relative">

    <!-- DATA BINDING -->
    <div id="app-data" class="hidden"
        data-rsvp-url="{{ route('rsvp.store', $invitation->slug) }}"
        data-event-date="{{ $invitation->events->first() ? $invitation->events->first()->start_time : '' }}">
    </div>

    <!-- Audio Background -->
    @if($invitation->background_music)
    <audio id="bg-music" loop preload="none">
        <source src="{{ Storage::url($invitation->background_music) }}" type="audio/mpeg">
    </audio>

    <button id="music-btn" onclick="toggleMusic()" aria-label="Putar musik" class="hidden fixed bottom-5 right-5 z-50 w-12 h-12 rounded-full bg-luxury-gold text-luxury-black flex items-center justify-center shadow-2xl border border-white/20 transition hover:scale-110">
        <svg id="music-icon" class="w-5 h-5" viewBox="0 0 24 24">
            <path class="icon-line" d="M9 18V5l10-2v13"></path>
            <circle class="icon-line" cx="6" cy="18" r="3"></circle>
            <circle class="icon-line" cx="16" cy="16" r="3"></circle>
        </svg>
    </button>
    @endif

    <!-- HERO COVER -->
    <section id="hero-cover" class="fixed inset-0 z-50 h-[100dvh] bg-luxury-black text-white flex items-center justify-center transition-all duration-1000 overflow-y-auto">
        <div class="absolute inset-0">
            @if($invitation->cover_image)
            <img src="{{ Storage::url($invitation->cover_image) }}" class="w-full h-full object-cover opacity-40" alt="Wedding Cover">
            @else
            <div class="w-full h-full bg-[#15130F]"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-black/90"></div>
        </div>

        <div class="relative z-10 text-center px-5 sm:px-6 max-w-3xl py-10">
            <p class="uppercase tracking-[0.3em] sm:tracking-[0.35em] text-[10px] sm:text-xs md:text-sm text-luxury-lightGold mb-3 sm:mb-4 animate-gentle-pulse">
                The Wedding Of
            </p>

            <h1 class="font-script leading-tight break-words text-luxury-lightGold my-2" style="font-size: clamp(2.75rem, 12vw, 6.5rem);">
                {{ $invitation->bride_nickname }} & {{ $invitation->groom_nickname }}
            </h1>

            <div class="flex items-center justify-center gap-4 my-4">
                <div class="w-12 sm:w-16 h-px bg-luxury-gold"></div>
                <span class="flourish text-luxury-lightGold">
                    <svg viewBox="0 0 24 24" class="w-4 h-4">
                        <path class="icon-line" d="M12 2v20M2 12h20" transform="rotate(45 12 12)"></path>
                    </svg>
                </span>
                <div class="w-12 sm:w-16 h-px bg-luxury-gold"></div>
            </div>

            <p class="font-serif text-base sm:text-lg md:text-xl text-white/90 mb-6 sm:mb-8">
                @if($invitation->events->first())
                {{ \Carbon\Carbon::parse($invitation->events->first()->start_time)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                @endif
            </p>

            <div class="glass border border-luxury-gold/40 p-4 sm:p-5 rounded-lg max-w-md mx-auto my-5 sm:my-6 text-center backdrop-blur-md">
                <p class="text-[10px] sm:text-[11px] uppercase tracking-[0.2em] text-luxury-lightGold mb-1">Kepada Yth.</p>
                <p class="font-serif text-lg sm:text-xl font-bold text-white tracking-wide break-words">{{ $guestName }}</p>
                <p class="text-xs text-white/60 mt-1 italic">Di Tempat</p>
            </div>

            <button onclick="openInvitation()" class="mt-2 sm:mt-4 inline-flex items-center gap-2.5 px-6 sm:px-8 py-3.5 sm:py-4 border border-luxury-gold text-luxury-lightGold uppercase tracking-[0.2em] text-xs hover:bg-luxury-gold hover:text-luxury-black transition duration-300 shadow-lg">
                <svg viewBox="0 0 24 24" class="w-4 h-4 shrink-0">
                    <path class="icon-line" d="M3 6h18v12H3z"></path>
                    <path class="icon-line" d="M3 7l9 6 9-6"></path>
                </svg>
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main id="main-content">

        <!-- INVITATION HEADER -->
        <section class="relative overflow-hidden bg-[#FAF8F5] py-20 px-4 text-center sm:px-6 sm:py-28">
            <div class="pointer-events-none absolute -top-12 -left-12 h-48 w-48 rounded-full bg-[#D4AF37]/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-12 -right-12 h-56 w-56 rounded-full bg-[#D4AF37]/10 blur-3xl"></div>

            <div class="relative z-10 mx-auto max-w-4xl" data-aos="fade-up">
                <div class="group relative mb-12 inline-block w-full max-w-md transition-transform duration-500 hover:-translate-y-2 sm:mb-16">
                    <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-r from-[#BF953F] via-[#FCF6BA] to-[#AA771C] opacity-70 blur-[3px] transition duration-500 group-hover:opacity-100"></div>
                    <div class="relative rounded-2xl border border-[#D4AF37]/40 bg-white/80 p-6 shadow-xl backdrop-blur-md transition-all duration-300 sm:p-8">
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-[#D4AF37]/40 bg-[#FAF8F5] px-3.5 py-1">
                            <span class="h-2 w-2 animate-ping rounded-full bg-[#B38728]"></span>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#B38728] sm:text-xs">Kepada Yth.</p>
                        </div>
                        <h3 class="my-2 font-serif text-2xl font-bold tracking-wide text-gray-900 break-words sm:text-4xl">
                            {{ $guestName }}
                            <p class="text-xs text-gray-600/60 mt-1 italic">Di Tempat</p>
                        </h3>
                        <div class="my-3 flex items-center justify-center gap-2 opacity-70">
                            <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-[#B38728]"></div>
                            <div class="h-1.5 w-1.5 rotate-45 bg-[#B38728]"></div>
                            <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-[#B38728]"></div>
                        </div>
                        <p class="text-xs font-light text-gray-500">Kami Mengundang Anda Untuk Hadir Di Acara Pernikahan Kami</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="font-serif italic text-lg text-[#B38728] sm:text-xl">Assalamu'alaikum Warahmatullahi Wabarakatuh</p>
                    <h2 class="font-serif text-2xl font-normal leading-snug text-gray-900 sm:text-4xl md:text-5xl">Dengan Memohon Rahmat & Ridho Allah SWT</h2>
                    <div class="my-6 flex items-center justify-center gap-3">
                        <span class="h-[1px] w-16 bg-[#D4AF37]/40"></span>
                        <span class="text-xs text-[#D4AF37]">❖</span>
                        <span class="h-[1px] w-16 bg-[#D4AF37]/40"></span>
                    </div>
                    <p class="mx-auto max-w-2xl px-2 text-sm font-light leading-relaxed text-gray-600 sm:text-base sm:leading-8">
                        Dengan penuh rasa syukur dan bahagia, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada acara pernikahan kami.
                    </p>
                </div>
            </div>
        </section>

        <!-- COUPLE SECTION -->
        <section class="relative overflow-hidden bg-[#FAF8F5] py-20 px-4 sm:px-6 sm:py-28">
            <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[500px] w-[500px] rounded-full bg-[#D4AF37]/5 blur-3xl"></div>

            <div class="relative z-10 mx-auto max-w-5xl">
                <div class="mb-14 text-center sm:mb-20" data-aos="fade-up">
                    <div class="mb-3 flex items-center justify-center gap-3">
                        <span class="h-[1px] w-12 bg-gradient-to-r from-transparent to-[#B38728]"></span>
                        <span class="text-[#B38728]"><svg viewBox="0 0 24 24" class="h-5 w-5 fill-[#B38728]/20 stroke-[#B38728] stroke-2">
                                <path d="M12 21s-7-4.35-9.5-8.5C.7 8.9 2.3 5 6 5c2 0 3.5 1.2 6 4 2.5-2.8 4-4 6-4 3.7 0 5.3 3.9 3.5 7.5C19 16.65 12 21 12 21z"></path>
                            </svg></span>
                        <span class="h-[1px] w-12 bg-gradient-to-l from-transparent to-[#B38728]"></span>
                    </div>
                    <h2 class="font-serif text-3xl font-bold tracking-wide text-gray-900 sm:text-5xl">Mempelai</h2>
                    <p class="mt-2 font-serif italic text-sm text-[#B38728] sm:text-base">Maha Suci Allah yang telah menciptakan pasangan-pasangan</p>
                </div>

                <div class="grid items-center gap-12 md:grid-cols-11 md:gap-6">

                    <!-- Mempelai Pria -->
                    <div class="group text-center md:col-span-5 md:text-right" data-aos="fade-right">
                        <div class="relative mx-auto mb-6 max-w-xs md:mr-0 md:ml-auto">
                            <div class="absolute -inset-2.5 rotate-2 rounded-2xl border border-[#D4AF37]/40 transition-transform duration-500 group-hover:rotate-0 group-hover:scale-105"></div>
                            <div class="relative flex aspect-[4/5] w-full items-center justify-center rounded-xl bg-gradient-to-br from-white via-[#FAF8F5] to-[#F3EFE6] p-6 shadow-xl border border-[#D4AF37]/30 overflow-hidden">
                                <div class="text-center">
                                    <span class="font-serif text-6xl sm:text-7xl font-bold text-[#B38728] block">{{ substr($invitation->groom_nickname, 0, 1) }}</span>
                                    <span class="font-serif text-sm tracking-[0.2em] text-[#BF953F] uppercase mt-2 block">{{ $invitation->groom_fullname }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-serif text-2xl font-bold tracking-wide text-gray-900 sm:text-3xl">{{ $invitation->groom_fullname }}</h3>
                            <div class="my-2 flex items-center justify-center md:justify-end gap-2 opacity-60">
                                <span class="h-[1px] w-8 bg-[#B38728]"></span>
                                <span class="h-1 w-1 rotate-45 bg-[#B38728]"></span>
                            </div>
                            <p class="text-xs leading-relaxed text-gray-600 sm:text-sm">
                                Putra dari<br>
                                <strong class="font-medium text-gray-800">Bpk. {{ $invitation->groom_father }}</strong> & <strong class="font-medium text-gray-800">Ibu {{ $invitation->groom_mother }}</strong>
                            </p>
                        </div>
                    </div>

                    <!-- Ampersand -->
                    <div class="flex items-center justify-center md:col-span-1" data-aos="zoom-in">
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-full border border-[#D4AF37]/40 bg-white shadow-md backdrop-blur-sm">
                            <span class="font-serif text-2xl font-bold italic text-[#B38728]">&</span>
                        </div>
                    </div>

                    <!-- Mempelai Wanita -->
                    <div class="group text-center md:col-span-5 md:text-left" data-aos="fade-left">
                        <div class="relative mx-auto mb-6 max-w-xs md:ml-0 md:mr-auto">
                            <div class="absolute -inset-2.5 -rotate-2 rounded-2xl border border-[#D4AF37]/40 transition-transform duration-500 group-hover:rotate-0 group-hover:scale-105"></div>
                            <div class="relative flex aspect-[4/5] w-full items-center justify-center rounded-xl bg-gradient-to-br from-white via-[#FAF8F5] to-[#F3EFE6] p-6 shadow-xl border border-[#D4AF37]/30 overflow-hidden">
                                <div class="text-center">
                                    <span class="font-serif text-6xl sm:text-7xl font-bold text-[#B38728] block">{{ substr($invitation->bride_nickname, 0, 1) }}</span>
                                    <span class="font-serif text-sm tracking-[0.2em] text-[#BF953F] uppercase mt-2 block">{{ $invitation->bride_fullname }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-serif text-2xl font-bold tracking-wide text-gray-900 sm:text-3xl">{{ $invitation->bride_fullname }}</h3>
                            <div class="my-2 flex items-center justify-center md:justify-start gap-2 opacity-60">
                                <span class="h-1 w-1 rotate-45 bg-[#B38728]"></span>
                                <span class="h-[1px] w-8 bg-[#B38728]"></span>
                            </div>
                            <p class="text-xs leading-relaxed text-gray-600 sm:text-sm">
                                Putri dari<br>
                                <strong class="font-medium text-gray-800">Bpk. {{ $invitation->bride_father }}</strong> & <strong class="font-medium text-gray-800">Ibu {{ $invitation->bride_mother }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- COUNTDOWN SECTION -->
        <section class="relative overflow-hidden bg-[#0D0D0D] py-16 px-4 text-white sm:px-6 sm:py-24">
            <div class="pointer-events-none absolute top-1/2 left-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#D4AF37]/10 blur-[100px]"></div>

            <div class="relative z-10 mx-auto max-w-4xl text-center" data-aos="fade-up">
                <p class="font-serif italic text-base text-[#D4AF37] sm:text-lg">Save the Date</p>
                <h2 class="mt-2 font-serif text-3xl font-normal tracking-wide text-white sm:text-5xl">Menuju Hari Bahagia</h2>
                <div class="my-6 flex items-center justify-center gap-3">
                    <span class="h-[1px] w-12 bg-gradient-to-r from-transparent to-[#D4AF37]"></span>
                    <span class="text-xs text-[#D4AF37]">❖</span>
                    <span class="h-[1px] w-12 bg-gradient-to-l from-transparent to-[#D4AF37]"></span>
                </div>

                <div id="countdown" class="mx-auto mt-8 grid max-w-xs grid-cols-2 gap-4 sm:max-w-3xl sm:grid-cols-4 sm:gap-6">
                    @foreach(['Hari' => 'days', 'Jam' => 'hours', 'Menit' => 'minutes', 'Detik' => 'seconds'] as $label => $id)
                    <div class="group relative rounded-2xl border border-[#D4AF37]/30 bg-white/5 p-4 shadow-2xl backdrop-blur-md transition-all duration-300 hover:-translate-y-1.5 hover:border-[#D4AF37]/70 hover:shadow-[#D4AF37]/10 sm:p-6">
                        <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-b from-[#D4AF37]/20 to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                        <div class="relative">
                            <div id="{{ $id }}" class="font-serif text-3xl font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-[#FFF6CD] via-[#D4AF37] to-[#AA771C] sm:text-5xl md:text-6xl">00</div>
                            <p class="mt-2 text-[10px] font-medium uppercase tracking-[0.2em] text-gray-400 sm:text-xs">{{ $label }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- EVENT & LOCATION SECTION -->
        <section class="relative overflow-hidden bg-[#FAF8F5] py-16 px-4 text-gray-800 sm:px-6 sm:py-24">
            <div class="pointer-events-none absolute -top-10 left-1/2 h-80 w-80 -translate-x-1/2 rounded-full bg-[#D4AF37]/10 blur-[120px]"></div>

            <div class="relative z-10 mx-auto max-w-5xl">
                <div class="mb-12 text-center sm:mb-16" data-aos="fade-up">
                    <div class="mb-3 flex items-center justify-center gap-3">
                        <span class="h-[1px] w-10 bg-gradient-to-r from-transparent to-[#B38728]"></span>
                        <span class="text-xs text-[#B38728]">❖</span>
                        <span class="h-[1px] w-10 bg-gradient-to-l from-transparent to-[#B38728]"></span>
                    </div>
                    <p class="font-serif italic text-base text-[#B38728] sm:text-lg">Lokasi Acara</p>
                    <h2 class="mt-1 font-serif text-3xl font-normal tracking-wide text-gray-900 sm:text-4xl md:text-5xl">Waktu & Tempat</h2>
                </div>

                <!-- EVENT CARDS LOOP -->
                <div class="mb-10 grid gap-6 sm:mb-12 md:grid-cols-2 sm:gap-8">
                    @foreach($invitation->events as $event)
                    <div class="group relative rounded-2xl border border-[#D4AF37]/30 bg-white/90 p-6 text-center shadow-xl backdrop-blur-md transition-all duration-500 hover:-translate-y-2 hover:border-[#D4AF37] hover:shadow-2xl sm:p-8" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="absolute inset-x-0 top-0 h-1.5 rounded-t-2xl bg-gradient-to-r from-[#BF953F] via-[#FCF6BA] to-[#AA771C]"></div>

                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#FAF8F5] border border-[#D4AF37]/40 shadow-inner group-hover:scale-110 transition duration-300">
                            <svg class="h-6 w-6 text-[#B38728]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        </div>

                        <h3 class="font-serif text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $event->name }}</h3>

                        <div class="my-4 flex items-center justify-center gap-2">
                            <span class="h-[1px] w-8 bg-[#D4AF37]/50"></span>
                            <span class="h-1.5 w-1.5 rotate-45 bg-[#B38728]"></span>
                            <span class="h-[1px] w-8 bg-[#D4AF37]/50"></span>
                        </div>

                        <!-- Parsing Hari dalam Bahasa Indonesia -->
                        <p class="font-medium text-gray-900 sm:text-base">
                            {{ \Carbon\Carbon::parse($event->start_time)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </p>
                        <p class="mt-1 text-sm font-medium text-[#B38728]">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} -
                            @if($event->end_time) {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} @else Selesai @endif
                            {{ $event->timezone }}
                        </p>

                        <p class="mt-4 text-xs leading-relaxed text-gray-600 sm:text-sm">
                            <span class="font-semibold text-gray-800">{{ $event->location_name }}</span><br>
                            {{ $event->location_address }}
                        </p>

                        @if($event->google_maps_url)
                        <div class="mt-6">
                            <a href="{{ $event->google_maps_url }}" target="_blank" class="group inline-flex items-center justify-center gap-2.5 rounded-xl bg-gradient-to-r from-[#1A1A1A] to-[#2D2D2D] px-6 py-3 text-[11px] font-semibold uppercase tracking-widest text-[#FFF6CD] shadow-lg transition-all duration-300 hover:from-[#B38728] hover:to-[#AA771C] hover:text-white">
                                <svg class="h-4 w-4 shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Buka Maps
                            </a>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- DOA & QUOTE SECTION -->
        <section class="relative overflow-hidden bg-white py-16 px-4 text-center sm:px-6 sm:py-24">
            <div class="pointer-events-none absolute top-1/2 left-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#D4AF37]/10 blur-[100px]"></div>

            <div class="relative z-10 mx-auto max-w-3xl" data-aos="zoom-in">
                <div class="mb-10 text-center sm:mb-12">
                    <div class="mb-3 flex items-center justify-center gap-3">
                        <span class="h-[1px] w-10 bg-gradient-to-r from-transparent to-[#B38728]"></span>
                        <span class="text-xs text-[#B38728]">❖</span>
                        <span class="h-[1px] w-10 bg-gradient-to-l from-transparent to-[#B38728]"></span>
                    </div>
                    <p class="font-serif italic text-base text-[#B38728] sm:text-lg">Doa Restu</p>
                    <h2 class="mt-1 font-serif text-3xl font-normal tracking-wide text-gray-900 sm:text-4xl md:text-5xl">Ungkapan Suci</h2>
                </div>

                <div class="group relative rounded-2xl border border-[#D4AF37]/30 bg-[#FAF8F5]/80 p-6 shadow-xl backdrop-blur-md transition-all duration-500 hover:border-[#D4AF37]/60 hover:shadow-2xl sm:p-10">
                    <div class="mx-auto mb-6 flex h-12 w-12 items-center justify-center rounded-full border border-[#D4AF37]/40 bg-white shadow-sm">
                        <svg class="h-5 w-5 text-[#B38728]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                    </div>

                    <!-- Teks Arab dengan Font Kaligrafi Amiri -->
                    <p dir="rtl" lang="ar" class="font-arabic text-3xl leading-[2.2] text-gray-900 sm:text-4xl sm:leading-[2.4] md:text-5xl md:leading-[2.5] drop-shadow-sm">
                        وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَٰجًا لِّتَسْكُنُوٓا۟ إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً ۚ إِنَّ فِى ذَٰلِكَ لَـَٔايَـٰتٍ لِّقَوْمٍ يَتَفَكَّرُونَ
                    </p>

                    <div class="my-6 flex items-center justify-center gap-3 opacity-70">
                        <div class="h-[1px] w-16 bg-gradient-to-r from-transparent to-[#B38728]"></div>
                        <div class="h-1.5 w-1.5 rotate-45 bg-[#B38728]"></div>
                        <div class="h-[1px] w-16 bg-gradient-to-l from-transparent to-[#B38728]"></div>
                    </div>

                    <p class="mx-auto max-w-xl text-xs font-light leading-relaxed text-gray-600 sm:text-sm sm:leading-loose">
                        {{ $invitation->quote ?? '"Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri..."' }}
                    </p>

                    <div class="mt-6 inline-block rounded-full border border-[#D4AF37]/40 bg-white px-4 py-1.5 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#B38728] sm:text-xs">QS. Ar-Rum : 21</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- RSVP & WISHES SECTION -->
        <section class="relative overflow-hidden bg-[#0D0D0D] py-16 px-4 text-white sm:px-6 sm:py-24">
            <div class="pointer-events-none absolute top-1/2 left-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#D4AF37]/10 blur-[130px]"></div>

            <div class="relative z-10 mx-auto max-w-3xl" data-aos="fade-up">
                <div class="mb-10 text-center sm:mb-12">
                    <p class="font-serif italic text-base text-[#D4AF37] sm:text-lg">RSVP & Ucapan</p>
                    <h2 class="mt-1 font-serif text-3xl font-normal tracking-wide text-white sm:text-4xl md:text-5xl">Konfirmasi Kehadiran</h2>
                    <div class="my-5 flex items-center justify-center gap-3">
                        <span class="h-[1px] w-12 bg-gradient-to-r from-transparent to-[#D4AF37]"></span>
                        <span class="text-xs text-[#D4AF37]">❖</span>
                        <span class="h-[1px] w-12 bg-gradient-to-l from-transparent to-[#D4AF37]"></span>
                    </div>
                    <p class="mx-auto max-w-md text-xs font-light leading-relaxed text-gray-400 sm:text-sm">
                        Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.
                    </p>
                </div>

                <!-- RSVP FORM CARD -->
                <div class="rounded-2xl border border-[#D4AF37]/30 bg-white/5 p-6 shadow-2xl backdrop-blur-md sm:p-10">
                    <form id="rsvpForm" onsubmit="submitRsvp(event)" class="space-y-5 text-left">

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-[#FFF6CD] sm:text-xs">Nama Lengkap</label>
                            <input id="guest_name" value="{{ $guestName }}" type="text" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3.5 text-sm text-white placeholder-gray-500 shadow-inner outline-none transition duration-300 focus:border-[#D4AF37] focus:bg-white/10 focus:ring-1 focus:ring-[#D4AF37]">
                        </div>

                        <!-- Konfirmasi Kehadiran -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-[#FFF6CD] sm:text-xs">Kehadiran</label>
                                <div class="relative mt-2">
                                    <select id="attendance" required class="w-full appearance-none rounded-xl border border-white/10 bg-[#1A1A1A] px-4 py-3.5 text-sm text-white outline-none transition duration-300 focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]">
                                        <option value="hadir">✓ Hadir</option>
                                        <option value="tidak_hadir">✕ Tidak Hadir</option>
                                        <option value="ragu">? Mungkin Hadir</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#D4AF37]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Tambahan Field Jumlah Orang -->
                            <div>
                                <label class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-[#FFF6CD] sm:text-xs">Jumlah Orang</label>
                                <input id="guest_count" type="number" min="1" value="1" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3.5 text-sm text-white placeholder-gray-500 shadow-inner outline-none transition duration-300 focus:border-[#D4AF37] focus:bg-white/10 focus:ring-1 focus:ring-[#D4AF37]">
                            </div>
                        </div>

                        <!-- Pesan / Ucapan -->
                        <div>
                            <label class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-[#FFF6CD] sm:text-xs">Pesan atau Ucapan</label>
                            <textarea id="message" rows="4" required placeholder="Tuliskan doa restu dan ucapan hangat Anda..." class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3.5 text-sm text-white placeholder-gray-500 shadow-inner outline-none transition duration-300 focus:border-[#D4AF37] focus:bg-white/10 focus:ring-1 focus:ring-[#D4AF37]"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="group relative mt-2 w-full overflow-hidden rounded-xl bg-gradient-to-r from-[#BF953F] via-[#FCF6BA] to-[#AA771C] py-4 text-xs font-bold uppercase tracking-[0.25em] text-[#111] shadow-lg transition-all duration-300 hover:shadow-[#D4AF37]/20 active:scale-[0.99]">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <span>Kirim Konfirmasi & Ucapan</span>
                                <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- GIFT SECTION (BANK ACCORDION) -->
        <section class="relative overflow-hidden bg-[#FAF8F5] py-16 px-4 text-gray-800 sm:px-6 sm:py-24">
            <div class="pointer-events-none absolute -top-10 left-1/2 h-80 w-80 -translate-x-1/2 rounded-full bg-[#D4AF37]/10 blur-[120px]"></div>

            <div class="relative z-10 mx-auto max-w-2xl text-center" data-aos="fade-up">
                <div class="mb-8 sm:mb-10">
                    <div class="mb-3 flex items-center justify-center gap-3">
                        <span class="h-[1px] w-10 bg-gradient-to-r from-transparent to-[#B38728]"></span>
                        <span class="text-xs text-[#B38728]">❖</span>
                        <span class="h-[1px] w-10 bg-gradient-to-l from-transparent to-[#B38728]"></span>
                    </div>
                    <p class="font-serif italic text-base text-[#B38728] sm:text-lg">Tanda Kasih</p>
                    <h2 class="mt-1 font-serif text-3xl font-normal tracking-wide text-gray-900 sm:text-4xl md:text-5xl">Wedding Gift</h2>
                    <p class="mx-auto mt-4 max-w-md text-xs font-light leading-relaxed text-gray-600 sm:text-sm">
                        Doa restu Anda merupakan hadiah terindah bagi kami. Namun apabila ingin memberikan tanda kasih, dapat melalui informasi di bawah ini.
                    </p>
                </div>

                <div class="overflow-hidden rounded-2xl border border-[#D4AF37]/40 bg-white/90 shadow-xl backdrop-blur-md text-left transition-all">
                    <details class="group" open>
                        <summary class="flex cursor-pointer select-none items-center justify-between gap-3 p-5 sm:p-6 transition hover:bg-[#FAF8F5]">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#FAF8F5] border border-[#D4AF37]/40 text-[#B38728] shadow-inner">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect x="2" y="5" width="20" height="14" rx="2" />
                                        <line x1="2" y1="10" x2="22" y2="10" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-serif text-base font-bold text-gray-900 sm:text-xl">Amplop Digital & Transfer Bank</h3>
                                    <p class="text-xs text-gray-500">Klik untuk melihat detail nomor rekening</p>
                                </div>
                            </div>
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100 text-[#B38728] transition duration-300 group-open:rotate-180">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </summary>

                        <div class="space-y-4 border-t border-[#D4AF37]/20 p-4 sm:p-6">
                            <!-- LOOPING GIFT DARI DATABASE -->
                            @foreach($invitation->gifts as $gift)
                            <div class="group relative rounded-xl border border-gray-100 bg-white p-4 shadow-sm transition-all duration-300 hover:border-[#D4AF37]/60 hover:shadow-md sm:flex sm:items-center sm:justify-between sm:p-5">
                                <div class="min-w-0">
                                    <span class="inline-block rounded-md bg-[#FAF8F5] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#B38728] border border-[#D4AF37]/30">
                                        {{ $gift->provider_name }}
                                    </span>
                                    <p class="mt-1 font-mono text-xl font-bold tracking-wider text-gray-900 sm:text-2xl">{{ $gift->account_number }}</p>
                                    <p class="text-xs font-light text-gray-500">a.n. {{ $gift->account_name }}</p>
                                </div>
                                <button onclick="copyAccount('{{ $gift->account_number }}', this)" class="mt-3 inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#1A1A1A] to-[#2D2D2D] px-5 py-2.5 text-xs font-semibold uppercase tracking-widest text-[#FFF6CD] shadow transition-all duration-300 hover:from-[#B38728] hover:to-[#AA771C] hover:text-white sm:mt-0 sm:w-auto">
                                    <svg class="h-4 w-4 shrink-0 copy-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="9" y="9" width="13" height="13" rx="2" />
                                        <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" />
                                    </svg>
                                    <span class="btn-text">Salin No. Rek</span>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </details>
                </div>
            </div>
        </section>

        <!-- CLOSING SECTION -->
        <section class="relative overflow-hidden bg-[#0D0D0D] py-24 px-4 text-center text-white sm:px-6 sm:py-32">
            <div class="absolute inset-0 z-0 opacity-20">
                @if($invitation->cover_image)
                <img src="{{ Storage::url($invitation->cover_image) }}" class="h-full w-full object-cover grayscale" alt="Closing Background">
                @else
                <div class="h-full w-full bg-[#15130F]"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-transparent to-[#0D0D0D]"></div>
            </div>
            <div class="pointer-events-none absolute top-1/2 left-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#D4AF37]/15 blur-[140px]"></div>

            <div class="relative z-10 mx-auto max-w-3xl" data-aos="zoom-in">
                <h1 class="font-serif text-4xl font-normal tracking-wide text-transparent bg-clip-text bg-gradient-to-b from-[#FFF6CD] via-[#D4AF37] to-[#AA771C] sm:text-6xl md:text-7xl">
                    {{ $invitation->bride_nickname }} & {{ $invitation->groom_nickname }}
                </h1>
                <p class="mt-6 font-serif text-base font-light text-gray-300 sm:text-xl">Terima kasih atas doa, restu, dan kehadiran Anda.</p>
                <div class="my-8 flex items-center justify-center gap-4">
                    <span class="h-[1px] w-12 bg-gradient-to-r from-transparent to-[#D4AF37] sm:w-20"></span>
                    <span class="text-sm text-[#D4AF37]">❖</span>
                    <span class="h-[1px] w-12 bg-gradient-to-l from-transparent to-[#D4AF37] sm:w-20"></span>
                </div>
                <p class="text-[11px] font-light tracking-widest text-gray-500 uppercase">
                    © {{ date('Y') }} {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} Wedding
                </p>
            </div>
        </section>

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Init Animasi AOS
        AOS.init({
            duration: window.innerWidth < 640 ? 700 : 1000,
            once: true,
            offset: 80
        });

        // Data Ekstraksi dari HTML
        const appData = document.getElementById("app-data");
        const urlRsvp = appData.getAttribute("data-rsvp-url");
        const eventDateString = appData.getAttribute("data-event-date");

        // Audio Handler
        const bgMusic = document.getElementById("bg-music");
        const musicBtn = document.getElementById("music-btn");
        let isPlaying = false;
        let invitationOpened = false;

        function openInvitation() {
            if (invitationOpened) return;
            invitationOpened = true;

            document.getElementById("body").classList.remove("overflow-y-hidden");
            const cover = document.getElementById("hero-cover");
            cover.classList.add("-translate-y-full", "opacity-0");
            setTimeout(() => {
                cover.style.display = "none";
            }, 1000);

            if (bgMusic) {
                bgMusic.play().then(() => {
                    isPlaying = true;
                    if (musicBtn) musicBtn.classList.remove("hidden");
                    musicBtn.classList.add("animate-fade-in");
                }).catch(e => console.log("Autoplay ditahan browser"));
            }
            document.getElementById("main-content")?.scrollIntoView({
                behavior: 'smooth'
            });
        }

        function toggleMusic() {
            if (!bgMusic) return;
            isPlaying ? bgMusic.pause() : bgMusic.play();
            isPlaying = !isPlaying;
        }

        // Countdown Timer Dinamis
        if (eventDateString) {
            const targetDate = new Date(eventDateString).getTime();
            setInterval(() => {
                const now = new Date().getTime();
                const diff = targetDate - now;

                if (diff <= 0) {
                    document.getElementById("days").innerText = "00";
                    document.getElementById("hours").innerText = "00";
                    document.getElementById("minutes").innerText = "00";
                    document.getElementById("seconds").innerText = "00";
                    return;
                }

                document.getElementById("days").innerText = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                document.getElementById("hours").innerText = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                document.getElementById("minutes").innerText = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                document.getElementById("seconds").innerText = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
            }, 1000);
        }

        // Fetch API - SweetAlert2 RSVP
        async function submitRsvp(e) {
            e.preventDefault();
            const payload = {
                guest_name: document.getElementById('guest_name').value,
                attendance: document.getElementById('attendance').value,
                guest_count: document.getElementById('guest_count').value,
                message: document.getElementById('message').value
            };

            try {
                const response = await fetch(urlRsvp, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    document.getElementById('rsvpForm').reset();
                    Swal.fire({
                        title: 'Terkirim!',
                        text: 'Terima kasih atas doa dan konfirmasinya.',
                        icon: 'success',
                        confirmButtonColor: '#AD8A54',
                        customClass: {
                            popup: 'swal-mobile-sm'
                        }
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengirim RSVP. Pastikan koneksi stabil.',
                    icon: 'error',
                    customClass: {
                        popup: 'swal-mobile-sm'
                    }
                });
            }
        }

        // Copy Rekening UI Handler & SweetAlert2
        function copyAccount(accountNumber, button) {
            navigator.clipboard.writeText(accountNumber).then(() => {
                const btnText = button.querySelector('.btn-text');
                const originalText = btnText.textContent;

                btnText.textContent = 'Tersalin! ✓';
                button.classList.add('bg-emerald-600', 'text-white');

                setTimeout(() => {
                    btnText.textContent = originalText;
                    button.classList.remove('bg-emerald-600', 'text-white');
                }, 2000);

                Swal.fire({
                    title: 'Tersalin',
                    text: 'Nomor rekening berhasil disalin!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal-mobile-sm'
                    }
                });
            }).catch(err => console.error('Gagal menyalin:', err));
        }
    </script>
</body>

</html>