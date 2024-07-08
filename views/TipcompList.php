<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$TipcompList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipcomp: currentTable } });
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
<form name="ftipcompsrch" id="ftipcompsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="ftipcompsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipcomp: currentTable } });
var currentForm;
var ftipcompsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("ftipcompsrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ftipcompsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ftipcompsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ftipcompsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ftipcompsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="tipcomp">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_tipcomp" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_tipcomplist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_tipcomp_codnum" class="tipcomp_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th data-name="descripcion" class="<?= $Page->descripcion->headerCellClass() ?>"><div id="elh_tipcomp_descripcion" class="tipcomp_descripcion"><?= $Page->renderFieldHeader($Page->descripcion) ?></div></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th data-name="activo" class="<?= $Page->activo->headerCellClass() ?>"><div id="elh_tipcomp_activo" class="tipcomp_activo"><?= $Page->renderFieldHeader($Page->activo) ?></div></th>
<?php } ?>
<?php if ($Page->esfactura->Visible) { // esfactura ?>
        <th data-name="esfactura" class="<?= $Page->esfactura->headerCellClass() ?>"><div id="elh_tipcomp_esfactura" class="tipcomp_esfactura"><?= $Page->renderFieldHeader($Page->esfactura) ?></div></th>
<?php } ?>
<?php if ($Page->esprovedor->Visible) { // esprovedor ?>
        <th data-name="esprovedor" class="<?= $Page->esprovedor->headerCellClass() ?>"><div id="elh_tipcomp_esprovedor" class="tipcomp_esprovedor"><?= $Page->renderFieldHeader($Page->esprovedor) ?></div></th>
<?php } ?>
<?php if ($Page->codafip->Visible) { // codafip ?>
        <th data-name="codafip" class="<?= $Page->codafip->headerCellClass() ?>"><div id="elh_tipcomp_codafip" class="tipcomp_codafip"><?= $Page->renderFieldHeader($Page->codafip) ?></div></th>
<?php } ?>
<?php if ($Page->usuarioalta->Visible) { // usuarioalta ?>
        <th data-name="usuarioalta" class="<?= $Page->usuarioalta->headerCellClass() ?>"><div id="elh_tipcomp_usuarioalta" class="tipcomp_usuarioalta"><?= $Page->renderFieldHeader($Page->usuarioalta) ?></div></th>
<?php } ?>
<?php if ($Page->fechaalta->Visible) { // fechaalta ?>
        <th data-name="fechaalta" class="<?= $Page->fechaalta->headerCellClass() ?>"><div id="elh_tipcomp_fechaalta" class="tipcomp_fechaalta"><?= $Page->renderFieldHeader($Page->fechaalta) ?></div></th>
<?php } ?>
<?php if ($Page->usuariomod->Visible) { // usuariomod ?>
        <th data-name="usuariomod" class="<?= $Page->usuariomod->headerCellClass() ?>"><div id="elh_tipcomp_usuariomod" class="tipcomp_usuariomod"><?= $Page->renderFieldHeader($Page->usuariomod) ?></div></th>
<?php } ?>
<?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
        <th data-name="fechaultmod" class="<?= $Page->fechaultmod->headerCellClass() ?>"><div id="elh_tipcomp_fechaultmod" class="tipcomp_fechaultmod"><?= $Page->renderFieldHeader($Page->fechaultmod) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_codnum" class="el_tipcomp_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_descripcion" class="el_tipcomp_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->activo->Visible) { // activo ?>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_activo" class="el_tipcomp_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->esfactura->Visible) { // esfactura ?>
        <td data-name="esfactura"<?= $Page->esfactura->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_esfactura" class="el_tipcomp_esfactura">
<span<?= $Page->esfactura->viewAttributes() ?>>
<?= $Page->esfactura->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->esprovedor->Visible) { // esprovedor ?>
        <td data-name="esprovedor"<?= $Page->esprovedor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_esprovedor" class="el_tipcomp_esprovedor">
<span<?= $Page->esprovedor->viewAttributes() ?>>
<?= $Page->esprovedor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codafip->Visible) { // codafip ?>
        <td data-name="codafip"<?= $Page->codafip->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_codafip" class="el_tipcomp_codafip">
<span<?= $Page->codafip->viewAttributes() ?>>
<?= $Page->codafip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuarioalta->Visible) { // usuarioalta ?>
        <td data-name="usuarioalta"<?= $Page->usuarioalta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_usuarioalta" class="el_tipcomp_usuarioalta">
<span<?= $Page->usuarioalta->viewAttributes() ?>>
<?= $Page->usuarioalta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaalta->Visible) { // fechaalta ?>
        <td data-name="fechaalta"<?= $Page->fechaalta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_fechaalta" class="el_tipcomp_fechaalta">
<span<?= $Page->fechaalta->viewAttributes() ?>>
<?= $Page->fechaalta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuariomod->Visible) { // usuariomod ?>
        <td data-name="usuariomod"<?= $Page->usuariomod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_usuariomod" class="el_tipcomp_usuariomod">
<span<?= $Page->usuariomod->viewAttributes() ?>>
<?= $Page->usuariomod->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
        <td data-name="fechaultmod"<?= $Page->fechaultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_tipcomp_fechaultmod" class="el_tipcomp_fechaultmod">
<span<?= $Page->fechaultmod->viewAttributes() ?>>
<?= $Page->fechaultmod->getViewValue() ?></span>
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
    ew.addEventHandlers("tipcomp");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
