$(function () {
    // States
    let currentModal = null;

    /**
     * Show modal
     * This modal contain Large modal(#modal-lg) and Extra Large Modal(#modal-xl)
     */
    $("body").on("click", ".btn-show-modal", function (event) {
        event.preventDefault();

        let me = $(this),
            title = me.prop("title"),
            url = me.prop("href"),
            checkClass = me.hasClass("lg") ? "#modal-lg" : "#modal-xl";

        $(`${checkClass}`).modal("show");
        $(`${checkClass} .modal-title`).html(title);

        // Remove save button when get into detail
        me.hasClass("just-show")
            ? $(`${checkClass} .btn-save`).hide()
            : $(`${checkClass} .btn-save`).show();

        // Change the word according action
        me.hasClass("edit")
            ? $(`${checkClass} .btn-save`).html("Edit")
            : $(`${checkClass} .btn-save`).html("Create");

        $.ajax({
            url,
            method: "GET",
            dataType: "html",
            beforeSend: function () {
                // Append overlay
                $(`.overlay`).css("z-index", "9999");
            },
            success: function (response) {
                // Remove overlay
                $(`.overlay`).css("z-index", "-9999");

                // Remove modal
                $(`${checkClass} .modal-body`).html(response);

                // Update state
                currentModal = checkClass;

                /**
                 * Disable keyboard enter in modal
                 */
                if ($(`${checkClass} .modal-body form`).length) {
                    $(`${checkClass} .modal-body form`).on(
                        "keyup keypress",
                        function (e) {
                            var keyCode = e.keyCode || e.which;
                            if (keyCode === 13) {
                                e.preventDefault();
                                return false;
                            }
                        }
                    );
                }
            },
            error: function (xhr) {
                let error = xhr.responseJSON;
                console.error(error.message);

                // Remove overlay
                $(`.overlay`).css("z-index", "-9999");
            },
        });
    });

    /**
     * Accept Incoming POST | PUT Request
     */
    $("body").on("click", ".btn-save", function (event) {
        event.preventDefault();

        let form = $(`${currentModal} .modal-body form`),
            url = form.prop("action"),
            method =
                $("input type[name=_method]").val() === undefined
                    ? "POST"
                    : "PUT";

        $.ajax({
            url,
            method,
            data: new FormData(form[0]),
            contentType: false,
            processData: false,
            beforeSend: function () {
                // Remove previous error message
                form.find(".invalid-feedback").remove();
                form.find(".form-control").removeClass("is-invalid");

                // Append overlay
                $(".overlay").css("z-index", "9999");
            },
            success: function ({ message }) {
                // Remove overlay
                $(".overlay").css("z-index", "-9999");

                // Close modal
                $(`${currentModal}`).modal("hide");

                // Add toast message from sweetalert
                initToast("success", message);

                // Reload datatable
                $("#datatables").DataTable().ajax.reload();
            },
            error: function (xhr) {
                let error = xhr.responseJSON;
                console.error(error.message);
                // Check if error is not empty
                if ($.isEmptyObject(error) == false) {
                    $.each(error.errors, function (key, value) {
                        $(`#${key}`)
                            .closest(".form-group")
                            .append(
                                `<strong class='invalid-feedback'>${value}</strong>`
                            )
                            .find(".form-control")
                            .addClass("is-invalid");
                    });
                }

                // Remove overlay
                $(".overlay").css("z-index", "-9999");
            },
        });
    });

    /**
     * Accept incoming DELETE request
     */
    $("body").on("click", ".btn-destroy", function (event) {
        event.preventDefault();

        let me = $(this),
            url = me.prop("href"),
            csrfToken = $('meta[name="csrf-token"]').prop("content");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url,
                    method: "POST",
                    data: {
                        _token: csrfToken,
                        _method: "DELETE",
                    },
                    beforeSend: function () {
                        // Show message
                        initToast("warning", "Deleting data");
                    },
                    success: function ({ message }) {
                        // Add toast message from sweetalert
                        initToast("success", message);

                        // Reload datatable
                        $("#datatables").DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        let error = xhr.responseJSON;
                        const { message } = error;
                        console.error(message);
                        initToast("error", message);
                    },
                });
            }
        });
    });
});
