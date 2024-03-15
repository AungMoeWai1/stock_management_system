<?php
include 'session-file.php';
// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Get the username of the currently logged-in user
    $loggedInUsername = $_SESSION['username'];
    

    // Check if postId and userName are set in the POST request
    if (isset($_POST['productId'])) {
        

        // Get postId and userName from POST request
        $productId = $_POST['productId'];
        $userName = $_POST['userName'];

        // Sanitize the userName to prevent SQL injection
        $uname = mysqli_real_escape_string($con, $userName);

        // Check if the userName from the POST request matches the username of the currently logged-in user
        if ($uname === $loggedInUsername) {

            // Delete the post
            $query = mysqli_query($con, "DELETE FROM products WHERE PID='$productId'");

            // Check if the deletion was successful
            if ($query) {
                // Actions after successful deletion
                echo "Post deleted successfully.";
            } else {
                // Error deleting the post
                echo "Error deleting post.";
            }
        } else {
            // User is not authorized to delete this post
            echo "You are not authorized to delete this post.";
        }
    } else {
        // postId or userName is not set in the POST request
        header("Location: index.php");
        exit(); 
    }
} else {
    // User is not logged in
    echo "You are not logged in.";
}
?>