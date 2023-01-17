<?php session_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once "Functions.php";
include_once "EntityClassLib.php";

//extract($_POST);
//Post Variables

$studentId = $_POST["studentId"];
$password = $_POST["password"];

$_SESSION["studentId"] = "";
$_SESSION["password"] = "";

//Error Messages
$studentIdErr = "";
$passwordErr = "";

//Validate Functions

function ValidateStudentId($studentId): string
{
    if (empty(trim($studentId))) {
        $studentIdErr = "The Student Id cannot be blank";
    } else {
        $studentIdErr = "";
    }
    return $studentIdErr;
}

function ValidatePassword($password): string
{
    $regex = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/";
    if (empty(trim($password))) {
        $passwordErr = "Password cannot be blank";
    } else {
        $passwordErr = "";
    }
    return $passwordErr;
}

//Validation set to false
$studentValidation = false;
if(isset($_POST["btnSubmit"])) {
    //Validate error messages by validate functions
    $studentIdErr = ValidateStudentId($studentId);
    $passwordErr = ValidatePassword($password);
    //Insert error messages in array.
    $array = [$studentIdErr, $passwordErr];
    //If array contains all the same values which is an empty string, return true if not return false.
    if (count(array_unique($array)) == 1) {
        $studentValidation = true;
    }
    if ($studentValidation) {
        try {
            $student = getStudentByIdAndPassword($studentId, $password);
        }
        catch (Exception $e)
        {
            die("The system is currently not available, try again later");
        }
        if ($student == null)
        {
            $loginErrorMsg = 'Incorrect Student ID and/or Password Combination!';
        }
        else
        {
            $_SESSION['student'] = $student;
            $_SESSION["studentId"] = $studentId;
            header("Location: Welcome.php");
            exit();
        }
    }
    //Store post values in session
    $_SESSION["studentId"] = $studentId;
    $_SESSION["password"] = $password;
}

$_SESSION["studentValidation"] = $studentValidation;

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
<h2 class="col-sm-6 offset-md-1 mt-3 pb-3">Log In</h2>
<p class="col-sm-6 offset-md-1">You need to <a href="NewUser.php" class="text-decoration-none">sign up</a> if you are a new user.</p>
<label class="col-sm-6 offset-md-1 col-form-label fw-bold text-danger" for="student">$loginErrorMsg</label>
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
    <label class="col-sm-2 col-form-label fw-bold text-danger" for="studentId">$studentIdErr</label>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 offset-md-1 col-form-label fw-bold" for="password">Password:</label>
    <div class="col-sm-2">
    <input type="password" class="form-control" id="password" name="password" value="{$_SESSION["password"]}">
    </div>
    <label class="col-sm-4 col-form-label fw-bold text-danger" for="password">$passwordErr</label>
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

