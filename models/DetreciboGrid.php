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
class DetreciboGrid extends Detrecibo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "DetreciboGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fdetrecibogrid";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "DetreciboGrid";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

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
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'detrecibo';
        $this->TableName = 'detrecibo';

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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (detrecibo)
        if (!isset($GLOBALS["detrecibo"]) || $GLOBALS["detrecibo"]::class == PROJECT_NAMESPACE . "detrecibo") {
            $GLOBALS["detrecibo"] = &$this;
        }
        $this->AddUrl = "DetreciboAdd";

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

        // List options
        $this->ListOptions = new ListOptions(Tag: "td", TableVar: $this->TableVar);

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $Language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );
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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
    public $ShowOtherOptions = false;
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

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
        if (Param("export") !== null) {
            $this->Export = Param("export");
        }

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
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

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fdetrecibogrid";
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

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

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

        // Hide other options
        if ($this->isExport()) {
            $this->OtherOptions->hideAllOptions();
        }

        // Show grid delete link for grid add / grid edit
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $item = $this->ListOptions["griddelete"];
                if ($item) {
                    $item->Visible = $Security->allowDelete(CurrentProjectID() . $this->TableName);
                }
            }
        }

        // Set up sorting order
        $this->setupSortOrder();

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Build filter
        if (!$Security->canList()) {
            $this->Filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "cabrecibo") {
            $masterTbl = Container("cabrecibo");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("CabreciboList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = RowType::MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

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
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
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
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
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

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->netocbterel->FormValue = ""; // Clear form value
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to grid add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to grid edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old result set
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
        $this->loadDefaultValues();
        $wrkfilter = "";
        $key = "";

        // Update row index and get row key
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete" && $rowaction != "hide") { // Skip insert then deleted rows / hidden rows for grid edit
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                        if ($gridUpdate) { // Get inserted or updated filter
                            AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                        }
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($gridUpdate) {
            $this->FilterForModalActions = $wrkfilter;

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
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

    // Perform grid add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
        $this->loadDefaultValues();

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            $rsold = null;
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $rsold = $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success
                $gridInsert = $this->addRow($rsold); // Insert row (already validated by validateGridForm())
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->codnum->CurrentValue;

                    // Add filter for this record
                    AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $this->FilterForModalActions = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if (
            $CurrentForm->hasValue("x_tcomp") &&
            $CurrentForm->hasValue("o_tcomp") &&
            $this->tcomp->CurrentValue != $this->tcomp->DefaultValue &&
            !($this->tcomp->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->tcomp->CurrentValue == $this->tcomp->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_serie") &&
            $CurrentForm->hasValue("o_serie") &&
            $this->serie->CurrentValue != $this->serie->DefaultValue &&
            !($this->serie->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->serie->CurrentValue == $this->serie->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_ncomp") &&
            $CurrentForm->hasValue("o_ncomp") &&
            $this->ncomp->CurrentValue != $this->ncomp->DefaultValue &&
            !($this->ncomp->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->ncomp->CurrentValue == $this->ncomp->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_nreng") &&
            $CurrentForm->hasValue("o_nreng") &&
            $this->nreng->CurrentValue != $this->nreng->DefaultValue &&
            !($this->nreng->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->nreng->CurrentValue == $this->nreng->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_tcomprel") &&
            $CurrentForm->hasValue("o_tcomprel") &&
            $this->tcomprel->CurrentValue != $this->tcomprel->DefaultValue &&
            !($this->tcomprel->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->tcomprel->CurrentValue == $this->tcomprel->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_serierel") &&
            $CurrentForm->hasValue("o_serierel") &&
            $this->serierel->CurrentValue != $this->serierel->DefaultValue &&
            !($this->serierel->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->serierel->CurrentValue == $this->serierel->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_ncomprel") &&
            $CurrentForm->hasValue("o_ncomprel") &&
            $this->ncomprel->CurrentValue != $this->ncomprel->DefaultValue &&
            !($this->ncomprel->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->ncomprel->CurrentValue == $this->ncomprel->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_netocbterel") &&
            $CurrentForm->hasValue("o_netocbterel") &&
            $this->netocbterel->CurrentValue != $this->netocbterel->DefaultValue &&
            !($this->netocbterel->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->netocbterel->CurrentValue == $this->netocbterel->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_usuario") &&
            $CurrentForm->hasValue("o_usuario") &&
            $this->usuario->CurrentValue != $this->usuario->DefaultValue &&
            !($this->usuario->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->usuario->CurrentValue == $this->usuario->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_fechahora") &&
            $CurrentForm->hasValue("o_fechahora") &&
            $this->fechahora->CurrentValue != $this->fechahora->DefaultValue &&
            !($this->fechahora->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->fechahora->CurrentValue == $this->fechahora->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_nrodoc") &&
            $CurrentForm->hasValue("o_nrodoc") &&
            $this->nrodoc->CurrentValue != $this->nrodoc->DefaultValue &&
            !($this->nrodoc->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->nrodoc->CurrentValue == $this->nrodoc->getSessionValue())
        ) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;

        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Load default values for emptyRow checking
        $this->loadDefaultValues();

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete" && $rowaction != "hide") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->ValidationErrors[$rowindex] = $this->getValidationErrors();
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        foreach ($this->Fields as $field) {
            $field->clearErrorMessage();
        }
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
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
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
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->tcomp->setSessionValue("");
                        $this->serie->setSessionValue("");
                        $this->ncomp->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
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

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

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

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->allowDelete(CurrentProjectID() . $this->TableName) && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"detrecibo\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"detrecibo\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"detrecibo\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
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
        $option = $this->OtherOptions["addedit"];
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            if ($this->ModalAdd && !IsMobile()) {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"detrecibo\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
            } else {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            }
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
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
            if (in_array($this->CurrentMode, ["add", "copy", "edit"]) && !$this->isConfirm()) { // Check add/copy/edit mode
                if ($this->AllowAddDeleteRow) {
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                    $this->ShowOtherOptions = $item->Visible;
                }
            }
            if ($this->CurrentMode == "view") { // Check view mode
                $option = $options["addedit"];
                $item = $option["add"];
                $this->ShowOtherOptions = $item?->Visible ?? false;
            }
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        $this->StartRecord = 1;
        $this->StopRecord = $this->TotalRecords; // Show all records

        // Restore number of post back records
        if ($CurrentForm && ($this->isConfirm() || $this->EventCancelled)) {
            $CurrentForm->resetIndex();
            if ($CurrentForm->hasValue($this->FormKeyCountName) && ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm())) {
                $this->KeyCount = $CurrentForm->getValue($this->FormKeyCountName);
                $this->StopRecord = $this->StartRecord + $this->KeyCount - 1;
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_detrecibo", "data-rowtype" => RowType::ADD]);
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
        if ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm() || $this->isMultiEdit()) {
            $this->RowIndex++;
            $CurrentForm->Index = $this->RowIndex;
            if ($CurrentForm->hasValue($this->FormActionName) && ($this->isConfirm() || $this->EventCancelled)) {
                $this->RowAction = strval($CurrentForm->getValue($this->FormActionName));
            } elseif ($this->isGridAdd()) {
                $this->RowAction = "insert";
            } else {
                $this->RowAction = "";
            }
        }

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->loadRowValues($this->CurrentRow); // Load row values
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
            } else {
                $this->loadRowValues(); // Load default values
                $this->OldKey = "";
            }
        } else {
            $this->loadRowValues($this->CurrentRow); // Load row values
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
        }
        $this->setKey($this->OldKey);
        $this->RowType = RowType::VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = RowType::ADD; // Render add
        }
        if ($this->isGridAdd() && $this->EventCancelled && !$CurrentForm->hasValue($this->FormBlankRowName)) { // Insert failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isGridEdit()) { // Grid edit
            if ($this->EventCancelled) {
                $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
            }
            if ($this->RowAction == "insert") {
                $this->RowType = RowType::ADD; // Render add
            } else {
                $this->RowType = RowType::EDIT; // Render edit
            }
        }
        if ($this->isGridEdit() && ($this->RowType == RowType::EDIT || $this->RowType == RowType::ADD) && $this->EventCancelled) { // Update failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isConfirm()) { // Confirm row
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
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
            "id" => "r" . $this->RowCount . "_detrecibo",
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
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'codnum' first before field var 'x_codnum'
        $val = $CurrentForm->hasValue("codnum") ? $CurrentForm->getValue("codnum") : $CurrentForm->getValue("x_codnum");
        if (!$this->codnum->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
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
        if ($CurrentForm->hasValue("o_tcomp")) {
            $this->tcomp->setOldValue($CurrentForm->getValue("o_tcomp"));
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
        if ($CurrentForm->hasValue("o_serie")) {
            $this->serie->setOldValue($CurrentForm->getValue("o_serie"));
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
        if ($CurrentForm->hasValue("o_ncomp")) {
            $this->ncomp->setOldValue($CurrentForm->getValue("o_ncomp"));
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
        if ($CurrentForm->hasValue("o_nreng")) {
            $this->nreng->setOldValue($CurrentForm->getValue("o_nreng"));
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
        if ($CurrentForm->hasValue("o_tcomprel")) {
            $this->tcomprel->setOldValue($CurrentForm->getValue("o_tcomprel"));
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
        if ($CurrentForm->hasValue("o_serierel")) {
            $this->serierel->setOldValue($CurrentForm->getValue("o_serierel"));
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
        if ($CurrentForm->hasValue("o_ncomprel")) {
            $this->ncomprel->setOldValue($CurrentForm->getValue("o_ncomprel"));
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
        if ($CurrentForm->hasValue("o_netocbterel")) {
            $this->netocbterel->setOldValue($CurrentForm->getValue("o_netocbterel"));
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
        if ($CurrentForm->hasValue("o_usuario")) {
            $this->usuario->setOldValue($CurrentForm->getValue("o_usuario"));
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
        if ($CurrentForm->hasValue("o_fechahora")) {
            $this->fechahora->setOldValue($CurrentForm->getValue("o_fechahora"));
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
        if ($CurrentForm->hasValue("o_nrodoc")) {
            $this->nrodoc->setOldValue($CurrentForm->getValue("o_nrodoc"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->codnum->CurrentValue = $this->codnum->FormValue;
        }
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // codnum

        // tcomp

        // serie

        // ncomp

        // nreng

        // tcomprel

        // serierel

        // ncomprel

        // netocbterel

        // usuario

        // fechahora

        // nrodoc

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

            // codnum
            $this->codnum->HrefValue = "";
            $this->codnum->TooltipValue = "";

            // tcomp
            $this->tcomp->HrefValue = "";
            $this->tcomp->TooltipValue = "";

            // serie
            $this->serie->HrefValue = "";
            $this->serie->TooltipValue = "";

            // ncomp
            $this->ncomp->HrefValue = "";
            $this->ncomp->TooltipValue = "";

            // nreng
            $this->nreng->HrefValue = "";
            $this->nreng->TooltipValue = "";

            // tcomprel
            $this->tcomprel->HrefValue = "";
            $this->tcomprel->TooltipValue = "";

            // serierel
            $this->serierel->HrefValue = "";
            $this->serierel->TooltipValue = "";

            // ncomprel
            $this->ncomprel->HrefValue = "";
            $this->ncomprel->TooltipValue = "";

            // netocbterel
            $this->netocbterel->HrefValue = "";
            $this->netocbterel->TooltipValue = "";

            // usuario
            $this->usuario->HrefValue = "";
            $this->usuario->TooltipValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";
            $this->fechahora->TooltipValue = "";

            // nrodoc
            $this->nrodoc->HrefValue = "";
            $this->nrodoc->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // codnum

            // tcomp
            $this->tcomp->setupEditAttributes();
            if ($this->tcomp->getSessionValue() != "") {
                $this->tcomp->CurrentValue = GetForeignKeyValue($this->tcomp->getSessionValue());
                $this->tcomp->OldValue = $this->tcomp->CurrentValue;
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
                $this->serie->OldValue = $this->serie->CurrentValue;
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
                $this->ncomp->OldValue = $this->ncomp->CurrentValue;
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
        } elseif ($this->RowType == RowType::EDIT) {
            // codnum
            $this->codnum->setupEditAttributes();
            $this->codnum->EditValue = $this->codnum->CurrentValue;

            // tcomp
            $this->tcomp->setupEditAttributes();
            if ($this->tcomp->getSessionValue() != "") {
                $this->tcomp->CurrentValue = GetForeignKeyValue($this->tcomp->getSessionValue());
                $this->tcomp->OldValue = $this->tcomp->CurrentValue;
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
                $this->serie->OldValue = $this->serie->CurrentValue;
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
                $this->ncomp->OldValue = $this->ncomp->CurrentValue;
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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['codnum'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        return $deleteRows;
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

        // Check referential integrity for master table 'cabrecibo'
        $detailKeys = [];
        $keyValue = $rsnew['tcomp'] ?? $rsold['tcomp'];
        $detailKeys['tcomp'] = $keyValue;
        $keyValue = $rsnew['serie'] ?? $rsold['serie'];
        $detailKeys['serie'] = $keyValue;
        $keyValue = $rsnew['ncomp'] ?? $rsold['ncomp'];
        $detailKeys['ncomp'] = $keyValue;
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

        // tcomprel
        $this->tcomprel->setDbValueDef($rsnew, $this->tcomprel->CurrentValue, $this->tcomprel->ReadOnly);

        // serierel
        $this->serierel->setDbValueDef($rsnew, $this->serierel->CurrentValue, $this->serierel->ReadOnly);

        // ncomprel
        $this->ncomprel->setDbValueDef($rsnew, $this->ncomprel->CurrentValue, $this->ncomprel->ReadOnly);

        // netocbterel
        $this->netocbterel->setDbValueDef($rsnew, $this->netocbterel->CurrentValue, $this->netocbterel->ReadOnly);

        // usuario
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue, $this->usuario->ReadOnly);

        // fechahora
        $this->fechahora->setDbValueDef($rsnew, UnFormatDateTime($this->fechahora->CurrentValue, $this->fechahora->formatPattern()), $this->fechahora->ReadOnly);

        // nrodoc
        $this->nrodoc->setDbValueDef($rsnew, $this->nrodoc->CurrentValue, $this->nrodoc->ReadOnly);
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
        if (isset($row['tcomprel'])) { // tcomprel
            $this->tcomprel->CurrentValue = $row['tcomprel'];
        }
        if (isset($row['serierel'])) { // serierel
            $this->serierel->CurrentValue = $row['serierel'];
        }
        if (isset($row['ncomprel'])) { // ncomprel
            $this->ncomprel->CurrentValue = $row['ncomprel'];
        }
        if (isset($row['netocbterel'])) { // netocbterel
            $this->netocbterel->CurrentValue = $row['netocbterel'];
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->CurrentValue = $row['usuario'];
        }
        if (isset($row['fechahora'])) { // fechahora
            $this->fechahora->CurrentValue = $row['fechahora'];
        }
        if (isset($row['nrodoc'])) { // nrodoc
            $this->nrodoc->CurrentValue = $row['nrodoc'];
        }
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "cabrecibo") {
            $this->tcomp->Visible = true; // Need to insert foreign key
            $this->tcomp->CurrentValue = $this->tcomp->getSessionValue();
            $this->serie->Visible = true; // Need to insert foreign key
            $this->serie->CurrentValue = $this->serie->getSessionValue();
            $this->ncomp->Visible = true; // Need to insert foreign key
            $this->ncomp->CurrentValue = $this->ncomp->getSessionValue();
        }

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
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "cabrecibo") {
            $masterTbl = Container("cabrecibo");
            $this->tcomp->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
            $this->serie->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
            $this->ncomp->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
}
