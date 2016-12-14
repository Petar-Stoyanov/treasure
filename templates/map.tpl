{include file="templates/header.tpl"}
	{capture name=back_url}{query_str full_request_uri=true ln=''}{/capture}

<div class="big-map-wrapper">

  <div class="side-menu-wrapper">
    <div class="side-menu-title">
      <div class="side-menu-text">Обекти</div>
      <div class="side-menu-icon"></div>
    </div>

    <div id="clear-filter" class="btn-default">ИЗЧИСТИ ФИЛТЪР</div>

    <div>
      <div class="side-menu-ul-header-li">ВИДОВЕ ОБЕКТИ</div>
      <ul class="side-menu-ul">
        <!-- <li class="side-menu-ul-header-li">ВИДОВЕ ОБЕКТИ</li> -->

        <!-- <a href="" class="side-menu-ul-anchor">
          <li class="side-menu-ul-white-li">
            <span class="side-menu-ul-i-1"></span>
            <span class="side-menu-ul-text">Читалище</span>
          </li>
        </a>

        <a href="" class="side-menu-ul-anchor">
          <li class="side-menu-ul-white-li">
            <span class="side-menu-ul-i-2"></span>
            <span class="side-menu-ul-text-2">Библиотека</span>
          </li>
        </a>

        <a href="" class="side-menu-ul-anchor">
          <li class="side-menu-ul-white-li">
            <span class="side-menu-ul-i-3"></span>
            <span class="side-menu-ul-text-3">Етнографска збирка</span>
          </li>
        </a>

        <a href="" class="side-menu-ul-anchor">
          <li class="side-menu-ul-white-li">
            <span class="side-menu-ul-i-4"></span>
            <span class="side-menu-ul-text-4">Музей</span>
          </li>
        </a> -->
        <input type="hidden" name="set-area" />
        <input type="hidden" name="set-type" />
        <input type="hidden" name="set-historical_period" />
        
        {counter start=0 skip=1 assign="count"}
        {foreach from=$FILTER.type item=type}
          <a class="side-menu-ul-anchor type-anchor" type="{$type.id}">
            <li class="side-menu-ul-white-li catch-li-click-1">
              <div class="side-bar-type-icon_{$type.id}"></div>
              <!-- <div class="side-menu-ul-text-4">{$type.id} - {$type.name}</div> -->
              <div class="side-menu-ul-text-4">{$type.name}</div>
            </li>
          </a>
          {counter}
        {/foreach}

        <!-- {counter start=0 skip=1 assign="count"}
        {foreach from=$FILTER.type item=type}
          <a class="side-menu-ul-anchor type-anchor" type="{$type.id}">
            <li class="side-menu-ul-white-li">
              <div class="side-bar-type-icon side-menu-ul-i-4"></div>
              <div class="side-menu-ul-text-4">{$type.id} - {$type.name}</div>
            </li>
          </a>
          {counter}
        {/foreach} -->
        
      </ul>

      <div class="side-menu-ul-header-li">Исторически период</div>

      <ul class="side-menu-ul">
        <!-- <li class="side-menu-ul-header-li">Исторически период</li> -->
        {counter start=0 skip=1 assign="count"}
        {foreach from=$FILTER.historical_period item=historical_period}
          <a class="side-menu-ul-anchor historical_period-anchor" historical_period="{$historical_period.id}">
            <li class="side-menu-ul-white-li catch-li-click-2">
              <span class="side-menu-ul-text-4">{$historical_period.name}</span>
            </li>
          </a> 
          {counter}
        {/foreach}
        
      </ul>

      <div class="side-menu-ul-header-li">населено място</div>

      <ul class="side-menu-ul">
        <!-- <li class="side-menu-ul-header-li">населено място</li> -->
        {counter start=0 skip=1 assign="count"}
        {foreach from=$FILTER.area item=area}
          <a class="side-menu-ul-anchor area-anchor" area="{$area.id}">
            <li class="side-menu-ul-white-li catch-li-click-3">
              <span class="side-menu-ul-text-4">{$area.name}</span>
            </li>
          </a> 
          {counter}
        {/foreach}
      </ul>
    </div>
  </div>

  <!-- <div class="map-popup">
    <img src="img/small-test-pic2.png" class="img-responsive popup-img">
    <h2 class="popup-h2">Наименование на артефакта</h3>
    <p class="popup-p1">Населено място</p>
    <p class="popup-p2">Вид обект</p>
    <p class="popup-p3">Исторически обект</p>
    <p class="popup-p4">Текст?...</p>
    <button class="popup-btn">Научи повече</button>
  </div> -->

  <div id="map"></div>

    {literal}
      <script>

        // add gray bg to the clicked li in the search menu
        $(document).on('click', ".catch-li-click-1", function() {
          $(".catch-li-click-1").removeClass("list-gray-bg");
          $(this).addClass("list-gray-bg");
        });

        $(document).on('click', ".catch-li-click-2", function() {
          $(".catch-li-click-2").removeClass("list-gray-bg");
          $(this).addClass("list-gray-bg");
        });

        $(document).on('click', ".catch-li-click-3", function() {
          $(".catch-li-click-3").removeClass("list-gray-bg");
          $(this).addClass("list-gray-bg");
        });

        var map;

        $('.type-anchor').click(function(){
          $("input[name='set-type']").val($(this).attr('type'));
          setAndChange(false);
        });

        $('.historical_period-anchor').click(function(){
          $("input[name='set-historical_period']").val($(this).attr('historical_period'));
          setAndChange(false);
        });

        $('.area-anchor').click(function(){
          $("input[name='set-area']").val($(this).attr('area'));
          setAndChange(false);
        });

        $('#clear-filter').click(function(){
          setAndChange(true);
        });

        var reqUrl = location.protocol + '//' + window.location.hostname + '/ajaxrequest.php';

        var markers = [];

        var infoWindowContent = [];

        $.ajax({
            url: reqUrl,
            success: function(result) {
              var rs = JSON.parse(result);
              $.each(rs, function(index, element) {
                var arr = [];
                arr.push(element.name);
                arr.push(element.x);
                arr.push(element.y);
                markers.push(arr);

                // var info = '<div class="info_content">';
                // info += '<h3>' + element.name + '</h3>';
                // info += '<p>' + element.description.substr(0, 200) + '<a class="btn btn-default" href="treasure/' + element.seo_url + '">'+ 'Научете повече' + '</a>' + '</p>';
                // info += '</div>';

                var info = '<div class="info_content map-popup">';

                  info += '<img src="./upload_images/treasure_picture_' + element.main_pic_id + '_cropped.jpg" class="img-responsive popup-img">';
                  
                  info += '<div class="pop-up-text-holder"';

                    info += '<h2 class="popup-h2">' + element.name + '</h2>';

                    info += '<p class="popup-p1">' + element.area + '</p>';
                    
                    info += '<p class="popup-p2">' + element.type + '</p>';
                    
                    info += '<p class="popup-p3">' + element.historical_period + '</p>';

                    info += '<p class="popup-p4">' + element.description.substr(0, 200) + '&nbsp;&nbsp;...' + '</p>';

                  info += '</div>';

                  info += '<a class="btn btn-default popup-btn" href="treasure/' + element.seo_url + '">'+ 'Научете повече' + '</a>';

                info += '</div>';

                var infoArr = [];
                infoArr.push(info);

                infoWindowContent.push(infoArr);
              });
            },
            error: function(error) {
              console.log(error);
            }
        }).then(function() {
          initMap(markers, infoWindowContent);
        });

        function setAndChange(filter) {

          var reqUrl = location.protocol + '//' + window.location.hostname;
          if(filter == true){
            reqUrl += '/ajaxrequest.php?mode=all';
            $.each($('.list-gray-bg'), function(){
              $(this).removeClass('list-gray-bg');
            });
          }else{
            reqUrl += '/ajaxrequest.php?mode=filter';
            
            if($("input[name='set-area']").val() != ""){
              reqUrl += "&area=" +  $("input[name='set-area']").val();
            }

            if($("input[name='set-type']").val() != ""){
              reqUrl += "&type=" +  $("input[name='set-type']").val();
            }

            if($("input[name='set-historical_period']").val() != "") {
              reqUrl += "&historical_period=" +  $("input[name='set-historical_period']").val();
            }
          }
          

          var markers = [];
          var infoWindowContent = [];
          $.ajax({
              url: reqUrl,
              success: function(result){
                var rs = JSON.parse(result);

                $.each(rs, function(index, element){
                  var arr = [];
                  arr.push(element.name);
                  arr.push(element.x);
                  arr.push(element.y);
                  markers.push(arr);

                  // var info = '<div class="info_content">';
                  // info += '<h3>' + element.name + '</h3>';
                  // info += '<p>' + element.description.substr(0, 200) + '<a class="btn btn-default" href="treasure/' + element.seo_url + '">'+ 'Научете повече' + '</a>' + '</p>';
                  // info += '</div>';

                  var info = '<div class="info_content map-popup">';

                  info += '<img src="./upload_images/treasure_picture_' + element.main_pic_id + '_cropped.jpg" class="img-responsive popup-img">';

                  info += '<h2 class="popup-h2">' + element.name + '</h2>';

                  info += '<p class="popup-p1">' + element.area + '</p>';
                  
                  info += '<p class="popup-p2">' + element.type + '</p>';
                  
                  info += '<p class="popup-p3">' + element.historical_period + '</p>';

                  info += '<p class="popup-p4">' + element.description.substr(0, 200) + '&nbsp;&nbsp;...' + '</p>';

                  info += '<a class="btn btn-default popup-btn" href="treasure/' + element.seo_url + '">'+ 'Научете повече' + '</a>';

                  info += '</div>';

                  var infoArr = [];
                  infoArr.push(info);

                  infoWindowContent.push(infoArr);
                });
              },
              error: function(error){
                console.log(error);
              }
          }).then(function(){
            initMap(markers, infoWindowContent);
          });
        }

        function initMap(markers, infoWindowContent) {
          map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 43.074283, lng: 25.608478},
            zoom: 9,
            zoomControl: true,
            zoomControlOptions: {
              position: google.maps.ControlPosition.LEFT_CENTER
            }
          });

          var bounds = new google.maps.LatLngBounds();
          // var mapOptions = {
          //     mapTypeId: 'roadmap'
          // };

          var infoWindow = new google.maps.InfoWindow(), marker, i;

          var icons = {
            chitalishte: {
              icon: 'img/small-building.png'
            },
            ethnoGathering: {
              icon: 'img/gathering.png'
            },
            museum: {
              icon: 'img/museum.png'
            },
            library: {
              icon: 'img/library.png'
            }
          }

          for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);

            bounds.extend(position);

            marker = new google.maps.Marker({
              position: position,
              map: map,
              animation: google.maps.Animation.DROP,
              title: markers[i][0]
              // icon: icons[features.type].icon
            });

            // var features = [
            //   {
            //     // position: position,
            //     type: 'chitalishte'
            //   }, {
            //     // position: position,
            //     type: 'ethnoGathering'
            //   }, {
            //     // position: position,
            //     type: 'museum'
            //   }, {
            //     // position: position,
            //     type: 'library'
            //   }
            // ];

            // for (var i = 0, feature; feature = features[i]; i++) {
            //   addMarker(feature);
            // };

            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
              }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            // map.fitBounds(bounds);
          }

          var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(9);
            google.maps.event.removeListener(boundsListener);
          });
        }
      </script>
    {/literal}
    
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuAowcIG7dCf1xiE2wRehmCSfZ29dRy1A&callback=initMap" async defer></script> -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuAowcIG7dCf1xiE2wRehmCSfZ29dRy1A&callback=initMap" async defer></script>

    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4062.3559569188005!2d25.61438989906971!3d43.077158379987075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40a9214b3d9491dd%3A0x400a01269bf5dc0!2z0JLQtdC70LjQutC-INCi0YrRgNC90L7QstC-!5e0!3m2!1sbg!2sbg!4v1474533632666" width="100%" height="800px" frameborder="0" style="border:0" allowfullscreen></iframe> -->

  </div>

<!-- END MAP HTML -->
{include file="templates/footer.tpl"}