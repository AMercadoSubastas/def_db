<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CabfacDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabfac: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcabfacdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcabfacdelete")
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
<form name="fcabfacdelete" id="fcabfacdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cabfac">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_cabfac_codnum" class="cabfac_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><span id="elh_cabfac_tcomp" class="cabfac_tcomp"><?= $Page->tcomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><span id="elh_cabfac_serie" class="cabfac_serie"><?= $Page->serie->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><span id="elh_cabfac_ncomp" class="cabfac_ncomp"><?= $Page->ncomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecval->Visible) { // fecval ?>
        <th class="<?= $Page->fecval->headerCellClass() ?>"><span id="elh_cabfac_fecval" class="cabfac_fecval"><?= $Page->fecval->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecdoc->Visible) { // fecdoc ?>
        <th class="<?= $Page->fecdoc->headerCellClass() ?>"><span id="elh_cabfac_fecdoc" class="cabfac_fecdoc"><?= $Page->fecdoc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecreg->Visible) { // fecreg ?>
        <th class="<?= $Page->fecreg->headerCellClass() ?>"><span id="elh_cabfac_fecreg" class="cabfac_fecreg"><?= $Page->fecreg->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th class="<?= $Page->cliente->headerCellClass() ?>"><span id="elh_cabfac_cliente" class="cabfac_cliente"><?= $Page->cliente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->direc->Visible) { // direc ?>
        <th class="<?= $Page->direc->headerCellClass() ?>"><span id="elh_cabfac_direc" class="cabfac_direc"><?= $Page->direc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
        <th class="<?= $Page->dnro->headerCellClass() ?>"><span id="elh_cabfac_dnro" class="cabfac_dnro"><?= $Page->dnro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
        <th class="<?= $Page->pisodto->headerCellClass() ?>"><span id="elh_cabfac_pisodto" class="cabfac_pisodto"><?= $Page->pisodto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
        <th class="<?= $Page->codpost->headerCellClass() ?>"><span id="elh_cabfac_codpost" class="cabfac_codpost"><?= $Page->codpost->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th class="<?= $Page->codpais->headerCellClass() ?>"><span id="elh_cabfac_codpais" class="cabfac_codpais"><?= $Page->codpais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th class="<?= $Page->codprov->headerCellClass() ?>"><span id="elh_cabfac_codprov" class="cabfac_codprov"><?= $Page->codprov->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th class="<?= $Page->codloc->headerCellClass() ?>"><span id="elh_cabfac_codloc" class="cabfac_codloc"><?= $Page->codloc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telef->Visible) { // telef ?>
        <th class="<?= $Page->telef->headerCellClass() ?>"><span id="elh_cabfac_telef" class="cabfac_telef"><?= $Page->telef->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><span id="elh_cabfac_codrem" class="cabfac_codrem"><?= $Page->codrem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><span id="elh_cabfac_estado" class="cabfac_estado"><?= $Page->estado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
        <th class="<?= $Page->emitido->headerCellClass() ?>"><span id="elh_cabfac_emitido" class="cabfac_emitido"><?= $Page->emitido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
        <th class="<?= $Page->moneda->headerCellClass() ?>"><span id="elh_cabfac_moneda" class="cabfac_moneda"><?= $Page->moneda->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totneto->Visible) { // totneto ?>
        <th class="<?= $Page->totneto->headerCellClass() ?>"><span id="elh_cabfac_totneto" class="cabfac_totneto"><?= $Page->totneto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totbruto->Visible) { // totbruto ?>
        <th class="<?= $Page->totbruto->headerCellClass() ?>"><span id="elh_cabfac_totbruto" class="cabfac_totbruto"><?= $Page->totbruto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
        <th class="<?= $Page->totiva105->headerCellClass() ?>"><span id="elh_cabfac_totiva105" class="cabfac_totiva105"><?= $Page->totiva105->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
        <th class="<?= $Page->totiva21->headerCellClass() ?>"><span id="elh_cabfac_totiva21" class="cabfac_totiva21"><?= $Page->totiva21->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totimp->Visible) { // totimp ?>
        <th class="<?= $Page->totimp->headerCellClass() ?>"><span id="elh_cabfac_totimp" class="cabfac_totimp"><?= $Page->totimp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totcomis->Visible) { // totcomis ?>
        <th class="<?= $Page->totcomis->headerCellClass() ?>"><span id="elh_cabfac_totcomis" class="cabfac_totcomis"><?= $Page->totcomis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totneto105->Visible) { // totneto105 ?>
        <th class="<?= $Page->totneto105->headerCellClass() ?>"><span id="elh_cabfac_totneto105" class="cabfac_totneto105"><?= $Page->totneto105->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totneto21->Visible) { // totneto21 ?>
        <th class="<?= $Page->totneto21->headerCellClass() ?>"><span id="elh_cabfac_totneto21" class="cabfac_totneto21"><?= $Page->totneto21->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <th class="<?= $Page->tipoiva->headerCellClass() ?>"><span id="elh_cabfac_tipoiva" class="cabfac_tipoiva"><?= $Page->tipoiva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
        <th class="<?= $Page->porciva->headerCellClass() ?>"><span id="elh_cabfac_porciva" class="cabfac_porciva"><?= $Page->porciva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nrengs->Visible) { // nrengs ?>
        <th class="<?= $Page->nrengs->headerCellClass() ?>"><span id="elh_cabfac_nrengs" class="cabfac_nrengs"><?= $Page->nrengs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><span id="elh_cabfac_fechahora" class="cabfac_fechahora"><?= $Page->fechahora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_cabfac_usuario" class="cabfac_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <th class="<?= $Page->tieneresol->headerCellClass() ?>"><span id="elh_cabfac_tieneresol" class="cabfac_tieneresol"><?= $Page->tieneresol->caption() ?></span></th>
<?php } ?>
<?php if ($Page->concepto->Visible) { // concepto ?>
        <th class="<?= $Page->concepto->headerCellClass() ?>"><span id="elh_cabfac_concepto" class="cabfac_concepto"><?= $Page->concepto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <th class="<?= $Page->nrodoc->headerCellClass() ?>"><span id="elh_cabfac_nrodoc" class="cabfac_nrodoc"><?= $Page->nrodoc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
        <th class="<?= $Page->tcompsal->headerCellClass() ?>"><span id="elh_cabfac_tcompsal" class="cabfac_tcompsal"><?= $Page->tcompsal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
        <th class="<?= $Page->seriesal->headerCellClass() ?>"><span id="elh_cabfac_seriesal" class="cabfac_seriesal"><?= $Page->seriesal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <th class="<?= $Page->ncompsal->headerCellClass() ?>"><span id="elh_cabfac_ncompsal" class="cabfac_ncompsal"><?= $Page->ncompsal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->en_liquid->Visible) { // en_liquid ?>
        <th class="<?= $Page->en_liquid->headerCellClass() ?>"><span id="elh_cabfac_en_liquid" class="cabfac_en_liquid"><?= $Page->en_liquid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CAE->Visible) { // CAE ?>
        <th class="<?= $Page->CAE->headerCellClass() ?>"><span id="elh_cabfac_CAE" class="cabfac_CAE"><?= $Page->CAE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CAEFchVto->Visible) { // CAEFchVto ?>
        <th class="<?= $Page->CAEFchVto->headerCellClass() ?>"><span id="elh_cabfac_CAEFchVto" class="cabfac_CAEFchVto"><?= $Page->CAEFchVto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Resultado->Visible) { // Resultado ?>
        <th class="<?= $Page->Resultado->headerCellClass() ?>"><span id="elh_cabfac_Resultado" class="cabfac_Resultado"><?= $Page->Resultado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th class="<?= $Page->usuarioultmod->headerCellClass() ?>"><span id="elh_cabfac_usuarioultmod" class="cabfac_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th class="<?= $Page->fecultmod->headerCellClass() ?>"><span id="elh_cabfac_fecultmod" class="cabfac_fecultmod"><?= $Page->fecultmod->caption() ?></span></th>
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
<?php if ($Page->fecval->Visible) { // fecval ?>
        <td<?= $Page->fecval->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecval->viewAttributes() ?>>
<?= $Page->fecval->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecdoc->Visible) { // fecdoc ?>
        <td<?= $Page->fecdoc->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecdoc->viewAttributes() ?>>
<?= $Page->fecdoc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecreg->Visible) { // fecreg ?>
        <td<?= $Page->fecreg->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecreg->viewAttributes() ?>>
<?= $Page->fecreg->getViewValue() ?></span>
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
<?php if ($Page->direc->Visible) { // direc ?>
        <td<?= $Page->direc->cellAttributes() ?>>
<span id="">
<span<?= $Page->direc->viewAttributes() ?>>
<?= $Page->direc->getViewValue() ?></span>
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
<?php if ($Page->telef->Visible) { // telef ?>
        <td<?= $Page->telef->cellAttributes() ?>>
<span id="">
<span<?= $Page->telef->viewAttributes() ?>>
<?= $Page->telef->getViewValue() ?></span>
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
<?php if ($Page->estado->Visible) { // estado ?>
        <td<?= $Page->estado->cellAttributes() ?>>
<span id="">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
        <td<?= $Page->emitido->cellAttributes() ?>>
<span id="">
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
        <td<?= $Page->moneda->cellAttributes() ?>>
<span id="">
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totneto->Visible) { // totneto ?>
        <td<?= $Page->totneto->cellAttributes() ?>>
<span id="">
<span<?= $Page->totneto->viewAttributes() ?>>
<?= $Page->totneto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totbruto->Visible) { // totbruto ?>
        <td<?= $Page->totbruto->cellAttributes() ?>>
<span id="">
<span<?= $Page->totbruto->viewAttributes() ?>>
<?= $Page->totbruto->getViewValue() ?></span>
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
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
        <td<?= $Page->totiva21->cellAttributes() ?>>
<span id="">
<span<?= $Page->totiva21->viewAttributes() ?>>
<?= $Page->totiva21->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totimp->Visible) { // totimp ?>
        <td<?= $Page->totimp->cellAttributes() ?>>
<span id="">
<span<?= $Page->totimp->viewAttributes() ?>>
<?= $Page->totimp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totcomis->Visible) { // totcomis ?>
        <td<?= $Page->totcomis->cellAttributes() ?>>
<span id="">
<span<?= $Page->totcomis->viewAttributes() ?>>
<?= $Page->totcomis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totneto105->Visible) { // totneto105 ?>
        <td<?= $Page->totneto105->cellAttributes() ?>>
<span id="">
<span<?= $Page->totneto105->viewAttributes() ?>>
<?= $Page->totneto105->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totneto21->Visible) { // totneto21 ?>
        <td<?= $Page->totneto21->cellAttributes() ?>>
<span id="">
<span<?= $Page->totneto21->viewAttributes() ?>>
<?= $Page->totneto21->getViewValue() ?></span>
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
<?php if ($Page->porciva->Visible) { // porciva ?>
        <td<?= $Page->porciva->cellAttributes() ?>>
<span id="">
<span<?= $Page->porciva->viewAttributes() ?>>
<?= $Page->porciva->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nrengs->Visible) { // nrengs ?>
        <td<?= $Page->nrengs->cellAttributes() ?>>
<span id="">
<span<?= $Page->nrengs->viewAttributes() ?>>
<?= $Page->nrengs->getViewValue() ?></span>
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
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <td<?= $Page->tieneresol->cellAttributes() ?>>
<span id="">
<span<?= $Page->tieneresol->viewAttributes() ?>>
<?= $Page->tieneresol->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->concepto->Visible) { // concepto ?>
        <td<?= $Page->concepto->cellAttributes() ?>>
<span id="">
<span<?= $Page->concepto->viewAttributes() ?>>
<?= $Page->concepto->getViewValue() ?></span>
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
<?php if ($Page->en_liquid->Visible) { // en_liquid ?>
        <td<?= $Page->en_liquid->cellAttributes() ?>>
<span id="">
<span<?= $Page->en_liquid->viewAttributes() ?>>
<?= $Page->en_liquid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CAE->Visible) { // CAE ?>
        <td<?= $Page->CAE->cellAttributes() ?>>
<span id="">
<span<?= $Page->CAE->viewAttributes() ?>>
<?= $Page->CAE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CAEFchVto->Visible) { // CAEFchVto ?>
        <td<?= $Page->CAEFchVto->cellAttributes() ?>>
<span id="">
<span<?= $Page->CAEFchVto->viewAttributes() ?>>
<?= $Page->CAEFchVto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Resultado->Visible) { // Resultado ?>
        <td<?= $Page->Resultado->cellAttributes() ?>>
<span id="">
<span<?= $Page->Resultado->viewAttributes() ?>>
<?= $Page->Resultado->getViewValue() ?></span>
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
