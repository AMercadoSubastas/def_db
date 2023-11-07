<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetreciboDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detrecibo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdetrecibodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetrecibodelete")
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
<form name="fdetrecibodelete" id="fdetrecibodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="detrecibo">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_detrecibo_codnum" class="detrecibo_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><span id="elh_detrecibo_tcomp" class="detrecibo_tcomp"><?= $Page->tcomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><span id="elh_detrecibo_serie" class="detrecibo_serie"><?= $Page->serie->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><span id="elh_detrecibo_ncomp" class="detrecibo_ncomp"><?= $Page->ncomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
        <th class="<?= $Page->nreng->headerCellClass() ?>"><span id="elh_detrecibo_nreng" class="detrecibo_nreng"><?= $Page->nreng->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <th class="<?= $Page->tcomprel->headerCellClass() ?>"><span id="elh_detrecibo_tcomprel" class="detrecibo_tcomprel"><?= $Page->tcomprel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
        <th class="<?= $Page->serierel->headerCellClass() ?>"><span id="elh_detrecibo_serierel" class="detrecibo_serierel"><?= $Page->serierel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <th class="<?= $Page->ncomprel->headerCellClass() ?>"><span id="elh_detrecibo_ncomprel" class="detrecibo_ncomprel"><?= $Page->ncomprel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->netocbterel->Visible) { // netocbterel ?>
        <th class="<?= $Page->netocbterel->headerCellClass() ?>"><span id="elh_detrecibo_netocbterel" class="detrecibo_netocbterel"><?= $Page->netocbterel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_detrecibo_usuario" class="detrecibo_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><span id="elh_detrecibo_fechahora" class="detrecibo_fechahora"><?= $Page->fechahora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <th class="<?= $Page->nrodoc->headerCellClass() ?>"><span id="elh_detrecibo_nrodoc" class="detrecibo_nrodoc"><?= $Page->nrodoc->caption() ?></span></th>
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
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <td<?= $Page->tcomprel->cellAttributes() ?>>
<span id="">
<span<?= $Page->tcomprel->viewAttributes() ?>>
<?= $Page->tcomprel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
        <td<?= $Page->serierel->cellAttributes() ?>>
<span id="">
<span<?= $Page->serierel->viewAttributes() ?>>
<?= $Page->serierel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <td<?= $Page->ncomprel->cellAttributes() ?>>
<span id="">
<span<?= $Page->ncomprel->viewAttributes() ?>>
<?= $Page->ncomprel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->netocbterel->Visible) { // netocbterel ?>
        <td<?= $Page->netocbterel->cellAttributes() ?>>
<span id="">
<span<?= $Page->netocbterel->viewAttributes() ?>>
<?= $Page->netocbterel->getViewValue() ?></span>
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
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <td<?= $Page->nrodoc->cellAttributes() ?>>
<span id="">
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
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
