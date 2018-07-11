define([
    'underscore',
    'jquery',
    'orotranslation/js/translator'
], function(_, $, __) {
    'use strict';

    var defaultParam = {
        message: 'This is not a valid ABN.'
    };

    var weights = [
        10, 1, 3, 5, 7, 9, 11, 13, 15, 17, 19
    ];

    /**
     * @export abnbundle/js/validator/abn
     */
    return [
        'Aligent\\ABNBundle\\Validator\\Constraints\\ABN',
        function(value, element, options) {
            if (value.length === 0 && element.required) {
                return false;
            } else if (value.length === 0 && !element.required) {
                return true;
            }

            var valid = false;
            value = value.replace(/\s+/g, '');

            if (value.length === 11) {
                var sum = 0;

                _.each(weights, function (weight, position, values) {
                    var digit = value.charAt(position) - (position ? 0 : 1);
                    sum += weight * digit;
                });
                valid = (sum % 89) === 0;
            }

            return valid;
        },
        function(param, element) {
            var value = String(this.elementValue(element));
            var placeholders = {};
            param = _.extend({}, defaultParam, param);
            placeholders.field = value;
            return __(param.message, placeholders);
        }
    ];
});
