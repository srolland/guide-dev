/* This file should only be used to set the s_account variable (report suite variable) as the "s" object will not have been created at this point.
To overwrite default variables, modify /js/local_s_code.js */

var s_account = "canwestglobal,cancansochi"
var schost=window.location.host;
var scpathArray=window.location.pathname.split('/');
if (schost.search("qa.")!=-1||schost.search("dev.")!=-1||schost.search("staging.")!=-1)
	s_account = "canpublishing,canwestglobaldev"
else if (scpathArray[1]!=undefined&&scpathArray[1]!=""&&scpathArray[1]=="mobile")
	s_account="canwestglobal,canmobilenews"
else if (scpathArray[1]!=undefined&&scpathArray[1]!=""&&scpathArray[1]=="webslice")
	s_account="canwestglobal,canwebslice"