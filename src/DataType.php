<?php

namespace PHPMaker2024\Subastas2024;

use BenSampo\Enum\Enum;

// DataType
final class DataType extends Enum
{
    const NUMBER = 1;
    const DATE = 2;
    const STRING = 3;
    const BOOLEAN = 4;
    const MEMO = 5;
    const BLOB = 6;
    const TIME = 7;
    const GUID = 8;
    const XML = 9;
    const BIT = 10;
    const OTHER = 11;
}
