<?php
session_start();
require_once __DIR__ . '/src/config.php';

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Generate enhanced challenge (math captcha) with multiple operations
// Always regenerate to prevent reuse and increase security
function generateChallenge() {
    $operations = ['+', '-', '*'];
    $operation = $operations[array_rand($operations)];
    $a = random_int(5, 99);
    
    // Adjust range based on operation to keep answers reasonable
    if ($operation === '*') {
        $a = random_int(2, 12);
        $b = random_int(2, 12);
    } else {
        $b = random_int(5, 99);
    }
    
    // For subtraction, ensure positive result
    if ($operation === '-' && $a < $b) {
        [$a, $b] = [$b, $a];
    }
    
    switch ($operation) {
        case '+':
            $answer = $a + $b;
            break;
        case '-':
            $answer = $a - $b;
            break;
        case '*':
            $answer = $a * $b;
            break;
    }
    
    return [
        'a' => $a,
        'b' => $b,
        'operation' => $operation,
        'answer' => $answer
    ];
}

// Initialize attempt tracking
if (empty($_SESSION['challenge_attempts'])) {
    $_SESSION['challenge_attempts'] = 0;
}
if (empty($_SESSION['challenge_locked_until'])) {
    $_SESSION['challenge_locked_until'] = 0;
}

// Only regenerate challenge if not currently locked
$now = time();
$isLocked = $now < $_SESSION['challenge_locked_until'];
if (!$isLocked) {
    $challenge = generateChallenge();
    $_SESSION['challenge_a'] = $challenge['a'];
    $_SESSION['challenge_b'] = $challenge['b'];
    $_SESSION['challenge_operation'] = $challenge['operation'];
    $_SESSION['challenge_answer'] = $challenge['answer'];
}

$errors = [];
$success = false;
$formDisabled = $isLocked;

// Show lockout message even on page load (GET request)
if ($isLocked) {
    $remainingSeconds = ceil(($_SESSION['challenge_locked_until'] - $now) / 60);
    $errors[] = "Too many failed attempts. Please try again in $remainingSeconds minute(s).";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Throttle
    if (isset($_SESSION['last_submit']) && ($now - $_SESSION['last_submit']) < $minSubmitIntervalSeconds) {
        $errors[] = 'Please wait a bit before submitting again.';
    }
    
    // Check if challenge is locked
    if ($now < $_SESSION['challenge_locked_until']) {
        $remainingSeconds = ceil(($_SESSION['challenge_locked_until'] - $now) / 60);
        $errors[] = "Too many failed attempts. Please try again in $remainingSeconds minute(s).";
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
    $expected = $_SESSION['challenge_answer'] ?? null;
    if ($challenge === '' || !ctype_digit($challenge) || (int)$challenge !== $expected) {
        $errors[] = 'Please answer the challenge question correctly.';
        // Track failed attempts
        $_SESSION['challenge_attempts'] = ($_SESSION['challenge_attempts'] ?? 0) + 1;
        // Lock after 3 failed attempts for 15 minutes
        if ($_SESSION['challenge_attempts'] >= 3) {
            $_SESSION['challenge_locked_until'] = $now + (15 * 60);
        }
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
                // Reset challenge attempts on successful submission
                $_SESSION['challenge_attempts'] = 0;
                $_SESSION['challenge_locked_until'] = 0;
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
  <li><a href="family.php">Family</a></li>
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
      <input type="text" id="name" name="name" required <?= $formDisabled ? 'disabled' : '' ?>>
    </div>

    <div class="form-row">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required <?= $formDisabled ? 'disabled' : '' ?>>
    </div>

    <div class="form-row">
      <label for="subject">Subject</label>
      <input type="text" id="subject" name="subject" placeholder="Consulting inquiry" <?= $formDisabled ? 'disabled' : '' ?>>
    </div>

    <div class="form-row">
      <label for="message">Message</label>
      <textarea id="message" name="message" rows="6" required <?= $formDisabled ? 'disabled' : '' ?>></textarea>
    </div>

    <div class="form-row">
      <label for="challenge">Challenge: What is <?= $_SESSION['challenge_a'] ?> <?= $_SESSION['challenge_operation'] ?> <?= $_SESSION['challenge_b'] ?>?</label>
      <input type="text" id="challenge" name="challenge" inputmode="numeric" pattern="[0-9]*" required <?= $formDisabled ? 'disabled' : '' ?>>
    </div>

    <div class="form-actions">
      <button type="submit" class="button-primary" <?= $formDisabled ? 'disabled' : '' ?>>Send Message</button>
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
  <p>&copy; <?php echo date('Y'); ?> Michael Robbeloth. All Rights Reserved.</p>
</footer>

</body>
</html>