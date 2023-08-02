<!DOCTYPE html>
<html>
<head>
    <title>Exam Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

       
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .question-container {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .question {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .options {
            margin-left: 20px;
        }

        .option {
            margin-bottom: 5px;
        }

        .your-response {
            font-weight: bold;
        }

        .status {
            font-weight: bold;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }

        .score {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .attempts {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .go-back-button {
            display: block;
            text-align: center;
            margin-bottom: 20px;
        }
        .go-back-button {
            text-align: center;
            margin-bottom: 20px;
        }

        .go-back-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .go-back-button a:hover {
            background-color: #0056b3;
        }

        .question-container.correct {
            background-color: #c3e6cb; /* Green background for correct responses */
        }

        .question-container.incorrect {
            background-color: #f5c6cb; /* Red background for incorrect responses */
        }
    </style>
</head>
<body>
    <h1>Exam Result</h1>
    <p style="text-align: center">Your Response has been submitted and here is your Result for your Revision.</p>
    
    <div class="go-back-button">
        <a href="{{ route('exams.list', ['username' => $username->username]) }}">Go Back</a>
    </div>

    <div class="score">Total Score: {{ $score }} / {{ $totalQuestions }}</div>
    <div class="attempts">Number of Questions Attempted: {{ $attemptedQuestions }}</div>

    <div>
        @php
        $questionNumber = 1;
        @endphp

        @foreach($questionsDetails as $question)
        @php
        $userResponse = \App\Models\QuizResponse::where([
            'student_id' => $student->id,
            'exam_id' => $examId,
            'question_id' => $question->id,
        ])->first();
        @endphp

        <div class="question-container {{ $userResponse && $userResponse->is_correct ? 'correct' : 'incorrect' }}">
            <div class="question"> {{ $questionNumber }}: {!! $question->question !!}</div>
            <div class="options">
                @php
                $options = json_decode($question->options);
                $letters = ['a', 'b', 'c', 'd', 'e', 'f'];
                @endphp
                @foreach($options as $index => $option)
                <div class="option">
                    <span>{{ $letters[$index] }})</span> {{ $option }}
                </div>
                @endforeach
            </div>
            <div class="correct-answer">
                <p>Correct Answer: {{ $question->correct_answer }}</p>
            </div>
            <div class="your-response">
                <p>Your Response: {{ $userResponse->response ?? 'Not Attempted' }}</p>
            </div>
            <div class="status">
                <p>Status: {{ $userResponse && $userResponse->is_correct ? 'Correct' : 'Incorrect' }}</p>
            </div>
        </div>
        <hr>
        @php
        $questionNumber++;
        @endphp
        @endforeach
    </div>
    <div class="go-back-button">
        <a href="{{ route('exams.list', ['username' => $username->username]) }}">Go Back</a>
    </div>
</body>
</html>
