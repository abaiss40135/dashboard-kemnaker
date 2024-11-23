function initMap(taggedMap = []) {
    $("#vmap").html("");
    $("#vmap").vectorMap({
        map: "indonesia_id",
        enableZoom: true,
        showTooltip: true,
        backgroundColor: "#a5bfdd",
        color: "#1fa603",
        borderColor: "#818181",
        hoverOpacity: 0.7,
        selectedColor: "#c10606",
        scaleColors: ["#2e6322", "#519931"],
        onRegionClick: function(event, code, region) {
            if (region.toUpperCase() == "YOGYAKARTA") {
                region = "Daerah Istimewa Yogyakarta";
            }
            window.localStorage.setItem(
                "selected-region",
                region.toUpperCase()
            );
            getDataPoldaAjax(region.toUpperCase());
        },
        onRegionSelect: function(evt, code, region) {
            //     if (region.toUpperCase() == "YOGYAKARTA") {
            //         region = "Daerah Istimewa Yogyakarta";
            //     }
            //     window.localStorage.setItem(
            //         "selected-region",
            //         region.toUpperCase()
            //     );
            //     getDataPoldaAjax(region.toUpperCase());
        },
        onRegionDeselect: function(event, code, region) {
            window.localStorage.removeItem("selected-region");
            $("#pagination-laporan").twbsPagination("destroy");
        },
        selectedRegions: Object.values(taggedMap)
    });
}
