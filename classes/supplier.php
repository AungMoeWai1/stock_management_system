<!-- User.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<?php

class supplier
{
    private $supplier;
    private $con;

    public function __construct($con, $sid)
    {
        $this->con = $con; //this -> con = private $con (connection)
        $category_details_query = mysqli_query($con, "SELECT * FROM users WHERE UID='$sid'");
        $this->supplier = mysqli_fetch_array($category_details_query); //this -> user = private $user (hold query)
    }

    public function getSupplierName()
    {
        return $this->supplier['Name'];
    }
    public function getSupplierID()
    {
        return $this->supplier['UID'];

    }
    public function getSupplierEmail()
    {
        return $this->supplier['Email'];

    }
    public function getSupplierPassword()
    {
        return $this->supplier['Password'];

    }

    public function indexSupplier()
    {
        $ret_str = "";
        $data_query = mysqli_query($this->con, "SELECT * FROM users where Utype='supplier'");

        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $sname = $row['Name'];
                $sid = $row['UID'];
                $email=$row['Email'];
                $pass=$row['Password'];

                // Display post content
                $ret_str .= "<tr>
            <td>$sid</td>
            <td>$sname</td>
            <td>$email</td>
            <td>$pass</td>
          </tr>";
            }

        } else {
            $ret_str = "<td>No Category found </td>";
        }
        echo $ret_str;
    }

}


?>