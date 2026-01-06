<!-- This is a hand crafted webpage put together inside Visual Studio Code -->
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Robbeloth Family</title>
<meta name="description" content="Meet the Robbeloth family from North-Central Ohio: Michael, Jacqueline, and Leonie the dachshund.">
<meta property="og:title" content="Robbeloth Family">
<meta property="og:description" content="Family page for the Robbeloth family from North-Central Ohio.">
<meta property="og:image" content="img/Robbeloth-2671-reduced.jpg">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Robbeloth Family">
<meta name="twitter:description" content="Meet the Robbeloth family from North-Central Ohio.">
<meta name="twitter:image" content="img/Robbeloth-2671-reduced.jpg">
<link rel="stylesheet" href="stylesheet.css" />
<link rel="icon" href="img/R.png" type="image/x-icon">

</head>
<body>

<nav aria-label="Primary navigation">
 <ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="consulting.php">Hire Me</a></li>
  <li><a aria-current="page" class="active" href="family.php">Family</a></li>
  <li><a href="https://www.linkedin.com/in/mrobbeloth/">LinkedIn</a></li>
  <li><a href="https://github.com/mrobbeloth">Github</a></li>
  <li><a href="contact.php">Contact</a></li>
 </ul>
</nav>

<main class="page">
 <section class="hero">
  <h1>The Robbeloth Family</h1>
  <p class="lede">Meet our family from North-Central Ohio.</p>
  <div class="hero-media">
   <img src="img/Robbeloth-2671-reduced.jpg" alt="Robbeloth family portrait in North-Central Ohio">
  </div>
 </section>

 <section class="content-section">
  <h2>About Us</h2>
  <p>Dr. Michael Robbeloth is an Assistant Professor of Practice at <a href="https://www.osu.edu">The Ohio State University</a> in the 
  <a href="https://engineering.osu.edu/">College of Engineering's</a> <a href="https://eed.osu.edu/">Engineering Education Department</a> with a courtesy
  appointment in the <a href="https://cse.osu.edu/">Department of Computer Science and Engineering. </a>. 
  I love to travel, play video games by myself or with my daughter, practice my photography hobby, and more.
</p>
  
  <p>My wife, Jacqueline Robbeloth, works for the <a href="https://www.galionschools.org/staff?search=robbeloth">Galion City School District</a> as the Director of Learning Improvement. 
     She also enjoys traveling, doing websearches and other puzzles, and binge watching TV shows.</p>
  
  <p>Our family pet is <a href="https://en.wikipedia.org/wiki/Leonie">Leonie</a>, a long-haired Dachshund.</p>
 </section>

 <section class="content-section">
  <h2>Octavia</h2>
  <img src="img/IMG_7617-reduced.JPG" alt="Octavia is wearing a Princess Anna costume. She is a few years
  older now.">
  <p> Octavia is our daughter. She loves unicorns, mermaids, princesses, and all things magical. 
    She is very creative and enjoys drawing, painting, and crafting. She also love all things minecraft related. 
 </section>
</main>

<footer>
<hr/>
<a href="https://github.com/mrobbeloth/website"> Github Repository for website </a>

<div class="accessibility-footer">
  <ul>
    <li><a href="contact.php">Email</a></li>
    <li><a href="https://www.linkedin.com/in/mrobbeloth/">LinkedIn</a></li>
    <li><a href="https://orcid.org/0009-0004-1643-4548" rel="me">ORCID</a></li>
  </ul>
</div>

<p>
<?php
$visitor_ip = $_SERVER['REMOTE_ADDR'];
$user_agent_string = $_SERVER['HTTP_USER_AGENT'];
echo "Hello. Thank you for visiting from <a href=\"https://en.wikipedia.org/wiki/IP_address\"> Internet Protocol (IP) </a> Address: " . $visitor_ip . '. ';
echo "You are using: " . $user_agent_string . '.';
?>
</p>

<p> Copyright (c) <?php echo date('Y'); ?> by Michael Robbeloth. All Rights Reserved.</p>
</footer>
</body>
</html>
