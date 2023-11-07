<?php

namespace PHPMaker2024\Subastas2024;

use BenSampo\Enum\Enum;

// RowTotal
final class RowTotal extends Enum
{
    const HEADER = 0;
    const FOOTER = 1;
    const SUM = 2;
    const AVG = 3;
    const MIN = 4;
    const MAX = 5;
    const CNT = 6;
}
