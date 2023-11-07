<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$ImprangosAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { imprangos: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fimprangosadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fimprangosadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["codimp", [fields.codimp.visible && fields.codimp.required ? ew.Validators.required(fields.codimp.caption) : null], fields.codimp.isInvalid],
            ["secuencia", [fields.secuencia.visible && fields.secuencia.required ? ew.Validators.required(fields.secuencia.caption) : null, ew.Validators.integer], fields.secuencia.isInvalid],
            ["monto_min", [fields.monto_min.visible && fields.monto_min.required ? ew.Validators.required(fields.monto_min.caption) : null, ew.Validators.float], fields.monto_min.isInvalid],
            ["monto_max", [fields.monto_max.visible && fields.monto_max.required ? ew.Validators.required(fields.monto_max.caption) : null, ew.Validators.float], fields.monto_max.isInvalid],
            ["porcentaje", [fields.porcentaje.visible && fields.porcentaje.required ? ew.Validators.required(fields.porcentaje.caption) : null, ew.Validators.float], fields.porcentaje.isInvalid],
            ["monto_fijo", [fields.monto_fijo.visible && fields.monto_fijo.required ? ew.Validators.required(fields.monto_fijo.caption) : null, ew.Validators.float], fields.monto_fijo.isInvalid],
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
            "codimp": <?= $Page->codimp->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fimprangosadd" id="fimprangosadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="imprangos">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->codimp->Visible) { // codimp ?>
    <div id="r_codimp"<?= $Page->codimp->rowAttributes() ?>>
        <label id="elh_imprangos_codimp" for="x_codimp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codimp->caption() ?><?= $Page->codimp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codimp->cellAttributes() ?>>
<span id="el_imprangos_codimp">
    <select
        id="x_codimp"
        name="x_codimp"
        class="form-select ew-select<?= $Page->codimp->isInvalidClass() ?>"
        <?php if (!$Page->codimp->IsNativeSelect) { ?>
        data-select2-id="fimprangosadd_x_codimp"
        <?php } ?>
        data-table="imprangos"
        data-field="x_codimp"
        data-value-separator="<?= $Page->codimp->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codimp->getPlaceHolder()) ?>"
        <?= $Page->codimp->editAttributes() ?>>
        <?= $Page->codimp->selectOptionListHtml("x_codimp") ?>
    </select>
    <?= $Page->codimp->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codimp->getErrorMessage() ?></div>
<?= $Page->codimp->Lookup->getParamTag($Page, "p_x_codimp") ?>
<?php if (!$Page->codimp->IsNativeSelect) { ?>
<script>
loadjs.ready("fimprangosadd", function() {
    var options = { name: "x_codimp", selectId: "fimprangosadd_x_codimp" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fimprangosadd.lists.codimp?.lookupOptions.length) {
        options.data = { id: "x_codimp", form: "fimprangosadd" };
    } else {
        options.ajax = { id: "x_codimp", form: "fimprangosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.imprangos.fields.codimp.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
    <div id="r_secuencia"<?= $Page->secuencia->rowAttributes() ?>>
        <label id="elh_imprangos_secuencia" for="x_secuencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->secuencia->caption() ?><?= $Page->secuencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->secuencia->cellAttributes() ?>>
<span id="el_imprangos_secuencia">
<input type="<?= $Page->secuencia->getInputTextType() ?>" name="x_secuencia" id="x_secuencia" data-table="imprangos" data-field="x_secuencia" value="<?= $Page->secuencia->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->secuencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->secuencia->formatPattern()) ?>"<?= $Page->secuencia->editAttributes() ?> aria-describedby="x_secuencia_help">
<?= $Page->secuencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->secuencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto_min->Visible) { // monto_min ?>
    <div id="r_monto_min"<?= $Page->monto_min->rowAttributes() ?>>
        <label id="elh_imprangos_monto_min" for="x_monto_min" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto_min->caption() ?><?= $Page->monto_min->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto_min->cellAttributes() ?>>
<span id="el_imprangos_monto_min">
<input type="<?= $Page->monto_min->getInputTextType() ?>" name="x_monto_min" id="x_monto_min" data-table="imprangos" data-field="x_monto_min" value="<?= $Page->monto_min->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monto_min->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto_min->formatPattern()) ?>"<?= $Page->monto_min->editAttributes() ?> aria-describedby="x_monto_min_help">
<?= $Page->monto_min->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto_min->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto_max->Visible) { // monto_max ?>
    <div id="r_monto_max"<?= $Page->monto_max->rowAttributes() ?>>
        <label id="elh_imprangos_monto_max" for="x_monto_max" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto_max->caption() ?><?= $Page->monto_max->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto_max->cellAttributes() ?>>
<span id="el_imprangos_monto_max">
<input type="<?= $Page->monto_max->getInputTextType() ?>" name="x_monto_max" id="x_monto_max" data-table="imprangos" data-field="x_monto_max" value="<?= $Page->monto_max->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monto_max->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto_max->formatPattern()) ?>"<?= $Page->monto_max->editAttributes() ?> aria-describedby="x_monto_max_help">
<?= $Page->monto_max->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto_max->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
    <div id="r_porcentaje"<?= $Page->porcentaje->rowAttributes() ?>>
        <label id="elh_imprangos_porcentaje" for="x_porcentaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->porcentaje->caption() ?><?= $Page->porcentaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->porcentaje->cellAttributes() ?>>
<span id="el_imprangos_porcentaje">
<input type="<?= $Page->porcentaje->getInputTextType() ?>" name="x_porcentaje" id="x_porcentaje" data-table="imprangos" data-field="x_porcentaje" value="<?= $Page->porcentaje->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->porcentaje->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentaje->formatPattern()) ?>"<?= $Page->porcentaje->editAttributes() ?> aria-describedby="x_porcentaje_help">
<?= $Page->porcentaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->porcentaje->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto_fijo->Visible) { // monto_fijo ?>
    <div id="r_monto_fijo"<?= $Page->monto_fijo->rowAttributes() ?>>
        <label id="elh_imprangos_monto_fijo" for="x_monto_fijo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto_fijo->caption() ?><?= $Page->monto_fijo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto_fijo->cellAttributes() ?>>
<span id="el_imprangos_monto_fijo">
<input type="<?= $Page->monto_fijo->getInputTextType() ?>" name="x_monto_fijo" id="x_monto_fijo" data-table="imprangos" data-field="x_monto_fijo" value="<?= $Page->monto_fijo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monto_fijo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto_fijo->formatPattern()) ?>"<?= $Page->monto_fijo->editAttributes() ?> aria-describedby="x_monto_fijo_help">
<?= $Page->monto_fijo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto_fijo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_imprangos_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_imprangos_activo">
<template id="tp_x_activo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="imprangos" data-field="x_activo" name="x_activo" id="x_activo"<?= $Page->activo->editAttributes() ?>>
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
    data-table="imprangos"
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fimprangosadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fimprangosadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("imprangos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
