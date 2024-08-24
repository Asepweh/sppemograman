<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'survey_db');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $questions = $_POST['questions'];
    $questionTypes = $_POST['question-type'];
    $options = isset($_POST['options']) ? $_POST['options'] : [];

    // Format pertanyaan dan opsi menjadi array
    $formattedQuestions = [];
    foreach ($questions as $index => $questionText) {
        $questionNumber = $index + 1;
        $type = $questionTypes[$index];
        
        // Format opsi jika ada
        $formattedOptions = [];
        if ($type === 'multiple-choice' && isset($options[$questionNumber])) {
            foreach ($options[$questionNumber] as $optionText) {
                $formattedOptions[] = $optionText;
            }
        }

        $formattedQuestions[] = [
            'question' => $questionText,
            'type' => $type,
            'options' => $formattedOptions
        ];
    }

    // Simpan informasi survei dengan pertanyaan dalam format JSON
    $questionsJson = json_encode($formattedQuestions);
    $stmt = $conn->prepare("INSERT INTO surveys (title, description, questions) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $title, $description, $questionsJson);
    $stmt->execute();
    $stmt->close();

    echo "Survey created successfully!";
    header('Location: view_surveys.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Survey</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f3f4;
            color: #202124;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            font-weight: 500;
            color: #1a73e8;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: 500;
            color: #5f6368;
        }
        .input-field, .textarea-field, .question-type, .option-field {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            font-size: 14px;
            background-color: #fff;
            box-sizing: border-box;
            color: #202124;
        }
        .input-field:focus, .textarea-field:focus, .question-type:focus, .option-field:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.3);
        }
        .questions-group {
            margin-bottom: 20px;
        }
        .button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .add-btn {
            background-color: #1a73e8;
            color: #fff;
        }
        .add-btn:hover {
            background-color: #1669c1;
        }
		.button-group {
			display: flex;
			gap: 10px; /* Menambahkan jarak antar tombol */
			margin-bottom: 20px; /* Menambahkan margin bawah */
		}

        .submit-btn {
            background-color: #34a853;
            color: #fff;
        }
        .submit-btn:hover {
            background-color: #2a8f47;
        }
        .secondary {
            background-color: #5f6368;
            color: #fff;
        }
        .secondary:hover {
            background-color: #444;
        }
        .add-option-btn {
            background-color: #fbbc04;
            color: #fff;
            border-radius: 4px;
            margin-top: 10px;
            padding: 8px 12px;
            cursor: pointer;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .add-option-btn:hover {
            background-color: #e09b03;
        }
        .options-group {
            margin-top: 10px;
        }
        .options-group ul {
            list-style-type: none;
            padding-left: 0;
        }
        .options-group ul li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .option-field {
            margin-left: 10px;
            flex-grow: 1;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: #5f6368;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        footer p {
            margin: 0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let questionCount = 1;

            const addQuestionButton = document.getElementById('addQuestion');
            const questionsContainer = document.getElementById('questions');

            addQuestionButton.addEventListener('click', () => {
                questionCount++;
                const newQuestion = document.createElement('div');
                newQuestion.classList.add('question', 'form-group');
                newQuestion.innerHTML = `
                    <label>Question ${questionCount}:</label>
                    <input type="text" name="questions[]" class="input-field" required>
                    <label for="question-type-${questionCount}">Answer Type:</label>
                    <select name="question-type[]" class="input-field question-type" data-question="${questionCount}">
                        <option value="text">Text</option>
                        <option value="multiple-choice">Multiple Choice</option>
                    </select>
                    <div class="options-group" id="options-group-${questionCount}" style="display:none;">
                        <label>Options:</label>
                        <ul id="options-list-${questionCount}">
                            <li>
                                <input type="radio" name="multiple-choice-${questionCount}" disabled>
                                <input type="text" name="options[${questionCount}][]" class="input-field option-field">
                            </li>
                        </ul>
                        <button type="button" class="button add-option-btn" data-question="${questionCount}">Add Option</button>
                    </div>
                `;
                questionsContainer.appendChild(newQuestion);
            });

            document.addEventListener('change', (event) => {
                if (event.target.matches('.question-type')) {
                    const questionId = event.target.getAttribute('data-question');
                    const optionsGroup = document.getElementById(`options-group-${questionId}`);
                    if (event.target.value === 'multiple-choice') {
                        optionsGroup.style.display = 'block';
                    } else {
                        optionsGroup.style.display = 'none';
                    }
                }
            });

            document.addEventListener('click', (event) => {
                if (event.target.matches('.add-option-btn')) {
                    const questionId = event.target.getAttribute('data-question');
                    const optionsList = document.getElementById(`options-list-${questionId}`);
                    const newOption = document.createElement('li');
                    newOption.innerHTML = `
                        <input type="radio" name="multiple-choice-${questionId}" disabled>
                        <input type="text" name="options[${questionId}][]" class="input-field option-field">
                    `;
                    optionsList.appendChild(newOption);
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Create New Survey</h2>
        <form id="surveyForm" action="create_survey.php" method="POST">
            <div class="form-group">
                <label for="title">Survey Title:</label>
                <input type="text" id="title" name="title" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="textarea-field" required></textarea>
            </div>

            <h3>Questions</h3>
            <div id="questions" class="questions-group">
                <div class="question form-group">
                    <label>Question 1:</label>
                    <input type="text" name="questions[]" class="input-field" required>
                    <label for="question-type-1">Answer Type:</label>
                    <select name="question-type[]" class="input-field question-type" data-question="1">
                        <option value="text">Text</option>
                        <option value="multiple-choice">Multiple Choice</option>
                    </select>
                    <div class="options-group" id="options-group-1" style="display:none;">
                        <label>Options:</label>
                        <ul id="options-list-1">
                            <li>
                                <input type="radio" name="multiple-choice-1" disabled>
                                <input type="text" name="options[1][]" class="input-field option-field">
                            </li>
                        </ul>
                        <button type="button" class="button add-option-btn" data-question="1">Add Option</button>
                    </div>
                </div>
            </div>
            <div class="button-group">
                <button type="button" id="addQuestion" class="button add-btn">Add Another Question</button>
                <button type="submit" class="button submit-btn">Create Survey</button><br>
            </div>
        </form>
        <form action="index.php" method="get"><button type="submit" class="button secondary">Back</button>
        </form>
    </div>
    <footer>
        <p>Survey App BY Asep Mulyana - 2024</p>
    </footer>
</body>
</html>
```


