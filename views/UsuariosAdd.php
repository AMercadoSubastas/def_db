<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$UsuariosAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { usuarios: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fusuariosadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusuariosadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["clave", [fields.clave.visible && fields.clave.required ? ew.Validators.required(fields.clave.caption) : null], fields.clave.isInvalid],
            ["nivel", [fields.nivel.visible && fields.nivel.required ? ew.Validators.required(fields.nivel.caption) : null], fields.nivel.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid]
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
            "nivel": <?= $Page->nivel->toClientList($Page) ?>,
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
<form name="fusuariosadd" id="fusuariosadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="usuarios">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->usuario->Visible) { // usuario ?>
    <div id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <label id="elh_usuarios_usuario" for="x_usuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario->caption() ?><?= $Page->usuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario->cellAttributes() ?>>
<span id="el_usuarios_usuario">
<input type="<?= $Page->usuario->getInputTextType() ?>" name="x_usuario" id="x_usuario" data-table="usuarios" data-field="x_usuario" value="<?= $Page->usuario->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->usuario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->usuario->formatPattern()) ?>"<?= $Page->usuario->editAttributes() ?> aria-describedby="x_usuario_help">
<?= $Page->usuario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->usuario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_usuarios_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_usuarios_nombre">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="usuarios" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?> aria-describedby="x_nombre_help">
<?= $Page->nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->clave->Visible) { // clave ?>
    <div id="r_clave"<?= $Page->clave->rowAttributes() ?>>
        <label id="elh_usuarios_clave" for="x_clave" class="<?= $Page->LeftColumnClass ?>"><?= $Page->clave->caption() ?><?= $Page->clave->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->clave->cellAttributes() ?>>
<span id="el_usuarios_clave">
<div class="input-group">
    <input type="password" name="x_clave" id="x_clave" autocomplete="new-password" data-table="usuarios" data-field="x_clave" size="40" maxlength="255" placeholder="<?= HtmlEncode($Page->clave->getPlaceHolder()) ?>"<?= $Page->clave->editAttributes() ?> aria-describedby="x_clave_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
</div>
<?= $Page->clave->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->clave->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nivel->Visible) { // nivel ?>
    <div id="r_nivel"<?= $Page->nivel->rowAttributes() ?>>
        <label id="elh_usuarios_nivel" for="x_nivel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nivel->caption() ?><?= $Page->nivel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nivel->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_usuarios_nivel">
<span class="form-control-plaintext"><?= $Page->nivel->getDisplayValue($Page->nivel->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_usuarios_nivel">
    <select
        id="x_nivel"
        name="x_nivel"
        class="form-select ew-select<?= $Page->nivel->isInvalidClass() ?>"
        <?php if (!$Page->nivel->IsNativeSelect) { ?>
        data-select2-id="fusuariosadd_x_nivel"
        <?php } ?>
        data-table="usuarios"
        data-field="x_nivel"
        data-value-separator="<?= $Page->nivel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nivel->getPlaceHolder()) ?>"
        <?= $Page->nivel->editAttributes() ?>>
        <?= $Page->nivel->selectOptionListHtml("x_nivel") ?>
    </select>
    <?= $Page->nivel->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->nivel->getErrorMessage() ?></div>
<?= $Page->nivel->Lookup->getParamTag($Page, "p_x_nivel") ?>
<?php if (!$Page->nivel->IsNativeSelect) { ?>
<script>
loadjs.ready("fusuariosadd", function() {
    var options = { name: "x_nivel", selectId: "fusuariosadd_x_nivel" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusuariosadd.lists.nivel?.lookupOptions.length) {
        options.data = { id: "x_nivel", form: "fusuariosadd" };
    } else {
        options.ajax = { id: "x_nivel", form: "fusuariosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.usuarios.fields.nivel.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_usuarios_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_usuarios_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fusuariosadd_x_activo"
        <?php } ?>
        data-table="usuarios"
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
loadjs.ready("fusuariosadd", function() {
    var options = { name: "x_activo", selectId: "fusuariosadd_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusuariosadd.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fusuariosadd" };
    } else {
        options.ajax = { id: "x_activo", form: "fusuariosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.usuarios.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_usuarios__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_usuarios__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="usuarios" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fusuariosadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fusuariosadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("usuarios");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
