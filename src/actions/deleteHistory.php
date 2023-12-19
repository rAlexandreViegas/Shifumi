<?php

require_once __DIR__ . '/../controllers/Database.php';

use Database;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["reset"])) {
  Database::resetHistory();
  header("Location: index.php");
  exit();
}
