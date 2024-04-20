<?php
session_start();

$servername = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$dbname = "medipath";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $userType = $_POST["userType"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phoneNumber = $_POST["phoneNumber"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $dateOfBirth = $_POST["dob"];
    $phn = isset($_POST["phn"]) ? $_POST["phn"] : null;
    $MINC = isset($_POST["MINC"]) ? $_POST["MINC"] : null;
    $employmentId = isset($_POST["employmentId"]) ? $_POST["employmentId"] : null;
    $education = isset($_POST["education"]) ? $_POST["education"] : null;
    $specialization = isset($_POST["specialization"]) ? $_POST["specialization"] : null;
    $clinicAffiliation = isset($_POST["clinicAffiliation"]) ? $_POST["clinicAffiliation"] : null;
    $experience = isset($_POST["experience"]) ? $_POST["experience"] : null;
    $certifications = isset($_POST["certifications"]) ? $_POST["certifications"] : null;
    $professionalMembership = isset($_POST["professionalMembership"]) ? $_POST["professionalMembership"] : null;

    $adminApproval = 'pending';
    $providerApproval = 'pending';

    if ($userType == "patient") {
        $stmt = $conn->prepare("INSERT INTO patients (first_name, last_name, phn, phone_number, address, email, password, date_of_birth, userType)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $firstName, $lastName, $phn, $phoneNumber, $address, $email, $password, $dateOfBirth, $userType);
    } elseif ($userType == "provider") {

        $stmt = $conn->prepare("INSERT INTO providers (first_name, last_name, MINC, phone_number, address, email, password, dob, education, specialization, clinicAffiliation, experience, certifications, professionalMembership, userType, approved)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssss", $firstName, $lastName, $MINC, $phoneNumber, $address, $email, $password, $dateOfBirth, $education, $specialization, $clinicAffiliation, $experience, $certifications, $professionalMembership, $userType, $providerApproval);
    } elseif ($userType == "admin") {

        $stmt = $conn->prepare("INSERT INTO admins (first_name, last_name, employment_id, phone_number, address, email, password, date_of_birth, userType, approved)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $firstName, $lastName, $employmentId, $phoneNumber, $address, $email, $password, $dateOfBirth, $userType, $adminApproval);
    }

    if ($stmt->execute() === TRUE) {
        if ($userType == "provider") {
            $_SESSION['success_message'] = 'Registration received. Please have patience while we verify your information.';
            echo "<script>alert('Registration Received. Please have patience while we verify your information.'); window.location.href = 'providerLogin.html';</script>";
            exit();
        } elseif ($userType == "admin") {
            $_SESSION['success_message'] = 'Registration received. Please have patience while we verify your information.';
            echo "<script>alert('Registration Received. Please have patience while we verify your information.'); window.location.href = 'adminLogin.html';</script>";
            exit();
        } else {
            $_SESSION['success_message'] = 'Registration successful! Please log in.';
            echo "<script>alert('Registration successful! Please log in.'); window.location.href = 'login.html';</script>";
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Database error: ' . $conn->error;
        echo "<script>alert('Database error: " . $conn->error . "'); window.location.href = 'patientRegistration.html?error=database_error';</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
}

