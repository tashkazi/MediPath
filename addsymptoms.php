<?php
session_start();

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to add a symptom.");
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT patient_id FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        die("Patient not found.");
    }

    $patient_id = $result['patient_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $symptom_description = $_POST['symptomDescription'];

        $image_path = null;
        if (isset($_FILES['imageFile']) && $_FILES['imageFile']['name']) {
            $image_path = "uploads/images/" . basename($_FILES['imageFile']['name']);
            move_uploaded_file($_FILES['imageFile']['tmp_name'], $image_path);
        }

        $video_path = null;
        if (isset($_FILES['videoFile']) && $_FILES['videoFile']['name']) {
            $video_file_name = basename($_FILES['videoFile']['name']);
            $video_path = "uploads/videos/" . $video_file_name;
            move_uploaded_file($_FILES['videoFile']['tmp_name'], $video_path);
        }

        $voice_record_path = null;
        if (isset($_FILES['voiceRecording']) && $_FILES['voiceRecording']['name']) {
            $voice_record_path = "uploads/voice_recordings/" . basename($_FILES['voiceRecording']['name']);
            move_uploaded_file($_FILES['voiceRecording']['tmp_name'], $voice_record_path);
        }

        $sql = "INSERT INTO symptoms (patient_id, symptom_description, image_path, video_path, voice_record_path, date_time, unread) 
                VALUES (:patient_id, :symptom_description, :image_path, :video_path, :voice_record_path, CURRENT_TIMESTAMP, 1)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':symptom_description', $symptom_description);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':video_path', $video_path);
        $stmt->bindParam(':voice_record_path', $voice_record_path);
        $stmt->execute();

        checkAndAddNotifications($pdo, $patient_id, $symptom_description);
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

function checkAndAddNotifications($pdo, $patient_id, $symptom_description)
{
    $stmt = $pdo->prepare("SELECT illness_name, common_symptoms FROM serious_illnesses");
    $stmt->execute();
    $serious_illnesses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($serious_illnesses as $illness) {
        $common_symptoms = explode(",", $illness['common_symptoms']);
        foreach ($common_symptoms as $symptom) {
            if (stripos($symptom_description, trim($symptom)) !== false) {
                $notification_message = "Your symptoms may indicate a serious health concern. 
                We strongly advise you to seek immediate medical care. Please consider booking
                 an appointment with your healthcare provider or visiting the nearest emergency
                  room for evaluation and treatment.";
                $sql_add_notification = "INSERT INTO notifications (patient_id, notification_message, timestamp, read_status) VALUES (:patient_id, :notification_message, CURRENT_TIMESTAMP, 0)";
                $stmt_add_notification = $pdo->prepare($sql_add_notification);
                $stmt_add_notification->bindParam(':patient_id', $patient_id);
                $stmt_add_notification->bindParam(':notification_message', $notification_message);
                $stmt_add_notification->execute();
                return;
            }
        }
    }
}
