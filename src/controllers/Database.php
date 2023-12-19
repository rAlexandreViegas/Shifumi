<?php

use PDO;
use PDOException;

class Database
{
  private static $host = "localhost";
  private static $dbname = "shifumi";
  private static $username = "root";
  private static $password = "";
  private static $charset = "utf8mb4";
  private static $pdo;

  public static function getPDO(): PDO
  {
    if (!isset(self::$pdo)) {
      try {
        self::$pdo = new PDO(
          "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset,
          self::$username,
          self::$password,
          [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
          ]
        );
      } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
      }
    }

    return self::$pdo;
  }

  public static function getHistory()
  {
    try {
      $pdo = Database::getPDO();
      $query = "SELECT * FROM history ORDER BY id DESC LIMIT 6";
      $stmt = $pdo->query($query);
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    } catch (PDOException $e) {
      echo "Erreur lors de la récupération de l'historique : " . $e->getMessage();
    }
  }

  public static function getLastResult()
  {
    try {
      $pdo = Database::getPDO();
      $query = "SELECT id FROM history ORDER BY id DESC LIMIT 1";
      $stmt = $pdo->query($query);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if (empty($result)) {
        $pdo->exec("ALTER TABLE history AUTO_INCREMENT = 1");
        return 1;
      } else {
        return $result["id"] + 1;
      }
    } catch (PDOException $e) {
      echo "Erreur lors de la récupération du dernier resultat : " . $e->getMessage();
    }
  }

  public static function resetHistory()
  {
    try {
      $pdo = Database::getPDO();
      $pdo->exec("DELETE FROM history");
    } catch (PDOException $e) {
      echo "Erreur lors de la suppression de l'historique : " . $e->getMessage();
    }
  }
}
