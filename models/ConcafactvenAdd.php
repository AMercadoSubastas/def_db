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
class ConcafactvenAdd extends Concafactven
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ConcafactvenAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ConcafactvenAdd";

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
        $this->nroconc->setVisibility();
        $this->descrip->setVisibility();
        $this->porcentaje->setVisibility();
        $this->importe->setVisibility();
        $this->usuario->setVisibility();
        $this->fechahora->setVisibility();
        $this->activo->setVisibility();
        $this->tipoiva->setVisibility();
        $this->impuesto->setVisibility();
        $this->tieneresol->setVisibility();
        $this->ctacbleBAS->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'concafactven';
        $this->TableName = 'concafactven';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (concafactven)
        if (!isset($GLOBALS["concafactven"]) || $GLOBALS["concafactven"]::class == PROJECT_NAMESPACE . "concafactven") {
            $GLOBALS["concafactven"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'concafactven');
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
                        $result["view"] = SameString($pageName, "ConcafactvenView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->tipoiva);
        $this->setupLookupOptions($this->impuesto);
        $this->setupLookupOptions($this->tieneresol);

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
                    $this->terminate("ConcafactvenList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ConcafactvenList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ConcafactvenView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ConcafactvenList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ConcafactvenList"; // Return list page content
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
        $this->tieneresol->DefaultValue = $this->tieneresol->getDefault(); // PHP
        $this->tieneresol->OldValue = $this->tieneresol->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'nroconc' first before field var 'x_nroconc'
        $val = $CurrentForm->hasValue("nroconc") ? $CurrentForm->getValue("nroconc") : $CurrentForm->getValue("x_nroconc");
        if (!$this->nroconc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nroconc->Visible = false; // Disable update for API request
            } else {
                $this->nroconc->setFormValue($val, true, $validate);
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

        // Check field name 'porcentaje' first before field var 'x_porcentaje'
        $val = $CurrentForm->hasValue("porcentaje") ? $CurrentForm->getValue("porcentaje") : $CurrentForm->getValue("x_porcentaje");
        if (!$this->porcentaje->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porcentaje->Visible = false; // Disable update for API request
            } else {
                $this->porcentaje->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'importe' first before field var 'x_importe'
        $val = $CurrentForm->hasValue("importe") ? $CurrentForm->getValue("importe") : $CurrentForm->getValue("x_importe");
        if (!$this->importe->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->importe->Visible = false; // Disable update for API request
            } else {
                $this->importe->setFormValue($val, true, $validate);
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

        // Check field name 'activo' first before field var 'x_activo'
        $val = $CurrentForm->hasValue("activo") ? $CurrentForm->getValue("activo") : $CurrentForm->getValue("x_activo");
        if (!$this->activo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->activo->Visible = false; // Disable update for API request
            } else {
                $this->activo->setFormValue($val);
            }
        }

        // Check field name 'tipoiva' first before field var 'x_tipoiva'
        $val = $CurrentForm->hasValue("tipoiva") ? $CurrentForm->getValue("tipoiva") : $CurrentForm->getValue("x_tipoiva");
        if (!$this->tipoiva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipoiva->Visible = false; // Disable update for API request
            } else {
                $this->tipoiva->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'impuesto' first before field var 'x_impuesto'
        $val = $CurrentForm->hasValue("impuesto") ? $CurrentForm->getValue("impuesto") : $CurrentForm->getValue("x_impuesto");
        if (!$this->impuesto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->impuesto->Visible = false; // Disable update for API request
            } else {
                $this->impuesto->setFormValue($val, true, $validate);
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

        // Check field name 'ctacbleBAS' first before field var 'x_ctacbleBAS'
        $val = $CurrentForm->hasValue("ctacbleBAS") ? $CurrentForm->getValue("ctacbleBAS") : $CurrentForm->getValue("x_ctacbleBAS");
        if (!$this->ctacbleBAS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ctacbleBAS->Visible = false; // Disable update for API request
            } else {
                $this->ctacbleBAS->setFormValue($val);
            }
        }

        // Check field name 'codnum' first before field var 'x_codnum'
        $val = $CurrentForm->hasValue("codnum") ? $CurrentForm->getValue("codnum") : $CurrentForm->getValue("x_codnum");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->nroconc->CurrentValue = $this->nroconc->FormValue;
        $this->descrip->CurrentValue = $this->descrip->FormValue;
        $this->porcentaje->CurrentValue = $this->porcentaje->FormValue;
        $this->importe->CurrentValue = $this->importe->FormValue;
        $this->usuario->CurrentValue = $this->usuario->FormValue;
        $this->fechahora->CurrentValue = $this->fechahora->FormValue;
        $this->fechahora->CurrentValue = UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        $this->activo->CurrentValue = $this->activo->FormValue;
        $this->tipoiva->CurrentValue = $this->tipoiva->FormValue;
        $this->impuesto->CurrentValue = $this->impuesto->FormValue;
        $this->tieneresol->CurrentValue = $this->tieneresol->FormValue;
        $this->ctacbleBAS->CurrentValue = $this->ctacbleBAS->FormValue;
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
        $this->nroconc->setDbValue($row['nroconc']);
        $this->descrip->setDbValue($row['descrip']);
        $this->porcentaje->setDbValue($row['porcentaje']);
        $this->importe->setDbValue($row['importe']);
        $this->usuario->setDbValue($row['usuario']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->activo->setDbValue($row['activo']);
        $this->tipoiva->setDbValue($row['tipoiva']);
        $this->impuesto->setDbValue($row['impuesto']);
        $this->tieneresol->setDbValue($row['tieneresol']);
        $this->ctacbleBAS->setDbValue($row['ctacbleBAS']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['codnum'] = $this->codnum->DefaultValue;
        $row['nroconc'] = $this->nroconc->DefaultValue;
        $row['descrip'] = $this->descrip->DefaultValue;
        $row['porcentaje'] = $this->porcentaje->DefaultValue;
        $row['importe'] = $this->importe->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['fechahora'] = $this->fechahora->DefaultValue;
        $row['activo'] = $this->activo->DefaultValue;
        $row['tipoiva'] = $this->tipoiva->DefaultValue;
        $row['impuesto'] = $this->impuesto->DefaultValue;
        $row['tieneresol'] = $this->tieneresol->DefaultValue;
        $row['ctacbleBAS'] = $this->ctacbleBAS->DefaultValue;
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

        // nroconc
        $this->nroconc->RowCssClass = "row";

        // descrip
        $this->descrip->RowCssClass = "row";

        // porcentaje
        $this->porcentaje->RowCssClass = "row";

        // importe
        $this->importe->RowCssClass = "row";

        // usuario
        $this->usuario->RowCssClass = "row";

        // fechahora
        $this->fechahora->RowCssClass = "row";

        // activo
        $this->activo->RowCssClass = "row";

        // tipoiva
        $this->tipoiva->RowCssClass = "row";

        // impuesto
        $this->impuesto->RowCssClass = "row";

        // tieneresol
        $this->tieneresol->RowCssClass = "row";

        // ctacbleBAS
        $this->ctacbleBAS->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // codnum
            $this->codnum->ViewValue = $this->codnum->CurrentValue;

            // nroconc
            $this->nroconc->ViewValue = $this->nroconc->CurrentValue;
            $this->nroconc->ViewValue = FormatNumber($this->nroconc->ViewValue, $this->nroconc->formatPattern());

            // descrip
            $this->descrip->ViewValue = $this->descrip->CurrentValue;

            // porcentaje
            $this->porcentaje->ViewValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->ViewValue = FormatNumber($this->porcentaje->ViewValue, $this->porcentaje->formatPattern());

            // importe
            $this->importe->ViewValue = $this->importe->CurrentValue;
            $this->importe->ViewValue = FormatNumber($this->importe->ViewValue, $this->importe->formatPattern());

            // usuario
            $this->usuario->ViewValue = $this->usuario->CurrentValue;
            $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

            // fechahora
            $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
            $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

            // activo
            if (strval($this->activo->CurrentValue) != "") {
                $this->activo->ViewValue = $this->activo->optionCaption($this->activo->CurrentValue);
            } else {
                $this->activo->ViewValue = null;
            }

            // tipoiva
            $this->tipoiva->ViewValue = $this->tipoiva->CurrentValue;
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

            // impuesto
            $this->impuesto->ViewValue = $this->impuesto->CurrentValue;
            $curVal = strval($this->impuesto->CurrentValue);
            if ($curVal != "") {
                $this->impuesto->ViewValue = $this->impuesto->lookupCacheOption($curVal);
                if ($this->impuesto->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->impuesto->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->impuesto->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->impuesto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->impuesto->Lookup->renderViewRow($rswrk[0]);
                        $this->impuesto->ViewValue = $this->impuesto->displayValue($arwrk);
                    } else {
                        $this->impuesto->ViewValue = FormatNumber($this->impuesto->CurrentValue, $this->impuesto->formatPattern());
                    }
                }
            } else {
                $this->impuesto->ViewValue = null;
            }

            // tieneresol
            if (strval($this->tieneresol->CurrentValue) != "") {
                $this->tieneresol->ViewValue = $this->tieneresol->optionCaption($this->tieneresol->CurrentValue);
            } else {
                $this->tieneresol->ViewValue = null;
            }

            // ctacbleBAS
            $this->ctacbleBAS->ViewValue = $this->ctacbleBAS->CurrentValue;

            // nroconc
            $this->nroconc->HrefValue = "";

            // descrip
            $this->descrip->HrefValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";

            // importe
            $this->importe->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";

            // tipoiva
            $this->tipoiva->HrefValue = "";

            // impuesto
            $this->impuesto->HrefValue = "";

            // tieneresol
            $this->tieneresol->HrefValue = "";

            // ctacbleBAS
            $this->ctacbleBAS->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // nroconc
            $this->nroconc->setupEditAttributes();
            $this->nroconc->EditValue = $this->nroconc->CurrentValue;
            $this->nroconc->PlaceHolder = RemoveHtml($this->nroconc->caption());
            if (strval($this->nroconc->EditValue) != "" && is_numeric($this->nroconc->EditValue)) {
                $this->nroconc->EditValue = FormatNumber($this->nroconc->EditValue, null);
            }

            // descrip
            $this->descrip->setupEditAttributes();
            if (!$this->descrip->Raw) {
                $this->descrip->CurrentValue = HtmlDecode($this->descrip->CurrentValue);
            }
            $this->descrip->EditValue = HtmlEncode($this->descrip->CurrentValue);
            $this->descrip->PlaceHolder = RemoveHtml($this->descrip->caption());

            // porcentaje
            $this->porcentaje->setupEditAttributes();
            $this->porcentaje->EditValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->PlaceHolder = RemoveHtml($this->porcentaje->caption());
            if (strval($this->porcentaje->EditValue) != "" && is_numeric($this->porcentaje->EditValue)) {
                $this->porcentaje->EditValue = FormatNumber($this->porcentaje->EditValue, null);
            }

            // importe
            $this->importe->setupEditAttributes();
            $this->importe->EditValue = $this->importe->CurrentValue;
            $this->importe->PlaceHolder = RemoveHtml($this->importe->caption());
            if (strval($this->importe->EditValue) != "" && is_numeric($this->importe->EditValue)) {
                $this->importe->EditValue = FormatNumber($this->importe->EditValue, null);
            }

            // usuario

            // fechahora
            $this->fechahora->setupEditAttributes();
            $this->fechahora->EditValue = HtmlEncode(FormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()));
            $this->fechahora->PlaceHolder = RemoveHtml($this->fechahora->caption());

            // activo
            $this->activo->setupEditAttributes();
            $this->activo->EditValue = $this->activo->options(true);
            $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

            // tipoiva
            $this->tipoiva->setupEditAttributes();
            $this->tipoiva->EditValue = $this->tipoiva->CurrentValue;
            $curVal = strval($this->tipoiva->CurrentValue);
            if ($curVal != "") {
                $this->tipoiva->EditValue = $this->tipoiva->lookupCacheOption($curVal);
                if ($this->tipoiva->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipoiva->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->tipoiva->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->tipoiva->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipoiva->Lookup->renderViewRow($rswrk[0]);
                        $this->tipoiva->EditValue = $this->tipoiva->displayValue($arwrk);
                    } else {
                        $this->tipoiva->EditValue = HtmlEncode(FormatNumber($this->tipoiva->CurrentValue, $this->tipoiva->formatPattern()));
                    }
                }
            } else {
                $this->tipoiva->EditValue = null;
            }
            $this->tipoiva->PlaceHolder = RemoveHtml($this->tipoiva->caption());

            // impuesto
            $this->impuesto->setupEditAttributes();
            $this->impuesto->EditValue = $this->impuesto->CurrentValue;
            $curVal = strval($this->impuesto->CurrentValue);
            if ($curVal != "") {
                $this->impuesto->EditValue = $this->impuesto->lookupCacheOption($curVal);
                if ($this->impuesto->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->impuesto->Lookup->getTable()->Fields["codnum"]->searchExpression(), "=", $curVal, $this->impuesto->Lookup->getTable()->Fields["codnum"]->searchDataType(), "");
                    $sqlWrk = $this->impuesto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->impuesto->Lookup->renderViewRow($rswrk[0]);
                        $this->impuesto->EditValue = $this->impuesto->displayValue($arwrk);
                    } else {
                        $this->impuesto->EditValue = HtmlEncode(FormatNumber($this->impuesto->CurrentValue, $this->impuesto->formatPattern()));
                    }
                }
            } else {
                $this->impuesto->EditValue = null;
            }
            $this->impuesto->PlaceHolder = RemoveHtml($this->impuesto->caption());

            // tieneresol
            $this->tieneresol->setupEditAttributes();
            $this->tieneresol->EditValue = $this->tieneresol->options(true);
            $this->tieneresol->PlaceHolder = RemoveHtml($this->tieneresol->caption());

            // ctacbleBAS
            $this->ctacbleBAS->setupEditAttributes();
            if (!$this->ctacbleBAS->Raw) {
                $this->ctacbleBAS->CurrentValue = HtmlDecode($this->ctacbleBAS->CurrentValue);
            }
            $this->ctacbleBAS->EditValue = HtmlEncode($this->ctacbleBAS->CurrentValue);
            $this->ctacbleBAS->PlaceHolder = RemoveHtml($this->ctacbleBAS->caption());

            // Add refer script

            // nroconc
            $this->nroconc->HrefValue = "";

            // descrip
            $this->descrip->HrefValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";

            // importe
            $this->importe->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";

            // tipoiva
            $this->tipoiva->HrefValue = "";

            // impuesto
            $this->impuesto->HrefValue = "";

            // tieneresol
            $this->tieneresol->HrefValue = "";

            // ctacbleBAS
            $this->ctacbleBAS->HrefValue = "";
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
            if ($this->nroconc->Visible && $this->nroconc->Required) {
                if (!$this->nroconc->IsDetailKey && EmptyValue($this->nroconc->FormValue)) {
                    $this->nroconc->addErrorMessage(str_replace("%s", $this->nroconc->caption(), $this->nroconc->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->nroconc->FormValue)) {
                $this->nroconc->addErrorMessage($this->nroconc->getErrorMessage(false));
            }
            if ($this->descrip->Visible && $this->descrip->Required) {
                if (!$this->descrip->IsDetailKey && EmptyValue($this->descrip->FormValue)) {
                    $this->descrip->addErrorMessage(str_replace("%s", $this->descrip->caption(), $this->descrip->RequiredErrorMessage));
                }
            }
            if ($this->porcentaje->Visible && $this->porcentaje->Required) {
                if (!$this->porcentaje->IsDetailKey && EmptyValue($this->porcentaje->FormValue)) {
                    $this->porcentaje->addErrorMessage(str_replace("%s", $this->porcentaje->caption(), $this->porcentaje->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->porcentaje->FormValue)) {
                $this->porcentaje->addErrorMessage($this->porcentaje->getErrorMessage(false));
            }
            if ($this->importe->Visible && $this->importe->Required) {
                if (!$this->importe->IsDetailKey && EmptyValue($this->importe->FormValue)) {
                    $this->importe->addErrorMessage(str_replace("%s", $this->importe->caption(), $this->importe->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->importe->FormValue)) {
                $this->importe->addErrorMessage($this->importe->getErrorMessage(false));
            }
            if ($this->usuario->Visible && $this->usuario->Required) {
                if (!$this->usuario->IsDetailKey && EmptyValue($this->usuario->FormValue)) {
                    $this->usuario->addErrorMessage(str_replace("%s", $this->usuario->caption(), $this->usuario->RequiredErrorMessage));
                }
            }
            if ($this->fechahora->Visible && $this->fechahora->Required) {
                if (!$this->fechahora->IsDetailKey && EmptyValue($this->fechahora->FormValue)) {
                    $this->fechahora->addErrorMessage(str_replace("%s", $this->fechahora->caption(), $this->fechahora->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fechahora->FormValue, $this->fechahora->formatPattern())) {
                $this->fechahora->addErrorMessage($this->fechahora->getErrorMessage(false));
            }
            if ($this->activo->Visible && $this->activo->Required) {
                if (!$this->activo->IsDetailKey && EmptyValue($this->activo->FormValue)) {
                    $this->activo->addErrorMessage(str_replace("%s", $this->activo->caption(), $this->activo->RequiredErrorMessage));
                }
            }
            if ($this->tipoiva->Visible && $this->tipoiva->Required) {
                if (!$this->tipoiva->IsDetailKey && EmptyValue($this->tipoiva->FormValue)) {
                    $this->tipoiva->addErrorMessage(str_replace("%s", $this->tipoiva->caption(), $this->tipoiva->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->tipoiva->FormValue)) {
                $this->tipoiva->addErrorMessage($this->tipoiva->getErrorMessage(false));
            }
            if ($this->impuesto->Visible && $this->impuesto->Required) {
                if (!$this->impuesto->IsDetailKey && EmptyValue($this->impuesto->FormValue)) {
                    $this->impuesto->addErrorMessage(str_replace("%s", $this->impuesto->caption(), $this->impuesto->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->impuesto->FormValue)) {
                $this->impuesto->addErrorMessage($this->impuesto->getErrorMessage(false));
            }
            if ($this->tieneresol->Visible && $this->tieneresol->Required) {
                if (!$this->tieneresol->IsDetailKey && EmptyValue($this->tieneresol->FormValue)) {
                    $this->tieneresol->addErrorMessage(str_replace("%s", $this->tieneresol->caption(), $this->tieneresol->RequiredErrorMessage));
                }
            }
            if ($this->ctacbleBAS->Visible && $this->ctacbleBAS->Required) {
                if (!$this->ctacbleBAS->IsDetailKey && EmptyValue($this->ctacbleBAS->FormValue)) {
                    $this->ctacbleBAS->addErrorMessage(str_replace("%s", $this->ctacbleBAS->caption(), $this->ctacbleBAS->RequiredErrorMessage));
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

        // nroconc
        $this->nroconc->setDbValueDef($rsnew, $this->nroconc->CurrentValue, false);

        // descrip
        $this->descrip->setDbValueDef($rsnew, $this->descrip->CurrentValue, false);

        // porcentaje
        $this->porcentaje->setDbValueDef($rsnew, $this->porcentaje->CurrentValue, false);

        // importe
        $this->importe->setDbValueDef($rsnew, $this->importe->CurrentValue, false);

        // usuario
        $this->usuario->CurrentValue = $this->usuario->getAutoUpdateValue(); // PHP
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue);

        // fechahora
        $this->fechahora->setDbValueDef($rsnew, UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()), false);

        // activo
        $this->activo->setDbValueDef($rsnew, $this->activo->CurrentValue, strval($this->activo->CurrentValue) == "");

        // tipoiva
        $this->tipoiva->setDbValueDef($rsnew, $this->tipoiva->CurrentValue, false);

        // impuesto
        $this->impuesto->setDbValueDef($rsnew, $this->impuesto->CurrentValue, false);

        // tieneresol
        $this->tieneresol->setDbValueDef($rsnew, $this->tieneresol->CurrentValue, strval($this->tieneresol->CurrentValue) == "");

        // ctacbleBAS
        $this->ctacbleBAS->setDbValueDef($rsnew, $this->ctacbleBAS->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['nroconc'])) { // nroconc
            $this->nroconc->setFormValue($row['nroconc']);
        }
        if (isset($row['descrip'])) { // descrip
            $this->descrip->setFormValue($row['descrip']);
        }
        if (isset($row['porcentaje'])) { // porcentaje
            $this->porcentaje->setFormValue($row['porcentaje']);
        }
        if (isset($row['importe'])) { // importe
            $this->importe->setFormValue($row['importe']);
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->setFormValue($row['usuario']);
        }
        if (isset($row['fechahora'])) { // fechahora
            $this->fechahora->setFormValue($row['fechahora']);
        }
        if (isset($row['activo'])) { // activo
            $this->activo->setFormValue($row['activo']);
        }
        if (isset($row['tipoiva'])) { // tipoiva
            $this->tipoiva->setFormValue($row['tipoiva']);
        }
        if (isset($row['impuesto'])) { // impuesto
            $this->impuesto->setFormValue($row['impuesto']);
        }
        if (isset($row['tieneresol'])) { // tieneresol
            $this->tieneresol->setFormValue($row['tieneresol']);
        }
        if (isset($row['ctacbleBAS'])) { // ctacbleBAS
            $this->ctacbleBAS->setFormValue($row['ctacbleBAS']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ConcafactvenList"), "", $this->TableVar, true);
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
                case "x_tipoiva":
                    break;
                case "x_impuesto":
                    break;
                case "x_tieneresol":
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
