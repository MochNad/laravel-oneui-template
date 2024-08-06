!(function () {
    "use strict";

    class Validator {
        static initValidation() {
            One.helpers("jq-validation");

            Validator.addCustomValidationMethods();

            jQuery("form").each(function () {
                Validator.setupFormValidation(jQuery(this));
            });
        }

        static addCustomValidationMethods() {
            jQuery.validator.addMethod(
                "hasCapitals",
                function (value, element) {
                    return this.optional(element) || /[A-Z]/.test(value);
                },
                "Must contain at least one capital letter."
            );

            jQuery.validator.addMethod(
                "hasNumbers",
                function (value, element) {
                    return this.optional(element) || /\d/.test(value);
                },
                "Must contain at least one number."
            );

            jQuery.validator.addMethod(
                "hasSpecials",
                function (value, element) {
                    return (
                        this.optional(element) ||
                        /[!@#$%^&*(),.?":{}|<>]/.test(value)
                    );
                },
                "Must contain at least one special character."
            );

            jQuery.validator.addMethod(
                "optional",
                function (value, element) {
                    return true;
                },
                "This field is optional."
            );

            jQuery.validator.addMethod(
                "same",
                function (value, element, param) {
                    return this.optional(element) || value === $(param).val();
                },
                "The value must be the same."
            );

            jQuery.validator.addMethod(
                "lowercaseOnly",
                function (value, element, param) {
                    const allowedChars = param
                        ? new RegExp(`^[a-z0-9${param}]+$`)
                        : /^[a-z0-9.]+$/;
                    return this.optional(element) || allowedChars.test(value);
                },
                "The value must contain only lowercase letters, numbers, and allowed symbols."
            );

            jQuery.validator.addMethod(
                "uppercaseOnly",
                function (value, element, param) {
                    const allowedChars = param
                        ? new RegExp(`^[A-Z0-9${param}]+$`)
                        : /^[A-Z0-9.]+$/;
                    return this.optional(element) || allowedChars.test(value);
                },
                "The value must contain only uppercase letters, numbers, and allowed symbols."
            );

            jQuery.validator.addMethod(
                "onlyNumbers",
                function (value, element, param) {
                    const allowedChars = param
                        ? new RegExp(`^[0-9${param}]+$`)
                        : /^[0-9]+$/;
                    return this.optional(element) || allowedChars.test(value);
                },
                "The value must contain only numbers and allowed symbols."
            );

            jQuery.validator.addMethod(
                "onlyLetters",
                function (value, element, param) {
                    const allowedChars = param
                        ? new RegExp(`^[a-zA-Z${param}]+$`)
                        : /^[a-zA-Z]+$/;
                    return this.optional(element) || allowedChars.test(value);
                },
                "The value must contain only letters and allowed symbols."
            );

            jQuery.validator.addMethod(
                "onlyAlphanum",
                function (value, element, param) {
                    const allowedChars = param
                        ? new RegExp(`^[a-zA-Z0-9${param}]+$`)
                        : /^[a-zA-Z0-9]+$/;
                    return this.optional(element) || allowedChars.test(value);
                },
                "The value must contain only letters, numbers, and allowed symbols."
            );

            jQuery.validator.addMethod(
                "empty",
                function (value, element, param) {
                    const fields = param
                        .split(",")
                        .map((field) => field.trim());

                    const form = $(element).closest("form");

                    fields.forEach((field) => {
                        const target = form.find(`[name="${field}"]`);

                        if (value !== "" && target.val() !== "") {
                            target
                                .val("")
                                .trigger("change")
                                .trigger("select2:unselect");
                        }
                    });

                    return true;
                },
                "This field is emptying the target field."
            );
        }

        static setupFormValidation(form) {
            const rules = {};
            const messages = {};

            form.find("[data-input-validation]").each(function () {
                Validator.setupInputValidation(jQuery(this), rules, messages);
            });

            form.validate({
                rules: rules,
                messages: messages,
            });
        }

        static setupInputValidation(input, rules, messages) {
            const name = input.attr("name");
            const validations = input.data("input-validation").split("|");

            rules[name] = {};
            messages[name] = {};

            validations.forEach((validation) => {
                Validator.processValidationRule(
                    validation,
                    name,
                    rules,
                    messages
                );
            });

            input.on("input", function () {
                Validator.handleInputConstraints(input, rules[name]);
                input.valid();
            });

            input.on("select2:select select2:unselect", function () {
                input.valid();
            });
        }

        static processValidationRule(validation, name, rules, messages) {
            const [rule, param] = validation.split(":");
            switch (rule) {
                case "min":
                    rules[name].minlength = param;
                    messages[
                        name
                    ].minlength = `The ${name} field must be at least ${param} characters.`;
                    break;
                case "max":
                    rules[name].maxlength = param;
                    messages[
                        name
                    ].maxlength = `The ${name} field must be at most ${param} characters.`;
                    break;
                case "same":
                    rules[name].equalTo = `input[name="${param}"]`;
                    messages[
                        name
                    ].equalTo = `The ${name} field must be the same as the ${param} field.`;
                    break;
                case "accepted":
                    rules[name].required = true;
                    messages[
                        name
                    ].required = `The ${name} field must be accepted.`;
                    break;
                case "has_capitals":
                    rules[name].hasCapitals = true;
                    break;
                case "has_numbers":
                    rules[name].hasNumbers = true;
                    break;
                case "has_specials":
                    rules[name].hasSpecials = true;
                    break;
                case "optional":
                    rules[name].optional = true;
                    break;
                case "only_numbers":
                    rules[name].onlyNumbers = param || true;
                    messages[
                        name
                    ].onlyNumbers = `The ${name} field must contain only numbers and allowed symbols.`;
                    break;
                case "only_letters":
                    rules[name].onlyLetters = param || true;
                    messages[
                        name
                    ].onlyLetters = `The ${name} field must contain only letters and allowed symbols.`;
                    break;
                case "only_alphanum":
                    rules[name].onlyAlphanum = param || true;
                    messages[
                        name
                    ].onlyAlphanum = `The ${name} field must contain only letters, numbers, and allowed symbols.`;
                    break;
                case "only_lowercase":
                    rules[name].lowercaseOnly = param || true;
                    break;
                case "only_uppercase":
                    rules[name].uppercaseOnly = param || true;
                    break;
                case "allow":
                    if (rules[name].lowercaseOnly) {
                        rules[name].lowercaseOnly = param;
                    } else if (rules[name].uppercaseOnly) {
                        rules[name].uppercaseOnly = param;
                    } else if (rules[name].onlyNumbers) {
                        rules[name].onlyNumbers = param;
                    } else if (rules[name].onlyLetters) {
                        rules[name].onlyLetters = param;
                    } else if (rules[name].onlyAlphanum) {
                        rules[name].onlyAlphanum = param;
                    }
                    break;
                case "empty":
                    rules[name].empty = param;
                    break;
                default:
                    break;
            }
        }

        static handleInputConstraints(input, rules) {
            const maxLength = rules.maxlength;
            const onlyNumbers = rules.onlyNumbers;
            const onlyLetters = rules.onlyLetters;
            const onlyAlphanum = rules.onlyAlphanum;
            const onlyLowercase = rules.lowercaseOnly;
            const onlyUppercase = rules.uppercaseOnly;

            if (maxLength && input.val().length > maxLength) {
                input.val(input.val().slice(0, maxLength));
            }

            if (onlyNumbers) {
                const regex = new RegExp(
                    `^[0-9${onlyNumbers === true ? "" : onlyNumbers}]+$`
                );
                if (!regex.test(input.val())) {
                    input.val(
                        input
                            .val()
                            .replace(
                                new RegExp(
                                    `[^0-9${
                                        onlyNumbers === true ? "" : onlyNumbers
                                    }]`,
                                    "g"
                                ),
                                ""
                            )
                    );
                }
            }

            if (onlyLetters) {
                const regex = new RegExp(
                    `^[a-zA-Z${onlyLetters === true ? "" : onlyLetters}]+$`
                );
                if (!regex.test(input.val())) {
                    input.val(
                        input
                            .val()
                            .replace(
                                new RegExp(
                                    `[^a-zA-Z${
                                        onlyLetters === true ? "" : onlyLetters
                                    }]`,
                                    "g"
                                ),
                                ""
                            )
                    );
                }
            }

            if (onlyAlphanum) {
                const regex = new RegExp(
                    `^[a-zA-Z0-9${onlyAlphanum === true ? "" : onlyAlphanum}]+$`
                );
                if (!regex.test(input.val())) {
                    input.val(
                        input
                            .val()
                            .replace(
                                new RegExp(
                                    `[^a-zA-Z0-9${
                                        onlyAlphanum === true
                                            ? ""
                                            : onlyAlphanum
                                    }]`,
                                    "g"
                                ),
                                ""
                            )
                    );
                }
            }

            if (onlyLowercase) {
                input.val(input.val().toLowerCase());
                const regex = new RegExp(
                    `^[a-z0-9${onlyLowercase === true ? "" : onlyLowercase}]+$`
                );
                if (!regex.test(input.val())) {
                    input.val(
                        input
                            .val()
                            .replace(
                                new RegExp(
                                    `[^a-z0-9${
                                        onlyLowercase === true
                                            ? ""
                                            : onlyLowercase
                                    }]`,
                                    "g"
                                ),
                                ""
                            )
                    );
                }
            }

            if (onlyUppercase) {
                input.val(input.val().toUpperCase());
                const regex = new RegExp(
                    `^[A-Z0-9${onlyUppercase === true ? "" : onlyUppercase}]+$`
                );
                if (!regex.test(input.val())) {
                    input.val(
                        input
                            .val()
                            .replace(
                                new RegExp(
                                    `[^A-Z0-9${
                                        onlyUppercase === true
                                            ? ""
                                            : onlyUppercase
                                    }]`,
                                    "g"
                                ),
                                ""
                            )
                    );
                }
            }
        }

        static init() {
            this.initValidation();
        }
    }

    One.onLoad(() => Validator.init());
})();
