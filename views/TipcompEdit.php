<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$TipcompEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ftipcompedit" id="ftipcompedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipcomp: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ftipcompedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipcompedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null], fields.codnum.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid],
            ["esfactura", [fields.esfactura.visible && fields.esfactura.required ? ew.Validators.required(fields.esfactura.caption) : null], fields.esfactura.isInvalid],
            ["esprovedor", [fields.esprovedor.visible && fields.esprovedor.required ? ew.Validators.required(fields.esprovedor.caption) : null], fields.esprovedor.isInvalid],
            ["codafip", [fields.codafip.visible && fields.codafip.required ? ew.Validators.required(fields.codafip.caption) : null, ew.Validators.integer], fields.codafip.isInvalid],
            ["usuarioalta", [fields.usuarioalta.visible && fields.usuarioalta.required ? ew.Validators.required(fields.usuarioalta.caption) : null], fields.usuarioalta.isInvalid],
            ["fechaalta", [fields.fechaalta.visible && fields.fechaalta.required ? ew.Validators.required(fields.fechaalta.caption) : null], fields.fechaalta.isInvalid],
            ["usuariomod", [fields.usuariomod.visible && fields.usuariomod.required ? ew.Validators.required(fields.usuariomod.caption) : null], fields.usuariomod.isInvalid],
            ["fechaultmod", [fields.fechaultmod.visible && fields.fechaultmod.required ? ew.Validators.required(fields.fechaultmod.caption) : null], fields.fechaultmod.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "activo": <?= $Page->activo->toClientList($Page) ?>,
            "esfactura": <?= $Page->esfactura->toClientList($Page) ?>,
            "esprovedor": <?= $Page->esprovedor->toClientList($Page) ?>,
        })
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tipcomp">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codnum->Visible) { // codnum ?>
    <div id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <label id="elh_tipcomp_codnum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codnum->caption() ?><?= $Page->codnum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codnum->cellAttributes() ?>>
<span id="el_tipcomp_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codnum->getDisplayValue($Page->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="tipcomp" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <label id="elh_tipcomp_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_tipcomp_descripcion">
<input type="<?= $Page->descripcion->getInputTextType() ?>" name="x_descripcion" id="x_descripcion" data-table="tipcomp" data-field="x_descripcion" value="<?= $Page->descripcion->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion->formatPattern()) ?>"<?= $Page->descripcion->editAttributes() ?> aria-describedby="x_descripcion_help">
<?= $Page->descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_tipcomp_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_tipcomp_activo">
<template id="tp_x_activo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="tipcomp" data-field="x_activo" name="x_activo" id="x_activo"<?= $Page->activo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_activo" class="ew-item-list"></div>
<selection-list hidden
    id="x_activo"
    name="x_activo"
    value="<?= HtmlEncode($Page->activo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_activo"
    data-target="dsl_x_activo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->activo->isInvalidClass() ?>"
    data-table="tipcomp"
    data-field="x_activo"
    data-value-separator="<?= $Page->activo->displayValueSeparatorAttribute() ?>"
    <?= $Page->activo->editAttributes() ?>></selection-list>
<?= $Page->activo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->activo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->esfactura->Visible) { // esfactura ?>
    <div id="r_esfactura"<?= $Page->esfactura->rowAttributes() ?>>
        <label id="elh_tipcomp_esfactura" class="<?= $Page->LeftColumnClass ?>"><?= $Page->esfactura->caption() ?><?= $Page->esfactura->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->esfactura->cellAttributes() ?>>
<span id="el_tipcomp_esfactura">
<template id="tp_x_esfactura">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="tipcomp" data-field="x_esfactura" name="x_esfactura" id="x_esfactura"<?= $Page->esfactura->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_esfactura" class="ew-item-list"></div>
<selection-list hidden
    id="x_esfactura"
    name="x_esfactura"
    value="<?= HtmlEncode($Page->esfactura->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_esfactura"
    data-target="dsl_x_esfactura"
    data-repeatcolumn="5"
    class="form-control<?= $Page->esfactura->isInvalidClass() ?>"
    data-table="tipcomp"
    data-field="x_esfactura"
    data-value-separator="<?= $Page->esfactura->displayValueSeparatorAttribute() ?>"
    <?= $Page->esfactura->editAttributes() ?>></selection-list>
<?= $Page->esfactura->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->esfactura->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->esprovedor->Visible) { // esprovedor ?>
    <div id="r_esprovedor"<?= $Page->esprovedor->rowAttributes() ?>>
        <label id="elh_tipcomp_esprovedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->esprovedor->caption() ?><?= $Page->esprovedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->esprovedor->cellAttributes() ?>>
<span id="el_tipcomp_esprovedor">
<template id="tp_x_esprovedor">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="tipcomp" data-field="x_esprovedor" name="x_esprovedor" id="x_esprovedor"<?= $Page->esprovedor->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_esprovedor" class="ew-item-list"></div>
<selection-list hidden
    id="x_esprovedor"
    name="x_esprovedor"
    value="<?= HtmlEncode($Page->esprovedor->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_esprovedor"
    data-target="dsl_x_esprovedor"
    data-repeatcolumn="5"
    class="form-control<?= $Page->esprovedor->isInvalidClass() ?>"
    data-table="tipcomp"
    data-field="x_esprovedor"
    data-value-separator="<?= $Page->esprovedor->displayValueSeparatorAttribute() ?>"
    <?= $Page->esprovedor->editAttributes() ?>></selection-list>
<?= $Page->esprovedor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->esprovedor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codafip->Visible) { // codafip ?>
    <div id="r_codafip"<?= $Page->codafip->rowAttributes() ?>>
        <label id="elh_tipcomp_codafip" for="x_codafip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codafip->caption() ?><?= $Page->codafip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codafip->cellAttributes() ?>>
<span id="el_tipcomp_codafip">
<input type="<?= $Page->codafip->getInputTextType() ?>" name="x_codafip" id="x_codafip" data-table="tipcomp" data-field="x_codafip" value="<?= $Page->codafip->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codafip->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codafip->formatPattern()) ?>"<?= $Page->codafip->editAttributes() ?> aria-describedby="x_codafip_help">
<?= $Page->codafip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codafip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftipcompedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftipcompedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("tipcomp");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
