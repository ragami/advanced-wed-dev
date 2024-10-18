<?php
session_start();
require_once("setup.php");

// Redirect to login if the user is not logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];

// Establish a connection to the database
$connection = mysqli_connect($host, $user, $pass, $db);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user's profile information
$userQuery = "SELECT friend_id, profile_name, num_of_friends FROM $friends WHERE friend_email = '$userEmail'";
$userResult = mysqli_query($connection, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// Store user information in variables
$userId = $user['friend_id'];
$profileName = $user['profile_name'];
$friendCount = $user['num_of_friends'];

// Retrieve the user's friends list
$friendsQuery = "SELECT f.friend_id, f.profile_name 
                FROM $friends f 
                INNER JOIN $myfriends mf ON (f.friend_id = mf.friend_id2 OR f.friend_id = mf.friend_id1)
                WHERE (mf.friend_id1 = $userId OR mf.friend_id2 = $userId) AND f.friend_id != $userId
                ORDER BY f.profile_name";
$userResult = mysqli_query($connection, $friendsQuery);

// Process unfriend request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unfriend'])) {
    $friendToRemove = $_POST['unfriend'];
    
    // Execute the deletion from the myfriends table
    $unfriendQuery = "DELETE FROM $myfriends WHERE (friend_id1 = $userId AND friend_id2 = $friendToRemove) 
                      OR (friend_id1 = $friendToRemove AND friend_id2 = $userId)";
    mysqli_query($connection, $unfriendQuery);
    
    // Update the number of friends for both users
    $updateFriendsCountQuery = "UPDATE $friends SET num_of_friends = num_of_friends - 1 WHERE friend_id IN ($userId, $friendToRemove)";
    mysqli_query($connection, $updateFriendsCountQuery);
    
    // Refresh the page to reflect the changes
    header("Location: friendlist.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Friends System - Friend List</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="navigation">
        <h1>My Friend System</h1>
        <ul class="nav">
            <li class="nav-link"><a href="friendlist.php">Friend List</a></li> <!-- Link to Friend List -->
            <li class="nav-link"><a href="friendadd.php">Add Friends</a></li> <!-- Link to Add Friends -->
            <li class="nav-link"><a href="logout.php">Log Out</a></li> <!-- Link to Log Out -->
        </ul>
    </div>

    <div class="content">
        <h2><?php echo htmlspecialchars($profileName); ?>'s Friend List</h2> <!-- Display user's profile name -->
        <p class="friend-count">Total number of friends: <?php echo $friendCount; ?></p> <!-- Display number of friends -->

        <table class="friend-table">
            <thead>
                <tr>
                    <th>Profile Name</th> <!-- Table header for Profile Name -->
                    <th>Add Friend</th> <!-- Table header for Add Friend -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($userResult)): ?> <!-- Loop through each friend in the result -->
                    <tr>
                        <td><?php echo htmlspecialchars($row['profile_name']); ?></td> <!-- Display friend's profile name -->
                        <td>
                            <form method="post" action="friendlist.php"> 
                                <input type="hidden" name="unfriend" value="<?php echo $row['friend_id']; ?>"> 
                                <input type="submit" value="Unfriend" class="unfriend-button"> <!-- Unfriend button -->
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?> <!-- End of the loop -->
            </tbody>
        </table>
    </div>
</body>
</html>