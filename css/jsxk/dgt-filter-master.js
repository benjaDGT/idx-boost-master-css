var IB_IS_REGULAR_FILTER_PAGE = true;
var countClickAnonymous = 0;
var textprueba = '',
    inifil_default = 4;
var idxboost_filter_countacti = false,
    idxboostcondition = '';
    filter_metadata =JSON.parse(filter_metadata);
(function($) {
    var ajax_request_filter;
    var idxboost_filter_forms;

    $(function() {
        idxboost_filter_forms = $(".idxboost-filter-form");

        // console.log(idxboost_filter_forms.length);

        if (idxboost_filter_forms.length) {
            idxboost_filter_forms.each(function() {
                var form = $(this);
                var inputs = form.find("input");

                if (inputs.length) {
                    inputs.on("change", function() {
                        var filter_form = $(this).parent();
                        var filter_form_data = filter_form.serialize();

                        console.log("change value form filter form #" + $(this).parent().data("filter-form-id"));
                        console.log(filter_form_data);
                    });
                }
            });
        }
    });
})(jQuery);

if (__flex_g_settings.force_registration != undefined && __flex_g_settings.force_registration == true ){
    idxboost_force_registration=true;
}
var ib_event_mobile=true;
var myLazyLoad;
var arraytest;
var arrayother;
var search_params = flex_idx_filter_params.params;
var baths_slider_values = _.pluck(search_params.baths_range, 'value');
var beds_slider_values = _.pluck(search_params.beds_range, 'value');
var sqft_slider_values = _.pluck(search_params.living_size_range, 'value');
var lotsize_slider_values = _.pluck(search_params.lot_size_range, 'value');
var price_rent_slider_values = _.pluck(search_params.price_rent_range, 'value');
var price_sale_slider_values = _.pluck(search_params.price_sale_range, 'value');
var year_built_slider_values = _.pluck(search_params.year_built_range, 'value');
var property_type_values = _.pluck(search_params.property_types, 'value');
var flex_ui_loaded = false;
var baths_slider;
var beds_slider;
var sqft_slider;
var lotsize_slider;
var price_sale_slider;
var price_rent_slider;
var year_built_slider;
var flex_filter_sort;
var flex_pagination;
var flex_search_rental_switch;
var flex_waterfront_switch;
var flex_parking_switch;
var flex_autocomplete;
var flex_autocomplete_inner;
var $cuerpo = jQuery("body");
var $ventana = jQuery(window);
var arraytest_pryueba = '';
var currentfiltemid = '';
var xDown = null;
var yDown = null;

var IB_SEARCH_FILTER_FORM = $("#flex-idx-filter-form");
var ib_min_price;
var ib_max_price;
var ib_min_rent_price;
var ib_max_rent_price;
var ib_min_beds;
var ib_max_beds;
var ib_min_baths;
var ib_max_baths;
var ib_m_types;
var ib_m_parking;
var ib_min_living;
var ib_max_living;
var ib_min_land;
var ib_max_land;
var ib_min_year;
var ib_max_year;
var ib_waterfront_switch;
var ib_m_features;
var $ibAdvanced = $('.ib-oadbanced');

var IB_RG_PRICE_SALE =  $("#range-price");
var IB_RG_YEARBUILT = $('#range-year');
var IB_RG_BEDROOMS = $("#range-beds");
var IB_RG_BATHROOMS = $("#range-baths");
var IB_RG_LIVINGSIZE = $("#range-living");
var IB_RG_LANDSIZE =  $("#range-land");
var IB_RG_PARKING=$('#flex_parking_switch');
var IB_RG_WATERFRONT=$('#flex_waterfront_switch');
var IB_RG_AMENITIES=$('.amenities_checkbox');
var IB_RG_PROPERTY_TYPE=$('.property_type_checkbox');

(function($) {
    $(function() {
      // handle save search on filter pages
      $("#filter-save-search").on("click", function() {
        var current_count = $(this).data("count");

        if (__flex_g_settings.anonymous === "yes") {
            active_modal($('#modal_login'));
        } else if (__flex_g_settings.anonymous === "no" && (current_count > 500)) {
            sweetAlert(word_translate.oops, word_translate.you_cannot_save_search_with_more_than_500_properties, "error");
            return;
        } else {
          // ajax saved search
          // var search_url = $("#flex-idx-search-form").data("save_slug");
          // var search_count = $("#flex-idx-search-form").data("save_count");
          //var name = prompt('Please enter a title to identify your custom search.', '');
          active_modal($('#modal_save_search'));
          setTimeout(function() {
              $('#modal_properties_send').find('.close').click();
          }, 2000);
        }
      });

        // fix touch slider
        $('body').on('touchstart', '.slider-generator .propertie', function(evt) {
            evt.stopPropagation();
            xDown = evt.originalEvent.touches[0].clientX;
            yDown = evt.originalEvent.touches[0].clientY;
        });
        $('body').on('touchmove', '.slider-generator .propertie', function(evt) {
            if (!xDown || !yDown) {
                return;
            }
            var xUp = evt.originalEvent.touches[0].clientX;
            var yUp = evt.originalEvent.touches[0].clientY;
            var xDiff = xDown - xUp;
            var yDiff = yDown - yUp;
            if (Math.abs(xDiff) > Math.abs(yDiff)) { // si se mueve derecha o izquierda
                evt.preventDefault();
                if (xDiff > 0) { // izquierda
                    $(this).find('.next').click();
                } else { // derecha
                    $(this).find('.prev').click();
                }
            }
            xDown = null;
            yDown = null;
        });
        $('#result-search').scroll(function() {
            new LazyLoad({
              callback_error: function(element){
                $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
              }
            });
        });

        // Expande y contrae los mini filtros de 'all filters' en versiÃ³n mobile de la web
        var $miniFilters = $('#mini-filters');
        if ($miniFilters.length) {
            // Expando y contrigo el filtro
            $miniFilters.find('h4').on('click', function() {
                var $theLi = $(this).parents('li');
                $theLi.toggleClass('expanded').siblings().removeClass('expanded');
                // ver si creo el slider de 'cities', si es que se clickeo el LI con clase CITIES
                /*if ($theLi.hasClass('cities') && !$citiesList.hasClass('ps-container')) {
                    setTimeout(function() {
                        $citiesList.perfectScrollbar({
                            suppressScrollX: true,
                            minScrollbarLength: '42'
                        });
                    }, ((Number($theLi.css('transition-duration').replace('s', '')) * 1000) * 2));
                    creaScrollTemporal($theLi, $citiesList);
                }*/
            });
        }
        // Abre y cierra el 'All Filters'
        var $theFilters = $('#filters');
        if ($theFilters.length) {
            var $allFilters = $('#all-filters');
            var $wrapFilters = $('#wrap-filters');
            $theFilters.on('click', 'button', function() {
                var $bedsActive = $('#mini-filters .price').addClass('expanded');
                var $liClicked = $(this).parent();
                var $nameClass = $liClicked.attr('class').split(' ')[0];
                // [A] verifico si existe un LI de mini filter vinculado al LI de la cabezera de filtros que se acaba de crear.
                var $miniFilter = $miniFilters.find('li.' + $nameClass);
                if (!$miniFilter.length) {
                    //El LI clickeado no estÃ¡ vinculado a la visualizacion de un mini filtro, verifiquemos si se hizo click en "All Filter".
                    if ($nameClass !== 'all') {
                        //console.log('no se hizo click en "All filters"');
                        return;
                    } else {
                        $liClicked.toggleClass('active').siblings().removeClass('active'); // se hizo click en 'All Filter', activo su flecha
                    }
                } else {
                    //console.log('si hay vinculaciÃ³n');
                    $liClicked.toggleClass('active').siblings().removeClass('active'); // activo su flecha, xq si hay vinculaciÃ³n y continuo.. apareciendo el mini filter.
                    //return;
                }
                // [/A]
                switch ($nameClass) {
                    case 'all': // Mostrar el 'All Filter'
                        // [B] Apareciendo y/o mutando
                        if (!$allFilters.hasClass('visible')) { // lo pongo asi, x siacaso yÃ¡ estÃ© visible individualmente y no se oculte, sino, muestre todos
                            $allFilters.addClass('visible');
                        } else {
                            if ($allFilters.hasClass('individual') && $allFilters.hasClass('visible')) { // EstÃ¡ visible, pero individualmente, le quitarÃ© eso...
                                $allFilters.removeClass('individual');
                            } else {
                                if (!$allFilters.hasClass('individual') && $allFilters.hasClass('visible')) { // EstÃ¡ visible, y sin individual, lo ocultarÃ©...
                                    $allFilters.removeClass('visible');
                                }
                            }
                        }
                        // [/B]
                        // verifico la dimenciÃ³n de la pantalla, para mostrar en fixed o como modal.
                        // [C] si es menor o igual a 768 siempre se mostrarÃ¡ en pantalla completa, con el body fixeado,
                        /* LO QUITE */
                        //if ($wrapFilters.width() <= 768) {
                        if ($wrapFilters.width() <= 959) {
                            //$cuerpo.toggleClass('fixed');
                            // @todo check fixed class
                            // $('html').toggleClass('fixed');
                            // Scrolleo si es necesario.
                            /*
                             var $SetScrollTop = $wrapFilters.position().top - Number($wrapFilters.css('margin-top').replace('px', ''));
                             if ($ventana.scrollTop() !== $SetScrollTop) {
                             $htmlcuerpo.animate({scrollTop:$SetScrollTop}, 800);
                             }
                             $htmlcuerpo.animate({scrollTop:0}, 800);
                             */
                            // Creo el scroll interno invisible del 'all filter'.
                            
                            /*Desactivando
                            if (!$allFilters.hasClass('ps-container')) {
                                setTimeout(function() {
                                    $allFilters.perfectScrollbar({
                                        suppressScrollX: true,
                                        minScrollbarLength: '42'
                                    });
                                }, ((Number($allFilters.css('transition-duration').replace('s', '')) * 1000) * 2));
                            }*/
                        }
                        // [/C]
                        // [D] Posiciono el 'All filter' dependiendo el ancho de la pantalla.
                        if ($wrapFilters.width() <= 640) {
                            $allFilters.css({ // porque la cabezera de los filtros estÃ¡n en una sola linea.
                                'top': ($wrapFilters.outerHeight() + $wrapFilters.position().top) + 'px',
                                'left': '0px',
                                'height': 'calc(100vh - ' + ($wrapFilters.outerHeight() + $theFilters.find('li.save').outerHeight()) + 'px)'
                            });
                        } else if ($wrapFilters.width() > 640 && $wrapFilters.width() <= 959) { // mayor a 640 pero menor a 768 pixeles de ancho.
                            if (!$allFilters.hasClass('neighborhood')) { // si no estoy en 'neighborhood' tengo todo el ancho de la pantalla.
                                $allFilters.css({ // porque la cabezera de los filtros estÃ¡n en 2 lineas.
                                    'left': '0px',
                                    'top': $wrapFilters.outerHeight() + 'px',
                                    'height': 'calc(100vh - ' + ($wrapFilters.outerHeight() + $applyFilters.outerHeight()) + 'px)'
                                });
                            } else { // estoy en 'neighborhood', lo aparesco diferente;
                                $allFilters.removeAttr('style');
                                console.log('Widt all filter: ' + $allFilters.width() + ' | position left clicked: ' + $liClicked.position().left + ' | Li clicked widht: ' + $liClicked.width());
                                $allFilters.css({
                                    'top': $wrapFilters.outerHeight() + 'px',
                                    //'left': ($allFilters.width() - ($liClicked.position().left + $liClicked.width())) + 'px'
                                    'right': '0',
                                    'left': 'auto',
                                    'transform': 'none'
                                });
                            }
                        } else { // cuando la cabezera de los filtros se muestran en 1 sola linea y el 'all filter' debe ser modal (de 960px para arriba).
                            $allFilters.removeAttr('style');
                            $allFilters.css('top', $wrapFilters.outerHeight() + 'px');
                            //creaScrollTemporal($allFilters, $citiesList);
                        }
                        // [/D]
                        break
                    default:
                        // Quito el fixed , ya que no es el LI 'ALL FILTER'
                        /*if ($cuerpo.hasClass('fixed')) {
                         $cuerpo.removeClass('fixed');
                         }*/
                        if ($('html').hasClass('fixed')) {
                            $('html').removeClass('fixed');
                        }
                        // Destruyo el 'perfect scroll bar' creado cuando era modal 'all filter'
                        /*Desactivando
                        if ($allFilters.hasClass('ps-container')) {
                            $allFilters.perfectScrollbar('destroy');
                        }*/

                        //  busco el mini filter vinculado al LI clickeado de la cabezera de filters
                        if ($liClicked.hasClass('active')) { // activo la flecha del LI clickeado
                            $miniFilter.addClass('visible').siblings().removeClass('visible'); //  aparesco el 'Mimi filter'
                            if (!$allFilters.hasClass('individual')) { // agrego la 'individualidad' solo si se viene de 'All filter', xq sino, yÃ¡ la tiene.
                                $allFilters.addClass('individual');
                                $allFilters.css('height', 'auto');
                            }
                            if (!$allFilters.hasClass('visible')) { // agrego la 'individualidad' solo si se viene de 'All filter', xq sino, yÃ¡ la tiene.
                                $allFilters.addClass('visible');
                            }
                            $allFilters.css({
                                'top': $wrapFilters.outerHeight() + 'px', // aparesco el filtro individual, justo abajito del boton LI que se hizo click
                                'left': (($liClicked.position().left + ($liClicked.outerWidth() / 2)) - 150) + 'px'
                            });
                        } else {
                            $allFilters.removeClass('visible');
                            $miniFilter.removeClass('visible');
                            $liClicked.removeClass('active');
                            setTimeout(function() {
                                $allFilters.removeClass('individual');
                            }, Number($allFilters.css('transition-duration').replace('s', '')) * 1000)
                        }
                }
            });
            // Escondo el 'All Filters' con el boton 'Apply filters', simulando click en 'All Filters'
            var $applyFilters = $('#apply-filters');
            if ($applyFilters.length) {
                $applyFilters.on('click', function() {
                    $theFilters.find('.all button').trigger('click');
                });
            }
            // Click fuera de 'All filters', desaparece.
            $(document).on('mouseup', function(e) {
                if ($allFilters.hasClass('visible')) {
                    if (!$wrapFilters.is(e.target) && $wrapFilters.has(e.target).length === 0) {
                        $theFilters.find('.active button').trigger('click');
                    }
                }
            });
            $theFilters.find('.mini-search, .save').on('click', function() {
                if ($allFilters.hasClass('visible')) {
                    $theFilters.find('.active button').trigger('click');
                }
            });
        }
        /*if ($("#wrap-filters").length) {
            scrollFixed('#wrap-filters');
        }*/
    });
    //alert('Ancho: ' + $(window).width() + ' | Alto: ' + $(window).height())
    // Variables Editables:
    var $textThComplet = 'Page % - LISTINGS % to %'; // Ã‰ste es el texto que aparecerÃ¡ en el separador cuando se cargue mÃ¡s items en la vista mapa, de la pÃ¡gina 'Search Results'. Ejm: Page 2 - LISTINGS 25 to 48
    //
    var $cuerpo = $('body');
    var $ventana = $(window);
    var $htmlcuerpo = $('html, body');
    //alert('Ancho: ' + $ventana.width() + 'px - Alto: ' + $ventana.height() + 'px');
    $ventana.on('load', function() {
        $cuerpo.removeClass('loading');
    });
    // Seleccionador de clases en los filtros.
    var $viewFilter = $('.filter-views');
    if ($viewFilter.length) {
        var $wrapResult = $('.wrap-result');
        // Cambio de vista por SELECT NATIVO
        $viewFilter.on('change', 'select', function() {
            console.log($viewFilter);
            switch ($(this).find('option:selected').val()) {
                case 'grid':
                    $viewFilter.removeClass('list map').addClass('grid');
                    $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                    $cuerpo.removeClass('view-list view-map');
                    $("#idx_view").val("grid");
                    break
                case 'list':
                    $viewFilter.removeClass('grid map').addClass('list');
                    $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                    $cuerpo.addClass('view-list').removeClass('view-map');
                    $("#idx_view").val("list");
                    break
                case 'map':
                    $viewFilter.removeClass('list grid').addClass('map');
                    $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                    $cuerpo.removeClass('view-list').addClass('view-map');
                    $("#idx_view").val("map");
                    /*console.log('trigger map resize');
                    google.maps.event.trigger(map, "resize");*/
                    setTimeout(function() {
                        var map_center = map.getCenter();
                        var map_zoom = map.getZoom();
                        google.maps.event.trigger(map, 'resize');
                        if (renderedMarkers === false) {
                            var bounds = new google.maps.LatLngBounds();
                            for (var i = 0, l = markers.length; i < l; i++) {
                                bounds.extend(markers[i].position);
                            }
                            map.fitBounds(bounds);
                        } else {
                            map.setCenter(map_center);
                            map.setZoom(map_zoom);
                        }
                    }, 100);
                    break
            }
            new LazyLoad({
              callback_error: function(element){
                $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
              }
            });
        });
        // Cambio de estado por select combertido a lista
        $viewFilter.on('click', 'li', function() {
            currentfiltemid=$(this).parent('ul').parent('li').attr('filtemid');
            $(this).addClass('active').siblings().removeClass('active');
            switch ($(this).attr('class').split(' ')[0]) {
                case 'grid':
                    $('.idxboost-content-filter-'+currentfiltemid+' ').find($wrapResult).removeClass('view-list view-map').addClass('view-grid');
                    $cuerpo.removeClass('view-list view-map');
                    
                    /*Desactivando scrollResultados(false)*/
                    break
                case 'list':
                    $('.idxboost-content-filter-'+currentfiltemid+' ').find($wrapResult).removeClass('view-grid view-map').addClass('view-list');
                    $cuerpo.addClass('view-list').removeClass('view-map');
                    /*Desactivando scrollResultados(false)*/
                    break
                case 'map':
                    $('.idxboost-content-filter-'+currentfiltemid+' ').find($wrapResult).removeClass('view-list view-grid').addClass('view-map');
                    $cuerpo.removeClass('view-list').addClass('view-map');
                    /*Desactivando scrollResultados(true);*/
                    // showFullMap();
                    break
            }
            new LazyLoad({
              callback_error: function(element){
                $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
              }
            });
        });
        var $wrapListResult = $('#wrap-list-result'); //seteo esto
        function scrollResultados(estado) {
            if (estado) { // creo slider
                if ($ventana.width() >= 1024) {
                    if (!$wrapListResult.hasClass('ps-container')) {
                        $wrapListResult.perfectScrollbar({
                            suppressScrollX: true
                        });
                        $wrapListResult.on('ps-y-reach-end', function() {
                            if (!$wrapListResult.hasClass('loading-more')) {
                                $wrapListResult.addClass('loading-more');
                                console.log('ahora cargarÃ© mÃ¡s ITEMS');
                                /////// PAUSADO
                                //-------- luego de cargar los nuevos items POR AJAX-------
                                /*
                                var moreItems = false; // pongo esto para ver si hay mÃ¡s items a agregar, puede ser que el resultado solo alcanse para 1 pÃ¡gina.
                                // 'Page % - LISTINGS % to %'
                                if (!moreItems) { //
                                  var $textThComplet;
                                  var $currentPage = $resultSearch.attr('data-cpage');
                                  if ($currentPage !== undefined) {
                                    $resultSearch.attr('data-cpage', Number($currentPage) + 1)
                                    //$textThComplet =
                                  } else {
                                    // estoy en la primera pÃ¡gina, asi que le pongo que estarÃ© en la 2
                                    $resultSearch.attr('data-cpage', '2');
                                  }
                                  $resultSearch.append('<li class="th-page">' + $textThComplete + '</li>' + $resultSearch.html()).promise().done(function(){
                                    $wrapListResult.perfectScrollbar('update');
                                    $wrapListResult.removeClass('loading-more');
                                  });
                                }
                                ////// AUN FALTA TRABAJAR EN ESTO
                                */
                            }
                        });
                    }
                }
            } else { // lo destruyo
                if ($wrapListResult.hasClass('ps-container')) {
                    $wrapListResult.perfectScrollbar('destroy');
                    /*
                    $wrapListResult.removeClass('ps-container ps-theme-default ps-active-y');
                    $wrapListResult.removeAttr('data-ps-id');
                    $wrapListResult.find('.ps-scrollbar-x-rail, .ps-scrollbar-y-rail').remove();
                    $wrapListResult.off('ontouchstart, touchend, touchmove, touchend');
                    */
                }
            }
        }
        // touchend de select 'Vista grid, list y map' a lista con botones.
        // Por defecto compruebo para mutar.
        if ($ventana.width() >= 768) {
            mutaSelectViews(true); //,por defecto que mute
        }
        // Al redimencionar muto los selects o Ul si corresponde
        $ventana.on('resize', function() {
            var $widthVentana = $ventana.width();
            if ($widthVentana >= 768) {
                mutaSelectViews(true)
            } else if ($widthVentana < 768) {
                mutaSelectViews(false);
            }
        });

        function mutaSelectViews(estado) {
            if (estado) {
                if (!$viewFilter.find('ul').length) {
                    //console.log('muto a lista, el Ancho es: ' + $ventana.width());
                    var $optionActive = $viewFilter.find('option:selected').val();
                    $viewFilter.find('option').each(function() {
                        $(this).replaceWith('<li class="' + $(this).val() + '">' + $(this).text() + '</li>');
                    });
                    var $theSelect = $viewFilter.find('select');
                    $theSelect.replaceWith('<ul>' + $theSelect.html() + '</ul>');
                    $viewFilter.find('.' + $optionActive).addClass('active');
                    $viewFilter.removeClass($optionActive);
                }
            } else {
                if (!$viewFilter.find('select').length) {
                    //console.log('muto a select nativo, el Ancho es: ' + $ventana.width());
                    var $indexLiActive = $viewFilter.find('.active').index();
                    var $classLiActive = $viewFilter.find('.active').attr('class').split(' ')[0];
                    $viewFilter.find('li').each(function() {
                        $(this).replaceWith('<option value="' + $(this).attr('class').split(' ')[0] + '">' + $(this).text() + '</option>');
                    });
                    var $theUl = $viewFilter.find('ul');
                    $theUl.replaceWith('<select>' + $theUl.html() + '</select>');
                    $viewFilter.find('option').eq($indexLiActive).prop('selected', true).siblings().prop('selected', false);
                    $viewFilter.addClass($classLiActive);
                }
            }
        }
    }
    // Results Search
    var $resultSearch = $('#result-search');
    if ($resultSearch.length) {

        function creaMiniSliders() {
            var $properties = $resultSearch.find('.propertie');
            var nproperties = $properties.length;
            for (var p = 0; p < nproperties; p++) {
                var $miniSlider = $properties.eq(p).find('.wrap-slider');
                if ($miniSlider.length) {
                    var $ulSlider = $miniSlider.find('> ul');
                    var $lisSlider = $ulSlider.find('> li');
                    var nLisEx = $lisSlider.length;
                    if (nLisEx > 1) {
                        $ulSlider.css('width', (nLisEx * 100) + '%');
                        $lisSlider.css('width', (100 / nLisEx) + '%');
                    }
                };
            }
        }
        // Escondo el 'All Filters' con el boton 'Apply filters', simulando click en 'All Filters'
        var $applyFilters = $('#apply-filters');
        if ($applyFilters.length) {
            $applyFilters.on('click', function() {
                $theFilters.find('.all button').trigger('click');
            });
        }
        // Click fuera de 'All filters', desaparece.
    }
    // Crea scroll para resultados , si es neighboorhood;
    var $neighborhood = $('#neighborhood');
    if ($neighborhood.length) {
        if ($ventana.width() >= 1280) {
            $('#neighborhood').perfectScrollbar({
                suppressScrollX: true,
                minScrollbarLength: '42'
            });
        }
    }
    // Escoge en el menu de 'neighborhood-menu' de Neighboorhood Results
    var $neighborhoodMenu = $('#neighborhood-menu');
    if ($neighborhoodMenu.length) {
        // Desaparece el menu cuando se hizo click en un LI
        $neighborhoodMenu.on('click', 'li', function() {
            $neighborhoodMenu.toggleClass('active');
            $(this).addClass('active').siblings().removeClass('active');
        })
    }
    // Abre y cierra el mapa en los resultados de busqueda: (Botones, Open y close)
    var $buttonsMap = $('#map-actions');
    if ($buttonsMap.length) {
        $buttonsMap.on('click', 'button', function() {
            $wrapListResult.toggleClass('closed');
            $(this).addClass('hide').siblings().removeClass('hide');
            setTimeout(function() {
                google.maps.event.trigger(map, 'resize');
                setTimeout(function() {
                    google.maps.event.trigger(map, 'resize');
                }, 200);
            }, 100);
        });
    }
    // Slider del menu de neighboorhood.
    // analizar, si se necesita convertir en funcion para luego anidar su ejecuciÃ³n permanente al evento .resize
    if ($neighborhoodMenu.width() >= 700) { // no pongo 768, xq en MAC: (1280), el espacio para el '$neighborhoodMenu' es solo de 720
        // Dando ancho relativo al contenedor de los enlaces;
        setTimeout(function() {
            var $enlacesNbh = $neighborhoodMenu.find('li');
            var nEnlacesNbh = $enlacesNbh.length
            if (nEnlacesNbh) { // Compruebo que existan enlaces
                var anchoUlNbh = 0;
                $enlacesNbh.each(function() {
                    anchoUlNbh = anchoUlNbh + $(this).outerWidth();
                });
                // Calculo el margen total de los items y luego doy ancho real al Ul
                var $anchoFinalUl = anchoUlNbh + (Number($enlacesNbh.eq(0).css('margin-right').replace('px', '')) * (nEnlacesNbh - 1))
                var $ulNbhMenu = $neighborhoodMenu.find('ul')
                    // Si los enlaces no son muchos, escondo las flechas
                var $menuNbhWidth = Number($neighborhoodMenu.find('.gwr').width());
                if ($anchoFinalUl < $neighborhoodMenu.width()) {
                    $neighborhoodMenu.find('button').addClass('hide');
                    var $porcentaje = Math.floor(($anchoFinalUl * 100) / $menuNbhWidth);
                    if ($porcentaje >= 65) { // si el porcentaje del ancho de los items sumados es mayor al 65%, damos flex
                        $ulNbhMenu.addClass('flex');
                    }
                } else {
                    $ulNbhMenu.css('width', $anchoFinalUl + 'px');
                    var $nextItemNbh = $neighborhoodMenu.find('.next-item');
                    var $prevItemNbh = $neighborhoodMenu.find('.prev-item');
                    // Asignando el desplazamiento para la flecha 'NEXT'
                    $nextItemNbh.on('click', function() { // Boton siguiente
                        var $lastItemMenuNbh = $enlacesNbh.eq(nEnlacesNbh - 1);
                        // Moviendo el menu
                        $ulNbhMenu.css('margin-left', '-' + (($menuNbhWidth - $lastItemMenuNbh.position().left) + $lastItemMenuNbh.width()) + 'px');
                        // Desactivando el boton
                        $(this).addClass('hide');
                        $prevItemNbh.removeClass('hide')
                    });
                    $prevItemNbh.on('click', function() {
                        $ulNbhMenu.css('margin-left', '0');
                        $(this).addClass('hide');
                        $nextItemNbh.removeClass('hide');
                    })
                }
            }
        }, 0);
    }

    widthTitleModal();
    $ventana.resize(function() {
        widthTitleModal();
    });
    var $openCloseMap = $('.map-actions button');
    if (typeof($openCloseMap) != 'undefined') {
        $openCloseMap.on('click', function() {
            $openCloseMap.removeClass('no-show');
            $(this).addClass('no-show');
            $('#wrap-list-result').toggleClass('hidden-results');
        });
    }
    var $showModal = $('.show-modal');
    if (typeof($showModal) != 'undefined') {
        $showModal.on('click', function() {
            var $idModal = $(this).attr('data-modal'); //Identificador del Modal a mostrar
            var $positionModal = $(this).attr('data-position'); //PosiciÃ³n en la que se encuentra el Modal
            var $modalImg = $('#' + $idModal).find('.lazy-img').attr('data-src'); //Consultamos si existe una imagen para mostrar en el Modal
            if (typeof($modalImg) != 'undefined') {
                $('#' + $idModal).find('.lazy-img').attr('src', $modalImg).removeAttr('data-src');
            }
            active_modal($idModal, $positionModal);
        });
    }
    //var $overlayModal = $('.overlay_modal');
    var $bodyModal = $('.modal_cm');
    var $bodyHtml = $('html');

    function active_modal(modal, positionmodal) {
        var $modal = $('#' + modal);
        var $positionModal = positionmodal;
        if ($modal.hasClass('active_modal')) {
            $('.overlay_modal').removeClass('active_modal');
        } else {
            $modal.addClass('active_modal');
            if ($positionModal == 0) {
                $bodyHtml.addClass('modal_fmobile');
                var $positionClose = 0;
            } else {
                $bodyHtml.addClass('modal_mobile');
                var $positionClose = 1;
            }
        }
        close_modal(modal, $positionClose);
    }

    function close_modal(modal, positionClose) {
        var $this, $parentModal;
        var $positionClose = positionClose; //PosiciÃ³n para cerrar el modal
        //CondiciÃ³n relacionada al botÃ³n close del modal
        if ($positionClose == 0) {
            $this = $('#' + modal).find('.close-btn'); //Boton close del modal
            $parentModal = 'modal_fmobile';
        } else {
            $this = $('#' + modal).find('.close'); //Boton close del modal
            $parentModal = 'modal_mobile';
        }
        $this.click(function() {
            var $modal = $this.closest('.active_modal');
            $modal.removeClass('active_modal');
            $bodyHtml.removeClass($parentModal);
        });
        /*$(document).keyup(function(e) {
          e.preventDefault();
          if (e.which === 27){
            $('#'+modal).removeClass('active_modal');
            $bodyHtml.removeClass('modal_mobile');
          }
        });*/
        $('#' + modal).find(".overlay_modal_closer").click(function() {
            $('#' + modal).removeClass('active_modal');
            $bodyHtml.removeClass('modal_mobile');
        });
    }

    function showFullMap() {
        console.log('activo');
        var flex_map_mini_view = $("#code-map");
        var myLatLng2 = {
            lat: parseFloat(flex_map_mini_view.data('lat')),
            lng: parseFloat(flex_map_mini_view.data('lng'))
        };
        var miniMap = new google.maps.Map(document.getElementById('code-map'), {
            zoom: 16,
            center: myLatLng2
        });
        var marker = new google.maps.Marker({
            position: myLatLng2,
            map: miniMap
        });
        google.maps.event.trigger(miniMap, "resize");
        $("#code-map").removeAttr("data-lat");
        $("#code-map").removeAttr("data-lng");
    }

    function widthTitleModal() {
        var $titleModal = $('#md-title');
        if (typeof($titleModal) != 'undefined') {
            var widthSize = $("#md-body").width();
            $titleModal.css({
                'width': widthSize + 'px'
            });
        }
    }
    //Final de Funciones agregadas el 20/04/2017
    // Funciones generales
    function apareceImagen(li) {
        var $laImagen = li.find('img');
        var $srcOriginal = $laImagen.attr('data-src');
        if ($srcOriginal !== undefined) {
            $laImagen.attr('src', $srcOriginal).removeAttr('data-src');
            li.addClass('loading');
            $laImagen.on('load', function() {
                li.removeClass('loading');
            });
        }
    }

    function itemActivo(losLi) { // refactorizar esto (nueva idea para la funciÃ³n).
        var nLis = losLi.length;
        for (var s = 0; s < nLis; s++) {
            if (losLi.eq(s).hasClass('active')) {
                return s;
            }
        }
    }

    function getGallery(mls, counter) {
        // ejemplo: http://retsimages.s3.amazonaws.com/34/A10172834_2.jpg
        var cdn = '//retsimages.s3.amazonaws.com';
        var folder = mls.substring((mls.length) - 2); // 34
        var list = [];
        var img = '';
        if (counter <= 0) {
            list.push(dgtCredential.imgComingSoon);
        } else {
            for (var i = 1; i <= counter; i++) {
                img = cdn + '/' + folder + '/' + mls + '_' + i + '.jpg';
                list.push(img);
            }
        }
        return list;
    }

    function creaScrollTemporal(creador, objetivo) {
        if (!objetivo.hasClass('ps-container')) {
            setTimeout(function() {
                objetivo.perfectScrollbar({
                    suppressScrollX: true,
                    minScrollbarLength: '42'
                });
            }, ((Number(creador.css('transition-duration').replace('s', '')) * 1000) * 2));
        }
    }

    function dgt_rangeSlide(elementRange, minr, maxr, stepTo, pricefrom, priceto, typev1, typev2, boolComa, maxStep, newStep) {
        $(elementRange).slider({
            range: true,
            min: minr,
            max: maxr,
            values: [minr, maxr],
            step: stepTo,
            slide: function(event, ui) {
                if (ui.values[0] > maxStep) {
                    newSepTo(elementRange, newStep);
                    //console.log('soy mas que: ' + maxStep);
                } else {
                    //if (step != stepTo) {
                    newSepTo(elementRange, stepTo);
                    //console.log('soy menos que: ' + maxStep);
                    //}
                }
                if (boolComa == true) {
                    $(pricefrom).val(typev1 + separadorComa(ui.values[0]) + " " + typev2);
                    $(priceto).val(typev1 + separadorComa(ui.values[1]) + " " + typev2);
                } else {
                    $(pricefrom).val(typev1 + ui.values[0] + " " + typev2);
                    $(priceto).val(typev1 + ui.values[1] + " " + typev2);
                }
            },
        });
    };

    function newSepTo(elementRange, newStep) {
        $(elementRange).slider({
            step: newStep
        });
    };

    function separadorComa(valor) {
        var nums = new Array();
        var simb = ","; //Ã‰ste es el separador
        valor = valor.toString();
        valor = valor.replace(/\D/g, ""); //Ã‰sta expresiÃ³n regular solo permitira ingresar nÃºmeros
        nums = valor.split(""); //Se vacia el valor en un arreglo
        var long = nums.length - 1; // Se saca la longitud del arreglo
        var patron = 3; //Indica cada cuanto se ponen las comas
        var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
        var res = "";
        while (long > prox) {
            nums.splice((long - prox), 0, simb); //Se agrega la coma
            prox += patron; //Se incrementa la posiciÃ³n prÃ³xima para colocar la coma
        }
        for (var i = 0; i <= nums.length - 1; i++) {
            res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
        }
        return res;
    };
    (function($) {
        var extensionMethods = {
            pips: function(settings) {
                options = {
                    first: "number",
                    last: "number",
                    rest: "pip"
                };
                $.extend(options, settings);
                this.element.addClass('ui-slider-pips').find('.ui-slider-pip').remove();
                var pips = this.options.max - this.options.min;
                for (i = 0; i <= pips; i++) {
                    var s = $('<span class="ui-slider-pip"><span class="ui-slider-line"></span><span class="ui-slider-number">' + i + '</span></span>');
                    if (0 == i) {
                        s.addClass('ui-slider-pip-first');
                        if ("number" == options.first) {
                            s.addClass('ui-slider-pip-number');
                        }
                        if (false == options.first) {
                            s.addClass('ui-slider-pip-hide');
                        }
                    } else if (pips == i) {
                        s.addClass('ui-slider-pip-last');
                        if ("number" == options.last) {
                            s.addClass('ui-slider-pip-number');
                        }
                        if (false == options.last) {
                            s.addClass('ui-slider-pip-hide');
                        }
                    } else {
                        if ("number" == options.rest) {
                            s.addClass('ui-slider-pip-number');
                        }
                        if (false == options.rest) {
                            s.addClass('ui-slider-pip-hide');
                        }
                    }
                    if (this.options.orientation == "horizontal") s.css({
                        left: '' + (100 / pips) * i + '%'
                    });
                    else s.css({
                        top: '' + (100 / pips) * i + '%'
                    });
                    this.element.append(s);
                }
            }
        };
        $.extend(true, $['ui']['slider'].prototype, extensionMethods);
    })(jQuery);

    function active_modal($modal) {
        if ($modal.hasClass('active_modal')) {
            $('.overlay_modal').removeClass('active_modal');
            // $("html, body").animate({
            //     scrollTop: 0
            // }, 1500);
        } else {
            $modal.addClass('active_modal');
            $modal.find('form').find('input').eq(0).focus();
            $('html').addClass('modal_mobile');
        }
        close_modal($modal);
    }

    function close_modal($obj) {
        var $this = $obj.find('.close');
        $this.click(function() {
            var $modal = $this.closest('.active_modal');
            $modal.removeClass('active_modal');
            $('html').removeClass('modal_mobile');
        });
    }
    $(function() {
        $("#wrap-list-result").on('scroll',function(){
            myLazyLoad.update();
        });

    if($ibAdvanced.length) {
        $ibAdvanced.on('click', function(){
            if (window.innerWidth < 990) {
              $(".ib-modal-filters-mobile").show();
            }

            // debugger;

            /*if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
              $("body").addClass("only-mobile");
            }*/
        });

        // hide more filter [mobile]
        $(".ib-close-modal-filters-mobile").on("click", function() {
            $(".ib-modal-filters-mobile").hide();
            $("body").removeClass("only-mobile");
        });

        // refresh page
        $("#ib-apply-clear").on("click", function() {
            window.scrollTo(0,0);
            location.href = flex_idx_filter_params.searchFilterPermalink;
        });

        // hide more filter [mobile]
        $("#ib-apply-filters-btn").on("click", function() {
            $(".ib-modal-filters-mobile").hide();
            window.scrollTo(0,0);
        });
    }

        $("#result-search, .result-search").on("click", ".view-detail", function() {
            var mlsNumber = $(this).parent('li').data('mls')

            originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
            console.log('opening...');

            loadPropertyInModal(mlsNumber);
        });

        $(document).on("click", ".view-detail", function(event) {
            event.preventDefault();
        });

        $('.property_type_checkbox').change(function(event){
            var typeProperty=[],text_type=[];
            $(".property_type_checkbox:checked").each(function(){
                typeProperty.push($(this).val());
            });

            if (typeProperty.indexOf("2") != -1 )
                text_type.push(word_translate.homes);
            

            if (typeProperty.indexOf("1") != -1 )
                text_type.push(word_translate.condominiums);

            if (typeProperty.indexOf("tw") != -1 )
                text_type.push(word_translate.townhouses);

            if (typeProperty.indexOf("mf") != -1 )
                text_type.push(word_translate.multi_family);            

            if (typeProperty.indexOf("valand") != -1 )
                text_type.push(word_translate.vacant_land);            

            if(text_type.length==5) {
                $('#text-type').text(word_translate.any_type);
            }else if (typeProperty.length>0){
                $('#text-type').text(text_type.join(', '));
            }else{
                $('#text-type').text(word_translate.any_type);
            }            

        });

        $('#result-search, .result-search').on("click", ".flex-favorite-btn", function(event) {
            event.stopPropagation();
            event.preventDefault();
            // active
            var buton_corazon = $(this);
            if (__flex_g_settings.anonymous === "yes") {
                active_modal($('#modal_login'));
            } else {
                // ajax favorite
                var class_id = $(this).parents('.propertie').data('class-id');
                var mls_num = $(this).parents('.propertie').data("mls");
                var property_subject = $(this).parents('.propertie').data("address");

                if (!$(this).find('.clidxboost-icon-check').hasClass('active')) {
                    //console.log('mark as favorite');
                    $(this).find('.clidxboost-icon-check').addClass('active');
                    $.ajax({
                        url: flex_idx_filter_params.ajaxUrl,
                        method: "POST",
                        data: {
                            action: "flex_favorite",
                            class_id: class_id,
                            mls_num: mls_num,
                            subject:property_subject,
                            search_url: window.location.href,
                            type_action: 'add'
                        },
                        dataType: "json",
                        success: function(data) {
                            /*console.log(data.message);
                            active_modal($('#modal_add_favorities'));
                            setTimeout(function() {
                                $('#modal_add_favorities').find('.close').click();
                            }, 2000); */
                            $(buton_corazon).attr("data-alert-token", data.token_alert);
                        }
                    });
                } else {
                    //console.log('remove from favorites');
                    $(this).find('.clidxboost-icon-check').removeClass('active');
                    var token_alert = $(this).attr("data-alert-token");
                    $.ajax({
                        url: flex_idx_filter_params.ajaxUrl,
                        method: "POST",
                        data: {
                            action: "flex_favorite",
                            class_id: class_id,
                            mls_num: mls_num,
                            type_action: 'remove',
                            token_alert: token_alert
                        },
                        dataType: "json",
                        success: function(data) {
                            //console.log(data.message);
                            $(buton_corazon).attr("data-alert-token", '');
                        }
                    });
                }
            }
        });
    });
    if (document.getElementById('code-map') === null) {
        return;
    }
    // console.dir(property_items);
    /******** MAP BEHAVIOR ********/
    var map;
    var markers = [];
    var infoWindow;
    var mapButtonsWrapper;
    var mapZoomInButton;
    var mapZoomOutButton;
    var mapDrawButton;
    var userIsDrawing = false;
    var userHasMapFigure = false;
    var renderedMarkers = false;
    var mapIsVisible = false;
    var polyStrokeColor = '#015288';
    var polyFillColor = '#0099FF';
    var hashed_properties = [];
    var filtered_properties = [];
    var unique_properties = [];
    var infobox_content = [];
    var geocode;
    var poly;
    var move;
    var properties = [];

    function initialize() {
        var style_map=[];
        myLazyLoad = new LazyLoad({
            elements_selector: ".flex-lazy-image",
            callback_load: function() {},
            callback_error: function(element){
              $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
              $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
            }
        });
    
        if(style_map_idxboost != undefined && style_map_idxboost != '') {
          style_map=JSON.parse(style_map_idxboost);
        }

        map = new google.maps.Map(
            document.getElementById('code-map'), {
            center: new google.maps.LatLng(25.761680, -80.19179),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 16,
            disableDoubleClickZoom: true,
            scrollwheel: false,
            panControl: false,
            streetViewControl: false,
            disableDefaultUI: true,
            clickableIcons: false,
            styles: style_map,
            gestureHandling: ("1" == __flex_g_settings.is_mobile) ? 'greedy' : 'cooperative'
        });
        google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);
        setupMarkers(filter_metadata.map_items);
    }

    function handleZoomInButton(event) {
        event.stopPropagation();
        event.preventDefault();
        map.setZoom(map.getZoom() + 1);
    }

    function handleZoomOutButton(event) {
        event.stopPropagation();
        event.preventDefault();
        map.setZoom(map.getZoom() - 1);
    }

    function handleDrawButton(event) {
        event.stopPropagation();
        event.preventDefault();
        if (this.classList.contains('flex-map-is-drawing')) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
            // remove polygon draw
            // $('#idx_page').val(1);
            // $('#idx_polygon').val('');
            // filter_refresh_search();
        } else {
            startDrawingMap();
            google.maps.event.addDomListener(map.getDiv(), "mousedown", handleMouseDown);
        }
    }

    function stopDrawingMap() {
        map.setOptions({
            draggable: true,
            zoomControl: true
        });
        mapDrawButton.classList.remove("flex-map-is-drawing");
        userIsDrawing = false;
    }

    function startDrawingMap() {
        if (infoWindow.isOpen()) {
            infoWindow.close();
        }
        map.setOptions({
            draggable: false,
            zoomControl: false
        });
        if (userHasMapFigure === true) {
            poly.setMap(null);
        }
        mapDrawButton.classList.add("flex-map-is-drawing");
        userIsDrawing = true;
    }

    function handleMapDrawing() {
        if (userIsDrawing === false) {
            return;
        }
        poly = new google.maps.Polyline({
            map: map,
            clickable: false,
            strokeColor: polyStrokeColor,
            strokeOpacity: 1,
            strokeWeight: 1
        });
        move = google.maps.event.addListener(map, "mousemove", handleMouseMove);
        google.maps.event.addListener(map, "mouseup", handleMouseUp);
    }

    function handleMouseMove(event) {
        poly.getPath().push(event.latLng);
    }

    function handleMouseUp(event) {
        google.maps.event.removeListener(move);
        if (userIsDrawing === false) {
            return;
        }
        poly.setMap(null);
        var path = poly.getPath();
        var theArrayOfLatLng = path.getArray();
        var arrayForPolygonSearch = [];
        var polyOptions = {
            map: map,
            fillColor: polyFillColor,
            fillOpacity: 0.25,
            strokeColor: polyStrokeColor,
            strokeWeight: 1,
            clickable: false,
            zIndex: 1,
            path: theArrayOfLatLng,
            editable: false
        };
        for (var i = 0, l = theArrayOfLatLng.length; i < l; i++) {
            arrayForPolygonSearch.push(theArrayOfLatLng[i].lat() + " " + theArrayOfLatLng[i].lng());
        }
        if (path.getArray().length) {
            arrayForPolygonSearch.push(path.getAt(0).lat() + ' ' + path.getAt(0).lng());
        }
        poly = new google.maps.Polygon(polyOptions);
        poly.setMap(map);
        google.maps.event.clearListeners(map.getDiv(), "mousedown");
        if (arrayForPolygonSearch.length) {
            var geometry = 'POLYGON((' + arrayForPolygonSearch.join(",") + '))';
            userHasMapFigure = true;
            // set polygon draw
            // $('#idx_page').val(1);
            // $('#idx_polygon').val(geometry);
            // filter_refresh_search();
        } else {
            userHasMapFigure = false;
        }
        stopDrawingMap();
    }

    function handleMouseDown(event) {
        event.stopPropagation();
        event.preventDefault();
        handleMapDrawing();
    }

    function setupMapControls() {
        // setup buttons wrapper
        mapButtonsWrapper = document.createElement("div");
        mapButtonsWrapper.classList.add('flex-map-controls-ct');
        // setup zoom in button
        mapZoomInButton = document.createElement("div");
        mapZoomInButton.classList.add('flex-map-zoomIn');
        mapButtonsWrapper.appendChild(mapZoomInButton);
        // setup zoom out button
        mapZoomOutButton = document.createElement("div");
        mapZoomOutButton.classList.add('flex-map-zoomOut');
        mapButtonsWrapper.appendChild(mapZoomOutButton);
        // setup draw button
        // mapDrawButton = document.createElement("div");
        // mapDrawButton.classList.add('flex-map-draw');
        // mapButtonsWrapper.appendChild(mapDrawButton);
        // setup listeners on buttons
        google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
        google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
        // google.maps.event.addDomListener(mapDrawButton, "click", handleDrawButton);
        // push controls to google map canvas
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
    }

    function setInitialStateSlider() {
        $("#wrap-result").find(".wrap-slider > ul li:first").each(function() {
            $(this).addClass("flex-slider-current");
        });
    }

/*NEW FILTER FROM MODALS*/
function buildMobileForm() {
    var ib_search_filter_params = flex_idx_filter_params.params;
    var ib_search_filter_frag = [];
    var ib_search_filter_dropdown;

    ib_min_price = $("#ib-min-price");
    ib_max_price = $("#ib-max-price");

    ib_min_rent_price = $("#ib-min-rent-price");
    ib_max_rent_price = $("#ib-max-rent-price");

    ib_min_beds = $("#ib-min-beds");
    ib_max_beds = $("#ib-max-beds");

    ib_min_baths = $("#ib-min-baths");
    ib_max_baths = $("#ib-max-baths");

    ib_m_types = $("#ib-flex-m-types");

    ib_m_parking = $("#ib-flex-m-parking");

    ib_min_living = $("#ib-min-living");
    ib_max_living = $("#ib-max-living");

    ib_min_land = $("#ib-min-land");
    ib_max_land = $("#ib-max-land");

    ib_min_year = $("#ib-min-year");
    ib_max_year = $("#ib-max-year");

    ib_waterfront_switch = $("#ib-flex-waterfront-switch");

    ib_m_features = $("#ib-flex-m-features");

    // FOR SALE [MOBILE]
    if (ib_min_price.length) {
        ib_search_filter_dropdown = ib_search_filter_params.price_sale_range;
        ib_search_filter_dropdown.splice(-1, 1);

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            if (("--" == option.value) || (0 == option.value)) { option.label = word_translate.any; }
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_min_price.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR SALE [MOBILE]
    if (ib_max_price.length) {
        ib_search_filter_dropdown = ib_search_filter_params.price_sale_range;
        ib_search_filter_dropdown.splice(-1, 1);

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            if (("--" == option.value) || (0 == option.value)) { option.label = word_translate.any; }
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_max_price.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR RENT [MOBILE]
    if (ib_min_rent_price.length) {
        ib_search_filter_dropdown = ib_search_filter_params.price_rent_range;
        ib_search_filter_dropdown.splice(-1, 1);

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            if (("--" == option.value) || (0 == option.value)) { option.label = word_translate.any; }
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_min_rent_price.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR RENT [MOBILE]
    if (ib_max_rent_price.length) {
        ib_search_filter_dropdown = ib_search_filter_params.price_rent_range;
        ib_search_filter_dropdown.splice(-1, 1);

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            if (("--" == option.value) || (0 == option.value)) { option.label = word_translate.any; }
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_max_rent_price.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR BEDS [MOBILE]
    if (ib_min_beds.length) {
        ib_search_filter_dropdown = ib_search_filter_params.beds_range;

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_min_beds.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR BEDS [MOBILE]
    if (ib_max_beds.length) {
        ib_search_filter_dropdown = ib_search_filter_params.beds_range.reverse();

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');


        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_max_beds.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR BATHS [MOBILE]
    if (ib_min_baths.length) {
        ib_search_filter_dropdown = _.filter(ib_search_filter_params.baths_range, function (row) { return !(row.value % 1 != 0);  });

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_min_baths.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR BATHS [MOBILE]
    if (ib_max_baths.length) {
        ib_search_filter_dropdown = _.filter(ib_search_filter_params.baths_range, function (row) {  return !(row.value % 1 != 0);  }).reverse();

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_max_baths.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR TYPES [MOBILE]
    if (ib_m_types.length) {
        ib_search_filter_dropdown = ib_search_filter_params.property_types;

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            var text_translate = '';

            if ('Single Family Homes' == option.label ){
                text_translate = word_translate.single_family_homes;
            }else if ('Condominiums' == option.label){
                text_translate = word_translate.condominiums;
            }else if ('Townhouses' == option.label){
                text_translate = word_translate.townhouses;
            }else if ('Multi-Family' == option.label){
                text_translate = word_translate.multi_family;
            }else if ('Vacant Land' == option.label){
                text_translate = word_translate.vacant_land;
            }else{
                text_translate = option.label;
            }

            ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input class="ib-m-types-checkboxes" type="checkbox" value="'+option.value+'" id="s_types_'+option.value+'"><label for="s_types_'+option.value+'">'+text_translate+'</label></li>');
        }

        if (ib_search_filter_frag.length) {
            ib_m_types.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR PARKING MOBILE
    if (ib_m_parking.length) {
        ib_search_filter_dropdown = ib_search_filter_params.parking_options;
        ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input class="ib-m-parking-checkboxes" name="ib_m_s_parking" type="radio" value="--" id="s_parking_any"><label for="s_parking_any">'+word_translate.any+'</label></li>');
        
        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];

            ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input name="ib_m_s_parking" type="radio" value="'+option.value+'" id="s_parking_'+option.value+'"><label for="s_parking_'+option.value+'">'+option.label+'</label></li>');
        }

        if (ib_search_filter_frag.length) {
            ib_m_parking.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR LIVING [MOBILE]
    if (ib_min_living.length) {
        ib_search_filter_dropdown = ib_search_filter_params.living_size_range;
        ib_search_filter_dropdown.splice(-1, 1);

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            if ("--" == option.value) {
                ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
            } else {
                ib_search_filter_frag.push('<option value="'+option.value+'">'+_.formatPrice(option.label)+' Sq.Ft.</option>');
            }
        }

        if (ib_search_filter_frag.length) {
            ib_min_living.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR LIVING [MOBILE]
    if (ib_max_living.length) {
        ib_search_filter_dropdown = ib_search_filter_params.living_size_range.reverse();
        ib_search_filter_dropdown.splice(-1, 1);

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            if ("--" == option.value) {
                ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
            } else {
                ib_search_filter_frag.push('<option value="'+option.value+'">'+_.formatPrice(option.label)+' Sq.Ft.</option>');
            }
        }

        if (ib_search_filter_frag.length) {
            ib_max_living.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR LAND [MOBILE]
    if (ib_min_land.length) {
        ib_search_filter_dropdown = ib_search_filter_params.lot_size_range;
        ib_search_filter_dropdown.splice(-1, 1);

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            if ("--" == option.value) {
                ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
            } else {
                ib_search_filter_frag.push('<option value="'+option.value+'">'+_.formatPrice(option.label)+' Sq.Ft.</option>');
            }
        }

        if (ib_search_filter_frag.length) {
            ib_min_land.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR LAND [MOBILE]
    if (ib_max_land.length) {
        ib_search_filter_dropdown = ib_search_filter_params.lot_size_range.reverse();
        ib_search_filter_dropdown.splice(-1, 1);

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            if ("--" == option.value) {
                ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
            } else {
                ib_search_filter_frag.push('<option value="'+option.value+'">'+_.formatPrice(option.label)+' Sq.Ft.</option>');
            }
        }

        if (ib_search_filter_frag.length) {
            ib_max_land.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR YEAR [MOBILE]
    if (ib_min_year.length) {
        ib_search_filter_dropdown = ib_search_filter_params.year_built_range;
        ib_search_filter_dropdown.splice(-1, 1);

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        ib_search_filter_frag.push('<option value="2020">2020</option>');

        if (ib_search_filter_frag.length) {
            ib_min_year.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR YEAR [MOBILE]
    if (ib_max_year.length) {
        ib_search_filter_dropdown = ib_search_filter_params.year_built_range.reverse();
        ib_search_filter_dropdown.splice(-1, 1);

        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');
        ib_search_filter_frag.push('<option value="2020">2020</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        ib_search_filter_frag.push('<option value="1900">1900</option>');

        if (ib_search_filter_frag.length) {
            ib_max_year.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }
    // FOR WATERFRONT [MOBILE]
    if (ib_waterfront_switch.length) {
        ib_search_filter_dropdown = _.sortBy(ib_search_filter_params.waterfront_options, "name");
        ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            var text_caracteristics ='';
            if (option.name=="Bay Front"){
                text_caracteristics=word_translate.bay_front;
            }else if ( option.name=="Canal"){
                text_caracteristics=word_translate.canal;
            }else if ( option.name=="Fixed Bridge"){
                text_caracteristics=word_translate.fixed_bridge;
            }else if ( option.name=="Intracoastal"){
                text_caracteristics=word_translate.intracoastal;
            }else if ( option.name=="Lake Front"){
                text_caracteristics=word_translate.lake_front;
            }else if ( option.name=="Ocean Access"){
                text_caracteristics=word_translate.ocean_access;
            }else if ( option.name=="Ocean Front"){
                text_caracteristics=word_translate.ocean_front;
            }else if ( option.name=="Point Lot"){
                text_caracteristics=word_translate.point_lot;
            }else if ( option.name=="River Front"){
                text_caracteristics=word_translate.river_front;
            }else{
                text_caracteristics=option.name;
            }
            
            ib_search_filter_frag.push('<option value="'+option.code+'">'+text_caracteristics+'</option>');
        }

        if (ib_search_filter_frag.length) {
            ib_waterfront_switch.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR FEATURES [MOBILE]
    if (ib_m_features.length) {
        ib_search_filter_dropdown = _.sortBy(ib_search_filter_params.amenities, "name");
        console.log(ib_search_filter_dropdown);

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];

            if (("equestrian" ==option.code) && (flex_idx_filter_params.boardId != "3")) {
                continue;
            }

            if (("loft" ==option.code) && (flex_idx_filter_params.boardId != "5")) {
                continue;
            }

            var text_caracteristics ='';
            if (option.name=='Swimming Pool'){
                text_caracteristics=word_translate.swimming_pool;
            }else if ( option.name=="Golf Course"){
                text_caracteristics=word_translate.golf_course;
            }else if ( option.name=="Tennis Courts"){
                text_caracteristics=word_translate.tennis_courts;
            }else if ( option.name=="Gated Community"){
                text_caracteristics=word_translate.gated_community;
            }else if ( option.name=="Lofts"){
                text_caracteristics=word_translate.lofts;
            }else if ( option.name=="Penthouse"){
                text_caracteristics=word_translate.penthouse;
            }else if ( option.name=="Water Front"){
                text_caracteristics=word_translate.water_front;
            }else if ( option.name=="Pets"){
                text_caracteristics=word_translate.pets;
            }else if ( option.name=="Furnished"){
                text_caracteristics=word_translate.furnished;
            }else if ( option.name=="Equestrian"){
                text_caracteristics=word_translate.equestrian;
            }else if ( option.name=="Boat Dock"){
                text_caracteristics=word_translate.boat_dock;
            }else if ( option.name=="Short Sales"){
                text_caracteristics=word_translate.short_sales;
            }else if ( option.name=="Foreclosures"){
                text_caracteristics=word_translate.foreclosures;
            }else{
                text_caracteristics=option.name;
            }

            ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input class="ib-m-features-checkboxes" type="checkbox" value="'+option.code+'" id="s_amenity_'+option.code+'"><label for="s_amenity_'+option.code+'">'+text_caracteristics+'</label></li>');
        }

        if (ib_search_filter_frag.length) {
            ib_m_features.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }
}


function fillValuesMobileForm(response,method=true) {
    var params = response.params;
    var infodata = response.info;
    ib_event_mobile=method;
    var min_price=params.min_price;
    
    if (null != params.min_price) {
        
        if (params.min_price=='--')
            min_price=0;

        ib_min_price.val(min_price);
    }

    // max price for sale
    var param_max_price=params.max_price;
    if (null != params.max_price) {
        if (params.max_price=='100000000'){
            param_max_price='--';
        }
        console.log(ib_max_price);
        ib_max_price.val(param_max_price);
    }

    // min price for rent
    if (null != params.min_rent_price) {
        ib_min_rent_price.val(params.min_rent_price);
    }

    // max price for rent
    if (null != params.max_rent_price) {
        ib_max_rent_price.val(params.max_rent_price);
    }

    // min beds
    if (null != params.min_beds) {
        ib_min_beds.val(params.min_beds);
    }

    // max beds
    if (null != params.max_beds) {
        ib_max_beds.val(params.max_beds);
    }

    // min baths
    if (null != params.min_baths) {
        ib_min_baths.val(params.min_baths);
    }

    // max baths
    if (null != params.max_baths) {
        ib_max_baths.val(params.max_baths);
    }

    // types
    var property_type=[];
    if (params.tab != undefined && params.tab != null && params.tab != '')
        property_type= params.tab.split('|');

    if (property_type.length == 0){
        property_type= infodata.property_type.split('|');
    }
    console.log(property_type);
    
    ib_m_types.find(":input").each(function(index, item) {
        item.checked = false;
        if (Array.isArray(property_type) && property_type.length>0 ){
            if (-1 !== $.inArray(item.value, property_type) ) 
                $(item).click();
        }else{
            $(item).click();
        }
    });

    // parking
    if (null != params.parking) {
        ib_m_parking.find(":input").each(function(index, item) {
            if (item.value == params.parking) {
                $(item).click();
            }
        });
    } else {
        $(ib_m_parking.find(":input")[0]).click();
    }

    // min living
    if (null != params.min_sqft) {
        ib_min_living.val(params.min_sqft);
    }

    // max living
    var text_max_sqft=params.max_sqft;
    if (null != params.max_sqft) {
        if (params.max_sqft=='80000'){
            text_max_sqft='--';
        }
        console.log(text_max_sqft);
        ib_max_living.val(text_max_sqft);
    }

    // min land
    if (null != params.min_lotsize) {
        ib_min_land.val(params.min_lotsize);
    }

    // max land
    var text_max_lotsize=params.max_lotsize;
    if (null != params.max_lotsize) {
        if (params.max_lotsize=='80000'){
            text_max_lotsize='--';
        }        
        console.log(text_max_lotsize);
        ib_max_land.val(text_max_lotsize);
    }

    // min year
    if (null != params.min_year) {
        ib_min_year.val(params.min_year);
    }

    // max year
    if (null != params.max_year) {
        ib_max_year.val(params.max_year);
    }

    // waterfront
    if (null != params.waterfront) {
        ib_waterfront_switch.val(params.waterfront);
    }

    // features
    var feature_amenities=[];
    if (params.features != undefined && params.features != null && params.features != '')
        feature_amenities= params.features.split('|');

        ib_m_features.find(":input").each(function(index, item) {
            item.checked = false;
            if (-1 !== $.inArray(item.value, feature_amenities) ) {
                $(item).click();
            }
        });
    
    $('#ib-apply-filters-btn span').html(_.formatShortPrice(ib_filter_metadata.counter)+' ');
    ib_event_mobile=true;
}

function attachListenersMobileForm() {
    ib_min_price.on("change", function() {
        var value = $(this).val();
        
        IB_SEARCH_FILTER_FORM.find('[name="idx[min_price]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_max_price.on("change", function() {
        var value = $(this).val();

        IB_SEARCH_FILTER_FORM.find('[name="idx[max_price]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_min_rent_price.on("change", function() {
        var value = $(this).val();


        IB_SEARCH_FILTER_FORM.find('[name="min_rent_price"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_max_rent_price.on("change", function() {
        var value = $(this).val();


        IB_SEARCH_FILTER_FORM.find('[name="max_rent_price"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_min_beds.on("change", function() {
        var value = $(this).val();


        IB_SEARCH_FILTER_FORM.find('[name="idx[min_beds]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_max_beds.on("change", function() {
        var value = $(this).val();


        IB_SEARCH_FILTER_FORM.find('[name="idx[max_beds]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_min_baths.on("change", function() {
        var value = $(this).val();


        IB_SEARCH_FILTER_FORM.find('[name="idx[min_baths]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_max_baths.on("change", function() {
        var value = $(this).val();


        IB_SEARCH_FILTER_FORM.find('[name="idx[max_baths]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_m_types.on("change", "input", function() {
        var checked_values = ib_m_types.find(":checked");
        var fill_values = [];

        checked_values.each(function () {
            fill_values.push($(this).val());
        });

        IB_SEARCH_FILTER_FORM.find('[name="idx[tab]"]').val(fill_values.join("|"));
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
        fill_values.length = 0;
    });

    ib_m_parking.on("click", "input", function() {
        var value = $(this).val();

        if ("--" == value) { value = ""; }

        IB_SEARCH_FILTER_FORM.find('[name="idx[parking]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_min_living.on("change", function() {
        var value = $(this).val();

        IB_SEARCH_FILTER_FORM.find('[name="idx[min_sqft]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_max_living.on("change", function() {
        var value = $(this).val();

        IB_SEARCH_FILTER_FORM.find('[name="idx[max_sqft]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_min_land.on("change", function() {
        var value = $(this).val();

        IB_SEARCH_FILTER_FORM.find('[name="idx[min_lotsize]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_max_land.on("change", function() {
        var value = $(this).val();

        IB_SEARCH_FILTER_FORM.find('[name="idx[max_lotsize]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_min_year.on("change", function() {
        var value = $(this).val();

        IB_SEARCH_FILTER_FORM.find('[name="idx[min_year]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_max_year.on("change", function() {
        var value = $(this).val();

        IB_SEARCH_FILTER_FORM.find('[name="idx[max_year]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_waterfront_switch.on("change", function() {
        var value = $(this).val();

        if ("--" == value || value==null || value == '') { value = "--"; }

        IB_SEARCH_FILTER_FORM.find('[name="idx[waterfront]"]').val(value);
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
    });

    ib_m_features.on("change", "input", function() {
        var checked_values = ib_m_features.find(":checked");
        var fill_values = [];

        checked_values.each(function () {
            fill_values.push($(this).val());
        });

        IB_SEARCH_FILTER_FORM.find('[name="idx[features]"]').val(fill_values.join("|"));
        IB_SEARCH_FILTER_FORM.find('[name="idx[page]"]').val(1);
        IB_SEARCH_FILTER_FORM.trigger("submit");
        fill_values.length = 0;
    });
}

function getPriceSaleValues(min, max) {
    var r_min = ((null == min) || ("--" == min)) ? 0 : price_slider_values.indexOf(parseInt(min, 10));
    var r_max = ((null == max) || ("--" == max)) ? (price_slider_values.length - 1) : price_slider_values.indexOf(parseInt(max, 10));

    return [ r_min, r_max ];
}

function getYearValues(min, max) {
    var r_min = ( (null == min) || ("--" == min) ) ? 0 : year_built_slider_values.indexOf(parseInt(min, 10));
    var r_max = ( (null == max) || ("--" == max)) ? (year_built_slider_values.length - 1) : year_built_slider_values.indexOf(parseInt(max, 10));

    return [ r_min, r_max ];
}

function getBedroomValues(min, max) {
    var r_min = ( (null == min) || ("--" == min) )  ? 0 : beds_slider_values.indexOf(parseInt(min, 10));
    var r_max = ( (null == max) || ("--" == max) )  ? (beds_slider_values.length - 1) : beds_slider_values.indexOf(parseInt(max, 10));

    return [ r_min, r_max ];
}

function getBathroomValues(min, max) {
    var r_min = ( (null == min) || ("--" == min) ) ? 0 : baths_slider_values.indexOf(parseInt(min, 10));
    var r_max = ( (null == max) || ("--" == max) ) ? (baths_slider_values.length - 1) : baths_slider_values.indexOf(parseInt(max, 10));

    return [ r_min, r_max ];
}

function getLivingSizeValues(min, max) {
    var r_min = ((null == min) || ("--" == min)) ? 0 : sqft_slider_values.indexOf(parseInt(min, 10));
    var r_max = ((null == max) || ("--" == max)) ? (sqft_slider_values.length - 1) : sqft_slider_values.indexOf(parseInt(max, 10));

    return [ r_min, r_max ];
}

function getLandSizeValues(min, max) {
    var r_min = ((null == min) || ("--" == min)) ? 0 : lotsize_slider_values.indexOf(parseInt(min, 10));
    var r_max = ((null == max) || ("--" == max)) ? (lotsize_slider_values.length - 1) : lotsize_slider_values.indexOf(parseInt(max, 10));

    return [ r_min, r_max ];
}

/*NEW FILTER FROM MODALS*/

    function filter_refresh_search() {
        if (flex_ui_loaded === false) {
            return;
        }
        if (idxboost_filter_countacti==false) {
            return false;
        }

        if (ib_event_mobile==false){
            return false;
        }

        var currentfiltemid = $(".flex-idx-filter-form:eq(0)").attr("filtemid");
        var flex_filter_form = $('.flex-idx-filter-form-'+ currentfiltemid);
        var idxboost_filter_class = flex_filter_form.attr('class');
        idxboost_filter_class = '.flex-idx-filter-form-'+ currentfiltemid;
        var idxboostnavresult ='.idxboost-content-filter-'+currentfiltemid+' #nav-results';
        var idxboostresult ='.idxboost-content-filter-'+currentfiltemid+' #result-search';


        if (flex_filter_form.length) {
            var flex_form_data = flex_filter_form.serialize();
            if(typeof ajax_request_filter !== 'undefined')
            ajax_request_filter.abort();

            ajax_request_filter=$.ajax({
                url: flex_idx_filter_params.ajaxUrl,
                type: "POST",
                data: flex_form_data,
                dataType: "json",
                success: function(response) {
                   if ("yes" === __flex_g_settings.anonymous) {
                     var buildObjectFilter = {
                       search_url: location.href,
                       search_count: response.counter,
                       name: response.title,
                       search_query: response.condition
                     };

                     localStorage.setItem("IB_SAVE_FILTER_PAYLOAD", JSON.stringify(buildObjectFilter));
                   }
                   var ar_filter_alert=[];

                    ar_filter_alert={
                    "sale_type" : response.info.rental_type,
                    "min_beds"  : response.info.min_bedrooms,
                    "max_beds"  : response.info.max_bedrooms,
                    "min_baths" : response.info.min_baths,
                    "max_baths" : response.info.max_baths,
                    "min_living_size" : response.info.min_living_size,
                    "max_living_size" : response.info.max_living_size
                    };

                   $('#idx_filter_condition').val(response.condition);
                   $('.filter_params_alert').val(JSON.stringify(ar_filter_alert));
                   
                   /*SLIDER COPIADO DE SEARCH FILTER*/
                   fillValuesMobileForm(response,false);
                   var params = response.params;
                   console.log(params);
                   ib_event_mobile=false;
                   // price for sale
                   IB_RG_PRICE_SALE.slider("option", "values", getPriceSaleValues(params.min_price, params.max_price));
                   // year built
                   IB_RG_YEARBUILT.slider("option", "values", getYearValues(params.min_year, params.max_year));
                   // bedrooms
                   IB_RG_BEDROOMS.slider("option", "values", getBedroomValues(params.min_beds, params.max_beds));
                   // bathrooms
                   IB_RG_BATHROOMS.slider("option", "values", getBathroomValues(params.min_baths, params.max_baths));
                   // living size
                   IB_RG_LIVINGSIZE.slider("option", "values", getLivingSizeValues(params.min_sqft, params.max_sqft));
                   // land size
                   IB_RG_LANDSIZE.slider("option", "values", getLandSizeValues(params.min_lotsize, params.max_lotsize));
                   //PARKING
                   var param_parking=params.parking;
                   if (params.parking==undefined || params.parking==''){ param_parking='--'; }
                   IB_RG_PARKING.val(param_parking);
                   //WATERFRONT
                   IB_RG_WATERFRONT.val(params.waterfront);
                   //features
                   var feature_amenities=[];
                   IB_RG_AMENITIES.each(function(index,item){
                        item.checked = false;
                        feature_amenities= params.features.split('|');
                        if (-1 !== $.inArray(item.value, feature_amenities) ) {
                            $(item).click();
                        }
                    });  
                    //property_type_checkbox
                   var property_type=[];
                   IB_RG_PROPERTY_TYPE.each(function(index,item){
                        item.checked = false;
                        property_type= params.tab.split('|');
                        if (-1 !== $.inArray(item.value, property_type) ) {
                            $(item).click();
                        }
                    });                                       
                   ib_event_mobile=true;
                   /*SLIDER COPIADO DE SEARCH FILTER*/

                    var items = response.items;
                    var listingHTML = [];
                    var paginationHTML = [];
                    var paging = response.pagination;

                    // xhr_running = false;
                    // $('#properties-found').html('<span>' + _.formatShortPrice(response.counter) + '</span> Properties');
                    $("#filter-save-search").data("count", response.counter);
                    $('#properties-found-2').html(_.formatShortPrice(response.counter));
                    $('#ib-apply-filters-btn span').html(_.formatShortPrice(response.counter)+' ');
                    $('#fs_inner_c').html(_.formatShortPrice(response.counter));
                    $('#info-subfilters').html(word_translate.showing+' ' +paging.offset.start+' '+word_translate.to+' ' +paging.offset.end+' '+word_translate.of+' '+ _.formatPrice(response.counter)+' '+word_translate.properties+'.');
                    $('#title-subfilters').html('<span>' + response.heading + '</span>');
                    for (var i = 0, l = items.length; i < l; i++) {
                        var item = response.items[i];
                        item.address_short = item.address_short.replace(/# /, "#");
                        item.address_large = item.address_large.replace(/ , /, ", ");

                        var text_is_rental='';
                        if (item.is_rental=='1')
                            text_is_rental='/'+word_translate.month;

                        var al = item.address_large.split(", ");
                        var st = al[1].replace(/[\d\s]/g, "");
                        var final_address = item.address_short + " " + al[0] + ", " + st;
                        var final_address_parceada = item.address_short + " <span>" + al[0] + ", " + al[1] + "</span>";

                        var final_address_parceada_new = " <span>"+ item.address_short.replace(/# /, "#") +", " + al[0] + ", " + al[1] + "</span>";

                        listingHTML.push('<li data-geocode="' + item.lat + ':' + item.lng + '" data-class-id="' + item.class_id + '" data-mls="' + item.mls_num + '" data-address="'+item.address_short+'" class="propertie">');
                        if (item.hasOwnProperty("status")) {
                            if (item.status == "5") {
                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.rented+'!</div>');
                            } else if (item.status == "2") {
                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.sold+'!</div>');
                            }
                        } else {
                            if (item.recently_listed === "yes") {
                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.new_listing+'!</div>');
                            }
                        }
                        if (view_grid_type=='1'){
                            listingHTML.push('<h2 title="' + item.full_address + '"><span>'+item.full_address_top+'</span><span>'+item.full_address_bottom+'</span></h2>');
                        }else{
                            listingHTML.push('<h2 title="' + item.full_address + '"><span>' + item.full_address + '</span></h2>');
                        }
                        listingHTML.push('<ul class="features">');
                        listingHTML.push('<li class="address">' + item.full_address + '</li>');
                        listingHTML.push('<li class="price">$' + _.formatPrice(item.price) + text_is_rental + '</li>');
                        if (item.reduced == '') {
                            listingHTML.push('<li class="pr">' + item.reduced + '</li>');
                        } else if (item.reduced < 0) {
                            listingHTML.push('<li class="pr down">' + item.reduced + '%</li>');
                        } else {
                            listingHTML.push('<li class="pr up">' + item.reduced + '%</li>');
                        }
                        var textbed = word_translate.bed;
                        if (item.bed > 1) {
                            textbed = word_translate.beds;
                        } else {
                            textbed = word_translate.bed;
                        }
                        listingHTML.push('<li class="beds">' + item.bed + ' <span>' + textbed + ' </span></li>');
                        var textbath = word_translate.bath;
                        if (item.bath > 1) {
                            textbath = word_translate.baths;
                        } else {
                            textbath = word_translate.bath;
                        }
                        if (item.baths_half > 0) {
                            listingHTML.push('<li class="baths">' + item.bath + '.5 <span>' + textbath + ' </span></li>');
                        } else {
                            listingHTML.push('<li class="baths">' + item.bath + ' <span>' + textbath + ' </span></li>');
                        }
                        listingHTML.push('<li class="living-size"> <span>' + _.formatPrice(item.sqft) + '</span>'+word_translate.sqft+' <span>(' + item.living_size_m2 + ' m2)</span></li>');
                        listingHTML.push('<li class="price-sf"><span>$' + item.price_sqft + ' </span>/ '+word_translate.sqft+'<span>($' + item.price_sqft_m2 + ' m2)</span></li>');
                        if (item.development !== '') {
                            listingHTML.push('<li class="development"><span>' + item.development + '</span></li>');
                        } else if (item.complex !== '') {
                            listingHTML.push('<li class="development"><span>' + item.complex + '</span></li>');
                        } else {
                            listingHTML.push('<li class="development"><span>' + item.subdivision + '</span></li>');
                        }
                        listingHTML.push('</ul>');
                        var totgallery='';
                        if (item.gallery.length <= 1) {
                            totgallery='no-zoom';
                        }
                        listingHTML.push('<div class="wrap-slider '+totgallery+'">');
                        listingHTML.push('<ul>');
                        for (var k = 0, m = item.gallery.length; k < m; k++) {
                            // listingHTML.push('<li><img src="' + item.gallery[k] + '" data-src="' + item.gallery[k] + '"></li>');
                            if (k <= 0) {
                                listingHTML.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="' + item.gallery[k] + '"></li>');
                            } else {
                                listingHTML.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="' + item.gallery[k] + '"></li>');
                            }
                        }
                        listingHTML.push('</ul>');
                        if (item.gallery.length > 1) {
                            listingHTML.push('<button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>');
                            listingHTML.push('<button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>');
                        }

                        if (!item.hasOwnProperty("status")) {
                            if (item.is_favorite) {
                                listingHTML.push('<button class="clidxboost-btn-check flex-favorite-btn"><span class="clidxboost-icon-check active"></span></button>');
                            } else {
                                listingHTML.push('<button class="clidxboost-btn-check flex-favorite-btn"><span class="clidxboost-icon-check"></span></button>');
                            }
                        }

                        listingHTML.push('</div>');
                        listingHTML.push('<a href="#" class="view-detail">'+item.full_address+'</a>');
                        listingHTML.push('<a class="view-map-detail" data-geocode="'+item.lat + ':' + item.lng+'">View Map</a>');
                        listingHTML.push('</li>');
                    }
                    $(idxboostresult).html(listingHTML.join("")).ready(function() {  idxboostTypeIcon();  if(typeof ppchack === 'function') { ppchack(); }  if(typeof idxboost_Hackedbox_cpanel === 'function') { idxboost_Hackedbox_cpanel(); } });


                    if (paging.total_pages_count > 1) {
                        paginationHTML.push('<span id="indicator">Pag ' + paging.current_page_number+' '+ word_translate.of+' ' + _.formatPrice(paging.total_pages_count) + '</span>');
                        if (paging.has_prev_page && paging.total_pages_count > 1) {
                            paginationHTML.push('<a href="#" data-page="1" title="First Page" id="firstp" class="ad visible">');
                            paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                            paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                            paginationHTML.push('<span>First page</span>');
                            paginationHTML.push('</a>');
                        }
                        if (paging.has_prev_page) {
                            paginationHTML.push('<a href="#" data-page="' + (paging.current_page_number - 1) + '" title="Prev Page" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible">');
                            paginationHTML.push('<span>Previous page</span>');
                            paginationHTML.push('</a>');
                        }
                        paginationHTML.push('<ul id="principal-nav">');
                        for (var i = 0, l = paging.range.length; i < l; i++) {
                            var loopPage = paging.range[i];
                            // if (i <= 3) {
                            if (paging.current_page_number === loopPage) {
                                paginationHTML.push('<li class="active"><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
                            } else {
                                paginationHTML.push('<li><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
                            }
                            // }
                        }
                        paginationHTML.push('</ul>');
                        if (paging.has_next_page) {
                            paginationHTML.push('<a href="#" data-page="' + (paging.current_page_number + 1) + '" title="Prev Page" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible">');
                            paginationHTML.push('<span>Next page</span>');
                            paginationHTML.push('</a>');
                        }
                        if (paging.has_next_page && paging.total_pages_count > 1) {
                            paginationHTML.push('<a href="#" data-page="' + paging.total_pages_count + '" title="First Page" id="lastp" class="ad visible">');
                            paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                            paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                            paginationHTML.push('<span>Last page</span>');
                            paginationHTML.push('</a>');
                        }
                    }
                    $(idxboostnavresult).html(paginationHTML.join(""));
                    $('.flex-loading-ct').fadeIn();

                    var idx_param_url=[];

                    if ( ($('#idx_min_price').val() != null || $('#idx_max_price').val() != null) && ($('#idx_min_price').val() != '--' || $('#idx_max_price').val() != '--') && ($('#idx_min_price').val() != '0' || $('#idx_max_price').val() != '100000000') )
                            idx_param_url.push('price='+$('#idx_min_price').val()+'~'+$('#idx_max_price').val());

                    if ( ($('#idx_min_rent_price').val() != null || $('#idx_max_rent_price').val() != null) && ($('#idx_min_rent_price').val() != '--' || $('#idx_max_rent_price').val() != '--') && ($('#idx_min_rent_price').val() != '0' || $('#idx_max_rent_price').val() != '100000000') )
                            idx_param_url.push('price_rent='+$('#idx_min_rent_price').val()+'~'+$('#idx_max_rent_price').val());                        

                    if ( ($('#idx_min_beds').val() != null || $('#idx_max_beds').val() != null) && ($('#idx_min_beds').val() != '--' || $('#idx_max_beds').val() != '--') )
                            idx_param_url.push('bed='+$('#idx_min_beds').val()+'~'+$('#idx_max_beds').val());

                    if ( ($('#idx_min_baths').val() != null || $('#idx_max_baths').val() != null) && ($('#idx_min_baths').val() != '--' || $('#idx_max_baths').val() != '--') )
                            idx_param_url.push('bath='+$('#idx_min_baths').val()+'~'+$('#idx_max_baths').val());                        

                    if ( ($('#idx_min_year').val() != null || $('#idx_max_year').val() != null) && ($('#idx_min_year').val() != '--' || $('#idx_max_year').val() != '--') && ($('#idx_min_year').val() != '1900' || $('#idx_max_year').val() != '2020') )
                            idx_param_url.push('yearbuilt='+$('#idx_min_year').val()+'~'+$('#idx_max_year').val());                        

                    if ( ($('#idx_min_sqft').val() != null || $('#idx_max_sqft').val() != null) && ($('#idx_min_sqft').val() != '--' || $('#idx_max_sqft').val() != '--') && ($('#idx_min_sqft').val() != '0' || $('#idx_max_sqft').val() != '80000') )
                            idx_param_url.push('sqft='+$('#idx_min_sqft').val()+'~'+$('#idx_max_sqft').val());                        

                    if ( ($('#idx_min_lotsize').val() != null || $('#idx_max_lotsize').val() != null) && ($('#idx_min_lotsize').val() != '--' || $('#idx_max_lotsize').val() != '--') && ($('#idx_min_lotsize').val() != '0' || $('#idx_max_lotsize').val() != '80000') )
                            idx_param_url.push('lotsize='+$('#idx_min_lotsize').val()+'~'+$('#idx_max_lotsize').val());                        

                    if ( $('#idx_parking').val() != null  && $('#idx_parking').val() != '--' && $('#idx_parking').val() != '' )
                            idx_param_url.push('parking='+$('#idx_parking').val());

                    if ( $('#idx_water_desc').val() != null  && $('#idx_water_desc').val() != '--' )
                            idx_param_url.push('waterdesc='+$('#idx_water_desc').val());

                    if ( $('#idx_features').val() != null  && $('#idx_features').val() != '' )
                            idx_param_url.push('fea='+$('#idx_features').val());

                    if ( $('#idx_property_type').val() != null  && $('#idx_property_type').val() != '' )
                            idx_param_url.push('type='+$('#idx_property_type').val());

                    if ( $('#idx_sort').val() != null  && $('#idx_sort').val() != '--' )
                            idx_param_url.push('sort='+$('#idx_sort').val());

                    if ( $('#idx_view').val() != null  && $('#idx_view').val() != '--' )
                            idx_param_url.push('view='+$('#idx_view').val());

                    if ( $('#idx_page').val() != null  && $('#idx_page').val() != '--' )
                            idx_param_url.push('pagenum='+$('#idx_page').val());                                                    

                    
                    if (response.hasOwnProperty("only_count") && (true === response.only_count)) {
                        var flex_filter_heading = $("#flex-idx-filter-heading_" + currentfiltemid);
                        var flex_filter_heading_tpl = flex_filter_heading.data("heading");
                        flex_filter_heading_tpl = flex_filter_heading_tpl.replace(/\{\{count\}\}/, _.formatPrice(response.counter));
                        flex_filter_heading_tpl = flex_filter_heading_tpl.replace(/\{\{rental\}\}/, (response.info.rental_type == 1 ? " For Rent " : " For Sale "));
                        flex_filter_heading.find("h4").html(flex_filter_heading_tpl);
                        }
                        var flex_idx_new_url = flex_idx_filter_params.sitewp + "?" + idx_param_url.join('&');
                        $("#idx-filter-min-btn_" + currentfiltemid).data("permalink", flex_idx_new_url);
                        history.pushState(null, '', flex_idx_new_url);

                    $("#search_count").val(response.counter);
                    idxboostcondition = response.condition;
                    $(idxboost_filter_class + " #flex-idx-search-form").data('save_count', response.counter);
                    $(idxboost_filter_class + " #flex-idx-search-form").data('next_page', response.pagination.has_next_page);
                    $(idxboost_filter_class + " #flex-idx-search-form").data('current_page', response.pagination.current_page_number);
                    // close all infowindow
                    if (typeof infoWindow !== 'undefined') {
                        if (infoWindow.isOpen()) {
                            infoWindow.close();
                        }
                    }

                    $('#wrap-list-result').show();
                    $('#paginator-cnt').show();
                    jQuery('#form-save .list-check .flex-save-type-options').removeAttr("disabled");
                    // reset scroll
                    if ($('.wrap-result').hasClass('view-map')){
                        $('#wrap-list-result').scrollTop(0);
                    }                    
                    // window.scrollTo(0, 0);
                    // first clean old markers
                    removeMarkers();
                    // setup markers on map
                    // var map_items = response.map_items;
                    // setupMarkers(map_items);
                    //setupMarkers(items);
                    $(window).scrollTop($('.clidxboost-sc-filters').offset().top);
                    setupMarkers(response.map_items);
                    // check lazy images
                    myLazyLoad.update();
                    setInitialStateSlider();
                    inifil_default=5;
                }
            });
        }
    }

    function idxboost_Hackedbox_cpanel() {
        var ib_object = jQuery('#result-search li.propertie, .result-search li.propertie');
        if(idxboost_hackbox_filter.status)
            if (idxboost_hackbox_filter.result.content != '')                                
                if(ib_object.length<3)
                    ib_object.eq(ib_object.length-1).after('<li class="propertie button_properties"><div class="ppc-content ppc-video-box">'+idxboost_hackbox_filter.result.content+'</div></li>');
                else
                    ib_object.eq(2).after('<li class="propertie button_properties"><div class="ppc-content ppc-video-box">'+idxboost_hackbox_filter.result.content+'</div></li>');            
    }

    function removeMarkers() {
        if (hashed_properties.length) {
            hashed_properties.length = 0;
        }
        if (filtered_properties.length) {
            filtered_properties.length = 0;
        }
        if (unique_properties.length) {
            unique_properties.length = 0;
        }
        if (markers.length) {
            for (var i = 0, l = markers.length; i < l; i++) {
                markers[i].setMap(null);
            }
            markers.length = 0;
        }
    }

    function setupMarkers(properties) {
        arrayother = properties;
        var bounds = new google.maps.LatLngBounds(),
            marker,
            property,
            row,
            i;
        infoWindow = new InfoBubble({
            map: map,
            disableAutoPan: true,
            shadowStyle: 0,
            padding: 0,
            borderRadius: 0,
            borderWidth: 0,
            disableAnimation: true,
            maxWidth: 380
        });

        infoWindow.addListener("domready", function() {
            $(".ib-load-property-iw").on("click", function(event) {
                event.preventDefault();
                event.stopPropagation();

                var _self = $(this);
                var mlsNum = _self.data("mls");

                console.log(mlsNum);
                originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
                console.log('opening...');

                loadPropertyInModal(mlsNum);          
/*

                if (__flex_g_settings.anonymous === 'yes') {
                    active_modal($('#modal_login'));
                    localStorage.setItem("ib_anon_mls", mlsNum);
                    return;
                }

                $('html').addClass('modal_mobile');
                $('#modal_property_detail').addClass('active_modal');
                $("#modal_property_detail .detail-modal").html('<span class="ib-modal-property-loading">Loading property details...</span>');

                $.ajax({
                    type: "POST",
                    url: __flex_g_settings.ajaxUrl,
                    data: { mlsNumber: mlsNum, action: "load_modal_property" },

                    success: function (response) {
                      $(document.body).addClass("modal-property-active");
                      $("#modal_property_detail .detail-modal").html(response);
                    },

                    complete: function(){
                      $('#full-main #clidxboost-data-loadMore-niche').trigger("click");
                      loadFullSlider(".clidxboost-full-slider");
                    }
                });
                */

            });
        });

        // reduce markers [first step]
        for (var i = 0, l = properties.length; i < l; i++) {
            row = properties[i];
            geocode = row.lat + ':' + row.lng;
            if (_.indexOf(hashed_properties, geocode) === -1) {
                hashed_properties.push(geocode);
                filtered_properties.push(row);
            }
        }
        // reduce markers [second step]
        for (var i = 0, l = filtered_properties.length; i < l; i++) {
            row = filtered_properties[i];
            geocode = [row.lat, row.lng];
            // reset array
            var related_properties = [];
            for (var k = 0, m = properties.length; k < m; k++) {
                inner = properties[k];
                if ((inner.lat == geocode[0]) && (inner.lng == geocode[1])) {
                    related_properties.push(inner);
                }
            }
            unique_properties.push({
                item: row,
                group: related_properties
            });
        }
        // console.dir(unique_properties);
        for (i = 0; i < unique_properties.length; i++) {
            property = unique_properties[i];
            marker = new RichMarker({
                position: new google.maps.LatLng(parseFloat(property.item.lat), parseFloat(property.item.lng)),
                map: map,
                flat: true,
                draggable: false,
                content: (property.group.length > 1) ? '<div class="dgt-richmarker-group"><strong>' + property.group.length + '</strong><span>Units</span></div>' : '<div class="dgt-richmarker-single"><strong>$' + _.formatShortPrice(property.item.price) + '</strong></div>',
                anchor: RichMarkerPosition.TOP
            });
            marker.geocode = property.item.lat + ':' + property.item.lng;
            bounds.extend(marker.position);
            markers.push(marker);
            google.maps.event.addListener(marker, "click", handleMarkerClick(marker, property, map));

            if (/webOS|iPhone|iPad/i.test(navigator.userAgent) === false) {
                google.maps.event.addListener(marker, "mouseover", handleMarkerMouseOver(marker));
                google.maps.event.addListener(marker, "mouseout", handleMarkerMouseOut(marker));
            }            
        }
        
        if (typeof map !== "undefined") {
            map.fitBounds(bounds);
        }
    }

    function handleMarkerClick(marker, property, map) {
        return function() {
            if (property.group.length > 1) {
                // multiple
                infobox_content.push('<div class="mapview-container">');
                infobox_content.push('<div class="mapviwe-header">');
                infobox_content.push('<h2>' + property.item.heading + '</h2>');
                infobox_content.push('<span class="build">' + property.group.length + '</span>');
                infobox_content.push('<button class="closeInfo"><span>'+word_translate.close+'</span></button>');
                infobox_content.push('</div>');
                infobox_content.push('<div class="mapviwe-body">');
                for (var i = 0, l = property.group.length; i < l; i++) {
                    var property_group = property.group[i];
                    infobox_content.push('<div class="mapviwe-item">');
                    infobox_content.push('<h2 title="' + property_group.address_short.replace(/# /, "#") + '"><span>' + property_group.address_short.replace(/# /, "#") + '</span></h2>');
                    infobox_content.push('<ul>');
                    infobox_content.push('<li class="address"><span>' + property_group.address_large.replace(/ , /, ", ") + '</span></li>');
                    infobox_content.push('<li class="price">$' + _.formatPrice(property_group.price) + '</li>');
                    var textpropertybed = word_translate.beds;
                    var textpropertybath = word_translate.baths;
                    if (property_group.bed > 1) {
                        textpropertybed = word_translate.beds;
                    } else {
                        textpropertybed = word_translate.bed;
                    }
                    if (property_group.bath > 1) {
                        textpropertybath = word_translate.baths;
                    } else {
                        textpropertybath = word_translate.bath;
                    }
                    infobox_content.push('<li class="beds"><b>' + property_group.bed + '</b> <span> ' + textpropertybed + '</span></li>');
                    infobox_content.push('<li class="baths"><b>' + property_group.bath + '</b> <span> ' + textpropertybath + '</span></li>');
                    infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property_group.sqft) + '</span> SF<span>(' + property_group.living_size_m2 + ' m2)</span></li>');
                    infobox_content.push('<li class="price-sf"><span>$' + property_group.price_sqft + ' </span>/ SF<span>($' + property_group.price_sqft_m2 + ' m2)</span></li>');
                    infobox_content.push('</ul>');
                    infobox_content.push('<div class="mapviwe-img">');
                    infobox_content.push('<img title="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '" alt="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '" src="' + property_group.gallery[0] + '">');
                    infobox_content.push('</div>');
                    infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property_group.mls_num + '" href="' + flex_idx_filter_params.propertyDetailPermalink + '/' + property_group.slug + '" title="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '">' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '</a>');
                    infobox_content.push('</div>');
                }
                infobox_content.push('</div>');
                infobox_content.push('</div>');
            } else {
                var text_is_rental='';
                if (property.item.is_rental=='1')
                    text_is_rental='/'+word_translate.month;

                // single
                infobox_content.push('<div class="mapview-container">');
                infobox_content.push('<div class="mapviwe-header">');
                infobox_content.push('<h2>' + property.item.heading + '</h2>');
                infobox_content.push('<button class="closeInfo"><span>'+word_translate.close+'</span></button>');
                infobox_content.push('</div>');
                infobox_content.push('<div class="mapviwe-body">');
                infobox_content.push('<div class="mapviwe-item">');
                infobox_content.push('<h2 title="' + property.item.address_short.replace(/# /, "#") + '"><span>' + property.item.address_short.replace(/# /, "#") + '</span></h2>');
                infobox_content.push('<ul>');
                infobox_content.push('<li class="address"><span>' + property.item.address_large.replace(/ , /, ", ") + '</span></li>');
                infobox_content.push('<li class="price">$' + _.formatPrice(property.item.price)+text_is_rental + '</li>');
                var textpropertyitembed = word_translate.beds;
                var textpropertyitembath = word_translate.baths;
                if (property.item.bed > 1) {
                    textpropertyitembed = word_translate.beds;
                } else {
                    textpropertyitembed = word_translate.bed;
                }
                if (property.item.bath > 1) {
                    textpropertyitembath = word_translate.baths;
                } else {
                    textpropertyitembath = word_translate.bath;
                }
                infobox_content.push('<li class="beds"><b>' + property.item.bed + '</b> <span> ' + textpropertyitembed + '</span></li>');
                infobox_content.push('<li class="baths"><b>' + property.item.bath + '</b> <span> ' + textpropertyitembath + '</span></li>');
                infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property.item.sqft) + '</span> SF<span>(' + property.item.living_size_m2 + ' m2)</span></li>');
                infobox_content.push('<li class="price-sf"><span>$' + property.item.price_sqft + ' </span>/ SF<span>($' + property.item.price_sqft_m2 + ' m2)</span></li>');
                infobox_content.push('</ul>');
                infobox_content.push('<div class="mapviwe-img">');
                infobox_content.push('<img title="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '" alt="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '" src="' + property.item.gallery[0] + '">');
                infobox_content.push('</div>');
                infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property.item.mls_num + '" href="' + flex_idx_filter_params.propertyDetailPermalink + '/' + property.item.slug + '" title="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '">' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '</a>');
                infobox_content.push('</div>');
                infobox_content.push('</div>');
                infobox_content.push('</div>');
            }
            if (infobox_content.length) {
                infoWindow.setContent(infobox_content.join(""));
                infoWindow.open(map, marker);
                infobox_content.length = 0;
            }
        };
    }


    function handleMarkerMouseOver(marker) {
        return function() {
            marker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
        };
    }

    function handleMarkerMouseOut(marker) {
        return function() {
            marker.setZIndex(google.maps.Marker.MAX_ZINDEX - 1);
        };
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    $(function() {
        $("#filter-views").on("click", "li", function() {
            if ($(this).hasClass("map")) {
                mapIsVisible = true;
                setTimeout(function() {
                    var map_center = map.getCenter();
                    var map_zoom = map.getZoom();
                    google.maps.event.trigger(map, 'resize');
                    if (renderedMarkers === false) {
                        var bounds = new google.maps.LatLngBounds();
                        for (var i = 0, l = markers.length; i < l; i++) {
                            bounds.extend(markers[i].position);
                        }
                        map.fitBounds(bounds);
                    } else {
                        map.setCenter(map_center);
                        map.setZoom(map_zoom);
                    }
                }, 100);
            } else {
                mapIsVisible = false;
            }
            new LazyLoad({
              callback_error: function(element){
                $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
              }
            });
        });
        // $("#nav-results a").on("click", function() {
        //     update_view_page(this);
        // });
        flex_pagination = $('.nav-results');
        if (flex_pagination.length) {
            flex_pagination.on('click', 'a', function(event) {
                event.preventDefault();
                var currentPage = $(this).data('page');
                //console.log($(this).parent('nav ul li'));
                currentfiltemid = $(this).parent('li').parent('ul').parent('nav').attr('filtemid');
                if($(this).attr('id')=='nextn' || $(this).attr('id')=='lastp' || $(this).attr('id')=='firstp' || $(this).attr('id')=='prevn' ) {
                    currentfiltemid=$(this).parent('nav').attr('filtemid');
                }

                $('.nav-results-'+currentfiltemid+' ul#principal-nav li').removeClass('active');
                $('.nav-results-'+currentfiltemid+' ul#principal-nav #page_' + currentPage).addClass('active');
                // history.pushState(null, '', $(this).attr('norefre'));
                $('.flex-idx-filter-form-'+currentfiltemid+' #idx_page').val(currentPage);
                // do ajax
                filter_refresh_search();
                // filter_change_page();
            });
        }

        function update_view_page(evento) {
            $('#nav-results ul#principal-nav li').removeClass('active');
            $('#nav-results ul#principal-nav #page_' + $(evento).attr('page')).addClass('active');
            history.pushState(null, '', $(evento).attr('norefre'));
            $('#idx_page').val($(this).attr('page'));
            // filter_change_page();
        }

        $("#result-search").on("mouseover", ">li", function(event) {
            if ($(this).hasClass("propertie")) {

                if (/webOS|iPhone|iPad/i.test(navigator.userAgent) ) {
                    return false;
                }
                        
                var geocodePoint = $(this).data("geocode");

                if (typeof geocodePoint === 'undefined') {
                    return;
                }

                if (!geocodePoint.length) {
                    return;
                }

                for (var i = 0, l = markers.length; i < l; i++) {
                    if (geocodePoint == markers[i].geocode) {
                        new google.maps.event.trigger(markers[i], 'click');
                        break;
                    }
                }
            }
        });

        $("#result-search").on("mouseleave", ">li", function(event) {
            if (typeof infoWindow !== 'undefined') {
                if (infoWindow.isOpen()) {
                    infoWindow.close();
                }
            }
        });

        var $wrapListResult = $('#wrap-list-result');

        $wrapListResult.on('ps-y-reach-end', _.debounce(function() {
            // next page
            // var has_next_page = $("#flex-idx-search-form").data("next_page");
            var has_next_page = filter_metadata.pagination.has_next_page;
            // var current_page = $("#flex-idx-search-form").data("current_page");
            var current_page = filter_metadata.pagination.current_page_number;
            if ($('#filter-views').find('.map:eq(0)').hasClass('active') && has_next_page == true) {
                console.log('map next page');
                /*if (has_next_page === true) {
                    $("#idx_page").val(current_page + 1);
                    filter_refresh_search();
                }*/
            }
        }, 800));
    });
    if (typeof search_metadata === 'undefined') {
        return;
    }
    var baths_slider_values = _.pluck(search_metadata.baths_range, 'value');
    var beds_slider_values = _.pluck(search_metadata.beds_range, 'value');
    var sqft_slider_values = _.pluck(search_metadata.living_size_range, 'value');
    var lotsize_slider_values = _.pluck(search_metadata.lot_size_range, 'value');
    var year_built_slider_values = _.pluck(search_metadata.year_built_range, 'value');
    var price_slider_values = _.pluck(search_metadata.price_sale_range, 'value');
    var price_rent_slider_values = _.pluck(search_metadata.price_rent_range, 'value');
    var baths_slider;
    var beds_slider;
    var sqft_slider;
    var lotsize_slider;
    var price_slider;
    var price_rent_slider;
    var year_built_slider;
    /*
        function filter_refresh_search() {
            console.log('update search');
        }
    */
    //INICIO_FORMULARIO
    $(function() {
        // DOM ready
        // Setup sliders
    $(document).on("click", "#modal_login .close-modal", function(event) {
        event.preventDefault();
        $(".ib-pbtnclose").click();
    });                

    $('.overlay_modal_closer').click(function(){
            event.preventDefault();
            $(".ib-pbtnclose").click();
    });

        $(document).ready(function(){
            var idxboostsearch =window.location.search.split('&');
            var urlParams = new URLSearchParams(window.location.search);
            idxboostsearch.forEach(function(elementboost){
            var keyelement=elementboost.split('=');
            if (keyelement[0].indexOf('savesearch') != -1) {
                if (flex_idx_filter_params.anonymous != 'yes') {
                    active_modal($('#modal_login'));
                }
            }
            });
            idxboost_filter_countacti=true;
            buildMobileForm();
            attachListenersMobileForm();
            fillValuesMobileForm(ib_filter_metadata,false);
            if (urlParams.has("show")) {
                var mlsNumber = urlParams.get("show");

                originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
                console.log('opening...');

                loadPropertyInModal(mlsNumber);
            }
        });

    if (IB_SEARCH_FILTER_FORM.length) {
        IB_SEARCH_FILTER_FORM.on("submit",function(event){
            if (typeof event !== "undefined") {
                event.preventDefault();
            }
            if (ib_event_mobile != false){
                filter_refresh_search();
            }
        });

        // init request [xhr]
    }


        baths_slider = $("#range-baths");
        beds_slider = $("#range-beds");
        sqft_slider = $("#range-living");
        lotsize_slider = $("#range-land");
        price_slider = $("#range-price");
        price_rent_slider = $("#range-price-rent");
        year_built_slider = $('#range-year');

        if (price_rent_slider.length) {
            price_rent_slider.slider({
                range: true,
                min: 0,
                max: price_rent_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#price_rent_from').val('$' + _.formatPrice(price_rent_slider_values[startValue]));
                    $('#price_rent_to').val('$' + _.formatPrice(price_rent_slider_values[endValue]));
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_rent_price').val() === '--' ? price_rent_slider_values[0] : parseInt($('#idx_min_rent_price').val(), 10);
                    var max_val = $('#idx_max_rent_price').val() === '--' ? price_rent_slider_values[price_rent_slider_values.length - 1] : parseInt($('#idx_max_rent_price').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_rent_price').val() === '--' ? 0 : price_rent_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_rent_price').val() === '--' ? (price_rent_slider_values.length - 1) : price_rent_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                    $('#price_rent_from').val('$' + _.formatPrice(min_val));
                    $('#price_rent_to').val('$' + _.formatPrice(max_val));
                },                
                change: function(event, ui) {
                    currentfiltemid=$(this).parent('.wrap-range').parent('div').parent('div').parent('li').parent('ul').parent('div').parent('div').parent('div').parent('div').parent('div').attr('filtemid');
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    if (idxboost_filter_countacti) {
                        $('#idx_min_rent_price').val(price_rent_slider_values[startValue]);
                        $('#idx_max_rent_price').val(price_rent_slider_values[endValue]);
                        // do ajax
                        filter_refresh_search();
                    }
                }
            });
        }
        

        if (price_slider.length) {
            price_slider.slider({
                range: true,
                min: 0,
                max: price_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#price_from').val('$' + _.formatPrice(price_slider_values[startValue]));
                    $('#price_to').val('$' + _.formatPrice(price_slider_values[endValue]));
                    // flex_input_min_price_sale_old_value = price_slider_values[startValue];
                    // flex_input_max_price_sale_old_value = price_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_price').val() === '--' ? price_slider_values[0] : parseInt($('#idx_min_price').val(), 10);
                    var max_val = $('#idx_max_price').val() === '--' ? price_slider_values[price_slider_values.length - 1] : parseInt($('#idx_max_price').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_price').val() === '--' ? 0 : price_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_price').val() === '--' ? (price_slider_values.length - 1) : price_slider_values.indexOf(max_val);

                    var min = $('#idx_min_price').val();
                    var max = $('#idx_max_price').val();


                    if ( (0 == min) || ("--" == min)) {
                        min = '$0';
                    } else {
                        min = "$" + _.formatPrice(min);
                    }
                    
                    if ( (0 == max) || ("--" == max) || (max ==100000000 ) ) {
                        max = word_translate.any_price;
                    } else {
                        max = "$" + _.formatPrice(max);
                    }

                    _self.slider('values', [startValue, endValue]);
                    $('#price_from').val(min);
                    $('#price_to').val(max);
                },
                change: function(event, ui) {
                    console.log("event");
                    currentfiltemid=$(this).parent('.wrap-range').parent('div').parent('div').parent('li').parent('ul').parent('div').parent('div').parent('div').parent('div').parent('div').attr('filtemid');
                    
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    var min = price_slider_values[ui.values[0]];
                    var max = price_slider_values[ui.values[1]];


                    if ( (0 == min) || ("--" == min)) {
                        min = '$0';
                    } else {
                        min = "$" + _.formatPrice(min);
                    }
                    
                    if ( (0 == max) || ("--" == max) || (max ==100000000 ) ) {
                        max = word_translate.any_price;
                    } else {
                        max = "$" + _.formatPrice(max);
                    }

                    var min_lbl = price_slider_values[ui.values[0]];
                    var max_lbl = price_slider_values[ui.values[1]];

                    if (
                        ( ("--" == min_lbl) && ("--" == max_lbl) ) ||
                        ( (0 == min_lbl) && (0 == max_lbl) ) ||
                        ( (0 == min_lbl) && ("--" == max_lbl) ) ||
                        ( (0 == min_lbl) && (100000000 == max_lbl) ) 
                    ) {
                        $('#text-price').html(word_translate.any_price);
                    } else {
                        if ( ("--" == max_lbl || 100000000 == max_lbl ) && ( (!isNaN(min_lbl)) && (min_lbl > 0) ) ) {
                            $('#text-price').html("$" + _.formatShortPrice(min_lbl) + " - "+word_translate.any_price);
                        } else {
                            $('#text-price').html("$" + _.formatShortPrice(min_lbl) + " - $" + _.formatShortPrice(max_lbl));
                        }
                    }
                    $('#price_to').val(max);
                
                    if (idxboost_filter_countacti) {
                    $('#idx_min_price').val(price_slider_values[startValue]);
                    $('#idx_max_price').val(price_slider_values[endValue]);
                    $("#idx_page").val(1);
                    // do ajax
                    filter_refresh_search();
                    }
                }
            });
        }
        if (baths_slider.length) {
            baths_slider.slider({
                range: true,
                min: 0,
                max: baths_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    console.log('From %s to %s', baths_slider_values[startValue], baths_slider_values[endValue]);
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_baths').val() === '--' ? baths_slider_values[0] : parseInt($('#idx_min_baths').val(), 10);
                    var max_val = $('#idx_max_baths').val() === '--' ? baths_slider_values[baths_slider_values.length - 1] : parseInt($('#idx_max_baths').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_baths').val() === '--' ? 0 : baths_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_baths').val() === '--' ? (baths_slider_values.length - 1) : baths_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    var min_lbl = baths_slider_values[ui.values[0]];
                    var max_lbl = baths_slider_values[ui.values[1]];

                    if (
                        ( (0 == min_lbl) && (6 == max_lbl) ) ||
                        ( (6 == min_lbl) && (6 == max_lbl) ) ||
                        ( (0 == min_lbl) && (0 == max_lbl) )
                    ) {
                        $('#text-baths').html(word_translate.any_baths);
                    } else {
                        if (max_lbl > 5) {
                            $('#text-baths').html(min_lbl + " - "+word_translate.any_baths);
                        } else {
                            $('#text-baths').html(min_lbl + " - " + max_lbl + " "+word_translate.bath);
                        }
                    }

                    var initialStartValue = (baths_slider_values[startValue] == baths_slider_values[0]) ? '--' : baths_slider_values[startValue];
                    var initialEndValue = (baths_slider_values[endValue] == baths_slider_values[baths_slider_values.length - 1]) ? '--' : baths_slider_values[endValue];
                    if (idxboost_filter_countacti) {
                    $('#idx_min_baths').val(initialStartValue);
                    $('#idx_max_baths').val(initialEndValue);
                    $("#idx_page").val(1);
                    // do ajax
                    filter_refresh_search();
                    }
                }
            });
        }
        $('.property_type_checkbox').on('change', function() {
            var checked_items = $('.property_type_checkbox:checked');
            if (checked_items.length) {
                var checked_values = [];
                checked_items.each(function() {
                    checked_values.push($(this).val());
                });
                if (checked_values.length) {
                    $('#idx_property_type').val(checked_values.join("|"));
                }
            } else {
                $('#idx_property_type').val(property_type_values.join("|"));
            }
            // do ajax
            $("#idx_page").val(1);
            filter_refresh_search();
        });
        // setup parking
        flex_parking_switch = $('#flex_parking_switch');
        if (flex_parking_switch.length) {
            flex_parking_switch.on("change", function() {
                var _self = $(this);
                $('#idx_parking').val(_self.val());
                $("#idx_page").val(1);
                // do ajax
                filter_refresh_search();
            });
        }
        // setup waterfront
        flex_waterfront_switch = $('#flex_waterfront_switch');
        if (flex_waterfront_switch.length) {
            flex_waterfront_switch.on("change", function() {
                var _self = $(this);
                $('#idx_water_desc').val(_self.val());
                $("#idx_page").val(1);
                // do ajax
                filter_refresh_search();
            });
        }
        // setup amenities
        $('.amenities_checkbox').on('change', function() {
            var checked_items = $('.amenities_checkbox:checked');
            if (checked_items.length) {
                var checked_values = [];
                checked_items.each(function() {
                    checked_values.push($(this).val());
                });
                $('#idx_features').val(checked_values.join("|"));
            } else {
                $('#idx_features').val("");
            }
            $("#idx_page").val(1);
            // do ajax
            filter_refresh_search();
        });
        // setup switch rental type
        flex_search_rental_switch = $('.flex_search_rental_switch');
        if (flex_search_rental_switch.length) {
            flex_search_rental_switch.on('click', function() {
                var _self = $(this);
                if (_self.hasClass('active')) {
                    return;
                }
                flex_search_rental_switch.removeClass('active');
                _self.addClass('active');
                $('.price_ranges_ct').hide();
                var type = _self.attr('id');
                if (type == 'for-sale') { // for sale
                    $('.price_range_for_sale').show();
                    $('#idx_rental').val(0);
                } else if (type == 'for-rent') { // for rent
                    $('.price_range_for_rent').show();
                    $('#idx_rental').val(1);
                }
                // do ajax
                $("#idx_page").val(1);
                filter_refresh_search();
            });
        }
        if (beds_slider.length) {
            beds_slider.slider({
                range: true,
                min: 0,
                max: beds_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    console.log('From %s to %s', beds_slider_values[startValue], beds_slider_values[endValue]);
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_beds').val() === '--' ? beds_slider_values[0] : parseInt($('#idx_min_beds').val(), 10);
                    var max_val = $('#idx_max_beds').val() === '--' ? beds_slider_values[beds_slider_values.length - 1] : parseInt($('#idx_max_beds').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_beds').val() === '--' ? 0 : beds_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_beds').val() === '--' ? (beds_slider_values.length - 1) : beds_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    var min_lbl = beds_slider_values[ui.values[0]];
                    var max_lbl = beds_slider_values[ui.values[1]];

                    if (
                        ( (0 == min_lbl) && (6 == max_lbl) ) ||
                        ( (6 == min_lbl) && (6 == max_lbl) ) ||
                        ( (0 == min_lbl) && (0 == max_lbl) )
                    ) {
                        $('#text-beds').html(word_translate.any_beds);
                    } else {
                        if (max_lbl > 5) {
                            $('#text-beds').html(min_lbl + " - "+word_translate.any_beds);
                        } else {
                            $('#text-beds').html(min_lbl + " - " + max_lbl + " "+ word_translate.beds);
                        }
                    }

                    var initialStartValue = (beds_slider_values[startValue] == beds_slider_values[0]) ? '--' : beds_slider_values[startValue];
                    var initialEndValue = (beds_slider_values[endValue] == beds_slider_values[beds_slider_values.length - 1]) ? '--' : beds_slider_values[endValue];
                    if (idxboost_filter_countacti) {
                    $('#idx_min_beds').val(initialStartValue);
                    $('#idx_max_beds').val(initialEndValue);
                    $("#idx_page").val(1);
                    // do ajax
                    filter_refresh_search();
                    }
                }
            });
        }
        if (sqft_slider.length) {
            sqft_slider.slider({
                range: true,
                min: 0,
                max: sqft_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var min = sqft_slider_values[ui.values[0]];
                    var max = sqft_slider_values[ui.values[1]];

                    if ( (0 == min) || ("--" == min)) {
                        min = '0 '+word_translate.sqft;
                    } else {
                        min = _.formatPrice(min) + " "+word_translate.sqft;
                    }
                    
                    if ( (0 == max) || ("--" == max) || (80000==max) ) {
                        max = word_translate.any_size;
                    } else {
                        max = _.formatPrice(max) + " "+word_translate.sqft;
                    }

                    $('#living_from').val(min);
                    $('#living_to').val(max);
                    // flex_input_living_from_old_value = sqft_slider_values[startValue];
                    // flex_input_living_to_old_value = sqft_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_sqft').val() === '--' ? sqft_slider_values[0] : parseInt($('#idx_min_sqft').val(), 10);
                    var max_val = $('#idx_max_sqft').val() === '--' ? sqft_slider_values[sqft_slider_values.length - 1] : parseInt($('#idx_max_sqft').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_sqft').val() === '--' ? 0 : sqft_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_sqft').val() === '--' ? (sqft_slider_values.length - 1) : sqft_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);

                    var min = $('#idx_min_sqft').val();
                    var max = $('#idx_max_sqft').val();

                    if ( (0 == min) || ("--" == min)) {
                        min = '0 '+word_translate.sqft;
                    } else {
                        min = _.formatPrice(min) + " "+word_translate.sqft;
                    }
                    
                    if ( (0 == max) || ("--" == max) || (80000==max) ) {
                        max = word_translate.any_size;
                    } else {
                        max = _.formatPrice(max) + " "+word_translate.sqft;
                    }

                    $('#living_from').val(min);
                    $('#living_to').val(max);
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    var min = sqft_slider_values[ui.values[0]];
                    var max = sqft_slider_values[ui.values[1]];

                    if ( (0 == min) || ("--" == min)) {
                        min = '0 '+word_translate.sqft;
                    } else {
                        min = _.formatPrice(min) + " "+word_translate.sqft;
                    }
                    
                    if ( (0 == max) || ("--" == max) || (80000==max) ) {
                        max = word_translate.any_size;
                    } else {
                        max = _.formatPrice(max) + " "+word_translate.sqft;
                    }

                    $('#living_from').val(min);
                    $('#living_to').val(max);

                    if (idxboost_filter_countacti) {
                    $('#idx_min_sqft').val(sqft_slider_values[startValue]);
                    $('#idx_max_sqft').val(sqft_slider_values[endValue]);
                    $("#idx_page").val(1);
                    // do ajax
                    filter_refresh_search();
                    }
                }
            });
        }
        if (lotsize_slider.length) {
            lotsize_slider.slider({
                range: true,
                min: 0,
                max: lotsize_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var min = lotsize_slider_values[ui.values[0]];
                    var max = lotsize_slider_values[ui.values[1]];

                    if ( (0 == min) || ("--" == min)) {
                        min = '0 '+word_translate.sqft;
                    } else {
                        min = _.formatPrice(min) + " "+word_translate.sqft;
                    }
                    
                    if ( (0 == max) || ("--" == max) || (80000==max) ) {
                        max = word_translate.any_size;
                    } else {
                        max = _.formatPrice(max) + " "+word_translate.sqft;
                    }
                    $('#land_from').val(min);
                    $('#land_to').val(max);
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_lotsize').val() === '--' ? sqft_slider_values[0] : parseInt($('#idx_min_lotsize').val(), 10);
                    var max_val = $('#idx_max_lotsize').val() === '--' ? sqft_slider_values[sqft_slider_values.length - 1] : parseInt($('#idx_max_lotsize').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_lotsize').val() === '--' ? 0 : sqft_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_lotsize').val() === '--' ? (sqft_slider_values.length - 1) : sqft_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);


                    var min = $('#idx_min_lotsize').val();
                    var max = $('#idx_max_lotsize').val();

                    if ( (0 == min) || ("--" == min)) {
                        min = '0 '+word_translate.sqft;
                    } else {
                        min = _.formatPrice(min) + " "+word_translate.sqft;
                    }
                    
                    if ( (0 == max) || ("--" == max) || (80000==max) ) {
                        max = word_translate.any_size;
                    } else {
                        max = _.formatPrice(max) + " "+word_translate.sqft;
                    }
                    $('#land_from').val(min);
                    $('#land_to').val(max);
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    var min = lotsize_slider_values[ui.values[0]];
                    var max = lotsize_slider_values[ui.values[1]];

                    if ( (0 == min) || ("--" == min)) {
                        min = '0 '+word_translate.sqft;
                    } else {
                        min = _.formatPrice(min) + " "+word_translate.sqft;
                    }
                    
                    if ( (0 == max) || ("--" == max) || (80000==max) ) {
                        max = word_translate.any_size;
                    } else {
                        max = _.formatPrice(max) + " "+word_translate.sqft;
                    }
                    $('#land_from').val(min);
                    $('#land_to').val(max);

                    if (idxboost_filter_countacti) {
                    $('#idx_min_lotsize').val(lotsize_slider_values[startValue]);
                    $('#idx_max_lotsize').val(lotsize_slider_values[endValue]);
                    $("#idx_page").val(1);
                    // do ajax
                    filter_refresh_search();
                    }
                }
            });
        }
        if (year_built_slider.length) {
            year_built_slider.slider({
                range: true,
                min: 0,
                max: year_built_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#year_from').val(year_built_slider_values[startValue]);
                    $('#year_to').val(year_built_slider_values[endValue]);
                    // flex_input_year_min_old_value = year_built_slider_values[startValue];
                    // flex_input_year_max_old_value = year_built_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_year').val() === '--' ? year_built_slider_values[0] : parseInt($('#idx_min_year').val(), 10);
                    var max_val = $('#idx_max_year').val() === '--' ? year_built_slider_values[year_built_slider_values.length - 1] : parseInt($('#idx_max_year').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_year').val() === '--' ? 0 : year_built_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_year').val() === '--' ? (year_built_slider_values.length - 1) : year_built_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                    $('#year_from').val(min_val);
                    $('#year_to').val(max_val);
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    if (idxboost_filter_countacti) {
                    $('#idx_min_year').val(year_built_slider_values[startValue]);
                    $('#idx_max_year').val(year_built_slider_values[endValue]);
                    $("#idx_page").val(1);
                    // do ajax
                    filter_refresh_search();
                    }
                }
            });
        }
    });

var IB_SEARCH_FILTER;
IB_SEARCH_FILTER= $('#flex-idx-filter-form');

function saveFilterSearchForLead() {
    // IB_SEARCH_FILTER
    if (idxboost_force_registration){
        var search_url = location.href;
        var search_count = IB_SEARCH_FILTER.find("#search_count").val();
        var search_condition = IB_SEARCH_FILTER.find(".filter_condition").val();
        var search_name = filter_metadata.title;
        var search_filter_params = IB_SEARCH_FILTER.find(".filter_params_alert").val();
        var search_filter_ID = IB_SEARCH_FILTER.find("#filter_panel").val();

        if ("no" === __flex_g_settings.anonymous) {
            $.ajax({
                type: "POST",
                url: flex_idx_filter_params.saveListings.replace(/{{filterId}}/g, search_filter_ID),
                data: {
                    access_token: IB_ACCESS_TOKEN,
                    search_rk: flex_idx_filter_params.rk,
                    search_wp_web_id: flex_idx_filter_params.wp_web_id,                
                    flex_credentials: Cookies.get("ib_lead_token"),
                    search_filter_id: IB_SEARCH_FILTER.data("filter-id"),
                    search_url: search_url,
                    search_count: search_count,
                    search_condition: search_condition,
                    search_name: search_name,
                    search_params: search_filter_params
                },
                success: function(response) {
                    // console.log("The search filter has been saved successfully.");
                }
            });
        }
    }
}

window.saveFilterSearchForLead = saveFilterSearchForLead;


    //FIN_FORMULARIO
    var view_options;
    var sort_options;
    var FILTER_PAGE_URL;
    var FILTER_PAGE_CURRENT;
    $(function() {
        FILTER_PAGE_URL = $('#flex_idx_sort').data('permalink');
        FILTER_PAGE_CURRENT = $('#flex_idx_sort').data('currpage');
        view_options = $(".filter-views li");
        sort_options = $(".flex_idx_sort");
        if (view_options.length) {
            view_options.on("click", function() {
                currentfiltemid=$(this).attr('filtemid');

                if ($(this).hasClass("active")) {
                    return;
                }
                var current_view = $(this).html().toLowerCase();
                var current_sort = sort_options.val();
                // $("#nav-results a").each(function() {
                //     var _href = $(this).attr('href');
                //     _href = _href.replace(/\/view-(.*)\//, "/view-" + current_view + "/");
                //     $(this).attr("href", _href);
                // });
                // history.pushState(null, '', FILTER_PAGE_URL + "order-" + current_sort + "/view-" + current_view + "/page-" + FILTER_PAGE_CURRENT);
            });
        }
        if (sort_options.length) {
            sort_options.on("change", function() {
                currentfiltemid=$(this).attr('filtemid');

                var current_view = $('#filter-views li.active:eq(0)').html();
                var current_sort = $(this).val();
                // update hidden form
                $('.flex-idx-filter-form-'+currentfiltemid+' #idx_sort').val(current_sort);
                $('.flex-idx-filter-form-'+currentfiltemid+' #idx_page').val(1);
                // do ajax
                filter_refresh_search();
                // window.location.href = FILTER_PAGE_URL + "order-" + current_sort + "/view-" + current_view.toLowerCase() + "/page-1";
            });
        }
        flex_ui_loaded = true;
    });
})(jQuery);
(function($) {
    $(function() {
        if (typeof myLazyLoad === 'undefined') {
            myLazyLoad = new LazyLoad({
                elements_selector: ".flex-lazy-image",
                callback_load: function() {},
                callback_error: function(element){
                  $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                  $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
                }
            });
        }
        $(document).on("click", ".flex-slider-prev", function(event) {
            event.stopPropagation();
            var node = $(this).prev().find('li.flex-slider-current');
            var index = node.index();
            var total = $(this).prev().find('li').length;
            index = (index === 0) ? (total - 1) : (index - 1);
            $(this).prev().find('li').removeClass('flex-slider-current');
            $(this).prev().find('li').addClass('flex-slider-item-hidden');
            $(this).prev().find('li').eq(index).removeClass('flex-slider-item-hidden').addClass('flex-slider-current');
            myLazyLoad.update();

            // Open Registration popup after 3 property pictures are showed [force registration]
            if ("yes" === __flex_g_settings.anonymous) {
                console.log(idxboost_force_registration);
                if ( (typeof idxboost_force_registration !== "undefined") && (true === idxboost_force_registration) ) {
                    countClickAnonymous++;
            
                    if (countClickAnonymous >= 3) {
                        $("#modal_login").addClass("active_modal")
                        .find('[data-tab]').removeClass('active');
                
                        $("#modal_login").addClass("active_modal")
                            .find('[data-tab]:eq(1)')
                            .addClass('active');
                        
                        $("#modal_login")
                            .find(".item_tab")
                            .removeClass("active");
                        
                        $("#tabRegister")
                            .addClass("active");
            
                        $("button.close-modal").addClass("ib-close-mproperty");
                        $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
            
                        $("#modal_login h2").html($("#modal_login").find('[data-tab]:eq(1)').data("text-force"));
                        countClickAnonymous = 0;
                    }
                }
            }
        });
        $(document).on("click", ".flex-slider-next", function(event) {
            event.stopPropagation();
            var node = $(this).prev().prev().find('li.flex-slider-current');
            var index = node.index();
            var total = $(this).prev().prev().find('li').length;
            if (index >= (total - 1)) {
                index = 0;
            } else {
                index = index + 1;
            }
            // index = (index >= (total - 1)) ? 0 : (index + 1);
            $(this).prev().prev().find('li').removeClass('flex-slider-current');
            $(this).prev().prev().find('li').addClass('flex-slider-item-hidden');
            $(this).prev().prev().find('li').eq(index).removeClass('flex-slider-item-hidden').addClass('flex-slider-current');
            myLazyLoad.update();

            // Open Registration popup after 3 property pictures are showed [force registration]
            if ("yes" === __flex_g_settings.anonymous) {
                console.log(idxboost_force_registration);
                if ( (typeof idxboost_force_registration !== "undefined") && (true === idxboost_force_registration) ) {
                    countClickAnonymous++;
            
                    if (countClickAnonymous >= 3) {
                        $("#modal_login").addClass("active_modal")
                        .find('[data-tab]').removeClass('active');
                
                        $("#modal_login").addClass("active_modal")
                            .find('[data-tab]:eq(1)')
                            .addClass('active');
                        
                        $("#modal_login")
                            .find(".item_tab")
                            .removeClass("active");
                        
                        $("#tabRegister")
                            .addClass("active");
            
                        $("button.close-modal").addClass("ib-close-mproperty");
                        $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
            
                        $("#modal_login h2").html($("#modal_login").find('[data-tab]:eq(1)').data("text-force"));
                        countClickAnonymous = 0;
                    }
                }
            }
        });
    });
})(jQuery);

(function($){
    
    $('#save-button-responsive').on('click',function(){
        $('#filter-save-search').click();
    });

    $('body').on('click', '.ib-requestinfo',()=>{
        $('.ib-cffitem:first-child input').focus();
    });
}(jQuery));


(function($) {

$(function() {
    // dom ready
    $(window).on("popstate", function(event) {
        console.group("[popstate]");
        console.log(location.href);
        console.dir(event);
        console.groupEnd("[popstate]");

        if ($("#modal_login").is(":visible")) {
            $(".close").click();
        }

        $(".ib-pbtnclose").click();
    });
});

})(jQuery);