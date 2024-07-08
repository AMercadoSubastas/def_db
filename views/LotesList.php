<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LotesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { lotes: currentTable } });
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

        // Add fields
        .setFields([
            ["codrem", [fields.codrem.visible && fields.codrem.required ? ew.Validators.required(fields.codrem.caption) : null], fields.codrem.isInvalid],
            ["codcli", [fields.codcli.visible && fields.codcli.required ? ew.Validators.required(fields.codcli.caption) : null], fields.codcli.isInvalid],
            ["codrubro", [fields.codrubro.visible && fields.codrubro.required ? ew.Validators.required(fields.codrubro.caption) : null], fields.codrubro.isInvalid],
            ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
            ["moneda", [fields.moneda.visible && fields.moneda.required ? ew.Validators.required(fields.moneda.caption) : null], fields.moneda.isInvalid],
            ["preciobase", [fields.preciobase.visible && fields.preciobase.required ? ew.Validators.required(fields.preciobase.caption) : null], fields.preciobase.isInvalid],
            ["preciofinal", [fields.preciofinal.visible && fields.preciofinal.required ? ew.Validators.required(fields.preciofinal.caption) : null, ew.Validators.float], fields.preciofinal.isInvalid],
            ["comiscobr", [fields.comiscobr.visible && fields.comiscobr.required ? ew.Validators.required(fields.comiscobr.caption) : null, ew.Validators.float], fields.comiscobr.isInvalid],
            ["comispag", [fields.comispag.visible && fields.comispag.required ? ew.Validators.required(fields.comispag.caption) : null], fields.comispag.isInvalid],
            ["comprador", [fields.comprador.visible && fields.comprador.required ? ew.Validators.required(fields.comprador.caption) : null], fields.comprador.isInvalid],
            ["ivari", [fields.ivari.visible && fields.ivari.required ? ew.Validators.required(fields.ivari.caption) : null], fields.ivari.isInvalid],
            ["ivarni", [fields.ivarni.visible && fields.ivarni.required ? ew.Validators.required(fields.ivarni.caption) : null], fields.ivarni.isInvalid],
            ["codimpadic", [fields.codimpadic.visible && fields.codimpadic.required ? ew.Validators.required(fields.codimpadic.caption) : null], fields.codimpadic.isInvalid],
            ["impadic", [fields.impadic.visible && fields.impadic.required ? ew.Validators.required(fields.impadic.caption) : null], fields.impadic.isInvalid],
            ["descor", [fields.descor.visible && fields.descor.required ? ew.Validators.required(fields.descor.caption) : null], fields.descor.isInvalid],
            ["observ", [fields.observ.visible && fields.observ.required ? ew.Validators.required(fields.observ.caption) : null], fields.observ.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["fecalta", [fields.fecalta.visible && fields.fecalta.required ? ew.Validators.required(fields.fecalta.caption) : null], fields.fecalta.isInvalid],
            ["secuencia", [fields.secuencia.visible && fields.secuencia.required ? ew.Validators.required(fields.secuencia.caption) : null], fields.secuencia.isInvalid],
            ["codintlote", [fields.codintlote.visible && fields.codintlote.required ? ew.Validators.required(fields.codintlote.caption) : null], fields.codintlote.isInvalid],
            ["codintnum", [fields.codintnum.visible && fields.codintnum.required ? ew.Validators.required(fields.codintnum.caption) : null], fields.codintnum.isInvalid],
            ["codintsublote", [fields.codintsublote.visible && fields.codintsublote.required ? ew.Validators.required(fields.codintsublote.caption) : null], fields.codintsublote.isInvalid],
            ["usuarioultmod", [fields.usuarioultmod.visible && fields.usuarioultmod.required ? ew.Validators.required(fields.usuarioultmod.caption) : null], fields.usuarioultmod.isInvalid],
            ["fecultmod", [fields.fecultmod.visible && fields.fecultmod.required ? ew.Validators.required(fields.fecultmod.caption) : null], fields.fecultmod.isInvalid],
            ["dir_secuencia", [fields.dir_secuencia.visible && fields.dir_secuencia.required ? ew.Validators.required(fields.dir_secuencia.caption) : null], fields.dir_secuencia.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "codrem": <?= $Page->codrem->toClientList($Page) ?>,
            "estado": <?= $Page->estado->toClientList($Page) ?>,
            "dir_secuencia": <?= $Page->dir_secuencia->toClientList($Page) ?>,
        })
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "remates") {
    if ($Page->MasterRecordExists) {
        include_once "views/RematesMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="flotessrch" id="flotessrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" autocomplete="off">
<div id="flotessrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { lotes: currentTable } });
var currentForm;
var flotessrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("flotessrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="flotessrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="flotessrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="flotessrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="flotessrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="lotes">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "remates" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="remates">
<input type="hidden" name="fk_ncomp" value="<?= HtmlEncode($Page->codrem->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_lotes" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_loteslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th data-name="codrem" class="<?= $Page->codrem->headerCellClass() ?>"><div id="elh_lotes_codrem" class="lotes_codrem"><?= $Page->renderFieldHeader($Page->codrem) ?></div></th>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
        <th data-name="codcli" class="<?= $Page->codcli->headerCellClass() ?>"><div id="elh_lotes_codcli" class="lotes_codcli"><?= $Page->renderFieldHeader($Page->codcli) ?></div></th>
<?php } ?>
<?php if ($Page->codrubro->Visible) { // codrubro ?>
        <th data-name="codrubro" class="<?= $Page->codrubro->headerCellClass() ?>"><div id="elh_lotes_codrubro" class="lotes_codrubro"><?= $Page->renderFieldHeader($Page->codrubro) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_lotes_estado" class="lotes_estado"><?= $Page->renderFieldHeader($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
        <th data-name="moneda" class="<?= $Page->moneda->headerCellClass() ?>"><div id="elh_lotes_moneda" class="lotes_moneda"><?= $Page->renderFieldHeader($Page->moneda) ?></div></th>
<?php } ?>
<?php if ($Page->preciobase->Visible) { // preciobase ?>
        <th data-name="preciobase" class="<?= $Page->preciobase->headerCellClass() ?>"><div id="elh_lotes_preciobase" class="lotes_preciobase"><?= $Page->renderFieldHeader($Page->preciobase) ?></div></th>
<?php } ?>
<?php if ($Page->preciofinal->Visible) { // preciofinal ?>
        <th data-name="preciofinal" class="<?= $Page->preciofinal->headerCellClass() ?>"><div id="elh_lotes_preciofinal" class="lotes_preciofinal"><?= $Page->renderFieldHeader($Page->preciofinal) ?></div></th>
<?php } ?>
<?php if ($Page->comiscobr->Visible) { // comiscobr ?>
        <th data-name="comiscobr" class="<?= $Page->comiscobr->headerCellClass() ?>"><div id="elh_lotes_comiscobr" class="lotes_comiscobr"><?= $Page->renderFieldHeader($Page->comiscobr) ?></div></th>
<?php } ?>
<?php if ($Page->comispag->Visible) { // comispag ?>
        <th data-name="comispag" class="<?= $Page->comispag->headerCellClass() ?>"><div id="elh_lotes_comispag" class="lotes_comispag"><?= $Page->renderFieldHeader($Page->comispag) ?></div></th>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
        <th data-name="comprador" class="<?= $Page->comprador->headerCellClass() ?>"><div id="elh_lotes_comprador" class="lotes_comprador"><?= $Page->renderFieldHeader($Page->comprador) ?></div></th>
<?php } ?>
<?php if ($Page->ivari->Visible) { // ivari ?>
        <th data-name="ivari" class="<?= $Page->ivari->headerCellClass() ?>"><div id="elh_lotes_ivari" class="lotes_ivari"><?= $Page->renderFieldHeader($Page->ivari) ?></div></th>
<?php } ?>
<?php if ($Page->ivarni->Visible) { // ivarni ?>
        <th data-name="ivarni" class="<?= $Page->ivarni->headerCellClass() ?>"><div id="elh_lotes_ivarni" class="lotes_ivarni"><?= $Page->renderFieldHeader($Page->ivarni) ?></div></th>
<?php } ?>
<?php if ($Page->codimpadic->Visible) { // codimpadic ?>
        <th data-name="codimpadic" class="<?= $Page->codimpadic->headerCellClass() ?>"><div id="elh_lotes_codimpadic" class="lotes_codimpadic"><?= $Page->renderFieldHeader($Page->codimpadic) ?></div></th>
<?php } ?>
<?php if ($Page->impadic->Visible) { // impadic ?>
        <th data-name="impadic" class="<?= $Page->impadic->headerCellClass() ?>"><div id="elh_lotes_impadic" class="lotes_impadic"><?= $Page->renderFieldHeader($Page->impadic) ?></div></th>
<?php } ?>
<?php if ($Page->descor->Visible) { // descor ?>
        <th data-name="descor" class="<?= $Page->descor->headerCellClass() ?>"><div id="elh_lotes_descor" class="lotes_descor"><?= $Page->renderFieldHeader($Page->descor) ?></div></th>
<?php } ?>
<?php if ($Page->observ->Visible) { // observ ?>
        <th data-name="observ" class="<?= $Page->observ->headerCellClass() ?>"><div id="elh_lotes_observ" class="lotes_observ"><?= $Page->renderFieldHeader($Page->observ) ?></div></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Page->usuario->headerCellClass() ?>"><div id="elh_lotes_usuario" class="lotes_usuario"><?= $Page->renderFieldHeader($Page->usuario) ?></div></th>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <th data-name="fecalta" class="<?= $Page->fecalta->headerCellClass() ?>"><div id="elh_lotes_fecalta" class="lotes_fecalta"><?= $Page->renderFieldHeader($Page->fecalta) ?></div></th>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <th data-name="secuencia" class="<?= $Page->secuencia->headerCellClass() ?>"><div id="elh_lotes_secuencia" class="lotes_secuencia"><?= $Page->renderFieldHeader($Page->secuencia) ?></div></th>
<?php } ?>
<?php if ($Page->codintlote->Visible) { // codintlote ?>
        <th data-name="codintlote" class="<?= $Page->codintlote->headerCellClass() ?>"><div id="elh_lotes_codintlote" class="lotes_codintlote"><?= $Page->renderFieldHeader($Page->codintlote) ?></div></th>
<?php } ?>
<?php if ($Page->codintnum->Visible) { // codintnum ?>
        <th data-name="codintnum" class="<?= $Page->codintnum->headerCellClass() ?>"><div id="elh_lotes_codintnum" class="lotes_codintnum"><?= $Page->renderFieldHeader($Page->codintnum) ?></div></th>
<?php } ?>
<?php if ($Page->codintsublote->Visible) { // codintsublote ?>
        <th data-name="codintsublote" class="<?= $Page->codintsublote->headerCellClass() ?>"><div id="elh_lotes_codintsublote" class="lotes_codintsublote"><?= $Page->renderFieldHeader($Page->codintsublote) ?></div></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th data-name="usuarioultmod" class="<?= $Page->usuarioultmod->headerCellClass() ?>"><div id="elh_lotes_usuarioultmod" class="lotes_usuarioultmod"><?= $Page->renderFieldHeader($Page->usuarioultmod) ?></div></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th data-name="fecultmod" class="<?= $Page->fecultmod->headerCellClass() ?>"><div id="elh_lotes_fecultmod" class="lotes_fecultmod"><?= $Page->renderFieldHeader($Page->fecultmod) ?></div></th>
<?php } ?>
<?php if ($Page->dir_secuencia->Visible) { // dir_secuencia ?>
        <th data-name="dir_secuencia" class="<?= $Page->dir_secuencia->headerCellClass() ?>"><div id="elh_lotes_dir_secuencia" class="lotes_dir_secuencia"><?= $Page->renderFieldHeader($Page->dir_secuencia) ?></div></th>
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

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow()) &&
            $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->codrem->Visible) { // codrem ?>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->codrem->getSessionValue() != "") { ?>
<span<?= $Page->codrem->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->codrem->getDisplayValue($Page->codrem->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_codrem" name="x<?= $Page->RowIndex ?>_codrem" value="<?= HtmlEncode($Page->codrem->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codrem" class="el_lotes_codrem">
<?php
if (IsRTL()) {
    $Page->codrem->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Page->RowIndex ?>_codrem" class="ew-auto-suggest">
    <input type="<?= $Page->codrem->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_codrem" id="sv_x<?= $Page->RowIndex ?>_codrem" value="<?= RemoveHtml($Page->codrem->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->codrem->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->codrem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codrem->formatPattern()) ?>"<?= $Page->codrem->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="lotes" data-field="x_codrem" data-input="sv_x<?= $Page->RowIndex ?>_codrem" data-value-separator="<?= $Page->codrem->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_codrem" id="x<?= $Page->RowIndex ?>_codrem" value="<?= HtmlEncode($Page->codrem->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Page->codrem->getErrorMessage() ?></div>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    <?= $Page->FormName ?>.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_codrem","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->codrem->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.lotes.fields.codrem.autoSuggestOptions));
});
</script>
<?= $Page->codrem->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_codrem") ?>
</span>
<?php } ?>
<input type="hidden" data-table="lotes" data-field="x_codrem" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_codrem" id="o<?= $Page->RowIndex ?>_codrem" value="<?= HtmlEncode($Page->codrem->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codrem" class="el_lotes_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->codrem->getDisplayValue($Page->codrem->EditValue) ?></span></span>
<input type="hidden" data-table="lotes" data-field="x_codrem" data-hidden="1" name="x<?= $Page->RowIndex ?>_codrem" id="x<?= $Page->RowIndex ?>_codrem" value="<?= HtmlEncode($Page->codrem->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codrem" class="el_lotes_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->codcli->Visible) { // codcli ?>
        <td data-name="codcli"<?= $Page->codcli->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codcli" class="el_lotes_codcli">
<input type="<?= $Page->codcli->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_codcli" id="x<?= $Page->RowIndex ?>_codcli" data-table="lotes" data-field="x_codcli" value="<?= $Page->codcli->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codcli->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codcli->formatPattern()) ?>"<?= $Page->codcli->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->codcli->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codcli" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_codcli" id="o<?= $Page->RowIndex ?>_codcli" value="<?= HtmlEncode($Page->codcli->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codcli" class="el_lotes_codcli">
<input type="hidden" data-table="lotes" data-field="x_codcli" data-hidden="1" name="x<?= $Page->RowIndex ?>_codcli" id="x<?= $Page->RowIndex ?>_codcli" value="<?= HtmlEncode($Page->codcli->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codcli" class="el_lotes_codcli">
<span<?= $Page->codcli->viewAttributes() ?>>
<?= $Page->codcli->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->codrubro->Visible) { // codrubro ?>
        <td data-name="codrubro"<?= $Page->codrubro->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codrubro" class="el_lotes_codrubro">
<input type="<?= $Page->codrubro->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_codrubro" id="x<?= $Page->RowIndex ?>_codrubro" data-table="lotes" data-field="x_codrubro" value="<?= $Page->codrubro->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codrubro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codrubro->formatPattern()) ?>"<?= $Page->codrubro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->codrubro->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codrubro" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_codrubro" id="o<?= $Page->RowIndex ?>_codrubro" value="<?= HtmlEncode($Page->codrubro->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codrubro" class="el_lotes_codrubro">
<input type="hidden" data-table="lotes" data-field="x_codrubro" data-hidden="1" name="x<?= $Page->RowIndex ?>_codrubro" id="x<?= $Page->RowIndex ?>_codrubro" value="<?= HtmlEncode($Page->codrubro->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codrubro" class="el_lotes_codrubro">
<span<?= $Page->codrubro->viewAttributes() ?>>
<?= $Page->codrubro->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_estado" class="el_lotes_estado">
<template id="tp_x<?= $Page->RowIndex ?>_estado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="lotes" data-field="x_estado" name="x<?= $Page->RowIndex ?>_estado" id="x<?= $Page->RowIndex ?>_estado"<?= $Page->estado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_estado" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_estado"
    name="x<?= $Page->RowIndex ?>_estado"
    value="<?= HtmlEncode($Page->estado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_estado"
    data-target="dsl_x<?= $Page->RowIndex ?>_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Page->estado->isInvalidClass() ?>"
    data-table="lotes"
    data-field="x_estado"
    data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
    <?= $Page->estado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_estado" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_estado" id="o<?= $Page->RowIndex ?>_estado" value="<?= HtmlEncode($Page->estado->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_estado" class="el_lotes_estado">
<template id="tp_x<?= $Page->RowIndex ?>_estado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="lotes" data-field="x_estado" name="x<?= $Page->RowIndex ?>_estado" id="x<?= $Page->RowIndex ?>_estado"<?= $Page->estado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_estado" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_estado"
    name="x<?= $Page->RowIndex ?>_estado"
    value="<?= HtmlEncode($Page->estado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_estado"
    data-target="dsl_x<?= $Page->RowIndex ?>_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Page->estado->isInvalidClass() ?>"
    data-table="lotes"
    data-field="x_estado"
    data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
    <?= $Page->estado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_estado" class="el_lotes_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->moneda->Visible) { // moneda ?>
        <td data-name="moneda"<?= $Page->moneda->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_moneda" class="el_lotes_moneda">
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" name="x<?= $Page->RowIndex ?>_moneda" id="x<?= $Page->RowIndex ?>_moneda" value="<?= HtmlEncode($Page->moneda->CurrentValue) ?>">
</span>
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_moneda" id="o<?= $Page->RowIndex ?>_moneda" value="<?= HtmlEncode($Page->moneda->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_moneda" class="el_lotes_moneda">
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" name="x<?= $Page->RowIndex ?>_moneda" id="x<?= $Page->RowIndex ?>_moneda" value="<?= HtmlEncode($Page->moneda->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_moneda" class="el_lotes_moneda">
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->preciobase->Visible) { // preciobase ?>
        <td data-name="preciobase"<?= $Page->preciobase->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_preciobase" class="el_lotes_preciobase">
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" name="x<?= $Page->RowIndex ?>_preciobase" id="x<?= $Page->RowIndex ?>_preciobase" value="<?= HtmlEncode($Page->preciobase->CurrentValue) ?>">
</span>
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_preciobase" id="o<?= $Page->RowIndex ?>_preciobase" value="<?= HtmlEncode($Page->preciobase->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_preciobase" class="el_lotes_preciobase">
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" name="x<?= $Page->RowIndex ?>_preciobase" id="x<?= $Page->RowIndex ?>_preciobase" value="<?= HtmlEncode($Page->preciobase->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_preciobase" class="el_lotes_preciobase">
<span<?= $Page->preciobase->viewAttributes() ?>>
<?= $Page->preciobase->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->preciofinal->Visible) { // preciofinal ?>
        <td data-name="preciofinal"<?= $Page->preciofinal->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_preciofinal" class="el_lotes_preciofinal">
<input type="<?= $Page->preciofinal->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_preciofinal" id="x<?= $Page->RowIndex ?>_preciofinal" data-table="lotes" data-field="x_preciofinal" value="<?= $Page->preciofinal->EditValue ?>" size="100" placeholder="<?= HtmlEncode($Page->preciofinal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->preciofinal->formatPattern()) ?>"<?= $Page->preciofinal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->preciofinal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_preciofinal" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_preciofinal" id="o<?= $Page->RowIndex ?>_preciofinal" value="<?= HtmlEncode($Page->preciofinal->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_preciofinal" class="el_lotes_preciofinal">
<input type="<?= $Page->preciofinal->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_preciofinal" id="x<?= $Page->RowIndex ?>_preciofinal" data-table="lotes" data-field="x_preciofinal" value="<?= $Page->preciofinal->EditValue ?>" size="100" placeholder="<?= HtmlEncode($Page->preciofinal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->preciofinal->formatPattern()) ?>"<?= $Page->preciofinal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->preciofinal->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_preciofinal" class="el_lotes_preciofinal">
<span<?= $Page->preciofinal->viewAttributes() ?>>
<?= $Page->preciofinal->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->comiscobr->Visible) { // comiscobr ?>
        <td data-name="comiscobr"<?= $Page->comiscobr->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comiscobr" class="el_lotes_comiscobr">
<input type="<?= $Page->comiscobr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_comiscobr" id="x<?= $Page->RowIndex ?>_comiscobr" data-table="lotes" data-field="x_comiscobr" value="<?= $Page->comiscobr->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->comiscobr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->comiscobr->formatPattern()) ?>"<?= $Page->comiscobr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->comiscobr->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_comiscobr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_comiscobr" id="o<?= $Page->RowIndex ?>_comiscobr" value="<?= HtmlEncode($Page->comiscobr->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comiscobr" class="el_lotes_comiscobr">
<input type="<?= $Page->comiscobr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_comiscobr" id="x<?= $Page->RowIndex ?>_comiscobr" data-table="lotes" data-field="x_comiscobr" value="<?= $Page->comiscobr->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->comiscobr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->comiscobr->formatPattern()) ?>"<?= $Page->comiscobr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->comiscobr->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comiscobr" class="el_lotes_comiscobr">
<span<?= $Page->comiscobr->viewAttributes() ?>>
<?= $Page->comiscobr->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->comispag->Visible) { // comispag ?>
        <td data-name="comispag"<?= $Page->comispag->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comispag" class="el_lotes_comispag">
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" name="x<?= $Page->RowIndex ?>_comispag" id="x<?= $Page->RowIndex ?>_comispag" value="<?= HtmlEncode($Page->comispag->CurrentValue) ?>">
</span>
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_comispag" id="o<?= $Page->RowIndex ?>_comispag" value="<?= HtmlEncode($Page->comispag->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comispag" class="el_lotes_comispag">
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" name="x<?= $Page->RowIndex ?>_comispag" id="x<?= $Page->RowIndex ?>_comispag" value="<?= HtmlEncode($Page->comispag->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comispag" class="el_lotes_comispag">
<span<?= $Page->comispag->viewAttributes() ?>>
<?= $Page->comispag->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->comprador->Visible) { // comprador ?>
        <td data-name="comprador"<?= $Page->comprador->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comprador" class="el_lotes_comprador">
<input type="<?= $Page->comprador->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_comprador" id="x<?= $Page->RowIndex ?>_comprador" data-table="lotes" data-field="x_comprador" value="<?= $Page->comprador->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->comprador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->comprador->formatPattern()) ?>"<?= $Page->comprador->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->comprador->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_comprador" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_comprador" id="o<?= $Page->RowIndex ?>_comprador" value="<?= HtmlEncode($Page->comprador->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comprador" class="el_lotes_comprador">
<input type="hidden" data-table="lotes" data-field="x_comprador" data-hidden="1" name="x<?= $Page->RowIndex ?>_comprador" id="x<?= $Page->RowIndex ?>_comprador" value="<?= HtmlEncode($Page->comprador->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_comprador" class="el_lotes_comprador">
<span<?= $Page->comprador->viewAttributes() ?>>
<?= $Page->comprador->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ivari->Visible) { // ivari ?>
        <td data-name="ivari"<?= $Page->ivari->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_ivari" class="el_lotes_ivari">
<input type="<?= $Page->ivari->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_ivari" id="x<?= $Page->RowIndex ?>_ivari" data-table="lotes" data-field="x_ivari" value="<?= $Page->ivari->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ivari->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ivari->formatPattern()) ?>"<?= $Page->ivari->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ivari->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_ivari" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_ivari" id="o<?= $Page->RowIndex ?>_ivari" value="<?= HtmlEncode($Page->ivari->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_ivari" class="el_lotes_ivari">
<input type="hidden" data-table="lotes" data-field="x_ivari" data-hidden="1" name="x<?= $Page->RowIndex ?>_ivari" id="x<?= $Page->RowIndex ?>_ivari" value="<?= HtmlEncode($Page->ivari->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_ivari" class="el_lotes_ivari">
<span<?= $Page->ivari->viewAttributes() ?>>
<?= $Page->ivari->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ivarni->Visible) { // ivarni ?>
        <td data-name="ivarni"<?= $Page->ivarni->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_ivarni" class="el_lotes_ivarni">
<input type="<?= $Page->ivarni->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_ivarni" id="x<?= $Page->RowIndex ?>_ivarni" data-table="lotes" data-field="x_ivarni" value="<?= $Page->ivarni->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ivarni->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ivarni->formatPattern()) ?>"<?= $Page->ivarni->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ivarni->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_ivarni" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_ivarni" id="o<?= $Page->RowIndex ?>_ivarni" value="<?= HtmlEncode($Page->ivarni->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_ivarni" class="el_lotes_ivarni">
<input type="hidden" data-table="lotes" data-field="x_ivarni" data-hidden="1" name="x<?= $Page->RowIndex ?>_ivarni" id="x<?= $Page->RowIndex ?>_ivarni" value="<?= HtmlEncode($Page->ivarni->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_ivarni" class="el_lotes_ivarni">
<span<?= $Page->ivarni->viewAttributes() ?>>
<?= $Page->ivarni->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->codimpadic->Visible) { // codimpadic ?>
        <td data-name="codimpadic"<?= $Page->codimpadic->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codimpadic" class="el_lotes_codimpadic">
<input type="<?= $Page->codimpadic->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_codimpadic" id="x<?= $Page->RowIndex ?>_codimpadic" data-table="lotes" data-field="x_codimpadic" value="<?= $Page->codimpadic->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codimpadic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codimpadic->formatPattern()) ?>"<?= $Page->codimpadic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->codimpadic->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codimpadic" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_codimpadic" id="o<?= $Page->RowIndex ?>_codimpadic" value="<?= HtmlEncode($Page->codimpadic->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codimpadic" class="el_lotes_codimpadic">
<input type="hidden" data-table="lotes" data-field="x_codimpadic" data-hidden="1" name="x<?= $Page->RowIndex ?>_codimpadic" id="x<?= $Page->RowIndex ?>_codimpadic" value="<?= HtmlEncode($Page->codimpadic->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codimpadic" class="el_lotes_codimpadic">
<span<?= $Page->codimpadic->viewAttributes() ?>>
<?= $Page->codimpadic->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->impadic->Visible) { // impadic ?>
        <td data-name="impadic"<?= $Page->impadic->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_impadic" class="el_lotes_impadic">
<input type="<?= $Page->impadic->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_impadic" id="x<?= $Page->RowIndex ?>_impadic" data-table="lotes" data-field="x_impadic" value="<?= $Page->impadic->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->impadic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->impadic->formatPattern()) ?>"<?= $Page->impadic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->impadic->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_impadic" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_impadic" id="o<?= $Page->RowIndex ?>_impadic" value="<?= HtmlEncode($Page->impadic->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_impadic" class="el_lotes_impadic">
<input type="hidden" data-table="lotes" data-field="x_impadic" data-hidden="1" name="x<?= $Page->RowIndex ?>_impadic" id="x<?= $Page->RowIndex ?>_impadic" value="<?= HtmlEncode($Page->impadic->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_impadic" class="el_lotes_impadic">
<span<?= $Page->impadic->viewAttributes() ?>>
<?= $Page->impadic->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->descor->Visible) { // descor ?>
        <td data-name="descor"<?= $Page->descor->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_descor" class="el_lotes_descor">
<input type="<?= $Page->descor->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_descor" id="x<?= $Page->RowIndex ?>_descor" data-table="lotes" data-field="x_descor" value="<?= $Page->descor->EditValue ?>" size="30" maxlength="300" placeholder="<?= HtmlEncode($Page->descor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descor->formatPattern()) ?>"<?= $Page->descor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->descor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_descor" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_descor" id="o<?= $Page->RowIndex ?>_descor" value="<?= HtmlEncode($Page->descor->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_descor" class="el_lotes_descor">
<input type="hidden" data-table="lotes" data-field="x_descor" data-hidden="1" name="x<?= $Page->RowIndex ?>_descor" id="x<?= $Page->RowIndex ?>_descor" value="<?= HtmlEncode($Page->descor->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_descor" class="el_lotes_descor">
<span<?= $Page->descor->viewAttributes() ?>>
<?= $Page->descor->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->observ->Visible) { // observ ?>
        <td data-name="observ"<?= $Page->observ->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_observ" class="el_lotes_observ">
<input type="<?= $Page->observ->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_observ" id="x<?= $Page->RowIndex ?>_observ" data-table="lotes" data-field="x_observ" value="<?= $Page->observ->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->observ->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->observ->formatPattern()) ?>"<?= $Page->observ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->observ->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_observ" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_observ" id="o<?= $Page->RowIndex ?>_observ" value="<?= HtmlEncode($Page->observ->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_observ" class="el_lotes_observ">
<input type="hidden" data-table="lotes" data-field="x_observ" data-hidden="1" name="x<?= $Page->RowIndex ?>_observ" id="x<?= $Page->RowIndex ?>_observ" value="<?= HtmlEncode($Page->observ->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_observ" class="el_lotes_observ">
<span<?= $Page->observ->viewAttributes() ?>>
<?= $Page->observ->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="lotes" data-field="x_usuario" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_usuario" id="o<?= $Page->RowIndex ?>_usuario" value="<?= HtmlEncode($Page->usuario->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_usuario" class="el_lotes_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->fecalta->Visible) { // fecalta ?>
        <td data-name="fecalta"<?= $Page->fecalta->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="lotes" data-field="x_fecalta" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_fecalta" id="o<?= $Page->RowIndex ?>_fecalta" value="<?= HtmlEncode($Page->fecalta->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_fecalta" class="el_lotes_fecalta">
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->secuencia->Visible) { // secuencia ?>
        <td data-name="secuencia"<?= $Page->secuencia->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_secuencia" class="el_lotes_secuencia">
<input type="<?= $Page->secuencia->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_secuencia" id="x<?= $Page->RowIndex ?>_secuencia" data-table="lotes" data-field="x_secuencia" value="<?= $Page->secuencia->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->secuencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->secuencia->formatPattern()) ?>"<?= $Page->secuencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->secuencia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_secuencia" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_secuencia" id="o<?= $Page->RowIndex ?>_secuencia" value="<?= HtmlEncode($Page->secuencia->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_secuencia" class="el_lotes_secuencia">
<input type="hidden" data-table="lotes" data-field="x_secuencia" data-hidden="1" name="x<?= $Page->RowIndex ?>_secuencia" id="x<?= $Page->RowIndex ?>_secuencia" value="<?= HtmlEncode($Page->secuencia->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_secuencia" class="el_lotes_secuencia">
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->codintlote->Visible) { // codintlote ?>
        <td data-name="codintlote"<?= $Page->codintlote->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintlote" class="el_lotes_codintlote">
<input type="<?= $Page->codintlote->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_codintlote" id="x<?= $Page->RowIndex ?>_codintlote" data-table="lotes" data-field="x_codintlote" value="<?= $Page->codintlote->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->codintlote->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codintlote->formatPattern()) ?>"<?= $Page->codintlote->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->codintlote->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codintlote" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_codintlote" id="o<?= $Page->RowIndex ?>_codintlote" value="<?= HtmlEncode($Page->codintlote->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintlote" class="el_lotes_codintlote">
<span<?= $Page->codintlote->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codintlote->getDisplayValue($Page->codintlote->EditValue))) ?>"></span>
<input type="hidden" data-table="lotes" data-field="x_codintlote" data-hidden="1" name="x<?= $Page->RowIndex ?>_codintlote" id="x<?= $Page->RowIndex ?>_codintlote" value="<?= HtmlEncode($Page->codintlote->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintlote" class="el_lotes_codintlote">
<span<?= $Page->codintlote->viewAttributes() ?>>
<?= $Page->codintlote->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->codintnum->Visible) { // codintnum ?>
        <td data-name="codintnum"<?= $Page->codintnum->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintnum" class="el_lotes_codintnum">
<input type="<?= $Page->codintnum->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_codintnum" id="x<?= $Page->RowIndex ?>_codintnum" data-table="lotes" data-field="x_codintnum" value="<?= $Page->codintnum->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codintnum->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codintnum->formatPattern()) ?>"<?= $Page->codintnum->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->codintnum->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codintnum" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_codintnum" id="o<?= $Page->RowIndex ?>_codintnum" value="<?= HtmlEncode($Page->codintnum->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintnum" class="el_lotes_codintnum">
<input type="hidden" data-table="lotes" data-field="x_codintnum" data-hidden="1" name="x<?= $Page->RowIndex ?>_codintnum" id="x<?= $Page->RowIndex ?>_codintnum" value="<?= HtmlEncode($Page->codintnum->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintnum" class="el_lotes_codintnum">
<span<?= $Page->codintnum->viewAttributes() ?>>
<?= $Page->codintnum->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->codintsublote->Visible) { // codintsublote ?>
        <td data-name="codintsublote"<?= $Page->codintsublote->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintsublote" class="el_lotes_codintsublote">
<input type="<?= $Page->codintsublote->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_codintsublote" id="x<?= $Page->RowIndex ?>_codintsublote" data-table="lotes" data-field="x_codintsublote" value="<?= $Page->codintsublote->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->codintsublote->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codintsublote->formatPattern()) ?>"<?= $Page->codintsublote->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->codintsublote->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codintsublote" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_codintsublote" id="o<?= $Page->RowIndex ?>_codintsublote" value="<?= HtmlEncode($Page->codintsublote->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintsublote" class="el_lotes_codintsublote">
<input type="hidden" data-table="lotes" data-field="x_codintsublote" data-hidden="1" name="x<?= $Page->RowIndex ?>_codintsublote" id="x<?= $Page->RowIndex ?>_codintsublote" value="<?= HtmlEncode($Page->codintsublote->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_codintsublote" class="el_lotes_codintsublote">
<span<?= $Page->codintsublote->viewAttributes() ?>>
<?= $Page->codintsublote->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="lotes" data-field="x_usuarioultmod" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_usuarioultmod" id="o<?= $Page->RowIndex ?>_usuarioultmod" value="<?= HtmlEncode($Page->usuarioultmod->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_usuarioultmod" class="el_lotes_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="lotes" data-field="x_fecultmod" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_fecultmod" id="o<?= $Page->RowIndex ?>_fecultmod" value="<?= HtmlEncode($Page->fecultmod->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_fecultmod" class="el_lotes_fecultmod">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->dir_secuencia->Visible) { // dir_secuencia ?>
        <td data-name="dir_secuencia"<?= $Page->dir_secuencia->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_dir_secuencia" class="el_lotes_dir_secuencia">
    <select
        id="x<?= $Page->RowIndex ?>_dir_secuencia"
        name="x<?= $Page->RowIndex ?>_dir_secuencia"
        class="form-select ew-select<?= $Page->dir_secuencia->isInvalidClass() ?>"
        <?php if (!$Page->dir_secuencia->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_dir_secuencia"
        <?php } ?>
        data-table="lotes"
        data-field="x_dir_secuencia"
        data-value-separator="<?= $Page->dir_secuencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->dir_secuencia->getPlaceHolder()) ?>"
        <?= $Page->dir_secuencia->editAttributes() ?>>
        <?= $Page->dir_secuencia->selectOptionListHtml("x{$Page->RowIndex}_dir_secuencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->dir_secuencia->getErrorMessage() ?></div>
<?= $Page->dir_secuencia->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_dir_secuencia") ?>
<?php if (!$Page->dir_secuencia->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_dir_secuencia", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_dir_secuencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.dir_secuencia?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_dir_secuencia", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_dir_secuencia", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.lotes.fields.dir_secuencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="lotes" data-field="x_dir_secuencia" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_dir_secuencia" id="o<?= $Page->RowIndex ?>_dir_secuencia" value="<?= HtmlEncode($Page->dir_secuencia->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_dir_secuencia" class="el_lotes_dir_secuencia">
    <select
        id="x<?= $Page->RowIndex ?>_dir_secuencia"
        name="x<?= $Page->RowIndex ?>_dir_secuencia"
        class="form-select ew-select<?= $Page->dir_secuencia->isInvalidClass() ?>"
        <?php if (!$Page->dir_secuencia->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_dir_secuencia"
        <?php } ?>
        data-table="lotes"
        data-field="x_dir_secuencia"
        data-value-separator="<?= $Page->dir_secuencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->dir_secuencia->getPlaceHolder()) ?>"
        <?= $Page->dir_secuencia->editAttributes() ?>>
        <?= $Page->dir_secuencia->selectOptionListHtml("x{$Page->RowIndex}_dir_secuencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->dir_secuencia->getErrorMessage() ?></div>
<?= $Page->dir_secuencia->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_dir_secuencia") ?>
<?php if (!$Page->dir_secuencia->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_dir_secuencia", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_dir_secuencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.dir_secuencia?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_dir_secuencia", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_dir_secuencia", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.lotes.fields.dir_secuencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_lotes_dir_secuencia" class="el_lotes_dir_secuencia">
<span<?= $Page->dir_secuencia->viewAttributes() ?>>
<?= $Page->dir_secuencia->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == RowType::ADD || $Page->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

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
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
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
    ew.addEventHandlers("lotes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
