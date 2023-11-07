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
class LiquidacionAdd extends Liquidacion
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "LiquidacionAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "LiquidacionAdd";

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
        $this->cliente->setVisibility();
        $this->rubro->setVisibility();
        $this->calle->setVisibility();
        $this->dnro->setVisibility();
        $this->pisodto->setVisibility();
        $this->codpost->setVisibility();
        $this->codpais->setVisibility();
        $this->codprov->setVisibility();
        $this->codloc->setVisibility();
        $this->codrem->setVisibility();
        $this->fecharem->setVisibility();
        $this->cuit->setVisibility();
        $this->tipoiva->setVisibility();
        $this->totremate->setVisibility();
        $this->totneto1->setVisibility();
        $this->totiva21->setVisibility();
        $this->subtot1->setVisibility();
        $this->totneto2->setVisibility();
        $this->totiva105->setVisibility();
        $this->subtot2->setVisibility();
        $this->totacuenta->setVisibility();
        $this->totgastos->setVisibility();
        $this->totvarios->setVisibility();
        $this->saldoafav->setVisibility();
        $this->fechahora->setVisibility();
        $this->usuario->setVisibility();
        $this->fechaliq->setVisibility();
        $this->estado->setVisibility();
        $this->nrodoc->setVisibility();
        $this->cotiz->setVisibility();
        $this->usuarioultmod->Visible = false;
        $this->fecultmod->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'liquidacion';
        $this->TableName = 'liquidacion';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (liquidacion)
        if (!isset($GLOBALS["liquidacion"]) || $GLOBALS["liquidacion"]::class == PROJECT_NAMESPACE . "liquidacion") {
            $GLOBALS["liquidacion"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'liquidacion');
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
                        $result["view"] = SameString($pageName, "LiquidacionView"); // If View page, no primary button
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
                    $this->terminate("LiquidacionList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "LiquidacionList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "LiquidacionView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "LiquidacionList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "LiquidacionList"; // Return list page content
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
        $this->totremate->DefaultValue = $this->totremate->getDefault(); // PHP
        $this->totremate->OldValue = $this->totremate->DefaultValue;
        $this->totneto1->DefaultValue = $this->totneto1->getDefault(); // PHP
        $this->totneto1->OldValue = $this->totneto1->DefaultValue;
        $this->totiva21->DefaultValue = $this->totiva21->getDefault(); // PHP
        $this->totiva21->OldValue = $this->totiva21->DefaultValue;
        $this->subtot1->DefaultValue = $this->subtot1->getDefault(); // PHP
        $this->subtot1->OldValue = $this->subtot1->DefaultValue;
        $this->totneto2->DefaultValue = $this->totneto2->getDefault(); // PHP
        $this->totneto2->OldValue = $this->totneto2->DefaultValue;
        $this->totiva105->DefaultValue = $this->totiva105->getDefault(); // PHP
        $this->totiva105->OldValue = $this->totiva105->DefaultValue;
        $this->subtot2->DefaultValue = $this->subtot2->getDefault(); // PHP
        $this->subtot2->OldValue = $this->subtot2->DefaultValue;
        $this->totacuenta->DefaultValue = $this->totacuenta->getDefault(); // PHP
        $this->totacuenta->OldValue = $this->totacuenta->DefaultValue;
        $this->totgastos->DefaultValue = $this->totgastos->getDefault(); // PHP
        $this->totgastos->OldValue = $this->totgastos->DefaultValue;
        $this->totvarios->DefaultValue = $this->totvarios->getDefault(); // PHP
        $this->totvarios->OldValue = $this->totvarios->DefaultValue;
        $this->saldoafav->DefaultValue = $this->saldoafav->getDefault(); // PHP
        $this->saldoafav->OldValue = $this->saldoafav->DefaultValue;
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

        // Check field name 'cliente' first before field var 'x_cliente'
        $val = $CurrentForm->hasValue("cliente") ? $CurrentForm->getValue("cliente") : $CurrentForm->getValue("x_cliente");
        if (!$this->cliente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cliente->Visible = false; // Disable update for API request
            } else {
                $this->cliente->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'rubro' first before field var 'x_rubro'
        $val = $CurrentForm->hasValue("rubro") ? $CurrentForm->getValue("rubro") : $CurrentForm->getValue("x_rubro");
        if (!$this->rubro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rubro->Visible = false; // Disable update for API request
            } else {
                $this->rubro->setFormValue($val);
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
                $this->codpais->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'codprov' first before field var 'x_codprov'
        $val = $CurrentForm->hasValue("codprov") ? $CurrentForm->getValue("codprov") : $CurrentForm->getValue("x_codprov");
        if (!$this->codprov->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codprov->Visible = false; // Disable update for API request
            } else {
                $this->codprov->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'codloc' first before field var 'x_codloc'
        $val = $CurrentForm->hasValue("codloc") ? $CurrentForm->getValue("codloc") : $CurrentForm->getValue("x_codloc");
        if (!$this->codloc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codloc->Visible = false; // Disable update for API request
            } else {
                $this->codloc->setFormValue($val, true, $validate);
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

        // Check field name 'fecharem' first before field var 'x_fecharem'
        $val = $CurrentForm->hasValue("fecharem") ? $CurrentForm->getValue("fecharem") : $CurrentForm->getValue("x_fecharem");
        if (!$this->fecharem->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecharem->Visible = false; // Disable update for API request
            } else {
                $this->fecharem->setFormValue($val, true, $validate);
            }
            $this->fecharem->CurrentValue = UnFormatDateTime($this->fecharem->CurrentValue, $this->fecharem->formatPattern());
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

        // Check field name 'tipoiva' first before field var 'x_tipoiva'
        $val = $CurrentForm->hasValue("tipoiva") ? $CurrentForm->getValue("tipoiva") : $CurrentForm->getValue("x_tipoiva");
        if (!$this->tipoiva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipoiva->Visible = false; // Disable update for API request
            } else {
                $this->tipoiva->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totremate' first before field var 'x_totremate'
        $val = $CurrentForm->hasValue("totremate") ? $CurrentForm->getValue("totremate") : $CurrentForm->getValue("x_totremate");
        if (!$this->totremate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totremate->Visible = false; // Disable update for API request
            } else {
                $this->totremate->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totneto1' first before field var 'x_totneto1'
        $val = $CurrentForm->hasValue("totneto1") ? $CurrentForm->getValue("totneto1") : $CurrentForm->getValue("x_totneto1");
        if (!$this->totneto1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totneto1->Visible = false; // Disable update for API request
            } else {
                $this->totneto1->setFormValue($val, true, $validate);
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

        // Check field name 'subtot1' first before field var 'x_subtot1'
        $val = $CurrentForm->hasValue("subtot1") ? $CurrentForm->getValue("subtot1") : $CurrentForm->getValue("x_subtot1");
        if (!$this->subtot1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subtot1->Visible = false; // Disable update for API request
            } else {
                $this->subtot1->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totneto2' first before field var 'x_totneto2'
        $val = $CurrentForm->hasValue("totneto2") ? $CurrentForm->getValue("totneto2") : $CurrentForm->getValue("x_totneto2");
        if (!$this->totneto2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totneto2->Visible = false; // Disable update for API request
            } else {
                $this->totneto2->setFormValue($val, true, $validate);
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

        // Check field name 'subtot2' first before field var 'x_subtot2'
        $val = $CurrentForm->hasValue("subtot2") ? $CurrentForm->getValue("subtot2") : $CurrentForm->getValue("x_subtot2");
        if (!$this->subtot2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subtot2->Visible = false; // Disable update for API request
            } else {
                $this->subtot2->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totacuenta' first before field var 'x_totacuenta'
        $val = $CurrentForm->hasValue("totacuenta") ? $CurrentForm->getValue("totacuenta") : $CurrentForm->getValue("x_totacuenta");
        if (!$this->totacuenta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totacuenta->Visible = false; // Disable update for API request
            } else {
                $this->totacuenta->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totgastos' first before field var 'x_totgastos'
        $val = $CurrentForm->hasValue("totgastos") ? $CurrentForm->getValue("totgastos") : $CurrentForm->getValue("x_totgastos");
        if (!$this->totgastos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totgastos->Visible = false; // Disable update for API request
            } else {
                $this->totgastos->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'totvarios' first before field var 'x_totvarios'
        $val = $CurrentForm->hasValue("totvarios") ? $CurrentForm->getValue("totvarios") : $CurrentForm->getValue("x_totvarios");
        if (!$this->totvarios->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totvarios->Visible = false; // Disable update for API request
            } else {
                $this->totvarios->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'saldoafav' first before field var 'x_saldoafav'
        $val = $CurrentForm->hasValue("saldoafav") ? $CurrentForm->getValue("saldoafav") : $CurrentForm->getValue("x_saldoafav");
        if (!$this->saldoafav->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->saldoafav->Visible = false; // Disable update for API request
            } else {
                $this->saldoafav->setFormValue($val, true, $validate);
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

        // Check field name 'usuario' first before field var 'x_usuario'
        $val = $CurrentForm->hasValue("usuario") ? $CurrentForm->getValue("usuario") : $CurrentForm->getValue("x_usuario");
        if (!$this->usuario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario->Visible = false; // Disable update for API request
            } else {
                $this->usuario->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fechaliq' first before field var 'x_fechaliq'
        $val = $CurrentForm->hasValue("fechaliq") ? $CurrentForm->getValue("fechaliq") : $CurrentForm->getValue("x_fechaliq");
        if (!$this->fechaliq->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechaliq->Visible = false; // Disable update for API request
            } else {
                $this->fechaliq->setFormValue($val, true, $validate);
            }
            $this->fechaliq->CurrentValue = UnFormatDateTime($this->fechaliq->CurrentValue, $this->fechaliq->formatPattern());
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

        // Check field name 'nrodoc' first before field var 'x_nrodoc'
        $val = $CurrentForm->hasValue("nrodoc") ? $CurrentForm->getValue("nrodoc") : $CurrentForm->getValue("x_nrodoc");
        if (!$this->nrodoc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nrodoc->Visible = false; // Disable update for API request
            } else {
                $this->nrodoc->setFormValue($val);
            }
        }

        // Check field name 'cotiz' first before field var 'x_cotiz'
        $val = $CurrentForm->hasValue("cotiz") ? $CurrentForm->getValue("cotiz") : $CurrentForm->getValue("x_cotiz");
        if (!$this->cotiz->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cotiz->Visible = false; // Disable update for API request
            } else {
                $this->cotiz->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fecultmod' first before field var 'x_fecultmod'
        $val = $CurrentForm->hasValue("fecultmod") ? $CurrentForm->getValue("fecultmod") : $CurrentForm->getValue("x_fecultmod");
        if (!$this->fecultmod->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecultmod->Visible = false; // Disable update for API request
            } else {
                $this->fecultmod->setFormValue($val, true, $validate);
            }
            $this->fecultmod->CurrentValue = UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern());
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
        $this->cliente->CurrentValue = $this->cliente->FormValue;
        $this->rubro->CurrentValue = $this->rubro->FormValue;
        $this->calle->CurrentValue = $this->calle->FormValue;
        $this->dnro->CurrentValue = $this->dnro->FormValue;
        $this->pisodto->CurrentValue = $this->pisodto->FormValue;
        $this->codpost->CurrentValue = $this->codpost->FormValue;
        $this->codpais->CurrentValue = $this->codpais->FormValue;
        $this->codprov->CurrentValue = $this->codprov->FormValue;
        $this->codloc->CurrentValue = $this->codloc->FormValue;
        $this->codrem->CurrentValue = $this->codrem->FormValue;
        $this->fecharem->CurrentValue = $this->fecharem->FormValue;
        $this->fecharem->CurrentValue = UnFormatDateTime($this->fecharem->CurrentValue, $this->fecharem->formatPattern());
        $this->cuit->CurrentValue = $this->cuit->FormValue;
        $this->tipoiva->CurrentValue = $this->tipoiva->FormValue;
        $this->totremate->CurrentValue = $this->totremate->FormValue;
        $this->totneto1->CurrentValue = $this->totneto1->FormValue;
        $this->totiva21->CurrentValue = $this->totiva21->FormValue;
        $this->subtot1->CurrentValue = $this->subtot1->FormValue;
        $this->totneto2->CurrentValue = $this->totneto2->FormValue;
        $this->totiva105->CurrentValue = $this->totiva105->FormValue;
        $this->subtot2->CurrentValue = $this->subtot2->FormValue;
        $this->totacuenta->CurrentValue = $this->totacuenta->FormValue;
        $this->totgastos->CurrentValue = $this->totgastos->FormValue;
        $this->totvarios->CurrentValue = $this->totvarios->FormValue;
        $this->saldoafav->CurrentValue = $this->saldoafav->FormValue;
        $this->fechahora->CurrentValue = $this->fechahora->FormValue;
        $this->fechahora->CurrentValue = UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern());
        $this->usuario->CurrentValue = $this->usuario->FormValue;
        $this->fechaliq->CurrentValue = $this->fechaliq->FormValue;
        $this->fechaliq->CurrentValue = UnFormatDateTime($this->fechaliq->CurrentValue, $this->fechaliq->formatPattern());
        $this->estado->CurrentValue = $this->estado->FormValue;
        $this->nrodoc->CurrentValue = $this->nrodoc->FormValue;
        $this->cotiz->CurrentValue = $this->cotiz->FormValue;
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
        $this->cliente->setDbValue($row['cliente']);
        $this->rubro->setDbValue($row['rubro']);
        $this->calle->setDbValue($row['calle']);
        $this->dnro->setDbValue($row['dnro']);
        $this->pisodto->setDbValue($row['pisodto']);
        $this->codpost->setDbValue($row['codpost']);
        $this->codpais->setDbValue($row['codpais']);
        $this->codprov->setDbValue($row['codprov']);
        $this->codloc->setDbValue($row['codloc']);
        $this->codrem->setDbValue($row['codrem']);
        $this->fecharem->setDbValue($row['fecharem']);
        $this->cuit->setDbValue($row['cuit']);
        $this->tipoiva->setDbValue($row['tipoiva']);
        $this->totremate->setDbValue($row['totremate']);
        $this->totneto1->setDbValue($row['totneto1']);
        $this->totiva21->setDbValue($row['totiva21']);
        $this->subtot1->setDbValue($row['subtot1']);
        $this->totneto2->setDbValue($row['totneto2']);
        $this->totiva105->setDbValue($row['totiva105']);
        $this->subtot2->setDbValue($row['subtot2']);
        $this->totacuenta->setDbValue($row['totacuenta']);
        $this->totgastos->setDbValue($row['totgastos']);
        $this->totvarios->setDbValue($row['totvarios']);
        $this->saldoafav->setDbValue($row['saldoafav']);
        $this->fechahora->setDbValue($row['fechahora']);
        $this->usuario->setDbValue($row['usuario']);
        $this->fechaliq->setDbValue($row['fechaliq']);
        $this->estado->setDbValue($row['estado']);
        $this->nrodoc->setDbValue($row['nrodoc']);
        $this->cotiz->setDbValue($row['cotiz']);
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
        $row['cliente'] = $this->cliente->DefaultValue;
        $row['rubro'] = $this->rubro->DefaultValue;
        $row['calle'] = $this->calle->DefaultValue;
        $row['dnro'] = $this->dnro->DefaultValue;
        $row['pisodto'] = $this->pisodto->DefaultValue;
        $row['codpost'] = $this->codpost->DefaultValue;
        $row['codpais'] = $this->codpais->DefaultValue;
        $row['codprov'] = $this->codprov->DefaultValue;
        $row['codloc'] = $this->codloc->DefaultValue;
        $row['codrem'] = $this->codrem->DefaultValue;
        $row['fecharem'] = $this->fecharem->DefaultValue;
        $row['cuit'] = $this->cuit->DefaultValue;
        $row['tipoiva'] = $this->tipoiva->DefaultValue;
        $row['totremate'] = $this->totremate->DefaultValue;
        $row['totneto1'] = $this->totneto1->DefaultValue;
        $row['totiva21'] = $this->totiva21->DefaultValue;
        $row['subtot1'] = $this->subtot1->DefaultValue;
        $row['totneto2'] = $this->totneto2->DefaultValue;
        $row['totiva105'] = $this->totiva105->DefaultValue;
        $row['subtot2'] = $this->subtot2->DefaultValue;
        $row['totacuenta'] = $this->totacuenta->DefaultValue;
        $row['totgastos'] = $this->totgastos->DefaultValue;
        $row['totvarios'] = $this->totvarios->DefaultValue;
        $row['saldoafav'] = $this->saldoafav->DefaultValue;
        $row['fechahora'] = $this->fechahora->DefaultValue;
        $row['usuario'] = $this->usuario->DefaultValue;
        $row['fechaliq'] = $this->fechaliq->DefaultValue;
        $row['estado'] = $this->estado->DefaultValue;
        $row['nrodoc'] = $this->nrodoc->DefaultValue;
        $row['cotiz'] = $this->cotiz->DefaultValue;
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

        // cliente
        $this->cliente->RowCssClass = "row";

        // rubro
        $this->rubro->RowCssClass = "row";

        // calle
        $this->calle->RowCssClass = "row";

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

        // codrem
        $this->codrem->RowCssClass = "row";

        // fecharem
        $this->fecharem->RowCssClass = "row";

        // cuit
        $this->cuit->RowCssClass = "row";

        // tipoiva
        $this->tipoiva->RowCssClass = "row";

        // totremate
        $this->totremate->RowCssClass = "row";

        // totneto1
        $this->totneto1->RowCssClass = "row";

        // totiva21
        $this->totiva21->RowCssClass = "row";

        // subtot1
        $this->subtot1->RowCssClass = "row";

        // totneto2
        $this->totneto2->RowCssClass = "row";

        // totiva105
        $this->totiva105->RowCssClass = "row";

        // subtot2
        $this->subtot2->RowCssClass = "row";

        // totacuenta
        $this->totacuenta->RowCssClass = "row";

        // totgastos
        $this->totgastos->RowCssClass = "row";

        // totvarios
        $this->totvarios->RowCssClass = "row";

        // saldoafav
        $this->saldoafav->RowCssClass = "row";

        // fechahora
        $this->fechahora->RowCssClass = "row";

        // usuario
        $this->usuario->RowCssClass = "row";

        // fechaliq
        $this->fechaliq->RowCssClass = "row";

        // estado
        $this->estado->RowCssClass = "row";

        // nrodoc
        $this->nrodoc->RowCssClass = "row";

        // cotiz
        $this->cotiz->RowCssClass = "row";

        // usuarioultmod
        $this->usuarioultmod->RowCssClass = "row";

        // fecultmod
        $this->fecultmod->RowCssClass = "row";

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

            // cliente
            $this->cliente->ViewValue = $this->cliente->CurrentValue;
            $this->cliente->ViewValue = FormatNumber($this->cliente->ViewValue, $this->cliente->formatPattern());

            // rubro
            $this->rubro->ViewValue = $this->rubro->CurrentValue;

            // calle
            $this->calle->ViewValue = $this->calle->CurrentValue;

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

            // codrem
            $this->codrem->ViewValue = $this->codrem->CurrentValue;
            $this->codrem->ViewValue = FormatNumber($this->codrem->ViewValue, $this->codrem->formatPattern());

            // fecharem
            $this->fecharem->ViewValue = $this->fecharem->CurrentValue;
            $this->fecharem->ViewValue = FormatDateTime($this->fecharem->ViewValue, $this->fecharem->formatPattern());

            // cuit
            $this->cuit->ViewValue = $this->cuit->CurrentValue;

            // tipoiva
            $this->tipoiva->ViewValue = $this->tipoiva->CurrentValue;
            $this->tipoiva->ViewValue = FormatNumber($this->tipoiva->ViewValue, $this->tipoiva->formatPattern());

            // totremate
            $this->totremate->ViewValue = $this->totremate->CurrentValue;
            $this->totremate->ViewValue = FormatNumber($this->totremate->ViewValue, $this->totremate->formatPattern());

            // totneto1
            $this->totneto1->ViewValue = $this->totneto1->CurrentValue;
            $this->totneto1->ViewValue = FormatNumber($this->totneto1->ViewValue, $this->totneto1->formatPattern());

            // totiva21
            $this->totiva21->ViewValue = $this->totiva21->CurrentValue;
            $this->totiva21->ViewValue = FormatNumber($this->totiva21->ViewValue, $this->totiva21->formatPattern());

            // subtot1
            $this->subtot1->ViewValue = $this->subtot1->CurrentValue;
            $this->subtot1->ViewValue = FormatNumber($this->subtot1->ViewValue, $this->subtot1->formatPattern());

            // totneto2
            $this->totneto2->ViewValue = $this->totneto2->CurrentValue;
            $this->totneto2->ViewValue = FormatNumber($this->totneto2->ViewValue, $this->totneto2->formatPattern());

            // totiva105
            $this->totiva105->ViewValue = $this->totiva105->CurrentValue;
            $this->totiva105->ViewValue = FormatNumber($this->totiva105->ViewValue, $this->totiva105->formatPattern());

            // subtot2
            $this->subtot2->ViewValue = $this->subtot2->CurrentValue;
            $this->subtot2->ViewValue = FormatNumber($this->subtot2->ViewValue, $this->subtot2->formatPattern());

            // totacuenta
            $this->totacuenta->ViewValue = $this->totacuenta->CurrentValue;
            $this->totacuenta->ViewValue = FormatNumber($this->totacuenta->ViewValue, $this->totacuenta->formatPattern());

            // totgastos
            $this->totgastos->ViewValue = $this->totgastos->CurrentValue;
            $this->totgastos->ViewValue = FormatNumber($this->totgastos->ViewValue, $this->totgastos->formatPattern());

            // totvarios
            $this->totvarios->ViewValue = $this->totvarios->CurrentValue;
            $this->totvarios->ViewValue = FormatNumber($this->totvarios->ViewValue, $this->totvarios->formatPattern());

            // saldoafav
            $this->saldoafav->ViewValue = $this->saldoafav->CurrentValue;
            $this->saldoafav->ViewValue = FormatNumber($this->saldoafav->ViewValue, $this->saldoafav->formatPattern());

            // fechahora
            $this->fechahora->ViewValue = $this->fechahora->CurrentValue;
            $this->fechahora->ViewValue = FormatDateTime($this->fechahora->ViewValue, $this->fechahora->formatPattern());

            // usuario
            $this->usuario->ViewValue = $this->usuario->CurrentValue;
            $this->usuario->ViewValue = FormatNumber($this->usuario->ViewValue, $this->usuario->formatPattern());

            // fechaliq
            $this->fechaliq->ViewValue = $this->fechaliq->CurrentValue;
            $this->fechaliq->ViewValue = FormatDateTime($this->fechaliq->ViewValue, $this->fechaliq->formatPattern());

            // estado
            $this->estado->ViewValue = $this->estado->CurrentValue;

            // nrodoc
            $this->nrodoc->ViewValue = $this->nrodoc->CurrentValue;

            // cotiz
            $this->cotiz->ViewValue = $this->cotiz->CurrentValue;
            $this->cotiz->ViewValue = FormatNumber($this->cotiz->ViewValue, $this->cotiz->formatPattern());

            // usuarioultmod
            $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
            $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

            // fecultmod
            $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
            $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // rubro
            $this->rubro->HrefValue = "";

            // calle
            $this->calle->HrefValue = "";

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

            // codrem
            $this->codrem->HrefValue = "";

            // fecharem
            $this->fecharem->HrefValue = "";

            // cuit
            $this->cuit->HrefValue = "";

            // tipoiva
            $this->tipoiva->HrefValue = "";

            // totremate
            $this->totremate->HrefValue = "";

            // totneto1
            $this->totneto1->HrefValue = "";

            // totiva21
            $this->totiva21->HrefValue = "";

            // subtot1
            $this->subtot1->HrefValue = "";

            // totneto2
            $this->totneto2->HrefValue = "";

            // totiva105
            $this->totiva105->HrefValue = "";

            // subtot2
            $this->subtot2->HrefValue = "";

            // totacuenta
            $this->totacuenta->HrefValue = "";

            // totgastos
            $this->totgastos->HrefValue = "";

            // totvarios
            $this->totvarios->HrefValue = "";

            // saldoafav
            $this->saldoafav->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fechaliq
            $this->fechaliq->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // nrodoc
            $this->nrodoc->HrefValue = "";

            // cotiz
            $this->cotiz->HrefValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // tcomp
            $this->tcomp->setupEditAttributes();
            $this->tcomp->EditValue = $this->tcomp->CurrentValue;
            $this->tcomp->PlaceHolder = RemoveHtml($this->tcomp->caption());
            if (strval($this->tcomp->EditValue) != "" && is_numeric($this->tcomp->EditValue)) {
                $this->tcomp->EditValue = FormatNumber($this->tcomp->EditValue, null);
            }

            // serie
            $this->serie->setupEditAttributes();
            $this->serie->EditValue = $this->serie->CurrentValue;
            $this->serie->PlaceHolder = RemoveHtml($this->serie->caption());
            if (strval($this->serie->EditValue) != "" && is_numeric($this->serie->EditValue)) {
                $this->serie->EditValue = FormatNumber($this->serie->EditValue, null);
            }

            // ncomp
            $this->ncomp->setupEditAttributes();
            $this->ncomp->EditValue = $this->ncomp->CurrentValue;
            $this->ncomp->PlaceHolder = RemoveHtml($this->ncomp->caption());
            if (strval($this->ncomp->EditValue) != "" && is_numeric($this->ncomp->EditValue)) {
                $this->ncomp->EditValue = FormatNumber($this->ncomp->EditValue, null);
            }

            // cliente
            $this->cliente->setupEditAttributes();
            $this->cliente->EditValue = $this->cliente->CurrentValue;
            $this->cliente->PlaceHolder = RemoveHtml($this->cliente->caption());
            if (strval($this->cliente->EditValue) != "" && is_numeric($this->cliente->EditValue)) {
                $this->cliente->EditValue = FormatNumber($this->cliente->EditValue, null);
            }

            // rubro
            $this->rubro->setupEditAttributes();
            if (!$this->rubro->Raw) {
                $this->rubro->CurrentValue = HtmlDecode($this->rubro->CurrentValue);
            }
            $this->rubro->EditValue = HtmlEncode($this->rubro->CurrentValue);
            $this->rubro->PlaceHolder = RemoveHtml($this->rubro->caption());

            // calle
            $this->calle->setupEditAttributes();
            if (!$this->calle->Raw) {
                $this->calle->CurrentValue = HtmlDecode($this->calle->CurrentValue);
            }
            $this->calle->EditValue = HtmlEncode($this->calle->CurrentValue);
            $this->calle->PlaceHolder = RemoveHtml($this->calle->caption());

            // dnro
            $this->dnro->setupEditAttributes();
            if (!$this->dnro->Raw) {
                $this->dnro->CurrentValue = HtmlDecode($this->dnro->CurrentValue);
            }
            $this->dnro->EditValue = HtmlEncode($this->dnro->CurrentValue);
            $this->dnro->PlaceHolder = RemoveHtml($this->dnro->caption());

            // pisodto
            $this->pisodto->setupEditAttributes();
            if (!$this->pisodto->Raw) {
                $this->pisodto->CurrentValue = HtmlDecode($this->pisodto->CurrentValue);
            }
            $this->pisodto->EditValue = HtmlEncode($this->pisodto->CurrentValue);
            $this->pisodto->PlaceHolder = RemoveHtml($this->pisodto->caption());

            // codpost
            $this->codpost->setupEditAttributes();
            if (!$this->codpost->Raw) {
                $this->codpost->CurrentValue = HtmlDecode($this->codpost->CurrentValue);
            }
            $this->codpost->EditValue = HtmlEncode($this->codpost->CurrentValue);
            $this->codpost->PlaceHolder = RemoveHtml($this->codpost->caption());

            // codpais
            $this->codpais->setupEditAttributes();
            $this->codpais->EditValue = $this->codpais->CurrentValue;
            $this->codpais->PlaceHolder = RemoveHtml($this->codpais->caption());
            if (strval($this->codpais->EditValue) != "" && is_numeric($this->codpais->EditValue)) {
                $this->codpais->EditValue = FormatNumber($this->codpais->EditValue, null);
            }

            // codprov
            $this->codprov->setupEditAttributes();
            $this->codprov->EditValue = $this->codprov->CurrentValue;
            $this->codprov->PlaceHolder = RemoveHtml($this->codprov->caption());
            if (strval($this->codprov->EditValue) != "" && is_numeric($this->codprov->EditValue)) {
                $this->codprov->EditValue = FormatNumber($this->codprov->EditValue, null);
            }

            // codloc
            $this->codloc->setupEditAttributes();
            $this->codloc->EditValue = $this->codloc->CurrentValue;
            $this->codloc->PlaceHolder = RemoveHtml($this->codloc->caption());
            if (strval($this->codloc->EditValue) != "" && is_numeric($this->codloc->EditValue)) {
                $this->codloc->EditValue = FormatNumber($this->codloc->EditValue, null);
            }

            // codrem
            $this->codrem->setupEditAttributes();
            $this->codrem->EditValue = $this->codrem->CurrentValue;
            $this->codrem->PlaceHolder = RemoveHtml($this->codrem->caption());
            if (strval($this->codrem->EditValue) != "" && is_numeric($this->codrem->EditValue)) {
                $this->codrem->EditValue = FormatNumber($this->codrem->EditValue, null);
            }

            // fecharem
            $this->fecharem->setupEditAttributes();
            $this->fecharem->EditValue = HtmlEncode(FormatDateTime($this->fecharem->CurrentValue, $this->fecharem->formatPattern()));
            $this->fecharem->PlaceHolder = RemoveHtml($this->fecharem->caption());

            // cuit
            $this->cuit->setupEditAttributes();
            if (!$this->cuit->Raw) {
                $this->cuit->CurrentValue = HtmlDecode($this->cuit->CurrentValue);
            }
            $this->cuit->EditValue = HtmlEncode($this->cuit->CurrentValue);
            $this->cuit->PlaceHolder = RemoveHtml($this->cuit->caption());

            // tipoiva
            $this->tipoiva->setupEditAttributes();
            $this->tipoiva->EditValue = $this->tipoiva->CurrentValue;
            $this->tipoiva->PlaceHolder = RemoveHtml($this->tipoiva->caption());
            if (strval($this->tipoiva->EditValue) != "" && is_numeric($this->tipoiva->EditValue)) {
                $this->tipoiva->EditValue = FormatNumber($this->tipoiva->EditValue, null);
            }

            // totremate
            $this->totremate->setupEditAttributes();
            $this->totremate->EditValue = $this->totremate->CurrentValue;
            $this->totremate->PlaceHolder = RemoveHtml($this->totremate->caption());
            if (strval($this->totremate->EditValue) != "" && is_numeric($this->totremate->EditValue)) {
                $this->totremate->EditValue = FormatNumber($this->totremate->EditValue, null);
            }

            // totneto1
            $this->totneto1->setupEditAttributes();
            $this->totneto1->EditValue = $this->totneto1->CurrentValue;
            $this->totneto1->PlaceHolder = RemoveHtml($this->totneto1->caption());
            if (strval($this->totneto1->EditValue) != "" && is_numeric($this->totneto1->EditValue)) {
                $this->totneto1->EditValue = FormatNumber($this->totneto1->EditValue, null);
            }

            // totiva21
            $this->totiva21->setupEditAttributes();
            $this->totiva21->EditValue = $this->totiva21->CurrentValue;
            $this->totiva21->PlaceHolder = RemoveHtml($this->totiva21->caption());
            if (strval($this->totiva21->EditValue) != "" && is_numeric($this->totiva21->EditValue)) {
                $this->totiva21->EditValue = FormatNumber($this->totiva21->EditValue, null);
            }

            // subtot1
            $this->subtot1->setupEditAttributes();
            $this->subtot1->EditValue = $this->subtot1->CurrentValue;
            $this->subtot1->PlaceHolder = RemoveHtml($this->subtot1->caption());
            if (strval($this->subtot1->EditValue) != "" && is_numeric($this->subtot1->EditValue)) {
                $this->subtot1->EditValue = FormatNumber($this->subtot1->EditValue, null);
            }

            // totneto2
            $this->totneto2->setupEditAttributes();
            $this->totneto2->EditValue = $this->totneto2->CurrentValue;
            $this->totneto2->PlaceHolder = RemoveHtml($this->totneto2->caption());
            if (strval($this->totneto2->EditValue) != "" && is_numeric($this->totneto2->EditValue)) {
                $this->totneto2->EditValue = FormatNumber($this->totneto2->EditValue, null);
            }

            // totiva105
            $this->totiva105->setupEditAttributes();
            $this->totiva105->EditValue = $this->totiva105->CurrentValue;
            $this->totiva105->PlaceHolder = RemoveHtml($this->totiva105->caption());
            if (strval($this->totiva105->EditValue) != "" && is_numeric($this->totiva105->EditValue)) {
                $this->totiva105->EditValue = FormatNumber($this->totiva105->EditValue, null);
            }

            // subtot2
            $this->subtot2->setupEditAttributes();
            $this->subtot2->EditValue = $this->subtot2->CurrentValue;
            $this->subtot2->PlaceHolder = RemoveHtml($this->subtot2->caption());
            if (strval($this->subtot2->EditValue) != "" && is_numeric($this->subtot2->EditValue)) {
                $this->subtot2->EditValue = FormatNumber($this->subtot2->EditValue, null);
            }

            // totacuenta
            $this->totacuenta->setupEditAttributes();
            $this->totacuenta->EditValue = $this->totacuenta->CurrentValue;
            $this->totacuenta->PlaceHolder = RemoveHtml($this->totacuenta->caption());
            if (strval($this->totacuenta->EditValue) != "" && is_numeric($this->totacuenta->EditValue)) {
                $this->totacuenta->EditValue = FormatNumber($this->totacuenta->EditValue, null);
            }

            // totgastos
            $this->totgastos->setupEditAttributes();
            $this->totgastos->EditValue = $this->totgastos->CurrentValue;
            $this->totgastos->PlaceHolder = RemoveHtml($this->totgastos->caption());
            if (strval($this->totgastos->EditValue) != "" && is_numeric($this->totgastos->EditValue)) {
                $this->totgastos->EditValue = FormatNumber($this->totgastos->EditValue, null);
            }

            // totvarios
            $this->totvarios->setupEditAttributes();
            $this->totvarios->EditValue = $this->totvarios->CurrentValue;
            $this->totvarios->PlaceHolder = RemoveHtml($this->totvarios->caption());
            if (strval($this->totvarios->EditValue) != "" && is_numeric($this->totvarios->EditValue)) {
                $this->totvarios->EditValue = FormatNumber($this->totvarios->EditValue, null);
            }

            // saldoafav
            $this->saldoafav->setupEditAttributes();
            $this->saldoafav->EditValue = $this->saldoafav->CurrentValue;
            $this->saldoafav->PlaceHolder = RemoveHtml($this->saldoafav->caption());
            if (strval($this->saldoafav->EditValue) != "" && is_numeric($this->saldoafav->EditValue)) {
                $this->saldoafav->EditValue = FormatNumber($this->saldoafav->EditValue, null);
            }

            // fechahora
            $this->fechahora->setupEditAttributes();
            $this->fechahora->EditValue = HtmlEncode(FormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()));
            $this->fechahora->PlaceHolder = RemoveHtml($this->fechahora->caption());

            // usuario
            $this->usuario->setupEditAttributes();
            $this->usuario->EditValue = $this->usuario->CurrentValue;
            $this->usuario->PlaceHolder = RemoveHtml($this->usuario->caption());
            if (strval($this->usuario->EditValue) != "" && is_numeric($this->usuario->EditValue)) {
                $this->usuario->EditValue = FormatNumber($this->usuario->EditValue, null);
            }

            // fechaliq
            $this->fechaliq->setupEditAttributes();
            $this->fechaliq->EditValue = HtmlEncode(FormatDateTime($this->fechaliq->CurrentValue, $this->fechaliq->formatPattern()));
            $this->fechaliq->PlaceHolder = RemoveHtml($this->fechaliq->caption());

            // estado
            $this->estado->setupEditAttributes();
            if (!$this->estado->Raw) {
                $this->estado->CurrentValue = HtmlDecode($this->estado->CurrentValue);
            }
            $this->estado->EditValue = HtmlEncode($this->estado->CurrentValue);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // nrodoc
            $this->nrodoc->setupEditAttributes();
            if (!$this->nrodoc->Raw) {
                $this->nrodoc->CurrentValue = HtmlDecode($this->nrodoc->CurrentValue);
            }
            $this->nrodoc->EditValue = HtmlEncode($this->nrodoc->CurrentValue);
            $this->nrodoc->PlaceHolder = RemoveHtml($this->nrodoc->caption());

            // cotiz
            $this->cotiz->setupEditAttributes();
            $this->cotiz->EditValue = $this->cotiz->CurrentValue;
            $this->cotiz->PlaceHolder = RemoveHtml($this->cotiz->caption());
            if (strval($this->cotiz->EditValue) != "" && is_numeric($this->cotiz->EditValue)) {
                $this->cotiz->EditValue = FormatNumber($this->cotiz->EditValue, null);
            }

            // fecultmod
            $this->fecultmod->setupEditAttributes();
            $this->fecultmod->EditValue = HtmlEncode(FormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern()));
            $this->fecultmod->PlaceHolder = RemoveHtml($this->fecultmod->caption());

            // Add refer script

            // tcomp
            $this->tcomp->HrefValue = "";

            // serie
            $this->serie->HrefValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";

            // cliente
            $this->cliente->HrefValue = "";

            // rubro
            $this->rubro->HrefValue = "";

            // calle
            $this->calle->HrefValue = "";

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

            // codrem
            $this->codrem->HrefValue = "";

            // fecharem
            $this->fecharem->HrefValue = "";

            // cuit
            $this->cuit->HrefValue = "";

            // tipoiva
            $this->tipoiva->HrefValue = "";

            // totremate
            $this->totremate->HrefValue = "";

            // totneto1
            $this->totneto1->HrefValue = "";

            // totiva21
            $this->totiva21->HrefValue = "";

            // subtot1
            $this->subtot1->HrefValue = "";

            // totneto2
            $this->totneto2->HrefValue = "";

            // totiva105
            $this->totiva105->HrefValue = "";

            // subtot2
            $this->subtot2->HrefValue = "";

            // totacuenta
            $this->totacuenta->HrefValue = "";

            // totgastos
            $this->totgastos->HrefValue = "";

            // totvarios
            $this->totvarios->HrefValue = "";

            // saldoafav
            $this->saldoafav->HrefValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fechaliq
            $this->fechaliq->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // nrodoc
            $this->nrodoc->HrefValue = "";

            // cotiz
            $this->cotiz->HrefValue = "";

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
            if ($this->cliente->Visible && $this->cliente->Required) {
                if (!$this->cliente->IsDetailKey && EmptyValue($this->cliente->FormValue)) {
                    $this->cliente->addErrorMessage(str_replace("%s", $this->cliente->caption(), $this->cliente->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->cliente->FormValue)) {
                $this->cliente->addErrorMessage($this->cliente->getErrorMessage(false));
            }
            if ($this->rubro->Visible && $this->rubro->Required) {
                if (!$this->rubro->IsDetailKey && EmptyValue($this->rubro->FormValue)) {
                    $this->rubro->addErrorMessage(str_replace("%s", $this->rubro->caption(), $this->rubro->RequiredErrorMessage));
                }
            }
            if ($this->calle->Visible && $this->calle->Required) {
                if (!$this->calle->IsDetailKey && EmptyValue($this->calle->FormValue)) {
                    $this->calle->addErrorMessage(str_replace("%s", $this->calle->caption(), $this->calle->RequiredErrorMessage));
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
            if (!CheckInteger($this->codpais->FormValue)) {
                $this->codpais->addErrorMessage($this->codpais->getErrorMessage(false));
            }
            if ($this->codprov->Visible && $this->codprov->Required) {
                if (!$this->codprov->IsDetailKey && EmptyValue($this->codprov->FormValue)) {
                    $this->codprov->addErrorMessage(str_replace("%s", $this->codprov->caption(), $this->codprov->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->codprov->FormValue)) {
                $this->codprov->addErrorMessage($this->codprov->getErrorMessage(false));
            }
            if ($this->codloc->Visible && $this->codloc->Required) {
                if (!$this->codloc->IsDetailKey && EmptyValue($this->codloc->FormValue)) {
                    $this->codloc->addErrorMessage(str_replace("%s", $this->codloc->caption(), $this->codloc->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->codloc->FormValue)) {
                $this->codloc->addErrorMessage($this->codloc->getErrorMessage(false));
            }
            if ($this->codrem->Visible && $this->codrem->Required) {
                if (!$this->codrem->IsDetailKey && EmptyValue($this->codrem->FormValue)) {
                    $this->codrem->addErrorMessage(str_replace("%s", $this->codrem->caption(), $this->codrem->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->codrem->FormValue)) {
                $this->codrem->addErrorMessage($this->codrem->getErrorMessage(false));
            }
            if ($this->fecharem->Visible && $this->fecharem->Required) {
                if (!$this->fecharem->IsDetailKey && EmptyValue($this->fecharem->FormValue)) {
                    $this->fecharem->addErrorMessage(str_replace("%s", $this->fecharem->caption(), $this->fecharem->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecharem->FormValue, $this->fecharem->formatPattern())) {
                $this->fecharem->addErrorMessage($this->fecharem->getErrorMessage(false));
            }
            if ($this->cuit->Visible && $this->cuit->Required) {
                if (!$this->cuit->IsDetailKey && EmptyValue($this->cuit->FormValue)) {
                    $this->cuit->addErrorMessage(str_replace("%s", $this->cuit->caption(), $this->cuit->RequiredErrorMessage));
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
            if ($this->totremate->Visible && $this->totremate->Required) {
                if (!$this->totremate->IsDetailKey && EmptyValue($this->totremate->FormValue)) {
                    $this->totremate->addErrorMessage(str_replace("%s", $this->totremate->caption(), $this->totremate->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totremate->FormValue)) {
                $this->totremate->addErrorMessage($this->totremate->getErrorMessage(false));
            }
            if ($this->totneto1->Visible && $this->totneto1->Required) {
                if (!$this->totneto1->IsDetailKey && EmptyValue($this->totneto1->FormValue)) {
                    $this->totneto1->addErrorMessage(str_replace("%s", $this->totneto1->caption(), $this->totneto1->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totneto1->FormValue)) {
                $this->totneto1->addErrorMessage($this->totneto1->getErrorMessage(false));
            }
            if ($this->totiva21->Visible && $this->totiva21->Required) {
                if (!$this->totiva21->IsDetailKey && EmptyValue($this->totiva21->FormValue)) {
                    $this->totiva21->addErrorMessage(str_replace("%s", $this->totiva21->caption(), $this->totiva21->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totiva21->FormValue)) {
                $this->totiva21->addErrorMessage($this->totiva21->getErrorMessage(false));
            }
            if ($this->subtot1->Visible && $this->subtot1->Required) {
                if (!$this->subtot1->IsDetailKey && EmptyValue($this->subtot1->FormValue)) {
                    $this->subtot1->addErrorMessage(str_replace("%s", $this->subtot1->caption(), $this->subtot1->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->subtot1->FormValue)) {
                $this->subtot1->addErrorMessage($this->subtot1->getErrorMessage(false));
            }
            if ($this->totneto2->Visible && $this->totneto2->Required) {
                if (!$this->totneto2->IsDetailKey && EmptyValue($this->totneto2->FormValue)) {
                    $this->totneto2->addErrorMessage(str_replace("%s", $this->totneto2->caption(), $this->totneto2->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totneto2->FormValue)) {
                $this->totneto2->addErrorMessage($this->totneto2->getErrorMessage(false));
            }
            if ($this->totiva105->Visible && $this->totiva105->Required) {
                if (!$this->totiva105->IsDetailKey && EmptyValue($this->totiva105->FormValue)) {
                    $this->totiva105->addErrorMessage(str_replace("%s", $this->totiva105->caption(), $this->totiva105->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totiva105->FormValue)) {
                $this->totiva105->addErrorMessage($this->totiva105->getErrorMessage(false));
            }
            if ($this->subtot2->Visible && $this->subtot2->Required) {
                if (!$this->subtot2->IsDetailKey && EmptyValue($this->subtot2->FormValue)) {
                    $this->subtot2->addErrorMessage(str_replace("%s", $this->subtot2->caption(), $this->subtot2->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->subtot2->FormValue)) {
                $this->subtot2->addErrorMessage($this->subtot2->getErrorMessage(false));
            }
            if ($this->totacuenta->Visible && $this->totacuenta->Required) {
                if (!$this->totacuenta->IsDetailKey && EmptyValue($this->totacuenta->FormValue)) {
                    $this->totacuenta->addErrorMessage(str_replace("%s", $this->totacuenta->caption(), $this->totacuenta->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totacuenta->FormValue)) {
                $this->totacuenta->addErrorMessage($this->totacuenta->getErrorMessage(false));
            }
            if ($this->totgastos->Visible && $this->totgastos->Required) {
                if (!$this->totgastos->IsDetailKey && EmptyValue($this->totgastos->FormValue)) {
                    $this->totgastos->addErrorMessage(str_replace("%s", $this->totgastos->caption(), $this->totgastos->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totgastos->FormValue)) {
                $this->totgastos->addErrorMessage($this->totgastos->getErrorMessage(false));
            }
            if ($this->totvarios->Visible && $this->totvarios->Required) {
                if (!$this->totvarios->IsDetailKey && EmptyValue($this->totvarios->FormValue)) {
                    $this->totvarios->addErrorMessage(str_replace("%s", $this->totvarios->caption(), $this->totvarios->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->totvarios->FormValue)) {
                $this->totvarios->addErrorMessage($this->totvarios->getErrorMessage(false));
            }
            if ($this->saldoafav->Visible && $this->saldoafav->Required) {
                if (!$this->saldoafav->IsDetailKey && EmptyValue($this->saldoafav->FormValue)) {
                    $this->saldoafav->addErrorMessage(str_replace("%s", $this->saldoafav->caption(), $this->saldoafav->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->saldoafav->FormValue)) {
                $this->saldoafav->addErrorMessage($this->saldoafav->getErrorMessage(false));
            }
            if ($this->fechahora->Visible && $this->fechahora->Required) {
                if (!$this->fechahora->IsDetailKey && EmptyValue($this->fechahora->FormValue)) {
                    $this->fechahora->addErrorMessage(str_replace("%s", $this->fechahora->caption(), $this->fechahora->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fechahora->FormValue, $this->fechahora->formatPattern())) {
                $this->fechahora->addErrorMessage($this->fechahora->getErrorMessage(false));
            }
            if ($this->usuario->Visible && $this->usuario->Required) {
                if (!$this->usuario->IsDetailKey && EmptyValue($this->usuario->FormValue)) {
                    $this->usuario->addErrorMessage(str_replace("%s", $this->usuario->caption(), $this->usuario->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->usuario->FormValue)) {
                $this->usuario->addErrorMessage($this->usuario->getErrorMessage(false));
            }
            if ($this->fechaliq->Visible && $this->fechaliq->Required) {
                if (!$this->fechaliq->IsDetailKey && EmptyValue($this->fechaliq->FormValue)) {
                    $this->fechaliq->addErrorMessage(str_replace("%s", $this->fechaliq->caption(), $this->fechaliq->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fechaliq->FormValue, $this->fechaliq->formatPattern())) {
                $this->fechaliq->addErrorMessage($this->fechaliq->getErrorMessage(false));
            }
            if ($this->estado->Visible && $this->estado->Required) {
                if (!$this->estado->IsDetailKey && EmptyValue($this->estado->FormValue)) {
                    $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
                }
            }
            if ($this->nrodoc->Visible && $this->nrodoc->Required) {
                if (!$this->nrodoc->IsDetailKey && EmptyValue($this->nrodoc->FormValue)) {
                    $this->nrodoc->addErrorMessage(str_replace("%s", $this->nrodoc->caption(), $this->nrodoc->RequiredErrorMessage));
                }
            }
            if ($this->cotiz->Visible && $this->cotiz->Required) {
                if (!$this->cotiz->IsDetailKey && EmptyValue($this->cotiz->FormValue)) {
                    $this->cotiz->addErrorMessage(str_replace("%s", $this->cotiz->caption(), $this->cotiz->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->cotiz->FormValue)) {
                $this->cotiz->addErrorMessage($this->cotiz->getErrorMessage(false));
            }
            if ($this->fecultmod->Visible && $this->fecultmod->Required) {
                if (!$this->fecultmod->IsDetailKey && EmptyValue($this->fecultmod->FormValue)) {
                    $this->fecultmod->addErrorMessage(str_replace("%s", $this->fecultmod->caption(), $this->fecultmod->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecultmod->FormValue, $this->fecultmod->formatPattern())) {
                $this->fecultmod->addErrorMessage($this->fecultmod->getErrorMessage(false));
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

        // tcomp
        $this->tcomp->setDbValueDef($rsnew, $this->tcomp->CurrentValue, false);

        // serie
        $this->serie->setDbValueDef($rsnew, $this->serie->CurrentValue, false);

        // ncomp
        $this->ncomp->setDbValueDef($rsnew, $this->ncomp->CurrentValue, false);

        // cliente
        $this->cliente->setDbValueDef($rsnew, $this->cliente->CurrentValue, false);

        // rubro
        $this->rubro->setDbValueDef($rsnew, $this->rubro->CurrentValue, false);

        // calle
        $this->calle->setDbValueDef($rsnew, $this->calle->CurrentValue, false);

        // dnro
        $this->dnro->setDbValueDef($rsnew, $this->dnro->CurrentValue, false);

        // pisodto
        $this->pisodto->setDbValueDef($rsnew, $this->pisodto->CurrentValue, false);

        // codpost
        $this->codpost->setDbValueDef($rsnew, $this->codpost->CurrentValue, false);

        // codpais
        $this->codpais->setDbValueDef($rsnew, $this->codpais->CurrentValue, false);

        // codprov
        $this->codprov->setDbValueDef($rsnew, $this->codprov->CurrentValue, false);

        // codloc
        $this->codloc->setDbValueDef($rsnew, $this->codloc->CurrentValue, false);

        // codrem
        $this->codrem->setDbValueDef($rsnew, $this->codrem->CurrentValue, false);

        // fecharem
        $this->fecharem->setDbValueDef($rsnew, UnFormatDateTime($this->fecharem->CurrentValue, $this->fecharem->formatPattern()), false);

        // cuit
        $this->cuit->setDbValueDef($rsnew, $this->cuit->CurrentValue, false);

        // tipoiva
        $this->tipoiva->setDbValueDef($rsnew, $this->tipoiva->CurrentValue, false);

        // totremate
        $this->totremate->setDbValueDef($rsnew, $this->totremate->CurrentValue, strval($this->totremate->CurrentValue) == "");

        // totneto1
        $this->totneto1->setDbValueDef($rsnew, $this->totneto1->CurrentValue, strval($this->totneto1->CurrentValue) == "");

        // totiva21
        $this->totiva21->setDbValueDef($rsnew, $this->totiva21->CurrentValue, strval($this->totiva21->CurrentValue) == "");

        // subtot1
        $this->subtot1->setDbValueDef($rsnew, $this->subtot1->CurrentValue, strval($this->subtot1->CurrentValue) == "");

        // totneto2
        $this->totneto2->setDbValueDef($rsnew, $this->totneto2->CurrentValue, strval($this->totneto2->CurrentValue) == "");

        // totiva105
        $this->totiva105->setDbValueDef($rsnew, $this->totiva105->CurrentValue, strval($this->totiva105->CurrentValue) == "");

        // subtot2
        $this->subtot2->setDbValueDef($rsnew, $this->subtot2->CurrentValue, strval($this->subtot2->CurrentValue) == "");

        // totacuenta
        $this->totacuenta->setDbValueDef($rsnew, $this->totacuenta->CurrentValue, strval($this->totacuenta->CurrentValue) == "");

        // totgastos
        $this->totgastos->setDbValueDef($rsnew, $this->totgastos->CurrentValue, strval($this->totgastos->CurrentValue) == "");

        // totvarios
        $this->totvarios->setDbValueDef($rsnew, $this->totvarios->CurrentValue, strval($this->totvarios->CurrentValue) == "");

        // saldoafav
        $this->saldoafav->setDbValueDef($rsnew, $this->saldoafav->CurrentValue, strval($this->saldoafav->CurrentValue) == "");

        // fechahora
        $this->fechahora->setDbValueDef($rsnew, UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()), false);

        // usuario
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue, false);

        // fechaliq
        $this->fechaliq->setDbValueDef($rsnew, UnFormatDateTime($this->fechaliq->CurrentValue, $this->fechaliq->formatPattern()), false);

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, false);

        // nrodoc
        $this->nrodoc->setDbValueDef($rsnew, $this->nrodoc->CurrentValue, false);

        // cotiz
        $this->cotiz->setDbValueDef($rsnew, $this->cotiz->CurrentValue, false);

        // fecultmod
        $this->fecultmod->setDbValueDef($rsnew, UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern()), false);
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
        if (isset($row['cliente'])) { // cliente
            $this->cliente->setFormValue($row['cliente']);
        }
        if (isset($row['rubro'])) { // rubro
            $this->rubro->setFormValue($row['rubro']);
        }
        if (isset($row['calle'])) { // calle
            $this->calle->setFormValue($row['calle']);
        }
        if (isset($row['dnro'])) { // dnro
            $this->dnro->setFormValue($row['dnro']);
        }
        if (isset($row['pisodto'])) { // pisodto
            $this->pisodto->setFormValue($row['pisodto']);
        }
        if (isset($row['codpost'])) { // codpost
            $this->codpost->setFormValue($row['codpost']);
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
        if (isset($row['codrem'])) { // codrem
            $this->codrem->setFormValue($row['codrem']);
        }
        if (isset($row['fecharem'])) { // fecharem
            $this->fecharem->setFormValue($row['fecharem']);
        }
        if (isset($row['cuit'])) { // cuit
            $this->cuit->setFormValue($row['cuit']);
        }
        if (isset($row['tipoiva'])) { // tipoiva
            $this->tipoiva->setFormValue($row['tipoiva']);
        }
        if (isset($row['totremate'])) { // totremate
            $this->totremate->setFormValue($row['totremate']);
        }
        if (isset($row['totneto1'])) { // totneto1
            $this->totneto1->setFormValue($row['totneto1']);
        }
        if (isset($row['totiva21'])) { // totiva21
            $this->totiva21->setFormValue($row['totiva21']);
        }
        if (isset($row['subtot1'])) { // subtot1
            $this->subtot1->setFormValue($row['subtot1']);
        }
        if (isset($row['totneto2'])) { // totneto2
            $this->totneto2->setFormValue($row['totneto2']);
        }
        if (isset($row['totiva105'])) { // totiva105
            $this->totiva105->setFormValue($row['totiva105']);
        }
        if (isset($row['subtot2'])) { // subtot2
            $this->subtot2->setFormValue($row['subtot2']);
        }
        if (isset($row['totacuenta'])) { // totacuenta
            $this->totacuenta->setFormValue($row['totacuenta']);
        }
        if (isset($row['totgastos'])) { // totgastos
            $this->totgastos->setFormValue($row['totgastos']);
        }
        if (isset($row['totvarios'])) { // totvarios
            $this->totvarios->setFormValue($row['totvarios']);
        }
        if (isset($row['saldoafav'])) { // saldoafav
            $this->saldoafav->setFormValue($row['saldoafav']);
        }
        if (isset($row['fechahora'])) { // fechahora
            $this->fechahora->setFormValue($row['fechahora']);
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->setFormValue($row['usuario']);
        }
        if (isset($row['fechaliq'])) { // fechaliq
            $this->fechaliq->setFormValue($row['fechaliq']);
        }
        if (isset($row['estado'])) { // estado
            $this->estado->setFormValue($row['estado']);
        }
        if (isset($row['nrodoc'])) { // nrodoc
            $this->nrodoc->setFormValue($row['nrodoc']);
        }
        if (isset($row['cotiz'])) { // cotiz
            $this->cotiz->setFormValue($row['cotiz']);
        }
        if (isset($row['fecultmod'])) { // fecultmod
            $this->fecultmod->setFormValue($row['fecultmod']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("LiquidacionList"), "", $this->TableVar, true);
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
