<?php
include 'auth.php';
include 'db.php';

if ($_SESSION['user']['role'] !== 'student') {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("
    SELECT check_in, check_out 
    FROM attendance 
    WHERE user_id = ? 
    ORDER BY check_in DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css?=v3">
    <title>history</title>
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
    <div class="history">
        <h1>ประวัติย้อนหลังของคุณ<br> <?= $_SESSION['user']['fullname'] ?></h1>
    </div>
    <div class="table">
        <table border="1">
            <tr>
                <th>เวลาเข้า</th>
                <th>เวลาออก</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['check_in'] ?></td>
                <td><?= $row['check_out'] ?? '-' ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div>
        <a href="student.php">← ย้อนกลับ</a>  
    </div>
</div>
<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        window.location.href = 'history.php'; // หรือหน้าอื่นตามต้องการ
    };
</script>
<script>
    // ล้าง forward history
    window.history.pushState(null, null, window.location.href);
    window.addEventListener('popstate', function () {
        window.history.pushState(null, null, window.location.href);
    });
</script>
</body>
</html>
