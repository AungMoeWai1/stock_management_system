<!-- User.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<?php 

    class User{
        private $user;
        private $con;

        public function __construct($con, $user){
            $this->con = $con; //this -> con = private $con (connection)
            $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE Name='$user'");
            $this->user = mysqli_fetch_array ($user_details_query); //this -> user = private $user (hold query)
        }

        public function getUsername(){
            return $this->user['Name'];
        }
        public function getUserID() {
            return $this->user['UID'];
            
        }
        public function getUserType(){
            return $this->user['Utype'];
        }

    }



?>