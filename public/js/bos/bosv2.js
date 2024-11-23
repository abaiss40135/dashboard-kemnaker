// const { default: Swal } = require("sweetalert2");
// const Swal = require("sweetalert2");

//IN MB
const MAX_FILE_SIZE = 50;
//IN KB
const MAX_FILE_SIZE_KB = 51200;
const preloader =
    '<img class="img-fluid" alt="img-preloader" src="https://bos.polri.go.id/img/ellipsis-preloader.gif">';
const loaderRotateContainer = document.querySelector(
    ".loader-rotate-container"
);
loaderRotateContainer && (loaderRotateContainer.style.display = "flex");

function submitFormLoader() {
    loaderRotateContainer.style.display = "flex";
}

function hideFormLoader() {
    loaderRotateContainer.style.display = "none";
}

window.chartColors = {
    red: "rgb(255, 99, 132)",
    orange: "rgb(244, 162, 97)",
    yellow: "rgb(255, 205, 86)",
    green: "rgb(42, 157, 143)",
    blue: "rgb(93,165,218)",
    purple: "rgb(153, 102, 255)",
    grey: "rgb(201, 203, 207)",
    brown: "rgb(245, 203, 92)",
    black: "rgb(36, 36, 35)",
    charcoal: "rgb(38, 70, 83)",
    burnSienna: "rgb(231, 111, 81)",
    pink: "rgb(239, 71, 111)",
};

/**
* Scroll down to specific ID Selector
* */

function scrollDownTo(href){
    let  targetOffset = $('#'+href+'').offset().top;
    $('html, body').animate({
        scrollTop: targetOffset + 'px'
    }, 700);
}

/**
 * Add comma after every 3 digit
 */
function addCommas(number) {
    if (isNaN(number)) return 0;
    return Number(number)
        .toFixed(0)
        .replace(/./g, function (c, i, a) {
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
        case typeof (e === "undefined"):
            return true;
        case typeof (e === "object"):
            return e.length === 0;
        default:
            return false;
    }
};

function isObjectEmpty(value) {
    return (
        Object.prototype.toString.call(value) === "[object Object]" &&
        JSON.stringify(value) === "{}"
    );
}

//append new option to input select
const appendSelectOption = (text, id = "", selected = true) =>
    new Option(text == null ? "" : text, id, false, selected);

/**
 * Method untuk pilih selected option select2
 * Dipakai untuk edit pada multiple tags
 *
 * @param selectorSelect
 * @param id
 * @param text
 */
const firstOrCreateOption = (selectorSelect, id, text = "") => {
    // Set the value, creating a new option if necessary
    if ($(selectorSelect).find("option[value='" + id + "']").length) {
        $(selectorSelect).val(id).trigger("change");
    } else {
        // Create a DOM Option and pre-select by default
        let newOption = new Option(text, id, true, true);
        // Append it to the select
        $(selectorSelect).append(newOption).trigger("change");
    }
};

const swalSuccess = (message, html = "") => {
    swalSetup("Operasi Sukses", message, "success", html);
};
const swalError = (message, html = "") => {
    swalSetup("Ada kesalahan", message, "error", html);
};
const swalWarning = (message, html = "") => {
    swalSetup("Perhatian", message, "warning", html);
};
const swalCancel = (message, html = "") => {
    swalSetup("Dibatalkan", message, "error", html);
};
const swalValidation = (errors) => {
    let values = "<span>";
    jQuery.each(errors, function (key, value) {
        values += `<p>${value}</p>`;
    });
    swalError("Validation Error", values + "</span>");
};

const swalSetup = (title, message, type, html) => {
    Swal.fire({
        icon: type,
        title: title,
        text: message,
        html: html,
    });
};

const titleCase = (string) => {
    let sentence = string.toLowerCase().split(" ");
    for (let i = 0; i < sentence.length; i++) {
        sentence[i] = sentence[i][0].toUpperCase() + sentence[i].slice(1);
    }
    return sentence.join(" ");
};

const slugify = (text) =>
    text
        .toString()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase()
        .trim()
        .replace(/\s+/g, "-")
        .replace(/[^\w-]+/g, "")
        .replace(/--+/g, "-");

function formatDate(date, format = "Y-m-d") {
    let d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();
    hour = d.getHours();
    minute = d.getMinutes();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;
    if (hour.length < 2) hour = "0" + hour;
    if (minute.length < 2) minute = "0" + minute;

    switch (format) {
        case "d-m-Y":
            return [day, month, year].join("-");
        case "m-d-Y":
            return [day, month, year].join("-");
        case "h:m":
            return [hour, minute].join(":");
        default:
            return [year, month, day].join("-");
    }
}

function localDateFormat(date) {
    return new Date(date)
        .toLocaleString("id")
        .replace(/\//g, "-")
        .replace(/\./g, ":");
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// replace default alert js to swal
// keep default js alert to use in specific cases
window.legacyAlert = window.alert;

// types alert and confirm: "success", "error", "warning", "info", "question". Default: "warning"
// overwrite default js alert
window.alert = function (msg, title, type, params) {
    let newTitle =
        title == null ? "Ada yang tidak beres dengan aplikasi" : title;
    let newType = type == null ? "warning" : type;
    Swal.fire(
        $.extend(
            {
                title: newTitle,
                text: msg,
                icon: newType,
            },
            params || {}
        )
    );
};

const validateSizePhoto = (file, preview = false) => {
    if (file.files && file.files[0]) {
        let valid_files = file.files[0];
        let FileSize = valid_files.size / 1024 / 1024; // in 512 KB
        if (FileSize > MAX_FILE_SIZE) {
            swalWarning(
                `File tidak diperbolehkan lebih dari ${MAX_FILE_SIZE_KB}Kb`
            );
            file.value = "";
        } else {
            if (preview) {
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
            swalWarning(
                `File tidak diperbolehkan lebih dari ${MAX_FILE_SIZE_KB}Kb`
            );
            file.value = "";
        }
    } else {
        swalError(`Tidak dapat membaca file. Mohon coba kembali.`);
    }
};

const inputValue = (el) => {
    el.parentElement.querySelector('input[type="text"]').value =
        el.files[0].name;
    validateSizeFile(el);
};

let setFileLabel = (el) => {
    el.parentElement.querySelector("label").textContent = el.files[0].name;
    el.parentElement.querySelector("label").classList.add("change");
};

function logout() {
    event.preventDefault();
    document.getElementById("frm-logout").submit();
    localStorage.setItem("login", false);
}

function confirmPoliceDepartment(callback, id = false) {
    const cookies = document.cookie;
    console.log(cookies.search("polda"));
    if (cookies.search("polda") !== -1) {
        console.log(cookies.search("polda"));
        if (id) {
            callback(id);
        } else {
            callback();
        }
    } else {
        swal.fire({
            title: "Masukkan Lokasi",
            html:
                // `<label class="form-label mb-0">Polda</label>` +
                `<input id="satuan-polda" class="form-control mb-3 mt-1" placeholder="POLDA tempat bertugas"/>` +
                // `<label class="form-label mb-0">Polres</label>` +
                `<input id="satuan-polres" class="form-control mb-3 mt-1" placeholder="POLRES tempat bertugas"/>` +
                // `<label class="form-label mb-0">Polsek</label>` +
                `<input id="satuan-polsek" class="form-control mb-3 mt-1" placeholder="POLSEK tempat bertugas"/>`,
            preConfirm: () => [
                document.getElementById("polda").value,
                document.getElementById("polres").value,
                document.getElementById("polsek").value,
            ],
        }).then((val) => {
            document.cookie = `polda=${val.value[0]}; path=/`;
            document.cookie = `polres=${val.value[1]}; path=/`;
            document.cookie = `polsek=${val.value[2]}; path=/`;
            if (id) {
                callback(id);
            } else {
                callback();
            }
        });
    }
}

function resetForm(formElement) {
    let form = formElement.closest("form");
    form.find(
        "input[type=text], input[type=date], input[type=month], textarea, input[type=number], input[type=password], input[type=file]"
    ).val("");
    form.find(".select2").val(null).trigger("change");
}

function resetInputCKDITOR() {
    if ($(CKEDITOR.instances).length) {
        for (var key in CKEDITOR.instances) {
            var instance = CKEDITOR.instances[key];
            instance.setData(instance.element.$.defaultValue);
        }
    }
}

function serializeForm(data) {
    let obj = {};
    for (let [key, value] of data) {
        if (obj[key] !== undefined) {
            if (!Array.isArray(obj[key])) {
                obj[key] = [obj[key]];
            }
            obj[key].push(value);
        } else {
            obj[key] = value;
        }
    }
    return obj;
}

function resetSelect2TagsInForm(form) {
    let parentSelect = form.find(".select2").parent();
    parentSelect.find("option").remove();
    form.find(".select2").html("");

    form.find("select option").prop("selected", function () {
        return this.defaultSelected;
    });
}

let xhr = new XMLHttpRequest();
xhr.onerror = function () {
    // only triggers if the request couldn't be made at all
    swalError("Request failed, network error!");
};

$.xhrPool = []; // array of uncompleted requests
$.xhrPool.abortAll = function () {
    // our abort function
    $(this).each(function (idx, jqXHR) {
        jqXHR.abort();
    });
    $.xhrPool.length = 0;
};

$.ajaxSetup({
    beforeSend: function (xhr) {
        xhr.setRequestHeader(
            "X-CSRF-Token",
            $('meta[name="csrf-token"]').attr("content")
        );
        $.xhrPool.push(xhr);
    },
    error: function (data) {
        const resp = data.responseJSON;
        if (data.status === 422) {
            swalValidation(resp.errors);
        } else if (data.status === 500) {
            swalError(resp.error ?? resp.message);
        } else if (data.status === 401) {
            Swal.fire({
                title: "Sesi anda telah berakhir!",
                text: "Silahkan login kembali.",
                icon: "warning",
            }).then((result) => {
                location.href = "/login";
            });
        } else if (data.status === 403) {
            if (typeof resp.errors != "undefined") {
                let html = `<p>${resp.message}</p>`;
                html += "<p>Silahkan hapus role yang tertera dibawah ini:<p>";
                html += "<span>";
                resp.errors.forEach((item, index) => {
                    html += `<p>${+index + 1}. ${item}</p>`;
                });
                html += "</span>";
                swalWarning(resp.message, html);
            } else {
                swalError(resp.message);
            }
        }
    },
    complete: function (jqXHR) {
        // when some of the requests completed it will splice from the array
        var index = $.xhrPool.indexOf(jqXHR);
        if (index > -1) {
            $.xhrPool.splice(index, 1);
        }
    },
});

// change icon collapse item
const angleIcon = (collapse) => {
    collapse.lastElementChild.classList.toggle("fa-angle-right");
    collapse.lastElementChild.classList.toggle("fa-angle-down");
};

const ucwords = (string) => {
    return string.replace(
        /\w\S*/g,
        (x) => x.charAt(0).toUpperCase() + x.substr(1).toLowerCase()
    );
};

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

const disableSubmitButtonTemporarily = (el = document) => {
    disableButtonSubmit(el)

    setTimeout(() => {
        enableSubmitButton(el)
    }, 5000);
}

const copy = (url, type = null, id = null) => {
    navigator.clipboard.writeText(url);
    swalSuccess("Tautan (link) telah disalin");

    if (type != null && id != null) {
        $.ajax({
            url: route("pemanfaatan-informasi.copy-link"),
            data: { type, id },
        });
    }
};

const deleteConfirm = (id) => {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Setelah dihapus, data berikut tidak dapat dikembalikan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batalkan",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(id).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalCancel("Data anda aman, proses hapus dibatalkan");
        }
    });
};

let listRiwayatApproval = (approvals, colspan) => {
    let body = "";
    approvals.forEach((approval, key) => {
        body += `<tr class="text-center ${
            approval.is_approve == null
                ? "bg-yellow"
                : approval.is_approve
                ? "bg-success"
                : "bg-danger"
        }">
            <td>${key + 1}</td>
            <td>${
                approval.is_approve == null
                    ? "Diajukan"
                    : approval.is_approve
                    ? "Diterima"
                    : "Ditolak"
            }</td>
            <td>${approval.keterangan}</td>
            <td>${
                approval.personel
                    ? approval.personel.nama +
                      " (" +
                      approval.level.toUpperCase() +
                      ")"
                    : ""
            }</td>
            <td>${approval.waktu}</td>
        </tr>`;
    });
    return `<tr class="expandable-body d-none">
                <td colspan="${colspan}">
                    <table class="w-100 table-bordered table-striped mt-1 mb-3">
                        <thead>
                        <tr class="text-center bg-dark text-white">
                            <td width="5%">No</td>
                            <td width="10%">Status</td>
                            <td width="40%">Keterangan</td>
                            <td width="25%">Approver</td>
                            <td width="20%">Tanggal</td>
                        </tr>
                        </thead>
                        <tbody>
                            ${body}
                        </tbody>
                    </table>
                </td>
            </tr>`;
};

let randomIntFromInterval = (min, max) => {
    // min and max included
    return Math.floor(Math.random() * (max - min + 1) + min);
};

let round = (value, decimals) => {
    if (value < 1) {
        return 1;
    }
    return Number(Math.round(value + "e" + decimals) + "e-" + decimals);
};

let generateObjectRandomData = () => {
    let randData = {};

    for (let index = 1; index <= 34; index++) {
        let key = index < 10 ? "path0" + index : "path" + index;
        var obj = {};
        obj[key] = randomIntFromInterval(700, 1500);
        Object.assign(randData, obj);
    }
    return randData;
};

// generate loading loader for forms submit
document.querySelectorAll("form").forEach((e) => {
    e.addEventListener("submit", (event) => {
        event.target.onsubmit = submitFormLoader();
    });
});

// Add a response interceptor
axios.interceptors.response.use(
    function (response) {
        hideFormLoader();
        return response;
    },
    function (error) {
        hideFormLoader();
        return Promise.reject(error);
    }
);

// generate loading loader for anchor tags
document.querySelectorAll("a").forEach((e) => {
    if (e.target !== "_blank" || e.href !== "#") {
        e.addEventListener("click", (event) => {
            event.target.onsubmit = submitFormLoader();
        });

        setTimeout(() => {
            hideFormLoader();
        }, 5000);
    }
});

// generate loading loader for forms submit with get method
document.querySelectorAll('form[method="get"]').forEach((e) => {
    e.addEventListener("submit", async (event) => {
        submitFormLoader();

        // ketika form telah berhasil dikirimkan lalu hasilnya telah diterima kembali oleh user, maka user tinggal meng-klik layar bagian manapun untuk menghilangkan loader nya
        event.submitter.addEventListener("focusout", (e) => {
            hideFormLoader();
        });

        // menghilangkan loader setelah 5 detik tampil
        setTimeout(() => {
            hideFormLoader();
        }, 5000);
    });
});

// Add a response interceptor
axios.interceptors.response.use(
    function (response) {
        hideFormLoader();
        return response;
    },
    function (error) {
        hideFormLoader();
        return Promise.reject(error);
    }
);

window.addEventListener("load", function () {
    hideFormLoader();
});

(function () {
    hideFormLoader();
})();

// get select alamat option
// params:
// - el: (use jquery selector) get value from `el` as parameter for route,
// - r: route alamat,
// - target: (use jquery selector) target select element,
// - text: text
const setOptionAlamat = (el, r, target, text) => {
    axios.post(r, { id: el.children(':selected').attr('id') })
        .then((res) => {
            target.empty()
            target.append(`<option value=""> pilih ${text} </option>`)
            return res.data
        })
        .then((data) => {
            for (let id in data) {
                target.append(`<option value="${data[id]}" id="${id}">${data[id]}</option>`)
            }
        })
}

// validate size file input form
const validateSize = (input) => {
    const fileSize = input.files[0].size / 1024 / 1024; // in MB

    // Max 20MB
    if (fileSize > 20) {
        alert(
            "File video yang diterima maksimal berukuran 20MB!",
            "File video anda terlalu besar!"
        );
        input.value = null;
    }
};
