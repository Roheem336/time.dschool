<?php
include 'auth.php';
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link rel="stylesheet" href="css/frontpage.css?v=3">
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
    <div>
        <div class="welcome">
            <h1 class="w">welcome</h1>
            <h1 class="welcome">Student : <?= $_SESSION['user']['fullname'] ?></h1>
        </div>
        <div>
            <form method="post">
                <button class="btna" name="checkin">ลงชื่อเข้าเรียน</button> 
            </form>
        </div>
        <div>
            <form method="post">
                <button class="btna" name="checkout">ลงชื่อออกเรียน</button>
            </form>
        </div>
        <div>
            <a class="btns" href="history.php">ดูประวัติย้อนหลัง</a></button>
        </div>
        <div>
            <a class="btns" href="logout.php">ออกจากระบบ</a></button>
        </div>

    </div>
<?php
    if ($_SESSION['user']['role'] !== 'student') header("Location: dashboard.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user']['id'];

    if (isset($_POST['checkin'])) {
        $stmt = $conn->prepare("INSERT INTO attendance (user_id, check_in) VALUES (?, NOW())");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire({
                        icon: "success",
                        title: "ลงชื่อเข้าเรียนเรียบร้อยแล้ว",
                        text: "คลิก OK เพื่อไปหน้าหลัก",
                        confirmButtonText: "ไปหน้าหลัก"
                        }).then(() => {
                         window.location.href = "student.php";
                        });
                    </script>
                  ';
    }

    if (isset($_POST['checkout'])) {
        $stmt = $conn->prepare("UPDATE attendance SET check_out = NOW() WHERE user_id = ? AND check_out IS NULL ORDER BY check_in DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire({
                        icon: "success",
                        title: "ลงชื่อออกเรียนเรียบร้อยแล้ว",
                        text: "คลิก OK เพื่อไปหน้าหลัก",
                        confirmButtonText: "ไปหน้าหลัก"
                        }).then(() => {
                         window.location.href = "student.php";
                        });
                    </script>
                  ';
    }
}
?>
</body>
</html>
