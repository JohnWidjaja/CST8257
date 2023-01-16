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
include("./common/footer.php");
//Dropdown list selected variables
$semesters = getAllSemesters();
$errMessage = "";
$successMessage = "";
$totalWeeklyHours = 0;
$totalSemesterHours = 0;
$maxWeeklyHours = 16;
$action = htmlspecialchars($_SERVER["PHP_SELF"]);
$student = $_SESSION['student'];
$studentId = $_SESSION["studentId"];

if (isset($_POST["btnClear"]))
{
    unset($_POST["registerCourses"]);
}

if (isset($_POST["btnSubmit"]))
{
    $semesterList = $_SESSION["semesterList"];
    $courses = getAllCoursesPerSemester($studentId, $semesterList);
    if (isset($_POST["registerCourses"]))
    {
        $registerCourses = $_POST["registerCourses"];
        $totalWeeklyHours = getTotalWeeklyHours($registerCourses);
        $totalCurrentSemesterHours = getTotalHoursPerSemester($studentId, $_POST["semesterList"]);
        foreach ($registerCourses as $registerCourse)
        {
            if ($totalWeeklyHours > 16 || $totalWeeklyHours + $totalCurrentSemesterHours > 16)
            {
                $errMessage = "Your selection exceeds the max amount of weekly hours for this semester!";
            }
            else
            {
                addNewCourses($studentId, $registerCourse, $semesterList);
                $successMessage = "Your courses have been registered successfully!";
            }
        }
//        $_SESSION["registerCourses"] = $registerCourses;

    }
    else
    {
        $errMessage = "You must select at least one course!";
    }
}
echo "<h2 class='text-center pt-4 pb-4'>Course Selection</h2>";
echo "<p class='offset-sm-1'>Welcome <b>".$student->getName()."</b>! (Not you? You can change your user <a href='Logout.php' class='text-decoration-none'>here</a>)</p>";
echo "<p class='offset-sm-1'>You have registered <b>",$totalSemesterHours += getTotalHoursPerSemester($studentId, $_POST["semesterList"]),"</b> hours for the selected semester.</p>";
echo "<p class='offset-sm-1'>You can register <b>",$maxWeeklyHours - $totalSemesterHours,"</b> more hours of course(s) for the semester.</p>";
echo <<<EOT
<form method = "post" action = $action>
<p class='offset-sm-1'>Please note that the courses you have registered will not be displayed in a list.</p>
<div class='container mt-4 mb-4'>
<table class='table'>
<thead class='table-dark'>
<tr>
<th scope='col'>Code</th>
<th scope='col'>Course Title</th>
<th scope='col'>Hours</th>
<th scope='col'>Select</th>
</tr>
</thead>
<select name="semesterList" style="width: 250px" onchange="this.form.submit()" class="form-select mb-3">
<option value="-1">Select a semester...</option>
EOT;
    foreach ($semesters as $semester)
    {
        echo "<option value='$semester->SemesterCode'", ($_POST["semesterList"] == $semester->SemesterCode) ? "selected>" : ">",$semester->Term." ".$semester->Year,"</option>";
    }
echo '</select>';
echo '<label class="fw-bold text-danger pb-3">',$errMessage,'</label>';
echo '<label class="fw-bold text-success pb-3">',$successMessage,'</label>';
//echo '<input type="submit" name="btnSemesterSelectionSubmit" id="semesterListBtn" value="Submit" class="d-none"/>';
    if (isset($_POST["semesterList"]) && $_POST["semesterList"] != "-1")
    {
        $_SESSION["totalSemesterHours"] = $totalSemesterHours + getTotalHoursPerSemester($studentId, $_POST["semesterList"]);
        $courses = getAllCoursesPerSemester($studentId, $_POST["semesterList"]);
        foreach ($courses as $course)
        {
            echo "<tr>";
            echo "<td>$course->CourseCode</td>";
            echo "<td>$course->Title</td>";
            echo "<td>$course->WeeklyHours</td>";
            if (isset($_POST["registerCourses"]))
            {
                if (in_array($course->CourseCode,$_POST["registerCourses"]))
                {
                    echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode' checked/></td>";
                }
                else
                {
                    echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
                }
            }
            else
            {
                echo "<td><input type='checkbox' name='registerCourses[]' value='$course->CourseCode'/></td>";
            }
            echo "</tr>";
        }
        $_SESSION["semesterList"] = $_POST["semesterList"];
        echo "</table>";
        echo "</div>";
        echo '<button type="submit" class="offset-sm-10 btn btn-success mt-2 me-2 mb-3" name="btnSubmit">Submit</button>';
        echo '<button type="submit" class="btn btn-primary mt-2 mb-3" name="btnClear">Clear</button>';
        echo "</form>";
    }
?>



