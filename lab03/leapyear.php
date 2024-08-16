<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab03 Task 2 - Leap Year</h1>
    <hr>
    <?php
    function is_leapyear($year)
    {
        if ($year % 400 == 0) { // it is divisible by 400
            return true;
        } else if ($year % 100 == 0) { // it is not a leap year
            return false;
        } else if ($year % 4 == 0) { // it is a leap year
            return true;
        } else {
            return false; // if no conditions met, it is not a leap year
        }
    }
    if (isset($_GET["year"])) {
        $year = $_GET["year"];
        // verifies if it is numeric, a positive number and round is an integer 
        if (is_numeric($year) && $year > 0 && $year == round($year)) { 
            is_leapyear($year)
                ? print("<p>The year you entered $year is a leap year.</p>")
                : print("<p>The year you entered $year is not a leap year.</p>");
        } else {
            echo "<p>Please enter a positive integer.</p>";
        }
    } else {
        echo "<p>Please enter a year.</p>";
    }
    ?>
</body>

</html>