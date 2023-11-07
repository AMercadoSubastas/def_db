<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$RematesEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="frematesedit" id="frematesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { remates: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var frematesedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frematesedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null, ew.Validators.integer], fields.codnum.isInvalid],
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["codcli", [fields.codcli.visible && fields.codcli.required ? ew.Validators.required(fields.codcli.caption) : null], fields.codcli.isInvalid],
            ["direccion", [fields.direccion.visible && fields.direccion.required ? ew.Validators.required(fields.direccion.caption) : null], fields.direccion.isInvalid],
            ["codpais", [fields.codpais.visible && fields.codpais.required ? ew.Validators.required(fields.codpais.caption) : null], fields.codpais.isInvalid],
            ["codprov", [fields.codprov.visible && fields.codprov.required ? ew.Validators.required(fields.codprov.caption) : null], fields.codprov.isInvalid],
            ["codloc", [fields.codloc.visible && fields.codloc.required ? ew.Validators.required(fields.codloc.caption) : null], fields.codloc.isInvalid],
            ["fecest", [fields.fecest.visible && fields.fecest.required ? ew.Validators.required(fields.fecest.caption) : null, ew.Validators.datetime(fields.fecest.clientFormatPattern)], fields.fecest.isInvalid],
            ["fecreal", [fields.fecreal.visible && fields.fecreal.required ? ew.Validators.required(fields.fecreal.caption) : null, ew.Validators.datetime(fields.fecreal.clientFormatPattern)], fields.fecreal.isInvalid],
            ["imptot", [fields.imptot.visible && fields.imptot.required ? ew.Validators.required(fields.imptot.caption) : null], fields.imptot.isInvalid],
            ["impbase", [fields.impbase.visible && fields.impbase.required ? ew.Validators.required(fields.impbase.caption) : null], fields.impbase.isInvalid],
            ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
            ["cantlotes", [fields.cantlotes.visible && fields.cantlotes.required ? ew.Validators.required(fields.cantlotes.caption) : null], fields.cantlotes.isInvalid],
            ["horaest", [fields.horaest.visible && fields.horaest.required ? ew.Validators.required(fields.horaest.caption) : null], fields.horaest.isInvalid],
            ["horareal", [fields.horareal.visible && fields.horareal.required ? ew.Validators.required(fields.horareal.caption) : null, ew.Validators.time(fields.horareal.clientFormatPattern)], fields.horareal.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["fecalta", [fields.fecalta.visible && fields.fecalta.required ? ew.Validators.required(fields.fecalta.caption) : null, ew.Validators.datetime(fields.fecalta.clientFormatPattern)], fields.fecalta.isInvalid],
            ["observacion", [fields.observacion.visible && fields.observacion.required ? ew.Validators.required(fields.observacion.caption) : null], fields.observacion.isInvalid],
            ["tipoind", [fields.tipoind.visible && fields.tipoind.required ? ew.Validators.required(fields.tipoind.caption) : null, ew.Validators.integer], fields.tipoind.isInvalid],
            ["sello", [fields.sello.visible && fields.sello.required ? ew.Validators.required(fields.sello.caption) : null], fields.sello.isInvalid],
            ["plazoSAP", [fields.plazoSAP.visible && fields.plazoSAP.required ? ew.Validators.required(fields.plazoSAP.caption) : null], fields.plazoSAP.isInvalid],
            ["usuarioultmod", [fields.usuarioultmod.visible && fields.usuarioultmod.required ? ew.Validators.required(fields.usuarioultmod.caption) : null], fields.usuarioultmod.isInvalid],
            ["fecultmod", [fields.fecultmod.visible && fields.fecultmod.required ? ew.Validators.required(fields.fecultmod.caption) : null], fields.fecultmod.isInvalid],
            ["servicios", [fields.servicios.visible && fields.servicios.required ? ew.Validators.required(fields.servicios.caption) : null, ew.Validators.float], fields.servicios.isInvalid],
            ["gastos", [fields.gastos.visible && fields.gastos.required ? ew.Validators.required(fields.gastos.caption) : null, ew.Validators.float], fields.gastos.isInvalid],
            ["tasa", [fields.tasa.visible && fields.tasa.required ? ew.Validators.required(fields.tasa.caption) : null], fields.tasa.isInvalid]
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
            "codcli": <?= $Page->codcli->toClientList($Page) ?>,
            "codpais": <?= $Page->codpais->toClientList($Page) ?>,
            "codprov": <?= $Page->codprov->toClientList($Page) ?>,
            "codloc": <?= $Page->codloc->toClientList($Page) ?>,
            "estado": <?= $Page->estado->toClientList($Page) ?>,
            "sello": <?= $Page->sello->toClientList($Page) ?>,
            "plazoSAP": <?= $Page->plazoSAP->toClientList($Page) ?>,
            "tasa": <?= $Page->tasa->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="remates">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codnum->Visible) { // codnum ?>
    <div id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <label id="elh_remates_codnum" for="x_codnum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codnum->caption() ?><?= $Page->codnum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codnum->cellAttributes() ?>>
<span id="el_remates_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codnum->getDisplayValue($Page->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="remates" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <div id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <label id="elh_remates_tcomp" for="x_tcomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomp->caption() ?><?= $Page->tcomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomp->cellAttributes() ?>>
<span id="el_remates_tcomp">
    <select
        id="x_tcomp"
        name="x_tcomp"
        class="form-select ew-select<?= $Page->tcomp->isInvalidClass() ?>"
        <?php if (!$Page->tcomp->IsNativeSelect) { ?>
        data-select2-id="frematesedit_x_tcomp"
        <?php } ?>
        data-table="remates"
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
loadjs.ready("frematesedit", function() {
    var options = { name: "x_tcomp", selectId: "frematesedit_x_tcomp" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frematesedit.lists.tcomp?.lookupOptions.length) {
        options.data = { id: "x_tcomp", form: "frematesedit" };
    } else {
        options.ajax = { id: "x_tcomp", form: "frematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.remates.fields.tcomp.selectOptions);
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
        <label id="elh_remates_serie" for="x_serie" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serie->caption() ?><?= $Page->serie->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serie->cellAttributes() ?>>
<span id="el_remates_serie">
    <select
        id="x_serie"
        name="x_serie"
        class="form-select ew-select<?= $Page->serie->isInvalidClass() ?>"
        <?php if (!$Page->serie->IsNativeSelect) { ?>
        data-select2-id="frematesedit_x_serie"
        <?php } ?>
        data-table="remates"
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
loadjs.ready("frematesedit", function() {
    var options = { name: "x_serie", selectId: "frematesedit_x_serie" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frematesedit.lists.serie?.lookupOptions.length) {
        options.data = { id: "x_serie", form: "frematesedit" };
    } else {
        options.ajax = { id: "x_serie", form: "frematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.remates.fields.serie.selectOptions);
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
        <label id="elh_remates_ncomp" for="x_ncomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomp->caption() ?><?= $Page->ncomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomp->cellAttributes() ?>>
<span id="el_remates_ncomp">
<input type="<?= $Page->ncomp->getInputTextType() ?>" name="x_ncomp" id="x_ncomp" data-table="remates" data-field="x_ncomp" value="<?= $Page->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomp->formatPattern()) ?>"<?= $Page->ncomp->editAttributes() ?> aria-describedby="x_ncomp_help">
<?= $Page->ncomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
    <div id="r_codcli"<?= $Page->codcli->rowAttributes() ?>>
        <label id="elh_remates_codcli" for="x_codcli" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codcli->caption() ?><?= $Page->codcli->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codcli->cellAttributes() ?>>
<span id="el_remates_codcli">
    <select
        id="x_codcli"
        name="x_codcli"
        class="form-select ew-select<?= $Page->codcli->isInvalidClass() ?>"
        <?php if (!$Page->codcli->IsNativeSelect) { ?>
        data-select2-id="frematesedit_x_codcli"
        <?php } ?>
        data-table="remates"
        data-field="x_codcli"
        data-value-separator="<?= $Page->codcli->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codcli->getPlaceHolder()) ?>"
        <?= $Page->codcli->editAttributes() ?>>
        <?= $Page->codcli->selectOptionListHtml("x_codcli") ?>
    </select>
    <?= $Page->codcli->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codcli->getErrorMessage() ?></div>
<?= $Page->codcli->Lookup->getParamTag($Page, "p_x_codcli") ?>
<?php if (!$Page->codcli->IsNativeSelect) { ?>
<script>
loadjs.ready("frematesedit", function() {
    var options = { name: "x_codcli", selectId: "frematesedit_x_codcli" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frematesedit.lists.codcli?.lookupOptions.length) {
        options.data = { id: "x_codcli", form: "frematesedit" };
    } else {
        options.ajax = { id: "x_codcli", form: "frematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.remates.fields.codcli.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <div id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <label id="elh_remates_direccion" for="x_direccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion->caption() ?><?= $Page->direccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion->cellAttributes() ?>>
<span id="el_remates_direccion">
<input type="<?= $Page->direccion->getInputTextType() ?>" name="x_direccion" id="x_direccion" data-table="remates" data-field="x_direccion" value="<?= $Page->direccion->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->direccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->direccion->formatPattern()) ?>"<?= $Page->direccion->editAttributes() ?> aria-describedby="x_direccion_help">
<?= $Page->direccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <div id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <label id="elh_remates_codpais" for="x_codpais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpais->caption() ?><?= $Page->codpais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpais->cellAttributes() ?>>
<span id="el_remates_codpais">
    <select
        id="x_codpais"
        name="x_codpais"
        class="form-select ew-select<?= $Page->codpais->isInvalidClass() ?>"
        <?php if (!$Page->codpais->IsNativeSelect) { ?>
        data-select2-id="frematesedit_x_codpais"
        <?php } ?>
        data-table="remates"
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
loadjs.ready("frematesedit", function() {
    var options = { name: "x_codpais", selectId: "frematesedit_x_codpais" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frematesedit.lists.codpais?.lookupOptions.length) {
        options.data = { id: "x_codpais", form: "frematesedit" };
    } else {
        options.ajax = { id: "x_codpais", form: "frematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.remates.fields.codpais.selectOptions);
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
        <label id="elh_remates_codprov" for="x_codprov" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codprov->caption() ?><?= $Page->codprov->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codprov->cellAttributes() ?>>
<span id="el_remates_codprov">
    <select
        id="x_codprov"
        name="x_codprov"
        class="form-select ew-select<?= $Page->codprov->isInvalidClass() ?>"
        <?php if (!$Page->codprov->IsNativeSelect) { ?>
        data-select2-id="frematesedit_x_codprov"
        <?php } ?>
        data-table="remates"
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
loadjs.ready("frematesedit", function() {
    var options = { name: "x_codprov", selectId: "frematesedit_x_codprov" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frematesedit.lists.codprov?.lookupOptions.length) {
        options.data = { id: "x_codprov", form: "frematesedit" };
    } else {
        options.ajax = { id: "x_codprov", form: "frematesedit", limit: 99999 };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.remates.fields.codprov.selectOptions);
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
        <label id="elh_remates_codloc" for="x_codloc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codloc->caption() ?><?= $Page->codloc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codloc->cellAttributes() ?>>
<span id="el_remates_codloc">
    <select
        id="x_codloc"
        name="x_codloc"
        class="form-select ew-select<?= $Page->codloc->isInvalidClass() ?>"
        <?php if (!$Page->codloc->IsNativeSelect) { ?>
        data-select2-id="frematesedit_x_codloc"
        <?php } ?>
        data-table="remates"
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
loadjs.ready("frematesedit", function() {
    var options = { name: "x_codloc", selectId: "frematesedit_x_codloc" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frematesedit.lists.codloc?.lookupOptions.length) {
        options.data = { id: "x_codloc", form: "frematesedit" };
    } else {
        options.ajax = { id: "x_codloc", form: "frematesedit", limit: 99999 };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.remates.fields.codloc.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecest->Visible) { // fecest ?>
    <div id="r_fecest"<?= $Page->fecest->rowAttributes() ?>>
        <label id="elh_remates_fecest" for="x_fecest" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecest->caption() ?><?= $Page->fecest->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecest->cellAttributes() ?>>
<span id="el_remates_fecest">
<input type="<?= $Page->fecest->getInputTextType() ?>" name="x_fecest" id="x_fecest" data-table="remates" data-field="x_fecest" value="<?= $Page->fecest->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecest->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecest->formatPattern()) ?>"<?= $Page->fecest->editAttributes() ?> aria-describedby="x_fecest_help">
<?= $Page->fecest->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecest->getErrorMessage() ?></div>
<?php if (!$Page->fecest->ReadOnly && !$Page->fecest->Disabled && !isset($Page->fecest->EditAttrs["readonly"]) && !isset($Page->fecest->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frematesedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frematesedit", "x_fecest", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecreal->Visible) { // fecreal ?>
    <div id="r_fecreal"<?= $Page->fecreal->rowAttributes() ?>>
        <label id="elh_remates_fecreal" for="x_fecreal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecreal->caption() ?><?= $Page->fecreal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecreal->cellAttributes() ?>>
<span id="el_remates_fecreal">
<input type="<?= $Page->fecreal->getInputTextType() ?>" name="x_fecreal" id="x_fecreal" data-table="remates" data-field="x_fecreal" value="<?= $Page->fecreal->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecreal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecreal->formatPattern()) ?>"<?= $Page->fecreal->editAttributes() ?> aria-describedby="x_fecreal_help">
<?= $Page->fecreal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecreal->getErrorMessage() ?></div>
<?php if (!$Page->fecreal->ReadOnly && !$Page->fecreal->Disabled && !isset($Page->fecreal->EditAttrs["readonly"]) && !isset($Page->fecreal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frematesedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frematesedit", "x_fecreal", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <div id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <label id="elh_remates_estado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado->caption() ?><?= $Page->estado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estado->cellAttributes() ?>>
<span id="el_remates_estado">
<template id="tp_x_estado">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="remates" data-field="x_estado" name="x_estado" id="x_estado"<?= $Page->estado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_estado" class="ew-item-list"></div>
<selection-list hidden
    id="x_estado[]"
    name="x_estado[]"
    value="<?= HtmlEncode($Page->estado->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_estado"
    data-target="dsl_x_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Page->estado->isInvalidClass() ?>"
    data-table="remates"
    data-field="x_estado"
    data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
    <?= $Page->estado->editAttributes() ?>></selection-list>
<?= $Page->estado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->horareal->Visible) { // horareal ?>
    <div id="r_horareal"<?= $Page->horareal->rowAttributes() ?>>
        <label id="elh_remates_horareal" for="x_horareal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->horareal->caption() ?><?= $Page->horareal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->horareal->cellAttributes() ?>>
<span id="el_remates_horareal">
<input type="<?= $Page->horareal->getInputTextType() ?>" name="x_horareal" id="x_horareal" data-table="remates" data-field="x_horareal" value="<?= $Page->horareal->EditValue ?>" placeholder="<?= HtmlEncode($Page->horareal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->horareal->formatPattern()) ?>"<?= $Page->horareal->editAttributes() ?> aria-describedby="x_horareal_help">
<?= $Page->horareal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->horareal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
    <div id="r_fecalta"<?= $Page->fecalta->rowAttributes() ?>>
        <label id="elh_remates_fecalta" for="x_fecalta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecalta->caption() ?><?= $Page->fecalta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecalta->cellAttributes() ?>>
<span id="el_remates_fecalta">
<input type="<?= $Page->fecalta->getInputTextType() ?>" name="x_fecalta" id="x_fecalta" data-table="remates" data-field="x_fecalta" value="<?= $Page->fecalta->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecalta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecalta->formatPattern()) ?>"<?= $Page->fecalta->editAttributes() ?> aria-describedby="x_fecalta_help">
<?= $Page->fecalta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecalta->getErrorMessage() ?></div>
<?php if (!$Page->fecalta->ReadOnly && !$Page->fecalta->Disabled && !isset($Page->fecalta->EditAttrs["readonly"]) && !isset($Page->fecalta->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frematesedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frematesedit", "x_fecalta", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->observacion->Visible) { // observacion ?>
    <div id="r_observacion"<?= $Page->observacion->rowAttributes() ?>>
        <label id="elh_remates_observacion" for="x_observacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->observacion->caption() ?><?= $Page->observacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->observacion->cellAttributes() ?>>
<span id="el_remates_observacion">
<textarea data-table="remates" data-field="x_observacion" name="x_observacion" id="x_observacion" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->observacion->getPlaceHolder()) ?>"<?= $Page->observacion->editAttributes() ?> aria-describedby="x_observacion_help"><?= $Page->observacion->EditValue ?></textarea>
<?= $Page->observacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->observacion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipoind->Visible) { // tipoind ?>
    <div id="r_tipoind"<?= $Page->tipoind->rowAttributes() ?>>
        <label id="elh_remates_tipoind" for="x_tipoind" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipoind->caption() ?><?= $Page->tipoind->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipoind->cellAttributes() ?>>
<span id="el_remates_tipoind">
<input type="<?= $Page->tipoind->getInputTextType() ?>" name="x_tipoind" id="x_tipoind" data-table="remates" data-field="x_tipoind" value="<?= $Page->tipoind->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tipoind->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipoind->formatPattern()) ?>"<?= $Page->tipoind->editAttributes() ?> aria-describedby="x_tipoind_help">
<?= $Page->tipoind->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipoind->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sello->Visible) { // sello ?>
    <div id="r_sello"<?= $Page->sello->rowAttributes() ?>>
        <label id="elh_remates_sello" for="x_sello" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sello->caption() ?><?= $Page->sello->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sello->cellAttributes() ?>>
<span id="el_remates_sello">
    <select
        id="x_sello"
        name="x_sello"
        class="form-select ew-select<?= $Page->sello->isInvalidClass() ?>"
        <?php if (!$Page->sello->IsNativeSelect) { ?>
        data-select2-id="frematesedit_x_sello"
        <?php } ?>
        data-table="remates"
        data-field="x_sello"
        data-value-separator="<?= $Page->sello->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->sello->getPlaceHolder()) ?>"
        <?= $Page->sello->editAttributes() ?>>
        <?= $Page->sello->selectOptionListHtml("x_sello") ?>
    </select>
    <?= $Page->sello->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->sello->getErrorMessage() ?></div>
<?php if (!$Page->sello->IsNativeSelect) { ?>
<script>
loadjs.ready("frematesedit", function() {
    var options = { name: "x_sello", selectId: "frematesedit_x_sello" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frematesedit.lists.sello?.lookupOptions.length) {
        options.data = { id: "x_sello", form: "frematesedit" };
    } else {
        options.ajax = { id: "x_sello", form: "frematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.remates.fields.sello.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->plazoSAP->Visible) { // plazoSAP ?>
    <div id="r_plazoSAP"<?= $Page->plazoSAP->rowAttributes() ?>>
        <label id="elh_remates_plazoSAP" for="x_plazoSAP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->plazoSAP->caption() ?><?= $Page->plazoSAP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->plazoSAP->cellAttributes() ?>>
<span id="el_remates_plazoSAP">
    <select
        id="x_plazoSAP"
        name="x_plazoSAP"
        class="form-select ew-select<?= $Page->plazoSAP->isInvalidClass() ?>"
        <?php if (!$Page->plazoSAP->IsNativeSelect) { ?>
        data-select2-id="frematesedit_x_plazoSAP"
        <?php } ?>
        data-table="remates"
        data-field="x_plazoSAP"
        data-value-separator="<?= $Page->plazoSAP->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->plazoSAP->getPlaceHolder()) ?>"
        <?= $Page->plazoSAP->editAttributes() ?>>
        <?= $Page->plazoSAP->selectOptionListHtml("x_plazoSAP") ?>
    </select>
    <?= $Page->plazoSAP->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->plazoSAP->getErrorMessage() ?></div>
<?php if (!$Page->plazoSAP->IsNativeSelect) { ?>
<script>
loadjs.ready("frematesedit", function() {
    var options = { name: "x_plazoSAP", selectId: "frematesedit_x_plazoSAP" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frematesedit.lists.plazoSAP?.lookupOptions.length) {
        options.data = { id: "x_plazoSAP", form: "frematesedit" };
    } else {
        options.ajax = { id: "x_plazoSAP", form: "frematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.remates.fields.plazoSAP.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicios->Visible) { // servicios ?>
    <div id="r_servicios"<?= $Page->servicios->rowAttributes() ?>>
        <label id="elh_remates_servicios" for="x_servicios" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicios->caption() ?><?= $Page->servicios->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicios->cellAttributes() ?>>
<span id="el_remates_servicios">
<input type="<?= $Page->servicios->getInputTextType() ?>" name="x_servicios" id="x_servicios" data-table="remates" data-field="x_servicios" value="<?= $Page->servicios->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->servicios->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->servicios->formatPattern()) ?>"<?= $Page->servicios->editAttributes() ?> aria-describedby="x_servicios_help">
<?= $Page->servicios->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->servicios->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gastos->Visible) { // gastos ?>
    <div id="r_gastos"<?= $Page->gastos->rowAttributes() ?>>
        <label id="elh_remates_gastos" for="x_gastos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gastos->caption() ?><?= $Page->gastos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->gastos->cellAttributes() ?>>
<span id="el_remates_gastos">
<input type="<?= $Page->gastos->getInputTextType() ?>" name="x_gastos" id="x_gastos" data-table="remates" data-field="x_gastos" value="<?= $Page->gastos->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->gastos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->gastos->formatPattern()) ?>"<?= $Page->gastos->editAttributes() ?> aria-describedby="x_gastos_help">
<?= $Page->gastos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gastos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <div id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <label id="elh_remates_tasa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tasa->caption() ?><?= $Page->tasa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tasa->cellAttributes() ?>>
<span id="el_remates_tasa">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->tasa->isInvalidClass() ?>" data-table="remates" data-field="x_tasa" data-boolean name="x_tasa" id="x_tasa" value="1"<?= ConvertToBool($Page->tasa->CurrentValue) ? " checked" : "" ?><?= $Page->tasa->editAttributes() ?> aria-describedby="x_tasa_help">
    <div class="invalid-feedback"><?= $Page->tasa->getErrorMessage() ?></div>
</div>
<?= $Page->tasa->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<span id="el_remates_imptot">
<input type="hidden" data-table="remates" data-field="x_imptot" data-hidden="1" name="x_imptot" id="x_imptot" value="<?= HtmlEncode($Page->imptot->CurrentValue) ?>">
</span>
<span id="el_remates_impbase">
<input type="hidden" data-table="remates" data-field="x_impbase" data-hidden="1" name="x_impbase" id="x_impbase" value="<?= HtmlEncode($Page->impbase->CurrentValue) ?>">
</span>
<span id="el_remates_cantlotes">
<input type="hidden" data-table="remates" data-field="x_cantlotes" data-hidden="1" name="x_cantlotes" id="x_cantlotes" value="<?= HtmlEncode($Page->cantlotes->CurrentValue) ?>">
</span>
<span id="el_remates_horaest">
<input type="hidden" data-table="remates" data-field="x_horaest" data-hidden="1" name="x_horaest" id="x_horaest" value="<?= HtmlEncode($Page->horaest->CurrentValue) ?>">
</span>
<?php
    if (in_array("lotes", explode(",", $Page->getCurrentDetailTable())) && $lotes->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("lotes", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "LotesGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frematesedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frematesedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("remates");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
