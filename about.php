<?php
require_once 'includes/config.php';
$page_title = 'About Us';
$about = getAboutContent();
$about_hero = getAboutHero();
$about_who = getAboutWho();
$about_explore = getAboutExplore();
$about_cta_content = getAboutCta();
?>
<?php include 'includes/header.php'; ?>

<style>
/* ── About Page Styles ── */

/* Hero */
.ab-hero {
    position:relative; overflow:hidden;
    min-height:320px; display:flex; align-items:center;
    background-size:cover; background-position:center; background-repeat:no-repeat;
    padding:70px 0;
}
.ab-hero-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(245,130,32,0.12); border:1px solid rgba(245,130,32,0.35);
    color:var(--accent-color); padding:6px 18px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:16px;
}
.ab-hero h1 {
    font-size:42px; font-weight:800; color:#fff;
    margin:0 0 12px; line-height:1.15;
    text-shadow:0 4px 20px rgba(0,0,0,0.4);
}
.ab-hero h1 span {
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.ab-hero p {
    color:rgba(255,255,255,0.75); font-size:15px;
    margin:0; max-width:520px; line-height:1.7;
}
.ab-breadcrumb {
    display:flex; align-items:center; gap:8px;
    font-size:12px; color:rgba(255,255,255,0.5);
    margin-bottom:18px;
}
.ab-breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
.ab-breadcrumb a:hover { color:var(--accent-color); }
/* Hero floating orbs */
.ab-orb {
    position:absolute; border-radius:50%;
    pointer-events:none; filter:blur(80px);
}

/* ── Who We Are ── */
.ab-who {
    padding:70px 0 60px; background:#fff;
}
.ab-who-grid {
    display:grid; grid-template-columns:1fr 1fr;
    gap:55px; align-items:center;
}
.ab-section-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(13,43,94,0.08); border:1px solid rgba(13,43,94,0.22);
    color:var(--primary-color); padding:6px 16px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:16px;
}
.ab-who h2 {
    font-size:32px; font-weight:800; color:var(--text-dark);
    margin:0 0 16px; line-height:1.22;
}
.ab-who h2 span { color:var(--primary-color); }
.ab-who p {
    font-size:14.5px; color:var(--text-light);
    line-height:1.78; margin:0 0 14px;
}
.ab-highlights {
    display:flex; gap:18px; margin-top:22px; flex-wrap:wrap;
}
.ab-hl {
    display:flex; align-items:center; gap:9px;
    background:rgba(24,74,156,0.07);
    border:1px solid rgba(24,74,156,0.15);
    padding:8px 16px; border-radius:10px;
    font-size:12.5px; font-weight:600; color:var(--text-dark);
}
.ab-hl i { color:var(--primary-color); font-size:13px; }

/* Image side */
.ab-img-wrap { position:relative; }
.ab-img-wrap img {
    width:100%; border-radius:18px;
    box-shadow:0 20px 55px rgba(0,0,0,0.12);
    display:block;
}
.ab-img-badge {
    position:absolute; bottom:-18px; left:-18px;
    background:var(--primary-color); color:#fff;
    padding:16px 22px; border-radius:16px;
    box-shadow:0 12px 30px rgba(13,43,94,0.35);
    text-align:center;
}
.ab-img-badge .num { font-size:26px; font-weight:800; line-height:1; }
.ab-img-badge .lbl { font-size:10px; opacity:0.85; margin-top:3px; letter-spacing:0.5px; }

@keyframes abIn {
    from { opacity:0; transform:translateY(30px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Explore More (links to spun-off pages) ── */
.ab-explore {
    padding:60px 0; background:var(--bg-light);
}
.ab-explore-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:22px; margin-top:40px;
}
.ab-explore-card {
    background:#fff; border-radius:20px;
    padding:34px 28px;
    text-decoration:none; display:block;
    border-top:4px solid var(--primary-color);
    box-shadow:0 4px 24px rgba(0,0,0,0.06);
    transition:transform 0.35s cubic-bezier(0.25,1,0.5,1),
               box-shadow 0.35s ease;
    opacity:0; transform:translateY(30px);
}
.ab-explore-card:nth-child(2) { border-top-color:var(--accent-color); }
.ab-explore-card:nth-child(3) { border-top-color:#7b1fa2; }
.ab-explore-card:hover {
    transform:translateY(-6px);
    box-shadow:0 16px 45px rgba(0,0,0,0.1);
}
.ab-explore-card.ab-in { animation:abIn 0.6s cubic-bezier(0.22,1,0.36,1) both; }
.ab-explore-icon {
    width:52px; height:52px; border-radius:15px;
    display:flex; align-items:center; justify-content:center;
    font-size:22px; margin-bottom:18px;
    background:rgba(13,43,94,0.1); color:var(--primary-color);
}
.ab-explore-card:nth-child(2) .ab-explore-icon { background:rgba(245,130,32,0.1); color:var(--accent-color); }
.ab-explore-card:nth-child(3) .ab-explore-icon { background:rgba(123,31,162,0.1); color:#7b1fa2; }
.ab-explore-card h3 {
    font-size:17px; font-weight:800; color:var(--text-dark);
    margin:0 0 8px;
}
.ab-explore-card p {
    font-size:13px; color:var(--text-light);
    line-height:1.68; margin:0 0 14px;
}
.ab-explore-link {
    font-size:12.5px; font-weight:700; color:var(--primary-color);
    display:inline-flex; align-items:center; gap:6px;
}
.ab-explore-card:hover .ab-explore-link { gap:10px; }

/* ── Stats Strip ── */
.ab-stats {
    padding:48px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    position:relative; overflow:hidden;
}
.ab-stats::before {
    content:''; position:absolute;
    top:-80px; right:-80px; width:280px; height:280px;
    background:radial-gradient(circle,rgba(245,130,32,0.1) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}
.ab-stats-grid {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:0; position:relative; z-index:1;
}
.ab-stat-item {
    text-align:center; padding:20px 16px;
    border-right:1px solid rgba(255,255,255,0.1);
    opacity:0; transform:translateY(20px);
}
.ab-stat-item:last-child { border-right:none; }
.ab-stat-item.ab-in { animation:abIn 0.55s cubic-bezier(0.22,1,0.36,1) both; }
.ab-stat-num {
    font-size:36px; font-weight:800;
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text; line-height:1;
}
.ab-stat-lbl {
    font-size:12px; color:rgba(255,255,255,0.65);
    margin-top:6px; font-weight:500; letter-spacing:0.5px;
}

/* ── About CTA ── */
.ab-cta {
    padding:52px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    position:relative; overflow:hidden;
}
.ab-cta::before {
    content:''; position:absolute; top:-100px; right:-100px;
    width:300px; height:300px;
    background:radial-gradient(circle,rgba(245,130,32,0.09) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}

/* ── Section Header ── */
.ab-sh { text-align:center; margin-bottom:6px; }
.ab-sh h2 {
    font-size:30px; font-weight:800; color:var(--text-dark); margin:10px 0 10px;
}
.ab-sh h2 span { color:var(--primary-color); }
.ab-sh p { color:var(--text-light); font-size:14px; margin:0; }

/* ── Responsive ── */
@media(max-width:900px) {
    .ab-who-grid { grid-template-columns:1fr; }
    .ab-stats-grid { grid-template-columns:repeat(2,1fr); }
    .ab-stat-item:nth-child(2) { border-right:none; }
    .ab-stat-item:nth-child(1),
    .ab-stat-item:nth-child(2) { border-bottom:1px solid rgba(255,255,255,0.1); }
    .ab-explore-grid { grid-template-columns:1fr; }
    .ab-hero h1 { font-size:30px; }
}
@media(max-width:540px) {
    .ab-stats-grid  { grid-template-columns:repeat(2,1fr); }
}
</style>

<!-- ── Hero Banner ── -->
<section class="ab-hero" style="background-image:linear-gradient(130deg,rgba(8,29,64,0.82),rgba(13,43,94,0.88)), url('<?php echo htmlspecialchars($about_hero['image']); ?>');">
    <div class="ab-orb" style="width:400px;height:400px;background:rgba(24,74,156,0.2);top:-120px;right:-100px;"></div>
    <div class="ab-orb" style="width:260px;height:260px;background:rgba(245,130,32,0.08);bottom:-80px;left:-60px;"></div>

    <div class="container" style="position:relative;z-index:2;">
        <div class="ab-breadcrumb">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <span>About Us</span>
        </div>
        <div class="ab-hero-badge">
            <i class="fas fa-info-circle" style="font-size:9px;"></i>
            <?php echo htmlspecialchars($about_hero['badge']); ?>
        </div>
        <h1>About <span><?php echo getSiteName(); ?></span></h1>
        <p><?php echo htmlspecialchars($about_hero['subtitle']); ?></p>
    </div>
</section>

<!-- ── Who We Are ── -->
<section class="ab-who" id="abWho">
    <div class="container">
        <div class="ab-who-grid">
            <!-- Text -->
            <div>
                <div class="ab-section-badge">
                    <i class="fas fa-university" style="font-size:9px;"></i>
                    <?php echo htmlspecialchars($about_who['badge']); ?>
                </div>
                <h2><?php echo renderHighlightedTitle($about_who['title'], $about_who['title_highlight'], 'span'); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($about['description'])); ?></p>
                <p><?php echo htmlspecialchars($about_who['paragraph2']); ?></p>
                <div class="ab-highlights">
                    <div class="ab-hl"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($about_who['hl1']); ?></div>
                    <div class="ab-hl"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($about_who['hl2']); ?></div>
                    <div class="ab-hl"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($about_who['hl3']); ?></div>
                    <div class="ab-hl"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($about_who['hl4']); ?></div>
                </div>
            </div>
            <!-- Image -->
            <div class="ab-img-wrap">
                <img src="<?php echo htmlspecialchars($about_who['image']); ?>" alt="<?php echo getSiteName(); ?> Campus"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNTAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iI0VFRjZGNiIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iNDAiIGZpbGw9IiMwQjcyNzUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj7wn4+rPC90ZXh0Pjwvc3ZnPg=='">
                <div class="ab-img-badge">
                    <div class="num"><?php echo htmlspecialchars($about_who['image_badge_num']); ?></div>
                    <div class="lbl"><?php echo htmlspecialchars($about_who['image_badge_label']); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── Explore More ── -->
<section class="ab-explore">
    <div class="container">
        <div class="ab-sh">
            <div class="ab-section-badge" style="margin:0 auto 0;">
                <i class="fas fa-compass" style="font-size:9px;"></i>
                <?php echo htmlspecialchars($about_explore['badge']); ?>
            </div>
            <h2 style="font-size:30px;font-weight:800;color:var(--text-dark);margin:10px 0 6px;">
                <?php echo renderHighlightedTitle($about_explore['title'], $about_explore['title_highlight'], 'span'); ?>
            </h2>
            <p style="color:var(--text-light);font-size:14px;"><?php echo htmlspecialchars($about_explore['subtitle']); ?></p>
        </div>
        <div class="ab-explore-grid">
            <a href="mission-vision.php" class="ab-explore-card" data-ab-delay="0">
                <div class="ab-explore-icon"><i class="fas fa-compass"></i></div>
                <h3><?php echo htmlspecialchars($about_explore['card1_title']); ?></h3>
                <p><?php echo htmlspecialchars($about_explore['card1_desc']); ?></p>
                <span class="ab-explore-link">Read More <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="core-values.php" class="ab-explore-card" data-ab-delay="120">
                <div class="ab-explore-icon"><i class="fas fa-heart"></i></div>
                <h3><?php echo htmlspecialchars($about_explore['card2_title']); ?></h3>
                <p><?php echo htmlspecialchars($about_explore['card2_desc']); ?></p>
                <span class="ab-explore-link">Read More <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="leadership.php" class="ab-explore-card" data-ab-delay="240">
                <div class="ab-explore-icon"><i class="fas fa-users"></i></div>
                <h3><?php echo htmlspecialchars($about_explore['card3_title']); ?></h3>
                <p><?php echo htmlspecialchars($about_explore['card3_desc']); ?></p>
                <span class="ab-explore-link">Read More <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>

<!-- ── Stats Strip ── -->
<section class="ab-stats">
    <div class="container">
        <div class="ab-stats-grid">
            <?php $stats = getAboutStats(); ?>
            <?php foreach($stats as $i=>$s): ?>
            <div class="ab-stat-item" data-ab-delay="<?php echo $i*100; ?>">
                <div class="ab-stat-num"><?php echo htmlspecialchars($s['number']); ?></div>
                <div class="ab-stat-lbl"><?php echo htmlspecialchars($s['label']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── CTA ── -->
<section class="ab-cta">
    <div class="container">
        <div style="display:flex;align-items:center;gap:44px;flex-wrap:wrap;position:relative;z-index:1;">
            <div style="flex:1 1 340px;">
                <div style="display:inline-flex;align-items:center;gap:7px;background:rgba(245,130,32,0.12);border:1px solid rgba(245,130,32,0.3);color:var(--accent-color);padding:6px 16px;border-radius:50px;font-size:10.5px;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:14px;">
                    <i class="fas fa-door-open" style="font-size:9px;"></i> <?php echo htmlspecialchars($about_cta_content['badge']); ?>
                </div>
                <h2 style="font-size:30px;font-weight:800;color:#fff;margin:0 0 10px;line-height:1.22;">
                    <?php echo htmlspecialchars($about_cta_content['heading_line1']); ?><br><span style="background:linear-gradient(90deg,var(--accent-color),#FFC107);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"><?php echo htmlspecialchars($about_cta_content['heading_line2']); ?></span>
                </h2>
                <p style="color:rgba(255,255,255,0.68);font-size:14px;margin:0;line-height:1.7;">
                    <?php echo htmlspecialchars(applySiteNamePlaceholder($about_cta_content['subtext'])); ?>
                </p>
            </div>
            <div style="display:flex;flex-direction:column;gap:14px;flex-shrink:0;">
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="admission.php" style="display:inline-flex;align-items:center;gap:8px;background:var(--accent-color);color:#fff;padding:12px 26px;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;transition:all 0.3s ease;"
                       onmouseover="this.style.background='#D96C0F';this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='var(--accent-color)';this.style.transform='';">
                        <i class="fas fa-graduation-cap"></i> Apply for Admission
                    </a>
                    <a href="contact.php" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.25);color:#fff;padding:12px 26px;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;transition:all 0.3s ease;"
                       onmouseover="this.style.background='rgba(255,255,255,0.16)';this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.transform='';">
                        <i class="fas fa-phone-alt"></i> Contact Us
                    </a>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.72);padding:5px 13px;border-radius:50px;font-size:11.5px;font-weight:600;">
                        <i class="fas fa-check-circle" style="color:var(--accent-color);font-size:10px;"></i> <?php echo htmlspecialchars($about_cta_content['pill1']); ?>
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.72);padding:5px 13px;border-radius:50px;font-size:11.5px;font-weight:600;">
                        <i class="fas fa-check-circle" style="color:var(--accent-color);font-size:10px;"></i> <?php echo htmlspecialchars($about_cta_content['pill2']); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function(){
    /* Generic scroll-animate observer */
    function observe(selector, delay_attr) {
        var els = document.querySelectorAll(selector);
        if (!els.length) return;
        var obs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if (!e.isIntersecting) return;
                var d = parseInt(e.target.dataset[delay_attr || 'abDelay']) || 0;
                setTimeout(function(){ e.target.classList.add('ab-in'); }, d);
                obs.unobserve(e.target);
            });
        },{threshold:0.12});
        els.forEach(function(el){ obs.observe(el); });
    }

    observe('.ab-explore-card', 'abDelay');
    observe('.ab-stat-item',    'abDelay');

    /* Who We Are — left panel fade */
    var who = document.getElementById('abWho');
    if(who){
        var wo = new IntersectionObserver(function(entries){
            if(entries[0].isIntersecting){
                who.style.transition='opacity 0.7s ease,transform 0.7s ease';
                who.style.opacity='1'; who.style.transform='translateY(0)';
                wo.disconnect();
            }
        },{threshold:0.1});
        who.style.opacity='0'; who.style.transform='translateY(24px)';
        wo.observe(who);
    }

})();
</script>

<?php include 'includes/footer.php'; ?>
