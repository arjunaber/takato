<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAKATO - Super App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .shimmer-text {
            background: linear-gradient(90deg, #ffffff, #e5e5e5, #ffffff);
            background-size: 200% 100%;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s infinite linear;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .flip-card {
            perspective: 1000px;
            width: 100%;
            height: 300px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .flip-card-back {
            transform: rotateY(180deg);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000000;
        }

        .flip-card-back img {
            width: 120px;
            height: 120px;
            object-fit: contain;
        }

        .ghost-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }

        #reviews-slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        #reviews-slider>div {
            flex: 0 0 auto;
        }

        @media (min-width: 768px) {
            #reviews-slider>div {
                width: 50%;
            }
        }

        @media (min-width: 1024px) {
            #reviews-slider>div {
                width: 33.3333%;
            }
        }

        /* Active navigation link */
        nav a.active {
            color: white !important;
            position: relative;
        }

        nav a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: white;
        }

        /* Mobile menu */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="font-sans bg-gray-900 text-slate-100">
    <!-- Desktop Navigation -->
    <nav
        class="z-[1004] hidden md:flex fixed top-0 left-0 w-full h-auto justify-center items-center text-slate-100 py-3 px-10 md:px-16 transition-all bg-black/20 backdrop-blur-md border-b border-white/10">
        <div class="w-full h-auto flex flex-row justify-center items-center gap-7 justify-between">
            <div class="text-2xl font-bold shimmer-text">TAKATO</div>
            <nav class="flex gap-7 px-4 bg-black/40 backdrop-blur-md border-b border-white/10 rounded-2xl"
                role="navigation">
                <a href="#home"
                    class="nav-link relative flex items-center justify-center text-slate-100 transition duration-300 py-3 hover:text-white">Home</a>
                <a href="#facilities"
                    class="nav-link relative flex items-center justify-center text-slate-100 transition duration-300 py-3 hover:text-white">Facilities</a>
                <a href="#resto"
                    class="nav-link relative flex items-center justify-center text-slate-100 transition duration-300 py-3 hover:text-white">Restaurant</a>
                <a href="#reviews"
                    class="nav-link relative flex items-center justify-center text-slate-100 transition duration-300 py-3 hover:text-white">Reviews</a>
            </nav>
            <div class="px-[2.2rem] bg-transparent" aria-hidden="true"></div>
        </div>
    </nav>

    <!-- Mobile Navigation -->
    <nav class="z-[1004] md:hidden fixed top-0 left-0 w-full flex h-auto justify-center items-center bg-black/20 backdrop-blur-md border border-white/10 shadow-lg text-slate-100 py-3 px-6"
        role="navigation">
        <div class="w-full h-auto flex flex-row justify-between items-center gap-7">
            <div class="text-xl font-bold shimmer-text">TAKATO</div>
            <button class="h-10 w-auto cursor-pointer text-white" id="mobile-menu-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-10 w-auto">
                    <path fill-rule="evenodd"
                        d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Sidebar -->
    <div class="mobile-menu fixed top-0 right-0 h-full w-64 bg-black/95 backdrop-blur-md z-[1005] md:hidden">
        <div class="flex flex-col h-full">
            <div class="flex justify-between items-center p-6 border-b border-white/10">
                <div class="text-xl font-bold shimmer-text">TAKATO</div>
                <button class="text-white" id="close-menu-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                        <path fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <nav class="flex flex-col p-6 gap-4">
                <a href="#home"
                    class="mobile-nav-link text-slate-100 hover:text-white transition py-2 border-b border-white/10">Home</a>
                <a href="#facilities"
                    class="mobile-nav-link text-slate-100 hover:text-white transition py-2 border-b border-white/10">Facilities</a>
                <a href="#resto"
                    class="mobile-nav-link text-slate-100 hover:text-white transition py-2 border-b border-white/10">Restaurant</a>
                <a href="#reviews"
                    class="mobile-nav-link text-slate-100 hover:text-white transition py-2 border-b border-white/10">Reviews</a>
            </nav>
        </div>
    </div>

    <main class="w-full h-auto flex flex-col justify-center items-center text-slate-100 font-sans scroll-smooth">
        <!-- Hero Section -->
        <section id="home"
            class="text-slate-100 flex flex-col items-center justify-center w-full xl:w-[100%] md:w-[90%] min-h-screen pt-20">
            <div class="absolute top-0 left-0 w-full h-[80%] -z-10 bg-cover bg-center"
                style="background-image: linear-gradient(rgba(255, 255, 255, 0) 60%, rgb(26, 26, 26) 90%), url('https://images.unsplash.com/photo-1613977257363-707ba9348227?w=1200&h=800&fit=crop');">
            </div>
            <div class="absolute bottom-0 left-0 w-full h-[21%] -z-10 bg-cover bg-[#1a1a1a]"></div>
            <header
                class="flex flex-col items-center justify-center text-center w-full h-auto pt-20 pb-20 px-[4%] md:px-[20%]">
                <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold mb-6 shimmer-text">Welcome to TAKATO</h1>
                <div
                    class="z-[1001] bg-black/20 backdrop-blur-md border border-white/10 shadow-lg p-4 sm:p-7 mt-4 rounded-2xl w-full">
                    <p class="text-sm sm:text-base md:text-lg font-normal text-slate-100 pb-4 sm:pb-7 max-w-4xl">Your
                        all-in-one solution for <strong
                            class="text-white drop-shadow-[0_1.2px_1px_rgba(255,255,255,0.8)]">villa management</strong>
                        and <strong class="text-white drop-shadow-[0_1.2px_1px_rgba(255,255,255,0.8)]">restaurant
                            ordering</strong>. Experience luxury living and exquisite dining in one seamless platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 w-full items-center justify-center pb-4">
                        <a href="#facilities"
                            class="button w-full sm:w-[40%] md:w-[25%] bg-gradient-to-t from-gray-700 to-gray-600 cursor-pointer h-12 rounded-xl flex items-center flex-row justify-center gap-1 transition-all hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5 sm:w-6 sm:h-6 text-slate-100">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-100 text-sm sm:text-base">Explore Villa</span>
                        </a>
                        <a href="#resto"
                            class="button w-full sm:w-[40%] md:w-[25%] bg-transparent border-2 border-white text-white h-12 cursor-pointer rounded-xl flex items-center justify-center transition-all hover:bg-white hover:text-gray-900 text-sm sm:text-base">Order
                            Food</a>
                    </div>
                </div>
                <div class="bounce flex w-full h-auto flex-col mt-10 sm:mt-20 justify-center items-center">
                    <div
                        class="flex items-center text-slate-100 flex-row justify-center w-[80%] h-auto gap-2 pb-3 text-center">
                        <p class="text-xs sm:text-sm">Scroll Down</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-6 sm:w-8 h-auto pt-1 text-white">
                        <path fill-rule="evenodd"
                            d="M11.47 13.28a.75.75 0 0 0 1.06 0l7.5-7.5a.75.75 0 0 0-1.06-1.06L12 11.69 5.03 4.72a.75.75 0 0 0-1.06 1.06l7.5 7.5Z"
                            clip-rule="evenodd"></path>
                        <path fill-rule="evenodd"
                            d="M11.47 19.28a.75.75 0 0 0 1.06 0l7.5-7.5a.75.75 0 1 0-1.06-1.06L12 17.69l-6.97-6.97a.75.75 0 0 0-1.06 1.06l7.5 7.5Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            </header>
        </section>

        <!-- Services Section -->
        <section
            class="w-full bg-[#1a1a1a] max-w-[120rem] h-auto flex justify-center items-center flex-col pb-12 px-4 sm:px-6 md:px-10 lg:px-14">
            <header class="flex w-full h-auto items-center flex-col justify-center text-center pb-8 sm:pb-16">
                <h2 class="shimmer-text text-xl sm:text-2xl md:text-4xl font-extrabold pt-5 pb-2 text-center"><span
                        class="underline underline-offset-4 decoration-white">Our</span> Services</h2>
                <p class="text-sm sm:text-base md:text-lg font-normal text-slate-100 text-center">Choose the service you
                    need!</p>
            </header>

            <div class="grid md:grid-cols-2 gap-6 sm:gap-8 max-w-4xl mx-auto w-full">
                <a href="/grandschedule" class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-4 sm:p-6 h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-black/10 p-2 sm:p-3 rounded-full mr-3 sm:mr-4">
                                        <i class="fas fa-calendar-alt text-black text-lg sm:text-xl"></i>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">TAKATO HOUSE</h3>
                                </div>
                                <p class="text-sm sm:text-base text-gray-600 mb-4 flex-grow">Manage your villa bookings
                                    with our intuitive calendar system. See availability at a glance and update status
                                    with just a few clicks.</p>
                                <div class="text-center">
                                    <button
                                        class="bg-black text-white px-4 sm:px-6 py-2 rounded-full hover:bg-gray-800 transition text-sm sm:text-base">Click</button>
                                </div>
                            </div>
                        </div>
                        <div class="flip-card-back">
                            <img src="https://cdn-icons-png.flaticon.com/512/3652/3652191.png" alt="Calendar Icon">
                        </div>
                    </div>
                </a>

                <a href="#" class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-4 sm:p-6 h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-black/10 p-2 sm:p-3 rounded-full mr-3 sm:mr-4">
                                        <i class="fas fa-utensils text-black text-lg sm:text-xl"></i>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">TAKATO RESTO</h3>
                                </div>
                                <p class="text-sm sm:text-base text-gray-600 mb-4 flex-grow">Streamline your restaurant
                                    operations with our integrated ordering system. From menu management to payment
                                    processing.</p>
                                <div class="text-center">
                                    <button
                                        class="bg-black text-white px-4 sm:px-6 py-2 rounded-full hover:bg-gray-800 transition text-sm sm:text-base">Order</button>
                                </div>
                            </div>
                        </div>
                        <div class="flip-card-back" style="background-color: rgb(0, 109, 78);">
                            <img src="/cafe2.png" alt="Restaurant Image" class="w-full h-full object-contain">
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Villa Facilities Section -->
        <section id="facilities" class="py-12 sm:py-20 bg-gradient-to-b from-gray-900 to-black text-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8 sm:mb-16">
                    <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white mb-4 font-serif">Takato Residence
                    </h2>
                    <p class="text-base sm:text-xl text-gray-300 max-w-2xl mx-auto">Rumah Mewah dengan Halaman Luas di
                        Bogor</p>
                    <div class="w-24 h-1 bg-gradient-to-r from-white to-gray-400 mx-auto mt-6 rounded-full"></div>
                </div>

                <div class="grid lg:grid-cols-3 gap-6 sm:gap-8 mb-8 sm:mb-12">
                    <div
                        class="lg:col-span-2 bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200 text-gray-800">
                        <div class="p-4 sm:p-8">
                            <div class="flex items-center mb-4 sm:mb-6">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                                    <i class="fas fa-home text-white text-base sm:text-lg"></i>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold">Gambaran Properti</h3>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4 sm:gap-8 mb-4 sm:mb-6">
                                <div class="space-y-4 sm:space-y-6">
                                    <div>
                                        <h4
                                            class="text-xs sm:text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                            LOKASI</h4>
                                        <p class="text-sm sm:text-lg flex items-center">
                                            <i class="fas fa-map-marker-alt text-gray-700 mr-2"></i>
                                            Jl. Babakan Palasari No. 1, Cihideung, Bogor
                                        </p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                        <div class="bg-gray-100 p-3 sm:p-4 rounded-xl">
                                            <h4
                                                class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">
                                                LUAS TANAH</h4>
                                            <p class="text-xl sm:text-2xl font-bold">5,360 <span
                                                    class="text-sm sm:text-base font-normal">m²</span></p>
                                        </div>
                                        <div class="bg-gray-100 p-3 sm:p-4 rounded-xl">
                                            <h4
                                                class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">
                                                LUAS BANGUNAN</h4>
                                            <p class="text-xl sm:text-2xl font-bold">1,000 <span
                                                    class="text-sm sm:text-base font-normal">m²</span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4 sm:space-y-6">
                                    <div>
                                        <h4
                                            class="text-xs sm:text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                            STATUS HUKUM</h4>
                                        <div
                                            class="flex items-center bg-gray-100 px-3 sm:px-4 py-2 sm:py-3 rounded-xl">
                                            <i
                                                class="fas fa-file-contract text-gray-700 mr-2 sm:mr-3 text-sm sm:text-base"></i>
                                            <span class="font-medium text-sm sm:text-base">SHM (3 Sertifikat)</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-xs sm:text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                            POSISI</h4>
                                        <div
                                            class="flex items-center bg-gray-100 px-3 sm:px-4 py-2 sm:py-3 rounded-xl">
                                            <i
                                                class="fas fa-compass text-gray-700 mr-2 sm:mr-3 text-sm sm:text-base"></i>
                                            <span class="font-medium text-sm sm:text-base">Hook</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="h-48 sm:h-64 md:h-80 w-full bg-gray-200 relative">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.347344724797!2d106.7978513152944!3d-6.603873966187785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5d1a5a5a5a5%3A0x5a5a5a5a5a5a5a5!2sJl.%20Babakan%20Palasari%20No.1%2C%20Cihideung%2C%20Bogor!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                class="absolute inset-0"></iframe>
                        </div>

                        <div class="p-4 sm:p-6 bg-gray-100">
                            <h4 class="text-xs sm:text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wider">
                                FASILITAS TERDEKAT</h4>
                            <div class="flex flex-wrap gap-2 sm:gap-3">
                                <span
                                    class="bg-white px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm flex items-center border border-gray-200">
                                    <i class="fas fa-road text-gray-700 mr-2"></i>
                                    Gerbang Tol Jagorawi (4km)
                                </span>
                                <span
                                    class="bg-white px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm flex items-center border border-gray-200">
                                    <i class="fas fa-exchange-alt text-gray-700 mr-2"></i>
                                    Tol Bocimi
                                </span>
                                <span
                                    class="bg-white px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm flex items-center border border-gray-200">
                                    <i class="fas fa-bus text-gray-700 mr-2"></i>
                                    Terminal Baranangsiang (4km)
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 sm:space-y-6">
                        <div class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-300 shadow-lg text-gray-800">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-bolt text-white text-xs sm:text-sm"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl font-bold">Kapasitas Listrik</h3>
                            </div>
                            <div class="space-y-2 sm:space-y-3">
                                <div
                                    class="flex justify-between items-center bg-gray-100 px-3 sm:px-4 py-2 sm:py-3 rounded-lg border-l-4 border-gray-700">
                                    <span class="flex items-center text-sm sm:text-base">
                                        <i class="fas fa-circle text-gray-700 mr-2 text-xs"></i>
                                        Daya Utama
                                    </span>
                                    <span class="font-bold text-gray-700 text-sm sm:text-base">6000 watt</span>
                                </div>
                                <div
                                    class="flex justify-between items-center bg-gray-100 px-3 sm:px-4 py-2 sm:py-3 rounded-lg border-l-4 border-gray-600">
                                    <span class="flex items-center text-sm sm:text-base">
                                        <i class="fas fa-circle text-gray-600 mr-2 text-xs"></i>
                                        Sekunder
                                    </span>
                                    <span class="font-bold text-gray-600 text-sm sm:text-base">4000 watt</span>
                                </div>
                                <div
                                    class="flex justify-between items-center bg-gray-100 px-3 sm:px-4 py-2 sm:py-3 rounded-lg border-l-4 border-gray-500">
                                    <span class="flex items-center text-sm sm:text-base">
                                        <i class="fas fa-circle text-gray-500 mr-2 text-xs"></i>
                                        Cadangan
                                    </span>
                                    <span class="font-bold text-gray-500 text-sm sm:text-base">2200 watt</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-200 shadow-lg text-gray-800">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-shield-alt text-white text-xs sm:text-sm"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl font-bold">Fasilitas Keamanan</h3>
                            </div>
                            <div class="space-y-2 sm:space-y-3">
                                <div class="bg-gray-100 p-3 sm:p-4 rounded-lg border border-gray-200">
                                    <div class="flex items-start">
                                        <i
                                            class="fas fa-home text-gray-700 mt-1 mr-2 sm:mr-3 text-sm sm:text-base"></i>
                                        <div>
                                            <h4 class="font-semibold mb-1 text-sm sm:text-base">Rumah Satpam</h4>
                                            <p class="text-xs sm:text-sm text-gray-600">2 kamar tidur, dapur, ruang
                                                tamu, ruang makan, kamar mandi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-100 p-3 sm:p-4 rounded-lg border border-gray-200">
                                    <div class="flex items-start">
                                        <i
                                            class="fas fa-user-shield text-gray-700 mt-1 mr-2 sm:mr-3 text-sm sm:text-base"></i>
                                        <div>
                                            <h4 class="font-semibold mb-1 text-sm sm:text-base">Pos Satpam</h4>
                                            <p class="text-xs sm:text-sm text-gray-600">1 kamar tidur, 1 kamar mandi
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-200 shadow-lg text-gray-800">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-briefcase text-white text-xs sm:text-sm"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl font-bold">Fasilitas Bisnis</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                    <i class="fas fa-chart-line text-gray-700 text-lg sm:text-xl mb-2"></i>
                                    <p class="font-medium text-xs sm:text-sm">Ruang Meeting</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div
                        class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-200 shadow-lg hover:border-gray-400 transition-all duration-300 text-gray-800">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bed text-white text-xs sm:text-sm"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold">Ruang Hunian</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-bed text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">12 Kamar Tidur</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-bath text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">9 Kamar Mandi</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-couch text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Ruang Tamu</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-users text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Ruang Keluarga</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-200 shadow-lg hover:border-gray-400 transition-all duration-300 text-gray-800">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-utensils text-white text-xs sm:text-sm"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold">Dapur & Makan</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-blender text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">2 Dapur Bersih</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-fire text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Dapur Kotor</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-utensils text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">2 Ruang Makan</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-car text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">2 Garasi</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-200 shadow-lg hover:border-gray-400 transition-all duration-300 text-gray-800">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-swimming-pool text-white text-xs sm:text-sm"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold">Rekreasi</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-swimming-pool text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Kolam Renang</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-table-tennis text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Badminton Indoor</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-fish text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Kolam Pancing</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-umbrella-beach text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Balkon Besar</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-200 shadow-lg hover:border-gray-400 transition-all duration-300 text-gray-800">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-tools text-white text-xs sm:text-sm"></i>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold">Utilitas</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-tshirt text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Area Laundry</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-boxes text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Gudang</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-fire-alt text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Gazebo</p>
                                <p class="text-xs text-gray-500">untuk memasak</p>
                            </div>
                            <div class="bg-gray-100 p-2 sm:p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-place-of-worship text-gray-700 text-lg sm:text-xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Musholla</p>
                                <p class="text-xs text-gray-500">+ WC + Wudhu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-8 sm:mt-12 bg-white rounded-2xl p-4 sm:p-8 border border-gray-200 shadow-xl text-gray-800">
                    <div class="flex items-center mb-4 sm:mb-8">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                            <i class="fas fa-camera text-white text-base sm:text-lg"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold">Galeri Foto</h3>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5">
                        <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden group relative">
                            <img src="/d4224d93-1c8e-4e14-99bb-ba71fae20bd0.jpg" alt="Properti Takato"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-3 sm:p-4">
                                <span class="text-white font-medium text-xs sm:text-sm">Takato Residence</span>
                            </div>
                        </div>
                        <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden group relative">
                            <img src="/b4a28977-cc48-4899-b1f2-ffbaf68b22dc.jpg" alt="Properti Takato"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-3 sm:p-4">
                                <span class="text-white font-medium text-xs sm:text-sm">Takato Residence</span>
                            </div>
                        </div>
                        <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden group relative">
                            <img src="/5464b013-f73b-4a1c-abbd-2c82191a6c24.jpg" alt="Properti Takato"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-3 sm:p-4">
                                <span class="text-white font-medium text-xs sm:text-sm">Takato Residence</span>
                            </div>
                        </div>
                        <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden group relative">
                            <img src="/904b43c3-7771-49cb-9994-7df19df0071e.jpg" alt="Properti Takato"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-3 sm:p-4">
                                <span class="text-white font-medium text-xs sm:text-sm">Takato Residence</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-6 text-center">
                        <button
                            class="px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-gray-700 to-gray-800 rounded-full text-white font-medium hover:shadow-lg transition-all duration-300 flex items-center mx-auto text-sm sm:text-base">
                            <i class="fas fa-images mr-2"></i>
                            Lihat Galeri Lengkap
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Restaurant Section -->
        <section id="resto" class="py-12 sm:py-20 bg-gray-100">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8 sm:mb-16">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4">Pengalaman Takato Resto
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">Temukan fasilitas makan kami yang
                        istimewa di jantung Bogor</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 sm:gap-12 items-center">
                    <div class="relative order-2 md:order-1">
                        <div class="rounded-2xl overflow-hidden shadow-xl h-[400px] sm:h-[500px] md:h-[700px]">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.152651053472!2d106.79827731537068!3d-6.628980966396264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMzcnNDQuMyJTIDEwNsKwNDgnMDEuNiJF!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                class="rounded-2xl" title="Lokasi Takato Resto"></iframe>
                        </div>
                    </div>

                    <div class="order-1 md:order-2">
                        <div
                            class="bg-white p-4 sm:p-8 rounded-xl shadow-lg border-l-4 border-gray-700 mb-6 sm:mb-8 transform hover:-translate-y-1 transition duration-300">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Jam Operasional</h3>
                            <div class="grid grid-cols-2 gap-4 text-gray-600 text-sm sm:text-base">
                                <div>
                                    <p class="font-semibold">Senin - Jumat</p>
                                    <p>06:00 - 23:00</p>
                                </div>
                                <div>
                                    <p class="font-semibold">Akhir Pekan</p>
                                    <p>06:00 - 24:00</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-xs sm:text-sm text-gray-500">
                                <i class="fas fa-clock mr-2 text-gray-700"></i>
                                <span>Pesanan terakhir 30 menit sebelum tutup</span>
                            </div>
                        </div>

                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Fasilitas Kami</h3>
                            <ul class="space-y-3 sm:space-y-5">
                                <li
                                    class="flex items-start bg-white/50 p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                    <div class="bg-gray-100 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 text-gray-700">
                                        <i class="fas fa-utensils text-base sm:text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base">Masakan Autentik
                                        </h4>
                                        <p class="text-gray-600 text-xs sm:text-sm">Rasakan cita rasa asli yang dibuat
                                            oleh koki kami yang ahli</p>
                                    </div>
                                </li>
                                <li
                                    class="flex items-start bg-white/50 p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                    <div class="bg-gray-100 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 text-gray-700">
                                        <i class="fas fa-coffee text-base sm:text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base">Kopi Premium</h4>
                                        <p class="text-gray-600 text-xs sm:text-sm">Kopi spesial dari biji kopi lokal
                                            Bogor</p>
                                    </div>
                                </li>
                                <li
                                    class="flex items-start bg-white/50 p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                    <div class="bg-gray-100 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 text-gray-700">
                                        <i class="fas fa-wifi text-base sm:text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base">WiFi Gratis</h4>
                                        <p class="text-gray-600 text-xs sm:text-sm">Tetap terhubung dengan internet
                                            berkecepatan tinggi</p>
                                    </div>
                                </li>
                                <li
                                    class="flex items-start bg-white/50 p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                    <div class="bg-gray-100 p-2 sm:p-3 rounded-full mr-3 sm:mr-4 text-gray-700">
                                        <i class="fas fa-parking text-base sm:text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base">Area Parkir Luas
                                        </h4>
                                        <p class="text-gray-600 text-xs sm:text-sm">Tersedia tempat parkir yang nyaman
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div
                            class="bg-white p-4 sm:p-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition duration-300">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3">Lokasi Kami</h3>
                            <p class="text-gray-600 mb-4 text-xs sm:text-sm">Temukan kami di Jl. Babakan Palasari No.
                                1, Cihideung, Bogor. Terletak di lokasi yang strategis dengan akses mudah dari jalan
                                utama, restoran kami menawarkan suasana yang nyaman untuk acara keluarga, rapat bisnis,
                                atau makan sendirian.</p>
                            <div class="flex items-center text-xs sm:text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-700"></i>
                                <span>5 menit dari Kebun Raya Bogor</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 sm:mt-20">
                    <h3 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-6 sm:mb-10">Menu Unggulan
                    </h3>
                    <div class="grid md:grid-cols-3 gap-6 sm:gap-8">
                        <div
                            class="bg-white rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                            <div class="h-48 sm:h-72 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                                    alt="Nasi Liwet Komplit"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4 sm:p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-bold text-base sm:text-xl text-gray-800">Nasi Liwet Komplit</h4>
                                    <span
                                        class="bg-gray-100 text-gray-700 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold">Terlaris</span>
                                </div>
                                <p class="text-gray-600 mb-4 text-xs sm:text-sm">Hidangan nasi khas Sunda dengan
                                    berbagai lauk pelengkap</p>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-gray-800 text-base sm:text-lg">Rp 45.000</span>
                                    <button
                                        class="text-gray-700 hover:text-gray-900 font-semibold text-xs sm:text-sm flex items-center">
                                        Lihat Detail <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                            <div class="h-48 sm:h-72 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                                    alt="Kopi Spesial Bogor"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4 sm:p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-bold text-base sm:text-xl text-gray-800">Kopi Spesial Bogor</h4>
                                    <span
                                        class="bg-gray-100 text-gray-700 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold">Favorit</span>
                                </div>
                                <p class="text-gray-600 mb-4 text-xs sm:text-sm">Kopi premium lokal dengan penyajian
                                    tradisional</p>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-gray-800 text-base sm:text-lg">Rp 25.000</span>
                                    <button
                                        class="text-gray-700 hover:text-gray-900 font-semibold text-xs sm:text-sm flex items-center">
                                        Lihat Detail <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                            <div class="h-48 sm:h-72 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1579954115561-d6cd8998c57a?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                                    alt="Es Campur Takato"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4 sm:p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-bold text-base sm:text-xl text-gray-800">Es Campur Takato</h4>
                                    <span
                                        class="bg-gray-100 text-gray-700 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold">Segar</span>
                                </div>
                                <p class="text-gray-600 mb-4 text-xs sm:text-sm">Es campur khas Indonesia dengan resep
                                    spesial</p>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-gray-800 text-base sm:text-lg">Rp 30.000</span>
                                    <button
                                        class="text-gray-700 hover:text-gray-900 font-semibold text-xs sm:text-sm flex items-center">
                                        Lihat Detail <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Reviews Section -->
        <section id="reviews" class="py-12 sm:py-20 bg-gradient-to-br from-gray-800 to-black">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white mb-4 font-serif">Customer Reviews
                    </h2>
                    <p class="text-base sm:text-xl text-white max-w-3xl mx-auto">Apa kata mereka yang telah merasakan
                        pengalaman di TAKATO Residence</p>
                    <div class="w-24 h-1 bg-gradient-to-r from-white to-gray-400 mx-auto mt-6 rounded-full"></div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl p-4 sm:p-8 mb-8 sm:mb-12 max-w-4xl mx-auto">
                    <div class="grid md:grid-cols-3 gap-6 sm:gap-8 items-center">
                        <div class="text-center">
                            <div class="text-4xl sm:text-6xl font-bold text-gray-700 mb-2">4.4</div>
                            <div class="flex justify-center mb-2">
                                <i class="fas fa-star text-yellow-400 text-base sm:text-xl"></i>
                                <i class="fas fa-star text-yellow-400 text-base sm:text-xl"></i>
                                <i class="fas fa-star text-yellow-400 text-base sm:text-xl"></i>
                                <i class="fas fa-star text-yellow-400 text-base sm:text-xl"></i>
                                <i class="fas fa-star-half-alt text-yellow-400 text-base sm:text-xl"></i>
                            </div>
                            <p class="text-gray-600 text-xs sm:text-base">Berdasarkan 43 ulasan</p>
                        </div>

                        <div class="md:col-span-2">
                            <div class="space-y-2 sm:space-y-3">
                                <div class="flex items-center">
                                    <span class="text-xs sm:text-sm w-6 sm:w-8">5★</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 sm:h-3 mx-2 sm:mx-3">
                                        <div class="bg-yellow-400 h-2 sm:h-3 rounded-full" style="width: 60%"></div>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-600 w-10 sm:w-12">60%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-xs sm:text-sm w-6 sm:w-8">4★</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 sm:h-3 mx-2 sm:mx-3">
                                        <div class="bg-yellow-400 h-2 sm:h-3 rounded-full" style="width: 25%"></div>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-600 w-10 sm:w-12">25%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-xs sm:text-sm w-6 sm:w-8">3★</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 sm:h-3 mx-2 sm:mx-3">
                                        <div class="bg-yellow-400 h-2 sm:h-3 rounded-full" style="width: 10%"></div>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-600 w-10 sm:w-12">10%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-xs sm:text-sm w-6 sm:w-8">2★</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 sm:h-3 mx-2 sm:mx-3">
                                        <div class="bg-yellow-400 h-2 sm:h-3 rounded-full" style="width: 3%"></div>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-600 w-10 sm:w-12">3%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-xs sm:text-sm w-6 sm:w-8">1★</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 sm:h-3 mx-2 sm:mx-3">
                                        <div class="bg-yellow-400 h-2 sm:h-3 rounded-full" style="width: 2%"></div>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-600 w-10 sm:w-12">2%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative mb-2">
                    <button
                        class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 rounded-full p-2 sm:p-3 shadow-lg ml-2 hover:bg-white transition-all hidden md:block"
                        id="review-prev">
                        <i class="fas fa-chevron-left text-gray-700"></i>
                    </button>
                    <button
                        class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 rounded-full p-2 sm:p-3 shadow-lg mr-2 hover:bg-white transition-all hidden md:block"
                        id="review-next">
                        <i class="fas fa-chevron-right text-gray-700"></i>
                    </button>

                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-in-out pb-12" id="reviews-slider">
                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-2 sm:px-4 mb-12">
                                <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 h-full">
                                    <div class="flex items-start mb-4">
                                        <div
                                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-gray-600 to-gray-700 rounded-full flex items-center justify-center text-white font-bold text-base sm:text-lg mr-3 sm:mr-4">
                                            R</div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900 text-sm sm:text-base">Rizfa Sachika</h3>
                                            <div class="flex items-center mb-1">
                                                <div class="flex text-yellow-400 mr-2">
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                </div>
                                                <span class="text-xs sm:text-sm text-gray-500">• 2 bulan lalu</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-4 text-xs sm:text-sm">"Tempatnya nyaman banget adem,
                                        villanya bersih, luas saya buat acara keluarga enak banget. parkirannya juga
                                        luas. TOPP🫶🏻"</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-400">Acara Keluarga</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-2 sm:px-4 mb-12">
                                <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 h-full">
                                    <div class="flex items-start mb-4">
                                        <div
                                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-gray-600 to-gray-700 rounded-full flex items-center justify-center text-white font-bold text-base sm:text-lg mr-3 sm:mr-4">
                                            A</div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900 text-sm sm:text-base">Agus Suwarko</h3>
                                            <div class="flex items-center mb-1">
                                                <div class="flex text-yellow-400 mr-2">
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="far fa-star text-xs sm:text-sm"></i>
                                                </div>
                                                <span class="text-xs sm:text-sm text-gray-500">• 11 bulan lalu</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-4 text-xs sm:text-sm">"Tempatnya nyaman. Minim tempat
                                        sampah di area kebunnya"</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-400">Feedback konstruktif</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-2 sm:px-4 mb-12">
                                <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 h-full">
                                    <div class="flex items-start mb-4">
                                        <div
                                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-gray-600 to-gray-700 rounded-full flex items-center justify-center text-white font-bold text-base sm:text-lg mr-3 sm:mr-4">
                                            M</div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900 text-sm sm:text-base">Muhamad Zahra</h3>
                                            <div class="flex items-center mb-1">
                                                <div class="flex text-yellow-400 mr-2">
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                    <i class="fas fa-star text-xs sm:text-sm"></i>
                                                </div>
                                                <span class="text-xs sm:text-sm text-gray-500">• 4 tahun lalu</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-4 text-xs sm:text-sm">"Tempat yang bagus dan nyaman,
                                        dengan fasilitas yang lengkap dan servis yang memuaskan"</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-400">Verified stay</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="https://www.google.com/maps/place/TAKATO+House/@-6.6678079,106.7955884,871m/data=!3m1!1e3!4m14!1m5!8m4!1e1!2s108577363218960224761!3m1!1e1!3m7!1s0x2e69cfd0917512e5:0x4f4e592292796e69!8m2!3d-6.6678132!4d106.7981633!9m1!1b1!16s%2Fg%2F11gs5pgnyq?hl=id&entry=ttu&g_ep=EgoyMDI5MDgwNC.0wIKXMDSoASAFQAw%3D%3D"
                        target="_blank" rel="noopener noreferrer"
                        class="inline-block bg-gradient-to-r from-gray-700 to-gray-800 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full hover:from-gray-800 hover:to-gray-900 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-sm sm:text-base">
                        <i class="fas fa-comment-alt mr-2"></i>
                        Lihat Semua Ulasan
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-[#1a1a1a] w-full" role="contentinfo">
        <div class="justify-center xl:justify-between items-end flex h-auto flex-row w-full px-4 md:px-9">
            <div class="footer-img w-auto flex-row items-end gap-6 hidden xl:flex">
                <div class="w-10 h-10 bg-gray-600 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-500 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-400 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-600 rounded-full scale-x-[-1]"></div>
            </div>
            <div class="max-w-[30rem] py-6 h-auto flex flex-col justify-center items-center text-center">
                <div class="text-xl sm:text-2xl font-bold shimmer-text mb-3">TAKATO</div>
                <p class="text-slate-100 text-xs sm:text-sm md:text-md mb-2">© 2024 - 2025 <strong
                        class="shimmer-text">TAKATO Villa & Restaurant</strong>. All rights reserved.</p>
                <p class="text-xs sm:text-sm shimmer-text"><span class="font-medium">TAKATO</span> - Your premium
                    destination for luxury stays and fine dining.</p>
            </div>
            <div class="footer-img w-auto flex-row items-end gap-6 hidden xl:flex">
                <div class="w-10 h-10 bg-gray-600 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-500 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-400 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                <div class="w-10 h-10 bg-gray-600 rounded-full scale-x-[-1]"></div>
            </div>
        </div>
    </footer>

    <aside class="z-[1008] bounce fixed bottom-8 right-2 md:right-5 flex items-end flex-col gap-2">
        <a href="https://wa.me/your-number" class="cursor-pointer flex hover:scale-110 transition-transform"
            target="_blank" rel="noopener noreferrer">
            <div
                class="w-12 h-12 md:w-16 md:h-16 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                <i class="fab fa-whatsapp text-white text-xl md:text-2xl"></i>
            </div>
        </a>
    </aside>
    <aside
        class="z-[1008] bounce fixed bottom-[5.5rem] md:bottom-[8rem] right-2 md:right-5 flex items-end flex-col gap-2">
        <a href="tel:your-number" class="cursor-pointer flex hover:scale-110 transition-transform">
            <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-700 rounded-full flex items-center justify-center shadow-lg">
                <i class="fas fa-phone text-white text-xl md:text-2xl"></i>
            </div>
        </a>
    </aside>

    <div class="ghost-container hidden md:block"></div>

    <script>
        // Active section tracking
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

        function setActiveLink() {
            let current = '';
            const scrollPos = window.scrollY + 100;

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });

            mobileNavLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', setActiveLink);
        window.addEventListener('load', setActiveLink);

        // Mobile menu
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.querySelector('.mobile-menu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('active');
            });
        }

        if (closeMenuBtn) {
            closeMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        }

        // Close mobile menu when clicking a link
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Smooth scroll
        function scrollToSection(selector) {
            const el = document.querySelector(selector);
            if (el) {
                const offset = 80;
                const top = el.offsetTop - offset;
                window.scrollTo({
                    top: top,
                    behavior: 'smooth'
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('a[href^="#"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = link.getAttribute('href');
                    if (target && target !== '#') {
                        scrollToSection(target);
                    }
                });
            });

            // Reviews slider with auto-slide
            const slider = document.getElementById('reviews-slider');
            const prevBtn = document.getElementById('review-prev');
            const nextBtn = document.getElementById('review-next');
            const reviews = document.querySelectorAll('#reviews-slider > div');

            if (slider && reviews.length > 0) {
                let currentIndex = 0;
                let autoSlideInterval;
                const cardWidth = reviews[0].offsetWidth;
                const getVisibleCards = () => window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;

                function updateSliderPosition() {
                    const offset = -currentIndex * cardWidth;
                    slider.style.transform = `translateX(${offset}px)`;
                }

                function nextSlide() {
                    const visibleCards = getVisibleCards();
                    if (currentIndex < reviews.length - visibleCards) {
                        currentIndex++;
                    } else {
                        currentIndex = 0;
                    }
                    updateSliderPosition();
                }

                function prevSlide() {
                    const visibleCards = getVisibleCards();
                    if (currentIndex > 0) {
                        currentIndex--;
                    } else {
                        currentIndex = reviews.length - visibleCards;
                    }
                    updateSliderPosition();
                }

                function startAutoSlide() {
                    autoSlideInterval = setInterval(nextSlide, 4000);
                }

                function stopAutoSlide() {
                    clearInterval(autoSlideInterval);
                }

                if (nextBtn && prevBtn) {
                    nextBtn.addEventListener('click', () => {
                        stopAutoSlide();
                        nextSlide();
                        startAutoSlide();
                    });

                    prevBtn.addEventListener('click', () => {
                        stopAutoSlide();
                        prevSlide();
                        startAutoSlide();
                    });
                }

                // Start auto-slide
                startAutoSlide();

                // Pause on hover
                slider.parentElement.addEventListener('mouseenter', stopAutoSlide);
                slider.parentElement.addEventListener('mouseleave', startAutoSlide);

                // Handle resize
                let resizeTimer;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => {
                        currentIndex = 0;
                        updateSliderPosition();
                    }, 250);
                });
            }
        });

        // Animated floating elements
        (() => {
            const canvas = document.createElement('canvas');
            const container = document.querySelector('.ghost-container');
            if (!container) return;

            container.appendChild(canvas);
            canvas.style.position = 'fixed';
            canvas.style.top = 0;
            canvas.style.left = 0;
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            canvas.style.pointerEvents = 'none';
            canvas.style.zIndex = 9999;

            const ctx = canvas.getContext('2d');
            let width = window.innerWidth;
            let height = window.innerHeight;
            canvas.width = width;
            canvas.height = height;

            const shapes = [];
            const ks = 8;

            for (let i = 0; i < ks; i++) {
                shapes.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    dx: (Math.random() - 0.5) * 1.5,
                    dy: (Math.random() - 0.5) * 1.5,
                    size: Math.random() * 20 + 15,
                    opacity: Math.random() * 0.3 + 0.2,
                    rotation: Math.random() * 360,
                    color: `rgba(255, 255, 255, ${Math.random() * 0.3 + 0.1})`,
                    type: Math.floor(Math.random() * 3)
                });
            }

            function drawShape(obj) {
                ctx.save();
                ctx.globalAlpha = obj.opacity;
                ctx.translate(obj.x, obj.y);
                ctx.rotate(obj.rotation);
                ctx.fillStyle = obj.color;

                switch (obj.type) {
                    case 0:
                        ctx.beginPath();
                        ctx.arc(0, 0, obj.size / 2, 0, Math.PI * 2);
                        ctx.fill();
                        break;
                    case 1:
                        ctx.beginPath();
                        ctx.moveTo(0, -obj.size / 2);
                        ctx.lineTo(obj.size / 2, obj.size / 2);
                        ctx.lineTo(-obj.size / 2, obj.size / 2);
                        ctx.closePath();
                        ctx.fill();
                        break;
                    case 2:
                        ctx.fillRect(-obj.size / 2, -obj.size / 2, obj.size, obj.size);
                        break;
                }

                ctx.restore();
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);
                shapes.forEach(obj => {
                    obj.x += obj.dx;
                    obj.y += obj.dy;
                    obj.rotation += 0.03;

                    if (obj.x < 0 || obj.x > width) obj.dx *= -1;
                    if (obj.y < 0 || obj.y > height) obj.dy *= -1;

                    if (Math.random() < 0.01) {
                        obj.dx += (Math.random() - 0.5) * 0.1;
                        obj.dy += (Math.random() - 0.5) * 0.1;
                    }

                    drawShape(obj);
                });

                requestAnimationFrame(animate);
            }

            animate();

            window.addEventListener('resize', () => {
                width = window.innerWidth;
                height = window.innerHeight;
                canvas.width = width;
                canvas.height = height;
            });
        })();
    </script>
</body>

</html>
