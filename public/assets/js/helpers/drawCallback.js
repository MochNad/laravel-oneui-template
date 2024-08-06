$('[data-bs-toggle="tooltip"]').tooltip();
$("[data-action-create]").on("click", function (e) {
    e.preventDefault();
    const route = $(this).data("route");
    const modalId = $(this).data("modal");
    const modalTitle = $(this).data("bs-original-title");

    $(modalId).find(".block-title").text(modalTitle);
    $(modalId).find("form").attr("action", route);
    $(modalId)
        .find("input, textarea")
        .not("input[type=hidden], input[type=checkbox]")
        .val("");
    $(modalId).find("select").val(null).trigger("change");
    $(modalId).modal("show");
});

$("[data-action-read]").on("click", function (e) {
    e.preventDefault();
    const route = $(this).data("route");
    const column = $(this).data("column");
    const modalId = $(this).data("modal");
    const modalTitle = $(this).data("bs-original-title");

    $.get(route, function (response) {
        const responseData = response[column];
        $(modalId)
            .find(".block-title")
            .text(modalTitle + " " + responseData);
        for (const key in response) {
            $(modalId)
                .find(modalId + "-" + key)
                .text(response[key]);
        }
        $(modalId).modal("show");
    });
});

$("[data-action-edit]").on("click", function (e) {
    e.preventDefault();
    const routeEdit = $(this).data("route-edit");
    const routeUpdate = $(this).data("route-update");
    const column = $(this).data("column");
    const modalId = $(this).data("modal");
    const modalTitle = $(this).data("bs-original-title");

    $.get(routeEdit, function (response) {
        const responseData = response[column];
        $(modalId)
            .find(".block-title")
            .text(modalTitle + " " + responseData);

        $(modalId).find('input[type="checkbox"]').prop("checked", false);

        $.each(response, function (key, value) {
            const input = $(modalId).find('[name="' + key + '"]');

            if (typeof value === "object" && !input.hasClass("js-select2")) {
                $.each(value, function (name, checked) {
                    const checkbox = $(modalId).find(`input[name="${name}"]`);
                    if (checkbox.length) {
                        checkbox.prop("checked", checked);
                    }
                });
            } else if (input.hasClass("js-select2")) {
                const option = $("<option selected></option>")
                    .val(value.id)
                    .text(value.text);
                input.append(option).trigger("change");
            } else {
                input.val(value);
            }
        });

        $(modalId).find("form").attr("action", routeUpdate);
        $(modalId).modal("show");
    });
});

$("[data-action-delete]").on("click", function (e) {
    e.preventDefault();
    const route = $(this).data("route");
    const swalTitle = $(this).data("bs-original-title");
    const swalText = $(this).data("name");
    const csrf = $('meta[name="csrf-token"]').attr("content");

    (async () => {
        try {
            const result = await Swal.fire({
                title: swalTitle,
                text: swalText,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(route, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": csrf,
                            },
                        });
                        if (!response.ok) {
                            const contentType =
                                response.headers.get("content-type");
                            if (
                                contentType &&
                                contentType.includes("application/json")
                            ) {
                                const errorData = await response.json();
                                throw new Error(
                                    errorData.error || response.statusText
                                );
                            } else {
                                throw new Error(response.statusText);
                            }
                        }

                        return response.json();
                    } catch (error) {
                        Swal.showValidationMessage(`${error.message}`);
                    }
                },

                allowOutsideClick: () => !Swal.isLoading(),
            });
            if (result.isConfirmed) {
                await Swal.fire("Deleted!", result.value.message, "success");
                jQuery(result.value.tableId).DataTable().ajax.reload();
            }
        } catch (error) {
            console.error(error);
        }
    })();
});

$("[data-action-menu]").on("click", function (e) {
    e.preventDefault();
    const csrf = $('meta[name="csrf-token"]').attr("content");
    const route = $(this).data("route");
    const move = $(this).data("move");

    $.ajax({
        url: route,
        type: "PUT",
        headers: {
            "X-CSRF-TOKEN": csrf,
        },
        data: { move: move },
        success: function (response) {
            One.helpers("jq-notify", {
                type: "success",
                icon: "fa fa-check me-1",
                align: "right",
                message: response.message,
            });
            jQuery(response.tableId).DataTable().ajax.reload();
        },
        error: function (xhr, status, error) {
            Swal.fire("Error", xhr.responseJSON.message, "error");
        },
    });
});

$("[data-action-user]").on("click", function (e) {
    e.preventDefault();
    const route = $(this).data("route");
    const csrf = $('meta[name="csrf-token"]').attr("content");

    $.post(route, { _token: csrf })
        .done(function (response) {
            if (response.redirect) {
                window.location.href = response.redirect;
            } else if (response.tableId && response.message) {
                One.helpers("jq-notify", {
                    type: "success",
                    icon: "fa fa-check me-1",
                    align: "right",
                    message: response.message,
                });
                jQuery(response.tableId).DataTable().ajax.reload();
            }
        })
        .fail(function (xhr, status, error) {
            Swal.fire("Error", xhr.responseJSON.message, "error");
        });
});

let componentCheckbox = function (field) {
    return `
        <div class="mb-4 d-flex flex-column justify-content-center align-items-center">
            <label class="form-label mb-2">${
                field.label
                    ? field.label.charAt(0).toUpperCase() + field.label.slice(1)
                    : ""
            }</label>
            <div class="space-x-2">
                ${field.options
                    .map(
                        (option) => `
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox"
                            value="${option.value}"
                            id="${option.id}-field"
                            name="${option.name}"
                            ${option.checked ? "checked" : ""}>
                        <label class="form-check-label"
                            for="${option.id}-field">
                            ${
                                option.label.charAt(0).toUpperCase() +
                                option.label.slice(1)
                            }
                        </label>
                    </div>
                `
                    )
                    .join("")}
            </div>
        </div>
    `;
};

$("[data-action-role]").on("click", function (e) {
    e.preventDefault();
    const routeEdit = $(this).data("route-edit");
    const routeUpdate = $(this).data("route-update");
    const modalId = $(this).data("modal");
    const modalTitle = $(this).data("bs-original-title");

    $.get(routeEdit, function (response) {
        const permissions = response.permissions;
        let checkboxHTML = '<div class="block-content fs-sm"><div class="row">';

        for (const [key, value] of Object.entries(permissions)) {
            checkboxHTML += componentCheckbox({
                label: key,
                options: Object.entries(value).map(([permKey, permValue]) => ({
                    value: true,
                    id: `${key}-${permKey}`,
                    name: `${key}-${permKey}`,
                    label: permKey,
                    checked: permValue,
                })),
            });
        }

        checkboxHTML += "</div></div>";

        const form = $(modalId).find("form");
        form.attr("action", routeUpdate);
        form.find(".block-content.fs-sm").remove();
        form.find('input[name="_method"]').after(checkboxHTML);
        $(modalId)
            .find(".block-title")
            .text(modalTitle + " " + response.name);
        $(modalId).modal("show");
    });
});
