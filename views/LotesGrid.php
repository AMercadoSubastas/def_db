<?php

namespace PHPMaker2024\Subastas2024;

// Set up and run Grid object
$Grid = Container("LotesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var flotesgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { lotes: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flotesgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

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

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["codrem",false],["codcli",false],["codrubro",false],["estado",false],["moneda",false],["preciobase",false],["preciofinal",false],["comiscobr",false],["comispag",false],["comprador",false],["ivari",false],["ivarni",false],["codimpadic",false],["impadic",false],["descor",false],["observ",false],["secuencia",false],["codintlote",false],["codintnum",false],["codintsublote",false],["dir_secuencia",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
                return true;
            }
        )

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
            "codrem": <?= $Grid->codrem->toClientList($Grid) ?>,
            "estado": <?= $Grid->estado->toClientList($Grid) ?>,
            "dir_secuencia": <?= $Grid->dir_secuencia->toClientList($Grid) ?>,
        })
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<main class="list">
<div id="ew-header-options">
<?php $Grid->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="flotesgrid" class="ew-form ew-list-form">
<div id="gmp_lotes" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_lotesgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = RowType::HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->codrem->Visible) { // codrem ?>
        <th data-name="codrem" class="<?= $Grid->codrem->headerCellClass() ?>"><div id="elh_lotes_codrem" class="lotes_codrem"><?= $Grid->renderFieldHeader($Grid->codrem) ?></div></th>
<?php } ?>
<?php if ($Grid->codcli->Visible) { // codcli ?>
        <th data-name="codcli" class="<?= $Grid->codcli->headerCellClass() ?>"><div id="elh_lotes_codcli" class="lotes_codcli"><?= $Grid->renderFieldHeader($Grid->codcli) ?></div></th>
<?php } ?>
<?php if ($Grid->codrubro->Visible) { // codrubro ?>
        <th data-name="codrubro" class="<?= $Grid->codrubro->headerCellClass() ?>"><div id="elh_lotes_codrubro" class="lotes_codrubro"><?= $Grid->renderFieldHeader($Grid->codrubro) ?></div></th>
<?php } ?>
<?php if ($Grid->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Grid->estado->headerCellClass() ?>"><div id="elh_lotes_estado" class="lotes_estado"><?= $Grid->renderFieldHeader($Grid->estado) ?></div></th>
<?php } ?>
<?php if ($Grid->moneda->Visible) { // moneda ?>
        <th data-name="moneda" class="<?= $Grid->moneda->headerCellClass() ?>"><div id="elh_lotes_moneda" class="lotes_moneda"><?= $Grid->renderFieldHeader($Grid->moneda) ?></div></th>
<?php } ?>
<?php if ($Grid->preciobase->Visible) { // preciobase ?>
        <th data-name="preciobase" class="<?= $Grid->preciobase->headerCellClass() ?>"><div id="elh_lotes_preciobase" class="lotes_preciobase"><?= $Grid->renderFieldHeader($Grid->preciobase) ?></div></th>
<?php } ?>
<?php if ($Grid->preciofinal->Visible) { // preciofinal ?>
        <th data-name="preciofinal" class="<?= $Grid->preciofinal->headerCellClass() ?>"><div id="elh_lotes_preciofinal" class="lotes_preciofinal"><?= $Grid->renderFieldHeader($Grid->preciofinal) ?></div></th>
<?php } ?>
<?php if ($Grid->comiscobr->Visible) { // comiscobr ?>
        <th data-name="comiscobr" class="<?= $Grid->comiscobr->headerCellClass() ?>"><div id="elh_lotes_comiscobr" class="lotes_comiscobr"><?= $Grid->renderFieldHeader($Grid->comiscobr) ?></div></th>
<?php } ?>
<?php if ($Grid->comispag->Visible) { // comispag ?>
        <th data-name="comispag" class="<?= $Grid->comispag->headerCellClass() ?>"><div id="elh_lotes_comispag" class="lotes_comispag"><?= $Grid->renderFieldHeader($Grid->comispag) ?></div></th>
<?php } ?>
<?php if ($Grid->comprador->Visible) { // comprador ?>
        <th data-name="comprador" class="<?= $Grid->comprador->headerCellClass() ?>"><div id="elh_lotes_comprador" class="lotes_comprador"><?= $Grid->renderFieldHeader($Grid->comprador) ?></div></th>
<?php } ?>
<?php if ($Grid->ivari->Visible) { // ivari ?>
        <th data-name="ivari" class="<?= $Grid->ivari->headerCellClass() ?>"><div id="elh_lotes_ivari" class="lotes_ivari"><?= $Grid->renderFieldHeader($Grid->ivari) ?></div></th>
<?php } ?>
<?php if ($Grid->ivarni->Visible) { // ivarni ?>
        <th data-name="ivarni" class="<?= $Grid->ivarni->headerCellClass() ?>"><div id="elh_lotes_ivarni" class="lotes_ivarni"><?= $Grid->renderFieldHeader($Grid->ivarni) ?></div></th>
<?php } ?>
<?php if ($Grid->codimpadic->Visible) { // codimpadic ?>
        <th data-name="codimpadic" class="<?= $Grid->codimpadic->headerCellClass() ?>"><div id="elh_lotes_codimpadic" class="lotes_codimpadic"><?= $Grid->renderFieldHeader($Grid->codimpadic) ?></div></th>
<?php } ?>
<?php if ($Grid->impadic->Visible) { // impadic ?>
        <th data-name="impadic" class="<?= $Grid->impadic->headerCellClass() ?>"><div id="elh_lotes_impadic" class="lotes_impadic"><?= $Grid->renderFieldHeader($Grid->impadic) ?></div></th>
<?php } ?>
<?php if ($Grid->descor->Visible) { // descor ?>
        <th data-name="descor" class="<?= $Grid->descor->headerCellClass() ?>"><div id="elh_lotes_descor" class="lotes_descor"><?= $Grid->renderFieldHeader($Grid->descor) ?></div></th>
<?php } ?>
<?php if ($Grid->observ->Visible) { // observ ?>
        <th data-name="observ" class="<?= $Grid->observ->headerCellClass() ?>"><div id="elh_lotes_observ" class="lotes_observ"><?= $Grid->renderFieldHeader($Grid->observ) ?></div></th>
<?php } ?>
<?php if ($Grid->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Grid->usuario->headerCellClass() ?>"><div id="elh_lotes_usuario" class="lotes_usuario"><?= $Grid->renderFieldHeader($Grid->usuario) ?></div></th>
<?php } ?>
<?php if ($Grid->fecalta->Visible) { // fecalta ?>
        <th data-name="fecalta" class="<?= $Grid->fecalta->headerCellClass() ?>"><div id="elh_lotes_fecalta" class="lotes_fecalta"><?= $Grid->renderFieldHeader($Grid->fecalta) ?></div></th>
<?php } ?>
<?php if ($Grid->secuencia->Visible) { // secuencia ?>
        <th data-name="secuencia" class="<?= $Grid->secuencia->headerCellClass() ?>"><div id="elh_lotes_secuencia" class="lotes_secuencia"><?= $Grid->renderFieldHeader($Grid->secuencia) ?></div></th>
<?php } ?>
<?php if ($Grid->codintlote->Visible) { // codintlote ?>
        <th data-name="codintlote" class="<?= $Grid->codintlote->headerCellClass() ?>"><div id="elh_lotes_codintlote" class="lotes_codintlote"><?= $Grid->renderFieldHeader($Grid->codintlote) ?></div></th>
<?php } ?>
<?php if ($Grid->codintnum->Visible) { // codintnum ?>
        <th data-name="codintnum" class="<?= $Grid->codintnum->headerCellClass() ?>"><div id="elh_lotes_codintnum" class="lotes_codintnum"><?= $Grid->renderFieldHeader($Grid->codintnum) ?></div></th>
<?php } ?>
<?php if ($Grid->codintsublote->Visible) { // codintsublote ?>
        <th data-name="codintsublote" class="<?= $Grid->codintsublote->headerCellClass() ?>"><div id="elh_lotes_codintsublote" class="lotes_codintsublote"><?= $Grid->renderFieldHeader($Grid->codintsublote) ?></div></th>
<?php } ?>
<?php if ($Grid->usuarioultmod->Visible) { // usuarioultmod ?>
        <th data-name="usuarioultmod" class="<?= $Grid->usuarioultmod->headerCellClass() ?>"><div id="elh_lotes_usuarioultmod" class="lotes_usuarioultmod"><?= $Grid->renderFieldHeader($Grid->usuarioultmod) ?></div></th>
<?php } ?>
<?php if ($Grid->fecultmod->Visible) { // fecultmod ?>
        <th data-name="fecultmod" class="<?= $Grid->fecultmod->headerCellClass() ?>"><div id="elh_lotes_fecultmod" class="lotes_fecultmod"><?= $Grid->renderFieldHeader($Grid->fecultmod) ?></div></th>
<?php } ?>
<?php if ($Grid->dir_secuencia->Visible) { // dir_secuencia ?>
        <th data-name="dir_secuencia" class="<?= $Grid->dir_secuencia->headerCellClass() ?>"><div id="elh_lotes_dir_secuencia" class="lotes_dir_secuencia"><?= $Grid->renderFieldHeader($Grid->dir_secuencia) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$') {
    if (
        $Grid->CurrentRow !== false &&
        $Grid->RowIndex !== '$rowindex$' &&
        (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy") &&
        (!(($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0))
    ) {
        $Grid->fetch();
    }
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete" &&
            $Grid->RowAction != "insertdelete" &&
            !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow()) &&
            $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->codrem->Visible) { // codrem ?>
        <td data-name="codrem"<?= $Grid->codrem->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->codrem->getSessionValue() != "") { ?>
<span<?= $Grid->codrem->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->codrem->getDisplayValue($Grid->codrem->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_codrem" name="x<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codrem" class="el_lotes_codrem">
<?php
if (IsRTL()) {
    $Grid->codrem->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_codrem" class="ew-auto-suggest">
    <input type="<?= $Grid->codrem->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_codrem" id="sv_x<?= $Grid->RowIndex ?>_codrem" value="<?= RemoveHtml($Grid->codrem->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Grid->codrem->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->codrem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codrem->formatPattern()) ?>"<?= $Grid->codrem->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="lotes" data-field="x_codrem" data-input="sv_x<?= $Grid->RowIndex ?>_codrem" data-value-separator="<?= $Grid->codrem->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_codrem" id="x<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->codrem->getErrorMessage() ?></div>
<script>
loadjs.ready("flotesgrid", function() {
    flotesgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_codrem","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->codrem->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.lotes.fields.codrem.autoSuggestOptions));
});
</script>
<?= $Grid->codrem->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_codrem") ?>
</span>
<?php } ?>
<input type="hidden" data-table="lotes" data-field="x_codrem" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codrem" id="o<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codrem" class="el_lotes_codrem">
<span<?= $Grid->codrem->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->codrem->getDisplayValue($Grid->codrem->EditValue) ?></span></span>
<input type="hidden" data-table="lotes" data-field="x_codrem" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codrem" id="x<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codrem" class="el_lotes_codrem">
<span<?= $Grid->codrem->viewAttributes() ?>>
<?= $Grid->codrem->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_codrem" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_codrem" id="flotesgrid$x<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_codrem" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_codrem" id="flotesgrid$o<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->codcli->Visible) { // codcli ?>
        <td data-name="codcli"<?= $Grid->codcli->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codcli" class="el_lotes_codcli">
<input type="<?= $Grid->codcli->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codcli" id="x<?= $Grid->RowIndex ?>_codcli" data-table="lotes" data-field="x_codcli" value="<?= $Grid->codcli->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->codcli->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codcli->formatPattern()) ?>"<?= $Grid->codcli->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codcli->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codcli" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codcli" id="o<?= $Grid->RowIndex ?>_codcli" value="<?= HtmlEncode($Grid->codcli->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codcli" class="el_lotes_codcli">
<input type="hidden" data-table="lotes" data-field="x_codcli" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codcli" id="x<?= $Grid->RowIndex ?>_codcli" value="<?= HtmlEncode($Grid->codcli->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codcli" class="el_lotes_codcli">
<span<?= $Grid->codcli->viewAttributes() ?>>
<?= $Grid->codcli->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_codcli" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_codcli" id="flotesgrid$x<?= $Grid->RowIndex ?>_codcli" value="<?= HtmlEncode($Grid->codcli->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_codcli" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_codcli" id="flotesgrid$o<?= $Grid->RowIndex ?>_codcli" value="<?= HtmlEncode($Grid->codcli->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->codrubro->Visible) { // codrubro ?>
        <td data-name="codrubro"<?= $Grid->codrubro->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codrubro" class="el_lotes_codrubro">
<input type="<?= $Grid->codrubro->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codrubro" id="x<?= $Grid->RowIndex ?>_codrubro" data-table="lotes" data-field="x_codrubro" value="<?= $Grid->codrubro->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->codrubro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codrubro->formatPattern()) ?>"<?= $Grid->codrubro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codrubro->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codrubro" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codrubro" id="o<?= $Grid->RowIndex ?>_codrubro" value="<?= HtmlEncode($Grid->codrubro->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codrubro" class="el_lotes_codrubro">
<input type="hidden" data-table="lotes" data-field="x_codrubro" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codrubro" id="x<?= $Grid->RowIndex ?>_codrubro" value="<?= HtmlEncode($Grid->codrubro->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codrubro" class="el_lotes_codrubro">
<span<?= $Grid->codrubro->viewAttributes() ?>>
<?= $Grid->codrubro->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_codrubro" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_codrubro" id="flotesgrid$x<?= $Grid->RowIndex ?>_codrubro" value="<?= HtmlEncode($Grid->codrubro->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_codrubro" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_codrubro" id="flotesgrid$o<?= $Grid->RowIndex ?>_codrubro" value="<?= HtmlEncode($Grid->codrubro->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->estado->Visible) { // estado ?>
        <td data-name="estado"<?= $Grid->estado->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_estado" class="el_lotes_estado">
<template id="tp_x<?= $Grid->RowIndex ?>_estado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="lotes" data-field="x_estado" name="x<?= $Grid->RowIndex ?>_estado" id="x<?= $Grid->RowIndex ?>_estado"<?= $Grid->estado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_estado" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_estado"
    name="x<?= $Grid->RowIndex ?>_estado"
    value="<?= HtmlEncode($Grid->estado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_estado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->estado->isInvalidClass() ?>"
    data-table="lotes"
    data-field="x_estado"
    data-value-separator="<?= $Grid->estado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->estado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->estado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_estado" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_estado" id="o<?= $Grid->RowIndex ?>_estado" value="<?= HtmlEncode($Grid->estado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_estado" class="el_lotes_estado">
<template id="tp_x<?= $Grid->RowIndex ?>_estado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="lotes" data-field="x_estado" name="x<?= $Grid->RowIndex ?>_estado" id="x<?= $Grid->RowIndex ?>_estado"<?= $Grid->estado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_estado" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_estado"
    name="x<?= $Grid->RowIndex ?>_estado"
    value="<?= HtmlEncode($Grid->estado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_estado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->estado->isInvalidClass() ?>"
    data-table="lotes"
    data-field="x_estado"
    data-value-separator="<?= $Grid->estado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->estado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->estado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_estado" class="el_lotes_estado">
<span<?= $Grid->estado->viewAttributes() ?>>
<?= $Grid->estado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_estado" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_estado" id="flotesgrid$x<?= $Grid->RowIndex ?>_estado" value="<?= HtmlEncode($Grid->estado->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_estado" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_estado" id="flotesgrid$o<?= $Grid->RowIndex ?>_estado" value="<?= HtmlEncode($Grid->estado->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->moneda->Visible) { // moneda ?>
        <td data-name="moneda"<?= $Grid->moneda->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_moneda" class="el_lotes_moneda">
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" name="x<?= $Grid->RowIndex ?>_moneda" id="x<?= $Grid->RowIndex ?>_moneda" value="<?= HtmlEncode($Grid->moneda->CurrentValue) ?>">
</span>
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_moneda" id="o<?= $Grid->RowIndex ?>_moneda" value="<?= HtmlEncode($Grid->moneda->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_moneda" class="el_lotes_moneda">
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" name="x<?= $Grid->RowIndex ?>_moneda" id="x<?= $Grid->RowIndex ?>_moneda" value="<?= HtmlEncode($Grid->moneda->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_moneda" class="el_lotes_moneda">
<span<?= $Grid->moneda->viewAttributes() ?>>
<?= $Grid->moneda->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_moneda" id="flotesgrid$x<?= $Grid->RowIndex ?>_moneda" value="<?= HtmlEncode($Grid->moneda->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_moneda" id="flotesgrid$o<?= $Grid->RowIndex ?>_moneda" value="<?= HtmlEncode($Grid->moneda->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->preciobase->Visible) { // preciobase ?>
        <td data-name="preciobase"<?= $Grid->preciobase->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_preciobase" class="el_lotes_preciobase">
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" name="x<?= $Grid->RowIndex ?>_preciobase" id="x<?= $Grid->RowIndex ?>_preciobase" value="<?= HtmlEncode($Grid->preciobase->CurrentValue) ?>">
</span>
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_preciobase" id="o<?= $Grid->RowIndex ?>_preciobase" value="<?= HtmlEncode($Grid->preciobase->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_preciobase" class="el_lotes_preciobase">
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" name="x<?= $Grid->RowIndex ?>_preciobase" id="x<?= $Grid->RowIndex ?>_preciobase" value="<?= HtmlEncode($Grid->preciobase->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_preciobase" class="el_lotes_preciobase">
<span<?= $Grid->preciobase->viewAttributes() ?>>
<?= $Grid->preciobase->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_preciobase" id="flotesgrid$x<?= $Grid->RowIndex ?>_preciobase" value="<?= HtmlEncode($Grid->preciobase->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_preciobase" id="flotesgrid$o<?= $Grid->RowIndex ?>_preciobase" value="<?= HtmlEncode($Grid->preciobase->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->preciofinal->Visible) { // preciofinal ?>
        <td data-name="preciofinal"<?= $Grid->preciofinal->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_preciofinal" class="el_lotes_preciofinal">
<input type="<?= $Grid->preciofinal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_preciofinal" id="x<?= $Grid->RowIndex ?>_preciofinal" data-table="lotes" data-field="x_preciofinal" value="<?= $Grid->preciofinal->EditValue ?>" size="100" placeholder="<?= HtmlEncode($Grid->preciofinal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->preciofinal->formatPattern()) ?>"<?= $Grid->preciofinal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->preciofinal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_preciofinal" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_preciofinal" id="o<?= $Grid->RowIndex ?>_preciofinal" value="<?= HtmlEncode($Grid->preciofinal->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_preciofinal" class="el_lotes_preciofinal">
<input type="<?= $Grid->preciofinal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_preciofinal" id="x<?= $Grid->RowIndex ?>_preciofinal" data-table="lotes" data-field="x_preciofinal" value="<?= $Grid->preciofinal->EditValue ?>" size="100" placeholder="<?= HtmlEncode($Grid->preciofinal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->preciofinal->formatPattern()) ?>"<?= $Grid->preciofinal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->preciofinal->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_preciofinal" class="el_lotes_preciofinal">
<span<?= $Grid->preciofinal->viewAttributes() ?>>
<?= $Grid->preciofinal->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_preciofinal" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_preciofinal" id="flotesgrid$x<?= $Grid->RowIndex ?>_preciofinal" value="<?= HtmlEncode($Grid->preciofinal->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_preciofinal" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_preciofinal" id="flotesgrid$o<?= $Grid->RowIndex ?>_preciofinal" value="<?= HtmlEncode($Grid->preciofinal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->comiscobr->Visible) { // comiscobr ?>
        <td data-name="comiscobr"<?= $Grid->comiscobr->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comiscobr" class="el_lotes_comiscobr">
<input type="<?= $Grid->comiscobr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_comiscobr" id="x<?= $Grid->RowIndex ?>_comiscobr" data-table="lotes" data-field="x_comiscobr" value="<?= $Grid->comiscobr->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->comiscobr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->comiscobr->formatPattern()) ?>"<?= $Grid->comiscobr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->comiscobr->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_comiscobr" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_comiscobr" id="o<?= $Grid->RowIndex ?>_comiscobr" value="<?= HtmlEncode($Grid->comiscobr->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comiscobr" class="el_lotes_comiscobr">
<input type="<?= $Grid->comiscobr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_comiscobr" id="x<?= $Grid->RowIndex ?>_comiscobr" data-table="lotes" data-field="x_comiscobr" value="<?= $Grid->comiscobr->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->comiscobr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->comiscobr->formatPattern()) ?>"<?= $Grid->comiscobr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->comiscobr->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comiscobr" class="el_lotes_comiscobr">
<span<?= $Grid->comiscobr->viewAttributes() ?>>
<?= $Grid->comiscobr->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_comiscobr" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_comiscobr" id="flotesgrid$x<?= $Grid->RowIndex ?>_comiscobr" value="<?= HtmlEncode($Grid->comiscobr->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_comiscobr" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_comiscobr" id="flotesgrid$o<?= $Grid->RowIndex ?>_comiscobr" value="<?= HtmlEncode($Grid->comiscobr->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->comispag->Visible) { // comispag ?>
        <td data-name="comispag"<?= $Grid->comispag->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comispag" class="el_lotes_comispag">
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" name="x<?= $Grid->RowIndex ?>_comispag" id="x<?= $Grid->RowIndex ?>_comispag" value="<?= HtmlEncode($Grid->comispag->CurrentValue) ?>">
</span>
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_comispag" id="o<?= $Grid->RowIndex ?>_comispag" value="<?= HtmlEncode($Grid->comispag->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comispag" class="el_lotes_comispag">
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" name="x<?= $Grid->RowIndex ?>_comispag" id="x<?= $Grid->RowIndex ?>_comispag" value="<?= HtmlEncode($Grid->comispag->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comispag" class="el_lotes_comispag">
<span<?= $Grid->comispag->viewAttributes() ?>>
<?= $Grid->comispag->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_comispag" id="flotesgrid$x<?= $Grid->RowIndex ?>_comispag" value="<?= HtmlEncode($Grid->comispag->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_comispag" id="flotesgrid$o<?= $Grid->RowIndex ?>_comispag" value="<?= HtmlEncode($Grid->comispag->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->comprador->Visible) { // comprador ?>
        <td data-name="comprador"<?= $Grid->comprador->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comprador" class="el_lotes_comprador">
<input type="<?= $Grid->comprador->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_comprador" id="x<?= $Grid->RowIndex ?>_comprador" data-table="lotes" data-field="x_comprador" value="<?= $Grid->comprador->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->comprador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->comprador->formatPattern()) ?>"<?= $Grid->comprador->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->comprador->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_comprador" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_comprador" id="o<?= $Grid->RowIndex ?>_comprador" value="<?= HtmlEncode($Grid->comprador->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comprador" class="el_lotes_comprador">
<input type="hidden" data-table="lotes" data-field="x_comprador" data-hidden="1" name="x<?= $Grid->RowIndex ?>_comprador" id="x<?= $Grid->RowIndex ?>_comprador" value="<?= HtmlEncode($Grid->comprador->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_comprador" class="el_lotes_comprador">
<span<?= $Grid->comprador->viewAttributes() ?>>
<?= $Grid->comprador->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_comprador" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_comprador" id="flotesgrid$x<?= $Grid->RowIndex ?>_comprador" value="<?= HtmlEncode($Grid->comprador->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_comprador" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_comprador" id="flotesgrid$o<?= $Grid->RowIndex ?>_comprador" value="<?= HtmlEncode($Grid->comprador->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ivari->Visible) { // ivari ?>
        <td data-name="ivari"<?= $Grid->ivari->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_ivari" class="el_lotes_ivari">
<input type="<?= $Grid->ivari->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ivari" id="x<?= $Grid->RowIndex ?>_ivari" data-table="lotes" data-field="x_ivari" value="<?= $Grid->ivari->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ivari->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ivari->formatPattern()) ?>"<?= $Grid->ivari->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ivari->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_ivari" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ivari" id="o<?= $Grid->RowIndex ?>_ivari" value="<?= HtmlEncode($Grid->ivari->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_ivari" class="el_lotes_ivari">
<input type="hidden" data-table="lotes" data-field="x_ivari" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ivari" id="x<?= $Grid->RowIndex ?>_ivari" value="<?= HtmlEncode($Grid->ivari->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_ivari" class="el_lotes_ivari">
<span<?= $Grid->ivari->viewAttributes() ?>>
<?= $Grid->ivari->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_ivari" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_ivari" id="flotesgrid$x<?= $Grid->RowIndex ?>_ivari" value="<?= HtmlEncode($Grid->ivari->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_ivari" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_ivari" id="flotesgrid$o<?= $Grid->RowIndex ?>_ivari" value="<?= HtmlEncode($Grid->ivari->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ivarni->Visible) { // ivarni ?>
        <td data-name="ivarni"<?= $Grid->ivarni->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_ivarni" class="el_lotes_ivarni">
<input type="<?= $Grid->ivarni->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ivarni" id="x<?= $Grid->RowIndex ?>_ivarni" data-table="lotes" data-field="x_ivarni" value="<?= $Grid->ivarni->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ivarni->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ivarni->formatPattern()) ?>"<?= $Grid->ivarni->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ivarni->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_ivarni" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ivarni" id="o<?= $Grid->RowIndex ?>_ivarni" value="<?= HtmlEncode($Grid->ivarni->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_ivarni" class="el_lotes_ivarni">
<input type="hidden" data-table="lotes" data-field="x_ivarni" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ivarni" id="x<?= $Grid->RowIndex ?>_ivarni" value="<?= HtmlEncode($Grid->ivarni->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_ivarni" class="el_lotes_ivarni">
<span<?= $Grid->ivarni->viewAttributes() ?>>
<?= $Grid->ivarni->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_ivarni" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_ivarni" id="flotesgrid$x<?= $Grid->RowIndex ?>_ivarni" value="<?= HtmlEncode($Grid->ivarni->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_ivarni" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_ivarni" id="flotesgrid$o<?= $Grid->RowIndex ?>_ivarni" value="<?= HtmlEncode($Grid->ivarni->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->codimpadic->Visible) { // codimpadic ?>
        <td data-name="codimpadic"<?= $Grid->codimpadic->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codimpadic" class="el_lotes_codimpadic">
<input type="<?= $Grid->codimpadic->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codimpadic" id="x<?= $Grid->RowIndex ?>_codimpadic" data-table="lotes" data-field="x_codimpadic" value="<?= $Grid->codimpadic->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->codimpadic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codimpadic->formatPattern()) ?>"<?= $Grid->codimpadic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codimpadic->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codimpadic" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codimpadic" id="o<?= $Grid->RowIndex ?>_codimpadic" value="<?= HtmlEncode($Grid->codimpadic->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codimpadic" class="el_lotes_codimpadic">
<input type="hidden" data-table="lotes" data-field="x_codimpadic" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codimpadic" id="x<?= $Grid->RowIndex ?>_codimpadic" value="<?= HtmlEncode($Grid->codimpadic->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codimpadic" class="el_lotes_codimpadic">
<span<?= $Grid->codimpadic->viewAttributes() ?>>
<?= $Grid->codimpadic->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_codimpadic" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_codimpadic" id="flotesgrid$x<?= $Grid->RowIndex ?>_codimpadic" value="<?= HtmlEncode($Grid->codimpadic->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_codimpadic" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_codimpadic" id="flotesgrid$o<?= $Grid->RowIndex ?>_codimpadic" value="<?= HtmlEncode($Grid->codimpadic->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->impadic->Visible) { // impadic ?>
        <td data-name="impadic"<?= $Grid->impadic->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_impadic" class="el_lotes_impadic">
<input type="<?= $Grid->impadic->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_impadic" id="x<?= $Grid->RowIndex ?>_impadic" data-table="lotes" data-field="x_impadic" value="<?= $Grid->impadic->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->impadic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->impadic->formatPattern()) ?>"<?= $Grid->impadic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->impadic->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_impadic" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_impadic" id="o<?= $Grid->RowIndex ?>_impadic" value="<?= HtmlEncode($Grid->impadic->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_impadic" class="el_lotes_impadic">
<input type="hidden" data-table="lotes" data-field="x_impadic" data-hidden="1" name="x<?= $Grid->RowIndex ?>_impadic" id="x<?= $Grid->RowIndex ?>_impadic" value="<?= HtmlEncode($Grid->impadic->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_impadic" class="el_lotes_impadic">
<span<?= $Grid->impadic->viewAttributes() ?>>
<?= $Grid->impadic->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_impadic" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_impadic" id="flotesgrid$x<?= $Grid->RowIndex ?>_impadic" value="<?= HtmlEncode($Grid->impadic->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_impadic" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_impadic" id="flotesgrid$o<?= $Grid->RowIndex ?>_impadic" value="<?= HtmlEncode($Grid->impadic->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->descor->Visible) { // descor ?>
        <td data-name="descor"<?= $Grid->descor->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_descor" class="el_lotes_descor">
<input type="<?= $Grid->descor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_descor" id="x<?= $Grid->RowIndex ?>_descor" data-table="lotes" data-field="x_descor" value="<?= $Grid->descor->EditValue ?>" size="30" maxlength="300" placeholder="<?= HtmlEncode($Grid->descor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->descor->formatPattern()) ?>"<?= $Grid->descor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->descor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_descor" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_descor" id="o<?= $Grid->RowIndex ?>_descor" value="<?= HtmlEncode($Grid->descor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_descor" class="el_lotes_descor">
<input type="hidden" data-table="lotes" data-field="x_descor" data-hidden="1" name="x<?= $Grid->RowIndex ?>_descor" id="x<?= $Grid->RowIndex ?>_descor" value="<?= HtmlEncode($Grid->descor->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_descor" class="el_lotes_descor">
<span<?= $Grid->descor->viewAttributes() ?>>
<?= $Grid->descor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_descor" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_descor" id="flotesgrid$x<?= $Grid->RowIndex ?>_descor" value="<?= HtmlEncode($Grid->descor->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_descor" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_descor" id="flotesgrid$o<?= $Grid->RowIndex ?>_descor" value="<?= HtmlEncode($Grid->descor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->observ->Visible) { // observ ?>
        <td data-name="observ"<?= $Grid->observ->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_observ" class="el_lotes_observ">
<input type="<?= $Grid->observ->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_observ" id="x<?= $Grid->RowIndex ?>_observ" data-table="lotes" data-field="x_observ" value="<?= $Grid->observ->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->observ->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->observ->formatPattern()) ?>"<?= $Grid->observ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->observ->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_observ" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_observ" id="o<?= $Grid->RowIndex ?>_observ" value="<?= HtmlEncode($Grid->observ->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_observ" class="el_lotes_observ">
<input type="hidden" data-table="lotes" data-field="x_observ" data-hidden="1" name="x<?= $Grid->RowIndex ?>_observ" id="x<?= $Grid->RowIndex ?>_observ" value="<?= HtmlEncode($Grid->observ->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_observ" class="el_lotes_observ">
<span<?= $Grid->observ->viewAttributes() ?>>
<?= $Grid->observ->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_observ" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_observ" id="flotesgrid$x<?= $Grid->RowIndex ?>_observ" value="<?= HtmlEncode($Grid->observ->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_observ" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_observ" id="flotesgrid$o<?= $Grid->RowIndex ?>_observ" value="<?= HtmlEncode($Grid->observ->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Grid->usuario->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="lotes" data-field="x_usuario" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_usuario" id="o<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_usuario" class="el_lotes_usuario">
<span<?= $Grid->usuario->viewAttributes() ?>>
<?= $Grid->usuario->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_usuario" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_usuario" id="flotesgrid$x<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_usuario" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_usuario" id="flotesgrid$o<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecalta->Visible) { // fecalta ?>
        <td data-name="fecalta"<?= $Grid->fecalta->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="lotes" data-field="x_fecalta" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecalta" id="o<?= $Grid->RowIndex ?>_fecalta" value="<?= HtmlEncode($Grid->fecalta->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_fecalta" class="el_lotes_fecalta">
<span<?= $Grid->fecalta->viewAttributes() ?>>
<?= $Grid->fecalta->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_fecalta" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_fecalta" id="flotesgrid$x<?= $Grid->RowIndex ?>_fecalta" value="<?= HtmlEncode($Grid->fecalta->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_fecalta" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_fecalta" id="flotesgrid$o<?= $Grid->RowIndex ?>_fecalta" value="<?= HtmlEncode($Grid->fecalta->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->secuencia->Visible) { // secuencia ?>
        <td data-name="secuencia"<?= $Grid->secuencia->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_secuencia" class="el_lotes_secuencia">
<input type="<?= $Grid->secuencia->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_secuencia" id="x<?= $Grid->RowIndex ?>_secuencia" data-table="lotes" data-field="x_secuencia" value="<?= $Grid->secuencia->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->secuencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->secuencia->formatPattern()) ?>"<?= $Grid->secuencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->secuencia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_secuencia" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_secuencia" id="o<?= $Grid->RowIndex ?>_secuencia" value="<?= HtmlEncode($Grid->secuencia->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_secuencia" class="el_lotes_secuencia">
<input type="hidden" data-table="lotes" data-field="x_secuencia" data-hidden="1" name="x<?= $Grid->RowIndex ?>_secuencia" id="x<?= $Grid->RowIndex ?>_secuencia" value="<?= HtmlEncode($Grid->secuencia->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_secuencia" class="el_lotes_secuencia">
<span<?= $Grid->secuencia->viewAttributes() ?>>
<?= $Grid->secuencia->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_secuencia" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_secuencia" id="flotesgrid$x<?= $Grid->RowIndex ?>_secuencia" value="<?= HtmlEncode($Grid->secuencia->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_secuencia" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_secuencia" id="flotesgrid$o<?= $Grid->RowIndex ?>_secuencia" value="<?= HtmlEncode($Grid->secuencia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->codintlote->Visible) { // codintlote ?>
        <td data-name="codintlote"<?= $Grid->codintlote->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintlote" class="el_lotes_codintlote">
<input type="<?= $Grid->codintlote->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codintlote" id="x<?= $Grid->RowIndex ?>_codintlote" data-table="lotes" data-field="x_codintlote" value="<?= $Grid->codintlote->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Grid->codintlote->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codintlote->formatPattern()) ?>"<?= $Grid->codintlote->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codintlote->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codintlote" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codintlote" id="o<?= $Grid->RowIndex ?>_codintlote" value="<?= HtmlEncode($Grid->codintlote->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintlote" class="el_lotes_codintlote">
<span<?= $Grid->codintlote->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->codintlote->getDisplayValue($Grid->codintlote->EditValue))) ?>"></span>
<input type="hidden" data-table="lotes" data-field="x_codintlote" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codintlote" id="x<?= $Grid->RowIndex ?>_codintlote" value="<?= HtmlEncode($Grid->codintlote->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintlote" class="el_lotes_codintlote">
<span<?= $Grid->codintlote->viewAttributes() ?>>
<?= $Grid->codintlote->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_codintlote" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_codintlote" id="flotesgrid$x<?= $Grid->RowIndex ?>_codintlote" value="<?= HtmlEncode($Grid->codintlote->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_codintlote" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_codintlote" id="flotesgrid$o<?= $Grid->RowIndex ?>_codintlote" value="<?= HtmlEncode($Grid->codintlote->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->codintnum->Visible) { // codintnum ?>
        <td data-name="codintnum"<?= $Grid->codintnum->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintnum" class="el_lotes_codintnum">
<input type="<?= $Grid->codintnum->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codintnum" id="x<?= $Grid->RowIndex ?>_codintnum" data-table="lotes" data-field="x_codintnum" value="<?= $Grid->codintnum->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->codintnum->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codintnum->formatPattern()) ?>"<?= $Grid->codintnum->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codintnum->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codintnum" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codintnum" id="o<?= $Grid->RowIndex ?>_codintnum" value="<?= HtmlEncode($Grid->codintnum->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintnum" class="el_lotes_codintnum">
<input type="hidden" data-table="lotes" data-field="x_codintnum" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codintnum" id="x<?= $Grid->RowIndex ?>_codintnum" value="<?= HtmlEncode($Grid->codintnum->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintnum" class="el_lotes_codintnum">
<span<?= $Grid->codintnum->viewAttributes() ?>>
<?= $Grid->codintnum->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_codintnum" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_codintnum" id="flotesgrid$x<?= $Grid->RowIndex ?>_codintnum" value="<?= HtmlEncode($Grid->codintnum->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_codintnum" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_codintnum" id="flotesgrid$o<?= $Grid->RowIndex ?>_codintnum" value="<?= HtmlEncode($Grid->codintnum->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->codintsublote->Visible) { // codintsublote ?>
        <td data-name="codintsublote"<?= $Grid->codintsublote->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintsublote" class="el_lotes_codintsublote">
<input type="<?= $Grid->codintsublote->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codintsublote" id="x<?= $Grid->RowIndex ?>_codintsublote" data-table="lotes" data-field="x_codintsublote" value="<?= $Grid->codintsublote->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Grid->codintsublote->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codintsublote->formatPattern()) ?>"<?= $Grid->codintsublote->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codintsublote->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="lotes" data-field="x_codintsublote" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codintsublote" id="o<?= $Grid->RowIndex ?>_codintsublote" value="<?= HtmlEncode($Grid->codintsublote->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintsublote" class="el_lotes_codintsublote">
<input type="hidden" data-table="lotes" data-field="x_codintsublote" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codintsublote" id="x<?= $Grid->RowIndex ?>_codintsublote" value="<?= HtmlEncode($Grid->codintsublote->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_codintsublote" class="el_lotes_codintsublote">
<span<?= $Grid->codintsublote->viewAttributes() ?>>
<?= $Grid->codintsublote->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_codintsublote" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_codintsublote" id="flotesgrid$x<?= $Grid->RowIndex ?>_codintsublote" value="<?= HtmlEncode($Grid->codintsublote->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_codintsublote" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_codintsublote" id="flotesgrid$o<?= $Grid->RowIndex ?>_codintsublote" value="<?= HtmlEncode($Grid->codintsublote->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usuarioultmod->Visible) { // usuarioultmod ?>
        <td data-name="usuarioultmod"<?= $Grid->usuarioultmod->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="lotes" data-field="x_usuarioultmod" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_usuarioultmod" id="o<?= $Grid->RowIndex ?>_usuarioultmod" value="<?= HtmlEncode($Grid->usuarioultmod->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_usuarioultmod" class="el_lotes_usuarioultmod">
<span<?= $Grid->usuarioultmod->viewAttributes() ?>>
<?= $Grid->usuarioultmod->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_usuarioultmod" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_usuarioultmod" id="flotesgrid$x<?= $Grid->RowIndex ?>_usuarioultmod" value="<?= HtmlEncode($Grid->usuarioultmod->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_usuarioultmod" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_usuarioultmod" id="flotesgrid$o<?= $Grid->RowIndex ?>_usuarioultmod" value="<?= HtmlEncode($Grid->usuarioultmod->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecultmod->Visible) { // fecultmod ?>
        <td data-name="fecultmod"<?= $Grid->fecultmod->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="lotes" data-field="x_fecultmod" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecultmod" id="o<?= $Grid->RowIndex ?>_fecultmod" value="<?= HtmlEncode($Grid->fecultmod->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_fecultmod" class="el_lotes_fecultmod">
<span<?= $Grid->fecultmod->viewAttributes() ?>>
<?= $Grid->fecultmod->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_fecultmod" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_fecultmod" id="flotesgrid$x<?= $Grid->RowIndex ?>_fecultmod" value="<?= HtmlEncode($Grid->fecultmod->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_fecultmod" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_fecultmod" id="flotesgrid$o<?= $Grid->RowIndex ?>_fecultmod" value="<?= HtmlEncode($Grid->fecultmod->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dir_secuencia->Visible) { // dir_secuencia ?>
        <td data-name="dir_secuencia"<?= $Grid->dir_secuencia->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_dir_secuencia" class="el_lotes_dir_secuencia">
    <select
        id="x<?= $Grid->RowIndex ?>_dir_secuencia"
        name="x<?= $Grid->RowIndex ?>_dir_secuencia"
        class="form-select ew-select<?= $Grid->dir_secuencia->isInvalidClass() ?>"
        <?php if (!$Grid->dir_secuencia->IsNativeSelect) { ?>
        data-select2-id="flotesgrid_x<?= $Grid->RowIndex ?>_dir_secuencia"
        <?php } ?>
        data-table="lotes"
        data-field="x_dir_secuencia"
        data-value-separator="<?= $Grid->dir_secuencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->dir_secuencia->getPlaceHolder()) ?>"
        <?= $Grid->dir_secuencia->editAttributes() ?>>
        <?= $Grid->dir_secuencia->selectOptionListHtml("x{$Grid->RowIndex}_dir_secuencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->dir_secuencia->getErrorMessage() ?></div>
<?= $Grid->dir_secuencia->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_dir_secuencia") ?>
<?php if (!$Grid->dir_secuencia->IsNativeSelect) { ?>
<script>
loadjs.ready("flotesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_dir_secuencia", selectId: "flotesgrid_x<?= $Grid->RowIndex ?>_dir_secuencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flotesgrid.lists.dir_secuencia?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_dir_secuencia", form: "flotesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_dir_secuencia", form: "flotesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.lotes.fields.dir_secuencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="lotes" data-field="x_dir_secuencia" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_dir_secuencia" id="o<?= $Grid->RowIndex ?>_dir_secuencia" value="<?= HtmlEncode($Grid->dir_secuencia->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_dir_secuencia" class="el_lotes_dir_secuencia">
    <select
        id="x<?= $Grid->RowIndex ?>_dir_secuencia"
        name="x<?= $Grid->RowIndex ?>_dir_secuencia"
        class="form-select ew-select<?= $Grid->dir_secuencia->isInvalidClass() ?>"
        <?php if (!$Grid->dir_secuencia->IsNativeSelect) { ?>
        data-select2-id="flotesgrid_x<?= $Grid->RowIndex ?>_dir_secuencia"
        <?php } ?>
        data-table="lotes"
        data-field="x_dir_secuencia"
        data-value-separator="<?= $Grid->dir_secuencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->dir_secuencia->getPlaceHolder()) ?>"
        <?= $Grid->dir_secuencia->editAttributes() ?>>
        <?= $Grid->dir_secuencia->selectOptionListHtml("x{$Grid->RowIndex}_dir_secuencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->dir_secuencia->getErrorMessage() ?></div>
<?= $Grid->dir_secuencia->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_dir_secuencia") ?>
<?php if (!$Grid->dir_secuencia->IsNativeSelect) { ?>
<script>
loadjs.ready("flotesgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_dir_secuencia", selectId: "flotesgrid_x<?= $Grid->RowIndex ?>_dir_secuencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flotesgrid.lists.dir_secuencia?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_dir_secuencia", form: "flotesgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_dir_secuencia", form: "flotesgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.lotes.fields.dir_secuencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_lotes_dir_secuencia" class="el_lotes_dir_secuencia">
<span<?= $Grid->dir_secuencia->viewAttributes() ?>>
<?= $Grid->dir_secuencia->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="lotes" data-field="x_dir_secuencia" data-hidden="1" name="flotesgrid$x<?= $Grid->RowIndex ?>_dir_secuencia" id="flotesgrid$x<?= $Grid->RowIndex ?>_dir_secuencia" value="<?= HtmlEncode($Grid->dir_secuencia->FormValue) ?>">
<input type="hidden" data-table="lotes" data-field="x_dir_secuencia" data-hidden="1" data-old name="flotesgrid$o<?= $Grid->RowIndex ?>_dir_secuencia" id="flotesgrid$o<?= $Grid->RowIndex ?>_dir_secuencia" value="<?= HtmlEncode($Grid->dir_secuencia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == RowType::ADD || $Grid->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["flotesgrid","load"], () => flotesgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="flotesgrid">
</div><!-- /.ew-list-form -->
<?php
// Close result set
$Grid->Recordset?->free();
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Grid->FooterOptions?->render("body") ?>
</div>
</main>
<?php if (!$Grid->isExport()) { ?>
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
