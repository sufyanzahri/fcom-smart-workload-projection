(function ($) {
  'use strict';
  $(function () {
    $('#order-listing').DataTable({
      "aLengthMenu": [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
      ],
      responsive: true,
      "scrollY": 310,
      "iDisplayLength": 5,
      "bLengthChange": false,
      "language": {
        search: "Sort By :"
      }
    });
    $('#order-listing').each(function () {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Sort');
      // search_input.removeClass('form-control-sm');
      var s = datatable.closest('.dataTables_wrapper').find(".dataTables_filter").append('<button type="button" class="btn btn-primary ml-2">New Record</button>');
    });
  });
  $(function () {
    $('#fixed-column').DataTable({
      "aLengthMenu": [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
      ],
      columnDefs: [{
        orderable: false,
        targets: [1]
      }],
      fixedHeader: {
        header: false,
        footer: true
      },
      scrollY: 300,
      scrollX: true,
      scrollCollapse: true,
      paging: false,
      fixedColumns: true,
      "iDisplayLength": 10,
      "bLengthChange": false,
      "language": {
        search: "Sort By :"
      }
    });
    $('#fixed-column').each(function () {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Sort');
      // search_input.removeClass('form-control-sm');
      var s = datatable.closest('.dataTables_wrapper').find(".dataTables_filter").append('<button type="button" class="btn btn-primary ml-2">New Record</button>');
    });
  });
})(jQuery);