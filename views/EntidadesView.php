<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$EntidadesView = &$Page;
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
<form name="fentidadesview" id="fentidadesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { entidades: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fentidadesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fentidadesview")
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
<input type="hidden" name="t" value="entidades">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->razsoc->Visible) { // razsoc ?>
    <tr id="r_razsoc"<?= $Page->razsoc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_razsoc"><?= $Page->razsoc->caption() ?></span></td>
        <td data-name="razsoc"<?= $Page->razsoc->cellAttributes() ?>>
<span id="el_entidades_razsoc">
<span<?= $Page->razsoc->viewAttributes() ?>>
<?= $Page->razsoc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
    <tr id="r_calle"<?= $Page->calle->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_calle"><?= $Page->calle->caption() ?></span></td>
        <td data-name="calle"<?= $Page->calle->cellAttributes() ?>>
<span id="el_entidades_calle">
<span<?= $Page->calle->viewAttributes() ?>>
<?= $Page->calle->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->numero->Visible) { // numero ?>
    <tr id="r_numero"<?= $Page->numero->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_numero"><?= $Page->numero->caption() ?></span></td>
        <td data-name="numero"<?= $Page->numero->cellAttributes() ?>>
<span id="el_entidades_numero">
<span<?= $Page->numero->viewAttributes() ?>>
<?= $Page->numero->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
    <tr id="r_pisodto"<?= $Page->pisodto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_pisodto"><?= $Page->pisodto->caption() ?></span></td>
        <td data-name="pisodto"<?= $Page->pisodto->cellAttributes() ?>>
<span id="el_entidades_pisodto">
<span<?= $Page->pisodto->viewAttributes() ?>>
<?= $Page->pisodto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <tr id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_codpais"><?= $Page->codpais->caption() ?></span></td>
        <td data-name="codpais"<?= $Page->codpais->cellAttributes() ?>>
<span id="el_entidades_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
    <tr id="r_codprov"<?= $Page->codprov->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_codprov"><?= $Page->codprov->caption() ?></span></td>
        <td data-name="codprov"<?= $Page->codprov->cellAttributes() ?>>
<span id="el_entidades_codprov">
<span<?= $Page->codprov->viewAttributes() ?>>
<?= $Page->codprov->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
    <tr id="r_codloc"<?= $Page->codloc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_codloc"><?= $Page->codloc->caption() ?></span></td>
        <td data-name="codloc"<?= $Page->codloc->cellAttributes() ?>>
<span id="el_entidades_codloc">
<span<?= $Page->codloc->viewAttributes() ?>>
<?= $Page->codloc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
    <tr id="r_codpost"<?= $Page->codpost->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_codpost"><?= $Page->codpost->caption() ?></span></td>
        <td data-name="codpost"<?= $Page->codpost->cellAttributes() ?>>
<span id="el_entidades_codpost">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tellinea->Visible) { // tellinea ?>
    <tr id="r_tellinea"<?= $Page->tellinea->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_tellinea"><?= $Page->tellinea->caption() ?></span></td>
        <td data-name="tellinea"<?= $Page->tellinea->cellAttributes() ?>>
<span id="el_entidades_tellinea">
<span<?= $Page->tellinea->viewAttributes() ?>>
<?= $Page->tellinea->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telcelu->Visible) { // telcelu ?>
    <tr id="r_telcelu"<?= $Page->telcelu->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_telcelu"><?= $Page->telcelu->caption() ?></span></td>
        <td data-name="telcelu"<?= $Page->telcelu->cellAttributes() ?>>
<span id="el_entidades_telcelu">
<span<?= $Page->telcelu->viewAttributes() ?>>
<?= $Page->telcelu->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipoent->Visible) { // tipoent ?>
    <tr id="r_tipoent"<?= $Page->tipoent->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_tipoent"><?= $Page->tipoent->caption() ?></span></td>
        <td data-name="tipoent"<?= $Page->tipoent->cellAttributes() ?>>
<span id="el_entidades_tipoent">
<span<?= $Page->tipoent->viewAttributes() ?>>
<?= $Page->tipoent->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
    <tr id="r_tipoiva"<?= $Page->tipoiva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_tipoiva"><?= $Page->tipoiva->caption() ?></span></td>
        <td data-name="tipoiva"<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el_entidades_tipoiva">
<span<?= $Page->tipoiva->viewAttributes() ?>>
<?= $Page->tipoiva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
    <tr id="r_cuit"<?= $Page->cuit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_cuit"><?= $Page->cuit->caption() ?></span></td>
        <td data-name="cuit"<?= $Page->cuit->cellAttributes() ?>>
<span id="el_entidades_cuit">
<span<?= $Page->cuit->viewAttributes() ?>>
<?= $Page->cuit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->calif->Visible) { // calif ?>
    <tr id="r_calif"<?= $Page->calif->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_calif"><?= $Page->calif->caption() ?></span></td>
        <td data-name="calif"<?= $Page->calif->cellAttributes() ?>>
<span id="el_entidades_calif">
<span<?= $Page->calif->viewAttributes() ?>>
<?= $Page->calif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
    <tr id="r_fecalta"<?= $Page->fecalta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_fecalta"><?= $Page->fecalta->caption() ?></span></td>
        <td data-name="fecalta"<?= $Page->fecalta->cellAttributes() ?>>
<span id="el_entidades_fecalta">
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_entidades_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contacto->Visible) { // contacto ?>
    <tr id="r_contacto"<?= $Page->contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_contacto"><?= $Page->contacto->caption() ?></span></td>
        <td data-name="contacto"<?= $Page->contacto->cellAttributes() ?>>
<span id="el_entidades_contacto">
<span<?= $Page->contacto->viewAttributes() ?>>
<?= $Page->contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mailcont->Visible) { // mailcont ?>
    <tr id="r_mailcont"<?= $Page->mailcont->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_mailcont"><?= $Page->mailcont->caption() ?></span></td>
        <td data-name="mailcont"<?= $Page->mailcont->cellAttributes() ?>>
<span id="el_entidades_mailcont">
<span<?= $Page->mailcont->viewAttributes() ?>>
<?= $Page->mailcont->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
    <tr id="r_cargo"<?= $Page->cargo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_cargo"><?= $Page->cargo->caption() ?></span></td>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el_entidades_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <tr id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_fechahora"><?= $Page->fechahora->caption() ?></span></td>
        <td data-name="fechahora"<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_entidades_fechahora">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <tr id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_activo"><?= $Page->activo->caption() ?></span></td>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el_entidades_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pagweb->Visible) { // pagweb ?>
    <tr id="r_pagweb"<?= $Page->pagweb->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_pagweb"><?= $Page->pagweb->caption() ?></span></td>
        <td data-name="pagweb"<?= $Page->pagweb->cellAttributes() ?>>
<span id="el_entidades_pagweb">
<span<?= $Page->pagweb->viewAttributes() ?>>
<?= $Page->pagweb->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
    <tr id="r_tipoind"<?= $Page->tipoind->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_tipoind"><?= $Page->tipoind->caption() ?></span></td>
        <td data-name="tipoind"<?= $Page->tipoind->cellAttributes() ?>>
<span id="el_entidades_tipoind">
<span<?= $Page->tipoind->viewAttributes() ?>>
<?= $Page->tipoind->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
    <tr id="r_usuarioultmod"<?= $Page->usuarioultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></td>
        <td data-name="usuarioultmod"<?= $Page->usuarioultmod->cellAttributes() ?>>
<span id="el_entidades_usuarioultmod">
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
    <tr id="r_fecultmod"<?= $Page->fecultmod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_entidades_fecultmod"><?= $Page->fecultmod->caption() ?></span></td>
        <td data-name="fecultmod"<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el_entidades_fecultmod">
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
