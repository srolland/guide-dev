/*
 *
 * Utility functions
 *
 * @author rclarkson
 *
 */
Postmedia.Utils = (function ($) {

    var isProduction = IsProduction(),
        userAgent = GetUserAgent();

    function Init() {
        //Add Constructor Code
    }

    function Log(a) {

        if(userAgent !== "msie" && isProduction == false){
            console.log(a);
        }
    }

    /**
    * Capitalizes first letter of string.
    * Should Refactor into Utils.
    * @return {String} - 'String' from 'string'
    * @param {String} string
    * @method capitaliseFirstLetter
    */
    function CapitaliseFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function GetScreenSize(){

        var screenSize = "small";

        if( $( window ).width() > 1200 ){

		    screenSize = "large";

	    }else if( $( window ).width() > 768 ){

		    screenSize = "medium";

	    }

        return screenSize;
    }

    function GetImageSize(){

        var imageSize = "320";

        switch(GetScreenSize()){

            case "large":
                imageSize = "1200"
                break;
            case "medium":
                imageSize = "768"
                break;
        }

        if(Postmedia.Properties.isModal){
            imageSize = "modal";
        }

        return imageSize;
    }

    function PreventKeyScroll() {

        document.onkeydown = function (evt) {

            evt = evt || window.event;
            var keyCode = evt.keyCode;

            if (keyCode >= 37 && keyCode <= 40) {
                return false;
            }

        };
    }

    function GetQueryString(name) {

        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        
        var regexS = "[\\?&]" + name + "=([^&#]*)",
        	regex = new RegExp(regexS),
        	results = regex.exec(window.location.href);
        
        if (results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

	function GetHashTagString(name) {

        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        
        var regexS = "[\\#&]" + name + "=([^&#]*)",
        	regex = new RegExp(regexS),
        	results = regex.exec(window.location.href);
        
        if (results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    function GetUserAgent() {

        var retAgent,
	        userAgents = [];

        userAgents = userAgents.concat(Postmedia.Properties.userAgents, Postmedia.Properties.mobileAgents);

        for (var i = 0; i < userAgents.length; i++) {

            if (navigator.userAgent.toLowerCase().indexOf(userAgents[i]) > -1) {
                retAgent = userAgents[i];
            }

        }

        return retAgent;
    }

    function IsMobile() {

        var retVal = false;

        for (var i = 0; i < Postmedia.Properties.mobileAgents.length; i++) {

            if (navigator.userAgent.toLowerCase().indexOf(Postmedia.Properties.mobileAgents[i]) > -1) {
                retVal = true;
                break;
            }
        }

        return retVal;
    }

    function GetDeviceWidth() {
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        return width;
    }

    function IsProduction() {

        if (window.location.href.search("o.canada.com") != -1) {
            return true;
        } else {
            return false;
        }
    }

	function GetRelativeTimeMessage(time, isApiFeed) {

        var dateTime, temp;

        // This is a bit of a hack because we have two different feeds with two different UTC dateTime formats
        // API.twitter - Wed Jul 04 18:50:00 +0000 2012
        // Search.twitter - Wed, 04 Jul 2012 18:51:59 +0000
        // Needs to be done properly
        if((isApiFeed || !userAgent === "msie")){

	        dateTime = Date.parse(time);
	        temp = new Date(time);

        } else {

	        dateTime = parseDate(time);
	        temp = parseDate(time);

        }

        dateTime = Date.UTC(temp.getUTCFullYear(), temp.getUTCMonth(), temp.getUTCDate(), temp.getUTCHours(), temp.getUTCMinutes(), temp.getUTCSeconds()) / 60000;

        var local = new Date(),
	        local = Date.UTC(local.getUTCFullYear(), local.getUTCMonth(), local.getUTCDate(), local.getUTCHours(), local.getUTCMinutes(), local.getUTCSeconds()) / 60000,
	        minutes = Math.floor(local - dateTime);

        // Format the response message
        if (minutes < 1) {
            return 'less than a minute ago';
        }
        else if (minutes < 2) {
            return '1 minute ago';
        }
        else if (minutes < 59) {
            return (minutes + ' minutes ago');
        }

        var hours = Math.floor(minutes / 60);
        if (hours < 2) {
            return '1 hour ago';
        }
        else if (hours < 24) {
            return (hours + ' hours ago');
        }

        var days = Math.floor(hours / 24);
        if (days < 2) {
            return '1 day ago';
        }
        return (days + ' days ago');
    }

    function parseDate(str) {
        var v = str.split(' ');
        return new Date(Date.parse(v[1]+" "+v[2]+", "+v[5]+" "+v[3]+" UTC"));
    }

    function CleanForJS(s){

        s = s.replace(/'/g, "\\\'");
        s = s.replace(/\"/g, "\\\'");

        return s;
    }

    function PopupCenter(pageUrl, title,w,h) {

        var left = (screen.width/2)-(w/2),
        	top = (screen.height/2)-(h/2),
        	targetWin = window.open( pageUrl, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left );

        Log(pageUrl);

    }

    return {
        Init: Init,
        Log: Log,
        CapitaliseFirstLetter: CapitaliseFirstLetter,
        CleanForJS : CleanForJS,
        GetQueryString: GetQueryString,
		GetHashTagString:GetHashTagString,
        GetDeviceWidth: GetDeviceWidth,
        PreventKeyScroll: PreventKeyScroll,
        IsMobile: IsMobile,
        GetScreenSize : GetScreenSize,
        GetImageSize : GetImageSize,
		GetRelativeTimeMessage : GetRelativeTimeMessage,
        isProduction: isProduction,
        PopupCenter: PopupCenter,
        userAgent : userAgent
    }

} (jQuery));