<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LiquidacionDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { liquidacion: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fliquidaciondelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fliquidaciondelete")
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
<form name="fliquidaciondelete" id="fliquidaciondelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="liquidacion">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_liquidacion_codnum" class="liquidacion_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><span id="elh_liquidacion_tcomp" class="liquidacion_tcomp"><?= $Page->tcomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><span id="elh_liquidacion_serie" class="liquidacion_serie"><?= $Page->serie->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><span id="elh_liquidacion_ncomp" class="liquidacion_ncomp"><?= $Page->ncomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th class="<?= $Page->cliente->headerCellClass() ?>"><span id="elh_liquidacion_cliente" class="liquidacion_cliente"><?= $Page->cliente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rubro->Visible) { // rubro ?>
        <th class="<?= $Page->rubro->headerCellClass() ?>"><span id="elh_liquidacion_rubro" class="liquidacion_rubro"><?= $Page->rubro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
        <th class="<?= $Page->calle->headerCellClass() ?>"><span id="elh_liquidacion_calle" class="liquidacion_calle"><?= $Page->calle->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
        <th class="<?= $Page->dnro->headerCellClass() ?>"><span id="elh_liquidacion_dnro" class="liquidacion_dnro"><?= $Page->dnro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
        <th class="<?= $Page->pisodto->headerCellClass() ?>"><span id="elh_liquidacion_pisodto" class="liquidacion_pisodto"><?= $Page->pisodto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
        <th class="<?= $Page->codpost->headerCellClass() ?>"><span id="elh_liquidacion_codpost" class="liquidacion_codpost"><?= $Page->codpost->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th class="<?= $Page->codpais->headerCellClass() ?>"><span id="elh_liquidacion_codpais" class="liquidacion_codpais"><?= $Page->codpais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th class="<?= $Page->codprov->headerCellClass() ?>"><span id="elh_liquidacion_codprov" class="liquidacion_codprov"><?= $Page->codprov->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th class="<?= $Page->codloc->headerCellClass() ?>"><span id="elh_liquidacion_codloc" class="liquidacion_codloc"><?= $Page->codloc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><span id="elh_liquidacion_codrem" class="liquidacion_codrem"><?= $Page->codrem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecharem->Visible) { // fecharem ?>
        <th class="<?= $Page->fecharem->headerCellClass() ?>"><span id="elh_liquidacion_fecharem" class="liquidacion_fecharem"><?= $Page->fecharem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
        <th class="<?= $Page->cuit->headerCellClass() ?>"><span id="elh_liquidacion_cuit" class="liquidacion_cuit"><?= $Page->cuit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <th class="<?= $Page->tipoiva->headerCellClass() ?>"><span id="elh_liquidacion_tipoiva" class="liquidacion_tipoiva"><?= $Page->tipoiva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totremate->Visible) { // totremate ?>
        <th class="<?= $Page->totremate->headerCellClass() ?>"><span id="elh_liquidacion_totremate" class="liquidacion_totremate"><?= $Page->totremate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totneto1->Visible) { // totneto1 ?>
        <th class="<?= $Page->totneto1->headerCellClass() ?>"><span id="elh_liquidacion_totneto1" class="liquidacion_totneto1"><?= $Page->totneto1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
        <th class="<?= $Page->totiva21->headerCellClass() ?>"><span id="elh_liquidacion_totiva21" class="liquidacion_totiva21"><?= $Page->totiva21->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subtot1->Visible) { // subtot1 ?>
        <th class="<?= $Page->subtot1->headerCellClass() ?>"><span id="elh_liquidacion_subtot1" class="liquidacion_subtot1"><?= $Page->subtot1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totneto2->Visible) { // totneto2 ?>
        <th class="<?= $Page->totneto2->headerCellClass() ?>"><span id="elh_liquidacion_totneto2" class="liquidacion_totneto2"><?= $Page->totneto2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
        <th class="<?= $Page->totiva105->headerCellClass() ?>"><span id="elh_liquidacion_totiva105" class="liquidacion_totiva105"><?= $Page->totiva105->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subtot2->Visible) { // subtot2 ?>
        <th class="<?= $Page->subtot2->headerCellClass() ?>"><span id="elh_liquidacion_subtot2" class="liquidacion_subtot2"><?= $Page->subtot2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totacuenta->Visible) { // totacuenta ?>
        <th class="<?= $Page->totacuenta->headerCellClass() ?>"><span id="elh_liquidacion_totacuenta" class="liquidacion_totacuenta"><?= $Page->totacuenta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totgastos->Visible) { // totgastos ?>
        <th class="<?= $Page->totgastos->headerCellClass() ?>"><span id="elh_liquidacion_totgastos" class="liquidacion_totgastos"><?= $Page->totgastos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totvarios->Visible) { // totvarios ?>
        <th class="<?= $Page->totvarios->headerCellClass() ?>"><span id="elh_liquidacion_totvarios" class="liquidacion_totvarios"><?= $Page->totvarios->caption() ?></span></th>
<?php } ?>
<?php if ($Page->saldoafav->Visible) { // saldoafav ?>
        <th class="<?= $Page->saldoafav->headerCellClass() ?>"><span id="elh_liquidacion_saldoafav" class="liquidacion_saldoafav"><?= $Page->saldoafav->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><span id="elh_liquidacion_fechahora" class="liquidacion_fechahora"><?= $Page->fechahora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_liquidacion_usuario" class="liquidacion_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaliq->Visible) { // fechaliq ?>
        <th class="<?= $Page->fechaliq->headerCellClass() ?>"><span id="elh_liquidacion_fechaliq" class="liquidacion_fechaliq"><?= $Page->fechaliq->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><span id="elh_liquidacion_estado" class="liquidacion_estado"><?= $Page->estado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <th class="<?= $Page->nrodoc->headerCellClass() ?>"><span id="elh_liquidacion_nrodoc" class="liquidacion_nrodoc"><?= $Page->nrodoc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
        <th class="<?= $Page->cotiz->headerCellClass() ?>"><span id="elh_liquidacion_cotiz" class="liquidacion_cotiz"><?= $Page->cotiz->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th class="<?= $Page->usuarioultmod->headerCellClass() ?>"><span id="elh_liquidacion_usuarioultmod" class="liquidacion_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th class="<?= $Page->fecultmod->headerCellClass() ?>"><span id="elh_liquidacion_fecultmod" class="liquidacion_fecultmod"><?= $Page->fecultmod->caption() ?></span></th>
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
<?php if ($Page->cliente->Visible) { // cliente ?>
        <td<?= $Page->cliente->cellAttributes() ?>>
<span id="">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rubro->Visible) { // rubro ?>
        <td<?= $Page->rubro->cellAttributes() ?>>
<span id="">
<span<?= $Page->rubro->viewAttributes() ?>>
<?= $Page->rubro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
        <td<?= $Page->calle->cellAttributes() ?>>
<span id="">
<span<?= $Page->calle->viewAttributes() ?>>
<?= $Page->calle->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
        <td<?= $Page->dnro->cellAttributes() ?>>
<span id="">
<span<?= $Page->dnro->viewAttributes() ?>>
<?= $Page->dnro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
        <td<?= $Page->pisodto->cellAttributes() ?>>
<span id="">
<span<?= $Page->pisodto->viewAttributes() ?>>
<?= $Page->pisodto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
        <td<?= $Page->codpost->cellAttributes() ?>>
<span id="">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
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
<?php if ($Page->codrem->Visible) { // codrem ?>
        <td<?= $Page->codrem->cellAttributes() ?>>
<span id="">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecharem->Visible) { // fecharem ?>
        <td<?= $Page->fecharem->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecharem->viewAttributes() ?>>
<?= $Page->fecharem->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
        <td<?= $Page->cuit->cellAttributes() ?>>
<span id="">
<span<?= $Page->cuit->viewAttributes() ?>>
<?= $Page->cuit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <td<?= $Page->tipoiva->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totremate->Visible) { // totremate ?>
        <td<?= $Page->totremate->cellAttributes() ?>>
<span id="">
<span<?= $Page->totremate->viewAttributes() ?>>
<?= $Page->totremate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totneto1->Visible) { // totneto1 ?>
        <td<?= $Page->totneto1->cellAttributes() ?>>
<span id="">
<span<?= $Page->totneto1->viewAttributes() ?>>
<?= $Page->totneto1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
        <td<?= $Page->totiva21->cellAttributes() ?>>
<span id="">
<span<?= $Page->totiva21->viewAttributes() ?>>
<?= $Page->totiva21->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subtot1->Visible) { // subtot1 ?>
        <td<?= $Page->subtot1->cellAttributes() ?>>
<span id="">
<span<?= $Page->subtot1->viewAttributes() ?>>
<?= $Page->subtot1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totneto2->Visible) { // totneto2 ?>
        <td<?= $Page->totneto2->cellAttributes() ?>>
<span id="">
<span<?= $Page->totneto2->viewAttributes() ?>>
<?= $Page->totneto2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
        <td<?= $Page->totiva105->cellAttributes() ?>>
<span id="">
<span<?= $Page->totiva105->viewAttributes() ?>>
<?= $Page->totiva105->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subtot2->Visible) { // subtot2 ?>
        <td<?= $Page->subtot2->cellAttributes() ?>>
<span id="">
<span<?= $Page->subtot2->viewAttributes() ?>>
<?= $Page->subtot2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totacuenta->Visible) { // totacuenta ?>
        <td<?= $Page->totacuenta->cellAttributes() ?>>
<span id="">
<span<?= $Page->totacuenta->viewAttributes() ?>>
<?= $Page->totacuenta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totgastos->Visible) { // totgastos ?>
        <td<?= $Page->totgastos->cellAttributes() ?>>
<span id="">
<span<?= $Page->totgastos->viewAttributes() ?>>
<?= $Page->totgastos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totvarios->Visible) { // totvarios ?>
        <td<?= $Page->totvarios->cellAttributes() ?>>
<span id="">
<span<?= $Page->totvarios->viewAttributes() ?>>
<?= $Page->totvarios->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->saldoafav->Visible) { // saldoafav ?>
        <td<?= $Page->saldoafav->cellAttributes() ?>>
<span id="">
<span<?= $Page->saldoafav->viewAttributes() ?>>
<?= $Page->saldoafav->getViewValue() ?></span>
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
<?php if ($Page->fechaliq->Visible) { // fechaliq ?>
        <td<?= $Page->fechaliq->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechaliq->viewAttributes() ?>>
<?= $Page->fechaliq->getViewValue() ?></span>
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
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <td<?= $Page->nrodoc->cellAttributes() ?>>
<span id="">
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
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
