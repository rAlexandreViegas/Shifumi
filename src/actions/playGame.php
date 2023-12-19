<?php

require_once __DIR__ . "/../class/Game.php";

$game = new Game();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["choice"])) {
  $playerChoice = $_POST["choice"];
  $game->playGame($playerChoice);

  header("Location: index.php");
  exit();
}
