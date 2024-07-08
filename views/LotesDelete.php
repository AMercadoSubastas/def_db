<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LotesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { lotes: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var flotesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flotesdelete")
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
<form name="flotesdelete" id="flotesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="lotes">
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
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><span id="elh_lotes_codrem" class="lotes_codrem"><?= $Page->codrem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
        <th class="<?= $Page->codcli->headerCellClass() ?>"><span id="elh_lotes_codcli" class="lotes_codcli"><?= $Page->codcli->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codrubro->Visible) { // codrubro ?>
        <th class="<?= $Page->codrubro->headerCellClass() ?>"><span id="elh_lotes_codrubro" class="lotes_codrubro"><?= $Page->codrubro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><span id="elh_lotes_estado" class="lotes_estado"><?= $Page->estado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
        <th class="<?= $Page->moneda->headerCellClass() ?>"><span id="elh_lotes_moneda" class="lotes_moneda"><?= $Page->moneda->caption() ?></span></th>
<?php } ?>
<?php if ($Page->preciobase->Visible) { // preciobase ?>
        <th class="<?= $Page->preciobase->headerCellClass() ?>"><span id="elh_lotes_preciobase" class="lotes_preciobase"><?= $Page->preciobase->caption() ?></span></th>
<?php } ?>
<?php if ($Page->preciofinal->Visible) { // preciofinal ?>
        <th class="<?= $Page->preciofinal->headerCellClass() ?>"><span id="elh_lotes_preciofinal" class="lotes_preciofinal"><?= $Page->preciofinal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->comiscobr->Visible) { // comiscobr ?>
        <th class="<?= $Page->comiscobr->headerCellClass() ?>"><span id="elh_lotes_comiscobr" class="lotes_comiscobr"><?= $Page->comiscobr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->comispag->Visible) { // comispag ?>
        <th class="<?= $Page->comispag->headerCellClass() ?>"><span id="elh_lotes_comispag" class="lotes_comispag"><?= $Page->comispag->caption() ?></span></th>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
        <th class="<?= $Page->comprador->headerCellClass() ?>"><span id="elh_lotes_comprador" class="lotes_comprador"><?= $Page->comprador->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ivari->Visible) { // ivari ?>
        <th class="<?= $Page->ivari->headerCellClass() ?>"><span id="elh_lotes_ivari" class="lotes_ivari"><?= $Page->ivari->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ivarni->Visible) { // ivarni ?>
        <th class="<?= $Page->ivarni->headerCellClass() ?>"><span id="elh_lotes_ivarni" class="lotes_ivarni"><?= $Page->ivarni->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codimpadic->Visible) { // codimpadic ?>
        <th class="<?= $Page->codimpadic->headerCellClass() ?>"><span id="elh_lotes_codimpadic" class="lotes_codimpadic"><?= $Page->codimpadic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->impadic->Visible) { // impadic ?>
        <th class="<?= $Page->impadic->headerCellClass() ?>"><span id="elh_lotes_impadic" class="lotes_impadic"><?= $Page->impadic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descor->Visible) { // descor ?>
        <th class="<?= $Page->descor->headerCellClass() ?>"><span id="elh_lotes_descor" class="lotes_descor"><?= $Page->descor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->observ->Visible) { // observ ?>
        <th class="<?= $Page->observ->headerCellClass() ?>"><span id="elh_lotes_observ" class="lotes_observ"><?= $Page->observ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_lotes_usuario" class="lotes_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <th class="<?= $Page->fecalta->headerCellClass() ?>"><span id="elh_lotes_fecalta" class="lotes_fecalta"><?= $Page->fecalta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <th class="<?= $Page->secuencia->headerCellClass() ?>"><span id="elh_lotes_secuencia" class="lotes_secuencia"><?= $Page->secuencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codintlote->Visible) { // codintlote ?>
        <th class="<?= $Page->codintlote->headerCellClass() ?>"><span id="elh_lotes_codintlote" class="lotes_codintlote"><?= $Page->codintlote->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codintnum->Visible) { // codintnum ?>
        <th class="<?= $Page->codintnum->headerCellClass() ?>"><span id="elh_lotes_codintnum" class="lotes_codintnum"><?= $Page->codintnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codintsublote->Visible) { // codintsublote ?>
        <th class="<?= $Page->codintsublote->headerCellClass() ?>"><span id="elh_lotes_codintsublote" class="lotes_codintsublote"><?= $Page->codintsublote->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th class="<?= $Page->usuarioultmod->headerCellClass() ?>"><span id="elh_lotes_usuarioultmod" class="lotes_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th class="<?= $Page->fecultmod->headerCellClass() ?>"><span id="elh_lotes_fecultmod" class="lotes_fecultmod"><?= $Page->fecultmod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dir_secuencia->Visible) { // dir_secuencia ?>
        <th class="<?= $Page->dir_secuencia->headerCellClass() ?>"><span id="elh_lotes_dir_secuencia" class="lotes_dir_secuencia"><?= $Page->dir_secuencia->caption() ?></span></th>
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
<?php if ($Page->codrem->Visible) { // codrem ?>
        <td<?= $Page->codrem->cellAttributes() ?>>
<span id="">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
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
<?php if ($Page->codrubro->Visible) { // codrubro ?>
        <td<?= $Page->codrubro->cellAttributes() ?>>
<span id="">
<span<?= $Page->codrubro->viewAttributes() ?>>
<?= $Page->codrubro->getViewValue() ?></span>
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
<?php if ($Page->moneda->Visible) { // moneda ?>
        <td<?= $Page->moneda->cellAttributes() ?>>
<span id="">
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->preciobase->Visible) { // preciobase ?>
        <td<?= $Page->preciobase->cellAttributes() ?>>
<span id="">
<span<?= $Page->preciobase->viewAttributes() ?>>
<?= $Page->preciobase->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->preciofinal->Visible) { // preciofinal ?>
        <td<?= $Page->preciofinal->cellAttributes() ?>>
<span id="">
<span<?= $Page->preciofinal->viewAttributes() ?>>
<?= $Page->preciofinal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->comiscobr->Visible) { // comiscobr ?>
        <td<?= $Page->comiscobr->cellAttributes() ?>>
<span id="">
<span<?= $Page->comiscobr->viewAttributes() ?>>
<?= $Page->comiscobr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->comispag->Visible) { // comispag ?>
        <td<?= $Page->comispag->cellAttributes() ?>>
<span id="">
<span<?= $Page->comispag->viewAttributes() ?>>
<?= $Page->comispag->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
        <td<?= $Page->comprador->cellAttributes() ?>>
<span id="">
<span<?= $Page->comprador->viewAttributes() ?>>
<?= $Page->comprador->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ivari->Visible) { // ivari ?>
        <td<?= $Page->ivari->cellAttributes() ?>>
<span id="">
<span<?= $Page->ivari->viewAttributes() ?>>
<?= $Page->ivari->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ivarni->Visible) { // ivarni ?>
        <td<?= $Page->ivarni->cellAttributes() ?>>
<span id="">
<span<?= $Page->ivarni->viewAttributes() ?>>
<?= $Page->ivarni->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codimpadic->Visible) { // codimpadic ?>
        <td<?= $Page->codimpadic->cellAttributes() ?>>
<span id="">
<span<?= $Page->codimpadic->viewAttributes() ?>>
<?= $Page->codimpadic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->impadic->Visible) { // impadic ?>
        <td<?= $Page->impadic->cellAttributes() ?>>
<span id="">
<span<?= $Page->impadic->viewAttributes() ?>>
<?= $Page->impadic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descor->Visible) { // descor ?>
        <td<?= $Page->descor->cellAttributes() ?>>
<span id="">
<span<?= $Page->descor->viewAttributes() ?>>
<?= $Page->descor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->observ->Visible) { // observ ?>
        <td<?= $Page->observ->cellAttributes() ?>>
<span id="">
<span<?= $Page->observ->viewAttributes() ?>>
<?= $Page->observ->getViewValue() ?></span>
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
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <td<?= $Page->secuencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codintlote->Visible) { // codintlote ?>
        <td<?= $Page->codintlote->cellAttributes() ?>>
<span id="">
<span<?= $Page->codintlote->viewAttributes() ?>>
<?= $Page->codintlote->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codintnum->Visible) { // codintnum ?>
        <td<?= $Page->codintnum->cellAttributes() ?>>
<span id="">
<span<?= $Page->codintnum->viewAttributes() ?>>
<?= $Page->codintnum->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codintsublote->Visible) { // codintsublote ?>
        <td<?= $Page->codintsublote->cellAttributes() ?>>
<span id="">
<span<?= $Page->codintsublote->viewAttributes() ?>>
<?= $Page->codintsublote->getViewValue() ?></span>
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
<?php if ($Page->dir_secuencia->Visible) { // dir_secuencia ?>
        <td<?= $Page->dir_secuencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->dir_secuencia->viewAttributes() ?>>
<?= $Page->dir_secuencia->getViewValue() ?></span>
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
