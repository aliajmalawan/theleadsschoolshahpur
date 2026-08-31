<?php
require_once 'includes/config.php';
require_once 'includes/settings_helper.php';

// Fetch active datesheets
$datesheets = mysqli_query($conn, "SELECT * FROM exam_datesheets WHERE status = 'active' ORDER BY exam_year DESC");

// Fetch active board results
$matric_results = mysqli_query($conn, "SELECT * FROM board_results WHERE status = 'active' AND board_type = 'Matric' ORDER BY year DESC, display_order ASC");
$inter_results = mysqli_query($conn, "SELECT * FROM board_results WHERE status = 'active' AND board_type = 'Intermediate' ORDER BY year DESC, display_order ASC");

$exam_header = getExaminationHeader();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination - <?php echo getSiteName(); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Page Header with Background Image -->
    <section class="page-header" style="background-image: linear-gradient(rgba(11, 77, 162, 0.85), rgba(10, 58, 122, 0.85)), url('<?php echo htmlspecialchars($exam_header['image']); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; padding: 50px 0 60px; text-align: center; color: white; position: relative;">
        <div class="container" style="position: relative; z-index: 2;">
            <div style="display: inline-block; background: rgba(255,255,255,0.1); padding: 15px 35px; border-radius: 10px; backdrop-filter: blur(10px);">
                <i class="fas fa-file-alt" style="font-size: 2.5rem; margin-bottom: 12px; opacity: 0.9;"></i>
                <h1 style="font-size: 2.2rem; margin-bottom: 8px; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);"><?php echo htmlspecialchars($exam_header['title']); ?></h1>
                <p style="font-size: 1rem; opacity: 0.95;"><?php echo htmlspecialchars($exam_header['subtitle']); ?></p>
            </div>
        </div>
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(to bottom, transparent, var(--bg-light));"></div>
    </section>

    <!-- Datesheets Section -->
    <section style="padding: 60px 0;">
        <div class="container">
            <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 40px;"><i class="fas fa-calendar-alt"></i> Exam Datesheets</h2>

            <?php
            if ($datesheets && mysqli_num_rows($datesheets) > 0) {
                while ($datesheet = mysqli_fetch_assoc($datesheets)) {
                    echo '<div class="card" style="margin-bottom: 40px;">';
                    echo '<h3 style="color: var(--primary-color); margin-bottom: 20px; text-align: center;">' . htmlspecialchars($datesheet['exam_name']) . '</h3>';

                    // Fetch details
                    $details = mysqli_query($conn, "SELECT * FROM datesheet_details WHERE datesheet_id = {$datesheet['id']} ORDER BY exam_date ASC, class ASC");

                    if ($details && mysqli_num_rows($details) > 0) {
                        // Group by date
                        $dates = [];
                        while ($detail = mysqli_fetch_assoc($details)) {
                            $dates[$detail['exam_date']][] = $detail;
                        }

                        echo '<div style="overflow-x: auto;">';
                        echo '<table style="width: 100%; border-collapse: collapse;">';
                        echo '<thead><tr style="background: var(--primary-color); color: white;">';

                        // Get unique dates
                        $date_keys = array_keys($dates);
                        echo '<th style="padding: 15px; text-align: left; vertical-align: top;">Class</th>';
                        foreach ($date_keys as $date) {
                            $day = $dates[$date][0]['day_name'];
                            echo '<th style="padding: 15px; text-align: center;">' . date('d.m.Y', strtotime($date)) . '<br><small>' . $day . '</small></th>';
                        }

                        echo '</tr></thead><tbody>';

                        // Get unique classes
                        $classes = [];
                        foreach ($dates as $date => $entries) {
                            foreach ($entries as $entry) {
                                $classes[$entry['class']][$date] = $entry['subject'];
                            }
                        }

                        foreach ($classes as $class => $subjects_by_date) {
                            echo '<tr style="border-bottom: 1px solid #e0e0e0;">';
                            echo '<td style="padding: 15px; font-weight: bold; background: #f8f9fa;">' . htmlspecialchars($class) . '</td>';
                            foreach ($date_keys as $date) {
                                echo '<td style="padding: 15px; text-align: center;">';
                                echo isset($subjects_by_date[$date]) ? htmlspecialchars($subjects_by_date[$date]) : '-';
                                echo '</td>';
                            }
                            echo '</tr>';
                        }

                        echo '</tbody></table></div>';
                    } else {
                        echo '<p style="text-align: center; color: var(--text-light);">Schedule not available yet</p>';
                    }

                    echo '</div>';
                }
            } else {
                echo '<div class="card"><p style="text-align: center; color: var(--text-light); padding: 40px;">No datesheets available at the moment</p></div>';
            }
            ?>
        </div>
    </section>

    <!-- Board Results Section -->
    <section style="padding: 60px 0; background: var(--bg-light);">
        <div class="container">
            <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 40px;"><i class="fas fa-trophy"></i> Board Results</h2>

            <!-- Intermediate Results -->
            <div style="margin-bottom: 50px;">
                <h3 style="color: var(--primary-color); margin-bottom: 25px; border-left: 5px solid var(--primary-color); padding-left: 15px;">Intermediate Results</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
                    <?php
                    if ($inter_results && mysqli_num_rows($inter_results) > 0) {
                        while ($result = mysqli_fetch_assoc($inter_results)) {
                            echo '<div class="card">';
                            echo '<img src="' . $result['image_path'] . '" style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px; margin-bottom: 15px; cursor: pointer;" onclick="window.open(\'' . $result['image_path'] . '\', \'_blank\')">';
                            echo '<h4 style="color: var(--primary-color); margin-bottom: 10px;">' . htmlspecialchars($result['title']) . '</h4>';
                            echo '<p style="color: var(--text-light);">Year: ' . $result['year'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p style="color: var(--text-light);">No Intermediate results available yet</p>';
                    }
                    ?>
                </div>
            </div>

            <!-- Matric Results -->
            <div>
                <h3 style="color: var(--primary-color); margin-bottom: 25px; border-left: 5px solid var(--primary-color); padding-left: 15px;">Matric Results</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
                    <?php
                    if ($matric_results && mysqli_num_rows($matric_results) > 0) {
                        while ($result = mysqli_fetch_assoc($matric_results)) {
                            echo '<div class="card">';
                            echo '<img src="' . $result['image_path'] . '" style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px; margin-bottom: 15px; cursor: pointer;" onclick="window.open(\'' . $result['image_path'] . '\', \'_blank\')">';
                            echo '<h4 style="color: var(--primary-color); margin-bottom: 10px;">' . htmlspecialchars($result['title']) . '</h4>';
                            echo '<p style="color: var(--text-light);">Year: ' . $result['year'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p style="color: var(--text-light);">No Matric results available yet</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
