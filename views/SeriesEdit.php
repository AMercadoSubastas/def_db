<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$SeriesEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fseriesedit" id="fseriesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { series: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fseriesedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fseriesedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null], fields.codnum.isInvalid],
            ["tipcomp", [fields.tipcomp.visible && fields.tipcomp.required ? ew.Validators.required(fields.tipcomp.caption) : null], fields.tipcomp.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["nrodesde", [fields.nrodesde.visible && fields.nrodesde.required ? ew.Validators.required(fields.nrodesde.caption) : null, ew.Validators.integer], fields.nrodesde.isInvalid],
            ["nrohasta", [fields.nrohasta.visible && fields.nrohasta.required ? ew.Validators.required(fields.nrohasta.caption) : null, ew.Validators.integer], fields.nrohasta.isInvalid],
            ["nroact", [fields.nroact.visible && fields.nroact.required ? ew.Validators.required(fields.nroact.caption) : null, ew.Validators.integer], fields.nroact.isInvalid],
            ["mascara", [fields.mascara.visible && fields.mascara.required ? ew.Validators.required(fields.mascara.caption) : null], fields.mascara.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid],
            ["automatica", [fields.automatica.visible && fields.automatica.required ? ew.Validators.required(fields.automatica.caption) : null], fields.automatica.isInvalid],
            ["fechatope", [fields.fechatope.visible && fields.fechatope.required ? ew.Validators.required(fields.fechatope.caption) : null, ew.Validators.datetime(fields.fechatope.clientFormatPattern)], fields.fechatope.isInvalid]
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
            "tipcomp": <?= $Page->tipcomp->toClientList($Page) ?>,
            "activo": <?= $Page->activo->toClientList($Page) ?>,
            "automatica": <?= $Page->automatica->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="series">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codnum->Visible) { // codnum ?>
    <div id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <label id="elh_series_codnum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codnum->caption() ?><?= $Page->codnum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codnum->cellAttributes() ?>>
<span id="el_series_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codnum->getDisplayValue($Page->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="series" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipcomp->Visible) { // tipcomp ?>
    <div id="r_tipcomp"<?= $Page->tipcomp->rowAttributes() ?>>
        <label id="elh_series_tipcomp" for="x_tipcomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipcomp->caption() ?><?= $Page->tipcomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipcomp->cellAttributes() ?>>
<span id="el_series_tipcomp">
    <select
        id="x_tipcomp"
        name="x_tipcomp"
        class="form-select ew-select<?= $Page->tipcomp->isInvalidClass() ?>"
        <?php if (!$Page->tipcomp->IsNativeSelect) { ?>
        data-select2-id="fseriesedit_x_tipcomp"
        <?php } ?>
        data-table="series"
        data-field="x_tipcomp"
        data-value-separator="<?= $Page->tipcomp->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipcomp->getPlaceHolder()) ?>"
        <?= $Page->tipcomp->editAttributes() ?>>
        <?= $Page->tipcomp->selectOptionListHtml("x_tipcomp") ?>
    </select>
    <?= $Page->tipcomp->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipcomp->getErrorMessage() ?></div>
<?= $Page->tipcomp->Lookup->getParamTag($Page, "p_x_tipcomp") ?>
<?php if (!$Page->tipcomp->IsNativeSelect) { ?>
<script>
loadjs.ready("fseriesedit", function() {
    var options = { name: "x_tipcomp", selectId: "fseriesedit_x_tipcomp" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fseriesedit.lists.tipcomp?.lookupOptions.length) {
        options.data = { id: "x_tipcomp", form: "fseriesedit" };
    } else {
        options.ajax = { id: "x_tipcomp", form: "fseriesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.series.fields.tipcomp.selectOptions);
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
        <label id="elh_series_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_series_descripcion">
<input type="<?= $Page->descripcion->getInputTextType() ?>" name="x_descripcion" id="x_descripcion" data-table="series" data-field="x_descripcion" value="<?= $Page->descripcion->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion->formatPattern()) ?>"<?= $Page->descripcion->editAttributes() ?> aria-describedby="x_descripcion_help">
<?= $Page->descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrodesde->Visible) { // nrodesde ?>
    <div id="r_nrodesde"<?= $Page->nrodesde->rowAttributes() ?>>
        <label id="elh_series_nrodesde" for="x_nrodesde" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrodesde->caption() ?><?= $Page->nrodesde->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nrodesde->cellAttributes() ?>>
<span id="el_series_nrodesde">
<input type="<?= $Page->nrodesde->getInputTextType() ?>" name="x_nrodesde" id="x_nrodesde" data-table="series" data-field="x_nrodesde" value="<?= $Page->nrodesde->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nrodesde->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nrodesde->formatPattern()) ?>"<?= $Page->nrodesde->editAttributes() ?> aria-describedby="x_nrodesde_help">
<?= $Page->nrodesde->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nrodesde->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrohasta->Visible) { // nrohasta ?>
    <div id="r_nrohasta"<?= $Page->nrohasta->rowAttributes() ?>>
        <label id="elh_series_nrohasta" for="x_nrohasta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrohasta->caption() ?><?= $Page->nrohasta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nrohasta->cellAttributes() ?>>
<span id="el_series_nrohasta">
<input type="<?= $Page->nrohasta->getInputTextType() ?>" name="x_nrohasta" id="x_nrohasta" data-table="series" data-field="x_nrohasta" value="<?= $Page->nrohasta->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nrohasta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nrohasta->formatPattern()) ?>"<?= $Page->nrohasta->editAttributes() ?> aria-describedby="x_nrohasta_help">
<?= $Page->nrohasta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nrohasta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nroact->Visible) { // nroact ?>
    <div id="r_nroact"<?= $Page->nroact->rowAttributes() ?>>
        <label id="elh_series_nroact" for="x_nroact" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nroact->caption() ?><?= $Page->nroact->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nroact->cellAttributes() ?>>
<span id="el_series_nroact">
<input type="<?= $Page->nroact->getInputTextType() ?>" name="x_nroact" id="x_nroact" data-table="series" data-field="x_nroact" value="<?= $Page->nroact->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nroact->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nroact->formatPattern()) ?>"<?= $Page->nroact->editAttributes() ?> aria-describedby="x_nroact_help">
<?= $Page->nroact->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nroact->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mascara->Visible) { // mascara ?>
    <div id="r_mascara"<?= $Page->mascara->rowAttributes() ?>>
        <label id="elh_series_mascara" for="x_mascara" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mascara->caption() ?><?= $Page->mascara->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mascara->cellAttributes() ?>>
<span id="el_series_mascara">
<input type="<?= $Page->mascara->getInputTextType() ?>" name="x_mascara" id="x_mascara" data-table="series" data-field="x_mascara" value="<?= $Page->mascara->EditValue ?>" size="30" maxlength="6" placeholder="<?= HtmlEncode($Page->mascara->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->mascara->formatPattern()) ?>"<?= $Page->mascara->editAttributes() ?> aria-describedby="x_mascara_help">
<?= $Page->mascara->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mascara->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_series_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_series_activo">
<template id="tp_x_activo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="series" data-field="x_activo" name="x_activo" id="x_activo"<?= $Page->activo->editAttributes() ?>>
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
    data-table="series"
    data-field="x_activo"
    data-value-separator="<?= $Page->activo->displayValueSeparatorAttribute() ?>"
    <?= $Page->activo->editAttributes() ?>></selection-list>
<?= $Page->activo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->activo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->automatica->Visible) { // automatica ?>
    <div id="r_automatica"<?= $Page->automatica->rowAttributes() ?>>
        <label id="elh_series_automatica" class="<?= $Page->LeftColumnClass ?>"><?= $Page->automatica->caption() ?><?= $Page->automatica->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->automatica->cellAttributes() ?>>
<span id="el_series_automatica">
<template id="tp_x_automatica">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="series" data-field="x_automatica" name="x_automatica" id="x_automatica"<?= $Page->automatica->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_automatica" class="ew-item-list"></div>
<selection-list hidden
    id="x_automatica"
    name="x_automatica"
    value="<?= HtmlEncode($Page->automatica->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_automatica"
    data-target="dsl_x_automatica"
    data-repeatcolumn="5"
    class="form-control<?= $Page->automatica->isInvalidClass() ?>"
    data-table="series"
    data-field="x_automatica"
    data-value-separator="<?= $Page->automatica->displayValueSeparatorAttribute() ?>"
    <?= $Page->automatica->editAttributes() ?>></selection-list>
<?= $Page->automatica->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->automatica->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechatope->Visible) { // fechatope ?>
    <div id="r_fechatope"<?= $Page->fechatope->rowAttributes() ?>>
        <label id="elh_series_fechatope" for="x_fechatope" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechatope->caption() ?><?= $Page->fechatope->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechatope->cellAttributes() ?>>
<span id="el_series_fechatope">
<input type="<?= $Page->fechatope->getInputTextType() ?>" name="x_fechatope" id="x_fechatope" data-table="series" data-field="x_fechatope" value="<?= $Page->fechatope->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->fechatope->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechatope->formatPattern()) ?>"<?= $Page->fechatope->editAttributes() ?> aria-describedby="x_fechatope_help">
<?= $Page->fechatope->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechatope->getErrorMessage() ?></div>
<?php if (!$Page->fechatope->ReadOnly && !$Page->fechatope->Disabled && !isset($Page->fechatope->EditAttrs["readonly"]) && !isset($Page->fechatope->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fseriesedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fseriesedit", "x_fechatope", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fseriesedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fseriesedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("series");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
