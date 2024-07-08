<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$EntidadesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { entidades: currentTable } });
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
<form name="fentidadessrch" id="fentidadessrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="fentidadessrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { entidades: currentTable } });
var currentForm;
var fentidadessrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fentidadessrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fentidadessrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fentidadessrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fentidadessrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fentidadessrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="entidades">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_entidades" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_entidadeslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Page->codnum->headerCellClass() ?>"><div id="elh_entidades_codnum" class="entidades_codnum"><?= $Page->renderFieldHeader($Page->codnum) ?></div></th>
<?php } ?>
<?php if ($Page->razsoc->Visible) { // razsoc ?>
        <th data-name="razsoc" class="<?= $Page->razsoc->headerCellClass() ?>"><div id="elh_entidades_razsoc" class="entidades_razsoc"><?= $Page->renderFieldHeader($Page->razsoc) ?></div></th>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
        <th data-name="calle" class="<?= $Page->calle->headerCellClass() ?>"><div id="elh_entidades_calle" class="entidades_calle"><?= $Page->renderFieldHeader($Page->calle) ?></div></th>
<?php } ?>
<?php if ($Page->numero->Visible) { // numero ?>
        <th data-name="numero" class="<?= $Page->numero->headerCellClass() ?>"><div id="elh_entidades_numero" class="entidades_numero"><?= $Page->renderFieldHeader($Page->numero) ?></div></th>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
        <th data-name="pisodto" class="<?= $Page->pisodto->headerCellClass() ?>"><div id="elh_entidades_pisodto" class="entidades_pisodto"><?= $Page->renderFieldHeader($Page->pisodto) ?></div></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th data-name="codpais" class="<?= $Page->codpais->headerCellClass() ?>"><div id="elh_entidades_codpais" class="entidades_codpais"><?= $Page->renderFieldHeader($Page->codpais) ?></div></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th data-name="codprov" class="<?= $Page->codprov->headerCellClass() ?>"><div id="elh_entidades_codprov" class="entidades_codprov"><?= $Page->renderFieldHeader($Page->codprov) ?></div></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th data-name="codloc" class="<?= $Page->codloc->headerCellClass() ?>"><div id="elh_entidades_codloc" class="entidades_codloc"><?= $Page->renderFieldHeader($Page->codloc) ?></div></th>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
        <th data-name="codpost" class="<?= $Page->codpost->headerCellClass() ?>"><div id="elh_entidades_codpost" class="entidades_codpost"><?= $Page->renderFieldHeader($Page->codpost) ?></div></th>
<?php } ?>
<?php if ($Page->tellinea->Visible) { // tellinea ?>
        <th data-name="tellinea" class="<?= $Page->tellinea->headerCellClass() ?>"><div id="elh_entidades_tellinea" class="entidades_tellinea"><?= $Page->renderFieldHeader($Page->tellinea) ?></div></th>
<?php } ?>
<?php if ($Page->telcelu->Visible) { // telcelu ?>
        <th data-name="telcelu" class="<?= $Page->telcelu->headerCellClass() ?>"><div id="elh_entidades_telcelu" class="entidades_telcelu"><?= $Page->renderFieldHeader($Page->telcelu) ?></div></th>
<?php } ?>
<?php if ($Page->tipoent->Visible) { // tipoent ?>
        <th data-name="tipoent" class="<?= $Page->tipoent->headerCellClass() ?>"><div id="elh_entidades_tipoent" class="entidades_tipoent"><?= $Page->renderFieldHeader($Page->tipoent) ?></div></th>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <th data-name="tipoiva" class="<?= $Page->tipoiva->headerCellClass() ?>"><div id="elh_entidades_tipoiva" class="entidades_tipoiva"><?= $Page->renderFieldHeader($Page->tipoiva) ?></div></th>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
        <th data-name="cuit" class="<?= $Page->cuit->headerCellClass() ?>"><div id="elh_entidades_cuit" class="entidades_cuit"><?= $Page->renderFieldHeader($Page->cuit) ?></div></th>
<?php } ?>
<?php if ($Page->calif->Visible) { // calif ?>
        <th data-name="calif" class="<?= $Page->calif->headerCellClass() ?>"><div id="elh_entidades_calif" class="entidades_calif"><?= $Page->renderFieldHeader($Page->calif) ?></div></th>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <th data-name="fecalta" class="<?= $Page->fecalta->headerCellClass() ?>"><div id="elh_entidades_fecalta" class="entidades_fecalta"><?= $Page->renderFieldHeader($Page->fecalta) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_entidades_usuario" class="entidades_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->contacto->Visible) { // contacto ?>
        <th data-name="contacto" class="<?= $Page->contacto->headerCellClass() ?>"><div id="elh_entidades_contacto" class="entidades_contacto"><?= $Page->renderFieldHeader($Page->contacto) ?></div></th>
<?php } ?>
<?php if ($Page->mailcont->Visible) { // mailcont ?>
        <th data-name="mailcont" class="<?= $Page->mailcont->headerCellClass() ?>"><div id="elh_entidades_mailcont" class="entidades_mailcont"><?= $Page->renderFieldHeader($Page->mailcont) ?></div></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th data-name="cargo" class="<?= $Page->cargo->headerCellClass() ?>"><div id="elh_entidades_cargo" class="entidades_cargo"><?= $Page->renderFieldHeader($Page->cargo) ?></div></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Page->fechahora->headerCellClass() ?>"><div id="elh_entidades_fechahora" class="entidades_fechahora"><?= $Page->renderFieldHeader($Page->fechahora) ?></div></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th data-name="activo" class="<?= $Page->activo->headerCellClass() ?>"><div id="elh_entidades_activo" class="entidades_activo"><?= $Page->renderFieldHeader($Page->activo) ?></div></th>
<?php } ?>
<?php if ($Page->pagweb->Visible) { // pagweb ?>
        <th data-name="pagweb" class="<?= $Page->pagweb->headerCellClass() ?>"><div id="elh_entidades_pagweb" class="entidades_pagweb"><?= $Page->renderFieldHeader($Page->pagweb) ?></div></th>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
        <th data-name="tipoind" class="<?= $Page->tipoind->headerCellClass() ?>"><div id="elh_entidades_tipoind" class="entidades_tipoind"><?= $Page->renderFieldHeader($Page->tipoind) ?></div></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th data-name="usuarioultmod" class="<?= $Page->usuarioultmod->headerCellClass() ?>"><div id="elh_entidades_usuarioultmod" class="entidades_usuarioultmod"><?= $Page->renderFieldHeader($Page->usuarioultmod) ?></div></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th data-name="fecultmod" class="<?= $Page->fecultmod->headerCellClass() ?>"><div id="elh_entidades_fecultmod" class="entidades_fecultmod"><?= $Page->renderFieldHeader($Page->fecultmod) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_codnum" class="el_entidades_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->razsoc->Visible) { // razsoc ?>
        <td data-name="razsoc"<?= $Page->razsoc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_razsoc" class="el_entidades_razsoc">
<span<?= $Page->razsoc->viewAttributes() ?>>
<?= $Page->razsoc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->calle->Visible) { // calle ?>
        <td data-name="calle"<?= $Page->calle->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_calle" class="el_entidades_calle">
<span<?= $Page->calle->viewAttributes() ?>>
<?= $Page->calle->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->numero->Visible) { // numero ?>
        <td data-name="numero"<?= $Page->numero->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_numero" class="el_entidades_numero">
<span<?= $Page->numero->viewAttributes() ?>>
<?= $Page->numero->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pisodto->Visible) { // pisodto ?>
        <td data-name="pisodto"<?= $Page->pisodto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_pisodto" class="el_entidades_pisodto">
<span<?= $Page->pisodto->viewAttributes() ?>>
<?= $Page->pisodto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpais->Visible) { // codpais ?>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_codpais" class="el_entidades_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codprov->Visible) { // codprov ?>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_codprov" class="el_entidades_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codloc->Visible) { // codloc ?>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_codloc" class="el_entidades_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpost->Visible) { // codpost ?>
        <td data-name="codpost"<?= $Page->codpost->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_codpost" class="el_entidades_codpost">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tellinea->Visible) { // tellinea ?>
        <td data-name="tellinea"<?= $Page->tellinea->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_tellinea" class="el_entidades_tellinea">
<span<?= $Page->tellinea->viewAttributes() ?>>
<?= $Page->tellinea->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telcelu->Visible) { // telcelu ?>
        <td data-name="telcelu"<?= $Page->telcelu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_telcelu" class="el_entidades_telcelu">
<span<?= $Page->telcelu->viewAttributes() ?>>
<?= $Page->telcelu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipoent->Visible) { // tipoent ?>
        <td data-name="tipoent"<?= $Page->tipoent->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_tipoent" class="el_entidades_tipoent">
<span<?= $Page->tipoent->viewAttributes() ?>>
<?= $Page->tipoent->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <td data-name="tipoiva"<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_tipoiva" class="el_entidades_tipoiva">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cuit->Visible) { // cuit ?>
        <td data-name="cuit"<?= $Page->cuit->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_cuit" class="el_entidades_cuit">
<span<?= $Page->cuit->viewAttributes() ?>>
<?= $Page->cuit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->calif->Visible) { // calif ?>
        <td data-name="calif"<?= $Page->calif->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_calif" class="el_entidades_calif">
<span<?= $Page->calif->viewAttributes() ?>>
<?= $Page->calif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecalta->Visible) { // fecalta ?>
        <td data-name="fecalta"<?= $Page->fecalta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_fecalta" class="el_entidades_fecalta">
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_usuario" class="el_entidades_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contacto->Visible) { // contacto ?>
        <td data-name="contacto"<?= $Page->contacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_contacto" class="el_entidades_contacto">
<span<?= $Page->contacto->viewAttributes() ?>>
<?= $Page->contacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mailcont->Visible) { // mailcont ?>
        <td data-name="mailcont"<?= $Page->mailcont->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_mailcont" class="el_entidades_mailcont">
<span<?= $Page->mailcont->viewAttributes() ?>>
<?= $Page->mailcont->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cargo->Visible) { // cargo ?>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_cargo" class="el_entidades_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_fechahora" class="el_entidades_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->activo->Visible) { // activo ?>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_activo" class="el_entidades_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pagweb->Visible) { // pagweb ?>
        <td data-name="pagweb"<?= $Page->pagweb->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_pagweb" class="el_entidades_pagweb">
<span<?= $Page->pagweb->viewAttributes() ?>>
<?= $Page->pagweb->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipoind->Visible) { // tipoind ?>
        <td data-name="tipoind"<?= $Page->tipoind->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_tipoind" class="el_entidades_tipoind">
<span<?= $Page->tipoind->viewAttributes() ?>>
<?= $Page->tipoind->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_usuarioultmod" class="el_entidades_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_entidades_fecultmod" class="el_entidades_fecultmod">
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
    ew.addEventHandlers("entidades");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
