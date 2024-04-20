<?php


$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_GET['id'])) {

    $provider_id = $conn->real_escape_string($_GET['id']);

    $sql = "SELECT id, first_name, last_name, MINC, email, education, specialization, clinicAffiliation, experience, professionalMembership 
            FROM providers 
            WHERE id = '$provider_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $provider = $result->fetch_assoc();
    } else {

        die("Provider not found");
    }
} else {

    die("No provider ID provided");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 400px;
            padding: 30px;
            width: 60%;
            text-align: left;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        h1 {
            margin-top: 0;
            text-align: center;
        }
        .return-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2C3E50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .return-btn:hover {
            background-color: #34495E;
        }
    </style>
</head>
<body>
<?php if(isset($provider)): ?>
    <div class="container">
        <h1>Provider Profile</h1>
        <p><strong>Name:</strong> <?php echo $provider['first_name'] . ' ' . $provider['last_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $provider['email']; ?></p>
        <p><strong>Education:</strong> <?php echo $provider['education']; ?></p>
        <p><strong>Specialization:</strong> <?php echo $provider['specialization']; ?></p>
        <p><strong>Clinic Affiliation:</strong> <?php echo $provider['clinicAffiliation']; ?></p>
        <p><strong>Experience:</strong> <?php echo $provider['experience']; ?> years</p>
        <?php if(isset($provider['professionalMembership'])): ?>
            <p><strong>Professional Membership:</strong> <?php echo $provider['professionalMembership']; ?></p>
        <?php endif; ?>
        <a href="doctors.html" class="return-btn">&#8592; Return</a>
    </div>
<?php else: ?>
    <p>No provider information found.</p>
<?php endif; ?>
</body>
</html>