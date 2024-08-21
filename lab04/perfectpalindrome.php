<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab04 Task 2 - Perfect Palindrome</h1>
    <hr>
    <?php
    if (isset($_POST['str']) && !empty($_POST['str'])) { // not empty
        $str = $_POST['str'];
        $strrev = strrev($str); // strrev reverses the string 
        // if it returns 0, the strings are identical
        if (strcmp(strtolower($str), strtolower($strrev)) === 0) { // strcmp compares the original and reversed strings
            echo "<p>The text you entered '$str' is a perfect palindrome!</p>";
        } else {
            echo "<p>The text you entered '$str' is not a perfect palindrome.</p>";
        } 
    } else {
        echo "<p>Please enter a string.</p>";
    }
    ?>
</body>

</html>