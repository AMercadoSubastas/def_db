<?php

namespace PHPMaker2024\Subastas2024;

// Table
$cabfac = Container("cabfac");
$cabfac->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($cabfac->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cabfacmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cabfac->codnum->Visible) { // codnum ?>
        <tr id="r_codnum"<?= $cabfac->codnum->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->codnum->caption() ?></td>
            <td<?= $cabfac->codnum->cellAttributes() ?>>
<span id="el_cabfac_codnum">
<span<?= $cabfac->codnum->viewAttributes() ?>>
<?= $cabfac->codnum->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->tcomp->Visible) { // tcomp ?>
        <tr id="r_tcomp"<?= $cabfac->tcomp->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->tcomp->caption() ?></td>
            <td<?= $cabfac->tcomp->cellAttributes() ?>>
<span id="el_cabfac_tcomp">
<span<?= $cabfac->tcomp->viewAttributes() ?>>
<?= $cabfac->tcomp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->serie->Visible) { // serie ?>
        <tr id="r_serie"<?= $cabfac->serie->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->serie->caption() ?></td>
            <td<?= $cabfac->serie->cellAttributes() ?>>
<span id="el_cabfac_serie">
<span<?= $cabfac->serie->viewAttributes() ?>>
<?= $cabfac->serie->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->ncomp->Visible) { // ncomp ?>
        <tr id="r_ncomp"<?= $cabfac->ncomp->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->ncomp->caption() ?></td>
            <td<?= $cabfac->ncomp->cellAttributes() ?>>
<span id="el_cabfac_ncomp">
<span<?= $cabfac->ncomp->viewAttributes() ?>>
<?= $cabfac->ncomp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->fecval->Visible) { // fecval ?>
        <tr id="r_fecval"<?= $cabfac->fecval->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->fecval->caption() ?></td>
            <td<?= $cabfac->fecval->cellAttributes() ?>>
<span id="el_cabfac_fecval">
<span<?= $cabfac->fecval->viewAttributes() ?>>
<?= $cabfac->fecval->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->fecdoc->Visible) { // fecdoc ?>
        <tr id="r_fecdoc"<?= $cabfac->fecdoc->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->fecdoc->caption() ?></td>
            <td<?= $cabfac->fecdoc->cellAttributes() ?>>
<span id="el_cabfac_fecdoc">
<span<?= $cabfac->fecdoc->viewAttributes() ?>>
<?= $cabfac->fecdoc->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->fecreg->Visible) { // fecreg ?>
        <tr id="r_fecreg"<?= $cabfac->fecreg->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->fecreg->caption() ?></td>
            <td<?= $cabfac->fecreg->cellAttributes() ?>>
<span id="el_cabfac_fecreg">
<span<?= $cabfac->fecreg->viewAttributes() ?>>
<?= $cabfac->fecreg->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->cliente->Visible) { // cliente ?>
        <tr id="r_cliente"<?= $cabfac->cliente->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->cliente->caption() ?></td>
            <td<?= $cabfac->cliente->cellAttributes() ?>>
<span id="el_cabfac_cliente">
<span<?= $cabfac->cliente->viewAttributes() ?>>
<?= $cabfac->cliente->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->direc->Visible) { // direc ?>
        <tr id="r_direc"<?= $cabfac->direc->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->direc->caption() ?></td>
            <td<?= $cabfac->direc->cellAttributes() ?>>
<span id="el_cabfac_direc">
<span<?= $cabfac->direc->viewAttributes() ?>>
<?= $cabfac->direc->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->dnro->Visible) { // dnro ?>
        <tr id="r_dnro"<?= $cabfac->dnro->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->dnro->caption() ?></td>
            <td<?= $cabfac->dnro->cellAttributes() ?>>
<span id="el_cabfac_dnro">
<span<?= $cabfac->dnro->viewAttributes() ?>>
<?= $cabfac->dnro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->pisodto->Visible) { // pisodto ?>
        <tr id="r_pisodto"<?= $cabfac->pisodto->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->pisodto->caption() ?></td>
            <td<?= $cabfac->pisodto->cellAttributes() ?>>
<span id="el_cabfac_pisodto">
<span<?= $cabfac->pisodto->viewAttributes() ?>>
<?= $cabfac->pisodto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->codpost->Visible) { // codpost ?>
        <tr id="r_codpost"<?= $cabfac->codpost->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->codpost->caption() ?></td>
            <td<?= $cabfac->codpost->cellAttributes() ?>>
<span id="el_cabfac_codpost">
<span<?= $cabfac->codpost->viewAttributes() ?>>
<?= $cabfac->codpost->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->codpais->Visible) { // codpais ?>
        <tr id="r_codpais"<?= $cabfac->codpais->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->codpais->caption() ?></td>
            <td<?= $cabfac->codpais->cellAttributes() ?>>
<span id="el_cabfac_codpais">
<span<?= $cabfac->codpais->viewAttributes() ?>>
<?= $cabfac->codpais->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->codprov->Visible) { // codprov ?>
        <tr id="r_codprov"<?= $cabfac->codprov->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->codprov->caption() ?></td>
            <td<?= $cabfac->codprov->cellAttributes() ?>>
<span id="el_cabfac_codprov">
<span<?= $cabfac->codprov->viewAttributes() ?>>
<?= $cabfac->codprov->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->codloc->Visible) { // codloc ?>
        <tr id="r_codloc"<?= $cabfac->codloc->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->codloc->caption() ?></td>
            <td<?= $cabfac->codloc->cellAttributes() ?>>
<span id="el_cabfac_codloc">
<span<?= $cabfac->codloc->viewAttributes() ?>>
<?= $cabfac->codloc->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->telef->Visible) { // telef ?>
        <tr id="r_telef"<?= $cabfac->telef->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->telef->caption() ?></td>
            <td<?= $cabfac->telef->cellAttributes() ?>>
<span id="el_cabfac_telef">
<span<?= $cabfac->telef->viewAttributes() ?>>
<?= $cabfac->telef->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->codrem->Visible) { // codrem ?>
        <tr id="r_codrem"<?= $cabfac->codrem->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->codrem->caption() ?></td>
            <td<?= $cabfac->codrem->cellAttributes() ?>>
<span id="el_cabfac_codrem">
<span<?= $cabfac->codrem->viewAttributes() ?>>
<?= $cabfac->codrem->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->estado->Visible) { // estado ?>
        <tr id="r_estado"<?= $cabfac->estado->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->estado->caption() ?></td>
            <td<?= $cabfac->estado->cellAttributes() ?>>
<span id="el_cabfac_estado">
<span<?= $cabfac->estado->viewAttributes() ?>>
<?= $cabfac->estado->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->emitido->Visible) { // emitido ?>
        <tr id="r_emitido"<?= $cabfac->emitido->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->emitido->caption() ?></td>
            <td<?= $cabfac->emitido->cellAttributes() ?>>
<span id="el_cabfac_emitido">
<span<?= $cabfac->emitido->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($cabfac->emitido->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->moneda->Visible) { // moneda ?>
        <tr id="r_moneda"<?= $cabfac->moneda->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->moneda->caption() ?></td>
            <td<?= $cabfac->moneda->cellAttributes() ?>>
<span id="el_cabfac_moneda">
<span<?= $cabfac->moneda->viewAttributes() ?>>
<?= $cabfac->moneda->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->totneto->Visible) { // totneto ?>
        <tr id="r_totneto"<?= $cabfac->totneto->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->totneto->caption() ?></td>
            <td<?= $cabfac->totneto->cellAttributes() ?>>
<span id="el_cabfac_totneto">
<span<?= $cabfac->totneto->viewAttributes() ?>>
<?= $cabfac->totneto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->totbruto->Visible) { // totbruto ?>
        <tr id="r_totbruto"<?= $cabfac->totbruto->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->totbruto->caption() ?></td>
            <td<?= $cabfac->totbruto->cellAttributes() ?>>
<span id="el_cabfac_totbruto">
<span<?= $cabfac->totbruto->viewAttributes() ?>>
<?= $cabfac->totbruto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->totiva105->Visible) { // totiva105 ?>
        <tr id="r_totiva105"<?= $cabfac->totiva105->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->totiva105->caption() ?></td>
            <td<?= $cabfac->totiva105->cellAttributes() ?>>
<span id="el_cabfac_totiva105">
<span<?= $cabfac->totiva105->viewAttributes() ?>>
<?= $cabfac->totiva105->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->totiva21->Visible) { // totiva21 ?>
        <tr id="r_totiva21"<?= $cabfac->totiva21->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->totiva21->caption() ?></td>
            <td<?= $cabfac->totiva21->cellAttributes() ?>>
<span id="el_cabfac_totiva21">
<span<?= $cabfac->totiva21->viewAttributes() ?>>
<?= $cabfac->totiva21->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->totimp->Visible) { // totimp ?>
        <tr id="r_totimp"<?= $cabfac->totimp->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->totimp->caption() ?></td>
            <td<?= $cabfac->totimp->cellAttributes() ?>>
<span id="el_cabfac_totimp">
<span<?= $cabfac->totimp->viewAttributes() ?>>
<?= $cabfac->totimp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->totcomis->Visible) { // totcomis ?>
        <tr id="r_totcomis"<?= $cabfac->totcomis->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->totcomis->caption() ?></td>
            <td<?= $cabfac->totcomis->cellAttributes() ?>>
<span id="el_cabfac_totcomis">
<span<?= $cabfac->totcomis->viewAttributes() ?>>
<?= $cabfac->totcomis->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->totneto105->Visible) { // totneto105 ?>
        <tr id="r_totneto105"<?= $cabfac->totneto105->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->totneto105->caption() ?></td>
            <td<?= $cabfac->totneto105->cellAttributes() ?>>
<span id="el_cabfac_totneto105">
<span<?= $cabfac->totneto105->viewAttributes() ?>>
<?= $cabfac->totneto105->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->totneto21->Visible) { // totneto21 ?>
        <tr id="r_totneto21"<?= $cabfac->totneto21->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->totneto21->caption() ?></td>
            <td<?= $cabfac->totneto21->cellAttributes() ?>>
<span id="el_cabfac_totneto21">
<span<?= $cabfac->totneto21->viewAttributes() ?>>
<?= $cabfac->totneto21->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->tipoiva->Visible) { // tipoiva ?>
        <tr id="r_tipoiva"<?= $cabfac->tipoiva->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->tipoiva->caption() ?></td>
            <td<?= $cabfac->tipoiva->cellAttributes() ?>>
<span id="el_cabfac_tipoiva">
<span<?= $cabfac->tipoiva->viewAttributes() ?>>
<?= $cabfac->tipoiva->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->porciva->Visible) { // porciva ?>
        <tr id="r_porciva"<?= $cabfac->porciva->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->porciva->caption() ?></td>
            <td<?= $cabfac->porciva->cellAttributes() ?>>
<span id="el_cabfac_porciva">
<span<?= $cabfac->porciva->viewAttributes() ?>>
<?= $cabfac->porciva->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->nrengs->Visible) { // nrengs ?>
        <tr id="r_nrengs"<?= $cabfac->nrengs->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->nrengs->caption() ?></td>
            <td<?= $cabfac->nrengs->cellAttributes() ?>>
<span id="el_cabfac_nrengs">
<span<?= $cabfac->nrengs->viewAttributes() ?>>
<?= $cabfac->nrengs->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->fechahora->Visible) { // fechahora ?>
        <tr id="r_fechahora"<?= $cabfac->fechahora->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->fechahora->caption() ?></td>
            <td<?= $cabfac->fechahora->cellAttributes() ?>>
<span id="el_cabfac_fechahora">
<span<?= $cabfac->fechahora->viewAttributes() ?>>
<?= $cabfac->fechahora->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->usuario->Visible) { // usuario ?>
        <tr id="r_usuario"<?= $cabfac->usuario->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->usuario->caption() ?></td>
            <td<?= $cabfac->usuario->cellAttributes() ?>>
<span id="el_cabfac_usuario">
<span<?= $cabfac->usuario->viewAttributes() ?>>
<?= $cabfac->usuario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->tieneresol->Visible) { // tieneresol ?>
        <tr id="r_tieneresol"<?= $cabfac->tieneresol->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->tieneresol->caption() ?></td>
            <td<?= $cabfac->tieneresol->cellAttributes() ?>>
<span id="el_cabfac_tieneresol">
<span<?= $cabfac->tieneresol->viewAttributes() ?>>
<?= $cabfac->tieneresol->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->concepto->Visible) { // concepto ?>
        <tr id="r_concepto"<?= $cabfac->concepto->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->concepto->caption() ?></td>
            <td<?= $cabfac->concepto->cellAttributes() ?>>
<span id="el_cabfac_concepto">
<span<?= $cabfac->concepto->viewAttributes() ?>>
<?= $cabfac->concepto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->nrodoc->Visible) { // nrodoc ?>
        <tr id="r_nrodoc"<?= $cabfac->nrodoc->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->nrodoc->caption() ?></td>
            <td<?= $cabfac->nrodoc->cellAttributes() ?>>
<span id="el_cabfac_nrodoc">
<span<?= $cabfac->nrodoc->viewAttributes() ?>>
<?= $cabfac->nrodoc->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->tcompsal->Visible) { // tcompsal ?>
        <tr id="r_tcompsal"<?= $cabfac->tcompsal->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->tcompsal->caption() ?></td>
            <td<?= $cabfac->tcompsal->cellAttributes() ?>>
<span id="el_cabfac_tcompsal">
<span<?= $cabfac->tcompsal->viewAttributes() ?>>
<?= $cabfac->tcompsal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->seriesal->Visible) { // seriesal ?>
        <tr id="r_seriesal"<?= $cabfac->seriesal->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->seriesal->caption() ?></td>
            <td<?= $cabfac->seriesal->cellAttributes() ?>>
<span id="el_cabfac_seriesal">
<span<?= $cabfac->seriesal->viewAttributes() ?>>
<?= $cabfac->seriesal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->ncompsal->Visible) { // ncompsal ?>
        <tr id="r_ncompsal"<?= $cabfac->ncompsal->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->ncompsal->caption() ?></td>
            <td<?= $cabfac->ncompsal->cellAttributes() ?>>
<span id="el_cabfac_ncompsal">
<span<?= $cabfac->ncompsal->viewAttributes() ?>>
<?= $cabfac->ncompsal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->en_liquid->Visible) { // en_liquid ?>
        <tr id="r_en_liquid"<?= $cabfac->en_liquid->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->en_liquid->caption() ?></td>
            <td<?= $cabfac->en_liquid->cellAttributes() ?>>
<span id="el_cabfac_en_liquid">
<span<?= $cabfac->en_liquid->viewAttributes() ?>>
<?= $cabfac->en_liquid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->CAE->Visible) { // CAE ?>
        <tr id="r_CAE"<?= $cabfac->CAE->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->CAE->caption() ?></td>
            <td<?= $cabfac->CAE->cellAttributes() ?>>
<span id="el_cabfac_CAE">
<span<?= $cabfac->CAE->viewAttributes() ?>>
<?= $cabfac->CAE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->CAEFchVto->Visible) { // CAEFchVto ?>
        <tr id="r_CAEFchVto"<?= $cabfac->CAEFchVto->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->CAEFchVto->caption() ?></td>
            <td<?= $cabfac->CAEFchVto->cellAttributes() ?>>
<span id="el_cabfac_CAEFchVto">
<span<?= $cabfac->CAEFchVto->viewAttributes() ?>>
<?= $cabfac->CAEFchVto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->Resultado->Visible) { // Resultado ?>
        <tr id="r_Resultado"<?= $cabfac->Resultado->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->Resultado->caption() ?></td>
            <td<?= $cabfac->Resultado->cellAttributes() ?>>
<span id="el_cabfac_Resultado">
<span<?= $cabfac->Resultado->viewAttributes() ?>>
<?= $cabfac->Resultado->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->usuarioultmod->Visible) { // usuarioultmod ?>
        <tr id="r_usuarioultmod"<?= $cabfac->usuarioultmod->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->usuarioultmod->caption() ?></td>
            <td<?= $cabfac->usuarioultmod->cellAttributes() ?>>
<span id="el_cabfac_usuarioultmod">
<span<?= $cabfac->usuarioultmod->viewAttributes() ?>>
<?= $cabfac->usuarioultmod->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabfac->fecultmod->Visible) { // fecultmod ?>
        <tr id="r_fecultmod"<?= $cabfac->fecultmod->rowAttributes() ?>>
            <td class="<?= $cabfac->TableLeftColumnClass ?>"><?= $cabfac->fecultmod->caption() ?></td>
            <td<?= $cabfac->fecultmod->cellAttributes() ?>>
<span id="el_cabfac_fecultmod">
<span<?= $cabfac->fecultmod->viewAttributes() ?>>
<?= $cabfac->fecultmod->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
