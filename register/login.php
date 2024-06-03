<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Informasi koneksi database
    $db_host = 'localhost';
    $db_user = 'myuser1';
    $db_pass = 'myuser1';
    $db_name = 'pendaftaran';

    // Koneksi ke database
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Periksa koneksi
    if ($mysqli->connect_error) {
        die("Koneksi gagal: " . $mysqli->connect_error);
    }

    // Query untuk mendapatkan pengguna
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    // Verifikasi password
    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        header("Location: rom/index.html");
    } else {
        echo "Login gagal. Username atau password salah.";
    }

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            display: flex;
            flex-direction: row;
            width: 70%;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 10px 10px 10px 10px rgba(0,0,0,0.1), 0px 0px 20px 0px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .left-half {
            width: 50%;
            background-color: #e74c3c;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .left-half img {
            max-width: 80%;
            height: auto;
            max-height: 80%;
            width: auto;
            margin-bottom: 20px;
        }
        .right-half {
            margin-top: 50px;
            width: 50%;
            padding: 110px;
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            background-color: #e74c3c;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: brown
        }
        button a {
        text-decoration: none; /* Remove underline */
        color: inherit; /* Inherit text color */
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-half">
            <img src="daftar1.png" alt="Logo">
            <h2>Selamat Datang di Portfolio Rommel!</h2>
        </div>
        <div class="right-half">
        <h2 style="text-align: center; color: #333; font-size: 24px; text-transform: uppercase; letter-spacing: 4px;">SIGN IN</h2>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit"><a href="profile.php">LOGIN</a></button>
                <p style="text-align: center; margin-top: 50px;">Belum punya akun? <a href="register.php">SIGN UP</a></p>
            </form>
        </div>
    </div>
</body>
</html>


