<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetfacPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { detfac: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid <?= $Page->TableGridClass ?>"><!-- .card -->
<div class="card-header ew-grid-upper-panel ew-preview-upper-panel"><!-- .card-header -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-header -->
<div class="card-body ew-preview-middle-panel ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>"><!-- .card-body -->
<table class="<?= $Page->TableClass ?>"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->codnum->Visible) { // codnum ?>
    <?php if (!$Page->codnum->Sortable || !$Page->sortUrl($Page->codnum)) { ?>
        <th class="<?= $Page->codnum->headerCellClass() ?>"><?= $Page->codnum->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codnum->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->codnum->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codnum->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codnum->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codnum->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
    <?php if (!$Page->tcomp->Sortable || !$Page->sortUrl($Page->tcomp)) { ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><?= $Page->tcomp->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->tcomp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tcomp->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tcomp->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tcomp->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
    <?php if (!$Page->serie->Sortable || !$Page->sortUrl($Page->serie)) { ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><?= $Page->serie->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->serie->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->serie->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->serie->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->serie->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->serie->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
    <?php if (!$Page->ncomp->Sortable || !$Page->sortUrl($Page->ncomp)) { ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><?= $Page->ncomp->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->ncomp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ncomp->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ncomp->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ncomp->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
    <?php if (!$Page->nreng->Sortable || !$Page->sortUrl($Page->nreng)) { ?>
        <th class="<?= $Page->nreng->headerCellClass() ?>"><?= $Page->nreng->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nreng->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->nreng->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nreng->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nreng->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nreng->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
    <?php if (!$Page->codrem->Sortable || !$Page->sortUrl($Page->codrem)) { ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><?= $Page->codrem->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->codrem->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codrem->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codrem->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codrem->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->codlote->Visible) { // codlote ?>
    <?php if (!$Page->codlote->Sortable || !$Page->sortUrl($Page->codlote)) { ?>
        <th class="<?= $Page->codlote->headerCellClass() ?>"><?= $Page->codlote->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codlote->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->codlote->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codlote->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codlote->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codlote->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
    <?php if (!$Page->descrip->Sortable || !$Page->sortUrl($Page->descrip)) { ?>
        <th class="<?= $Page->descrip->headerCellClass() ?>"><?= $Page->descrip->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->descrip->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->descrip->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->descrip->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->descrip->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->descrip->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->neto->Visible) { // neto ?>
    <?php if (!$Page->neto->Sortable || !$Page->sortUrl($Page->neto)) { ?>
        <th class="<?= $Page->neto->headerCellClass() ?>"><?= $Page->neto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->neto->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->neto->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->neto->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->neto->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->neto->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bruto->Visible) { // bruto ?>
    <?php if (!$Page->bruto->Sortable || !$Page->sortUrl($Page->bruto)) { ?>
        <th class="<?= $Page->bruto->headerCellClass() ?>"><?= $Page->bruto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bruto->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->bruto->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->bruto->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->bruto->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->bruto->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->iva->Visible) { // iva ?>
    <?php if (!$Page->iva->Sortable || !$Page->sortUrl($Page->iva)) { ?>
        <th class="<?= $Page->iva->headerCellClass() ?>"><?= $Page->iva->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->iva->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->iva->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->iva->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->iva->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->iva->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->imp->Visible) { // imp ?>
    <?php if (!$Page->imp->Sortable || !$Page->sortUrl($Page->imp)) { ?>
        <th class="<?= $Page->imp->headerCellClass() ?>"><?= $Page->imp->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->imp->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->imp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->imp->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->imp->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->imp->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->comcob->Visible) { // comcob ?>
    <?php if (!$Page->comcob->Sortable || !$Page->sortUrl($Page->comcob)) { ?>
        <th class="<?= $Page->comcob->headerCellClass() ?>"><?= $Page->comcob->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->comcob->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->comcob->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->comcob->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->comcob->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->comcob->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->compag->Visible) { // compag ?>
    <?php if (!$Page->compag->Sortable || !$Page->sortUrl($Page->compag)) { ?>
        <th class="<?= $Page->compag->headerCellClass() ?>"><?= $Page->compag->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->compag->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->compag->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->compag->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->compag->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->compag->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <?php if (!$Page->fechahora->Sortable || !$Page->sortUrl($Page->fechahora)) { ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><?= $Page->fechahora->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->fechahora->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fechahora->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fechahora->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fechahora->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <?php if (!$Page->usuario->Sortable || !$Page->sortUrl($Page->usuario)) { ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><?= $Page->usuario->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->usuario->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->usuario->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usuario->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usuario->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
    <?php if (!$Page->porciva->Sortable || !$Page->sortUrl($Page->porciva)) { ?>
        <th class="<?= $Page->porciva->headerCellClass() ?>"><?= $Page->porciva->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->porciva->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->porciva->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->porciva->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->porciva->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->porciva->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
    <?php if (!$Page->tieneresol->Sortable || !$Page->sortUrl($Page->tieneresol)) { ?>
        <th class="<?= $Page->tieneresol->headerCellClass() ?>"><?= $Page->tieneresol->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tieneresol->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->tieneresol->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tieneresol->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tieneresol->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tieneresol->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->concafac->Visible) { // concafac ?>
    <?php if (!$Page->concafac->Sortable || !$Page->sortUrl($Page->concafac)) { ?>
        <th class="<?= $Page->concafac->headerCellClass() ?>"><?= $Page->concafac->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->concafac->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->concafac->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->concafac->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->concafac->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->concafac->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tcomsal->Visible) { // tcomsal ?>
    <?php if (!$Page->tcomsal->Sortable || !$Page->sortUrl($Page->tcomsal)) { ?>
        <th class="<?= $Page->tcomsal->headerCellClass() ?>"><?= $Page->tcomsal->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tcomsal->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->tcomsal->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tcomsal->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tcomsal->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tcomsal->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
    <?php if (!$Page->seriesal->Sortable || !$Page->sortUrl($Page->seriesal)) { ?>
        <th class="<?= $Page->seriesal->headerCellClass() ?>"><?= $Page->seriesal->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->seriesal->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->seriesal->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->seriesal->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->seriesal->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->seriesal->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
    <?php if (!$Page->ncompsal->Sortable || !$Page->sortUrl($Page->ncompsal)) { ?>
        <th class="<?= $Page->ncompsal->headerCellClass() ?>"><?= $Page->ncompsal->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ncompsal->headerCellClass() ?>"><div role="button" data-table="detfac" data-sort="<?= HtmlEncode($Page->ncompsal->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ncompsal->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ncompsal->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ncompsal->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecordCount = 0;
$Page->RowCount = 0;
while ($Page->fetch()) {
    // Init row class and style
    $Page->RecordCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->CurrentRow);

    // Render row
    $Page->RowType = RowType::PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Set up row attributes
    $Page->RowAttrs->merge([
        "data-rowindex" => $Page->RowCount,
        "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",

        // Add row attributes for expandable row
        "data-widget" => "expandable-table",
        "aria-expanded" => "false",
    ]);

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->codnum->Visible) { // codnum ?>
        <!-- codnum -->
        <td<?= $Page->codnum->cellAttributes() ?>>
<span<?= $Page->codnum->viewAttributes() ?>>
<?= $Page->codnum->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tcomp->Visible) { // tcomp ?>
        <!-- tcomp -->
        <td<?= $Page->tcomp->cellAttributes() ?>>
<span<?= $Page->tcomp->viewAttributes() ?>>
<?= $Page->tcomp->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->serie->Visible) { // serie ?>
        <!-- serie -->
        <td<?= $Page->serie->cellAttributes() ?>>
<span<?= $Page->serie->viewAttributes() ?>>
<?= $Page->serie->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ncomp->Visible) { // ncomp ?>
        <!-- ncomp -->
        <td<?= $Page->ncomp->cellAttributes() ?>>
<span<?= $Page->ncomp->viewAttributes() ?>>
<?= $Page->ncomp->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nreng->Visible) { // nreng ?>
        <!-- nreng -->
        <td<?= $Page->nreng->cellAttributes() ?>>
<span<?= $Page->nreng->viewAttributes() ?>>
<?= $Page->nreng->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->codrem->Visible) { // codrem ?>
        <!-- codrem -->
        <td<?= $Page->codrem->cellAttributes() ?>>
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->codlote->Visible) { // codlote ?>
        <!-- codlote -->
        <td<?= $Page->codlote->cellAttributes() ?>>
<span<?= $Page->codlote->viewAttributes() ?>>
<?= $Page->codlote->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->descrip->Visible) { // descrip ?>
        <!-- descrip -->
        <td<?= $Page->descrip->cellAttributes() ?>>
<span<?= $Page->descrip->viewAttributes() ?>>
<?= $Page->descrip->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->neto->Visible) { // neto ?>
        <!-- neto -->
        <td<?= $Page->neto->cellAttributes() ?>>
<span<?= $Page->neto->viewAttributes() ?>>
<?= $Page->neto->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bruto->Visible) { // bruto ?>
        <!-- bruto -->
        <td<?= $Page->bruto->cellAttributes() ?>>
<span<?= $Page->bruto->viewAttributes() ?>>
<?= $Page->bruto->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->iva->Visible) { // iva ?>
        <!-- iva -->
        <td<?= $Page->iva->cellAttributes() ?>>
<span<?= $Page->iva->viewAttributes() ?>>
<?= $Page->iva->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->imp->Visible) { // imp ?>
        <!-- imp -->
        <td<?= $Page->imp->cellAttributes() ?>>
<span<?= $Page->imp->viewAttributes() ?>>
<?= $Page->imp->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->comcob->Visible) { // comcob ?>
        <!-- comcob -->
        <td<?= $Page->comcob->cellAttributes() ?>>
<span<?= $Page->comcob->viewAttributes() ?>>
<?= $Page->comcob->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->compag->Visible) { // compag ?>
        <!-- compag -->
        <td<?= $Page->compag->cellAttributes() ?>>
<span<?= $Page->compag->viewAttributes() ?>>
<?= $Page->compag->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <!-- fechahora -->
        <td<?= $Page->fechahora->cellAttributes() ?>>
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <!-- usuario -->
        <td<?= $Page->usuario->cellAttributes() ?>>
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->porciva->Visible) { // porciva ?>
        <!-- porciva -->
        <td<?= $Page->porciva->cellAttributes() ?>>
<span<?= $Page->porciva->viewAttributes() ?>>
<?= $Page->porciva->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tieneresol->Visible) { // tieneresol ?>
        <!-- tieneresol -->
        <td<?= $Page->tieneresol->cellAttributes() ?>>
<span<?= $Page->tieneresol->viewAttributes() ?>>
<?= $Page->tieneresol->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->concafac->Visible) { // concafac ?>
        <!-- concafac -->
        <td<?= $Page->concafac->cellAttributes() ?>>
<span<?= $Page->concafac->viewAttributes() ?>>
<?= $Page->concafac->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tcomsal->Visible) { // tcomsal ?>
        <!-- tcomsal -->
        <td<?= $Page->tcomsal->cellAttributes() ?>>
<span<?= $Page->tcomsal->viewAttributes() ?>>
<?= $Page->tcomsal->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->seriesal->Visible) { // seriesal ?>
        <!-- seriesal -->
        <td<?= $Page->seriesal->cellAttributes() ?>>
<span<?= $Page->seriesal->viewAttributes() ?>>
<?= $Page->seriesal->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ncompsal->Visible) { // ncompsal ?>
        <!-- ncompsal -->
        <td<?= $Page->ncompsal->cellAttributes() ?>>
<span<?= $Page->ncompsal->viewAttributes() ?>>
<?= $Page->ncompsal->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.card-body -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-footer -->
</div><!-- /.card -->
<?php } else { // No record ?>
<div class="card border-0"><!-- .card -->
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card -->
<?php } ?>
<?php
foreach ($Page->DetailCounts as $detailTblVar => $detailCount) {
?>
<div class="ew-detail-count d-none" data-table="<?= $detailTblVar ?>" data-count="<?= $detailCount ?>"><?= FormatInteger($detailCount) ?></div>
<?php
}
?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
$Page->Recordset?->free();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
