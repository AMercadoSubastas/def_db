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
class LotesEdit extends Lotes
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "LotesEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "LotesEdit";

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
        $this->codrem->setVisibility();
        $this->codcli->setVisibility();
        $this->codrubro->setVisibility();
        $this->estado->setVisibility();
        $this->moneda->setVisibility();
        $this->preciobase->setVisibility();
        $this->preciofinal->setVisibility();
        $this->comiscobr->setVisibility();
        $this->comispag->setVisibility();
        $this->comprador->setVisibility();
        $this->ivari->setVisibility();
        $this->ivarni->setVisibility();
        $this->codimpadic->setVisibility();
        $this->impadic->setVisibility();
        $this->descripcion->setVisibility();
        $this->descor->setVisibility();
        $this->observ->setVisibility();
        $this->usuario->setVisibility();
        $this->fecalta->setVisibility();
        $this->secuencia->Visible = false;
        $this->codintlote->setVisibility();
        $this->codintnum->setVisibility();
        $this->codintsublote->setVisibility();
        $this->usuarioultmod->setVisibility();
        $this->fecultmod->setVisibility();
        $this->dir_secuencia->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'lotes';
        $this->TableName = 'lotes';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (lotes)
        if (!isset($GLOBALS["lotes"]) || $GLOBALS["lotes"]::class == PROJECT_NAMESPACE . "lotes") {
            $GLOBALS["lotes"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'lotes');
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
                        $result["view"] = SameString($pageName, "LotesView"); // If View page, no primary button
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
    public $MultiPages; // Multi pages object

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
        $this->codrem->Required = false;
        $this->codintlote->Required = false;

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up multi page object
        $this->setupMultiPages();

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
        $this->setupLookupOptions($this->estado);
        $this->setupLookupOptions($this->dir_secuencia);

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

            // Set up master detail parameters
            $this->setupMasterParms();

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
                        $this->terminate("LotesList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "LotesList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "LotesList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "LotesList"; // Return list page content
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

        // Check field name 'codrem' first before field var 'x_codrem'
        $val = $CurrentForm->hasValue("codrem") ? $CurrentForm->getValue("codrem") : $CurrentForm->getValue("x_codrem");
        if (!$this->codrem->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codrem->Visible = false; // Disable update for API request
            } else {
                $this->codrem->setFormValue($val);
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

        // Check field name 'codrubro' first before field var 'x_codrubro'
        $val = $CurrentForm->hasValue("codrubro") ? $CurrentForm->getValue("codrubro") : $CurrentForm->getValue("x_codrubro");
        if (!$this->codrubro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codrubro->Visible = false; // Disable update for API request
            } else {
                $this->codrubro->setFormValue($val);
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

        // Check field name 'moneda' first before field var 'x_moneda'
        $val = $CurrentForm->hasValue("moneda") ? $CurrentForm->getValue("moneda") : $CurrentForm->getValue("x_moneda");
        if (!$this->moneda->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->moneda->Visible = false; // Disable update for API request
            } else {
                $this->moneda->setFormValue($val);
            }
        }

        // Check field name 'preciobase' first before field var 'x_preciobase'
        $val = $CurrentForm->hasValue("preciobase") ? $CurrentForm->getValue("preciobase") : $CurrentForm->getValue("x_preciobase");
        if (!$this->preciobase->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->preciobase->Visible = false; // Disable update for API request
            } else {
                $this->preciobase->setFormValue($val);
            }
        }

        // Check field name 'preciofinal' first before field var 'x_preciofinal'
        $val = $CurrentForm->hasValue("preciofinal") ? $CurrentForm->getValue("preciofinal") : $CurrentForm->getValue("x_preciofinal");
        if (!$this->preciofinal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->preciofinal->Visible = false; // Disable update for API request
            } else {
                $this->preciofinal->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'comiscobr' first before field var 'x_comiscobr'
        $val = $CurrentForm->hasValue("comiscobr") ? $CurrentForm->getValue("comiscobr") : $CurrentForm->getValue("x_comiscobr");
        if (!$this->comiscobr->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->comiscobr->Visible = false; // Disable update for API request
            } else {
                $this->comiscobr->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'comispag' first before field var 'x_comispag'
        $val = $CurrentForm->hasValue("comispag") ? $CurrentForm->getValue("comispag") : $CurrentForm->getValue("x_comispag");
        if (!$this->comispag->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->comispag->Visible = false; // Disable update for API request
            } else {
                $this->comispag->setFormValue($val);
            }
        }

        // Check field name 'comprador' first before field var 'x_comprador'
        $val = $CurrentForm->hasValue("comprador") ? $CurrentForm->getValue("comprador") : $CurrentForm->getValue("x_comprador");
        if (!$this->comprador->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->comprador->Visible = false; // Disable update for API request
            } else {
                $this->comprador->setFormValue($val);
            }
        }

        // Check field name 'ivari' first before field var 'x_ivari'
        $val = $CurrentForm->hasValue("ivari") ? $CurrentForm->getValue("ivari") : $CurrentForm->getValue("x_ivari");
        if (!$this->ivari->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ivari->Visible = false; // Disable update for API request
            } else {
                $this->ivari->setFormValue($val);
            }
        }

        // Check field name 'ivarni' first before field var 'x_ivarni'
        $val = $CurrentForm->hasValue("ivarni") ? $CurrentForm->getValue("ivarni") : $CurrentForm->getValue("x_ivarni");
        if (!$this->ivarni->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ivarni->Visible = false; // Disable update for API request
            } else {
                $this->ivarni->setFormValue($val);
            }
        }

        // Check field name 'codimpadic' first before field var 'x_codimpadic'
        $val = $CurrentForm->hasValue("codimpadic") ? $CurrentForm->getValue("codimpadic") : $CurrentForm->getValue("x_codimpadic");
        if (!$this->codimpadic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codimpadic->Visible = false; // Disable update for API request
            } else {
                $this->codimpadic->setFormValue($val);
            }
        }

        // Check field name 'impadic' first before field var 'x_impadic'
        $val = $CurrentForm->hasValue("impadic") ? $CurrentForm->getValue("impadic") : $CurrentForm->getValue("x_impadic");
        if (!$this->impadic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->impadic->Visible = false; // Disable update for API request
            } else {
                $this->impadic->setFormValue($val);
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

        // Check field name 'descor' first before field var 'x_descor'
        $val = $CurrentForm->hasValue("descor") ? $CurrentForm->getValue("descor") : $CurrentForm->getValue("x_descor");
        if (!$this->descor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descor->Visible = false; // Disable update for API request
            } else {
                $this->descor->setFormValue($val);
            }
        }

        // Check field name 'observ' first before field var 'x_observ'
        $val = $CurrentForm->hasValue("observ") ? $CurrentForm->getValue("observ") : $CurrentForm->getValue("x_observ");
        if (!$this->observ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->observ->Visible = false; // Disable update for API request
            } else {
                $this->observ->setFormValue($val);
            }
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
                $this->fecalta->setFormValue($val);
            }
            $this->fecalta->CurrentValue = UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern());
        }

        // Check field name 'codintlote' first before field var 'x_codintlote'
        $val = $CurrentForm->hasValue("codintlote") ? $CurrentForm->getValue("codintlote") : $CurrentForm->getValue("x_codintlote");
        if (!$this->codintlote->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codintlote->Visible = false; // Disable update for API request
            } else {
                $this->codintlote->setFormValue($val);
            }
        }

        // Check field name 'codintnum' first before field var 'x_codintnum'
        $val = $CurrentForm->hasValue("codintnum") ? $CurrentForm->getValue("codintnum") : $CurrentForm->getValue("x_codintnum");
        if (!$this->codintnum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codintnum->Visible = false; // Disable update for API request
            } else {
                $this->codintnum->setFormValue($val);
            }
        }

        // Check field name 'codintsublote' first before field var 'x_codintsublote'
        $val = $CurrentForm->hasValue("codintsublote") ? $CurrentForm->getValue("codintsublote") : $CurrentForm->getValue("x_codintsublote");
        if (!$this->codintsublote->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codintsublote->Visible = false; // Disable update for API request
            } else {
                $this->codintsublote->setFormValue($val);
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

        // Check field name 'dir_secuencia' first before field var 'x_dir_secuencia'
        $val = $CurrentForm->hasValue("dir_secuencia") ? $CurrentForm->getValue("dir_secuencia") : $CurrentForm->getValue("x_dir_secuencia");
        if (!$this->dir_secuencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dir_secuencia->Visible = false; // Disable update for API request
            } else {
                $this->dir_secuencia->setFormValue($val);
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
        $this->codrem->CurrentValue = $this->codrem->FormValue;
        $this->codcli->CurrentValue = $this->codcli->FormValue;
        $this->codrubro->CurrentValue = $this->codrubro->FormValue;
        $this->estado->CurrentValue = $this->estado->FormValue;
        $this->moneda->CurrentValue = $this->moneda->FormValue;
        $this->preciobase->CurrentValue = $this->preciobase->FormValue;
        $this->preciofinal->CurrentValue = $this->preciofinal->FormValue;
        $this->comiscobr->CurrentValue = $this->comiscobr->FormValue;
        $this->comispag->CurrentValue = $this->comispag->FormValue;
        $this->comprador->CurrentValue = $this->comprador->FormValue;
        $this->ivari->CurrentValue = $this->ivari->FormValue;
        $this->ivarni->CurrentValue = $this->ivarni->FormValue;
        $this->codimpadic->CurrentValue = $this->codimpadic->FormValue;
        $this->impadic->CurrentValue = $this->impadic->FormValue;
        $this->descripcion->CurrentValue = $this->descripcion->FormValue;
        $this->descor->CurrentValue = $this->descor->FormValue;
        $this->observ->CurrentValue = $this->observ->FormValue;
        $this->usuario->CurrentValue = $this->usuario->FormValue;
        $this->fecalta->CurrentValue = $this->fecalta->FormValue;
        $this->fecalta->CurrentValue = UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern());
        $this->codintlote->CurrentValue = $this->codintlote->FormValue;
        $this->codintnum->CurrentValue = $this->codintnum->FormValue;
        $this->codintsublote->CurrentValue = $this->codintsublote->FormValue;
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->FormValue;
        $this->fecultmod->CurrentValue = $this->fecultmod->FormValue;
        $this->fecultmod->CurrentValue = UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern());
        $this->dir_secuencia->CurrentValue = $this->dir_secuencia->FormValue;
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
        $this->codrem->setDbValue($row['codrem']);
        $this->codcli->setDbValue($row['codcli']);
        $this->codrubro->setDbValue($row['codrubro']);
        $this->estado->setDbValue($row['estado']);
        $this->moneda->setDbValue($row['moneda']);
        $this->preciobase->setDbValue($row['preciobase']);
        $this->preciofinal->setDbValue($row['preciofinal']);
        $this->comiscobr->setDbValue($row['comiscobr']);
        $this->comispag->setDbValue($row['comispag']);
        $this->comprador->setDbValue($row['comprador']);
        $this->ivari->setDbValue($row['ivari']);
        $this->ivarni->setDbValue($row['ivarni']);
        $this->codimpadic->setDbValue($row['codimpadic']);
        $this->impadic->setDbValue($row['impadic']);
        $this->descripcion->setDbValue($row['descripcion']);
        $this->descor->setDbValue($row['descor']);
        $this->observ->setDbValue($row['observ']);
        $this->usuario->setDbValue($row['usuario']);
        $this->fecalta->setDbValue($row['fecalta']);
        $this->secuencia->setDbValue($row['secuencia']);
        $this->codintlote->setDbValue($row['codintlote']);
        $this->codintnum->setDbValue($row['codintnum']);
        $this->codintsublote->setDbValue($row['codintsublote']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
        $this->dir_secuencia->setDbValue($row['dir_secuencia']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['codrem'] = $this->codrem->DefaultValue;
        $row['codcli'] = $this->codcli->DefaultValue;
        $row['codrubro'] = $this->codrubro->DefaultValue;
        $row['estado'] = $this->estado->DefaultValue;
        $row['moneda'] = $this->moneda->DefaultValue;
        $row['preciobase'] = $this->preciobase->DefaultValue;
        $row['preciofinal'] = $this->preciofinal->DefaultValue;
        $row['comiscobr'] = $this->comiscobr->DefaultValue;
        $row['comispag'] = $this->comispag->DefaultValue;
        $row['comprador'] = $this->comprador->DefaultValue;
        $row['ivari'] = $this->ivari->DefaultValue;
        $row['ivarni'] = $this->ivarni->DefaultValue;
        $row['codimpadic'] = $this->codimpadic->DefaultValue;
        $row['impadic'] = $this->impadic->DefaultValue;
        $row['descripcion'] = $this->descripcion->DefaultValue;
        $row['descor'] = $this->descor->DefaultValue;
        $row['observ'] = $this->observ->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['fecalta'] = $this->fecalta->DefaultValue;
        $row['secuencia'] = $this->secuencia->DefaultValue;
        $row['codintlote'] = $this->codintlote->DefaultValue;
        $row['codintnum'] = $this->codintnum->DefaultValue;
        $row['codintsublote'] = $this->codintsublote->DefaultValue;
        $row['usuarioultmod'] = $this->usuarioultmod->DefaultValue;
        $row['fecultmod'] = $this->fecultmod->DefaultValue;
        $row['dir_secuencia'] = $this->dir_secuencia->DefaultValue;
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

        // codrem
        $this->codrem->RowCssClass = "row";

        // codcli
        $this->codcli->RowCssClass = "row";

        // codrubro
        $this->codrubro->RowCssClass = "row";

        // estado
        $this->estado->RowCssClass = "row";

        // moneda
        $this->moneda->RowCssClass = "row";

        // preciobase
        $this->preciobase->RowCssClass = "row";

        // preciofinal
        $this->preciofinal->RowCssClass = "row";

        // comiscobr
        $this->comiscobr->RowCssClass = "row";

        // comispag
        $this->comispag->RowCssClass = "row";

        // comprador
        $this->comprador->RowCssClass = "row";

        // ivari
        $this->ivari->RowCssClass = "row";

        // ivarni
        $this->ivarni->RowCssClass = "row";

        // codimpadic
        $this->codimpadic->RowCssClass = "row";

        // impadic
        $this->impadic->RowCssClass = "row";

        // descripcion
        $this->descripcion->RowCssClass = "row";

        // descor
        $this->descor->RowCssClass = "row";

        // observ
        $this->observ->RowCssClass = "row";

        // usuario
        $this->usuario->RowCssClass = "row";

        // fecalta
        $this->fecalta->RowCssClass = "row";

        // secuencia
        $this->secuencia->RowCssClass = "row";

        // codintlote
        $this->codintlote->RowCssClass = "row";

        // codintnum
        $this->codintnum->RowCssClass = "row";

        // codintsublote
        $this->codintsublote->RowCssClass = "row";

        // usuarioultmod
        $this->usuarioultmod->RowCssClass = "row";

        // fecultmod
        $this->fecultmod->RowCssClass = "row";

        // dir_secuencia
        $this->dir_secuencia->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // codnum
            $this->codnum->ViewValue = $this->codnum->CurrentValue;

            // codrem
            $this->codrem->ViewValue = $this->codrem->CurrentValue;
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

            // codcli
            $this->codcli->ViewValue = $this->codcli->CurrentValue;
            $this->codcli->ViewValue = FormatNumber($this->codcli->ViewValue, $this->codcli->formatPattern());

            // codrubro
            $this->codrubro->ViewValue = $this->codrubro->CurrentValue;
            $this->codrubro->ViewValue = FormatNumber($this->codrubro->ViewValue, $this->codrubro->formatPattern());

            // estado
            if (strval($this->estado->CurrentValue) != "") {
                $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
            } else {
                $this->estado->ViewValue = null;
            }

            // moneda
            $this->moneda->ViewValue = $this->moneda->CurrentValue;
            $this->moneda->ViewValue = FormatNumber($this->moneda->ViewValue, $this->moneda->formatPattern());

            // preciobase
            $this->preciobase->ViewValue = $this->preciobase->CurrentValue;
            $this->preciobase->ViewValue = FormatNumber($this->preciobase->ViewValue, $this->preciobase->formatPattern());

            // preciofinal
            $this->preciofinal->ViewValue = $this->preciofinal->CurrentValue;
            $this->preciofinal->ViewValue = FormatNumber($this->preciofinal->ViewValue, $this->preciofinal->formatPattern());

            // comiscobr
            $this->comiscobr->ViewValue = $this->comiscobr->CurrentValue;
            $this->comiscobr->ViewValue = FormatNumber($this->comiscobr->ViewValue, $this->comiscobr->formatPattern());

            // comispag
            $this->comispag->ViewValue = $this->comispag->CurrentValue;
            $this->comispag->ViewValue = FormatNumber($this->comispag->ViewValue, $this->comispag->formatPattern());

            // comprador
            $this->comprador->ViewValue = $this->comprador->CurrentValue;
            $this->comprador->ViewValue = FormatNumber($this->comprador->ViewValue, $this->comprador->formatPattern());

            // ivari
            $this->ivari->ViewValue = $this->ivari->CurrentValue;
            $this->ivari->ViewValue = FormatNumber($this->ivari->ViewValue, $this->ivari->formatPattern());

            // ivarni
            $this->ivarni->ViewValue = $this->ivarni->CurrentValue;
            $this->ivarni->ViewValue = FormatNumber($this->ivarni->ViewValue, $this->ivarni->formatPattern());

            // codimpadic
            $this->codimpadic->ViewValue = $this->codimpadic->CurrentValue;
            $this->codimpadic->ViewValue = FormatNumber($this->codimpadic->ViewValue, $this->codimpadic->formatPattern());

            // impadic
            $this->impadic->ViewValue = $this->impadic->CurrentValue;
            $this->impadic->ViewValue = FormatNumber($this->impadic->ViewValue, $this->impadic->formatPattern());

            // descripcion
            $this->descripcion->ViewValue = $this->descripcion->CurrentValue;

            // descor
            $this->descor->ViewValue = $this->descor->CurrentValue;

            // observ
            $this->observ->ViewValue = $this->observ->CurrentValue;

            // usuario
            $this->usuario->ViewValue = $this->usuario->CurrentValue;
            $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

            // fecalta
            $this->fecalta->ViewValue = $this->fecalta->CurrentValue;
            $this->fecalta->ViewValue = FormatDateTime($this->fecalta->ViewValue, $this->fecalta->formatPattern());

            // secuencia
            $this->secuencia->ViewValue = $this->secuencia->CurrentValue;
            $this->secuencia->ViewValue = FormatNumber($this->secuencia->ViewValue, $this->secuencia->formatPattern());

            // codintlote
            $this->codintlote->ViewValue = $this->codintlote->CurrentValue;

            // codintnum
            $this->codintnum->ViewValue = $this->codintnum->CurrentValue;
            $this->codintnum->ViewValue = FormatNumber($this->codintnum->ViewValue, $this->codintnum->formatPattern());

            // codintsublote
            $this->codintsublote->ViewValue = $this->codintsublote->CurrentValue;

            // usuarioultmod
            $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
            $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

            // fecultmod
            $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
            $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

            // dir_secuencia
            $curVal = strval($this->dir_secuencia->CurrentValue);
            if ($curVal != "") {
                $this->dir_secuencia->ViewValue = $this->dir_secuencia->lookupCacheOption($curVal);
                if ($this->dir_secuencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->dir_secuencia->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->dir_secuencia->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->dir_secuencia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->dir_secuencia->Lookup->renderViewRow($rswrk[0]);
                        $this->dir_secuencia->ViewValue = $this->dir_secuencia->displayValue($arwrk);
                    } else {
                        $this->dir_secuencia->ViewValue = FormatNumber($this->dir_secuencia->CurrentValue, $this->dir_secuencia->formatPattern());
                    }
                }
            } else {
                $this->dir_secuencia->ViewValue = null;
            }

            // codrem
            $this->codrem->HrefValue = "";
            $this->codrem->TooltipValue = "";

            // codcli
            $this->codcli->HrefValue = "";

            // codrubro
            $this->codrubro->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // moneda
            $this->moneda->HrefValue = "";

            // preciobase
            $this->preciobase->HrefValue = "";

            // preciofinal
            $this->preciofinal->HrefValue = "";

            // comiscobr
            $this->comiscobr->HrefValue = "";

            // comispag
            $this->comispag->HrefValue = "";

            // comprador
            $this->comprador->HrefValue = "";

            // ivari
            $this->ivari->HrefValue = "";

            // ivarni
            $this->ivarni->HrefValue = "";

            // codimpadic
            $this->codimpadic->HrefValue = "";

            // impadic
            $this->impadic->HrefValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";

            // descor
            $this->descor->HrefValue = "";

            // observ
            $this->observ->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";

            // codintlote
            $this->codintlote->HrefValue = "";
            $this->codintlote->TooltipValue = "";

            // codintnum
            $this->codintnum->HrefValue = "";

            // codintsublote
            $this->codintsublote->HrefValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";

            // dir_secuencia
            $this->dir_secuencia->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // codrem
            $this->codrem->setupEditAttributes();
            $this->codrem->EditValue = $this->codrem->CurrentValue;
            $curVal = strval($this->codrem->CurrentValue);
            if ($curVal != "") {
                $this->codrem->EditValue = $this->codrem->lookupCacheOption($curVal);
                if ($this->codrem->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->codrem->Lookup->getTable()->Fields["ncomp"]->searchExpression(), "=", $curVal, $this->codrem->Lookup->getTable()->Fields["ncomp"]->searchDataType(), "");
                    $sqlWrk = $this->codrem->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->codrem->Lookup->renderViewRow($rswrk[0]);
                        $this->codrem->EditValue = $this->codrem->displayValue($arwrk);
                    } else {
                        $this->codrem->EditValue = FormatNumber($this->codrem->CurrentValue, $this->codrem->formatPattern());
                    }
                }
            } else {
                $this->codrem->EditValue = null;
            }

            // codcli
            $this->codcli->setupEditAttributes();
            $this->codcli->CurrentValue = FormatNumber($this->codcli->CurrentValue, $this->codcli->formatPattern());
            if (strval($this->codcli->EditValue) != "" && is_numeric($this->codcli->EditValue)) {
                $this->codcli->EditValue = FormatNumber($this->codcli->EditValue, null);
            }

            // codrubro
            $this->codrubro->setupEditAttributes();
            $this->codrubro->CurrentValue = FormatNumber($this->codrubro->CurrentValue, $this->codrubro->formatPattern());
            if (strval($this->codrubro->EditValue) != "" && is_numeric($this->codrubro->EditValue)) {
                $this->codrubro->EditValue = FormatNumber($this->codrubro->EditValue, null);
            }

            // estado
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // moneda
            $this->moneda->setupEditAttributes();
            $this->moneda->CurrentValue = FormatNumber($this->moneda->CurrentValue, $this->moneda->formatPattern());
            if (strval($this->moneda->EditValue) != "" && is_numeric($this->moneda->EditValue)) {
                $this->moneda->EditValue = FormatNumber($this->moneda->EditValue, null);
            }

            // preciobase
            $this->preciobase->setupEditAttributes();
            $this->preciobase->CurrentValue = FormatNumber($this->preciobase->CurrentValue, $this->preciobase->formatPattern());
            if (strval($this->preciobase->EditValue) != "" && is_numeric($this->preciobase->EditValue)) {
                $this->preciobase->EditValue = FormatNumber($this->preciobase->EditValue, null);
            }

            // preciofinal
            $this->preciofinal->setupEditAttributes();
            $this->preciofinal->EditValue = $this->preciofinal->CurrentValue;
            $this->preciofinal->PlaceHolder = RemoveHtml($this->preciofinal->caption());
            if (strval($this->preciofinal->EditValue) != "" && is_numeric($this->preciofinal->EditValue)) {
                $this->preciofinal->EditValue = FormatNumber($this->preciofinal->EditValue, null);
            }

            // comiscobr
            $this->comiscobr->setupEditAttributes();
            $this->comiscobr->EditValue = $this->comiscobr->CurrentValue;
            $this->comiscobr->PlaceHolder = RemoveHtml($this->comiscobr->caption());
            if (strval($this->comiscobr->EditValue) != "" && is_numeric($this->comiscobr->EditValue)) {
                $this->comiscobr->EditValue = FormatNumber($this->comiscobr->EditValue, null);
            }

            // comispag
            $this->comispag->setupEditAttributes();
            $this->comispag->CurrentValue = FormatNumber($this->comispag->CurrentValue, $this->comispag->formatPattern());
            if (strval($this->comispag->EditValue) != "" && is_numeric($this->comispag->EditValue)) {
                $this->comispag->EditValue = FormatNumber($this->comispag->EditValue, null);
            }

            // comprador
            $this->comprador->setupEditAttributes();
            $this->comprador->CurrentValue = FormatNumber($this->comprador->CurrentValue, $this->comprador->formatPattern());
            if (strval($this->comprador->EditValue) != "" && is_numeric($this->comprador->EditValue)) {
                $this->comprador->EditValue = FormatNumber($this->comprador->EditValue, null);
            }

            // ivari
            $this->ivari->setupEditAttributes();
            $this->ivari->CurrentValue = FormatNumber($this->ivari->CurrentValue, $this->ivari->formatPattern());
            if (strval($this->ivari->EditValue) != "" && is_numeric($this->ivari->EditValue)) {
                $this->ivari->EditValue = FormatNumber($this->ivari->EditValue, null);
            }

            // ivarni
            $this->ivarni->setupEditAttributes();
            $this->ivarni->CurrentValue = FormatNumber($this->ivarni->CurrentValue, $this->ivarni->formatPattern());
            if (strval($this->ivarni->EditValue) != "" && is_numeric($this->ivarni->EditValue)) {
                $this->ivarni->EditValue = FormatNumber($this->ivarni->EditValue, null);
            }

            // codimpadic
            $this->codimpadic->setupEditAttributes();
            $this->codimpadic->CurrentValue = FormatNumber($this->codimpadic->CurrentValue, $this->codimpadic->formatPattern());
            if (strval($this->codimpadic->EditValue) != "" && is_numeric($this->codimpadic->EditValue)) {
                $this->codimpadic->EditValue = FormatNumber($this->codimpadic->EditValue, null);
            }

            // impadic
            $this->impadic->setupEditAttributes();
            $this->impadic->CurrentValue = FormatNumber($this->impadic->CurrentValue, $this->impadic->formatPattern());
            if (strval($this->impadic->EditValue) != "" && is_numeric($this->impadic->EditValue)) {
                $this->impadic->EditValue = FormatNumber($this->impadic->EditValue, null);
            }

            // descripcion
            $this->descripcion->setupEditAttributes();
            $this->descripcion->EditValue = HtmlEncode($this->descripcion->CurrentValue);
            $this->descripcion->PlaceHolder = RemoveHtml($this->descripcion->caption());

            // descor
            $this->descor->setupEditAttributes();

            // observ
            $this->observ->setupEditAttributes();

            // usuario

            // fecalta

            // codintlote
            $this->codintlote->setupEditAttributes();
            $this->codintlote->EditValue = $this->codintlote->CurrentValue;

            // codintnum
            $this->codintnum->setupEditAttributes();
            $this->codintnum->CurrentValue = FormatNumber($this->codintnum->CurrentValue, $this->codintnum->formatPattern());
            if (strval($this->codintnum->EditValue) != "" && is_numeric($this->codintnum->EditValue)) {
                $this->codintnum->EditValue = FormatNumber($this->codintnum->EditValue, null);
            }

            // codintsublote
            $this->codintsublote->setupEditAttributes();

            // usuarioultmod

            // fecultmod

            // dir_secuencia
            $this->dir_secuencia->setupEditAttributes();
            $curVal = trim(strval($this->dir_secuencia->CurrentValue));
            if ($curVal != "") {
                $this->dir_secuencia->ViewValue = $this->dir_secuencia->lookupCacheOption($curVal);
            } else {
                $this->dir_secuencia->ViewValue = $this->dir_secuencia->Lookup !== null && is_array($this->dir_secuencia->lookupOptions()) && count($this->dir_secuencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->dir_secuencia->ViewValue !== null) { // Load from cache
                $this->dir_secuencia->EditValue = array_values($this->dir_secuencia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->dir_secuencia->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->dir_secuencia->CurrentValue, $this->dir_secuencia->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $sqlWrk = $this->dir_secuencia->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->dir_secuencia->EditValue = $arwrk;
            }
            $this->dir_secuencia->PlaceHolder = RemoveHtml($this->dir_secuencia->caption());

            // Edit refer script

            // codrem
            $this->codrem->HrefValue = "";
            $this->codrem->TooltipValue = "";

            // codcli
            $this->codcli->HrefValue = "";

            // codrubro
            $this->codrubro->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // moneda
            $this->moneda->HrefValue = "";

            // preciobase
            $this->preciobase->HrefValue = "";

            // preciofinal
            $this->preciofinal->HrefValue = "";

            // comiscobr
            $this->comiscobr->HrefValue = "";

            // comispag
            $this->comispag->HrefValue = "";

            // comprador
            $this->comprador->HrefValue = "";

            // ivari
            $this->ivari->HrefValue = "";

            // ivarni
            $this->ivarni->HrefValue = "";

            // codimpadic
            $this->codimpadic->HrefValue = "";

            // impadic
            $this->impadic->HrefValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";

            // descor
            $this->descor->HrefValue = "";

            // observ
            $this->observ->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";

            // codintlote
            $this->codintlote->HrefValue = "";
            $this->codintlote->TooltipValue = "";

            // codintnum
            $this->codintnum->HrefValue = "";

            // codintsublote
            $this->codintsublote->HrefValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";

            // dir_secuencia
            $this->dir_secuencia->HrefValue = "";
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
            if ($this->codrem->Visible && $this->codrem->Required) {
                if (!$this->codrem->IsDetailKey && EmptyValue($this->codrem->FormValue)) {
                    $this->codrem->addErrorMessage(str_replace("%s", $this->codrem->caption(), $this->codrem->RequiredErrorMessage));
                }
            }
            if ($this->codcli->Visible && $this->codcli->Required) {
                if (!$this->codcli->IsDetailKey && EmptyValue($this->codcli->FormValue)) {
                    $this->codcli->addErrorMessage(str_replace("%s", $this->codcli->caption(), $this->codcli->RequiredErrorMessage));
                }
            }
            if ($this->codrubro->Visible && $this->codrubro->Required) {
                if (!$this->codrubro->IsDetailKey && EmptyValue($this->codrubro->FormValue)) {
                    $this->codrubro->addErrorMessage(str_replace("%s", $this->codrubro->caption(), $this->codrubro->RequiredErrorMessage));
                }
            }
            if ($this->estado->Visible && $this->estado->Required) {
                if ($this->estado->FormValue == "") {
                    $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
                }
            }
            if ($this->moneda->Visible && $this->moneda->Required) {
                if (!$this->moneda->IsDetailKey && EmptyValue($this->moneda->FormValue)) {
                    $this->moneda->addErrorMessage(str_replace("%s", $this->moneda->caption(), $this->moneda->RequiredErrorMessage));
                }
            }
            if ($this->preciobase->Visible && $this->preciobase->Required) {
                if (!$this->preciobase->IsDetailKey && EmptyValue($this->preciobase->FormValue)) {
                    $this->preciobase->addErrorMessage(str_replace("%s", $this->preciobase->caption(), $this->preciobase->RequiredErrorMessage));
                }
            }
            if ($this->preciofinal->Visible && $this->preciofinal->Required) {
                if (!$this->preciofinal->IsDetailKey && EmptyValue($this->preciofinal->FormValue)) {
                    $this->preciofinal->addErrorMessage(str_replace("%s", $this->preciofinal->caption(), $this->preciofinal->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->preciofinal->FormValue)) {
                $this->preciofinal->addErrorMessage($this->preciofinal->getErrorMessage(false));
            }
            if ($this->comiscobr->Visible && $this->comiscobr->Required) {
                if (!$this->comiscobr->IsDetailKey && EmptyValue($this->comiscobr->FormValue)) {
                    $this->comiscobr->addErrorMessage(str_replace("%s", $this->comiscobr->caption(), $this->comiscobr->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->comiscobr->FormValue)) {
                $this->comiscobr->addErrorMessage($this->comiscobr->getErrorMessage(false));
            }
            if ($this->comispag->Visible && $this->comispag->Required) {
                if (!$this->comispag->IsDetailKey && EmptyValue($this->comispag->FormValue)) {
                    $this->comispag->addErrorMessage(str_replace("%s", $this->comispag->caption(), $this->comispag->RequiredErrorMessage));
                }
            }
            if ($this->comprador->Visible && $this->comprador->Required) {
                if (!$this->comprador->IsDetailKey && EmptyValue($this->comprador->FormValue)) {
                    $this->comprador->addErrorMessage(str_replace("%s", $this->comprador->caption(), $this->comprador->RequiredErrorMessage));
                }
            }
            if ($this->ivari->Visible && $this->ivari->Required) {
                if (!$this->ivari->IsDetailKey && EmptyValue($this->ivari->FormValue)) {
                    $this->ivari->addErrorMessage(str_replace("%s", $this->ivari->caption(), $this->ivari->RequiredErrorMessage));
                }
            }
            if ($this->ivarni->Visible && $this->ivarni->Required) {
                if (!$this->ivarni->IsDetailKey && EmptyValue($this->ivarni->FormValue)) {
                    $this->ivarni->addErrorMessage(str_replace("%s", $this->ivarni->caption(), $this->ivarni->RequiredErrorMessage));
                }
            }
            if ($this->codimpadic->Visible && $this->codimpadic->Required) {
                if (!$this->codimpadic->IsDetailKey && EmptyValue($this->codimpadic->FormValue)) {
                    $this->codimpadic->addErrorMessage(str_replace("%s", $this->codimpadic->caption(), $this->codimpadic->RequiredErrorMessage));
                }
            }
            if ($this->impadic->Visible && $this->impadic->Required) {
                if (!$this->impadic->IsDetailKey && EmptyValue($this->impadic->FormValue)) {
                    $this->impadic->addErrorMessage(str_replace("%s", $this->impadic->caption(), $this->impadic->RequiredErrorMessage));
                }
            }
            if ($this->descripcion->Visible && $this->descripcion->Required) {
                if (!$this->descripcion->IsDetailKey && EmptyValue($this->descripcion->FormValue)) {
                    $this->descripcion->addErrorMessage(str_replace("%s", $this->descripcion->caption(), $this->descripcion->RequiredErrorMessage));
                }
            }
            if ($this->descor->Visible && $this->descor->Required) {
                if (!$this->descor->IsDetailKey && EmptyValue($this->descor->FormValue)) {
                    $this->descor->addErrorMessage(str_replace("%s", $this->descor->caption(), $this->descor->RequiredErrorMessage));
                }
            }
            if ($this->observ->Visible && $this->observ->Required) {
                if (!$this->observ->IsDetailKey && EmptyValue($this->observ->FormValue)) {
                    $this->observ->addErrorMessage(str_replace("%s", $this->observ->caption(), $this->observ->RequiredErrorMessage));
                }
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
            if ($this->codintlote->Visible && $this->codintlote->Required) {
                if (!$this->codintlote->IsDetailKey && EmptyValue($this->codintlote->FormValue)) {
                    $this->codintlote->addErrorMessage(str_replace("%s", $this->codintlote->caption(), $this->codintlote->RequiredErrorMessage));
                }
            }
            if ($this->codintnum->Visible && $this->codintnum->Required) {
                if (!$this->codintnum->IsDetailKey && EmptyValue($this->codintnum->FormValue)) {
                    $this->codintnum->addErrorMessage(str_replace("%s", $this->codintnum->caption(), $this->codintnum->RequiredErrorMessage));
                }
            }
            if ($this->codintsublote->Visible && $this->codintsublote->Required) {
                if (!$this->codintsublote->IsDetailKey && EmptyValue($this->codintsublote->FormValue)) {
                    $this->codintsublote->addErrorMessage(str_replace("%s", $this->codintsublote->caption(), $this->codintsublote->RequiredErrorMessage));
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
            if ($this->dir_secuencia->Visible && $this->dir_secuencia->Required) {
                if (!$this->dir_secuencia->IsDetailKey && EmptyValue($this->dir_secuencia->FormValue)) {
                    $this->dir_secuencia->addErrorMessage(str_replace("%s", $this->dir_secuencia->caption(), $this->dir_secuencia->RequiredErrorMessage));
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

        // Check referential integrity for master table 'remates'
        $detailKeys = [];
        $keyValue = $rsnew['codrem'] ?? $rsold['codrem'];
        $detailKeys['codrem'] = $keyValue;
        $masterTable = Container("remates");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "remates", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
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

        // codcli
        $this->codcli->setDbValueDef($rsnew, $this->codcli->CurrentValue, $this->codcli->ReadOnly);

        // codrubro
        $this->codrubro->setDbValueDef($rsnew, $this->codrubro->CurrentValue, $this->codrubro->ReadOnly);

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, $this->estado->ReadOnly);

        // moneda
        $this->moneda->setDbValueDef($rsnew, $this->moneda->CurrentValue, $this->moneda->ReadOnly);

        // preciobase
        $this->preciobase->setDbValueDef($rsnew, $this->preciobase->CurrentValue, $this->preciobase->ReadOnly);

        // preciofinal
        $this->preciofinal->setDbValueDef($rsnew, $this->preciofinal->CurrentValue, $this->preciofinal->ReadOnly);

        // comiscobr
        $this->comiscobr->setDbValueDef($rsnew, $this->comiscobr->CurrentValue, $this->comiscobr->ReadOnly);

        // comispag
        $this->comispag->setDbValueDef($rsnew, $this->comispag->CurrentValue, $this->comispag->ReadOnly);

        // comprador
        $this->comprador->setDbValueDef($rsnew, $this->comprador->CurrentValue, $this->comprador->ReadOnly);

        // ivari
        $this->ivari->setDbValueDef($rsnew, $this->ivari->CurrentValue, $this->ivari->ReadOnly);

        // ivarni
        $this->ivarni->setDbValueDef($rsnew, $this->ivarni->CurrentValue, $this->ivarni->ReadOnly);

        // codimpadic
        $this->codimpadic->setDbValueDef($rsnew, $this->codimpadic->CurrentValue, $this->codimpadic->ReadOnly);

        // impadic
        $this->impadic->setDbValueDef($rsnew, $this->impadic->CurrentValue, $this->impadic->ReadOnly);

        // descripcion
        $this->descripcion->setDbValueDef($rsnew, $this->descripcion->CurrentValue, $this->descripcion->ReadOnly);

        // descor
        $this->descor->setDbValueDef($rsnew, $this->descor->CurrentValue, $this->descor->ReadOnly);

        // observ
        $this->observ->setDbValueDef($rsnew, $this->observ->CurrentValue, $this->observ->ReadOnly);

        // usuario
        $this->usuario->CurrentValue = $this->usuario->getAutoUpdateValue(); // PHP
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue, $this->usuario->ReadOnly);

        // fecalta
        $this->fecalta->CurrentValue = $this->fecalta->getAutoUpdateValue(); // PHP
        $this->fecalta->setDbValueDef($rsnew, UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern()), $this->fecalta->ReadOnly);

        // codintnum
        $this->codintnum->setDbValueDef($rsnew, $this->codintnum->CurrentValue, $this->codintnum->ReadOnly);

        // codintsublote
        $this->codintsublote->setDbValueDef($rsnew, $this->codintsublote->CurrentValue, $this->codintsublote->ReadOnly);

        // usuarioultmod
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->getAutoUpdateValue(); // PHP
        $this->usuarioultmod->setDbValueDef($rsnew, $this->usuarioultmod->CurrentValue, $this->usuarioultmod->ReadOnly);

        // fecultmod
        $this->fecultmod->CurrentValue = $this->fecultmod->getAutoUpdateValue(); // PHP
        $this->fecultmod->setDbValueDef($rsnew, UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern()), $this->fecultmod->ReadOnly);

        // dir_secuencia
        $this->dir_secuencia->setDbValueDef($rsnew, $this->dir_secuencia->CurrentValue, $this->dir_secuencia->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['codcli'])) { // codcli
            $this->codcli->CurrentValue = $row['codcli'];
        }
        if (isset($row['codrubro'])) { // codrubro
            $this->codrubro->CurrentValue = $row['codrubro'];
        }
        if (isset($row['estado'])) { // estado
            $this->estado->CurrentValue = $row['estado'];
        }
        if (isset($row['moneda'])) { // moneda
            $this->moneda->CurrentValue = $row['moneda'];
        }
        if (isset($row['preciobase'])) { // preciobase
            $this->preciobase->CurrentValue = $row['preciobase'];
        }
        if (isset($row['preciofinal'])) { // preciofinal
            $this->preciofinal->CurrentValue = $row['preciofinal'];
        }
        if (isset($row['comiscobr'])) { // comiscobr
            $this->comiscobr->CurrentValue = $row['comiscobr'];
        }
        if (isset($row['comispag'])) { // comispag
            $this->comispag->CurrentValue = $row['comispag'];
        }
        if (isset($row['comprador'])) { // comprador
            $this->comprador->CurrentValue = $row['comprador'];
        }
        if (isset($row['ivari'])) { // ivari
            $this->ivari->CurrentValue = $row['ivari'];
        }
        if (isset($row['ivarni'])) { // ivarni
            $this->ivarni->CurrentValue = $row['ivarni'];
        }
        if (isset($row['codimpadic'])) { // codimpadic
            $this->codimpadic->CurrentValue = $row['codimpadic'];
        }
        if (isset($row['impadic'])) { // impadic
            $this->impadic->CurrentValue = $row['impadic'];
        }
        if (isset($row['descripcion'])) { // descripcion
            $this->descripcion->CurrentValue = $row['descripcion'];
        }
        if (isset($row['descor'])) { // descor
            $this->descor->CurrentValue = $row['descor'];
        }
        if (isset($row['observ'])) { // observ
            $this->observ->CurrentValue = $row['observ'];
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->CurrentValue = $row['usuario'];
        }
        if (isset($row['fecalta'])) { // fecalta
            $this->fecalta->CurrentValue = $row['fecalta'];
        }
        if (isset($row['codintnum'])) { // codintnum
            $this->codintnum->CurrentValue = $row['codintnum'];
        }
        if (isset($row['codintsublote'])) { // codintsublote
            $this->codintsublote->CurrentValue = $row['codintsublote'];
        }
        if (isset($row['usuarioultmod'])) { // usuarioultmod
            $this->usuarioultmod->CurrentValue = $row['usuarioultmod'];
        }
        if (isset($row['fecultmod'])) { // fecultmod
            $this->fecultmod->CurrentValue = $row['fecultmod'];
        }
        if (isset($row['dir_secuencia'])) { // dir_secuencia
            $this->dir_secuencia->CurrentValue = $row['dir_secuencia'];
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
            if ($masterTblVar == "remates") {
                $validMaster = true;
                $masterTbl = Container("remates");
                if (($parm = Get("fk_ncomp", Get("codrem"))) !== null) {
                    $masterTbl->ncomp->setQueryStringValue($parm);
                    $this->codrem->QueryStringValue = $masterTbl->ncomp->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->codrem->setSessionValue($this->codrem->QueryStringValue);
                    $foreignKeys["codrem"] = $this->codrem->QueryStringValue;
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
            if ($masterTblVar == "remates") {
                $validMaster = true;
                $masterTbl = Container("remates");
                if (($parm = Post("fk_ncomp", Post("codrem"))) !== null) {
                    $masterTbl->ncomp->setFormValue($parm);
                    $this->codrem->FormValue = $masterTbl->ncomp->FormValue;
                    $this->codrem->setSessionValue($this->codrem->FormValue);
                    $foreignKeys["codrem"] = $this->codrem->FormValue;
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "remates") {
                if (!array_key_exists("codrem", $foreignKeys)) { // Not current foreign key
                    $this->codrem->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("LotesList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up multi pages
    protected function setupMultiPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        if ($pages->isAccordion()) {
            $pages->Parent = "#accordion_" . $this->PageObjName;
        }
        $pages->add(0);
        $pages->add(1);
        $pages->add(2);
        $this->MultiPages = $pages;
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
                case "x_estado":
                    break;
                case "x_dir_secuencia":
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
