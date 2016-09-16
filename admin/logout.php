<?
include('inc/application.php');

unset($_SESSION['user']);
$session_id = session_id();
session_destroy();
$mm->Query("DELETE FROM asession WHERE session_id='{$session_id}'");
redirect('/admin/login.php');
?>