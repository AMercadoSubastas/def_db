<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$EntidadesEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fentidadesedit" id="fentidadesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { entidades: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fentidadesedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fentidadesedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["razsoc", [fields.razsoc.visible && fields.razsoc.required ? ew.Validators.required(fields.razsoc.caption) : null], fields.razsoc.isInvalid],
            ["calle", [fields.calle.visible && fields.calle.required ? ew.Validators.required(fields.calle.caption) : null], fields.calle.isInvalid],
            ["numero", [fields.numero.visible && fields.numero.required ? ew.Validators.required(fields.numero.caption) : null], fields.numero.isInvalid],
            ["pisodto", [fields.pisodto.visible && fields.pisodto.required ? ew.Validators.required(fields.pisodto.caption) : null], fields.pisodto.isInvalid],
            ["codpais", [fields.codpais.visible && fields.codpais.required ? ew.Validators.required(fields.codpais.caption) : null], fields.codpais.isInvalid],
            ["codprov", [fields.codprov.visible && fields.codprov.required ? ew.Validators.required(fields.codprov.caption) : null], fields.codprov.isInvalid],
            ["codloc", [fields.codloc.visible && fields.codloc.required ? ew.Validators.required(fields.codloc.caption) : null], fields.codloc.isInvalid],
            ["codpost", [fields.codpost.visible && fields.codpost.required ? ew.Validators.required(fields.codpost.caption) : null], fields.codpost.isInvalid],
            ["tellinea", [fields.tellinea.visible && fields.tellinea.required ? ew.Validators.required(fields.tellinea.caption) : null], fields.tellinea.isInvalid],
            ["telcelu", [fields.telcelu.visible && fields.telcelu.required ? ew.Validators.required(fields.telcelu.caption) : null], fields.telcelu.isInvalid],
            ["tipoent", [fields.tipoent.visible && fields.tipoent.required ? ew.Validators.required(fields.tipoent.caption) : null], fields.tipoent.isInvalid],
            ["tipoiva", [fields.tipoiva.visible && fields.tipoiva.required ? ew.Validators.required(fields.tipoiva.caption) : null], fields.tipoiva.isInvalid],
            ["cuit", [fields.cuit.visible && fields.cuit.required ? ew.Validators.required(fields.cuit.caption) : null], fields.cuit.isInvalid],
            ["calif", [fields.calif.visible && fields.calif.required ? ew.Validators.required(fields.calif.caption) : null], fields.calif.isInvalid],
            ["fecalta", [fields.fecalta.visible && fields.fecalta.required ? ew.Validators.required(fields.fecalta.caption) : null, ew.Validators.datetime(fields.fecalta.clientFormatPattern)], fields.fecalta.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["contacto", [fields.contacto.visible && fields.contacto.required ? ew.Validators.required(fields.contacto.caption) : null], fields.contacto.isInvalid],
            ["mailcont", [fields.mailcont.visible && fields.mailcont.required ? ew.Validators.required(fields.mailcont.caption) : null, ew.Validators.email], fields.mailcont.isInvalid],
            ["cargo", [fields.cargo.visible && fields.cargo.required ? ew.Validators.required(fields.cargo.caption) : null], fields.cargo.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null], fields.fechahora.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid],
            ["pagweb", [fields.pagweb.visible && fields.pagweb.required ? ew.Validators.required(fields.pagweb.caption) : null], fields.pagweb.isInvalid],
            ["tipoind", [fields.tipoind.visible && fields.tipoind.required ? ew.Validators.required(fields.tipoind.caption) : null], fields.tipoind.isInvalid],
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
            "codpais": <?= $Page->codpais->toClientList($Page) ?>,
            "codprov": <?= $Page->codprov->toClientList($Page) ?>,
            "codloc": <?= $Page->codloc->toClientList($Page) ?>,
            "tipoent": <?= $Page->tipoent->toClientList($Page) ?>,
            "tipoiva": <?= $Page->tipoiva->toClientList($Page) ?>,
            "cuit": <?= $Page->cuit->toClientList($Page) ?>,
            "calif": <?= $Page->calif->toClientList($Page) ?>,
            "activo": <?= $Page->activo->toClientList($Page) ?>,
            "tipoind": <?= $Page->tipoind->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="entidades">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->razsoc->Visible) { // razsoc ?>
    <div id="r_razsoc"<?= $Page->razsoc->rowAttributes() ?>>
        <label id="elh_entidades_razsoc" for="x_razsoc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->razsoc->caption() ?><?= $Page->razsoc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->razsoc->cellAttributes() ?>>
<span id="el_entidades_razsoc">
<input type="<?= $Page->razsoc->getInputTextType() ?>" name="x_razsoc" id="x_razsoc" data-table="entidades" data-field="x_razsoc" value="<?= $Page->razsoc->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->razsoc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->razsoc->formatPattern()) ?>"<?= $Page->razsoc->editAttributes() ?> aria-describedby="x_razsoc_help">
<?= $Page->razsoc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->razsoc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->calle->Visible) { // calle ?>
    <div id="r_calle"<?= $Page->calle->rowAttributes() ?>>
        <label id="elh_entidades_calle" for="x_calle" class="<?= $Page->LeftColumnClass ?>"><?= $Page->calle->caption() ?><?= $Page->calle->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->calle->cellAttributes() ?>>
<span id="el_entidades_calle">
<input type="<?= $Page->calle->getInputTextType() ?>" name="x_calle" id="x_calle" data-table="entidades" data-field="x_calle" value="<?= $Page->calle->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->calle->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->calle->formatPattern()) ?>"<?= $Page->calle->editAttributes() ?> aria-describedby="x_calle_help">
<?= $Page->calle->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->calle->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->numero->Visible) { // numero ?>
    <div id="r_numero"<?= $Page->numero->rowAttributes() ?>>
        <label id="elh_entidades_numero" for="x_numero" class="<?= $Page->LeftColumnClass ?>"><?= $Page->numero->caption() ?><?= $Page->numero->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->numero->cellAttributes() ?>>
<span id="el_entidades_numero">
<input type="<?= $Page->numero->getInputTextType() ?>" name="x_numero" id="x_numero" data-table="entidades" data-field="x_numero" value="<?= $Page->numero->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->numero->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->numero->formatPattern()) ?>"<?= $Page->numero->editAttributes() ?> aria-describedby="x_numero_help">
<?= $Page->numero->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->numero->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pisodto->Visible) { // pisodto ?>
    <div id="r_pisodto"<?= $Page->pisodto->rowAttributes() ?>>
        <label id="elh_entidades_pisodto" for="x_pisodto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pisodto->caption() ?><?= $Page->pisodto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pisodto->cellAttributes() ?>>
<span id="el_entidades_pisodto">
<input type="<?= $Page->pisodto->getInputTextType() ?>" name="x_pisodto" id="x_pisodto" data-table="entidades" data-field="x_pisodto" value="<?= $Page->pisodto->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->pisodto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->pisodto->formatPattern()) ?>"<?= $Page->pisodto->editAttributes() ?> aria-describedby="x_pisodto_help">
<?= $Page->pisodto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pisodto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <div id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <label id="elh_entidades_codpais" for="x_codpais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpais->caption() ?><?= $Page->codpais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpais->cellAttributes() ?>>
<span id="el_entidades_codpais">
    <select
        id="x_codpais"
        name="x_codpais"
        class="form-select ew-select<?= $Page->codpais->isInvalidClass() ?>"
        <?php if (!$Page->codpais->IsNativeSelect) { ?>
        data-select2-id="fentidadesedit_x_codpais"
        <?php } ?>
        data-table="entidades"
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
loadjs.ready("fentidadesedit", function() {
    var options = { name: "x_codpais", selectId: "fentidadesedit_x_codpais" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fentidadesedit.lists.codpais?.lookupOptions.length) {
        options.data = { id: "x_codpais", form: "fentidadesedit" };
    } else {
        options.ajax = { id: "x_codpais", form: "fentidadesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.entidades.fields.codpais.selectOptions);
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
        <label id="elh_entidades_codprov" for="x_codprov" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codprov->caption() ?><?= $Page->codprov->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codprov->cellAttributes() ?>>
<span id="el_entidades_codprov">
    <select
        id="x_codprov"
        name="x_codprov"
        class="form-select ew-select<?= $Page->codprov->isInvalidClass() ?>"
        <?php if (!$Page->codprov->IsNativeSelect) { ?>
        data-select2-id="fentidadesedit_x_codprov"
        <?php } ?>
        data-table="entidades"
        data-field="x_codprov"
        data-value-separator="<?= $Page->codprov->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codprov->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->codprov->editAttributes() ?>>
        <?= $Page->codprov->selectOptionListHtml("x_codprov") ?>
    </select>
    <?= $Page->codprov->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codprov->getErrorMessage() ?></div>
<?= $Page->codprov->Lookup->getParamTag($Page, "p_x_codprov") ?>
<?php if (!$Page->codprov->IsNativeSelect) { ?>
<script>
loadjs.ready("fentidadesedit", function() {
    var options = { name: "x_codprov", selectId: "fentidadesedit_x_codprov" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fentidadesedit.lists.codprov?.lookupOptions.length) {
        options.data = { id: "x_codprov", form: "fentidadesedit" };
    } else {
        options.ajax = { id: "x_codprov", form: "fentidadesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.entidades.fields.codprov.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codloc->Visible) { // codloc ?>
    <div id="r_codloc"<?= $Page->codloc->rowAttributes() ?>>
        <label id="elh_entidades_codloc" for="x_codloc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codloc->caption() ?><?= $Page->codloc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codloc->cellAttributes() ?>>
<span id="el_entidades_codloc">
    <select
        id="x_codloc"
        name="x_codloc"
        class="form-select ew-select<?= $Page->codloc->isInvalidClass() ?>"
        <?php if (!$Page->codloc->IsNativeSelect) { ?>
        data-select2-id="fentidadesedit_x_codloc"
        <?php } ?>
        data-table="entidades"
        data-field="x_codloc"
        data-value-separator="<?= $Page->codloc->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codloc->getPlaceHolder()) ?>"
        <?= $Page->codloc->editAttributes() ?>>
        <?= $Page->codloc->selectOptionListHtml("x_codloc") ?>
    </select>
    <?= $Page->codloc->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codloc->getErrorMessage() ?></div>
<?= $Page->codloc->Lookup->getParamTag($Page, "p_x_codloc") ?>
<?php if (!$Page->codloc->IsNativeSelect) { ?>
<script>
loadjs.ready("fentidadesedit", function() {
    var options = { name: "x_codloc", selectId: "fentidadesedit_x_codloc" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fentidadesedit.lists.codloc?.lookupOptions.length) {
        options.data = { id: "x_codloc", form: "fentidadesedit" };
    } else {
        options.ajax = { id: "x_codloc", form: "fentidadesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.entidades.fields.codloc.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpost->Visible) { // codpost ?>
    <div id="r_codpost"<?= $Page->codpost->rowAttributes() ?>>
        <label id="elh_entidades_codpost" for="x_codpost" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpost->caption() ?><?= $Page->codpost->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpost->cellAttributes() ?>>
<span id="el_entidades_codpost">
<input type="<?= $Page->codpost->getInputTextType() ?>" name="x_codpost" id="x_codpost" data-table="entidades" data-field="x_codpost" value="<?= $Page->codpost->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->codpost->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codpost->formatPattern()) ?>"<?= $Page->codpost->editAttributes() ?> aria-describedby="x_codpost_help">
<?= $Page->codpost->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codpost->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tellinea->Visible) { // tellinea ?>
    <div id="r_tellinea"<?= $Page->tellinea->rowAttributes() ?>>
        <label id="elh_entidades_tellinea" for="x_tellinea" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tellinea->caption() ?><?= $Page->tellinea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tellinea->cellAttributes() ?>>
<span id="el_entidades_tellinea">
<input type="<?= $Page->tellinea->getInputTextType() ?>" name="x_tellinea" id="x_tellinea" data-table="entidades" data-field="x_tellinea" value="<?= $Page->tellinea->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->tellinea->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tellinea->formatPattern()) ?>"<?= $Page->tellinea->editAttributes() ?> aria-describedby="x_tellinea_help">
<?= $Page->tellinea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tellinea->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telcelu->Visible) { // telcelu ?>
    <div id="r_telcelu"<?= $Page->telcelu->rowAttributes() ?>>
        <label id="elh_entidades_telcelu" for="x_telcelu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telcelu->caption() ?><?= $Page->telcelu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telcelu->cellAttributes() ?>>
<span id="el_entidades_telcelu">
<input type="<?= $Page->telcelu->getInputTextType() ?>" name="x_telcelu" id="x_telcelu" data-table="entidades" data-field="x_telcelu" value="<?= $Page->telcelu->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->telcelu->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telcelu->formatPattern()) ?>"<?= $Page->telcelu->editAttributes() ?> aria-describedby="x_telcelu_help">
<?= $Page->telcelu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telcelu->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipoent->Visible) { // tipoent ?>
    <div id="r_tipoent"<?= $Page->tipoent->rowAttributes() ?>>
        <label id="elh_entidades_tipoent" for="x_tipoent" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipoent->caption() ?><?= $Page->tipoent->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipoent->cellAttributes() ?>>
<span id="el_entidades_tipoent">
    <select
        id="x_tipoent"
        name="x_tipoent"
        class="form-select ew-select<?= $Page->tipoent->isInvalidClass() ?>"
        <?php if (!$Page->tipoent->IsNativeSelect) { ?>
        data-select2-id="fentidadesedit_x_tipoent"
        <?php } ?>
        data-table="entidades"
        data-field="x_tipoent"
        data-value-separator="<?= $Page->tipoent->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipoent->getPlaceHolder()) ?>"
        <?= $Page->tipoent->editAttributes() ?>>
        <?= $Page->tipoent->selectOptionListHtml("x_tipoent") ?>
    </select>
    <?= $Page->tipoent->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipoent->getErrorMessage() ?></div>
<?= $Page->tipoent->Lookup->getParamTag($Page, "p_x_tipoent") ?>
<?php if (!$Page->tipoent->IsNativeSelect) { ?>
<script>
loadjs.ready("fentidadesedit", function() {
    var options = { name: "x_tipoent", selectId: "fentidadesedit_x_tipoent" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fentidadesedit.lists.tipoent?.lookupOptions.length) {
        options.data = { id: "x_tipoent", form: "fentidadesedit" };
    } else {
        options.ajax = { id: "x_tipoent", form: "fentidadesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.entidades.fields.tipoent.selectOptions);
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
        <label id="elh_entidades_tipoiva" for="x_tipoiva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipoiva->caption() ?><?= $Page->tipoiva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipoiva->cellAttributes() ?>>
<span id="el_entidades_tipoiva">
    <select
        id="x_tipoiva"
        name="x_tipoiva"
        class="form-select ew-select<?= $Page->tipoiva->isInvalidClass() ?>"
        <?php if (!$Page->tipoiva->IsNativeSelect) { ?>
        data-select2-id="fentidadesedit_x_tipoiva"
        <?php } ?>
        data-table="entidades"
        data-field="x_tipoiva"
        data-value-separator="<?= $Page->tipoiva->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipoiva->getPlaceHolder()) ?>"
        <?= $Page->tipoiva->editAttributes() ?>>
        <?= $Page->tipoiva->selectOptionListHtml("x_tipoiva") ?>
    </select>
    <?= $Page->tipoiva->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipoiva->getErrorMessage() ?></div>
<?= $Page->tipoiva->Lookup->getParamTag($Page, "p_x_tipoiva") ?>
<?php if (!$Page->tipoiva->IsNativeSelect) { ?>
<script>
loadjs.ready("fentidadesedit", function() {
    var options = { name: "x_tipoiva", selectId: "fentidadesedit_x_tipoiva" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fentidadesedit.lists.tipoiva?.lookupOptions.length) {
        options.data = { id: "x_tipoiva", form: "fentidadesedit" };
    } else {
        options.ajax = { id: "x_tipoiva", form: "fentidadesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.entidades.fields.tipoiva.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cuit->Visible) { // cuit ?>
    <div id="r_cuit"<?= $Page->cuit->rowAttributes() ?>>
        <label id="elh_entidades_cuit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cuit->caption() ?><?= $Page->cuit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cuit->cellAttributes() ?>>
<span id="el_entidades_cuit">
<?php
if (IsRTL()) {
    $Page->cuit->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_cuit" class="ew-auto-suggest">
    <input type="<?= $Page->cuit->getInputTextType() ?>" class="form-control" name="sv_x_cuit" id="sv_x_cuit" value="<?= RemoveHtml($Page->cuit->EditValue) ?>" autocomplete="off" size="30" maxlength="14" placeholder="<?= HtmlEncode($Page->cuit->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->cuit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cuit->formatPattern()) ?>"<?= $Page->cuit->editAttributes() ?> aria-describedby="x_cuit_help">
</span>
<selection-list hidden class="form-control" data-table="entidades" data-field="x_cuit" data-input="sv_x_cuit" data-value-separator="<?= $Page->cuit->displayValueSeparatorAttribute() ?>" name="x_cuit" id="x_cuit" value="<?= HtmlEncode($Page->cuit->CurrentValue) ?>"></selection-list>
<?= $Page->cuit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cuit->getErrorMessage() ?></div>
<script>
loadjs.ready("fentidadesedit", function() {
    fentidadesedit.createAutoSuggest(Object.assign({"id":"x_cuit","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->cuit->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.entidades.fields.cuit.autoSuggestOptions));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->calif->Visible) { // calif ?>
    <div id="r_calif"<?= $Page->calif->rowAttributes() ?>>
        <label id="elh_entidades_calif" for="x_calif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->calif->caption() ?><?= $Page->calif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->calif->cellAttributes() ?>>
<span id="el_entidades_calif">
    <select
        id="x_calif"
        name="x_calif"
        class="form-select ew-select<?= $Page->calif->isInvalidClass() ?>"
        <?php if (!$Page->calif->IsNativeSelect) { ?>
        data-select2-id="fentidadesedit_x_calif"
        <?php } ?>
        data-table="entidades"
        data-field="x_calif"
        data-value-separator="<?= $Page->calif->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->calif->getPlaceHolder()) ?>"
        <?= $Page->calif->editAttributes() ?>>
        <?= $Page->calif->selectOptionListHtml("x_calif") ?>
    </select>
    <?= $Page->calif->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->calif->getErrorMessage() ?></div>
<?= $Page->calif->Lookup->getParamTag($Page, "p_x_calif") ?>
<?php if (!$Page->calif->IsNativeSelect) { ?>
<script>
loadjs.ready("fentidadesedit", function() {
    var options = { name: "x_calif", selectId: "fentidadesedit_x_calif" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fentidadesedit.lists.calif?.lookupOptions.length) {
        options.data = { id: "x_calif", form: "fentidadesedit" };
    } else {
        options.ajax = { id: "x_calif", form: "fentidadesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.entidades.fields.calif.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
    <div id="r_fecalta"<?= $Page->fecalta->rowAttributes() ?>>
        <label id="elh_entidades_fecalta" for="x_fecalta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecalta->caption() ?><?= $Page->fecalta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecalta->cellAttributes() ?>>
<span id="el_entidades_fecalta">
<input type="<?= $Page->fecalta->getInputTextType() ?>" name="x_fecalta" id="x_fecalta" data-table="entidades" data-field="x_fecalta" value="<?= $Page->fecalta->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecalta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecalta->formatPattern()) ?>"<?= $Page->fecalta->editAttributes() ?> aria-describedby="x_fecalta_help">
<?= $Page->fecalta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecalta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contacto->Visible) { // contacto ?>
    <div id="r_contacto"<?= $Page->contacto->rowAttributes() ?>>
        <label id="elh_entidades_contacto" for="x_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contacto->caption() ?><?= $Page->contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contacto->cellAttributes() ?>>
<span id="el_entidades_contacto">
<input type="<?= $Page->contacto->getInputTextType() ?>" name="x_contacto" id="x_contacto" data-table="entidades" data-field="x_contacto" value="<?= $Page->contacto->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contacto->formatPattern()) ?>"<?= $Page->contacto->editAttributes() ?> aria-describedby="x_contacto_help">
<?= $Page->contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mailcont->Visible) { // mailcont ?>
    <div id="r_mailcont"<?= $Page->mailcont->rowAttributes() ?>>
        <label id="elh_entidades_mailcont" for="x_mailcont" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mailcont->caption() ?><?= $Page->mailcont->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mailcont->cellAttributes() ?>>
<span id="el_entidades_mailcont">
<input type="<?= $Page->mailcont->getInputTextType() ?>" name="x_mailcont" id="x_mailcont" data-table="entidades" data-field="x_mailcont" value="<?= $Page->mailcont->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->mailcont->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->mailcont->formatPattern()) ?>"<?= $Page->mailcont->editAttributes() ?> aria-describedby="x_mailcont_help">
<?= $Page->mailcont->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mailcont->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
    <div id="r_cargo"<?= $Page->cargo->rowAttributes() ?>>
        <label id="elh_entidades_cargo" for="x_cargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cargo->caption() ?><?= $Page->cargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cargo->cellAttributes() ?>>
<span id="el_entidades_cargo">
<input type="<?= $Page->cargo->getInputTextType() ?>" name="x_cargo" id="x_cargo" data-table="entidades" data-field="x_cargo" value="<?= $Page->cargo->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cargo->formatPattern()) ?>"<?= $Page->cargo->editAttributes() ?> aria-describedby="x_cargo_help">
<?= $Page->cargo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cargo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_entidades_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_entidades_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fentidadesedit_x_activo"
        <?php } ?>
        data-table="entidades"
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
loadjs.ready("fentidadesedit", function() {
    var options = { name: "x_activo", selectId: "fentidadesedit_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fentidadesedit.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fentidadesedit" };
    } else {
        options.ajax = { id: "x_activo", form: "fentidadesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.entidades.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pagweb->Visible) { // pagweb ?>
    <div id="r_pagweb"<?= $Page->pagweb->rowAttributes() ?>>
        <label id="elh_entidades_pagweb" for="x_pagweb" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pagweb->caption() ?><?= $Page->pagweb->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pagweb->cellAttributes() ?>>
<span id="el_entidades_pagweb">
<input type="<?= $Page->pagweb->getInputTextType() ?>" name="x_pagweb" id="x_pagweb" data-table="entidades" data-field="x_pagweb" value="<?= $Page->pagweb->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->pagweb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->pagweb->formatPattern()) ?>"<?= $Page->pagweb->editAttributes() ?> aria-describedby="x_pagweb_help">
<?= $Page->pagweb->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pagweb->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
    <div id="r_tipoind"<?= $Page->tipoind->rowAttributes() ?>>
        <label id="elh_entidades_tipoind" for="x_tipoind" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipoind->caption() ?><?= $Page->tipoind->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipoind->cellAttributes() ?>>
<span id="el_entidades_tipoind">
    <select
        id="x_tipoind"
        name="x_tipoind"
        class="form-select ew-select<?= $Page->tipoind->isInvalidClass() ?>"
        <?php if (!$Page->tipoind->IsNativeSelect) { ?>
        data-select2-id="fentidadesedit_x_tipoind"
        <?php } ?>
        data-table="entidades"
        data-field="x_tipoind"
        data-value-separator="<?= $Page->tipoind->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipoind->getPlaceHolder()) ?>"
        <?= $Page->tipoind->editAttributes() ?>>
        <?= $Page->tipoind->selectOptionListHtml("x_tipoind") ?>
    </select>
    <?= $Page->tipoind->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipoind->getErrorMessage() ?></div>
<?= $Page->tipoind->Lookup->getParamTag($Page, "p_x_tipoind") ?>
<?php if (!$Page->tipoind->IsNativeSelect) { ?>
<script>
loadjs.ready("fentidadesedit", function() {
    var options = { name: "x_tipoind", selectId: "fentidadesedit_x_tipoind" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fentidadesedit.lists.tipoind?.lookupOptions.length) {
        options.data = { id: "x_tipoind", form: "fentidadesedit" };
    } else {
        options.ajax = { id: "x_tipoind", form: "fentidadesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.entidades.fields.tipoind.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="entidades" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fentidadesedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fentidadesedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("entidades");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
