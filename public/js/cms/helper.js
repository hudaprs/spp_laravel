/**
 * Helping you in HTML
 * This file is for formatting the HTML input
 *
 * @author Huda Prasetyo
 */

/**
 * Catch events with Vanilla Javascript
 *
 * @param {string} textbox
 * @param {callback} inputFilter
 */
function setInputFilter(textbox, inputFilter) {
    [
        "input",
        "keydown",
        "keyup",
        "mousedown",
        "mouseup",
        "select",
        "contextmenu",
        "drop",
    ].forEach(function (event) {
        textbox.addEventListener(event, function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(
                    this.oldSelectionStart,
                    this.oldSelectionEnd
                );
            } else {
                this.value = "";
            }
        });
    });
}

/**
 * Format html input to integer only
 * NOTE: This function is using Vanilla JavaScript
 *
 * @param {string} element
 */
const formatInteger = (element) => {
    return setInputFilter(document.getElementById(element), function (value) {
        return /^-?\d*$/.test(value);
    });
};

/**
 * Format html input to float only
 * NOTE: This function is using Vanilla JavaScript
 *
 * @param {string} element
 */
const formatDecimal = (element) => {
    return setInputFilter(document.getElementById(element), function (value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });
};

/**
 * Format html input to currency
 * NOTE: This function is using Jquery
 *
 * @param {string} element
 */
const formatCurrency = (element) => {
    return new Cleave(element, {
        numeral: true,
        numeralThousandsGroupStyle: "thousand",
    });
};

/**
 * Format html input to time picker
 * NOTE: this function required Cleave.js and Jquery
 *
 * @param {string} element
 * @author Cleave.JS
 */
const formatTime = (element) => {
    return new Cleave(element, {
        time: true,
        timePattern: ["h", "m"],
    });
};

/**
 * Format html to integer only / remove anything except integer
 * NOTE: This function is using Vanilla JavaScript
 *
 * @param {string} element
 */
const onlyNumber = (element) => {
    if (element != null) {
        return element.replace(/[^\d]+/g, "");
    } else {
        return "";
    }
};

/**
 * Format html to datepicker
 * NOTE: This function is using Jquery
 *
 * @param {string} element
 */
const datePickerFormatIndonesia = (element) => {
    var date = new Date();
    date.setDate(date.getDate());
    return $(element).datepicker({
        format: "dd-mm-yyyy",
        startDate: date,
        //endDate: date,
        forceParse: false,
        orientation: "bottom",
    });
};

/**
 * Format html input to time picker
 * NOTE: This function is using Jquery
 *
 * @param element = element of input using jquery
 * @packageAuthor johnThorton
 */
const timePicker = (element) => {
    return $(element).timepicker({
        timeFormat: "H:i",
    });
};

/**
 * Trigger select2 for using ajax request
 * NOTE: This function is using jquery
 *
 * @param {string} element
 * @param {string} url
 * @param {string} placeholder
 */
function ajaxSelect2(element, url, placeholder) {
    const disableSearch = url == "/js/status.json" ? Infinity : false;
    return $(element).select2({
        minimumResultsForSearch: disableSearch,
        placeholder: placeholder,
        ajax: {
            url,
            processResults: (data) => {
                return {
                    results: data.map((item) => {
                        return {
                            id: item.id,
                            text: item.name,
                        };
                    }),
                };
            },
        },
    });
}

/**
 * Format html input, make value to uppercase and remove special character
 * NOTE: This function is using vanilla JavaScript
 *
 * @param {string} element
 */
const upperCaseInput = (element) => {
    return document
        .getElementById(element)
        .addEventListener("keyup", ({ target }) => {
            let { value } = target;
            return (document.getElementById(
                element
            ).value = value.toUpperCase().replace(/[^a-z0-9\s]/gi, ""));
        });
};

/**
 * Format html input for removing special character
 * NOTE: This function is using vanilla JavaScript
 *
 * @param {string} element
 */
const removeSpecialChar = (element) => {
    return document
        .getElementById(element)
        .addEventListener("keyup", ({ target }) => {
            let { value } = target;
            return (document.getElementById(element).value = value.replace(
                /[^a-z0-9\s]/gi,
                ""
            ));
        });
};

/**
 * Format html input for limitting the value
 * Note: This function is using Vanilla JavaScript
 *
 * @param {string} element
 * @param {integer} limit
 */
const limitInput = (element, limit) => {
    return document
        .getElementById(element)
        .addEventListener("keyup", ({ target }) => {
            let { value } = target;
            return (document.getElementById(element).value = value.slice(
                0,
                limit
            ));
        });
};

/**
 * @desc Format html input to date range picker
 * @desc NOTE: This function is using Jquery
 *
 * @param {string}    element
 * @param {callback}  config
 * @param {boolean}   startDate
 * @param {boolean}   endDate
 *
 * @packageAuthor     Long Bill
 */
const dateRangePicker = (element, config, startDate = false, endDate) => {
    let now = new Date();
    let dateRangePickerConfig = {
        setValue: function (s) {
            if (!$(this).is(":disabled") && s != $(this).val()) {
                $(this).val(s);
            }
        },
        separator: " s/d ",
        format: "DD-MM-YYYY",
        startDate: startDate ? now.setDate(now.getDate()) : null,
        endDate: endDate ? endDate.setDate(endDate.getDate()) : null,
    };

    Object.assign(dateRangePickerConfig, config);

    return $(element).dateRangePicker(dateRangePickerConfig);
};

/**
 * Common config for date range picker
 * NOTE: This function is for callback in @function dateRangePicker
 * NOTE: @param element is commonly used for startDate and End Date (must be)
 *
 * @param {array} element
 */
const commonDatePickerOption = (element = []) => {
    /**
     * element[0] = always be start date
     * element[1] = always be end date
     */
    if (element.length == 2) {
        return {
            getValue: () => {
                if ($(element[0]).val() && $(element[1]).val()) {
                    return $(element[0]).val() + " s/d " + $(element[1]).val();
                } else {
                    return "";
                }
            },
            setValue: (s, s1, s2) => {
                $(element[0]).val(s1);
                $(element[1]).val(s2);
            },
        };
    }
};

/**
 * Format html input to Rupiah
 * NOTE: The @param angka is for value of the html input or something else is integer
 *
 * @param {string} angka
 * @param {string} prefix
 * @author MalasNgoding.com
 */
const formatRupiah = (angka, prefix) => {
    let number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : ",-";
};

/**
 * Format html input to Gram
 * NOTE: The @param element is for value of the html input or something else is integer
 *
 * @param {string} element
 */
const gramationNumber = (element) => {
    return (Math.round(element * 100) / 100).toFixed(2);
};
