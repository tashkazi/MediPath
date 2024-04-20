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

if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];


        $provider_id_query = "SELECT provider_id FROM users WHERE id = $user_id AND userType = 'provider'";
        $provider_id_result = $conn->query($provider_id_query);

        if ($provider_id_result->num_rows > 0) {
            $row = $provider_id_result->fetch_assoc();
            $provider_id = $row['provider_id'];
        } else {
            echo "Error: Provider ID not found for the logged-in user.";
            exit();
        }
    } else {
        echo "Error: User ID not found in session.";
        exit();
    }

    $sql = "SELECT * FROM symptoms WHERE patient_id = $patient_id";
    $result = $conn->query($sql);

    echo "<form method='POST'>";
    echo "<input type='hidden' name='patient_id' value='$patient_id'>";
    echo "<table style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th style='border: 1px solid black; width: 10%;'>Date and Time</th><th style='border: 1px solid black; width: 30%;'>Symptom Description</th>";
    echo "<th style='border: 1px solid black; width: 10%;'>Image</th>";
    echo "<th style='border: 1px solid black; width: 20%;'>Video</th>";
    echo "<th style='border: 1px solid black; width: 10%;'>Voice Recording</th>";
    echo "<th style='border: 1px solid black; width: 25%;'>Provider Notes</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='border: 1px solid black;'>" . $row['date_time'] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row['symptom_description'] . "</td>";
        echo "<td style='border: 1px solid black;'>";
        if (!empty($row['image_path'])) {
            echo "<img src='" . $row['image_path'] . "' style='max-width: 100%;'>";
        }
        echo "</td>";

        echo "<td style='border: 1px solid black;'>";
        if (!empty($row['video_path'])) {
            echo "<video controls style='max-width: 100%;'>";
            echo "<source src='" . $row['video_path'] . "' type='video/mp4'>";
            echo "<source src='" . $row['video_path'] . "' type='video/webm'>";
            echo "<source src='" . $row['video_path'] . "' type='video/ogg'>";
            echo "Your browser does not support the video tag.";
            echo "</video>";
        }
        echo "</td>";

        echo "<td style='border: 1px solid black;'>";
        if (!empty($row['voice_record_path'])) {
            echo "<audio controls>";
            echo "<source src='" . $row['voice_record_path'] . "' type='audio/mpeg'>";
            echo "<source src='" . $row['voice_record_path'] . "' type='audio/wav'>";
            echo "<source src='" . $row['voice_record_path'] . "' type='audio/ogg'>";
            echo "Your browser does not support the audio tag.";
            echo "</audio>";
        }
        echo "</td>";

        echo "<td style='border: 1px solid black;'>";
        echo "<textarea name='notes[" . $row['symptom_id'] . "]' style='width: 100%;'>" . $row['provider_notes'] . "</textarea><br>";
        if (!empty($row['provider_notes'])) {
            echo "<input type='submit' name='update_note[" . $row['symptom_id'] . "]' value='Update Note'>";
        } else {
            echo "<input type='submit' name='save_note[" . $row['symptom_id'] . "]' value='Save Note'>";
        }
        echo "</td>";

        echo "</tr>";
    }

    echo "<tr>";
    echo "<td style='border: 1px solid black;'></td>";
    echo "<td style='border: 1px solid black;'><input type='text' name='new_symptom_description' style='width: 100%;'></td>";
    echo "<td style='border: 1px solid black;'></td>";
    echo "<td style='border: 1px solid black;'></td>";
    echo "<td style='border: 1px solid black;'></td>";
    echo "<td style='border: 1px solid black;'></td>";
    echo "</tr>";


    echo "<tr>";
    echo "<td colspan='6' style='text-align: right;'><input type='submit' name='add_symptom' value='Add Symptom'></td>";
    echo "</tr>";

    echo "</table>";


    echo "<a href='patients.html'><button>Go Back</button></a>";

    echo "</form>";

    if (isset($_POST['add_symptom'])) {

        $new_description = $conn->real_escape_string($_POST['new_symptom_description']);

        $insert_sql = "INSERT INTO symptoms (patient_id, provider_id, date_time, symptom_description, provider_notes) VALUES ('$patient_id', '$provider_id', CURRENT_TIMESTAMP, '$new_description', '')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "New symptom added successfully.";
        } else {
            echo "Error adding new symptom: " . $conn->error;
        }
    }


    if (isset($_POST['notes'])) {
        foreach ($_POST['notes'] as $symptom_id => $provider_notes) {
            $provider_notes = $conn->real_escape_string($provider_notes);

            if (isset($_POST['patient_id'])) {
                $patient_id = $_POST['patient_id'];

                $update_notes_sql = "UPDATE symptoms SET provider_notes = '$provider_notes', provider_id = $provider_id WHERE symptom_id = $symptom_id AND patient_id = $patient_id";
                if ($conn->query($update_notes_sql) === TRUE) {
                    echo "Provider notes updated successfully.";
                } else {
                    echo "Error updating provider notes: " . $conn->error;
                }
            } else {
                echo "Error: Patient ID not provided.";
            }
        }
    }
} else {
    echo "Patient ID not provided.";
}

$conn->close();
