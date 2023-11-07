<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DirRematesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dir_remates: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdir_rematesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdir_rematesdelete")
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
<form name="fdir_rematesdelete" id="fdir_rematesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="dir_remates">
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
<?php if ($Page->codigo->Visible) { // codigo ?>
        <th class="<?= $Page->codigo->headerCellClass() ?>"><span id="elh_dir_remates_codigo" class="dir_remates_codigo"><?= $Page->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><span id="elh_dir_remates_codrem" class="dir_remates_codrem"><?= $Page->codrem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <th class="<?= $Page->secuencia->headerCellClass() ?>"><span id="elh_dir_remates_secuencia" class="dir_remates_secuencia"><?= $Page->secuencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
        <th class="<?= $Page->direccion->headerCellClass() ?>"><span id="elh_dir_remates_direccion" class="dir_remates_direccion"><?= $Page->direccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th class="<?= $Page->codpais->headerCellClass() ?>"><span id="elh_dir_remates_codpais" class="dir_remates_codpais"><?= $Page->codpais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th class="<?= $Page->codprov->headerCellClass() ?>"><span id="elh_dir_remates_codprov" class="dir_remates_codprov"><?= $Page->codprov->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th class="<?= $Page->codloc->headerCellClass() ?>"><span id="elh_dir_remates_codloc" class="dir_remates_codloc"><?= $Page->codloc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuarioalta->Visible) { // usuarioalta ?>
        <th class="<?= $Page->usuarioalta->headerCellClass() ?>"><span id="elh_dir_remates_usuarioalta" class="dir_remates_usuarioalta"><?= $Page->usuarioalta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaalta->Visible) { // fechaalta ?>
        <th class="<?= $Page->fechaalta->headerCellClass() ?>"><span id="elh_dir_remates_fechaalta" class="dir_remates_fechaalta"><?= $Page->fechaalta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuariomod->Visible) { // usuariomod ?>
        <th class="<?= $Page->usuariomod->headerCellClass() ?>"><span id="elh_dir_remates_usuariomod" class="dir_remates_usuariomod"><?= $Page->usuariomod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
        <th class="<?= $Page->fechaultmod->headerCellClass() ?>"><span id="elh_dir_remates_fechaultmod" class="dir_remates_fechaultmod"><?= $Page->fechaultmod->caption() ?></span></th>
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
<?php if ($Page->codigo->Visible) { // codigo ?>
        <td<?= $Page->codigo->cellAttributes() ?>>
<span id="">
<span<?= $Page->codigo->viewAttributes() ?>>
<?= $Page->codigo->getViewValue() ?></span>
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
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <td<?= $Page->secuencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
        <td<?= $Page->direccion->cellAttributes() ?>>
<span id="">
<span<?= $Page->direccion->viewAttributes() ?>>
<?= $Page->direccion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <td<?= $Page->codpais->cellAttributes() ?>>
<span id="">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <td<?= $Page->codprov->cellAttributes() ?>>
<span id="">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <td<?= $Page->codloc->cellAttributes() ?>>
<span id="">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
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
