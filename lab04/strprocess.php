<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Lorraine Becker" />
    <title>TITLE</title>
</head>
<body>
    <h1>Web Programming - Lab 4</h1>
    <?php // read the comments for hints on how to answer each item
        if (isset ($_POST["str"])){ // check if form data exists
          $mystring = "hello world";
          $mystring = substr($mystring, 2, 7);
          echo "mystring is: $mystring";
            $str = $_POST["str"]; // obtain the form data
            $pattern = "/^[A-Za-z ]+$/"; // set regular expression pattern
            if (preg_match($pattern, $str)) { // check if $str with regular expression
                $ans = ""; // initialise variable for the answer
                $len = strlen($str); // obtain length of string $str
                for ($i = 0; $i < $len; $i++) { // checks all characters in $str
                  // accesses each character by position
                    $letter = substr ($str, $i, 1); // extract 1 char using substr. retrives 1 at a time
                    // check using strops, is_numeric is used as strops returns a number
                    // (position) if found, and false otherwise
                    // Searches for occurence of $letter. 
                    if ((strpos ("AEIOUaeiou", $letter)) === false){ 
                        $ans = $ans . $letter; // concatenate letter to answer
                    }
                }
                // generate answer after all letters are checked
              echo "<p>The word with no vowels is ", $ans, ".</p>";
            } else { // string contains invalid characters
              echo "<p>Please enter a string containing only letters or space.</p>";
            }
        } else { // no input
          echo "<p>Please enter string from the input form.</p>";
        }
        ?>
</body>
</html>
