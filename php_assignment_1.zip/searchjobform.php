<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character set and meta information for the document -->
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Search for Jobs" />
    <meta name="keywords" content="PHP, Job Search" />
    <meta name="author" content="Lorraine Becker" />
    
    <!-- Page title -->
    <title>Search Jobs</title>
    
    <!-- Link to stylesheet -->
    <link rel="stylesheet" href="style/style.css">
    
    <!-- Link to Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Header section with navigation -->
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
    
    <!-- Main content area -->
    <br>
    <h1 class="page-title">Search for Jobs</h1>
    
    <main class="content">
        <!-- Search form section -->
        <section class="search-form">
            <form action="searchjobprocess.php" method="get">
                <!-- Job Title input -->
                <div class="form-section">
                    <label for="title"><strong>Job Title:</strong></label>
                    <input type="text" id="title" name="title" class="input-text" placeholder="Enter job title">
                </div>

                <!-- Position Type dropdown -->
                <div class="form-section">
                    <label for="position"><strong>Position Type:</strong></label>
                    <select id="position" name="position" class="input-select">
                        <option value="">Any</option>
                        <option value="full">Full Time</option>
                        <option value="part">Part Time</option>
                    </select>
                </div>

                <!-- Contract Type dropdown -->
                <div class="form-section">
                    <label for="contract"><strong>Contract Type:</strong></label>
                    <select id="contract" name="contract" class="input-select">
                        <option value="">Any</option>
                        <option value="on_going">On-going</option>
                        <option value="fixed">Fixed Term</option>
                    </select>
                </div>

                <!-- Application By checkboxes -->
                <div class="form-section">
                    <label><strong>Application By:</strong></label>
                    <div class="checkbox-inline">
                        <input type="checkbox" id="postMethod" name="via[]" value="post">
                        <label for="postMethod">Post</label>
                        <input type="checkbox" id="emailMethod" name="via[]" value="email">
                        <label for="emailMethod">Email</label>
                    </div>
                </div>

                <!-- Location dropdown -->
                <div class="form-section">
                    <label for="location"><strong>Location:</strong></label>
                    <select id="location" name="location" class="input-select">
                        <option value="">Any</option>
                        <option value="on_site">On-site</option>
                        <option value="remote">Remote</option>
                    </select>
                </div>
                
                <!-- Submit button -->
                <div class="form-buttons">
                    <input type="submit" value="Find Jobs" class="btn submit-btn">
                </div>
            </form>
        </section>

        <!-- Footer section -->
        <footer class="footer">
            <p><a href="index.php">Return to Homepage</a></p>
        </footer>
    </main>
</body>

</html>
