<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        html,
        .login-page {
            height: 100%;
        }

        .login-page {
            display: flex;
        }

        .left-section,
        .right-section {
            flex: 1;
            padding: 20px;
            text-align: center;
        }

        .left-section {
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .right-section {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            /* Fill available space */
            padding: 20px;
            /* Add padding for margin */
        }

        .school-info img {
            max-width: 100px;
        }

        .instructions {
            margin-top: 20px;
            text-align: left;
            /* Align instruction text to the left */
        }

        .instructions h2 {
            margin-bottom: 10px;
            /* Add space below the heading */
        }

        .instructions p {
            margin-bottom: 15px;
            /* Add space between instructions */
        }

        .login-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 30px;
            /* Increased padding for better spacing */
            max-width: 400px;
            width: 100%;
            /* Make the card take 100% width of the right-section */
            margin: 10px;
            /* Add margin around the card */
        }

        .login-card h2 {
            margin-top: 0;
        }

        .login-card label {
            display: block;
            margin-bottom: 10px;
            /* Increased margin between labels and inputs */
            text-align: left;
        }

        .login-card input[type="text"],
        .login-card select {
            width: 100%;
            padding: 12px;
            /* Increased padding for better spacing */
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
            /* Ensure padding does not affect the width */
        }

        .login-card .admission-number-field {
            display: flex;
            justify-content: center;
            /* Center the input field */
        }

        .login-card button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            /* Increased padding for better button size */
            border-radius: 5px;
            cursor: pointer;
        }

        /* Add more CSS styles as needed to further customize the appearance */

        /* Responsive CSS */
        @media (max-width: 768px) {
            .login-page {
                flex-direction: column;
            }

            .left-section,
            .right-section {
                flex: initial;
            }
        }
    </style>
</head>

<body>
    <div class="login-page">
        <div class="left-section">
            <div class="school-info">
                <img src="{{ $school->logo }}" alt="School Logo">
                <h1>{{ $school->name }}</h1>
                <p>{{ $school->address }}</p>
            </div>
            <div class="instructions">
                <h2>Instructions:</h2>
                <p>1. Use your unique Admission Number as the Username.</p>
                <p>2. Choose your class from the dropdown menu before proceeding with the test.</p>
                <p>3. Complete the test within the allocated time.</p>
                <p>4. Ensure you have a stable internet connection before starting the test.</p>
                <p>5. Read each question carefully before answering.</p>
                <p>6. You can save answers for review before final submission.</p>
                <p>7. Avoid cheating, as it goes against the principles of fair evaluation.</p>
                <p>8. Raise your hand for technical support during the test.</p>
                <p>9. Provide post-test feedback for improvements.</p>
            </div>
        </div>
        <div class="right-section">
            <div class="login-card">
                <h2>Student Login</h2>
                <form id="login-form">
                    @csrf
                    <label for="admission-number">Admission Number:</label>
                    <input type="text" id="admission-number" name="admission_number">

                    <label for="class-field">Choose Your Class:</label>
                    <select id="class-field" name="class_field">
                        <option value="" disabled selected>Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" id="login-button">Proceed</button>
                </form>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        $(document).ready(function() {
            $("#login-form").submit(function(event) {
                event.preventDefault(); // Prevent the default form submission behavior
                const loginButton = $("#login-button");

                loginButton.prop("disabled", true).html(
                    '<i class="fa fa-spinner fa-spin"></i> Please wait...');

                // Get the school username from the address bar
                const username = window.location.pathname.split("/")[1];

                // Get the form data
                const formData = new FormData(this);

                // Add the school username to the form data
                formData.append("username", username);

                // Send the form data to the server using Ajax
                $.ajax({
                    url: "/cbt-login",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        if (response.success) {
                            // Redirect to the exams page or perform any other actions on successful login
                            window.location.href = response.redirect;
                        } else {
                            // Show toast message for validation errors
                            if (response.errors) {
                                let errorMessage = "";
                                Object.values(response.errors).forEach(error => {
                                    errorMessage += error[0] + "<br>";
                                });
                                toastr.error(errorMessage, "Validation Error");
                            } else {
                                toastr.error("Invalid credentials", "Error");
                            }
                            loginButton.prop("disabled", false).html("Proceed");
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                        toastr.error("An error occurred. Please try again later.", "Error");
                        loginButton.prop("disabled", false).html("Proceed");
                    }
                });
            });
        });
    </script>


</body>

</html>
