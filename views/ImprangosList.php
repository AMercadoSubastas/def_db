<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$ImprangosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { imprangos: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
ew.PREVIEW_SELECTOR ??= ".ew-preview-btn";
ew.PREVIEW_TYPE ??= "row";
ew.PREVIEW_NAV_STYLE ??= "tabs"; // tabs/pills/underline
ew.PREVIEW_MODAL_CLASS ??= "modal modal-fullscreen-sm-down";
ew.PREVIEW_ROW ??= true;
ew.PREVIEW_SINGLE_ROW ??= false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=24.13.0", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="imprangos">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_imprangos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_imprangoslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->codimp->Visible) { // codimp ?>
        <th data-name="codimp" class="<?= $Page->codimp->headerCellClass() ?>"><div id="elh_imprangos_codimp" class="imprangos_codimp"><?= $Page->renderFieldHeader($Page->codimp) ?></div></th>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <th data-name="secuencia" class="<?= $Page->secuencia->headerCellClass() ?>"><div id="elh_imprangos_secuencia" class="imprangos_secuencia"><?= $Page->renderFieldHeader($Page->secuencia) ?></div></th>
<?php } ?>
<?php if ($Page->monto_min->Visible) { // monto_min ?>
        <th data-name="monto_min" class="<?= $Page->monto_min->headerCellClass() ?>"><div id="elh_imprangos_monto_min" class="imprangos_monto_min"><?= $Page->renderFieldHeader($Page->monto_min) ?></div></th>
<?php } ?>
<?php if ($Page->monto_max->Visible) { // monto_max ?>
        <th data-name="monto_max" class="<?= $Page->monto_max->headerCellClass() ?>"><div id="elh_imprangos_monto_max" class="imprangos_monto_max"><?= $Page->renderFieldHeader($Page->monto_max) ?></div></th>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <th data-name="porcentaje" class="<?= $Page->porcentaje->headerCellClass() ?>"><div id="elh_imprangos_porcentaje" class="imprangos_porcentaje"><?= $Page->renderFieldHeader($Page->porcentaje) ?></div></th>
<?php } ?>
<?php if ($Page->monto_fijo->Visible) { // monto_fijo ?>
        <th data-name="monto_fijo" class="<?= $Page->monto_fijo->headerCellClass() ?>"><div id="elh_imprangos_monto_fijo" class="imprangos_monto_fijo"><?= $Page->renderFieldHeader($Page->monto_fijo) ?></div></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th data-name="activo" class="<?= $Page->activo->headerCellClass() ?>"><div id="elh_imprangos_activo" class="imprangos_activo"><?= $Page->renderFieldHeader($Page->activo) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->codimp->Visible) { // codimp ?>
        <td data-name="codimp"<?= $Page->codimp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_imprangos_codimp" class="el_imprangos_codimp">
<span<?= $Page->codimp->viewAttributes() ?>>
<?= $Page->codimp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->secuencia->Visible) { // secuencia ?>
        <td data-name="secuencia"<?= $Page->secuencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_imprangos_secuencia" class="el_imprangos_secuencia">
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->monto_min->Visible) { // monto_min ?>
        <td data-name="monto_min"<?= $Page->monto_min->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_imprangos_monto_min" class="el_imprangos_monto_min">
<span<?= $Page->monto_min->viewAttributes() ?>>
<?= $Page->monto_min->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->monto_max->Visible) { // monto_max ?>
        <td data-name="monto_max"<?= $Page->monto_max->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_imprangos_monto_max" class="el_imprangos_monto_max">
<span<?= $Page->monto_max->viewAttributes() ?>>
<?= $Page->monto_max->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <td data-name="porcentaje"<?= $Page->porcentaje->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_imprangos_porcentaje" class="el_imprangos_porcentaje">
<span<?= $Page->porcentaje->viewAttributes() ?>>
<?= $Page->porcentaje->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->monto_fijo->Visible) { // monto_fijo ?>
        <td data-name="monto_fijo"<?= $Page->monto_fijo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_imprangos_monto_fijo" class="el_imprangos_monto_fijo">
<span<?= $Page->monto_fijo->viewAttributes() ?>>
<?= $Page->monto_fijo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->activo->Visible) { // activo ?>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_imprangos_activo" class="el_imprangos_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("imprangos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
