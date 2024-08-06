!(function () {
    "use strict";

    class Dropzone {
        static parseOptionConfig(optionConfig) {
            const config = {};
            if (optionConfig) {
                optionConfig.split("|").forEach((pair) => {
                    const [key, value] = pair
                        .split(":")
                        .map((part) => part.trim());
                    if (key && value !== undefined) {
                        switch (key) {
                            case "paramName":
                                config[key] = value;
                                break;
                            case "maxFilesize":
                                config[key] = parseFloat(value);
                                break;
                            case "acceptedFiles":
                                config[key] = value;
                                break;
                            default:
                                console.warn(
                                    `Unknown key "${key}" in data-dropzone-option.`
                                );
                        }
                    }
                });
            }
            return config;
        }

        static removeExistingDropzones() {
            $("form.dropzone").each(function () {
                if (this.dropzone) {
                    this.dropzone.destroy();
                }
            });
        }

        static initDropzone() {
            Dropzone.autoDiscover = false;
            this.removeExistingDropzones();

            $("form.dropzone").each(function () {
                const $form = $(this);
                const formId = $form.attr("id");
                const $submit = $(`#${formId}-submit`);
                const $reset = $(`#${formId}-reset`);
                const actionUrl = $form.attr("action");
                const optionConfig = $form.attr("data-dropzone-option");
                const config = Dropzone.parseOptionConfig(optionConfig);

                const csrfToken = $form.find('input[name="_token"]').val();

                new Dropzone(this, {
                    url: actionUrl,
                    paramName: config.paramName || "file",
                    maxFilesize: config.maxFilesize || 2,
                    acceptedFiles: config.acceptedFiles || "image/*",
                    addRemoveLinks: true,
                    autoProcessQueue: false,
                    maxFiles: 1,
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    init: function () {
                        const dz = this;
                        const originalSubmitText = $submit.html();

                        dz.on("addedfile", function () {
                            if (dz.files.length > 1) {
                                dz.removeFile(dz.files[0]);
                            }
                        });

                        $submit.on("click", function (e) {
                            e.preventDefault();
                            console.log(dz.getAcceptedFiles());
                            if (dz.getAcceptedFiles().length === 0) {
                                $submit.html(originalSubmitText);
                                $submit.prop("disabled", false);
                                return;
                            }
                            $submit.html(
                                '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div> Wait...'
                            );
                            $submit.prop("disabled", true);
                            dz.processQueue();
                        });

                        $reset.on("click", function (e) {
                            e.preventDefault();
                            dz.removeAllFiles(true);
                        });

                        dz.on("success", function (file, response) {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                            $submit.html(originalSubmitText);
                            $submit.prop("disabled", false);
                        });

                        dz.on("error", function () {
                            $submit.html(originalSubmitText);
                            $submit.prop("disabled", false);
                        });
                    },
                });
            });
        }

        static init() {
            this.initDropzone();
        }
    }

    One.onLoad(() => Dropzone.init());
})();
