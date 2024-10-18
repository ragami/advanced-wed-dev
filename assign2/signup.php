<?php
session_start(); // Start the session to manage user session variables
require_once("setup.php"); 
$errors = []; 

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Trim and store input values
    $emailInput = trim($_POST['email']);
    $profileNameInput = trim($_POST['profileName']);
    $passwordInput = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validation for profile name
    if (empty($profileNameInput) || !preg_match("/^[a-zA-Z]+$/", $profileNameInput)){
        $errors[] = "Profile name must only contain letters and cannot be empty."; 
    }

    // Validation for email
    if (empty($emailInput) || !filter_var($emailInput, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please provide a valid email address."; 
    }

    // Validation for password
    if (empty($passwordInput) || !preg_match("/^[a-zA-Z0-9]+$/", $passwordInput)) {
        $errors[] = "Password can only contain letters and numbers."; 
    }

    // Check if passwords match
    if ($passwordInput !== $confirmPassword) {
        $errors[] = "Passwords do not match. Please try again."; 
    }

    // Check for duplicate email in the database
    $connection = mysqli_connect($host, $user, $pass, $db); // Establish database connection
    $checkEmail = mysqli_query($connection, "SELECT * FROM $friends WHERE friend_email = '$emailInput'"); 
    if (mysqli_num_rows($checkEmail) > 0) {
        $errors[] = "Email already exists"; 
    }

    // Insert data into the database if there are no errors
    if (empty($errors)) {
        // Insert new friend user into the database
        $query = "INSERT INTO $friends 
            (friend_email, password, profile_name, date_started, num_of_friends) 
            VALUES ('$emailInput', '$passwordInput', '$profileNameInput', CURDATE(), 0)";

        // Execute the insert query
        if (mysqli_query($connection, $query)){
            $_SESSION['email'] = $emailInput; // Store the user's email in the session
            $_SESSION['loggedIn'] = true; // Mark the user as logged in
            header("Location: friendadd.php"); // Redirect to the friend addition page
            exit(); // Stop further script execution
        } else {
            $errors[] = "Error occurred during account creation: " . mysqli_error($connection); // Add error if query fails
        }
    }
    mysqli_close($connection); // Close the database connection
}
?>

<?php
// Display error messages if there are any
if (!empty($errors)) {
    echo "<div class='errors'>";
    foreach ($errors as $error) {
        echo "<p class='error'>$error</p>"; // Output each error message
    }
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Friends System</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the CSS file for styling -->
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
        <h1>Sign Up Page</h1>
        <form method="post" action="signup.php"> <!-- Form for user registration -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php if (isset($_POST["email"])) { echo $_POST["email"]; } ?>" /><br> <!-- Email input field -->
            </div>
            <br>
            <div class="form-group">
                <label for="profileName">Profile Name</label>
                <input type="text" id="profileName" name="profileName" value="<?php if (isset($_POST["profileName"])) { echo $_POST["profileName"]; } ?>" /><br> <!-- Profile name input field -->
            </div>
            <br>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"> <!-- Password input field -->
            </div>
            <br>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword"> <!-- Confirm password input field -->
            </div>
            <br>
            <div class="button-container"> <!-- Centering the buttons -->
                <input type="submit" value="Register" class="submit-button"> <!-- Submit button for registration -->
                <input type="button" value="Clear" class="clear-button" onclick="window.location.href='signup.php';"> <!-- Button to clear form -->
            </div>
        </form>
    </div>
</body>
</html>
