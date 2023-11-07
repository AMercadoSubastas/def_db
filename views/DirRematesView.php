<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DirRematesView = &$Page;
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
<form name="fdir_rematesview" id="fdir_rematesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dir_remates: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdir_rematesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdir_rematesview")
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
<input type="hidden" name="t" value="dir_remates">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->codigo->Visible) { // codigo ?>
    <tr id="r_codigo"<?= $Page->codigo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_codigo"><?= $Page->codigo->caption() ?></span></td>
        <td data-name="codigo"<?= $Page->codigo->cellAttributes() ?>>
<span id="el_dir_remates_codigo">
<span<?= $Page->codigo->viewAttributes() ?>>
<?= $Page->codigo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <tr id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_codrem"><?= $Page->codrem->caption() ?></span></td>
        <td data-name="codrem"<?= $Page->codrem->cellAttributes() ?>>
<span id="el_dir_remates_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
    <tr id="r_secuencia"<?= $Page->secuencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_secuencia"><?= $Page->secuencia->caption() ?></span></td>
        <td data-name="secuencia"<?= $Page->secuencia->cellAttributes() ?>>
<span id="el_dir_remates_secuencia">
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <tr id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_direccion"><?= $Page->direccion->caption() ?></span></td>
        <td data-name="direccion"<?= $Page->direccion->cellAttributes() ?>>
<span id="el_dir_remates_direccion">
<span<?= $Page->direccion->viewAttributes() ?>>
<?= $Page->direccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <tr id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_codpais"><?= $Page->codpais->caption() ?></span></td>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el_dir_remates_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
    <tr id="r_codprov"<?= $Page->codprov->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_codprov"><?= $Page->codprov->caption() ?></span></td>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el_dir_remates_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
    <tr id="r_codloc"<?= $Page->codloc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_codloc"><?= $Page->codloc->caption() ?></span></td>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el_dir_remates_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuarioalta->Visible) { // usuarioalta ?>
    <tr id="r_usuarioalta"<?= $Page->usuarioalta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_usuarioalta"><?= $Page->usuarioalta->caption() ?></span></td>
        <td data-name="usuarioalta"<?= $Page->usuarioalta->cellAttributes() ?>>
<span id="el_dir_remates_usuarioalta">
<span<?= $Page->usuarioalta->viewAttributes() ?>>
<?= $Page->usuarioalta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaalta->Visible) { // fechaalta ?>
    <tr id="r_fechaalta"<?= $Page->fechaalta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_fechaalta"><?= $Page->fechaalta->caption() ?></span></td>
        <td data-name="fechaalta"<?= $Page->fechaalta->cellAttributes() ?>>
<span id="el_dir_remates_fechaalta">
<span<?= $Page->fechaalta->viewAttributes() ?>>
<?= $Page->fechaalta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuariomod->Visible) { // usuariomod ?>
    <tr id="r_usuariomod"<?= $Page->usuariomod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_usuariomod"><?= $Page->usuariomod->caption() ?></span></td>
        <td data-name="usuariomod"<?= $Page->usuariomod->cellAttributes() ?>>
<span id="el_dir_remates_usuariomod">
<span<?= $Page->usuariomod->viewAttributes() ?>>
<?= $Page->usuariomod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaultmod->Visible) { // fechaultmod ?>
    <tr id="r_fechaultmod"<?= $Page->fechaultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dir_remates_fechaultmod"><?= $Page->fechaultmod->caption() ?></span></td>
        <td data-name="fechaultmod"<?= $Page->fechaultmod->cellAttributes() ?>>
<span id="el_dir_remates_fechaultmod">
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
