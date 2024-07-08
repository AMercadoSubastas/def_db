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
class RematesEdit extends Remates
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RematesEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "RematesEdit";

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
        $this->ncomp->setVisibility();
        $this->codnum->Visible = false;
        $this->tcomp->setVisibility();
        $this->serie->setVisibility();
        $this->codcli->setVisibility();
        $this->direccion->setVisibility();
        $this->codpais->setVisibility();
        $this->codprov->setVisibility();
        $this->codloc->setVisibility();
        $this->fecest->setVisibility();
        $this->fecreal->setVisibility();
        $this->imptot->setVisibility();
        $this->impbase->setVisibility();
        $this->estado->setVisibility();
        $this->cantlotes->setVisibility();
        $this->horaest->setVisibility();
        $this->horareal->setVisibility();
        $this->usuario->setVisibility();
        $this->fecalta->setVisibility();
        $this->observacion->setVisibility();
        $this->tipoind->setVisibility();
        $this->sello->setVisibility();
        $this->plazoSAP->setVisibility();
        $this->usuarioultmod->setVisibility();
        $this->fecultmod->setVisibility();
        $this->servicios->setVisibility();
        $this->gastos->setVisibility();
        $this->tasa->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'remates';
        $this->TableName = 'remates';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (remates)
        if (!isset($GLOBALS["remates"]) || $GLOBALS["remates"]::class == PROJECT_NAMESPACE . "remates") {
            $GLOBALS["remates"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'remates');
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
                        $result["view"] = SameString($pageName, "RematesView"); // If View page, no primary button
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
        $this->ncomp->Required = false;

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
        $this->setupLookupOptions($this->tcomp);
        $this->setupLookupOptions($this->serie);
        $this->setupLookupOptions($this->codcli);
        $this->setupLookupOptions($this->codpais);
        $this->setupLookupOptions($this->codprov);
        $this->setupLookupOptions($this->codloc);
        $this->setupLookupOptions($this->estado);
        $this->setupLookupOptions($this->sello);
        $this->setupLookupOptions($this->plazoSAP);
        $this->setupLookupOptions($this->tasa);

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
            if (($keyValue = Get("codnum") ?? Key(0) ?? Route(2)) !== null) {
                $this->codnum->setQueryStringValue($keyValue);
                $this->codnum->setOldValue($this->codnum->QueryStringValue);
            } elseif (Post("codnum") !== null) {
                $this->codnum->setFormValue(Post("codnum"));
                $this->codnum->setOldValue($this->codnum->FormValue);
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
                if (($keyValue = Get("codnum") ?? Route("codnum")) !== null) {
                    $this->codnum->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->codnum->CurrentValue = null;
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

            // Set up detail parameters
            $this->setupDetailParms();
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
                        $this->terminate("RematesList"); // No matching record, return to list
                        return;
                    }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                $returnUrl = "RematesList";
                if (GetPageName($returnUrl) == "RematesList") {
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
                        if (GetPageName($returnUrl) != "RematesList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "RematesList"; // Return list page content
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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

        // Check field name 'ncomp' first before field var 'x_ncomp'
        $val = $CurrentForm->hasValue("ncomp") ? $CurrentForm->getValue("ncomp") : $CurrentForm->getValue("x_ncomp");
        if (!$this->ncomp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ncomp->Visible = false; // Disable update for API request
            } else {
                $this->ncomp->setFormValue($val);
            }
        }

        // Check field name 'tcomp' first before field var 'x_tcomp'
        $val = $CurrentForm->hasValue("tcomp") ? $CurrentForm->getValue("tcomp") : $CurrentForm->getValue("x_tcomp");
        if (!$this->tcomp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tcomp->Visible = false; // Disable update for API request
            } else {
                $this->tcomp->setFormValue($val);
            }
        }

        // Check field name 'serie' first before field var 'x_serie'
        $val = $CurrentForm->hasValue("serie") ? $CurrentForm->getValue("serie") : $CurrentForm->getValue("x_serie");
        if (!$this->serie->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->serie->Visible = false; // Disable update for API request
            } else {
                $this->serie->setFormValue($val);
            }
        }

        // Check field name 'codcli' first before field var 'x_codcli'
        $val = $CurrentForm->hasValue("codcli") ? $CurrentForm->getValue("codcli") : $CurrentForm->getValue("x_codcli");
        if (!$this->codcli->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codcli->Visible = false; // Disable update for API request
            } else {
                $this->codcli->setFormValue($val);
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

        // Check field name 'fecest' first before field var 'x_fecest'
        $val = $CurrentForm->hasValue("fecest") ? $CurrentForm->getValue("fecest") : $CurrentForm->getValue("x_fecest");
        if (!$this->fecest->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecest->Visible = false; // Disable update for API request
            } else {
                $this->fecest->setFormValue($val, true, $validate);
            }
            $this->fecest->CurrentValue = UnFormatDateTime($this->fecest->CurrentValue, $this->fecest->formatPattern());
        }

        // Check field name 'fecreal' first before field var 'x_fecreal'
        $val = $CurrentForm->hasValue("fecreal") ? $CurrentForm->getValue("fecreal") : $CurrentForm->getValue("x_fecreal");
        if (!$this->fecreal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecreal->Visible = false; // Disable update for API request
            } else {
                $this->fecreal->setFormValue($val, true, $validate);
            }
            $this->fecreal->CurrentValue = UnFormatDateTime($this->fecreal->CurrentValue, $this->fecreal->formatPattern());
        }

        // Check field name 'imptot' first before field var 'x_imptot'
        $val = $CurrentForm->hasValue("imptot") ? $CurrentForm->getValue("imptot") : $CurrentForm->getValue("x_imptot");
        if (!$this->imptot->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->imptot->Visible = false; // Disable update for API request
            } else {
                $this->imptot->setFormValue($val);
            }
        }

        // Check field name 'impbase' first before field var 'x_impbase'
        $val = $CurrentForm->hasValue("impbase") ? $CurrentForm->getValue("impbase") : $CurrentForm->getValue("x_impbase");
        if (!$this->impbase->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->impbase->Visible = false; // Disable update for API request
            } else {
                $this->impbase->setFormValue($val);
            }
        }

        // Check field name 'estado' first before field var 'x_estado'
        $val = $CurrentForm->hasValue("estado") ? $CurrentForm->getValue("estado") : $CurrentForm->getValue("x_estado");
        if (!$this->estado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estado->Visible = false; // Disable update for API request
            } else {
                $this->estado->setFormValue($val);
            }
        }

        // Check field name 'cantlotes' first before field var 'x_cantlotes'
        $val = $CurrentForm->hasValue("cantlotes") ? $CurrentForm->getValue("cantlotes") : $CurrentForm->getValue("x_cantlotes");
        if (!$this->cantlotes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cantlotes->Visible = false; // Disable update for API request
            } else {
                $this->cantlotes->setFormValue($val);
            }
        }

        // Check field name 'horaest' first before field var 'x_horaest'
        $val = $CurrentForm->hasValue("horaest") ? $CurrentForm->getValue("horaest") : $CurrentForm->getValue("x_horaest");
        if (!$this->horaest->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->horaest->Visible = false; // Disable update for API request
            } else {
                $this->horaest->setFormValue($val);
            }
            $this->horaest->CurrentValue = UnFormatDateTime($this->horaest->CurrentValue, $this->horaest->formatPattern());
        }

        // Check field name 'horareal' first before field var 'x_horareal'
        $val = $CurrentForm->hasValue("horareal") ? $CurrentForm->getValue("horareal") : $CurrentForm->getValue("x_horareal");
        if (!$this->horareal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->horareal->Visible = false; // Disable update for API request
            } else {
                $this->horareal->setFormValue($val, true, $validate);
            }
            $this->horareal->CurrentValue = UnFormatDateTime($this->horareal->CurrentValue, $this->horareal->formatPattern());
        }

        // Check field name 'usuario' first before field var 'x_usuario'
        $val = $CurrentForm->hasValue("usuario") ? $CurrentForm->getValue("usuario") : $CurrentForm->getValue("x_usuario");
        if (!$this->usuario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario->Visible = false; // Disable update for API request
            } else {
                $this->usuario->setFormValue($val);
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

        // Check field name 'observacion' first before field var 'x_observacion'
        $val = $CurrentForm->hasValue("observacion") ? $CurrentForm->getValue("observacion") : $CurrentForm->getValue("x_observacion");
        if (!$this->observacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->observacion->Visible = false; // Disable update for API request
            } else {
                $this->observacion->setFormValue($val);
            }
        }

        // Check field name 'tipoind' first before field var 'x_tipoind'
        $val = $CurrentForm->hasValue("tipoind") ? $CurrentForm->getValue("tipoind") : $CurrentForm->getValue("x_tipoind");
        if (!$this->tipoind->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipoind->Visible = false; // Disable update for API request
            } else {
                $this->tipoind->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'sello' first before field var 'x_sello'
        $val = $CurrentForm->hasValue("sello") ? $CurrentForm->getValue("sello") : $CurrentForm->getValue("x_sello");
        if (!$this->sello->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sello->Visible = false; // Disable update for API request
            } else {
                $this->sello->setFormValue($val);
            }
        }

        // Check field name 'plazoSAP' first before field var 'x_plazoSAP'
        $val = $CurrentForm->hasValue("plazoSAP") ? $CurrentForm->getValue("plazoSAP") : $CurrentForm->getValue("x_plazoSAP");
        if (!$this->plazoSAP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->plazoSAP->Visible = false; // Disable update for API request
            } else {
                $this->plazoSAP->setFormValue($val);
            }
        }

        // Check field name 'usuarioultmod' first before field var 'x_usuarioultmod'
        $val = $CurrentForm->hasValue("usuarioultmod") ? $CurrentForm->getValue("usuarioultmod") : $CurrentForm->getValue("x_usuarioultmod");
        if (!$this->usuarioultmod->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuarioultmod->Visible = false; // Disable update for API request
            } else {
                $this->usuarioultmod->setFormValue($val);
            }
        }

        // Check field name 'fecultmod' first before field var 'x_fecultmod'
        $val = $CurrentForm->hasValue("fecultmod") ? $CurrentForm->getValue("fecultmod") : $CurrentForm->getValue("x_fecultmod");
        if (!$this->fecultmod->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecultmod->Visible = false; // Disable update for API request
            } else {
                $this->fecultmod->setFormValue($val);
            }
            $this->fecultmod->CurrentValue = UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern());
        }

        // Check field name 'servicios' first before field var 'x_servicios'
        $val = $CurrentForm->hasValue("servicios") ? $CurrentForm->getValue("servicios") : $CurrentForm->getValue("x_servicios");
        if (!$this->servicios->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->servicios->Visible = false; // Disable update for API request
            } else {
                $this->servicios->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'gastos' first before field var 'x_gastos'
        $val = $CurrentForm->hasValue("gastos") ? $CurrentForm->getValue("gastos") : $CurrentForm->getValue("x_gastos");
        if (!$this->gastos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gastos->Visible = false; // Disable update for API request
            } else {
                $this->gastos->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'tasa' first before field var 'x_tasa'
        $val = $CurrentForm->hasValue("tasa") ? $CurrentForm->getValue("tasa") : $CurrentForm->getValue("x_tasa");
        if (!$this->tasa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tasa->Visible = false; // Disable update for API request
            } else {
                $this->tasa->setFormValue($val);
            }
        }

        // Check field name 'codnum' first before field var 'x_codnum'
        $val = $CurrentForm->hasValue("codnum") ? $CurrentForm->getValue("codnum") : $CurrentForm->getValue("x_codnum");
        if (!$this->codnum->IsDetailKey) {
            $this->codnum->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->codnum->CurrentValue = $this->codnum->FormValue;
        $this->ncomp->CurrentValue = $this->ncomp->FormValue;
        $this->tcomp->CurrentValue = $this->tcomp->FormValue;
        $this->serie->CurrentValue = $this->serie->FormValue;
        $this->codcli->CurrentValue = $this->codcli->FormValue;
        $this->direccion->CurrentValue = $this->direccion->FormValue;
        $this->codpais->CurrentValue = $this->codpais->FormValue;
        $this->codprov->CurrentValue = $this->codprov->FormValue;
        $this->codloc->CurrentValue = $this->codloc->FormValue;
        $this->fecest->CurrentValue = $this->fecest->FormValue;
        $this->fecest->CurrentValue = UnFormatDateTime($this->fecest->CurrentValue, $this->fecest->formatPattern());
        $this->fecreal->CurrentValue = $this->fecreal->FormValue;
        $this->fecreal->CurrentValue = UnFormatDateTime($this->fecreal->CurrentValue, $this->fecreal->formatPattern());
        $this->imptot->CurrentValue = $this->imptot->FormValue;
        $this->impbase->CurrentValue = $this->impbase->FormValue;
        $this->estado->CurrentValue = $this->estado->FormValue;
        $this->cantlotes->CurrentValue = $this->cantlotes->FormValue;
        $this->horaest->CurrentValue = $this->horaest->FormValue;
        $this->horaest->CurrentValue = UnFormatDateTime($this->horaest->CurrentValue, $this->horaest->formatPattern());
        $this->horareal->CurrentValue = $this->horareal->FormValue;
        $this->horareal->CurrentValue = UnFormatDateTime($this->horareal->CurrentValue, $this->horareal->formatPattern());
        $this->usuario->CurrentValue = $this->usuario->FormValue;
        $this->fecalta->CurrentValue = $this->fecalta->FormValue;
        $this->fecalta->CurrentValue = UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern());
        $this->observacion->CurrentValue = $this->observacion->FormValue;
        $this->tipoind->CurrentValue = $this->tipoind->FormValue;
        $this->sello->CurrentValue = $this->sello->FormValue;
        $this->plazoSAP->CurrentValue = $this->plazoSAP->FormValue;
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->FormValue;
        $this->fecultmod->CurrentValue = $this->fecultmod->FormValue;
        $this->fecultmod->CurrentValue = UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern());
        $this->servicios->CurrentValue = $this->servicios->FormValue;
        $this->gastos->CurrentValue = $this->gastos->FormValue;
        $this->tasa->CurrentValue = $this->tasa->FormValue;
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
        $this->ncomp->setDbValue($row['ncomp']);
        $this->codnum->setDbValue($row['codnum']);
        $this->tcomp->setDbValue($row['tcomp']);
        $this->serie->setDbValue($row['serie']);
        $this->codcli->setDbValue($row['codcli']);
        $this->direccion->setDbValue($row['direccion']);
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
        $this->fecest->setDbValue($row['fecest']);
        $this->fecreal->setDbValue($row['fecreal']);
        $this->imptot->setDbValue($row['imptot']);
        $this->impbase->setDbValue($row['impbase']);
        $this->estado->setDbValue($row['estado']);
        $this->cantlotes->setDbValue($row['cantlotes']);
        $this->horaest->setDbValue($row['horaest']);
        $this->horareal->setDbValue($row['horareal']);
        $this->usuario->setDbValue($row['usuario']);
        $this->fecalta->setDbValue($row['fecalta']);
        $this->observacion->setDbValue($row['observacion']);
        $this->tipoind->setDbValue($row['tipoind']);
        $this->sello->setDbValue($row['sello']);
        $this->plazoSAP->setDbValue($row['plazoSAP']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
        $this->servicios->setDbValue($row['servicios']);
        $this->gastos->setDbValue($row['gastos']);
        $this->tasa->setDbValue($row['tasa']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ncomp'] = $this->ncomp->DefaultValue;
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['tcomp'] = $this->tcomp->DefaultValue;
        $row['serie'] = $this->serie->DefaultValue;
        $row['codcli'] = $this->codcli->DefaultValue;
        $row['direccion'] = $this->direccion->DefaultValue;
        $row['codpais'] = $this->codpais->DefaultValue;
        $row['codprov'] = $this->codprov->DefaultValue;
        $row['codloc'] = $this->codloc->DefaultValue;
        $row['fecest'] = $this->fecest->DefaultValue;
        $row['fecreal'] = $this->fecreal->DefaultValue;
        $row['imptot'] = $this->imptot->DefaultValue;
        $row['impbase'] = $this->impbase->DefaultValue;
        $row['estado'] = $this->estado->DefaultValue;
        $row['cantlotes'] = $this->cantlotes->DefaultValue;
        $row['horaest'] = $this->horaest->DefaultValue;
        $row['horareal'] = $this->horareal->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['fecalta'] = $this->fecalta->DefaultValue;
        $row['observacion'] = $this->observacion->DefaultValue;
        $row['tipoind'] = $this->tipoind->DefaultValue;
        $row['sello'] = $this->sello->DefaultValue;
        $row['plazoSAP'] = $this->plazoSAP->DefaultValue;
        $row['usuarioultmod'] = $this->usuarioultmod->DefaultValue;
        $row['fecultmod'] = $this->fecultmod->DefaultValue;
        $row['servicios'] = $this->servicios->DefaultValue;
        $row['gastos'] = $this->gastos->DefaultValue;
        $row['tasa'] = $this->tasa->DefaultValue;
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

        // ncomp
        $this->ncomp->RowCssClass = "row";

        // codnum
        $this->codnum->RowCssClass = "row";

        // tcomp
        $this->tcomp->RowCssClass = "row";

        // serie
        $this->serie->RowCssClass = "row";

        // codcli
        $this->codcli->RowCssClass = "row";

        // direccion
        $this->direccion->RowCssClass = "row";

        // codpais
        $this->codpais->RowCssClass = "row";

        // codprov
        $this->codprov->RowCssClass = "row";

        // codloc
        $this->codloc->RowCssClass = "row";

        // fecest
        $this->fecest->RowCssClass = "row";

        // fecreal
        $this->fecreal->RowCssClass = "row";

        // imptot
        $this->imptot->RowCssClass = "row";

        // impbase
        $this->impbase->RowCssClass = "row";

        // estado
        $this->estado->RowCssClass = "row";

        // cantlotes
        $this->cantlotes->RowCssClass = "row";

        // horaest
        $this->horaest->RowCssClass = "row";

        // horareal
        $this->horareal->RowCssClass = "row";

        // usuario
        $this->usuario->RowCssClass = "row";

        // fecalta
        $this->fecalta->RowCssClass = "row";

        // observacion
        $this->observacion->RowCssClass = "row";

        // tipoind
        $this->tipoind->RowCssClass = "row";

        // sello
        $this->sello->RowCssClass = "row";

        // plazoSAP
        $this->plazoSAP->RowCssClass = "row";

        // usuarioultmod
        $this->usuarioultmod->RowCssClass = "row";

        // fecultmod
        $this->fecultmod->RowCssClass = "row";

        // servicios
        $this->servicios->RowCssClass = "row";

        // gastos
        $this->gastos->RowCssClass = "row";

        // tasa
        $this->tasa->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // ncomp
            $this->ncomp->ViewValue = $this->ncomp->CurrentValue;
            $this->ncomp->ViewValue = FormatNumber($this->ncomp->ViewValue, $this->ncomp->formatPattern());

            // codnum
            $this->codnum->ViewValue = $this->codnum->CurrentValue;

            // tcomp
            $curVal = strval($this->tcomp->CurrentValue);
            if ($curVal != "") {
                $this->tcomp->ViewValue = $this->tcomp->lookupCacheOption($curVal);
                if ($this->tcomp->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tcomp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tcomp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $lookupFilter = $this->tcomp->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tcomp->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tcomp->Lookup->renderViewRow($rswrk[0]);
                        $this->tcomp->ViewValue = $this->tcomp->displayValue($arwrk);
                    } else {
                        $this->tcomp->ViewValue = FormatNumber($this->tcomp->CurrentValue, $this->tcomp->formatPattern());
                    }
                }
            } else {
                $this->tcomp->ViewValue = null;
            }

            // serie
            $curVal = strval($this->serie->CurrentValue);
            if ($curVal != "") {
                $this->serie->ViewValue = $this->serie->lookupCacheOption($curVal);
                if ($this->serie->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->serie->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->serie->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $lookupFilter = $this->serie->getSelectFilter($this); // PHP
                    $sqlWrk = $this->serie->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->serie->Lookup->renderViewRow($rswrk[0]);
                        $this->serie->ViewValue = $this->serie->displayValue($arwrk);
                    } else {
                        $this->serie->ViewValue = FormatNumber($this->serie->CurrentValue, $this->serie->formatPattern());
                    }
                }
            } else {
                $this->serie->ViewValue = null;
            }

            // codcli
            $curVal = strval($this->codcli->CurrentValue);
            if ($curVal != "") {
                $this->codcli->ViewValue = $this->codcli->lookupCacheOption($curVal);
                if ($this->codcli->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->codcli->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->codcli->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $lookupFilter = $this->codcli->getSelectFilter($this); // PHP
                    $sqlWrk = $this->codcli->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->codcli->Lookup->renderViewRow($rswrk[0]);
                        $this->codcli->ViewValue = $this->codcli->displayValue($arwrk);
                    } else {
                        $this->codcli->ViewValue = FormatNumber($this->codcli->CurrentValue, $this->codcli->formatPattern());
                    }
                }
            } else {
                $this->codcli->ViewValue = null;
            }

            // direccion
            $this->direccion->ViewValue = $this->direccion->CurrentValue;

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
                            $this->codpais->ViewValue = FormatNumber($this->codpais->CurrentValue, $this->codpais->formatPattern());
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

            // fecest
            $this->fecest->ViewValue = $this->fecest->CurrentValue;
            $this->fecest->ViewValue = FormatDateTime($this->fecest->ViewValue, $this->fecest->formatPattern());

            // fecreal
            $this->fecreal->ViewValue = $this->fecreal->CurrentValue;
            $this->fecreal->ViewValue = FormatDateTime($this->fecreal->ViewValue, $this->fecreal->formatPattern());

            // imptot
            $this->imptot->ViewValue = $this->imptot->CurrentValue;
            $this->imptot->ViewValue = FormatNumber($this->imptot->ViewValue, $this->imptot->formatPattern());

            // impbase
            $this->impbase->ViewValue = $this->impbase->CurrentValue;
            $this->impbase->ViewValue = FormatNumber($this->impbase->ViewValue, $this->impbase->formatPattern());

            // estado
            if (strval($this->estado->CurrentValue) != "") {
                $this->estado->ViewValue = new OptionValues();
                $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), strval($this->estado->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->estado->ViewValue->add($this->estado->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->estado->ViewValue = null;
            }

            // cantlotes
            $this->cantlotes->ViewValue = $this->cantlotes->CurrentValue;
            $this->cantlotes->ViewValue = FormatNumber($this->cantlotes->ViewValue, $this->cantlotes->formatPattern());

            // horaest
            $this->horaest->ViewValue = $this->horaest->CurrentValue;
            $this->horaest->ViewValue = FormatDateTime($this->horaest->ViewValue, $this->horaest->formatPattern());

            // horareal
            $this->horareal->ViewValue = $this->horareal->CurrentValue;
            $this->horareal->ViewValue = FormatDateTime($this->horareal->ViewValue, $this->horareal->formatPattern());

            // usuario
            $this->usuario->ViewValue = $this->usuario->CurrentValue;
            $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

            // fecalta
            $this->fecalta->ViewValue = $this->fecalta->CurrentValue;
            $this->fecalta->ViewValue = FormatDateTime($this->fecalta->ViewValue, $this->fecalta->formatPattern());

            // observacion
            $this->observacion->ViewValue = $this->observacion->CurrentValue;

            // tipoind
            $this->tipoind->ViewValue = $this->tipoind->CurrentValue;
            $this->tipoind->ViewValue = FormatNumber($this->tipoind->ViewValue, $this->tipoind->formatPattern());

            // sello
            if (strval($this->sello->CurrentValue) != "") {
                $this->sello->ViewValue = $this->sello->optionCaption($this->sello->CurrentValue);
            } else {
                $this->sello->ViewValue = null;
            }

            // plazoSAP
            if (strval($this->plazoSAP->CurrentValue) != "") {
                $this->plazoSAP->ViewValue = $this->plazoSAP->optionCaption($this->plazoSAP->CurrentValue);
            } else {
                $this->plazoSAP->ViewValue = null;
            }

            // usuarioultmod
            $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
            $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

            // fecultmod
            $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
            $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

            // servicios
            $this->servicios->ViewValue = $this->servicios->CurrentValue;
            $this->servicios->ViewValue = FormatNumber($this->servicios->ViewValue, $this->servicios->formatPattern());

            // gastos
            $this->gastos->ViewValue = $this->gastos->CurrentValue;
            $this->gastos->ViewValue = FormatNumber($this->gastos->ViewValue, $this->gastos->formatPattern());

            // tasa
            if (ConvertToBool($this->tasa->CurrentValue)) {
                $this->tasa->ViewValue = $this->tasa->tagCaption(1) != "" ? $this->tasa->tagCaption(1) : "Yes";
            } else {
                $this->tasa->ViewValue = $this->tasa->tagCaption(2) != "" ? $this->tasa->tagCaption(2) : "No";
            }

            // ncomp
            $this->ncomp->HrefValue = "";
            $this->ncomp->TooltipValue = "";

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // codcli
            $this->codcli->HrefValue = "";

            // direccion
            $this->direccion->HrefValue = "";

            // codpais
            $this->codpais->HrefValue = "";

            // codprov
            $this->codprov->HrefValue = "";

            // codloc
            $this->codloc->HrefValue = "";

            // fecest
            $this->fecest->HrefValue = "";

            // fecreal
            $this->fecreal->HrefValue = "";

            // imptot
            $this->imptot->HrefValue = "";

            // impbase
            $this->impbase->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // cantlotes
            $this->cantlotes->HrefValue = "";

            // horaest
            $this->horaest->HrefValue = "";

            // horareal
            $this->horareal->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";

            // observacion
            $this->observacion->HrefValue = "";

            // tipoind
            $this->tipoind->HrefValue = "";

            // sello
            $this->sello->HrefValue = "";

            // plazoSAP
            $this->plazoSAP->HrefValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";

            // servicios
            $this->servicios->HrefValue = "";

            // gastos
            $this->gastos->HrefValue = "";

            // tasa
            $this->tasa->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // ncomp
            $this->ncomp->setupEditAttributes();
            $this->ncomp->EditValue = $this->ncomp->CurrentValue;
            $this->ncomp->EditValue = FormatNumber($this->ncomp->EditValue, $this->ncomp->formatPattern());

            // tcomp
            $this->tcomp->setupEditAttributes();
            $curVal = trim(strval($this->tcomp->CurrentValue));
            if ($curVal != "") {
                $this->tcomp->ViewValue = $this->tcomp->lookupCacheOption($curVal);
            } else {
                $this->tcomp->ViewValue = $this->tcomp->Lookup !== null && is_array($this->tcomp->lookupOptions()) && count($this->tcomp->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tcomp->ViewValue !== null) { // Load from cache
                $this->tcomp->EditValue = array_values($this->tcomp->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tcomp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->tcomp->CurrentValue, $this->tcomp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $lookupFilter = $this->tcomp->getSelectFilter($this); // PHP
                $sqlWrk = $this->tcomp->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tcomp->EditValue = $arwrk;
            }
            $this->tcomp->PlaceHolder = RemoveHtml($this->tcomp->caption());

            // serie
            $this->serie->setupEditAttributes();
            $curVal = trim(strval($this->serie->CurrentValue));
            if ($curVal != "") {
                $this->serie->ViewValue = $this->serie->lookupCacheOption($curVal);
            } else {
                $this->serie->ViewValue = $this->serie->Lookup !== null && is_array($this->serie->lookupOptions()) && count($this->serie->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->serie->ViewValue !== null) { // Load from cache
                $this->serie->EditValue = array_values($this->serie->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->serie->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->serie->CurrentValue, $this->serie->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $lookupFilter = $this->serie->getSelectFilter($this); // PHP
                $sqlWrk = $this->serie->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->serie->EditValue = $arwrk;
            }
            $this->serie->PlaceHolder = RemoveHtml($this->serie->caption());

            // codcli
            $this->codcli->setupEditAttributes();
            $curVal = trim(strval($this->codcli->CurrentValue));
            if ($curVal != "") {
                $this->codcli->ViewValue = $this->codcli->lookupCacheOption($curVal);
            } else {
                $this->codcli->ViewValue = $this->codcli->Lookup !== null && is_array($this->codcli->lookupOptions()) && count($this->codcli->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->codcli->ViewValue !== null) { // Load from cache
                $this->codcli->EditValue = array_values($this->codcli->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->codcli->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->codcli->CurrentValue, $this->codcli->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $lookupFilter = $this->codcli->getSelectFilter($this); // PHP
                $sqlWrk = $this->codcli->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->codcli->EditValue = $arwrk;
            }
            $this->codcli->PlaceHolder = RemoveHtml($this->codcli->caption());

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

            // fecest
            $this->fecest->setupEditAttributes();
            $this->fecest->EditValue = HtmlEncode(FormatDateTime($this->fecest->CurrentValue, $this->fecest->formatPattern()));
            $this->fecest->PlaceHolder = RemoveHtml($this->fecest->caption());

            // fecreal
            $this->fecreal->setupEditAttributes();
            $this->fecreal->EditValue = HtmlEncode(FormatDateTime($this->fecreal->CurrentValue, $this->fecreal->formatPattern()));
            $this->fecreal->PlaceHolder = RemoveHtml($this->fecreal->caption());

            // imptot
            $this->imptot->setupEditAttributes();
            $this->imptot->CurrentValue = FormatNumber($this->imptot->CurrentValue, $this->imptot->formatPattern());
            if (strval($this->imptot->EditValue) != "" && is_numeric($this->imptot->EditValue)) {
                $this->imptot->EditValue = FormatNumber($this->imptot->EditValue, null);
            }

            // impbase
            $this->impbase->setupEditAttributes();
            $this->impbase->CurrentValue = FormatNumber($this->impbase->CurrentValue, $this->impbase->formatPattern());
            if (strval($this->impbase->EditValue) != "" && is_numeric($this->impbase->EditValue)) {
                $this->impbase->EditValue = FormatNumber($this->impbase->EditValue, null);
            }

            // estado
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // cantlotes
            $this->cantlotes->setupEditAttributes();
            $this->cantlotes->CurrentValue = FormatNumber($this->cantlotes->CurrentValue, $this->cantlotes->formatPattern());
            if (strval($this->cantlotes->EditValue) != "" && is_numeric($this->cantlotes->EditValue)) {
                $this->cantlotes->EditValue = FormatNumber($this->cantlotes->EditValue, null);
            }

            // horaest
            $this->horaest->setupEditAttributes();
            $this->horaest->CurrentValue = FormatDateTime($this->horaest->CurrentValue, $this->horaest->formatPattern());

            // horareal
            $this->horareal->setupEditAttributes();
            $this->horareal->EditValue = HtmlEncode(FormatDateTime($this->horareal->CurrentValue, $this->horareal->formatPattern()));
            $this->horareal->PlaceHolder = RemoveHtml($this->horareal->caption());

            // usuario

            // fecalta
            $this->fecalta->setupEditAttributes();
            $this->fecalta->EditValue = HtmlEncode(FormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern()));
            $this->fecalta->PlaceHolder = RemoveHtml($this->fecalta->caption());

            // observacion
            $this->observacion->setupEditAttributes();
            $this->observacion->EditValue = HtmlEncode($this->observacion->CurrentValue);
            $this->observacion->PlaceHolder = RemoveHtml($this->observacion->caption());

            // tipoind
            $this->tipoind->setupEditAttributes();
            $this->tipoind->EditValue = $this->tipoind->CurrentValue;
            $this->tipoind->PlaceHolder = RemoveHtml($this->tipoind->caption());
            if (strval($this->tipoind->EditValue) != "" && is_numeric($this->tipoind->EditValue)) {
                $this->tipoind->EditValue = FormatNumber($this->tipoind->EditValue, null);
            }

            // sello
            $this->sello->setupEditAttributes();
            $this->sello->EditValue = $this->sello->options(true);
            $this->sello->PlaceHolder = RemoveHtml($this->sello->caption());

            // plazoSAP
            $this->plazoSAP->setupEditAttributes();
            $this->plazoSAP->EditValue = $this->plazoSAP->options(true);
            $this->plazoSAP->PlaceHolder = RemoveHtml($this->plazoSAP->caption());

            // usuarioultmod

            // fecultmod

            // servicios
            $this->servicios->setupEditAttributes();
            $this->servicios->EditValue = $this->servicios->CurrentValue;
            $this->servicios->PlaceHolder = RemoveHtml($this->servicios->caption());
            if (strval($this->servicios->EditValue) != "" && is_numeric($this->servicios->EditValue)) {
                $this->servicios->EditValue = FormatNumber($this->servicios->EditValue, null);
            }

            // gastos
            $this->gastos->setupEditAttributes();
            $this->gastos->EditValue = $this->gastos->CurrentValue;
            $this->gastos->PlaceHolder = RemoveHtml($this->gastos->caption());
            if (strval($this->gastos->EditValue) != "" && is_numeric($this->gastos->EditValue)) {
                $this->gastos->EditValue = FormatNumber($this->gastos->EditValue, null);
            }

            // tasa
            $this->tasa->EditValue = $this->tasa->options(false);
            $this->tasa->PlaceHolder = RemoveHtml($this->tasa->caption());

            // Edit refer script

            // ncomp
            $this->ncomp->HrefValue = "";
            $this->ncomp->TooltipValue = "";

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // codcli
            $this->codcli->HrefValue = "";

            // direccion
            $this->direccion->HrefValue = "";

            // codpais
            $this->codpais->HrefValue = "";

            // codprov
            $this->codprov->HrefValue = "";

            // codloc
            $this->codloc->HrefValue = "";

            // fecest
            $this->fecest->HrefValue = "";

            // fecreal
            $this->fecreal->HrefValue = "";

            // imptot
            $this->imptot->HrefValue = "";

            // impbase
            $this->impbase->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // cantlotes
            $this->cantlotes->HrefValue = "";

            // horaest
            $this->horaest->HrefValue = "";

            // horareal
            $this->horareal->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";

            // observacion
            $this->observacion->HrefValue = "";

            // tipoind
            $this->tipoind->HrefValue = "";

            // sello
            $this->sello->HrefValue = "";

            // plazoSAP
            $this->plazoSAP->HrefValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";

            // servicios
            $this->servicios->HrefValue = "";

            // gastos
            $this->gastos->HrefValue = "";

            // tasa
            $this->tasa->HrefValue = "";
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
            if ($this->ncomp->Visible && $this->ncomp->Required) {
                if (!$this->ncomp->IsDetailKey && EmptyValue($this->ncomp->FormValue)) {
                    $this->ncomp->addErrorMessage(str_replace("%s", $this->ncomp->caption(), $this->ncomp->RequiredErrorMessage));
                }
            }
            if ($this->tcomp->Visible && $this->tcomp->Required) {
                if (!$this->tcomp->IsDetailKey && EmptyValue($this->tcomp->FormValue)) {
                    $this->tcomp->addErrorMessage(str_replace("%s", $this->tcomp->caption(), $this->tcomp->RequiredErrorMessage));
                }
            }
            if ($this->serie->Visible && $this->serie->Required) {
                if (!$this->serie->IsDetailKey && EmptyValue($this->serie->FormValue)) {
                    $this->serie->addErrorMessage(str_replace("%s", $this->serie->caption(), $this->serie->RequiredErrorMessage));
                }
            }
            if ($this->codcli->Visible && $this->codcli->Required) {
                if (!$this->codcli->IsDetailKey && EmptyValue($this->codcli->FormValue)) {
                    $this->codcli->addErrorMessage(str_replace("%s", $this->codcli->caption(), $this->codcli->RequiredErrorMessage));
                }
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
            if ($this->fecest->Visible && $this->fecest->Required) {
                if (!$this->fecest->IsDetailKey && EmptyValue($this->fecest->FormValue)) {
                    $this->fecest->addErrorMessage(str_replace("%s", $this->fecest->caption(), $this->fecest->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecest->FormValue, $this->fecest->formatPattern())) {
                $this->fecest->addErrorMessage($this->fecest->getErrorMessage(false));
            }
            if ($this->fecreal->Visible && $this->fecreal->Required) {
                if (!$this->fecreal->IsDetailKey && EmptyValue($this->fecreal->FormValue)) {
                    $this->fecreal->addErrorMessage(str_replace("%s", $this->fecreal->caption(), $this->fecreal->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecreal->FormValue, $this->fecreal->formatPattern())) {
                $this->fecreal->addErrorMessage($this->fecreal->getErrorMessage(false));
            }
            if ($this->imptot->Visible && $this->imptot->Required) {
                if (!$this->imptot->IsDetailKey && EmptyValue($this->imptot->FormValue)) {
                    $this->imptot->addErrorMessage(str_replace("%s", $this->imptot->caption(), $this->imptot->RequiredErrorMessage));
                }
            }
            if ($this->impbase->Visible && $this->impbase->Required) {
                if (!$this->impbase->IsDetailKey && EmptyValue($this->impbase->FormValue)) {
                    $this->impbase->addErrorMessage(str_replace("%s", $this->impbase->caption(), $this->impbase->RequiredErrorMessage));
                }
            }
            if ($this->estado->Visible && $this->estado->Required) {
                if ($this->estado->FormValue == "") {
                    $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
                }
            }
            if ($this->cantlotes->Visible && $this->cantlotes->Required) {
                if (!$this->cantlotes->IsDetailKey && EmptyValue($this->cantlotes->FormValue)) {
                    $this->cantlotes->addErrorMessage(str_replace("%s", $this->cantlotes->caption(), $this->cantlotes->RequiredErrorMessage));
                }
            }
            if ($this->horaest->Visible && $this->horaest->Required) {
                if (!$this->horaest->IsDetailKey && EmptyValue($this->horaest->FormValue)) {
                    $this->horaest->addErrorMessage(str_replace("%s", $this->horaest->caption(), $this->horaest->RequiredErrorMessage));
                }
            }
            if ($this->horareal->Visible && $this->horareal->Required) {
                if (!$this->horareal->IsDetailKey && EmptyValue($this->horareal->FormValue)) {
                    $this->horareal->addErrorMessage(str_replace("%s", $this->horareal->caption(), $this->horareal->RequiredErrorMessage));
                }
            }
            if (!CheckTime($this->horareal->FormValue, $this->horareal->formatPattern())) {
                $this->horareal->addErrorMessage($this->horareal->getErrorMessage(false));
            }
            if ($this->usuario->Visible && $this->usuario->Required) {
                if (!$this->usuario->IsDetailKey && EmptyValue($this->usuario->FormValue)) {
                    $this->usuario->addErrorMessage(str_replace("%s", $this->usuario->caption(), $this->usuario->RequiredErrorMessage));
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
            if ($this->observacion->Visible && $this->observacion->Required) {
                if (!$this->observacion->IsDetailKey && EmptyValue($this->observacion->FormValue)) {
                    $this->observacion->addErrorMessage(str_replace("%s", $this->observacion->caption(), $this->observacion->RequiredErrorMessage));
                }
            }
            if ($this->tipoind->Visible && $this->tipoind->Required) {
                if (!$this->tipoind->IsDetailKey && EmptyValue($this->tipoind->FormValue)) {
                    $this->tipoind->addErrorMessage(str_replace("%s", $this->tipoind->caption(), $this->tipoind->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->tipoind->FormValue)) {
                $this->tipoind->addErrorMessage($this->tipoind->getErrorMessage(false));
            }
            if ($this->sello->Visible && $this->sello->Required) {
                if (!$this->sello->IsDetailKey && EmptyValue($this->sello->FormValue)) {
                    $this->sello->addErrorMessage(str_replace("%s", $this->sello->caption(), $this->sello->RequiredErrorMessage));
                }
            }
            if ($this->plazoSAP->Visible && $this->plazoSAP->Required) {
                if (!$this->plazoSAP->IsDetailKey && EmptyValue($this->plazoSAP->FormValue)) {
                    $this->plazoSAP->addErrorMessage(str_replace("%s", $this->plazoSAP->caption(), $this->plazoSAP->RequiredErrorMessage));
                }
            }
            if ($this->usuarioultmod->Visible && $this->usuarioultmod->Required) {
                if (!$this->usuarioultmod->IsDetailKey && EmptyValue($this->usuarioultmod->FormValue)) {
                    $this->usuarioultmod->addErrorMessage(str_replace("%s", $this->usuarioultmod->caption(), $this->usuarioultmod->RequiredErrorMessage));
                }
            }
            if ($this->fecultmod->Visible && $this->fecultmod->Required) {
                if (!$this->fecultmod->IsDetailKey && EmptyValue($this->fecultmod->FormValue)) {
                    $this->fecultmod->addErrorMessage(str_replace("%s", $this->fecultmod->caption(), $this->fecultmod->RequiredErrorMessage));
                }
            }
            if ($this->servicios->Visible && $this->servicios->Required) {
                if (!$this->servicios->IsDetailKey && EmptyValue($this->servicios->FormValue)) {
                    $this->servicios->addErrorMessage(str_replace("%s", $this->servicios->caption(), $this->servicios->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->servicios->FormValue)) {
                $this->servicios->addErrorMessage($this->servicios->getErrorMessage(false));
            }
            if ($this->gastos->Visible && $this->gastos->Required) {
                if (!$this->gastos->IsDetailKey && EmptyValue($this->gastos->FormValue)) {
                    $this->gastos->addErrorMessage(str_replace("%s", $this->gastos->caption(), $this->gastos->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->gastos->FormValue)) {
                $this->gastos->addErrorMessage($this->gastos->getErrorMessage(false));
            }
            if ($this->tasa->Visible && $this->tasa->Required) {
                if ($this->tasa->FormValue == "") {
                    $this->tasa->addErrorMessage(str_replace("%s", $this->tasa->caption(), $this->tasa->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("LotesGrid");
        if (in_array("lotes", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

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

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("LotesGrid");
            if (in_array("lotes", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "lotes"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }

            // Commit/Rollback transaction
            if ($this->getCurrentDetailTable() != "") {
                if ($editRow) {
                    if ($this->UseTransaction) { // Commit transaction
                        if ($conn->isTransactionActive()) {
                            $conn->commit();
                        }
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        if ($conn->isTransactionActive()) {
                            $conn->rollback();
                        }
                    }
                }
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

        // tcomp
        $this->tcomp->setDbValueDef($rsnew, $this->tcomp->CurrentValue, $this->tcomp->ReadOnly);

        // serie
        $this->serie->setDbValueDef($rsnew, $this->serie->CurrentValue, $this->serie->ReadOnly);

        // codcli
        $this->codcli->setDbValueDef($rsnew, $this->codcli->CurrentValue, $this->codcli->ReadOnly);

        // direccion
        $this->direccion->setDbValueDef($rsnew, $this->direccion->CurrentValue, $this->direccion->ReadOnly);

        // codpais
        $this->codpais->setDbValueDef($rsnew, $this->codpais->CurrentValue, $this->codpais->ReadOnly);

        // codprov
        $this->codprov->setDbValueDef($rsnew, $this->codprov->CurrentValue, $this->codprov->ReadOnly);

        // codloc
        $this->codloc->setDbValueDef($rsnew, $this->codloc->CurrentValue, $this->codloc->ReadOnly);

        // fecest
        $this->fecest->setDbValueDef($rsnew, UnFormatDateTime($this->fecest->CurrentValue, $this->fecest->formatPattern()), $this->fecest->ReadOnly);

        // fecreal
        $this->fecreal->setDbValueDef($rsnew, UnFormatDateTime($this->fecreal->CurrentValue, $this->fecreal->formatPattern()), $this->fecreal->ReadOnly);

        // imptot
        $this->imptot->setDbValueDef($rsnew, $this->imptot->CurrentValue, $this->imptot->ReadOnly);

        // impbase
        $this->impbase->setDbValueDef($rsnew, $this->impbase->CurrentValue, $this->impbase->ReadOnly);

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, $this->estado->ReadOnly);

        // cantlotes
        $this->cantlotes->setDbValueDef($rsnew, $this->cantlotes->CurrentValue, $this->cantlotes->ReadOnly);

        // horaest
        $this->horaest->setDbValueDef($rsnew, UnFormatDateTime($this->horaest->CurrentValue, $this->horaest->formatPattern()), $this->horaest->ReadOnly);

        // horareal
        $this->horareal->setDbValueDef($rsnew, UnFormatDateTime($this->horareal->CurrentValue, $this->horareal->formatPattern()), $this->horareal->ReadOnly);

        // usuario
        $this->usuario->CurrentValue = $this->usuario->getAutoUpdateValue(); // PHP
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue, $this->usuario->ReadOnly);

        // fecalta
        $this->fecalta->setDbValueDef($rsnew, UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern()), $this->fecalta->ReadOnly);

        // observacion
        $this->observacion->setDbValueDef($rsnew, $this->observacion->CurrentValue, $this->observacion->ReadOnly);

        // tipoind
        $this->tipoind->setDbValueDef($rsnew, $this->tipoind->CurrentValue, $this->tipoind->ReadOnly);

        // sello
        $this->sello->setDbValueDef($rsnew, $this->sello->CurrentValue, $this->sello->ReadOnly);

        // plazoSAP
        $this->plazoSAP->setDbValueDef($rsnew, $this->plazoSAP->CurrentValue, $this->plazoSAP->ReadOnly);

        // usuarioultmod
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->getAutoUpdateValue(); // PHP
        $this->usuarioultmod->setDbValueDef($rsnew, $this->usuarioultmod->CurrentValue, $this->usuarioultmod->ReadOnly);

        // fecultmod
        $this->fecultmod->CurrentValue = $this->fecultmod->getAutoUpdateValue(); // PHP
        $this->fecultmod->setDbValueDef($rsnew, UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern()), $this->fecultmod->ReadOnly);

        // servicios
        $this->servicios->setDbValueDef($rsnew, $this->servicios->CurrentValue, $this->servicios->ReadOnly);

        // gastos
        $this->gastos->setDbValueDef($rsnew, $this->gastos->CurrentValue, $this->gastos->ReadOnly);

        // tasa
        $tmpBool = $this->tasa->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->tasa->setDbValueDef($rsnew, $tmpBool, $this->tasa->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['tcomp'])) { // tcomp
            $this->tcomp->CurrentValue = $row['tcomp'];
        }
        if (isset($row['serie'])) { // serie
            $this->serie->CurrentValue = $row['serie'];
        }
        if (isset($row['codcli'])) { // codcli
            $this->codcli->CurrentValue = $row['codcli'];
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
        if (isset($row['fecest'])) { // fecest
            $this->fecest->CurrentValue = $row['fecest'];
        }
        if (isset($row['fecreal'])) { // fecreal
            $this->fecreal->CurrentValue = $row['fecreal'];
        }
        if (isset($row['imptot'])) { // imptot
            $this->imptot->CurrentValue = $row['imptot'];
        }
        if (isset($row['impbase'])) { // impbase
            $this->impbase->CurrentValue = $row['impbase'];
        }
        if (isset($row['estado'])) { // estado
            $this->estado->CurrentValue = $row['estado'];
        }
        if (isset($row['cantlotes'])) { // cantlotes
            $this->cantlotes->CurrentValue = $row['cantlotes'];
        }
        if (isset($row['horaest'])) { // horaest
            $this->horaest->CurrentValue = $row['horaest'];
        }
        if (isset($row['horareal'])) { // horareal
            $this->horareal->CurrentValue = $row['horareal'];
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->CurrentValue = $row['usuario'];
        }
        if (isset($row['fecalta'])) { // fecalta
            $this->fecalta->CurrentValue = $row['fecalta'];
        }
        if (isset($row['observacion'])) { // observacion
            $this->observacion->CurrentValue = $row['observacion'];
        }
        if (isset($row['tipoind'])) { // tipoind
            $this->tipoind->CurrentValue = $row['tipoind'];
        }
        if (isset($row['sello'])) { // sello
            $this->sello->CurrentValue = $row['sello'];
        }
        if (isset($row['plazoSAP'])) { // plazoSAP
            $this->plazoSAP->CurrentValue = $row['plazoSAP'];
        }
        if (isset($row['usuarioultmod'])) { // usuarioultmod
            $this->usuarioultmod->CurrentValue = $row['usuarioultmod'];
        }
        if (isset($row['fecultmod'])) { // fecultmod
            $this->fecultmod->CurrentValue = $row['fecultmod'];
        }
        if (isset($row['servicios'])) { // servicios
            $this->servicios->CurrentValue = $row['servicios'];
        }
        if (isset($row['gastos'])) { // gastos
            $this->gastos->CurrentValue = $row['gastos'];
        }
        if (isset($row['tasa'])) { // tasa
            $this->tasa->CurrentValue = $row['tasa'];
        }
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("lotes", $detailTblVar)) {
                $detailPageObj = Container("LotesGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->codrem->IsDetailKey = true;
                    $detailPageObj->codrem->CurrentValue = $this->ncomp->CurrentValue;
                    $detailPageObj->codrem->setSessionValue($detailPageObj->codrem->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("RematesList"), "", $this->TableVar, true);
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
                case "x_tcomp":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_serie":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_codcli":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_codpais":
                    break;
                case "x_codprov":
                    break;
                case "x_codloc":
                    break;
                case "x_estado":
                    break;
                case "x_sello":
                    break;
                case "x_plazoSAP":
                    break;
                case "x_tasa":
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
