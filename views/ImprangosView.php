<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$ImprangosView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<form name="fimprangosview" id="fimprangosview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { imprangos: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fimprangosview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fimprangosview")
        .setPageId("view")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="imprangos">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codimp->Visible) { // codimp ?>
    <tr id="r_codimp"<?= $Page->codimp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imprangos_codimp"><?= $Page->codimp->caption() ?></span></td>
        <td data-name="codimp"<?= $Page->codimp->cellAttributes() ?>>
<span id="el_imprangos_codimp">
<span<?= $Page->codimp->viewAttributes() ?>>
<?= $Page->codimp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
    <tr id="r_secuencia"<?= $Page->secuencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imprangos_secuencia"><?= $Page->secuencia->caption() ?></span></td>
        <td data-name="secuencia"<?= $Page->secuencia->cellAttributes() ?>>
<span id="el_imprangos_secuencia">
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto_min->Visible) { // monto_min ?>
    <tr id="r_monto_min"<?= $Page->monto_min->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imprangos_monto_min"><?= $Page->monto_min->caption() ?></span></td>
        <td data-name="monto_min"<?= $Page->monto_min->cellAttributes() ?>>
<span id="el_imprangos_monto_min">
<span<?= $Page->monto_min->viewAttributes() ?>>
<?= $Page->monto_min->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto_max->Visible) { // monto_max ?>
    <tr id="r_monto_max"<?= $Page->monto_max->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imprangos_monto_max"><?= $Page->monto_max->caption() ?></span></td>
        <td data-name="monto_max"<?= $Page->monto_max->cellAttributes() ?>>
<span id="el_imprangos_monto_max">
<span<?= $Page->monto_max->viewAttributes() ?>>
<?= $Page->monto_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
    <tr id="r_porcentaje"<?= $Page->porcentaje->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imprangos_porcentaje"><?= $Page->porcentaje->caption() ?></span></td>
        <td data-name="porcentaje"<?= $Page->porcentaje->cellAttributes() ?>>
<span id="el_imprangos_porcentaje">
<span<?= $Page->porcentaje->viewAttributes() ?>>
<?= $Page->porcentaje->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto_fijo->Visible) { // monto_fijo ?>
    <tr id="r_monto_fijo"<?= $Page->monto_fijo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imprangos_monto_fijo"><?= $Page->monto_fijo->caption() ?></span></td>
        <td data-name="monto_fijo"<?= $Page->monto_fijo->cellAttributes() ?>>
<span id="el_imprangos_monto_fijo">
<span<?= $Page->monto_fijo->viewAttributes() ?>>
<?= $Page->monto_fijo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <tr id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_imprangos_activo"><?= $Page->activo->caption() ?></span></td>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el_imprangos_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
