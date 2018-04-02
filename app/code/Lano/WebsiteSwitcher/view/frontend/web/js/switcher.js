/**
 * Created by julianovargas on 24/03/2018.
 */
define([
    "jquery",
    'Magento_Ui/js/modal/alert',
    "jquery/ui",
    'underscore',
    'ko',
    'mage/url',
], function ($, alert, jUi, _, ko, urlBuilder) {
    'use strict';
    $.widget('mage.websiteSwitcher', {
        options: {
            confirmMsg: ('divElement is removed.'),
            url: 'websiteSwitcher/Index/SwitcherAction'
        },
        _create: function () {
            var self = this;
            $(self.options.divElement).on('click', function(e){
                //e.preventDefault();
                //self._ajax(self.options.url, {
                  //  'item_code': $(e.currentTarget).find('a').attr('data-website')
                //});
                //console.log('ok');
            });
        },
        /**
         * @param {String} url - ajax url
         * @param {Object} data - post data for ajax call
         * @param {Object} elem - element that initiated the event
         * @param {Function} callback - callback method to execute after AJAX success
         */
        _ajax: function (url, data) {
            $.extend(data, {
                'form_key': $.mage.cookies.get('form_key')
            });
            $.ajax({
                url: urlBuilder.build(url),
                data: data,
                type: 'post',
                dataType: 'json',
                context: this,
            }).done(function (response) {
                if(response.success) {
                    console.log(response)
                }else {
                    alert('Something went wrong!')
                }
            }).fail(function (error) {
                console.log(JSON.stringify(error));
            });
        },
    });
    return $.mage.websiteSwitcher;
});