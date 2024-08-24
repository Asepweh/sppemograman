<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }

        header {
            background-color: #f8f8f8;
            padding: 10px 0;
        }

       

        h3 {
            margin-top: 20px;
            font-size: 20px;
        }

        .question {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .question h4 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .question p {
            margin: 0;
        }

        .answers {
            margin-top: 10px;
        }

        .answer-item {
            margin-bottom: 5px;
            padding: 5px;
            background-color: #f0f0f0;
            border-radius: 4px;
        }

        .respondent-header {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
		body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            
            padding: 10px 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 0 10px;
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-start;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            
            text-decoration: none;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }
		 
    </style>
    <title>Survey Results</title>
</head>
<body>
    <header>
        <div class="container">
            <h1>Survey App</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="create_survey.php">Create Survey</a></li>
                    <li><a href="view_surveys.php">View Surveys</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>

    <div class="container">
        <?php
        // Koneksi ke database
        $conn = new mysqli('localhost', 'root', '', 'survey_db');

        // Cek koneksi
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Ambil ID survei dari parameter URL
        $survey_id = intval($_GET['id']);

        // Query untuk mendapatkan detail survei
        $survey_sql = "SELECT title, description, questions FROM surveys WHERE id = ?";
        $survey_stmt = $conn->prepare($survey_sql);

        if (!$survey_stmt) {
            die("Error preparing survey statement: " . $conn->error);
        }

        $survey_stmt->bind_param('i', $survey_id);
        $survey_stmt->execute();
        $survey_result = $survey_stmt->get_result();

        if ($survey_result->num_rows > 0) {
            $survey_row = $survey_result->fetch_assoc();
            $questions = json_decode($survey_row['questions'], true);
            echo "<h1>" . htmlspecialchars($survey_row['title']) . "</h1>";
            echo "<p>" . htmlspecialchars($survey_row['description']) . "</p>";
        } else {
            echo "Survey not found.";
            $survey_stmt->close();
            $conn->close();
            exit;
        }

        // Query untuk mendapatkan hasil survei
        $results_sql = "SELECT id, question_id, answer FROM survey_responses WHERE survey_id = ? ORDER BY id, question_id";
        $results_stmt = $conn->prepare($results_sql);

        if (!$results_stmt) {
            die("Error preparing results statement: " . $conn->error);
        }

        $results_stmt->bind_param('i', $survey_id);
        $results_stmt->execute();
        $results_result = $results_stmt->get_result();

        // Tampilkan hasil
        echo "<h3>Survey Results:</h3>";

        // Mengelompokkan jawaban berdasarkan respondent_id
        $responses = [];
        while ($row = $results_result->fetch_assoc()) {
            $responses[$row['id']][$row['question_id']] = htmlspecialchars($row['answer']);
        }

        // Tampilkan jawaban berdasarkan respondent_id dengan label "Responden 1", "Responden 2", dll.
        $respondent_counter = 1;
        foreach ($responses as $answers) {
            echo "<div class='respondent-header'>Responden " . $respondent_counter . "</div>";
            $respondent_counter++;

            foreach ($questions as $index => $question) {
                echo "<div class='question'>";
                echo "<h4>Question " . ($index + 1) . ":</h4>";
                echo "<p>" . htmlspecialchars($question['question']) . "</p>";

                $answer = isset($answers[$index + 1]) ? $answers[$index + 1] : 'No answer';
                echo "<div class='answer-item'>Answer: " . $answer . "</div>";
                echo "</div>";
            }
        }

        // Tutup statement dan koneksi
        $survey_stmt->close();
        $results_stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
