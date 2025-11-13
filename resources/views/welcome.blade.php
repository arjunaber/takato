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
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        /* --- NEW CUSTOM PALETTE --- */
        /* Palet Warna Baru: (#8F6E6D)(#B05520)(#C88A3B)(#DCE0DC)(#6E736A) */
        :root {
            --color-primary-dark: #6E736A;
            /* Dark Text/Secondary Text */
            --color-primary-accent: #8F6E6D;
            /* Main Brown/Primary Accent */
            --color-secondary-accent: #B05520;
            /* Strong Accent - Button BG */
            --color-tertiary-accent: #C88A3B;
            /* Button Hover/Gradient Highlight */
            --color-light-bg: #DCE0DC;
            /* Main Background/Subtle Border/Light Contrast */
            --color-white-contrast: #ffffff;
            /* White for Card/Pop-up Contrast */
            --color-black-contrast: #000000;
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
            box-shadow: 0 8px 30px rgba(143, 110, 109, 0.1);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(45deg, var(--color-secondary-accent) 20%, var(--color-tertiary-accent) 80%);
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
            background-color: var(--color-tertiary-accent);
            box-shadow: 0 8px 15px rgba(176, 85, 32, 0.3);
            transform: translateY(-1px);
        }

        /* Button Style: Subtle Light Background */
        .btn-light-subtle {
            background-color: var(--color-light-bg);
            color: var(--color-primary-dark);
            transition: all 0.3s;
        }

        .btn-light-subtle:hover {
            background-color: var(--color-primary-accent);
            color: white;
        }

        /* Nav Link Style */
        .nav-link-elegant {
            color: var(--color-primary-dark);
            position: relative;
            padding-bottom: 5px;
            font-weight: 500;
        }

        .nav-link-elegant.active {
            color: var(--color-primary-accent);
            border-bottom: 2px solid var(--color-primary-accent);
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
            event: 'Event',
            faq: 'FAQ',
            contact: 'Kontak',
            // Experience Dropdown
            wedding: 'Wedding',
            retreat: 'Corporate Retreat',
            gathering: 'Family Gathering',
            // Hero
            heroTitle1: 'Sebuah Ruang Mewah',
            heroTitle2: 'untuk Setiap Kisah',
            exploreHouse: 'Jelajahi Villa',
            visitResto: 'Kunjungi Restoran',
            // Home Cards
            houseTitle: 'Takato House',
            houseDesc: 'Sebuah vila serbaguna untuk pernikahan, pertemuan, dan retreat.',
            restoTitle: 'Takato Coffee & Kitchen',
            restoDesc: 'Kafe taman keluarga yang nyaman dengan hidangan tradisional Indonesia.',
            viewMore: 'Lihat Detail',
            viewMenu: 'Lihat Menu',
            ourStoryTitle: 'Kisah Kami',
            ourStoryDesc: 'Takato Coffee & Kitchen dicetuskan dari kecintaan terhadap makanan enak dan keinginan untuk berbagi hidangan Nusantara terbaik dalam suasana taman yang ramah.',
            // Experience
            expTitle: 'Event',
            expSubtitle: 'Kurasi',
            expDesc: 'Selenggarakan momen paling berharga Anda di venue megah kami.',
            weddingTitle: 'Pernikahan',
            weddingDesc: 'Tempat yang magis dan elegan untuk upacara dan resepsi pernikahan Anda yang tak terlupakan. Kapasitas hingga 300 pax.',
            retreatTitle: 'Corporate Retreat',
            retreatDesc: 'Ideal untuk team building, peluncuran produk, dan pertemuan perusahaan tingkat tinggi.',
            gatheringTitle: 'Family Gathering',
            gatheringDesc: 'Vila pribadi yang luas dan nyaman untuk acara keluarga besar dan reuni.',
            seePackages: 'Lihat Paket',
            getQuote: 'Dapatkan Penawaran',
            bookStay: 'Pesan Tempat Anda',
            cateringTitle: 'Layanan Katering TAKATO',
            cateringDesc: 'Pastikan acara Anda sempurna dengan katering internal kami, menawarkan menu khusus mulai dari masakan Nusantara otentik hingga hidangan internasional. Tersedia untuk semua acara di Takato House.',
            inquireCatering: 'Ajukan Paket Katering',
            // Residence
            residenceTitle: 'Villa',
            residenceDesc: 'Sebuah ruang vila pribadi yang serbaguna dan elegan untuk menginap dan acara.',
            areaDesign: 'Area & Tinjauan Desain 3D',
            landArea: 'Area Tanah',
            buildingArea: 'Area Bangunan',
            landDesc: 'Rencana mendetail dari total 5,600 m² lahan yang mencakup taman, kolam renang privat, dan area outdoor.',
            buildingDesc: 'Visualisasi 3D dari 1,000 m² bangunan, termasuk 11 kamar tidur, ruang keluarga, dan fasilitas dalam ruangan.',
            designQuote: 'Visualisasi desain 3D rinci telah tersedia untuk menyajikan gambaran imersif mengenai potensi penuh dan kemewahan ruang Takato House.',
            facilities: 'Fasilitas Utama',
            bedrooms: 'Kamar Tidur (Kapasitas 50+)',
            kitchens: 'Dapur Lengkap',
            pool: 'Kolam Renang Pribadi',
            bbq: 'Area BBQ & Gazebo',
            hall: 'Hall/Area Badminton Indoor',
            parking: 'Tempat Parkir Luas',
            reservations: 'Reservasi (TAKATO House)',
            inquireAvail: 'Pesan via WhatsApp',
            bookAirbnb: 'Pesan via AirBNB',
            availDesc: 'Tanyakan ketersediaan tanggal dan paket event spesifik Anda langsung kepada tim kami.',
            // Dining
            diningTitle: 'Restaurant',
            diningDesc: 'Kafe taman keluarga yang nyaman menawarkan cita rasa Nusantara otentik.',
            storyAmbience: 'Kisah Kami & Suasana',
            storyDesc: 'Takato Coffee & Kitchen adalah kafe taman ramah keluarga yang menawarkan suasana tenang dan menu unik yang terinspirasi oleh cita rasa masakan Indonesia yang kaya. Kafe ini dicetuskan dari kecintaan terhadap makanan enak dan keinginan untuk berbagi hidangan Nusantara terbaik.',
            signatureMenu: 'Menu Unggulan',
            reserveTable: 'Pesan Meja',
            // Contact & Footer
            locationTitle: 'Lokasi',
            opHours: 'Jam Operasional: Senin - Minggu, 09:00 – 21:00',
            chatSupport: 'Chat dengan dukungan kami',
            moreInfo: 'Butuh informasi lebih lanjut?',
            copy: 'Hak Cipta © 2024 Takato.id. Semua Hak Dilindungi.',

            // FAQ Titles - Using existing content for simplicity
            faqQ1: 'Apa perbedaan antara Takato House dan Takato Coffee & Kitchen?',
            faqA1: 'The <strong>Takato House</strong> adalah vila mewah pribadi yang digunakan untuk menginap eksklusif, pertemuan besar, dan acara (seperti pernikahan/retreat). <strong>Takato Coffee & Kitchen</strong> adalah kafe taman dan restoran yang terbuka untuk umum di properti yang sama, berfokus pada kuliner otentik Nusantara.',
            faqQ2: 'Bagaimana cara memeriksa ketersediaan untuk pemesanan seluruh Takato House?',
            faqA2: 'Silakan periksa bagian <strong>Residence</strong> untuk detail atau, untuk respons tercepat, kami sarankan bertanya langsung melalui WhatsApp. Ini memastikan Anda mendapatkan ketersediaan terbaru untuk kebutuhan acara Anda.',
            faqQ3: 'Apakah Anda menyediakan layanan katering untuk acara di luar lokasi?',
            faqA3: 'Saat ini, layanan <strong>TAKATO Catering</strong> terutama berfokus pada dukungan acara dan menginap yang diadakan di Takato House dan Restoran. Silakan hubungi kami untuk konsultasi mengenai kebutuhan katering spesifik di luar lokasi kami.',
            faqQ4: 'Berapa kapasitas maksimum untuk acara pribadi di Takato House?',
            faqA4: '<strong>Takato House</strong> dapat menampung hingga <strong>50 tamu menginap</strong> dengan nyaman menggunakan 11 kamarnya. Untuk acara berdiri atau duduk yang lebih besar (misalnya, pernikahan), kapasitas venue meluas hingga <strong>300 orang</strong> menggunakan taman yang luas dan area outdoor.',
            faqQ5: 'Apakah Takato Coffee & Kitchen terbuka untuk umum?',
            faqA5: 'Ya, <strong>Takato Coffee & Kitchen</strong> adalah restoran dan kafe taman yang buka setiap hari untuk umum, menyajikan masakan Nusantara otentik. Area makan beroperasi secara terpisah dari penyewaan vila pribadi Takato House.',
            faqQ6: 'Apakah kolam renang pribadi dapat diakses selama jam operasional restoran?',
            faqA6: 'Tidak. Kolam renang pribadi adalah bagian dari fasilitas <strong>Takato House</strong> dan secara ketat dicadangkan untuk tamu yang telah memesan menginap vila eksklusif atau paket acara. Kolam renang tidak terbuka untuk pengunjung restoran.',
            faqQ7: 'Bisakah kami membawa katering luar sendiri untuk acara?',
            faqA7: 'Kami mendorong tamu untuk menggunakan layanan <strong>TAKATO Catering</strong> kami yang berperingkat tinggi. Namun, untuk acara skala besar tertentu, katering eksternal dapat diizinkan dengan biaya tambahan. Mohon diskusikan ini selama pertanyaan pemesanan awal Anda.',
            faqQ8: 'Apakah tersedia tempat parkir yang cukup untuk tamu acara?',
            faqA8: 'Ya, <strong>Takato House</strong> dan kompleks di sekitarnya menyediakan <strong>tempat parkir khusus yang luas</strong> yang mampu menampung banyak kendaraan untuk tamu yang menginap maupun peserta acara.',
            faqQ9: 'Berapa jarak tempuh dari Bogor atau Jakarta?',
            faqA9: 'Kami berlokasi strategis di Jalan Raya Puncak, Ciawi, menawarkan akses mudah. Waktu tempuh biasanya sekitar <strong>30-45 menit dari Bogor</strong> dan sekitar <strong>1.5-2 jam dari Jakarta</strong>, tergantung kondisi lalu lintas.',
            faqQ10: 'Bisakah Takato Coffee & Kitchen menyelenggarakan acara makan malam pribadi kecil?',
            faqA10: 'Ya, restoran kami menawarkan beberapa area semi-pribadi yang sempurna untuk pesta ulang tahun, arisan, atau makan malam perusahaan yang intim (hingga <strong>30 orang</strong>). Silakan hubungi kami untuk memesan bagian dari kafe taman kami.',
        },
        en: {
            // General
            home: 'Home',
            villa: 'Villa',
            dining: 'Restaurant',
            event: 'Event',
            faq: 'FAQ',
            contact: 'Contact',
            // Experience Dropdown
            wedding: 'Wedding',
            retreat: 'Corporate Retreat',
            gathering: 'Family Gathering',
            // Hero
            heroTitle1: 'A Luxury Space',
            heroTitle2: 'for Every Story',
            exploreHouse: 'Explore Villa',
            visitResto: 'Visit Restaurant',
            // Home Cards
            houseTitle: 'Takato House',
            houseDesc: 'A versatile villa venue for weddings, gatherings, and retreats.',
            restoTitle: 'Takato Coffee & Kitchen',
            restoDesc: 'A cozy family garden cafe with traditional Indonesian dishes.',
            viewMore: 'View More',
            viewMenu: 'View Menu',
            ourStoryTitle: 'Our Story',
            ourStoryDesc: 'Takato Coffee & Kitchen was conceived out of a love for good food and a desire to share the best of Nusantara cuisine in a welcoming, garden setting.',
            // Experience
            expTitle: 'Event',
            expSubtitle: 'Curated',
            expDesc: 'Host your most cherished moments in our magnificent venue.',
            weddingTitle: 'Wedding',
            weddingDesc: 'A magical and elegant setting for your unforgettable wedding ceremony and reception. Capacity up to 300 pax.',
            retreatTitle: 'Corporate Retreat',
            retreatDesc: 'Ideal for team building, product launches, and high-level corporate gatherings.',
            gatheringTitle: 'Family Gathering',
            gatheringDesc: 'Spacious, comfortable private villa for large family events and reunions.',
            seePackages: 'See Packages',
            getQuote: 'Get Quotation',
            bookStay: 'Book Your Stay',
            cateringTitle: 'TAKATO Catering Services',
            cateringDesc: 'Ensure your event is perfect with our in-house catering, offering bespoke menus from authentic Nusantara cuisine to international delights. Available for all events held at Takato House.',
            inquireCatering: 'Inquire Catering Package',
            // Residence
            residenceTitle: 'Villa',
            residenceDesc: 'A versatile and elegant private villa space for stay and events.',
            areaDesign: 'Area & 3D Design Overview',
            landArea: 'Land Area',
            buildingArea: 'Building Area',
            landDesc: 'Detailed plan of the total 5,600 m² land area encompassing the garden, private pool, and outdoor areas.',
            buildingDesc: '3D visualization of the 1,000 m² building, including 11 bedrooms, living spaces, and indoor facilities.',
            designQuote: 'Detailed 3D design visualizations are available to provide an immersive preview of the full potential and luxury of Takato House.',
            facilities: 'Key Facilities',
            bedrooms: 'Bedrooms (Capacity 50+)',
            kitchens: 'Complete Kitchens',
            pool: 'Private Swimming Pool',
            bbq: 'BBQ & Gazebo Area',
            hall: 'Indoor Badminton/Hall',
            parking: 'Large Parking Lot',
            reservations: 'Reservations (TAKATO House)',
            inquireAvail: 'Book via WhatsApp',
            bookAirbnb: 'Book via AirBNB',
            availDesc: 'Ask our team directly about specific dates and event packages.',
            // Dining
            diningTitle: 'Coffee & Kitchen',
            diningDesc: 'A cozy family garden cafe offering authentic Nusantara flavors.',
            storyAmbience: 'Our Story & Ambience',
            storyDesc: 'Takato Coffee & Kitchen is a family-friendly garden cafe offering a serene atmosphere and a unique menu inspired by the rich flavors of Indonesian cuisine. The cafe was conceived out of a love for good food and a desire to share the best of Nusantara cuisine.',
            signatureMenu: 'Signature Menu',
            reserveTable: 'Reserve a Table',
            // Contact & Footer
            locationTitle: 'Location',
            opHours: 'Operating Hours: Monday - Sunday, 9:00 AM – 9:00 PM',
            chatSupport: 'Chat with our support',
            moreInfo: 'Need more information?',
            copy: '© 2024 Takato.id. All Rights Reserved.',

            // FAQ Titles - Using existing content for simplicity
            faqQ1: 'What is the difference between Takato House and Takato Coffee & Kitchen?',
            faqA1: 'The <strong>Takato House</strong> is the private luxury villa used for exclusive stays, large gatherings, and events (like weddings/retreats). The <strong>Takato Coffee & Kitchen</strong> is a public-facing garden cafe and restaurant on the same property, focusing on authentic Nusantara dining.',
            faqQ2: 'How can I check the availability for booking the entire Takato House?',
            faqA2: 'Please check the <strong>Residence</strong> section for details or, for the fastest response, we recommend inquiring directly via WhatsApp. This ensures you get the most up-to-date availability for your event needs.',
            faqQ3: 'Do you provide catering service for outside events?',
            faqA3: 'Currently, the <strong>TAKATO Catering</strong> service is primarily focused on supporting events and stays held at the Takato House and Restaurant. Please contact us for a consultation regarding specific catering needs outside of our premises.',
            faqQ4: 'What is the maximum capacity for private events at Takato House?',
            faqA4: 'The <strong>Takato House</strong> can comfortably accommodate up to <strong>50 overnight guests</strong> using its 11 bedrooms. For larger standing or seating events (e.g., weddings), the venue capacity extends up to <strong>300 pax</strong> utilizing the expansive garden and outdoor areas.',
            faqQ5: 'Is Takato Coffee & Kitchen open to the public?',
            faqA5: 'Yes, <strong>Takato Coffee & Kitchen</strong> is a restaurant and garden cafe open daily to the public, serving authentic Nusantara cuisine. The dining area operates separately from the private Takato House villa rental.',
            faqQ6: 'Is the private pool accessible during restaurant operating hours?',
            faqA6: 'No. The private swimming pool is part of the <strong>Takato House</strong> facilities and is strictly reserved for guests who have booked the exclusive villa stay or event package. It is not open to restaurant patrons.',
            faqQ7: 'Can we bring our own outside catering for events at Takato House?',
            faqA7: 'We encourage guests to utilize our highly-rated <strong>TAKATO Catering</strong> services. However, for certain large-scale events, external catering may be permitted with an additional corkage fee. Please discuss this during your initial booking inquiry.',
            faqQ8: 'Is there sufficient parking space for event guests?',
            faqA8: 'Yes, <strong>Takato House</strong> and the surrounding complex provide a <strong>large dedicated parking lot</strong> capable of accommodating many vehicles for both staying guests and event attendees.',
            faqQ9: 'What is the travel distance from Bogor or Jakarta?',
            faqA9: 'We are conveniently located on Jalan Raya Puncak, Ciawi, offering easy access. Travel time is typically around <strong>30-45 minutes from Bogor</strong> and approximately <strong>1.5-2 hours from Jakarta</strong>, depending on traffic conditions.',
            faqQ10: 'Can Takato Coffee & Kitchen host small private dining events?',
            faqA10: 'Yes, our restaurant offers several semi-private areas perfect for birthday parties, arisan, or intimate corporate dinners (up to <strong>30 pax</strong>). Please contact us to reserve a section of our garden cafe.',
        }
    },
    t(key) {
        return this.translations[this.lang][key] || key;
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
    @scroll.window="isScrolled = (window.scrollY > 50)">

    <nav id="fixed-nav"
        class="fixed top-0 left-0 w-full z-50 flex justify-center items-center py-4 md:py-5 px-4 md:px-10 transition-all duration-300"
        :class="{ 'bg-white/25 backdrop-blur-md shadow-md': isScrolled, 'bg-transparent': !isScrolled }">
        <div class="w-full flex flex-row justify-between items-center max-w-7xl">
            <a href="#home"
                class="text-xl md:text-2xl font-extrabold font-serif text-[var(--color-black-contrast)] tracking-wider">Takato.id</a>
            <div class="hidden md:flex gap-8 items-center" role="navigation">
                <a href="#home" class="nav-link-elegant active" x-text="t('home')">Home</a>
                <a href="#residence" class="nav-link-elegant" x-text="t('villa')">Villa</a>
                <a href="#dining" class="nav-link-elegant" x-text="t('dining')">Coffee & Kitchen</a>

                <div class="relative" x-data="{ dropdownOpen: false }" @mouseenter="dropdownOpen = true"
                    @mouseleave="dropdownOpen = false">
                    <a href="#experience" class="nav-link-elegant flex items-center gap-1"
                        :class="{ 'active': $el.classList.contains('active') }" x-text="t('event')">
                        Event <i class="fas fa-chevron-down text-xs ml-1 transition-transform"
                            :class="{ 'rotate-180': dropdownOpen }"></i>
                    </a>
                    <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-3 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 origin-top-right"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a href="#experience"
                                class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50 transition"
                                x-text="t('wedding')">Wedding</a>
                            <a href="#experience"
                                class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50 transition"
                                x-text="t('retreat')">Corporate Retreat</a>
                            <a href="#experience"
                                class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50 transition"
                                x-text="t('gathering')">Family Gathering</a>
                        </div>
                    </div>
                </div>

                <a href="#faq" class="nav-link-elegant" x-text="t('faq')">FAQ</a>
                <a href="#contact" class="nav-link-elegant" x-text="t('contact')">Contact</a>

                <div class="ml-4 flex items-center text-sm font-semibold border border-gray-300 rounded-full p-0.5">
                    <button @click="setLang('id')"
                        :class="{ 'bg-[var(--color-primary-accent)] text-white': lang === 'id', 'text-[var(--color-primary-dark)]': lang !== 'id' }"
                        class="px-3 py-1 rounded-full transition-colors duration-200">IN</button>
                    <button @click="setLang('en')"
                        :class="{ 'bg-[var(--color-primary-accent)] text-white': lang === 'en', 'text-[var(--color-primary-dark)]': lang !== 'en' }"
                        class="px-3 py-1 rounded-full transition-colors duration-200">EN</button>
                </div>
            </div>
            <button class="md:hidden text-[var(--color-primary-dark)] text-xl" id="mobile-menu-btn"
                @click="$event.target.closest('body').querySelector('div[x-data]').__x.$data.open = true">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <div x-data="{ open: false }" class="md:hidden">
        <div x-show="open"
            class="fixed inset-0 z-[60] bg-[var(--color-light-bg)]/95 backdrop-blur-lg transform transition-transform ease-in-out duration-300"
            :class="{ 'translate-x-0': open, 'translate-x-full': !open }" style="display: none;">
            <div class="p-6 flex flex-col h-full">
                <div class="flex justify-between items-center mb-10">
                    <div class="text-2xl font-extrabold font-serif text-[var(--color-primary-dark)] tracking-wider">
                        Takato.id</div>
                    <button @click="open = false" class="text-[var(--color-primary-dark)] text-3xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex flex-col gap-6 text-xl font-semibold">
                    <a @click="open = false" href="#home"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition"
                        x-text="t('home')">Home</a>
                    <a @click="open = false" href="#residence"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition"
                        x-text="t('villa')">Villa</a>
                    <a @click="open = false" href="#dining"
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
                            <a @click="open = false; subOpen = false" href="#experience"
                                class="block py-1 hover:text-[var(--color-secondary-accent)]"
                                x-text="t('wedding')">Wedding</a>
                            <a @click="open = false; subOpen = false" href="#experience"
                                class="block py-1 hover:text-[var(--color-secondary-accent)]"
                                x-text="t('retreat')">Corporate Retreat</a>
                            <a @click="open = false; subOpen = false" href="#experience"
                                class="block py-1 hover:text-[var(--color-secondary-accent)]"
                                x-text="t('gathering')">Family Gathering</a>
                        </div>
                    </div>
                    <a @click="open = false" href="#faq"
                        class="py-3 border-b border-gray-200 hover:text-[var(--color-primary-accent)] transition"
                        x-text="t('faq')">FAQ</a>
                    <a @click="open = false" href="#contact"
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

    <section id="home" class="relative min-h-[90vh] flex flex-col justify-start pt-0 overflow-hidden">
        <div class="relative w-full overflow-hidden">
            <div class="w-full h-0 pb-[60%] hero-aspect-ratio relative">
                <div class="image-container absolute inset-0">
                    <img src="/1aab8845-00c7-46bd-92bb-767d70b7c128.avif"
                        alt="Luxury villa exterior with a large swimming pool and tropical greenery, suitable for a Takato House exterior view."
                        loading="lazy" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 bg-black/35">
                <div class="max-w-4xl mx-auto">
                    <h1
                        class="font-serif text-4xl sm:text-6xl md:text-7xl font-bold text-white mb-6 md:mb-8 leading-tight hero-title-mobile">
                        <span x-text="t('heroTitle1')">A Luxury Space</span> <br class="hidden sm:block" /> <span
                            x-text="t('heroTitle2')">for Every
                            Story</span>
                    </h1>

                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center items-center">
                        <a href="#residence"
                            class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-3.5 btn-warm rounded-md font-semibold text-sm md:text-lg shadow-luxury"
                            x-text="t('exploreHouse')">
                            Explore Takato House
                        </a>
                        <a href="#dining"
                            class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-3.5 btn-light-subtle rounded-md font-semibold text-sm md:text-lg shadow-luxury"
                            x-text="t('visitResto')">
                            Visit Takato Coffee & Kitchen
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-10 md:py-16">
            <div class="grid md:grid-cols-3 gap-6 md:gap-8 items-stretch">

                <a href="#residence"
                    class="md:col-span-2 card-elegant rounded-xl shadow-luxury group overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-[1.01]">
                    <div class="relative h-64 md:h-80 w-full overflow-hidden">
                        <img src="/img1.jpg" alt="Luxury villa exterior view with pool" loading="lazy"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                    </div>

                    <div class="p-6 md:p-8 space-y-4">
                        <div class="flex items-center space-x-3 text-[var(--color-secondary-accent)]">
                            <i class="fas fa-home text-2xl"></i>
                            <h2 class="font-serif text-3xl font-bold text-[var(--color-primary-dark)]"
                                x-text="t('houseTitle')">Takato House</h2>
                        </div>
                        <p class="text-base text-gray-700" x-text="t('houseDesc')">
                            A versatile villa venue for weddings, gatherings, and retreats.
                        </p>
                        <span
                            class="inline-flex items-center font-semibold text-sm md:text-base text-[var(--color-primary-accent)] group-hover:underline transition">
                            <span x-text="t('viewMore')">View More</span>
                            <i
                                class="fas fa-arrow-right text-xs ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </a>

                <a href="#dining"
                    class="md:col-span-1 card-elegant rounded-xl shadow-luxury group overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-[1.01] bg-[var(--color-primary-accent)]/10">
                    <div
                        class="relative h-64 md:h-80 w-full overflow-hidden border-b-4 border-[var(--color-secondary-accent)]">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Cozy garden cafe seating area" loading="lazy"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                    </div>

                    <div class="p-6 md:p-8 space-y-4">
                        <div class="flex items-center space-x-3 text-[var(--color-secondary-accent)]">
                            <i class="fas fa-utensils text-2xl"></i>
                            <h3 class="font-serif text-2xl font-bold text-[var(--color-primary-dark)]"
                                x-text="t('restoTitle')">Takato Coffee & Kitchen</h3>
                        </div>
                        <p class="text-base text-gray-700" x-text="t('restoDesc')">
                            A cozy family garden cafe with traditional Indonesian dishes.
                        </p>
                        <span
                            class="inline-flex items-center font-semibold text-sm md:text-base text-[var(--color-primary-accent)] group-hover:underline transition">
                            <span x-text="t('viewMenu')">View Menu</span>
                            <i
                                class="fas fa-arrow-right text-xs ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </a>
            </div>

            <div class="mt-12 md:mt-16 card-elegant p-6 md:p-8 rounded-xl shadow-luxury">
                <div class="flex items-center justify-center space-x-4 mb-4">
                    <i class="fas fa-seedling text-2xl text-[var(--color-secondary-accent)]"></i>
                    <h3 class="font-serif text-2xl md:text-3xl font-bold text-[var(--color-primary-dark)]"
                        x-text="t('ourStoryTitle')">Kisah Kami</h3>
                    <i class="fas fa-seedling text-2xl text-[var(--color-secondary-accent)]"></i>
                </div>
                <p class="text-base md:text-lg text-gray-700 max-w-4xl mx-auto text-center"
                    x-text="t('ourStoryDesc')">
                    Takato Coffee & Kitchen was conceived out of a love for good food and a desire
                    to share the best of Nusantara cuisine in a welcoming, garden setting.
                </p>
            </div>
        </div>
    </section>

    <section id="photos" class="py-10 md:py-20 mobile-py-10 bg-[var(--color-light-bg)]">
        <div class="w-full">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[var(--color-primary-dark)]">
                    Galeri <span class="gradient-text">Foto</span>
                </h2>
                <p class="text-base md:text-xl text-gray-600 mt-4 max-w-4xl mx-auto">
                    Jelajahi keindahan dan suasana Takato House dalam bidikan terbaik.
                </p>
            </div>

            <div class="swiper mySwiper w-full mx-auto">
                <div class="swiper-wrapper h-[300px] md:h-[400px]">
                    <div class="swiper-slide overflow-hidden">
                        <img src="/img1.jpg" alt="Interior living room with wooden accents" loading="lazy">
                    </div>
                    <div class="swiper-slide overflow-hidden">
                        <img src="/img2.jpg" alt="Private outdoor swimming pool area" loading="lazy">
                    </div>
                    <div class="swiper-slide overflow-hidden">
                        <img src="/img3.jpg" alt="Elegant dining setting for an event" loading="lazy">
                    </div>
                    <div class="swiper-slide overflow-hidden">
                        <img src="/img4.jpg" alt="Spacious bedroom with natural light" loading="lazy">
                    </div>
                    <div class="swiper-slide overflow-hidden">
                        <img src="/img5.jpg" alt="Beautiful garden cafe and seating area" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="swiper-pagination mt-4 max-w-7xl mx-auto px-4 md:px-6"></div>
        </div>
    </section>

    <section id="experience" class="py-10 md:py-20 mobile-py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[var(--color-primary-dark)]">
                    <span x-text="t('expSubtitle')">Kurasi</span> <span class="gradient-text"
                        x-text="t('event')">Experiences</span>
                </h2>
                <p class="text-base md:text-xl text-gray-600 mt-4 max-w-4xl mx-auto" x-text="t('expDesc')">
                    Selenggarakan momen paling berharga Anda di venue megah kami.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 md:gap-8">

                <a href="/events/wedding"
                    class="card-elegant rounded-xl shadow-luxury space-y-4 cursor-pointer group block" @click.stop>
                    <div class="h-48 w-full overflow-hidden rounded-t-xl">
                        <img src="/wedding.jpg" alt="Wedding event setup at Takato" loading="lazy"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-6 md:p-8 space-y-4">
                        <h3 class="font-serif text-xl md:text-2xl font-bold mb-3 text-[var(--color-primary-dark)]"
                            x-text="t('wedding')">Wedding</h3>
                        <p class="text-sm md:text-base text-gray-700 mb-4" x-text="t('weddingDesc')">
                            A magical and elegant setting for your unforgettable wedding ceremony and reception.
                        </p>
                        <span
                            class="text-xs md:text-sm text-[var(--color-primary-accent)] font-semibold hover:underline"
                            x-text="t('seePackages')">
                            See Packages <i class="fas fa-arrow-right text-xs ml-1"></i>
                        </span>
                    </div>
                </a>

                <a href="/events/retreat"
                    class="card-elegant rounded-xl shadow-luxury space-y-4 cursor-pointer group block" @click.stop>
                    <div class="h-48 w-full overflow-hidden rounded-t-xl">
                        <img src="https://cdn.prod.website-files.com/61eb3f79cfe8dd4bf6350818/63ff7b38bcf6a055318acdfd_PACE-EmmaCrystalWorkshop-2-scaled.webp"
                            alt="Corporate retreat setup" loading="lazy"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-6 md:p-8 space-y-4">
                        <h3 class="font-serif text-xl md:text-2xl font-bold mb-3 text-[var(--color-primary-dark)]"
                            x-text="t('retreat')">Corporate Retreat</h3>
                        <p class="text-sm md:text-base text-gray-700 mb-4" x-text="t('retreatDesc')">
                            Ideal for team building, product launches, and high-level corporate gatherings.
                        </p>
                        <span
                            class="text-xs md:text-sm text-[var(--color-primary-accent)] font-semibold hover:underline"
                            x-text="t('getQuote')">
                            Get Quotation <i class="fas fa-arrow-right text-xs ml-1"></i>
                        </span>
                    </div>
                </a>

                <a href="/events/gathering"
                    class="card-elegant rounded-xl shadow-luxury space-y-4 cursor-pointer group block" @click.stop>
                    <div class="h-48 w-full overflow-hidden rounded-t-xl">
                        <img src="https://images.stockcake.com/public/8/5/7/8570134f-7780-4b73-a459-59c5257e2615_large/family-dinner-gathering-stockcake.jpg"
                            alt="Family dinner gathering" loading="lazy"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-6 md:p-8 space-y-4">
                        <h3 class="font-serif text-xl md:text-2xl font-bold mb-3 text-[var(--color-primary-dark)]"
                            x-text="t('gathering')">Family Gathering</h3>
                        <p class="text-sm md:text-base text-gray-700 mb-4" x-text="t('gatheringDesc')">
                            Spacious, comfortable private villa for large family events and reunions.
                        </p>
                        <span
                            class="text-xs md:text-sm text-[var(--color-primary-accent)] font-semibold hover:underline"
                            x-text="t('bookStay')">
                            Book Your Stay <i class="fas fa-arrow-right text-xs ml-1"></i>
                        </span>
                    </div>
                </a>
            </div>

            <div
                class="mt-10 md:mt-16 card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-l-4 border-[var(--color-secondary-accent)]">
                <h3
                    class="font-serif text-2xl md:text-3xl font-bold mb-4 flex items-center gap-3 text-[var(--color-primary-dark)]">
                    <i class="fas fa-utensils text-[var(--color-primary-accent)]"></i> <span
                        x-text="t('cateringTitle')">TAKATO Catering Services</span>
                </h3>
                <p class="text-base md:text-lg text-gray-700 max-w-4xl" x-text="t('cateringDesc')">
                    Ensure your event is perfect with our in-house catering, offering bespoke menus from
                    authentic
                    Nusantara cuisine to international delights. Available for all events held at Takato
                    House.
                </p>
                <a href="https://wa.me/+6281214831823" target="_blank"
                    class="inline-block mt-4 px-6 py-3 btn-warm rounded-md font-semibold text-sm md:text-base"
                    x-text="t('inquireCatering')">
                    Inquire Catering Package
                </a>
            </div>
        </div>
    </section>

    <section id="residence" class="py-10 md:py-20 mobile-py-10 bg-[var(--color-primary-dark)]">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[var(--color-light-bg)]">
                    TAKATO <span class="gradient-text" x-text="t('villa')">Residence</span>
                </h2>
                <p class="text-base md:text-xl text-white mt-4 max-w-4xl mx-auto" x-text="t('residenceDesc')">
                    A versatile and elegant private villa space for stay and events.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 md:gap-12 items-stretch">

                <div class="lg:col-span-2 space-y-6 md:space-y-8">
                    <h3 class="font-serif text-2xl md:text-3xl font-bold text-[var(--color-light-bg)] mb-4"
                        x-text="t('areaDesign')">Area & 3D Design Overview</h3>

                    <div class="grid md:grid-cols-2 gap-6 md:gap-8">

                        <div class="card-elegant p-6 rounded-xl shadow-luxury">
                            <p class="text-base uppercase text-[var(--color-light-bg)] font-semibold mb-2"
                                x-text="t('landArea') + ' (5,600 m²)'">Land Area (5,600 m²)</p>
                            <div
                                class="w-full h-48 md:h-64 rounded-lg overflow-hidden border-2 border-[var(--color-light-bg)]">
                                <img src="https://masterpiece.co.id/wp-content/uploads/2023/12/Denah-Lantai-Bawah.webp"
                                    alt="3D Design Rendering of Land Area" class="w-full h-full object-cover"
                                    loading="lazy">
                            </div>
                            <p class="text-xs md:text-sm text-gray-600 mt-3" x-text="t('landDesc')">
                                Rencana mendetail dari total 5,600 m² lahan yang mencakup taman, kolam
                                renang privat,
                                dan area outdoor.
                            </p>
                        </div>

                        <div class="card-elegant p-6 rounded-xl shadow-luxury">
                            <p class="text-base uppercase text-[var(--color-primary-dark)] font-semibold mb-2"
                                x-text="t('buildingArea') + ' (1,000 m²)'">Building Area (1,000 m²)</p>
                            <div
                                class="w-full h-48 md:h-64 rounded-lg overflow-hidden border-2 border-[var(--color-light-bg)]">
                                <img src="https://mir-s3-cdn-cf.behance.net/projects/404/b9ebab176956077.Y3JvcCwyNjAxLDIwMzQsMCwyNjM.jpg"
                                    alt="3D Design Rendering of Building Area" class="w-full h-full object-cover"
                                    loading="lazy">
                            </div>
                            <p class="text-xs md:text-sm text-gray-600 mt-3" x-text="t('buildingDesc')">
                                Visualisasi 3D dari 1,000 m² bangunan, termasuk 11 kamar tidur, ruang
                                keluarga, dan
                                fasilitas dalam ruangan.
                            </p>
                        </div>

                    </div>

                    <blockquote
                        class="border-l-4 border-[var(--color-light-bg)] pl-4 py-2 text-base md:text-lg italic text-white"
                        x-text="t('designQuote')">
                        "Visualisasi desain 3D rinci telah tersedia untuk menyajikan gambaran imersif
                        mengenai potensi
                        penuh dan kemewahan ruang Takato House."
                    </blockquote>
                </div>

                <div class="lg:col-span-1 space-y-8 md:space-y-10">

                    <div class="card-elegant p-6 md:p-8 rounded-xl shadow-luxury h-fit">
                        <h3 class="font-serif text-2xl md:text-3xl font-bold mb-4 text-[var(--color-primary-dark)]"
                            x-text="t('facilities')">Key Facilities</h3>
                        <ul class="space-y-3 md:space-y-4 text-sm md:text-lg">
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-bed text-[var(--color-primary-accent)]"></i> <span
                                    x-text="t('bedrooms')">11 Bedrooms (Capacity 50+)</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-utensils text-[var(--color-primary-accent)]"></i> <span
                                    x-text="t('kitchens')">2 Complete Kitchens</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-swimming-pool text-[var(--color-primary-accent)]"></i>
                                <span x-text="t('pool')">Private Swimming Pool</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-fire text-[var(--color-primary-accent)]"></i> <span
                                    x-text="t('bbq')">BBQ & Gazebo Area</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-table-tennis text-[var(--color-primary-accent)]"></i>
                                <span x-text="t('hall')">Indoor Badminton/Hall</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <i class="fas fa-caravan text-[var(--color-primary-accent)]"></i> <span
                                    x-text="t('parking')">Large Parking Lot</span>
                            </li>
                        </ul>
                    </div>

                    <div
                        class="card-elegant p-6 md:p-8 rounded-xl shadow-luxury h-fit border-l-4 border-[var(--color-secondary-accent)]">
                        <h3 class="font-serif text-xl font-bold mb-4 text-[var(--color-primary-dark)]"
                            x-text="t('reservations')">Reservations (TAKATO House)</h3>
                        <p class="text-sm md:text-base text-gray-700 mb-4" x-text="t('availDesc')">
                            Tanyakan ketersediaan tanggal dan paket event spesifik Anda langsung kepada tim
                            kami.
                        </p>
                        <a href="https://www.airbnb.co.id/rooms/31336206?guests=1&adults=1&s=67&unique_share_id=8a460253-0073-4a62-a778-8c25c2f589f4"
                            target="_blank"
                            class="inline-flex items-center gap-2 w-full justify-center px-6 py-3 rounded-md font-semibold text-sm md:text-base mb-3
           bg-red-600 text-white hover:bg-red-700 transition duration-300 shadow-md hover:shadow-lg">
                            <i class="fab fa-airbnb ml-1 text-lg"></i>
                            <span x-text="t('bookAirbnb')">Pesan via AirBNB</span>
                        </a>
                        <a href="https://wa.me/+6281214831823" target="_blank"
                            class="inline-flex items-center gap-2 w-full justify-center px-6 py-3 rounded-md font-semibold text-sm md:text-base
           bg-green-600 text-white hover:bg-green-700 transition duration-300 shadow-md hover:shadow-lg">
                            <i class="fab fa-whatsapp text-lg"></i>
                            <span x-text="t('inquireAvail')">Pesan via WhatsApp</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="dining" class="py-10 md:py-20 bg-[var(--color-light-bg)] mobile-py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[var(--color-primary-dark)]">
                    Takato <span class="gradient-text" x-text="t('dining')">Coffee & Kitchen</span>
                </h2>
                <p class="text-base md:text-xl text-gray-600 mt-4 max-w-4xl mx-auto" x-text="t('diningDesc')">
                    A cozy family garden cafe offering authentic Nusantara flavors.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-start">

                <div class="lg:order-1 space-y-4 md:space-y-6">
                    <div
                        class="w-full h-[300px] md:h-[450px] rounded-xl shadow-luxury overflow-hidden border border-gray-200">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Cozy, brightly lit family garden cafe with wooden furniture and lush plants."
                            loading="lazy" class="w-full h-full object-cover">
                    </div>

                    <h3 class="font-serif text-2xl md:text-3xl font-bold text-[var(--color-primary-dark)] pt-4"
                        x-text="t('storyAmbience')">Our Story & Ambience
                    </h3>
                    <p class="text-sm md:text-lg text-gray-700" x-text="t('storyDesc')">
                        Takato Coffee & Kitchen is a family-friendly garden cafe offering a serene
                        atmosphere
                        and a unique menu inspired by the rich flavors of Indonesian cuisine. The cafe was
                        conceived
                        out of a love for good food and a desire to share the best of Nusantara cuisine.
                    </p>
                </div>

                <div
                    class="lg:order-2 card-elegant p-6 md:p-8 rounded-xl shadow-luxury border-l-4 border-[var(--color-secondary-accent)]">
                    <h3 class="font-serif text-2xl md:text-3xl font-bold mb-6 text-[var(--color-primary-dark)]"
                        x-text="t('signatureMenu')">Signature Menu</h3>
                    <ul class="space-y-3 md:space-y-4 text-base md:text-xl mb-6 md:mb-8">
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-drumstick-bite text-[var(--color-primary-accent)]"></i> Nasi
                            Goreng
                        </li>
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-drumstick-bite text-[var(--color-primary-accent)]"></i> Gado
                            Gado
                        </li>
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-drumstick-bite text-[var(--color-primary-accent)]"></i> Soto
                            Ayam
                        </li>
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-drumstick-bite text-[var(--color-primary-accent)]"></i> Ikan
                            Bakar
                        </li>
                        <li class="flex items-center gap-3 font-semibold text-[var(--color-primary-dark)]">
                            <i class="fas fa-coffee text-[var(--color-primary-accent)]"></i> Premium Bogor
                            Coffee
                        </li>
                    </ul>
                    <div class="w-full h-48 md:h-64 rounded-xl shadow-md overflow-hidden border border-gray-200">
                        <img src="https://www.unileverfoodsolutions.co.id/dam/global-ufs/mcos/SEA/calcmenu/recipes/ID-recipes/chicken-&-other-poultry-dishes/soto-ayam/main-header.jpg"
                            alt="A beautifully plated Indonesian Nasi Goreng with egg and fresh garnish."
                            loading="lazy" class="w-full h-full object-cover">
                    </div>
                    <a href="#contact"
                        class="inline-block mt-4 px-6 py-3 btn-light-subtle rounded-md font-semibold text-sm md:text-base"
                        x-text="t('reserveTable')">
                        Reserve a Table
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-10 md:py-20 mobile-py-10">
        <div class="max-w-xl md:max-w-4xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[var(--color-primary-dark)]">
                    <span x-text="t('faq')">FAQ</span>
                    <span class="gradient-text">/</span>
                    <span class="gradient-text text-xl sm:text-3xl"
                        x-text="lang === 'id' ? 'Pertanyaan yang Sering Diajukan' : 'Frequently Asked Questions'">
                        Frequently Asked Questions
                    </span>
                </h2>
                <p class="text-base md:text-xl text-gray-600 mt-4 max-w-4xl mx-auto">
                    Find quick answers about our Residence, Dining, and Events.
                </p>
            </div>

            <div class="space-y-4">

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ1')">What is the difference between Takato House and Takato
                            Coffee &
                            Kitchen?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA1')">
                            The <strong>Takato House</strong> is the private luxury villa used for exclusive
                            stays,
                            large gatherings,
                            and events (like weddings/retreats). The <strong>Takato Coffee &
                                Kitchen</strong> is a
                            public-facing
                            garden cafe and restaurant on the same property, focusing on authentic Nusantara
                            dining.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ2')">How can I check the availability for booking the entire
                            Takato
                            House?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA2')">
                            Please check the <strong>Residence</strong> section for details or, for the
                            fastest
                            response, we
                            recommend inquiring directly via WhatsApp. This ensures you get the most
                            up-to-date
                            availability for
                            your event needs.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ3')">Do you provide catering service for outside
                            events?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA3')">
                            Currently, the <strong>TAKATO Catering</strong> service is primarily focused on
                            supporting
                            events and
                            stays held at the TAKATO House and Restaurant. Please contact us for a
                            consultation
                            regarding specific catering needs outside of our premises.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ4')">What is the maximum capacity for private events at Takato
                            House?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA4')">
                            The <strong>Takato House</strong> can comfortably accommodate up to <strong>50
                                overnight
                                guests</strong> using its 11
                            bedrooms. For larger standing or seating events (e.g., weddings), the venue
                            capacity extends
                            up to
                            <strong>300 pax</strong> utilizing the expansive garden and outdoor areas.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ5')">Is Takato Coffee & Kitchen open to the public?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA5')">
                            Yes, <strong>Takato Coffee & Kitchen</strong> is a restaurant and garden cafe
                            open daily to
                            the public,
                            serving authentic Nusantara cuisine. The dining area operates separately from
                            the private
                            Takato House villa rental.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ6')">Is the private pool accessible during restaurant
                            operating
                            hours?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA6')">
                            No. The private swimming pool is part of the <strong>Takato House</strong>
                            facilities and is
                            strictly
                            reserved for guests who have booked the exclusive villa stay or event package.
                            It is not
                            open
                            to restaurant patrons.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ7')">Can we bring our own outside catering for events at
                            Takato
                            House?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA7')">
                            We encourage guests to utilize our highly-rated <strong>TAKATO Catering</strong>
                            services.
                            However, for
                            certain large-scale events, external catering may be permitted with an
                            additional corkage
                            fee.
                            Please discuss this during your initial booking inquiry.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ8')">Is there sufficient parking space for event
                            guests?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA8')">
                            Yes, <strong>Takato House</strong> and the surrounding complex provide a
                            <strong>large
                                dedicated parking lot</strong>
                            capable of accommodating many vehicles for both staying guests and event
                            attendees.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ9')">What is the travel distance from Bogor or Jakarta?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA9')">
                            We are conveniently located on Jalan Raya Puncak, Ciawi, offering easy access.
                            Travel time
                            is typically
                            around <strong>30-45 minutes from Bogor</strong> and approximately <strong>1.5-2
                                hours from
                                Jakarta</strong>, depending on traffic conditions.
                        </p>
                    </div>
                </div>

                <div class="card-elegant rounded-lg shadow-luxury overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-4 py-3 md:px-6 md:py-4 text-left font-semibold text-sm md:text-lg text-[var(--color-primary-dark)] hover:bg-gray-50 transition">
                        <span x-text="t('faqQ10')">Can Takato Coffee & Kitchen host small private dining
                            events?</span>
                        <i class="fas fa-chevron-down transform transition-transform text-[var(--color-primary-accent)]"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-4 pb-3 md:px-6 md:pb-4 pt-0 text-gray-700 border-t border-gray-100">
                        <p class="pt-3 text-sm md:text-base" x-html="t('faqA10')">
                            Yes, our restaurant offers several semi-private areas perfect for birthday
                            parties, arisan,
                            or intimate corporate dinners (up to <strong>30 pax</strong>). Please contact us
                            to reserve
                            a section of our garden cafe.
                        </p>
                    </div>
                </div>

            </div>

            <div class="text-center mt-8 md:mt-10">
                <p class="text-gray-600 text-sm md:text-base" x-text="t('moreInfo')">Need more information? <a
                        href="https://wa.me/+6281214831823" target="_blank"
                        class="font-bold text-[var(--color-primary-accent)] hover:text-[var(--color-primary-dark)] transition"
                        x-text="t('chatSupport')">Chat
                        with our support.</a></p>
            </div>
        </div>
    </section>

    <section id="contact" class="py-10 md:py-20 bg-[var(--color-primary-dark)] mobile-py-10 text-white">
        <div class="max-w-xl md:max-w-4xl mx-auto px-4 md:px-6">
            <div class="text-center mb-8 md:mb-10">
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white">
                    <span x-text="t('contact')">Contact</span> & <span class="gradient-text"
                        x-text="t('locationTitle')">Location</span>
                </h2>
            </div>

            <div class="space-y-6 md:space-y-8">
                <div class="space-y-4">
                    <div class="h-64 md:h-80 rounded-xl overflow-hidden shadow-luxury border border-gray-200">
                        <iframe
                            src="https://maps.google.com/maps?q=Jalan%20Raya%20Puncak,%20Blok%20Bendungan,%20Ciawi,%20Cijeruk,%20Bogor&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="card-elegant p-4 md:p-6 rounded-xl shadow-luxury space-y-2 md:space-y-3">
                        <p class="text-base md:text-xl font-serif font-bold text-[var(--color-primary-dark)]">
                            Jalan Raya Puncak, Blok Bendungan, Ciawi, Cijeruk, Bogor, Jawa Barat 16740
                        </p>
                        <p class="text-sm md:text-lg text-gray-700" x-text="t('opHours')">
                            Operating Hours: Monday - Sunday, 9:00 AM – 9:00 PM
                        </p>
                    </div>
                </div>

                <div class="card-elegant p-4 md:p-6 rounded-xl shadow-luxury">
                    <div class="flex justify-center mb-4 md:mb-6">
                        <a href="https://wa.me/+6281214831823" target="_blank"
                            class="w-full sm:w-2/3 md:w-1/2 px-8 py-3.5 rounded-md font-semibold text-sm md:text-lg flex items-center justify-center gap-2 hover:shadow-lg
                                bg-green-600 text-white hover:bg-green-700 transition duration-300">
                            <i class="fab fa-whatsapp"></i> <span x-text="t('chatSupport')">Chat with
                                us</span>
                        </a>
                    </div>
                </div>
            </div>
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
                            <a class="tracking-widest font-secondary text-gradient" href="/">
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
                            <li><a href="/" class="text-white transition-colors hover:text-accent">**Takato
                                    Catering**</a></li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="mb-4 text-sm font-normal">
                            <a class="tracking-widest font-secondary text-gradient" href="#">
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
            class="group w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-xl shadow-green-500/50 hover:scale-110 transition-all duration-300">
            <i class="fab fa-whatsapp text-2xl md:text-3xl text-white group-hover:scale-110 transition-transform"></i>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Navigation Active State & Mobile Menu Logic (Unchanged) ---
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link-elegant');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', (event) => {
                    const alpineDataElement = document.querySelector('body > div[x-data]:not(#fixed-nav)');
                    if (alpineDataElement && alpineDataElement.__x && alpineDataElement.__x.$data) {
                        alpineDataElement.__x.$data.open = true;
                    }
                    event.stopPropagation();
                });
            }

            document.querySelectorAll('.md\\:hidden nav a').forEach(link => {
                link.addEventListener('click', () => {
                    const alpineDataElement = document.querySelector(
                        'body > div[x-data]:not(#fixed-nav)');
                    if (alpineDataElement && alpineDataElement.__x && alpineDataElement.__x.$data) {
                        alpineDataElement.__x.$data.open = false;
                    }
                });
            });


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

            // --- Swiper Initialization ---
            const swiper = new Swiper(".mySwiper", {
                slidesPerView: 1,
                // PERUBAHAN 2: Mengubah spaceBetween dari 30 menjadi 0
                spaceBetween: 0,
                loop: true,
                autoplay: {
                    delay: 1000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        // PERUBAHAN 2: Mengubah spaceBetween dari 20 menjadi 0
                        spaceBetween: 0,
                    },
                    1024: {
                        slidesPerView: 3,
                        // PERUBAHAN 2: Mengubah spaceBetween dari 30 menjadi 0
                        spaceBetween: 0,
                    },
                }
            });
        });
    </script>
</body>

</html>
