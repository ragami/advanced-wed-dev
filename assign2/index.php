<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Friends System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navigation">
        <h1>My Friends System </h1>
        <ul class="nav">
            <li class="nav-link"><a href="index.php">Home</a></li>
            <li class="nav-link"><a href="signup.php">Sign Up</a></li>
            <li class="nav-link"><a href="login.php">Login</a></li>
            <li class="nav-link"><a href="about.php">About</a></li>
        </ul>
    </div>

    <div class="body">
        <h1>Home Page</h1>
        <p>Name: Lorraine Becker</p>
        <p>Student ID: 104584773</p>
        <p>Email: <a class="email" href="mailto:104584773@student.swin.edu.au">104584773@student.swin.edu.au</a></p>
        <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student’s work or from any other source.</p>
    </div>

    <div class="database">
        <h2>Status Messages</h2>
        <?php
            require_once("setup.php");
            // Establishing connection
            $connection = @mysqli_connect($host, $user, $pass, $db);
            if (!$connection) { // No connection
                echo "<p>Database connection failure</p>";
                echo "<p>Error: " . mysqli_connect_error() . "</p>";
                exit;
            } else {
                // Connection successful
                echo "<p>Database connection successful</p>";
            }

            $friends = "friends";  // Ensure these variables are defined
            $myfriends = "myfriends";

            // Create friends table
            $sqlFriends = "CREATE TABLE IF NOT EXISTS $friends (
                friend_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                friend_email VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(20) NOT NULL,
                profile_name VARCHAR(30) NOT NULL,
                date_started DATE NOT NULL,
                num_of_friends INT UNSIGNED
            )";

            // Query execution for friends table
            if (mysqli_query($connection, $sqlFriends)) {
                echo "<p>Table '$friends' created successfully.</p>";
            } else {
                echo "<p>Error creating table: " . mysqli_error($connection) . "</p>";
            }

            // Create myfriends table
            $sqlMyFriends = "CREATE TABLE IF NOT EXISTS $myfriends (
                friend_id1 INT NOT NULL,
                friend_id2 INT NOT NULL,
                CHECK (friend_id1 != friend_id2)
            )";

            // Execute the table creation query
            if (mysqli_query($connection, $sqlMyFriends)) {
                echo "<p>Table '$myfriends' created successfully.</p>";
            } else {
                echo "<p>Error creating table: " . mysqli_error($connection) . "</p>";
            }

            // Inserting dummy data into friends table
            $sqlInsertDummyFriends = "INSERT INTO $friends (friend_email, password, profile_name, date_started, num_of_friends)
            VALUES
            ('lorra@gmail.com', 'lorra456', 'Lorra', '2024-11-11', 2),
            ('gabe@gmail.com', 'gabe456', 'Gabe', '2024-10-10', 1),
            ('andy@gmail.com', 'andy456', 'Andy', '2024-09-09', 2),
            ('ram@gmail.com', 'ram456', 'Ram', '2024-08-08', 0),
            ('mon@gmail.com', 'mon456', 'Monika', '2024-07-07', 1),
            ('sum@gmail.com', 'sum456', 'Suminda', '2024-06-06', 2),
            ('eli@gmail.com', 'eli456', 'Eli', '2024-05-05', 1),
            ('kaitlyn@gmail.com', 'kaitlyn456', 'Kaitlyn', '2024-04-04', 2),
            ('anna@gmail.com', 'anna456', 'Anna', '2024-03-03', 2),
            ('adrian@gmail.com', 'adrian456', 'Adrian', '2024-02-02', 2),
            ('mia@gmail.com', 'mia456', 'Mia', '2024-01-01', 2)";

            // Check if friends table has records
            $sqlCheck = "SELECT * FROM $friends";
            $userResult = mysqli_query($connection, $sqlCheck);
            if (mysqli_num_rows($userResult) > 0) {
                echo "<p>The table '$friends' already contains records</p>";
            } else {
                // Insert sample data into friends table
                if (mysqli_query($connection, $sqlInsertDummyFriends)) {
                    echo "<p>Sample records have been inserted to '$friends' table</p>";
                } else {
                    echo "<p>Error adding records: " . mysqli_error($connection) . "</p>";
                }
            }

            // Inserting sample data into myfriends table
            $sqlInsertMyFriends = "INSERT INTO $myfriends (friend_id1, friend_id2)
                VALUES
                    (1, 2),
                    (2, 3),
                    (3, 4),
                    (4, 5),
                    (5, 6),
                    (6, 7),
                    (7, 8),
                    (8, 9),
                    (9, 10),
                    (10, 1),
                    (1, 3),
                    (2, 4),
                    (3, 5),
                    (4, 6),
                    (5, 7),
                    (6, 8),
                    (7, 9),
                    (8, 10),
                    (9, 1),
                    (10, 2)";

            // Check if myfriends table has records
            $sqlCheck2 = "SELECT * FROM $myfriends";
            $userResult2 = mysqli_query($connection, $sqlCheck2);
            if (mysqli_num_rows($userResult2) > 0) {
                echo "<p>The table '$myfriends' already contains records</p>";
            } else {
                // Insert sample data into myfriends table
                if (mysqli_query($connection, $sqlInsertMyFriends)) {
                    echo "<p>Sample records have been inserted to '$myfriends' table</p>";
                } else {
                    echo "<p>Error adding records: " . mysqli_error($connection) . "</p>";
                }
            }

            // Close the connection
            mysqli_close($connection);
        ?>
    </div>
</body>
</html>
