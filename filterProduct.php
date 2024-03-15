<?php
// Include your database connection file
include 'session-file.php';
include 'classes/category.php';

// Get the category from the AJAX request
$category = $_GET['category'];
$uname = $_GET['uname'];

$data_query = mysqli_query($con, "SELECT * FROM users WHERE Name='$uname'");
$row = mysqli_fetch_array($data_query);
$utype = $row['Utype'];

if ($utype == 'admin') {

    if ($category == 'All') {

        $ret_str = "";
        $data_query = mysqli_query($con, "SELECT * FROM products");

        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $pid = $row['PID'];
                $cid = $row['cid'];
                $pname = $row['PName'];
                $quantity = $row['quantity'];
                $date = $row['date'];
                $uid = $row['uid'];
                $price = $row['price'];
                $cat_obj = new Category($con, $cid);
                $category_name = $cat_obj->getCategoryname();                

                // Display post content
                $ret_str .= "<tr>
                <td>$pid</td>
                <td>$pname</td>
                <td>$category_name</td>
                <td>$price</td>
                <td>$quantity</td>
                <td>$date</td>
                <td style='text-align: center;width:170px;'> <!-- Center align the content -->
                    <form id='deleteForm' method='post' action='remove_product.php'>
                        <input type='hidden' name='post_id' id='post_id_input' value='$pid'>
                        <input type='hidden' name='post_username' id='post_username_input' value='$uname'>
                        <div class='post_buttons'>
                            <button type='button' class='update_btn' id='updateButton' onclick='updateProduct($pid)'>Update</button>
                            <button type='button' class='delete_btn' id='deleteButton' onclick='deleteProduct($pid)'>Delete</button>
                        </div>
                    </form>
                </td>
              </tr>";
            }
        } else {
            $ret_str = "<td colspan='7'>No product found for this category.</td>";
        }
        echo $ret_str;
    } else {

        $data_query = mysqli_query($con, "SELECT * FROM category WHERE CName='$category'");
        $row = mysqli_fetch_array($data_query);
        $cid = $row['CID'];

        // Query the database to fetch posts based on the selected category
        $query = "SELECT * FROM products WHERE cid = '$cid'";
        $result = mysqli_query($con, $query);

        // Initialize a variable to store the HTML content of the filtered posts
        $filteredPostsHTML = '';

        // Check if there are any posts matching the selected category
        if (mysqli_num_rows($result) > 0) {
            // Loop through the result set and generate HTML for each post
            while ($row1 = mysqli_fetch_assoc($result)) {
                $pid = $row1['PID'];
                $cid = $row1['cid'];
                $pname = $row1['PName'];
                $quantity = $row1['quantity'];
                $date = $row1['date'];
                $uid = $row1['uid'];
                $price = $row1['price'];
                $cat_obj = new Category($con, $cid);
                $category_name = $cat_obj->getCategoryname();                

                // Display post content
                $ret_str= "<tr>
                <td>$pid</td>
                <td>$pname</td>
                <td>$category_name</td>
                <td>$price</td>
                <td>$quantity</td>
                <td>$date</td>
                <td style='text-align: center;width:170px;'> <!-- Center align the content -->
                    <form id='deleteForm' method='post' action='remove_product.php'>
                        <input type='hidden' name='post_id' id='post_id_input' value='$pid'>
                        <input type='hidden' name='post_username' id='post_username_input' value='$uname'>
                        <div class='post_buttons'>
                            <button type='button' class='update_btn' id='updateButton' onclick='updateProduct($pid)'>Update</button>
                            <button type='button' class='delete_btn' id='deleteButton' onclick='deleteProduct($pid)'>Delete</button>
                        </div>
                    </form>
                </td>
              </tr>";
              $filteredPostsHTML.=$ret_str;
            }
            
        } else {
            // If no posts are found, display a message
            $filteredPostsHTML = "<tr><td colspan='7'>No product found for this category.</td></tr>";
        }
        
        // Echo the HTML content of the filtered posts
        echo $filteredPostsHTML;
    }
} else {
    if ($category == 'All') {

        $ret_str = "";
        $data_query = mysqli_query($con, "SELECT * FROM products");

        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $pid = $row['PID'];
                $cid = $row['cid'];
                $pname = $row['PName'];
                $quantity = $row['quantity'];
                $date = $row['date'];
                $uid = $row['uid'];
                $price = $row['price'];
                $cat_obj = new Category($con, $cid);
                $category_name = $cat_obj->getCategoryname();                

                // Display post content
                $ret_str .= "<tr>
                <td>$pid</td>
                <td>$pname</td>
                <td>$category_name</td>
                <td>$price</td>
                <td>$quantity</td>
                <td>$date</td>
              </tr>";
            }
        } else {
            $ret_str = "<tr><td colspan='6'>No posts found for this category.</td></tr>";
        }
        echo $ret_str;
    } else {

        $data_query = mysqli_query($con, "SELECT * FROM category WHERE CName='$category'");
        $row = mysqli_fetch_array($data_query);
        $cid = $row['CID'];

        // Query the database to fetch posts based on the selected category
        $query = "SELECT * FROM products WHERE cid = '$cid'";
        $result = mysqli_query($con, $query);

        // Initialize a variable to store the HTML content of the filtered posts
        $filteredPostsHTML = '';

        // Check if there are any posts matching the selected category
        if (mysqli_num_rows($result) > 0) {
            // Loop through the result set and generate HTML for each post
            while ($row = mysqli_fetch_assoc($result)) {
                $pid = $row['PID'];
                $cid = $row['cid'];
                $pname = $row['PName'];
                $quantity = $row['quantity'];
                $pdate = $row['date'];
                $uid = $row['uid'];
                $price = $row['price'];
                $cat_obj = new Category($con, $cid);
                $category_name = $cat_obj->getCategoryname();                

                // Display post content
                $ret_str = "<tr>
                <td>$pid</td>
                <td>$pname</td>
                <td>$category_name</td>
                <td>$price</td>
                <td>$quantity</td>
                <td>$pdate</td>
              </tr>";
              $filteredPostsHTML.= $ret_str;
            }
            
        } else {
            // If no posts are found, display a message
            $filteredPostsHTML = "<tr><td colspan='6'>No posts found for this category.</td></tr>";
        }

        // Echo the HTML content of the filtered posts
        echo $filteredPostsHTML;
    }
}

?>