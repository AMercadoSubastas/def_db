<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LCiticompras = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php include_once "lista_citicompras_xls.php"; // Includes an external file ?>

<?= GetDebugMessage() ?>
