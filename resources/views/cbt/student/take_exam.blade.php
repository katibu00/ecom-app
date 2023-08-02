<!DOCTYPE html>
<html>

<head>
    <title>{{ $examTitle }}</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }

        #quiz-container {
            width: 95%;
            max-width: 1200px;
            height: auto;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            margin-top: 20px;
        }

        .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            opacity: 0.5;
        }

        /* Optionally, you can change the text color for disabled buttons */
        .btn:disabled {
            color: #888;
        }

        .timer {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .question-box {
            margin-bottom: 20px;
        }

        .question-number-box {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin-right: 10px;
            display: inline-block;
            font-weight: bold;
            cursor: pointer;
        }

        .current-question {
            background-color: #007bff;
            color: #fff;
        }

        .question {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .options {
            margin-left: 20px;
        }

        .option {
            margin-bottom: 5px;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #prev-btn,
        #next-btn {
            background-color: #007bff;
            color: #fff;
        }

        #submit-btn {
            background-color: #28a745;
            color: #fff;
        }

        .question-list {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .question-list .question-number-box {
            margin-bottom: 10px;
        }

        .attempt-progress {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .progress-label {
            margin-right: 10px;
            font-weight: bold;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <form id="quiz-form">
        @csrf
        <input type="hidden" value="{{ $examId }}" name="exam_id" />
        <div id="quiz-container">
            <div class="timer" id="timer">Time Left: 00:00</div>
            <div class="question-list">
                <!-- Small boxes representing question numbers will be generated here -->
            </div>
            <div class="question-box">
                <span class="question-number">1</span>
                <div class="question">What is the capital of France?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" name="question_1_response" value="London" id="option_1">
                        <label for="option_1">London</label>
                    </div>
                    <div class="option">
                        <input type="radio" name="question_1_response" value="Paris" id="option_2">
                        <label for="option_2">Paris</label>
                    </div>
                    <div class="option">
                        <input type="radio" name="question_1_response" value="Berlin" id="option_3">
                        <label for="option_3">Berlin</label>
                    </div>
                    <div class="option">
                        <input type="radio" name="question_1_response" value="Madrid" id="option_4">
                        <label for="option_4">Madrid</label>
                    </div>
                </div>
            </div>



            <div class="navigation-buttons">
                <div>
                    <button type="button" class="btn" id="prev-btn" disabled>Previous</button>
                    <button type="button" class="btn" id="next-btn">Next</button>
                </div>
                <div class="attempt-progress">
                    <div class="progress-label">Questions Attempted:</div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20"
                            aria-valuemin="20" aria-valuemax="100">0%</div>
                    </div>
                </div>
                <button type="submit" class="btn" id="submit-btn">Submit</button>
            </div>
        </div>
    </form>




<script>
    var quizData = {!! $quizDataJson !!};

    var currentQuestionIndex = 0;
    var userResponses = {}; 

    function updateAttemptProgress() {
        const totalQuestions = quizData.length;
        const answeredQuestions = Object.keys(userResponses).length;

        const attemptProgress = (answeredQuestions / totalQuestions) * 100;

        const progressBar = document.querySelector(".progress-bar");
        progressBar.style.width = `${attemptProgress}%`;
        progressBar.textContent = `${Math.round(attemptProgress)}%`;

        // Update the label
        const progressLabel = document.querySelector(".progress-label");
        progressLabel.textContent = `Questions Attempted: ${answeredQuestions} / ${totalQuestions}`;
    }

    function attachOptionEventListeners() {
        document.querySelectorAll(".option input").forEach((optionInput) => {
            optionInput.addEventListener("change", function () {
                saveUserResponse();

                updateAttemptProgress();
            });
        });
    }

    function displayQuestion(index) {
        var currentQuestion = quizData[index];
        // Display the current question and options in the question-box
        document.querySelector(".question-number").textContent = currentQuestion.index;
        document.querySelector(".question").innerHTML = currentQuestion.question; // Use innerHTML here
        var optionsHtml = currentQuestion.options.map(function (option, i) {
            var checked = userResponses[currentQuestion.id] === option ? "checked" : "";
            return `
            <div class="option">
                <input type="radio" name="question_${currentQuestion.id}_response" value="${option}" id="option_${i + 1}" ${checked}>
                <label for="option_${i + 1}">${option}</label>
            </div>
            `;
        }).join("");
        document.querySelector(".options").innerHTML = optionsHtml;

        // Enable/disable next and previous buttons based on the current question index
        document.getElementById("prev-btn").disabled = index === 0;
        document.getElementById("next-btn").disabled = index === quizData.length - 1;

        // Update the question number boxes to indicate the current question
        var questionNumberBoxes = document.querySelectorAll(".question-number-box");
        questionNumberBoxes.forEach(function (box, i) {
            box.classList.remove("current-question");
            if (i === index) {
                box.classList.add("current-question");
            }
        });

        // Attach event listeners to the options of the current question
        attachOptionEventListeners();
    }

    var questionListHtml = quizData.map(function (question) {
        return `<div class="question-number-box">${question.index}</div>`;
    }).join("");
    document.querySelector(".question-list").innerHTML = questionListHtml;

    // Event handler for the next button
    document.getElementById("next-btn").addEventListener("click", function () {
        saveUserResponse();
        currentQuestionIndex++;
        if (currentQuestionIndex >= quizData.length) {
            currentQuestionIndex = quizData.length - 1;
        }
        displayQuestion(currentQuestionIndex);
        updateButtonStates(); // Add this line to update button states
    });

    // Event handler for the previous button
    document.getElementById("prev-btn").addEventListener("click", function () {
        saveUserResponse();
        currentQuestionIndex--;
        if (currentQuestionIndex < 0) {
            currentQuestionIndex = 0;
        }
        displayQuestion(currentQuestionIndex);
        updateButtonStates();
    });

    function saveUserResponse() {
            var currentQuestion = quizData[currentQuestionIndex];
            var selectedOption = document.querySelector(`input[name="question_${currentQuestion.id}_response"]:checked`);
            if (selectedOption) {
                userResponses[currentQuestion.id] = selectedOption.value;
            }
        }

    var questionNumberBoxes = document.querySelectorAll(".question-number-box");
        questionNumberBoxes.forEach(function(box, i) {
            box.addEventListener("click", function() {
                saveUserResponse();
                currentQuestionIndex = i;
                displayQuestion(currentQuestionIndex);
            });
        });

    function updateButtonStates() {
        const prevButton = document.getElementById("prev-btn");
        const nextButton = document.getElementById("next-btn");
        prevButton.disabled = currentQuestionIndex === 0;
        nextButton.disabled = currentQuestionIndex === quizData.length - 1;
    }


    displayQuestion(currentQuestionIndex);
    updateButtonStates();
    updateAttemptProgress();

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<script>
    // Event handler for the submit button
    document.getElementById("submit-btn").addEventListener("click", async function(event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "Once submitted, you won't be able to change your responses.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Submit",
            cancelButtonText: "Cancel",
            reverseButtons: true,
        }).then(async (result) => {
            if (result.isConfirmed) {
                await saveUserResponses();
                submitForm();
            }
        });
    });

    async function saveUserResponses() {
        // Get all the question IDs from the quizData array
        const questionIds = quizData.map((question) => question.id);

        // Loop through each question ID and save the user response for that question
        for (const questionId of questionIds) {
            const selectedOption = document.querySelector(`input[name="question_${questionId}_response"]:checked`);
            if (selectedOption) {
                userResponses[questionId] = selectedOption.value;
            }
        }
    }


  
function submitForm() {
    // Retrieve the CSRF token from the cookie (adjust the name according to your backend)
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const examId = document.querySelector('input[name="exam_id"]').value;

    // Add the CSRF token to the fetch request headers
    fetch("/submit-quiz", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            responses: userResponses,
            examId: examId
        }), // Separate the responses and examId
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.json();
    })
    .then((data) => {
        // Check if the response contains an error message
        if (data.error) {
            Swal.fire("Error", data.error, "error");
        } else {
            // Handle the successful response here
            console.log(data);

            window.location.href = data.redirect_url;

        }
    })
    .catch((error) => {
        // Handle errors here
        console.error("Error submitting quiz:", error);
        Swal.fire("Error", "Quiz submission failed.", "error");
    });
}



</script>

<script>
    // Timer function to display and handle the timer
    function startTimer() {
        const timerElement = document.getElementById("timer");
        const submitButton = document.getElementById("submit-btn");
        const warningThreshold = 10000; // 10 seconds warning threshold

        let timeLeft = {!! $durationInSeconds !!};

        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            return `${minutes.toString().padStart(2, "0")}:${remainingSeconds.toString().padStart(2, "0")}`;
        }

        function updateTimer() {
            timeLeft--;
            timerElement.textContent = `Time Left: ${formatTime(timeLeft)}`;

            if (timeLeft === warningThreshold / 1000) {

                Swal.fire("Warning", "Only 10 seconds remaining!", "warning");
            }

            if (timeLeft <= 0) {

                clearInterval(timerInterval);
                timerElement.textContent = "Time's Up!";
                Swal.fire("Time's Up!", "Your time is up. The quiz will be submitted automatically.", "warning").then(
                    () => {
                        submitForm();
                    });
            }
        }

        updateTimer();

        const timerInterval = setInterval(updateTimer, 1000);
    }

    startTimer();
</script>

</body>

</html>





</body>

</html>
