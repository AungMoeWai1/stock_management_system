<!-- User.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<?php

class Category
{
    private $category;
    private $con;

    public function __construct($con, $cid)
    {
        $this->con = $con; //this -> con = private $con (connection)
        $category_details_query = mysqli_query($con, "SELECT * FROM category WHERE CID='$cid'");
        $this->category = mysqli_fetch_array($category_details_query); //this -> user = private $user (hold query)
    }

    public function getCategoryname()
    {
        return $this->category['CName'];
    }
    public function getCategoryID()
    {
        return $this->category['CID'];

    }


    public function indexCategory()
    {
        $ret_str = "";
        $data_query = mysqli_query($this->con, "SELECT * FROM category");

        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $cname = $row['CName'];
                $cid = $row['CID'];

                // Display post content
                $ret_str .= "<tr>
            <td>$cid</td>
            <td>$cname</td>
          </tr>";
            }

        } else {
            $ret_str = "<td>No Category found </td>";
        }
        echo $ret_str;
    }

}


?>