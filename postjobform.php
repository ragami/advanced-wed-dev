<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Advanced Web Development" />
    <title>Assignment 1</title>
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a class="active" href="postjobform.php">Post Job</a></li>
            <li><a href="searchjobform.php">Job Search</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="banner">
            <h1>Job Vacancy Posting System</h1>
        </div>
        <form action="postjobprocess.php" method="post">
            <div>
                <!-- Position -->
                <label for="id">Position ID:</label>
                <input type="text" id="id" name="id" placeholder="e.g. ID001"><br>

                <!-- title  -->
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Enter Title Here"><br>

                <!-- description -->
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" cols="30" placeholder="Enter Description Here"></textarea><br>
                </div>

                <!-- Closing Date -->
                <label for="closing_date">Closing Date:</label>
                <input type="text" id="closing_date" name="closing_date" value="<?php echo date('d/m/Y') ?>">
            </div>

            <!-- Position -->
            <label>Position:</label>
            <input type="radio" id="position" name="position" value="full">
            <label for="part">Full Time</label>
            <input type="radio" id="position" name="position" value="part">
            <label for="part">Part Time</label>

            <!-- Contract  -->
            <p>Contract:
                <input type="radio" id="contract" name="contract" value="on_going">
                <label for="on_going">On-going</label>
                <input type="radio" id="contract" name="contract" value="fixed">
                <label for="fixed">Fixed Term</label>
            </p>

            <!-- location -->
            <p>Location:
                <input type="radio" id="location" name="location" value="on_site">
                <label for="on_site">On site</label>
                <input type="radio" id="location" name="location" value="remote">
                <label for="remote">Remote</label>
            </p>

            <!-- Application type -->
            <p>Application by:
                <input type="checkbox" id="type1" name="type1" value="post">
                <label for="post">Post </label>
                <input type="checkbox" id="type2" name="type2" value="mail">
                <label for="mail">Mail</label>
            </p>

            <!-- submit, reset  -->
            <input type="submit" value="Post">
            <input type="reset" value="Reset">

            <!-- link to return to homepage (index.html) -->
            <p>All fields are required. <a href="index.php">Return to Home Page</a></p>
        </form>
    </div>

</body>

</html>
