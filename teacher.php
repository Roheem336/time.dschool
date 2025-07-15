<?php
include 'auth.php';
include 'db.php';

if ($_SESSION['user']['role'] !== 'teacher') {
    header("Location: dashboard.php");
    exit();
}

$classroom_id = $_SESSION['user']['classroom_id'];

$stmt = $conn->prepare("
    SELECT u.fullname, a.check_in, a.check_out 
    FROM attendance a 
    JOIN users u ON a.user_id = u.id 
    WHERE u.classroom_id = ?
    ORDER BY a.check_in DESC
");
$stmt->bind_param("i", $classroom_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css?=v4">
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
<h1 style="text-align: center;">รายงานการเข้าเรียน - ห้องที่คุณดูแล</h1>
<table border="1">
    <tr>
        <th>ชื่อ</th>
        <th>เข้า</th>
        <th>ออก</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['fullname'] ?></td>
        <td><?= $row['check_in'] ?></td>
        <td><?= $row['check_out'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="logout.php">ออกจากระบบ</a>

<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        window.location.href = 'teacher.php'; // หรือหน้าอื่นตามต้องการ
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
