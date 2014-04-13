<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>ACCUEIL</title>
    <script type="text/javascript"
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLRnFhu7ruRX9BO-ql9JhTseSgDCC2IDM&sensor=true">
    </script>
    <script type="text/javascript">
        try {
            function downloadUrl(url, callback) {
                var request = window.ActiveXObject ?
                    new ActiveXObject('Microsoft.XMLHTTP') :
                    new XMLHttpRequest;

                request.onreadystatechange = function () {
                    if (request.readyState == 4) {
						request.onreadystatechange = doNothing;
                        callback(request, request.status);
                    }
                };

                request.open('GET', url, true);
                request.send(null);
            }

            function StringtoXML(text) {
                if (window.ActiveXObject) {
                    var doc = new ActiveXObject('Microsoft.XMLDOM');
                    doc.async = 'false';
                    doc.loadXML(text);
                } else {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(text, 'text/xml');
                }
                return doc;
            }

            var iss;
            var listMarker = new Array();
            function initialize() {
                var mapOptions = {
                    center: new google.maps.LatLng(0, 0),
                    zoom: 3,
                    minZoom: 2,
					maxZoom: 12,
                    streetViewControl: false,
                    disableDoubleClickZoom: true,
                    disableDefaultUI: false,
                    navigationControl: true,
                    keyboardShortcuts: false,
                    panControlOptions: {
                        position: google.maps.ControlPosition.LEFT_CENTER
                    },
                    zoomControlOptions: {
                        position: google.maps.ControlPosition.LEFT_CENTER
                    }
                };


                var map = new google.maps.Map(document.getElementById("map-canvas"),
                    mapOptions);
                var infowindow = new google.maps.InfoWindow({
                    content: ""
                });

				// Get XML from PHP
                var xmlString = '<?php echo  $xml_result; ?>';
                var xml = StringtoXML(xmlString);
                var markers = xml.documentElement.getElementsByTagName("marker");

                for (var i = 0; i < markers.length; i++) {
                    var name = markers[i].getAttribute("name");
                    var point = new google.maps.LatLng(
                        markers[i].getAttribute("lat"),
                         markers[i].getAttribute("lng"));
                    var name_img = name.split('.');
                    var name_img_min = name_img[0] + "_min." + name_img[1];
                    var html = '<img src="http://ew9.spaceappsbdx.org/files/iserv/' + name_img_min + '" height="100" width="100">';

                    // Best photo Icon
                    if ('<?php echo  $IDBestImage; ?>' == markers[i].getAttribute("id")) {
                        var icon = 'media/img/winner.png';
                    }
                    else {
                        var icon = 'media/img/pastille.png';
                    }

                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: icon,
                        html: html,
                        title: markers[i].getAttribute("id")

                    });
                    listMarker.push(marker);
                }


                // add event Markers
                for (var i = 0; i < listMarker.length; i++) {
                    var marker = listMarker[i];
                    google.maps.event.addListener(marker, 'mouseover', function () {
                        // where I have added .html to the marker object.
                        infowindow.setContent(this.html);
                        infowindow.open(map, this);
                    });

                    google.maps.event.addListener(marker, 'click', function () {
                        window.location = "index.php?page=detail&id=" + this.title;
                    });
                }

                // get ISS statiion                
                $.getJSON('http://open-notify-api.herokuapp.com/iss-now.json?callback=?', function (data) {

                    var name = "ISS"
                    var point = new google.maps.LatLng(
                        data["iss_position"]["latitude"],
                         data["iss_position"]["longitude"]);

                    iss = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: 'media/img/stationiss.png'
                    });

                });


            }

            google.maps.event.addDomListener(window, 'load', initialize);

            function changeMarkerPosition() {
                $.getJSON('http://open-notify-api.herokuapp.com/iss-now.json?callback=?', function (data) {
                    var latlng = new google.maps.LatLng(data["iss_position"]["latitude"], data["iss_position"]["longitude"]);
                    iss.setPosition(latlng);
                    if (iss == null) {
                        var name = "ISS"
                        var point = new google.maps.LatLng(
                            data["iss_position"]["latitude"],
                             data["iss_position"]["longitude"]);

                        iss = new google.maps.Marker({
                            map: map,
                            position: point,
                            icon: 'media/img/stationiss.png'
                        });
                    }
                });
                setTimeout(changeMarkerPosition, 2000);
            }
            changeMarkerPosition(iss);
        }
        catch (ex) {
            console.debug(ex);
        }

    </script>
</head>
<body>

    <div id="map-canvas" style="height: 100%;"></div>
</body>
</html>
