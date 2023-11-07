<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetreciboEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fdetreciboedit" id="fdetreciboedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detrecibo: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdetreciboedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetreciboedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codnum", [fields.codnum.visible && fields.codnum.required ? ew.Validators.required(fields.codnum.caption) : null], fields.codnum.isInvalid],
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null, ew.Validators.integer], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null, ew.Validators.integer], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["nreng", [fields.nreng.visible && fields.nreng.required ? ew.Validators.required(fields.nreng.caption) : null, ew.Validators.integer], fields.nreng.isInvalid],
            ["tcomprel", [fields.tcomprel.visible && fields.tcomprel.required ? ew.Validators.required(fields.tcomprel.caption) : null, ew.Validators.integer], fields.tcomprel.isInvalid],
            ["serierel", [fields.serierel.visible && fields.serierel.required ? ew.Validators.required(fields.serierel.caption) : null, ew.Validators.integer], fields.serierel.isInvalid],
            ["ncomprel", [fields.ncomprel.visible && fields.ncomprel.required ? ew.Validators.required(fields.ncomprel.caption) : null, ew.Validators.integer], fields.ncomprel.isInvalid],
            ["netocbterel", [fields.netocbterel.visible && fields.netocbterel.required ? ew.Validators.required(fields.netocbterel.caption) : null, ew.Validators.float], fields.netocbterel.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null, ew.Validators.integer], fields.usuario.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null, ew.Validators.datetime(fields.fechahora.clientFormatPattern)], fields.fechahora.isInvalid],
            ["nrodoc", [fields.nrodoc.visible && fields.nrodoc.required ? ew.Validators.required(fields.nrodoc.caption) : null], fields.nrodoc.isInvalid]
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="detrecibo">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "cabrecibo") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cabrecibo">
<input type="hidden" name="fk_tcomp" value="<?= HtmlEncode($Page->tcomp->getSessionValue()) ?>">
<input type="hidden" name="fk_serie" value="<?= HtmlEncode($Page->serie->getSessionValue()) ?>">
<input type="hidden" name="fk_ncomp" value="<?= HtmlEncode($Page->ncomp->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codnum->Visible) { // codnum ?>
    <div id="r_codnum"<?= $Page->codnum->rowAttributes() ?>>
        <label id="elh_detrecibo_codnum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codnum->caption() ?><?= $Page->codnum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codnum->cellAttributes() ?>>
<span id="el_detrecibo_codnum">
<span<?= $Page->codnum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codnum->getDisplayValue($Page->codnum->EditValue))) ?>"></span>
<input type="hidden" data-table="detrecibo" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <div id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <label id="elh_detrecibo_tcomp" for="x_tcomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomp->caption() ?><?= $Page->tcomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomp->cellAttributes() ?>>
<?php if ($Page->tcomp->getSessionValue() != "") { ?>
<span<?= $Page->tcomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tcomp->getDisplayValue($Page->tcomp->ViewValue))) ?>"></span>
<input type="hidden" id="x_tcomp" name="x_tcomp" value="<?= HtmlEncode($Page->tcomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_detrecibo_tcomp">
<input type="<?= $Page->tcomp->getInputTextType() ?>" name="x_tcomp" id="x_tcomp" data-table="detrecibo" data-field="x_tcomp" value="<?= $Page->tcomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tcomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcomp->formatPattern()) ?>"<?= $Page->tcomp->editAttributes() ?> aria-describedby="x_tcomp_help">
<?= $Page->tcomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcomp->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <div id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <label id="elh_detrecibo_serie" for="x_serie" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serie->caption() ?><?= $Page->serie->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serie->cellAttributes() ?>>
<?php if ($Page->serie->getSessionValue() != "") { ?>
<span<?= $Page->serie->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->serie->getDisplayValue($Page->serie->ViewValue))) ?>"></span>
<input type="hidden" id="x_serie" name="x_serie" value="<?= HtmlEncode($Page->serie->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_detrecibo_serie">
<input type="<?= $Page->serie->getInputTextType() ?>" name="x_serie" id="x_serie" data-table="detrecibo" data-field="x_serie" value="<?= $Page->serie->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->serie->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->serie->formatPattern()) ?>"<?= $Page->serie->editAttributes() ?> aria-describedby="x_serie_help">
<?= $Page->serie->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serie->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <div id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <label id="elh_detrecibo_ncomp" for="x_ncomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomp->caption() ?><?= $Page->ncomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomp->cellAttributes() ?>>
<?php if ($Page->ncomp->getSessionValue() != "") { ?>
<span<?= $Page->ncomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ncomp->getDisplayValue($Page->ncomp->ViewValue))) ?>"></span>
<input type="hidden" id="x_ncomp" name="x_ncomp" value="<?= HtmlEncode($Page->ncomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_detrecibo_ncomp">
<input type="<?= $Page->ncomp->getInputTextType() ?>" name="x_ncomp" id="x_ncomp" data-table="detrecibo" data-field="x_ncomp" value="<?= $Page->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomp->formatPattern()) ?>"<?= $Page->ncomp->editAttributes() ?> aria-describedby="x_ncomp_help">
<?= $Page->ncomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomp->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
    <div id="r_nreng"<?= $Page->nreng->rowAttributes() ?>>
        <label id="elh_detrecibo_nreng" for="x_nreng" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nreng->caption() ?><?= $Page->nreng->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nreng->cellAttributes() ?>>
<span id="el_detrecibo_nreng">
<input type="<?= $Page->nreng->getInputTextType() ?>" name="x_nreng" id="x_nreng" data-table="detrecibo" data-field="x_nreng" value="<?= $Page->nreng->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nreng->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nreng->formatPattern()) ?>"<?= $Page->nreng->editAttributes() ?> aria-describedby="x_nreng_help">
<?= $Page->nreng->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nreng->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
    <div id="r_tcomprel"<?= $Page->tcomprel->rowAttributes() ?>>
        <label id="elh_detrecibo_tcomprel" for="x_tcomprel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomprel->caption() ?><?= $Page->tcomprel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomprel->cellAttributes() ?>>
<span id="el_detrecibo_tcomprel">
<input type="<?= $Page->tcomprel->getInputTextType() ?>" name="x_tcomprel" id="x_tcomprel" data-table="detrecibo" data-field="x_tcomprel" value="<?= $Page->tcomprel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tcomprel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcomprel->formatPattern()) ?>"<?= $Page->tcomprel->editAttributes() ?> aria-describedby="x_tcomprel_help">
<?= $Page->tcomprel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcomprel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
    <div id="r_serierel"<?= $Page->serierel->rowAttributes() ?>>
        <label id="elh_detrecibo_serierel" for="x_serierel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serierel->caption() ?><?= $Page->serierel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serierel->cellAttributes() ?>>
<span id="el_detrecibo_serierel">
<input type="<?= $Page->serierel->getInputTextType() ?>" name="x_serierel" id="x_serierel" data-table="detrecibo" data-field="x_serierel" value="<?= $Page->serierel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->serierel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->serierel->formatPattern()) ?>"<?= $Page->serierel->editAttributes() ?> aria-describedby="x_serierel_help">
<?= $Page->serierel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serierel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
    <div id="r_ncomprel"<?= $Page->ncomprel->rowAttributes() ?>>
        <label id="elh_detrecibo_ncomprel" for="x_ncomprel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomprel->caption() ?><?= $Page->ncomprel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomprel->cellAttributes() ?>>
<span id="el_detrecibo_ncomprel">
<input type="<?= $Page->ncomprel->getInputTextType() ?>" name="x_ncomprel" id="x_ncomprel" data-table="detrecibo" data-field="x_ncomprel" value="<?= $Page->ncomprel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomprel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomprel->formatPattern()) ?>"<?= $Page->ncomprel->editAttributes() ?> aria-describedby="x_ncomprel_help">
<?= $Page->ncomprel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomprel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->netocbterel->Visible) { // netocbterel ?>
    <div id="r_netocbterel"<?= $Page->netocbterel->rowAttributes() ?>>
        <label id="elh_detrecibo_netocbterel" for="x_netocbterel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->netocbterel->caption() ?><?= $Page->netocbterel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->netocbterel->cellAttributes() ?>>
<span id="el_detrecibo_netocbterel">
<input type="<?= $Page->netocbterel->getInputTextType() ?>" name="x_netocbterel" id="x_netocbterel" data-table="detrecibo" data-field="x_netocbterel" value="<?= $Page->netocbterel->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->netocbterel->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->netocbterel->formatPattern()) ?>"<?= $Page->netocbterel->editAttributes() ?> aria-describedby="x_netocbterel_help">
<?= $Page->netocbterel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->netocbterel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <div id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <label id="elh_detrecibo_usuario" for="x_usuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario->caption() ?><?= $Page->usuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario->cellAttributes() ?>>
<span id="el_detrecibo_usuario">
<input type="<?= $Page->usuario->getInputTextType() ?>" name="x_usuario" id="x_usuario" data-table="detrecibo" data-field="x_usuario" value="<?= $Page->usuario->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->usuario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->usuario->formatPattern()) ?>"<?= $Page->usuario->editAttributes() ?> aria-describedby="x_usuario_help">
<?= $Page->usuario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->usuario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <div id="r_fechahora"<?= $Page->fechahora->rowAttributes() ?>>
        <label id="elh_detrecibo_fechahora" for="x_fechahora" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechahora->caption() ?><?= $Page->fechahora->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fechahora->cellAttributes() ?>>
<span id="el_detrecibo_fechahora">
<input type="<?= $Page->fechahora->getInputTextType() ?>" name="x_fechahora" id="x_fechahora" data-table="detrecibo" data-field="x_fechahora" value="<?= $Page->fechahora->EditValue ?>" placeholder="<?= HtmlEncode($Page->fechahora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fechahora->formatPattern()) ?>"<?= $Page->fechahora->editAttributes() ?> aria-describedby="x_fechahora_help">
<?= $Page->fechahora->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechahora->getErrorMessage() ?></div>
<?php if (!$Page->fechahora->ReadOnly && !$Page->fechahora->Disabled && !isset($Page->fechahora->EditAttrs["readonly"]) && !isset($Page->fechahora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdetreciboedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdetreciboedit", "x_fechahora", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
    <div id="r_nrodoc"<?= $Page->nrodoc->rowAttributes() ?>>
        <label id="elh_detrecibo_nrodoc" for="x_nrodoc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nrodoc->caption() ?><?= $Page->nrodoc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nrodoc->cellAttributes() ?>>
<span id="el_detrecibo_nrodoc">
<input type="<?= $Page->nrodoc->getInputTextType() ?>" name="x_nrodoc" id="x_nrodoc" data-table="detrecibo" data-field="x_nrodoc" value="<?= $Page->nrodoc->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->nrodoc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nrodoc->formatPattern()) ?>"<?= $Page->nrodoc->editAttributes() ?> aria-describedby="x_nrodoc_help">
<?= $Page->nrodoc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nrodoc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdetreciboedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdetreciboedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("detrecibo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
