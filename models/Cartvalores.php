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
 * Table class for cartvalores
 */
class Cartvalores extends DbTable
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
    public $codnum;
    public $tcomp;
    public $serie;
    public $ncomp;
    public $codban;
    public $codsuc;
    public $codcta;
    public $tipcta;
    public $codchq;
    public $codpais;
    public $importe;
    public $fechaemis;
    public $fechapago;
    public $entrego;
    public $recibio;
    public $fechaingr;
    public $fechaentrega;
    public $tcomprel;
    public $serierel;
    public $ncomprel;
    public $estado;
    public $moneda;
    public $fechahora;
    public $usuario;
    public $tcompsal;
    public $seriesal;
    public $ncompsal;
    public $codrem;
    public $cotiz;
    public $usurel;
    public $fecharel;
    public $ususal;
    public $fechasal;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "cartvalores";
        $this->TableName = 'cartvalores';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "cartvalores";
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
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

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
            'NO' // Edit Tag
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
            'TEXT' // Edit Tag
        );
        $this->tcomp->InputTextType = "text";
        $this->tcomp->Raw = true;
        $this->tcomp->Nullable = false; // NOT NULL field
        $this->tcomp->Required = true; // Required field
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->tcomp->Lookup = new Lookup($this->tcomp, 'tipcomp', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`descripcion`");
                break;
            default:
                $this->tcomp->Lookup = new Lookup($this->tcomp, 'tipcomp', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`descripcion`");
                break;
        }
        $this->tcomp->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tcomp->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
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
            'TEXT' // Edit Tag
        );
        $this->serie->InputTextType = "text";
        $this->serie->Raw = true;
        $this->serie->Nullable = false; // NOT NULL field
        $this->serie->Required = true; // Required field
        $this->serie->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->serie->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['serie'] = &$this->serie;

        // ncomp
        $this->ncomp = new DbField(
            $this, // Table
            'x_ncomp', // Variable name
            'ncomp', // Name
            '`ncomp`', // Expression
            '`ncomp`', // Basic search expression
            3, // Type
            9, // Size
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
        $this->ncomp->Nullable = false; // NOT NULL field
        $this->ncomp->Required = true; // Required field
        $this->ncomp->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ncomp->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['ncomp'] = &$this->ncomp;

        // codban
        $this->codban = new DbField(
            $this, // Table
            'x_codban', // Variable name
            'codban', // Name
            '`codban`', // Expression
            '`codban`', // Basic search expression
            3, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codban`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codban->InputTextType = "text";
        $this->codban->Raw = true;
        $this->codban->setSelectMultiple(false); // Select one
        $this->codban->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codban->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codban->Lookup = new Lookup($this->codban, 'bancos', false, 'codnum', ["nombre","","",""], '', '', [], ["x_codsuc"], [], [], [], [], false, '', '', "`nombre`");
                break;
            default:
                $this->codban->Lookup = new Lookup($this->codban, 'bancos', false, 'codnum', ["nombre","","",""], '', '', [], ["x_codsuc"], [], [], [], [], false, '', '', "`nombre`");
                break;
        }
        $this->codban->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codban->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['codban'] = &$this->codban;

        // codsuc
        $this->codsuc = new DbField(
            $this, // Table
            'x_codsuc', // Variable name
            'codsuc', // Name
            '`codsuc`', // Expression
            '`codsuc`', // Basic search expression
            3, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codsuc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codsuc->InputTextType = "text";
        $this->codsuc->Raw = true;
        $this->codsuc->setSelectMultiple(false); // Select one
        $this->codsuc->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codsuc->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codsuc->Lookup = new Lookup($this->codsuc, 'sucbancos', false, 'codnum', ["nombre","","",""], '', '', ["x_codban"], [], ["codbanco"], ["x_codbanco"], [], [], false, '', '', "`nombre`");
                break;
            default:
                $this->codsuc->Lookup = new Lookup($this->codsuc, 'sucbancos', false, 'codnum', ["nombre","","",""], '', '', ["x_codban"], [], ["codbanco"], ["x_codbanco"], [], [], false, '', '', "`nombre`");
                break;
        }
        $this->codsuc->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codsuc->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['codsuc'] = &$this->codsuc;

        // codcta
        $this->codcta = new DbField(
            $this, // Table
            'x_codcta', // Variable name
            'codcta', // Name
            '`codcta`', // Expression
            '`codcta`', // Basic search expression
            200, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codcta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->codcta->InputTextType = "text";
        $this->codcta->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['codcta'] = &$this->codcta;

        // tipcta
        $this->tipcta = new DbField(
            $this, // Table
            'x_tipcta', // Variable name
            'tipcta', // Name
            '`tipcta`', // Expression
            '`tipcta`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipcta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tipcta->InputTextType = "text";
        $this->tipcta->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipcta'] = &$this->tipcta;

        // codchq
        $this->codchq = new DbField(
            $this, // Table
            'x_codchq', // Variable name
            'codchq', // Name
            '`codchq`', // Expression
            '`codchq`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codchq`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->codchq->InputTextType = "text";
        $this->codchq->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['codchq'] = &$this->codchq;

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
            '`codpais`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codpais->InputTextType = "text";
        $this->codpais->Raw = true;
        $this->codpais->Required = true; // Required field
        $this->codpais->setSelectMultiple(false); // Select one
        $this->codpais->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codpais->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codpais->Lookup = new Lookup($this->codpais, 'paises', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`descripcion`");
                break;
            default:
                $this->codpais->Lookup = new Lookup($this->codpais, 'paises', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`descripcion`");
                break;
        }
        $this->codpais->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codpais->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['codpais'] = &$this->codpais;

        // importe
        $this->importe = new DbField(
            $this, // Table
            'x_importe', // Variable name
            'importe', // Name
            '`importe`', // Expression
            '`importe`', // Basic search expression
            131, // Type
            14, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`importe`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->importe->addMethod("getDefault", fn() => 0.00);
        $this->importe->InputTextType = "text";
        $this->importe->Raw = true;
        $this->importe->Nullable = false; // NOT NULL field
        $this->importe->Required = true; // Required field
        $this->importe->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->importe->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['importe'] = &$this->importe;

        // fechaemis
        $this->fechaemis = new DbField(
            $this, // Table
            'x_fechaemis', // Variable name
            'fechaemis', // Name
            '`fechaemis`', // Expression
            CastDateFieldForLike("`fechaemis`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fechaemis`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechaemis->InputTextType = "text";
        $this->fechaemis->Raw = true;
        $this->fechaemis->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fechaemis->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fechaemis'] = &$this->fechaemis;

        // fechapago
        $this->fechapago = new DbField(
            $this, // Table
            'x_fechapago', // Variable name
            'fechapago', // Name
            '`fechapago`', // Expression
            CastDateFieldForLike("`fechapago`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fechapago`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechapago->InputTextType = "text";
        $this->fechapago->Raw = true;
        $this->fechapago->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fechapago->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fechapago'] = &$this->fechapago;

        // entrego
        $this->entrego = new DbField(
            $this, // Table
            'x_entrego', // Variable name
            'entrego', // Name
            '`entrego`', // Expression
            '`entrego`', // Basic search expression
            3, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`entrego`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->entrego->InputTextType = "text";
        $this->entrego->Raw = true;
        $this->entrego->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->entrego->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['entrego'] = &$this->entrego;

        // recibio
        $this->recibio = new DbField(
            $this, // Table
            'x_recibio', // Variable name
            'recibio', // Name
            '`recibio`', // Expression
            '`recibio`', // Basic search expression
            3, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`recibio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->recibio->InputTextType = "text";
        $this->recibio->Raw = true;
        $this->recibio->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->recibio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['recibio'] = &$this->recibio;

        // fechaingr
        $this->fechaingr = new DbField(
            $this, // Table
            'x_fechaingr', // Variable name
            'fechaingr', // Name
            '`fechaingr`', // Expression
            CastDateFieldForLike("`fechaingr`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fechaingr`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechaingr->InputTextType = "text";
        $this->fechaingr->Raw = true;
        $this->fechaingr->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fechaingr->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fechaingr'] = &$this->fechaingr;

        // fechaentrega
        $this->fechaentrega = new DbField(
            $this, // Table
            'x_fechaentrega', // Variable name
            'fechaentrega', // Name
            '`fechaentrega`', // Expression
            CastDateFieldForLike("`fechaentrega`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fechaentrega`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechaentrega->InputTextType = "text";
        $this->fechaentrega->Raw = true;
        $this->fechaentrega->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fechaentrega->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fechaentrega'] = &$this->fechaentrega;

        // tcomprel
        $this->tcomprel = new DbField(
            $this, // Table
            'x_tcomprel', // Variable name
            'tcomprel', // Name
            '`tcomprel`', // Expression
            '`tcomprel`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tcomprel`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tcomprel->InputTextType = "text";
        $this->tcomprel->Raw = true;
        $this->tcomprel->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tcomprel->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tcomprel'] = &$this->tcomprel;

        // serierel
        $this->serierel = new DbField(
            $this, // Table
            'x_serierel', // Variable name
            'serierel', // Name
            '`serierel`', // Expression
            '`serierel`', // Basic search expression
            3, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`serierel`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->serierel->InputTextType = "text";
        $this->serierel->Raw = true;
        $this->serierel->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->serierel->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['serierel'] = &$this->serierel;

        // ncomprel
        $this->ncomprel = new DbField(
            $this, // Table
            'x_ncomprel', // Variable name
            'ncomprel', // Name
            '`ncomprel`', // Expression
            '`ncomprel`', // Basic search expression
            3, // Type
            9, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ncomprel`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ncomprel->InputTextType = "text";
        $this->ncomprel->Raw = true;
        $this->ncomprel->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ncomprel->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['ncomprel'] = &$this->ncomprel;

        // estado
        $this->estado = new DbField(
            $this, // Table
            'x_estado', // Variable name
            'estado', // Name
            '`estado`', // Expression
            '`estado`', // Basic search expression
            200, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->estado->InputTextType = "text";
        $this->estado->Nullable = false; // NOT NULL field
        $this->estado->Required = true; // Required field
        $this->estado->setSelectMultiple(false); // Select one
        $this->estado->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estado->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->estado->Lookup = new Lookup($this->estado, 'cartvalores', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->estado->Lookup = new Lookup($this->estado, 'cartvalores', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->estado->OptionCount = 2;
        $this->estado->SearchOperators = ["=", "<>"];
        $this->Fields['estado'] = &$this->estado;

        // moneda
        $this->moneda = new DbField(
            $this, // Table
            'x_moneda', // Variable name
            'moneda', // Name
            '`moneda`', // Expression
            '`moneda`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`moneda`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->moneda->addMethod("getDefault", fn() => 1);
        $this->moneda->InputTextType = "text";
        $this->moneda->Raw = true;
        $this->moneda->Nullable = false; // NOT NULL field
        $this->moneda->Required = true; // Required field
        $this->moneda->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->moneda->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['moneda'] = &$this->moneda;

        // fechahora
        $this->fechahora = new DbField(
            $this, // Table
            'x_fechahora', // Variable name
            'fechahora', // Name
            '`fechahora`', // Expression
            CastDateFieldForLike("`fechahora`", 11, "DB"), // Basic search expression
            135, // Type
            19, // Size
            11, // Date/Time format
            false, // Is upload field
            '`fechahora`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechahora->InputTextType = "text";
        $this->fechahora->Raw = true;
        $this->fechahora->Nullable = false; // NOT NULL field
        $this->fechahora->DefaultErrorMessage = str_replace("%s", DateFormat(11), $Language->phrase("IncorrectDate"));
        $this->fechahora->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fechahora'] = &$this->fechahora;

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
        $this->usuario->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->usuario->InputTextType = "text";
        $this->usuario->Raw = true;
        $this->usuario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuario'] = &$this->usuario;

        // tcompsal
        $this->tcompsal = new DbField(
            $this, // Table
            'x_tcompsal', // Variable name
            'tcompsal', // Name
            '`tcompsal`', // Expression
            '`tcompsal`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tcompsal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tcompsal->InputTextType = "text";
        $this->tcompsal->Raw = true;
        $this->tcompsal->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tcompsal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tcompsal'] = &$this->tcompsal;

        // seriesal
        $this->seriesal = new DbField(
            $this, // Table
            'x_seriesal', // Variable name
            'seriesal', // Name
            '`seriesal`', // Expression
            '`seriesal`', // Basic search expression
            3, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`seriesal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->seriesal->InputTextType = "text";
        $this->seriesal->Raw = true;
        $this->seriesal->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->seriesal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['seriesal'] = &$this->seriesal;

        // ncompsal
        $this->ncompsal = new DbField(
            $this, // Table
            'x_ncompsal', // Variable name
            'ncompsal', // Name
            '`ncompsal`', // Expression
            '`ncompsal`', // Basic search expression
            3, // Type
            9, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ncompsal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ncompsal->InputTextType = "text";
        $this->ncompsal->Raw = true;
        $this->ncompsal->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ncompsal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['ncompsal'] = &$this->ncompsal;

        // codrem
        $this->codrem = new DbField(
            $this, // Table
            'x_codrem', // Variable name
            'codrem', // Name
            '`codrem`', // Expression
            '`codrem`', // Basic search expression
            3, // Type
            9, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codrem`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codrem->InputTextType = "text";
        $this->codrem->Raw = true;
        $this->codrem->setSelectMultiple(false); // Select one
        $this->codrem->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codrem->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codrem->Lookup = new Lookup($this->codrem, 'remates', false, 'codnum', ["ncomp","direccion","",""], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(`ncomp`, ''),'" . ValueSeparator(1, $this->codrem) . "',COALESCE(`direccion`,''))");
                break;
            default:
                $this->codrem->Lookup = new Lookup($this->codrem, 'remates', false, 'codnum', ["ncomp","direccion","",""], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(`ncomp`, ''),'" . ValueSeparator(1, $this->codrem) . "',COALESCE(`direccion`,''))");
                break;
        }
        $this->codrem->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codrem->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['codrem'] = &$this->codrem;

        // cotiz
        $this->cotiz = new DbField(
            $this, // Table
            'x_cotiz', // Variable name
            'cotiz', // Name
            '`cotiz`', // Expression
            '`cotiz`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cotiz`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cotiz->InputTextType = "text";
        $this->cotiz->Raw = true;
        $this->cotiz->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->cotiz->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['cotiz'] = &$this->cotiz;

        // usurel
        $this->usurel = new DbField(
            $this, // Table
            'x_usurel', // Variable name
            'usurel', // Name
            '`usurel`', // Expression
            '`usurel`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usurel`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->usurel->InputTextType = "text";
        $this->usurel->Raw = true;
        $this->usurel->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usurel->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['usurel'] = &$this->usurel;

        // fecharel
        $this->fecharel = new DbField(
            $this, // Table
            'x_fecharel', // Variable name
            'fecharel', // Name
            '`fecharel`', // Expression
            CastDateFieldForLike("`fecharel`", 11, "DB"), // Basic search expression
            135, // Type
            19, // Size
            11, // Date/Time format
            false, // Is upload field
            '`fecharel`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecharel->InputTextType = "text";
        $this->fecharel->Raw = true;
        $this->fecharel->DefaultErrorMessage = str_replace("%s", DateFormat(11), $Language->phrase("IncorrectDate"));
        $this->fecharel->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecharel'] = &$this->fecharel;

        // ususal
        $this->ususal = new DbField(
            $this, // Table
            'x_ususal', // Variable name
            'ususal', // Name
            '`ususal`', // Expression
            '`ususal`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ususal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ususal->InputTextType = "text";
        $this->ususal->Raw = true;
        $this->ususal->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ususal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['ususal'] = &$this->ususal;

        // fechasal
        $this->fechasal = new DbField(
            $this, // Table
            'x_fechasal', // Variable name
            'fechasal', // Name
            '`fechasal`', // Expression
            CastDateFieldForLike("`fechasal`", 11, "DB"), // Basic search expression
            135, // Type
            19, // Size
            11, // Date/Time format
            false, // Is upload field
            '`fechasal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechasal->InputTextType = "text";
        $this->fechasal->Raw = true;
        $this->fechasal->DefaultErrorMessage = str_replace("%s", DateFormat(11), $Language->phrase("IncorrectDate"));
        $this->fechasal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fechasal'] = &$this->fechasal;

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

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
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

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "cartvalores";
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
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
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
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
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
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
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
        $this->codnum->DbValue = $row['codnum'];
        $this->tcomp->DbValue = $row['tcomp'];
        $this->serie->DbValue = $row['serie'];
        $this->ncomp->DbValue = $row['ncomp'];
        $this->codban->DbValue = $row['codban'];
        $this->codsuc->DbValue = $row['codsuc'];
        $this->codcta->DbValue = $row['codcta'];
        $this->tipcta->DbValue = $row['tipcta'];
        $this->codchq->DbValue = $row['codchq'];
        $this->codpais->DbValue = $row['codpais'];
        $this->importe->DbValue = $row['importe'];
        $this->fechaemis->DbValue = $row['fechaemis'];
        $this->fechapago->DbValue = $row['fechapago'];
        $this->entrego->DbValue = $row['entrego'];
        $this->recibio->DbValue = $row['recibio'];
        $this->fechaingr->DbValue = $row['fechaingr'];
        $this->fechaentrega->DbValue = $row['fechaentrega'];
        $this->tcomprel->DbValue = $row['tcomprel'];
        $this->serierel->DbValue = $row['serierel'];
        $this->ncomprel->DbValue = $row['ncomprel'];
        $this->estado->DbValue = $row['estado'];
        $this->moneda->DbValue = $row['moneda'];
        $this->fechahora->DbValue = $row['fechahora'];
        $this->usuario->DbValue = $row['usuario'];
        $this->tcompsal->DbValue = $row['tcompsal'];
        $this->seriesal->DbValue = $row['seriesal'];
        $this->ncompsal->DbValue = $row['ncompsal'];
        $this->codrem->DbValue = $row['codrem'];
        $this->cotiz->DbValue = $row['cotiz'];
        $this->usurel->DbValue = $row['usurel'];
        $this->fecharel->DbValue = $row['fecharel'];
        $this->ususal->DbValue = $row['ususal'];
        $this->fechasal->DbValue = $row['fechasal'];
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
        return $_SESSION[$name] ?? GetUrl("CartvaloresList");
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
            "CartvaloresView" => $Language->phrase("View"),
            "CartvaloresEdit" => $Language->phrase("Edit"),
            "CartvaloresAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "CartvaloresList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "CartvaloresView",
            Config("API_ADD_ACTION") => "CartvaloresAdd",
            Config("API_EDIT_ACTION") => "CartvaloresEdit",
            Config("API_DELETE_ACTION") => "CartvaloresDelete",
            Config("API_LIST_ACTION") => "CartvaloresList",
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
        return "CartvaloresList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CartvaloresView", $parm);
        } else {
            $url = $this->keyUrl("CartvaloresView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "CartvaloresAdd?" . $parm;
        } else {
            $url = "CartvaloresAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("CartvaloresEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("CartvaloresList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("CartvaloresAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("CartvaloresList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("CartvaloresDelete", $parm);
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
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
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
        $this->codnum->setDbValue($row['codnum']);
        $this->tcomp->setDbValue($row['tcomp']);
        $this->serie->setDbValue($row['serie']);
        $this->ncomp->setDbValue($row['ncomp']);
        $this->codban->setDbValue($row['codban']);
        $this->codsuc->setDbValue($row['codsuc']);
        $this->codcta->setDbValue($row['codcta']);
        $this->tipcta->setDbValue($row['tipcta']);
        $this->codchq->setDbValue($row['codchq']);
        $this->codpais->setDbValue($row['codpais']);
        $this->importe->setDbValue($row['importe']);
        $this->fechaemis->setDbValue($row['fechaemis']);
        $this->fechapago->setDbValue($row['fechapago']);
        $this->entrego->setDbValue($row['entrego']);
        $this->recibio->setDbValue($row['recibio']);
        $this->fechaingr->setDbValue($row['fechaingr']);
        $this->fechaentrega->setDbValue($row['fechaentrega']);
        $this->tcomprel->setDbValue($row['tcomprel']);
        $this->serierel->setDbValue($row['serierel']);
        $this->ncomprel->setDbValue($row['ncomprel']);
        $this->estado->setDbValue($row['estado']);
        $this->moneda->setDbValue($row['moneda']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->usuario->setDbValue($row['usuario']);
        $this->tcompsal->setDbValue($row['tcompsal']);
        $this->seriesal->setDbValue($row['seriesal']);
        $this->ncompsal->setDbValue($row['ncompsal']);
        $this->codrem->setDbValue($row['codrem']);
        $this->cotiz->setDbValue($row['cotiz']);
        $this->usurel->setDbValue($row['usurel']);
        $this->fecharel->setDbValue($row['fecharel']);
        $this->ususal->setDbValue($row['ususal']);
        $this->fechasal->setDbValue($row['fechasal']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "CartvaloresList";
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

        // codnum

        // tcomp

        // serie

        // ncomp

        // codban

        // codsuc

        // codcta

        // tipcta

        // codchq

        // codpais

        // importe

        // fechaemis

        // fechapago

        // entrego

        // recibio

        // fechaingr

        // fechaentrega

        // tcomprel

        // serierel

        // ncomprel

        // estado

        // moneda

        // fechahora

        // usuario

        // tcompsal

        // seriesal

        // ncompsal

        // codrem

        // cotiz

        // usurel

        // fecharel

        // ususal

        // fechasal

        // codnum
        $this->codnum->ViewValue = $this->codnum->CurrentValue;

        // tcomp
        $this->tcomp->ViewValue = $this->tcomp->CurrentValue;
        $curVal = strval($this->tcomp->CurrentValue);
        if ($curVal != "") {
            $this->tcomp->ViewValue = $this->tcomp->lookupCacheOption($curVal);
            if ($this->tcomp->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tcomp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tcomp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->tcomp->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
        $this->serie->ViewValue = $this->serie->CurrentValue;
        $this->serie->ViewValue = FormatNumber($this->serie->ViewValue, $this->serie->formatPattern());

        // ncomp
        $this->ncomp->ViewValue = $this->ncomp->CurrentValue;
        $this->ncomp->ViewValue = FormatNumber($this->ncomp->ViewValue, $this->ncomp->formatPattern());

        // codban
        $curVal = strval($this->codban->CurrentValue);
        if ($curVal != "") {
            $this->codban->ViewValue = $this->codban->lookupCacheOption($curVal);
            if ($this->codban->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->codban->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codban->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->codban->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->codban->Lookup->renderViewRow($rswrk[0]);
                    $this->codban->ViewValue = $this->codban->displayValue($arwrk);
                } else {
                    $this->codban->ViewValue = FormatNumber($this->codban->CurrentValue, $this->codban->formatPattern());
                }
            }
        } else {
            $this->codban->ViewValue = null;
        }

        // codsuc
        $curVal = strval($this->codsuc->CurrentValue);
        if ($curVal != "") {
            $this->codsuc->ViewValue = $this->codsuc->lookupCacheOption($curVal);
            if ($this->codsuc->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->codsuc->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codsuc->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->codsuc->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->codsuc->Lookup->renderViewRow($rswrk[0]);
                    $this->codsuc->ViewValue = $this->codsuc->displayValue($arwrk);
                } else {
                    $this->codsuc->ViewValue = FormatNumber($this->codsuc->CurrentValue, $this->codsuc->formatPattern());
                }
            }
        } else {
            $this->codsuc->ViewValue = null;
        }

        // codcta
        $this->codcta->ViewValue = $this->codcta->CurrentValue;

        // tipcta
        $this->tipcta->ViewValue = $this->tipcta->CurrentValue;

        // codchq
        $this->codchq->ViewValue = $this->codchq->CurrentValue;

        // codpais
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

        // importe
        $this->importe->ViewValue = $this->importe->CurrentValue;
        $this->importe->ViewValue = FormatNumber($this->importe->ViewValue, $this->importe->formatPattern());

        // fechaemis
        $this->fechaemis->ViewValue = $this->fechaemis->CurrentValue;
        $this->fechaemis->ViewValue = FormatDateTime($this->fechaemis->ViewValue, $this->fechaemis->formatPattern());

        // fechapago
        $this->fechapago->ViewValue = $this->fechapago->CurrentValue;
        $this->fechapago->ViewValue = FormatDateTime($this->fechapago->ViewValue, $this->fechapago->formatPattern());

        // entrego
        $this->entrego->ViewValue = $this->entrego->CurrentValue;
        $this->entrego->ViewValue = FormatNumber($this->entrego->ViewValue, $this->entrego->formatPattern());

        // recibio
        $this->recibio->ViewValue = $this->recibio->CurrentValue;
        $this->recibio->ViewValue = FormatNumber($this->recibio->ViewValue, $this->recibio->formatPattern());

        // fechaingr
        $this->fechaingr->ViewValue = $this->fechaingr->CurrentValue;
        $this->fechaingr->ViewValue = FormatDateTime($this->fechaingr->ViewValue, $this->fechaingr->formatPattern());

        // fechaentrega
        $this->fechaentrega->ViewValue = $this->fechaentrega->CurrentValue;
        $this->fechaentrega->ViewValue = FormatDateTime($this->fechaentrega->ViewValue, $this->fechaentrega->formatPattern());

        // tcomprel
        $this->tcomprel->ViewValue = $this->tcomprel->CurrentValue;
        $this->tcomprel->ViewValue = FormatNumber($this->tcomprel->ViewValue, $this->tcomprel->formatPattern());

        // serierel
        $this->serierel->ViewValue = $this->serierel->CurrentValue;
        $this->serierel->ViewValue = FormatNumber($this->serierel->ViewValue, $this->serierel->formatPattern());

        // ncomprel
        $this->ncomprel->ViewValue = $this->ncomprel->CurrentValue;
        $this->ncomprel->ViewValue = FormatNumber($this->ncomprel->ViewValue, $this->ncomprel->formatPattern());

        // estado
        if (strval($this->estado->CurrentValue) != "") {
            $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
        } else {
            $this->estado->ViewValue = null;
        }

        // moneda
        $this->moneda->ViewValue = $this->moneda->CurrentValue;
        $this->moneda->ViewValue = FormatNumber($this->moneda->ViewValue, $this->moneda->formatPattern());

        // fechahora
        $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
        $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

        // usuario
        $this->usuario->ViewValue = $this->usuario->CurrentValue;
        $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

        // tcompsal
        $this->tcompsal->ViewValue = $this->tcompsal->CurrentValue;
        $this->tcompsal->ViewValue = FormatNumber($this->tcompsal->ViewValue, $this->tcompsal->formatPattern());

        // seriesal
        $this->seriesal->ViewValue = $this->seriesal->CurrentValue;
        $this->seriesal->ViewValue = FormatNumber($this->seriesal->ViewValue, $this->seriesal->formatPattern());

        // ncompsal
        $this->ncompsal->ViewValue = $this->ncompsal->CurrentValue;
        $this->ncompsal->ViewValue = FormatNumber($this->ncompsal->ViewValue, $this->ncompsal->formatPattern());

        // codrem
        $curVal = strval($this->codrem->CurrentValue);
        if ($curVal != "") {
            $this->codrem->ViewValue = $this->codrem->lookupCacheOption($curVal);
            if ($this->codrem->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->codrem->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codrem->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->codrem->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->codrem->Lookup->renderViewRow($rswrk[0]);
                    $this->codrem->ViewValue = $this->codrem->displayValue($arwrk);
                } else {
                    $this->codrem->ViewValue = FormatNumber($this->codrem->CurrentValue, $this->codrem->formatPattern());
                }
            }
        } else {
            $this->codrem->ViewValue = null;
        }

        // cotiz
        $this->cotiz->ViewValue = $this->cotiz->CurrentValue;
        $this->cotiz->ViewValue = FormatNumber($this->cotiz->ViewValue, $this->cotiz->formatPattern());

        // usurel
        $this->usurel->ViewValue = $this->usurel->CurrentValue;
        $this->usurel->ViewValue = FormatNumber($this->usurel->ViewValue, $this->usurel->formatPattern());

        // fecharel
        $this->fecharel->ViewValue = $this->fecharel->CurrentValue;
        $this->fecharel->ViewValue = FormatDateTime($this->fecharel->ViewValue, $this->fecharel->formatPattern());

        // ususal
        $this->ususal->ViewValue = $this->ususal->CurrentValue;
        $this->ususal->ViewValue = FormatNumber($this->ususal->ViewValue, $this->ususal->formatPattern());

        // fechasal
        $this->fechasal->ViewValue = $this->fechasal->CurrentValue;
        $this->fechasal->ViewValue = FormatDateTime($this->fechasal->ViewValue, $this->fechasal->formatPattern());

        // codnum
        $this->codnum->HrefValue = "";
        $this->codnum->TooltipValue = "";

        // tcomp
        $this->tcomp->HrefValue = "";
        $this->tcomp->TooltipValue = "";

        // serie
        $this->serie->HrefValue = "";
        $this->serie->TooltipValue = "";

        // ncomp
        $this->ncomp->HrefValue = "";
        $this->ncomp->TooltipValue = "";

        // codban
        $this->codban->HrefValue = "";
        $this->codban->TooltipValue = "";

        // codsuc
        $this->codsuc->HrefValue = "";
        $this->codsuc->TooltipValue = "";

        // codcta
        $this->codcta->HrefValue = "";
        $this->codcta->TooltipValue = "";

        // tipcta
        $this->tipcta->HrefValue = "";
        $this->tipcta->TooltipValue = "";

        // codchq
        $this->codchq->HrefValue = "";
        $this->codchq->TooltipValue = "";

        // codpais
        $this->codpais->HrefValue = "";
        $this->codpais->TooltipValue = "";

        // importe
        $this->importe->HrefValue = "";
        $this->importe->TooltipValue = "";

        // fechaemis
        $this->fechaemis->HrefValue = "";
        $this->fechaemis->TooltipValue = "";

        // fechapago
        $this->fechapago->HrefValue = "";
        $this->fechapago->TooltipValue = "";

        // entrego
        $this->entrego->HrefValue = "";
        $this->entrego->TooltipValue = "";

        // recibio
        $this->recibio->HrefValue = "";
        $this->recibio->TooltipValue = "";

        // fechaingr
        $this->fechaingr->HrefValue = "";
        $this->fechaingr->TooltipValue = "";

        // fechaentrega
        $this->fechaentrega->HrefValue = "";
        $this->fechaentrega->TooltipValue = "";

        // tcomprel
        $this->tcomprel->HrefValue = "";
        $this->tcomprel->TooltipValue = "";

        // serierel
        $this->serierel->HrefValue = "";
        $this->serierel->TooltipValue = "";

        // ncomprel
        $this->ncomprel->HrefValue = "";
        $this->ncomprel->TooltipValue = "";

        // estado
        $this->estado->HrefValue = "";
        $this->estado->TooltipValue = "";

        // moneda
        $this->moneda->HrefValue = "";
        $this->moneda->TooltipValue = "";

        // fechahora
        $this->fechahora->HrefValue = "";
        $this->fechahora->TooltipValue = "";

        // usuario
        $this->usuario->HrefValue = "";
        $this->usuario->TooltipValue = "";

        // tcompsal
        $this->tcompsal->HrefValue = "";
        $this->tcompsal->TooltipValue = "";

        // seriesal
        $this->seriesal->HrefValue = "";
        $this->seriesal->TooltipValue = "";

        // ncompsal
        $this->ncompsal->HrefValue = "";
        $this->ncompsal->TooltipValue = "";

        // codrem
        $this->codrem->HrefValue = "";
        $this->codrem->TooltipValue = "";

        // cotiz
        $this->cotiz->HrefValue = "";
        $this->cotiz->TooltipValue = "";

        // usurel
        $this->usurel->HrefValue = "";
        $this->usurel->TooltipValue = "";

        // fecharel
        $this->fecharel->HrefValue = "";
        $this->fecharel->TooltipValue = "";

        // ususal
        $this->ususal->HrefValue = "";
        $this->ususal->TooltipValue = "";

        // fechasal
        $this->fechasal->HrefValue = "";
        $this->fechasal->TooltipValue = "";

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

        // codnum
        $this->codnum->setupEditAttributes();
        $this->codnum->EditValue = $this->codnum->CurrentValue;

        // tcomp
        $this->tcomp->setupEditAttributes();
        $this->tcomp->EditValue = $this->tcomp->CurrentValue;
        $this->tcomp->PlaceHolder = RemoveHtml($this->tcomp->caption());

        // serie
        $this->serie->setupEditAttributes();
        $this->serie->EditValue = $this->serie->CurrentValue;
        $this->serie->PlaceHolder = RemoveHtml($this->serie->caption());
        if (strval($this->serie->EditValue) != "" && is_numeric($this->serie->EditValue)) {
            $this->serie->EditValue = FormatNumber($this->serie->EditValue, null);
        }

        // ncomp
        $this->ncomp->setupEditAttributes();
        $this->ncomp->EditValue = $this->ncomp->CurrentValue;
        $this->ncomp->PlaceHolder = RemoveHtml($this->ncomp->caption());
        if (strval($this->ncomp->EditValue) != "" && is_numeric($this->ncomp->EditValue)) {
            $this->ncomp->EditValue = FormatNumber($this->ncomp->EditValue, null);
        }

        // codban
        $this->codban->setupEditAttributes();
        $this->codban->PlaceHolder = RemoveHtml($this->codban->caption());

        // codsuc
        $this->codsuc->setupEditAttributes();
        $this->codsuc->PlaceHolder = RemoveHtml($this->codsuc->caption());

        // codcta
        $this->codcta->setupEditAttributes();
        if (!$this->codcta->Raw) {
            $this->codcta->CurrentValue = HtmlDecode($this->codcta->CurrentValue);
        }
        $this->codcta->EditValue = $this->codcta->CurrentValue;
        $this->codcta->PlaceHolder = RemoveHtml($this->codcta->caption());

        // tipcta
        $this->tipcta->setupEditAttributes();
        if (!$this->tipcta->Raw) {
            $this->tipcta->CurrentValue = HtmlDecode($this->tipcta->CurrentValue);
        }
        $this->tipcta->EditValue = $this->tipcta->CurrentValue;
        $this->tipcta->PlaceHolder = RemoveHtml($this->tipcta->caption());

        // codchq
        $this->codchq->setupEditAttributes();
        if (!$this->codchq->Raw) {
            $this->codchq->CurrentValue = HtmlDecode($this->codchq->CurrentValue);
        }
        $this->codchq->EditValue = $this->codchq->CurrentValue;
        $this->codchq->PlaceHolder = RemoveHtml($this->codchq->caption());

        // codpais
        $this->codpais->setupEditAttributes();
        $this->codpais->PlaceHolder = RemoveHtml($this->codpais->caption());

        // importe
        $this->importe->setupEditAttributes();
        $this->importe->EditValue = $this->importe->CurrentValue;
        $this->importe->PlaceHolder = RemoveHtml($this->importe->caption());
        if (strval($this->importe->EditValue) != "" && is_numeric($this->importe->EditValue)) {
            $this->importe->EditValue = FormatNumber($this->importe->EditValue, null);
        }

        // fechaemis
        $this->fechaemis->setupEditAttributes();
        $this->fechaemis->EditValue = FormatDateTime($this->fechaemis->CurrentValue, $this->fechaemis->formatPattern());
        $this->fechaemis->PlaceHolder = RemoveHtml($this->fechaemis->caption());

        // fechapago
        $this->fechapago->setupEditAttributes();
        $this->fechapago->EditValue = FormatDateTime($this->fechapago->CurrentValue, $this->fechapago->formatPattern());
        $this->fechapago->PlaceHolder = RemoveHtml($this->fechapago->caption());

        // entrego
        $this->entrego->setupEditAttributes();
        $this->entrego->EditValue = $this->entrego->CurrentValue;
        $this->entrego->PlaceHolder = RemoveHtml($this->entrego->caption());
        if (strval($this->entrego->EditValue) != "" && is_numeric($this->entrego->EditValue)) {
            $this->entrego->EditValue = FormatNumber($this->entrego->EditValue, null);
        }

        // recibio
        $this->recibio->setupEditAttributes();
        $this->recibio->EditValue = $this->recibio->CurrentValue;
        $this->recibio->PlaceHolder = RemoveHtml($this->recibio->caption());
        if (strval($this->recibio->EditValue) != "" && is_numeric($this->recibio->EditValue)) {
            $this->recibio->EditValue = FormatNumber($this->recibio->EditValue, null);
        }

        // fechaingr
        $this->fechaingr->setupEditAttributes();
        $this->fechaingr->EditValue = FormatDateTime($this->fechaingr->CurrentValue, $this->fechaingr->formatPattern());
        $this->fechaingr->PlaceHolder = RemoveHtml($this->fechaingr->caption());

        // fechaentrega
        $this->fechaentrega->setupEditAttributes();
        $this->fechaentrega->EditValue = FormatDateTime($this->fechaentrega->CurrentValue, $this->fechaentrega->formatPattern());
        $this->fechaentrega->PlaceHolder = RemoveHtml($this->fechaentrega->caption());

        // tcomprel
        $this->tcomprel->setupEditAttributes();
        $this->tcomprel->EditValue = $this->tcomprel->CurrentValue;
        $this->tcomprel->PlaceHolder = RemoveHtml($this->tcomprel->caption());
        if (strval($this->tcomprel->EditValue) != "" && is_numeric($this->tcomprel->EditValue)) {
            $this->tcomprel->EditValue = FormatNumber($this->tcomprel->EditValue, null);
        }

        // serierel
        $this->serierel->setupEditAttributes();
        $this->serierel->EditValue = $this->serierel->CurrentValue;
        $this->serierel->PlaceHolder = RemoveHtml($this->serierel->caption());
        if (strval($this->serierel->EditValue) != "" && is_numeric($this->serierel->EditValue)) {
            $this->serierel->EditValue = FormatNumber($this->serierel->EditValue, null);
        }

        // ncomprel
        $this->ncomprel->setupEditAttributes();
        $this->ncomprel->EditValue = $this->ncomprel->CurrentValue;
        $this->ncomprel->PlaceHolder = RemoveHtml($this->ncomprel->caption());
        if (strval($this->ncomprel->EditValue) != "" && is_numeric($this->ncomprel->EditValue)) {
            $this->ncomprel->EditValue = FormatNumber($this->ncomprel->EditValue, null);
        }

        // estado
        $this->estado->setupEditAttributes();
        $this->estado->EditValue = $this->estado->options(true);
        $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

        // moneda
        $this->moneda->setupEditAttributes();
        $this->moneda->EditValue = $this->moneda->CurrentValue;
        $this->moneda->PlaceHolder = RemoveHtml($this->moneda->caption());
        if (strval($this->moneda->EditValue) != "" && is_numeric($this->moneda->EditValue)) {
            $this->moneda->EditValue = FormatNumber($this->moneda->EditValue, null);
        }

        // fechahora
        $this->fechahora->setupEditAttributes();
        $this->fechahora->EditValue = FormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        $this->fechahora->PlaceHolder = RemoveHtml($this->fechahora->caption());

        // usuario

        // tcompsal
        $this->tcompsal->setupEditAttributes();
        $this->tcompsal->EditValue = $this->tcompsal->CurrentValue;
        $this->tcompsal->PlaceHolder = RemoveHtml($this->tcompsal->caption());
        if (strval($this->tcompsal->EditValue) != "" && is_numeric($this->tcompsal->EditValue)) {
            $this->tcompsal->EditValue = FormatNumber($this->tcompsal->EditValue, null);
        }

        // seriesal
        $this->seriesal->setupEditAttributes();
        $this->seriesal->EditValue = $this->seriesal->CurrentValue;
        $this->seriesal->PlaceHolder = RemoveHtml($this->seriesal->caption());
        if (strval($this->seriesal->EditValue) != "" && is_numeric($this->seriesal->EditValue)) {
            $this->seriesal->EditValue = FormatNumber($this->seriesal->EditValue, null);
        }

        // ncompsal
        $this->ncompsal->setupEditAttributes();
        $this->ncompsal->EditValue = $this->ncompsal->CurrentValue;
        $this->ncompsal->PlaceHolder = RemoveHtml($this->ncompsal->caption());
        if (strval($this->ncompsal->EditValue) != "" && is_numeric($this->ncompsal->EditValue)) {
            $this->ncompsal->EditValue = FormatNumber($this->ncompsal->EditValue, null);
        }

        // codrem
        $this->codrem->setupEditAttributes();
        $this->codrem->PlaceHolder = RemoveHtml($this->codrem->caption());

        // cotiz
        $this->cotiz->setupEditAttributes();
        $this->cotiz->EditValue = $this->cotiz->CurrentValue;
        $this->cotiz->PlaceHolder = RemoveHtml($this->cotiz->caption());
        if (strval($this->cotiz->EditValue) != "" && is_numeric($this->cotiz->EditValue)) {
            $this->cotiz->EditValue = FormatNumber($this->cotiz->EditValue, null);
        }

        // usurel
        $this->usurel->setupEditAttributes();
        $this->usurel->EditValue = $this->usurel->CurrentValue;
        $this->usurel->PlaceHolder = RemoveHtml($this->usurel->caption());
        if (strval($this->usurel->EditValue) != "" && is_numeric($this->usurel->EditValue)) {
            $this->usurel->EditValue = FormatNumber($this->usurel->EditValue, null);
        }

        // fecharel
        $this->fecharel->setupEditAttributes();
        $this->fecharel->EditValue = FormatDateTime($this->fecharel->CurrentValue, $this->fecharel->formatPattern());
        $this->fecharel->PlaceHolder = RemoveHtml($this->fecharel->caption());

        // ususal
        $this->ususal->setupEditAttributes();
        $this->ususal->EditValue = $this->ususal->CurrentValue;
        $this->ususal->PlaceHolder = RemoveHtml($this->ususal->caption());
        if (strval($this->ususal->EditValue) != "" && is_numeric($this->ususal->EditValue)) {
            $this->ususal->EditValue = FormatNumber($this->ususal->EditValue, null);
        }

        // fechasal
        $this->fechasal->setupEditAttributes();
        $this->fechasal->EditValue = FormatDateTime($this->fechasal->CurrentValue, $this->fechasal->formatPattern());
        $this->fechasal->PlaceHolder = RemoveHtml($this->fechasal->caption());

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
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->tcomp);
                    $doc->exportCaption($this->serie);
                    $doc->exportCaption($this->ncomp);
                    $doc->exportCaption($this->codban);
                    $doc->exportCaption($this->codsuc);
                    $doc->exportCaption($this->codcta);
                    $doc->exportCaption($this->tipcta);
                    $doc->exportCaption($this->codchq);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->importe);
                    $doc->exportCaption($this->fechaemis);
                    $doc->exportCaption($this->fechapago);
                    $doc->exportCaption($this->entrego);
                    $doc->exportCaption($this->recibio);
                    $doc->exportCaption($this->fechaingr);
                    $doc->exportCaption($this->fechaentrega);
                    $doc->exportCaption($this->tcomprel);
                    $doc->exportCaption($this->serierel);
                    $doc->exportCaption($this->ncomprel);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->moneda);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->tcompsal);
                    $doc->exportCaption($this->seriesal);
                    $doc->exportCaption($this->ncompsal);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->cotiz);
                    $doc->exportCaption($this->usurel);
                    $doc->exportCaption($this->fecharel);
                    $doc->exportCaption($this->ususal);
                    $doc->exportCaption($this->fechasal);
                } else {
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->tcomp);
                    $doc->exportCaption($this->serie);
                    $doc->exportCaption($this->ncomp);
                    $doc->exportCaption($this->codban);
                    $doc->exportCaption($this->codsuc);
                    $doc->exportCaption($this->codcta);
                    $doc->exportCaption($this->tipcta);
                    $doc->exportCaption($this->codchq);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->importe);
                    $doc->exportCaption($this->fechaemis);
                    $doc->exportCaption($this->fechapago);
                    $doc->exportCaption($this->entrego);
                    $doc->exportCaption($this->recibio);
                    $doc->exportCaption($this->fechaingr);
                    $doc->exportCaption($this->fechaentrega);
                    $doc->exportCaption($this->tcomprel);
                    $doc->exportCaption($this->serierel);
                    $doc->exportCaption($this->ncomprel);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->moneda);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->tcompsal);
                    $doc->exportCaption($this->seriesal);
                    $doc->exportCaption($this->ncompsal);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->cotiz);
                    $doc->exportCaption($this->usurel);
                    $doc->exportCaption($this->fecharel);
                    $doc->exportCaption($this->ususal);
                    $doc->exportCaption($this->fechasal);
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
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->tcomp);
                        $doc->exportField($this->serie);
                        $doc->exportField($this->ncomp);
                        $doc->exportField($this->codban);
                        $doc->exportField($this->codsuc);
                        $doc->exportField($this->codcta);
                        $doc->exportField($this->tipcta);
                        $doc->exportField($this->codchq);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->importe);
                        $doc->exportField($this->fechaemis);
                        $doc->exportField($this->fechapago);
                        $doc->exportField($this->entrego);
                        $doc->exportField($this->recibio);
                        $doc->exportField($this->fechaingr);
                        $doc->exportField($this->fechaentrega);
                        $doc->exportField($this->tcomprel);
                        $doc->exportField($this->serierel);
                        $doc->exportField($this->ncomprel);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->moneda);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->tcompsal);
                        $doc->exportField($this->seriesal);
                        $doc->exportField($this->ncompsal);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->cotiz);
                        $doc->exportField($this->usurel);
                        $doc->exportField($this->fecharel);
                        $doc->exportField($this->ususal);
                        $doc->exportField($this->fechasal);
                    } else {
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->tcomp);
                        $doc->exportField($this->serie);
                        $doc->exportField($this->ncomp);
                        $doc->exportField($this->codban);
                        $doc->exportField($this->codsuc);
                        $doc->exportField($this->codcta);
                        $doc->exportField($this->tipcta);
                        $doc->exportField($this->codchq);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->importe);
                        $doc->exportField($this->fechaemis);
                        $doc->exportField($this->fechapago);
                        $doc->exportField($this->entrego);
                        $doc->exportField($this->recibio);
                        $doc->exportField($this->fechaingr);
                        $doc->exportField($this->fechaentrega);
                        $doc->exportField($this->tcomprel);
                        $doc->exportField($this->serierel);
                        $doc->exportField($this->ncomprel);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->moneda);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->tcompsal);
                        $doc->exportField($this->seriesal);
                        $doc->exportField($this->ncompsal);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->cotiz);
                        $doc->exportField($this->usurel);
                        $doc->exportField($this->fecharel);
                        $doc->exportField($this->ususal);
                        $doc->exportField($this->fechasal);
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

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
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
