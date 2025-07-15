<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $classroom_id = $_POST['classroom_id'];

    $stmt = $conn->prepare("INSERT INTO users (fullname, username, password, role, classroom_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $fullname, $username, $password, $role, $classroom_id);

    if ($stmt->execute()) {
        echo "สมัครสมาชิกเรียบร้อย <a href='index.php'>เข้าสู่ระบบ</a>";
    } else {
        echo "สมัครไม่สำเร็จ: อาจมีชื่อผู้ใช้นี้แล้ว";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/frontpage.css">
    <title>Sign Up</title>
    <style>
    body {
      opacity: 0;
      animation: fadeIn 1s forwards;
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }
    </style>
</head>
<body>
    <div class="wrapper">
        <form method="post">
            <h1>Sign Up</h1>
            <div class="input-box">
                <input type="text" name="fullname" placeholder="Fullname" required>
                <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class="bx bxs-user"></i> 
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class="bx bxs-lock-alt"></i>
            </div>
            <div>
                <select name="role" required>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>
            <div class="input-box">
                <input type="number" name="classroom_id" placeholder="Class ID (1,2,3...)" required>
            </div>
            <button class="btn" type="submit">Sign Up</button>
            <div class="register-link">
                <p>
                    Already have an account?
                    <a href="index.php">Login</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
