<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$TipoivaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ftipoivaedit" id="ftipoivaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipoiva: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ftipoivaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipoivaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null], fields.codnum.isInvalid],
            ["descor", [fields.descor.visible && fields.descor.required ? ew.Validators.required(fields.descor.caption) : null], fields.descor.isInvalid],
            ["descrip", [fields.descrip.visible && fields.descrip.required ? ew.Validators.required(fields.descrip.caption) : null], fields.descrip.isInvalid],
            ["discrimina", [fields.discrimina.visible && fields.discrimina.required ? ew.Validators.required(fields.discrimina.caption) : null], fields.discrimina.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid]
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
            "discrimina": <?= $Page->discrimina->toClientList($Page) ?>,
            "activo": <?= $Page->activo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="tipoiva">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codnum->Visible) { // codnum ?>
    <div id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <label id="elh_tipoiva_codnum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codnum->caption() ?><?= $Page->codnum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codnum->cellAttributes() ?>>
<span id="el_tipoiva_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codnum->getDisplayValue($Page->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="tipoiva" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descor->Visible) { // descor ?>
    <div id="r_descor"<?= $Page->descor->rowAttributes() ?>>
        <label id="elh_tipoiva_descor" for="x_descor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descor->caption() ?><?= $Page->descor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descor->cellAttributes() ?>>
<span id="el_tipoiva_descor">
<input type="<?= $Page->descor->getInputTextType() ?>" name="x_descor" id="x_descor" data-table="tipoiva" data-field="x_descor" value="<?= $Page->descor->EditValue ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->descor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descor->formatPattern()) ?>"<?= $Page->descor->editAttributes() ?> aria-describedby="x_descor_help">
<?= $Page->descor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
    <div id="r_descrip"<?= $Page->descrip->rowAttributes() ?>>
        <label id="elh_tipoiva_descrip" for="x_descrip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descrip->caption() ?><?= $Page->descrip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descrip->cellAttributes() ?>>
<span id="el_tipoiva_descrip">
<input type="<?= $Page->descrip->getInputTextType() ?>" name="x_descrip" id="x_descrip" data-table="tipoiva" data-field="x_descrip" value="<?= $Page->descrip->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->descrip->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descrip->formatPattern()) ?>"<?= $Page->descrip->editAttributes() ?> aria-describedby="x_descrip_help">
<?= $Page->descrip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descrip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->discrimina->Visible) { // discrimina ?>
    <div id="r_discrimina"<?= $Page->discrimina->rowAttributes() ?>>
        <label id="elh_tipoiva_discrimina" class="<?= $Page->LeftColumnClass ?>"><?= $Page->discrimina->caption() ?><?= $Page->discrimina->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->discrimina->cellAttributes() ?>>
<span id="el_tipoiva_discrimina">
<template id="tp_x_discrimina">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="tipoiva" data-field="x_discrimina" name="x_discrimina" id="x_discrimina"<?= $Page->discrimina->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_discrimina" class="ew-item-list"></div>
<selection-list hidden
    id="x_discrimina"
    name="x_discrimina"
    value="<?= HtmlEncode($Page->discrimina->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_discrimina"
    data-target="dsl_x_discrimina"
    data-repeatcolumn="5"
    class="form-control<?= $Page->discrimina->isInvalidClass() ?>"
    data-table="tipoiva"
    data-field="x_discrimina"
    data-value-separator="<?= $Page->discrimina->displayValueSeparatorAttribute() ?>"
    <?= $Page->discrimina->editAttributes() ?>></selection-list>
<?= $Page->discrimina->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->discrimina->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_tipoiva_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_tipoiva_activo">
<template id="tp_x_activo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="tipoiva" data-field="x_activo" name="x_activo" id="x_activo"<?= $Page->activo->editAttributes() ?>>
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
    data-table="tipoiva"
    data-field="x_activo"
    data-value-separator="<?= $Page->activo->displayValueSeparatorAttribute() ?>"
    <?= $Page->activo->editAttributes() ?>></selection-list>
<?= $Page->activo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->activo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftipoivaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftipoivaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("tipoiva");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
