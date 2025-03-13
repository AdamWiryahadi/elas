<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            max-width: 600px;
        }

        h1 {
            font-size: 100px;
            font-weight: bold;
            color: #ff4c4c;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        p {
            font-size: 18px;
            color: #555;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff4c4c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        a:hover {
            background-color: #d84343;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <p>Access Denied! You don't have permission to view this page.</p>
        <a href="/">Go Back Home</a>
    </div>
</body>
</html>
