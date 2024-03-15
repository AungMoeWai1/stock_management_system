<?php
include 'session-file.php';

// Initialize variables to store fetched data
$pid = "";
$pName = "";
$pCatID = "";
$pQty = "";
$pDate = "";
$pPrice = "";
$uid = "";


$currentLoginUserID = "";

if (isset($_GET['prod_id'])) {

    $prodID = $_GET['prod_id'];

    $pid_query = mysqli_query($con, "SELECT * FROM products WHERE PID='$prodID'");
    $pid_row = mysqli_fetch_assoc($pid_query);
    $pid = $pid_row['PID'];
    $pName = $pid_row['PName'];
    $pCatID = $pid_row['cid'];
    $pQty = $pid_row['quantity'];
    $pDate = $pid_row['date'];
    $pPrice = $pid_row['price'];
    $uid = $pid_row['uid'];
}

if (isset($_SESSION['username'])) {
    // Get the username from the session
    $userLoggedIn = $_SESSION['username'];

    // Fetch the UID for the logged-in user
    $check_database_query1 = mysqli_query($con, "SELECT UID FROM users WHERE Name='$userLoggedIn'");
    $row = mysqli_fetch_assoc($check_database_query1); // Fetch the result row
    $currentLoginUserID = $row['UID'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_submit'])) {


    // get the form value
    $pid = $_POST['productID'];
    $pname = $_POST["productName"];
    $pqty = $_POST["productQuantity"];
    $pPrice = $_POST["productPrice"];
    $pDate = $_POST["productDate"];
    $pcat = $_POST["productCategory"];
    if ($pname == "") {
        echo "<script>alert('Product name must not be null');</script>";
    } else if ($pqty == "") {
        echo "<script>alert('Must contain Quantity');</script>";
    } else if ($pPrice == "") {
        echo "<script>alert('Must contain Price');</script>";
    } else if ($pDate == "") {
        echo "<script>alert('Select the date');</script>";
    } else if ($pcat == "") {
        echo "<script>alert('Select the category');</script>";
    } else {
        // Construct the SQL query string
        $sql = "UPDATE products SET PName='$pname',quantity='$pqty', date='$pDate', price='$pPrice' WHERE PID='$pid'";

        // Execute the SQL query
        $result = mysqli_query($con, $sql);

        // Check if the query was successful
        if ($result) {
            // Redirect to the index page
            header("Location: index.php");
            echo "<script>alert('Product Updated Successful');</script>";
            exit();
        } else {
            // If the query failed, print the error message
            echo "Error: " . mysqli_error($con);
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Product</title>

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        /* Styles for post upload form */
        .post_form {
            margin-bottom: 20px;
        }

        .post_form input[type="text"],
        .post_form input[type="number"],
        .post_form input[type="datetime-local"],
        .post_form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
            box-sizing: border-box; /* Ensure padding doesn't affect width */
        }

        .post_form select {
            width: 100%;
        }

        /* Styles for buttons */
        .btn-container {
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Product</h1>
        <div class="post-body">
            <form class="post_form" id="postForm" action="updateProduct.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="productID" value="<?php echo $pid; ?>" required>
                <input type="text" name="productName" id="productName" placeholder="Product Name" value="<?php echo $pName; ?>" required/>
                <input type="number" name="productQuantity" id="productQuantity" placeholder="Quantity" value="<?php echo $pQty; ?>" required/>
                <input type="text" name="productPrice" id="productPrice" placeholder="Price" value="<?php echo $pPrice; ?>" required/>
                <input type="datetime-local" name="productDate" id="productDate" value="<?php echo $pDate; ?>" required/>
                <?php $query = "SELECT * FROM category ORDER BY CID";
                $result = mysqli_query($con, $query);
                ?>
                <select name="productCategory" id="productCategory" required>
                    <option value="">Select Category</option>
                    <?php
                    // Check if there are any categories
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through the result set and generate HTML for each category
                        while ($row = mysqli_fetch_assoc($result)) {
                            $cid = $row['CID'];
                            $cname = $row['CName'];
                            $selected = ($cid == $pCatID) ? 'selected' : '';
                            echo "<option value='$cid' $selected>$cname</option>";
                        }
                    } else {
                        echo "<option value='0' disabled>No categories found</option>";
                    }
                    ?>
                </select>
                <div class="btn-container">
                    <button class="btn" type="submit" name="post_submit">Update</button>
                    <a href="index.php" class="btn btn-secondary">Go Back Home</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

