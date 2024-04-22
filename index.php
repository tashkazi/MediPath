<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediPath - Index</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

        body {
            margin: 0;
            padding: 0;
            background: url('uploads/2019.jpg') no-repeat center top fixed;
            background-size: cover;
            color: #333;
        }

        .animated {
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .interactive:hover {
            transform: scale(1.1);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            position: fixed;
            width: 100%;
            padding: 30px 0;
            text-align: center;
            color: #fff;
            background: url('uploads/2019.jpg') no-repeat center top fixed;
            background-size: cover;
            z-index: 1000; /* Ensure header is above other content */
        }


        #logo {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .header-content {
            max-width: 600px;
            margin: 0 auto;
            font-family: retro, serif;
            position: relative;
            z-index: 1;
        }

        .header-content p {
            font-size: 18px;
            line-height: 1.6;
            color: #fff;
        }


        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        nav {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 15px 0;
            z-index: 1000;
        }

        nav ul {
            margin: 0;
            padding: 0;
            list-style: none;
            text-align: center;
        }

        #menu-container {
            padding-top: 10px;
            padding-right: 10px;
            margin-left: 5px;
            flex-grow: 1;
        }

        #menu-container ul {
            list-style: none;
            display: flex;
            justify-content: flex-end;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        #menu-container li {
            margin-left: 20px;
            position: relative;
        }

        #menu-container a {
            text-decoration: none;
            color: #ecf0f1;
            font-weight: bold;
            font-size: 16px;
            padding: 6px 15px;
            white-space: nowrap;
        }

        .login-button {
            border-radius: 5px;
            background-color: #2c3e50;
            transition: background-color 0.3s ease;
            padding: 10px 20px;
            margin-top: 10px;
            display: inline-block;
        }

        .login-button:hover {
            background-color: #2980b9;
        }

        nav ul li {
            display: inline-block;
            margin: 0 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            color: #30697c;
        }


        .main-content {
            padding: 150px 0 100px;
            text-align: center;
        }

        .info-section {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 60px;
        }
        .header-content {
            max-width: 600px;
            margin: 0 auto;
            font-family: retro, serif;
            position: relative;
            z-index: 1;
            color: #fff;
        }
        .login-button {
            border-radius: 5px;
            background-color: #30697c;
            transition: background-color 0.3s ease;
            padding: 10px 20px;
            margin-top: 10px;
            display: inline-block;
            color: #fff;
            text-decoration: none;
        }

        .login-button:hover {
            background-color: #30697c;
        }
        .header-content p {
            font-size: 24px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1; /* Added */
        }

        .info-box {
            flex: 1;
            padding: 40px;
            margin-top: 100px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-10px);
        }

        .info-box i {
            font-size: 48px;
            margin-bottom: 20px;
            color: #30697c;
        }

        .info-box h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .info-box p {
            font-size: 18px;
            color: #555;
        }

        .newsletter-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .newsletter {
            width: 100%;
            background-color: #f9f9f9;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: left;
        }

        .notice-board {
            width: 100%;
            background-color: #f9f9f9;
            padding: 5px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            text-align: left;

        }

        .newsletter h2,
        .notice-board h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .newsletter-form input[type="text"],
        .newsletter-form input[type="email"],
        .newsletter-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .newsletter-form input[type="submit"] {
            background: #30697c;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .newsletter-form input[type="submit"]:hover {
            background: #30697c;
        }

        .notice-board-content {
            position: relative;
        }

        .notice-carousel {
            overflow: hidden;
            position: relative;
        }

        .notice-carousel .notice-item {
            display: none;
        }

        .notice-carousel .notice-item:first-child {
            display: block;
        }

        .notice-carousel img {
            width: 100%;
            height: auto;
        }

        .notice-carousel-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .notice-carousel-prev,
        .notice-carousel-next {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            cursor: pointer;
        }

        .notice-carousel-prev:hover,
        .notice-carousel-next:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }


        .useful-links {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 100px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .link-group {
            flex: 1 1 300px;
            text-align: left;
            padding: 16px;
        }

        .link-group h2 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #333;
        }

        .link-group ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .link-group ul li {
            margin-bottom: 10px;
        }

        .link-group ul li a {
            color: #555;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .link-group ul li a:hover {
            color: #30697c;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        @media only screen and (max-width: 768px) {

            .newsletter-container {
                display: block;
                margin-bottom: -150px;
                justify-content: space-between;
                gap: 20px;
            }

            .newsletter {
                width: 80%;
                background-color: #f9f9f9;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                margin-left: 12px;
                margin-bottom: 10px;
                text-align: left;
            }

            .notice-board {
                width: 90%;
                background-color: #f9f9f9;
                margin-left: 18px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);

            }


            .main-content {
                padding-top: 10px;
            }

            .info-section {
                margin-top: 290px;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .info-box {
                width: calc(30.33% - 20px);
                margin: 20px;
            }

            .info-box h3 {
                font-size: 20px;
            }


            .useful-links {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }

            .link-group {
                flex: 1 1 auto;
                text-align: left;
            }

            .link-group h2 {
                margin-bottom: 10px;
                font-size: 18px;
            }

            .link-group ul {
                padding: 0;
                margin: 0;
                list-style: none;
            }

            .link-group ul li {
                margin-bottom: 5px;
            }

            .info-box:hover {
                transform: translateY(-10px);
            }


        }

    </style>
</head>
<body>
<header>
    <div class="container">
        <img src="uploads/medi.png" alt="MediPath Logo" id="logo">
        <div class="header-overlay"></div>
    </div>
    <div class="header-content animated">
        <p>Empowering Healthcare Through Innovation and Compassion</p>
        <a href="login.html" class="login-button interactive">Login</a>
    </div>
</header>


<div class="container main-content">
    <h2>Our Services</h2>
    <section class="info-section">
        <div class="info-box telehealth interactive">
            <i class="fas fa-mobile-alt"></i>
            <h3>Telehealth: The Future</h3>
            <p>Telehealth is revolutionizing healthcare delivery by providing access to medical services remotely, leading to improved patient outcomes and reduced healthcare costs.</p>
        </div>
        <div class="info-box benefits interactive">
            <i class="fas fa-medkit"></i>
            <h3>Benefits of Technology</h3>
            <p>Advanced healthcare technology, such as electronic health records and telemedicine platforms, enhances communication between patients and providers, resulting in more personalized care and better treatment outcomes.</p>
        </div>
        <div class="info-box preventive interactive">
            <i class="fas fa-heartbeat"></i>
            <h3>Preventive Healthcare</h3>
            <p>Preventive healthcare focuses on proactive measures to maintain overall health and prevent the onset of diseases. By promoting healthy lifestyles and early detection, preventive healthcare reduces the burden on the healthcare system and improves public health.</p>
        </div>
    </section>
</div>

<div class="container main-content">
    <div class="newsletter-container">
        <div class="newsletter animated">
            <h2>Subscribe to our Newsletter</h2>
            <div class="newsletter-form">
                <form action="/action_page.php">
                    <input type="text" placeholder="Name" name="name" required>
                    <input type="email" placeholder="Email address" name="mail" required>
                    <input type="submit" value="Subscribe" class="interactive">
                </form>
            </div>
        </div>

        <div class="notice-board animated">
            <div class="notice-board-content">
                <div class="notice-carousel">
                    <div class="notice-item interactive">
                        <img src="uploads/notice3.png" alt="Notice 1">
                    </div>
                    <div class="notice-item interactive">
                        <img src="uploads/notice.jpg" alt="Notice 2">
                    </div>
                    <div class="notice-item interactive">
                        <img src="uploads/notice1.jpg" alt="Notice 3">
                    </div>
                </div>
                <div class="notice-carousel-controls">
                    <div class="notice-carousel-prev"><i class="fas fa-chevron-left"></i></div>
                    <div class="notice-carousel-next"><i class="fas fa-chevron-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="useful-links animated">
    <div class="link-group">
        <h2>Services</h2>
        <ul>
            <li><a href="services.html">Primary Care Consultation</a></li>
            <li><a href="services.html">Specialist Referrals</a></li>
            <li><a href="services.html">Diagnostic Tests</a></li>
            <li><a href="services.html">Telemedicine Visits</a></li>
            <li><a href="services.html">Prescription Refills</a></li>
            <li><a href="services.html">In-Person Visits</a></li>
        </ul>
    </div>

    <div class="link-group">

        <h2>Join our Team</h2>
        <ul>
            <li><a href="careers.html">Careers</a></li>
            <li><a href="providerRegistration.html">Provider Application</a></li>
            <li><a href="adminRegistration.html">Administration Application</a></li>
            <li><a href="#">Provider FAQs</a></li>
        </ul>
    </div>

    <div class="link-group">
        <h2>Meet our Team</h2>
        <ul>
            <li><a href="doctors.html">Get to Know our Staff</a></li>
        </ul>
    </div>

    <div class="link-group">
        <h2>About MediPath</h2>
        <ul>
            <li><a href="aboutus.html">Company Overview</a></li>
            <li><a href="aboutus.html">Mission & Vision</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><i class="fas fa-phone"></i> <a href="tel:7789513966">778 951 3966</a></li>
            <li><i class="fas fa-envelope"></i> <a href="mailto:tashreeka.kazi@student.kpu.ca">tashreeka.kazi@student.kpu.ca</a></li>
        </ul>
    </div>

    <div class="link-group">
        <h2>Find us on:</h2>
        <ul>
            <li><i class="fab fa-instagram interactive"></i> <a href="#">Instagram</a></li>
            <li><i class="fab fa-facebook-f interactive"></i> <a href="#">Facebook</a></li>
            <li><i class="fab fa-twitter interactive"></i> <a href="#">Twitter</a></li>
        </ul>
    </div>
</div>

<footer class="animated">
    <div class="container">
        <p>&copy; 2024 MediPath. All rights reserved.</p>
    </div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentIndex = 0;
        var items = document.querySelectorAll('.notice-carousel .notice-item');

        function showItem(index) {
            if (index >= 0 && index < items.length) {
                items.forEach(function(item) {
                    item.style.display = 'none';
                });
                items[index].style.display = 'block';
                currentIndex = index;
            }
        }

        function nextItem() {
            currentIndex++;
            if (currentIndex >= items.length) {
                currentIndex = 0;
            }
            showItem(currentIndex);
        }

        function prevItem() {
            currentIndex--;
            if (currentIndex < 0) {
                currentIndex = items.length - 1;
            }
            showItem(currentIndex);
        }

        var prevButton = document.querySelector('.notice-carousel-prev');
        var nextButton = document.querySelector('.notice-carousel-next');

        if (prevButton && nextButton) {
            prevButton.addEventListener('click', function() {
                prevItem();
            });

            nextButton.addEventListener('click', function() {
                nextItem();
            });
        }
    });


    document.addEventListener("DOMContentLoaded", function() {
        var dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(function(dropdown) {
            dropdown.style.display = 'none';
        });

        var joinTeam = document.querySelector(".dropdown");
        var dropdownContent = joinTeam.querySelector(".dropdown-content");

        joinTeam.addEventListener("mouseenter", function() {
            dropdownContent.style.display = "block";
        });

        joinTeam.addEventListener("mouseleave", function() {
            dropdownContent.style.display = "none";
        });
    });
</script>

</body>
</html>
