<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$SeriesView = &$Page;
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
<form name="fseriesview" id="fseriesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { series: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fseriesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fseriesview")
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
<input type="hidden" name="t" value="series">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_series_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipcomp->Visible) { // tipcomp ?>
    <tr id="r_tipcomp"<?= $Page->tipcomp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_tipcomp"><?= $Page->tipcomp->caption() ?></span></td>
        <td data-name="tipcomp"<?= $Page->tipcomp->cellAttributes() ?>>
<span id="el_series_tipcomp">
<span<?= $Page->tipcomp->viewAttributes() ?>>
<?= $Page->tipcomp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <tr id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_descripcion"><?= $Page->descripcion->caption() ?></span></td>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_series_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nrodesde->Visible) { // nrodesde ?>
    <tr id="r_nrodesde"<?= $Page->nrodesde->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_nrodesde"><?= $Page->nrodesde->caption() ?></span></td>
        <td data-name="nrodesde"<?= $Page->nrodesde->cellAttributes() ?>>
<span id="el_series_nrodesde">
<span<?= $Page->nrodesde->viewAttributes() ?>>
<?= $Page->nrodesde->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nrohasta->Visible) { // nrohasta ?>
    <tr id="r_nrohasta"<?= $Page->nrohasta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_nrohasta"><?= $Page->nrohasta->caption() ?></span></td>
        <td data-name="nrohasta"<?= $Page->nrohasta->cellAttributes() ?>>
<span id="el_series_nrohasta">
<span<?= $Page->nrohasta->viewAttributes() ?>>
<?= $Page->nrohasta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nroact->Visible) { // nroact ?>
    <tr id="r_nroact"<?= $Page->nroact->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_nroact"><?= $Page->nroact->caption() ?></span></td>
        <td data-name="nroact"<?= $Page->nroact->cellAttributes() ?>>
<span id="el_series_nroact">
<span<?= $Page->nroact->viewAttributes() ?>>
<?= $Page->nroact->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mascara->Visible) { // mascara ?>
    <tr id="r_mascara"<?= $Page->mascara->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_mascara"><?= $Page->mascara->caption() ?></span></td>
        <td data-name="mascara"<?= $Page->mascara->cellAttributes() ?>>
<span id="el_series_mascara">
<span<?= $Page->mascara->viewAttributes() ?>>
<?= $Page->mascara->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <tr id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_activo"><?= $Page->activo->caption() ?></span></td>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el_series_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->automatica->Visible) { // automatica ?>
    <tr id="r_automatica"<?= $Page->automatica->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_automatica"><?= $Page->automatica->caption() ?></span></td>
        <td data-name="automatica"<?= $Page->automatica->cellAttributes() ?>>
<span id="el_series_automatica">
<span<?= $Page->automatica->viewAttributes() ?>>
<?= $Page->automatica->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechatope->Visible) { // fechatope ?>
    <tr id="r_fechatope"<?= $Page->fechatope->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_series_fechatope"><?= $Page->fechatope->caption() ?></span></td>
        <td data-name="fechatope"<?= $Page->fechatope->cellAttributes() ?>>
<span id="el_series_fechatope">
<span<?= $Page->fechatope->viewAttributes() ?>>
<?= $Page->fechatope->getViewValue() ?></span>
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
