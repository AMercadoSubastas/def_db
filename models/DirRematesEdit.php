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
class DirRematesEdit extends DirRemates
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "DirRematesEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "DirRematesEdit";

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
        $this->codigo->setVisibility();
        $this->codrem->setVisibility();
        $this->secuencia->setVisibility();
        $this->direccion->setVisibility();
        $this->codpais->setVisibility();
        $this->codprov->setVisibility();
        $this->codloc->setVisibility();
        $this->usuarioalta->setVisibility();
        $this->fechaalta->setVisibility();
        $this->usuariomod->setVisibility();
        $this->fechaultmod->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'dir_remates';
        $this->TableName = 'dir_remates';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (dir_remates)
        if (!isset($GLOBALS["dir_remates"]) || $GLOBALS["dir_remates"]::class == PROJECT_NAMESPACE . "dir_remates") {
            $GLOBALS["dir_remates"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'dir_remates');
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
                        $result["view"] = SameString($pageName, "DirRematesView"); // If View page, no primary button
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
            $key .= @$ar['codigo'];
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
            $this->codigo->Visible = false;
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->setupLookupOptions($this->codrem);
        $this->setupLookupOptions($this->codpais);
        $this->setupLookupOptions($this->codprov);
        $this->setupLookupOptions($this->codloc);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("codigo") ?? Key(0) ?? Route(2)) !== null) {
                $this->codigo->setQueryStringValue($keyValue);
                $this->codigo->setOldValue($this->codigo->QueryStringValue);
            } elseif (Post("codigo") !== null) {
                $this->codigo->setFormValue(Post("codigo"));
                $this->codigo->setOldValue($this->codigo->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("codigo") ?? Route("codigo")) !== null) {
                    $this->codigo->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->codigo->CurrentValue = null;
                }
            }

            // Load result set
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("DirRematesList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "DirRematesList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "DirRematesList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "DirRematesList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
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
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = RowType::EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'codigo' first before field var 'x_codigo'
        $val = $CurrentForm->hasValue("codigo") ? $CurrentForm->getValue("codigo") : $CurrentForm->getValue("x_codigo");
        if (!$this->codigo->IsDetailKey) {
            $this->codigo->setFormValue($val);
        }

        // Check field name 'codrem' first before field var 'x_codrem'
        $val = $CurrentForm->hasValue("codrem") ? $CurrentForm->getValue("codrem") : $CurrentForm->getValue("x_codrem");
        if (!$this->codrem->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codrem->Visible = false; // Disable update for API request
            } else {
                $this->codrem->setFormValue($val);
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

        // Check field name 'direccion' first before field var 'x_direccion'
        $val = $CurrentForm->hasValue("direccion") ? $CurrentForm->getValue("direccion") : $CurrentForm->getValue("x_direccion");
        if (!$this->direccion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->direccion->Visible = false; // Disable update for API request
            } else {
                $this->direccion->setFormValue($val);
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

        // Check field name 'usuariomod' first before field var 'x_usuariomod'
        $val = $CurrentForm->hasValue("usuariomod") ? $CurrentForm->getValue("usuariomod") : $CurrentForm->getValue("x_usuariomod");
        if (!$this->usuariomod->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuariomod->Visible = false; // Disable update for API request
            } else {
                $this->usuariomod->setFormValue($val);
            }
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->codigo->CurrentValue = $this->codigo->FormValue;
        $this->codrem->CurrentValue = $this->codrem->FormValue;
        $this->secuencia->CurrentValue = $this->secuencia->FormValue;
        $this->direccion->CurrentValue = $this->direccion->FormValue;
        $this->codpais->CurrentValue = $this->codpais->FormValue;
        $this->codprov->CurrentValue = $this->codprov->FormValue;
        $this->codloc->CurrentValue = $this->codloc->FormValue;
        $this->usuarioalta->CurrentValue = $this->usuarioalta->FormValue;
        $this->fechaalta->CurrentValue = $this->fechaalta->FormValue;
        $this->fechaalta->CurrentValue = UnFormatDateTime($this->fechaalta->CurrentValue, $this->fechaalta->formatPattern());
        $this->usuariomod->CurrentValue = $this->usuariomod->FormValue;
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codigo'] = $this->codigo->DefaultValue;
        $row['codrem'] = $this->codrem->DefaultValue;
        $row['secuencia'] = $this->secuencia->DefaultValue;
        $row['direccion'] = $this->direccion->DefaultValue;
        $row['codpais'] = $this->codpais->DefaultValue;
        $row['codprov'] = $this->codprov->DefaultValue;
        $row['codloc'] = $this->codloc->DefaultValue;
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

        // codigo
        $this->codigo->RowCssClass = "row";

        // codrem
        $this->codrem->RowCssClass = "row";

        // secuencia
        $this->secuencia->RowCssClass = "row";

        // direccion
        $this->direccion->RowCssClass = "row";

        // codpais
        $this->codpais->RowCssClass = "row";

        // codprov
        $this->codprov->RowCssClass = "row";

        // codloc
        $this->codloc->RowCssClass = "row";

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

            // codrem
            $this->codrem->HrefValue = "";

            // secuencia
            $this->secuencia->HrefValue = "";

            // direccion
            $this->direccion->HrefValue = "";

            // codpais
            $this->codpais->HrefValue = "";

            // codprov
            $this->codprov->HrefValue = "";

            // codloc
            $this->codloc->HrefValue = "";

            // usuarioalta
            $this->usuarioalta->HrefValue = "";

            // fechaalta
            $this->fechaalta->HrefValue = "";

            // usuariomod
            $this->usuariomod->HrefValue = "";

            // fechaultmod
            $this->fechaultmod->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // codigo
            $this->codigo->setupEditAttributes();
            $this->codigo->EditValue = $this->codigo->CurrentValue;

            // codrem
            $this->codrem->setupEditAttributes();
            $curVal = trim(strval($this->codrem->CurrentValue));
            if ($curVal != "") {
                $this->codrem->ViewValue = $this->codrem->lookupCacheOption($curVal);
            } else {
                $this->codrem->ViewValue = $this->codrem->Lookup !== null && is_array($this->codrem->lookupOptions()) && count($this->codrem->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->codrem->ViewValue !== null) { // Load from cache
                $this->codrem->EditValue = array_values($this->codrem->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->codrem->Lookup->getTable()->Fields["ncomp"]->searchExpression(), "=", $this->codrem->CurrentValue, $this->codrem->Lookup->getTable()->Fields["ncomp"]->searchDataType(), "");
                }
                $sqlWrk = $this->codrem->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->codrem->Lookup->renderViewRow($row);
                }
                $this->codrem->EditValue = $arwrk;
            }
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
            $this->direccion->EditValue = HtmlEncode($this->direccion->CurrentValue);
            $this->direccion->PlaceHolder = RemoveHtml($this->direccion->caption());

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

            // usuarioalta

            // fechaalta

            // usuariomod

            // fechaultmod

            // Edit refer script

            // codigo
            $this->codigo->HrefValue = "";

            // codrem
            $this->codrem->HrefValue = "";

            // secuencia
            $this->secuencia->HrefValue = "";

            // direccion
            $this->direccion->HrefValue = "";

            // codpais
            $this->codpais->HrefValue = "";

            // codprov
            $this->codprov->HrefValue = "";

            // codloc
            $this->codloc->HrefValue = "";

            // usuarioalta
            $this->usuarioalta->HrefValue = "";

            // fechaalta
            $this->fechaalta->HrefValue = "";

            // usuariomod
            $this->usuariomod->HrefValue = "";

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
            if ($this->codigo->Visible && $this->codigo->Required) {
                if (!$this->codigo->IsDetailKey && EmptyValue($this->codigo->FormValue)) {
                    $this->codigo->addErrorMessage(str_replace("%s", $this->codigo->caption(), $this->codigo->RequiredErrorMessage));
                }
            }
            if ($this->codrem->Visible && $this->codrem->Required) {
                if (!$this->codrem->IsDetailKey && EmptyValue($this->codrem->FormValue)) {
                    $this->codrem->addErrorMessage(str_replace("%s", $this->codrem->caption(), $this->codrem->RequiredErrorMessage));
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
            if ($this->direccion->Visible && $this->direccion->Required) {
                if (!$this->direccion->IsDetailKey && EmptyValue($this->direccion->FormValue)) {
                    $this->direccion->addErrorMessage(str_replace("%s", $this->direccion->caption(), $this->direccion->RequiredErrorMessage));
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
            if ($this->usuariomod->Visible && $this->usuariomod->Required) {
                if (!$this->usuariomod->IsDetailKey && EmptyValue($this->usuariomod->FormValue)) {
                    $this->usuariomod->addErrorMessage(str_replace("%s", $this->usuariomod->caption(), $this->usuariomod->RequiredErrorMessage));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // codrem
        $this->codrem->setDbValueDef($rsnew, $this->codrem->CurrentValue, $this->codrem->ReadOnly);

        // secuencia
        $this->secuencia->setDbValueDef($rsnew, $this->secuencia->CurrentValue, $this->secuencia->ReadOnly);

        // direccion
        $this->direccion->setDbValueDef($rsnew, $this->direccion->CurrentValue, $this->direccion->ReadOnly);

        // codpais
        $this->codpais->setDbValueDef($rsnew, $this->codpais->CurrentValue, $this->codpais->ReadOnly);

        // codprov
        $this->codprov->setDbValueDef($rsnew, $this->codprov->CurrentValue, $this->codprov->ReadOnly);

        // codloc
        $this->codloc->setDbValueDef($rsnew, $this->codloc->CurrentValue, $this->codloc->ReadOnly);

        // usuarioalta
        $this->usuarioalta->CurrentValue = $this->usuarioalta->getAutoUpdateValue(); // PHP
        $this->usuarioalta->setDbValueDef($rsnew, $this->usuarioalta->CurrentValue, $this->usuarioalta->ReadOnly);

        // fechaalta
        $this->fechaalta->CurrentValue = $this->fechaalta->getAutoUpdateValue(); // PHP
        $this->fechaalta->setDbValueDef($rsnew, UnFormatDateTime($this->fechaalta->CurrentValue, $this->fechaalta->formatPattern()), $this->fechaalta->ReadOnly);

        // usuariomod
        $this->usuariomod->CurrentValue = $this->usuariomod->getAutoUpdateValue(); // PHP
        $this->usuariomod->setDbValueDef($rsnew, $this->usuariomod->CurrentValue, $this->usuariomod->ReadOnly);

        // fechaultmod
        $this->fechaultmod->CurrentValue = $this->fechaultmod->getAutoUpdateValue(); // PHP
        $this->fechaultmod->setDbValueDef($rsnew, UnFormatDateTime($this->fechaultmod->CurrentValue, $this->fechaultmod->formatPattern()), $this->fechaultmod->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['codrem'])) { // codrem
            $this->codrem->CurrentValue = $row['codrem'];
        }
        if (isset($row['secuencia'])) { // secuencia
            $this->secuencia->CurrentValue = $row['secuencia'];
        }
        if (isset($row['direccion'])) { // direccion
            $this->direccion->CurrentValue = $row['direccion'];
        }
        if (isset($row['codpais'])) { // codpais
            $this->codpais->CurrentValue = $row['codpais'];
        }
        if (isset($row['codprov'])) { // codprov
            $this->codprov->CurrentValue = $row['codprov'];
        }
        if (isset($row['codloc'])) { // codloc
            $this->codloc->CurrentValue = $row['codloc'];
        }
        if (isset($row['usuarioalta'])) { // usuarioalta
            $this->usuarioalta->CurrentValue = $row['usuarioalta'];
        }
        if (isset($row['fechaalta'])) { // fechaalta
            $this->fechaalta->CurrentValue = $row['fechaalta'];
        }
        if (isset($row['usuariomod'])) { // usuariomod
            $this->usuariomod->CurrentValue = $row['usuariomod'];
        }
        if (isset($row['fechaultmod'])) { // fechaultmod
            $this->fechaultmod->CurrentValue = $row['fechaultmod'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("DirRematesList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_codrem":
                    break;
                case "x_codpais":
                    break;
                case "x_codprov":
                    break;
                case "x_codloc":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
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
