<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>xFenster Demo 1</title>
<meta name='author' content='Mike Foster (Cross-Browser.com)'>
<meta name='description' content="Cross-Browser Javascript Libraries and Applications">
<meta name='keywords' content='javascript,dhtml,crossbrowser,animation,tooltips,menu,collapsible,dhtml drag drop,downgradeable layout,dynamic select,image rollover,dhtml layout,css,dom,api,library,dhtml demos,lgpl code,unobtrusive dhtml,dom2 events,dynamic forms,animation,ellipse,parametric equation,object-oriented javascript'>
<meta name='license' content='Distributed under the terms of the GNU LGPL (gnu.org)'>
<link rel='stylesheet' type='text/css' href='x/lib/v3.css'>
<link rel='stylesheet' type='text/css' href='x/lib/xfenster.css'>
<style type='text/css'>
.fenster-content {
  padding:1em;
}
</style>
<script type='text/javascript' src='x/lib/x_core.js'></script>
<script type='text/javascript' src='x/lib/x_event.js'></script>
<script type='text/javascript' src='x/lib/xenabledrag.js'></script>
<script type='text/javascript' src='x/lib/xfenster.js'></script>
<script type='text/javascript'>

document.write("<style type='text/css'>.xFenster {display:none}</style>");

var data = [ ['xf1', 'Ticket Virtual', null, 125, false, 0]];

xAddEventListener(window, 'load',
  function() {
    for (var i = 0; i < data.length; ++i) {
      new xFenster(data[i][0], data[i][1], data[i][2], 150+i*50, 150+i*30, 400, 500, data[i][3], null, i, 1, data[i][5],true);
    }

    xf1Load();
  // setInterval(ticker, 1000);
  }, false
);


function ticker()
{
  xFenster.instances.xf3.status(new Date().toString());
}
function xf1Load()
{

  xFenster.instances.xf1.client.innerHTML =
    "<div class='fenster-content'>" +
    "<p>You can <i>focus<\/i> me by clicking anywhere on me or on one of my child elements.<\/p>" +
    "<p>You can <i>move<\/i> me by dragging on the title bar.<\/p>" +
    "<p>You can <i>minimize<\/i> me by clicking on the <img src='x/lib/images/xf_minimize_icon.gif'> icon.<\/p>" +
    "<p>You can <i>maximize<\/i> me by clicking on the <img src='x/lib/images/xf_maximize_icon.gif'> icon or by double-clicking on the title bar.<\/p>" +
    "<p>You can <i>restore<\/i> me by clicking on the <img src='x/lib/images/xf_restore_icon.gif'> icon.<\/p>" +
    "<p>You can <i>close<\/i> me by clicking on the <img src='x/lib/images/xf_close_icon.gif'> icon.<\/p>" +
    "<p>You can <i>resize<\/i> me by dragging on the <img src='x/lib/images/xf_resize_icon.gif'> icon.<\/p>" +
    "<\/div>";
}
</script>
</head>
<body><div id='topLinkCon'><a name='topofpg'>&nbsp;</a></div>

<div id='leftColumn' class='column'> <!-- Begin left column -->

<div class='leftContent'> <!-- Begin left content -->

<div id='header'>
<div id='menubar1'>
<a href='x/lib/images' title='X Library Viewer'>XV</a>&nbsp;|&nbsp;<a href='../../x/docs/xc_reference.php' title='X Library Compiler'>XC</a>&nbsp;|&nbsp;<a href='../../toys/' title='Demos and Applications'>Demos</a>&nbsp;|&nbsp;<a href='../../talk/' title='Articles and Documentation'>Docs</a>&nbsp;|&nbsp;<a href='../../forums/' title='X Library Community'>Forums</a>&nbsp;|&nbsp;<a href='../../' title='Cross-Browser.com'>Home</a>
</div> <!-- end menubar1 -->
<h1>Cross-Browser.com</h1>
</div> <!-- end header -->

<h2>xFenster Demo 1</h2>

<h3>Intro</h3>
<div>
  <p>This demo illustrates...</p>
  <ul>
    <li>Creating fensters from static and dynamic DIVs.</li>
    <li>Different border styles.</li>
    <li>Updating the status bar every second.</li>
    <li>Fensters with and without status bars.</li>
    <li>Fixed fensters that do not scroll with the page.</li>
  </ul>
  <p>View xFenster <a href='http://cross-browser.com/x/lib/view.php?sym=xFenster'>Source &amp; Docs</a>.</p>
</div>

<h3>xFenster Demos</h3>
<div>
  <p><a href='../../x/examples/xfenster.php'>Demo 1</a>, <a href='../../x/examples/xfenster2.php'>demo 2</a>, <a href='../../x/examples/xfenster3.php'>demo 3</a> and <a href='../../x/examples/xfenster4.php'>demo 4</a>. The new <a href='../../x/examples/property_viewer.php'>Property Viewer</a> also uses xFenster. Here is an <a href='../../x/examples/xfenster_r16a.php'>experimental feature</a> which was not implemented in revision 16.</p>
</div>

<h3>Off-topic but Interesting</h3>
<div>
  <h4>Kappeler Institute</h4>
  <p>"Dr. Max Kappeler's works represent a spiritually scientific approach, rather than a "religious" approach, to the Bible and Christian Science textbook, Science and Health with Key to the Scriptures, by Mary Baker Eddy. This subject has been termed "the Science of Christian Science" (sometimes referred to as "Science," "the Science of Being," or "the Science of all sciences.")."</p>
  <p><a href='http://www.kappelerinstitute.org/'>Source</a></p>
  <h4>Mappa.Mundi Magazine</h4>
  <p>"Mappa.Mundi examines information discovery on the Internet via an eclectic mix of ideas about technology, history, and the future of cyberspace."</p>
  <p><a href='http://mappa.mundi.net/'>Source</a></p>
</div>

<div id="xf2" class='xFenster'>
  <div class='fenster-content'>
    <h4>Declaration of Independence</h4>
    <p>In CONGRESS, July 4, 1776,</p>
    <p>The unanimous Declaration of the thirteen united STATES of AMERICA,</p>
    <p>When in the Course of human events, it becomes necessary for one people to dissolve the political bands which have connected them with another, and to assume among the powers of the earth, the separate and equal station to which the Laws of Nature and of Nature's God entitle them, a decent respect to the opinions of mankind requires that they should declare the causes which impel them to the separation.</p>
    <p>We hold these truths to be self-evident, that all men are created equal, that they are endowed by their Creator with certain unalienable Rights, that among these are Life, Liberty, and the pursuit of Happiness. That to secure these rights, Governments are instituted among Men, deriving their just powers from the consent of the governed. That whenever any Form of Government becomes destructive of these ends, it is the Right of the People to alter or to abolish it, and to institute new Government, laying its foundation on such principles and organizing its powers in such form, as to them shall seem most likely to effect their Safety and Happiness. Prudence, indeed, will dictate that Governments long established should not be changed for light and transient causes; and accordingly all experience hath shewn, that mankind are more disposed to suffer, while evils are sufferable, than to right themselves by abolishing the forms to which they are accustomed. But when a long train of abuses and usurpations, pursuing invariably the same object evinces a design to reduce them under absolute Despotism, it is their right, it is their duty, to throw off such Government, and to provide new Guards for their future security. ...</p>
    <p>(<a href='http://www.duke.edu/eng169s2/group1/lex3/hyprdecl.htm'>source</a>)</p>
  </div>
</div><!-- end xFenster -->

<div id="xf3" class='xFenster'>
  <div class='fenster-content'>
    <p>"Yet, alas, of what great goods do miserable mortals despoil one another, by their shameful itching for quarrels. How profound an ignorance of their fate overwhelms them, as they have deserved. With what deplorable perverseness do we rush into the midst of the flames, in fleeing from the fire," he [Kepler] wrote in 1621, three years after the eruption of the Thirty Years War.</p>
    <p>"Would that even now indeed, there may still, after the reversal of Austrian affairs which followed, be a place for Plato's oracular saying. For when Greece was on fire on all sides with a long civil war, and was troubled with all the evils which usually accompany civil war, he was consulted about a Delian Riddle, and was seeking a pretext for suggesting salutary advice to the peoples. At length he replied that, according to Apollo's opinion Greece would be peaceful if the Greeks turned to geometry and other philosophical studies, as these studies would lead their spirits from ambition and other forms of greed, out of which wars and other evils arise, to the love of peace and to moderation in all things."</p>
    <p>(<a href='http://wlym.com/antidummies/part02.html'>source</a>)</p>
  </div>
</div><!-- end xFenster -->

</div> <!-- end leftContent -->


<div id='sponsor3' style='width:468px; margin:20px auto 20px auto;'>
<script type="text/javascript">
google_ad_client = "pub-6162857333153838";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text";
google_ad_channel = "";
// palette 1
google_color_link   = 'BF8660';
google_color_text   = '6078BF';
google_color_url    = '6078BF';
google_color_bg     = 'FFFFFF';
google_color_border = 'FFFFFF';
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div> <!-- end sponsor3 -->

<div id='footer' class='leftContent'>
Copyright &copy; 2001-2008 Michael Foster<br>
Javascript distributed under the terms of the <a href='../../license.html'>GNU LGPL</a>
</div> <!-- end footer -->

</div> <!-- end leftColumn -->

<div id='rightColumn' class='column'>
<div class='rightContent'>


<h3>Sponsors</h3>
<div id='sponsor2'>
<script type="text/javascript">
google_ad_client  = "pub-6162857333153838";
google_ad_width   = 160;
google_ad_height  = 600;
google_ad_type = "text";
google_ad_format  = "160x600_as";
google_ad_channel = "";
// palette 0
google_color_link   = '6078BF';
google_color_text   = '806959';
google_color_url    = '6078BF';
google_color_bg     = 'CFD4E6';
google_color_border = 'CFD4E6';
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>
<h3>Tech Support</h3>
<div class='collapsible'>
<p>For email support please <a href='http://cross-browser.com/contact.php?s=RFQ'>request a quote</a>.</p>
<p>Forum support is available at the <a href='http://cross-browser.com/forums/'>xLibrary Support Forums</a>.</p>
</div>

</div> <!-- end rightContent -->
</div> <!-- end rightColumn -->

</body>
</html>
