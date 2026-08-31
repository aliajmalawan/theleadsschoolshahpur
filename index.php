<?php
require_once 'includes/config.php';
$page_title = 'Home';
?>
<?php include 'includes/header.php'; ?>

<!-- ===== HERO CAROUSEL - FULLY ANIMATED ===== -->
<?php $carousel_slides = getHeroCarouselSlides(); ?>

<style>
/* ── Carousel Base ── */
.hero-carousel { position:relative; min-height:620px; overflow:hidden; }

.carousel-slide {
    position:absolute; top:0; left:0; width:100%; height:100%;
    min-height:620px; display:flex; align-items:center;
    opacity:0; transition:opacity 1.2s ease-in-out;
    will-change:opacity;
}
.carousel-slide.active { opacity:1; }

/* ── All animated children start invisible ── */
.cs-badge, .cs-title, .cs-sub, .cs-btns { opacity:0; }

/* ── ENTRY ANIMATIONS (triggered by .hero-play class) ── */

/* Badge: drop + bounce from top */
.hero-play .cs-badge {
    animation: anim-badge 0.75s cubic-bezier(0.34,1.56,0.64,1) 0.05s both;
}
@keyframes anim-badge {
    0%   { opacity:0; transform:translateY(-32px) scale(0.75); }
    100% { opacity:1; transform:translateY(0)     scale(1);    }
}

/* Title words: each word blurs + rises, staggered via JS */
.cs-title .hw {
    display:inline-block;
    opacity:0;
    will-change:transform,opacity,filter;
}
.hero-play .cs-title .hw {
    animation: anim-word 0.65s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes anim-word {
    0%   { opacity:0; transform:translateY(55px) skewY(4deg); filter:blur(8px); }
    100% { opacity:1; transform:translateY(0)    skewY(0);    filter:blur(0);   }
}

/* Subtitle: slide in from left */
.hero-play .cs-sub {
    animation: anim-sub 0.7s cubic-bezier(0.25,1,0.5,1) 0.78s both;
}
@keyframes anim-sub {
    0%   { opacity:0; transform:translateX(-45px); }
    100% { opacity:1; transform:translateX(0);     }
}

/* Buttons: scale + bounce up */
.hero-play .cs-btns {
    animation: anim-btns 0.65s cubic-bezier(0.34,1.56,0.64,1) 1.0s both;
}
@keyframes anim-btns {
    0%   { opacity:0; transform:scale(0.72) translateY(24px); }
    100% { opacity:1; transform:scale(1)    translateY(0);    }
}

/* ── IDLE / CONTINUOUS ANIMATIONS (after .hero-idle class) ── */

/* Badge shimmer sweep */
.hero-idle .cs-badge {
    animation: idle-badge-glow 3s 0s ease-in-out infinite !important;
}
@keyframes idle-badge-glow {
    0%,100% { box-shadow:0 0 0 0 rgba(245,130,32,0);  }
    50%      { box-shadow:0 0 18px 4px rgba(245,130,32,0.35); }
}

/* Apply button soft float */
.hero-idle .cs-btn-apply {
    animation: idle-btn-float 2.4s ease-in-out infinite !important;
}
@keyframes idle-btn-float {
    0%,100% { transform:translateY(0)   scale(1);    }
    50%     { transform:translateY(-7px) scale(1.03); }
}

/* Outline button shimmer border */
.hero-idle .cs-btn-outline {
    animation: idle-outline-pulse 3s 0.5s ease-in-out infinite !important;
}
@keyframes idle-outline-pulse {
    0%,100% { border-color:rgba(255,255,255,0.65); }
    50%     { border-color:rgba(255,255,255,1);    box-shadow:0 0 14px rgba(255,255,255,0.2); }
}

/* ── Navigation arrows ── */
.carousel-prev, .carousel-next {
    position:absolute; top:50%; transform:translateY(-50%); z-index:10;
    background:rgba(255,255,255,0.12); backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.2); color:white;
    width:52px; height:52px; border-radius:50%; font-size:20px;
    cursor:pointer; transition:all 0.3s ease; display:flex;
    align-items:center; justify-content:center;
}
.carousel-prev { left:22px; }
.carousel-next { right:22px; }
.carousel-prev:hover, .carousel-next:hover {
    background:rgba(245,130,32,0.3) !important;
    border-color:var(--accent-color) !important;
    transform:translateY(-50%) scale(1.08);
}

/* ── Progress bar at bottom ── */
.carousel-progress-bar {
    position:absolute; bottom:0; left:0; height:3px;
    background:var(--accent-color); width:0%; z-index:11;
    transition:width 0.1s linear; opacity:0.85;
    border-radius:0 2px 2px 0;
}

/* ── Dots ── */
.carousel-dot:hover { background:rgba(255,255,255,0.8) !important; }

/* ── Background floating shapes (CSS only) ── */
.cs-shape {
    position:absolute; border-radius:50%;
    pointer-events:none; opacity:0.06;
}
.cs-shape-1 {
    width:340px; height:340px; background:var(--accent-color);
    top:-80px; right:-80px;
    animation:shape-drift 12s ease-in-out infinite alternate;
}
.cs-shape-2 {
    width:260px; height:260px; background:#fff;
    bottom:-70px; left:-50px;
    animation:shape-drift 10s 2s ease-in-out infinite alternate-reverse;
}
.cs-shape-3 {
    width:180px; height:180px; background:var(--primary-color);
    top:30%; right:8%; opacity:0.04;
    animation:shape-drift 8s 1s ease-in-out infinite alternate;
}
@keyframes shape-drift {
    from { transform:translate(0,0) scale(1);    }
    to   { transform:translate(20px,15px) scale(1.1); }
}

/* ── Title opacity fix: parent must be visible so word-spans can show ── */
.hero-play .cs-title { opacity:1; }

/* ── Responsive ── */
@media (max-width:768px) {
    .carousel-slide { min-height:500px !important; }
    .cs-title-text  { font-size:36px !important; letter-spacing:-0.3px !important; }
    .cs-sub-text    { font-size:16px !important; }
    .carousel-prev, .carousel-next { width:40px; height:40px; font-size:16px; }
    .cs-shape { display:none; }
}
@media (max-width:480px) {
    .cs-title-text { font-size:28px !important; }
}
</style>

<section class="hero-carousel">
<?php if (!empty($carousel_slides)): ?>

    <?php foreach ($carousel_slides as $index => $slide):
        $txt = htmlspecialchars($slide['text_color'] ?? '#ffffff');
    ?>
    <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>"
         style="background:linear-gradient(rgba(8,29,64,0.60),rgba(8,29,64,0.72)),
                url('<?php echo htmlspecialchars($slide['image_path']); ?>') center/cover no-repeat;">

        <!-- Floating shapes -->
        <div class="cs-shape cs-shape-1"></div>
        <div class="cs-shape cs-shape-2"></div>
        <div class="cs-shape cs-shape-3"></div>

        <div class="container" style="position:relative;z-index:2;text-align:center;padding:50px 24px;">
            <div style="max-width:880px;margin:0 auto;">

                <!-- Badge -->
                <div class="cs-badge" style="display:inline-flex;align-items:center;gap:8px;background:rgba(245,130,32,0.14);border:1px solid rgba(245,130,32,0.35);color:var(--accent-color);padding:8px 22px;border-radius:50px;font-size:11.5px;font-weight:700;letter-spacing:2.2px;text-transform:uppercase;margin-bottom:26px;backdrop-filter:blur(8px);">
                    <i class="fas fa-graduation-cap" style="font-size:10px;"></i>
                    <?php echo getSiteName(); ?>
                </div>

                <!-- Heading (words split by JS) -->
                <h1 class="cs-title cs-title-text"
                    style="font-size:58px;font-weight:800;margin-bottom:22px;color:<?php echo $txt; ?>;text-shadow:0 4px 24px rgba(0,0,0,0.45);line-height:1.15;letter-spacing:-0.5px;">
                    <?php echo htmlspecialchars($slide['title'] ?: 'Welcome to ' . getSiteName()); ?>
                </h1>

                <?php if (!empty($slide['subtitle'])): ?>
                <p class="cs-sub cs-sub-text"
                   style="font-size:20px;margin-bottom:34px;color:rgba(255,255,255,0.88);font-weight:400;line-height:1.65;max-width:680px;margin-left:auto;margin-right:auto;">
                    <?php echo htmlspecialchars($slide['subtitle']); ?>
                </p>
                <?php else: ?>
                <p class="cs-sub" style="margin-bottom:34px;"></p>
                <?php endif; ?>

                <!-- Buttons -->
                <div class="cs-btns btn-group" style="justify-content:center;gap:18px;">
                    <a href="admission.php" class="btn btn-primary cs-btn-apply" style="padding:15px 44px;font-size:16px;font-weight:700;">
                        <i class="fas fa-graduation-cap"></i> Apply Now
                    </a>
                    <a href="about.php" class="btn btn-outline cs-btn-outline" style="padding:15px 44px;font-size:16px;">
                        Discover More <i class="fas fa-arrow-right" style="font-size:13px;"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Dots -->
    <div style="position:absolute;bottom:22px;left:50%;transform:translateX(-50%);z-index:10;display:flex;gap:10px;align-items:center;">
        <?php foreach ($carousel_slides as $index => $slide): ?>
            <button class="carousel-dot <?php echo $index === 0 ? 'active' : ''; ?>"
                    data-slide="<?php echo $index; ?>"
                    style="width:<?php echo $index === 0 ? '28px' : '10px'; ?>;height:10px;border-radius:5px;border:none;background:<?php echo $index === 0 ? 'var(--accent-color)' : 'rgba(255,255,255,0.35)'; ?>;cursor:pointer;transition:all 0.35s;"></button>
        <?php endforeach; ?>
    </div>

    <!-- Arrows -->
    <button class="carousel-prev">&#8249;</button>
    <button class="carousel-next">&#8250;</button>

    <!-- Progress bar -->
    <div class="carousel-progress-bar" id="heroProgressBar"></div>

<?php else: ?>
    <!-- Fallback -->
    <?php $hero = getHeroContent(); ?>
    <div class="carousel-slide active hero-play hero-idle"
         style="background:linear-gradient(rgba(8,29,64,0.65),rgba(8,29,64,0.75)),url('<?php echo htmlspecialchars($hero['image']); ?>') center/cover no-repeat;">
        <div class="container" style="text-align:center;padding:50px 24px;position:relative;z-index:2;">
            <div style="max-width:880px;margin:0 auto;">
                <div class="cs-badge" style="display:inline-flex;align-items:center;gap:8px;background:rgba(245,130,32,0.14);border:1px solid rgba(245,130,32,0.35);color:var(--accent-color);padding:8px 22px;border-radius:50px;font-size:11.5px;font-weight:700;letter-spacing:2.2px;text-transform:uppercase;margin-bottom:26px;">
                    <i class="fas fa-graduation-cap" style="font-size:10px;"></i>
                    <?php echo getSiteName(); ?>
                </div>
                <h1 class="cs-title cs-title-text" style="font-size:58px;font-weight:800;margin-bottom:22px;color:#fff;text-shadow:0 4px 24px rgba(0,0,0,0.45);line-height:1.15;">
                    Welcome to <?php echo getSiteName(); ?>
                </h1>
                <p class="cs-sub cs-sub-text" style="font-size:20px;margin-bottom:34px;color:rgba(255,255,255,0.88);line-height:1.65;max-width:680px;margin-left:auto;margin-right:auto;">
                    <?php echo htmlspecialchars($hero['description']); ?>
                </p>
                <div class="cs-btns btn-group" style="justify-content:center;gap:18px;">
                    <a href="<?php echo htmlspecialchars($hero['button_link']); ?>" class="btn btn-primary cs-btn-apply" style="padding:15px 44px;font-size:16px;font-weight:700;">
                        <i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($hero['button_text']); ?>
                    </a>
                    <a href="about.php" class="btn btn-outline cs-btn-outline" style="padding:15px 44px;font-size:16px;">
                        Learn More <i class="fas fa-arrow-right" style="font-size:13px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Split heading words into animated spans ── */
    document.querySelectorAll('.cs-title').forEach(function (title) {
        var raw = title.textContent.trim();
        title.innerHTML = raw.split(/\s+/).map(function (word, i) {
            return '<span class="hw" style="animation-delay:' + (0.22 + i * 0.13) + 's">'
                + word + '&nbsp;</span>';
        }).join('');
    });

    var slides    = document.querySelectorAll('.carousel-slide');
    var dots      = document.querySelectorAll('.carousel-dot');
    var prevBtn   = document.querySelector('.carousel-prev');
    var nextBtn   = document.querySelector('.carousel-next');
    var progBar   = document.getElementById('heroProgressBar');
    var current   = 0;
    var total     = slides.length;
    var INTERVAL  = 5800;
    var idleTimer = null;
    var progTimer = null;

    /* ── Play animations on a slide ── */
    function playSlide(slide) {
        /* reset: strip classes, force reflow, re-add */
        slide.classList.remove('hero-play', 'hero-idle');
        void slide.offsetWidth;
        slide.classList.add('hero-play');

        clearTimeout(idleTimer);
        idleTimer = setTimeout(function () {
            slide.classList.add('hero-idle');
        }, 2200);
    }

    /* ── Animate progress bar ── */
    function startProgress() {
        if (!progBar) return;
        clearInterval(progTimer);
        progBar.style.transition = 'none';
        progBar.style.width = '0%';
        void progBar.offsetWidth;
        progBar.style.transition = 'width ' + INTERVAL + 'ms linear';
        progBar.style.width = '100%';
    }

    /* ── Show a slide ── */
    function showSlide(idx) {
        slides.forEach(function (s) {
            s.style.opacity = '0';
            s.classList.remove('active', 'hero-play', 'hero-idle');
        });
        dots.forEach(function (d) {
            d.style.background = 'rgba(255,255,255,0.35)';
            d.style.width = '10px';
            d.classList.remove('active');
        });

        slides[idx].style.opacity = '1';
        slides[idx].classList.add('active');
        if (dots[idx]) {
            dots[idx].style.background = 'var(--accent-color)';
            dots[idx].style.width = '28px';
            dots[idx].classList.add('active');
        }

        playSlide(slides[idx]);
        startProgress();
    }

    function next() { current = (current + 1) % total; showSlide(current); }
    function prev() { current = (current - 1 + total) % total; showSlide(current); }

    /* ── Auto-play ── */
    var auto = null;
    function startAuto() { auto = setInterval(next, INTERVAL); }
    function stopAuto()  { clearInterval(auto); }

    /* ── Init first slide ── */
    if (total > 0) {
        playSlide(slides[0]);
        startProgress();
        if (total > 1) startAuto();
    }

    /* ── Controls ── */
    if (nextBtn) nextBtn.addEventListener('click', function () { next(); stopAuto(); startAuto(); });
    if (prevBtn) prevBtn.addEventListener('click', function () { prev(); stopAuto(); startAuto(); });

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () {
            current = i; showSlide(current); stopAuto(); startAuto();
        });
    });

    /* ── Pause on hover ── */
    var section = document.querySelector('.hero-carousel');
    if (section) {
        section.addEventListener('mouseenter', function () { stopAuto(); });
        section.addEventListener('mouseleave', function () { if (total > 1) startAuto(); });
    }

    /* ── Keyboard support ── */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') { next(); stopAuto(); startAuto(); }
        if (e.key === 'ArrowLeft')  { prev(); stopAuto(); startAuto(); }
    });

    /* ── Touch / swipe support ── */
    var touchX = 0;
    if (section) {
        section.addEventListener('touchstart', function (e) { touchX = e.changedTouches[0].screenX; }, {passive:true});
        section.addEventListener('touchend', function (e) {
            var diff = touchX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) { diff > 0 ? next() : prev(); stopAuto(); startAuto(); }
        }, {passive:true});
    }
});
</script>

<!-- ===== NOTIFICATIONS TICKER ===== -->
<?php
$notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE status = 'active' ORDER BY display_order ASC LIMIT 10");
if ($notifications && mysqli_num_rows($notifications) > 0):
?>
<div style="background:#fff;border-bottom:1px solid rgba(11,77,162,0.1);overflow:hidden;position:relative;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
    <div style="display:flex;align-items:stretch;">
        <div style="background:linear-gradient(135deg,var(--primary-color),#1565C0);color:white;padding:13px 26px;font-weight:700;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;display:flex;align-items:center;gap:9px;flex-shrink:0;z-index:2;">
            <i class="fas fa-bullhorn" style="font-size:14px;color:var(--accent-color);"></i> Notifications
        </div>
        <div style="overflow:hidden;width:100%;display:flex;align-items:center;padding:0 20px;">
            <div class="notification-ticker" style="display:flex;animation:tickerScroll 30s linear infinite;white-space:nowrap;">
                <?php
                while ($notif = mysqli_fetch_assoc($notifications)) {
                    $tag = $notif['link'] ? 'a href="' . htmlspecialchars($notif['link']) . '"' : 'span';
                    $close = $notif['link'] ? 'a' : 'span';
                    echo '<' . $tag . ' style="color:var(--text-dark);text-decoration:none;font-size:13.5px;font-weight:500;padding:0 40px;display:inline-flex;align-items:center;gap:10px;">';
                    echo '<span style="width:7px;height:7px;border-radius:50%;background:var(--accent-color);flex-shrink:0;"></span>';
                    echo htmlspecialchars($notif['title']);
                    echo '</' . $close . '>';
                }
                mysqli_data_seek($notifications, 0);
                while ($notif = mysqli_fetch_assoc($notifications)) {
                    $tag = $notif['link'] ? 'a href="' . htmlspecialchars($notif['link']) . '"' : 'span';
                    $close = $notif['link'] ? 'a' : 'span';
                    echo '<' . $tag . ' style="color:var(--text-dark);text-decoration:none;font-size:13.5px;font-weight:500;padding:0 40px;display:inline-flex;align-items:center;gap:10px;">';
                    echo '<span style="width:7px;height:7px;border-radius:50%;background:var(--accent-color);flex-shrink:0;"></span>';
                    echo htmlspecialchars($notif['title']);
                    echo '</' . $close . '>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<style>
@keyframes tickerScroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.notification-ticker:hover { animation-play-state: paused; }
</style>
<?php endif; ?>

<!-- ===== STATS SECTION - MODERN ===== -->
<?php $stats = getStatistics(); ?>

<style>
/* Stats Modern */
.stats-modern {
    background: linear-gradient(135deg, var(--primary-color) 0%, #0A2449 55%, #081D40 100%);
    padding: 70px 0 100px;
    position: relative;
    overflow: hidden;
}
/* Decorative background shapes */
.stats-modern .sm-blob1 {
    position:absolute;top:-100px;right:-80px;
    width:380px;height:380px;border-radius:50%;
    background:rgba(255,255,255,0.03);pointer-events:none;
}
.stats-modern .sm-blob2 {
    position:absolute;bottom:-120px;left:-80px;
    width:320px;height:320px;border-radius:50%;
    background:rgba(245,130,32,0.05);pointer-events:none;
}
.stats-modern .sm-blob3 {
    position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
    width:600px;height:600px;border-radius:50%;
    background:rgba(255,255,255,0.015);pointer-events:none;
}
/* Top label */
.sm-label {
    display:inline-flex;align-items:center;gap:7px;
    background:rgba(255,255,255,0.1);
    border:1px solid rgba(255,255,255,0.18);
    color:rgba(255,255,255,0.85);
    font-size:11px;font-weight:700;letter-spacing:2.5px;
    text-transform:uppercase;padding:6px 18px;border-radius:50px;
    margin-bottom:10px;backdrop-filter:blur(6px);
}
.sm-title {
    font-size:34px;font-weight:800;color:#fff;
    margin-bottom:55px;line-height:1.2;
}
.sm-title em {
    font-style:normal;color:var(--accent-color);
    position:relative;
}
/* Cards grid */
.sm-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:22px;
    position:relative;z-index:1;
}
/* Individual glass card */
.sm-card {
    background:rgba(255,255,255,0.07);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,0.12);
    border-radius:22px;
    padding:36px 24px 32px;
    text-align:center;
    position:relative;
    overflow:hidden;
    transition:all 0.35s cubic-bezier(0.4,0,0.2,1);
    cursor:default;
    opacity:0;
    transform:translateY(30px);
}
.sm-card.sm-visible {
    opacity:1;transform:translateY(0);
}
.sm-card:hover {
    background:rgba(255,255,255,0.12);
    border-color:rgba(255,255,255,0.22);
    transform:translateY(-8px);
    box-shadow:0 20px 50px rgba(0,0,0,0.2);
}
/* Top gold accent line */
.sm-card::before {
    content:'';
    position:absolute;top:0;left:20%;right:20%;height:3px;
    background:linear-gradient(90deg,transparent,var(--accent-color),transparent);
    border-radius:0 0 3px 3px;
    transform:scaleX(0);
    transition:transform 0.4s ease;
}
.sm-card:hover::before { transform:scaleX(1); }
/* Icon circle */
.sm-icon {
    width:68px;height:68px;
    background:linear-gradient(135deg,var(--accent-color),var(--accent-dark));
    border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    margin:0 auto 20px;
    font-size:26px;color:#fff;
    box-shadow:0 8px 24px rgba(245,130,32,0.35);
    transition:transform 0.35s ease, box-shadow 0.35s ease;
}
.sm-card:hover .sm-icon {
    transform:scale(1.12) rotate(-6deg);
    box-shadow:0 12px 32px rgba(245,130,32,0.5);
}
/* Number */
.sm-number {
    display:block;
    font-size:54px;font-weight:800;
    color:var(--accent-color);
    line-height:1;letter-spacing:-1px;
    margin-bottom:10px;
}
/* Thin divider */
.sm-divider {
    width:36px;height:2px;
    background:rgba(255,255,255,0.2);
    margin:12px auto;border-radius:2px;
    transition:width 0.35s ease,background 0.35s ease;
}
.sm-card:hover .sm-divider {
    width:60px;background:var(--accent-color);
}
/* Label */
.sm-text {
    font-size:15px;font-weight:600;color:#fff;
    margin:0;letter-spacing:0.3px;
}
/* Sub text */
.sm-sub {
    font-size:12px;color:rgba(255,255,255,0.5);
    margin:5px 0 0;
    font-weight:400;
}
/* Bottom SVG wave */
.stats-wave {
    position:absolute;bottom:0;left:0;right:0;
    line-height:0;
}
.stats-wave svg { display:block;width:100%; }
/* Responsive */
@media (max-width:900px) {
    .sm-grid { grid-template-columns:repeat(2,1fr);gap:16px; }
    .sm-number { font-size:44px; }
}
@media (max-width:480px) {
    .sm-grid { grid-template-columns:repeat(2,1fr);gap:12px; }
    .sm-card { padding:28px 16px 24px; }
    .sm-number { font-size:38px; }
    .sm-title { font-size:26px; }
    .sm-icon { width:56px;height:56px;font-size:22px; }
}
</style>

<section class="stats-modern">
    <div class="sm-blob1"></div>
    <div class="sm-blob2"></div>
    <div class="sm-blob3"></div>

    <?php $stats_header = getStatsHeader(); ?>
    <div class="container" style="position:relative;z-index:1;text-align:center;">
        <span class="sm-label">
            <i class="fas fa-chart-bar" style="font-size:11px;"></i> <?php echo htmlspecialchars($stats_header['badge']); ?>
        </span>
        <h2 class="sm-title"><?php echo renderHighlightedTitle($stats_header['title'], $stats_header['highlight']); ?></h2>

        <div class="sm-grid">
            <!-- Students -->
            <div class="sm-card sm-animate">
                <div class="sm-icon"><i class="fas fa-user-graduate"></i></div>
                <span class="sm-number sm-count" data-target="<?php echo intval($stats['students']); ?>">0</span>
                <div class="sm-divider"></div>
                <p class="sm-text">Active Students</p>
                <p class="sm-sub"><?php echo htmlspecialchars($stats_header['sub_students']); ?></p>
            </div>
            <!-- Teachers -->
            <div class="sm-card sm-animate" style="transition-delay:0.1s;">
                <div class="sm-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <span class="sm-number sm-count" data-target="<?php echo intval($stats['teachers']); ?>">0</span>
                <div class="sm-divider"></div>
                <p class="sm-text">Expert Teachers</p>
                <p class="sm-sub"><?php echo htmlspecialchars($stats_header['sub_teachers']); ?></p>
            </div>
            <!-- Board Pass Rate -->
            <div class="sm-card sm-animate" style="transition-delay:0.2s;">
                <div class="sm-icon"><i class="fas fa-award"></i></div>
                <span class="sm-number sm-count" data-target="<?php echo intval($stats['courses']); ?>" data-suffix="%">0</span>
                <div class="sm-divider"></div>
                <p class="sm-text">Board Pass Rate</p>
                <p class="sm-sub"><?php echo htmlspecialchars($stats_header['sub_courses']); ?></p>
            </div>
            <!-- Years -->
            <div class="sm-card sm-animate" style="transition-delay:0.3s;">
                <div class="sm-icon"><i class="fas fa-trophy"></i></div>
                <span class="sm-number sm-count" data-target="<?php echo intval($stats['years']); ?>">0</span>
                <div class="sm-divider"></div>
                <p class="sm-text">Years of Excellence</p>
                <p class="sm-sub"><?php echo htmlspecialchars($stats_header['sub_years']); ?></p>
            </div>
        </div>
    </div>

    <!-- Wave separator -->
    <div class="stats-wave">
        <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,30 C240,60 480,0 720,30 C960,60 1200,0 1440,30 L1440,60 L0,60 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

<script>
(function(){
    var cards = document.querySelectorAll('.sm-animate');
    if (!cards.length) return;

    var io = new IntersectionObserver(function(entries){
        entries.forEach(function(entry){
            if (!entry.isIntersecting) return;
            var card = entry.target;
            card.classList.add('sm-visible');

            // Animate counter
            var el = card.querySelector('.sm-count');
            if (el && !el.dataset.done) {
                el.dataset.done = '1';
                var target = parseInt(el.dataset.target) || 0;
                var suffix = el.dataset.suffix || '+';
                var start = 0;
                var dur = 1800;
                var step = target / (dur / 16);
                var timer = setInterval(function(){
                    start += step;
                    if (start >= target) {
                        el.textContent = target + suffix;
                        clearInterval(timer);
                    } else {
                        el.textContent = Math.floor(start) + suffix;
                    }
                }, 16);
            }
            io.unobserve(card);
        });
    }, { threshold: 0.25 });

    cards.forEach(function(c){ io.observe(c); });
})();
</script>

<!-- ===== DIGITAL MANAGEMENT SYSTEM ===== -->
<style>
.dms-section {
    padding:90px 0 80px;
    background:linear-gradient(160deg,var(--bg-light) 0%,#ffffff 52%,var(--bg-light) 100%);
    position:relative; overflow:hidden;
}
.dms-orb {
    position:absolute; border-radius:50%;
    pointer-events:none; filter:blur(90px);
}
.dms-header { text-align:center; margin-bottom:58px; position:relative; z-index:2; }
.dms-badge {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(13,43,94,0.08); border:1px solid rgba(13,43,94,0.25);
    color:var(--primary-color); padding:8px 22px; border-radius:50px;
    font-size:11px; font-weight:700; letter-spacing:2.5px;
    text-transform:uppercase; margin-bottom:22px;
}
.dms-title {
    font-size:44px; font-weight:800; color:var(--text-dark);
    line-height:1.18; margin:0 0 18px;
}
.dms-title .dms-grad {
    background:linear-gradient(90deg,var(--primary-color) 0%,var(--accent-color) 100%);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.dms-subtitle {
    color:var(--text-light); font-size:16px;
    max-width:580px; margin:0 auto; line-height:1.75;
}

/* Grid */
.dms-grid {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:18px; margin-bottom:52px; position:relative; z-index:2;
}

/* Card */
.dms-card {
    background:#fff;
    border:1px solid rgba(24,74,156,0.1);
    box-shadow:0 4px 20px rgba(0,0,0,0.06);
    border-radius:22px; padding:32px 20px 26px;
    text-align:center; cursor:default;
    transition:transform 0.4s cubic-bezier(0.25,1,0.5,1),
               border-color 0.35s ease, background 0.35s ease,
               box-shadow 0.4s ease;
    position:relative; overflow:hidden;
    opacity:0; transform:translateY(48px) scale(0.95);
}
.dms-card.dms-in {
    animation:dmsIn 0.65s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes dmsIn {
    from { opacity:0; transform:translateY(48px) scale(0.94); }
    to   { opacity:1; transform:translateY(0)    scale(1);    }
}
/* Gold top line reveal on hover */
.dms-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    background:linear-gradient(90deg,var(--accent-color),#FFC107,var(--accent-color));
    transform:scaleX(0); transform-origin:left;
    transition:transform 0.45s cubic-bezier(0.25,1,0.5,1);
    border-radius:22px 22px 0 0;
}
/* Inner glow on hover */
.dms-card::after {
    content:''; position:absolute; inset:0;
    background:radial-gradient(ellipse at 50% 0%,rgba(245,130,32,0.1) 0%,transparent 65%);
    opacity:0; transition:opacity 0.4s ease; pointer-events:none;
}
.dms-card:hover {
    transform:translateY(-10px) !important;
    border-color:rgba(24,74,156,0.25);
    background:var(--bg-light);
    box-shadow:0 24px 50px rgba(24,74,156,0.12), 0 0 35px rgba(245,130,32,0.06);
}
.dms-card:hover::before { transform:scaleX(1); }
.dms-card:hover::after  { opacity:1; }

/* Icon */
.dms-icon-box {
    width:68px; height:68px; border-radius:20px;
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 18px; font-size:27px;
    transition:transform 0.45s cubic-bezier(0.34,1.56,0.64,1),
               box-shadow 0.4s ease;
    position:relative; z-index:1;
}
.dms-card:hover .dms-icon-box {
    transform:scale(1.14) rotate(-6deg);
    box-shadow:0 8px 24px rgba(0,0,0,0.35);
}
.dms-card h4 {
    color:var(--text-dark); font-size:14px; font-weight:700;
    margin:0 0 8px; line-height:1.35; position:relative; z-index:1;
}
.dms-card p {
    color:var(--text-light); font-size:12px;
    margin:0; line-height:1.6; position:relative; z-index:1;
}

/* CTA strip */
.dms-cta {
    background:linear-gradient(135deg,var(--primary-color) 0%,var(--secondary-color) 55%,#081D40 100%);
    border:none;
    border-radius:24px; padding:38px 44px;
    display:flex; align-items:center; gap:30px; flex-wrap:wrap;
    position:relative; overflow:hidden; z-index:2;
    box-shadow:0 20px 60px rgba(24,74,156,0.28);
    opacity:0; transform:translateY(35px);
    transition:opacity 0.7s ease, transform 0.7s ease;
}
.dms-cta.dms-in { opacity:1; transform:translateY(0); }
.dms-cta::before {
    content:''; position:absolute; top:-80px; right:-80px;
    width:260px; height:260px;
    background:radial-gradient(circle,rgba(255,255,255,0.07) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.dms-cta::after {
    content:''; position:absolute; bottom:-60px; left:20%;
    width:180px; height:180px;
    background:radial-gradient(circle,rgba(245,130,32,0.08) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.dms-store-btn {
    display:inline-flex; align-items:center; gap:11px;
    background:rgba(255,255,255,0.08); backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.14); color:#fff;
    padding:13px 24px; border-radius:15px; text-decoration:none;
    font-size:13px; font-weight:600;
    transition:all 0.3s cubic-bezier(0.25,1,0.5,1);
}
.dms-store-btn:hover {
    background:rgba(255,255,255,0.15);
    transform:translateY(-3px);
    box-shadow:0 12px 30px rgba(0,0,0,0.3);
    color:#fff;
}

@media(max-width:1024px) { .dms-grid{grid-template-columns:repeat(2,1fr);} }
@media(max-width:580px) {
    .dms-grid{grid-template-columns:repeat(2,1fr);gap:12px;}
    .dms-title{font-size:28px;}
    .dms-cta{padding:26px 22px;}
}
</style>

<?php $dms_header = getDmsHeader(); ?>
<section class="dms-section">
    <!-- Background orbs -->
    <div class="dms-orb" style="width:520px;height:520px;background:rgba(24,74,156,0.07);top:-160px;right:-140px;"></div>
    <div class="dms-orb" style="width:400px;height:400px;background:rgba(245,130,32,0.05);bottom:-120px;left:-120px;"></div>
    <div class="dms-orb" style="width:280px;height:280px;background:rgba(24,74,156,0.05);top:42%;left:38%;"></div>

    <div class="container">

        <!-- Header -->
        <div class="dms-header">
            <div class="dms-badge">
                <i class="fas fa-microchip" style="font-size:10px;"></i>
                <?php echo htmlspecialchars($dms_header['badge']); ?>
            </div>
            <h2 class="dms-title">
                <?php echo htmlspecialchars($dms_header['title_line1']); ?><br>
                <span class="dms-grad"><?php echo htmlspecialchars($dms_header['title_line2']); ?></span>
            </h2>
            <p class="dms-subtitle">
                <?php echo htmlspecialchars(applySiteNamePlaceholder($dms_header['subtitle'])); ?>
            </p>
        </div>

        <!-- Feature Cards -->
        <div class="dms-grid">
        <?php
        $features = getDmsFeatures();
        foreach ($features as $idx => $f):
        ?>
            <div class="dms-card" data-dms-delay="<?php echo $idx * 85; ?>">
                <div class="dms-icon-box" style="background:<?php echo hexToRgba($f['color'], 0.14); ?>;">
                    <i class="<?php echo htmlspecialchars($f['icon']); ?>" style="color:<?php echo htmlspecialchars($f['color']); ?>;"></i>
                </div>
                <h4><?php echo htmlspecialchars($f['title']); ?></h4>
                <p><?php echo htmlspecialchars($f['description']); ?></p>
            </div>
        <?php endforeach; ?>
        </div>

        <!-- Mobile App CTA -->
        <div class="dms-cta" id="dmsCta">
            <div style="flex-shrink:0;position:relative;z-index:1;">
                <div style="width:74px;height:74px;background:rgba(245,130,32,0.12);border:1px solid rgba(245,130,32,0.28);border-radius:22px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-mobile-alt" style="font-size:36px;color:var(--accent-color);"></i>
                </div>
            </div>
            <div style="flex:1 1 260px;position:relative;z-index:1;">
                <h3 style="color:#fff;font-size:22px;margin:0 0 9px;font-weight:700;"><?php echo htmlspecialchars($dms_header['cta_title']); ?></h3>
                <p style="color:rgba(255,255,255,0.62);font-size:14px;margin:0;line-height:1.65;">
                    <?php echo htmlspecialchars($dms_header['cta_desc']); ?>
                </p>
            </div>
            <div style="display:flex;gap:12px;flex-wrap:wrap;flex-shrink:0;position:relative;z-index:1;">
                <a href="<?php echo htmlspecialchars($dms_header['playstore_link']); ?>" class="dms-store-btn">
                    <i class="fab fa-google-play" style="font-size:22px;color:#00e676;"></i>
                    <div><div style="font-size:9px;opacity:0.6;letter-spacing:1px;margin-bottom:2px;">GET IT ON</div><div style="font-size:14px;font-weight:700;">Google Play</div></div>
                </a>
                <a href="#" title="Coming Soon"
                   style="display:inline-flex;align-items:center;gap:11px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);color:rgba(255,255,255,0.3);padding:13px 24px;border-radius:15px;text-decoration:none;cursor:not-allowed;">
                    <i class="fab fa-apple" style="font-size:25px;"></i>
                    <div><div style="font-size:9px;letter-spacing:1px;margin-bottom:2px;">COMING SOON</div><div style="font-size:14px;font-weight:700;">App Store</div></div>
                </a>
            </div>
        </div>

    </div>
</section>

<script>
(function(){
    /* Cards staggered entrance */
    var cards = document.querySelectorAll('.dms-card');
    if (cards.length) {
        var cardObs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if (!e.isIntersecting) return;
                var el = e.target;
                var delay = parseInt(el.dataset.dmsDelay) || 0;
                setTimeout(function(){ el.classList.add('dms-in'); }, delay);
                cardObs.unobserve(el);
            });
        }, {threshold:0.12});
        cards.forEach(function(c){ cardObs.observe(c); });
    }

    /* CTA fade-in */
    var cta = document.getElementById('dmsCta');
    if (cta) {
        var ctaObs = new IntersectionObserver(function(entries){
            if (entries[0].isIntersecting) {
                setTimeout(function(){ cta.classList.add('dms-in'); }, 200);
                ctaObs.disconnect();
            }
        }, {threshold:0.15});
        ctaObs.observe(cta);
    }
})();
</script>

<!-- ===== LEADERSHIP SECTION ===== -->
<?php include 'includes/leadership_section.php'; ?>

<!-- ===== WHY CHOOSE US ===== -->
<style>
.wcu-section { padding:68px 0 64px; background:#fff; }

/* Split layout */
.wcu-inner {
    display:grid;
    grid-template-columns:1fr 1.65fr;
    gap:52px;
    align-items:center;
}

/* Left panel */
.wcu-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(13,43,94,0.08); border:1px solid rgba(13,43,94,0.22);
    color:var(--primary-color); padding:6px 18px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:18px;
}
.wcu-title {
    font-size:34px; font-weight:800; color:var(--text-dark);
    line-height:1.22; margin:0 0 14px;
}
.wcu-title span { color:var(--primary-color); }
.wcu-sub {
    color:var(--text-light); font-size:14.5px;
    line-height:1.72; margin:0 0 26px; max-width:340px;
}
.wcu-stats {
    display:flex; gap:24px; margin-bottom:28px;
}
.wcu-stat-num {
    font-size:26px; font-weight:800; color:var(--primary-color); line-height:1;
}
.wcu-stat-lbl {
    font-size:11px; color:var(--text-light); margin-top:3px; line-height:1.3;
}
.wcu-apply {
    display:inline-flex; align-items:center; gap:9px;
    background:var(--primary-color); color:#fff;
    padding:11px 28px; border-radius:10px; font-size:14px; font-weight:700;
    text-decoration:none;
    transition:all 0.3s cubic-bezier(0.25,1,0.5,1);
}
.wcu-apply:hover {
    background:var(--primary-dark); transform:translateY(-2px);
    box-shadow:0 10px 28px rgba(24,74,156,0.3); color:#fff;
}

/* Right tile grid */
.wcu-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    border:1px solid rgba(24,74,156,0.12);
    border-radius:20px; overflow:hidden;
}
.wcu-tile {
    padding:22px 18px 20px;
    border-right:1px solid rgba(24,74,156,0.12);
    border-bottom:1px solid rgba(24,74,156,0.12);
    transition:background 0.3s ease, box-shadow 0.3s ease;
    position:relative; overflow:hidden;
    opacity:0; transform:translateY(28px);
}
.wcu-tile.wcu-in {
    animation:wcuIn 0.55s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes wcuIn {
    from { opacity:0; transform:translateY(28px); }
    to   { opacity:1; transform:translateY(0); }
}
/* Remove right border on 3rd column */
.wcu-tile:nth-child(3n) { border-right:none; }
/* Remove bottom border on last row (items 4,5,6) */
.wcu-tile:nth-child(n+4) { border-bottom:none; }

.wcu-tile::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    transform:scaleX(0); transform-origin:left;
    transition:transform 0.4s ease;
}
.wcu-tile:hover { background:rgba(24,74,156,0.04); }
.wcu-tile:hover::before { transform:scaleX(1); }

.wcu-ico {
    width:44px; height:44px; border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    font-size:19px; margin-bottom:12px;
    transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
.wcu-tile:hover .wcu-ico { transform:scale(1.12) rotate(-5deg); }
.wcu-tile h4 {
    color:var(--text-dark); font-size:13.5px; font-weight:700;
    margin:0 0 5px; line-height:1.3;
}
.wcu-tile p {
    color:var(--text-light); font-size:11.5px;
    margin:0; line-height:1.55;
}

@media(max-width:900px) {
    .wcu-inner { grid-template-columns:1fr; gap:36px; }
    .wcu-title { font-size:28px; }
    .wcu-sub { max-width:100%; }
    .wcu-grid { grid-template-columns:repeat(2,1fr); }
    .wcu-tile:nth-child(3n) { border-right:1px solid rgba(24,74,156,0.12); }
    .wcu-tile:nth-child(2n) { border-right:none; }
    .wcu-tile:nth-child(n+4) { border-bottom:1px solid rgba(24,74,156,0.12); }
    .wcu-tile:nth-child(n+5) { border-bottom:none; }
}
@media(max-width:480px) {
    .wcu-grid { grid-template-columns:1fr; }
    .wcu-tile { border-right:none !important; }
    .wcu-tile:last-child { border-bottom:none; }
}
</style>

<section class="wcu-section">
    <div class="container">
        <div class="wcu-inner">

            <!-- Left: Heading panel -->
            <?php $wcu_header = getWcuHeader(); ?>
            <div class="wcu-left" id="wcuLeft">
                <div class="wcu-badge">
                    <i class="fas fa-award" style="font-size:9px;"></i>
                    <?php echo htmlspecialchars($wcu_header['badge']); ?>
                </div>
                <h2 class="wcu-title">
                    Why Choose<br><span><?php echo SITE_NAME; ?>?</span>
                </h2>
                <p class="wcu-sub">
                    <?php echo htmlspecialchars($wcu_header['description']); ?>
                </p>
                <div class="wcu-stats">
                <?php $wcu_stats = getWcuStats(); ?>
                <?php foreach ($wcu_stats as $i => $s): ?>
                    <?php if ($i > 0): ?><div style="width:1px;background:rgba(24,74,156,0.15);"></div><?php endif; ?>
                    <div>
                        <div class="wcu-stat-num"><?php echo htmlspecialchars($s['number']); ?></div>
                        <div class="wcu-stat-lbl"><?php echo htmlspecialchars($s['label']); ?></div>
                    </div>
                <?php endforeach; ?>
                </div>
                <a href="admission.php" class="wcu-apply">
                    <i class="fas fa-graduation-cap"></i> Apply Now
                </a>
            </div>

            <!-- Right: Feature tile grid -->
            <div class="wcu-grid">
            <?php
            $why = getWhyChooseUs();
            foreach($why as $i => $w):
            ?>
                <div class="wcu-tile" data-wcu-delay="<?php echo $i*80; ?>">
                    <style>.wcu-tile:nth-child(<?php echo $i+1; ?>)::before{background:<?php echo htmlspecialchars($w['color']); ?>;}</style>
                    <div class="wcu-ico" style="background:<?php echo hexToRgba($w['color'], 0.1); ?>;">
                        <i class="<?php echo htmlspecialchars($w['icon']); ?>" style="color:<?php echo htmlspecialchars($w['color']); ?>;"></i>
                    </div>
                    <h4><?php echo htmlspecialchars($w['title']); ?></h4>
                    <p><?php echo htmlspecialchars($w['description']); ?></p>
                </div>
            <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>

<script>
(function(){
    var tiles = document.querySelectorAll('.wcu-tile');
    if (!tiles.length) return;
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if (!e.isIntersecting) return;
            var el = e.target;
            setTimeout(function(){ el.classList.add('wcu-in'); },
                       parseInt(el.dataset.wcuDelay)||0);
            obs.unobserve(el);
        });
    },{threshold:0.1});
    tiles.forEach(function(t){ obs.observe(t); });

    /* Left panel fade-in */
    var lp = document.getElementById('wcuLeft');
    if(lp){
        var lo = new IntersectionObserver(function(entries){
            if(entries[0].isIntersecting){
                lp.style.transition='opacity 0.7s ease,transform 0.7s ease';
                lp.style.opacity='1'; lp.style.transform='translateY(0)';
                lo.disconnect();
            }
        },{threshold:0.15});
        lp.style.opacity='0'; lp.style.transform='translateY(30px)';
        lo.observe(lp);
    }
})();
</script>

<!-- ===== CTA SECTION ===== -->
<style>
.cta-section {
    padding:54px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    position:relative; overflow:hidden;
}
.cta-section::before {
    content:''; position:absolute;
    top:-100px; right:-100px;
    width:320px; height:320px;
    background:radial-gradient(circle,rgba(245,130,32,0.1) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.cta-section::after {
    content:''; position:absolute;
    bottom:-80px; left:-60px;
    width:260px; height:260px;
    background:radial-gradient(circle,rgba(255,255,255,0.04) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.cta-inner {
    display:flex; align-items:center;
    gap:48px; flex-wrap:wrap;
    position:relative; z-index:1;
}

/* Left */
.cta-left { flex:1 1 380px; }
.cta-badge-pill {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(245,130,32,0.12); border:1px solid rgba(245,130,32,0.3);
    color:var(--accent-color); padding:6px 16px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:14px;
}
.cta-heading {
    font-size:32px; font-weight:800; color:#fff;
    margin:0 0 10px; line-height:1.2; letter-spacing:-0.3px;
}
.cta-heading span {
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.cta-sub {
    font-size:14px; color:rgba(255,255,255,0.68);
    margin:0; line-height:1.7; max-width:420px;
}

/* Right */
.cta-right {
    flex:0 0 auto; display:flex;
    flex-direction:column; align-items:flex-start; gap:16px;
}
.cta-btns { display:flex; gap:12px; flex-wrap:wrap; }
.cta-btn-primary {
    display:inline-flex; align-items:center; gap:8px;
    background:var(--accent-color); color:#fff;
    padding:12px 28px; border-radius:10px;
    font-size:14px; font-weight:700; text-decoration:none;
    transition:all 0.3s cubic-bezier(0.25,1,0.5,1);
    white-space:nowrap;
}
.cta-btn-primary:hover {
    background:var(--accent-dark); transform:translateY(-2px);
    box-shadow:0 10px 28px rgba(245,130,32,0.35); color:#fff;
}
.cta-btn-outline {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.25); color:#fff;
    padding:12px 28px; border-radius:10px;
    font-size:14px; font-weight:600; text-decoration:none;
    transition:all 0.3s cubic-bezier(0.25,1,0.5,1);
    white-space:nowrap;
}
.cta-btn-outline:hover {
    background:rgba(255,255,255,0.16);
    border-color:rgba(255,255,255,0.5);
    transform:translateY(-2px); color:#fff;
}

/* Trust pills */
.cta-trust {
    display:flex; gap:10px; flex-wrap:wrap;
}
.cta-pill {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(255,255,255,0.07);
    border:1px solid rgba(255,255,255,0.12);
    color:rgba(255,255,255,0.75);
    padding:5px 13px; border-radius:50px;
    font-size:11.5px; font-weight:600;
}
.cta-pill i { color:var(--accent-color); font-size:10px; }

@media(max-width:768px) {
    .cta-right { align-items:flex-start; }
    .cta-heading { font-size:26px; }
}
</style>

<?php $cta_section = getCtaSection(); ?>
<section class="cta-section" id="ctaSection">
    <div class="container">
        <div class="cta-inner">

            <!-- Left: Heading -->
            <div class="cta-left">
                <div class="cta-badge-pill">
                    <i class="fas fa-rocket" style="font-size:9px;"></i>
                    <?php echo htmlspecialchars($cta_section['badge']); ?>
                </div>
                <h2 class="cta-heading">
                    <?php echo htmlspecialchars($cta_section['heading_line1']); ?><br><span><?php echo htmlspecialchars($cta_section['heading_line2']); ?></span>
                </h2>
                <p class="cta-sub">
                    <?php echo htmlspecialchars(applySiteNamePlaceholder($cta_section['subtext'])); ?>
                </p>
            </div>

            <!-- Right: Buttons + trust -->
            <div class="cta-right">
                <div class="cta-btns">
                    <a href="admission.php" class="cta-btn-primary">
                        <i class="fas fa-graduation-cap"></i> Apply for Admission
                    </a>
                    <a href="contact.php" class="cta-btn-outline">
                        <i class="fas fa-phone-alt"></i> Contact Us
                    </a>
                </div>
                <div class="cta-trust">
                    <span class="cta-pill"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($cta_section['pill1']); ?></span>
                    <span class="cta-pill"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($cta_section['pill2']); ?></span>
                    <span class="cta-pill"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($cta_section['pill3']); ?></span>
                    <span class="cta-pill"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($cta_section['pill4']); ?></span>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function(){
    var cs = document.getElementById('ctaSection');
    if(!cs) return;
    var ob = new IntersectionObserver(function(entries){
        if(entries[0].isIntersecting){
            cs.style.transition='opacity 0.7s ease,transform 0.7s ease';
            cs.style.opacity='1'; cs.style.transform='translateY(0)';
            ob.disconnect();
        }
    },{threshold:0.15});
    cs.style.opacity='0'; cs.style.transform='translateY(24px)';
    ob.observe(cs);
})();
</script>

<?php include 'includes/footer.php'; ?>
