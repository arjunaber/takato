<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAKATO.id - Luxury Residence, Premium Dining & Events</title>
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
        /* --- CUSTOM PALETTE --- */
        :root {
            --color-primary-dark: #3D4F42;
            --color-primary-accent: #A8956F;
            --color-secondary-accent: #887B57;
            --color-tertiary-accent: #B8B097;
            --color-light-bg: #EAEAE4;
            --color-white-contrast: #ffffff;
            --color-black-contrast: #000000;
        }

        /* --- FLIP CARD STYLES (ELASTIC EFFECT) --- */
        .flip-card {
            perspective: 1000px;
            width: 100%;
            height: 300px;
            cursor: pointer;
            position: relative;
            z-index: 10;
            transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* --- LOGIC KHUSUS DESKTOP (ELASTIC / ACCORDION) --- */
        @media (min-width: 768px) {
            .perspective-container {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                gap: 1.5rem;
                width: 100%;
                max-width: 1100px !important;
            }

            .flip-card {
                flex: 1;
                height: 300px;
                transition: flex 0.6s cubic-bezier(0.25, 1, 0.5, 1), filter 0.6s ease, transform 0.6s ease;
            }

            .perspective-container:hover .flip-card:not(:hover) {
                flex: 0.8;
                filter: brightness(0.2) grayscale(0.8);
                transform: scale(0.95);
            }

            .perspective-container .flip-card:hover {
                flex: 1.3;
                filter: brightness(1) grayscale(0);
                z-index: 20;
                transform: scale(1.05);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            }

            .perspective-container:hover .flip-card:not(:hover) .card-content-wrapper {
                opacity: 0;
                transform: scale(0.9);
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            .perspective-container .flip-card:hover .card-content-wrapper {
                opacity: 1;
                transform: scale(1);
                transition: opacity 0.5s ease 0.2s, transform 0.5s ease 0.2s;
            }
        }

        .card-content-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s ease;
        }

        /* --- INTERAKSI KLIK --- */
        .flip-card.zoom-active {
            transform: scale(25) !important;
            flex: 10 !important;
            opacity: 0;
            transition: transform 1.2s cubic-bezier(0.7, 0, 0.3, 1), opacity 0.5s ease-in 0.6s;
            z-index: 50;
            pointer-events: none;
        }

        .flip-card.zoom-inactive {
            flex: 0.01 !important;
            opacity: 0;
            filter: blur(10px);
            margin: 0 !important;
            padding: 0 !important;
            transition: all 0.5s ease;
        }

        /* --- STRUKTUR KARTU --- */
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            border-radius: 20px;
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card.zoom-active .flip-card-inner {
            transform: rotateY(0deg) !important;
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 20px;
            overflow: hidden;
        }

        .flip-card-front {
            background-color: rgba(255, 255, 255, 0.95);
        }

        .flip-card-back {
            transform: rotateY(180deg);
            background-color: var(--color-primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .flip-card-back img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .flip-card-back-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- SCROLL SNAP --- */
        html {
            scroll-snap-type: y mandatory;
            height: 100vh;
            overflow-y: scroll;
            scroll-behavior: smooth;
        }

        section {
            scroll-snap-align: start;
            scroll-snap-stop: always;
            width: 100%;
            position: relative;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-light-bg);
            color: var(--color-primary-dark);
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .animated-gradient-text {
            background-size: 300% 300%;
            background-image: linear-gradient(-45deg, var(--color-secondary-accent) 0%, var(--color-white-contrast) 40%, var(--color-tertiary-accent) 60%, var(--color-secondary-accent) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient-shift 2s linear infinite;
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 100% 50%;
            }
        }

        /* UI Elements */
        .card-elegant {
            background-color: var(--color-white-contrast);
            border: 1px solid var(--color-light-bg);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(61, 79, 66, 0.1);
        }

        .gradient-text-dark {
            background: linear-gradient(45deg, var(--color-secondary-accent) 20%, var(--color-primary-accent) 80%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-text-light {
            background: linear-gradient(45deg, var(--color-tertiary-accent) 20%, var(--color-white-contrast) 80%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link-elegant.white-text {
            color: var(--color-white-contrast);
        }

        .nav-link-elegant.active {
            color: var(--color-secondary-accent);
            border-bottom: 2px solid var(--color-secondary-accent);
            padding-bottom: 3px;
        }

        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--color-primary-dark);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .water-fill-text {
            font-family: 'Playfair Display', serif;
            font-size: 6rem;
            font-weight: 800;
            position: relative;
            -webkit-text-fill-color: var(--color-white-contrast);
        }

        .water-fill-text::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            overflow: hidden;
            height: 0%;
            width: 100%;
            color: #A8956F;
            -webkit-text-fill-color: #A8956F;
            animation: fill-up 2s ease-out forwards;
        }

        @keyframes fill-up {
            0% {
                height: 0%;
            }

            100% {
                height: 100%;
            }
        }

        @media (max-width: 640px) {
            .water-fill-text {
                font-size: 3rem;
            }
        }

        @keyframes calm-dribble {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
                box-shadow: 0 10px 20px rgba(37, 211, 102, 0.4);
            }

            100% {
                transform: translateY(0);
            }
        }

        .animated-whatsapp {
            animation: calm-dribble 2s ease-in-out infinite;
        }

        .swiper-pagination-bullet-active {
            background-color: var(--color-primary-accent) !important;
        }

        .compact-img {
            height: 280px;
        }

        @media (min-height: 800px) {
            .compact-img {
                height: 350px;
            }
        }

        @media (max-width: 768px) {
            .compact-img {
                height: 200px;
            }
        }

        /* --- FALLING LEAVES --- */
        .falling-leaf {
            position: absolute;
            top: -15%;
            opacity: 0;
            pointer-events: none;
            z-index: 40;
            will-change: transform, opacity;
            backdrop-filter: blur(1px);
        }

        .leaf-gold {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            opacity: 0.4 !important;
        }

        .leaf-watercolor {
            mix-blend-mode: multiply;
            opacity: 0.25 !important;
        }

        .blur-sm-leaf {
            filter: blur(2px);
        }

        .blur-md-leaf {
            filter: blur(4px);
            opacity: 0.2 !important;
        }

        @keyframes drift-gentle {
            0% {
                opacity: 0;
                top: -15%;
                transform: translateX(0) rotate(0deg);
            }

            10% {
                opacity: 1;
            }

            25% {
                transform: translateX(15px) rotate(5deg);
            }

            50% {
                transform: translateX(-15px) rotate(-5deg);
            }

            75% {
                transform: translateX(10px) rotate(3deg);
            }

            100% {
                opacity: 0;
                top: 110%;
                transform: translateX(-5px) rotate(-2deg);
            }
        }

        @keyframes slow-sway {
            0% {
                opacity: 0;
                top: -15%;
                transform: translateX(-20px) rotate(-10deg);
            }

            10% {
                opacity: 1;
            }

            50% {
                transform: translateX(20px) rotate(10deg);
            }

            100% {
                opacity: 0;
                top: 110%;
                transform: translateX(-20px) rotate(-5deg);
            }
        }

        @keyframes soft-tumble {
            0% {
                opacity: 0;
                top: -15%;
                transform: translateX(0) rotate(0deg) scale(1);
            }

            10% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                top: 110%;
                transform: translateX(30px) rotate(45deg) scale(0.95);
            }
        }

        .animate-leaf-1 {
            animation: drift-gentle linear infinite;
        }

        .animate-leaf-2 {
            animation: slow-sway linear infinite;
        }

        .animate-leaf-3 {
            animation: soft-tumble linear infinite;
        }
    </style>
</head>

<body class="bg-[var(--color-light-bg)] text-[var(--color-primary-dark)]" x-data="{
    lang: 'en',
    setLang(newLang) { this.lang = newLang; },
    isScrolled: false,

    navigateTo(url) {
        const loader = document.getElementById('loading-screen');
        loader.style.display = 'flex';
        void loader.offsetWidth;
        loader.style.opacity = '1';
        loader.style.visibility = 'visible';

        setTimeout(() => {
            const target = document.querySelector(url);
            if (target) {
                target.scrollIntoView({ behavior: 'auto' });
                history.pushState(null, null, url);
            }
            setTimeout(() => {
                loader.style.opacity = '0';
                loader.style.visibility = 'hidden';
                setTimeout(() => {
                    loader.style.display = 'none';
                    this.zooming = false;
                    this.activeCard = null;
                }, 500);
            }, 500);
        }, 1500);
    },

    translations: {
        en: {
            home: 'Home',
            villa: 'Villa',
            dining: 'Dining',
            diningNav: 'Restaurant',
            event: 'Events',
            contact: 'Contact',

            // Hero
            heroTitle1: 'A Luxury Sanctuary',
            heroTitle2: 'for Every Story',

            // Buttons
            exploreHouse: 'Explore Villa',
            visitResto: 'Visit Restaurant',
            checkAvailability: 'Check Availability',
            viewMenu: 'View Menu',
            getQuote: 'Get Quotation',
            seePackages: 'View Packages',
            bookStay: 'Book Your Stay',
            inquireCatering: 'Inquire Catering',

            // Special Offers (BARU)
            promoTitle: 'Special Prize & Exclusive Offers',
            promoDesc: 'Unlock exclusive privileges for reservations made this month. Contact us to reveal our bespoke packages.',
            getYours: 'Claim Offer',

            // Short Descs
            villaShort: 'Exclusive private villa with a pool & lush gardens.',
            diningShort: 'Authentic cuisine & premium coffee in nature.',

            // Residence
            welcomeHouse: 'Welcome to Takato House',
            residenceTitle: 'Private Villa',
            residenceDesc: 'Takato House is an exclusive luxury villa, designed for private stays and grand events. Featuring a private pool, a professional kitchen, and expansive garden areas.',
            facilities: 'Facilities: 11 Bedrooms, Private Pool, Kitchen, Spacious Garden',

            // Dining
            welcomeKitchen: 'Welcome to Takato Kitchen & Coffee',
            diningTitle: 'Taste of Nusantara',
            diningDesc: 'Experience the warmth of Indonesian cuisine amidst lush greenery. The perfect sanctuary to relax with family and friends over premium coffee and authentic dishes.',
            menuHighlights: 'Signatures: Nasi Goreng, Soto Ayam, Premium Bogor Coffee',

            // Events
            ourFriends: 'Our Friends',
            expSubtitle: 'Curated',
            expDesc: 'Host your most cherished moments in our magnificent venue.',
            event: 'Experiences',
            weddingTitle: 'Weddings',
            weddingDesc: 'A magical venue for your special day.',
            retreatTitle: 'Corporate Retreats',
            retreatDesc: 'Ideal for team building and productivity.',
            gatheringTitle: 'Family Gatherings',
            gatheringDesc: 'Perfect spacious venue for large family reunions.',

            // Catering & Footer
            cateringTitle: 'Catering Services',
            cateringDesc: 'Bespoke menus crafted for every occasion.',
            locationTitle: 'Location',
            opHours: 'Open Daily: 09:00 AM - 09:00 PM',
            chatSupport: 'Chat with us',
            copy: '© 2024 Takato.id. All Rights Reserved.',
        },
        id: {
            home: 'Beranda',
            villa: 'Villa',
            dining: 'Coffee & Kitchen',
            diningNav: 'Restoran',
            event: 'Acara',
            contact: 'Kontak',

            // Hero
            heroTitle1: 'Sebuah Ruang Mewah',
            heroTitle2: 'untuk Setiap Kisah',

            // Buttons
            exploreHouse: 'Jelajahi Villa',
            visitResto: 'Kunjungi Restoran',
            checkAvailability: 'Cek Ketersediaan',
            viewMenu: 'Lihat Menu',
            getQuote: 'Dapatkan Penawaran',
            seePackages: 'Lihat Paket',
            bookStay: 'Reservasi Sekarang',
            inquireCatering: 'Tanya Katering',

            // Special Offers (BARU)
            promoTitle: 'Penawaran Spesial & Eksklusif',
            promoDesc: 'Dapatkan penawaran spesial untuk pemesanan bulan ini. Hubungi kami untuk detail paket eksklusif.',
            getYours: 'Ambil Penawaran',

            // Short Descs
            villaShort: 'Villa pribadi eksklusif dengan kolam renang & taman.',
            diningShort: 'Masakan otentik & kopi premium di alam terbuka.',

            // Residence
            welcomeHouse: 'Selamat Datang di Takato House',
            residenceTitle: 'Villa Pribadi',
            residenceDesc: 'Takato House adalah vila mewah pribadi yang sempurna untuk penginapan eksklusif atau acara besar. Dilengkapi fasilitas lengkap termasuk kolam renang pribadi, dapur luas, dan taman yang asri.',
            facilities: 'Fasilitas: 11 Kamar Tidur, Kolam Renang, Dapur, Taman Luas',

            // Dining
            welcomeKitchen: 'Selamat Datang di Takato Kitchen & Coffee',
            diningTitle: 'Cita Rasa Nusantara',
            diningDesc: 'Rasakan kehangatan masakan Indonesia di tengah taman yang asri. Tempat sempurna untuk bersantai bersama keluarga dan teman ditemani kopi premium dan hidangan otentik.',
            menuHighlights: 'Menu Favorit: Nasi Goreng, Soto Ayam, Kopi Bogor Premium',

            // Events
            ourFriends: 'Sahabat Kami',
            expSubtitle: 'Kurasi',
            expDesc: 'Wujudkan momen paling berharga Anda di venue megah kami.',
            event: 'Pengalaman',
            weddingTitle: 'Pernikahan',
            weddingDesc: 'Tempat magis untuk hari istimewa Anda.',
            retreatTitle: 'Corporate Retreat',
            retreatDesc: 'Ideal untuk kegiatan team building perusahaan.',
            gatheringTitle: 'Kumpul Keluarga',
            gatheringDesc: 'Sangat nyaman dan luas untuk keluarga besar.',

            // Catering & Footer
            cateringTitle: 'Layanan Katering',
            cateringDesc: 'Menu spesial untuk melengkapi setiap acara.',
            locationTitle: 'Lokasi',
            opHours: 'Buka: 09:00 - 21:00 WIB',
            chatSupport: 'Chat Kami',
            copy: 'Hak Cipta © 2024 Takato.id',
        }
    },
    t(key) { return this.translations[this.lang][key] || key; }
}"
    @scroll.window="isScrolled = (window.scrollY > 50)">

    <div id="loading-screen">
        <div class="water-fill-text" data-text="TAKATO">TAKATO</div>
    </div>

    <div class="fixed inset-0 pointer-events-none z-[40] overflow-hidden" aria-hidden="true">
        <img src="leaf.png" class="falling-leaf leaf-gold animate-leaf-2 w-8 md:w-12 blur-[1px]"
            style="left: 10%; animation-duration: 18s; animation-delay: 0s;">
        <img src="leaf.png" class="falling-leaf leaf-gold animate-leaf-3 w-10 blur-sm-leaf hidden md:block"
            style="left: 85%; animation-duration: 22s; animation-delay: 5s;">
        <img src="leaf.png" class="falling-leaf leaf-gold animate-leaf-2 w-14 blur-md-leaf hidden md:block"
            style="left: 50%; animation-duration: 25s; animation-delay: 10s;">
        <img src="leaf2.png" class="falling-leaf leaf-watercolor animate-leaf-1 w-10 md:w-16 blur-[1px]"
            style="left: 5%; animation-duration: 15s; animation-delay: 2s;">
        <img src="leaf2.png" class="falling-leaf leaf-watercolor animate-leaf-1 w-12 hidden md:block"
            style="left: 25%; animation-duration: 17s; animation-delay: -5s;">
        <img src="leaf2.png" class="falling-leaf leaf-watercolor animate-leaf-3 w-14 blur-sm-leaf hidden md:block"
            style="left: 65%; animation-duration: 20s; animation-delay: 1s;">
    </div>

    <nav id="fixed-nav"
        class="fixed top-0 left-0 w-full z-50 flex justify-center items-center py-4 px-4 md:px-8 transition-all duration-300"
        :class="{ 'bg-white/25 backdrop-blur-md shadow-md': isScrolled, 'bg-transparent shadow-none': !isScrolled }">
        <div class="w-full flex flex-row justify-between items-center max-w-7xl">
            <a href="#home" class="text-xl md:text-2xl font-extrabold font-serif tracking-wider transition-colors"
                :class="{ 'text-[var(--color-primary-dark)]': isScrolled, 'text-[var(--color-white-contrast)]': !isScrolled }">Takato.id</a>

            <div class="hidden md:flex gap-6 items-center">
                <a href="#home" class="nav-link-elegant font-bold text-sm" x-text="t('home')"
                    :class="{ 'white-text': !isScrolled }"></a>
                <a href="#residence" class="nav-link-elegant font-bold text-sm" x-text="t('villa')"
                    :class="{ 'white-text': !isScrolled }"></a>
                <a href="#dining" class="nav-link-elegant font-bold text-sm" x-text="t('diningNav')"
                    :class="{ 'white-text': !isScrolled }"></a>
                <a href="#experience" class="nav-link-elegant font-bold text-sm" x-text="t('event')"
                    :class="{ 'white-text': !isScrolled }"></a>
                <a href="#contact" class="nav-link-elegant font-bold text-sm" x-text="t('contact')"
                    :class="{ 'white-text': !isScrolled }"></a>

                <div
                    class="ml-2 flex items-center text-xs font-semibold border border-gray-300 rounded-full p-0.5 bg-white/10 backdrop-blur-sm">
                    <button @click="setLang('id')"
                        :class="lang === 'id' ? 'bg-[var(--color-primary-accent)] text-white' : 'text-gray-500'"
                        class="px-2 py-1 rounded-full transition">IN</button>
                    <button @click="setLang('en')"
                        :class="lang === 'en' ? 'bg-[var(--color-primary-accent)] text-white' : 'text-gray-500'"
                        class="px-2 py-1 rounded-full transition">EN</button>
                </div>
            </div>

            <button class="md:hidden text-xl"
                :class="{ 'text-[var(--color-primary-dark)]': isScrolled, 'text-[var(--color-white-contrast)]': !isScrolled }"
                @click="$store.mobileMenu.open = true">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <div x-data class="md:hidden">
        <div x-show="$store.mobileMenu.open" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="$store.mobileMenu.open = false" style="display:none;"></div>
        <div x-show="$store.mobileMenu.open"
            class="fixed top-0 right-0 z-[60] w-64 h-full bg-[var(--color-light-bg)] shadow-2xl p-6"
            x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0" style="display:none;">
            <div class="flex justify-between items-center pb-6 border-b border-gray-200">
                <span class="font-serif font-bold text-xl">Takato.id</span>
                <button @click="$store.mobileMenu.open = false"><i class="fas fa-times text-2xl"></i></button>
            </div>
            <nav class="flex flex-col gap-4 mt-6">
                <a href="#home" @click="$store.mobileMenu.open = false" class="text-lg font-semibold">Home</a>
                <a href="#residence" @click="$store.mobileMenu.open = false" class="text-lg font-semibold">Villa</a>
                <a href="#dining" @click="$store.mobileMenu.open = false" class="text-lg font-semibold">Dining</a>
                <a href="#experience" @click="$store.mobileMenu.open = false" class="text-lg font-semibold">Event</a>
                <a href="#contact" @click="$store.mobileMenu.open = false" class="text-lg font-semibold">Contact</a>
            </nav>
        </div>
    </div>

    <section id="home" class="h-screen w-full relative overflow-hidden" x-data="{ cardHovered: false, zooming: false, activeCard: null }">

        <div class="absolute inset-0 z-0">
            <img src="/img2.jpg" class="w-full h-full object-cover">
        </div>

        <div class="absolute inset-0 bg-black transition-opacity duration-500 ease-in-out z-1"
            :class="cardHovered ? 'opacity-90' : 'opacity-30'"></div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10"
            :class="{ 'pointer-events-none': zooming }">

            <h1 class="font-serif text-4xl sm:text-6xl md:text-7xl font-bold mb-8 leading-tight animated-gradient-text mt-12 md:mt-0 transition-opacity duration-500"
                :class="{ 'opacity-0': zooming }">
                <span x-text="t('heroTitle1')">A Luxury Space</span><br />
                <span x-text="t('heroTitle2')">for Every Story</span>
            </h1>

            <div class="perspective-container w-full px-4 relative flex flex-col md:flex-row gap-4 md:gap-6">

                <a href="#residence" class="flip-card" @mouseenter="cardHovered = true"
                    @mouseleave="cardHovered = false" @click.prevent="navigateTo('#residence')">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <div class="card-content-wrapper p-6 text-center">
                                <div
                                    class="bg-[var(--color-light-bg)] p-4 rounded-full mb-4 text-[var(--color-primary-dark)]">
                                    <i class="fas fa-home text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[var(--color-primary-dark)] font-serif mb-2"
                                    x-text="t('residenceTitle')">TAKATO HOUSE</h3>
                                <p class="text-gray-600 mb-6 text-sm flex-grow flex items-center justify-center"
                                    x-text="t('villaShort')">Short description...</p>
                                <button
                                    class="bg-[var(--color-primary-dark)] text-white px-6 py-2 rounded-full hover:bg-[var(--color-primary-accent)] transition text-sm shadow-md whitespace-nowrap">
                                    <span x-text="t('exploreHouse')">Click</span>
                                </button>
                            </div>
                        </div>

                        <div class="flip-card-back bg-black rounded-[20px] overflow-hidden">
                            <img src="image.png" alt="Villa" class="w-full h-full !object-contain rounded-[20px]">

                            <div class="flip-card-back-overlay rounded-[20px] !justify-end pr-8 !bg-transparent">
                                <div
                                    class="flex flex-col items-center gap-2 group-hover:scale-110 transition-transform duration-300">
                                    <div
                                        class="bg-white/20 backdrop-blur-md p-3 rounded-full border border-white/40 shadow-lg">
                                        <i class="fas fa-arrow-right text-white text-2xl"></i>
                                    </div>
                                    <span
                                        class="text-white text-xs font-bold tracking-widest uppercase shadow-black drop-shadow-md">Click</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="#dining" class="flip-card" @mouseenter="cardHovered = true"
                    @mouseleave="cardHovered = false" @click.prevent="navigateTo('#dining')">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <div class="card-content-wrapper p-6 text-center">
                                <div
                                    class="bg-[var(--color-light-bg)] p-4 rounded-full mb-4 text-[var(--color-primary-dark)]">
                                    <i class="fas fa-utensils text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[var(--color-primary-dark)] font-serif mb-2"
                                    x-text="t('diningNav')">TAKATO RESTO</h3>
                                <p class="text-gray-600 mb-6 text-sm flex-grow flex items-center justify-center"
                                    x-text="t('diningShort')">Short description...</p>
                                <button
                                    class="bg-[var(--color-secondary-accent)] text-white px-6 py-2 rounded-full hover:bg-[var(--color-primary-accent)] transition text-sm shadow-md whitespace-nowrap">
                                    <span x-text="t('visitResto')">Order</span>
                                </button>
                            </div>
                        </div>

                        <div class="flip-card-back bg-white rounded-[20px] overflow-hidden">
                            <img src="cafe.png" alt="Restaurant"
                                class="w-full h-full !object-contain rounded-[20px]">

                            <div class="flip-card-back-overlay rounded-[20px] !justify-end pr-8 !bg-transparent">
                                <div
                                    class="flex flex-col items-center gap-2 group-hover:scale-110 transition-transform duration-300">
                                    <div
                                        class="bg-black/5 backdrop-blur-md p-3 rounded-full border border-black/10 shadow-lg">
                                        <i class="fas fa-arrow-right text-black text-2xl"></i>
                                    </div>
                                    <span class="text-black text-xs font-bold tracking-widest uppercase">Click</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="absolute bottom-8 animate-bounce text-white hidden md:block transition-opacity duration-300"
                :class="{ 'opacity-0': zooming }">
                <span class="text-xs tracking-widest block mb-2 opacity-80">SCROLL</span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <section id="residence"
        class="min-h-screen h-auto md:h-screen w-full bg-[var(--color-primary-dark)] text-white relative flex flex-col justify-center py-8">
        <div class="max-w-7xl mx-auto px-4 w-full h-full flex flex-col justify-center">

            <div class="flex flex-col items-center justify-center mb-6 text-center shrink-0">
                <div class="animate-bounce mb-2">
                    <i class="fas fa-long-arrow-alt-up text-2xl text-[var(--color-secondary-accent)]"></i>
                </div>
                <h2 class="font-serif text-2xl md:text-4xl font-bold tracking-wide" x-text="t('welcomeHouse')">Welcome
                    to Takato House</h2>
                <div class="h-1 w-16 bg-[var(--color-secondary-accent)] mt-2"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center mb-6 shrink-0">
                <div class="relative group mx-auto w-full max-w-lg">
                    <div class="absolute -inset-2 bg-[var(--color-secondary-accent)] rounded-lg opacity-30 blur-sm">
                    </div>
                    <div
                        class="relative w-full rounded-lg overflow-hidden border border-[var(--color-secondary-accent)] shadow-2xl compact-img">
                        <img src="https://masterpiece.co.id/wp-content/uploads/2023/12/Denah-Lantai-Bawah.webp"
                            alt="Takato House Residence" class="w-full h-full object-cover">
                        <div class="absolute bottom-2 left-2 bg-black/60 px-3 py-1 rounded backdrop-blur-sm">
                            <p class="text-xs font-semibold text-[var(--color-tertiary-accent)]">5,600 m² Area</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 text-center lg:text-left">
                    <h3 class="font-serif text-2xl md:text-3xl font-bold text-[var(--color-light-bg)]"
                        x-text="t('residenceTitle')">Private Villa</h3>
                    <p class="text-gray-300 text-sm md:text-base leading-snug line-clamp-3"
                        x-text="t('residenceDesc')">Desc...</p>
                    <div class="p-3 bg-white/5 rounded-lg border border-white/10 backdrop-blur-sm inline-block w-full">
                        <p class="text-[var(--color-secondary-accent)] text-xs font-semibold mb-1"><i
                                class="fas fa-star mr-1"></i>Highlight</p>
                        <p class="text-xs text-gray-300" x-text="t('facilities')">Facilities...</p>
                    </div>
                    <div class="pt-2">
                        <a href="https://wa.me/+6281214831823" target="_blank"
                            class="inline-flex items-center gap-2 px-6 py-2 bg-[var(--color-secondary-accent)] hover:bg-[var(--color-primary-accent)] text-white rounded-full font-semibold text-sm transition-all shadow-md">
                            <span x-text="t('checkAvailability')">Check</span> <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-4 shrink-0">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <div class="h-px bg-white/20 w-12 md:w-24"></div>
                    <h3 class="font-serif text-lg md:text-xl font-bold text-[var(--color-tertiary-accent)] uppercase tracking-wider"
                        x-text="t('ourFriends')">Our Friends</h3>
                    <div class="h-px bg-white/20 w-12 md:w-24"></div>
                </div>

                <div class="swiper reviews-swiper w-full">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-4 rounded-lg border border-white/5 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-secondary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-300 italic text-xs mb-2 line-clamp-3">"The villa is massive!
                                        Perfect for our big family reunion. The pool is clean and the air is so fresh."
                                    </p>
                                </div>
                                <span class="font-semibold text-xs text-white">- Budi Santoso</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-4 rounded-lg border border-white/5 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-secondary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-300 italic text-xs mb-2 line-clamp-3">"Very private. We loved
                                        the kitchen facilities, complete and clean. Highly recommended."</p>
                                </div>
                                <span class="font-semibold text-xs text-white">- Sarah Jenkins</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-4 rounded-lg border border-white/5 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-secondary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-300 italic text-xs mb-2 line-clamp-3">"Best healing spot near
                                        Jakarta. No traffic noise, just nature sounds."</p>
                                </div>
                                <span class="font-semibold text-xs text-white">- Andi Pratama</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-4 rounded-lg border border-white/5 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-secondary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-300 italic text-xs mb-2 line-clamp-3">"Halaman luas banget,
                                        anak-anak puas lari-larian. Staff sangat ramah."</p>
                                </div>
                                <span class="font-semibold text-xs text-white">- Citra Lestari</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-4 rounded-lg border border-white/5 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-secondary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-300 italic text-xs mb-2 line-clamp-3">"Held our intimate
                                        wedding here. The garden setup was magical."</p>
                                </div>
                                <span class="font-semibold text-xs text-white">- Dimas & Rina</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-4 rounded-lg border border-white/5 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-secondary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-300 italic text-xs mb-2 line-clamp-3">"Luxury vibes with
                                        affordable price for large groups. Will come back!"</p>
                                </div>
                                <span class="font-semibold text-xs text-white">- Michael T.</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-4 rounded-lg border border-white/5 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-secondary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-300 italic text-xs mb-2 line-clamp-3">"Kamar tidurnya banyak
                                        dan bersih. AC dingin, water heater lancar."</p>
                                </div>
                                <span class="font-semibold text-xs text-white">- Ibu Ratna</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-4 rounded-lg border border-white/5 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-secondary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-300 italic text-xs mb-2 line-clamp-3">"Pengalaman menginap yang
                                        luar biasa. Sangat recommended!"</p>
                                </div>
                                <span class="font-semibold text-xs text-white">- Ferry Irawan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="dining"
        class="min-h-screen h-auto md:h-screen w-full bg-[var(--color-light-bg)] text-[var(--color-primary-dark)] relative flex flex-col justify-center py-8">
        <div class="max-w-7xl mx-auto px-4 w-full h-full flex flex-col justify-center">

            <div class="flex flex-col items-center justify-center mb-6 text-center shrink-0">
                <div class="animate-bounce mb-2"><i
                        class="fas fa-long-arrow-alt-up text-2xl text-[var(--color-secondary-accent)]"></i></div>
                <h2 class="font-serif text-2xl md:text-4xl font-bold tracking-wide" x-text="t('welcomeKitchen')">
                    Welcome to Takato Kitchen</h2>
                <div class="h-1 w-16 bg-[var(--color-secondary-accent)] mt-2"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center mb-6 shrink-0">
                <div class="space-y-4 text-center lg:text-left order-2 lg:order-1">
                    <h3 class="font-serif text-2xl md:text-3xl font-bold text-[var(--color-primary-dark)]"
                        x-text="t('diningTitle')">Taste of Nusantara</h3>
                    <p class="text-gray-600 text-sm md:text-base leading-snug line-clamp-3" x-text="t('diningDesc')">
                        Desc...</p>
                    <div
                        class="p-3 bg-white rounded-lg border border-[var(--color-tertiary-accent)] shadow-sm inline-block w-full">
                        <p class="text-[var(--color-primary-accent)] text-xs font-semibold mb-1"><i
                                class="fas fa-utensils mr-1"></i>Favorite</p>
                        <p class="text-xs text-gray-600 italic" x-text="t('menuHighlights')">Menu...</p>
                    </div>
                    <div class="pt-2">
                        <a href="#contact"
                            class="inline-flex items-center gap-2 px-6 py-2 bg-white text-[var(--color-primary-dark)] border border-[var(--color-secondary-accent)] hover:bg-[var(--color-secondary-accent)] hover:text-white rounded-full font-semibold text-sm transition-all shadow-md">
                            <span x-text="t('viewMenu')">Menu</span> <i class="fas fa-book-open"></i>
                        </a>
                    </div>
                </div>

                <div class="relative group mx-auto w-full max-w-lg order-1 lg:order-2">
                    <div class="absolute -inset-2 bg-[var(--color-primary-dark)] rounded-lg opacity-10 blur-sm"></div>
                    <div
                        class="relative w-full rounded-lg overflow-hidden border border-[var(--color-primary-dark)] shadow-2xl compact-img">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=2574&auto=format&fit=crop"
                            alt="Takato Kitchen" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 bg-white/80 px-3 py-1 rounded backdrop-blur-sm">
                            <p class="text-xs font-bold text-[var(--color-primary-dark)]">09:00 - 21:00</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-[var(--color-tertiary-accent)] pt-4 shrink-0">
                <div class="flex items-center justify-center gap-4 mb-4 text-[var(--color-primary-dark)]">
                    <div class="h-px bg-[var(--color-primary-dark)] w-12 md:w-24"></div>
                    <h3 class="font-serif text-lg md:text-xl font-bold uppercase tracking-wider"
                        x-text="t('ourFriends')">Our Friends</h3>
                    <div class="h-px bg-[var(--color-primary-dark)] w-12 md:w-24"></div>
                </div>

                <div class="swiper reviews-swiper w-full">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white p-4 rounded-lg border border-[var(--color-tertiary-accent)] shadow-sm h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-primary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-600 italic text-xs mb-2 line-clamp-3">"Great coffee, chill
                                        vibes. The manual brew is a must try!"</p>
                                </div>
                                <span class="font-semibold text-xs text-gray-800">- Dina M.</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white p-4 rounded-lg border border-[var(--color-tertiary-accent)] shadow-sm h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-primary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-600 italic text-xs mb-2 line-clamp-3">"Nasi Goreng Kampoeng
                                        nya
                                        juara! Rasanya otentik banget."</p>
                                </div>
                                <span class="font-semibold text-xs text-gray-800">- Rahmat Hidayat</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white p-4 rounded-lg border border-[var(--color-tertiary-accent)] shadow-sm h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-primary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-600 italic text-xs mb-2 line-clamp-3">"Cozy place for work
                                        (WFC). Wifi kencang, colokan banyak."</p>
                                </div>
                                <span class="font-semibold text-xs text-gray-800">- Fajar Nugraha</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white p-4 rounded-lg border border-[var(--color-tertiary-accent)] shadow-sm h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-primary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-600 italic text-xs mb-2 line-clamp-3">"Hidden gem in Bogor.
                                        The
                                        ambiance at night is so romantic."</p>
                                </div>
                                <span class="font-semibold text-xs text-gray-800">- Clara S.</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white p-4 rounded-lg border border-[var(--color-tertiary-accent)] shadow-sm h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-primary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-600 italic text-xs mb-2 line-clamp-3">"Soto Ayam nya enak,
                                        kuahnya seger. Harga juga reasonable."</p>
                                </div>
                                <span class="font-semibold text-xs text-gray-800">- Ibu Wati</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white p-4 rounded-lg border border-[var(--color-tertiary-accent)] shadow-sm h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-primary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-600 italic text-xs mb-2 line-clamp-3">"Pelayanan ramah,
                                        tempat
                                        bersih. Cocok buat nongkrong sore."</p>
                                </div>
                                <span class="font-semibold text-xs text-gray-800">- Dedi K.</span>
                            </div>
                        </div>
                        <div class="swiper-slide h-auto">
                            <div
                                class="bg-white p-4 rounded-lg border border-[var(--color-tertiary-accent)] shadow-sm h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex text-[var(--color-primary-accent)] text-xs mb-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <p class="text-gray-600 italic text-xs mb-2 line-clamp-3">"Tempatnya
                                        instagramable
                                        banget, banyak spot foto."</p>
                                </div>
                                <span class="font-semibold text-xs text-gray-800">- Sisca E.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="experience" class="py-10 md:py-20 mobile-py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-6">

            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[var(--color-primary-dark)]">
                    <span x-text="t('expSubtitle')">Curated</span> <span class="gradient-text-dark"
                        x-text="t('event')">Experiences</span>
                </h2>
                <p class="text-base md:text-xl text-gray-600 mt-4 max-w-4xl mx-auto" x-text="t('expDesc')">Host your
                    moments...</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                <a href="/events/wedding"
                    class="card-elegant rounded-xl shadow-luxury space-y-4 cursor-pointer group block" @click.stop>
                    <div class="h-48 w-full overflow-hidden rounded-t-xl">
                        <img src="/wedding.jpg" alt="Wedding"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 md:p-8 space-y-4">
                        <h3 class="font-serif text-xl md:text-2xl font-bold mb-3 text-[var(--color-primary-dark)]"
                            x-text="t('weddingTitle')">Weddings</h3>
                        <p class="text-sm md:text-base text-gray-700 mb-4" x-text="t('weddingDesc')">Desc...</p>
                        <span
                            class="text-xs md:text-sm text-[var(--color-primary-accent)] font-semibold hover:underline"
                            x-text="t('seePackages')">See Packages <i
                                class="fas fa-arrow-right text-xs ml-1"></i></span>
                    </div>
                </a>

                <a href="/events/retreat"
                    class="card-elegant rounded-xl shadow-luxury space-y-4 cursor-pointer group block" @click.stop>
                    <div class="h-48 w-full overflow-hidden rounded-t-xl">
                        <img src="https://cdn.prod.website-files.com/61eb3f79cfe8dd4bf6350818/63ff7b38bcf6a055318acdfd_PACE-EmmaCrystalWorkshop-2-scaled.webp"
                            alt="Retreat"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 md:p-8 space-y-4">
                        <h3 class="font-serif text-xl md:text-2xl font-bold mb-3 text-[var(--color-primary-dark)]"
                            x-text="t('retreatTitle')">Corporate Retreats</h3>
                        <p class="text-sm md:text-base text-gray-700 mb-4" x-text="t('retreatDesc')">Desc...</p>
                        <span
                            class="text-xs md:text-sm text-[var(--color-primary-accent)] font-semibold hover:underline"
                            x-text="t('getQuote')">Get Quotation <i
                                class="fas fa-arrow-right text-xs ml-1"></i></span>
                    </div>
                </a>

                <a href="/events/gathering"
                    class="card-elegant rounded-xl shadow-luxury space-y-4 cursor-pointer group block" @click.stop>
                    <div class="h-48 w-full overflow-hidden rounded-t-xl">
                        <img src="https://images.stockcake.com/public/8/5/7/8570134f-7780-4b73-a459-59c5257e2615_large/family-dinner-gathering-stockcake.jpg"
                            alt="Gathering"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 md:p-8 space-y-4">
                        <h3 class="font-serif text-xl md:text-2xl font-bold mb-3 text-[var(--color-primary-dark)]"
                            x-text="t('gatheringTitle')">Family Gatherings</h3>
                        <p class="text-sm md:text-base text-gray-700 mb-4" x-text="t('gatheringDesc')">Desc...</p>
                        <span
                            class="text-xs md:text-sm text-[var(--color-primary-accent)] font-semibold hover:underline"
                            x-text="t('bookStay')">Book Your Stay <i
                                class="fas fa-arrow-right text-xs ml-1"></i></span>
                    </div>
                </a>
            </div>

            <div class="mt-8 space-y-6">

                <div
                    class="card-elegant rounded-xl shadow-luxury p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-[var(--color-primary-accent)]/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                    </div>

                    <div class="relative z-10 text-center md:text-left">
                        <h3 class="font-serif text-2xl md:text-3xl font-bold text-[var(--color-primary-dark)] mb-2">
                            <span class="gradient-text-dark" x-text="t('promoTitle')">Special Prize & Exclusive
                                Offers</span>
                        </h3>
                        <p class="text-gray-600 text-sm md:text-base max-w-2xl" x-text="t('promoDesc')">
                            Dapatkan penawaran spesial...
                        </p>
                    </div>

                    <a href="https://wa.me/+6281214831823?text=Halo,%20saya%20tertarik%20dengan%20Special%20Prize/Offer%20di%20Takato"
                        target="_blank"
                        class="relative z-10 inline-flex items-center gap-2 px-8 py-3 bg-[var(--color-primary-dark)] text-white rounded-full font-semibold hover:bg-[var(--color-primary-accent)] transition-all duration-300 shadow-md whitespace-nowrap group-hover:scale-105">
                        <span x-text="t('getYours')">Get Yours</span>
                        <i class="fab fa-whatsapp text-lg"></i>
                    </a>
                </div>

                <div
                    class="card-elegant rounded-xl shadow-luxury p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 group">
                    <div class="flex flex-col md:flex-row items-center gap-6 w-full">
                        <div
                            class="w-16 h-16 rounded-full bg-[var(--color-light-bg)] flex items-center justify-center shrink-0 text-[var(--color-primary-dark)]">
                            <i class="fas fa-utensils text-2xl"></i>
                        </div>

                        <div class="text-center md:text-left flex-grow">
                            <h3 class="font-serif text-xl md:text-2xl font-bold text-[var(--color-primary-dark)] mb-2"
                                x-text="t('cateringTitle')">
                                Catering Services
                            </h3>
                            <p class="text-gray-600 text-sm md:text-base" x-text="t('cateringDesc')">
                                Menu spesial dengan cita rasa otentik untuk setiap acara Anda.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto shrink-0">
                        <a href="#dining"
                            class="px-6 py-2.5 rounded-full font-semibold text-sm border border-[var(--color-primary-dark)] text-[var(--color-primary-dark)] hover:bg-[var(--color-light-bg)] transition-all text-center">
                            <i class="fas fa-book-open mr-2"></i> <span x-text="t('viewMenu')">View Menu</span>
                        </a>

                        <a href="https://wa.me/+6281214831823?text=Halo,%20saya%20ingin%20tanya%20tentang%20Catering"
                            target="_blank"
                            class="px-6 py-2.5 rounded-full font-semibold text-sm bg-green-600 text-white hover:bg-green-700 transition-all text-center shadow-md flex items-center justify-center gap-2">
                            <span>Chat</span> <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="contact"
        class="min-h-screen h-auto w-full bg-[var(--color-primary-dark)] text-white flex flex-col justify-between overflow-y-auto">

        <div class="flex-grow flex flex-col justify-center py-10 md:py-20 px-4">
            <div class="max-w-xl md:max-w-4xl mx-auto px-4 md:px-6 w-full">
                <div class="text-center mb-8 md:mb-10">
                    <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white">
                        <span x-text="t('contact')">Contact</span> & <span class="gradient-text-light"
                            x-text="t('locationTitle')">Location</span>
                    </h2>
                </div>
                <div class="space-y-6 md:space-y-8">
                    <div class="space-y-4">
                        <div class="h-64 md:h-80 rounded-xl overflow-hidden shadow-luxury border border-gray-200">
                            <iframe
                                src="https://maps.google.com/maps?q=Jalan%20Raya%20Puncak,%20Blok%20Bendungan,%20Ciawi,%20Cijeruk,%20Bogor&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                width="100%" height="100%" style="border:0;" allowfullscreen=""
                                loading="lazy"></iframe>
                        </div>
                        <div class="card-elegant p-4 md:p-6 rounded-xl shadow-luxury">
                            <div
                                class="flex flex-col md:flex-row gap-4 items-center justify-between text-[var(--color-primary-dark)]">
                                <div class="text-center md:text-left">
                                    <p class="font-serif font-bold text-lg md:text-xl">Jalan Raya Puncak, Ciawi, Bogor
                                    </p>
                                    <p class="text-sm md:text-base mt-1" x-text="t('opHours')">Operating Hours...</p>
                                </div>
                                <a href="https://wa.me/+6281214831823" target="_blank"
                                    class="px-8 py-3.5 rounded-md font-semibold text-sm md:text-lg flex items-center justify-center gap-2 hover:shadow-lg bg-green-600 text-white hover:bg-green-700 transition duration-300 w-full md:w-auto">
                                    <i class="fab fa-whatsapp"></i> <span x-text="t('chatSupport')">Chat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="w-full px-4 md:px-6 py-8 md:py-12 text-gray-300 shrink-0" style="background-color: #000000;">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                    <div class="md:col-span-1 text-center md:text-left">
                        <div class="flex items-center justify-center mb-4 md:justify-start">
                            <a href="/"><img src="/image.png" class="w-48 md:w-32 h-auto" alt="Logo"></a>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6 md:col-span-2 md:grid-cols-2 md:gap-8">
                        <div>
                            <h2 class="mb-4 text-sm font-normal"><a
                                    class="tracking-widest font-secondary text-gradient-light"
                                    href="/">SERVICES</a></h2>
                            <ul class="space-y-2 text-xs">
                                <li><a href="/" class="text-white hover:text-accent">Property Management</a>
                                </li>
                                <li><a href="/" class="text-white hover:text-accent">Construction</a></li>
                                <li><a href="/" class="text-white hover:text-accent">Interior Design</a></li>
                                <li><a href="/" class="text-white hover:text-accent">Catering</a></li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="mb-4 text-sm font-normal"><a
                                    class="tracking-widest font-secondary text-gradient-light"
                                    href="#">EXPERIENCE</a></h2>
                            <ul class="space-y-2 text-xs">
                                <li><a href="/" class="text-white hover:text-accent">Wedding</a></li>
                                <li><a href="/" class="text-white hover:text-accent">Corporate</a></li>
                                <li><a href="/" class="text-white hover:text-accent">Family Gathering</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:col-span-1">
                        <h2 class="mb-4 text-sm font-normal tracking-widest text-white font-secondary text-center md:text-left"
                            style="color: var(--color-primary-accent);">CONTACT US</h2>
                        <div class="space-y-3 text-xs md:text-sm text-center md:text-left">
                            <div class="flex items-center justify-center md:justify-start space-x-2">
                                <a href="https://wa.me/628113809193"
                                    class="flex items-center text-white hover:text-accent"><i
                                        class="fab fa-whatsapp text-lg mr-2"></i><span>+628113809193</span></a>
                            </div>
                            <div class="flex items-center justify-center md:justify-start space-x-2">
                                <a href="mailto:info@takato.house"
                                    class="flex items-center text-white hover:text-accent"><i
                                        class="fas fa-envelope text-lg mr-2"></i><span>info@takato.house</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-6 mt-8 md:mt-12 border-t text-center md:text-left"
                    style="border-color: rgba(255, 255, 255, 0.1);">
                    <p class="text-xs md:text-sm text-white" x-text="t('copy')">Copyright © 2024 Takato.id. All Rights
                        Reserved.</p>
                </div>
            </div>
        </footer>
    </section>

    <div class="fixed bottom-6 right-4 md:bottom-8 md:right-6 z-[1008]">
        <a href="https://wa.me/+6281214831823" target="_blank"
            class="group w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-xl hover:scale-110 transition-all duration-300 animated-whatsapp text-white text-3xl">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            // Inisialisasi Alpine Store untuk mengelola status menu mobile
            Alpine.store('mobileMenu', {
                open: false // Default: menu mobile tertutup
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Ambil semua elemen navigasi utama
            const navLinks = document.querySelectorAll('.nav-link-elegant');
            // Ambil semua elemen section yang memiliki ID untuk dijadikan target scroll-snap
            const sections = document.querySelectorAll('section[id]');

            /**
             * Fungsi untuk mengaktifkan link navigasi berdasarkan posisi scroll.
             * Ini mendukung fungsionalitas scroll-snap dan penanda posisi aktif.
             */
            function onScroll() {
                let current = 'home'; // Tetapkan default section saat di paling atas

                // Iterasi melalui setiap section
                sections.forEach(sec => {
                    const rect = sec.getBoundingClientRect();

                    // Cek jika bagian tengah viewport berada di dalam batas section
                    // Ini menandakan section tersebut adalah yang aktif (saat ini terlihat)
                    if (rect.top <= window.innerHeight / 2 && rect.bottom >= window.innerHeight / 2) {
                        current = sec.getAttribute('id');
                    }
                });

                // Update kelas 'active' pada link navigasi yang sesuai
                navLinks.forEach(link => {
                    link.classList.remove('active'); // Hapus kelas 'active' dari semua link

                    // Tambahkan kelas 'active' jika href link cocok dengan ID section yang aktif
                    if (link.getAttribute('href').substring(1) === current) link.classList.add('active');
                });
            }

            // Tambahkan event listener untuk memanggil fungsi onScroll saat halaman digulir
            // Penggunaan { passive: true } untuk meningkatkan performa scroll
            window.addEventListener('scroll', onScroll, {
                passive: true
            });

            // --- INISIALISASI SWIPER SLIDER UNTUK BAGIAN REVIEWS/TESTIMONIALS ---
            /**
             * Inisialisasi Swiper untuk bagian reviews/testimonials.
             * Pengaturan ini mengaktifkan fitur auto-slide/autoplay.
             */
            const reviewsSwiper = new Swiper('.reviews-swiper', {
                // Konfigurasi umum
                slidesPerView: 1.2, // Jumlah slide yang terlihat (default untuk mobile)
                spaceBetween: 15, // Jarak antar slide (dalam piksel)
                centeredSlides: true, // Memposisikan slide aktif di tengah
                loop: true, // Mengaktifkan mode loop (geser tak terbatas)
                grabCursor: true, // Mengubah kursor menjadi 'grab' saat hover

                // --- PENGATURAN AUTOPLAY (AUTO SLIDE) ---
                autoplay: {
                    delay: 1000, // Durasi tunggu (dalam ms) sebelum geser ke slide berikutnya (3 detik)
                    disableOnInteraction: false, // JANGAN hentikan autoplay saat pengguna berinteraksi (menggeser manual)
                    pauseOnMouseEnter: true // Jeda autoplay saat kursor mouse di atas slider
                },

                // Pengaturan Responsif (Breakpoints)
                breakpoints: {
                    // Ketika lebar viewport >= 0px (Mobile)
                    0: {
                        slidesPerView: 1.2,
                        spaceBetween: 15,
                        centeredSlides: true
                    },
                    // Ketika lebar viewport >= 640px (Small/Tablet)
                    640: {
                        slidesPerView: 2.5,
                        spaceBetween: 20,
                        centeredSlides: false // Geser tidak lagi di tengah
                    },
                    // Ketika lebar viewport >= 1024px (Desktop)
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        centeredSlides: false
                    },
                },
            });

            // --- LOGIKA LOADING SCREEN AWAL ---
            const loadingScreen = document.getElementById('loading-screen');
            // Menunggu 2 detik (2000ms) sebelum memulai animasi fade out
            setTimeout(() => {
                loadingScreen.style.opacity = '0'; // Mulai transisi opacity ke 0 (fade out)
                loadingScreen.style.visibility = 'hidden'; // Sembunyikan setelah fade out

                // Setelah transisi opacity selesai (500ms), atur display ke 'none'
                setTimeout(() => loadingScreen.style.display = 'none', 500);
            }, 2000);
        });
    </script>
</body>

</html>
