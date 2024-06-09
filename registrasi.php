<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Password and Confirm Password do not match!";
    } else {
        // Check if username already exists
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $error = "Username already taken!";
        } else {
            // Insert new user into database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                header('Location: login.php');
                exit;
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:ital,wght@0,500;0,600;0,700;1,400&family=Roboto:wght@400;500;700&display=swap');
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Roboto", sans-serif;
            background: #F4F4F9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #8e2de2, #4a00e0);
        }
        .register-container {
            width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .register-container h2 {
            margin-bottom: 30px;
            color: #4a00e0;
        }
        .input-control {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            cursor: pointer;
            background: #4a00e0;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        button:hover {
            background: #6a00e0;
        }
        .footer {
            margin-top: 20px;
        }
        .footer a {
            color: #4a00e0;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="username" class="input-control" placeholder="Username" required>
            <input type="password" name="password" class="input-control" placeholder="Password" required>
            <input type="password" name="confirm_password" class="input-control" placeholder="Konfirmasi Password" required>
            <button type="submit">Register</button>
        </form>
        <div class="footer">
            <p>Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
