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
class EntidadesDelete extends Entidades
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "EntidadesDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "EntidadesDelete";

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
        $this->razsoc->setVisibility();
        $this->calle->setVisibility();
        $this->numero->setVisibility();
        $this->pisodto->setVisibility();
        $this->codpais->setVisibility();
        $this->codprov->setVisibility();
        $this->codloc->setVisibility();
        $this->codpost->setVisibility();
        $this->tellinea->setVisibility();
        $this->telcelu->setVisibility();
        $this->tipoent->setVisibility();
        $this->tipoiva->setVisibility();
        $this->cuit->setVisibility();
        $this->calif->setVisibility();
        $this->fecalta->setVisibility();
        $this->usuario->setVisibility();
        $this->contacto->setVisibility();
        $this->mailcont->setVisibility();
        $this->cargo->setVisibility();
        $this->fechahora->setVisibility();
        $this->activo->setVisibility();
        $this->pagweb->setVisibility();
        $this->tipoind->setVisibility();
        $this->usuarioultmod->setVisibility();
        $this->fecultmod->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'entidades';
        $this->TableName = 'entidades';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (entidades)
        if (!isset($GLOBALS["entidades"]) || $GLOBALS["entidades"]::class == PROJECT_NAMESPACE . "entidades") {
            $GLOBALS["entidades"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'entidades');
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

        // Set up lookup cache
        $this->setupLookupOptions($this->codpais);
        $this->setupLookupOptions($this->codprov);
        $this->setupLookupOptions($this->codloc);
        $this->setupLookupOptions($this->tipoent);
        $this->setupLookupOptions($this->tipoiva);
        $this->setupLookupOptions($this->cuit);
        $this->setupLookupOptions($this->calif);
        $this->setupLookupOptions($this->activo);
        $this->setupLookupOptions($this->tipoind);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("EntidadesList"); // Prevent SQL injection, return to list
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
                $this->terminate("EntidadesList"); // Return to list
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
        $this->razsoc->setDbValue($row['razsoc']);
        $this->calle->setDbValue($row['calle']);
        $this->numero->setDbValue($row['numero']);
        $this->pisodto->setDbValue($row['pisodto']);
        $this->codpais->setDbValue($row['codpais']);
        if (array_key_exists('EV__codpais', $row)) {
            $this->codpais->VirtualValue = $row['EV__codpais']; // Set up virtual field value
        } else {
            $this->codpais->VirtualValue = ""; // Clear value
        }
        $this->codprov->setDbValue($row['codprov']);
        if (array_key_exists('EV__codprov', $row)) {
            $this->codprov->VirtualValue = $row['EV__codprov']; // Set up virtual field value
        } else {
            $this->codprov->VirtualValue = ""; // Clear value
        }
        $this->codloc->setDbValue($row['codloc']);
        if (array_key_exists('EV__codloc', $row)) {
            $this->codloc->VirtualValue = $row['EV__codloc']; // Set up virtual field value
        } else {
            $this->codloc->VirtualValue = ""; // Clear value
        }
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['razsoc'] = $this->razsoc->DefaultValue;
        $row['calle'] = $this->calle->DefaultValue;
        $row['numero'] = $this->numero->DefaultValue;
        $row['pisodto'] = $this->pisodto->DefaultValue;
        $row['codpais'] = $this->codpais->DefaultValue;
        $row['codprov'] = $this->codprov->DefaultValue;
        $row['codloc'] = $this->codloc->DefaultValue;
        $row['codpost'] = $this->codpost->DefaultValue;
        $row['tellinea'] = $this->tellinea->DefaultValue;
        $row['telcelu'] = $this->telcelu->DefaultValue;
        $row['tipoent'] = $this->tipoent->DefaultValue;
        $row['tipoiva'] = $this->tipoiva->DefaultValue;
        $row['cuit'] = $this->cuit->DefaultValue;
        $row['calif'] = $this->calif->DefaultValue;
        $row['fecalta'] = $this->fecalta->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['contacto'] = $this->contacto->DefaultValue;
        $row['mailcont'] = $this->mailcont->DefaultValue;
        $row['cargo'] = $this->cargo->DefaultValue;
        $row['fechahora'] = $this->fechahora->DefaultValue;
        $row['activo'] = $this->activo->DefaultValue;
        $row['pagweb'] = $this->pagweb->DefaultValue;
        $row['tipoind'] = $this->tipoind->DefaultValue;
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

        // View row
        if ($this->RowType == RowType::VIEW) {
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("EntidadesList"), "", $this->TableVar, true);
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
                case "x_codpais":
                    break;
                case "x_codprov":
                    break;
                case "x_codloc":
                    break;
                case "x_tipoent":
                    break;
                case "x_tipoiva":
                    break;
                case "x_cuit":
                    break;
                case "x_calif":
                    break;
                case "x_activo":
                    break;
                case "x_tipoind":
                    break;
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
