<?php
session_start();
if (!isset($_SESSION['user'])) header("Location: index.php");

$role = $_SESSION['user']['role'];
header("Location: " . ($role === 'teacher' ? 'teacher.php' : 'student.php'));

