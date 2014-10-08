//sochi
var scdir=window.location.pathname.split('/'); //[0]="";
var scfilenameloc=scdir.length-1;
s.pageName=window.location.pathname;
s.server=window.location.hostname.toLowerCase();
s.channel=scdir[1];
s.prop2=scdir.slice(1).join('/');
s.prop3="wordpress vip"; //  If hosted internally, "postmedia".
s.prop25=scdir[scdir.length-1].split('.',1);  // Content type. Filename of page, excluding extension. 'index'.
s.prop27=s.channel;
s.prop28=s.channel;
s.prop29=s.channel;
if (scfilenameloc>1){s.prop27=s.prop27+"/"+scdir[2];s.prop28=s.prop28+"/"+scdir[2];s.prop29=s.prop29+"/"+scdir[2];}
if (scfilenameloc>2){s.prop28=s.prop28+"/"+scdir[3];s.prop29=s.prop29+"/"+scdir[3];}
if (scfilenameloc>3)s.prop29=s.prop29+"/"+scdir[4];