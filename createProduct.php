<?php
include 'session-file.php';
@session_start(); // Start the session

$userLoggedIn = $_SESSION['username'];

// Fetch the UID for the logged-in user
$check_database_query1 = mysqli_query($con, "SELECT UID FROM users WHERE Name='$userLoggedIn'");
$row = mysqli_fetch_assoc($check_database_query1); // Fetch the result row
$uid = $row['UID'];
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_submit'])) {

    $pname = $_POST["productName"];
    $pqty = $_POST["productQuantity"];
    $pPrice = $_POST["productPrice"];
    $pDate=$_POST['productDate'];
    $pcat = $_POST["productCategory"];
    if ($pname == "") {
        echo "<script>alert('Product name must not be null');</script>";
    } else if ($pqty == "") {
        echo "<script>alert('Must contain Quantity');</script>";
    } else if ($pPrice == "") {
        echo "<script>alert('Must contain Price');</script>";
    }else if($pDate==""){
        echo "<script>alert('Select the Date');</script>";
    }
     else if ($pcat == "") {
        echo "<script>alert('Select the category');</script>";
    } else {
        // Prepare and execute the SQL statement to insert the post into the database
        $stmt = mysqli_prepare($con, "INSERT INTO products (cid, PName, quantity, uid, date, price) VALUES (?, ?, ?, ?, ?,?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $pcat, $pname, $pqty, $uid, $pDate, $pPrice);
        mysqli_stmt_execute($stmt);

        // Check for errors
        if (mysqli_stmt_errno($stmt) !== 0) {
            echo "Error: " . mysqli_stmt_error($stmt);
        } else {
            // Close the statement
            mysqli_stmt_close($stmt);

            echo "<script>alert('Product is succfully added!');</script>";
            // Redirect to the index page
            header("Location: index.php");
            exit();
        }
    }


}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional Custom Styles */
        body {
            background-color: #f2f2f2;
            padding-top: 20px; /* Add padding to the top to separate navbar */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Create Product</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form class="post_form" id="postForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" class="form-control" name="productName" id="productName"
                                    placeholder="Product Name" required>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="productQuantity" id="productQuantity"
                                    placeholder="Quantity" required>
                            </div>
                            <div class="form-group">
                                <input type="datetime-local" class="form-control" name="productDate" id="productDate"
                                    placeholder="Date" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="productPrice" id="productPrice"
                                    placeholder="Price" required>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="productCategory" id="productCategory" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $query = "SELECT * FROM category ORDER BY CID";
                                    $result = mysqli_query($con, $query);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $cid = $row['CID'];
                                            $cname = $row['CName'];
                                            echo "<option value='$cid'>$cname</option>";
                                        }
                                    } else {
                                        echo "<option value='0' disabled>No categories found</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" name="post_submit">Save</button>
                                <button type="reset" name="post_cancel" class="btn btn-secondary">Clear</button>
                                <a href="index.php" class="btn btn-secondary">Go Back Home</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Listen for click event on the post_cancel button
        document.querySelector('button[name="post_cancel"]').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default behavior of the button
            // Reset form fields
            document.getElementById('productName').value = '';
            document.getElementById('productQuantity').value = '';
            document.getElementById('productPrice').value = '';
            document.getElementById('productCategory').selectedIndex = 0;
            document.getElementById('productDate').value = '';
        });
    </script>
</body>
</html>
