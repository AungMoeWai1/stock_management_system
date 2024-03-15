<!-- Login.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<?php
include 'session-file.php';

//for button submit to login
if (isset ($_POST['login_button'])) {

    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);

    $_SESSION['log_email'] = $email;
    // Extract domain part of the email address
    $domain = substr(strrchr($email, "@"), 1);

    // Check if the domain is gmail.com
    if ($domain !== "gmail.com") {
        // Invalid email domain
        $emailError = "Must be a Gmail address";
    } else {
        $password = $_POST['log_password'];
        $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE Email='$email' AND Password='$password'");
        $check_login_query = mysqli_num_rows($check_database_query);

        if ($check_login_query == 1) {
            $row = mysqli_fetch_array($check_database_query);
            $username = $row['Name'];
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $loginError = "Gmail or Password was incorrect";
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management System - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f3f3;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #000;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #44c2d8;
        }

        .toggle-password {
            position: absolute;
            top: 38.5%;
            margin-left: -25px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ccc;
        }

        .toggle-password:hover {
            color: #44c2d8;
        }

        .form-submit {
            text-align: center;
        }

        .form-submit button {
            padding: 12px 24px;
            background-color: #44c2d8;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-submit button:hover {
            background-color: #3299aa;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: #666;
        }

        .form-footer a {
            color: #44c2d8;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="form-title">Stock Management System</h2>
        <form action="login.php" method="POST">
            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Gmail Address</label>
                <input type="text" id="email" name="log_email" placeholder="Gmail" value="<?php if (isset ($_SESSION['log_email'])) {
                    echo $_SESSION['log_email'];
                } ?>" required>
                <!-- Error message for email -->
                <div id="email-error" style="color: red; display: none;">Must be a valid Gmail address</div>
                <?php if (isset ($emailError))
                    echo '<div style="color: red;">' . $emailError . '</div>'; ?>
            </div>
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="log_password" placeholder="Password" required>
                    <i class="far fa-eye toggle-password"
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                        onclick="togglePassword('password')"></i>
                </div>
                <!-- Error message for password -->
            </div>
            <?php if (isset ($loginError))
                echo '<div style="color: red;">' . $loginError . '</div>'; ?>
            <!-- Submit Button -->
            <div class="form-submit">
                <button type="submit" name="login_button">Login</button>
            </div>
        </form>
    </div>
    <!-- JavaScript for toggling password visibility -->
    <script>
        function togglePassword(inputId) {
            var x = document.getElementById(inputId);
            var icon = document.querySelector('#' + inputId + ' + .toggle-password');
            if (x.type === "password") {
                x.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                x.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        // Event listener for input change
        document.getElementById("email").addEventListener("input", function () {
            var emailInput = document.getElementById("email");
            var errorMessage = document.getElementById("email-error");

            if (!validateEmail(emailInput.value)) {
                errorMessage.style.display = "block"; // Show error message
                emailInput.style.borderColor = "red"; // Apply red border color to input
                return false;
            } else {
                errorMessage.style.display = "none"; // Hide error message
                emailInput.style.borderColor = ""; // Remove custom border color
                return true;
            }
        });
        // Function to validate Gmail address format
        function validateEmail(email) {
            // Regular expression for validating Gmail addresses
            var regex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            return regex.test(email);
        }
    </script>
</body>

</html>