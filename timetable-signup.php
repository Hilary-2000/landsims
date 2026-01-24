<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Create Account - Online-Timetable Generator</title>
    <meta content="Ladybird Online-Timetable Generator helps schools administrators generate timetables efficiently and effectively - . It is the best timetable generator for schools in Kenya." name="description">

    <meta content="The best timetable generator for schools in Kenya" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/logo2.png" rel="icon">
    <link href="assets/img/logo2.png" rel="apple-touch-icon">
    <link rel="shortcut icon" href="assets/img/logo2.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: FlexStart - v1.9.0
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-243578000-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-243578000-1');
        gtag('event', 'conversion', {'send_to': 'AW-17752151149/LD-gCLDIqOgbEO2o8ZBC'}); </script>
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-K5H4YCK02K"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-K5H4YCK02K');
        gtag('config', 'AW-17752151149'); 
    </script>
    <style id="builder-color-presets-css">
        [data-colorpreset="cp-light-background"],
        .light-background {
            --background-color: #f9f9f9;
            --surface-color: #ffffff;
        }

        [data-colorpreset="cp-dark-background"],
        .dark-background {
            --background-color: #060606;
            --default-color: #ffffff;
            --heading-color: #ffffff;
            --surface-color: #252525;
            --contrast-color: #ffffff;
        }
    </style>
    <style id="section-XHcwBXvsKg-style">
        .steps .steps-content {
            padding-right: 30px;
            margin-bottom: 40px;
        }

        @media (max-width: 992px) {
            .steps .steps-content {
                padding-right: 0;
            }
        }

        .steps .steps-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--heading-color);
        }

        @media (max-width: 768px) {
            .steps .steps-content h2 {
                font-size: 2rem;
            }
        }

        .steps .steps-content .lead {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            color: var(--default-color);
        }

        .steps .steps-content p {
            margin-bottom: 2rem;
            color: var(--default-color);
        }

        .steps .steps-content .steps-cta {
            display: flex;
            gap: 15px;
        }

        @media (max-width: 576px) {
            .steps .steps-content .steps-cta {
                flex-direction: column;
            }
        }

        .steps .steps-content .steps-cta .btn {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .steps .steps-content .steps-cta .btn-primary {
            background-color: rgb(95, 158, 160);
            border-color: rgb(95, 158, 160);
            color: var(--contrast-color);
        }

        .steps .steps-content .steps-cta .btn-primary:hover {
            background-color: color-mix(in srgb, rgb(95, 158, 160), #000 10%);
            border-color: color-mix(in srgb, rgb(95, 158, 160), #000 10%);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .steps .steps-content .steps-cta .btn-outline {
            background-color: transparent;
            border: 2px solid rgb(95, 158, 160);
            color: rgb(95, 158, 160);
        }

        .steps .steps-content .steps-cta .btn-outline:hover {
            background-color: rgb(95, 158, 160);
            color: var(--contrast-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .steps .steps-list {
            position: relative;
        }

        .steps .steps-list::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 25px;
            width: 2px;
            background-color: color-mix(in srgb, rgb(95, 158, 160), transparent 70%);
        }

        @media (max-width: 576px) {
            .steps .steps-list::before {
                left: 20px;
            }
        }

        .steps .steps-list .step-item {
            display: flex;
            margin-bottom: 30px;
            position: relative;
        }

        .steps .steps-list .step-item:last-child {
            margin-bottom: 0;
        }

        .steps .steps-list .step-item:hover .step-number {
            background-color: rgb(95, 158, 160);
            color: var(--contrast-color);
            transform: scale(1.1);
        }

        .steps .steps-list .step-item .step-number {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: color-mix(in srgb, rgb(95, 158, 160) 10%, white 90%);
            color: rgb(95, 158, 160);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            margin-right: 20px;
            z-index: 1;
            transition: all 0.3s ease;
        }

        @media (max-width: 576px) {
            .steps .steps-list .step-item .step-number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        .steps .steps-list .step-item .step-content {
            padding-top: 5px;
        }

        .steps .steps-list .step-item .step-content h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--heading-color);
        }

        @media (max-width: 576px) {
            .steps .steps-list .step-item .step-content h3 {
                font-size: 1.1rem;
            }
        }

        .steps .steps-list .step-item .step-content p {
            font-size: 0.95rem;
            color: var(--default-color);
            margin-bottom: 0;
        }
    </style>

    <!-- Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <h1 class="d-none">Ladybird School Management System</h1>
            <a href="." class="logo d-flex align-items-center">
                <img src="assets/img/ladybird_white-removebg.png" alt="">
                <span>Ladybird</span>
            </a>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="./timetable-generator.php">Home</a></li>
                    <li><a class="nav-link scrollto" href="./timetable-generator.php#guide">5 Step Guide</a></li>
                    <li><a class="nav-link scrollto" href="./timetable-generator.php#values">Why Choose Us</a></li>
                    <li><a class="nav-link scrollto" href="./timetable-generator.php#pricing">Pricing</a></li>
                    <li><a class="nav-link scrollto" href="index.php">Back to Ladybird SMS</a></li>
                    <li><a class="getstarted scrollto" href="https://timetablegenerator.ladybirdsmis.com">Sign In</a></li>
                    <!-- <li><a class="getstarted scrollto" href="lsims.ladybirdsmis.com">L-SIMS</a></li> -->
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <!-- .navbar -->

        </div>
    </header>
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up">Ladybird Online Timetable Generator</h1>
                    <h2 data-aos="fade-up" data-aos-delay="400">Generate class, block and teacher timetable online in just a few minutes using our robust timetable generator. <br>In just <span class="badge bg-success">5 simple</span> steps your timetable will be ready.</h2>
                    <div data-aos="fade-up" data-aos-delay="600">
                        <div class="text-center text-lg-start">
                            <a href="#about" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>Get Started</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="#guide" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>Guide</span>
                                <i class="bi bi-file-earmark-richtext"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/img/student2.svg" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2></h2>
                <p>Create you account</p>
            </header>
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Address</h3>
                                <p>A2 Thika Town,<br>P.O Box 853-50400</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-telephone"></i>
                                <h3>Call Us</h3>
                                <p>+254 743 551 250<br>+254 705 624 113</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-envelope"></i>
                                <h3>Email Us</h3>
                                <p>mail@ladybirdsmis.com</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-clock"></i>
                                <h3>Open Hours</h3>
                                <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                                <p>Saturday <br>9:00AM - 01:00PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <form action="ajax/login/login.php" method="post" class="" id="registration_form">
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <input type="hidden" name="create_account" value="1">
                                <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                                <input type="text" id="full_names" name="fullname" class="form-control" value="<?= isset($_SESSION['fullname']) ? $_SESSION['fullname'] : "" ?>" placeholder="Your Name" required>
                            </div>

                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" value="<?= isset($_SESSION['email']) ? $_SESSION['email'] : "" ?>" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" id="tt_code" name="tt_code" value="<?= isset($_SESSION['tt_code']) ? $_SESSION['tt_code'] : "" ?>" placeholder="Timetable Code" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" name="school_name" class="form-control" value="<?= isset($_SESSION['school_name']) ? $_SESSION['school_name'] : "" ?>" placeholder="School Name" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="phone_number" value="<?= isset($_SESSION['phone_number']) ? $_SESSION['phone_number'] : "" ?>" placeholder="Your Phone Number" required>
                            </div>

                            <div class="col-md-12">
                                <select class="form-control" name="school_county" id="school_county">
                                    <option value="" hidden>Select County</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Mombasa") ? "selected" : "" ?> id="Mombasa" value="Mombasa">Mombasa</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kwale") ? "selected" : "" ?> id="Kwale" value="Kwale">Kwale</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kilifi") ? "selected" : "" ?> id="Kilifi" value="Kilifi">Kilifi</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Tana River") ? "selected" : "" ?> id="Tana River" value="Tana River">Tana River</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Lamu") ? "selected" : "" ?> id="Lamu" value="Lamu">Lamu</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Taita/aveta") ? "selected" : "" ?> id="Taita/aveta" value="Taita/Taveta">Taita/Taveta</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Garissa") ? "selected" : "" ?> id="Garissa" value="Garissa">Garissa</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Wajir") ? "selected" : "" ?> id="Wajir" value="Wajir">Wajir</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Mandera") ? "selected" : "" ?> id="Mandera" value="Mandera">Mandera</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Marsabit") ? "selected" : "" ?> id="Marsabit" value="Marsabit">Marsabit</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Isiolo") ? "selected" : "" ?> id="Isiolo" value="Isiolo">Isiolo</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Meru") ? "selected" : "" ?> id="Meru" value="Meru">Meru</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Tharaka-Nithi") ? "selected" : "" ?> id="Tharaka-Nithi" value="Tharaka-Nithi">Tharaka-Nithi</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Embu") ? "selected" : "" ?> id="Embu" value="Embu">Embu</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kitui") ? "selected" : "" ?> id="Kitui" value="Kitui">Kitui</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Machakos") ? "selected" : "" ?> id="Machakos" value="Machakos">Machakos</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Makueni") ? "selected" : "" ?> id="Makueni" value="Makueni">Makueni</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Nyandarua") ? "selected" : "" ?> id="Nyandarua" value="Nyandarua">Nyandarua</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Nyeri") ? "selected" : "" ?> id="Nyeri" value="Nyeri">Nyeri</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kirinyaga") ? "selected" : "" ?> id="Kirinyaga" value="Kirinyaga">Kirinyaga</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Murang'a") ? "selected" : "" ?> id="Murang'a" value="Murang'a">Murang'a</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kiambu") ? "selected" : "" ?> id="Kiambu" value="Kiambu">Kiambu</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Turkana") ? "selected" : "" ?> id="Turkana" value="Turkana">Turkana</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "West Pokot") ? "selected" : "" ?> id="West Pokot" value="West Pokot">West Pokot</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Samburu") ? "selected" : "" ?> id="Samburu" value="Samburu">Samburu</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Trans Nzoia") ? "selected" : "" ?> id="Trans Nzoia" value="Trans Nzoia">Trans Nzoia</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Uasin Gishu") ? "selected" : "" ?> id="Uasin Gishu" value="Uasin Gishu">Uasin Gishu</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Elgeyo/Marakwet") ? "selected" : "" ?> id="Elgeyo/Marakwet" value="Elgeyo/Marakwet">Elgeyo/Marakwet</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Nandi") ? "selected" : "" ?> id="Nandi" value="Nandi">Nandi</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Baringo") ? "selected" : "" ?> id="Baringo" value="Baringo">Baringo</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Laikipia") ? "selected" : "" ?> id="Laikipia" value="Laikipia">Laikipia</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Nakuru") ? "selected" : "" ?> id="Nakuru" value="Nakuru">Nakuru</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Narok") ? "selected" : "" ?> id="Narok" value="Narok">Narok</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kajiado") ? "selected" : "" ?> id="Kajiado" value="Kajiado">Kajiado</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kericho") ? "selected" : "" ?> id="Kericho" value="Kericho">Kericho</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Bomet") ? "selected" : "" ?> id="Bomet" value="Bomet">Bomet</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kakamega") ? "selected" : "" ?> id="Kakamega" value="Kakamega">Kakamega</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Vihiga") ? "selected" : "" ?> id="Vihiga" value="Vihiga">Vihiga</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Bungoma") ? "selected" : "" ?> id="Bungoma" value="Bungoma">Bungoma</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Busia") ? "selected" : "" ?> id="Busia" value="Busia">Busia</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Siaya") ? "selected" : "" ?> id="Siaya" value="Siaya">Siaya</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kisumu") ? "selected" : "" ?> id="Kisumu" value="Kisumu">Kisumu</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Homa Bay") ? "selected" : "" ?> id="Homa Bay" value="Homa Bay">Homa Bay</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Migori") ? "selected" : "" ?> id="Migori" value="Migori">Migori</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Kisii") ? "selected" : "" ?> id="Kisii" value="Kisii">Kisii</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Nyamira") ? "selected" : "" ?> id="Nyamira" value="Nyamira">Nyamira</option>
                                    <option <?= (isset($_SESSION['school_county']) && $_SESSION['school_county'] == "Nairobi") ? "selected" : "" ?> id="Nairobi" value="Nairobi">Nairobi</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <select class="form-control" name="school_country" id="school_country">
                                    <option value="" hidden>Select Country</option>
                                    <option <?= (isset($_SESSION['school_country']) && $_SESSION['school_country'] == "Kenya") ? "selected" : "" ?> id = "Kenya" selected value="Kenya">Kenya</option>
                                    <option <?= (isset($_SESSION['school_country']) && $_SESSION['school_country'] == "Uganda") ? "selected" : "" ?> id = "Uganda" hidden value="Uganda">Uganda</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <input type="text" value="<?= isset($_SESSION['username']) ? $_SESSION['username'] : "" ?>" class="form-control" name="username" placeholder="Preffered Username" required>
                            </div>

                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password_1" placeholder="Preffered Password" required>
                            </div>

                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password_2" placeholder="Repeat Password" required>
                            </div>

                            <div class="cf-turnstile"
                                data-sitekey="0x4AAAAAACOwrvcgUtNUu9B6"
                                data-callback="onTurnstileSuccess"
                                data-error-callback="onTurnstileError"
                                data-expired-callback="onTurnstileExpired">
                            </div>

                            <input type="hidden" name="cf_turnstile_response" id="cf_turnstile_response">

                            <div class="col-md-12 text-center">
                                <div id="expiry_handler"><?php
                                        if (isset($_SESSION['error'])) {
                                            echo "<p class='border border-danger text-danger'>" . $_SESSION['error'] . "</p>";
                                        }
                                        if (isset($_SESSION['success'])) {
                                            echo "<p class='border border-success text-success'>" . $_SESSION['success'] . "</p>";
                                        }
                                        ?>
                                </div>
                                <button class="btn btn-primary" id='submit_button' disabled type="submit"><i class="bi bi-person-plus"></i> Register</button>
                                <a href="https://timetablegenerator.ladybirdsmis.com/timetable_generator/login.php" class="btn btn-outline-success"><i class="bi bi-box-arrow-in-right"></i> Sign In</a>
                            </div>

                        </div>
                    </form>

                </div>

            </div>

        </div>

    </section>
    <!-- End Contact Section -->
    <?php
    if (isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    ?>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <!-- <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <h4>Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                    </div>
                    <div class="col-lg-6">
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-5 col-md-12 footer-info">
                        <a href="." class="logo d-flex align-items-center">
                            <img src="assets/img/ladybird_white-removebg.png" alt="">
                            <span>Ladybird</span>
                        </a>
                        <p>The all-in-one school management information system with a suite of portals for parents, students and staff, giving your school full control of all academic, financial and administrative information.</p>
                        <div class="social-links mt-3">
                            <a href="https://www.tiktok.com/@ladybirdsmis?lang=en" target="_blank" class="twitter"><i class="bi bi-tiktok"></i></a>
                            <a href="https://www.facebook.com/ladybirdsmis" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="https://www.instagram.com/ladybirdsmis/" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.linkedin.com/company/ladybird-softech-co" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            <a href="https://www.youtube.com/@ladybirdschoolmanagementsy8323" target="_blank" class="linkedin"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Android Development</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                        <h4>Contact Us</h4>
                        <p>
                            Thika Town <br>Kenya <br><br>
                            <strong>Phone:</strong> +254 743 551 250<br>
                            <strong>Email:</strong> mail@ladybirdsmis.com<br>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Ladybird SMIS from ladybird Softech Company</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
                Designed by <a href="javascript:;">Ladybird Softech co.</a>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script>
        cObj("full_names").onkeyup =  function(){
            var fullname = this.value.trim();
            var abbr_name = fullname.substring(0,3);
            if(fullname.split(" ").length > 1){
                abbr_name = "";
                for(var index = 0; index < fullname.split(" ").length; index++){
                    abbr_name += fullname.split(" ")[index].substring(0,1);
                }
            }

            // tt_code
            cObj("tt_code").value = abbr_name.substring(0,3);
        }

        function cObj(id){
            return document.getElementById(id);
        }
    </script>
    <script>
        function onTurnstileSuccess(token) {
            cObj('cf_turnstile_response').value = token;
            cObj('submit_button').disabled = false;
        }
        function onTurnstileError(errorCode) {
            console.error("Turnstile error:", errorCode);
        }
        function onTurnstileExpired() {
            console.warn("Turnstile token expired");
            cObj("expiry_handler").innerHTML = "<p class='border border-danger text-danger'>Page expired. Reload and try again!</p>";
        }
    </script>
</body>

</html>