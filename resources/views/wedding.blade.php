<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAKATO.id - Grand Wedding Venue & Packages</title>
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
            weddingDetailTitle: 'Grand Wedding',
            weddingDetailDesc: 'Tempat abadi dan elegan untuk momen Anda mengucapkan ~Saya bersedia.',
            weddingIntroTitle: 'Venue & Kapasitas Tinjauan',
            weddingIntroText: 'Takato House menawarkan lebih dari sekadar tempat; kami menawarkan kanvas luas di mana impian pernikahan Anda dapat terwujud. Dengan pemandangan taman tropis yang indah dan arsitektur vila yang mewah, tempat kami dapat diubah untuk mencerminkan gaya unik Anda.',
            weddingIntroQuote: 'Setiap sudut dirancang untuk menciptakan latar belakang yang sempurna untuk foto dan kenangan abadi.',
            capacityTitle: 'Kapasitas Acara',
            capacityStanding: 'Resepsi Berdiri',
            capacitySeating: 'Resepsi Duduk',
            capacityAccom: 'Akomodasi Menginap',
            galleryTitle: 'Galeri Kami',
            galleryDesc: 'Beberapa momen terbaik yang diselenggarakan di Takato House.',
            packageTitle: 'Paket Wedding',
            packageDesc: 'Paket lengkap yang dirancang untuk menciptakan hari spesial Anda tanpa hambatan.',
            venueAccomTitle: 'Venue & Akomodasi Eksklusif',
            venueAccom1: 'Penyewaan Vila Eksklusif (11 Kamar Tidur) selama 2D1N',
            venueAccom2: 'Akses penuh ke taman, kolam renang, dan area outdoor',
            venueAccom3: 'Fasilitas Parkir Luas untuk tamu',
            venueAccom4: 'Keamanan 24 jam',
            supportTitle: 'Dukungan & Manajemen Acara',
            support1: 'Izin Lokasi dan Biaya Kebersihan',
            support2: 'Listrik Cadangan (Genset) hingga 15,000 Watt',
            support3: 'Dukungan teknis dan staf venue',
            support4: 'Direktori vendor pernikahan yang direkomendasikan',
            cateringTitlePackage: 'Katering & Logistik',
            catering1: 'Diskon khusus untuk TAKATO Catering (Wajib)',
            catering2: 'Area preparation dapur katering terpisah',
            catering3: 'Akses bongkar muat logistik yang mudah',
            catering4: 'Welcome drink untuk tamu menginap',
            ctaTitle: 'Mulai Kisah Pernikahan Anda',
            ctaDesc: 'Jadwalkan kunjungan Anda atau diskusikan detail paket pernikahan kustom Anda dengan tim spesialis kami.',
            ctaButton: 'Dapatkan Penawaran Khusus',
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
            weddingDetailTitle: 'Grand Wedding',
            weddingDetailDesc: 'A timeless and elegant venue for the moment you say ~I do.',
            weddingIntroTitle: 'Venue & Capacity Overview',
            weddingIntroText: 'Takato House offers more than just a venue; we provide an expansive canvas where your wedding dreams can come to life. With stunning tropical garden views and luxurious villa architecture, our place can be transformed to reflect your unique style.',
            weddingIntroQuote: 'Every corner is designed to create the perfect backdrop for photographs and lasting memories.',
            capacityTitle: 'Event Capacity',
            capacityStanding: 'Standing Reception',
            capacitySeating: 'Seated Reception',
            capacityAccom: 'Overnight Accommodation',
            galleryTitle: 'Our Gallery',
            galleryDesc: 'Some of the best moments held at Takato House.',
            packageTitle: 'Wedding Packages',
            packageDesc: 'Comprehensive packages designed to make your special day seamless.',
            venueAccomTitle: 'Exclusive Venue & Accommodation',
            venueAccom1: 'Exclusive Villa Rental (11 Bedrooms) for 2D1N',
            venueAccom2: 'Full access to garden, private pool, and outdoor areas',
            venueAccom3: 'Large Guest Parking Facility',
            venueAccom4: '24-hour security',
            supportTitle: 'Event Support & Management',
            support1: 'Location Permit and Cleaning Fee',
            support2: 'Backup Electricity (Generator) up to 15,000 Watts',
            support3: 'Technical support and venue staff',
            support4: 'Directory of recommended wedding vendors',
            cateringTitlePackage: 'Catering & Logistics',
            catering1: 'Special discount for TAKATO Catering (Mandatory)',
            catering2: 'Separate catering kitchen preparation area',
            catering3: 'Easy logistics loading/unloading access',
            catering4: 'Welcome drink for staying guests',
            ctaTitle: 'Start Your Wedding Story',
            ctaDesc: 'Schedule your visit or discuss your custom wedding package details with our specialist team.',
            ctaButton: 'Get Special Quotation',
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
            <img src="/wedding.jpg" alt="Elegant wedding setup at Takato House with flowers and lighting."
                loading="lazy" class="w-full h-full object-cover brightness-[.75]">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 pt-20">
            <h1 class="font-serif text-5xl sm:text-7xl md:text-8xl font-bold text-white mb-4 drop-shadow-lg">
                <span class="gradient-text-light" x-text="t('weddingDetailTitle')">Grand Wedding</span>
            </h1>
            <p class="text-xl md:text-2xl text-white font-light max-w-3xl drop-shadow-md"
                x-text="t('weddingDetailDesc')">
                A timeless and elegant venue for the moment you say "I do."
            </p>
        </div>
    </section>

    <section id="intro-capacity" class="py-10 md:py-20 mobile-py-10 bg-[var(--color-light-bg)]">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="grid lg:grid-cols-3 gap-8 md:gap-12 items-center">
                <div class="lg:col-span-2 space-y-6 md:space-y-8">
                    <h2 class="font-serif text-3xl md:text-5xl font-bold text-[var(--color-primary-dark)] border-l-4 pl-4 border-[var(--color-secondary-accent)]"
                        x-text="t('weddingIntroTitle')">
                        Venue & Capacity Overview
                    </h2>
                    <p class="text-lg md:text-xl text-gray-700" x-text="t('weddingIntroText')">
                        Takato House menawarkan lebih dari sekadar tempat; kami menawarkan kanvas luas di mana impian
                        pernikahan Anda dapat terwujud. Dengan pemandangan taman tropis yang indah dan arsitektur vila
                        yang mewah, tempat kami dapat diubah untuk mencerminkan gaya unik Anda.
                    </p>
                    <p class="text-base md:text-lg text-gray-600 italic" x-text="t('weddingIntroQuote')">
                        "Setiap sudut dirancang untuk menciptakan latar belakang yang sempurna untuk foto dan kenangan
                        abadi."
                    </p>
                </div>
                <div
                    class="lg:col-span-1 card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-t-4 border-[var(--color-primary-accent)] h-full flex flex-col justify-center">
                    <h3 class="font-serif text-xl md:text-2xl font-bold mb-4 text-[var(--color-primary-dark)]"
                        x-text="t('capacityTitle')">
                        Kapasitas Acara
                    </h3>
                    <div class="space-y-3">
                        <p
                            class="flex justify-between items-center text-lg font-semibold text-[var(--color-primary-dark)] border-b pb-2">
                            <i class="fas fa-users text-[var(--color-secondary-accent)]"></i> <span
                                x-text="t('capacityStanding')">Resepsi Berdiri</span>:
                            <span class="font-bold text-2xl">300 Pax</span>
                        </p>
                        <p
                            class="flex justify-between items-center text-lg font-semibold text-[var(--color-primary-dark)] border-b pb-2">
                            <i class="fas fa-chair text-[var(--color-secondary-accent)]"></i> <span
                                x-text="t('capacitySeating')">Resepsi Duduk</span>:
                            <span class="font-bold text-2xl">150 Pax</span>
                        </p>
                        <p
                            class="flex justify-between items-center text-lg font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-bed text-[var(--color-secondary-accent)]"></i> <span
                                x-text="t('capacityAccom')">Akomodasi Menginap</span>:
                            <span class="font-bold text-2xl">50+ Pax</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-10 md:py-20 mobile-py-10 bg-[var(--color-primary-dark)]">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white">
                    <span x-text="t('galleryTitle').split(' ')[0]">Our</span> <span class="gradient-text-light"
                        x-text="t('galleryTitle').split(' ')[1]">Gallery</span>
                </h2>
                <p class="text-base md:text-xl text-gray-300 mt-4 max-w-4xl mx-auto" x-text="t('galleryDesc')">
                    Beberapa momen terbaik yang diselenggarakan di Takato House.
                </p>
            </div>
            <div class="swiper detailSwiper w-full mx-auto mb-10 md:mb-16">
                <div class="swiper-wrapper h-[400px] md:h-[550px]">
                    <div class="swiper-slide overflow-hidden rounded-xl shadow-2xl">
                        <img src="/wedding5.jpg" alt="Evening reception lighting in the garden" loading="lazy"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="swiper-slide overflow-hidden rounded-xl shadow-2xl">
                        <img src="/wedding6.jpg" alt="Indoor hall for reception or ceremony" loading="lazy"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="swiper-slide overflow-hidden rounded-xl shadow-2xl">
                        <img src="/wedding.jpg" alt="Elegant indoor wedding dining setup" loading="lazy"
                            class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="swiper-button-next text-white"></div>
                <div class="swiper-button-prev text-white"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <div class="md:col-span-2 h-72 md:h-96 overflow-hidden rounded-xl shadow-xl">
                    <img src="/wedding1.jpg" alt="Bride and groom walking in the garden"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <div class="md:col-span-1 h-72 md:h-96 overflow-hidden rounded-xl shadow-xl">
                    <img src="/wedding2.jpg" alt="Wedding table decoration close-up"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <div class="md:col-span-1 h-72 md:h-96 overflow-hidden rounded-xl shadow-xl">
                    <img src="/wedding3.jpg" alt="Outdoor wedding ceremony by the pool"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <div class="md:col-span-2 h-72 md:h-96 overflow-hidden rounded-xl shadow-xl">
                    <img src="/wedding4.jpg" alt="Indoor hall for reception or ceremony"
                        class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
            </div>
        </div>
    </section>

    <section id="packages" class="py-10 md:py-20 mobile-py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[var(--color-primary-dark)]">
                    <span class="gradient-text-dark" x-text="t('wedding')">Wedding</span> <span
                        x-text="t('packageTitle')">Packages</span>
                </h2>
                <p class="text-base md:text-xl text-gray-600 mt-4 max-w-4xl mx-auto" x-text="t('packageDesc')">
                    Paket lengkap yang dirancang untuk menciptakan hari spesial Anda tanpa hambatan.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                <div
                    class="card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-b-8 border-[var(--color-primary-accent)]">
                    <i class="fas fa-home text-4xl mb-4 text-[var(--color-secondary-accent)]"></i>
                    <h3 class="font-serif text-2xl font-bold mb-4 text-[var(--color-primary-dark)]"
                        x-text="t('venueAccomTitle')">
                        Venue & Akomodasi Eksklusif
                    </h3>
                    <ul class="space-y-3 text-base text-gray-700 list-inside list-disc">
                        <li x-text="t('venueAccom1')">Penyewaan Vila Eksklusif (11 Kamar Tidur) selama 2D1N</li>
                        <li x-text="t('venueAccom2')">Akses penuh ke taman, kolam renang, dan area outdoor</li>
                        <li x-text="t('venueAccom3')">Fasilitas Parkir Luas untuk tamu</li>
                        <li x-text="t('venueAccom4')">Keamanan 24 jam</li>
                    </ul>
                </div>

                <div
                    class="card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-b-8 border-[var(--color-secondary-accent)]">
                    <i class="fas fa-hands-helping text-4xl mb-4 text-[var(--color-primary-accent)]"></i>
                    <h3 class="font-serif text-2xl font-bold mb-4 text-[var(--color-primary-dark)]"
                        x-text="t('supportTitle')">
                        Dukungan & Manajemen Acara
                    </h3>
                    <ul class="space-y-3 text-base text-gray-700 list-inside list-disc">
                        <li x-text="t('support1')">Izin Lokasi dan Biaya Kebersihan</li>
                        <li x-text="t('support2')">Listrik Cadangan (Genset) hingga 15,000 Watt</li>
                        <li x-text="t('support3')">Dukungan teknis dan staf venue</li>
                        <li x-text="t('support4')">Direktori vendor pernikahan yang direkomendasikan</li>
                    </ul>
                </div>

                <div
                    class="card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-b-8 border-[var(--color-primary-dark)]">
                    <i class="fas fa-utensils text-4xl mb-4 text-[var(--color-secondary-accent)]"></i>
                    <h3 class="font-serif text-2xl font-bold mb-4 text-[var(--color-primary-dark)]"
                        x-text="t('cateringTitlePackage')">
                        Katering & Logistik
                    </h3>
                    <ul class="space-y-3 text-base text-gray-700 list-inside list-disc">
                        <li x-text="t('catering1')">Diskon khusus untuk TAKATO Catering (Wajib)</li>
                        <li x-text="t('catering2')">Area preparation dapur katering terpisah</li>
                        <li x-text="t('catering3')">Akses bongkar muat logistik yang mudah</li>
                        <li x-text="t('catering4')">Welcome drink untuk tamu menginap</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="cta-inquire" class="py-10 md:py-20 mobile-py-10 bg-[var(--color-tertiary-accent)]">
        <div class="max-w-4xl mx-auto px-4 md:px-6 text-center">
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-[var(--color-primary-dark)] mb-4"
                x-text="t('ctaTitle')">
                Mulai Kisah Pernikahan Anda
            </h2>
            <p class="text-lg md:text-xl text-gray-800 mb-8" x-text="t('ctaDesc')">
                Jadwalkan kunjungan Anda atau diskusikan detail paket pernikahan kustom Anda dengan tim spesialis kami.
            </p>
            <a href="https://wa.me/+6281214831823?text=Halo%20Takato.id%2C%20saya%20tertarik%20dengan%20paket%20wedding%20di%20Takato%20House.%20Bisa%20berikan%20penawaran%20terbaik%3F"
                target="_blank"
                class="inline-flex items-center gap-3 px-10 py-4 btn-warm rounded-full font-bold text-lg md:text-xl shadow-luxury hover:scale-[1.05] transition-transform">
                <span x-text="t('ctaButton')">Dapatkan Penawaran Khusus</span> <i class="fab fa-whatsapp text-xl"></i>
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
                <p class="text-xs md:text-sm text-white">Copyright © 2024 Takato.id. All Rights
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
