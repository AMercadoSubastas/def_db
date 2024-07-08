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
class CabfacEdit extends Cabfac
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "CabfacEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "CabfacEdit";

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
        $this->fecval->setVisibility();
        $this->fecdoc->setVisibility();
        $this->fecreg->setVisibility();
        $this->cliente->setVisibility();
        $this->cpago->Visible = false;
        $this->fecvenc->Visible = false;
        $this->direc->setVisibility();
        $this->dnro->setVisibility();
        $this->pisodto->setVisibility();
        $this->codpost->setVisibility();
        $this->codpais->setVisibility();
        $this->codprov->setVisibility();
        $this->codloc->setVisibility();
        $this->telef->setVisibility();
        $this->codrem->setVisibility();
        $this->estado->setVisibility();
        $this->emitido->setVisibility();
        $this->moneda->setVisibility();
        $this->totneto->setVisibility();
        $this->totbruto->setVisibility();
        $this->totiva105->setVisibility();
        $this->totiva21->setVisibility();
        $this->totimp->setVisibility();
        $this->totcomis->setVisibility();
        $this->totneto105->setVisibility();
        $this->totneto21->setVisibility();
        $this->tipoiva->Visible = false;
        $this->porciva->setVisibility();
        $this->nrengs->setVisibility();
        $this->fechahora->setVisibility();
        $this->usuario->setVisibility();
        $this->tieneresol->setVisibility();
        $this->leyendafc->setVisibility();
        $this->concepto->setVisibility();
        $this->nrodoc->setVisibility();
        $this->tcompsal->setVisibility();
        $this->seriesal->setVisibility();
        $this->ncompsal->setVisibility();
        $this->en_liquid->setVisibility();
        $this->CAE->setVisibility();
        $this->CAEFchVto->setVisibility();
        $this->Resultado->setVisibility();
        $this->usuarioultmod->setVisibility();
        $this->fecultmod->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'cabfac';
        $this->TableName = 'cabfac';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (cabfac)
        if (!isset($GLOBALS["cabfac"]) || $GLOBALS["cabfac"]::class == PROJECT_NAMESPACE . "cabfac") {
            $GLOBALS["cabfac"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'cabfac');
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
                        $result["view"] = SameString($pageName, "CabfacView"); // If View page, no primary button
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

        // Set up lookup cache
        $this->setupLookupOptions($this->tcomp);
        $this->setupLookupOptions($this->serie);
        $this->setupLookupOptions($this->cliente);
        $this->setupLookupOptions($this->codrem);
        $this->setupLookupOptions($this->estado);
        $this->setupLookupOptions($this->emitido);
        $this->setupLookupOptions($this->en_liquid);

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
                        $this->terminate("CabfacList"); // No matching record, return to list
                        return;
                    }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "CabfacList") {
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
                        if (GetPageName($returnUrl) != "CabfacList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "CabfacList"; // Return list page content
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

        // Check field name 'ncomp' first before field var 'x_ncomp'
        $val = $CurrentForm->hasValue("ncomp") ? $CurrentForm->getValue("ncomp") : $CurrentForm->getValue("x_ncomp");
        if (!$this->ncomp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ncomp->Visible = false; // Disable update for API request
            } else {
                $this->ncomp->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fecval' first before field var 'x_fecval'
        $val = $CurrentForm->hasValue("fecval") ? $CurrentForm->getValue("fecval") : $CurrentForm->getValue("x_fecval");
        if (!$this->fecval->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecval->Visible = false; // Disable update for API request
            } else {
                $this->fecval->setFormValue($val, true, $validate);
            }
            $this->fecval->CurrentValue = UnFormatDateTime($this->fecval->CurrentValue, $this->fecval->formatPattern());
        }

        // Check field name 'fecdoc' first before field var 'x_fecdoc'
        $val = $CurrentForm->hasValue("fecdoc") ? $CurrentForm->getValue("fecdoc") : $CurrentForm->getValue("x_fecdoc");
        if (!$this->fecdoc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecdoc->Visible = false; // Disable update for API request
            } else {
                $this->fecdoc->setFormValue($val, true, $validate);
            }
            $this->fecdoc->CurrentValue = UnFormatDateTime($this->fecdoc->CurrentValue, $this->fecdoc->formatPattern());
        }

        // Check field name 'fecreg' first before field var 'x_fecreg'
        $val = $CurrentForm->hasValue("fecreg") ? $CurrentForm->getValue("fecreg") : $CurrentForm->getValue("x_fecreg");
        if (!$this->fecreg->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecreg->Visible = false; // Disable update for API request
            } else {
                $this->fecreg->setFormValue($val, true, $validate);
            }
            $this->fecreg->CurrentValue = UnFormatDateTime($this->fecreg->CurrentValue, $this->fecreg->formatPattern());
        }

        // Check field name 'cliente' first before field var 'x_cliente'
        $val = $CurrentForm->hasValue("cliente") ? $CurrentForm->getValue("cliente") : $CurrentForm->getValue("x_cliente");
        if (!$this->cliente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cliente->Visible = false; // Disable update for API request
            } else {
                $this->cliente->setFormValue($val);
            }
        }

        // Check field name 'direc' first before field var 'x_direc'
        $val = $CurrentForm->hasValue("direc") ? $CurrentForm->getValue("direc") : $CurrentForm->getValue("x_direc");
        if (!$this->direc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->direc->Visible = false; // Disable update for API request
            } else {
                $this->direc->setFormValue($val);
            }
        }

        // Check field name 'dnro' first before field var 'x_dnro'
        $val = $CurrentForm->hasValue("dnro") ? $CurrentForm->getValue("dnro") : $CurrentForm->getValue("x_dnro");
        if (!$this->dnro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dnro->Visible = false; // Disable update for API request
            } else {
                $this->dnro->setFormValue($val);
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

        // Check field name 'codpost' first before field var 'x_codpost'
        $val = $CurrentForm->hasValue("codpost") ? $CurrentForm->getValue("codpost") : $CurrentForm->getValue("x_codpost");
        if (!$this->codpost->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codpost->Visible = false; // Disable update for API request
            } else {
                $this->codpost->setFormValue($val);
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

        // Check field name 'telef' first before field var 'x_telef'
        $val = $CurrentForm->hasValue("telef") ? $CurrentForm->getValue("telef") : $CurrentForm->getValue("x_telef");
        if (!$this->telef->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telef->Visible = false; // Disable update for API request
            } else {
                $this->telef->setFormValue($val);
            }
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

        // Check field name 'estado' first before field var 'x_estado'
        $val = $CurrentForm->hasValue("estado") ? $CurrentForm->getValue("estado") : $CurrentForm->getValue("x_estado");
        if (!$this->estado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estado->Visible = false; // Disable update for API request
            } else {
                $this->estado->setFormValue($val);
            }
        }

        // Check field name 'emitido' first before field var 'x_emitido'
        $val = $CurrentForm->hasValue("emitido") ? $CurrentForm->getValue("emitido") : $CurrentForm->getValue("x_emitido");
        if (!$this->emitido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->emitido->Visible = false; // Disable update for API request
            } else {
                $this->emitido->setFormValue($val);
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

        // Check field name 'totneto' first before field var 'x_totneto'
        $val = $CurrentForm->hasValue("totneto") ? $CurrentForm->getValue("totneto") : $CurrentForm->getValue("x_totneto");
        if (!$this->totneto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totneto->Visible = false; // Disable update for API request
            } else {
                $this->totneto->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totbruto' first before field var 'x_totbruto'
        $val = $CurrentForm->hasValue("totbruto") ? $CurrentForm->getValue("totbruto") : $CurrentForm->getValue("x_totbruto");
        if (!$this->totbruto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totbruto->Visible = false; // Disable update for API request
            } else {
                $this->totbruto->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totiva105' first before field var 'x_totiva105'
        $val = $CurrentForm->hasValue("totiva105") ? $CurrentForm->getValue("totiva105") : $CurrentForm->getValue("x_totiva105");
        if (!$this->totiva105->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totiva105->Visible = false; // Disable update for API request
            } else {
                $this->totiva105->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totiva21' first before field var 'x_totiva21'
        $val = $CurrentForm->hasValue("totiva21") ? $CurrentForm->getValue("totiva21") : $CurrentForm->getValue("x_totiva21");
        if (!$this->totiva21->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totiva21->Visible = false; // Disable update for API request
            } else {
                $this->totiva21->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totimp' first before field var 'x_totimp'
        $val = $CurrentForm->hasValue("totimp") ? $CurrentForm->getValue("totimp") : $CurrentForm->getValue("x_totimp");
        if (!$this->totimp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totimp->Visible = false; // Disable update for API request
            } else {
                $this->totimp->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totcomis' first before field var 'x_totcomis'
        $val = $CurrentForm->hasValue("totcomis") ? $CurrentForm->getValue("totcomis") : $CurrentForm->getValue("x_totcomis");
        if (!$this->totcomis->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totcomis->Visible = false; // Disable update for API request
            } else {
                $this->totcomis->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totneto105' first before field var 'x_totneto105'
        $val = $CurrentForm->hasValue("totneto105") ? $CurrentForm->getValue("totneto105") : $CurrentForm->getValue("x_totneto105");
        if (!$this->totneto105->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totneto105->Visible = false; // Disable update for API request
            } else {
                $this->totneto105->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totneto21' first before field var 'x_totneto21'
        $val = $CurrentForm->hasValue("totneto21") ? $CurrentForm->getValue("totneto21") : $CurrentForm->getValue("x_totneto21");
        if (!$this->totneto21->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totneto21->Visible = false; // Disable update for API request
            } else {
                $this->totneto21->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'porciva' first before field var 'x_porciva'
        $val = $CurrentForm->hasValue("porciva") ? $CurrentForm->getValue("porciva") : $CurrentForm->getValue("x_porciva");
        if (!$this->porciva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porciva->Visible = false; // Disable update for API request
            } else {
                $this->porciva->setFormValue($val);
            }
        }

        // Check field name 'nrengs' first before field var 'x_nrengs'
        $val = $CurrentForm->hasValue("nrengs") ? $CurrentForm->getValue("nrengs") : $CurrentForm->getValue("x_nrengs");
        if (!$this->nrengs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nrengs->Visible = false; // Disable update for API request
            } else {
                $this->nrengs->setFormValue($val, true, $validate);
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

        // Check field name 'tieneresol' first before field var 'x_tieneresol'
        $val = $CurrentForm->hasValue("tieneresol") ? $CurrentForm->getValue("tieneresol") : $CurrentForm->getValue("x_tieneresol");
        if (!$this->tieneresol->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tieneresol->Visible = false; // Disable update for API request
            } else {
                $this->tieneresol->setFormValue($val);
            }
        }

        // Check field name 'leyendafc' first before field var 'x_leyendafc'
        $val = $CurrentForm->hasValue("leyendafc") ? $CurrentForm->getValue("leyendafc") : $CurrentForm->getValue("x_leyendafc");
        if (!$this->leyendafc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->leyendafc->Visible = false; // Disable update for API request
            } else {
                $this->leyendafc->setFormValue($val);
            }
        }

        // Check field name 'concepto' first before field var 'x_concepto'
        $val = $CurrentForm->hasValue("concepto") ? $CurrentForm->getValue("concepto") : $CurrentForm->getValue("x_concepto");
        if (!$this->concepto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->concepto->Visible = false; // Disable update for API request
            } else {
                $this->concepto->setFormValue($val);
            }
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

        // Check field name 'tcompsal' first before field var 'x_tcompsal'
        $val = $CurrentForm->hasValue("tcompsal") ? $CurrentForm->getValue("tcompsal") : $CurrentForm->getValue("x_tcompsal");
        if (!$this->tcompsal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tcompsal->Visible = false; // Disable update for API request
            } else {
                $this->tcompsal->setFormValue($val, true, $validate);
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

        // Check field name 'en_liquid' first before field var 'x_en_liquid'
        $val = $CurrentForm->hasValue("en_liquid") ? $CurrentForm->getValue("en_liquid") : $CurrentForm->getValue("x_en_liquid");
        if (!$this->en_liquid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->en_liquid->Visible = false; // Disable update for API request
            } else {
                $this->en_liquid->setFormValue($val);
            }
        }

        // Check field name 'CAE' first before field var 'x_CAE'
        $val = $CurrentForm->hasValue("CAE") ? $CurrentForm->getValue("CAE") : $CurrentForm->getValue("x_CAE");
        if (!$this->CAE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CAE->Visible = false; // Disable update for API request
            } else {
                $this->CAE->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'CAEFchVto' first before field var 'x_CAEFchVto'
        $val = $CurrentForm->hasValue("CAEFchVto") ? $CurrentForm->getValue("CAEFchVto") : $CurrentForm->getValue("x_CAEFchVto");
        if (!$this->CAEFchVto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CAEFchVto->Visible = false; // Disable update for API request
            } else {
                $this->CAEFchVto->setFormValue($val, true, $validate);
            }
            $this->CAEFchVto->CurrentValue = UnFormatDateTime($this->CAEFchVto->CurrentValue, $this->CAEFchVto->formatPattern());
        }

        // Check field name 'Resultado' first before field var 'x_Resultado'
        $val = $CurrentForm->hasValue("Resultado") ? $CurrentForm->getValue("Resultado") : $CurrentForm->getValue("x_Resultado");
        if (!$this->Resultado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Resultado->Visible = false; // Disable update for API request
            } else {
                $this->Resultado->setFormValue($val);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->codnum->CurrentValue = $this->codnum->FormValue;
        $this->tcomp->CurrentValue = $this->tcomp->FormValue;
        $this->serie->CurrentValue = $this->serie->FormValue;
        $this->ncomp->CurrentValue = $this->ncomp->FormValue;
        $this->fecval->CurrentValue = $this->fecval->FormValue;
        $this->fecval->CurrentValue = UnFormatDateTime($this->fecval->CurrentValue, $this->fecval->formatPattern());
        $this->fecdoc->CurrentValue = $this->fecdoc->FormValue;
        $this->fecdoc->CurrentValue = UnFormatDateTime($this->fecdoc->CurrentValue, $this->fecdoc->formatPattern());
        $this->fecreg->CurrentValue = $this->fecreg->FormValue;
        $this->fecreg->CurrentValue = UnFormatDateTime($this->fecreg->CurrentValue, $this->fecreg->formatPattern());
        $this->cliente->CurrentValue = $this->cliente->FormValue;
        $this->direc->CurrentValue = $this->direc->FormValue;
        $this->dnro->CurrentValue = $this->dnro->FormValue;
        $this->pisodto->CurrentValue = $this->pisodto->FormValue;
        $this->codpost->CurrentValue = $this->codpost->FormValue;
        $this->codpais->CurrentValue = $this->codpais->FormValue;
        $this->codprov->CurrentValue = $this->codprov->FormValue;
        $this->codloc->CurrentValue = $this->codloc->FormValue;
        $this->telef->CurrentValue = $this->telef->FormValue;
        $this->codrem->CurrentValue = $this->codrem->FormValue;
        $this->estado->CurrentValue = $this->estado->FormValue;
        $this->emitido->CurrentValue = $this->emitido->FormValue;
        $this->moneda->CurrentValue = $this->moneda->FormValue;
        $this->totneto->CurrentValue = $this->totneto->FormValue;
        $this->totbruto->CurrentValue = $this->totbruto->FormValue;
        $this->totiva105->CurrentValue = $this->totiva105->FormValue;
        $this->totiva21->CurrentValue = $this->totiva21->FormValue;
        $this->totimp->CurrentValue = $this->totimp->FormValue;
        $this->totcomis->CurrentValue = $this->totcomis->FormValue;
        $this->totneto105->CurrentValue = $this->totneto105->FormValue;
        $this->totneto21->CurrentValue = $this->totneto21->FormValue;
        $this->porciva->CurrentValue = $this->porciva->FormValue;
        $this->nrengs->CurrentValue = $this->nrengs->FormValue;
        $this->fechahora->CurrentValue = $this->fechahora->FormValue;
        $this->fechahora->CurrentValue = UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        $this->usuario->CurrentValue = $this->usuario->FormValue;
        $this->tieneresol->CurrentValue = $this->tieneresol->FormValue;
        $this->leyendafc->CurrentValue = $this->leyendafc->FormValue;
        $this->concepto->CurrentValue = $this->concepto->FormValue;
        $this->nrodoc->CurrentValue = $this->nrodoc->FormValue;
        $this->tcompsal->CurrentValue = $this->tcompsal->FormValue;
        $this->seriesal->CurrentValue = $this->seriesal->FormValue;
        $this->ncompsal->CurrentValue = $this->ncompsal->FormValue;
        $this->en_liquid->CurrentValue = $this->en_liquid->FormValue;
        $this->CAE->CurrentValue = $this->CAE->FormValue;
        $this->CAEFchVto->CurrentValue = $this->CAEFchVto->FormValue;
        $this->CAEFchVto->CurrentValue = UnFormatDateTime($this->CAEFchVto->CurrentValue, $this->CAEFchVto->formatPattern());
        $this->Resultado->CurrentValue = $this->Resultado->FormValue;
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->FormValue;
        $this->fecultmod->CurrentValue = $this->fecultmod->FormValue;
        $this->fecultmod->CurrentValue = UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern());
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
        $this->fecval->setDbValue($row['fecval']);
        $this->fecdoc->setDbValue($row['fecdoc']);
        $this->fecreg->setDbValue($row['fecreg']);
        $this->cliente->setDbValue($row['cliente']);
        $this->cpago->setDbValue($row['cpago']);
        $this->fecvenc->setDbValue($row['fecvenc']);
        $this->direc->setDbValue($row['direc']);
        $this->dnro->setDbValue($row['dnro']);
        $this->pisodto->setDbValue($row['pisodto']);
        $this->codpost->setDbValue($row['codpost']);
        $this->codpais->setDbValue($row['codpais']);
        $this->codprov->setDbValue($row['codprov']);
        $this->codloc->setDbValue($row['codloc']);
        $this->telef->setDbValue($row['telef']);
        $this->codrem->setDbValue($row['codrem']);
        $this->estado->setDbValue($row['estado']);
        $this->emitido->setDbValue($row['emitido']);
        $this->moneda->setDbValue($row['moneda']);
        $this->totneto->setDbValue($row['totneto']);
        $this->totbruto->setDbValue($row['totbruto']);
        $this->totiva105->setDbValue($row['totiva105']);
        $this->totiva21->setDbValue($row['totiva21']);
        $this->totimp->setDbValue($row['totimp']);
        $this->totcomis->setDbValue($row['totcomis']);
        $this->totneto105->setDbValue($row['totneto105']);
        $this->totneto21->setDbValue($row['totneto21']);
        $this->tipoiva->setDbValue($row['tipoiva']);
        $this->porciva->setDbValue($row['porciva']);
        $this->nrengs->setDbValue($row['nrengs']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->usuario->setDbValue($row['usuario']);
        $this->tieneresol->setDbValue($row['tieneresol']);
        $this->leyendafc->setDbValue($row['leyendafc']);
        $this->concepto->setDbValue($row['concepto']);
        $this->nrodoc->setDbValue($row['nrodoc']);
        $this->tcompsal->setDbValue($row['tcompsal']);
        $this->seriesal->setDbValue($row['seriesal']);
        $this->ncompsal->setDbValue($row['ncompsal']);
        $this->en_liquid->setDbValue($row['en_liquid']);
        $this->CAE->setDbValue($row['CAE']);
        $this->CAEFchVto->setDbValue($row['CAEFchVto']);
        $this->Resultado->setDbValue($row['Resultado']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['tcomp'] = $this->tcomp->DefaultValue;
        $row['serie'] = $this->serie->DefaultValue;
        $row['ncomp'] = $this->ncomp->DefaultValue;
        $row['fecval'] = $this->fecval->DefaultValue;
        $row['fecdoc'] = $this->fecdoc->DefaultValue;
        $row['fecreg'] = $this->fecreg->DefaultValue;
        $row['cliente'] = $this->cliente->DefaultValue;
        $row['cpago'] = $this->cpago->DefaultValue;
        $row['fecvenc'] = $this->fecvenc->DefaultValue;
        $row['direc'] = $this->direc->DefaultValue;
        $row['dnro'] = $this->dnro->DefaultValue;
        $row['pisodto'] = $this->pisodto->DefaultValue;
        $row['codpost'] = $this->codpost->DefaultValue;
        $row['codpais'] = $this->codpais->DefaultValue;
        $row['codprov'] = $this->codprov->DefaultValue;
        $row['codloc'] = $this->codloc->DefaultValue;
        $row['telef'] = $this->telef->DefaultValue;
        $row['codrem'] = $this->codrem->DefaultValue;
        $row['estado'] = $this->estado->DefaultValue;
        $row['emitido'] = $this->emitido->DefaultValue;
        $row['moneda'] = $this->moneda->DefaultValue;
        $row['totneto'] = $this->totneto->DefaultValue;
        $row['totbruto'] = $this->totbruto->DefaultValue;
        $row['totiva105'] = $this->totiva105->DefaultValue;
        $row['totiva21'] = $this->totiva21->DefaultValue;
        $row['totimp'] = $this->totimp->DefaultValue;
        $row['totcomis'] = $this->totcomis->DefaultValue;
        $row['totneto105'] = $this->totneto105->DefaultValue;
        $row['totneto21'] = $this->totneto21->DefaultValue;
        $row['tipoiva'] = $this->tipoiva->DefaultValue;
        $row['porciva'] = $this->porciva->DefaultValue;
        $row['nrengs'] = $this->nrengs->DefaultValue;
        $row['fechahora'] = $this->fechahora->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['tieneresol'] = $this->tieneresol->DefaultValue;
        $row['leyendafc'] = $this->leyendafc->DefaultValue;
        $row['concepto'] = $this->concepto->DefaultValue;
        $row['nrodoc'] = $this->nrodoc->DefaultValue;
        $row['tcompsal'] = $this->tcompsal->DefaultValue;
        $row['seriesal'] = $this->seriesal->DefaultValue;
        $row['ncompsal'] = $this->ncompsal->DefaultValue;
        $row['en_liquid'] = $this->en_liquid->DefaultValue;
        $row['CAE'] = $this->CAE->DefaultValue;
        $row['CAEFchVto'] = $this->CAEFchVto->DefaultValue;
        $row['Resultado'] = $this->Resultado->DefaultValue;
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

        // tcomp
        $this->tcomp->RowCssClass = "row";

        // serie
        $this->serie->RowCssClass = "row";

        // ncomp
        $this->ncomp->RowCssClass = "row";

        // fecval
        $this->fecval->RowCssClass = "row";

        // fecdoc
        $this->fecdoc->RowCssClass = "row";

        // fecreg
        $this->fecreg->RowCssClass = "row";

        // cliente
        $this->cliente->RowCssClass = "row";

        // cpago
        $this->cpago->RowCssClass = "row";

        // fecvenc
        $this->fecvenc->RowCssClass = "row";

        // direc
        $this->direc->RowCssClass = "row";

        // dnro
        $this->dnro->RowCssClass = "row";

        // pisodto
        $this->pisodto->RowCssClass = "row";

        // codpost
        $this->codpost->RowCssClass = "row";

        // codpais
        $this->codpais->RowCssClass = "row";

        // codprov
        $this->codprov->RowCssClass = "row";

        // codloc
        $this->codloc->RowCssClass = "row";

        // telef
        $this->telef->RowCssClass = "row";

        // codrem
        $this->codrem->RowCssClass = "row";

        // estado
        $this->estado->RowCssClass = "row";

        // emitido
        $this->emitido->RowCssClass = "row";

        // moneda
        $this->moneda->RowCssClass = "row";

        // totneto
        $this->totneto->RowCssClass = "row";

        // totbruto
        $this->totbruto->RowCssClass = "row";

        // totiva105
        $this->totiva105->RowCssClass = "row";

        // totiva21
        $this->totiva21->RowCssClass = "row";

        // totimp
        $this->totimp->RowCssClass = "row";

        // totcomis
        $this->totcomis->RowCssClass = "row";

        // totneto105
        $this->totneto105->RowCssClass = "row";

        // totneto21
        $this->totneto21->RowCssClass = "row";

        // tipoiva
        $this->tipoiva->RowCssClass = "row";

        // porciva
        $this->porciva->RowCssClass = "row";

        // nrengs
        $this->nrengs->RowCssClass = "row";

        // fechahora
        $this->fechahora->RowCssClass = "row";

        // usuario
        $this->usuario->RowCssClass = "row";

        // tieneresol
        $this->tieneresol->RowCssClass = "row";

        // leyendafc
        $this->leyendafc->RowCssClass = "row";

        // concepto
        $this->concepto->RowCssClass = "row";

        // nrodoc
        $this->nrodoc->RowCssClass = "row";

        // tcompsal
        $this->tcompsal->RowCssClass = "row";

        // seriesal
        $this->seriesal->RowCssClass = "row";

        // ncompsal
        $this->ncompsal->RowCssClass = "row";

        // en_liquid
        $this->en_liquid->RowCssClass = "row";

        // CAE
        $this->CAE->RowCssClass = "row";

        // CAEFchVto
        $this->CAEFchVto->RowCssClass = "row";

        // Resultado
        $this->Resultado->RowCssClass = "row";

        // usuarioultmod
        $this->usuarioultmod->RowCssClass = "row";

        // fecultmod
        $this->fecultmod->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // codnum
            $this->codnum->ViewValue = $this->codnum->CurrentValue;

            // tcomp
            $curVal = strval($this->tcomp->CurrentValue);
            if ($curVal != "") {
                $this->tcomp->ViewValue = $this->tcomp->lookupCacheOption($curVal);
                if ($this->tcomp->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tcomp->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tcomp->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->tcomp->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
                    $sqlWrk = $this->serie->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // ncomp
            $this->ncomp->ViewValue = $this->ncomp->CurrentValue;
            $this->ncomp->ViewValue = FormatNumber($this->ncomp->ViewValue, $this->ncomp->formatPattern());

            // fecval
            $this->fecval->ViewValue = $this->fecval->CurrentValue;
            $this->fecval->ViewValue = FormatDateTime($this->fecval->ViewValue, $this->fecval->formatPattern());

            // fecdoc
            $this->fecdoc->ViewValue = $this->fecdoc->CurrentValue;
            $this->fecdoc->ViewValue = FormatDateTime($this->fecdoc->ViewValue, $this->fecdoc->formatPattern());

            // fecreg
            $this->fecreg->ViewValue = $this->fecreg->CurrentValue;
            $this->fecreg->ViewValue = FormatDateTime($this->fecreg->ViewValue, $this->fecreg->formatPattern());

            // cliente
            $curVal = strval($this->cliente->CurrentValue);
            if ($curVal != "") {
                $this->cliente->ViewValue = $this->cliente->lookupCacheOption($curVal);
                if ($this->cliente->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->cliente->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->cliente->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $lookupFilter = $this->cliente->getSelectFilter($this); // PHP
                    $sqlWrk = $this->cliente->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cliente->Lookup->renderViewRow($rswrk[0]);
                        $this->cliente->ViewValue = $this->cliente->displayValue($arwrk);
                    } else {
                        $this->cliente->ViewValue = FormatNumber($this->cliente->CurrentValue, $this->cliente->formatPattern());
                    }
                }
            } else {
                $this->cliente->ViewValue = null;
            }

            // cpago
            $this->cpago->ViewValue = $this->cpago->CurrentValue;
            $this->cpago->ViewValue = FormatNumber($this->cpago->ViewValue, $this->cpago->formatPattern());

            // fecvenc
            $this->fecvenc->ViewValue = $this->fecvenc->CurrentValue;
            $this->fecvenc->ViewValue = FormatDateTime($this->fecvenc->ViewValue, $this->fecvenc->formatPattern());

            // direc
            $this->direc->ViewValue = $this->direc->CurrentValue;

            // dnro
            $this->dnro->ViewValue = $this->dnro->CurrentValue;

            // pisodto
            $this->pisodto->ViewValue = $this->pisodto->CurrentValue;

            // codpost
            $this->codpost->ViewValue = $this->codpost->CurrentValue;

            // codpais
            $this->codpais->ViewValue = $this->codpais->CurrentValue;
            $this->codpais->ViewValue = FormatNumber($this->codpais->ViewValue, $this->codpais->formatPattern());

            // codprov
            $this->codprov->ViewValue = $this->codprov->CurrentValue;
            $this->codprov->ViewValue = FormatNumber($this->codprov->ViewValue, $this->codprov->formatPattern());

            // codloc
            $this->codloc->ViewValue = $this->codloc->CurrentValue;
            $this->codloc->ViewValue = FormatNumber($this->codloc->ViewValue, $this->codloc->formatPattern());

            // telef
            $this->telef->ViewValue = $this->telef->CurrentValue;

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

            // estado
            if (strval($this->estado->CurrentValue) != "") {
                $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
            } else {
                $this->estado->ViewValue = null;
            }

            // emitido
            if (ConvertToBool($this->emitido->CurrentValue)) {
                $this->emitido->ViewValue = $this->emitido->tagCaption(1) != "" ? $this->emitido->tagCaption(1) : "Sí";
            } else {
                $this->emitido->ViewValue = $this->emitido->tagCaption(2) != "" ? $this->emitido->tagCaption(2) : "No";
            }

            // moneda
            $this->moneda->ViewValue = $this->moneda->CurrentValue;
            $this->moneda->ViewValue = FormatNumber($this->moneda->ViewValue, $this->moneda->formatPattern());

            // totneto
            $this->totneto->ViewValue = $this->totneto->CurrentValue;
            $this->totneto->ViewValue = FormatNumber($this->totneto->ViewValue, $this->totneto->formatPattern());

            // totbruto
            $this->totbruto->ViewValue = $this->totbruto->CurrentValue;
            $this->totbruto->ViewValue = FormatNumber($this->totbruto->ViewValue, $this->totbruto->formatPattern());

            // totiva105
            $this->totiva105->ViewValue = $this->totiva105->CurrentValue;
            $this->totiva105->ViewValue = FormatNumber($this->totiva105->ViewValue, $this->totiva105->formatPattern());

            // totiva21
            $this->totiva21->ViewValue = $this->totiva21->CurrentValue;
            $this->totiva21->ViewValue = FormatNumber($this->totiva21->ViewValue, $this->totiva21->formatPattern());

            // totimp
            $this->totimp->ViewValue = $this->totimp->CurrentValue;
            $this->totimp->ViewValue = FormatNumber($this->totimp->ViewValue, $this->totimp->formatPattern());

            // totcomis
            $this->totcomis->ViewValue = $this->totcomis->CurrentValue;
            $this->totcomis->ViewValue = FormatNumber($this->totcomis->ViewValue, $this->totcomis->formatPattern());

            // totneto105
            $this->totneto105->ViewValue = $this->totneto105->CurrentValue;
            $this->totneto105->ViewValue = FormatNumber($this->totneto105->ViewValue, $this->totneto105->formatPattern());

            // totneto21
            $this->totneto21->ViewValue = $this->totneto21->CurrentValue;
            $this->totneto21->ViewValue = FormatNumber($this->totneto21->ViewValue, $this->totneto21->formatPattern());

            // tipoiva
            $this->tipoiva->ViewValue = $this->tipoiva->CurrentValue;
            $this->tipoiva->ViewValue = FormatNumber($this->tipoiva->ViewValue, $this->tipoiva->formatPattern());

            // porciva
            $this->porciva->ViewValue = $this->porciva->CurrentValue;
            $this->porciva->ViewValue = FormatNumber($this->porciva->ViewValue, $this->porciva->formatPattern());

            // nrengs
            $this->nrengs->ViewValue = $this->nrengs->CurrentValue;
            $this->nrengs->ViewValue = FormatNumber($this->nrengs->ViewValue, $this->nrengs->formatPattern());

            // fechahora
            $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
            $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

            // usuario
            $this->usuario->ViewValue = $this->usuario->CurrentValue;
            $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

            // tieneresol
            $this->tieneresol->ViewValue = $this->tieneresol->CurrentValue;

            // leyendafc
            $this->leyendafc->ViewValue = $this->leyendafc->CurrentValue;

            // concepto
            $this->concepto->ViewValue = $this->concepto->CurrentValue;

            // nrodoc
            $this->nrodoc->ViewValue = $this->nrodoc->CurrentValue;

            // tcompsal
            $this->tcompsal->ViewValue = $this->tcompsal->CurrentValue;
            $this->tcompsal->ViewValue = FormatNumber($this->tcompsal->ViewValue, $this->tcompsal->formatPattern());

            // seriesal
            $this->seriesal->ViewValue = $this->seriesal->CurrentValue;
            $this->seriesal->ViewValue = FormatNumber($this->seriesal->ViewValue, $this->seriesal->formatPattern());

            // ncompsal
            $this->ncompsal->ViewValue = $this->ncompsal->CurrentValue;
            $this->ncompsal->ViewValue = FormatNumber($this->ncompsal->ViewValue, $this->ncompsal->formatPattern());

            // en_liquid
            if (strval($this->en_liquid->CurrentValue) != "") {
                $this->en_liquid->ViewValue = $this->en_liquid->optionCaption($this->en_liquid->CurrentValue);
            } else {
                $this->en_liquid->ViewValue = null;
            }

            // CAE
            $this->CAE->ViewValue = $this->CAE->CurrentValue;
            $this->CAE->ViewValue = FormatNumber($this->CAE->ViewValue, $this->CAE->formatPattern());

            // CAEFchVto
            $this->CAEFchVto->ViewValue = $this->CAEFchVto->CurrentValue;
            $this->CAEFchVto->ViewValue = FormatDateTime($this->CAEFchVto->ViewValue, $this->CAEFchVto->formatPattern());

            // Resultado
            $this->Resultado->ViewValue = $this->Resultado->CurrentValue;

            // usuarioultmod
            $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
            $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

            // fecultmod
            $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
            $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

            // codnum
            $this->codnum->HrefValue = "";

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";

            // fecval
            $this->fecval->HrefValue = "";

            // fecdoc
            $this->fecdoc->HrefValue = "";

            // fecreg
            $this->fecreg->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // direc
            $this->direc->HrefValue = "";

            // dnro
            $this->dnro->HrefValue = "";

            // pisodto
            $this->pisodto->HrefValue = "";

            // codpost
            $this->codpost->HrefValue = "";

            // codpais
            $this->codpais->HrefValue = "";

            // codprov
            $this->codprov->HrefValue = "";

            // codloc
            $this->codloc->HrefValue = "";

            // telef
            $this->telef->HrefValue = "";

            // codrem
            $this->codrem->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // emitido
            $this->emitido->HrefValue = "";

            // moneda
            $this->moneda->HrefValue = "";

            // totneto
            $this->totneto->HrefValue = "";

            // totbruto
            $this->totbruto->HrefValue = "";

            // totiva105
            $this->totiva105->HrefValue = "";

            // totiva21
            $this->totiva21->HrefValue = "";

            // totimp
            $this->totimp->HrefValue = "";

            // totcomis
            $this->totcomis->HrefValue = "";

            // totneto105
            $this->totneto105->HrefValue = "";

            // totneto21
            $this->totneto21->HrefValue = "";

            // porciva
            $this->porciva->HrefValue = "";

            // nrengs
            $this->nrengs->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // tieneresol
            $this->tieneresol->HrefValue = "";

            // leyendafc
            $this->leyendafc->HrefValue = "";

            // concepto
            $this->concepto->HrefValue = "";

            // nrodoc
            $this->nrodoc->HrefValue = "";

            // tcompsal
            $this->tcompsal->HrefValue = "";

            // seriesal
            $this->seriesal->HrefValue = "";

            // ncompsal
            $this->ncompsal->HrefValue = "";

            // en_liquid
            $this->en_liquid->HrefValue = "";

            // CAE
            $this->CAE->HrefValue = "";

            // CAEFchVto
            $this->CAEFchVto->HrefValue = "";

            // Resultado
            $this->Resultado->HrefValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // codnum
            $this->codnum->setupEditAttributes();
            $this->codnum->EditValue = $this->codnum->CurrentValue;

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
                $sqlWrk = $this->tcomp->Lookup->getSql(true, $filterWrk, '', $this, false, true);
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
                $sqlWrk = $this->serie->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->serie->EditValue = $arwrk;
            }
            $this->serie->PlaceHolder = RemoveHtml($this->serie->caption());

            // ncomp
            $this->ncomp->setupEditAttributes();
            $this->ncomp->EditValue = $this->ncomp->CurrentValue;
            $this->ncomp->PlaceHolder = RemoveHtml($this->ncomp->caption());
            if (strval($this->ncomp->EditValue) != "" && is_numeric($this->ncomp->EditValue)) {
                $this->ncomp->EditValue = FormatNumber($this->ncomp->EditValue, null);
            }

            // fecval
            $this->fecval->setupEditAttributes();
            $this->fecval->EditValue = HtmlEncode(FormatDateTime($this->fecval->CurrentValue, $this->fecval->formatPattern()));
            $this->fecval->PlaceHolder = RemoveHtml($this->fecval->caption());

            // fecdoc
            $this->fecdoc->setupEditAttributes();
            $this->fecdoc->EditValue = HtmlEncode(FormatDateTime($this->fecdoc->CurrentValue, $this->fecdoc->formatPattern()));
            $this->fecdoc->PlaceHolder = RemoveHtml($this->fecdoc->caption());

            // fecreg
            $this->fecreg->setupEditAttributes();
            $this->fecreg->EditValue = HtmlEncode(FormatDateTime($this->fecreg->CurrentValue, $this->fecreg->formatPattern()));
            $this->fecreg->PlaceHolder = RemoveHtml($this->fecreg->caption());

            // cliente
            $this->cliente->setupEditAttributes();
            $curVal = trim(strval($this->cliente->CurrentValue));
            if ($curVal != "") {
                $this->cliente->ViewValue = $this->cliente->lookupCacheOption($curVal);
            } else {
                $this->cliente->ViewValue = $this->cliente->Lookup !== null && is_array($this->cliente->lookupOptions()) && count($this->cliente->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cliente->ViewValue !== null) { // Load from cache
                $this->cliente->EditValue = array_values($this->cliente->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cliente->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $this->cliente->CurrentValue, $this->cliente->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                }
                $lookupFilter = $this->cliente->getSelectFilter($this); // PHP
                $sqlWrk = $this->cliente->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->cliente->EditValue = $arwrk;
            }
            $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());

            // direc
            $this->direc->setupEditAttributes();

            // dnro
            $this->dnro->setupEditAttributes();

            // pisodto
            $this->pisodto->setupEditAttributes();

            // codpost
            $this->codpost->setupEditAttributes();

            // codpais
            $this->codpais->setupEditAttributes();
            $this->codpais->CurrentValue = FormatNumber($this->codpais->CurrentValue, $this->codpais->formatPattern());
            if (strval($this->codpais->EditValue) != "" && is_numeric($this->codpais->EditValue)) {
                $this->codpais->EditValue = FormatNumber($this->codpais->EditValue, null);
            }

            // codprov
            $this->codprov->setupEditAttributes();
            $this->codprov->CurrentValue = FormatNumber($this->codprov->CurrentValue, $this->codprov->formatPattern());
            if (strval($this->codprov->EditValue) != "" && is_numeric($this->codprov->EditValue)) {
                $this->codprov->EditValue = FormatNumber($this->codprov->EditValue, null);
            }

            // codloc
            $this->codloc->setupEditAttributes();
            $this->codloc->CurrentValue = FormatNumber($this->codloc->CurrentValue, $this->codloc->formatPattern());
            if (strval($this->codloc->EditValue) != "" && is_numeric($this->codloc->EditValue)) {
                $this->codloc->EditValue = FormatNumber($this->codloc->EditValue, null);
            }

            // telef
            $this->telef->setupEditAttributes();

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

            // estado
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // emitido
            $this->emitido->EditValue = $this->emitido->options(false);
            $this->emitido->PlaceHolder = RemoveHtml($this->emitido->caption());

            // moneda
            $this->moneda->setupEditAttributes();
            $this->moneda->CurrentValue = FormatNumber($this->moneda->CurrentValue, $this->moneda->formatPattern());
            if (strval($this->moneda->EditValue) != "" && is_numeric($this->moneda->EditValue)) {
                $this->moneda->EditValue = FormatNumber($this->moneda->EditValue, null);
            }

            // totneto
            $this->totneto->setupEditAttributes();
            $this->totneto->EditValue = $this->totneto->CurrentValue;
            $this->totneto->PlaceHolder = RemoveHtml($this->totneto->caption());
            if (strval($this->totneto->EditValue) != "" && is_numeric($this->totneto->EditValue)) {
                $this->totneto->EditValue = FormatNumber($this->totneto->EditValue, null);
            }

            // totbruto
            $this->totbruto->setupEditAttributes();
            $this->totbruto->EditValue = $this->totbruto->CurrentValue;
            $this->totbruto->PlaceHolder = RemoveHtml($this->totbruto->caption());
            if (strval($this->totbruto->EditValue) != "" && is_numeric($this->totbruto->EditValue)) {
                $this->totbruto->EditValue = FormatNumber($this->totbruto->EditValue, null);
            }

            // totiva105
            $this->totiva105->setupEditAttributes();
            $this->totiva105->EditValue = $this->totiva105->CurrentValue;
            $this->totiva105->PlaceHolder = RemoveHtml($this->totiva105->caption());
            if (strval($this->totiva105->EditValue) != "" && is_numeric($this->totiva105->EditValue)) {
                $this->totiva105->EditValue = FormatNumber($this->totiva105->EditValue, null);
            }

            // totiva21
            $this->totiva21->setupEditAttributes();
            $this->totiva21->EditValue = $this->totiva21->CurrentValue;
            $this->totiva21->PlaceHolder = RemoveHtml($this->totiva21->caption());
            if (strval($this->totiva21->EditValue) != "" && is_numeric($this->totiva21->EditValue)) {
                $this->totiva21->EditValue = FormatNumber($this->totiva21->EditValue, null);
            }

            // totimp
            $this->totimp->setupEditAttributes();
            $this->totimp->EditValue = $this->totimp->CurrentValue;
            $this->totimp->PlaceHolder = RemoveHtml($this->totimp->caption());
            if (strval($this->totimp->EditValue) != "" && is_numeric($this->totimp->EditValue)) {
                $this->totimp->EditValue = FormatNumber($this->totimp->EditValue, null);
            }

            // totcomis
            $this->totcomis->setupEditAttributes();
            $this->totcomis->EditValue = $this->totcomis->CurrentValue;
            $this->totcomis->PlaceHolder = RemoveHtml($this->totcomis->caption());
            if (strval($this->totcomis->EditValue) != "" && is_numeric($this->totcomis->EditValue)) {
                $this->totcomis->EditValue = FormatNumber($this->totcomis->EditValue, null);
            }

            // totneto105
            $this->totneto105->setupEditAttributes();
            $this->totneto105->EditValue = $this->totneto105->CurrentValue;
            $this->totneto105->PlaceHolder = RemoveHtml($this->totneto105->caption());
            if (strval($this->totneto105->EditValue) != "" && is_numeric($this->totneto105->EditValue)) {
                $this->totneto105->EditValue = FormatNumber($this->totneto105->EditValue, null);
            }

            // totneto21
            $this->totneto21->setupEditAttributes();
            $this->totneto21->EditValue = $this->totneto21->CurrentValue;
            $this->totneto21->PlaceHolder = RemoveHtml($this->totneto21->caption());
            if (strval($this->totneto21->EditValue) != "" && is_numeric($this->totneto21->EditValue)) {
                $this->totneto21->EditValue = FormatNumber($this->totneto21->EditValue, null);
            }

            // porciva
            $this->porciva->setupEditAttributes();
            $this->porciva->CurrentValue = FormatNumber($this->porciva->CurrentValue, $this->porciva->formatPattern());
            if (strval($this->porciva->EditValue) != "" && is_numeric($this->porciva->EditValue)) {
                $this->porciva->EditValue = FormatNumber($this->porciva->EditValue, null);
            }

            // nrengs
            $this->nrengs->setupEditAttributes();
            $this->nrengs->EditValue = $this->nrengs->CurrentValue;
            $this->nrengs->PlaceHolder = RemoveHtml($this->nrengs->caption());
            if (strval($this->nrengs->EditValue) != "" && is_numeric($this->nrengs->EditValue)) {
                $this->nrengs->EditValue = FormatNumber($this->nrengs->EditValue, null);
            }

            // fechahora

            // usuario

            // tieneresol
            $this->tieneresol->setupEditAttributes();
            if (strval($this->tieneresol->EditValue) != "" && is_numeric($this->tieneresol->EditValue)) {
                $this->tieneresol->EditValue = $this->tieneresol->EditValue;
            }

            // leyendafc
            $this->leyendafc->setupEditAttributes();

            // concepto
            $this->concepto->setupEditAttributes();
            if (!$this->concepto->Raw) {
                $this->concepto->CurrentValue = HtmlDecode($this->concepto->CurrentValue);
            }
            $this->concepto->EditValue = HtmlEncode($this->concepto->CurrentValue);
            $this->concepto->PlaceHolder = RemoveHtml($this->concepto->caption());

            // nrodoc
            $this->nrodoc->setupEditAttributes();
            if (!$this->nrodoc->Raw) {
                $this->nrodoc->CurrentValue = HtmlDecode($this->nrodoc->CurrentValue);
            }
            $this->nrodoc->EditValue = HtmlEncode($this->nrodoc->CurrentValue);
            $this->nrodoc->PlaceHolder = RemoveHtml($this->nrodoc->caption());

            // tcompsal
            $this->tcompsal->setupEditAttributes();
            $this->tcompsal->EditValue = $this->tcompsal->CurrentValue;
            $this->tcompsal->PlaceHolder = RemoveHtml($this->tcompsal->caption());
            if (strval($this->tcompsal->EditValue) != "" && is_numeric($this->tcompsal->EditValue)) {
                $this->tcompsal->EditValue = FormatNumber($this->tcompsal->EditValue, null);
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

            // en_liquid
            $this->en_liquid->EditValue = $this->en_liquid->options(false);
            $this->en_liquid->PlaceHolder = RemoveHtml($this->en_liquid->caption());

            // CAE
            $this->CAE->setupEditAttributes();
            $this->CAE->EditValue = $this->CAE->CurrentValue;
            $this->CAE->PlaceHolder = RemoveHtml($this->CAE->caption());
            if (strval($this->CAE->EditValue) != "" && is_numeric($this->CAE->EditValue)) {
                $this->CAE->EditValue = FormatNumber($this->CAE->EditValue, null);
            }

            // CAEFchVto
            $this->CAEFchVto->setupEditAttributes();
            $this->CAEFchVto->EditValue = HtmlEncode(FormatDateTime($this->CAEFchVto->CurrentValue, $this->CAEFchVto->formatPattern()));
            $this->CAEFchVto->PlaceHolder = RemoveHtml($this->CAEFchVto->caption());

            // Resultado
            $this->Resultado->setupEditAttributes();
            if (!$this->Resultado->Raw) {
                $this->Resultado->CurrentValue = HtmlDecode($this->Resultado->CurrentValue);
            }
            $this->Resultado->EditValue = HtmlEncode($this->Resultado->CurrentValue);
            $this->Resultado->PlaceHolder = RemoveHtml($this->Resultado->caption());

            // usuarioultmod

            // fecultmod

            // Edit refer script

            // codnum
            $this->codnum->HrefValue = "";

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";

            // fecval
            $this->fecval->HrefValue = "";

            // fecdoc
            $this->fecdoc->HrefValue = "";

            // fecreg
            $this->fecreg->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // direc
            $this->direc->HrefValue = "";

            // dnro
            $this->dnro->HrefValue = "";

            // pisodto
            $this->pisodto->HrefValue = "";

            // codpost
            $this->codpost->HrefValue = "";

            // codpais
            $this->codpais->HrefValue = "";

            // codprov
            $this->codprov->HrefValue = "";

            // codloc
            $this->codloc->HrefValue = "";

            // telef
            $this->telef->HrefValue = "";

            // codrem
            $this->codrem->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // emitido
            $this->emitido->HrefValue = "";

            // moneda
            $this->moneda->HrefValue = "";

            // totneto
            $this->totneto->HrefValue = "";

            // totbruto
            $this->totbruto->HrefValue = "";

            // totiva105
            $this->totiva105->HrefValue = "";

            // totiva21
            $this->totiva21->HrefValue = "";

            // totimp
            $this->totimp->HrefValue = "";

            // totcomis
            $this->totcomis->HrefValue = "";

            // totneto105
            $this->totneto105->HrefValue = "";

            // totneto21
            $this->totneto21->HrefValue = "";

            // porciva
            $this->porciva->HrefValue = "";

            // nrengs
            $this->nrengs->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // tieneresol
            $this->tieneresol->HrefValue = "";

            // leyendafc
            $this->leyendafc->HrefValue = "";

            // concepto
            $this->concepto->HrefValue = "";

            // nrodoc
            $this->nrodoc->HrefValue = "";

            // tcompsal
            $this->tcompsal->HrefValue = "";

            // seriesal
            $this->seriesal->HrefValue = "";

            // ncompsal
            $this->ncompsal->HrefValue = "";

            // en_liquid
            $this->en_liquid->HrefValue = "";

            // CAE
            $this->CAE->HrefValue = "";

            // CAEFchVto
            $this->CAEFchVto->HrefValue = "";

            // Resultado
            $this->Resultado->HrefValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";
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
            if ($this->serie->Visible && $this->serie->Required) {
                if (!$this->serie->IsDetailKey && EmptyValue($this->serie->FormValue)) {
                    $this->serie->addErrorMessage(str_replace("%s", $this->serie->caption(), $this->serie->RequiredErrorMessage));
                }
            }
            if ($this->ncomp->Visible && $this->ncomp->Required) {
                if (!$this->ncomp->IsDetailKey && EmptyValue($this->ncomp->FormValue)) {
                    $this->ncomp->addErrorMessage(str_replace("%s", $this->ncomp->caption(), $this->ncomp->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->ncomp->FormValue)) {
                $this->ncomp->addErrorMessage($this->ncomp->getErrorMessage(false));
            }
            if ($this->fecval->Visible && $this->fecval->Required) {
                if (!$this->fecval->IsDetailKey && EmptyValue($this->fecval->FormValue)) {
                    $this->fecval->addErrorMessage(str_replace("%s", $this->fecval->caption(), $this->fecval->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecval->FormValue, $this->fecval->formatPattern())) {
                $this->fecval->addErrorMessage($this->fecval->getErrorMessage(false));
            }
            if ($this->fecdoc->Visible && $this->fecdoc->Required) {
                if (!$this->fecdoc->IsDetailKey && EmptyValue($this->fecdoc->FormValue)) {
                    $this->fecdoc->addErrorMessage(str_replace("%s", $this->fecdoc->caption(), $this->fecdoc->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecdoc->FormValue, $this->fecdoc->formatPattern())) {
                $this->fecdoc->addErrorMessage($this->fecdoc->getErrorMessage(false));
            }
            if ($this->fecreg->Visible && $this->fecreg->Required) {
                if (!$this->fecreg->IsDetailKey && EmptyValue($this->fecreg->FormValue)) {
                    $this->fecreg->addErrorMessage(str_replace("%s", $this->fecreg->caption(), $this->fecreg->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecreg->FormValue, $this->fecreg->formatPattern())) {
                $this->fecreg->addErrorMessage($this->fecreg->getErrorMessage(false));
            }
            if ($this->cliente->Visible && $this->cliente->Required) {
                if (!$this->cliente->IsDetailKey && EmptyValue($this->cliente->FormValue)) {
                    $this->cliente->addErrorMessage(str_replace("%s", $this->cliente->caption(), $this->cliente->RequiredErrorMessage));
                }
            }
            if ($this->direc->Visible && $this->direc->Required) {
                if (!$this->direc->IsDetailKey && EmptyValue($this->direc->FormValue)) {
                    $this->direc->addErrorMessage(str_replace("%s", $this->direc->caption(), $this->direc->RequiredErrorMessage));
                }
            }
            if ($this->dnro->Visible && $this->dnro->Required) {
                if (!$this->dnro->IsDetailKey && EmptyValue($this->dnro->FormValue)) {
                    $this->dnro->addErrorMessage(str_replace("%s", $this->dnro->caption(), $this->dnro->RequiredErrorMessage));
                }
            }
            if ($this->pisodto->Visible && $this->pisodto->Required) {
                if (!$this->pisodto->IsDetailKey && EmptyValue($this->pisodto->FormValue)) {
                    $this->pisodto->addErrorMessage(str_replace("%s", $this->pisodto->caption(), $this->pisodto->RequiredErrorMessage));
                }
            }
            if ($this->codpost->Visible && $this->codpost->Required) {
                if (!$this->codpost->IsDetailKey && EmptyValue($this->codpost->FormValue)) {
                    $this->codpost->addErrorMessage(str_replace("%s", $this->codpost->caption(), $this->codpost->RequiredErrorMessage));
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
            if ($this->telef->Visible && $this->telef->Required) {
                if (!$this->telef->IsDetailKey && EmptyValue($this->telef->FormValue)) {
                    $this->telef->addErrorMessage(str_replace("%s", $this->telef->caption(), $this->telef->RequiredErrorMessage));
                }
            }
            if ($this->codrem->Visible && $this->codrem->Required) {
                if (!$this->codrem->IsDetailKey && EmptyValue($this->codrem->FormValue)) {
                    $this->codrem->addErrorMessage(str_replace("%s", $this->codrem->caption(), $this->codrem->RequiredErrorMessage));
                }
            }
            if ($this->estado->Visible && $this->estado->Required) {
                if ($this->estado->FormValue == "") {
                    $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
                }
            }
            if ($this->emitido->Visible && $this->emitido->Required) {
                if ($this->emitido->FormValue == "") {
                    $this->emitido->addErrorMessage(str_replace("%s", $this->emitido->caption(), $this->emitido->RequiredErrorMessage));
                }
            }
            if ($this->moneda->Visible && $this->moneda->Required) {
                if (!$this->moneda->IsDetailKey && EmptyValue($this->moneda->FormValue)) {
                    $this->moneda->addErrorMessage(str_replace("%s", $this->moneda->caption(), $this->moneda->RequiredErrorMessage));
                }
            }
            if ($this->totneto->Visible && $this->totneto->Required) {
                if (!$this->totneto->IsDetailKey && EmptyValue($this->totneto->FormValue)) {
                    $this->totneto->addErrorMessage(str_replace("%s", $this->totneto->caption(), $this->totneto->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totneto->FormValue)) {
                $this->totneto->addErrorMessage($this->totneto->getErrorMessage(false));
            }
            if ($this->totbruto->Visible && $this->totbruto->Required) {
                if (!$this->totbruto->IsDetailKey && EmptyValue($this->totbruto->FormValue)) {
                    $this->totbruto->addErrorMessage(str_replace("%s", $this->totbruto->caption(), $this->totbruto->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totbruto->FormValue)) {
                $this->totbruto->addErrorMessage($this->totbruto->getErrorMessage(false));
            }
            if ($this->totiva105->Visible && $this->totiva105->Required) {
                if (!$this->totiva105->IsDetailKey && EmptyValue($this->totiva105->FormValue)) {
                    $this->totiva105->addErrorMessage(str_replace("%s", $this->totiva105->caption(), $this->totiva105->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totiva105->FormValue)) {
                $this->totiva105->addErrorMessage($this->totiva105->getErrorMessage(false));
            }
            if ($this->totiva21->Visible && $this->totiva21->Required) {
                if (!$this->totiva21->IsDetailKey && EmptyValue($this->totiva21->FormValue)) {
                    $this->totiva21->addErrorMessage(str_replace("%s", $this->totiva21->caption(), $this->totiva21->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totiva21->FormValue)) {
                $this->totiva21->addErrorMessage($this->totiva21->getErrorMessage(false));
            }
            if ($this->totimp->Visible && $this->totimp->Required) {
                if (!$this->totimp->IsDetailKey && EmptyValue($this->totimp->FormValue)) {
                    $this->totimp->addErrorMessage(str_replace("%s", $this->totimp->caption(), $this->totimp->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totimp->FormValue)) {
                $this->totimp->addErrorMessage($this->totimp->getErrorMessage(false));
            }
            if ($this->totcomis->Visible && $this->totcomis->Required) {
                if (!$this->totcomis->IsDetailKey && EmptyValue($this->totcomis->FormValue)) {
                    $this->totcomis->addErrorMessage(str_replace("%s", $this->totcomis->caption(), $this->totcomis->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totcomis->FormValue)) {
                $this->totcomis->addErrorMessage($this->totcomis->getErrorMessage(false));
            }
            if ($this->totneto105->Visible && $this->totneto105->Required) {
                if (!$this->totneto105->IsDetailKey && EmptyValue($this->totneto105->FormValue)) {
                    $this->totneto105->addErrorMessage(str_replace("%s", $this->totneto105->caption(), $this->totneto105->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totneto105->FormValue)) {
                $this->totneto105->addErrorMessage($this->totneto105->getErrorMessage(false));
            }
            if ($this->totneto21->Visible && $this->totneto21->Required) {
                if (!$this->totneto21->IsDetailKey && EmptyValue($this->totneto21->FormValue)) {
                    $this->totneto21->addErrorMessage(str_replace("%s", $this->totneto21->caption(), $this->totneto21->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totneto21->FormValue)) {
                $this->totneto21->addErrorMessage($this->totneto21->getErrorMessage(false));
            }
            if ($this->porciva->Visible && $this->porciva->Required) {
                if (!$this->porciva->IsDetailKey && EmptyValue($this->porciva->FormValue)) {
                    $this->porciva->addErrorMessage(str_replace("%s", $this->porciva->caption(), $this->porciva->RequiredErrorMessage));
                }
            }
            if ($this->nrengs->Visible && $this->nrengs->Required) {
                if (!$this->nrengs->IsDetailKey && EmptyValue($this->nrengs->FormValue)) {
                    $this->nrengs->addErrorMessage(str_replace("%s", $this->nrengs->caption(), $this->nrengs->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->nrengs->FormValue)) {
                $this->nrengs->addErrorMessage($this->nrengs->getErrorMessage(false));
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
            if ($this->tieneresol->Visible && $this->tieneresol->Required) {
                if (!$this->tieneresol->IsDetailKey && EmptyValue($this->tieneresol->FormValue)) {
                    $this->tieneresol->addErrorMessage(str_replace("%s", $this->tieneresol->caption(), $this->tieneresol->RequiredErrorMessage));
                }
            }
            if ($this->leyendafc->Visible && $this->leyendafc->Required) {
                if (!$this->leyendafc->IsDetailKey && EmptyValue($this->leyendafc->FormValue)) {
                    $this->leyendafc->addErrorMessage(str_replace("%s", $this->leyendafc->caption(), $this->leyendafc->RequiredErrorMessage));
                }
            }
            if ($this->concepto->Visible && $this->concepto->Required) {
                if (!$this->concepto->IsDetailKey && EmptyValue($this->concepto->FormValue)) {
                    $this->concepto->addErrorMessage(str_replace("%s", $this->concepto->caption(), $this->concepto->RequiredErrorMessage));
                }
            }
            if ($this->nrodoc->Visible && $this->nrodoc->Required) {
                if (!$this->nrodoc->IsDetailKey && EmptyValue($this->nrodoc->FormValue)) {
                    $this->nrodoc->addErrorMessage(str_replace("%s", $this->nrodoc->caption(), $this->nrodoc->RequiredErrorMessage));
                }
            }
            if ($this->tcompsal->Visible && $this->tcompsal->Required) {
                if (!$this->tcompsal->IsDetailKey && EmptyValue($this->tcompsal->FormValue)) {
                    $this->tcompsal->addErrorMessage(str_replace("%s", $this->tcompsal->caption(), $this->tcompsal->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->tcompsal->FormValue)) {
                $this->tcompsal->addErrorMessage($this->tcompsal->getErrorMessage(false));
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
            if ($this->en_liquid->Visible && $this->en_liquid->Required) {
                if ($this->en_liquid->FormValue == "") {
                    $this->en_liquid->addErrorMessage(str_replace("%s", $this->en_liquid->caption(), $this->en_liquid->RequiredErrorMessage));
                }
            }
            if ($this->CAE->Visible && $this->CAE->Required) {
                if (!$this->CAE->IsDetailKey && EmptyValue($this->CAE->FormValue)) {
                    $this->CAE->addErrorMessage(str_replace("%s", $this->CAE->caption(), $this->CAE->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->CAE->FormValue)) {
                $this->CAE->addErrorMessage($this->CAE->getErrorMessage(false));
            }
            if ($this->CAEFchVto->Visible && $this->CAEFchVto->Required) {
                if (!$this->CAEFchVto->IsDetailKey && EmptyValue($this->CAEFchVto->FormValue)) {
                    $this->CAEFchVto->addErrorMessage(str_replace("%s", $this->CAEFchVto->caption(), $this->CAEFchVto->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->CAEFchVto->FormValue, $this->CAEFchVto->formatPattern())) {
                $this->CAEFchVto->addErrorMessage($this->CAEFchVto->getErrorMessage(false));
            }
            if ($this->Resultado->Visible && $this->Resultado->Required) {
                if (!$this->Resultado->IsDetailKey && EmptyValue($this->Resultado->FormValue)) {
                    $this->Resultado->addErrorMessage(str_replace("%s", $this->Resultado->caption(), $this->Resultado->RequiredErrorMessage));
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

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("DetfacGrid");
        if (in_array("detfac", $detailTblVar) && $detailPage->DetailEdit) {
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
            $detailPage = Container("DetfacGrid");
            if (in_array("detfac", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "detfac"); // Load user level of detail table
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

        // ncomp
        $this->ncomp->setDbValueDef($rsnew, $this->ncomp->CurrentValue, $this->ncomp->ReadOnly);

        // fecval
        $this->fecval->setDbValueDef($rsnew, UnFormatDateTime($this->fecval->CurrentValue, $this->fecval->formatPattern()), $this->fecval->ReadOnly);

        // fecdoc
        $this->fecdoc->setDbValueDef($rsnew, UnFormatDateTime($this->fecdoc->CurrentValue, $this->fecdoc->formatPattern()), $this->fecdoc->ReadOnly);

        // fecreg
        $this->fecreg->setDbValueDef($rsnew, UnFormatDateTime($this->fecreg->CurrentValue, $this->fecreg->formatPattern()), $this->fecreg->ReadOnly);

        // cliente
        $this->cliente->setDbValueDef($rsnew, $this->cliente->CurrentValue, $this->cliente->ReadOnly);

        // direc
        $this->direc->setDbValueDef($rsnew, $this->direc->CurrentValue, $this->direc->ReadOnly);

        // dnro
        $this->dnro->setDbValueDef($rsnew, $this->dnro->CurrentValue, $this->dnro->ReadOnly);

        // pisodto
        $this->pisodto->setDbValueDef($rsnew, $this->pisodto->CurrentValue, $this->pisodto->ReadOnly);

        // codpost
        $this->codpost->setDbValueDef($rsnew, $this->codpost->CurrentValue, $this->codpost->ReadOnly);

        // codpais
        $this->codpais->setDbValueDef($rsnew, $this->codpais->CurrentValue, $this->codpais->ReadOnly);

        // codprov
        $this->codprov->setDbValueDef($rsnew, $this->codprov->CurrentValue, $this->codprov->ReadOnly);

        // codloc
        $this->codloc->setDbValueDef($rsnew, $this->codloc->CurrentValue, $this->codloc->ReadOnly);

        // telef
        $this->telef->setDbValueDef($rsnew, $this->telef->CurrentValue, $this->telef->ReadOnly);

        // codrem
        $this->codrem->setDbValueDef($rsnew, $this->codrem->CurrentValue, $this->codrem->ReadOnly);

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, $this->estado->ReadOnly);

        // emitido
        $tmpBool = $this->emitido->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->emitido->setDbValueDef($rsnew, $tmpBool, $this->emitido->ReadOnly);

        // moneda
        $this->moneda->setDbValueDef($rsnew, $this->moneda->CurrentValue, $this->moneda->ReadOnly);

        // totneto
        $this->totneto->setDbValueDef($rsnew, $this->totneto->CurrentValue, $this->totneto->ReadOnly);

        // totbruto
        $this->totbruto->setDbValueDef($rsnew, $this->totbruto->CurrentValue, $this->totbruto->ReadOnly);

        // totiva105
        $this->totiva105->setDbValueDef($rsnew, $this->totiva105->CurrentValue, $this->totiva105->ReadOnly);

        // totiva21
        $this->totiva21->setDbValueDef($rsnew, $this->totiva21->CurrentValue, $this->totiva21->ReadOnly);

        // totimp
        $this->totimp->setDbValueDef($rsnew, $this->totimp->CurrentValue, $this->totimp->ReadOnly);

        // totcomis
        $this->totcomis->setDbValueDef($rsnew, $this->totcomis->CurrentValue, $this->totcomis->ReadOnly);

        // totneto105
        $this->totneto105->setDbValueDef($rsnew, $this->totneto105->CurrentValue, $this->totneto105->ReadOnly);

        // totneto21
        $this->totneto21->setDbValueDef($rsnew, $this->totneto21->CurrentValue, $this->totneto21->ReadOnly);

        // porciva
        $this->porciva->setDbValueDef($rsnew, $this->porciva->CurrentValue, $this->porciva->ReadOnly);

        // nrengs
        $this->nrengs->setDbValueDef($rsnew, $this->nrengs->CurrentValue, $this->nrengs->ReadOnly);

        // fechahora
        $this->fechahora->CurrentValue = $this->fechahora->getAutoUpdateValue(); // PHP
        $this->fechahora->setDbValueDef($rsnew, UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()), $this->fechahora->ReadOnly);

        // usuario
        $this->usuario->CurrentValue = $this->usuario->getAutoUpdateValue(); // PHP
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue, $this->usuario->ReadOnly);

        // tieneresol
        $this->tieneresol->setDbValueDef($rsnew, $this->tieneresol->CurrentValue, $this->tieneresol->ReadOnly);

        // leyendafc
        $this->leyendafc->setDbValueDef($rsnew, $this->leyendafc->CurrentValue, $this->leyendafc->ReadOnly);

        // concepto
        $this->concepto->setDbValueDef($rsnew, $this->concepto->CurrentValue, $this->concepto->ReadOnly);

        // nrodoc
        $this->nrodoc->setDbValueDef($rsnew, $this->nrodoc->CurrentValue, $this->nrodoc->ReadOnly);

        // tcompsal
        $this->tcompsal->setDbValueDef($rsnew, $this->tcompsal->CurrentValue, $this->tcompsal->ReadOnly);

        // seriesal
        $this->seriesal->setDbValueDef($rsnew, $this->seriesal->CurrentValue, $this->seriesal->ReadOnly);

        // ncompsal
        $this->ncompsal->setDbValueDef($rsnew, $this->ncompsal->CurrentValue, $this->ncompsal->ReadOnly);

        // en_liquid
        $this->en_liquid->setDbValueDef($rsnew, $this->en_liquid->CurrentValue, $this->en_liquid->ReadOnly);

        // CAE
        $this->CAE->setDbValueDef($rsnew, $this->CAE->CurrentValue, $this->CAE->ReadOnly);

        // CAEFchVto
        $this->CAEFchVto->setDbValueDef($rsnew, UnFormatDateTime($this->CAEFchVto->CurrentValue, $this->CAEFchVto->formatPattern()), $this->CAEFchVto->ReadOnly);

        // Resultado
        $this->Resultado->setDbValueDef($rsnew, $this->Resultado->CurrentValue, $this->Resultado->ReadOnly);

        // usuarioultmod
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->getAutoUpdateValue(); // PHP
        $this->usuarioultmod->setDbValueDef($rsnew, $this->usuarioultmod->CurrentValue, $this->usuarioultmod->ReadOnly);

        // fecultmod
        $this->fecultmod->CurrentValue = $this->fecultmod->getAutoUpdateValue(); // PHP
        $this->fecultmod->setDbValueDef($rsnew, UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern()), $this->fecultmod->ReadOnly);
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
        if (isset($row['fecval'])) { // fecval
            $this->fecval->CurrentValue = $row['fecval'];
        }
        if (isset($row['fecdoc'])) { // fecdoc
            $this->fecdoc->CurrentValue = $row['fecdoc'];
        }
        if (isset($row['fecreg'])) { // fecreg
            $this->fecreg->CurrentValue = $row['fecreg'];
        }
        if (isset($row['cliente'])) { // cliente
            $this->cliente->CurrentValue = $row['cliente'];
        }
        if (isset($row['direc'])) { // direc
            $this->direc->CurrentValue = $row['direc'];
        }
        if (isset($row['dnro'])) { // dnro
            $this->dnro->CurrentValue = $row['dnro'];
        }
        if (isset($row['pisodto'])) { // pisodto
            $this->pisodto->CurrentValue = $row['pisodto'];
        }
        if (isset($row['codpost'])) { // codpost
            $this->codpost->CurrentValue = $row['codpost'];
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
        if (isset($row['telef'])) { // telef
            $this->telef->CurrentValue = $row['telef'];
        }
        if (isset($row['codrem'])) { // codrem
            $this->codrem->CurrentValue = $row['codrem'];
        }
        if (isset($row['estado'])) { // estado
            $this->estado->CurrentValue = $row['estado'];
        }
        if (isset($row['emitido'])) { // emitido
            $this->emitido->CurrentValue = $row['emitido'];
        }
        if (isset($row['moneda'])) { // moneda
            $this->moneda->CurrentValue = $row['moneda'];
        }
        if (isset($row['totneto'])) { // totneto
            $this->totneto->CurrentValue = $row['totneto'];
        }
        if (isset($row['totbruto'])) { // totbruto
            $this->totbruto->CurrentValue = $row['totbruto'];
        }
        if (isset($row['totiva105'])) { // totiva105
            $this->totiva105->CurrentValue = $row['totiva105'];
        }
        if (isset($row['totiva21'])) { // totiva21
            $this->totiva21->CurrentValue = $row['totiva21'];
        }
        if (isset($row['totimp'])) { // totimp
            $this->totimp->CurrentValue = $row['totimp'];
        }
        if (isset($row['totcomis'])) { // totcomis
            $this->totcomis->CurrentValue = $row['totcomis'];
        }
        if (isset($row['totneto105'])) { // totneto105
            $this->totneto105->CurrentValue = $row['totneto105'];
        }
        if (isset($row['totneto21'])) { // totneto21
            $this->totneto21->CurrentValue = $row['totneto21'];
        }
        if (isset($row['porciva'])) { // porciva
            $this->porciva->CurrentValue = $row['porciva'];
        }
        if (isset($row['nrengs'])) { // nrengs
            $this->nrengs->CurrentValue = $row['nrengs'];
        }
        if (isset($row['fechahora'])) { // fechahora
            $this->fechahora->CurrentValue = $row['fechahora'];
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->CurrentValue = $row['usuario'];
        }
        if (isset($row['tieneresol'])) { // tieneresol
            $this->tieneresol->CurrentValue = $row['tieneresol'];
        }
        if (isset($row['leyendafc'])) { // leyendafc
            $this->leyendafc->CurrentValue = $row['leyendafc'];
        }
        if (isset($row['concepto'])) { // concepto
            $this->concepto->CurrentValue = $row['concepto'];
        }
        if (isset($row['nrodoc'])) { // nrodoc
            $this->nrodoc->CurrentValue = $row['nrodoc'];
        }
        if (isset($row['tcompsal'])) { // tcompsal
            $this->tcompsal->CurrentValue = $row['tcompsal'];
        }
        if (isset($row['seriesal'])) { // seriesal
            $this->seriesal->CurrentValue = $row['seriesal'];
        }
        if (isset($row['ncompsal'])) { // ncompsal
            $this->ncompsal->CurrentValue = $row['ncompsal'];
        }
        if (isset($row['en_liquid'])) { // en_liquid
            $this->en_liquid->CurrentValue = $row['en_liquid'];
        }
        if (isset($row['CAE'])) { // CAE
            $this->CAE->CurrentValue = $row['CAE'];
        }
        if (isset($row['CAEFchVto'])) { // CAEFchVto
            $this->CAEFchVto->CurrentValue = $row['CAEFchVto'];
        }
        if (isset($row['Resultado'])) { // Resultado
            $this->Resultado->CurrentValue = $row['Resultado'];
        }
        if (isset($row['usuarioultmod'])) { // usuarioultmod
            $this->usuarioultmod->CurrentValue = $row['usuarioultmod'];
        }
        if (isset($row['fecultmod'])) { // fecultmod
            $this->fecultmod->CurrentValue = $row['fecultmod'];
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
            if (in_array("detfac", $detailTblVar)) {
                $detailPageObj = Container("DetfacGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->tcomp->IsDetailKey = true;
                    $detailPageObj->tcomp->CurrentValue = $this->tcomp->CurrentValue;
                    $detailPageObj->tcomp->setSessionValue($detailPageObj->tcomp->CurrentValue);
                    $detailPageObj->serie->IsDetailKey = true;
                    $detailPageObj->serie->CurrentValue = $this->serie->CurrentValue;
                    $detailPageObj->serie->setSessionValue($detailPageObj->serie->CurrentValue);
                    $detailPageObj->ncomp->IsDetailKey = true;
                    $detailPageObj->ncomp->CurrentValue = $this->ncomp->CurrentValue;
                    $detailPageObj->ncomp->setSessionValue($detailPageObj->ncomp->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CabfacList"), "", $this->TableVar, true);
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
                    break;
                case "x_serie":
                    break;
                case "x_cliente":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_codrem":
                    break;
                case "x_estado":
                    break;
                case "x_emitido":
                    break;
                case "x_en_liquid":
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
