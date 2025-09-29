<?php
session_start();

// Initialize session array if not exists
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

// Handle deletion
if (isset($_POST['btnDelete'])) {
    unset($_SESSION['users'][$_POST['btnDelete']]);
    // Re-index array so keys remain sequential
    $_SESSION['users'] = array_values($_SESSION['users']);
    header("Location: students.php");
    exit();
}

// ✅ Count present and absent based on attendance_status
$totalPresent = 0;
$totalAbsent = 0;

foreach ($_SESSION['users'] as $student) {
    if (isset($student['attendance_status'])) {
        if ($student['attendance_status'] === 'present') {
            $totalPresent++;
        } elseif ($student['attendance_status'] === 'absent') {
            $totalAbsent++;
        }
    }
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

  <div class="container shadow p-1" style="margin-top: 0px;">
    <div class="container bg-white p-1" style="margin-top: 5px; ">
      <div class="row">
        <div class="col-md-4">
          <div class="card bg-primary m-3 " style="width: 25rem;">
            <div class="card-body text-white">
              <h5 class="card-title"><?= count($_SESSION['users']) ?></h5>
              <p class="card-text">Total Students</p>
              <a href="form.php" class="btn btn-outline-light">Add Student</a>
            </div>
          </div>
          <!-- ✅ Updated counts -->
          <div class="card bg-success m-3" style="width: 25rem;">
            <div class="card-body text-white">
              <h5 class="card-title"><?= $totalPresent ?></h5>
              <p class="card-text">Total Present</p>
              <a href="attendance.php#present-section" class="btn btn-outline-light">See more...</a>
            </div>
          </div>
          <div class="card bg-danger m-3 " style="width: 25rem;">
            <div class="card-body text-white">
              <h5 class="card-title"><?= $totalAbsent ?></h5>
              <p class="card-text">Total Absent</p>
              <a href="attendance.php#absent-section" class="btn btn-outline-light">See more...</a>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
        <div class="table-responsive mt-3">
          <table class="table table-bordered text-nowrap">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Student No.</th>
                  <th scope="col">Name</th>
                  <th scope="col">Status</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Civil Status</th>
                  <th scope="col">Nationality</th>
                  <th scope="col">Date of Birth</th>
                  <th scope="col">Place of Birth</th>
                  <th scope="col">Address</th>
                  <th scope="col">Religion</th>
                  <th scope="col">Contact No.</th>
                  <th scope="col">Email</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($_SESSION['users'])): ?>
                  <tr>
                    <td class="text-center" colspan="14">No Students Available!</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($_SESSION['users'] as $key => $user): ?>
                    <tr>
                      <th scope="row"><?= $key + 1 ?></th>
                      <td><?= htmlspecialchars($user['studentno'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['lastname'] . ', ' . $user['firstname'] . ' ' . $user['middlename']) ?></td>
                      <td>
                        <?php if (($user['attendance_status'] ?? '') === 'present'): ?>
                          <span class="badge bg-success">Present</span>
                        <?php elseif (($user['attendance_status'] ?? '') === 'absent'): ?>
                          <span class="badge bg-danger">Absent</span>
                        <?php else: ?>
                          <span class="badge bg-secondary"></span>
                        <?php endif; ?>
                      </td>
                      <td><?= htmlspecialchars($user['gender'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['civilstatus'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['nationality'] ?? '') ?></td>
                      <td>
                        <?php 
                          if (!empty($user['dateofbirth'])) {
                              echo date("F j, Y", strtotime($user['dateofbirth']));
                          } 
                        ?>
                      </td>
                      <td><?= htmlspecialchars($user['placeofbirth'] ?? '') ?></td>
                      <td><?= htmlspecialchars(($user['street'] ?? '') . ', ' . ($user['barangay'] ?? '') . ', ' . ($user['city'] ?? '') . ', ' . ($user['province'] ?? '')) ?></td>
                      <td><?= htmlspecialchars($user['religion'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['contactno'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                      <td class="text-center">
                        <form method="post" action="students.php">
                          <button type="submit" name="btnDelete" value="<?= $key ?>" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ✅ Carousel and Departments Section -->
      <hr class="my-4">
      <h1 style="text-align: center;">Departments</h1>
      <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"
            aria-label="Slide 4"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4"
            aria-label="Slide 5"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5"
            aria-label="Slide 6"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="6"
            aria-label="Slide 7"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="7"
            aria-label="Slide 8"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="8"
            aria-label="Slide 9"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://dct.edu.ph/wp-content/uploads/2024/11/GS-Logo-150x150.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Elementary Department</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://dct.edu.ph/wp-content/uploads/2024/11/JHS-Logo-300x300.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5 style="color: black;">Junior High School Department</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://dct.edu.ph/wp-content/uploads/2024/11/SHS-Logo-300x300.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Senior High School Department</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://dct.edu.ph/wp-content/uploads/2024/11/CLA-Logo-300x300.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>College of Liberal Arts</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://dct.edu.ph/wp-content/uploads/2024/11/CED-Logo-300x300.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>College of Education</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="http://dct.edu.ph/wp-content/uploads/2024/11/CHM-Logo-300x300.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>College of Hospitality Management</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://dct.edu.ph/wp-content/uploads/2024/11/CCS-Logo-300x300.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>College of Computer Studies</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://dct.edu.ph/wp-content/uploads/2024/11/CBA-Logo-300x300.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>College of Business and Accountancy</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://dct.edu.ph/wp-content/uploads/2024/11/CCJE-Logo-300x300.png" class="d-block mx-auto" width="600px" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>College of Criminal Justice Education</h5>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <div class="container border mt-4">
        <h1 style="text-align: center;">PVMGO</h1>
        <div class="row">
          <div class="col-sm-6">
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title text-center">Vision</h5>
                <p class="card-text text-center">A God-loving educational community with passion for truth and compassion for humanity.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title text-center">Mission</h5>
                <p class="card-text text-center">We commit ourselves to promote the truth and holistically transform persons for the service of humanity.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title text-center">Goals, Core Values, and Objectives</h5>
                <p class="card-text text-center">We aim to provide a system of cultivating learner-centered practices that promotes the 21st century skills and a way of life that centers on faith, wisdom, patriotism.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title text-center">Faith (Fides)</h5>
                <p class="card-text text-center">Practice acquired understanding of Gospel Values in every aspect of life.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title text-center">Patriotism (Patria)</h5>
                <p class="card-text text-center">Inculcate and promote Filipino Christian values.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title text-center">Wisdom (Sapientia)</h5>
                <p class="card-text text-center">Possess knowledge and skills for effective communication to engage oneself in relevant research-based socio-cultural issues.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- container -->
  </div> <!-- shadow -->
</body>
</html>
