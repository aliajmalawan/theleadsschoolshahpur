<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$valid_tabs = ['messages', 'page_content', 'campuses'];
$active_tab = isset($_GET['tab']) && in_array($_GET['tab'], $valid_tabs) ? $_GET['tab'] : 'messages';
$message = isset($_GET['msg']) ? $_GET['msg'] : '';
$is_error = isset($_GET['err']) && $_GET['err'] == '1';

function redirectBackContact($tab, $msg, $err = false) {
    header('Location: manage_contact.php?tab=' . urlencode($tab) . '&msg=' . urlencode($msg) . ($err ? '&err=1' : ''));
    exit;
}

function saveContactSetting($conn, $key, $value) {
    $key = mysqli_real_escape_string($conn, $key);
    $value = mysqli_real_escape_string($conn, $value);
    $exists = mysqli_query($conn, "SELECT id FROM settings WHERE setting_key = '$key'");
    if ($exists && mysqli_num_rows($exists) > 0) {
        mysqli_query($conn, "UPDATE settings SET setting_value = '$value' WHERE setting_key = '$key'");
    } else {
        mysqli_query($conn, "INSERT INTO settings (setting_key, setting_value) VALUES ('$key', '$value')");
    }
}

/* =========================================================
   MESSAGES
   ========================================================= */
if (isset($_GET['mark_read_id'])) {
    $id = intval($_GET['mark_read_id']);
    mysqli_query($conn, "UPDATE contacts SET status = 'read' WHERE id = $id");
    redirectBackContact('messages', 'Marked as read!');
}

/* =========================================================
   PAGE CONTENT
   ========================================================= */
if (isset($_POST['save_hours'])) {
    saveContactSetting($conn, 'contact_hours_weekday', $_POST['contact_hours_weekday'] ?? '');
    saveContactSetting($conn, 'contact_hours_saturday', $_POST['contact_hours_saturday'] ?? '');
    saveContactSetting($conn, 'contact_hours_sunday', $_POST['contact_hours_sunday'] ?? '');
    redirectBackContact('page_content', 'Office hours saved successfully!');
}

if (isset($_POST['save_subjects'])) {
    saveContactSetting($conn, 'contact_subjects', $_POST['contact_subjects'] ?? '');
    redirectBackContact('page_content', 'Subject options saved successfully!');
}

if (isset($_POST['save_faq'])) {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $display_order = intval($_POST['display_order']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (!empty($_POST['faq_id'])) {
        $id = intval($_POST['faq_id']);
        $query = "UPDATE contact_faqs SET question='$question', answer='$answer', display_order=$display_order, status='$status' WHERE id=$id";
    } else {
        $query = "INSERT INTO contact_faqs (question, answer, display_order, status) VALUES ('$question', '$answer', $display_order, '$status')";
    }
    if (mysqli_query($conn, $query)) {
        redirectBackContact('page_content', 'FAQ saved successfully!');
    }
    redirectBackContact('page_content', 'Error saving FAQ.', true);
}

if (isset($_GET['delete_faq_id'])) {
    $id = intval($_GET['delete_faq_id']);
    mysqli_query($conn, "DELETE FROM contact_faqs WHERE id = $id");
    redirectBackContact('page_content', 'FAQ deleted successfully!');
}

/* =========================================================
   CAMPUSES
   ========================================================= */
if (isset($_POST['save_campus_stats'])) {
    $pairs = [
        'camp_stat_students' => $_POST['camp_stat_students'],
        'camp_stat_years' => $_POST['camp_stat_years'],
        'camp_stat_passrate' => $_POST['camp_stat_passrate'],
    ];
    foreach ($pairs as $key => $value) {
        saveContactSetting($conn, $key, $value);
    }
    redirectBackContact('campuses', 'Stats bar saved successfully!');
}

if (isset($_POST['save_campus'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $students = mysqli_real_escape_string($conn, $_POST['students']);
    $programs = mysqli_real_escape_string($conn, $_POST['programs']);
    $since_year = mysqli_real_escape_string($conn, $_POST['since_year']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    $badge = mysqli_real_escape_string($conn, $_POST['badge']);
    $badge_color = mysqli_real_escape_string($conn, $_POST['badge_color']);
    $color_from = mysqli_real_escape_string($conn, $_POST['color_from']);
    $color_to = mysqli_real_escape_string($conn, $_POST['color_to']);
    $map_query = mysqli_real_escape_string($conn, $_POST['map_query']);
    $facilities = mysqli_real_escape_string($conn, $_POST['facilities']);
    $is_main = isset($_POST['is_main']) ? 1 : 0;
    $display_order = intval($_POST['display_order']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if ($is_main) {
        mysqli_query($conn, "UPDATE campuses SET is_main = 0");
    }

    if (!empty($_POST['campus_id'])) {
        $id = intval($_POST['campus_id']);
        $query = "UPDATE campuses SET name='$name', area='$area', phone='$phone', email='$email', students='$students', programs='$programs', since_year='$since_year', icon='$icon', badge='$badge', badge_color='$badge_color', color_from='$color_from', color_to='$color_to', map_query='$map_query', facilities='$facilities', is_main=$is_main, display_order=$display_order, status='$status' WHERE id=$id";
    } else {
        $query = "INSERT INTO campuses (name, area, phone, email, students, programs, since_year, icon, badge, badge_color, color_from, color_to, map_query, facilities, is_main, display_order, status)
                  VALUES ('$name', '$area', '$phone', '$email', '$students', '$programs', '$since_year', '$icon', '$badge', '$badge_color', '$color_from', '$color_to', '$map_query', '$facilities', $is_main, $display_order, '$status')";
    }
    if (mysqli_query($conn, $query)) {
        redirectBackContact('campuses', 'Campus saved successfully!');
    }
    redirectBackContact('campuses', 'Error saving campus: ' . mysqli_error($conn), true);
}

if (isset($_GET['delete_campus_id'])) {
    $id = intval($_GET['delete_campus_id']);
    mysqli_query($conn, "DELETE FROM campuses WHERE id = $id");
    redirectBackContact('campuses', 'Campus deleted successfully!');
}

/* =========================================================
   DATA FOR ACTIVE TAB
   ========================================================= */
$contacts_result = mysqli_query($conn, "SELECT * FROM contacts ORDER BY created_at DESC");

$contact_hours = getContactHours();
$contact_subjects_raw = getSetting('contact_subjects', implode("\n", getContactSubjects()));
$main_campus_preview = getMainCampus();

$edit_faq = null;
if (isset($_GET['edit_faq'])) {
    $edit_faq = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM contact_faqs WHERE id = " . intval($_GET['edit_faq'])));
}
$faqs_result = mysqli_query($conn, "SELECT * FROM contact_faqs ORDER BY display_order ASC, id ASC");

$camp_stats = getCampusStats();
$edit_campus = null;
if (isset($_GET['edit_campus'])) {
    $edit_campus = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM campuses WHERE id = " . intval($_GET['edit_campus'])));
}
$campuses_result = mysqli_query($conn, "SELECT * FROM campuses ORDER BY display_order ASC, id ASC");

$tab_labels = [
    'messages' => ['icon' => 'fas fa-envelope', 'label' => 'Messages'],
    'page_content' => ['icon' => 'fas fa-file-alt', 'label' => 'Page Content'],
    'campuses' => ['icon' => 'fas fa-city', 'label' => 'Campuses'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contact Section - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: var(--bg-light); }
        .tab-nav {
            display: flex; flex-wrap: wrap; gap: 8px;
            margin-bottom: 25px; border-bottom: 2px solid var(--border-color);
        }
        .tab-nav a {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 20px; text-decoration: none;
            color: var(--text-light); font-weight: 600; font-size: 14px;
            border-radius: 10px 10px 0 0; border-bottom: 3px solid transparent;
            transition: all 0.25s ease;
        }
        .tab-nav a:hover { background: rgba(13,43,94,0.06); color: var(--primary-color); }
        .tab-nav a.active { color: var(--primary-color); border-bottom-color: var(--accent-color); background: rgba(13,43,94,0.08); }

        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; color: #fff; }
        .status-active, .status-read { background: #28a745; }
        .status-inactive, .status-unread { background: #dc3545; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: var(--primary-color); color: #fff; padding: 14px; text-align: left; }
        .data-table td { padding: 14px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .data-table tr:hover { background: #f8f9fa; }
        .action-btn { padding: 6px 12px; margin: 0 3px; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; text-decoration: none; display: inline-block; }
        .btn-edit { background: var(--primary-color); color: #fff; }
        .btn-delete { background: #dc3545; color: #fff; }
        .btn-mark { background: var(--primary-color); color: #fff; }

        .info-box { background: #e7f3ff; border-left: 4px solid var(--primary-color); padding: 16px 20px; border-radius: 8px; margin-bottom: 25px; }
        .info-box strong { color: var(--primary-color); }
        .main-pill { background: var(--accent-color); color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    </style>
</head>
<body>
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h1 style="color: var(--primary-color);"><i class="fas fa-envelope"></i> Manage Contact Section</h1>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <?php if ($message): ?>
            <div style="background: <?php echo $is_error ? '#f8d7da' : '#d4edda'; ?>; color: <?php echo $is_error ? '#721c24' : '#155724'; ?>; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <i class="fas <?php echo $is_error ? 'fa-exclamation-circle' : 'fa-check-circle'; ?>"></i> <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="tab-nav">
            <?php foreach ($tab_labels as $key => $t): ?>
                <a href="?tab=<?php echo $key; ?>" class="<?php echo $active_tab === $key ? 'active' : ''; ?>">
                    <i class="<?php echo $t['icon']; ?>"></i> <?php echo $t['label']; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($active_tab === 'messages'): ?>
        <!-- ============ MESSAGES TAB ============ -->
        <div class="card" style="overflow-x:auto;">
            <table class="data-table">
                <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Subject</th><th>Message</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                <?php if ($contacts_result && mysqli_num_rows($contacts_result) > 0): ?>
                    <?php while ($contact = mysqli_fetch_assoc($contacts_result)): ?>
                        <tr>
                            <td>#<?php echo $contact['id']; ?></td>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                            <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                            <td><?php echo htmlspecialchars(substr($contact['message'], 0, 50)); ?>...</td>
                            <td><?php echo date('M d, Y', strtotime($contact['created_at'])); ?></td>
                            <td><span class="status-badge status-<?php echo $contact['status']; ?>"><?php echo ucfirst($contact['status']); ?></span></td>
                            <td>
                                <?php if ($contact['status'] === 'unread'): ?>
                                    <a href="?tab=messages&mark_read_id=<?php echo $contact['id']; ?>" class="action-btn btn-mark">Mark Read</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" style="text-align:center;padding:30px;color:var(--text-light);">No contact messages yet</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($active_tab === 'page_content'): ?>
        <!-- ============ PAGE CONTENT TAB ============ -->
        <div class="info-box">
            <strong><i class="fas fa-info-circle"></i> Shared Content:</strong>
            Address, phone, and email shown on this page come from <strong>Settings &gt; General Information</strong> (same values used site-wide). The map/location comes from the campus marked <strong>"Featured in Location/Map section"</strong> under the <strong>Campuses</strong> tab<?php echo $main_campus_preview ? ' — currently: ' . htmlspecialchars($main_campus_preview['name']) . ', ' . htmlspecialchars($main_campus_preview['area']) : ''; ?>.
            <div style="margin-top: 12px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="settings.php" class="btn btn-primary"><i class="fas fa-cog"></i> Edit General Settings</a>
                <a href="?tab=campuses" class="btn btn-primary"><i class="fas fa-city"></i> Manage Campuses</a>
            </div>
        </div>

        <form method="POST">
            <div class="card" style="margin-bottom: 25px;">
                <h2 style="color: var(--primary-color); margin-bottom: 20px;"><i class="fas fa-clock"></i> Office Hours</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Monday - Friday</label>
                        <input type="text" name="contact_hours_weekday" value="<?php echo htmlspecialchars($contact_hours[0]['time']); ?>" placeholder="e.g., 8:00 AM - 5:00 PM">
                    </div>
                    <div class="form-group">
                        <label>Saturday</label>
                        <input type="text" name="contact_hours_saturday" value="<?php echo htmlspecialchars($contact_hours[1]['time']); ?>" placeholder="e.g., 9:00 AM - 3:00 PM">
                    </div>
                    <div class="form-group">
                        <label>Sunday</label>
                        <input type="text" name="contact_hours_sunday" value="<?php echo htmlspecialchars($contact_hours[2]['time']); ?>" placeholder="e.g., Closed">
                    </div>
                </div>
                <button type="submit" name="save_hours" class="btn btn-primary"><i class="fas fa-save"></i> Save Office Hours</button>
            </div>
        </form>

        <form method="POST">
            <div class="card" style="margin-bottom: 25px;">
                <h2 style="color: var(--primary-color); margin-bottom: 20px;"><i class="fas fa-list"></i> Contact Form Subject Options</h2>
                <div class="form-group">
                    <label>One subject option per line</label>
                    <textarea name="contact_subjects" rows="8"><?php echo htmlspecialchars($contact_subjects_raw); ?></textarea>
                </div>
                <button type="submit" name="save_subjects" class="btn btn-primary"><i class="fas fa-save"></i> Save Subject Options</button>
            </div>
        </form>

        <div class="card" style="margin-bottom: 25px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;"><?php echo $edit_faq ? 'Edit FAQ' : 'Add New FAQ'; ?></h2>
            <form method="POST">
                <?php if ($edit_faq): ?><input type="hidden" name="faq_id" value="<?php echo $edit_faq['id']; ?>"><?php endif; ?>
                <div class="form-group">
                    <label>Question *</label>
                    <input type="text" name="question" required value="<?php echo $edit_faq ? htmlspecialchars($edit_faq['question']) : ''; ?>" placeholder="e.g., What are the admission requirements?">
                </div>
                <div class="form-group">
                    <label>Answer *</label>
                    <textarea name="answer" required rows="4"><?php echo $edit_faq ? htmlspecialchars($edit_faq['answer']) : ''; ?></textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="display_order" value="<?php echo $edit_faq ? $edit_faq['display_order'] : 0; ?>" min="0">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?php echo ($edit_faq && $edit_faq['status']=='active') ? 'selected':''; ?>>Active</option>
                            <option value="inactive" <?php echo ($edit_faq && $edit_faq['status']=='inactive') ? 'selected':''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="save_faq" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo $edit_faq ? 'Update' : 'Add'; ?> FAQ</button>
                <?php if ($edit_faq): ?><a href="?tab=page_content" class="btn btn-primary" style="background:var(--text-light);margin-left:10px;">Cancel</a><?php endif; ?>
            </form>
        </div>

        <div class="card" style="overflow-x:auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">FAQs</h2>
            <table class="data-table">
                <thead><tr><th>Order</th><th>Question</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                <?php if ($faqs_result && mysqli_num_rows($faqs_result) > 0): ?>
                    <?php while ($faq = mysqli_fetch_assoc($faqs_result)): ?>
                        <tr>
                            <td><?php echo $faq['display_order']; ?></td>
                            <td><strong><?php echo htmlspecialchars($faq['question']); ?></strong></td>
                            <td><span class="status-badge status-<?php echo $faq['status']; ?>"><?php echo ucfirst($faq['status']); ?></span></td>
                            <td>
                                <a href="?tab=page_content&edit_faq=<?php echo $faq['id']; ?>" class="action-btn btn-edit"><i class="fas fa-edit"></i></a>
                                <a href="?tab=page_content&delete_faq_id=<?php echo $faq['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete this FAQ?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center;padding:30px;color:var(--text-light);">No FAQs yet</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($active_tab === 'campuses'): ?>
        <!-- ============ CAMPUSES TAB ============ -->
        <div class="card" style="margin-bottom: 25px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">Campuses Stats Bar</h2>
            <p style="color: var(--text-light); font-size: 13px; margin-bottom: 15px;">"Campuses" count is calculated automatically from active campuses below.</p>
            <form method="POST">
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Total Students</label>
                        <input type="text" name="camp_stat_students" value="<?php echo htmlspecialchars($camp_stats[1]['number']); ?>" placeholder="e.g., 2,300+">
                    </div>
                    <div class="form-group">
                        <label>Years of Education</label>
                        <input type="text" name="camp_stat_years" value="<?php echo htmlspecialchars($camp_stats[2]['number']); ?>" placeholder="e.g., 15+">
                    </div>
                    <div class="form-group">
                        <label>Pass Rate</label>
                        <input type="text" name="camp_stat_passrate" value="<?php echo htmlspecialchars($camp_stats[3]['number']); ?>" placeholder="e.g., 98%">
                    </div>
                </div>
                <button type="submit" name="save_campus_stats" class="btn btn-primary"><i class="fas fa-save"></i> Save Stats</button>
            </form>
        </div>

        <div class="card" style="margin-bottom: 25px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;"><?php echo $edit_campus ? 'Edit Campus' : 'Add New Campus'; ?></h2>
            <form method="POST">
                <?php if ($edit_campus): ?><input type="hidden" name="campus_id" value="<?php echo $edit_campus['id']; ?>"><?php endif; ?>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Campus Name *</label>
                        <input type="text" name="name" required value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['name']) : ''; ?>" placeholder="e.g., Main Campus">
                    </div>
                    <div class="form-group">
                        <label>Area / Location *</label>
                        <input type="text" name="area" required value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['area']) : ''; ?>" placeholder="e.g., Green Town, Gujranwala">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['phone']) : ''; ?>" placeholder="e.g., 0300 0642851">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['email']) : ''; ?>" placeholder="e.g., main@theleadschool.pk">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Students</label>
                        <input type="text" name="students" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['students']) : ''; ?>" placeholder="e.g., 800+">
                    </div>
                    <div class="form-group">
                        <label>Programs</label>
                        <input type="text" name="programs" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['programs']) : ''; ?>" placeholder="e.g., 12">
                    </div>
                    <div class="form-group">
                        <label>Established Year</label>
                        <input type="text" name="since_year" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['since_year']) : ''; ?>" placeholder="e.g., 2009">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Badge Text</label>
                        <input type="text" name="badge" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['badge']) : ''; ?>" placeholder="e.g., Headquarters">
                    </div>
                    <div class="form-group">
                        <label>Icon (Font Awesome, without "fa-")</label>
                        <input type="text" name="icon" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['icon']) : 'fa-building-columns'; ?>" placeholder="e.g., fa-school">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Badge Color</label>
                        <input type="color" name="badge_color" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['badge_color']) : '#0D2B5E'; ?>" style="height:42px;">
                    </div>
                    <div class="form-group">
                        <label>Gradient Start Color</label>
                        <input type="color" name="color_from" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['color_from']) : '#081D40'; ?>" style="height:42px;">
                    </div>
                    <div class="form-group">
                        <label>Gradient End Color</label>
                        <input type="color" name="color_to" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['color_to']) : '#0D2B5E'; ?>" style="height:42px;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Google Maps Query</label>
                    <input type="text" name="map_query" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['map_query']) : ''; ?>" placeholder="e.g., Green+Town+Gujranwala+Pakistan">
                    <small style="color: var(--text-light);">Use + instead of spaces</small>
                </div>

                <div class="form-group">
                    <label>Facilities (comma separated)</label>
                    <input type="text" name="facilities" value="<?php echo $edit_campus ? htmlspecialchars($edit_campus['facilities']) : ''; ?>" placeholder="e.g., Computer Lab, Science Labs, Library">
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;align-items:center;">
                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="display_order" value="<?php echo $edit_campus ? $edit_campus['display_order'] : 0; ?>" min="0">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?php echo ($edit_campus && $edit_campus['status']=='active') ? 'selected':''; ?>>Active</option>
                            <option value="inactive" <?php echo ($edit_campus && $edit_campus['status']=='inactive') ? 'selected':''; ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="is_main" value="1" <?php echo ($edit_campus && $edit_campus['is_main']) ? 'checked':''; ?> style="width:auto;"> Featured in Location/Map section</label>
                    </div>
                </div>

                <button type="submit" name="save_campus" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo $edit_campus ? 'Update' : 'Add'; ?> Campus</button>
                <?php if ($edit_campus): ?><a href="?tab=campuses" class="btn btn-primary" style="background:var(--text-light);margin-left:10px;">Cancel</a><?php endif; ?>
            </form>
        </div>

        <div class="card" style="overflow-x:auto;">
            <table class="data-table">
                <thead><tr><th>Order</th><th>Name</th><th>Area</th><th>Students</th><th>Main?</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                <?php if ($campuses_result && mysqli_num_rows($campuses_result) > 0): ?>
                    <?php while ($c = mysqli_fetch_assoc($campuses_result)): ?>
                        <tr>
                            <td><?php echo $c['display_order']; ?></td>
                            <td><strong><?php echo htmlspecialchars($c['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($c['area']); ?></td>
                            <td><?php echo htmlspecialchars($c['students']); ?></td>
                            <td><?php echo $c['is_main'] ? '<span class="main-pill">Main</span>' : '-'; ?></td>
                            <td><span class="status-badge status-<?php echo $c['status']; ?>"><?php echo ucfirst($c['status']); ?></span></td>
                            <td>
                                <a href="?tab=campuses&edit_campus=<?php echo $c['id']; ?>" class="action-btn btn-edit"><i class="fas fa-edit"></i></a>
                                <a href="?tab=campuses&delete_campus_id=<?php echo $c['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete this campus?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--text-light);">No campuses yet</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>
    </div>
</body>
</html>
