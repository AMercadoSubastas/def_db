<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LotesView = &$Page;
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
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<form name="flotesview" id="flotesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { lotes: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var flotesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flotesview")
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
<input type="hidden" name="t" value="lotes">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_lotes_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <tr id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_codrem"><?= $Page->codrem->caption() ?></span></td>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el_lotes_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
    <tr id="r_codcli"<?= $Page->codcli->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_codcli"><?= $Page->codcli->caption() ?></span></td>
        <td data-name="codcli"<?= $Page->codcli->cellAttributes() ?>>
<span id="el_lotes_codcli">
<span<?= $Page->codcli->viewAttributes() ?>>
<?= $Page->codcli->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codrubro->Visible) { // codrubro ?>
    <tr id="r_codrubro"<?= $Page->codrubro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_codrubro"><?= $Page->codrubro->caption() ?></span></td>
        <td data-name="codrubro"<?= $Page->codrubro->cellAttributes() ?>>
<span id="el_lotes_codrubro">
<span<?= $Page->codrubro->viewAttributes() ?>>
<?= $Page->codrubro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_estado"><?= $Page->estado->caption() ?></span></td>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el_lotes_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
    <tr id="r_moneda"<?= $Page->moneda->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_moneda"><?= $Page->moneda->caption() ?></span></td>
        <td data-name="moneda"<?= $Page->moneda->cellAttributes() ?>>
<span id="el_lotes_moneda">
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->preciobase->Visible) { // preciobase ?>
    <tr id="r_preciobase"<?= $Page->preciobase->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_preciobase"><?= $Page->preciobase->caption() ?></span></td>
        <td data-name="preciobase"<?= $Page->preciobase->cellAttributes() ?>>
<span id="el_lotes_preciobase">
<span<?= $Page->preciobase->viewAttributes() ?>>
<?= $Page->preciobase->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->preciofinal->Visible) { // preciofinal ?>
    <tr id="r_preciofinal"<?= $Page->preciofinal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_preciofinal"><?= $Page->preciofinal->caption() ?></span></td>
        <td data-name="preciofinal"<?= $Page->preciofinal->cellAttributes() ?>>
<span id="el_lotes_preciofinal">
<span<?= $Page->preciofinal->viewAttributes() ?>>
<?= $Page->preciofinal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comiscobr->Visible) { // comiscobr ?>
    <tr id="r_comiscobr"<?= $Page->comiscobr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_comiscobr"><?= $Page->comiscobr->caption() ?></span></td>
        <td data-name="comiscobr"<?= $Page->comiscobr->cellAttributes() ?>>
<span id="el_lotes_comiscobr">
<span<?= $Page->comiscobr->viewAttributes() ?>>
<?= $Page->comiscobr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comispag->Visible) { // comispag ?>
    <tr id="r_comispag"<?= $Page->comispag->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_comispag"><?= $Page->comispag->caption() ?></span></td>
        <td data-name="comispag"<?= $Page->comispag->cellAttributes() ?>>
<span id="el_lotes_comispag">
<span<?= $Page->comispag->viewAttributes() ?>>
<?= $Page->comispag->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
    <tr id="r_comprador"<?= $Page->comprador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_comprador"><?= $Page->comprador->caption() ?></span></td>
        <td data-name="comprador"<?= $Page->comprador->cellAttributes() ?>>
<span id="el_lotes_comprador">
<span<?= $Page->comprador->viewAttributes() ?>>
<?= $Page->comprador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ivari->Visible) { // ivari ?>
    <tr id="r_ivari"<?= $Page->ivari->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_ivari"><?= $Page->ivari->caption() ?></span></td>
        <td data-name="ivari"<?= $Page->ivari->cellAttributes() ?>>
<span id="el_lotes_ivari">
<span<?= $Page->ivari->viewAttributes() ?>>
<?= $Page->ivari->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ivarni->Visible) { // ivarni ?>
    <tr id="r_ivarni"<?= $Page->ivarni->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_ivarni"><?= $Page->ivarni->caption() ?></span></td>
        <td data-name="ivarni"<?= $Page->ivarni->cellAttributes() ?>>
<span id="el_lotes_ivarni">
<span<?= $Page->ivarni->viewAttributes() ?>>
<?= $Page->ivarni->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codimpadic->Visible) { // codimpadic ?>
    <tr id="r_codimpadic"<?= $Page->codimpadic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_codimpadic"><?= $Page->codimpadic->caption() ?></span></td>
        <td data-name="codimpadic"<?= $Page->codimpadic->cellAttributes() ?>>
<span id="el_lotes_codimpadic">
<span<?= $Page->codimpadic->viewAttributes() ?>>
<?= $Page->codimpadic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->impadic->Visible) { // impadic ?>
    <tr id="r_impadic"<?= $Page->impadic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_impadic"><?= $Page->impadic->caption() ?></span></td>
        <td data-name="impadic"<?= $Page->impadic->cellAttributes() ?>>
<span id="el_lotes_impadic">
<span<?= $Page->impadic->viewAttributes() ?>>
<?= $Page->impadic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <tr id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_descripcion"><?= $Page->descripcion->caption() ?></span></td>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_lotes_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descor->Visible) { // descor ?>
    <tr id="r_descor"<?= $Page->descor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_descor"><?= $Page->descor->caption() ?></span></td>
        <td data-name="descor"<?= $Page->descor->cellAttributes() ?>>
<span id="el_lotes_descor">
<span<?= $Page->descor->viewAttributes() ?>>
<?= $Page->descor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_lotes_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
    <tr id="r_fecalta"<?= $Page->fecalta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_fecalta"><?= $Page->fecalta->caption() ?></span></td>
        <td data-name="fecalta"<?= $Page->fecalta->cellAttributes() ?>>
<span id="el_lotes_fecalta">
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
    <tr id="r_secuencia"<?= $Page->secuencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_secuencia"><?= $Page->secuencia->caption() ?></span></td>
        <td data-name="secuencia"<?= $Page->secuencia->cellAttributes() ?>>
<span id="el_lotes_secuencia">
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codintlote->Visible) { // codintlote ?>
    <tr id="r_codintlote"<?= $Page->codintlote->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_codintlote"><?= $Page->codintlote->caption() ?></span></td>
        <td data-name="codintlote"<?= $Page->codintlote->cellAttributes() ?>>
<span id="el_lotes_codintlote">
<span<?= $Page->codintlote->viewAttributes() ?>>
<?= $Page->codintlote->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codintnum->Visible) { // codintnum ?>
    <tr id="r_codintnum"<?= $Page->codintnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_codintnum"><?= $Page->codintnum->caption() ?></span></td>
        <td data-name="codintnum"<?= $Page->codintnum->cellAttributes() ?>>
<span id="el_lotes_codintnum">
<span<?= $Page->codintnum->viewAttributes() ?>>
<?= $Page->codintnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codintsublote->Visible) { // codintsublote ?>
    <tr id="r_codintsublote"<?= $Page->codintsublote->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_codintsublote"><?= $Page->codintsublote->caption() ?></span></td>
        <td data-name="codintsublote"<?= $Page->codintsublote->cellAttributes() ?>>
<span id="el_lotes_codintsublote">
<span<?= $Page->codintsublote->viewAttributes() ?>>
<?= $Page->codintsublote->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dir_secuencia->Visible) { // dir_secuencia ?>
    <tr id="r_dir_secuencia"<?= $Page->dir_secuencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_dir_secuencia"><?= $Page->dir_secuencia->caption() ?></span></td>
        <td data-name="dir_secuencia"<?= $Page->dir_secuencia->cellAttributes() ?>>
<span id="el_lotes_dir_secuencia">
<span<?= $Page->dir_secuencia->viewAttributes() ?>>
<?= $Page->dir_secuencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
    <tr id="r_usuarioultmod"<?= $Page->usuarioultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></td>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el_lotes_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
    <tr id="r_fecultmod"<?= $Page->fecultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_lotes_fecultmod"><?= $Page->fecultmod->caption() ?></span></td>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el_lotes_fecultmod">
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
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
