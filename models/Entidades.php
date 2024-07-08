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
 * Table class for entidades
 */
class Entidades extends DbTable
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
    public $razsoc;
    public $calle;
    public $numero;
    public $pisodto;
    public $codpais;
    public $codprov;
    public $codloc;
    public $codpost;
    public $tellinea;
    public $telcelu;
    public $tipoent;
    public $tipoiva;
    public $cuit;
    public $calif;
    public $fecalta;
    public $usuario;
    public $contacto;
    public $mailcont;
    public $cargo;
    public $fechahora;
    public $activo;
    public $pagweb;
    public $tipoind;
    public $usuarioultmod;
    public $fecultmod;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "entidades";
        $this->TableName = 'entidades';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "entidades";
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
            5, // Size
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

        // razsoc
        $this->razsoc = new DbField(
            $this, // Table
            'x_razsoc', // Variable name
            'razsoc', // Name
            '`razsoc`', // Expression
            '`razsoc`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`razsoc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->razsoc->InputTextType = "text";
        $this->razsoc->Nullable = false; // NOT NULL field
        $this->razsoc->Required = true; // Required field
        $this->razsoc->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['razsoc'] = &$this->razsoc;

        // calle
        $this->calle = new DbField(
            $this, // Table
            'x_calle', // Variable name
            'calle', // Name
            '`calle`', // Expression
            '`calle`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`calle`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->calle->InputTextType = "text";
        $this->calle->Required = true; // Required field
        $this->calle->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['calle'] = &$this->calle;

        // numero
        $this->numero = new DbField(
            $this, // Table
            'x_numero', // Variable name
            'numero', // Name
            '`numero`', // Expression
            '`numero`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`numero`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->numero->InputTextType = "text";
        $this->numero->Required = true; // Required field
        $this->numero->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['numero'] = &$this->numero;

        // pisodto
        $this->pisodto = new DbField(
            $this, // Table
            'x_pisodto', // Variable name
            'pisodto', // Name
            '`pisodto`', // Expression
            '`pisodto`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`pisodto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->pisodto->InputTextType = "text";
        $this->pisodto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['pisodto'] = &$this->pisodto;

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
        $this->codpais->InputTextType = "text";
        $this->codpais->Raw = true;
        $this->codpais->Required = true; // Required field
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
            3, // Size
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
        $this->codprov->Required = true; // Required field
        $this->codprov->setSelectMultiple(false); // Select one
        $this->codprov->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codprov->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codprov->Lookup = new Lookup($this->codprov, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', ["x_codpais"], ["x_codloc"], ["codpais"], ["x_codpais"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->codprov->Lookup = new Lookup($this->codprov, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', ["x_codpais"], ["x_codloc"], ["codpais"], ["x_codpais"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->codprov->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codprov->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
        $this->codloc->Required = true; // Required field
        $this->codloc->setSelectMultiple(false); // Select one
        $this->codloc->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->codloc->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->codloc->Lookup = new Lookup($this->codloc, 'localidades', false, 'codnum', ["descripcion","","",""], '', '', ["x_codprov"], [], ["codprov"], ["x_codprov"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->codloc->Lookup = new Lookup($this->codloc, 'localidades', false, 'codnum', ["descripcion","","",""], '', '', ["x_codprov"], [], ["codprov"], ["x_codprov"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->codloc->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codloc->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['codloc'] = &$this->codloc;

        // codpost
        $this->codpost = new DbField(
            $this, // Table
            'x_codpost', // Variable name
            'codpost', // Name
            '`codpost`', // Expression
            '`codpost`', // Basic search expression
            200, // Type
            8, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codpost`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->codpost->InputTextType = "text";
        $this->codpost->Required = true; // Required field
        $this->codpost->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['codpost'] = &$this->codpost;

        // tellinea
        $this->tellinea = new DbField(
            $this, // Table
            'x_tellinea', // Variable name
            'tellinea', // Name
            '`tellinea`', // Expression
            '`tellinea`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tellinea`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tellinea->InputTextType = "text";
        $this->tellinea->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['tellinea'] = &$this->tellinea;

        // telcelu
        $this->telcelu = new DbField(
            $this, // Table
            'x_telcelu', // Variable name
            'telcelu', // Name
            '`telcelu`', // Expression
            '`telcelu`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telcelu`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telcelu->InputTextType = "text";
        $this->telcelu->Required = true; // Required field
        $this->telcelu->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telcelu'] = &$this->telcelu;

        // tipoent
        $this->tipoent = new DbField(
            $this, // Table
            'x_tipoent', // Variable name
            'tipoent', // Name
            '`tipoent`', // Expression
            '`tipoent`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipoent`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipoent->InputTextType = "text";
        $this->tipoent->Raw = true;
        $this->tipoent->Nullable = false; // NOT NULL field
        $this->tipoent->Required = true; // Required field
        $this->tipoent->setSelectMultiple(false); // Select one
        $this->tipoent->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipoent->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->tipoent->Lookup = new Lookup($this->tipoent, 'tipoenti', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->tipoent->Lookup = new Lookup($this->tipoent, 'tipoenti', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->tipoent->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipoent->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tipoent'] = &$this->tipoent;

        // tipoiva
        $this->tipoiva = new DbField(
            $this, // Table
            'x_tipoiva', // Variable name
            'tipoiva', // Name
            '`tipoiva`', // Expression
            '`tipoiva`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipoiva`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipoiva->addMethod("getDefault", fn() => 1);
        $this->tipoiva->InputTextType = "text";
        $this->tipoiva->Raw = true;
        $this->tipoiva->Nullable = false; // NOT NULL field
        $this->tipoiva->Required = true; // Required field
        $this->tipoiva->setSelectMultiple(false); // Select one
        $this->tipoiva->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipoiva->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->tipoiva->Lookup = new Lookup($this->tipoiva, 'tipoiva', false, 'codnum', ["descrip","","",""], '', '', [], [], [], [], [], [], false, '`descrip` ASC', '', "`descrip`");
                break;
            default:
                $this->tipoiva->Lookup = new Lookup($this->tipoiva, 'tipoiva', false, 'codnum', ["descrip","","",""], '', '', [], [], [], [], [], [], false, '`descrip` ASC', '', "`descrip`");
                break;
        }
        $this->tipoiva->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipoiva->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tipoiva'] = &$this->tipoiva;

        // cuit
        $this->cuit = new DbField(
            $this, // Table
            'x_cuit', // Variable name
            'cuit', // Name
            '`cuit`', // Expression
            '`cuit`', // Basic search expression
            200, // Type
            14, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cuit`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cuit->InputTextType = "text";
        $this->cuit->Required = true; // Required field
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->cuit->Lookup = new Lookup($this->cuit, 'entidades', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->cuit->Lookup = new Lookup($this->cuit, 'entidades', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->cuit->OptionCount = 1;
        $this->cuit->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cuit'] = &$this->cuit;

        // calif
        $this->calif = new DbField(
            $this, // Table
            'x_calif', // Variable name
            'calif', // Name
            '`calif`', // Expression
            '`calif`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`calif`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->calif->InputTextType = "text";
        $this->calif->Raw = true;
        $this->calif->setSelectMultiple(false); // Select one
        $this->calif->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->calif->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->calif->Lookup = new Lookup($this->calif, 'calificacion', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->calif->Lookup = new Lookup($this->calif, 'calificacion', false, 'codnum', ["descripcion","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->calif->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->calif->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['calif'] = &$this->calif;

        // fecalta
        $this->fecalta = new DbField(
            $this, // Table
            'x_fecalta', // Variable name
            'fecalta', // Name
            '`fecalta`', // Expression
            CastDateFieldForLike("`fecalta`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
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
        $this->fecalta->Required = true; // Required field
        $this->fecalta->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecalta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecalta'] = &$this->fecalta;

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
        $this->usuario->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuario'] = &$this->usuario;

        // contacto
        $this->contacto = new DbField(
            $this, // Table
            'x_contacto', // Variable name
            'contacto', // Name
            '`contacto`', // Expression
            '`contacto`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`contacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->contacto->InputTextType = "text";
        $this->contacto->Required = true; // Required field
        $this->contacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['contacto'] = &$this->contacto;

        // mailcont
        $this->mailcont = new DbField(
            $this, // Table
            'x_mailcont', // Variable name
            'mailcont', // Name
            '`mailcont`', // Expression
            '`mailcont`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`mailcont`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->mailcont->InputTextType = "text";
        $this->mailcont->Required = true; // Required field
        $this->mailcont->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->mailcont->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['mailcont'] = &$this->mailcont;

        // cargo
        $this->cargo = new DbField(
            $this, // Table
            'x_cargo', // Variable name
            'cargo', // Name
            '`cargo`', // Expression
            '`cargo`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cargo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cargo->InputTextType = "text";
        $this->cargo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cargo'] = &$this->cargo;

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
        $this->fechahora->addMethod("getAutoUpdateValue", fn() => CurrentDateTime());
        $this->fechahora->InputTextType = "text";
        $this->fechahora->Raw = true;
        $this->fechahora->DefaultErrorMessage = str_replace("%s", DateFormat(11), $Language->phrase("IncorrectDate"));
        $this->fechahora->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fechahora'] = &$this->fechahora;

        // activo
        $this->activo = new DbField(
            $this, // Table
            'x_activo', // Variable name
            'activo', // Name
            '`activo`', // Expression
            '`activo`', // Basic search expression
            16, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`activo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->activo->addMethod("getDefault", fn() => 1);
        $this->activo->InputTextType = "text";
        $this->activo->Raw = true;
        $this->activo->Nullable = false; // NOT NULL field
        $this->activo->setSelectMultiple(false); // Select one
        $this->activo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->activo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->activo->Lookup = new Lookup($this->activo, 'entidades', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->activo->Lookup = new Lookup($this->activo, 'entidades', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->activo->OptionCount = 2;
        $this->activo->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->activo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['activo'] = &$this->activo;

        // pagweb
        $this->pagweb = new DbField(
            $this, // Table
            'x_pagweb', // Variable name
            'pagweb', // Name
            '`pagweb`', // Expression
            '`pagweb`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`pagweb`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->pagweb->InputTextType = "text";
        $this->pagweb->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['pagweb'] = &$this->pagweb;

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
            'SELECT' // Edit Tag
        );
        $this->tipoind->InputTextType = "text";
        $this->tipoind->Raw = true;
        $this->tipoind->Required = true; // Required field
        $this->tipoind->setSelectMultiple(false); // Select one
        $this->tipoind->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipoind->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->tipoind->Lookup = new Lookup($this->tipoind, 'tipoindustria', false, 'codnum', ["nomre","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nomre`");
                break;
            default:
                $this->tipoind->Lookup = new Lookup($this->tipoind, 'tipoindustria', false, 'codnum', ["nomre","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nomre`");
                break;
        }
        $this->tipoind->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipoind->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipoind'] = &$this->tipoind;

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
        $this->usuarioultmod->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->usuarioultmod->InputTextType = "text";
        $this->usuarioultmod->Raw = true;
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
            $sortFieldList = ($fld->VirtualExpression != "") ? $fld->VirtualExpression : $sortField;
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortFieldList . " " . $curSort : "";
            $this->setSessionOrderByList($orderBy); // Save to Session
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

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "entidades";
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
        $from = "(SELECT " . $this->sqlSelectFields() . ", (SELECT `descripcion` FROM paises TMP_LOOKUPTABLE WHERE TMP_LOOKUPTABLE.codnum = entidades.codpais LIMIT 1) AS EV__codpais, (SELECT `descripcion` FROM provincias TMP_LOOKUPTABLE WHERE TMP_LOOKUPTABLE.codnum = entidades.codprov LIMIT 1) AS EV__codprov, (SELECT `descripcion` FROM localidades TMP_LOOKUPTABLE WHERE TMP_LOOKUPTABLE.codnum = entidades.codloc LIMIT 1) AS EV__codloc FROM entidades)";
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
        $this->codnum->DbValue = $row['codnum'];
        $this->razsoc->DbValue = $row['razsoc'];
        $this->calle->DbValue = $row['calle'];
        $this->numero->DbValue = $row['numero'];
        $this->pisodto->DbValue = $row['pisodto'];
        $this->codpais->DbValue = $row['codpais'];
        $this->codprov->DbValue = $row['codprov'];
        $this->codloc->DbValue = $row['codloc'];
        $this->codpost->DbValue = $row['codpost'];
        $this->tellinea->DbValue = $row['tellinea'];
        $this->telcelu->DbValue = $row['telcelu'];
        $this->tipoent->DbValue = $row['tipoent'];
        $this->tipoiva->DbValue = $row['tipoiva'];
        $this->cuit->DbValue = $row['cuit'];
        $this->calif->DbValue = $row['calif'];
        $this->fecalta->DbValue = $row['fecalta'];
        $this->usuario->DbValue = $row['usuario'];
        $this->contacto->DbValue = $row['contacto'];
        $this->mailcont->DbValue = $row['mailcont'];
        $this->cargo->DbValue = $row['cargo'];
        $this->fechahora->DbValue = $row['fechahora'];
        $this->activo->DbValue = $row['activo'];
        $this->pagweb->DbValue = $row['pagweb'];
        $this->tipoind->DbValue = $row['tipoind'];
        $this->usuarioultmod->DbValue = $row['usuarioultmod'];
        $this->fecultmod->DbValue = $row['fecultmod'];
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
        return $_SESSION[$name] ?? GetUrl("EntidadesList");
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
            "EntidadesView" => $Language->phrase("View"),
            "EntidadesEdit" => $Language->phrase("Edit"),
            "EntidadesAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "EntidadesList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "EntidadesView",
            Config("API_ADD_ACTION") => "EntidadesAdd",
            Config("API_EDIT_ACTION") => "EntidadesEdit",
            Config("API_DELETE_ACTION") => "EntidadesDelete",
            Config("API_LIST_ACTION") => "EntidadesList",
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
        return "EntidadesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("EntidadesView", $parm);
        } else {
            $url = $this->keyUrl("EntidadesView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "EntidadesAdd?" . $parm;
        } else {
            $url = "EntidadesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("EntidadesEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("EntidadesList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("EntidadesAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("EntidadesList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("EntidadesDelete", $parm);
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
        $this->razsoc->setDbValue($row['razsoc']);
        $this->calle->setDbValue($row['calle']);
        $this->numero->setDbValue($row['numero']);
        $this->pisodto->setDbValue($row['pisodto']);
        $this->codpais->setDbValue($row['codpais']);
        $this->codprov->setDbValue($row['codprov']);
        $this->codloc->setDbValue($row['codloc']);
        $this->codpost->setDbValue($row['codpost']);
        $this->tellinea->setDbValue($row['tellinea']);
        $this->telcelu->setDbValue($row['telcelu']);
        $this->tipoent->setDbValue($row['tipoent']);
        $this->tipoiva->setDbValue($row['tipoiva']);
        $this->cuit->setDbValue($row['cuit']);
        $this->calif->setDbValue($row['calif']);
        $this->fecalta->setDbValue($row['fecalta']);
        $this->usuario->setDbValue($row['usuario']);
        $this->contacto->setDbValue($row['contacto']);
        $this->mailcont->setDbValue($row['mailcont']);
        $this->cargo->setDbValue($row['cargo']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->activo->setDbValue($row['activo']);
        $this->pagweb->setDbValue($row['pagweb']);
        $this->tipoind->setDbValue($row['tipoind']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "EntidadesList";
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

        // razsoc

        // calle

        // numero

        // pisodto

        // codpais

        // codprov

        // codloc

        // codpost

        // tellinea

        // telcelu

        // tipoent

        // tipoiva

        // cuit

        // calif

        // fecalta

        // usuario

        // contacto

        // mailcont

        // cargo

        // fechahora

        // activo

        // pagweb

        // tipoind

        // usuarioultmod

        // fecultmod

        // codnum
        $this->codnum->ViewValue = $this->codnum->CurrentValue;

        // razsoc
        $this->razsoc->ViewValue = $this->razsoc->CurrentValue;

        // calle
        $this->calle->ViewValue = $this->calle->CurrentValue;

        // numero
        $this->numero->ViewValue = $this->numero->CurrentValue;

        // pisodto
        $this->pisodto->ViewValue = $this->pisodto->CurrentValue;

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
                        $this->codpais->ViewValue = $this->codpais->CurrentValue;
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

        // codpost
        $this->codpost->ViewValue = $this->codpost->CurrentValue;

        // tellinea
        $this->tellinea->ViewValue = $this->tellinea->CurrentValue;

        // telcelu
        $this->telcelu->ViewValue = $this->telcelu->CurrentValue;

        // tipoent
        $curVal = strval($this->tipoent->CurrentValue);
        if ($curVal != "") {
            $this->tipoent->ViewValue = $this->tipoent->lookupCacheOption($curVal);
            if ($this->tipoent->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipoent->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tipoent->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->tipoent->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipoent->Lookup->renderViewRow($rswrk[0]);
                    $this->tipoent->ViewValue = $this->tipoent->displayValue($arwrk);
                } else {
                    $this->tipoent->ViewValue = FormatNumber($this->tipoent->CurrentValue, $this->tipoent->formatPattern());
                }
            }
        } else {
            $this->tipoent->ViewValue = null;
        }

        // tipoiva
        $curVal = strval($this->tipoiva->CurrentValue);
        if ($curVal != "") {
            $this->tipoiva->ViewValue = $this->tipoiva->lookupCacheOption($curVal);
            if ($this->tipoiva->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipoiva->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tipoiva->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->tipoiva->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipoiva->Lookup->renderViewRow($rswrk[0]);
                    $this->tipoiva->ViewValue = $this->tipoiva->displayValue($arwrk);
                } else {
                    $this->tipoiva->ViewValue = FormatNumber($this->tipoiva->CurrentValue, $this->tipoiva->formatPattern());
                }
            }
        } else {
            $this->tipoiva->ViewValue = null;
        }

        // cuit
        $this->cuit->ViewValue = $this->cuit->CurrentValue;

        // calif
        $curVal = strval($this->calif->CurrentValue);
        if ($curVal != "") {
            $this->calif->ViewValue = $this->calif->lookupCacheOption($curVal);
            if ($this->calif->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->calif->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->calif->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->calif->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->calif->Lookup->renderViewRow($rswrk[0]);
                    $this->calif->ViewValue = $this->calif->displayValue($arwrk);
                } else {
                    $this->calif->ViewValue = FormatNumber($this->calif->CurrentValue, $this->calif->formatPattern());
                }
            }
        } else {
            $this->calif->ViewValue = null;
        }

        // fecalta
        $this->fecalta->ViewValue = $this->fecalta->CurrentValue;
        $this->fecalta->ViewValue = FormatDateTime($this->fecalta->ViewValue, $this->fecalta->formatPattern());

        // usuario
        $this->usuario->ViewValue = $this->usuario->CurrentValue;
        $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

        // contacto
        $this->contacto->ViewValue = $this->contacto->CurrentValue;

        // mailcont
        $this->mailcont->ViewValue = $this->mailcont->CurrentValue;

        // cargo
        $this->cargo->ViewValue = $this->cargo->CurrentValue;

        // fechahora
        $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
        $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

        // activo
        if (strval($this->activo->CurrentValue) != "") {
            $this->activo->ViewValue = $this->activo->optionCaption($this->activo->CurrentValue);
        } else {
            $this->activo->ViewValue = null;
        }

        // pagweb
        $this->pagweb->ViewValue = $this->pagweb->CurrentValue;

        // tipoind
        $curVal = strval($this->tipoind->CurrentValue);
        if ($curVal != "") {
            $this->tipoind->ViewValue = $this->tipoind->lookupCacheOption($curVal);
            if ($this->tipoind->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipoind->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tipoind->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->tipoind->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipoind->Lookup->renderViewRow($rswrk[0]);
                    $this->tipoind->ViewValue = $this->tipoind->displayValue($arwrk);
                } else {
                    $this->tipoind->ViewValue = FormatNumber($this->tipoind->CurrentValue, $this->tipoind->formatPattern());
                }
            }
        } else {
            $this->tipoind->ViewValue = null;
        }

        // usuarioultmod
        $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
        $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

        // fecultmod
        $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
        $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

        // codnum
        $this->codnum->HrefValue = "";
        $this->codnum->TooltipValue = "";

        // razsoc
        $this->razsoc->HrefValue = "";
        $this->razsoc->TooltipValue = "";

        // calle
        $this->calle->HrefValue = "";
        $this->calle->TooltipValue = "";

        // numero
        $this->numero->HrefValue = "";
        $this->numero->TooltipValue = "";

        // pisodto
        $this->pisodto->HrefValue = "";
        $this->pisodto->TooltipValue = "";

        // codpais
        $this->codpais->HrefValue = "";
        $this->codpais->TooltipValue = "";

        // codprov
        $this->codprov->HrefValue = "";
        $this->codprov->TooltipValue = "";

        // codloc
        $this->codloc->HrefValue = "";
        $this->codloc->TooltipValue = "";

        // codpost
        $this->codpost->HrefValue = "";
        $this->codpost->TooltipValue = "";

        // tellinea
        $this->tellinea->HrefValue = "";
        $this->tellinea->TooltipValue = "";

        // telcelu
        $this->telcelu->HrefValue = "";
        $this->telcelu->TooltipValue = "";

        // tipoent
        $this->tipoent->HrefValue = "";
        $this->tipoent->TooltipValue = "";

        // tipoiva
        $this->tipoiva->HrefValue = "";
        $this->tipoiva->TooltipValue = "";

        // cuit
        $this->cuit->HrefValue = "";
        $this->cuit->TooltipValue = "";

        // calif
        $this->calif->HrefValue = "";
        $this->calif->TooltipValue = "";

        // fecalta
        $this->fecalta->HrefValue = "";
        $this->fecalta->TooltipValue = "";

        // usuario
        $this->usuario->HrefValue = "";
        $this->usuario->TooltipValue = "";

        // contacto
        $this->contacto->HrefValue = "";
        $this->contacto->TooltipValue = "";

        // mailcont
        $this->mailcont->HrefValue = "";
        $this->mailcont->TooltipValue = "";

        // cargo
        $this->cargo->HrefValue = "";
        $this->cargo->TooltipValue = "";

        // fechahora
        $this->fechahora->HrefValue = "";
        $this->fechahora->TooltipValue = "";

        // activo
        $this->activo->HrefValue = "";
        $this->activo->TooltipValue = "";

        // pagweb
        $this->pagweb->HrefValue = "";
        $this->pagweb->TooltipValue = "";

        // tipoind
        $this->tipoind->HrefValue = "";
        $this->tipoind->TooltipValue = "";

        // usuarioultmod
        $this->usuarioultmod->HrefValue = "";
        $this->usuarioultmod->TooltipValue = "";

        // fecultmod
        $this->fecultmod->HrefValue = "";
        $this->fecultmod->TooltipValue = "";

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

        // razsoc
        $this->razsoc->setupEditAttributes();
        if (!$this->razsoc->Raw) {
            $this->razsoc->CurrentValue = HtmlDecode($this->razsoc->CurrentValue);
        }
        $this->razsoc->EditValue = $this->razsoc->CurrentValue;
        $this->razsoc->PlaceHolder = RemoveHtml($this->razsoc->caption());

        // calle
        $this->calle->setupEditAttributes();
        if (!$this->calle->Raw) {
            $this->calle->CurrentValue = HtmlDecode($this->calle->CurrentValue);
        }
        $this->calle->EditValue = $this->calle->CurrentValue;
        $this->calle->PlaceHolder = RemoveHtml($this->calle->caption());

        // numero
        $this->numero->setupEditAttributes();
        if (!$this->numero->Raw) {
            $this->numero->CurrentValue = HtmlDecode($this->numero->CurrentValue);
        }
        $this->numero->EditValue = $this->numero->CurrentValue;
        $this->numero->PlaceHolder = RemoveHtml($this->numero->caption());

        // pisodto
        $this->pisodto->setupEditAttributes();
        if (!$this->pisodto->Raw) {
            $this->pisodto->CurrentValue = HtmlDecode($this->pisodto->CurrentValue);
        }
        $this->pisodto->EditValue = $this->pisodto->CurrentValue;
        $this->pisodto->PlaceHolder = RemoveHtml($this->pisodto->caption());

        // codpais
        $this->codpais->setupEditAttributes();
        $this->codpais->PlaceHolder = RemoveHtml($this->codpais->caption());

        // codprov
        $this->codprov->setupEditAttributes();
        $this->codprov->PlaceHolder = RemoveHtml($this->codprov->caption());

        // codloc
        $this->codloc->setupEditAttributes();
        $this->codloc->PlaceHolder = RemoveHtml($this->codloc->caption());

        // codpost
        $this->codpost->setupEditAttributes();
        if (!$this->codpost->Raw) {
            $this->codpost->CurrentValue = HtmlDecode($this->codpost->CurrentValue);
        }
        $this->codpost->EditValue = $this->codpost->CurrentValue;
        $this->codpost->PlaceHolder = RemoveHtml($this->codpost->caption());

        // tellinea
        $this->tellinea->setupEditAttributes();
        if (!$this->tellinea->Raw) {
            $this->tellinea->CurrentValue = HtmlDecode($this->tellinea->CurrentValue);
        }
        $this->tellinea->EditValue = $this->tellinea->CurrentValue;
        $this->tellinea->PlaceHolder = RemoveHtml($this->tellinea->caption());

        // telcelu
        $this->telcelu->setupEditAttributes();
        if (!$this->telcelu->Raw) {
            $this->telcelu->CurrentValue = HtmlDecode($this->telcelu->CurrentValue);
        }
        $this->telcelu->EditValue = $this->telcelu->CurrentValue;
        $this->telcelu->PlaceHolder = RemoveHtml($this->telcelu->caption());

        // tipoent
        $this->tipoent->setupEditAttributes();
        $this->tipoent->PlaceHolder = RemoveHtml($this->tipoent->caption());

        // tipoiva
        $this->tipoiva->setupEditAttributes();
        $this->tipoiva->PlaceHolder = RemoveHtml($this->tipoiva->caption());

        // cuit
        $this->cuit->setupEditAttributes();
        if (!$this->cuit->Raw) {
            $this->cuit->CurrentValue = HtmlDecode($this->cuit->CurrentValue);
        }
        $this->cuit->EditValue = $this->cuit->CurrentValue;
        $this->cuit->PlaceHolder = RemoveHtml($this->cuit->caption());

        // calif
        $this->calif->setupEditAttributes();
        $this->calif->PlaceHolder = RemoveHtml($this->calif->caption());

        // fecalta
        $this->fecalta->setupEditAttributes();
        $this->fecalta->EditValue = FormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern());
        $this->fecalta->PlaceHolder = RemoveHtml($this->fecalta->caption());

        // usuario

        // contacto
        $this->contacto->setupEditAttributes();
        if (!$this->contacto->Raw) {
            $this->contacto->CurrentValue = HtmlDecode($this->contacto->CurrentValue);
        }
        $this->contacto->EditValue = $this->contacto->CurrentValue;
        $this->contacto->PlaceHolder = RemoveHtml($this->contacto->caption());

        // mailcont
        $this->mailcont->setupEditAttributes();
        if (!$this->mailcont->Raw) {
            $this->mailcont->CurrentValue = HtmlDecode($this->mailcont->CurrentValue);
        }
        $this->mailcont->EditValue = $this->mailcont->CurrentValue;
        $this->mailcont->PlaceHolder = RemoveHtml($this->mailcont->caption());

        // cargo
        $this->cargo->setupEditAttributes();
        if (!$this->cargo->Raw) {
            $this->cargo->CurrentValue = HtmlDecode($this->cargo->CurrentValue);
        }
        $this->cargo->EditValue = $this->cargo->CurrentValue;
        $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

        // fechahora

        // activo
        $this->activo->setupEditAttributes();
        $this->activo->EditValue = $this->activo->options(true);
        $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

        // pagweb
        $this->pagweb->setupEditAttributes();
        if (!$this->pagweb->Raw) {
            $this->pagweb->CurrentValue = HtmlDecode($this->pagweb->CurrentValue);
        }
        $this->pagweb->EditValue = $this->pagweb->CurrentValue;
        $this->pagweb->PlaceHolder = RemoveHtml($this->pagweb->caption());

        // tipoind
        $this->tipoind->setupEditAttributes();
        $this->tipoind->PlaceHolder = RemoveHtml($this->tipoind->caption());

        // usuarioultmod

        // fecultmod

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
                    $doc->exportCaption($this->razsoc);
                    $doc->exportCaption($this->calle);
                    $doc->exportCaption($this->numero);
                    $doc->exportCaption($this->pisodto);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->codpost);
                    $doc->exportCaption($this->tellinea);
                    $doc->exportCaption($this->telcelu);
                    $doc->exportCaption($this->tipoent);
                    $doc->exportCaption($this->tipoiva);
                    $doc->exportCaption($this->cuit);
                    $doc->exportCaption($this->calif);
                    $doc->exportCaption($this->fecalta);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->contacto);
                    $doc->exportCaption($this->mailcont);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->activo);
                    $doc->exportCaption($this->pagweb);
                    $doc->exportCaption($this->tipoind);
                    $doc->exportCaption($this->usuarioultmod);
                    $doc->exportCaption($this->fecultmod);
                } else {
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->razsoc);
                    $doc->exportCaption($this->calle);
                    $doc->exportCaption($this->numero);
                    $doc->exportCaption($this->pisodto);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->codpost);
                    $doc->exportCaption($this->tellinea);
                    $doc->exportCaption($this->telcelu);
                    $doc->exportCaption($this->tipoent);
                    $doc->exportCaption($this->tipoiva);
                    $doc->exportCaption($this->cuit);
                    $doc->exportCaption($this->calif);
                    $doc->exportCaption($this->fecalta);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->contacto);
                    $doc->exportCaption($this->mailcont);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->activo);
                    $doc->exportCaption($this->pagweb);
                    $doc->exportCaption($this->tipoind);
                    $doc->exportCaption($this->usuarioultmod);
                    $doc->exportCaption($this->fecultmod);
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
                        $doc->exportField($this->razsoc);
                        $doc->exportField($this->calle);
                        $doc->exportField($this->numero);
                        $doc->exportField($this->pisodto);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->codpost);
                        $doc->exportField($this->tellinea);
                        $doc->exportField($this->telcelu);
                        $doc->exportField($this->tipoent);
                        $doc->exportField($this->tipoiva);
                        $doc->exportField($this->cuit);
                        $doc->exportField($this->calif);
                        $doc->exportField($this->fecalta);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->contacto);
                        $doc->exportField($this->mailcont);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->activo);
                        $doc->exportField($this->pagweb);
                        $doc->exportField($this->tipoind);
                        $doc->exportField($this->usuarioultmod);
                        $doc->exportField($this->fecultmod);
                    } else {
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->razsoc);
                        $doc->exportField($this->calle);
                        $doc->exportField($this->numero);
                        $doc->exportField($this->pisodto);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->codpost);
                        $doc->exportField($this->tellinea);
                        $doc->exportField($this->telcelu);
                        $doc->exportField($this->tipoent);
                        $doc->exportField($this->tipoiva);
                        $doc->exportField($this->cuit);
                        $doc->exportField($this->calif);
                        $doc->exportField($this->fecalta);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->contacto);
                        $doc->exportField($this->mailcont);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->activo);
                        $doc->exportField($this->pagweb);
                        $doc->exportField($this->tipoind);
                        $doc->exportField($this->usuarioultmod);
                        $doc->exportField($this->fecultmod);
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
        $cuit = $rsnew['cuit'];
        echo '<script language="javascript">alert("El Cuit está mal crack, faltan los guiones o te comiste un número / El cuit no es existente en afip");</script>';
        if (strlen($cuit) != 13) return false;
    		$rv = false;
    		$resultado = 0;
    		$cuit_nro = str_replace("-", "", $cuit);
    		$codes = "6789456789";
    		$cuit_long = intVal($cuit_nro);
    		$verificador = intVal($cuit_nro[strlen($cuit_nro)-1]);
    		$x = 0;
    		while ($x < 10)
    		{
    			$digitoValidador = intVal(substr($codes, $x, 1));
    			$digito = intVal(substr($cuit_nro, $x, 1));
    			$digitoValidacion = $digitoValidador * $digito;
    			$resultado += $digitoValidacion;
    			$x++;
    		}
    		$resultado = intVal($resultado) % 11;
    		$rv = $resultado == $verificador;
    		return $rv;
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
        $cuit = $rsnew['cuit'];
        echo '<script language="javascript">alert("El Cuit está mal crack, faltan los guiones o te comiste un número / El cuit no es existente en afip");</script>';
        if (strlen($cuit) != 13) return false;
    		$rv = false;
    		$resultado = 0;
    		$cuit_nro = str_replace("-", "", $cuit);
    		$codes = "6789456789";
    		$cuit_long = intVal($cuit_nro);
    		$verificador = intVal($cuit_nro[strlen($cuit_nro)-1]);
    		$x = 0;
    		while ($x < 10)
    		{
    			$digitoValidador = intVal(substr($codes, $x, 1));
    			$digito = intVal(substr($cuit_nro, $x, 1));
    			$digitoValidacion = $digitoValidador * $digito;
    			$resultado += $digitoValidacion;
    			$x++;
    		}
    		$resultado = intVal($resultado) % 11;
    		$rv = $resultado == $verificador;
    		return $rv;
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
