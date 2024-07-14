(function () {
    "use strict";

    class FormHandler {
        static initResponse() {
            jQuery("form").on("submit", function (event) {
                event.preventDefault();

                const form = jQuery(this);
                const submitButton = form.find("button[type='submit']");
                const originalButtonText = submitButton.html();

                if (form.valid()) {
                    submitButton.html(
                        '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div> Wait...'
                    );
                    submitButton.prop("disabled", true);
                    jQuery
                        .post(
                            form.attr("action"),
                            form.serialize(),
                            function (data, textStatus, xhr) {
                                if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.redirect
                                ) {
                                    window.location.href =
                                        xhr.responseJSON.redirect;
                                } else if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.success
                                ) {
                                    One.helpers("jq-notify", {
                                        type: "success",
                                        icon: "fa fa-check me-1",
                                        align: "center",
                                        message: xhr.responseJSON.success,
                                    });
                                } else {
                                    One.helpers("jq-notify", {
                                        type: "danger",
                                        icon: "fa fa-times me-1",
                                        align: "center",
                                        message: xhr.responseJSON.status,
                                    });
                                }
                                submitButton.html(originalButtonText);
                                submitButton.prop("disabled", false);
                            }
                        )
                        .fail(function (xhr, status, error) {
                            const response = xhr.responseJSON;

                            if (response && response.errors) {
                                const errors = response.errors;
                                form.validate().showErrors(errors);
                            } else {
                                One.helpers("jq-notify", {
                                    type: "danger",
                                    icon: "fa fa-times me-1",
                                    align: "center",
                                    message:
                                        response.message || "An error occurred",
                                });
                            }

                            submitButton.html(originalButtonText);
                            submitButton.prop("disabled", false);
                        });
                }
            });
        }

        static init() {
            this.initResponse();
        }
    }

    One.onLoad(() => FormHandler.init());
})();
