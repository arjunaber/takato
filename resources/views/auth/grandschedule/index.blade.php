<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villa Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --danger-color: #e74a3b;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .calendar-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.35rem 0.35rem 0 0;
        }

        .calendar-day-header {
            background-color: #f8f9fc;
            font-weight: 600;
            text-align: center;
            padding: 0.5rem;
        }

        .calendar-day {
            min-height: 120px;
            border: 1px solid #e3e6f0;
            padding: 0.5rem;
            transition: all 0.2s;
        }

        .calendar-day:hover {
            background-color: #f8f9fa;
        }

        .day-number {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .other-month {
            background-color: #f8f9fa;
            color: #b7b9cc;
        }

        .today {
            background-color: rgba(78, 115, 223, 0.1);
            position: relative;
        }

        .today:after {
            content: '';
            position: absolute;
            top: 5px;
            right: 5px;
            width: 8px;
            height: 8px;
            background-color: var(--primary-color);
            border-radius: 50%;
        }

        .booking-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
            display: inline-block;
        }

        .available {
            background-color: rgba(28, 200, 138, 0.1);
            color: var(--success-color);
        }

        .booked {
            background-color: rgba(231, 74, 59, 0.1);
            color: var(--danger-color);
        }

        .villa-card {
            transition: all 0.3s;
            cursor: pointer;
        }

        .villa-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.2);
        }

        .villa-img {
            height: 180px;
            object-fit: cover;
            border-radius: 0.35rem 0.35rem 0 0;
        }

        .modal-villa-img {
            height: 250px;
            object-fit: cover;
            border-radius: 0.35rem;
        }

        .amenity-badge {
            background-color: #f8f9fc;
            padding: 0.5rem;
            border-radius: 0.35rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-flex;
            align-items: center;
        }

        .price-display {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }

        .fc-event {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4 text-gray-800">Villa Booking System</h1>
            </div>
        </div>

        <!-- Villa Selection Cards -->
        <div class="row mb-4" id="villaSelection">
            <div class="col-md-4 mb-4">
                <div class="card villa-card" data-villa-id="1" data-bs-toggle="modal" data-bs-target="#bookingModal">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                        class="card-img-top villa-img" alt="Villa Serenity">
                    <div class="card-body">
                        <h5 class="card-title">Villa Serenity</h5>
                        <p class="card-text text-muted">Premium villa with ocean view and private pool</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">Premium</span>
                            <span class="price-display">$250/night</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card villa-card" data-villa-id="2" data-bs-toggle="modal" data-bs-target="#bookingModal">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                        class="card-img-top villa-img" alt="Villa Harmony">
                    <div class="card-body">
                        <h5 class="card-title">Villa Harmony</h5>
                        <p class="card-text text-muted">Deluxe villa with garden view and jacuzzi</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-warning text-dark">Deluxe</span>
                            <span class="price-display">$180/night</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card villa-card" data-villa-id="3" data-bs-toggle="modal" data-bs-target="#bookingModal">
                    <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                        class="card-img-top villa-img" alt="Villa Tranquility">
                    <div class="card-body">
                        <h5 class="card-title">Villa Tranquility</h5>
                        <p class="card-text text-muted">Standard villa with mountain view</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success">Standard</span>
                            <span class="price-display">$120/night</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div
                        class="card-header calendar-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-white">Booking Calendar</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-white"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="#" id="viewAll">View All Villas</a></li>
                                <li><a class="dropdown-item" href="#" id="viewAvailable">View Available Only</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Calendar Navigation -->
                        <div class="row mb-4">
                            <div class="col-md-4 mb-2">
                                <select class="form-select" id="villaFilter">
                                    <option value="all">All Villas</option>
                                    <option value="1">Villa Serenity</option>
                                    <option value="2">Villa Harmony</option>
                                    <option value="3">Villa Tranquility</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="month" class="form-control" id="monthPicker" value="">
                            </div>
                            <div class="col-md-4 mb-2 d-flex justify-content-end">
                                <button class="btn btn-primary me-2" id="prevMonth"><i
                                        class="bi bi-chevron-left"></i></button>
                                <button class="btn btn-outline-secondary me-2" id="todayBtn">Today</button>
                                <button class="btn btn-primary" id="nextMonth"><i
                                        class="bi bi-chevron-right"></i></button>
                            </div>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="bookingCalendar">
                                <thead>
                                    <tr>
                                        <th class="calendar-day-header">Sun</th>
                                        <th class="calendar-day-header">Mon</th>
                                        <th class="calendar-day-header">Tue</th>
                                        <th class="calendar-day-header">Wed</th>
                                        <th class="calendar-day-header">Thu</th>
                                        <th class="calendar-day-header">Fri</th>
                                        <th class="calendar-day-header">Sat</th>
                                    </tr>
                                </thead>
                                <tbody id="calendarBody">
                                    <!-- Calendar days will be generated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book Villa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="" id="modalVillaImage" class="modal-villa-img w-100 mb-3"
                                alt="Villa Image">
                            <h4 id="modalVillaName">Villa Name</h4>
                            <p id="modalVillaType" class="text-muted"></p>
                            <p id="modalVillaDescription"></p>

                            <div class="mb-4">
                                <h6>Amenities</h6>
                                <div id="modalVillaAmenities">
                                    <span class="amenity-badge"><i class="bi bi-wifi me-1"></i> WiFi</span>
                                    <span class="amenity-badge"><i class="bi bi-tv me-1"></i> TV</span>
                                    <span class="amenity-badge"><i class="bi bi-thermometer-snow me-1"></i> AC</span>
                                    <span class="amenity-badge"><i class="bi bi-cup-hot me-1"></i> Kitchen</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="nav nav-pills mb-3" id="bookingTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="check-availability-tab" data-bs-toggle="pill"
                                        data-bs-target="#check-availability" type="button" role="tab">Check
                                        Availability</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="book-now-tab" data-bs-toggle="pill"
                                        data-bs-target="#book-now" type="button" role="tab">Book Now</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="bookingTabsContent">
                                <div class="tab-pane fade show active" id="check-availability" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="availabilityDateRange" class="form-label">Select Dates</label>
                                        <input type="text" class="form-control" id="availabilityDateRange"
                                            placeholder="Select date range">
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i> Select your desired dates to check
                                        availability
                                    </div>
                                    <div id="availabilityResult" class="d-none">
                                        <div class="alert alert-success mb-3">
                                            <i class="bi bi-check-circle me-2"></i> <span
                                                id="availabilityMessage">Villa is available for your selected
                                                dates</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Total for <span id="nightsCount">0</span> nights:</span>
                                            <span class="price-display" id="totalPrice">$0</span>
                                        </div>
                                        <button class="btn btn-primary w-100" id="proceedToBook">Proceed to
                                            Book</button>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="book-now" role="tabpanel">
                                    <form id="bookingForm">
                                        <div class="mb-3">
                                            <label for="bookingDateRange" class="form-label">Booking Dates</label>
                                            <input type="text" class="form-control" id="bookingDateRange"
                                                readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="guestName" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="guestName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="guestEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="guestEmail" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="guestPhone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" id="guestPhone" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="specialRequests" class="form-label">Special Requests</label>
                                            <textarea class="form-control" id="specialRequests" rows="3"></textarea>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Total Amount:</span>
                                            <span class="price-display" id="finalPrice">$0</span>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Confirm Booking</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="mb-3">Booking Confirmed!</h4>
                    <p class="mb-4">Your villa booking has been successfully confirmed. A confirmation has been sent
                        to your email.</p>
                    <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Mock data for villas
        const villas = {
            1: {
                name: "Villa Serenity",
                type: "Premium",
                description: "Luxurious villa with breathtaking ocean views, private infinity pool, and premium amenities for an unforgettable stay.",
                price: 250,
                image: "https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
                amenities: ["WiFi", "Private Pool", "Ocean View", "AC", "Kitchen", "Parking", "TV", "BBQ Area"]
            },
            2: {
                name: "Villa Harmony",
                type: "Deluxe",
                description: "Elegant villa surrounded by lush gardens featuring a relaxing jacuzzi and spacious living areas.",
                price: 180,
                image: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
                amenities: ["WiFi", "Jacuzzi", "Garden View", "AC", "Kitchen", "TV", "Parking"]
            },
            3: {
                name: "Villa Tranquility",
                type: "Standard",
                description: "Cozy villa with stunning mountain views, perfect for a peaceful retreat in nature.",
                price: 120,
                image: "https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
                amenities: ["WiFi", "Mountain View", "AC", "Kitchen", "TV"]
            }
        };

        // Mock data for bookings
        const bookings = [{
                villaId: 1,
                startDate: "2023-06-10",
                endDate: "2023-06-15",
                guestName: "John Doe"
            },
            {
                villaId: 2,
                startDate: "2023-06-20",
                endDate: "2023-06-25",
                guestName: "Jane Smith"
            },
            {
                villaId: 1,
                startDate: "2023-06-28",
                endDate: "2023-07-02",
                guestName: "Bob Johnson"
            },
            {
                villaId: 3,
                startDate: "2023-06-05",
                endDate: "2023-06-08",
                guestName: "Alice Williams"
            }
        ];

        // Current date and selected villa
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        let selectedVillaId = null;
        let selectedDates = [];

        // DOM elements
        const monthPicker = document.getElementById('monthPicker');
        const villaFilter = document.getElementById('villaFilter');
        const calendarBody = document.getElementById('calendarBody');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const todayBtn = document.getElementById('todayBtn');
        const viewAllBtn = document.getElementById('viewAll');
        const viewAvailableBtn = document.getElementById('viewAvailable');
        const bookingModal = document.getElementById('bookingModal');
        const modalVillaName = document.getElementById('modalVillaName');
        const modalVillaType = document.getElementById('modalVillaType');
        const modalVillaDescription = document.getElementById('modalVillaDescription');
        const modalVillaImage = document.getElementById('modalVillaImage');
        const modalVillaAmenities = document.getElementById('modalVillaAmenities');
        const availabilityDateRange = document.getElementById('availabilityDateRange');
        const availabilityResult = document.getElementById('availabilityResult');
        const availabilityMessage = document.getElementById('availabilityMessage');
        const nightsCount = document.getElementById('nightsCount');
        const totalPrice = document.getElementById('totalPrice');
        const proceedToBook = document.getElementById('proceedToBook');
        const bookingDateRange = document.getElementById('bookingDateRange');
        const finalPrice = document.getElementById('finalPrice');
        const bookingForm = document.getElementById('bookingForm');
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));

        // Initialize the calendar
        function initCalendar() {
            // Set current month in the month input
            const currentMonthFormatted = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}`;
            monthPicker.value = currentMonthFormatted;

            // Generate calendar
            generateCalendar();
        }

        // Generate calendar days
        function generateCalendar() {
            // Clear previous calendar days
            calendarBody.innerHTML = '';

            // Get first day of month and last day of month
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);

            // Get days from previous month to show
            const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
            const firstDayOfWeek = firstDay.getDay(); // 0 = Sunday, 6 = Saturday

            // Get days from next month to show
            const totalDays = lastDay.getDate();
            const lastDayOfWeek = lastDay.getDay();

            // Get selected villa filter
            const selectedVilla = villaFilter.value;

            // Calculate total weeks to show (6 weeks to cover all cases)
            let dayCount = 1;
            let nextMonthDay = 1;
            let calendarHTML = '';

            for (let week = 0; week < 6; week++) {
                calendarHTML += '<tr>';

                for (let day = 0; day < 7; day++) {
                    let dayObj = {};
                    let isCurrentMonth = false;
                    let isToday = false;
                    let dateStr = '';

                    // Previous month
                    if (week === 0 && day < firstDayOfWeek) {
                        const prevMonth = currentMonth === 0 ? 11 : currentMonth - 1;
                        const prevYear = currentMonth === 0 ? currentYear - 1 : currentYear;
                        const dayNum = prevMonthLastDay - firstDayOfWeek + day + 1;

                        dateStr =
                        `${prevYear}-${String(prevMonth + 1).padStart(2, '0')}-${String(dayNum).padStart(2, '0')}`;
                        dayObj = {
                            day: dayNum,
                            isCurrentMonth: false,
                            isToday: false,
                            date: dateStr
                        };
                    }
                    // Current month
                    else if (dayCount <= totalDays) {
                        dateStr =
                            `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(dayCount).padStart(2, '0')}`;

                        // Check if today
                        const today = new Date();
                        isToday = currentYear === today.getFullYear() &&
                            currentMonth === today.getMonth() &&
                            dayCount === today.getDate();

                        dayObj = {
                            day: dayCount,
                            isCurrentMonth: true,
                            isToday: isToday,
                            date: dateStr
                        };
                        dayCount++;
                    }
                    // Next month
                    else {
                        const nextMonth = currentMonth === 11 ? 0 : currentMonth + 1;
                        const nextYear = currentMonth === 11 ? currentYear + 1 : currentYear;

                        dateStr =
                            `${nextYear}-${String(nextMonth + 1).padStart(2, '0')}-${String(nextMonthDay).padStart(2, '0')}`;
                        dayObj = {
                            day: nextMonthDay,
                            isCurrentMonth: false,
                            isToday: false,
                            date: dateStr
                        };
                        nextMonthDay++;
                    }

                    // Check bookings for this day
                    const bookingsForDay = bookings.filter(booking => {
                        const bookingStart = new Date(booking.startDate);
                        const bookingEnd = new Date(booking.endDate);
                        const currentDate = new Date(dateStr);

                        // Filter by villa if selected
                        const villaMatch = selectedVilla === 'all' || booking.villaId == selectedVilla;

                        return villaMatch && currentDate >= bookingStart && currentDate <= bookingEnd;
                    });

                    // Generate day HTML
                    let dayHTML =
                        `<td class="calendar-day ${!dayObj.isCurrentMonth ? 'other-month' : ''} ${dayObj.isToday ? 'today' : ''}" data-date="${dayObj.date}">`;
                    dayHTML += `<div class="day-number">${dayObj.day}</div>`;

                    // Show bookings for this day
                    if (dayObj.isCurrentMonth) {
                        if (bookingsForDay.length > 0) {
                            bookingsForDay.forEach(booking => {
                                const villa = villas[booking.villaId];
                                dayHTML += `<div class="booking-badge booked" data-bs-toggle="tooltip" title="Booked: ${villa.name} (${booking.guestName})">
                                    <i class="bi bi-lock-fill me-1"></i> ${villa.name}
                                </div>`;
                            });
                        } else {
                            dayHTML += `<div class="booking-badge available">
                                <i class="bi bi-check-circle-fill me-1"></i> Available
                            </div>`;
                        }
                    }

                    dayHTML += '</td>';
                    calendarHTML += dayHTML;
                }

                calendarHTML += '</tr>';

                // Stop if we've shown all days of the month
                if (dayCount > totalDays && nextMonthDay > 7) {
                    break;
                }
            }

            calendarBody.innerHTML = calendarHTML;

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Update month picker value
        function updateMonthPicker() {
            monthPicker.value = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}`;
        }

        // Initialize date range picker for availability check
        function initDateRangePicker() {
            flatpickr(availabilityDateRange, {
                mode: "range",
                minDate: "today",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        checkAvailability(selectedDates);
                    } else {
                        availabilityResult.classList.add('d-none');
                    }
                }
            });
        }

        // Check villa availability for selected dates
        function checkAvailability(dates) {
            selectedDates = dates;
            const startDate = dates[0];
            const endDate = dates[1];

            // Calculate nights
            const nights = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
            nightsCount.textContent = nights;

            // Calculate total price
            const villa = villas[selectedVillaId];
            const total = villa.price * nights;
            totalPrice.textContent = `$${total}`;

            // Check if dates are available
            const isAvailable = isVillaAvailable(selectedVillaId, startDate, endDate);

            if (isAvailable) {
                availabilityMessage.textContent = `${villa.name} is available for your selected dates`;
                availabilityResult.classList.remove('d-none');
            } else {
                availabilityMessage.textContent = `${villa.name} is not available for the selected dates`;
                availabilityResult.classList.remove('d-none');
                proceedToBook.disabled = true;
            }
        }

        // Check if villa is available for given dates
        function isVillaAvailable(villaId, startDate, endDate) {
            for (const booking of bookings) {
                if (booking.villaId == villaId) {
                    const bookingStart = new Date(booking.startDate);
                    const bookingEnd = new Date(booking.endDate);

                    // Check for overlap
                    if ((startDate >= bookingStart && startDate <= bookingEnd) ||
                        (endDate >= bookingStart && endDate <= bookingEnd) ||
                        (startDate <= bookingStart && endDate >= bookingEnd)) {
                        return false;
                    }
                }
            }
            return true;
        }

        // Setup modal with villa details
        function setupModal(villaId) {
            selectedVillaId = villaId;
            const villa = villas[villaId];

            modalVillaName.textContent = villa.name;
            modalVillaType.textContent = villa.type;
            modalVillaDescription.textContent = villa.description;
            modalVillaImage.src = villa.image;
            modalVillaImage.alt = villa.name;

            // Clear previous amenities
            modalVillaAmenities.innerHTML = '';

            // Add amenities
            villa.amenities.forEach(amenity => {
                let icon = 'bi-check-circle';
                switch (amenity) {
                    case 'WiFi':
                        icon = 'bi-wifi';
                        break;
                    case 'TV':
                        icon = 'bi-tv';
                        break;
                    case 'AC':
                        icon = 'bi-thermometer-snow';
                        break;
                    case 'Kitchen':
                        icon = 'bi-cup-hot';
                        break;
                    case 'Parking':
                        icon = 'bi-p-circle';
                        break;
                    case 'Private Pool':
                        icon = 'bi-water';
                        break;
                    case 'Jacuzzi':
                        icon = 'bi-water';
                        break;
                    case 'Ocean View':
                        icon = 'bi-brightness-high';
                        break;
                    case 'Garden View':
                        icon = 'bi-flower2';
                        break;
                    case 'Mountain View':
                        icon = 'bi-mountain';
                        break;
                    case 'BBQ Area':
                        icon = 'bi-fire';
                        break;
                }

                const amenityEl = document.createElement('span');
                amenityEl.className = 'amenity-badge';
                amenityEl.innerHTML = `<i class="bi ${icon} me-1"></i> ${amenity}`;
                modalVillaAmenities.appendChild(amenityEl);
            });

            // Reset availability tab
            availabilityDateRange._flatpickr.clear();
            availabilityResult.classList.add('d-none');

            // Activate first tab
            const firstTab = new bootstrap.Tab(document.querySelector('#check-availability-tab'));
            firstTab.show();
        }

        // Event listeners
        prevMonthBtn.addEventListener('click', function() {
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }

            updateMonthPicker();
            generateCalendar();
        });

        nextMonthBtn.addEventListener('click', function() {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }

            updateMonthPicker();
            generateCalendar();
        });

        todayBtn.addEventListener('click', function() {
            const today = new Date();
            currentMonth = today.getMonth();
            currentYear = today.getFullYear();

            updateMonthPicker();
            generateCalendar();
        });

        villaFilter.addEventListener('change', function() {
            generateCalendar();
        });

        viewAllBtn.addEventListener('click', function() {
            villaFilter.value = 'all';
            generateCalendar();
        });

        viewAvailableBtn.addEventListener('click', function() {
            // This would need more complex logic to show only days with availability
            // For now just filter to show all villas
            villaFilter.value = 'all';
            generateCalendar();
        });

        // Handle villa card clicks to open modal
        document.querySelectorAll('.villa-card').forEach(card => {
            card.addEventListener('click', function() {
                const villaId = this.getAttribute('data-villa-id');
                setupModal(villaId);
            });
        });

        // Handle proceed to book button
        proceedToBook.addEventListener('click', function() {
            // Switch to booking tab
            const bookTab = new bootstrap.Tab(document.querySelector('#book-now-tab'));
            bookTab.show();

            // Set booking dates
            const startDate = selectedDates[0].toISOString().split('T')[0];
            const endDate = selectedDates[1].toISOString().split('T')[0];
            bookingDateRange.value = `${startDate} to ${endDate}`;

            // Set final price
            finalPrice.textContent = totalPrice.textContent;
        });

        // Handle form submission
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // In a real app, you would send this data to your backend
            const bookingData = {
                villaId: selectedVillaId,
                villaName: modalVillaName.textContent,
                startDate: selectedDates[0].toISOString().split('T')[0],
                endDate: selectedDates[1].toISOString().split('T')[0],
                guestName: document.getElementById('guestName').value,
                guestEmail: document.getElementById('guestEmail').value,
                guestPhone: document.getElementById('guestPhone').value,
                specialRequests: document.getElementById('specialRequests').value,
                totalPrice: finalPrice.textContent
            };

            console.log('Booking data:', bookingData);

            // Close booking modal
            const modal = bootstrap.Modal.getInstance(bookingModal);
            modal.hide();

            // Show success modal
            successModal.show();

            // Reset form
            this.reset();
        });

        // Initialize the calendar when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initCalendar();
            initDateRangePicker();

            // Set current month in month picker
            const today = new Date();
            monthPicker.value = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}`;
        });
    </script>
</body>

</html>
