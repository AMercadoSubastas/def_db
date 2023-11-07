<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DirRematesEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fdir_rematesedit" id="fdir_rematesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dir_remates: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdir_rematesedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdir_rematesedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codigo", [fields.codigo.visible && fields.codigo.required ? ew.Validators.required(fields.codigo.caption) : null], fields.codigo.isInvalid],
            ["codrem", [fields.codrem.visible && fields.codrem.required ? ew.Validators.required(fields.codrem.caption) : null], fields.codrem.isInvalid],
            ["secuencia", [fields.secuencia.visible && fields.secuencia.required ? ew.Validators.required(fields.secuencia.caption) : null, ew.Validators.integer], fields.secuencia.isInvalid],
            ["direccion", [fields.direccion.visible && fields.direccion.required ? ew.Validators.required(fields.direccion.caption) : null], fields.direccion.isInvalid],
            ["codpais", [fields.codpais.visible && fields.codpais.required ? ew.Validators.required(fields.codpais.caption) : null], fields.codpais.isInvalid],
            ["codprov", [fields.codprov.visible && fields.codprov.required ? ew.Validators.required(fields.codprov.caption) : null], fields.codprov.isInvalid],
            ["codloc", [fields.codloc.visible && fields.codloc.required ? ew.Validators.required(fields.codloc.caption) : null], fields.codloc.isInvalid],
            ["usuarioalta", [fields.usuarioalta.visible && fields.usuarioalta.required ? ew.Validators.required(fields.usuarioalta.caption) : null], fields.usuarioalta.isInvalid],
            ["fechaalta", [fields.fechaalta.visible && fields.fechaalta.required ? ew.Validators.required(fields.fechaalta.caption) : null], fields.fechaalta.isInvalid],
            ["usuariomod", [fields.usuariomod.visible && fields.usuariomod.required ? ew.Validators.required(fields.usuariomod.caption) : null], fields.usuariomod.isInvalid],
            ["fechaultmod", [fields.fechaultmod.visible && fields.fechaultmod.required ? ew.Validators.required(fields.fechaultmod.caption) : null], fields.fechaultmod.isInvalid]
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
            "codrem": <?= $Page->codrem->toClientList($Page) ?>,
            "codpais": <?= $Page->codpais->toClientList($Page) ?>,
            "codprov": <?= $Page->codprov->toClientList($Page) ?>,
            "codloc": <?= $Page->codloc->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="dir_remates">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codigo->Visible) { // codigo ?>
    <div id="r_codigo"<?= $Page->codigo->rowAttributes() ?>>
        <label id="elh_dir_remates_codigo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codigo->caption() ?><?= $Page->codigo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codigo->cellAttributes() ?>>
<span id="el_dir_remates_codigo">
<span<?= $Page->codigo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codigo->getDisplayValue($Page->codigo->EditValue))) ?>"></span>
<input type="hidden" data-table="dir_remates" data-field="x_codigo" data-hidden="1" name="x_codigo" id="x_codigo" value="<?= HtmlEncode($Page->codigo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <div id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <label id="elh_dir_remates_codrem" for="x_codrem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codrem->caption() ?><?= $Page->codrem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codrem->cellAttributes() ?>>
<span id="el_dir_remates_codrem">
    <select
        id="x_codrem"
        name="x_codrem"
        class="form-select ew-select<?= $Page->codrem->isInvalidClass() ?>"
        <?php if (!$Page->codrem->IsNativeSelect) { ?>
        data-select2-id="fdir_rematesedit_x_codrem"
        <?php } ?>
        data-table="dir_remates"
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
loadjs.ready("fdir_rematesedit", function() {
    var options = { name: "x_codrem", selectId: "fdir_rematesedit_x_codrem" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdir_rematesedit.lists.codrem?.lookupOptions.length) {
        options.data = { id: "x_codrem", form: "fdir_rematesedit" };
    } else {
        options.ajax = { id: "x_codrem", form: "fdir_rematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dir_remates.fields.codrem.selectOptions);
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
        <label id="elh_dir_remates_secuencia" for="x_secuencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->secuencia->caption() ?><?= $Page->secuencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->secuencia->cellAttributes() ?>>
<span id="el_dir_remates_secuencia">
<input type="<?= $Page->secuencia->getInputTextType() ?>" name="x_secuencia" id="x_secuencia" data-table="dir_remates" data-field="x_secuencia" value="<?= $Page->secuencia->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->secuencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->secuencia->formatPattern()) ?>"<?= $Page->secuencia->editAttributes() ?> aria-describedby="x_secuencia_help">
<?= $Page->secuencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->secuencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <div id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <label id="elh_dir_remates_direccion" for="x_direccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion->caption() ?><?= $Page->direccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion->cellAttributes() ?>>
<span id="el_dir_remates_direccion">
<input type="<?= $Page->direccion->getInputTextType() ?>" name="x_direccion" id="x_direccion" data-table="dir_remates" data-field="x_direccion" value="<?= $Page->direccion->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->direccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->direccion->formatPattern()) ?>"<?= $Page->direccion->editAttributes() ?> aria-describedby="x_direccion_help">
<?= $Page->direccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <div id="r_codpais"<?= $Page->codpais->rowAttributes() ?>>
        <label id="elh_dir_remates_codpais" for="x_codpais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpais->caption() ?><?= $Page->codpais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codpais->cellAttributes() ?>>
<span id="el_dir_remates_codpais">
    <select
        id="x_codpais"
        name="x_codpais"
        class="form-select ew-select<?= $Page->codpais->isInvalidClass() ?>"
        <?php if (!$Page->codpais->IsNativeSelect) { ?>
        data-select2-id="fdir_rematesedit_x_codpais"
        <?php } ?>
        data-table="dir_remates"
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
loadjs.ready("fdir_rematesedit", function() {
    var options = { name: "x_codpais", selectId: "fdir_rematesedit_x_codpais" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdir_rematesedit.lists.codpais?.lookupOptions.length) {
        options.data = { id: "x_codpais", form: "fdir_rematesedit" };
    } else {
        options.ajax = { id: "x_codpais", form: "fdir_rematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dir_remates.fields.codpais.selectOptions);
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
        <label id="elh_dir_remates_codprov" for="x_codprov" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codprov->caption() ?><?= $Page->codprov->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codprov->cellAttributes() ?>>
<span id="el_dir_remates_codprov">
    <select
        id="x_codprov"
        name="x_codprov"
        class="form-select ew-select<?= $Page->codprov->isInvalidClass() ?>"
        <?php if (!$Page->codprov->IsNativeSelect) { ?>
        data-select2-id="fdir_rematesedit_x_codprov"
        <?php } ?>
        data-table="dir_remates"
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
loadjs.ready("fdir_rematesedit", function() {
    var options = { name: "x_codprov", selectId: "fdir_rematesedit_x_codprov" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdir_rematesedit.lists.codprov?.lookupOptions.length) {
        options.data = { id: "x_codprov", form: "fdir_rematesedit" };
    } else {
        options.ajax = { id: "x_codprov", form: "fdir_rematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dir_remates.fields.codprov.selectOptions);
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
        <label id="elh_dir_remates_codloc" for="x_codloc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codloc->caption() ?><?= $Page->codloc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codloc->cellAttributes() ?>>
<span id="el_dir_remates_codloc">
    <select
        id="x_codloc"
        name="x_codloc"
        class="form-select ew-select<?= $Page->codloc->isInvalidClass() ?>"
        <?php if (!$Page->codloc->IsNativeSelect) { ?>
        data-select2-id="fdir_rematesedit_x_codloc"
        <?php } ?>
        data-table="dir_remates"
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
loadjs.ready("fdir_rematesedit", function() {
    var options = { name: "x_codloc", selectId: "fdir_rematesedit_x_codloc" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdir_rematesedit.lists.codloc?.lookupOptions.length) {
        options.data = { id: "x_codloc", form: "fdir_rematesedit" };
    } else {
        options.ajax = { id: "x_codloc", form: "fdir_rematesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.dir_remates.fields.codloc.selectOptions);
    ew.createSelect(options);
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdir_rematesedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdir_rematesedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("dir_remates");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
