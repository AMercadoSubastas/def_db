/*!
 * Infinite Scroll for PHPMaker v24.13.0
 * Copyright (c) e.World Technology Limited. All rights reserved.
 */
(function ($, ew) {
  'use strict';

  function _typeof(o) {
    "@babel/helpers - typeof";

    return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
      return typeof o;
    } : function (o) {
      return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
    }, _typeof(o);
  }

  function toPrimitive(t, r) {
    if ("object" != _typeof(t) || !t) return t;
    var e = t[Symbol.toPrimitive];
    if (void 0 !== e) {
      var i = e.call(t, r || "default");
      if ("object" != _typeof(i)) return i;
      throw new TypeError("@@toPrimitive must return a primitive value.");
    }
    return ("string" === r ? String : Number)(t);
  }

  function toPropertyKey(t) {
    var i = toPrimitive(t, "string");
    return "symbol" == _typeof(i) ? i : String(i);
  }

  function _defineProperty(obj, key, value) {
    key = toPropertyKey(key);
    if (key in obj) {
      Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
      });
    } else {
      obj[key] = value;
    }
    return obj;
  }

  /**
   * InfiniteScroll
   */
  let InfiniteScroll = /*#__PURE__*/function () {
    /**
     * Constructor
     * @param {string} id Container ID
     * @param {Object} options Options
     * @param {string} options.threshold Specifies a set of offsets to add to the root's bounding box when calculating intersections. Default is "0px 0px 0px 0px".
     * @param {number[]} options.rootMargin An array of numbers between 0.0 and 1.0, specifying a ratio of intersection area to total bounding box area for the observed target. Default is [0, 0.25].
     * @param {number} options.pageCount Page count
     */
    function InfiniteScroll(id, options) {
      var _this$options, _this$options$rootMar, _this$options2, _this$options2$thresh;
      this.container = document.getElementById(id), this.table = this.getTable();
      if (!this.table || !this.table.rows || !this.container || !this.container.classList.contains("ew-grid-middle-panel")) return;
      this.options = options || {}, this.pageCount = options.pageCount;
      (_this$options$rootMar = (_this$options = this.options).rootMargin) != null ? _this$options$rootMar : _this$options.rootMargin = InfiniteScroll.rootMargin, (_this$options2$thresh = (_this$options2 = this.options).threshold) != null ? _this$options2$thresh : _this$options2.threshold = InfiniteScroll.threshold, this.$document = $(document), this.$container = $(this.container).addClass("table-responsive"), this.$grid = this.$container.closest(".ew-grid"), this.$panels = this.$grid.find(".ew-grid-lower-panel, .ew-grid-upper-panel").innerWidth("100%"), this.$form = this.$grid.closest(".ew-form:not(.ew-list-form)"), this.$detailPages = this.$grid.closest(".ew-detail-pages").addClass("d-block"),
      // Reset from "table" to "block"
      this.$tabPane = this.$grid.closest(".tab-pane"), this.$tab = this.$detailPages.find("a[data-bs-toggle=tab][href='#" + this.$tabPane.attr("id") + "']"), this.$collapse = this.$grid.closest(".collapse"), this.isActive = this.$tab.hasClass("show") || this.$collapse.hasClass("show") || !this.$detailPages[0], this.isDetail = !!this.$form[0];
      if (this.isDetail && !this.isActive) {
        // Is detail grid but not active
        this.$tab.on("shown.bs.tab", this.init.bind(this));
        this.$collapse.on("shown.bs.collapse", this.init.bind(this));
      } else {
        this.init();
      }
    }

    /**
     * Get table
     * @returns {HTMLTableElement} Table
     */
    var _proto = InfiniteScroll.prototype;
    _proto.getTable = function getTable() {
      var _this$container;
      return (_this$container = this.container) == null ? void 0 : _this$container.querySelector("table.ew-table.ew-infinite-scroll-table");
    }

    /**
     * Get width
     * @returns {string} Width
     */;
    _proto.getWidth = function getWidth() {
      return ew.isMobile() ? "100%" : ""; // Use width = 100% for mobile
    }

    /**
     * Get URL
     * @param {number} page
     * @returns {string} URL
     */;
    _proto.getUrl = function getUrl(page) {
      return ew.currentPage() + "?" + ew.TABLE_PAGE_NUMBER + "=" + page;
    }

    /**
     * Get request parameters
     * @returns {URLSearchParams}
     */;
    _proto.getParams = function getParams() {
      return new URLSearchParams([[ew.TOKEN_NAME_KEY, ew.TOKEN_NAME],
      // Add token name // PHP
      [ew.ANTIFORGERY_TOKEN_KEY, ew.ANTIFORGERY_TOKEN],
      // Add antiforgery token // PHP
      [ew.PAGE_LAYOUT, "false"], ["infinitescroll", "1"]]);
    }

    /**
     * Set current page
     * @param {number} page Current page number
     */;
    _proto.setCurrentPage = function setCurrentPage(page) {
      this.currentPage = page;
      history.replaceState(null, "", this.getUrl(page));
    }

    /**
     * Observe element
     * @param {HTMLElement} el Element to observe
     */;
    _proto.observe = function observe(el) {
      if (!this.observer) {
        this.observer = new IntersectionObserver(entries => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              let el = entry.target;
              if (el.matches("tr")) {
                // Table row
                let tbody = el.closest("tbody[data-page]");
                if (!tbody.nextElementSibling && !tbody.closest(".ew-grid.ew-loading"))
                  // No next page and not loading
                  this.load(parseInt(tbody.dataset.page, 10));
              } else if (el.matches("tbody[data-page]") && entry.intersectionRatio > (this.options.threshold[1] || InfiniteScroll.threshold[1])) {
                // Table body
                this.setCurrentPage(parseInt(el.dataset.page, 10));
              }
            }
          });
        }, {
          root: this.container,
          rootMargin: this.options.rootMargin,
          threshold: this.options.threshold
        });
      }
      if (!el) return;
      this.observer.observe(el);
    }

    /**
     * Observe table body element and the nth-to-last row element
     * @param {HTMLElement} tbody
     */;
    _proto.observeTableBody = function observeTableBody(tbody) {
      this.observe(tbody); // Observe the tbody
      let count = Math.max(InfiniteScroll.countToLast, 1) || 1;
      for (let i = 1; i <= count; i++) this.observe(tbody.querySelector(":scope > tr:nth-last-child(" + i + ")")); // Observe the nth-to-last row
    }

    /**
     * Load next page
     * @param {number} page Current page index
     */;
    _proto.load = function load(page) {
      if (page >= this.pageCount) return;
      if (this.$grid.find("[data-rowtype=" + ew.ROWTYPE_ADD + "], [data-rowtype=" + ew.ROWTYPE_EDIT + "]")[0])
        // Inline/Grid-Add/Edit
        return;
      let $overlay = $(ew.overlayTemplate());
      this.$grid.addClass("ew-loading").append($overlay);
      fetch(this.getUrl(++page), {
        method: "POST",
        body: this.getParams()
      }).then(async response => {
        let $html = $("<div>" + (await response.text()) + "</div>"),
          $main = $html.find(".list"),
          main = $main[0],
          $tbody = $html.find(".ew-infinite-scroll-table > tbody[data-page]"),
          tbody = $tbody[0];
        if (tbody) {
          InfiniteScroll.replaceSelectors.forEach(selector => $(selector).html($html.find(selector).html())); // Replace contents
          InfiniteScroll.appendSelectors.forEach(selector => $(selector).append($html.find(selector).html())); // Append contents
          let e = $.Event({
            type: "load.ew",
            target: main
          });
          this.table.appendChild(tbody); // Append tbody
          ew.initPage(e);
          this.$document.trigger(e);
          Array.from(this.table.rows).forEach((row, i) => row.dataset.rowindex = i); // Update row index
          this.observeTableBody(tbody);
        }
      }).finally(() => this.$grid.removeClass("ew-loading").find($overlay).remove());
    }

    /**
     * Set up table
     */;
    _proto.setupTable = function setupTable() {
      // Setup the table
      this.table = this.getTable();
      ew.setupTable(this.table);

      // Check last row
      if (this.table.rows && this.container.clientHeight > this.table.offsetHeight) {
        let $rows = $(this.table.rows).filter(":not(.ew-template)"),
          n = $rows.filter("[data-rowindex=1]").length || $rows.filter("[data-rowindex=0]").length || 1;
        $rows.slice(-1 * n).find("td.ew-table-last-row").removeClass("ew-table-last-row").addClass("ew-table-border-bottom");
      }

      // Observe the tbody and the nth-to-last row
      let tbody = this.table.querySelector("tbody[data-page]");
      !tbody || this.observeTableBody(tbody);
    }

    /**
     * Init
     */;
    _proto.init = function init() {
      if (this.$container.data("InfiniteScroll")) return;

      // Add handlers to send infinitescroll=1 (jQuery)
      $(document).on("ajaxSend", function (event, jqxhr, settings) {
        let data = settings.data;
        if ($.isString(data) && data.startsWith("[{") && data.endsWith("}]")) {
          // Check if jQuery batch request
          let ar = ew.parseJson(data);
          if (Array.isArray(ar)) settings.data = JSON.stringify(ar.map(req => ({
            ...req,
            infinitescroll: 1
          })));
        } else {
          if (settings.multipart)
            // jQuery file upload
            settings.contentType = "multipart/form-data";
          if (settings.data instanceof FormData) settings.data.set("infinitescroll", "1");else settings.data = ew.mergeSearchParams(data, {
            infinitescroll: 1
          });
        }
      });

      // Add handlers to send infinitescroll=1 (ew.fetch)
      $(document).on("fetch", function (e, args) {
        var _args$init;
        (_args$init = args.init) != null ? _args$init : args.init = {};
        if (!args.init.method || ew.sameText(args.init.method, "GET")) {
          // GET
          args.url = ew.setSearchParams(args.url, {
            infinitescroll: 1
          });
        } else {
          // POST
          if (args.init.body instanceof FormData) args.init.body.set("infinitescroll", "1");else args.init.body = ew.mergeSearchParams(args.init.body, {
            infinitescroll: 1
          });
        }
      });

      // Width
      let width = this.getWidth();

      // Set form width same as grid
      if (this.isDetail && width) this.$form.addClass("w-100");

      // Adjust the width of the container
      if (this.isDetail || ew.isMobile()) this.$grid.addClass("d-block");

      // Set up table
      this.setupTable();

      // Listen to refresh event (e.g. after sorting)
      this.$document.on("refresh.ew", e => {
        let grid = e.target;
        if (this.$grid[0] == grid) {
          let content = grid.querySelector(".ew-grid-middle-panel");
          content.scrollTop = 0;
          this.setupTable();
        }
      });

      // Save the instance
      this.$container.data("InfiniteScroll", this);
    };
    return InfiniteScroll;
  }(); // Extend
  // IntersectionObserver
  // Integer
  // Integer
  _defineProperty(InfiniteScroll, "countToLast", 1);
  // Load next page when the nth-to-last row of current page is visible. Default is 1 (the last row).
  _defineProperty(InfiniteScroll, "rootMargin", "0px");
  _defineProperty(InfiniteScroll, "threshold", [0, 0.25]);
  _defineProperty(InfiniteScroll, "replaceSelectors", [".ew-infinite-scroll-grid .ew-grid-upper-panel .ew-pager-end", ".ew-infinite-scroll-table thead", ".ew-infinite-scroll-grid .ew-grid-lower-panel .ew-pager-end"]);
  _defineProperty(InfiniteScroll, "appendSelectors", [".ew-debug .card-body"]);
  Object.assign(ew, {
    InfiniteScroll
  });

})(jQuery, ew);
