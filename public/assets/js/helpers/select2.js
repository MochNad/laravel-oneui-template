!(function () {
    "use strict";

    class Select2 {
        static initSelect2() {
            One.helpers("jq-select2");

            $(".modal").on("shown.bs.modal", function () {
                $(this)
                    .find("select.js-select2")
                    .each(function () {
                        const $select = $(this);
                        Select2.setupSelect2($select, true);
                    });
            });

            $("select.js-select2")
                .not(".modal select.js-select2")
                .each(function () {
                    const $select = $(this);
                    Select2.setupSelect2($select);
                });
        }

        static setupSelect2($select, isInModal = false) {
            const options = {
                width: "100%",
            };

            if ($select.data("placeholder")) {
                options.placeholder = $select.data("placeholder");
            }

            if ($select.data("allow-clear")) {
                options.allowClear = true;
            }

            if ($select.data("reference")) {
                options.ajax = {
                    url: $select.data("reference"),
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page || 1,
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.map((item) => ({
                                id: item.id,
                                text: item.text,
                            })),
                            pagination: {
                                more: data.length === 10,
                            },
                        };
                    },
                    cache: true,
                };
            }

            if ($select.data("icon")) {
                options.templateResult = function (data) {
                    if (!data.id) {
                        return `<span class="ms-2">${data.text}</span>`;
                    }
                    return $(
                        `<span><i class="${data.id} me-2"></i>${data.text}</span>`
                    );
                };

                options.templateSelection = function (data) {
                    if (!data.id) {
                        return `<span class="ms-2">${data.text}</span>`;
                    }
                    return $(
                        `<span><i class="${data.id} ms-2 me-2"></i>${data.text}</span>`
                    );
                };
            } else {
                options.templateResult = function (data) {
                    return `<span class="ms-2">${data.text}</span>`;
                };

                options.templateSelection = function (data) {
                    return `<span class="ms-2">${data.text}</span>`;
                };
            }

            options.escapeMarkup = function (markup) {
                return markup;
            };

            if (isInModal) {
                const $dropdownParent =
                    "#" + $select.closest(".modal").attr("id");
                options.dropdownParent = $($dropdownParent);
            }

            $select.select2(options).val($select.val()).trigger("change");
        }

        static init() {
            this.initSelect2();
        }
    }

    One.onLoad(() => Select2.init());
})();
