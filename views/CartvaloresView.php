<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CartvaloresView = &$Page;
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
<form name="fcartvaloresview" id="fcartvaloresview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cartvalores: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcartvaloresview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcartvaloresview")
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
<input type="hidden" name="t" value="cartvalores">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_cartvalores_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <tr id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_tcomp"><?= $Page->tcomp->caption() ?></span></td>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_cartvalores_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <tr id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_serie"><?= $Page->serie->caption() ?></span></td>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el_cartvalores_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <tr id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_ncomp"><?= $Page->ncomp->caption() ?></span></td>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_cartvalores_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codban->Visible) { // codban ?>
    <tr id="r_codban"<?= $Page->codban->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_codban"><?= $Page->codban->caption() ?></span></td>
        <td data-name="codban"<?= $Page->codban->cellAttributes() ?>>
<span id="el_cartvalores_codban">
<span<?= $Page->codban->viewAttributes() ?>>
<?= $Page->codban->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codsuc->Visible) { // codsuc ?>
    <tr id="r_codsuc"<?= $Page->codsuc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_codsuc"><?= $Page->codsuc->caption() ?></span></td>
        <td data-name="codsuc"<?= $Page->codsuc->cellAttributes() ?>>
<span id="el_cartvalores_codsuc">
<span<?= $Page->codsuc->viewAttributes() ?>>
<?= $Page->codsuc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codcta->Visible) { // codcta ?>
    <tr id="r_codcta"<?= $Page->codcta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_codcta"><?= $Page->codcta->caption() ?></span></td>
        <td data-name="codcta"<?= $Page->codcta->cellAttributes() ?>>
<span id="el_cartvalores_codcta">
<span<?= $Page->codcta->viewAttributes() ?>>
<?= $Page->codcta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipcta->Visible) { // tipcta ?>
    <tr id="r_tipcta"<?= $Page->tipcta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_tipcta"><?= $Page->tipcta->caption() ?></span></td>
        <td data-name="tipcta"<?= $Page->tipcta->cellAttributes() ?>>
<span id="el_cartvalores_tipcta">
<span<?= $Page->tipcta->viewAttributes() ?>>
<?= $Page->tipcta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codchq->Visible) { // codchq ?>
    <tr id="r_codchq"<?= $Page->codchq->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_codchq"><?= $Page->codchq->caption() ?></span></td>
        <td data-name="codchq"<?= $Page->codchq->cellAttributes() ?>>
<span id="el_cartvalores_codchq">
<span<?= $Page->codchq->viewAttributes() ?>>
<?= $Page->codchq->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <tr id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_codpais"><?= $Page->codpais->caption() ?></span></td>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el_cartvalores_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->importe->Visible) { // importe ?>
    <tr id="r_importe"<?= $Page->importe->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_importe"><?= $Page->importe->caption() ?></span></td>
        <td data-name="importe"<?= $Page->importe->cellAttributes() ?>>
<span id="el_cartvalores_importe">
<span<?= $Page->importe->viewAttributes() ?>>
<?= $Page->importe->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaemis->Visible) { // fechaemis ?>
    <tr id="r_fechaemis"<?= $Page->fechaemis->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_fechaemis"><?= $Page->fechaemis->caption() ?></span></td>
        <td data-name="fechaemis"<?= $Page->fechaemis->cellAttributes() ?>>
<span id="el_cartvalores_fechaemis">
<span<?= $Page->fechaemis->viewAttributes() ?>>
<?= $Page->fechaemis->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechapago->Visible) { // fechapago ?>
    <tr id="r_fechapago"<?= $Page->fechapago->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_fechapago"><?= $Page->fechapago->caption() ?></span></td>
        <td data-name="fechapago"<?= $Page->fechapago->cellAttributes() ?>>
<span id="el_cartvalores_fechapago">
<span<?= $Page->fechapago->viewAttributes() ?>>
<?= $Page->fechapago->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->entrego->Visible) { // entrego ?>
    <tr id="r_entrego"<?= $Page->entrego->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_entrego"><?= $Page->entrego->caption() ?></span></td>
        <td data-name="entrego"<?= $Page->entrego->cellAttributes() ?>>
<span id="el_cartvalores_entrego">
<span<?= $Page->entrego->viewAttributes() ?>>
<?= $Page->entrego->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->recibio->Visible) { // recibio ?>
    <tr id="r_recibio"<?= $Page->recibio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_recibio"><?= $Page->recibio->caption() ?></span></td>
        <td data-name="recibio"<?= $Page->recibio->cellAttributes() ?>>
<span id="el_cartvalores_recibio">
<span<?= $Page->recibio->viewAttributes() ?>>
<?= $Page->recibio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaingr->Visible) { // fechaingr ?>
    <tr id="r_fechaingr"<?= $Page->fechaingr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_fechaingr"><?= $Page->fechaingr->caption() ?></span></td>
        <td data-name="fechaingr"<?= $Page->fechaingr->cellAttributes() ?>>
<span id="el_cartvalores_fechaingr">
<span<?= $Page->fechaingr->viewAttributes() ?>>
<?= $Page->fechaingr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaentrega->Visible) { // fechaentrega ?>
    <tr id="r_fechaentrega"<?= $Page->fechaentrega->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_fechaentrega"><?= $Page->fechaentrega->caption() ?></span></td>
        <td data-name="fechaentrega"<?= $Page->fechaentrega->cellAttributes() ?>>
<span id="el_cartvalores_fechaentrega">
<span<?= $Page->fechaentrega->viewAttributes() ?>>
<?= $Page->fechaentrega->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
    <tr id="r_tcomprel"<?= $Page->tcomprel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_tcomprel"><?= $Page->tcomprel->caption() ?></span></td>
        <td data-name="tcomprel"<?= $Page->tcomprel->cellAttributes() ?>>
<span id="el_cartvalores_tcomprel">
<span<?= $Page->tcomprel->viewAttributes() ?>>
<?= $Page->tcomprel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
    <tr id="r_serierel"<?= $Page->serierel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_serierel"><?= $Page->serierel->caption() ?></span></td>
        <td data-name="serierel"<?= $Page->serierel->cellAttributes() ?>>
<span id="el_cartvalores_serierel">
<span<?= $Page->serierel->viewAttributes() ?>>
<?= $Page->serierel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
    <tr id="r_ncomprel"<?= $Page->ncomprel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_ncomprel"><?= $Page->ncomprel->caption() ?></span></td>
        <td data-name="ncomprel"<?= $Page->ncomprel->cellAttributes() ?>>
<span id="el_cartvalores_ncomprel">
<span<?= $Page->ncomprel->viewAttributes() ?>>
<?= $Page->ncomprel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_estado"><?= $Page->estado->caption() ?></span></td>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el_cartvalores_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
    <tr id="r_moneda"<?= $Page->moneda->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_moneda"><?= $Page->moneda->caption() ?></span></td>
        <td data-name="moneda"<?= $Page->moneda->cellAttributes() ?>>
<span id="el_cartvalores_moneda">
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <tr id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_fechahora"><?= $Page->fechahora->caption() ?></span></td>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_cartvalores_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_cartvalores_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
    <tr id="r_tcompsal"<?= $Page->tcompsal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_tcompsal"><?= $Page->tcompsal->caption() ?></span></td>
        <td data-name="tcompsal"<?= $Page->tcompsal->cellAttributes() ?>>
<span id="el_cartvalores_tcompsal">
<span<?= $Page->tcompsal->viewAttributes() ?>>
<?= $Page->tcompsal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
    <tr id="r_seriesal"<?= $Page->seriesal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_seriesal"><?= $Page->seriesal->caption() ?></span></td>
        <td data-name="seriesal"<?= $Page->seriesal->cellAttributes() ?>>
<span id="el_cartvalores_seriesal">
<span<?= $Page->seriesal->viewAttributes() ?>>
<?= $Page->seriesal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
    <tr id="r_ncompsal"<?= $Page->ncompsal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_ncompsal"><?= $Page->ncompsal->caption() ?></span></td>
        <td data-name="ncompsal"<?= $Page->ncompsal->cellAttributes() ?>>
<span id="el_cartvalores_ncompsal">
<span<?= $Page->ncompsal->viewAttributes() ?>>
<?= $Page->ncompsal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <tr id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_codrem"><?= $Page->codrem->caption() ?></span></td>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el_cartvalores_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
    <tr id="r_cotiz"<?= $Page->cotiz->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_cotiz"><?= $Page->cotiz->caption() ?></span></td>
        <td data-name="cotiz"<?= $Page->cotiz->cellAttributes() ?>>
<span id="el_cartvalores_cotiz">
<span<?= $Page->cotiz->viewAttributes() ?>>
<?= $Page->cotiz->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usurel->Visible) { // usurel ?>
    <tr id="r_usurel"<?= $Page->usurel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_usurel"><?= $Page->usurel->caption() ?></span></td>
        <td data-name="usurel"<?= $Page->usurel->cellAttributes() ?>>
<span id="el_cartvalores_usurel">
<span<?= $Page->usurel->viewAttributes() ?>>
<?= $Page->usurel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecharel->Visible) { // fecharel ?>
    <tr id="r_fecharel"<?= $Page->fecharel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_fecharel"><?= $Page->fecharel->caption() ?></span></td>
        <td data-name="fecharel"<?= $Page->fecharel->cellAttributes() ?>>
<span id="el_cartvalores_fecharel">
<span<?= $Page->fecharel->viewAttributes() ?>>
<?= $Page->fecharel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ususal->Visible) { // ususal ?>
    <tr id="r_ususal"<?= $Page->ususal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_ususal"><?= $Page->ususal->caption() ?></span></td>
        <td data-name="ususal"<?= $Page->ususal->cellAttributes() ?>>
<span id="el_cartvalores_ususal">
<span<?= $Page->ususal->viewAttributes() ?>>
<?= $Page->ususal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechasal->Visible) { // fechasal ?>
    <tr id="r_fechasal"<?= $Page->fechasal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cartvalores_fechasal"><?= $Page->fechasal->caption() ?></span></td>
        <td data-name="fechasal"<?= $Page->fechasal->cellAttributes() ?>>
<span id="el_cartvalores_fechasal">
<span<?= $Page->fechasal->viewAttributes() ?>>
<?= $Page->fechasal->getViewValue() ?></span>
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
