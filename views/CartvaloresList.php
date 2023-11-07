<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CartvaloresList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cartvalores: currentTable } });
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
<form name="fcartvaloressrch" id="fcartvaloressrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="fcartvaloressrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cartvalores: currentTable } });
var currentForm;
var fcartvaloressrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fcartvaloressrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcartvaloressrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcartvaloressrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcartvaloressrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcartvaloressrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="cartvalores">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_cartvalores" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_cartvaloreslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_cartvalores_codnum" class="cartvalores_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th data-name="tcomp" class="<?= $Page->tcomp->headerCellClass() ?>"><div id="elh_cartvalores_tcomp" class="cartvalores_tcomp"><?= $Page->renderFieldHeader($Page->tcomp) ?></div></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th data-name="serie" class="<?= $Page->serie->headerCellClass() ?>"><div id="elh_cartvalores_serie" class="cartvalores_serie"><?= $Page->renderFieldHeader($Page->serie) ?></div></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th data-name="ncomp" class="<?= $Page->ncomp->headerCellClass() ?>"><div id="elh_cartvalores_ncomp" class="cartvalores_ncomp"><?= $Page->renderFieldHeader($Page->ncomp) ?></div></th>
<?php } ?>
<?php if ($Page->codban->Visible) { // codban ?>
        <th data-name="codban" class="<?= $Page->codban->headerCellClass() ?>"><div id="elh_cartvalores_codban" class="cartvalores_codban"><?= $Page->renderFieldHeader($Page->codban) ?></div></th>
<?php } ?>
<?php if ($Page->codsuc->Visible) { // codsuc ?>
        <th data-name="codsuc" class="<?= $Page->codsuc->headerCellClass() ?>"><div id="elh_cartvalores_codsuc" class="cartvalores_codsuc"><?= $Page->renderFieldHeader($Page->codsuc) ?></div></th>
<?php } ?>
<?php if ($Page->codcta->Visible) { // codcta ?>
        <th data-name="codcta" class="<?= $Page->codcta->headerCellClass() ?>"><div id="elh_cartvalores_codcta" class="cartvalores_codcta"><?= $Page->renderFieldHeader($Page->codcta) ?></div></th>
<?php } ?>
<?php if ($Page->tipcta->Visible) { // tipcta ?>
        <th data-name="tipcta" class="<?= $Page->tipcta->headerCellClass() ?>"><div id="elh_cartvalores_tipcta" class="cartvalores_tipcta"><?= $Page->renderFieldHeader($Page->tipcta) ?></div></th>
<?php } ?>
<?php if ($Page->codchq->Visible) { // codchq ?>
        <th data-name="codchq" class="<?= $Page->codchq->headerCellClass() ?>"><div id="elh_cartvalores_codchq" class="cartvalores_codchq"><?= $Page->renderFieldHeader($Page->codchq) ?></div></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th data-name="codpais" class="<?= $Page->codpais->headerCellClass() ?>"><div id="elh_cartvalores_codpais" class="cartvalores_codpais"><?= $Page->renderFieldHeader($Page->codpais) ?></div></th>
<?php } ?>
<?php if ($Page->importe->Visible) { // importe ?>
        <th data-name="importe" class="<?= $Page->importe->headerCellClass() ?>"><div id="elh_cartvalores_importe" class="cartvalores_importe"><?= $Page->renderFieldHeader($Page->importe) ?></div></th>
<?php } ?>
<?php if ($Page->fechaemis->Visible) { // fechaemis ?>
        <th data-name="fechaemis" class="<?= $Page->fechaemis->headerCellClass() ?>"><div id="elh_cartvalores_fechaemis" class="cartvalores_fechaemis"><?= $Page->renderFieldHeader($Page->fechaemis) ?></div></th>
<?php } ?>
<?php if ($Page->fechapago->Visible) { // fechapago ?>
        <th data-name="fechapago" class="<?= $Page->fechapago->headerCellClass() ?>"><div id="elh_cartvalores_fechapago" class="cartvalores_fechapago"><?= $Page->renderFieldHeader($Page->fechapago) ?></div></th>
<?php } ?>
<?php if ($Page->entrego->Visible) { // entrego ?>
        <th data-name="entrego" class="<?= $Page->entrego->headerCellClass() ?>"><div id="elh_cartvalores_entrego" class="cartvalores_entrego"><?= $Page->renderFieldHeader($Page->entrego) ?></div></th>
<?php } ?>
<?php if ($Page->recibio->Visible) { // recibio ?>
        <th data-name="recibio" class="<?= $Page->recibio->headerCellClass() ?>"><div id="elh_cartvalores_recibio" class="cartvalores_recibio"><?= $Page->renderFieldHeader($Page->recibio) ?></div></th>
<?php } ?>
<?php if ($Page->fechaingr->Visible) { // fechaingr ?>
        <th data-name="fechaingr" class="<?= $Page->fechaingr->headerCellClass() ?>"><div id="elh_cartvalores_fechaingr" class="cartvalores_fechaingr"><?= $Page->renderFieldHeader($Page->fechaingr) ?></div></th>
<?php } ?>
<?php if ($Page->fechaentrega->Visible) { // fechaentrega ?>
        <th data-name="fechaentrega" class="<?= $Page->fechaentrega->headerCellClass() ?>"><div id="elh_cartvalores_fechaentrega" class="cartvalores_fechaentrega"><?= $Page->renderFieldHeader($Page->fechaentrega) ?></div></th>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <th data-name="tcomprel" class="<?= $Page->tcomprel->headerCellClass() ?>"><div id="elh_cartvalores_tcomprel" class="cartvalores_tcomprel"><?= $Page->renderFieldHeader($Page->tcomprel) ?></div></th>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
        <th data-name="serierel" class="<?= $Page->serierel->headerCellClass() ?>"><div id="elh_cartvalores_serierel" class="cartvalores_serierel"><?= $Page->renderFieldHeader($Page->serierel) ?></div></th>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <th data-name="ncomprel" class="<?= $Page->ncomprel->headerCellClass() ?>"><div id="elh_cartvalores_ncomprel" class="cartvalores_ncomprel"><?= $Page->renderFieldHeader($Page->ncomprel) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_cartvalores_estado" class="cartvalores_estado"><?= $Page->renderFieldHeader($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
        <th data-name="moneda" class="<?= $Page->moneda->headerCellClass() ?>"><div id="elh_cartvalores_moneda" class="cartvalores_moneda"><?= $Page->renderFieldHeader($Page->moneda) ?></div></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Page->fechahora->headerCellClass() ?>"><div id="elh_cartvalores_fechahora" class="cartvalores_fechahora"><?= $Page->renderFieldHeader($Page->fechahora) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_cartvalores_usuario" class="cartvalores_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
        <th data-name="tcompsal" class="<?= $Page->tcompsal->headerCellClass() ?>"><div id="elh_cartvalores_tcompsal" class="cartvalores_tcompsal"><?= $Page->renderFieldHeader($Page->tcompsal) ?></div></th>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
        <th data-name="seriesal" class="<?= $Page->seriesal->headerCellClass() ?>"><div id="elh_cartvalores_seriesal" class="cartvalores_seriesal"><?= $Page->renderFieldHeader($Page->seriesal) ?></div></th>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <th data-name="ncompsal" class="<?= $Page->ncompsal->headerCellClass() ?>"><div id="elh_cartvalores_ncompsal" class="cartvalores_ncompsal"><?= $Page->renderFieldHeader($Page->ncompsal) ?></div></th>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th data-name="codrem" class="<?= $Page->codrem->headerCellClass() ?>"><div id="elh_cartvalores_codrem" class="cartvalores_codrem"><?= $Page->renderFieldHeader($Page->codrem) ?></div></th>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
        <th data-name="cotiz" class="<?= $Page->cotiz->headerCellClass() ?>"><div id="elh_cartvalores_cotiz" class="cartvalores_cotiz"><?= $Page->renderFieldHeader($Page->cotiz) ?></div></th>
<?php } ?>
<?php if ($Page->usurel->Visible) { // usurel ?>
        <th data-name="usurel" class="<?= $Page->usurel->headerCellClass() ?>"><div id="elh_cartvalores_usurel" class="cartvalores_usurel"><?= $Page->renderFieldHeader($Page->usurel) ?></div></th>
<?php } ?>
<?php if ($Page->fecharel->Visible) { // fecharel ?>
        <th data-name="fecharel" class="<?= $Page->fecharel->headerCellClass() ?>"><div id="elh_cartvalores_fecharel" class="cartvalores_fecharel"><?= $Page->renderFieldHeader($Page->fecharel) ?></div></th>
<?php } ?>
<?php if ($Page->ususal->Visible) { // ususal ?>
        <th data-name="ususal" class="<?= $Page->ususal->headerCellClass() ?>"><div id="elh_cartvalores_ususal" class="cartvalores_ususal"><?= $Page->renderFieldHeader($Page->ususal) ?></div></th>
<?php } ?>
<?php if ($Page->fechasal->Visible) { // fechasal ?>
        <th data-name="fechasal" class="<?= $Page->fechasal->headerCellClass() ?>"><div id="elh_cartvalores_fechasal" class="cartvalores_fechasal"><?= $Page->renderFieldHeader($Page->fechasal) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_codnum" class="el_cartvalores_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_tcomp" class="el_cartvalores_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serie->Visible) { // serie ?>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_serie" class="el_cartvalores_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_ncomp" class="el_cartvalores_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codban->Visible) { // codban ?>
        <td data-name="codban"<?= $Page->codban->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_codban" class="el_cartvalores_codban">
<span<?= $Page->codban->viewAttributes() ?>>
<?= $Page->codban->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codsuc->Visible) { // codsuc ?>
        <td data-name="codsuc"<?= $Page->codsuc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_codsuc" class="el_cartvalores_codsuc">
<span<?= $Page->codsuc->viewAttributes() ?>>
<?= $Page->codsuc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codcta->Visible) { // codcta ?>
        <td data-name="codcta"<?= $Page->codcta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_codcta" class="el_cartvalores_codcta">
<span<?= $Page->codcta->viewAttributes() ?>>
<?= $Page->codcta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipcta->Visible) { // tipcta ?>
        <td data-name="tipcta"<?= $Page->tipcta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_tipcta" class="el_cartvalores_tipcta">
<span<?= $Page->tipcta->viewAttributes() ?>>
<?= $Page->tipcta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codchq->Visible) { // codchq ?>
        <td data-name="codchq"<?= $Page->codchq->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_codchq" class="el_cartvalores_codchq">
<span<?= $Page->codchq->viewAttributes() ?>>
<?= $Page->codchq->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpais->Visible) { // codpais ?>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_codpais" class="el_cartvalores_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->importe->Visible) { // importe ?>
        <td data-name="importe"<?= $Page->importe->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_importe" class="el_cartvalores_importe">
<span<?= $Page->importe->viewAttributes() ?>>
<?= $Page->importe->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaemis->Visible) { // fechaemis ?>
        <td data-name="fechaemis"<?= $Page->fechaemis->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_fechaemis" class="el_cartvalores_fechaemis">
<span<?= $Page->fechaemis->viewAttributes() ?>>
<?= $Page->fechaemis->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechapago->Visible) { // fechapago ?>
        <td data-name="fechapago"<?= $Page->fechapago->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_fechapago" class="el_cartvalores_fechapago">
<span<?= $Page->fechapago->viewAttributes() ?>>
<?= $Page->fechapago->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->entrego->Visible) { // entrego ?>
        <td data-name="entrego"<?= $Page->entrego->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_entrego" class="el_cartvalores_entrego">
<span<?= $Page->entrego->viewAttributes() ?>>
<?= $Page->entrego->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->recibio->Visible) { // recibio ?>
        <td data-name="recibio"<?= $Page->recibio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_recibio" class="el_cartvalores_recibio">
<span<?= $Page->recibio->viewAttributes() ?>>
<?= $Page->recibio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaingr->Visible) { // fechaingr ?>
        <td data-name="fechaingr"<?= $Page->fechaingr->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_fechaingr" class="el_cartvalores_fechaingr">
<span<?= $Page->fechaingr->viewAttributes() ?>>
<?= $Page->fechaingr->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaentrega->Visible) { // fechaentrega ?>
        <td data-name="fechaentrega"<?= $Page->fechaentrega->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_fechaentrega" class="el_cartvalores_fechaentrega">
<span<?= $Page->fechaentrega->viewAttributes() ?>>
<?= $Page->fechaentrega->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <td data-name="tcomprel"<?= $Page->tcomprel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_tcomprel" class="el_cartvalores_tcomprel">
<span<?= $Page->tcomprel->viewAttributes() ?>>
<?= $Page->tcomprel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serierel->Visible) { // serierel ?>
        <td data-name="serierel"<?= $Page->serierel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_serierel" class="el_cartvalores_serierel">
<span<?= $Page->serierel->viewAttributes() ?>>
<?= $Page->serierel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <td data-name="ncomprel"<?= $Page->ncomprel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_ncomprel" class="el_cartvalores_ncomprel">
<span<?= $Page->ncomprel->viewAttributes() ?>>
<?= $Page->ncomprel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_estado" class="el_cartvalores_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->moneda->Visible) { // moneda ?>
        <td data-name="moneda"<?= $Page->moneda->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_moneda" class="el_cartvalores_moneda">
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_fechahora" class="el_cartvalores_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_usuario" class="el_cartvalores_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcompsal->Visible) { // tcompsal ?>
        <td data-name="tcompsal"<?= $Page->tcompsal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_tcompsal" class="el_cartvalores_tcompsal">
<span<?= $Page->tcompsal->viewAttributes() ?>>
<?= $Page->tcompsal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->seriesal->Visible) { // seriesal ?>
        <td data-name="seriesal"<?= $Page->seriesal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_seriesal" class="el_cartvalores_seriesal">
<span<?= $Page->seriesal->viewAttributes() ?>>
<?= $Page->seriesal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <td data-name="ncompsal"<?= $Page->ncompsal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_ncompsal" class="el_cartvalores_ncompsal">
<span<?= $Page->ncompsal->viewAttributes() ?>>
<?= $Page->ncompsal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codrem->Visible) { // codrem ?>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_codrem" class="el_cartvalores_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cotiz->Visible) { // cotiz ?>
        <td data-name="cotiz"<?= $Page->cotiz->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_cotiz" class="el_cartvalores_cotiz">
<span<?= $Page->cotiz->viewAttributes() ?>>
<?= $Page->cotiz->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usurel->Visible) { // usurel ?>
        <td data-name="usurel"<?= $Page->usurel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_usurel" class="el_cartvalores_usurel">
<span<?= $Page->usurel->viewAttributes() ?>>
<?= $Page->usurel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecharel->Visible) { // fecharel ?>
        <td data-name="fecharel"<?= $Page->fecharel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_fecharel" class="el_cartvalores_fecharel">
<span<?= $Page->fecharel->viewAttributes() ?>>
<?= $Page->fecharel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ususal->Visible) { // ususal ?>
        <td data-name="ususal"<?= $Page->ususal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_ususal" class="el_cartvalores_ususal">
<span<?= $Page->ususal->viewAttributes() ?>>
<?= $Page->ususal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechasal->Visible) { // fechasal ?>
        <td data-name="fechasal"<?= $Page->fechasal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cartvalores_fechasal" class="el_cartvalores_fechasal">
<span<?= $Page->fechasal->viewAttributes() ?>>
<?= $Page->fechasal->getViewValue() ?></span>
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
    ew.addEventHandlers("cartvalores");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
