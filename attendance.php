<?php
session_start();

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['student_id'];
    $status = $_POST['status'];

    foreach ($_SESSION['users'] as &$student) {
        if ($student['studentno'] == $id) {  // ✅ use studentno
            $student['attendance_status'] = $status;
            break;
        }
    }


    header("Location: attendance.php");
    exit();
}

// Categorize students
$students_list = [];
$present_list = [];
$absent_list = [];

foreach ($_SESSION['users'] as $student) {
    if (!isset($student['attendance_status'])) {
        $students_list[] = $student;
    } elseif ($student['attendance_status'] === 'present') {
        $present_list[] = $student;
    } elseif ($student['attendance_status'] === 'absent') {
        $absent_list[] = $student;
    }
}

function renderCard($student, $status = 'students') {
    $btnClass = [
        'students' => 'primary',
        'present' => 'success',
        'absent' => 'danger'
    ][$status];

    echo '<div class="col-md-3">
            <div class="card border border-' . $btnClass . ' mb-3" style="width: 18rem;">
                <img src="https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($student['firstname']) . ' ' . htmlspecialchars($student['lastname']) . '</h5>
                    <p class="card-text">ID: ' . (isset($student['studentno']) ? $student['studentno'] : '-') . '</p>';


    if ($status === 'students') {
        echo '<form method="POST" class="d-flex justify-content-end">
                <input type="hidden" name="student_id" value="' . $student['studentno'] . '">
                <button name="status" value="present" class="btn btn-success btn-sm me-2">Present</button>
                <button name="status" value="absent" class="btn btn-danger btn-sm">Absent</button>
              </form>';
    }

    echo '  </div>
            </div>
        </div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img src="https://tse4.mm.bing.net/th/id/OIP.GbF-dydiai059qwqT8Fe4AHaHa?rs=1&pid=ImgDetMain&o=7&rm=3" width="40" height="40" alt="">
            <a class="navbar-brand" href="students.php">{Group 11}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
                    <li class="nav-item"><a class="nav-link active" href="attendance.php">Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="form.php">Form</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container p-2 shadow" style="margin-top: 20px;">
        <h2 class="text-primary">Students <span class="badge text-bg-primary"><?= count($students_list) ?></span></h2>
        <div class="row">
            <?php foreach ($students_list as $student) renderCard($student, 'students'); ?>
        </div>

        <hr>
        <h2 class="text-success">Present <span class="badge text-bg-success"><?= count($present_list) ?></span></h2>
        <div class="row">
            <?php foreach ($present_list as $student) renderCard($student, 'present'); ?>
        </div>

        <hr>
        <h2 class="text-danger">Absent <span class="badge text-bg-danger"><?= count($absent_list) ?></span></h2>
        <div class="row">
            <?php foreach ($absent_list as $student) renderCard($student, 'absent'); ?>
        </div>
    </div>
</body>
</html>
