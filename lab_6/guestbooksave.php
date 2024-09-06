<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Lorraine Becker" />
    <title>Week 5 - Task 1</title>
</head>

<body>
    <h1>Web Programming - Lab 5</h1>
    <hr>
    <?php
    if (isset($_POST["fname"], $_POST["email"])) {
        $fname = trim($_POST["fname"]);
        $email = trim($_POST["email"]);

        // Check if either field is empty
        if (empty($fname) || empty($email)) {
            echo "<p>You must enter your name and email!</p>";
            echo '<p>Use the browser\'s "Go back" button to return to the Guestbook form.</p>';
        } else {
            $fname = addslashes($fname);
            $email = addslashes($email);

            // Directory setup
            $dir = "../../data/lab05/";
            umask(0007);
            if (!is_dir($dir)) {
                mkdir($dir, 02770);
            }

            $filename = "guestbook.txt";
            $handle = fopen($dir . $filename, "a+");

            // Check if the file is writable
            if (!is_writable($dir . $filename)) {
                echo "<p>Cannot write to file</p>";
                echo '<a href="guestbookform.php">Go back</a>';
            } else {
                $data = $fname . " " . $email . "\n";
                if (fwrite($handle, $data) > 0) {
                    echo "Thank you for signing our Guest book";
                } else {
                    echo "Cannot add your name to the Guest book";
                }
            }
            fclose($handle);
        }
    } else {
        echo "<p>You must enter your name and email!</p>";
        echo '<p>Use the browser\'s "Go back" button to return to the Guestbook form.</p>';
    }
    ?>
    <br>
    <a href="guestbookform.php">Add another Visitor</a>
    <br>
    <a href="guestbookshow.php">Show Guest Book</a>
</body>

</html>
