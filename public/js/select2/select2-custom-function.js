function buildSelect2(data) {
    const options = {
        theme: "bootstrap-5",
        language: "id",
        allowClear: data.allowClear ?? true,
        tags: data.tags ?? false,
        tokenSeparators: [",", "#"],
        templateResult: data.templateResult,
        minimumInputLength: data.minimumInputLength ?? 0,
        minimumResultsForSearch: data.minimumResultsForSearch ?? 1,
        placeholder: data.placeholder,
        dropdownAutoWidth: true,
        width: data.width ?? "auto",
        data: data.data,
    };

    mappingItemSelect2(data, options);
}

function buildSelect2Search(data) {
    const options = {
        theme: "bootstrap-5",
        language: "id",
        allowClear: true,
        placeholder: data.placeholder,
        dropdownAutoWidth: true,
        width: data?.width ?? "auto",
        minimumInputLength: data.minimumInputLength ?? 3,
        minimumResultsForSearch: data.minimumResultsForSearch ?? 1,
        tags: data.tags ?? false,
        tokenSeparators: [",", "#"],
        templateResult: data.templateResult,
        ajax: {
            dataType: "json",
            url: data.url,
            data: data.query,
            processResults: function (data) {
                return {
                    results: data,
                };
            },
            delay: 800,
            cache: true,
        },
        createTag:
            data.createTag ??
            ((params) => {
                let term = $.trim(params.term);
                if (term === "") {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true, // add additional parameters
                };
            }),
        insertTag:
            data.insertTag ??
            ((data, tag) => {
                // Insert the tag at the end of the results
                data.push(tag);
            }),
    };

    mappingItemSelect2(data, options);
}

function buildSelect2PaginateSearch(data) {
    const options = {
        theme: "bootstrap-5",
        language: "id",
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
        allowClear: true,
        placeholder: data.placeholder,
        dropdownAutoWidth: true,
        width: "auto",
        minimumInputLength: data.minimumInputLength ?? 3,
        minimumResultsForSearch: data.minimumResultsForSearch ?? 1,
        tags: data.tags ?? false,
        tokenSeparators: [",", "#"],
        templateResult: data.templateResult,
        ajax: {
            dataType: "json",
            url: data.url,
            data: data.query,
            processResults: function (data) {
                return {
                    results: data.results,
                    pagination: data.pagination,
                };
            },
            delay: 800,
            cache: true,
        },
    };

    mappingItemSelect2(data, options);
}

function mappingItemSelect2(data, options) {
    data.selector.map((item) => {
        if (item.modal) {
            item.id.select2(
                Object.assign(options, {
                    dropdownParent: item.modal,
                })
            );
        } else {
            item.id.select2(options);
        }
    });
}
