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
    </style>
</head>

<body class="font-sans bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-primary">TAKATO</div>
            <div class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-700 hover:text-primary">Home</a>
                <a href="#profile" class="text-gray-700 hover:text-primary">Profile</a>
                <a href="#facilities" class="text-gray-700 hover:text-primary">Facilities</a>
                <a href="#" class="text-gray-700 hover:text-primary">Login</a>
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
                <a href="#" class="flip-card">
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
                        <div class="flip-card-back">
                            <img src="https://cdn-icons-png.flaticon.com/512/3174/3174825.png" alt="Restaurant Icon">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Villa Facilities Section with Black Background -->
    <section id="facilities" class="py-20 bg-black text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Villa Facilities</h2>
                <p class="text-gray-300 max-w-2xl mx-auto">Discover the premium amenities we offer at our villas</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Facility 1 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="/904b43c3-7771-49cb-9994-7df19df0071e.avif" alt="Swimming Pool"
                        class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pool</h3>
                        <p class="text-gray-600">Stunning pool with panoramic views, perfect for relaxation and
                            sunset watching.</p>
                    </div>
                </div>

                <!-- Facility 2 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Luxury Bedroom" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Luxury Bedrooms</h3>
                        <p class="text-gray-600">Spacious bedrooms with premium bedding, air conditioning, and private
                            balconies.</p>
                    </div>
                </div>

                <!-- Facility 3 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="https://images.unsplash.com/photo-1600566752225-3f2fe3f8f6c8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Restaurant" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Private Chef</h3>
                        <p class="text-gray-600">Enjoy gourmet meals prepared by our professional chefs in the comfort
                            of your villa.</p>
                    </div>
                </div>

                <!-- Facility 4 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Spa" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Spa Services</h3>
                        <p class="text-gray-600">Rejuvenate with our range of spa treatments and massage therapies.</p>
                    </div>
                </div>

                <!-- Facility 5 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Gym" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Fitness Center</h3>
                        <p class="text-gray-600">State-of-the-art gym equipment for your daily workout routine.</p>
                    </div>
                </div>

                <!-- Facility 6 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Meeting Room" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Meeting Rooms</h3>
                        <p class="text-gray-600">Fully equipped meeting spaces for business travelers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Restaurant Facilities Section -->
    <section id="resto-facilities" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Restaurant Experience</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Discover our exceptional dining facilities and breathtaking
                    views</p>
            </div>

            <!-- Main Content -->
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Column - Image Gallery -->
                <div class="relative">
                    <!-- Main Image -->
                    <div class="rounded-2xl overflow-hidden shadow-xl mb-6 h-96">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
                            alt="Restaurant Interior"
                            class="w-full h-full object-cover transition-all duration-500 hover:scale-105">
                    </div>

                    <!-- Thumbnail Gallery -->
                    <div class="grid grid-cols-3 gap-4">
                        <div
                            class="rounded-lg overflow-hidden shadow-md h-32 cursor-pointer hover:shadow-lg transition">
                            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                alt="Dining Area" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="rounded-lg overflow-hidden shadow-md h-32 cursor-pointer hover:shadow-lg transition">
                            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                alt="Chef Cooking" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="rounded-lg overflow-hidden shadow-md h-32 cursor-pointer hover:shadow-lg transition">
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                alt="Food Presentation" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Right Column - Facilities Info -->
                <div>
                    <!-- Features List -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Our Dining Features</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="bg-primary/10 p-2 rounded-full mr-4">
                                    <i class="fas fa-utensils text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Gourmet Cuisine</h4>
                                    <p class="text-gray-600">Experience exquisite dishes prepared by our award-winning
                                        chefs</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary/10 p-2 rounded-full mr-4">
                                    <i class="fas fa-wine-glass-alt text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Premium Bar</h4>
                                    <p class="text-gray-600">Extensive selection of fine wines and craft cocktails</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary/10 p-2 rounded-full mr-4">
                                    <i class="fas fa-sun text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Sunset Terrace</h4>
                                    <p class="text-gray-600">Outdoor seating with panoramic ocean views</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary/10 p-2 rounded-full mr-4">
                                    <i class="fas fa-music text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Live Entertainment</h4>
                                    <p class="text-gray-600">Weekly performances by local artists</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- View Description -->
                    <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-primary">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Breathtaking Views</h3>
                        <p class="text-gray-600 mb-4">Our restaurant offers unparalleled views of the coastline from
                            every angle. Whether you're dining during the day or under the stars, you'll enjoy a
                            spectacular vista that complements our culinary experience.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Best viewing times: 5:30pm - 7:30pm daily</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Highlights -->
            <div class="mt-16">
                <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">Menu Highlights</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Menu Item 1 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-transform duration-300 hover:-translate-y-2">
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="Signature Dish" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-lg text-gray-800">Ocean's Bounty Platter</h4>
                                <span
                                    class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">Chef's
                                    Choice</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Fresh seafood selection with seasonal accompaniments
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800">IDR 350K</span>
                                <button class="text-primary hover:text-primary-dark font-semibold text-sm">
                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Item 2 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-transform duration-300 hover:-translate-y-2">
                        <img src="https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="Premium Steak" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-lg text-gray-800">Wagyu Ribeye Steak</h4>
                                <span
                                    class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">Popular</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Premium Australian wagyu with truffle mashed potatoes
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800">IDR 550K</span>
                                <button class="text-primary hover:text-primary-dark font-semibold text-sm">
                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Item 3 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-transform duration-300 hover:-translate-y-2">
                        <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="Dessert" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-lg text-gray-800">Chocolate Symphony</h4>
                                <span
                                    class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">New</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Five-layer chocolate dessert with berry compote</p>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800">IDR 180K</span>
                                <button class="text-primary hover:text-primary-dark font-semibold text-sm">
                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Profile Section -->
    <section id="profile" class="py-20 bg-black text-white">
        <div class="container mx-auto px-4">
            <!-- Goals Section -->
            <div class="my-5 py-5">
                <h2 class="fw-bold text-primary text-3xl mb-8">Our Goals</h2>
                <div class="news-slider-container pb-5 pt-2" id="news-container">
                    <div class="news-slide-wrapper" id="news-slide-wrapper">
                        @foreach ([1, 2, 3, 4] as $key => $item)
                            <a id="slide-{{ $key }}" class="news-slide {{ $key == 0 ? 'active' : '' }}">
                                <div class="news-slide-content">
                                    <div class="h3 fw-bolder text-primary text-2xl font-bold mb-4">TAKATO's Mission
                                        {{ $item }}</div>
                                    <div class="text-gray-600 mb-6">At TAKATO, we're committed to revolutionizing the
                                        hospitality industry through innovative technology solutions that enhance both
                                        guest experiences and business operations.</div>
                                    <ul class="list-unstyled mt-4 space-y-3">
                                        <li class="flex items-start">
                                            <div class="badge bg-primary rounded-circle p-2 me-3 mt-1">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                            <div>Provide seamless booking and management solutions</div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="badge bg-primary rounded-circle p-2 me-3 mt-1">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                            <div>Enhance operational efficiency for hospitality businesses</div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="badge bg-primary rounded-circle p-2 me-3 mt-1">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                            <div>Deliver exceptional guest experiences</div>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="news-indicator-container flex justify-center mt-8" id="news-container-indicator">
                        @foreach ([1, 2, 3, 4] as $key => $item)
                            <div class="news-indicator {{ $key == 0 ? 'active' : '' }}" id="news-{{ $key }}"
                                onclick="goToSlideNews({{ $key }})"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Services Section -->
            <div class="my-5 py-5">
                <section class="">
                    <div class="row flex flex-col lg:flex-row">
                        <!-- Left Section: Text + Buttons -->
                        <div class="col-lg-6 mb-4 mb-lg-0 lg:pr-8">
                            <h2 class="fw-bold text-primary text-3xl mb-6">Our Services</h2>
                            <p id="service-desc" class="text-gray-600 mb-8">
                                TAKATO offers comprehensive solutions for modern hospitality businesses. Our platform
                                combines villa management and restaurant operations into one seamless experience,
                                helping you manage your business more efficiently while providing excellent service to
                                your guests.
                            </p>

                            <div class="d-flex flex-wrap gap-4 mt-5" id="service-tabs">
                                <button
                                    class="btn btn-primary px-5 py-3 rounded-full bg-primary text-white hover:bg-primary-dark transition"
                                    data-title="Villa Management"
                                    data-desc="Our villa management system provides real-time availability tracking, booking management, and owner tools to streamline your operations. With integrations to major booking platforms, you can manage all your reservations in one place."
                                    data-img="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80">
                                    Villa Management
                                </button>

                                <button
                                    class="btn btn-light px-5 py-3 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition"
                                    data-title="Restaurant System"
                                    data-desc="The TAKATO restaurant system includes menu management, order processing, inventory tracking, and integrated payments. Our system helps reduce errors, improve service speed, and provide valuable business insights."
                                    data-img="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80">
                                    Restaurant System
                                </button>

                                <button
                                    class="btn btn-light px-5 py-3 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition"
                                    data-title="Business Analytics"
                                    data-desc="Gain valuable insights into your business performance with our analytics dashboard. Track revenue, occupancy rates, popular menu items, and customer trends to make data-driven decisions for your business."
                                    data-img="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80">
                                    Analytics
                                </button>
                            </div>
                        </div>

                        <!-- Right Section: Image -->
                        <div class="col-lg-6 mt-8 lg:mt-0">
                            <div class="d-flex">
                                <img id="service-img"
                                    src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                    alt="Villa Management"
                                    style="border-radius:20px;min-height:300px;object-fit:cover;background:#F4F4F4"
                                    class="shadow w-100">
                            </div>
                        </div>
                    </div>
                </section>
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
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#profile" class="text-gray-400 hover:text-white transition">Profile</a></li>
                        <li><a href="#facilities" class="text-gray-400 hover:text-white transition">Facilities</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Login</a></li>
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
    </script>
</body>

</html>
