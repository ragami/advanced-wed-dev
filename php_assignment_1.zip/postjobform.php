<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for character set and description -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Advanced Web Development" />
    
    <!-- Page title -->
    <title>Assignment 1</title>
    
    <!-- Link to stylesheet and Google Fonts -->
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Header section with navigation -->
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="postjobform.php">Post a Job</a></li>
                <li><a href="searchjobform.php">Job Search</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>
    
    <!-- Main content area -->
    <div class="content">
        <!-- Banner section -->
        <div class="banner">
            <br>
            <h1 class="page-title">Job Vacancy Posting System</h1>
        </div>
        
        <!-- Job posting form -->
        <form action="postjobprocess.php" method="post" class="job-form">
            
            <!-- Position ID field -->
            <div class="form-section">
                <label for="id"><strong>Position ID:</strong></label>
                <input type="text" id="id" name="id" class="input-text" placeholder="e.g. ID001">
            </div>

            <!-- Title field -->
            <div class="form-section">
                <label for="title"><strong>Title:</strong></label>
                <input type="text" id="title" name="title" class="input-text" placeholder="Enter Title Here">
            </div>

            <!-- Description field -->
            <div class="form-section">
                <label for="description"><strong>Description:</strong></label>
                <textarea id="description" name="description" class="input-textarea" rows="4" cols="30"></textarea>
            </div>

            <!-- Closing Date field -->
            <div class="form-section">
                <label for="closing_date"><strong>Closing Date:</strong></label>
                <input type="text" id="closing_date" name="closing_date" class="input-text" value="<?php echo date('d/m/Y') ?>">
            </div>

            <!-- Position options -->
            <div class="form-section">
                <label><strong>Position:</strong></label>
                <div class="radio-inline">
                    <input type="radio" id="full_time" name="position" value="full">
                    <label for="full_time">Full Time</label>
                    <input type="radio" id="part_time" name="position" value="part">
                    <label for="part_time">Part Time</label>
                </div>
            </div>

            <!-- Contract options -->
            <div class="form-section">
                <label><strong>Contract:</strong></label>
                <div class="radio-inline">
                    <input type="radio" id="on_going" name="contract" value="on_going">
                    <label for="on_going">On-going</label>
                    <input type="radio" id="fixed_term" name="contract" value="fixed">
                    <label for="fixed_term">Fixed Term</label>
                </div>
            </div>

            <!-- Location options -->
            <div class="form-section">
                <label><strong>Location:</strong></label>
                <div class="radio-inline">
                    <input type="radio" id="on_site" name="location" value="on_site">
                    <label for="on_site">On site</label>
                    <input type="radio" id="remote" name="location" value="remote">
                    <label for="remote">Remote</label>
                </div>
            </div>

            <!-- Application type options -->
            <div class="form-section">
                <label><strong>Application By:</strong></label>
                <div class="checkbox-inline">
                    <input type="checkbox" id="post" name="type1" value="post">
                    <label for="post">Post</label>
                    <input type="checkbox" id="email" name="type2" value="email">
                    <label for="email">Email</label>
                </div>
            </div>

            <!-- Form action buttons -->
            <div class="form-buttons">
                <input type="submit" value="Post" class="btn submit-btn">
                <input type="reset" value="Reset" class="btn reset-btn">
            </div>
            <br>

            <!-- Form footer -->
            <div class="form-footer">
                <p>All fields are required. <a href="index.php">Return to Home Page</a></p>
            </div>
        </form>
    </div>
</body>

</html>