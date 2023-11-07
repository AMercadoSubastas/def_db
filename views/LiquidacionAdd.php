<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LiquidacionAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { liquidacion: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fliquidacionadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fliquidacionadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null, ew.Validators.integer], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null, ew.Validators.integer], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["cliente", [fields.cliente.visible && fields.cliente.required ? ew.Validators.required(fields.cliente.caption) : null, ew.Validators.integer], fields.cliente.isInvalid],
            ["rubro", [fields.rubro.visible && fields.rubro.required ? ew.Validators.required(fields.rubro.caption) : null], fields.rubro.isInvalid],
            ["calle", [fields.calle.visible && fields.calle.required ? ew.Validators.required(fields.calle.caption) : null], fields.calle.isInvalid],
            ["dnro", [fields.dnro.visible && fields.dnro.required ? ew.Validators.required(fields.dnro.caption) : null], fields.dnro.isInvalid],
            ["pisodto", [fields.pisodto.visible && fields.pisodto.required ? ew.Validators.required(fields.pisodto.caption) : null], fields.pisodto.isInvalid],
            ["codpost", [fields.codpost.visible && fields.codpost.required ? ew.Validators.required(fields.codpost.caption) : null], fields.codpost.isInvalid],
            ["codpais", [fields.codpais.visible && fields.codpais.required ? ew.Validators.required(fields.codpais.caption) : null, ew.Validators.integer], fields.codpais.isInvalid],
            ["codprov", [fields.codprov.visible && fields.codprov.required ? ew.Validators.required(fields.codprov.caption) : null, ew.Validators.integer], fields.codprov.isInvalid],
            ["codloc", [fields.codloc.visible && fields.codloc.required ? ew.Validators.required(fields.codloc.caption) : null, ew.Validators.integer], fields.codloc.isInvalid],
            ["codrem", [fields.codrem.visible && fields.codrem.required ? ew.Validators.required(fields.codrem.caption) : null, ew.Validators.integer], fields.codrem.isInvalid],
            ["fecharem", [fields.fecharem.visible && fields.fecharem.required ? ew.Validators.required(fields.fecharem.caption) : null, ew.Validators.datetime(fields.fecharem.clientFormatPattern)], fields.fecharem.isInvalid],
            ["cuit", [fields.cuit.visible && fields.cuit.required ? ew.Validators.required(fields.cuit.caption) : null], fields.cuit.isInvalid],
            ["tipoiva", [fields.tipoiva.visible && fields.tipoiva.required ? ew.Validators.required(fields.tipoiva.caption) : null, ew.Validators.integer], fields.tipoiva.isInvalid],
            ["totremate", [fields.totremate.visible && fields.totremate.required ? ew.Validators.required(fields.totremate.caption) : null, ew.Validators.float], fields.totremate.isInvalid],
            ["totneto1", [fields.totneto1.visible && fields.totneto1.required ? ew.Validators.required(fields.totneto1.caption) : null, ew.Validators.float], fields.totneto1.isInvalid],
            ["totiva21", [fields.totiva21.visible && fields.totiva21.required ? ew.Validators.required(fields.totiva21.caption) : null, ew.Validators.float], fields.totiva21.isInvalid],
            ["subtot1", [fields.subtot1.visible && fields.subtot1.required ? ew.Validators.required(fields.subtot1.caption) : null, ew.Validators.float], fields.subtot1.isInvalid],
            ["totneto2", [fields.totneto2.visible && fields.totneto2.required ? ew.Validators.required(fields.totneto2.caption) : null, ew.Validators.float], fields.totneto2.isInvalid],
            ["totiva105", [fields.totiva105.visible && fields.totiva105.required ? ew.Validators.required(fields.totiva105.caption) : null, ew.Validators.float], fields.totiva105.isInvalid],
            ["subtot2", [fields.subtot2.visible && fields.subtot2.required ? ew.Validators.required(fields.subtot2.caption) : null, ew.Validators.float], fields.subtot2.isInvalid],
            ["totacuenta", [fields.totacuenta.visible && fields.totacuenta.required ? ew.Validators.required(fields.totacuenta.caption) : null, ew.Validators.float], fields.totacuenta.isInvalid],
            ["totgastos", [fields.totgastos.visible && fields.totgastos.required ? ew.Validators.required(fields.totgastos.caption) : null, ew.Validators.float], fields.totgastos.isInvalid],
            ["totvarios", [fields.totvarios.visible && fields.totvarios.required ? ew.Validators.required(fields.totvarios.caption) : null, ew.Validators.float], fields.totvarios.isInvalid],
            ["saldoafav", [fields.saldoafav.visible && fields.saldoafav.required ? ew.Validators.required(fields.saldoafav.caption) : null, ew.Validators.float], fields.saldoafav.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null, ew.Validators.datetime(fields.fechahora.clientFormatPattern)], fields.fechahora.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null, ew.Validators.integer], fields.usuario.isInvalid],
            ["fechaliq", [fields.fechaliq.visible && fields.fechaliq.required ? ew.Validators.required(fields.fechaliq.caption) : null, ew.Validators.datetime(fields.fechaliq.clientFormatPattern)], fields.fechaliq.isInvalid],
            ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
            ["nrodoc", [fields.nrodoc.visible && fields.nrodoc.required ? ew.Validators.required(fields.nrodoc.caption) : null], fields.nrodoc.isInvalid],
            ["cotiz", [fields.cotiz.visible && fields.cotiz.required ? ew.Validators.required(fields.cotiz.caption) : null, ew.Validators.float], fields.cotiz.isInvalid],
            ["fecultmod", [fields.fecultmod.visible && fields.fecultmod.required ? ew.Validators.required(fields.fecultmod.caption) : null, ew.Validators.datetime(fields.fecultmod.clientFormatPattern)], fields.fecultmod.isInvalid]
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
<form name="fliquidacionadd" id="fliquidacionadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="liquidacion">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <div id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <label id="elh_liquidacion_tcomp" for="x_tcomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomp->caption() ?><?= $Page->tcomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_liquidacion_tcomp">
<input type="<?= $Page->tcomp->getInputTextType() ?>" name="x_tcomp" id="x_tcomp" data-table="liquidacion" data-field="x_tcomp" value="<?= $Page->tcomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tcomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcomp->formatPattern()) ?>"<?= $Page->tcomp->editAttributes() ?> aria-describedby="x_tcomp_help">
<?= $Page->tcomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcomp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <div id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <label id="elh_liquidacion_serie" for="x_serie" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serie->caption() ?><?= $Page->serie->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serie->cellAttributes() ?>>
<span id="el_liquidacion_serie">
<input type="<?= $Page->serie->getInputTextType() ?>" name="x_serie" id="x_serie" data-table="liquidacion" data-field="x_serie" value="<?= $Page->serie->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->serie->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->serie->formatPattern()) ?>"<?= $Page->serie->editAttributes() ?> aria-describedby="x_serie_help">
<?= $Page->serie->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serie->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <div id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <label id="elh_liquidacion_ncomp" for="x_ncomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomp->caption() ?><?= $Page->ncomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_liquidacion_ncomp">
<input type="<?= $Page->ncomp->getInputTextType() ?>" name="x_ncomp" id="x_ncomp" data-table="liquidacion" data-field="x_ncomp" value="<?= $Page->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomp->formatPattern()) ?>"<?= $Page->ncomp->editAttributes() ?> aria-describedby="x_ncomp_help">
<?= $Page->ncomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cliente->Visible) { // cliente ?>
    <div id="r_cliente"<?= $Page->cliente->rowAttributes() ?>>
        <label id="elh_liquidacion_cliente" for="x_cliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cliente->caption() ?><?= $Page->cliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cliente->cellAttributes() ?>>
<span id="el_liquidacion_cliente">
<input type="<?= $Page->cliente->getInputTextType() ?>" name="x_cliente" id="x_cliente" data-table="liquidacion" data-field="x_cliente" value="<?= $Page->cliente->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cliente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cliente->formatPattern()) ?>"<?= $Page->cliente->editAttributes() ?> aria-describedby="x_cliente_help">
<?= $Page->cliente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cliente->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rubro->Visible) { // rubro ?>
    <div id="r_rubro"<?= $Page->rubro->rowAttributes() ?>>
        <label id="elh_liquidacion_rubro" for="x_rubro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rubro->caption() ?><?= $Page->rubro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rubro->cellAttributes() ?>>
<span id="el_liquidacion_rubro">
<input type="<?= $Page->rubro->getInputTextType() ?>" name="x_rubro" id="x_rubro" data-table="liquidacion" data-field="x_rubro" value="<?= $Page->rubro->EditValue ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->rubro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rubro->formatPattern()) ?>"<?= $Page->rubro->editAttributes() ?> aria-describedby="x_rubro_help">
<?= $Page->rubro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rubro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
    <div id="r_calle"<?= $Page->calle->rowAttributes() ?>>
        <label id="elh_liquidacion_calle" for="x_calle" class="<?= $Page->LeftColumnClass ?>"><?= $Page->calle->caption() ?><?= $Page->calle->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->calle->cellAttributes() ?>>
<span id="el_liquidacion_calle">
<input type="<?= $Page->calle->getInputTextType() ?>" name="x_calle" id="x_calle" data-table="liquidacion" data-field="x_calle" value="<?= $Page->calle->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->calle->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->calle->formatPattern()) ?>"<?= $Page->calle->editAttributes() ?> aria-describedby="x_calle_help">
<?= $Page->calle->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->calle->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dnro->Visible) { // dnro ?>
    <div id="r_dnro"<?= $Page->dnro->rowAttributes() ?>>
        <label id="elh_liquidacion_dnro" for="x_dnro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dnro->caption() ?><?= $Page->dnro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dnro->cellAttributes() ?>>
<span id="el_liquidacion_dnro">
<input type="<?= $Page->dnro->getInputTextType() ?>" name="x_dnro" id="x_dnro" data-table="liquidacion" data-field="x_dnro" value="<?= $Page->dnro->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->dnro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dnro->formatPattern()) ?>"<?= $Page->dnro->editAttributes() ?> aria-describedby="x_dnro_help">
<?= $Page->dnro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dnro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
    <div id="r_pisodto"<?= $Page->pisodto->rowAttributes() ?>>
        <label id="elh_liquidacion_pisodto" for="x_pisodto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pisodto->caption() ?><?= $Page->pisodto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pisodto->cellAttributes() ?>>
<span id="el_liquidacion_pisodto">
<input type="<?= $Page->pisodto->getInputTextType() ?>" name="x_pisodto" id="x_pisodto" data-table="liquidacion" data-field="x_pisodto" value="<?= $Page->pisodto->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->pisodto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->pisodto->formatPattern()) ?>"<?= $Page->pisodto->editAttributes() ?> aria-describedby="x_pisodto_help">
<?= $Page->pisodto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pisodto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
    <div id="r_codpost"<?= $Page->codpost->rowAttributes() ?>>
        <label id="elh_liquidacion_codpost" for="x_codpost" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpost->caption() ?><?= $Page->codpost->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpost->cellAttributes() ?>>
<span id="el_liquidacion_codpost">
<input type="<?= $Page->codpost->getInputTextType() ?>" name="x_codpost" id="x_codpost" data-table="liquidacion" data-field="x_codpost" value="<?= $Page->codpost->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->codpost->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codpost->formatPattern()) ?>"<?= $Page->codpost->editAttributes() ?> aria-describedby="x_codpost_help">
<?= $Page->codpost->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codpost->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <div id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <label id="elh_liquidacion_codpais" for="x_codpais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpais->caption() ?><?= $Page->codpais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpais->cellAttributes() ?>>
<span id="el_liquidacion_codpais">
<input type="<?= $Page->codpais->getInputTextType() ?>" name="x_codpais" id="x_codpais" data-table="liquidacion" data-field="x_codpais" value="<?= $Page->codpais->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codpais->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codpais->formatPattern()) ?>"<?= $Page->codpais->editAttributes() ?> aria-describedby="x_codpais_help">
<?= $Page->codpais->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codpais->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codprov->Visible) { // codprov ?>
    <div id="r_codprov"<?= $Page->codprov->rowAttributes() ?>>
        <label id="elh_liquidacion_codprov" for="x_codprov" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codprov->caption() ?><?= $Page->codprov->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codprov->cellAttributes() ?>>
<span id="el_liquidacion_codprov">
<input type="<?= $Page->codprov->getInputTextType() ?>" name="x_codprov" id="x_codprov" data-table="liquidacion" data-field="x_codprov" value="<?= $Page->codprov->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codprov->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codprov->formatPattern()) ?>"<?= $Page->codprov->editAttributes() ?> aria-describedby="x_codprov_help">
<?= $Page->codprov->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codprov->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
    <div id="r_codloc"<?= $Page->codloc->rowAttributes() ?>>
        <label id="elh_liquidacion_codloc" for="x_codloc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codloc->caption() ?><?= $Page->codloc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codloc->cellAttributes() ?>>
<span id="el_liquidacion_codloc">
<input type="<?= $Page->codloc->getInputTextType() ?>" name="x_codloc" id="x_codloc" data-table="liquidacion" data-field="x_codloc" value="<?= $Page->codloc->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codloc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codloc->formatPattern()) ?>"<?= $Page->codloc->editAttributes() ?> aria-describedby="x_codloc_help">
<?= $Page->codloc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codloc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <div id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <label id="elh_liquidacion_codrem" for="x_codrem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codrem->caption() ?><?= $Page->codrem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codrem->cellAttributes() ?>>
<span id="el_liquidacion_codrem">
<input type="<?= $Page->codrem->getInputTextType() ?>" name="x_codrem" id="x_codrem" data-table="liquidacion" data-field="x_codrem" value="<?= $Page->codrem->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codrem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codrem->formatPattern()) ?>"<?= $Page->codrem->editAttributes() ?> aria-describedby="x_codrem_help">
<?= $Page->codrem->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codrem->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecharem->Visible) { // fecharem ?>
    <div id="r_fecharem"<?= $Page->fecharem->rowAttributes() ?>>
        <label id="elh_liquidacion_fecharem" for="x_fecharem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecharem->caption() ?><?= $Page->fecharem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecharem->cellAttributes() ?>>
<span id="el_liquidacion_fecharem">
<input type="<?= $Page->fecharem->getInputTextType() ?>" name="x_fecharem" id="x_fecharem" data-table="liquidacion" data-field="x_fecharem" value="<?= $Page->fecharem->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecharem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecharem->formatPattern()) ?>"<?= $Page->fecharem->editAttributes() ?> aria-describedby="x_fecharem_help">
<?= $Page->fecharem->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecharem->getErrorMessage() ?></div>
<?php if (!$Page->fecharem->ReadOnly && !$Page->fecharem->Disabled && !isset($Page->fecharem->EditAttrs["readonly"]) && !isset($Page->fecharem->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fliquidacionadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fliquidacionadd", "x_fecharem", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
    <div id="r_cuit"<?= $Page->cuit->rowAttributes() ?>>
        <label id="elh_liquidacion_cuit" for="x_cuit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuit->caption() ?><?= $Page->cuit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuit->cellAttributes() ?>>
<span id="el_liquidacion_cuit">
<input type="<?= $Page->cuit->getInputTextType() ?>" name="x_cuit" id="x_cuit" data-table="liquidacion" data-field="x_cuit" value="<?= $Page->cuit->EditValue ?>" size="30" maxlength="14" placeholder="<?= HtmlEncode($Page->cuit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cuit->formatPattern()) ?>"<?= $Page->cuit->editAttributes() ?> aria-describedby="x_cuit_help">
<?= $Page->cuit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipoiva->Visible) { // tipoiva ?>
    <div id="r_tipoiva"<?= $Page->tipoiva->rowAttributes() ?>>
        <label id="elh_liquidacion_tipoiva" for="x_tipoiva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipoiva->caption() ?><?= $Page->tipoiva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el_liquidacion_tipoiva">
<input type="<?= $Page->tipoiva->getInputTextType() ?>" name="x_tipoiva" id="x_tipoiva" data-table="liquidacion" data-field="x_tipoiva" value="<?= $Page->tipoiva->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tipoiva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipoiva->formatPattern()) ?>"<?= $Page->tipoiva->editAttributes() ?> aria-describedby="x_tipoiva_help">
<?= $Page->tipoiva->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipoiva->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totremate->Visible) { // totremate ?>
    <div id="r_totremate"<?= $Page->totremate->rowAttributes() ?>>
        <label id="elh_liquidacion_totremate" for="x_totremate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totremate->caption() ?><?= $Page->totremate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totremate->cellAttributes() ?>>
<span id="el_liquidacion_totremate">
<input type="<?= $Page->totremate->getInputTextType() ?>" name="x_totremate" id="x_totremate" data-table="liquidacion" data-field="x_totremate" value="<?= $Page->totremate->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totremate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totremate->formatPattern()) ?>"<?= $Page->totremate->editAttributes() ?> aria-describedby="x_totremate_help">
<?= $Page->totremate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totremate->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totneto1->Visible) { // totneto1 ?>
    <div id="r_totneto1"<?= $Page->totneto1->rowAttributes() ?>>
        <label id="elh_liquidacion_totneto1" for="x_totneto1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totneto1->caption() ?><?= $Page->totneto1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totneto1->cellAttributes() ?>>
<span id="el_liquidacion_totneto1">
<input type="<?= $Page->totneto1->getInputTextType() ?>" name="x_totneto1" id="x_totneto1" data-table="liquidacion" data-field="x_totneto1" value="<?= $Page->totneto1->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totneto1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totneto1->formatPattern()) ?>"<?= $Page->totneto1->editAttributes() ?> aria-describedby="x_totneto1_help">
<?= $Page->totneto1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totneto1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totiva21->Visible) { // totiva21 ?>
    <div id="r_totiva21"<?= $Page->totiva21->rowAttributes() ?>>
        <label id="elh_liquidacion_totiva21" for="x_totiva21" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totiva21->caption() ?><?= $Page->totiva21->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totiva21->cellAttributes() ?>>
<span id="el_liquidacion_totiva21">
<input type="<?= $Page->totiva21->getInputTextType() ?>" name="x_totiva21" id="x_totiva21" data-table="liquidacion" data-field="x_totiva21" value="<?= $Page->totiva21->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totiva21->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totiva21->formatPattern()) ?>"<?= $Page->totiva21->editAttributes() ?> aria-describedby="x_totiva21_help">
<?= $Page->totiva21->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totiva21->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subtot1->Visible) { // subtot1 ?>
    <div id="r_subtot1"<?= $Page->subtot1->rowAttributes() ?>>
        <label id="elh_liquidacion_subtot1" for="x_subtot1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subtot1->caption() ?><?= $Page->subtot1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subtot1->cellAttributes() ?>>
<span id="el_liquidacion_subtot1">
<input type="<?= $Page->subtot1->getInputTextType() ?>" name="x_subtot1" id="x_subtot1" data-table="liquidacion" data-field="x_subtot1" value="<?= $Page->subtot1->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->subtot1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->subtot1->formatPattern()) ?>"<?= $Page->subtot1->editAttributes() ?> aria-describedby="x_subtot1_help">
<?= $Page->subtot1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subtot1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totneto2->Visible) { // totneto2 ?>
    <div id="r_totneto2"<?= $Page->totneto2->rowAttributes() ?>>
        <label id="elh_liquidacion_totneto2" for="x_totneto2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totneto2->caption() ?><?= $Page->totneto2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totneto2->cellAttributes() ?>>
<span id="el_liquidacion_totneto2">
<input type="<?= $Page->totneto2->getInputTextType() ?>" name="x_totneto2" id="x_totneto2" data-table="liquidacion" data-field="x_totneto2" value="<?= $Page->totneto2->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totneto2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totneto2->formatPattern()) ?>"<?= $Page->totneto2->editAttributes() ?> aria-describedby="x_totneto2_help">
<?= $Page->totneto2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totneto2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totiva105->Visible) { // totiva105 ?>
    <div id="r_totiva105"<?= $Page->totiva105->rowAttributes() ?>>
        <label id="elh_liquidacion_totiva105" for="x_totiva105" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totiva105->caption() ?><?= $Page->totiva105->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totiva105->cellAttributes() ?>>
<span id="el_liquidacion_totiva105">
<input type="<?= $Page->totiva105->getInputTextType() ?>" name="x_totiva105" id="x_totiva105" data-table="liquidacion" data-field="x_totiva105" value="<?= $Page->totiva105->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totiva105->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totiva105->formatPattern()) ?>"<?= $Page->totiva105->editAttributes() ?> aria-describedby="x_totiva105_help">
<?= $Page->totiva105->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totiva105->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subtot2->Visible) { // subtot2 ?>
    <div id="r_subtot2"<?= $Page->subtot2->rowAttributes() ?>>
        <label id="elh_liquidacion_subtot2" for="x_subtot2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subtot2->caption() ?><?= $Page->subtot2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subtot2->cellAttributes() ?>>
<span id="el_liquidacion_subtot2">
<input type="<?= $Page->subtot2->getInputTextType() ?>" name="x_subtot2" id="x_subtot2" data-table="liquidacion" data-field="x_subtot2" value="<?= $Page->subtot2->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->subtot2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->subtot2->formatPattern()) ?>"<?= $Page->subtot2->editAttributes() ?> aria-describedby="x_subtot2_help">
<?= $Page->subtot2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subtot2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totacuenta->Visible) { // totacuenta ?>
    <div id="r_totacuenta"<?= $Page->totacuenta->rowAttributes() ?>>
        <label id="elh_liquidacion_totacuenta" for="x_totacuenta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totacuenta->caption() ?><?= $Page->totacuenta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totacuenta->cellAttributes() ?>>
<span id="el_liquidacion_totacuenta">
<input type="<?= $Page->totacuenta->getInputTextType() ?>" name="x_totacuenta" id="x_totacuenta" data-table="liquidacion" data-field="x_totacuenta" value="<?= $Page->totacuenta->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totacuenta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totacuenta->formatPattern()) ?>"<?= $Page->totacuenta->editAttributes() ?> aria-describedby="x_totacuenta_help">
<?= $Page->totacuenta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totacuenta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totgastos->Visible) { // totgastos ?>
    <div id="r_totgastos"<?= $Page->totgastos->rowAttributes() ?>>
        <label id="elh_liquidacion_totgastos" for="x_totgastos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totgastos->caption() ?><?= $Page->totgastos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totgastos->cellAttributes() ?>>
<span id="el_liquidacion_totgastos">
<input type="<?= $Page->totgastos->getInputTextType() ?>" name="x_totgastos" id="x_totgastos" data-table="liquidacion" data-field="x_totgastos" value="<?= $Page->totgastos->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totgastos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totgastos->formatPattern()) ?>"<?= $Page->totgastos->editAttributes() ?> aria-describedby="x_totgastos_help">
<?= $Page->totgastos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totgastos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totvarios->Visible) { // totvarios ?>
    <div id="r_totvarios"<?= $Page->totvarios->rowAttributes() ?>>
        <label id="elh_liquidacion_totvarios" for="x_totvarios" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totvarios->caption() ?><?= $Page->totvarios->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->totvarios->cellAttributes() ?>>
<span id="el_liquidacion_totvarios">
<input type="<?= $Page->totvarios->getInputTextType() ?>" name="x_totvarios" id="x_totvarios" data-table="liquidacion" data-field="x_totvarios" value="<?= $Page->totvarios->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->totvarios->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->totvarios->formatPattern()) ?>"<?= $Page->totvarios->editAttributes() ?> aria-describedby="x_totvarios_help">
<?= $Page->totvarios->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totvarios->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->saldoafav->Visible) { // saldoafav ?>
    <div id="r_saldoafav"<?= $Page->saldoafav->rowAttributes() ?>>
        <label id="elh_liquidacion_saldoafav" for="x_saldoafav" class="<?= $Page->LeftColumnClass ?>"><?= $Page->saldoafav->caption() ?><?= $Page->saldoafav->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->saldoafav->cellAttributes() ?>>
<span id="el_liquidacion_saldoafav">
<input type="<?= $Page->saldoafav->getInputTextType() ?>" name="x_saldoafav" id="x_saldoafav" data-table="liquidacion" data-field="x_saldoafav" value="<?= $Page->saldoafav->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->saldoafav->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->saldoafav->formatPattern()) ?>"<?= $Page->saldoafav->editAttributes() ?> aria-describedby="x_saldoafav_help">
<?= $Page->saldoafav->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->saldoafav->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <div id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <label id="elh_liquidacion_fechahora" for="x_fechahora" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechahora->caption() ?><?= $Page->fechahora->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_liquidacion_fechahora">
<input type="<?= $Page->fechahora->getInputTextType() ?>" name="x_fechahora" id="x_fechahora" data-table="liquidacion" data-field="x_fechahora" value="<?= $Page->fechahora->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechahora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechahora->formatPattern()) ?>"<?= $Page->fechahora->editAttributes() ?> aria-describedby="x_fechahora_help">
<?= $Page->fechahora->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechahora->getErrorMessage() ?></div>
<?php if (!$Page->fechahora->ReadOnly && !$Page->fechahora->Disabled && !isset($Page->fechahora->EditAttrs["readonly"]) && !isset($Page->fechahora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fliquidacionadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fliquidacionadd", "x_fechahora", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <div id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <label id="elh_liquidacion_usuario" for="x_usuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario->caption() ?><?= $Page->usuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario->cellAttributes() ?>>
<span id="el_liquidacion_usuario">
<input type="<?= $Page->usuario->getInputTextType() ?>" name="x_usuario" id="x_usuario" data-table="liquidacion" data-field="x_usuario" value="<?= $Page->usuario->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->usuario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->usuario->formatPattern()) ?>"<?= $Page->usuario->editAttributes() ?> aria-describedby="x_usuario_help">
<?= $Page->usuario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->usuario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechaliq->Visible) { // fechaliq ?>
    <div id="r_fechaliq"<?= $Page->fechaliq->rowAttributes() ?>>
        <label id="elh_liquidacion_fechaliq" for="x_fechaliq" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechaliq->caption() ?><?= $Page->fechaliq->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechaliq->cellAttributes() ?>>
<span id="el_liquidacion_fechaliq">
<input type="<?= $Page->fechaliq->getInputTextType() ?>" name="x_fechaliq" id="x_fechaliq" data-table="liquidacion" data-field="x_fechaliq" value="<?= $Page->fechaliq->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechaliq->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechaliq->formatPattern()) ?>"<?= $Page->fechaliq->editAttributes() ?> aria-describedby="x_fechaliq_help">
<?= $Page->fechaliq->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechaliq->getErrorMessage() ?></div>
<?php if (!$Page->fechaliq->ReadOnly && !$Page->fechaliq->Disabled && !isset($Page->fechaliq->EditAttrs["readonly"]) && !isset($Page->fechaliq->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fliquidacionadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fliquidacionadd", "x_fechaliq", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <div id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <label id="elh_liquidacion_estado" for="x_estado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado->caption() ?><?= $Page->estado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estado->cellAttributes() ?>>
<span id="el_liquidacion_estado">
<input type="<?= $Page->estado->getInputTextType() ?>" name="x_estado" id="x_estado" data-table="liquidacion" data-field="x_estado" value="<?= $Page->estado->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->estado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->estado->formatPattern()) ?>"<?= $Page->estado->editAttributes() ?> aria-describedby="x_estado_help">
<?= $Page->estado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
    <div id="r_nrodoc"<?= $Page->nrodoc->rowAttributes() ?>>
        <label id="elh_liquidacion_nrodoc" for="x_nrodoc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrodoc->caption() ?><?= $Page->nrodoc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el_liquidacion_nrodoc">
<input type="<?= $Page->nrodoc->getInputTextType() ?>" name="x_nrodoc" id="x_nrodoc" data-table="liquidacion" data-field="x_nrodoc" value="<?= $Page->nrodoc->EditValue ?>" size="30" maxlength="14" placeholder="<?= HtmlEncode($Page->nrodoc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nrodoc->formatPattern()) ?>"<?= $Page->nrodoc->editAttributes() ?> aria-describedby="x_nrodoc_help">
<?= $Page->nrodoc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nrodoc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cotiz->Visible) { // cotiz ?>
    <div id="r_cotiz"<?= $Page->cotiz->rowAttributes() ?>>
        <label id="elh_liquidacion_cotiz" for="x_cotiz" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cotiz->caption() ?><?= $Page->cotiz->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cotiz->cellAttributes() ?>>
<span id="el_liquidacion_cotiz">
<input type="<?= $Page->cotiz->getInputTextType() ?>" name="x_cotiz" id="x_cotiz" data-table="liquidacion" data-field="x_cotiz" value="<?= $Page->cotiz->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cotiz->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cotiz->formatPattern()) ?>"<?= $Page->cotiz->editAttributes() ?> aria-describedby="x_cotiz_help">
<?= $Page->cotiz->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cotiz->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
    <div id="r_fecultmod"<?= $Page->fecultmod->rowAttributes() ?>>
        <label id="elh_liquidacion_fecultmod" for="x_fecultmod" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecultmod->caption() ?><?= $Page->fecultmod->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecultmod->cellAttributes() ?>>
<span id="el_liquidacion_fecultmod">
<input type="<?= $Page->fecultmod->getInputTextType() ?>" name="x_fecultmod" id="x_fecultmod" data-table="liquidacion" data-field="x_fecultmod" value="<?= $Page->fecultmod->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecultmod->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecultmod->formatPattern()) ?>"<?= $Page->fecultmod->editAttributes() ?> aria-describedby="x_fecultmod_help">
<?= $Page->fecultmod->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecultmod->getErrorMessage() ?></div>
<?php if (!$Page->fecultmod->ReadOnly && !$Page->fecultmod->Disabled && !isset($Page->fecultmod->EditAttrs["readonly"]) && !isset($Page->fecultmod->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fliquidacionadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fliquidacionadd", "x_fecultmod", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fliquidacionadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fliquidacionadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("liquidacion");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
