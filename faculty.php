<?php
require_once 'includes/config.php';
$page_title = 'Our Faculty';

$faculty_result = mysqli_query($conn, "SELECT * FROM faculty WHERE status='active' ORDER BY display_order ASC");
$db_faculty = [];
if ($faculty_result && mysqli_num_rows($faculty_result) > 0)
    while ($r = mysqli_fetch_assoc($faculty_result)) $db_faculty[] = $r;

$faculty = $db_faculty;
$has_faculty = count($faculty) > 0;

$faculty_hero = getFacultyHero();
$faculty_stats = getFacultyStats();
$faculty_grid_header = getFacultyGridHeader();
$faculty_why = getFacultyWhy();
$faculty_cta_content = getFacultyCta();

// Avatar gradient pool
$gradients = [
    'linear-gradient(135deg,var(--primary-color),var(--primary-dark))',
    'linear-gradient(135deg,#2e7d32,#43a047)',
    'linear-gradient(135deg,#7b1fa2,#9c27b0)',
    'linear-gradient(135deg,#c62828,#e53935)',
    'linear-gradient(135deg,#e65100,#f57c00)',
    'linear-gradient(135deg,#00695c,#00897b)',
    'linear-gradient(135deg,#1565c0,#1976d2)',
    'linear-gradient(135deg,#4527a0,#5e35b1)',
];
?>
<?php include 'includes/header.php'; ?>

<style>
/* ── Faculty Page ── */

/* Hero */
.fac-hero {
    position:relative; overflow:hidden;
    min-height:290px; display:flex; align-items:center;
    background:linear-gradient(130deg,rgba(8,29,64,0.85),rgba(13,43,94,0.91)),
               url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=1600') center/cover no-repeat;
    padding:65px 0;
}
.fac-orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(80px); }
.fac-hero-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(245,130,32,0.12); border:1px solid rgba(245,130,32,0.35);
    color:var(--accent-color); padding:6px 18px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:14px;
}
.fac-hero h1 { font-size:38px; font-weight:800; color:#fff; margin:0 0 10px; line-height:1.15; }
.fac-hero h1 span {
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.fac-hero p { color:rgba(255,255,255,0.72); font-size:14.5px; margin:0; max-width:480px; line-height:1.7; }
.fac-breadcrumb {
    display:flex; align-items:center; gap:8px;
    font-size:12px; color:rgba(255,255,255,0.5); margin-bottom:16px;
}
.fac-breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
.fac-breadcrumb a:hover { color:var(--accent-color); }

/* ── Stats bar ── */
.fac-stats-bar {
    background:var(--primary-color);
    padding:16px 0;
}
.fac-stats-inner {
    display:flex; justify-content:center; gap:0;
    flex-wrap:wrap;
}
.fac-stat {
    padding:8px 36px; text-align:center;
    border-right:1px solid rgba(255,255,255,0.15);
    color:#fff;
}
.fac-stat:last-child { border-right:none; }
.fac-stat-n { font-size:22px; font-weight:800; color:var(--accent-color); line-height:1; }
.fac-stat-l { font-size:11px; opacity:0.75; margin-top:3px; letter-spacing:0.3px; }

/* ── Faculty Grid ── */
.fac-section { padding:58px 0 65px; background:#f8fffe; }
.fac-sh { text-align:center; margin-bottom:42px; }
.fac-sh-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(13,43,94,0.08); border:1px solid rgba(13,43,94,0.22);
    color:var(--primary-color); padding:6px 16px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:12px;
}
.fac-sh h2 { font-size:30px; font-weight:800; color:var(--text-dark); margin:0 0 8px; }
.fac-sh h2 span { color:var(--primary-color); }
.fac-sh p { color:var(--text-light); font-size:14px; margin:0; }

.fac-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

/* Empty state */
.fac-empty { grid-column:1/-1; text-align:center; padding:80px 20px; }
.fac-empty-icon {
    width:100px; height:100px; border-radius:50%;
    background:linear-gradient(135deg, rgba(24,74,156,0.1), rgba(245,130,32,0.1));
    border:2px dashed rgba(24,74,156,0.2);
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 24px;
}
.fac-empty-icon i { font-size:40px; color:var(--primary-color); opacity:.5; }
.fac-empty h3 { color:var(--text-dark); font-size:22px; font-weight:700; margin-bottom:10px; }
.fac-empty p { color:var(--text-light); font-size:15px; max-width:460px; margin:0 auto; line-height:1.7; }

/* Profile Card */
.fac-card {
    background:#fff;
    border:1px solid rgba(24,74,156,0.1);
    border-radius:20px;
    overflow:hidden;
    transition:transform 0.35s cubic-bezier(0.25,1,0.5,1),
               box-shadow 0.35s ease, border-color 0.3s;
    opacity:0; transform:translateY(38px);
    display:flex; flex-direction:column;
}
.fac-card.fac-in { animation:facIn 0.6s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes facIn {
    from { opacity:0; transform:translateY(38px) scale(0.95); }
    to   { opacity:1; transform:translateY(0)    scale(1); }
}
.fac-card:hover {
    transform:translateY(-8px);
    box-shadow:0 20px 48px rgba(24,74,156,0.13);
    border-color:rgba(24,74,156,0.22);
}

/* Card top — avatar area */
.fac-card-top {
    padding:28px 20px 18px;
    text-align:center;
    position:relative;
}
.fac-card-top::before {
    content:''; position:absolute;
    top:0; left:0; right:0; height:3px;
}

/* Avatar */
.fac-avatar {
    width:82px; height:82px; border-radius:50%;
    margin:0 auto 14px;
    display:flex; align-items:center; justify-content:center;
    font-size:32px; color:#fff;
    box-shadow:0 8px 24px rgba(0,0,0,0.18);
    position:relative;
}
.fac-avatar img {
    width:100%; height:100%; border-radius:50%; object-fit:cover;
}
.fac-card-top h3 {
    font-size:14.5px; font-weight:800; color:var(--text-dark);
    margin:0 0 5px; line-height:1.25;
}
.fac-desig {
    font-size:11.5px; font-weight:600; color:var(--primary-color);
    margin-bottom:14px; line-height:1.3;
}

/* Subject tags */
.fac-tags { display:flex; flex-wrap:wrap; gap:5px; justify-content:center; }
.fac-tag {
    display:inline-flex; align-items:center;
    background:rgba(13,43,94,0.07);
    border:1px solid rgba(13,43,94,0.15);
    color:var(--primary-color); padding:3px 9px;
    border-radius:5px; font-size:10.5px; font-weight:600;
}

/* Card footer */
.fac-card-foot {
    padding:12px 20px 16px;
    border-top:1px solid rgba(24,74,156,0.07);
    margin-top:auto;
    display:flex; flex-direction:column; gap:6px;
}
.fac-info-row {
    display:flex; align-items:center; gap:8px;
    font-size:11.5px; color:var(--text-light);
}
.fac-info-row i { color:var(--primary-color); font-size:10px; width:13px; }
.fac-info-row strong { color:var(--text-dark); font-weight:600; }

/* ── Why Faculty ── */
.fac-why { padding:58px 0; background:#fff; }
.fac-why-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:18px; margin-top:40px;
}
.fac-why-tile {
    background:#fff; border:1px solid rgba(24,74,156,0.1);
    border-radius:18px; padding:24px 20px 20px;
    transition:all 0.35s cubic-bezier(0.25,1,0.5,1);
    position:relative; overflow:hidden;
    opacity:0; transform:translateY(28px);
}
.fac-why-tile.fac-in { animation:facIn 0.6s cubic-bezier(0.22,1,0.36,1) both; }
.fac-why-tile::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    transform:scaleX(0); transform-origin:left; transition:transform 0.4s ease;
}
.fac-why-tile:hover {
    transform:translateY(-6px);
    border-color:rgba(24,74,156,0.22);
    box-shadow:0 14px 38px rgba(24,74,156,0.1);
}
.fac-why-tile:hover::before { transform:scaleX(1); }
.fac-why-ico {
    width:46px; height:46px; border-radius:13px;
    display:flex; align-items:center; justify-content:center;
    font-size:19px; margin-bottom:14px;
    transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
.fac-why-tile:hover .fac-why-ico { transform:scale(1.1) rotate(-5deg); }
.fac-why-tile h4 { font-size:14px; font-weight:700; color:var(--text-dark); margin:0 0 7px; }
.fac-why-tile p  { font-size:12px; color:var(--text-light); margin:0; line-height:1.6; }

/* ── CTA ── */
.fac-cta {
    padding:52px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    position:relative; overflow:hidden;
}
.fac-cta::before {
    content:''; position:absolute; top:-100px; right:-100px;
    width:280px; height:280px;
    background:radial-gradient(circle,rgba(245,130,32,0.09) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}

/* Responsive */
@media(max-width:1100px) { .fac-grid { grid-template-columns:repeat(3,1fr); } }
@media(max-width:780px)  {
    .fac-grid     { grid-template-columns:repeat(2,1fr); }
    .fac-why-grid { grid-template-columns:repeat(2,1fr); }
    .fac-hero h1  { font-size:28px; }
    .fac-stat     { padding:8px 20px; }
}
@media(max-width:480px)  {
    .fac-grid     { grid-template-columns:1fr 1fr; gap:14px; }
    .fac-why-grid { grid-template-columns:1fr; }
}
</style>

<!-- ── Hero ── -->
<section class="fac-hero">
    <div class="fac-orb" style="width:360px;height:360px;background:rgba(24,74,156,0.2);top:-110px;right:-90px;"></div>
    <div class="fac-orb" style="width:220px;height:220px;background:rgba(245,130,32,0.07);bottom:-70px;left:-50px;"></div>
    <div class="container" style="position:relative;z-index:2;">
        <div class="fac-breadcrumb">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <span>Faculty</span>
        </div>
        <div class="fac-hero-badge">
            <i class="fas fa-chalkboard-teacher" style="font-size:9px;"></i>
            <?php echo htmlspecialchars($faculty_hero['badge']); ?>
        </div>
        <h1>Our <span>Expert Faculty</span></h1>
        <p><?php echo htmlspecialchars($faculty_hero['subtitle']); ?></p>
    </div>
</section>

<!-- ── Stats bar ── -->
<div class="fac-stats-bar">
    <div class="container">
        <div class="fac-stats-inner">
            <div class="fac-stat"><div class="fac-stat-n"><?php echo $has_faculty ? count($faculty) . '+' : '—'; ?></div><div class="fac-stat-l">Expert Teachers</div></div>
            <div class="fac-stat"><div class="fac-stat-n"><?php echo htmlspecialchars($faculty_stats['stat2_number']); ?></div><div class="fac-stat-l"><?php echo htmlspecialchars($faculty_stats['stat2_label']); ?></div></div>
            <div class="fac-stat"><div class="fac-stat-n"><?php echo htmlspecialchars($faculty_stats['stat3_number']); ?></div><div class="fac-stat-l"><?php echo htmlspecialchars($faculty_stats['stat3_label']); ?></div></div>
            <div class="fac-stat"><div class="fac-stat-n"><?php echo htmlspecialchars($faculty_stats['stat4_number']); ?></div><div class="fac-stat-l"><?php echo htmlspecialchars($faculty_stats['stat4_label']); ?></div></div>
        </div>
    </div>
</div>

<!-- ── Faculty Grid ── -->
<section class="fac-section">
    <div class="container">
        <div class="fac-sh">
            <div class="fac-sh-badge"><i class="fas fa-users" style="font-size:9px;"></i> <?php echo htmlspecialchars($faculty_grid_header['badge']); ?></div>
            <h2><?php echo renderHighlightedTitle($faculty_grid_header['title'], $faculty_grid_header['title_highlight'], 'span'); ?></h2>
            <p><?php echo htmlspecialchars($faculty_grid_header['subtitle']); ?></p>
        </div>

        <div class="fac-grid">
        <?php if (!$has_faculty): ?>
            <div class="fac-empty">
                <div class="fac-empty-icon"><i class="fas fa-chalkboard-user"></i></div>
                <h3>Faculty Coming Soon</h3>
                <p>We're updating our faculty profiles. Please check back soon to meet our teaching staff.</p>
            </div>
        <?php else: ?>
        <?php foreach($faculty as $idx => $t):
            $grad   = $gradients[$idx % count($gradients)];
            $icon   = $t['icon'] ?? 'fa-chalkboard-teacher';
            $delay  = ($idx % 4) * 85;
            $subjs  = !empty($t['subjects']) ? explode(',', $t['subjects']) : [];
        ?>
            <div class="fac-card" data-fac-delay="<?php echo $delay; ?>">

                <!-- Card top strip gradient (same as avatar) -->
                <style>.fac-card:nth-child(<?php echo $idx+1; ?>)::before,.fac-card:nth-child(<?php echo $idx+1; ?>) .fac-card-top::before { background:<?php echo $grad; ?>; }</style>
                <style>.fac-card:nth-child(<?php echo $idx+1; ?>) .fac-card-top::before { transform:none; height:3px; }</style>

                <div class="fac-card-top">
                    <div class="fac-avatar" style="background:<?php echo $grad; ?>;">
                        <?php if(!empty($t['photo'])): ?>
                            <img src="<?php echo htmlspecialchars($t['photo']); ?>"
                                 alt="<?php echo htmlspecialchars($t['name']); ?>"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <span style="display:none;position:absolute;inset:0;align-items:center;justify-content:center;font-size:30px;">
                                <i class="fas <?php echo htmlspecialchars($icon); ?>"></i>
                            </span>
                        <?php else: ?>
                            <i class="fas <?php echo htmlspecialchars($icon); ?>"></i>
                        <?php endif; ?>
                    </div>
                    <h3><?php echo htmlspecialchars($t['name']); ?></h3>
                    <div class="fac-desig"><?php echo htmlspecialchars($t['designation']); ?></div>
                    <?php if($subjs): ?>
                    <div class="fac-tags">
                        <?php foreach(array_slice($subjs,0,3) as $s): ?>
                        <span class="fac-tag"><?php echo htmlspecialchars(trim($s)); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="fac-card-foot">
                    <?php if(!empty($t['qualification'])): ?>
                    <div class="fac-info-row">
                        <i class="fas fa-certificate"></i>
                        <span><?php echo htmlspecialchars($t['qualification']); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($t['experience'])): ?>
                    <div class="fac-info-row">
                        <i class="fas fa-clock"></i>
                        <strong><?php echo htmlspecialchars($t['experience']); ?> yrs</strong>
                        <span>experience</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </div>
</section>

<!-- ── Why Our Faculty Stands Out ── -->
<section class="fac-why">
    <div class="container">
        <div class="fac-sh">
            <div class="fac-sh-badge"><i class="fas fa-star" style="font-size:9px;"></i> <?php echo htmlspecialchars($faculty_why['badge']); ?></div>
            <h2><?php echo renderHighlightedTitle($faculty_why['title'], $faculty_why['title_highlight'], 'span'); ?></h2>
            <p><?php echo htmlspecialchars($faculty_why['subtitle']); ?></p>
        </div>
        <div class="fac-why-grid">
        <?php
        $why = [
            ['ic'=>'fas fa-graduation-cap','clr'=>'#0D2B5E','bg'=>'rgba(13,43,94,0.1)', 'bar'=>'linear-gradient(90deg,var(--primary-color),var(--secondary-color))',
             'title'=>$faculty_why['tile1_title'], 'desc'=>$faculty_why['tile1_desc']],
            ['ic'=>'fas fa-medal',         'clr'=>'#D96C0F','bg'=>'rgba(245,130,32,0.1)',  'bar'=>'linear-gradient(90deg,#D96C0F,var(--accent-color))',
             'title'=>$faculty_why['tile2_title'], 'desc'=>$faculty_why['tile2_desc']],
            ['ic'=>'fas fa-heart',         'clr'=>'#e53935','bg'=>'rgba(229,57,53,0.1)',  'bar'=>'linear-gradient(90deg,#e53935,#ef5350)',
             'title'=>$faculty_why['tile3_title'], 'desc'=>$faculty_why['tile3_desc']],
            ['ic'=>'fas fa-book-reader',   'clr'=>'#7b1fa2','bg'=>'rgba(123,31,162,0.1)','bar'=>'linear-gradient(90deg,#7b1fa2,#9c27b0)',
             'title'=>$faculty_why['tile4_title'], 'desc'=>$faculty_why['tile4_desc']],
            ['ic'=>'fas fa-comments',      'clr'=>'#2e7d32','bg'=>'rgba(46,125,50,0.1)',  'bar'=>'linear-gradient(90deg,#2e7d32,#43a047)',
             'title'=>$faculty_why['tile5_title'], 'desc'=>$faculty_why['tile5_desc']],
            ['ic'=>'fas fa-hands-helping', 'clr'=>'#00695c','bg'=>'rgba(0,105,92,0.1)',   'bar'=>'linear-gradient(90deg,#00695c,#00897b)',
             'title'=>$faculty_why['tile6_title'], 'desc'=>$faculty_why['tile6_desc']],
        ];
        foreach($why as $i=>$w):
        ?>
        <div class="fac-why-tile" data-fac-delay="<?php echo $i*80; ?>">
            <style>.fac-why-tile:nth-child(<?php echo $i+1; ?>)::before{background:<?php echo $w['bar']; ?>;}</style>
            <div class="fac-why-ico" style="background:<?php echo $w['bg']; ?>;">
                <i class="<?php echo $w['ic']; ?>" style="color:<?php echo $w['clr']; ?>;"></i>
            </div>
            <h4><?php echo htmlspecialchars($w['title']); ?></h4>
            <p><?php echo htmlspecialchars($w['desc']); ?></p>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── CTA ── -->
<section class="fac-cta">
    <div class="container">
        <div style="display:flex;align-items:center;gap:44px;flex-wrap:wrap;position:relative;z-index:1;">
            <div style="flex:1 1 320px;">
                <div style="display:inline-flex;align-items:center;gap:7px;background:rgba(245,130,32,0.12);border:1px solid rgba(245,130,32,0.3);color:var(--accent-color);padding:6px 16px;border-radius:50px;font-size:10.5px;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:14px;">
                    <i class="fas fa-chalkboard-teacher" style="font-size:9px;"></i> <?php echo htmlspecialchars($faculty_cta_content['badge']); ?>
                </div>
                <h2 style="font-size:28px;font-weight:800;color:#fff;margin:0 0 10px;line-height:1.22;">
                    <?php echo htmlspecialchars(applySiteNamePlaceholder($faculty_cta_content['heading_line1'])); ?><br>
                    <span style="background:linear-gradient(90deg,var(--accent-color),#FFC107);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"><?php echo htmlspecialchars($faculty_cta_content['heading_line2']); ?></span>
                </h2>
                <p style="color:rgba(255,255,255,0.68);font-size:14px;margin:0;line-height:1.7;">
                    <?php echo htmlspecialchars($faculty_cta_content['subtext']); ?>
                </p>
            </div>
            <div style="display:flex;flex-direction:column;gap:14px;flex-shrink:0;">
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="admission.php"
                       style="display:inline-flex;align-items:center;gap:8px;background:var(--accent-color);color:#fff;padding:12px 26px;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;transition:all 0.3s ease;"
                       onmouseover="this.style.background='#D96C0F';this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='var(--accent-color)';this.style.transform='';">
                        <i class="fas fa-graduation-cap"></i> Apply for Admission
                    </a>
                    <a href="courses.php"
                       style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.25);color:#fff;padding:12px 26px;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;transition:all 0.3s ease;"
                       onmouseover="this.style.background='rgba(255,255,255,0.16)';this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.transform='';">
                        <i class="fas fa-book-open"></i> View Courses
                    </a>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.72);padding:5px 13px;border-radius:50px;font-size:11.5px;font-weight:600;">
                        <i class="fas fa-check-circle" style="color:var(--accent-color);font-size:10px;"></i> <?php echo htmlspecialchars($faculty_cta_content['pill1']); ?>
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.72);padding:5px 13px;border-radius:50px;font-size:11.5px;font-weight:600;">
                        <i class="fas fa-check-circle" style="color:var(--accent-color);font-size:10px;"></i> <?php echo htmlspecialchars($faculty_cta_content['pill2']); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function(){
    var els = document.querySelectorAll('.fac-card, .fac-why-tile');
    if(!els.length) return;
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(!e.isIntersecting) return;
            var d = parseInt(e.target.dataset.facDelay)||0;
            setTimeout(function(){ e.target.classList.add('fac-in'); }, d);
            obs.unobserve(e.target);
        });
    },{threshold:0.08});
    els.forEach(function(el){ obs.observe(el); });
})();
</script>

<?php include 'includes/footer.php'; ?>
