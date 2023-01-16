<?php
include_once 'Functions.php';
include_once 'EntityClassLib.php';
session_start();

if (!isset($_SESSION['student']))
{
    header("Location: Login.php");
    exit();
}
include("./common/header.php");
$student = $_SESSION['student'];
echo "<h2 class='text-center pt-4 pb-4'>Welcome ".$student->getName()."</h2>";
?>
<div class="container text-center">
    <p>Welcome to the Algonquin's registration portal where you can choose up to <b>57</b> courses over <b>9</b> semesters. Click <a href="CourseSelection.php" class="text-decoration-none">here</a> to start.</p>
<p>Want to make a new account? You can <a href="NewUser.php" class="text-decoration-none">sign up</a>.</p>
<p>Want to logout? You can <a href="Login.php" class="text-decoration-none">here</a>.</p>
</div>
<?php include('./common/footer.php'); ?>
