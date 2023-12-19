<?php

require_once __DIR__ . '/../controllers/Database.php';
require_once __DIR__ . '/../actions/deleteHistory.php';

use Database;

$results = Database::getHistory();

include __DIR__ . '/../../templates/history.html.php';

foreach ($results as $result) {
  echo "
    <div class='result'>
      <p>" . $result['result'] . "</p>
      <p>" . ucfirst($result['playerChoice']) . "</p>
    </div>
  ";
}

include __DIR__ . '/../../templates/_partials/reset-btn.html.php';
