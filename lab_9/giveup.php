<?php
    session_start();
    $num = $_SESSION["guessNumber"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lorraine</title>
</head>
<body>
    <h1>Guessing Game</h1>
    <p>The hidden number was: <?php echo $num ?></p>
    <a href="startover.php">Start Over</a>
</body>
</html>