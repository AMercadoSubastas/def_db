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
 * Table class for detfac
 */
class Detfac extends DbTable
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
    public $nreng;
    public $codrem;
    public $codlote;
    public $descrip;
    public $neto;
    public $bruto;
    public $iva;
    public $imp;
    public $comcob;
    public $compag;
    public $fechahora;
    public $usuario;
    public $porciva;
    public $tieneresol;
    public $concafac;
    public $tcomsal;
    public $seriesal;
    public $ncompsal;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "detfac";
        $this->TableName = 'detfac';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "detfac";
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
        $this->tcomp->IsForeignKey = true; // Foreign key field
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
        $this->serie->IsForeignKey = true; // Foreign key field
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
        $this->ncomp->IsForeignKey = true; // Foreign key field
        $this->ncomp->Nullable = false; // NOT NULL field
        $this->ncomp->Required = true; // Required field
        $this->ncomp->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ncomp->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['ncomp'] = &$this->ncomp;

        // nreng
        $this->nreng = new DbField(
            $this, // Table
            'x_nreng', // Variable name
            'nreng', // Name
            '`nreng`', // Expression
            '`nreng`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nreng`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nreng->InputTextType = "text";
        $this->nreng->Raw = true;
        $this->nreng->Nullable = false; // NOT NULL field
        $this->nreng->Required = true; // Required field
        $this->nreng->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->nreng->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['nreng'] = &$this->nreng;

        // codrem
        $this->codrem = new DbField(
            $this, // Table
            'x_codrem', // Variable name
            'codrem', // Name
            '`codrem`', // Expression
            '`codrem`', // Basic search expression
            3, // Type
            5, // Size
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
        $this->codrem->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codrem->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['codrem'] = &$this->codrem;

        // codlote
        $this->codlote = new DbField(
            $this, // Table
            'x_codlote', // Variable name
            'codlote', // Name
            '`codlote`', // Expression
            '`codlote`', // Basic search expression
            3, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codlote`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->codlote->InputTextType = "text";
        $this->codlote->Raw = true;
        $this->codlote->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codlote->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['codlote'] = &$this->codlote;

        // descrip
        $this->descrip = new DbField(
            $this, // Table
            'x_descrip', // Variable name
            'descrip', // Name
            '`descrip`', // Expression
            '`descrip`', // Basic search expression
            200, // Type
            300, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`descrip`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->descrip->InputTextType = "text";
        $this->descrip->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['descrip'] = &$this->descrip;

        // neto
        $this->neto = new DbField(
            $this, // Table
            'x_neto', // Variable name
            'neto', // Name
            '`neto`', // Expression
            '`neto`', // Basic search expression
            131, // Type
            14, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`neto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->neto->addMethod("getDefault", fn() => 0.00);
        $this->neto->InputTextType = "text";
        $this->neto->Raw = true;
        $this->neto->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->neto->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['neto'] = &$this->neto;

        // bruto
        $this->bruto = new DbField(
            $this, // Table
            'x_bruto', // Variable name
            'bruto', // Name
            '`bruto`', // Expression
            '`bruto`', // Basic search expression
            131, // Type
            14, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`bruto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->bruto->addMethod("getDefault", fn() => 0.00);
        $this->bruto->InputTextType = "text";
        $this->bruto->Raw = true;
        $this->bruto->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->bruto->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['bruto'] = &$this->bruto;

        // iva
        $this->iva = new DbField(
            $this, // Table
            'x_iva', // Variable name
            'iva', // Name
            '`iva`', // Expression
            '`iva`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`iva`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->iva->addMethod("getDefault", fn() => 0.00);
        $this->iva->InputTextType = "text";
        $this->iva->Raw = true;
        $this->iva->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->iva->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['iva'] = &$this->iva;

        // imp
        $this->imp = new DbField(
            $this, // Table
            'x_imp', // Variable name
            'imp', // Name
            '`imp`', // Expression
            '`imp`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`imp`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->imp->addMethod("getDefault", fn() => 0.00);
        $this->imp->InputTextType = "text";
        $this->imp->Raw = true;
        $this->imp->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->imp->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['imp'] = &$this->imp;

        // comcob
        $this->comcob = new DbField(
            $this, // Table
            'x_comcob', // Variable name
            'comcob', // Name
            '`comcob`', // Expression
            '`comcob`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`comcob`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->comcob->addMethod("getDefault", fn() => 0.00);
        $this->comcob->InputTextType = "text";
        $this->comcob->Raw = true;
        $this->comcob->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->comcob->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['comcob'] = &$this->comcob;

        // compag
        $this->compag = new DbField(
            $this, // Table
            'x_compag', // Variable name
            'compag', // Name
            '`compag`', // Expression
            '`compag`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`compag`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->compag->addMethod("getDefault", fn() => 0.00);
        $this->compag->InputTextType = "text";
        $this->compag->Raw = true;
        $this->compag->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->compag->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['compag'] = &$this->compag;

        // fechahora
        $this->fechahora = new DbField(
            $this, // Table
            'x_fechahora', // Variable name
            'fechahora', // Name
            '`fechahora`', // Expression
            CastDateFieldForLike("`fechahora`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
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
        $this->fechahora->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
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
            11, // Size
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
            'TEXT' // Edit Tag
        );
        $this->porciva->InputTextType = "text";
        $this->porciva->Raw = true;
        $this->porciva->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->porciva->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['porciva'] = &$this->porciva;

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

        // concafac
        $this->concafac = new DbField(
            $this, // Table
            'x_concafac', // Variable name
            'concafac', // Name
            '`concafac`', // Expression
            '`concafac`', // Basic search expression
            3, // Type
            9, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`concafac`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->concafac->InputTextType = "text";
        $this->concafac->Raw = true;
        $this->concafac->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->concafac->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['concafac'] = &$this->concafac;

        // tcomsal
        $this->tcomsal = new DbField(
            $this, // Table
            'x_tcomsal', // Variable name
            'tcomsal', // Name
            '`tcomsal`', // Expression
            '`tcomsal`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tcomsal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tcomsal->InputTextType = "text";
        $this->tcomsal->Raw = true;
        $this->tcomsal->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tcomsal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tcomsal'] = &$this->tcomsal;

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
        if ($this->getCurrentMasterTable() == "cabfac") {
            $masterTable = Container("cabfac");
            if ($this->tcomp->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->tcomp, $this->tcomp->getSessionValue(), $masterTable->tcomp->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
            if ($this->serie->getSessionValue() != "") {
                $masterFilter .= " AND " . GetKeyFilter($masterTable->serie, $this->serie->getSessionValue(), $masterTable->serie->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
            if ($this->ncomp->getSessionValue() != "") {
                $masterFilter .= " AND " . GetKeyFilter($masterTable->ncomp, $this->ncomp->getSessionValue(), $masterTable->ncomp->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "cabfac") {
            $masterTable = Container("cabfac");
            if ($this->tcomp->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->tcomp, $this->tcomp->getSessionValue(), $masterTable->tcomp->DataType, $this->Dbid);
            } else {
                return "";
            }
            if ($this->serie->getSessionValue() != "") {
                $detailFilter .= " AND " . GetKeyFilter($this->serie, $this->serie->getSessionValue(), $masterTable->serie->DataType, $this->Dbid);
            } else {
                return "";
            }
            if ($this->ncomp->getSessionValue() != "") {
                $detailFilter .= " AND " . GetKeyFilter($this->ncomp, $this->ncomp->getSessionValue(), $masterTable->ncomp->DataType, $this->Dbid);
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
            case "cabfac":
                $key = $keys["tcomp"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->tcomp->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                $key = $keys["serie"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->serie->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                $key = $keys["ncomp"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->ncomp->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->tcomp, $keys["tcomp"], $this->tcomp->DataType, $this->Dbid) . " AND " . GetKeyFilter($masterTable->serie, $keys["serie"], $this->serie->DataType, $this->Dbid) . " AND " . GetKeyFilter($masterTable->ncomp, $keys["ncomp"], $this->ncomp->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "cabfac":
                return GetKeyFilter($this->tcomp, $masterTable->tcomp->DbValue, $masterTable->tcomp->DataType, $masterTable->Dbid) . " AND " . GetKeyFilter($this->serie, $masterTable->serie->DbValue, $masterTable->serie->DataType, $masterTable->Dbid) . " AND " . GetKeyFilter($this->ncomp, $masterTable->ncomp->DbValue, $masterTable->ncomp->DataType, $masterTable->Dbid);
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "detfac";
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
        $this->nreng->DbValue = $row['nreng'];
        $this->codrem->DbValue = $row['codrem'];
        $this->codlote->DbValue = $row['codlote'];
        $this->descrip->DbValue = $row['descrip'];
        $this->neto->DbValue = $row['neto'];
        $this->bruto->DbValue = $row['bruto'];
        $this->iva->DbValue = $row['iva'];
        $this->imp->DbValue = $row['imp'];
        $this->comcob->DbValue = $row['comcob'];
        $this->compag->DbValue = $row['compag'];
        $this->fechahora->DbValue = $row['fechahora'];
        $this->usuario->DbValue = $row['usuario'];
        $this->porciva->DbValue = $row['porciva'];
        $this->tieneresol->DbValue = $row['tieneresol'];
        $this->concafac->DbValue = $row['concafac'];
        $this->tcomsal->DbValue = $row['tcomsal'];
        $this->seriesal->DbValue = $row['seriesal'];
        $this->ncompsal->DbValue = $row['ncompsal'];
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
        return $_SESSION[$name] ?? GetUrl("DetfacList");
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
            "DetfacView" => $Language->phrase("View"),
            "DetfacEdit" => $Language->phrase("Edit"),
            "DetfacAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "DetfacList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "DetfacView",
            Config("API_ADD_ACTION") => "DetfacAdd",
            Config("API_EDIT_ACTION") => "DetfacEdit",
            Config("API_DELETE_ACTION") => "DetfacDelete",
            Config("API_LIST_ACTION") => "DetfacList",
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
        return "DetfacList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("DetfacView", $parm);
        } else {
            $url = $this->keyUrl("DetfacView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "DetfacAdd?" . $parm;
        } else {
            $url = "DetfacAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("DetfacEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("DetfacList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("DetfacAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("DetfacList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("DetfacDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "cabfac" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_tcomp", $this->tcomp->getSessionValue()); // Use Session Value
            $url .= "&" . GetForeignKeyUrl("fk_serie", $this->serie->getSessionValue()); // Use Session Value
            $url .= "&" . GetForeignKeyUrl("fk_ncomp", $this->ncomp->getSessionValue()); // Use Session Value
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
        $this->tcomp->setDbValue($row['tcomp']);
        $this->serie->setDbValue($row['serie']);
        $this->ncomp->setDbValue($row['ncomp']);
        $this->nreng->setDbValue($row['nreng']);
        $this->codrem->setDbValue($row['codrem']);
        $this->codlote->setDbValue($row['codlote']);
        $this->descrip->setDbValue($row['descrip']);
        $this->neto->setDbValue($row['neto']);
        $this->bruto->setDbValue($row['bruto']);
        $this->iva->setDbValue($row['iva']);
        $this->imp->setDbValue($row['imp']);
        $this->comcob->setDbValue($row['comcob']);
        $this->compag->setDbValue($row['compag']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->usuario->setDbValue($row['usuario']);
        $this->porciva->setDbValue($row['porciva']);
        $this->tieneresol->setDbValue($row['tieneresol']);
        $this->concafac->setDbValue($row['concafac']);
        $this->tcomsal->setDbValue($row['tcomsal']);
        $this->seriesal->setDbValue($row['seriesal']);
        $this->ncompsal->setDbValue($row['ncompsal']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "DetfacList";
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

        // nreng

        // codrem

        // codlote

        // descrip

        // neto

        // bruto

        // iva

        // imp

        // comcob

        // compag

        // fechahora

        // usuario

        // porciva

        // tieneresol

        // concafac

        // tcomsal

        // seriesal

        // ncompsal

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

        // nreng
        $this->nreng->ViewValue = $this->nreng->CurrentValue;
        $this->nreng->ViewValue = FormatNumber($this->nreng->ViewValue, $this->nreng->formatPattern());

        // codrem
        $this->codrem->ViewValue = $this->codrem->CurrentValue;
        $this->codrem->ViewValue = FormatNumber($this->codrem->ViewValue, $this->codrem->formatPattern());

        // codlote
        $this->codlote->ViewValue = $this->codlote->CurrentValue;
        $this->codlote->ViewValue = FormatNumber($this->codlote->ViewValue, $this->codlote->formatPattern());

        // descrip
        $this->descrip->ViewValue = $this->descrip->CurrentValue;

        // neto
        $this->neto->ViewValue = $this->neto->CurrentValue;
        $this->neto->ViewValue = FormatNumber($this->neto->ViewValue, $this->neto->formatPattern());

        // bruto
        $this->bruto->ViewValue = $this->bruto->CurrentValue;
        $this->bruto->ViewValue = FormatNumber($this->bruto->ViewValue, $this->bruto->formatPattern());

        // iva
        $this->iva->ViewValue = $this->iva->CurrentValue;
        $this->iva->ViewValue = FormatNumber($this->iva->ViewValue, $this->iva->formatPattern());

        // imp
        $this->imp->ViewValue = $this->imp->CurrentValue;
        $this->imp->ViewValue = FormatNumber($this->imp->ViewValue, $this->imp->formatPattern());

        // comcob
        $this->comcob->ViewValue = $this->comcob->CurrentValue;
        $this->comcob->ViewValue = FormatNumber($this->comcob->ViewValue, $this->comcob->formatPattern());

        // compag
        $this->compag->ViewValue = $this->compag->CurrentValue;
        $this->compag->ViewValue = FormatNumber($this->compag->ViewValue, $this->compag->formatPattern());

        // fechahora
        $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
        $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

        // usuario
        $this->usuario->ViewValue = $this->usuario->CurrentValue;
        $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

        // porciva
        $this->porciva->ViewValue = $this->porciva->CurrentValue;
        $this->porciva->ViewValue = FormatNumber($this->porciva->ViewValue, $this->porciva->formatPattern());

        // tieneresol
        $this->tieneresol->ViewValue = $this->tieneresol->CurrentValue;

        // concafac
        $this->concafac->ViewValue = $this->concafac->CurrentValue;
        $this->concafac->ViewValue = FormatNumber($this->concafac->ViewValue, $this->concafac->formatPattern());

        // tcomsal
        $this->tcomsal->ViewValue = $this->tcomsal->CurrentValue;
        $this->tcomsal->ViewValue = FormatNumber($this->tcomsal->ViewValue, $this->tcomsal->formatPattern());

        // seriesal
        $this->seriesal->ViewValue = $this->seriesal->CurrentValue;
        $this->seriesal->ViewValue = FormatNumber($this->seriesal->ViewValue, $this->seriesal->formatPattern());

        // ncompsal
        $this->ncompsal->ViewValue = $this->ncompsal->CurrentValue;
        $this->ncompsal->ViewValue = FormatNumber($this->ncompsal->ViewValue, $this->ncompsal->formatPattern());

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

        // nreng
        $this->nreng->HrefValue = "";
        $this->nreng->TooltipValue = "";

        // codrem
        $this->codrem->HrefValue = "";
        $this->codrem->TooltipValue = "";

        // codlote
        $this->codlote->HrefValue = "";
        $this->codlote->TooltipValue = "";

        // descrip
        $this->descrip->HrefValue = "";
        $this->descrip->TooltipValue = "";

        // neto
        $this->neto->HrefValue = "";
        $this->neto->TooltipValue = "";

        // bruto
        $this->bruto->HrefValue = "";
        $this->bruto->TooltipValue = "";

        // iva
        $this->iva->HrefValue = "";
        $this->iva->TooltipValue = "";

        // imp
        $this->imp->HrefValue = "";
        $this->imp->TooltipValue = "";

        // comcob
        $this->comcob->HrefValue = "";
        $this->comcob->TooltipValue = "";

        // compag
        $this->compag->HrefValue = "";
        $this->compag->TooltipValue = "";

        // fechahora
        $this->fechahora->HrefValue = "";
        $this->fechahora->TooltipValue = "";

        // usuario
        $this->usuario->HrefValue = "";
        $this->usuario->TooltipValue = "";

        // porciva
        $this->porciva->HrefValue = "";
        $this->porciva->TooltipValue = "";

        // tieneresol
        $this->tieneresol->HrefValue = "";
        $this->tieneresol->TooltipValue = "";

        // concafac
        $this->concafac->HrefValue = "";
        $this->concafac->TooltipValue = "";

        // tcomsal
        $this->tcomsal->HrefValue = "";
        $this->tcomsal->TooltipValue = "";

        // seriesal
        $this->seriesal->HrefValue = "";
        $this->seriesal->TooltipValue = "";

        // ncompsal
        $this->ncompsal->HrefValue = "";
        $this->ncompsal->TooltipValue = "";

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
        if ($this->tcomp->getSessionValue() != "") {
            $this->tcomp->CurrentValue = GetForeignKeyValue($this->tcomp->getSessionValue());
            $this->tcomp->ViewValue = $this->tcomp->CurrentValue;
            $this->tcomp->ViewValue = FormatNumber($this->tcomp->ViewValue, $this->tcomp->formatPattern());
        } else {
            $this->tcomp->EditValue = $this->tcomp->CurrentValue;
            $this->tcomp->PlaceHolder = RemoveHtml($this->tcomp->caption());
            if (strval($this->tcomp->EditValue) != "" && is_numeric($this->tcomp->EditValue)) {
                $this->tcomp->EditValue = FormatNumber($this->tcomp->EditValue, null);
            }
        }

        // serie
        $this->serie->setupEditAttributes();
        if ($this->serie->getSessionValue() != "") {
            $this->serie->CurrentValue = GetForeignKeyValue($this->serie->getSessionValue());
            $this->serie->ViewValue = $this->serie->CurrentValue;
            $this->serie->ViewValue = FormatNumber($this->serie->ViewValue, $this->serie->formatPattern());
        } else {
            $this->serie->EditValue = $this->serie->CurrentValue;
            $this->serie->PlaceHolder = RemoveHtml($this->serie->caption());
            if (strval($this->serie->EditValue) != "" && is_numeric($this->serie->EditValue)) {
                $this->serie->EditValue = FormatNumber($this->serie->EditValue, null);
            }
        }

        // ncomp
        $this->ncomp->setupEditAttributes();
        if ($this->ncomp->getSessionValue() != "") {
            $this->ncomp->CurrentValue = GetForeignKeyValue($this->ncomp->getSessionValue());
            $this->ncomp->ViewValue = $this->ncomp->CurrentValue;
            $this->ncomp->ViewValue = FormatNumber($this->ncomp->ViewValue, $this->ncomp->formatPattern());
        } else {
            $this->ncomp->EditValue = $this->ncomp->CurrentValue;
            $this->ncomp->PlaceHolder = RemoveHtml($this->ncomp->caption());
            if (strval($this->ncomp->EditValue) != "" && is_numeric($this->ncomp->EditValue)) {
                $this->ncomp->EditValue = FormatNumber($this->ncomp->EditValue, null);
            }
        }

        // nreng
        $this->nreng->setupEditAttributes();
        $this->nreng->EditValue = $this->nreng->CurrentValue;
        $this->nreng->PlaceHolder = RemoveHtml($this->nreng->caption());
        if (strval($this->nreng->EditValue) != "" && is_numeric($this->nreng->EditValue)) {
            $this->nreng->EditValue = FormatNumber($this->nreng->EditValue, null);
        }

        // codrem
        $this->codrem->setupEditAttributes();
        $this->codrem->EditValue = $this->codrem->CurrentValue;
        $this->codrem->PlaceHolder = RemoveHtml($this->codrem->caption());
        if (strval($this->codrem->EditValue) != "" && is_numeric($this->codrem->EditValue)) {
            $this->codrem->EditValue = FormatNumber($this->codrem->EditValue, null);
        }

        // codlote
        $this->codlote->setupEditAttributes();
        $this->codlote->EditValue = $this->codlote->CurrentValue;
        $this->codlote->PlaceHolder = RemoveHtml($this->codlote->caption());
        if (strval($this->codlote->EditValue) != "" && is_numeric($this->codlote->EditValue)) {
            $this->codlote->EditValue = FormatNumber($this->codlote->EditValue, null);
        }

        // descrip
        $this->descrip->setupEditAttributes();
        if (!$this->descrip->Raw) {
            $this->descrip->CurrentValue = HtmlDecode($this->descrip->CurrentValue);
        }
        $this->descrip->EditValue = $this->descrip->CurrentValue;
        $this->descrip->PlaceHolder = RemoveHtml($this->descrip->caption());

        // neto
        $this->neto->setupEditAttributes();
        $this->neto->EditValue = $this->neto->CurrentValue;
        $this->neto->PlaceHolder = RemoveHtml($this->neto->caption());
        if (strval($this->neto->EditValue) != "" && is_numeric($this->neto->EditValue)) {
            $this->neto->EditValue = FormatNumber($this->neto->EditValue, null);
        }

        // bruto
        $this->bruto->setupEditAttributes();
        $this->bruto->EditValue = $this->bruto->CurrentValue;
        $this->bruto->PlaceHolder = RemoveHtml($this->bruto->caption());
        if (strval($this->bruto->EditValue) != "" && is_numeric($this->bruto->EditValue)) {
            $this->bruto->EditValue = FormatNumber($this->bruto->EditValue, null);
        }

        // iva
        $this->iva->setupEditAttributes();
        $this->iva->EditValue = $this->iva->CurrentValue;
        $this->iva->PlaceHolder = RemoveHtml($this->iva->caption());
        if (strval($this->iva->EditValue) != "" && is_numeric($this->iva->EditValue)) {
            $this->iva->EditValue = FormatNumber($this->iva->EditValue, null);
        }

        // imp
        $this->imp->setupEditAttributes();
        $this->imp->EditValue = $this->imp->CurrentValue;
        $this->imp->PlaceHolder = RemoveHtml($this->imp->caption());
        if (strval($this->imp->EditValue) != "" && is_numeric($this->imp->EditValue)) {
            $this->imp->EditValue = FormatNumber($this->imp->EditValue, null);
        }

        // comcob
        $this->comcob->setupEditAttributes();
        $this->comcob->EditValue = $this->comcob->CurrentValue;
        $this->comcob->PlaceHolder = RemoveHtml($this->comcob->caption());
        if (strval($this->comcob->EditValue) != "" && is_numeric($this->comcob->EditValue)) {
            $this->comcob->EditValue = FormatNumber($this->comcob->EditValue, null);
        }

        // compag
        $this->compag->setupEditAttributes();
        $this->compag->EditValue = $this->compag->CurrentValue;
        $this->compag->PlaceHolder = RemoveHtml($this->compag->caption());
        if (strval($this->compag->EditValue) != "" && is_numeric($this->compag->EditValue)) {
            $this->compag->EditValue = FormatNumber($this->compag->EditValue, null);
        }

        // fechahora

        // usuario

        // porciva
        $this->porciva->setupEditAttributes();
        $this->porciva->EditValue = $this->porciva->CurrentValue;
        $this->porciva->PlaceHolder = RemoveHtml($this->porciva->caption());
        if (strval($this->porciva->EditValue) != "" && is_numeric($this->porciva->EditValue)) {
            $this->porciva->EditValue = FormatNumber($this->porciva->EditValue, null);
        }

        // tieneresol
        $this->tieneresol->setupEditAttributes();
        if (strval($this->tieneresol->EditValue) != "" && is_numeric($this->tieneresol->EditValue)) {
            $this->tieneresol->EditValue = $this->tieneresol->EditValue;
        }

        // concafac
        $this->concafac->setupEditAttributes();
        $this->concafac->EditValue = $this->concafac->CurrentValue;
        $this->concafac->PlaceHolder = RemoveHtml($this->concafac->caption());
        if (strval($this->concafac->EditValue) != "" && is_numeric($this->concafac->EditValue)) {
            $this->concafac->EditValue = FormatNumber($this->concafac->EditValue, null);
        }

        // tcomsal
        $this->tcomsal->setupEditAttributes();
        $this->tcomsal->EditValue = $this->tcomsal->CurrentValue;
        $this->tcomsal->PlaceHolder = RemoveHtml($this->tcomsal->caption());
        if (strval($this->tcomsal->EditValue) != "" && is_numeric($this->tcomsal->EditValue)) {
            $this->tcomsal->EditValue = FormatNumber($this->tcomsal->EditValue, null);
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
                    $doc->exportCaption($this->nreng);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->codlote);
                    $doc->exportCaption($this->descrip);
                    $doc->exportCaption($this->neto);
                    $doc->exportCaption($this->bruto);
                    $doc->exportCaption($this->iva);
                    $doc->exportCaption($this->imp);
                    $doc->exportCaption($this->comcob);
                    $doc->exportCaption($this->compag);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->porciva);
                    $doc->exportCaption($this->tieneresol);
                    $doc->exportCaption($this->concafac);
                    $doc->exportCaption($this->tcomsal);
                    $doc->exportCaption($this->seriesal);
                    $doc->exportCaption($this->ncompsal);
                } else {
                    $doc->exportCaption($this->codnum);
                    $doc->exportCaption($this->tcomp);
                    $doc->exportCaption($this->serie);
                    $doc->exportCaption($this->ncomp);
                    $doc->exportCaption($this->nreng);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->codlote);
                    $doc->exportCaption($this->descrip);
                    $doc->exportCaption($this->neto);
                    $doc->exportCaption($this->bruto);
                    $doc->exportCaption($this->iva);
                    $doc->exportCaption($this->imp);
                    $doc->exportCaption($this->comcob);
                    $doc->exportCaption($this->compag);
                    $doc->exportCaption($this->fechahora);
                    $doc->exportCaption($this->usuario);
                    $doc->exportCaption($this->porciva);
                    $doc->exportCaption($this->tieneresol);
                    $doc->exportCaption($this->concafac);
                    $doc->exportCaption($this->tcomsal);
                    $doc->exportCaption($this->seriesal);
                    $doc->exportCaption($this->ncompsal);
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
                        $doc->exportField($this->nreng);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->codlote);
                        $doc->exportField($this->descrip);
                        $doc->exportField($this->neto);
                        $doc->exportField($this->bruto);
                        $doc->exportField($this->iva);
                        $doc->exportField($this->imp);
                        $doc->exportField($this->comcob);
                        $doc->exportField($this->compag);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->porciva);
                        $doc->exportField($this->tieneresol);
                        $doc->exportField($this->concafac);
                        $doc->exportField($this->tcomsal);
                        $doc->exportField($this->seriesal);
                        $doc->exportField($this->ncompsal);
                    } else {
                        $doc->exportField($this->codnum);
                        $doc->exportField($this->tcomp);
                        $doc->exportField($this->serie);
                        $doc->exportField($this->ncomp);
                        $doc->exportField($this->nreng);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->codlote);
                        $doc->exportField($this->descrip);
                        $doc->exportField($this->neto);
                        $doc->exportField($this->bruto);
                        $doc->exportField($this->iva);
                        $doc->exportField($this->imp);
                        $doc->exportField($this->comcob);
                        $doc->exportField($this->compag);
                        $doc->exportField($this->fechahora);
                        $doc->exportField($this->usuario);
                        $doc->exportField($this->porciva);
                        $doc->exportField($this->tieneresol);
                        $doc->exportField($this->concafac);
                        $doc->exportField($this->tcomsal);
                        $doc->exportField($this->seriesal);
                        $doc->exportField($this->ncompsal);
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
