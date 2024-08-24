<?php
// view_surveys.php

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'survey_db');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil semua survei dari database
$sql = "SELECT id, title, description FROM surveys";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Surveys</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        /* Tambahkan CSS yang sesuai di sini jika diperlukan */
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

        .survey-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .survey-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        .survey-item h3 {
            margin: 0 0 10px;
        }

        .survey-item p {
            margin: 0 0 10px;
        }

        .survey-item a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .survey-item a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #333;
            
            padding: 10px 0;
            text-align: center;
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
    <main>
        <div class="container">
            <h2>All Surveys</h2>
            <ul class="survey-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <li class="survey-item">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <a href="survey_details.php?id=<?php echo urlencode($row['id']); ?>">View Details</a><br>
                            <a href="view_survey_all.php?id=<?php echo urlencode($row['id']); ?>">Lihat Semua Jawaban</a>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No surveys found.</p>
                <?php endif; ?>
            </ul>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Survey App. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
