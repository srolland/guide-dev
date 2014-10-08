/*
 *
 * Handles Ajax Requests
 *
 * @author rclarkson
 * @todo code the damn thing!
 *
 */
Postmedia.Data = (function ($) {

    function Init() {
        //Add Constructor Code
    }

    /*
    *
    * Makes AJAX call using jQuery getScript.
    * @param {String} - API being called
    * @param {Object} - callback function called on ajaxSuccess
    * @method GetScript
    *
    */
    function GetScript(service, callback) {

        $.getScript(service, function () {
            callback();
        });
    }

    function Ajax(service, callbackFunction, dataType, callType, jsonData, context) {

        //Should make some defaults here
        //Log(decodeURI(service));

        $.ajax({
            url: service,
            data: jsonData,
            type: callType,
            dataType: dataType,
            async: true,
            contentType: 'application/json; charset=utf-8',
            success: function (data, textStatus, XMLHttpRequest) {

                if (data !== null) {
                    callbackFunction(data, context);
                } else {
                    data = {};
                    callbackFunction(data, context);
                }

                Log("Postmedia.Data.AjaxCall : success():  " + decodeURI(service));
            },

            error: function (data, textStatus, errorThrown) {

                data.PMerror = true;
                data.PMlength = 0;
                data.PMmsg = data.Message;

                callbackFunction(data, context);
                Log("Postmedia.Data.AjaxCall : error():<br><br>Details:<br>" + "XHR: " + decodeURI(service) + " XHRStatus: " + textStatus + "XHRError: " + errorThrown);
            },
            statusCode: {
                400: function() {
                    data.PMerror = true;
                    data.error = "400";
                    callbackFunction(data, context);
                }
            },
            complete: function (XMLHttpRequest, textStatus) {
                Log("Postmedia.Data.AjaxCall : complete():  " + decodeURI(service));
            }

        });

    }

    function GetCachedScript(url, options) {

        options = $.extend(options || {}, {
            dataType: "script",
            cache: true,
            url: url
        });

        return $.ajax(options);

    }

    function AppendScript(src, node) {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = src;
        $(node).append(script);
    }

    function WriteScript(src, isInline) {

        //REFACTOR
        if (isInline) {
            document.write('<scr' + 'ipt type="text/javascript">' + src + '<\/sc' + 'ript>');
        } else {
            document.write('<scr' + 'ipt type="text/javascript" src="' + src + '"></scr' + 'ipt>');
        }
    }

    /*
    *
    * Checks the returned JSON object for errors. Removes the ajax throbber gif.
    * @param {Object} response - returned JSON object
    * @return {Boolean}
    * @method dataOk
    *
    */
    function DataOk(response) {
        //$m.utils.hideAjaxLoader();
        //return response.ResponseBatch.Messages[0].Message == "ok" ? true : false;
    }

    function Log(a) {

        //Postmedia.Utils.Log(a);

    }

    return {
        Init: Init,
        AppendScript: AppendScript,
        GetScript: GetScript,
        GetCachedScript: GetCachedScript,
        WriteScript: WriteScript,
        Ajax : Ajax
    }

} (jQuery));