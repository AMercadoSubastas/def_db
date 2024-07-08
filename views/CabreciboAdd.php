<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CabreciboAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabrecibo: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fcabreciboadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcabreciboadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["cantcbtes", [fields.cantcbtes.visible && fields.cantcbtes.required ? ew.Validators.required(fields.cantcbtes.caption) : null, ew.Validators.integer], fields.cantcbtes.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null], fields.fechahora.isInvalid],
            ["cliente", [fields.cliente.visible && fields.cliente.required ? ew.Validators.required(fields.cliente.caption) : null], fields.cliente.isInvalid],
            ["imptot", [fields.imptot.visible && fields.imptot.required ? ew.Validators.required(fields.imptot.caption) : null, ew.Validators.float], fields.imptot.isInvalid],
            ["emitido", [fields.emitido.visible && fields.emitido.required ? ew.Validators.required(fields.emitido.caption) : null], fields.emitido.isInvalid],
            ["usuarioultmod", [fields.usuarioultmod.visible && fields.usuarioultmod.required ? ew.Validators.required(fields.usuarioultmod.caption) : null], fields.usuarioultmod.isInvalid],
            ["fecultmod", [fields.fecultmod.visible && fields.fecultmod.required ? ew.Validators.required(fields.fecultmod.caption) : null], fields.fecultmod.isInvalid]
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
            "serie": <?= $Page->serie->toClientList($Page) ?>,
            "cliente": <?= $Page->cliente->toClientList($Page) ?>,
            "emitido": <?= $Page->emitido->toClientList($Page) ?>,
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
<form name="fcabreciboadd" id="fcabreciboadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cabrecibo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <div id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <label id="elh_cabrecibo_tcomp" for="x_tcomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomp->caption() ?><?= $Page->tcomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_cabrecibo_tcomp">
    <select
        id="x_tcomp"
        name="x_tcomp"
        class="form-select ew-select<?= $Page->tcomp->isInvalidClass() ?>"
        <?php if (!$Page->tcomp->IsNativeSelect) { ?>
        data-select2-id="fcabreciboadd_x_tcomp"
        <?php } ?>
        data-table="cabrecibo"
        data-field="x_tcomp"
        data-value-separator="<?= $Page->tcomp->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tcomp->getPlaceHolder()) ?>"
        <?= $Page->tcomp->editAttributes() ?>>
        <?= $Page->tcomp->selectOptionListHtml("x_tcomp") ?>
    </select>
    <?= $Page->tcomp->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tcomp->getErrorMessage() ?></div>
<?= $Page->tcomp->Lookup->getParamTag($Page, "p_x_tcomp") ?>
<?php if (!$Page->tcomp->IsNativeSelect) { ?>
<script>
loadjs.ready("fcabreciboadd", function() {
    var options = { name: "x_tcomp", selectId: "fcabreciboadd_x_tcomp" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcabreciboadd.lists.tcomp?.lookupOptions.length) {
        options.data = { id: "x_tcomp", form: "fcabreciboadd" };
    } else {
        options.ajax = { id: "x_tcomp", form: "fcabreciboadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cabrecibo.fields.tcomp.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <div id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <label id="elh_cabrecibo_serie" for="x_serie" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serie->caption() ?><?= $Page->serie->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serie->cellAttributes() ?>>
<span id="el_cabrecibo_serie">
    <select
        id="x_serie"
        name="x_serie"
        class="form-select ew-select<?= $Page->serie->isInvalidClass() ?>"
        <?php if (!$Page->serie->IsNativeSelect) { ?>
        data-select2-id="fcabreciboadd_x_serie"
        <?php } ?>
        data-table="cabrecibo"
        data-field="x_serie"
        data-value-separator="<?= $Page->serie->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->serie->getPlaceHolder()) ?>"
        <?= $Page->serie->editAttributes() ?>>
        <?= $Page->serie->selectOptionListHtml("x_serie") ?>
    </select>
    <?= $Page->serie->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->serie->getErrorMessage() ?></div>
<?= $Page->serie->Lookup->getParamTag($Page, "p_x_serie") ?>
<?php if (!$Page->serie->IsNativeSelect) { ?>
<script>
loadjs.ready("fcabreciboadd", function() {
    var options = { name: "x_serie", selectId: "fcabreciboadd_x_serie" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcabreciboadd.lists.serie?.lookupOptions.length) {
        options.data = { id: "x_serie", form: "fcabreciboadd" };
    } else {
        options.ajax = { id: "x_serie", form: "fcabreciboadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cabrecibo.fields.serie.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <div id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <label id="elh_cabrecibo_ncomp" for="x_ncomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomp->caption() ?><?= $Page->ncomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_cabrecibo_ncomp">
<input type="<?= $Page->ncomp->getInputTextType() ?>" name="x_ncomp" id="x_ncomp" data-table="cabrecibo" data-field="x_ncomp" value="<?= $Page->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomp->formatPattern()) ?>"<?= $Page->ncomp->editAttributes() ?> aria-describedby="x_ncomp_help">
<?= $Page->ncomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cantcbtes->Visible) { // cantcbtes ?>
    <div id="r_cantcbtes"<?= $Page->cantcbtes->rowAttributes() ?>>
        <label id="elh_cabrecibo_cantcbtes" for="x_cantcbtes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cantcbtes->caption() ?><?= $Page->cantcbtes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cantcbtes->cellAttributes() ?>>
<span id="el_cabrecibo_cantcbtes">
<input type="<?= $Page->cantcbtes->getInputTextType() ?>" name="x_cantcbtes" id="x_cantcbtes" data-table="cabrecibo" data-field="x_cantcbtes" value="<?= $Page->cantcbtes->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cantcbtes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cantcbtes->formatPattern()) ?>"<?= $Page->cantcbtes->editAttributes() ?> aria-describedby="x_cantcbtes_help">
<?= $Page->cantcbtes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cantcbtes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_cabrecibo_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_cabrecibo_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="cabrecibo" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
<?php if (!$Page->fecha->ReadOnly && !$Page->fecha->Disabled && !isset($Page->fecha->EditAttrs["readonly"]) && !isset($Page->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcabreciboadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcabreciboadd", "x_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
    <div id="r_cliente"<?= $Page->cliente->rowAttributes() ?>>
        <label id="elh_cabrecibo_cliente" for="x_cliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cliente->caption() ?><?= $Page->cliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cliente->cellAttributes() ?>>
<span id="el_cabrecibo_cliente">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-select ew-select<?= $Page->cliente->isInvalidClass() ?>"
        <?php if (!$Page->cliente->IsNativeSelect) { ?>
        data-select2-id="fcabreciboadd_x_cliente"
        <?php } ?>
        data-table="cabrecibo"
        data-field="x_cliente"
        data-value-separator="<?= $Page->cliente->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cliente->getPlaceHolder()) ?>"
        <?= $Page->cliente->editAttributes() ?>>
        <?= $Page->cliente->selectOptionListHtml("x_cliente") ?>
    </select>
    <?= $Page->cliente->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cliente->getErrorMessage() ?></div>
<?= $Page->cliente->Lookup->getParamTag($Page, "p_x_cliente") ?>
<?php if (!$Page->cliente->IsNativeSelect) { ?>
<script>
loadjs.ready("fcabreciboadd", function() {
    var options = { name: "x_cliente", selectId: "fcabreciboadd_x_cliente" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcabreciboadd.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "fcabreciboadd" };
    } else {
        options.ajax = { id: "x_cliente", form: "fcabreciboadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cabrecibo.fields.cliente.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imptot->Visible) { // imptot ?>
    <div id="r_imptot"<?= $Page->imptot->rowAttributes() ?>>
        <label id="elh_cabrecibo_imptot" for="x_imptot" class="<?= $Page->LeftColumnClass ?>"><?= $Page->imptot->caption() ?><?= $Page->imptot->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->imptot->cellAttributes() ?>>
<span id="el_cabrecibo_imptot">
<input type="<?= $Page->imptot->getInputTextType() ?>" name="x_imptot" id="x_imptot" data-table="cabrecibo" data-field="x_imptot" value="<?= $Page->imptot->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->imptot->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->imptot->formatPattern()) ?>"<?= $Page->imptot->editAttributes() ?> aria-describedby="x_imptot_help">
<?= $Page->imptot->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->imptot->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
    <div id="r_emitido"<?= $Page->emitido->rowAttributes() ?>>
        <label id="elh_cabrecibo_emitido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->emitido->caption() ?><?= $Page->emitido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->emitido->cellAttributes() ?>>
<span id="el_cabrecibo_emitido">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->emitido->isInvalidClass() ?>" data-table="cabrecibo" data-field="x_emitido" data-boolean name="x_emitido" id="x_emitido" value="1"<?= ConvertToBool($Page->emitido->CurrentValue) ? " checked" : "" ?><?= $Page->emitido->editAttributes() ?> aria-describedby="x_emitido_help">
    <div class="invalid-feedback"><?= $Page->emitido->getErrorMessage() ?></div>
</div>
<?= $Page->emitido->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("detrecibo", explode(",", $Page->getCurrentDetailTable())) && $detrecibo->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detrecibo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "DetreciboGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcabreciboadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcabreciboadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("cabrecibo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
