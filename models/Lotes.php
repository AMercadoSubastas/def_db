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
 * Table class for lotes
 */
class Lotes extends DbTable
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
    public $ModalView = true;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $codnum;
    public $codrem;
    public $codcli;
    public $codrubro;
    public $estado;
    public $moneda;
    public $preciobase;
    public $preciofinal;
    public $comiscobr;
    public $comispag;
    public $comprador;
    public $ivari;
    public $ivarni;
    public $codimpadic;
    public $impadic;
    public $descripcion;
    public $descor;
    public $observ;
    public $usuario;
    public $fecalta;
    public $secuencia;
    public $codintlote;
    public $codintnum;
    public $codintsublote;
    public $usuarioultmod;
    public $fecultmod;
    public $dir_secuencia;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "lotes";
        $this->TableName = 'lotes';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "lotes";
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
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
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
            'HIDDEN' // Edit Tag
        );
        $this->codnum->InputTextType = "text";
        $this->codnum->Raw = true;
        $this->codnum->IsAutoIncrement = true; // Autoincrement field
        $this->codnum->IsPrimaryKey = true; // Primary key field
        $this->codnum->Nullable = false; // NOT NULL field
        $this->codnum->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codnum->SearchOperators = ["=", "<>"];
        $this->Fields['codnum'] = &$this->codnum;

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
            'TEXT' // Edit Tag
        );
        $this->codrem->InputTextType = "text";
        $this->codrem->Raw = true;
        $this->codrem->IsForeignKey = true; // Foreign key field
        $this->codrem->Nullable = false; // NOT NULL field
        $this->codrem->Required = true; // Required field
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codrem->Lookup = new Lookup($this->codrem, 'remates', false, 'ncomp', ["ncomp","observacion","",""], '', '', [], [], [], [], [], [], false, '`ncomp` DESC', '', "CONCAT(COALESCE(`ncomp`, ''),'" . ValueSeparator(1, $this->codrem) . "',COALESCE(`observacion`,''))");
                break;
            default:
                $this->codrem->Lookup = new Lookup($this->codrem, 'remates', false, 'ncomp', ["ncomp","observacion","",""], '', '', [], [], [], [], [], [], false, '`ncomp` DESC', '', "CONCAT(COALESCE(`ncomp`, ''),'" . ValueSeparator(1, $this->codrem) . "',COALESCE(`observacion`,''))");
                break;
        }
        $this->codrem->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codrem->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codrem'] = &$this->codrem;

        // codcli
        $this->codcli = new DbField(
            $this, // Table
            'x_codcli', // Variable name
            'codcli', // Name
            '`codcli`', // Expression
            '`codcli`', // Basic search expression
            3, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codcli`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->codcli->InputTextType = "text";
        $this->codcli->Raw = true;
        $this->codcli->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codcli->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['codcli'] = &$this->codcli;

        // codrubro
        $this->codrubro = new DbField(
            $this, // Table
            'x_codrubro', // Variable name
            'codrubro', // Name
            '`codrubro`', // Expression
            '`codrubro`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codrubro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->codrubro->InputTextType = "text";
        $this->codrubro->Raw = true;
        $this->codrubro->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codrubro->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['codrubro'] = &$this->codrubro;

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
            'RADIO' // Edit Tag
        );
        $this->estado->addMethod("getDefault", fn() => 0);
        $this->estado->InputTextType = "text";
        $this->estado->Raw = true;
        $this->estado->Nullable = false; // NOT NULL field
        $this->estado->Required = true; // Required field
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->estado->Lookup = new Lookup($this->estado, 'lotes', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->estado->Lookup = new Lookup($this->estado, 'lotes', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->estado->OptionCount = 2;
        $this->estado->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->estado->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
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
            'HIDDEN' // Edit Tag
        );
        $this->moneda->addMethod("getDefault", fn() => 1);
        $this->moneda->InputTextType = "text";
        $this->moneda->Raw = true;
        $this->moneda->Nullable = false; // NOT NULL field
        $this->moneda->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->moneda->SearchOperators = ["=", "<>"];
        $this->Fields['moneda'] = &$this->moneda;

        // preciobase
        $this->preciobase = new DbField(
            $this, // Table
            'x_preciobase', // Variable name
            'preciobase', // Name
            '`preciobase`', // Expression
            '`preciobase`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`preciobase`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->preciobase->addMethod("getDefault", fn() => 0);
        $this->preciobase->InputTextType = "text";
        $this->preciobase->Raw = true;
        $this->preciobase->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->preciobase->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['preciobase'] = &$this->preciobase;

        // preciofinal
        $this->preciofinal = new DbField(
            $this, // Table
            'x_preciofinal', // Variable name
            'preciofinal', // Name
            '`preciofinal`', // Expression
            '`preciofinal`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`preciofinal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->preciofinal->addMethod("getDefault", fn() => 0);
        $this->preciofinal->InputTextType = "text";
        $this->preciofinal->Raw = true;
        $this->preciofinal->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->preciofinal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['preciofinal'] = &$this->preciofinal;

        // comiscobr
        $this->comiscobr = new DbField(
            $this, // Table
            'x_comiscobr', // Variable name
            'comiscobr', // Name
            '`comiscobr`', // Expression
            '`comiscobr`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`comiscobr`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->comiscobr->addMethod("getDefault", fn() => 10);
        $this->comiscobr->InputTextType = "text";
        $this->comiscobr->Raw = true;
        $this->comiscobr->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->comiscobr->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['comiscobr'] = &$this->comiscobr;

        // comispag
        $this->comispag = new DbField(
            $this, // Table
            'x_comispag', // Variable name
            'comispag', // Name
            '`comispag`', // Expression
            '`comispag`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`comispag`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->comispag->addMethod("getDefault", fn() => 0);
        $this->comispag->InputTextType = "text";
        $this->comispag->Raw = true;
        $this->comispag->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->comispag->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['comispag'] = &$this->comispag;

        // comprador
        $this->comprador = new DbField(
            $this, // Table
            'x_comprador', // Variable name
            'comprador', // Name
            '`comprador`', // Expression
            '`comprador`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`comprador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->comprador->InputTextType = "text";
        $this->comprador->Raw = true;
        $this->comprador->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->comprador->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['comprador'] = &$this->comprador;

        // ivari
        $this->ivari = new DbField(
            $this, // Table
            'x_ivari', // Variable name
            'ivari', // Name
            '`ivari`', // Expression
            '`ivari`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ivari`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->ivari->InputTextType = "text";
        $this->ivari->Raw = true;
        $this->ivari->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->ivari->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['ivari'] = &$this->ivari;

        // ivarni
        $this->ivarni = new DbField(
            $this, // Table
            'x_ivarni', // Variable name
            'ivarni', // Name
            '`ivarni`', // Expression
            '`ivarni`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ivarni`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->ivarni->InputTextType = "text";
        $this->ivarni->Raw = true;
        $this->ivarni->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->ivarni->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['ivarni'] = &$this->ivarni;

        // codimpadic
        $this->codimpadic = new DbField(
            $this, // Table
            'x_codimpadic', // Variable name
            'codimpadic', // Name
            '`codimpadic`', // Expression
            '`codimpadic`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codimpadic`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->codimpadic->InputTextType = "text";
        $this->codimpadic->Raw = true;
        $this->codimpadic->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codimpadic->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['codimpadic'] = &$this->codimpadic;

        // impadic
        $this->impadic = new DbField(
            $this, // Table
            'x_impadic', // Variable name
            'impadic', // Name
            '`impadic`', // Expression
            '`impadic`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`impadic`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->impadic->InputTextType = "text";
        $this->impadic->Raw = true;
        $this->impadic->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->impadic->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['impadic'] = &$this->impadic;

        // descripcion
        $this->descripcion = new DbField(
            $this, // Table
            'x_descripcion', // Variable name
            'descripcion', // Name
            '`descripcion`', // Expression
            '`descripcion`', // Basic search expression
            200, // Type
            2000, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`descripcion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->descripcion->InputTextType = "text";
        $this->descripcion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['descripcion'] = &$this->descripcion;

        // descor
        $this->descor = new DbField(
            $this, // Table
            'x_descor', // Variable name
            'descor', // Name
            '`descor`', // Expression
            '`descor`', // Basic search expression
            200, // Type
            300, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`descor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->descor->InputTextType = "text";
        $this->descor->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['descor'] = &$this->descor;

        // observ
        $this->observ = new DbField(
            $this, // Table
            'x_observ', // Variable name
            'observ', // Name
            '`observ`', // Expression
            '`observ`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`observ`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->observ->InputTextType = "text";
        $this->observ->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['observ'] = &$this->observ;

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
            'HIDDEN' // Edit Tag
        );
        $this->usuario->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->usuario->InputTextType = "text";
        $this->usuario->Raw = true;
        $this->usuario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
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
            'HIDDEN' // Edit Tag
        );
        $this->fecalta->addMethod("getAutoUpdateValue", fn() => CurrentDate());
        $this->fecalta->InputTextType = "text";
        $this->fecalta->Raw = true;
        $this->fecalta->Nullable = false; // NOT NULL field
        $this->fecalta->DefaultErrorMessage = str_replace("%s", DateFormat(11), $Language->phrase("IncorrectDate"));
        $this->fecalta->SearchOperators = ["=", "<>"];
        $this->Fields['fecalta'] = &$this->fecalta;

        // secuencia
        $this->secuencia = new DbField(
            $this, // Table
            'x_secuencia', // Variable name
            'secuencia', // Name
            '`secuencia`', // Expression
            '`secuencia`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`secuencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->secuencia->addMethod("getSearchDefault", fn() => 0);
        $this->secuencia->InputTextType = "text";
        $this->secuencia->Raw = true;
        $this->secuencia->Nullable = false; // NOT NULL field
        $this->secuencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->secuencia->SearchOperators = ["=", "<>"];
        $this->secuencia->AdvancedSearch->SearchValueDefault = $this->secuencia->getSearchDefault();
        $this->secuencia->AdvancedSearch->SearchOperatorDefault = "=";
        $this->secuencia->AdvancedSearch->SearchOperator2Default = "";
        $this->secuencia->AdvancedSearch->SearchConditionDefault = "AND";
        $this->Fields['secuencia'] = &$this->secuencia;

        // codintlote
        $this->codintlote = new DbField(
            $this, // Table
            'x_codintlote', // Variable name
            'codintlote', // Name
            '`codintlote`', // Expression
            '`codintlote`', // Basic search expression
            200, // Type
            8, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codintlote`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->codintlote->InputTextType = "text";
        $this->codintlote->Nullable = false; // NOT NULL field
        $this->codintlote->Required = true; // Required field
        $this->codintlote->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['codintlote'] = &$this->codintlote;

        // codintnum
        $this->codintnum = new DbField(
            $this, // Table
            'x_codintnum', // Variable name
            'codintnum', // Name
            '`codintnum`', // Expression
            '`codintnum`', // Basic search expression
            3, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codintnum`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->codintnum->InputTextType = "text";
        $this->codintnum->Raw = true;
        $this->codintnum->Nullable = false; // NOT NULL field
        $this->codintnum->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codintnum->SearchOperators = ["=", "<>"];
        $this->Fields['codintnum'] = &$this->codintnum;

        // codintsublote
        $this->codintsublote = new DbField(
            $this, // Table
            'x_codintsublote', // Variable name
            'codintsublote', // Name
            '`codintsublote`', // Expression
            '`codintsublote`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codintsublote`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->codintsublote->InputTextType = "text";
        $this->codintsublote->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['codintsublote'] = &$this->codintsublote;

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
            'HIDDEN' // Edit Tag
        );
        $this->usuarioultmod->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->usuarioultmod->InputTextType = "text";
        $this->usuarioultmod->Raw = true;
        $this->usuarioultmod->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuarioultmod->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
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
            'HIDDEN' // Edit Tag
        );
        $this->fecultmod->addMethod("getAutoUpdateValue", fn() => CurrentDateTime());
        $this->fecultmod->InputTextType = "text";
        $this->fecultmod->Raw = true;
        $this->fecultmod->DefaultErrorMessage = str_replace("%s", DateFormat(11), $Language->phrase("IncorrectDate"));
        $this->fecultmod->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecultmod'] = &$this->fecultmod;

        // dir_secuencia
        $this->dir_secuencia = new DbField(
            $this, // Table
            'x_dir_secuencia', // Variable name
            'dir_secuencia', // Name
            '`dir_secuencia`', // Expression
            '`dir_secuencia`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`dir_secuencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->dir_secuencia->InputTextType = "text";
        $this->dir_secuencia->Raw = true;
        $this->dir_secuencia->Required = true; // Required field
        $this->dir_secuencia->setSelectMultiple(false); // Select one
        $this->dir_secuencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->dir_secuencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->dir_secuencia->Lookup = new Lookup($this->dir_secuencia, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`descripcion`");
                break;
            default:
                $this->dir_secuencia->Lookup = new Lookup($this->dir_secuencia, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`descripcion`");
                break;
        }
        $this->dir_secuencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->dir_secuencia->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['dir_secuencia'] = &$this->dir_secuencia;

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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "remates") {
            $masterTable = Container("remates");
            if ($this->codrem->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->ncomp, $this->codrem->getSessionValue(), $masterTable->ncomp->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "remates") {
            $masterTable = Container("remates");
            if ($this->codrem->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->codrem, $this->codrem->getSessionValue(), $masterTable->ncomp->DataType, $this->Dbid);
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "remates":
                $key = $keys["codrem"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->ncomp->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->ncomp, $keys["codrem"], $this->codrem->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "remates":
                return GetKeyFilter($this->codrem, $masterTable->ncomp->DbValue, $masterTable->ncomp->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "lotes";
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
                return ($allow & Allow::ADD) == Allow::ADD;
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return ($allow & Allow::EDIT) == Allow::EDIT;
            case "delete":
                return ($allow & Allow::DELETE) == Allow::DELETE;
            case "view":
                return ($allow & Allow::VIEW) == Allow::VIEW;
            case "search":
                return ($allow & Allow::SEARCH) == Allow::SEARCH;
            case "lookup":
                return ($allow & Allow::LOOKUP) == Allow::LOOKUP;
            default:
                return ($allow & Allow::LIST) == Allow::LIST;
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
        $this->codrem->DbValue = $row['codrem'];
        $this->codcli->DbValue = $row['codcli'];
        $this->codrubro->DbValue = $row['codrubro'];
        $this->estado->DbValue = $row['estado'];
        $this->moneda->DbValue = $row['moneda'];
        $this->preciobase->DbValue = $row['preciobase'];
        $this->preciofinal->DbValue = $row['preciofinal'];
        $this->comiscobr->DbValue = $row['comiscobr'];
        $this->comispag->DbValue = $row['comispag'];
        $this->comprador->DbValue = $row['comprador'];
        $this->ivari->DbValue = $row['ivari'];
        $this->ivarni->DbValue = $row['ivarni'];
        $this->codimpadic->DbValue = $row['codimpadic'];
        $this->impadic->DbValue = $row['impadic'];
        $this->descripcion->DbValue = $row['descripcion'];
        $this->descor->DbValue = $row['descor'];
        $this->observ->DbValue = $row['observ'];
        $this->usuario->DbValue = $row['usuario'];
        $this->fecalta->DbValue = $row['fecalta'];
        $this->secuencia->DbValue = $row['secuencia'];
        $this->codintlote->DbValue = $row['codintlote'];
        $this->codintnum->DbValue = $row['codintnum'];
        $this->codintsublote->DbValue = $row['codintsublote'];
        $this->usuarioultmod->DbValue = $row['usuarioultmod'];
        $this->fecultmod->DbValue = $row['fecultmod'];
        $this->dir_secuencia->DbValue = $row['dir_secuencia'];
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
        return $_SESSION[$name] ?? GetUrl("LotesList");
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
            "LotesView" => $Language->phrase("View"),
            "LotesEdit" => $Language->phrase("Edit"),
            "LotesAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "LotesList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "LotesView",
            Config("API_ADD_ACTION") => "LotesAdd",
            Config("API_EDIT_ACTION") => "LotesEdit",
            Config("API_DELETE_ACTION") => "LotesDelete",
            Config("API_LIST_ACTION") => "LotesList",
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
        return "LotesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("LotesView", $parm);
        } else {
            $url = $this->keyUrl("LotesView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "LotesAdd?" . $parm;
        } else {
            $url = "LotesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("LotesEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("LotesList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("LotesAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("LotesList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("LotesDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "remates" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_ncomp", $this->codrem->getSessionValue()); // Use Session Value
        }
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
        $this->codrem->setDbValue($row['codrem']);
        $this->codcli->setDbValue($row['codcli']);
        $this->codrubro->setDbValue($row['codrubro']);
        $this->estado->setDbValue($row['estado']);
        $this->moneda->setDbValue($row['moneda']);
        $this->preciobase->setDbValue($row['preciobase']);
        $this->preciofinal->setDbValue($row['preciofinal']);
        $this->comiscobr->setDbValue($row['comiscobr']);
        $this->comispag->setDbValue($row['comispag']);
        $this->comprador->setDbValue($row['comprador']);
        $this->ivari->setDbValue($row['ivari']);
        $this->ivarni->setDbValue($row['ivarni']);
        $this->codimpadic->setDbValue($row['codimpadic']);
        $this->impadic->setDbValue($row['impadic']);
        $this->descripcion->setDbValue($row['descripcion']);
        $this->descor->setDbValue($row['descor']);
        $this->observ->setDbValue($row['observ']);
        $this->usuario->setDbValue($row['usuario']);
        $this->fecalta->setDbValue($row['fecalta']);
        $this->secuencia->setDbValue($row['secuencia']);
        $this->codintlote->setDbValue($row['codintlote']);
        $this->codintnum->setDbValue($row['codintnum']);
        $this->codintsublote->setDbValue($row['codintsublote']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
        $this->dir_secuencia->setDbValue($row['dir_secuencia']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "LotesList";
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

        // codrem

        // codcli

        // codrubro

        // estado

        // moneda

        // preciobase

        // preciofinal

        // comiscobr

        // comispag

        // comprador

        // ivari

        // ivarni

        // codimpadic

        // impadic

        // descripcion

        // descor

        // observ

        // usuario

        // fecalta

        // secuencia

        // codintlote

        // codintnum

        // codintsublote

        // usuarioultmod

        // fecultmod

        // dir_secuencia

        // codnum
        $this->codnum->ViewValue = $this->codnum->CurrentValue;

        // codrem
        $this->codrem->ViewValue = $this->codrem->CurrentValue;
        $curVal = strval($this->codrem->CurrentValue);
        if ($curVal != "") {
            $this->codrem->ViewValue = $this->codrem->lookupCacheOption($curVal);
            if ($this->codrem->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->codrem->Lookup->getTable()->Fields["ncomp"]->searchExpression(), "=", $curVal, $this->codrem->Lookup->getTable()->Fields["ncomp"]->searchDataType(), "");
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

        // codcli
        $this->codcli->ViewValue = $this->codcli->CurrentValue;
        $this->codcli->ViewValue = FormatNumber($this->codcli->ViewValue, $this->codcli->formatPattern());

        // codrubro
        $this->codrubro->ViewValue = $this->codrubro->CurrentValue;
        $this->codrubro->ViewValue = FormatNumber($this->codrubro->ViewValue, $this->codrubro->formatPattern());

        // estado
        if (strval($this->estado->CurrentValue) != "") {
            $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
        } else {
            $this->estado->ViewValue = null;
        }

        // moneda
        $this->moneda->ViewValue = $this->moneda->CurrentValue;
        $this->moneda->ViewValue = FormatNumber($this->moneda->ViewValue, $this->moneda->formatPattern());

        // preciobase
        $this->preciobase->ViewValue = $this->preciobase->CurrentValue;
        $this->preciobase->ViewValue = FormatNumber($this->preciobase->ViewValue, $this->preciobase->formatPattern());

        // preciofinal
        $this->preciofinal->ViewValue = $this->preciofinal->CurrentValue;
        $this->preciofinal->ViewValue = FormatNumber($this->preciofinal->ViewValue, $this->preciofinal->formatPattern());

        // comiscobr
        $this->comiscobr->ViewValue = $this->comiscobr->CurrentValue;
        $this->comiscobr->ViewValue = FormatNumber($this->comiscobr->ViewValue, $this->comiscobr->formatPattern());

        // comispag
        $this->comispag->ViewValue = $this->comispag->CurrentValue;
        $this->comispag->ViewValue = FormatNumber($this->comispag->ViewValue, $this->comispag->formatPattern());

        // comprador
        $this->comprador->ViewValue = $this->comprador->CurrentValue;
        $this->comprador->ViewValue = FormatNumber($this->comprador->ViewValue, $this->comprador->formatPattern());

        // ivari
        $this->ivari->ViewValue = $this->ivari->CurrentValue;
        $this->ivari->ViewValue = FormatNumber($this->ivari->ViewValue, $this->ivari->formatPattern());

        // ivarni
        $this->ivarni->ViewValue = $this->ivarni->CurrentValue;
        $this->ivarni->ViewValue = FormatNumber($this->ivarni->ViewValue, $this->ivarni->formatPattern());

        // codimpadic
        $this->codimpadic->ViewValue = $this->codimpadic->CurrentValue;
        $this->codimpadic->ViewValue = FormatNumber($this->codimpadic->ViewValue, $this->codimpadic->formatPattern());

        // impadic
        $this->impadic->ViewValue = $this->impadic->CurrentValue;
        $this->impadic->ViewValue = FormatNumber($this->impadic->ViewValue, $this->impadic->formatPattern());

        // descripcion
        $this->descripcion->ViewValue = $this->descripcion->CurrentValue;

        // descor
        $this->descor->ViewValue = $this->descor->CurrentValue;

        // observ
        $this->observ->ViewValue = $this->observ->CurrentValue;

        // usuario
        $this->usuario->ViewValue = $this->usuario->CurrentValue;
        $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

        // fecalta
        $this->fecalta->ViewValue = $this->fecalta->CurrentValue;
        $this->fecalta->ViewValue = FormatDateTime($this->fecalta->ViewValue, $this->fecalta->formatPattern());

        // secuencia
        $this->secuencia->ViewValue = $this->secuencia->CurrentValue;
        $this->secuencia->ViewValue = FormatNumber($this->secuencia->ViewValue, $this->secuencia->formatPattern());

        // codintlote
        $this->codintlote->ViewValue = $this->codintlote->CurrentValue;

        // codintnum
        $this->codintnum->ViewValue = $this->codintnum->CurrentValue;
        $this->codintnum->ViewValue = FormatNumber($this->codintnum->ViewValue, $this->codintnum->formatPattern());

        // codintsublote
        $this->codintsublote->ViewValue = $this->codintsublote->CurrentValue;

        // usuarioultmod
        $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
        $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

        // fecultmod
        $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
        $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

        // dir_secuencia
        $curVal = strval($this->dir_secuencia->CurrentValue);
        if ($curVal != "") {
            $this->dir_secuencia->ViewValue = $this->dir_secuencia->lookupCacheOption($curVal);
            if ($this->dir_secuencia->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->dir_secuencia->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->dir_secuencia->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->dir_secuencia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->dir_secuencia->Lookup->renderViewRow($rswrk[0]);
                    $this->dir_secuencia->ViewValue = $this->dir_secuencia->displayValue($arwrk);
                } else {
                    $this->dir_secuencia->ViewValue = FormatNumber($this->dir_secuencia->CurrentValue, $this->dir_secuencia->formatPattern());
                }
            }
        } else {
            $this->dir_secuencia->ViewValue = null;
        }

        // codnum
        $this->codnum->HrefValue = "";
        $this->codnum->TooltipValue = "";

        // codrem
        $this->codrem->HrefValue = "";
        $this->codrem->TooltipValue = "";

        // codcli
        $this->codcli->HrefValue = "";
        $this->codcli->TooltipValue = "";

        // codrubro
        $this->codrubro->HrefValue = "";
        $this->codrubro->TooltipValue = "";

        // estado
        $this->estado->HrefValue = "";
        $this->estado->TooltipValue = "";

        // moneda
        $this->moneda->HrefValue = "";
        $this->moneda->TooltipValue = "";

        // preciobase
        $this->preciobase->HrefValue = "";
        $this->preciobase->TooltipValue = "";

        // preciofinal
        $this->preciofinal->HrefValue = "";
        $this->preciofinal->TooltipValue = "";

        // comiscobr
        $this->comiscobr->HrefValue = "";
        $this->comiscobr->TooltipValue = "";

        // comispag
        $this->comispag->HrefValue = "";
        $this->comispag->TooltipValue = "";

        // comprador
        $this->comprador->HrefValue = "";
        $this->comprador->TooltipValue = "";

        // ivari
        $this->ivari->HrefValue = "";
        $this->ivari->TooltipValue = "";

        // ivarni
        $this->ivarni->HrefValue = "";
        $this->ivarni->TooltipValue = "";

        // codimpadic
        $this->codimpadic->HrefValue = "";
        $this->codimpadic->TooltipValue = "";

        // impadic
        $this->impadic->HrefValue = "";
        $this->impadic->TooltipValue = "";

        // descripcion
        $this->descripcion->HrefValue = "";
        $this->descripcion->TooltipValue = "";

        // descor
        $this->descor->HrefValue = "";
        $this->descor->TooltipValue = "";

        // observ
        $this->observ->HrefValue = "";
        $this->observ->TooltipValue = "";

        // usuario
        $this->usuario->HrefValue = "";
        $this->usuario->TooltipValue = "";

        // fecalta
        $this->fecalta->HrefValue = "";
        $this->fecalta->TooltipValue = "";

        // secuencia
        $this->secuencia->HrefValue = "";
        $this->secuencia->TooltipValue = "";

        // codintlote
        $this->codintlote->HrefValue = "";
        $this->codintlote->TooltipValue = "";

        // codintnum
        $this->codintnum->HrefValue = "";
        $this->codintnum->TooltipValue = "";

        // codintsublote
        $this->codintsublote->HrefValue = "";
        $this->codintsublote->TooltipValue = "";

        // usuarioultmod
        $this->usuarioultmod->HrefValue = "";
        $this->usuarioultmod->TooltipValue = "";

        // fecultmod
        $this->fecultmod->HrefValue = "";
        $this->fecultmod->TooltipValue = "";

        // dir_secuencia
        $this->dir_secuencia->HrefValue = "";
        $this->dir_secuencia->TooltipValue = "";

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
        if (strval($this->codnum->EditValue) != "" && is_numeric($this->codnum->EditValue)) {
            $this->codnum->EditValue = $this->codnum->EditValue;
        }

        // codrem
        $this->codrem->setupEditAttributes();
        $this->codrem->EditValue = $this->codrem->CurrentValue;
        $curVal = strval($this->codrem->CurrentValue);
        if ($curVal != "") {
            $this->codrem->EditValue = $this->codrem->lookupCacheOption($curVal);
            if ($this->codrem->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->codrem->Lookup->getTable()->Fields["ncomp"]->searchExpression(), "=", $curVal, $this->codrem->Lookup->getTable()->Fields["ncomp"]->searchDataType(), "");
                $sqlWrk = $this->codrem->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->codrem->Lookup->renderViewRow($rswrk[0]);
                    $this->codrem->EditValue = $this->codrem->displayValue($arwrk);
                } else {
                    $this->codrem->EditValue = FormatNumber($this->codrem->CurrentValue, $this->codrem->formatPattern());
                }
            }
        } else {
            $this->codrem->EditValue = null;
        }

        // codcli
        $this->codcli->setupEditAttributes();
        $this->codcli->CurrentValue = FormatNumber($this->codcli->CurrentValue, $this->codcli->formatPattern());
        if (strval($this->codcli->EditValue) != "" && is_numeric($this->codcli->EditValue)) {
            $this->codcli->EditValue = FormatNumber($this->codcli->EditValue, null);
        }

        // codrubro
        $this->codrubro->setupEditAttributes();
        $this->codrubro->CurrentValue = FormatNumber($this->codrubro->CurrentValue, $this->codrubro->formatPattern());
        if (strval($this->codrubro->EditValue) != "" && is_numeric($this->codrubro->EditValue)) {
            $this->codrubro->EditValue = FormatNumber($this->codrubro->EditValue, null);
        }

        // estado
        $this->estado->EditValue = $this->estado->options(false);
        $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

        // moneda
        $this->moneda->setupEditAttributes();
        $this->moneda->CurrentValue = FormatNumber($this->moneda->CurrentValue, $this->moneda->formatPattern());
        if (strval($this->moneda->EditValue) != "" && is_numeric($this->moneda->EditValue)) {
            $this->moneda->EditValue = FormatNumber($this->moneda->EditValue, null);
        }

        // preciobase
        $this->preciobase->setupEditAttributes();
        $this->preciobase->CurrentValue = FormatNumber($this->preciobase->CurrentValue, $this->preciobase->formatPattern());
        if (strval($this->preciobase->EditValue) != "" && is_numeric($this->preciobase->EditValue)) {
            $this->preciobase->EditValue = FormatNumber($this->preciobase->EditValue, null);
        }

        // preciofinal
        $this->preciofinal->setupEditAttributes();
        $this->preciofinal->EditValue = $this->preciofinal->CurrentValue;
        $this->preciofinal->PlaceHolder = RemoveHtml($this->preciofinal->caption());
        if (strval($this->preciofinal->EditValue) != "" && is_numeric($this->preciofinal->EditValue)) {
            $this->preciofinal->EditValue = FormatNumber($this->preciofinal->EditValue, null);
        }

        // comiscobr
        $this->comiscobr->setupEditAttributes();
        $this->comiscobr->EditValue = $this->comiscobr->CurrentValue;
        $this->comiscobr->PlaceHolder = RemoveHtml($this->comiscobr->caption());
        if (strval($this->comiscobr->EditValue) != "" && is_numeric($this->comiscobr->EditValue)) {
            $this->comiscobr->EditValue = FormatNumber($this->comiscobr->EditValue, null);
        }

        // comispag
        $this->comispag->setupEditAttributes();
        $this->comispag->CurrentValue = FormatNumber($this->comispag->CurrentValue, $this->comispag->formatPattern());
        if (strval($this->comispag->EditValue) != "" && is_numeric($this->comispag->EditValue)) {
            $this->comispag->EditValue = FormatNumber($this->comispag->EditValue, null);
        }

        // comprador
        $this->comprador->setupEditAttributes();
        $this->comprador->CurrentValue = FormatNumber($this->comprador->CurrentValue, $this->comprador->formatPattern());
        if (strval($this->comprador->EditValue) != "" && is_numeric($this->comprador->EditValue)) {
            $this->comprador->EditValue = FormatNumber($this->comprador->EditValue, null);
        }

        // ivari
        $this->ivari->setupEditAttributes();
        $this->ivari->CurrentValue = FormatNumber($this->ivari->CurrentValue, $this->ivari->formatPattern());
        if (strval($this->ivari->EditValue) != "" && is_numeric($this->ivari->EditValue)) {
            $this->ivari->EditValue = FormatNumber($this->ivari->EditValue, null);
        }

        // ivarni
        $this->ivarni->setupEditAttributes();
        $this->ivarni->CurrentValue = FormatNumber($this->ivarni->CurrentValue, $this->ivarni->formatPattern());
        if (strval($this->ivarni->EditValue) != "" && is_numeric($this->ivarni->EditValue)) {
            $this->ivarni->EditValue = FormatNumber($this->ivarni->EditValue, null);
        }

        // codimpadic
        $this->codimpadic->setupEditAttributes();
        $this->codimpadic->CurrentValue = FormatNumber($this->codimpadic->CurrentValue, $this->codimpadic->formatPattern());
        if (strval($this->codimpadic->EditValue) != "" && is_numeric($this->codimpadic->EditValue)) {
            $this->codimpadic->EditValue = FormatNumber($this->codimpadic->EditValue, null);
        }

        // impadic
        $this->impadic->setupEditAttributes();
        $this->impadic->CurrentValue = FormatNumber($this->impadic->CurrentValue, $this->impadic->formatPattern());
        if (strval($this->impadic->EditValue) != "" && is_numeric($this->impadic->EditValue)) {
            $this->impadic->EditValue = FormatNumber($this->impadic->EditValue, null);
        }

        // descripcion
        $this->descripcion->setupEditAttributes();
        $this->descripcion->EditValue = $this->descripcion->CurrentValue;
        $this->descripcion->PlaceHolder = RemoveHtml($this->descripcion->caption());

        // descor
        $this->descor->setupEditAttributes();

        // observ
        $this->observ->setupEditAttributes();

        // usuario

        // fecalta

        // secuencia
        $this->secuencia->setupEditAttributes();
        $this->secuencia->CurrentValue = FormatNumber($this->secuencia->CurrentValue, $this->secuencia->formatPattern());
        if (strval($this->secuencia->EditValue) != "" && is_numeric($this->secuencia->EditValue)) {
            $this->secuencia->EditValue = FormatNumber($this->secuencia->EditValue, null);
        }

        // codintlote
        $this->codintlote->setupEditAttributes();
        $this->codintlote->EditValue = $this->codintlote->CurrentValue;

        // codintnum
        $this->codintnum->setupEditAttributes();
        $this->codintnum->CurrentValue = FormatNumber($this->codintnum->CurrentValue, $this->codintnum->formatPattern());
        if (strval($this->codintnum->EditValue) != "" && is_numeric($this->codintnum->EditValue)) {
            $this->codintnum->EditValue = FormatNumber($this->codintnum->EditValue, null);
        }

        // codintsublote
        $this->codintsublote->setupEditAttributes();

        // usuarioultmod

        // fecultmod

        // dir_secuencia
        $this->dir_secuencia->setupEditAttributes();
        $this->dir_secuencia->PlaceHolder = RemoveHtml($this->dir_secuencia->caption());

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
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->codcli);
                    $doc->exportCaption($this->codrubro);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->moneda);
                    $doc->exportCaption($this->preciobase);
                    $doc->exportCaption($this->preciofinal);
                    $doc->exportCaption($this->comiscobr);
                    $doc->exportCaption($this->comispag);
                    $doc->exportCaption($this->comprador);
                    $doc->exportCaption($this->ivari);
                    $doc->exportCaption($this->ivarni);
                    $doc->exportCaption($this->codimpadic);
                    $doc->exportCaption($this->impadic);
                    $doc->exportCaption($this->descripcion);
                    $doc->exportCaption($this->descor);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->fecalta);
                    $doc->exportCaption($this->secuencia);
                    $doc->exportCaption($this->codintlote);
                    $doc->exportCaption($this->codintnum);
                    $doc->exportCaption($this->codintsublote);
                    $doc->exportCaption($this->usuarioultmod);
                    $doc->exportCaption($this->fecultmod);
                    $doc->exportCaption($this->dir_secuencia);
                } else {
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->codcli);
                    $doc->exportCaption($this->codrubro);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->moneda);
                    $doc->exportCaption($this->preciobase);
                    $doc->exportCaption($this->preciofinal);
                    $doc->exportCaption($this->comiscobr);
                    $doc->exportCaption($this->comispag);
                    $doc->exportCaption($this->comprador);
                    $doc->exportCaption($this->ivari);
                    $doc->exportCaption($this->ivarni);
                    $doc->exportCaption($this->codimpadic);
                    $doc->exportCaption($this->impadic);
                    $doc->exportCaption($this->descor);
                    $doc->exportCaption($this->observ);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->fecalta);
                    $doc->exportCaption($this->secuencia);
                    $doc->exportCaption($this->codintlote);
                    $doc->exportCaption($this->codintnum);
                    $doc->exportCaption($this->codintsublote);
                    $doc->exportCaption($this->usuarioultmod);
                    $doc->exportCaption($this->fecultmod);
                    $doc->exportCaption($this->dir_secuencia);
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
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->codcli);
                        $doc->exportField($this->codrubro);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->moneda);
                        $doc->exportField($this->preciobase);
                        $doc->exportField($this->preciofinal);
                        $doc->exportField($this->comiscobr);
                        $doc->exportField($this->comispag);
                        $doc->exportField($this->comprador);
                        $doc->exportField($this->ivari);
                        $doc->exportField($this->ivarni);
                        $doc->exportField($this->codimpadic);
                        $doc->exportField($this->impadic);
                        $doc->exportField($this->descripcion);
                        $doc->exportField($this->descor);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->fecalta);
                        $doc->exportField($this->secuencia);
                        $doc->exportField($this->codintlote);
                        $doc->exportField($this->codintnum);
                        $doc->exportField($this->codintsublote);
                        $doc->exportField($this->usuarioultmod);
                        $doc->exportField($this->fecultmod);
                        $doc->exportField($this->dir_secuencia);
                    } else {
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->codcli);
                        $doc->exportField($this->codrubro);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->moneda);
                        $doc->exportField($this->preciobase);
                        $doc->exportField($this->preciofinal);
                        $doc->exportField($this->comiscobr);
                        $doc->exportField($this->comispag);
                        $doc->exportField($this->comprador);
                        $doc->exportField($this->ivari);
                        $doc->exportField($this->ivarni);
                        $doc->exportField($this->codimpadic);
                        $doc->exportField($this->impadic);
                        $doc->exportField($this->descor);
                        $doc->exportField($this->observ);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->fecalta);
                        $doc->exportField($this->secuencia);
                        $doc->exportField($this->codintlote);
                        $doc->exportField($this->codintnum);
                        $doc->exportField($this->codintsublote);
                        $doc->exportField($this->usuarioultmod);
                        $doc->exportField($this->fecultmod);
                        $doc->exportField($this->dir_secuencia);
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

    public function rowInserting($rsold, &$rsnew) {
                $amercado = Conn();
                    $partes[0] = "";
                	$partes[1] = "";
                	$numero = "";
                	$letras = "";
                	$codintlote = "";
                	$codintlote   = $rsnew['codintlote'];
                	$partes = preg_split("/(,?\s+)|((?<=[a-z])(?=\d))|((?<=\d)(?=[a-z]))/i", $codintlote);
                	$numero = $partes[0];
                	$letras  = $partes[1];
                	$rsnew['codintnum'] = $numero;
                	$rsnew['codintsublote'] = $letras;	
                	$rsnew['descor'] = $rsnew['descripcion'];
                    $codnum = $rsnew['codnum'];

                	// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
                	$codrem     = $rsold['codrem']; 
                	$codintlote  = $rsnew['codintlote'];
                    $querySecun = sprintf("SELECT secuencia FROM lotes WHERE lotes.codrem = $codrem AND codnum = $codintlote LIMIT 1");
                    $secuencia = $amercado->fetchAssociative($querySecun);
                    $secNum = $secuencia["secuencia"];
                    $rsnew['secuencia'] = $secNum;

                	// LEO LA TABLA LOTES
                	if($rsnew['codintnum'] == "$codintlote"){
                	    return TRUE;
                    }
                	else {
                        ?> <script>alert('La secuencia esta mal, si persiste el error, mandar ticket, probablemente esta mal cargado el lote.')</script> <?php
                        return FALSE;
                    } 
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew) {
    $amercado = Conn();
                    $partes[0] = "";
                	$partes[1] = "";
                	$numero = "";
                	$letras = "";
                	$codintlote = "";
                	$codintlote   = $rsnew['codintlote'];
                	$partes = preg_split("/(,?\s+)|((?<=[a-z])(?=\d))|((?<=\d)(?=[a-z]))/i", $codintlote);
                	$numero = $partes[0];
                	$letras  = $partes[1];
                	$rsnew['codintnum'] = $numero;
                	$rsnew['codintsublote'] = $letras;	
                	$rsnew['descor'] = $rsnew['descripcion'];
                    $codnum = $rsold['codnum'];

                	// BUSCO LOS CAMPOS NECESARIOS PARA VALIDAR
                	$codrem     = $rsold['codrem']; 
                	$codintlote  = $rsnew['codintlote'];
                    $querySecun = sprintf("SELECT secuencia FROM lotes WHERE lotes.codrem = $codrem AND codnum = $codnum LIMIT 1");
                    $secuencia = $amercado->fetchAssociative($querySecun);
                    $secNum = $secuencia["secuencia"];
                    $rsnew['secuencia'] = $secNum;
                	return TRUE;

                    // ACA LE MANDO EL MENSAJE DE ERROR Y NO DEBE GRABAR EL LOTE    
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
