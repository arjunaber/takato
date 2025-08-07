<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villa Booking - Rumah Idaman Bogor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 420px;
            /* Ukuran lebih kecil */
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .input-group {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 6px 10px;
            background: #f9f9f9;
        }

        .input-group i {
            margin-right: 8px;
            color: #666;
        }

        .form-input,
        .form-select {
            width: 100%;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
        }

        .price-summary {
            margin-top: 20px;
            font-size: 14px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .price-total {
            font-weight: bold;
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .btn-book {
            background-color: #007bff;
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            margin-top: 15px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-book:hover {
            background-color: #0056b3;
        }

        .btn-primary {
            margin-top: 15px;
            background-color: #ccc;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
        }


        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        /* Error State Styles */
        .error-input {
            border-color: var(--error) !important;
        }

        .error-message {
            color: var(--error);
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }

        :root {
            --primary: #7367F0;
            --primary-dark: #5E50EE;
            --secondary: #ffffff;
            --accent: #F8F8F8;
            --text: #6E6B7B;
            --text-light: #B9B9C3;
            --border: #EBE9F1;
            --success: #28C76F;
            --error: #EA5455;
            --warning: #FF9F43;
            --info: #00CFE8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text);
            background-color: var(--secondary);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header Styles */
        header {
            background-color: var(--secondary);
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
        }

        .logo i {
            margin-right: 10px;
            color: var(--primary);
        }

        .nav {
            display: flex;
            align-items: center;
        }

        .nav a {
            margin-left: 25px;
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }

        .nav a:hover {
            color: var(--primary);
        }

        .nav .btn-login {
            background-color: var(--primary);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            margin-left: 20px;
            font-weight: 500;
            box-shadow: 0 4px 8px rgba(115, 103, 240, 0.4);
            transition: all 0.3s;
        }

        .nav .btn-login:hover {
            background-color: var(--primary-dark);
            color: white;
            box-shadow: 0 8px 16px rgba(115, 103, 240, 0.4);
            transform: translateY(-2px);
        }

        /* Property Header */
        .property-header {
            margin: 30px 0 20px;
        }

        .property-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #5E5873;
            font-weight: 700;
        }

        .property-header .location {
            display: flex;
            align-items: center;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .property-header .location i {
            margin-right: 8px;
        }

        .property-header .rating {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .property-header .rating-stars {
            color: var(--warning);
            margin-right: 10px;
        }

        .property-header .rating-number {
            background-color: var(--primary);
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            margin-right: 10px;
        }

        .property-header .rating-text {
            color: var(--text-light);
            font-size: 14px;
        }

        /* Card Styles */
        .card {
            background-color: var(--secondary);
            border-radius: 8px;
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid var(--border);
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #5E5873;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }

        /* FullCalendar Custom Styles */
        .fc {
            font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
        }

        .fc-header-toolbar {
            margin-bottom: 1em;
        }

        .fc-toolbar-title {
            color: var(--text);
            font-weight: 600;
        }

        .fc-button {
            background-color: var(--secondary);
            border: 1px solid var(--border);
            color: var(--text);
            font-weight: 500;
            text-transform: capitalize;
            padding: 8px 15px;
            transition: all 0.3s;
        }

        .fc-button:hover {
            background-color: var(--accent);
            color: var(--text);
        }

        .fc-button-active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .fc-daygrid-day {
            background-color: white;
        }

        .fc-daygrid-day.fc-day-today {
            background-color: rgba(115, 103, 240, 0.1);
        }

        .fc-daygrid-day-top {
            justify-content: center;
        }

        .fc-daygrid-day-number {
            padding: 5px;
            margin: 5px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .fc-daygrid-day:hover .fc-daygrid-day-number {
            background-color: var(--primary);
            color: white;
        }

        .fc-daygrid-day.fc-day-selected .fc-daygrid-day-number {
            background-color: var(--primary);
            color: white;
        }

        .fc-daygrid-event {
            cursor: pointer;
            font-weight: 500;
            border: none;
            font-size: 12px;
            padding: 2px 4px;
        }

        .fc-event-available {
            background-color: var(--success);
            color: white;
        }

        .fc-event-booked {
            background-color: var(--error);
            color: white;
        }

        .fc-event-peak {
            background-color: var(--warning);
            color: white;
        }

        /* Status Legend */
        .status-legend {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            margin-right: 5px;
            border-radius: 3px;
        }

        /* Property Details */
        .booking-container {
            display: flex;
            margin-top: 30px;
            gap: 30px;
        }

        .property-details {
            flex: 2;
        }

        .section-title {
            font-size: 22px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
            color: #5E5873;
            font-weight: 600;
        }

        .property-description {
            margin-bottom: 25px;
            line-height: 1.7;
            color: var(--text);
        }

        .amenities-section {
            margin-bottom: 30px;
        }

        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 15px;
            margin: 20px 0;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            color: var(--text);
        }

        .amenity-item i {
            margin-right: 10px;
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        .amenity-category {
            margin-bottom: 15px;
            font-weight: 600;
            color: #5E5873;
            display: flex;
            align-items: center;
        }

        .amenity-category i {
            margin-right: 10px;
            color: var(--primary);
        }

        /* Location Card */
        .location-card {
            margin-bottom: 30px;
        }

        .location-card .card-title {
            display: flex;
            align-items: center;
        }

        .location-card .card-title i {
            margin-right: 10px;
            color: var(--primary);
        }

        .location-map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 15px;
            border: 1px solid var(--border);
        }

        .location-map iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .location-address {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px;
            background-color: var(--accent);
            border-radius: 8px;
        }

        .location-address i {
            margin-right: 10px;
            color: var(--primary);
        }

        .btn-directions {
            background-color: var(--primary);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-directions i {
            margin-right: 8px;
        }

        .btn-directions:hover {
            background-color: var(--primary-dark);
            box-shadow: 0 4px 8px rgba(115, 103, 240, 0.4);
            transform: translateY(-2px);
        }

        /* Booking Form */
        .booking-form {
            flex: 1;
            background-color: var(--secondary);
            border-radius: 8px;
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
            padding: 25px;
            position: sticky;
            top: 100px;
            height: fit-content;
            border: 1px solid var(--border);
        }

        .price-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .price {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
        }

        .price span {
            font-size: 16px;
            font-weight: normal;
            color: var(--text-light);
        }

        .price-per-night {
            font-size: 14px;
            color: var(--text-light);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #5E5873;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            z-index: 2;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
            background-color: var(--secondary);
            color: var(--text);
            position: relative;
            z-index: 1;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 3px 10px rgba(115, 103, 240, 0.1);
        }

        .btn-book {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(115, 103, 240, 0.4);
        }

        .btn-book i {
            margin-right: 8px;
        }

        .btn-book:hover {
            background-color: var(--primary-dark);
            box-shadow: 0 8px 16px rgba(115, 103, 240, 0.4);
            transform: translateY(-2px);
        }

        .price-summary {
            margin-top: 25px;
            border-top: 1px solid var(--border);
            padding-top: 15px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: var(--text);
        }

        .price-total {
            font-weight: 600;
            color: #5E5873;
            border-top: 1px solid var(--border);
            padding-top: 10px;
            margin-top: 10px;
        }

        .info-text {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 15px;
            text-align: center;
        }

        /* Grand Schedule Card */
        .schedule-card {
            margin-bottom: 30px;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedule-table th,
        .schedule-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .schedule-table th {
            background-color: var(--accent);
            font-weight: 600;
            color: #5E5873;
        }

        .schedule-table tr:hover {
            background-color: rgba(115, 103, 240, 0.05);
        }

        .price-high {
            color: var(--error);
            font-weight: 500;
        }

        .price-medium {
            color: var(--warning);
            font-weight: 500;
        }

        .price-low {
            color: var(--success);
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .booking-container {
                flex-direction: column;
            }

            .property-gallery {
                height: 350px;
            }

            .booking-form {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .amenities-grid {
                grid-template-columns: 1fr;
            }

            .property-gallery {
                grid-template-columns: 1fr;
                height: auto;
            }

            .main-image {
                height: 250px;
                grid-row: auto;
            }

            .secondary-image {
                height: 120px;
            }

            .nav a:not(.btn-login) {
                display: none;
            }

            .schedule-table {
                display: block;
                overflow-x: auto;
            }
        }

        /* Enhanced Calendar Event Styles */
        .fc-event {
            padding: 2px 4px;
            margin: 1px;
            font-size: 0.85em;
            cursor: pointer;
            border-radius: 4px;
            border: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 40px;
        }

        .fc-event-main {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .fc-event-price {
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 0.9em;
        }

        .fc-event-status {
            font-size: 0.7em;
            padding: 2px 5px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.2);
            display: inline-block;
            margin-top: 2px;
        }

        /* Color coding for different statuses */
        .fc-event-available {
            background-color: #28C76F;
            color: white;
        }

        .fc-event-booked {
            background-color: #EA5455;
            color: white;
        }

        .fc-event-peak {
            background-color: #FF9F43;
            color: white;
        }

        /* Make calendar cells taller to accommodate the event content */
        .fc-daygrid-day-frame {
            min-height: 60px;
        }

        /* Adjust the day number position */
        .fc-daygrid-day-top {
            justify-content: center;
            padding-top: 4px;
        }

        /* Status Legend */
        .status-legend {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            background: #F8F8F8;
            padding: 5px 10px;
            border-radius: 20px;
            border: 1px solid #EBE9F1;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            margin-right: 8px;
            border-radius: 3px;
        }

        /* Layout Styles */
        .calendar-container {
            padding: 20px;
        }

        .calendar-layout {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .calendar-column {
            flex: 3;
            min-width: 0;
            /* Prevent overflow */
        }

        .booking-column {
            flex: 1;
            min-width: 300px;
            /* Prevent form from getting too narrow */
        }

        /* Calendar Styles */
        #calendar {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 15px;
        }

        /* Booking Form Styles */
        .booking-form {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            position: sticky;
            top: 20px;
        }

        .price-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .price {
            font-size: 24px;
            font-weight: bold;
        }

        .price span {
            font-size: 16px;
            font-weight: normal;
            color: #666;
        }

        .price-per-night {
            color: #666;
            font-size: 14px;
        }

        .rating-stars {
            color: #FFD700;
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .input-group {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
        }

        .input-group i {
            margin-right: 10px;
            color: #666;
        }

        .form-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 16px;
        }

        .form-select {
            width: 100%;
            border: none;
            outline: none;
            font-size: 16px;
            background: transparent;
        }

        .btn-book {
            width: 100%;
            background: #28C76F;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin: 20px 0;
            transition: background 0.3s;
        }

        .btn-book:hover {
            background: #22a85c;
        }

        .btn-book i {
            margin-right: 8px;
        }

        .price-summary {
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .price-total {
            font-weight: bold;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .info-text {
            font-size: 14px;
            color: #666;
            margin-top: 15px;
        }

        .info-text i {
            margin-right: 5px;
        }

        /* Status Legend */
        .status-legend {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .calendar-layout {
                flex-direction: column;
            }

            .calendar-column,
            .booking-column {
                flex: none;
                width: 100%;
            }
        }

        .nav a.active {
            color: black;
            /* Anda bisa menambahkan properti lain untuk menonjolkan active page */
            font-weight: bold;
            text-decoration: underline;
        }

        #bookingModal.modal {
            align-items: flex-start;
            /* Mengubah dari center ke flex-start */
            padding-top: 15px;
            padding-bottom: 15px;
            /* Menambahkan padding di bagian atas */
        }

        .modal-content {
            margin-top: 15px;
            margin-bottom: 15px;
            /* Menambahkan margin top untuk konten modal */
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="text-2xl font-bold text-primary">TAKATO</div>
            <div class="nav">
                <a href="/landing" class="active">Home</a>
                <a href="/landing#facilities" class="active">Facilites</a>
            </div>
        </div>
    </header>
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <h3 id="modalTitle"></h3>
            <div id="modalMessage"></div>
            <div id="modalForm" style="display: none;">

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" class="form-input" placeholder="Alamat email Anda"
                            required>
                    </div>
                    <div class="error-message" id="emailError"></div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="tel" id="phone" class="form-input" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="error-message" id="phoneError"></div>
                </div>

                <!-- Check-in -->
                <div class="form-group">
                    <label class="form-label">Check-in</label>
                    <div class="input-group">
                        <i class="fas fa-calendar-day"></i>
                        <input type="text" id="checkin-date" class="form-input" placeholder="Pilih tanggal check-in"
                            required>
                    </div>
                    <div class="error-message" id="checkinError"></div>
                </div>

                <!-- Check-out -->
                <div class="form-group">
                    <label class="form-label">Check-out</label>
                    <div class="input-group">
                        <i class="fas fa-calendar-day"></i>
                        <input type="text" id="checkout-date" class="form-input"
                            placeholder="Pilih tanggal check-out" required>
                    </div>
                    <div class="error-message" id="checkoutError"></div>
                </div>

                <!-- Guests -->
                <div class="form-group">
                    <label class="form-label">Jumlah Tamu</label>
                    <div class="input-group">
                        <i class="fas fa-users"></i>
                        <select id="guests" class="form-select">
                            <option value="1">1 Tamu</option>
                            <option value="2">2 Tamu</option>
                            <option value="3">3 Tamu</option>
                            <option value="4">4 Tamu</option>
                            <option value="5">5 Tamu</option>
                            <option value="6">6 Tamu</option>
                            <option value="7">7 Tamu</option>
                            <option value="8">8 Tamu</option>
                            <option value="9">9 Tamu</option>
                            <option value="10">10 Tamu</option>
                            <option value="11">11–15 Tamu</option>
                            <option value="16">16–20 Tamu</option>
                            <option value="21">21–30 Tamu</option>
                            <option value="31">31+ Tamu</option>
                        </select>
                    </div>
                </div>

                <!-- Harga -->
                <div class="price-summary">
                    <div class="price-row">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp0</span>
                    </div>
                    <div class="price-row price-total">
                        <span>Total</span>
                        <span id="totalPrice">Rp0</span>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button id="proceedToPayment" class="btn-book">
                    <i class="fas fa-credit-card"></i> Book Now
                </button>
            </div>

            <button id="modalCloseBtn" class="btn-primary">Close</button>
        </div>
    </div>

    <div class="container">
        <div class="property-header">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-4 font-serif">Takato House</h2>
        </div>

        <!-- Calendar Section -->
        <div class="card calendar-container">
            <h3 class="card-title">
                <i class="fas fa-calendar"></i> Availability Calendar
            </h3>

            <!-- Status Legend -->
            <div class="status-legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #28C76F;"></div>
                    <span>Available</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #EA5455;"></div>
                    <span>Booked</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #FF9F43;"></div>
                    <span>Special Event</span>
                </div>
            </div>

            <div class="calendar-layout">
                <!-- Calendar Column (3 parts) -->
                <div class="calendar-column">
                    <div id="calendar"></div>
                </div>

                <!-- Booking Form Column (1 part) -->
                <div class="booking-column">
                    <div class="booking-form">
                        <div class="price-container">
                            <button id="openBookingModal" class="btn-book">
                                <i class="fas fa-calendar-check"></i> Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Grand Schedule in Card -->
            <div class="card schedule-card">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt"></i> Grand Schedule & Pricing
                </h3>
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Date Range</th>
                            <th>Day Type</th>
                            <th>Price</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Weekday & Weekend (Mon-Sun)</td>
                            <td>Regular</td>
                            <td class="price-low">Rp 5,000,000</td>

                        </tr>
                        <tr>
                            <td>Public Holidays</td>
                            <td>Peak Season</td>
                            <td class="price-high">Rp 10,000,000</td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="booking-container">
                <div class="property-details">
                    <h2 class="section-title">Property Details</h2>
                    <p class="property-description">
                        Rumah idaman dengan halaman luas di Bogor menawarkan kenyamanan dan kemewahan dengan fasilitas
                        lengkap untuk liburan atau acara keluarga Anda.
                        Terletak di lokasi strategis dengan akses mudah ke berbagai fasilitas umum, villa ini cocok
                        untuk
                        staycation maupun gathering besar.
                    </p>

                    <!-- Location Card with Google Maps -->
                    <div class="card location-card">
                        <h3 class="card-title">
                            <i class="fas fa-map-marker-alt"></i> Location
                        </h3>
                        <div class="location-map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.152651029673!2d106.8061263147699!3d-6.628966995218302!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5d1a5b0d3a5%3A0x5e5a5e5a5e5a5e5a!2sJl.%20Babakan%20Palasari%20No.1%2C%20Cihideung%2C%20Kec.%20Bogor%20Utara%2C%20Kota%20Bogor%2C%20Jawa%20Barat%2016112!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid"
                                allowfullscreen="" loading="lazy"></iframe>
                        </div>
                        <div class="location-address">
                            <i class="fas fa-map-pin"></i>
                            <span>Jl. Babakan palasari no 1, cihideung bogor, Jawa Barat 16112</span>
                        </div>
                        <a href="https://www.google.com/maps/dir//Jl.+Babakan+Palasari+No.1,+Cihideung,+Kec.+Bogor+Utara,+Kota+Bogor,+Jawa+Barat+16112/@-6.628967,106.808315,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x2e69c5d1a5b0d3a5:0x5e5a5e5a5e5a5e5a!2m2!1d106.808315!2d-6.628967?entry=ttu"
                            class="btn-directions" target="_blank">
                            <i class="fas fa-directions"></i> Get Directions
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="SB-Mid-client-vumw33ofLMM-bm9y"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
        <script>
            // Make calendar instance globally accessible
            let calendar;
            // Modal functionality
            const modal = document.getElementById('bookingModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const modalForm = document.getElementById('modalForm');
            const modalCloseBtn = document.getElementById('modalCloseBtn');


            function showModal(title, message) {
                modalTitle.textContent = title;
                modalMessage.innerHTML = message;
                modalForm.style.display = 'none';
                modalMessage.style.display = 'block';
                modal.style.display = 'flex';
            }

            document.addEventListener('DOMContentLoaded', function() {

                // Initialize the calendar
                var calendarEl = document.getElementById('calendar');
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    selectMirror: true,
                    timeZone: 'local',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek'
                    },
                    buttonText: {
                        today: 'Today',
                        month: 'Month',
                        week: 'Week'
                    },
                    initialDate: new Date(),
                    dayMaxEventRows: 2,
                    dayCellContent: function(arg) {
                        return {
                            html: arg.dayNumberText.replace('日', '')
                        };
                    },
                    // In your FullCalendar events function
                    events: function(fetchInfo, successCallback, failureCallback) {
                        $.ajax({
                            url: '/grand-schedules/calendar-data',
                            method: 'GET',
                            data: {
                                start: fetchInfo.startStr,
                                end: fetchInfo.endStr
                            },
                            success: function(response) {
                                var events = response.map(function(schedule) {
                                    // Determine day type - use special_event if defined, otherwise weekday_weekend
                                    const dayType = schedule.extendedProps.day_type ||
                                        'weekday_weekend';

                                    // Extract price from title (Rp 5.000.000 -> 5000000)
                                    var priceText = schedule.title.replace('Rp ', '')
                                        .replace(/\./g, '');
                                    var price = parseInt(priceText) || (dayType ===
                                        'special_event' ? 7000000 : 5000000);

                                    return {
                                        title: schedule.title,
                                        start: schedule.start,
                                        extendedProps: {
                                            day_type: dayType, // This will be either special_event or weekday_weekend
                                            status: schedule.extendedProps.status,
                                            notes: schedule.extendedProps.notes,
                                            original_price: price
                                        },
                                        className: schedule.extendedProps.status ===
                                            'available' ?
                                            (dayType === 'special_event' ?
                                                'fc-event-peak' : 'fc-event-available'
                                            ) : 'fc-event-booked'
                                    };
                                });
                                successCallback(events);
                            },
                            error: function(error) {
                                console.error('Error fetching calendar data:', error);
                                failureCallback(error);
                            }
                        });
                    },
                    eventContent: function(arg) {
                        var eventContainer = document.createElement('div');
                        eventContainer.className = 'fc-event-main';

                        var priceEl = document.createElement('div');
                        priceEl.className = 'fc-event-price';
                        priceEl.innerText = arg.event.title;

                        var statusEl = document.createElement('div');
                        statusEl.className = 'fc-event-status';
                        statusEl.innerText = arg.event.extendedProps.status === 'available' ?
                            (arg.event.extendedProps.day_type === 'special_event' ?
                                'Special' : 'Available') :
                            'Booked';

                        eventContainer.appendChild(priceEl);
                        eventContainer.appendChild(statusEl);

                        return {
                            domNodes: [eventContainer]
                        };
                    }
                });

                calendar.render();

                function showBookingForm() {
                    modalTitle.textContent = 'Book Your Stay';
                    modalMessage.style.display = 'none';
                    modalForm.style.display = 'block';
                    modal.style.display = 'flex';

                    // Reset form
                    document.getElementById('checkin-date').value = '';
                    document.getElementById('checkout-date').value = '';
                    document.getElementById('guests').value = '1';
                    document.getElementById('email').value = '';
                    updatePriceSummary(0, 0, 0);
                }

                modalCloseBtn.addEventListener('click', () => {
                    modal.style.display = 'none';
                });

                // Number formatting helper
                function numberFormat(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                }

                // Calculate number of nights
                function getNights(checkin, checkout) {
                    const diff = new Date(checkout) - new Date(checkin);
                    return Math.ceil(diff / (1000 * 60 * 60 * 24));
                }

                // Calculate total price
                function calculateTotalPrice(checkin, checkout) {
                    if (!checkin || !checkout) return {
                        nights: 0,
                        subtotal: 0,
                        total: 0,
                        nightlyRate: 0
                    };

                    const checkinDate = new Date(checkin);
                    const checkoutDate = new Date(checkout);
                    let total = 0;
                    let nights = 0;

                    const events = calendar.getEvents();
                    let currentDate = new Date(checkinDate);

                    while (currentDate < checkoutDate) {
                        const dateStr = currentDate.toISOString().split('T')[0];

                        // Find if there's a special event for this date
                        const event = events.find(e =>
                            e.start && e.start.toISOString().split('T')[0] === dateStr
                        );

                        // Determine price: 
                        // - Use event price if exists
                        // - Otherwise use default pricing based on day type
                        const price = event ?
                            event.extendedProps.original_price :
                            (currentDate.getDay() === 0 || currentDate.getDay() === 6 ? 6000000 : 5000000);

                        total += price;
                        nights++;
                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    return {
                        nights: nights,
                        subtotal: total,
                        total: total, // No additional fees in this example
                        nightlyRate: nights > 0 ? Math.round(total / nights) : 0
                    };
                }

                // Update price summary in the modal
                function updatePriceSummary(subtotal, serviceFee, total) {
                    document.getElementById('subtotal').textContent = 'Rp' + numberFormat(subtotal);
                    document.getElementById('totalPrice').textContent = 'Rp' + numberFormat(total);
                }

                function validateBookingDates(checkin, checkout) {
                    if (!checkin || !checkout) {
                        return {
                            valid: false,
                            message: 'Please select both check-in and check-out dates'
                        };
                    }

                    const checkinDate = new Date(checkin);
                    const checkoutDate = new Date(checkout);

                    if (checkinDate >= checkoutDate) {
                        return {
                            valid: false,
                            message: 'Check-out date must be after check-in date'
                        };
                    }

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (checkinDate < today) {
                        return {
                            valid: false,
                            message: 'Check-in date cannot be in the past'
                        };
                    }

                    // Helper untuk format YYYY-MM-DD tanpa masalah timezone
                    function toDateStringLocal(d) {
                        return d.getFullYear() + '-' +
                            String(d.getMonth() + 1).padStart(2, '0') + '-' +
                            String(d.getDate()).padStart(2, '0');
                    }

                    const events = calendar.getEvents();

                    // Loop dari check-in sampai sehari sebelum check-out
                    let currentDate = new Date(checkinDate);
                    while (currentDate < checkoutDate) {
                        const currentDateStr = toDateStringLocal(currentDate);

                        const isBooked = events.some(e => {
                            const eventDateStr = toDateStringLocal(e.start);
                            return eventDateStr === currentDateStr && e.extendedProps.status === 'booked';
                        });

                        if (isBooked) {
                            return {
                                valid: false,
                                message: `Date ${currentDateStr} is already booked`
                            };
                        }

                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    return {
                        valid: true
                    };
                }


                // Format date for display
                function formatDate(date) {
                    return date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }

                // Process payment with Midtrans
                function processPayment(bookingData) {
                    showModal('Processing', 'Preparing your payment...');

                    // In a real implementation, you would send this to your backend
                    // which would then generate a Snap token
                    // This is a mock implementation for demonstration

                    // Mock snap token (in production, get this from your backend)
                    const snapToken = 'YOUR_MOCK_SNAP_TOKEN';

                    // For demo purposes, we'll use a timeout to simulate API call
                    setTimeout(() => {
                        snap.pay(snapToken, {
                            onSuccess: function(result) {
                                showModal('Success', `
                            <p>Payment successful!</p>
                            <p>Booking ID: ${generateBookingId()}</p>
                            <p>We've sent confirmation to ${bookingData.email}</p>
                        `);
                                calendar.refetchEvents();
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
                }

                // Generate random booking ID for demo
                function generateBookingId() {
                    return 'BK-' + Math.random().toString(36).substr(2, 8).toUpperCase();
                }
                // Handle booking submission
                function handleBooking() {
                    const email = document.getElementById('email').value.trim();
                    const phone = document.getElementById('phone').value.trim();
                    const checkin = document.getElementById('checkin-date').value;
                    const checkout = document.getElementById('checkout-date').value;
                    const guests = document.getElementById('guests').value;

                    // Reset error states
                    document.getElementById('emailError').style.display = 'none';
                    document.getElementById('phoneError').style.display = 'none';
                    document.getElementById('checkinError').style.display = 'none';
                    document.getElementById('checkoutError').style.display = 'none';

                    // Validate fields
                    let isValid = true;

                    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        document.getElementById('emailError').textContent = 'Please enter a valid email address';
                        document.getElementById('emailError').style.display = 'block';
                        isValid = false;
                    }

                    if (!phone || phone.length < 10 || !/^[0-9]+$/.test(phone)) {
                        document.getElementById('phoneError').textContent =
                            'Please enter a valid phone number (min 10 digits)';
                        document.getElementById('phoneError').style.display = 'block';
                        isValid = false;
                    }

                    if (!checkin) {
                        document.getElementById('checkinError').textContent = 'Please select check-in date';
                        document.getElementById('checkinError').style.display = 'block';
                        isValid = false;
                    }

                    if (!checkout) {
                        document.getElementById('checkoutError').textContent = 'Please select check-out date';
                        document.getElementById('checkoutError').style.display = 'block';
                        isValid = false;
                    }

                    if (checkin && checkout && new Date(checkin) >= new Date(checkout)) {
                        document.getElementById('checkoutError').textContent = 'Check-out must be after check-in';
                        document.getElementById('checkoutError').style.display = 'block';
                        isValid = false;
                    }

                    if (!isValid) return;

                    // Calculate price details
                    const priceDetails = calculateTotalPrice(checkin, checkout);

                    // Prepare booking data
                    const bookingData = {
                        checkin_date: checkin,
                        checkout_date: checkout,
                        email: email,
                        phone: phone,
                        guests: parseInt(guests),
                        subtotal: priceDetails.subtotal,
                        total_price: priceDetails.total
                    };

                    // Submit booking
                    submitBookingToBackend(bookingData);
                }

                // Initialize date inputs
                $('#checkin-date, #checkout-date')
                    .on('focus', function() {
                        this.type = 'date';
                    })
                    .attr('min', new Date().toISOString().split('T')[0])
                    .on('change', function() {
                        const checkin = $('#checkin-date').val();
                        const checkout = $('#checkout-date').val();

                        if (checkin && checkout) {
                            const priceDetails = calculateTotalPrice(checkin, checkout);
                            updatePriceSummary(priceDetails.subtotal, priceDetails.serviceFee, priceDetails.total);
                        }
                    });

                // Open booking modal
                document.getElementById('openBookingModal').addEventListener('click', showBookingForm);

                // Proceed to payment button
                document.getElementById('proceedToPayment').addEventListener('click', handleBooking);
            });

            function submitBookingToBackend(bookingData) {
                showModal('Processing', 'Processing your booking...');

                $.ajax({
                    url: '/grand-schedules/book',
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    data: bookingData,
                    success: function(response) {
                        if (response.success) {
                            if (response.payment_options && response.payment_options.midtrans) {
                                // Process payment with Midtrans
                                processMidtransPayment(
                                    response.payment_options.midtrans.token,
                                    response.total_price,
                                    bookingData.email,
                                    bookingData.phone,
                                    response.booking_id
                                );
                            } else {
                                showModal('Success', `
                        <p>Booking successful!</p>
                        <p>Booking ID: ${response.booking_id}</p>
                        <p>Total: Rp${numberFormat(response.total_price)}</p>
                        <p>Confirmation sent to ${bookingData.email}</p>
                    `);
                                calendar.refetchEvents();
                            }
                        } else {
                            showModal('Error', response.message || 'Booking failed');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Failed to process booking';

                        if (xhr.status === 422) {
                            const response = xhr.responseJSON;
                            if (response && response.errors) {
                                errorMsg = Object.entries(response.errors)
                                    .map(([field, messages]) =>
                                        `${field}: ${Array.isArray(messages) ? messages.join(', ') : messages}`)
                                    .join('<br>');
                            } else if (response && response.message) {
                                errorMsg = response.message;
                            }
                        } else if (xhr.status === 500) {
                            errorMsg = 'Server error occurred. Please try again later.';
                        }

                        showModal('Error', errorMsg);
                    }
                });
            }

            function processMidtransPayment(snapToken, amount, email, phone, bookingId) {
                showModal('Processing', 'Redirecting to payment gateway...');

                // For demo purposes, we'll use a timeout to simulate API call
                setTimeout(() => {
                    snap.pay(snapToken, {
                        onSuccess: function(result) {
                            showModal('Success', `
                    <p>Payment successful!</p>
                    <p>Booking ID: ${bookingId}</p>
                    <p>Amount: Rp${numberFormat(amount)}</p>
                    <p>We've sent confirmation to ${email}</p>
                `);
                            calendar.refetchEvents();
                        },
                        onPending: function(result) {
                            showModal('Pending', `
                    <p>Payment pending.</p>
                    <p>Booking ID: ${bookingId}</p>
                    <p>Please complete your payment.</p>
                    <p>We'll notify you when payment is confirmed.</p>
                `);
                        },
                        onError: function(result) {
                            showModal('Error', `
                    <p>Payment failed: ${result.status_message || 'Unknown error'}</p>
                    <p>Booking ID: ${bookingId}</p>
                    <p>Please try again or contact support.</p>
                `);
                        },
                        onClose: function() {
                            showModal('Info', `
                    <p>Payment window closed.</p>
                    <p>Your booking is still reserved.</p>
                    <p>Booking ID: ${bookingId}</p>
                `);
                        }
                    });
                }, 1000);
            }
        </script>
</body>

</html>
