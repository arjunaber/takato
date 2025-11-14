<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - TAKATO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ==========================================================
        * EARTH TONE COLOR PALETTE
        * =========================================================== */
        :root {
            --primary-color: #557A76;
            --secondary-color: #F7F5EB;
            --accent-color: #436360;
            --text-color: #5D5A53;
            --border-color: #A3A39A;

            /* Ukuran satu set 5 gambar */
            --total-set-width: 150vw;
            --image-size: 30vw;
            --animation-duration: 60s;
        }

        /* ----------------------------------------------------------
        * CSS UNTUK ANIMASI MARQUEE BACKGROUND
        * ---------------------------------------------------------- */

        @keyframes scrollRight {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes scrollLeft {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-100%);
            }
        }

        /* BASE LAYOUT */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--secondary-color);
            min-height: 100vh;
            /* Ganti height menjadi min-height */
            display: flex;
            align-items: center;
            justify-content: center;

            /* PENTING: Memperbolehkan vertical scroll jika konten meluap */
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
        }

        /* CONTAINER MARQUEE */
        .background-marquee {
            position: fixed;
            /* Gunakan fixed agar tetap di viewport */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            z-index: -2;
            overflow: hidden;
            /* Kontainer Marquee yang menyembunyikan overscroll */
        }

        .marquee-row {
            flex: 1;
            /* Membagi 3 tingkat secara vertikal */
            width: 200%;
            display: flex;
            animation: scrollLeft var(--animation-duration) linear infinite;
        }

        .marquee-row:nth-child(even) {
            animation: scrollRight var(--animation-duration) linear infinite;
            animation-duration: 55s;
        }

        .marquee-item {
            width: var(--image-size);
            height: 100%;
            flex-shrink: 0;
            background-size: cover;
            background-position: center;
        }

        /* SETTING GAMBAR */
        .marquee-item:nth-child(5n + 1) {
            background-image: url('/img1.jpg');
        }

        .marquee-item:nth-child(5n + 2) {
            background-image: url('/img2.jpg');
        }

        .marquee-item:nth-child(5n + 3) {
            background-image: url('/img3.jpg');
        }

        .marquee-item:nth-child(5n + 4) {
            background-image: url('/img4.jpg');
        }

        .marquee-item:nth-child(5n + 5) {
            background-image: url('/img5.jpg');
        }


        /* Overlay gelap agar teks terbaca */
        body::after {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            background: rgba(0, 0, 0, 0.5);
        }

        /* ----------------------------------------------------------
        * LOGIN STYLES
        * ---------------------------------------------------------- */
        .login-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            margin: 1rem;
            /* Tambahkan margin agar tidak menempel di tepi HP */
        }

        .form-side {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-side h2 {
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 2rem;
            text-align: center;
            letter-spacing: 2px;
        }

        /* Input & Tombol */
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(85, 122, 118, 0.25);
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            width: 100%;
            padding: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: var(--accent-color);
        }

        .input-group-text {
            background-color: var(--secondary-color);
            border-right: none;
            border-color: var(--border-color);
            color: var(--text-color);
        }

        .form-control {
            border-left: none;
            border-color: var(--border-color);
        }

        .login-footer {
            text-align: center;
            padding-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-color);
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        /* ==========================================================
        * MEDIA QUERIES UNTUK RESPONSIVE
        * =========================================================== */

        /* Tablet dan Mobile (di bawah 768px) */
        @media (max-width: 767.98px) {

            /* Mengurangi padding form agar fit di layar kecil */
            .form-side {
                padding: 2rem 1.5rem;
            }

            /* Mengurangi ukuran gambar marquee agar tidak terlalu besar di HP */
            :root {
                --image-size: 50vw;
                /* Setiap gambar 50% lebar layar */
            }

            /* JIKA KONTEN LOGIN TERLALU TINGGI DI HP:
               Karena kita menggunakan min-height: 100vh di body,
               scroll vertikal seharusnya sudah berfungsi otomatis. */
        }
    </style>
</head>

<body>

    {{-- BACKGROUND MARQUEE --}}
    <div class="background-marquee">

        <div class="marquee-row">
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
        </div>

        <div class="marquee-row">
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
        </div>

        <div class="marquee-row">
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
            <div class="marquee-item"></div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-card">

                    {{-- FORM --}}
                    <div class="form-side">
                        <h2>TAKATO</h2>

                        {{-- Laravel/Blade Error Handling Block --}}
                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ $errors->first() }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Masukkan email Anda" required autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Masukkan kata sandi Anda" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Ingat Saya</label>
                                </div>
                                <a href="#" style="color: var(--primary-color);">Lupa Kata Sandi?</a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i> MASUK
                            </button>
                        </form>

                        <div class="login-footer">
                            Belum punya akun? <a href="#">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
