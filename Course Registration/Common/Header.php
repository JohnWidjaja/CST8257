<!DOCTYPE html>
<html lang="en" style="position: relative; min-height: 100%;">
<head>
	<title>Online Course Registration</title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body style="margin-bottom: 60px;">
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://www.algonquincollege.com">
            <img src="Common/img/AC.png "
                 alt="Algonquin College" width="33" height="30"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                    if (!isset($_SESSION['student']))
                    {
                        echo '<a class="nav-link" aria-current="page" href="Index.php">Home</a></li>';
                    }
                    else
                    {
                        echo '<a class="nav-link" aria-current="page" href="Welcome.php">Home</a></li>';
                    }
                    ?>
                </li>
                <li class="nav-item">
                <li><a class="nav-link" aria-current="page" href="CourseSelection.php">Course Selection</a></li>
                </li>
                <li class="nav-item">
                <li><a class="nav-link" aria-current="page" href="CurrentRegistration.php">Current Registration</a></li>
                </li>
                <li class="nav-item">
                    <?php
                    if (!isset($_SESSION['student']))
                    {
                        echo '<a class="nav-link" aria-current="page" href="Login.php">Log In</a></li>';
                    }
                    else
                    {
                        echo '<a class="nav-link" aria-current="page" href="Logout.php">Log Out</a></li>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
