<?php
session_start(); // start the session
if (!isset($_SESSION["guessNumber"])) { // check if session variable exists
    $_SESSION["guessNumber"] = rand(1, 100); // create the session variable
    $_SESSION["attempt"] = 0;
}
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["guessInput"])) {
        $guessNumber = $_SESSION["guessNumber"]; // copy the value to a variable
        $guessInput = $_POST["guessInput"];
        if (is_numeric($guessInput) && 1 <= $guessInput && $guessInput <= 100) {
            if ($guessInput > $guessNumber) {
                $message = "Your number is higher than the hidden number";
                $_SESSION["attempt"]++;
            } else if ($guessInput < $guessNumber) {
                $message = "Your number is lower than the hidden number";
                $_SESSION["attempt"]++;
            } else {
                $message = "Congratulations! You guessed the hidden number!";
                $_SESSION["attempt"]++;
            }
        } else {
            $message = "Number must between 1 and 100";
        }
    } 
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Lorraine Becker" />
    <title>Number</title>
</head>

<body>
    <h1>Guessing Game</h1>
    <form method="POST" action="guessinggame.php">
        <label for="guessInput">Enter a number between 1 and 100, <br> then press the Guess button.</label><br>
        <input type="text" name="guessInput" />
        <input type="submit" value="Guess" />
    </form>
    <?php
    echo $message; // displays the number
    echo "<br/>";
    echo "Number of guesses " . $_SESSION["attempt"];
    ?>
    <p><a href="giveup.php">Give Up</a></p>
    <p><a href="startover.php">Start Over</a></p>
</body>

</html>