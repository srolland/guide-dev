var schost=window.location.host;
var s_account = "canwestglobal,cancansochi";  // RSID is report suite id in lower case.
if (schost.search("qa.")!=-1 || schost.search("dev.")!=-1 || schost.search("staging.")!=-1)
s_account = "canpublishing,canwestglobaldev"