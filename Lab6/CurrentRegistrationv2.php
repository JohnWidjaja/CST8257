<?php
include_once 'Functions.php';
include_once 'EntityClassLib.php';
session_start();
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SESSION['student']))
{
    header("Location: Login.php");
    exit();
}
include("./common/header.php");
//Dropdown list selected variables
$errMessage = "";
$totalWeeklyHours22F = 0;
$totalWeeklyHours22W = 0;
$totalWeeklyHours22S = 0;
$totalWeeklyHours23F = 0;
$totalWeeklyHours23W = 0;
$totalWeeklyHours23S = 0;
$totalWeeklyHours24F = 0;
$totalWeeklyHours24W = 0;
$totalWeeklyHours24S = 0;
$action = htmlspecialchars($_SERVER["PHP_SELF"]);
$student = $_SESSION['student'];
$studentId = $_SESSION["studentId"];

//Delete selected courses
if (isset($_POST["btnDelete"]))
{
    if (isset($_POST["registerCourses"]))
    {
        $registerCourses = $_POST["registerCourses"];
        foreach ($registerCourses as $registerCourse)
        {
            deleteCourses($studentId, $registerCourse);
        }
    }
    else
    {
        $errMessage = "You must select at least one course to delete!";
    }
}
echo "<h2 class='text-center pt-4 pb-4'>Current Registrations</h2>";
echo "<p class='offset-sm-1'>Hello <b>".$student->getName()."</b>! (Not you? You can change your user <a href='Logout.php' class='text-decoration-none'>here</a>), the following are your current course registrations.</p>";
echo '<label class="offset-sm-1 fw-bold text-danger">',$errMessage,'</label>';
echo <<<EOT
<form method = "post" action = $action>
<div class='container mb-4'>
<table class='table'>
<thead class='thead-dark'>
<tr>
<th scope='col'>Year</th>
<th scope='col'>Term</th>
<th scope='col'>Code</th>
<th scope='col'>Course Title</th>
<th scope='col'></th>
<th scope='col'>Hours</th>
<th scope='col'>Select</th>
</tr>
</thead>
EOT;
//$courses = getAllCourses($studentId);
$courses22F = getAllCourses22F($studentId);
$courses22W = getAllCourses22W($studentId);
$courses22S = getAllCourses22S($studentId);
$courses23F = getAllCourses23F($studentId);
$courses23W = getAllCourses23W($studentId);
$courses23S = getAllCourses23W($studentId);
$courses24F = getAllCourses24F($studentId);
$courses24W = getAllCourses24W($studentId);
$courses24S = getAllCourses24S($studentId);

if ($courses22F != null)
{
    foreach ($courses22F as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours22F += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours22F</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
if ($courses22W != null)
{
    foreach ($courses22W as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours22W += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours22W</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
if ($courses22S != null)
{
    foreach ($courses22S as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours22S += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours22S</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
if ($courses23F != null)
{
    foreach ($courses23F as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours23F += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours23F</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
if ($courses23W != null)
{
    foreach ($courses23W as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours23W += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours23W</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
if ($courses23S != null)
{
    foreach ($courses23S as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours23S += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours23S</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
if ($courses24F != null)
{
    foreach ($courses24F as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours24F += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours24F</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
if ($courses24W != null)
{
    foreach ($courses24W as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours24W += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours24W</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
if ($courses24S != null)
{
    foreach ($courses24S as $course)
    {
        echo "<tr>";
        echo "<td>$course->Year</td>";
        echo "<td>$course->Term</td>";
        echo "<td>$course->CourseCode</td>";
        echo "<td>$course->Title</td>";
        echo "<td></td>";
        echo "<td>$course->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours24S += $course->WeeklyHours;
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>Total Weekly Hours:</b></td>";
    echo "<td><b>$totalWeeklyHours24S</b></td>";
    echo "<td></td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";
echo "<button type='submit' class='offset-sm-10 btn btn-primary mt-3 me-2' name='btnDelete' onclick=\"return confirm('The selected course registrations will be deleted!');\">Delete</button>";
echo "<button type='reset' class='btn btn-primary mt-3' name='btnClear'>Clear</button>";
echo "</form>";
?>


