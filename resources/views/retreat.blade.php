<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAKATO.id - Corporate Retreat & Team Building Venue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        /* --- NEW CUSTOM PALETTE (Deep Forest & Gold-Beige) --- */
        :root {
            --color-primary-dark: #3D4F42;
            /* Dark Text/Secondary Text (Deep Forest) */
            --color-primary-accent: #A8956F;
            /* Main Accent (Gold-Beige) */
            --color-secondary-accent: #887B57;
            /* Strong Accent (Darker Gold) */
            --color-tertiary-accent: #B8B097;
            /* Button Hover/Highlight (Light Beige) */
            --color-light-bg: #EAEAE4;
            /* Main Background (Off-White/Light Beige) */
            --color-white-contrast: #ffffff;
            --color-black-contrast: #000000;

            --color-start: #ffffff;
            /* Warna Gold-Beige (Primary Accent) */
            --color-middle: #3D4F42;
            /* Warna Darker Gold (Secondary Accent) */
            --color-end: #887B57;
            /* Warna Light Beige (Tertiary Accent) */
        }

        .animated-gradient-text {
            /* Ukuran Background yang besar untuk memungkinkan pergerakan */
            background-size: 300% 300%;

            /* Mendefinisikan Gradien DENGAN FOKUS WARNA TERANG YANG LEBIH LAMA */
            background-image: linear-gradient(-45deg,
                    var(--color-secondary-accent) 0%,
                    /* Darker Gold (Mulai) */
                    var(--color-white-contrast) 40%,
                    /* Putih (Tampak lebih lama) */
                    var(--color-tertiary-accent) 60%,
                    /* Light Beige (Tengah) */
                    var(--color-secondary-accent) 100%);
            /* Darker Gold (Ulang) */

            /* Menerapkan properti teks gradient */
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            /* Menerapkan Animasi: 2s durasi, non-stop (infinite), dan bergerak ke satu arah */
            animation: gradient-shift 2s linear infinite;
        }

        /* Keyframes tidak berubah, tetapi jika Anda ingin membuatnya terlihat lebih cepat dan berkelanjutan: */
        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 100% 50%;
            }
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-light-bg);
            color: var(--color-primary-dark);
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* --- Global Elements for Luxury Look --- */
        .shadow-luxury {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .card-elegant {
            background-color: var(--color-white-contrast);
            border: 1px solid var(--color-light-bg);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(61, 79, 66, 0.1);
        }

        /* Gradient Text (Untuk Latar Terang - Contoh: Photos) */
        .gradient-text-dark {
            background: linear-gradient(45deg, var(--color-secondary-accent) 20%, var(--color-primary-accent) 80%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Gradient Text (Untuk Latar Gelap - Contoh: Contact) */
        .gradient-text-light {
            background: linear-gradient(45deg, var(--color-tertiary-accent) 20%, var(--color-white-contrast) 80%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }


        /* Button Style: Strong Accent */
        .btn-warm {
            background-color: var(--color-secondary-accent);
            color: white;
            transition: all 0.3s;
        }

        .btn-warm:hover {
            background-color: var(--color-primary-accent);
            box-shadow: 0 8px 15px rgba(136, 123, 87, 0.3);
            transform: translateY(-1px);
        }

        /* Button Style: Subtle Light Background */
        .btn-light-subtle {
            background-color: var(--color-light-bg);
            color: var(--color-primary-dark);
            border: 1px solid var(--color-tertiary-accent);
            transition: all 0.3s;
        }

        .btn-light-subtle:hover {
            background-color: var(--color-primary-accent);
            color: white;
        }

        /* Nav Link Style DITINGKATKAN untuk visibilitas */
        .nav-link-elegant.white-text {
            color: var(--color-white-contrast);
            /* Warna putih saat transparan */
        }

        /* Di dalam nav-link-elegant.active */
        .nav-link-elegant.active {
            /* Tetap warna aksen agar terlihat bagus saat blur/scroll */
            color: var(--color-secondary-accent);
            border-bottom: 2px solid var(--color-secondary-accent);
            padding-bottom: 3px;
        }

        /* WhatsApp button style */
        .btn-chat {
            background-color: #25D366;
            color: white;
            transition: all 0.3s;
        }

        .btn-chat:hover {
            background-color: #128C7E;
            box-shadow: 0 8px 15px rgba(37, 211, 102, 0.3);
            transform: translateY(-1px);
        }

        /* Custom Swiper Styles */
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* --- Custom Mobile Adjustments --- */
        @media (max-width: 640px) {
            .mobile-padding {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .hero-title-mobile {
                font-size: 2.5rem;
            }

            .hero-aspect-ratio {
                padding-bottom: 80% !important;
            }

            .mobile-py-10 {
                padding-top: 2.5rem !important;
                padding-bottom: 2.5rem !important;
            }

            .md\:justify-start {
                justify-content: center;
            }

            .hero-content {
                padding-top: 100px;
                /* Memberi ruang di bagian atas Hero Content */
            }

            .hero-title-mobile {
                font-size: 2.5rem;
            }
        }

        /* --- LOADING SCREEN STYLES (Water Fill Effect) --- */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--color-primary-dark);
            /* Latar belakang Deep Forest gelap */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .water-fill-text {
            /* Menggunakan font serif untuk konsistensi dengan TAKATO.id */
            font-family: 'Playfair Display', serif;
            font-size: 6rem;
            /* Ukuran besar untuk fokus */
            font-weight: 800;
            position: relative;

            /* Warna teks default (putih) dan Stroke Gold-Beige */
            -webkit-text-fill-color: var(--color-white-contrast);
            -webkit-text-stroke-width: 0;
            -webkit-text-stroke-color: transparent;
        }

        .water-fill-text::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            overflow: hidden;
            height: 0%;
            /* Dimulai dari 0% (tidak terisi) */
            width: 100%;

            color: #A8956F;
            -webkit-text-fill-color: #A8956F;
            -webkit-text-stroke-width: 0px;
            -webkit-text-stroke-color: transparent;

            animation: fill-up 2s ease-out forwards;
            /* Durasi animasi diatur ke 3 detik */
        }


        @keyframes fill-up {
            0% {
                height: 0%;
            }

            100% {
                height: 100%;
            }
        }

        /* Penyesuaian mobile */
        @media (max-width: 640px) {
            .water-fill-text {
                font-size: 3rem;
                -webkit-text-stroke-width: 1px;
            }
        }

        /* --- CSS untuk Efek Dribble Naik-Turun Calm --- */
        @keyframes calm-dribble {
            0% {
                transform: translateY(0);
                /* Posisi awal */
            }

            50% {
                transform: translateY(-20px);
                /* Bergerak ke atas sejauh 8px (efek drible/pantul) */
                /* Pertahankan box-shadow untuk efek cahaya, tapi tambahkan transisi ke atas */
                box-shadow: 0 5px 15px rgba(37, 211, 102, 0.5);
            }

            100% {
                transform: translateY(0);
                /* Kembali ke posisi awal */
            }
        }

        .animated-whatsapp {
            /* Ganti nama animasi dan pastikan properti yang diubah sudah benar */
            animation: calm-dribble 1.5s ease-in-out infinite;
            /* Mengurangi durasi menjadi 1.5s agar tidak terlalu lambat/calm, dan gunakan ease-in-out */
        }
    </style>
</head>

<body class="bg-[var(--color-light-bg)] text-[var(--color-primary-dark)]" x-data="{
    lang: 'id', // 'id' or 'en'
    setLang(newLang) { this.lang = newLang; },
    isScrolled: false,
    translations: {
        id: {
            // General
            home: 'Beranda',
            villa: 'Villa',
            dining: 'Coffee & Kitchen',
            diningNav: 'Restoran',
            event: 'Event',
            faq: 'FAQ',
            contact: 'Kontak',

            // Experience Dropdown
            wedding: 'Wedding',
            retreat: 'Corporate Retreat',
            gathering: 'Family Gathering',

            // --- RETREAT DETAIL KEYS (ID) ---
            retreatDetailTitle: 'Corporate Retreat',
            retreatDetailDesc: 'Lingkungan yang tenang dan inspiratif untuk team building, workshop, dan rapat dewan.',
            retreatIntroTitle: 'Retreat & Produktivitas',
            retreatIntroText: 'Takato House menyediakan suasana yang jauh dari hiruk pikuk kota, ideal untuk menumbuhkan kreativitas dan kolaborasi tim. Dengan ruang serbaguna indoor dan outdoor, tim Anda dapat mengadakan sesi brainstorming, presentasi, atau kegiatan team building yang efektif.',
            retreatIntroQuote: 'Ubah cara tim Anda bekerja. Inspirasi datang dari lingkungan yang tenang.',
            roomTitle: 'Fasilitas Meeting & Kerja',
            room1: 'Ruang Rapat Indoor (Kapasitas 30)',
            room2: 'Area *Workshop* Outdoor (Kapasitas 100)',
            room3: 'Proyektor & Sound System Profesional',
            room4: 'Internet Kecepatan Tinggi (Dedicated Fiber Optic)',
            room5: 'Area Breakout yang Nyaman',

            packageTitle: 'Paket Retreat MICE',
            packageDesc: 'Paket yang fleksibel, dirancang untuk mendukung tujuan strategis dan operasional perusahaan Anda.',

            // Paket Inklusi (Dukungan & Logistik)
            miceAccomTitle: 'Akomodasi & Inklusi Dasar', // Kategori Baru
            mice1: 'Akomodasi Eksklusif (11 Kamar Tidur) 2D1N',
            mice2: 'Akses penuh ke semua fasilitas rapat & kerja',
            mice3: 'Full Board Catering (3x Makan, 2x Kopi/Snack)',
            mice4: 'Listrik Cadangan (Genset) hingga 15,000 Watt', // Mengambil dari support2

            miceSupportTitle: 'Dukungan Teknis & Kegiatan', // Kategori Baru
            mice5: 'Dukungan IT & Staf Venue Penuh', // Mengambil dari mice4 lama
            mice6: 'Izin Lokasi dan Biaya Kebersihan', // Baru
            mice7: 'Opsi Kegiatan Team Building (Opsional)', // Mengambil dari mice5 lama

            ctaTitleRetreat: 'Rencanakan Retreat Perusahaan Anda',
            ctaDescRetreat: 'Dapatkan proposal lengkap yang disesuaikan dengan anggaran dan tujuan tim Anda.',
            ctaButtonRetreat: 'Dapatkan Proposal & Quotation',
            galleryTitle: 'Gallery Kami',
            galleryDesc: 'Foto-foto lingkungan yang ideal untuk team building dan rapat.',

            // --- KEYS DARI WELCOME.BLADE.PHP UNTUK FOOTER, DLL. (HARUS DIJAGA) ---
            copy: 'Hak Cipta © 2024 Takato.id. Semua Hak Dilindungi.',
            inquireAvail: 'Pesan via WhatsApp',
            // --- END WELCOME KEYS ---
        },
        en: {
            // General
            home: 'Home',
            villa: 'Villa',
            dining: 'Coffee & Kitchen',
            diningNav: 'Restaurant',
            event: 'Event',
            faq: 'FAQ',
            contact: 'Contact',

            // Experience Dropdown
            wedding: 'Wedding',
            retreat: 'Corporate Retreat',
            gathering: 'Family Gathering',
            galleryTitle: 'Our Gallery',
            galleryDesc: 'Photos of the ideal environment for team building and meetings.',

            // --- RETREAT DETAIL KEYS (EN) ---
            retreatDetailTitle: 'Corporate Retreat',
            retreatDetailDesc: 'A serene and inspiring environment for team building, workshops, and board meetings.',
            retreatIntroTitle: 'Retreat & Productivity',
            retreatIntroText: 'Takato House offers an atmosphere away from the city bustle, ideal for fostering creativity and team collaboration. With versatile indoor and outdoor spaces, your team can host effective brainstorming sessions, presentations, or team building activities.',
            retreatIntroQuote: 'Transform the way your team works. Inspiration comes from quiet surroundings.',
            roomTitle: 'Meeting & Work Facilities',
            room1: 'Indoor Meeting Room (Capacity 30)',
            room2: 'Outdoor Workshop Area (Capacity 100)',
            room3: 'Professional Projector & Sound System',
            room4: 'High-Speed Internet (Dedicated Fiber Optic)',
            room5: 'Comfortable Breakout Areas',

            packageTitle: 'MICE Retreat Packages',
            packageDesc: 'Flexible packages designed to support your company\'s strategic and operational goals.',

            // Paket Inklusi (Dukungan & Logistik)
            miceAccomTitle: 'Accommodation & Core Inclusions', // Kategori Baru
            mice1: 'Exclusive Accommodation (11 Bedrooms) 2D1N',
            mice2: 'Full access to all meeting & work facilities',
            mice3: 'Full Board Catering (3x Meals, 2x Coffee/Snack)',
            mice4: 'Backup Electricity (Generator) up to 15,000 Watts', // Mengambil dari support2

            miceSupportTitle: 'Technical Support & Activities', // Kategori Baru
            mice5: 'Full IT Support & Venue Staff', // Mengambil dari mice4 lama
            mice6: 'Location Permit and Cleaning Fee', // Baru
            mice7: 'Team Building Activity Options (Optional)', // Mengambil dari mice5 lama

            ctaTitleRetreat: 'Plan Your Corporate Retreat',
            ctaDescRetreat: 'Receive a comprehensive proposal tailored to your team\'s budget and objectives.',
            ctaButtonRetreat: 'Get Proposal & Quotation',

            // --- KEYS DARI WELCOME.BLADE.PHP UNTUK FOOTER, DLL. (HARUS DIJAGA) ---
            copy: '© 2024 Takato.id. All Rights Reserved.',
            inquireAvail: 'Book via WhatsApp',
            // --- END WELCOME KEYS ---
        }
    },
    t(key) {
        return this.translations[this.lang][key] || key;
    },
    setActiveLink() {
        let current = 'detail-hero'; // Set default active link for detail page
        const scrollPos = window.scrollY + 150;
        // Since this is a detail page, we only check the first section or use a fixed name
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link-elegant');

        // --- Custom Active Link Logic for Detail Pages ---
        // For detail pages, we only highlight the 'Event' category in the navbar.
        current = 'experience';
        // We still run the logic to ensure other sections aren't accidentally activated if they exist
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;

            if (scrollPos >= (sectionTop - 100) && scrollPos < (sectionTop + sectionHeight - 100)) {
                // We don't change 'current' based on the detail page sections, 
                // we stick to 'experience' to highlight the parent category in the navbar.
            }
        });
        // -------------------------------------------------

        navLinks.forEach(link => {
            link.classList.remove('active');
            const targetId = link.getAttribute('href').substring(1);

            if (targetId === current) {
                link.classList.add('active');
            }
            // Ensure the main 'Event' link is active
            if (targetId === 'experience') {
                link.classList.add('active');
            }
        });
    },
    // Modal functions (maintained)
    isModalOpen: false,
    modalTitle: '',
    modalImage: '',
    modalContent: '',
    openModal(title, image, content_id_key, content_en_key, image_url) {
        const img = image_url || image.id;
        this.modalTitle = this.lang === 'id' ? title.id : title.en;
        this.modalImage = img;
        const content_id = this.translations.id[content_id_key] || '';
        const content_en = this.translations.en[content_en_key] || '';
        this.modalContent = this.lang === 'id' ? content_id : content_en;
        this.isModalOpen = true;
    }
}"
    @scroll.window="isScrolled = (window.scrollY > 50)" x-init="setActiveLink()">
    <div id="loading-screen">
        <div class="water-fill-text" data-text="TAKATO">TAKATO</div>
    </div>
    <nav id="fixed-nav"
        class="fixed top-0 left-0 w-full z-50 flex justify-center items-center py-4 md:py-5 px-4 md:px-8 lg:px-16 transition-all duration-300"
        :class="{ 'bg-white/25 backdrop-blur-md shadow-md': isScrolled, 'bg-transparent shadow-none': !isScrolled }">
        <div class="w-full flex flex-row justify-between items-center max-w-7xl">
            <a href="/"
                class="text-xl md:text-2xl font-extrabold font-serif tracking-wider transition-colors duration-300"
                :class="{ 'text-[var(--color-primary-dark)]': isScrolled, 'text-[var(--color-primary-dark)]': !isScrolled }">
                Takato.id
            </a>

            <div class="hidden md:flex md:gap-4 lg:gap-8 items-center" role="navigation">
                <a href="/#home" class="nav-link-elegant font-bold md:text-sm" x-text="t('home')"
                    :class="{
                        '--color-primary-dark': !isScrolled,
                        '!text-[var(--color-secondary-accent)]': $el.classList.contains(
                            'active') && isScrolled
                    }">Home</a>
                <a href="/#residence" class="nav-link-elegant font-bold md:text-sm" x-text="t('villa')"
                    :class="{ '--color-primary-dark': !isScrolled }">Villa</a>
                <a href="/#dining" class="nav-link-elegant font-bold md:text-sm" x-text="t('diningNav')"
                    :class="{ '--color-primary-dark': !isScrolled }">Coffee & Kitchen</a>

                <div class="relative" x-data="{ dropdownOpen: false }" @mouseenter="dropdownOpen = true"
                    @mouseleave="dropdownOpen = false">
                    <a href="/#experience" class="nav-link-elegant flex items-center gap-1 md:text-sm active"
                        :class="{ 'active': $el.classList.contains('active'), '--color-primary-dark': !isScrolled }">
                        <span x-text="t('event')">Event</span>
                        <i class="fas fa-chevron-down text-xs ml-1 transition-transform"
                            :class="{ 'rotate-180': dropdownOpen }"></i>
                    </a>

                    <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-3 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 origin-top-right"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                        style="display: none;">
                        <div class="py-1" role="none">
                            <a href="/events/wedding"
                                class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50 transition">Wedding</a>
                            <a href="/events/retreat"
                                class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50 transition">Corporate
                                Retreat</a>
                            <a href="/events/gathering"
                                class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50 transition">Family
                                Gathering</a>
                        </div>
                    </div>
                </div>

                <a href="/#faq" class="nav-link-elegant font-bold md:text-sm" x-text="t('faq')"
                    :class="{ '--color-primary-dark': !isScrolled }">FAQ</a>
                <a href="/#contact" class="nav-link-elegant font-bold md:text-sm" x-text="t('contact')"
                    :class="{ '--color-primary-dark': !isScrolled }">Contact</a>

                <div class="ml-4 flex items-center text-sm font-semibold border border-gray-300 rounded-full p-0.5">
                    <button @click="setLang('id')"
                        :class="{
                            'bg-[var(--color-primary-accent)] text-white': lang === 'id',
                            'text-[var(--color-primary-dark)]': lang !== 'id',
                            'text-[var(--color-white-contrast)] !border-white/50': lang !== 'id' &&
                                !isScrolled
                        }"
                        class="px-3 py-1 rounded-full transition-colors duration-200">IN</button>
                    <button @click="setLang('en')"
                        :class="{
                            'bg-[var(--color-primary-accent)] text-white': lang === 'en',
                            'text-[var(--color-primary-dark)]': lang !== 'en',
                            'text-[var(--color-white-contrast)] !border-white/50': lang !== 'en' &&
                                !isScrolled
                        }"
                        class="px-3 py-1 rounded-full transition-colors duration-200">EN</button>
                </div>
            </div>

            <button class="md:hidden text-xl transition-colors duration-300" id="mobile-menu-btn"
                :class="{ 'text-[var(--color-primary-dark)]': isScrolled, 'text-[var(--color-white-contrast)]': !isScrolled }"
                @click="$store.mobileMenu.open = true">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <div x-data class="md:hidden" id="mobile-menu-container">
        <div x-show="$store.mobileMenu.open" @click="$store.mobileMenu.open = false"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm" style="display: none;">
        </div>

        <div x-show="$store.mobileMenu.open" @click.outside="$store.mobileMenu.open = false"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full"
            class="fixed top-0 right-0 z-[60] w-64 h-full bg-[var(--color-light-bg)] shadow-2xl p-6 overflow-y-auto"
            style="display: none;">

            <div class="flex justify-between items-center pb-6 border-b border-gray-200">
                <a href="#home"
                    class="text-xl font-extrabold font-serif tracking-wider text-[var(--color-primary-dark)]">
                    Takato.id
                </a>
                <button @click="$store.mobileMenu.open = false"
                    class="text-[var(--color-primary-dark)] text-3xl hover:text-[var(--color-secondary-accent)] transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="flex flex-col gap-2 text-xl font-semibold mt-6">
                <a @click="$store.mobileMenu.open = false" href="/#home"
                    class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition"
                    x-text="t('home')">Home</a>
                <a @click="$store.mobileMenu.open = false" href="/#residence"
                    class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition"
                    x-text="t('villa')">Villa</a>
                <a @click="$store.mobileMenu.open = false" href="/#dining"
                    class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition"
                    x-text="t('dining')">Coffee & Kitchen</a>
                <div x-data="{ subOpen: false }" class="py-3 border-b border-gray-200">
                    <button @click="subOpen = !subOpen"
                        class="w-full text-left flex justify-between items-center hover:text-[var(--color-primary-accent)] transition">
                        <span x-text="t('event')">Event</span>
                        <i class="fas fa-chevron-down text-xs ml-1 transition-transform"
                            :class="{ 'rotate-180': subOpen }"></i>
                    </button>
                    <div x-show="subOpen" x-collapse class="pl-4 pt-2 space-y-2 text-lg font-normal">
                        <a @click="$store.mobileMenu.open = false; subOpen = false" href="/events/wedding"
                            class="block py-1 hover:text-[var(--color-secondary-accent)]"
                            x-text="t('wedding')">Wedding</a>
                        <a @click="$store.mobileMenu.open = false; subOpen = false" href="/events/retreat"
                            class="block py-1 hover:text-[var(--color-secondary-accent)]"
                            x-text="t('retreat')">Corporate
                            Retreat</a>
                        <a @click="$store.mobileMenu.open = false; subOpen = false" href="/events/gathering"
                            class="block py-1 hover:text-[var(--color-secondary-accent)]"
                            x-text="t('gathering')">Family
                            Gathering</a>
                    </div>
                </div>
                <a @click="$store.mobileMenu.open = false" href="/#faq"
                    class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition"
                    x-text="t('faq')">FAQ</a>
                <a @click="$store.mobileMenu.open = false" href="/#contact"
                    class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition"
                    x-text="t('contact')">Contact</a>

                <div
                    class="mt-4 flex items-center justify-center text-lg font-semibold border border-gray-300 rounded-full p-0.5">
                    <button @click="setLang('id')"
                        :class="{ 'bg-[var(--color-primary-accent)] text-white': lang === 'id', 'text-[var(--color-primary-dark)]': lang !== 'id' }"
                        class="px-5 py-2 rounded-full transition-colors duration-200">IN</button>
                    <button @click="setLang('en')"
                        :class="{ 'bg-[var(--color-primary-accent)] text-white': lang === 'en', 'text-[var(--color-primary-dark)]': lang !== 'en' }"
                        class="px-5 py-2 rounded-full transition-colors duration-200">EN</button>
                </div>
            </nav>
        </div>
    </div>

    <div x-show="isModalOpen"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity duration-300"
        @click.away="isModalOpen = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;">

        <div class="card-elegant w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-xl shadow-2xl transform transition-transform duration-300"
            @click.stop>
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-1/2 flex-shrink-0 relative overflow-hidden">
                    <div class="h-64 md:h-full w-full">
                        <img :src="modalImage" :alt="modalTitle" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="w-full md:w-1/2 p-6 md:p-8 relative">
                    <button @click="isModalOpen = false"
                        class="absolute top-4 right-4 text-2xl text-[var(--color-primary-dark)] hover:text-[var(--color-primary-accent)] transition">
                        <i class="fas fa-times"></i>
                    </button>

                    <h3 class="font-serif text-2xl md:text-3xl font-bold text-[var(--color-primary-dark)] mb-4"
                        x-text="modalTitle">
                    </h3>
                    <div class="text-gray-700 space-y-4 text-sm md:text-base" x-html="modalContent"></div>

                    <a href="https://wa.me/+6281214831823" target="_blank"
                        class="mt-6 inline-flex items-center gap-2 px-6 py-3 btn-warm rounded-md font-semibold text-sm md:text-base">
                        <span x-text="t('inquireAvail')">Inquire Availability via WhatsApp</span> <i
                            class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section id="detail-hero" class="relative min-h-[60vh] flex items-end pt-20 overflow-hidden">
        <div class="relative w-full h-[60vh]">
            <img src="https://blog.smarteventi.it/wp-content/uploads/outdoor-corporate-events-eventi-aziendali-allaperto-810x338.jpg"
                alt="Corporate meeting setup with projector and tables in a luxury villa." loading="lazy"
                class="w-full h-full object-cover brightness-[.75]">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 pt-20">
            <h1 class="font-serif text-5xl sm:text-7xl md:text-8xl font-bold text-white mb-4 drop-shadow-lg">
                <span class="gradient-text-light" x-text="t('retreatDetailTitle')">Corporate Retreat</span>
            </h1>
            <p class="text-xl md:text-2xl text-white font-light max-w-3xl drop-shadow-md"
                x-text="t('retreatDetailDesc')">
                A serene and inspiring environment for team building, workshops, and board meetings.
            </p>
        </div>
    </section>

    <section id="intro-features" class="py-10 md:py-20 mobile-py-10 bg-[var(--color-light-bg)]">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="grid lg:grid-cols-3 gap-8 md:gap-12 items-start">
                <div class="lg:col-span-2 space-y-6 md:space-y-8">
                    <h2 class="font-serif text-3xl md:text-5xl font-bold text-[var(--color-primary-dark)] border-l-4 pl-4 border-[var(--color-secondary-accent)]"
                        x-text="t('retreatIntroTitle')">
                        Retreat & Productivity
                    </h2>
                    <p class="text-lg md:text-xl text-gray-700" x-text="t('retreatIntroText')">
                        Takato House menyediakan suasana yang jauh dari hiruk pikuk kota, ideal untuk menumbuhkan
                        kreativitas dan kolaborasi tim. Dengan ruang serbaguna indoor dan outdoor, tim Anda dapat
                        mengadakan sesi brainstorming, presentasi, atau kegiatan team building yang efektif.
                    </p>
                    <p class="text-base md:text-lg text-gray-600 italic" x-text="t('retreatIntroQuote')">
                        "Ubah cara tim Anda bekerja. Inspirasi datang dari lingkungan yang tenang."
                    </p>
                </div>

                <div
                    class="lg:col-span-1 card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-t-4 border-[var(--color-primary-accent)] h-full">
                    <h3 class="font-serif text-xl md:text-2xl font-bold mb-4 text-[var(--color-primary-dark)]"
                        x-text="t('roomTitle')">
                        Meeting & Work Facilities
                    </h3>
                    <div class="space-y-4">
                        <p class="flex items-center text-lg font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-desktop text-[var(--color-secondary-accent)] mr-3"></i> <span
                                x-text="t('room1')">Ruang Rapat Indoor (Kapasitas 30)</span>
                        </p>
                        <p class="flex items-center text-lg font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-tree text-[var(--color-secondary-accent)] mr-3"></i> <span
                                x-text="t('room2')">Area *Workshop* Outdoor (Kapasitas 100)</span>
                        </p>
                        <p class="flex items-center text-lg font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-video text-[var(--color-secondary-accent)] mr-3"></i> <span
                                x-text="t('room3')">Proyektor & Sound System Profesional</span>
                        </p>
                        <p class="flex items-center text-lg font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-wifi text-[var(--color-secondary-accent)] mr-3"></i> <span
                                x-text="t('room4')">Internet Kecepatan Tinggi (Dedicated Fiber Optic)</span>
                        </p>
                        <p class="flex items-center text-lg font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-coffee text-[var(--color-secondary-accent)] mr-3"></i> <span
                                x-text="t('room5')">Area Breakout yang Nyaman</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="retreat-gallery" class="py-10 md:py-20 mobile-py-10 bg-[var(--color-primary-dark)]">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white">
                    <span class="gradient-text-light" x-text="t('galleryTitle')">Our Gallery</span>
                </h2>
                <p class="text-base md:text-xl text-gray-300 mt-4 max-w-4xl mx-auto" x-text="t('galleryDesc')">
                    Foto-foto lingkungan yang ideal untuk team building dan rapat.
                </p>
            </div>

            <div class="swiper detailSwiper w-full mx-auto mb-10 md:mb-16">
                <div class="swiper-wrapper h-[400px] md:h-[550px]">
                    <div class="swiper-slide overflow-hidden rounded-xl shadow-2xl">
                        <img src="https://cdn.prod.website-files.com/61eb3f79cfe8dd4bf6350818/67256f4465582febd95ca1e5_Amphitheatre-1555x1155-c-default.webp"
                            alt="Team brainstorming session at a large table" loading="lazy"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="swiper-slide overflow-hidden rounded-xl shadow-2xl">
                        <img src="https://thehospitalitydaily.com/wp-content/uploads/2022/10/5-Tips-for-a-Successful-Corporate-Retreat-2.jpg"
                            alt="Outdoor gathering area for team relaxation" loading="lazy"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="swiper-slide overflow-hidden rounded-xl shadow-2xl">
                        <img src="https://cdn.prod.website-files.com/63789ee68d9dda6487c9704c/64206bb67894bff36c289bf5_1%20general.webp"
                            alt="Presentation setup with projector" loading="lazy" class
                            class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-button-next text-white"></div>
                <div class="swiper-button-prev text-white"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <div class="md:col-span-2 h-72 md:h-96 overflow-hidden rounded-xl shadow-xl">
                    <img src="https://uploads-ssl.webflow.com/5e6fda408b05912878a8bdc6/63feb0b5e66922719333ff77_Executive%20Retreat%20Ideas.png"
                        alt="Outdoor team building activity in the garden"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <div class="md:col-span-1 h-72 md:h-96 overflow-hidden rounded-xl shadow-xl">
                    <img src="https://www.yarnfieldpark.com/wp-content/uploads/2021/06/outdoor-team-building-1024x581.jpg"
                        alt="Villa pool area suitable for relaxation"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <div class="md:col-span-1 h-72 md:h-96 overflow-hidden rounded-xl shadow-xl">
                    <img src="https://www.independentadventure.co.uk/images/easyblog_articles/24/b2ap3_medium_collageIA.jpg"
                        alt="Indoor leisure hall for team games"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <div class="md:col-span-2 h-72 md:h-96 overflow-hidden rounded-xl shadow-xl">
                    <img src="https://www.thejungleni.com/app/uploads/2016/08/Water-Carrying-Races-768x432.jpg"
                        alt="Outdoor dining setup for corporate group"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
            </div>
        </div>
    </section>

    <section id="packages" class="py-10 md:py-20 mobile-py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[var(--color-primary-dark)]">
                    <span class="gradient-text-dark" x-text="t('retreat')">Corporate Retreat</span> <span
                        x-text="t('packageTitle')">Packages</span>
                </h2>
                <p class="text-base md:text-xl text-gray-600 mt-4 max-w-4xl mx-auto" x-text="t('packageDesc')">
                    Paket yang fleksibel, dirancang untuk mendukung tujuan strategis dan operasional perusahaan Anda.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 md:gap-8">
                <div
                    class="card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-b-8 border-[var(--color-primary-accent)]">
                    <i class="fas fa-briefcase text-4xl mb-4 text-[var(--color-secondary-accent)]"></i>
                    <h3 class="font-serif text-2xl font-bold mb-4 text-[var(--color-primary-dark)]"
                        x-text="t('miceAccomTitle')">
                        Akomodasi & Inklusi Dasar
                    </h3>
                    <ul class="space-y-3 text-base text-gray-700 list-inside list-disc">
                        <li x-text="t('mice1')">Akomodasi Eksklusif (11 Kamar Tidur) 2D1N</li>
                        <li x-text="t('mice2')">Akses penuh ke semua fasilitas rapat & kerja</li>
                        <li x-text="t('mice3')">Full Board Catering (3x Makan, 2x Kopi/Snack)</li>
                        <li x-text="t('mice4')">Listrik Cadangan (Genset) hingga 15,000 Watt</li>
                    </ul>
                </div>

                <div
                    class="card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-b-8 border-[var(--color-secondary-accent)]">
                    <i class="fas fa-puzzle-piece text-4xl mb-4 text-[var(--color-primary-accent)]"></i>
                    <h3 class="font-serif text-2xl font-bold mb-4 text-[var(--color-primary-dark)]"
                        x-text="t('miceSupportTitle')">
                        Dukungan Teknis & Kegiatan
                    </h3>
                    <ul class="space-y-3 text-base text-gray-700 list-inside list-disc">
                        <li x-text="t('mice5')">Dukungan IT & Staf Venue Penuh</li>
                        <li x-text="t('mice6')">Izin Lokasi dan Biaya Kebersihan</li>
                        <li x-text="t('mice7')">Opsi Kegiatan Team Building (Opsional)</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="cta-inquire" class="py-10 md:py-20 mobile-py-10 bg-[var(--color-tertiary-accent)]">
        <div class="max-w-4xl mx-auto px-4 md:px-6 text-center">
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-[var(--color-primary-dark)] mb-4"
                x-text="t('ctaTitleRetreat')">
                Rencanakan Retreat Perusahaan Anda
            </h2>
            <p class="text-lg md:text-xl text-gray-800 mb-8" x-text="t('ctaDescRetreat')">
                Dapatkan proposal lengkap yang disesuaikan dengan anggaran dan tujuan tim Anda.
            </p>
            <a href="https://wa.me/+6281214831823?text=Halo%20Takato.id%2C%20saya%20tertarik%20dengan%20paket%20Corporate%20Retreat.%20Bisa%20berikan%20penawaran%20terbaik%3F"
                target="_blank"
                class="inline-flex items-center gap-3 px-10 py-4 btn-warm rounded-full font-bold text-lg md:text-xl shadow-luxury hover:scale-[1.05] transition-transform">
                <span x-text="t('ctaButtonRetreat')">Dapatkan Proposal & Quotation</span> <i
                    class="fab fa-whatsapp text-xl"></i>
            </a>
        </div>
    </section>


    <footer class="px-4 md:px-6 py-8 md:py-12 text-gray-300" style="background-color: #000000;">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">

                <div class="md:col-span-1 text-center md:text-left">
                    <div class="flex items-center justify-center mb-4 md:justify-start">
                        <a href="/">
                            <img src="/image.png" class="w-48 md:w-32 h-auto" alt="Logo Takato House">
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 md:col-span-2 md:grid-cols-2 md:gap-8">
                    <div>
                        <h2 class="mb-4 text-sm font-normal">
                            <a class="tracking-widest font-secondary text-gradient-light" href="/">
                                LAYANAN
                            </a>
                        </h2>
                        <ul class="space-y-2 text-xs">
                            <li><a href="/" class="text-white transition-colors hover:text-accent">Manajemen
                                    Properti</a></li>
                            <li><a href="/" class="text-white transition-colors hover:text-accent">Konstruksi &
                                    Renovasi</a>
                            </li>
                            <li><a href="/" class="text-white transition-colors hover:text-accent">Desain
                                    Interior</a></li>
                            <li><a href="/" class="text-white transition-colors hover:text-accent">Takato
                                    Catering</a></li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="mb-4 text-sm font-normal">
                            <a class="tracking-widest font-secondary text-gradient-light" href="#">
                                EXPERIENCE
                            </a>
                        </h2>
                        <ul class="space-y-2 text-xs">
                            <li><a href="/" class="text-white transition-colors hover:text-accent">Wedding
                                </a></li>
                            <li><a href="/" class="text-white transition-colors hover:text-accent">Corporate
                                </a></li>
                            <li><a href="/" class="text-white transition-colors hover:text-accent">Family
                                    Gathering
                                </a>
                            </li>
                            <li><a href="/"
                                    class="text-white transition-colors hover:text-accent">Grandschedule</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="md:col-span-1">
                    <h2 class="mb-4 text-sm font-normal tracking-widest text-white font-secondary text-center md:text-left"
                        style="color: var(--color-primary-accent);">Hubungi Kami</h2>
                    <div class="space-y-3 text-xs md:text-sm text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start space-x-2">
                            <a href="https://wa.me/628113809193?text=Halo%20Takato%20House"
                                class="flex items-center text-white transition-colors hover:text-accent"
                                target="_blank">
                                <i class="fab fa-whatsapp text-lg mr-2"></i>
                                <span class="font-light">+628113809193</span>
                            </a>
                        </div>
                        <div class="flex items-center justify-center md:justify-start space-x-2">
                            <a href="mailto:info@takato.house"
                                class="flex items-center text-white transition-colors hover:text-accent"
                                target="_blank">
                                <i class="fas fa-envelope text-lg mr-2"></i>
                                <span class="font-light">info@takato.house</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-8 md:mt-12 border-t text-center md:text-left"
                style="border-color: rgba(255, 255, 255, 0.1);">
                <p class="text-xs md:text-sm text-white" x-text="t('copy')">Copyright © 2024 Takato.id. All Rights
                    Reserved
                </p>
            </div>
        </div>
    </footer>


    <div class="fixed bottom-6 right-4 md:bottom-8 md:right-6 z-[1008]">
        <a href="https://wa.me/+6281214831823" target="_blank" rel="noopener noreferrer"
            class="group w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-xl shadow-green-500/50 hover:scale-110 transition-all duration-300 animated-whatsapp">
            <i class="fab fa-whatsapp text-2xl md:text-3xl text-white group-hover:scale-110 transition-transform"></i>
        </a>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('mobileMenu', {
                open: false,
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            // --- Navigation Active State & Mobile Menu Logic (Unchanged) ---
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link-elegant');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');

            function setActiveLink() {
                let current = 'detail-hero';
                const scrollPos = window.scrollY + 150;
                const sections = document.querySelectorAll('section[id]');
                const navLinks = document.querySelectorAll('.nav-link-elegant');

                // For detail pages, we fix the active link to the 'experience' (Event) parent link
                let targetActive = 'experience';

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    const targetId = link.getAttribute('href').substring(1);

                    if (targetId === targetActive) {
                        link.classList.add('active');
                    }
                });
            }

            window.addEventListener('scroll', setActiveLink);
            setActiveLink();

            // --- Swiper Initialization (General Gallery) ---
            // Dibiarkan untuk referensi, tapi tidak digunakan di halaman ini.
            const swiper = new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                autoplay: {
                    delay: 1000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 0,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 0,
                    },
                }
            });

            // --- Swiper Initialization untuk Halaman Detail (detailSwiper) ---
            const detailSwiper = new Swiper(".detailSwiper", {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 3000, // Durasi 3 detik per slide
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    768: {
                        slidesPerView: 1.5,
                        spaceBetween: 20,
                    },
                }
            });


            window.addEventListener('load', () => {
                const loadingScreen = document.getElementById('loading-screen');
                setTimeout(() => {
                    loadingScreen.style.opacity = '0';
                    loadingScreen.style.visibility = 'hidden';

                    // Hapus elemen setelah transisi selesai
                    setTimeout(() => {
                        loadingScreen.remove();
                    }, 500);
                }, 2000); // TOTAL DELAY 3.5 detik
            });
        });
    </script>
</body>

</html>
