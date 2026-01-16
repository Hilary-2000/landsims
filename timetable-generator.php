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
                    <li><a class="nav-link scrollto" href="#values">Why Choose Us</a></li>
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
                    <h2 data-aos="fade-up" data-aos-delay="400">Generate conflict free class, block and teacher timetable online in just a few minutes using our robust timetable generator. <br>In just <span class="badge bg-success">5 simple</span> steps your timetable will be ready.</h2>
                    <div data-aos="fade-up" data-aos-delay="600">
                        <div class="text-center text-lg-start">
                            <a href="timetable-signup.php" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>Create an Account</span>
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
                            <p><b>Note:</b><br> Suitable for primary schools, junior and senior secondary schools <u><b>excluding</b></u> tertiary institutions.</p>
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
                                    <p>Register all teaching staff and all learning areas to be included in the timetable.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">03</div>
                                <div class="step-content">
                                    <h3>Subject/Learning Areas Assignment</h3>
                                    <p>Assign learning areas to teachers teaching them and their respective grades.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">04</div>
                                <div class="step-content">
                                    <h3>Generate Timetable</h3>
                                    <p>Once you have your data setup use the timetable wizard to generate your timetable.</p>
                                </div>
                            </div>

                            <div class="step-item">
                                <div class="step-number">05</div>
                                <div class="step-content">
                                    <h3>Share Timetable</h3>
                                    <p>Share via email your generated timetable with teachers, students, and the administrative circle.</p>
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
                            <img src="assets/img/features-2.png" class="img-fluid" alt="">
                            <h3>Conflict Free</h3>
                            <p>Our timetable generator prevents scheduling conflicts by ensuring no teacher is teaching a subjects in two or more classes at a go.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
                        <div class="box">
                            <img src="assets/img/features.png" class="img-fluid" alt="">
                            <h3>Set Up Once Use forever</h3>
                            <p>Once you set up your information, you use it forever without initial setup everytime you want to generate your timetable.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="600">
                        <div class="box">
                            <img src="assets/img/sharable.png" class="img-fluid" alt="">
                            <h3>Sharability</h3>
                            <p>Ability to share your timetable with teachers, students, and the administrative circle in just one click via the e-mail. You can also download the pdf file on your device.</p>
                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- End Values Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing container">

            <div class="container " data-aos="fade-up">

                <header class="section-header">
                    <h2>Pricing</h2>
                    <p>Check our Pricing</p>
                </header>

                <div class="row gy-4" data-aos="fade-left">

                    <div class="col-lg-3 col-md-6 d-none" data-aos="zoom-in" data-aos-delay="100">
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

                    <div class="col-lg-3 col-md-6 d-none" data-aos="zoom-in" data-aos-delay="300">
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
                    <div class="col-lg-4 col-md-6"></div>
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                        <div class="box">
                            <h3 style="color: #ff0071;">Ultimate Plan</h3>
                            <div class="price"><sup>Kes</sup>200<span> / gen</span></div>
                            <img src="assets/img/pricing-ultimate.png" class="img-fluid" alt="">
                            <ul>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Generate Timetable</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> E-Mail timetable to teachers</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Regenerate up-to 3 times</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Download timetable in pdf</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> In app customizations</li>
                                <li style="font-size:12px; font-weight:700;"><i class="bi bi-check"></i> Shared Lessons configuration</li>
                            </ul>
                            <a href="timetable-signup.php" class="btn-buy">Start Now</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6"></div>
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
                                        What is a timetable generator?
                                    </button>
                                </h2>
                                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        is a system that automatically creates school timetables by assigning teachers, subjects, classes, and periods without clashes, saving time and eliminating manual errors.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                                        Is the timetable generator CBC-compliant?
                                    </button>
                                </h2>
                                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        Yes. The timetable generator is designed to support CBC learning areas, correct lesson allocations, and grade-based requirements as guided by KICD, including junior secondary and primary levels.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-3">
                                        Does it prevent teacher and class clashes?
                                    </button>
                                </h2>
                                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        Yes. The system ensures:
                                        <ul>
                                            <li>A teacher is not assigned to more than one class at the same time</li>
                                            <li>A class does not have two subjects in the same period</li>
                                            <li>Rooms and learning areas are not double-booked</li>
                                        </ul>

                                        This guarantees a conflict-free timetable.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-4">
                                        How much does it cost?
                                    </button>
                                </h2>
                                <div id="faq-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        The system costs only Kes 200 for one timetable set-up. You can re-generate up to 3 versions of the timetable with the same data setup.
                                        You can send the timetable to anyone via e-mail and also download it in pdf format at any time.
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
                                        Can it generate timetables for junior secondary (Grade 7–9)?
                                    </button>
                                </h2>
                                <div id="faq2-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        Absolutely. The system fully supports Junior Secondary School (JSS) requirements, including subject combinations and teacher specialization.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-2">
                                        How long does it take to generate a timetable?
                                    </button>
                                </h2>
                                <div id="faq2-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        In most cases, a complete timetable is generated within seconds, depending on the size of the school and the number of constraints.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-3">
                                        Can the timetable be edited manually?
                                    </button>
                                </h2>
                                <div id="faq2-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        Yes. After generation, administrators can manually adjust lessons to accommodate special school needs such as assemblies, clubs, or remedial classes.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-4">
                                        Can the timetable be shared with teachers?
                                    </button>
                                </h2>
                                <div id="faq2-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        Yes. Timetables can be:
                                        <ul>
                                            <li>E-mailed directly to teachers</li>
                                            <li>Downloaded as PDF files for distribution</li>
                                            <li>Viewed online by the administrator</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-5">
                                    Can I get the full school management system with unlimited timetable generations?
                                </button>
                            </h2>
                            <div id="faq-content-5" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                    Absolutely, you can get the system with unlimited timetable generations along with other modules such as admissions, financial management, academic management, communication module and many more for just 2500 per term per module. Contact us via email at <a href="mailto:mail@ladybirdsmis.com">mail@ladybirdsmis.com</a> or download our proposal that has all the information you need.
                                    <a target="_blank" href="https://drive.google.com/drive/folders/1lPkZsdq2ryUTAQLIfnWbecSYB3VqZXbB?usp=sharing">Download Proposal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <!-- End F.A.Q Section -->
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