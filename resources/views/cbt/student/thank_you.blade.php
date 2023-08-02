<!DOCTYPE html>
<html>
<head>
    <title>Exam Result</title>
    <!-- Add your CSS links here -->
    <style>
        /* Add your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            color: #0066cc;
        }

        p {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #0066cc;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0052a3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You for Your Response!</h1>
        <p>Your Score: {{ $score }}</p>
        <p>Exam ID: {{ $examId }}</p>
        <p>Other relevant information can be displayed here.</p>
        <div>
            <a href="" class="btn">Back to Exams List</a>
            <a href="" class="btn">View Full Score</a>
        </div>
    </div>
</body>
</html>
