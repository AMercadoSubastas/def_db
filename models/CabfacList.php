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
class CabfacList extends Cabfac
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "CabfacList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fcabfaclist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "CabfacList";

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
        $this->tipoiva->setVisibility();
        $this->porciva->setVisibility();
        $this->nrengs->setVisibility();
        $this->fechahora->setVisibility();
        $this->usuario->setVisibility();
        $this->tieneresol->setVisibility();
        $this->leyendafc->Visible = false;
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
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'cabfac';
        $this->TableName = 'cabfac';

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

        // Table object (cabfac)
        if (!isset($GLOBALS["cabfac"]) || $GLOBALS["cabfac"]::class == PROJECT_NAMESPACE . "cabfac") {
            $GLOBALS["cabfac"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "CabfacAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "CabfacDelete";
        $this->MultiUpdateUrl = "CabfacUpdate";

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
                    $result["view"] = SameString($pageName, "CabfacView"); // If View page, no primary button
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
            $this->fechahora->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->usuario->Visible = false;
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
        $this->setupLookupOptions($this->tcomp);
        $this->setupLookupOptions($this->serie);
        $this->setupLookupOptions($this->cliente);
        $this->setupLookupOptions($this->codrem);
        $this->setupLookupOptions($this->estado);
        $this->setupLookupOptions($this->emitido);
        $this->setupLookupOptions($this->en_liquid);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fcabfacgrid";
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

        // Get basic search values
        $this->loadBasicSearchValues();

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
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
            $savedFilterList = Profile()->getSearchFilters("fcabfacsrch");
        }
        $filterList = Concat($filterList, $this->codnum->AdvancedSearch->toJson(), ","); // Field codnum
        $filterList = Concat($filterList, $this->tcomp->AdvancedSearch->toJson(), ","); // Field tcomp
        $filterList = Concat($filterList, $this->serie->AdvancedSearch->toJson(), ","); // Field serie
        $filterList = Concat($filterList, $this->ncomp->AdvancedSearch->toJson(), ","); // Field ncomp
        $filterList = Concat($filterList, $this->fecval->AdvancedSearch->toJson(), ","); // Field fecval
        $filterList = Concat($filterList, $this->fecdoc->AdvancedSearch->toJson(), ","); // Field fecdoc
        $filterList = Concat($filterList, $this->fecreg->AdvancedSearch->toJson(), ","); // Field fecreg
        $filterList = Concat($filterList, $this->cliente->AdvancedSearch->toJson(), ","); // Field cliente
        $filterList = Concat($filterList, $this->cpago->AdvancedSearch->toJson(), ","); // Field cpago
        $filterList = Concat($filterList, $this->fecvenc->AdvancedSearch->toJson(), ","); // Field fecvenc
        $filterList = Concat($filterList, $this->direc->AdvancedSearch->toJson(), ","); // Field direc
        $filterList = Concat($filterList, $this->dnro->AdvancedSearch->toJson(), ","); // Field dnro
        $filterList = Concat($filterList, $this->pisodto->AdvancedSearch->toJson(), ","); // Field pisodto
        $filterList = Concat($filterList, $this->codpost->AdvancedSearch->toJson(), ","); // Field codpost
        $filterList = Concat($filterList, $this->codpais->AdvancedSearch->toJson(), ","); // Field codpais
        $filterList = Concat($filterList, $this->codprov->AdvancedSearch->toJson(), ","); // Field codprov
        $filterList = Concat($filterList, $this->codloc->AdvancedSearch->toJson(), ","); // Field codloc
        $filterList = Concat($filterList, $this->telef->AdvancedSearch->toJson(), ","); // Field telef
        $filterList = Concat($filterList, $this->codrem->AdvancedSearch->toJson(), ","); // Field codrem
        $filterList = Concat($filterList, $this->estado->AdvancedSearch->toJson(), ","); // Field estado
        $filterList = Concat($filterList, $this->emitido->AdvancedSearch->toJson(), ","); // Field emitido
        $filterList = Concat($filterList, $this->moneda->AdvancedSearch->toJson(), ","); // Field moneda
        $filterList = Concat($filterList, $this->totneto->AdvancedSearch->toJson(), ","); // Field totneto
        $filterList = Concat($filterList, $this->totbruto->AdvancedSearch->toJson(), ","); // Field totbruto
        $filterList = Concat($filterList, $this->totiva105->AdvancedSearch->toJson(), ","); // Field totiva105
        $filterList = Concat($filterList, $this->totiva21->AdvancedSearch->toJson(), ","); // Field totiva21
        $filterList = Concat($filterList, $this->totimp->AdvancedSearch->toJson(), ","); // Field totimp
        $filterList = Concat($filterList, $this->totcomis->AdvancedSearch->toJson(), ","); // Field totcomis
        $filterList = Concat($filterList, $this->totneto105->AdvancedSearch->toJson(), ","); // Field totneto105
        $filterList = Concat($filterList, $this->totneto21->AdvancedSearch->toJson(), ","); // Field totneto21
        $filterList = Concat($filterList, $this->tipoiva->AdvancedSearch->toJson(), ","); // Field tipoiva
        $filterList = Concat($filterList, $this->porciva->AdvancedSearch->toJson(), ","); // Field porciva
        $filterList = Concat($filterList, $this->nrengs->AdvancedSearch->toJson(), ","); // Field nrengs
        $filterList = Concat($filterList, $this->fechahora->AdvancedSearch->toJson(), ","); // Field fechahora
        $filterList = Concat($filterList, $this->usuario->AdvancedSearch->toJson(), ","); // Field usuario
        $filterList = Concat($filterList, $this->tieneresol->AdvancedSearch->toJson(), ","); // Field tieneresol
        $filterList = Concat($filterList, $this->leyendafc->AdvancedSearch->toJson(), ","); // Field leyendafc
        $filterList = Concat($filterList, $this->concepto->AdvancedSearch->toJson(), ","); // Field concepto
        $filterList = Concat($filterList, $this->nrodoc->AdvancedSearch->toJson(), ","); // Field nrodoc
        $filterList = Concat($filterList, $this->tcompsal->AdvancedSearch->toJson(), ","); // Field tcompsal
        $filterList = Concat($filterList, $this->seriesal->AdvancedSearch->toJson(), ","); // Field seriesal
        $filterList = Concat($filterList, $this->ncompsal->AdvancedSearch->toJson(), ","); // Field ncompsal
        $filterList = Concat($filterList, $this->en_liquid->AdvancedSearch->toJson(), ","); // Field en_liquid
        $filterList = Concat($filterList, $this->CAE->AdvancedSearch->toJson(), ","); // Field CAE
        $filterList = Concat($filterList, $this->CAEFchVto->AdvancedSearch->toJson(), ","); // Field CAEFchVto
        $filterList = Concat($filterList, $this->Resultado->AdvancedSearch->toJson(), ","); // Field Resultado
        $filterList = Concat($filterList, $this->usuarioultmod->AdvancedSearch->toJson(), ","); // Field usuarioultmod
        $filterList = Concat($filterList, $this->fecultmod->AdvancedSearch->toJson(), ","); // Field fecultmod
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
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
            Profile()->setSearchFilters("fcabfacsrch", $filters);
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

        // Field tcomp
        $this->tcomp->AdvancedSearch->SearchValue = @$filter["x_tcomp"];
        $this->tcomp->AdvancedSearch->SearchOperator = @$filter["z_tcomp"];
        $this->tcomp->AdvancedSearch->SearchCondition = @$filter["v_tcomp"];
        $this->tcomp->AdvancedSearch->SearchValue2 = @$filter["y_tcomp"];
        $this->tcomp->AdvancedSearch->SearchOperator2 = @$filter["w_tcomp"];
        $this->tcomp->AdvancedSearch->save();

        // Field serie
        $this->serie->AdvancedSearch->SearchValue = @$filter["x_serie"];
        $this->serie->AdvancedSearch->SearchOperator = @$filter["z_serie"];
        $this->serie->AdvancedSearch->SearchCondition = @$filter["v_serie"];
        $this->serie->AdvancedSearch->SearchValue2 = @$filter["y_serie"];
        $this->serie->AdvancedSearch->SearchOperator2 = @$filter["w_serie"];
        $this->serie->AdvancedSearch->save();

        // Field ncomp
        $this->ncomp->AdvancedSearch->SearchValue = @$filter["x_ncomp"];
        $this->ncomp->AdvancedSearch->SearchOperator = @$filter["z_ncomp"];
        $this->ncomp->AdvancedSearch->SearchCondition = @$filter["v_ncomp"];
        $this->ncomp->AdvancedSearch->SearchValue2 = @$filter["y_ncomp"];
        $this->ncomp->AdvancedSearch->SearchOperator2 = @$filter["w_ncomp"];
        $this->ncomp->AdvancedSearch->save();

        // Field fecval
        $this->fecval->AdvancedSearch->SearchValue = @$filter["x_fecval"];
        $this->fecval->AdvancedSearch->SearchOperator = @$filter["z_fecval"];
        $this->fecval->AdvancedSearch->SearchCondition = @$filter["v_fecval"];
        $this->fecval->AdvancedSearch->SearchValue2 = @$filter["y_fecval"];
        $this->fecval->AdvancedSearch->SearchOperator2 = @$filter["w_fecval"];
        $this->fecval->AdvancedSearch->save();

        // Field fecdoc
        $this->fecdoc->AdvancedSearch->SearchValue = @$filter["x_fecdoc"];
        $this->fecdoc->AdvancedSearch->SearchOperator = @$filter["z_fecdoc"];
        $this->fecdoc->AdvancedSearch->SearchCondition = @$filter["v_fecdoc"];
        $this->fecdoc->AdvancedSearch->SearchValue2 = @$filter["y_fecdoc"];
        $this->fecdoc->AdvancedSearch->SearchOperator2 = @$filter["w_fecdoc"];
        $this->fecdoc->AdvancedSearch->save();

        // Field fecreg
        $this->fecreg->AdvancedSearch->SearchValue = @$filter["x_fecreg"];
        $this->fecreg->AdvancedSearch->SearchOperator = @$filter["z_fecreg"];
        $this->fecreg->AdvancedSearch->SearchCondition = @$filter["v_fecreg"];
        $this->fecreg->AdvancedSearch->SearchValue2 = @$filter["y_fecreg"];
        $this->fecreg->AdvancedSearch->SearchOperator2 = @$filter["w_fecreg"];
        $this->fecreg->AdvancedSearch->save();

        // Field cliente
        $this->cliente->AdvancedSearch->SearchValue = @$filter["x_cliente"];
        $this->cliente->AdvancedSearch->SearchOperator = @$filter["z_cliente"];
        $this->cliente->AdvancedSearch->SearchCondition = @$filter["v_cliente"];
        $this->cliente->AdvancedSearch->SearchValue2 = @$filter["y_cliente"];
        $this->cliente->AdvancedSearch->SearchOperator2 = @$filter["w_cliente"];
        $this->cliente->AdvancedSearch->save();

        // Field cpago
        $this->cpago->AdvancedSearch->SearchValue = @$filter["x_cpago"];
        $this->cpago->AdvancedSearch->SearchOperator = @$filter["z_cpago"];
        $this->cpago->AdvancedSearch->SearchCondition = @$filter["v_cpago"];
        $this->cpago->AdvancedSearch->SearchValue2 = @$filter["y_cpago"];
        $this->cpago->AdvancedSearch->SearchOperator2 = @$filter["w_cpago"];
        $this->cpago->AdvancedSearch->save();

        // Field fecvenc
        $this->fecvenc->AdvancedSearch->SearchValue = @$filter["x_fecvenc"];
        $this->fecvenc->AdvancedSearch->SearchOperator = @$filter["z_fecvenc"];
        $this->fecvenc->AdvancedSearch->SearchCondition = @$filter["v_fecvenc"];
        $this->fecvenc->AdvancedSearch->SearchValue2 = @$filter["y_fecvenc"];
        $this->fecvenc->AdvancedSearch->SearchOperator2 = @$filter["w_fecvenc"];
        $this->fecvenc->AdvancedSearch->save();

        // Field direc
        $this->direc->AdvancedSearch->SearchValue = @$filter["x_direc"];
        $this->direc->AdvancedSearch->SearchOperator = @$filter["z_direc"];
        $this->direc->AdvancedSearch->SearchCondition = @$filter["v_direc"];
        $this->direc->AdvancedSearch->SearchValue2 = @$filter["y_direc"];
        $this->direc->AdvancedSearch->SearchOperator2 = @$filter["w_direc"];
        $this->direc->AdvancedSearch->save();

        // Field dnro
        $this->dnro->AdvancedSearch->SearchValue = @$filter["x_dnro"];
        $this->dnro->AdvancedSearch->SearchOperator = @$filter["z_dnro"];
        $this->dnro->AdvancedSearch->SearchCondition = @$filter["v_dnro"];
        $this->dnro->AdvancedSearch->SearchValue2 = @$filter["y_dnro"];
        $this->dnro->AdvancedSearch->SearchOperator2 = @$filter["w_dnro"];
        $this->dnro->AdvancedSearch->save();

        // Field pisodto
        $this->pisodto->AdvancedSearch->SearchValue = @$filter["x_pisodto"];
        $this->pisodto->AdvancedSearch->SearchOperator = @$filter["z_pisodto"];
        $this->pisodto->AdvancedSearch->SearchCondition = @$filter["v_pisodto"];
        $this->pisodto->AdvancedSearch->SearchValue2 = @$filter["y_pisodto"];
        $this->pisodto->AdvancedSearch->SearchOperator2 = @$filter["w_pisodto"];
        $this->pisodto->AdvancedSearch->save();

        // Field codpost
        $this->codpost->AdvancedSearch->SearchValue = @$filter["x_codpost"];
        $this->codpost->AdvancedSearch->SearchOperator = @$filter["z_codpost"];
        $this->codpost->AdvancedSearch->SearchCondition = @$filter["v_codpost"];
        $this->codpost->AdvancedSearch->SearchValue2 = @$filter["y_codpost"];
        $this->codpost->AdvancedSearch->SearchOperator2 = @$filter["w_codpost"];
        $this->codpost->AdvancedSearch->save();

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

        // Field telef
        $this->telef->AdvancedSearch->SearchValue = @$filter["x_telef"];
        $this->telef->AdvancedSearch->SearchOperator = @$filter["z_telef"];
        $this->telef->AdvancedSearch->SearchCondition = @$filter["v_telef"];
        $this->telef->AdvancedSearch->SearchValue2 = @$filter["y_telef"];
        $this->telef->AdvancedSearch->SearchOperator2 = @$filter["w_telef"];
        $this->telef->AdvancedSearch->save();

        // Field codrem
        $this->codrem->AdvancedSearch->SearchValue = @$filter["x_codrem"];
        $this->codrem->AdvancedSearch->SearchOperator = @$filter["z_codrem"];
        $this->codrem->AdvancedSearch->SearchCondition = @$filter["v_codrem"];
        $this->codrem->AdvancedSearch->SearchValue2 = @$filter["y_codrem"];
        $this->codrem->AdvancedSearch->SearchOperator2 = @$filter["w_codrem"];
        $this->codrem->AdvancedSearch->save();

        // Field estado
        $this->estado->AdvancedSearch->SearchValue = @$filter["x_estado"];
        $this->estado->AdvancedSearch->SearchOperator = @$filter["z_estado"];
        $this->estado->AdvancedSearch->SearchCondition = @$filter["v_estado"];
        $this->estado->AdvancedSearch->SearchValue2 = @$filter["y_estado"];
        $this->estado->AdvancedSearch->SearchOperator2 = @$filter["w_estado"];
        $this->estado->AdvancedSearch->save();

        // Field emitido
        $this->emitido->AdvancedSearch->SearchValue = @$filter["x_emitido"];
        $this->emitido->AdvancedSearch->SearchOperator = @$filter["z_emitido"];
        $this->emitido->AdvancedSearch->SearchCondition = @$filter["v_emitido"];
        $this->emitido->AdvancedSearch->SearchValue2 = @$filter["y_emitido"];
        $this->emitido->AdvancedSearch->SearchOperator2 = @$filter["w_emitido"];
        $this->emitido->AdvancedSearch->save();

        // Field moneda
        $this->moneda->AdvancedSearch->SearchValue = @$filter["x_moneda"];
        $this->moneda->AdvancedSearch->SearchOperator = @$filter["z_moneda"];
        $this->moneda->AdvancedSearch->SearchCondition = @$filter["v_moneda"];
        $this->moneda->AdvancedSearch->SearchValue2 = @$filter["y_moneda"];
        $this->moneda->AdvancedSearch->SearchOperator2 = @$filter["w_moneda"];
        $this->moneda->AdvancedSearch->save();

        // Field totneto
        $this->totneto->AdvancedSearch->SearchValue = @$filter["x_totneto"];
        $this->totneto->AdvancedSearch->SearchOperator = @$filter["z_totneto"];
        $this->totneto->AdvancedSearch->SearchCondition = @$filter["v_totneto"];
        $this->totneto->AdvancedSearch->SearchValue2 = @$filter["y_totneto"];
        $this->totneto->AdvancedSearch->SearchOperator2 = @$filter["w_totneto"];
        $this->totneto->AdvancedSearch->save();

        // Field totbruto
        $this->totbruto->AdvancedSearch->SearchValue = @$filter["x_totbruto"];
        $this->totbruto->AdvancedSearch->SearchOperator = @$filter["z_totbruto"];
        $this->totbruto->AdvancedSearch->SearchCondition = @$filter["v_totbruto"];
        $this->totbruto->AdvancedSearch->SearchValue2 = @$filter["y_totbruto"];
        $this->totbruto->AdvancedSearch->SearchOperator2 = @$filter["w_totbruto"];
        $this->totbruto->AdvancedSearch->save();

        // Field totiva105
        $this->totiva105->AdvancedSearch->SearchValue = @$filter["x_totiva105"];
        $this->totiva105->AdvancedSearch->SearchOperator = @$filter["z_totiva105"];
        $this->totiva105->AdvancedSearch->SearchCondition = @$filter["v_totiva105"];
        $this->totiva105->AdvancedSearch->SearchValue2 = @$filter["y_totiva105"];
        $this->totiva105->AdvancedSearch->SearchOperator2 = @$filter["w_totiva105"];
        $this->totiva105->AdvancedSearch->save();

        // Field totiva21
        $this->totiva21->AdvancedSearch->SearchValue = @$filter["x_totiva21"];
        $this->totiva21->AdvancedSearch->SearchOperator = @$filter["z_totiva21"];
        $this->totiva21->AdvancedSearch->SearchCondition = @$filter["v_totiva21"];
        $this->totiva21->AdvancedSearch->SearchValue2 = @$filter["y_totiva21"];
        $this->totiva21->AdvancedSearch->SearchOperator2 = @$filter["w_totiva21"];
        $this->totiva21->AdvancedSearch->save();

        // Field totimp
        $this->totimp->AdvancedSearch->SearchValue = @$filter["x_totimp"];
        $this->totimp->AdvancedSearch->SearchOperator = @$filter["z_totimp"];
        $this->totimp->AdvancedSearch->SearchCondition = @$filter["v_totimp"];
        $this->totimp->AdvancedSearch->SearchValue2 = @$filter["y_totimp"];
        $this->totimp->AdvancedSearch->SearchOperator2 = @$filter["w_totimp"];
        $this->totimp->AdvancedSearch->save();

        // Field totcomis
        $this->totcomis->AdvancedSearch->SearchValue = @$filter["x_totcomis"];
        $this->totcomis->AdvancedSearch->SearchOperator = @$filter["z_totcomis"];
        $this->totcomis->AdvancedSearch->SearchCondition = @$filter["v_totcomis"];
        $this->totcomis->AdvancedSearch->SearchValue2 = @$filter["y_totcomis"];
        $this->totcomis->AdvancedSearch->SearchOperator2 = @$filter["w_totcomis"];
        $this->totcomis->AdvancedSearch->save();

        // Field totneto105
        $this->totneto105->AdvancedSearch->SearchValue = @$filter["x_totneto105"];
        $this->totneto105->AdvancedSearch->SearchOperator = @$filter["z_totneto105"];
        $this->totneto105->AdvancedSearch->SearchCondition = @$filter["v_totneto105"];
        $this->totneto105->AdvancedSearch->SearchValue2 = @$filter["y_totneto105"];
        $this->totneto105->AdvancedSearch->SearchOperator2 = @$filter["w_totneto105"];
        $this->totneto105->AdvancedSearch->save();

        // Field totneto21
        $this->totneto21->AdvancedSearch->SearchValue = @$filter["x_totneto21"];
        $this->totneto21->AdvancedSearch->SearchOperator = @$filter["z_totneto21"];
        $this->totneto21->AdvancedSearch->SearchCondition = @$filter["v_totneto21"];
        $this->totneto21->AdvancedSearch->SearchValue2 = @$filter["y_totneto21"];
        $this->totneto21->AdvancedSearch->SearchOperator2 = @$filter["w_totneto21"];
        $this->totneto21->AdvancedSearch->save();

        // Field tipoiva
        $this->tipoiva->AdvancedSearch->SearchValue = @$filter["x_tipoiva"];
        $this->tipoiva->AdvancedSearch->SearchOperator = @$filter["z_tipoiva"];
        $this->tipoiva->AdvancedSearch->SearchCondition = @$filter["v_tipoiva"];
        $this->tipoiva->AdvancedSearch->SearchValue2 = @$filter["y_tipoiva"];
        $this->tipoiva->AdvancedSearch->SearchOperator2 = @$filter["w_tipoiva"];
        $this->tipoiva->AdvancedSearch->save();

        // Field porciva
        $this->porciva->AdvancedSearch->SearchValue = @$filter["x_porciva"];
        $this->porciva->AdvancedSearch->SearchOperator = @$filter["z_porciva"];
        $this->porciva->AdvancedSearch->SearchCondition = @$filter["v_porciva"];
        $this->porciva->AdvancedSearch->SearchValue2 = @$filter["y_porciva"];
        $this->porciva->AdvancedSearch->SearchOperator2 = @$filter["w_porciva"];
        $this->porciva->AdvancedSearch->save();

        // Field nrengs
        $this->nrengs->AdvancedSearch->SearchValue = @$filter["x_nrengs"];
        $this->nrengs->AdvancedSearch->SearchOperator = @$filter["z_nrengs"];
        $this->nrengs->AdvancedSearch->SearchCondition = @$filter["v_nrengs"];
        $this->nrengs->AdvancedSearch->SearchValue2 = @$filter["y_nrengs"];
        $this->nrengs->AdvancedSearch->SearchOperator2 = @$filter["w_nrengs"];
        $this->nrengs->AdvancedSearch->save();

        // Field fechahora
        $this->fechahora->AdvancedSearch->SearchValue = @$filter["x_fechahora"];
        $this->fechahora->AdvancedSearch->SearchOperator = @$filter["z_fechahora"];
        $this->fechahora->AdvancedSearch->SearchCondition = @$filter["v_fechahora"];
        $this->fechahora->AdvancedSearch->SearchValue2 = @$filter["y_fechahora"];
        $this->fechahora->AdvancedSearch->SearchOperator2 = @$filter["w_fechahora"];
        $this->fechahora->AdvancedSearch->save();

        // Field usuario
        $this->usuario->AdvancedSearch->SearchValue = @$filter["x_usuario"];
        $this->usuario->AdvancedSearch->SearchOperator = @$filter["z_usuario"];
        $this->usuario->AdvancedSearch->SearchCondition = @$filter["v_usuario"];
        $this->usuario->AdvancedSearch->SearchValue2 = @$filter["y_usuario"];
        $this->usuario->AdvancedSearch->SearchOperator2 = @$filter["w_usuario"];
        $this->usuario->AdvancedSearch->save();

        // Field tieneresol
        $this->tieneresol->AdvancedSearch->SearchValue = @$filter["x_tieneresol"];
        $this->tieneresol->AdvancedSearch->SearchOperator = @$filter["z_tieneresol"];
        $this->tieneresol->AdvancedSearch->SearchCondition = @$filter["v_tieneresol"];
        $this->tieneresol->AdvancedSearch->SearchValue2 = @$filter["y_tieneresol"];
        $this->tieneresol->AdvancedSearch->SearchOperator2 = @$filter["w_tieneresol"];
        $this->tieneresol->AdvancedSearch->save();

        // Field leyendafc
        $this->leyendafc->AdvancedSearch->SearchValue = @$filter["x_leyendafc"];
        $this->leyendafc->AdvancedSearch->SearchOperator = @$filter["z_leyendafc"];
        $this->leyendafc->AdvancedSearch->SearchCondition = @$filter["v_leyendafc"];
        $this->leyendafc->AdvancedSearch->SearchValue2 = @$filter["y_leyendafc"];
        $this->leyendafc->AdvancedSearch->SearchOperator2 = @$filter["w_leyendafc"];
        $this->leyendafc->AdvancedSearch->save();

        // Field concepto
        $this->concepto->AdvancedSearch->SearchValue = @$filter["x_concepto"];
        $this->concepto->AdvancedSearch->SearchOperator = @$filter["z_concepto"];
        $this->concepto->AdvancedSearch->SearchCondition = @$filter["v_concepto"];
        $this->concepto->AdvancedSearch->SearchValue2 = @$filter["y_concepto"];
        $this->concepto->AdvancedSearch->SearchOperator2 = @$filter["w_concepto"];
        $this->concepto->AdvancedSearch->save();

        // Field nrodoc
        $this->nrodoc->AdvancedSearch->SearchValue = @$filter["x_nrodoc"];
        $this->nrodoc->AdvancedSearch->SearchOperator = @$filter["z_nrodoc"];
        $this->nrodoc->AdvancedSearch->SearchCondition = @$filter["v_nrodoc"];
        $this->nrodoc->AdvancedSearch->SearchValue2 = @$filter["y_nrodoc"];
        $this->nrodoc->AdvancedSearch->SearchOperator2 = @$filter["w_nrodoc"];
        $this->nrodoc->AdvancedSearch->save();

        // Field tcompsal
        $this->tcompsal->AdvancedSearch->SearchValue = @$filter["x_tcompsal"];
        $this->tcompsal->AdvancedSearch->SearchOperator = @$filter["z_tcompsal"];
        $this->tcompsal->AdvancedSearch->SearchCondition = @$filter["v_tcompsal"];
        $this->tcompsal->AdvancedSearch->SearchValue2 = @$filter["y_tcompsal"];
        $this->tcompsal->AdvancedSearch->SearchOperator2 = @$filter["w_tcompsal"];
        $this->tcompsal->AdvancedSearch->save();

        // Field seriesal
        $this->seriesal->AdvancedSearch->SearchValue = @$filter["x_seriesal"];
        $this->seriesal->AdvancedSearch->SearchOperator = @$filter["z_seriesal"];
        $this->seriesal->AdvancedSearch->SearchCondition = @$filter["v_seriesal"];
        $this->seriesal->AdvancedSearch->SearchValue2 = @$filter["y_seriesal"];
        $this->seriesal->AdvancedSearch->SearchOperator2 = @$filter["w_seriesal"];
        $this->seriesal->AdvancedSearch->save();

        // Field ncompsal
        $this->ncompsal->AdvancedSearch->SearchValue = @$filter["x_ncompsal"];
        $this->ncompsal->AdvancedSearch->SearchOperator = @$filter["z_ncompsal"];
        $this->ncompsal->AdvancedSearch->SearchCondition = @$filter["v_ncompsal"];
        $this->ncompsal->AdvancedSearch->SearchValue2 = @$filter["y_ncompsal"];
        $this->ncompsal->AdvancedSearch->SearchOperator2 = @$filter["w_ncompsal"];
        $this->ncompsal->AdvancedSearch->save();

        // Field en_liquid
        $this->en_liquid->AdvancedSearch->SearchValue = @$filter["x_en_liquid"];
        $this->en_liquid->AdvancedSearch->SearchOperator = @$filter["z_en_liquid"];
        $this->en_liquid->AdvancedSearch->SearchCondition = @$filter["v_en_liquid"];
        $this->en_liquid->AdvancedSearch->SearchValue2 = @$filter["y_en_liquid"];
        $this->en_liquid->AdvancedSearch->SearchOperator2 = @$filter["w_en_liquid"];
        $this->en_liquid->AdvancedSearch->save();

        // Field CAE
        $this->CAE->AdvancedSearch->SearchValue = @$filter["x_CAE"];
        $this->CAE->AdvancedSearch->SearchOperator = @$filter["z_CAE"];
        $this->CAE->AdvancedSearch->SearchCondition = @$filter["v_CAE"];
        $this->CAE->AdvancedSearch->SearchValue2 = @$filter["y_CAE"];
        $this->CAE->AdvancedSearch->SearchOperator2 = @$filter["w_CAE"];
        $this->CAE->AdvancedSearch->save();

        // Field CAEFchVto
        $this->CAEFchVto->AdvancedSearch->SearchValue = @$filter["x_CAEFchVto"];
        $this->CAEFchVto->AdvancedSearch->SearchOperator = @$filter["z_CAEFchVto"];
        $this->CAEFchVto->AdvancedSearch->SearchCondition = @$filter["v_CAEFchVto"];
        $this->CAEFchVto->AdvancedSearch->SearchValue2 = @$filter["y_CAEFchVto"];
        $this->CAEFchVto->AdvancedSearch->SearchOperator2 = @$filter["w_CAEFchVto"];
        $this->CAEFchVto->AdvancedSearch->save();

        // Field Resultado
        $this->Resultado->AdvancedSearch->SearchValue = @$filter["x_Resultado"];
        $this->Resultado->AdvancedSearch->SearchOperator = @$filter["z_Resultado"];
        $this->Resultado->AdvancedSearch->SearchCondition = @$filter["v_Resultado"];
        $this->Resultado->AdvancedSearch->SearchValue2 = @$filter["y_Resultado"];
        $this->Resultado->AdvancedSearch->SearchOperator2 = @$filter["w_Resultado"];
        $this->Resultado->AdvancedSearch->save();

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
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";
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
        $searchFlds[] = &$this->direc;
        $searchFlds[] = &$this->dnro;
        $searchFlds[] = &$this->pisodto;
        $searchFlds[] = &$this->codpost;
        $searchFlds[] = &$this->telef;
        $searchFlds[] = &$this->estado;
        $searchFlds[] = &$this->leyendafc;
        $searchFlds[] = &$this->concepto;
        $searchFlds[] = &$this->nrodoc;
        $searchFlds[] = &$this->Resultado;
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

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
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
            $this->updateSort($this->codnum); // codnum
            $this->updateSort($this->tcomp); // tcomp
            $this->updateSort($this->serie); // serie
            $this->updateSort($this->ncomp); // ncomp
            $this->updateSort($this->fecval); // fecval
            $this->updateSort($this->fecdoc); // fecdoc
            $this->updateSort($this->fecreg); // fecreg
            $this->updateSort($this->cliente); // cliente
            $this->updateSort($this->direc); // direc
            $this->updateSort($this->dnro); // dnro
            $this->updateSort($this->pisodto); // pisodto
            $this->updateSort($this->codpost); // codpost
            $this->updateSort($this->codpais); // codpais
            $this->updateSort($this->codprov); // codprov
            $this->updateSort($this->codloc); // codloc
            $this->updateSort($this->telef); // telef
            $this->updateSort($this->codrem); // codrem
            $this->updateSort($this->estado); // estado
            $this->updateSort($this->emitido); // emitido
            $this->updateSort($this->moneda); // moneda
            $this->updateSort($this->totneto); // totneto
            $this->updateSort($this->totbruto); // totbruto
            $this->updateSort($this->totiva105); // totiva105
            $this->updateSort($this->totiva21); // totiva21
            $this->updateSort($this->totimp); // totimp
            $this->updateSort($this->totcomis); // totcomis
            $this->updateSort($this->totneto105); // totneto105
            $this->updateSort($this->totneto21); // totneto21
            $this->updateSort($this->tipoiva); // tipoiva
            $this->updateSort($this->porciva); // porciva
            $this->updateSort($this->nrengs); // nrengs
            $this->updateSort($this->fechahora); // fechahora
            $this->updateSort($this->usuario); // usuario
            $this->updateSort($this->tieneresol); // tieneresol
            $this->updateSort($this->concepto); // concepto
            $this->updateSort($this->nrodoc); // nrodoc
            $this->updateSort($this->tcompsal); // tcompsal
            $this->updateSort($this->seriesal); // seriesal
            $this->updateSort($this->ncompsal); // ncompsal
            $this->updateSort($this->en_liquid); // en_liquid
            $this->updateSort($this->CAE); // CAE
            $this->updateSort($this->CAEFchVto); // CAEFchVto
            $this->updateSort($this->Resultado); // Resultado
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
                $this->codnum->setSort("");
                $this->tcomp->setSort("");
                $this->serie->setSort("");
                $this->ncomp->setSort("");
                $this->fecval->setSort("");
                $this->fecdoc->setSort("");
                $this->fecreg->setSort("");
                $this->cliente->setSort("");
                $this->cpago->setSort("");
                $this->fecvenc->setSort("");
                $this->direc->setSort("");
                $this->dnro->setSort("");
                $this->pisodto->setSort("");
                $this->codpost->setSort("");
                $this->codpais->setSort("");
                $this->codprov->setSort("");
                $this->codloc->setSort("");
                $this->telef->setSort("");
                $this->codrem->setSort("");
                $this->estado->setSort("");
                $this->emitido->setSort("");
                $this->moneda->setSort("");
                $this->totneto->setSort("");
                $this->totbruto->setSort("");
                $this->totiva105->setSort("");
                $this->totiva21->setSort("");
                $this->totimp->setSort("");
                $this->totcomis->setSort("");
                $this->totneto105->setSort("");
                $this->totneto21->setSort("");
                $this->tipoiva->setSort("");
                $this->porciva->setSort("");
                $this->nrengs->setSort("");
                $this->fechahora->setSort("");
                $this->usuario->setSort("");
                $this->tieneresol->setSort("");
                $this->leyendafc->setSort("");
                $this->concepto->setSort("");
                $this->nrodoc->setSort("");
                $this->tcompsal->setSort("");
                $this->seriesal->setSort("");
                $this->ncompsal->setSort("");
                $this->en_liquid->setSort("");
                $this->CAE->setSort("");
                $this->CAEFchVto->setSort("");
                $this->Resultado->setSort("");
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

        // "detail_detfac"
        $item = &$this->ListOptions->add("detail_detfac");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'detfac');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails && $this->ListOptions->detailVisible();
            $item->OnLeft = true;
            $item->ShowInButtonGroup = false;
            $this->ListOptions->hideDetailItems();
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("detfac");
        $this->DetailPages = $pages;

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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"cabfac\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"cabfac\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"cabfac\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fcabfaclist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fcabfaclist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_detfac"
        $opt = $this->ListOptions["detail_detfac"];
        if ($Security->allowList(CurrentProjectID() . 'detfac')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("detfac", "TblCaption");
            if (!$this->ShowMultipleDetails) { // Skip loading record count if show multiple details
                $detailTbl = Container("detfac");
                $detailFilter = $detailTbl->getDetailFilter($this);
                $detailTbl->setCurrentMasterTable($this->TableVar);
                $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                $body .= "&nbsp;" . str_replace(["%c", "%s"], [Container("detfac")->Count, "white"], $Language->phrase("DetailCount"));
            }
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("DetfacList?" . Config("TABLE_SHOW_MASTER") . "=cabfac&" . GetForeignKeyUrl("fk_tcomp", $this->tcomp->CurrentValue) . "&" . GetForeignKeyUrl("fk_serie", $this->serie->CurrentValue) . "&" . GetForeignKeyUrl("fk_ncomp", $this->ncomp->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("DetfacGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'cabfac')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=detfac");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "detfac";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'cabfac')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=detfac");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "detfac";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $Security->allowAdd(CurrentProjectID() . 'cabfac')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=detfac");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "detfac";
            }
            if ($links != "") {
                $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            } else {
                $body = preg_replace('/\b\s+dropdown-toggle\b/', "", $body);
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-dropdown-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
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

        // Preview extension
        $links = "";
        $detailFilters = [];
        $masterKeys = []; // Reset
        $masterKeys["tcomp"] = strval($this->tcomp->DbValue);
        $masterKeys["serie"] = strval($this->serie->DbValue);
        $masterKeys["ncomp"] = strval($this->ncomp->DbValue);

        // Column "detail_detfac"
        if ($this->DetailPages?->getItem("detfac")?->Visible && $Security->allowList(CurrentProjectID() . 'detfac')) {
            $link = "";
            $option = $this->ListOptions["detail_detfac"];
            $detailTbl = Container("detfac");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "DetfacPreview?t=cabfac&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"detfac\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group btn-group btn-group-sm d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'cabfac')) {
                $label = $Language->tablePhrase("detfac", "TblCaption");
                $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                $detailFilters[$detailTbl->TableVar] = $detailFilter;
                $label .= "&nbsp;" . JsEncode(str_replace(["%c", "%s"], [$detailTbl->Count, "white"], $Language->phrase("DetailCount")));
                $url .= "&detailfilters=%f";
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"detfac\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("DetfacList?" . Config("TABLE_SHOW_MASTER") . "=cabfac");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("detfac", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $caption .= "&nbsp;" . $title;
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</button>";
            }
            $detailPageObj = Container("DetfacGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'cabfac')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=detfac"));
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</button>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'cabfac')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=detfac"));
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($editurl) . "\">" . $caption . "</button>";
            }
            if ($detailPageObj->DetailAdd && $Security->canAdd() && $Security->allowAdd(CurrentProjectID() . 'cabfac')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $copyurl = GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=detfac"));
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($copyurl) . "\">" . $caption . "</button>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $link = "<li class=\"nav-item\">" . $btngrp . $link . "</li>";  // Note: Place $btngrp before $link
                $links .= $link;
                $option->Body .= "<div class=\"ew-preview d-none\">" . $link . "</div>";
            }
        }
        foreach ($this->ListOptions as $option) {
            if (str_starts_with($option->Name, "detail_") && str_contains($option->Body, "&detailfilters=%f")) {
                if (count($detailFilters) > 0) {
                    $encryptedFilters = Encrypt(JsonEncode($detailFilters));
                    $option->Body = str_replace("&detailfilters=%f", "&detailfilters=" . $encryptedFilters, $option->Body);
                    $links = str_replace("&detailfilters=%f", "&detailfilters=" . $encryptedFilters, $links);
                } else {
                    $option->Body = str_replace("&detailfilters=%f", "", $option->Body);
                    $links = str_replace("&detailfilters=%f", "", $links);
                }
            }
        }

        // Add row attributes for expandable row
        if ($this->RowType == RowType::VIEW) {
            $this->RowAttrs["data-widget"] = "expandable-table";
            $this->RowAttrs["aria-expanded"] = "false";
        }

        // Column "preview"
        $option = $this->ListOptions["preview"];
        if (!$option) { // Add preview column
            $option = &$this->ListOptions->add("preview");
            $option->OnLeft = true;
            $checkboxPos = $this->ListOptions->itemPos("checkbox");
            $pos = $checkboxPos === false
                ? ($option->OnLeft ? 0 : -1)
                : ($option->OnLeft ? $checkboxPos + 1 : $checkboxPos);
            $option->moveTo($pos);
            $option->Visible = !($this->isExport() || $this->isGridAdd() || $this->isGridEdit() || $this->isMultiEdit());
            $option->ShowInDropDown = false;
            $option->ShowInButtonGroup = false;
        }
        if ($option) {
            $icon = "fa-solid fa-caret-right fa-fw"; // Right
            if (property_exists($this, "MultiColumnLayout") && $this->MultiColumnLayout == "table") {
                $option->CssStyle = "width: 1%;";
                if (!$option->OnLeft) {
                    $icon = preg_replace('/\\bright\\b/', "left", $icon);
                }
            }
            if (IsRTL()) { // Reverse
                if (preg_match('/\\bleft\\b/', $icon)) {
                    $icon = preg_replace('/\\bleft\\b/', "right", $icon);
                } elseif (preg_match('/\\bright\\b/', $icon)) {
                    $icon = preg_replace('/\\bright\\b/', "left", $icon);
                }
            }
            $option->Body = "<i role=\"button\" class=\"ew-preview-btn expandable-table-caret ew-icon " . $icon . "\"></i>" .
                "<div class=\"ew-preview d-none\">" . $links . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }

        // Column "details" (Multiple details)
        $option = $this->ListOptions["details"];
        if ($option) {
            $option->Body .= "<div class=\"ew-preview d-none\">" . $links . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }
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
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"cabfac\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
        $item = &$option->add("detailadd_detfac");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=detfac");
        $detailPage = Container("DetfacGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'cabfac') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "detfac";
        }

        // Add multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$option->add("detailsadd");
            $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
            $caption = $Language->phrase("AddMasterDetailLink");
            $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
            $item->Visible = $detailTableLink != "" && $Security->canAdd();
            // Hide single master/detail items
            $ar = explode(",", $detailTableLink);
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                if ($item = $option["detailadd_" . $ar[$i]]) {
                    $item->Visible = false;
                }
            }
        }
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "codnum");
            $this->createColumnOption($option, "tcomp");
            $this->createColumnOption($option, "serie");
            $this->createColumnOption($option, "ncomp");
            $this->createColumnOption($option, "fecval");
            $this->createColumnOption($option, "fecdoc");
            $this->createColumnOption($option, "fecreg");
            $this->createColumnOption($option, "cliente");
            $this->createColumnOption($option, "direc");
            $this->createColumnOption($option, "dnro");
            $this->createColumnOption($option, "pisodto");
            $this->createColumnOption($option, "codpost");
            $this->createColumnOption($option, "codpais");
            $this->createColumnOption($option, "codprov");
            $this->createColumnOption($option, "codloc");
            $this->createColumnOption($option, "telef");
            $this->createColumnOption($option, "codrem");
            $this->createColumnOption($option, "estado");
            $this->createColumnOption($option, "emitido");
            $this->createColumnOption($option, "moneda");
            $this->createColumnOption($option, "totneto");
            $this->createColumnOption($option, "totbruto");
            $this->createColumnOption($option, "totiva105");
            $this->createColumnOption($option, "totiva21");
            $this->createColumnOption($option, "totimp");
            $this->createColumnOption($option, "totcomis");
            $this->createColumnOption($option, "totneto105");
            $this->createColumnOption($option, "totneto21");
            $this->createColumnOption($option, "tipoiva");
            $this->createColumnOption($option, "porciva");
            $this->createColumnOption($option, "nrengs");
            $this->createColumnOption($option, "fechahora");
            $this->createColumnOption($option, "usuario");
            $this->createColumnOption($option, "tieneresol");
            $this->createColumnOption($option, "concepto");
            $this->createColumnOption($option, "nrodoc");
            $this->createColumnOption($option, "tcompsal");
            $this->createColumnOption($option, "seriesal");
            $this->createColumnOption($option, "ncompsal");
            $this->createColumnOption($option, "en_liquid");
            $this->createColumnOption($option, "CAE");
            $this->createColumnOption($option, "CAEFchVto");
            $this->createColumnOption($option, "Resultado");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fcabfacsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fcabfacsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fcabfaclist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_cabfac", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_cabfac",
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

        // tcomp

        // serie

        // ncomp

        // fecval

        // fecdoc

        // fecreg

        // cliente

        // cpago

        // fecvenc

        // direc

        // dnro

        // pisodto

        // codpost

        // codpais

        // codprov

        // codloc

        // telef

        // codrem

        // estado

        // emitido

        // moneda

        // totneto

        // totbruto

        // totiva105

        // totiva21

        // totimp

        // totcomis

        // totneto105

        // totneto21

        // tipoiva

        // porciva

        // nrengs

        // fechahora

        // usuario

        // tieneresol

        // leyendafc

        // concepto

        // nrodoc

        // tcompsal

        // seriesal

        // ncompsal

        // en_liquid

        // CAE

        // CAEFchVto

        // Resultado

        // usuarioultmod

        // fecultmod

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

            // fecval
            $this->fecval->HrefValue = "";
            $this->fecval->TooltipValue = "";

            // fecdoc
            $this->fecdoc->HrefValue = "";
            $this->fecdoc->TooltipValue = "";

            // fecreg
            $this->fecreg->HrefValue = "";
            $this->fecreg->TooltipValue = "";

            // cliente
            $this->cliente->HrefValue = "";
            $this->cliente->TooltipValue = "";

            // direc
            $this->direc->HrefValue = "";
            $this->direc->TooltipValue = "";

            // dnro
            $this->dnro->HrefValue = "";
            $this->dnro->TooltipValue = "";

            // pisodto
            $this->pisodto->HrefValue = "";
            $this->pisodto->TooltipValue = "";

            // codpost
            $this->codpost->HrefValue = "";
            $this->codpost->TooltipValue = "";

            // codpais
            $this->codpais->HrefValue = "";
            $this->codpais->TooltipValue = "";

            // codprov
            $this->codprov->HrefValue = "";
            $this->codprov->TooltipValue = "";

            // codloc
            $this->codloc->HrefValue = "";
            $this->codloc->TooltipValue = "";

            // telef
            $this->telef->HrefValue = "";
            $this->telef->TooltipValue = "";

            // codrem
            $this->codrem->HrefValue = "";
            $this->codrem->TooltipValue = "";

            // estado
            $this->estado->HrefValue = "";
            $this->estado->TooltipValue = "";

            // emitido
            $this->emitido->HrefValue = "";
            $this->emitido->TooltipValue = "";

            // moneda
            $this->moneda->HrefValue = "";
            $this->moneda->TooltipValue = "";

            // totneto
            $this->totneto->HrefValue = "";
            $this->totneto->TooltipValue = "";

            // totbruto
            $this->totbruto->HrefValue = "";
            $this->totbruto->TooltipValue = "";

            // totiva105
            $this->totiva105->HrefValue = "";
            $this->totiva105->TooltipValue = "";

            // totiva21
            $this->totiva21->HrefValue = "";
            $this->totiva21->TooltipValue = "";

            // totimp
            $this->totimp->HrefValue = "";
            $this->totimp->TooltipValue = "";

            // totcomis
            $this->totcomis->HrefValue = "";
            $this->totcomis->TooltipValue = "";

            // totneto105
            $this->totneto105->HrefValue = "";
            $this->totneto105->TooltipValue = "";

            // totneto21
            $this->totneto21->HrefValue = "";
            $this->totneto21->TooltipValue = "";

            // tipoiva
            $this->tipoiva->HrefValue = "";
            $this->tipoiva->TooltipValue = "";

            // porciva
            $this->porciva->HrefValue = "";
            $this->porciva->TooltipValue = "";

            // nrengs
            $this->nrengs->HrefValue = "";
            $this->nrengs->TooltipValue = "";

            // fechahora
            $this->fechahora->HrefValue = "";
            $this->fechahora->TooltipValue = "";

            // usuario
            $this->usuario->HrefValue = "";
            $this->usuario->TooltipValue = "";

            // tieneresol
            $this->tieneresol->HrefValue = "";
            $this->tieneresol->TooltipValue = "";

            // concepto
            $this->concepto->HrefValue = "";
            $this->concepto->TooltipValue = "";

            // nrodoc
            $this->nrodoc->HrefValue = "";
            $this->nrodoc->TooltipValue = "";

            // tcompsal
            $this->tcompsal->HrefValue = "";
            $this->tcompsal->TooltipValue = "";

            // seriesal
            $this->seriesal->HrefValue = "";
            $this->seriesal->TooltipValue = "";

            // ncompsal
            $this->ncompsal->HrefValue = "";
            $this->ncompsal->TooltipValue = "";

            // en_liquid
            $this->en_liquid->HrefValue = "";
            $this->en_liquid->TooltipValue = "";

            // CAE
            $this->CAE->HrefValue = "";
            $this->CAE->TooltipValue = "";

            // CAEFchVto
            $this->CAEFchVto->HrefValue = "";
            $this->CAEFchVto->TooltipValue = "";

            // Resultado
            $this->Resultado->HrefValue = "";
            $this->Resultado->TooltipValue = "";

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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fcabfaclist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fcabfaclist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fcabfaclist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fcabfaclist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fcabfacsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

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
