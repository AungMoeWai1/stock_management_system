<?php
include 'supplierHeader.php';
include 'classes/supplier.php';

$search_query = '';

$user_detail_query = mysqli_query($con, "select * from users where Name='$userLoggedIn'");
$user_array = mysqli_fetch_array($user_detail_query);

if (isset($_GET['search_query'])) {
    $search_query = $_GET['search_query'];
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
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        background-color: transparent;
        border: 1px solid #007bff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        max-width: 900px;
        margin: 0 auto;
        margin-top: -50px;
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
        transform: translateY(-5px);
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

        <div>

            <?php if($user_array['Utype']=='admin'){ ?>
            <!--Manage Supplier Button -->
            <button onclick="addSupplier()">Add Supplier</button>
            <?php } ?>
            
        </div>

        <table>
            <tr>
                <th>User ID</th>
                <th>Email</th>
                <th>Name</th>
                <th>Password</th>
            </tr>
            <?php if ($user_array['Utype'] == 'admin') { ?>
                <div class="show_post">
                    <?php
                    $supplier = new supplier($con, '1');
                    $supplier->indexSupplier();
                    ?>
                </div>
            <?php } ?>
        </table>
    </div>
</div>

<script>
    function addSupplier() {
        window.location.href = "addSupplier.php";
    }
</script>

</div>
</body>

</html>