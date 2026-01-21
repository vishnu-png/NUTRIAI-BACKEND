<?php
include 'config.php';

// Standardize response to JSON
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    // Get JSON body if sent as JSON, or POST vars if sent as Form
    $input = json_decode(file_get_contents('php://input'), true);
    
    $email = $input['email'] ?? $_POST['email'] ?? '';
    $otp = $input['otp'] ?? $_POST['otp'] ?? '';

    if(empty($email) || empty($otp)){
        echo json_encode(["status" => "failed", "message" => "Missing email or OTP"]);
        exit();
    }

    $subject = "Your NutriAI Verification Code";
    
    // HTML Email Content
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: NutriAI <no-reply@nutriai.com>" . "\r\n";

    $message = '
    <div style="font-family: sans-serif; max-width: 500px; margin: auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background-color: #fff;">
        <div style="background-color: #00A67E; padding: 20px; color: white;">
            <h2 style="margin: 0;">NutriAI</h2>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Verify your email</p>
        </div>
        <div style="padding: 20px;">
            <h3 style="margin-top: 0; color: #333;">Hi User,</h3>
            <p style="color: #555; line-height: 1.5;">Use the one-time password (OTP) below to continue.</p>
            
            <div style="background-color: #1F2937; color: white; padding: 20px; text-align: center; font-size: 32px; font-weight: bold; border-radius: 8px; letter-spacing: 5px; margin: 30px 0;">
                ' . htmlspecialchars($otp) . '
            </div>
            
            <p style="color: #999; font-size: 14px; text-align: center;">Expires in 10 minutes</p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="color: #aaa; font-size: 12px; text-align: center;">Sent by NutriAI Prediction App</p>
        </div>
    </div>';

    // Send Email
    if(mail($email, $subject, $message, $headers)){
        echo json_encode(["status" => "success", "message" => "OTP sent successfully"]);
    } else {
        // Fallback for local XAMPP without SMTP configured
        // In production, this should return failed, but for local testing ease we might pretend?
        // No, user specifically asked for "no errors" on server.
        // On a real server, mail() works. On XAMPP, it fails without config.
        echo json_encode(["status" => "failed", "message" => "Server failed to send email. Check SMTP settings."]);
    }

} else {
    echo json_encode(["status" => "failed", "message" => "Invalid Request Method"]);
}
?>
