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
 * Table class for cabfac
 */
class Cabfac extends DbTable
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
    public $fecval;
    public $fecdoc;
    public $fecreg;
    public $cliente;
    public $cpago;
    public $fecvenc;
    public $direc;
    public $dnro;
    public $pisodto;
    public $codpost;
    public $codpais;
    public $codprov;
    public $codloc;
    public $telef;
    public $codrem;
    public $estado;
    public $emitido;
    public $moneda;
    public $totneto;
    public $totbruto;
    public $totiva105;
    public $totiva21;
    public $totimp;
    public $totcomis;
    public $totneto105;
    public $totneto21;
    public $tipoiva;
    public $porciva;
    public $nrengs;
    public $fechahora;
    public $usuario;
    public $tieneresol;
    public $leyendafc;
    public $concepto;
    public $nrodoc;
    public $tcompsal;
    public $seriesal;
    public $ncompsal;
    public $en_liquid;
    public $CAE;
    public $CAEFchVto;
    public $Resultado;
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
        $this->TableVar = "cabfac";
        $this->TableName = 'cabfac';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "cabfac";
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
            'SELECT' // Edit Tag
        );
        $this->tcomp->InputTextType = "text";
        $this->tcomp->Raw = true;
        $this->tcomp->IsForeignKey = true; // Foreign key field
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
        $this->serie->InputTextType = "text";
        $this->serie->Raw = true;
        $this->serie->IsForeignKey = true; // Foreign key field
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
        $this->ncomp->IsForeignKey = true; // Foreign key field
        $this->ncomp->Nullable = false; // NOT NULL field
        $this->ncomp->Required = true; // Required field
        $this->ncomp->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ncomp->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['ncomp'] = &$this->ncomp;

        // fecval
        $this->fecval = new DbField(
            $this, // Table
            'x_fecval', // Variable name
            'fecval', // Name
            '`fecval`', // Expression
            CastDateFieldForLike("`fecval`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecval`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecval->InputTextType = "text";
        $this->fecval->Raw = true;
        $this->fecval->Nullable = false; // NOT NULL field
        $this->fecval->Required = true; // Required field
        $this->fecval->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecval->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fecval'] = &$this->fecval;

        // fecdoc
        $this->fecdoc = new DbField(
            $this, // Table
            'x_fecdoc', // Variable name
            'fecdoc', // Name
            '`fecdoc`', // Expression
            CastDateFieldForLike("`fecdoc`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecdoc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecdoc->InputTextType = "text";
        $this->fecdoc->Raw = true;
        $this->fecdoc->Nullable = false; // NOT NULL field
        $this->fecdoc->Required = true; // Required field
        $this->fecdoc->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecdoc->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fecdoc'] = &$this->fecdoc;

        // fecreg
        $this->fecreg = new DbField(
            $this, // Table
            'x_fecreg', // Variable name
            'fecreg', // Name
            '`fecreg`', // Expression
            CastDateFieldForLike("`fecreg`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecreg`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecreg->InputTextType = "text";
        $this->fecreg->Raw = true;
        $this->fecreg->Nullable = false; // NOT NULL field
        $this->fecreg->Required = true; // Required field
        $this->fecreg->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecreg->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fecreg'] = &$this->fecreg;

        // cliente
        $this->cliente = new DbField(
            $this, // Table
            'x_cliente', // Variable name
            'cliente', // Name
            '`cliente`', // Expression
            '`cliente`', // Basic search expression
            3, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cliente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->cliente->addMethod("getSelectFilter", fn() => "`activo`=1 && `tipoent` = 1");
        $this->cliente->InputTextType = "text";
        $this->cliente->Raw = true;
        $this->cliente->setSelectMultiple(false); // Select one
        $this->cliente->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cliente->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->cliente->Lookup = new Lookup($this->cliente, 'entidades', false, 'codnum', ["razsoc","","",""], '', '', [], [], [], [], [], [], false, '`razsoc` ASC', '', "`razsoc`");
                break;
            default:
                $this->cliente->Lookup = new Lookup($this->cliente, 'entidades', false, 'codnum', ["razsoc","","",""], '', '', [], [], [], [], [], [], false, '`razsoc` ASC', '', "`razsoc`");
                break;
        }
        $this->cliente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cliente->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['cliente'] = &$this->cliente;

        // cpago
        $this->cpago = new DbField(
            $this, // Table
            'x_cpago', // Variable name
            'cpago', // Name
            '`cpago`', // Expression
            '`cpago`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cpago`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cpago->InputTextType = "text";
        $this->cpago->Raw = true;
        $this->cpago->Required = true; // Required field
        $this->cpago->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cpago->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['cpago'] = &$this->cpago;

        // fecvenc
        $this->fecvenc = new DbField(
            $this, // Table
            'x_fecvenc', // Variable name
            'fecvenc', // Name
            '`fecvenc`', // Expression
            CastDateFieldForLike("`fecvenc`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecvenc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecvenc->InputTextType = "text";
        $this->fecvenc->Raw = true;
        $this->fecvenc->Nullable = false; // NOT NULL field
        $this->fecvenc->Required = true; // Required field
        $this->fecvenc->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecvenc->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fecvenc'] = &$this->fecvenc;

        // direc
        $this->direc = new DbField(
            $this, // Table
            'x_direc', // Variable name
            'direc', // Name
            '`direc`', // Expression
            '`direc`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`direc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->direc->InputTextType = "text";
        $this->direc->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['direc'] = &$this->direc;

        // dnro
        $this->dnro = new DbField(
            $this, // Table
            'x_dnro', // Variable name
            'dnro', // Name
            '`dnro`', // Expression
            '`dnro`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`dnro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->dnro->InputTextType = "text";
        $this->dnro->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['dnro'] = &$this->dnro;

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
            'HIDDEN' // Edit Tag
        );
        $this->pisodto->InputTextType = "text";
        $this->pisodto->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['pisodto'] = &$this->pisodto;

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
            'HIDDEN' // Edit Tag
        );
        $this->codpost->InputTextType = "text";
        $this->codpost->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['codpost'] = &$this->codpost;

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
            'HIDDEN' // Edit Tag
        );
        $this->codpais->InputTextType = "text";
        $this->codpais->Raw = true;
        $this->codpais->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codpais->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
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
            '`codprov`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->codprov->InputTextType = "text";
        $this->codprov->Raw = true;
        $this->codprov->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codprov->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
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
            '`codloc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->codloc->InputTextType = "text";
        $this->codloc->Raw = true;
        $this->codloc->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codloc->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['codloc'] = &$this->codloc;

        // telef
        $this->telef = new DbField(
            $this, // Table
            'x_telef', // Variable name
            'telef', // Name
            '`telef`', // Expression
            '`telef`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telef`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->telef->InputTextType = "text";
        $this->telef->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['telef'] = &$this->telef;

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
                $this->codrem->Lookup = new Lookup($this->codrem, 'remates', false, 'ncomp', ["ncomp","observacion","",""], '', '', [], [], [], [], [], [], false, '`ncomp` DESC', '', "CONCAT(COALESCE(`ncomp`, ''),'" . ValueSeparator(1, $this->codrem) . "',COALESCE(`observacion`,''))");
                break;
            default:
                $this->codrem->Lookup = new Lookup($this->codrem, 'remates', false, 'ncomp', ["ncomp","observacion","",""], '', '', [], [], [], [], [], [], false, '`ncomp` DESC', '', "CONCAT(COALESCE(`ncomp`, ''),'" . ValueSeparator(1, $this->codrem) . "',COALESCE(`observacion`,''))");
                break;
        }
        $this->codrem->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codrem->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['codrem'] = &$this->codrem;

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
            'RADIO' // Edit Tag
        );
        $this->estado->InputTextType = "text";
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->estado->Lookup = new Lookup($this->estado, 'cabfac', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->estado->Lookup = new Lookup($this->estado, 'cabfac', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->estado->OptionCount = 2;
        $this->estado->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estado'] = &$this->estado;

        // emitido
        $this->emitido = new DbField(
            $this, // Table
            'x_emitido', // Variable name
            'emitido', // Name
            '`emitido`', // Expression
            '`emitido`', // Basic search expression
            16, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`emitido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->emitido->InputTextType = "text";
        $this->emitido->Raw = true;
        $this->emitido->setDataType(DataType::BOOLEAN);
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->emitido->Lookup = new Lookup($this->emitido, 'cabfac', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->emitido->Lookup = new Lookup($this->emitido, 'cabfac', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->emitido->OptionCount = 2;
        $this->emitido->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->emitido->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['emitido'] = &$this->emitido;

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
        $this->moneda->addMethod("getDefault", fn() => 0);
        $this->moneda->InputTextType = "text";
        $this->moneda->Raw = true;
        $this->moneda->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->moneda->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['moneda'] = &$this->moneda;

        // totneto
        $this->totneto = new DbField(
            $this, // Table
            'x_totneto', // Variable name
            'totneto', // Name
            '`totneto`', // Expression
            '`totneto`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totneto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totneto->addMethod("getDefault", fn() => 0.00);
        $this->totneto->InputTextType = "text";
        $this->totneto->Raw = true;
        $this->totneto->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totneto->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['totneto'] = &$this->totneto;

        // totbruto
        $this->totbruto = new DbField(
            $this, // Table
            'x_totbruto', // Variable name
            'totbruto', // Name
            '`totbruto`', // Expression
            '`totbruto`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totbruto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totbruto->addMethod("getDefault", fn() => 0.00);
        $this->totbruto->InputTextType = "text";
        $this->totbruto->Raw = true;
        $this->totbruto->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totbruto->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['totbruto'] = &$this->totbruto;

        // totiva105
        $this->totiva105 = new DbField(
            $this, // Table
            'x_totiva105', // Variable name
            'totiva105', // Name
            '`totiva105`', // Expression
            '`totiva105`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totiva105`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totiva105->addMethod("getDefault", fn() => 0.00);
        $this->totiva105->InputTextType = "text";
        $this->totiva105->Raw = true;
        $this->totiva105->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totiva105->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['totiva105'] = &$this->totiva105;

        // totiva21
        $this->totiva21 = new DbField(
            $this, // Table
            'x_totiva21', // Variable name
            'totiva21', // Name
            '`totiva21`', // Expression
            '`totiva21`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totiva21`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totiva21->addMethod("getDefault", fn() => 0.00);
        $this->totiva21->InputTextType = "text";
        $this->totiva21->Raw = true;
        $this->totiva21->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totiva21->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['totiva21'] = &$this->totiva21;

        // totimp
        $this->totimp = new DbField(
            $this, // Table
            'x_totimp', // Variable name
            'totimp', // Name
            '`totimp`', // Expression
            '`totimp`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totimp`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totimp->addMethod("getDefault", fn() => 0.00);
        $this->totimp->InputTextType = "text";
        $this->totimp->Raw = true;
        $this->totimp->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totimp->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['totimp'] = &$this->totimp;

        // totcomis
        $this->totcomis = new DbField(
            $this, // Table
            'x_totcomis', // Variable name
            'totcomis', // Name
            '`totcomis`', // Expression
            '`totcomis`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totcomis`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totcomis->addMethod("getDefault", fn() => 0.00);
        $this->totcomis->InputTextType = "text";
        $this->totcomis->Raw = true;
        $this->totcomis->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totcomis->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['totcomis'] = &$this->totcomis;

        // totneto105
        $this->totneto105 = new DbField(
            $this, // Table
            'x_totneto105', // Variable name
            'totneto105', // Name
            '`totneto105`', // Expression
            '`totneto105`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totneto105`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totneto105->addMethod("getDefault", fn() => 0.00);
        $this->totneto105->InputTextType = "text";
        $this->totneto105->Raw = true;
        $this->totneto105->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totneto105->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['totneto105'] = &$this->totneto105;

        // totneto21
        $this->totneto21 = new DbField(
            $this, // Table
            'x_totneto21', // Variable name
            'totneto21', // Name
            '`totneto21`', // Expression
            '`totneto21`', // Basic search expression
            131, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totneto21`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totneto21->addMethod("getDefault", fn() => 0.00);
        $this->totneto21->InputTextType = "text";
        $this->totneto21->Raw = true;
        $this->totneto21->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totneto21->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['totneto21'] = &$this->totneto21;

        // tipoiva
        $this->tipoiva = new DbField(
            $this, // Table
            'x_tipoiva', // Variable name
            'tipoiva', // Name
            '`tipoiva`', // Expression
            '`tipoiva`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipoiva`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->tipoiva->addMethod("getDefault", fn() => 0);
        $this->tipoiva->InputTextType = "text";
        $this->tipoiva->Raw = true;
        $this->tipoiva->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipoiva->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipoiva'] = &$this->tipoiva;

        // porciva
        $this->porciva = new DbField(
            $this, // Table
            'x_porciva', // Variable name
            'porciva', // Name
            '`porciva`', // Expression
            '`porciva`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`porciva`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->porciva->addMethod("getDefault", fn() => 0);
        $this->porciva->InputTextType = "text";
        $this->porciva->Raw = true;
        $this->porciva->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->porciva->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['porciva'] = &$this->porciva;

        // nrengs
        $this->nrengs = new DbField(
            $this, // Table
            'x_nrengs', // Variable name
            'nrengs', // Name
            '`nrengs`', // Expression
            '`nrengs`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nrengs`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nrengs->InputTextType = "text";
        $this->nrengs->Raw = true;
        $this->nrengs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->nrengs->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['nrengs'] = &$this->nrengs;

        // fechahora
        $this->fechahora = new DbField(
            $this, // Table
            'x_fechahora', // Variable name
            'fechahora', // Name
            '`fechahora`', // Expression
            CastDateFieldForLike("`fechahora`", 17, "DB"), // Basic search expression
            135, // Type
            19, // Size
            17, // Date/Time format
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
        $this->fechahora->Nullable = false; // NOT NULL field
        $this->fechahora->DefaultErrorMessage = str_replace("%s", DateFormat(17), $Language->phrase("IncorrectDate"));
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
        $this->usuario->addMethod("getDefault", fn() => 1);
        $this->usuario->InputTextType = "text";
        $this->usuario->Raw = true;
        $this->usuario->Nullable = false; // NOT NULL field
        $this->usuario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['usuario'] = &$this->usuario;

        // tieneresol
        $this->tieneresol = new DbField(
            $this, // Table
            'x_tieneresol', // Variable name
            'tieneresol', // Name
            '`tieneresol`', // Expression
            '`tieneresol`', // Basic search expression
            16, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tieneresol`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->tieneresol->addMethod("getDefault", fn() => 0);
        $this->tieneresol->InputTextType = "text";
        $this->tieneresol->Raw = true;
        $this->tieneresol->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->tieneresol->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tieneresol'] = &$this->tieneresol;

        // leyendafc
        $this->leyendafc = new DbField(
            $this, // Table
            'x_leyendafc', // Variable name
            'leyendafc', // Name
            '`leyendafc`', // Expression
            '`leyendafc`', // Basic search expression
            200, // Type
            500, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`leyendafc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'HIDDEN' // Edit Tag
        );
        $this->leyendafc->InputTextType = "text";
        $this->leyendafc->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['leyendafc'] = &$this->leyendafc;

        // concepto
        $this->concepto = new DbField(
            $this, // Table
            'x_concepto', // Variable name
            'concepto', // Name
            '`concepto`', // Expression
            '`concepto`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`concepto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->concepto->InputTextType = "text";
        $this->concepto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['concepto'] = &$this->concepto;

        // nrodoc
        $this->nrodoc = new DbField(
            $this, // Table
            'x_nrodoc', // Variable name
            'nrodoc', // Name
            '`nrodoc`', // Expression
            '`nrodoc`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nrodoc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nrodoc->InputTextType = "text";
        $this->nrodoc->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nrodoc'] = &$this->nrodoc;

        // tcompsal
        $this->tcompsal = new DbField(
            $this, // Table
            'x_tcompsal', // Variable name
            'tcompsal', // Name
            '`tcompsal`', // Expression
            '`tcompsal`', // Basic search expression
            3, // Type
            3, // Size
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
            3, // Size
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

        // en_liquid
        $this->en_liquid = new DbField(
            $this, // Table
            'x_en_liquid', // Variable name
            'en_liquid', // Name
            '`en_liquid`', // Expression
            '`en_liquid`', // Basic search expression
            3, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`en_liquid`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->en_liquid->InputTextType = "text";
        $this->en_liquid->Raw = true;
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->en_liquid->Lookup = new Lookup($this->en_liquid, 'cabfac', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
            default:
                $this->en_liquid->Lookup = new Lookup($this->en_liquid, 'cabfac', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
                break;
        }
        $this->en_liquid->OptionCount = 2;
        $this->en_liquid->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->en_liquid->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['en_liquid'] = &$this->en_liquid;

        // CAE
        $this->CAE = new DbField(
            $this, // Table
            'x_CAE', // Variable name
            'CAE', // Name
            '`CAE`', // Expression
            '`CAE`', // Basic search expression
            20, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`CAE`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->CAE->InputTextType = "text";
        $this->CAE->Raw = true;
        $this->CAE->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CAE->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['CAE'] = &$this->CAE;

        // CAEFchVto
        $this->CAEFchVto = new DbField(
            $this, // Table
            'x_CAEFchVto', // Variable name
            'CAEFchVto', // Name
            '`CAEFchVto`', // Expression
            CastDateFieldForLike("`CAEFchVto`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`CAEFchVto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->CAEFchVto->InputTextType = "text";
        $this->CAEFchVto->Raw = true;
        $this->CAEFchVto->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->CAEFchVto->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['CAEFchVto'] = &$this->CAEFchVto;

        // Resultado
        $this->Resultado = new DbField(
            $this, // Table
            'x_Resultado', // Variable name
            'Resultado', // Name
            '`Resultado`', // Expression
            '`Resultado`', // Basic search expression
            200, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Resultado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Resultado->InputTextType = "text";
        $this->Resultado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Resultado'] = &$this->Resultado;

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
        if ($this->getCurrentDetailTable() == "detfac") {
            $detailUrl = Container("detfac")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_tcomp", $this->tcomp->CurrentValue);
            $detailUrl .= "&" . GetForeignKeyUrl("fk_serie", $this->serie->CurrentValue);
            $detailUrl .= "&" . GetForeignKeyUrl("fk_ncomp", $this->ncomp->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "CabfacList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "cabfac";
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
        // Cascade Update detail table 'detfac'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['tcomp']) && $rsold['tcomp'] != $rs['tcomp'])) { // Update detail field 'tcomp'
            $cascadeUpdate = true;
            $rscascade['tcomp'] = $rs['tcomp'];
        }
        if ($rsold && (isset($rs['serie']) && $rsold['serie'] != $rs['serie'])) { // Update detail field 'serie'
            $cascadeUpdate = true;
            $rscascade['serie'] = $rs['serie'];
        }
        if ($rsold && (isset($rs['ncomp']) && $rsold['ncomp'] != $rs['ncomp'])) { // Update detail field 'ncomp'
            $cascadeUpdate = true;
            $rscascade['ncomp'] = $rs['ncomp'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("detfac")->loadRs("`tcomp` = " . QuotedValue($rsold['tcomp'], DataType::NUMBER, 'DB') . " AND " . "`serie` = " . QuotedValue($rsold['serie'], DataType::NUMBER, 'DB') . " AND " . "`ncomp` = " . QuotedValue($rsold['ncomp'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'codnum';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("detfac")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("detfac")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("detfac")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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

        // Cascade delete detail table 'detfac'
        $dtlrows = Container("detfac")->loadRs("`tcomp` = " . QuotedValue($rs['tcomp'], DataType::NUMBER, "DB") . " AND " . "`serie` = " . QuotedValue($rs['serie'], DataType::NUMBER, "DB") . " AND " . "`ncomp` = " . QuotedValue($rs['ncomp'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("detfac")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("detfac")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("detfac")->rowDeleted($dtlrow);
            }
        }
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
        $this->fecval->DbValue = $row['fecval'];
        $this->fecdoc->DbValue = $row['fecdoc'];
        $this->fecreg->DbValue = $row['fecreg'];
        $this->cliente->DbValue = $row['cliente'];
        $this->cpago->DbValue = $row['cpago'];
        $this->fecvenc->DbValue = $row['fecvenc'];
        $this->direc->DbValue = $row['direc'];
        $this->dnro->DbValue = $row['dnro'];
        $this->pisodto->DbValue = $row['pisodto'];
        $this->codpost->DbValue = $row['codpost'];
        $this->codpais->DbValue = $row['codpais'];
        $this->codprov->DbValue = $row['codprov'];
        $this->codloc->DbValue = $row['codloc'];
        $this->telef->DbValue = $row['telef'];
        $this->codrem->DbValue = $row['codrem'];
        $this->estado->DbValue = $row['estado'];
        $this->emitido->DbValue = $row['emitido'];
        $this->moneda->DbValue = $row['moneda'];
        $this->totneto->DbValue = $row['totneto'];
        $this->totbruto->DbValue = $row['totbruto'];
        $this->totiva105->DbValue = $row['totiva105'];
        $this->totiva21->DbValue = $row['totiva21'];
        $this->totimp->DbValue = $row['totimp'];
        $this->totcomis->DbValue = $row['totcomis'];
        $this->totneto105->DbValue = $row['totneto105'];
        $this->totneto21->DbValue = $row['totneto21'];
        $this->tipoiva->DbValue = $row['tipoiva'];
        $this->porciva->DbValue = $row['porciva'];
        $this->nrengs->DbValue = $row['nrengs'];
        $this->fechahora->DbValue = $row['fechahora'];
        $this->usuario->DbValue = $row['usuario'];
        $this->tieneresol->DbValue = $row['tieneresol'];
        $this->leyendafc->DbValue = $row['leyendafc'];
        $this->concepto->DbValue = $row['concepto'];
        $this->nrodoc->DbValue = $row['nrodoc'];
        $this->tcompsal->DbValue = $row['tcompsal'];
        $this->seriesal->DbValue = $row['seriesal'];
        $this->ncompsal->DbValue = $row['ncompsal'];
        $this->en_liquid->DbValue = $row['en_liquid'];
        $this->CAE->DbValue = $row['CAE'];
        $this->CAEFchVto->DbValue = $row['CAEFchVto'];
        $this->Resultado->DbValue = $row['Resultado'];
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
        return $_SESSION[$name] ?? GetUrl("CabfacList");
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
            "CabfacView" => $Language->phrase("View"),
            "CabfacEdit" => $Language->phrase("Edit"),
            "CabfacAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "CabfacList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "CabfacView",
            Config("API_ADD_ACTION") => "CabfacAdd",
            Config("API_EDIT_ACTION") => "CabfacEdit",
            Config("API_DELETE_ACTION") => "CabfacDelete",
            Config("API_LIST_ACTION") => "CabfacList",
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
        return "CabfacList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CabfacView", $parm);
        } else {
            $url = $this->keyUrl("CabfacView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "CabfacAdd?" . $parm;
        } else {
            $url = "CabfacAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CabfacEdit", $parm);
        } else {
            $url = $this->keyUrl("CabfacEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("CabfacList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CabfacAdd", $parm);
        } else {
            $url = $this->keyUrl("CabfacAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("CabfacList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("CabfacDelete", $parm);
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
        $this->fecval->setDbValue($row['fecval']);
        $this->fecdoc->setDbValue($row['fecdoc']);
        $this->fecreg->setDbValue($row['fecreg']);
        $this->cliente->setDbValue($row['cliente']);
        $this->cpago->setDbValue($row['cpago']);
        $this->fecvenc->setDbValue($row['fecvenc']);
        $this->direc->setDbValue($row['direc']);
        $this->dnro->setDbValue($row['dnro']);
        $this->pisodto->setDbValue($row['pisodto']);
        $this->codpost->setDbValue($row['codpost']);
        $this->codpais->setDbValue($row['codpais']);
        $this->codprov->setDbValue($row['codprov']);
        $this->codloc->setDbValue($row['codloc']);
        $this->telef->setDbValue($row['telef']);
        $this->codrem->setDbValue($row['codrem']);
        $this->estado->setDbValue($row['estado']);
        $this->emitido->setDbValue($row['emitido']);
        $this->moneda->setDbValue($row['moneda']);
        $this->totneto->setDbValue($row['totneto']);
        $this->totbruto->setDbValue($row['totbruto']);
        $this->totiva105->setDbValue($row['totiva105']);
        $this->totiva21->setDbValue($row['totiva21']);
        $this->totimp->setDbValue($row['totimp']);
        $this->totcomis->setDbValue($row['totcomis']);
        $this->totneto105->setDbValue($row['totneto105']);
        $this->totneto21->setDbValue($row['totneto21']);
        $this->tipoiva->setDbValue($row['tipoiva']);
        $this->porciva->setDbValue($row['porciva']);
        $this->nrengs->setDbValue($row['nrengs']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->usuario->setDbValue($row['usuario']);
        $this->tieneresol->setDbValue($row['tieneresol']);
        $this->leyendafc->setDbValue($row['leyendafc']);
        $this->concepto->setDbValue($row['concepto']);
        $this->nrodoc->setDbValue($row['nrodoc']);
        $this->tcompsal->setDbValue($row['tcompsal']);
        $this->seriesal->setDbValue($row['seriesal']);
        $this->ncompsal->setDbValue($row['ncompsal']);
        $this->en_liquid->setDbValue($row['en_liquid']);
        $this->CAE->setDbValue($row['CAE']);
        $this->CAEFchVto->setDbValue($row['CAEFchVto']);
        $this->Resultado->setDbValue($row['Resultado']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "CabfacList";
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

        // fecval

        // fecdoc

        // fecreg

        // cliente

        // cpago

        // fecvenc

        // direc

        // dnro

        // pisodto

        // codpost

        // codpais

        // codprov

        // codloc

        // telef

        // codrem

        // estado

        // emitido

        // moneda

        // totneto

        // totbruto

        // totiva105

        // totiva21

        // totimp

        // totcomis

        // totneto105

        // totneto21

        // tipoiva

        // porciva

        // nrengs

        // fechahora

        // usuario

        // tieneresol

        // leyendafc

        // concepto

        // nrodoc

        // tcompsal

        // seriesal

        // ncompsal

        // en_liquid

        // CAE

        // CAEFchVto

        // Resultado

        // usuarioultmod

        // fecultmod

        // codnum
        $this->codnum->ViewValue = $this->codnum->CurrentValue;

        // tcomp
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
        $curVal = strval($this->serie->CurrentValue);
        if ($curVal != "") {
            $this->serie->ViewValue = $this->serie->lookupCacheOption($curVal);
            if ($this->serie->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->serie->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->serie->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $sqlWrk = $this->serie->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

        // ncomp
        $this->ncomp->ViewValue = $this->ncomp->CurrentValue;
        $this->ncomp->ViewValue = FormatNumber($this->ncomp->ViewValue, $this->ncomp->formatPattern());

        // fecval
        $this->fecval->ViewValue = $this->fecval->CurrentValue;
        $this->fecval->ViewValue = FormatDateTime($this->fecval->ViewValue, $this->fecval->formatPattern());

        // fecdoc
        $this->fecdoc->ViewValue = $this->fecdoc->CurrentValue;
        $this->fecdoc->ViewValue = FormatDateTime($this->fecdoc->ViewValue, $this->fecdoc->formatPattern());

        // fecreg
        $this->fecreg->ViewValue = $this->fecreg->CurrentValue;
        $this->fecreg->ViewValue = FormatDateTime($this->fecreg->ViewValue, $this->fecreg->formatPattern());

        // cliente
        $curVal = strval($this->cliente->CurrentValue);
        if ($curVal != "") {
            $this->cliente->ViewValue = $this->cliente->lookupCacheOption($curVal);
            if ($this->cliente->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->cliente->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->cliente->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                $lookupFilter = $this->cliente->getSelectFilter($this); // PHP
                $sqlWrk = $this->cliente->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cliente->Lookup->renderViewRow($rswrk[0]);
                    $this->cliente->ViewValue = $this->cliente->displayValue($arwrk);
                } else {
                    $this->cliente->ViewValue = FormatNumber($this->cliente->CurrentValue, $this->cliente->formatPattern());
                }
            }
        } else {
            $this->cliente->ViewValue = null;
        }

        // cpago
        $this->cpago->ViewValue = $this->cpago->CurrentValue;
        $this->cpago->ViewValue = FormatNumber($this->cpago->ViewValue, $this->cpago->formatPattern());

        // fecvenc
        $this->fecvenc->ViewValue = $this->fecvenc->CurrentValue;
        $this->fecvenc->ViewValue = FormatDateTime($this->fecvenc->ViewValue, $this->fecvenc->formatPattern());

        // direc
        $this->direc->ViewValue = $this->direc->CurrentValue;

        // dnro
        $this->dnro->ViewValue = $this->dnro->CurrentValue;

        // pisodto
        $this->pisodto->ViewValue = $this->pisodto->CurrentValue;

        // codpost
        $this->codpost->ViewValue = $this->codpost->CurrentValue;

        // codpais
        $this->codpais->ViewValue = $this->codpais->CurrentValue;
        $this->codpais->ViewValue = FormatNumber($this->codpais->ViewValue, $this->codpais->formatPattern());

        // codprov
        $this->codprov->ViewValue = $this->codprov->CurrentValue;
        $this->codprov->ViewValue = FormatNumber($this->codprov->ViewValue, $this->codprov->formatPattern());

        // codloc
        $this->codloc->ViewValue = $this->codloc->CurrentValue;
        $this->codloc->ViewValue = FormatNumber($this->codloc->ViewValue, $this->codloc->formatPattern());

        // telef
        $this->telef->ViewValue = $this->telef->CurrentValue;

        // codrem
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

        // estado
        if (strval($this->estado->CurrentValue) != "") {
            $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
        } else {
            $this->estado->ViewValue = null;
        }

        // emitido
        if (ConvertToBool($this->emitido->CurrentValue)) {
            $this->emitido->ViewValue = $this->emitido->tagCaption(1) != "" ? $this->emitido->tagCaption(1) : "Sí";
        } else {
            $this->emitido->ViewValue = $this->emitido->tagCaption(2) != "" ? $this->emitido->tagCaption(2) : "No";
        }

        // moneda
        $this->moneda->ViewValue = $this->moneda->CurrentValue;
        $this->moneda->ViewValue = FormatNumber($this->moneda->ViewValue, $this->moneda->formatPattern());

        // totneto
        $this->totneto->ViewValue = $this->totneto->CurrentValue;
        $this->totneto->ViewValue = FormatNumber($this->totneto->ViewValue, $this->totneto->formatPattern());

        // totbruto
        $this->totbruto->ViewValue = $this->totbruto->CurrentValue;
        $this->totbruto->ViewValue = FormatNumber($this->totbruto->ViewValue, $this->totbruto->formatPattern());

        // totiva105
        $this->totiva105->ViewValue = $this->totiva105->CurrentValue;
        $this->totiva105->ViewValue = FormatNumber($this->totiva105->ViewValue, $this->totiva105->formatPattern());

        // totiva21
        $this->totiva21->ViewValue = $this->totiva21->CurrentValue;
        $this->totiva21->ViewValue = FormatNumber($this->totiva21->ViewValue, $this->totiva21->formatPattern());

        // totimp
        $this->totimp->ViewValue = $this->totimp->CurrentValue;
        $this->totimp->ViewValue = FormatNumber($this->totimp->ViewValue, $this->totimp->formatPattern());

        // totcomis
        $this->totcomis->ViewValue = $this->totcomis->CurrentValue;
        $this->totcomis->ViewValue = FormatNumber($this->totcomis->ViewValue, $this->totcomis->formatPattern());

        // totneto105
        $this->totneto105->ViewValue = $this->totneto105->CurrentValue;
        $this->totneto105->ViewValue = FormatNumber($this->totneto105->ViewValue, $this->totneto105->formatPattern());

        // totneto21
        $this->totneto21->ViewValue = $this->totneto21->CurrentValue;
        $this->totneto21->ViewValue = FormatNumber($this->totneto21->ViewValue, $this->totneto21->formatPattern());

        // tipoiva
        $this->tipoiva->ViewValue = $this->tipoiva->CurrentValue;
        $this->tipoiva->ViewValue = FormatNumber($this->tipoiva->ViewValue, $this->tipoiva->formatPattern());

        // porciva
        $this->porciva->ViewValue = $this->porciva->CurrentValue;
        $this->porciva->ViewValue = FormatNumber($this->porciva->ViewValue, $this->porciva->formatPattern());

        // nrengs
        $this->nrengs->ViewValue = $this->nrengs->CurrentValue;
        $this->nrengs->ViewValue = FormatNumber($this->nrengs->ViewValue, $this->nrengs->formatPattern());

        // fechahora
        $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
        $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

        // usuario
        $this->usuario->ViewValue = $this->usuario->CurrentValue;
        $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

        // tieneresol
        $this->tieneresol->ViewValue = $this->tieneresol->CurrentValue;

        // leyendafc
        $this->leyendafc->ViewValue = $this->leyendafc->CurrentValue;

        // concepto
        $this->concepto->ViewValue = $this->concepto->CurrentValue;

        // nrodoc
        $this->nrodoc->ViewValue = $this->nrodoc->CurrentValue;

        // tcompsal
        $this->tcompsal->ViewValue = $this->tcompsal->CurrentValue;
        $this->tcompsal->ViewValue = FormatNumber($this->tcompsal->ViewValue, $this->tcompsal->formatPattern());

        // seriesal
        $this->seriesal->ViewValue = $this->seriesal->CurrentValue;
        $this->seriesal->ViewValue = FormatNumber($this->seriesal->ViewValue, $this->seriesal->formatPattern());

        // ncompsal
        $this->ncompsal->ViewValue = $this->ncompsal->CurrentValue;
        $this->ncompsal->ViewValue = FormatNumber($this->ncompsal->ViewValue, $this->ncompsal->formatPattern());

        // en_liquid
        if (strval($this->en_liquid->CurrentValue) != "") {
            $this->en_liquid->ViewValue = $this->en_liquid->optionCaption($this->en_liquid->CurrentValue);
        } else {
            $this->en_liquid->ViewValue = null;
        }

        // CAE
        $this->CAE->ViewValue = $this->CAE->CurrentValue;
        $this->CAE->ViewValue = FormatNumber($this->CAE->ViewValue, $this->CAE->formatPattern());

        // CAEFchVto
        $this->CAEFchVto->ViewValue = $this->CAEFchVto->CurrentValue;
        $this->CAEFchVto->ViewValue = FormatDateTime($this->CAEFchVto->ViewValue, $this->CAEFchVto->formatPattern());

        // Resultado
        $this->Resultado->ViewValue = $this->Resultado->CurrentValue;

        // usuarioultmod
        $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
        $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

        // fecultmod
        $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
        $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

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

        // fecval
        $this->fecval->HrefValue = "";
        $this->fecval->TooltipValue = "";

        // fecdoc
        $this->fecdoc->HrefValue = "";
        $this->fecdoc->TooltipValue = "";

        // fecreg
        $this->fecreg->HrefValue = "";
        $this->fecreg->TooltipValue = "";

        // cliente
        $this->cliente->HrefValue = "";
        $this->cliente->TooltipValue = "";

        // cpago
        $this->cpago->HrefValue = "";
        $this->cpago->TooltipValue = "";

        // fecvenc
        $this->fecvenc->HrefValue = "";
        $this->fecvenc->TooltipValue = "";

        // direc
        $this->direc->HrefValue = "";
        $this->direc->TooltipValue = "";

        // dnro
        $this->dnro->HrefValue = "";
        $this->dnro->TooltipValue = "";

        // pisodto
        $this->pisodto->HrefValue = "";
        $this->pisodto->TooltipValue = "";

        // codpost
        $this->codpost->HrefValue = "";
        $this->codpost->TooltipValue = "";

        // codpais
        $this->codpais->HrefValue = "";
        $this->codpais->TooltipValue = "";

        // codprov
        $this->codprov->HrefValue = "";
        $this->codprov->TooltipValue = "";

        // codloc
        $this->codloc->HrefValue = "";
        $this->codloc->TooltipValue = "";

        // telef
        $this->telef->HrefValue = "";
        $this->telef->TooltipValue = "";

        // codrem
        $this->codrem->HrefValue = "";
        $this->codrem->TooltipValue = "";

        // estado
        $this->estado->HrefValue = "";
        $this->estado->TooltipValue = "";

        // emitido
        $this->emitido->HrefValue = "";
        $this->emitido->TooltipValue = "";

        // moneda
        $this->moneda->HrefValue = "";
        $this->moneda->TooltipValue = "";

        // totneto
        $this->totneto->HrefValue = "";
        $this->totneto->TooltipValue = "";

        // totbruto
        $this->totbruto->HrefValue = "";
        $this->totbruto->TooltipValue = "";

        // totiva105
        $this->totiva105->HrefValue = "";
        $this->totiva105->TooltipValue = "";

        // totiva21
        $this->totiva21->HrefValue = "";
        $this->totiva21->TooltipValue = "";

        // totimp
        $this->totimp->HrefValue = "";
        $this->totimp->TooltipValue = "";

        // totcomis
        $this->totcomis->HrefValue = "";
        $this->totcomis->TooltipValue = "";

        // totneto105
        $this->totneto105->HrefValue = "";
        $this->totneto105->TooltipValue = "";

        // totneto21
        $this->totneto21->HrefValue = "";
        $this->totneto21->TooltipValue = "";

        // tipoiva
        $this->tipoiva->HrefValue = "";
        $this->tipoiva->TooltipValue = "";

        // porciva
        $this->porciva->HrefValue = "";
        $this->porciva->TooltipValue = "";

        // nrengs
        $this->nrengs->HrefValue = "";
        $this->nrengs->TooltipValue = "";

        // fechahora
        $this->fechahora->HrefValue = "";
        $this->fechahora->TooltipValue = "";

        // usuario
        $this->usuario->HrefValue = "";
        $this->usuario->TooltipValue = "";

        // tieneresol
        $this->tieneresol->HrefValue = "";
        $this->tieneresol->TooltipValue = "";

        // leyendafc
        $this->leyendafc->HrefValue = "";
        $this->leyendafc->TooltipValue = "";

        // concepto
        $this->concepto->HrefValue = "";
        $this->concepto->TooltipValue = "";

        // nrodoc
        $this->nrodoc->HrefValue = "";
        $this->nrodoc->TooltipValue = "";

        // tcompsal
        $this->tcompsal->HrefValue = "";
        $this->tcompsal->TooltipValue = "";

        // seriesal
        $this->seriesal->HrefValue = "";
        $this->seriesal->TooltipValue = "";

        // ncompsal
        $this->ncompsal->HrefValue = "";
        $this->ncompsal->TooltipValue = "";

        // en_liquid
        $this->en_liquid->HrefValue = "";
        $this->en_liquid->TooltipValue = "";

        // CAE
        $this->CAE->HrefValue = "";
        $this->CAE->TooltipValue = "";

        // CAEFchVto
        $this->CAEFchVto->HrefValue = "";
        $this->CAEFchVto->TooltipValue = "";

        // Resultado
        $this->Resultado->HrefValue = "";
        $this->Resultado->TooltipValue = "";

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

        // tcomp
        $this->tcomp->setupEditAttributes();
        $this->tcomp->PlaceHolder = RemoveHtml($this->tcomp->caption());

        // serie
        $this->serie->setupEditAttributes();
        $this->serie->PlaceHolder = RemoveHtml($this->serie->caption());

        // ncomp
        $this->ncomp->setupEditAttributes();
        $this->ncomp->EditValue = $this->ncomp->CurrentValue;
        $this->ncomp->PlaceHolder = RemoveHtml($this->ncomp->caption());
        if (strval($this->ncomp->EditValue) != "" && is_numeric($this->ncomp->EditValue)) {
            $this->ncomp->EditValue = FormatNumber($this->ncomp->EditValue, null);
        }

        // fecval
        $this->fecval->setupEditAttributes();
        $this->fecval->EditValue = FormatDateTime($this->fecval->CurrentValue, $this->fecval->formatPattern());
        $this->fecval->PlaceHolder = RemoveHtml($this->fecval->caption());

        // fecdoc
        $this->fecdoc->setupEditAttributes();
        $this->fecdoc->EditValue = FormatDateTime($this->fecdoc->CurrentValue, $this->fecdoc->formatPattern());
        $this->fecdoc->PlaceHolder = RemoveHtml($this->fecdoc->caption());

        // fecreg
        $this->fecreg->setupEditAttributes();
        $this->fecreg->EditValue = FormatDateTime($this->fecreg->CurrentValue, $this->fecreg->formatPattern());
        $this->fecreg->PlaceHolder = RemoveHtml($this->fecreg->caption());

        // cliente
        $this->cliente->setupEditAttributes();
        $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

        // cpago
        $this->cpago->setupEditAttributes();
        $this->cpago->EditValue = $this->cpago->CurrentValue;
        $this->cpago->PlaceHolder = RemoveHtml($this->cpago->caption());
        if (strval($this->cpago->EditValue) != "" && is_numeric($this->cpago->EditValue)) {
            $this->cpago->EditValue = FormatNumber($this->cpago->EditValue, null);
        }

        // fecvenc
        $this->fecvenc->setupEditAttributes();
        $this->fecvenc->EditValue = FormatDateTime($this->fecvenc->CurrentValue, $this->fecvenc->formatPattern());
        $this->fecvenc->PlaceHolder = RemoveHtml($this->fecvenc->caption());

        // direc
        $this->direc->setupEditAttributes();

        // dnro
        $this->dnro->setupEditAttributes();

        // pisodto
        $this->pisodto->setupEditAttributes();

        // codpost
        $this->codpost->setupEditAttributes();

        // codpais
        $this->codpais->setupEditAttributes();
        $this->codpais->CurrentValue = FormatNumber($this->codpais->CurrentValue, $this->codpais->formatPattern());
        if (strval($this->codpais->EditValue) != "" && is_numeric($this->codpais->EditValue)) {
            $this->codpais->EditValue = FormatNumber($this->codpais->EditValue, null);
        }

        // codprov
        $this->codprov->setupEditAttributes();
        $this->codprov->CurrentValue = FormatNumber($this->codprov->CurrentValue, $this->codprov->formatPattern());
        if (strval($this->codprov->EditValue) != "" && is_numeric($this->codprov->EditValue)) {
            $this->codprov->EditValue = FormatNumber($this->codprov->EditValue, null);
        }

        // codloc
        $this->codloc->setupEditAttributes();
        $this->codloc->CurrentValue = FormatNumber($this->codloc->CurrentValue, $this->codloc->formatPattern());
        if (strval($this->codloc->EditValue) != "" && is_numeric($this->codloc->EditValue)) {
            $this->codloc->EditValue = FormatNumber($this->codloc->EditValue, null);
        }

        // telef
        $this->telef->setupEditAttributes();

        // codrem
        $this->codrem->setupEditAttributes();
        $this->codrem->PlaceHolder = RemoveHtml($this->codrem->caption());

        // estado
        $this->estado->EditValue = $this->estado->options(false);
        $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

        // emitido
        $this->emitido->EditValue = $this->emitido->options(false);
        $this->emitido->PlaceHolder = RemoveHtml($this->emitido->caption());

        // moneda
        $this->moneda->setupEditAttributes();
        $this->moneda->CurrentValue = FormatNumber($this->moneda->CurrentValue, $this->moneda->formatPattern());
        if (strval($this->moneda->EditValue) != "" && is_numeric($this->moneda->EditValue)) {
            $this->moneda->EditValue = FormatNumber($this->moneda->EditValue, null);
        }

        // totneto
        $this->totneto->setupEditAttributes();
        $this->totneto->EditValue = $this->totneto->CurrentValue;
        $this->totneto->PlaceHolder = RemoveHtml($this->totneto->caption());
        if (strval($this->totneto->EditValue) != "" && is_numeric($this->totneto->EditValue)) {
            $this->totneto->EditValue = FormatNumber($this->totneto->EditValue, null);
        }

        // totbruto
        $this->totbruto->setupEditAttributes();
        $this->totbruto->EditValue = $this->totbruto->CurrentValue;
        $this->totbruto->PlaceHolder = RemoveHtml($this->totbruto->caption());
        if (strval($this->totbruto->EditValue) != "" && is_numeric($this->totbruto->EditValue)) {
            $this->totbruto->EditValue = FormatNumber($this->totbruto->EditValue, null);
        }

        // totiva105
        $this->totiva105->setupEditAttributes();
        $this->totiva105->EditValue = $this->totiva105->CurrentValue;
        $this->totiva105->PlaceHolder = RemoveHtml($this->totiva105->caption());
        if (strval($this->totiva105->EditValue) != "" && is_numeric($this->totiva105->EditValue)) {
            $this->totiva105->EditValue = FormatNumber($this->totiva105->EditValue, null);
        }

        // totiva21
        $this->totiva21->setupEditAttributes();
        $this->totiva21->EditValue = $this->totiva21->CurrentValue;
        $this->totiva21->PlaceHolder = RemoveHtml($this->totiva21->caption());
        if (strval($this->totiva21->EditValue) != "" && is_numeric($this->totiva21->EditValue)) {
            $this->totiva21->EditValue = FormatNumber($this->totiva21->EditValue, null);
        }

        // totimp
        $this->totimp->setupEditAttributes();
        $this->totimp->EditValue = $this->totimp->CurrentValue;
        $this->totimp->PlaceHolder = RemoveHtml($this->totimp->caption());
        if (strval($this->totimp->EditValue) != "" && is_numeric($this->totimp->EditValue)) {
            $this->totimp->EditValue = FormatNumber($this->totimp->EditValue, null);
        }

        // totcomis
        $this->totcomis->setupEditAttributes();
        $this->totcomis->EditValue = $this->totcomis->CurrentValue;
        $this->totcomis->PlaceHolder = RemoveHtml($this->totcomis->caption());
        if (strval($this->totcomis->EditValue) != "" && is_numeric($this->totcomis->EditValue)) {
            $this->totcomis->EditValue = FormatNumber($this->totcomis->EditValue, null);
        }

        // totneto105
        $this->totneto105->setupEditAttributes();
        $this->totneto105->EditValue = $this->totneto105->CurrentValue;
        $this->totneto105->PlaceHolder = RemoveHtml($this->totneto105->caption());
        if (strval($this->totneto105->EditValue) != "" && is_numeric($this->totneto105->EditValue)) {
            $this->totneto105->EditValue = FormatNumber($this->totneto105->EditValue, null);
        }

        // totneto21
        $this->totneto21->setupEditAttributes();
        $this->totneto21->EditValue = $this->totneto21->CurrentValue;
        $this->totneto21->PlaceHolder = RemoveHtml($this->totneto21->caption());
        if (strval($this->totneto21->EditValue) != "" && is_numeric($this->totneto21->EditValue)) {
            $this->totneto21->EditValue = FormatNumber($this->totneto21->EditValue, null);
        }

        // tipoiva
        $this->tipoiva->setupEditAttributes();
        $this->tipoiva->CurrentValue = FormatNumber($this->tipoiva->CurrentValue, $this->tipoiva->formatPattern());
        if (strval($this->tipoiva->EditValue) != "" && is_numeric($this->tipoiva->EditValue)) {
            $this->tipoiva->EditValue = FormatNumber($this->tipoiva->EditValue, null);
        }

        // porciva
        $this->porciva->setupEditAttributes();
        $this->porciva->CurrentValue = FormatNumber($this->porciva->CurrentValue, $this->porciva->formatPattern());
        if (strval($this->porciva->EditValue) != "" && is_numeric($this->porciva->EditValue)) {
            $this->porciva->EditValue = FormatNumber($this->porciva->EditValue, null);
        }

        // nrengs
        $this->nrengs->setupEditAttributes();
        $this->nrengs->EditValue = $this->nrengs->CurrentValue;
        $this->nrengs->PlaceHolder = RemoveHtml($this->nrengs->caption());
        if (strval($this->nrengs->EditValue) != "" && is_numeric($this->nrengs->EditValue)) {
            $this->nrengs->EditValue = FormatNumber($this->nrengs->EditValue, null);
        }

        // fechahora

        // usuario

        // tieneresol
        $this->tieneresol->setupEditAttributes();
        if (strval($this->tieneresol->EditValue) != "" && is_numeric($this->tieneresol->EditValue)) {
            $this->tieneresol->EditValue = $this->tieneresol->EditValue;
        }

        // leyendafc
        $this->leyendafc->setupEditAttributes();

        // concepto
        $this->concepto->setupEditAttributes();
        if (!$this->concepto->Raw) {
            $this->concepto->CurrentValue = HtmlDecode($this->concepto->CurrentValue);
        }
        $this->concepto->EditValue = $this->concepto->CurrentValue;
        $this->concepto->PlaceHolder = RemoveHtml($this->concepto->caption());

        // nrodoc
        $this->nrodoc->setupEditAttributes();
        if (!$this->nrodoc->Raw) {
            $this->nrodoc->CurrentValue = HtmlDecode($this->nrodoc->CurrentValue);
        }
        $this->nrodoc->EditValue = $this->nrodoc->CurrentValue;
        $this->nrodoc->PlaceHolder = RemoveHtml($this->nrodoc->caption());

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

        // en_liquid
        $this->en_liquid->EditValue = $this->en_liquid->options(false);
        $this->en_liquid->PlaceHolder = RemoveHtml($this->en_liquid->caption());

        // CAE
        $this->CAE->setupEditAttributes();
        $this->CAE->EditValue = $this->CAE->CurrentValue;
        $this->CAE->PlaceHolder = RemoveHtml($this->CAE->caption());
        if (strval($this->CAE->EditValue) != "" && is_numeric($this->CAE->EditValue)) {
            $this->CAE->EditValue = FormatNumber($this->CAE->EditValue, null);
        }

        // CAEFchVto
        $this->CAEFchVto->setupEditAttributes();
        $this->CAEFchVto->EditValue = FormatDateTime($this->CAEFchVto->CurrentValue, $this->CAEFchVto->formatPattern());
        $this->CAEFchVto->PlaceHolder = RemoveHtml($this->CAEFchVto->caption());

        // Resultado
        $this->Resultado->setupEditAttributes();
        if (!$this->Resultado->Raw) {
            $this->Resultado->CurrentValue = HtmlDecode($this->Resultado->CurrentValue);
        }
        $this->Resultado->EditValue = $this->Resultado->CurrentValue;
        $this->Resultado->PlaceHolder = RemoveHtml($this->Resultado->caption());

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
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->tcomp);
                    $doc->exportCaption($this->serie);
                    $doc->exportCaption($this->ncomp);
                    $doc->exportCaption($this->fecval);
                    $doc->exportCaption($this->fecdoc);
                    $doc->exportCaption($this->fecreg);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->fecvenc);
                    $doc->exportCaption($this->direc);
                    $doc->exportCaption($this->dnro);
                    $doc->exportCaption($this->pisodto);
                    $doc->exportCaption($this->codpost);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->telef);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->emitido);
                    $doc->exportCaption($this->moneda);
                    $doc->exportCaption($this->totneto);
                    $doc->exportCaption($this->totbruto);
                    $doc->exportCaption($this->totiva105);
                    $doc->exportCaption($this->totiva21);
                    $doc->exportCaption($this->totimp);
                    $doc->exportCaption($this->totcomis);
                    $doc->exportCaption($this->totneto105);
                    $doc->exportCaption($this->totneto21);
                    $doc->exportCaption($this->tipoiva);
                    $doc->exportCaption($this->porciva);
                    $doc->exportCaption($this->nrengs);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->tieneresol);
                    $doc->exportCaption($this->leyendafc);
                    $doc->exportCaption($this->concepto);
                    $doc->exportCaption($this->nrodoc);
                    $doc->exportCaption($this->tcompsal);
                    $doc->exportCaption($this->seriesal);
                    $doc->exportCaption($this->ncompsal);
                    $doc->exportCaption($this->en_liquid);
                    $doc->exportCaption($this->CAE);
                    $doc->exportCaption($this->CAEFchVto);
                    $doc->exportCaption($this->Resultado);
                    $doc->exportCaption($this->usuarioultmod);
                    $doc->exportCaption($this->fecultmod);
                } else {
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->tcomp);
                    $doc->exportCaption($this->serie);
                    $doc->exportCaption($this->ncomp);
                    $doc->exportCaption($this->fecval);
                    $doc->exportCaption($this->fecdoc);
                    $doc->exportCaption($this->fecreg);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->cpago);
                    $doc->exportCaption($this->fecvenc);
                    $doc->exportCaption($this->direc);
                    $doc->exportCaption($this->dnro);
                    $doc->exportCaption($this->pisodto);
                    $doc->exportCaption($this->codpost);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->telef);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->emitido);
                    $doc->exportCaption($this->moneda);
                    $doc->exportCaption($this->totneto);
                    $doc->exportCaption($this->totbruto);
                    $doc->exportCaption($this->totiva105);
                    $doc->exportCaption($this->totiva21);
                    $doc->exportCaption($this->totimp);
                    $doc->exportCaption($this->totcomis);
                    $doc->exportCaption($this->totneto105);
                    $doc->exportCaption($this->totneto21);
                    $doc->exportCaption($this->tipoiva);
                    $doc->exportCaption($this->porciva);
                    $doc->exportCaption($this->nrengs);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->tieneresol);
                    $doc->exportCaption($this->concepto);
                    $doc->exportCaption($this->nrodoc);
                    $doc->exportCaption($this->tcompsal);
                    $doc->exportCaption($this->seriesal);
                    $doc->exportCaption($this->ncompsal);
                    $doc->exportCaption($this->en_liquid);
                    $doc->exportCaption($this->CAE);
                    $doc->exportCaption($this->CAEFchVto);
                    $doc->exportCaption($this->Resultado);
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
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->tcomp);
                        $doc->exportField($this->serie);
                        $doc->exportField($this->ncomp);
                        $doc->exportField($this->fecval);
                        $doc->exportField($this->fecdoc);
                        $doc->exportField($this->fecreg);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->fecvenc);
                        $doc->exportField($this->direc);
                        $doc->exportField($this->dnro);
                        $doc->exportField($this->pisodto);
                        $doc->exportField($this->codpost);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->telef);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->emitido);
                        $doc->exportField($this->moneda);
                        $doc->exportField($this->totneto);
                        $doc->exportField($this->totbruto);
                        $doc->exportField($this->totiva105);
                        $doc->exportField($this->totiva21);
                        $doc->exportField($this->totimp);
                        $doc->exportField($this->totcomis);
                        $doc->exportField($this->totneto105);
                        $doc->exportField($this->totneto21);
                        $doc->exportField($this->tipoiva);
                        $doc->exportField($this->porciva);
                        $doc->exportField($this->nrengs);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->tieneresol);
                        $doc->exportField($this->leyendafc);
                        $doc->exportField($this->concepto);
                        $doc->exportField($this->nrodoc);
                        $doc->exportField($this->tcompsal);
                        $doc->exportField($this->seriesal);
                        $doc->exportField($this->ncompsal);
                        $doc->exportField($this->en_liquid);
                        $doc->exportField($this->CAE);
                        $doc->exportField($this->CAEFchVto);
                        $doc->exportField($this->Resultado);
                        $doc->exportField($this->usuarioultmod);
                        $doc->exportField($this->fecultmod);
                    } else {
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->tcomp);
                        $doc->exportField($this->serie);
                        $doc->exportField($this->ncomp);
                        $doc->exportField($this->fecval);
                        $doc->exportField($this->fecdoc);
                        $doc->exportField($this->fecreg);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->cpago);
                        $doc->exportField($this->fecvenc);
                        $doc->exportField($this->direc);
                        $doc->exportField($this->dnro);
                        $doc->exportField($this->pisodto);
                        $doc->exportField($this->codpost);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->telef);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->emitido);
                        $doc->exportField($this->moneda);
                        $doc->exportField($this->totneto);
                        $doc->exportField($this->totbruto);
                        $doc->exportField($this->totiva105);
                        $doc->exportField($this->totiva21);
                        $doc->exportField($this->totimp);
                        $doc->exportField($this->totcomis);
                        $doc->exportField($this->totneto105);
                        $doc->exportField($this->totneto21);
                        $doc->exportField($this->tipoiva);
                        $doc->exportField($this->porciva);
                        $doc->exportField($this->nrengs);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->tieneresol);
                        $doc->exportField($this->concepto);
                        $doc->exportField($this->nrodoc);
                        $doc->exportField($this->tcompsal);
                        $doc->exportField($this->seriesal);
                        $doc->exportField($this->ncompsal);
                        $doc->exportField($this->en_liquid);
                        $doc->exportField($this->CAE);
                        $doc->exportField($this->CAEFchVto);
                        $doc->exportField($this->Resultado);
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
