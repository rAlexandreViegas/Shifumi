<?php

require_once __DIR__ . "/../controllers/Database.php";

use Database;

class Game
{
  private $choices = ["pierre", "papier", "ciseaux"];
  private $result = "";

  public function playGame($playerChoice)
  {
    $computerChoice = $this->getComputerChoice();
    $this->determineWinner($playerChoice, $computerChoice);
    $this->saveResultToDatabase($this->result, $playerChoice);
  }

  private function getComputerChoice()
  {
    return $this->choices[array_rand($this->choices)];
  }

  private function determineWinner($playerChoice, $computerChoice)
  {
    if ($playerChoice === $computerChoice) {
      $this->result = "Égalité";
    } elseif (
      ($playerChoice === "pierre" && $computerChoice === "ciseaux") ||
      ($playerChoice === "papier" && $computerChoice === "pierre") ||
      ($playerChoice === "ciseaux" && $computerChoice === "papier")
    ) {
      $this->result = "Gagné";
    } else {
      $this->result = "Perdu";
    }
  }

  private function saveResultToDatabase($result, $playerChoice)
  {
    try {
      $pdo = Database::getPDO();
      $query = "INSERT INTO history (result, playerChoice) VALUES (:result, :playerChoice)";

      $stmt = $pdo->prepare($query);
      $stmt->bindParam(":result", $result, PDO::PARAM_STR);
      $stmt->bindParam(":playerChoice", $playerChoice, PDO::PARAM_STR);
      $stmt->execute();
    } catch (PDOException $e) {
      echo "Erreur d'insertion dans la base de données : " . $e->getMessage();
    }
  }
}
