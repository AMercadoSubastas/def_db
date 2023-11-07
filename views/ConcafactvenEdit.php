<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$ConcafactvenEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fconcafactvenedit" id="fconcafactvenedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { concafactven: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fconcafactvenedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fconcafactvenedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null], fields.codnum.isInvalid],
            ["nroconc", [fields.nroconc.visible && fields.nroconc.required ? ew.Validators.required(fields.nroconc.caption) : null, ew.Validators.integer], fields.nroconc.isInvalid],
            ["descrip", [fields.descrip.visible && fields.descrip.required ? ew.Validators.required(fields.descrip.caption) : null], fields.descrip.isInvalid],
            ["porcentaje", [fields.porcentaje.visible && fields.porcentaje.required ? ew.Validators.required(fields.porcentaje.caption) : null, ew.Validators.float], fields.porcentaje.isInvalid],
            ["importe", [fields.importe.visible && fields.importe.required ? ew.Validators.required(fields.importe.caption) : null, ew.Validators.float], fields.importe.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null, ew.Validators.datetime(fields.fechahora.clientFormatPattern)], fields.fechahora.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid],
            ["tipoiva", [fields.tipoiva.visible && fields.tipoiva.required ? ew.Validators.required(fields.tipoiva.caption) : null, ew.Validators.integer], fields.tipoiva.isInvalid],
            ["impuesto", [fields.impuesto.visible && fields.impuesto.required ? ew.Validators.required(fields.impuesto.caption) : null, ew.Validators.integer], fields.impuesto.isInvalid],
            ["tieneresol", [fields.tieneresol.visible && fields.tieneresol.required ? ew.Validators.required(fields.tieneresol.caption) : null], fields.tieneresol.isInvalid],
            ["ctacbleBAS", [fields.ctacbleBAS.visible && fields.ctacbleBAS.required ? ew.Validators.required(fields.ctacbleBAS.caption) : null], fields.ctacbleBAS.isInvalid]
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
            "tipoiva": <?= $Page->tipoiva->toClientList($Page) ?>,
            "impuesto": <?= $Page->impuesto->toClientList($Page) ?>,
            "tieneresol": <?= $Page->tieneresol->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="concafactven">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codnum->Visible) { // codnum ?>
    <div id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <label id="elh_concafactven_codnum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codnum->caption() ?><?= $Page->codnum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codnum->cellAttributes() ?>>
<span id="el_concafactven_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codnum->getDisplayValue($Page->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="concafactven" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nroconc->Visible) { // nroconc ?>
    <div id="r_nroconc"<?= $Page->nroconc->rowAttributes() ?>>
        <label id="elh_concafactven_nroconc" for="x_nroconc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nroconc->caption() ?><?= $Page->nroconc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nroconc->cellAttributes() ?>>
<span id="el_concafactven_nroconc">
<input type="<?= $Page->nroconc->getInputTextType() ?>" name="x_nroconc" id="x_nroconc" data-table="concafactven" data-field="x_nroconc" value="<?= $Page->nroconc->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nroconc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nroconc->formatPattern()) ?>"<?= $Page->nroconc->editAttributes() ?> aria-describedby="x_nroconc_help">
<?= $Page->nroconc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nroconc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
    <div id="r_descrip"<?= $Page->descrip->rowAttributes() ?>>
        <label id="elh_concafactven_descrip" for="x_descrip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descrip->caption() ?><?= $Page->descrip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descrip->cellAttributes() ?>>
<span id="el_concafactven_descrip">
<input type="<?= $Page->descrip->getInputTextType() ?>" name="x_descrip" id="x_descrip" data-table="concafactven" data-field="x_descrip" value="<?= $Page->descrip->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->descrip->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descrip->formatPattern()) ?>"<?= $Page->descrip->editAttributes() ?> aria-describedby="x_descrip_help">
<?= $Page->descrip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descrip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
    <div id="r_porcentaje"<?= $Page->porcentaje->rowAttributes() ?>>
        <label id="elh_concafactven_porcentaje" for="x_porcentaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->porcentaje->caption() ?><?= $Page->porcentaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->porcentaje->cellAttributes() ?>>
<span id="el_concafactven_porcentaje">
<input type="<?= $Page->porcentaje->getInputTextType() ?>" name="x_porcentaje" id="x_porcentaje" data-table="concafactven" data-field="x_porcentaje" value="<?= $Page->porcentaje->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->porcentaje->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentaje->formatPattern()) ?>"<?= $Page->porcentaje->editAttributes() ?> aria-describedby="x_porcentaje_help">
<?= $Page->porcentaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->porcentaje->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->importe->Visible) { // importe ?>
    <div id="r_importe"<?= $Page->importe->rowAttributes() ?>>
        <label id="elh_concafactven_importe" for="x_importe" class="<?= $Page->LeftColumnClass ?>"><?= $Page->importe->caption() ?><?= $Page->importe->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->importe->cellAttributes() ?>>
<span id="el_concafactven_importe">
<input type="<?= $Page->importe->getInputTextType() ?>" name="x_importe" id="x_importe" data-table="concafactven" data-field="x_importe" value="<?= $Page->importe->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->importe->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->importe->formatPattern()) ?>"<?= $Page->importe->editAttributes() ?> aria-describedby="x_importe_help">
<?= $Page->importe->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->importe->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <div id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <label id="elh_concafactven_fechahora" for="x_fechahora" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechahora->caption() ?><?= $Page->fechahora->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_concafactven_fechahora">
<input type="<?= $Page->fechahora->getInputTextType() ?>" name="x_fechahora" id="x_fechahora" data-table="concafactven" data-field="x_fechahora" value="<?= $Page->fechahora->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechahora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechahora->formatPattern()) ?>"<?= $Page->fechahora->editAttributes() ?> aria-describedby="x_fechahora_help">
<?= $Page->fechahora->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechahora->getErrorMessage() ?></div>
<?php if (!$Page->fechahora->ReadOnly && !$Page->fechahora->Disabled && !isset($Page->fechahora->EditAttrs["readonly"]) && !isset($Page->fechahora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fconcafactvenedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fconcafactvenedit", "x_fechahora", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_concafactven_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_concafactven_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fconcafactvenedit_x_activo"
        <?php } ?>
        data-table="concafactven"
        data-field="x_activo"
        data-value-separator="<?= $Page->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->activo->getPlaceHolder()) ?>"
        <?= $Page->activo->editAttributes() ?>>
        <?= $Page->activo->selectOptionListHtml("x_activo") ?>
    </select>
    <?= $Page->activo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->activo->getErrorMessage() ?></div>
<?php if (!$Page->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fconcafactvenedit", function() {
    var options = { name: "x_activo", selectId: "fconcafactvenedit_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fconcafactvenedit.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fconcafactvenedit" };
    } else {
        options.ajax = { id: "x_activo", form: "fconcafactvenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.concafactven.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
    <div id="r_tipoiva"<?= $Page->tipoiva->rowAttributes() ?>>
        <label id="elh_concafactven_tipoiva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipoiva->caption() ?><?= $Page->tipoiva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el_concafactven_tipoiva">
<?php
if (IsRTL()) {
    $Page->tipoiva->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_tipoiva" class="ew-auto-suggest">
    <input type="<?= $Page->tipoiva->getInputTextType() ?>" class="form-control" name="sv_x_tipoiva" id="sv_x_tipoiva" value="<?= RemoveHtml($Page->tipoiva->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->tipoiva->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->tipoiva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipoiva->formatPattern()) ?>"<?= $Page->tipoiva->editAttributes() ?> aria-describedby="x_tipoiva_help">
</span>
<selection-list hidden class="form-control" data-table="concafactven" data-field="x_tipoiva" data-input="sv_x_tipoiva" data-value-separator="<?= $Page->tipoiva->displayValueSeparatorAttribute() ?>" name="x_tipoiva" id="x_tipoiva" value="<?= HtmlEncode($Page->tipoiva->CurrentValue) ?>"></selection-list>
<?= $Page->tipoiva->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipoiva->getErrorMessage() ?></div>
<script>
loadjs.ready("fconcafactvenedit", function() {
    fconcafactvenedit.createAutoSuggest(Object.assign({"id":"x_tipoiva","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->tipoiva->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.concafactven.fields.tipoiva.autoSuggestOptions));
});
</script>
<?= $Page->tipoiva->Lookup->getParamTag($Page, "p_x_tipoiva") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->impuesto->Visible) { // impuesto ?>
    <div id="r_impuesto"<?= $Page->impuesto->rowAttributes() ?>>
        <label id="elh_concafactven_impuesto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->impuesto->caption() ?><?= $Page->impuesto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->impuesto->cellAttributes() ?>>
<span id="el_concafactven_impuesto">
<?php
if (IsRTL()) {
    $Page->impuesto->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_impuesto" class="ew-auto-suggest">
    <input type="<?= $Page->impuesto->getInputTextType() ?>" class="form-control" name="sv_x_impuesto" id="sv_x_impuesto" value="<?= RemoveHtml($Page->impuesto->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->impuesto->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->impuesto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->impuesto->formatPattern()) ?>"<?= $Page->impuesto->editAttributes() ?> aria-describedby="x_impuesto_help">
</span>
<selection-list hidden class="form-control" data-table="concafactven" data-field="x_impuesto" data-input="sv_x_impuesto" data-value-separator="<?= $Page->impuesto->displayValueSeparatorAttribute() ?>" name="x_impuesto" id="x_impuesto" value="<?= HtmlEncode($Page->impuesto->CurrentValue) ?>"></selection-list>
<?= $Page->impuesto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->impuesto->getErrorMessage() ?></div>
<script>
loadjs.ready("fconcafactvenedit", function() {
    fconcafactvenedit.createAutoSuggest(Object.assign({"id":"x_impuesto","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->impuesto->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.concafactven.fields.impuesto.autoSuggestOptions));
});
</script>
<?= $Page->impuesto->Lookup->getParamTag($Page, "p_x_impuesto") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
    <div id="r_tieneresol"<?= $Page->tieneresol->rowAttributes() ?>>
        <label id="elh_concafactven_tieneresol" for="x_tieneresol" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tieneresol->caption() ?><?= $Page->tieneresol->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tieneresol->cellAttributes() ?>>
<span id="el_concafactven_tieneresol">
    <select
        id="x_tieneresol"
        name="x_tieneresol"
        class="form-select ew-select<?= $Page->tieneresol->isInvalidClass() ?>"
        <?php if (!$Page->tieneresol->IsNativeSelect) { ?>
        data-select2-id="fconcafactvenedit_x_tieneresol"
        <?php } ?>
        data-table="concafactven"
        data-field="x_tieneresol"
        data-value-separator="<?= $Page->tieneresol->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tieneresol->getPlaceHolder()) ?>"
        <?= $Page->tieneresol->editAttributes() ?>>
        <?= $Page->tieneresol->selectOptionListHtml("x_tieneresol") ?>
    </select>
    <?= $Page->tieneresol->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tieneresol->getErrorMessage() ?></div>
<?php if (!$Page->tieneresol->IsNativeSelect) { ?>
<script>
loadjs.ready("fconcafactvenedit", function() {
    var options = { name: "x_tieneresol", selectId: "fconcafactvenedit_x_tieneresol" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fconcafactvenedit.lists.tieneresol?.lookupOptions.length) {
        options.data = { id: "x_tieneresol", form: "fconcafactvenedit" };
    } else {
        options.ajax = { id: "x_tieneresol", form: "fconcafactvenedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.concafactven.fields.tieneresol.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ctacbleBAS->Visible) { // ctacbleBAS ?>
    <div id="r_ctacbleBAS"<?= $Page->ctacbleBAS->rowAttributes() ?>>
        <label id="elh_concafactven_ctacbleBAS" for="x_ctacbleBAS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ctacbleBAS->caption() ?><?= $Page->ctacbleBAS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ctacbleBAS->cellAttributes() ?>>
<span id="el_concafactven_ctacbleBAS">
<input type="<?= $Page->ctacbleBAS->getInputTextType() ?>" name="x_ctacbleBAS" id="x_ctacbleBAS" data-table="concafactven" data-field="x_ctacbleBAS" value="<?= $Page->ctacbleBAS->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Page->ctacbleBAS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ctacbleBAS->formatPattern()) ?>"<?= $Page->ctacbleBAS->editAttributes() ?> aria-describedby="x_ctacbleBAS_help">
<?= $Page->ctacbleBAS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ctacbleBAS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fconcafactvenedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fconcafactvenedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("concafactven");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
