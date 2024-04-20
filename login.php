<?php
session_start();

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$passwordAttempt = $_POST['password'];

$stmt = $conn->prepare("SELECT u.id, u.password, u.userType, u.patient_id, u.provider_id, u.admin_id, a.approved AS admin_approved, p.approved AS provider_approved FROM users u LEFT JOIN admins a ON u.admin_id = a.id LEFT JOIN providers p ON u.provider_id = p.id WHERE u.email = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("s", $email);
if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($passwordAttempt, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['userType'] = $row['userType'];

        if ($_SESSION['userType'] === 'provider' && $row['provider_approved'] !== 'approved') {
            echo "<script>alert('Thank You for your patience while we verify your information.'); window.location.href='providerLogin.html';</script>";
            exit();
        } elseif ($_SESSION['userType'] === 'admin' && $row['admin_approved'] !== 'approved') {
            echo "<script>alert('Thank You for your patience while we verify your information..'); window.location.href='adminLogin.html';</script>";
            exit();
        } elseif ($_SESSION['userType'] === 'patient') {
            $_SESSION['patient_id'] = $row['patient_id'];
            header("Location: patientHomepage.html");
            exit();
        }

        if ($_SESSION['userType'] === 'provider' && $row['provider_approved'] === 'approved') {
            $_SESSION['provider_id'] = $row['provider_id'];
            header("Location: providerHomepage.html");
            exit();
        } elseif ($_SESSION['userType'] === 'admin' && $row['admin_approved'] === 'approved') {
            $_SESSION['admin_id'] = $row['admin_id'];
            header("Location: adminHomepage.html");
            exit();
        }
    } else {
        echo "<script>alert('Incorrect email or password. Please try again.'); window.location.href='login.html';</script>";
        exit();
    }
} else {
    echo "<script>alert('Incorrect email or password. Please try again.'); window.location.href='login.html';</script>";
    exit();
}

$stmt->close();
$conn->close();

