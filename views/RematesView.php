<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$RematesView = &$Page;
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
<form name="frematesview" id="frematesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { remates: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var frematesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frematesview")
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
<input type="hidden" name="t" value="remates">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <tr id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_ncomp"><?= $Page->ncomp->caption() ?></span></td>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_remates_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <tr id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_tcomp"><?= $Page->tcomp->caption() ?></span></td>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_remates_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <tr id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_serie"><?= $Page->serie->caption() ?></span></td>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el_remates_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
    <tr id="r_codcli"<?= $Page->codcli->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_codcli"><?= $Page->codcli->caption() ?></span></td>
        <td data-name="codcli"<?= $Page->codcli->cellAttributes() ?>>
<span id="el_remates_codcli">
<span<?= $Page->codcli->viewAttributes() ?>>
<?= $Page->codcli->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <tr id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_direccion"><?= $Page->direccion->caption() ?></span></td>
        <td data-name="direccion"<?= $Page->direccion->cellAttributes() ?>>
<span id="el_remates_direccion">
<span<?= $Page->direccion->viewAttributes() ?>>
<?= $Page->direccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <tr id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_codpais"><?= $Page->codpais->caption() ?></span></td>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el_remates_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
    <tr id="r_codprov"<?= $Page->codprov->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_codprov"><?= $Page->codprov->caption() ?></span></td>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el_remates_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
    <tr id="r_codloc"<?= $Page->codloc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_codloc"><?= $Page->codloc->caption() ?></span></td>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el_remates_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecest->Visible) { // fecest ?>
    <tr id="r_fecest"<?= $Page->fecest->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_fecest"><?= $Page->fecest->caption() ?></span></td>
        <td data-name="fecest"<?= $Page->fecest->cellAttributes() ?>>
<span id="el_remates_fecest">
<span<?= $Page->fecest->viewAttributes() ?>>
<?= $Page->fecest->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecreal->Visible) { // fecreal ?>
    <tr id="r_fecreal"<?= $Page->fecreal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_fecreal"><?= $Page->fecreal->caption() ?></span></td>
        <td data-name="fecreal"<?= $Page->fecreal->cellAttributes() ?>>
<span id="el_remates_fecreal">
<span<?= $Page->fecreal->viewAttributes() ?>>
<?= $Page->fecreal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->imptot->Visible) { // imptot ?>
    <tr id="r_imptot"<?= $Page->imptot->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_imptot"><?= $Page->imptot->caption() ?></span></td>
        <td data-name="imptot"<?= $Page->imptot->cellAttributes() ?>>
<span id="el_remates_imptot">
<span<?= $Page->imptot->viewAttributes() ?>>
<?= $Page->imptot->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->impbase->Visible) { // impbase ?>
    <tr id="r_impbase"<?= $Page->impbase->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_impbase"><?= $Page->impbase->caption() ?></span></td>
        <td data-name="impbase"<?= $Page->impbase->cellAttributes() ?>>
<span id="el_remates_impbase">
<span<?= $Page->impbase->viewAttributes() ?>>
<?= $Page->impbase->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_estado"><?= $Page->estado->caption() ?></span></td>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el_remates_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cantlotes->Visible) { // cantlotes ?>
    <tr id="r_cantlotes"<?= $Page->cantlotes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_cantlotes"><?= $Page->cantlotes->caption() ?></span></td>
        <td data-name="cantlotes"<?= $Page->cantlotes->cellAttributes() ?>>
<span id="el_remates_cantlotes">
<span<?= $Page->cantlotes->viewAttributes() ?>>
<?= $Page->cantlotes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->horaest->Visible) { // horaest ?>
    <tr id="r_horaest"<?= $Page->horaest->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_horaest"><?= $Page->horaest->caption() ?></span></td>
        <td data-name="horaest"<?= $Page->horaest->cellAttributes() ?>>
<span id="el_remates_horaest">
<span<?= $Page->horaest->viewAttributes() ?>>
<?= $Page->horaest->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->horareal->Visible) { // horareal ?>
    <tr id="r_horareal"<?= $Page->horareal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_horareal"><?= $Page->horareal->caption() ?></span></td>
        <td data-name="horareal"<?= $Page->horareal->cellAttributes() ?>>
<span id="el_remates_horareal">
<span<?= $Page->horareal->viewAttributes() ?>>
<?= $Page->horareal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_remates_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
    <tr id="r_fecalta"<?= $Page->fecalta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_fecalta"><?= $Page->fecalta->caption() ?></span></td>
        <td data-name="fecalta"<?= $Page->fecalta->cellAttributes() ?>>
<span id="el_remates_fecalta">
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->observacion->Visible) { // observacion ?>
    <tr id="r_observacion"<?= $Page->observacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_observacion"><?= $Page->observacion->caption() ?></span></td>
        <td data-name="observacion"<?= $Page->observacion->cellAttributes() ?>>
<span id="el_remates_observacion">
<span<?= $Page->observacion->viewAttributes() ?>>
<?= $Page->observacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
    <tr id="r_tipoind"<?= $Page->tipoind->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_tipoind"><?= $Page->tipoind->caption() ?></span></td>
        <td data-name="tipoind"<?= $Page->tipoind->cellAttributes() ?>>
<span id="el_remates_tipoind">
<span<?= $Page->tipoind->viewAttributes() ?>>
<?= $Page->tipoind->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sello->Visible) { // sello ?>
    <tr id="r_sello"<?= $Page->sello->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_sello"><?= $Page->sello->caption() ?></span></td>
        <td data-name="sello"<?= $Page->sello->cellAttributes() ?>>
<span id="el_remates_sello">
<span<?= $Page->sello->viewAttributes() ?>>
<?= $Page->sello->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->plazoSAP->Visible) { // plazoSAP ?>
    <tr id="r_plazoSAP"<?= $Page->plazoSAP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_plazoSAP"><?= $Page->plazoSAP->caption() ?></span></td>
        <td data-name="plazoSAP"<?= $Page->plazoSAP->cellAttributes() ?>>
<span id="el_remates_plazoSAP">
<span<?= $Page->plazoSAP->viewAttributes() ?>>
<?= $Page->plazoSAP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
    <tr id="r_usuarioultmod"<?= $Page->usuarioultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></td>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el_remates_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
    <tr id="r_fecultmod"<?= $Page->fecultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_fecultmod"><?= $Page->fecultmod->caption() ?></span></td>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el_remates_fecultmod">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicios->Visible) { // servicios ?>
    <tr id="r_servicios"<?= $Page->servicios->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_servicios"><?= $Page->servicios->caption() ?></span></td>
        <td data-name="servicios"<?= $Page->servicios->cellAttributes() ?>>
<span id="el_remates_servicios">
<span<?= $Page->servicios->viewAttributes() ?>>
<?= $Page->servicios->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gastos->Visible) { // gastos ?>
    <tr id="r_gastos"<?= $Page->gastos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_gastos"><?= $Page->gastos->caption() ?></span></td>
        <td data-name="gastos"<?= $Page->gastos->cellAttributes() ?>>
<span id="el_remates_gastos">
<span<?= $Page->gastos->viewAttributes() ?>>
<?= $Page->gastos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <tr id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_remates_tasa"><?= $Page->tasa->caption() ?></span></td>
        <td data-name="tasa"<?= $Page->tasa->cellAttributes() ?>>
<span id="el_remates_tasa">
<span<?= $Page->tasa->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_tasa_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->tasa->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->tasa->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_tasa_<?= $Page->RowCount ?>"></label>
</div>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("lotes", explode(",", $Page->getCurrentDetailTable())) && $lotes->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("lotes", "TblCaption") ?>&nbsp;<?= str_replace("%s", "white", str_replace("%c", Container("lotes")->Count, $Language->phrase("DetailCount"))) ?></h4>
<?php } ?>
<?php include_once "LotesGrid.php" ?>
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
