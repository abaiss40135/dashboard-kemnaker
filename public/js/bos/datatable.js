function generateDataTable(options) {
    const table = options.selector;
    table.DataTable().clear();
    table.DataTable().destroy();
    table.DataTable({
        dom: options.dom ?? "lfrtip",
        paging: options.paging ?? true,
        order: options.order ?? [],
        stateSave: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        processing: true,
        searching: options.searching ?? true,
        language: {
            processing:
                '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            lengthMenu: "_MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Halaman _PAGE_ sampai _PAGES_ dari _MAX_ data",
            infoEmpty: "Hasil pencarian nihil",
            infoFiltered: "(disaring dari _MAX_ total data)",
            search: "Cari",
            paginate: {
                previous: '<i class="fa fa-angle-left"></i> Sebelumnya',
                first: '<i class="fa fa-angle-double-left"></i> Pertama',
                last: 'Terakhir <i class="fa fa-angle-double-right"></i> ',
                next: 'Selanjutnya <i class="fa fa-angle-right"></i> ',
            },
        },
        ajax: {
            url: options.url,
            data: options.data ?? function (d) {},
            beforeSend: function () {
                table.hide();
            },
            complete: function () {
                table.show();
                table.DataTable().responsive.recalc();
            },
        },
        columns: options.columns,
        createdRow: function (row, data, index) {
            /** set width 24% last td in row (action-column) */
            $("td:last", row).addClass("action-column");
        },
        columnDefs: options.columnDefs,
        rowCallback: options.rowCallback,
        initComplete: function (settings = null, json = null) {
            debounceFilterInput(this);
            options.hasOwnProperty("initComplete")
                ? options.initComplete(settings, json)
                : "";
        },
    });
}

$.fn.dataTable.ext.errMode = function (settings, tn, msg) {
    if (settings && settings.jqXHR && settings.jqXHR.status === 401) {
        Swal.fire({
            title: "Sesi anda telah berakhir!",
            text: "Silahkan login kembali.",
            icon: "warning",
        }).then((result) => {
            location.href = "/login";
        });
    } else {
        swalError(msg);
    }
};

function debounceFilterInput(obj, timeout = 1500) {
    var api = obj.api();
    var searchWait = 0;
    var searchWaitInterval;
    // Grab the datatables input box and alter how it is bound to events
    $(".dataTables_filter input")
        .unbind() // Unbind previous default bindings
        .bind("input", function (e) {
            // Bind our desired behavior
            var item = $(this);
            searchWait = 0;
            if (!searchWaitInterval)
                searchWaitInterval = setInterval(function () {
                    searchTerm = $(item).val();
                    // if(searchTerm.length >= 3 || e.keyCode == 13) {
                    clearInterval(searchWaitInterval);
                    searchWaitInterval = "";
                    // Call the API search function
                    api.search(searchTerm).draw();
                    searchWait = 0;
                    // }
                    searchWait++;
                }, timeout);
            return;
        });
}
