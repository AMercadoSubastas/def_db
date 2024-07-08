<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CabreciboView = &$Page;
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
<form name="fcabreciboview" id="fcabreciboview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabrecibo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcabreciboview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcabreciboview")
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
<input type="hidden" name="t" value="cabrecibo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_cabrecibo_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <tr id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_tcomp"><?= $Page->tcomp->caption() ?></span></td>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_cabrecibo_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <tr id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_serie"><?= $Page->serie->caption() ?></span></td>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el_cabrecibo_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <tr id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_ncomp"><?= $Page->ncomp->caption() ?></span></td>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_cabrecibo_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cantcbtes->Visible) { // cantcbtes ?>
    <tr id="r_cantcbtes"<?= $Page->cantcbtes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_cantcbtes"><?= $Page->cantcbtes->caption() ?></span></td>
        <td data-name="cantcbtes"<?= $Page->cantcbtes->cellAttributes() ?>>
<span id="el_cabrecibo_cantcbtes">
<span<?= $Page->cantcbtes->viewAttributes() ?>>
<?= $Page->cantcbtes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_cabrecibo_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_cabrecibo_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <tr id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_fechahora"><?= $Page->fechahora->caption() ?></span></td>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_cabrecibo_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
    <tr id="r_cliente"<?= $Page->cliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_cliente"><?= $Page->cliente->caption() ?></span></td>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el_cabrecibo_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->imptot->Visible) { // imptot ?>
    <tr id="r_imptot"<?= $Page->imptot->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_imptot"><?= $Page->imptot->caption() ?></span></td>
        <td data-name="imptot"<?= $Page->imptot->cellAttributes() ?>>
<span id="el_cabrecibo_imptot">
<span<?= $Page->imptot->viewAttributes() ?>>
<?= $Page->imptot->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
    <tr id="r_emitido"<?= $Page->emitido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_emitido"><?= $Page->emitido->caption() ?></span></td>
        <td data-name="emitido"<?= $Page->emitido->cellAttributes() ?>>
<span id="el_cabrecibo_emitido">
<span<?= $Page->emitido->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_emitido_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->emitido->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->emitido->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_emitido_<?= $Page->RowCount ?>"></label>
</div>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
    <tr id="r_usuarioultmod"<?= $Page->usuarioultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></td>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el_cabrecibo_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
    <tr id="r_fecultmod"<?= $Page->fecultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabrecibo_fecultmod"><?= $Page->fecultmod->caption() ?></span></td>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el_cabrecibo_fecultmod">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("detrecibo", explode(",", $Page->getCurrentDetailTable())) && $detrecibo->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detrecibo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "DetreciboGrid.php" ?>
<?php } ?>
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
