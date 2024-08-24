<?php
// jawab_survey.php

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'survey_db');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID survei dari form
$survey_id = intval($_POST['survey_id']);

// Loop melalui semua jawaban yang dikirim
foreach ($_POST as $key => $answer) {
    // Lewati survey_id karena itu bukan pertanyaan
    if ($key === 'survey_id') continue;

    // Ambil nomor pertanyaan dari name attribute (misal, "question_1" menjadi 1)
    if (preg_match('/question_(\d+)/', $key, $matches)) {
        $question_id = intval($matches[1]);

        // Cek apakah jawabannya adalah array (untuk checkbox multiple-choice)
        if (is_array($answer)) {
            foreach ($answer as $single_answer) {
                // Simpan setiap jawaban checkbox ke database
                $stmt = $conn->prepare("INSERT INTO survey_responses (survey_id, question_id, answer) VALUES (?, ?, ?)");
                $stmt->bind_param('iis', $survey_id, $question_id, $single_answer);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            // Simpan jawaban single (radio atau text) ke database
            $stmt = $conn->prepare("INSERT INTO survey_responses (survey_id, question_id, answer) VALUES (?, ?, ?)");
            $stmt->bind_param('iis', $survey_id, $question_id, $answer);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Tutup koneksi dan arahkan ke halaman thank you atau hasil survei
$conn->close();
header('Location: view_surveys_results.php?id=' . $survey_id);
exit();
?>
