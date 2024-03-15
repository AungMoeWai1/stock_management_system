<?php
include 'session-file.php';
@session_start(); // Start the session

$userLoggedIn = $_SESSION['username'];

// Fetch the UID for the logged-in user
$check_database_query1 = mysqli_query($con, "SELECT UID FROM users WHERE Name='$userLoggedIn'");
$row = mysqli_fetch_assoc($check_database_query1); // Fetch the result row
$uid = $row['UID'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST['post_submit'])) {
    $sname = $_POST["supplierName"];
    $sEmail = $_POST["supplierEmail"];
    $sPassword = $_POST["supplierPassword"];
    $sType = "supplier";
    // Get the current date and time
    $pdate = date("Y-m-d H:i:s");

    $strongRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    if ($sname == "") {
        $inputNameNull = "Enter supplier Name";
    } else if ($sEmail == "") {
        $inputGmail = 'Enter suppler Gmail';
    } else if ($sPassword == "") {
        $inputPassword = 'Enter supplier password';
    } else {

        //Filter the input was gmail or not.
        $email = filter_var($_POST['supplierEmail'], FILTER_SANITIZE_EMAIL);
        // Extract domain part of the email address
        $domain = substr(strrchr($email, "@"), 1);
        // Check if the domain is gmail.com
        if ($domain !== "gmail.com") {
            // Invalid email domain
            $emailError = "Must be a Gmail address";
        } else {

            if (preg_match($strongRegex, $sPassword)) {
                // Prepare and execute the SQL statement to insert the post into the database
                $stmt = mysqli_prepare($con, "INSERT INTO users ( Email, Password, Name,Utype) VALUES (?, ?, ?,?)");
                mysqli_stmt_bind_param($stmt, "ssss", $sEmail, $sPassword, $sname, $sType);
                mysqli_stmt_execute($stmt);

                // Check for errors
                if (mysqli_stmt_errno($stmt) !== 0) {
                    $regError = "Enter valid Gmail and strong Password";
                } else {
                    // Close the statement
                    mysqli_stmt_close($stmt);
                    // Redirect to the index page
                    header("Location: manageSupplier.php");
                    exit();
                }

            }

        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add Supplier</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <input type="text" name="supplierName" class="form-control" placeholder="Name" required>
                        <?php if (isset ($inputNameNull))
                            echo '<div style="color: red;">' . $inputNameNull . '</div>'; ?>
                    </div>
                    <div class="form-group">
                        <input type="email" id="supplierEmail" name="supplierEmail" class="form-control"
                            placeholder="Gmail" required>
                        <?php if (isset ($inputGmail))
                            echo '<div style="color: red;">' . $inputGmail . '</div>'; ?>
                        <div id="email-error" style="color: red; display: none;">Invalid Gmail address</div>
                    </div>
                    <div class="form-group">
                        <input type="password" id="supplierPassword" name="supplierPassword" class="form-control"
                            placeholder="Password" required>
                        <div id="password-strength" style="margin-top: 5px;"></div>
                        <?php if (isset ($inputPassword))
                            echo '<div style="color: red;">' . $inputPassword . '</div>'; ?>
                    </div>
                    <?php if (isset ($regError))
                        echo '<div style="color: red;">' . $regError . '</div>'; ?>
                    <div class="form-group">
                        <button type="submit" name="post_submit" class="btn btn-primary mr-2">Add Supplier</button>
                        <button type="reset" name="post_cancel" class="btn btn-secondary mr-2">Clear</button>
                        <a href="manageSupplier.php" class="btn btn-secondary">Go Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Listen for click event on the post_cancel button
        document.querySelector('button[name="post_cancel"]').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default behavior of the button

            // Reset form fields
            document.querySelector('form').reset();
        });

        // Function to validate Gmail address format
        function validateEmail(email) {
            // Regular expression for validating Gmail addresses
            var regex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            return regex.test(email);
        }

        // Function to handle input validation
        function validateInput() {
            var emailInput = document.getElementById("supplierEmail");
            var errorMessage = document.getElementById("email-error");

            if (!validateEmail(emailInput.value)) {
                errorMessage.style.display = "block"; // Show error message
                return false;
            } else {
                errorMessage.style.display = "none"; // Hide error message
                return true;
            }
        }
        // Event listener for input change
        document.getElementById("supplierEmail").addEventListener("input", function () {
            validateInput();
        });

        // Function to check password strength
        function checkPasswordStrength(password) {
            // Define criteria for a strong password
            var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            // Test the password against the regex
            return strongRegex.test(password);
        }

        // Function to update password strength indicator
        function updatePasswordStrength() {
            var password = document.getElementById("supplierPassword").value;
            var strengthIndicator = document.getElementById("password-strength");

            if (checkPasswordStrength(password)) {
                strengthIndicator.innerHTML = "Strong password";
                strengthIndicator.style.color = "green";
            } else {
                strengthIndicator.innerHTML = "Password should contain at least 8 characters including uppercase, lowercase, numbers, and special characters";
                strengthIndicator.style.color = "red";
            }
        }

        // Event listener for password input
        document.getElementById("supplierPassword").addEventListener("input", updatePasswordStrength);


    </script>
</body>

</html>