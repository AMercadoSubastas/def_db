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
class LotesDelete extends Lotes
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "LotesDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "LotesDelete";

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
        $this->descripcion->Visible = false;
        $this->descor->setVisibility();
        $this->observ->setVisibility();
        $this->usuario->setVisibility();
        $this->fecalta->setVisibility();
        $this->secuencia->setVisibility();
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
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
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
        $this->setupLookupOptions($this->codrem);
        $this->setupLookupOptions($this->estado);
        $this->setupLookupOptions($this->dir_secuencia);

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("LotesList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Param("action") !== null) {
            $this->CurrentAction = Param("action") == "delete" ? "delete" : "show";
        } else {
            $this->CurrentAction = $this->InlineDelete ?
                "delete" : // Delete record directly
                "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsJsonResponse()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsJsonResponse()) {
                    $this->terminate();
                    return;
                }
                // Return JSON error message if UseAjaxActions
                if ($this->UseAjaxActions) {
                    WriteJson(["success" => false, "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                }
                if ($this->InlineDelete) {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->CurrentAction = "show"; // Display record
                }
            }
        }
        if ($this->isShow()) { // Load records for display
            $this->Recordset = $this->loadRecordset();
            if ($this->TotalRecords <= 0) { // No record found, exit
                $this->Recordset?->free();
                $this->terminate("LotesList"); // Return to list
                return;
            }
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

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

        // usuarioultmod

        // fecultmod

        // dir_secuencia

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

            // usuarioultmod
            $this->usuarioultmod->HrefValue = "";
            $this->usuarioultmod->TooltipValue = "";

            // fecultmod
            $this->fecultmod->HrefValue = "";
            $this->fecultmod->TooltipValue = "";

            // dir_secuencia
            $this->dir_secuencia->HrefValue = "";
            $this->dir_secuencia->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
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
        if ($this->UseTransaction) {
            $conn->beginTransaction();
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
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
        }

        // Write JSON response
        if ((IsJsonResponse() || ConvertToBool(Param("infinitescroll"))) && $deleteRows) {
            $rows = $this->getRecordsFromRecordset($rsold);
            $table = $this->TableVar;
            if (Param("key_m") === null) { // Single delete
                $rows = $rows[0]; // Return object
            }
            WriteJson(["success" => true, "action" => Config("API_DELETE_ACTION"), $table => $rows]);
        }
        return $deleteRows;
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
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
