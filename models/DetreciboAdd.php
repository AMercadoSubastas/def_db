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
class DetreciboAdd extends Detrecibo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "DetreciboAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "DetreciboAdd";

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
        $this->tcomp->setVisibility();
        $this->serie->setVisibility();
        $this->ncomp->setVisibility();
        $this->nreng->setVisibility();
        $this->tcomprel->setVisibility();
        $this->serierel->setVisibility();
        $this->ncomprel->setVisibility();
        $this->netocbterel->setVisibility();
        $this->usuario->setVisibility();
        $this->fechahora->setVisibility();
        $this->nrodoc->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'detrecibo';
        $this->TableName = 'detrecibo';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (detrecibo)
        if (!isset($GLOBALS["detrecibo"]) || $GLOBALS["detrecibo"]::class == PROJECT_NAMESPACE . "detrecibo") {
            $GLOBALS["detrecibo"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'detrecibo');
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
                        $result["view"] = SameString($pageName, "DetreciboView"); // If View page, no primary button
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

        // Set up master/detail parameters
        // NOTE: Must be after loadOldRecord to prevent master key values being overwritten
        $this->setupMasterParms();

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
                    $this->terminate("DetreciboList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "DetreciboList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "DetreciboView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "DetreciboList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "DetreciboList"; // Return list page content
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
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'tcomp' first before field var 'x_tcomp'
        $val = $CurrentForm->hasValue("tcomp") ? $CurrentForm->getValue("tcomp") : $CurrentForm->getValue("x_tcomp");
        if (!$this->tcomp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tcomp->Visible = false; // Disable update for API request
            } else {
                $this->tcomp->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'serie' first before field var 'x_serie'
        $val = $CurrentForm->hasValue("serie") ? $CurrentForm->getValue("serie") : $CurrentForm->getValue("x_serie");
        if (!$this->serie->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->serie->Visible = false; // Disable update for API request
            } else {
                $this->serie->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ncomp' first before field var 'x_ncomp'
        $val = $CurrentForm->hasValue("ncomp") ? $CurrentForm->getValue("ncomp") : $CurrentForm->getValue("x_ncomp");
        if (!$this->ncomp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ncomp->Visible = false; // Disable update for API request
            } else {
                $this->ncomp->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'nreng' first before field var 'x_nreng'
        $val = $CurrentForm->hasValue("nreng") ? $CurrentForm->getValue("nreng") : $CurrentForm->getValue("x_nreng");
        if (!$this->nreng->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nreng->Visible = false; // Disable update for API request
            } else {
                $this->nreng->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'tcomprel' first before field var 'x_tcomprel'
        $val = $CurrentForm->hasValue("tcomprel") ? $CurrentForm->getValue("tcomprel") : $CurrentForm->getValue("x_tcomprel");
        if (!$this->tcomprel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tcomprel->Visible = false; // Disable update for API request
            } else {
                $this->tcomprel->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'serierel' first before field var 'x_serierel'
        $val = $CurrentForm->hasValue("serierel") ? $CurrentForm->getValue("serierel") : $CurrentForm->getValue("x_serierel");
        if (!$this->serierel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->serierel->Visible = false; // Disable update for API request
            } else {
                $this->serierel->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ncomprel' first before field var 'x_ncomprel'
        $val = $CurrentForm->hasValue("ncomprel") ? $CurrentForm->getValue("ncomprel") : $CurrentForm->getValue("x_ncomprel");
        if (!$this->ncomprel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ncomprel->Visible = false; // Disable update for API request
            } else {
                $this->ncomprel->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'netocbterel' first before field var 'x_netocbterel'
        $val = $CurrentForm->hasValue("netocbterel") ? $CurrentForm->getValue("netocbterel") : $CurrentForm->getValue("x_netocbterel");
        if (!$this->netocbterel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->netocbterel->Visible = false; // Disable update for API request
            } else {
                $this->netocbterel->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'usuario' first before field var 'x_usuario'
        $val = $CurrentForm->hasValue("usuario") ? $CurrentForm->getValue("usuario") : $CurrentForm->getValue("x_usuario");
        if (!$this->usuario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario->Visible = false; // Disable update for API request
            } else {
                $this->usuario->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fechahora' first before field var 'x_fechahora'
        $val = $CurrentForm->hasValue("fechahora") ? $CurrentForm->getValue("fechahora") : $CurrentForm->getValue("x_fechahora");
        if (!$this->fechahora->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechahora->Visible = false; // Disable update for API request
            } else {
                $this->fechahora->setFormValue($val, true, $validate);
            }
            $this->fechahora->CurrentValue = UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        }

        // Check field name 'nrodoc' first before field var 'x_nrodoc'
        $val = $CurrentForm->hasValue("nrodoc") ? $CurrentForm->getValue("nrodoc") : $CurrentForm->getValue("x_nrodoc");
        if (!$this->nrodoc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nrodoc->Visible = false; // Disable update for API request
            } else {
                $this->nrodoc->setFormValue($val);
            }
        }

        // Check field name 'codnum' first before field var 'x_codnum'
        $val = $CurrentForm->hasValue("codnum") ? $CurrentForm->getValue("codnum") : $CurrentForm->getValue("x_codnum");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->tcomp->CurrentValue = $this->tcomp->FormValue;
        $this->serie->CurrentValue = $this->serie->FormValue;
        $this->ncomp->CurrentValue = $this->ncomp->FormValue;
        $this->nreng->CurrentValue = $this->nreng->FormValue;
        $this->tcomprel->CurrentValue = $this->tcomprel->FormValue;
        $this->serierel->CurrentValue = $this->serierel->FormValue;
        $this->ncomprel->CurrentValue = $this->ncomprel->FormValue;
        $this->netocbterel->CurrentValue = $this->netocbterel->FormValue;
        $this->usuario->CurrentValue = $this->usuario->FormValue;
        $this->fechahora->CurrentValue = $this->fechahora->FormValue;
        $this->fechahora->CurrentValue = UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        $this->nrodoc->CurrentValue = $this->nrodoc->FormValue;
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
        $this->nreng->setDbValue($row['nreng']);
        $this->tcomprel->setDbValue($row['tcomprel']);
        $this->serierel->setDbValue($row['serierel']);
        $this->ncomprel->setDbValue($row['ncomprel']);
        $this->netocbterel->setDbValue($row['netocbterel']);
        $this->usuario->setDbValue($row['usuario']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->nrodoc->setDbValue($row['nrodoc']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['tcomp'] = $this->tcomp->DefaultValue;
        $row['serie'] = $this->serie->DefaultValue;
        $row['ncomp'] = $this->ncomp->DefaultValue;
        $row['nreng'] = $this->nreng->DefaultValue;
        $row['tcomprel'] = $this->tcomprel->DefaultValue;
        $row['serierel'] = $this->serierel->DefaultValue;
        $row['ncomprel'] = $this->ncomprel->DefaultValue;
        $row['netocbterel'] = $this->netocbterel->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['fechahora'] = $this->fechahora->DefaultValue;
        $row['nrodoc'] = $this->nrodoc->DefaultValue;
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

        // tcomp
        $this->tcomp->RowCssClass = "row";

        // serie
        $this->serie->RowCssClass = "row";

        // ncomp
        $this->ncomp->RowCssClass = "row";

        // nreng
        $this->nreng->RowCssClass = "row";

        // tcomprel
        $this->tcomprel->RowCssClass = "row";

        // serierel
        $this->serierel->RowCssClass = "row";

        // ncomprel
        $this->ncomprel->RowCssClass = "row";

        // netocbterel
        $this->netocbterel->RowCssClass = "row";

        // usuario
        $this->usuario->RowCssClass = "row";

        // fechahora
        $this->fechahora->RowCssClass = "row";

        // nrodoc
        $this->nrodoc->RowCssClass = "row";

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

            // nreng
            $this->nreng->ViewValue = $this->nreng->CurrentValue;
            $this->nreng->ViewValue = FormatNumber($this->nreng->ViewValue, $this->nreng->formatPattern());

            // tcomprel
            $this->tcomprel->ViewValue = $this->tcomprel->CurrentValue;
            $this->tcomprel->ViewValue = FormatNumber($this->tcomprel->ViewValue, $this->tcomprel->formatPattern());

            // serierel
            $this->serierel->ViewValue = $this->serierel->CurrentValue;
            $this->serierel->ViewValue = FormatNumber($this->serierel->ViewValue, $this->serierel->formatPattern());

            // ncomprel
            $this->ncomprel->ViewValue = $this->ncomprel->CurrentValue;
            $this->ncomprel->ViewValue = FormatNumber($this->ncomprel->ViewValue, $this->ncomprel->formatPattern());

            // netocbterel
            $this->netocbterel->ViewValue = $this->netocbterel->CurrentValue;
            $this->netocbterel->ViewValue = FormatNumber($this->netocbterel->ViewValue, $this->netocbterel->formatPattern());

            // usuario
            $this->usuario->ViewValue = $this->usuario->CurrentValue;
            $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

            // fechahora
            $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
            $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

            // nrodoc
            $this->nrodoc->ViewValue = $this->nrodoc->CurrentValue;

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";

            // nreng
            $this->nreng->HrefValue = "";

            // tcomprel
            $this->tcomprel->HrefValue = "";

            // serierel
            $this->serierel->HrefValue = "";

            // ncomprel
            $this->ncomprel->HrefValue = "";

            // netocbterel
            $this->netocbterel->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // nrodoc
            $this->nrodoc->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
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

            // tcomprel
            $this->tcomprel->setupEditAttributes();
            $this->tcomprel->EditValue = $this->tcomprel->CurrentValue;
            $this->tcomprel->PlaceHolder = RemoveHtml($this->tcomprel->caption());
            if (strval($this->tcomprel->EditValue) != "" && is_numeric($this->tcomprel->EditValue)) {
                $this->tcomprel->EditValue = FormatNumber($this->tcomprel->EditValue, null);
            }

            // serierel
            $this->serierel->setupEditAttributes();
            $this->serierel->EditValue = $this->serierel->CurrentValue;
            $this->serierel->PlaceHolder = RemoveHtml($this->serierel->caption());
            if (strval($this->serierel->EditValue) != "" && is_numeric($this->serierel->EditValue)) {
                $this->serierel->EditValue = FormatNumber($this->serierel->EditValue, null);
            }

            // ncomprel
            $this->ncomprel->setupEditAttributes();
            $this->ncomprel->EditValue = $this->ncomprel->CurrentValue;
            $this->ncomprel->PlaceHolder = RemoveHtml($this->ncomprel->caption());
            if (strval($this->ncomprel->EditValue) != "" && is_numeric($this->ncomprel->EditValue)) {
                $this->ncomprel->EditValue = FormatNumber($this->ncomprel->EditValue, null);
            }

            // netocbterel
            $this->netocbterel->setupEditAttributes();
            $this->netocbterel->EditValue = $this->netocbterel->CurrentValue;
            $this->netocbterel->PlaceHolder = RemoveHtml($this->netocbterel->caption());
            if (strval($this->netocbterel->EditValue) != "" && is_numeric($this->netocbterel->EditValue)) {
                $this->netocbterel->EditValue = FormatNumber($this->netocbterel->EditValue, null);
            }

            // usuario
            $this->usuario->setupEditAttributes();
            $this->usuario->EditValue = $this->usuario->CurrentValue;
            $this->usuario->PlaceHolder = RemoveHtml($this->usuario->caption());
            if (strval($this->usuario->EditValue) != "" && is_numeric($this->usuario->EditValue)) {
                $this->usuario->EditValue = FormatNumber($this->usuario->EditValue, null);
            }

            // fechahora
            $this->fechahora->setupEditAttributes();
            $this->fechahora->EditValue = HtmlEncode(FormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()));
            $this->fechahora->PlaceHolder = RemoveHtml($this->fechahora->caption());

            // nrodoc
            $this->nrodoc->setupEditAttributes();
            if (!$this->nrodoc->Raw) {
                $this->nrodoc->CurrentValue = HtmlDecode($this->nrodoc->CurrentValue);
            }
            $this->nrodoc->EditValue = HtmlEncode($this->nrodoc->CurrentValue);
            $this->nrodoc->PlaceHolder = RemoveHtml($this->nrodoc->caption());

            // Add refer script

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";

            // nreng
            $this->nreng->HrefValue = "";

            // tcomprel
            $this->tcomprel->HrefValue = "";

            // serierel
            $this->serierel->HrefValue = "";

            // ncomprel
            $this->ncomprel->HrefValue = "";

            // netocbterel
            $this->netocbterel->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // nrodoc
            $this->nrodoc->HrefValue = "";
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
            if ($this->tcomp->Visible && $this->tcomp->Required) {
                if (!$this->tcomp->IsDetailKey && EmptyValue($this->tcomp->FormValue)) {
                    $this->tcomp->addErrorMessage(str_replace("%s", $this->tcomp->caption(), $this->tcomp->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->tcomp->FormValue)) {
                $this->tcomp->addErrorMessage($this->tcomp->getErrorMessage(false));
            }
            if ($this->serie->Visible && $this->serie->Required) {
                if (!$this->serie->IsDetailKey && EmptyValue($this->serie->FormValue)) {
                    $this->serie->addErrorMessage(str_replace("%s", $this->serie->caption(), $this->serie->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->serie->FormValue)) {
                $this->serie->addErrorMessage($this->serie->getErrorMessage(false));
            }
            if ($this->ncomp->Visible && $this->ncomp->Required) {
                if (!$this->ncomp->IsDetailKey && EmptyValue($this->ncomp->FormValue)) {
                    $this->ncomp->addErrorMessage(str_replace("%s", $this->ncomp->caption(), $this->ncomp->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->ncomp->FormValue)) {
                $this->ncomp->addErrorMessage($this->ncomp->getErrorMessage(false));
            }
            if ($this->nreng->Visible && $this->nreng->Required) {
                if (!$this->nreng->IsDetailKey && EmptyValue($this->nreng->FormValue)) {
                    $this->nreng->addErrorMessage(str_replace("%s", $this->nreng->caption(), $this->nreng->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->nreng->FormValue)) {
                $this->nreng->addErrorMessage($this->nreng->getErrorMessage(false));
            }
            if ($this->tcomprel->Visible && $this->tcomprel->Required) {
                if (!$this->tcomprel->IsDetailKey && EmptyValue($this->tcomprel->FormValue)) {
                    $this->tcomprel->addErrorMessage(str_replace("%s", $this->tcomprel->caption(), $this->tcomprel->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->tcomprel->FormValue)) {
                $this->tcomprel->addErrorMessage($this->tcomprel->getErrorMessage(false));
            }
            if ($this->serierel->Visible && $this->serierel->Required) {
                if (!$this->serierel->IsDetailKey && EmptyValue($this->serierel->FormValue)) {
                    $this->serierel->addErrorMessage(str_replace("%s", $this->serierel->caption(), $this->serierel->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->serierel->FormValue)) {
                $this->serierel->addErrorMessage($this->serierel->getErrorMessage(false));
            }
            if ($this->ncomprel->Visible && $this->ncomprel->Required) {
                if (!$this->ncomprel->IsDetailKey && EmptyValue($this->ncomprel->FormValue)) {
                    $this->ncomprel->addErrorMessage(str_replace("%s", $this->ncomprel->caption(), $this->ncomprel->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->ncomprel->FormValue)) {
                $this->ncomprel->addErrorMessage($this->ncomprel->getErrorMessage(false));
            }
            if ($this->netocbterel->Visible && $this->netocbterel->Required) {
                if (!$this->netocbterel->IsDetailKey && EmptyValue($this->netocbterel->FormValue)) {
                    $this->netocbterel->addErrorMessage(str_replace("%s", $this->netocbterel->caption(), $this->netocbterel->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->netocbterel->FormValue)) {
                $this->netocbterel->addErrorMessage($this->netocbterel->getErrorMessage(false));
            }
            if ($this->usuario->Visible && $this->usuario->Required) {
                if (!$this->usuario->IsDetailKey && EmptyValue($this->usuario->FormValue)) {
                    $this->usuario->addErrorMessage(str_replace("%s", $this->usuario->caption(), $this->usuario->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->usuario->FormValue)) {
                $this->usuario->addErrorMessage($this->usuario->getErrorMessage(false));
            }
            if ($this->fechahora->Visible && $this->fechahora->Required) {
                if (!$this->fechahora->IsDetailKey && EmptyValue($this->fechahora->FormValue)) {
                    $this->fechahora->addErrorMessage(str_replace("%s", $this->fechahora->caption(), $this->fechahora->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fechahora->FormValue, $this->fechahora->formatPattern())) {
                $this->fechahora->addErrorMessage($this->fechahora->getErrorMessage(false));
            }
            if ($this->nrodoc->Visible && $this->nrodoc->Required) {
                if (!$this->nrodoc->IsDetailKey && EmptyValue($this->nrodoc->FormValue)) {
                    $this->nrodoc->addErrorMessage(str_replace("%s", $this->nrodoc->caption(), $this->nrodoc->RequiredErrorMessage));
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

        // Check referential integrity for master table 'detrecibo'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["tcomp"] = $this->tcomp->CurrentValue;
        $detailKeys["serie"] = $this->serie->CurrentValue;
        $detailKeys["ncomp"] = $this->ncomp->CurrentValue;
        $masterTable = Container("cabrecibo");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "cabrecibo", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
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

        // tcomp
        $this->tcomp->setDbValueDef($rsnew, $this->tcomp->CurrentValue, false);

        // serie
        $this->serie->setDbValueDef($rsnew, $this->serie->CurrentValue, false);

        // ncomp
        $this->ncomp->setDbValueDef($rsnew, $this->ncomp->CurrentValue, false);

        // nreng
        $this->nreng->setDbValueDef($rsnew, $this->nreng->CurrentValue, false);

        // tcomprel
        $this->tcomprel->setDbValueDef($rsnew, $this->tcomprel->CurrentValue, false);

        // serierel
        $this->serierel->setDbValueDef($rsnew, $this->serierel->CurrentValue, false);

        // ncomprel
        $this->ncomprel->setDbValueDef($rsnew, $this->ncomprel->CurrentValue, false);

        // netocbterel
        $this->netocbterel->setDbValueDef($rsnew, $this->netocbterel->CurrentValue, false);

        // usuario
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue, false);

        // fechahora
        $this->fechahora->setDbValueDef($rsnew, UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()), false);

        // nrodoc
        $this->nrodoc->setDbValueDef($rsnew, $this->nrodoc->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['tcomp'])) { // tcomp
            $this->tcomp->setFormValue($row['tcomp']);
        }
        if (isset($row['serie'])) { // serie
            $this->serie->setFormValue($row['serie']);
        }
        if (isset($row['ncomp'])) { // ncomp
            $this->ncomp->setFormValue($row['ncomp']);
        }
        if (isset($row['nreng'])) { // nreng
            $this->nreng->setFormValue($row['nreng']);
        }
        if (isset($row['tcomprel'])) { // tcomprel
            $this->tcomprel->setFormValue($row['tcomprel']);
        }
        if (isset($row['serierel'])) { // serierel
            $this->serierel->setFormValue($row['serierel']);
        }
        if (isset($row['ncomprel'])) { // ncomprel
            $this->ncomprel->setFormValue($row['ncomprel']);
        }
        if (isset($row['netocbterel'])) { // netocbterel
            $this->netocbterel->setFormValue($row['netocbterel']);
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->setFormValue($row['usuario']);
        }
        if (isset($row['fechahora'])) { // fechahora
            $this->fechahora->setFormValue($row['fechahora']);
        }
        if (isset($row['nrodoc'])) { // nrodoc
            $this->nrodoc->setFormValue($row['nrodoc']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        $foreignKeys = [];
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "cabrecibo") {
                $validMaster = true;
                $masterTbl = Container("cabrecibo");
                if (($parm = Get("fk_tcomp", Get("tcomp"))) !== null) {
                    $masterTbl->tcomp->setQueryStringValue($parm);
                    $this->tcomp->QueryStringValue = $masterTbl->tcomp->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->tcomp->setSessionValue($this->tcomp->QueryStringValue);
                    $foreignKeys["tcomp"] = $this->tcomp->QueryStringValue;
                    if (!is_numeric($masterTbl->tcomp->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_serie", Get("serie"))) !== null) {
                    $masterTbl->serie->setQueryStringValue($parm);
                    $this->serie->QueryStringValue = $masterTbl->serie->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->serie->setSessionValue($this->serie->QueryStringValue);
                    $foreignKeys["serie"] = $this->serie->QueryStringValue;
                    if (!is_numeric($masterTbl->serie->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_ncomp", Get("ncomp"))) !== null) {
                    $masterTbl->ncomp->setQueryStringValue($parm);
                    $this->ncomp->QueryStringValue = $masterTbl->ncomp->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->ncomp->setSessionValue($this->ncomp->QueryStringValue);
                    $foreignKeys["ncomp"] = $this->ncomp->QueryStringValue;
                    if (!is_numeric($masterTbl->ncomp->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "cabrecibo") {
                $validMaster = true;
                $masterTbl = Container("cabrecibo");
                if (($parm = Post("fk_tcomp", Post("tcomp"))) !== null) {
                    $masterTbl->tcomp->setFormValue($parm);
                    $this->tcomp->FormValue = $masterTbl->tcomp->FormValue;
                    $this->tcomp->setSessionValue($this->tcomp->FormValue);
                    $foreignKeys["tcomp"] = $this->tcomp->FormValue;
                    if (!is_numeric($masterTbl->tcomp->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_serie", Post("serie"))) !== null) {
                    $masterTbl->serie->setFormValue($parm);
                    $this->serie->FormValue = $masterTbl->serie->FormValue;
                    $this->serie->setSessionValue($this->serie->FormValue);
                    $foreignKeys["serie"] = $this->serie->FormValue;
                    if (!is_numeric($masterTbl->serie->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_ncomp", Post("ncomp"))) !== null) {
                    $masterTbl->ncomp->setFormValue($parm);
                    $this->ncomp->FormValue = $masterTbl->ncomp->FormValue;
                    $this->ncomp->setSessionValue($this->ncomp->FormValue);
                    $foreignKeys["ncomp"] = $this->ncomp->FormValue;
                    if (!is_numeric($masterTbl->ncomp->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "cabrecibo") {
                if (!array_key_exists("tcomp", $foreignKeys)) { // Not current foreign key
                    $this->tcomp->setSessionValue("");
                }
                if (!array_key_exists("serie", $foreignKeys)) { // Not current foreign key
                    $this->serie->setSessionValue("");
                }
                if (!array_key_exists("ncomp", $foreignKeys)) { // Not current foreign key
                    $this->ncomp->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("DetreciboList"), "", $this->TableVar, true);
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
