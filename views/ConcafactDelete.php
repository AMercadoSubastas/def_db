<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$ConcafactDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { concafact: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fconcafactdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fconcafactdelete")
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
<form name="fconcafactdelete" id="fconcafactdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="concafact">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_concafact_codnum" class="concafact_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nroconc->Visible) { // nroconc ?>
        <th class="<?= $Page->nroconc->headerCellClass() ?>"><span id="elh_concafact_nroconc" class="concafact_nroconc"><?= $Page->nroconc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
        <th class="<?= $Page->descrip->headerCellClass() ?>"><span id="elh_concafact_descrip" class="concafact_descrip"><?= $Page->descrip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <th class="<?= $Page->porcentaje->headerCellClass() ?>"><span id="elh_concafact_porcentaje" class="concafact_porcentaje"><?= $Page->porcentaje->caption() ?></span></th>
<?php } ?>
<?php if ($Page->importe->Visible) { // importe ?>
        <th class="<?= $Page->importe->headerCellClass() ?>"><span id="elh_concafact_importe" class="concafact_importe"><?= $Page->importe->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_concafact_usuario" class="concafact_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><span id="elh_concafact_fechahora" class="concafact_fechahora"><?= $Page->fechahora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_concafact_activo" class="concafact_activo"><?= $Page->activo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <th class="<?= $Page->tipoiva->headerCellClass() ?>"><span id="elh_concafact_tipoiva" class="concafact_tipoiva"><?= $Page->tipoiva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->impuesto->Visible) { // impuesto ?>
        <th class="<?= $Page->impuesto->headerCellClass() ?>"><span id="elh_concafact_impuesto" class="concafact_impuesto"><?= $Page->impuesto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <th class="<?= $Page->tieneresol->headerCellClass() ?>"><span id="elh_concafact_tieneresol" class="concafact_tieneresol"><?= $Page->tieneresol->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ctacbleBAS->Visible) { // ctacbleBAS ?>
        <th class="<?= $Page->ctacbleBAS->headerCellClass() ?>"><span id="elh_concafact_ctacbleBAS" class="concafact_ctacbleBAS"><?= $Page->ctacbleBAS->caption() ?></span></th>
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
<?php if ($Page->nroconc->Visible) { // nroconc ?>
        <td<?= $Page->nroconc->cellAttributes() ?>>
<span id="">
<span<?= $Page->nroconc->viewAttributes() ?>>
<?= $Page->nroconc->getViewValue() ?></span>
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
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <td<?= $Page->porcentaje->cellAttributes() ?>>
<span id="">
<span<?= $Page->porcentaje->viewAttributes() ?>>
<?= $Page->porcentaje->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->importe->Visible) { // importe ?>
        <td<?= $Page->importe->cellAttributes() ?>>
<span id="">
<span<?= $Page->importe->viewAttributes() ?>>
<?= $Page->importe->getViewValue() ?></span>
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
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td<?= $Page->fechahora->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <td<?= $Page->activo->cellAttributes() ?>>
<span id="">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <td<?= $Page->tipoiva->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->impuesto->Visible) { // impuesto ?>
        <td<?= $Page->impuesto->cellAttributes() ?>>
<span id="">
<span<?= $Page->impuesto->viewAttributes() ?>>
<?= $Page->impuesto->getViewValue() ?></span>
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
<?php if ($Page->ctacbleBAS->Visible) { // ctacbleBAS ?>
        <td<?= $Page->ctacbleBAS->cellAttributes() ?>>
<span id="">
<span<?= $Page->ctacbleBAS->viewAttributes() ?>>
<?= $Page->ctacbleBAS->getViewValue() ?></span>
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
