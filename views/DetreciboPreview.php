<?php

namespace PHPMaker2024\Subastas2024;

// Page object
$DetreciboPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { detrecibo: <?= JsonEncode($Page->toClientVar()) ?> } });
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
        <th class="<?= $Page->codnum->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->codnum->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->codnum->getNextSort() ?>">
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
        <th class="<?= $Page->tcomp->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->tcomp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tcomp->getNextSort() ?>">
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
        <th class="<?= $Page->serie->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->serie->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->serie->getNextSort() ?>">
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
        <th class="<?= $Page->ncomp->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->ncomp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ncomp->getNextSort() ?>">
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
        <th class="<?= $Page->nreng->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->nreng->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nreng->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nreng->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nreng->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
    <?php if (!$Page->tcomprel->Sortable || !$Page->sortUrl($Page->tcomprel)) { ?>
        <th class="<?= $Page->tcomprel->headerCellClass() ?>"><?= $Page->tcomprel->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tcomprel->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->tcomprel->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tcomprel->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tcomprel->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tcomprel->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
    <?php if (!$Page->serierel->Sortable || !$Page->sortUrl($Page->serierel)) { ?>
        <th class="<?= $Page->serierel->headerCellClass() ?>"><?= $Page->serierel->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->serierel->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->serierel->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->serierel->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->serierel->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->serierel->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
    <?php if (!$Page->ncomprel->Sortable || !$Page->sortUrl($Page->ncomprel)) { ?>
        <th class="<?= $Page->ncomprel->headerCellClass() ?>"><?= $Page->ncomprel->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ncomprel->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->ncomprel->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ncomprel->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ncomprel->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ncomprel->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->netocbterel->Visible) { // netocbterel ?>
    <?php if (!$Page->netocbterel->Sortable || !$Page->sortUrl($Page->netocbterel)) { ?>
        <th class="<?= $Page->netocbterel->headerCellClass() ?>"><?= $Page->netocbterel->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->netocbterel->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->netocbterel->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->netocbterel->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->netocbterel->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->netocbterel->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <?php if (!$Page->usuario->Sortable || !$Page->sortUrl($Page->usuario)) { ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><?= $Page->usuario->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usuario->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->usuario->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->usuario->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usuario->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usuario->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
    <?php if (!$Page->fechahora->Sortable || !$Page->sortUrl($Page->fechahora)) { ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><?= $Page->fechahora->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fechahora->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->fechahora->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fechahora->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fechahora->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fechahora->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
    <?php if (!$Page->nrodoc->Sortable || !$Page->sortUrl($Page->nrodoc)) { ?>
        <th class="<?= $Page->nrodoc->headerCellClass() ?>"><?= $Page->nrodoc->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nrodoc->headerCellClass() ?>"><div role="button" data-table="detrecibo" data-sort="<?= HtmlEncode($Page->nrodoc->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nrodoc->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nrodoc->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nrodoc->getSortIcon() ?></span>
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
<?php if ($Page->tcomprel->Visible) { // tcomprel ?>
        <!-- tcomprel -->
        <td<?= $Page->tcomprel->cellAttributes() ?>>
<span<?= $Page->tcomprel->viewAttributes() ?>>
<?= $Page->tcomprel->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->serierel->Visible) { // serierel ?>
        <!-- serierel -->
        <td<?= $Page->serierel->cellAttributes() ?>>
<span<?= $Page->serierel->viewAttributes() ?>>
<?= $Page->serierel->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ncomprel->Visible) { // ncomprel ?>
        <!-- ncomprel -->
        <td<?= $Page->ncomprel->cellAttributes() ?>>
<span<?= $Page->ncomprel->viewAttributes() ?>>
<?= $Page->ncomprel->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->netocbterel->Visible) { // netocbterel ?>
        <!-- netocbterel -->
        <td<?= $Page->netocbterel->cellAttributes() ?>>
<span<?= $Page->netocbterel->viewAttributes() ?>>
<?= $Page->netocbterel->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
        <!-- usuario -->
        <td<?= $Page->usuario->cellAttributes() ?>>
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fechahora->Visible) { // fechahora ?>
        <!-- fechahora -->
        <td<?= $Page->fechahora->cellAttributes() ?>>
<span<?= $Page->fechahora->viewAttributes() ?>>
<?= $Page->fechahora->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nrodoc->Visible) { // nrodoc ?>
        <!-- nrodoc -->
        <td<?= $Page->nrodoc->cellAttributes() ?>>
<span<?= $Page->nrodoc->viewAttributes() ?>>
<?= $Page->nrodoc->getViewValue() ?></span>
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
