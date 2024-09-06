<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character set and viewport settings for responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Advanced Web Development" />
    
    <!-- Page title -->
    <title>About</title>
    
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
                <li><a class="active" href="about.php">About</a></li>
            </ul>
        </nav>
    </header>
    
    <!-- Main content area -->
    <main>
        <br>
        <!-- Main heading -->
        <h1 class="page-title">Frequently Asked Questions</h1>
        
        <!-- FAQ section -->
        <div class="box">
            <ul>
                <li>
                    Which PHP version is it? <br>
                    PHP Version: <?php echo phpversion(); ?>
                </li>
                <li>
                    What tasks have you not attempted or not completed? <br>
                    I have attempted to complete all of the tasks. However, I'm unsure if the closing date part of my 
                    postjobform.php is correct because it does allow dates that are before today's date. In the job search page, 
                    it will filter out those dates before today's date though.
                </li>
                <li>
                    What special features have you done, or attempted, in creating the site that we should know about? <br>
                    My website is responsive on all of the pages, 
                    it can also search jobs by title, position, contract, application type, and location. 
                    If no criteria are selected, it will show all the results.
                    The job vacancies are shown from the most future closing date until today’s date (inclusive of today’s date).
                </li>
                <li>
                    What discussion points did you participate in on the unit’s discussion board for Assignment 1? <br>
                    I didn't participate in the discussion board mainly because all the questions I had in mind were already asked by other students. 
                    Those questions were all answered too.
                </li>
            </ul>
        </div>
    </main>
    
    <!-- Footer section -->
    <footer class="footer">
        <p><a href="index.php">Return to Homepage</a></p>
    </footer>
</body>

</html>
