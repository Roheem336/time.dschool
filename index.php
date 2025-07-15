<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($_POST['password']== $user['password']) {
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/frontpage.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>
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

<div class="box"></div>
    <div class="wrapper">
        <form method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class=""></i> <!--bx bxs-user-->
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class=""></i> <!--bx bxs-lock-alt-->
            </div>
            <div class="remember-forgot">
                <label for="">
                    <input type="checkbox">
                    Remamber me
                </label>
                <a href="forgot_password.php">Forgot password?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>
                    Don't have an account.
                    <a href="signup.php">Register</a>
                </p>
            </div>
        </form>
    </div>

    <script>
    // ล้างประวัติเดิม
    history.replaceState(null, null, location.href);
    history.pushState(null, null, location.href);

    window.addEventListener('popstate', function () {
        history.pushState(null, null, location.href);
    });
</script>

</body>
</html>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
