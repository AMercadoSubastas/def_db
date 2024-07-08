<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LotesEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="flotesedit" id="flotesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { lotes: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var flotesedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flotesedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["codrem", [fields.codrem.visible && fields.codrem.required ? ew.Validators.required(fields.codrem.caption) : null], fields.codrem.isInvalid],
            ["codcli", [fields.codcli.visible && fields.codcli.required ? ew.Validators.required(fields.codcli.caption) : null], fields.codcli.isInvalid],
            ["codrubro", [fields.codrubro.visible && fields.codrubro.required ? ew.Validators.required(fields.codrubro.caption) : null], fields.codrubro.isInvalid],
            ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
            ["moneda", [fields.moneda.visible && fields.moneda.required ? ew.Validators.required(fields.moneda.caption) : null], fields.moneda.isInvalid],
            ["preciobase", [fields.preciobase.visible && fields.preciobase.required ? ew.Validators.required(fields.preciobase.caption) : null], fields.preciobase.isInvalid],
            ["preciofinal", [fields.preciofinal.visible && fields.preciofinal.required ? ew.Validators.required(fields.preciofinal.caption) : null, ew.Validators.float], fields.preciofinal.isInvalid],
            ["comiscobr", [fields.comiscobr.visible && fields.comiscobr.required ? ew.Validators.required(fields.comiscobr.caption) : null, ew.Validators.float], fields.comiscobr.isInvalid],
            ["comispag", [fields.comispag.visible && fields.comispag.required ? ew.Validators.required(fields.comispag.caption) : null], fields.comispag.isInvalid],
            ["comprador", [fields.comprador.visible && fields.comprador.required ? ew.Validators.required(fields.comprador.caption) : null], fields.comprador.isInvalid],
            ["ivari", [fields.ivari.visible && fields.ivari.required ? ew.Validators.required(fields.ivari.caption) : null], fields.ivari.isInvalid],
            ["ivarni", [fields.ivarni.visible && fields.ivarni.required ? ew.Validators.required(fields.ivarni.caption) : null], fields.ivarni.isInvalid],
            ["codimpadic", [fields.codimpadic.visible && fields.codimpadic.required ? ew.Validators.required(fields.codimpadic.caption) : null], fields.codimpadic.isInvalid],
            ["impadic", [fields.impadic.visible && fields.impadic.required ? ew.Validators.required(fields.impadic.caption) : null], fields.impadic.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["descor", [fields.descor.visible && fields.descor.required ? ew.Validators.required(fields.descor.caption) : null], fields.descor.isInvalid],
            ["observ", [fields.observ.visible && fields.observ.required ? ew.Validators.required(fields.observ.caption) : null], fields.observ.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["fecalta", [fields.fecalta.visible && fields.fecalta.required ? ew.Validators.required(fields.fecalta.caption) : null], fields.fecalta.isInvalid],
            ["codintlote", [fields.codintlote.visible && fields.codintlote.required ? ew.Validators.required(fields.codintlote.caption) : null], fields.codintlote.isInvalid],
            ["codintnum", [fields.codintnum.visible && fields.codintnum.required ? ew.Validators.required(fields.codintnum.caption) : null], fields.codintnum.isInvalid],
            ["codintsublote", [fields.codintsublote.visible && fields.codintsublote.required ? ew.Validators.required(fields.codintsublote.caption) : null], fields.codintsublote.isInvalid],
            ["usuarioultmod", [fields.usuarioultmod.visible && fields.usuarioultmod.required ? ew.Validators.required(fields.usuarioultmod.caption) : null], fields.usuarioultmod.isInvalid],
            ["fecultmod", [fields.fecultmod.visible && fields.fecultmod.required ? ew.Validators.required(fields.fecultmod.caption) : null], fields.fecultmod.isInvalid],
            ["dir_secuencia", [fields.dir_secuencia.visible && fields.dir_secuencia.required ? ew.Validators.required(fields.dir_secuencia.caption) : null], fields.dir_secuencia.isInvalid]
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

        // Multi-Page
        .setMultiPage(true)

        // Dynamic selection lists
        .setLists({
            "estado": <?= $Page->estado->toClientList($Page) ?>,
            "dir_secuencia": <?= $Page->dir_secuencia->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="lotes">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "remates") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="remates">
<input type="hidden" name="fk_ncomp" value="<?= HtmlEncode($Page->codrem->getSessionValue()) ?>">
<?php } ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_LotesEdit"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_lotes1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_lotes1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_lotes2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_lotes2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_lotes1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->codrem->Visible) { // codrem ?>
    <div id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <label id="elh_lotes_codrem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codrem->caption() ?><?= $Page->codrem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codrem->cellAttributes() ?>>
<span id="el_lotes_codrem">
<span<?= $Page->codrem->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->codrem->getDisplayValue($Page->codrem->EditValue) ?></span></span>
<input type="hidden" data-table="lotes" data-field="x_codrem" data-hidden="1" data-page="1" name="x_codrem" id="x_codrem" value="<?= HtmlEncode($Page->codrem->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->preciofinal->Visible) { // preciofinal ?>
    <div id="r_preciofinal"<?= $Page->preciofinal->rowAttributes() ?>>
        <label id="elh_lotes_preciofinal" for="x_preciofinal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->preciofinal->caption() ?><?= $Page->preciofinal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->preciofinal->cellAttributes() ?>>
<span id="el_lotes_preciofinal">
<input type="<?= $Page->preciofinal->getInputTextType() ?>" name="x_preciofinal" id="x_preciofinal" data-table="lotes" data-field="x_preciofinal" value="<?= $Page->preciofinal->EditValue ?>" data-page="1" size="100" placeholder="<?= HtmlEncode($Page->preciofinal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->preciofinal->formatPattern()) ?>"<?= $Page->preciofinal->editAttributes() ?> aria-describedby="x_preciofinal_help">
<?= $Page->preciofinal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->preciofinal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <label id="elh_lotes_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_lotes_descripcion">
<textarea data-table="lotes" data-field="x_descripcion" data-page="1" name="x_descripcion" id="x_descripcion" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>"<?= $Page->descripcion->editAttributes() ?> aria-describedby="x_descripcion_help"><?= $Page->descripcion->EditValue ?></textarea>
<?= $Page->descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codintlote->Visible) { // codintlote ?>
    <div id="r_codintlote"<?= $Page->codintlote->rowAttributes() ?>>
        <label id="elh_lotes_codintlote" for="x_codintlote" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codintlote->caption() ?><?= $Page->codintlote->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codintlote->cellAttributes() ?>>
<span id="el_lotes_codintlote">
<span<?= $Page->codintlote->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->codintlote->getDisplayValue($Page->codintlote->EditValue))) ?>"></span>
<input type="hidden" data-table="lotes" data-field="x_codintlote" data-hidden="1" data-page="1" name="x_codintlote" id="x_codintlote" value="<?= HtmlEncode($Page->codintlote->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dir_secuencia->Visible) { // dir_secuencia ?>
    <div id="r_dir_secuencia"<?= $Page->dir_secuencia->rowAttributes() ?>>
        <label id="elh_lotes_dir_secuencia" for="x_dir_secuencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dir_secuencia->caption() ?><?= $Page->dir_secuencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dir_secuencia->cellAttributes() ?>>
<span id="el_lotes_dir_secuencia">
    <select
        id="x_dir_secuencia"
        name="x_dir_secuencia"
        class="form-select ew-select<?= $Page->dir_secuencia->isInvalidClass() ?>"
        <?php if (!$Page->dir_secuencia->IsNativeSelect) { ?>
        data-select2-id="flotesedit_x_dir_secuencia"
        <?php } ?>
        data-table="lotes"
        data-field="x_dir_secuencia"
        data-page="1"
        data-value-separator="<?= $Page->dir_secuencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->dir_secuencia->getPlaceHolder()) ?>"
        <?= $Page->dir_secuencia->editAttributes() ?>>
        <?= $Page->dir_secuencia->selectOptionListHtml("x_dir_secuencia") ?>
    </select>
    <?= $Page->dir_secuencia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->dir_secuencia->getErrorMessage() ?></div>
<?= $Page->dir_secuencia->Lookup->getParamTag($Page, "p_x_dir_secuencia") ?>
<?php if (!$Page->dir_secuencia->IsNativeSelect) { ?>
<script>
loadjs.ready("flotesedit", function() {
    var options = { name: "x_dir_secuencia", selectId: "flotesedit_x_dir_secuencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flotesedit.lists.dir_secuencia?.lookupOptions.length) {
        options.data = { id: "x_dir_secuencia", form: "flotesedit" };
    } else {
        options.ajax = { id: "x_dir_secuencia", form: "flotesedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.lotes.fields.dir_secuencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_lotes2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->estado->Visible) { // estado ?>
    <div id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <label id="elh_lotes_estado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado->caption() ?><?= $Page->estado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estado->cellAttributes() ?>>
<span id="el_lotes_estado">
<template id="tp_x_estado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="lotes" data-field="x_estado" name="x_estado" id="x_estado"<?= $Page->estado->editAttributes() ?>>
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
    data-table="lotes"
    data-field="x_estado"
    data-page="2"
    data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
    <?= $Page->estado->editAttributes() ?>></selection-list>
<?= $Page->estado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comiscobr->Visible) { // comiscobr ?>
    <div id="r_comiscobr"<?= $Page->comiscobr->rowAttributes() ?>>
        <label id="elh_lotes_comiscobr" for="x_comiscobr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comiscobr->caption() ?><?= $Page->comiscobr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->comiscobr->cellAttributes() ?>>
<span id="el_lotes_comiscobr">
<input type="<?= $Page->comiscobr->getInputTextType() ?>" name="x_comiscobr" id="x_comiscobr" data-table="lotes" data-field="x_comiscobr" value="<?= $Page->comiscobr->EditValue ?>" data-page="2" size="30" placeholder="<?= HtmlEncode($Page->comiscobr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->comiscobr->formatPattern()) ?>"<?= $Page->comiscobr->editAttributes() ?> aria-describedby="x_comiscobr_help">
<?= $Page->comiscobr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->comiscobr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<span id="el_lotes_codcli">
<input type="hidden" data-table="lotes" data-field="x_codcli" data-hidden="1" name="x_codcli" id="x_codcli" value="<?= HtmlEncode($Page->codcli->CurrentValue) ?>">
</span>
<span id="el_lotes_codrubro">
<input type="hidden" data-table="lotes" data-field="x_codrubro" data-hidden="1" name="x_codrubro" id="x_codrubro" value="<?= HtmlEncode($Page->codrubro->CurrentValue) ?>">
</span>
<span id="el_lotes_moneda">
<input type="hidden" data-table="lotes" data-field="x_moneda" data-hidden="1" data-page="1" name="x_moneda" id="x_moneda" value="<?= HtmlEncode($Page->moneda->CurrentValue) ?>">
</span>
<span id="el_lotes_preciobase">
<input type="hidden" data-table="lotes" data-field="x_preciobase" data-hidden="1" data-page="1" name="x_preciobase" id="x_preciobase" value="<?= HtmlEncode($Page->preciobase->CurrentValue) ?>">
</span>
<span id="el_lotes_comispag">
<input type="hidden" data-table="lotes" data-field="x_comispag" data-hidden="1" data-page="1" name="x_comispag" id="x_comispag" value="<?= HtmlEncode($Page->comispag->CurrentValue) ?>">
</span>
<span id="el_lotes_comprador">
<input type="hidden" data-table="lotes" data-field="x_comprador" data-hidden="1" name="x_comprador" id="x_comprador" value="<?= HtmlEncode($Page->comprador->CurrentValue) ?>">
</span>
<span id="el_lotes_ivari">
<input type="hidden" data-table="lotes" data-field="x_ivari" data-hidden="1" name="x_ivari" id="x_ivari" value="<?= HtmlEncode($Page->ivari->CurrentValue) ?>">
</span>
<span id="el_lotes_ivarni">
<input type="hidden" data-table="lotes" data-field="x_ivarni" data-hidden="1" name="x_ivarni" id="x_ivarni" value="<?= HtmlEncode($Page->ivarni->CurrentValue) ?>">
</span>
<span id="el_lotes_codimpadic">
<input type="hidden" data-table="lotes" data-field="x_codimpadic" data-hidden="1" name="x_codimpadic" id="x_codimpadic" value="<?= HtmlEncode($Page->codimpadic->CurrentValue) ?>">
</span>
<span id="el_lotes_impadic">
<input type="hidden" data-table="lotes" data-field="x_impadic" data-hidden="1" name="x_impadic" id="x_impadic" value="<?= HtmlEncode($Page->impadic->CurrentValue) ?>">
</span>
<span id="el_lotes_descor">
<input type="hidden" data-table="lotes" data-field="x_descor" data-hidden="1" name="x_descor" id="x_descor" value="<?= HtmlEncode($Page->descor->CurrentValue) ?>">
</span>
<span id="el_lotes_observ">
<input type="hidden" data-table="lotes" data-field="x_observ" data-hidden="1" name="x_observ" id="x_observ" value="<?= HtmlEncode($Page->observ->CurrentValue) ?>">
</span>
<span id="el_lotes_codintnum">
<input type="hidden" data-table="lotes" data-field="x_codintnum" data-hidden="1" name="x_codintnum" id="x_codintnum" value="<?= HtmlEncode($Page->codintnum->CurrentValue) ?>">
</span>
<span id="el_lotes_codintsublote">
<input type="hidden" data-table="lotes" data-field="x_codintsublote" data-hidden="1" name="x_codintsublote" id="x_codintsublote" value="<?= HtmlEncode($Page->codintsublote->CurrentValue) ?>">
</span>
    <input type="hidden" data-table="lotes" data-field="x_codnum" data-hidden="1" name="x_codnum" id="x_codnum" value="<?= HtmlEncode($Page->codnum->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="flotesedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="flotesedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("lotes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
