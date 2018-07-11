define([
    'oroui/js/app/controllers/base/controller'
], function (BaseController) {
    'use strict';

    BaseController.loadBeforeAction([
        'jquery', 'jquery.validate'
    ], function ($) {
        $.validator.loadMethod('aligentabn/js/validator/abn');
    });
});
