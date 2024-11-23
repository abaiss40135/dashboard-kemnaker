<!-- jqvmap -->
<link rel="stylesheet" href="{{ asset('vendor/jqvmap/jqvmap.min.css') }}">
<style>
    .jqvmap-zoomin, .jqvmap-zoomout {
        background: #d2d2d2 !important;
        color: #0e3f73 !important;
        box-sizing: content-box;
        border-radius: 30px !important;
        font-weight: 700 !important;
        font-size: 18px !important;
    }

    .jqvmap-label {
        position: absolute;
        display: none;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        background: white;
        color: black;
        font-family: sans-serif, Verdana;
        font-size: smaller;
        padding: 2px;
        pointer-events:none;
        border: solid 1px black;
    }

    .jqvmap-label table {
        background: #fff;
        color: black;
        margin: 10px;
    }
</style>
