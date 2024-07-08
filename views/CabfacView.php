<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CabfacView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<form name="fcabfacview" id="fcabfacview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabfac: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcabfacview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcabfacview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cabfac">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_cabfac_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <tr id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_tcomp"><?= $Page->tcomp->caption() ?></span></td>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_cabfac_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <tr id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_serie"><?= $Page->serie->caption() ?></span></td>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el_cabfac_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <tr id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_ncomp"><?= $Page->ncomp->caption() ?></span></td>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_cabfac_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecval->Visible) { // fecval ?>
    <tr id="r_fecval"<?= $Page->fecval->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_fecval"><?= $Page->fecval->caption() ?></span></td>
        <td data-name="fecval"<?= $Page->fecval->cellAttributes() ?>>
<span id="el_cabfac_fecval">
<span<?= $Page->fecval->viewAttributes() ?>>
<?= $Page->fecval->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecdoc->Visible) { // fecdoc ?>
    <tr id="r_fecdoc"<?= $Page->fecdoc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_fecdoc"><?= $Page->fecdoc->caption() ?></span></td>
        <td data-name="fecdoc"<?= $Page->fecdoc->cellAttributes() ?>>
<span id="el_cabfac_fecdoc">
<span<?= $Page->fecdoc->viewAttributes() ?>>
<?= $Page->fecdoc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecreg->Visible) { // fecreg ?>
    <tr id="r_fecreg"<?= $Page->fecreg->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_fecreg"><?= $Page->fecreg->caption() ?></span></td>
        <td data-name="fecreg"<?= $Page->fecreg->cellAttributes() ?>>
<span id="el_cabfac_fecreg">
<span<?= $Page->fecreg->viewAttributes() ?>>
<?= $Page->fecreg->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
    <tr id="r_cliente"<?= $Page->cliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_cliente"><?= $Page->cliente->caption() ?></span></td>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el_cabfac_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecvenc->Visible) { // fecvenc ?>
    <tr id="r_fecvenc"<?= $Page->fecvenc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_fecvenc"><?= $Page->fecvenc->caption() ?></span></td>
        <td data-name="fecvenc"<?= $Page->fecvenc->cellAttributes() ?>>
<span id="el_cabfac_fecvenc">
<span<?= $Page->fecvenc->viewAttributes() ?>>
<?= $Page->fecvenc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direc->Visible) { // direc ?>
    <tr id="r_direc"<?= $Page->direc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_direc"><?= $Page->direc->caption() ?></span></td>
        <td data-name="direc"<?= $Page->direc->cellAttributes() ?>>
<span id="el_cabfac_direc">
<span<?= $Page->direc->viewAttributes() ?>>
<?= $Page->direc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
    <tr id="r_dnro"<?= $Page->dnro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_dnro"><?= $Page->dnro->caption() ?></span></td>
        <td data-name="dnro"<?= $Page->dnro->cellAttributes() ?>>
<span id="el_cabfac_dnro">
<span<?= $Page->dnro->viewAttributes() ?>>
<?= $Page->dnro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
    <tr id="r_pisodto"<?= $Page->pisodto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_pisodto"><?= $Page->pisodto->caption() ?></span></td>
        <td data-name="pisodto"<?= $Page->pisodto->cellAttributes() ?>>
<span id="el_cabfac_pisodto">
<span<?= $Page->pisodto->viewAttributes() ?>>
<?= $Page->pisodto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
    <tr id="r_codpost"<?= $Page->codpost->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_codpost"><?= $Page->codpost->caption() ?></span></td>
        <td data-name="codpost"<?= $Page->codpost->cellAttributes() ?>>
<span id="el_cabfac_codpost">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <tr id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_codpais"><?= $Page->codpais->caption() ?></span></td>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el_cabfac_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
    <tr id="r_codprov"<?= $Page->codprov->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_codprov"><?= $Page->codprov->caption() ?></span></td>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el_cabfac_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
    <tr id="r_codloc"<?= $Page->codloc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_codloc"><?= $Page->codloc->caption() ?></span></td>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el_cabfac_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telef->Visible) { // telef ?>
    <tr id="r_telef"<?= $Page->telef->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_telef"><?= $Page->telef->caption() ?></span></td>
        <td data-name="telef"<?= $Page->telef->cellAttributes() ?>>
<span id="el_cabfac_telef">
<span<?= $Page->telef->viewAttributes() ?>>
<?= $Page->telef->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <tr id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_codrem"><?= $Page->codrem->caption() ?></span></td>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el_cabfac_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_estado"><?= $Page->estado->caption() ?></span></td>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el_cabfac_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
    <tr id="r_emitido"<?= $Page->emitido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_emitido"><?= $Page->emitido->caption() ?></span></td>
        <td data-name="emitido"<?= $Page->emitido->cellAttributes() ?>>
<span id="el_cabfac_emitido">
<span<?= $Page->emitido->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_emitido_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->emitido->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->emitido->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_emitido_<?= $Page->RowCount ?>"></label>
</div>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
    <tr id="r_moneda"<?= $Page->moneda->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_moneda"><?= $Page->moneda->caption() ?></span></td>
        <td data-name="moneda"<?= $Page->moneda->cellAttributes() ?>>
<span id="el_cabfac_moneda">
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totneto->Visible) { // totneto ?>
    <tr id="r_totneto"<?= $Page->totneto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_totneto"><?= $Page->totneto->caption() ?></span></td>
        <td data-name="totneto"<?= $Page->totneto->cellAttributes() ?>>
<span id="el_cabfac_totneto">
<span<?= $Page->totneto->viewAttributes() ?>>
<?= $Page->totneto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totbruto->Visible) { // totbruto ?>
    <tr id="r_totbruto"<?= $Page->totbruto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_totbruto"><?= $Page->totbruto->caption() ?></span></td>
        <td data-name="totbruto"<?= $Page->totbruto->cellAttributes() ?>>
<span id="el_cabfac_totbruto">
<span<?= $Page->totbruto->viewAttributes() ?>>
<?= $Page->totbruto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
    <tr id="r_totiva105"<?= $Page->totiva105->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_totiva105"><?= $Page->totiva105->caption() ?></span></td>
        <td data-name="totiva105"<?= $Page->totiva105->cellAttributes() ?>>
<span id="el_cabfac_totiva105">
<span<?= $Page->totiva105->viewAttributes() ?>>
<?= $Page->totiva105->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
    <tr id="r_totiva21"<?= $Page->totiva21->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_totiva21"><?= $Page->totiva21->caption() ?></span></td>
        <td data-name="totiva21"<?= $Page->totiva21->cellAttributes() ?>>
<span id="el_cabfac_totiva21">
<span<?= $Page->totiva21->viewAttributes() ?>>
<?= $Page->totiva21->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totimp->Visible) { // totimp ?>
    <tr id="r_totimp"<?= $Page->totimp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_totimp"><?= $Page->totimp->caption() ?></span></td>
        <td data-name="totimp"<?= $Page->totimp->cellAttributes() ?>>
<span id="el_cabfac_totimp">
<span<?= $Page->totimp->viewAttributes() ?>>
<?= $Page->totimp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totcomis->Visible) { // totcomis ?>
    <tr id="r_totcomis"<?= $Page->totcomis->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_totcomis"><?= $Page->totcomis->caption() ?></span></td>
        <td data-name="totcomis"<?= $Page->totcomis->cellAttributes() ?>>
<span id="el_cabfac_totcomis">
<span<?= $Page->totcomis->viewAttributes() ?>>
<?= $Page->totcomis->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totneto105->Visible) { // totneto105 ?>
    <tr id="r_totneto105"<?= $Page->totneto105->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_totneto105"><?= $Page->totneto105->caption() ?></span></td>
        <td data-name="totneto105"<?= $Page->totneto105->cellAttributes() ?>>
<span id="el_cabfac_totneto105">
<span<?= $Page->totneto105->viewAttributes() ?>>
<?= $Page->totneto105->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totneto21->Visible) { // totneto21 ?>
    <tr id="r_totneto21"<?= $Page->totneto21->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_totneto21"><?= $Page->totneto21->caption() ?></span></td>
        <td data-name="totneto21"<?= $Page->totneto21->cellAttributes() ?>>
<span id="el_cabfac_totneto21">
<span<?= $Page->totneto21->viewAttributes() ?>>
<?= $Page->totneto21->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
    <tr id="r_tipoiva"<?= $Page->tipoiva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_tipoiva"><?= $Page->tipoiva->caption() ?></span></td>
        <td data-name="tipoiva"<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el_cabfac_tipoiva">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
    <tr id="r_porciva"<?= $Page->porciva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_porciva"><?= $Page->porciva->caption() ?></span></td>
        <td data-name="porciva"<?= $Page->porciva->cellAttributes() ?>>
<span id="el_cabfac_porciva">
<span<?= $Page->porciva->viewAttributes() ?>>
<?= $Page->porciva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nrengs->Visible) { // nrengs ?>
    <tr id="r_nrengs"<?= $Page->nrengs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_nrengs"><?= $Page->nrengs->caption() ?></span></td>
        <td data-name="nrengs"<?= $Page->nrengs->cellAttributes() ?>>
<span id="el_cabfac_nrengs">
<span<?= $Page->nrengs->viewAttributes() ?>>
<?= $Page->nrengs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <tr id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_fechahora"><?= $Page->fechahora->caption() ?></span></td>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_cabfac_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_cabfac_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
    <tr id="r_tieneresol"<?= $Page->tieneresol->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_tieneresol"><?= $Page->tieneresol->caption() ?></span></td>
        <td data-name="tieneresol"<?= $Page->tieneresol->cellAttributes() ?>>
<span id="el_cabfac_tieneresol">
<span<?= $Page->tieneresol->viewAttributes() ?>>
<?= $Page->tieneresol->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->leyendafc->Visible) { // leyendafc ?>
    <tr id="r_leyendafc"<?= $Page->leyendafc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_leyendafc"><?= $Page->leyendafc->caption() ?></span></td>
        <td data-name="leyendafc"<?= $Page->leyendafc->cellAttributes() ?>>
<span id="el_cabfac_leyendafc">
<span<?= $Page->leyendafc->viewAttributes() ?>>
<?= $Page->leyendafc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->concepto->Visible) { // concepto ?>
    <tr id="r_concepto"<?= $Page->concepto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_concepto"><?= $Page->concepto->caption() ?></span></td>
        <td data-name="concepto"<?= $Page->concepto->cellAttributes() ?>>
<span id="el_cabfac_concepto">
<span<?= $Page->concepto->viewAttributes() ?>>
<?= $Page->concepto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
    <tr id="r_nrodoc"<?= $Page->nrodoc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_nrodoc"><?= $Page->nrodoc->caption() ?></span></td>
        <td data-name="nrodoc"<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el_cabfac_nrodoc">
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
    <tr id="r_tcompsal"<?= $Page->tcompsal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_tcompsal"><?= $Page->tcompsal->caption() ?></span></td>
        <td data-name="tcompsal"<?= $Page->tcompsal->cellAttributes() ?>>
<span id="el_cabfac_tcompsal">
<span<?= $Page->tcompsal->viewAttributes() ?>>
<?= $Page->tcompsal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
    <tr id="r_seriesal"<?= $Page->seriesal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_seriesal"><?= $Page->seriesal->caption() ?></span></td>
        <td data-name="seriesal"<?= $Page->seriesal->cellAttributes() ?>>
<span id="el_cabfac_seriesal">
<span<?= $Page->seriesal->viewAttributes() ?>>
<?= $Page->seriesal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
    <tr id="r_ncompsal"<?= $Page->ncompsal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_ncompsal"><?= $Page->ncompsal->caption() ?></span></td>
        <td data-name="ncompsal"<?= $Page->ncompsal->cellAttributes() ?>>
<span id="el_cabfac_ncompsal">
<span<?= $Page->ncompsal->viewAttributes() ?>>
<?= $Page->ncompsal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->en_liquid->Visible) { // en_liquid ?>
    <tr id="r_en_liquid"<?= $Page->en_liquid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_en_liquid"><?= $Page->en_liquid->caption() ?></span></td>
        <td data-name="en_liquid"<?= $Page->en_liquid->cellAttributes() ?>>
<span id="el_cabfac_en_liquid">
<span<?= $Page->en_liquid->viewAttributes() ?>>
<?= $Page->en_liquid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CAE->Visible) { // CAE ?>
    <tr id="r_CAE"<?= $Page->CAE->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_CAE"><?= $Page->CAE->caption() ?></span></td>
        <td data-name="CAE"<?= $Page->CAE->cellAttributes() ?>>
<span id="el_cabfac_CAE">
<span<?= $Page->CAE->viewAttributes() ?>>
<?= $Page->CAE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CAEFchVto->Visible) { // CAEFchVto ?>
    <tr id="r_CAEFchVto"<?= $Page->CAEFchVto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_CAEFchVto"><?= $Page->CAEFchVto->caption() ?></span></td>
        <td data-name="CAEFchVto"<?= $Page->CAEFchVto->cellAttributes() ?>>
<span id="el_cabfac_CAEFchVto">
<span<?= $Page->CAEFchVto->viewAttributes() ?>>
<?= $Page->CAEFchVto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Resultado->Visible) { // Resultado ?>
    <tr id="r_Resultado"<?= $Page->Resultado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_Resultado"><?= $Page->Resultado->caption() ?></span></td>
        <td data-name="Resultado"<?= $Page->Resultado->cellAttributes() ?>>
<span id="el_cabfac_Resultado">
<span<?= $Page->Resultado->viewAttributes() ?>>
<?= $Page->Resultado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
    <tr id="r_usuarioultmod"<?= $Page->usuarioultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></td>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el_cabfac_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
    <tr id="r_fecultmod"<?= $Page->fecultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cabfac_fecultmod"><?= $Page->fecultmod->caption() ?></span></td>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el_cabfac_fecultmod">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("detfac", explode(",", $Page->getCurrentDetailTable())) && $detfac->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detfac", "TblCaption") ?>&nbsp;<?= str_replace("%s", "white", str_replace("%c", Container("detfac")->Count, $Language->phrase("DetailCount"))) ?></h4>
<?php } ?>
<?php include_once "DetfacGrid.php" ?>
<?php } ?>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
