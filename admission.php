<?php
require_once 'includes/config.php';
$page_title = 'Admission';

$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name      = mysqli_real_escape_string($conn, $_POST['student_name']);
    $father_name       = mysqli_real_escape_string($conn, $_POST['father_name']);
    $cnic_bform        = mysqli_real_escape_string($conn, $_POST['cnic_bform']);
    $phone             = mysqli_real_escape_string($conn, $_POST['phone']);
    $email             = mysqli_real_escape_string($conn, $_POST['email']);
    $address           = mysqli_real_escape_string($conn, $_POST['address']);
    $course_id         = mysqli_real_escape_string($conn, $_POST['course_id']);
    $medium            = mysqli_real_escape_string($conn, $_POST['medium']);
    $previous_education= mysqli_real_escape_string($conn, $_POST['previous_education']);
    $message           = mysqli_real_escape_string($conn, $_POST['message']);

    $document_path = '';
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] == 0) {
        $file_name  = time() . '_' . $_FILES['documents']['name'];
        $target_dir = "uploads/documents/";
        $target_file= $target_dir . $file_name;
        if (move_uploaded_file($_FILES['documents']['tmp_name'], $target_file))
            $document_path = $target_file;
    }

    $q = "INSERT INTO admissions (student_name,father_name,cnic_bform,phone,email,address,course_id,medium,previous_education,documents,message,status,created_at)
          VALUES ('$student_name','$father_name','$cnic_bform','$phone','$email','$address','$course_id','$medium','$previous_education','$document_path','$message','pending',NOW())";

    if (mysqli_query($conn, $q)) {
        // Admin email
        $msg_admin = "<html><body style='font-family:Arial;'>
            <div style='background:#0D2B5E;color:#fff;padding:20px;text-align:center;'><h2>New Admission Application</h2></div>
            <div style='padding:20px;background:#f9f9f9;'>
            <table width='100%' style='border-collapse:collapse;'>
            <tr><td style='padding:10px;background:#f0f0f0;font-weight:bold;width:200px;'>Student Name</td><td style='padding:10px;border-bottom:1px solid #ddd;'>".htmlspecialchars($student_name)."</td></tr>
            <tr><td style='padding:10px;background:#f0f0f0;font-weight:bold;'>Father Name</td><td style='padding:10px;border-bottom:1px solid #ddd;'>".htmlspecialchars($father_name)."</td></tr>
            <tr><td style='padding:10px;background:#f0f0f0;font-weight:bold;'>Phone</td><td style='padding:10px;border-bottom:1px solid #ddd;'>".htmlspecialchars($phone)."</td></tr>
            <tr><td style='padding:10px;background:#f0f0f0;font-weight:bold;'>Program</td><td style='padding:10px;border-bottom:1px solid #ddd;'>".htmlspecialchars($course_id)."</td></tr>
            <tr><td style='padding:10px;background:#f0f0f0;font-weight:bold;'>Date</td><td style='padding:10px;'>".date('d M Y, h:i A')."</td></tr>
            </table></div>
            <div style='background:#333;color:#fff;padding:12px;text-align:center;font-size:12px;'>".SITE_NAME." — Automated Notification</div>
            </body></html>";
        $h = "MIME-Version:1.0\r\nContent-type:text/html;charset=UTF-8\r\nFrom:".SITE_NAME." <noreply@leadschoolshahpur.com>\r\nReply-To:".$email;
        mail(ADMIN_EMAIL, "New Admission - ".SITE_NAME, $msg_admin, $h);

        if (!empty($email)) {
            $msg_stu = "<html><body style='font-family:Arial;'>
                <div style='background:#0D2B5E;color:#fff;padding:24px;text-align:center;'><h2>".SITE_NAME."</h2><p>Admission Application Received</p></div>
                <div style='padding:24px;'>
                <p>Dear <strong>".htmlspecialchars($student_name)."</strong>,</p>
                <p>Your application for <strong>".htmlspecialchars($course_id)."</strong> has been received. Our team will contact you within 2-3 working days.</p>
                <p style='background:#F2F4F7;padding:14px;border-left:4px solid #0D2B5E;border-radius:4px;'><strong>Next Step:</strong> Keep your phone accessible for our admission team call.</p>
                <p>Contact: ".SITE_CONTACT." | ".ADMIN_EMAIL."</p>
                <br><p>Best Regards,<br>Admission Team<br>".SITE_NAME."</p>
                </div></body></html>";
            $hs = "MIME-Version:1.0\r\nContent-type:text/html;charset=UTF-8\r\nFrom:".SITE_NAME." <noreply@leadschoolshahpur.com>";
            mail($email, "Application Received - ".SITE_NAME, $msg_stu, $hs);
        }
        $success_message = "Your admission application has been submitted successfully! We will contact you within 2-3 working days.";
    } else {
        $error_message = "Error submitting application. Please try again.";
    }
}
?>
<?php include 'includes/header.php'; ?>

<style>
/* ── Admission Page ── */

/* Hero */
.adm-hero {
    position:relative; overflow:hidden;
    min-height:290px; display:flex; align-items:center;
    background:linear-gradient(130deg,rgba(8,29,64,0.86),rgba(10,36,73,0.92)),
               url('https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=1600') center/cover no-repeat;
    padding:65px 0;
}
.adm-orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(80px); }
.adm-hero-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(245,130,32,0.12); border:1px solid rgba(245,130,32,0.35);
    color:var(--accent-color); padding:6px 18px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:14px;
}
.adm-hero h1 { font-size:38px; font-weight:800; color:#fff; margin:0 0 10px; line-height:1.15; }
.adm-hero h1 span {
    background:linear-gradient(90deg,var(--accent-color),#FFC107);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.adm-hero p { color:rgba(255,255,255,0.72); font-size:14.5px; margin:0; max-width:480px; line-height:1.7; }
.adm-breadcrumb {
    display:flex; align-items:center; gap:8px;
    font-size:12px; color:rgba(255,255,255,0.5); margin-bottom:16px;
}
.adm-breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
.adm-breadcrumb a:hover { color:var(--accent-color); }

/* ── Main Layout ── */
.adm-main { padding:55px 0 65px; background:#f8fffe; }
.adm-layout {
    display:grid; grid-template-columns:1fr 340px;
    gap:28px; align-items:start;
}

/* ── Form Card ── */
.adm-form-card {
    background:#fff; border-radius:22px;
    border:1px solid rgba(24,74,156,0.1);
    box-shadow:0 6px 30px rgba(0,0,0,0.07);
    overflow:hidden;
}
.adm-form-header {
    background:linear-gradient(130deg,var(--primary-color),var(--primary-dark));
    padding:24px 30px;
    display:flex; align-items:center; gap:14px;
}
.adm-form-header-ico {
    width:46px; height:46px; border-radius:13px;
    background:rgba(255,255,255,0.12);
    display:flex; align-items:center; justify-content:center;
    font-size:20px; color:#fff; flex-shrink:0;
}
.adm-form-header h2 { color:#fff; font-size:18px; font-weight:700; margin:0 0 3px; }
.adm-form-header p  { color:rgba(255,255,255,0.7); font-size:12.5px; margin:0; }
.adm-form-body { padding:28px 30px; }

/* Alert */
.adm-alert {
    display:flex; align-items:flex-start; gap:12px;
    padding:14px 18px; border-radius:12px; margin-bottom:22px;
    font-size:13.5px; line-height:1.6;
}
.adm-alert-ok  { background:#d4edda; color:#155724; border:1px solid #b8dfc4; }
.adm-alert-err { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
.adm-alert i   { font-size:16px; margin-top:2px; flex-shrink:0; }

/* Field groups */
.adm-section-label {
    font-size:11px; font-weight:700; letter-spacing:1.5px;
    text-transform:uppercase; color:var(--primary-color);
    padding:0 0 8px; border-bottom:1px solid rgba(13,43,94,0.12);
    margin:22px 0 16px; display:flex; align-items:center; gap:7px;
}
.adm-section-label:first-child { margin-top:0; }
.adm-section-label i { font-size:12px; }

.adm-row { display:grid; gap:16px; }
.adm-row-2 { grid-template-columns:1fr 1fr; }

/* Modern form inputs */
.adm-field { display:flex; flex-direction:column; gap:5px; }
.adm-field label {
    font-size:12.5px; font-weight:600; color:var(--text-dark);
}
.adm-field label .req { color:#e53935; margin-left:2px; }
.adm-field input,
.adm-field select,
.adm-field textarea {
    border:1.5px solid rgba(24,74,156,0.18);
    border-radius:10px; padding:10px 14px;
    font-size:13.5px; color:var(--text-dark);
    background:#fff; transition:border-color 0.25s, box-shadow 0.25s;
    font-family:inherit; width:100%; box-sizing:border-box;
}
.adm-field input:focus,
.adm-field select:focus,
.adm-field textarea:focus {
    outline:none; border-color:var(--primary-color);
    box-shadow:0 0 0 3px rgba(24,74,156,0.1);
}
.adm-field textarea { min-height:80px; resize:vertical; }
.adm-field small { font-size:11px; color:var(--text-light); }

/* File upload */
.adm-upload {
    border:1.5px dashed rgba(24,74,156,0.3);
    border-radius:10px; padding:16px 14px;
    text-align:center; cursor:pointer;
    transition:border-color 0.25s, background 0.25s;
    background:rgba(24,74,156,0.02);
}
.adm-upload:hover { border-color:var(--primary-color); background:rgba(24,74,156,0.04); }
.adm-upload input { display:none; }
.adm-upload-label { cursor:pointer; }
.adm-upload i { font-size:22px; color:var(--primary-color); margin-bottom:6px; display:block; }
.adm-upload span { font-size:12.5px; color:var(--text-light); display:block; }
.adm-upload strong { font-size:13px; color:var(--primary-color); }

/* Submit button */
.adm-submit {
    width:100%; padding:13px; border:none; border-radius:12px;
    background:var(--primary-color); color:#fff;
    font-size:15px; font-weight:700; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:9px;
    transition:all 0.3s cubic-bezier(0.25,1,0.5,1);
    margin-top:22px; font-family:inherit;
}
.adm-submit:hover {
    background:var(--primary-dark); transform:translateY(-2px);
    box-shadow:0 10px 28px rgba(24,74,156,0.3);
}

/* ── Sidebar ── */
.adm-sidebar { display:flex; flex-direction:column; gap:20px; }

.adm-side-card {
    background:#fff; border-radius:18px;
    border:1px solid rgba(24,74,156,0.1);
    box-shadow:0 4px 18px rgba(0,0,0,0.06);
    overflow:hidden;
}
.adm-side-head {
    padding:14px 20px;
    display:flex; align-items:center; gap:10px;
    border-bottom:1px solid rgba(24,74,156,0.08);
}
.adm-side-head i { color:var(--primary-color); font-size:15px; }
.adm-side-head h4 { font-size:13.5px; font-weight:700; color:var(--text-dark); margin:0; }
.adm-side-body { padding:16px 20px; }

/* Process steps (sidebar) */
.adm-step {
    display:flex; align-items:flex-start; gap:13px;
    padding:10px 0; border-bottom:1px solid rgba(24,74,156,0.06);
}
.adm-step:last-child { border-bottom:none; padding-bottom:0; }
.adm-step-num {
    width:30px; height:30px; border-radius:50%;
    background:var(--primary-color); color:#fff;
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:800; flex-shrink:0;
}
.adm-step h5 { font-size:13px; font-weight:700; color:var(--text-dark); margin:0 0 3px; }
.adm-step p  { font-size:11.5px; color:var(--text-light); margin:0; line-height:1.5; }

/* Contact strip */
.adm-contact-row {
    display:flex; align-items:center; gap:10px;
    padding:9px 0; border-bottom:1px solid rgba(24,74,156,0.06);
    font-size:12.5px;
}
.adm-contact-row:last-child { border-bottom:none; padding-bottom:0; }
.adm-contact-ico {
    width:30px; height:30px; border-radius:9px;
    background:rgba(24,74,156,0.1);
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0;
}
.adm-contact-ico i { color:var(--primary-color); font-size:12px; }
.adm-contact-row a { color:var(--text-dark); text-decoration:none; font-weight:600; }
.adm-contact-row a:hover { color:var(--primary-color); }

/* Doc checklist */
.adm-doc-item {
    display:flex; align-items:center; gap:9px;
    padding:7px 0; border-bottom:1px solid rgba(24,74,156,0.06);
    font-size:12.5px; color:var(--text-dark);
}
.adm-doc-item:last-child { border-bottom:none; }
.adm-doc-item i { color:var(--primary-color); font-size:11px; flex-shrink:0; }

/* ── Fee Section ── */
.adm-fee { padding:55px 0; background:#fff; }
.adm-fee-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:18px; margin-top:38px;
}
.adm-fee-card {
    border-radius:18px; overflow:hidden;
    border:1px solid rgba(24,74,156,0.1);
    transition:transform 0.35s ease, box-shadow 0.35s ease;
    opacity:0; transform:translateY(28px);
}
.adm-fee-card.adm-in { animation:admIn 0.6s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes admIn {
    from { opacity:0; transform:translateY(28px); }
    to   { opacity:1; transform:translateY(0); }
}
.adm-fee-card:hover { transform:translateY(-6px); box-shadow:0 16px 40px rgba(24,74,156,0.12); }
.adm-fee-top {
    padding:20px 22px 16px;
}
.adm-fee-top i { font-size:24px; margin-bottom:10px; display:block; }
.adm-fee-top h4 { font-size:14.5px; font-weight:700; color:#fff; margin:0 0 4px; }
.adm-fee-top small { color:rgba(255,255,255,0.7); font-size:11px; }
.adm-fee-amount {
    padding:14px 22px 18px;
    background:#fff;
}
.adm-fee-amount .price {
    font-size:22px; font-weight:800; color:var(--primary-color); line-height:1;
}
.adm-fee-amount .per { font-size:11px; color:var(--text-light); margin-top:3px; }
.adm-fee-note {
    margin-top:28px; padding:16px 20px;
    background:rgba(24,74,156,0.05);
    border:1px solid rgba(24,74,156,0.1);
    border-radius:14px; font-size:13px;
    color:var(--text-dark); text-align:center; line-height:1.6;
}
.adm-fee-note strong { color:var(--primary-color); }

/* ── Section header shared ── */
.adm-sh { text-align:center; margin-bottom:6px; }
.adm-sh-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(13,43,94,0.08); border:1px solid rgba(13,43,94,0.22);
    color:var(--primary-color); padding:6px 16px; border-radius:50px;
    font-size:10.5px; font-weight:700; letter-spacing:2px;
    text-transform:uppercase; margin-bottom:12px;
}
.adm-sh h2 { font-size:28px; font-weight:800; color:var(--text-dark); margin:0 0 8px; }
.adm-sh h2 span { color:var(--primary-color); }
.adm-sh p { color:var(--text-light); font-size:14px; margin:0; }

/* ── CTA ── */
.adm-cta {
    padding:50px 0;
    background:linear-gradient(130deg,var(--primary-color) 0%,#0A2449 55%,#081D40 100%);
    position:relative; overflow:hidden;
}
.adm-cta::before {
    content:''; position:absolute; top:-100px; right:-100px;
    width:280px; height:280px;
    background:radial-gradient(circle,rgba(245,130,32,0.09) 0%,transparent 70%);
    border-radius:50%; pointer-events:none;
}

/* Responsive */
@media(max-width:960px) {
    .adm-layout { grid-template-columns:1fr; }
    .adm-sidebar { order:-1; }
    .adm-fee-grid { grid-template-columns:1fr 1fr; }
}
@media(max-width:580px) {
    .adm-row-2 { grid-template-columns:1fr; }
    .adm-fee-grid { grid-template-columns:1fr; }
    .adm-hero h1 { font-size:26px; }
}
</style>

<!-- ── Hero ── -->
<section class="adm-hero">
    <div class="adm-orb" style="width:360px;height:360px;background:rgba(24,74,156,0.2);top:-110px;right:-90px;"></div>
    <div class="adm-orb" style="width:220px;height:220px;background:rgba(245,130,32,0.07);bottom:-70px;left:-50px;"></div>
    <div class="container" style="position:relative;z-index:2;">
        <div class="adm-breadcrumb">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            <span>Admission</span>
        </div>
        <div class="adm-hero-badge">
            <i class="fas fa-graduation-cap" style="font-size:9px;"></i>
            Admissions Open
        </div>
        <h1>Apply for <span>Admission</span></h1>
        <p>Start your educational journey with <?php echo getSiteName(); ?> — fill in the form and our team will guide you through the rest.</p>
    </div>
</section>

<!-- ── Main: Form + Sidebar ── -->
<section class="adm-main">
    <div class="container">
        <div class="adm-layout">

            <!-- ── Application Form ── -->
            <div class="adm-form-card">
                <div class="adm-form-header">
                    <div class="adm-form-header-ico"><i class="fas fa-file-alt"></i></div>
                    <div>
                        <h2>Admission Application Form</h2>
                        <p>Fill in all required fields marked with *</p>
                    </div>
                </div>

                <div class="adm-form-body">
                    <?php if ($success_message): ?>
                    <div class="adm-alert adm-alert-ok">
                        <i class="fas fa-check-circle"></i>
                        <div><?php echo $success_message; ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if ($error_message): ?>
                    <div class="adm-alert adm-alert-err">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div><?php echo $error_message; ?></div>
                    </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" id="admissionForm">

                        <!-- Personal Info -->
                        <div class="adm-section-label">
                            <i class="fas fa-user"></i> Personal Information
                        </div>
                        <div class="adm-row adm-row-2" style="margin-bottom:16px;">
                            <div class="adm-field">
                                <label>Student Name <span class="req">*</span></label>
                                <input type="text" name="student_name" required placeholder="Full name">
                            </div>
                            <div class="adm-field">
                                <label>Father / Guardian Name <span class="req">*</span></label>
                                <input type="text" name="father_name" required placeholder="Father or guardian">
                            </div>
                        </div>
                        <div class="adm-row adm-row-2" style="margin-bottom:16px;">
                            <div class="adm-field">
                                <label>CNIC / B-Form <span class="req">*</span></label>
                                <input type="text" name="cnic_bform" required placeholder="12345-1234567-1">
                            </div>
                            <div class="adm-field">
                                <label>Phone Number <span class="req">*</span></label>
                                <input type="tel" name="phone" required placeholder="03001234567">
                            </div>
                        </div>
                        <div class="adm-row adm-row-2" style="margin-bottom:16px;">
                            <div class="adm-field">
                                <label>Email Address</label>
                                <input type="email" name="email" placeholder="your.email@example.com">
                            </div>
                            <div class="adm-field">
                                <label>Previous Education <span class="req">*</span></label>
                                <input type="text" name="previous_education" required placeholder="e.g., Matric – 85%, XYZ School">
                            </div>
                        </div>
                        <div class="adm-field" style="margin-bottom:16px;">
                            <label>Residential Address <span class="req">*</span></label>
                            <textarea name="address" required placeholder="Complete address..."></textarea>
                        </div>

                        <!-- Program -->
                        <div class="adm-section-label">
                            <i class="fas fa-book-open"></i> Program Selection
                        </div>
                        <div class="adm-row adm-row-2" style="margin-bottom:16px;">
                            <div class="adm-field">
                                <label>Program / Course <span class="req">*</span></label>
                                <select name="course_id" required>
                                    <option value="">— Choose a Program —</option>
                                    <?php
                                    $cr = mysqli_query($conn,"SELECT id,name FROM courses WHERE status='active' ORDER BY name ASC");
                                    if($cr && mysqli_num_rows($cr)>0){
                                        while($c=mysqli_fetch_assoc($cr)){
                                            $sel=(isset($_GET['course'])&&$_GET['course']==$c['id'])?'selected':'';
                                            echo '<option value="'.$c['id'].'" '.$sel.'>'.htmlspecialchars($c['name']).'</option>';
                                        }
                                    } else {
                                        $progs=['Nursery & Prep (Early Years)','Primary Section (Class 1–5)','Middle Section (Class 6–8)','Matric – Science Group (Class 9–10)','Matric – Computer Science Group (Class 9–10)','Matric – Arts/Humanities Group (Class 9–10)'];
                                        foreach($progs as $p) echo '<option value="'.$p.'">'.$p.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="adm-field">
                                <label>Medium of Instruction <span class="req">*</span></label>
                                <select name="medium" required>
                                    <option value="">— Choose Medium —</option>
                                    <option value="English">English</option>
                                    <option value="Urdu">Urdu</option>
                                </select>
                            </div>
                        </div>

                        <!-- Documents & Notes -->
                        <div class="adm-section-label">
                            <i class="fas fa-paperclip"></i> Documents & Notes
                        </div>
                        <div class="adm-upload" style="margin-bottom:16px;" onclick="document.getElementById('docInput').click()">
                            <input type="file" id="docInput" name="documents" accept=".pdf,.jpg,.jpeg,.png">
                            <label class="adm-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <strong>Click to Upload Documents</strong>
                                <span>PDF, JPG, PNG — Max 5MB (Optional)</span>
                            </label>
                        </div>
                        <div class="adm-field" style="margin-bottom:4px;">
                            <label>Additional Information</label>
                            <textarea name="message" placeholder="Any extra details, scholarship request, etc..."></textarea>
                        </div>

                        <button type="submit" class="adm-submit">
                            <i class="fas fa-paper-plane"></i> Submit Application
                        </button>
                    </form>
                </div>
            </div>

            <!-- ── Sidebar ── -->
            <div class="adm-sidebar">

                <!-- Steps -->
                <div class="adm-side-card">
                    <div class="adm-side-head">
                        <i class="fas fa-list-ol"></i>
                        <h4>Admission Process</h4>
                    </div>
                    <div class="adm-side-body">
                        <?php $steps = getAdmissionSteps(); ?>
                        <?php foreach($steps as $i=>$s): ?>
                        <div class="adm-step">
                            <div class="adm-step-num"><?php echo $i+1; ?></div>
                            <div>
                                <h5><?php echo htmlspecialchars($s['title']); ?></h5>
                                <p><?php echo htmlspecialchars($s['desc']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Required Documents -->
                <div class="adm-side-card">
                    <div class="adm-side-head">
                        <i class="fas fa-folder-open"></i>
                        <h4>Required Documents</h4>
                    </div>
                    <div class="adm-side-body">
                        <?php $docs = getAdmissionDocuments(); ?>
                        <?php foreach($docs as $d): ?>
                        <div class="adm-doc-item">
                            <i class="fas fa-check-circle"></i>
                            <?php echo htmlspecialchars($d); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Contact -->
                <div class="adm-side-card">
                    <div class="adm-side-head">
                        <i class="fas fa-headset"></i>
                        <h4>Need Help?</h4>
                    </div>
                    <div class="adm-side-body">
                        <div class="adm-contact-row">
                            <div class="adm-contact-ico"><i class="fas fa-phone-alt"></i></div>
                            <div><div style="font-size:11px;color:var(--text-light);">Call Us</div>
                            <a href="tel:<?php echo SITE_CONTACT; ?>"><?php echo SITE_CONTACT; ?></a></div>
                        </div>
                        <div class="adm-contact-row">
                            <div class="adm-contact-ico"><i class="fas fa-envelope"></i></div>
                            <div><div style="font-size:11px;color:var(--text-light);">Email</div>
                            <a href="mailto:<?php echo ADMIN_EMAIL; ?>"><?php echo ADMIN_EMAIL; ?></a></div>
                        </div>
                        <div class="adm-contact-row">
                            <div class="adm-contact-ico"><i class="fas fa-map-marker-alt"></i></div>
                            <div><div style="font-size:11px;color:var(--text-light);">Location</div>
                            <span style="font-weight:600;color:var(--text-dark);"><?php echo SITE_LOCATION; ?></span></div>
                        </div>
                        <div class="adm-contact-row">
                            <div class="adm-contact-ico"><i class="fas fa-clock"></i></div>
                            <div><div style="font-size:11px;color:var(--text-light);">Office Hours</div>
                            <span style="font-weight:600;color:var(--text-dark);">Mon–Sat, 8AM–4PM</span></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ── Fee Structure ── -->
<section class="adm-fee">
    <div class="container">
        <div class="adm-sh">
            <div class="adm-sh-badge"><i class="fas fa-tag" style="font-size:9px;"></i> Fees</div>
            <h2>Fee <span>Structure</span></h2>
            <p>Transparent and affordable — flexible payment options available</p>
        </div>
        <div class="adm-fee-grid">
        <?php
        $fees = getFeeStructure();
        foreach($fees as $i=>$f):
        ?>
        <div class="adm-fee-card" data-adm-delay="<?php echo $i*90; ?>">
            <div class="adm-fee-top" style="background:<?php echo htmlspecialchars($f['color']); ?>;">
                <i class="<?php echo htmlspecialchars($f['icon']); ?>" style="color:rgba(255,255,255,0.85);"></i>
                <h4><?php echo htmlspecialchars($f['title']); ?></h4>
                <small><?php echo htmlspecialchars($f['subtitle']); ?></small>
            </div>
            <div class="adm-fee-amount">
                <div class="price">Rs. <?php echo htmlspecialchars($f['price']); ?></div>
                <div class="per"><?php echo htmlspecialchars($f['price_period']); ?></div>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
        <div class="adm-fee-note">
            <strong>Scholarships Available</strong> for deserving students &nbsp;|&nbsp;
            Flexible installment plans &nbsp;|&nbsp;
            Contact us for sibling discounts
        </div>
    </div>
</section>

<!-- ── CTA ── -->
<section class="adm-cta">
    <div class="container">
        <div style="display:flex;align-items:center;gap:44px;flex-wrap:wrap;position:relative;z-index:1;">
            <div style="flex:1 1 320px;">
                <div style="display:inline-flex;align-items:center;gap:7px;background:rgba(245,130,32,0.12);border:1px solid rgba(245,130,32,0.3);color:var(--accent-color);padding:6px 16px;border-radius:50px;font-size:10.5px;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:14px;">
                    <i class="fas fa-headset" style="font-size:9px;"></i> We're Here to Help
                </div>
                <h2 style="font-size:28px;font-weight:800;color:#fff;margin:0 0 10px;line-height:1.22;">
                    Questions About<br>
                    <span style="background:linear-gradient(90deg,var(--accent-color),#FFC107);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Admission Process?</span>
                </h2>
                <p style="color:rgba(255,255,255,0.68);font-size:14px;margin:0;line-height:1.7;">
                    Our admission team is ready to assist you — call, email, or visit our campus.
                </p>
            </div>
            <div style="display:flex;gap:12px;flex-wrap:wrap;flex-shrink:0;">
                <a href="contact.php"
                   style="display:inline-flex;align-items:center;gap:8px;background:var(--accent-color);color:#fff;padding:12px 26px;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;transition:all 0.3s ease;"
                   onmouseover="this.style.background='#D96C0F';this.style.transform='translateY(-2px)';"
                   onmouseout="this.style.background='var(--accent-color)';this.style.transform='';">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
                <a href="tel:<?php echo SITE_CONTACT; ?>"
                   style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.25);color:#fff;padding:12px 26px;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;transition:all 0.3s ease;"
                   onmouseover="this.style.background='rgba(255,255,255,0.16)';this.style.transform='translateY(-2px)';"
                   onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.transform='';">
                    <i class="fas fa-phone"></i> Call Now
                </a>
            </div>
        </div>
    </div>
</section>

<script>
(function(){
    /* Fee cards entrance */
    var fCards = document.querySelectorAll('.adm-fee-card');
    if(fCards.length){
        var obs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if(!e.isIntersecting) return;
                var d = parseInt(e.target.dataset.admDelay)||0;
                setTimeout(function(){ e.target.classList.add('adm-in'); }, d);
                obs.unobserve(e.target);
            });
        },{threshold:0.1});
        fCards.forEach(function(c){ obs.observe(c); });
    }

    /* File upload label update */
    var inp = document.getElementById('docInput');
    if(inp){
        inp.addEventListener('change', function(){
            var lbl = this.closest('.adm-upload').querySelector('strong');
            if(this.files.length && lbl) lbl.textContent = this.files[0].name;
        });
    }
})();
</script>

<?php include 'includes/footer.php'; ?>
