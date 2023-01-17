<?php
include_once 'EntityClassLib.php';

function getPDO()
{
    $dbConnection = parse_ini_file("DBConnection.ini");
    extract($dbConnection);
    return new PDO($dsn, $scriptUser, $scriptPassword);  
}

function getStudentByIdAndPassword($studentId, $password)
{
    $pdo = getPDO();
    $sql = "SELECT StudentId, Name, Phone, Password FROM Student WHERE StudentId = :studentId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['studentId' => $studentId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $row['Password']))
    {
        return new Student($row['StudentId'], $row['Name'], $row['Phone'] );
    }
    return null;
}

function addNewStudent($studentId, $name, $phone, $password)
{
    $pdo = getPDO();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Student VALUES( :studentId, :name, :phone, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['studentId' => $studentId, 'name' => $name, 'phone' => $phone, 'password' => $hashedPassword]);
}

function getAllSemesters()
{
    $semesters = array();
    $pdo = getPDO();
    $sth = $pdo ->prepare ("SELECT SemesterCode, Term, Year FROM Semester");
    $sth->execute();
    $resultSet = $sth->fetchAll(PDO::FETCH_OBJ);
    return $resultSet;
}

function getAllCourses($studentId)
{
    $pdo = getPDO();
    $sth = $pdo ->prepare ("SELECT Course.CourseCode, Course.Title, Course.WeeklyHours, Semester.SemesterCode, Semester.Year, Semester.Term
                                  FROM Course INNER JOIN Registration ON Course.CourseCode = Registration.CourseCode
                                  INNER JOIN Semester ON Registration.SemesterCode = Semester.SemesterCode
                                  WHERE Registration.StudentId = :studentId
                                  ORDER BY Semester.Year, Semester.SemesterCode");
    $sth->execute(['studentId' => $studentId]);
    $resultSet = $sth->fetchAll(PDO::FETCH_OBJ);
    return $resultSet;
}

function getAllCoursesPerSemester($studentId, $semesterCode)
{
    $pdo = getPDO();
    $sth = $pdo ->prepare ("SELECT Course.CourseCode, Title, WeeklyHours 
                                  FROM Course INNER JOIN CourseOffer ON Course.CourseCode = CourseOffer.CourseCode 
                                  WHERE CourseOffer.SemesterCode = :semesterCode 
                                  AND Course.CourseCode NOT IN (SELECT CourseCode FROM Registration WHERE StudentId = :studentId)");
    $sth->execute(['studentId' => $studentId, 'semesterCode' => $semesterCode]);
    $resultSet = $sth->fetchAll(PDO::FETCH_OBJ);
    return $resultSet;
}

function getTotalHoursPerSemester($studentId, $semesterCode)
{
    $pdo = getPDO();
    $sth = $pdo ->prepare ("SELECT SUM(Course.WeeklyHours) 
                                  FROM Course 
                                  INNER JOIN Registration ON Registration.CourseCode = Course.CourseCode
                                  WHERE Registration.SemesterCode = :semesterCode AND Registration.StudentId = :studentId");
    $sth->execute(['studentId' => $studentId, 'semesterCode' => $semesterCode]);
    $resultSet = $sth->fetch(PDO::FETCH_ASSOC);
    $totalHours = implode("", $resultSet);
    return (int)$totalHours;
}

function addNewCourses($studentId, $registerCourse, $semesterCode)
    {
        $pdo = getPDO();
        $sql = "INSERT INTO Registration VALUES( :studentId, :courseCode, :semesterCode)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['studentId' => $studentId, 'courseCode' => $registerCourse, 'semesterCode' => $semesterCode]);
    }

function deleteCourses($studentId, $registerCourse)
{
    $pdo = getPDO();
    $sql = "DELETE FROM Registration WHERE StudentId = :studentId AND CourseCode = :courseCode";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['studentId' => $studentId, 'courseCode' => $registerCourse]);
}

function getTotalWeeklyHours($registerCourses)
{
    foreach ($registerCourses as $courseCode)
    {
        $pdo = getPDO();
        $sql = "SELECT WeeklyHours FROM Course WHERE CourseCode = :courseCode";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':courseCode' => $courseCode]);
        $totalHours = $stmt->fetch();
        $totalWeeklyHours += $totalHours[0];
    }
    return $totalWeeklyHours;
}
?>


