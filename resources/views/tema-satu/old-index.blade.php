<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wedding Invitation {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</title>

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

    <!-- Google Fonts & AOS -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- SweetAlert2 -->
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

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
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

    <!-- DATA BINDING: Menyimpan variabel PHP di HTML agar aman dibaca JavaScript -->
    <div id="app-data" class="hidden"
        data-rsvp-url="{{ route('rsvp.store', $invitation->slug) }}"
        data-event-date="{{ $invitation->events->first() ? $invitation->events->first()->start_time : '' }}">
    </div>

    <!-- Audio Player: Hanya tampil jika klien memiliki file musik -->
    @if($invitation->background_music)
    <audio id="bg-music" loop preload="none">
        <source src="{{ asset('storage/klien/' . $invitation->background_music) }}" type="audio/mpeg">
    </audio>

    <button id="music-btn" onclick="toggleMusic()" class="hidden fixed bottom-5 right-5 z-50 w-11 h-11 rounded-full bg-luxury-gold text-white flex items-center justify-center shadow-2xl transition hover:scale-110">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18V5l10-2v13M6 18a3 3 0 100-6 3 3 0 000 6zm10-2a3 3 0 100-6 3 3 0 000 6z"></path>
        </svg>
    </button>
    @endif

    <button id="music-btn" onclick="toggleMusic()" class="hidden fixed bottom-5 right-5 z-50 w-11 h-11 rounded-full bg-luxury-gold text-white flex items-center justify-center shadow-2xl transition hover:scale-110">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18V5l10-2v13M6 18a3 3 0 100-6 3 3 0 000 6zm10-2a3 3 0 100-6 3 3 0 000 6z"></path>
        </svg>
    </button>

    <!-- HERO COVER -->
    <section id="hero-cover" class="fixed inset-0 z-50 h-[100dvh] bg-luxury-black text-white flex items-center justify-center transition-all duration-1000 overflow-y-auto">
        <div class="absolute inset-0">
            @if($invitation->cover_image)
            <!-- Menggunakan Storage::url untuk gambar cover -->
            <img src="{{ Storage::url($invitation->cover_image) }}" class="w-full h-full object-cover opacity-40" alt="Cover">
            @else
            <div class="w-full h-full bg-[#15130F]"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-black/90"></div>
        </div>

        <div class="relative z-10 text-center px-5 py-10">
            <p class="uppercase tracking-[0.3em] text-[10px] text-luxury-lightGold mb-3 animate-gentle-pulse">The Wedding Of</p>
            <h1 class="font-script leading-tight text-luxury-lightGold my-2" style="font-size: clamp(2.75rem, 12vw, 6.5rem);">
                {{ $invitation->bride_nickname }} & {{ $invitation->groom_nickname }}
            </h1>

            <div class="glass border border-luxury-gold/40 p-5 rounded-lg max-w-md mx-auto my-6 text-center backdrop-blur-md">
                <p class="text-[11px] uppercase tracking-[0.2em] text-luxury-lightGold mb-1">Kepada Yth.</p>
                <p class="font-serif text-xl font-bold text-white">{{ $guestName }}</p>
                <p class="text-xs text-white/60 mt-1 italic">Di Tempat</p>
            </div>

            <button onclick="openInvitation()" class="mt-4 inline-flex items-center gap-2.5 px-8 py-4 border border-luxury-gold text-luxury-lightGold uppercase tracking-[0.2em] text-xs hover:bg-luxury-gold hover:text-luxury-black transition duration-300">
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main id="main-content">
        <!-- COUPLE SECTION -->
        <section class="relative overflow-hidden bg-[#FAF8F5] py-20 px-4">
            <div class="relative z-10 mx-auto max-w-5xl text-center">
                <h2 class="font-serif text-3xl font-bold text-gray-900 sm:text-5xl" data-aos="fade-up">Mempelai</h2>
                <div class="grid items-center gap-12 mt-12 md:grid-cols-11">

                    <div class="md:col-span-5 md:text-right" data-aos="fade-right">
                        <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $invitation->groom_fullname }}</h3>
                        <p class="text-xs text-gray-600 mt-2">Putra dari<br><strong>Bpk. {{ $invitation->groom_father }}</strong> & <strong>Ibu {{ $invitation->groom_mother }}</strong></p>
                    </div>

                    <div class="md:col-span-1 flex justify-center"><span class="font-serif text-3xl italic text-[#B38728]">&</span></div>

                    <div class="md:col-span-5 md:text-left" data-aos="fade-left">
                        <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $invitation->bride_fullname }}</h3>
                        <p class="text-xs text-gray-600 mt-2">Putri dari<br><strong>Bpk. {{ $invitation->bride_father }}</strong> & <strong>Ibu {{ $invitation->bride_mother }}</strong></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- COUNTDOWN SECTION -->
        <section class="bg-[#0D0D0D] py-16 px-4 text-white text-center">
            <h2 class="font-serif text-3xl text-white">Menuju Hari Bahagia</h2>
            <div id="countdown-container" class="mx-auto mt-8 grid max-w-3xl grid-cols-4 gap-4">
                <div class="rounded-2xl border border-[#D4AF37]/30 bg-white/5 p-4 backdrop-blur-md">
                    <div id="timer-days" class="font-serif text-3xl font-bold text-[#D4AF37]">00</div>
                    <p class="text-[10px] uppercase tracking-[0.2em] mt-2">Hari</p>
                </div>
                <div class="rounded-2xl border border-[#D4AF37]/30 bg-white/5 p-4 backdrop-blur-md">
                    <div id="timer-hours" class="font-serif text-3xl font-bold text-[#D4AF37]">00</div>
                    <p class="text-[10px] uppercase tracking-[0.2em] mt-2">Jam</p>
                </div>
                <div class="rounded-2xl border border-[#D4AF37]/30 bg-white/5 p-4 backdrop-blur-md">
                    <div id="timer-minutes" class="font-serif text-3xl font-bold text-[#D4AF37]">00</div>
                    <p class="text-[10px] uppercase tracking-[0.2em] mt-2">Menit</p>
                </div>
                <div class="rounded-2xl border border-[#D4AF37]/30 bg-white/5 p-4 backdrop-blur-md">
                    <div id="timer-seconds" class="font-serif text-3xl font-bold text-[#D4AF37]">00</div>
                    <p class="text-[10px] uppercase tracking-[0.2em] mt-2">Detik</p>
                </div>
            </div>
        </section>

        <!-- EVENT SECTION -->
        <section class="bg-[#FAF8F5] py-16 px-4 text-center">
            <h2 class="font-serif text-3xl text-gray-900 mb-10">Waktu & Tempat</h2>
            <div class="grid gap-6 md:grid-cols-2 max-w-4xl mx-auto">
                @foreach($invitation->events as $event)
                <div class="rounded-2xl border border-[#D4AF37]/30 bg-white p-6 shadow-xl" data-aos="fade-up">
                    <h3 class="font-serif text-2xl font-bold text-gray-900">{{ $event->name }}</h3>

                    <!-- Format penanggalan yang dipaksa ke Bahasa Indonesia -->
                    <p class="font-medium text-gray-900 mt-4">
                        {{ \Carbon\Carbon::parse($event->start_time)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </p>

                    <p class="text-sm font-medium text-[#B38728]">
                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} -
                        @if($event->end_time)
                        {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                        @else
                        Selesai
                        @endif
                        {{ $event->timezone }}
                    </p>
                    <p class="mt-4 text-xs text-gray-600">{{ $event->location_name }}<br>{{ $event->location_address }}</p>
                    @if($event->google_maps_url)
                    <a href="{{ $event->google_maps_url }}" target="_blank" class="mt-4 inline-block text-xs bg-[#1A1A1A] text-[#FFF6CD] px-4 py-2 rounded">Buka Maps</a>
                    @endif
                </div>
                @endforeach
            </div>
        </section>

        <!-- RSVP SECTION -->
        <section class="bg-[#0D0D0D] py-16 px-4 text-white text-center">
            <h2 class="font-serif text-3xl text-white mb-8">Konfirmasi Kehadiran</h2>
            <div class="max-w-xl mx-auto rounded-2xl border border-[#D4AF37]/30 bg-white/5 p-6 backdrop-blur-md">
                <form id="rsvpForm" onsubmit="submitRsvp(event)" class="space-y-4 text-left">
                    <input type="text" id="guest_name" value="{{ $guestName }}" class="w-full rounded bg-white/5 border border-white/10 p-3 text-white" placeholder="Nama Lengkap" required>
                    <select id="attendance" class="w-full rounded bg-[#1A1A1A] border border-white/10 p-3 text-white" required>
                        <option value="hadir">✓ Ya, Saya Akan Hadir</option>
                        <option value="tidak_hadir">✕ Maaf, Saya Tidak Bisa Hadir</option>
                        <option value="ragu">? Mungkin Hadir</option>
                    </select>
                    <input type="number" id="guest_count" value="1" min="1" class="w-full rounded bg-white/5 border border-white/10 p-3 text-white" placeholder="Jumlah Orang" required>
                    <textarea id="message" rows="3" class="w-full rounded bg-white/5 border border-white/10 p-3 text-white" placeholder="Ucapan & Doa..." required></textarea>
                    <button type="submit" class="w-full bg-[#BF953F] text-black font-bold py-3 rounded uppercase tracking-widest">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- GIFT SECTION -->
        <section class="bg-[#FAF8F5] py-16 px-4 text-center">
            <h2 class="font-serif text-3xl text-gray-900 mb-8">Wedding Gift</h2>
            <div class="max-w-md mx-auto space-y-4 text-left">
                @foreach($invitation->gifts as $gift)
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm flex justify-between items-center">
                    <div>
                        <span class="text-[10px] font-bold text-[#B38728] uppercase">{{ $gift->provider_name }}</span>
                        <p class="font-mono text-lg font-bold text-gray-900">{{ $gift->account_number }}</p>
                        <p class="text-xs text-gray-500">a.n. {{ $gift->account_name }}</p>
                    </div>
                    <button onclick="copyAccount('{{ $gift->account_number }}')" class="bg-[#1A1A1A] text-[#FFF6CD] px-4 py-2 text-xs rounded">Salin</button>
                </div>
                @endforeach
            </div>
        </section>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init animasi AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Manajemen Data dari HTML Atribut
        const appData = document.getElementById("app-data");
        const urlRsvp = appData.getAttribute("data-rsvp-url");
        const eventDateString = appData.getAttribute("data-event-date");

        // Audio Handler
        const bgMusic = document.getElementById("bg-music");
        let isPlaying = false;

        function openInvitation() {
            document.getElementById("body").classList.remove("overflow-y-hidden");
            document.getElementById("hero-cover").style.transform = "translateY(-100%)";

            // Cek apakah elemen musik ada (klien punya lagu) sebelum diputar
            if (bgMusic) {
                bgMusic.play().then(() => {
                    isPlaying = true;
                    const btn = document.getElementById("music-btn");
                    if (btn) btn.classList.remove("hidden");
                }).catch(() => console.log('Autoplay ditahan oleh browser'));
            }
        }

        function toggleMusic() {
            if (!bgMusic) return;

            if (isPlaying) {
                bgMusic.pause();
            } else {
                bgMusic.play();
            }
            isPlaying = !isPlaying;
        }

        // Countdown Handler
        if (eventDateString) {
            const targetDate = new Date(eventDateString).getTime();
            setInterval(() => {
                const now = new Date().getTime();
                const diff = targetDate - now;

                if (diff > 0) {
                    document.getElementById("timer-days").innerText = Math.floor(diff / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                    document.getElementById("timer-hours").innerText = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                    document.getElementById("timer-minutes").innerText = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                    document.getElementById("timer-seconds").innerText = Math.floor((diff % (1000 * 60)) / 1000).toString().padStart(2, '0');
                }
            }, 1000);
        }

        // Form RSVP dengan Fetch API
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
                    text: 'Gagal mengirim RSVP. Pastikan koneksi internet stabil.',
                    icon: 'error',
                    customClass: {
                        popup: 'swal-mobile-sm'
                    }
                });
            }
        }

        // Copy Rekening Bank
        function copyAccount(acc) {
            navigator.clipboard.writeText(acc);
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
        }
    </script>
</body>

</html>