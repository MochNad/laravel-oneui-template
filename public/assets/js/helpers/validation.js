(function () {
    "use strict";

    class Validator {
        static initValidation() {
            One.helpers("jq-validation");

            jQuery.validator.addMethod("hasCapitals", function(value, element) {
                return /[A-Z]/.test(value);
            }, "Must contain at least one capital letter.");

            jQuery.validator.addMethod("hasNumbers", function(value, element) {
                return /\d/.test(value);
            }, "Must contain at least one number.");

            jQuery.validator.addMethod("hasSpecials", function(value, element) {
                return /[!@#$%^&*(),.?":{}|<>]/.test(value);
            }, "Must contain at least one special character.");

            jQuery("form").each(function () {
                const form = jQuery(this);
                const rules = {};
                const messages = {};

                form.find("[data-input-validation]").each(function () {
                    const input = jQuery(this);
                    const name = input.attr("name");
                    const validations = input.data("input-validation").split("|");

                    rules[name] = {};
                    messages[name] = {};

                    validations.forEach((validation) => {
                        const [rule, param] = validation.split(":");
                        switch (rule) {
                            case "required":
                                rules[name].required = true;
                                messages[name].required = `The ${name} field is required.`;
                                break;
                            case "email":
                                rules[name].email = true;
                                messages[name].email = `The ${name} field must be a valid email address.`;
                                break;
                            case "min":
                                rules[name].minlength = param;
                                messages[name].minlength = `The ${name} field must be at least ${param} characters.`;
                                break;
                            case "same":
                                rules[name].equalTo = `input[name="${param}"]`;
                                messages[name].equalTo = `The ${name} field must be the same as the ${param} field.`;
                                break;
                            case "accepted":
                                rules[name].required = true;
                                messages[name].required = `The ${name} field must be accepted.`;
                                break;
                            case "capitals":
                                rules[name].hasCapitals = true;
                                break;
                            case "numbers":
                                rules[name].hasNumbers = true;
                                break;
                            case "specials":
                                rules[name].hasSpecials = true;
                                break;
                            default:
                                break;
                        }
                    });
                });

                form.validate({
                    rules: rules,
                    messages: messages
                });
            });
        }

        static init() {
            this.initValidation();
        }
    }

    One.onLoad(() => Validator.init());
})();
