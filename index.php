<!-- This is a hand crafted webpage put together inside Visual Studio Code -->
<!DOCTYPE html>
<html lang="en-US">
<head>
<title> Robbeloth Family Website </title>
<link rel="stylesheet" href="stylesheet.css" />
<link rel="icon" href="img/R.png" type="image/x-icon">
</head>
<body>

<h1>Welcome to the Robbeloth Family Website</h1>
<img src="img/Robbeloth-2671-reduced.jpg" width="600" height="400" alt="The North-Central Ohio based Robbeloth Family"> 

<p>
<?php
$visitor_ip = $_SERVER['REMOTE_ADDR'];
$user_agent_string = $_SERVER['HTTP_USER_AGENT'];
echo "Hello. Thank you for visiting from <a href=\"https://en.wikipedia.org/wiki/IP_address\"> Internet Protocol (IP) </a> Address: " . $visitor_ip . '. ';
echo "You are using: " . $user_agent_string . '.';
?>
</p>

<p title="Important links">  Dr. Michael Robbeloth is a senior lecturer at OSU in the <a href="https://engineering.osu.edu/">College of Engineering&apos;s</a> <a href="https://cse.osu.edu/">Department of Computer Science and Engineering</a>. Previously, I was an associate professor of <a href="https://cs.mvnu.edu/">Computer Science</a> at 
Mount Vernon Nazarene University (<a href="https://www.mvnu.edu">MVNU</a>). Dr. Robbeloth is also available to take on professonal speaking engagements or consulting work (see my consulting page). 
You can learn more about Dr. Robbeloth from following one of the links below: </p>
<ol>
    <a href="https://about.me/mrobbeloth">About Dr. Robbeloth</a> <br/>
    <a href="consulting.html">Consulting Information</a> <br/>
    <a href="https://cse.osu.edu/people/robbeloth.1">Work: OSU</a> <br/>
    <a href="https://mvnu.edu/faculty/dr-michael-robbeloth/">Work: MVNU </a> <br/>
    <a href="https://www.linkedin.com/in/mrobbeloth/"> Dr. Robbeloth&apos;s Linked In Profile </a> <br/>
    <a href="https://www.twitter.com/mrobbeloth">Twitter</a> <br/>
    <a href="https://github.com/mrobbeloth">Github</a> <br/>
</ol>
<p>My wife, Jacqueline Robbeloth, works for the <a href="https://www.galionschools.org/staff?search=robbeloth">Galion City School District</a> as the Supervisor of Learning. </p>
<p>Our family pet is <a href="https://en.wikipedia.org/wiki/Leonie">Leonie</a>, a long-haired Dachshund.</p>
<section>
<img src="img/IMG_7617-reduced.JPG" width="600" height="400" alt="Princess Anna, I mean Octavia"> </img>
</section>
<br/>
<footer>
<hr/>
<a href="https://github.com/mrobbeloth/website"> Github Repository for website </a>

<p> Copyright (c) 2025 by Michael Robbeloth. All Rights Reserved</p>
</footer>
</body>
</html>
