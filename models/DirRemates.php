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
 * Table class for dir_remates
 */
class DirRemates extends DbTable
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
    public $codigo;
    public $codrem;
    public $secuencia;
    public $direccion;
    public $codpais;
    public $codprov;
    public $codloc;
    public $usuarioalta;
    public $fechaalta;
    public $usuariomod;
    public $fechaultmod;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "dir_remates";
        $this->TableName = 'dir_remates';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "dir_remates";
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

        // codigo
        $this->codigo = new DbField(
            $this, // Table
            'x_codigo', // Variable name
            'codigo', // Name
            '`codigo`', // Expression
            '`codigo`', // Basic search expression
            3, // Type
            9, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codigo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->codigo->InputTextType = "text";
        $this->codigo->Raw = true;
        $this->codigo->IsAutoIncrement = true; // Autoincrement field
        $this->codigo->IsPrimaryKey = true; // Primary key field
        $this->codigo->Nullable = false; // NOT NULL field
        $this->codigo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codigo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codigo'] = &$this->codigo;

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
        $this->codrem->Nullable = false; // NOT NULL field
        $this->codrem->Required = true; // Required field
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
        $this->codrem->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codrem'] = &$this->codrem;

        // secuencia
        $this->secuencia = new DbField(
            $this, // Table
            'x_secuencia', // Variable name
            'secuencia', // Name
            '`secuencia`', // Expression
            '`secuencia`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`secuencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->secuencia->InputTextType = "text";
        $this->secuencia->Raw = true;
        $this->secuencia->Nullable = false; // NOT NULL field
        $this->secuencia->Required = true; // Required field
        $this->secuencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->secuencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['secuencia'] = &$this->secuencia;

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
            '`codpais`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codpais->InputTextType = "text";
        $this->codpais->Raw = true;
        $this->codpais->Nullable = false; // NOT NULL field
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
        $this->codpais->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codpais'] = &$this->codpais;

        // codprov
        $this->codprov = new DbField(
            $this, // Table
            'x_codprov', // Variable name
            'codprov', // Name
            '`codprov`', // Expression
            '`codprov`', // Basic search expression
            3, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codprov`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
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
                $this->codprov->Lookup = new Lookup($this->codprov, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', ["x_codpais"], ["x_codloc"], ["codpais"], ["x_codpais"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
            default:
                $this->codprov->Lookup = new Lookup($this->codprov, 'provincias', false, 'codnum', ["descripcion","","",""], '', '', ["x_codpais"], ["x_codloc"], ["codpais"], ["x_codpais"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
                break;
        }
        $this->codprov->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->codprov->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codprov'] = &$this->codprov;

        // codloc
        $this->codloc = new DbField(
            $this, // Table
            'x_codloc', // Variable name
            'codloc', // Name
            '`codloc`', // Expression
            '`codloc`', // Basic search expression
            3, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`codloc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->codloc->InputTextType = "text";
        $this->codloc->Raw = true;
        $this->codloc->Nullable = false; // NOT NULL field
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
        $this->codloc->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['codloc'] = &$this->codloc;

        // usuarioalta
        $this->usuarioalta = new DbField(
            $this, // Table
            'x_usuarioalta', // Variable name
            'usuarioalta', // Name
            '`usuarioalta`', // Expression
            '`usuarioalta`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuarioalta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->usuarioalta->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->usuarioalta->InputTextType = "text";
        $this->usuarioalta->Raw = true;
        $this->usuarioalta->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuarioalta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuarioalta'] = &$this->usuarioalta;

        // fechaalta
        $this->fechaalta = new DbField(
            $this, // Table
            'x_fechaalta', // Variable name
            'fechaalta', // Name
            '`fechaalta`', // Expression
            CastDateFieldForLike("`fechaalta`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`fechaalta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechaalta->addMethod("getAutoUpdateValue", fn() => CurrentDateTime());
        $this->fechaalta->InputTextType = "text";
        $this->fechaalta->Raw = true;
        $this->fechaalta->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->fechaalta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fechaalta'] = &$this->fechaalta;

        // usuariomod
        $this->usuariomod = new DbField(
            $this, // Table
            'x_usuariomod', // Variable name
            'usuariomod', // Name
            '`usuariomod`', // Expression
            '`usuariomod`', // Basic search expression
            3, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuariomod`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->usuariomod->addMethod("getAutoUpdateValue", fn() => cogerUsuario());
        $this->usuariomod->InputTextType = "text";
        $this->usuariomod->Raw = true;
        $this->usuariomod->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuariomod->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuariomod'] = &$this->usuariomod;

        // fechaultmod
        $this->fechaultmod = new DbField(
            $this, // Table
            'x_fechaultmod', // Variable name
            'fechaultmod', // Name
            '`fechaultmod`', // Expression
            CastDateFieldForLike("`fechaultmod`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`fechaultmod`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fechaultmod->addMethod("getAutoUpdateValue", fn() => CurrentDateTime());
        $this->fechaultmod->InputTextType = "text";
        $this->fechaultmod->Raw = true;
        $this->fechaultmod->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->fechaultmod->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fechaultmod'] = &$this->fechaultmod;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "dir_remates";
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
            $this->codigo->setDbValue($conn->lastInsertId());
            $rs['codigo'] = $this->codigo->DbValue;
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
            if (!isset($rs['codigo']) && !EmptyValue($this->codigo->CurrentValue)) {
                $rs['codigo'] = $this->codigo->CurrentValue;
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
            if (array_key_exists('codigo', $rs)) {
                AddFilter($where, QuotedName('codigo', $this->Dbid) . '=' . QuotedValue($rs['codigo'], $this->codigo->DataType, $this->Dbid));
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
        $this->codigo->DbValue = $row['codigo'];
        $this->codrem->DbValue = $row['codrem'];
        $this->secuencia->DbValue = $row['secuencia'];
        $this->direccion->DbValue = $row['direccion'];
        $this->codpais->DbValue = $row['codpais'];
        $this->codprov->DbValue = $row['codprov'];
        $this->codloc->DbValue = $row['codloc'];
        $this->usuarioalta->DbValue = $row['usuarioalta'];
        $this->fechaalta->DbValue = $row['fechaalta'];
        $this->usuariomod->DbValue = $row['usuariomod'];
        $this->fechaultmod->DbValue = $row['fechaultmod'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`codigo` = @codigo@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->codigo->CurrentValue : $this->codigo->OldValue;
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
                $this->codigo->CurrentValue = $keys[0];
            } else {
                $this->codigo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('codigo', $row) ? $row['codigo'] : null;
        } else {
            $val = !EmptyValue($this->codigo->OldValue) && !$current ? $this->codigo->OldValue : $this->codigo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@codigo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("DirRematesList");
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
            "DirRematesView" => $Language->phrase("View"),
            "DirRematesEdit" => $Language->phrase("Edit"),
            "DirRematesAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "DirRematesList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "DirRematesView",
            Config("API_ADD_ACTION") => "DirRematesAdd",
            Config("API_EDIT_ACTION") => "DirRematesEdit",
            Config("API_DELETE_ACTION") => "DirRematesDelete",
            Config("API_LIST_ACTION") => "DirRematesList",
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
        return "DirRematesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("DirRematesView", $parm);
        } else {
            $url = $this->keyUrl("DirRematesView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "DirRematesAdd?" . $parm;
        } else {
            $url = "DirRematesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("DirRematesEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("DirRematesList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("DirRematesAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("DirRematesList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("DirRematesDelete", $parm);
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
        $json .= "\"codigo\":" . VarToJson($this->codigo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->codigo->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->codigo->CurrentValue);
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
            if (($keyValue = Param("codigo") ?? Route("codigo")) !== null) {
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
                $this->codigo->CurrentValue = $key;
            } else {
                $this->codigo->OldValue = $key;
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
        $this->codigo->setDbValue($row['codigo']);
        $this->codrem->setDbValue($row['codrem']);
        $this->secuencia->setDbValue($row['secuencia']);
        $this->direccion->setDbValue($row['direccion']);
        $this->codpais->setDbValue($row['codpais']);
        $this->codprov->setDbValue($row['codprov']);
        $this->codloc->setDbValue($row['codloc']);
        $this->usuarioalta->setDbValue($row['usuarioalta']);
        $this->fechaalta->setDbValue($row['fechaalta']);
        $this->usuariomod->setDbValue($row['usuariomod']);
        $this->fechaultmod->setDbValue($row['fechaultmod']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "DirRematesList";
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

        // codigo

        // codrem

        // secuencia

        // direccion

        // codpais

        // codprov

        // codloc

        // usuarioalta

        // fechaalta

        // usuariomod

        // fechaultmod

        // codigo
        $this->codigo->ViewValue = $this->codigo->CurrentValue;

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

        // secuencia
        $this->secuencia->ViewValue = $this->secuencia->CurrentValue;
        $this->secuencia->ViewValue = FormatNumber($this->secuencia->ViewValue, $this->secuencia->formatPattern());

        // direccion
        $this->direccion->ViewValue = $this->direccion->CurrentValue;

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

        // codprov
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

        // codloc
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

        // usuarioalta
        $this->usuarioalta->ViewValue = $this->usuarioalta->CurrentValue;
        $this->usuarioalta->ViewValue = FormatNumber($this->usuarioalta->ViewValue, $this->usuarioalta->formatPattern());

        // fechaalta
        $this->fechaalta->ViewValue = $this->fechaalta->CurrentValue;
        $this->fechaalta->ViewValue = FormatDateTime($this->fechaalta->ViewValue, $this->fechaalta->formatPattern());

        // usuariomod
        $this->usuariomod->ViewValue = $this->usuariomod->CurrentValue;
        $this->usuariomod->ViewValue = FormatNumber($this->usuariomod->ViewValue, $this->usuariomod->formatPattern());

        // fechaultmod
        $this->fechaultmod->ViewValue = $this->fechaultmod->CurrentValue;
        $this->fechaultmod->ViewValue = FormatDateTime($this->fechaultmod->ViewValue, $this->fechaultmod->formatPattern());

        // codigo
        $this->codigo->HrefValue = "";
        $this->codigo->TooltipValue = "";

        // codrem
        $this->codrem->HrefValue = "";
        $this->codrem->TooltipValue = "";

        // secuencia
        $this->secuencia->HrefValue = "";
        $this->secuencia->TooltipValue = "";

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

        // usuarioalta
        $this->usuarioalta->HrefValue = "";
        $this->usuarioalta->TooltipValue = "";

        // fechaalta
        $this->fechaalta->HrefValue = "";
        $this->fechaalta->TooltipValue = "";

        // usuariomod
        $this->usuariomod->HrefValue = "";
        $this->usuariomod->TooltipValue = "";

        // fechaultmod
        $this->fechaultmod->HrefValue = "";
        $this->fechaultmod->TooltipValue = "";

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

        // codigo
        $this->codigo->setupEditAttributes();
        $this->codigo->EditValue = $this->codigo->CurrentValue;

        // codrem
        $this->codrem->setupEditAttributes();
        $this->codrem->PlaceHolder = RemoveHtml($this->codrem->caption());

        // secuencia
        $this->secuencia->setupEditAttributes();
        $this->secuencia->EditValue = $this->secuencia->CurrentValue;
        $this->secuencia->PlaceHolder = RemoveHtml($this->secuencia->caption());
        if (strval($this->secuencia->EditValue) != "" && is_numeric($this->secuencia->EditValue)) {
            $this->secuencia->EditValue = FormatNumber($this->secuencia->EditValue, null);
        }

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

        // usuarioalta

        // fechaalta

        // usuariomod

        // fechaultmod

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
                    $doc->exportCaption($this->codigo);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->secuencia);
                    $doc->exportCaption($this->direccion);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->usuarioalta);
                    $doc->exportCaption($this->fechaalta);
                    $doc->exportCaption($this->usuariomod);
                    $doc->exportCaption($this->fechaultmod);
                } else {
                    $doc->exportCaption($this->codigo);
                    $doc->exportCaption($this->codrem);
                    $doc->exportCaption($this->secuencia);
                    $doc->exportCaption($this->direccion);
                    $doc->exportCaption($this->codpais);
                    $doc->exportCaption($this->codprov);
                    $doc->exportCaption($this->codloc);
                    $doc->exportCaption($this->usuarioalta);
                    $doc->exportCaption($this->fechaalta);
                    $doc->exportCaption($this->usuariomod);
                    $doc->exportCaption($this->fechaultmod);
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
                        $doc->exportField($this->codigo);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->secuencia);
                        $doc->exportField($this->direccion);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->usuarioalta);
                        $doc->exportField($this->fechaalta);
                        $doc->exportField($this->usuariomod);
                        $doc->exportField($this->fechaultmod);
                    } else {
                        $doc->exportField($this->codigo);
                        $doc->exportField($this->codrem);
                        $doc->exportField($this->secuencia);
                        $doc->exportField($this->direccion);
                        $doc->exportField($this->codpais);
                        $doc->exportField($this->codprov);
                        $doc->exportField($this->codloc);
                        $doc->exportField($this->usuarioalta);
                        $doc->exportField($this->fechaalta);
                        $doc->exportField($this->usuariomod);
                        $doc->exportField($this->fechaultmod);
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
