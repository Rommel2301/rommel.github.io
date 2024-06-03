<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

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

    // Masukkan data ke database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil.";
    } else {
        if ($stmt->errno == 1062) { // 1062 adalah kode error untuk pelanggaran UNIQUE
            echo "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            echo "Terjadi kesalahan: " . $stmt->error;
        }
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
    <title>SIGN UP</title>
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
            flex-direction: row-reverse;
            /* Perubahan ini membuat posisi .left-half menjadi di sebelah kanan */
            width: 70%;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1), 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .left-half {
            width: 50%;
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
            background-color: #4caf50;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left-half">
            <img src="daftar1.png" alt="Logo">
            <h2>Selamat Datang!</h2>
            <p>Silakan daftar untuk bergabung.</p>
        </div>
        <div class="right-half">
        <h2 style="text-align: center; color: #333; font-size: 24px; text-transform: uppercase; letter-spacing: 2px;">SIGN UP</h2>
            <form method="POST" action="">
                Username: <input type="text" name="username" required><br>
                Email: <input type="email" name="email" required><br>
                Password: <input type="password" name="password" required><br>
                <button type="submit">Daftar</button>
                <p style="text-align: center; margin-top: 50px;">Sudah punya akun? <a href="login.php">SIGN UP</a></p>
            </form>
        </div>
    </div>
</body>

</html>