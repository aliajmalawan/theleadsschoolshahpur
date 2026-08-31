<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$valid_tabs = ['applications', 'page_content', 'downloads', 'notifications'];
$active_tab = isset($_GET['tab']) && in_array($_GET['tab'], $valid_tabs) ? $_GET['tab'] : 'applications';
$message = isset($_GET['msg']) ? $_GET['msg'] : '';
$is_error = isset($_GET['err']) && $_GET['err'] == '1';

function redirectBackAdmission($tab, $msg, $err = false) {
    header('Location: manage_admission.php?tab=' . urlencode($tab) . '&msg=' . urlencode($msg) . ($err ? '&err=1' : ''));
    exit;
}

function saveAdmSetting($conn, $key, $value) {
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
   APPLICATIONS (approve / reject)
   ========================================================= */
if (isset($_GET['app_action']) && isset($_GET['app_id'])) {
    $id = intval($_GET['app_id']);
    $action = $_GET['app_action'];
    if ($action === 'approve') {
        mysqli_query($conn, "UPDATE admissions SET status = 'approved' WHERE id = $id");
    } elseif ($action === 'reject') {
        mysqli_query($conn, "UPDATE admissions SET status = 'rejected' WHERE id = $id");
    }
    redirectBackAdmission('applications', 'Application status updated!');
}

/* =========================================================
   PAGE CONTENT (steps, documents, fee cards)
   ========================================================= */
if (isset($_POST['save_steps'])) {
    for ($i = 1; $i <= 4; $i++) {
        saveAdmSetting($conn, "adm_step{$i}_title", $_POST["adm_step{$i}_title"] ?? '');
        saveAdmSetting($conn, "adm_step{$i}_desc", $_POST["adm_step{$i}_desc"] ?? '');
    }
    redirectBackAdmission('page_content', 'Admission process steps saved successfully!');
}

if (isset($_POST['save_documents'])) {
    saveAdmSetting($conn, 'adm_documents_list', $_POST['adm_documents_list'] ?? '');
    redirectBackAdmission('page_content', 'Required documents list saved successfully!');
}

if (isset($_POST['save_fee'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $price_period = mysqli_real_escape_string($conn, $_POST['price_period']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $display_order = intval($_POST['display_order']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (!empty($_POST['fee_id'])) {
        $id = intval($_POST['fee_id']);
        $query = "UPDATE fee_structure SET title='$title', subtitle='$subtitle', price='$price', price_period='$price_period', icon='$icon', color='$color', display_order=$display_order, status='$status' WHERE id=$id";
    } else {
        $query = "INSERT INTO fee_structure (title, subtitle, price, price_period, icon, color, display_order, status) VALUES ('$title', '$subtitle', '$price', '$price_period', '$icon', '$color', $display_order, '$status')";
    }
    if (mysqli_query($conn, $query)) {
        redirectBackAdmission('page_content', 'Fee card saved successfully!');
    }
    redirectBackAdmission('page_content', 'Error saving fee card.', true);
}

if (isset($_GET['delete_fee_id'])) {
    $id = intval($_GET['delete_fee_id']);
    mysqli_query($conn, "DELETE FROM fee_structure WHERE id = $id");
    redirectBackAdmission('page_content', 'Fee card deleted successfully!');
}

/* =========================================================
   DOWNLOADS
   ========================================================= */
if (isset($_POST['add_download'])) {
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $display_order = intval($_POST['display_order']);

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip'];

        if (in_array($file_ext, $allowed)) {
            $upload_dir = '../uploads/downloads/';
            if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
            $new_file_name = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file_name);
            if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . $new_file_name)) {
                $db_path = 'uploads/downloads/' . $new_file_name;
                $sql = "INSERT INTO downloads (date, description, file_path, file_name, file_type, display_order) VALUES ('$date', '$description', '$db_path', '$file_name', '$file_type', $display_order)";
                if (mysqli_query($conn, $sql)) {
                    redirectBackAdmission('downloads', 'Download added successfully!');
                }
                redirectBackAdmission('downloads', 'Database error: ' . mysqli_error($conn), true);
            }
            redirectBackAdmission('downloads', 'Failed to upload file.', true);
        }
        redirectBackAdmission('downloads', 'Invalid file type. Allowed: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP', true);
    }
    redirectBackAdmission('downloads', 'Please select a file.', true);
}

if (isset($_GET['delete_download_id'])) {
    $id = intval($_GET['delete_download_id']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT file_path FROM downloads WHERE id = $id"));
    if ($row) {
        $file_path = $row['file_path'];
        if (strpos($file_path, '../') !== 0) $file_path = '../' . $file_path;
        if (file_exists($file_path)) unlink($file_path);
    }
    mysqli_query($conn, "DELETE FROM downloads WHERE id = $id");
    redirectBackAdmission('downloads', 'Download deleted successfully!');
}

if (isset($_GET['toggle_download_id'])) {
    $id = intval($_GET['toggle_download_id']);
    mysqli_query($conn, "UPDATE downloads SET status = IF(status='active','inactive','active') WHERE id = $id");
    redirectBackAdmission('downloads', 'Status updated!');
}

/* =========================================================
   DATA FOR ACTIVE TAB
   ========================================================= */
$applications_result = mysqli_query($conn, "SELECT a.*, c.name as course_name FROM admissions a LEFT JOIN courses c ON a.course_id = c.id ORDER BY a.created_at DESC");

$adm_steps = getAdmissionSteps();
$adm_documents_raw = getSetting('adm_documents_list', implode("\n", getAdmissionDocuments()));

$edit_fee = null;
if (isset($_GET['edit_fee'])) {
    $edit_fee = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM fee_structure WHERE id = " . intval($_GET['edit_fee'])));
}
$fee_result = mysqli_query($conn, "SELECT * FROM fee_structure ORDER BY display_order ASC, id ASC");

$downloads_result = mysqli_query($conn, "SELECT * FROM downloads ORDER BY display_order ASC, date DESC");

$notifications_preview = mysqli_query($conn, "SELECT * FROM notifications ORDER BY display_order ASC, created_at DESC LIMIT 10");

$tab_labels = [
    'applications' => ['icon' => 'fas fa-user-graduate', 'label' => 'Applications'],
    'page_content' => ['icon' => 'fas fa-file-alt', 'label' => 'Page Content'],
    'downloads' => ['icon' => 'fas fa-download', 'label' => 'Downloads'],
    'notifications' => ['icon' => 'fas fa-bullhorn', 'label' => 'Notifications'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admission Section - Admin Panel</title>
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
        .status-active, .status-approved { background: #28a745; }
        .status-inactive, .status-rejected { background: #dc3545; }
        .status-pending { background: #ffc107; color: #1a2b2c; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: var(--primary-color); color: #fff; padding: 14px; text-align: left; }
        .data-table td { padding: 14px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .data-table tr:hover { background: #f8f9fa; }
        .action-btn { padding: 6px 12px; margin: 0 3px; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; text-decoration: none; display: inline-block; }
        .btn-edit { background: var(--primary-color); color: #fff; }
        .btn-delete { background: #dc3545; color: #fff; }
        .btn-toggle { background: #28a745; color: #fff; }
        .btn-approve { background: #28a745; color: #fff; }
        .btn-reject { background: #dc3545; color: #fff; }

        .info-box { background: #e7f3ff; border-left: 4px solid var(--primary-color); padding: 18px 20px; border-radius: 8px; }
        .info-box strong { color: var(--primary-color); }
    </style>
</head>
<body>
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h1 style="color: var(--primary-color);"><i class="fas fa-user-graduate"></i> Manage Admission Section</h1>
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

        <?php if ($active_tab === 'applications'): ?>
        <!-- ============ APPLICATIONS TAB ============ -->
        <div class="card" style="overflow-x:auto;">
            <table class="data-table">
                <thead><tr><th>ID</th><th>Student</th><th>Father</th><th>Phone</th><th>Course</th><th>Medium</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                <?php if ($applications_result && mysqli_num_rows($applications_result) > 0): ?>
                    <?php while ($app = mysqli_fetch_assoc($applications_result)): ?>
                        <tr>
                            <td>#<?php echo $app['id']; ?></td>
                            <td><?php echo htmlspecialchars($app['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($app['father_name']); ?></td>
                            <td><?php echo htmlspecialchars($app['phone']); ?></td>
                            <td><?php echo htmlspecialchars($app['course_name'] ?? $app['course_id']); ?></td>
                            <td><?php echo htmlspecialchars($app['medium'] ?? '-'); ?></td>
                            <td><?php echo date('M d, Y', strtotime($app['created_at'])); ?></td>
                            <td><span class="status-badge status-<?php echo $app['status']; ?>"><?php echo ucfirst($app['status']); ?></span></td>
                            <td>
                                <?php if ($app['status'] === 'pending'): ?>
                                    <a href="?tab=applications&app_action=approve&app_id=<?php echo $app['id']; ?>" class="action-btn btn-approve" onclick="return confirm('Approve this admission?')">Approve</a>
                                    <a href="?tab=applications&app_action=reject&app_id=<?php echo $app['id']; ?>" class="action-btn btn-reject" onclick="return confirm('Reject this admission?')">Reject</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" style="text-align:center;padding:30px;color:var(--text-light);">No admission applications yet</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($active_tab === 'page_content'): ?>
        <!-- ============ PAGE CONTENT TAB ============ -->
        <form method="POST">
            <div class="card" style="margin-bottom: 25px;">
                <h2 style="color: var(--primary-color); margin-bottom: 20px;"><i class="fas fa-list-ol"></i> Admission Process Steps</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div>
                        <div class="form-group">
                            <label>Step <?php echo $i; ?> Title</label>
                            <input type="text" name="adm_step<?php echo $i; ?>_title" value="<?php echo htmlspecialchars($adm_steps[$i-1]['title']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Step <?php echo $i; ?> Description</label>
                            <input type="text" name="adm_step<?php echo $i; ?>_desc" value="<?php echo htmlspecialchars($adm_steps[$i-1]['desc']); ?>">
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                <button type="submit" name="save_steps" class="btn btn-primary"><i class="fas fa-save"></i> Save Steps</button>
            </div>
        </form>

        <form method="POST">
            <div class="card" style="margin-bottom: 25px;">
                <h2 style="color: var(--primary-color); margin-bottom: 20px;"><i class="fas fa-folder-open"></i> Required Documents Checklist</h2>
                <div class="form-group">
                    <label>One document per line</label>
                    <textarea name="adm_documents_list" rows="7"><?php echo htmlspecialchars($adm_documents_raw); ?></textarea>
                </div>
                <button type="submit" name="save_documents" class="btn btn-primary"><i class="fas fa-save"></i> Save Documents List</button>
            </div>
        </form>

        <div class="card" style="margin-bottom: 25px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;"><?php echo $edit_fee ? 'Edit Fee Card' : 'Add New Fee Card'; ?></h2>
            <form method="POST">
                <?php if ($edit_fee): ?><input type="hidden" name="fee_id" value="<?php echo $edit_fee['id']; ?>"><?php endif; ?>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" required value="<?php echo $edit_fee ? htmlspecialchars($edit_fee['title']) : ''; ?>" placeholder="e.g., Matric Programs">
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" value="<?php echo $edit_fee ? htmlspecialchars($edit_fee['subtitle']) : ''; ?>" placeholder="e.g., 9th & 10th Grade">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Price *</label>
                        <input type="text" name="price" required value="<?php echo $edit_fee ? htmlspecialchars($edit_fee['price']) : ''; ?>" placeholder="e.g., 5,000">
                    </div>
                    <div class="form-group">
                        <label>Price Period</label>
                        <input type="text" name="price_period" value="<?php echo $edit_fee ? htmlspecialchars($edit_fee['price_period']) : 'per month'; ?>" placeholder="e.g., per month">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Icon (Font Awesome)</label>
                        <input type="text" name="icon" value="<?php echo $edit_fee ? htmlspecialchars($edit_fee['icon']) : 'fas fa-tag'; ?>">
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <input type="color" name="color" value="<?php echo $edit_fee ? htmlspecialchars($edit_fee['color']) : '#0D2B5E'; ?>" style="height:42px;">
                    </div>
                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="display_order" value="<?php echo $edit_fee ? $edit_fee['display_order'] : 0; ?>" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="active" <?php echo ($edit_fee && $edit_fee['status']=='active') ? 'selected':''; ?>>Active</option>
                        <option value="inactive" <?php echo ($edit_fee && $edit_fee['status']=='inactive') ? 'selected':''; ?>>Inactive</option>
                    </select>
                </div>
                <button type="submit" name="save_fee" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo $edit_fee ? 'Update' : 'Add'; ?> Fee Card</button>
                <?php if ($edit_fee): ?><a href="?tab=page_content" class="btn btn-primary" style="background:var(--text-light);margin-left:10px;">Cancel</a><?php endif; ?>
            </form>
        </div>

        <div class="card" style="overflow-x:auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">Fee Structure Cards</h2>
            <table class="data-table">
                <thead><tr><th>Order</th><th>Title</th><th>Subtitle</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                <?php if ($fee_result && mysqli_num_rows($fee_result) > 0): ?>
                    <?php while ($fee = mysqli_fetch_assoc($fee_result)): ?>
                        <tr>
                            <td><?php echo $fee['display_order']; ?></td>
                            <td><strong><?php echo htmlspecialchars($fee['title']); ?></strong></td>
                            <td><?php echo htmlspecialchars($fee['subtitle']); ?></td>
                            <td>Rs. <?php echo htmlspecialchars($fee['price']); ?> (<?php echo htmlspecialchars($fee['price_period']); ?>)</td>
                            <td><span class="status-badge status-<?php echo $fee['status']; ?>"><?php echo ucfirst($fee['status']); ?></span></td>
                            <td>
                                <a href="?tab=page_content&edit_fee=<?php echo $fee['id']; ?>" class="action-btn btn-edit"><i class="fas fa-edit"></i></a>
                                <a href="?tab=page_content&delete_fee_id=<?php echo $fee['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete this fee card?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;padding:30px;color:var(--text-light);">No fee cards yet</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($active_tab === 'downloads'): ?>
        <!-- ============ DOWNLOADS TAB ============ -->
        <div class="card" style="margin-bottom: 25px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">Add New Download</h2>
            <form method="POST" enctype="multipart/form-data">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="display_order" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" required placeholder="e.g., Homework for winter vacations">
                </div>
                <div class="form-group">
                    <label>File (PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP)</label>
                    <input type="file" name="file" required>
                </div>
                <button type="submit" name="add_download" class="btn btn-primary"><i class="fas fa-plus"></i> Add Download</button>
            </form>
        </div>

        <div class="card" style="overflow-x:auto;">
            <table class="data-table">
                <thead><tr><th>Date</th><th>Description</th><th>File</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                <?php if ($downloads_result && mysqli_num_rows($downloads_result) > 0): ?>
                    <?php while ($download = mysqli_fetch_assoc($downloads_result)):
                        $display_path = $download['file_path'];
                        if (strpos($display_path, '../') !== 0) $display_path = '../' . $display_path;
                    ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($download['date'])); ?></td>
                            <td><?php echo htmlspecialchars($download['description']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($display_path); ?>" target="_blank"><?php echo htmlspecialchars($download['file_name']); ?></a></td>
                            <td><?php echo $download['display_order']; ?></td>
                            <td><span class="status-badge status-<?php echo $download['status']; ?>"><?php echo ucfirst($download['status']); ?></span></td>
                            <td>
                                <a href="?tab=downloads&toggle_download_id=<?php echo $download['id']; ?>" class="action-btn btn-toggle" title="Toggle Status"><i class="fas fa-toggle-on"></i></a>
                                <a href="?tab=downloads&delete_download_id=<?php echo $download['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete this download?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;padding:30px;color:var(--text-light);">No downloads yet</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($active_tab === 'notifications'): ?>
        <!-- ============ NOTIFICATIONS TAB (shared with Home Page) ============ -->
        <div class="info-box" style="margin-bottom: 25px;">
            <strong><i class="fas fa-info-circle"></i> Shared Content:</strong>
            Notifications appear on the Home page ticker and on the dedicated Notifications page, so they're managed in one place to avoid duplicate entries.
            <div style="margin-top: 14px;">
                <a href="manage_home.php?tab=notifications" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Manage Notifications</a>
            </div>
        </div>

        <div class="card" style="overflow-x:auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">Recent Notifications (read-only preview)</h2>
            <table class="data-table">
                <thead><tr><th>Title</th><th>Link</th><th>Order</th><th>Status</th><th>Created</th></tr></thead>
                <tbody>
                <?php if ($notifications_preview && mysqli_num_rows($notifications_preview) > 0): ?>
                    <?php while ($notif = mysqli_fetch_assoc($notifications_preview)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($notif['title']); ?></td>
                            <td><?php echo $notif['link'] ? htmlspecialchars($notif['link']) : '-'; ?></td>
                            <td><?php echo $notif['display_order']; ?></td>
                            <td><span class="status-badge status-<?php echo $notif['status']; ?>"><?php echo ucfirst($notif['status']); ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($notif['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-light);">No notifications yet</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>
    </div>
</body>
</html>
