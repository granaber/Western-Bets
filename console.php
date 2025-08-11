<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
<script>
/*alert(window.console)
//alert(window.console.firebug)
if (window.console ) 
	alert('asi no');*/
	
	//alert(window.console.info);
	
	
	window.console.clear();
	
	/*for (var x in console) 
	alert( console[x]);

for (var x in console) 
delete console[x];
*/


if (! ('console' in window) || !('firebug' in console)) {
    var names = ['log', 'debug', 'info', 'warn', 'error', 'assert', 'dir', 'dirxml', 'group', 'groupEnd', 'time', 'timeEnd', 'count', 'trace', 'profile', 'profileEnd'];
    window.console = {};
    for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
}
</script>
</html>
