<!-- This is a hand crafted webpage put together inside Visual Studio Code -->
<!DOCTYPE html>
<html lang="en-US">
<head>
<title> Robbeloth Family Website </title>
<meta name="description" content="Robbeloth family website and professional profile of Dr. Michael Robbeloth, Assistant Professor at Ohio State University and consultant for software, systems, and engineering projects.">
<meta property="og:title" content="Robbeloth Family Website">
<meta property="og:description" content="Learn about Dr. Michael Robbeloth, his academic role at OSU, industry experience, and consulting availability.">
<meta property="og:image" content="img/Robbeloth-2671-reduced.jpg">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Robbeloth Family Website">
<meta name="twitter:description" content="Profile of Dr. Michael Robbeloth with links to consulting, academia, and social profiles.">
<meta name="twitter:image" content="img/Robbeloth-2671-reduced.jpg">
<link rel="stylesheet" href="stylesheet.css" />
<link rel="icon" href="img/R.png" type="image/x-icon">

</head>
<body>

<nav aria-label="Primary navigation">
 <ul>
  <li><a href="consulting.php">Hire Me</a></li>
  <li><a href="family.php">Family</a></li>
  <li><a href="https://eed.osu.edu/people/robbeloth.1">Work @ OSU</a></li>
  <li><a href="https://www.linkedin.com/in/mrobbeloth/">LinkedIn Profile</a></li>
  <li><a href="https://www.twitter.com/mrobbeloth">Twitter Profile</a></li>
  <li><a href="https://github.com/mrobbeloth">Github Profile</a></li>
  <li><a href="contact.php">Contact</a></li>
 </ul>
</nav>

<main class="page">
 <section class="hero">
  <h1>Dr. Michael Robbeloth</h1>
  <p class="lede">Academic leader, speaker, researcher, and consultant specializing in software, systems, and engineering education.</p>
  <div class="hero-actions">
   <a class="button-primary" href="consulting.html">Hire Me</a>
  </div>
  <div class="hero-media">
    <img src="img/headshots/IMG_0521_even_smaller.png" alt="Dr. Michael Robbeloth">
  </div>
 </section>

 <section class="content-section">
  <p title="Important links">  Dr. Michael Robbeloth is an Assistant Professor of Practice at <a href="https://www.osu.edu">The Ohio State University</a> in the 
  <a href="https://engineering.osu.edu/">College of Engineering&apos;s</a> <a href="https://eed.osu.edu/">Engineering Education Department </a> with a courtesy
  appointment in the <a href="https://cse.osu.edu/">Department of Computer Science and Engineering</a>. Previously, Dr. Robbeloth was an Associate Professor of <a href="https://cs.mvnu.edu/">Computer Science</a> at 
  Mount Vernon Nazarene University (<a href="https://www.mvnu.edu">MVNU</a>) and worked in industry for companies of all sizes and from different industries including: <a href="https://www.kodak.com">Eastman Kodak</a>, <a href="https://dsautomation.com/">DSA Automation</a>, and <a href="https://www.pdiarm.com">PDi Communications, Inc.</a>
  Dr. Robbeloth is available to take on professonal speaking engagements or consulting work (see my <a href="consulting.html">consulting</a> page).
  You can learn more about Dr. Robbeloth from following one of the links below: </p>
  <ol>
      <li>Consulting: <a href="consulting.html">Services and contact</a></li>
      <li>Academic role: <a href="https://eed.osu.edu/people/robbeloth.1">Work @ OSU profile</a></li>
      <li>Professional network: <a href="https://www.linkedin.com/in/mrobbeloth/">LinkedIn</a></li>
      <li>Updates: <a href="https://www.twitter.com/mrobbeloth">Twitter</a></li>
      <li>Code: <a href="https://github.com/mrobbeloth">Github</a></li>
      <li>Research ID:
      <a
      id="cy-effective-orcid-url"
      class="underline"
       href="https://orcid.org/0009-0004-1643-4548"
       target="orcid.widget"
       rel="me noopener noreferrer"
       style="vertical-align: top">
       <img
          src="https://orcid.org/sites/default/files/images/orcid_16x16.png"
          style="width: 1em; margin-inline-start: 0.5em"
          alt="ORCID iD icon"/>
        ORCID
      </a>
     </li>
  </ol>
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
