<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams - School Name</title>
    <style>
        /* Your custom CSS styles go here */
        /* Example styles for reference, modify as needed */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .instructions {
            flex: 1 0 300px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
        }

        .exams-container {
            flex: 1 0 calc(70% - 20px);
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .exam-card {
            flex: 1 0 100%;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .exam-title {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .exam-info {
            margin-bottom: 10px;
        }

        .start-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .error-message {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            margin-bottom: 20px;
        }

        /* Add these styles to your existing CSS */
        .exam-status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin-top: 5px;
            width: 130px;
        }

        .success {
            background-color: #4caf50;
            color: #fff;
        }

        .error {
            background-color: #f44336;
            color: #fff;
        }


        /* Add more styles as needed */
    </style>
</head>

<body>
    <div class="container">
        <!-- Instructions Section -->
        <div class="instructions col-md-5">
            <h2>Instructions:</h2>
            <ol>
                <li>Read the instructions carefully before starting the exam.</li>
                <li>Ensure you have a stable internet connection to avoid any disruptions during the exam.</li>
                <li>You are allowed to take the exam only once. Ensure you are ready before clicking the "Start Exam"
                    button.</li>
                <li>The exam duration is [duration], and the timer will start once you click the "Start Exam" button.
                </li>
                <li>Answer all the questions within the given time limit. Unanswered questions will not be considered
                    for evaluation.</li>
                <li>You can navigate between questions using the navigation buttons provided.</li>
                <li>Do not close the exam window or refresh the page during the exam; it may lead to disqualification.
                </li>
                <li>Avoid any form of cheating or plagiarism. Violation of academic integrity will result in severe
                    consequences.</li>
                <li>Make sure to submit your answers before the time runs out. Late submissions will not be accepted.
                </li>
                <li>If you encounter any technical issues during the exam, raise your hand and inform the invigilator
                    immediately.</li>
            </ol>
        </div>

        <!-- Exams List Section -->
        <div class="exams-container col-md-7">

            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif



            @foreach ($exams as $exam)
                @php
                    $seconds = $exam->duration;
                    $hours = floor($seconds / 3600);
                    $minutes = floor(($seconds % 3600) / 60);
                    $timeAllowed = "$hours hours $minutes minutes";
                    
                    $attempted = \App\Models\QuizResponse::where([
                        'student_id' => session('student')->id,
                        'exam_id' => $exam->id,
                    ])->exists();
                @endphp

                <div class="exam-card">
                    <div class="exam-title">{{ $exam->title }}</div>
                    <div class="exam-info">
                        <strong>Classes:</strong>
                        <?php
                        $classIds = explode(',', $exam->classes);
                        $classNames = [];
                        foreach ($classIds as $classId) {
                            $class = App\Models\Classes::find($classId);
                            if ($class) {
                                $classNames[] = $class->name;
                            }
                        }
                        echo implode(', ', $classNames);
                        ?>
                    </div>
                    <div class="exam-info">
                        <strong>Subject:</strong> {{ $exam->subject->name }}
                    </div>
                    <div class="exam-info">
                        <strong>Time Allowed:</strong> {{ $timeAllowed }}
                    </div>
                    <div class="exam-info">
                        <strong>Questions:</strong> {{ $exam->num_questions }}
                    </div>
                    @if ($attempted)
                        <div class="exam-status success">Attempted</div>
                    @else
                        <div class="exam-status error">Not Attempted</div>
                    @endif
                    <button class="start-button" data-exam-id="{{ $exam->id }}">Start Exam</button>
                </div>
            @endforeach


        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Add event listener to all "Start Exam" buttons
    var startButtons = document.querySelectorAll('.start-button');
    startButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Get the exam ID from the data attribute
            var examId = this.getAttribute('data-exam-id');

            // Generate the URL for the exam page with the examId directly inserted
            var url = `{{ route('cbt.student.exams.show') }}?examId=${examId}`;

            // Show the SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure you want to start the exam?',
                text: 'Please ensure you have read all the instructions carefully.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, start the exam!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the exam page with the exam ID
                    window.location.href = url;
                }
            });
        });
    });
</script>





</html>
