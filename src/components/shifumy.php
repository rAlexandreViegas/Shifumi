<?php

require_once __DIR__ . '/../controllers/Database.php';
require_once __DIR__ . '/../actions/playGame.php';

use Database;

include __DIR__ . "/../../templates/shifumi.html.php";

?>

<p>Partie n°<?= Database::getLastResult() ?></p>

<?php

include __DIR__ . "/../../templates/_partials/choice-btn.html.php";
