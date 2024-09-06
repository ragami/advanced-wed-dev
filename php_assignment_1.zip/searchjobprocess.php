<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Job Search Results" />
    <meta name="keywords" content="PHP, Job Search" />
    <meta name="author" content="Lorraine Becker" />
    <title>Search Results</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="postjobform.php">Post a Job</a></li>
                <li><a class="active" href="searchjobform.php">Job Search</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>
    
    <br>
    <h1 class="page-title">Search Results</h1>

    <?php
    // Retrieve search parameters from URL query string
    $searchTitle = isset($_GET['title']) ? trim($_GET['title']) : '';
    $searchPosition = isset($_GET['position']) ? trim($_GET['position']) : '';
    $searchContract = isset($_GET['contract']) ? trim($_GET['contract']) : '';
    $searchLocation = isset($_GET['location']) ? trim($_GET['location']) : '';
    $searchVia = isset($_GET['via']) ? $_GET['via'] : [];

    // Get today's date
    $today = strtotime(date('d/m/Y')); // Current date in timestamp format

    // Define the path to the jobs file
    $filename = "../../data/jobs/positions.txt";

    if (file_exists($filename)) {
        $handle = fopen($filename, "r");
        $results = [];

        // Read and process each line of the jobs file
        while (($line = fgets($handle)) !== false) {
            $fields = explode("\t", $line);
            $matches = true;

            // Check each search criterion
            if (!empty($searchTitle) && stripos($fields[1], $searchTitle) === false) {
                $matches = false;
            }

            if (!empty($searchPosition) && $searchPosition != $fields[4]) {
                $matches = false;
            }

            if (!empty($searchContract) && $searchContract != $fields[5]) {
                $matches = false;
            }

            if (!empty($searchLocation) && $searchLocation != $fields[8]) {
                $matches = false;
            }

            if (!empty($searchVia)) {
                $applicationTypes = array_filter([$fields[6], $fields[7]]);
                $matchingVia = false;

                foreach ($searchVia as $via) {
                    if (in_array($via, $applicationTypes)) {
                        $matchingVia = true;
                        break;
                    }
                }

                if (!$matchingVia) {
                    $matches = false;
                }
            }

            // Check if the closing date is today or in the future
            $closingDateTimestamp = strtotime($fields[3]);
            if ($closingDateTimestamp < $today) {
                $matches = false; // Exclude jobs with a closing date before today
            }

            // If all criteria match, add the job to results
            if ($matches) {
                $fields[] = $closingDateTimestamp; // Append timestamp to fields
                $results[] = $fields;
            }
        }

        fclose($handle);

        // Sort results by closing date (future dates first)
        usort($results, function($a, $b) {
            return $b[9] - $a[9]; // Compare timestamps (assumes timestamp is in index 9)
        });

        // Display results
        if (!empty($results)) {
            foreach ($results as $job) {
                echo "<div class='box'>";
                echo "<p><strong>Title:</strong> " . htmlspecialchars($job[1]) . "</p>";
                echo "<p><strong>Position:</strong> " . htmlspecialchars($job[4]) . "</p>";
                echo "<p><strong>Contract:</strong> " . htmlspecialchars($job[5]) . "</p>";
                echo "<p><strong>Location:</strong> " . htmlspecialchars($job[8]) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($job[2]) . "</p>";
                echo "<p><strong>Closing Date:</strong> " . htmlspecialchars($job[3]) . "</p>";
                echo "<p><strong>Application By:</strong> " . htmlspecialchars($job[6]) . htmlspecialchars($job[7]) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='box'>";
            echo "<p class='error-message'>No jobs found matching your criteria.</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No job data available.</p>";
    }
    ?>

    <footer class="footer">
        <p><a href="index.php">Return to Homepage</a></p>
        <p><a href="searchjobform.php">Return to the Search Job Vacancy Page</a></p>
    </footer>
</body>

</html>
