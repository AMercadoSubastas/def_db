<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$LotesPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { lotes: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->codrem->Visible) { // codrem ?>
    <?php if (!$Page->codrem->Sortable || !$Page->sortUrl($Page->codrem)) { ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><?= $Page->codrem->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codrem->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->codrem->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codrem->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codrem->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codrem->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
    <?php if (!$Page->codcli->Sortable || !$Page->sortUrl($Page->codcli)) { ?>
        <th class="<?= $Page->codcli->headerCellClass() ?>"><?= $Page->codcli->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codcli->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->codcli->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codcli->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codcli->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codcli->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->codrubro->Visible) { // codrubro ?>
    <?php if (!$Page->codrubro->Sortable || !$Page->sortUrl($Page->codrubro)) { ?>
        <th class="<?= $Page->codrubro->headerCellClass() ?>"><?= $Page->codrubro->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codrubro->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->codrubro->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codrubro->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codrubro->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codrubro->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <?php if (!$Page->estado->Sortable || !$Page->sortUrl($Page->estado)) { ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><?= $Page->estado->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->estado->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->estado->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->estado->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->estado->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
    <?php if (!$Page->moneda->Sortable || !$Page->sortUrl($Page->moneda)) { ?>
        <th class="<?= $Page->moneda->headerCellClass() ?>"><?= $Page->moneda->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->moneda->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->moneda->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->moneda->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->moneda->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->moneda->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->preciobase->Visible) { // preciobase ?>
    <?php if (!$Page->preciobase->Sortable || !$Page->sortUrl($Page->preciobase)) { ?>
        <th class="<?= $Page->preciobase->headerCellClass() ?>"><?= $Page->preciobase->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->preciobase->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->preciobase->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->preciobase->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->preciobase->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->preciobase->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->preciofinal->Visible) { // preciofinal ?>
    <?php if (!$Page->preciofinal->Sortable || !$Page->sortUrl($Page->preciofinal)) { ?>
        <th class="<?= $Page->preciofinal->headerCellClass() ?>"><?= $Page->preciofinal->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->preciofinal->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->preciofinal->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->preciofinal->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->preciofinal->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->preciofinal->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->comiscobr->Visible) { // comiscobr ?>
    <?php if (!$Page->comiscobr->Sortable || !$Page->sortUrl($Page->comiscobr)) { ?>
        <th class="<?= $Page->comiscobr->headerCellClass() ?>"><?= $Page->comiscobr->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->comiscobr->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->comiscobr->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->comiscobr->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->comiscobr->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->comiscobr->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->comispag->Visible) { // comispag ?>
    <?php if (!$Page->comispag->Sortable || !$Page->sortUrl($Page->comispag)) { ?>
        <th class="<?= $Page->comispag->headerCellClass() ?>"><?= $Page->comispag->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->comispag->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->comispag->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->comispag->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->comispag->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->comispag->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
    <?php if (!$Page->comprador->Sortable || !$Page->sortUrl($Page->comprador)) { ?>
        <th class="<?= $Page->comprador->headerCellClass() ?>"><?= $Page->comprador->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->comprador->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->comprador->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->comprador->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->comprador->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->comprador->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ivari->Visible) { // ivari ?>
    <?php if (!$Page->ivari->Sortable || !$Page->sortUrl($Page->ivari)) { ?>
        <th class="<?= $Page->ivari->headerCellClass() ?>"><?= $Page->ivari->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ivari->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->ivari->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ivari->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ivari->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ivari->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ivarni->Visible) { // ivarni ?>
    <?php if (!$Page->ivarni->Sortable || !$Page->sortUrl($Page->ivarni)) { ?>
        <th class="<?= $Page->ivarni->headerCellClass() ?>"><?= $Page->ivarni->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ivarni->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->ivarni->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ivarni->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ivarni->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ivarni->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->codimpadic->Visible) { // codimpadic ?>
    <?php if (!$Page->codimpadic->Sortable || !$Page->sortUrl($Page->codimpadic)) { ?>
        <th class="<?= $Page->codimpadic->headerCellClass() ?>"><?= $Page->codimpadic->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codimpadic->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->codimpadic->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codimpadic->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codimpadic->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codimpadic->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->impadic->Visible) { // impadic ?>
    <?php if (!$Page->impadic->Sortable || !$Page->sortUrl($Page->impadic)) { ?>
        <th class="<?= $Page->impadic->headerCellClass() ?>"><?= $Page->impadic->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->impadic->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->impadic->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->impadic->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->impadic->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->impadic->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->descor->Visible) { // descor ?>
    <?php if (!$Page->descor->Sortable || !$Page->sortUrl($Page->descor)) { ?>
        <th class="<?= $Page->descor->headerCellClass() ?>"><?= $Page->descor->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->descor->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->descor->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->descor->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->descor->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->descor->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->observ->Visible) { // observ ?>
    <?php if (!$Page->observ->Sortable || !$Page->sortUrl($Page->observ)) { ?>
        <th class="<?= $Page->observ->headerCellClass() ?>"><?= $Page->observ->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->observ->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->observ->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->observ->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->observ->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->observ->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <?php if (!$Page->usuario->Sortable || !$Page->sortUrl($Page->usuario)) { ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><?= $Page->usuario->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->usuario->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->usuario->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usuario->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usuario->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
    <?php if (!$Page->fecalta->Sortable || !$Page->sortUrl($Page->fecalta)) { ?>
        <th class="<?= $Page->fecalta->headerCellClass() ?>"><?= $Page->fecalta->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecalta->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->fecalta->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecalta->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecalta->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecalta->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
    <?php if (!$Page->secuencia->Sortable || !$Page->sortUrl($Page->secuencia)) { ?>
        <th class="<?= $Page->secuencia->headerCellClass() ?>"><?= $Page->secuencia->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->secuencia->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->secuencia->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->secuencia->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->secuencia->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->secuencia->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->codintlote->Visible) { // codintlote ?>
    <?php if (!$Page->codintlote->Sortable || !$Page->sortUrl($Page->codintlote)) { ?>
        <th class="<?= $Page->codintlote->headerCellClass() ?>"><?= $Page->codintlote->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codintlote->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->codintlote->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codintlote->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codintlote->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codintlote->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->codintnum->Visible) { // codintnum ?>
    <?php if (!$Page->codintnum->Sortable || !$Page->sortUrl($Page->codintnum)) { ?>
        <th class="<?= $Page->codintnum->headerCellClass() ?>"><?= $Page->codintnum->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codintnum->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->codintnum->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codintnum->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codintnum->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codintnum->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->codintsublote->Visible) { // codintsublote ?>
    <?php if (!$Page->codintsublote->Sortable || !$Page->sortUrl($Page->codintsublote)) { ?>
        <th class="<?= $Page->codintsublote->headerCellClass() ?>"><?= $Page->codintsublote->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->codintsublote->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->codintsublote->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codintsublote->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->codintsublote->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->codintsublote->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
    <?php if (!$Page->usuarioultmod->Sortable || !$Page->sortUrl($Page->usuarioultmod)) { ?>
        <th class="<?= $Page->usuarioultmod->headerCellClass() ?>"><?= $Page->usuarioultmod->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usuarioultmod->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->usuarioultmod->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->usuarioultmod->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usuarioultmod->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usuarioultmod->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
    <?php if (!$Page->fecultmod->Sortable || !$Page->sortUrl($Page->fecultmod)) { ?>
        <th class="<?= $Page->fecultmod->headerCellClass() ?>"><?= $Page->fecultmod->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecultmod->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->fecultmod->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecultmod->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecultmod->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecultmod->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dir_secuencia->Visible) { // dir_secuencia ?>
    <?php if (!$Page->dir_secuencia->Sortable || !$Page->sortUrl($Page->dir_secuencia)) { ?>
        <th class="<?= $Page->dir_secuencia->headerCellClass() ?>"><?= $Page->dir_secuencia->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dir_secuencia->headerCellClass() ?>"><div role="button" data-table="lotes" data-sort="<?= HtmlEncode($Page->dir_secuencia->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->dir_secuencia->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dir_secuencia->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dir_secuencia->getSortIcon() ?></span>
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
<?php if ($Page->codrem->Visible) { // codrem ?>
        <!-- codrem -->
        <td<?= $Page->codrem->cellAttributes() ?>>
<span<?= $Page->codrem->viewAttributes() ?>>
<?= $Page->codrem->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->codcli->Visible) { // codcli ?>
        <!-- codcli -->
        <td<?= $Page->codcli->cellAttributes() ?>>
<span<?= $Page->codcli->viewAttributes() ?>>
<?= $Page->codcli->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->codrubro->Visible) { // codrubro ?>
        <!-- codrubro -->
        <td<?= $Page->codrubro->cellAttributes() ?>>
<span<?= $Page->codrubro->viewAttributes() ?>>
<?= $Page->codrubro->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <!-- estado -->
        <td<?= $Page->estado->cellAttributes() ?>>
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
        <!-- moneda -->
        <td<?= $Page->moneda->cellAttributes() ?>>
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->preciobase->Visible) { // preciobase ?>
        <!-- preciobase -->
        <td<?= $Page->preciobase->cellAttributes() ?>>
<span<?= $Page->preciobase->viewAttributes() ?>>
<?= $Page->preciobase->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->preciofinal->Visible) { // preciofinal ?>
        <!-- preciofinal -->
        <td<?= $Page->preciofinal->cellAttributes() ?>>
<span<?= $Page->preciofinal->viewAttributes() ?>>
<?= $Page->preciofinal->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->comiscobr->Visible) { // comiscobr ?>
        <!-- comiscobr -->
        <td<?= $Page->comiscobr->cellAttributes() ?>>
<span<?= $Page->comiscobr->viewAttributes() ?>>
<?= $Page->comiscobr->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->comispag->Visible) { // comispag ?>
        <!-- comispag -->
        <td<?= $Page->comispag->cellAttributes() ?>>
<span<?= $Page->comispag->viewAttributes() ?>>
<?= $Page->comispag->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
        <!-- comprador -->
        <td<?= $Page->comprador->cellAttributes() ?>>
<span<?= $Page->comprador->viewAttributes() ?>>
<?= $Page->comprador->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ivari->Visible) { // ivari ?>
        <!-- ivari -->
        <td<?= $Page->ivari->cellAttributes() ?>>
<span<?= $Page->ivari->viewAttributes() ?>>
<?= $Page->ivari->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ivarni->Visible) { // ivarni ?>
        <!-- ivarni -->
        <td<?= $Page->ivarni->cellAttributes() ?>>
<span<?= $Page->ivarni->viewAttributes() ?>>
<?= $Page->ivarni->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->codimpadic->Visible) { // codimpadic ?>
        <!-- codimpadic -->
        <td<?= $Page->codimpadic->cellAttributes() ?>>
<span<?= $Page->codimpadic->viewAttributes() ?>>
<?= $Page->codimpadic->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->impadic->Visible) { // impadic ?>
        <!-- impadic -->
        <td<?= $Page->impadic->cellAttributes() ?>>
<span<?= $Page->impadic->viewAttributes() ?>>
<?= $Page->impadic->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->descor->Visible) { // descor ?>
        <!-- descor -->
        <td<?= $Page->descor->cellAttributes() ?>>
<span<?= $Page->descor->viewAttributes() ?>>
<?= $Page->descor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->observ->Visible) { // observ ?>
        <!-- observ -->
        <td<?= $Page->observ->cellAttributes() ?>>
<span<?= $Page->observ->viewAttributes() ?>>
<?= $Page->observ->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <!-- usuario -->
        <td<?= $Page->usuario->cellAttributes() ?>>
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecalta->Visible) { // fecalta ?>
        <!-- fecalta -->
        <td<?= $Page->fecalta->cellAttributes() ?>>
<span<?= $Page->fecalta->viewAttributes() ?>>
<?= $Page->fecalta->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->secuencia->Visible) { // secuencia ?>
        <!-- secuencia -->
        <td<?= $Page->secuencia->cellAttributes() ?>>
<span<?= $Page->secuencia->viewAttributes() ?>>
<?= $Page->secuencia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->codintlote->Visible) { // codintlote ?>
        <!-- codintlote -->
        <td<?= $Page->codintlote->cellAttributes() ?>>
<span<?= $Page->codintlote->viewAttributes() ?>>
<?= $Page->codintlote->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->codintnum->Visible) { // codintnum ?>
        <!-- codintnum -->
        <td<?= $Page->codintnum->cellAttributes() ?>>
<span<?= $Page->codintnum->viewAttributes() ?>>
<?= $Page->codintnum->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->codintsublote->Visible) { // codintsublote ?>
        <!-- codintsublote -->
        <td<?= $Page->codintsublote->cellAttributes() ?>>
<span<?= $Page->codintsublote->viewAttributes() ?>>
<?= $Page->codintsublote->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usuarioultmod->Visible) { // usuarioultmod ?>
        <!-- usuarioultmod -->
        <td<?= $Page->usuarioultmod->cellAttributes() ?>>
<span<?= $Page->usuarioultmod->viewAttributes() ?>>
<?= $Page->usuarioultmod->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecultmod->Visible) { // fecultmod ?>
        <!-- fecultmod -->
        <td<?= $Page->fecultmod->cellAttributes() ?>>
<span<?= $Page->fecultmod->viewAttributes() ?>>
<?= $Page->fecultmod->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dir_secuencia->Visible) { // dir_secuencia ?>
        <!-- dir_secuencia -->
        <td<?= $Page->dir_secuencia->cellAttributes() ?>>
<span<?= $Page->dir_secuencia->viewAttributes() ?>>
<?= $Page->dir_secuencia->getViewValue() ?></span>
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
