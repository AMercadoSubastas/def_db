<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$TipcompDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipcomp: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var ftipcompdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipcompdelete")
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
<form name="ftipcompdelete" id="ftipcompdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tipcomp">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_tipcomp_codnum" class="tipcomp_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><span id="elh_tipcomp_descripcion" class="tipcomp_descripcion"><?= $Page->descripcion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_tipcomp_activo" class="tipcomp_activo"><?= $Page->activo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->esfactura->Visible) { // esfactura ?>
        <th class="<?= $Page->esfactura->headerCellClass() ?>"><span id="elh_tipcomp_esfactura" class="tipcomp_esfactura"><?= $Page->esfactura->caption() ?></span></th>
<?php } ?>
<?php if ($Page->esprovedor->Visible) { // esprovedor ?>
        <th class="<?= $Page->esprovedor->headerCellClass() ?>"><span id="elh_tipcomp_esprovedor" class="tipcomp_esprovedor"><?= $Page->esprovedor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codafip->Visible) { // codafip ?>
        <th class="<?= $Page->codafip->headerCellClass() ?>"><span id="elh_tipcomp_codafip" class="tipcomp_codafip"><?= $Page->codafip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuarioalta->Visible) { // usuarioalta ?>
        <th class="<?= $Page->usuarioalta->headerCellClass() ?>"><span id="elh_tipcomp_usuarioalta" class="tipcomp_usuarioalta"><?= $Page->usuarioalta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaalta->Visible) { // fechaalta ?>
        <th class="<?= $Page->fechaalta->headerCellClass() ?>"><span id="elh_tipcomp_fechaalta" class="tipcomp_fechaalta"><?= $Page->fechaalta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuariomod->Visible) { // usuariomod ?>
        <th class="<?= $Page->usuariomod->headerCellClass() ?>"><span id="elh_tipcomp_usuariomod" class="tipcomp_usuariomod"><?= $Page->usuariomod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
        <th class="<?= $Page->fechaultmod->headerCellClass() ?>"><span id="elh_tipcomp_fechaultmod" class="tipcomp_fechaultmod"><?= $Page->fechaultmod->caption() ?></span></th>
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
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td<?= $Page->descripcion->cellAttributes() ?>>
<span id="">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
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
<?php if ($Page->esfactura->Visible) { // esfactura ?>
        <td<?= $Page->esfactura->cellAttributes() ?>>
<span id="">
<span<?= $Page->esfactura->viewAttributes() ?>>
<?= $Page->esfactura->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->esprovedor->Visible) { // esprovedor ?>
        <td<?= $Page->esprovedor->cellAttributes() ?>>
<span id="">
<span<?= $Page->esprovedor->viewAttributes() ?>>
<?= $Page->esprovedor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codafip->Visible) { // codafip ?>
        <td<?= $Page->codafip->cellAttributes() ?>>
<span id="">
<span<?= $Page->codafip->viewAttributes() ?>>
<?= $Page->codafip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuarioalta->Visible) { // usuarioalta ?>
        <td<?= $Page->usuarioalta->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuarioalta->viewAttributes() ?>>
<?= $Page->usuarioalta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechaalta->Visible) { // fechaalta ?>
        <td<?= $Page->fechaalta->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechaalta->viewAttributes() ?>>
<?= $Page->fechaalta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuariomod->Visible) { // usuariomod ?>
        <td<?= $Page->usuariomod->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuariomod->viewAttributes() ?>>
<?= $Page->usuariomod->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
        <td<?= $Page->fechaultmod->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechaultmod->viewAttributes() ?>>
<?= $Page->fechaultmod->getViewValue() ?></span>
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
