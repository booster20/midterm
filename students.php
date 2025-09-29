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
            <a class="navbar-brand" href="students.php">{Group 11}</a>

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

  <div class="container shadow p-1" style="margin-top: 20px;">
    <div class="container bg-white p-1" style="margin-top: 20px; ">
      <div class="row">
        <div class="col-md-4">
          <div class="card bg-primary m-3 " style="width: 25rem;">
            <div class="card-body text-white">
              <h5 class="card-title"><?= count($_SESSION['users']) ?></h5>
              <p class="card-text">Total Students</p>
              <a href="form.php" class="btn btn-outline-light">Add Student</a>
            </div>
          </div>
          <!-- You can also compute “Present” and “Absent” counts if you add status field -->
          <div class="card bg-success m-3" style="width: 25rem;">
            <div class="card-body text-white">
              <h5 class="card-title">0</h5>
              <p class="card-text">Total Present</p>
              <a href="#" class="btn btn-outline-light">See more...</a>
            </div>
          </div>
          <div class="card bg-danger m-3 " style="width: 25rem;">
            <div class="card-body text-white">
              <h5 class="card-title">0</h5>
              <p class="card-text">Total Absent</p>
              <a href="#" class="btn btn-outline-light">See more...</a>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="table-responsive">
            <table class="table table-bordered text-nowrap ">
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
                      <td><?= htmlspecialchars($user['status'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['gender'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['civilstatus'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['nationality'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['dateofbirth'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['placeofbirth'] ?? '') ?></td>
                      <td><?= htmlspecialchars($user['address'] ?? '') ?></td>
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

      <!-- (the rest of your carousel and “Departments”, etc., stays the same) -->

    </div>
  </div>
</body>
</html>
