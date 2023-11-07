<?php

namespace PHPMaker2024\Subastas2024;

use BenSampo\Enum\Enum;

// RowType
final class RowType extends Enum
{
    const HEADER = 0;
    const VIEW = 1;
    const ADD = 2;
    const EDIT = 3;
    const SEARCH = 4;
    const MASTER = 5;
    const AGGREGATEINIT = 6;
    const AGGREGATE = 7;
    const DETAIL = 8;
    const TOTAL = 9;
    const PREVIEW = 10;
    const PREVIEWFIELD = 11;
}
