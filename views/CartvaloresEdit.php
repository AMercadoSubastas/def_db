<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CartvaloresEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fcartvaloresedit" id="fcartvaloresedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cartvalores: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcartvaloresedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcartvaloresedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null], fields.codnum.isInvalid],
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null, ew.Validators.integer], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null, ew.Validators.integer], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["codban", [fields.codban.visible && fields.codban.required ? ew.Validators.required(fields.codban.caption) : null], fields.codban.isInvalid],
            ["codsuc", [fields.codsuc.visible && fields.codsuc.required ? ew.Validators.required(fields.codsuc.caption) : null], fields.codsuc.isInvalid],
            ["codcta", [fields.codcta.visible && fields.codcta.required ? ew.Validators.required(fields.codcta.caption) : null], fields.codcta.isInvalid],
            ["tipcta", [fields.tipcta.visible && fields.tipcta.required ? ew.Validators.required(fields.tipcta.caption) : null], fields.tipcta.isInvalid],
            ["codchq", [fields.codchq.visible && fields.codchq.required ? ew.Validators.required(fields.codchq.caption) : null], fields.codchq.isInvalid],
            ["codpais", [fields.codpais.visible && fields.codpais.required ? ew.Validators.required(fields.codpais.caption) : null], fields.codpais.isInvalid],
            ["importe", [fields.importe.visible && fields.importe.required ? ew.Validators.required(fields.importe.caption) : null, ew.Validators.float], fields.importe.isInvalid],
            ["fechaemis", [fields.fechaemis.visible && fields.fechaemis.required ? ew.Validators.required(fields.fechaemis.caption) : null, ew.Validators.datetime(fields.fechaemis.clientFormatPattern)], fields.fechaemis.isInvalid],
            ["fechapago", [fields.fechapago.visible && fields.fechapago.required ? ew.Validators.required(fields.fechapago.caption) : null, ew.Validators.datetime(fields.fechapago.clientFormatPattern)], fields.fechapago.isInvalid],
            ["entrego", [fields.entrego.visible && fields.entrego.required ? ew.Validators.required(fields.entrego.caption) : null, ew.Validators.integer], fields.entrego.isInvalid],
            ["recibio", [fields.recibio.visible && fields.recibio.required ? ew.Validators.required(fields.recibio.caption) : null, ew.Validators.integer], fields.recibio.isInvalid],
            ["fechaingr", [fields.fechaingr.visible && fields.fechaingr.required ? ew.Validators.required(fields.fechaingr.caption) : null, ew.Validators.datetime(fields.fechaingr.clientFormatPattern)], fields.fechaingr.isInvalid],
            ["fechaentrega", [fields.fechaentrega.visible && fields.fechaentrega.required ? ew.Validators.required(fields.fechaentrega.caption) : null, ew.Validators.datetime(fields.fechaentrega.clientFormatPattern)], fields.fechaentrega.isInvalid],
            ["tcomprel", [fields.tcomprel.visible && fields.tcomprel.required ? ew.Validators.required(fields.tcomprel.caption) : null, ew.Validators.integer], fields.tcomprel.isInvalid],
            ["serierel", [fields.serierel.visible && fields.serierel.required ? ew.Validators.required(fields.serierel.caption) : null, ew.Validators.integer], fields.serierel.isInvalid],
            ["ncomprel", [fields.ncomprel.visible && fields.ncomprel.required ? ew.Validators.required(fields.ncomprel.caption) : null, ew.Validators.integer], fields.ncomprel.isInvalid],
            ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
            ["moneda", [fields.moneda.visible && fields.moneda.required ? ew.Validators.required(fields.moneda.caption) : null, ew.Validators.integer], fields.moneda.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null, ew.Validators.datetime(fields.fechahora.clientFormatPattern)], fields.fechahora.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["tcompsal", [fields.tcompsal.visible && fields.tcompsal.required ? ew.Validators.required(fields.tcompsal.caption) : null, ew.Validators.integer], fields.tcompsal.isInvalid],
            ["seriesal", [fields.seriesal.visible && fields.seriesal.required ? ew.Validators.required(fields.seriesal.caption) : null, ew.Validators.integer], fields.seriesal.isInvalid],
            ["ncompsal", [fields.ncompsal.visible && fields.ncompsal.required ? ew.Validators.required(fields.ncompsal.caption) : null, ew.Validators.integer], fields.ncompsal.isInvalid],
            ["codrem", [fields.codrem.visible && fields.codrem.required ? ew.Validators.required(fields.codrem.caption) : null], fields.codrem.isInvalid],
            ["cotiz", [fields.cotiz.visible && fields.cotiz.required ? ew.Validators.required(fields.cotiz.caption) : null, ew.Validators.float], fields.cotiz.isInvalid],
            ["usurel", [fields.usurel.visible && fields.usurel.required ? ew.Validators.required(fields.usurel.caption) : null, ew.Validators.integer], fields.usurel.isInvalid],
            ["fecharel", [fields.fecharel.visible && fields.fecharel.required ? ew.Validators.required(fields.fecharel.caption) : null, ew.Validators.datetime(fields.fecharel.clientFormatPattern)], fields.fecharel.isInvalid],
            ["ususal", [fields.ususal.visible && fields.ususal.required ? ew.Validators.required(fields.ususal.caption) : null, ew.Validators.integer], fields.ususal.isInvalid],
            ["fechasal", [fields.fechasal.visible && fields.fechasal.required ? ew.Validators.required(fields.fechasal.caption) : null, ew.Validators.datetime(fields.fechasal.clientFormatPattern)], fields.fechasal.isInvalid]
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
            "tcomp": <?= $Page->tcomp->toClientList($Page) ?>,
            "codban": <?= $Page->codban->toClientList($Page) ?>,
            "codsuc": <?= $Page->codsuc->toClientList($Page) ?>,
            "codpais": <?= $Page->codpais->toClientList($Page) ?>,
            "estado": <?= $Page->estado->toClientList($Page) ?>,
            "codrem": <?= $Page->codrem->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="cartvalores">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codnum->Visible) { // codnum ?>
    <div id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <label id="elh_cartvalores_codnum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codnum->caption() ?><?= $Page->codnum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codnum->cellAttributes() ?>>
<span id="el_cartvalores_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codnum->getDisplayValue($Page->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="cartvalores" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <div id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <label id="elh_cartvalores_tcomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomp->caption() ?><?= $Page->tcomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_cartvalores_tcomp">
<?php
if (IsRTL()) {
    $Page->tcomp->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_tcomp" class="ew-auto-suggest">
    <input type="<?= $Page->tcomp->getInputTextType() ?>" class="form-control" name="sv_x_tcomp" id="sv_x_tcomp" value="<?= RemoveHtml($Page->tcomp->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->tcomp->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->tcomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcomp->formatPattern()) ?>"<?= $Page->tcomp->editAttributes() ?> aria-describedby="x_tcomp_help">
</span>
<selection-list hidden class="form-control" data-table="cartvalores" data-field="x_tcomp" data-input="sv_x_tcomp" data-value-separator="<?= $Page->tcomp->displayValueSeparatorAttribute() ?>" name="x_tcomp" id="x_tcomp" value="<?= HtmlEncode($Page->tcomp->CurrentValue) ?>"></selection-list>
<?= $Page->tcomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcomp->getErrorMessage() ?></div>
<script>
loadjs.ready("fcartvaloresedit", function() {
    fcartvaloresedit.createAutoSuggest(Object.assign({"id":"x_tcomp","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->tcomp->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.cartvalores.fields.tcomp.autoSuggestOptions));
});
</script>
<?= $Page->tcomp->Lookup->getParamTag($Page, "p_x_tcomp") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <div id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <label id="elh_cartvalores_serie" for="x_serie" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serie->caption() ?><?= $Page->serie->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serie->cellAttributes() ?>>
<span id="el_cartvalores_serie">
<input type="<?= $Page->serie->getInputTextType() ?>" name="x_serie" id="x_serie" data-table="cartvalores" data-field="x_serie" value="<?= $Page->serie->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->serie->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->serie->formatPattern()) ?>"<?= $Page->serie->editAttributes() ?> aria-describedby="x_serie_help">
<?= $Page->serie->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serie->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <div id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <label id="elh_cartvalores_ncomp" for="x_ncomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomp->caption() ?><?= $Page->ncomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_cartvalores_ncomp">
<input type="<?= $Page->ncomp->getInputTextType() ?>" name="x_ncomp" id="x_ncomp" data-table="cartvalores" data-field="x_ncomp" value="<?= $Page->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomp->formatPattern()) ?>"<?= $Page->ncomp->editAttributes() ?> aria-describedby="x_ncomp_help">
<?= $Page->ncomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codban->Visible) { // codban ?>
    <div id="r_codban"<?= $Page->codban->rowAttributes() ?>>
        <label id="elh_cartvalores_codban" for="x_codban" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codban->caption() ?><?= $Page->codban->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codban->cellAttributes() ?>>
<span id="el_cartvalores_codban">
    <select
        id="x_codban"
        name="x_codban"
        class="form-select ew-select<?= $Page->codban->isInvalidClass() ?>"
        <?php if (!$Page->codban->IsNativeSelect) { ?>
        data-select2-id="fcartvaloresedit_x_codban"
        <?php } ?>
        data-table="cartvalores"
        data-field="x_codban"
        data-value-separator="<?= $Page->codban->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codban->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->codban->editAttributes() ?>>
        <?= $Page->codban->selectOptionListHtml("x_codban") ?>
    </select>
    <?= $Page->codban->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codban->getErrorMessage() ?></div>
<?= $Page->codban->Lookup->getParamTag($Page, "p_x_codban") ?>
<?php if (!$Page->codban->IsNativeSelect) { ?>
<script>
loadjs.ready("fcartvaloresedit", function() {
    var options = { name: "x_codban", selectId: "fcartvaloresedit_x_codban" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcartvaloresedit.lists.codban?.lookupOptions.length) {
        options.data = { id: "x_codban", form: "fcartvaloresedit" };
    } else {
        options.ajax = { id: "x_codban", form: "fcartvaloresedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cartvalores.fields.codban.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codsuc->Visible) { // codsuc ?>
    <div id="r_codsuc"<?= $Page->codsuc->rowAttributes() ?>>
        <label id="elh_cartvalores_codsuc" for="x_codsuc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codsuc->caption() ?><?= $Page->codsuc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codsuc->cellAttributes() ?>>
<span id="el_cartvalores_codsuc">
    <select
        id="x_codsuc"
        name="x_codsuc"
        class="form-select ew-select<?= $Page->codsuc->isInvalidClass() ?>"
        <?php if (!$Page->codsuc->IsNativeSelect) { ?>
        data-select2-id="fcartvaloresedit_x_codsuc"
        <?php } ?>
        data-table="cartvalores"
        data-field="x_codsuc"
        data-value-separator="<?= $Page->codsuc->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codsuc->getPlaceHolder()) ?>"
        <?= $Page->codsuc->editAttributes() ?>>
        <?= $Page->codsuc->selectOptionListHtml("x_codsuc") ?>
    </select>
    <?= $Page->codsuc->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codsuc->getErrorMessage() ?></div>
<?= $Page->codsuc->Lookup->getParamTag($Page, "p_x_codsuc") ?>
<?php if (!$Page->codsuc->IsNativeSelect) { ?>
<script>
loadjs.ready("fcartvaloresedit", function() {
    var options = { name: "x_codsuc", selectId: "fcartvaloresedit_x_codsuc" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcartvaloresedit.lists.codsuc?.lookupOptions.length) {
        options.data = { id: "x_codsuc", form: "fcartvaloresedit" };
    } else {
        options.ajax = { id: "x_codsuc", form: "fcartvaloresedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cartvalores.fields.codsuc.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codcta->Visible) { // codcta ?>
    <div id="r_codcta"<?= $Page->codcta->rowAttributes() ?>>
        <label id="elh_cartvalores_codcta" for="x_codcta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codcta->caption() ?><?= $Page->codcta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codcta->cellAttributes() ?>>
<span id="el_cartvalores_codcta">
<input type="<?= $Page->codcta->getInputTextType() ?>" name="x_codcta" id="x_codcta" data-table="cartvalores" data-field="x_codcta" value="<?= $Page->codcta->EditValue ?>" size="30" maxlength="12" placeholder="<?= HtmlEncode($Page->codcta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codcta->formatPattern()) ?>"<?= $Page->codcta->editAttributes() ?> aria-describedby="x_codcta_help">
<?= $Page->codcta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codcta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipcta->Visible) { // tipcta ?>
    <div id="r_tipcta"<?= $Page->tipcta->rowAttributes() ?>>
        <label id="elh_cartvalores_tipcta" for="x_tipcta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipcta->caption() ?><?= $Page->tipcta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipcta->cellAttributes() ?>>
<span id="el_cartvalores_tipcta">
<input type="<?= $Page->tipcta->getInputTextType() ?>" name="x_tipcta" id="x_tipcta" data-table="cartvalores" data-field="x_tipcta" value="<?= $Page->tipcta->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->tipcta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipcta->formatPattern()) ?>"<?= $Page->tipcta->editAttributes() ?> aria-describedby="x_tipcta_help">
<?= $Page->tipcta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipcta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codchq->Visible) { // codchq ?>
    <div id="r_codchq"<?= $Page->codchq->rowAttributes() ?>>
        <label id="elh_cartvalores_codchq" for="x_codchq" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codchq->caption() ?><?= $Page->codchq->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codchq->cellAttributes() ?>>
<span id="el_cartvalores_codchq">
<input type="<?= $Page->codchq->getInputTextType() ?>" name="x_codchq" id="x_codchq" data-table="cartvalores" data-field="x_codchq" value="<?= $Page->codchq->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->codchq->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codchq->formatPattern()) ?>"<?= $Page->codchq->editAttributes() ?> aria-describedby="x_codchq_help">
<?= $Page->codchq->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codchq->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <div id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <label id="elh_cartvalores_codpais" for="x_codpais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpais->caption() ?><?= $Page->codpais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpais->cellAttributes() ?>>
<span id="el_cartvalores_codpais">
    <select
        id="x_codpais"
        name="x_codpais"
        class="form-select ew-select<?= $Page->codpais->isInvalidClass() ?>"
        <?php if (!$Page->codpais->IsNativeSelect) { ?>
        data-select2-id="fcartvaloresedit_x_codpais"
        <?php } ?>
        data-table="cartvalores"
        data-field="x_codpais"
        data-value-separator="<?= $Page->codpais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codpais->getPlaceHolder()) ?>"
        <?= $Page->codpais->editAttributes() ?>>
        <?= $Page->codpais->selectOptionListHtml("x_codpais") ?>
    </select>
    <?= $Page->codpais->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codpais->getErrorMessage() ?></div>
<?= $Page->codpais->Lookup->getParamTag($Page, "p_x_codpais") ?>
<?php if (!$Page->codpais->IsNativeSelect) { ?>
<script>
loadjs.ready("fcartvaloresedit", function() {
    var options = { name: "x_codpais", selectId: "fcartvaloresedit_x_codpais" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcartvaloresedit.lists.codpais?.lookupOptions.length) {
        options.data = { id: "x_codpais", form: "fcartvaloresedit" };
    } else {
        options.ajax = { id: "x_codpais", form: "fcartvaloresedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cartvalores.fields.codpais.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->importe->Visible) { // importe ?>
    <div id="r_importe"<?= $Page->importe->rowAttributes() ?>>
        <label id="elh_cartvalores_importe" for="x_importe" class="<?= $Page->LeftColumnClass ?>"><?= $Page->importe->caption() ?><?= $Page->importe->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->importe->cellAttributes() ?>>
<span id="el_cartvalores_importe">
<input type="<?= $Page->importe->getInputTextType() ?>" name="x_importe" id="x_importe" data-table="cartvalores" data-field="x_importe" value="<?= $Page->importe->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->importe->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->importe->formatPattern()) ?>"<?= $Page->importe->editAttributes() ?> aria-describedby="x_importe_help">
<?= $Page->importe->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->importe->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechaemis->Visible) { // fechaemis ?>
    <div id="r_fechaemis"<?= $Page->fechaemis->rowAttributes() ?>>
        <label id="elh_cartvalores_fechaemis" for="x_fechaemis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechaemis->caption() ?><?= $Page->fechaemis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechaemis->cellAttributes() ?>>
<span id="el_cartvalores_fechaemis">
<input type="<?= $Page->fechaemis->getInputTextType() ?>" name="x_fechaemis" id="x_fechaemis" data-table="cartvalores" data-field="x_fechaemis" value="<?= $Page->fechaemis->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechaemis->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechaemis->formatPattern()) ?>"<?= $Page->fechaemis->editAttributes() ?> aria-describedby="x_fechaemis_help">
<?= $Page->fechaemis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechaemis->getErrorMessage() ?></div>
<?php if (!$Page->fechaemis->ReadOnly && !$Page->fechaemis->Disabled && !isset($Page->fechaemis->EditAttrs["readonly"]) && !isset($Page->fechaemis->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcartvaloresedit", "datetimepicker"], function () {
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
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcartvaloresedit", "x_fechaemis", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechapago->Visible) { // fechapago ?>
    <div id="r_fechapago"<?= $Page->fechapago->rowAttributes() ?>>
        <label id="elh_cartvalores_fechapago" for="x_fechapago" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechapago->caption() ?><?= $Page->fechapago->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechapago->cellAttributes() ?>>
<span id="el_cartvalores_fechapago">
<input type="<?= $Page->fechapago->getInputTextType() ?>" name="x_fechapago" id="x_fechapago" data-table="cartvalores" data-field="x_fechapago" value="<?= $Page->fechapago->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechapago->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechapago->formatPattern()) ?>"<?= $Page->fechapago->editAttributes() ?> aria-describedby="x_fechapago_help">
<?= $Page->fechapago->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechapago->getErrorMessage() ?></div>
<?php if (!$Page->fechapago->ReadOnly && !$Page->fechapago->Disabled && !isset($Page->fechapago->EditAttrs["readonly"]) && !isset($Page->fechapago->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcartvaloresedit", "datetimepicker"], function () {
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
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcartvaloresedit", "x_fechapago", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->entrego->Visible) { // entrego ?>
    <div id="r_entrego"<?= $Page->entrego->rowAttributes() ?>>
        <label id="elh_cartvalores_entrego" for="x_entrego" class="<?= $Page->LeftColumnClass ?>"><?= $Page->entrego->caption() ?><?= $Page->entrego->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->entrego->cellAttributes() ?>>
<span id="el_cartvalores_entrego">
<input type="<?= $Page->entrego->getInputTextType() ?>" name="x_entrego" id="x_entrego" data-table="cartvalores" data-field="x_entrego" value="<?= $Page->entrego->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->entrego->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->entrego->formatPattern()) ?>"<?= $Page->entrego->editAttributes() ?> aria-describedby="x_entrego_help">
<?= $Page->entrego->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->entrego->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->recibio->Visible) { // recibio ?>
    <div id="r_recibio"<?= $Page->recibio->rowAttributes() ?>>
        <label id="elh_cartvalores_recibio" for="x_recibio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->recibio->caption() ?><?= $Page->recibio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->recibio->cellAttributes() ?>>
<span id="el_cartvalores_recibio">
<input type="<?= $Page->recibio->getInputTextType() ?>" name="x_recibio" id="x_recibio" data-table="cartvalores" data-field="x_recibio" value="<?= $Page->recibio->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->recibio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->recibio->formatPattern()) ?>"<?= $Page->recibio->editAttributes() ?> aria-describedby="x_recibio_help">
<?= $Page->recibio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->recibio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechaingr->Visible) { // fechaingr ?>
    <div id="r_fechaingr"<?= $Page->fechaingr->rowAttributes() ?>>
        <label id="elh_cartvalores_fechaingr" for="x_fechaingr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechaingr->caption() ?><?= $Page->fechaingr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechaingr->cellAttributes() ?>>
<span id="el_cartvalores_fechaingr">
<input type="<?= $Page->fechaingr->getInputTextType() ?>" name="x_fechaingr" id="x_fechaingr" data-table="cartvalores" data-field="x_fechaingr" value="<?= $Page->fechaingr->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechaingr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechaingr->formatPattern()) ?>"<?= $Page->fechaingr->editAttributes() ?> aria-describedby="x_fechaingr_help">
<?= $Page->fechaingr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechaingr->getErrorMessage() ?></div>
<?php if (!$Page->fechaingr->ReadOnly && !$Page->fechaingr->Disabled && !isset($Page->fechaingr->EditAttrs["readonly"]) && !isset($Page->fechaingr->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcartvaloresedit", "datetimepicker"], function () {
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
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcartvaloresedit", "x_fechaingr", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechaentrega->Visible) { // fechaentrega ?>
    <div id="r_fechaentrega"<?= $Page->fechaentrega->rowAttributes() ?>>
        <label id="elh_cartvalores_fechaentrega" for="x_fechaentrega" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechaentrega->caption() ?><?= $Page->fechaentrega->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechaentrega->cellAttributes() ?>>
<span id="el_cartvalores_fechaentrega">
<input type="<?= $Page->fechaentrega->getInputTextType() ?>" name="x_fechaentrega" id="x_fechaentrega" data-table="cartvalores" data-field="x_fechaentrega" value="<?= $Page->fechaentrega->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechaentrega->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechaentrega->formatPattern()) ?>"<?= $Page->fechaentrega->editAttributes() ?> aria-describedby="x_fechaentrega_help">
<?= $Page->fechaentrega->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechaentrega->getErrorMessage() ?></div>
<?php if (!$Page->fechaentrega->ReadOnly && !$Page->fechaentrega->Disabled && !isset($Page->fechaentrega->EditAttrs["readonly"]) && !isset($Page->fechaentrega->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcartvaloresedit", "datetimepicker"], function () {
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
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcartvaloresedit", "x_fechaentrega", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
    <div id="r_tcomprel"<?= $Page->tcomprel->rowAttributes() ?>>
        <label id="elh_cartvalores_tcomprel" for="x_tcomprel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomprel->caption() ?><?= $Page->tcomprel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomprel->cellAttributes() ?>>
<span id="el_cartvalores_tcomprel">
<input type="<?= $Page->tcomprel->getInputTextType() ?>" name="x_tcomprel" id="x_tcomprel" data-table="cartvalores" data-field="x_tcomprel" value="<?= $Page->tcomprel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tcomprel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcomprel->formatPattern()) ?>"<?= $Page->tcomprel->editAttributes() ?> aria-describedby="x_tcomprel_help">
<?= $Page->tcomprel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcomprel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
    <div id="r_serierel"<?= $Page->serierel->rowAttributes() ?>>
        <label id="elh_cartvalores_serierel" for="x_serierel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serierel->caption() ?><?= $Page->serierel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serierel->cellAttributes() ?>>
<span id="el_cartvalores_serierel">
<input type="<?= $Page->serierel->getInputTextType() ?>" name="x_serierel" id="x_serierel" data-table="cartvalores" data-field="x_serierel" value="<?= $Page->serierel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->serierel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->serierel->formatPattern()) ?>"<?= $Page->serierel->editAttributes() ?> aria-describedby="x_serierel_help">
<?= $Page->serierel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serierel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
    <div id="r_ncomprel"<?= $Page->ncomprel->rowAttributes() ?>>
        <label id="elh_cartvalores_ncomprel" for="x_ncomprel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomprel->caption() ?><?= $Page->ncomprel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomprel->cellAttributes() ?>>
<span id="el_cartvalores_ncomprel">
<input type="<?= $Page->ncomprel->getInputTextType() ?>" name="x_ncomprel" id="x_ncomprel" data-table="cartvalores" data-field="x_ncomprel" value="<?= $Page->ncomprel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomprel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomprel->formatPattern()) ?>"<?= $Page->ncomprel->editAttributes() ?> aria-describedby="x_ncomprel_help">
<?= $Page->ncomprel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomprel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <div id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <label id="elh_cartvalores_estado" for="x_estado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado->caption() ?><?= $Page->estado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estado->cellAttributes() ?>>
<span id="el_cartvalores_estado">
    <select
        id="x_estado"
        name="x_estado"
        class="form-select ew-select<?= $Page->estado->isInvalidClass() ?>"
        <?php if (!$Page->estado->IsNativeSelect) { ?>
        data-select2-id="fcartvaloresedit_x_estado"
        <?php } ?>
        data-table="cartvalores"
        data-field="x_estado"
        data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estado->getPlaceHolder()) ?>"
        <?= $Page->estado->editAttributes() ?>>
        <?= $Page->estado->selectOptionListHtml("x_estado") ?>
    </select>
    <?= $Page->estado->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
<?php if (!$Page->estado->IsNativeSelect) { ?>
<script>
loadjs.ready("fcartvaloresedit", function() {
    var options = { name: "x_estado", selectId: "fcartvaloresedit_x_estado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcartvaloresedit.lists.estado?.lookupOptions.length) {
        options.data = { id: "x_estado", form: "fcartvaloresedit" };
    } else {
        options.ajax = { id: "x_estado", form: "fcartvaloresedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cartvalores.fields.estado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
    <div id="r_moneda"<?= $Page->moneda->rowAttributes() ?>>
        <label id="elh_cartvalores_moneda" for="x_moneda" class="<?= $Page->LeftColumnClass ?>"><?= $Page->moneda->caption() ?><?= $Page->moneda->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->moneda->cellAttributes() ?>>
<span id="el_cartvalores_moneda">
<input type="<?= $Page->moneda->getInputTextType() ?>" name="x_moneda" id="x_moneda" data-table="cartvalores" data-field="x_moneda" value="<?= $Page->moneda->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->moneda->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->moneda->formatPattern()) ?>"<?= $Page->moneda->editAttributes() ?> aria-describedby="x_moneda_help">
<?= $Page->moneda->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->moneda->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <div id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <label id="elh_cartvalores_fechahora" for="x_fechahora" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechahora->caption() ?><?= $Page->fechahora->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_cartvalores_fechahora">
<input type="<?= $Page->fechahora->getInputTextType() ?>" name="x_fechahora" id="x_fechahora" data-table="cartvalores" data-field="x_fechahora" value="<?= $Page->fechahora->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechahora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechahora->formatPattern()) ?>"<?= $Page->fechahora->editAttributes() ?> aria-describedby="x_fechahora_help">
<?= $Page->fechahora->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechahora->getErrorMessage() ?></div>
<?php if (!$Page->fechahora->ReadOnly && !$Page->fechahora->Disabled && !isset($Page->fechahora->EditAttrs["readonly"]) && !isset($Page->fechahora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcartvaloresedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(11) ?>",
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
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcartvaloresedit", "x_fechahora", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
    <div id="r_tcompsal"<?= $Page->tcompsal->rowAttributes() ?>>
        <label id="elh_cartvalores_tcompsal" for="x_tcompsal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcompsal->caption() ?><?= $Page->tcompsal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcompsal->cellAttributes() ?>>
<span id="el_cartvalores_tcompsal">
<input type="<?= $Page->tcompsal->getInputTextType() ?>" name="x_tcompsal" id="x_tcompsal" data-table="cartvalores" data-field="x_tcompsal" value="<?= $Page->tcompsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tcompsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcompsal->formatPattern()) ?>"<?= $Page->tcompsal->editAttributes() ?> aria-describedby="x_tcompsal_help">
<?= $Page->tcompsal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcompsal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
    <div id="r_seriesal"<?= $Page->seriesal->rowAttributes() ?>>
        <label id="elh_cartvalores_seriesal" for="x_seriesal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seriesal->caption() ?><?= $Page->seriesal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seriesal->cellAttributes() ?>>
<span id="el_cartvalores_seriesal">
<input type="<?= $Page->seriesal->getInputTextType() ?>" name="x_seriesal" id="x_seriesal" data-table="cartvalores" data-field="x_seriesal" value="<?= $Page->seriesal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->seriesal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seriesal->formatPattern()) ?>"<?= $Page->seriesal->editAttributes() ?> aria-describedby="x_seriesal_help">
<?= $Page->seriesal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->seriesal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
    <div id="r_ncompsal"<?= $Page->ncompsal->rowAttributes() ?>>
        <label id="elh_cartvalores_ncompsal" for="x_ncompsal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncompsal->caption() ?><?= $Page->ncompsal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncompsal->cellAttributes() ?>>
<span id="el_cartvalores_ncompsal">
<input type="<?= $Page->ncompsal->getInputTextType() ?>" name="x_ncompsal" id="x_ncompsal" data-table="cartvalores" data-field="x_ncompsal" value="<?= $Page->ncompsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncompsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncompsal->formatPattern()) ?>"<?= $Page->ncompsal->editAttributes() ?> aria-describedby="x_ncompsal_help">
<?= $Page->ncompsal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncompsal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <div id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <label id="elh_cartvalores_codrem" for="x_codrem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codrem->caption() ?><?= $Page->codrem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codrem->cellAttributes() ?>>
<span id="el_cartvalores_codrem">
    <select
        id="x_codrem"
        name="x_codrem"
        class="form-select ew-select<?= $Page->codrem->isInvalidClass() ?>"
        <?php if (!$Page->codrem->IsNativeSelect) { ?>
        data-select2-id="fcartvaloresedit_x_codrem"
        <?php } ?>
        data-table="cartvalores"
        data-field="x_codrem"
        data-value-separator="<?= $Page->codrem->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codrem->getPlaceHolder()) ?>"
        <?= $Page->codrem->editAttributes() ?>>
        <?= $Page->codrem->selectOptionListHtml("x_codrem") ?>
    </select>
    <?= $Page->codrem->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codrem->getErrorMessage() ?></div>
<?= $Page->codrem->Lookup->getParamTag($Page, "p_x_codrem") ?>
<?php if (!$Page->codrem->IsNativeSelect) { ?>
<script>
loadjs.ready("fcartvaloresedit", function() {
    var options = { name: "x_codrem", selectId: "fcartvaloresedit_x_codrem" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcartvaloresedit.lists.codrem?.lookupOptions.length) {
        options.data = { id: "x_codrem", form: "fcartvaloresedit" };
    } else {
        options.ajax = { id: "x_codrem", form: "fcartvaloresedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cartvalores.fields.codrem.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
    <div id="r_cotiz"<?= $Page->cotiz->rowAttributes() ?>>
        <label id="elh_cartvalores_cotiz" for="x_cotiz" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cotiz->caption() ?><?= $Page->cotiz->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cotiz->cellAttributes() ?>>
<span id="el_cartvalores_cotiz">
<input type="<?= $Page->cotiz->getInputTextType() ?>" name="x_cotiz" id="x_cotiz" data-table="cartvalores" data-field="x_cotiz" value="<?= $Page->cotiz->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cotiz->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cotiz->formatPattern()) ?>"<?= $Page->cotiz->editAttributes() ?> aria-describedby="x_cotiz_help">
<?= $Page->cotiz->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cotiz->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usurel->Visible) { // usurel ?>
    <div id="r_usurel"<?= $Page->usurel->rowAttributes() ?>>
        <label id="elh_cartvalores_usurel" for="x_usurel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usurel->caption() ?><?= $Page->usurel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usurel->cellAttributes() ?>>
<span id="el_cartvalores_usurel">
<input type="<?= $Page->usurel->getInputTextType() ?>" name="x_usurel" id="x_usurel" data-table="cartvalores" data-field="x_usurel" value="<?= $Page->usurel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->usurel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->usurel->formatPattern()) ?>"<?= $Page->usurel->editAttributes() ?> aria-describedby="x_usurel_help">
<?= $Page->usurel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->usurel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecharel->Visible) { // fecharel ?>
    <div id="r_fecharel"<?= $Page->fecharel->rowAttributes() ?>>
        <label id="elh_cartvalores_fecharel" for="x_fecharel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecharel->caption() ?><?= $Page->fecharel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecharel->cellAttributes() ?>>
<span id="el_cartvalores_fecharel">
<input type="<?= $Page->fecharel->getInputTextType() ?>" name="x_fecharel" id="x_fecharel" data-table="cartvalores" data-field="x_fecharel" value="<?= $Page->fecharel->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecharel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecharel->formatPattern()) ?>"<?= $Page->fecharel->editAttributes() ?> aria-describedby="x_fecharel_help">
<?= $Page->fecharel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecharel->getErrorMessage() ?></div>
<?php if (!$Page->fecharel->ReadOnly && !$Page->fecharel->Disabled && !isset($Page->fecharel->EditAttrs["readonly"]) && !isset($Page->fecharel->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcartvaloresedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(11) ?>",
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
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcartvaloresedit", "x_fecharel", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ususal->Visible) { // ususal ?>
    <div id="r_ususal"<?= $Page->ususal->rowAttributes() ?>>
        <label id="elh_cartvalores_ususal" for="x_ususal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ususal->caption() ?><?= $Page->ususal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ususal->cellAttributes() ?>>
<span id="el_cartvalores_ususal">
<input type="<?= $Page->ususal->getInputTextType() ?>" name="x_ususal" id="x_ususal" data-table="cartvalores" data-field="x_ususal" value="<?= $Page->ususal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ususal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ususal->formatPattern()) ?>"<?= $Page->ususal->editAttributes() ?> aria-describedby="x_ususal_help">
<?= $Page->ususal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ususal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechasal->Visible) { // fechasal ?>
    <div id="r_fechasal"<?= $Page->fechasal->rowAttributes() ?>>
        <label id="elh_cartvalores_fechasal" for="x_fechasal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechasal->caption() ?><?= $Page->fechasal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechasal->cellAttributes() ?>>
<span id="el_cartvalores_fechasal">
<input type="<?= $Page->fechasal->getInputTextType() ?>" name="x_fechasal" id="x_fechasal" data-table="cartvalores" data-field="x_fechasal" value="<?= $Page->fechasal->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechasal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechasal->formatPattern()) ?>"<?= $Page->fechasal->editAttributes() ?> aria-describedby="x_fechasal_help">
<?= $Page->fechasal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechasal->getErrorMessage() ?></div>
<?php if (!$Page->fechasal->ReadOnly && !$Page->fechasal->Disabled && !isset($Page->fechasal->EditAttrs["readonly"]) && !isset($Page->fechasal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcartvaloresedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(11) ?>",
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
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcartvaloresedit", "x_fechasal", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcartvaloresedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcartvaloresedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("cartvalores");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
