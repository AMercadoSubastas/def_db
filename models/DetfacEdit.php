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
class DetfacEdit extends Detfac
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "DetfacEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "DetfacEdit";

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
        $this->nreng->setVisibility();
        $this->codrem->setVisibility();
        $this->codlote->setVisibility();
        $this->descrip->setVisibility();
        $this->neto->setVisibility();
        $this->bruto->setVisibility();
        $this->iva->setVisibility();
        $this->imp->setVisibility();
        $this->comcob->setVisibility();
        $this->compag->setVisibility();
        $this->fechahora->setVisibility();
        $this->usuario->setVisibility();
        $this->porciva->setVisibility();
        $this->tieneresol->setVisibility();
        $this->concafac->setVisibility();
        $this->tcomsal->setVisibility();
        $this->seriesal->setVisibility();
        $this->ncompsal->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'detfac';
        $this->TableName = 'detfac';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (detfac)
        if (!isset($GLOBALS["detfac"]) || $GLOBALS["detfac"]::class == PROJECT_NAMESPACE . "detfac") {
            $GLOBALS["detfac"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'detfac');
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
                        $result["view"] = SameString($pageName, "DetfacView"); // If View page, no primary button
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
                        $this->terminate("DetfacList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "DetfacList") {
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
                        if (GetPageName($returnUrl) != "DetfacList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "DetfacList"; // Return list page content
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

        // Check field name 'codnum' first before field var 'x_codnum'
        $val = $CurrentForm->hasValue("codnum") ? $CurrentForm->getValue("codnum") : $CurrentForm->getValue("x_codnum");
        if (!$this->codnum->IsDetailKey) {
            $this->codnum->setFormValue($val);
        }

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

        // Check field name 'codrem' first before field var 'x_codrem'
        $val = $CurrentForm->hasValue("codrem") ? $CurrentForm->getValue("codrem") : $CurrentForm->getValue("x_codrem");
        if (!$this->codrem->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codrem->Visible = false; // Disable update for API request
            } else {
                $this->codrem->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'codlote' first before field var 'x_codlote'
        $val = $CurrentForm->hasValue("codlote") ? $CurrentForm->getValue("codlote") : $CurrentForm->getValue("x_codlote");
        if (!$this->codlote->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codlote->Visible = false; // Disable update for API request
            } else {
                $this->codlote->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'descrip' first before field var 'x_descrip'
        $val = $CurrentForm->hasValue("descrip") ? $CurrentForm->getValue("descrip") : $CurrentForm->getValue("x_descrip");
        if (!$this->descrip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descrip->Visible = false; // Disable update for API request
            } else {
                $this->descrip->setFormValue($val);
            }
        }

        // Check field name 'neto' first before field var 'x_neto'
        $val = $CurrentForm->hasValue("neto") ? $CurrentForm->getValue("neto") : $CurrentForm->getValue("x_neto");
        if (!$this->neto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->neto->Visible = false; // Disable update for API request
            } else {
                $this->neto->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'bruto' first before field var 'x_bruto'
        $val = $CurrentForm->hasValue("bruto") ? $CurrentForm->getValue("bruto") : $CurrentForm->getValue("x_bruto");
        if (!$this->bruto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bruto->Visible = false; // Disable update for API request
            } else {
                $this->bruto->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'iva' first before field var 'x_iva'
        $val = $CurrentForm->hasValue("iva") ? $CurrentForm->getValue("iva") : $CurrentForm->getValue("x_iva");
        if (!$this->iva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->iva->Visible = false; // Disable update for API request
            } else {
                $this->iva->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'imp' first before field var 'x_imp'
        $val = $CurrentForm->hasValue("imp") ? $CurrentForm->getValue("imp") : $CurrentForm->getValue("x_imp");
        if (!$this->imp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->imp->Visible = false; // Disable update for API request
            } else {
                $this->imp->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'comcob' first before field var 'x_comcob'
        $val = $CurrentForm->hasValue("comcob") ? $CurrentForm->getValue("comcob") : $CurrentForm->getValue("x_comcob");
        if (!$this->comcob->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->comcob->Visible = false; // Disable update for API request
            } else {
                $this->comcob->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'compag' first before field var 'x_compag'
        $val = $CurrentForm->hasValue("compag") ? $CurrentForm->getValue("compag") : $CurrentForm->getValue("x_compag");
        if (!$this->compag->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->compag->Visible = false; // Disable update for API request
            } else {
                $this->compag->setFormValue($val, true, $validate);
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

        // Check field name 'usuario' first before field var 'x_usuario'
        $val = $CurrentForm->hasValue("usuario") ? $CurrentForm->getValue("usuario") : $CurrentForm->getValue("x_usuario");
        if (!$this->usuario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario->Visible = false; // Disable update for API request
            } else {
                $this->usuario->setFormValue($val);
            }
        }

        // Check field name 'porciva' first before field var 'x_porciva'
        $val = $CurrentForm->hasValue("porciva") ? $CurrentForm->getValue("porciva") : $CurrentForm->getValue("x_porciva");
        if (!$this->porciva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porciva->Visible = false; // Disable update for API request
            } else {
                $this->porciva->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'tieneresol' first before field var 'x_tieneresol'
        $val = $CurrentForm->hasValue("tieneresol") ? $CurrentForm->getValue("tieneresol") : $CurrentForm->getValue("x_tieneresol");
        if (!$this->tieneresol->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tieneresol->Visible = false; // Disable update for API request
            } else {
                $this->tieneresol->setFormValue($val);
            }
        }

        // Check field name 'concafac' first before field var 'x_concafac'
        $val = $CurrentForm->hasValue("concafac") ? $CurrentForm->getValue("concafac") : $CurrentForm->getValue("x_concafac");
        if (!$this->concafac->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->concafac->Visible = false; // Disable update for API request
            } else {
                $this->concafac->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'tcomsal' first before field var 'x_tcomsal'
        $val = $CurrentForm->hasValue("tcomsal") ? $CurrentForm->getValue("tcomsal") : $CurrentForm->getValue("x_tcomsal");
        if (!$this->tcomsal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tcomsal->Visible = false; // Disable update for API request
            } else {
                $this->tcomsal->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'seriesal' first before field var 'x_seriesal'
        $val = $CurrentForm->hasValue("seriesal") ? $CurrentForm->getValue("seriesal") : $CurrentForm->getValue("x_seriesal");
        if (!$this->seriesal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->seriesal->Visible = false; // Disable update for API request
            } else {
                $this->seriesal->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ncompsal' first before field var 'x_ncompsal'
        $val = $CurrentForm->hasValue("ncompsal") ? $CurrentForm->getValue("ncompsal") : $CurrentForm->getValue("x_ncompsal");
        if (!$this->ncompsal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ncompsal->Visible = false; // Disable update for API request
            } else {
                $this->ncompsal->setFormValue($val, true, $validate);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->codnum->CurrentValue = $this->codnum->FormValue;
        $this->tcomp->CurrentValue = $this->tcomp->FormValue;
        $this->serie->CurrentValue = $this->serie->FormValue;
        $this->ncomp->CurrentValue = $this->ncomp->FormValue;
        $this->nreng->CurrentValue = $this->nreng->FormValue;
        $this->codrem->CurrentValue = $this->codrem->FormValue;
        $this->codlote->CurrentValue = $this->codlote->FormValue;
        $this->descrip->CurrentValue = $this->descrip->FormValue;
        $this->neto->CurrentValue = $this->neto->FormValue;
        $this->bruto->CurrentValue = $this->bruto->FormValue;
        $this->iva->CurrentValue = $this->iva->FormValue;
        $this->imp->CurrentValue = $this->imp->FormValue;
        $this->comcob->CurrentValue = $this->comcob->FormValue;
        $this->compag->CurrentValue = $this->compag->FormValue;
        $this->fechahora->CurrentValue = $this->fechahora->FormValue;
        $this->fechahora->CurrentValue = UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        $this->usuario->CurrentValue = $this->usuario->FormValue;
        $this->porciva->CurrentValue = $this->porciva->FormValue;
        $this->tieneresol->CurrentValue = $this->tieneresol->FormValue;
        $this->concafac->CurrentValue = $this->concafac->FormValue;
        $this->tcomsal->CurrentValue = $this->tcomsal->FormValue;
        $this->seriesal->CurrentValue = $this->seriesal->FormValue;
        $this->ncompsal->CurrentValue = $this->ncompsal->FormValue;
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
        $this->codrem->setDbValue($row['codrem']);
        $this->codlote->setDbValue($row['codlote']);
        $this->descrip->setDbValue($row['descrip']);
        $this->neto->setDbValue($row['neto']);
        $this->bruto->setDbValue($row['bruto']);
        $this->iva->setDbValue($row['iva']);
        $this->imp->setDbValue($row['imp']);
        $this->comcob->setDbValue($row['comcob']);
        $this->compag->setDbValue($row['compag']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->usuario->setDbValue($row['usuario']);
        $this->porciva->setDbValue($row['porciva']);
        $this->tieneresol->setDbValue($row['tieneresol']);
        $this->concafac->setDbValue($row['concafac']);
        $this->tcomsal->setDbValue($row['tcomsal']);
        $this->seriesal->setDbValue($row['seriesal']);
        $this->ncompsal->setDbValue($row['ncompsal']);
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
        $row['codrem'] = $this->codrem->DefaultValue;
        $row['codlote'] = $this->codlote->DefaultValue;
        $row['descrip'] = $this->descrip->DefaultValue;
        $row['neto'] = $this->neto->DefaultValue;
        $row['bruto'] = $this->bruto->DefaultValue;
        $row['iva'] = $this->iva->DefaultValue;
        $row['imp'] = $this->imp->DefaultValue;
        $row['comcob'] = $this->comcob->DefaultValue;
        $row['compag'] = $this->compag->DefaultValue;
        $row['fechahora'] = $this->fechahora->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['porciva'] = $this->porciva->DefaultValue;
        $row['tieneresol'] = $this->tieneresol->DefaultValue;
        $row['concafac'] = $this->concafac->DefaultValue;
        $row['tcomsal'] = $this->tcomsal->DefaultValue;
        $row['seriesal'] = $this->seriesal->DefaultValue;
        $row['ncompsal'] = $this->ncompsal->DefaultValue;
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

        // codrem
        $this->codrem->RowCssClass = "row";

        // codlote
        $this->codlote->RowCssClass = "row";

        // descrip
        $this->descrip->RowCssClass = "row";

        // neto
        $this->neto->RowCssClass = "row";

        // bruto
        $this->bruto->RowCssClass = "row";

        // iva
        $this->iva->RowCssClass = "row";

        // imp
        $this->imp->RowCssClass = "row";

        // comcob
        $this->comcob->RowCssClass = "row";

        // compag
        $this->compag->RowCssClass = "row";

        // fechahora
        $this->fechahora->RowCssClass = "row";

        // usuario
        $this->usuario->RowCssClass = "row";

        // porciva
        $this->porciva->RowCssClass = "row";

        // tieneresol
        $this->tieneresol->RowCssClass = "row";

        // concafac
        $this->concafac->RowCssClass = "row";

        // tcomsal
        $this->tcomsal->RowCssClass = "row";

        // seriesal
        $this->seriesal->RowCssClass = "row";

        // ncompsal
        $this->ncompsal->RowCssClass = "row";

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

            // codrem
            $this->codrem->ViewValue = $this->codrem->CurrentValue;
            $this->codrem->ViewValue = FormatNumber($this->codrem->ViewValue, $this->codrem->formatPattern());

            // codlote
            $this->codlote->ViewValue = $this->codlote->CurrentValue;
            $this->codlote->ViewValue = FormatNumber($this->codlote->ViewValue, $this->codlote->formatPattern());

            // descrip
            $this->descrip->ViewValue = $this->descrip->CurrentValue;

            // neto
            $this->neto->ViewValue = $this->neto->CurrentValue;
            $this->neto->ViewValue = FormatNumber($this->neto->ViewValue, $this->neto->formatPattern());

            // bruto
            $this->bruto->ViewValue = $this->bruto->CurrentValue;
            $this->bruto->ViewValue = FormatNumber($this->bruto->ViewValue, $this->bruto->formatPattern());

            // iva
            $this->iva->ViewValue = $this->iva->CurrentValue;
            $this->iva->ViewValue = FormatNumber($this->iva->ViewValue, $this->iva->formatPattern());

            // imp
            $this->imp->ViewValue = $this->imp->CurrentValue;
            $this->imp->ViewValue = FormatNumber($this->imp->ViewValue, $this->imp->formatPattern());

            // comcob
            $this->comcob->ViewValue = $this->comcob->CurrentValue;
            $this->comcob->ViewValue = FormatNumber($this->comcob->ViewValue, $this->comcob->formatPattern());

            // compag
            $this->compag->ViewValue = $this->compag->CurrentValue;
            $this->compag->ViewValue = FormatNumber($this->compag->ViewValue, $this->compag->formatPattern());

            // fechahora
            $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
            $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

            // usuario
            $this->usuario->ViewValue = $this->usuario->CurrentValue;
            $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

            // porciva
            $this->porciva->ViewValue = $this->porciva->CurrentValue;
            $this->porciva->ViewValue = FormatNumber($this->porciva->ViewValue, $this->porciva->formatPattern());

            // tieneresol
            $this->tieneresol->ViewValue = $this->tieneresol->CurrentValue;

            // concafac
            $this->concafac->ViewValue = $this->concafac->CurrentValue;
            $this->concafac->ViewValue = FormatNumber($this->concafac->ViewValue, $this->concafac->formatPattern());

            // tcomsal
            $this->tcomsal->ViewValue = $this->tcomsal->CurrentValue;
            $this->tcomsal->ViewValue = FormatNumber($this->tcomsal->ViewValue, $this->tcomsal->formatPattern());

            // seriesal
            $this->seriesal->ViewValue = $this->seriesal->CurrentValue;
            $this->seriesal->ViewValue = FormatNumber($this->seriesal->ViewValue, $this->seriesal->formatPattern());

            // ncompsal
            $this->ncompsal->ViewValue = $this->ncompsal->CurrentValue;
            $this->ncompsal->ViewValue = FormatNumber($this->ncompsal->ViewValue, $this->ncompsal->formatPattern());

            // codnum
            $this->codnum->HrefValue = "";

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";

            // nreng
            $this->nreng->HrefValue = "";

            // codrem
            $this->codrem->HrefValue = "";

            // codlote
            $this->codlote->HrefValue = "";

            // descrip
            $this->descrip->HrefValue = "";

            // neto
            $this->neto->HrefValue = "";

            // bruto
            $this->bruto->HrefValue = "";

            // iva
            $this->iva->HrefValue = "";

            // imp
            $this->imp->HrefValue = "";

            // comcob
            $this->comcob->HrefValue = "";

            // compag
            $this->compag->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // porciva
            $this->porciva->HrefValue = "";

            // tieneresol
            $this->tieneresol->HrefValue = "";

            // concafac
            $this->concafac->HrefValue = "";

            // tcomsal
            $this->tcomsal->HrefValue = "";

            // seriesal
            $this->seriesal->HrefValue = "";

            // ncompsal
            $this->ncompsal->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // codnum
            $this->codnum->setupEditAttributes();
            $this->codnum->EditValue = $this->codnum->CurrentValue;

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

            // codrem
            $this->codrem->setupEditAttributes();
            $this->codrem->EditValue = $this->codrem->CurrentValue;
            $this->codrem->PlaceHolder = RemoveHtml($this->codrem->caption());
            if (strval($this->codrem->EditValue) != "" && is_numeric($this->codrem->EditValue)) {
                $this->codrem->EditValue = FormatNumber($this->codrem->EditValue, null);
            }

            // codlote
            $this->codlote->setupEditAttributes();
            $this->codlote->EditValue = $this->codlote->CurrentValue;
            $this->codlote->PlaceHolder = RemoveHtml($this->codlote->caption());
            if (strval($this->codlote->EditValue) != "" && is_numeric($this->codlote->EditValue)) {
                $this->codlote->EditValue = FormatNumber($this->codlote->EditValue, null);
            }

            // descrip
            $this->descrip->setupEditAttributes();
            if (!$this->descrip->Raw) {
                $this->descrip->CurrentValue = HtmlDecode($this->descrip->CurrentValue);
            }
            $this->descrip->EditValue = HtmlEncode($this->descrip->CurrentValue);
            $this->descrip->PlaceHolder = RemoveHtml($this->descrip->caption());

            // neto
            $this->neto->setupEditAttributes();
            $this->neto->EditValue = $this->neto->CurrentValue;
            $this->neto->PlaceHolder = RemoveHtml($this->neto->caption());
            if (strval($this->neto->EditValue) != "" && is_numeric($this->neto->EditValue)) {
                $this->neto->EditValue = FormatNumber($this->neto->EditValue, null);
            }

            // bruto
            $this->bruto->setupEditAttributes();
            $this->bruto->EditValue = $this->bruto->CurrentValue;
            $this->bruto->PlaceHolder = RemoveHtml($this->bruto->caption());
            if (strval($this->bruto->EditValue) != "" && is_numeric($this->bruto->EditValue)) {
                $this->bruto->EditValue = FormatNumber($this->bruto->EditValue, null);
            }

            // iva
            $this->iva->setupEditAttributes();
            $this->iva->EditValue = $this->iva->CurrentValue;
            $this->iva->PlaceHolder = RemoveHtml($this->iva->caption());
            if (strval($this->iva->EditValue) != "" && is_numeric($this->iva->EditValue)) {
                $this->iva->EditValue = FormatNumber($this->iva->EditValue, null);
            }

            // imp
            $this->imp->setupEditAttributes();
            $this->imp->EditValue = $this->imp->CurrentValue;
            $this->imp->PlaceHolder = RemoveHtml($this->imp->caption());
            if (strval($this->imp->EditValue) != "" && is_numeric($this->imp->EditValue)) {
                $this->imp->EditValue = FormatNumber($this->imp->EditValue, null);
            }

            // comcob
            $this->comcob->setupEditAttributes();
            $this->comcob->EditValue = $this->comcob->CurrentValue;
            $this->comcob->PlaceHolder = RemoveHtml($this->comcob->caption());
            if (strval($this->comcob->EditValue) != "" && is_numeric($this->comcob->EditValue)) {
                $this->comcob->EditValue = FormatNumber($this->comcob->EditValue, null);
            }

            // compag
            $this->compag->setupEditAttributes();
            $this->compag->EditValue = $this->compag->CurrentValue;
            $this->compag->PlaceHolder = RemoveHtml($this->compag->caption());
            if (strval($this->compag->EditValue) != "" && is_numeric($this->compag->EditValue)) {
                $this->compag->EditValue = FormatNumber($this->compag->EditValue, null);
            }

            // fechahora

            // usuario

            // porciva
            $this->porciva->setupEditAttributes();
            $this->porciva->EditValue = $this->porciva->CurrentValue;
            $this->porciva->PlaceHolder = RemoveHtml($this->porciva->caption());
            if (strval($this->porciva->EditValue) != "" && is_numeric($this->porciva->EditValue)) {
                $this->porciva->EditValue = FormatNumber($this->porciva->EditValue, null);
            }

            // tieneresol
            $this->tieneresol->setupEditAttributes();
            if (strval($this->tieneresol->EditValue) != "" && is_numeric($this->tieneresol->EditValue)) {
                $this->tieneresol->EditValue = $this->tieneresol->EditValue;
            }

            // concafac
            $this->concafac->setupEditAttributes();
            $this->concafac->EditValue = $this->concafac->CurrentValue;
            $this->concafac->PlaceHolder = RemoveHtml($this->concafac->caption());
            if (strval($this->concafac->EditValue) != "" && is_numeric($this->concafac->EditValue)) {
                $this->concafac->EditValue = FormatNumber($this->concafac->EditValue, null);
            }

            // tcomsal
            $this->tcomsal->setupEditAttributes();
            $this->tcomsal->EditValue = $this->tcomsal->CurrentValue;
            $this->tcomsal->PlaceHolder = RemoveHtml($this->tcomsal->caption());
            if (strval($this->tcomsal->EditValue) != "" && is_numeric($this->tcomsal->EditValue)) {
                $this->tcomsal->EditValue = FormatNumber($this->tcomsal->EditValue, null);
            }

            // seriesal
            $this->seriesal->setupEditAttributes();
            $this->seriesal->EditValue = $this->seriesal->CurrentValue;
            $this->seriesal->PlaceHolder = RemoveHtml($this->seriesal->caption());
            if (strval($this->seriesal->EditValue) != "" && is_numeric($this->seriesal->EditValue)) {
                $this->seriesal->EditValue = FormatNumber($this->seriesal->EditValue, null);
            }

            // ncompsal
            $this->ncompsal->setupEditAttributes();
            $this->ncompsal->EditValue = $this->ncompsal->CurrentValue;
            $this->ncompsal->PlaceHolder = RemoveHtml($this->ncompsal->caption());
            if (strval($this->ncompsal->EditValue) != "" && is_numeric($this->ncompsal->EditValue)) {
                $this->ncompsal->EditValue = FormatNumber($this->ncompsal->EditValue, null);
            }

            // Edit refer script

            // codnum
            $this->codnum->HrefValue = "";

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";

            // nreng
            $this->nreng->HrefValue = "";

            // codrem
            $this->codrem->HrefValue = "";

            // codlote
            $this->codlote->HrefValue = "";

            // descrip
            $this->descrip->HrefValue = "";

            // neto
            $this->neto->HrefValue = "";

            // bruto
            $this->bruto->HrefValue = "";

            // iva
            $this->iva->HrefValue = "";

            // imp
            $this->imp->HrefValue = "";

            // comcob
            $this->comcob->HrefValue = "";

            // compag
            $this->compag->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // porciva
            $this->porciva->HrefValue = "";

            // tieneresol
            $this->tieneresol->HrefValue = "";

            // concafac
            $this->concafac->HrefValue = "";

            // tcomsal
            $this->tcomsal->HrefValue = "";

            // seriesal
            $this->seriesal->HrefValue = "";

            // ncompsal
            $this->ncompsal->HrefValue = "";
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
            if ($this->codnum->Visible && $this->codnum->Required) {
                if (!$this->codnum->IsDetailKey && EmptyValue($this->codnum->FormValue)) {
                    $this->codnum->addErrorMessage(str_replace("%s", $this->codnum->caption(), $this->codnum->RequiredErrorMessage));
                }
            }
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
            if ($this->codrem->Visible && $this->codrem->Required) {
                if (!$this->codrem->IsDetailKey && EmptyValue($this->codrem->FormValue)) {
                    $this->codrem->addErrorMessage(str_replace("%s", $this->codrem->caption(), $this->codrem->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->codrem->FormValue)) {
                $this->codrem->addErrorMessage($this->codrem->getErrorMessage(false));
            }
            if ($this->codlote->Visible && $this->codlote->Required) {
                if (!$this->codlote->IsDetailKey && EmptyValue($this->codlote->FormValue)) {
                    $this->codlote->addErrorMessage(str_replace("%s", $this->codlote->caption(), $this->codlote->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->codlote->FormValue)) {
                $this->codlote->addErrorMessage($this->codlote->getErrorMessage(false));
            }
            if ($this->descrip->Visible && $this->descrip->Required) {
                if (!$this->descrip->IsDetailKey && EmptyValue($this->descrip->FormValue)) {
                    $this->descrip->addErrorMessage(str_replace("%s", $this->descrip->caption(), $this->descrip->RequiredErrorMessage));
                }
            }
            if ($this->neto->Visible && $this->neto->Required) {
                if (!$this->neto->IsDetailKey && EmptyValue($this->neto->FormValue)) {
                    $this->neto->addErrorMessage(str_replace("%s", $this->neto->caption(), $this->neto->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->neto->FormValue)) {
                $this->neto->addErrorMessage($this->neto->getErrorMessage(false));
            }
            if ($this->bruto->Visible && $this->bruto->Required) {
                if (!$this->bruto->IsDetailKey && EmptyValue($this->bruto->FormValue)) {
                    $this->bruto->addErrorMessage(str_replace("%s", $this->bruto->caption(), $this->bruto->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->bruto->FormValue)) {
                $this->bruto->addErrorMessage($this->bruto->getErrorMessage(false));
            }
            if ($this->iva->Visible && $this->iva->Required) {
                if (!$this->iva->IsDetailKey && EmptyValue($this->iva->FormValue)) {
                    $this->iva->addErrorMessage(str_replace("%s", $this->iva->caption(), $this->iva->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->iva->FormValue)) {
                $this->iva->addErrorMessage($this->iva->getErrorMessage(false));
            }
            if ($this->imp->Visible && $this->imp->Required) {
                if (!$this->imp->IsDetailKey && EmptyValue($this->imp->FormValue)) {
                    $this->imp->addErrorMessage(str_replace("%s", $this->imp->caption(), $this->imp->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->imp->FormValue)) {
                $this->imp->addErrorMessage($this->imp->getErrorMessage(false));
            }
            if ($this->comcob->Visible && $this->comcob->Required) {
                if (!$this->comcob->IsDetailKey && EmptyValue($this->comcob->FormValue)) {
                    $this->comcob->addErrorMessage(str_replace("%s", $this->comcob->caption(), $this->comcob->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->comcob->FormValue)) {
                $this->comcob->addErrorMessage($this->comcob->getErrorMessage(false));
            }
            if ($this->compag->Visible && $this->compag->Required) {
                if (!$this->compag->IsDetailKey && EmptyValue($this->compag->FormValue)) {
                    $this->compag->addErrorMessage(str_replace("%s", $this->compag->caption(), $this->compag->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->compag->FormValue)) {
                $this->compag->addErrorMessage($this->compag->getErrorMessage(false));
            }
            if ($this->fechahora->Visible && $this->fechahora->Required) {
                if (!$this->fechahora->IsDetailKey && EmptyValue($this->fechahora->FormValue)) {
                    $this->fechahora->addErrorMessage(str_replace("%s", $this->fechahora->caption(), $this->fechahora->RequiredErrorMessage));
                }
            }
            if ($this->usuario->Visible && $this->usuario->Required) {
                if (!$this->usuario->IsDetailKey && EmptyValue($this->usuario->FormValue)) {
                    $this->usuario->addErrorMessage(str_replace("%s", $this->usuario->caption(), $this->usuario->RequiredErrorMessage));
                }
            }
            if ($this->porciva->Visible && $this->porciva->Required) {
                if (!$this->porciva->IsDetailKey && EmptyValue($this->porciva->FormValue)) {
                    $this->porciva->addErrorMessage(str_replace("%s", $this->porciva->caption(), $this->porciva->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->porciva->FormValue)) {
                $this->porciva->addErrorMessage($this->porciva->getErrorMessage(false));
            }
            if ($this->tieneresol->Visible && $this->tieneresol->Required) {
                if (!$this->tieneresol->IsDetailKey && EmptyValue($this->tieneresol->FormValue)) {
                    $this->tieneresol->addErrorMessage(str_replace("%s", $this->tieneresol->caption(), $this->tieneresol->RequiredErrorMessage));
                }
            }
            if ($this->concafac->Visible && $this->concafac->Required) {
                if (!$this->concafac->IsDetailKey && EmptyValue($this->concafac->FormValue)) {
                    $this->concafac->addErrorMessage(str_replace("%s", $this->concafac->caption(), $this->concafac->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->concafac->FormValue)) {
                $this->concafac->addErrorMessage($this->concafac->getErrorMessage(false));
            }
            if ($this->tcomsal->Visible && $this->tcomsal->Required) {
                if (!$this->tcomsal->IsDetailKey && EmptyValue($this->tcomsal->FormValue)) {
                    $this->tcomsal->addErrorMessage(str_replace("%s", $this->tcomsal->caption(), $this->tcomsal->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->tcomsal->FormValue)) {
                $this->tcomsal->addErrorMessage($this->tcomsal->getErrorMessage(false));
            }
            if ($this->seriesal->Visible && $this->seriesal->Required) {
                if (!$this->seriesal->IsDetailKey && EmptyValue($this->seriesal->FormValue)) {
                    $this->seriesal->addErrorMessage(str_replace("%s", $this->seriesal->caption(), $this->seriesal->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->seriesal->FormValue)) {
                $this->seriesal->addErrorMessage($this->seriesal->getErrorMessage(false));
            }
            if ($this->ncompsal->Visible && $this->ncompsal->Required) {
                if (!$this->ncompsal->IsDetailKey && EmptyValue($this->ncompsal->FormValue)) {
                    $this->ncompsal->addErrorMessage(str_replace("%s", $this->ncompsal->caption(), $this->ncompsal->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->ncompsal->FormValue)) {
                $this->ncompsal->addErrorMessage($this->ncompsal->getErrorMessage(false));
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

        // Check referential integrity for master table 'cabfac'
        $detailKeys = [];
        $keyValue = $rsnew['tcomp'] ?? $rsold['tcomp'];
        $detailKeys['tcomp'] = $keyValue;
        $keyValue = $rsnew['serie'] ?? $rsold['serie'];
        $detailKeys['serie'] = $keyValue;
        $keyValue = $rsnew['ncomp'] ?? $rsold['ncomp'];
        $detailKeys['ncomp'] = $keyValue;
        $masterTable = Container("cabfac");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "cabfac", $Language->phrase("RelatedRecordRequired"));
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

        // tcomp
        if ($this->tcomp->getSessionValue() != "") {
            $this->tcomp->ReadOnly = true;
        }
        $this->tcomp->setDbValueDef($rsnew, $this->tcomp->CurrentValue, $this->tcomp->ReadOnly);

        // serie
        if ($this->serie->getSessionValue() != "") {
            $this->serie->ReadOnly = true;
        }
        $this->serie->setDbValueDef($rsnew, $this->serie->CurrentValue, $this->serie->ReadOnly);

        // ncomp
        if ($this->ncomp->getSessionValue() != "") {
            $this->ncomp->ReadOnly = true;
        }
        $this->ncomp->setDbValueDef($rsnew, $this->ncomp->CurrentValue, $this->ncomp->ReadOnly);

        // nreng
        $this->nreng->setDbValueDef($rsnew, $this->nreng->CurrentValue, $this->nreng->ReadOnly);

        // codrem
        $this->codrem->setDbValueDef($rsnew, $this->codrem->CurrentValue, $this->codrem->ReadOnly);

        // codlote
        $this->codlote->setDbValueDef($rsnew, $this->codlote->CurrentValue, $this->codlote->ReadOnly);

        // descrip
        $this->descrip->setDbValueDef($rsnew, $this->descrip->CurrentValue, $this->descrip->ReadOnly);

        // neto
        $this->neto->setDbValueDef($rsnew, $this->neto->CurrentValue, $this->neto->ReadOnly);

        // bruto
        $this->bruto->setDbValueDef($rsnew, $this->bruto->CurrentValue, $this->bruto->ReadOnly);

        // iva
        $this->iva->setDbValueDef($rsnew, $this->iva->CurrentValue, $this->iva->ReadOnly);

        // imp
        $this->imp->setDbValueDef($rsnew, $this->imp->CurrentValue, $this->imp->ReadOnly);

        // comcob
        $this->comcob->setDbValueDef($rsnew, $this->comcob->CurrentValue, $this->comcob->ReadOnly);

        // compag
        $this->compag->setDbValueDef($rsnew, $this->compag->CurrentValue, $this->compag->ReadOnly);

        // fechahora
        $this->fechahora->CurrentValue = $this->fechahora->getAutoUpdateValue(); // PHP
        $this->fechahora->setDbValueDef($rsnew, UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()));

        // usuario
        $this->usuario->CurrentValue = $this->usuario->getAutoUpdateValue(); // PHP
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue);

        // porciva
        $this->porciva->setDbValueDef($rsnew, $this->porciva->CurrentValue, $this->porciva->ReadOnly);

        // tieneresol
        $this->tieneresol->setDbValueDef($rsnew, $this->tieneresol->CurrentValue, $this->tieneresol->ReadOnly);

        // concafac
        $this->concafac->setDbValueDef($rsnew, $this->concafac->CurrentValue, $this->concafac->ReadOnly);

        // tcomsal
        $this->tcomsal->setDbValueDef($rsnew, $this->tcomsal->CurrentValue, $this->tcomsal->ReadOnly);

        // seriesal
        $this->seriesal->setDbValueDef($rsnew, $this->seriesal->CurrentValue, $this->seriesal->ReadOnly);

        // ncompsal
        $this->ncompsal->setDbValueDef($rsnew, $this->ncompsal->CurrentValue, $this->ncompsal->ReadOnly);
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
        if (isset($row['ncomp'])) { // ncomp
            $this->ncomp->CurrentValue = $row['ncomp'];
        }
        if (isset($row['nreng'])) { // nreng
            $this->nreng->CurrentValue = $row['nreng'];
        }
        if (isset($row['codrem'])) { // codrem
            $this->codrem->CurrentValue = $row['codrem'];
        }
        if (isset($row['codlote'])) { // codlote
            $this->codlote->CurrentValue = $row['codlote'];
        }
        if (isset($row['descrip'])) { // descrip
            $this->descrip->CurrentValue = $row['descrip'];
        }
        if (isset($row['neto'])) { // neto
            $this->neto->CurrentValue = $row['neto'];
        }
        if (isset($row['bruto'])) { // bruto
            $this->bruto->CurrentValue = $row['bruto'];
        }
        if (isset($row['iva'])) { // iva
            $this->iva->CurrentValue = $row['iva'];
        }
        if (isset($row['imp'])) { // imp
            $this->imp->CurrentValue = $row['imp'];
        }
        if (isset($row['comcob'])) { // comcob
            $this->comcob->CurrentValue = $row['comcob'];
        }
        if (isset($row['compag'])) { // compag
            $this->compag->CurrentValue = $row['compag'];
        }
        if (isset($row['fechahora'])) { // fechahora
            $this->fechahora->CurrentValue = $row['fechahora'];
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->CurrentValue = $row['usuario'];
        }
        if (isset($row['porciva'])) { // porciva
            $this->porciva->CurrentValue = $row['porciva'];
        }
        if (isset($row['tieneresol'])) { // tieneresol
            $this->tieneresol->CurrentValue = $row['tieneresol'];
        }
        if (isset($row['concafac'])) { // concafac
            $this->concafac->CurrentValue = $row['concafac'];
        }
        if (isset($row['tcomsal'])) { // tcomsal
            $this->tcomsal->CurrentValue = $row['tcomsal'];
        }
        if (isset($row['seriesal'])) { // seriesal
            $this->seriesal->CurrentValue = $row['seriesal'];
        }
        if (isset($row['ncompsal'])) { // ncompsal
            $this->ncompsal->CurrentValue = $row['ncompsal'];
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
            if ($masterTblVar == "cabfac") {
                $validMaster = true;
                $masterTbl = Container("cabfac");
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
            if ($masterTblVar == "cabfac") {
                $validMaster = true;
                $masterTbl = Container("cabfac");
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "cabfac") {
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("DetfacList"), "", $this->TableVar, true);
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
