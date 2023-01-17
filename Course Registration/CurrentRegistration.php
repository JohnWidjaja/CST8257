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
$semesterTerms = array();
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
<thead class='table-dark'>
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
$courses = getAllCourses($studentId);
foreach ($courses as $course) {
    $semesterTerms[$course->SemesterCode][] = $course;
}
foreach ($semesterTerms as $semesterCourses)
{
    $totalWeeklyHours = 0;
    foreach ($semesterCourses as $semesterCourse)
    {
        echo "<tr>";
        echo "<td>$semesterCourse->Year</td>";
        echo "<td>$semesterCourse->Term</td>";
        echo "<td>$semesterCourse->CourseCode</td>";
        echo "<td>$semesterCourse->Title</td>";
        echo "<td></td>";
        echo "<td>$semesterCourse->WeeklyHours</td>";
        echo "<td><input type='checkbox' name='registerCourses[]' value='$semesterCourse->CourseCode'/></td>";
        echo "</tr>";
        $totalWeeklyHours += $semesterCourse->WeeklyHours;
    }
    echo "<tr>";
    echo "<td class='table-secondary'></td>";
    echo "<td class='table-secondary'></td>";
    echo "<td class='table-secondary'></td>";
    echo "<td class='table-secondary'></td>";
    echo "<th class='table-secondary'>Total Weekly Hours:</th>";
    echo "<td class='table-secondary'><b>$totalWeeklyHours</b></td>";
    echo "<td class='table-secondary'></td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";
if ($semesterTerms != null)
{
    echo "<button type='submit' class='offset-sm-10 btn btn-danger mt-2 me-2 mb-3' name='btnDelete' onclick=\"return confirm('The selected course registrations will be deleted!');\">Delete</button>";
    echo "<button type='reset' class='btn btn-primary mt-2 mb-3' name='btnClear'>Clear</button>";
}
else
{
    echo "<p class='text-center'><b>You currently are not registered in any courses</b></p>";
}
echo "</form>";
include("./common/footer.php");
?>


