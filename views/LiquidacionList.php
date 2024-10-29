<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LiquidacionList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { liquidacion: currentTable } });
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
<form name="fliquidacionsrch" id="fliquidacionsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="fliquidacionsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { liquidacion: currentTable } });
var currentForm;
var fliquidacionsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fliquidacionsrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fliquidacionsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fliquidacionsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fliquidacionsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fliquidacionsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="liquidacion">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_liquidacion" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_liquidacionlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_liquidacion_codnum" class="liquidacion_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th data-name="tcomp" class="<?= $Page->tcomp->headerCellClass() ?>"><div id="elh_liquidacion_tcomp" class="liquidacion_tcomp"><?= $Page->renderFieldHeader($Page->tcomp) ?></div></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th data-name="serie" class="<?= $Page->serie->headerCellClass() ?>"><div id="elh_liquidacion_serie" class="liquidacion_serie"><?= $Page->renderFieldHeader($Page->serie) ?></div></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th data-name="ncomp" class="<?= $Page->ncomp->headerCellClass() ?>"><div id="elh_liquidacion_ncomp" class="liquidacion_ncomp"><?= $Page->renderFieldHeader($Page->ncomp) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div id="elh_liquidacion_cliente" class="liquidacion_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->rubro->Visible) { // rubro ?>
        <th data-name="rubro" class="<?= $Page->rubro->headerCellClass() ?>"><div id="elh_liquidacion_rubro" class="liquidacion_rubro"><?= $Page->renderFieldHeader($Page->rubro) ?></div></th>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
        <th data-name="calle" class="<?= $Page->calle->headerCellClass() ?>"><div id="elh_liquidacion_calle" class="liquidacion_calle"><?= $Page->renderFieldHeader($Page->calle) ?></div></th>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
        <th data-name="dnro" class="<?= $Page->dnro->headerCellClass() ?>"><div id="elh_liquidacion_dnro" class="liquidacion_dnro"><?= $Page->renderFieldHeader($Page->dnro) ?></div></th>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
        <th data-name="pisodto" class="<?= $Page->pisodto->headerCellClass() ?>"><div id="elh_liquidacion_pisodto" class="liquidacion_pisodto"><?= $Page->renderFieldHeader($Page->pisodto) ?></div></th>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
        <th data-name="codpost" class="<?= $Page->codpost->headerCellClass() ?>"><div id="elh_liquidacion_codpost" class="liquidacion_codpost"><?= $Page->renderFieldHeader($Page->codpost) ?></div></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th data-name="codpais" class="<?= $Page->codpais->headerCellClass() ?>"><div id="elh_liquidacion_codpais" class="liquidacion_codpais"><?= $Page->renderFieldHeader($Page->codpais) ?></div></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th data-name="codprov" class="<?= $Page->codprov->headerCellClass() ?>"><div id="elh_liquidacion_codprov" class="liquidacion_codprov"><?= $Page->renderFieldHeader($Page->codprov) ?></div></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th data-name="codloc" class="<?= $Page->codloc->headerCellClass() ?>"><div id="elh_liquidacion_codloc" class="liquidacion_codloc"><?= $Page->renderFieldHeader($Page->codloc) ?></div></th>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th data-name="codrem" class="<?= $Page->codrem->headerCellClass() ?>"><div id="elh_liquidacion_codrem" class="liquidacion_codrem"><?= $Page->renderFieldHeader($Page->codrem) ?></div></th>
<?php } ?>
<?php if ($Page->fecharem->Visible) { // fecharem ?>
        <th data-name="fecharem" class="<?= $Page->fecharem->headerCellClass() ?>"><div id="elh_liquidacion_fecharem" class="liquidacion_fecharem"><?= $Page->renderFieldHeader($Page->fecharem) ?></div></th>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
        <th data-name="cuit" class="<?= $Page->cuit->headerCellClass() ?>"><div id="elh_liquidacion_cuit" class="liquidacion_cuit"><?= $Page->renderFieldHeader($Page->cuit) ?></div></th>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <th data-name="tipoiva" class="<?= $Page->tipoiva->headerCellClass() ?>"><div id="elh_liquidacion_tipoiva" class="liquidacion_tipoiva"><?= $Page->renderFieldHeader($Page->tipoiva) ?></div></th>
<?php } ?>
<?php if ($Page->totremate->Visible) { // totremate ?>
        <th data-name="totremate" class="<?= $Page->totremate->headerCellClass() ?>"><div id="elh_liquidacion_totremate" class="liquidacion_totremate"><?= $Page->renderFieldHeader($Page->totremate) ?></div></th>
<?php } ?>
<?php if ($Page->totneto1->Visible) { // totneto1 ?>
        <th data-name="totneto1" class="<?= $Page->totneto1->headerCellClass() ?>"><div id="elh_liquidacion_totneto1" class="liquidacion_totneto1"><?= $Page->renderFieldHeader($Page->totneto1) ?></div></th>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
        <th data-name="totiva21" class="<?= $Page->totiva21->headerCellClass() ?>"><div id="elh_liquidacion_totiva21" class="liquidacion_totiva21"><?= $Page->renderFieldHeader($Page->totiva21) ?></div></th>
<?php } ?>
<?php if ($Page->subtot1->Visible) { // subtot1 ?>
        <th data-name="subtot1" class="<?= $Page->subtot1->headerCellClass() ?>"><div id="elh_liquidacion_subtot1" class="liquidacion_subtot1"><?= $Page->renderFieldHeader($Page->subtot1) ?></div></th>
<?php } ?>
<?php if ($Page->totneto2->Visible) { // totneto2 ?>
        <th data-name="totneto2" class="<?= $Page->totneto2->headerCellClass() ?>"><div id="elh_liquidacion_totneto2" class="liquidacion_totneto2"><?= $Page->renderFieldHeader($Page->totneto2) ?></div></th>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
        <th data-name="totiva105" class="<?= $Page->totiva105->headerCellClass() ?>"><div id="elh_liquidacion_totiva105" class="liquidacion_totiva105"><?= $Page->renderFieldHeader($Page->totiva105) ?></div></th>
<?php } ?>
<?php if ($Page->subtot2->Visible) { // subtot2 ?>
        <th data-name="subtot2" class="<?= $Page->subtot2->headerCellClass() ?>"><div id="elh_liquidacion_subtot2" class="liquidacion_subtot2"><?= $Page->renderFieldHeader($Page->subtot2) ?></div></th>
<?php } ?>
<?php if ($Page->totacuenta->Visible) { // totacuenta ?>
        <th data-name="totacuenta" class="<?= $Page->totacuenta->headerCellClass() ?>"><div id="elh_liquidacion_totacuenta" class="liquidacion_totacuenta"><?= $Page->renderFieldHeader($Page->totacuenta) ?></div></th>
<?php } ?>
<?php if ($Page->totgastos->Visible) { // totgastos ?>
        <th data-name="totgastos" class="<?= $Page->totgastos->headerCellClass() ?>"><div id="elh_liquidacion_totgastos" class="liquidacion_totgastos"><?= $Page->renderFieldHeader($Page->totgastos) ?></div></th>
<?php } ?>
<?php if ($Page->totvarios->Visible) { // totvarios ?>
        <th data-name="totvarios" class="<?= $Page->totvarios->headerCellClass() ?>"><div id="elh_liquidacion_totvarios" class="liquidacion_totvarios"><?= $Page->renderFieldHeader($Page->totvarios) ?></div></th>
<?php } ?>
<?php if ($Page->saldoafav->Visible) { // saldoafav ?>
        <th data-name="saldoafav" class="<?= $Page->saldoafav->headerCellClass() ?>"><div id="elh_liquidacion_saldoafav" class="liquidacion_saldoafav"><?= $Page->renderFieldHeader($Page->saldoafav) ?></div></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Page->fechahora->headerCellClass() ?>"><div id="elh_liquidacion_fechahora" class="liquidacion_fechahora"><?= $Page->renderFieldHeader($Page->fechahora) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_liquidacion_usuario" class="liquidacion_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->fechaliq->Visible) { // fechaliq ?>
        <th data-name="fechaliq" class="<?= $Page->fechaliq->headerCellClass() ?>"><div id="elh_liquidacion_fechaliq" class="liquidacion_fechaliq"><?= $Page->renderFieldHeader($Page->fechaliq) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_liquidacion_estado" class="liquidacion_estado"><?= $Page->renderFieldHeader($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <th data-name="nrodoc" class="<?= $Page->nrodoc->headerCellClass() ?>"><div id="elh_liquidacion_nrodoc" class="liquidacion_nrodoc"><?= $Page->renderFieldHeader($Page->nrodoc) ?></div></th>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
        <th data-name="cotiz" class="<?= $Page->cotiz->headerCellClass() ?>"><div id="elh_liquidacion_cotiz" class="liquidacion_cotiz"><?= $Page->renderFieldHeader($Page->cotiz) ?></div></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th data-name="usuarioultmod" class="<?= $Page->usuarioultmod->headerCellClass() ?>"><div id="elh_liquidacion_usuarioultmod" class="liquidacion_usuarioultmod"><?= $Page->renderFieldHeader($Page->usuarioultmod) ?></div></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th data-name="fecultmod" class="<?= $Page->fecultmod->headerCellClass() ?>"><div id="elh_liquidacion_fecultmod" class="liquidacion_fecultmod"><?= $Page->renderFieldHeader($Page->fecultmod) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_codnum" class="el_liquidacion_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_tcomp" class="el_liquidacion_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serie->Visible) { // serie ?>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_serie" class="el_liquidacion_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_ncomp" class="el_liquidacion_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_cliente" class="el_liquidacion_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rubro->Visible) { // rubro ?>
        <td data-name="rubro"<?= $Page->rubro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_rubro" class="el_liquidacion_rubro">
<span<?= $Page->rubro->viewAttributes() ?>>
<?= $Page->rubro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->calle->Visible) { // calle ?>
        <td data-name="calle"<?= $Page->calle->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_calle" class="el_liquidacion_calle">
<span<?= $Page->calle->viewAttributes() ?>>
<?= $Page->calle->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dnro->Visible) { // dnro ?>
        <td data-name="dnro"<?= $Page->dnro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_dnro" class="el_liquidacion_dnro">
<span<?= $Page->dnro->viewAttributes() ?>>
<?= $Page->dnro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pisodto->Visible) { // pisodto ?>
        <td data-name="pisodto"<?= $Page->pisodto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_pisodto" class="el_liquidacion_pisodto">
<span<?= $Page->pisodto->viewAttributes() ?>>
<?= $Page->pisodto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpost->Visible) { // codpost ?>
        <td data-name="codpost"<?= $Page->codpost->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_codpost" class="el_liquidacion_codpost">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpais->Visible) { // codpais ?>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_codpais" class="el_liquidacion_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codprov->Visible) { // codprov ?>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_codprov" class="el_liquidacion_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codloc->Visible) { // codloc ?>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_codloc" class="el_liquidacion_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codrem->Visible) { // codrem ?>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_codrem" class="el_liquidacion_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecharem->Visible) { // fecharem ?>
        <td data-name="fecharem"<?= $Page->fecharem->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_fecharem" class="el_liquidacion_fecharem">
<span<?= $Page->fecharem->viewAttributes() ?>>
<?= $Page->fecharem->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuit->Visible) { // cuit ?>
        <td data-name="cuit"<?= $Page->cuit->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_cuit" class="el_liquidacion_cuit">
<span<?= $Page->cuit->viewAttributes() ?>>
<?= $Page->cuit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <td data-name="tipoiva"<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_tipoiva" class="el_liquidacion_tipoiva">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totremate->Visible) { // totremate ?>
        <td data-name="totremate"<?= $Page->totremate->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_totremate" class="el_liquidacion_totremate">
<span<?= $Page->totremate->viewAttributes() ?>>
<?= $Page->totremate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totneto1->Visible) { // totneto1 ?>
        <td data-name="totneto1"<?= $Page->totneto1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_totneto1" class="el_liquidacion_totneto1">
<span<?= $Page->totneto1->viewAttributes() ?>>
<?= $Page->totneto1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totiva21->Visible) { // totiva21 ?>
        <td data-name="totiva21"<?= $Page->totiva21->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_totiva21" class="el_liquidacion_totiva21">
<span<?= $Page->totiva21->viewAttributes() ?>>
<?= $Page->totiva21->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subtot1->Visible) { // subtot1 ?>
        <td data-name="subtot1"<?= $Page->subtot1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_subtot1" class="el_liquidacion_subtot1">
<span<?= $Page->subtot1->viewAttributes() ?>>
<?= $Page->subtot1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totneto2->Visible) { // totneto2 ?>
        <td data-name="totneto2"<?= $Page->totneto2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_totneto2" class="el_liquidacion_totneto2">
<span<?= $Page->totneto2->viewAttributes() ?>>
<?= $Page->totneto2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totiva105->Visible) { // totiva105 ?>
        <td data-name="totiva105"<?= $Page->totiva105->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_totiva105" class="el_liquidacion_totiva105">
<span<?= $Page->totiva105->viewAttributes() ?>>
<?= $Page->totiva105->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subtot2->Visible) { // subtot2 ?>
        <td data-name="subtot2"<?= $Page->subtot2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_subtot2" class="el_liquidacion_subtot2">
<span<?= $Page->subtot2->viewAttributes() ?>>
<?= $Page->subtot2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totacuenta->Visible) { // totacuenta ?>
        <td data-name="totacuenta"<?= $Page->totacuenta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_totacuenta" class="el_liquidacion_totacuenta">
<span<?= $Page->totacuenta->viewAttributes() ?>>
<?= $Page->totacuenta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totgastos->Visible) { // totgastos ?>
        <td data-name="totgastos"<?= $Page->totgastos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_totgastos" class="el_liquidacion_totgastos">
<span<?= $Page->totgastos->viewAttributes() ?>>
<?= $Page->totgastos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totvarios->Visible) { // totvarios ?>
        <td data-name="totvarios"<?= $Page->totvarios->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_totvarios" class="el_liquidacion_totvarios">
<span<?= $Page->totvarios->viewAttributes() ?>>
<?= $Page->totvarios->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->saldoafav->Visible) { // saldoafav ?>
        <td data-name="saldoafav"<?= $Page->saldoafav->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_saldoafav" class="el_liquidacion_saldoafav">
<span<?= $Page->saldoafav->viewAttributes() ?>>
<?= $Page->saldoafav->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_fechahora" class="el_liquidacion_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_usuario" class="el_liquidacion_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaliq->Visible) { // fechaliq ?>
        <td data-name="fechaliq"<?= $Page->fechaliq->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_fechaliq" class="el_liquidacion_fechaliq">
<span<?= $Page->fechaliq->viewAttributes() ?>>
<?= $Page->fechaliq->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_estado" class="el_liquidacion_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <td data-name="nrodoc"<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_nrodoc" class="el_liquidacion_nrodoc">
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cotiz->Visible) { // cotiz ?>
        <td data-name="cotiz"<?= $Page->cotiz->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_cotiz" class="el_liquidacion_cotiz">
<span<?= $Page->cotiz->viewAttributes() ?>>
<?= $Page->cotiz->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_usuarioultmod" class="el_liquidacion_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_liquidacion_fecultmod" class="el_liquidacion_fecultmod">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
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
    ew.addEventHandlers("liquidacion");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
