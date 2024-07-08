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
 * Table class for liquidacion
 */
class Liquidacion extends DbTable
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
    public $cliente;
    public $rubro;
    public $calle;
    public $dnro;
    public $pisodto;
    public $codpost;
    public $codpais;
    public $codprov;
    public $codloc;
    public $codrem;
    public $fecharem;
    public $cuit;
    public $tipoiva;
    public $totremate;
    public $totneto1;
    public $totiva21;
    public $subtot1;
    public $totneto2;
    public $totiva105;
    public $subtot2;
    public $totacuenta;
    public $totgastos;
    public $totvarios;
    public $saldoafav;
    public $fechahora;
    public $usuario;
    public $fechaliq;
    public $estado;
    public $nrodoc;
    public $cotiz;
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
        $this->TableVar = "liquidacion";
        $this->TableName = 'liquidacion';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "liquidacion";
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
            'TEXT' // Edit Tag
        );
        $this->cliente->InputTextType = "text";
        $this->cliente->Raw = true;
        $this->cliente->Nullable = false; // NOT NULL field
        $this->cliente->Required = true; // Required field
        $this->cliente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['cliente'] = &$this->cliente;

        // rubro
        $this->rubro = new DbField(
            $this, // Table
            'x_rubro', // Variable name
            'rubro', // Name
            '`rubro`', // Expression
            '`rubro`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`rubro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->rubro->InputTextType = "text";
        $this->rubro->Nullable = false; // NOT NULL field
        $this->rubro->Required = true; // Required field
        $this->rubro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['rubro'] = &$this->rubro;

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
        $this->calle->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['calle'] = &$this->calle;

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
            'TEXT' // Edit Tag
        );
        $this->dnro->InputTextType = "text";
        $this->dnro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->pisodto->InputTextType = "text";
        $this->pisodto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->codpost->InputTextType = "text";
        $this->codpost->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->codpais->InputTextType = "text";
        $this->codpais->Raw = true;
        $this->codpais->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codpais->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->codprov->InputTextType = "text";
        $this->codprov->Raw = true;
        $this->codprov->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codprov->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->codloc->InputTextType = "text";
        $this->codloc->Raw = true;
        $this->codloc->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codloc->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['codloc'] = &$this->codloc;

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
        $this->codrem->Nullable = false; // NOT NULL field
        $this->codrem->Required = true; // Required field
        $this->codrem->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codrem->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codrem'] = &$this->codrem;

        // fecharem
        $this->fecharem = new DbField(
            $this, // Table
            'x_fecharem', // Variable name
            'fecharem', // Name
            '`fecharem`', // Expression
            CastDateFieldForLike("`fecharem`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecharem`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecharem->InputTextType = "text";
        $this->fecharem->Raw = true;
        $this->fecharem->Nullable = false; // NOT NULL field
        $this->fecharem->Required = true; // Required field
        $this->fecharem->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecharem->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fecharem'] = &$this->fecharem;

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
        $this->cuit->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cuit'] = &$this->cuit;

        // tipoiva
        $this->tipoiva = new DbField(
            $this, // Table
            'x_tipoiva', // Variable name
            'tipoiva', // Name
            '`tipoiva`', // Expression
            '`tipoiva`', // Basic search expression
            3, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipoiva`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tipoiva->InputTextType = "text";
        $this->tipoiva->Raw = true;
        $this->tipoiva->Required = true; // Required field
        $this->tipoiva->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipoiva->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipoiva'] = &$this->tipoiva;

        // totremate
        $this->totremate = new DbField(
            $this, // Table
            'x_totremate', // Variable name
            'totremate', // Name
            '`totremate`', // Expression
            '`totremate`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totremate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totremate->addMethod("getDefault", fn() => 0.00);
        $this->totremate->InputTextType = "text";
        $this->totremate->Raw = true;
        $this->totremate->Nullable = false; // NOT NULL field
        $this->totremate->Required = true; // Required field
        $this->totremate->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totremate->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['totremate'] = &$this->totremate;

        // totneto1
        $this->totneto1 = new DbField(
            $this, // Table
            'x_totneto1', // Variable name
            'totneto1', // Name
            '`totneto1`', // Expression
            '`totneto1`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totneto1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totneto1->addMethod("getDefault", fn() => 0.00);
        $this->totneto1->InputTextType = "text";
        $this->totneto1->Raw = true;
        $this->totneto1->Nullable = false; // NOT NULL field
        $this->totneto1->Required = true; // Required field
        $this->totneto1->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totneto1->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['totneto1'] = &$this->totneto1;

        // totiva21
        $this->totiva21 = new DbField(
            $this, // Table
            'x_totiva21', // Variable name
            'totiva21', // Name
            '`totiva21`', // Expression
            '`totiva21`', // Basic search expression
            131, // Type
            16, // Size
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
        $this->totiva21->Nullable = false; // NOT NULL field
        $this->totiva21->Required = true; // Required field
        $this->totiva21->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totiva21->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['totiva21'] = &$this->totiva21;

        // subtot1
        $this->subtot1 = new DbField(
            $this, // Table
            'x_subtot1', // Variable name
            'subtot1', // Name
            '`subtot1`', // Expression
            '`subtot1`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`subtot1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->subtot1->addMethod("getDefault", fn() => 0.00);
        $this->subtot1->InputTextType = "text";
        $this->subtot1->Raw = true;
        $this->subtot1->Nullable = false; // NOT NULL field
        $this->subtot1->Required = true; // Required field
        $this->subtot1->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->subtot1->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['subtot1'] = &$this->subtot1;

        // totneto2
        $this->totneto2 = new DbField(
            $this, // Table
            'x_totneto2', // Variable name
            'totneto2', // Name
            '`totneto2`', // Expression
            '`totneto2`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totneto2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totneto2->addMethod("getDefault", fn() => 0.00);
        $this->totneto2->InputTextType = "text";
        $this->totneto2->Raw = true;
        $this->totneto2->Nullable = false; // NOT NULL field
        $this->totneto2->Required = true; // Required field
        $this->totneto2->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totneto2->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['totneto2'] = &$this->totneto2;

        // totiva105
        $this->totiva105 = new DbField(
            $this, // Table
            'x_totiva105', // Variable name
            'totiva105', // Name
            '`totiva105`', // Expression
            '`totiva105`', // Basic search expression
            131, // Type
            16, // Size
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
        $this->totiva105->Nullable = false; // NOT NULL field
        $this->totiva105->Required = true; // Required field
        $this->totiva105->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totiva105->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['totiva105'] = &$this->totiva105;

        // subtot2
        $this->subtot2 = new DbField(
            $this, // Table
            'x_subtot2', // Variable name
            'subtot2', // Name
            '`subtot2`', // Expression
            '`subtot2`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`subtot2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->subtot2->addMethod("getDefault", fn() => 0.00);
        $this->subtot2->InputTextType = "text";
        $this->subtot2->Raw = true;
        $this->subtot2->Nullable = false; // NOT NULL field
        $this->subtot2->Required = true; // Required field
        $this->subtot2->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->subtot2->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['subtot2'] = &$this->subtot2;

        // totacuenta
        $this->totacuenta = new DbField(
            $this, // Table
            'x_totacuenta', // Variable name
            'totacuenta', // Name
            '`totacuenta`', // Expression
            '`totacuenta`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totacuenta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totacuenta->addMethod("getDefault", fn() => 0.00);
        $this->totacuenta->InputTextType = "text";
        $this->totacuenta->Raw = true;
        $this->totacuenta->Nullable = false; // NOT NULL field
        $this->totacuenta->Required = true; // Required field
        $this->totacuenta->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totacuenta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['totacuenta'] = &$this->totacuenta;

        // totgastos
        $this->totgastos = new DbField(
            $this, // Table
            'x_totgastos', // Variable name
            'totgastos', // Name
            '`totgastos`', // Expression
            '`totgastos`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totgastos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totgastos->addMethod("getDefault", fn() => 0.00);
        $this->totgastos->InputTextType = "text";
        $this->totgastos->Raw = true;
        $this->totgastos->Nullable = false; // NOT NULL field
        $this->totgastos->Required = true; // Required field
        $this->totgastos->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totgastos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['totgastos'] = &$this->totgastos;

        // totvarios
        $this->totvarios = new DbField(
            $this, // Table
            'x_totvarios', // Variable name
            'totvarios', // Name
            '`totvarios`', // Expression
            '`totvarios`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`totvarios`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->totvarios->addMethod("getDefault", fn() => 0.00);
        $this->totvarios->InputTextType = "text";
        $this->totvarios->Raw = true;
        $this->totvarios->Nullable = false; // NOT NULL field
        $this->totvarios->Required = true; // Required field
        $this->totvarios->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totvarios->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['totvarios'] = &$this->totvarios;

        // saldoafav
        $this->saldoafav = new DbField(
            $this, // Table
            'x_saldoafav', // Variable name
            'saldoafav', // Name
            '`saldoafav`', // Expression
            '`saldoafav`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`saldoafav`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->saldoafav->addMethod("getDefault", fn() => 0.00);
        $this->saldoafav->InputTextType = "text";
        $this->saldoafav->Raw = true;
        $this->saldoafav->Nullable = false; // NOT NULL field
        $this->saldoafav->Required = true; // Required field
        $this->saldoafav->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->saldoafav->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['saldoafav'] = &$this->saldoafav;

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
        $this->usuario->InputTextType = "text";
        $this->usuario->Raw = true;
        $this->usuario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuario'] = &$this->usuario;

        // fechaliq
        $this->fechaliq = new DbField(
            $this, // Table
            'x_fechaliq', // Variable name
            'fechaliq', // Name
            '`fechaliq`', // Expression
            CastDateFieldForLike("`fechaliq`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fechaliq`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechaliq->InputTextType = "text";
        $this->fechaliq->Raw = true;
        $this->fechaliq->Nullable = false; // NOT NULL field
        $this->fechaliq->Required = true; // Required field
        $this->fechaliq->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fechaliq->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['fechaliq'] = &$this->fechaliq;

        // estado
        $this->estado = new DbField(
            $this, // Table
            'x_estado', // Variable name
            'estado', // Name
            '`estado`', // Expression
            '`estado`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->estado->InputTextType = "text";
        $this->estado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['estado'] = &$this->estado;

        // nrodoc
        $this->nrodoc = new DbField(
            $this, // Table
            'x_nrodoc', // Variable name
            'nrodoc', // Name
            '`nrodoc`', // Expression
            '`nrodoc`', // Basic search expression
            200, // Type
            14, // Size
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

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "liquidacion";
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
        $this->tcomp->DbValue = $row['tcomp'];
        $this->serie->DbValue = $row['serie'];
        $this->ncomp->DbValue = $row['ncomp'];
        $this->cliente->DbValue = $row['cliente'];
        $this->rubro->DbValue = $row['rubro'];
        $this->calle->DbValue = $row['calle'];
        $this->dnro->DbValue = $row['dnro'];
        $this->pisodto->DbValue = $row['pisodto'];
        $this->codpost->DbValue = $row['codpost'];
        $this->codpais->DbValue = $row['codpais'];
        $this->codprov->DbValue = $row['codprov'];
        $this->codloc->DbValue = $row['codloc'];
        $this->codrem->DbValue = $row['codrem'];
        $this->fecharem->DbValue = $row['fecharem'];
        $this->cuit->DbValue = $row['cuit'];
        $this->tipoiva->DbValue = $row['tipoiva'];
        $this->totremate->DbValue = $row['totremate'];
        $this->totneto1->DbValue = $row['totneto1'];
        $this->totiva21->DbValue = $row['totiva21'];
        $this->subtot1->DbValue = $row['subtot1'];
        $this->totneto2->DbValue = $row['totneto2'];
        $this->totiva105->DbValue = $row['totiva105'];
        $this->subtot2->DbValue = $row['subtot2'];
        $this->totacuenta->DbValue = $row['totacuenta'];
        $this->totgastos->DbValue = $row['totgastos'];
        $this->totvarios->DbValue = $row['totvarios'];
        $this->saldoafav->DbValue = $row['saldoafav'];
        $this->fechahora->DbValue = $row['fechahora'];
        $this->usuario->DbValue = $row['usuario'];
        $this->fechaliq->DbValue = $row['fechaliq'];
        $this->estado->DbValue = $row['estado'];
        $this->nrodoc->DbValue = $row['nrodoc'];
        $this->cotiz->DbValue = $row['cotiz'];
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
        return $_SESSION[$name] ?? GetUrl("LiquidacionList");
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
            "LiquidacionView" => $Language->phrase("View"),
            "LiquidacionEdit" => $Language->phrase("Edit"),
            "LiquidacionAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "LiquidacionList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "LiquidacionView",
            Config("API_ADD_ACTION") => "LiquidacionAdd",
            Config("API_EDIT_ACTION") => "LiquidacionEdit",
            Config("API_DELETE_ACTION") => "LiquidacionDelete",
            Config("API_LIST_ACTION") => "LiquidacionList",
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
        return "LiquidacionList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("LiquidacionView", $parm);
        } else {
            $url = $this->keyUrl("LiquidacionView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "LiquidacionAdd?" . $parm;
        } else {
            $url = "LiquidacionAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("LiquidacionEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("LiquidacionList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("LiquidacionAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("LiquidacionList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("LiquidacionDelete", $parm);
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
        $this->cliente->setDbValue($row['cliente']);
        $this->rubro->setDbValue($row['rubro']);
        $this->calle->setDbValue($row['calle']);
        $this->dnro->setDbValue($row['dnro']);
        $this->pisodto->setDbValue($row['pisodto']);
        $this->codpost->setDbValue($row['codpost']);
        $this->codpais->setDbValue($row['codpais']);
        $this->codprov->setDbValue($row['codprov']);
        $this->codloc->setDbValue($row['codloc']);
        $this->codrem->setDbValue($row['codrem']);
        $this->fecharem->setDbValue($row['fecharem']);
        $this->cuit->setDbValue($row['cuit']);
        $this->tipoiva->setDbValue($row['tipoiva']);
        $this->totremate->setDbValue($row['totremate']);
        $this->totneto1->setDbValue($row['totneto1']);
        $this->totiva21->setDbValue($row['totiva21']);
        $this->subtot1->setDbValue($row['subtot1']);
        $this->totneto2->setDbValue($row['totneto2']);
        $this->totiva105->setDbValue($row['totiva105']);
        $this->subtot2->setDbValue($row['subtot2']);
        $this->totacuenta->setDbValue($row['totacuenta']);
        $this->totgastos->setDbValue($row['totgastos']);
        $this->totvarios->setDbValue($row['totvarios']);
        $this->saldoafav->setDbValue($row['saldoafav']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->usuario->setDbValue($row['usuario']);
        $this->fechaliq->setDbValue($row['fechaliq']);
        $this->estado->setDbValue($row['estado']);
        $this->nrodoc->setDbValue($row['nrodoc']);
        $this->cotiz->setDbValue($row['cotiz']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "LiquidacionList";
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

        // cliente

        // rubro

        // calle

        // dnro

        // pisodto

        // codpost

        // codpais

        // codprov

        // codloc

        // codrem

        // fecharem

        // cuit

        // tipoiva

        // totremate

        // totneto1

        // totiva21

        // subtot1

        // totneto2

        // totiva105

        // subtot2

        // totacuenta

        // totgastos

        // totvarios

        // saldoafav

        // fechahora

        // usuario

        // fechaliq

        // estado

        // nrodoc

        // cotiz

        // usuarioultmod

        // fecultmod

        // codnum
        $this->codnum->ViewValue = $this->codnum->CurrentValue;

        // tcomp
        $this->tcomp->ViewValue = $this->tcomp->CurrentValue;
        $this->tcomp->ViewValue = FormatNumber($this->tcomp->ViewValue, $this->tcomp->formatPattern());

        // serie
        $this->serie->ViewValue = $this->serie->CurrentValue;
        $this->serie->ViewValue = FormatNumber($this->serie->ViewValue, $this->serie->formatPattern());

        // ncomp
        $this->ncomp->ViewValue = $this->ncomp->CurrentValue;
        $this->ncomp->ViewValue = FormatNumber($this->ncomp->ViewValue, $this->ncomp->formatPattern());

        // cliente
        $this->cliente->ViewValue = $this->cliente->CurrentValue;
        $this->cliente->ViewValue = FormatNumber($this->cliente->ViewValue, $this->cliente->formatPattern());

        // rubro
        $this->rubro->ViewValue = $this->rubro->CurrentValue;

        // calle
        $this->calle->ViewValue = $this->calle->CurrentValue;

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

        // codrem
        $this->codrem->ViewValue = $this->codrem->CurrentValue;
        $this->codrem->ViewValue = FormatNumber($this->codrem->ViewValue, $this->codrem->formatPattern());

        // fecharem
        $this->fecharem->ViewValue = $this->fecharem->CurrentValue;
        $this->fecharem->ViewValue = FormatDateTime($this->fecharem->ViewValue, $this->fecharem->formatPattern());

        // cuit
        $this->cuit->ViewValue = $this->cuit->CurrentValue;

        // tipoiva
        $this->tipoiva->ViewValue = $this->tipoiva->CurrentValue;
        $this->tipoiva->ViewValue = FormatNumber($this->tipoiva->ViewValue, $this->tipoiva->formatPattern());

        // totremate
        $this->totremate->ViewValue = $this->totremate->CurrentValue;
        $this->totremate->ViewValue = FormatNumber($this->totremate->ViewValue, $this->totremate->formatPattern());

        // totneto1
        $this->totneto1->ViewValue = $this->totneto1->CurrentValue;
        $this->totneto1->ViewValue = FormatNumber($this->totneto1->ViewValue, $this->totneto1->formatPattern());

        // totiva21
        $this->totiva21->ViewValue = $this->totiva21->CurrentValue;
        $this->totiva21->ViewValue = FormatNumber($this->totiva21->ViewValue, $this->totiva21->formatPattern());

        // subtot1
        $this->subtot1->ViewValue = $this->subtot1->CurrentValue;
        $this->subtot1->ViewValue = FormatNumber($this->subtot1->ViewValue, $this->subtot1->formatPattern());

        // totneto2
        $this->totneto2->ViewValue = $this->totneto2->CurrentValue;
        $this->totneto2->ViewValue = FormatNumber($this->totneto2->ViewValue, $this->totneto2->formatPattern());

        // totiva105
        $this->totiva105->ViewValue = $this->totiva105->CurrentValue;
        $this->totiva105->ViewValue = FormatNumber($this->totiva105->ViewValue, $this->totiva105->formatPattern());

        // subtot2
        $this->subtot2->ViewValue = $this->subtot2->CurrentValue;
        $this->subtot2->ViewValue = FormatNumber($this->subtot2->ViewValue, $this->subtot2->formatPattern());

        // totacuenta
        $this->totacuenta->ViewValue = $this->totacuenta->CurrentValue;
        $this->totacuenta->ViewValue = FormatNumber($this->totacuenta->ViewValue, $this->totacuenta->formatPattern());

        // totgastos
        $this->totgastos->ViewValue = $this->totgastos->CurrentValue;
        $this->totgastos->ViewValue = FormatNumber($this->totgastos->ViewValue, $this->totgastos->formatPattern());

        // totvarios
        $this->totvarios->ViewValue = $this->totvarios->CurrentValue;
        $this->totvarios->ViewValue = FormatNumber($this->totvarios->ViewValue, $this->totvarios->formatPattern());

        // saldoafav
        $this->saldoafav->ViewValue = $this->saldoafav->CurrentValue;
        $this->saldoafav->ViewValue = FormatNumber($this->saldoafav->ViewValue, $this->saldoafav->formatPattern());

        // fechahora
        $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
        $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

        // usuario
        $this->usuario->ViewValue = $this->usuario->CurrentValue;
        $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

        // fechaliq
        $this->fechaliq->ViewValue = $this->fechaliq->CurrentValue;
        $this->fechaliq->ViewValue = FormatDateTime($this->fechaliq->ViewValue, $this->fechaliq->formatPattern());

        // estado
        $this->estado->ViewValue = $this->estado->CurrentValue;

        // nrodoc
        $this->nrodoc->ViewValue = $this->nrodoc->CurrentValue;

        // cotiz
        $this->cotiz->ViewValue = $this->cotiz->CurrentValue;
        $this->cotiz->ViewValue = FormatNumber($this->cotiz->ViewValue, $this->cotiz->formatPattern());

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

        // cliente
        $this->cliente->HrefValue = "";
        $this->cliente->TooltipValue = "";

        // rubro
        $this->rubro->HrefValue = "";
        $this->rubro->TooltipValue = "";

        // calle
        $this->calle->HrefValue = "";
        $this->calle->TooltipValue = "";

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

        // codrem
        $this->codrem->HrefValue = "";
        $this->codrem->TooltipValue = "";

        // fecharem
        $this->fecharem->HrefValue = "";
        $this->fecharem->TooltipValue = "";

        // cuit
        $this->cuit->HrefValue = "";
        $this->cuit->TooltipValue = "";

        // tipoiva
        $this->tipoiva->HrefValue = "";
        $this->tipoiva->TooltipValue = "";

        // totremate
        $this->totremate->HrefValue = "";
        $this->totremate->TooltipValue = "";

        // totneto1
        $this->totneto1->HrefValue = "";
        $this->totneto1->TooltipValue = "";

        // totiva21
        $this->totiva21->HrefValue = "";
        $this->totiva21->TooltipValue = "";

        // subtot1
        $this->subtot1->HrefValue = "";
        $this->subtot1->TooltipValue = "";

        // totneto2
        $this->totneto2->HrefValue = "";
        $this->totneto2->TooltipValue = "";

        // totiva105
        $this->totiva105->HrefValue = "";
        $this->totiva105->TooltipValue = "";

        // subtot2
        $this->subtot2->HrefValue = "";
        $this->subtot2->TooltipValue = "";

        // totacuenta
        $this->totacuenta->HrefValue = "";
        $this->totacuenta->TooltipValue = "";

        // totgastos
        $this->totgastos->HrefValue = "";
        $this->totgastos->TooltipValue = "";

        // totvarios
        $this->totvarios->HrefValue = "";
        $this->totvarios->TooltipValue = "";

        // saldoafav
        $this->saldoafav->HrefValue = "";
        $this->saldoafav->TooltipValue = "";

        // fechahora
        $this->fechahora->HrefValue = "";
        $this->fechahora->TooltipValue = "";

        // usuario
        $this->usuario->HrefValue = "";
        $this->usuario->TooltipValue = "";

        // fechaliq
        $this->fechaliq->HrefValue = "";
        $this->fechaliq->TooltipValue = "";

        // estado
        $this->estado->HrefValue = "";
        $this->estado->TooltipValue = "";

        // nrodoc
        $this->nrodoc->HrefValue = "";
        $this->nrodoc->TooltipValue = "";

        // cotiz
        $this->cotiz->HrefValue = "";
        $this->cotiz->TooltipValue = "";

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
        $this->tcomp->EditValue = $this->tcomp->CurrentValue;
        $this->tcomp->PlaceHolder = RemoveHtml($this->tcomp->caption());
        if (strval($this->tcomp->EditValue) != "" && is_numeric($this->tcomp->EditValue)) {
            $this->tcomp->EditValue = FormatNumber($this->tcomp->EditValue, null);
        }

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

        // cliente
        $this->cliente->setupEditAttributes();
        $this->cliente->EditValue = $this->cliente->CurrentValue;
        $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());
        if (strval($this->cliente->EditValue) != "" && is_numeric($this->cliente->EditValue)) {
            $this->cliente->EditValue = FormatNumber($this->cliente->EditValue, null);
        }

        // rubro
        $this->rubro->setupEditAttributes();
        if (!$this->rubro->Raw) {
            $this->rubro->CurrentValue = HtmlDecode($this->rubro->CurrentValue);
        }
        $this->rubro->EditValue = $this->rubro->CurrentValue;
        $this->rubro->PlaceHolder = RemoveHtml($this->rubro->caption());

        // calle
        $this->calle->setupEditAttributes();
        if (!$this->calle->Raw) {
            $this->calle->CurrentValue = HtmlDecode($this->calle->CurrentValue);
        }
        $this->calle->EditValue = $this->calle->CurrentValue;
        $this->calle->PlaceHolder = RemoveHtml($this->calle->caption());

        // dnro
        $this->dnro->setupEditAttributes();
        if (!$this->dnro->Raw) {
            $this->dnro->CurrentValue = HtmlDecode($this->dnro->CurrentValue);
        }
        $this->dnro->EditValue = $this->dnro->CurrentValue;
        $this->dnro->PlaceHolder = RemoveHtml($this->dnro->caption());

        // pisodto
        $this->pisodto->setupEditAttributes();
        if (!$this->pisodto->Raw) {
            $this->pisodto->CurrentValue = HtmlDecode($this->pisodto->CurrentValue);
        }
        $this->pisodto->EditValue = $this->pisodto->CurrentValue;
        $this->pisodto->PlaceHolder = RemoveHtml($this->pisodto->caption());

        // codpost
        $this->codpost->setupEditAttributes();
        if (!$this->codpost->Raw) {
            $this->codpost->CurrentValue = HtmlDecode($this->codpost->CurrentValue);
        }
        $this->codpost->EditValue = $this->codpost->CurrentValue;
        $this->codpost->PlaceHolder = RemoveHtml($this->codpost->caption());

        // codpais
        $this->codpais->setupEditAttributes();
        $this->codpais->EditValue = $this->codpais->CurrentValue;
        $this->codpais->PlaceHolder = RemoveHtml($this->codpais->caption());
        if (strval($this->codpais->EditValue) != "" && is_numeric($this->codpais->EditValue)) {
            $this->codpais->EditValue = FormatNumber($this->codpais->EditValue, null);
        }

        // codprov
        $this->codprov->setupEditAttributes();
        $this->codprov->EditValue = $this->codprov->CurrentValue;
        $this->codprov->PlaceHolder = RemoveHtml($this->codprov->caption());
        if (strval($this->codprov->EditValue) != "" && is_numeric($this->codprov->EditValue)) {
            $this->codprov->EditValue = FormatNumber($this->codprov->EditValue, null);
        }

        // codloc
        $this->codloc->setupEditAttributes();
        $this->codloc->EditValue = $this->codloc->CurrentValue;
        $this->codloc->PlaceHolder = RemoveHtml($this->codloc->caption());
        if (strval($this->codloc->EditValue) != "" && is_numeric($this->codloc->EditValue)) {
            $this->codloc->EditValue = FormatNumber($this->codloc->EditValue, null);
        }

        // codrem
        $this->codrem->setupEditAttributes();
        $this->codrem->EditValue = $this->codrem->CurrentValue;
        $this->codrem->PlaceHolder = RemoveHtml($this->codrem->caption());
        if (strval($this->codrem->EditValue) != "" && is_numeric($this->codrem->EditValue)) {
            $this->codrem->EditValue = FormatNumber($this->codrem->EditValue, null);
        }

        // fecharem
        $this->fecharem->setupEditAttributes();
        $this->fecharem->EditValue = FormatDateTime($this->fecharem->CurrentValue, $this->fecharem->formatPattern());
        $this->fecharem->PlaceHolder = RemoveHtml($this->fecharem->caption());

        // cuit
        $this->cuit->setupEditAttributes();
        if (!$this->cuit->Raw) {
            $this->cuit->CurrentValue = HtmlDecode($this->cuit->CurrentValue);
        }
        $this->cuit->EditValue = $this->cuit->CurrentValue;
        $this->cuit->PlaceHolder = RemoveHtml($this->cuit->caption());

        // tipoiva
        $this->tipoiva->setupEditAttributes();
        $this->tipoiva->EditValue = $this->tipoiva->CurrentValue;
        $this->tipoiva->PlaceHolder = RemoveHtml($this->tipoiva->caption());
        if (strval($this->tipoiva->EditValue) != "" && is_numeric($this->tipoiva->EditValue)) {
            $this->tipoiva->EditValue = FormatNumber($this->tipoiva->EditValue, null);
        }

        // totremate
        $this->totremate->setupEditAttributes();
        $this->totremate->EditValue = $this->totremate->CurrentValue;
        $this->totremate->PlaceHolder = RemoveHtml($this->totremate->caption());
        if (strval($this->totremate->EditValue) != "" && is_numeric($this->totremate->EditValue)) {
            $this->totremate->EditValue = FormatNumber($this->totremate->EditValue, null);
        }

        // totneto1
        $this->totneto1->setupEditAttributes();
        $this->totneto1->EditValue = $this->totneto1->CurrentValue;
        $this->totneto1->PlaceHolder = RemoveHtml($this->totneto1->caption());
        if (strval($this->totneto1->EditValue) != "" && is_numeric($this->totneto1->EditValue)) {
            $this->totneto1->EditValue = FormatNumber($this->totneto1->EditValue, null);
        }

        // totiva21
        $this->totiva21->setupEditAttributes();
        $this->totiva21->EditValue = $this->totiva21->CurrentValue;
        $this->totiva21->PlaceHolder = RemoveHtml($this->totiva21->caption());
        if (strval($this->totiva21->EditValue) != "" && is_numeric($this->totiva21->EditValue)) {
            $this->totiva21->EditValue = FormatNumber($this->totiva21->EditValue, null);
        }

        // subtot1
        $this->subtot1->setupEditAttributes();
        $this->subtot1->EditValue = $this->subtot1->CurrentValue;
        $this->subtot1->PlaceHolder = RemoveHtml($this->subtot1->caption());
        if (strval($this->subtot1->EditValue) != "" && is_numeric($this->subtot1->EditValue)) {
            $this->subtot1->EditValue = FormatNumber($this->subtot1->EditValue, null);
        }

        // totneto2
        $this->totneto2->setupEditAttributes();
        $this->totneto2->EditValue = $this->totneto2->CurrentValue;
        $this->totneto2->PlaceHolder = RemoveHtml($this->totneto2->caption());
        if (strval($this->totneto2->EditValue) != "" && is_numeric($this->totneto2->EditValue)) {
            $this->totneto2->EditValue = FormatNumber($this->totneto2->EditValue, null);
        }

        // totiva105
        $this->totiva105->setupEditAttributes();
        $this->totiva105->EditValue = $this->totiva105->CurrentValue;
        $this->totiva105->PlaceHolder = RemoveHtml($this->totiva105->caption());
        if (strval($this->totiva105->EditValue) != "" && is_numeric($this->totiva105->EditValue)) {
            $this->totiva105->EditValue = FormatNumber($this->totiva105->EditValue, null);
        }

        // subtot2
        $this->subtot2->setupEditAttributes();
        $this->subtot2->EditValue = $this->subtot2->CurrentValue;
        $this->subtot2->PlaceHolder = RemoveHtml($this->subtot2->caption());
        if (strval($this->subtot2->EditValue) != "" && is_numeric($this->subtot2->EditValue)) {
            $this->subtot2->EditValue = FormatNumber($this->subtot2->EditValue, null);
        }

        // totacuenta
        $this->totacuenta->setupEditAttributes();
        $this->totacuenta->EditValue = $this->totacuenta->CurrentValue;
        $this->totacuenta->PlaceHolder = RemoveHtml($this->totacuenta->caption());
        if (strval($this->totacuenta->EditValue) != "" && is_numeric($this->totacuenta->EditValue)) {
            $this->totacuenta->EditValue = FormatNumber($this->totacuenta->EditValue, null);
        }

        // totgastos
        $this->totgastos->setupEditAttributes();
        $this->totgastos->EditValue = $this->totgastos->CurrentValue;
        $this->totgastos->PlaceHolder = RemoveHtml($this->totgastos->caption());
        if (strval($this->totgastos->EditValue) != "" && is_numeric($this->totgastos->EditValue)) {
            $this->totgastos->EditValue = FormatNumber($this->totgastos->EditValue, null);
        }

        // totvarios
        $this->totvarios->setupEditAttributes();
        $this->totvarios->EditValue = $this->totvarios->CurrentValue;
        $this->totvarios->PlaceHolder = RemoveHtml($this->totvarios->caption());
        if (strval($this->totvarios->EditValue) != "" && is_numeric($this->totvarios->EditValue)) {
            $this->totvarios->EditValue = FormatNumber($this->totvarios->EditValue, null);
        }

        // saldoafav
        $this->saldoafav->setupEditAttributes();
        $this->saldoafav->EditValue = $this->saldoafav->CurrentValue;
        $this->saldoafav->PlaceHolder = RemoveHtml($this->saldoafav->caption());
        if (strval($this->saldoafav->EditValue) != "" && is_numeric($this->saldoafav->EditValue)) {
            $this->saldoafav->EditValue = FormatNumber($this->saldoafav->EditValue, null);
        }

        // fechahora
        $this->fechahora->setupEditAttributes();
        $this->fechahora->EditValue = FormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        $this->fechahora->PlaceHolder = RemoveHtml($this->fechahora->caption());

        // usuario
        $this->usuario->setupEditAttributes();
        $this->usuario->EditValue = $this->usuario->CurrentValue;
        $this->usuario->PlaceHolder = RemoveHtml($this->usuario->caption());
        if (strval($this->usuario->EditValue) != "" && is_numeric($this->usuario->EditValue)) {
            $this->usuario->EditValue = FormatNumber($this->usuario->EditValue, null);
        }

        // fechaliq
        $this->fechaliq->setupEditAttributes();
        $this->fechaliq->EditValue = FormatDateTime($this->fechaliq->CurrentValue, $this->fechaliq->formatPattern());
        $this->fechaliq->PlaceHolder = RemoveHtml($this->fechaliq->caption());

        // estado
        $this->estado->setupEditAttributes();
        if (!$this->estado->Raw) {
            $this->estado->CurrentValue = HtmlDecode($this->estado->CurrentValue);
        }
        $this->estado->EditValue = $this->estado->CurrentValue;
        $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

        // nrodoc
        $this->nrodoc->setupEditAttributes();
        if (!$this->nrodoc->Raw) {
            $this->nrodoc->CurrentValue = HtmlDecode($this->nrodoc->CurrentValue);
        }
        $this->nrodoc->EditValue = $this->nrodoc->CurrentValue;
        $this->nrodoc->PlaceHolder = RemoveHtml($this->nrodoc->caption());

        // cotiz
        $this->cotiz->setupEditAttributes();
        $this->cotiz->EditValue = $this->cotiz->CurrentValue;
        $this->cotiz->PlaceHolder = RemoveHtml($this->cotiz->caption());
        if (strval($this->cotiz->EditValue) != "" && is_numeric($this->cotiz->EditValue)) {
            $this->cotiz->EditValue = FormatNumber($this->cotiz->EditValue, null);
        }

        // usuarioultmod

        // fecultmod
        $this->fecultmod->setupEditAttributes();
        $this->fecultmod->EditValue = FormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern());
        $this->fecultmod->PlaceHolder = RemoveHtml($this->fecultmod->caption());

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
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->rubro);
                    $doc->exportCaption($this->calle);
                    $doc->exportCaption($this->dnro);
                    $doc->exportCaption($this->pisodto);
                    $doc->exportCaption($this->codpost);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->fecharem);
                    $doc->exportCaption($this->cuit);
                    $doc->exportCaption($this->tipoiva);
                    $doc->exportCaption($this->totremate);
                    $doc->exportCaption($this->totneto1);
                    $doc->exportCaption($this->totiva21);
                    $doc->exportCaption($this->subtot1);
                    $doc->exportCaption($this->totneto2);
                    $doc->exportCaption($this->totiva105);
                    $doc->exportCaption($this->subtot2);
                    $doc->exportCaption($this->totacuenta);
                    $doc->exportCaption($this->totgastos);
                    $doc->exportCaption($this->totvarios);
                    $doc->exportCaption($this->saldoafav);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->fechaliq);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->nrodoc);
                    $doc->exportCaption($this->cotiz);
                    $doc->exportCaption($this->usuarioultmod);
                    $doc->exportCaption($this->fecultmod);
                } else {
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->tcomp);
                    $doc->exportCaption($this->serie);
                    $doc->exportCaption($this->ncomp);
                    $doc->exportCaption($this->cliente);
                    $doc->exportCaption($this->rubro);
                    $doc->exportCaption($this->calle);
                    $doc->exportCaption($this->dnro);
                    $doc->exportCaption($this->pisodto);
                    $doc->exportCaption($this->codpost);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->fecharem);
                    $doc->exportCaption($this->cuit);
                    $doc->exportCaption($this->tipoiva);
                    $doc->exportCaption($this->totremate);
                    $doc->exportCaption($this->totneto1);
                    $doc->exportCaption($this->totiva21);
                    $doc->exportCaption($this->subtot1);
                    $doc->exportCaption($this->totneto2);
                    $doc->exportCaption($this->totiva105);
                    $doc->exportCaption($this->subtot2);
                    $doc->exportCaption($this->totacuenta);
                    $doc->exportCaption($this->totgastos);
                    $doc->exportCaption($this->totvarios);
                    $doc->exportCaption($this->saldoafav);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->fechaliq);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->nrodoc);
                    $doc->exportCaption($this->cotiz);
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
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->rubro);
                        $doc->exportField($this->calle);
                        $doc->exportField($this->dnro);
                        $doc->exportField($this->pisodto);
                        $doc->exportField($this->codpost);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->fecharem);
                        $doc->exportField($this->cuit);
                        $doc->exportField($this->tipoiva);
                        $doc->exportField($this->totremate);
                        $doc->exportField($this->totneto1);
                        $doc->exportField($this->totiva21);
                        $doc->exportField($this->subtot1);
                        $doc->exportField($this->totneto2);
                        $doc->exportField($this->totiva105);
                        $doc->exportField($this->subtot2);
                        $doc->exportField($this->totacuenta);
                        $doc->exportField($this->totgastos);
                        $doc->exportField($this->totvarios);
                        $doc->exportField($this->saldoafav);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->fechaliq);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->nrodoc);
                        $doc->exportField($this->cotiz);
                        $doc->exportField($this->usuarioultmod);
                        $doc->exportField($this->fecultmod);
                    } else {
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->tcomp);
                        $doc->exportField($this->serie);
                        $doc->exportField($this->ncomp);
                        $doc->exportField($this->cliente);
                        $doc->exportField($this->rubro);
                        $doc->exportField($this->calle);
                        $doc->exportField($this->dnro);
                        $doc->exportField($this->pisodto);
                        $doc->exportField($this->codpost);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->fecharem);
                        $doc->exportField($this->cuit);
                        $doc->exportField($this->tipoiva);
                        $doc->exportField($this->totremate);
                        $doc->exportField($this->totneto1);
                        $doc->exportField($this->totiva21);
                        $doc->exportField($this->subtot1);
                        $doc->exportField($this->totneto2);
                        $doc->exportField($this->totiva105);
                        $doc->exportField($this->subtot2);
                        $doc->exportField($this->totacuenta);
                        $doc->exportField($this->totgastos);
                        $doc->exportField($this->totvarios);
                        $doc->exportField($this->saldoafav);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->fechaliq);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->nrodoc);
                        $doc->exportField($this->cotiz);
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
