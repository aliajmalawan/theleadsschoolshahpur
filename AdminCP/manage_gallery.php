<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Image compression function
function compressImage($source, $destination, $quality = 75) {
    $info = getimagesize($source);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($source);
            break;
        default:
            return false;
    }

    // Save compressed image
    imagejpeg($image, $destination, $quality);
    imagedestroy($image);

    return file_exists($destination);
}

// Compress image to target size (100KB)
function compressToTargetSize($source, $destination, $maxSizeKB = 100) {
    $maxSizeBytes = $maxSizeKB * 1024;

    // If already under size, just copy
    if (filesize($source) <= $maxSizeBytes) {
        copy($source, $destination);
        return true;
    }

    // Start with quality 75 and reduce until file is small enough
    $quality = 75;
    $attempts = 0;
    $maxAttempts = 10;

    while ($attempts < $maxAttempts) {
        compressImage($source, $destination, $quality);

        if (file_exists($destination) && filesize($destination) <= $maxSizeBytes) {
            return true;
        }

        // Reduce quality for next attempt
        $quality -= 10;
        $attempts++;

        if ($quality < 10) {
            $quality = 10;
        }
    }

    // If still too large, use the last compressed version
    return file_exists($destination);
}

// ============ CATEGORIES ============

// Add / edit category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_category'])) {
    $cat_name = trim($_POST['cat_name']);
    $cat_slug = trim($_POST['cat_slug']);
    if ($cat_slug === '') $cat_slug = $cat_name; // auto-generate from name when adding a new category
    $cat_slug = strtolower($cat_slug);
    $cat_slug = preg_replace('/[^a-z0-9\-]/', '-', $cat_slug);
    $cat_slug = trim(preg_replace('/-+/', '-', $cat_slug), '-');
    $cat_icon = trim($_POST['cat_icon']) ?: 'fa-tag';
    $cat_color = trim($_POST['cat_color']) ?: '#0D2B5E';
    $cat_order = intval($_POST['cat_order']);
    $cat_status = $_POST['cat_status'] === 'inactive' ? 'inactive' : 'active';

    $cat_name_e = mysqli_real_escape_string($conn, $cat_name);
    $cat_slug_e = mysqli_real_escape_string($conn, $cat_slug);
    $cat_icon_e = mysqli_real_escape_string($conn, $cat_icon);
    $cat_color_e = mysqli_real_escape_string($conn, $cat_color);

    if ($cat_name === '' || $cat_slug === '') {
        $message = "Category name is required.";
    } else {
        // Ensure slug is unique (append -2, -3... if taken by a different category)
        $editing_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : 0;
        $base_slug = $cat_slug_e;
        $suffix = 2;
        while (true) {
            $check = mysqli_query($conn, "SELECT id FROM gallery_categories WHERE slug = '$cat_slug_e' AND id != $editing_id");
            if (mysqli_num_rows($check) == 0) break;
            $cat_slug_e = $base_slug . '-' . $suffix;
            $suffix++;
        }

        if ($editing_id) {
            $sql = "UPDATE gallery_categories SET name='$cat_name_e', slug='$cat_slug_e', icon='$cat_icon_e', color='$cat_color_e', display_order=$cat_order, status='$cat_status' WHERE id=$editing_id";
            if (mysqli_query($conn, $sql)) {
                $message = "Category updated successfully!";
            } else {
                $message = "Error updating category.";
            }
        } else {
            $sql = "INSERT INTO gallery_categories (name, slug, icon, color, display_order, status) VALUES ('$cat_name_e', '$cat_slug_e', '$cat_icon_e', '$cat_color_e', $cat_order, '$cat_status')";
            if (mysqli_query($conn, $sql)) {
                $message = "Category added successfully!";
            } else {
                $message = "Error adding category.";
            }
        }
    }
}

// Delete category (only if no gallery images still use it)
if (isset($_GET['cat_action']) && $_GET['cat_action'] == 'delete' && isset($_GET['cat_id'])) {
    $cat_id = intval($_GET['cat_id']);
    $cat_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT slug, name FROM gallery_categories WHERE id = $cat_id"));
    if ($cat_row) {
        $slug_e = mysqli_real_escape_string($conn, $cat_row['slug']);
        $in_use = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM gallery WHERE category = '$slug_e'"));
        if ($in_use['c'] > 0) {
            $message = "Can't delete \"{$cat_row['name']}\" — {$in_use['c']} image(s) still use this category. Reassign or delete those images first.";
        } else {
            mysqli_query($conn, "DELETE FROM gallery_categories WHERE id = $cat_id");
            $message = "Category deleted successfully!";
        }
    }
}

// Fetch category being edited
$edit_category = null;
if (isset($_GET['edit_cat'])) {
    $edit_cat_id = intval($_GET['edit_cat']);
    $edit_category = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM gallery_categories WHERE id = $edit_cat_id"));
}

// Fetch all categories (with image counts)
$categories_result = mysqli_query($conn, "
    SELECT gc.*, (SELECT COUNT(*) FROM gallery g WHERE g.category = gc.slug) AS img_count
    FROM gallery_categories gc
    ORDER BY gc.display_order ASC, gc.id ASC
");
$categories_list = [];
if ($categories_result) {
    while ($row = mysqli_fetch_assoc($categories_result)) $categories_list[] = $row;
}

// ============ GALLERY IMAGES ============

// Handle delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete image file
    $img_query = mysqli_query($conn, "SELECT image_path FROM gallery WHERE id = $id");
    if ($img_row = mysqli_fetch_assoc($img_query)) {
        if (file_exists('../' . $img_row['image_path'])) {
            unlink('../' . $img_row['image_path']);
        }
    }

    if (mysqli_query($conn, "DELETE FROM gallery WHERE id = $id")) {
        $message = "Image deleted successfully!";
    }
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_gallery'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $display_order = intval($_POST['display_order']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $is_edit = isset($_POST['gallery_id']) && !empty($_POST['gallery_id']);

    $upload_dir = '../uploads/gallery/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if ($is_edit) {
        // ── Edit: single image, replace is optional ──
        $id = intval($_POST['gallery_id']);

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (in_array($file_extension, $allowed_extensions)) {
                $new_filename = time() . '_' . uniqid() . '.jpg';
                $target_file = $upload_dir . $new_filename;

                if (compressToTargetSize($_FILES['image']['tmp_name'], $target_file, 100)) {
                    $image_path = 'uploads/gallery/' . $new_filename;

                    $old_img_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_path FROM gallery WHERE id = $id"));
                    if ($old_img_row && file_exists('../' . $old_img_row['image_path'])) {
                        unlink('../' . $old_img_row['image_path']);
                    }

                    $query = "UPDATE gallery SET image_path='$image_path', category='$category', display_order=$display_order, status='$status' WHERE id=$id";
                    $message = mysqli_query($conn, $query) ? "Image updated successfully!" : "Error updating image.";
                } else {
                    $message = "Error compressing and uploading file.";
                }
            } else {
                $message = "Invalid file format. Only JPG, PNG, GIF, WEBP allowed.";
            }
        } else {
            $query = "UPDATE gallery SET category='$category', display_order=$display_order, status='$status' WHERE id=$id";
            $message = mysqli_query($conn, $query) ? "Gallery item updated successfully!" : "Error updating gallery item.";
        }
    } else {
        // ── Add: multiple images at once, no title ──
        if (!empty($_FILES['images']['name'][0])) {
            $total = count($_FILES['images']['name']);
            $saved = 0;
            $failed = 0;

            for ($i = 0; $i < $total; $i++) {
                if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) { $failed++; continue; }

                $file_extension = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_extensions)) { $failed++; continue; }

                $new_filename = time() . '_' . uniqid() . '_' . $i . '.jpg';
                $target_file = $upload_dir . $new_filename;

                if (compressToTargetSize($_FILES['images']['tmp_name'][$i], $target_file, 100)) {
                    $image_path = 'uploads/gallery/' . $new_filename;
                    $query = "INSERT INTO gallery (title, image_path, category, display_order, status) VALUES (NULL, '$image_path', '$category', $display_order, '$status')";
                    if (mysqli_query($conn, $query)) { $saved++; } else { $failed++; }
                } else {
                    $failed++;
                }
            }

            $message = "$saved image(s) uploaded successfully!" . ($failed ? " ($failed failed)" : "");
        } else {
            $message = "Please select at least one image to upload.";
        }
    }
}

// Fetch gallery item for editing
$edit_item = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM gallery WHERE id = $edit_id");
    $edit_item = mysqli_fetch_assoc($result);
}

// Fetch all gallery items
$gallery = mysqli_query($conn, "SELECT * FROM gallery ORDER BY display_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .gallery-item {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .gallery-item-info {
            padding: 15px;
        }
        .gallery-item-actions {
            padding: 10px 15px;
            background: var(--bg-light);
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body style="background: var(--bg-light);">
    <div class="container" style="padding: 30px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 style="color: var(--primary-color);"><i class="fas fa-images"></i> Manage Gallery</h1>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <?php if ($message): ?>
            <div style="background: <?php echo strpos($message, 'Error') !== false || strpos($message, 'Invalid') !== false ? '#f8d7da' : '#d4edda'; ?>; color: <?php echo strpos($message, 'Error') !== false || strpos($message, 'Invalid') !== false ? '#721c24' : '#155724'; ?>; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Manage Categories -->
        <div class="card" style="margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;"><i class="fas fa-tags"></i> <?php echo $edit_category ? 'Edit Category' : 'Manage Categories'; ?></h2>

            <form method="POST" style="margin-bottom: 25px;">
                <?php if ($edit_category): ?>
                    <input type="hidden" name="category_id" value="<?php echo $edit_category['id']; ?>">
                <?php endif; ?>
                <div style="display: grid; grid-template-columns: 2fr 1.4fr 1fr 1fr 1fr; gap: 15px; align-items: end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Category Name *</label>
                        <input type="text" name="cat_name" required value="<?php echo $edit_category ? htmlspecialchars($edit_category['name']) : ''; ?>" placeholder="e.g., Sports Day">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Icon (Font Awesome)</label>
                        <input type="text" name="cat_icon" value="<?php echo $edit_category ? htmlspecialchars($edit_category['icon']) : 'fa-tag'; ?>" placeholder="fa-star">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Color</label>
                        <input type="color" name="cat_color" value="<?php echo $edit_category ? htmlspecialchars($edit_category['color']) : '#0D2B5E'; ?>" style="height: 42px; padding: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Order</label>
                        <input type="number" name="cat_order" value="<?php echo $edit_category ? $edit_category['display_order'] : count($categories_list); ?>">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Status</label>
                        <select name="cat_status">
                            <option value="active" <?php echo (!$edit_category || $edit_category['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($edit_category && $edit_category['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <?php if ($edit_category): ?>
                <div class="form-group">
                    <label>URL Slug</label>
                    <input type="text" name="cat_slug" value="<?php echo htmlspecialchars($edit_category['slug']); ?>">
                    <small style="color: var(--text-light); font-size: 12px;">Used in the gallery filter link (gallery.php?category=...). Change carefully — old links using the previous slug will stop matching.</small>
                </div>
                <?php else: ?>
                    <input type="hidden" name="cat_slug" value="">
                    <small style="color: var(--text-light); font-size: 12px; display:block; margin-top: 8px;">A URL-friendly slug will be generated automatically from the name.</small>
                <?php endif; ?>
                <div style="margin-top: 15px;">
                    <button type="submit" name="save_category" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $edit_category ? 'Update Category' : 'Add Category'; ?>
                    </button>
                    <?php if ($edit_category): ?>
                        <a href="manage_gallery.php" class="btn btn-primary" style="background: var(--text-light); margin-left: 10px;">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if (!empty($categories_list)): ?>
            <div style="overflow-x: auto;">
                <table class="data-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--bg-light); text-align: left;">
                            <th style="padding: 10px;">Category</th>
                            <th style="padding: 10px;">Slug</th>
                            <th style="padding: 10px;">Photos</th>
                            <th style="padding: 10px;">Order</th>
                            <th style="padding: 10px;">Status</th>
                            <th style="padding: 10px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories_list as $gc): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 10px;">
                                <span style="display:inline-flex;align-items:center;gap:8px;">
                                    <span style="width:26px;height:26px;border-radius:50%;background:<?php echo htmlspecialchars($gc['color']); ?>;color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;">
                                        <i class="fas <?php echo htmlspecialchars($gc['icon']); ?>"></i>
                                    </span>
                                    <?php echo htmlspecialchars($gc['name']); ?>
                                </span>
                            </td>
                            <td style="padding: 10px; color: var(--text-light);"><?php echo htmlspecialchars($gc['slug']); ?></td>
                            <td style="padding: 10px;"><?php echo $gc['img_count']; ?></td>
                            <td style="padding: 10px;"><?php echo $gc['display_order']; ?></td>
                            <td style="padding: 10px;">
                                <span style="background: <?php echo $gc['status'] == 'active' ? '#28a745' : '#dc3545'; ?>; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px;"><?php echo ucfirst($gc['status']); ?></span>
                            </td>
                            <td style="padding: 10px; white-space: nowrap;">
                                <a href="?edit_cat=<?php echo $gc['id']; ?>" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;"><i class="fas fa-edit"></i></a>
                                <a href="?cat_action=delete&cat_id=<?php echo $gc['id']; ?>" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; background: #dc3545;" onclick="return confirm('Delete category &quot;<?php echo htmlspecialchars($gc['name']); ?>&quot;?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Add/Edit Form -->
        <div class="card" style="margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;"><?php echo $edit_item ? 'Edit Gallery Item' : 'Add New Images'; ?></h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="save_gallery" value="1">
                <?php if ($edit_item): ?>
                    <input type="hidden" name="gallery_id" value="<?php echo $edit_item['id']; ?>">
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Category *</label>
                        <select name="category" required>
                            <?php if (empty($categories_list)): ?>
                                <option value="" disabled selected>Add a category below first</option>
                            <?php endif; ?>
                            <?php foreach ($categories_list as $gc): ?>
                                <option value="<?php echo htmlspecialchars($gc['slug']); ?>" <?php echo ($edit_item && $edit_item['category'] == $gc['slug']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($gc['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="display_order" value="<?php echo $edit_item ? $edit_item['display_order'] : '0'; ?>" placeholder="0">
                        <small style="color: var(--text-light); font-size: 12px;">Lower numbers appear first</small>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?php echo ($edit_item && $edit_item['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($edit_item && $edit_item['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <?php if ($edit_item): ?>
                <div class="form-group">
                    <label>Replace Image (optional - leave empty to keep current)</label>
                    <input type="file" name="image" accept="image/*">
                    <?php if (!empty($edit_item['image_path'])): ?>
                        <div style="margin-top: 15px;">
                            <img src="../<?php echo htmlspecialchars($edit_item['image_path']); ?>" alt="Current Image" style="max-width: 300px; border-radius: 8px; box-shadow: var(--shadow);">
                            <p style="margin-top: 5px; font-size: 13px; color: var(--text-light);">Current image</p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="form-group">
                    <label>Upload Images *</label>
                    <input type="file" name="images[]" accept="image/*" multiple required>
                    <small style="color: var(--text-light); font-size: 12px;">You can select multiple images at once — they'll all be added to the category above.</small>
                </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $edit_item ? 'Update Image' : 'Add Images'; ?>
                </button>
                <?php if ($edit_item): ?>
                    <a href="manage_gallery.php" class="btn btn-primary" style="background: var(--text-light); margin-left: 10px;">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Gallery Grid -->
        <div class="card">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">All Gallery Images</h2>

            <?php
            $cat_name_lookup = [];
            foreach ($categories_list as $gc) $cat_name_lookup[$gc['slug']] = $gc['name'];
            ?>
            <?php if ($gallery && mysqli_num_rows($gallery) > 0): ?>
                <div class="gallery-grid">
                    <?php
                    while ($item = mysqli_fetch_assoc($gallery)) {
                        $cat_display = $cat_name_lookup[$item['category']] ?? ucfirst($item['category']);
                        echo '<div class="gallery-item">';
                        echo '<img src="../' . htmlspecialchars($item['image_path']) . '" alt="' . htmlspecialchars($cat_display) . '">';
                        echo '<div class="gallery-item-info">';
                        echo '<p style="margin: 0; font-size: 13px; color: var(--text-light);"><i class="fas fa-tag"></i> ' . htmlspecialchars($cat_display) . '</p>';
                        echo '<p style="margin: 5px 0 0 0; font-size: 13px; color: var(--text-light);"><i class="fas fa-sort"></i> Order: ' . $item['display_order'] . '</p>';
                        echo '<span style="background: ' . ($item['status'] == 'active' ? '#28a745' : '#dc3545') . '; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; display: inline-block; margin-top: 5px;">' . ucfirst($item['status']) . '</span>';
                        echo '</div>';
                        echo '<div class="gallery-item-actions">';
                        echo '<a href="?edit=' . $item['id'] . '" class="btn btn-primary" style="padding: 8px 15px; font-size: 13px; flex: 1; text-align: center;"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<a href="?action=delete&id=' . $item['id'] . '" class="btn btn-primary" style="padding: 8px 15px; font-size: 13px; background: #dc3545; flex: 1; text-align: center;" onclick="return confirm(\'Delete this image?\')"><i class="fas fa-trash"></i> Delete</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: var(--text-light);">
                    <i class="fas fa-images" style="font-size: 80px; margin-bottom: 20px; opacity: 0.3;"></i>
                    <h3 style="margin-bottom: 10px;">No Images Yet</h3>
                    <p>Upload your first image to get started!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
