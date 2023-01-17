<?php session_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once "Functions.php";
include_once "EntityClassLib.php";

//extract($_POST);

//Post Variables

$name = $_POST["name"];
$studentId = $_POST["studentId"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$passwordConfirm = $_POST["passwordConfirm"];

$_SESSION["name"] = "";
$_SESSION["studentId"] = "";
$_SESSION["phone"] = "";
$_SESSION["password"] = "";
$_SESSION["passwordConfirm"] = "";

//Error Messages
$nameErr = "";
$studentIdErr = "";
$phoneErr = "";
$passwordErr = "";
$passwordConfirmErr = "";
$existErr = "";

//Validate Functions

function ValidateStudentId($studentId): string
{
    $pdo = getPDO();
    $sql = "SELECT COUNT(*) FROM Student WHERE StudentId = '$studentId'";
    $resultSet = $pdo->query($sql);
    $count = $resultSet->fetchColumn();
    if (empty(trim($studentId))) {
        $studentIdErr = "The Student Id cannot be blank";
    } else if ($count > 0) {
        $studentIdErr = "A student with this Id already exists";
    } else {
        $studentIdErr = "";
    }
    return $studentIdErr;
}

function ValidateName($name): string
{
    if (empty(trim($name))) {
        $nameErr = "The name cannot be blank";
    } else {
        $nameErr = "";
    }
    return $nameErr;
}

function ValidatePhone($phone): string
{
    $regex = "/^([2-9]\d{2})-([2-9]{3})-(\d{4})$/";
    if (empty(trim($phone))) {
        $phoneErr = "Phone cannot be blank";
    } else if (!preg_match ($regex, $phone)) {
        $phoneErr = "Phone format must be (xxx-xxx-xxxx)";
    } else {
        $phoneErr = "";
    }
    return $phoneErr;
}

function ValidatePassword($password): string
{
    $regex = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/";
    if (empty(trim($password))) {
        $passwordErr = "Password cannot be blank";
    } else if (!preg_match ($regex, $password)) {
        $passwordErr = "Password format must be at least 6 characters long, contains at least one uppercase, one lowercase and one digit";
    } else {
        $passwordErr = "";
    }
    return $passwordErr;
}

function ValidatePasswordConfirm($password, $passwordConfirm): string
{
    if (empty(trim($passwordConfirm))) {
        $passwordConfirmErr = "Password confirmation cannot be blank";
    } else if ($password != $passwordConfirm) {
        $passwordConfirmErr = "Password confirmation does not match";
    } else {
        $passwordConfirmErr = "";
    }
    return $passwordConfirmErr;
}

//Validation set to false
$registrationValidation = false;
if(isset($_POST["btnSubmit"])) {
    //Validate error messages by validate functions
    $nameErr = ValidateName($name);
    $studentIdErr = ValidateStudentId($studentId);
    $phoneErr = ValidatePhone($phone);
    $passwordErr = ValidatePassword($password);
    $passwordConfirmErr = ValidatePasswordConfirm($password, $passwordConfirm);
    //Insert error messages in array.
    $array = [$nameErr, $studentIdErr, $existErr, $phoneErr, $passwordErr, $passwordConfirmErr];
    //If array contains all the same values which is an empty string, return true if not return false.
    if (count(array_unique($array)) == 1) {
        $registrationValidation = true;
        try {
            addNewStudent($studentId, $name, $phone, $password);
            $student = getStudentByIdAndPassword($studentId, $password);
            $_SESSION['student'] = $student;
            $_SESSION["studentId"] = $studentId;
            header("Location: CourseSelection.php");
            exit();
        }
        catch (Exception $e)
        {
            die("The system is currently not available, try again later");
        }
    }
    //Store post values in session
    $_SESSION["name"] = $name;
    $_SESSION["studentId"] = $studentId;
    $_SESSION["phone"] = $phone;
    $_SESSION["password"] = $password;
    $_SESSION["passwordConfirm"] = $passwordConfirm;
}
$_SESSION["registrationValidation"] = $registrationValidation;

//If reset button is pressed.
if(isset($btnClear)) {
    //Destroy and reset all session variables
    session_reset();
    session_destroy();
    //unset all post values
    unset($_POST);
    //Refresh to the page itself
    header("Location: NewUser.php");
}

//Declare action so post submits to itself, using htmlspecialchars to prevent injection attacks
$action = htmlspecialchars($_SERVER["PHP_SELF"]);

include("./common/header.php");
echo <<<EOT
<body>
<form method = "post" action = "$action">
<div class="form-group row">
<h2 class="col-sm-6 offset-md-1 mt-3 pb-3">Sign Up</h2>
<p class="col-sm-6 offset-md-1">All fields are required.</p>
</div>
  <div class="form-group row">
    <div class="col-sm-5 offset-md-1">
      <hr>
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-2 offset-md-1 col-form-label fw-bold" for="studentId">Student Id:</label>
    <div class="col-sm-2">
    <input type="text" class="form-control" id="studentId" name="studentId" value="{$_SESSION["studentId"]}">
    </div>
    <label class="col-sm-3 col-form-label fw-bold text-danger" for="studentId">$studentIdErr</label>
  </div>
<div class="form-group row mb-3">
    <label class="col-sm-2 offset-md-1 col-form-label fw-bold" for="name">Name:</label>
    <div class="col-sm-2">
    <input type="text" class="form-control" id="name" name="name" value="{$_SESSION["name"]}">
    </div>
    <label class="col-sm-2 col-form-label fw-bold text-danger" for="name">$nameErr</label>
  </div>
    <div class="form-group row mb-3">
    <label class="col-sm-2 offset-md-1 col-form-label fw-bold" for="phone">Phone Number:</label>
      <div class="col-sm-2">
    <input type="text" class="form-control" id="phone" name="phone" placeholder="xxx-xxx-xxxx" value="{$_SESSION["phone"]}">
      </div>
      <label class="col-sm-4 col-form-label fw-bold text-danger" for="phone">$phoneErr</label>
    </div>
  <div class="form-group row mb-3">
    <label class="col-sm-2 offset-md-1 col-form-label fw-bold" for="password">Password:</label>
    <div class="col-sm-2">
    <input type="password" class="form-control" id="password" name="password" value="{$_SESSION["password"]}">
    </div>
    <label class="col-sm-4 col-form-label fw-bold text-danger" for="password">$passwordErr</label>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 offset-md-1 col-form-label fw-bold" for="passwordConfirm">Password Confirmation:</label>
    <div class="col-sm-2">
    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" value="{$_SESSION["passwordConfirm"]}">
    </div>
    <label class="col-sm-4 col-form-label fw-bold text-danger" for="passwordConfirm">$passwordConfirmErr</label>
  </div>
  <div class="form-group row">
    <div class="col-sm-5 offset-md-1">
      <hr>
    </div>
  </div>
    <div class="form-group row">
      <div class="col-sm-6 offset-md-1">
        <button type="submit" class="btn btn-primary mt-3" name="btnSubmit">Submit</button>
        <button type="submit" class="btn btn-primary mt-3" name="btnClear">Clear</button>
      </div>
    </div>
</form>
</body>
EOT;

include('./common/footer.php'); ?>
