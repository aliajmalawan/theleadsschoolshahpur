<?php
require_once 'includes/config.php';
$page_title = 'Our Leadership';
?>
<?php include 'includes/header.php'; ?>

<style>
.ld-hero {
    position:relative; overflow:hidden;
    min-height:280px; display:flex; align-items:center;
    background:linear-gradient(130deg,rgba(8,29,64,0.82),rgba(13,43,94,0.88)),
               url('https://images.unsplash.com/photo-1560250097-0b93528c311a?w=1600') center/cover no-repeat;
    padding:70px 0;
}
.ld-breadcrumb {
    display:flex; align-items:center; gap:8px; flex-wrap:wrap;
    font-size:12px; color:rgba(255,255,255,0.5);
    margin-bottom:18px;
}
.ld-breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
.ld-breadcrumb a:hover { color:var(--accent-color); }
.ld-hero-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(245,130,32,0.12); border:1px solid rgba(245,130,32,0.35);
    color:var(--accent-color); padding:6px 18px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:16px;
}
.ld-hero h1 {
    font-size:40px; font-weight:800; color:#fff;
    margin:0 0 12px; line-height:1.15;
    text-shadow:0 4px 20px rgba(0,0,0,0.4);
}
.ld-hero h1 span {
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.ld-hero p { color:rgba(255,255,255,0.75); font-size:15px; margin:0; max-width:560px; line-height:1.7; }

.ld-cta {
    padding:52px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    text-align:center;
}
.ld-cta h2 { color:#fff; font-size:26px; font-weight:800; margin:0 0 22px; }
</style>

<!-- Hero -->
<section class="ld-hero">
    <div class="container" style="position:relative;z-index:2;">
        <div class="ld-breadcrumb">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <a href="about.php">About</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <span>Leadership</span>
        </div>
        <div class="ld-hero-badge">
            <i class="fas fa-users" style="font-size:9px;"></i> Meet The Team
        </div>
        <h1>Our <span>Leadership</span></h1>
        <p>Meet the people guiding <?php echo getSiteName(); ?> and hear their message to our students and community.</p>
    </div>
</section>

<!-- Leadership Messages (shared component, also used on homepage) -->
<?php include 'includes/leadership_section.php'; ?>

<!-- CTA -->
<section class="ld-cta">
    <div class="container">
        <h2>Want to learn more about us?</h2>
        <a href="mission-vision.php" class="btn btn-primary" style="margin-right:10px;">
            <i class="fas fa-compass"></i> Mission & Vision
        </a>
        <a href="core-values.php" class="btn btn-outline">
            <i class="fas fa-heart"></i> Our Core Values
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
