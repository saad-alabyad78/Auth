<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        .otp {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your One-Time Password (OTP)</h2>
        <p class="otp">{{ $otp_code }}</p>
        <p>{{ $m }}</p>
        <p>If you didn't request this OTP, please ignore this email.</p>
    </div>
    <div class="footer">
        Sent with ❤️ from YourApp
    </div>
</body>
</html>
