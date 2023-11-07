<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$RematesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { remates: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var frematesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frematesdelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="frematesdelete" id="frematesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="remates">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->codnum->Visible) { // codnum ?>
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_remates_codnum" class="remates_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><span id="elh_remates_tcomp" class="remates_tcomp"><?= $Page->tcomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><span id="elh_remates_serie" class="remates_serie"><?= $Page->serie->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><span id="elh_remates_ncomp" class="remates_ncomp"><?= $Page->ncomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
        <th class="<?= $Page->codcli->headerCellClass() ?>"><span id="elh_remates_codcli" class="remates_codcli"><?= $Page->codcli->caption() ?></span></th>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
        <th class="<?= $Page->direccion->headerCellClass() ?>"><span id="elh_remates_direccion" class="remates_direccion"><?= $Page->direccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th class="<?= $Page->codpais->headerCellClass() ?>"><span id="elh_remates_codpais" class="remates_codpais"><?= $Page->codpais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th class="<?= $Page->codprov->headerCellClass() ?>"><span id="elh_remates_codprov" class="remates_codprov"><?= $Page->codprov->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th class="<?= $Page->codloc->headerCellClass() ?>"><span id="elh_remates_codloc" class="remates_codloc"><?= $Page->codloc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecest->Visible) { // fecest ?>
        <th class="<?= $Page->fecest->headerCellClass() ?>"><span id="elh_remates_fecest" class="remates_fecest"><?= $Page->fecest->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecreal->Visible) { // fecreal ?>
        <th class="<?= $Page->fecreal->headerCellClass() ?>"><span id="elh_remates_fecreal" class="remates_fecreal"><?= $Page->fecreal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->imptot->Visible) { // imptot ?>
        <th class="<?= $Page->imptot->headerCellClass() ?>"><span id="elh_remates_imptot" class="remates_imptot"><?= $Page->imptot->caption() ?></span></th>
<?php } ?>
<?php if ($Page->impbase->Visible) { // impbase ?>
        <th class="<?= $Page->impbase->headerCellClass() ?>"><span id="elh_remates_impbase" class="remates_impbase"><?= $Page->impbase->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><span id="elh_remates_estado" class="remates_estado"><?= $Page->estado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cantlotes->Visible) { // cantlotes ?>
        <th class="<?= $Page->cantlotes->headerCellClass() ?>"><span id="elh_remates_cantlotes" class="remates_cantlotes"><?= $Page->cantlotes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->horaest->Visible) { // horaest ?>
        <th class="<?= $Page->horaest->headerCellClass() ?>"><span id="elh_remates_horaest" class="remates_horaest"><?= $Page->horaest->caption() ?></span></th>
<?php } ?>
<?php if ($Page->horareal->Visible) { // horareal ?>
        <th class="<?= $Page->horareal->headerCellClass() ?>"><span id="elh_remates_horareal" class="remates_horareal"><?= $Page->horareal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_remates_usuario" class="remates_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <th class="<?= $Page->fecalta->headerCellClass() ?>"><span id="elh_remates_fecalta" class="remates_fecalta"><?= $Page->fecalta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
        <th class="<?= $Page->tipoind->headerCellClass() ?>"><span id="elh_remates_tipoind" class="remates_tipoind"><?= $Page->tipoind->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sello->Visible) { // sello ?>
        <th class="<?= $Page->sello->headerCellClass() ?>"><span id="elh_remates_sello" class="remates_sello"><?= $Page->sello->caption() ?></span></th>
<?php } ?>
<?php if ($Page->plazoSAP->Visible) { // plazoSAP ?>
        <th class="<?= $Page->plazoSAP->headerCellClass() ?>"><span id="elh_remates_plazoSAP" class="remates_plazoSAP"><?= $Page->plazoSAP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th class="<?= $Page->usuarioultmod->headerCellClass() ?>"><span id="elh_remates_usuarioultmod" class="remates_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th class="<?= $Page->fecultmod->headerCellClass() ?>"><span id="elh_remates_fecultmod" class="remates_fecultmod"><?= $Page->fecultmod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->servicios->Visible) { // servicios ?>
        <th class="<?= $Page->servicios->headerCellClass() ?>"><span id="elh_remates_servicios" class="remates_servicios"><?= $Page->servicios->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gastos->Visible) { // gastos ?>
        <th class="<?= $Page->gastos->headerCellClass() ?>"><span id="elh_remates_gastos" class="remates_gastos"><?= $Page->gastos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
        <th class="<?= $Page->tasa->headerCellClass() ?>"><span id="elh_remates_tasa" class="remates_tasa"><?= $Page->tasa->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->codnum->Visible) { // codnum ?>
        <td<?= $Page->codnum->cellAttributes() ?>>
<span id="">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td<?= $Page->tcomp->cellAttributes() ?>>
<span id="">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <td<?= $Page->serie->cellAttributes() ?>>
<span id="">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td<?= $Page->ncomp->cellAttributes() ?>>
<span id="">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
        <td<?= $Page->codcli->cellAttributes() ?>>
<span id="">
<span<?= $Page->codcli->viewAttributes() ?>>
<?= $Page->codcli->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
        <td<?= $Page->direccion->cellAttributes() ?>>
<span id="">
<span<?= $Page->direccion->viewAttributes() ?>>
<?= $Page->direccion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <td<?= $Page->codpais->cellAttributes() ?>>
<span id="">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <td<?= $Page->codprov->cellAttributes() ?>>
<span id="">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <td<?= $Page->codloc->cellAttributes() ?>>
<span id="">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecest->Visible) { // fecest ?>
        <td<?= $Page->fecest->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecest->viewAttributes() ?>>
<?= $Page->fecest->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecreal->Visible) { // fecreal ?>
        <td<?= $Page->fecreal->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecreal->viewAttributes() ?>>
<?= $Page->fecreal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->imptot->Visible) { // imptot ?>
        <td<?= $Page->imptot->cellAttributes() ?>>
<span id="">
<span<?= $Page->imptot->viewAttributes() ?>>
<?= $Page->imptot->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->impbase->Visible) { // impbase ?>
        <td<?= $Page->impbase->cellAttributes() ?>>
<span id="">
<span<?= $Page->impbase->viewAttributes() ?>>
<?= $Page->impbase->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <td<?= $Page->estado->cellAttributes() ?>>
<span id="">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cantlotes->Visible) { // cantlotes ?>
        <td<?= $Page->cantlotes->cellAttributes() ?>>
<span id="">
<span<?= $Page->cantlotes->viewAttributes() ?>>
<?= $Page->cantlotes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->horaest->Visible) { // horaest ?>
        <td<?= $Page->horaest->cellAttributes() ?>>
<span id="">
<span<?= $Page->horaest->viewAttributes() ?>>
<?= $Page->horaest->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->horareal->Visible) { // horareal ?>
        <td<?= $Page->horareal->cellAttributes() ?>>
<span id="">
<span<?= $Page->horareal->viewAttributes() ?>>
<?= $Page->horareal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <td<?= $Page->usuario->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <td<?= $Page->fecalta->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
        <td<?= $Page->tipoind->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipoind->viewAttributes() ?>>
<?= $Page->tipoind->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sello->Visible) { // sello ?>
        <td<?= $Page->sello->cellAttributes() ?>>
<span id="">
<span<?= $Page->sello->viewAttributes() ?>>
<?= $Page->sello->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->plazoSAP->Visible) { // plazoSAP ?>
        <td<?= $Page->plazoSAP->cellAttributes() ?>>
<span id="">
<span<?= $Page->plazoSAP->viewAttributes() ?>>
<?= $Page->plazoSAP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <td<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <td<?= $Page->fecultmod->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->servicios->Visible) { // servicios ?>
        <td<?= $Page->servicios->cellAttributes() ?>>
<span id="">
<span<?= $Page->servicios->viewAttributes() ?>>
<?= $Page->servicios->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gastos->Visible) { // gastos ?>
        <td<?= $Page->gastos->cellAttributes() ?>>
<span id="">
<span<?= $Page->gastos->viewAttributes() ?>>
<?= $Page->gastos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
        <td<?= $Page->tasa->cellAttributes() ?>>
<span id="">
<span<?= $Page->tasa->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($Page->tasa->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
