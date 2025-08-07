<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .admin-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
            border-radius: 10px 10px 0 0 !important;
        }

        .welcome-message {
            color: #000000;
            margin-bottom: 20px;
        }

        /* Flip Card Styles */
        .flip-card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            max-width: 900px;
            margin: 30px auto;
        }

        .flip-card {
            background-color: transparent;
            perspective: 1000px;
            height: 300px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
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
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .flip-card-front {
            background-color: white;
            color: #333;
        }

        .flip-card-back {
            background-color: #000000;
            color: white;
            transform: rotateY(180deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .flip-card-back img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }

        .card-icon {
            background-color: rgba(78, 115, 223, 0.1);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .card-icon i {
            font-size: 24px;
            color: #000000;
        }

        .flip-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .flip-card p {
            color: #666;
            margin-bottom: 25px;
            flex-grow: 1;
        }

        .flip-card .btn {
            background-color: #000000;
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .flip-card .btn:hover {
            background-color: #000000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card admin-card">
                    <div class="card-header text-center py-3">
                        <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                    </div>

                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="text-center welcome-message">
                            <h3><i class="fas fa-user-shield me-2"></i>Selamat datang, Admin!</h3>
                            <p class="text-muted">Ini adalah area khusus untuk administrator sistem</p>
                        </div>

                        <!-- Flip Cards Section -->
                        <div class="flip-card-container">
                            <!-- Takato House Card -->
                            <div class="flip-card">
                                <div class="flip-card-inner">
                                    <div class="flip-card-front">
                                        <div class="card-icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <h3>TAKATO HOUSE</h3>
                                        <p>Manage your villa bookings with our intuitive calendar system. See
                                            availability at a glance and update status with ease.</p>
                                        <button class="btn">Check</button>
                                    </div>
                                    <div class="flip-card-back">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3652/3652191.png"
                                            alt="Calendar Icon">
                                    </div>
                                </div>
                            </div>

                            <!-- Takato Resto Card -->
                            <div class="flip-card">
                                <div class="flip-card-inner">
                                    <div class="flip-card-front">
                                        <div class="card-icon">
                                            <i class="fas fa-utensils"></i>
                                        </div>
                                        <h3>TAKATO RESTO</h3>
                                        <p>Streamline your restaurant operations with our integrated ordering system.
                                            From menu management to payment processing.</p>
                                        <button class="btn">Check</button>
                                    </div>
                                    <div class="flip-card-back" style="background-color: rgb(0, 109, 78);">
                                        <img src="/cafe2.png" alt="Restaurant Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted text-center py-3">
                        <small>Sistem Admin &copy; {{ date('Y') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
