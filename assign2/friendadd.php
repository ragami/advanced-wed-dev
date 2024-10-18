<?php
session_start();
require_once("setup.php");

// Check if user is logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];

// Connect to the database
$connection = mysqli_connect($host, $user, $pass, $db);
if (!$connection) {
    die("Failed to connect: " . mysqli_connect_error());
}

// Query to fetch the current user's profile information
$query = "SELECT friend_id, profile_name FROM $friends WHERE friend_email = '$userEmail'";
$userResult = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($userResult);
$userId = $user['friend_id'];
$profileName = $user['profile_name'];

// Set up pagination: determine the current page and items per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$start = ($currentPage > 1) ? ($currentPage * $perPage) - $perPage : 0;

// Get total number of potential friends (not friends with current user)
$total_sql = "SELECT COUNT(*) as total FROM $friends f 
              WHERE f.friend_id != $userId 
              AND f.friend_id NOT IN (
                  SELECT IF(friend_id1 = $userId, friend_id2, friend_id1)
                  FROM $myfriends
                  WHERE friend_id1 = $userId OR friend_id2 = $userId
              )";
$total_result = mysqli_query($connection, $total_sql);
$total = mysqli_fetch_assoc($total_result)['total'];
$pages = ceil($total / $perPage);

// Fetch the list of potential friends, excluding current user's friends and count mutual friends
$query = "
    SELECT f.friend_id, f.profile_name,
        (
            SELECT COUNT(*) 
            FROM $myfriends mf1
            WHERE 
                (mf1.friend_id1 = f.friend_id OR mf1.friend_id2 = f.friend_id)
                AND (
                    mf1.friend_id1 IN (
                        SELECT IF(friend_id1 = $userId, friend_id2, friend_id1)
                        FROM $myfriends
                        WHERE friend_id1 = $userId OR friend_id2 = $userId
                    )
                    OR mf1.friend_id2 IN (
                        SELECT IF(friend_id1 = $userId, friend_id2, friend_id1)
                        FROM $myfriends
                        WHERE friend_id1 = $userId OR friend_id2 = $userId
                    )
                )
        ) AS count_of_mutual_friends
    FROM $friends f
    WHERE f.friend_id != $userId
    AND f.friend_id NOT IN (
        SELECT IF(friend_id1 = $userId, friend_id2, friend_id1)
        FROM $myfriends
        WHERE friend_id1 = $userId OR friend_id2 = $userId
    )
    ORDER BY f.profile_name
    LIMIT $start, $perPage
";
$userResult = mysqli_query($connection, $query);

// Check for "Add Friend" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_friend'])) {
    $friendToAdd = $_POST['add_friend'];
    
    // Insert the friendship record into the database
    $query = "INSERT INTO $myfriends (friend_id1, friend_id2) VALUES ($userId, $friendToAdd)";
    mysqli_query($connection, $query);
    
    // Update the number of friends for both users
    $query = "UPDATE $friends SET num_of_friends = num_of_friends + 1 WHERE friend_id IN ($userId, $friendToAdd)";
    mysqli_query($connection, $query);
    
    // Redirect to refresh the page after adding the friend
    header("Location: friendadd.php");
    exit();
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Set character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensure proper rendering on other devices -->
    <title>My Friends System</title> 
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="navigation"> 
        <h1>My Friend System</h1> 
        <ul class="nav"> 
            <li class="nav-link"><a href="friendlist.php">Friend List</a></li> <!-- Link to the friend list page -->
            <li class="nav-link"><a href="friendadd.php">Add Friends</a></li> <!-- Link to the add friends page -->
            <li class="nav-link"><a href="logout.php">Log Out</a></li> <!-- Link to log out page -->
        </ul>
    </div>

    <div class="content"> <!-- Main content area of the page -->
        <h2>Add Friends for <?php echo htmlspecialchars($profileName); ?></h2> <!-- Display the profile name for adding friends -->

        <table class="friend-table"> <!-- Table to display friends -->
            <thead> 
                <tr>
                    <th>Profile Name</th> 
                    <th>Mutual Friends</th> 
                    <th>Add Friend</th> 
                </tr>
            </thead>
            <tbody> <!-- Table body -->
                <?php while ($row = mysqli_fetch_assoc($userResult)): ?> <!-- Loop through each user result -->
                    <tr>
                        <td><?php echo htmlspecialchars($row['profile_name']); ?></td> <!-- Display the friend's profile name -->
                        <td><?php echo $row['count_of_mutual_friends']; ?></td> <!-- Display the number of mutual friends -->
                        <td>
                            <form method="post" action="friendadd.php"> <!-- Form to add a friend -->
                                <input type="hidden" name="add_friend" value="<?php echo $row['friend_id']; ?>"> <!-- Hidden input to store the friend's ID -->
                                <input type="submit" value="Add friend" class="add-friend-button"> <!-- Submit button to add a friend -->
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?> 
            </tbody>
        </table>

        <div class="pagination"> <!-- Pagination controls -->
            <?php if ($currentPage > 1): ?> <!-- Check if not on the first page -->
                <a href="?page=<?= $currentPage - 1; ?>" class="page-link">Previous</a> <!-- Link to the previous page -->
            <?php endif; ?>

            <?php
            // Loop through pages and create links
            foreach (range(1, $pages) as $i): ?> 
                <a href="?page=<?= $i; ?>" class="page-link <?= ($i === $currentPage) ? 'active' : ''; ?>"> 
                    <?= $i; ?> 
                </a>
            <?php endforeach; ?>

            <?php if ($currentPage < $pages): ?> <!-- Check if not on the last page -->
                <a href="?page=<?= $currentPage + 1; ?>" class="page-link">Next</a> <!-- Link to the next page -->
            <?php endif; ?>
        </div>

    </div>
</body>
</html>
