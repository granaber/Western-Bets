<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Another attempt at CSS rounded-corner dialogs using the sliding doors technique</title>
<style type="text/css">

/* this is an example page. Real-use cases should never have inline CSS like this. ;) */

body {
 font:normal 76% georgia,helvetica,verdana,tahoma,arial,"sans serif";
}

.dialog {
 width:67%;
 margin:0px;
 min-width:20em;
 max-width:430px; /* I only cut the left background images out to 800px. You could do much larger, etc. */
 color:#fff;
}

.dialog .hd .c,
.dialog .ft .c {
 font-size:1px; /* ensure minimum height */
 height:11px;
}

.dialog .ft .c {
 height:14px;
}

.dialog .hd {
 background:transparent url(media/tl.png) no-repeat 0px 0px;
 margin-right:14px; /* space for right corner */
}

.dialog .hd .c {
 background:transparent url(media/tr.png) no-repeat right 0px;
 margin-right:-14px; /* pull right corner back over "empty" space (from above margin) */
}

.dialog .bd {
 background:transparent url(media/ml.png) repeat-y 0px 0px;
 margin-right:6px;
}

.dialog .bd .c {
 background:transparent url(media/mr.png) repeat-y right 0px;
 margin-right:-6px;
}

.dialog .bd .c .s {
 margin:0px 8px 0px 4px;
 background: url(media/ms.jpg) repeat-x 0px 0px;
 padding:1em;
}

.dialog .ft {
 background:transparent url(media/bl.png) no-repeat 0px 0px;
 margin-right:14px;
}

.dialog .ft .c {
 background:transparent url(media/br.png) no-repeat right 0px;
 margin-right:-14px;
}

/* content-specific */

.dialog h1 {
 /* header */
 font-size:2em;
 margin:0px;
 padding:0px;
 margin-top:-0.6em;
}

p {
 font-family:verdana,tahoma,arial,"sans serif";
}

.dialog p {
 margin:0.5em 0px 0px 0px;
 padding:0px;
 font:0.95em/1.5em arial,tahoma,"sans serif";
}

html>body .dialog pre {
 font-size:1.1em;
}
.linea {
background: t;
}

</style>
</head>

<body>

<div>

<div class="dialog">
 <div class="hd"><div class="c"></div></div>
 <div class="bd">
  <div class="c">
    <div class="s">
      <p>
        <!-- content area -->
        
        <!-- content area --><label>
            <input type="submit" name="button" id="button" value="Imprimir" onclick="print();" />
            </label>
        <label>
            <input type="submit" name="button2" id="button2" value="&lt;-----Volver"  onclick="window.close();"/>
            </label></p>
      </div>
  </div>
 </div>
 <div class="ft"><div class="c"></div></div>
</div>

</div>

</body>
</html>