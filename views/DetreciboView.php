<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetreciboView = &$Page;
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
<form name="fdetreciboview" id="fdetreciboview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detrecibo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdetreciboview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetreciboview")
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
<input type="hidden" name="t" value="detrecibo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_detrecibo_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <tr id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_tcomp"><?= $Page->tcomp->caption() ?></span></td>
        <td data-name="tcomp"<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_detrecibo_tcomp">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <tr id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_serie"><?= $Page->serie->caption() ?></span></td>
        <td data-name="serie"<?= $Page->serie->cellAttributes() ?>>
<span id="el_detrecibo_serie">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <tr id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_ncomp"><?= $Page->ncomp->caption() ?></span></td>
        <td data-name="ncomp"<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_detrecibo_ncomp">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
    <tr id="r_nreng"<?= $Page->nreng->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_nreng"><?= $Page->nreng->caption() ?></span></td>
        <td data-name="nreng"<?= $Page->nreng->cellAttributes() ?>>
<span id="el_detrecibo_nreng">
<span<?= $Page->nreng->viewAttributes() ?>>
<?= $Page->nreng->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
    <tr id="r_tcomprel"<?= $Page->tcomprel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_tcomprel"><?= $Page->tcomprel->caption() ?></span></td>
        <td data-name="tcomprel"<?= $Page->tcomprel->cellAttributes() ?>>
<span id="el_detrecibo_tcomprel">
<span<?= $Page->tcomprel->viewAttributes() ?>>
<?= $Page->tcomprel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
    <tr id="r_serierel"<?= $Page->serierel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_serierel"><?= $Page->serierel->caption() ?></span></td>
        <td data-name="serierel"<?= $Page->serierel->cellAttributes() ?>>
<span id="el_detrecibo_serierel">
<span<?= $Page->serierel->viewAttributes() ?>>
<?= $Page->serierel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
    <tr id="r_ncomprel"<?= $Page->ncomprel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_ncomprel"><?= $Page->ncomprel->caption() ?></span></td>
        <td data-name="ncomprel"<?= $Page->ncomprel->cellAttributes() ?>>
<span id="el_detrecibo_ncomprel">
<span<?= $Page->ncomprel->viewAttributes() ?>>
<?= $Page->ncomprel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->netocbterel->Visible) { // netocbterel ?>
    <tr id="r_netocbterel"<?= $Page->netocbterel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_netocbterel"><?= $Page->netocbterel->caption() ?></span></td>
        <td data-name="netocbterel"<?= $Page->netocbterel->cellAttributes() ?>>
<span id="el_detrecibo_netocbterel">
<span<?= $Page->netocbterel->viewAttributes() ?>>
<?= $Page->netocbterel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_detrecibo_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <tr id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_fechahora"><?= $Page->fechahora->caption() ?></span></td>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_detrecibo_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
    <tr id="r_nrodoc"<?= $Page->nrodoc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detrecibo_nrodoc"><?= $Page->nrodoc->caption() ?></span></td>
        <td data-name="nrodoc"<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el_detrecibo_nrodoc">
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
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
