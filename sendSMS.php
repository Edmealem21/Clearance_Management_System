<?php
// Required if your environment does not handle autoloading
require 'twilio-php-main\src\Twilio\autoload.php';

// Function to send SMS
function sendSMS($id_number, $reason) {
    // Create Twilio client using environment variables for security
    $sid = getenv('TWILIO_ACCOUNT_SID');
    $token = getenv('TWILIO_AUTH_TOKEN');

    // The number you'd like to send the message to
    $to = '+251955179813'; // Correctly formatted recipient phone number

    $client = new Twilio\Rest\Client($sid, $token);

    // Customize the message based on the form submission data
    $message_body = "I am a student ID no $id_number. I want checked for clearance in the reason of $reason";

    try {
        // Send SMS
        $message = $client->messages->create(
            $to,
            [
                // A Twilio phone number you purchased at https://console.twilio.com
                'from' => '+14012648047',
                // The body of the text message you'd like to send
                'body' => $message_body
            ]
        );
    } catch (Exception $e) {
        // Log error or display an error message
        echo 'Error: ' . $e->getMessage();
    }
}

// Fetch the student ID number and reason for clearance from the form submission
if(isset($_POST['matric_no']) && isset($_POST['reason'])) {
    $id_number = $_POST['matric_no']; // Assigned to $id_number
    $reason = $_POST['reason']; 
    
    // Call the function using the correct variable name
    sendSMS($id_number, $reason);
} else {
    // Handle missing form data
    echo 'Error: Missing form data';
}

// Redirect to index.php
header("Location: index.php");
exit(); // Stop execution after redirect
?>