(function ($) {
    "use strict";

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



}(jQuery));
