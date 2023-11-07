<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetfacDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detfac: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdetfacdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetfacdelete")
        .setPageId("delete")
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdetfacdelete" id="fdetfacdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="detfac">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->codnum->Visible) { // codnum ?>
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_detfac_codnum" class="detfac_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><span id="elh_detfac_tcomp" class="detfac_tcomp"><?= $Page->tcomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><span id="elh_detfac_serie" class="detfac_serie"><?= $Page->serie->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><span id="elh_detfac_ncomp" class="detfac_ncomp"><?= $Page->ncomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
        <th class="<?= $Page->nreng->headerCellClass() ?>"><span id="elh_detfac_nreng" class="detfac_nreng"><?= $Page->nreng->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><span id="elh_detfac_codrem" class="detfac_codrem"><?= $Page->codrem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codlote->Visible) { // codlote ?>
        <th class="<?= $Page->codlote->headerCellClass() ?>"><span id="elh_detfac_codlote" class="detfac_codlote"><?= $Page->codlote->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
        <th class="<?= $Page->descrip->headerCellClass() ?>"><span id="elh_detfac_descrip" class="detfac_descrip"><?= $Page->descrip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->neto->Visible) { // neto ?>
        <th class="<?= $Page->neto->headerCellClass() ?>"><span id="elh_detfac_neto" class="detfac_neto"><?= $Page->neto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bruto->Visible) { // bruto ?>
        <th class="<?= $Page->bruto->headerCellClass() ?>"><span id="elh_detfac_bruto" class="detfac_bruto"><?= $Page->bruto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->iva->Visible) { // iva ?>
        <th class="<?= $Page->iva->headerCellClass() ?>"><span id="elh_detfac_iva" class="detfac_iva"><?= $Page->iva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->imp->Visible) { // imp ?>
        <th class="<?= $Page->imp->headerCellClass() ?>"><span id="elh_detfac_imp" class="detfac_imp"><?= $Page->imp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->comcob->Visible) { // comcob ?>
        <th class="<?= $Page->comcob->headerCellClass() ?>"><span id="elh_detfac_comcob" class="detfac_comcob"><?= $Page->comcob->caption() ?></span></th>
<?php } ?>
<?php if ($Page->compag->Visible) { // compag ?>
        <th class="<?= $Page->compag->headerCellClass() ?>"><span id="elh_detfac_compag" class="detfac_compag"><?= $Page->compag->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><span id="elh_detfac_fechahora" class="detfac_fechahora"><?= $Page->fechahora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_detfac_usuario" class="detfac_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
        <th class="<?= $Page->porciva->headerCellClass() ?>"><span id="elh_detfac_porciva" class="detfac_porciva"><?= $Page->porciva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <th class="<?= $Page->tieneresol->headerCellClass() ?>"><span id="elh_detfac_tieneresol" class="detfac_tieneresol"><?= $Page->tieneresol->caption() ?></span></th>
<?php } ?>
<?php if ($Page->concafac->Visible) { // concafac ?>
        <th class="<?= $Page->concafac->headerCellClass() ?>"><span id="elh_detfac_concafac" class="detfac_concafac"><?= $Page->concafac->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomsal->Visible) { // tcomsal ?>
        <th class="<?= $Page->tcomsal->headerCellClass() ?>"><span id="elh_detfac_tcomsal" class="detfac_tcomsal"><?= $Page->tcomsal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
        <th class="<?= $Page->seriesal->headerCellClass() ?>"><span id="elh_detfac_seriesal" class="detfac_seriesal"><?= $Page->seriesal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <th class="<?= $Page->ncompsal->headerCellClass() ?>"><span id="elh_detfac_ncompsal" class="detfac_ncompsal"><?= $Page->ncompsal->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->codnum->Visible) { // codnum ?>
        <td<?= $Page->codnum->cellAttributes() ?>>
<span id="">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td<?= $Page->tcomp->cellAttributes() ?>>
<span id="">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <td<?= $Page->serie->cellAttributes() ?>>
<span id="">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td<?= $Page->ncomp->cellAttributes() ?>>
<span id="">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
        <td<?= $Page->nreng->cellAttributes() ?>>
<span id="">
<span<?= $Page->nreng->viewAttributes() ?>>
<?= $Page->nreng->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <td<?= $Page->codrem->cellAttributes() ?>>
<span id="">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codlote->Visible) { // codlote ?>
        <td<?= $Page->codlote->cellAttributes() ?>>
<span id="">
<span<?= $Page->codlote->viewAttributes() ?>>
<?= $Page->codlote->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
        <td<?= $Page->descrip->cellAttributes() ?>>
<span id="">
<span<?= $Page->descrip->viewAttributes() ?>>
<?= $Page->descrip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->neto->Visible) { // neto ?>
        <td<?= $Page->neto->cellAttributes() ?>>
<span id="">
<span<?= $Page->neto->viewAttributes() ?>>
<?= $Page->neto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bruto->Visible) { // bruto ?>
        <td<?= $Page->bruto->cellAttributes() ?>>
<span id="">
<span<?= $Page->bruto->viewAttributes() ?>>
<?= $Page->bruto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->iva->Visible) { // iva ?>
        <td<?= $Page->iva->cellAttributes() ?>>
<span id="">
<span<?= $Page->iva->viewAttributes() ?>>
<?= $Page->iva->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->imp->Visible) { // imp ?>
        <td<?= $Page->imp->cellAttributes() ?>>
<span id="">
<span<?= $Page->imp->viewAttributes() ?>>
<?= $Page->imp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->comcob->Visible) { // comcob ?>
        <td<?= $Page->comcob->cellAttributes() ?>>
<span id="">
<span<?= $Page->comcob->viewAttributes() ?>>
<?= $Page->comcob->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->compag->Visible) { // compag ?>
        <td<?= $Page->compag->cellAttributes() ?>>
<span id="">
<span<?= $Page->compag->viewAttributes() ?>>
<?= $Page->compag->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td<?= $Page->fechahora->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <td<?= $Page->usuario->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
        <td<?= $Page->porciva->cellAttributes() ?>>
<span id="">
<span<?= $Page->porciva->viewAttributes() ?>>
<?= $Page->porciva->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <td<?= $Page->tieneresol->cellAttributes() ?>>
<span id="">
<span<?= $Page->tieneresol->viewAttributes() ?>>
<?= $Page->tieneresol->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->concafac->Visible) { // concafac ?>
        <td<?= $Page->concafac->cellAttributes() ?>>
<span id="">
<span<?= $Page->concafac->viewAttributes() ?>>
<?= $Page->concafac->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tcomsal->Visible) { // tcomsal ?>
        <td<?= $Page->tcomsal->cellAttributes() ?>>
<span id="">
<span<?= $Page->tcomsal->viewAttributes() ?>>
<?= $Page->tcomsal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
        <td<?= $Page->seriesal->cellAttributes() ?>>
<span id="">
<span<?= $Page->seriesal->viewAttributes() ?>>
<?= $Page->seriesal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <td<?= $Page->ncompsal->cellAttributes() ?>>
<span id="">
<span<?= $Page->ncompsal->viewAttributes() ?>>
<?= $Page->ncompsal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
