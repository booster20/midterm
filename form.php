<?php
session_start();

$lastname = "";
$firstname = "";
$middlename = "";
$gender = "Male"; 
$civilstatus = "Single"; 
$dateofbirth = "";
$placeofbirth = "";
$nationality = "";
$religion = "";
$contactno = "";
$email = "";
$street = "";
$barangay = "";
$city = "";
$province = "";
$error_messages = [];

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

if (isset($_POST['btnSubmit'])) {
    $lastname = trim($_POST['lastname']);
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $gender = $_POST['gender'];
    $civilstatus = $_POST['civilstatus'];
    $dateofbirth = $_POST['dateofbirth'];
    $placeofbirth = trim($_POST['placeofbirth']);
    $nationality = trim($_POST['nationality']);
    $religion = trim($_POST['religion']);
    $contactno = trim($_POST['contactno']);
    $email = trim($_POST['email']);
    $street = trim($_POST['street']);
    $barangay = trim($_POST['barangay']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);
    
    if (empty($error_messages)) {
        
        $prefix = "STUD20250"; 
        $count = count($_SESSION['users']) + 1;
        $studentno = $prefix . $count;

        $_SESSION['users'][] = [
            'studentno' => $studentno,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'middlename' => $middlename,
            'gender' => $gender,
            'civilstatus' => $civilstatus,
            'dateofbirth' => $dateofbirth,
            'placeofbirth' => $placeofbirth,
            'nationality' => $nationality,
            'religion' => $religion,
            'contactno' => $contactno,
            'email' => $email,
            'street' => $street,
            'barangay' => $barangay,
            'city' => $city,
            'province' => $province,
            'attendance_status' => 'students'
        ];

        header("Location: students.php");
        exit();
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form</title>
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
                        <a class="nav-link" href="students.php">Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="attendance.php">Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="form.php">Form</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container p-1 shadow" style="margin-top: 0px;">
        <div class="container p-1 bg-white" style="margin-top: 5px;">
            <div class="row">
                <p class="fs-1 text-center "><b>Add Student Form</b></p>

                <div class="col-md-12">
                    <form class="was-validated" action="form.php" method="post">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control <?php if(isset($error_messages['lastname'])) echo 'is-invalid'; ?>" id="lastname" name="lastname"
                                    placeholder="ex. Dela Cruz" value="<?= htmlspecialchars($lastname) ?>" required>
                                <div class="invalid-feedback">
                                    <?= $error_messages['lastname'] ?? 'Last Name is Required!' ?>
                                </div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control <?php if(isset($error_messages['firstname'])) echo 'is-invalid'; ?>" id="firstname" name="firstname"
                                    placeholder="ex. Juan" value="<?= htmlspecialchars($firstname) ?>" required>
                                <div class="invalid-feedback">
                                    <?= $error_messages['firstname'] ?? 'First Name is Required!' ?>
                                </div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middlename" name="middlename"
                                    placeholder="ex. Cruz" value="<?= htmlspecialchars($middlename) ?>">
                                <div class="valid-feedback">Optional</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Gender</label>
                                <div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="male" name="gender"
                                            value="Male" <?= ($gender === "Male" ? "checked" : "") ?> required>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="radio" class="form-check-input" id="female" name="gender"
                                            value="Female" <?= ($gender === "Female" ? "checked" : "") ?> required>
                                        <label class="form-check-label" for="female">Female</label>
                                        <div class="invalid-feedback">Required</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Civil Status</label>
                                <select class="form-select <?php if(isset($error_messages['civilstatus'])) echo 'is-invalid'; ?>"
                                    id="civilstatus" name="civilstatus" required>
                                    <option value="">Select</option>
                                    <option value="Single" <?= ($civilstatus === "Single" ? "selected" : "") ?>>Single</option>
                                    <option value="Married" <?= ($civilstatus === "Married" ? "selected" : "") ?>>Married</option>
                                    <option value="Divorced" <?= ($civilstatus === "Divorced" ? "selected" : "") ?>>Divorced</option>
                                    <option value="Widowed" <?= ($civilstatus === "Widowed" ? "selected" : "") ?>>Widowed</option>
                                </select>
                                <div class="invalid-feedback">Invalid Selection</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control <?php if(isset($error_messages['dateofbirth'])) echo 'is-invalid'; ?>"
                                    id="dateofbirth" name="dateofbirth" value="<?= htmlspecialchars($dateofbirth) ?>" required>
                                <div class="invalid-feedback">
                                    <?= $error_messages['dateofbirth'] ?? 'Date of Birth is Required!' ?>
                                </div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Place of Birth</label>
                                <input type="text" class="form-control" name="placeofbirth"
                                    value="<?= htmlspecialchars($placeofbirth) ?>" required placeholder="ex. Tarlac City">
                                <div class="invalid-feedback">Place of Birth is Required!</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nationality</label>
                                <input type="text" class="form-control" name="nationality"
                                    value="<?= htmlspecialchars($nationality) ?>" required placeholder="ex. Filipino">
                                <div class="invalid-feedback">Nationality is Required!</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Religion</label>
                                <input type="text" class="form-control" name="religion"
                                    value="<?= htmlspecialchars($religion) ?>" required placeholder="ex. Roman Catholic">
                                <div class="invalid-feedback">Religion is Required!</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.</label>
                                <input type="tel" class="form-control" name="contactno"
                                    value="<?= htmlspecialchars($contactno) ?>"
                                    pattern="09[0-9]{9}" required placeholder="09XXXXXXXXX">
                                <div class="invalid-feedback">Contact No. is Required! | Invalid Pattern</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?= htmlspecialchars($email) ?>" required placeholder="ex. JuanD@email.com">
                                <div class="invalid-feedback">Email is Required! | Invalid Pattern</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-15">
                                <label class="form-label">Street</label>
                                <input type="text" class="form-control" name="street"
                                    value="<?= htmlspecialchars($street) ?>" required placeholder="ex. 85th Subd.">
                                <div class="invalid-feedback">Street is Required!</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Barangay</label>
                                <input type="text" class="form-control" name="barangay"
                                    value="<?= htmlspecialchars($barangay) ?>" required placeholder="ex. Sto. Rosario">
                                <div class="invalid-feedback">Barangay is Required!</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city"
                                    value="<?= htmlspecialchars($city) ?>" required placeholder="ex. Capas">
                                <div class="invalid-feedback">City is Required!</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province</label>
                                <input type="text" class="form-control" name="province"
                                    value="<?= htmlspecialchars($province) ?>" required placeholder="ex. Tarlac">
                                <div class="invalid-feedback">Province is Required!</div>
                                <div class="valid-feedback">Valid</div>
                            </div>
                        </div>

                        <button type="submit" name="btnSubmit" class="btn btn-success mt-0">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
