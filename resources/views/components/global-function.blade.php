<script>
    const MAX_FILE_SIZE = "{{ \App\Helpers\Constants::MAX_FILE_SIZE }}"
    const MAX_FILE_SIZE_KB = "{{ \App\Helpers\Constants::MAX_FILE_SIZE_KB }}"
    const preloader = '<img class="img-fluid" alt="img-preloader" src="{{asset('img/ellipsis-preloader.gif')}}">';
    const loaderRotateContainer = document.querySelector('.loader-rotate-container')

    loaderRotateContainer.style.display = "none"

    function submitFormLoader(){
        loaderRotateContainer.style.display = "flex";
    }

    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(244, 162, 97)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(42, 157, 143)',
        blue: 'rgb(93,165,218)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)',
        brown: 'rgb(245, 203, 92)',
        black: 'rgb(36, 36, 35)',
        charcoal: 'rgb(38, 70, 83)',
        burnSienna: 'rgb(231, 111, 81)',
        pink: 'rgb(239, 71, 111)',
    };

    /**
     *  Add comma after every 3 digit
     */
    function addCommas(number){
        if(isNaN(number)) return 0;
        return Number(number).toFixed(0).replace(/./g, function(c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
        });
    }

    /*
     * Check isEmpty variable
     */
    const isEmpty = (e) => {
        switch (e) {
            case "":
            case 0:
            case "0":
            case null:
            case false:
            case typeof(e == "undefined"):
                return true;
            default:
                return false;
        }
    }

    function isObjectEmpty(value) {
        return (
            Object.prototype.toString.call(value) === '[object Object]' &&
            JSON.stringify(value) === '{}'
        );
    }

    //append new option to input select
    const appendSelectOption = (text, id = '') => new Option(text == null ? "": text, id, false, true);

    /**
     * Method untuk pilih selected option select2
     * Dipakai untuk edit pada multiple tags
     *
     * @param selectorSelect
     * @param id
     * @param text
     */
    const firstOrCreateOption = (selectorSelect ,id, text = '') => {
        // Set the value, creating a new option if necessary
        if ($(selectorSelect).find("option[value='" + id + "']").length) {
            $(selectorSelect).val(id).trigger('change');
        } else {
            // Create a DOM Option and pre-select by default
            var newOption = new Option(text, id, true, true);
            // Append it to the select
            $(selectorSelect).append(newOption).trigger('change');
        }
    }

    const swalSuccess = (message, html = "") => {
        swalSetup('Operasi Sukses', message, 'success', html);
    }
    const swalError = (message, html = "") => {
        swalSetup('Ada kesalahan', message, 'error', html);
    }
    const swalWarning = (message, html = "") => {
        swalSetup('Perhatian', message, 'warning', html);
    }
    const swalCancel = (message, html = "") => {
        swalSetup('Dibatalkan', message, 'error', html);
    }
    const swalValidation = (errors) => {
        let values = '<span>';
        jQuery.each(errors, function (key, value) {
            values += `<p>${value}</p>`;
        });
        swalError('Validation Error', values+'</span>');
    }

    const swalSetup = (title, message, type, html) => {
        Swal.fire({
            icon: type,
            title: title,
            text: message,
            html: html
        });
    }

    const titleCase = (string) => {
        let sentence = string.toLowerCase().split(" ");
        for(let i = 0; i< sentence.length; i++){
            sentence[i] = sentence[i][0].toUpperCase() + sentence[i].slice(1);
        }
        return sentence.join(" ");
    }

    const slugify = text =>
        text
            .toString()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w-]+/g, '')
            .replace(/--+/g, '-');

    function formatDate(date, format = 'Y-m-d') {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        switch (format) {
            case 'd-m-Y':
                return [day, month, year].join('-');
            case 'm-d-Y':
                return [day, month, year].join('-');
            default:
                return [year, month, day].join('-');
        }
    }

    function localDateFormat(date) {
        return new Date(date).toLocaleString("id").replace(/\//g, '-').replace(/\./g, ':')
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    // replace  default alert js to swal
    // keep default js alert to use in specific cases
    window.legacyAlert = window.alert;

    // types alert and confirm: "success", "error", "warning", "info", "question". Default: "warning"
    // overwrite default js alert
    window.alert = function(msg, title, type, params) {
        let newTitle = (title == null) ? 'Ada yang tidak beres dengan aplikasi' : title;
        let newType = (type == null) ? 'warning' : type;
        Swal.fire($.extend({
                title: newTitle,
                text: msg,
                icon: newType
            }, params || {})
        );
    };

    const validateSizePhoto = (file, preview = false) => {
        if (file.files && file.files[0]) {
            let valid_files = file.files[0];
            let FileSize = valid_files.size / 1024 / 1024; // in 512 KB
            if (FileSize > MAX_FILE_SIZE) {
                swalWarning(`File tidak diperbolehkan lebih dari ${MAX_FILE_SIZE_KB}Kb`);
                file.value = "";
            } else {
                if (preview){
                    readUrl(valid_files);
                }
            }
        } else {
            swalError(`Tidak dapat membaca file. Mohon coba kembali.`);
        }
    };

    const validateSizeFile = (file) => {
        if (file.files && file.files[0]) {
            let valid_files = file.files[0];
            let FileSize = valid_files.size / 1024 / 1024; // in 512 KB
            if (FileSize > MAX_FILE_SIZE_KB) {
                swalWarning(`File tidak diperbolehkan lebih dari ${MAX_FILE_SIZE_KB}Kb`);
                file.value = "";
            }
        } else {
            swalError(`Tidak dapat membaca file. Mohon coba kembali.`);
        }
    }

    const inputValue = (el) => {
        el.parentElement.querySelector('input[type="text"]').value = el.files[0].name;
        el.parentElement.querySelector('label').classList.add('change')

        validateSizeFile(el);
    }

    function logout(){
        event.preventDefault();
        document.getElementById('frm-logout').submit();
        localStorage.setItem('login' , false)
    }

    function resetForm(formElement){
        const form = formElement.closest('form');
        form.find("input[type=text], textarea, input[type=number], input[type=password]").val('');
        form.find("select option").prop('selected', function () {
            return this.defaultSelected;
        })
        form.find(".select2").val(null).trigger('change');
        form.find(".select2").remove();
    }

    let xhr = new XMLHttpRequest();
    xhr.onerror = function() { // only triggers if the request couldn't be made at all
        swalError('Request failed, network error!');
    };

    $.xhrPool = []; // array of uncompleted requests
    $.xhrPool.abortAll = function() { // our abort function
        $(this).each(function(idx, jqXHR) {
            jqXHR.abort();
        });
        $.xhrPool.length = 0
    };

    $.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            $.xhrPool.push(xhr);
        },
        error: function (data) {
            const resp = data.responseJSON;
            if (data.status === 422) {
                swalValidation(resp.errors)
            } else if (data.status === 500) {
                swalError(resp.error ?? resp.message)
            } else if(data.status === 401) {
                Swal.fire({
                    title: 'Sesi anda telah berakhir!',
                    text: "Silahkan login kembali.",
                    icon: 'warning',
                }).then((result) => {
                    location.href = '/login';
                });
            } else if (data.status === 403) {
                if (typeof resp.errors != 'undefined'){
                    let html = `<p>${resp.message}</p>`;
                    html += '<p>Silahkan hapus role yang tertera dibawah ini:<p>';
                    html += '<span>';
                    resp.errors.forEach((item, index) => {
                        html += `<p>${+index+1}. ${item}</p>`
                    });
                    html += '</span>';
                    swalWarning(resp.message, html);
                } else {
                    swalError(resp.message)
                }
            }
        },
        complete: function(jqXHR) { // when some of the requests completed it will splice from the array
            var index = $.xhrPool.indexOf(jqXHR);
            if (index > -1) {
                $.xhrPool.splice(index, 1);
            }
        }
    });

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // change icon collapse item
    const angleIcon = (collapse) => {
        collapse.lastElementChild.classList.toggle('fa-angle-right')
        collapse.lastElementChild.classList.toggle('fa-angle-down')
    }

    const ucwords = (string) => {
        return string.toLowerCase().split(' ').map(capitalize).join(' ');
        // return string.toLowerCase().replace(/(?<= )[^\s]|^./g, a=>a.toUpperCase())  Throw error on iOS
    }

    const disableButtonSubmit = (el = document) => {
        const submitBtn = el.querySelector('button[type="submit"]')
        submitBtn.setAttribute('disabled', 'disabled');
        submitBtn.classList.add('btn', 'disabled')
    }

    const enableSubmitButton = (el = document) => {
        const submitBtn = el.querySelector('button[type="submit"]')
        submitBtn.removeAttribute('disabled')
        submitBtn.classList.remove('disabled')
    }
</script>
