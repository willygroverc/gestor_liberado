/*
 * validate.js 1.1
 * Copyright (c) 2011 Rick Harrison, http://rickharrison.me
 * validate.js is open sourced under the MIT license.
 * Portions of validate.js are inspired by CodeIgniter.
 * http://rickharrison.github.com/validate.js
 */

(function(window, document, undefined) {
    /*
     * If you would like an application-wide config, change these defaults.
     * Otherwise, use the setMessage() function to configure form specific messages.
     */

    var defaults = {
        messages: {
			etq_HTML: 'Se han detectado caracteres de entrada NO validos en el campo %s',
			fecha:' La %s es incorrecta, verifique por favor.',
            required: 'El campo %s no puede ser vacio.',
            matches: 'Los campos %s y %s no coinciden.',
            valid_email: 'El %s introducido no es v�lido.',
            valid_emails: 'The %s field must contain all valid email addresses.',
            min_length: 'El campo %s debe contener al menos %s caracteres.',
            max_length: 'La longitud del campo %s no debe exceder en %s caracteres.',
            exact_length: 'EL campo %s  debe contener %s caracteres exactamente.',
            greater_than: 'El campo %s debe contener un numero mayor a %s.',
            less_than: 'El campo %s debe contener un numero menor a %s.',
            alpha: 'El campo %s solo admite letras sin espacios.',
            alpha_numeric: 'El campo %s solo admite letras y numeros.',
            alpha_dash: 'The %s field must only contain alpha-numeric characters, underscores, and dashes.',
            numeric: 'El campo %s solo admite valores numericos.',
            integer: 'El campo %s solo admite numeros.',
            decimal: 'El campo %s solo admite numeros y decimales.',
            is_natural: 'El campo %s solo admite numeros positivos.',
            is_natural_no_zero: 'The %s field must contain a number greater than zero.',
            valid_ip: 'El campo %s solo admite IPs validas.',
            valid_base64: 'The %s field must contain a base64 string.'
        },
        callback: function(errors) {
        }
    };

    /*
     * Define the regular expressions that will be used
     */
    var 
		fechaRegex= /^[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9]$/,
		htmlRegex= /^([1-zA-Z0-1.s]{1,255})$/ ,
		ruleRegex = /^(.+)\[(.+)\]$/,
        numericRegex = /^[0-9]+$/,
        integerRegex = /^\-?[0-9]+$/,
        decimalRegex = /^\-?[0-9]*\.?[0-9]+$/,
        emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,6}$/i,
        alphaRegex = /^[a-z]+$/i,
        alphaNumericRegex = /^[a-z0-9]+$/i,
        alphaDashRegex = /^[a-z0-9_-]+$/i,
        naturalRegex = /^[0-9]+$/i,
        naturalNoZeroRegex = /^[1-9][0-9]*$/i,
        ipRegex = /^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/i,
        base64Regex = /[^a-zA-Z0-9\/\+=]/i;

    /*
     * The exposed public object to validate a form:
     *
     * @param formName - String - The name attribute of the form (i.e. <form name="myForm"></form>)
     * @param fields - Array - [{
     *     name: The name of the element (i.e. <input name="myField" />)
     *     display: 'Field Name'
     *     rules: required|matches[password_confirm]
     * }]
     * @param callback - Function - The callback after validation has been performed.
     *     @argument errors - An array of validation errors
     *     @argument event - The javascript event
     */

    var FormValidator = function(formName, fields, callback) {
        this.callback = callback || defaults.callback;
        this.errors = [];
        this.fields = {};
        this.form = document.forms[formName] || {};
        this.messages = {};
        this.handlers = {};

        for (var i = 0, fieldLength = fields.length; i < fieldLength; i++) {
            var field = fields[i];

            // If passed in incorrectly, we need to skip the field.
            if (!field.name || !field.rules) {
                continue;
            }

            /*
             * Build the master fields array that has all the information needed to validate
             */

            this.fields[field.name] = {
                name: field.name,
                display: field.display || field.name,
                rules: field.rules,
                id: null,
                type: null,
                value: null,
                checked: null
            };
        }

        /*
         * Attach an event callback for the form submission
         */

        this.form.onsubmit = (function(that) {
            return function(event) {
                try {
					return that._validateForm(event);
					
                } catch(e) {}
            }
        })(this);
    };

    /*
     * @public
     * Sets a custom message for one of the rules
     */

    FormValidator.prototype.setMessage = function(rule, message) {
        this.messages[rule] = message;

        // return this for chaining
        return this;
    };

    /*
     * @public
     * Registers a callback for a custom rule (i.e. callback_username_check)
     */

    FormValidator.prototype.registerCallback = function(name, handler) {
        if (name && typeof name === 'string' && handler && typeof handler === 'function') {
            this.handlers[name] = handler;
        }

        // return this for chaining
        return this;
    };

    /*
     * @private
     * Runs the validation when the form is submitted.
     */

    FormValidator.prototype._validateForm = function(event) {
        this.errors = [];

        for (var key in this.fields) {
            if (this.fields.hasOwnProperty(key)) {
                var field = this.fields[key] || {},
                    element = this.form[field.name];

                if (element && element !== undefined) {
                    field.id = element.id;
                    field.type = element.type;
                    field.value = element.value;
                    field.checked = element.checked;
                }

                /*
                 * Run through the rules for each field.
                 */

                this._validateField(field);
            }
        }

        if (typeof this.callback === 'function') {
            this.callback(this.errors, event);
        }

        if (this.errors.length > 0) {
            if (event && event.preventDefault) {
                event.preventDefault();
            } else {
                // IE6 doesn't pass in an event parameter so return false
                return false;
            }
        }

        return true;
    };

    /*
     * @private
     * Looks at the fields value and evaluates it against the given rules
     */

    FormValidator.prototype._validateField = function(field) {
        var rules = field.rules.split('|');

        /*
         * If the value is null and not required, we don't need to run through validation
         */

        if (field.rules.indexOf('required') === -1 && (!field.value || field.value === '' || field.value === undefined)) {
            return;
        }

        /*
         * Run through the rules and execute the validation methods as needed
         */

        for (var i = 0, ruleLength = rules.length; i < ruleLength; i++) {
            var method = rules[i],
                param = null,
                failed = false;

            /*
             * If the rule has a parameter (i.e. matches[param]) split it out
             */

            if (parts = ruleRegex.exec(method)) {
                method = parts[1];
                param = parts[2];
            }

            /*
             * If the hook is defined, run it to find any validation errors
             */

            if (typeof this._hooks[method] === 'function') {
                if (!this._hooks[method].apply(this, [field, param])) {
                    failed = true;
                }
            } else if (method.substring(0, 9) === 'callback_') {
                // Custom method. Execute the handler if it was registered
                method = method.substring(9, method.length);

                if (typeof this.handlers[method] === 'function') {
                    if (this.handlers[method].apply(this, [field.value]) === false) {
                        failed = true;
                    }
                }
            }

            /*
             * If the hook failed, add a message to the errors array
             */

            if (failed) {
                // Make sure we have a message for this rule
                var source = this.messages[method] || defaults.messages[method],
                    message = 'An error has occurred with the ' + field.display + ' field.';

                if (source) {
                    message = source.replace('%s', field.display);

                    if (param) {
                        message = message.replace('%s', (this.fields[param]) ? this.fields[param].display : param);
                    }
                }
                
                this.errors.push({
                    id: field.id,
                    name: field.name,
                    message: message 
                });

                // Break out so as to not spam with validation errors (i.e. required and valid_email)
                break;
            }
        }
    };

    /*
     * @private
     * Object containing all of the validation hooks
     */

    FormValidator.prototype._hooks = {
        required: function(field) {
            var value = field.value;

            if (field.type === 'checkbox') {
                return (field.checked === true);
            }

            return (value !== null && value !== '');
        },
		
		etq_html: function(field){
			return (htmlRegex.test(field.value));
		},
		
		fecha: function(field){
			return(fechaRegex.test(field.value));
		},

        matches: function(field, matchName) {
            if (el = this.form[matchName]) {
                return field.value === el.value;
            }

            return false;
        },

        valid_email: function(field) {
            return emailRegex.test(field.value);
        },

        valid_emails: function(field) {
            var result = field.value.split(",");
            
            for (var i = 0; i < result.length; i++) {
                if (!emailRegex.test(result[i])) {
                    return false;
                }
            }
            
            return true;
        },

        min_length: function(field, length) {
            if (!numericRegex.test(length)) {
                return false;
            }

            return (field.value.length >= parseInt(length, 10));
        },

        max_length: function(field, length) {
            if (!numericRegex.test(length)) {
                return false;
            }

            return (field.value.length <= parseInt(length, 10));
        },

        exact_length: function(field, length) {
            if (!numericRegex.test(length)) {
                return false;
            }
            
            return (field.value.length === parseInt(length, 10));
        },

        greater_than: function(field, param) {
            if (!decimalRegex.test(field.value)) {
                return false;
            }

            return (parseFloat(field.value) > parseFloat(param));
        },

        less_than: function(field, param) {
            if (!decimalRegex.test(field.value)) {
                return false;
            }

            return (parseFloat(field.value) < parseFloat(param));
        },
		

        alpha: function(field) {
            return (alphaRegex.test(field.value));
        },

        alpha_numeric: function(field) {
            return (alphaNumericRegex.test(field.value));
        },

        alpha_dash: function(field) {
            return (alphaDashRegex.test(field.value));
        },

        numeric: function(field) {
            return (decimalRegex.test(field.value));
        },

        integer: function(field) {
            return (integerRegex.test(field.value));
        },

        decimal: function(field) {
            return (decimalRegex.test(field.value));
        },

        is_natural: function(field) {
            return (naturalRegex.test(field.value));
        },

        is_natural_no_zero: function(field) {
            return (naturalNoZeroRegex.test(field.value));
        },

        valid_ip: function(field) {
            return (ipRegex.test(field.value));
        },

        valid_base64: function(field) {
            return (base64Regex.test(field.value));
        }
    };

    window.FormValidator = FormValidator;

})(window, document);
