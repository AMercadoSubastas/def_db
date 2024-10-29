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
class EntidadesList extends Entidades
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "EntidadesList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fentidadeslist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "EntidadesList";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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
        $this->usuario->setVisibility();
        $this->contacto->setVisibility();
        $this->mailcont->setVisibility();
        $this->cargo->setVisibility();
        $this->fechahora->setVisibility();
        $this->activo->setVisibility();
        $this->pagweb->setVisibility();
        $this->tipoind->setVisibility();
        $this->usuarioultmod->setVisibility();
        $this->fecultmod->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'entidades';
        $this->TableName = 'entidades';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->TableGridClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (entidades)
        if (!isset($GLOBALS["entidades"]) || $GLOBALS["entidades"]::class == PROJECT_NAMESPACE . "entidades") {
            $GLOBALS["entidades"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "EntidadesAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "EntidadesDelete";
        $this->MultiUpdateUrl = "EntidadesUpdate";

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

        // List options
        $this->ListOptions = new ListOptions(Tag: "td", TableVar: $this->TableVar);

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Import options
        $this->ImportOptions = new ListOptions(TagClassName: "ew-import-option");

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $Language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(TagClassName: "ew-detail-option");
        // Actions
        $this->OtherOptions["action"] = new ListOptions(TagClassName: "ew-action-option");

        // Column visibility
        $this->OtherOptions["column"] = new ListOptions(
            TableVar: $this->TableVar,
            TagClassName: "ew-column-option",
            ButtonGroupClass: "ew-column-dropdown",
            UseDropDownButton: true,
            DropDownButtonPhrase: $Language->phrase("Columns"),
            DropDownAutoClose: "outside",
            UseButtonGroup: false
        );

        // Filter options
        $this->FilterOptions = new ListOptions(TagClassName: "ew-filter-option");

        // List actions
        $this->ListActions = new ListActions();
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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "EntidadesView"); // If View page, no primary button
                } else { // List page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
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
                        if ($fld->DataType == DataType::MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
        if ($this->isAddOrEdit()) {
            $this->usuario->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->fechahora->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->usuarioultmod->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->fecultmod->Visible = false;
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $HeaderOptions; // Header options
    public $FooterOptions; // Footer options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "5,10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $InlineRowCount = 0;
    public $StartRowCount = 1;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $MultiColumnGridClass = "row-cols-md";
    public $MultiColumnEditClass = "col-12 w-100";
    public $MultiColumnCardClass = "card h-200 ew-card";
    public $MultiColumnListOptionsPosition = "bottom-start";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $UserAction; // User action
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $TopContentClass = "ew-top";
    public $MiddleContentClass = "ew-middle";
    public $BottomContentClass = "ew-bottom";
    public $PageAction;
    public $RecKeys = [];
    public $IsModal = false;
    protected $FilterForModalActions = "";
    private $UseInfiniteScroll = false;

    /**
     * Load result set from filter
     *
     * @return void
     */
    public function loadRecordsetFromFilter($filter)
    {
        // Set up list options
        $this->setupListOptions();

        // Search options
        $this->setupSearchOptions();

        // Other options
        $this->setupOtherOptions();

        // Set visibility
        $this->setVisibility();

        // Load result set
        $this->TotalRecords = $this->loadRecordCount($filter);
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords;
        $this->CurrentFilter = $filter;
        $this->Recordset = $this->loadRecordset();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
    }

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $DashboardReport;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");
        $DashboardReport ??= Param(Config("PAGE_DASHBOARD"));

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();
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

        // Setup other options
        $this->setupOtherOptions();

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

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fentidadesgrid";
        }

        // Set up page action
        $this->PageAction = CurrentPageUrl(false);

        // Set up infinite scroll
        $this->UseInfiniteScroll = ConvertToBool(Param("infinitescroll"));

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $query = ""; // Query builder

        // Set up Dashboard Filter
        if ($DashboardReport) {
            AddFilter($this->Filter, $this->getDashboardFilter($DashboardReport, $this->TableVar));
        }

        // Get command
        $this->Command = strtolower(Get("cmd", ""));

        // Process list action first
        if ($this->processListAction()) { // Ajax request
            $this->terminate();
            return;
        }

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Hide list options
        if ($this->isExport()) {
            $this->ListOptions->hideAllOptions(["sequence"]);
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        } elseif ($this->isGridAdd() || $this->isGridEdit() || $this->isMultiEdit() || $this->isConfirm()) {
            $this->ListOptions->hideAllOptions();
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        }

        // Hide options
        if ($this->isExport() || !(EmptyValue($this->CurrentAction) || $this->isSearch())) {
            $this->ExportOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
            $this->ImportOptions->hideAllOptions();
        }

        // Hide other options
        if ($this->isExport()) {
            $this->OtherOptions->hideAllOptions();
        }

        // Get default search criteria
        AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
        AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

        // Get basic search values
        $this->loadBasicSearchValues();

        // Get and validate search values for advanced search
        if (EmptyValue($this->UserAction)) { // Skip if user action
            $this->loadSearchValues();
        }

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
        }
        if (!$this->validateSearch()) {
            // Nothing to do
        }

        // Restore search parms from Session if not searching / reset / export
        if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
            $this->restoreSearchParms();
        }

        // Call Recordset SearchValidated event
        $this->recordsetSearchValidated();

        // Set up sorting order
        $this->setupSortOrder();

        // Get basic search criteria
        if (!$this->hasInvalidFields()) {
            $srchBasic = $this->basicSearchWhere();
        }

        // Get advanced search criteria
        if (!$this->hasInvalidFields()) {
            $srchAdvanced = $this->advancedSearchWhere();
        }

        // Get query builder criteria
        $query = $DashboardReport ? "" : $this->queryBuilderWhere();

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms() && !$query) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere(); // Save to session
            }

            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere(); // Save to session
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        if ($query) {
            AddFilter($this->SearchWhere, $query);
        } else {
            AddFilter($this->SearchWhere, $srchAdvanced);
            AddFilter($this->SearchWhere, $srchBasic);
        }

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json" && !$query) {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        if (!$Security->canList()) {
            $this->Filter = "(0=1)"; // Filter all records
        }
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $this->Filter;
        } else {
            $this->setSessionWhere($this->Filter);
            $this->CurrentFilter = "";
        }
        $this->Filter = $this->applyUserIDFilters($this->Filter);
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } elseif (($this->isEdit() || $this->isCopy() || $this->isInlineInserted() || $this->isInlineUpdated()) && $this->UseInfiniteScroll) { // Get current record only
            $this->CurrentFilter = $this->isInlineUpdated() ? $this->getRecordFilter() : $this->getFilterFromRecordKeys();
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } elseif (
            $this->UseInfiniteScroll && $this->isGridInserted() ||
            $this->UseInfiniteScroll && ($this->isGridEdit() || $this->isGridUpdated()) ||
            $this->isMultiEdit() ||
            $this->UseInfiniteScroll && $this->isMultiUpdated()
        ) { // Get current records only
            $this->CurrentFilter = $this->FilterForModalActions; // Restore filter
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if ((EmptyValue($this->CurrentAction) || $this->isSearch()) && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Set up list action columns
        foreach ($this->ListActions as $listAction) {
            if ($listAction->Allowed) {
                if ($listAction->Select == ACTION_MULTIPLE) { // Show checkbox column if multiple action
                    $this->ListOptions["checkbox"]->Visible = true;
                } elseif ($listAction->Select == ACTION_SINGLE) { // Show list action column
                        $this->ListOptions["listactions"]->Visible = true; // Set visible if any list action is allowed
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            if ($query) { // Hide search panel if using QueryBuilder
                RemoveClass($this->SearchPanelClass, "show");
            } else {
                AppendClass($this->SearchPanelClass, "show");
            }
        }

        // API list action
        if (IsApi()) {
            if (Route(0) == Config("API_LIST_ACTION")) {
                if (!$this->isExport()) {
                    $rows = $this->getRecordsFromRecordset($this->Recordset);
                    $this->Recordset?->free();
                    WriteJson([
                        "success" => true,
                        "action" => Config("API_LIST_ACTION"),
                        $this->TableVar => $rows,
                        "totalRecordCount" => $this->TotalRecords
                    ]);
                    $this->terminate(true);
                }
                return;
            } elseif ($this->getFailureMessage() != "") {
                WriteJson(["error" => $this->getFailureMessage()]);
                $this->clearFailureMessage();
                $this->terminate(true);
                return;
            }
        }

        // Render other options
        $this->renderOtherOptions();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set ReturnUrl in header if necessary
        if ($returnUrl = Container("app.flash")->getFirstMessage("Return-Url")) {
            AddHeader("Return-Url", GetUrl($returnUrl));
        }

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

    // Get page number
    public function getPageNumber()
    {
        return ($this->DisplayRecords > 0 && $this->StartRecord > 0) ? ceil($this->StartRecord / $this->DisplayRecords) : 1;
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server") {
            $savedFilterList = Profile()->getSearchFilters("fentidadessrch");
        }
        $filterList = Concat($filterList, $this->codnum->AdvancedSearch->toJson(), ","); // Field codnum
        $filterList = Concat($filterList, $this->razsoc->AdvancedSearch->toJson(), ","); // Field razsoc
        $filterList = Concat($filterList, $this->calle->AdvancedSearch->toJson(), ","); // Field calle
        $filterList = Concat($filterList, $this->numero->AdvancedSearch->toJson(), ","); // Field numero
        $filterList = Concat($filterList, $this->pisodto->AdvancedSearch->toJson(), ","); // Field pisodto
        $filterList = Concat($filterList, $this->codpais->AdvancedSearch->toJson(), ","); // Field codpais
        $filterList = Concat($filterList, $this->codprov->AdvancedSearch->toJson(), ","); // Field codprov
        $filterList = Concat($filterList, $this->codloc->AdvancedSearch->toJson(), ","); // Field codloc
        $filterList = Concat($filterList, $this->codpost->AdvancedSearch->toJson(), ","); // Field codpost
        $filterList = Concat($filterList, $this->tellinea->AdvancedSearch->toJson(), ","); // Field tellinea
        $filterList = Concat($filterList, $this->telcelu->AdvancedSearch->toJson(), ","); // Field telcelu
        $filterList = Concat($filterList, $this->tipoent->AdvancedSearch->toJson(), ","); // Field tipoent
        $filterList = Concat($filterList, $this->tipoiva->AdvancedSearch->toJson(), ","); // Field tipoiva
        $filterList = Concat($filterList, $this->cuit->AdvancedSearch->toJson(), ","); // Field cuit
        $filterList = Concat($filterList, $this->fecalta->AdvancedSearch->toJson(), ","); // Field fecalta
        $filterList = Concat($filterList, $this->usuario->AdvancedSearch->toJson(), ","); // Field usuario
        $filterList = Concat($filterList, $this->contacto->AdvancedSearch->toJson(), ","); // Field contacto
        $filterList = Concat($filterList, $this->mailcont->AdvancedSearch->toJson(), ","); // Field mailcont
        $filterList = Concat($filterList, $this->cargo->AdvancedSearch->toJson(), ","); // Field cargo
        $filterList = Concat($filterList, $this->fechahora->AdvancedSearch->toJson(), ","); // Field fechahora
        $filterList = Concat($filterList, $this->activo->AdvancedSearch->toJson(), ","); // Field activo
        $filterList = Concat($filterList, $this->pagweb->AdvancedSearch->toJson(), ","); // Field pagweb
        $filterList = Concat($filterList, $this->tipoind->AdvancedSearch->toJson(), ","); // Field tipoind
        $filterList = Concat($filterList, $this->usuarioultmod->AdvancedSearch->toJson(), ","); // Field usuarioultmod
        $filterList = Concat($filterList, $this->fecultmod->AdvancedSearch->toJson(), ","); // Field fecultmod
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Query Builder rules
        $rules = $this->queryBuilderRules();
        if ($rules) {
            $filterList = Concat($filterList, "\"" . Config("TABLE_RULES") . "\":\"" . JsEncode($rules) . "\"", ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            Profile()->setSearchFilters("fentidadessrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field codnum
        $this->codnum->AdvancedSearch->SearchValue = @$filter["x_codnum"];
        $this->codnum->AdvancedSearch->SearchOperator = @$filter["z_codnum"];
        $this->codnum->AdvancedSearch->SearchCondition = @$filter["v_codnum"];
        $this->codnum->AdvancedSearch->SearchValue2 = @$filter["y_codnum"];
        $this->codnum->AdvancedSearch->SearchOperator2 = @$filter["w_codnum"];
        $this->codnum->AdvancedSearch->save();

        // Field razsoc
        $this->razsoc->AdvancedSearch->SearchValue = @$filter["x_razsoc"];
        $this->razsoc->AdvancedSearch->SearchOperator = @$filter["z_razsoc"];
        $this->razsoc->AdvancedSearch->SearchCondition = @$filter["v_razsoc"];
        $this->razsoc->AdvancedSearch->SearchValue2 = @$filter["y_razsoc"];
        $this->razsoc->AdvancedSearch->SearchOperator2 = @$filter["w_razsoc"];
        $this->razsoc->AdvancedSearch->save();

        // Field calle
        $this->calle->AdvancedSearch->SearchValue = @$filter["x_calle"];
        $this->calle->AdvancedSearch->SearchOperator = @$filter["z_calle"];
        $this->calle->AdvancedSearch->SearchCondition = @$filter["v_calle"];
        $this->calle->AdvancedSearch->SearchValue2 = @$filter["y_calle"];
        $this->calle->AdvancedSearch->SearchOperator2 = @$filter["w_calle"];
        $this->calle->AdvancedSearch->save();

        // Field numero
        $this->numero->AdvancedSearch->SearchValue = @$filter["x_numero"];
        $this->numero->AdvancedSearch->SearchOperator = @$filter["z_numero"];
        $this->numero->AdvancedSearch->SearchCondition = @$filter["v_numero"];
        $this->numero->AdvancedSearch->SearchValue2 = @$filter["y_numero"];
        $this->numero->AdvancedSearch->SearchOperator2 = @$filter["w_numero"];
        $this->numero->AdvancedSearch->save();

        // Field pisodto
        $this->pisodto->AdvancedSearch->SearchValue = @$filter["x_pisodto"];
        $this->pisodto->AdvancedSearch->SearchOperator = @$filter["z_pisodto"];
        $this->pisodto->AdvancedSearch->SearchCondition = @$filter["v_pisodto"];
        $this->pisodto->AdvancedSearch->SearchValue2 = @$filter["y_pisodto"];
        $this->pisodto->AdvancedSearch->SearchOperator2 = @$filter["w_pisodto"];
        $this->pisodto->AdvancedSearch->save();

        // Field codpais
        $this->codpais->AdvancedSearch->SearchValue = @$filter["x_codpais"];
        $this->codpais->AdvancedSearch->SearchOperator = @$filter["z_codpais"];
        $this->codpais->AdvancedSearch->SearchCondition = @$filter["v_codpais"];
        $this->codpais->AdvancedSearch->SearchValue2 = @$filter["y_codpais"];
        $this->codpais->AdvancedSearch->SearchOperator2 = @$filter["w_codpais"];
        $this->codpais->AdvancedSearch->save();

        // Field codprov
        $this->codprov->AdvancedSearch->SearchValue = @$filter["x_codprov"];
        $this->codprov->AdvancedSearch->SearchOperator = @$filter["z_codprov"];
        $this->codprov->AdvancedSearch->SearchCondition = @$filter["v_codprov"];
        $this->codprov->AdvancedSearch->SearchValue2 = @$filter["y_codprov"];
        $this->codprov->AdvancedSearch->SearchOperator2 = @$filter["w_codprov"];
        $this->codprov->AdvancedSearch->save();

        // Field codloc
        $this->codloc->AdvancedSearch->SearchValue = @$filter["x_codloc"];
        $this->codloc->AdvancedSearch->SearchOperator = @$filter["z_codloc"];
        $this->codloc->AdvancedSearch->SearchCondition = @$filter["v_codloc"];
        $this->codloc->AdvancedSearch->SearchValue2 = @$filter["y_codloc"];
        $this->codloc->AdvancedSearch->SearchOperator2 = @$filter["w_codloc"];
        $this->codloc->AdvancedSearch->save();

        // Field codpost
        $this->codpost->AdvancedSearch->SearchValue = @$filter["x_codpost"];
        $this->codpost->AdvancedSearch->SearchOperator = @$filter["z_codpost"];
        $this->codpost->AdvancedSearch->SearchCondition = @$filter["v_codpost"];
        $this->codpost->AdvancedSearch->SearchValue2 = @$filter["y_codpost"];
        $this->codpost->AdvancedSearch->SearchOperator2 = @$filter["w_codpost"];
        $this->codpost->AdvancedSearch->save();

        // Field tellinea
        $this->tellinea->AdvancedSearch->SearchValue = @$filter["x_tellinea"];
        $this->tellinea->AdvancedSearch->SearchOperator = @$filter["z_tellinea"];
        $this->tellinea->AdvancedSearch->SearchCondition = @$filter["v_tellinea"];
        $this->tellinea->AdvancedSearch->SearchValue2 = @$filter["y_tellinea"];
        $this->tellinea->AdvancedSearch->SearchOperator2 = @$filter["w_tellinea"];
        $this->tellinea->AdvancedSearch->save();

        // Field telcelu
        $this->telcelu->AdvancedSearch->SearchValue = @$filter["x_telcelu"];
        $this->telcelu->AdvancedSearch->SearchOperator = @$filter["z_telcelu"];
        $this->telcelu->AdvancedSearch->SearchCondition = @$filter["v_telcelu"];
        $this->telcelu->AdvancedSearch->SearchValue2 = @$filter["y_telcelu"];
        $this->telcelu->AdvancedSearch->SearchOperator2 = @$filter["w_telcelu"];
        $this->telcelu->AdvancedSearch->save();

        // Field tipoent
        $this->tipoent->AdvancedSearch->SearchValue = @$filter["x_tipoent"];
        $this->tipoent->AdvancedSearch->SearchOperator = @$filter["z_tipoent"];
        $this->tipoent->AdvancedSearch->SearchCondition = @$filter["v_tipoent"];
        $this->tipoent->AdvancedSearch->SearchValue2 = @$filter["y_tipoent"];
        $this->tipoent->AdvancedSearch->SearchOperator2 = @$filter["w_tipoent"];
        $this->tipoent->AdvancedSearch->save();

        // Field tipoiva
        $this->tipoiva->AdvancedSearch->SearchValue = @$filter["x_tipoiva"];
        $this->tipoiva->AdvancedSearch->SearchOperator = @$filter["z_tipoiva"];
        $this->tipoiva->AdvancedSearch->SearchCondition = @$filter["v_tipoiva"];
        $this->tipoiva->AdvancedSearch->SearchValue2 = @$filter["y_tipoiva"];
        $this->tipoiva->AdvancedSearch->SearchOperator2 = @$filter["w_tipoiva"];
        $this->tipoiva->AdvancedSearch->save();

        // Field cuit
        $this->cuit->AdvancedSearch->SearchValue = @$filter["x_cuit"];
        $this->cuit->AdvancedSearch->SearchOperator = @$filter["z_cuit"];
        $this->cuit->AdvancedSearch->SearchCondition = @$filter["v_cuit"];
        $this->cuit->AdvancedSearch->SearchValue2 = @$filter["y_cuit"];
        $this->cuit->AdvancedSearch->SearchOperator2 = @$filter["w_cuit"];
        $this->cuit->AdvancedSearch->save();

        // Field fecalta
        $this->fecalta->AdvancedSearch->SearchValue = @$filter["x_fecalta"];
        $this->fecalta->AdvancedSearch->SearchOperator = @$filter["z_fecalta"];
        $this->fecalta->AdvancedSearch->SearchCondition = @$filter["v_fecalta"];
        $this->fecalta->AdvancedSearch->SearchValue2 = @$filter["y_fecalta"];
        $this->fecalta->AdvancedSearch->SearchOperator2 = @$filter["w_fecalta"];
        $this->fecalta->AdvancedSearch->save();

        // Field usuario
        $this->usuario->AdvancedSearch->SearchValue = @$filter["x_usuario"];
        $this->usuario->AdvancedSearch->SearchOperator = @$filter["z_usuario"];
        $this->usuario->AdvancedSearch->SearchCondition = @$filter["v_usuario"];
        $this->usuario->AdvancedSearch->SearchValue2 = @$filter["y_usuario"];
        $this->usuario->AdvancedSearch->SearchOperator2 = @$filter["w_usuario"];
        $this->usuario->AdvancedSearch->save();

        // Field contacto
        $this->contacto->AdvancedSearch->SearchValue = @$filter["x_contacto"];
        $this->contacto->AdvancedSearch->SearchOperator = @$filter["z_contacto"];
        $this->contacto->AdvancedSearch->SearchCondition = @$filter["v_contacto"];
        $this->contacto->AdvancedSearch->SearchValue2 = @$filter["y_contacto"];
        $this->contacto->AdvancedSearch->SearchOperator2 = @$filter["w_contacto"];
        $this->contacto->AdvancedSearch->save();

        // Field mailcont
        $this->mailcont->AdvancedSearch->SearchValue = @$filter["x_mailcont"];
        $this->mailcont->AdvancedSearch->SearchOperator = @$filter["z_mailcont"];
        $this->mailcont->AdvancedSearch->SearchCondition = @$filter["v_mailcont"];
        $this->mailcont->AdvancedSearch->SearchValue2 = @$filter["y_mailcont"];
        $this->mailcont->AdvancedSearch->SearchOperator2 = @$filter["w_mailcont"];
        $this->mailcont->AdvancedSearch->save();

        // Field cargo
        $this->cargo->AdvancedSearch->SearchValue = @$filter["x_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator = @$filter["z_cargo"];
        $this->cargo->AdvancedSearch->SearchCondition = @$filter["v_cargo"];
        $this->cargo->AdvancedSearch->SearchValue2 = @$filter["y_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator2 = @$filter["w_cargo"];
        $this->cargo->AdvancedSearch->save();

        // Field fechahora
        $this->fechahora->AdvancedSearch->SearchValue = @$filter["x_fechahora"];
        $this->fechahora->AdvancedSearch->SearchOperator = @$filter["z_fechahora"];
        $this->fechahora->AdvancedSearch->SearchCondition = @$filter["v_fechahora"];
        $this->fechahora->AdvancedSearch->SearchValue2 = @$filter["y_fechahora"];
        $this->fechahora->AdvancedSearch->SearchOperator2 = @$filter["w_fechahora"];
        $this->fechahora->AdvancedSearch->save();

        // Field activo
        $this->activo->AdvancedSearch->SearchValue = @$filter["x_activo"];
        $this->activo->AdvancedSearch->SearchOperator = @$filter["z_activo"];
        $this->activo->AdvancedSearch->SearchCondition = @$filter["v_activo"];
        $this->activo->AdvancedSearch->SearchValue2 = @$filter["y_activo"];
        $this->activo->AdvancedSearch->SearchOperator2 = @$filter["w_activo"];
        $this->activo->AdvancedSearch->save();

        // Field pagweb
        $this->pagweb->AdvancedSearch->SearchValue = @$filter["x_pagweb"];
        $this->pagweb->AdvancedSearch->SearchOperator = @$filter["z_pagweb"];
        $this->pagweb->AdvancedSearch->SearchCondition = @$filter["v_pagweb"];
        $this->pagweb->AdvancedSearch->SearchValue2 = @$filter["y_pagweb"];
        $this->pagweb->AdvancedSearch->SearchOperator2 = @$filter["w_pagweb"];
        $this->pagweb->AdvancedSearch->save();

        // Field tipoind
        $this->tipoind->AdvancedSearch->SearchValue = @$filter["x_tipoind"];
        $this->tipoind->AdvancedSearch->SearchOperator = @$filter["z_tipoind"];
        $this->tipoind->AdvancedSearch->SearchCondition = @$filter["v_tipoind"];
        $this->tipoind->AdvancedSearch->SearchValue2 = @$filter["y_tipoind"];
        $this->tipoind->AdvancedSearch->SearchOperator2 = @$filter["w_tipoind"];
        $this->tipoind->AdvancedSearch->save();

        // Field usuarioultmod
        $this->usuarioultmod->AdvancedSearch->SearchValue = @$filter["x_usuarioultmod"];
        $this->usuarioultmod->AdvancedSearch->SearchOperator = @$filter["z_usuarioultmod"];
        $this->usuarioultmod->AdvancedSearch->SearchCondition = @$filter["v_usuarioultmod"];
        $this->usuarioultmod->AdvancedSearch->SearchValue2 = @$filter["y_usuarioultmod"];
        $this->usuarioultmod->AdvancedSearch->SearchOperator2 = @$filter["w_usuarioultmod"];
        $this->usuarioultmod->AdvancedSearch->save();

        // Field fecultmod
        $this->fecultmod->AdvancedSearch->SearchValue = @$filter["x_fecultmod"];
        $this->fecultmod->AdvancedSearch->SearchOperator = @$filter["z_fecultmod"];
        $this->fecultmod->AdvancedSearch->SearchCondition = @$filter["v_fecultmod"];
        $this->fecultmod->AdvancedSearch->SearchValue2 = @$filter["y_fecultmod"];
        $this->fecultmod->AdvancedSearch->SearchOperator2 = @$filter["w_fecultmod"];
        $this->fecultmod->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
        if ($filter[Config("TABLE_RULES")] ?? false) {
            $this->Command = "query"; // Set command for query builder
            $this->setSessionRules($filter[Config("TABLE_RULES")]);
        }
    }

    // Advanced search WHERE clause based on QueryString
    public function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->codnum, $default, false); // codnum
        $this->buildSearchSql($where, $this->razsoc, $default, false); // razsoc
        $this->buildSearchSql($where, $this->calle, $default, false); // calle
        $this->buildSearchSql($where, $this->numero, $default, false); // numero
        $this->buildSearchSql($where, $this->pisodto, $default, false); // pisodto
        $this->buildSearchSql($where, $this->codpais, $default, false); // codpais
        $this->buildSearchSql($where, $this->codprov, $default, false); // codprov
        $this->buildSearchSql($where, $this->codloc, $default, false); // codloc
        $this->buildSearchSql($where, $this->codpost, $default, false); // codpost
        $this->buildSearchSql($where, $this->tellinea, $default, false); // tellinea
        $this->buildSearchSql($where, $this->telcelu, $default, false); // telcelu
        $this->buildSearchSql($where, $this->tipoent, $default, false); // tipoent
        $this->buildSearchSql($where, $this->tipoiva, $default, false); // tipoiva
        $this->buildSearchSql($where, $this->cuit, $default, false); // cuit
        $this->buildSearchSql($where, $this->fecalta, $default, false); // fecalta
        $this->buildSearchSql($where, $this->usuario, $default, false); // usuario
        $this->buildSearchSql($where, $this->contacto, $default, false); // contacto
        $this->buildSearchSql($where, $this->mailcont, $default, false); // mailcont
        $this->buildSearchSql($where, $this->cargo, $default, false); // cargo
        $this->buildSearchSql($where, $this->fechahora, $default, false); // fechahora
        $this->buildSearchSql($where, $this->activo, $default, false); // activo
        $this->buildSearchSql($where, $this->pagweb, $default, false); // pagweb
        $this->buildSearchSql($where, $this->tipoind, $default, false); // tipoind
        $this->buildSearchSql($where, $this->usuarioultmod, $default, false); // usuarioultmod
        $this->buildSearchSql($where, $this->fecultmod, $default, false); // fecultmod

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->codnum->AdvancedSearch->save(); // codnum
            $this->razsoc->AdvancedSearch->save(); // razsoc
            $this->calle->AdvancedSearch->save(); // calle
            $this->numero->AdvancedSearch->save(); // numero
            $this->pisodto->AdvancedSearch->save(); // pisodto
            $this->codpais->AdvancedSearch->save(); // codpais
            $this->codprov->AdvancedSearch->save(); // codprov
            $this->codloc->AdvancedSearch->save(); // codloc
            $this->codpost->AdvancedSearch->save(); // codpost
            $this->tellinea->AdvancedSearch->save(); // tellinea
            $this->telcelu->AdvancedSearch->save(); // telcelu
            $this->tipoent->AdvancedSearch->save(); // tipoent
            $this->tipoiva->AdvancedSearch->save(); // tipoiva
            $this->cuit->AdvancedSearch->save(); // cuit
            $this->fecalta->AdvancedSearch->save(); // fecalta
            $this->usuario->AdvancedSearch->save(); // usuario
            $this->contacto->AdvancedSearch->save(); // contacto
            $this->mailcont->AdvancedSearch->save(); // mailcont
            $this->cargo->AdvancedSearch->save(); // cargo
            $this->fechahora->AdvancedSearch->save(); // fechahora
            $this->activo->AdvancedSearch->save(); // activo
            $this->pagweb->AdvancedSearch->save(); // pagweb
            $this->tipoind->AdvancedSearch->save(); // tipoind
            $this->usuarioultmod->AdvancedSearch->save(); // usuarioultmod
            $this->fecultmod->AdvancedSearch->save(); // fecultmod

            // Clear rules for QueryBuilder
            $this->setSessionRules("");
        }
        return $where;
    }

    // Query builder rules
    public function queryBuilderRules()
    {
        return Post("rules") ?? $this->getSessionRules();
    }

    // Quey builder WHERE clause
    public function queryBuilderWhere($fieldName = "")
    {
        global $Security;
        if (!$Security->canSearch()) {
            return "";
        }

        // Get rules by query builder
        $rules = $this->queryBuilderRules();

        // Decode and parse rules
        $where = $rules ? $this->parseRules(json_decode($rules, true), $fieldName) : "";

        // Clear other search and save rules to session
        if ($where && $fieldName == "") { // Skip if get query for specific field
            $this->resetSearchParms();
            $this->codnum->AdvancedSearch->save(); // codnum
            $this->razsoc->AdvancedSearch->save(); // razsoc
            $this->calle->AdvancedSearch->save(); // calle
            $this->numero->AdvancedSearch->save(); // numero
            $this->pisodto->AdvancedSearch->save(); // pisodto
            $this->codpais->AdvancedSearch->save(); // codpais
            $this->codprov->AdvancedSearch->save(); // codprov
            $this->codloc->AdvancedSearch->save(); // codloc
            $this->codpost->AdvancedSearch->save(); // codpost
            $this->tellinea->AdvancedSearch->save(); // tellinea
            $this->telcelu->AdvancedSearch->save(); // telcelu
            $this->tipoent->AdvancedSearch->save(); // tipoent
            $this->tipoiva->AdvancedSearch->save(); // tipoiva
            $this->cuit->AdvancedSearch->save(); // cuit
            $this->fecalta->AdvancedSearch->save(); // fecalta
            $this->usuario->AdvancedSearch->save(); // usuario
            $this->contacto->AdvancedSearch->save(); // contacto
            $this->mailcont->AdvancedSearch->save(); // mailcont
            $this->cargo->AdvancedSearch->save(); // cargo
            $this->fechahora->AdvancedSearch->save(); // fechahora
            $this->activo->AdvancedSearch->save(); // activo
            $this->pagweb->AdvancedSearch->save(); // pagweb
            $this->tipoind->AdvancedSearch->save(); // tipoind
            $this->usuarioultmod->AdvancedSearch->save(); // usuarioultmod
            $this->fecultmod->AdvancedSearch->save(); // fecultmod
            $this->setSessionRules($rules);
        }

        // Return query
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, $fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = $default ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = $default ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $fldVal = ConvertSearchValue($fldVal, $fldOpr, $fld);
        $fldVal2 = ConvertSearchValue($fldVal2, $fldOpr2, $fld);
        $fldOpr = ConvertSearchOperator($fldOpr, $fld, $fldVal);
        $fldOpr2 = ConvertSearchOperator($fldOpr2, $fld, $fldVal2);
        $wrk = "";
        $sep = $fld->UseFilter ? Config("FILTER_OPTION_SEPARATOR") : Config("MULTIPLE_OPTION_SEPARATOR");
        if (is_array($fldVal)) {
            $fldVal = implode($sep, $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode($sep, $fldVal2);
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 && !$fld->UseFilter || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = $fldVal2 != "" ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            AddFilter($wrk, $wrk2, $fldCond);
        } else {
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        if ($this->SearchOption == "AUTO" && in_array($this->BasicSearch->getType(), ["AND", "OR"])) {
            $cond = $this->BasicSearch->getType();
        } else {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
        }
        AddFilter($where, $wrk, $cond);
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field codnum
        $filter = $this->queryBuilderWhere("codnum");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->codnum, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->codnum->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field razsoc
        $filter = $this->queryBuilderWhere("razsoc");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->razsoc, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->razsoc->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field calle
        $filter = $this->queryBuilderWhere("calle");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->calle, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->calle->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field numero
        $filter = $this->queryBuilderWhere("numero");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->numero, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->numero->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field pisodto
        $filter = $this->queryBuilderWhere("pisodto");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->pisodto, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->pisodto->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field codpais
        $filter = $this->queryBuilderWhere("codpais");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->codpais, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->codpais->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field codprov
        $filter = $this->queryBuilderWhere("codprov");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->codprov, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->codprov->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field codloc
        $filter = $this->queryBuilderWhere("codloc");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->codloc, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->codloc->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field codpost
        $filter = $this->queryBuilderWhere("codpost");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->codpost, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->codpost->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tellinea
        $filter = $this->queryBuilderWhere("tellinea");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tellinea, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tellinea->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field telcelu
        $filter = $this->queryBuilderWhere("telcelu");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->telcelu, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->telcelu->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tipoent
        $filter = $this->queryBuilderWhere("tipoent");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tipoent, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipoent->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tipoiva
        $filter = $this->queryBuilderWhere("tipoiva");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tipoiva, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipoiva->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cuit
        $filter = $this->queryBuilderWhere("cuit");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cuit, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cuit->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fecalta
        $filter = $this->queryBuilderWhere("fecalta");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fecalta, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fecalta->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field usuario
        $filter = $this->queryBuilderWhere("usuario");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->usuario, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->usuario->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field contacto
        $filter = $this->queryBuilderWhere("contacto");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->contacto, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->contacto->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field mailcont
        $filter = $this->queryBuilderWhere("mailcont");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->mailcont, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->mailcont->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cargo
        $filter = $this->queryBuilderWhere("cargo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cargo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cargo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fechahora
        $filter = $this->queryBuilderWhere("fechahora");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fechahora, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fechahora->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field activo
        $filter = $this->queryBuilderWhere("activo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->activo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->activo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field pagweb
        $filter = $this->queryBuilderWhere("pagweb");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->pagweb, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->pagweb->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tipoind
        $filter = $this->queryBuilderWhere("tipoind");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tipoind, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipoind->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field usuarioultmod
        $filter = $this->queryBuilderWhere("usuarioultmod");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->usuarioultmod, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->usuarioultmod->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fecultmod
        $filter = $this->queryBuilderWhere("fecultmod");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fecultmod, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fecultmod->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }
        if ($this->BasicSearch->Keyword != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $Language->phrase("BasicSearchKeyword") . "</span>" . $captionSuffix . $this->BasicSearch->Keyword . "</div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"callout callout-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<div id=\"ew-filter-list\"></div>");
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    public function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }

        // Fields to search
        $searchFlds = [];
        $searchFlds[] = &$this->razsoc;
        $searchFlds[] = &$this->calle;
        $searchFlds[] = &$this->numero;
        $searchFlds[] = &$this->pisodto;
        $searchFlds[] = &$this->codpost;
        $searchFlds[] = &$this->tellinea;
        $searchFlds[] = &$this->telcelu;
        $searchFlds[] = &$this->cuit;
        $searchFlds[] = &$this->contacto;
        $searchFlds[] = &$this->mailcont;
        $searchFlds[] = &$this->cargo;
        $searchFlds[] = &$this->pagweb;
        $searchKeyword = $default ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = $default ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            $searchStr = GetQuickSearchFilter($searchFlds, $ar, $searchType, Config("BASIC_SEARCH_ANY_FIELDS"), $this->Dbid);
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);

            // Clear rules for QueryBuilder
            $this->setSessionRules("");
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        if ($this->codnum->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->razsoc->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->calle->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->numero->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->pisodto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->codpais->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->codprov->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->codloc->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->codpost->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tellinea->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telcelu->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipoent->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipoiva->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cuit->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecalta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usuario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->contacto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->mailcont->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cargo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fechahora->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->activo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->pagweb->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipoind->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usuarioultmod->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecultmod->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();

        // Clear queryBuilder
        $this->setSessionRules("");
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->codnum->AdvancedSearch->unsetSession();
        $this->razsoc->AdvancedSearch->unsetSession();
        $this->calle->AdvancedSearch->unsetSession();
        $this->numero->AdvancedSearch->unsetSession();
        $this->pisodto->AdvancedSearch->unsetSession();
        $this->codpais->AdvancedSearch->unsetSession();
        $this->codprov->AdvancedSearch->unsetSession();
        $this->codloc->AdvancedSearch->unsetSession();
        $this->codpost->AdvancedSearch->unsetSession();
        $this->tellinea->AdvancedSearch->unsetSession();
        $this->telcelu->AdvancedSearch->unsetSession();
        $this->tipoent->AdvancedSearch->unsetSession();
        $this->tipoiva->AdvancedSearch->unsetSession();
        $this->cuit->AdvancedSearch->unsetSession();
        $this->fecalta->AdvancedSearch->unsetSession();
        $this->usuario->AdvancedSearch->unsetSession();
        $this->contacto->AdvancedSearch->unsetSession();
        $this->mailcont->AdvancedSearch->unsetSession();
        $this->cargo->AdvancedSearch->unsetSession();
        $this->fechahora->AdvancedSearch->unsetSession();
        $this->activo->AdvancedSearch->unsetSession();
        $this->pagweb->AdvancedSearch->unsetSession();
        $this->tipoind->AdvancedSearch->unsetSession();
        $this->usuarioultmod->AdvancedSearch->unsetSession();
        $this->fecultmod->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->codnum->AdvancedSearch->load();
        $this->razsoc->AdvancedSearch->load();
        $this->calle->AdvancedSearch->load();
        $this->numero->AdvancedSearch->load();
        $this->pisodto->AdvancedSearch->load();
        $this->codpais->AdvancedSearch->load();
        $this->codprov->AdvancedSearch->load();
        $this->codloc->AdvancedSearch->load();
        $this->codpost->AdvancedSearch->load();
        $this->tellinea->AdvancedSearch->load();
        $this->telcelu->AdvancedSearch->load();
        $this->tipoent->AdvancedSearch->load();
        $this->tipoiva->AdvancedSearch->load();
        $this->cuit->AdvancedSearch->load();
        $this->fecalta->AdvancedSearch->load();
        $this->usuario->AdvancedSearch->load();
        $this->contacto->AdvancedSearch->load();
        $this->mailcont->AdvancedSearch->load();
        $this->cargo->AdvancedSearch->load();
        $this->fechahora->AdvancedSearch->load();
        $this->activo->AdvancedSearch->load();
        $this->pagweb->AdvancedSearch->load();
        $this->tipoind->AdvancedSearch->load();
        $this->usuarioultmod->AdvancedSearch->load();
        $this->fecultmod->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = ""; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
            $defaultSortList = ""; // Set up default sort
            if ($this->getSessionOrderByList() == "" && $defaultSortList != "") {
                $this->setSessionOrderByList($defaultSortList);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->codnum); // codnum
            $this->updateSort($this->razsoc); // razsoc
            $this->updateSort($this->calle); // calle
            $this->updateSort($this->numero); // numero
            $this->updateSort($this->pisodto); // pisodto
            $this->updateSort($this->codpais); // codpais
            $this->updateSort($this->codprov); // codprov
            $this->updateSort($this->codloc); // codloc
            $this->updateSort($this->codpost); // codpost
            $this->updateSort($this->tellinea); // tellinea
            $this->updateSort($this->telcelu); // telcelu
            $this->updateSort($this->tipoent); // tipoent
            $this->updateSort($this->tipoiva); // tipoiva
            $this->updateSort($this->cuit); // cuit
            $this->updateSort($this->calif); // calif
            $this->updateSort($this->fecalta); // fecalta
            $this->updateSort($this->usuario); // usuario
            $this->updateSort($this->contacto); // contacto
            $this->updateSort($this->mailcont); // mailcont
            $this->updateSort($this->cargo); // cargo
            $this->updateSort($this->fechahora); // fechahora
            $this->updateSort($this->activo); // activo
            $this->updateSort($this->pagweb); // pagweb
            $this->updateSort($this->tipoind); // tipoind
            $this->updateSort($this->usuarioultmod); // usuarioultmod
            $this->updateSort($this->fecultmod); // fecultmod
            $this->setStartRecordNumber(1); // Reset start position
        }

        // Update field sort
        $this->updateFieldSort();
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->setSessionOrderByList($orderBy);
                $this->codnum->setSort("");
                $this->razsoc->setSort("");
                $this->calle->setSort("");
                $this->numero->setSort("");
                $this->pisodto->setSort("");
                $this->codpais->setSort("");
                $this->codprov->setSort("");
                $this->codloc->setSort("");
                $this->codpost->setSort("");
                $this->tellinea->setSort("");
                $this->telcelu->setSort("");
                $this->tipoent->setSort("");
                $this->tipoiva->setSort("");
                $this->cuit->setSort("");
                $this->calif->setSort("");
                $this->fecalta->setSort("");
                $this->usuario->setSort("");
                $this->contacto->setSort("");
                $this->mailcont->setSort("");
                $this->cargo->setSort("");
                $this->fechahora->setSort("");
                $this->activo->setSort("");
                $this->pagweb->setSort("");
                $this->tipoind->setSort("");
                $this->usuarioultmod->setSort("");
                $this->fecultmod->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = true;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"form-check\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"form-check-input\" data-ew-action=\"select-all-keys\"></div>";
        if ($item->OnLeft) {
            $item->moveTo(0);
        }
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = true;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = true;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
        // Preview extension
        $this->ListOptions->hideDetailItemsForDropDown(); // Hide detail items for dropdown if necessary
    }

    // Add "hash" parameter to URL
    public function urlAddHash($url, $hash)
    {
        return $this->UseAjaxActions ? $url : UrlAddQuery($url, "hash=" . $hash);
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"entidades\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                if ($this->ModalEdit && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"entidades\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                if ($this->ModalAdd && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"entidades\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
                $deleteCaption = $Language->phrase("DeleteLink");
                $deleteTitle = HtmlTitle($deleteCaption);
                if ($this->UseAjaxActions) {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"inline\" data-action=\"delete\" title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" data-key= \"" . HtmlEncode($this->getKey(true)) . "\" data-url=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\"" .
                        ($this->InlineDelete ? " data-ew-action=\"inline-delete\"" : "") .
                        " title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                }
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions as $listAction) {
                $action = $listAction->Action;
                $allowed = $listAction->Allowed;
                $disabled = false;
                if ($listAction->Select == ACTION_SINGLE && $allowed) {
                    $caption = $listAction->Caption;
                    $title = HtmlTitle($caption);
                    if ($action != "") {
                        $icon = ($listAction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listAction->Icon)) . "\" data-caption=\"" . $title . "\"></i> " : "";
                        $link = $disabled
                            ? "<li><div class=\"alert alert-light\">" . $icon . " " . $caption . "</div></li>"
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fentidadeslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fentidadeslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
                        }
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = implode(array_map(fn($link) => "<li>" . $link . "</li>", $links));
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->codnum->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        if ($this->ModalAdd && !IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"entidades\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "codnum");
            $this->createColumnOption($option, "razsoc");
            $this->createColumnOption($option, "calle");
            $this->createColumnOption($option, "numero");
            $this->createColumnOption($option, "pisodto");
            $this->createColumnOption($option, "codpais");
            $this->createColumnOption($option, "codprov");
            $this->createColumnOption($option, "codloc");
            $this->createColumnOption($option, "codpost");
            $this->createColumnOption($option, "tellinea");
            $this->createColumnOption($option, "telcelu");
            $this->createColumnOption($option, "tipoent");
            $this->createColumnOption($option, "tipoiva");
            $this->createColumnOption($option, "cuit");
            $this->createColumnOption($option, "calif");
            $this->createColumnOption($option, "fecalta");
            $this->createColumnOption($option, "usuario");
            $this->createColumnOption($option, "contacto");
            $this->createColumnOption($option, "mailcont");
            $this->createColumnOption($option, "cargo");
            $this->createColumnOption($option, "fechahora");
            $this->createColumnOption($option, "activo");
            $this->createColumnOption($option, "pagweb");
            $this->createColumnOption($option, "tipoind");
            $this->createColumnOption($option, "usuarioultmod");
            $this->createColumnOption($option, "fecultmod");
        }

        // Set up custom actions
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions[$name] = $action;
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = false;
                $option->UseButtonGroup = true;
            }
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fentidadessrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fentidadessrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Page header/footer options
        $this->HeaderOptions = new ListOptions(TagClassName: "ew-header-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->HeaderOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
        $this->FooterOptions = new ListOptions(TagClassName: "ew-footer-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->FooterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Show active user count from SQL
    }

    // Active user filter
    // - Get active users by SQL (SELECT COUNT(*) FROM UserTable WHERE ProfileField LIKE '%"SessionID":%')
    protected function activeUserFilter()
    {
        if (UserProfile::$FORCE_LOGOUT_USER) {
            $userProfileField = $this->Fields[Config("USER_PROFILE_FIELD_NAME")];
            return $userProfileField->Expression . " LIKE '%\"" . UserProfile::$SESSION_ID . "\":%'";
        }
        return "0=1"; // No active users
    }

    // Create new column option
    protected function createColumnOption($option, $name)
    {
        $field = $this->Fields[$name] ?? null;
        if ($field?->Visible) {
            $item = $option->add($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions as $listAction) {
            if ($listAction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listAction->Action);
                $caption = $listAction->Caption;
                $icon = ($listAction->Icon != "") ? '<i class="' . HtmlEncode($listAction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fentidadeslist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
                $item->Visible = $listAction->Allowed;
            }
        }

        // Hide multi edit, grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security, $Response;
        $users = [];
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("action", "");
        if ($filter != "" && $userAction != "") {
            $conn = $this->getConnection();
            // Clear current action
            $this->CurrentAction = "";
            // Check permission first
            $actionCaption = $userAction;
            $listAction = $this->ListActions[$userAction] ?? null;
            if ($listAction) {
                $this->UserAction = $userAction;
                $actionCaption = $listAction->Caption ?: $listAction->Action;
                if (!$listAction->Allowed) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            } else {
                $errmsg = str_replace('%s', $userAction, $Language->phrase("CustomActionNotFound"));
                if (Post("ajax") == $userAction) { // Ajax
                    echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                    return true;
                } else {
                    $this->setFailureMessage($errmsg);
                    return false;
                }
            }
            $rows = $this->loadRs($filter)->fetchAllAssociative();
            $this->SelectedCount = count($rows);
            $this->ActionValue = Post("actionvalue");

            // Call row action event
            if ($this->SelectedCount > 0) {
                if ($this->UseTransaction) {
                    $conn->beginTransaction();
                }
                $this->SelectedIndex = 0;
                foreach ($rows as $row) {
                    $this->SelectedIndex++;
                    $processed = $listAction->handle($row, $this);
                    if (!$processed) {
                        break;
                    }
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                }
                if ($processed) {
                    if ($this->UseTransaction) { // Commit transaction
                        if ($conn->isTransactionActive()) {
                            $conn->commit();
                        }
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($listAction->SuccessMessage);
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage(str_replace("%s", $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        if ($conn->isTransactionActive()) {
                            $conn->rollback();
                        }
                    }
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($listAction->FailureMessage);
                    }

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if (Post("ajax") == $userAction) { // Ajax
                if (WithJsonResponse()) { // List action returns JSON
                    $this->clearSuccessMessage(); // Clear success message
                    $this->clearFailureMessage(); // Clear failure message
                } else {
                    if ($this->getSuccessMessage() != "") {
                        echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                        $this->clearSuccessMessage(); // Clear success message
                    }
                    if ($this->getFailureMessage() != "") {
                        echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                        $this->clearFailureMessage(); // Clear failure message
                    }
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        if ($this->ExportAll && $this->isExport()) {
            $this->StopRecord = $this->TotalRecords;
        } else {
            // Set the last record to display
            if ($this->TotalRecords > $this->StartRecord + $this->DisplayRecords - 1) {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            } else {
                $this->StopRecord = $this->TotalRecords;
            }
        }
        $this->RecordCount = $this->StartRecord - 1;
        if ($this->CurrentRow !== false) {
            // Nothing to do
        } elseif ($this->isGridAdd() && !$this->AllowAddDeleteRow && $this->StopRecord == 0) { // Grid-Add with no records
            $this->StopRecord = $this->GridAddRowCount;
        } elseif ($this->isAdd() && $this->TotalRecords == 0) { // Inline-Add with no records
            $this->StopRecord = 1;
        }

        // Initialize aggregate
        $this->RowType = RowType::AGGREGATEINIT;
        $this->resetAttributes();
        $this->renderRow();
        if (($this->isGridAdd() || $this->isGridEdit())) { // Render template row first
            $this->RowIndex = '$rowindex$';
        }
    }

    // Set up Row
    public function setupRow()
    {
        global $CurrentForm;
        if ($this->isGridAdd() || $this->isGridEdit()) {
            if ($this->RowIndex === '$rowindex$') { // Render template row first
                $this->loadRowValues();

                // Set row properties
                $this->resetAttributes();
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_entidades", "data-rowtype" => RowType::ADD]);
                $this->RowAttrs->appendClass("ew-template");
                // Render row
                $this->RowType = RowType::ADD;
                $this->renderRow();

                // Render list options
                $this->renderListOptions();

                // Reset record count for template row
                $this->RecordCount--;
                return;
            }
        }

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isCopy() && $this->InlineRowCount == 0 && !$this->loadRow()) { // Inline copy
            $this->CurrentAction = "add";
        }
        if ($this->isAdd() && $this->InlineRowCount == 0 || $this->isGridAdd()) {
            $this->loadRowValues(); // Load default values
            $this->OldKey = "";
            $this->setKey($this->OldKey);
        } elseif ($this->isInlineInserted() && $this->UseInfiniteScroll) {
            // Nothing to do, just use current values
        } elseif (!($this->isCopy() && $this->InlineRowCount == 0)) {
            $this->loadRowValues($this->CurrentRow); // Load row values
            if ($this->isGridEdit() || $this->isMultiEdit()) {
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey);
            }
        }
        $this->RowType = RowType::VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = RowType::ADD; // Render add
        }

        // Inline Add/Copy row (row 0)
        if ($this->RowType == RowType::ADD && ($this->isAdd() || $this->isCopy())) {
            $this->InlineRowCount++;
            $this->RecordCount--; // Reset record count for inline add/copy row
            if ($this->TotalRecords == 0) { // Reset stop record if no records
                $this->StopRecord = 0;
            }
        } else {
            // Inline Edit row
            if ($this->RowType == RowType::EDIT && $this->isEdit()) {
                $this->InlineRowCount++;
            }
            $this->RowCount++; // Increment row count
        }

        // Set up row attributes
        $this->RowAttrs->merge([
            "data-rowindex" => $this->RowCount,
            "data-key" => $this->getKey(true),
            "id" => "r" . $this->RowCount . "_entidades",
            "data-rowtype" => $this->RowType,
            "data-inline" => ($this->isAdd() || $this->isCopy() || $this->isEdit()) ? "true" : "false", // Inline-Add/Copy/Edit
            "class" => ($this->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($this->isAdd() && $this->RowType == RowType::ADD || $this->isEdit() && $this->RowType == RowType::EDIT) { // Inline-Add/Edit row
            $this->RowAttrs->appendClass("table-active");
        }

        // Render row
        $this->renderRow();

        // Render list options
        $this->renderListOptions();
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // Load query builder rules
        $rules = Post("rules");
        if ($rules && $this->Command == "") {
            $this->QueryRules = $rules;
            $this->Command = "search";
        }

        // codnum
        if ($this->codnum->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->codnum->AdvancedSearch->SearchValue != "" || $this->codnum->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // razsoc
        if ($this->razsoc->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->razsoc->AdvancedSearch->SearchValue != "" || $this->razsoc->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // calle
        if ($this->calle->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->calle->AdvancedSearch->SearchValue != "" || $this->calle->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // numero
        if ($this->numero->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->numero->AdvancedSearch->SearchValue != "" || $this->numero->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // pisodto
        if ($this->pisodto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->pisodto->AdvancedSearch->SearchValue != "" || $this->pisodto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // codpais
        if ($this->codpais->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->codpais->AdvancedSearch->SearchValue != "" || $this->codpais->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // codprov
        if ($this->codprov->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->codprov->AdvancedSearch->SearchValue != "" || $this->codprov->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // codloc
        if ($this->codloc->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->codloc->AdvancedSearch->SearchValue != "" || $this->codloc->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // codpost
        if ($this->codpost->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->codpost->AdvancedSearch->SearchValue != "" || $this->codpost->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tellinea
        if ($this->tellinea->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tellinea->AdvancedSearch->SearchValue != "" || $this->tellinea->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // telcelu
        if ($this->telcelu->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->telcelu->AdvancedSearch->SearchValue != "" || $this->telcelu->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipoent
        if ($this->tipoent->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipoent->AdvancedSearch->SearchValue != "" || $this->tipoent->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipoiva
        if ($this->tipoiva->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipoiva->AdvancedSearch->SearchValue != "" || $this->tipoiva->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cuit
        if ($this->cuit->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cuit->AdvancedSearch->SearchValue != "" || $this->cuit->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecalta
        if ($this->fecalta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecalta->AdvancedSearch->SearchValue != "" || $this->fecalta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usuario
        if ($this->usuario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usuario->AdvancedSearch->SearchValue != "" || $this->usuario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // contacto
        if ($this->contacto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->contacto->AdvancedSearch->SearchValue != "" || $this->contacto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // mailcont
        if ($this->mailcont->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->mailcont->AdvancedSearch->SearchValue != "" || $this->mailcont->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cargo
        if ($this->cargo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cargo->AdvancedSearch->SearchValue != "" || $this->cargo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fechahora
        if ($this->fechahora->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fechahora->AdvancedSearch->SearchValue != "" || $this->fechahora->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // activo
        if ($this->activo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->activo->AdvancedSearch->SearchValue != "" || $this->activo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // pagweb
        if ($this->pagweb->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->pagweb->AdvancedSearch->SearchValue != "" || $this->pagweb->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipoind
        if ($this->tipoind->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipoind->AdvancedSearch->SearchValue != "" || $this->tipoind->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usuarioultmod
        if ($this->usuarioultmod->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usuarioultmod->AdvancedSearch->SearchValue != "" || $this->usuarioultmod->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecultmod
        if ($this->fecultmod->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecultmod->AdvancedSearch->SearchValue != "" || $this->fecultmod->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
    }

    /**
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // codnum

        // razsoc

        // calle

        // numero

        // pisodto

        // codpais

        // codprov

        // codloc

        // codpost

        // tellinea

        // telcelu

        // tipoent

        // tipoiva

        // cuit

        // calif

        // fecalta

        // usuario

        // contacto

        // mailcont

        // cargo

        // fechahora

        // activo

        // pagweb

        // tipoind

        // usuarioultmod

        // fecultmod

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

            // codnum
            $this->codnum->HrefValue = "";
            $this->codnum->TooltipValue = "";

            // razsoc
            $this->razsoc->HrefValue = "";
            $this->razsoc->TooltipValue = "";

            // calle
            $this->calle->HrefValue = "";
            $this->calle->TooltipValue = "";

            // numero
            $this->numero->HrefValue = "";
            $this->numero->TooltipValue = "";

            // pisodto
            $this->pisodto->HrefValue = "";
            $this->pisodto->TooltipValue = "";

            // codpais
            $this->codpais->HrefValue = "";
            $this->codpais->TooltipValue = "";

            // codprov
            $this->codprov->HrefValue = "";
            $this->codprov->TooltipValue = "";

            // codloc
            $this->codloc->HrefValue = "";
            $this->codloc->TooltipValue = "";

            // codpost
            $this->codpost->HrefValue = "";
            $this->codpost->TooltipValue = "";

            // tellinea
            $this->tellinea->HrefValue = "";
            $this->tellinea->TooltipValue = "";

            // telcelu
            $this->telcelu->HrefValue = "";
            $this->telcelu->TooltipValue = "";

            // tipoent
            $this->tipoent->HrefValue = "";
            $this->tipoent->TooltipValue = "";

            // tipoiva
            $this->tipoiva->HrefValue = "";
            $this->tipoiva->TooltipValue = "";

            // cuit
            $this->cuit->HrefValue = "";
            $this->cuit->TooltipValue = "";

            // calif
            $this->calif->HrefValue = "";
            $this->calif->TooltipValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";
            $this->fecalta->TooltipValue = "";

            // usuario
            $this->usuario->HrefValue = "";
            $this->usuario->TooltipValue = "";

            // contacto
            $this->contacto->HrefValue = "";
            $this->contacto->TooltipValue = "";

            // mailcont
            $this->mailcont->HrefValue = "";
            $this->mailcont->TooltipValue = "";

            // cargo
            $this->cargo->HrefValue = "";
            $this->cargo->TooltipValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";
            $this->fechahora->TooltipValue = "";

            // activo
            $this->activo->HrefValue = "";
            $this->activo->TooltipValue = "";

            // pagweb
            $this->pagweb->HrefValue = "";
            $this->pagweb->TooltipValue = "";

            // tipoind
            $this->tipoind->HrefValue = "";
            $this->tipoind->TooltipValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";
            $this->usuarioultmod->TooltipValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";
            $this->fecultmod->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->codnum->AdvancedSearch->load();
        $this->razsoc->AdvancedSearch->load();
        $this->calle->AdvancedSearch->load();
        $this->numero->AdvancedSearch->load();
        $this->pisodto->AdvancedSearch->load();
        $this->codpais->AdvancedSearch->load();
        $this->codprov->AdvancedSearch->load();
        $this->codloc->AdvancedSearch->load();
        $this->codpost->AdvancedSearch->load();
        $this->tellinea->AdvancedSearch->load();
        $this->telcelu->AdvancedSearch->load();
        $this->tipoent->AdvancedSearch->load();
        $this->tipoiva->AdvancedSearch->load();
        $this->cuit->AdvancedSearch->load();
        $this->fecalta->AdvancedSearch->load();
        $this->usuario->AdvancedSearch->load();
        $this->contacto->AdvancedSearch->load();
        $this->mailcont->AdvancedSearch->load();
        $this->cargo->AdvancedSearch->load();
        $this->fechahora->AdvancedSearch->load();
        $this->activo->AdvancedSearch->load();
        $this->pagweb->AdvancedSearch->load();
        $this->tipoind->AdvancedSearch->load();
        $this->usuarioultmod->AdvancedSearch->load();
        $this->fecultmod->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        if ($type == "print" || $custom) { // Printer friendly / custom export
            $pageUrl = $this->pageUrl(false);
            $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        } else { // Export API URL
            $exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
        }
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fentidadeslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fentidadeslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fentidadeslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\">" . $Language->phrase("ExportToPdf") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ' data-url="' . $exportUrl . '"' : '';
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fentidadeslist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language, $Security;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = true;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = false;

        // Export to XML
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to CSV
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = true;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = true;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : "";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fentidadessrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Query builder button
        $item = &$this->SearchOptions->add("querybuilder");
        if ($this->ModalSearch && !IsMobile()) {
            $item->Body = "<a class=\"btn btn-default ew-query-builder\" title=\"" . $Language->phrase("QueryBuilder", true) . "\" data-table=\"entidades\" data-caption=\"" . $Language->phrase("QueryBuilder", true) . "\" data-ew-action=\"modal\" data-url=\"EntidadesQuery\" data-btn=\"SearchBtn\">" . $Language->phrase("QueryBuilder", false) . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-query-builder\" title=\"" . $Language->phrase("QueryBuilder", true) . "\" data-caption=\"" . $Language->phrase("QueryBuilder", true) . "\" href=\"EntidadesQuery\">" . $Language->phrase("QueryBuilder", false) . "</a>";
        }
        $item->Visible = true;

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction && $this->CurrentAction != "search") {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return true;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($doc)
    {
        global $Language;
        $rs = null;
        $this->TotalRecords = $this->listRecordCount();

        // Export all
        if ($this->ExportAll) {
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $doc->ExportCustom = !$this->pageExporting($doc);

        // Page header
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
        $rs->free();

        // Page footer
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Call Page Exported server event
        $this->pageExported($doc);
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset(all)
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = ConvertToBool(Param("infinitescroll"));
        if ($pageNo !== null) { // Check for "pageno" parameter first
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                if ($this->StartRecord <= 0) {
                    $this->StartRecord = 1;
                } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                    $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                }
            }
        } elseif ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
            $this->StartRecord = $startRec;
        } elseif (!$infiniteScroll) {
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

    // Parse query builder rule
    protected function parseRules($group, $fieldName = "", $itemName = "") {
        $group["condition"] ??= "AND";
        if (!in_array($group["condition"], ["AND", "OR"])) {
            throw new \Exception("Unable to build SQL query with condition '" . $group["condition"] . "'");
        }
        if (!is_array($group["rules"] ?? null)) {
            return "";
        }
        $parts = [];
        foreach ($group["rules"] as $rule) {
            if (is_array($rule["rules"] ?? null) && count($rule["rules"]) > 0) {
                $part = $this->parseRules($rule, $fieldName, $itemName);
                if ($part) {
                    $parts[] = "(" . " " . $part . " " . ")" . " ";
                }
            } else {
                $field = $rule["field"];
                $fld = $this->fieldByParam($field);
                $dbid = $this->Dbid;
                if ($fld instanceof ReportField && is_array($fld->DashboardSearchSourceFields)) {
                    $item = $fld->DashboardSearchSourceFields[$itemName] ?? null;
                    if ($item) {
                        $tbl = Container($item["table"]);
                        $dbid = $tbl->Dbid;
                        $fld = $tbl->Fields[$item["field"]];
                    } else {
                        $fld = null;
                    }
                }
                if ($fld && ($fieldName == "" || $fld->Name == $fieldName)) { // Field name not specified or matched field name
                    $fldOpr = array_search($rule["operator"], Config("CLIENT_SEARCH_OPERATORS"));
                    $ope = Config("QUERY_BUILDER_OPERATORS")[$rule["operator"]] ?? null;
                    if (!$ope || !$fldOpr) {
                        throw new \Exception("Unknown SQL operation for operator '" . $rule["operator"] . "'");
                    }
                    if ($ope["nb_inputs"] > 0 && isset($rule["value"]) && !EmptyValue($rule["value"]) || IsNullOrEmptyOperator($fldOpr)) {
                        $fldVal = $rule["value"];
                        if (is_array($fldVal)) {
                            $fldVal = $fld->isMultiSelect() ? implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal) : $fldVal[0];
                        }
                        $useFilter = $fld->UseFilter; // Query builder does not use filter
                        try {
                            if ($fld instanceof ReportField) { // Search report fields
                                if ($fld->SearchType == "dropdown") {
                                    if (is_array($fldVal)) {
                                        $sql = "";
                                        foreach ($fldVal as $val) {
                                            AddFilter($sql, DropDownFilter($fld, $val, $fldOpr, $dbid), "OR");
                                        }
                                        $parts[] = $sql;
                                    } else {
                                        $parts[] = DropDownFilter($fld, $fldVal, $fldOpr, $dbid);
                                    }
                                } else {
                                    $fld->AdvancedSearch->SearchOperator = $fldOpr;
                                    $fld->AdvancedSearch->SearchValue = $fldVal;
                                    $parts[] = GetReportFilter($fld, false, $dbid);
                                }
                            } else { // Search normal fields
                                if ($fld->isMultiSelect()) {
                                    $parts[] = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, ConvertSearchValue($fldVal, $fldOpr, $fld), $this->Dbid) : "";
                                } else {
                                    $fldVal2 = ContainsString($fldOpr, "BETWEEN") ? $rule["value"][1] : ""; // BETWEEN
                                    if (is_array($fldVal2)) {
                                        $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
                                    }
                                    $fld->AdvancedSearch->SearchValue = ConvertSearchValue($fldVal, $fldOpr, $fld);
                                    $fld->AdvancedSearch->SearchValue2 = ConvertSearchValue($fldVal2, $fldOpr, $fld);
                                    $parts[] = GetSearchSql(
                                        $fld,
                                        $fld->AdvancedSearch->SearchValue, // SearchValue
                                        $fldOpr,
                                        "", // $fldCond not used
                                        $fld->AdvancedSearch->SearchValue2, // SearchValue2
                                        "", // $fldOpr2 not used
                                        $this->Dbid
                                    );
                                }
                            }
                        } finally {
                            $fld->UseFilter = $useFilter;
                        }
                    }
                }
            }
        }
        $where = "";
        foreach ($parts as $part) {
            AddFilter($where, $part, $group["condition"]);
        }
        if ($where && ($group["not"] ?? false)) {
            $where = "NOT (" . $where . ")";
        }
        return $where;
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->moveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $doc = export object
    public function pageExporting(&$doc)
    {
        //$doc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $doc = export document object
    public function rowExport($doc, $rs)
    {
        //$doc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $doc = export document object
    public function pageExported($doc)
    {
        //$doc->Text .= "my footer"; // Export footer
        //Log($doc->Text);
    }

    // Page Importing event
    public function pageImporting(&$builder, &$options)
    {
        //var_dump($options); // Show all options for importing
        //$builder = fn($workflow) => $workflow->addStep($myStep);
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($obj, $results)
    {
        //var_dump($obj); // Workflow result object
        //var_dump($results); // Import results
    }
}
