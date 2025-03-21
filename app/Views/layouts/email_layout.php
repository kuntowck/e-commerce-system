<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration Confirmation</title>

    <style>
        body {
            font-family: Inter, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f5f5f5;
        }

        header {
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            background-color: #fff;
        }

        main {
            padding: 20px;
        }

        footer {
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            border-radius: 8px;
            background-color: #fff;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-top: 20px;
            background-color: #fff;
        }

        .card-header {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-body {
            padding: 10px;
        }

        .card-body li {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <?= $this->renderSection('title'); ?>
        </header>

        <main>
            <?= $this->renderSection('content'); ?>
        </main>

        <footer>
            <p>This email was sent automatically. Please do not reply to this email.</p>
            <p>&copy; 2025 Student Management System</p>
        </footer>
    </div>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>