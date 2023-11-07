<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetfacAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detfac: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fdetfacadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetfacadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tcomp", [fields.tcomp.visible && fields.tcomp.required ? ew.Validators.required(fields.tcomp.caption) : null, ew.Validators.integer], fields.tcomp.isInvalid],
            ["serie", [fields.serie.visible && fields.serie.required ? ew.Validators.required(fields.serie.caption) : null, ew.Validators.integer], fields.serie.isInvalid],
            ["ncomp", [fields.ncomp.visible && fields.ncomp.required ? ew.Validators.required(fields.ncomp.caption) : null, ew.Validators.integer], fields.ncomp.isInvalid],
            ["nreng", [fields.nreng.visible && fields.nreng.required ? ew.Validators.required(fields.nreng.caption) : null, ew.Validators.integer], fields.nreng.isInvalid],
            ["codrem", [fields.codrem.visible && fields.codrem.required ? ew.Validators.required(fields.codrem.caption) : null, ew.Validators.integer], fields.codrem.isInvalid],
            ["codlote", [fields.codlote.visible && fields.codlote.required ? ew.Validators.required(fields.codlote.caption) : null, ew.Validators.integer], fields.codlote.isInvalid],
            ["descrip", [fields.descrip.visible && fields.descrip.required ? ew.Validators.required(fields.descrip.caption) : null], fields.descrip.isInvalid],
            ["neto", [fields.neto.visible && fields.neto.required ? ew.Validators.required(fields.neto.caption) : null, ew.Validators.float], fields.neto.isInvalid],
            ["bruto", [fields.bruto.visible && fields.bruto.required ? ew.Validators.required(fields.bruto.caption) : null, ew.Validators.float], fields.bruto.isInvalid],
            ["iva", [fields.iva.visible && fields.iva.required ? ew.Validators.required(fields.iva.caption) : null, ew.Validators.float], fields.iva.isInvalid],
            ["imp", [fields.imp.visible && fields.imp.required ? ew.Validators.required(fields.imp.caption) : null, ew.Validators.float], fields.imp.isInvalid],
            ["comcob", [fields.comcob.visible && fields.comcob.required ? ew.Validators.required(fields.comcob.caption) : null, ew.Validators.float], fields.comcob.isInvalid],
            ["compag", [fields.compag.visible && fields.compag.required ? ew.Validators.required(fields.compag.caption) : null, ew.Validators.float], fields.compag.isInvalid],
            ["fechahora", [fields.fechahora.visible && fields.fechahora.required ? ew.Validators.required(fields.fechahora.caption) : null], fields.fechahora.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["porciva", [fields.porciva.visible && fields.porciva.required ? ew.Validators.required(fields.porciva.caption) : null, ew.Validators.float], fields.porciva.isInvalid],
            ["tieneresol", [fields.tieneresol.visible && fields.tieneresol.required ? ew.Validators.required(fields.tieneresol.caption) : null], fields.tieneresol.isInvalid],
            ["concafac", [fields.concafac.visible && fields.concafac.required ? ew.Validators.required(fields.concafac.caption) : null, ew.Validators.integer], fields.concafac.isInvalid],
            ["tcomsal", [fields.tcomsal.visible && fields.tcomsal.required ? ew.Validators.required(fields.tcomsal.caption) : null, ew.Validators.integer], fields.tcomsal.isInvalid],
            ["seriesal", [fields.seriesal.visible && fields.seriesal.required ? ew.Validators.required(fields.seriesal.caption) : null, ew.Validators.integer], fields.seriesal.isInvalid],
            ["ncompsal", [fields.ncompsal.visible && fields.ncompsal.required ? ew.Validators.required(fields.ncompsal.caption) : null, ew.Validators.integer], fields.ncompsal.isInvalid]
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
<form name="fdetfacadd" id="fdetfacadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="detfac">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "cabfac") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="cabfac">
<input type="hidden" name="fk_tcomp" value="<?= HtmlEncode($Page->tcomp->getSessionValue()) ?>">
<input type="hidden" name="fk_serie" value="<?= HtmlEncode($Page->serie->getSessionValue()) ?>">
<input type="hidden" name="fk_ncomp" value="<?= HtmlEncode($Page->ncomp->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <div id="r_tcomp"<?= $Page->tcomp->rowAttributes() ?>>
        <label id="elh_detfac_tcomp" for="x_tcomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomp->caption() ?><?= $Page->tcomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomp->cellAttributes() ?>>
<?php if ($Page->tcomp->getSessionValue() != "") { ?>
<span<?= $Page->tcomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->tcomp->getDisplayValue($Page->tcomp->ViewValue))) ?>"></span>
<input type="hidden" id="x_tcomp" name="x_tcomp" value="<?= HtmlEncode($Page->tcomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_detfac_tcomp">
<input type="<?= $Page->tcomp->getInputTextType() ?>" name="x_tcomp" id="x_tcomp" data-table="detfac" data-field="x_tcomp" value="<?= $Page->tcomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tcomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcomp->formatPattern()) ?>"<?= $Page->tcomp->editAttributes() ?> aria-describedby="x_tcomp_help">
<?= $Page->tcomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcomp->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <div id="r_serie"<?= $Page->serie->rowAttributes() ?>>
        <label id="elh_detfac_serie" for="x_serie" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serie->caption() ?><?= $Page->serie->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serie->cellAttributes() ?>>
<?php if ($Page->serie->getSessionValue() != "") { ?>
<span<?= $Page->serie->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->serie->getDisplayValue($Page->serie->ViewValue))) ?>"></span>
<input type="hidden" id="x_serie" name="x_serie" value="<?= HtmlEncode($Page->serie->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_detfac_serie">
<input type="<?= $Page->serie->getInputTextType() ?>" name="x_serie" id="x_serie" data-table="detfac" data-field="x_serie" value="<?= $Page->serie->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->serie->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->serie->formatPattern()) ?>"<?= $Page->serie->editAttributes() ?> aria-describedby="x_serie_help">
<?= $Page->serie->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serie->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <div id="r_ncomp"<?= $Page->ncomp->rowAttributes() ?>>
        <label id="elh_detfac_ncomp" for="x_ncomp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncomp->caption() ?><?= $Page->ncomp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncomp->cellAttributes() ?>>
<?php if ($Page->ncomp->getSessionValue() != "") { ?>
<span<?= $Page->ncomp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ncomp->getDisplayValue($Page->ncomp->ViewValue))) ?>"></span>
<input type="hidden" id="x_ncomp" name="x_ncomp" value="<?= HtmlEncode($Page->ncomp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_detfac_ncomp">
<input type="<?= $Page->ncomp->getInputTextType() ?>" name="x_ncomp" id="x_ncomp" data-table="detfac" data-field="x_ncomp" value="<?= $Page->ncomp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncomp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncomp->formatPattern()) ?>"<?= $Page->ncomp->editAttributes() ?> aria-describedby="x_ncomp_help">
<?= $Page->ncomp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncomp->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
    <div id="r_nreng"<?= $Page->nreng->rowAttributes() ?>>
        <label id="elh_detfac_nreng" for="x_nreng" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nreng->caption() ?><?= $Page->nreng->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nreng->cellAttributes() ?>>
<span id="el_detfac_nreng">
<input type="<?= $Page->nreng->getInputTextType() ?>" name="x_nreng" id="x_nreng" data-table="detfac" data-field="x_nreng" value="<?= $Page->nreng->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nreng->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nreng->formatPattern()) ?>"<?= $Page->nreng->editAttributes() ?> aria-describedby="x_nreng_help">
<?= $Page->nreng->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nreng->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <div id="r_codrem"<?= $Page->codrem->rowAttributes() ?>>
        <label id="elh_detfac_codrem" for="x_codrem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codrem->caption() ?><?= $Page->codrem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codrem->cellAttributes() ?>>
<span id="el_detfac_codrem">
<input type="<?= $Page->codrem->getInputTextType() ?>" name="x_codrem" id="x_codrem" data-table="detfac" data-field="x_codrem" value="<?= $Page->codrem->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codrem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codrem->formatPattern()) ?>"<?= $Page->codrem->editAttributes() ?> aria-describedby="x_codrem_help">
<?= $Page->codrem->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codrem->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codlote->Visible) { // codlote ?>
    <div id="r_codlote"<?= $Page->codlote->rowAttributes() ?>>
        <label id="elh_detfac_codlote" for="x_codlote" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codlote->caption() ?><?= $Page->codlote->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codlote->cellAttributes() ?>>
<span id="el_detfac_codlote">
<input type="<?= $Page->codlote->getInputTextType() ?>" name="x_codlote" id="x_codlote" data-table="detfac" data-field="x_codlote" value="<?= $Page->codlote->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->codlote->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codlote->formatPattern()) ?>"<?= $Page->codlote->editAttributes() ?> aria-describedby="x_codlote_help">
<?= $Page->codlote->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codlote->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
    <div id="r_descrip"<?= $Page->descrip->rowAttributes() ?>>
        <label id="elh_detfac_descrip" for="x_descrip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descrip->caption() ?><?= $Page->descrip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descrip->cellAttributes() ?>>
<span id="el_detfac_descrip">
<input type="<?= $Page->descrip->getInputTextType() ?>" name="x_descrip" id="x_descrip" data-table="detfac" data-field="x_descrip" value="<?= $Page->descrip->EditValue ?>" size="30" maxlength="300" placeholder="<?= HtmlEncode($Page->descrip->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descrip->formatPattern()) ?>"<?= $Page->descrip->editAttributes() ?> aria-describedby="x_descrip_help">
<?= $Page->descrip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descrip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->neto->Visible) { // neto ?>
    <div id="r_neto"<?= $Page->neto->rowAttributes() ?>>
        <label id="elh_detfac_neto" for="x_neto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->neto->caption() ?><?= $Page->neto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->neto->cellAttributes() ?>>
<span id="el_detfac_neto">
<input type="<?= $Page->neto->getInputTextType() ?>" name="x_neto" id="x_neto" data-table="detfac" data-field="x_neto" value="<?= $Page->neto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->neto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->neto->formatPattern()) ?>"<?= $Page->neto->editAttributes() ?> aria-describedby="x_neto_help">
<?= $Page->neto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->neto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bruto->Visible) { // bruto ?>
    <div id="r_bruto"<?= $Page->bruto->rowAttributes() ?>>
        <label id="elh_detfac_bruto" for="x_bruto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bruto->caption() ?><?= $Page->bruto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->bruto->cellAttributes() ?>>
<span id="el_detfac_bruto">
<input type="<?= $Page->bruto->getInputTextType() ?>" name="x_bruto" id="x_bruto" data-table="detfac" data-field="x_bruto" value="<?= $Page->bruto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->bruto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->bruto->formatPattern()) ?>"<?= $Page->bruto->editAttributes() ?> aria-describedby="x_bruto_help">
<?= $Page->bruto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bruto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->iva->Visible) { // iva ?>
    <div id="r_iva"<?= $Page->iva->rowAttributes() ?>>
        <label id="elh_detfac_iva" for="x_iva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iva->caption() ?><?= $Page->iva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->iva->cellAttributes() ?>>
<span id="el_detfac_iva">
<input type="<?= $Page->iva->getInputTextType() ?>" name="x_iva" id="x_iva" data-table="detfac" data-field="x_iva" value="<?= $Page->iva->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->iva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->iva->formatPattern()) ?>"<?= $Page->iva->editAttributes() ?> aria-describedby="x_iva_help">
<?= $Page->iva->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->iva->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imp->Visible) { // imp ?>
    <div id="r_imp"<?= $Page->imp->rowAttributes() ?>>
        <label id="elh_detfac_imp" for="x_imp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->imp->caption() ?><?= $Page->imp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->imp->cellAttributes() ?>>
<span id="el_detfac_imp">
<input type="<?= $Page->imp->getInputTextType() ?>" name="x_imp" id="x_imp" data-table="detfac" data-field="x_imp" value="<?= $Page->imp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->imp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->imp->formatPattern()) ?>"<?= $Page->imp->editAttributes() ?> aria-describedby="x_imp_help">
<?= $Page->imp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->imp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comcob->Visible) { // comcob ?>
    <div id="r_comcob"<?= $Page->comcob->rowAttributes() ?>>
        <label id="elh_detfac_comcob" for="x_comcob" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comcob->caption() ?><?= $Page->comcob->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->comcob->cellAttributes() ?>>
<span id="el_detfac_comcob">
<input type="<?= $Page->comcob->getInputTextType() ?>" name="x_comcob" id="x_comcob" data-table="detfac" data-field="x_comcob" value="<?= $Page->comcob->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->comcob->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->comcob->formatPattern()) ?>"<?= $Page->comcob->editAttributes() ?> aria-describedby="x_comcob_help">
<?= $Page->comcob->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->comcob->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->compag->Visible) { // compag ?>
    <div id="r_compag"<?= $Page->compag->rowAttributes() ?>>
        <label id="elh_detfac_compag" for="x_compag" class="<?= $Page->LeftColumnClass ?>"><?= $Page->compag->caption() ?><?= $Page->compag->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->compag->cellAttributes() ?>>
<span id="el_detfac_compag">
<input type="<?= $Page->compag->getInputTextType() ?>" name="x_compag" id="x_compag" data-table="detfac" data-field="x_compag" value="<?= $Page->compag->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->compag->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->compag->formatPattern()) ?>"<?= $Page->compag->editAttributes() ?> aria-describedby="x_compag_help">
<?= $Page->compag->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->compag->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
    <div id="r_porciva"<?= $Page->porciva->rowAttributes() ?>>
        <label id="elh_detfac_porciva" for="x_porciva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->porciva->caption() ?><?= $Page->porciva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->porciva->cellAttributes() ?>>
<span id="el_detfac_porciva">
<input type="<?= $Page->porciva->getInputTextType() ?>" name="x_porciva" id="x_porciva" data-table="detfac" data-field="x_porciva" value="<?= $Page->porciva->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->porciva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porciva->formatPattern()) ?>"<?= $Page->porciva->editAttributes() ?> aria-describedby="x_porciva_help">
<?= $Page->porciva->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->porciva->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_detfac_tieneresol">
    <input type="hidden" data-table="detfac" data-field="x_tieneresol" data-hidden="1" name="x_tieneresol" id="x_tieneresol" value="<?= HtmlEncode($Page->tieneresol->CurrentValue) ?>">
    </span>
<?php if ($Page->concafac->Visible) { // concafac ?>
    <div id="r_concafac"<?= $Page->concafac->rowAttributes() ?>>
        <label id="elh_detfac_concafac" for="x_concafac" class="<?= $Page->LeftColumnClass ?>"><?= $Page->concafac->caption() ?><?= $Page->concafac->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->concafac->cellAttributes() ?>>
<span id="el_detfac_concafac">
<input type="<?= $Page->concafac->getInputTextType() ?>" name="x_concafac" id="x_concafac" data-table="detfac" data-field="x_concafac" value="<?= $Page->concafac->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->concafac->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->concafac->formatPattern()) ?>"<?= $Page->concafac->editAttributes() ?> aria-describedby="x_concafac_help">
<?= $Page->concafac->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->concafac->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tcomsal->Visible) { // tcomsal ?>
    <div id="r_tcomsal"<?= $Page->tcomsal->rowAttributes() ?>>
        <label id="elh_detfac_tcomsal" for="x_tcomsal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tcomsal->caption() ?><?= $Page->tcomsal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tcomsal->cellAttributes() ?>>
<span id="el_detfac_tcomsal">
<input type="<?= $Page->tcomsal->getInputTextType() ?>" name="x_tcomsal" id="x_tcomsal" data-table="detfac" data-field="x_tcomsal" value="<?= $Page->tcomsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tcomsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tcomsal->formatPattern()) ?>"<?= $Page->tcomsal->editAttributes() ?> aria-describedby="x_tcomsal_help">
<?= $Page->tcomsal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tcomsal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
    <div id="r_seriesal"<?= $Page->seriesal->rowAttributes() ?>>
        <label id="elh_detfac_seriesal" for="x_seriesal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seriesal->caption() ?><?= $Page->seriesal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seriesal->cellAttributes() ?>>
<span id="el_detfac_seriesal">
<input type="<?= $Page->seriesal->getInputTextType() ?>" name="x_seriesal" id="x_seriesal" data-table="detfac" data-field="x_seriesal" value="<?= $Page->seriesal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->seriesal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seriesal->formatPattern()) ?>"<?= $Page->seriesal->editAttributes() ?> aria-describedby="x_seriesal_help">
<?= $Page->seriesal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->seriesal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
    <div id="r_ncompsal"<?= $Page->ncompsal->rowAttributes() ?>>
        <label id="elh_detfac_ncompsal" for="x_ncompsal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ncompsal->caption() ?><?= $Page->ncompsal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ncompsal->cellAttributes() ?>>
<span id="el_detfac_ncompsal">
<input type="<?= $Page->ncompsal->getInputTextType() ?>" name="x_ncompsal" id="x_ncompsal" data-table="detfac" data-field="x_ncompsal" value="<?= $Page->ncompsal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ncompsal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ncompsal->formatPattern()) ?>"<?= $Page->ncompsal->editAttributes() ?> aria-describedby="x_ncompsal_help">
<?= $Page->ncompsal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ncompsal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdetfacadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdetfacadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("detfac");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
