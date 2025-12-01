<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking & Availability - Takato.id</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        :root {
            --color-primary-dark: #3D4F42;
            --color-primary-accent: #A8956F;
            --color-secondary-accent: #887B57;
            --color-tertiary-accent: #B8B097;
            --color-light-bg: #EAEAE4;
            --color-white-contrast: #ffffff;

            /* Warna Status Kalender */
            --cal-available: #ecfdf5;
            --cal-booked: #ef4444;
            --cal-event: #EAB308;
            --cal-selected: #A8956F;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-light-bg);
            color: var(--color-primary-dark);
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .btn-warm {
            background-color: var(--color-secondary-accent);
            color: white;
            transition: all 0.3s;
        }

        .btn-warm:hover {
            background-color: var(--color-primary-accent);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(136, 123, 87, 0.4);
        }

        /* Calendar Styles */
        #booking-calendar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            font-family: 'Inter', sans-serif;
        }

        .fc-toolbar-title {
            font-family: 'Playfair Display', serif !important;
            color: var(--color-primary-dark);
        }

        .fc-button-primary {
            background-color: var(--color-primary-dark) !important;
            border-color: var(--color-primary-dark) !important;
        }

        .fc-daygrid-day {
            background-color: var(--cal-available) !important;
            transition: background-color 0.2s;
        }

        .fc-day-today {
            background-color: rgba(168, 149, 111, 0.2) !important;
        }

        /* Status Colors */
        .bg-booked {
            background-color: var(--cal-booked) !important;
            opacity: 0.7;
            border: none;
            color: white;
        }

        .bg-event {
            background-color: var(--cal-event) !important;
            opacity: 0.8;
            border: none;
            color: white;
        }

        .bg-selected {
            background-color: var(--cal-selected) !important;
            border-color: var(--cal-selected) !important;
        }

        .nav-link-elegant {
            color: var(--color-primary-dark);
            font-weight: 600;
            transition: color 0.3s;
        }

        .nav-link-elegant:hover {
            color: var(--color-secondary-accent);
        }

        /* Scrollbar untuk breakdown list */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }
    </style>
</head>

<body x-data="bookingApp()">

    <nav
        class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm py-4 px-6 md:px-16 flex justify-between items-center">
        <a href="/"
            class="text-2xl font-extrabold font-serif tracking-wider text-[var(--color-primary-dark)]">Takato.id</a>
        <div class="hidden md:flex gap-8">
            <a href="/" class="nav-link-elegant">Home</a>
            <a href="/#residence" class="nav-link-elegant">Villa</a>
            <a href="/#experience" class="nav-link-elegant">Experience</a>
            <a href="/booking"
                class="nav-link-elegant text-[var(--color-secondary-accent)] border-b-2 border-[var(--color-secondary-accent)]">Book
                Now</a>
        </div>
    </nav>

    <header class="pt-32 pb-10 px-6 text-center bg-[var(--color-primary-dark)] text-white">
        <h1 class="font-serif text-4xl md:text-6xl font-bold mb-4">Check Availability</h1>
        <p class="text-lg text-[var(--color-tertiary-accent)]">Select dates to see pricing or check event details.</p>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-6 py-12">
        <div class="grid lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2">
                <div id="booking-calendar"></div>

                <div class="mt-6 flex flex-wrap gap-6 text-sm justify-center md:justify-start">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded border border-gray-200"
                            style="background-color: var(--cal-available);"></div>
                        <span class="text-gray-600 font-medium">Available</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded opacity-70" style="background-color: var(--cal-booked);"></div>
                        <span class="text-gray-600 font-medium">Booked</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded opacity-80" style="background-color: var(--cal-event);"></div>
                        <span class="text-gray-600 font-medium">Event / Special</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded" style="background-color: var(--cal-selected);"></div>
                        <span class="text-gray-600 font-medium">Your Selection</span>
                    </div>
                </div>

                <div
                    class="mt-4 p-3 bg-blue-50 text-blue-800 text-sm rounded-lg border border-blue-100 flex items-start gap-2">
                    <i class="fas fa-info-circle mt-0.5"></i>
                    <span><strong>Tip:</strong> Tanggal berwarna Emas (Event) mungkin memiliki harga khusus. Klik
                        tanggal untuk info.</span>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div
                    class="bg-white p-6 rounded-xl shadow-lg border border-[var(--color-tertiary-accent)] sticky top-32">
                    <h3 class="font-serif text-2xl font-bold mb-6 text-[var(--color-primary-dark)]">Reservation Details
                    </h3>

                    <div x-show="clickedStatusInfo" x-transition
                        class="mb-6 p-4 bg-yellow-50 border border-yellow-100 rounded-lg">
                        <h4 class="font-bold text-yellow-800 mb-1" x-text="clickedStatusTitle"></h4>
                        <p class="text-sm text-yellow-700" x-text="clickedStatusDesc"></p>
                    </div>

                    <div class="mb-6 space-y-3">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Check-in</label>
                            <div class="text-lg font-medium p-3 bg-gray-50 rounded border border-gray-200"
                                x-text="startDate || '-'"></div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Check-out</label>
                            <div class="text-lg font-medium p-3 bg-gray-50 rounded border border-gray-200"
                                x-text="endDate || '-'"></div>
                        </div>
                    </div>

                    <hr class="border-gray-200 my-4">

                    <div x-show="priceDetails.length > 0" x-transition>
                        <p class="text-xs font-bold uppercase text-gray-500 mb-2">Price Breakdown</p>

                        <div class="max-h-60 overflow-y-auto custom-scrollbar pr-2 space-y-2 mb-4">
                            <template x-for="detail in priceDetails" :key="detail.raw_date">
                                <div
                                    class="flex justify-between items-center text-sm p-2 bg-gray-50 rounded border border-gray-100">
                                    <div>
                                        <div class="font-medium text-gray-700" x-text="detail.date"></div>
                                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full mt-1"
                                            :class="{
                                                'bg-green-100 text-green-700': detail.color === 'green',
                                                'bg-orange-100 text-orange-700': detail.color === 'orange',
                                                'bg-yellow-100 text-yellow-800': detail.color === 'gold'
                                            }"
                                            x-text="detail.label">
                                        </span>
                                    </div>
                                    <div class="font-semibold text-[var(--color-primary-dark)]"
                                        x-text="'Rp ' + detail.formatted"></div>
                                </div>
                            </template>
                        </div>

                        <div
                            class="flex justify-between text-xl font-bold text-[var(--color-primary-dark)] border-t border-gray-200 pt-4 mt-2">
                            <span>Total Estimate</span>
                            <span x-text="'Rp ' + formatPrice(totalPrice)"></span>
                        </div>
                        <p class="text-xs text-gray-400 italic mt-1 text-right">Durasi: <span x-text="dayCount"></span>
                            Malam</p>
                    </div>

                    <div x-show="totalPrice === 0 && !clickedStatusInfo"
                        class="text-center py-8 text-gray-400 italic bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        Select dates on calendar to see full details & pricing.
                    </div>

                    <div class="space-y-3 mt-6">
                        <a :href="whatsappLink" target="_blank"
                            :class="{ 'opacity-50 pointer-events-none': totalPrice === 0 }"
                            class="btn-warm w-full py-4 rounded-lg font-bold flex items-center justify-center gap-2">
                            <i class="fab fa-whatsapp text-xl"></i> Book via WhatsApp
                        </a>

                        <a href="https://www.airbnb.co.id/rooms/31336206?guests=1&adults=1&s=67&unique_share_id=8a460253-0073-4a62-a778-8c25c2f589f4"
                            target="_blank"
                            class="block w-full py-4 rounded-lg font-bold text-center border-2 border-[var(--color-primary-dark)] text-[var(--color-primary-dark)] hover:bg-[var(--color-primary-dark)] hover:text-white transition">
                            <i class="fab fa-airbnb text-xl mr-2"></i> Book via Airbnb
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-black text-white py-12 text-center mt-12">
        <p class="mb-2 font-serif text-xl">Takato House</p>
        <p class="text-sm text-gray-400">© 2025 Takato.id. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('bookingApp', () => ({
                startDate: null,
                endDate: null,
                dayCount: 0,
                totalPrice: 0,
                selectedDates: [],
                priceDetails: [], // Menyimpan detail per hari dari server

                clickedStatusInfo: false,
                clickedStatusTitle: '',
                clickedStatusDesc: '',

                init() {
                    this.initCalendar();
                },

                formatPrice(value) {
                    return new Intl.NumberFormat('id-ID').format(value);
                },

                formatDateLocal(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                },

                // Membuat link WA dengan rincian
                get whatsappLink() {
                    if (!this.startDate)
                return 'https://wa.me/6281214831823'; // Default link jika belum pilih tanggal

                    const text =
                        `Halo Admin Takato, saya ingin reservasi:\n\nCheck-in: ${this.startDate}\nCheck-out: ${this.endDate}\nDurasi: ${this.dayCount} Malam\n\nTotal Estimasi: Rp ${this.formatPrice(this.totalPrice)}\n\nMohon info ketersediaan.`;

                    // Nomor diperbarui ke 6281214831823
                    return `https://wa.me/6281214831823?text=${encodeURIComponent(text)}`;
                },

                clearInfo() {
                    this.clickedStatusInfo = false;
                    this.clickedStatusTitle = '';
                    this.clickedStatusDesc = '';
                },

                async calculate() {
                    this.clearInfo();

                    if (this.selectedDates.length === 0) {
                        this.totalPrice = 0;
                        this.priceDetails = [];
                        return;
                    }

                    try {
                        const response = await fetch('/api/calculate-price', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                dates: this.selectedDates
                            })
                        });

                        const data = await response.json();
                        if (response.ok) {
                            this.totalPrice = data.total;
                            this.dayCount = this.selectedDates.length;
                            this.priceDetails = data.details; // Simpan detail dari controller
                        } else {
                            this.showStatusInfo('Selection Error', data.error);
                            this.resetSelection();
                        }
                    } catch (e) {
                        console.error(e);
                    }
                },

                resetSelection() {
                    this.startDate = null;
                    this.endDate = null;
                    this.selectedDates = [];
                    this.totalPrice = 0;
                    this.dayCount = 0;
                    this.priceDetails = [];
                    if (window.calendar) window.calendar.unselect();
                },

                showStatusInfo(title, desc) {
                    this.clickedStatusInfo = true;
                    this.clickedStatusTitle = title;
                    this.clickedStatusDesc = desc;
                    this.resetSelection();
                },

                initCalendar() {
                    var calendarEl = document.getElementById('booking-calendar');
                    window.calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        selectable: true,
                        selectMirror: false,
                        unselectAuto: false,
                        timeZone: 'local',
                        headerToolbar: {
                            left: 'prev',
                            center: 'title',
                            right: 'next'
                        },
                        events: '/api/calendar-data',

                        // Hanya block tanggal Booked
                        selectOverlap: function(event) {
                            return event.display === 'background' && event.extendedProps
                                .status !== 'booked';
                        },

                        eventClick: (info) => {
                            const props = info.event.extendedProps;

                            if (props.status === 'booked') {
                                this.showStatusInfo('Date Unavailable',
                                    'This date is already booked.');
                            } else if (props.is_event) {
                                // Hanya info, tidak reset selection (user masih bisa select jika mau bayar harga event)
                                this.clickedStatusInfo = true;
                                this.clickedStatusTitle = 'Special Event Date';
                                this.clickedStatusDesc =
                                    `Note: ${props.notes || 'High Season'}. Special pricing applies.`;
                            }
                        },

                        select: (info) => {
                            const start = new Date(info.start);
                            const end = new Date(info.end);
                            this.selectedDates = [];
                            let current = new Date(start);

                            while (current < end) {
                                this.selectedDates.push(this.formatDateLocal(current));
                                current.setDate(current.getDate() + 1);
                            }

                            this.startDate = this.selectedDates[0];
                            let lastDay = new Date(end);
                            lastDay.setDate(lastDay.getDate() - 1);
                            this.endDate = this.formatDateLocal(lastDay);

                            this.calculate();
                        }
                    });
                    window.calendar.render();
                }
            }));
        });
    </script>
</body>

</html>
