<?php
session_start();
unset($_SESSION['github_data']);
unset($_SESSION['data']);
header("Location: index.php");
?>