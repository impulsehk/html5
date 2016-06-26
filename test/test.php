<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="src/style/pluginStyle.css">
     <script src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry"></script>
    <script src="src/google-map-bsi.min.js"></script>
    <script  type="text/javascript">
        $(document).ready(function () {

        $(".firstExample").ShopLocator({
            infoBubble:{
                visible: true,
                backgroundColor: 'transparent',
                arrowSize: 0,
                arrowPosition: 50,
                minHeight: 127,
                maxHeight: null,
                minWidth: 170,
                maxWidth: 250,
                hideCloseButton: false
            },
			map:{
				zoom: 10,
				maxZoom: "16",
                minZoom: "2"
			},
			markersIcon: "../images/map/marker_h.png",
            marker:{
                latlng: [52.2296760, 21.0122290],
                title: "CreateIT",
                street: "ul. Narbutta 22/15",
                zip: "+48 22 378 3 379",
                city: "Warszawa"
            }
        });

       
    });
    </script>

</head>

<body>
 <div class="firstExample"></div> 

</body>
</html>
