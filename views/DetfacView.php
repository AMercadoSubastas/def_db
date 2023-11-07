<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetfacView = &$Page;
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
<form name="fdetfacview" id="fdetfacview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detfac: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdetfacview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetfacview")
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
<input type="hidden" name="t" value="detfac">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_detfac_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <tr id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_tcomp"><?= $Page->tcomp->caption() ?></span></td>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_detfac_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <tr id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_serie"><?= $Page->serie->caption() ?></span></td>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el_detfac_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <tr id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_ncomp"><?= $Page->ncomp->caption() ?></span></td>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_detfac_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
    <tr id="r_nreng"<?= $Page->nreng->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_nreng"><?= $Page->nreng->caption() ?></span></td>
        <td data-name="nreng"<?= $Page->nreng->cellAttributes() ?>>
<span id="el_detfac_nreng">
<span<?= $Page->nreng->viewAttributes() ?>>
<?= $Page->nreng->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <tr id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_codrem"><?= $Page->codrem->caption() ?></span></td>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el_detfac_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codlote->Visible) { // codlote ?>
    <tr id="r_codlote"<?= $Page->codlote->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_codlote"><?= $Page->codlote->caption() ?></span></td>
        <td data-name="codlote"<?= $Page->codlote->cellAttributes() ?>>
<span id="el_detfac_codlote">
<span<?= $Page->codlote->viewAttributes() ?>>
<?= $Page->codlote->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
    <tr id="r_descrip"<?= $Page->descrip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_descrip"><?= $Page->descrip->caption() ?></span></td>
        <td data-name="descrip"<?= $Page->descrip->cellAttributes() ?>>
<span id="el_detfac_descrip">
<span<?= $Page->descrip->viewAttributes() ?>>
<?= $Page->descrip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->neto->Visible) { // neto ?>
    <tr id="r_neto"<?= $Page->neto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_neto"><?= $Page->neto->caption() ?></span></td>
        <td data-name="neto"<?= $Page->neto->cellAttributes() ?>>
<span id="el_detfac_neto">
<span<?= $Page->neto->viewAttributes() ?>>
<?= $Page->neto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bruto->Visible) { // bruto ?>
    <tr id="r_bruto"<?= $Page->bruto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_bruto"><?= $Page->bruto->caption() ?></span></td>
        <td data-name="bruto"<?= $Page->bruto->cellAttributes() ?>>
<span id="el_detfac_bruto">
<span<?= $Page->bruto->viewAttributes() ?>>
<?= $Page->bruto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->iva->Visible) { // iva ?>
    <tr id="r_iva"<?= $Page->iva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_iva"><?= $Page->iva->caption() ?></span></td>
        <td data-name="iva"<?= $Page->iva->cellAttributes() ?>>
<span id="el_detfac_iva">
<span<?= $Page->iva->viewAttributes() ?>>
<?= $Page->iva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->imp->Visible) { // imp ?>
    <tr id="r_imp"<?= $Page->imp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_imp"><?= $Page->imp->caption() ?></span></td>
        <td data-name="imp"<?= $Page->imp->cellAttributes() ?>>
<span id="el_detfac_imp">
<span<?= $Page->imp->viewAttributes() ?>>
<?= $Page->imp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comcob->Visible) { // comcob ?>
    <tr id="r_comcob"<?= $Page->comcob->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_comcob"><?= $Page->comcob->caption() ?></span></td>
        <td data-name="comcob"<?= $Page->comcob->cellAttributes() ?>>
<span id="el_detfac_comcob">
<span<?= $Page->comcob->viewAttributes() ?>>
<?= $Page->comcob->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->compag->Visible) { // compag ?>
    <tr id="r_compag"<?= $Page->compag->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_compag"><?= $Page->compag->caption() ?></span></td>
        <td data-name="compag"<?= $Page->compag->cellAttributes() ?>>
<span id="el_detfac_compag">
<span<?= $Page->compag->viewAttributes() ?>>
<?= $Page->compag->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <tr id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_fechahora"><?= $Page->fechahora->caption() ?></span></td>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_detfac_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_detfac_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
    <tr id="r_porciva"<?= $Page->porciva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_porciva"><?= $Page->porciva->caption() ?></span></td>
        <td data-name="porciva"<?= $Page->porciva->cellAttributes() ?>>
<span id="el_detfac_porciva">
<span<?= $Page->porciva->viewAttributes() ?>>
<?= $Page->porciva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
    <tr id="r_tieneresol"<?= $Page->tieneresol->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_tieneresol"><?= $Page->tieneresol->caption() ?></span></td>
        <td data-name="tieneresol"<?= $Page->tieneresol->cellAttributes() ?>>
<span id="el_detfac_tieneresol">
<span<?= $Page->tieneresol->viewAttributes() ?>>
<?= $Page->tieneresol->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->concafac->Visible) { // concafac ?>
    <tr id="r_concafac"<?= $Page->concafac->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_concafac"><?= $Page->concafac->caption() ?></span></td>
        <td data-name="concafac"<?= $Page->concafac->cellAttributes() ?>>
<span id="el_detfac_concafac">
<span<?= $Page->concafac->viewAttributes() ?>>
<?= $Page->concafac->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomsal->Visible) { // tcomsal ?>
    <tr id="r_tcomsal"<?= $Page->tcomsal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_tcomsal"><?= $Page->tcomsal->caption() ?></span></td>
        <td data-name="tcomsal"<?= $Page->tcomsal->cellAttributes() ?>>
<span id="el_detfac_tcomsal">
<span<?= $Page->tcomsal->viewAttributes() ?>>
<?= $Page->tcomsal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
    <tr id="r_seriesal"<?= $Page->seriesal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_seriesal"><?= $Page->seriesal->caption() ?></span></td>
        <td data-name="seriesal"<?= $Page->seriesal->cellAttributes() ?>>
<span id="el_detfac_seriesal">
<span<?= $Page->seriesal->viewAttributes() ?>>
<?= $Page->seriesal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
    <tr id="r_ncompsal"<?= $Page->ncompsal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detfac_ncompsal"><?= $Page->ncompsal->caption() ?></span></td>
        <td data-name="ncompsal"<?= $Page->ncompsal->cellAttributes() ?>>
<span id="el_detfac_ncompsal">
<span<?= $Page->ncompsal->viewAttributes() ?>>
<?= $Page->ncompsal->getViewValue() ?></span>
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
