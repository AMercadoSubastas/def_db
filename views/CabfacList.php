<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CabfacList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabfac: currentTable } });
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
<form name="fcabfacsrch" id="fcabfacsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="fcabfacsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabfac: currentTable } });
var currentForm;
var fcabfacsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fcabfacsrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcabfacsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcabfacsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcabfacsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcabfacsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="cabfac">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_cabfac" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_cabfaclist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_cabfac_codnum" class="cabfac_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th data-name="tcomp" class="<?= $Page->tcomp->headerCellClass() ?>"><div id="elh_cabfac_tcomp" class="cabfac_tcomp"><?= $Page->renderFieldHeader($Page->tcomp) ?></div></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th data-name="serie" class="<?= $Page->serie->headerCellClass() ?>"><div id="elh_cabfac_serie" class="cabfac_serie"><?= $Page->renderFieldHeader($Page->serie) ?></div></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th data-name="ncomp" class="<?= $Page->ncomp->headerCellClass() ?>"><div id="elh_cabfac_ncomp" class="cabfac_ncomp"><?= $Page->renderFieldHeader($Page->ncomp) ?></div></th>
<?php } ?>
<?php if ($Page->fecval->Visible) { // fecval ?>
        <th data-name="fecval" class="<?= $Page->fecval->headerCellClass() ?>"><div id="elh_cabfac_fecval" class="cabfac_fecval"><?= $Page->renderFieldHeader($Page->fecval) ?></div></th>
<?php } ?>
<?php if ($Page->fecdoc->Visible) { // fecdoc ?>
        <th data-name="fecdoc" class="<?= $Page->fecdoc->headerCellClass() ?>"><div id="elh_cabfac_fecdoc" class="cabfac_fecdoc"><?= $Page->renderFieldHeader($Page->fecdoc) ?></div></th>
<?php } ?>
<?php if ($Page->fecreg->Visible) { // fecreg ?>
        <th data-name="fecreg" class="<?= $Page->fecreg->headerCellClass() ?>"><div id="elh_cabfac_fecreg" class="cabfac_fecreg"><?= $Page->renderFieldHeader($Page->fecreg) ?></div></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th data-name="cliente" class="<?= $Page->cliente->headerCellClass() ?>"><div id="elh_cabfac_cliente" class="cabfac_cliente"><?= $Page->renderFieldHeader($Page->cliente) ?></div></th>
<?php } ?>
<?php if ($Page->direc->Visible) { // direc ?>
        <th data-name="direc" class="<?= $Page->direc->headerCellClass() ?>"><div id="elh_cabfac_direc" class="cabfac_direc"><?= $Page->renderFieldHeader($Page->direc) ?></div></th>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
        <th data-name="dnro" class="<?= $Page->dnro->headerCellClass() ?>"><div id="elh_cabfac_dnro" class="cabfac_dnro"><?= $Page->renderFieldHeader($Page->dnro) ?></div></th>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
        <th data-name="pisodto" class="<?= $Page->pisodto->headerCellClass() ?>"><div id="elh_cabfac_pisodto" class="cabfac_pisodto"><?= $Page->renderFieldHeader($Page->pisodto) ?></div></th>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
        <th data-name="codpost" class="<?= $Page->codpost->headerCellClass() ?>"><div id="elh_cabfac_codpost" class="cabfac_codpost"><?= $Page->renderFieldHeader($Page->codpost) ?></div></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th data-name="codpais" class="<?= $Page->codpais->headerCellClass() ?>"><div id="elh_cabfac_codpais" class="cabfac_codpais"><?= $Page->renderFieldHeader($Page->codpais) ?></div></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th data-name="codprov" class="<?= $Page->codprov->headerCellClass() ?>"><div id="elh_cabfac_codprov" class="cabfac_codprov"><?= $Page->renderFieldHeader($Page->codprov) ?></div></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th data-name="codloc" class="<?= $Page->codloc->headerCellClass() ?>"><div id="elh_cabfac_codloc" class="cabfac_codloc"><?= $Page->renderFieldHeader($Page->codloc) ?></div></th>
<?php } ?>
<?php if ($Page->telef->Visible) { // telef ?>
        <th data-name="telef" class="<?= $Page->telef->headerCellClass() ?>"><div id="elh_cabfac_telef" class="cabfac_telef"><?= $Page->renderFieldHeader($Page->telef) ?></div></th>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th data-name="codrem" class="<?= $Page->codrem->headerCellClass() ?>"><div id="elh_cabfac_codrem" class="cabfac_codrem"><?= $Page->renderFieldHeader($Page->codrem) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_cabfac_estado" class="cabfac_estado"><?= $Page->renderFieldHeader($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
        <th data-name="emitido" class="<?= $Page->emitido->headerCellClass() ?>"><div id="elh_cabfac_emitido" class="cabfac_emitido"><?= $Page->renderFieldHeader($Page->emitido) ?></div></th>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
        <th data-name="moneda" class="<?= $Page->moneda->headerCellClass() ?>"><div id="elh_cabfac_moneda" class="cabfac_moneda"><?= $Page->renderFieldHeader($Page->moneda) ?></div></th>
<?php } ?>
<?php if ($Page->totneto->Visible) { // totneto ?>
        <th data-name="totneto" class="<?= $Page->totneto->headerCellClass() ?>"><div id="elh_cabfac_totneto" class="cabfac_totneto"><?= $Page->renderFieldHeader($Page->totneto) ?></div></th>
<?php } ?>
<?php if ($Page->totbruto->Visible) { // totbruto ?>
        <th data-name="totbruto" class="<?= $Page->totbruto->headerCellClass() ?>"><div id="elh_cabfac_totbruto" class="cabfac_totbruto"><?= $Page->renderFieldHeader($Page->totbruto) ?></div></th>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
        <th data-name="totiva105" class="<?= $Page->totiva105->headerCellClass() ?>"><div id="elh_cabfac_totiva105" class="cabfac_totiva105"><?= $Page->renderFieldHeader($Page->totiva105) ?></div></th>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
        <th data-name="totiva21" class="<?= $Page->totiva21->headerCellClass() ?>"><div id="elh_cabfac_totiva21" class="cabfac_totiva21"><?= $Page->renderFieldHeader($Page->totiva21) ?></div></th>
<?php } ?>
<?php if ($Page->totimp->Visible) { // totimp ?>
        <th data-name="totimp" class="<?= $Page->totimp->headerCellClass() ?>"><div id="elh_cabfac_totimp" class="cabfac_totimp"><?= $Page->renderFieldHeader($Page->totimp) ?></div></th>
<?php } ?>
<?php if ($Page->totcomis->Visible) { // totcomis ?>
        <th data-name="totcomis" class="<?= $Page->totcomis->headerCellClass() ?>"><div id="elh_cabfac_totcomis" class="cabfac_totcomis"><?= $Page->renderFieldHeader($Page->totcomis) ?></div></th>
<?php } ?>
<?php if ($Page->totneto105->Visible) { // totneto105 ?>
        <th data-name="totneto105" class="<?= $Page->totneto105->headerCellClass() ?>"><div id="elh_cabfac_totneto105" class="cabfac_totneto105"><?= $Page->renderFieldHeader($Page->totneto105) ?></div></th>
<?php } ?>
<?php if ($Page->totneto21->Visible) { // totneto21 ?>
        <th data-name="totneto21" class="<?= $Page->totneto21->headerCellClass() ?>"><div id="elh_cabfac_totneto21" class="cabfac_totneto21"><?= $Page->renderFieldHeader($Page->totneto21) ?></div></th>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <th data-name="tipoiva" class="<?= $Page->tipoiva->headerCellClass() ?>"><div id="elh_cabfac_tipoiva" class="cabfac_tipoiva"><?= $Page->renderFieldHeader($Page->tipoiva) ?></div></th>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
        <th data-name="porciva" class="<?= $Page->porciva->headerCellClass() ?>"><div id="elh_cabfac_porciva" class="cabfac_porciva"><?= $Page->renderFieldHeader($Page->porciva) ?></div></th>
<?php } ?>
<?php if ($Page->nrengs->Visible) { // nrengs ?>
        <th data-name="nrengs" class="<?= $Page->nrengs->headerCellClass() ?>"><div id="elh_cabfac_nrengs" class="cabfac_nrengs"><?= $Page->renderFieldHeader($Page->nrengs) ?></div></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Page->fechahora->headerCellClass() ?>"><div id="elh_cabfac_fechahora" class="cabfac_fechahora"><?= $Page->renderFieldHeader($Page->fechahora) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_cabfac_usuario" class="cabfac_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <th data-name="tieneresol" class="<?= $Page->tieneresol->headerCellClass() ?>"><div id="elh_cabfac_tieneresol" class="cabfac_tieneresol"><?= $Page->renderFieldHeader($Page->tieneresol) ?></div></th>
<?php } ?>
<?php if ($Page->concepto->Visible) { // concepto ?>
        <th data-name="concepto" class="<?= $Page->concepto->headerCellClass() ?>"><div id="elh_cabfac_concepto" class="cabfac_concepto"><?= $Page->renderFieldHeader($Page->concepto) ?></div></th>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <th data-name="nrodoc" class="<?= $Page->nrodoc->headerCellClass() ?>"><div id="elh_cabfac_nrodoc" class="cabfac_nrodoc"><?= $Page->renderFieldHeader($Page->nrodoc) ?></div></th>
<?php } ?>
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
        <th data-name="tcompsal" class="<?= $Page->tcompsal->headerCellClass() ?>"><div id="elh_cabfac_tcompsal" class="cabfac_tcompsal"><?= $Page->renderFieldHeader($Page->tcompsal) ?></div></th>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
        <th data-name="seriesal" class="<?= $Page->seriesal->headerCellClass() ?>"><div id="elh_cabfac_seriesal" class="cabfac_seriesal"><?= $Page->renderFieldHeader($Page->seriesal) ?></div></th>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <th data-name="ncompsal" class="<?= $Page->ncompsal->headerCellClass() ?>"><div id="elh_cabfac_ncompsal" class="cabfac_ncompsal"><?= $Page->renderFieldHeader($Page->ncompsal) ?></div></th>
<?php } ?>
<?php if ($Page->en_liquid->Visible) { // en_liquid ?>
        <th data-name="en_liquid" class="<?= $Page->en_liquid->headerCellClass() ?>"><div id="elh_cabfac_en_liquid" class="cabfac_en_liquid"><?= $Page->renderFieldHeader($Page->en_liquid) ?></div></th>
<?php } ?>
<?php if ($Page->CAE->Visible) { // CAE ?>
        <th data-name="CAE" class="<?= $Page->CAE->headerCellClass() ?>"><div id="elh_cabfac_CAE" class="cabfac_CAE"><?= $Page->renderFieldHeader($Page->CAE) ?></div></th>
<?php } ?>
<?php if ($Page->CAEFchVto->Visible) { // CAEFchVto ?>
        <th data-name="CAEFchVto" class="<?= $Page->CAEFchVto->headerCellClass() ?>"><div id="elh_cabfac_CAEFchVto" class="cabfac_CAEFchVto"><?= $Page->renderFieldHeader($Page->CAEFchVto) ?></div></th>
<?php } ?>
<?php if ($Page->Resultado->Visible) { // Resultado ?>
        <th data-name="Resultado" class="<?= $Page->Resultado->headerCellClass() ?>"><div id="elh_cabfac_Resultado" class="cabfac_Resultado"><?= $Page->renderFieldHeader($Page->Resultado) ?></div></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th data-name="usuarioultmod" class="<?= $Page->usuarioultmod->headerCellClass() ?>"><div id="elh_cabfac_usuarioultmod" class="cabfac_usuarioultmod"><?= $Page->renderFieldHeader($Page->usuarioultmod) ?></div></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th data-name="fecultmod" class="<?= $Page->fecultmod->headerCellClass() ?>"><div id="elh_cabfac_fecultmod" class="cabfac_fecultmod"><?= $Page->renderFieldHeader($Page->fecultmod) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_codnum" class="el_cabfac_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_tcomp" class="el_cabfac_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->serie->Visible) { // serie ?>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_serie" class="el_cabfac_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_ncomp" class="el_cabfac_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecval->Visible) { // fecval ?>
        <td data-name="fecval"<?= $Page->fecval->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_fecval" class="el_cabfac_fecval">
<span<?= $Page->fecval->viewAttributes() ?>>
<?= $Page->fecval->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecdoc->Visible) { // fecdoc ?>
        <td data-name="fecdoc"<?= $Page->fecdoc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_fecdoc" class="el_cabfac_fecdoc">
<span<?= $Page->fecdoc->viewAttributes() ?>>
<?= $Page->fecdoc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecreg->Visible) { // fecreg ?>
        <td data-name="fecreg"<?= $Page->fecreg->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_fecreg" class="el_cabfac_fecreg">
<span<?= $Page->fecreg->viewAttributes() ?>>
<?= $Page->fecreg->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cliente->Visible) { // cliente ?>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_cliente" class="el_cabfac_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->direc->Visible) { // direc ?>
        <td data-name="direc"<?= $Page->direc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_direc" class="el_cabfac_direc">
<span<?= $Page->direc->viewAttributes() ?>>
<?= $Page->direc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dnro->Visible) { // dnro ?>
        <td data-name="dnro"<?= $Page->dnro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_dnro" class="el_cabfac_dnro">
<span<?= $Page->dnro->viewAttributes() ?>>
<?= $Page->dnro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pisodto->Visible) { // pisodto ?>
        <td data-name="pisodto"<?= $Page->pisodto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_pisodto" class="el_cabfac_pisodto">
<span<?= $Page->pisodto->viewAttributes() ?>>
<?= $Page->pisodto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpost->Visible) { // codpost ?>
        <td data-name="codpost"<?= $Page->codpost->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_codpost" class="el_cabfac_codpost">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpais->Visible) { // codpais ?>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_codpais" class="el_cabfac_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codprov->Visible) { // codprov ?>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_codprov" class="el_cabfac_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codloc->Visible) { // codloc ?>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_codloc" class="el_cabfac_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telef->Visible) { // telef ?>
        <td data-name="telef"<?= $Page->telef->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_telef" class="el_cabfac_telef">
<span<?= $Page->telef->viewAttributes() ?>>
<?= $Page->telef->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codrem->Visible) { // codrem ?>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_codrem" class="el_cabfac_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_estado" class="el_cabfac_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->emitido->Visible) { // emitido ?>
        <td data-name="emitido"<?= $Page->emitido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_emitido" class="el_cabfac_emitido">
<span<?= $Page->emitido->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_emitido_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->emitido->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->emitido->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_emitido_<?= $Page->RowCount ?>"></label>
</div>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->moneda->Visible) { // moneda ?>
        <td data-name="moneda"<?= $Page->moneda->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_moneda" class="el_cabfac_moneda">
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totneto->Visible) { // totneto ?>
        <td data-name="totneto"<?= $Page->totneto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_totneto" class="el_cabfac_totneto">
<span<?= $Page->totneto->viewAttributes() ?>>
<?= $Page->totneto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totbruto->Visible) { // totbruto ?>
        <td data-name="totbruto"<?= $Page->totbruto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_totbruto" class="el_cabfac_totbruto">
<span<?= $Page->totbruto->viewAttributes() ?>>
<?= $Page->totbruto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totiva105->Visible) { // totiva105 ?>
        <td data-name="totiva105"<?= $Page->totiva105->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_totiva105" class="el_cabfac_totiva105">
<span<?= $Page->totiva105->viewAttributes() ?>>
<?= $Page->totiva105->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totiva21->Visible) { // totiva21 ?>
        <td data-name="totiva21"<?= $Page->totiva21->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_totiva21" class="el_cabfac_totiva21">
<span<?= $Page->totiva21->viewAttributes() ?>>
<?= $Page->totiva21->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totimp->Visible) { // totimp ?>
        <td data-name="totimp"<?= $Page->totimp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_totimp" class="el_cabfac_totimp">
<span<?= $Page->totimp->viewAttributes() ?>>
<?= $Page->totimp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totcomis->Visible) { // totcomis ?>
        <td data-name="totcomis"<?= $Page->totcomis->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_totcomis" class="el_cabfac_totcomis">
<span<?= $Page->totcomis->viewAttributes() ?>>
<?= $Page->totcomis->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totneto105->Visible) { // totneto105 ?>
        <td data-name="totneto105"<?= $Page->totneto105->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_totneto105" class="el_cabfac_totneto105">
<span<?= $Page->totneto105->viewAttributes() ?>>
<?= $Page->totneto105->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totneto21->Visible) { // totneto21 ?>
        <td data-name="totneto21"<?= $Page->totneto21->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_totneto21" class="el_cabfac_totneto21">
<span<?= $Page->totneto21->viewAttributes() ?>>
<?= $Page->totneto21->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <td data-name="tipoiva"<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_tipoiva" class="el_cabfac_tipoiva">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->porciva->Visible) { // porciva ?>
        <td data-name="porciva"<?= $Page->porciva->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_porciva" class="el_cabfac_porciva">
<span<?= $Page->porciva->viewAttributes() ?>>
<?= $Page->porciva->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nrengs->Visible) { // nrengs ?>
        <td data-name="nrengs"<?= $Page->nrengs->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_nrengs" class="el_cabfac_nrengs">
<span<?= $Page->nrengs->viewAttributes() ?>>
<?= $Page->nrengs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_fechahora" class="el_cabfac_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_usuario" class="el_cabfac_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <td data-name="tieneresol"<?= $Page->tieneresol->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_tieneresol" class="el_cabfac_tieneresol">
<span<?= $Page->tieneresol->viewAttributes() ?>>
<?= $Page->tieneresol->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->concepto->Visible) { // concepto ?>
        <td data-name="concepto"<?= $Page->concepto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_concepto" class="el_cabfac_concepto">
<span<?= $Page->concepto->viewAttributes() ?>>
<?= $Page->concepto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <td data-name="nrodoc"<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_nrodoc" class="el_cabfac_nrodoc">
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tcompsal->Visible) { // tcompsal ?>
        <td data-name="tcompsal"<?= $Page->tcompsal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_tcompsal" class="el_cabfac_tcompsal">
<span<?= $Page->tcompsal->viewAttributes() ?>>
<?= $Page->tcompsal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->seriesal->Visible) { // seriesal ?>
        <td data-name="seriesal"<?= $Page->seriesal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_seriesal" class="el_cabfac_seriesal">
<span<?= $Page->seriesal->viewAttributes() ?>>
<?= $Page->seriesal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <td data-name="ncompsal"<?= $Page->ncompsal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_ncompsal" class="el_cabfac_ncompsal">
<span<?= $Page->ncompsal->viewAttributes() ?>>
<?= $Page->ncompsal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->en_liquid->Visible) { // en_liquid ?>
        <td data-name="en_liquid"<?= $Page->en_liquid->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_en_liquid" class="el_cabfac_en_liquid">
<span<?= $Page->en_liquid->viewAttributes() ?>>
<?= $Page->en_liquid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CAE->Visible) { // CAE ?>
        <td data-name="CAE"<?= $Page->CAE->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_CAE" class="el_cabfac_CAE">
<span<?= $Page->CAE->viewAttributes() ?>>
<?= $Page->CAE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CAEFchVto->Visible) { // CAEFchVto ?>
        <td data-name="CAEFchVto"<?= $Page->CAEFchVto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_CAEFchVto" class="el_cabfac_CAEFchVto">
<span<?= $Page->CAEFchVto->viewAttributes() ?>>
<?= $Page->CAEFchVto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Resultado->Visible) { // Resultado ?>
        <td data-name="Resultado"<?= $Page->Resultado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_Resultado" class="el_cabfac_Resultado">
<span<?= $Page->Resultado->viewAttributes() ?>>
<?= $Page->Resultado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_usuarioultmod" class="el_cabfac_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_cabfac_fecultmod" class="el_cabfac_fecultmod">
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
    ew.addEventHandlers("cabfac");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
