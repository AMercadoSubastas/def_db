<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetreciboList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detrecibo: currentTable } });
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "cabrecibo") {
    if ($Page->MasterRecordExists) {
        include_once "views/CabreciboMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fdetrecibosrch" id="fdetrecibosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="fdetrecibosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detrecibo: currentTable } });
var currentForm;
var fdetrecibosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdetrecibosrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdetrecibosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdetrecibosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdetrecibosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdetrecibosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="detrecibo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "cabrecibo" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cabrecibo">
<input type="hidden" name="fk_tcomp" value="<?= HtmlEncode($Page->tcomp->getSessionValue()) ?>">
<input type="hidden" name="fk_serie" value="<?= HtmlEncode($Page->serie->getSessionValue()) ?>">
<input type="hidden" name="fk_ncomp" value="<?= HtmlEncode($Page->ncomp->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_detrecibo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_detrecibolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_detrecibo_codnum" class="detrecibo_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th data-name="tcomp" class="<?= $Page->tcomp->headerCellClass() ?>"><div id="elh_detrecibo_tcomp" class="detrecibo_tcomp"><?= $Page->renderFieldHeader($Page->tcomp) ?></div></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th data-name="serie" class="<?= $Page->serie->headerCellClass() ?>"><div id="elh_detrecibo_serie" class="detrecibo_serie"><?= $Page->renderFieldHeader($Page->serie) ?></div></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th data-name="ncomp" class="<?= $Page->ncomp->headerCellClass() ?>"><div id="elh_detrecibo_ncomp" class="detrecibo_ncomp"><?= $Page->renderFieldHeader($Page->ncomp) ?></div></th>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
        <th data-name="nreng" class="<?= $Page->nreng->headerCellClass() ?>"><div id="elh_detrecibo_nreng" class="detrecibo_nreng"><?= $Page->renderFieldHeader($Page->nreng) ?></div></th>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <th data-name="tcomprel" class="<?= $Page->tcomprel->headerCellClass() ?>"><div id="elh_detrecibo_tcomprel" class="detrecibo_tcomprel"><?= $Page->renderFieldHeader($Page->tcomprel) ?></div></th>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
        <th data-name="serierel" class="<?= $Page->serierel->headerCellClass() ?>"><div id="elh_detrecibo_serierel" class="detrecibo_serierel"><?= $Page->renderFieldHeader($Page->serierel) ?></div></th>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <th data-name="ncomprel" class="<?= $Page->ncomprel->headerCellClass() ?>"><div id="elh_detrecibo_ncomprel" class="detrecibo_ncomprel"><?= $Page->renderFieldHeader($Page->ncomprel) ?></div></th>
<?php } ?>
<?php if ($Page->netocbterel->Visible) { // netocbterel ?>
        <th data-name="netocbterel" class="<?= $Page->netocbterel->headerCellClass() ?>"><div id="elh_detrecibo_netocbterel" class="detrecibo_netocbterel"><?= $Page->renderFieldHeader($Page->netocbterel) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_detrecibo_usuario" class="detrecibo_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Page->fechahora->headerCellClass() ?>"><div id="elh_detrecibo_fechahora" class="detrecibo_fechahora"><?= $Page->renderFieldHeader($Page->fechahora) ?></div></th>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <th data-name="nrodoc" class="<?= $Page->nrodoc->headerCellClass() ?>"><div id="elh_detrecibo_nrodoc" class="detrecibo_nrodoc"><?= $Page->renderFieldHeader($Page->nrodoc) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_codnum" class="el_detrecibo_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_tcomp" class="el_detrecibo_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serie->Visible) { // serie ?>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_serie" class="el_detrecibo_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_ncomp" class="el_detrecibo_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nreng->Visible) { // nreng ?>
        <td data-name="nreng"<?= $Page->nreng->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_nreng" class="el_detrecibo_nreng">
<span<?= $Page->nreng->viewAttributes() ?>>
<?= $Page->nreng->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <td data-name="tcomprel"<?= $Page->tcomprel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_tcomprel" class="el_detrecibo_tcomprel">
<span<?= $Page->tcomprel->viewAttributes() ?>>
<?= $Page->tcomprel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serierel->Visible) { // serierel ?>
        <td data-name="serierel"<?= $Page->serierel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_serierel" class="el_detrecibo_serierel">
<span<?= $Page->serierel->viewAttributes() ?>>
<?= $Page->serierel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <td data-name="ncomprel"<?= $Page->ncomprel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_ncomprel" class="el_detrecibo_ncomprel">
<span<?= $Page->ncomprel->viewAttributes() ?>>
<?= $Page->ncomprel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->netocbterel->Visible) { // netocbterel ?>
        <td data-name="netocbterel"<?= $Page->netocbterel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_netocbterel" class="el_detrecibo_netocbterel">
<span<?= $Page->netocbterel->viewAttributes() ?>>
<?= $Page->netocbterel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_usuario" class="el_detrecibo_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_fechahora" class="el_detrecibo_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <td data-name="nrodoc"<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detrecibo_nrodoc" class="el_detrecibo_nrodoc">
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
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
    ew.addEventHandlers("detrecibo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
