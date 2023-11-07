<?php

namespace PHPMaker2024\Subastas2024;

use BenSampo\Enum\Enum;

// Allow
final class Allow extends Enum
{
    const ADD = 1;
    const DELETE = 2;
    const EDIT = 4;
    const LIST = 8;
    const ADMIN = 16;
    const VIEW = 32;
    const SEARCH = 64;
    const IMPORT = 128;
    const LOOKUP = 256;
    const PUSH = 512;
    const EXPORT = 1024;
    const ALL = 2047;
}
