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
class EntidadesAdd extends Entidades
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "EntidadesAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "EntidadesAdd";

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
        $this->usuario->Visible = false;
        $this->contacto->setVisibility();
        $this->mailcont->setVisibility();
        $this->cargo->setVisibility();
        $this->fechahora->setVisibility();
        $this->activo->Visible = false;
        $this->pagweb->setVisibility();
        $this->tipoind->setVisibility();
        $this->usuarioultmod->Visible = false;
        $this->fecultmod->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'entidades';
        $this->TableName = 'entidades';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

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
                        $result["view"] = SameString($pageName, "EntidadesView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->codpais);
        $this->setupLookupOptions($this->codprov);
        $this->setupLookupOptions($this->codloc);
        $this->setupLookupOptions($this->tipoent);
        $this->setupLookupOptions($this->tipoiva);
        $this->setupLookupOptions($this->cuit);
        $this->setupLookupOptions($this->calif);
        $this->setupLookupOptions($this->activo);
        $this->setupLookupOptions($this->tipoind);

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
                    $this->terminate("EntidadesList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "EntidadesList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "EntidadesView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "EntidadesList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "EntidadesList"; // Return list page content
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
        $this->tipoiva->DefaultValue = $this->tipoiva->getDefault(); // PHP
        $this->tipoiva->OldValue = $this->tipoiva->DefaultValue;
        $this->activo->DefaultValue = $this->activo->getDefault(); // PHP
        $this->activo->OldValue = $this->activo->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'razsoc' first before field var 'x_razsoc'
        $val = $CurrentForm->hasValue("razsoc") ? $CurrentForm->getValue("razsoc") : $CurrentForm->getValue("x_razsoc");
        if (!$this->razsoc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->razsoc->Visible = false; // Disable update for API request
            } else {
                $this->razsoc->setFormValue($val);
            }
        }

        // Check field name 'calle' first before field var 'x_calle'
        $val = $CurrentForm->hasValue("calle") ? $CurrentForm->getValue("calle") : $CurrentForm->getValue("x_calle");
        if (!$this->calle->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->calle->Visible = false; // Disable update for API request
            } else {
                $this->calle->setFormValue($val);
            }
        }

        // Check field name 'numero' first before field var 'x_numero'
        $val = $CurrentForm->hasValue("numero") ? $CurrentForm->getValue("numero") : $CurrentForm->getValue("x_numero");
        if (!$this->numero->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->numero->Visible = false; // Disable update for API request
            } else {
                $this->numero->setFormValue($val);
            }
        }

        // Check field name 'pisodto' first before field var 'x_pisodto'
        $val = $CurrentForm->hasValue("pisodto") ? $CurrentForm->getValue("pisodto") : $CurrentForm->getValue("x_pisodto");
        if (!$this->pisodto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pisodto->Visible = false; // Disable update for API request
            } else {
                $this->pisodto->setFormValue($val);
            }
        }

        // Check field name 'codpais' first before field var 'x_codpais'
        $val = $CurrentForm->hasValue("codpais") ? $CurrentForm->getValue("codpais") : $CurrentForm->getValue("x_codpais");
        if (!$this->codpais->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codpais->Visible = false; // Disable update for API request
            } else {
                $this->codpais->setFormValue($val);
            }
        }

        // Check field name 'codprov' first before field var 'x_codprov'
        $val = $CurrentForm->hasValue("codprov") ? $CurrentForm->getValue("codprov") : $CurrentForm->getValue("x_codprov");
        if (!$this->codprov->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codprov->Visible = false; // Disable update for API request
            } else {
                $this->codprov->setFormValue($val);
            }
        }

        // Check field name 'codloc' first before field var 'x_codloc'
        $val = $CurrentForm->hasValue("codloc") ? $CurrentForm->getValue("codloc") : $CurrentForm->getValue("x_codloc");
        if (!$this->codloc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codloc->Visible = false; // Disable update for API request
            } else {
                $this->codloc->setFormValue($val);
            }
        }

        // Check field name 'codpost' first before field var 'x_codpost'
        $val = $CurrentForm->hasValue("codpost") ? $CurrentForm->getValue("codpost") : $CurrentForm->getValue("x_codpost");
        if (!$this->codpost->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codpost->Visible = false; // Disable update for API request
            } else {
                $this->codpost->setFormValue($val);
            }
        }

        // Check field name 'tellinea' first before field var 'x_tellinea'
        $val = $CurrentForm->hasValue("tellinea") ? $CurrentForm->getValue("tellinea") : $CurrentForm->getValue("x_tellinea");
        if (!$this->tellinea->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tellinea->Visible = false; // Disable update for API request
            } else {
                $this->tellinea->setFormValue($val);
            }
        }

        // Check field name 'telcelu' first before field var 'x_telcelu'
        $val = $CurrentForm->hasValue("telcelu") ? $CurrentForm->getValue("telcelu") : $CurrentForm->getValue("x_telcelu");
        if (!$this->telcelu->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telcelu->Visible = false; // Disable update for API request
            } else {
                $this->telcelu->setFormValue($val);
            }
        }

        // Check field name 'tipoent' first before field var 'x_tipoent'
        $val = $CurrentForm->hasValue("tipoent") ? $CurrentForm->getValue("tipoent") : $CurrentForm->getValue("x_tipoent");
        if (!$this->tipoent->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipoent->Visible = false; // Disable update for API request
            } else {
                $this->tipoent->setFormValue($val);
            }
        }

        // Check field name 'tipoiva' first before field var 'x_tipoiva'
        $val = $CurrentForm->hasValue("tipoiva") ? $CurrentForm->getValue("tipoiva") : $CurrentForm->getValue("x_tipoiva");
        if (!$this->tipoiva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipoiva->Visible = false; // Disable update for API request
            } else {
                $this->tipoiva->setFormValue($val);
            }
        }

        // Check field name 'cuit' first before field var 'x_cuit'
        $val = $CurrentForm->hasValue("cuit") ? $CurrentForm->getValue("cuit") : $CurrentForm->getValue("x_cuit");
        if (!$this->cuit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cuit->Visible = false; // Disable update for API request
            } else {
                $this->cuit->setFormValue($val);
            }
        }

        // Check field name 'calif' first before field var 'x_calif'
        $val = $CurrentForm->hasValue("calif") ? $CurrentForm->getValue("calif") : $CurrentForm->getValue("x_calif");
        if (!$this->calif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->calif->Visible = false; // Disable update for API request
            } else {
                $this->calif->setFormValue($val);
            }
        }

        // Check field name 'fecalta' first before field var 'x_fecalta'
        $val = $CurrentForm->hasValue("fecalta") ? $CurrentForm->getValue("fecalta") : $CurrentForm->getValue("x_fecalta");
        if (!$this->fecalta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecalta->Visible = false; // Disable update for API request
            } else {
                $this->fecalta->setFormValue($val, true, $validate);
            }
            $this->fecalta->CurrentValue = UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern());
        }

        // Check field name 'contacto' first before field var 'x_contacto'
        $val = $CurrentForm->hasValue("contacto") ? $CurrentForm->getValue("contacto") : $CurrentForm->getValue("x_contacto");
        if (!$this->contacto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contacto->Visible = false; // Disable update for API request
            } else {
                $this->contacto->setFormValue($val);
            }
        }

        // Check field name 'mailcont' first before field var 'x_mailcont'
        $val = $CurrentForm->hasValue("mailcont") ? $CurrentForm->getValue("mailcont") : $CurrentForm->getValue("x_mailcont");
        if (!$this->mailcont->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mailcont->Visible = false; // Disable update for API request
            } else {
                $this->mailcont->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'cargo' first before field var 'x_cargo'
        $val = $CurrentForm->hasValue("cargo") ? $CurrentForm->getValue("cargo") : $CurrentForm->getValue("x_cargo");
        if (!$this->cargo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cargo->Visible = false; // Disable update for API request
            } else {
                $this->cargo->setFormValue($val);
            }
        }

        // Check field name 'fechahora' first before field var 'x_fechahora'
        $val = $CurrentForm->hasValue("fechahora") ? $CurrentForm->getValue("fechahora") : $CurrentForm->getValue("x_fechahora");
        if (!$this->fechahora->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechahora->Visible = false; // Disable update for API request
            } else {
                $this->fechahora->setFormValue($val);
            }
            $this->fechahora->CurrentValue = UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        }

        // Check field name 'pagweb' first before field var 'x_pagweb'
        $val = $CurrentForm->hasValue("pagweb") ? $CurrentForm->getValue("pagweb") : $CurrentForm->getValue("x_pagweb");
        if (!$this->pagweb->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pagweb->Visible = false; // Disable update for API request
            } else {
                $this->pagweb->setFormValue($val);
            }
        }

        // Check field name 'tipoind' first before field var 'x_tipoind'
        $val = $CurrentForm->hasValue("tipoind") ? $CurrentForm->getValue("tipoind") : $CurrentForm->getValue("x_tipoind");
        if (!$this->tipoind->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipoind->Visible = false; // Disable update for API request
            } else {
                $this->tipoind->setFormValue($val);
            }
        }

        // Check field name 'codnum' first before field var 'x_codnum'
        $val = $CurrentForm->hasValue("codnum") ? $CurrentForm->getValue("codnum") : $CurrentForm->getValue("x_codnum");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->razsoc->CurrentValue = $this->razsoc->FormValue;
        $this->calle->CurrentValue = $this->calle->FormValue;
        $this->numero->CurrentValue = $this->numero->FormValue;
        $this->pisodto->CurrentValue = $this->pisodto->FormValue;
        $this->codpais->CurrentValue = $this->codpais->FormValue;
        $this->codprov->CurrentValue = $this->codprov->FormValue;
        $this->codloc->CurrentValue = $this->codloc->FormValue;
        $this->codpost->CurrentValue = $this->codpost->FormValue;
        $this->tellinea->CurrentValue = $this->tellinea->FormValue;
        $this->telcelu->CurrentValue = $this->telcelu->FormValue;
        $this->tipoent->CurrentValue = $this->tipoent->FormValue;
        $this->tipoiva->CurrentValue = $this->tipoiva->FormValue;
        $this->cuit->CurrentValue = $this->cuit->FormValue;
        $this->calif->CurrentValue = $this->calif->FormValue;
        $this->fecalta->CurrentValue = $this->fecalta->FormValue;
        $this->fecalta->CurrentValue = UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern());
        $this->contacto->CurrentValue = $this->contacto->FormValue;
        $this->mailcont->CurrentValue = $this->mailcont->FormValue;
        $this->cargo->CurrentValue = $this->cargo->FormValue;
        $this->fechahora->CurrentValue = $this->fechahora->FormValue;
        $this->fechahora->CurrentValue = UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        $this->pagweb->CurrentValue = $this->pagweb->FormValue;
        $this->tipoind->CurrentValue = $this->tipoind->FormValue;
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

        // razsoc
        $this->razsoc->RowCssClass = "row";

        // calle
        $this->calle->RowCssClass = "row";

        // numero
        $this->numero->RowCssClass = "row";

        // pisodto
        $this->pisodto->RowCssClass = "row";

        // codpais
        $this->codpais->RowCssClass = "row";

        // codprov
        $this->codprov->RowCssClass = "row";

        // codloc
        $this->codloc->RowCssClass = "row";

        // codpost
        $this->codpost->RowCssClass = "row";

        // tellinea
        $this->tellinea->RowCssClass = "row";

        // telcelu
        $this->telcelu->RowCssClass = "row";

        // tipoent
        $this->tipoent->RowCssClass = "row";

        // tipoiva
        $this->tipoiva->RowCssClass = "row";

        // cuit
        $this->cuit->RowCssClass = "row";

        // calif
        $this->calif->RowCssClass = "row";

        // fecalta
        $this->fecalta->RowCssClass = "row";

        // usuario
        $this->usuario->RowCssClass = "row";

        // contacto
        $this->contacto->RowCssClass = "row";

        // mailcont
        $this->mailcont->RowCssClass = "row";

        // cargo
        $this->cargo->RowCssClass = "row";

        // fechahora
        $this->fechahora->RowCssClass = "row";

        // activo
        $this->activo->RowCssClass = "row";

        // pagweb
        $this->pagweb->RowCssClass = "row";

        // tipoind
        $this->tipoind->RowCssClass = "row";

        // usuarioultmod
        $this->usuarioultmod->RowCssClass = "row";

        // fecultmod
        $this->fecultmod->RowCssClass = "row";

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

            // razsoc
            $this->razsoc->HrefValue = "";

            // calle
            $this->calle->HrefValue = "";

            // numero
            $this->numero->HrefValue = "";

            // pisodto
            $this->pisodto->HrefValue = "";

            // codpais
            $this->codpais->HrefValue = "";

            // codprov
            $this->codprov->HrefValue = "";

            // codloc
            $this->codloc->HrefValue = "";

            // codpost
            $this->codpost->HrefValue = "";

            // tellinea
            $this->tellinea->HrefValue = "";

            // telcelu
            $this->telcelu->HrefValue = "";

            // tipoent
            $this->tipoent->HrefValue = "";

            // tipoiva
            $this->tipoiva->HrefValue = "";

            // cuit
            $this->cuit->HrefValue = "";

            // calif
            $this->calif->HrefValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";

            // contacto
            $this->contacto->HrefValue = "";

            // mailcont
            $this->mailcont->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // pagweb
            $this->pagweb->HrefValue = "";

            // tipoind
            $this->tipoind->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // razsoc
            $this->razsoc->setupEditAttributes();
            if (!$this->razsoc->Raw) {
                $this->razsoc->CurrentValue = HtmlDecode($this->razsoc->CurrentValue);
            }
            $this->razsoc->EditValue = HtmlEncode($this->razsoc->CurrentValue);
            $this->razsoc->PlaceHolder = RemoveHtml($this->razsoc->caption());

            // calle
            $this->calle->setupEditAttributes();
            if (!$this->calle->Raw) {
                $this->calle->CurrentValue = HtmlDecode($this->calle->CurrentValue);
            }
            $this->calle->EditValue = HtmlEncode($this->calle->CurrentValue);
            $this->calle->PlaceHolder = RemoveHtml($this->calle->caption());

            // numero
            $this->numero->setupEditAttributes();
            if (!$this->numero->Raw) {
                $this->numero->CurrentValue = HtmlDecode($this->numero->CurrentValue);
            }
            $this->numero->EditValue = HtmlEncode($this->numero->CurrentValue);
            $this->numero->PlaceHolder = RemoveHtml($this->numero->caption());

            // pisodto
            $this->pisodto->setupEditAttributes();
            if (!$this->pisodto->Raw) {
                $this->pisodto->CurrentValue = HtmlDecode($this->pisodto->CurrentValue);
            }
            $this->pisodto->EditValue = HtmlEncode($this->pisodto->CurrentValue);
            $this->pisodto->PlaceHolder = RemoveHtml($this->pisodto->caption());

            // codpais
            $this->codpais->setupEditAttributes();
            $curVal = trim(strval($this->codpais->CurrentValue));
            if ($curVal != "") {
                $this->codpais->ViewValue = $this->codpais->lookupCacheOption($curVal);
            } else {
                $this->codpais->ViewValue = $this->codpais->Lookup !== null && is_array($this->codpais->lookupOptions()) && count($this->codpais->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->codpais->ViewValue !== null) { // Load from cache
                $this->codpais->EditValue = array_values($this->codpais->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->codpais->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->codpais->CurrentValue, $this->codpais->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->codpais->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->codpais->EditValue = $arwrk;
            }
            $this->codpais->PlaceHolder = RemoveHtml($this->codpais->caption());

            // codprov
            $this->codprov->setupEditAttributes();
            $curVal = trim(strval($this->codprov->CurrentValue));
            if ($curVal != "") {
                $this->codprov->ViewValue = $this->codprov->lookupCacheOption($curVal);
            } else {
                $this->codprov->ViewValue = $this->codprov->Lookup !== null && is_array($this->codprov->lookupOptions()) && count($this->codprov->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->codprov->ViewValue !== null) { // Load from cache
                $this->codprov->EditValue = array_values($this->codprov->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->codprov->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->codprov->CurrentValue, $this->codprov->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->codprov->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->codprov->EditValue = $arwrk;
            }
            $this->codprov->PlaceHolder = RemoveHtml($this->codprov->caption());

            // codloc
            $this->codloc->setupEditAttributes();
            $curVal = trim(strval($this->codloc->CurrentValue));
            if ($curVal != "") {
                $this->codloc->ViewValue = $this->codloc->lookupCacheOption($curVal);
            } else {
                $this->codloc->ViewValue = $this->codloc->Lookup !== null && is_array($this->codloc->lookupOptions()) && count($this->codloc->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->codloc->ViewValue !== null) { // Load from cache
                $this->codloc->EditValue = array_values($this->codloc->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->codloc->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->codloc->CurrentValue, $this->codloc->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->codloc->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->codloc->EditValue = $arwrk;
            }
            $this->codloc->PlaceHolder = RemoveHtml($this->codloc->caption());

            // codpost
            $this->codpost->setupEditAttributes();
            if (!$this->codpost->Raw) {
                $this->codpost->CurrentValue = HtmlDecode($this->codpost->CurrentValue);
            }
            $this->codpost->EditValue = HtmlEncode($this->codpost->CurrentValue);
            $this->codpost->PlaceHolder = RemoveHtml($this->codpost->caption());

            // tellinea
            $this->tellinea->setupEditAttributes();
            if (!$this->tellinea->Raw) {
                $this->tellinea->CurrentValue = HtmlDecode($this->tellinea->CurrentValue);
            }
            $this->tellinea->EditValue = HtmlEncode($this->tellinea->CurrentValue);
            $this->tellinea->PlaceHolder = RemoveHtml($this->tellinea->caption());

            // telcelu
            $this->telcelu->setupEditAttributes();
            if (!$this->telcelu->Raw) {
                $this->telcelu->CurrentValue = HtmlDecode($this->telcelu->CurrentValue);
            }
            $this->telcelu->EditValue = HtmlEncode($this->telcelu->CurrentValue);
            $this->telcelu->PlaceHolder = RemoveHtml($this->telcelu->caption());

            // tipoent
            $this->tipoent->setupEditAttributes();
            $curVal = trim(strval($this->tipoent->CurrentValue));
            if ($curVal != "") {
                $this->tipoent->ViewValue = $this->tipoent->lookupCacheOption($curVal);
            } else {
                $this->tipoent->ViewValue = $this->tipoent->Lookup !== null && is_array($this->tipoent->lookupOptions()) && count($this->tipoent->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipoent->ViewValue !== null) { // Load from cache
                $this->tipoent->EditValue = array_values($this->tipoent->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipoent->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->tipoent->CurrentValue, $this->tipoent->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipoent->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipoent->EditValue = $arwrk;
            }
            $this->tipoent->PlaceHolder = RemoveHtml($this->tipoent->caption());

            // tipoiva
            $this->tipoiva->setupEditAttributes();
            $curVal = trim(strval($this->tipoiva->CurrentValue));
            if ($curVal != "") {
                $this->tipoiva->ViewValue = $this->tipoiva->lookupCacheOption($curVal);
            } else {
                $this->tipoiva->ViewValue = $this->tipoiva->Lookup !== null && is_array($this->tipoiva->lookupOptions()) && count($this->tipoiva->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipoiva->ViewValue !== null) { // Load from cache
                $this->tipoiva->EditValue = array_values($this->tipoiva->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipoiva->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->tipoiva->CurrentValue, $this->tipoiva->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipoiva->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipoiva->EditValue = $arwrk;
            }
            $this->tipoiva->PlaceHolder = RemoveHtml($this->tipoiva->caption());

            // cuit
            $this->cuit->setupEditAttributes();
            if (!$this->cuit->Raw) {
                $this->cuit->CurrentValue = HtmlDecode($this->cuit->CurrentValue);
            }
            $this->cuit->EditValue = HtmlEncode($this->cuit->CurrentValue);
            $this->cuit->PlaceHolder = RemoveHtml($this->cuit->caption());

            // calif
            $this->calif->setupEditAttributes();
            $curVal = trim(strval($this->calif->CurrentValue));
            if ($curVal != "") {
                $this->calif->ViewValue = $this->calif->lookupCacheOption($curVal);
            } else {
                $this->calif->ViewValue = $this->calif->Lookup !== null && is_array($this->calif->lookupOptions()) && count($this->calif->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->calif->ViewValue !== null) { // Load from cache
                $this->calif->EditValue = array_values($this->calif->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->calif->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->calif->CurrentValue, $this->calif->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->calif->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->calif->EditValue = $arwrk;
            }
            $this->calif->PlaceHolder = RemoveHtml($this->calif->caption());

            // fecalta
            $this->fecalta->setupEditAttributes();
            $this->fecalta->EditValue = HtmlEncode(FormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern()));
            $this->fecalta->PlaceHolder = RemoveHtml($this->fecalta->caption());

            // contacto
            $this->contacto->setupEditAttributes();
            if (!$this->contacto->Raw) {
                $this->contacto->CurrentValue = HtmlDecode($this->contacto->CurrentValue);
            }
            $this->contacto->EditValue = HtmlEncode($this->contacto->CurrentValue);
            $this->contacto->PlaceHolder = RemoveHtml($this->contacto->caption());

            // mailcont
            $this->mailcont->setupEditAttributes();
            if (!$this->mailcont->Raw) {
                $this->mailcont->CurrentValue = HtmlDecode($this->mailcont->CurrentValue);
            }
            $this->mailcont->EditValue = HtmlEncode($this->mailcont->CurrentValue);
            $this->mailcont->PlaceHolder = RemoveHtml($this->mailcont->caption());

            // cargo
            $this->cargo->setupEditAttributes();
            if (!$this->cargo->Raw) {
                $this->cargo->CurrentValue = HtmlDecode($this->cargo->CurrentValue);
            }
            $this->cargo->EditValue = HtmlEncode($this->cargo->CurrentValue);
            $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

            // fechahora

            // pagweb
            $this->pagweb->setupEditAttributes();
            if (!$this->pagweb->Raw) {
                $this->pagweb->CurrentValue = HtmlDecode($this->pagweb->CurrentValue);
            }
            $this->pagweb->EditValue = HtmlEncode($this->pagweb->CurrentValue);
            $this->pagweb->PlaceHolder = RemoveHtml($this->pagweb->caption());

            // tipoind
            $this->tipoind->setupEditAttributes();
            $curVal = trim(strval($this->tipoind->CurrentValue));
            if ($curVal != "") {
                $this->tipoind->ViewValue = $this->tipoind->lookupCacheOption($curVal);
            } else {
                $this->tipoind->ViewValue = $this->tipoind->Lookup !== null && is_array($this->tipoind->lookupOptions()) && count($this->tipoind->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipoind->ViewValue !== null) { // Load from cache
                $this->tipoind->EditValue = array_values($this->tipoind->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipoind->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->tipoind->CurrentValue, $this->tipoind->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipoind->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipoind->EditValue = $arwrk;
            }
            $this->tipoind->PlaceHolder = RemoveHtml($this->tipoind->caption());

            // Add refer script

            // razsoc
            $this->razsoc->HrefValue = "";

            // calle
            $this->calle->HrefValue = "";

            // numero
            $this->numero->HrefValue = "";

            // pisodto
            $this->pisodto->HrefValue = "";

            // codpais
            $this->codpais->HrefValue = "";

            // codprov
            $this->codprov->HrefValue = "";

            // codloc
            $this->codloc->HrefValue = "";

            // codpost
            $this->codpost->HrefValue = "";

            // tellinea
            $this->tellinea->HrefValue = "";

            // telcelu
            $this->telcelu->HrefValue = "";

            // tipoent
            $this->tipoent->HrefValue = "";

            // tipoiva
            $this->tipoiva->HrefValue = "";

            // cuit
            $this->cuit->HrefValue = "";

            // calif
            $this->calif->HrefValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";

            // contacto
            $this->contacto->HrefValue = "";

            // mailcont
            $this->mailcont->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // pagweb
            $this->pagweb->HrefValue = "";

            // tipoind
            $this->tipoind->HrefValue = "";
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
            if ($this->razsoc->Visible && $this->razsoc->Required) {
                if (!$this->razsoc->IsDetailKey && EmptyValue($this->razsoc->FormValue)) {
                    $this->razsoc->addErrorMessage(str_replace("%s", $this->razsoc->caption(), $this->razsoc->RequiredErrorMessage));
                }
            }
            if ($this->calle->Visible && $this->calle->Required) {
                if (!$this->calle->IsDetailKey && EmptyValue($this->calle->FormValue)) {
                    $this->calle->addErrorMessage(str_replace("%s", $this->calle->caption(), $this->calle->RequiredErrorMessage));
                }
            }
            if ($this->numero->Visible && $this->numero->Required) {
                if (!$this->numero->IsDetailKey && EmptyValue($this->numero->FormValue)) {
                    $this->numero->addErrorMessage(str_replace("%s", $this->numero->caption(), $this->numero->RequiredErrorMessage));
                }
            }
            if ($this->pisodto->Visible && $this->pisodto->Required) {
                if (!$this->pisodto->IsDetailKey && EmptyValue($this->pisodto->FormValue)) {
                    $this->pisodto->addErrorMessage(str_replace("%s", $this->pisodto->caption(), $this->pisodto->RequiredErrorMessage));
                }
            }
            if ($this->codpais->Visible && $this->codpais->Required) {
                if (!$this->codpais->IsDetailKey && EmptyValue($this->codpais->FormValue)) {
                    $this->codpais->addErrorMessage(str_replace("%s", $this->codpais->caption(), $this->codpais->RequiredErrorMessage));
                }
            }
            if ($this->codprov->Visible && $this->codprov->Required) {
                if (!$this->codprov->IsDetailKey && EmptyValue($this->codprov->FormValue)) {
                    $this->codprov->addErrorMessage(str_replace("%s", $this->codprov->caption(), $this->codprov->RequiredErrorMessage));
                }
            }
            if ($this->codloc->Visible && $this->codloc->Required) {
                if (!$this->codloc->IsDetailKey && EmptyValue($this->codloc->FormValue)) {
                    $this->codloc->addErrorMessage(str_replace("%s", $this->codloc->caption(), $this->codloc->RequiredErrorMessage));
                }
            }
            if ($this->codpost->Visible && $this->codpost->Required) {
                if (!$this->codpost->IsDetailKey && EmptyValue($this->codpost->FormValue)) {
                    $this->codpost->addErrorMessage(str_replace("%s", $this->codpost->caption(), $this->codpost->RequiredErrorMessage));
                }
            }
            if ($this->tellinea->Visible && $this->tellinea->Required) {
                if (!$this->tellinea->IsDetailKey && EmptyValue($this->tellinea->FormValue)) {
                    $this->tellinea->addErrorMessage(str_replace("%s", $this->tellinea->caption(), $this->tellinea->RequiredErrorMessage));
                }
            }
            if ($this->telcelu->Visible && $this->telcelu->Required) {
                if (!$this->telcelu->IsDetailKey && EmptyValue($this->telcelu->FormValue)) {
                    $this->telcelu->addErrorMessage(str_replace("%s", $this->telcelu->caption(), $this->telcelu->RequiredErrorMessage));
                }
            }
            if ($this->tipoent->Visible && $this->tipoent->Required) {
                if (!$this->tipoent->IsDetailKey && EmptyValue($this->tipoent->FormValue)) {
                    $this->tipoent->addErrorMessage(str_replace("%s", $this->tipoent->caption(), $this->tipoent->RequiredErrorMessage));
                }
            }
            if ($this->tipoiva->Visible && $this->tipoiva->Required) {
                if (!$this->tipoiva->IsDetailKey && EmptyValue($this->tipoiva->FormValue)) {
                    $this->tipoiva->addErrorMessage(str_replace("%s", $this->tipoiva->caption(), $this->tipoiva->RequiredErrorMessage));
                }
            }
            if ($this->cuit->Visible && $this->cuit->Required) {
                if (!$this->cuit->IsDetailKey && EmptyValue($this->cuit->FormValue)) {
                    $this->cuit->addErrorMessage(str_replace("%s", $this->cuit->caption(), $this->cuit->RequiredErrorMessage));
                }
            }
            if ($this->calif->Visible && $this->calif->Required) {
                if (!$this->calif->IsDetailKey && EmptyValue($this->calif->FormValue)) {
                    $this->calif->addErrorMessage(str_replace("%s", $this->calif->caption(), $this->calif->RequiredErrorMessage));
                }
            }
            if ($this->fecalta->Visible && $this->fecalta->Required) {
                if (!$this->fecalta->IsDetailKey && EmptyValue($this->fecalta->FormValue)) {
                    $this->fecalta->addErrorMessage(str_replace("%s", $this->fecalta->caption(), $this->fecalta->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecalta->FormValue, $this->fecalta->formatPattern())) {
                $this->fecalta->addErrorMessage($this->fecalta->getErrorMessage(false));
            }
            if ($this->contacto->Visible && $this->contacto->Required) {
                if (!$this->contacto->IsDetailKey && EmptyValue($this->contacto->FormValue)) {
                    $this->contacto->addErrorMessage(str_replace("%s", $this->contacto->caption(), $this->contacto->RequiredErrorMessage));
                }
            }
            if ($this->mailcont->Visible && $this->mailcont->Required) {
                if (!$this->mailcont->IsDetailKey && EmptyValue($this->mailcont->FormValue)) {
                    $this->mailcont->addErrorMessage(str_replace("%s", $this->mailcont->caption(), $this->mailcont->RequiredErrorMessage));
                }
            }
            if (!CheckEmail($this->mailcont->FormValue)) {
                $this->mailcont->addErrorMessage($this->mailcont->getErrorMessage(false));
            }
            if ($this->cargo->Visible && $this->cargo->Required) {
                if (!$this->cargo->IsDetailKey && EmptyValue($this->cargo->FormValue)) {
                    $this->cargo->addErrorMessage(str_replace("%s", $this->cargo->caption(), $this->cargo->RequiredErrorMessage));
                }
            }
            if ($this->fechahora->Visible && $this->fechahora->Required) {
                if (!$this->fechahora->IsDetailKey && EmptyValue($this->fechahora->FormValue)) {
                    $this->fechahora->addErrorMessage(str_replace("%s", $this->fechahora->caption(), $this->fechahora->RequiredErrorMessage));
                }
            }
            if ($this->pagweb->Visible && $this->pagweb->Required) {
                if (!$this->pagweb->IsDetailKey && EmptyValue($this->pagweb->FormValue)) {
                    $this->pagweb->addErrorMessage(str_replace("%s", $this->pagweb->caption(), $this->pagweb->RequiredErrorMessage));
                }
            }
            if ($this->tipoind->Visible && $this->tipoind->Required) {
                if (!$this->tipoind->IsDetailKey && EmptyValue($this->tipoind->FormValue)) {
                    $this->tipoind->addErrorMessage(str_replace("%s", $this->tipoind->caption(), $this->tipoind->RequiredErrorMessage));
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

        // razsoc
        $this->razsoc->setDbValueDef($rsnew, $this->razsoc->CurrentValue, false);

        // calle
        $this->calle->setDbValueDef($rsnew, $this->calle->CurrentValue, false);

        // numero
        $this->numero->setDbValueDef($rsnew, $this->numero->CurrentValue, false);

        // pisodto
        $this->pisodto->setDbValueDef($rsnew, $this->pisodto->CurrentValue, false);

        // codpais
        $this->codpais->setDbValueDef($rsnew, $this->codpais->CurrentValue, false);

        // codprov
        $this->codprov->setDbValueDef($rsnew, $this->codprov->CurrentValue, false);

        // codloc
        $this->codloc->setDbValueDef($rsnew, $this->codloc->CurrentValue, false);

        // codpost
        $this->codpost->setDbValueDef($rsnew, $this->codpost->CurrentValue, false);

        // tellinea
        $this->tellinea->setDbValueDef($rsnew, $this->tellinea->CurrentValue, false);

        // telcelu
        $this->telcelu->setDbValueDef($rsnew, $this->telcelu->CurrentValue, false);

        // tipoent
        $this->tipoent->setDbValueDef($rsnew, $this->tipoent->CurrentValue, false);

        // tipoiva
        $this->tipoiva->setDbValueDef($rsnew, $this->tipoiva->CurrentValue, strval($this->tipoiva->CurrentValue) == "");

        // cuit
        $this->cuit->setDbValueDef($rsnew, $this->cuit->CurrentValue, false);

        // calif
        $this->calif->setDbValueDef($rsnew, $this->calif->CurrentValue, false);

        // fecalta
        $this->fecalta->setDbValueDef($rsnew, UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern()), false);

        // contacto
        $this->contacto->setDbValueDef($rsnew, $this->contacto->CurrentValue, false);

        // mailcont
        $this->mailcont->setDbValueDef($rsnew, $this->mailcont->CurrentValue, false);

        // cargo
        $this->cargo->setDbValueDef($rsnew, $this->cargo->CurrentValue, false);

        // fechahora
        $this->fechahora->CurrentValue = $this->fechahora->getAutoUpdateValue(); // PHP
        $this->fechahora->setDbValueDef($rsnew, UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()));

        // pagweb
        $this->pagweb->setDbValueDef($rsnew, $this->pagweb->CurrentValue, false);

        // tipoind
        $this->tipoind->setDbValueDef($rsnew, $this->tipoind->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['razsoc'])) { // razsoc
            $this->razsoc->setFormValue($row['razsoc']);
        }
        if (isset($row['calle'])) { // calle
            $this->calle->setFormValue($row['calle']);
        }
        if (isset($row['numero'])) { // numero
            $this->numero->setFormValue($row['numero']);
        }
        if (isset($row['pisodto'])) { // pisodto
            $this->pisodto->setFormValue($row['pisodto']);
        }
        if (isset($row['codpais'])) { // codpais
            $this->codpais->setFormValue($row['codpais']);
        }
        if (isset($row['codprov'])) { // codprov
            $this->codprov->setFormValue($row['codprov']);
        }
        if (isset($row['codloc'])) { // codloc
            $this->codloc->setFormValue($row['codloc']);
        }
        if (isset($row['codpost'])) { // codpost
            $this->codpost->setFormValue($row['codpost']);
        }
        if (isset($row['tellinea'])) { // tellinea
            $this->tellinea->setFormValue($row['tellinea']);
        }
        if (isset($row['telcelu'])) { // telcelu
            $this->telcelu->setFormValue($row['telcelu']);
        }
        if (isset($row['tipoent'])) { // tipoent
            $this->tipoent->setFormValue($row['tipoent']);
        }
        if (isset($row['tipoiva'])) { // tipoiva
            $this->tipoiva->setFormValue($row['tipoiva']);
        }
        if (isset($row['cuit'])) { // cuit
            $this->cuit->setFormValue($row['cuit']);
        }
        if (isset($row['calif'])) { // calif
            $this->calif->setFormValue($row['calif']);
        }
        if (isset($row['fecalta'])) { // fecalta
            $this->fecalta->setFormValue($row['fecalta']);
        }
        if (isset($row['contacto'])) { // contacto
            $this->contacto->setFormValue($row['contacto']);
        }
        if (isset($row['mailcont'])) { // mailcont
            $this->mailcont->setFormValue($row['mailcont']);
        }
        if (isset($row['cargo'])) { // cargo
            $this->cargo->setFormValue($row['cargo']);
        }
        if (isset($row['fechahora'])) { // fechahora
            $this->fechahora->setFormValue($row['fechahora']);
        }
        if (isset($row['pagweb'])) { // pagweb
            $this->pagweb->setFormValue($row['pagweb']);
        }
        if (isset($row['tipoind'])) { // tipoind
            $this->tipoind->setFormValue($row['tipoind']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("EntidadesList"), "", $this->TableVar, true);
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
