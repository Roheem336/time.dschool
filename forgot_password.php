<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/frontpage.css">
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
        <h1>Forgot Password</h1>
        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-box">
            <input type="password" name="new_password" placeholder="New password" required> <!--อาจจะต้องลบ-->
        </div>
        <button type="submit" class="btn">Reset Password</button>
        <div class="register-link">
            <p>
                Remember your password?
                <a href="index.php">Back to Login</a>
            </p>
        </div>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];

    // ตรวจสอบว่าผู้ใช้นี้มีจริงไหม
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // ถ้ามีผู้ใช้นี้ ให้เปลี่ยนรหัสผ่าน
        $stmt->close();

        // *ถ้าอยากเข้ารหัส ให้ใช้ password_hash แทน
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_password, $username);

        if ($stmt->execute()) {
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire({
                        icon: "success",
                        title: "เปลี่ยนรหัสผ่านเรียบร้อย",
                        text: "คลิก OK เพื่อไปหน้า Login",
                        confirmButtonText: "ไปหน้า Login"
                        }).then(() => {
                         window.location.href = "index.php";
                        });
                    </script>
                  ';
        } else {
            $message = "<p style='color:red;'>เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน</p>";
        }
    } else {
        $message = "<p style='color:red;'>ไม่พบชื่อผู้ใช้นี้ในระบบ</p>";
    }
}
?>
</body>
</html>
