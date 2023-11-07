<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LocalidadesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { localidades: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var flocalidadesadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flocalidadesadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["codpais", [fields.codpais.visible && fields.codpais.required ? ew.Validators.required(fields.codpais.caption) : null], fields.codpais.isInvalid],
            ["codprov", [fields.codprov.visible && fields.codprov.required ? ew.Validators.required(fields.codprov.caption) : null], fields.codprov.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
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
            "codpais": <?= $Page->codpais->toClientList($Page) ?>,
            "codprov": <?= $Page->codprov->toClientList($Page) ?>,
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
<form name="flocalidadesadd" id="flocalidadesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="localidades">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->codpais->Visible) { // codpais ?>
    <div id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <label id="elh_localidades_codpais" for="x_codpais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpais->caption() ?><?= $Page->codpais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpais->cellAttributes() ?>>
<span id="el_localidades_codpais">
    <select
        id="x_codpais"
        name="x_codpais"
        class="form-select ew-select<?= $Page->codpais->isInvalidClass() ?>"
        <?php if (!$Page->codpais->IsNativeSelect) { ?>
        data-select2-id="flocalidadesadd_x_codpais"
        <?php } ?>
        data-table="localidades"
        data-field="x_codpais"
        data-value-separator="<?= $Page->codpais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codpais->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->codpais->editAttributes() ?>>
        <?= $Page->codpais->selectOptionListHtml("x_codpais") ?>
    </select>
    <?= $Page->codpais->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codpais->getErrorMessage() ?></div>
<?= $Page->codpais->Lookup->getParamTag($Page, "p_x_codpais") ?>
<?php if (!$Page->codpais->IsNativeSelect) { ?>
<script>
loadjs.ready("flocalidadesadd", function() {
    var options = { name: "x_codpais", selectId: "flocalidadesadd_x_codpais" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flocalidadesadd.lists.codpais?.lookupOptions.length) {
        options.data = { id: "x_codpais", form: "flocalidadesadd" };
    } else {
        options.ajax = { id: "x_codpais", form: "flocalidadesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.localidades.fields.codpais.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
    <div id="r_codprov"<?= $Page->codprov->rowAttributes() ?>>
        <label id="elh_localidades_codprov" for="x_codprov" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codprov->caption() ?><?= $Page->codprov->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codprov->cellAttributes() ?>>
<span id="el_localidades_codprov">
    <select
        id="x_codprov"
        name="x_codprov"
        class="form-select ew-select<?= $Page->codprov->isInvalidClass() ?>"
        <?php if (!$Page->codprov->IsNativeSelect) { ?>
        data-select2-id="flocalidadesadd_x_codprov"
        <?php } ?>
        data-table="localidades"
        data-field="x_codprov"
        data-value-separator="<?= $Page->codprov->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codprov->getPlaceHolder()) ?>"
        <?= $Page->codprov->editAttributes() ?>>
        <?= $Page->codprov->selectOptionListHtml("x_codprov") ?>
    </select>
    <?= $Page->codprov->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codprov->getErrorMessage() ?></div>
<?= $Page->codprov->Lookup->getParamTag($Page, "p_x_codprov") ?>
<?php if (!$Page->codprov->IsNativeSelect) { ?>
<script>
loadjs.ready("flocalidadesadd", function() {
    var options = { name: "x_codprov", selectId: "flocalidadesadd_x_codprov" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flocalidadesadd.lists.codprov?.lookupOptions.length) {
        options.data = { id: "x_codprov", form: "flocalidadesadd" };
    } else {
        options.ajax = { id: "x_codprov", form: "flocalidadesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.localidades.fields.codprov.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <label id="elh_localidades_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_localidades_descripcion">
<input type="<?= $Page->descripcion->getInputTextType() ?>" name="x_descripcion" id="x_descripcion" data-table="localidades" data-field="x_descripcion" value="<?= $Page->descripcion->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion->formatPattern()) ?>"<?= $Page->descripcion->editAttributes() ?> aria-describedby="x_descripcion_help">
<?= $Page->descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_localidades_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_localidades_activo">
<template id="tp_x_activo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="localidades" data-field="x_activo" name="x_activo" id="x_activo"<?= $Page->activo->editAttributes() ?>>
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
    data-table="localidades"
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="flocalidadesadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="flocalidadesadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("localidades");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
