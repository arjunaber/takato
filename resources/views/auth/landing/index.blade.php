<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAKATO - Super App</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .news-slide {
            display: none;
        }

        .news-slide.active {
            display: block;
        }

        .news-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #E0E0E0;
            cursor: pointer;
            margin: 0 5px;
        }

        .news-indicator.active {
            background-color: #4F46E5;
        }

        /* Flip Card Styles */
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

        /* Hero Section with Profile Background */
        .hero-section {
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/1aab8845-00c7-46bd-92bb-767d70b7c128.jpg');
            background-size: cover;
            background-position: center;
            z-index: 0;
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* 50% darkness */
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        #story-viewer {
            aspect-ratio: 9/12;
        }

        .story-progress {
            transition: width 0.1s linear;
        }

        @media (max-width: 640px) {
            #story-viewer {
                width: 100%;
                height: auto;
            }
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
    </style>
</head>

<body class="font-sans bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-primary">TAKATO</div>
            <div class="hidden md:flex space-x-8">
                <a href="/landing" class="text-gray-700 hover:text-primary">Home</a>
                <a href="#profile" class="text-gray-700 hover:text-primary">Profile</a>
                <a href="#facilities" class="text-gray-700 hover:text-primary">Facilities</a>
            </div>
            <div class="md:hidden">
                <button class="text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Profile Background -->
    <section class="hero-section bg-gradient-to-r from-primary to-indigo-700 text-white py-20">
        <div class="hero-bg"></div>
        <div class="hero-content container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Welcome to TAKATO</h1>
            <p class="text-xl md:text-2xl mb-8">Your all-in-one solution for villa management and restaurant ordering
            </p>

            <!-- Flip Cards Container -->
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto mt-12">
                <!-- Grand Schedule Card -->
                <a href="/grandschedule" class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-6 h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-black/10 p-3 rounded-full mr-4">
                                        <i class="fas fa-calendar-alt text-black text-xl"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800">TAKATO HOUSE</h3>
                                </div>
                                <p class="text-gray-600 mb-4 flex-grow">Manage your villa bookings with our intuitive
                                    calendar system. See availability at a glance and update status with just a few
                                    clicks.</p>
                                <div class="text-center">
                                    <button
                                        class="bg-black text-white px-6 py-2 rounded-full hover:bg-black-dark transition">Click</button>
                                </div>
                            </div>
                        </div>
                        <div class="flip-card-back">
                            <img src="https://cdn-icons-png.flaticon.com/512/3652/3652191.png" alt="Calendar Icon">
                        </div>
                    </div>
                </a>

                <!-- Resto Order Card -->
                <a href="#" class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-6 h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-black/10 p-3 rounded-full mr-4">
                                        <i class="fas fa-utensils text-black text-xl"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800">TAKATO RESTO</h3>
                                </div>
                                <p class="text-gray-600 mb-4 flex-grow">Streamline your restaurant operations with our
                                    integrated ordering system. From menu management to payment processing.</p>
                                <div class="text-center">
                                    <button
                                        class="bg-black text-white px-6 py-2 rounded-full hover:bg-black-dark transition">Order
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flip-card-back" style="background-color: rgb(0, 109, 78);">
                            <img src="/cafe2.png" alt="Restaurant Image" class="w-full h-full object-contain">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Villa Facilities Section with Black Background -->
    <section id="facilities" class="py-20 bg-gradient-to-b from-gray-900 to-black text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-6xl font-bold text-white mb-4 font-serif">Takato Residence</h2>
                <p class="text-xl text-primary-200 max-w-2xl mx-auto">Rumah Mewah dengan Halaman Luas di Bogor</p>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-primary-400 mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 mb-12">
                <!-- Property Overview with Map -->
                <div
                    class="lg:col-span-2 bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200 text-gray-800">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-home text-white text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold">Gambaran Properti</h3>
                        </div>

                        <div class="grid md:grid-cols-2 gap-8 mb-6">
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-semibold text-primary-600 mb-2 uppercase tracking-wider">
                                        LOKASI</h4>
                                    <p class="text-lg flex items-center">
                                        <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                        Jl. Babakan Palasari No. 1, Cihideung, Bogor
                                    </p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-100 p-4 rounded-xl">
                                        <h4
                                            class="text-xs font-semibold text-primary-600 mb-1 uppercase tracking-wider">
                                            LUAS TANAH</h4>
                                        <p class="text-2xl font-bold">5,360 <span
                                                class="text-base font-normal">m²</span></p>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-xl">
                                        <h4
                                            class="text-xs font-semibold text-primary-600 mb-1 uppercase tracking-wider">
                                            LUAS BANGUNAN</h4>
                                        <p class="text-2xl font-bold">1,000 <span
                                                class="text-base font-normal">m²</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-semibold text-primary-600 mb-2 uppercase tracking-wider">
                                        STATUS HUKUM</h4>
                                    <div class="flex items-center bg-gray-100 px-4 py-3 rounded-xl">
                                        <i class="fas fa-file-contract text-primary mr-3"></i>
                                        <span class="font-medium">SHM (3 Sertifikat)</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-primary-600 mb-2 uppercase tracking-wider">
                                        POSISI</h4>
                                    <div class="flex items-center bg-gray-100 px-4 py-3 rounded-xl">
                                        <i class="fas fa-compass text-primary mr-3"></i>
                                        <span class="font-medium">Hook</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Map -->
                    <div class="h-64 md:h-80 w-full bg-gray-200 relative">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.347344724797!2d106.7978513152944!3d-6.603873966187785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5d1a5a5a5a5%3A0x5a5a5a5a5a5a5a5!2sJl.%20Babakan%20Palasari%20No.1%2C%20Cihideung%2C%20Bogor!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            class="absolute inset-0">
                        </iframe>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-20 pointer-events-none">
                        </div>
                    </div>

                    <div class="p-6 bg-gray-100">
                        <h4 class="text-sm font-semibold text-primary-600 mb-3 uppercase tracking-wider">FASILITAS
                            TERDEKAT</h4>
                        <div class="flex flex-wrap gap-3">
                            <span
                                class="bg-white px-4 py-2 rounded-full text-sm flex items-center border border-gray-200">
                                <i class="fas fa-road text-primary mr-2"></i>
                                Gerbang Tol Jagorawi (4km)
                            </span>
                            <span
                                class="bg-white px-4 py-2 rounded-full text-sm flex items-center border border-gray-200">
                                <i class="fas fa-exchange-alt text-primary mr-2"></i>
                                Tol Bocimi
                            </span>
                            <span
                                class="bg-white px-4 py-2 rounded-full text-sm flex items-center border border-gray-200">
                                <i class="fas fa-bus text-primary mr-2"></i>
                                Terminal Baranangsiang (4km)
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Features -->
                <div class="space-y-6">
                    <!-- Electricity -->
                    <div class="bg-white rounded-2xl p-6 border border-primary/30 shadow-lg text-gray-800">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bolt text-white text-sm"></i>
                            </div>
                            <h3 class="text-xl font-bold">Kapasitas Listrik</h3>
                        </div>
                        <div class="space-y-3">
                            <div
                                class="flex justify-between items-center bg-gray-100 px-4 py-3 rounded-lg border-l-4 border-primary">
                                <span class="flex items-center">
                                    <i class="fas fa-circle text-primary mr-2 text-xs"></i>
                                    Daya Utama
                                </span>
                                <span class="font-bold text-primary">6000 watt</span>
                            </div>
                            <div
                                class="flex justify-between items-center bg-gray-100 px-4 py-3 rounded-lg border-l-4 border-primary">
                                <span class="flex items-center">
                                    <i class="fas fa-circle text-primary-600 mr-2 text-xs"></i>
                                    Sekunder
                                </span>
                                <span class="font-bold text-primary-600">4000 watt</span>
                            </div>
                            <div
                                class="flex justify-between items-center bg-gray-100 px-4 py-3 rounded-lg border-l-4 border-primary">
                                <span class="flex items-center">
                                    <i class="fas fa-circle text-primary-400 mr-2 text-xs"></i>
                                    Cadangan
                                </span>
                                <span class="font-bold text-primary-400">2200 watt</span>
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg text-gray-800">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-white text-sm"></i>
                            </div>
                            <h3 class="text-xl font-bold">Fasilitas Keamanan</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="bg-gray-100 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-start">
                                    <i class="fas fa-home text-primary mt-1 mr-3"></i>
                                    <div>
                                        <h4 class="font-semibold mb-1">Rumah Satpam</h4>
                                        <p class="text-sm text-gray-600">2 kamar tidur, dapur, ruang tamu, ruang makan,
                                            kamar mandi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-start">
                                    <i class="fas fa-user-shield text-primary mt-1 mr-3"></i>
                                    <div>
                                        <h4 class="font-semibold mb-1">Pos Satpam</h4>
                                        <p class="text-sm text-gray-600">1 kamar tidur, 1 kamar mandi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Facilities -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg text-gray-800">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-briefcase text-white text-sm"></i>
                            </div>
                            <h3 class="text-xl font-bold">Fasilitas Bisnis</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                                <i class="fas fa-chart-line text-primary text-xl mb-2"></i>
                                <p class="font-medium text-sm">Ruang Meeting</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Living Spaces -->
                <div
                    class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:border-primary transition-all duration-300 text-gray-800">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-bed text-white text-sm"></i>
                        </div>
                        <h3 class="text-xl font-bold">Ruang Hunian</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-bed text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">12 Kamar Tidur</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-bath text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">9 Kamar Mandi</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-couch text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Ruang Tamu</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-users text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Ruang Keluarga</p>
                        </div>
                    </div>
                </div>

                <!-- Kitchen & Dining -->
                <div
                    class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:border-primary transition-all duration-300 text-gray-800">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-utensils text-white text-sm"></i>
                        </div>
                        <h3 class="text-xl font-bold">Dapur & Makan</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-blender text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">2 Dapur Bersih</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-fire text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Dapur Kotor</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-utensils text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">2 Ruang Makan</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-car text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">2 Garasi</p>
                        </div>
                    </div>
                </div>

                <!-- Recreation -->
                <div
                    class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:border-primary transition-all duration-300 text-gray-800">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-swimming-pool text-white text-sm"></i>
                        </div>
                        <h3 class="text-xl font-bold">Rekreasi</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-swimming-pool text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Kolam Renang</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-table-tennis text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Badminton Indoor</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-fish text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Kolam Pancing</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-umbrella-beach text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Balkon Besar</p>
                        </div>
                    </div>
                </div>

                <!-- Utilities -->
                <div
                    class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:border-primary transition-all duration-300 text-gray-800">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-tools text-white text-sm"></i>
                        </div>
                        <h3 class="text-xl font-bold">Utilitas</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-tshirt text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Area Laundry</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-boxes text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Gudang</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-fire-alt text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Gazebo</p>
                            <p class="text-xs text-gray-500">untuk memasak</p>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg text-center border border-gray-200">
                            <i class="fas fa-place-of-worship text-primary text-xl mb-2"></i>
                            <p class="font-medium text-sm">Musholla</p>
                            <p class="text-xs text-gray-500">+ WC + Wudhu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Gallery -->
            <div class="mt-12 bg-white rounded-2xl p-8 border border-gray-200 shadow-xl text-gray-800">
                <div class="flex items-center mb-8">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-primary to-primary-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-camera text-white text-lg"></i>
                    </div>
                    <h3 class="text-2xl font-bold">Galeri Foto</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    <!-- First 4 images from your list -->
                    <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden group relative">
                        <img src="/d4224d93-1c8e-4e14-99bb-ba71fae20bd0.jpg" alt="Properti Takato"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                            <span class="text-white font-medium">Takato Residence</span>
                        </div>
                    </div>
                    <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden group relative">
                        <img src="/b4a28977-cc48-4899-b1f2-ffbaf68b22dc.jpg" alt="Properti Takato"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                            <span class="text-white font-medium">Takato Residence</span>
                        </div>
                    </div>
                    <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden group relative">
                        <img src="/5464b013-f73b-4a1c-abbd-2c82191a6c24.jpg" alt="Properti Takato"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                            <span class="text-white font-medium">Takato Residence</span>
                        </div>
                    </div>
                    <div class="aspect-square bg-gray-200 rounded-xl overflow-hidden group relative">
                        <img src="/904b43c3-7771-49cb-9994-7df19df0071e.jpg" alt="Properti Takato"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                            <span class="text-white font-medium">Takato Residence</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button id="openGalleryBtn"
                        class="px-6 py-3 bg-gradient-to-r from-primary to-primary-600 rounded-full text-white font-medium hover:shadow-lg transition-all duration-300 flex items-center mx-auto">
                        <i class="fas fa-images mr-2"></i>
                        Lihat Galeri Lengkap
                    </button>
                </div>
            </div>

            <!-- Gallery Modal -->
            <div id="galleryModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-90">
                <div class="relative min-h-screen w-full">
                    <!-- Close Button -->
                    <button id="closeGalleryBtn"
                        class="fixed top-4 right-12 z-50 text-white text-3xl hover:text-primary transition">
                        <i class="fas fa-times"></i>
                    </button>

                    <!-- Gallery Content -->
                    <div class="container mx-auto px-4 py-20">
                        <h2 class="text-3xl font-bold text-white mb-8 text-center">Galeri Takato Residence</h2>

                        <!-- Masonry Grid Layout -->
                        <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4">
                            <!-- All your images in random sizes -->
                            <div class="break-inside-avoid">
                                <img src="/d4224d93-1c8e-4e14-99bb-ba71fae20bd0.jpg" alt="Takato Residence"
                                    class="w-full rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/b4a28977-cc48-4899-b1f2-ffbaf68b22dc.jpg" alt="Takato Residence"
                                    class="w-full rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/5464b013-f73b-4a1c-abbd-2c82191a6c24.jpg" alt="Takato Residence"
                                    class="w-full h-64 object-cover rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/904b43c3-7771-49cb-9994-7df19df0071e.jpg" alt="Takato Residence"
                                    class="w-full rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/806b2a84-eb07-4567-b37b-cbaffeededf5.jpg" alt="Takato Residence"
                                    class="w-full h-80 object-cover rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/142fecc5-abd2-4de4-b63a-abd998bbe563.avif" alt="Takato Residence"
                                    class="w-full rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/86f407f5-1207-4772-8e5d-315d0e750c43.avif" alt="Takato Residence"
                                    class="w-full h-96 object-cover rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/7bc30c68-f20b-4a4f-a237-e0f8f70efa8a.avif" alt="Takato Residence"
                                    class="w-full rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/2b543991-6b91-41ce-b9db-096d47373a14.avif" alt="Takato Residence"
                                    class="w-full h-64 object-cover rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/1aab8845-00c7-46bd-92bb-767d70b7c128.avif" alt="Takato Residence"
                                    class="w-full rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                            <div class="break-inside-avoid">
                                <img src="/0fe6c365-8b57-4987-8e9e-1c78a477889c.avif" alt="Takato Residence"
                                    class="w-full h-80 object-cover rounded-lg shadow-lg hover:opacity-90 transition">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="gallery-events" class="py-20 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4 font-serif">Event Stories</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Momen spesial di TAKATO Residence dalam format
                    Instagram Stories</p>
                <div class="w-24 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto mt-6 rounded-full"></div>
            </div>

            <!-- Instagram Stories Style Container -->
            <div class="max-w-md mx-auto relative">
                <!-- Story Viewer -->
                <div class="relative overflow-hidden rounded-xl shadow-xl" id="story-viewer">
                    <!-- Progress Bars -->
                    <div class="absolute top-4 left-4 right-4 z-10 flex space-x-1" id="progress-bars">
                        <!-- Progress bars will be inserted here by JavaScript -->
                    </div>

                    <!-- Story Content -->
                    <div class="relative h-[70vh] max-h-[600px] bg-gradient-to-b from-indigo-600 to-black"
                        id="current-story">
                        <!-- Current story content will be inserted here by JavaScript -->
                    </div>

                    <!-- Navigation Controls -->
                    <button
                        class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/30 backdrop-blur rounded-full flex items-center justify-center text-white text-xl hover:bg-white/50 transition-all story-nav"
                        data-direction="prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button
                        class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/30 backdrop-blur rounded-full flex items-center justify-center text-white text-xl hover:bg-white/50 transition-all story-nav"
                        data-direction="next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews/Testimonials Section -->
    <section id="reviews" class="py-20 bg-gradient-to-br from-gray-800 to-black">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-6xl font-bold text-white mb-4 font-serif">Customer Reviews</h2>
                <p class="text-xl text-white max-w-3xl mx-auto">Apa kata mereka yang telah merasakan pengalaman di
                    TAKATO Residence</p>
                <div class="w-24 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto mt-6 rounded-full"></div>
            </div>

            <!-- Overall Rating Summary -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-12 max-w-4xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 items-center">
                    <div class="text-center">
                        <div class="text-6xl font-bold text-indigo-600 mb-2">4.4</div>
                        <div class="flex justify-center mb-2">
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                            <i class="fas fa-star-half-alt text-yellow-400 text-xl"></i>
                        </div>
                        <p class="text-gray-600">Berdasarkan 43 ulasan</p>
                    </div>

                    <div class="md:col-span-2">
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <span class="text-sm w-8">5★</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-3 mx-3">
                                    <div class="bg-yellow-400 h-3 rounded-full" style="width: 60%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-12">60%</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm w-8">4★</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-3 mx-3">
                                    <div class="bg-yellow-400 h-3 rounded-full" style="width: 25%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-12">25%</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm w-8">3★</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-3 mx-3">
                                    <div class="bg-yellow-400 h-3 rounded-full" style="width: 10%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-12">10%</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm w-8">2★</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-3 mx-3">
                                    <div class="bg-yellow-400 h-3 rounded-full" style="width: 3%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-12">3%</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm w-8">1★</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-3 mx-3">
                                    <div class="bg-yellow-400 h-3 rounded-full" style="width: 2%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-12">2%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sliding Reviews Container -->
            <div class="relative mb-2">
                <!-- Navigation Arrows -->
                <button
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 rounded-full p-3 shadow-lg ml-2 hover:bg-white transition-all hidden md:block"
                    id="review-prev">
                    <i class="fas fa-chevron-left text-indigo-600"></i>
                </button>
                <button
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 rounded-full p-3 shadow-lg mr-2 hover:bg-white transition-all hidden md:block"
                    id="review-next">
                    <i class="fas fa-chevron-right text-indigo-600"></i>
                </button>

                <!-- Reviews Slider -->
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out pb-12" id="reviews-slider">
                        <!-- Review 1 - Rizfa Sachika -->
                        <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4 mb-12">
                            <div class="bg-white rounded-2xl shadow-lg p-6 h-full">
                                <div class="flex items-start mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                        R
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Rizfa Sachika</h3>
                                        <div class="flex items-center mb-1">
                                            <div class="flex text-yellow-400 mr-2">
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                            </div>
                                            <span class="text-sm text-gray-500">• 2 bulan lalu</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">"Tempatnya nyaman banget adem, villanya bersih, luas saya
                                    buat acara keluarga enak banget. parkirannya juga luas. TOPP🫶🏻"</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">Acara Keluarga</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review 2 - Agus Suwarko -->
                        <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4 mb-12">
                            <div class="bg-white rounded-2xl shadow-lg p-6 h-full">
                                <div class="flex items-start mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                        A
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Agus Suwarko</h3>
                                        <div class="flex items-center mb-1">
                                            <div class="flex text-yellow-400 mr-2">
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="far fa-star text-sm"></i>
                                            </div>
                                            <span class="text-sm text-gray-500">• 11 bulan lalu</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">"Tempatnya nyaman. Minim tempat sampah di area kebunnya"
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">Feedback konstruktif</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review 3 - Muhamad Zahra -->
                        <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4 mb-12">
                            <div class="bg-white rounded-2xl shadow-lg p-6 h-full">
                                <div class="flex items-start mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                        M
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Muhamad Zahra</h3>
                                        <div class="flex items-center mb-1">
                                            <div class="flex text-yellow-400 mr-2">
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                            </div>
                                            <span class="text-sm text-gray-500">• 4 tahun lalu</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">"Tempat yang bagus dan nyaman, dengan fasilitas yang
                                    lengkap dan servis yang memuaskan"</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">Verified stay</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review 4 - Gayska Vetotama -->
                        <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4 mb-12">
                            <div class="bg-white rounded-2xl shadow-lg p-6 h-full">
                                <div class="flex items-start mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                        G
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Gayska Vetotama</h3>
                                        <div class="flex items-center mb-1">
                                            <div class="flex text-yellow-400 mr-2">
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="far fa-star text-sm"></i>
                                            </div>
                                            <span class="text-sm text-gray-500">• setahun lalu</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">"View super bagus, fasilitas dapur dan kamar juga oke di
                                    mana cukup untuk menampung +40 orang. Problem terbesar ada di air, sayang sekali
                                    selalu bermasalah jadi saya dan teman-teman selalu kesulitan untuk urusan mandi dan
                                    kakus."</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">40+ orang</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review 5 - Aria WN -->
                        <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4 mb-12">
                            <div class="bg-white rounded-2xl shadow-lg p-6 h-full">
                                <div class="flex items-start mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                        A
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Aria WN</h3>
                                        <div class="flex items-center mb-1">
                                            <div class="flex text-yellow-400 mr-2">
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                            </div>
                                            <span class="text-sm text-gray-500">• 2 tahun lalu</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">"Luas, ada fasilitas kolam renang & lapangan indoor, jadi
                                    bisa explore dan beraktifitas didalam area. Cocok untuk rame2 / team building
                                    terbatas / keluarga."</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">Pool & Indoor facilities</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review 6 - Denis K70 -->
                        <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4 mb-12">
                            <div class="bg-white rounded-2xl shadow-lg p-6 h-full">
                                <div class="flex items-start mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                        D
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Denis K70 Bogor</h3>
                                        <div class="flex items-center mb-1">
                                            <div class="flex text-yellow-400 mr-2">
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                                <i class="fas fa-star text-sm"></i>
                                            </div>
                                            <span class="text-sm text-gray-500">• 2 tahun lalu</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">"Mudah dijangkau.. cocok untuk acara keluarga.. Tempat
                                    luas & nyaman."</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">Family Event</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Reviews Button -->
            <div class="text-center">
                <a href="https://www.google.com/maps/place/TAKATO+House/@-6.6678079,106.7955884,871m/data=!3m1!1e3!4m14!1m5!8m4!1e1!2s108577363218960224761!3m1!1e1!3m7!1s0x2e69cfd0917512e5:0x4f4e592292796e69!8m2!3d-6.6678132!4d106.7981633!9m1!1b1!16s%2Fg%2F11gs5pgnyq?hl=id&entry=ttu&g_ep=EgoyMDI5MDgwNC4wIKXMDSoASAFQAw%3D%3D"
                    target="_blank" rel="noopener noreferrer"
                    class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-full hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-comment-alt mr-2"></i>
                    Ulasan
                </a>
            </div>
        </div>
    </section>

    <!-- Restaurant Facilities Section -->
    <section id="resto-facilities" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Pengalaman Takato Resto</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan fasilitas makan kami yang istimewa di jantung Bogor
                </p>
            </div>

            <!-- Main Content -->
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Column - Image Gallery -->
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden shadow-xl h-[700px]">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.152651053472!2d106.79827731537068!3d-6.628980966396264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMzcnNDQuMyJTIDEwNsKwNDgnMDEuNiJF!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            class="rounded-2xl" title="Lokasi Takato Resto">
                        </iframe>
                    </div>
                </div>

                <!-- Right Column - Facilities Info -->
                <div>
                    <!-- Operating Hours -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg border-l-4 border-primary mb-8 transform hover:-translate-y-1 transition duration-300">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Jam Operasional</h3>
                        <div class="grid grid-cols-2 gap-4 text-gray-600">
                            <div>
                                <p class="font-semibold">Senin - Jumat</p>
                                <p>06:00 - 23:00</p>
                            </div>
                            <div>
                                <p class="font-semibold">Akhir Pekan</p>
                                <p>06:00 - 24:00</p>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="fas fa-clock mr-2 text-primary"></i>
                            <span>Pesanan terakhir 30 menit sebelum tutup</span>
                        </div>
                    </div>

                    <!-- Features List -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Fasilitas Kami</h3>
                        <ul class="space-y-5">
                            <li
                                class="flex items-start bg-white/50 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                <div class="bg-primary/10 p-3 rounded-full mr-4 text-primary">
                                    <i class="fas fa-utensils text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Masakan Autentik</h4>
                                    <p class="text-gray-600">Rasakan cita rasa asli yang dibuat oleh koki kami yang
                                        ahli</p>
                                </div>
                            </li>
                            <li
                                class="flex items-start bg-white/50 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                <div class="bg-primary/10 p-3 rounded-full mr-4 text-primary">
                                    <i class="fas fa-coffee text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Kopi Premium</h4>
                                    <p class="text-gray-600">Kopi spesial dari biji kopi lokal Bogor</p>
                                </div>
                            </li>
                            <li
                                class="flex items-start bg-white/50 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                <div class="bg-primary/10 p-3 rounded-full mr-4 text-primary">
                                    <i class="fas fa-wifi text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">WiFi Gratis</h4>
                                    <p class="text-gray-600">Tetap terhubung dengan internet berkecepatan tinggi</p>
                                </div>
                            </li>
                            <li
                                class="flex items-start bg-white/50 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                <div class="bg-primary/10 p-3 rounded-full mr-4 text-primary">
                                    <i class="fas fa-parking text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Area Parkir Luas</h4>
                                    <p class="text-gray-600">Tersedia tempat parkir yang nyaman</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Location Description -->
                    <div
                        class="bg-white p-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition duration-300">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Lokasi Kami</h3>
                        <p class="text-gray-600 mb-4">Temukan kami di Jl. Babakan Palasari No. 1, Cihideung, Bogor.
                            Terletak di lokasi yang strategis dengan akses mudah dari jalan utama, restoran kami
                            menawarkan suasana yang nyaman untuk acara keluarga, rapat bisnis, atau makan sendirian.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                            <span>5 menit dari Kebun Raya Bogor</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Highlights -->
            <div class="mt-20">
                <h3 class="text-2xl font-bold text-center text-gray-800 mb-10">Menu Unggulan</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Menu Item 1 -->
                    <div
                        class="bg-white rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                        <div class="h-72 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                                alt="Nasi Liwet Komplit"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-bold text-xl text-gray-800">Nasi Liwet Komplit</h4>
                                <span
                                    class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">Terlaris</span>
                            </div>
                            <p class="text-gray-600 mb-4">Hidangan nasi khas Sunda dengan berbagai lauk pelengkap</p>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800 text-lg">Rp 45.000</span>
                                <button
                                    class="text-primary hover:text-primary-dark font-semibold text-sm flex items-center">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Item 2 -->
                    <div
                        class="bg-white rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                        <div class="h-72 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                                alt="Kopi Spesial Bogor"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-bold text-xl text-gray-800">Kopi Spesial Bogor</h4>
                                <span
                                    class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">Favorit</span>
                            </div>
                            <p class="text-gray-600 mb-4">Kopi premium lokal dengan penyajian tradisional</p>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800 text-lg">Rp 25.000</span>
                                <button
                                    class="text-primary hover:text-primary-dark font-semibold text-sm flex items-center">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Item 3 -->
                    <div
                        class="bg-white rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                        <div class="h-72 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1579954115561-d6cd8998c57a?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                                alt="Es Campur Takato"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-bold text-xl text-gray-800">Es Campur Takato</h4>
                                <span
                                    class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">Segar</span>
                            </div>
                            <p class="text-gray-600 mb-4">Es campur khas Indonesia dengan resep spesial</p>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800 text-lg">Rp 30.000</span>
                                <button
                                    class="text-primary hover:text-primary-dark font-semibold text-sm flex items-center">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">TAKATO</h3>
                    <p class="text-gray-400">Revolutionizing hospitality management with innovative technology
                        solutions.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/landing" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#profile" class="text-gray-400 hover:text-white transition">Profile</a></li>
                        <li><a href="#facilities" class="text-gray-400 hover:text-white transition">Facilities</a>
                        </li>
                        <li><a href="/login" class="text-gray-400 hover:text-white transition">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>123 Business Ave, City</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3"></i>
                            <span>+1 234 567 890</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3"></i>
                            <span>info@takato.com</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition text-xl"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-xl"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-xl"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-xl"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 TAKATO. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // News Slider Functionality
        function goToSlideNews(index) {
            document.querySelectorAll('.news-slide').forEach(slide => slide.classList.remove('active'));
            document.querySelectorAll('.news-indicator').forEach(ind => ind.classList.remove('active'));

            document.getElementById(`slide-${index}`).classList.add('active');
            document.getElementById(`news-${index}`).classList.add('active');
        }

        // Service Tabs Functionality
        document.querySelectorAll('#service-tabs button').forEach(button => {
            button.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('#service-tabs button').forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white', 'hover:bg-primary-dark');
                    btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                });
                this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                this.classList.add('bg-primary', 'text-white', 'hover:bg-primary-dark');

                // Update content
                document.getElementById('service-desc').textContent = this.dataset.desc;
                document.getElementById('service-img').src = this.dataset.img;
                document.getElementById('service-img').alt = this.dataset.title;
            });
        });

        // Auto-rotate news slides
        let currentSlide = 0;
        const totalSlides = document.querySelectorAll('.news-slide').length;

        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlideNews(currentSlide);
        }, 5000);

        // Modal functionality
        const modal = document.getElementById('galleryModal');
        const openBtn = document.getElementById('openGalleryBtn');
        const closeBtn = document.getElementById('closeGalleryBtn');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        // Close modal when clicking outside content
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        // Process payment with Midtrans
        function processPayment(bookingData) {
            showModal('Processing', 'Preparing your payment...');

            // Load Midtrans Snap script
            const script = document.createElement('script');
            script.src = 'https://app.midtrans.com/snap/snap.js';
            script.setAttribute('data-client-key',
                'SB-Mid-client-vumw33ofLMM-bm9y'); // Replace with your Midtrans client key
            document.head.appendChild(script);
            script.onload = function() {
                // Initialize Midtrans Snap
                snap.pay(bookingData.snapToken, {
                    onSuccess: function(result) {
                        handlePaymentSuccess(result, bookingData);
                    },
                    onPending: function(result) {
                        showModal('Pending', `
                            <p>Payment is pending.</p>
                            <p>Please complete your payment.</p>
                            <p>We'll notify you when payment is confirmed.</p>
                        `);
                    },
                    onError: function(result) {
                        showModal('Error', `
                            <p>Payment failed: ${result.status_message || 'Unknown error'}</p>
                            <p>Please try again or contact support.</p>
                        `);
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                    }
                });
            };
        }


        // Mock snap token (in production, get this from your backend)
        const snapToken = 'YOUR_MOCK_SNAP_TOKEN';

        // For demo purposes, we'll use a timeout to simulate API call
        setTimeout(() => {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    // Send booking data to server
                    $.ajax({
                        url: '/bookings/store',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            booking_data: bookingData,
                            payment_result: result
                        },
                        success: function(response) {
                            showModal('Success', `
                            <p>Payment successful!</p>
                            <p>Booking ID: ${response.booking_id}</p>
                            <p>We've sent confirmation to ${bookingData.email}</p>
                        `);
                            calendar.refetchEvents();
                        },
                        error: function(error) {
                            showModal('Error', `
                            <p>Payment was successful but we encountered an issue saving your booking.</p>
                            <p>Please contact support with reference: ${result.order_id}</p>
                        `);
                            console.error('Error saving booking:', error);
                        }
                    });
                },
                onPending: function(result) {
                    showModal('Pending', `
                    <p>Payment pending.</p>
                    <p>Please complete your payment.</p>
                    <p>We'll notify you when payment is confirmed.</p>
                `);
                },
                onError: function(result) {
                    showModal('Error', `
                    <p>Payment failed: ${result.status_message || 'Unknown error'}</p>
                    <p>Please try again or contact support.</p>
                `);
                },
                onClose: function() {
                    console.log('Payment popup closed');
                }
            });
        }, 1000);


        // Instagram Stories Data
        const stories = [{
                id: 1,
                category: "wedding",
                title: "Sarah & John Wedding",
                date: "15 Juni 2024",
                details: "150 Guests",
                image: "https://images.unsplash.com/photo-1519741497674-611481863552?w=500&h=889&fit=crop",
                avatar: "https://randomuser.me/api/portraits/women/44.jpg",
                duration: 5000,
                color: "from-purple-500 to-pink-500"
            },
            {
                id: 2,
                category: "corporate",
                title: "TechCorp Retreat",
                date: "8 Agustus 2024",
                details: "80 People",
                image: "https://images.unsplash.com/photo-1511578314322-379afb476865?w=500&h=889&fit=crop",
                avatar: "https://randomuser.me/api/portraits/men/32.jpg",
                duration: 5000,
                color: "from-blue-500 to-cyan-500"
            },
            {
                id: 3,
                category: "birthday",
                title: "Jessica's 17th",
                date: "22 Sept 2024",
                details: "50 Friends",
                image: "https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=500&h=889&fit=crop",
                avatar: "https://randomuser.me/api/portraits/women/68.jpg",
                duration: 5000,
                color: "from-pink-500 to-red-500"
            },
            {
                id: 4,
                category: "reunion",
                title: "Smith Family Reunion",
                date: "12 Nov 2024",
                details: "120 Members",
                image: "https://images.unsplash.com/photo-1511895426328-dc8714191300?w=500&h=889&fit=crop",
                avatar: "https://randomuser.me/api/portraits/men/75.jpg",
                duration: 5000,
                color: "from-green-500 to-teal-500"
            },
            {
                id: 5,
                category: "wedding",
                title: "25th Anniversary",
                date: "14 Feb 2025",
                details: "100 Guests",
                image: "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=500&h=889&fit=crop",
                avatar: "https://randomuser.me/api/portraits/women/33.jpg",
                duration: 5000,
                color: "from-purple-600 to-indigo-600"
            },
            {
                id: 6,
                category: "corporate",
                title: "Exec Meeting",
                date: "20 Dec 2024",
                details: "30 Execs",
                image: "https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=500&h=889&fit=crop",
                avatar: "https://randomuser.me/api/portraits/men/45.jpg",
                duration: 5000,
                color: "from-blue-600 to-indigo-600"
            }
        ];

        // Story Player Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const storyViewer = document.getElementById('story-viewer');
            const currentStoryEl = document.getElementById('current-story');
            const progressBarsEl = document.getElementById('progress-bars');
            const navButtons = document.querySelectorAll('.story-nav');

            let currentStoryIndex = 0;
            let progressInterval;
            let isPaused = false;

            // Initialize progress bars
            function initProgressBars() {
                progressBarsEl.innerHTML = '';
                stories.forEach((story, index) => {
                    const progressBar = document.createElement('div');
                    progressBar.className = 'h-1 flex-1 bg-gray-400/30 rounded-full overflow-hidden';
                    progressBar.innerHTML =
                        `<div class="h-full bg-white rounded-full story-progress" id="progress-${index}" style="width: 0%"></div>`;
                    progressBarsEl.appendChild(progressBar);
                });
            }

            // Load a story
            function loadStory(index) {
                if (index < 0 || index >= stories.length) return;

                currentStoryIndex = index;
                const story = stories[index];

                currentStoryEl.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-tr ${story.color}">
                    <img src="${story.image}" alt="${story.title}" class="w-full h-full object-cover">
                </div>
                <div class="absolute top-16 left-0 right-0 p-4 z-10">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3">
                                <img src="${story.avatar}" class="w-9 h-9 rounded-full object-cover">
                            </div>
                            <div>
                                <div class="text-white font-medium">${story.title}</div>
                                <div class="text-white/80 text-sm">${story.date}</div>
                            </div>
                        </div>
                        <span class="text-white text-xs bg-black/30 px-2 py-1 rounded-full">${story.category}</span>
                    </div>
                </div>
            `;

                // Reset all progress bars
                document.querySelectorAll('.story-progress').forEach(bar => {
                    bar.style.width = '0%';
                });

                // Highlight current progress bar
                for (let i = 0; i < index; i++) {
                    document.getElementById(`progress-${i}`).style.width = '100%';
                }

                // Start progress
                startProgress();
            }

            // Start progress animation
            function startProgress() {
                clearInterval(progressInterval);

                if (isPaused) return;

                const progressBar = document.getElementById(`progress-${currentStoryIndex}`);
                const duration = stories[currentStoryIndex].duration;
                let width = 0;

                progressInterval = setInterval(() => {
                    if (!isPaused) {
                        width += 1;
                        progressBar.style.width = width + '%';

                        if (width >= 100) {
                            clearInterval(progressInterval);
                            nextStory();
                        }
                    }
                }, duration / 100);
            }

            // Next story
            function nextStory() {
                if (currentStoryIndex < stories.length - 1) {
                    loadStory(currentStoryIndex + 1);
                } else {
                    // Loop back to first story
                    loadStory(0);
                }
            }

            // Previous story
            function prevStory() {
                if (currentStoryIndex > 0) {
                    loadStory(currentStoryIndex - 1);
                } else {
                    // Loop to last story
                    loadStory(stories.length - 1);
                }
            }

            // Navigation buttons
            navButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const direction = this.getAttribute('data-direction');
                    if (direction === 'next') {
                        nextStory();
                    } else {
                        prevStory();
                    }
                });
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') {
                    nextStory();
                } else if (e.key === 'ArrowLeft') {
                    prevStory();
                }
            });

            // Touch events for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            storyViewer.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            }, false);

            storyViewer.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, false);

            function handleSwipe() {
                if (touchEndX < touchStartX - 50) {
                    nextStory(); // Swipe left
                } else if (touchEndX > touchStartX + 50) {
                    prevStory(); // Swipe right
                }
            }

            // Initialize
            initProgressBars();
            loadStory(0);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('reviews-slider');
            const prevBtn = document.getElementById('review-prev');
            const nextBtn = document.getElementById('review-next');
            const reviews = document.querySelectorAll('#reviews-slider > div');

            let currentIndex = 0;
            const cardWidth = reviews[0].offsetWidth;
            const visibleCards = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
            let autoSlideInterval;

            // Initialize slider position
            updateSliderPosition();

            // Auto slide every 5 seconds
            function startAutoSlide() {
                autoSlideInterval = setInterval(() => {
                    nextSlide();
                }, 1000);
            }

            startAutoSlide();

            // Pause auto slide on hover
            slider.parentElement.addEventListener('mouseenter', () => {
                clearInterval(autoSlideInterval);
            });

            slider.parentElement.addEventListener('mouseleave', () => {
                startAutoSlide();
            });

            // Next slide
            function nextSlide() {
                if (currentIndex < reviews.length - visibleCards) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateSliderPosition();
            }

            // Previous slide
            function prevSlide() {
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = reviews.length - visibleCards;
                }
                updateSliderPosition();
            }

            // Update slider position
            function updateSliderPosition() {
                const offset = -currentIndex * cardWidth;
                slider.style.transform = `translateX(${offset}px)`;
            }

            // Button events
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            // Handle window resize
            window.addEventListener('resize', function() {
                const newVisibleCards = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
                if (newVisibleCards !== visibleCards) {
                    currentIndex = 0;
                    updateSliderPosition();
                }
            });
        });
    </script>
</body>

</html>
