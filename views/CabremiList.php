<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CabremiList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabremi: currentTable } });
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
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=24.14.0", "preview");
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
<form name="fcabremisrch" id="fcabremisrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="fcabremisrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabremi: currentTable } });
var currentForm;
var fcabremisrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fcabremisrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcabremisrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcabremisrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcabremisrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcabremisrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="cabremi">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_cabremi" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_cabremilist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_cabremi_codnum" class="cabremi_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th data-name="tcomp" class="<?= $Page->tcomp->headerCellClass() ?>"><div id="elh_cabremi_tcomp" class="cabremi_tcomp"><?= $Page->renderFieldHeader($Page->tcomp) ?></div></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th data-name="serie" class="<?= $Page->serie->headerCellClass() ?>"><div id="elh_cabremi_serie" class="cabremi_serie"><?= $Page->renderFieldHeader($Page->serie) ?></div></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th data-name="ncomp" class="<?= $Page->ncomp->headerCellClass() ?>"><div id="elh_cabremi_ncomp" class="cabremi_ncomp"><?= $Page->renderFieldHeader($Page->ncomp) ?></div></th>
<?php } ?>
<?php if ($Page->cantrengs->Visible) { // cantrengs ?>
        <th data-name="cantrengs" class="<?= $Page->cantrengs->headerCellClass() ?>"><div id="elh_cabremi_cantrengs" class="cabremi_cantrengs"><?= $Page->renderFieldHeader($Page->cantrengs) ?></div></th>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
        <th data-name="comprador" class="<?= $Page->comprador->headerCellClass() ?>"><div id="elh_cabremi_comprador" class="cabremi_comprador"><?= $Page->renderFieldHeader($Page->comprador) ?></div></th>
<?php } ?>
<?php if ($Page->fecharemi->Visible) { // fecharemi ?>
        <th data-name="fecharemi" class="<?= $Page->fecharemi->headerCellClass() ?>"><div id="elh_cabremi_fecharemi" class="cabremi_fecharemi"><?= $Page->renderFieldHeader($Page->fecharemi) ?></div></th>
<?php } ?>
<?php if ($Page->observaciones->Visible) { // observaciones ?>
        <th data-name="observaciones" class="<?= $Page->observaciones->headerCellClass() ?>"><div id="elh_cabremi_observaciones" class="cabremi_observaciones"><?= $Page->renderFieldHeader($Page->observaciones) ?></div></th>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
        <th data-name="calle" class="<?= $Page->calle->headerCellClass() ?>"><div id="elh_cabremi_calle" class="cabremi_calle"><?= $Page->renderFieldHeader($Page->calle) ?></div></th>
<?php } ?>
<?php if ($Page->numero->Visible) { // numero ?>
        <th data-name="numero" class="<?= $Page->numero->headerCellClass() ?>"><div id="elh_cabremi_numero" class="cabremi_numero"><?= $Page->renderFieldHeader($Page->numero) ?></div></th>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
        <th data-name="pisodto" class="<?= $Page->pisodto->headerCellClass() ?>"><div id="elh_cabremi_pisodto" class="cabremi_pisodto"><?= $Page->renderFieldHeader($Page->pisodto) ?></div></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th data-name="codpais" class="<?= $Page->codpais->headerCellClass() ?>"><div id="elh_cabremi_codpais" class="cabremi_codpais"><?= $Page->renderFieldHeader($Page->codpais) ?></div></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th data-name="codprov" class="<?= $Page->codprov->headerCellClass() ?>"><div id="elh_cabremi_codprov" class="cabremi_codprov"><?= $Page->renderFieldHeader($Page->codprov) ?></div></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th data-name="codloc" class="<?= $Page->codloc->headerCellClass() ?>"><div id="elh_cabremi_codloc" class="cabremi_codloc"><?= $Page->renderFieldHeader($Page->codloc) ?></div></th>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
        <th data-name="codpost" class="<?= $Page->codpost->headerCellClass() ?>"><div id="elh_cabremi_codpost" class="cabremi_codpost"><?= $Page->renderFieldHeader($Page->codpost) ?></div></th>
<?php } ?>
<?php if ($Page->patente->Visible) { // patente ?>
        <th data-name="patente" class="<?= $Page->patente->headerCellClass() ?>"><div id="elh_cabremi_patente" class="cabremi_patente"><?= $Page->renderFieldHeader($Page->patente) ?></div></th>
<?php } ?>
<?php if ($Page->patremolque->Visible) { // patremolque ?>
        <th data-name="patremolque" class="<?= $Page->patremolque->headerCellClass() ?>"><div id="elh_cabremi_patremolque" class="cabremi_patremolque"><?= $Page->renderFieldHeader($Page->patremolque) ?></div></th>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
        <th data-name="cuit" class="<?= $Page->cuit->headerCellClass() ?>"><div id="elh_cabremi_cuit" class="cabremi_cuit"><?= $Page->renderFieldHeader($Page->cuit) ?></div></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Page->fechahora->headerCellClass() ?>"><div id="elh_cabremi_fechahora" class="cabremi_fechahora"><?= $Page->renderFieldHeader($Page->fechahora) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_cabremi_usuario" class="cabremi_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <th data-name="tcomprel" class="<?= $Page->tcomprel->headerCellClass() ?>"><div id="elh_cabremi_tcomprel" class="cabremi_tcomprel"><?= $Page->renderFieldHeader($Page->tcomprel) ?></div></th>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
        <th data-name="serierel" class="<?= $Page->serierel->headerCellClass() ?>"><div id="elh_cabremi_serierel" class="cabremi_serierel"><?= $Page->renderFieldHeader($Page->serierel) ?></div></th>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <th data-name="ncomprel" class="<?= $Page->ncomprel->headerCellClass() ?>"><div id="elh_cabremi_ncomprel" class="cabremi_ncomprel"><?= $Page->renderFieldHeader($Page->ncomprel) ?></div></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th data-name="usuarioultmod" class="<?= $Page->usuarioultmod->headerCellClass() ?>"><div id="elh_cabremi_usuarioultmod" class="cabremi_usuarioultmod"><?= $Page->renderFieldHeader($Page->usuarioultmod) ?></div></th>
<?php } ?>
<?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
        <th data-name="fechaultmod" class="<?= $Page->fechaultmod->headerCellClass() ?>"><div id="elh_cabremi_fechaultmod" class="cabremi_fechaultmod"><?= $Page->renderFieldHeader($Page->fechaultmod) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_codnum" class="el_cabremi_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_tcomp" class="el_cabremi_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serie->Visible) { // serie ?>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_serie" class="el_cabremi_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_ncomp" class="el_cabremi_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cantrengs->Visible) { // cantrengs ?>
        <td data-name="cantrengs"<?= $Page->cantrengs->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_cantrengs" class="el_cabremi_cantrengs">
<span<?= $Page->cantrengs->viewAttributes() ?>>
<?= $Page->cantrengs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->comprador->Visible) { // comprador ?>
        <td data-name="comprador"<?= $Page->comprador->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_comprador" class="el_cabremi_comprador">
<span<?= $Page->comprador->viewAttributes() ?>>
<?= $Page->comprador->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecharemi->Visible) { // fecharemi ?>
        <td data-name="fecharemi"<?= $Page->fecharemi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_fecharemi" class="el_cabremi_fecharemi">
<span<?= $Page->fecharemi->viewAttributes() ?>>
<?= $Page->fecharemi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->observaciones->Visible) { // observaciones ?>
        <td data-name="observaciones"<?= $Page->observaciones->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_observaciones" class="el_cabremi_observaciones">
<span<?= $Page->observaciones->viewAttributes() ?>>
<?= $Page->observaciones->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->calle->Visible) { // calle ?>
        <td data-name="calle"<?= $Page->calle->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_calle" class="el_cabremi_calle">
<span<?= $Page->calle->viewAttributes() ?>>
<?= $Page->calle->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->numero->Visible) { // numero ?>
        <td data-name="numero"<?= $Page->numero->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_numero" class="el_cabremi_numero">
<span<?= $Page->numero->viewAttributes() ?>>
<?= $Page->numero->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pisodto->Visible) { // pisodto ?>
        <td data-name="pisodto"<?= $Page->pisodto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_pisodto" class="el_cabremi_pisodto">
<span<?= $Page->pisodto->viewAttributes() ?>>
<?= $Page->pisodto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpais->Visible) { // codpais ?>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_codpais" class="el_cabremi_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codprov->Visible) { // codprov ?>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_codprov" class="el_cabremi_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codloc->Visible) { // codloc ?>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_codloc" class="el_cabremi_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpost->Visible) { // codpost ?>
        <td data-name="codpost"<?= $Page->codpost->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_codpost" class="el_cabremi_codpost">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->patente->Visible) { // patente ?>
        <td data-name="patente"<?= $Page->patente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_patente" class="el_cabremi_patente">
<span<?= $Page->patente->viewAttributes() ?>>
<?= $Page->patente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->patremolque->Visible) { // patremolque ?>
        <td data-name="patremolque"<?= $Page->patremolque->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_patremolque" class="el_cabremi_patremolque">
<span<?= $Page->patremolque->viewAttributes() ?>>
<?= $Page->patremolque->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuit->Visible) { // cuit ?>
        <td data-name="cuit"<?= $Page->cuit->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_cuit" class="el_cabremi_cuit">
<span<?= $Page->cuit->viewAttributes() ?>>
<?= $Page->cuit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_fechahora" class="el_cabremi_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_usuario" class="el_cabremi_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <td data-name="tcomprel"<?= $Page->tcomprel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_tcomprel" class="el_cabremi_tcomprel">
<span<?= $Page->tcomprel->viewAttributes() ?>>
<?= $Page->tcomprel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serierel->Visible) { // serierel ?>
        <td data-name="serierel"<?= $Page->serierel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_serierel" class="el_cabremi_serierel">
<span<?= $Page->serierel->viewAttributes() ?>>
<?= $Page->serierel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <td data-name="ncomprel"<?= $Page->ncomprel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_ncomprel" class="el_cabremi_ncomprel">
<span<?= $Page->ncomprel->viewAttributes() ?>>
<?= $Page->ncomprel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_usuarioultmod" class="el_cabremi_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
        <td data-name="fechaultmod"<?= $Page->fechaultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabremi_fechaultmod" class="el_cabremi_fechaultmod">
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
    ew.addEventHandlers("cabremi");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
