<?php
// Define variables and set to empty values
$nameErr = $emailErr = $messageErr = "";
$name = $email = $message = "";

// Function to sanitize input data
function sanitize_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// If the form is submitted, process the data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate name input
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = sanitize_input($_POST["name"]);
    // Check if name contains only letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  // Validate email input
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = sanitize_input($_POST["email"]);
    // Check if email address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  // Validate message input
  if (empty($_POST["message"])) {
    $messageErr = "Message is required";
  } else {
    $message = sanitize_input($_POST["message"]);
  }

  // If no errors were found, send the email
  if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
    $to = "your-email@example.com"; // Set the recipient email address here
    $subject = "New Contact Form Submission";
    $headers = "From: $email";
    $email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nMessage:\n$message";
    
    // Send the email
    mail($to, $subject, $email_body, $headers);
    
    // Redirect to a thank-you page
    header("Location: thank-you.html");
    exit();
  }
}
?>
