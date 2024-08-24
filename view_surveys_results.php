<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        /* Tambahkan CSS yang sesuai di sini jika diperlukan */
        .container {
            width: 80%;
            margin: 0 auto;
        }

        header {
            background-color: #f8f8f8;
            padding: 10px 0;
        }

        header h1 {
            margin: 0;
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
        $results_sql = "SELECT question_id, answer FROM survey_responses WHERE survey_id = ?";
        $results_stmt = $conn->prepare($results_sql);

        if (!$results_stmt) {
            die("Error preparing results statement: " . $conn->error);
        }

        $results_stmt->bind_param('i', $survey_id);
        $results_stmt->execute();
        $results_result = $results_stmt->get_result();

        // Store answers in an associative array
        $answers = [];
        while ($row = $results_result->fetch_assoc()) {
            $answers[$row['question_id']] = htmlspecialchars($row['answer']);
        }

        // Tampilkan hasil
		echo "<h3>Survey Results:</h3>";

        // Cek apakah hasil ada
        if (!empty($questions)) {
            foreach ($questions as $index => $question) {
                echo "<div class='question'>";
                echo "<h4>Question " . ($index + 1) . ":</h4>";
                echo "<p>" . htmlspecialchars($question['question']) . "</p>";

                // Get the answer for the current question
                $answer = isset($answers[$index]) ? $answers[$index] : 'No answer';
                echo "<p>Answer: " . $answer . "</p>";
                echo "</div>";
            }
        } else {
            echo "No results found for this survey.";
        }

        // Tutup statement dan koneksi
        $survey_stmt->close();
        $results_stmt->close();
        $conn->close();
        ?>
    </div>
	
	
</body>
</html>

