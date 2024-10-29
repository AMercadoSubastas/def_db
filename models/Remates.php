<?php

namespace PHPMaker2024\Subastas2024;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

/**
 * Table class for remates
 */
class Remates extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = false;
    public $ModalView = false;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $ncomp;
    public $codnum;
    public $tcomp;
    public $serie;
    public $codcli;
    public $direccion;
    public $codpais;
    public $codprov;
    public $codloc;
    public $fecest;
    public $fecreal;
    public $imptot;
    public $impbase;
    public $estado;
    public $cantlotes;
    public $horaest;
    public $horareal;
    public $usuario;
    public $fecalta;
    public $observacion;
    public $tipoind;
    public $sello;
    public $plazoSAP;
    public $usuarioultmod;
    public $fecultmod;
    public $servicios;
    public $gastos;
    public $tasa;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "remates";
        $this->TableName = 'remates';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "remates";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UseColumnVisibility = true;
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);
        $this->BasicSearch->TypeDefault = "=";

        // ncomp
        $this->ncomp = new DbField(
            $this, // Table
            'x_ncomp', // Variable name
            'ncomp', // Name
            '`ncomp`', // Expression
            '`ncomp`', // Basic search expression
            3, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ncomp`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ncomp->InputTextType = "text";
        $this->ncomp->Raw = true;
        $this->ncomp->IsForeignKey = true; // Foreign key field
        $this->ncomp->Nullable = false; // NOT NULL field
        $this->ncomp->Required = true; // Required field
        $this->ncomp->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ncomp->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['ncomp'] = &$this->ncomp;

        // codnum
        $this->codnum = new DbField(
            $this, // Table
            'x_codnum', // Variable name
            'codnum', // Name
            '`codnum`', // Expression
            '`codnum`', // Basic search expression
            3, // Type
            9, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codnum`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->codnum->InputTextType = "text";
        $this->codnum->Raw = true;
        $this->codnum->IsAutoIncrement = true; // Autoincrement field
        $this->codnum->IsPrimaryKey = true; // Primary key field
        $this->codnum->Nullable = false; // NOT NULL field
        $this->codnum->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codnum->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codnum'] = &$this->codnum;

        // tcomp
        $this->tcomp = new DbField(
            $this, // Table
            'x_tcomp', // Variable name
            'tcomp', // Name
            '`tcomp`', // Expression
            '`tcomp`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tcomp`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tcomp->addMethod("getSelectFilter", fn() => "`codnum` = 4");
        $this->tcomp->InputTextType = "text";
        $this->tcomp->Raw = true;
        $this->tcomp->Nullable = false; // NOT NULL field
        $this->tcomp->Required = true; // Required field
        $this->tcomp->setSelectMultiple(false); // Select one
        $this->tcomp->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tcomp->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->tcomp->Lookup = new Lookup($this->tcomp, 'tipcomp', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->tcomp->Lookup = new Lookup($this->tcomp, 'tipcomp', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->tcomp->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tcomp->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tcomp'] = &$this->tcomp;

        // serie
        $this->serie = new DbField(
            $this, // Table
            'x_serie', // Variable name
            'serie', // Name
            '`serie`', // Expression
            '`serie`', // Basic search expression
            3, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`serie`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->serie->addMethod("getSelectFilter", fn() => "`codnum` = 4");
        $this->serie->InputTextType = "text";
        $this->serie->Raw = true;
        $this->serie->Nullable = false; // NOT NULL field
        $this->serie->Required = true; // Required field
        $this->serie->setSelectMultiple(false); // Select one
        $this->serie->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->serie->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->serie->Lookup = new Lookup($this->serie, 'series', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->serie->Lookup = new Lookup($this->serie, 'series', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->serie->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->serie->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['serie'] = &$this->serie;

        // codcli
        $this->codcli = new DbField(
            $this, // Table
            'x_codcli', // Variable name
            'codcli', // Name
            '`codcli`', // Expression
            '`codcli`', // Basic search expression
            3, // Type
            6, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codcli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codcli->addMethod("getSelectFilter", fn() => "`tipoent` = 1");
        $this->codcli->addMethod("getDefault", fn() => 940);
        $this->codcli->InputTextType = "text";
        $this->codcli->Raw = true;
        $this->codcli->Nullable = false; // NOT NULL field
        $this->codcli->Required = true; // Required field
        $this->codcli->setSelectMultiple(false); // Select one
        $this->codcli->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codcli->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codcli->Lookup = new Lookup($this->codcli, 'entidades', false, 'codnum', ["razsoc","","",""], '', '', [], [], [], [], [], [], false, '`razsoc` ASC', '', "`razsoc`");
                break;
            default:
                $this->codcli->Lookup = new Lookup($this->codcli, 'entidades', false, 'codnum', ["razsoc","","",""], '', '', [], [], [], [], [], [], false, '`razsoc` ASC', '', "`razsoc`");
                break;
        }
        $this->codcli->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codcli->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codcli'] = &$this->codcli;

        // direccion
        $this->direccion = new DbField(
            $this, // Table
            'x_direccion', // Variable name
            'direccion', // Name
            '`direccion`', // Expression
            '`direccion`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`direccion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->direccion->InputTextType = "text";
        $this->direccion->Nullable = false; // NOT NULL field
        $this->direccion->Required = true; // Required field
        $this->direccion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['direccion'] = &$this->direccion;

        // codpais
        $this->codpais = new DbField(
            $this, // Table
            'x_codpais', // Variable name
            'codpais', // Name
            '`codpais`', // Expression
            '`codpais`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            'EV__codpais', // Virtual expression
            true, // Is virtual
            true, // Force selection
            true, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codpais->addMethod("getDefault", fn() => 1);
        $this->codpais->InputTextType = "text";
        $this->codpais->Raw = true;
        $this->codpais->setSelectMultiple(false); // Select one
        $this->codpais->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codpais->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codpais->Lookup = new Lookup($this->codpais, 'paises', false, 'codnum', ["descripcion","","",""], '', '', [], ["x_codprov"], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->codpais->Lookup = new Lookup($this->codpais, 'paises', false, 'codnum', ["descripcion","","",""], '', '', [], ["x_codprov"], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->codpais->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codpais->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['codpais'] = &$this->codpais;

        // codprov
        $this->codprov = new DbField(
            $this, // Table
            'x_codprov', // Variable name
            'codprov', // Name
            '`codprov`', // Expression
            '`codprov`', // Basic search expression
            3, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            'EV__codprov', // Virtual expression
            true, // Is virtual
            true, // Force selection
            true, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codprov->InputTextType = "text";
        $this->codprov->Raw = true;
        $this->codprov->Nullable = false; // NOT NULL field
        $this->codprov->Required = true; // Required field
        $this->codprov->setSelectMultiple(false); // Select one
        $this->codprov->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codprov->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codprov->Lookup = new Lookup($this->codprov, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', ["x_codpais"], [], ["codpais"], ["x_codpais"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->codprov->Lookup = new Lookup($this->codprov, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', ["x_codpais"], [], ["codpais"], ["x_codpais"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->codprov->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codprov->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['codprov'] = &$this->codprov;

        // codloc
        $this->codloc = new DbField(
            $this, // Table
            'x_codloc', // Variable name
            'codloc', // Name
            '`codloc`', // Expression
            '`codloc`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            'EV__codloc', // Virtual expression
            true, // Is virtual
            true, // Force selection
            true, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codloc->InputTextType = "text";
        $this->codloc->Raw = true;
        $this->codloc->setSelectMultiple(false); // Select one
        $this->codloc->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codloc->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codloc->Lookup = new Lookup($this->codloc, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->codloc->Lookup = new Lookup($this->codloc, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->codloc->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codloc->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['codloc'] = &$this->codloc;

        // fecest
        $this->fecest = new DbField(
            $this, // Table
            'x_fecest', // Variable name
            'fecest', // Name
            '`fecest`', // Expression
            CastDateFieldForLike("`fecest`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecest`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecest->InputTextType = "text";
        $this->fecest->Raw = true;
        $this->fecest->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecest->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecest'] = &$this->fecest;

        // fecreal
        $this->fecreal = new DbField(
            $this, // Table
            'x_fecreal', // Variable name
            'fecreal', // Name
            '`fecreal`', // Expression
            CastDateFieldForLike("`fecreal`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecreal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecreal->InputTextType = "text";
        $this->fecreal->Raw = true;
        $this->fecreal->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecreal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecreal'] = &$this->fecreal;

        // imptot
        $this->imptot = new DbField(
            $this, // Table
            'x_imptot', // Variable name
            'imptot', // Name
            '`imptot`', // Expression
            '`imptot`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`imptot`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->imptot->InputTextType = "text";
        $this->imptot->Raw = true;
        $this->imptot->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->imptot->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['imptot'] = &$this->imptot;

        // impbase
        $this->impbase = new DbField(
            $this, // Table
            'x_impbase', // Variable name
            'impbase', // Name
            '`impbase`', // Expression
            '`impbase`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`impbase`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->impbase->InputTextType = "text";
        $this->impbase->Raw = true;
        $this->impbase->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->impbase->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['impbase'] = &$this->impbase;

        // estado
        $this->estado = new DbField(
            $this, // Table
            'x_estado', // Variable name
            'estado', // Name
            '`estado`', // Expression
            '`estado`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->estado->addMethod("getDefault", fn() => 0);
        $this->estado->InputTextType = "text";
        $this->estado->Raw = true;
        $this->estado->Nullable = false; // NOT NULL field
        $this->estado->Required = true; // Required field
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->estado->Lookup = new Lookup($this->estado, 'remates', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->estado->Lookup = new Lookup($this->estado, 'remates', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->estado->OptionCount = 2;
        $this->estado->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->estado->SearchOperators = ["=", "<>"];
        $this->Fields['estado'] = &$this->estado;

        // cantlotes
        $this->cantlotes = new DbField(
            $this, // Table
            'x_cantlotes', // Variable name
            'cantlotes', // Name
            '`cantlotes`', // Expression
            '`cantlotes`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cantlotes`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->cantlotes->InputTextType = "text";
        $this->cantlotes->Raw = true;
        $this->cantlotes->Nullable = false; // NOT NULL field
        $this->cantlotes->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cantlotes->SearchOperators = ["=", "<>"];
        $this->Fields['cantlotes'] = &$this->cantlotes;

        // horaest
        $this->horaest = new DbField(
            $this, // Table
            'x_horaest', // Variable name
            'horaest', // Name
            '`horaest`', // Expression
            CastDateFieldForLike("`horaest`", 4, "DB"), // Basic search expression
            134, // Type
            10, // Size
            4, // Date/Time format
            false, // Is upload field
            '`horaest`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->horaest->InputTextType = "text";
        $this->horaest->Raw = true;
        $this->horaest->DefaultErrorMessage = str_replace("%s", DateFormat(4), $Language->phrase("IncorrectTime"));
        $this->horaest->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['horaest'] = &$this->horaest;

        // horareal
        $this->horareal = new DbField(
            $this, // Table
            'x_horareal', // Variable name
            'horareal', // Name
            '`horareal`', // Expression
            CastDateFieldForLike("`horareal`", 4, "DB"), // Basic search expression
            134, // Type
            10, // Size
            4, // Date/Time format
            false, // Is upload field
            '`horareal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->horareal->InputTextType = "text";
        $this->horareal->Raw = true;
        $this->horareal->DefaultErrorMessage = str_replace("%s", DateFormat(4), $Language->phrase("IncorrectTime"));
        $this->horareal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['horareal'] = &$this->horareal;

        // usuario
        $this->usuario = new DbField(
            $this, // Table
            'x_usuario', // Variable name
            'usuario', // Name
            '`usuario`', // Expression
            '`usuario`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuario`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->usuario->addMethod("getAutoUpdateValue", fn() => cogerUsuario());
        $this->usuario->InputTextType = "text";
        $this->usuario->Raw = true;
        $this->usuario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuario'] = &$this->usuario;

        // fecalta
        $this->fecalta = new DbField(
            $this, // Table
            'x_fecalta', // Variable name
            'fecalta', // Name
            '`fecalta`', // Expression
            CastDateFieldForLike("`fecalta`", 11, "DB"), // Basic search expression
            135, // Type
            19, // Size
            11, // Date/Time format
            false, // Is upload field
            '`fecalta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecalta->InputTextType = "text";
        $this->fecalta->Raw = true;
        $this->fecalta->Nullable = false; // NOT NULL field
        $this->fecalta->DefaultErrorMessage = str_replace("%s", DateFormat(11), $Language->phrase("IncorrectDate"));
        $this->fecalta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fecalta'] = &$this->fecalta;

        // observacion
        $this->observacion = new DbField(
            $this, // Table
            'x_observacion', // Variable name
            'observacion', // Name
            '`observacion`', // Expression
            '`observacion`', // Basic search expression
            200, // Type
            500, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`observacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->observacion->InputTextType = "text";
        $this->observacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['observacion'] = &$this->observacion;

        // tipoind
        $this->tipoind = new DbField(
            $this, // Table
            'x_tipoind', // Variable name
            'tipoind', // Name
            '`tipoind`', // Expression
            '`tipoind`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipoind`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tipoind->InputTextType = "text";
        $this->tipoind->Raw = true;
        $this->tipoind->Nullable = false; // NOT NULL field
        $this->tipoind->Required = true; // Required field
        $this->tipoind->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipoind->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tipoind'] = &$this->tipoind;

        // sello
        $this->sello = new DbField(
            $this, // Table
            'x_sello', // Variable name
            'sello', // Name
            '`sello`', // Expression
            '`sello`', // Basic search expression
            16, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`sello`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->sello->addMethod("getDefault", fn() => 0);
        $this->sello->InputTextType = "text";
        $this->sello->Raw = true;
        $this->sello->setSelectMultiple(false); // Select one
        $this->sello->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->sello->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->sello->Lookup = new Lookup($this->sello, 'remates', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->sello->Lookup = new Lookup($this->sello, 'remates', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->sello->OptionCount = 2;
        $this->sello->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->sello->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['sello'] = &$this->sello;

        // plazoSAP
        $this->plazoSAP = new DbField(
            $this, // Table
            'x_plazoSAP', // Variable name
            'plazoSAP', // Name
            '`plazoSAP`', // Expression
            '`plazoSAP`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`plazoSAP`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->plazoSAP->InputTextType = "text";
        $this->plazoSAP->setSelectMultiple(false); // Select one
        $this->plazoSAP->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->plazoSAP->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->plazoSAP->Lookup = new Lookup($this->plazoSAP, 'remates', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->plazoSAP->Lookup = new Lookup($this->plazoSAP, 'remates', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->plazoSAP->OptionCount = 9;
        $this->plazoSAP->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['plazoSAP'] = &$this->plazoSAP;

        // usuarioultmod
        $this->usuarioultmod = new DbField(
            $this, // Table
            'x_usuarioultmod', // Variable name
            'usuarioultmod', // Name
            '`usuarioultmod`', // Expression
            '`usuarioultmod`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuarioultmod`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->usuarioultmod->addMethod("getAutoUpdateValue", fn() => cogerUsuario());
        $this->usuarioultmod->InputTextType = "text";
        $this->usuarioultmod->Raw = true;
        $this->usuarioultmod->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuarioultmod->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuarioultmod'] = &$this->usuarioultmod;

        // fecultmod
        $this->fecultmod = new DbField(
            $this, // Table
            'x_fecultmod', // Variable name
            'fecultmod', // Name
            '`fecultmod`', // Expression
            CastDateFieldForLike("`fecultmod`", 11, "DB"), // Basic search expression
            135, // Type
            19, // Size
            11, // Date/Time format
            false, // Is upload field
            '`fecultmod`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecultmod->addMethod("getAutoUpdateValue", fn() => CurrentDateTime());
        $this->fecultmod->InputTextType = "text";
        $this->fecultmod->Raw = true;
        $this->fecultmod->DefaultErrorMessage = str_replace("%s", DateFormat(11), $Language->phrase("IncorrectDate"));
        $this->fecultmod->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecultmod'] = &$this->fecultmod;

        // servicios
        $this->servicios = new DbField(
            $this, // Table
            'x_servicios', // Variable name
            'servicios', // Name
            '`servicios`', // Expression
            '`servicios`', // Basic search expression
            4, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`servicios`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->servicios->InputTextType = "text";
        $this->servicios->Raw = true;
        $this->servicios->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->servicios->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicios'] = &$this->servicios;

        // gastos
        $this->gastos = new DbField(
            $this, // Table
            'x_gastos', // Variable name
            'gastos', // Name
            '`gastos`', // Expression
            '`gastos`', // Basic search expression
            4, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`gastos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->gastos->InputTextType = "text";
        $this->gastos->Raw = true;
        $this->gastos->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->gastos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['gastos'] = &$this->gastos;

        // tasa
        $this->tasa = new DbField(
            $this, // Table
            'x_tasa', // Variable name
            'tasa', // Name
            '`tasa`', // Expression
            '`tasa`', // Basic search expression
            16, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tasa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->tasa->addMethod("getDefault", fn() => 1);
        $this->tasa->InputTextType = "text";
        $this->tasa->Raw = true;
        $this->tasa->Nullable = false; // NOT NULL field
        $this->tasa->setDataType(DataType::BOOLEAN);
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->tasa->Lookup = new Lookup($this->tasa, 'remates', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->tasa->Lookup = new Lookup($this->tasa, 'remates', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->tasa->OptionCount = 2;
        $this->tasa->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->tasa->SearchOperators = ["=", "<>"];
        $this->Fields['tasa'] = &$this->tasa;

        // Add Doctrine Cache
        $this->Cache = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Multiple column sort
    public function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($ctrl) {
                $orderBy = $this->getSessionOrderBy();
                $arOrderBy = !empty($orderBy) ? explode(", ", $orderBy) : [];
                if ($lastOrderBy != "" && in_array($lastOrderBy, $arOrderBy)) {
                    foreach ($arOrderBy as $key => $val) {
                        if ($val == $lastOrderBy) {
                            if ($curOrderBy == "") {
                                unset($arOrderBy[$key]);
                            } else {
                                $arOrderBy[$key] = $curOrderBy;
                            }
                        }
                    }
                } elseif ($curOrderBy != "") {
                    $arOrderBy[] = $curOrderBy;
                }
                $orderBy = implode(", ", $arOrderBy);
                $this->setSessionOrderBy($orderBy); // Save to Session
            } else {
                $this->setSessionOrderBy($curOrderBy); // Save to Session
            }
            $sortFieldList = ($fld->VirtualExpression != "") ? $fld->VirtualExpression : $sortField;
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortFieldList . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortFieldList . " " . $curSort : "";
            if ($ctrl) {
                $orderByList = $this->getSessionOrderByList();
                $arOrderBy = !empty($orderByList) ? explode(", ", $orderByList) : [];
                if ($lastOrderBy != "" && in_array($lastOrderBy, $arOrderBy)) {
                    foreach ($arOrderBy as $key => $val) {
                        if ($val == $lastOrderBy) {
                            if ($curOrderBy == "") {
                                unset($arOrderBy[$key]);
                            } else {
                                $arOrderBy[$key] = $curOrderBy;
                            }
                        }
                    }
                } elseif ($curOrderBy != "") {
                    $arOrderBy[] = $curOrderBy;
                }
                $orderByList = implode(", ", $arOrderBy);
                $this->setSessionOrderByList($orderByList); // Save to Session
            } else {
                $this->setSessionOrderByList($curOrderBy); // Save to Session
            }
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->useVirtualFields() ? $this->getSessionOrderByList() : $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Session ORDER BY for List page
    public function getSessionOrderByList()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST"));
    }

    public function setSessionOrderByList($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")] = $v;
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")) ?? "";
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "lotes") {
            $detailUrl = Container("lotes")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_ncomp", $this->ncomp->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "RematesList";
        }
        return $detailUrl;
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "remates";
    }

    // Get FROM clause (for backward compatibility)
    public function sqlFrom()
    {
        return $this->getSqlFrom();
    }

    // Set FROM clause
    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    // Get SELECT clause
    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select($this->sqlSelectFields());
    }

    // Get list of fields
    private function sqlSelectFields()
    {
        $useFieldNames = false;
        $fieldNames = [];
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($this->Fields as $field) {
            $expr = $field->Expression;
            $customExpr = $field->CustomDataType?->convertToPHPValueSQL($expr, $platform) ?? $expr;
            if ($customExpr != $expr) {
                $fieldNames[] = $customExpr . " AS " . QuotedName($field->Name, $this->Dbid);
                $useFieldNames = true;
            } else {
                $fieldNames[] = $expr;
            }
        }
        return $useFieldNames ? implode(", ", $fieldNames) : "*";
    }

    // Get SELECT clause (for backward compatibility)
    public function sqlSelect()
    {
        return $this->getSqlSelect();
    }

    // Set SELECT clause
    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    // Get SELECT clause for List page
    public function getSqlSelectList()
    {
        if ($this->SqlSelectList) {
            return $this->SqlSelectList;
        }
        $from = "(SELECT " . $this->sqlSelectFields() . ", (SELECT `descripcion` FROM paises TMP_LOOKUPTABLE WHERE TMP_LOOKUPTABLE.codnum = remates.codpais LIMIT 1) AS EV__codpais, (SELECT `descripcion` FROM provincias TMP_LOOKUPTABLE WHERE TMP_LOOKUPTABLE.codnum = remates.codprov LIMIT 1) AS EV__codprov, (SELECT `descripcion` FROM provincias TMP_LOOKUPTABLE WHERE TMP_LOOKUPTABLE.codnum = remates.codloc LIMIT 1) AS EV__codloc FROM remates)";
        return $from . " TMP_TABLE";
    }

    // Get SELECT clause for List page (for backward compatibility)
    public function sqlSelectList()
    {
        return $this->getSqlSelectList();
    }

    // Set SELECT clause for List page
    public function setSqlSelectList($v)
    {
        $this->SqlSelectList = $v;
    }

    // Get WHERE clause
    public function getSqlWhere()
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    // Get WHERE clause (for backward compatibility)
    public function sqlWhere()
    {
        return $this->getSqlWhere();
    }

    // Set WHERE clause
    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    // Get GROUP BY clause
    public function getSqlGroupBy()
    {
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "";
    }

    // Get GROUP BY clause (for backward compatibility)
    public function sqlGroupBy()
    {
        return $this->getSqlGroupBy();
    }

    // set GROUP BY clause
    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    // Get HAVING clause
    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    // Get HAVING clause (for backward compatibility)
    public function sqlHaving()
    {
        return $this->getSqlHaving();
    }

    // Set HAVING clause
    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    // Get ORDER BY clause
    public function getSqlOrderBy()
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    // Get ORDER BY clause (for backward compatibility)
    public function sqlOrderBy()
    {
        return $this->getSqlOrderBy();
    }

    // set ORDER BY clause
    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return ($allow & Allow::ADD->value) == Allow::ADD->value;
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return ($allow & Allow::EDIT->value) == Allow::EDIT->value;
            case "delete":
                return ($allow & Allow::DELETE->value) == Allow::DELETE->value;
            case "view":
                return ($allow & Allow::VIEW->value) == Allow::VIEW->value;
            case "search":
                return ($allow & Allow::SEARCH->value) == Allow::SEARCH->value;
            case "lookup":
                return ($allow & Allow::LOOKUP->value) == Allow::LOOKUP->value;
            default:
                return ($allow & Allow::LIST->value) == Allow::LIST->value;
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $sqlwrk = $sql instanceof QueryBuilder // Query builder
            ? (clone $sql)->resetQueryPart("orderBy")->getSQL()
            : $sql;
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            in_array($this->TableType, ["TABLE", "VIEW", "LINKTABLE"]) &&
            preg_match($pattern, $sqlwrk) &&
            !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*SELECT\s+DISTINCT\s+/i', $sqlwrk) &&
            !preg_match('/\s+ORDER\s+BY\s+/i', $sqlwrk)
        ) {
            $sqlcnt = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlcnt = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlcnt);
        if ($cnt !== false) {
            return (int)$cnt;
        }
        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        $result = $conn->executeQuery($sqlwrk);
        $cnt = $result->rowCount();
        if ($cnt == 0) { // Unable to get record count, count directly
            while ($result->fetch()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        if ($this->useVirtualFields()) {
            $select = "*";
            $from = $this->getSqlSelectList();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        } else {
            $select = $this->getSqlSelect();
            $from = $this->getSqlFrom();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        }
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = ($this->useVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Check if virtual fields is used in SQL
    protected function useVirtualFields()
    {
        $where = $this->UseSessionForListSql ? $this->getSessionWhere() : $this->CurrentFilter;
        $orderBy = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        if ($where != "") {
            $where = " " . str_replace(["(", ")"], ["", ""], $where) . " ";
        }
        if ($orderBy != "") {
            $orderBy = " " . str_replace(["(", ")"], ["", ""], $orderBy) . " ";
        }
        if ($this->BasicSearch->getKeyword() != "") {
            return true;
        }
        if (
            $this->codpais->AdvancedSearch->SearchValue != "" ||
            $this->codpais->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->codpais->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->codpais->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->codprov->AdvancedSearch->SearchValue != "" ||
            $this->codprov->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->codprov->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->codprov->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->codloc->AdvancedSearch->SearchValue != "" ||
            $this->codloc->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->codloc->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->codloc->VirtualExpression . " ")) {
            return true;
        }
        return false;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        if ($this->useVirtualFields()) {
            $sql = $this->buildSelectSql("*", $this->getSqlSelectList(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        } else {
            $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        }
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->setValue($field->Expression, $parm);
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $queryBuilder = $this->insertSql($rs);
            $result = $queryBuilder->executeStatement();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $result = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($result) {
            $this->codnum->setDbValue($conn->lastInsertId());
            $rs['codnum'] = $this->codnum->DbValue;
        }
        return $result;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->set($field->Expression, $parm);
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->executeStatement();
            $success = $success > 0 ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['codnum']) && !EmptyValue($this->codnum->CurrentValue)) {
                $rs['codnum'] = $this->codnum->CurrentValue;
            }
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('codnum', $rs)) {
                AddFilter($where, QuotedName('codnum', $this->Dbid) . '=' . QuotedValue($rs['codnum'], $this->codnum->DataType, $this->Dbid));
            }
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->executeStatement();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        return $success;
    }

    // Load DbValue from result set or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->ncomp->DbValue = $row['ncomp'];
        $this->codnum->DbValue = $row['codnum'];
        $this->tcomp->DbValue = $row['tcomp'];
        $this->serie->DbValue = $row['serie'];
        $this->codcli->DbValue = $row['codcli'];
        $this->direccion->DbValue = $row['direccion'];
        $this->codpais->DbValue = $row['codpais'];
        $this->codprov->DbValue = $row['codprov'];
        $this->codloc->DbValue = $row['codloc'];
        $this->fecest->DbValue = $row['fecest'];
        $this->fecreal->DbValue = $row['fecreal'];
        $this->imptot->DbValue = $row['imptot'];
        $this->impbase->DbValue = $row['impbase'];
        $this->estado->DbValue = $row['estado'];
        $this->cantlotes->DbValue = $row['cantlotes'];
        $this->horaest->DbValue = $row['horaest'];
        $this->horareal->DbValue = $row['horareal'];
        $this->usuario->DbValue = $row['usuario'];
        $this->fecalta->DbValue = $row['fecalta'];
        $this->observacion->DbValue = $row['observacion'];
        $this->tipoind->DbValue = $row['tipoind'];
        $this->sello->DbValue = $row['sello'];
        $this->plazoSAP->DbValue = $row['plazoSAP'];
        $this->usuarioultmod->DbValue = $row['usuarioultmod'];
        $this->fecultmod->DbValue = $row['fecultmod'];
        $this->servicios->DbValue = $row['servicios'];
        $this->gastos->DbValue = $row['gastos'];
        $this->tasa->DbValue = $row['tasa'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`codnum` = @codnum@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->codnum->CurrentValue : $this->codnum->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->codnum->CurrentValue = $keys[0];
            } else {
                $this->codnum->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('codnum', $row) ? $row['codnum'] : null;
        } else {
            $val = !EmptyValue($this->codnum->OldValue) && !$current ? $this->codnum->OldValue : $this->codnum->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@codnum@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("RematesList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        return match ($pageName) {
            "RematesView" => $Language->phrase("View"),
            "RematesEdit" => $Language->phrase("Edit"),
            "RematesAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "RematesList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "RematesView",
            Config("API_ADD_ACTION") => "RematesAdd",
            Config("API_EDIT_ACTION") => "RematesEdit",
            Config("API_DELETE_ACTION") => "RematesDelete",
            Config("API_LIST_ACTION") => "RematesList",
            default => ""
        };
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "RematesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RematesView", $parm);
        } else {
            $url = $this->keyUrl("RematesView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "RematesAdd?" . $parm;
        } else {
            $url = "RematesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RematesEdit", $parm);
        } else {
            $url = $this->keyUrl("RematesEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("RematesList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RematesAdd", $parm);
        } else {
            $url = $this->keyUrl("RematesAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("RematesList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("RematesDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"codnum\":" . VarToJson($this->codnum->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->codnum->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->codnum->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($this->PageID != "grid" && $fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="2"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($this->PageID != "grid" && !$this->isExport() && $fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") .
                (is_array($fld->EditValue) ? str_replace("%c", count($fld->EditValue), $Language->phrase("FilterCount")) : '') .
                '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport;
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 0))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 0))) // Other API
                : []; // Non-API
            if (($keyValue = Param("codnum") ?? Route("codnum")) !== null) {
                $arKeys[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        return implode(" OR ", array_map(fn($row) => "(" . $this->getRecordFilter($row) . ")", $rows));
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->codnum->CurrentValue = $key;
            } else {
                $this->codnum->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load result set based on filter/sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->ncomp->setDbValue($row['ncomp']);
        $this->codnum->setDbValue($row['codnum']);
        $this->tcomp->setDbValue($row['tcomp']);
        $this->serie->setDbValue($row['serie']);
        $this->codcli->setDbValue($row['codcli']);
        $this->direccion->setDbValue($row['direccion']);
        $this->codpais->setDbValue($row['codpais']);
        $this->codprov->setDbValue($row['codprov']);
        $this->codloc->setDbValue($row['codloc']);
        $this->fecest->setDbValue($row['fecest']);
        $this->fecreal->setDbValue($row['fecreal']);
        $this->imptot->setDbValue($row['imptot']);
        $this->impbase->setDbValue($row['impbase']);
        $this->estado->setDbValue($row['estado']);
        $this->cantlotes->setDbValue($row['cantlotes']);
        $this->horaest->setDbValue($row['horaest']);
        $this->horareal->setDbValue($row['horareal']);
        $this->usuario->setDbValue($row['usuario']);
        $this->fecalta->setDbValue($row['fecalta']);
        $this->observacion->setDbValue($row['observacion']);
        $this->tipoind->setDbValue($row['tipoind']);
        $this->sello->setDbValue($row['sello']);
        $this->plazoSAP->setDbValue($row['plazoSAP']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
        $this->servicios->setDbValue($row['servicios']);
        $this->gastos->setDbValue($row['gastos']);
        $this->tasa->setDbValue($row['tasa']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "RematesList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("app.view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // ncomp

        // codnum

        // tcomp

        // serie

        // codcli

        // direccion

        // codpais

        // codprov

        // codloc

        // fecest

        // fecreal

        // imptot

        // impbase

        // estado

        // cantlotes

        // horaest

        // horareal

        // usuario

        // fecalta

        // observacion

        // tipoind

        // sello

        // plazoSAP

        // usuarioultmod

        // fecultmod

        // servicios

        // gastos

        // tasa

        // ncomp
        $this->ncomp->ViewValue = $this->ncomp->CurrentValue;
        $this->ncomp->ViewValue = FormatNumber($this->ncomp->ViewValue, $this->ncomp->formatPattern());

        // codnum
        $this->codnum->ViewValue = $this->codnum->CurrentValue;

        // tcomp
        $curVal = strval($this->tcomp->CurrentValue);
        if ($curVal != "") {
            $this->tcomp->ViewValue = $this->tcomp->lookupCacheOption($curVal);
            if ($this->tcomp->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tcomp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tcomp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $lookupFilter = $this->tcomp->getSelectFilter($this); // PHP
                $sqlWrk = $this->tcomp->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tcomp->Lookup->renderViewRow($rswrk[0]);
                    $this->tcomp->ViewValue = $this->tcomp->displayValue($arwrk);
                } else {
                    $this->tcomp->ViewValue = FormatNumber($this->tcomp->CurrentValue, $this->tcomp->formatPattern());
                }
            }
        } else {
            $this->tcomp->ViewValue = null;
        }

        // serie
        $curVal = strval($this->serie->CurrentValue);
        if ($curVal != "") {
            $this->serie->ViewValue = $this->serie->lookupCacheOption($curVal);
            if ($this->serie->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->serie->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->serie->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $lookupFilter = $this->serie->getSelectFilter($this); // PHP
                $sqlWrk = $this->serie->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->serie->Lookup->renderViewRow($rswrk[0]);
                    $this->serie->ViewValue = $this->serie->displayValue($arwrk);
                } else {
                    $this->serie->ViewValue = FormatNumber($this->serie->CurrentValue, $this->serie->formatPattern());
                }
            }
        } else {
            $this->serie->ViewValue = null;
        }

        // codcli
        $curVal = strval($this->codcli->CurrentValue);
        if ($curVal != "") {
            $this->codcli->ViewValue = $this->codcli->lookupCacheOption($curVal);
            if ($this->codcli->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->codcli->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codcli->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $lookupFilter = $this->codcli->getSelectFilter($this); // PHP
                $sqlWrk = $this->codcli->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->codcli->Lookup->renderViewRow($rswrk[0]);
                    $this->codcli->ViewValue = $this->codcli->displayValue($arwrk);
                } else {
                    $this->codcli->ViewValue = FormatNumber($this->codcli->CurrentValue, $this->codcli->formatPattern());
                }
            }
        } else {
            $this->codcli->ViewValue = null;
        }

        // direccion
        $this->direccion->ViewValue = $this->direccion->CurrentValue;

        // codpais
        if ($this->codpais->VirtualValue != "") {
            $this->codpais->ViewValue = $this->codpais->VirtualValue;
        } else {
            $curVal = strval($this->codpais->CurrentValue);
            if ($curVal != "") {
                $this->codpais->ViewValue = $this->codpais->lookupCacheOption($curVal);
                if ($this->codpais->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->codpais->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codpais->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->codpais->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->codpais->Lookup->renderViewRow($rswrk[0]);
                        $this->codpais->ViewValue = $this->codpais->displayValue($arwrk);
                    } else {
                        $this->codpais->ViewValue = FormatNumber($this->codpais->CurrentValue, $this->codpais->formatPattern());
                    }
                }
            } else {
                $this->codpais->ViewValue = null;
            }
        }

        // codprov
        if ($this->codprov->VirtualValue != "") {
            $this->codprov->ViewValue = $this->codprov->VirtualValue;
        } else {
            $curVal = strval($this->codprov->CurrentValue);
            if ($curVal != "") {
                $this->codprov->ViewValue = $this->codprov->lookupCacheOption($curVal);
                if ($this->codprov->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->codprov->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codprov->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->codprov->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->codprov->Lookup->renderViewRow($rswrk[0]);
                        $this->codprov->ViewValue = $this->codprov->displayValue($arwrk);
                    } else {
                        $this->codprov->ViewValue = FormatNumber($this->codprov->CurrentValue, $this->codprov->formatPattern());
                    }
                }
            } else {
                $this->codprov->ViewValue = null;
            }
        }

        // codloc
        if ($this->codloc->VirtualValue != "") {
            $this->codloc->ViewValue = $this->codloc->VirtualValue;
        } else {
            $curVal = strval($this->codloc->CurrentValue);
            if ($curVal != "") {
                $this->codloc->ViewValue = $this->codloc->lookupCacheOption($curVal);
                if ($this->codloc->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->codloc->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codloc->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->codloc->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->codloc->Lookup->renderViewRow($rswrk[0]);
                        $this->codloc->ViewValue = $this->codloc->displayValue($arwrk);
                    } else {
                        $this->codloc->ViewValue = FormatNumber($this->codloc->CurrentValue, $this->codloc->formatPattern());
                    }
                }
            } else {
                $this->codloc->ViewValue = null;
            }
        }

        // fecest
        $this->fecest->ViewValue = $this->fecest->CurrentValue;
        $this->fecest->ViewValue = FormatDateTime($this->fecest->ViewValue, $this->fecest->formatPattern());

        // fecreal
        $this->fecreal->ViewValue = $this->fecreal->CurrentValue;
        $this->fecreal->ViewValue = FormatDateTime($this->fecreal->ViewValue, $this->fecreal->formatPattern());

        // imptot
        $this->imptot->ViewValue = $this->imptot->CurrentValue;
        $this->imptot->ViewValue = FormatNumber($this->imptot->ViewValue, $this->imptot->formatPattern());

        // impbase
        $this->impbase->ViewValue = $this->impbase->CurrentValue;
        $this->impbase->ViewValue = FormatNumber($this->impbase->ViewValue, $this->impbase->formatPattern());

        // estado
        if (strval($this->estado->CurrentValue) != "") {
            $this->estado->ViewValue = new OptionValues();
            $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), strval($this->estado->CurrentValue));
            $cnt = count($arwrk);
            for ($ari = 0; $ari < $cnt; $ari++)
                $this->estado->ViewValue->add($this->estado->optionCaption(trim($arwrk[$ari])));
        } else {
            $this->estado->ViewValue = null;
        }

        // cantlotes
        $this->cantlotes->ViewValue = $this->cantlotes->CurrentValue;
        $this->cantlotes->ViewValue = FormatNumber($this->cantlotes->ViewValue, $this->cantlotes->formatPattern());

        // horaest
        $this->horaest->ViewValue = $this->horaest->CurrentValue;
        $this->horaest->ViewValue = FormatDateTime($this->horaest->ViewValue, $this->horaest->formatPattern());

        // horareal
        $this->horareal->ViewValue = $this->horareal->CurrentValue;
        $this->horareal->ViewValue = FormatDateTime($this->horareal->ViewValue, $this->horareal->formatPattern());

        // usuario
        $this->usuario->ViewValue = $this->usuario->CurrentValue;
        $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

        // fecalta
        $this->fecalta->ViewValue = $this->fecalta->CurrentValue;
        $this->fecalta->ViewValue = FormatDateTime($this->fecalta->ViewValue, $this->fecalta->formatPattern());

        // observacion
        $this->observacion->ViewValue = $this->observacion->CurrentValue;

        // tipoind
        $this->tipoind->ViewValue = $this->tipoind->CurrentValue;
        $this->tipoind->ViewValue = FormatNumber($this->tipoind->ViewValue, $this->tipoind->formatPattern());

        // sello
        if (strval($this->sello->CurrentValue) != "") {
            $this->sello->ViewValue = $this->sello->optionCaption($this->sello->CurrentValue);
        } else {
            $this->sello->ViewValue = null;
        }

        // plazoSAP
        if (strval($this->plazoSAP->CurrentValue) != "") {
            $this->plazoSAP->ViewValue = $this->plazoSAP->optionCaption($this->plazoSAP->CurrentValue);
        } else {
            $this->plazoSAP->ViewValue = null;
        }

        // usuarioultmod
        $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
        $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

        // fecultmod
        $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
        $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

        // servicios
        $this->servicios->ViewValue = $this->servicios->CurrentValue;
        $this->servicios->ViewValue = FormatNumber($this->servicios->ViewValue, $this->servicios->formatPattern());

        // gastos
        $this->gastos->ViewValue = $this->gastos->CurrentValue;
        $this->gastos->ViewValue = FormatNumber($this->gastos->ViewValue, $this->gastos->formatPattern());

        // tasa
        if (ConvertToBool($this->tasa->CurrentValue)) {
            $this->tasa->ViewValue = $this->tasa->tagCaption(1) != "" ? $this->tasa->tagCaption(1) : "Yes";
        } else {
            $this->tasa->ViewValue = $this->tasa->tagCaption(2) != "" ? $this->tasa->tagCaption(2) : "No";
        }

        // ncomp
        $this->ncomp->HrefValue = "";
        $this->ncomp->TooltipValue = "";

        // codnum
        $this->codnum->HrefValue = "";
        $this->codnum->TooltipValue = "";

        // tcomp
        $this->tcomp->HrefValue = "";
        $this->tcomp->TooltipValue = "";

        // serie
        $this->serie->HrefValue = "";
        $this->serie->TooltipValue = "";

        // codcli
        $this->codcli->HrefValue = "";
        $this->codcli->TooltipValue = "";

        // direccion
        $this->direccion->HrefValue = "";
        $this->direccion->TooltipValue = "";

        // codpais
        $this->codpais->HrefValue = "";
        $this->codpais->TooltipValue = "";

        // codprov
        $this->codprov->HrefValue = "";
        $this->codprov->TooltipValue = "";

        // codloc
        $this->codloc->HrefValue = "";
        $this->codloc->TooltipValue = "";

        // fecest
        $this->fecest->HrefValue = "";
        $this->fecest->TooltipValue = "";

        // fecreal
        $this->fecreal->HrefValue = "";
        $this->fecreal->TooltipValue = "";

        // imptot
        $this->imptot->HrefValue = "";
        $this->imptot->TooltipValue = "";

        // impbase
        $this->impbase->HrefValue = "";
        $this->impbase->TooltipValue = "";

        // estado
        $this->estado->HrefValue = "";
        $this->estado->TooltipValue = "";

        // cantlotes
        $this->cantlotes->HrefValue = "";
        $this->cantlotes->TooltipValue = "";

        // horaest
        $this->horaest->HrefValue = "";
        $this->horaest->TooltipValue = "";

        // horareal
        $this->horareal->HrefValue = "";
        $this->horareal->TooltipValue = "";

        // usuario
        $this->usuario->HrefValue = "";
        $this->usuario->TooltipValue = "";

        // fecalta
        $this->fecalta->HrefValue = "";
        $this->fecalta->TooltipValue = "";

        // observacion
        $this->observacion->HrefValue = "";
        $this->observacion->TooltipValue = "";

        // tipoind
        $this->tipoind->HrefValue = "";
        $this->tipoind->TooltipValue = "";

        // sello
        $this->sello->HrefValue = "";
        $this->sello->TooltipValue = "";

        // plazoSAP
        $this->plazoSAP->HrefValue = "";
        $this->plazoSAP->TooltipValue = "";

        // usuarioultmod
        $this->usuarioultmod->HrefValue = "";
        $this->usuarioultmod->TooltipValue = "";

        // fecultmod
        $this->fecultmod->HrefValue = "";
        $this->fecultmod->TooltipValue = "";

        // servicios
        $this->servicios->HrefValue = "";
        $this->servicios->TooltipValue = "";

        // gastos
        $this->gastos->HrefValue = "";
        $this->gastos->TooltipValue = "";

        // tasa
        $this->tasa->HrefValue = "";
        $this->tasa->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // ncomp
        $this->ncomp->setupEditAttributes();
        $this->ncomp->EditValue = $this->ncomp->CurrentValue;
        $this->ncomp->EditValue = FormatNumber($this->ncomp->EditValue, $this->ncomp->formatPattern());

        // codnum
        $this->codnum->setupEditAttributes();
        $this->codnum->EditValue = $this->codnum->CurrentValue;

        // tcomp
        $this->tcomp->setupEditAttributes();
        $this->tcomp->PlaceHolder = RemoveHtml($this->tcomp->caption());

        // serie
        $this->serie->setupEditAttributes();
        $this->serie->PlaceHolder = RemoveHtml($this->serie->caption());

        // codcli
        $this->codcli->setupEditAttributes();
        $this->codcli->PlaceHolder = RemoveHtml($this->codcli->caption());

        // direccion
        $this->direccion->setupEditAttributes();
        if (!$this->direccion->Raw) {
            $this->direccion->CurrentValue = HtmlDecode($this->direccion->CurrentValue);
        }
        $this->direccion->EditValue = $this->direccion->CurrentValue;
        $this->direccion->PlaceHolder = RemoveHtml($this->direccion->caption());

        // codpais
        $this->codpais->setupEditAttributes();
        $this->codpais->PlaceHolder = RemoveHtml($this->codpais->caption());

        // codprov
        $this->codprov->setupEditAttributes();
        $this->codprov->PlaceHolder = RemoveHtml($this->codprov->caption());

        // codloc
        $this->codloc->setupEditAttributes();
        $this->codloc->PlaceHolder = RemoveHtml($this->codloc->caption());

        // fecest
        $this->fecest->setupEditAttributes();
        $this->fecest->EditValue = FormatDateTime($this->fecest->CurrentValue, $this->fecest->formatPattern());
        $this->fecest->PlaceHolder = RemoveHtml($this->fecest->caption());

        // fecreal
        $this->fecreal->setupEditAttributes();
        $this->fecreal->EditValue = FormatDateTime($this->fecreal->CurrentValue, $this->fecreal->formatPattern());
        $this->fecreal->PlaceHolder = RemoveHtml($this->fecreal->caption());

        // imptot
        $this->imptot->setupEditAttributes();
        $this->imptot->CurrentValue = FormatNumber($this->imptot->CurrentValue, $this->imptot->formatPattern());
        if (strval($this->imptot->EditValue) != "" && is_numeric($this->imptot->EditValue)) {
            $this->imptot->EditValue = FormatNumber($this->imptot->EditValue, null);
        }

        // impbase
        $this->impbase->setupEditAttributes();
        $this->impbase->CurrentValue = FormatNumber($this->impbase->CurrentValue, $this->impbase->formatPattern());
        if (strval($this->impbase->EditValue) != "" && is_numeric($this->impbase->EditValue)) {
            $this->impbase->EditValue = FormatNumber($this->impbase->EditValue, null);
        }

        // estado
        $this->estado->EditValue = $this->estado->options(false);
        $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

        // cantlotes
        $this->cantlotes->setupEditAttributes();
        $this->cantlotes->CurrentValue = FormatNumber($this->cantlotes->CurrentValue, $this->cantlotes->formatPattern());
        if (strval($this->cantlotes->EditValue) != "" && is_numeric($this->cantlotes->EditValue)) {
            $this->cantlotes->EditValue = FormatNumber($this->cantlotes->EditValue, null);
        }

        // horaest
        $this->horaest->setupEditAttributes();
        $this->horaest->CurrentValue = FormatDateTime($this->horaest->CurrentValue, $this->horaest->formatPattern());

        // horareal
        $this->horareal->setupEditAttributes();
        $this->horareal->EditValue = FormatDateTime($this->horareal->CurrentValue, $this->horareal->formatPattern());
        $this->horareal->PlaceHolder = RemoveHtml($this->horareal->caption());

        // usuario

        // fecalta
        $this->fecalta->setupEditAttributes();
        $this->fecalta->EditValue = FormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern());
        $this->fecalta->PlaceHolder = RemoveHtml($this->fecalta->caption());

        // observacion
        $this->observacion->setupEditAttributes();
        $this->observacion->EditValue = $this->observacion->CurrentValue;
        $this->observacion->PlaceHolder = RemoveHtml($this->observacion->caption());

        // tipoind
        $this->tipoind->setupEditAttributes();
        $this->tipoind->EditValue = $this->tipoind->CurrentValue;
        $this->tipoind->PlaceHolder = RemoveHtml($this->tipoind->caption());
        if (strval($this->tipoind->EditValue) != "" && is_numeric($this->tipoind->EditValue)) {
            $this->tipoind->EditValue = FormatNumber($this->tipoind->EditValue, null);
        }

        // sello
        $this->sello->setupEditAttributes();
        $this->sello->EditValue = $this->sello->options(true);
        $this->sello->PlaceHolder = RemoveHtml($this->sello->caption());

        // plazoSAP
        $this->plazoSAP->setupEditAttributes();
        $this->plazoSAP->EditValue = $this->plazoSAP->options(true);
        $this->plazoSAP->PlaceHolder = RemoveHtml($this->plazoSAP->caption());

        // usuarioultmod

        // fecultmod

        // servicios
        $this->servicios->setupEditAttributes();
        $this->servicios->EditValue = $this->servicios->CurrentValue;
        $this->servicios->PlaceHolder = RemoveHtml($this->servicios->caption());
        if (strval($this->servicios->EditValue) != "" && is_numeric($this->servicios->EditValue)) {
            $this->servicios->EditValue = FormatNumber($this->servicios->EditValue, null);
        }

        // gastos
        $this->gastos->setupEditAttributes();
        $this->gastos->EditValue = $this->gastos->CurrentValue;
        $this->gastos->PlaceHolder = RemoveHtml($this->gastos->caption());
        if (strval($this->gastos->EditValue) != "" && is_numeric($this->gastos->EditValue)) {
            $this->gastos->EditValue = FormatNumber($this->gastos->EditValue, null);
        }

        // tasa
        $this->tasa->EditValue = $this->tasa->options(false);
        $this->tasa->PlaceHolder = RemoveHtml($this->tasa->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $result, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$result || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->ncomp);
                    $doc->exportCaption($this->tcomp);
                    $doc->exportCaption($this->serie);
                    $doc->exportCaption($this->codcli);
                    $doc->exportCaption($this->direccion);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->fecest);
                    $doc->exportCaption($this->fecreal);
                    $doc->exportCaption($this->imptot);
                    $doc->exportCaption($this->impbase);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->cantlotes);
                    $doc->exportCaption($this->horaest);
                    $doc->exportCaption($this->horareal);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->fecalta);
                    $doc->exportCaption($this->observacion);
                    $doc->exportCaption($this->tipoind);
                    $doc->exportCaption($this->sello);
                    $doc->exportCaption($this->plazoSAP);
                    $doc->exportCaption($this->usuarioultmod);
                    $doc->exportCaption($this->fecultmod);
                    $doc->exportCaption($this->servicios);
                    $doc->exportCaption($this->gastos);
                    $doc->exportCaption($this->tasa);
                } else {
                    $doc->exportCaption($this->ncomp);
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->tcomp);
                    $doc->exportCaption($this->serie);
                    $doc->exportCaption($this->codcli);
                    $doc->exportCaption($this->direccion);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->fecest);
                    $doc->exportCaption($this->fecreal);
                    $doc->exportCaption($this->imptot);
                    $doc->exportCaption($this->impbase);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->cantlotes);
                    $doc->exportCaption($this->horaest);
                    $doc->exportCaption($this->horareal);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->fecalta);
                    $doc->exportCaption($this->tipoind);
                    $doc->exportCaption($this->sello);
                    $doc->exportCaption($this->plazoSAP);
                    $doc->exportCaption($this->usuarioultmod);
                    $doc->exportCaption($this->fecultmod);
                    $doc->exportCaption($this->servicios);
                    $doc->exportCaption($this->gastos);
                    $doc->exportCaption($this->tasa);
                }
                $doc->endExportRow();
            }
        }
        $recCnt = $startRec - 1;
        $stopRec = $stopRec > 0 ? $stopRec : PHP_INT_MAX;
        while (($row = $result->fetch()) && $recCnt < $stopRec) {
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->ncomp);
                        $doc->exportField($this->tcomp);
                        $doc->exportField($this->serie);
                        $doc->exportField($this->codcli);
                        $doc->exportField($this->direccion);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->fecest);
                        $doc->exportField($this->fecreal);
                        $doc->exportField($this->imptot);
                        $doc->exportField($this->impbase);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->cantlotes);
                        $doc->exportField($this->horaest);
                        $doc->exportField($this->horareal);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->fecalta);
                        $doc->exportField($this->observacion);
                        $doc->exportField($this->tipoind);
                        $doc->exportField($this->sello);
                        $doc->exportField($this->plazoSAP);
                        $doc->exportField($this->usuarioultmod);
                        $doc->exportField($this->fecultmod);
                        $doc->exportField($this->servicios);
                        $doc->exportField($this->gastos);
                        $doc->exportField($this->tasa);
                    } else {
                        $doc->exportField($this->ncomp);
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->tcomp);
                        $doc->exportField($this->serie);
                        $doc->exportField($this->codcli);
                        $doc->exportField($this->direccion);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->fecest);
                        $doc->exportField($this->fecreal);
                        $doc->exportField($this->imptot);
                        $doc->exportField($this->impbase);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->cantlotes);
                        $doc->exportField($this->horaest);
                        $doc->exportField($this->horareal);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->fecalta);
                        $doc->exportField($this->tipoind);
                        $doc->exportField($this->sello);
                        $doc->exportField($this->plazoSAP);
                        $doc->exportField($this->usuarioultmod);
                        $doc->exportField($this->fecultmod);
                        $doc->exportField($this->servicios);
                        $doc->exportField($this->gastos);
                        $doc->exportField($this->tasa);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
    }

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected($rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    public function rowInserted($rsold, &$rsnew) {
    	$this->setSuccessMessage("Registro agregado. El nuevo numero de Remate es " . $rsnew["ncomp"]);    
    		$amercado = Conn();
    		// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
    		$serie    = 4;  

    		// LEO LA TABLA SERIES

            // consulta por series si codnum es = 4
    		$query = sprintf("SELECT * FROM series WHERE series.codnum = $serie"); 
    		$Result = mysqli_query($amercado, $query) or die(mysqli_error($amercado));

            // hacer if que retorne false si no sale
    		$row_Result = mysqli_fetch_assoc($Result);   
    		$nroact = $row_Result['nroact'] + 1;
    		$rematenum = $nroact;
    		// ACTUALIZO EL ULTIMO NRO DE LA serie
    		$query2 = sprintf("UPDATE SERIES SET nroact = $nroact WHERE series.codnum = $serie");
    		$Result2 = mysqli_query($amercado, $query2) or die(mysqli_error($amercado));
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted($rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, $args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
