<!-- Post.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<?php
include ('category.php');

class Product
{
    private $user_obj;
    private $con;

    public function __construct($con, $user)
    {
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }
    public function createTextForSupplier($data_query)
    {
        $ret_str = "";
        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $pid = $row['PID'];
                $cid = $row['cid'];
                $pname = $row['PName'];
                $quantity = $row['quantity'];
                $date = $row['date'];
                $uid = $row['uid'];
                $price = $row['price'];
                $cat_obj = new Category($this->con, $cid);
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
            $ret_str = "<tr><td colspan='6'>No product found for this category.</td></tr>";
        }
        return $ret_str;
    }
    public function createTextForAdmin($data_query, $uname)
    {
        $ret_str = "";
        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $pid = $row['PID'];
                $cid = $row['cid'];
                $pname = $row['PName'];
                $quantity = $row['quantity'];
                $date = $row['date'];
                $uid = $row['uid'];
                $price = $row['price'];
                $cat_obj = new Category($this->con, $cid);
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
            $ret_str = "<tr><td colspan='7'>No product found for this category.</td></tr>";
        }
        return $ret_str;
    }

    //for admin view ,start selecting all product
    public function indexProducts()
    {
        $uname = $this->user_obj->getUsername();
        $ret_str = "";
        $data_query = mysqli_query($this->con, "SELECT * FROM products");
        $ret_str = $this->createTextForAdmin($data_query, $uname);
        echo $ret_str;
    }

    // for show by other user 
    public function indexProductsBySupplier()
    {
        $ret_str = "";
        $data_query = mysqli_query($this->con, "SELECT * FROM products");
        $ret_str = $this->createTextForSupplier($data_query);
        echo $ret_str;
    }
    public function indexProductsByProductName($search_query)
    {
        $utype = $this->user_obj->getUserType();
        $uname = $this->user_obj->getUsername();
        if ($utype == "admin") {
            $data_query = mysqli_query($this->con, "SELECT * FROM products WHERE PName LIKE '%$search_query%' ");
            $ret_str = $this->createTextForAdmin($data_query, $uname);
            echo $ret_str;
        } else if ($utype == "supplier") {
            $data_query = mysqli_query($this->con, "SELECT * FROM products WHERE PName LIKE '%$search_query%' ");
            $ret_str = $this->createTextForSupplier($data_query);
            echo $ret_str;
        }
    }

    //Search by Product Data
    public function indexProductsByProductDate($search_query)
    {
        $utype = $this->user_obj->getUserType();
        $uname = $this->user_obj->getUsername();
        //Check the user , It is Admin or supplier        
        if ($utype == "admin") {

            $data_query = mysqli_query($this->con, "SELECT * FROM products WHERE date LIKE '%$search_query%' ");
            $ret_str = $this->createTextForAdmin($data_query, $uname);
            echo $ret_str;
        } else if ($utype == "supplier") {
            $data_query = mysqli_query($this->con, "SELECT * FROM products WHERE date LIKE '%$search_query%' ");
            $ret_str = $this->createTextForSupplier($data_query);
            echo $ret_str;
        }

    }
    public function indexProductsByProductNameAndDate($search_name, $search_date)
    {

        $utype = $this->user_obj->getUserType();
        $uname = $this->user_obj->getUsername();
        if ($utype == "admin") {

            $data_query = mysqli_query($this->con, "SELECT * FROM products WHERE PName LIKE '%$search_name%' AND  date LIKE '%$search_date%'");
            $ret_str = $this->createTextForAdmin($data_query, $uname);
            echo $ret_str;
        } else if ($utype == "supplier") {
            $data_query = mysqli_query($this->con, "SELECT * FROM products WHERE PName LIKE '%$search_name%' AND  date LIKE '%$search_date%' ");

            $ret_str = $this->createTextForSupplier($data_query);

            echo $ret_str;
        }
    }

}//end class
?>

<script>

    //For delete the product by the user clicked product ID
    function deleteProduct(pID) {
        // Get the post ID value
        var uname = document.getElementsByName('post_username')[0].value; // Get the username based on name attribute
        // Perform any operations with the post ID value
        var confirmation = confirm("Are you sure to delete this product?");
        if (confirmation) {
            // Send AJAX request to delete post
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'remove_product.php', true);

            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    //alert(xhr.responseText);
                    window.location.reload();
                    // You can perform any additional actions here after post deletion
                }
            };
            xhr.send('productId=' + pID + '&userName=' + uname); // Corrected sending of postId
        }
    }

    //for update the product by the user Clicked product ID
    function updateProduct(proID) {
        // Get the post ID value
        var uname = document.getElementsByName('post_username')[0].value; // Get the username based on name attribute
        // Redirect to postUpdate.php with the post ID
        window.location.href = 'updateProduct.php?prod_id=' + proID;
    }
</script>

<style>
    /* Updated Styles for Post Cards */
    .status_post_card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .post_profile_pic {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 20px;
        float: left;
    }

    .post_body {
        overflow: hidden;
        /* Clear float */
    }

    .post_body h2 {
        margin: 0;
        font-size: 20px;
    }

    .user_circle_button {
        float: right;
        margin-top: 10px;
    }

    .circle_button {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
        border: none;
        font-size: 16px;
        cursor: pointer;
        outline: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .circle_button:hover {
        background-color: #0056b3;
    }

    .post_body span {
        font-size: 14px;
        color: #888888;
        display: block;
        margin-bottom: 5px;
    }

    .post_body p {
        font-size: 16px;
        margin-top: 10px;
        line-height: 1.6;
    }

    .post_buttons {
        margin-top: 10px;
        float: right;
        display: inline-block;
    }

    .post_buttons button {
        width: 37%;
        padding: 8px 3px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
        transition: background-color 0.3s ease;
    }

    .update_btn {
        font-size: 0.7em;
        background-color: #28a745;
        color: #fff;
    }

    .delete_btn {
        font-size: 0.7em;
        background-color: #dc3545;
        color: #fff;
    }

    .post_buttons button:hover {
        opacity: 0.8;
    }

    /* Responsive Styles */
    @media screen and (max-width: 600px) {

        .status_post_card {
            width: 85%;
        }

        .post_profile_pic {
            display: none;
        }

        .post_body h2 {
            font-size: 18px;
        }

        .circle_button {
            width: 25px;
            height: 25px;
            font-size: 14px;
        }

        .post_body span {
            font-size: 12px;
        }

        .post_body p {
            font-size: 14px;
        }
    }
</style>