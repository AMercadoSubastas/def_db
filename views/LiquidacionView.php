<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LiquidacionView = &$Page;
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
<form name="fliquidacionview" id="fliquidacionview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { liquidacion: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fliquidacionview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fliquidacionview")
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
<input type="hidden" name="t" value="liquidacion">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_liquidacion_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <tr id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_tcomp"><?= $Page->tcomp->caption() ?></span></td>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_liquidacion_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <tr id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_serie"><?= $Page->serie->caption() ?></span></td>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el_liquidacion_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <tr id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_ncomp"><?= $Page->ncomp->caption() ?></span></td>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_liquidacion_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
    <tr id="r_cliente"<?= $Page->cliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_cliente"><?= $Page->cliente->caption() ?></span></td>
        <td data-name="cliente"<?= $Page->cliente->cellAttributes() ?>>
<span id="el_liquidacion_cliente">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rubro->Visible) { // rubro ?>
    <tr id="r_rubro"<?= $Page->rubro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_rubro"><?= $Page->rubro->caption() ?></span></td>
        <td data-name="rubro"<?= $Page->rubro->cellAttributes() ?>>
<span id="el_liquidacion_rubro">
<span<?= $Page->rubro->viewAttributes() ?>>
<?= $Page->rubro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
    <tr id="r_calle"<?= $Page->calle->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_calle"><?= $Page->calle->caption() ?></span></td>
        <td data-name="calle"<?= $Page->calle->cellAttributes() ?>>
<span id="el_liquidacion_calle">
<span<?= $Page->calle->viewAttributes() ?>>
<?= $Page->calle->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
    <tr id="r_dnro"<?= $Page->dnro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_dnro"><?= $Page->dnro->caption() ?></span></td>
        <td data-name="dnro"<?= $Page->dnro->cellAttributes() ?>>
<span id="el_liquidacion_dnro">
<span<?= $Page->dnro->viewAttributes() ?>>
<?= $Page->dnro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
    <tr id="r_pisodto"<?= $Page->pisodto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_pisodto"><?= $Page->pisodto->caption() ?></span></td>
        <td data-name="pisodto"<?= $Page->pisodto->cellAttributes() ?>>
<span id="el_liquidacion_pisodto">
<span<?= $Page->pisodto->viewAttributes() ?>>
<?= $Page->pisodto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
    <tr id="r_codpost"<?= $Page->codpost->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_codpost"><?= $Page->codpost->caption() ?></span></td>
        <td data-name="codpost"<?= $Page->codpost->cellAttributes() ?>>
<span id="el_liquidacion_codpost">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <tr id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_codpais"><?= $Page->codpais->caption() ?></span></td>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el_liquidacion_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
    <tr id="r_codprov"<?= $Page->codprov->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_codprov"><?= $Page->codprov->caption() ?></span></td>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el_liquidacion_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
    <tr id="r_codloc"<?= $Page->codloc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_codloc"><?= $Page->codloc->caption() ?></span></td>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el_liquidacion_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <tr id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_codrem"><?= $Page->codrem->caption() ?></span></td>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el_liquidacion_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecharem->Visible) { // fecharem ?>
    <tr id="r_fecharem"<?= $Page->fecharem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_fecharem"><?= $Page->fecharem->caption() ?></span></td>
        <td data-name="fecharem"<?= $Page->fecharem->cellAttributes() ?>>
<span id="el_liquidacion_fecharem">
<span<?= $Page->fecharem->viewAttributes() ?>>
<?= $Page->fecharem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
    <tr id="r_cuit"<?= $Page->cuit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_cuit"><?= $Page->cuit->caption() ?></span></td>
        <td data-name="cuit"<?= $Page->cuit->cellAttributes() ?>>
<span id="el_liquidacion_cuit">
<span<?= $Page->cuit->viewAttributes() ?>>
<?= $Page->cuit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
    <tr id="r_tipoiva"<?= $Page->tipoiva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_tipoiva"><?= $Page->tipoiva->caption() ?></span></td>
        <td data-name="tipoiva"<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el_liquidacion_tipoiva">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totremate->Visible) { // totremate ?>
    <tr id="r_totremate"<?= $Page->totremate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_totremate"><?= $Page->totremate->caption() ?></span></td>
        <td data-name="totremate"<?= $Page->totremate->cellAttributes() ?>>
<span id="el_liquidacion_totremate">
<span<?= $Page->totremate->viewAttributes() ?>>
<?= $Page->totremate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totneto1->Visible) { // totneto1 ?>
    <tr id="r_totneto1"<?= $Page->totneto1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_totneto1"><?= $Page->totneto1->caption() ?></span></td>
        <td data-name="totneto1"<?= $Page->totneto1->cellAttributes() ?>>
<span id="el_liquidacion_totneto1">
<span<?= $Page->totneto1->viewAttributes() ?>>
<?= $Page->totneto1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
    <tr id="r_totiva21"<?= $Page->totiva21->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_totiva21"><?= $Page->totiva21->caption() ?></span></td>
        <td data-name="totiva21"<?= $Page->totiva21->cellAttributes() ?>>
<span id="el_liquidacion_totiva21">
<span<?= $Page->totiva21->viewAttributes() ?>>
<?= $Page->totiva21->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subtot1->Visible) { // subtot1 ?>
    <tr id="r_subtot1"<?= $Page->subtot1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_subtot1"><?= $Page->subtot1->caption() ?></span></td>
        <td data-name="subtot1"<?= $Page->subtot1->cellAttributes() ?>>
<span id="el_liquidacion_subtot1">
<span<?= $Page->subtot1->viewAttributes() ?>>
<?= $Page->subtot1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totneto2->Visible) { // totneto2 ?>
    <tr id="r_totneto2"<?= $Page->totneto2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_totneto2"><?= $Page->totneto2->caption() ?></span></td>
        <td data-name="totneto2"<?= $Page->totneto2->cellAttributes() ?>>
<span id="el_liquidacion_totneto2">
<span<?= $Page->totneto2->viewAttributes() ?>>
<?= $Page->totneto2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
    <tr id="r_totiva105"<?= $Page->totiva105->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_totiva105"><?= $Page->totiva105->caption() ?></span></td>
        <td data-name="totiva105"<?= $Page->totiva105->cellAttributes() ?>>
<span id="el_liquidacion_totiva105">
<span<?= $Page->totiva105->viewAttributes() ?>>
<?= $Page->totiva105->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subtot2->Visible) { // subtot2 ?>
    <tr id="r_subtot2"<?= $Page->subtot2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_subtot2"><?= $Page->subtot2->caption() ?></span></td>
        <td data-name="subtot2"<?= $Page->subtot2->cellAttributes() ?>>
<span id="el_liquidacion_subtot2">
<span<?= $Page->subtot2->viewAttributes() ?>>
<?= $Page->subtot2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totacuenta->Visible) { // totacuenta ?>
    <tr id="r_totacuenta"<?= $Page->totacuenta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_totacuenta"><?= $Page->totacuenta->caption() ?></span></td>
        <td data-name="totacuenta"<?= $Page->totacuenta->cellAttributes() ?>>
<span id="el_liquidacion_totacuenta">
<span<?= $Page->totacuenta->viewAttributes() ?>>
<?= $Page->totacuenta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totgastos->Visible) { // totgastos ?>
    <tr id="r_totgastos"<?= $Page->totgastos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_totgastos"><?= $Page->totgastos->caption() ?></span></td>
        <td data-name="totgastos"<?= $Page->totgastos->cellAttributes() ?>>
<span id="el_liquidacion_totgastos">
<span<?= $Page->totgastos->viewAttributes() ?>>
<?= $Page->totgastos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totvarios->Visible) { // totvarios ?>
    <tr id="r_totvarios"<?= $Page->totvarios->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_totvarios"><?= $Page->totvarios->caption() ?></span></td>
        <td data-name="totvarios"<?= $Page->totvarios->cellAttributes() ?>>
<span id="el_liquidacion_totvarios">
<span<?= $Page->totvarios->viewAttributes() ?>>
<?= $Page->totvarios->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->saldoafav->Visible) { // saldoafav ?>
    <tr id="r_saldoafav"<?= $Page->saldoafav->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_saldoafav"><?= $Page->saldoafav->caption() ?></span></td>
        <td data-name="saldoafav"<?= $Page->saldoafav->cellAttributes() ?>>
<span id="el_liquidacion_saldoafav">
<span<?= $Page->saldoafav->viewAttributes() ?>>
<?= $Page->saldoafav->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <tr id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_fechahora"><?= $Page->fechahora->caption() ?></span></td>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_liquidacion_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_liquidacion_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaliq->Visible) { // fechaliq ?>
    <tr id="r_fechaliq"<?= $Page->fechaliq->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_fechaliq"><?= $Page->fechaliq->caption() ?></span></td>
        <td data-name="fechaliq"<?= $Page->fechaliq->cellAttributes() ?>>
<span id="el_liquidacion_fechaliq">
<span<?= $Page->fechaliq->viewAttributes() ?>>
<?= $Page->fechaliq->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_estado"><?= $Page->estado->caption() ?></span></td>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el_liquidacion_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
    <tr id="r_nrodoc"<?= $Page->nrodoc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_nrodoc"><?= $Page->nrodoc->caption() ?></span></td>
        <td data-name="nrodoc"<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el_liquidacion_nrodoc">
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
    <tr id="r_cotiz"<?= $Page->cotiz->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_cotiz"><?= $Page->cotiz->caption() ?></span></td>
        <td data-name="cotiz"<?= $Page->cotiz->cellAttributes() ?>>
<span id="el_liquidacion_cotiz">
<span<?= $Page->cotiz->viewAttributes() ?>>
<?= $Page->cotiz->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
    <tr id="r_usuarioultmod"<?= $Page->usuarioultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></td>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el_liquidacion_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
    <tr id="r_fecultmod"<?= $Page->fecultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_liquidacion_fecultmod"><?= $Page->fecultmod->caption() ?></span></td>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el_liquidacion_fecultmod">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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
