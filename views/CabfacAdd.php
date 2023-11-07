<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$CabfacAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cabfac: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fcabfacadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcabfacadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["fecval", [fields.fecval.visible && fields.fecval.required ? ew.Validators.required(fields.fecval.caption) : null, ew.Validators.datetime(fields.fecval.clientFormatPattern)], fields.fecval.isInvalid],
            ["fecdoc", [fields.fecdoc.visible && fields.fecdoc.required ? ew.Validators.required(fields.fecdoc.caption) : null, ew.Validators.datetime(fields.fecdoc.clientFormatPattern)], fields.fecdoc.isInvalid],
            ["fecreg", [fields.fecreg.visible && fields.fecreg.required ? ew.Validators.required(fields.fecreg.caption) : null, ew.Validators.datetime(fields.fecreg.clientFormatPattern)], fields.fecreg.isInvalid],
            ["cliente", [fields.cliente.visible && fields.cliente.required ? ew.Validators.required(fields.cliente.caption) : null], fields.cliente.isInvalid],
            ["direc", [fields.direc.visible && fields.direc.required ? ew.Validators.required(fields.direc.caption) : null], fields.direc.isInvalid],
            ["dnro", [fields.dnro.visible && fields.dnro.required ? ew.Validators.required(fields.dnro.caption) : null], fields.dnro.isInvalid],
            ["pisodto", [fields.pisodto.visible && fields.pisodto.required ? ew.Validators.required(fields.pisodto.caption) : null], fields.pisodto.isInvalid],
            ["codpost", [fields.codpost.visible && fields.codpost.required ? ew.Validators.required(fields.codpost.caption) : null], fields.codpost.isInvalid],
            ["codpais", [fields.codpais.visible && fields.codpais.required ? ew.Validators.required(fields.codpais.caption) : null], fields.codpais.isInvalid],
            ["codprov", [fields.codprov.visible && fields.codprov.required ? ew.Validators.required(fields.codprov.caption) : null], fields.codprov.isInvalid],
            ["codloc", [fields.codloc.visible && fields.codloc.required ? ew.Validators.required(fields.codloc.caption) : null], fields.codloc.isInvalid],
            ["telef", [fields.telef.visible && fields.telef.required ? ew.Validators.required(fields.telef.caption) : null], fields.telef.isInvalid],
            ["codrem", [fields.codrem.visible && fields.codrem.required ? ew.Validators.required(fields.codrem.caption) : null], fields.codrem.isInvalid],
            ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
            ["emitido", [fields.emitido.visible && fields.emitido.required ? ew.Validators.required(fields.emitido.caption) : null], fields.emitido.isInvalid],
            ["totneto", [fields.totneto.visible && fields.totneto.required ? ew.Validators.required(fields.totneto.caption) : null, ew.Validators.float], fields.totneto.isInvalid],
            ["totbruto", [fields.totbruto.visible && fields.totbruto.required ? ew.Validators.required(fields.totbruto.caption) : null, ew.Validators.float], fields.totbruto.isInvalid],
            ["totiva105", [fields.totiva105.visible && fields.totiva105.required ? ew.Validators.required(fields.totiva105.caption) : null, ew.Validators.float], fields.totiva105.isInvalid],
            ["totiva21", [fields.totiva21.visible && fields.totiva21.required ? ew.Validators.required(fields.totiva21.caption) : null, ew.Validators.float], fields.totiva21.isInvalid],
            ["totimp", [fields.totimp.visible && fields.totimp.required ? ew.Validators.required(fields.totimp.caption) : null, ew.Validators.float], fields.totimp.isInvalid],
            ["totcomis", [fields.totcomis.visible && fields.totcomis.required ? ew.Validators.required(fields.totcomis.caption) : null, ew.Validators.float], fields.totcomis.isInvalid],
            ["totneto105", [fields.totneto105.visible && fields.totneto105.required ? ew.Validators.required(fields.totneto105.caption) : null, ew.Validators.float], fields.totneto105.isInvalid],
            ["totneto21", [fields.totneto21.visible && fields.totneto21.required ? ew.Validators.required(fields.totneto21.caption) : null, ew.Validators.float], fields.totneto21.isInvalid],
            ["porciva", [fields.porciva.visible && fields.porciva.required ? ew.Validators.required(fields.porciva.caption) : null], fields.porciva.isInvalid],
            ["nrengs", [fields.nrengs.visible && fields.nrengs.required ? ew.Validators.required(fields.nrengs.caption) : null, ew.Validators.integer], fields.nrengs.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null], fields.fechahora.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["tieneresol", [fields.tieneresol.visible && fields.tieneresol.required ? ew.Validators.required(fields.tieneresol.caption) : null], fields.tieneresol.isInvalid],
            ["leyendafc", [fields.leyendafc.visible && fields.leyendafc.required ? ew.Validators.required(fields.leyendafc.caption) : null], fields.leyendafc.isInvalid],
            ["concepto", [fields.concepto.visible && fields.concepto.required ? ew.Validators.required(fields.concepto.caption) : null], fields.concepto.isInvalid],
            ["nrodoc", [fields.nrodoc.visible && fields.nrodoc.required ? ew.Validators.required(fields.nrodoc.caption) : null], fields.nrodoc.isInvalid],
            ["tcompsal", [fields.tcompsal.visible && fields.tcompsal.required ? ew.Validators.required(fields.tcompsal.caption) : null, ew.Validators.integer], fields.tcompsal.isInvalid],
            ["seriesal", [fields.seriesal.visible && fields.seriesal.required ? ew.Validators.required(fields.seriesal.caption) : null, ew.Validators.integer], fields.seriesal.isInvalid],
            ["ncompsal", [fields.ncompsal.visible && fields.ncompsal.required ? ew.Validators.required(fields.ncompsal.caption) : null, ew.Validators.integer], fields.ncompsal.isInvalid],
            ["en_liquid", [fields.en_liquid.visible && fields.en_liquid.required ? ew.Validators.required(fields.en_liquid.caption) : null], fields.en_liquid.isInvalid],
            ["CAE", [fields.CAE.visible && fields.CAE.required ? ew.Validators.required(fields.CAE.caption) : null, ew.Validators.integer], fields.CAE.isInvalid],
            ["CAEFchVto", [fields.CAEFchVto.visible && fields.CAEFchVto.required ? ew.Validators.required(fields.CAEFchVto.caption) : null, ew.Validators.datetime(fields.CAEFchVto.clientFormatPattern)], fields.CAEFchVto.isInvalid],
            ["Resultado", [fields.Resultado.visible && fields.Resultado.required ? ew.Validators.required(fields.Resultado.caption) : null], fields.Resultado.isInvalid]
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
            "codrem": <?= $Page->codrem->toClientList($Page) ?>,
            "estado": <?= $Page->estado->toClientList($Page) ?>,
            "emitido": <?= $Page->emitido->toClientList($Page) ?>,
            "en_liquid": <?= $Page->en_liquid->toClientList($Page) ?>,
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
<form name="fcabfacadd" id="fcabfacadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cabfac">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <div id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <label id="elh_cabfac_tcomp" for="x_tcomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomp->caption() ?><?= $Page->tcomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_cabfac_tcomp">
    <select
        id="x_tcomp"
        name="x_tcomp"
        class="form-select ew-select<?= $Page->tcomp->isInvalidClass() ?>"
        <?php if (!$Page->tcomp->IsNativeSelect) { ?>
        data-select2-id="fcabfacadd_x_tcomp"
        <?php } ?>
        data-table="cabfac"
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
loadjs.ready("fcabfacadd", function() {
    var options = { name: "x_tcomp", selectId: "fcabfacadd_x_tcomp" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcabfacadd.lists.tcomp?.lookupOptions.length) {
        options.data = { id: "x_tcomp", form: "fcabfacadd" };
    } else {
        options.ajax = { id: "x_tcomp", form: "fcabfacadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cabfac.fields.tcomp.selectOptions);
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
        <label id="elh_cabfac_serie" for="x_serie" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serie->caption() ?><?= $Page->serie->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serie->cellAttributes() ?>>
<span id="el_cabfac_serie">
    <select
        id="x_serie"
        name="x_serie"
        class="form-select ew-select<?= $Page->serie->isInvalidClass() ?>"
        <?php if (!$Page->serie->IsNativeSelect) { ?>
        data-select2-id="fcabfacadd_x_serie"
        <?php } ?>
        data-table="cabfac"
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
loadjs.ready("fcabfacadd", function() {
    var options = { name: "x_serie", selectId: "fcabfacadd_x_serie" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcabfacadd.lists.serie?.lookupOptions.length) {
        options.data = { id: "x_serie", form: "fcabfacadd" };
    } else {
        options.ajax = { id: "x_serie", form: "fcabfacadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cabfac.fields.serie.selectOptions);
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
        <label id="elh_cabfac_ncomp" for="x_ncomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomp->caption() ?><?= $Page->ncomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_cabfac_ncomp">
<input type="<?= $Page->ncomp->getInputTextType() ?>" name="x_ncomp" id="x_ncomp" data-table="cabfac" data-field="x_ncomp" value="<?= $Page->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomp->formatPattern()) ?>"<?= $Page->ncomp->editAttributes() ?> aria-describedby="x_ncomp_help">
<?= $Page->ncomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecval->Visible) { // fecval ?>
    <div id="r_fecval"<?= $Page->fecval->rowAttributes() ?>>
        <label id="elh_cabfac_fecval" for="x_fecval" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecval->caption() ?><?= $Page->fecval->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecval->cellAttributes() ?>>
<span id="el_cabfac_fecval">
<input type="<?= $Page->fecval->getInputTextType() ?>" name="x_fecval" id="x_fecval" data-table="cabfac" data-field="x_fecval" value="<?= $Page->fecval->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecval->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecval->formatPattern()) ?>"<?= $Page->fecval->editAttributes() ?> aria-describedby="x_fecval_help">
<?= $Page->fecval->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecval->getErrorMessage() ?></div>
<?php if (!$Page->fecval->ReadOnly && !$Page->fecval->Disabled && !isset($Page->fecval->EditAttrs["readonly"]) && !isset($Page->fecval->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcabfacadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcabfacadd", "x_fecval", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecdoc->Visible) { // fecdoc ?>
    <div id="r_fecdoc"<?= $Page->fecdoc->rowAttributes() ?>>
        <label id="elh_cabfac_fecdoc" for="x_fecdoc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecdoc->caption() ?><?= $Page->fecdoc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecdoc->cellAttributes() ?>>
<span id="el_cabfac_fecdoc">
<input type="<?= $Page->fecdoc->getInputTextType() ?>" name="x_fecdoc" id="x_fecdoc" data-table="cabfac" data-field="x_fecdoc" value="<?= $Page->fecdoc->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecdoc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecdoc->formatPattern()) ?>"<?= $Page->fecdoc->editAttributes() ?> aria-describedby="x_fecdoc_help">
<?= $Page->fecdoc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecdoc->getErrorMessage() ?></div>
<?php if (!$Page->fecdoc->ReadOnly && !$Page->fecdoc->Disabled && !isset($Page->fecdoc->EditAttrs["readonly"]) && !isset($Page->fecdoc->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcabfacadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcabfacadd", "x_fecdoc", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecreg->Visible) { // fecreg ?>
    <div id="r_fecreg"<?= $Page->fecreg->rowAttributes() ?>>
        <label id="elh_cabfac_fecreg" for="x_fecreg" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecreg->caption() ?><?= $Page->fecreg->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecreg->cellAttributes() ?>>
<span id="el_cabfac_fecreg">
<input type="<?= $Page->fecreg->getInputTextType() ?>" name="x_fecreg" id="x_fecreg" data-table="cabfac" data-field="x_fecreg" value="<?= $Page->fecreg->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecreg->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecreg->formatPattern()) ?>"<?= $Page->fecreg->editAttributes() ?> aria-describedby="x_fecreg_help">
<?= $Page->fecreg->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecreg->getErrorMessage() ?></div>
<?php if (!$Page->fecreg->ReadOnly && !$Page->fecreg->Disabled && !isset($Page->fecreg->EditAttrs["readonly"]) && !isset($Page->fecreg->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcabfacadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcabfacadd", "x_fecreg", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
    <div id="r_cliente"<?= $Page->cliente->rowAttributes() ?>>
        <label id="elh_cabfac_cliente" for="x_cliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cliente->caption() ?><?= $Page->cliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cliente->cellAttributes() ?>>
<span id="el_cabfac_cliente">
    <select
        id="x_cliente"
        name="x_cliente"
        class="form-select ew-select<?= $Page->cliente->isInvalidClass() ?>"
        <?php if (!$Page->cliente->IsNativeSelect) { ?>
        data-select2-id="fcabfacadd_x_cliente"
        <?php } ?>
        data-table="cabfac"
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
loadjs.ready("fcabfacadd", function() {
    var options = { name: "x_cliente", selectId: "fcabfacadd_x_cliente" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcabfacadd.lists.cliente?.lookupOptions.length) {
        options.data = { id: "x_cliente", form: "fcabfacadd" };
    } else {
        options.ajax = { id: "x_cliente", form: "fcabfacadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cabfac.fields.cliente.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direc->Visible) { // direc ?>
    <div id="r_direc"<?= $Page->direc->rowAttributes() ?>>
        <label id="elh_cabfac_direc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direc->caption() ?><?= $Page->direc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direc->cellAttributes() ?>>
<span id="el_cabfac_direc">
<input type="<?= $Page->direc->getInputTextType() ?>" name="x_direc" id="x_direc" data-table="cabfac" data-field="x_direc" value="<?= $Page->direc->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->direc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->direc->formatPattern()) ?>"<?= $Page->direc->editAttributes() ?> aria-describedby="x_direc_help">
<?= $Page->direc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
    <div id="r_dnro"<?= $Page->dnro->rowAttributes() ?>>
        <label id="elh_cabfac_dnro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dnro->caption() ?><?= $Page->dnro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dnro->cellAttributes() ?>>
<span id="el_cabfac_dnro">
<input type="<?= $Page->dnro->getInputTextType() ?>" name="x_dnro" id="x_dnro" data-table="cabfac" data-field="x_dnro" value="<?= $Page->dnro->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->dnro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dnro->formatPattern()) ?>"<?= $Page->dnro->editAttributes() ?> aria-describedby="x_dnro_help">
<?= $Page->dnro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dnro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
    <div id="r_pisodto"<?= $Page->pisodto->rowAttributes() ?>>
        <label id="elh_cabfac_pisodto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pisodto->caption() ?><?= $Page->pisodto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pisodto->cellAttributes() ?>>
<span id="el_cabfac_pisodto">
<input type="<?= $Page->pisodto->getInputTextType() ?>" name="x_pisodto" id="x_pisodto" data-table="cabfac" data-field="x_pisodto" value="<?= $Page->pisodto->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->pisodto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->pisodto->formatPattern()) ?>"<?= $Page->pisodto->editAttributes() ?> aria-describedby="x_pisodto_help">
<?= $Page->pisodto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pisodto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
    <div id="r_codpost"<?= $Page->codpost->rowAttributes() ?>>
        <label id="elh_cabfac_codpost" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpost->caption() ?><?= $Page->codpost->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpost->cellAttributes() ?>>
<span id="el_cabfac_codpost">
<input type="<?= $Page->codpost->getInputTextType() ?>" name="x_codpost" id="x_codpost" data-table="cabfac" data-field="x_codpost" value="<?= $Page->codpost->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->codpost->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codpost->formatPattern()) ?>"<?= $Page->codpost->editAttributes() ?> aria-describedby="x_codpost_help">
<?= $Page->codpost->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codpost->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <div id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <label id="elh_cabfac_codpais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpais->caption() ?><?= $Page->codpais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpais->cellAttributes() ?>>
<span id="el_cabfac_codpais">
<input type="<?= $Page->codpais->getInputTextType() ?>" name="x_codpais" id="x_codpais" data-table="cabfac" data-field="x_codpais" value="<?= $Page->codpais->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codpais->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codpais->formatPattern()) ?>"<?= $Page->codpais->editAttributes() ?> aria-describedby="x_codpais_help">
<?= $Page->codpais->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codpais->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
    <div id="r_codprov"<?= $Page->codprov->rowAttributes() ?>>
        <label id="elh_cabfac_codprov" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codprov->caption() ?><?= $Page->codprov->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codprov->cellAttributes() ?>>
<span id="el_cabfac_codprov">
<input type="<?= $Page->codprov->getInputTextType() ?>" name="x_codprov" id="x_codprov" data-table="cabfac" data-field="x_codprov" value="<?= $Page->codprov->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codprov->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codprov->formatPattern()) ?>"<?= $Page->codprov->editAttributes() ?> aria-describedby="x_codprov_help">
<?= $Page->codprov->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codprov->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
    <div id="r_codloc"<?= $Page->codloc->rowAttributes() ?>>
        <label id="elh_cabfac_codloc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codloc->caption() ?><?= $Page->codloc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codloc->cellAttributes() ?>>
<span id="el_cabfac_codloc">
<input type="<?= $Page->codloc->getInputTextType() ?>" name="x_codloc" id="x_codloc" data-table="cabfac" data-field="x_codloc" value="<?= $Page->codloc->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codloc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codloc->formatPattern()) ?>"<?= $Page->codloc->editAttributes() ?> aria-describedby="x_codloc_help">
<?= $Page->codloc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codloc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telef->Visible) { // telef ?>
    <div id="r_telef"<?= $Page->telef->rowAttributes() ?>>
        <label id="elh_cabfac_telef" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telef->caption() ?><?= $Page->telef->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telef->cellAttributes() ?>>
<span id="el_cabfac_telef">
<input type="<?= $Page->telef->getInputTextType() ?>" name="x_telef" id="x_telef" data-table="cabfac" data-field="x_telef" value="<?= $Page->telef->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telef->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telef->formatPattern()) ?>"<?= $Page->telef->editAttributes() ?> aria-describedby="x_telef_help">
<?= $Page->telef->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telef->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <div id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <label id="elh_cabfac_codrem" for="x_codrem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codrem->caption() ?><?= $Page->codrem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codrem->cellAttributes() ?>>
<span id="el_cabfac_codrem">
    <select
        id="x_codrem"
        name="x_codrem"
        class="form-select ew-select<?= $Page->codrem->isInvalidClass() ?>"
        <?php if (!$Page->codrem->IsNativeSelect) { ?>
        data-select2-id="fcabfacadd_x_codrem"
        <?php } ?>
        data-table="cabfac"
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
loadjs.ready("fcabfacadd", function() {
    var options = { name: "x_codrem", selectId: "fcabfacadd_x_codrem" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcabfacadd.lists.codrem?.lookupOptions.length) {
        options.data = { id: "x_codrem", form: "fcabfacadd" };
    } else {
        options.ajax = { id: "x_codrem", form: "fcabfacadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cabfac.fields.codrem.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <div id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <label id="elh_cabfac_estado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado->caption() ?><?= $Page->estado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estado->cellAttributes() ?>>
<span id="el_cabfac_estado">
<template id="tp_x_estado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cabfac" data-field="x_estado" name="x_estado" id="x_estado"<?= $Page->estado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_estado" class="ew-item-list"></div>
<selection-list hidden
    id="x_estado"
    name="x_estado"
    value="<?= HtmlEncode($Page->estado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_estado"
    data-target="dsl_x_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Page->estado->isInvalidClass() ?>"
    data-table="cabfac"
    data-field="x_estado"
    data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
    <?= $Page->estado->editAttributes() ?>></selection-list>
<?= $Page->estado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->emitido->Visible) { // emitido ?>
    <div id="r_emitido"<?= $Page->emitido->rowAttributes() ?>>
        <label id="elh_cabfac_emitido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->emitido->caption() ?><?= $Page->emitido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->emitido->cellAttributes() ?>>
<span id="el_cabfac_emitido">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->emitido->isInvalidClass() ?>" data-table="cabfac" data-field="x_emitido" data-boolean name="x_emitido" id="x_emitido" value="1"<?= ConvertToBool($Page->emitido->CurrentValue) ? " checked" : "" ?><?= $Page->emitido->editAttributes() ?> aria-describedby="x_emitido_help">
    <div class="invalid-feedback"><?= $Page->emitido->getErrorMessage() ?></div>
</div>
<?= $Page->emitido->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totneto->Visible) { // totneto ?>
    <div id="r_totneto"<?= $Page->totneto->rowAttributes() ?>>
        <label id="elh_cabfac_totneto" for="x_totneto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totneto->caption() ?><?= $Page->totneto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totneto->cellAttributes() ?>>
<span id="el_cabfac_totneto">
<input type="<?= $Page->totneto->getInputTextType() ?>" name="x_totneto" id="x_totneto" data-table="cabfac" data-field="x_totneto" value="<?= $Page->totneto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totneto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totneto->formatPattern()) ?>"<?= $Page->totneto->editAttributes() ?> aria-describedby="x_totneto_help">
<?= $Page->totneto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totneto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totbruto->Visible) { // totbruto ?>
    <div id="r_totbruto"<?= $Page->totbruto->rowAttributes() ?>>
        <label id="elh_cabfac_totbruto" for="x_totbruto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totbruto->caption() ?><?= $Page->totbruto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totbruto->cellAttributes() ?>>
<span id="el_cabfac_totbruto">
<input type="<?= $Page->totbruto->getInputTextType() ?>" name="x_totbruto" id="x_totbruto" data-table="cabfac" data-field="x_totbruto" value="<?= $Page->totbruto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totbruto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totbruto->formatPattern()) ?>"<?= $Page->totbruto->editAttributes() ?> aria-describedby="x_totbruto_help">
<?= $Page->totbruto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totbruto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
    <div id="r_totiva105"<?= $Page->totiva105->rowAttributes() ?>>
        <label id="elh_cabfac_totiva105" for="x_totiva105" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totiva105->caption() ?><?= $Page->totiva105->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totiva105->cellAttributes() ?>>
<span id="el_cabfac_totiva105">
<input type="<?= $Page->totiva105->getInputTextType() ?>" name="x_totiva105" id="x_totiva105" data-table="cabfac" data-field="x_totiva105" value="<?= $Page->totiva105->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totiva105->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totiva105->formatPattern()) ?>"<?= $Page->totiva105->editAttributes() ?> aria-describedby="x_totiva105_help">
<?= $Page->totiva105->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totiva105->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
    <div id="r_totiva21"<?= $Page->totiva21->rowAttributes() ?>>
        <label id="elh_cabfac_totiva21" for="x_totiva21" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totiva21->caption() ?><?= $Page->totiva21->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totiva21->cellAttributes() ?>>
<span id="el_cabfac_totiva21">
<input type="<?= $Page->totiva21->getInputTextType() ?>" name="x_totiva21" id="x_totiva21" data-table="cabfac" data-field="x_totiva21" value="<?= $Page->totiva21->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totiva21->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totiva21->formatPattern()) ?>"<?= $Page->totiva21->editAttributes() ?> aria-describedby="x_totiva21_help">
<?= $Page->totiva21->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totiva21->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totimp->Visible) { // totimp ?>
    <div id="r_totimp"<?= $Page->totimp->rowAttributes() ?>>
        <label id="elh_cabfac_totimp" for="x_totimp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totimp->caption() ?><?= $Page->totimp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totimp->cellAttributes() ?>>
<span id="el_cabfac_totimp">
<input type="<?= $Page->totimp->getInputTextType() ?>" name="x_totimp" id="x_totimp" data-table="cabfac" data-field="x_totimp" value="<?= $Page->totimp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totimp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totimp->formatPattern()) ?>"<?= $Page->totimp->editAttributes() ?> aria-describedby="x_totimp_help">
<?= $Page->totimp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totimp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totcomis->Visible) { // totcomis ?>
    <div id="r_totcomis"<?= $Page->totcomis->rowAttributes() ?>>
        <label id="elh_cabfac_totcomis" for="x_totcomis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totcomis->caption() ?><?= $Page->totcomis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totcomis->cellAttributes() ?>>
<span id="el_cabfac_totcomis">
<input type="<?= $Page->totcomis->getInputTextType() ?>" name="x_totcomis" id="x_totcomis" data-table="cabfac" data-field="x_totcomis" value="<?= $Page->totcomis->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totcomis->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totcomis->formatPattern()) ?>"<?= $Page->totcomis->editAttributes() ?> aria-describedby="x_totcomis_help">
<?= $Page->totcomis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totcomis->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totneto105->Visible) { // totneto105 ?>
    <div id="r_totneto105"<?= $Page->totneto105->rowAttributes() ?>>
        <label id="elh_cabfac_totneto105" for="x_totneto105" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totneto105->caption() ?><?= $Page->totneto105->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totneto105->cellAttributes() ?>>
<span id="el_cabfac_totneto105">
<input type="<?= $Page->totneto105->getInputTextType() ?>" name="x_totneto105" id="x_totneto105" data-table="cabfac" data-field="x_totneto105" value="<?= $Page->totneto105->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totneto105->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totneto105->formatPattern()) ?>"<?= $Page->totneto105->editAttributes() ?> aria-describedby="x_totneto105_help">
<?= $Page->totneto105->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totneto105->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totneto21->Visible) { // totneto21 ?>
    <div id="r_totneto21"<?= $Page->totneto21->rowAttributes() ?>>
        <label id="elh_cabfac_totneto21" for="x_totneto21" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totneto21->caption() ?><?= $Page->totneto21->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totneto21->cellAttributes() ?>>
<span id="el_cabfac_totneto21">
<input type="<?= $Page->totneto21->getInputTextType() ?>" name="x_totneto21" id="x_totneto21" data-table="cabfac" data-field="x_totneto21" value="<?= $Page->totneto21->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totneto21->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totneto21->formatPattern()) ?>"<?= $Page->totneto21->editAttributes() ?> aria-describedby="x_totneto21_help">
<?= $Page->totneto21->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totneto21->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cabfac_porciva">
    <input type="hidden" data-table="cabfac" data-field="x_porciva" data-hidden="1" name="x_porciva" id="x_porciva" value="<?= HtmlEncode($Page->porciva->CurrentValue) ?>">
    </span>
<?php if ($Page->nrengs->Visible) { // nrengs ?>
    <div id="r_nrengs"<?= $Page->nrengs->rowAttributes() ?>>
        <label id="elh_cabfac_nrengs" for="x_nrengs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrengs->caption() ?><?= $Page->nrengs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nrengs->cellAttributes() ?>>
<span id="el_cabfac_nrengs">
<input type="<?= $Page->nrengs->getInputTextType() ?>" name="x_nrengs" id="x_nrengs" data-table="cabfac" data-field="x_nrengs" value="<?= $Page->nrengs->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nrengs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nrengs->formatPattern()) ?>"<?= $Page->nrengs->editAttributes() ?> aria-describedby="x_nrengs_help">
<?= $Page->nrengs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nrengs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_cabfac_tieneresol">
    <input type="hidden" data-table="cabfac" data-field="x_tieneresol" data-hidden="1" name="x_tieneresol" id="x_tieneresol" value="<?= HtmlEncode($Page->tieneresol->CurrentValue) ?>">
    </span>
<?php if ($Page->leyendafc->Visible) { // leyendafc ?>
    <div id="r_leyendafc"<?= $Page->leyendafc->rowAttributes() ?>>
        <label id="elh_cabfac_leyendafc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->leyendafc->caption() ?><?= $Page->leyendafc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->leyendafc->cellAttributes() ?>>
<span id="el_cabfac_leyendafc">
<input type="<?= $Page->leyendafc->getInputTextType() ?>" name="x_leyendafc" id="x_leyendafc" data-table="cabfac" data-field="x_leyendafc" value="<?= $Page->leyendafc->EditValue ?>" maxlength="500" placeholder="<?= HtmlEncode($Page->leyendafc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->leyendafc->formatPattern()) ?>"<?= $Page->leyendafc->editAttributes() ?> aria-describedby="x_leyendafc_help">
<?= $Page->leyendafc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->leyendafc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->concepto->Visible) { // concepto ?>
    <div id="r_concepto"<?= $Page->concepto->rowAttributes() ?>>
        <label id="elh_cabfac_concepto" for="x_concepto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->concepto->caption() ?><?= $Page->concepto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->concepto->cellAttributes() ?>>
<span id="el_cabfac_concepto">
<input type="<?= $Page->concepto->getInputTextType() ?>" name="x_concepto" id="x_concepto" data-table="cabfac" data-field="x_concepto" value="<?= $Page->concepto->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->concepto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->concepto->formatPattern()) ?>"<?= $Page->concepto->editAttributes() ?> aria-describedby="x_concepto_help">
<?= $Page->concepto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->concepto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
    <div id="r_nrodoc"<?= $Page->nrodoc->rowAttributes() ?>>
        <label id="elh_cabfac_nrodoc" for="x_nrodoc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrodoc->caption() ?><?= $Page->nrodoc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el_cabfac_nrodoc">
<input type="<?= $Page->nrodoc->getInputTextType() ?>" name="x_nrodoc" id="x_nrodoc" data-table="cabfac" data-field="x_nrodoc" value="<?= $Page->nrodoc->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nrodoc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nrodoc->formatPattern()) ?>"<?= $Page->nrodoc->editAttributes() ?> aria-describedby="x_nrodoc_help">
<?= $Page->nrodoc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nrodoc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tcompsal->Visible) { // tcompsal ?>
    <div id="r_tcompsal"<?= $Page->tcompsal->rowAttributes() ?>>
        <label id="elh_cabfac_tcompsal" for="x_tcompsal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcompsal->caption() ?><?= $Page->tcompsal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcompsal->cellAttributes() ?>>
<span id="el_cabfac_tcompsal">
<input type="<?= $Page->tcompsal->getInputTextType() ?>" name="x_tcompsal" id="x_tcompsal" data-table="cabfac" data-field="x_tcompsal" value="<?= $Page->tcompsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tcompsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcompsal->formatPattern()) ?>"<?= $Page->tcompsal->editAttributes() ?> aria-describedby="x_tcompsal_help">
<?= $Page->tcompsal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcompsal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
    <div id="r_seriesal"<?= $Page->seriesal->rowAttributes() ?>>
        <label id="elh_cabfac_seriesal" for="x_seriesal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seriesal->caption() ?><?= $Page->seriesal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seriesal->cellAttributes() ?>>
<span id="el_cabfac_seriesal">
<input type="<?= $Page->seriesal->getInputTextType() ?>" name="x_seriesal" id="x_seriesal" data-table="cabfac" data-field="x_seriesal" value="<?= $Page->seriesal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->seriesal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seriesal->formatPattern()) ?>"<?= $Page->seriesal->editAttributes() ?> aria-describedby="x_seriesal_help">
<?= $Page->seriesal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->seriesal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
    <div id="r_ncompsal"<?= $Page->ncompsal->rowAttributes() ?>>
        <label id="elh_cabfac_ncompsal" for="x_ncompsal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncompsal->caption() ?><?= $Page->ncompsal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncompsal->cellAttributes() ?>>
<span id="el_cabfac_ncompsal">
<input type="<?= $Page->ncompsal->getInputTextType() ?>" name="x_ncompsal" id="x_ncompsal" data-table="cabfac" data-field="x_ncompsal" value="<?= $Page->ncompsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncompsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncompsal->formatPattern()) ?>"<?= $Page->ncompsal->editAttributes() ?> aria-describedby="x_ncompsal_help">
<?= $Page->ncompsal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncompsal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->en_liquid->Visible) { // en_liquid ?>
    <div id="r_en_liquid"<?= $Page->en_liquid->rowAttributes() ?>>
        <label id="elh_cabfac_en_liquid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->en_liquid->caption() ?><?= $Page->en_liquid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->en_liquid->cellAttributes() ?>>
<span id="el_cabfac_en_liquid">
<template id="tp_x_en_liquid">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="cabfac" data-field="x_en_liquid" name="x_en_liquid" id="x_en_liquid"<?= $Page->en_liquid->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_en_liquid" class="ew-item-list"></div>
<selection-list hidden
    id="x_en_liquid"
    name="x_en_liquid"
    value="<?= HtmlEncode($Page->en_liquid->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_en_liquid"
    data-target="dsl_x_en_liquid"
    data-repeatcolumn="5"
    class="form-control<?= $Page->en_liquid->isInvalidClass() ?>"
    data-table="cabfac"
    data-field="x_en_liquid"
    data-value-separator="<?= $Page->en_liquid->displayValueSeparatorAttribute() ?>"
    <?= $Page->en_liquid->editAttributes() ?>></selection-list>
<?= $Page->en_liquid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->en_liquid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CAE->Visible) { // CAE ?>
    <div id="r_CAE"<?= $Page->CAE->rowAttributes() ?>>
        <label id="elh_cabfac_CAE" for="x_CAE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CAE->caption() ?><?= $Page->CAE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->CAE->cellAttributes() ?>>
<span id="el_cabfac_CAE">
<input type="<?= $Page->CAE->getInputTextType() ?>" name="x_CAE" id="x_CAE" data-table="cabfac" data-field="x_CAE" value="<?= $Page->CAE->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->CAE->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->CAE->formatPattern()) ?>"<?= $Page->CAE->editAttributes() ?> aria-describedby="x_CAE_help">
<?= $Page->CAE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CAE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CAEFchVto->Visible) { // CAEFchVto ?>
    <div id="r_CAEFchVto"<?= $Page->CAEFchVto->rowAttributes() ?>>
        <label id="elh_cabfac_CAEFchVto" for="x_CAEFchVto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CAEFchVto->caption() ?><?= $Page->CAEFchVto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->CAEFchVto->cellAttributes() ?>>
<span id="el_cabfac_CAEFchVto">
<input type="<?= $Page->CAEFchVto->getInputTextType() ?>" name="x_CAEFchVto" id="x_CAEFchVto" data-table="cabfac" data-field="x_CAEFchVto" value="<?= $Page->CAEFchVto->EditValue ?>" placeholder="<?= HtmlEncode($Page->CAEFchVto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->CAEFchVto->formatPattern()) ?>"<?= $Page->CAEFchVto->editAttributes() ?> aria-describedby="x_CAEFchVto_help">
<?= $Page->CAEFchVto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CAEFchVto->getErrorMessage() ?></div>
<?php if (!$Page->CAEFchVto->ReadOnly && !$Page->CAEFchVto->Disabled && !isset($Page->CAEFchVto->EditAttrs["readonly"]) && !isset($Page->CAEFchVto->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcabfacadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcabfacadd", "x_CAEFchVto", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Resultado->Visible) { // Resultado ?>
    <div id="r_Resultado"<?= $Page->Resultado->rowAttributes() ?>>
        <label id="elh_cabfac_Resultado" for="x_Resultado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Resultado->caption() ?><?= $Page->Resultado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Resultado->cellAttributes() ?>>
<span id="el_cabfac_Resultado">
<input type="<?= $Page->Resultado->getInputTextType() ?>" name="x_Resultado" id="x_Resultado" data-table="cabfac" data-field="x_Resultado" value="<?= $Page->Resultado->EditValue ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->Resultado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Resultado->formatPattern()) ?>"<?= $Page->Resultado->editAttributes() ?> aria-describedby="x_Resultado_help">
<?= $Page->Resultado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Resultado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("detfac", explode(",", $Page->getCurrentDetailTable())) && $detfac->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detfac", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "DetfacGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcabfacadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcabfacadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("cabfac");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
