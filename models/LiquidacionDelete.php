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
 * Page class
 */
class LiquidacionDelete extends Liquidacion
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "LiquidacionDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "LiquidacionDelete";

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->codnum->setVisibility();
        $this->tcomp->setVisibility();
        $this->serie->setVisibility();
        $this->ncomp->setVisibility();
        $this->cliente->setVisibility();
        $this->rubro->setVisibility();
        $this->calle->setVisibility();
        $this->dnro->setVisibility();
        $this->pisodto->setVisibility();
        $this->codpost->setVisibility();
        $this->codpais->setVisibility();
        $this->codprov->setVisibility();
        $this->codloc->setVisibility();
        $this->codrem->setVisibility();
        $this->fecharem->setVisibility();
        $this->cuit->setVisibility();
        $this->tipoiva->setVisibility();
        $this->totremate->setVisibility();
        $this->totneto1->setVisibility();
        $this->totiva21->setVisibility();
        $this->subtot1->setVisibility();
        $this->totneto2->setVisibility();
        $this->totiva105->setVisibility();
        $this->subtot2->setVisibility();
        $this->totacuenta->setVisibility();
        $this->totgastos->setVisibility();
        $this->totvarios->setVisibility();
        $this->saldoafav->setVisibility();
        $this->fechahora->setVisibility();
        $this->usuario->setVisibility();
        $this->fechaliq->setVisibility();
        $this->estado->setVisibility();
        $this->nrodoc->setVisibility();
        $this->cotiz->setVisibility();
        $this->usuarioultmod->setVisibility();
        $this->fecultmod->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'liquidacion';
        $this->TableName = 'liquidacion';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (liquidacion)
        if (!isset($GLOBALS["liquidacion"]) || $GLOBALS["liquidacion"]::class == PROJECT_NAMESPACE . "liquidacion") {
            $GLOBALS["liquidacion"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'liquidacion');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['codnum'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->codnum->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
        $this->CurrentAction = Param("action"); // Set up current action
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("LiquidacionList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Param("action") !== null) {
            $this->CurrentAction = Param("action") == "delete" ? "delete" : "show";
        } else {
            $this->CurrentAction = $this->InlineDelete ?
                "delete" : // Delete record directly
                "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsJsonResponse()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsJsonResponse()) {
                    $this->terminate();
                    return;
                }
                // Return JSON error message if UseAjaxActions
                if ($this->UseAjaxActions) {
                    WriteJson(["success" => false, "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                }
                if ($this->InlineDelete) {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->CurrentAction = "show"; // Display record
                }
            }
        }
        if ($this->isShow()) { // Load records for display
            $this->Recordset = $this->loadRecordset();
            if ($this->TotalRecords <= 0) { // No record found, exit
                $this->Recordset?->free();
                $this->terminate("LiquidacionList"); // Return to list
                return;
            }
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    /**
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['tcomp'] = $this->tcomp->DefaultValue;
        $row['serie'] = $this->serie->DefaultValue;
        $row['ncomp'] = $this->ncomp->DefaultValue;
        $row['cliente'] = $this->cliente->DefaultValue;
        $row['rubro'] = $this->rubro->DefaultValue;
        $row['calle'] = $this->calle->DefaultValue;
        $row['dnro'] = $this->dnro->DefaultValue;
        $row['pisodto'] = $this->pisodto->DefaultValue;
        $row['codpost'] = $this->codpost->DefaultValue;
        $row['codpais'] = $this->codpais->DefaultValue;
        $row['codprov'] = $this->codprov->DefaultValue;
        $row['codloc'] = $this->codloc->DefaultValue;
        $row['codrem'] = $this->codrem->DefaultValue;
        $row['fecharem'] = $this->fecharem->DefaultValue;
        $row['cuit'] = $this->cuit->DefaultValue;
        $row['tipoiva'] = $this->tipoiva->DefaultValue;
        $row['totremate'] = $this->totremate->DefaultValue;
        $row['totneto1'] = $this->totneto1->DefaultValue;
        $row['totiva21'] = $this->totiva21->DefaultValue;
        $row['subtot1'] = $this->subtot1->DefaultValue;
        $row['totneto2'] = $this->totneto2->DefaultValue;
        $row['totiva105'] = $this->totiva105->DefaultValue;
        $row['subtot2'] = $this->subtot2->DefaultValue;
        $row['totacuenta'] = $this->totacuenta->DefaultValue;
        $row['totgastos'] = $this->totgastos->DefaultValue;
        $row['totvarios'] = $this->totvarios->DefaultValue;
        $row['saldoafav'] = $this->saldoafav->DefaultValue;
        $row['fechahora'] = $this->fechahora->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['fechaliq'] = $this->fechaliq->DefaultValue;
        $row['estado'] = $this->estado->DefaultValue;
        $row['nrodoc'] = $this->nrodoc->DefaultValue;
        $row['cotiz'] = $this->cotiz->DefaultValue;
        $row['usuarioultmod'] = $this->usuarioultmod->DefaultValue;
        $row['fecultmod'] = $this->fecultmod->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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

        // View row
        if ($this->RowType == RowType::VIEW) {
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
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['codnum'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
        }

        // Write JSON response
        if ((IsJsonResponse() || ConvertToBool(Param("infinitescroll"))) && $deleteRows) {
            $rows = $this->getRecordsFromRecordset($rsold);
            $table = $this->TableVar;
            if (Param("key_m") === null) { // Single delete
                $rows = $rows[0]; // Return object
            }
            WriteJson(["success" => true, "action" => Config("API_DELETE_ACTION"), $table => $rows]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("LiquidacionList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }
}
