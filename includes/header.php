<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo SITE_NAME; ?> - Quality Education for a Bright Future">
    <meta name="keywords" content="the leads school, leads school system shahpur, education, school, learning, sargodha education">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo getSiteName(); ?></title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Dynamic Theme Colors -->
    <style>
        <?php echo getThemeCSS(); ?>
    </style>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo getLogoPath(); ?>">
</head>
<body>
    <!-- Header -->
    <header id="main-header">

        <!-- ===== BRAND BAR (top section like VU) ===== -->
        <div class="brand-bar">
            <div class="container">
                <!-- Left: Logo + Name + Tagline -->
                <a href="index.php" class="brand-identity">
                    <img src="<?php echo getLogoPath(); ?>" alt="<?php echo getSiteName(); ?> Logo" onerror="this.style.display='none'">
                    <div class="brand-text">
                        <span class="brand-name"><?php echo getSiteName(); ?></span>
                        <span class="brand-tagline">Quality Education for a Bright Future</span>
                    </div>
                </a>

                <!-- Right: Contact + Campus Login + Social -->
                <div class="brand-right">
                    <?php
                    $phone = getSitePhone();
                    $phone_numbers = explode(',', $phone);
                    $first_phone = trim($phone_numbers[0]);
                    ?>
                    <div class="brand-contact">
                        <a href="tel:<?php echo str_replace([' ', '-'], '', $first_phone); ?>">
                            <i class="fas fa-phone-alt"></i> <?php echo $first_phone; ?>
                        </a>
                        <span class="brand-contact-sep"></span>
                        <a href="mailto:<?php echo getSiteEmail(); ?>">
                            <i class="fas fa-envelope"></i> <?php echo getSiteEmail(); ?>
                        </a>
                    </div>
                    <div class="brand-actions">
                        <?php
                        $social  = getSocialMedia();
                        $fb_url  = !empty($social['facebook'])  ? htmlspecialchars($social['facebook'])  : '#';
                        $ig_url  = !empty($social['instagram']) ? htmlspecialchars($social['instagram']) : '#';
                        $yt_url  = !empty($social['youtube'])   ? htmlspecialchars($social['youtube'])   : '#';
                        $fb_target = $fb_url !== '#' ? 'target="_blank"' : '';
                        $ig_target = $ig_url !== '#' ? 'target="_blank"' : '';
                        $yt_target = $yt_url !== '#' ? 'target="_blank"' : '';
                        ?>
                        <div class="brand-social">
                            <a href="<?php echo $fb_url; ?>" <?php echo $fb_target; ?> title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="<?php echo $ig_url; ?>" <?php echo $ig_target; ?> title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="<?php echo $yt_url; ?>" <?php echo $yt_target; ?> title="YouTube"><i class="fab fa-youtube"></i></a>
                            <?php if (!empty($social['twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($social['twitter']); ?>" target="_blank" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== NAVIGATION BAR (icon + text like VU) ===== -->
        <nav id="main-nav">
            <div class="container">
                <!-- Mobile Hamburger -->
                <div class="menu-toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <ul class="nav-links" id="navLinks">
                    <li>
                        <a href="index.php">
                            <i class="fas fa-house"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <!-- About -->
                    <li class="dropdown">
                        <a href="about.php" class="dropdown-toggle">
                            <i class="fas fa-circle-info"></i>
                            <span>About <i class="fas fa-chevron-down chev"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="about.php"><i class="fas fa-university"></i> About Us</a></li>
                            <li><a href="mission-vision.php"><i class="fas fa-compass"></i> Mission & Vision</a></li>
                            <li><a href="core-values.php"><i class="fas fa-heart"></i> Core Values</a></li>
                            <li><a href="leadership.php"><i class="fas fa-users"></i> Leadership</a></li>
                        </ul>
                    </li>

                    <!-- Academics -->
                    <li class="dropdown">
                        <a href="courses.php" class="dropdown-toggle">
                            <i class="fas fa-book-open"></i>
                            <span>Academics <i class="fas fa-chevron-down chev"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="courses.php"><i class="fas fa-book-open"></i> Our Courses</a></li>
                            <li><a href="faculty.php"><i class="fas fa-chalkboard-user"></i> Faculty Members</a></li>
                            <li><a href="examination.php"><i class="fas fa-file-alt"></i> Examination</a></li>
                        </ul>
                    </li>

                    <!-- Admission -->
                    <li class="dropdown">
                        <a href="admission.php" class="dropdown-toggle">
                            <i class="fas fa-file-pen"></i>
                            <span>Admission <i class="fas fa-chevron-down chev"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="admission.php"><i class="fas fa-info-circle"></i> Admission Overview</a></li>
                            <li><a href="downloads.php"><i class="fas fa-download"></i> Downloads</a></li>
                            <li><a href="notifications.php"><i class="fas fa-bullhorn"></i> Notifications</a></li>
                        </ul>
                    </li>

                    <!-- Student Life -->
                    <li class="dropdown">
                        <a href="events.php" class="dropdown-toggle">
                            <i class="fas fa-layer-group"></i>
                            <span>Student Life <i class="fas fa-chevron-down chev"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="events.php"><i class="fas fa-calendar-alt"></i> Events</a></li>
                            <li><a href="news.php"><i class="fas fa-newspaper"></i> News</a></li>
                        </ul>
                    </li>

                    <!-- Gallery -->
                    <li class="dropdown">
                        <a href="gallery.php" class="dropdown-toggle">
                            <i class="fas fa-images"></i>
                            <span>Gallery <i class="fas fa-chevron-down chev"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="gallery.php"><i class="fas fa-th"></i> All Photos</a></li>
                            <?php foreach (getGalleryCategories() as $gcat): ?>
                            <li><a href="gallery.php?category=<?php echo urlencode($gcat['slug']); ?>"><i class="fas <?php echo htmlspecialchars($gcat['icon']); ?>"></i> <?php echo htmlspecialchars($gcat['name']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <!-- Contact -->
                    <li class="dropdown">
                        <a href="contact.php" class="dropdown-toggle">
                            <i class="fas fa-headset"></i>
                            <span>Contact <i class="fas fa-chevron-down chev"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

    </header>

    <script>
    (function() {
        var header  = document.getElementById('main-header');
        var toggle  = document.getElementById('menuToggle');
        var navList = document.getElementById('navLinks');

        // Scroll elevation
        window.addEventListener('scroll', function() {
            header.classList.toggle('scrolled', window.scrollY > 30);
        }, { passive: true });

        // Hamburger toggle
        if (toggle) {
            toggle.addEventListener('click', function() {
                toggle.classList.toggle('active');
                navList.classList.toggle('active');
            });
        }

        // Mobile: dropdown click toggle
        document.querySelectorAll('#navLinks .dropdown > a').forEach(function(a) {
            a.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    var li = this.closest('.dropdown');
                    li.classList.toggle('open');
                }
            });
        });

        // Close nav when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#main-header')) {
                navList.classList.remove('active');
                toggle && toggle.classList.remove('active');
                document.querySelectorAll('.dropdown.open').forEach(function(d) {
                    d.classList.remove('open');
                });
            }
        });

        // Highlight active nav link (top-level link, or dropdown toggle whose submenu contains the current page)
        var path = window.location.pathname.split('/').pop() || 'index.php';
        document.querySelectorAll('#navLinks > li').forEach(function(li) {
            var topLink = li.querySelector(':scope > a');
            var subLinks = li.querySelectorAll('.dropdown-menu a');
            var isActive = false;

            if (topLink) {
                var href = (topLink.getAttribute('href') || '').split('?')[0];
                if (href === path || (path === '' && href === 'index.php')) isActive = true;
            }
            subLinks.forEach(function(sub) {
                var subHref = (sub.getAttribute('href') || '').split('?')[0];
                if (subHref === path) isActive = true;
            });

            if (isActive && topLink) {
                topLink.classList.add('active');
            }
        });
    })();
    </script>
