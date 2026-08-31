<?php
require_once 'includes/config.php';
$page_title = 'Courses & Programs';

// Fetch from DB
$courses_result = mysqli_query($conn, "SELECT * FROM courses WHERE status='active' ORDER BY display_order ASC");
$db_courses = [];
if ($courses_result && mysqli_num_rows($courses_result) > 0) {
    while ($r = mysqli_fetch_assoc($courses_result)) {
        $r['cat'] = $r['category'] ?: 'default';
        $db_courses[] = $r;
    }
}
$courses_hero = getCoursesHero();
$courses_req = getCoursesRequirements();
$courses_cta_content = getCoursesCta();
?>
<?php include 'includes/header.php'; ?>

<style>
/* ── Courses Page ── */

/* Hero */
.cr-hero {
    position:relative; overflow:hidden;
    min-height:300px; display:flex; align-items:center;
    background:linear-gradient(130deg,rgba(8,29,64,0.84),rgba(13,43,94,0.9)),
               url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1600') center/cover no-repeat;
    padding:68px 0;
}
.cr-orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(80px); }
.cr-hero-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(245,130,32,0.12); border:1px solid rgba(245,130,32,0.35);
    color:var(--accent-color); padding:6px 18px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:16px;
}
.cr-hero h1 {
    font-size:40px; font-weight:800; color:#fff;
    margin:0 0 12px; line-height:1.15;
    text-shadow:0 4px 20px rgba(0,0,0,0.4);
}
.cr-hero h1 span {
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
.cr-hero p { color:rgba(255,255,255,0.72); font-size:15px; margin:0; max-width:500px; line-height:1.7; }
.cr-breadcrumb {
    display:flex; align-items:center; gap:8px;
    font-size:12px; color:rgba(255,255,255,0.5); margin-bottom:18px;
}
.cr-breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
.cr-breadcrumb a:hover { color:var(--accent-color); }

/* ── Filter Tabs ── */
.cr-filter-wrap {
    background:#fff;
    border-bottom:1px solid rgba(24,74,156,0.1);
    padding:18px 0; position:sticky; top:0; z-index:50;
    box-shadow:0 2px 16px rgba(0,0,0,0.06);
}
.cr-filter-inner {
    display:flex; align-items:center; gap:10px;
    flex-wrap:wrap;
}
.cr-filter-btn {
    display:inline-flex; align-items:center; gap:7px;
    padding:8px 20px; border-radius:50px;
    border:1px solid rgba(24,74,156,0.2);
    background:transparent; color:var(--text-light);
    font-size:12.5px; font-weight:600; cursor:pointer;
    transition:all 0.3s ease; white-space:nowrap;
}
.cr-filter-btn:hover { border-color:var(--primary-color); color:var(--primary-color); background:rgba(13,43,94,0.05); }
.cr-filter-btn.active {
    background:var(--primary-color); color:#fff; border-color:var(--primary-color);
    box-shadow:0 4px 16px rgba(13,43,94,0.3);
}
.cr-filter-btn .cr-count {
    background:rgba(255,255,255,0.2); padding:1px 7px;
    border-radius:50px; font-size:10px; font-weight:700;
}
.cr-filter-btn:not(.active) .cr-count {
    background:rgba(13,43,94,0.1); color:var(--primary-color);
}

/* ── Courses Grid ── */
.cr-section { padding:52px 0 60px; background:#f8fffe; }
.cr-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:20px;
}

/* Course Card */
.cr-card {
    background:#fff; border-radius:20px;
    border:1px solid rgba(24,74,156,0.1);
    overflow:hidden;
    transition:transform 0.35s cubic-bezier(0.25,1,0.5,1),
               box-shadow 0.35s ease, border-color 0.3s;
    opacity:0; transform:translateY(35px);
    display:flex; flex-direction:column;
}
.cr-card.cr-in { animation:crIn 0.6s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes crIn {
    from { opacity:0; transform:translateY(35px) scale(0.96); }
    to   { opacity:1; transform:translateY(0)    scale(1); }
}
.cr-card:hover {
    transform:translateY(-8px);
    box-shadow:0 20px 50px rgba(24,74,156,0.12);
    border-color:rgba(24,74,156,0.22);
}

/* Card Top Banner */
.cr-card-top {
    padding:22px 22px 18px;
    position:relative; overflow:hidden;
}
.cr-card-top::after {
    content:''; position:absolute; bottom:0; left:0; right:0; height:1px;
    background:linear-gradient(90deg,transparent,rgba(24,74,156,0.15),transparent);
}
.cr-cat-badge {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 12px; border-radius:50px; font-size:10px;
    font-weight:700; letter-spacing:1px; text-transform:uppercase;
    margin-bottom:14px;
}
.cr-icon-wrap {
    width:52px; height:52px; border-radius:15px;
    display:flex; align-items:center; justify-content:center;
    font-size:22px; margin-bottom:14px;
    transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
.cr-card:hover .cr-icon-wrap { transform:scale(1.1) rotate(-6deg); }
.cr-card-top h3 {
    font-size:15.5px; font-weight:800; color:var(--text-dark);
    margin:0 0 6px; line-height:1.3;
}
.cr-card-top p {
    font-size:12.5px; color:var(--text-light);
    margin:0; line-height:1.6;
}

/* Card Footer */
.cr-card-foot {
    padding:14px 22px 18px;
    margin-top:auto;
    display:flex; flex-direction:column; gap:12px;
}
.cr-tags { display:flex; gap:8px; flex-wrap:wrap; }
.cr-tag {
    display:inline-flex; align-items:center; gap:5px;
    background:rgba(13,43,94,0.07);
    border:1px solid rgba(13,43,94,0.15);
    color:var(--primary-color); padding:4px 10px;
    border-radius:6px; font-size:11.5px; font-weight:600;
}
.cr-tag i { font-size:10px; }
.cr-enroll {
    display:inline-flex; align-items:center; gap:7px;
    background:var(--primary-color); color:#fff;
    padding:10px 22px; border-radius:9px;
    font-size:13px; font-weight:700; text-decoration:none;
    transition:all 0.3s cubic-bezier(0.25,1,0.5,1);
    align-self:flex-start;
}
.cr-enroll:hover {
    background:var(--primary-dark); transform:translateY(-2px);
    box-shadow:0 8px 22px rgba(13,43,94,0.3); color:#fff;
}

/* No results */
.cr-empty {
    grid-column:1/-1; text-align:center; padding:40px;
    color:var(--text-light); font-size:15px;
}

/* ── Requirements ── */
.cr-req { padding:58px 0; background:#fff; }
.cr-req-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:20px; margin-top:40px;
}
.cr-req-card {
    border-radius:18px; overflow:hidden;
    border:1px solid rgba(24,74,156,0.1);
    opacity:0; transform:translateY(28px);
    transition:transform 0.35s ease, box-shadow 0.35s ease;
}
.cr-req-card.cr-in { animation:crIn 0.6s cubic-bezier(0.22,1,0.36,1) both; }
.cr-req-card:hover { transform:translateY(-5px); box-shadow:0 14px 36px rgba(24,74,156,0.1); }
.cr-req-head {
    padding:16px 22px;
    display:flex; align-items:center; gap:11px;
}
.cr-req-head h4 { color:#fff; font-size:14.5px; font-weight:700; margin:0; }
.cr-req-head i { font-size:18px; color:rgba(255,255,255,0.8); }
.cr-req-body { padding:6px 0 16px; background:#fff; }
.cr-req-item {
    display:flex; align-items:center; gap:10px;
    padding:9px 22px;
    border-bottom:1px solid rgba(24,74,156,0.06);
    font-size:13px; color:var(--text-dark);
}
.cr-req-item:last-child { border-bottom:none; }
.cr-req-item i { color:var(--primary-color); font-size:11px; flex-shrink:0; }

/* ── Section Header shared ── */
.cr-sh { text-align:center; margin-bottom:8px; }
.cr-sh-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(13,43,94,0.08); border:1px solid rgba(13,43,94,0.22);
    color:var(--primary-color); padding:6px 16px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:12px;
}
.cr-sh h2 { font-size:30px; font-weight:800; color:var(--text-dark); margin:0 0 8px; }
.cr-sh h2 span { color:var(--primary-color); }
.cr-sh p { color:var(--text-light); font-size:14px; margin:0; }

/* ── CTA ── */
.cr-cta {
    padding:52px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    position:relative; overflow:hidden;
}
.cr-cta::before {
    content:''; position:absolute; top:-100px; right:-100px;
    width:300px; height:300px;
    background:radial-gradient(circle,rgba(245,130,32,0.09) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}

/* ── Responsive ── */
@media(max-width:1024px) { .cr-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:760px) {
    .cr-grid { grid-template-columns:1fr; }
    .cr-req-grid { grid-template-columns:1fr; }
    .cr-hero h1 { font-size:28px; }
}
</style>

<!-- ── Hero ── -->
<section class="cr-hero">
    <div class="cr-orb" style="width:380px;height:380px;background:rgba(24,74,156,0.2);top:-120px;right:-100px;"></div>
    <div class="cr-orb" style="width:240px;height:240px;background:rgba(245,130,32,0.08);bottom:-70px;left:-60px;"></div>
    <div class="container" style="position:relative;z-index:2;">
        <div class="cr-breadcrumb">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <span>Courses & Programs</span>
        </div>
        <div class="cr-hero-badge">
            <i class="fas fa-book-open" style="font-size:9px;"></i>
            <?php echo htmlspecialchars($courses_hero['badge']); ?>
        </div>
        <h1>Our <span>Courses & Programs</span></h1>
        <p><?php echo htmlspecialchars($courses_hero['subtitle']); ?></p>
    </div>
</section>

<?php
// ── Define default courses with categories ──
// (Nursery-to-Matric school — no intermediate/college-level programs)
$default_courses = [
    // Regular Programs
    ['id'=>null,'icon'=>'fa-child','cat'=>'regular','cat_label'=>'Regular Program',
     'name'=>'Nursery & Prep (Early Years)',
     'description'=>'A warm, play-based foundation stage building early literacy, numeracy, and social skills in a caring classroom environment.',
     'duration'=>'2 Years'],
    ['id'=>null,'icon'=>'fa-book-reader','cat'=>'regular','cat_label'=>'Regular Program',
     'name'=>'Primary Section (Class 1–5)',
     'description'=>'A strong academic foundation in English, Urdu, Mathematics, Science, Islamiat, and Social Studies.',
     'duration'=>'5 Years'],
    ['id'=>null,'icon'=>'fa-book-open','cat'=>'regular','cat_label'=>'Regular Program',
     'name'=>'Middle Section (Class 6–8)',
     'description'=>'An expanded curriculum with core subjects plus introductory Computer Studies, preparing students for Matriculation.',
     'duration'=>'3 Years'],
    ['id'=>null,'icon'=>'fa-flask','cat'=>'regular','cat_label'=>'Regular Program',
     'name'=>'Matric – Science Group (Class 9–10)',
     'description'=>'Physics, Chemistry, Biology, Mathematics & English with a strong focus on board exam preparation and lab work.',
     'duration'=>'2 Years'],
    ['id'=>null,'icon'=>'fa-laptop-code','cat'=>'regular','cat_label'=>'Regular Program',
     'name'=>'Matric – Computer Science Group (Class 9–10)',
     'description'=>'Computer Science, Mathematics, Physics & English for students interested in technology and IT-related fields.',
     'duration'=>'2 Years'],
    ['id'=>null,'icon'=>'fa-landmark','cat'=>'regular','cat_label'=>'Regular Program',
     'name'=>'Matric – Arts/Humanities Group (Class 9–10)',
     'description'=>'Urdu, Islamiat, Pakistan Studies, Civics & Economics/General Science for students pursuing arts, commerce or humanities.',
     'duration'=>'2 Years'],
];

// Use DB data if available, otherwise use defaults
$courses_to_show = !empty($db_courses) ? $db_courses : $default_courses;

// Category meta
$cat_meta = [
    'regular' => ['label'=>'Regular Programs','color'=>'#0D2B5E','bg'=>'rgba(13,43,94,0.1)','grad'=>'linear-gradient(135deg,var(--primary-color),var(--secondary-color))'],
    'test'    => ['label'=>'Test Preparation','color'=>'#D96C0F','bg'=>'rgba(245,130,32,0.12)','grad'=>'linear-gradient(135deg,#D96C0F,var(--accent-color))'],
    'short'   => ['label'=>'Short Courses',   'color'=>'#7b1fa2','bg'=>'rgba(123,31,162,0.1)','grad'=>'linear-gradient(135deg,#7b1fa2,#9c27b0)'],
    'default' => ['label'=>'Program',         'color'=>'#0D2B5E','bg'=>'rgba(13,43,94,0.1)','grad'=>'linear-gradient(135deg,var(--primary-color),var(--secondary-color))'],
];

// Count by category
$cat_counts = ['all'=>count($courses_to_show),'regular'=>0,'test'=>0,'short'=>0];
foreach($courses_to_show as $c){
    $cat = $c['cat'] ?? 'default';
    if(isset($cat_counts[$cat])) $cat_counts[$cat]++;
}
?>

<!-- ── Filter Tabs ── -->
<div class="cr-filter-wrap">
    <div class="container">
        <div class="cr-filter-inner">
            <button class="cr-filter-btn active" data-filter="all">
                <i class="fas fa-th-large"></i> All Programs
                <span class="cr-count"><?php echo $cat_counts['all']; ?></span>
            </button>
            <?php if($cat_counts['regular']): ?>
            <button class="cr-filter-btn" data-filter="regular">
                <i class="fas fa-graduation-cap"></i> Regular Programs
                <span class="cr-count"><?php echo $cat_counts['regular']; ?></span>
            </button>
            <?php endif; ?>
            <?php if($cat_counts['test']): ?>
            <button class="cr-filter-btn" data-filter="test">
                <i class="fas fa-pencil-alt"></i> Test Preparation
                <span class="cr-count"><?php echo $cat_counts['test']; ?></span>
            </button>
            <?php endif; ?>
            <?php if($cat_counts['short']): ?>
            <button class="cr-filter-btn" data-filter="short">
                <i class="fas fa-clock"></i> Short Courses
                <span class="cr-count"><?php echo $cat_counts['short']; ?></span>
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ── Courses Grid ── -->
<section class="cr-section">
    <div class="container">
        <div class="cr-grid" id="crGrid">
        <?php foreach($courses_to_show as $idx => $course):
            $cat  = $course['cat'] ?? 'default';
            $meta = $cat_meta[$cat] ?? $cat_meta['default'];
            $icon = $course['icon'] ?? 'fa-book';
            $link = $course['id'] ? "admission.php?course={$course['id']}" : "admission.php";
        ?>
            <div class="cr-card" data-cat="<?php echo htmlspecialchars($cat); ?>"
                 data-cr-delay="<?php echo ($idx % 3) * 90; ?>">

                <div class="cr-card-top">
                    <div class="cr-cat-badge"
                         style="background:<?php echo $meta['bg']; ?>;color:<?php echo $meta['color']; ?>;">
                        <?php echo htmlspecialchars($meta['label']); ?>
                    </div>
                    <div class="cr-icon-wrap"
                         style="background:<?php echo $meta['bg']; ?>;">
                        <i class="fas <?php echo htmlspecialchars($icon); ?>"
                           style="color:<?php echo $meta['color']; ?>;"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                    <p><?php echo htmlspecialchars($course['description']); ?></p>
                </div>

                <div class="cr-card-foot">
                    <div class="cr-tags">
                        <?php if(!empty($course['duration'])): ?>
                        <span class="cr-tag">
                            <i class="fas fa-clock"></i>
                            <?php echo htmlspecialchars($course['duration']); ?>
                        </span>
                        <?php endif; ?>
                        <?php if(!empty($course['fee'])): ?>
                        <span class="cr-tag" style="background:rgba(245,130,32,0.08);border-color:rgba(245,130,32,0.25);color:#D96C0F;">
                            <i class="fas fa-tag"></i>
                            Rs. <?php echo htmlspecialchars($course['fee']); ?>/mo
                        </span>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo $link; ?>" class="cr-enroll">
                        Enroll Now <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── Admission Requirements ── -->
<section class="cr-req">
    <div class="container">
        <div class="cr-sh">
            <div class="cr-sh-badge">
                <i class="fas fa-file-alt" style="font-size:9px;"></i>
                <?php echo htmlspecialchars($courses_req['badge']); ?>
            </div>
            <h2><?php echo renderHighlightedTitle($courses_req['title'], $courses_req['title_highlight'], 'span'); ?></h2>
            <p><?php echo htmlspecialchars($courses_req['subtitle']); ?></p>
        </div>
        <div class="cr-req-grid">
            <?php
            $reqs = [
                ['head'=>$courses_req['req1_head'], 'icon'=>'fa-graduation-cap',
                 'grad'=>'linear-gradient(135deg,var(--primary-color),var(--secondary-color))',
                 'items'=>array_values(array_filter(array_map('trim', explode("\n", $courses_req['req1_items']))))],
                ['head'=>$courses_req['req2_head'], 'icon'=>'fa-university',
                 'grad'=>'linear-gradient(135deg,#1565c0,#1976d2)',
                 'items'=>array_values(array_filter(array_map('trim', explode("\n", $courses_req['req2_items']))))],
                ['head'=>$courses_req['req3_head'], 'icon'=>'fa-clock',
                 'grad'=>'linear-gradient(135deg,#7b1fa2,#9c27b0)',
                 'items'=>array_values(array_filter(array_map('trim', explode("\n", $courses_req['req3_items']))))],
            ];
            foreach($reqs as $ri => $req):
            ?>
            <div class="cr-req-card" data-cr-delay="<?php echo $ri*110; ?>">
                <div class="cr-req-head" style="background:<?php echo $req['grad']; ?>;">
                    <i class="fas <?php echo $req['icon']; ?>"></i>
                    <h4>For <?php echo htmlspecialchars($req['head']); ?></h4>
                </div>
                <div class="cr-req-body">
                    <?php foreach($req['items'] as $item): ?>
                    <div class="cr-req-item">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($item); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── CTA ── -->
<section class="cr-cta">
    <div class="container">
        <div style="display:flex;align-items:center;gap:44px;flex-wrap:wrap;position:relative;z-index:1;">
            <div style="flex:1 1 320px;">
                <div style="display:inline-flex;align-items:center;gap:7px;background:rgba(245,130,32,0.12);border:1px solid rgba(245,130,32,0.3);color:var(--accent-color);padding:6px 16px;border-radius:50px;font-size:10.5px;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:14px;">
                    <i class="fas fa-rocket" style="font-size:9px;"></i> <?php echo htmlspecialchars($courses_cta_content['badge']); ?>
                </div>
                <h2 style="font-size:28px;font-weight:800;color:#fff;margin:0 0 10px;line-height:1.22;">
                    <?php echo htmlspecialchars($courses_cta_content['heading_line1']); ?><br>
                    <span style="background:linear-gradient(90deg,var(--accent-color),#FFC107);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"><?php echo htmlspecialchars($courses_cta_content['heading_line2']); ?></span>
                </h2>
                <p style="color:rgba(255,255,255,0.68);font-size:14px;margin:0;line-height:1.7;">
                    <?php echo htmlspecialchars(applySiteNamePlaceholder($courses_cta_content['subtext'])); ?>
                </p>
            </div>
            <div style="display:flex;flex-direction:column;gap:14px;flex-shrink:0;">
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="admission.php"
                       style="display:inline-flex;align-items:center;gap:8px;background:var(--accent-color);color:#fff;padding:12px 26px;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;transition:all 0.3s ease;"
                       onmouseover="this.style.background='#D96C0F';this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='var(--accent-color)';this.style.transform='';">
                        <i class="fas fa-graduation-cap"></i> Apply Now
                    </a>
                    <a href="contact.php"
                       style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.25);color:#fff;padding:12px 26px;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;transition:all 0.3s ease;"
                       onmouseover="this.style.background='rgba(255,255,255,0.16)';this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.transform='';">
                        <i class="fas fa-question-circle"></i> Have Questions?
                    </a>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.72);padding:5px 13px;border-radius:50px;font-size:11.5px;font-weight:600;">
                        <i class="fas fa-check-circle" style="color:var(--accent-color);font-size:10px;"></i> <?php echo htmlspecialchars($courses_cta_content['pill1']); ?>
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.72);padding:5px 13px;border-radius:50px;font-size:11.5px;font-weight:600;">
                        <i class="fas fa-check-circle" style="color:var(--accent-color);font-size:10px;"></i> <?php echo htmlspecialchars($courses_cta_content['pill2']); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function(){
    /* ── Scroll-triggered entrance ── */
    var cards = document.querySelectorAll('.cr-card, .cr-req-card');
    if(cards.length){
        var obs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if(!e.isIntersecting) return;
                var d = parseInt(e.target.dataset.crDelay)||0;
                setTimeout(function(){ e.target.classList.add('cr-in'); }, d);
                obs.unobserve(e.target);
            });
        },{threshold:0.08});
        cards.forEach(function(c){ obs.observe(c); });
    }

    /* ── Category Filter ── */
    var btns  = document.querySelectorAll('.cr-filter-btn');
    var items = document.querySelectorAll('.cr-card');

    btns.forEach(function(btn){
        btn.addEventListener('click', function(){
            var filter = this.dataset.filter;

            /* Update active button */
            btns.forEach(function(b){ b.classList.remove('active'); });
            this.classList.add('active');

            /* Show/hide cards */
            var visible = 0;
            items.forEach(function(item){
                var cat = item.dataset.cat || 'default';
                var show = (filter === 'all' || cat === filter);
                if(show){
                    item.style.display = 'flex';
                    /* Re-trigger animation */
                    item.classList.remove('cr-in');
                    void item.offsetWidth;
                    var d = visible * 70;
                    setTimeout((function(el,delay){
                        return function(){ el.classList.add('cr-in'); };
                    })(item, d), d);
                    visible++;
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
})();
</script>

<?php include 'includes/footer.php'; ?>
