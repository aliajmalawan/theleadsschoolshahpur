<?php
require_once 'includes/config.php';
require_once 'includes/settings_helper.php';

// Fetch active downloads
$downloads = mysqli_query($conn, "SELECT * FROM downloads WHERE status = 'active' ORDER BY display_order ASC, date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloads - <?php echo getSiteName(); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Page Header with Background Image -->
    <section class="page-header" style="background-image: linear-gradient(rgba(11, 77, 162, 0.85), rgba(10, 58, 122, 0.85)), url('https://images.unsplash.com/photo-1568667256549-094345857637?q=80&w=1200'); background-size: cover; background-position: center; background-repeat: no-repeat; padding: 50px 0 60px; text-align: center; color: white; position: relative;">
        <div class="container" style="position: relative; z-index: 2;">
            <div style="display: inline-block; background: rgba(255,255,255,0.1); padding: 15px 35px; border-radius: 10px; backdrop-filter: blur(10px);">
                <i class="fas fa-download" style="font-size: 2.5rem; margin-bottom: 12px; opacity: 0.9;"></i>
                <h1 style="font-size: 2.2rem; margin-bottom: 8px; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Downloads</h1>
                <p style="font-size: 1rem; opacity: 0.95;">Important documents and files for students</p>
            </div>
        </div>
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(to bottom, transparent, var(--bg-light));"></div>
    </section>

    <!-- Downloads Section -->
    <section style="padding: 60px 0; background: var(--bg-light);">
        <div class="container">
            <div class="card">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <thead>
                            <tr style="background: linear-gradient(135deg, var(--primary-color), #0a3d7a); color: white;">
                                <th style="padding: 18px 15px; text-align: left; width: 120px; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                                <th style="padding: 18px 15px; text-align: left; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Description</th>
                                <th style="padding: 18px 15px; text-align: left; width: 150px; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">File Type</th>
                                <th style="padding: 18px 15px; text-align: center; width: 180px; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($downloads && mysqli_num_rows($downloads) > 0) {
                                while ($download = mysqli_fetch_assoc($downloads)) {
                                    $file_ext = strtolower(pathinfo($download['file_name'], PATHINFO_EXTENSION));

                                    // Icon based on file type
                                    $icon = 'fa-file';
                                    if ($file_ext == 'pdf') $icon = 'fa-file-pdf';
                                    elseif (in_array($file_ext, ['doc', 'docx'])) $icon = 'fa-file-word';
                                    elseif (in_array($file_ext, ['xls', 'xlsx'])) $icon = 'fa-file-excel';
                                    elseif (in_array($file_ext, ['jpg', 'jpeg', 'png'])) $icon = 'fa-file-image';
                                    elseif ($file_ext == 'zip') $icon = 'fa-file-zipper';

                                    echo '<tr style="border-bottom: 1px solid #e0e0e0; background: white; transition: all 0.3s ease;" onmouseover="this.style.background=\'#f8f9fa\'; this.style.boxShadow=\'0 2px 8px rgba(0,0,0,0.05)\';" onmouseout="this.style.background=\'white\'; this.style.boxShadow=\'none\';">';
                                    echo '<td style="padding: 15px; font-weight: 600; color: var(--text-dark);">' . date('d.m.Y', strtotime($download['date'])) . '</td>';
                                    echo '<td style="padding: 15px; color: var(--text-dark);">' . htmlspecialchars($download['description']) . '</td>';
                                    echo '<td style="padding: 15px;"><i class="fas ' . $icon . '" style="color: var(--primary-color); margin-right: 8px;"></i><span style="font-weight: 500;">' . strtoupper($file_ext) . ' File</span></td>';
                                    echo '<td style="padding: 15px; text-align: center;">';
                                    echo '<a href="' . $download['file_path'] . '" download style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; background: var(--primary-color); color: white; border-radius: 6px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(11, 77, 162, 0.2);" onmouseover="this.style.background=\'#0a3d7a\'; this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 4px 12px rgba(11, 77, 162, 0.3)\';" onmouseout="this.style.background=\'var(--primary-color)\'; this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 2px 8px rgba(11, 77, 162, 0.2)\';"><i class="fas fa-download"></i> Download</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" style="padding: 40px; text-align: center; color: var(--text-light);">';
                                echo '<i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i><br>';
                                echo 'No downloads available at the moment';
                                echo '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
