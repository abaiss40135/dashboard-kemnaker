document.getElementById("btn-search").addEventListener("click", (event) => {
    event.preventDefault();

    if ($(".table-data-polsus").hasClass("d-none")) {
        laporanDetailPolsus();
    } else {
        $(".table-detail-polsus").addClass("d-none");
        $(".table-data-polsus").removeClass("d-none");
        $(".init-view-btn").addClass("d-none");

        listLaporan.updateState(
            "provinsi",
            document.querySelector('select[name="provinsi"]').value
        );
        listLaporan.updateState(
            "kabupaten",
            document.querySelector('select[name="kabupaten"]').value
        );
        listLaporan.updateState(
            "filter_kl",
            document.querySelector('select[name="filter_kl"]').value
        );
        listLaporan.updateState("page", 1);
        listLaporan.fetchData();
    }
});

const dataDetailPolsus = [];
const detailPolsus = function (el) {
    $(".search-form-detail-polsus").removeClass("d-none");
    $(".table-detail-polsus").removeClass("d-none");
    $(".init-view-btn").removeClass("d-none");

    $(".table-data-polsus").addClass("d-none");
    $(".search-form-general").addClass("d-none");

    const dataPolsus = $(el).data("polsuswilayah").split(",");
    dataDetailPolsus["jenis_polsus"] = dataPolsus[0];
    dataDetailPolsus["attribute"] = dataPolsus[1];
    dataDetailPolsus["provinsi"] = dataPolsus[2];
    dataDetailPolsus["kotakab"] = dataPolsus[3];
    dataDetailPolsus["jenjang_diklat"] = dataPolsus[4];

    laporanDetailPolsus();
};

let test = undefined;

const laporanDetailPolsus = () => {
    if (!test)
        test = new ComponentWithPagination({
            contentWrapper: "#content-wrapper-detail-polsus",
            messageWrapper: "#message-wrapper-detail-polsus",
            paginator: "#paginator-wrapper-detail-polsus",
            loader: "#shimmer-wrapper-detail-polsus",
            searchState: {
                url: route("sipolsus.detail-polsus"),
                data: {
                    _token: document.querySelector('meta[name="csrf-token"]')
                        .content,
                    jenis_polsus: dataDetailPolsus["jenis_polsus"],
                    attribute: dataDetailPolsus["attribute"],
                    jenjang_diklat: dataDetailPolsus["jenjang_diklat"],
                    provinsi: dataDetailPolsus["provinsi"],
                    kotakab: dataDetailPolsus["kotakab"],
                    search: document.querySelector('input[name="search"]')
                        .value,
                },
            },
            content: (item, rowNumber) => {
                return `
                                <tr>
                                    <td class="align-middle text-center">${rowNumber}</td>
                                    <td class="align-middle text-center">${
                                        item.nama
                                    }</td>
                                    <td class="align-middle text-center table-data-instansi" data-instansi_id="${
                                        item.instansi_id
                                    }">${item?.instansi?.instansi}</td>
                                    <td class="align-middle text-center table-data-kategori d-none">${
                                        item.kategori?.length
                                            ? item.kategori
                                            : "-"
                                    }</td>
                                    <td class="align-middle text-center">${
                                        item.pangkat
                                    }</td>
                                    <td class="align-middle text-center">${
                                        item.golongan
                                    }</td>
                                    <td class="align-middle text-center">${
                                        item.jabatan
                                    }</td>
                                    <td class="align-middle text-center">${
                                        item.no_nip
                                    }</td>
                                    <td class="align-middle text-center">${
                                        item.no_kta?.length ? item.no_kta : "-"
                                    }</td>
                                    <td class="align-middle text-center">${item.detail_alamat.toUpperCase()}, ${item.desa.toUpperCase()}, ${item.kecamatan.toUpperCase()}, ${item.kabupaten.toUpperCase()}, ${item.provinsi.toUpperCase()}    </td>
                                </tr>
                            `;
            },
            completeEvent: () => {
                const instansiId = $(".table-data-instansi")
                    .first()
                    .data("instansi_id");
                const namaKategori = mapNamaKategoriPolsus[instansiId];
                if (namaKategori) {
                    $(".table-data-kategori").removeClass("d-none");
                    $(".kategori-polsus-head").removeClass("d-none");
                    $(".kategori-polsus-head").html(namaKategori);
                } else {
                    $(".kategori-polsus-head").addClass("d-none");
                    $(".table-data-kategori").addClass("d-none");
                }
            },
        });
    else {
        [
            "jenis_polsus",
            "attribute",
            "jenjang_diklat",
            "provinsi",
            "kotakab",
        ].forEach((e) => {
            test.updateState(e, dataDetailPolsus[e]);
        });

        test.updateState(
            "search",
            document.querySelector('input[name="search"]').value
        );
        test.updateState("page", 1);
        test.fetchData();
    }
};

const initView = (el) => {
    $(".search-form-detail-polsus input").val("");
    $(".table-detail-polsus").addClass("d-none");
    $(".search-form-detail-polsus").addClass("d-none");
    $(".table-data-polsus").removeClass("d-none");
    $(".search-form-general").removeClass("d-none");
    $(el).addClass("d-none");
};
