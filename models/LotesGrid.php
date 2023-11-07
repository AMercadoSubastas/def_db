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
class LotesGrid extends Lotes
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "LotesGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "flotesgrid";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "LotesGrid";

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
        $this->descripcion->Visible = false;
        $this->descor->setVisibility();
        $this->observ->setVisibility();
        $this->usuario->setVisibility();
        $this->fecalta->setVisibility();
        $this->secuencia->setVisibility();
        $this->codintlote->setVisibility();
        $this->codintnum->setVisibility();
        $this->codintsublote->setVisibility();
        $this->dir_secuencia->setVisibility();
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
        $this->TableVar = 'lotes';
        $this->TableName = 'lotes';

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

        // Table object (lotes)
        if (!isset($GLOBALS["lotes"]) || $GLOBALS["lotes"]::class == PROJECT_NAMESPACE . "lotes") {
            $GLOBALS["lotes"] = &$this;
        }
        $this->AddUrl = "LotesAdd";

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
        if ($this->isAddOrEdit()) {
            $this->usuario->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->fecalta->Visible = false;
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
    public $ShowOtherOptions = false;
    public $DisplayRecords = 600;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,600,-1"; // Page sizes (comma separated)
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
    public $MultiColumnCardClass = "card h-100 ew-card";
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

        // Set up lookup cache
        $this->setupLookupOptions($this->codrem);
        $this->setupLookupOptions($this->estado);
        $this->setupLookupOptions($this->dir_secuencia);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "flotesgrid";
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
            $this->DisplayRecords = 600; // Load default
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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "remates") {
            $masterTbl = Container("remates");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("RematesList"); // Return to master page
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
                    $this->DisplayRecords = 600; // Non-numeric, load default
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
        $this->preciofinal->FormValue = ""; // Clear form value
        $this->comiscobr->FormValue = ""; // Clear form value
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
        if ($CurrentForm->hasValue("x_codrem") && $CurrentForm->hasValue("o_codrem") && $this->codrem->CurrentValue != $this->codrem->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_codcli") && $CurrentForm->hasValue("o_codcli") && $this->codcli->CurrentValue != $this->codcli->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_codrubro") && $CurrentForm->hasValue("o_codrubro") && $this->codrubro->CurrentValue != $this->codrubro->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_estado") && $CurrentForm->hasValue("o_estado") && $this->estado->CurrentValue != $this->estado->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_moneda") && $CurrentForm->hasValue("o_moneda") && $this->moneda->CurrentValue != $this->moneda->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_preciobase") && $CurrentForm->hasValue("o_preciobase") && $this->preciobase->CurrentValue != $this->preciobase->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_preciofinal") && $CurrentForm->hasValue("o_preciofinal") && $this->preciofinal->CurrentValue != $this->preciofinal->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_comiscobr") && $CurrentForm->hasValue("o_comiscobr") && $this->comiscobr->CurrentValue != $this->comiscobr->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_comispag") && $CurrentForm->hasValue("o_comispag") && $this->comispag->CurrentValue != $this->comispag->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_comprador") && $CurrentForm->hasValue("o_comprador") && $this->comprador->CurrentValue != $this->comprador->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_ivari") && $CurrentForm->hasValue("o_ivari") && $this->ivari->CurrentValue != $this->ivari->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_ivarni") && $CurrentForm->hasValue("o_ivarni") && $this->ivarni->CurrentValue != $this->ivarni->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_codimpadic") && $CurrentForm->hasValue("o_codimpadic") && $this->codimpadic->CurrentValue != $this->codimpadic->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_impadic") && $CurrentForm->hasValue("o_impadic") && $this->impadic->CurrentValue != $this->impadic->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_descor") && $CurrentForm->hasValue("o_descor") && $this->descor->CurrentValue != $this->descor->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_observ") && $CurrentForm->hasValue("o_observ") && $this->observ->CurrentValue != $this->observ->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_secuencia") && $CurrentForm->hasValue("o_secuencia") && $this->secuencia->CurrentValue != $this->secuencia->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_codintlote") && $CurrentForm->hasValue("o_codintlote") && $this->codintlote->CurrentValue != $this->codintlote->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_codintnum") && $CurrentForm->hasValue("o_codintnum") && $this->codintnum->CurrentValue != $this->codintnum->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_codintsublote") && $CurrentForm->hasValue("o_codintsublote") && $this->codintsublote->CurrentValue != $this->codintsublote->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_dir_secuencia") && $CurrentForm->hasValue("o_dir_secuencia") && $this->dir_secuencia->CurrentValue != $this->dir_secuencia->DefaultValue) {
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
                        $this->codrem->setSessionValue("");
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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"lotes\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"lotes\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
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
                    $item->Visible = false;
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_lotes", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_lotes",
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
        $this->estado->DefaultValue = $this->estado->getDefault(); // PHP
        $this->estado->OldValue = $this->estado->DefaultValue;
        $this->moneda->DefaultValue = $this->moneda->getDefault(); // PHP
        $this->moneda->OldValue = $this->moneda->DefaultValue;
        $this->preciobase->DefaultValue = $this->preciobase->getDefault(); // PHP
        $this->preciobase->OldValue = $this->preciobase->DefaultValue;
        $this->preciofinal->DefaultValue = $this->preciofinal->getDefault(); // PHP
        $this->preciofinal->OldValue = $this->preciofinal->DefaultValue;
        $this->comiscobr->DefaultValue = $this->comiscobr->getDefault(); // PHP
        $this->comiscobr->OldValue = $this->comiscobr->DefaultValue;
        $this->comispag->DefaultValue = $this->comispag->getDefault(); // PHP
        $this->comispag->OldValue = $this->comispag->DefaultValue;
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

        // Check field name 'codrem' first before field var 'x_codrem'
        $val = $CurrentForm->hasValue("codrem") ? $CurrentForm->getValue("codrem") : $CurrentForm->getValue("x_codrem");
        if (!$this->codrem->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->codrem->Visible = false; // Disable update for API request
            } else {
                $this->codrem->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_codrem")) {
            $this->codrem->setOldValue($CurrentForm->getValue("o_codrem"));
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
        if ($CurrentForm->hasValue("o_codcli")) {
            $this->codcli->setOldValue($CurrentForm->getValue("o_codcli"));
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
        if ($CurrentForm->hasValue("o_codrubro")) {
            $this->codrubro->setOldValue($CurrentForm->getValue("o_codrubro"));
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
        if ($CurrentForm->hasValue("o_estado")) {
            $this->estado->setOldValue($CurrentForm->getValue("o_estado"));
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
        if ($CurrentForm->hasValue("o_moneda")) {
            $this->moneda->setOldValue($CurrentForm->getValue("o_moneda"));
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
        if ($CurrentForm->hasValue("o_preciobase")) {
            $this->preciobase->setOldValue($CurrentForm->getValue("o_preciobase"));
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
        if ($CurrentForm->hasValue("o_preciofinal")) {
            $this->preciofinal->setOldValue($CurrentForm->getValue("o_preciofinal"));
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
        if ($CurrentForm->hasValue("o_comiscobr")) {
            $this->comiscobr->setOldValue($CurrentForm->getValue("o_comiscobr"));
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
        if ($CurrentForm->hasValue("o_comispag")) {
            $this->comispag->setOldValue($CurrentForm->getValue("o_comispag"));
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
        if ($CurrentForm->hasValue("o_comprador")) {
            $this->comprador->setOldValue($CurrentForm->getValue("o_comprador"));
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
        if ($CurrentForm->hasValue("o_ivari")) {
            $this->ivari->setOldValue($CurrentForm->getValue("o_ivari"));
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
        if ($CurrentForm->hasValue("o_ivarni")) {
            $this->ivarni->setOldValue($CurrentForm->getValue("o_ivarni"));
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
        if ($CurrentForm->hasValue("o_codimpadic")) {
            $this->codimpadic->setOldValue($CurrentForm->getValue("o_codimpadic"));
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
        if ($CurrentForm->hasValue("o_impadic")) {
            $this->impadic->setOldValue($CurrentForm->getValue("o_impadic"));
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
        if ($CurrentForm->hasValue("o_descor")) {
            $this->descor->setOldValue($CurrentForm->getValue("o_descor"));
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
        if ($CurrentForm->hasValue("o_observ")) {
            $this->observ->setOldValue($CurrentForm->getValue("o_observ"));
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
        if ($CurrentForm->hasValue("o_usuario")) {
            $this->usuario->setOldValue($CurrentForm->getValue("o_usuario"));
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
        if ($CurrentForm->hasValue("o_fecalta")) {
            $this->fecalta->setOldValue($CurrentForm->getValue("o_fecalta"));
        }

        // Check field name 'secuencia' first before field var 'x_secuencia'
        $val = $CurrentForm->hasValue("secuencia") ? $CurrentForm->getValue("secuencia") : $CurrentForm->getValue("x_secuencia");
        if (!$this->secuencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->secuencia->Visible = false; // Disable update for API request
            } else {
                $this->secuencia->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_secuencia")) {
            $this->secuencia->setOldValue($CurrentForm->getValue("o_secuencia"));
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
        if ($CurrentForm->hasValue("o_codintlote")) {
            $this->codintlote->setOldValue($CurrentForm->getValue("o_codintlote"));
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
        if ($CurrentForm->hasValue("o_codintnum")) {
            $this->codintnum->setOldValue($CurrentForm->getValue("o_codintnum"));
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
        if ($CurrentForm->hasValue("o_codintsublote")) {
            $this->codintsublote->setOldValue($CurrentForm->getValue("o_codintsublote"));
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
        if ($CurrentForm->hasValue("o_dir_secuencia")) {
            $this->dir_secuencia->setOldValue($CurrentForm->getValue("o_dir_secuencia"));
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
        if ($CurrentForm->hasValue("o_usuarioultmod")) {
            $this->usuarioultmod->setOldValue($CurrentForm->getValue("o_usuarioultmod"));
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
        if ($CurrentForm->hasValue("o_fecultmod")) {
            $this->fecultmod->setOldValue($CurrentForm->getValue("o_fecultmod"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->codnum->CurrentValue = $this->codnum->FormValue;
        }
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
        $this->descor->CurrentValue = $this->descor->FormValue;
        $this->observ->CurrentValue = $this->observ->FormValue;
        $this->usuario->CurrentValue = $this->usuario->FormValue;
        $this->fecalta->CurrentValue = $this->fecalta->FormValue;
        $this->fecalta->CurrentValue = UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern());
        $this->secuencia->CurrentValue = $this->secuencia->FormValue;
        $this->codintlote->CurrentValue = $this->codintlote->FormValue;
        $this->codintnum->CurrentValue = $this->codintnum->FormValue;
        $this->codintsublote->CurrentValue = $this->codintsublote->FormValue;
        $this->dir_secuencia->CurrentValue = $this->dir_secuencia->FormValue;
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->FormValue;
        $this->fecultmod->CurrentValue = $this->fecultmod->FormValue;
        $this->fecultmod->CurrentValue = UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern());
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
        $this->dir_secuencia->setDbValue($row['dir_secuencia']);
        $this->usuarioultmod->setDbValue($row['usuarioultmod']);
        $this->fecultmod->setDbValue($row['fecultmod']);
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
        $row['dir_secuencia'] = $this->dir_secuencia->DefaultValue;
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
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // codnum

        // codrem

        // codcli

        // codrubro

        // estado

        // moneda

        // preciobase

        // preciofinal

        // comiscobr

        // comispag

        // comprador

        // ivari

        // ivarni

        // codimpadic

        // impadic

        // descripcion

        // descor

        // observ

        // usuario

        // fecalta

        // secuencia

        // codintlote

        // codintnum

        // codintsublote

        // dir_secuencia

        // usuarioultmod

        // fecultmod

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

            // dir_secuencia
            $curVal = strval($this->dir_secuencia->CurrentValue);
            if ($curVal != "") {
                $this->dir_secuencia->ViewValue = $this->dir_secuencia->lookupCacheOption($curVal);
                if ($this->dir_secuencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->dir_secuencia->Lookup->getTable()->Fields["secuencia"]->searchExpression(), "=", $curVal, $this->dir_secuencia->Lookup->getTable()->Fields["secuencia"]->searchDataType(), "");
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

            // usuarioultmod
            $this->usuarioultmod->ViewValue = $this->usuarioultmod->CurrentValue;
            $this->usuarioultmod->ViewValue = FormatNumber($this->usuarioultmod->ViewValue, $this->usuarioultmod->formatPattern());

            // fecultmod
            $this->fecultmod->ViewValue = $this->fecultmod->CurrentValue;
            $this->fecultmod->ViewValue = FormatDateTime($this->fecultmod->ViewValue, $this->fecultmod->formatPattern());

            // codnum
            $this->codnum->HrefValue = "";
            $this->codnum->TooltipValue = "";

            // codrem
            $this->codrem->HrefValue = "";
            $this->codrem->TooltipValue = "";

            // codcli
            $this->codcli->HrefValue = "";
            $this->codcli->TooltipValue = "";

            // codrubro
            $this->codrubro->HrefValue = "";
            $this->codrubro->TooltipValue = "";

            // estado
            $this->estado->HrefValue = "";
            $this->estado->TooltipValue = "";

            // moneda
            $this->moneda->HrefValue = "";
            $this->moneda->TooltipValue = "";

            // preciobase
            $this->preciobase->HrefValue = "";
            $this->preciobase->TooltipValue = "";

            // preciofinal
            $this->preciofinal->HrefValue = "";
            $this->preciofinal->TooltipValue = "";

            // comiscobr
            $this->comiscobr->HrefValue = "";
            $this->comiscobr->TooltipValue = "";

            // comispag
            $this->comispag->HrefValue = "";
            $this->comispag->TooltipValue = "";

            // comprador
            $this->comprador->HrefValue = "";
            $this->comprador->TooltipValue = "";

            // ivari
            $this->ivari->HrefValue = "";
            $this->ivari->TooltipValue = "";

            // ivarni
            $this->ivarni->HrefValue = "";
            $this->ivarni->TooltipValue = "";

            // codimpadic
            $this->codimpadic->HrefValue = "";
            $this->codimpadic->TooltipValue = "";

            // impadic
            $this->impadic->HrefValue = "";
            $this->impadic->TooltipValue = "";

            // descor
            $this->descor->HrefValue = "";
            $this->descor->TooltipValue = "";

            // observ
            $this->observ->HrefValue = "";
            $this->observ->TooltipValue = "";

            // usuario
            $this->usuario->HrefValue = "";
            $this->usuario->TooltipValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";
            $this->fecalta->TooltipValue = "";

            // secuencia
            $this->secuencia->HrefValue = "";
            $this->secuencia->TooltipValue = "";

            // codintlote
            $this->codintlote->HrefValue = "";
            $this->codintlote->TooltipValue = "";

            // codintnum
            $this->codintnum->HrefValue = "";
            $this->codintnum->TooltipValue = "";

            // codintsublote
            $this->codintsublote->HrefValue = "";
            $this->codintsublote->TooltipValue = "";

            // dir_secuencia
            $this->dir_secuencia->HrefValue = "";
            $this->dir_secuencia->TooltipValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";
            $this->usuarioultmod->TooltipValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";
            $this->fecultmod->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // codnum

            // codrem
            $this->codrem->setupEditAttributes();
            if ($this->codrem->getSessionValue() != "") {
                $this->codrem->CurrentValue = GetForeignKeyValue($this->codrem->getSessionValue());
                $this->codrem->OldValue = $this->codrem->CurrentValue;
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
            } else {
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
                            $this->codrem->EditValue = HtmlEncode(FormatNumber($this->codrem->CurrentValue, $this->codrem->formatPattern()));
                        }
                    }
                } else {
                    $this->codrem->EditValue = null;
                }
                $this->codrem->PlaceHolder = RemoveHtml($this->codrem->caption());
            }

            // codcli
            $this->codcli->setupEditAttributes();
            $this->codcli->EditValue = $this->codcli->CurrentValue;
            $this->codcli->PlaceHolder = RemoveHtml($this->codcli->caption());
            if (strval($this->codcli->EditValue) != "" && is_numeric($this->codcli->EditValue)) {
                $this->codcli->EditValue = FormatNumber($this->codcli->EditValue, null);
            }

            // codrubro
            $this->codrubro->setupEditAttributes();
            $this->codrubro->EditValue = $this->codrubro->CurrentValue;
            $this->codrubro->PlaceHolder = RemoveHtml($this->codrubro->caption());
            if (strval($this->codrubro->EditValue) != "" && is_numeric($this->codrubro->EditValue)) {
                $this->codrubro->EditValue = FormatNumber($this->codrubro->EditValue, null);
            }

            // estado
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // moneda
            $this->moneda->setupEditAttributes();
            $this->moneda->CurrentValue = FormatNumber($this->moneda->getDefault(), $this->moneda->formatPattern());
            if (strval($this->moneda->EditValue) != "" && is_numeric($this->moneda->EditValue)) {
                $this->moneda->EditValue = FormatNumber($this->moneda->EditValue, null);
            }

            // preciobase
            $this->preciobase->setupEditAttributes();
            $this->preciobase->CurrentValue = FormatNumber($this->preciobase->getDefault(), $this->preciobase->formatPattern());
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
            $this->comispag->CurrentValue = FormatNumber($this->comispag->getDefault(), $this->comispag->formatPattern());
            if (strval($this->comispag->EditValue) != "" && is_numeric($this->comispag->EditValue)) {
                $this->comispag->EditValue = FormatNumber($this->comispag->EditValue, null);
            }

            // comprador
            $this->comprador->setupEditAttributes();
            $this->comprador->EditValue = $this->comprador->CurrentValue;
            $this->comprador->PlaceHolder = RemoveHtml($this->comprador->caption());
            if (strval($this->comprador->EditValue) != "" && is_numeric($this->comprador->EditValue)) {
                $this->comprador->EditValue = FormatNumber($this->comprador->EditValue, null);
            }

            // ivari
            $this->ivari->setupEditAttributes();
            $this->ivari->EditValue = $this->ivari->CurrentValue;
            $this->ivari->PlaceHolder = RemoveHtml($this->ivari->caption());
            if (strval($this->ivari->EditValue) != "" && is_numeric($this->ivari->EditValue)) {
                $this->ivari->EditValue = FormatNumber($this->ivari->EditValue, null);
            }

            // ivarni
            $this->ivarni->setupEditAttributes();
            $this->ivarni->EditValue = $this->ivarni->CurrentValue;
            $this->ivarni->PlaceHolder = RemoveHtml($this->ivarni->caption());
            if (strval($this->ivarni->EditValue) != "" && is_numeric($this->ivarni->EditValue)) {
                $this->ivarni->EditValue = FormatNumber($this->ivarni->EditValue, null);
            }

            // codimpadic
            $this->codimpadic->setupEditAttributes();
            $this->codimpadic->EditValue = $this->codimpadic->CurrentValue;
            $this->codimpadic->PlaceHolder = RemoveHtml($this->codimpadic->caption());
            if (strval($this->codimpadic->EditValue) != "" && is_numeric($this->codimpadic->EditValue)) {
                $this->codimpadic->EditValue = FormatNumber($this->codimpadic->EditValue, null);
            }

            // impadic
            $this->impadic->setupEditAttributes();
            $this->impadic->EditValue = $this->impadic->CurrentValue;
            $this->impadic->PlaceHolder = RemoveHtml($this->impadic->caption());
            if (strval($this->impadic->EditValue) != "" && is_numeric($this->impadic->EditValue)) {
                $this->impadic->EditValue = FormatNumber($this->impadic->EditValue, null);
            }

            // descor
            $this->descor->setupEditAttributes();
            if (!$this->descor->Raw) {
                $this->descor->CurrentValue = HtmlDecode($this->descor->CurrentValue);
            }
            $this->descor->EditValue = HtmlEncode($this->descor->CurrentValue);
            $this->descor->PlaceHolder = RemoveHtml($this->descor->caption());

            // observ
            $this->observ->setupEditAttributes();
            if (!$this->observ->Raw) {
                $this->observ->CurrentValue = HtmlDecode($this->observ->CurrentValue);
            }
            $this->observ->EditValue = HtmlEncode($this->observ->CurrentValue);
            $this->observ->PlaceHolder = RemoveHtml($this->observ->caption());

            // usuario

            // fecalta

            // secuencia
            $this->secuencia->setupEditAttributes();
            $this->secuencia->EditValue = $this->secuencia->CurrentValue;
            $this->secuencia->PlaceHolder = RemoveHtml($this->secuencia->caption());
            if (strval($this->secuencia->EditValue) != "" && is_numeric($this->secuencia->EditValue)) {
                $this->secuencia->EditValue = FormatNumber($this->secuencia->EditValue, null);
            }

            // codintlote
            $this->codintlote->setupEditAttributes();
            if (!$this->codintlote->Raw) {
                $this->codintlote->CurrentValue = HtmlDecode($this->codintlote->CurrentValue);
            }
            $this->codintlote->EditValue = HtmlEncode($this->codintlote->CurrentValue);
            $this->codintlote->PlaceHolder = RemoveHtml($this->codintlote->caption());

            // codintnum
            $this->codintnum->setupEditAttributes();
            $this->codintnum->EditValue = $this->codintnum->CurrentValue;
            $this->codintnum->PlaceHolder = RemoveHtml($this->codintnum->caption());
            if (strval($this->codintnum->EditValue) != "" && is_numeric($this->codintnum->EditValue)) {
                $this->codintnum->EditValue = FormatNumber($this->codintnum->EditValue, null);
            }

            // codintsublote
            $this->codintsublote->setupEditAttributes();
            if (!$this->codintsublote->Raw) {
                $this->codintsublote->CurrentValue = HtmlDecode($this->codintsublote->CurrentValue);
            }
            $this->codintsublote->EditValue = HtmlEncode($this->codintsublote->CurrentValue);
            $this->codintsublote->PlaceHolder = RemoveHtml($this->codintsublote->caption());

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
                    $filterWrk = SearchFilter($this->dir_secuencia->Lookup->getTable()->Fields["secuencia"]->searchExpression(), "=", $this->dir_secuencia->CurrentValue, $this->dir_secuencia->Lookup->getTable()->Fields["secuencia"]->searchDataType(), "");
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

            // usuarioultmod

            // fecultmod

            // Add refer script

            // codnum
            $this->codnum->HrefValue = "";

            // codrem
            $this->codrem->HrefValue = "";

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

            // descor
            $this->descor->HrefValue = "";

            // observ
            $this->observ->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";

            // secuencia
            $this->secuencia->HrefValue = "";

            // codintlote
            $this->codintlote->HrefValue = "";

            // codintnum
            $this->codintnum->HrefValue = "";

            // codintsublote
            $this->codintsublote->HrefValue = "";

            // dir_secuencia
            $this->dir_secuencia->HrefValue = "";

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // codnum
            $this->codnum->setupEditAttributes();
            if (strval($this->codnum->EditValue) != "" && is_numeric($this->codnum->EditValue)) {
                $this->codnum->EditValue = $this->codnum->EditValue;
            }

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
            $this->estado->setupEditAttributes();
            if (strval($this->estado->CurrentValue) != "") {
                $this->estado->EditValue = $this->estado->optionCaption($this->estado->CurrentValue);
            } else {
                $this->estado->EditValue = null;
            }

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

            // descor
            $this->descor->setupEditAttributes();

            // observ
            $this->observ->setupEditAttributes();

            // usuario

            // fecalta

            // secuencia
            $this->secuencia->setupEditAttributes();
            $this->secuencia->CurrentValue = FormatNumber($this->secuencia->CurrentValue, $this->secuencia->formatPattern());
            if (strval($this->secuencia->EditValue) != "" && is_numeric($this->secuencia->EditValue)) {
                $this->secuencia->EditValue = FormatNumber($this->secuencia->EditValue, null);
            }

            // codintlote
            $this->codintlote->setupEditAttributes();
            if (!$this->codintlote->Raw) {
                $this->codintlote->CurrentValue = HtmlDecode($this->codintlote->CurrentValue);
            }
            $this->codintlote->EditValue = HtmlEncode($this->codintlote->CurrentValue);
            $this->codintlote->PlaceHolder = RemoveHtml($this->codintlote->caption());

            // codintnum
            $this->codintnum->setupEditAttributes();
            $this->codintnum->CurrentValue = FormatNumber($this->codintnum->CurrentValue, $this->codintnum->formatPattern());
            if (strval($this->codintnum->EditValue) != "" && is_numeric($this->codintnum->EditValue)) {
                $this->codintnum->EditValue = FormatNumber($this->codintnum->EditValue, null);
            }

            // codintsublote
            $this->codintsublote->setupEditAttributes();

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
                    $filterWrk = SearchFilter($this->dir_secuencia->Lookup->getTable()->Fields["secuencia"]->searchExpression(), "=", $this->dir_secuencia->CurrentValue, $this->dir_secuencia->Lookup->getTable()->Fields["secuencia"]->searchDataType(), "");
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

            // usuarioultmod

            // fecultmod

            // Edit refer script

            // codnum
            $this->codnum->HrefValue = "";

            // codrem
            $this->codrem->HrefValue = "";
            $this->codrem->TooltipValue = "";

            // codcli
            $this->codcli->HrefValue = "";

            // codrubro
            $this->codrubro->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";
            $this->estado->TooltipValue = "";

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

            // descor
            $this->descor->HrefValue = "";

            // observ
            $this->observ->HrefValue = "";

            // usuario
            $this->usuario->HrefValue = "";

            // fecalta
            $this->fecalta->HrefValue = "";

            // secuencia
            $this->secuencia->HrefValue = "";

            // codintlote
            $this->codintlote->HrefValue = "";

            // codintnum
            $this->codintnum->HrefValue = "";

            // codintsublote
            $this->codintsublote->HrefValue = "";

            // dir_secuencia
            $this->dir_secuencia->HrefValue = "";

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
            if ($this->secuencia->Visible && $this->secuencia->Required) {
                if (!$this->secuencia->IsDetailKey && EmptyValue($this->secuencia->FormValue)) {
                    $this->secuencia->addErrorMessage(str_replace("%s", $this->secuencia->caption(), $this->secuencia->RequiredErrorMessage));
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
            if ($this->dir_secuencia->Visible && $this->dir_secuencia->Required) {
                if (!$this->dir_secuencia->IsDetailKey && EmptyValue($this->dir_secuencia->FormValue)) {
                    $this->dir_secuencia->addErrorMessage(str_replace("%s", $this->dir_secuencia->caption(), $this->dir_secuencia->RequiredErrorMessage));
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

        // descor
        $this->descor->setDbValueDef($rsnew, $this->descor->CurrentValue, $this->descor->ReadOnly);

        // observ
        $this->observ->setDbValueDef($rsnew, $this->observ->CurrentValue, $this->observ->ReadOnly);

        // usuario
        $this->usuario->CurrentValue = $this->usuario->getAutoUpdateValue(); // PHP
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue);

        // fecalta
        $this->fecalta->CurrentValue = $this->fecalta->getAutoUpdateValue(); // PHP
        $this->fecalta->setDbValueDef($rsnew, UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern()));

        // secuencia
        $this->secuencia->setDbValueDef($rsnew, $this->secuencia->CurrentValue, $this->secuencia->ReadOnly);

        // codintlote
        $this->codintlote->setDbValueDef($rsnew, $this->codintlote->CurrentValue, $this->codintlote->ReadOnly);

        // codintnum
        $this->codintnum->setDbValueDef($rsnew, $this->codintnum->CurrentValue, $this->codintnum->ReadOnly);

        // codintsublote
        $this->codintsublote->setDbValueDef($rsnew, $this->codintsublote->CurrentValue, $this->codintsublote->ReadOnly);

        // dir_secuencia
        $this->dir_secuencia->setDbValueDef($rsnew, $this->dir_secuencia->CurrentValue, $this->dir_secuencia->ReadOnly);

        // usuarioultmod
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->getAutoUpdateValue(); // PHP
        $this->usuarioultmod->setDbValueDef($rsnew, $this->usuarioultmod->CurrentValue);

        // fecultmod
        $this->fecultmod->CurrentValue = $this->fecultmod->getAutoUpdateValue(); // PHP
        $this->fecultmod->setDbValueDef($rsnew, UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern()));
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
        if (isset($row['secuencia'])) { // secuencia
            $this->secuencia->CurrentValue = $row['secuencia'];
        }
        if (isset($row['codintlote'])) { // codintlote
            $this->codintlote->CurrentValue = $row['codintlote'];
        }
        if (isset($row['codintnum'])) { // codintnum
            $this->codintnum->CurrentValue = $row['codintnum'];
        }
        if (isset($row['codintsublote'])) { // codintsublote
            $this->codintsublote->CurrentValue = $row['codintsublote'];
        }
        if (isset($row['dir_secuencia'])) { // dir_secuencia
            $this->dir_secuencia->CurrentValue = $row['dir_secuencia'];
        }
        if (isset($row['usuarioultmod'])) { // usuarioultmod
            $this->usuarioultmod->CurrentValue = $row['usuarioultmod'];
        }
        if (isset($row['fecultmod'])) { // fecultmod
            $this->fecultmod->CurrentValue = $row['fecultmod'];
        }
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "remates") {
            $this->codrem->Visible = true; // Need to insert foreign key
            $this->codrem->CurrentValue = $this->codrem->getSessionValue();
        }

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'lotes'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["codrem"] = $this->codrem->CurrentValue;
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

        // codrem
        $this->codrem->setDbValueDef($rsnew, $this->codrem->CurrentValue, false);

        // codcli
        $this->codcli->setDbValueDef($rsnew, $this->codcli->CurrentValue, false);

        // codrubro
        $this->codrubro->setDbValueDef($rsnew, $this->codrubro->CurrentValue, false);

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, strval($this->estado->CurrentValue) == "");

        // moneda
        $this->moneda->setDbValueDef($rsnew, $this->moneda->CurrentValue, strval($this->moneda->CurrentValue) == "");

        // preciobase
        $this->preciobase->setDbValueDef($rsnew, $this->preciobase->CurrentValue, strval($this->preciobase->CurrentValue) == "");

        // preciofinal
        $this->preciofinal->setDbValueDef($rsnew, $this->preciofinal->CurrentValue, strval($this->preciofinal->CurrentValue) == "");

        // comiscobr
        $this->comiscobr->setDbValueDef($rsnew, $this->comiscobr->CurrentValue, strval($this->comiscobr->CurrentValue) == "");

        // comispag
        $this->comispag->setDbValueDef($rsnew, $this->comispag->CurrentValue, strval($this->comispag->CurrentValue) == "");

        // comprador
        $this->comprador->setDbValueDef($rsnew, $this->comprador->CurrentValue, false);

        // ivari
        $this->ivari->setDbValueDef($rsnew, $this->ivari->CurrentValue, false);

        // ivarni
        $this->ivarni->setDbValueDef($rsnew, $this->ivarni->CurrentValue, false);

        // codimpadic
        $this->codimpadic->setDbValueDef($rsnew, $this->codimpadic->CurrentValue, false);

        // impadic
        $this->impadic->setDbValueDef($rsnew, $this->impadic->CurrentValue, false);

        // descor
        $this->descor->setDbValueDef($rsnew, $this->descor->CurrentValue, false);

        // observ
        $this->observ->setDbValueDef($rsnew, $this->observ->CurrentValue, false);

        // usuario
        $this->usuario->CurrentValue = $this->usuario->getAutoUpdateValue(); // PHP
        $this->usuario->setDbValueDef($rsnew, $this->usuario->CurrentValue);

        // fecalta
        $this->fecalta->CurrentValue = $this->fecalta->getAutoUpdateValue(); // PHP
        $this->fecalta->setDbValueDef($rsnew, UnFormatDateTime($this->fecalta->CurrentValue, $this->fecalta->formatPattern()));

        // secuencia
        $this->secuencia->setDbValueDef($rsnew, $this->secuencia->CurrentValue, false);

        // codintlote
        $this->codintlote->setDbValueDef($rsnew, $this->codintlote->CurrentValue, false);

        // codintnum
        $this->codintnum->setDbValueDef($rsnew, $this->codintnum->CurrentValue, false);

        // codintsublote
        $this->codintsublote->setDbValueDef($rsnew, $this->codintsublote->CurrentValue, false);

        // dir_secuencia
        $this->dir_secuencia->setDbValueDef($rsnew, $this->dir_secuencia->CurrentValue, false);

        // usuarioultmod
        $this->usuarioultmod->CurrentValue = $this->usuarioultmod->getAutoUpdateValue(); // PHP
        $this->usuarioultmod->setDbValueDef($rsnew, $this->usuarioultmod->CurrentValue);

        // fecultmod
        $this->fecultmod->CurrentValue = $this->fecultmod->getAutoUpdateValue(); // PHP
        $this->fecultmod->setDbValueDef($rsnew, UnFormatDateTime($this->fecultmod->CurrentValue, $this->fecultmod->formatPattern()));
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['codrem'])) { // codrem
            $this->codrem->setFormValue($row['codrem']);
        }
        if (isset($row['codcli'])) { // codcli
            $this->codcli->setFormValue($row['codcli']);
        }
        if (isset($row['codrubro'])) { // codrubro
            $this->codrubro->setFormValue($row['codrubro']);
        }
        if (isset($row['estado'])) { // estado
            $this->estado->setFormValue($row['estado']);
        }
        if (isset($row['moneda'])) { // moneda
            $this->moneda->setFormValue($row['moneda']);
        }
        if (isset($row['preciobase'])) { // preciobase
            $this->preciobase->setFormValue($row['preciobase']);
        }
        if (isset($row['preciofinal'])) { // preciofinal
            $this->preciofinal->setFormValue($row['preciofinal']);
        }
        if (isset($row['comiscobr'])) { // comiscobr
            $this->comiscobr->setFormValue($row['comiscobr']);
        }
        if (isset($row['comispag'])) { // comispag
            $this->comispag->setFormValue($row['comispag']);
        }
        if (isset($row['comprador'])) { // comprador
            $this->comprador->setFormValue($row['comprador']);
        }
        if (isset($row['ivari'])) { // ivari
            $this->ivari->setFormValue($row['ivari']);
        }
        if (isset($row['ivarni'])) { // ivarni
            $this->ivarni->setFormValue($row['ivarni']);
        }
        if (isset($row['codimpadic'])) { // codimpadic
            $this->codimpadic->setFormValue($row['codimpadic']);
        }
        if (isset($row['impadic'])) { // impadic
            $this->impadic->setFormValue($row['impadic']);
        }
        if (isset($row['descor'])) { // descor
            $this->descor->setFormValue($row['descor']);
        }
        if (isset($row['observ'])) { // observ
            $this->observ->setFormValue($row['observ']);
        }
        if (isset($row['usuario'])) { // usuario
            $this->usuario->setFormValue($row['usuario']);
        }
        if (isset($row['fecalta'])) { // fecalta
            $this->fecalta->setFormValue($row['fecalta']);
        }
        if (isset($row['secuencia'])) { // secuencia
            $this->secuencia->setFormValue($row['secuencia']);
        }
        if (isset($row['codintlote'])) { // codintlote
            $this->codintlote->setFormValue($row['codintlote']);
        }
        if (isset($row['codintnum'])) { // codintnum
            $this->codintnum->setFormValue($row['codintnum']);
        }
        if (isset($row['codintsublote'])) { // codintsublote
            $this->codintsublote->setFormValue($row['codintsublote']);
        }
        if (isset($row['dir_secuencia'])) { // dir_secuencia
            $this->dir_secuencia->setFormValue($row['dir_secuencia']);
        }
        if (isset($row['usuarioultmod'])) { // usuarioultmod
            $this->usuarioultmod->setFormValue($row['usuarioultmod']);
        }
        if (isset($row['fecultmod'])) { // fecultmod
            $this->fecultmod->setFormValue($row['fecultmod']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "remates") {
            $masterTbl = Container("remates");
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
