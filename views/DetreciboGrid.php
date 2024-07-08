<?php

namespace PHPMaker2024\Subastas2024;

// Set up and run Grid object
$Grid = Container("DetreciboGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fdetrecibogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { detrecibo: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetrecibogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null], fields.codnum.isInvalid],
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null, ew.Validators.integer], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null, ew.Validators.integer], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["nreng", [fields.nreng.visible && fields.nreng.required ? ew.Validators.required(fields.nreng.caption) : null, ew.Validators.integer], fields.nreng.isInvalid],
            ["tcomprel", [fields.tcomprel.visible && fields.tcomprel.required ? ew.Validators.required(fields.tcomprel.caption) : null, ew.Validators.integer], fields.tcomprel.isInvalid],
            ["serierel", [fields.serierel.visible && fields.serierel.required ? ew.Validators.required(fields.serierel.caption) : null, ew.Validators.integer], fields.serierel.isInvalid],
            ["ncomprel", [fields.ncomprel.visible && fields.ncomprel.required ? ew.Validators.required(fields.ncomprel.caption) : null, ew.Validators.integer], fields.ncomprel.isInvalid],
            ["netocbterel", [fields.netocbterel.visible && fields.netocbterel.required ? ew.Validators.required(fields.netocbterel.caption) : null, ew.Validators.float], fields.netocbterel.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null, ew.Validators.integer], fields.usuario.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null, ew.Validators.datetime(fields.fechahora.clientFormatPattern)], fields.fechahora.isInvalid],
            ["nrodoc", [fields.nrodoc.visible && fields.nrodoc.required ? ew.Validators.required(fields.nrodoc.caption) : null], fields.nrodoc.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tcomp",false],["serie",false],["ncomp",false],["nreng",false],["tcomprel",false],["serierel",false],["ncomprel",false],["netocbterel",false],["usuario",false],["fechahora",false],["nrodoc",false]];
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
<div id="fdetrecibogrid" class="ew-form ew-list-form">
<div id="gmp_detrecibo" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_detrecibogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="codnum" class="<?= $Grid->codnum->headerCellClass() ?>"><div id="elh_detrecibo_codnum" class="detrecibo_codnum"><?= $Grid->renderFieldHeader($Grid->codnum) ?></div></th>
<?php } ?>
<?php if ($Grid->tcomp->Visible) { // tcomp ?>
        <th data-name="tcomp" class="<?= $Grid->tcomp->headerCellClass() ?>"><div id="elh_detrecibo_tcomp" class="detrecibo_tcomp"><?= $Grid->renderFieldHeader($Grid->tcomp) ?></div></th>
<?php } ?>
<?php if ($Grid->serie->Visible) { // serie ?>
        <th data-name="serie" class="<?= $Grid->serie->headerCellClass() ?>"><div id="elh_detrecibo_serie" class="detrecibo_serie"><?= $Grid->renderFieldHeader($Grid->serie) ?></div></th>
<?php } ?>
<?php if ($Grid->ncomp->Visible) { // ncomp ?>
        <th data-name="ncomp" class="<?= $Grid->ncomp->headerCellClass() ?>"><div id="elh_detrecibo_ncomp" class="detrecibo_ncomp"><?= $Grid->renderFieldHeader($Grid->ncomp) ?></div></th>
<?php } ?>
<?php if ($Grid->nreng->Visible) { // nreng ?>
        <th data-name="nreng" class="<?= $Grid->nreng->headerCellClass() ?>"><div id="elh_detrecibo_nreng" class="detrecibo_nreng"><?= $Grid->renderFieldHeader($Grid->nreng) ?></div></th>
<?php } ?>
<?php if ($Grid->tcomprel->Visible) { // tcomprel ?>
        <th data-name="tcomprel" class="<?= $Grid->tcomprel->headerCellClass() ?>"><div id="elh_detrecibo_tcomprel" class="detrecibo_tcomprel"><?= $Grid->renderFieldHeader($Grid->tcomprel) ?></div></th>
<?php } ?>
<?php if ($Grid->serierel->Visible) { // serierel ?>
        <th data-name="serierel" class="<?= $Grid->serierel->headerCellClass() ?>"><div id="elh_detrecibo_serierel" class="detrecibo_serierel"><?= $Grid->renderFieldHeader($Grid->serierel) ?></div></th>
<?php } ?>
<?php if ($Grid->ncomprel->Visible) { // ncomprel ?>
        <th data-name="ncomprel" class="<?= $Grid->ncomprel->headerCellClass() ?>"><div id="elh_detrecibo_ncomprel" class="detrecibo_ncomprel"><?= $Grid->renderFieldHeader($Grid->ncomprel) ?></div></th>
<?php } ?>
<?php if ($Grid->netocbterel->Visible) { // netocbterel ?>
        <th data-name="netocbterel" class="<?= $Grid->netocbterel->headerCellClass() ?>"><div id="elh_detrecibo_netocbterel" class="detrecibo_netocbterel"><?= $Grid->renderFieldHeader($Grid->netocbterel) ?></div></th>
<?php } ?>
<?php if ($Grid->usuario->Visible) { // usuario ?>
        <th data-name="usuario" class="<?= $Grid->usuario->headerCellClass() ?>"><div id="elh_detrecibo_usuario" class="detrecibo_usuario"><?= $Grid->renderFieldHeader($Grid->usuario) ?></div></th>
<?php } ?>
<?php if ($Grid->fechahora->Visible) { // fechahora ?>
        <th data-name="fechahora" class="<?= $Grid->fechahora->headerCellClass() ?>"><div id="elh_detrecibo_fechahora" class="detrecibo_fechahora"><?= $Grid->renderFieldHeader($Grid->fechahora) ?></div></th>
<?php } ?>
<?php if ($Grid->nrodoc->Visible) { // nrodoc ?>
        <th data-name="nrodoc" class="<?= $Grid->nrodoc->headerCellClass() ?>"><div id="elh_detrecibo_nrodoc" class="detrecibo_nrodoc"><?= $Grid->renderFieldHeader($Grid->nrodoc) ?></div></th>
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
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_codnum" class="el_detrecibo_codnum"></span>
<input type="hidden" data-table="detrecibo" data-field="x_codnum" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_codnum" id="o<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_codnum" class="el_detrecibo_codnum">
<span<?= $Grid->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->codnum->getDisplayValue($Grid->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="detrecibo" data-field="x_codnum" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codnum" id="x<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_codnum" class="el_detrecibo_codnum">
<span<?= $Grid->codnum->viewAttributes() ?>>
<?= $Grid->codnum->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_codnum" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_codnum" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_codnum" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_codnum" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detrecibo" data-field="x_codnum" data-hidden="1" name="x<?= $Grid->RowIndex ?>_codnum" id="x<?= $Grid->RowIndex ?>_codnum" value="<?= HtmlEncode($Grid->codnum->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->tcomp->Visible) { // tcomp ?>
        <td data-name="tcomp"<?= $Grid->tcomp->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->tcomp->getSessionValue() != "") { ?>
<span<?= $Grid->tcomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tcomp->getDisplayValue($Grid->tcomp->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_tcomp" name="x<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_tcomp" class="el_detrecibo_tcomp">
<input type="<?= $Grid->tcomp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tcomp" id="x<?= $Grid->RowIndex ?>_tcomp" data-table="detrecibo" data-field="x_tcomp" value="<?= $Grid->tcomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tcomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tcomp->formatPattern()) ?>"<?= $Grid->tcomp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tcomp->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detrecibo" data-field="x_tcomp" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tcomp" id="o<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->tcomp->getSessionValue() != "") { ?>
<span<?= $Grid->tcomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tcomp->getDisplayValue($Grid->tcomp->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_tcomp" name="x<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_tcomp" class="el_detrecibo_tcomp">
<input type="<?= $Grid->tcomp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tcomp" id="x<?= $Grid->RowIndex ?>_tcomp" data-table="detrecibo" data-field="x_tcomp" value="<?= $Grid->tcomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tcomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tcomp->formatPattern()) ?>"<?= $Grid->tcomp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tcomp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_tcomp" class="el_detrecibo_tcomp">
<span<?= $Grid->tcomp->viewAttributes() ?>>
<?= $Grid->tcomp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_tcomp" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_tcomp" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_tcomp" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_tcomp" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_tcomp" value="<?= HtmlEncode($Grid->tcomp->OldValue) ?>">
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
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_serie" class="el_detrecibo_serie">
<input type="<?= $Grid->serie->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_serie" id="x<?= $Grid->RowIndex ?>_serie" data-table="detrecibo" data-field="x_serie" value="<?= $Grid->serie->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->serie->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->serie->formatPattern()) ?>"<?= $Grid->serie->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->serie->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detrecibo" data-field="x_serie" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_serie" id="o<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->serie->getSessionValue() != "") { ?>
<span<?= $Grid->serie->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->serie->getDisplayValue($Grid->serie->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_serie" name="x<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_serie" class="el_detrecibo_serie">
<input type="<?= $Grid->serie->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_serie" id="x<?= $Grid->RowIndex ?>_serie" data-table="detrecibo" data-field="x_serie" value="<?= $Grid->serie->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->serie->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->serie->formatPattern()) ?>"<?= $Grid->serie->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->serie->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_serie" class="el_detrecibo_serie">
<span<?= $Grid->serie->viewAttributes() ?>>
<?= $Grid->serie->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_serie" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_serie" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_serie" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_serie" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_serie" value="<?= HtmlEncode($Grid->serie->OldValue) ?>">
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
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_ncomp" class="el_detrecibo_ncomp">
<input type="<?= $Grid->ncomp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ncomp" id="x<?= $Grid->RowIndex ?>_ncomp" data-table="detrecibo" data-field="x_ncomp" value="<?= $Grid->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ncomp->formatPattern()) ?>"<?= $Grid->ncomp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ncomp->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detrecibo" data-field="x_ncomp" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ncomp" id="o<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->ncomp->getSessionValue() != "") { ?>
<span<?= $Grid->ncomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ncomp->getDisplayValue($Grid->ncomp->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ncomp" name="x<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_ncomp" class="el_detrecibo_ncomp">
<input type="<?= $Grid->ncomp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ncomp" id="x<?= $Grid->RowIndex ?>_ncomp" data-table="detrecibo" data-field="x_ncomp" value="<?= $Grid->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ncomp->formatPattern()) ?>"<?= $Grid->ncomp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ncomp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_ncomp" class="el_detrecibo_ncomp">
<span<?= $Grid->ncomp->viewAttributes() ?>>
<?= $Grid->ncomp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_ncomp" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_ncomp" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_ncomp" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_ncomp" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_ncomp" value="<?= HtmlEncode($Grid->ncomp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nreng->Visible) { // nreng ?>
        <td data-name="nreng"<?= $Grid->nreng->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_nreng" class="el_detrecibo_nreng">
<input type="<?= $Grid->nreng->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nreng" id="x<?= $Grid->RowIndex ?>_nreng" data-table="detrecibo" data-field="x_nreng" value="<?= $Grid->nreng->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->nreng->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nreng->formatPattern()) ?>"<?= $Grid->nreng->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nreng->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detrecibo" data-field="x_nreng" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nreng" id="o<?= $Grid->RowIndex ?>_nreng" value="<?= HtmlEncode($Grid->nreng->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_nreng" class="el_detrecibo_nreng">
<input type="<?= $Grid->nreng->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nreng" id="x<?= $Grid->RowIndex ?>_nreng" data-table="detrecibo" data-field="x_nreng" value="<?= $Grid->nreng->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->nreng->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nreng->formatPattern()) ?>"<?= $Grid->nreng->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nreng->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_nreng" class="el_detrecibo_nreng">
<span<?= $Grid->nreng->viewAttributes() ?>>
<?= $Grid->nreng->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_nreng" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_nreng" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_nreng" value="<?= HtmlEncode($Grid->nreng->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_nreng" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_nreng" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_nreng" value="<?= HtmlEncode($Grid->nreng->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tcomprel->Visible) { // tcomprel ?>
        <td data-name="tcomprel"<?= $Grid->tcomprel->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_tcomprel" class="el_detrecibo_tcomprel">
<input type="<?= $Grid->tcomprel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tcomprel" id="x<?= $Grid->RowIndex ?>_tcomprel" data-table="detrecibo" data-field="x_tcomprel" value="<?= $Grid->tcomprel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tcomprel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tcomprel->formatPattern()) ?>"<?= $Grid->tcomprel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tcomprel->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detrecibo" data-field="x_tcomprel" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tcomprel" id="o<?= $Grid->RowIndex ?>_tcomprel" value="<?= HtmlEncode($Grid->tcomprel->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_tcomprel" class="el_detrecibo_tcomprel">
<input type="<?= $Grid->tcomprel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tcomprel" id="x<?= $Grid->RowIndex ?>_tcomprel" data-table="detrecibo" data-field="x_tcomprel" value="<?= $Grid->tcomprel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tcomprel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tcomprel->formatPattern()) ?>"<?= $Grid->tcomprel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tcomprel->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_tcomprel" class="el_detrecibo_tcomprel">
<span<?= $Grid->tcomprel->viewAttributes() ?>>
<?= $Grid->tcomprel->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_tcomprel" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_tcomprel" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_tcomprel" value="<?= HtmlEncode($Grid->tcomprel->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_tcomprel" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_tcomprel" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_tcomprel" value="<?= HtmlEncode($Grid->tcomprel->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->serierel->Visible) { // serierel ?>
        <td data-name="serierel"<?= $Grid->serierel->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_serierel" class="el_detrecibo_serierel">
<input type="<?= $Grid->serierel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_serierel" id="x<?= $Grid->RowIndex ?>_serierel" data-table="detrecibo" data-field="x_serierel" value="<?= $Grid->serierel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->serierel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->serierel->formatPattern()) ?>"<?= $Grid->serierel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->serierel->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detrecibo" data-field="x_serierel" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_serierel" id="o<?= $Grid->RowIndex ?>_serierel" value="<?= HtmlEncode($Grid->serierel->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_serierel" class="el_detrecibo_serierel">
<input type="<?= $Grid->serierel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_serierel" id="x<?= $Grid->RowIndex ?>_serierel" data-table="detrecibo" data-field="x_serierel" value="<?= $Grid->serierel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->serierel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->serierel->formatPattern()) ?>"<?= $Grid->serierel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->serierel->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_serierel" class="el_detrecibo_serierel">
<span<?= $Grid->serierel->viewAttributes() ?>>
<?= $Grid->serierel->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_serierel" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_serierel" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_serierel" value="<?= HtmlEncode($Grid->serierel->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_serierel" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_serierel" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_serierel" value="<?= HtmlEncode($Grid->serierel->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ncomprel->Visible) { // ncomprel ?>
        <td data-name="ncomprel"<?= $Grid->ncomprel->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_ncomprel" class="el_detrecibo_ncomprel">
<input type="<?= $Grid->ncomprel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ncomprel" id="x<?= $Grid->RowIndex ?>_ncomprel" data-table="detrecibo" data-field="x_ncomprel" value="<?= $Grid->ncomprel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ncomprel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ncomprel->formatPattern()) ?>"<?= $Grid->ncomprel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ncomprel->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detrecibo" data-field="x_ncomprel" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ncomprel" id="o<?= $Grid->RowIndex ?>_ncomprel" value="<?= HtmlEncode($Grid->ncomprel->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_ncomprel" class="el_detrecibo_ncomprel">
<input type="<?= $Grid->ncomprel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ncomprel" id="x<?= $Grid->RowIndex ?>_ncomprel" data-table="detrecibo" data-field="x_ncomprel" value="<?= $Grid->ncomprel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->ncomprel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ncomprel->formatPattern()) ?>"<?= $Grid->ncomprel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ncomprel->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_ncomprel" class="el_detrecibo_ncomprel">
<span<?= $Grid->ncomprel->viewAttributes() ?>>
<?= $Grid->ncomprel->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_ncomprel" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_ncomprel" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_ncomprel" value="<?= HtmlEncode($Grid->ncomprel->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_ncomprel" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_ncomprel" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_ncomprel" value="<?= HtmlEncode($Grid->ncomprel->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->netocbterel->Visible) { // netocbterel ?>
        <td data-name="netocbterel"<?= $Grid->netocbterel->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_netocbterel" class="el_detrecibo_netocbterel">
<input type="<?= $Grid->netocbterel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_netocbterel" id="x<?= $Grid->RowIndex ?>_netocbterel" data-table="detrecibo" data-field="x_netocbterel" value="<?= $Grid->netocbterel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->netocbterel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->netocbterel->formatPattern()) ?>"<?= $Grid->netocbterel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->netocbterel->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detrecibo" data-field="x_netocbterel" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_netocbterel" id="o<?= $Grid->RowIndex ?>_netocbterel" value="<?= HtmlEncode($Grid->netocbterel->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_netocbterel" class="el_detrecibo_netocbterel">
<input type="<?= $Grid->netocbterel->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_netocbterel" id="x<?= $Grid->RowIndex ?>_netocbterel" data-table="detrecibo" data-field="x_netocbterel" value="<?= $Grid->netocbterel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->netocbterel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->netocbterel->formatPattern()) ?>"<?= $Grid->netocbterel->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->netocbterel->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_netocbterel" class="el_detrecibo_netocbterel">
<span<?= $Grid->netocbterel->viewAttributes() ?>>
<?= $Grid->netocbterel->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_netocbterel" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_netocbterel" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_netocbterel" value="<?= HtmlEncode($Grid->netocbterel->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_netocbterel" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_netocbterel" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_netocbterel" value="<?= HtmlEncode($Grid->netocbterel->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usuario->Visible) { // usuario ?>
        <td data-name="usuario"<?= $Grid->usuario->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_usuario" class="el_detrecibo_usuario">
<input type="<?= $Grid->usuario->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usuario" id="x<?= $Grid->RowIndex ?>_usuario" data-table="detrecibo" data-field="x_usuario" value="<?= $Grid->usuario->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->usuario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->usuario->formatPattern()) ?>"<?= $Grid->usuario->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usuario->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detrecibo" data-field="x_usuario" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_usuario" id="o<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_usuario" class="el_detrecibo_usuario">
<input type="<?= $Grid->usuario->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_usuario" id="x<?= $Grid->RowIndex ?>_usuario" data-table="detrecibo" data-field="x_usuario" value="<?= $Grid->usuario->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->usuario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->usuario->formatPattern()) ?>"<?= $Grid->usuario->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->usuario->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_usuario" class="el_detrecibo_usuario">
<span<?= $Grid->usuario->viewAttributes() ?>>
<?= $Grid->usuario->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_usuario" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_usuario" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_usuario" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_usuario" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_usuario" value="<?= HtmlEncode($Grid->usuario->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fechahora->Visible) { // fechahora ?>
        <td data-name="fechahora"<?= $Grid->fechahora->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_fechahora" class="el_detrecibo_fechahora">
<input type="<?= $Grid->fechahora->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fechahora" id="x<?= $Grid->RowIndex ?>_fechahora" data-table="detrecibo" data-field="x_fechahora" value="<?= $Grid->fechahora->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fechahora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fechahora->formatPattern()) ?>"<?= $Grid->fechahora->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechahora->getErrorMessage() ?></div>
<?php if (!$Grid->fechahora->ReadOnly && !$Grid->fechahora->Disabled && !isset($Grid->fechahora->EditAttrs["readonly"]) && !isset($Grid->fechahora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdetrecibogrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(11) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fdetrecibogrid", "x<?= $Grid->RowIndex ?>_fechahora", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="detrecibo" data-field="x_fechahora" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fechahora" id="o<?= $Grid->RowIndex ?>_fechahora" value="<?= HtmlEncode($Grid->fechahora->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_fechahora" class="el_detrecibo_fechahora">
<input type="<?= $Grid->fechahora->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fechahora" id="x<?= $Grid->RowIndex ?>_fechahora" data-table="detrecibo" data-field="x_fechahora" value="<?= $Grid->fechahora->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fechahora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fechahora->formatPattern()) ?>"<?= $Grid->fechahora->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechahora->getErrorMessage() ?></div>
<?php if (!$Grid->fechahora->ReadOnly && !$Grid->fechahora->Disabled && !isset($Grid->fechahora->EditAttrs["readonly"]) && !isset($Grid->fechahora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdetrecibogrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(11) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fdetrecibogrid", "x<?= $Grid->RowIndex ?>_fechahora", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_fechahora" class="el_detrecibo_fechahora">
<span<?= $Grid->fechahora->viewAttributes() ?>>
<?= $Grid->fechahora->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_fechahora" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_fechahora" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_fechahora" value="<?= HtmlEncode($Grid->fechahora->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_fechahora" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_fechahora" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_fechahora" value="<?= HtmlEncode($Grid->fechahora->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nrodoc->Visible) { // nrodoc ?>
        <td data-name="nrodoc"<?= $Grid->nrodoc->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_nrodoc" class="el_detrecibo_nrodoc">
<input type="<?= $Grid->nrodoc->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nrodoc" id="x<?= $Grid->RowIndex ?>_nrodoc" data-table="detrecibo" data-field="x_nrodoc" value="<?= $Grid->nrodoc->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->nrodoc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nrodoc->formatPattern()) ?>"<?= $Grid->nrodoc->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nrodoc->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detrecibo" data-field="x_nrodoc" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nrodoc" id="o<?= $Grid->RowIndex ?>_nrodoc" value="<?= HtmlEncode($Grid->nrodoc->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_nrodoc" class="el_detrecibo_nrodoc">
<input type="<?= $Grid->nrodoc->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nrodoc" id="x<?= $Grid->RowIndex ?>_nrodoc" data-table="detrecibo" data-field="x_nrodoc" value="<?= $Grid->nrodoc->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->nrodoc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nrodoc->formatPattern()) ?>"<?= $Grid->nrodoc->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nrodoc->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detrecibo_nrodoc" class="el_detrecibo_nrodoc">
<span<?= $Grid->nrodoc->viewAttributes() ?>>
<?= $Grid->nrodoc->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detrecibo" data-field="x_nrodoc" data-hidden="1" name="fdetrecibogrid$x<?= $Grid->RowIndex ?>_nrodoc" id="fdetrecibogrid$x<?= $Grid->RowIndex ?>_nrodoc" value="<?= HtmlEncode($Grid->nrodoc->FormValue) ?>">
<input type="hidden" data-table="detrecibo" data-field="x_nrodoc" data-hidden="1" data-old name="fdetrecibogrid$o<?= $Grid->RowIndex ?>_nrodoc" id="fdetrecibogrid$o<?= $Grid->RowIndex ?>_nrodoc" value="<?= HtmlEncode($Grid->nrodoc->OldValue) ?>">
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
loadjs.ready(["fdetrecibogrid","load"], () => fdetrecibogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fdetrecibogrid">
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
    ew.addEventHandlers("detrecibo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
