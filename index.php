<?php
include 'header.php';
//include 'classes/friend.php';

$searchByproductName = '';
$seachByproductDate = '';


$user_detail_query = mysqli_query($con, "select * from users where Name='$userLoggedIn'");
$user_array = mysqli_fetch_array($user_detail_query);

if (isset ($_GET['searchByProductName'])) {
    $searchByproductName = $_GET['searchByProductName'];
}

if (isset ($_GET['searchByProductDate'])) {
    $seachByproductDate = $_GET['searchByProductDate'];
}
?>


<style>
    /*for product view*/
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Common styles for all devices */
    .archive-box {
        display: block;
        background-color: transparent;
        border: 1px solid #007bff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        max-width: 100%;
        margin: 0 auto;
        margin-top: -50px;
        margin-bottom: 5px;
    }

    .archive-data {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        max-width: 100%;
        margin: 0 auto;
        margin-bottom: 5px;
    }

    .category {
        width: 100px;
        padding: 4px;
        margin: 4px;
        text-align: center;
        background-color: #f0f0f0;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .category.clicked {
        background-color: #90EE90;
        /* Light green */
    }

    .category:hover {
        cursor: pointer;
        font-weight: border-left: 1px solid #eee;
        ;
        transform: translateY(-2px);
    }

    .category h2 {
        margin: 0;
        padding: 5px 0;
        cursor: pointer;
        color: #333;
        font-size: 10px;
    }

    /* for show post */
    .show_post {
        width: 70%;
        margin-left: 150px;
    }

    /* for pop-up upload design */
    .post-upload-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
    }

    .post-upload-btn {
        width: 50px;
        height: 50px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
    }

    .post-upload-btn:hover {
        background-color: #0056b3;
    }

    .popup {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 200px;
        height: 100px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        display: none;
        z-index: 999;
    }

    .popup-close-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: none;
        border: none;
        font-size: 14px;
        color: #007bff;
        cursor: pointer;
    }

    .user-info-container {
        max-width: 900px;
        margin: 0 auto;
        margin-top: 20px;
        padding: 0 20px;
    }

    .user-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .user-details {
        flex: 1;
    }

    .user-details h2 {
        margin-bottom: 10px;
    }

    .user-data {
        margin-top: 10px;
    }

    .user-data-item {
        margin-bottom: 5px;
    }

    .user-data-item .label {
        font-weight: bold;
    }

    .num-posts {
        flex: 0 0 150px;
        text-align: center;
        padding: 20px;
        background-color: #f0f0f0;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .main-container {
        display: flex;
        max-width: 1200px;
        margin: 0 auto;
        margin-top: 70px;
    }

    .user-info-container {
        flex: 0 0 300px;
    }

    .post-container {
        flex: 1;
    }

    /* For Show Friend Function */
    .show_friend {
        position: absolute;
        right: 0;
        top: 0;
        margin-top: 120px;
        width: 15%;
        background-color: #fff;
        border-radius: 5px;
        margin-right: 20px;

    }



    /* Responsive design for smaller devices */
    @media only screen and (max-width: 600px) {
        .show_friend {
            position: inherit;
            width: 88%;
            margin-left: 15px;
            margin-top: 10px;
        }

        .show_post {
            width: 85%;
            margin-left: 15px;
        }

        .archive-box {
            flex-wrap: wrap;
            margin-top: -40px;
        }

        .category {
            width: 20%;
            /* Adjust based on your preference */
        }

        .main-container {
            flex-direction: column;
        }

        .user-info-container {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 20px;
        }

        .user-info-card {
            margin-bottom: 20px;
        }
    }
</style>

<div class="main-container">

    <div class="post-container">
        <div class=archive-box>
            <div style="text-align:center; text-decoration:underline; margin-bottom:5px;">
                <h5 style="font-size:1em;">Filter By Category</h5>
            </div>
            <div class="archive-data">
                <!-- Categories -->

                <input type='hidden' name='username1' id='username1' value="<?php echo $user_array['Name'] ?>">
                <div class="category clicked" onclick='filterProduct("All" ,this)'>
                    <h2>All</h2>
                </div>
                <?php $query = "SELECT * FROM category ORDER BY CID";
                $result = mysqli_query($con, $query);

                // Check if there are any posts matching the selected category
                if (mysqli_num_rows($result) > 0) {
                    // Loop through the result set and generate HTML for each post
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cid = $row['CID'];
                        $cname = $row['CName'];
                        ?>
                        <div class="category" onclick='filterProduct("<?php echo $cname; ?>" ,this)'>
                            <h2>
                                <?php echo $cname; ?>
                            </h2>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>


        <div>
            <!-- Create Product button -->
            <button style="border:1px solid #333;border-radius:3px; margin-bottom:5px;" onclick="createProduct()">
                Add Product
            </button>

        </div>

        <table>
            <thed>
                <tr>
                    <th>PNo</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <?php if ($user_array['Utype'] == 'admin') { ?>
                        <th>Operation</th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody id="productTableBody">
                    <?php
                    $post = new Product($con, $userLoggedIn);
                    if ($searchByproductName != '' && $seachByproductDate != '') {
                        $post->indexProductsByProductNameAndDate($searchByproductName, $seachByproductDate);
                    } else if ($seachByproductDate != '') {
                        $post->indexProductsByProductDate($seachByproductDate);
                    } else if ($searchByproductName != '') {
                        $post->indexProductsByProductName($searchByproductName);
                    } else {
                        ?>
                                <!-- On load Get Product data by admin mode or supplier mode -->
                        <?php if ($user_array['Utype'] == 'admin') { ?>
                                <?php
                                $post = new Product($con, $userLoggedIn);
                                $post->indexProducts();
                                ?>
                        <?php } else {
                            $post = new Product($con, $userLoggedIn);
                            $post->indexProductsBySupplier();
                        }
                    }
                    ?>
                </tbody>
        </table>
    </div>
</div>

<script>
    function createProduct() {
        window.location.href = "createProduct.php";
    }
    function createCategory() {
        window.location.href = "createCategory.php";
    }

    function filterProduct(category, element) {
        // Toggle 'clicked' class on the clicked category
        //element.classList.toggle('clicked');
        element.classList.add('clicked');
        // Remove 'clicked' class from other categories
        document.querySelectorAll('.category').forEach(item => {
            if (item !== element) {
                item.classList.remove('clicked');
            }
        });

        document.querySelector("#productTableBody tr:first-child").style.display = "none";

        var uname = document.getElementsByName('username1')[0].value;

        // Send AJAX request to fetch posts based on the selected category
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'filterProduct.php?category=' + category + '&uname=' + uname, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Update the content of the div containing posts with the response
                document.getElementById("productTableBody").innerHTML = xhr.responseText;
            }
        };
        xhr.send();

    }
</script>

</div>
</body>

</html>