<?php
session_start(); // Start the session to access session variables
require_once("setup.php"); // Include the setup file for database connection details

// Initialising array and variables
$errors = []; 
$emailInput = ''; 
$passwordInput = ''; 

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim and store the input values
    $emailInput = trim($_POST['email']);
    $passwordInput = ($_POST['password']);

    // Validate the email and password inputs
    if (empty($emailInput)) {
        $errors[] = "Email is required"; // Add error if email is empty
    }
    if (empty($passwordInput)) {
        $errors[] = "Password is required"; // Add error if password is empty
    }

    // Establish database connection
    $connection = mysqli_connect($host, $user, $pass, $db);
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error()); // Otherwise exit
    }

    // Validate email and password by querying the database
    $query = "SELECT * FROM $friends WHERE friend_email = '$emailInput'";
    $userResult = mysqli_query($connection, $query);

    // Check if a user with the provided email exists
    if (mysqli_num_rows($userResult) == 1) {
        $row = mysqli_fetch_assoc($userResult); // Fetch the user's data
        // Check if the provided password matches the stored password
        if ($passwordInput === $row['password']) {
            // Login successful: set session variables
            $_SESSION['loggedIn'] = true; // Mark user as logged in
            $_SESSION['email'] = $emailInput; // Store user's email
            $_SESSION['user_id'] = $row['friend_id']; // Store user's ID
            header("Location: friendlist.php"); // Redirect to friend list page
            exit();
        } else {
            $errors[] = "Incorrect password"; // Add error if password is incorrect
        }
    } else {
        $errors[] = "Email not found"; // Add error if email does not exist
    }
    mysqli_close($connection); // Close the database connection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Friends System - Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the CSS file -->
</head>
<body>
    <div class="navigation">
        <h1>My Friends System</h1>
        <ul class="nav">
            <li class="nav-link"><a href="index.php">Home</a></li>
            <li class="nav-link"><a href="signup.php">Sign Up</a></li>
            <li class="nav-link"><a href="login.php">Login</a></li>
            <li class="nav-link"><a href="about.php">About</a></li>
        </ul>
    </div>

    <div class="registration-form">
        <h1>Login Page</h1>
        <?php
        // Display error messages if there are any
        if (!empty($errors)) {
            echo "<div class='errors'>";
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>"; // Display each error
            }
            echo "</div>";
        }
        ?>
        <form method="post" action="login.php"> <!-- Form for user login -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($emailInput); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="button-container"> <!-- Centering the buttons -->
                <input type="submit" value="Login" class="submit-button"> <!-- Submit button for login -->
                <input type="button" value="Clear" class="clear-button" onclick="window.location.href='login.php';"> <!-- Button to clear form -->
            </div>
        </form>
        <div class="return-to-home">
            <a href="index.php">Return to Home</a> <!-- Link to return to the home page -->
        </div>
    </div>
</body>
</html>
