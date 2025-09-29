<?php
session_start();

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['student_id'];
    $status = $_POST['status'];

    foreach ($_SESSION['users'] as &$student) {
        if ($student['studentno'] == $id) {
            $student['attendance_status'] = $status;
            break;
        }
    }
    unset($student);

    header("Location: attendance.php");
    exit();
}

$students_list = [];
$present_list = [];
$absent_list = [];

foreach ($_SESSION['users'] as $student) {
    if (!isset($student['attendance_status']) || $student['attendance_status'] === 'students') {
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
                    <p class="card-text"> ' . (isset($student['studentno']) ? $student['studentno'] : '-') . '</p>';

    echo '<div class="dropdown d-flex justify-content-end mt-2">
        <button class="btn btn-' . $btnClass . ' dropdown-toggle" type="button" data-bs-toggle="dropdown">Action</button>
        <ul class="dropdown-menu dropdown-menu-end">';

    if ($status === 'students') {
        echo '<li>
                <form method="POST">
                    <input type="hidden" name="student_id" value="' . $student['studentno'] . '">
                    <button name="status" value="present" class="dropdown-item">Present</button>
                </form>
              </li>
              <li>
                <form method="POST">
                    <input type="hidden" name="student_id" value="' . $student['studentno'] . '">
                    <button name="status" value="absent" class="dropdown-item">Absent</button>
                </form>
              </li>';
    } elseif ($status === 'present') {
        echo '<li>
                <form method="POST">
                    <input type="hidden" name="student_id" value="' . $student['studentno'] . '">
                    <button name="status" value="absent" class="dropdown-item">Absent</button>
                </form>
              </li>
              <li>
                <form method="POST">
                    <input type="hidden" name="student_id" value="' . $student['studentno'] . '">
                    <button name="status" value="students" class="dropdown-item text-dark">Remove</button>
                </form>
              </li>';
    } elseif ($status === 'absent') {
        echo '<li>
                <form method="POST">
                    <input type="hidden" name="student_id" value="' . $student['studentno'] . '">
                    <button name="status" value="present" class="dropdown-item">Present</button>
                </form>
              </li>
              <li>
                <form method="POST">
                    <input type="hidden" name="student_id" value="' . $student['studentno'] . '">
                    <button name="status" value="students" class="dropdown-item text-dark">Remove</button>
                </form>
              </li>';
    }

    echo '  </ul>
            </div>'; 

    echo '  </div>
            </div>
        </div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img src="https://tse4.mm.bing.net/th/id/OIP.GbF-dydiai059qwqT8Fe4AHaHa?rs=1&pid=ImgDetMain&o=7&rm=3"
                width="40" height="40" alt="">
            <a class="navbar-brand" href="students.php">Group 5</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="students.php">Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="attendance.php">Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="true" href="form.php">Form</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container p-3 shadow" style="margin-top: 40;">
        <h2 class="text-primary">Students <span class="badge text-bg-primary"><?= count($students_list) ?></span></h2>
        <div class="row">
            <?php foreach ($students_list as $student) renderCard($student, 'students'); ?>
        </div>

        <hr>
        <h2 id="present-section" class="text-success">Present <span class="badge text-bg-success"><?= count($present_list) ?></span></h2>
        <div class="row">
            <?php foreach ($present_list as $student) renderCard($student, 'present'); ?>
        </div>

        <hr>
        <h2 id="absent-section" class="text-danger">Absent <span class="badge text-bg-danger"><?= count($absent_list) ?></span></h2>
        <div class="row">
            <?php foreach ($absent_list as $student) renderCard($student, 'absent'); ?>
        </div>
    </div>
</body>
</html>
