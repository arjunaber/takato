<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAKATO - Luxury Villa & Premium Restaurant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ... (CSS Anda yang lain tetap sama) ... */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0a0a;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* Animasi Fade-in */
        .fade-in-section {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animasi Text Gradient (Indigo/Purple/Pink) */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 4s ease infinite;
        }

        @keyframes gradientShift {

            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Partikel Canvas */
        .particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            opacity: 0.6;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Hover Effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
        }

        /* Navigation */
        nav a.active {
            color: #667eea !important;
            position: relative;
        }

        nav a.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Slider */
        #reviews-slider {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #reviews-slider>div {
            flex: 0 0 auto;
        }

        /* Accent Line */
        .accent-line {
            height: 3px;
            background: linear-gradient(90deg, transparent, #667eea, #764ba2, transparent);
            animation: lineGlow 3s ease-in-out infinite;
        }

        @keyframes lineGlow {

            0%,
            100% {
                opacity: 0.5;
            }

            50% {
                opacity: 1;
            }
        }

        /* Button Glow */
        .btn-glow {
            position: relative;
            overflow: hidden;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-glow:hover::before {
            left: 100%;
        }

        /* Floating Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Image Parallax Effect */
        .parallax-img {
            transition: transform 0.3s ease-out;
        }

        .parallax-container:hover .parallax-img {
            transform: scale(1.05);
        }

        /* BLEED EFFECT KUSTOM PADA GAMBAR */
        @media (min-width: 1024px) {

            /* Memaksa elemen di lg:w-1/2 untuk menempel ke kiri viewport */
            .bleed-left-container {
                /* (Lebar Viewport - Lebar Kontainer Max) / 2 */
                margin-left: calc(50% - 38rem);
                /* Biarkan width penuh */
                width: 100vw;
            }

            /* Memaksa elemen di lg:w-1/2 untuk menempel ke kanan viewport */
            .bleed-right-container {
                /* (Lebar Viewport - Lebar Kontainer Max) / 2 */
                margin-right: calc(50% - 38rem);
                /* Biarkan width penuh */
                width: 100vw;
            }

            /* Agar gambar tidak memiliki rounded-corner di sisi bleed */
            .bleed-left-image {
                border-top-left-radius: 0 !important;
                border-bottom-left-radius: 0 !important;
            }

            .bleed-right-image {
                border-top-right-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }
        }

        /* PERBAIKAN: Z-index untuk modal gallery */
        #galleryModal {
            z-index: 10050 !important;
        }

        #closeGalleryBtn {
            z-index: 10051 !important;
        }

        /* PERBAIKAN: Responsivitas untuk bagian facilities */
        @media (max-width: 640px) {
            .facilities-grid {
                grid-template-columns: 1fr !important;
            }

            .facility-item {
                grid-template-columns: 1fr !important;
            }

            .facility-icon {
                width: 100% !important;
                justify-content: center !important;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<body class="bg-black text-white">
    <canvas class="particles-canvas"></canvas>

    <nav id="desktopNav"
        class="z-[1004] hidden md:flex fixed top-0 left-0 w-full h-auto justify-center items-center py-4 px-10 glass-dark">
        <div class="w-full h-auto flex flex-row justify-between items-center gap-7 max-w-7xl">
            <div class="text-2xl font-bold gradient-text font-serif">TAKATO</div>
            <nav class="flex gap-8 px-4" role="navigation">
                <a href="#home"
                    class="nav-link text-gray-300 hover:text-white transition duration-300 py-2 font-medium">Home</a>
                <a href="#services"
                    class="nav-link text-gray-300 hover:text-white transition duration-300 py-2 font-medium">Services</a>
                <a href="#facilities"
                    class="nav-link text-gray-300 hover:text-white transition duration-300 py-2 font-medium">Facilities</a>
                <a href="#resto"
                    class="nav-link text-gray-300 hover:text-white transition duration-300 py-2 font-medium">Restaurant</a>
                <a href="#reviews"
                    class="nav-link text-gray-300 hover:text-white transition duration-300 py-2 font-medium">Reviews</a>
            </nav>
            <div class="px-[2.2rem] bg-transparent"></div>
        </div>
    </nav>

    <nav id="mobileNav"
        class="z-[1004] md:hidden fixed top-0 left-0 w-full flex h-auto justify-center items-center glass-dark py-3 px-6">
        <div class="w-full h-auto flex flex-row justify-between items-center">
            <div class="text-xl font-bold gradient-text font-serif">TAKATO</div>
            <button class="h-10 w-auto text-white" id="mobile-menu-btn">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>

    <div
        class="mobile-menu fixed top-0 right-0 h-full w-64 bg-black/95 backdrop-blur-xl z-[1005] md:hidden border-l border-white/10">
        <div class="flex flex-col h-full">
            <div class="flex justify-between items-center p-6 border-b border-white/10">
                <div class="text-xl font-bold gradient-text font-serif">TAKATO</div>
                <button class="text-white" id="close-menu-btn">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <nav class="flex flex-col p-6 gap-4">
                <a href="#home"
                    class="mobile-nav-link text-gray-300 hover:text-white transition py-3 border-b border-white/5">Home</a>
                <a href="#services"
                    class="mobile-nav-link text-gray-300 hover:text-white transition py-3 border-b border-white/5">Services</a>
                <a href="#facilities"
                    class="mobile-nav-link text-gray-300 hover:text-white transition py-3 border-b border-white/5">Facilities</a>
                <a href="#resto"
                    class="mobile-nav-link text-gray-300 hover:text-white transition py-3 border-b border-white/5">Restaurant</a>
                <a href="#reviews"
                    class="mobile-nav-link text-gray-300 hover:text-white transition py-3 border-b border-white/5">Reviews</a>
            </nav>
        </div>
    </div>

    <main class="relative z-10">
        <section id="home" class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black"></div>
                <img src="/d4224d93-1c8e-4e14-99bb-ba71fae20bd0.jpg" alt="TAKATO Villa"
                    class="w-full h-full object-cover opacity-50">
            </div>

            <div class="relative z-10 text-center px-6 max-w-6xl mx-auto">
                <div class="floating">
                    <h1 class="font-serif text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold mb-6 leading-tight">
                        Where Moments and <br />
                        <span class="gradient-text">Flavors Meet</span>
                    </h1>
                </div>

                <p class="text-lg sm:text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto font-light">
                    Experience exclusive stays in private villas and enjoy authentic culinary delights in one premium
                    destination.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="#facilities"
                        class="group relative px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full font-semibold text-lg overflow-hidden btn-glow hover:shadow-2xl hover:shadow-purple-500/50 transition-all duration-300">
                        <span class="relative z-10 flex items-center gap-3">
                            <i class="fas fa-home"></i>
                            Explore Villa
                        </span>
                    </a>
                    <a href="#resto"
                        class="px-10 py-4 glass rounded-full font-semibold text-lg hover:bg-white/10 transition-all duration-300 border border-white/20">
                        Visit Restaurant
                    </a>
                </div>
            </div>

            <div class="absolute bottom-10 left-1/2 -translate-x-1/2">
                <i class="fas fa-chevron-down text-3xl text-white/50 animate-bounce"></i>
            </div>
        </section>

        <section id="services" class="relative py-24 fade-in-section overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-black via-gray-900 to-black"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 bleed-container">
                <div class="text-center mb-20">
                    <h2 class="font-serif text-4xl sm:text-5xl md:text-6xl font-bold mb-6">
                        The Perfect <span class="gradient-text">Balance</span>
                    </h2>
                    <div class="accent-line w-32 mx-auto mb-6"></div>
                    <p class="text-xl text-gray-400 max-w-3xl mx-auto font-light">
                        From the luxury of private villas to the comfort of a friendly restaurant, we deliver harmony
                        between satisfaction and culinary delight.
                    </p>
                </div>

                <div class="mb-32 fade-in-section">
                    <div class="flex flex-col lg:flex-row items-center gap-12">
                        <div class="lg:w-1/2 parallax-container lg:pr-6">
                            <div class="relative overflow-hidden shadow-2xl rounded-3xl">
                                <img src="/d4224d93-1c8e-4e14-99bb-ba71fae20bd0.jpg" alt="TAKATO House"
                                    class="w-full h-[350px] sm:h-[500px] object-cover parallax-img rounded-3xl">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-1/2 lg:pl-6">
                            <div class="glass p-8 sm:p-10 rounded-3xl card-hover">
                                <div
                                    class="inline-block px-4 py-2 bg-indigo-500/20 rounded-full text-indigo-400 text-sm font-semibold mb-6">
                                    <i class="fas fa-home mr-2"></i>Exclusive Villa
                                </div>
                                <h3 class="font-serif text-3xl lg:text-4xl font-bold mb-6">TAKATO House</h3>
                                <p class="text-gray-300 text-lg leading-relaxed mb-8">
                                    Manage villa reservations with our intuitive and easy calendar system. Monitor room
                                    availability and update booking status with just a few touches.
                                </p>
                                <a href="#facilities"
                                    class="group inline-flex items-center gap-3 text-indigo-400 hover:text-indigo-300 font-semibold text-lg transition-all">
                                    View Full Facilities
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fade-in-section">
                    <div class="flex flex-col lg:flex-row-reverse items-center gap-12">
                        <div class="lg:w-1/2 parallax-container lg:pl-6">
                            <div class="relative overflow-hidden shadow-2xl rounded-3xl">
                                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800&h=600&fit=crop"
                                    alt="TAKATO Resto"
                                    class="w-full h-[350px] sm:h-[500px] object-cover parallax-img rounded-3xl">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-1/2 lg:pr-12">
                            <div class="glass p-8 sm:p-10 rounded-3xl card-hover">
                                <div
                                    class="inline-block px-4 py-2 bg-purple-500/20 rounded-full text-purple-400 text-sm font-semibold mb-6">
                                    <i class="fas fa-utensils mr-2"></i>Premium Restaurant
                                </div>
                                <h3 class="font-serif text-3xl lg:text-4xl font-bold mb-6">TAKATO Restaurant</h3>
                                <p class="text-gray-300 text-lg leading-relaxed mb-8">
                                    Streamline restaurant operations with a perfectly integrated ordering system. From
                                    menu management to payment processing, all in one platform.
                                </p>
                                <a href="#resto"
                                    class="group inline-flex items-center gap-3 text-purple-400 hover:text-purple-300 font-semibold text-lg transition-all">
                                    View Menu & Map
                                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section id="facilities" class="relative py-24 fade-in-section">
            <div class="absolute inset-0 bg-gradient-to-b from-black via-gray-900/50 to-black"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h2 class="font-serif text-4xl sm:text-5xl md:text-6xl font-bold mb-6">
                        TAKATO <span class="gradient-text">Residence</span>
                    </h2>
                    <div class="accent-line w-32 mx-auto mb-6"></div>
                    <p class="text-xl text-gray-400">Luxury Home with Large Garden in Bogor</p>
                </div>

                <div class="grid lg:grid-cols-3 gap-8 mb-16">
                    <div class="lg:col-span-2 glass-dark rounded-3xl p-8 card-hover">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-home text-white text-xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold">Property Overview</h3>
                        </div>

                        <div class="grid md:grid-cols-2 gap-8 mb-8">
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-500 mb-3 uppercase tracking-wider">
                                        Location</h4>
                                    <p class="text-lg flex items-start gap-3">
                                        <i class="fas fa-map-marker-alt text-indigo-400 mt-1"></i>
                                        <span>Jl. Babakan Palasari No. 1, Cihideung, Bogor</span>
                                    </p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="glass p-5 rounded-2xl border border-white/5">
                                        <h4 class="text-xs font-semibold text-gray-500 mb-2 uppercase">Land Area</h4>
                                        <p class="text-3xl font-bold">5,360 <span
                                                class="text-base font-normal text-gray-400">m²</span></p>
                                    </div>
                                    <div class="glass p-5 rounded-2xl border border-white/5">
                                        <h4 class="text-xs font-semibold text-gray-500 mb-2 uppercase">Building Area
                                        </h4>
                                        <p class="text-3xl font-bold">1,000 <span
                                                class="text-base font-normal text-gray-400">m²</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-500 mb-3 uppercase tracking-wider">
                                        Legal Status</h4>
                                    <div
                                        class="glass px-5 py-4 rounded-2xl border border-white/5 flex items-center gap-3">
                                        <i class="fas fa-file-contract text-indigo-400 text-lg"></i>
                                        <span class="font-medium">SHM (3 Certificates)</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-500 mb-3 uppercase tracking-wider">
                                        Position</h4>
                                    <div
                                        class="glass px-5 py-4 rounded-2xl border border-white/5 flex items-center gap-3">
                                        <i class="fas fa-compass text-indigo-400 text-lg"></i>
                                        <span class="font-medium">Hook</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-white/5 pt-6">
                            <h4 class="text-sm font-semibold text-gray-500 mb-4 uppercase tracking-wider">Nearby
                                Facilities</h4>
                            <div class="flex flex-wrap gap-3">
                                <span
                                    class="glass px-4 py-2 rounded-full text-sm flex items-center gap-2 border border-white/5">
                                    <i class="fas fa-road text-indigo-400"></i>
                                    Jagorawi Toll Gate (4km)
                                </span>
                                <span
                                    class="glass px-4 py-2 rounded-full text-sm flex items-center gap-2 border border-white/5">
                                    <i class="fas fa-exchange-alt text-indigo-400"></i>
                                    Bocimi Toll
                                </span>
                                <span
                                    class="glass px-4 py-2 rounded-full text-sm flex items-center gap-2 border border-white/5">
                                    <i class="fas fa-bus text-indigo-400"></i>
                                    Baranangsiang Terminal (4km)
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="glass-dark rounded-3xl p-6 card-hover">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-bolt text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold">Electrical Capacity</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="glass px-5 py-4 rounded-xl border-l-4 border-indigo-500">
                                    <div class="flex justify-between items-center">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-circle text-indigo-500 text-xs"></i>
                                            Main Power
                                        </span>
                                        <span class="font-bold">6000 watt</span>
                                    </div>
                                </div>
                                <div class="glass px-5 py-4 rounded-xl border-l-4 border-indigo-600">
                                    <div class="flex justify-between items-center">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-circle text-indigo-600 text-xs"></i>
                                            Secondary
                                        </span>
                                        <span class="font-bold">4000 watt</span>
                                    </div>
                                </div>
                                <div class="glass px-5 py-4 rounded-xl border-l-4 border-indigo-700">
                                    <div class="flex justify-between items-center">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-circle text-indigo-700 text-xs"></i>
                                            Backup
                                        </span>
                                        <span class="font-bold">2200 watt</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass-dark rounded-3xl p-6 card-hover">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-shield-alt text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold">Security Facilities</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="glass p-4 rounded-xl border border-white/5">
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-home text-indigo-400 mt-1"></i>
                                        <div>
                                            <h4 class="font-semibold mb-1">Guard House</h4>
                                            <p class="text-sm text-gray-400">2 beds, kitchen, living room, dining room,
                                                bathroom</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="glass p-4 rounded-xl border border-white/5">
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-user-shield text-indigo-400 mt-1"></i>
                                        <div>
                                            <h4 class="font-semibold mb-1">Guard Post</h4>
                                            <p class="text-sm text-gray-400">1 bed, 1 bathroom</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="facilities-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto w-full mt-12">
                    <div class="glass-dark rounded-3xl p-6 card-hover facility-item">
                        <div class="flex flex-col sm:flex-row items-center gap-3 mb-6 facility-icon">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-bed text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-center sm:text-left">Living Spaces</h3>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-2 gap-3">
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-bed text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">12 Bedrooms</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-bath text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">9 Bathrooms</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-couch text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Living Room</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-users text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Family Room</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-dark rounded-3xl p-6 card-hover facility-item">
                        <div class="flex flex-col sm:flex-row items-center gap-3 mb-6 facility-icon">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-swimming-pool text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-center sm:text-left">Recreation</h3>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-2 gap-3">
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-swimming-pool text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Swimming Pool</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-table-tennis text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Indoor Badminton</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-fish text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Fishing Pond</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-umbrella-beach text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Large Balcony</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-dark rounded-3xl p-6 card-hover facility-item">
                        <div class="flex flex-col sm:flex-row items-center gap-3 mb-6 facility-icon">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-tools text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-center sm:text-left">Utilities</h3>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-2 gap-3">
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-tshirt text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Laundry Area</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-boxes text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Storage</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-fire-alt text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Gazebo</p>
                                <p class="text-xs text-gray-500 mt-1">for cooking</p>
                            </div>
                            <div class="glass p-3 sm:p-4 rounded-xl text-center border border-white/5">
                                <i class="fas fa-place-of-worship text-indigo-400 text-xl sm:text-2xl mb-2"></i>
                                <p class="font-medium text-xs sm:text-sm">Musala</p>
                                <p class="text-xs text-gray-500 mt-1">+ WC + Ablution</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass p-8 rounded-3xl shadow-2xl max-w-7xl mx-auto w-full mt-20">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-10">
                        <div>
                            <h3 class="font-serif text-3xl font-bold mb-3">Photo Gallery</h3>
                            <p class="text-gray-400 max-w-lg">Take a closer look at the luxury and comfort that awaits
                                you.</p>
                        </div>
                        <button id="openGalleryBtn"
                            class="mt-6 sm:mt-0 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full font-semibold btn-glow hover:shadow-2xl hover:shadow-purple-500/50 transition-all duration-300">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-images"></i>
                                View Full Gallery
                            </span>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="aspect-square rounded-2xl overflow-hidden shadow-xl parallax-container">
                            <img src="/d4224d93-1c8e-4e14-99bb-ba71fae20bd0.jpg" alt="Property Takato 1"
                                class="w-full h-full object-cover parallax-img">
                        </div>
                        <div class="aspect-square rounded-2xl overflow-hidden shadow-xl parallax-container">
                            <img src="/b4a28977-cc48-4899-b1f2-ffbaf68b22dc.jpg" alt="Property Takato 2"
                                class="w-full h-full object-cover parallax-img">
                        </div>
                        <div class="aspect-square rounded-2xl overflow-hidden shadow-xl parallax-container">
                            <img src="/5464b013-f73b-4a1c-abbd-2c82191a6c24.jpg" alt="Property Takato 3"
                                class="w-full h-full object-cover parallax-img">
                        </div>
                        <div class="aspect-square rounded-2xl overflow-hidden shadow-xl parallax-container">
                            <img src="/904b43c3-7771-49cb-9994-7df19df0071e.jpg" alt="Property Takato 4"
                                class="w-full h-full object-cover parallax-img">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="galleryModal" class="fixed inset-0 z-[10050] hidden overflow-y-auto bg-black/95 backdrop-blur-xl">
            <div class="relative min-h-screen w-full">
                <button id="closeGalleryBtn"
                    class="fixed top-8 right-8 z-[10051] w-14 h-14 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded-full text-white text-2xl transition-all">
                    <i class="fas fa-times"></i>
                </button>
                <div class="container mx-auto px-4 py-24">
                    <h2 class="font-serif text-4xl font-bold text-center mb-4 gradient-text">Gallery TAKATO Residence
                    </h2>
                    <div class="accent-line w-32 mx-auto mb-16"></div>
                    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                        <div class="break-inside-avoid">
                            <img src="/d4224d93-1c8e-4e14-99bb-ba71fae20bd0.jpg" alt="TAKATO Residence"
                                class="w-full rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/b4a28977-cc48-4899-b1f2-ffbaf68b22dc.jpg" alt="TAKATO Residence"
                                class="w-full rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/5464b013-f73b-4a1c-abbd-2c82191a6c24.jpg" alt="TAKATO Residence"
                                class="w-full h-64 object-cover rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/904b43c3-7771-49cb-9994-7df19df0071e.jpg" alt="TAKATO Residence"
                                class="w-full rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/806b2a84-eb07-4567-b37b-cbaffeededf5.jpg" alt="TAKATO Residence"
                                class="w-full h-80 object-cover rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/142fecc5-abd2-4de4-b63a-abd998bbe563.avif" alt="TAKATO Residence"
                                class="w-full rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/86f407f5-1207-4772-8e5d-315d0e750c43.avif" alt="TAKATO Residence"
                                class="w-full h-96 object-cover rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/7bc30c68-f20b-4a4f-a237-e0f8f70efa8a.avif" alt="TAKATO Residence"
                                class="w-full rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/2b543991-6b91-41ce-b9db-096d47373a14.avif" alt="TAKATO Residence"
                                class="w-full h-64 object-cover rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/1aab8845-00c7-46bd-92bb-767d70b7c128.avif" alt="TAKATO Residence"
                                class="w-full rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                        <div class="break-inside-avoid">
                            <img src="/0fe6c365-8b57-4987-8e9e-1c78a477889c.avif" alt="TAKATO Residence"
                                class="w-full h-80 object-cover rounded-2xl hover:opacity-90 transition shadow-2xl">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id="resto" class="relative py-24 fade-in-section">
            <div class="absolute inset-0 bg-gradient-to-b from-black via-gray-900 to-black"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h2 class="font-serif text-4xl sm:text-5xl md:text-6xl font-bold mb-6">
                        Experience <span class="gradient-text">TAKATO Restaurant</span>
                    </h2>
                    <div class="accent-line w-32 mx-auto mb-6"></div>
                    <p class="text-xl text-gray-400 max-w-3xl mx-auto">Discover authentic culinary delights in the
                        heart of
                        Bogor city.</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
                    <div class="order-2 lg:order-1">
                        <div class="rounded-3xl overflow-hidden shadow-2xl h-[500px] lg:h-[600px]">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.152651053472!2d106.79827731537068!3d-6.628980966396264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMzcnNDQuMyJTIDEwNsKwNDgnMDEuNiJF!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                class="rounded-3xl"></iframe>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2 space-y-8">
                        <div class="glass-dark p-8 rounded-3xl card-hover">
                            <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                                <i class="fas fa-clock text-indigo-400"></i>
                                Operating Hours
                            </h3>
                            <div class="grid grid-cols-2 gap-6 mb-6">
                                <div>
                                    <p class="font-semibold text-lg mb-2">Monday - Friday</p>
                                    <p class="text-gray-400 text-lg">06:00 - 23:00</p>
                                </div>
                                <div>
                                    <p class="font-semibold text-lg mb-2">Weekends</p>
                                    <p class="text-gray-400 text-lg">06:00 - 24:00</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-gray-400 border-t border-white/5 pt-4">
                                <i class="fas fa-info-circle text-indigo-400"></i>
                                <span>Last order 30 minutes before closing</span>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold mb-6">Restaurant Facilities</h3>
                            <div class="space-y-4">
                                <div class="glass-dark p-6 rounded-2xl flex items-start gap-4 card-hover">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-utensils text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-lg mb-2">Authentic Cuisine</h4>
                                        <p class="text-gray-400">Enjoy authentic flavors prepared by experienced chefs
                                        </p>
                                    </div>
                                </div>
                                <div class="glass-dark p-6 rounded-2xl flex items-start gap-4 card-hover">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-coffee text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-lg mb-2">Premium Coffee</h4>
                                        <p class="text-gray-400">Special coffee from the best selected beans in Bogor
                                        </p>
                                    </div>
                                </div>
                                <div class="glass-dark p-6 rounded-2xl flex items-start gap-4 card-hover">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-wifi text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-lg mb-2">Free WiFi</h4>
                                        <p class="text-gray-400">High-speed internet connection for your convenience
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-serif text-3xl font-bold text-center mb-12">Featured Menu</h3>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="glass-dark rounded-3xl overflow-hidden card-hover">
                            <div class="h-72 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                                    alt="Complete Liwet Rice"
                                    class="w-full h-full object-cover hover:scale-110 transition duration-500">
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="font-bold text-xl">Complete Liwet Rice</h4>
                                    <span
                                        class="px-3 py-1 bg-gradient-to-r from-orange-500/20 to-red-500/20 text-orange-400 rounded-full text-sm font-semibold">Bestseller</span>
                                </div>
                                <p class="text-gray-400 mb-6">Traditional Sundanese rice dish with various side dishes
                                    of choice</p>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-2xl gradient-text">Rp 45.000</span>
                                    <button
                                        class="text-indigo-400 hover:text-indigo-300 font-semibold flex items-center gap-2 group">
                                        Detail
                                        <i
                                            class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="glass-dark rounded-3xl overflow-hidden card-hover">
                            <div class="h-72 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                                    alt="Bogor Special Coffee"
                                    class="w-full h-full object-cover hover:scale-110 transition duration-500">
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="font-bold text-xl">Bogor Special Coffee</h4>
                                    <span
                                        class="px-3 py-1 bg-gradient-to-r from-amber-500/20 to-yellow-500/20 text-amber-400 rounded-full text-sm font-semibold">Favorite</span>
                                </div>
                                <p class="text-gray-400 mb-6">Premium local coffee with special preparation</p>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-2xl gradient-text">Rp 25.000</span>
                                    <button
                                        class="text-indigo-400 hover:text-indigo-300 font-semibold flex items-center gap-2 group">
                                        Detail
                                        <i
                                            class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="glass-dark rounded-3xl overflow-hidden card-hover">
                            <div class="h-72 overflow-hidden">
                                <img src="https://asset.kompas.com/crops/Ps3rFgrW4RMEVul_WIPd81uvPlI=/0x0:968x646/1200x800/data/photo/2024/03/20/65fa68e9d98c8.jpg"
                                    alt="TAKATO Mixed Ice"
                                    class="w-full h-full object-cover hover:scale-110 transition duration-500">
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="font-bold text-xl">TAKATO Mixed Ice</h4>
                                    <span
                                        class="px-3 py-1 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-400 rounded-full text-sm font-semibold">Fresh</span>
                                </div>
                                <p class="text-gray-400 mb-6">Traditional Indonesian mixed ice with our secret recipe
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-2xl gradient-text">Rp 30.000</span>
                                    <button
                                        class="text-indigo-400 hover:text-indigo-300 font-semibold flex items-center gap-2 group">
                                        Detail
                                        <i
                                            class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="reviews" class="relative py-24 fade-in-section">
            <div class="absolute inset-0 bg-gradient-to-b from-black via-gray-900/50 to-black"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h2 class="font-serif text-4xl sm:text-5xl md:text-6xl font-bold mb-6">
                        Customer <span class="gradient-text">Reviews</span>
                    </h2>
                    <div class="accent-line w-32 mx-auto mb-6"></div>
                    <p class="text-xl text-gray-400 max-w-3xl mx-auto">Hear the experience of those who have felt the
                        warmth of TAKATO</p>
                </div>

                <div class="glass-dark rounded-3xl p-10 mb-16 max-w-4xl mx-auto">
                    <div class="grid md:grid-cols-3 gap-10 items-center">
                        <div class="text-center">
                            <div class="text-7xl font-bold gradient-text mb-4">4.4</div>
                            <div class="flex justify-center mb-3">
                                <i class="fas fa-star text-amber-400 text-2xl mx-1"></i>
                                <i class="fas fa-star text-amber-400 text-2xl mx-1"></i>
                                <i class="fas fa-star text-amber-400 text-2xl mx-1"></i>
                                <i class="fas fa-star text-amber-400 text-2xl mx-1"></i>
                                <i class="fas fa-star-half-alt text-amber-400 text-2xl mx-1"></i>
                            </div>
                            <p class="text-gray-400">Based on 43 reviews</p>
                        </div>

                        <div class="md:col-span-2">
                            <div class="space-y-3">
                                <div class="flex items-center gap-4">
                                    <span class="text-sm w-8">5★</span>
                                    <div class="flex-1 bg-gray-800 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-amber-400 to-yellow-500 h-3 rounded-full"
                                            style="width: 60%"></div>
                                    </div>
                                    <span class="text-sm text-gray-400 w-12 text-right">60%</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm w-8">4★</span>
                                    <div class="flex-1 bg-gray-800 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-amber-400 to-yellow-500 h-3 rounded-full"
                                            style="width: 25%"></div>
                                    </div>
                                    <span class="text-sm text-gray-400 w-12 text-right">25%</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm w-8">3★</span>
                                    <div class="flex-1 bg-gray-800 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-amber-400 to-yellow-500 h-3 rounded-full"
                                            style="width: 10%"></div>
                                    </div>
                                    <span class="text-sm text-gray-400 w-12 text-right">10%</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm w-8">2★</span>
                                    <div class="flex-1 bg-gray-800 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-amber-400 to-yellow-500 h-3 rounded-full"
                                            style="width: 3%"></div>
                                    </div>
                                    <span class="text-sm text-gray-400 w-12 text-right">3%</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm w-8">1★</span>
                                    <div class="flex-1 bg-gray-800 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-amber-400 to-yellow-500 h-3 rounded-full"
                                            style="width: 2%"></div>
                                    </div>
                                    <span class="text-sm text-gray-400 w-12 text-right">2%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button
                        class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full shadow-lg transition-all hidden md:flex items-center justify-center -ml-1"
                        id="review-prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button
                        class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full shadow-lg transition-all hidden md:flex items-center justify-center -mr-1"
                        id="review-next">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-in-out" id="reviews-slider">
                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                                <div class="glass-dark rounded-3xl p-8 h-full card-hover">
                                    <div class="flex items-start gap-4 mb-6">
                                        <div
                                            class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                                            R</div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg mb-2">Rizfa Sachika</h3>
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="flex text-amber-400">
                                                    <i class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i>
                                                </div>
                                                <span class="text-sm text-gray-500">• 2 months ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 mb-6 leading-relaxed">"The place is very comfortable and
                                        cool,
                                        the villa is clean and spacious. Perfect for a family event. The parking lot is
                                        also spacious. Recommended!"</p>
                                    <div
                                        class="px-3 py-1 bg-indigo-500/20 rounded-full text-indigo-400 text-sm font-semibold inline-block">
                                        Family Event
                                    </div>
                                </div>
                            </div>

                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                                <div class="glass-dark rounded-3xl p-8 h-full card-hover">
                                    <div class="flex items-start gap-4 mb-6">
                                        <div
                                            class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                                            A</div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg mb-2">Agus Suwarko</h3>
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="flex text-amber-400">
                                                    <i class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="far fa-star text-sm"></i>
                                                </div>
                                                <span class="text-sm text-gray-500">• 11 months ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 mb-6 leading-relaxed">"The place is very comfortable. Maybe
                                        should add trash cans in the garden area."</p>
                                    <div
                                        class="px-3 py-1 bg-blue-500/20 rounded-full text-blue-400 text-sm font-semibold inline-block">
                                        Constructive Feedback
                                    </div>
                                </div>
                            </div>

                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                                <div class="glass-dark rounded-3xl p-8 h-full card-hover">
                                    <div class="flex items-start gap-4 mb-6">
                                        <div
                                            class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                                            M</div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg mb-2">Muhamad Zahra</h3>
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="flex text-amber-400">
                                                    <i class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i>
                                                </div>
                                                <span class="text-sm text-gray-500">• 4 years ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 mb-6 leading-relaxed">"A good and comfortable place, with
                                        complete facilities and satisfying service."</p>
                                    <div
                                        class="px-3 py-1 bg-green-500/20 rounded-full text-green-400 text-sm font-semibold inline-block">
                                        Verified Stay
                                    </div>
                                </div>
                            </div>

                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                                <div class="glass-dark rounded-3xl p-8 h-full card-hover">
                                    <div class="flex items-start gap-4 mb-6">
                                        <div
                                            class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                                            G</div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg mb-2">Gayska Vetotama</h3>
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="flex text-amber-400">
                                                    <i class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="far fa-star text-sm"></i>
                                                </div>
                                                <span class="text-sm text-gray-500">• a year ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 mb-6 leading-relaxed">"Great view, kitchen and room
                                        facilities are okay, enough for 40+ people. Need water system repair."</p>
                                    <div
                                        class="px-3 py-1 bg-orange-500/20 rounded-full text-orange-400 text-sm font-semibold inline-block">
                                        40+ People
                                    </div>
                                </div>
                            </div>

                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                                <div class="glass-dark rounded-3xl p-8 h-full card-hover">
                                    <div class="flex items-start gap-4 mb-6">
                                        <div
                                            class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                                            A
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg mb-2">Aria WN</h3>
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="flex text-amber-400">
                                                    <i class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i>
                                                </div>
                                                <span class="text-sm text-gray-500">• 2 years ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 mb-6 leading-relaxed">"Spacious, has a swimming pool and
                                        indoor
                                        badminton court. Suitable for large events or team building."</p>
                                    <div
                                        class="px-3 py-1 bg-purple-500/20 rounded-full text-purple-400 text-sm font-semibold inline-block">
                                        Team Building
                                    </div>
                                </div>
                            </div>

                            <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                                <div class="glass-dark rounded-3xl p-8 h-full card-hover">
                                    <div class="flex items-start gap-4 mb-6">
                                        <div
                                            class="w-14 h-14 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                                            D
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg mb-2">Denis K70 Bogor</h3>
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="flex text-amber-400">
                                                    <i class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i><i
                                                        class="fas fa-star text-sm"></i>
                                                </div>
                                                <span class="text-sm text-gray-500">• 2 years ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 mb-6 leading-relaxed">"Easy to reach, suitable for family
                                        events. Spacious and very comfortable place."</p>
                                    <div
                                        class="px-3 py-1 bg-teal-500/20 rounded-full text-teal-400 text-sm font-semibold inline-block">
                                        Family Event
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="text-center mt-16">
                    <a href="https://www.google.com/maps/place/TAKATO+House/@-6.6678079,106.7955884,871m/data=!3m1!1e3!4m14!1m5!8m4!1e1!2s108577363218960224761!3m1!1e1!3m7!1s0x2e69cfd0917512e5:0x4f4e592292796e69!8m2!3d-6.6678132!4d106.7981633!9m1!1b1!16s%2Fg%2F11gs5pgnyq?hl=id&entry=ttu&g_ep=EgoyMDI5MDgwNC.0wIKXMDSoASAFQAw%3D%3D"
                        target="_blank" rel="noopener noreferrer"
                        class="inline-block px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full font-semibold overflow-hidden btn-glow hover:shadow-2xl hover:shadow-purple-500/50 transition-all duration-300">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-comment-alt"></i>
                            View All Reviews
                        </span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="relative py-16 border-t border-white/5">
        <div class="absolute inset-0 bg-gradient-to-b from-black to-gray-900"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-8">
                <div class="hidden lg:flex gap-4">
                    <div class="w-12 h-12 glass rounded-full"></div>
                    <div class="w-12 h-12 glass rounded-full"></div>
                    <div class="w-12 h-12 glass rounded-full"></div>
                </div>

                <div class="text-center max-w-2xl">
                    <h3 class="text-3xl font-bold gradient-text font-serif mb-4">TAKATO</h3>
                    <p class="text-gray-400 mb-2">© 2024 - 2025 <span class="font-semibold gradient-text">TAKATO Villa
                            & Restaurant</span>. All rights reserved.</p>
                    <p class="text-gray-500 text-sm">Your premium destination for luxury stays and fine dining
                    </p>
                </div>

                <div class="hidden lg:flex gap-4">
                    <div class="w-12 h-12 glass rounded-full"></div>
                    <div class="w-12 h-12 glass rounded-full"></div>
                    <div class="w-12 h-12 glass rounded-full"></div>
                </div>
            </div>
        </div>
    </footer>

    <div class="fixed bottom-8 right-6 z-[1008] flex flex-col gap-4">
        <a href="https://wa.me/+6281214831823" target="_blank" rel="noopener noreferrer"
            class="group w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-2xl hover:shadow-green-500/50 hover:scale-110 transition-all duration-300">
            <i class="fab fa-whatsapp text-white text-2xl group-hover:scale-110 transition-transform"></i>
        </a>
    </div>

    <script>
        // Navigation Active State
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

        // Dapatkan referensi navbar (Sudah benar)
        const desktopNav = document.getElementById('desktopNav');
        const mobileNav = document.getElementById('mobileNav');

        function setActiveLink() {
            let current = 'home';
            const scrollPos = window.scrollY + 100;

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollPos >= (sectionTop - 100) && scrollPos < (sectionTop + sectionHeight - 100)) {
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

        // Mobile Menu
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

        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const target = link.getAttribute('href');
                if (target && target !== '#') {
                    const el = document.querySelector(target);
                    if (el) {
                        const offset = 80;
                        const top = el.offsetTop - offset;
                        window.scrollTo({
                            top: top,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Gallery Modal
        const modal = document.getElementById('galleryModal');
        const openBtn = document.getElementById('openGalleryBtn');
        const closeBtn = document.getElementById('closeGalleryBtn');

        // --- PERBAIKAN FUNGSI NAV BAR V2 ---

        // Simpan kelas-kelas awal navbar desktop dan mobile
        // Ini memastikan saat showNavbars dipanggil, kelas aslinya dikembalikan, BUKAN dihapus.
        const desktopNavOriginalClasses = desktopNav ? Array.from(desktopNav.classList) : [];
        const mobileNavOriginalClasses = mobileNav ? Array.from(mobileNav.classList) : [];


        function hideNavbars() {
            if (desktopNav) {
                // Hapus semua kelas tampilan yang bertentangan dan tambahkan 'hidden'
                desktopNav.classList.add('hidden');
                desktopNav.classList.remove('md:flex');
            }
            if (mobileNav) {
                // Hapus kelas tampilan mobile dan tambahkan 'hidden'
                mobileNav.classList.add('hidden');
                mobileNav.classList.remove('flex');
            }
        }

        function showNavbars() {
            if (desktopNav) {
                // Hapus semua kelas dan kembalikan kelas aslinya
                desktopNav.classList.value = desktopNavOriginalClasses.join(' ');
                desktopNav.classList.remove('hidden'); // Pastikan hidden dihapus
                desktopNav.classList.add('md:flex'); // Pastikan md:flex ada (jika ini kelas aslinya)
            }
            if (mobileNav) {
                // Hapus semua kelas dan kembalikan kelas aslinya
                mobileNav.classList.value = mobileNavOriginalClasses.join(' ');
                mobileNav.classList.remove('hidden'); // Pastikan hidden dihapus
                mobileNav.classList.add('flex', 'md:hidden'); // Pastikan flex dan md:hidden ada (jika ini kelas aslinya)
            }
        }
        // --- AKHIR PERBAIKAN FUNGSI NAV BAR V2 ---

        if (openBtn) {
            openBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                // **Menyembunyikan Navbar saat modal terbuka**
                hideNavbars();
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                // **Menampilkan kembali Navbar saat modal ditutup**
                showNavbars();
            });
        }

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    // **Menampilkan kembali Navbar saat klik di luar modal**
                    showNavbars();
                }
            });
        }

        // ... (Sisa kode JS, Reviews Slider dan Particles Animation) ...

        // Reviews Slider
        window.addEventListener('load', () => {
            setActiveLink();

            const slider = document.getElementById('reviews-slider');
            const prevBtn = document.getElementById('review-prev');
            const nextBtn = document.getElementById('review-next');
            const reviews = slider ? slider.children : [];

            if (slider && reviews.length > 0) {
                let currentIndex = 0;
                let autoSlideInterval;
                let cardWidth;

                function updateCardWidth() {
                    if (reviews.length > 0) {
                        cardWidth = reviews[0].offsetWidth;
                    }
                }

                const getVisibleCards = () => {
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 768) return 2;
                    return 1;
                }

                function updateSliderPosition() {
                    if (!cardWidth) updateCardWidth();
                    if (cardWidth > 0) {
                        const offset = -currentIndex * cardWidth;
                        slider.style.transform = `translateX(${offset}px)`;
                    }
                }

                function nextSlide() {
                    const visibleCards = getVisibleCards();
                    let maxIndex = reviews.length - visibleCards;
                    if (maxIndex < 0) maxIndex = 0;

                    if (currentIndex < maxIndex) {
                        currentIndex++;
                    } else {
                        currentIndex = 0;
                    }
                    updateSliderPosition();
                }

                function prevSlide() {
                    const visibleCards = getVisibleCards();
                    let maxIndex = reviews.length - visibleCards;
                    if (maxIndex < 0) maxIndex = 0;

                    if (currentIndex > 0) {
                        currentIndex--;
                    } else {
                        currentIndex = maxIndex;
                    }
                    updateSliderPosition();
                }

                function startAutoSlide() {
                    stopAutoSlide();
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

                updateCardWidth();
                updateSliderPosition();
                startAutoSlide();

                slider.parentElement.addEventListener('mouseenter', stopAutoSlide);
                slider.parentElement.addEventListener('mouseleave', startAutoSlide);

                let resizeTimer;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => {
                        updateCardWidth();
                        currentIndex = 0;
                        updateSliderPosition();
                    }, 250);
                });
            }

            // Fade-in Observer
            const sectionsToFade = document.querySelectorAll('.fade-in-section');
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            sectionsToFade.forEach(section => {
                observer.observe(section);
            });
        });

        // Particles Animation (Enhanced)
        (() => {
            const canvas = document.querySelector('.particles-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            let width = window.innerWidth;
            let height = window.innerHeight;
            canvas.width = width;
            canvas.height = height;

            const particles = [];
            const particleCount = 60;

            for (let i = 0; i < particleCount; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    dx: (Math.random() - 0.5) * 2,
                    dy: (Math.random() - 0.5) * 2,
                    size: Math.random() * 3 + 1,
                    opacity: Math.random() * 0.8 + 0.2
                });
            }

            function drawParticles() {
                ctx.clearRect(0, 0, width, height);

                particles.forEach((p, i) => {
                    p.x += p.dx;
                    p.y += p.dy;

                    if (p.x < 0 || p.x > width) p.dx *= -1;
                    if (p.y < 0 || p.y > height) p.dy *= -1;

                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(102, 126, 234, ${p.opacity})`;
                    ctx.fill();

                    // Draw connections
                    particles.forEach((p2, j) => {
                        if (i !== j) {
                            const dx = p.x - p2.x;
                            const dy = p.y - p2.y;
                            const distance = Math.sqrt(dx * dx + dy * dy);

                            if (distance < 150) {
                                ctx.beginPath();
                                ctx.moveTo(p.x, p.y);
                                ctx.lineTo(p2.x, p2.y);
                                ctx.strokeStyle = `rgba(102, 126, 234, ${0.15 * (1 - distance / 150)})`;
                                ctx.lineWidth = 1;
                                ctx.stroke();
                            }
                        }
                    });
                });

                requestAnimationFrame(drawParticles);
            }

            drawParticles();

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
