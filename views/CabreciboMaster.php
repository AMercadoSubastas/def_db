<?php

namespace PHPMaker2024\Subastas2024;

// Table
$cabrecibo = Container("cabrecibo");
$cabrecibo->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($cabrecibo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cabrecibomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cabrecibo->codnum->Visible) { // codnum ?>
        <tr id="r_codnum"<?= $cabrecibo->codnum->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->codnum->caption() ?></td>
            <td<?= $cabrecibo->codnum->cellAttributes() ?>>
<span id="el_cabrecibo_codnum">
<span<?= $cabrecibo->codnum->viewAttributes() ?>>
<?= $cabrecibo->codnum->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->tcomp->Visible) { // tcomp ?>
        <tr id="r_tcomp"<?= $cabrecibo->tcomp->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->tcomp->caption() ?></td>
            <td<?= $cabrecibo->tcomp->cellAttributes() ?>>
<span id="el_cabrecibo_tcomp">
<span<?= $cabrecibo->tcomp->viewAttributes() ?>>
<?= $cabrecibo->tcomp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->serie->Visible) { // serie ?>
        <tr id="r_serie"<?= $cabrecibo->serie->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->serie->caption() ?></td>
            <td<?= $cabrecibo->serie->cellAttributes() ?>>
<span id="el_cabrecibo_serie">
<span<?= $cabrecibo->serie->viewAttributes() ?>>
<?= $cabrecibo->serie->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->ncomp->Visible) { // ncomp ?>
        <tr id="r_ncomp"<?= $cabrecibo->ncomp->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->ncomp->caption() ?></td>
            <td<?= $cabrecibo->ncomp->cellAttributes() ?>>
<span id="el_cabrecibo_ncomp">
<span<?= $cabrecibo->ncomp->viewAttributes() ?>>
<?= $cabrecibo->ncomp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->cantcbtes->Visible) { // cantcbtes ?>
        <tr id="r_cantcbtes"<?= $cabrecibo->cantcbtes->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->cantcbtes->caption() ?></td>
            <td<?= $cabrecibo->cantcbtes->cellAttributes() ?>>
<span id="el_cabrecibo_cantcbtes">
<span<?= $cabrecibo->cantcbtes->viewAttributes() ?>>
<?= $cabrecibo->cantcbtes->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->fecha->Visible) { // fecha ?>
        <tr id="r_fecha"<?= $cabrecibo->fecha->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->fecha->caption() ?></td>
            <td<?= $cabrecibo->fecha->cellAttributes() ?>>
<span id="el_cabrecibo_fecha">
<span<?= $cabrecibo->fecha->viewAttributes() ?>>
<?= $cabrecibo->fecha->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->usuario->Visible) { // usuario ?>
        <tr id="r_usuario"<?= $cabrecibo->usuario->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->usuario->caption() ?></td>
            <td<?= $cabrecibo->usuario->cellAttributes() ?>>
<span id="el_cabrecibo_usuario">
<span<?= $cabrecibo->usuario->viewAttributes() ?>>
<?= $cabrecibo->usuario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->fechahora->Visible) { // fechahora ?>
        <tr id="r_fechahora"<?= $cabrecibo->fechahora->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->fechahora->caption() ?></td>
            <td<?= $cabrecibo->fechahora->cellAttributes() ?>>
<span id="el_cabrecibo_fechahora">
<span<?= $cabrecibo->fechahora->viewAttributes() ?>>
<?= $cabrecibo->fechahora->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->cliente->Visible) { // cliente ?>
        <tr id="r_cliente"<?= $cabrecibo->cliente->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->cliente->caption() ?></td>
            <td<?= $cabrecibo->cliente->cellAttributes() ?>>
<span id="el_cabrecibo_cliente">
<span<?= $cabrecibo->cliente->viewAttributes() ?>>
<?= $cabrecibo->cliente->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->imptot->Visible) { // imptot ?>
        <tr id="r_imptot"<?= $cabrecibo->imptot->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->imptot->caption() ?></td>
            <td<?= $cabrecibo->imptot->cellAttributes() ?>>
<span id="el_cabrecibo_imptot">
<span<?= $cabrecibo->imptot->viewAttributes() ?>>
<?= $cabrecibo->imptot->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->emitido->Visible) { // emitido ?>
        <tr id="r_emitido"<?= $cabrecibo->emitido->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->emitido->caption() ?></td>
            <td<?= $cabrecibo->emitido->cellAttributes() ?>>
<span id="el_cabrecibo_emitido">
<span<?= $cabrecibo->emitido->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($cabrecibo->emitido->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->usuarioultmod->Visible) { // usuarioultmod ?>
        <tr id="r_usuarioultmod"<?= $cabrecibo->usuarioultmod->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->usuarioultmod->caption() ?></td>
            <td<?= $cabrecibo->usuarioultmod->cellAttributes() ?>>
<span id="el_cabrecibo_usuarioultmod">
<span<?= $cabrecibo->usuarioultmod->viewAttributes() ?>>
<?= $cabrecibo->usuarioultmod->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cabrecibo->fecultmod->Visible) { // fecultmod ?>
        <tr id="r_fecultmod"<?= $cabrecibo->fecultmod->rowAttributes() ?>>
            <td class="<?= $cabrecibo->TableLeftColumnClass ?>"><?= $cabrecibo->fecultmod->caption() ?></td>
            <td<?= $cabrecibo->fecultmod->cellAttributes() ?>>
<span id="el_cabrecibo_fecultmod">
<span<?= $cabrecibo->fecultmod->viewAttributes() ?>>
<?= $cabrecibo->fecultmod->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
