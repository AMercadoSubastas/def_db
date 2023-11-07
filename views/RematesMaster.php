<?php

namespace PHPMaker2024\Subastas2024;

// Table
$remates = Container("remates");
$remates->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($remates->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_rematesmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($remates->codnum->Visible) { // codnum ?>
        <tr id="r_codnum"<?= $remates->codnum->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->codnum->caption() ?></td>
            <td<?= $remates->codnum->cellAttributes() ?>>
<span id="el_remates_codnum">
<span<?= $remates->codnum->viewAttributes() ?>>
<?= $remates->codnum->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->tcomp->Visible) { // tcomp ?>
        <tr id="r_tcomp"<?= $remates->tcomp->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->tcomp->caption() ?></td>
            <td<?= $remates->tcomp->cellAttributes() ?>>
<span id="el_remates_tcomp">
<span<?= $remates->tcomp->viewAttributes() ?>>
<?= $remates->tcomp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->serie->Visible) { // serie ?>
        <tr id="r_serie"<?= $remates->serie->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->serie->caption() ?></td>
            <td<?= $remates->serie->cellAttributes() ?>>
<span id="el_remates_serie">
<span<?= $remates->serie->viewAttributes() ?>>
<?= $remates->serie->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->ncomp->Visible) { // ncomp ?>
        <tr id="r_ncomp"<?= $remates->ncomp->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->ncomp->caption() ?></td>
            <td<?= $remates->ncomp->cellAttributes() ?>>
<span id="el_remates_ncomp">
<span<?= $remates->ncomp->viewAttributes() ?>>
<?= $remates->ncomp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->codcli->Visible) { // codcli ?>
        <tr id="r_codcli"<?= $remates->codcli->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->codcli->caption() ?></td>
            <td<?= $remates->codcli->cellAttributes() ?>>
<span id="el_remates_codcli">
<span<?= $remates->codcli->viewAttributes() ?>>
<?= $remates->codcli->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->direccion->Visible) { // direccion ?>
        <tr id="r_direccion"<?= $remates->direccion->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->direccion->caption() ?></td>
            <td<?= $remates->direccion->cellAttributes() ?>>
<span id="el_remates_direccion">
<span<?= $remates->direccion->viewAttributes() ?>>
<?= $remates->direccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->codpais->Visible) { // codpais ?>
        <tr id="r_codpais"<?= $remates->codpais->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->codpais->caption() ?></td>
            <td<?= $remates->codpais->cellAttributes() ?>>
<span id="el_remates_codpais">
<span<?= $remates->codpais->viewAttributes() ?>>
<?= $remates->codpais->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->codprov->Visible) { // codprov ?>
        <tr id="r_codprov"<?= $remates->codprov->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->codprov->caption() ?></td>
            <td<?= $remates->codprov->cellAttributes() ?>>
<span id="el_remates_codprov">
<span<?= $remates->codprov->viewAttributes() ?>>
<?= $remates->codprov->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->codloc->Visible) { // codloc ?>
        <tr id="r_codloc"<?= $remates->codloc->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->codloc->caption() ?></td>
            <td<?= $remates->codloc->cellAttributes() ?>>
<span id="el_remates_codloc">
<span<?= $remates->codloc->viewAttributes() ?>>
<?= $remates->codloc->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->fecest->Visible) { // fecest ?>
        <tr id="r_fecest"<?= $remates->fecest->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->fecest->caption() ?></td>
            <td<?= $remates->fecest->cellAttributes() ?>>
<span id="el_remates_fecest">
<span<?= $remates->fecest->viewAttributes() ?>>
<?= $remates->fecest->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->fecreal->Visible) { // fecreal ?>
        <tr id="r_fecreal"<?= $remates->fecreal->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->fecreal->caption() ?></td>
            <td<?= $remates->fecreal->cellAttributes() ?>>
<span id="el_remates_fecreal">
<span<?= $remates->fecreal->viewAttributes() ?>>
<?= $remates->fecreal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->imptot->Visible) { // imptot ?>
        <tr id="r_imptot"<?= $remates->imptot->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->imptot->caption() ?></td>
            <td<?= $remates->imptot->cellAttributes() ?>>
<span id="el_remates_imptot">
<span<?= $remates->imptot->viewAttributes() ?>>
<?= $remates->imptot->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->impbase->Visible) { // impbase ?>
        <tr id="r_impbase"<?= $remates->impbase->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->impbase->caption() ?></td>
            <td<?= $remates->impbase->cellAttributes() ?>>
<span id="el_remates_impbase">
<span<?= $remates->impbase->viewAttributes() ?>>
<?= $remates->impbase->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->estado->Visible) { // estado ?>
        <tr id="r_estado"<?= $remates->estado->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->estado->caption() ?></td>
            <td<?= $remates->estado->cellAttributes() ?>>
<span id="el_remates_estado">
<span<?= $remates->estado->viewAttributes() ?>>
<?= $remates->estado->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->cantlotes->Visible) { // cantlotes ?>
        <tr id="r_cantlotes"<?= $remates->cantlotes->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->cantlotes->caption() ?></td>
            <td<?= $remates->cantlotes->cellAttributes() ?>>
<span id="el_remates_cantlotes">
<span<?= $remates->cantlotes->viewAttributes() ?>>
<?= $remates->cantlotes->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->horaest->Visible) { // horaest ?>
        <tr id="r_horaest"<?= $remates->horaest->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->horaest->caption() ?></td>
            <td<?= $remates->horaest->cellAttributes() ?>>
<span id="el_remates_horaest">
<span<?= $remates->horaest->viewAttributes() ?>>
<?= $remates->horaest->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->horareal->Visible) { // horareal ?>
        <tr id="r_horareal"<?= $remates->horareal->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->horareal->caption() ?></td>
            <td<?= $remates->horareal->cellAttributes() ?>>
<span id="el_remates_horareal">
<span<?= $remates->horareal->viewAttributes() ?>>
<?= $remates->horareal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->usuario->Visible) { // usuario ?>
        <tr id="r_usuario"<?= $remates->usuario->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->usuario->caption() ?></td>
            <td<?= $remates->usuario->cellAttributes() ?>>
<span id="el_remates_usuario">
<span<?= $remates->usuario->viewAttributes() ?>>
<?= $remates->usuario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->fecalta->Visible) { // fecalta ?>
        <tr id="r_fecalta"<?= $remates->fecalta->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->fecalta->caption() ?></td>
            <td<?= $remates->fecalta->cellAttributes() ?>>
<span id="el_remates_fecalta">
<span<?= $remates->fecalta->viewAttributes() ?>>
<?= $remates->fecalta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->tipoind->Visible) { // tipoind ?>
        <tr id="r_tipoind"<?= $remates->tipoind->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->tipoind->caption() ?></td>
            <td<?= $remates->tipoind->cellAttributes() ?>>
<span id="el_remates_tipoind">
<span<?= $remates->tipoind->viewAttributes() ?>>
<?= $remates->tipoind->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->sello->Visible) { // sello ?>
        <tr id="r_sello"<?= $remates->sello->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->sello->caption() ?></td>
            <td<?= $remates->sello->cellAttributes() ?>>
<span id="el_remates_sello">
<span<?= $remates->sello->viewAttributes() ?>>
<?= $remates->sello->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->plazoSAP->Visible) { // plazoSAP ?>
        <tr id="r_plazoSAP"<?= $remates->plazoSAP->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->plazoSAP->caption() ?></td>
            <td<?= $remates->plazoSAP->cellAttributes() ?>>
<span id="el_remates_plazoSAP">
<span<?= $remates->plazoSAP->viewAttributes() ?>>
<?= $remates->plazoSAP->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->usuarioultmod->Visible) { // usuarioultmod ?>
        <tr id="r_usuarioultmod"<?= $remates->usuarioultmod->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->usuarioultmod->caption() ?></td>
            <td<?= $remates->usuarioultmod->cellAttributes() ?>>
<span id="el_remates_usuarioultmod">
<span<?= $remates->usuarioultmod->viewAttributes() ?>>
<?= $remates->usuarioultmod->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->fecultmod->Visible) { // fecultmod ?>
        <tr id="r_fecultmod"<?= $remates->fecultmod->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->fecultmod->caption() ?></td>
            <td<?= $remates->fecultmod->cellAttributes() ?>>
<span id="el_remates_fecultmod">
<span<?= $remates->fecultmod->viewAttributes() ?>>
<?= $remates->fecultmod->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->servicios->Visible) { // servicios ?>
        <tr id="r_servicios"<?= $remates->servicios->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->servicios->caption() ?></td>
            <td<?= $remates->servicios->cellAttributes() ?>>
<span id="el_remates_servicios">
<span<?= $remates->servicios->viewAttributes() ?>>
<?= $remates->servicios->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->gastos->Visible) { // gastos ?>
        <tr id="r_gastos"<?= $remates->gastos->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->gastos->caption() ?></td>
            <td<?= $remates->gastos->cellAttributes() ?>>
<span id="el_remates_gastos">
<span<?= $remates->gastos->viewAttributes() ?>>
<?= $remates->gastos->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($remates->tasa->Visible) { // tasa ?>
        <tr id="r_tasa"<?= $remates->tasa->rowAttributes() ?>>
            <td class="<?= $remates->TableLeftColumnClass ?>"><?= $remates->tasa->caption() ?></td>
            <td<?= $remates->tasa->cellAttributes() ?>>
<span id="el_remates_tasa">
<span<?= $remates->tasa->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($remates->tasa->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
