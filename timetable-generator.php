<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ladybird Online-Timetable Generator</title>
    <meta content="Ladybird Online-Timetable Generator helps schools administrators generate timetables efficiently and effectively - . It is the best timetable generator for schools in Kenya." name="description">

    <meta content="The best timetable generator for schools in Kenya" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/ladybird_dark-removebg.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="shortcut icon" href="assets/img/ladybird_dark-removebg.png" type="image/x-icon">

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
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#guide">5 Step Guide</a></li>
                    <li><a class="nav-link scrollto" href="#pricing">Pricing</a></li>
                    <li><a class="nav-link scrollto" href="index.php">Back to Ladybird SMS</a></li>
                    <li><a class="getstarted scrollto" href="#about">Sign In</a></li>
                    <!-- <li><a class="getstarted scrollto" href="lsims.ladybirdsmis.com">L-SIMS</a></li> -->
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <!-- .navbar -->

        </div>
    </header>
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">

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
    <!-- End Hero -->

    <main id="main">
        <section id="guide" class="steps section" data-builder="section">
            <div class="container section-title" data-aos="fade-up" data-builder="section-title">
                <h2>Timetable Generation Guide</h2>
            </div>
            <slot type="section-title"></slot>
            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row">
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="steps-content">
                            <h2>Step 5 Guide</h2>
                            <p>This 5 step guide helps you generate your timetable efficiently and allows you to share it with your teachers, students, and the administrative circle. Once you have your information setup you will continue generating timetables as many times as you wish.</p>
                            <div class="steps-cta">
                                <a href="#contact" class="btn btn-primary">Create Account <i class="bi bi-arrow-right"></i></a>
                                <a href="#about" class="btn btn-outline d-none">Learn More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="300">
                        <div class="steps-list">
                            <div class="step-item">
                                <div class="step-number">01</div>
                                <div class="step-content">
                                    <h3>Create an Account</h3>
                                    <p>Create an account to access the timetable generator using your credentials.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">02</div>
                                <div class="step-content">
                                    <h3>Register Teacher & Subject/Learning Areas</h3>
                                    <p>Register all teaching staff and the school respective learning areas.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">03</div>
                                <div class="step-content">
                                    <h3>Subject/Learning Areas Assignment</h3>
                                    <p>Register all subjects and assign them to teachers teaching them and their respective grade.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">04</div>
                                <div class="step-content">
                                    <h3>Generate Timetable</h3>
                                    <p>Once you have your data setup use the timetable to generate your timetable.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">05</div>
                                <div class="step-content">
                                    <h3>Share Timetable</h3>
                                    <p>Share your generated timetable with teachers, students, and the administrative circle.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End About Section -->

        <!-- ======= Values Section ======= -->
        <section id="values" class="values">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>Why Choose Us</h2>
                    <p>Why Ladybird Online Timetable Generator?</p>
                </header>

                <div class="row">

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="box">
                            <img src="assets/img/values-1.png" class="img-fluid" alt="">
                            <h3>Conflict Free</h3>
                            <p>Our timetable generator prevents scheduling conflicts by ensuring no teacher or classroom is double-booked.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
                        <div class="box">
                            <img src="assets/img/values-2.png" class="img-fluid" alt="">
                            <h3>Set Up Once Use forever</h3>
                            <p>Once you set up your information, you use it forever without initial setup everytime you want to generate your timetable.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="600">
                        <div class="box">
                            <img src="assets/img/values-3.png" class="img-fluid" alt="">
                            <h3>Sharability</h3>
                            <p>Ability to share your timetable with teachers, students, and the administrative circle in just one click via the e-mail. NO need for everyone to have an account to access the timetable.</p>
                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- End Values Section -->

        <!-- ======= Counts Section ======= -->
        <section id="counts" class="counts">
            <div class="container" data-aos="fade-up">

                <div class="row gy-4">

                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-emoji-smile"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Happy Clients</p>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="20" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Projects</p>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-headset" style="color: #15be56;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="24" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Hours Of Support</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-people" style="color: #bb0852;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Hard Workers</p>
                            </div>
                        </div>
                    </div> -->

                </div>

            </div>
        </section>
        <!-- End Counts Section -->

        <!-- ======= Features Section ======= -->
        <section id="features" class="features">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>Features</h2>
                    <p>View our features</p>
                </header>

                <div class="row">

                    <div class="col-lg-6">
                        <img src="assets/img/features.png" class="img-fluid" alt="">
                    </div>

                    <div class="col-lg-6 mt-5 mt-lg-0 d-flex">
                        <div class="row align-self-center gy-4">

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="200">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-shield-plus"></i>
                                    <h3>Admission & Administration</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-bank"></i>
                                    <h3>Financial Management Module</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Reciepts Printing and report generation.</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>SMS fees confirmation, Students results</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Academic Management Module</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="700">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>M-Pesa intergration</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="800">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-calendar3-range"></i>
                                    <h3>Timetable Creation And Management Module</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="900">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Boarding Module</h3>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- / row -->

            </div>

        </section>
        <!-- End Features Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>Detailed Features</h2>
                    <p>Understand More Of What We Offer</p>
                </header>

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-box blue">
                            <i class="ri-discuss-line icon"></i>
                            <h3>Admission & Administration</h3>
                            <p>You can register your students and assign them an admission number or generate one automatically with the system and also manage thier information and the staff information as well.</p>
                            <!-- <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-box orange">
                            <i class="ri-discuss-line icon"></i>
                            <h3>Financial Management Module</h3>
                            <p>Record all financial information this includes: Fees paid, Record School Expenses, Staff payroll information and view all transactions done via mpesa to the institution and many more.</p>
                            <!-- <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-box green">
                            <i class="ri-discuss-line icon"></i>
                            <h3>Reciepts Printing and report generation.</h3>
                            <p>The system is capable of generating fee reciepts for all the transacions captured by the system. Generate reports such as student perfomance charts and income reports statements</p>
                            <!-- <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-box red">
                            <i class="ri-discuss-line icon"></i>
                            <h3>SMS fees confirmation, Students results</h3>
                            <p>You can send SMS to your parents showing them transaction confirmation and student new fee balance or students results.</p>
                            <!-- <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-box purple">
                            <i class="ri-discuss-line icon"></i>
                            <h3>Academic Management Module.</h3>
                            <p>Record view and manage the students and the staff academic information.</p>
                            <!-- <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-box pink">
                            <i class="ri-discuss-line icon"></i>
                            <h3>Timetable Creation And Management Module</h3>
                            <p>Create the school timetable. Staff can view their own timetables and print them.</p>
                            <!-- <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="280">
                        <div class="service-box orange">
                            <i class="ri-discuss-line icon"></i>
                            <h3>Boarding Module</h3>
                            <p>Assign your students their dormitory and view who has boarded in your institution or not.</p>
                            <!-- <a href="#" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a> -->
                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- End Services Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing container d-none">

            <div class="container " data-aos="fade-up">

                <header class="section-header">
                    <h2>Pricing</h2>
                    <p>Check our Pricing</p>
                </header>

                <div class="row gy-4" data-aos="fade-left">

                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="box">
                            <!-- <span class="featured">Featured</span> -->
                            <h3 style="color: #65c600;">Starter Plan</h3>
                            <div class="price"><sup>$</sup>150<span> / yr</span></div>
                            <img src="assets/img/pricing-starter.png" class="img-fluid" alt="">
                            <ul class="">
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Admission and Administration Module</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Financial Management Module</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Report generation and Reciept printing</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Academic Management Module.</li>
                                <!-- <li class="na">Massa ultricies mi</li> -->
                            </ul>
                            <a href="#" class="btn-buy">Buy Now</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                        <div class="box">
                            <span class="featured">Featured</span>
                            <h3 style="color: #ff901c;">Business Plan</h3>
                            <div class="price"><sup>$</sup>200<span> / yr</span></div>
                            <img src="assets/img/pricing-business.png" class="img-fluid" alt="">
                            <ul>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Admission and Administration Module</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Financial Management Module</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Report generation and Reciept printing</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Academic Management Module.</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> SMS fees confirmation, Students results</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> M-Pesa intergration</li>
                            </ul>
                            <a href="#" class="btn-buy">Buy Now</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                        <div class="box">
                            <h3 style="color: #ff0071;">Ultimate Plan</h3>
                            <div class="price"><sup>$</sup>300<span> / yr</span></div>
                            <img src="assets/img/pricing-ultimate.png" class="img-fluid" alt="">
                            <ul>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Admission and Administration Module</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Financial Management Module</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Report generation and Reciept printing</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Academic Management Module.</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> SMS fees confirmation, Students results</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> M-Pesa intergration</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Boarding Module</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> All regular Updates</li>
                            </ul>
                            <a href="#" class="btn-buy">Buy Now</a>
                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- End Pricing Section -->

        <!-- ======= F.A.Q Section ======= -->
        <section id="faq" class="faq">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>F.A.Q</h2>
                    <p>Frequently Asked Questions</p>
                </header>

                <div class="row">
                    <div class="col-lg-6">
                        <!-- F.A.Q List 1-->
                        <div class="accordion accordion-flush" id="faqlist1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                                        Whats a school Management Information System?
                                    </button>
                                </h2>
                                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        is an administration tool for educational institutions.It aims to help educational organizations in their daily routine, by automating administrative tasks
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                                        Who can access Ladybird School Management System?
                                    </button>
                                </h2>
                                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        This school management system can be accessed by the school administrator/ Headteacher and the staff registerd and given permission to access the system. The users of Ladybird SIMS have different role to play in the system.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-3">
                                        Does the adminstrator and the staff access the same information?
                                    </button>
                                </h2>
                                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        No! The different users with different roles in the system are limited to only whats important to them. For example a class teacher can only view the students personal and academic information only not even the financial information can be accessed by
                                        the class teacher.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">

                        <!-- F.A.Q List 2-->
                        <div class="accordion accordion-flush" id="faqlist2">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-1">
                                        Where can I access the system from?
                                    </button>
                                </h2>
                                <div id="faq2-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        The system can be accessed from anywhere securely as long as there is internet connection on your device. You are not limited since we take advantage of the new technology of cloud computing
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-2">
                                        How many students can the system hold?
                                    </button>
                                </h2>
                                <div id="faq2-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        As many as the school can hold and manage. Student number is not limited.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-3">
                                        How can I get the Ladybird School Management System?
                                    </button>
                                </h2>
                                <div id="faq2-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        The process is simple as ABC, You make a call, we book an appointment with you anywhere in the country, or we can organize for a zoom meeting. We customize your dashboard as you wish then we give you your accounts credentials and you can start using our
                                        system.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- End F.A.Q Section -->


        <!-- ======= Testimonials Section ======= -->
        <!-- <section id="testimonials" class="testimonials"> -->

        <!-- <div class="container" data-aos="fade-up"> -->

        <!-- <header class="section-header">
                    <h2>Testimonials</h2>
                    <p>What they are saying about us</p>
                </header> -->

        <!-- <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200"> -->
        <!-- <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    Its one of the best systems we have evr created.We as Ladybird have a good feeling that all our clients are suited to their needs with the system.
                                </p>
                                <div class="profile mt-auto">
                                    <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                                    <h3>Hillary Ngige</h3>
                                    <h4>Ceo &amp; Founder</h4>
                                </div>
                            </div>
                        </div> -->
        <!-- End testimonial item -->

        <!-- <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                                <h3>Sara Wilsson</h3>
                                <h4>Designer</h4>
                            </div>
                        </div>
                    </div> -->
        <!-- End testimonial item -->

        <!-- <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                                <h3>Jena Karlis</h3>
                                <h4>Store Owner</h4>
                            </div>
                        </div>
                    </div> -->
        <!-- End testimonial item -->

        <!-- <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                                <h3>Matt Brandon</h3>
                                <h4>Freelancer</h4>
                            </div>
                        </div>
                    </div> -->
        <!-- End testimonial item -->

        <!-- <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                                <h3>John Larson</h3>
                                <h4>Entrepreneur</h4>
                            </div>
                        </div>
                    </div> -->
        <!-- End testimonial item -->

        <!-- </div> -->
        <!-- <div class="swiper-pagination"></div> -->
        <!-- </div> -->

        <!-- </div> -->

        </section>
        <!-- End Testimonials Section -->

        <!-- ======= Team Section ======= -->
        <!-- <section id="team" class="team">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>Team</h2>
                    <p>Our hard working team</p>
                </header>

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <div class="member-img">
                                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Walter White</h4>
                                <span>Chief Executive Officer</span>
                                <p>Velit aut quia fugit et et. Dolorum ea voluptate vel tempore tenetur ipsa quae aut. Ipsum exercitationem iure minima enim corporis et voluptate.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                        <div class="member">
                            <div class="member-img">
                                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Sarah Jhonson</h4>
                                <span>Product Manager</span>
                                <p>Quo esse repellendus quia id. Est eum et accusantium pariatur fugit nihil minima suscipit corporis. Voluptate sed quas reiciendis animi neque sapiente.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                        <div class="member">
                            <div class="member-img">
                                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>William Anderson</h4>
                                <span>CTO</span>
                                <p>Vero omnis enim consequatur. Voluptas consectetur unde qui molestiae deserunt. Voluptates enim aut architecto porro aspernatur molestiae modi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
                        <div class="member">
                            <div class="member-img">
                                <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                                <p>Rerum voluptate non adipisci animi distinctio et deserunt amet voluptas. Quia aut aliquid doloremque ut possimus ipsum officia.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section> -->
        <!-- End Team Section -->

        <!-- ======= Clients Section ======= -->
        <!-- <section id="clients" class="clients">
            <div class="container" data-aos="fade-up">
                <header class="section-header">
                    <h2>Our Clients</h2>
                    <p>Temporibus omnis officia</p>
                </header>
                <div class="clients-slider swiper">
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section> -->
        <!-- End Clients Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <header class="section-header">
                    <h2>Contact</h2>
                    <p>Contact Us</p>
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
                                    <p>+254 743 551 250<br>+254 704 241 905</p>
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
                        <form action="ajax/login/login.php" method="post" class="">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                                </div>

                                <div class="col-md-12 ">
                                    <input type="text" class="form-control" name="phone_number" placeholder="Your Phone Number" required>
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Write a Message to us or Request demo...." required></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div><?php
                                            if (isset($_SESSION['error'])) {
                                                echo "<p class='border border-danger text-danger'>" . $_SESSION['error'] . "</p>";
                                            }
                                            if (isset($_SESSION['success'])) {
                                                echo "<p class='border border-success text-success'>" . $_SESSION['success'] . "</p>";
                                            }
                                            ?></div>
                                    <button class="btn btn-primary" type="submit">Send Message</button>
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

</body>

</html>