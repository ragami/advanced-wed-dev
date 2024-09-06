<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character set and meta information for the document -->
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Advanced Web Development" />
    
    <!-- Page title -->
    <title>Assignment 1</title>

    <!-- Link to stylesheet -->
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <!-- Header section with navigation -->
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="postjobform.php">Post a Job</a></li>
                <li><a href="searchjobform.php">Job Search</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>
    
    <!-- Main content area -->
    <br>
    <h1 class="page-title">Job Vacancy Posting System</h1>
    
    <div class="error-box">
        <?php
        $error = 0; // Initialize error variable
        
        // Validate Position ID
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            if (strlen($id) != 5 || !preg_match("/^ID[0-9]{3}$/", $id)) {
                echo "<p class='error-message'>Invalid Position ID. It must start with 'ID' followed by 3 digits.</p>";
            }
        } else {
            echo "<p class='error-message'>Position ID is required.</p>";
        }

        // Validate Title
        if (isset($_POST['title']) && !empty($_POST['title'])) {
            $title = $_POST['title'];
            if (strlen($title) > 10) {
                echo "<p class='error-message'>Title should be between 1 and 10 characters in length.</p>";
            } elseif (!preg_match("/^[a-zA-Z0-9,.! ]+$/", $title)) {
                echo "<p class='error-message'>Title can only contain alphanumeric characters, spaces, commas, periods, and exclamation points.</p>";
            }
        } else {
            echo "<p class='error-message'>Title is required.</p>";
        }

        // Validate Description
        if (isset($_POST['description']) && !empty($_POST['description'])) {
            $description = $_POST['description'];
            if (strlen($description) > 250) {
                echo "<p class='error-message'>Description should be no more than 250 characters.</p>";
            }
        } else {
            echo "<p class='error-message'>Description is required.</p>";
        }

        // Validate Closing Date
        if (isset($_POST['closing_date']) && !empty($_POST['closing_date'])) {
            $closing_date = $_POST['closing_date'];
            if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $closing_date, $matches)) {
                if (!checkdate($matches[2], $matches[1], $matches[3])) {
                    echo 'Please enter a valid date in the format - dd/mm/yyyy';
                }
            } else {
                echo 'Only this format - dd/mm/yyyy - is accepted.';
            }
        } else {
            echo "<p class='error-message'>Close Date is required</p>";
        }

        // Validate Position
        if (isset($_POST['position']) && !empty($_POST['position'])) {
            $position = $_POST['position'];
        } else {
            echo "<p class='error-message'>Please select a Position</p>";
        }

        // Validate Contract
        if (isset($_POST['contract']) && !empty($_POST['contract'])) {
            $contract = $_POST['contract'];
        } else {
            echo "<p class='error-message'>Please select a Contract</p>";
        }

        // Validate Location
        if (isset($_POST['location']) && !empty($_POST['location'])) {
            $location = $_POST['location'];
        } else {
            echo "<p class='error-message'>Please select a Location</p>";
        }

        // Validate Application Types
        if ((isset($_POST["type1"]) && !empty($_POST["type1"])) || (isset($_POST["type2"]) && !empty($_POST["type2"]))) {
            // Set application types with default empty values if not provided
            $type1 = isset($_POST["type1"]) ? $_POST["type1"] : " ";
            $type2 = isset($_POST["type2"]) ? $_POST["type2"] : " ";
        } else {
            echo "<p class='error-message'>Please select an Application type</p>";
            $error = 1;
        }

        // Read, Write, run validation function
        if ($error == 0) {
            $filename = "../../data/jobs/positions.txt"; // File path
            $dir = "../../data/jobs"; // Directory path
            
            if (!(file_exists($dir))) { // Check if directory exists
                umask(0007); // Set permission for directory
                mkdir($dir, 02770); // Create directory with permission
            }
            
            if (file_exists($filename)) { // Check if file exists for reading
                $idData = array(); // Create an empty array
                $handle = fopen($filename, "r") or die("File not found"); // Open the file in read mode

                while (!feof($handle)) { // Loop while not end of file
                    $onedata = fgets($handle); // Read a line from the text file
                    if ($onedata != "") { // Ignore blank lines
                        $data = explode("\t", $onedata); // Split line into array
                        $idData[] = $data[0]; // Add ID to array
                    }
                }
                fclose($handle); // Close the file
                $newdata = !(in_array($id, $idData)); // Check if ID is new
            } else {
                $newdata = true; // File does not exist, thus it is new data
            }
            
            if ($newdata) { // Save to file
                $handle = fopen($filename, "a"); // Open file in append mode
                $data = $id . "\t" . $title . "\t" . $description . "\t" . $closing_date . "\t" . $position . "\t" . $contract . "\t" . $type1 . "\t" . $type2 . "\t" . $location . "\n";
                fputs($handle, $data); // Write data to file
                fclose($handle); // Close the file
                echo "<p>You have successfully posted your job.</p>";
                echo "<p><a href=\"index.php\"> Return Home</a></p>";
            } else {
                echo "<p class='error-message'>Position ID already exists.</p>";
                echo "<p>Return to <a href=\"index.php\"> Home Page</a></p>";
                echo "<p>Go to <a href=\"searchjobform.php\">Search Job Vacancy</a></p>";
            }
        } else {
            echo "<p>Return to <a href=\"index.php\"> Home Page</a></p>";
            echo "<p>Go to <a href=\"searchjobform.php\">Search Job Vacancy</a></p>";
        }
        ?>
    </div>
</body>

</html>
