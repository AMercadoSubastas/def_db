<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CabreciboDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabrecibo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcabrecibodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcabrecibodelete")
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
<form name="fcabrecibodelete" id="fcabrecibodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cabrecibo">
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><span id="elh_cabrecibo_codnum" class="cabrecibo_codnum"><?= $Page->codnum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><span id="elh_cabrecibo_tcomp" class="cabrecibo_tcomp"><?= $Page->tcomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><span id="elh_cabrecibo_serie" class="cabrecibo_serie"><?= $Page->serie->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><span id="elh_cabrecibo_ncomp" class="cabrecibo_ncomp"><?= $Page->ncomp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cantcbtes->Visible) { // cantcbtes ?>
        <th class="<?= $Page->cantcbtes->headerCellClass() ?>"><span id="elh_cabrecibo_cantcbtes" class="cabrecibo_cantcbtes"><?= $Page->cantcbtes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_cabrecibo_fecha" class="cabrecibo_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><span id="elh_cabrecibo_usuario" class="cabrecibo_usuario"><?= $Page->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><span id="elh_cabrecibo_fechahora" class="cabrecibo_fechahora"><?= $Page->fechahora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <th class="<?= $Page->cliente->headerCellClass() ?>"><span id="elh_cabrecibo_cliente" class="cabrecibo_cliente"><?= $Page->cliente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->imptot->Visible) { // imptot ?>
        <th class="<?= $Page->imptot->headerCellClass() ?>"><span id="elh_cabrecibo_imptot" class="cabrecibo_imptot"><?= $Page->imptot->caption() ?></span></th>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
        <th class="<?= $Page->emitido->headerCellClass() ?>"><span id="elh_cabrecibo_emitido" class="cabrecibo_emitido"><?= $Page->emitido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <th class="<?= $Page->usuarioultmod->headerCellClass() ?>"><span id="elh_cabrecibo_usuarioultmod" class="cabrecibo_usuarioultmod"><?= $Page->usuarioultmod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <th class="<?= $Page->fecultmod->headerCellClass() ?>"><span id="elh_cabrecibo_fecultmod" class="cabrecibo_fecultmod"><?= $Page->fecultmod->caption() ?></span></th>
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
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <td<?= $Page->tcomp->cellAttributes() ?>>
<span id="">
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <td<?= $Page->serie->cellAttributes() ?>>
<span id="">
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <td<?= $Page->ncomp->cellAttributes() ?>>
<span id="">
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cantcbtes->Visible) { // cantcbtes ?>
        <td<?= $Page->cantcbtes->cellAttributes() ?>>
<span id="">
<span<?= $Page->cantcbtes->viewAttributes() ?>>
<?= $Page->cantcbtes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <td<?= $Page->fecha->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
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
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <td<?= $Page->fechahora->cellAttributes() ?>>
<span id="">
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
        <td<?= $Page->cliente->cellAttributes() ?>>
<span id="">
<span<?= $Page->cliente->viewAttributes() ?>>
<?= $Page->cliente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->imptot->Visible) { // imptot ?>
        <td<?= $Page->imptot->cellAttributes() ?>>
<span id="">
<span<?= $Page->imptot->viewAttributes() ?>>
<?= $Page->imptot->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
        <td<?= $Page->emitido->cellAttributes() ?>>
<span id="">
<span<?= $Page->emitido->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($Page->emitido->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
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
