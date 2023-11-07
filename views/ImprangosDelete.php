<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$ImprangosDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { imprangos: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fimprangosdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fimprangosdelete")
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
<form name="fimprangosdelete" id="fimprangosdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="imprangos">
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
<?php if ($Page->codimp->Visible) { // codimp ?>
        <th class="<?= $Page->codimp->headerCellClass() ?>"><span id="elh_imprangos_codimp" class="imprangos_codimp"><?= $Page->codimp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <th class="<?= $Page->secuencia->headerCellClass() ?>"><span id="elh_imprangos_secuencia" class="imprangos_secuencia"><?= $Page->secuencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->monto_min->Visible) { // monto_min ?>
        <th class="<?= $Page->monto_min->headerCellClass() ?>"><span id="elh_imprangos_monto_min" class="imprangos_monto_min"><?= $Page->monto_min->caption() ?></span></th>
<?php } ?>
<?php if ($Page->monto_max->Visible) { // monto_max ?>
        <th class="<?= $Page->monto_max->headerCellClass() ?>"><span id="elh_imprangos_monto_max" class="imprangos_monto_max"><?= $Page->monto_max->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <th class="<?= $Page->porcentaje->headerCellClass() ?>"><span id="elh_imprangos_porcentaje" class="imprangos_porcentaje"><?= $Page->porcentaje->caption() ?></span></th>
<?php } ?>
<?php if ($Page->monto_fijo->Visible) { // monto_fijo ?>
        <th class="<?= $Page->monto_fijo->headerCellClass() ?>"><span id="elh_imprangos_monto_fijo" class="imprangos_monto_fijo"><?= $Page->monto_fijo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_imprangos_activo" class="imprangos_activo"><?= $Page->activo->caption() ?></span></th>
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
<?php if ($Page->codimp->Visible) { // codimp ?>
        <td<?= $Page->codimp->cellAttributes() ?>>
<span id="">
<span<?= $Page->codimp->viewAttributes() ?>>
<?= $Page->codimp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <td<?= $Page->secuencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->monto_min->Visible) { // monto_min ?>
        <td<?= $Page->monto_min->cellAttributes() ?>>
<span id="">
<span<?= $Page->monto_min->viewAttributes() ?>>
<?= $Page->monto_min->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->monto_max->Visible) { // monto_max ?>
        <td<?= $Page->monto_max->cellAttributes() ?>>
<span id="">
<span<?= $Page->monto_max->viewAttributes() ?>>
<?= $Page->monto_max->getViewValue() ?></span>
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
<?php if ($Page->monto_fijo->Visible) { // monto_fijo ?>
        <td<?= $Page->monto_fijo->cellAttributes() ?>>
<span id="">
<span<?= $Page->monto_fijo->viewAttributes() ?>>
<?= $Page->monto_fijo->getViewValue() ?></span>
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
