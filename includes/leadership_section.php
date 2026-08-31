<!-- ===================================================
     MODERN LEADERSHIP SECTION - Animated & Unique
     =================================================== -->

<style>
/* === LEADERSHIP SECTION BASE === */
.lm-section {
    padding: 80px 0;
    background: #f2fafa;
    position: relative;
    overflow: hidden;
}

/* Decorative background blobs */
.lm-section::before {
    content: '';
    position: absolute;
    top: -120px; left: -120px;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(24,74,156,0.07) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.lm-section::after {
    content: '';
    position: absolute;
    bottom: -100px; right: -100px;
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(245,130,32,0.07) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

/* === SECTION HEADER === */
.lm-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 65px;
    position: relative;
    z-index: 1;
}
.lm-header .section-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(13,43,94,0.08);
    color: var(--primary-color);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    padding: 6px 18px;
    border-radius: 50px;
    margin-bottom: 18px;
    border: 1px solid rgba(13,43,94,0.14);
    width: fit-content;
}
.lm-header h2 {
    font-size: 38px;
    font-weight: 800;
    color: #1A2B2C;
    position: relative;
    margin-bottom: 0;
    padding-bottom: 18px;
    line-height: 1.25;
}
.lm-header h2 span { color: var(--primary-color); }
.lm-header h2::after {
    content: '';
    position: absolute;
    bottom: 0; left: 50%;
    transform: translateX(-50%);
    width: 60px; height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    border-radius: 2px;
}
.lm-header p {
    color: #607B7D;
    font-size: 15.5px;
    margin-top: 22px;
    max-width: 520px;
    line-height: 1.7;
}

/* === CARDS WRAPPER === */
.lm-cards {
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
    z-index: 1;
}

/* === INDIVIDUAL CARD === */
.lm-card {
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 0;
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(24,74,156,0.10);
    border: 1px solid rgba(24,74,156,0.08);
    opacity: 0;
    transform: translateY(45px);
    transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1),
                transform 0.7s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.35s ease;
    margin-bottom: 28px;
    min-height: 360px;
}
.lm-card:last-child { margin-bottom: 0; }

.lm-card.lm-visible {
    opacity: 1;
    transform: translateY(0);
}
.lm-card:hover {
    box-shadow: 0 18px 60px rgba(24,74,156,0.15);
    transform: translateY(-3px);
}

/* Reversed layout for even cards */
.lm-card.lm-reverse {
    grid-template-columns: 1fr 340px;
}
.lm-card.lm-reverse .lm-image-side { order: 2; }
.lm-card.lm-reverse .lm-quote-side { order: 1; }

/* === IMAGE SIDE === */
.lm-image-side {
    background: linear-gradient(160deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 44px 36px;
    position: relative;
    overflow: hidden;
}

/* Decorative circles inside image panel */
.lm-image-side::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 50%;
}
.lm-image-side::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -40px;
    width: 260px; height: 260px;
    border: 1px solid rgba(245,130,32,0.1);
    border-radius: 50%;
}

/* Image wrapper with animated rings */
.lm-img-wrap {
    position: relative;
    margin-bottom: 28px;
    z-index: 1;
}

/* Outer animated ring */
.lm-img-wrap::before {
    content: '';
    position: absolute;
    inset: -10px;
    border-radius: 50%;
    border: 2px solid rgba(245,130,32,0.4);
    animation: ringRotate 8s linear infinite;
    background: conic-gradient(
        var(--accent-color) 0deg,
        transparent 120deg,
        transparent 240deg,
        rgba(245,130,32,0.3) 360deg
    );
    border: none;
    background-clip: padding-box;
}

/* Inner subtle ring */
.lm-img-wrap::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.15);
}

@keyframes ringRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Actual photo */
.lm-photo {
    width: 170px;
    height: 170px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center top;
    border: 4px solid rgba(255,255,255,0.25);
    display: block;
    position: relative;
    z-index: 1;
    transition: transform 0.5s ease;
}
.lm-card:hover .lm-photo {
    transform: scale(1.04);
}

/* Placeholder icon when no photo */
.lm-photo-placeholder {
    width: 170px;
    height: 170px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 70px;
    color: rgba(255,255,255,0.5);
    border: 4px solid rgba(255,255,255,0.15);
    position: relative;
    z-index: 1;
}

/* Role badge */
.lm-role-badge {
    display: inline-block;
    background: var(--accent-color);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 5px 16px;
    border-radius: 50px;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.lm-person-name {
    font-size: 22px;
    font-weight: 800;
    color: white;
    text-align: center;
    margin-bottom: 5px;
    position: relative;
    z-index: 1;
    line-height: 1.2;
}

.lm-person-desig {
    font-size: 13px;
    color: rgba(255,255,255,0.65);
    text-align: center;
    font-weight: 400;
    position: relative;
    z-index: 1;
    letter-spacing: 0.3px;
}

/* === QUOTE SIDE === */
.lm-quote-side {
    padding: 44px 52px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
    background: white;
}

/* Giant background quote mark */
.lm-quote-bg {
    position: absolute;
    top: 20px; left: 30px;
    font-size: 200px;
    font-family: Georgia, serif;
    font-weight: 900;
    color: var(--primary-color);
    opacity: 0.04;
    line-height: 1;
    pointer-events: none;
    user-select: none;
    transition: opacity 0.5s ease;
}
.lm-card:hover .lm-quote-bg { opacity: 0.07; }

/* Decorative left accent bar */
.lm-accent-bar {
    position: absolute;
    left: 0; top: 50px; bottom: 50px;
    width: 5px;
    background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
    border-radius: 0 4px 4px 0;
}

/* Opening quote icon */
.lm-quote-icon {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
    position: relative;
    z-index: 1;
}
.lm-quote-icon i {
    font-size: 28px;
    color: var(--primary-color);
    opacity: 0.7;
}
.lm-quote-icon span {
    height: 2px;
    width: 50px;
    background: linear-gradient(90deg, var(--primary-color), transparent);
    border-radius: 2px;
}

/* Message text */
.lm-message-text {
    font-size: 15px;
    line-height: 1.9;
    color: #3D5255;
    position: relative;
    z-index: 1;
    font-style: italic;
    flex: 1;
}

/* Footer with signature */
.lm-card-footer {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-top: 30px;
    padding-top: 22px;
    border-top: 1px solid rgba(24,74,156,0.1);
    position: relative;
    z-index: 1;
}

.lm-sig-img {
    height: 42px;
    width: auto;
    max-width: 130px;
    opacity: 0.75;
    filter: saturate(0);
}

.lm-footer-name {
    font-size: 15px;
    font-weight: 700;
    color: var(--primary-color);
    display: block;
    line-height: 1.2;
    margin-bottom: 3px;
}
.lm-footer-role {
    font-size: 12.5px;
    color: #607B7D;
    letter-spacing: 0.3px;
}

/* === SEPARATOR BETWEEN CARDS === */
.lm-separator {
    display: flex;
    align-items: center;
    gap: 18px;
    margin: 0 auto 32px;
    max-width: 300px;
}
.lm-sep-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(24,74,156,0.2), transparent);
}
.lm-sep-dot {
    width: 38px; height: 38px;
    background: white;
    border: 2px solid rgba(24,74,156,0.18);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    font-size: 15px;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(24,74,156,0.1);
}

/* === NO LEADERS FALLBACK === */
.lm-empty {
    text-align: center;
    padding: 60px;
    color: #607B7D;
    background: white;
    border-radius: 20px;
    border: 2px dashed rgba(24,74,156,0.15);
}

/* === RESPONSIVE === */
@media (max-width: 960px) {
    .lm-card,
    .lm-card.lm-reverse {
        grid-template-columns: 1fr;
        min-height: auto;
    }
    .lm-card.lm-reverse .lm-image-side { order: 1; }
    .lm-card.lm-reverse .lm-quote-side { order: 2; }
    .lm-image-side { padding: 40px 30px 35px; }
    .lm-quote-side { padding: 38px 34px; }
    .lm-accent-bar {
        top: 0; bottom: auto;
        left: 34px; right: 34px;
        width: auto; height: 4px;
        border-radius: 0 0 4px 4px;
    }
}
@media (max-width: 480px) {
    .lm-photo, .lm-photo-placeholder { width: 140px; height: 140px; }
    .lm-person-name { font-size: 18px; }
    .lm-quote-side { padding: 30px 22px; }
    .lm-message-text { font-size: 14px; }
    .lm-header h2 { font-size: 26px; }
    .lm-quote-bg { font-size: 140px; }
}
</style>

<section class="lm-section">
    <div class="container">

        <!-- Section Header -->
        <?php $leadership_header = getLeadershipHeader(); ?>
        <div class="lm-header">
            <span class="section-label"><i class="fas fa-users" style="margin-right:6px;"></i><?php echo htmlspecialchars($leadership_header['badge']); ?></span>
            <h2><?php echo renderHighlightedTitle($leadership_header['title'], $leadership_header['highlight'], 'span'); ?></h2>
            <p><?php echo htmlspecialchars($leadership_header['subtitle']); ?></p>
        </div>

        <!-- Cards -->
        <div class="lm-cards">
            <?php
            $leaders = getLeadershipMessages();
            if (!empty($leaders)):
                $count = 0;
                foreach ($leaders as $leader):
                    $count++;
                    $is_reverse = ($count % 2 === 0);
                    $is_last    = ($count === count($leaders));
            ?>

            <!-- Leader Card -->
            <div class="lm-card <?php echo $is_reverse ? 'lm-reverse' : ''; ?> lm-animate-card">

                <!-- IMAGE SIDE -->
                <div class="lm-image-side">
                    <div class="lm-img-wrap">
                        <?php if (!empty($leader['photo'])): ?>
                            <img src="<?php echo htmlspecialchars($leader['photo']); ?>"
                                 alt="<?php echo htmlspecialchars($leader['name']); ?>"
                                 class="lm-photo"
                                 onerror="this.parentElement.innerHTML='<div class=\'lm-photo-placeholder\'><i class=\'fas fa-user-tie\'></i></div>'">
                        <?php else: ?>
                            <div class="lm-photo-placeholder">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($leader['role_title'])): ?>
                        <span class="lm-role-badge"><?php echo htmlspecialchars($leader['role_title']); ?></span>
                    <?php endif; ?>

                    <h3 class="lm-person-name"><?php echo htmlspecialchars($leader['name']); ?></h3>
                    <p class="lm-person-desig"><?php echo htmlspecialchars($leader['designation']); ?></p>
                </div>

                <!-- QUOTE SIDE -->
                <div class="lm-quote-side">
                    <div class="lm-accent-bar"></div>
                    <span class="lm-quote-bg">&#10077;</span>

                    <div class="lm-quote-icon">
                        <i class="fas fa-quote-left"></i>
                        <span></span>
                    </div>

                    <div class="lm-message-text">
                        <?php echo nl2br(htmlspecialchars($leader['message'])); ?>
                    </div>

                    <div class="lm-card-footer">
                        <?php if (!empty($leader['signature'])): ?>
                            <img src="<?php echo htmlspecialchars($leader['signature']); ?>"
                                 alt="Signature" class="lm-sig-img"
                                 onerror="this.style.display='none'">
                            <div style="width:1px;height:36px;background:rgba(24,74,156,0.15);"></div>
                        <?php endif; ?>
                        <div>
                            <strong class="lm-footer-name"><?php echo htmlspecialchars($leader['name']); ?></strong>
                            <span class="lm-footer-role"><?php echo htmlspecialchars($leader['designation']); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                    // Separator between cards (not after last)
                    if (!$is_last):
            ?>
            <div class="lm-separator">
                <div class="lm-sep-line"></div>
                <div class="lm-sep-dot">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="lm-sep-line"></div>
            </div>
            <?php
                    endif;
                endforeach;
            else:
            ?>
                <div class="lm-empty">
                    <i class="fas fa-users" style="font-size:40px;color:rgba(24,74,156,0.3);display:block;margin-bottom:14px;"></i>
                    <p>No leadership messages available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- Scroll Animation Script -->
<script>
(function() {
    var cards = document.querySelectorAll('.lm-animate-card');
    if (!cards.length) return;

    var io = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry, idx) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var delay = parseInt(el.getAttribute('data-delay') || 0);
                setTimeout(function() {
                    el.classList.add('lm-visible');
                }, delay);
                io.unobserve(el);
            }
        });
    }, { threshold: 0.15 });

    cards.forEach(function(card, i) {
        card.setAttribute('data-delay', i * 180);
        io.observe(card);
    });
})();
</script>
