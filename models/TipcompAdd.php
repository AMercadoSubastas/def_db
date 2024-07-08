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
class TipcompAdd extends Tipcomp
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "TipcompAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "TipcompAdd";

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
        $this->descripcion->setVisibility();
        $this->activo->setVisibility();
        $this->esfactura->setVisibility();
        $this->esprovedor->setVisibility();
        $this->codafip->setVisibility();
        $this->usuarioalta->setVisibility();
        $this->fechaalta->setVisibility();
        $this->usuariomod->Visible = false;
        $this->fechaultmod->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'tipcomp';
        $this->TableName = 'tipcomp';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (tipcomp)
        if (!isset($GLOBALS["tipcomp"]) || $GLOBALS["tipcomp"]::class == PROJECT_NAMESPACE . "tipcomp") {
            $GLOBALS["tipcomp"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tipcomp');
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
                        $result["view"] = SameString($pageName, "TipcompView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->activo);
        $this->setupLookupOptions($this->esfactura);
        $this->setupLookupOptions($this->esprovedor);

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
                    $this->terminate("TipcompList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "TipcompList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "TipcompView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "TipcompList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "TipcompList"; // Return list page content
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
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'descripcion' first before field var 'x_descripcion'
        $val = $CurrentForm->hasValue("descripcion") ? $CurrentForm->getValue("descripcion") : $CurrentForm->getValue("x_descripcion");
        if (!$this->descripcion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion->Visible = false; // Disable update for API request
            } else {
                $this->descripcion->setFormValue($val);
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

        // Check field name 'esfactura' first before field var 'x_esfactura'
        $val = $CurrentForm->hasValue("esfactura") ? $CurrentForm->getValue("esfactura") : $CurrentForm->getValue("x_esfactura");
        if (!$this->esfactura->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->esfactura->Visible = false; // Disable update for API request
            } else {
                $this->esfactura->setFormValue($val);
            }
        }

        // Check field name 'esprovedor' first before field var 'x_esprovedor'
        $val = $CurrentForm->hasValue("esprovedor") ? $CurrentForm->getValue("esprovedor") : $CurrentForm->getValue("x_esprovedor");
        if (!$this->esprovedor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->esprovedor->Visible = false; // Disable update for API request
            } else {
                $this->esprovedor->setFormValue($val);
            }
        }

        // Check field name 'codafip' first before field var 'x_codafip'
        $val = $CurrentForm->hasValue("codafip") ? $CurrentForm->getValue("codafip") : $CurrentForm->getValue("x_codafip");
        if (!$this->codafip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codafip->Visible = false; // Disable update for API request
            } else {
                $this->codafip->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'usuarioalta' first before field var 'x_usuarioalta'
        $val = $CurrentForm->hasValue("usuarioalta") ? $CurrentForm->getValue("usuarioalta") : $CurrentForm->getValue("x_usuarioalta");
        if (!$this->usuarioalta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuarioalta->Visible = false; // Disable update for API request
            } else {
                $this->usuarioalta->setFormValue($val);
            }
        }

        // Check field name 'fechaalta' first before field var 'x_fechaalta'
        $val = $CurrentForm->hasValue("fechaalta") ? $CurrentForm->getValue("fechaalta") : $CurrentForm->getValue("x_fechaalta");
        if (!$this->fechaalta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechaalta->Visible = false; // Disable update for API request
            } else {
                $this->fechaalta->setFormValue($val);
            }
            $this->fechaalta->CurrentValue = UnFormatDateTime($this->fechaalta->CurrentValue, $this->fechaalta->formatPattern());
        }

        // Check field name 'fechaultmod' first before field var 'x_fechaultmod'
        $val = $CurrentForm->hasValue("fechaultmod") ? $CurrentForm->getValue("fechaultmod") : $CurrentForm->getValue("x_fechaultmod");
        if (!$this->fechaultmod->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechaultmod->Visible = false; // Disable update for API request
            } else {
                $this->fechaultmod->setFormValue($val);
            }
            $this->fechaultmod->CurrentValue = UnFormatDateTime($this->fechaultmod->CurrentValue, $this->fechaultmod->formatPattern());
        }

        // Check field name 'codnum' first before field var 'x_codnum'
        $val = $CurrentForm->hasValue("codnum") ? $CurrentForm->getValue("codnum") : $CurrentForm->getValue("x_codnum");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->descripcion->CurrentValue = $this->descripcion->FormValue;
        $this->activo->CurrentValue = $this->activo->FormValue;
        $this->esfactura->CurrentValue = $this->esfactura->FormValue;
        $this->esprovedor->CurrentValue = $this->esprovedor->FormValue;
        $this->codafip->CurrentValue = $this->codafip->FormValue;
        $this->usuarioalta->CurrentValue = $this->usuarioalta->FormValue;
        $this->fechaalta->CurrentValue = $this->fechaalta->FormValue;
        $this->fechaalta->CurrentValue = UnFormatDateTime($this->fechaalta->CurrentValue, $this->fechaalta->formatPattern());
        $this->fechaultmod->CurrentValue = $this->fechaultmod->FormValue;
        $this->fechaultmod->CurrentValue = UnFormatDateTime($this->fechaultmod->CurrentValue, $this->fechaultmod->formatPattern());
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
        $this->descripcion->setDbValue($row['descripcion']);
        $this->activo->setDbValue($row['activo']);
        $this->esfactura->setDbValue($row['esfactura']);
        $this->esprovedor->setDbValue($row['esprovedor']);
        $this->codafip->setDbValue($row['codafip']);
        $this->usuarioalta->setDbValue($row['usuarioalta']);
        $this->fechaalta->setDbValue($row['fechaalta']);
        $this->usuariomod->setDbValue($row['usuariomod']);
        $this->fechaultmod->setDbValue($row['fechaultmod']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['descripcion'] = $this->descripcion->DefaultValue;
        $row['activo'] = $this->activo->DefaultValue;
        $row['esfactura'] = $this->esfactura->DefaultValue;
        $row['esprovedor'] = $this->esprovedor->DefaultValue;
        $row['codafip'] = $this->codafip->DefaultValue;
        $row['usuarioalta'] = $this->usuarioalta->DefaultValue;
        $row['fechaalta'] = $this->fechaalta->DefaultValue;
        $row['usuariomod'] = $this->usuariomod->DefaultValue;
        $row['fechaultmod'] = $this->fechaultmod->DefaultValue;
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

        // descripcion
        $this->descripcion->RowCssClass = "row";

        // activo
        $this->activo->RowCssClass = "row";

        // esfactura
        $this->esfactura->RowCssClass = "row";

        // esprovedor
        $this->esprovedor->RowCssClass = "row";

        // codafip
        $this->codafip->RowCssClass = "row";

        // usuarioalta
        $this->usuarioalta->RowCssClass = "row";

        // fechaalta
        $this->fechaalta->RowCssClass = "row";

        // usuariomod
        $this->usuariomod->RowCssClass = "row";

        // fechaultmod
        $this->fechaultmod->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // codnum
            $this->codnum->ViewValue = $this->codnum->CurrentValue;

            // descripcion
            $this->descripcion->ViewValue = $this->descripcion->CurrentValue;

            // activo
            if (ConvertToBool($this->activo->CurrentValue)) {
                $this->activo->ViewValue = $this->activo->tagCaption(1) != "" ? $this->activo->tagCaption(1) : "Sí";
            } else {
                $this->activo->ViewValue = $this->activo->tagCaption(2) != "" ? $this->activo->tagCaption(2) : "No";
            }

            // esfactura
            if (ConvertToBool($this->esfactura->CurrentValue)) {
                $this->esfactura->ViewValue = $this->esfactura->tagCaption(1) != "" ? $this->esfactura->tagCaption(1) : "Sí";
            } else {
                $this->esfactura->ViewValue = $this->esfactura->tagCaption(2) != "" ? $this->esfactura->tagCaption(2) : "No";
            }

            // esprovedor
            if (ConvertToBool($this->esprovedor->CurrentValue)) {
                $this->esprovedor->ViewValue = $this->esprovedor->tagCaption(1) != "" ? $this->esprovedor->tagCaption(1) : "Sí";
            } else {
                $this->esprovedor->ViewValue = $this->esprovedor->tagCaption(2) != "" ? $this->esprovedor->tagCaption(2) : "No";
            }

            // codafip
            $this->codafip->ViewValue = $this->codafip->CurrentValue;
            $this->codafip->ViewValue = FormatNumber($this->codafip->ViewValue, $this->codafip->formatPattern());

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

            // descripcion
            $this->descripcion->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";

            // esfactura
            $this->esfactura->HrefValue = "";

            // esprovedor
            $this->esprovedor->HrefValue = "";

            // codafip
            $this->codafip->HrefValue = "";

            // usuarioalta
            $this->usuarioalta->HrefValue = "";

            // fechaalta
            $this->fechaalta->HrefValue = "";

            // fechaultmod
            $this->fechaultmod->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // descripcion
            $this->descripcion->setupEditAttributes();
            if (!$this->descripcion->Raw) {
                $this->descripcion->CurrentValue = HtmlDecode($this->descripcion->CurrentValue);
            }
            $this->descripcion->EditValue = HtmlEncode($this->descripcion->CurrentValue);
            $this->descripcion->PlaceHolder = RemoveHtml($this->descripcion->caption());

            // activo
            $this->activo->EditValue = $this->activo->options(false);
            $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

            // esfactura
            $this->esfactura->EditValue = $this->esfactura->options(false);
            $this->esfactura->PlaceHolder = RemoveHtml($this->esfactura->caption());

            // esprovedor
            $this->esprovedor->EditValue = $this->esprovedor->options(false);
            $this->esprovedor->PlaceHolder = RemoveHtml($this->esprovedor->caption());

            // codafip
            $this->codafip->setupEditAttributes();
            $this->codafip->EditValue = $this->codafip->CurrentValue;
            $this->codafip->PlaceHolder = RemoveHtml($this->codafip->caption());
            if (strval($this->codafip->EditValue) != "" && is_numeric($this->codafip->EditValue)) {
                $this->codafip->EditValue = FormatNumber($this->codafip->EditValue, null);
            }

            // usuarioalta

            // fechaalta

            // fechaultmod

            // Add refer script

            // descripcion
            $this->descripcion->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";

            // esfactura
            $this->esfactura->HrefValue = "";

            // esprovedor
            $this->esprovedor->HrefValue = "";

            // codafip
            $this->codafip->HrefValue = "";

            // usuarioalta
            $this->usuarioalta->HrefValue = "";

            // fechaalta
            $this->fechaalta->HrefValue = "";

            // fechaultmod
            $this->fechaultmod->HrefValue = "";
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
            if ($this->descripcion->Visible && $this->descripcion->Required) {
                if (!$this->descripcion->IsDetailKey && EmptyValue($this->descripcion->FormValue)) {
                    $this->descripcion->addErrorMessage(str_replace("%s", $this->descripcion->caption(), $this->descripcion->RequiredErrorMessage));
                }
            }
            if ($this->activo->Visible && $this->activo->Required) {
                if ($this->activo->FormValue == "") {
                    $this->activo->addErrorMessage(str_replace("%s", $this->activo->caption(), $this->activo->RequiredErrorMessage));
                }
            }
            if ($this->esfactura->Visible && $this->esfactura->Required) {
                if ($this->esfactura->FormValue == "") {
                    $this->esfactura->addErrorMessage(str_replace("%s", $this->esfactura->caption(), $this->esfactura->RequiredErrorMessage));
                }
            }
            if ($this->esprovedor->Visible && $this->esprovedor->Required) {
                if ($this->esprovedor->FormValue == "") {
                    $this->esprovedor->addErrorMessage(str_replace("%s", $this->esprovedor->caption(), $this->esprovedor->RequiredErrorMessage));
                }
            }
            if ($this->codafip->Visible && $this->codafip->Required) {
                if (!$this->codafip->IsDetailKey && EmptyValue($this->codafip->FormValue)) {
                    $this->codafip->addErrorMessage(str_replace("%s", $this->codafip->caption(), $this->codafip->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->codafip->FormValue)) {
                $this->codafip->addErrorMessage($this->codafip->getErrorMessage(false));
            }
            if ($this->usuarioalta->Visible && $this->usuarioalta->Required) {
                if (!$this->usuarioalta->IsDetailKey && EmptyValue($this->usuarioalta->FormValue)) {
                    $this->usuarioalta->addErrorMessage(str_replace("%s", $this->usuarioalta->caption(), $this->usuarioalta->RequiredErrorMessage));
                }
            }
            if ($this->fechaalta->Visible && $this->fechaalta->Required) {
                if (!$this->fechaalta->IsDetailKey && EmptyValue($this->fechaalta->FormValue)) {
                    $this->fechaalta->addErrorMessage(str_replace("%s", $this->fechaalta->caption(), $this->fechaalta->RequiredErrorMessage));
                }
            }
            if ($this->fechaultmod->Visible && $this->fechaultmod->Required) {
                if (!$this->fechaultmod->IsDetailKey && EmptyValue($this->fechaultmod->FormValue)) {
                    $this->fechaultmod->addErrorMessage(str_replace("%s", $this->fechaultmod->caption(), $this->fechaultmod->RequiredErrorMessage));
                }
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

        // descripcion
        $this->descripcion->setDbValueDef($rsnew, $this->descripcion->CurrentValue, false);

        // activo
        $this->activo->setDbValueDef($rsnew, strval($this->activo->CurrentValue) == "1" ? "1" : "0", strval($this->activo->CurrentValue) == "");

        // esfactura
        $this->esfactura->setDbValueDef($rsnew, strval($this->esfactura->CurrentValue) == "1" ? "1" : "0", false);

        // esprovedor
        $this->esprovedor->setDbValueDef($rsnew, strval($this->esprovedor->CurrentValue) == "1" ? "1" : "0", false);

        // codafip
        $this->codafip->setDbValueDef($rsnew, $this->codafip->CurrentValue, false);

        // usuarioalta
        $this->usuarioalta->CurrentValue = $this->usuarioalta->getAutoUpdateValue(); // PHP
        $this->usuarioalta->setDbValueDef($rsnew, $this->usuarioalta->CurrentValue, false);

        // fechaalta
        $this->fechaalta->CurrentValue = $this->fechaalta->getAutoUpdateValue(); // PHP
        $this->fechaalta->setDbValueDef($rsnew, UnFormatDateTime($this->fechaalta->CurrentValue, $this->fechaalta->formatPattern()), false);

        // fechaultmod
        $this->fechaultmod->CurrentValue = $this->fechaultmod->getAutoUpdateValue(); // PHP
        $this->fechaultmod->setDbValueDef($rsnew, UnFormatDateTime($this->fechaultmod->CurrentValue, $this->fechaultmod->formatPattern()), false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['descripcion'])) { // descripcion
            $this->descripcion->setFormValue($row['descripcion']);
        }
        if (isset($row['activo'])) { // activo
            $this->activo->setFormValue($row['activo']);
        }
        if (isset($row['esfactura'])) { // esfactura
            $this->esfactura->setFormValue($row['esfactura']);
        }
        if (isset($row['esprovedor'])) { // esprovedor
            $this->esprovedor->setFormValue($row['esprovedor']);
        }
        if (isset($row['codafip'])) { // codafip
            $this->codafip->setFormValue($row['codafip']);
        }
        if (isset($row['usuarioalta'])) { // usuarioalta
            $this->usuarioalta->setFormValue($row['usuarioalta']);
        }
        if (isset($row['fechaalta'])) { // fechaalta
            $this->fechaalta->setFormValue($row['fechaalta']);
        }
        if (isset($row['fechaultmod'])) { // fechaultmod
            $this->fechaultmod->setFormValue($row['fechaultmod']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TipcompList"), "", $this->TableVar, true);
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
                case "x_activo":
                    break;
                case "x_esfactura":
                    break;
                case "x_esprovedor":
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
