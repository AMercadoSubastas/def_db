<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$EntidadesDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { entidades: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fentidadesdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fentidadesdelete")
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
<form name="fentidadesdelete" id="fentidadesdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="entidades">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_entidades_codnum" class="entidades_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->razsoc->Visible) { // razsoc ?>
        <th class="<?= $Page->razsoc->headerCellClass() ?>"><span id="elh_entidades_razsoc" class="entidades_razsoc"><?= $Page->razsoc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
        <th class="<?= $Page->calle->headerCellClass() ?>"><span id="elh_entidades_calle" class="entidades_calle"><?= $Page->calle->caption() ?></span></th>
<?php } ?>
<?php if ($Page->numero->Visible) { // numero ?>
        <th class="<?= $Page->numero->headerCellClass() ?>"><span id="elh_entidades_numero" class="entidades_numero"><?= $Page->numero->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
        <th class="<?= $Page->pisodto->headerCellClass() ?>"><span id="elh_entidades_pisodto" class="entidades_pisodto"><?= $Page->pisodto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th class="<?= $Page->codpais->headerCellClass() ?>"><span id="elh_entidades_codpais" class="entidades_codpais"><?= $Page->codpais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
        <th class="<?= $Page->codprov->headerCellClass() ?>"><span id="elh_entidades_codprov" class="entidades_codprov"><?= $Page->codprov->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
        <th class="<?= $Page->codloc->headerCellClass() ?>"><span id="elh_entidades_codloc" class="entidades_codloc"><?= $Page->codloc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
        <th class="<?= $Page->codpost->headerCellClass() ?>"><span id="elh_entidades_codpost" class="entidades_codpost"><?= $Page->codpost->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tellinea->Visible) { // tellinea ?>
        <th class="<?= $Page->tellinea->headerCellClass() ?>"><span id="elh_entidades_tellinea" class="entidades_tellinea"><?= $Page->tellinea->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telcelu->Visible) { // telcelu ?>
        <th class="<?= $Page->telcelu->headerCellClass() ?>"><span id="elh_entidades_telcelu" class="entidades_telcelu"><?= $Page->telcelu->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipoent->Visible) { // tipoent ?>
        <th class="<?= $Page->tipoent->headerCellClass() ?>"><span id="elh_entidades_tipoent" class="entidades_tipoent"><?= $Page->tipoent->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
        <th class="<?= $Page->tipoiva->headerCellClass() ?>"><span id="elh_entidades_tipoiva" class="entidades_tipoiva"><?= $Page->tipoiva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
        <th class="<?= $Page->cuit->headerCellClass() ?>"><span id="elh_entidades_cuit" class="entidades_cuit"><?= $Page->cuit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->calif->Visible) { // calif ?>
        <th class="<?= $Page->calif->headerCellClass() ?>"><span id="elh_entidades_calif" class="entidades_calif"><?= $Page->calif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <th class="<?= $Page->fecalta->headerCellClass() ?>"><span id="elh_entidades_fecalta" class="entidades_fecalta"><?= $Page->fecalta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_entidades_usuario" class="entidades_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contacto->Visible) { // contacto ?>
        <th class="<?= $Page->contacto->headerCellClass() ?>"><span id="elh_entidades_contacto" class="entidades_contacto"><?= $Page->contacto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mailcont->Visible) { // mailcont ?>
        <th class="<?= $Page->mailcont->headerCellClass() ?>"><span id="elh_entidades_mailcont" class="entidades_mailcont"><?= $Page->mailcont->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <th class="<?= $Page->cargo->headerCellClass() ?>"><span id="elh_entidades_cargo" class="entidades_cargo"><?= $Page->cargo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><span id="elh_entidades_fechahora" class="entidades_fechahora"><?= $Page->fechahora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_entidades_activo" class="entidades_activo"><?= $Page->activo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pagweb->Visible) { // pagweb ?>
        <th class="<?= $Page->pagweb->headerCellClass() ?>"><span id="elh_entidades_pagweb" class="entidades_pagweb"><?= $Page->pagweb->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
        <th class="<?= $Page->tipoind->headerCellClass() ?>"><span id="elh_entidades_tipoind" class="entidades_tipoind"><?= $Page->tipoind->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th class="<?= $Page->usuarioultmod->headerCellClass() ?>"><span id="elh_entidades_usuarioultmod" class="entidades_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th class="<?= $Page->fecultmod->headerCellClass() ?>"><span id="elh_entidades_fecultmod" class="entidades_fecultmod"><?= $Page->fecultmod->caption() ?></span></th>
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
<?php if ($Page->razsoc->Visible) { // razsoc ?>
        <td<?= $Page->razsoc->cellAttributes() ?>>
<span id="">
<span<?= $Page->razsoc->viewAttributes() ?>>
<?= $Page->razsoc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
        <td<?= $Page->calle->cellAttributes() ?>>
<span id="">
<span<?= $Page->calle->viewAttributes() ?>>
<?= $Page->calle->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->numero->Visible) { // numero ?>
        <td<?= $Page->numero->cellAttributes() ?>>
<span id="">
<span<?= $Page->numero->viewAttributes() ?>>
<?= $Page->numero->getViewValue() ?></span>
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
<?php if ($Page->codpost->Visible) { // codpost ?>
        <td<?= $Page->codpost->cellAttributes() ?>>
<span id="">
<span<?= $Page->codpost->viewAttributes() ?>>
<?= $Page->codpost->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tellinea->Visible) { // tellinea ?>
        <td<?= $Page->tellinea->cellAttributes() ?>>
<span id="">
<span<?= $Page->tellinea->viewAttributes() ?>>
<?= $Page->tellinea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->telcelu->Visible) { // telcelu ?>
        <td<?= $Page->telcelu->cellAttributes() ?>>
<span id="">
<span<?= $Page->telcelu->viewAttributes() ?>>
<?= $Page->telcelu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipoent->Visible) { // tipoent ?>
        <td<?= $Page->tipoent->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipoent->viewAttributes() ?>>
<?= $Page->tipoent->getViewValue() ?></span>
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
<?php if ($Page->cuit->Visible) { // cuit ?>
        <td<?= $Page->cuit->cellAttributes() ?>>
<span id="">
<span<?= $Page->cuit->viewAttributes() ?>>
<?= $Page->cuit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->calif->Visible) { // calif ?>
        <td<?= $Page->calif->cellAttributes() ?>>
<span id="">
<span<?= $Page->calif->viewAttributes() ?>>
<?= $Page->calif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <td<?= $Page->fecalta->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
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
<?php if ($Page->contacto->Visible) { // contacto ?>
        <td<?= $Page->contacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->contacto->viewAttributes() ?>>
<?= $Page->contacto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mailcont->Visible) { // mailcont ?>
        <td<?= $Page->mailcont->cellAttributes() ?>>
<span id="">
<span<?= $Page->mailcont->viewAttributes() ?>>
<?= $Page->mailcont->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
        <td<?= $Page->cargo->cellAttributes() ?>>
<span id="">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
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
<?php if ($Page->activo->Visible) { // activo ?>
        <td<?= $Page->activo->cellAttributes() ?>>
<span id="">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pagweb->Visible) { // pagweb ?>
        <td<?= $Page->pagweb->cellAttributes() ?>>
<span id="">
<span<?= $Page->pagweb->viewAttributes() ?>>
<?= $Page->pagweb->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
        <td<?= $Page->tipoind->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipoind->viewAttributes() ?>>
<?= $Page->tipoind->getViewValue() ?></span>
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
