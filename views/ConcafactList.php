<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$ConcafactList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { concafact: currentTable } });
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fconcafactsrch" id="fconcafactsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="fconcafactsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { concafact: currentTable } });
var currentForm;
var fconcafactsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fconcafactsrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)

        // Init search panel as collapsed
        .setInitSearchPanel(true)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fconcafactsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fconcafactsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fconcafactsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fconcafactsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
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
<input type="hidden" name="t" value="concafact">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_concafact" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_concafactlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->codnum->Visible) { // codnum ?>
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_concafact_codnum" class="concafact_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->nroconc->Visible) { // nroconc ?>
        <th data-name="nroconc" class="<?= $Page->nroconc->headerCellClass() ?>"><div id="elh_concafact_nroconc" class="concafact_nroconc"><?= $Page->renderFieldHeader($Page->nroconc) ?></div></th>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
        <th data-name="descrip" class="<?= $Page->descrip->headerCellClass() ?>"><div id="elh_concafact_descrip" class="concafact_descrip"><?= $Page->renderFieldHeader($Page->descrip) ?></div></th>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <th data-name="porcentaje" class="<?= $Page->porcentaje->headerCellClass() ?>"><div id="elh_concafact_porcentaje" class="concafact_porcentaje"><?= $Page->renderFieldHeader($Page->porcentaje) ?></div></th>
<?php } ?>
<?php if ($Page->importe->Visible) { // importe ?>
        <th data-name="importe" class="<?= $Page->importe->headerCellClass() ?>"><div id="elh_concafact_importe" class="concafact_importe"><?= $Page->renderFieldHeader($Page->importe) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_concafact_usuario" class="concafact_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Page->fechahora->headerCellClass() ?>"><div id="elh_concafact_fechahora" class="concafact_fechahora"><?= $Page->renderFieldHeader($Page->fechahora) ?></div></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th data-name="activo" class="<?= $Page->activo->headerCellClass() ?>"><div id="elh_concafact_activo" class="concafact_activo"><?= $Page->renderFieldHeader($Page->activo) ?></div></th>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <th data-name="tipoiva" class="<?= $Page->tipoiva->headerCellClass() ?>"><div id="elh_concafact_tipoiva" class="concafact_tipoiva"><?= $Page->renderFieldHeader($Page->tipoiva) ?></div></th>
<?php } ?>
<?php if ($Page->impuesto->Visible) { // impuesto ?>
        <th data-name="impuesto" class="<?= $Page->impuesto->headerCellClass() ?>"><div id="elh_concafact_impuesto" class="concafact_impuesto"><?= $Page->renderFieldHeader($Page->impuesto) ?></div></th>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <th data-name="tieneresol" class="<?= $Page->tieneresol->headerCellClass() ?>"><div id="elh_concafact_tieneresol" class="concafact_tieneresol"><?= $Page->renderFieldHeader($Page->tieneresol) ?></div></th>
<?php } ?>
<?php if ($Page->ctacbleBAS->Visible) { // ctacbleBAS ?>
        <th data-name="ctacbleBAS" class="<?= $Page->ctacbleBAS->headerCellClass() ?>"><div id="elh_concafact_ctacbleBAS" class="concafact_ctacbleBAS"><?= $Page->renderFieldHeader($Page->ctacbleBAS) ?></div></th>
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
    <?php if ($Page->codnum->Visible) { // codnum ?>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_codnum" class="el_concafact_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nroconc->Visible) { // nroconc ?>
        <td data-name="nroconc"<?= $Page->nroconc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_nroconc" class="el_concafact_nroconc">
<span<?= $Page->nroconc->viewAttributes() ?>>
<?= $Page->nroconc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->descrip->Visible) { // descrip ?>
        <td data-name="descrip"<?= $Page->descrip->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_descrip" class="el_concafact_descrip">
<span<?= $Page->descrip->viewAttributes() ?>>
<?= $Page->descrip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <td data-name="porcentaje"<?= $Page->porcentaje->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_porcentaje" class="el_concafact_porcentaje">
<span<?= $Page->porcentaje->viewAttributes() ?>>
<?= $Page->porcentaje->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->importe->Visible) { // importe ?>
        <td data-name="importe"<?= $Page->importe->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_importe" class="el_concafact_importe">
<span<?= $Page->importe->viewAttributes() ?>>
<?= $Page->importe->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_usuario" class="el_concafact_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_fechahora" class="el_concafact_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->activo->Visible) { // activo ?>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_activo" class="el_concafact_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <td data-name="tipoiva"<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_tipoiva" class="el_concafact_tipoiva">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->impuesto->Visible) { // impuesto ?>
        <td data-name="impuesto"<?= $Page->impuesto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_impuesto" class="el_concafact_impuesto">
<span<?= $Page->impuesto->viewAttributes() ?>>
<?= $Page->impuesto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <td data-name="tieneresol"<?= $Page->tieneresol->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_tieneresol" class="el_concafact_tieneresol">
<span<?= $Page->tieneresol->viewAttributes() ?>>
<?= $Page->tieneresol->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ctacbleBAS->Visible) { // ctacbleBAS ?>
        <td data-name="ctacbleBAS"<?= $Page->ctacbleBAS->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_concafact_ctacbleBAS" class="el_concafact_ctacbleBAS">
<span<?= $Page->ctacbleBAS->viewAttributes() ?>>
<?= $Page->ctacbleBAS->getViewValue() ?></span>
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
    ew.addEventHandlers("concafact");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
