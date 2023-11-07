<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$TipcompView = &$Page;
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
<form name="ftipcompview" id="ftipcompview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipcomp: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ftipcompview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipcompview")
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
<input type="hidden" name="t" value="tipcomp">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codnum->Visible) { // codnum ?>
    <tr id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_codnum"><?= $Page->codnum->caption() ?></span></td>
        <td data-name="codnum"<?= $Page->codnum->cellAttributes() ?>>
<span id="el_tipcomp_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <tr id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_descripcion"><?= $Page->descripcion->caption() ?></span></td>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_tipcomp_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <tr id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_activo"><?= $Page->activo->caption() ?></span></td>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el_tipcomp_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->esfactura->Visible) { // esfactura ?>
    <tr id="r_esfactura"<?= $Page->esfactura->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_esfactura"><?= $Page->esfactura->caption() ?></span></td>
        <td data-name="esfactura"<?= $Page->esfactura->cellAttributes() ?>>
<span id="el_tipcomp_esfactura">
<span<?= $Page->esfactura->viewAttributes() ?>>
<?= $Page->esfactura->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->esprovedor->Visible) { // esprovedor ?>
    <tr id="r_esprovedor"<?= $Page->esprovedor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_esprovedor"><?= $Page->esprovedor->caption() ?></span></td>
        <td data-name="esprovedor"<?= $Page->esprovedor->cellAttributes() ?>>
<span id="el_tipcomp_esprovedor">
<span<?= $Page->esprovedor->viewAttributes() ?>>
<?= $Page->esprovedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codafip->Visible) { // codafip ?>
    <tr id="r_codafip"<?= $Page->codafip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_codafip"><?= $Page->codafip->caption() ?></span></td>
        <td data-name="codafip"<?= $Page->codafip->cellAttributes() ?>>
<span id="el_tipcomp_codafip">
<span<?= $Page->codafip->viewAttributes() ?>>
<?= $Page->codafip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuarioalta->Visible) { // usuarioalta ?>
    <tr id="r_usuarioalta"<?= $Page->usuarioalta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_usuarioalta"><?= $Page->usuarioalta->caption() ?></span></td>
        <td data-name="usuarioalta"<?= $Page->usuarioalta->cellAttributes() ?>>
<span id="el_tipcomp_usuarioalta">
<span<?= $Page->usuarioalta->viewAttributes() ?>>
<?= $Page->usuarioalta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaalta->Visible) { // fechaalta ?>
    <tr id="r_fechaalta"<?= $Page->fechaalta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_fechaalta"><?= $Page->fechaalta->caption() ?></span></td>
        <td data-name="fechaalta"<?= $Page->fechaalta->cellAttributes() ?>>
<span id="el_tipcomp_fechaalta">
<span<?= $Page->fechaalta->viewAttributes() ?>>
<?= $Page->fechaalta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuariomod->Visible) { // usuariomod ?>
    <tr id="r_usuariomod"<?= $Page->usuariomod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_usuariomod"><?= $Page->usuariomod->caption() ?></span></td>
        <td data-name="usuariomod"<?= $Page->usuariomod->cellAttributes() ?>>
<span id="el_tipcomp_usuariomod">
<span<?= $Page->usuariomod->viewAttributes() ?>>
<?= $Page->usuariomod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
    <tr id="r_fechaultmod"<?= $Page->fechaultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipcomp_fechaultmod"><?= $Page->fechaultmod->caption() ?></span></td>
        <td data-name="fechaultmod"<?= $Page->fechaultmod->cellAttributes() ?>>
<span id="el_tipcomp_fechaultmod">
<span<?= $Page->fechaultmod->viewAttributes() ?>>
<?= $Page->fechaultmod->getViewValue() ?></span>
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
