<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CartvaloresDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cartvalores: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcartvaloresdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcartvaloresdelete")
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
<form name="fcartvaloresdelete" id="fcartvaloresdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cartvalores">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_cartvalores_codnum" class="cartvalores_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><span id="elh_cartvalores_tcomp" class="cartvalores_tcomp"><?= $Page->tcomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><span id="elh_cartvalores_serie" class="cartvalores_serie"><?= $Page->serie->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><span id="elh_cartvalores_ncomp" class="cartvalores_ncomp"><?= $Page->ncomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codban->Visible) { // codban ?>
        <th class="<?= $Page->codban->headerCellClass() ?>"><span id="elh_cartvalores_codban" class="cartvalores_codban"><?= $Page->codban->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codsuc->Visible) { // codsuc ?>
        <th class="<?= $Page->codsuc->headerCellClass() ?>"><span id="elh_cartvalores_codsuc" class="cartvalores_codsuc"><?= $Page->codsuc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codcta->Visible) { // codcta ?>
        <th class="<?= $Page->codcta->headerCellClass() ?>"><span id="elh_cartvalores_codcta" class="cartvalores_codcta"><?= $Page->codcta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipcta->Visible) { // tipcta ?>
        <th class="<?= $Page->tipcta->headerCellClass() ?>"><span id="elh_cartvalores_tipcta" class="cartvalores_tipcta"><?= $Page->tipcta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codchq->Visible) { // codchq ?>
        <th class="<?= $Page->codchq->headerCellClass() ?>"><span id="elh_cartvalores_codchq" class="cartvalores_codchq"><?= $Page->codchq->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th class="<?= $Page->codpais->headerCellClass() ?>"><span id="elh_cartvalores_codpais" class="cartvalores_codpais"><?= $Page->codpais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->importe->Visible) { // importe ?>
        <th class="<?= $Page->importe->headerCellClass() ?>"><span id="elh_cartvalores_importe" class="cartvalores_importe"><?= $Page->importe->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaemis->Visible) { // fechaemis ?>
        <th class="<?= $Page->fechaemis->headerCellClass() ?>"><span id="elh_cartvalores_fechaemis" class="cartvalores_fechaemis"><?= $Page->fechaemis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechapago->Visible) { // fechapago ?>
        <th class="<?= $Page->fechapago->headerCellClass() ?>"><span id="elh_cartvalores_fechapago" class="cartvalores_fechapago"><?= $Page->fechapago->caption() ?></span></th>
<?php } ?>
<?php if ($Page->entrego->Visible) { // entrego ?>
        <th class="<?= $Page->entrego->headerCellClass() ?>"><span id="elh_cartvalores_entrego" class="cartvalores_entrego"><?= $Page->entrego->caption() ?></span></th>
<?php } ?>
<?php if ($Page->recibio->Visible) { // recibio ?>
        <th class="<?= $Page->recibio->headerCellClass() ?>"><span id="elh_cartvalores_recibio" class="cartvalores_recibio"><?= $Page->recibio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaingr->Visible) { // fechaingr ?>
        <th class="<?= $Page->fechaingr->headerCellClass() ?>"><span id="elh_cartvalores_fechaingr" class="cartvalores_fechaingr"><?= $Page->fechaingr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaentrega->Visible) { // fechaentrega ?>
        <th class="<?= $Page->fechaentrega->headerCellClass() ?>"><span id="elh_cartvalores_fechaentrega" class="cartvalores_fechaentrega"><?= $Page->fechaentrega->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <th class="<?= $Page->tcomprel->headerCellClass() ?>"><span id="elh_cartvalores_tcomprel" class="cartvalores_tcomprel"><?= $Page->tcomprel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
        <th class="<?= $Page->serierel->headerCellClass() ?>"><span id="elh_cartvalores_serierel" class="cartvalores_serierel"><?= $Page->serierel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <th class="<?= $Page->ncomprel->headerCellClass() ?>"><span id="elh_cartvalores_ncomprel" class="cartvalores_ncomprel"><?= $Page->ncomprel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><span id="elh_cartvalores_estado" class="cartvalores_estado"><?= $Page->estado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
        <th class="<?= $Page->moneda->headerCellClass() ?>"><span id="elh_cartvalores_moneda" class="cartvalores_moneda"><?= $Page->moneda->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><span id="elh_cartvalores_fechahora" class="cartvalores_fechahora"><?= $Page->fechahora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_cartvalores_usuario" class="cartvalores_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
        <th class="<?= $Page->tcompsal->headerCellClass() ?>"><span id="elh_cartvalores_tcompsal" class="cartvalores_tcompsal"><?= $Page->tcompsal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
        <th class="<?= $Page->seriesal->headerCellClass() ?>"><span id="elh_cartvalores_seriesal" class="cartvalores_seriesal"><?= $Page->seriesal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <th class="<?= $Page->ncompsal->headerCellClass() ?>"><span id="elh_cartvalores_ncompsal" class="cartvalores_ncompsal"><?= $Page->ncompsal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><span id="elh_cartvalores_codrem" class="cartvalores_codrem"><?= $Page->codrem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
        <th class="<?= $Page->cotiz->headerCellClass() ?>"><span id="elh_cartvalores_cotiz" class="cartvalores_cotiz"><?= $Page->cotiz->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usurel->Visible) { // usurel ?>
        <th class="<?= $Page->usurel->headerCellClass() ?>"><span id="elh_cartvalores_usurel" class="cartvalores_usurel"><?= $Page->usurel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecharel->Visible) { // fecharel ?>
        <th class="<?= $Page->fecharel->headerCellClass() ?>"><span id="elh_cartvalores_fecharel" class="cartvalores_fecharel"><?= $Page->fecharel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ususal->Visible) { // ususal ?>
        <th class="<?= $Page->ususal->headerCellClass() ?>"><span id="elh_cartvalores_ususal" class="cartvalores_ususal"><?= $Page->ususal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechasal->Visible) { // fechasal ?>
        <th class="<?= $Page->fechasal->headerCellClass() ?>"><span id="elh_cartvalores_fechasal" class="cartvalores_fechasal"><?= $Page->fechasal->caption() ?></span></th>
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
<?php if ($Page->codban->Visible) { // codban ?>
        <td<?= $Page->codban->cellAttributes() ?>>
<span id="">
<span<?= $Page->codban->viewAttributes() ?>>
<?= $Page->codban->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codsuc->Visible) { // codsuc ?>
        <td<?= $Page->codsuc->cellAttributes() ?>>
<span id="">
<span<?= $Page->codsuc->viewAttributes() ?>>
<?= $Page->codsuc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codcta->Visible) { // codcta ?>
        <td<?= $Page->codcta->cellAttributes() ?>>
<span id="">
<span<?= $Page->codcta->viewAttributes() ?>>
<?= $Page->codcta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipcta->Visible) { // tipcta ?>
        <td<?= $Page->tipcta->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipcta->viewAttributes() ?>>
<?= $Page->tipcta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codchq->Visible) { // codchq ?>
        <td<?= $Page->codchq->cellAttributes() ?>>
<span id="">
<span<?= $Page->codchq->viewAttributes() ?>>
<?= $Page->codchq->getViewValue() ?></span>
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
<?php if ($Page->importe->Visible) { // importe ?>
        <td<?= $Page->importe->cellAttributes() ?>>
<span id="">
<span<?= $Page->importe->viewAttributes() ?>>
<?= $Page->importe->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechaemis->Visible) { // fechaemis ?>
        <td<?= $Page->fechaemis->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechaemis->viewAttributes() ?>>
<?= $Page->fechaemis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechapago->Visible) { // fechapago ?>
        <td<?= $Page->fechapago->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechapago->viewAttributes() ?>>
<?= $Page->fechapago->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->entrego->Visible) { // entrego ?>
        <td<?= $Page->entrego->cellAttributes() ?>>
<span id="">
<span<?= $Page->entrego->viewAttributes() ?>>
<?= $Page->entrego->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->recibio->Visible) { // recibio ?>
        <td<?= $Page->recibio->cellAttributes() ?>>
<span id="">
<span<?= $Page->recibio->viewAttributes() ?>>
<?= $Page->recibio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechaingr->Visible) { // fechaingr ?>
        <td<?= $Page->fechaingr->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechaingr->viewAttributes() ?>>
<?= $Page->fechaingr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechaentrega->Visible) { // fechaentrega ?>
        <td<?= $Page->fechaentrega->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechaentrega->viewAttributes() ?>>
<?= $Page->fechaentrega->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <td<?= $Page->tcomprel->cellAttributes() ?>>
<span id="">
<span<?= $Page->tcomprel->viewAttributes() ?>>
<?= $Page->tcomprel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
        <td<?= $Page->serierel->cellAttributes() ?>>
<span id="">
<span<?= $Page->serierel->viewAttributes() ?>>
<?= $Page->serierel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <td<?= $Page->ncomprel->cellAttributes() ?>>
<span id="">
<span<?= $Page->ncomprel->viewAttributes() ?>>
<?= $Page->ncomprel->getViewValue() ?></span>
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
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td<?= $Page->fechahora->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
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
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
        <td<?= $Page->tcompsal->cellAttributes() ?>>
<span id="">
<span<?= $Page->tcompsal->viewAttributes() ?>>
<?= $Page->tcompsal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
        <td<?= $Page->seriesal->cellAttributes() ?>>
<span id="">
<span<?= $Page->seriesal->viewAttributes() ?>>
<?= $Page->seriesal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <td<?= $Page->ncompsal->cellAttributes() ?>>
<span id="">
<span<?= $Page->ncompsal->viewAttributes() ?>>
<?= $Page->ncompsal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <td<?= $Page->codrem->cellAttributes() ?>>
<span id="">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
        <td<?= $Page->cotiz->cellAttributes() ?>>
<span id="">
<span<?= $Page->cotiz->viewAttributes() ?>>
<?= $Page->cotiz->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usurel->Visible) { // usurel ?>
        <td<?= $Page->usurel->cellAttributes() ?>>
<span id="">
<span<?= $Page->usurel->viewAttributes() ?>>
<?= $Page->usurel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecharel->Visible) { // fecharel ?>
        <td<?= $Page->fecharel->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecharel->viewAttributes() ?>>
<?= $Page->fecharel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ususal->Visible) { // ususal ?>
        <td<?= $Page->ususal->cellAttributes() ?>>
<span id="">
<span<?= $Page->ususal->viewAttributes() ?>>
<?= $Page->ususal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechasal->Visible) { // fechasal ?>
        <td<?= $Page->fechasal->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechasal->viewAttributes() ?>>
<?= $Page->fechasal->getViewValue() ?></span>
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
