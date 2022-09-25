<!doctype html>
<html lang="en">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Deposit Calculator</title>
</head>
<body>
<?php
//Declare POST variables from html form.
$principal = $_POST["principalAmount"];
$interest = $_POST["interestRate"];
$years = $_POST["yearsToDeposit"];
$name = $_POST["name"];
$postalCode = $_POST["postalCode"];
$phone = $_POST["phoneNumber"];
$email = $_POST["email"];
$preferredContact = $_POST["contactMethod"];

//Declare empty error message array.
$errArray=[];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!is_numeric($_POST["principalAmount"])) {
        $principalErr = "The principal amount must be numeric and greater than zero.";
        $errArray[] = $principalErr;
        }
    if ($_POST["principalAmount"] <= 0) {
        $principalErrTwo = "The principal amount must be numeric and non-negative.";
        $errArray[] = $principalErrTwo;
    }

    if (!is_numeric($_POST["interestRate"])) {
        $interestErr = "The interest rate must be numeric and greater than zero.";
        $errArray[] = $interestErr;
    }
    if ($_POST["interestRate"] <= 0) {
        $interestErrTwo = "The interest rate must be numeric and non-negative.";
        $errArray[] = $interestErrTwo;
    }
    if (empty(trim($_POST["name"]))) {
        $nameErr = "The name cannot be blank.";
        $errArray[] = $nameErr;
        echo "<h2 class='text-center mt-4'>Thank you for using our deposit calculator, but you didn't enter a name!</h2>";
    } else {
        echo "<h2 class='text-center mt-4'>Thank you, $name, for using our deposit calculator!</h2>";
    }
    if (empty(trim($_POST["postalCode"]))) {
        $postalCodeErr = "The postal code cannot be blank.";
        $errArray[] = $postalCodeErr;
    }
    if (empty(trim($_POST["phoneNumber"]))) {
        $phoneErr = "The phone number cannot be blank.";
        $errArray[] = $phoneErr;
    }
    if (empty(trim($_POST["email"]))) {
        $emailErr = "The email cannot be blank.";
        $errArray[] = $emailErr;
    }
    if ($preferredContact == "phone") {
        if (!isset($_POST["contactTime"])) {
            $preferredErr = "When preferred contact method is phone, you have to select one or more contact items.";
            $errArray[] = $preferredErr;
        }
    }
    //check if validation succeeds or not based on if there is any error messages in the array.
    if (count($errArray) == 0) {
        $formValidation = true;
    } else {
        $formValidation = false;
    }

    echo "<div class='container mt-4 mb-4' style='width: 800px'>";
    if ($formValidation === false) {
        echo "<p>However we cannot process your request because of the following input errors:</p>";
        echo "<ul>";
        foreach ($errArray as $value) {
            echo "<li>$value</li>";
        }
        echo "</ul>";
    }
    if ($formValidation === true) {
        if (isset($_POST["contactMethod"])) {
            $contactMethod = $_POST["contactMethod"];
            if (isset($_POST["contactTime"]) && $contactMethod == "phone") {
                $contactTime= $_POST["contactTime"];
                if (count($contactTime) == 1) {
                    echo "<p>Our customer service department will call you in the $contactTime[0] at $phone.</p>";
                }
                elseif (count($contactTime) == 2) {
                    echo "<p>Our customer service department will call you in the $contactTime[0] and $contactTime[1] at $phone.</p>";
                }
                elseif (count($contactTime) == 3) {
                    echo "<p>Our customer service department will call you in the $contactTime[0], $contactTime[1] and $contactTime[2] at $phone.</p>";
                }
            }
            elseif ($contactMethod == "email") {
                echo "<p>Our customer service department will email you at $email.</p>";
            }
        }
        echo "<p>The following is the result of the calculation:</p>";
        echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
       echo "<th scope='col'>Year</th>
        <th scope='col'>Principal at Year Start</th>
        <th scope='col'>Interest for the Year</th>";
    echo "</tr>";
    echo "</thead>";
        //The interest year value is equal to the principal amount times the interest percentage.
        $interestYear = $principal*($interest/100);
        for ($x = 1; $x <= $years; $x++) {
            $principalNew = number_format($principal, 2, '.', '');
            $interestNew = number_format($interestYear, 2, '.', '');
            echo "<tr>";
            echo "<td>$x</td>
            <td>$$principalNew</td>
            <td>$$interestNew</td>";
            echo "</tr>";
            $principal+=$interestYear;
            $interestYear+=$interestYear*($interest/100);
        }
    echo "</table>";
    }
}
?>
</div>
</body>
</html>
