<?php
require_once 'includes/config.php';
$page_title = 'Core Values';

function cvHexToRgba($hex, $alpha) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "rgba($r,$g,$b,$alpha)";
}

$core_values_result = mysqli_query($conn, "SELECT * FROM core_values WHERE status = 'active' ORDER BY display_order ASC, id ASC");
$core_values = [];
if ($core_values_result) {
    while ($row = mysqli_fetch_assoc($core_values_result)) {
        $core_values[] = $row;
    }
}
?>
<?php include 'includes/header.php'; ?>

<style>
/* ── Core Values Page Styles ── */

.cv-hero {
    position:relative; overflow:hidden;
    min-height:280px; display:flex; align-items:center;
    background:linear-gradient(130deg,rgba(8,29,64,0.82),rgba(13,43,94,0.88)),
               url('https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=1600') center/cover no-repeat;
    padding:70px 0;
}
.cv-breadcrumb {
    display:flex; align-items:center; gap:8px; flex-wrap:wrap;
    font-size:12px; color:rgba(255,255,255,0.5);
    margin-bottom:18px;
}
.cv-breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
.cv-breadcrumb a:hover { color:var(--accent-color); }
.cv-hero-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(245,130,32,0.12); border:1px solid rgba(245,130,32,0.35);
    color:var(--accent-color); padding:6px 18px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:16px;
}
.cv-hero h1 {
    font-size:40px; font-weight:800; color:#fff;
    margin:0 0 12px; line-height:1.15;
    text-shadow:0 4px 20px rgba(0,0,0,0.4);
}
.cv-hero h1 span {
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.cv-hero p { color:rgba(255,255,255,0.75); font-size:15px; margin:0; max-width:560px; line-height:1.7; }

.cv-section { padding:70px 0; background:#fff; }
.cv-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:22px;
}
.cv-card {
    background:#fff; border:1px solid rgba(24,74,156,0.1);
    border-radius:20px; padding:32px 26px 26px;
    transition:all 0.35s cubic-bezier(0.25,1,0.5,1);
    position:relative; overflow:hidden;
    opacity:0; transform:translateY(28px);
}
.cv-card.cv-in { animation:cvIn 0.6s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes cvIn { from{opacity:0;transform:translateY(28px);} to{opacity:1;transform:translateY(0);} }
.cv-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    transform:scaleX(0); transform-origin:left;
    transition:transform 0.4s ease;
}
.cv-card:hover {
    transform:translateY(-6px);
    border-color:rgba(24,74,156,0.22);
    box-shadow:0 16px 40px rgba(24,74,156,0.1);
}
.cv-card:hover::before { transform:scaleX(1); }
.cv-ico {
    width:54px; height:54px; border-radius:15px;
    display:flex; align-items:center; justify-content:center;
    font-size:22px; margin-bottom:16px;
    transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
.cv-card:hover .cv-ico { transform:scale(1.1) rotate(-5deg); }
.cv-card h3 { font-size:17px; font-weight:800; color:var(--text-dark); margin:0 0 9px; }
.cv-card p { font-size:13.5px; color:var(--text-light); margin:0; line-height:1.7; }

.cv-cta {
    padding:52px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    text-align:center;
}
.cv-cta h2 { color:#fff; font-size:26px; font-weight:800; margin:0 0 22px; }

@media(max-width:900px){ .cv-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:560px){ .cv-grid { grid-template-columns:1fr; } .cv-hero h1 { font-size:28px; } }
</style>

<!-- Hero -->
<section class="cv-hero">
    <div class="container" style="position:relative;z-index:2;">
        <div class="cv-breadcrumb">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <a href="about.php">About</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <span>Core Values</span>
        </div>
        <div class="cv-hero-badge">
            <i class="fas fa-heart" style="font-size:9px;"></i> Our Principles
        </div>
        <h1>Our Core <span>Values</span></h1>
        <p>The principles of excellence, integrity, and respect that shape the culture at <?php echo getSiteName(); ?>.</p>
    </div>
</section>

<!-- Values Grid -->
<section class="cv-section">
    <div class="container">
        <div class="cv-grid">
        <?php if (!empty($core_values)): ?>
            <?php foreach($core_values as $i=>$v): ?>
            <div class="cv-card" data-cv-delay="<?php echo $i*80; ?>">
                <style>.cv-card:nth-child(<?php echo $i+1; ?>)::before{background:<?php echo htmlspecialchars($v['color']); ?>;}</style>
                <div class="cv-ico" style="background:<?php echo cvHexToRgba($v['color'], 0.1); ?>;">
                    <i class="<?php echo htmlspecialchars($v['icon']); ?>" style="color:<?php echo htmlspecialchars($v['color']); ?>;"></i>
                </div>
                <h3><?php echo htmlspecialchars($v['title']); ?></h3>
                <p><?php echo htmlspecialchars($v['description']); ?></p>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--text-light);">
                <i class="fas fa-heart" style="font-size:50px;color:rgba(24,74,156,0.2);margin-bottom:16px;display:block;"></i>
                No core values published yet.
            </div>
        <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cv-cta">
    <div class="container">
        <h2>Curious about our direction?</h2>
        <a href="mission-vision.php" class="btn btn-primary" style="margin-right:10px;">
            <i class="fas fa-compass"></i> Mission & Vision
        </a>
        <a href="leadership.php" class="btn btn-outline">
            <i class="fas fa-users"></i> Meet Our Leadership
        </a>
    </div>
</section>

<script>
(function(){
    var els = document.querySelectorAll('.cv-card');
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if (!e.isIntersecting) return;
            var d = parseInt(e.target.dataset.cvDelay) || 0;
            setTimeout(function(){ e.target.classList.add('cv-in'); }, d);
            obs.unobserve(e.target);
        });
    },{threshold:0.12});
    els.forEach(function(el){ obs.observe(el); });
})();
</script>

<?php include 'includes/footer.php'; ?>
