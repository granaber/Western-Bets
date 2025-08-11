<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example: Control Positioning</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAABBzfSuuIw8zjsnP_KfCh1RR1Ge3duXVftkuqcKvS6AxGD4SIZxT5HKDUupcRSbbaOH_Poh5BN5vzuw"
            type="text/javascript"></script>
    <script type="text/javascript">

    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(37.4419, -122.1419), 13);
        var mapTypeControl = new GMapTypeControl();
        var topRight = new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(10,10));
        var bottomRight = new GControlPosition(G_ANCHOR_BOTTOM_RIGHT, new GSize(10,10));
        map.addControl(mapTypeControl, topRight);
        GEvent.addListener(map, "dblclick", function() {
          map.removeControl(mapTypeControl);
          map.addControl(new GMapTypeControl(), bottomRight);
        });
        map.addControl(new GSmallMapControl());
      }
    }

    </script>
  </head>

  <body onload="initialize()" onunload="GUnload()">
  <div id="map_canvas" style="width: 700px; height: 400px"></div>
  </body>
</html>

