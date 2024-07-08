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
class ImprangosAdd extends Imprangos
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ImprangosAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ImprangosAdd";

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
        $this->codimp->setVisibility();
        $this->secuencia->setVisibility();
        $this->monto_min->setVisibility();
        $this->monto_max->setVisibility();
        $this->porcentaje->setVisibility();
        $this->monto_fijo->setVisibility();
        $this->activo->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'imprangos';
        $this->TableName = 'imprangos';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (imprangos)
        if (!isset($GLOBALS["imprangos"]) || $GLOBALS["imprangos"]::class == PROJECT_NAMESPACE . "imprangos") {
            $GLOBALS["imprangos"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'imprangos');
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
                        $result["view"] = SameString($pageName, "ImprangosView"); // If View page, no primary button
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
            $key .= @$ar['codimp'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['secuencia'];
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
        $this->setupLookupOptions($this->codimp);
        $this->setupLookupOptions($this->activo);

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
            if (($keyValue = Get("codimp") ?? Route("codimp")) !== null) {
                $this->codimp->setQueryStringValue($keyValue);
            }
            if (($keyValue = Get("secuencia") ?? Route("secuencia")) !== null) {
                $this->secuencia->setQueryStringValue($keyValue);
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
                    $this->terminate("ImprangosList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ImprangosList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ImprangosView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ImprangosList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ImprangosList"; // Return list page content
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
        $this->monto_min->DefaultValue = $this->monto_min->getDefault(); // PHP
        $this->monto_min->OldValue = $this->monto_min->DefaultValue;
        $this->monto_max->DefaultValue = $this->monto_max->getDefault(); // PHP
        $this->monto_max->OldValue = $this->monto_max->DefaultValue;
        $this->activo->DefaultValue = $this->activo->getDefault(); // PHP
        $this->activo->OldValue = $this->activo->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'codimp' first before field var 'x_codimp'
        $val = $CurrentForm->hasValue("codimp") ? $CurrentForm->getValue("codimp") : $CurrentForm->getValue("x_codimp");
        if (!$this->codimp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codimp->Visible = false; // Disable update for API request
            } else {
                $this->codimp->setFormValue($val);
            }
        }

        // Check field name 'secuencia' first before field var 'x_secuencia'
        $val = $CurrentForm->hasValue("secuencia") ? $CurrentForm->getValue("secuencia") : $CurrentForm->getValue("x_secuencia");
        if (!$this->secuencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->secuencia->Visible = false; // Disable update for API request
            } else {
                $this->secuencia->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monto_min' first before field var 'x_monto_min'
        $val = $CurrentForm->hasValue("monto_min") ? $CurrentForm->getValue("monto_min") : $CurrentForm->getValue("x_monto_min");
        if (!$this->monto_min->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monto_min->Visible = false; // Disable update for API request
            } else {
                $this->monto_min->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monto_max' first before field var 'x_monto_max'
        $val = $CurrentForm->hasValue("monto_max") ? $CurrentForm->getValue("monto_max") : $CurrentForm->getValue("x_monto_max");
        if (!$this->monto_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monto_max->Visible = false; // Disable update for API request
            } else {
                $this->monto_max->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'porcentaje' first before field var 'x_porcentaje'
        $val = $CurrentForm->hasValue("porcentaje") ? $CurrentForm->getValue("porcentaje") : $CurrentForm->getValue("x_porcentaje");
        if (!$this->porcentaje->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porcentaje->Visible = false; // Disable update for API request
            } else {
                $this->porcentaje->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'monto_fijo' first before field var 'x_monto_fijo'
        $val = $CurrentForm->hasValue("monto_fijo") ? $CurrentForm->getValue("monto_fijo") : $CurrentForm->getValue("x_monto_fijo");
        if (!$this->monto_fijo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monto_fijo->Visible = false; // Disable update for API request
            } else {
                $this->monto_fijo->setFormValue($val, true, $validate);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->codimp->CurrentValue = $this->codimp->FormValue;
        $this->secuencia->CurrentValue = $this->secuencia->FormValue;
        $this->monto_min->CurrentValue = $this->monto_min->FormValue;
        $this->monto_max->CurrentValue = $this->monto_max->FormValue;
        $this->porcentaje->CurrentValue = $this->porcentaje->FormValue;
        $this->monto_fijo->CurrentValue = $this->monto_fijo->FormValue;
        $this->activo->CurrentValue = $this->activo->FormValue;
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
        $this->codimp->setDbValue($row['codimp']);
        $this->secuencia->setDbValue($row['secuencia']);
        $this->monto_min->setDbValue($row['monto_min']);
        $this->monto_max->setDbValue($row['monto_max']);
        $this->porcentaje->setDbValue($row['porcentaje']);
        $this->monto_fijo->setDbValue($row['monto_fijo']);
        $this->activo->setDbValue($row['activo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codimp'] = $this->codimp->DefaultValue;
        $row['secuencia'] = $this->secuencia->DefaultValue;
        $row['monto_min'] = $this->monto_min->DefaultValue;
        $row['monto_max'] = $this->monto_max->DefaultValue;
        $row['porcentaje'] = $this->porcentaje->DefaultValue;
        $row['monto_fijo'] = $this->monto_fijo->DefaultValue;
        $row['activo'] = $this->activo->DefaultValue;
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

        // codimp
        $this->codimp->RowCssClass = "row";

        // secuencia
        $this->secuencia->RowCssClass = "row";

        // monto_min
        $this->monto_min->RowCssClass = "row";

        // monto_max
        $this->monto_max->RowCssClass = "row";

        // porcentaje
        $this->porcentaje->RowCssClass = "row";

        // monto_fijo
        $this->monto_fijo->RowCssClass = "row";

        // activo
        $this->activo->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // codimp
            $curVal = strval($this->codimp->CurrentValue);
            if ($curVal != "") {
                $this->codimp->ViewValue = $this->codimp->lookupCacheOption($curVal);
                if ($this->codimp->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->codimp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codimp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->codimp->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->codimp->Lookup->renderViewRow($rswrk[0]);
                        $this->codimp->ViewValue = $this->codimp->displayValue($arwrk);
                    } else {
                        $this->codimp->ViewValue = FormatNumber($this->codimp->CurrentValue, $this->codimp->formatPattern());
                    }
                }
            } else {
                $this->codimp->ViewValue = null;
            }

            // secuencia
            $this->secuencia->ViewValue = $this->secuencia->CurrentValue;
            $this->secuencia->ViewValue = FormatNumber($this->secuencia->ViewValue, $this->secuencia->formatPattern());

            // monto_min
            $this->monto_min->ViewValue = $this->monto_min->CurrentValue;
            $this->monto_min->ViewValue = FormatNumber($this->monto_min->ViewValue, $this->monto_min->formatPattern());

            // monto_max
            $this->monto_max->ViewValue = $this->monto_max->CurrentValue;
            $this->monto_max->ViewValue = FormatNumber($this->monto_max->ViewValue, $this->monto_max->formatPattern());

            // porcentaje
            $this->porcentaje->ViewValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->ViewValue = FormatNumber($this->porcentaje->ViewValue, $this->porcentaje->formatPattern());

            // monto_fijo
            $this->monto_fijo->ViewValue = $this->monto_fijo->CurrentValue;
            $this->monto_fijo->ViewValue = FormatNumber($this->monto_fijo->ViewValue, $this->monto_fijo->formatPattern());

            // activo
            if (strval($this->activo->CurrentValue) != "") {
                $this->activo->ViewValue = $this->activo->optionCaption($this->activo->CurrentValue);
            } else {
                $this->activo->ViewValue = null;
            }

            // codimp
            $this->codimp->HrefValue = "";

            // secuencia
            $this->secuencia->HrefValue = "";

            // monto_min
            $this->monto_min->HrefValue = "";

            // monto_max
            $this->monto_max->HrefValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";

            // monto_fijo
            $this->monto_fijo->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // codimp
            $this->codimp->setupEditAttributes();
            $curVal = trim(strval($this->codimp->CurrentValue));
            if ($curVal != "") {
                $this->codimp->ViewValue = $this->codimp->lookupCacheOption($curVal);
            } else {
                $this->codimp->ViewValue = $this->codimp->Lookup !== null && is_array($this->codimp->lookupOptions()) && count($this->codimp->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->codimp->ViewValue !== null) { // Load from cache
                $this->codimp->EditValue = array_values($this->codimp->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->codimp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->codimp->CurrentValue, $this->codimp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->codimp->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->codimp->EditValue = $arwrk;
            }
            $this->codimp->PlaceHolder = RemoveHtml($this->codimp->caption());

            // secuencia
            $this->secuencia->setupEditAttributes();
            $this->secuencia->EditValue = $this->secuencia->CurrentValue;
            $this->secuencia->PlaceHolder = RemoveHtml($this->secuencia->caption());
            if (strval($this->secuencia->EditValue) != "" && is_numeric($this->secuencia->EditValue)) {
                $this->secuencia->EditValue = FormatNumber($this->secuencia->EditValue, null);
            }

            // monto_min
            $this->monto_min->setupEditAttributes();
            $this->monto_min->EditValue = $this->monto_min->CurrentValue;
            $this->monto_min->PlaceHolder = RemoveHtml($this->monto_min->caption());
            if (strval($this->monto_min->EditValue) != "" && is_numeric($this->monto_min->EditValue)) {
                $this->monto_min->EditValue = FormatNumber($this->monto_min->EditValue, null);
            }

            // monto_max
            $this->monto_max->setupEditAttributes();
            $this->monto_max->EditValue = $this->monto_max->CurrentValue;
            $this->monto_max->PlaceHolder = RemoveHtml($this->monto_max->caption());
            if (strval($this->monto_max->EditValue) != "" && is_numeric($this->monto_max->EditValue)) {
                $this->monto_max->EditValue = FormatNumber($this->monto_max->EditValue, null);
            }

            // porcentaje
            $this->porcentaje->setupEditAttributes();
            $this->porcentaje->EditValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->PlaceHolder = RemoveHtml($this->porcentaje->caption());
            if (strval($this->porcentaje->EditValue) != "" && is_numeric($this->porcentaje->EditValue)) {
                $this->porcentaje->EditValue = FormatNumber($this->porcentaje->EditValue, null);
            }

            // monto_fijo
            $this->monto_fijo->setupEditAttributes();
            $this->monto_fijo->EditValue = $this->monto_fijo->CurrentValue;
            $this->monto_fijo->PlaceHolder = RemoveHtml($this->monto_fijo->caption());
            if (strval($this->monto_fijo->EditValue) != "" && is_numeric($this->monto_fijo->EditValue)) {
                $this->monto_fijo->EditValue = FormatNumber($this->monto_fijo->EditValue, null);
            }

            // activo
            $this->activo->setupEditAttributes();
            $this->activo->EditValue = $this->activo->options(true);
            $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

            // Add refer script

            // codimp
            $this->codimp->HrefValue = "";

            // secuencia
            $this->secuencia->HrefValue = "";

            // monto_min
            $this->monto_min->HrefValue = "";

            // monto_max
            $this->monto_max->HrefValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";

            // monto_fijo
            $this->monto_fijo->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";
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
            if ($this->codimp->Visible && $this->codimp->Required) {
                if (!$this->codimp->IsDetailKey && EmptyValue($this->codimp->FormValue)) {
                    $this->codimp->addErrorMessage(str_replace("%s", $this->codimp->caption(), $this->codimp->RequiredErrorMessage));
                }
            }
            if ($this->secuencia->Visible && $this->secuencia->Required) {
                if (!$this->secuencia->IsDetailKey && EmptyValue($this->secuencia->FormValue)) {
                    $this->secuencia->addErrorMessage(str_replace("%s", $this->secuencia->caption(), $this->secuencia->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->secuencia->FormValue)) {
                $this->secuencia->addErrorMessage($this->secuencia->getErrorMessage(false));
            }
            if ($this->monto_min->Visible && $this->monto_min->Required) {
                if (!$this->monto_min->IsDetailKey && EmptyValue($this->monto_min->FormValue)) {
                    $this->monto_min->addErrorMessage(str_replace("%s", $this->monto_min->caption(), $this->monto_min->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->monto_min->FormValue)) {
                $this->monto_min->addErrorMessage($this->monto_min->getErrorMessage(false));
            }
            if ($this->monto_max->Visible && $this->monto_max->Required) {
                if (!$this->monto_max->IsDetailKey && EmptyValue($this->monto_max->FormValue)) {
                    $this->monto_max->addErrorMessage(str_replace("%s", $this->monto_max->caption(), $this->monto_max->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->monto_max->FormValue)) {
                $this->monto_max->addErrorMessage($this->monto_max->getErrorMessage(false));
            }
            if ($this->porcentaje->Visible && $this->porcentaje->Required) {
                if (!$this->porcentaje->IsDetailKey && EmptyValue($this->porcentaje->FormValue)) {
                    $this->porcentaje->addErrorMessage(str_replace("%s", $this->porcentaje->caption(), $this->porcentaje->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->porcentaje->FormValue)) {
                $this->porcentaje->addErrorMessage($this->porcentaje->getErrorMessage(false));
            }
            if ($this->monto_fijo->Visible && $this->monto_fijo->Required) {
                if (!$this->monto_fijo->IsDetailKey && EmptyValue($this->monto_fijo->FormValue)) {
                    $this->monto_fijo->addErrorMessage(str_replace("%s", $this->monto_fijo->caption(), $this->monto_fijo->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->monto_fijo->FormValue)) {
                $this->monto_fijo->addErrorMessage($this->monto_fijo->getErrorMessage(false));
            }
            if ($this->activo->Visible && $this->activo->Required) {
                if (!$this->activo->IsDetailKey && EmptyValue($this->activo->FormValue)) {
                    $this->activo->addErrorMessage(str_replace("%s", $this->activo->caption(), $this->activo->RequiredErrorMessage));
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

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['codimp']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['secuencia']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
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

        // codimp
        $this->codimp->setDbValueDef($rsnew, $this->codimp->CurrentValue, false);

        // secuencia
        $this->secuencia->setDbValueDef($rsnew, $this->secuencia->CurrentValue, false);

        // monto_min
        $this->monto_min->setDbValueDef($rsnew, $this->monto_min->CurrentValue, strval($this->monto_min->CurrentValue) == "");

        // monto_max
        $this->monto_max->setDbValueDef($rsnew, $this->monto_max->CurrentValue, strval($this->monto_max->CurrentValue) == "");

        // porcentaje
        $this->porcentaje->setDbValueDef($rsnew, $this->porcentaje->CurrentValue, false);

        // monto_fijo
        $this->monto_fijo->setDbValueDef($rsnew, $this->monto_fijo->CurrentValue, false);

        // activo
        $this->activo->setDbValueDef($rsnew, $this->activo->CurrentValue, strval($this->activo->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['codimp'])) { // codimp
            $this->codimp->setFormValue($row['codimp']);
        }
        if (isset($row['secuencia'])) { // secuencia
            $this->secuencia->setFormValue($row['secuencia']);
        }
        if (isset($row['monto_min'])) { // monto_min
            $this->monto_min->setFormValue($row['monto_min']);
        }
        if (isset($row['monto_max'])) { // monto_max
            $this->monto_max->setFormValue($row['monto_max']);
        }
        if (isset($row['porcentaje'])) { // porcentaje
            $this->porcentaje->setFormValue($row['porcentaje']);
        }
        if (isset($row['monto_fijo'])) { // monto_fijo
            $this->monto_fijo->setFormValue($row['monto_fijo']);
        }
        if (isset($row['activo'])) { // activo
            $this->activo->setFormValue($row['activo']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ImprangosList"), "", $this->TableVar, true);
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
                case "x_codimp":
                    break;
                case "x_activo":
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
