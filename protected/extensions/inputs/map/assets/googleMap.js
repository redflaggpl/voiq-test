//Funciones Mapa

/*-------------------------INICIALIZACIÓN DEL MAPA---------------------------*/
var map;
var polygons = [];
var markers = [];

function initialize() {


    var mapOptions = {
        zoom: 8,
        center: new google.maps.LatLng(4.659634, -74.062035),
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'usroadatlas']
        },
        panControl: false,
        zoomControl: false
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    /*ESTILOS DEL MAPA*/
    var mapPeepStyle = [{
            stylers: [{
                    lightness: 1
                }, {
                    saturation: -48
                }, {
                    hue: "#005eff"
                }]
        }];

    var styledMapOptions = {
        name: 'Peep Map'
    };

    var colMapStyle = new google.maps.StyledMapType(mapPeepStyle, styledMapOptions);

    map.mapTypes.set('usroadatlas', colMapStyle);
    map.setMapTypeId('usroadatlas');

    /*MARKERS*/
    var markersCollection = [{
            lat: 4.663056,
            lng: -74.066713
        }, {
            lat: 4.659634,
            lng: -74.062035
        }, {
            lat: 4.665537,
            lng: -74.060876
        }, {
            lat: 4.668702,
            lng: -74.06328
        }, {
            lat: 4.667803819695674,
            lng: -74.05130639141845
        }, {
            lat: 4.665280079753264,
            lng: -74.0469287988281
        }, {
            lat: 4.668830524353261,
            lng: -74.04538356072999
        }, {
            lat: 4.670883417109691,
            lng: -74.04937542846687
        }, {
            lat: 4.651507115488849,
            lng: -74.07555356091308
        }, {
            lat: 4.651036473292493,
            lng: -74.0725921746826
        }, {
            lat: 4.655314144235659,
            lng: -74.07186232812501
        }, {
            lat: 4.6565116031496885,
            lng: -74.07409466674818
        }, {
            lat: 4.654009363767306,
            lng: -74.07469536779797
        }];

    /*POLIGONOS*/
    var polygonsCollection = [
        [{
                lat: 4.663056,
                lng: -74.066713
            }, {
                lat: 4.659634,
                lng: -74.062035
            }, {
                lat: 4.665537,
                lng: -74.060876
            }, {
                lat: 4.668702,
                lng: -74.06328
            }],
        [{
                lat: 4.667803819695674,
                lng: -74.05130639141845
            }, {
                lat: 4.665280079753264,
                lng: -74.0469287988281
            }, {
                lat: 4.668830524353261,
                lng: -74.04538356072999
            }, {
                lat: 4.670883417109691,
                lng: -74.04937542846687
            }],
        [{
                lat: 4.651507115488849,
                lng: -74.07555356091308
            }, {
                lat: 4.651036473292493,
                lng: -74.0725921746826
            }, {
                lat: 4.655314144235659,
                lng: -74.07186232812501
            }, {
                lat: 4.6565116031496885,
                lng: -74.07409466674818
            }, {
                lat: 4.654009363767306,
                lng: -74.07469536779797
            }]
    ];

    createMarkers(markersCollection, map);
    createPolygons(polygonsCollection, map);
}

// Sets the map on all polygons in the array.
function setAllPolygonsMap(map) {
    for (var i = 0; i < polygons.length; i++) {
        polygons[i].setMap(map);
    }
}

// Removes the polygons from the map, but keeps them in the array.
function clearPolygons() {
    setAllPolygonsMap(null);
}

// Shows any polygons currently in the array.
function showPolygons() {
    setAllPolygonsMap(map);
}

// Deletes all polygons in the array by removing references to them.
function deletePolygons() {
    clearPolygons();
    polygons = [];
}

/*FUNCIONES CON MARKERS*/
function createMarkers(markersCollection, parentMap) {
    if (markersCollection.length > 0) {

        for (var i = 0; i < markersCollection.length; i++) {

            var markerCoords = new google.maps.LatLng(markersCollection[i].lat, markersCollection[i].lng);

            var myMarker = new google.maps.Marker({
                position: markerCoords,
                draggable: false,
                title: 'Arrastrame',
                icon: 'img/etiqueta.png',
                map: map
            });

            myMarker.setMap(parentMap);

            google.maps.event.addListener(myMarker, 'click', function(marker) {
                console.log(marker);
            });

            markers.push(myMarker);
        }
    }
}

// Add a marker to the map and push to the array.
function addMarker(location) {
    var marker = new google.maps.Marker({
        position: location,
        draggable: true,
        title: 'Arrastrame',
        icon: 'img/etiqueta.png',
        map: map
    });

    markers.push(marker);
}

// Sets the map on all markers in the array.
function setAllMarkersMap(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setAllMarkersMap(null);
}

// Shows any markers currently in the array.
function showMarkers() {
    setAllMarkersMap(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    clearMarkers();
    markers = [];
}


// CREAR EVENTO EN EL MAPA ---------------------------------------------
function crearevento(id_field) {
//Variables
    var lat = null;
    var lng = null;
    var map = null;
    var geocoder = null;
    var marker = null;
    var myLatlng = new google.maps.LatLng(lat, lng);
    var markersArray = [];
    var styles = [
        {
            featureType: "all",
            elementType: "geometry",
            stylers: [
                //{ lightness: 70 },
                {hue: "#005eff"},
                {saturation: -48},
                {lightness: 1},
                {gamma: 1.5}

            ]
        },
        {
            featureType: "water",
            elementType: "geometry",
            stylers: [
                //{ lightness: 70 },
                {hue: "#005eff"}
            ]
        }
    ];
    var styledMap2 = new google.maps.StyledMapType(styles, {name: "Styled Map2"});


    $(document).ready(function() {
        //obtenemos los valores en caso de tenerlos en un formulario ya guardado en la base de datos
        lat = jQuery('#'+id_field+'_lat').val();
        lng = jQuery('#'+id_field+'_long').val();
    
        //Asignamos al evento click del boton la funcion codeAddress
        jQuery(document).on('click','#'+id_field+'_search',function(e) {
            e.preventDefault();
            codeAddress(id_field);
        });
        jQuery(document).on('keyup','#'+id_field+'_address',function(e) {
            e.preventDefault();
            if(e.keyCode!==13 && $(e.currentTarget).val()!='')
                $('#'+id_field).val($('#'+id_field+'_address').val());
            if(e.keyCode===13 && $(e.currentTarget).val()!='') {
                codeAddress(id_field);
                $('#'+id_field+'_search').modal('hide');
            }
        });
        //Inicializamos la función de google maps una vez el DOM este cargado
        initialize(id_field);
    });

    function initialize(id_field) {
        var url_img = $('#'+id_field+'_map').attr('data-img') || undefined;

        geocoder = new google.maps.Geocoder();
        codeAddress(id_field);

        //Si hay valores creamos un objeto Latlng
        if (lat != '' && lng != '') {
            var latLng = new google.maps.LatLng(lat, lng);
        } else {
            var latLng = new google.maps.LatLng(4.659634, -74.062035);
        }
        //Definimos algunas opciones del mapa a crear
        var myOptions = {
            center: latLng, //centro del mapa
            zoom: 8, //zoom del mapa
            mapTypeId: google.maps.MapTypeId.ROADMAP //tipo de mapa, carretera, híbrido,etc
        };

        //creamos el mapa con las opciones anteriores y le pasamos el elemento div
        map = new google.maps.Map(document.getElementById(id_field+'_map'), myOptions);
        map.mapTypes.set(id_field+'_map', styledMap2);
        map.setMapTypeId(id_field+'_map');

        /*creamos el marcador en el mapa
         marker = new google.maps.Marker({
         map: map,//el mapa creado en el paso anterior
         position: latLng,//objeto con latitud y longitud
         draggable: true //que el marcador se pueda arrastrar
         });*/

        //INICIO Contenido para clic y hallar cordenadas------------------------//
        placeMarker(myLatlng);
        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
        });

        $(document).on('click','#'+id_field+'_draw',function(e){
            e.preventDefault();
            if($('#'+id_field+'_address').val()!='') {
                marker.setPosition(null);
                $('#'+id_field+'_lat').val('');
                $('#'+id_field+'_long').val('');

                var drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.POLYGON,
                    drawingControl: false,
                    // drawingControlOptions: {
                    //   position: google.maps.ControlPosition.TOP_CENTER,
                    //   drawingModes: [
                    //     google.maps.drawing.OverlayType.POLYGON,
                    //   ]
                    // },
                });
                drawingManager.setMap(map);

                google.maps.event.addListener(drawingManager, 'drawingmode_changed', function(e){
                    console.log('DrawingChange');
                });
                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
                    // Add an event listener that selects the newly-drawn shape when the user
                    // mouses down on it.
                    var newShape = e.overlay;
                    newShape.type = e.type;
                    var 
                    path  = newShape.getPath(),
                    coords  = new Array(),
                    payload = { type: "MultiPolygon", coordinates: new Array()};

                    payload.coordinates.push(new Array());
                    payload.coordinates[0].push(new Array());

                    for (var i = 0; i < path.length; i++) {
                      coord = path.getAt(i);
                      coords.push( coord.lng() + " " + coord.lat() );
                      payload.coordinates[0][0].push([coord.lng(),coord.lat()])
                    }

                    console.log('complete',coords);
                    $('#'+id_field+'_path').val(JSON.stringify(coords));


                    var geocoder;
                    geocoder = new google.maps.Geocoder();
                    var closePolygone = coords[0].split(' ');
                    console.log('[JS]',closePolygone);
                    var latlng = new google.maps.LatLng(closePolygone[1], closePolygone[0]);

                    geocoder.geocode({'latLng': latlng}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            // console.log(results,'----');
                            if (results[1]) {
                                $('#'+id_field).attr("value", results[0].formatted_address);
                                $('#'+id_field+'_address').attr("value", results[0].formatted_address);
                                // console.log(results[1].formatted_address);
                            }
                        } else {
                            bootbox.alert("El Geocodificador falló debido a : " + status, function() {
                                console.log("El Geocodificador falló debido a : " + status);
                            });
                        }
                    });

                    // google.maps.event.addListener(newShape, 'click', function() {
                    //     setSelection(this);
                    // });

                    // setSelection(newShape);
                    // storePolygon(newShape.getPath());
                    // newShape.setEditable(false);
                    drawingManager.setMap(null);
                });
            } else {
                bootbox.alert("Escribe una dirección aproximada o central a la zona afectación que vas a dibujar y selecciona nuevamente la opción 'Dibujar cuadrante'.", function() {
                    console.log("El Geocodificador falló debido a : ");
                    $('#'+id_field+'_address').focus();
                });
            }
        });

        // Función de obtención de latitud
        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
                google.maps.event.addListener(marker, 'dragend', function() {
                    updatePosition(marker.getPosition());
                });
                google.maps.event.addListener(marker, 'click', function() {
                    console.log(marker.getPosition());
                });
            } else {
                marker = new google.maps.Marker({
                    position: latLng,
                    draggable: true,
                    title: 'Arrastrame',
                    icon: url_img,
                    map: map
                });
                google.maps.event.addListener(marker, 'dragend', function() {
                    updatePosition(marker.getPosition());
                });
                google.maps.event.addListener(marker, 'click', function() {
                    console.log(marker.getPosition());
                });
                markersArray.push(marker);
            }
        }
        // Elimina las superposiciones del mapa, pero los mantiene en la matriz
        function clearOverlays() {
            if (markersArray) {
                for (var i = 0, length = markersArray.length; i < length; i++) {
                    markersArray[i].setMap(null);
                }
            }
        }
        //Capturar direcciones
        function updatelonlat() {
            $('#'+id_field+'_lat').val(marker.getPosition().lat());
            $('#'+id_field+'_long').val(marker.getPosition().lng());

            var geocoder;
            geocoder = new google.maps.Geocoder();

            var lat = parseFloat(document.getElementById(id_field+'_lat').value);
            var lng = parseFloat(document.getElementById(id_field+'_long').value);

            var latlng = new google.maps.LatLng(lat, lng);

            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        $('#'+id_field).attr("value", results[0].formatted_address);
                        $('#'+id_field+'_address').attr("value", results[0].formatted_address);
                        console.log(results);
                        // console.log(results[1].formatted_address);
                    }
                } else {
                    bootbox.alert("El Geocodificador falló debido a : " + status, function() {
                        console.log("El Geocodificador falló debido a : " + status);
                    });
                }
            });
        }
        // evento click
        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
            updatelonlat();
        });

        // evento change
        // google.maps.event.addListener(map, 'change', function(event) {
        //     console.log(event.latLng);
        //     placeMarker(event.latLng);
        //     updatelonlat();
        // });
        //FIN Contenido para clic y hallar cordenadas------------------------//

        //función que actualiza los input del formulario con las nuevas latitudes
        //Estos campos suelen ser hidden
        updatePosition(latLng);
    }

    //funcion que traduce la direccion en coordenadas
    function codeAddress(id_field) {

        //obtengo la direccion del formulario
        $('#'+id_field+'_dtext').html($('#Notifications_department_id option:selected').text());
        $('#'+id_field+'_ttext').html($('#Notifications_town_id option:selected').text());
        var address = document.getElementById(id_field+'_address').value;
        //hago la llamada al geodecoder
        if($('#Notifications_department_id').val()!='' && $('#Notifications_town_id').val()!='') {
            address=address+' '+$('#Notifications_town_id option:selected').text()+', '+$('#Notifications_department_id option:selected').text()+', Colombia';
        }
        console.log(Date(),address);
        geocoder.geocode({'address': address}, function(results, status) {

            //si el estado de la llamado es OK
            if (status == google.maps.GeocoderStatus.OK) {
                //centro el mapa en las coordenadas obtenidas
                map.setCenter(results[0].geometry.location);
                map.setZoom(15);
                //coloco el marcador en dichas coordenadas
                marker.setPosition(results[0].geometry.location);
                //actualizo el formulario
                updatePosition(results[0].geometry.location);

                //Añado un listener para cuando el markador se termine de arrastrar
                //actualize el formulario con las nuevas coordenadas
                google.maps.event.addListener(marker, 'dragend', function() {
                    updatePosition(marker.getPosition());
                });
            } else {
                //si no es OK devuelvo error
                bootbox.alert("No podemos encontrar la dirección, error: " + status + " verifique los datos ingresados!", function() {
                    console.log("No podemos encontrar la dirección, error: " + status + " verifique los datos ingresados!");
                });
            }
        });
    }

//funcion que simplemente actualiza los campos del formulario
    function updatePosition(latLng) {
        $('#'+id_field+'_lat').val(latLng.lat());
        $('#'+id_field+'_long').val(latLng.lng());
    }
}


/*-----------------------FUNCIONES POLIGONOS-----------------------------------*/
function detalleevento() {
    $('#modal-detalle').addClass("shown");
    $('.over-modal').removeClass("ng-hide");
}

function cerrardetalleevento() {
    $('#modal-detalle').removeClass("shown");
    $('.over-modal').addClass("ng-hide");
}

function capturardireccion() {
    $('#reporte-mapa').addClass("shown");
    $('.over-modal').removeClass("ng-hide");
}

function cerrarcapturardireccion() {
    $('#reporte-mapa').removeClass("shown");
    $('.over-modal').addClass("ng-hide");
}
/*-----------------------FUNCIONES POLIGONOS-----------------------------------*/






/*-----------------------REPORTAR EVENTO EN EL MAPA-----------------------------------*/
//Actios Eventos
$(function() {
    $(document).on('click','#ubicar_direccion_map',function(e) {
    	e.preventDefault();
        //Acciones en maqueta
        $('header').animate({
            'top': '-120px'
        });
        $('.form-evento').animate({
            'top': '0px'
        });
        $('.button-reportar-event').animate({
            'opacity': '0'
        });
        $('#reporte-mapa').removeClass("shown");
        $('.over-modal').addClass("ng-hide");
    });
});

//Actios Direcciones
$(function() {
    $('.crear_direccion').click(function() {
        //Acciones en maqueta
        $('header').animate({
            'top': '-120px'
        });
        $('.form-direcciones').animate({
            'top': '0px'
        });
        $('.new_dir').css({
            'display': 'block'
        });
        $('.editar_dir').css({
            'display': 'none'
        });
        $('.editar_dir_serv').css({
            'displayedlay': 'none'
        });
        $('.button-reportar-event').animate({
            'opacity': '0'
        });
        $('#reporte-mapa').removeClass("shown");
        $('.over-modal').addClass("ng-hide");
        $('.textCambiaEdit').css({
            'display': 'none'
        });
        $('.textCambiarRegis').css({
            'display': 'block'
        });
    });
});
$(function() {
    $('.editar_direccion').click(function() {
        //Acciones en maqueta
        $('header').animate({
            'top': '-120px'
        });
        $('.form-direcciones').animate({
            'top': '0px'
        });
        $('.new_dir').css({
            'display': 'none'
        });
        $('.editar_dir').css({
            'display': 'block'
        });
        $('.editar_dir_serv').css({
            'display': 'none'
        });
        $('.button-reportar-event').animate({
            'opacity': '0'
        });
        $('#reporte-mapa').removeClass("shown");
        $('.over-modal').addClass("ng-hide");
        $('.textCambiaEdit').css({
            'display': 'block'
        });
        $('.textCambiarRegis').css({
            'display': 'none'
        });
    });
});
$(function() {
    $('.editar_direccion_servicio').click(function() {
        //Acciones en maqueta
        $('header').animate({
            'top': '-120px'
        });
        $('.form-direcciones').animate({
            'top': '0px'
        });
        $('.new_dir').css({
            'display': 'none'
        });
        $('.editar_dir').css({
            'display': 'none'
        });
        $('.editar_dir_serv').css({
            'display': 'block'
        });
        $('.button-reportar-event').animate({
            'opacity': '0'
        });
        $('#crear-servicios').removeClass("shown");
        $('.over-modal').addClass("ng-hide");
        $('.textCambiaEdit').css({
            'display': 'block'
        });
        $('.textCambiarRegis').css({
            'display': 'none'
        });
    });
});

//Cerrar MAPA
function cerrarbuscador() {
    //Acciones en maqueta
    $('header').animate({
        'top': '0px'
    });
    $('.form-busqueda').animate({
        'top': '-400px'
    });
    $('.button-reportar-event').animate({
        'opacity': '1'
    });
    $('#reporte-mapa').addClass("shown");
    $('.over-modal').removeClass("ng-hide");
}

function cerrarresultadosbusqueda() {
    $('#reporte-mapa').removeClass("shown");
    $('.over-modal').addClass("ng-hide");
}

function cerrarbuscador_direccion() {
    $('header').animate({
        'top': '0px'
    });
    $('.form-direcciones').animate({
        'top': '-400px'
    });
    $('.button-reportar-event').animate({
        'opacity': '1'
    });
    $('#mensaje_direccion').addClass("shown");
}

function cerrarresultado_direccion() {
    $('#mensaje_direccion').removeClass("shown");
}

function cerrarbuscador_editardireccion() {
    $('header').animate({
        'top': '0px'
    });
    $('.form-direcciones').animate({
        'top': '-400px'
    });
    $('.button-reportar-event').animate({
        'opacity': '1'
    });
    $('#mensaje_direccion_editado').addClass("shown");
}

function cerrarresultado_editardireccion() {
    $('#mensaje_direccion_editado').removeClass("shown");
    $('.over-modal').removeClass("ng-hide");
}

function cerrarbuscador_editardireccionserv() {
    $('header').animate({
        'top': '0px'
    });
    $('.form-direcciones').animate({
        'top': '-400px'
    });
    $('.button-reportar-event').animate({
        'opacity': '1'
    });
    $('#mensaje_direccion_editado_servicios').addClass("shown");
}

function cerrarresultado_editardireccionserv() {
    $('#mensaje_direccion_editado_servicios').removeClass("shown");
    $('#crear-servicios').addClass("shown");
    $('.over-modal').removeClass("ng-hide");
}
/*-----------------------REPORTAR EVENTO EN EL MAPA-----------------------------------*/