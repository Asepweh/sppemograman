<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey App</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2 {
            color: #444;
        }

        /* Header Styles */
        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            text-align: center;
        }

        header nav {
            text-align: center;
            margin-top: 10px;
        }

        header nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: inline-block;
        }

        header nav ul li {
            display: inline;
            margin: 0 10px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        header nav ul li a:hover {
            text-decoration: underline;
        }

        /* Main Styles */
        main {
            padding: 40px 0;
        }

        .intro {
            text-align: center;
            margin-bottom: 30px;
        }

        .actions {
            text-align: center;
        }

        .button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }

        .primary {
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
        }

        .primary:hover {
            background-color: #218838;
        }

        .secondary {
            background-color: #17a2b8;
            color: #fff;
            border-radius: 5px;
        }

        .secondary:hover {
            background-color: #138496;
        }

        /* Footer Styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            
            <nav>
                
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="intro">
                <h2>Welcome to Survey App</h2>
                <p>Easily create and manage surveys. This app is made to meet the web Programming Exam.</p>
            </section>
            <section class="actions">
                <a href="create_survey.php" class="button primary">Create New Survey</a>
                <a href="view_surveys.php" class="button secondary">View All Surveys</a>
            </section>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Survey App BY Asep Mulyana.</p>
        </div>
    </footer>
</body>
</html>
