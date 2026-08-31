    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <!-- About Column -->
                <div class="footer-section">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                        <img src="<?php echo getLogoPath(); ?>" alt="Logo" style="height:48px;width:48px;border-radius:50%;object-fit:contain;object-position:center;flex-shrink:0;" onerror="this.style.display='none'">
                        <span style="font-size:17px;font-weight:700;color:white;line-height:1.2;"><?php echo getSiteName(); ?></span>
                    </div>
                    <p style="line-height:1.85;font-size:13.5px;"><?php echo htmlspecialchars(getFooterContent()['about_text']); ?></p>
                    <div class="social-links">
                        <?php
                        $social = getSocialMedia();
                        if (!empty($social['facebook'])): ?>
                            <a href="<?php echo htmlspecialchars($social['facebook']); ?>" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <?php endif;
                        if (!empty($social['instagram'])): ?>
                            <a href="<?php echo htmlspecialchars($social['instagram']); ?>" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <?php endif;
                        if (!empty($social['youtube'])): ?>
                            <a href="<?php echo htmlspecialchars($social['youtube']); ?>" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <?php endif;
                        if (!empty($social['twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($social['twitter']); ?>" target="_blank" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="courses.php">Our Courses</a></li>
                        <li><a href="admission.php">Admission</a></li>
                        <li><a href="faculty.php">Our Faculty</a></li>
                        <li><a href="events.php">Events &amp; News</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                    </ul>
                </div>

                <!-- Programs -->
                <div class="footer-section">
                    <h3>Programs</h3>
                    <ul>
                        <li><a href="courses.php">Matric Programs</a></li>
                        <li><a href="courses.php">Middle & Primary Section</a></li>
                        <li><a href="courses.php">Nursery & Prep</a></li>
                        <li><a href="courses.php">Matric Science Group</a></li>
                        <li><a href="courses.php">Matric Computer Science Group</a></li>
                        <li><a href="examination.php">Examination Info</a></li>
                        <li><a href="downloads.php">Downloads</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        <div style="display:flex;gap:12px;align-items:flex-start;">
                            <span style="width:32px;height:32px;background:rgba(245,130,32,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                <i class="fas fa-map-marker-alt" style="color:var(--accent-color);font-size:14px;"></i>
                            </span>
                            <p style="margin:0;line-height:1.6;"><?php echo nl2br(htmlspecialchars(getSiteAddress())); ?></p>
                        </div>
                        <div style="display:flex;gap:12px;align-items:flex-start;">
                            <span style="width:32px;height:32px;background:rgba(245,130,32,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-phone-alt" style="color:var(--accent-color);font-size:13px;"></i>
                            </span>
                            <div style="line-height:1.9;">
                                <?php
                                $phone = getSitePhone();
                                $phone_numbers = explode(',', $phone);
                                foreach ($phone_numbers as $number): ?>
                                    <a href="tel:<?php echo str_replace([' ', '-'], '', trim($number)); ?>" style="display:block;"><?php echo htmlspecialchars(trim($number)); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div style="display:flex;gap:12px;align-items:center;">
                            <span style="width:32px;height:32px;background:rgba(245,130,32,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-envelope" style="color:var(--accent-color);font-size:13px;"></i>
                            </span>
                            <a href="mailto:<?php echo getSiteEmail(); ?>"><?php echo getSiteEmail(); ?></a>
                        </div>
                        <div style="display:flex;gap:12px;align-items:center;">
                            <span style="width:32px;height:32px;background:rgba(245,130,32,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-clock" style="color:var(--accent-color);font-size:13px;"></i>
                            </span>
                            <p style="margin:0;"><?php echo htmlspecialchars(getOfficeHours()); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo getSiteName(); ?>. All rights reserved. &nbsp;|&nbsp; Designed by <a href="#" style="color:var(--accent-color);">Computech</a></p>
            </div>
        </div>
    </footer>

    <!-- Analytics Tracker -->
    <?php
    if (file_exists(__DIR__ . '/analytics_tracker.php')) {
        include __DIR__ . '/analytics_tracker.php';
    }
    ?>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
</body>
</html>
