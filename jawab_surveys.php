<?php
// survey_details.php

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'survey_db');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID survei dari parameter URL
$survey_id = intval($_GET['id']);

// Ambil detail survei dari database
$sql = $conn->prepare("SELECT title, description, questions FROM surveys WHERE id = ?");
$sql->bind_param('i', $survey_id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $survey = $result->fetch_assoc();
    $questions = json_decode($survey['questions'], true);
} else {
    echo "Survey not found.";
    $conn->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Details</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        /* Tambahkan CSS yang sesuai di sini jika diperlukan */
        .survey-detail {
            margin: 20px;
        }

        .question {
            margin-bottom: 20px;
        }

        .question h4 {
            margin: 0 0 10px;
        }

        .question p {
            margin: 0 0 5px;
        }

        .question ul {
            margin: 0;
            padding-left: 20px;
            list-style-type: disc;
        }

        .question ul li {
            margin-bottom: 5px;
        }

        .text-answer {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="survey-detail">
        <h1><?php echo htmlspecialchars($survey['title']); ?></h1>
        <p><?php echo htmlspecialchars($survey['description']); ?></p>

        <form action="submit_survey.php" method="POST">
            <input type="hidden" name="survey_id" value="<?php echo $survey_id; ?>">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <h4>Question <?php echo $index + 1; ?>:</h4>
                    <p><?php echo htmlspecialchars($question['question']); ?></p>
                    <?php if ($question['type'] === 'multiple-choice'): ?>
                        <ul>
                            <?php foreach ($question['options'] as $option): ?>
                                <li>
                                    <label>
                                        <input type="radio" name="question_<?php echo $index; ?>" value="<?php echo htmlspecialchars($option); ?>">
                                        <?php echo htmlspecialchars($option); ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php elseif ($question['type'] === 'text'): ?>
                        <input type="text" name="question_<?php echo $index; ?>" class="text-answer" placeholder="Type your answer here">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit">submit Survey</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
