<!-- DataTables -->
<link rel="stylesheet" href="{{ asset( 'vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css' )  }}">
<link rel="stylesheet" href="{{ asset( 'vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css' )  }}">
<link rel="stylesheet" href="{{ asset( 'vendor/datatables.net-autofill-bs4/css/autoFill.bootstrap4.min.css' )  }}">
<link rel="stylesheet" href="{{ asset( 'vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css' )  }}">
<link rel="stylesheet" href="{{ asset( 'vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css' )  }}">
<style>
    .dataTables_processing {
        z-index: 999 !important;
    }

    div.dataTables_filter,
    div.dataTables_length, div.dataTables_info, div.dataTables_paginate {
        display: inline-block;
    }

    div.dataTables_filter, div.dataTables_paginate {
        float: right;
    }
</style>
