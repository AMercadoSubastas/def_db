<?php

namespace PHPMaker2024\Subastas2024;

// Set up and run Grid object
$Grid = Container("DetfacGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fdetfacgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { detfac: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetfacgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null], fields.codnum.isInvalid],
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null, ew.Validators.integer], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null, ew.Validators.integer], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["nreng", [fields.nreng.visible && fields.nreng.required ? ew.Validators.required(fields.nreng.caption) : null, ew.Validators.integer], fields.nreng.isInvalid],
            ["codrem", [fields.codrem.visible && fields.codrem.required ? ew.Validators.required(fields.codrem.caption) : null, ew.Validators.integer], fields.codrem.isInvalid],
            ["codlote", [fields.codlote.visible && fields.codlote.required ? ew.Validators.required(fields.codlote.caption) : null, ew.Validators.integer], fields.codlote.isInvalid],
            ["descrip", [fields.descrip.visible && fields.descrip.required ? ew.Validators.required(fields.descrip.caption) : null], fields.descrip.isInvalid],
            ["neto", [fields.neto.visible && fields.neto.required ? ew.Validators.required(fields.neto.caption) : null, ew.Validators.float], fields.neto.isInvalid],
            ["bruto", [fields.bruto.visible && fields.bruto.required ? ew.Validators.required(fields.bruto.caption) : null, ew.Validators.float], fields.bruto.isInvalid],
            ["iva", [fields.iva.visible && fields.iva.required ? ew.Validators.required(fields.iva.caption) : null, ew.Validators.float], fields.iva.isInvalid],
            ["imp", [fields.imp.visible && fields.imp.required ? ew.Validators.required(fields.imp.caption) : null, ew.Validators.float], fields.imp.isInvalid],
            ["comcob", [fields.comcob.visible && fields.comcob.required ? ew.Validators.required(fields.comcob.caption) : null, ew.Validators.float], fields.comcob.isInvalid],
            ["compag", [fields.compag.visible && fields.compag.required ? ew.Validators.required(fields.compag.caption) : null, ew.Validators.float], fields.compag.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null], fields.fechahora.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["porciva", [fields.porciva.visible && fields.porciva.required ? ew.Validators.required(fields.porciva.caption) : null, ew.Validators.float], fields.porciva.isInvalid],
            ["tieneresol", [fields.tieneresol.visible && fields.tieneresol.required ? ew.Validators.required(fields.tieneresol.caption) : null], fields.tieneresol.isInvalid],
            ["concafac", [fields.concafac.visible && fields.concafac.required ? ew.Validators.required(fields.concafac.caption) : null, ew.Validators.integer], fields.concafac.isInvalid],
            ["tcomsal", [fields.tcomsal.visible && fields.tcomsal.required ? ew.Validators.required(fields.tcomsal.caption) : null, ew.Validators.integer], fields.tcomsal.isInvalid],
            ["seriesal", [fields.seriesal.visible && fields.seriesal.required ? ew.Validators.required(fields.seriesal.caption) : null, ew.Validators.integer], fields.seriesal.isInvalid],
            ["ncompsal", [fields.ncompsal.visible && fields.ncompsal.required ? ew.Validators.required(fields.ncompsal.caption) : null, ew.Validators.integer], fields.ncompsal.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tcomp",false],["serie",false],["ncomp",false],["nreng",false],["codrem",false],["codlote",false],["descrip",false],["neto",false],["bruto",false],["iva",false],["imp",false],["comcob",false],["compag",false],["porciva",false],["tieneresol",false],["concafac",false],["tcomsal",false],["seriesal",false],["ncompsal",false]];
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
<div id="fdetfacgrid" class="ew-form ew-list-form">
<div id="gmp_detfac" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_detfacgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->codnum->Visible) { // codnum ?>
        <th data-name="codnum" class="<?= $Grid->codnum->headerCellClass() ?>"><div id="elh_detfac_codnum" class="detfac_codnum"><?= $Grid->renderFieldHeader($Grid->codnum) ?></div></th>
<?php } ?>
<?php if ($Grid->tcomp->Visible) { // tcomp ?>
        <th data-name="tcomp" class="<?= $Grid->tcomp->headerCellClass() ?>"><div id="elh_detfac_tcomp" class="detfac_tcomp"><?= $Grid->renderFieldHeader($Grid->tcomp) ?></div></th>
<?php } ?>
<?php if ($Grid->serie->Visible) { // serie ?>
        <th data-name="serie" class="<?= $Grid->serie->headerCellClass() ?>"><div id="elh_detfac_serie" class="detfac_serie"><?= $Grid->renderFieldHeader($Grid->serie) ?></div></th>
<?php } ?>
<?php if ($Grid->ncomp->Visible) { // ncomp ?>
        <th data-name="ncomp" class="<?= $Grid->ncomp->headerCellClass() ?>"><div id="elh_detfac_ncomp" class="detfac_ncomp"><?= $Grid->renderFieldHeader($Grid->ncomp) ?></div></th>
<?php } ?>
<?php if ($Grid->nreng->Visible) { // nreng ?>
        <th data-name="nreng" class="<?= $Grid->nreng->headerCellClass() ?>"><div id="elh_detfac_nreng" class="detfac_nreng"><?= $Grid->renderFieldHeader($Grid->nreng) ?></div></th>
<?php } ?>
<?php if ($Grid->codrem->Visible) { // codrem ?>
        <th data-name="codrem" class="<?= $Grid->codrem->headerCellClass() ?>"><div id="elh_detfac_codrem" class="detfac_codrem"><?= $Grid->renderFieldHeader($Grid->codrem) ?></div></th>
<?php } ?>
<?php if ($Grid->codlote->Visible) { // codlote ?>
        <th data-name="codlote" class="<?= $Grid->codlote->headerCellClass() ?>"><div id="elh_detfac_codlote" class="detfac_codlote"><?= $Grid->renderFieldHeader($Grid->codlote) ?></div></th>
<?php } ?>
<?php if ($Grid->descrip->Visible) { // descrip ?>
        <th data-name="descrip" class="<?= $Grid->descrip->headerCellClass() ?>"><div id="elh_detfac_descrip" class="detfac_descrip"><?= $Grid->renderFieldHeader($Grid->descrip) ?></div></th>
<?php } ?>
<?php if ($Grid->neto->Visible) { // neto ?>
        <th data-name="neto" class="<?= $Grid->neto->headerCellClass() ?>"><div id="elh_detfac_neto" class="detfac_neto"><?= $Grid->renderFieldHeader($Grid->neto) ?></div></th>
<?php } ?>
<?php if ($Grid->bruto->Visible) { // bruto ?>
        <th data-name="bruto" class="<?= $Grid->bruto->headerCellClass() ?>"><div id="elh_detfac_bruto" class="detfac_bruto"><?= $Grid->renderFieldHeader($Grid->bruto) ?></div></th>
<?php } ?>
<?php if ($Grid->iva->Visible) { // iva ?>
        <th data-name="iva" class="<?= $Grid->iva->headerCellClass() ?>"><div id="elh_detfac_iva" class="detfac_iva"><?= $Grid->renderFieldHeader($Grid->iva) ?></div></th>
<?php } ?>
<?php if ($Grid->imp->Visible) { // imp ?>
        <th data-name="imp" class="<?= $Grid->imp->headerCellClass() ?>"><div id="elh_detfac_imp" class="detfac_imp"><?= $Grid->renderFieldHeader($Grid->imp) ?></div></th>
<?php } ?>
<?php if ($Grid->comcob->Visible) { // comcob ?>
        <th data-name="comcob" class="<?= $Grid->comcob->headerCellClass() ?>"><div id="elh_detfac_comcob" class="detfac_comcob"><?= $Grid->renderFieldHeader($Grid->comcob) ?></div></th>
<?php } ?>
<?php if ($Grid->compag->Visible) { // compag ?>
        <th data-name="compag" class="<?= $Grid->compag->headerCellClass() ?>"><div id="elh_detfac_compag" class="detfac_compag"><?= $Grid->renderFieldHeader($Grid->compag) ?></div></th>
<?php } ?>
<?php if ($Grid->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Grid->fechahora->headerCellClass() ?>"><div id="elh_detfac_fechahora" class="detfac_fechahora"><?= $Grid->renderFieldHeader($Grid->fechahora) ?></div></th>
<?php } ?>
<?php if ($Grid->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Grid->usuario->headerCellClass() ?>"><div id="elh_detfac_usuario" class="detfac_usuario"><?= $Grid->renderFieldHeader($Grid->usuario) ?></div></th>
<?php } ?>
<?php if ($Grid->porciva->Visible) { // porciva ?>
        <th data-name="porciva" class="<?= $Grid->porciva->headerCellClass() ?>"><div id="elh_detfac_porciva" class="detfac_porciva"><?= $Grid->renderFieldHeader($Grid->porciva) ?></div></th>
<?php } ?>
<?php if ($Grid->tieneresol->Visible) { // tieneresol ?>
        <th data-name="tieneresol" class="<?= $Grid->tieneresol->headerCellClass() ?>"><div id="elh_detfac_tieneresol" class="detfac_tieneresol"><?= $Grid->renderFieldHeader($Grid->tieneresol) ?></div></th>
<?php } ?>
<?php if ($Grid->concafac->Visible) { // concafac ?>
        <th data-name="concafac" class="<?= $Grid->concafac->headerCellClass() ?>"><div id="elh_detfac_concafac" class="detfac_concafac"><?= $Grid->renderFieldHeader($Grid->concafac) ?></div></th>
<?php } ?>
<?php if ($Grid->tcomsal->Visible) { // tcomsal ?>
        <th data-name="tcomsal" class="<?= $Grid->tcomsal->headerCellClass() ?>"><div id="elh_detfac_tcomsal" class="detfac_tcomsal"><?= $Grid->renderFieldHeader($Grid->tcomsal) ?></div></th>
<?php } ?>
<?php if ($Grid->seriesal->Visible) { // seriesal ?>
        <th data-name="seriesal" class="<?= $Grid->seriesal->headerCellClass() ?>"><div id="elh_detfac_seriesal" class="detfac_seriesal"><?= $Grid->renderFieldHeader($Grid->seriesal) ?></div></th>
<?php } ?>
<?php if ($Grid->ncompsal->Visible) { // ncompsal ?>
        <th data-name="ncompsal" class="<?= $Grid->ncompsal->headerCellClass() ?>"><div id="elh_detfac_ncompsal" class="detfac_ncompsal"><?= $Grid->renderFieldHeader($Grid->ncompsal) ?></div></th>
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
    <?php if ($Grid->codnum->Visible) { // codnum ?>
        <td data-name="codnum"<?= $Grid->codnum->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codnum" class="el_detfac_codnum"></span>
<input type="hidden" data-table="detfac" data-field="x_codnum" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codnum" id="o<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codnum" class="el_detfac_codnum">
<span<?= $Grid->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->codnum->getDisplayValue($Grid->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="detfac" data-field="x_codnum" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codnum" id="x<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codnum" class="el_detfac_codnum">
<span<?= $Grid->codnum->viewAttributes() ?>>
<?= $Grid->codnum->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_codnum" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_codnum" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_codnum" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_codnum" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detfac" data-field="x_codnum" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codnum" id="x<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->tcomp->Visible) { // tcomp ?>
        <td data-name="tcomp"<?= $Grid->tcomp->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->tcomp->getSessionValue() != "") { ?>
<span<?= $Grid->tcomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tcomp->getDisplayValue($Grid->tcomp->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_tcomp" name="x<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tcomp" class="el_detfac_tcomp">
<input type="<?= $Grid->tcomp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tcomp" id="x<?= $Grid->RowIndex ?>_tcomp" data-table="detfac" data-field="x_tcomp" value="<?= $Grid->tcomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tcomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tcomp->formatPattern()) ?>"<?= $Grid->tcomp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tcomp->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detfac" data-field="x_tcomp" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tcomp" id="o<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->tcomp->getSessionValue() != "") { ?>
<span<?= $Grid->tcomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tcomp->getDisplayValue($Grid->tcomp->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_tcomp" name="x<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tcomp" class="el_detfac_tcomp">
<input type="<?= $Grid->tcomp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tcomp" id="x<?= $Grid->RowIndex ?>_tcomp" data-table="detfac" data-field="x_tcomp" value="<?= $Grid->tcomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tcomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tcomp->formatPattern()) ?>"<?= $Grid->tcomp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tcomp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tcomp" class="el_detfac_tcomp">
<span<?= $Grid->tcomp->viewAttributes() ?>>
<?= $Grid->tcomp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_tcomp" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_tcomp" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_tcomp" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_tcomp" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->serie->Visible) { // serie ?>
        <td data-name="serie"<?= $Grid->serie->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->serie->getSessionValue() != "") { ?>
<span<?= $Grid->serie->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->serie->getDisplayValue($Grid->serie->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_serie" name="x<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_serie" class="el_detfac_serie">
<input type="<?= $Grid->serie->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_serie" id="x<?= $Grid->RowIndex ?>_serie" data-table="detfac" data-field="x_serie" value="<?= $Grid->serie->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->serie->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->serie->formatPattern()) ?>"<?= $Grid->serie->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->serie->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detfac" data-field="x_serie" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_serie" id="o<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->serie->getSessionValue() != "") { ?>
<span<?= $Grid->serie->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->serie->getDisplayValue($Grid->serie->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_serie" name="x<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_serie" class="el_detfac_serie">
<input type="<?= $Grid->serie->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_serie" id="x<?= $Grid->RowIndex ?>_serie" data-table="detfac" data-field="x_serie" value="<?= $Grid->serie->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->serie->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->serie->formatPattern()) ?>"<?= $Grid->serie->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->serie->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_serie" class="el_detfac_serie">
<span<?= $Grid->serie->viewAttributes() ?>>
<?= $Grid->serie->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_serie" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_serie" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_serie" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_serie" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ncomp->Visible) { // ncomp ?>
        <td data-name="ncomp"<?= $Grid->ncomp->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->ncomp->getSessionValue() != "") { ?>
<span<?= $Grid->ncomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ncomp->getDisplayValue($Grid->ncomp->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ncomp" name="x<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_ncomp" class="el_detfac_ncomp">
<input type="<?= $Grid->ncomp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ncomp" id="x<?= $Grid->RowIndex ?>_ncomp" data-table="detfac" data-field="x_ncomp" value="<?= $Grid->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ncomp->formatPattern()) ?>"<?= $Grid->ncomp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ncomp->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detfac" data-field="x_ncomp" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ncomp" id="o<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->ncomp->getSessionValue() != "") { ?>
<span<?= $Grid->ncomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ncomp->getDisplayValue($Grid->ncomp->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ncomp" name="x<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_ncomp" class="el_detfac_ncomp">
<input type="<?= $Grid->ncomp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ncomp" id="x<?= $Grid->RowIndex ?>_ncomp" data-table="detfac" data-field="x_ncomp" value="<?= $Grid->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ncomp->formatPattern()) ?>"<?= $Grid->ncomp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ncomp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_ncomp" class="el_detfac_ncomp">
<span<?= $Grid->ncomp->viewAttributes() ?>>
<?= $Grid->ncomp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_ncomp" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_ncomp" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_ncomp" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_ncomp" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nreng->Visible) { // nreng ?>
        <td data-name="nreng"<?= $Grid->nreng->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_nreng" class="el_detfac_nreng">
<input type="<?= $Grid->nreng->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nreng" id="x<?= $Grid->RowIndex ?>_nreng" data-table="detfac" data-field="x_nreng" value="<?= $Grid->nreng->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->nreng->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nreng->formatPattern()) ?>"<?= $Grid->nreng->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nreng->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_nreng" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nreng" id="o<?= $Grid->RowIndex ?>_nreng" value="<?= HtmlEncode($Grid->nreng->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_nreng" class="el_detfac_nreng">
<input type="<?= $Grid->nreng->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nreng" id="x<?= $Grid->RowIndex ?>_nreng" data-table="detfac" data-field="x_nreng" value="<?= $Grid->nreng->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->nreng->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nreng->formatPattern()) ?>"<?= $Grid->nreng->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nreng->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_nreng" class="el_detfac_nreng">
<span<?= $Grid->nreng->viewAttributes() ?>>
<?= $Grid->nreng->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_nreng" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_nreng" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_nreng" value="<?= HtmlEncode($Grid->nreng->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_nreng" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_nreng" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_nreng" value="<?= HtmlEncode($Grid->nreng->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->codrem->Visible) { // codrem ?>
        <td data-name="codrem"<?= $Grid->codrem->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codrem" class="el_detfac_codrem">
<input type="<?= $Grid->codrem->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codrem" id="x<?= $Grid->RowIndex ?>_codrem" data-table="detfac" data-field="x_codrem" value="<?= $Grid->codrem->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->codrem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codrem->formatPattern()) ?>"<?= $Grid->codrem->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codrem->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_codrem" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codrem" id="o<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codrem" class="el_detfac_codrem">
<input type="<?= $Grid->codrem->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codrem" id="x<?= $Grid->RowIndex ?>_codrem" data-table="detfac" data-field="x_codrem" value="<?= $Grid->codrem->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->codrem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codrem->formatPattern()) ?>"<?= $Grid->codrem->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codrem->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codrem" class="el_detfac_codrem">
<span<?= $Grid->codrem->viewAttributes() ?>>
<?= $Grid->codrem->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_codrem" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_codrem" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_codrem" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_codrem" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_codrem" value="<?= HtmlEncode($Grid->codrem->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->codlote->Visible) { // codlote ?>
        <td data-name="codlote"<?= $Grid->codlote->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codlote" class="el_detfac_codlote">
<input type="<?= $Grid->codlote->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codlote" id="x<?= $Grid->RowIndex ?>_codlote" data-table="detfac" data-field="x_codlote" value="<?= $Grid->codlote->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->codlote->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codlote->formatPattern()) ?>"<?= $Grid->codlote->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codlote->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_codlote" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codlote" id="o<?= $Grid->RowIndex ?>_codlote" value="<?= HtmlEncode($Grid->codlote->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codlote" class="el_detfac_codlote">
<input type="<?= $Grid->codlote->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_codlote" id="x<?= $Grid->RowIndex ?>_codlote" data-table="detfac" data-field="x_codlote" value="<?= $Grid->codlote->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->codlote->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->codlote->formatPattern()) ?>"<?= $Grid->codlote->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->codlote->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_codlote" class="el_detfac_codlote">
<span<?= $Grid->codlote->viewAttributes() ?>>
<?= $Grid->codlote->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_codlote" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_codlote" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_codlote" value="<?= HtmlEncode($Grid->codlote->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_codlote" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_codlote" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_codlote" value="<?= HtmlEncode($Grid->codlote->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->descrip->Visible) { // descrip ?>
        <td data-name="descrip"<?= $Grid->descrip->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_descrip" class="el_detfac_descrip">
<input type="<?= $Grid->descrip->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_descrip" id="x<?= $Grid->RowIndex ?>_descrip" data-table="detfac" data-field="x_descrip" value="<?= $Grid->descrip->EditValue ?>" size="30" maxlength="300" placeholder="<?= HtmlEncode($Grid->descrip->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->descrip->formatPattern()) ?>"<?= $Grid->descrip->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->descrip->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_descrip" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_descrip" id="o<?= $Grid->RowIndex ?>_descrip" value="<?= HtmlEncode($Grid->descrip->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_descrip" class="el_detfac_descrip">
<input type="<?= $Grid->descrip->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_descrip" id="x<?= $Grid->RowIndex ?>_descrip" data-table="detfac" data-field="x_descrip" value="<?= $Grid->descrip->EditValue ?>" size="30" maxlength="300" placeholder="<?= HtmlEncode($Grid->descrip->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->descrip->formatPattern()) ?>"<?= $Grid->descrip->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->descrip->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_descrip" class="el_detfac_descrip">
<span<?= $Grid->descrip->viewAttributes() ?>>
<?= $Grid->descrip->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_descrip" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_descrip" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_descrip" value="<?= HtmlEncode($Grid->descrip->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_descrip" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_descrip" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_descrip" value="<?= HtmlEncode($Grid->descrip->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->neto->Visible) { // neto ?>
        <td data-name="neto"<?= $Grid->neto->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_neto" class="el_detfac_neto">
<input type="<?= $Grid->neto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_neto" id="x<?= $Grid->RowIndex ?>_neto" data-table="detfac" data-field="x_neto" value="<?= $Grid->neto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->neto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->neto->formatPattern()) ?>"<?= $Grid->neto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->neto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_neto" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_neto" id="o<?= $Grid->RowIndex ?>_neto" value="<?= HtmlEncode($Grid->neto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_neto" class="el_detfac_neto">
<input type="<?= $Grid->neto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_neto" id="x<?= $Grid->RowIndex ?>_neto" data-table="detfac" data-field="x_neto" value="<?= $Grid->neto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->neto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->neto->formatPattern()) ?>"<?= $Grid->neto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->neto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_neto" class="el_detfac_neto">
<span<?= $Grid->neto->viewAttributes() ?>>
<?= $Grid->neto->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_neto" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_neto" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_neto" value="<?= HtmlEncode($Grid->neto->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_neto" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_neto" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_neto" value="<?= HtmlEncode($Grid->neto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bruto->Visible) { // bruto ?>
        <td data-name="bruto"<?= $Grid->bruto->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_bruto" class="el_detfac_bruto">
<input type="<?= $Grid->bruto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_bruto" id="x<?= $Grid->RowIndex ?>_bruto" data-table="detfac" data-field="x_bruto" value="<?= $Grid->bruto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->bruto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->bruto->formatPattern()) ?>"<?= $Grid->bruto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bruto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_bruto" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_bruto" id="o<?= $Grid->RowIndex ?>_bruto" value="<?= HtmlEncode($Grid->bruto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_bruto" class="el_detfac_bruto">
<input type="<?= $Grid->bruto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_bruto" id="x<?= $Grid->RowIndex ?>_bruto" data-table="detfac" data-field="x_bruto" value="<?= $Grid->bruto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->bruto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->bruto->formatPattern()) ?>"<?= $Grid->bruto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bruto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_bruto" class="el_detfac_bruto">
<span<?= $Grid->bruto->viewAttributes() ?>>
<?= $Grid->bruto->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_bruto" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_bruto" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_bruto" value="<?= HtmlEncode($Grid->bruto->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_bruto" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_bruto" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_bruto" value="<?= HtmlEncode($Grid->bruto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->iva->Visible) { // iva ?>
        <td data-name="iva"<?= $Grid->iva->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_iva" class="el_detfac_iva">
<input type="<?= $Grid->iva->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_iva" id="x<?= $Grid->RowIndex ?>_iva" data-table="detfac" data-field="x_iva" value="<?= $Grid->iva->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->iva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->iva->formatPattern()) ?>"<?= $Grid->iva->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->iva->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_iva" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_iva" id="o<?= $Grid->RowIndex ?>_iva" value="<?= HtmlEncode($Grid->iva->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_iva" class="el_detfac_iva">
<input type="<?= $Grid->iva->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_iva" id="x<?= $Grid->RowIndex ?>_iva" data-table="detfac" data-field="x_iva" value="<?= $Grid->iva->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->iva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->iva->formatPattern()) ?>"<?= $Grid->iva->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->iva->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_iva" class="el_detfac_iva">
<span<?= $Grid->iva->viewAttributes() ?>>
<?= $Grid->iva->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_iva" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_iva" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_iva" value="<?= HtmlEncode($Grid->iva->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_iva" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_iva" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_iva" value="<?= HtmlEncode($Grid->iva->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->imp->Visible) { // imp ?>
        <td data-name="imp"<?= $Grid->imp->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_imp" class="el_detfac_imp">
<input type="<?= $Grid->imp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_imp" id="x<?= $Grid->RowIndex ?>_imp" data-table="detfac" data-field="x_imp" value="<?= $Grid->imp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->imp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->imp->formatPattern()) ?>"<?= $Grid->imp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->imp->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_imp" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_imp" id="o<?= $Grid->RowIndex ?>_imp" value="<?= HtmlEncode($Grid->imp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_imp" class="el_detfac_imp">
<input type="<?= $Grid->imp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_imp" id="x<?= $Grid->RowIndex ?>_imp" data-table="detfac" data-field="x_imp" value="<?= $Grid->imp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->imp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->imp->formatPattern()) ?>"<?= $Grid->imp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->imp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_imp" class="el_detfac_imp">
<span<?= $Grid->imp->viewAttributes() ?>>
<?= $Grid->imp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_imp" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_imp" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_imp" value="<?= HtmlEncode($Grid->imp->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_imp" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_imp" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_imp" value="<?= HtmlEncode($Grid->imp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->comcob->Visible) { // comcob ?>
        <td data-name="comcob"<?= $Grid->comcob->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_comcob" class="el_detfac_comcob">
<input type="<?= $Grid->comcob->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_comcob" id="x<?= $Grid->RowIndex ?>_comcob" data-table="detfac" data-field="x_comcob" value="<?= $Grid->comcob->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->comcob->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->comcob->formatPattern()) ?>"<?= $Grid->comcob->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->comcob->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_comcob" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_comcob" id="o<?= $Grid->RowIndex ?>_comcob" value="<?= HtmlEncode($Grid->comcob->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_comcob" class="el_detfac_comcob">
<input type="<?= $Grid->comcob->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_comcob" id="x<?= $Grid->RowIndex ?>_comcob" data-table="detfac" data-field="x_comcob" value="<?= $Grid->comcob->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->comcob->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->comcob->formatPattern()) ?>"<?= $Grid->comcob->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->comcob->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_comcob" class="el_detfac_comcob">
<span<?= $Grid->comcob->viewAttributes() ?>>
<?= $Grid->comcob->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_comcob" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_comcob" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_comcob" value="<?= HtmlEncode($Grid->comcob->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_comcob" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_comcob" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_comcob" value="<?= HtmlEncode($Grid->comcob->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->compag->Visible) { // compag ?>
        <td data-name="compag"<?= $Grid->compag->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_compag" class="el_detfac_compag">
<input type="<?= $Grid->compag->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_compag" id="x<?= $Grid->RowIndex ?>_compag" data-table="detfac" data-field="x_compag" value="<?= $Grid->compag->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->compag->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->compag->formatPattern()) ?>"<?= $Grid->compag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->compag->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_compag" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_compag" id="o<?= $Grid->RowIndex ?>_compag" value="<?= HtmlEncode($Grid->compag->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_compag" class="el_detfac_compag">
<input type="<?= $Grid->compag->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_compag" id="x<?= $Grid->RowIndex ?>_compag" data-table="detfac" data-field="x_compag" value="<?= $Grid->compag->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->compag->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->compag->formatPattern()) ?>"<?= $Grid->compag->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->compag->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_compag" class="el_detfac_compag">
<span<?= $Grid->compag->viewAttributes() ?>>
<?= $Grid->compag->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_compag" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_compag" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_compag" value="<?= HtmlEncode($Grid->compag->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_compag" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_compag" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_compag" value="<?= HtmlEncode($Grid->compag->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Grid->fechahora->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="detfac" data-field="x_fechahora" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fechahora" id="o<?= $Grid->RowIndex ?>_fechahora" value="<?= HtmlEncode($Grid->fechahora->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_fechahora" class="el_detfac_fechahora">
<span<?= $Grid->fechahora->viewAttributes() ?>>
<?= $Grid->fechahora->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_fechahora" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_fechahora" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_fechahora" value="<?= HtmlEncode($Grid->fechahora->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_fechahora" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_fechahora" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_fechahora" value="<?= HtmlEncode($Grid->fechahora->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Grid->usuario->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<input type="hidden" data-table="detfac" data-field="x_usuario" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_usuario" id="o<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_usuario" class="el_detfac_usuario">
<span<?= $Grid->usuario->viewAttributes() ?>>
<?= $Grid->usuario->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_usuario" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_usuario" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_usuario" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_usuario" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->porciva->Visible) { // porciva ?>
        <td data-name="porciva"<?= $Grid->porciva->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_porciva" class="el_detfac_porciva">
<input type="<?= $Grid->porciva->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_porciva" id="x<?= $Grid->RowIndex ?>_porciva" data-table="detfac" data-field="x_porciva" value="<?= $Grid->porciva->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->porciva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->porciva->formatPattern()) ?>"<?= $Grid->porciva->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->porciva->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_porciva" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_porciva" id="o<?= $Grid->RowIndex ?>_porciva" value="<?= HtmlEncode($Grid->porciva->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_porciva" class="el_detfac_porciva">
<input type="<?= $Grid->porciva->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_porciva" id="x<?= $Grid->RowIndex ?>_porciva" data-table="detfac" data-field="x_porciva" value="<?= $Grid->porciva->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->porciva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->porciva->formatPattern()) ?>"<?= $Grid->porciva->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->porciva->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_porciva" class="el_detfac_porciva">
<span<?= $Grid->porciva->viewAttributes() ?>>
<?= $Grid->porciva->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_porciva" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_porciva" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_porciva" value="<?= HtmlEncode($Grid->porciva->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_porciva" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_porciva" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_porciva" value="<?= HtmlEncode($Grid->porciva->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tieneresol->Visible) { // tieneresol ?>
        <td data-name="tieneresol"<?= $Grid->tieneresol->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tieneresol" class="el_detfac_tieneresol">
<input type="hidden" data-table="detfac" data-field="x_tieneresol" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tieneresol" id="x<?= $Grid->RowIndex ?>_tieneresol" value="<?= HtmlEncode($Grid->tieneresol->CurrentValue) ?>">
</span>
<input type="hidden" data-table="detfac" data-field="x_tieneresol" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tieneresol" id="o<?= $Grid->RowIndex ?>_tieneresol" value="<?= HtmlEncode($Grid->tieneresol->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tieneresol" class="el_detfac_tieneresol">
<input type="hidden" data-table="detfac" data-field="x_tieneresol" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tieneresol" id="x<?= $Grid->RowIndex ?>_tieneresol" value="<?= HtmlEncode($Grid->tieneresol->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tieneresol" class="el_detfac_tieneresol">
<span<?= $Grid->tieneresol->viewAttributes() ?>>
<?= $Grid->tieneresol->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_tieneresol" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_tieneresol" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_tieneresol" value="<?= HtmlEncode($Grid->tieneresol->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_tieneresol" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_tieneresol" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_tieneresol" value="<?= HtmlEncode($Grid->tieneresol->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->concafac->Visible) { // concafac ?>
        <td data-name="concafac"<?= $Grid->concafac->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_concafac" class="el_detfac_concafac">
<input type="<?= $Grid->concafac->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_concafac" id="x<?= $Grid->RowIndex ?>_concafac" data-table="detfac" data-field="x_concafac" value="<?= $Grid->concafac->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->concafac->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->concafac->formatPattern()) ?>"<?= $Grid->concafac->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->concafac->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_concafac" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_concafac" id="o<?= $Grid->RowIndex ?>_concafac" value="<?= HtmlEncode($Grid->concafac->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_concafac" class="el_detfac_concafac">
<input type="<?= $Grid->concafac->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_concafac" id="x<?= $Grid->RowIndex ?>_concafac" data-table="detfac" data-field="x_concafac" value="<?= $Grid->concafac->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->concafac->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->concafac->formatPattern()) ?>"<?= $Grid->concafac->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->concafac->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_concafac" class="el_detfac_concafac">
<span<?= $Grid->concafac->viewAttributes() ?>>
<?= $Grid->concafac->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_concafac" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_concafac" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_concafac" value="<?= HtmlEncode($Grid->concafac->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_concafac" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_concafac" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_concafac" value="<?= HtmlEncode($Grid->concafac->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tcomsal->Visible) { // tcomsal ?>
        <td data-name="tcomsal"<?= $Grid->tcomsal->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tcomsal" class="el_detfac_tcomsal">
<input type="<?= $Grid->tcomsal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tcomsal" id="x<?= $Grid->RowIndex ?>_tcomsal" data-table="detfac" data-field="x_tcomsal" value="<?= $Grid->tcomsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tcomsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tcomsal->formatPattern()) ?>"<?= $Grid->tcomsal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tcomsal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_tcomsal" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tcomsal" id="o<?= $Grid->RowIndex ?>_tcomsal" value="<?= HtmlEncode($Grid->tcomsal->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tcomsal" class="el_detfac_tcomsal">
<input type="<?= $Grid->tcomsal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tcomsal" id="x<?= $Grid->RowIndex ?>_tcomsal" data-table="detfac" data-field="x_tcomsal" value="<?= $Grid->tcomsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tcomsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tcomsal->formatPattern()) ?>"<?= $Grid->tcomsal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tcomsal->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_tcomsal" class="el_detfac_tcomsal">
<span<?= $Grid->tcomsal->viewAttributes() ?>>
<?= $Grid->tcomsal->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_tcomsal" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_tcomsal" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_tcomsal" value="<?= HtmlEncode($Grid->tcomsal->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_tcomsal" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_tcomsal" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_tcomsal" value="<?= HtmlEncode($Grid->tcomsal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->seriesal->Visible) { // seriesal ?>
        <td data-name="seriesal"<?= $Grid->seriesal->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_seriesal" class="el_detfac_seriesal">
<input type="<?= $Grid->seriesal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_seriesal" id="x<?= $Grid->RowIndex ?>_seriesal" data-table="detfac" data-field="x_seriesal" value="<?= $Grid->seriesal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->seriesal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->seriesal->formatPattern()) ?>"<?= $Grid->seriesal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->seriesal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_seriesal" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_seriesal" id="o<?= $Grid->RowIndex ?>_seriesal" value="<?= HtmlEncode($Grid->seriesal->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_seriesal" class="el_detfac_seriesal">
<input type="<?= $Grid->seriesal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_seriesal" id="x<?= $Grid->RowIndex ?>_seriesal" data-table="detfac" data-field="x_seriesal" value="<?= $Grid->seriesal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->seriesal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->seriesal->formatPattern()) ?>"<?= $Grid->seriesal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->seriesal->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_seriesal" class="el_detfac_seriesal">
<span<?= $Grid->seriesal->viewAttributes() ?>>
<?= $Grid->seriesal->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_seriesal" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_seriesal" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_seriesal" value="<?= HtmlEncode($Grid->seriesal->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_seriesal" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_seriesal" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_seriesal" value="<?= HtmlEncode($Grid->seriesal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ncompsal->Visible) { // ncompsal ?>
        <td data-name="ncompsal"<?= $Grid->ncompsal->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_ncompsal" class="el_detfac_ncompsal">
<input type="<?= $Grid->ncompsal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ncompsal" id="x<?= $Grid->RowIndex ?>_ncompsal" data-table="detfac" data-field="x_ncompsal" value="<?= $Grid->ncompsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ncompsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ncompsal->formatPattern()) ?>"<?= $Grid->ncompsal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ncompsal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detfac" data-field="x_ncompsal" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ncompsal" id="o<?= $Grid->RowIndex ?>_ncompsal" value="<?= HtmlEncode($Grid->ncompsal->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_ncompsal" class="el_detfac_ncompsal">
<input type="<?= $Grid->ncompsal->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ncompsal" id="x<?= $Grid->RowIndex ?>_ncompsal" data-table="detfac" data-field="x_ncompsal" value="<?= $Grid->ncompsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ncompsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ncompsal->formatPattern()) ?>"<?= $Grid->ncompsal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ncompsal->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detfac_ncompsal" class="el_detfac_ncompsal">
<span<?= $Grid->ncompsal->viewAttributes() ?>>
<?= $Grid->ncompsal->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detfac" data-field="x_ncompsal" data-hidden="1" name="fdetfacgrid$x<?= $Grid->RowIndex ?>_ncompsal" id="fdetfacgrid$x<?= $Grid->RowIndex ?>_ncompsal" value="<?= HtmlEncode($Grid->ncompsal->FormValue) ?>">
<input type="hidden" data-table="detfac" data-field="x_ncompsal" data-hidden="1" data-old name="fdetfacgrid$o<?= $Grid->RowIndex ?>_ncompsal" id="fdetfacgrid$o<?= $Grid->RowIndex ?>_ncompsal" value="<?= HtmlEncode($Grid->ncompsal->OldValue) ?>">
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
loadjs.ready(["fdetfacgrid","load"], () => fdetfacgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fdetfacgrid">
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
    ew.addEventHandlers("detfac");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
