<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Lorraine Becker" />
    <title>Week 5 - Task 2</title>
</head>

<body>
    <h1>Lab05 Task 2 - Guestbook</h1>
    <hr>
    <form action="guestbooksave.php" method="POST">
        <fieldset>
            <legend>Enter your details to sign our guest book</legend>
            <label for="fname">Name</label>
            <input type="text" name="fname" id="fname">
            <br>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
            <br>
            <input type="submit" value="Submit">
        </fieldset>
    </form>
    <a href="guestbookshow.php">View Guest Book</a>
</body>

</html>