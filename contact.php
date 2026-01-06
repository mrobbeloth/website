<?php
session_start();
require_once __DIR__ . '/src/config.php';

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Generate simple challenge (math captcha)
if (empty($_SESSION['challenge_a']) || empty($_SESSION['challenge_b'])) {
    $_SESSION['challenge_a'] = random_int(1, 9);
    $_SESSION['challenge_b'] = random_int(1, 9);
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Throttle
    $now = time();
    if (isset($_SESSION['last_submit']) && ($now - $_SESSION['last_submit']) < $minSubmitIntervalSeconds) {
        $errors[] = 'Please wait a bit before submitting again.';
    }

    // CSRF check
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        $errors[] = 'Invalid form token. Please refresh and try again.';
    }

    // Honeypot check
    $honeypot = trim($_POST['website'] ?? '');
    if ($honeypot !== '') {
        $errors[] = 'Spam detected.';
    }

    // Challenge check
    $challenge = trim($_POST['challenge'] ?? '');
    $expected = $_SESSION['challenge_a'] + $_SESSION['challenge_b'];
    if ($challenge === '' || !ctype_digit($challenge) || (int)$challenge !== $expected) {
        $errors[] = 'Please answer the challenge question correctly.';
    }

    // Inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') { $errors[] = 'Name is required.'; }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Valid email is required.'; }
    if ($message === '') { $errors[] = 'Message is required.'; }

    if (empty($subject)) {
        $subject = 'New contact form submission - ' . $siteName;
    }

    if (empty($errors)) {
        if (empty($recipientEmail)) {
            $errors[] = 'Contact form is not configured. Please set $recipientEmail in src/config.php.';
        } else {
            // Prepare email
            $safeSubject = preg_replace('/[\r\n]+/', ' ', $subject);
            $body = "From: $name\nEmail: $email\n\n$message";
            $headers = [];
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-Type: text/plain; charset=UTF-8';
            $headers[] = 'X-Mailer: PHP/' . phpversion();
            $headers[] = 'Reply-To: ' . $email;
            $headersStr = implode("\r\n", $headers);

            if (@mail($recipientEmail, $safeSubject, $body, $headersStr)) {
                $success = true;
                $_SESSION['last_submit'] = $now;
                // Reset challenge for next time
                $_SESSION['challenge_a'] = random_int(1, 9);
                $_SESSION['challenge_b'] = random_int(1, 9);
            } else {
                $errors[] = 'Failed to send email. Please try again later.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Contact Dr. Robbeloth</title>
    <meta name="description" content="Contact form to reach Dr. Michael Robbeloth for consulting and speaking engagements.">
    <link rel="stylesheet" href="stylesheet.css" />
    <link rel="icon" href="img/R.png" type="image/x-icon">
</head>
<body>

<nav aria-label="Primary navigation">
 <ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="consulting.html">Consulting</a></li>
  <li><a href="https://www.linkedin.com/in/mrobbeloth/">LinkedIn</a></li>
  <li><a href="https://github.com/mrobbeloth">Github</a></li>
  <li><a aria-current="page" class="active" href="contact.php">Contact</a></li>
 </ul>
</nav>

<main class="page">
 <section class="hero">
  <h1>Contact</h1>
  <p class="lede">Send a message to inquire about consulting, speaking, or collaborations.</p>
 </section>

 <section class="content-section">
  <?php if ($success): ?>
    <p class="success">Thank you! Your message has been sent.</p>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="error" role="alert" aria-live="assertive">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form class="contact-form" method="post" action="contact.php" novalidate>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <!-- Honeypot field (should be empty) -->
    <div class="hp-field" aria-hidden="true">
      <label for="website">Website</label>
      <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
    </div>

    <div class="form-row">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>
    </div>

    <div class="form-row">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="form-row">
      <label for="subject">Subject</label>
      <input type="text" id="subject" name="subject" placeholder="Consulting inquiry">
    </div>

    <div class="form-row">
      <label for="message">Message</label>
      <textarea id="message" name="message" rows="6" required></textarea>
    </div>

    <div class="form-row">
      <label for="challenge">Challenge: What is <?= $_SESSION['challenge_a'] ?> + <?= $_SESSION['challenge_b'] ?>?</label>
      <input type="text" id="challenge" name="challenge" inputmode="numeric" pattern="[0-9]*" required>
    </div>

    <div class="form-actions">
      <button type="submit" class="button-primary">Send Message</button>
    </div>
  </form>
 </section>
</main>

<footer class="accessibility-footer">
  <ul>
    <li><a href="contact.php">Email</a></li>
    <li><a href="https://www.linkedin.com/in/mrobbeloth/">LinkedIn</a></li>
    <li><a href="https://orcid.org/0009-0004-1643-4548" rel="me">ORCID</a></li>
  </ul>
  <p>&copy; 2025 Michael Robbeloth. All Rights Reserved.</p>
</footer>

</body>
</html>