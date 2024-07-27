<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RC syrian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h3 {
            color: #333;
            text-align: center;
        }
        p {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h3>Welcome to Our application</h3>
        <p>
            Dear,<br>
            {{ $data['body'] }}
        </p>
        <p>
            The RC syrian Team
        </p>
    </div>
</body>
</html>