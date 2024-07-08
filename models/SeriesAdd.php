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
class SeriesAdd extends Series
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "SeriesAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "SeriesAdd";

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
        $this->codnum->Visible = false;
        $this->tipcomp->setVisibility();
        $this->descripcion->setVisibility();
        $this->nrodesde->setVisibility();
        $this->nrohasta->setVisibility();
        $this->nroact->setVisibility();
        $this->mascara->setVisibility();
        $this->activo->setVisibility();
        $this->automatica->setVisibility();
        $this->fechatope->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'series';
        $this->TableName = 'series';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (series)
        if (!isset($GLOBALS["series"]) || $GLOBALS["series"]::class == PROJECT_NAMESPACE . "series") {
            $GLOBALS["series"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'series');
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (
                    SameString($pageName, GetPageName($this->getListUrl())) ||
                    SameString($pageName, GetPageName($this->getViewUrl())) ||
                    SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "SeriesView"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                        $this->clearFailureMessage();
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Create form object
        $CurrentForm = new HttpForm();
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
        $this->setupLookupOptions($this->tipcomp);
        $this->setupLookupOptions($this->activo);
        $this->setupLookupOptions($this->automatica);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("codnum") ?? Route("codnum")) !== null) {
                $this->codnum->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("SeriesList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "SeriesList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "SeriesView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "SeriesList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "SeriesList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->activo->DefaultValue = $this->activo->getDefault(); // PHP
        $this->activo->OldValue = $this->activo->DefaultValue;
        $this->automatica->DefaultValue = $this->automatica->getDefault(); // PHP
        $this->automatica->OldValue = $this->automatica->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'tipcomp' first before field var 'x_tipcomp'
        $val = $CurrentForm->hasValue("tipcomp") ? $CurrentForm->getValue("tipcomp") : $CurrentForm->getValue("x_tipcomp");
        if (!$this->tipcomp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipcomp->Visible = false; // Disable update for API request
            } else {
                $this->tipcomp->setFormValue($val);
            }
        }

        // Check field name 'descripcion' first before field var 'x_descripcion'
        $val = $CurrentForm->hasValue("descripcion") ? $CurrentForm->getValue("descripcion") : $CurrentForm->getValue("x_descripcion");
        if (!$this->descripcion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion->Visible = false; // Disable update for API request
            } else {
                $this->descripcion->setFormValue($val);
            }
        }

        // Check field name 'nrodesde' first before field var 'x_nrodesde'
        $val = $CurrentForm->hasValue("nrodesde") ? $CurrentForm->getValue("nrodesde") : $CurrentForm->getValue("x_nrodesde");
        if (!$this->nrodesde->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nrodesde->Visible = false; // Disable update for API request
            } else {
                $this->nrodesde->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'nrohasta' first before field var 'x_nrohasta'
        $val = $CurrentForm->hasValue("nrohasta") ? $CurrentForm->getValue("nrohasta") : $CurrentForm->getValue("x_nrohasta");
        if (!$this->nrohasta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nrohasta->Visible = false; // Disable update for API request
            } else {
                $this->nrohasta->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'nroact' first before field var 'x_nroact'
        $val = $CurrentForm->hasValue("nroact") ? $CurrentForm->getValue("nroact") : $CurrentForm->getValue("x_nroact");
        if (!$this->nroact->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nroact->Visible = false; // Disable update for API request
            } else {
                $this->nroact->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'mascara' first before field var 'x_mascara'
        $val = $CurrentForm->hasValue("mascara") ? $CurrentForm->getValue("mascara") : $CurrentForm->getValue("x_mascara");
        if (!$this->mascara->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mascara->Visible = false; // Disable update for API request
            } else {
                $this->mascara->setFormValue($val);
            }
        }

        // Check field name 'activo' first before field var 'x_activo'
        $val = $CurrentForm->hasValue("activo") ? $CurrentForm->getValue("activo") : $CurrentForm->getValue("x_activo");
        if (!$this->activo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->activo->Visible = false; // Disable update for API request
            } else {
                $this->activo->setFormValue($val);
            }
        }

        // Check field name 'automatica' first before field var 'x_automatica'
        $val = $CurrentForm->hasValue("automatica") ? $CurrentForm->getValue("automatica") : $CurrentForm->getValue("x_automatica");
        if (!$this->automatica->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->automatica->Visible = false; // Disable update for API request
            } else {
                $this->automatica->setFormValue($val);
            }
        }

        // Check field name 'fechatope' first before field var 'x_fechatope'
        $val = $CurrentForm->hasValue("fechatope") ? $CurrentForm->getValue("fechatope") : $CurrentForm->getValue("x_fechatope");
        if (!$this->fechatope->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechatope->Visible = false; // Disable update for API request
            } else {
                $this->fechatope->setFormValue($val, true, $validate);
            }
            $this->fechatope->CurrentValue = UnFormatDateTime($this->fechatope->CurrentValue, $this->fechatope->formatPattern());
        }

        // Check field name 'codnum' first before field var 'x_codnum'
        $val = $CurrentForm->hasValue("codnum") ? $CurrentForm->getValue("codnum") : $CurrentForm->getValue("x_codnum");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->tipcomp->CurrentValue = $this->tipcomp->FormValue;
        $this->descripcion->CurrentValue = $this->descripcion->FormValue;
        $this->nrodesde->CurrentValue = $this->nrodesde->FormValue;
        $this->nrohasta->CurrentValue = $this->nrohasta->FormValue;
        $this->nroact->CurrentValue = $this->nroact->FormValue;
        $this->mascara->CurrentValue = $this->mascara->FormValue;
        $this->activo->CurrentValue = $this->activo->FormValue;
        $this->automatica->CurrentValue = $this->automatica->FormValue;
        $this->fechatope->CurrentValue = $this->fechatope->FormValue;
        $this->fechatope->CurrentValue = UnFormatDateTime($this->fechatope->CurrentValue, $this->fechatope->formatPattern());
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
        $this->tipcomp->setDbValue($row['tipcomp']);
        $this->descripcion->setDbValue($row['descripcion']);
        $this->nrodesde->setDbValue($row['nrodesde']);
        $this->nrohasta->setDbValue($row['nrohasta']);
        $this->nroact->setDbValue($row['nroact']);
        $this->mascara->setDbValue($row['mascara']);
        $this->activo->setDbValue($row['activo']);
        $this->automatica->setDbValue($row['automatica']);
        $this->fechatope->setDbValue($row['fechatope']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['tipcomp'] = $this->tipcomp->DefaultValue;
        $row['descripcion'] = $this->descripcion->DefaultValue;
        $row['nrodesde'] = $this->nrodesde->DefaultValue;
        $row['nrohasta'] = $this->nrohasta->DefaultValue;
        $row['nroact'] = $this->nroact->DefaultValue;
        $row['mascara'] = $this->mascara->DefaultValue;
        $row['activo'] = $this->activo->DefaultValue;
        $row['automatica'] = $this->automatica->DefaultValue;
        $row['fechatope'] = $this->fechatope->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = ExecuteQuery($sql, $conn);
            if ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
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
        $this->codnum->RowCssClass = "row";

        // tipcomp
        $this->tipcomp->RowCssClass = "row";

        // descripcion
        $this->descripcion->RowCssClass = "row";

        // nrodesde
        $this->nrodesde->RowCssClass = "row";

        // nrohasta
        $this->nrohasta->RowCssClass = "row";

        // nroact
        $this->nroact->RowCssClass = "row";

        // mascara
        $this->mascara->RowCssClass = "row";

        // activo
        $this->activo->RowCssClass = "row";

        // automatica
        $this->automatica->RowCssClass = "row";

        // fechatope
        $this->fechatope->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // codnum
            $this->codnum->ViewValue = $this->codnum->CurrentValue;

            // tipcomp
            $curVal = strval($this->tipcomp->CurrentValue);
            if ($curVal != "") {
                $this->tipcomp->ViewValue = $this->tipcomp->lookupCacheOption($curVal);
                if ($this->tipcomp->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipcomp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tipcomp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->tipcomp->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipcomp->Lookup->renderViewRow($rswrk[0]);
                        $this->tipcomp->ViewValue = $this->tipcomp->displayValue($arwrk);
                    } else {
                        $this->tipcomp->ViewValue = FormatNumber($this->tipcomp->CurrentValue, $this->tipcomp->formatPattern());
                    }
                }
            } else {
                $this->tipcomp->ViewValue = null;
            }

            // descripcion
            $this->descripcion->ViewValue = $this->descripcion->CurrentValue;

            // nrodesde
            $this->nrodesde->ViewValue = $this->nrodesde->CurrentValue;
            $this->nrodesde->ViewValue = FormatNumber($this->nrodesde->ViewValue, $this->nrodesde->formatPattern());

            // nrohasta
            $this->nrohasta->ViewValue = $this->nrohasta->CurrentValue;
            $this->nrohasta->ViewValue = FormatNumber($this->nrohasta->ViewValue, $this->nrohasta->formatPattern());

            // nroact
            $this->nroact->ViewValue = $this->nroact->CurrentValue;
            $this->nroact->ViewValue = FormatNumber($this->nroact->ViewValue, $this->nroact->formatPattern());

            // mascara
            $this->mascara->ViewValue = $this->mascara->CurrentValue;

            // activo
            if (ConvertToBool($this->activo->CurrentValue)) {
                $this->activo->ViewValue = $this->activo->tagCaption(1) != "" ? $this->activo->tagCaption(1) : "Sí";
            } else {
                $this->activo->ViewValue = $this->activo->tagCaption(2) != "" ? $this->activo->tagCaption(2) : "No";
            }

            // automatica
            if (ConvertToBool($this->automatica->CurrentValue)) {
                $this->automatica->ViewValue = $this->automatica->tagCaption(1) != "" ? $this->automatica->tagCaption(1) : "Sí";
            } else {
                $this->automatica->ViewValue = $this->automatica->tagCaption(2) != "" ? $this->automatica->tagCaption(2) : "No";
            }

            // fechatope
            $this->fechatope->ViewValue = $this->fechatope->CurrentValue;
            $this->fechatope->ViewValue = FormatDateTime($this->fechatope->ViewValue, $this->fechatope->formatPattern());

            // tipcomp
            $this->tipcomp->HrefValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";

            // nrodesde
            $this->nrodesde->HrefValue = "";

            // nrohasta
            $this->nrohasta->HrefValue = "";

            // nroact
            $this->nroact->HrefValue = "";

            // mascara
            $this->mascara->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";

            // automatica
            $this->automatica->HrefValue = "";

            // fechatope
            $this->fechatope->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // tipcomp
            $this->tipcomp->setupEditAttributes();
            $curVal = trim(strval($this->tipcomp->CurrentValue));
            if ($curVal != "") {
                $this->tipcomp->ViewValue = $this->tipcomp->lookupCacheOption($curVal);
            } else {
                $this->tipcomp->ViewValue = $this->tipcomp->Lookup !== null && is_array($this->tipcomp->lookupOptions()) && count($this->tipcomp->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipcomp->ViewValue !== null) { // Load from cache
                $this->tipcomp->EditValue = array_values($this->tipcomp->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipcomp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->tipcomp->CurrentValue, $this->tipcomp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipcomp->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipcomp->EditValue = $arwrk;
            }
            $this->tipcomp->PlaceHolder = RemoveHtml($this->tipcomp->caption());

            // descripcion
            $this->descripcion->setupEditAttributes();
            if (!$this->descripcion->Raw) {
                $this->descripcion->CurrentValue = HtmlDecode($this->descripcion->CurrentValue);
            }
            $this->descripcion->EditValue = HtmlEncode($this->descripcion->CurrentValue);
            $this->descripcion->PlaceHolder = RemoveHtml($this->descripcion->caption());

            // nrodesde
            $this->nrodesde->setupEditAttributes();
            $this->nrodesde->EditValue = $this->nrodesde->CurrentValue;
            $this->nrodesde->PlaceHolder = RemoveHtml($this->nrodesde->caption());
            if (strval($this->nrodesde->EditValue) != "" && is_numeric($this->nrodesde->EditValue)) {
                $this->nrodesde->EditValue = FormatNumber($this->nrodesde->EditValue, null);
            }

            // nrohasta
            $this->nrohasta->setupEditAttributes();
            $this->nrohasta->EditValue = $this->nrohasta->CurrentValue;
            $this->nrohasta->PlaceHolder = RemoveHtml($this->nrohasta->caption());
            if (strval($this->nrohasta->EditValue) != "" && is_numeric($this->nrohasta->EditValue)) {
                $this->nrohasta->EditValue = FormatNumber($this->nrohasta->EditValue, null);
            }

            // nroact
            $this->nroact->setupEditAttributes();
            $this->nroact->EditValue = $this->nroact->CurrentValue;
            $this->nroact->PlaceHolder = RemoveHtml($this->nroact->caption());
            if (strval($this->nroact->EditValue) != "" && is_numeric($this->nroact->EditValue)) {
                $this->nroact->EditValue = FormatNumber($this->nroact->EditValue, null);
            }

            // mascara
            $this->mascara->setupEditAttributes();
            if (!$this->mascara->Raw) {
                $this->mascara->CurrentValue = HtmlDecode($this->mascara->CurrentValue);
            }
            $this->mascara->EditValue = HtmlEncode($this->mascara->CurrentValue);
            $this->mascara->PlaceHolder = RemoveHtml($this->mascara->caption());

            // activo
            $this->activo->EditValue = $this->activo->options(false);
            $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

            // automatica
            $this->automatica->EditValue = $this->automatica->options(false);
            $this->automatica->PlaceHolder = RemoveHtml($this->automatica->caption());

            // fechatope
            $this->fechatope->setupEditAttributes();
            $this->fechatope->EditValue = HtmlEncode(FormatDateTime($this->fechatope->CurrentValue, $this->fechatope->formatPattern()));
            $this->fechatope->PlaceHolder = RemoveHtml($this->fechatope->caption());

            // Add refer script

            // tipcomp
            $this->tipcomp->HrefValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";

            // nrodesde
            $this->nrodesde->HrefValue = "";

            // nrohasta
            $this->nrohasta->HrefValue = "";

            // nroact
            $this->nroact->HrefValue = "";

            // mascara
            $this->mascara->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";

            // automatica
            $this->automatica->HrefValue = "";

            // fechatope
            $this->fechatope->HrefValue = "";
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->tipcomp->Visible && $this->tipcomp->Required) {
                if (!$this->tipcomp->IsDetailKey && EmptyValue($this->tipcomp->FormValue)) {
                    $this->tipcomp->addErrorMessage(str_replace("%s", $this->tipcomp->caption(), $this->tipcomp->RequiredErrorMessage));
                }
            }
            if ($this->descripcion->Visible && $this->descripcion->Required) {
                if (!$this->descripcion->IsDetailKey && EmptyValue($this->descripcion->FormValue)) {
                    $this->descripcion->addErrorMessage(str_replace("%s", $this->descripcion->caption(), $this->descripcion->RequiredErrorMessage));
                }
            }
            if ($this->nrodesde->Visible && $this->nrodesde->Required) {
                if (!$this->nrodesde->IsDetailKey && EmptyValue($this->nrodesde->FormValue)) {
                    $this->nrodesde->addErrorMessage(str_replace("%s", $this->nrodesde->caption(), $this->nrodesde->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->nrodesde->FormValue)) {
                $this->nrodesde->addErrorMessage($this->nrodesde->getErrorMessage(false));
            }
            if ($this->nrohasta->Visible && $this->nrohasta->Required) {
                if (!$this->nrohasta->IsDetailKey && EmptyValue($this->nrohasta->FormValue)) {
                    $this->nrohasta->addErrorMessage(str_replace("%s", $this->nrohasta->caption(), $this->nrohasta->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->nrohasta->FormValue)) {
                $this->nrohasta->addErrorMessage($this->nrohasta->getErrorMessage(false));
            }
            if ($this->nroact->Visible && $this->nroact->Required) {
                if (!$this->nroact->IsDetailKey && EmptyValue($this->nroact->FormValue)) {
                    $this->nroact->addErrorMessage(str_replace("%s", $this->nroact->caption(), $this->nroact->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->nroact->FormValue)) {
                $this->nroact->addErrorMessage($this->nroact->getErrorMessage(false));
            }
            if ($this->mascara->Visible && $this->mascara->Required) {
                if (!$this->mascara->IsDetailKey && EmptyValue($this->mascara->FormValue)) {
                    $this->mascara->addErrorMessage(str_replace("%s", $this->mascara->caption(), $this->mascara->RequiredErrorMessage));
                }
            }
            if ($this->activo->Visible && $this->activo->Required) {
                if ($this->activo->FormValue == "") {
                    $this->activo->addErrorMessage(str_replace("%s", $this->activo->caption(), $this->activo->RequiredErrorMessage));
                }
            }
            if ($this->automatica->Visible && $this->automatica->Required) {
                if ($this->automatica->FormValue == "") {
                    $this->automatica->addErrorMessage(str_replace("%s", $this->automatica->caption(), $this->automatica->RequiredErrorMessage));
                }
            }
            if ($this->fechatope->Visible && $this->fechatope->Required) {
                if (!$this->fechatope->IsDetailKey && EmptyValue($this->fechatope->FormValue)) {
                    $this->fechatope->addErrorMessage(str_replace("%s", $this->fechatope->caption(), $this->fechatope->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fechatope->FormValue, $this->fechatope->formatPattern())) {
                $this->fechatope->addErrorMessage($this->fechatope->getErrorMessage(false));
            }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // tipcomp
        $this->tipcomp->setDbValueDef($rsnew, $this->tipcomp->CurrentValue, false);

        // descripcion
        $this->descripcion->setDbValueDef($rsnew, $this->descripcion->CurrentValue, false);

        // nrodesde
        $this->nrodesde->setDbValueDef($rsnew, $this->nrodesde->CurrentValue, false);

        // nrohasta
        $this->nrohasta->setDbValueDef($rsnew, $this->nrohasta->CurrentValue, false);

        // nroact
        $this->nroact->setDbValueDef($rsnew, $this->nroact->CurrentValue, false);

        // mascara
        $this->mascara->setDbValueDef($rsnew, $this->mascara->CurrentValue, false);

        // activo
        $this->activo->setDbValueDef($rsnew, strval($this->activo->CurrentValue) == "1" ? "1" : "0", strval($this->activo->CurrentValue) == "");

        // automatica
        $this->automatica->setDbValueDef($rsnew, strval($this->automatica->CurrentValue) == "1" ? "1" : "0", strval($this->automatica->CurrentValue) == "");

        // fechatope
        $this->fechatope->setDbValueDef($rsnew, UnFormatDateTime($this->fechatope->CurrentValue, $this->fechatope->formatPattern()), false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['tipcomp'])) { // tipcomp
            $this->tipcomp->setFormValue($row['tipcomp']);
        }
        if (isset($row['descripcion'])) { // descripcion
            $this->descripcion->setFormValue($row['descripcion']);
        }
        if (isset($row['nrodesde'])) { // nrodesde
            $this->nrodesde->setFormValue($row['nrodesde']);
        }
        if (isset($row['nrohasta'])) { // nrohasta
            $this->nrohasta->setFormValue($row['nrohasta']);
        }
        if (isset($row['nroact'])) { // nroact
            $this->nroact->setFormValue($row['nroact']);
        }
        if (isset($row['mascara'])) { // mascara
            $this->mascara->setFormValue($row['mascara']);
        }
        if (isset($row['activo'])) { // activo
            $this->activo->setFormValue($row['activo']);
        }
        if (isset($row['automatica'])) { // automatica
            $this->automatica->setFormValue($row['automatica']);
        }
        if (isset($row['fechatope'])) { // fechatope
            $this->fechatope->setFormValue($row['fechatope']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SeriesList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_tipcomp":
                    break;
                case "x_activo":
                    break;
                case "x_automatica":
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
