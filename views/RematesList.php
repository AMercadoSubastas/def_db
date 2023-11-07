<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$RematesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { remates: currentTable } });
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
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.js?v=24.4.0", "preview");
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
<form name="frematessrch" id="frematessrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="frematessrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { remates: currentTable } });
var currentForm;
var frematessrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frematessrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="frematessrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="frematessrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="frematessrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="frematessrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="remates">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_remates" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_remateslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_remates_codnum" class="remates_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th data-name="tcomp" class="<?= $Page->tcomp->headerCellClass() ?>"><div id="elh_remates_tcomp" class="remates_tcomp"><?= $Page->renderFieldHeader($Page->tcomp) ?></div></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th data-name="serie" class="<?= $Page->serie->headerCellClass() ?>"><div id="elh_remates_serie" class="remates_serie"><?= $Page->renderFieldHeader($Page->serie) ?></div></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th data-name="ncomp" class="<?= $Page->ncomp->headerCellClass() ?>"><div id="elh_remates_ncomp" class="remates_ncomp"><?= $Page->renderFieldHeader($Page->ncomp) ?></div></th>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
        <th data-name="codcli" class="<?= $Page->codcli->headerCellClass() ?>"><div id="elh_remates_codcli" class="remates_codcli"><?= $Page->renderFieldHeader($Page->codcli) ?></div></th>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
        <th data-name="direccion" class="<?= $Page->direccion->headerCellClass() ?>"><div id="elh_remates_direccion" class="remates_direccion"><?= $Page->renderFieldHeader($Page->direccion) ?></div></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th data-name="codpais" class="<?= $Page->codpais->headerCellClass() ?>"><div id="elh_remates_codpais" class="remates_codpais"><?= $Page->renderFieldHeader($Page->codpais) ?></div></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th data-name="codprov" class="<?= $Page->codprov->headerCellClass() ?>"><div id="elh_remates_codprov" class="remates_codprov"><?= $Page->renderFieldHeader($Page->codprov) ?></div></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th data-name="codloc" class="<?= $Page->codloc->headerCellClass() ?>"><div id="elh_remates_codloc" class="remates_codloc"><?= $Page->renderFieldHeader($Page->codloc) ?></div></th>
<?php } ?>
<?php if ($Page->fecest->Visible) { // fecest ?>
        <th data-name="fecest" class="<?= $Page->fecest->headerCellClass() ?>"><div id="elh_remates_fecest" class="remates_fecest"><?= $Page->renderFieldHeader($Page->fecest) ?></div></th>
<?php } ?>
<?php if ($Page->fecreal->Visible) { // fecreal ?>
        <th data-name="fecreal" class="<?= $Page->fecreal->headerCellClass() ?>"><div id="elh_remates_fecreal" class="remates_fecreal"><?= $Page->renderFieldHeader($Page->fecreal) ?></div></th>
<?php } ?>
<?php if ($Page->imptot->Visible) { // imptot ?>
        <th data-name="imptot" class="<?= $Page->imptot->headerCellClass() ?>"><div id="elh_remates_imptot" class="remates_imptot"><?= $Page->renderFieldHeader($Page->imptot) ?></div></th>
<?php } ?>
<?php if ($Page->impbase->Visible) { // impbase ?>
        <th data-name="impbase" class="<?= $Page->impbase->headerCellClass() ?>"><div id="elh_remates_impbase" class="remates_impbase"><?= $Page->renderFieldHeader($Page->impbase) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_remates_estado" class="remates_estado"><?= $Page->renderFieldHeader($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->cantlotes->Visible) { // cantlotes ?>
        <th data-name="cantlotes" class="<?= $Page->cantlotes->headerCellClass() ?>"><div id="elh_remates_cantlotes" class="remates_cantlotes"><?= $Page->renderFieldHeader($Page->cantlotes) ?></div></th>
<?php } ?>
<?php if ($Page->horaest->Visible) { // horaest ?>
        <th data-name="horaest" class="<?= $Page->horaest->headerCellClass() ?>"><div id="elh_remates_horaest" class="remates_horaest"><?= $Page->renderFieldHeader($Page->horaest) ?></div></th>
<?php } ?>
<?php if ($Page->horareal->Visible) { // horareal ?>
        <th data-name="horareal" class="<?= $Page->horareal->headerCellClass() ?>"><div id="elh_remates_horareal" class="remates_horareal"><?= $Page->renderFieldHeader($Page->horareal) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_remates_usuario" class="remates_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <th data-name="fecalta" class="<?= $Page->fecalta->headerCellClass() ?>"><div id="elh_remates_fecalta" class="remates_fecalta"><?= $Page->renderFieldHeader($Page->fecalta) ?></div></th>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
        <th data-name="tipoind" class="<?= $Page->tipoind->headerCellClass() ?>"><div id="elh_remates_tipoind" class="remates_tipoind"><?= $Page->renderFieldHeader($Page->tipoind) ?></div></th>
<?php } ?>
<?php if ($Page->sello->Visible) { // sello ?>
        <th data-name="sello" class="<?= $Page->sello->headerCellClass() ?>"><div id="elh_remates_sello" class="remates_sello"><?= $Page->renderFieldHeader($Page->sello) ?></div></th>
<?php } ?>
<?php if ($Page->plazoSAP->Visible) { // plazoSAP ?>
        <th data-name="plazoSAP" class="<?= $Page->plazoSAP->headerCellClass() ?>"><div id="elh_remates_plazoSAP" class="remates_plazoSAP"><?= $Page->renderFieldHeader($Page->plazoSAP) ?></div></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th data-name="usuarioultmod" class="<?= $Page->usuarioultmod->headerCellClass() ?>"><div id="elh_remates_usuarioultmod" class="remates_usuarioultmod"><?= $Page->renderFieldHeader($Page->usuarioultmod) ?></div></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th data-name="fecultmod" class="<?= $Page->fecultmod->headerCellClass() ?>"><div id="elh_remates_fecultmod" class="remates_fecultmod"><?= $Page->renderFieldHeader($Page->fecultmod) ?></div></th>
<?php } ?>
<?php if ($Page->servicios->Visible) { // servicios ?>
        <th data-name="servicios" class="<?= $Page->servicios->headerCellClass() ?>"><div id="elh_remates_servicios" class="remates_servicios"><?= $Page->renderFieldHeader($Page->servicios) ?></div></th>
<?php } ?>
<?php if ($Page->gastos->Visible) { // gastos ?>
        <th data-name="gastos" class="<?= $Page->gastos->headerCellClass() ?>"><div id="elh_remates_gastos" class="remates_gastos"><?= $Page->renderFieldHeader($Page->gastos) ?></div></th>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
        <th data-name="tasa" class="<?= $Page->tasa->headerCellClass() ?>"><div id="elh_remates_tasa" class="remates_tasa"><?= $Page->renderFieldHeader($Page->tasa) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_codnum" class="el_remates_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_tcomp" class="el_remates_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serie->Visible) { // serie ?>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_serie" class="el_remates_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_ncomp" class="el_remates_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codcli->Visible) { // codcli ?>
        <td data-name="codcli"<?= $Page->codcli->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_codcli" class="el_remates_codcli">
<span<?= $Page->codcli->viewAttributes() ?>>
<?= $Page->codcli->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->direccion->Visible) { // direccion ?>
        <td data-name="direccion"<?= $Page->direccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_direccion" class="el_remates_direccion">
<span<?= $Page->direccion->viewAttributes() ?>>
<?= $Page->direccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpais->Visible) { // codpais ?>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_codpais" class="el_remates_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codprov->Visible) { // codprov ?>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_codprov" class="el_remates_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codloc->Visible) { // codloc ?>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_codloc" class="el_remates_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecest->Visible) { // fecest ?>
        <td data-name="fecest"<?= $Page->fecest->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_fecest" class="el_remates_fecest">
<span<?= $Page->fecest->viewAttributes() ?>>
<?= $Page->fecest->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecreal->Visible) { // fecreal ?>
        <td data-name="fecreal"<?= $Page->fecreal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_fecreal" class="el_remates_fecreal">
<span<?= $Page->fecreal->viewAttributes() ?>>
<?= $Page->fecreal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->imptot->Visible) { // imptot ?>
        <td data-name="imptot"<?= $Page->imptot->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_imptot" class="el_remates_imptot">
<span<?= $Page->imptot->viewAttributes() ?>>
<?= $Page->imptot->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->impbase->Visible) { // impbase ?>
        <td data-name="impbase"<?= $Page->impbase->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_impbase" class="el_remates_impbase">
<span<?= $Page->impbase->viewAttributes() ?>>
<?= $Page->impbase->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_estado" class="el_remates_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cantlotes->Visible) { // cantlotes ?>
        <td data-name="cantlotes"<?= $Page->cantlotes->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_cantlotes" class="el_remates_cantlotes">
<span<?= $Page->cantlotes->viewAttributes() ?>>
<?= $Page->cantlotes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->horaest->Visible) { // horaest ?>
        <td data-name="horaest"<?= $Page->horaest->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_horaest" class="el_remates_horaest">
<span<?= $Page->horaest->viewAttributes() ?>>
<?= $Page->horaest->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->horareal->Visible) { // horareal ?>
        <td data-name="horareal"<?= $Page->horareal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_horareal" class="el_remates_horareal">
<span<?= $Page->horareal->viewAttributes() ?>>
<?= $Page->horareal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_usuario" class="el_remates_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecalta->Visible) { // fecalta ?>
        <td data-name="fecalta"<?= $Page->fecalta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_fecalta" class="el_remates_fecalta">
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipoind->Visible) { // tipoind ?>
        <td data-name="tipoind"<?= $Page->tipoind->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_tipoind" class="el_remates_tipoind">
<span<?= $Page->tipoind->viewAttributes() ?>>
<?= $Page->tipoind->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sello->Visible) { // sello ?>
        <td data-name="sello"<?= $Page->sello->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_sello" class="el_remates_sello">
<span<?= $Page->sello->viewAttributes() ?>>
<?= $Page->sello->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->plazoSAP->Visible) { // plazoSAP ?>
        <td data-name="plazoSAP"<?= $Page->plazoSAP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_plazoSAP" class="el_remates_plazoSAP">
<span<?= $Page->plazoSAP->viewAttributes() ?>>
<?= $Page->plazoSAP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_usuarioultmod" class="el_remates_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_fecultmod" class="el_remates_fecultmod">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicios->Visible) { // servicios ?>
        <td data-name="servicios"<?= $Page->servicios->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_servicios" class="el_remates_servicios">
<span<?= $Page->servicios->viewAttributes() ?>>
<?= $Page->servicios->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gastos->Visible) { // gastos ?>
        <td data-name="gastos"<?= $Page->gastos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_gastos" class="el_remates_gastos">
<span<?= $Page->gastos->viewAttributes() ?>>
<?= $Page->gastos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tasa->Visible) { // tasa ?>
        <td data-name="tasa"<?= $Page->tasa->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_remates_tasa" class="el_remates_tasa">
<span<?= $Page->tasa->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($Page->tasa->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
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
    ew.addEventHandlers("remates");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
