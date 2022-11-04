;
(function($) {
    "use strict";


    var faqAcc = function($scope, $) {
        $("#accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var eventAcc = function($scope, $) {
        $("#event-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var portalAcc = function($scope, $) {
        $("#portal-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var usageAcc = function($scope, $) {
        $("#usage-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var webhookAcc = function($scope, $) {
        $("#webhook-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var purchaseAcc = function($scope, $) {
        $("#purchase-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var orderAcc = function($scope, $) {
        $("#order-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var accountAcc = function($scope, $) {
        $("#account-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var productAcc = function($scope, $) {
        $("#product-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };



    var transAcc = function($scope, $) {
        $("#trans-accordion ul li").each(function() {
            var trigger = $(this).find('a');
            var acc_text = $(this).find('.accordion');
            $(acc_text).hide();
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle();
            });
        });
    };




    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/eb-faq-acc.default', faqAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/event-api-acc.default', eventAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/portal-api-acc.default', portalAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/usage-api-acc.default', usageAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/webhook-api-acc.default', webhookAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/purchase-api-acc.default', purchaseAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/eb-orders-api.default', orderAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/account-api-acc.default', accountAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/trans-api-acc.default', transAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/product-api-acc.default', productAcc);
    });
})(jQuery);