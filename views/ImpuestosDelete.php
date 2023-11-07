<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$ImpuestosDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { impuestos: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fimpuestosdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fimpuestosdelete")
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
<form name="fimpuestosdelete" id="fimpuestosdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="impuestos">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_impuestos_codnum" class="impuestos_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porcen->Visible) { // porcen ?>
        <th class="<?= $Page->porcen->headerCellClass() ?>"><span id="elh_impuestos_porcen" class="impuestos_porcen"><?= $Page->porcen->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><span id="elh_impuestos_descripcion" class="impuestos_descripcion"><?= $Page->descripcion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rangos->Visible) { // rangos ?>
        <th class="<?= $Page->rangos->headerCellClass() ?>"><span id="elh_impuestos_rangos" class="impuestos_rangos"><?= $Page->rangos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->montomin->Visible) { // montomin ?>
        <th class="<?= $Page->montomin->headerCellClass() ?>"><span id="elh_impuestos_montomin" class="impuestos_montomin"><?= $Page->montomin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_impuestos_activo" class="impuestos_activo"><?= $Page->activo->caption() ?></span></th>
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
<?php if ($Page->porcen->Visible) { // porcen ?>
        <td<?= $Page->porcen->cellAttributes() ?>>
<span id="">
<span<?= $Page->porcen->viewAttributes() ?>>
<?= $Page->porcen->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td<?= $Page->descripcion->cellAttributes() ?>>
<span id="">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rangos->Visible) { // rangos ?>
        <td<?= $Page->rangos->cellAttributes() ?>>
<span id="">
<span<?= $Page->rangos->viewAttributes() ?>>
<?= $Page->rangos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->montomin->Visible) { // montomin ?>
        <td<?= $Page->montomin->cellAttributes() ?>>
<span id="">
<span<?= $Page->montomin->viewAttributes() ?>>
<?= $Page->montomin->getViewValue() ?></span>
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
