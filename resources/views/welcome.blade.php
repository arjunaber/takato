<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAKATO.id - Luxury Residence, Premium Dining & Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* LUXURY WARM TONE PALETTE (Light Mode - Earth Tones) */
        :root {
            --color-light-bg: #fbf4e2;
            /* Main Cream/Beige Background */
            --color-white-contrast: #ffffff;
            /* White for Card/Pop-up Contrast */
            --color-dark-text: #1c1a16;
            /* Espresso Brown/Dark Text */
            --color-primary-accent: #a87e5b;
            /* Medium Warm Brown/Gold Accent */
            --color-secondary-accent: #b08d6d;
            /* Soft Brown Button/Highlight */
            --color-button-bg: #b08d6d;
            --color-hover-bg: #c9a686;
            --color-border-subtle: #eae3d4;
            /* Subtle Border Color */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-light-bg);
            color: var(--color-dark-text);
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
            border: 1px solid var(--color-border-subtle);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(168, 126, 91, 0.1);
        }

        /* Gradient Text (Warm Brown) */
        .gradient-text {
            background: linear-gradient(45deg, var(--color-primary-accent) 20%, #856149 80%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Button Style */
        .btn-warm {
            background-color: var(--color-button-bg);
            color: white;
            transition: all 0.3s;
        }

        .btn-warm:hover {
            background-color: var(--color-hover-bg);
            box-shadow: 0 8px 15px rgba(168, 126, 91, 0.3);
            transform: translateY(-1px);
        }

        .btn-light-subtle {
            background-color: var(--color-border-subtle);
            color: var(--color-dark-text);
            transition: all 0.3s;
        }

        .btn-light-subtle:hover {
            background-color: #dfd8c9;
        }

        /* Nav Link Style */
        .nav-link-elegant {
            color: var(--color-dark-text);
            position: relative;
            padding-bottom: 5px;
            font-weight: 500;
        }

        .nav-link-elegant.active {
            color: var(--color-primary-accent);
            border-bottom: 2px solid var(--color-primary-accent);
            padding-bottom: 3px;
        }

        /* Placeholder for Dummy Image (No longer needed, but keeping the class for reference) */
        .dummy-img-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 0.8rem;
            color: #888;
            border: 2px dashed #ccc;
            background-color: #f5f0e1;
            padding: 1rem;
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

        /* Image Placeholder Style to match the aspect ratio but use a real image */
        .image-container {
            position: absolute;
            inset: 0;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-[var(--color-light-bg)] text-[var(--color-dark-text)]" x-data="{
    isModalOpen: false,
    modalTitle: '',
    modalImage: '',
    modalContent: '',
    openModal(title, image, content) {
        this.modalTitle = title;
        this.modalImage = image;
        this.modalContent = content;
        this.isModalOpen = true;
    }
}">

    <nav id="fixed-nav"
        class="fixed top-0 left-0 w-full z-50 flex justify-center items-center py-5 px-6 md:px-10 bg-white shadow-sm">
        <div class="w-full flex flex-row justify-between items-center max-w-7xl">
            <a href="#home"
                class="text-2xl font-extrabold font-serif text-[var(--color-dark-text)] tracking-wider">Takato.id</a>
            <div class="hidden md:flex gap-8" role="navigation">
                <a href="#home" class="nav-link-elegant active">Home</a>
                <a href="#experience" class="nav-link-elegant">Experience</a>
                <a href="#residence" class="nav-link-elegant">Residence</a>
                <a href="#dining" class="nav-link-elegant">Dining</a>
                <a href="#faq" class="nav-link-elegant">FAQ</a>
                <a href="#contact" class="nav-link-elegant">Contact</a>
            </div>
            <button class="md:hidden text-[var(--color-dark-text)] text-xl" id="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <div x-data="{ open: false }" class="md:hidden">
        <button id="mobile-menu-btn-alt" @click="open = true" class="hidden"></button>
        <div x-show="open"
            class="fixed inset-0 z-[60] bg-[var(--color-light-bg)]/95 backdrop-blur-lg transform transition-transform ease-in-out duration-300"
            :class="{ 'translate-x-0': open, 'translate-x-full': !open }" style="display: none;">
            <div class="p-6 flex flex-col h-full">
                <div class="flex justify-between items-center mb-10">
                    <div class="text-2xl font-extrabold font-serif text-[var(--color-dark-text)] tracking-wider">
                        Takato.id</div>
                    <button @click="open = false" class="text-[var(--color-dark-text)] text-3xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex flex-col gap-6 text-xl font-semibold">
                    <a @click="open = false" href="#home"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition">Home</a>
                    <a @click="open = false" href="#experience"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition">Experience</a>
                    <a @click="open = false" href="#residence"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition">Residence</a>
                    <a @click="open = false" href="#dining"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition">Dining</a>
                    <a @click="open = false" href="#faq"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition">FAQ</a>
                    <a @click="open = false" href="#contact"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition">Contact</a>
                </nav>
            </div>
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
                <div class="w-full md:w-1/2 p-8 relative">
                    <button @click="isModalOpen = false"
                        class="absolute top-4 right-4 text-2xl text-[var(--color-dark-text)] hover:text-[var(--color-primary-accent)] transition">
                        <i class="fas fa-times"></i>
                    </button>

                    <h3 class="font-serif text-3xl font-bold text-[var(--color-dark-text)] mb-4" x-text="modalTitle">
                    </h3>
                    <div class="text-gray-700 space-y-4" x-html="modalContent"></div>

                    <a href="https://wa.me/+6281214831823" target="_blank"
                        class="mt-6 inline-flex items-center gap-2 px-6 py-3 btn-warm rounded-md font-semibold text-base">
                        Inquire Now <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <section id="home" class="relative min-h-[90vh] flex flex-col justify-start pt-24 overflow-hidden">
        <div class="w-full max-w-7xl mx-auto px-6">
            <div class="relative w-full card-elegant rounded-xl shadow-luxury overflow-hidden">
                <div class="w-full h-0 pb-[60%] relative">
                    <div class="image-container">
                        <img src="https://lifestyleretreats.com/wp-content/uploads/2023/02/Villa-Candani-Main-House-Overview-Nighttime.webp"
                            alt="Luxury villa exterior with a large swimming pool and tropical greenery, suitable for a Takato House exterior view."
                            loading="lazy">
                    </div>
                </div>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 bg-black/35">
                    <h1 class="font-serif text-5xl sm:text-6xl md:text-7xl font-bold text-white mb-8 leading-tight">
                        A Luxury Space <br class="hidden sm:block" /> for Every Story
                    </h1>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="#residence"
                            class="w-full sm:w-auto px-8 py-3.5 btn-warm rounded-md font-semibold text-lg shadow-luxury">
                            Explore Takato House
                        </a>
                        <a href="#dining"
                            class="w-full sm:w-auto px-8 py-3.5 btn-light-subtle rounded-md font-semibold text-lg shadow-luxury">
                            Visit Takato Restaurant
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid md:grid-cols-2 gap-12 items-start">

                <div class="card-elegant p-8 rounded-xl shadow-luxury space-y-4">
                    <h2 class="font-serif text-3xl font-bold text-[var(--color-dark-text)]">Takato House</h2>
                    <p class="text-lg text-gray-700">
                        A versatile villa venue for weddings, gatherings, and retreats.
                    </p>
                    <a href="#residence"
                        class="inline-block px-6 py-3 btn-light-subtle rounded-md font-semibold text-base">
                        View More <i class="fas fa-arrow-right text-sm ml-2"></i>
                    </a>
                </div>

                <div class="card-elegant p-8 rounded-xl shadow-luxury space-y-4">
                    <h2 class="font-serif text-3xl font-bold text-[var(--color-dark-text)]">Takato Restaurant</h2>
                    <p class="text-lg text-gray-700">
                        A cozy family garden cafe with traditional Indonesian dishes.
                    </p>
                    <a href="#dining"
                        class="inline-block px-6 py-3 btn-light-subtle rounded-md font-semibold text-base">
                        View Menu <i class="fas fa-arrow-right text-sm ml-2"></i>
                    </a>
                </div>
            </div>

            <div class="mt-12 p-8 card-elegant rounded-xl shadow-luxury">
                <h3 class="font-serif text-3xl font-bold text-[var(--color-dark-text)] mb-4">Our Story</h3>
                <p class="text-lg text-gray-700 max-w-4xl">
                    Takato Coffee & Kitchen was conceived out of a love for good food and a desire
                    to share the best of Nusantara cuisine in a welcoming, garden setting.
                </p>
            </div>
        </div>
    </section>

    <section id="experience" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-serif text-4xl sm:text-5xl font-bold text-[var(--color-dark-text)]">
                    Curated <span class="gradient-text">Experiences</span>
                </h2>
                <p class="text-xl text-gray-600 mt-4 max-w-4xl mx-auto">
                    Host your most cherished moments in our magnificent venue.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">

                <div class="card-elegant p-8 rounded-xl shadow-luxury space-y-4 cursor-pointer"
                    @click="openModal('The Wedding Venue', 'https://weddingmarket.com/storage/images/artikelidea/cd57df0724156a06e98469692ea39ddd1de675ee.webp', `A magical and elegant setting for your unforgettable wedding ceremony and reception. Our expansive garden and elegant villa interior offer the perfect backdrop for both intimate and grand celebrations. The venue can accommodate <strong>up to 300 guests</strong> (standing) with a dedicated catering area.`)">
                    <i class="fas fa-ring text-4xl text-[var(--color-primary-accent)] mb-2"></i>
                    <h3 class="font-serif text-2xl font-bold mb-3 text-[var(--color-dark-text)]">Wedding</h3>
                    <p class="text-gray-700 mb-4">
                        A magical and elegant setting for your unforgettable wedding ceremony and reception.
                    </p>
                    <a @click.stop href="https://wa.me/+6281214831823" target="_blank"
                        class="text-sm text-[var(--color-primary-accent)] font-semibold hover:underline">
                        See Packages <i class="fas fa-arrow-right text-xs ml-1"></i>
                    </a>
                </div>

                <div class="card-elegant p-8 rounded-xl shadow-luxury space-y-4 cursor-pointer"
                    @click="openModal('Executive Corporate Retreats', 'https://julssharpleyevents.com/wp-content/uploads/2024/08/corporate-retreat-planning.jpg', `Ideal for <strong>team building, product launches, and high-level corporate gatherings</strong>. Enjoy our professional meeting hall, private dining spaces, and comfortable 11-bedroom villa for an inspiring offsite experience. Includes high-speed Wi-Fi and presentation facilities.`)">
                    <i class="fas fa-users text-4xl text-[var(--color-primary-accent)] mb-2"></i>
                    <h3 class="font-serif text-2xl font-bold mb-3 text-[var(--color-dark-text)]">Corporate Retreat</h3>
                    <p class="text-gray-700 mb-4">
                        Ideal for team building, product launches, and high-level corporate gatherings.
                    </p>
                    <a @click.stop href="https://wa.me/+6281214831823" target="_blank"
                        class="text-sm text-[var(--color-primary-accent)] font-semibold hover:underline">
                        Get Quotation <i class="fas fa-arrow-right text-xs ml-1"></i>
                    </a>
                </div>

                <div class="card-elegant p-8 rounded-xl shadow-luxury space-y-4 cursor-pointer"
                    @click="openModal('The Ultimate Family Gathering', 'https://images.stockcake.com/public/8/5/7/8570134f-7780-4b73-a459-59c5257e2615_large/family-dinner-gathering-stockcake.jpg', `A spacious, comfortable private villa perfect for <strong>large family events and reunions</strong>. With 11 bedrooms, a private pool, and expansive outdoor areas, it ensures everyone has a relaxing and enjoyable stay. Self-catering is easy with our two complete kitchens.`)">
                    <i class="fas fa-caravan text-4xl text-[var(--color-primary-accent)] mb-2"></i>
                    <h3 class="font-serif text-2xl font-bold mb-3 text-[var(--color-dark-text)]">Family Gathering</h3>
                    <p class="text-gray-700 mb-4">
                        Spacious, comfortable private villa for large family events and reunions.
                    </p>
                    <a @click.stop href="https://wa.me/+6281214831823" target="_blank"
                        class="text-sm text-[var(--color-primary-accent)] font-semibold hover:underline">
                        Book Your Stay <i class="fas fa-arrow-right text-xs ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="mt-16 card-elegant p-8 rounded-xl shadow-luxury border-l-4 border-[var(--color-button-bg)]">
                <h3 class="font-serif text-3xl font-bold mb-4 flex items-center gap-3 text-[var(--color-dark-text)]">
                    <i class="fas fa-utensils text-[var(--color-primary-accent)]"></i> TAKATO Catering Services
                </h3>
                <p class="text-lg text-gray-700 max-w-4xl">
                    Ensure your event is perfect with our in-house catering, offering bespoke menus from authentic
                    Nusantara cuisine to international delights. Available for all events held at Takato House.
                </p>
                <a href="https://wa.me/+6281214831823" target="_blank"
                    class="inline-block mt-4 px-6 py-3 btn-warm rounded-md font-semibold text-base">
                    Inquire Catering Package
                </a>
            </div>
        </div>
    </section>

    <section id="residence" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-serif text-4xl sm:text-5xl font-bold text-[var(--color-dark-text)]">
                    TAKATO <span class="gradient-text">Residence</span>
                </h2>
                <p class="text-xl text-gray-600 mt-4 max-w-4xl mx-auto">
                    A versatile and elegant private villa space for stay and events.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12 items-stretch">

                <div class="lg:col-span-2 space-y-8">
                    <h3 class="font-serif text-3xl font-bold text-[var(--color-dark-text)] mb-4">Area & 3D Design
                        Overview</h3>

                    <div class="grid md:grid-cols-2 gap-8">

                        <div class="card-elegant p-6 rounded-xl shadow-luxury">
                            <p class="text-lg uppercase text-[var(--color-dark-text)] font-semibold mb-2">Land Area
                                (5,600 m²)</p>
                            <div
                                class="w-full h-64 rounded-lg overflow-hidden border-2 border-[var(--color-border-subtle)]">
                                <img src="https://5.imimg.com/data5/GX/MY/MY-10901897/3d-design-and-consultation.jpg"
                                    alt="3D Design Rendering of Land Area" class="w-full h-full object-cover"
                                    loading="lazy">
                            </div>
                            <p class="text-sm text-gray-600 mt-3">
                                Rencana mendetail dari total 5,600 m² lahan yang mencakup taman, kolam renang privat,
                                dan area outdoor.
                            </p>
                        </div>

                        <div class="card-elegant p-6 rounded-xl shadow-luxury">
                            <p class="text-lg uppercase text-[var(--color-dark-text)] font-semibold mb-2">Building Area
                                (1,000 m²)</p>
                            <div
                                class="w-full h-64 rounded-lg overflow-hidden border-2 border-[var(--color-border-subtle)]">
                                <img src="https://5.imimg.com/data5/GX/MY/MY-10901897/3d-design-and-consultation.jpg"
                                    alt="3D Design Rendering of Building Area" class="w-full h-full object-cover"
                                    loading="lazy">
                            </div>
                            <p class="text-sm text-gray-600 mt-3">
                                Visualisasi 3D dari 1,000 m² bangunan, termasuk 11 kamar tidur, ruang keluarga, dan
                                fasilitas dalam ruangan.
                            </p>
                        </div>

                    </div>

                    <blockquote
                        class="border-l-4 border-[var(--color-primary-accent)] pl-4 py-2 text-lg italic text-gray-700">
                        "Visualisasi desain 3D rinci telah tersedia untuk menyajikan gambaran imersif mengenai potensi
                        penuh dan kemewahan ruang Takato House."
                    </blockquote>
                </div>

                <div class="lg:col-span-1 space-y-10">

                    <div class="card-elegant p-8 rounded-xl shadow-luxury h-fit">
                        <h3 class="font-serif text-3xl font-bold mb-4 text-[var(--color-dark-text)]">Key Facilities
                        </h3>
                        <ul class="space-y-4 text-lg">
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-bed text-[var(--color-primary-accent)]"></i> 11 Bedrooms (Capacity
                                50+)
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-utensils text-[var(--color-primary-accent)]"></i> 2 Complete Kitchens
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-swimming-pool text-[var(--color-primary-accent)]"></i> Private
                                Swimming Pool
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-fire text-[var(--color-primary-accent)]"></i> BBQ & Gazebo Area
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-table-tennis text-[var(--color-primary-accent)]"></i> Indoor
                                Badminton/Hall
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-caravan text-[var(--color-primary-accent)]"></i> Large Parking Lot
                            </li>
                        </ul>
                    </div>

                    <div
                        class="card-elegant p-8 rounded-xl shadow-luxury h-fit border-l-4 border-[var(--color-button-bg)]">
                        <h3 class="font-serif text-xl font-bold mb-4 text-[var(--color-dark-text)]">Reservations
                            (TAKATO.House)</h3>
                        <p class="text-gray-700 mb-4">
                            Tanyakan ketersediaan tanggal dan paket event spesifik Anda langsung kepada tim kami.
                        </p>
                        <a href="https://wa.me/+6281214831823" target="_blank"
                            class="inline-flex items-center gap-2 w-full justify-center px-6 py-3 btn-warm rounded-md font-semibold text-base">
                            Inquire Availability via WhatsApp <i class="fab fa-whatsapp ml-1"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="dining" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-serif text-4xl sm:text-5xl font-bold text-[var(--color-dark-text)]">
                    Takato <span class="gradient-text">Dining</span>
                </h2>
                <p class="text-xl text-gray-600 mt-4 max-w-4xl mx-auto">
                    A cozy family garden cafe offering authentic Nusantara flavors.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-start">

                <div class="lg:order-1 space-y-6">
                    <div class="w-full h-[450px] rounded-xl shadow-luxury overflow-hidden border border-gray-200">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Cozy, brightly lit family garden cafe with wooden furniture and lush plants."
                            loading="lazy" class="w-full h-full object-cover">
                    </div>

                    <h3 class="font-serif text-3xl font-bold text-[var(--color-dark-text)] pt-4">Our Story & Ambience
                    </h3>
                    <p class="text-lg text-gray-700">
                        Takato Coffee & Kitchen is a family-friendly garden cafe offering a serene atmosphere
                        and a unique menu inspired by the rich flavors of Indonesian cuisine. The cafe was conceived
                        out of a love for good food and a desire to share the best of Nusantara cuisine.
                    </p>
                </div>

                <div
                    class="lg:order-2 card-elegant p-8 rounded-xl shadow-luxury border-l-4 border-[var(--color-button-bg)]">
                    <h3 class="font-serif text-3xl font-bold mb-6 text-[var(--color-dark-text)]">Signature Menu</h3>
                    <ul class="space-y-4 text-xl mb-8">
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-dark-text)]">
                            <i class="fas fa-drumstick-bite text-[var(--color-primary-accent)]"></i> Nasi Goreng
                        </li>
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-dark-text)]">
                            <i class="fas fa-drumstick-bite text-[var(--color-primary-accent)]"></i> Gado Gado
                        </li>
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-dark-text)]">
                            <i class="fas fa-drumstick-bite text-[var(--color-primary-accent)]"></i> Soto Ayam
                        </li>
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-dark-text)]">
                            <i class="fas fa-drumstick-bite text-[var(--color-primary-accent)]"></i> Ikan Bakar
                        </li>
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-dark-text)]">
                            <i class="fas fa-coffee text-[var(--color-primary-accent)]"></i> Premium Bogor Coffee
                        </li>
                    </ul>
                    <div class="w-full h-64 rounded-xl shadow-md overflow-hidden border border-gray-200">
                        <img src="https://www.unileverfoodsolutions.co.id/dam/global-ufs/mcos/SEA/calcmenu/recipes/ID-recipes/chicken-&-other-poultry-dishes/soto-ayam/main-header.jpg"
                            alt="A beautifully plated Indonesian Nasi Goreng with egg and fresh garnish."
                            loading="lazy" class="w-full h-full object-cover">
                    </div>
                    <a href="#contact"
                        class="inline-block mt-4 px-6 py-3 btn-light-subtle rounded-md font-semibold text-base">
                        Reserve a Table
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-20">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-serif text-4xl sm:text-5xl font-bold text-[var(--color-dark-text)]">
                    Frequently Asked <span class="gradient-text">Questions</span>
                </h2>
                <p class="text-xl text-gray-600 mt-4 max-w-4xl mx-auto">
                    Find quick answers about our Residence, Dining, and Events.
                </p>
            </div>

            <div class="space-y-4">

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>What is the difference between Takato House and Takato Coffee & Kitchen?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            The <strong>Takato House</strong> is the private luxury villa used for exclusive stays,
                            large gatherings,
                            and events (like weddings/retreats). The <strong>Takato Coffee & Kitchen</strong> is a
                            public-facing
                            garden cafe and restaurant on the same property, focusing on authentic Nusantara dining.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>How can I check the availability for booking the entire Takato House?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            Please check the <strong>Residence</strong> section for details or, for the fastest
                            response, we
                            recommend inquiring directly via WhatsApp. This ensures you get the most up-to-date
                            availability for
                            your event needs.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>Do you provide catering service for outside events?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            Currently, the <strong>TAKATO Catering</strong> service is primarily focused on supporting
                            events and
                            stays held at the TAKATO House and Restaurant. Please contact us for a consultation
                            regarding specific catering needs outside of our premises.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>What is the maximum capacity for private events at Takato House?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            The <strong>Takato House</strong> can comfortably accommodate up to <strong>50 overnight
                                guests</strong> using its 11
                            bedrooms. For larger standing or seating events (e.g., weddings), the venue capacity extends
                            up to
                            <strong>300 pax</strong> utilizing the expansive garden and outdoor areas.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>Is Takato Coffee & Kitchen open to the public?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            Yes, <strong>Takato Coffee & Kitchen</strong> is a restaurant and garden cafe open daily to
                            the public,
                            serving authentic Nusantara cuisine. The dining area operates separately from the private
                            Takato House villa rental.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>Is the private pool accessible during restaurant operating hours?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            No. The private swimming pool is part of the <strong>Takato House</strong> facilities and is
                            strictly
                            reserved for guests who have booked the exclusive villa stay or event package. It is not
                            open
                            to restaurant patrons.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>Can we bring our own outside catering for events at Takato House?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            We encourage guests to utilize our highly-rated <strong>TAKATO Catering</strong> services.
                            However, for
                            certain large-scale events, external catering may be permitted with an additional corkage
                            fee.
                            Please discuss this during your initial booking inquiry.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>Is there sufficient parking space for event guests?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            Yes, <strong>Takato House</strong> and the surrounding complex provide a <strong>large
                                dedicated parking lot</strong>
                            capable of accommodating many vehicles for both staying guests and event attendees.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>What is the travel distance from Bogor or Jakarta?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            We are conveniently located on Jalan Raya Puncak, Ciawi, offering easy access. Travel time
                            is typically
                            around <strong>30-45 minutes from Bogor</strong> and approximately <strong>1.5-2 hours from
                                Jakarta</strong>, depending on traffic conditions.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-6 py-4 text-left font-semibold text-lg text-[var(--color-dark-text)] hover:bg-gray-50 transition">
                        <span>Can Takato Coffee & Kitchen host small private dining events?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3">
                            Yes, our restaurant offers several semi-private areas perfect for birthday parties, arisan,
                            or intimate corporate dinners (up to <strong>30 pax</strong>). Please contact us to reserve
                            a section of our garden cafe.
                        </p>
                    </div>
                </div>

            </div>

            <div class="text-center mt-10">
                <p class="text-gray-600">Need more information? <a href="https://wa.me/+6281214831823"
                        target="_blank"
                        class="font-bold text-[var(--color-primary-accent)] hover:text-[var(--color-dark-text)] transition">Chat
                        with our support.</a></p>
            </div>
        </div>
    </section>

    <section id="contact" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-10">
                <h2 class="font-serif text-4xl sm:text-5xl font-bold text-[var(--color-dark-text)]">
                    Contact & <span class="gradient-text">Location</span>
                </h2>
            </div>

            <div class="space-y-8">
                <div class="space-y-4">
                    <div class="h-80 rounded-xl overflow-hidden shadow-luxury border border-gray-200">
                        <iframe
                            src="https://maps.google.com/maps?q=Jalan%20Raya%20Puncak,%20Blok%20Bendungan,%20Ciawi,%20Cijeruk,%20Bogor&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="card-elegant p-6 rounded-xl shadow-luxury space-y-3">
                        <p class="text-xl font-medium text-[var(--color-dark-text)]">
                            Jalan Raya Puncak, Blok Bendungan, Ciawi, Cijeruk, Bogor, Jawa Barat 16740
                        </p>
                        <p class="text-lg text-gray-700">
                            Operating Hours: Monday - Sunday, 9:00 AM – 9:00 PM
                        </p>
                    </div>
                </div>

                <div class="card-elegant p-6 rounded-xl shadow-luxury">
                    <div class="flex justify-center mb-6">
                        <a href="https://wa.me/+6281214831823" target="_blank"
                            class="w-full sm:w-1/2 px-8 py-3.5 btn-chat rounded-md font-semibold text-lg flex items-center justify-center gap-2 hover:shadow-lg">
                            <i class="fab fa-whatsapp"></i> Chat with us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t border-gray-200 py-10 bg-[var(--color-light-bg)]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-2xl font-extrabold font-serif text-[var(--color-dark-text)] mb-1">Takato.id</h3>
                    <p class="text-gray-600 text-sm">© 2024 Takato.id. All Rights Reserved.</p>
                </div>
                <div class="flex gap-5 text-2xl">
                    <a href="#" class="text-gray-500 hover:text-[var(--color-primary-accent)] transition"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-500 hover:text-[var(--color-primary-accent)] transition"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/+6281214831823" target="_blank"
                        class="text-gray-500 hover:text-[var(--color-primary-accent)] transition"><i
                            class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <div class="fixed bottom-8 right-6 z-[1008]">
        <a href="https://wa.me/+6281214831823" target="_blank" rel="noopener noreferrer"
            class="group w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-xl shadow-green-500/50 hover:scale-110 transition-all duration-300">
            <i class="fab fa-whatsapp text-white text-3xl group-hover:scale-110 transition-transform"></i>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Navigation Active State ---
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link-elegant');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');

            // Open mobile menu logic (Trigger Alpine.js)
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', () => {
                    const alpineData = mobileMenuBtn.closest('body').querySelector('div[x-data]');
                    if (alpineData && alpineData.__x && alpineData.__x.$data) {
                        alpineData.__x.$data.open = true;
                    }
                });
            }

            function setActiveLink() {
                let current = 'home';
                const scrollPos = window.scrollY + 150;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;

                    if (scrollPos >= (sectionTop - 100) && scrollPos < (sectionTop + sectionHeight - 100)) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    const targetId = link.getAttribute('href').substring(1);

                    if (targetId === current) {
                        link.classList.add('active');
                    }
                });
            }

            window.addEventListener('scroll', setActiveLink);
            setActiveLink();
        });
    </script>
</body>

</html>
