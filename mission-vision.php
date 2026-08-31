<?php
require_once 'includes/config.php';
$page_title = 'Mission & Vision';
$about = getAboutContent();
?>
<?php include 'includes/header.php'; ?>

<style>
/* ── Mission & Vision Page Styles ── */

.mv-hero {
    position:relative; overflow:hidden;
    min-height:280px; display:flex; align-items:center;
    background:linear-gradient(130deg,rgba(8,29,64,0.82),rgba(13,43,94,0.88)),
               url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1600') center/cover no-repeat;
    padding:70px 0;
}
.mv-breadcrumb {
    display:flex; align-items:center; gap:8px; flex-wrap:wrap;
    font-size:12px; color:rgba(255,255,255,0.5);
    margin-bottom:18px;
}
.mv-breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
.mv-breadcrumb a:hover { color:var(--accent-color); }
.mv-hero-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(245,130,32,0.12); border:1px solid rgba(245,130,32,0.35);
    color:var(--accent-color); padding:6px 18px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:16px;
}
.mv-hero h1 {
    font-size:40px; font-weight:800; color:#fff;
    margin:0 0 12px; line-height:1.15;
    text-shadow:0 4px 20px rgba(0,0,0,0.4);
}
.mv-hero h1 span {
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.mv-hero p { color:rgba(255,255,255,0.75); font-size:15px; margin:0; max-width:560px; line-height:1.7; }

.mv-section { padding:70px 0; background:#fff; }
.mv-grid { display:grid; grid-template-columns:1fr 1fr; gap:28px; }
.mv-card {
    background:var(--bg-light); border-radius:22px;
    padding:40px 34px;
    border-left:5px solid var(--primary-color);
    box-shadow:0 4px 24px rgba(0,0,0,0.06);
    transition:transform 0.35s cubic-bezier(0.25,1,0.5,1), box-shadow 0.35s ease;
    opacity:0; transform:translateY(30px);
}
.mv-card.vision { border-left-color:var(--accent-color); }
.mv-card:hover { transform:translateY(-6px); box-shadow:0 16px 45px rgba(0,0,0,0.1); }
.mv-card.mv-in { animation:mvIn 0.6s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes mvIn { from{opacity:0;transform:translateY(30px);} to{opacity:1;transform:translateY(0);} }
.mv-icon {
    width:64px; height:64px; border-radius:18px;
    display:flex; align-items:center; justify-content:center;
    font-size:26px; margin-bottom:22px;
    background:rgba(13,43,94,0.1); color:var(--primary-color);
}
.mv-card.vision .mv-icon { background:rgba(245,130,32,0.1); color:var(--accent-color); }
.mv-card h2 { font-size:22px; font-weight:800; color:var(--text-dark); margin:0 0 14px; }
.mv-card p { font-size:14.5px; color:var(--text-light); line-height:1.85; margin:0; }

.mv-cta {
    padding:52px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    text-align:center;
}
.mv-cta h2 { color:#fff; font-size:26px; font-weight:800; margin:0 0 22px; }

@media(max-width:820px){
    .mv-grid { grid-template-columns:1fr; }
    .mv-hero h1 { font-size:28px; }
}
</style>

<!-- Hero -->
<section class="mv-hero">
    <div class="container" style="position:relative;z-index:2;">
        <div class="mv-breadcrumb">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <a href="about.php">About</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <span>Mission & Vision</span>
        </div>
        <div class="mv-hero-badge">
            <i class="fas fa-compass" style="font-size:9px;"></i> Our Direction
        </div>
        <h1>Mission & <span>Vision</span></h1>
        <p>The guiding principles and long-term direction that shape everything we do at <?php echo getSiteName(); ?>.</p>
    </div>
</section>

<!-- Mission & Vision Cards -->
<section class="mv-section">
    <div class="container">
        <div class="mv-grid">
            <div class="mv-card" data-mv-delay="0">
                <div class="mv-icon"><i class="fas fa-bullseye"></i></div>
                <h2>Our Mission</h2>
                <p><?php echo nl2br(htmlspecialchars($about['mission'])); ?></p>
            </div>
            <div class="mv-card vision" data-mv-delay="150">
                <div class="mv-icon"><i class="fas fa-eye"></i></div>
                <h2>Our Vision</h2>
                <p><?php echo nl2br(htmlspecialchars($about['vision'])); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="mv-cta">
    <div class="container">
        <h2>Want to know what we stand for?</h2>
        <a href="core-values.php" class="btn btn-primary" style="margin-right:10px;">
            <i class="fas fa-heart"></i> Our Core Values
        </a>
        <a href="leadership.php" class="btn btn-outline">
            <i class="fas fa-users"></i> Meet Our Leadership
        </a>
    </div>
</section>

<script>
(function(){
    var els = document.querySelectorAll('.mv-card');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if (!e.isIntersecting) return;
            var d = parseInt(e.target.dataset.mvDelay) || 0;
            setTimeout(function(){ e.target.classList.add('mv-in'); }, d);
            obs.unobserve(e.target);
        });
    },{threshold:0.15});
    els.forEach(function(el){ obs.observe(el); });
})();
</script>

<?php include 'includes/footer.php'; ?>
