<?php
echo "Thanks for subscribing us !!";
require_once 'connection/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists
        $check_sql = "SELECT * FROM newsletter_subscribers WHERE email = ?";
        $stmt = mysqli_prepare($connection, $check_sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $message = "You're already subscribed!";
        } else {
            // Insert new subscriber
            $insert_sql = "INSERT INTO newsletter_subscribers (email, subscribed_at) VALUES (?, NOW())";
            $stmt = mysqli_prepare($connection, $insert_sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            
            if (mysqli_stmt_execute($stmt)) {
                $message = "Thank you for subscribing to our newsletter!";
                
                // Here you could send a welcome email if you have email functionality
            } else {
                $message = "Error: " . mysqli_error($connection);
            }
        }
    } else {
        $message = "Please enter a valid email address";
    }
    
    // Redirect back with message
    header("Location: newsletter.php?subscribe_message=" . urlencode($message));
    exit();


    
}