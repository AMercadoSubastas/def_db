<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$SeriesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { series: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fseriesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fseriesdelete")
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
<form name="fseriesdelete" id="fseriesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="series">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_series_codnum" class="series_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipcomp->Visible) { // tipcomp ?>
        <th class="<?= $Page->tipcomp->headerCellClass() ?>"><span id="elh_series_tipcomp" class="series_tipcomp"><?= $Page->tipcomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><span id="elh_series_descripcion" class="series_descripcion"><?= $Page->descripcion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nrodesde->Visible) { // nrodesde ?>
        <th class="<?= $Page->nrodesde->headerCellClass() ?>"><span id="elh_series_nrodesde" class="series_nrodesde"><?= $Page->nrodesde->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nrohasta->Visible) { // nrohasta ?>
        <th class="<?= $Page->nrohasta->headerCellClass() ?>"><span id="elh_series_nrohasta" class="series_nrohasta"><?= $Page->nrohasta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nroact->Visible) { // nroact ?>
        <th class="<?= $Page->nroact->headerCellClass() ?>"><span id="elh_series_nroact" class="series_nroact"><?= $Page->nroact->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mascara->Visible) { // mascara ?>
        <th class="<?= $Page->mascara->headerCellClass() ?>"><span id="elh_series_mascara" class="series_mascara"><?= $Page->mascara->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_series_activo" class="series_activo"><?= $Page->activo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->automatica->Visible) { // automatica ?>
        <th class="<?= $Page->automatica->headerCellClass() ?>"><span id="elh_series_automatica" class="series_automatica"><?= $Page->automatica->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechatope->Visible) { // fechatope ?>
        <th class="<?= $Page->fechatope->headerCellClass() ?>"><span id="elh_series_fechatope" class="series_fechatope"><?= $Page->fechatope->caption() ?></span></th>
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
<?php if ($Page->tipcomp->Visible) { // tipcomp ?>
        <td<?= $Page->tipcomp->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipcomp->viewAttributes() ?>>
<?= $Page->tipcomp->getViewValue() ?></span>
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
<?php if ($Page->nrodesde->Visible) { // nrodesde ?>
        <td<?= $Page->nrodesde->cellAttributes() ?>>
<span id="">
<span<?= $Page->nrodesde->viewAttributes() ?>>
<?= $Page->nrodesde->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nrohasta->Visible) { // nrohasta ?>
        <td<?= $Page->nrohasta->cellAttributes() ?>>
<span id="">
<span<?= $Page->nrohasta->viewAttributes() ?>>
<?= $Page->nrohasta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nroact->Visible) { // nroact ?>
        <td<?= $Page->nroact->cellAttributes() ?>>
<span id="">
<span<?= $Page->nroact->viewAttributes() ?>>
<?= $Page->nroact->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mascara->Visible) { // mascara ?>
        <td<?= $Page->mascara->cellAttributes() ?>>
<span id="">
<span<?= $Page->mascara->viewAttributes() ?>>
<?= $Page->mascara->getViewValue() ?></span>
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
<?php if ($Page->automatica->Visible) { // automatica ?>
        <td<?= $Page->automatica->cellAttributes() ?>>
<span id="">
<span<?= $Page->automatica->viewAttributes() ?>>
<?= $Page->automatica->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechatope->Visible) { // fechatope ?>
        <td<?= $Page->fechatope->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechatope->viewAttributes() ?>>
<?= $Page->fechatope->getViewValue() ?></span>
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
