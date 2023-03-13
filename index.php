<?php
  $reminders = [];

  // Check if there are already saved reminders
  if (file_exists('reminders.txt')) {
    $reminders_data = file_get_contents('reminders.txt');
    $reminders = unserialize($reminders_data);
  }

  // Add new reminder
  if (isset($_POST['name']) && isset($_POST['date'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];

    // Add reminder to array
    $reminders[] = ['name' => $name, 'date' => $date];

    // Save reminders to file
    $reminders_data = serialize($reminders);
    file_put_contents('reminders.txt', $reminders_data);
  }

  // Delete reminder
  if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    unset($reminders[$index]);

    // Save reminders to file
    $reminders_data = serialize($reminders);
    file_put_contents('reminders.txt', $reminders_data);

    // Redirect to same page to refresh list
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Birthday Reminder</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <h1>Birthday Reminder</h1>

  <form method="post">
    <label>Name:</label>
    <input type="text" name="name" required>
    <label>Date:</label>
    <input type="date" name="date" required>
    <button type="submit">Add Reminder</button>
  </form>

  <?php if (count($reminders) > 0): ?>
    <h2>Reminders:</h2>
    <ul>
      <?php foreach ($reminders as $index => $reminder): ?>
        <li>
          <?php echo "It is {$reminder['name']}'s birthday on {$reminder['date']}"; ?>
          <a href="?delete=<?php echo $index; ?>">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

</body>
</html>
