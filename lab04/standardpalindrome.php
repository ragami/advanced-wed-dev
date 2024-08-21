<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab04 Task 3 - Standard Palindrome</h1>
    <hr>
    <?php
    if (isset($_POST['str']) && !empty($_POST['str'])) { // checks if it is not empty
        $str = $_POST['str'];
        $newstr = "";
        $pattern = "/^[A-Za-z]+$/"; 
        for ($i = 0; $i < strlen($str); $i++) { // tracks current position (index) and returns length of string. $1++ increased by 1 and moves to next character
            $letter = substr($str, $i, 1); // extracts each character one by one
            if (preg_match($pattern, $letter)) { // pattern checks if the character is alphabetic
                $newstr .= $letter; // appended to newstr and is stripped of any spaces, punctuation, etc
            }
        }
        $revstr = strrev($newstr);
        if (strcmp(strtolower($newstr), strtolower($revstr)) === 0) {
            echo "<p>The text you entered '$str' is a standard palindrome!</p>";
        } else {
            echo "<p>The text you entered '$str' is not a standard palindrome.</p>";
        }
    } else {
        echo "<p>Please enter a string.</p>";
    }
    ?>
</body>

</html>