{include file="templates/header.tpl"}
	{capture name=back_url}{query_str full_request_uri=true ln=''}{/capture}

<!-- HOME HTML -->
<div class="big-map-wrapper">

        <div class="side-menu-wrapper">
          <div class="side-menu-title">
            <div class="side-menu-text">Обекти</div>
            <div class="side-menu-icon"></div>
          </div>

          <div class="colapsable-uls-hidden">
            <ul class="side-menu-ul">
              <li class="side-menu-ul-header-li">ВИДОВЕ ОБЕКТИ</li>

              <a href="" class="side-menu-ul-anchor">
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
              </a>
              
            </ul>

            <ul class="side-menu-ul">
              <li class="side-menu-ul-header-li">Исторически период</li>

              <a href="" class="side-menu-ul-anchor">
                <li class="side-menu-ul-white-li">
                  <span class="side-menu-ul-text">Турско робство</span>
                </li>
              </a>

              <a href="" class="side-menu-ul-anchor">
                <li class="side-menu-ul-white-li">
                  <span class="side-menu-ul-text-2">Възраждане</span>
                </li>
              </a>

              <a href="" class="side-menu-ul-anchor">
                <li class="side-menu-ul-white-li">
                  <span class="side-menu-ul-text-3">Началото на 20-ти век</span>
                </li>
              </a>

              <a href="" class="side-menu-ul-anchor">
                <li class="side-menu-ul-white-li">
                  <span class="side-menu-ul-text-4">Комунизъм</span>
                </li>
              </a>
              
            </ul>

            <ul class="side-menu-ul">
              <li class="side-menu-ul-header-li">населено място</li>

              <a href="" class="side-menu-ul-anchor">
                <li class="side-menu-ul-white-li">
                  <span class="side-menu-ul-text">Турско робство</span>
                </li>
              </a>

              <a href="" class="side-menu-ul-anchor">
                <li class="side-menu-ul-white-li">
                  <span class="side-menu-ul-text-2">Възраждане</span>
                </li>
              </a>

              <a href="" class="side-menu-ul-anchor">
                <li class="side-menu-ul-white-li">
                  <span class="side-menu-ul-text-3">Началото на 20-ти век</span>
                </li>
              </a>

              <a href="" class="side-menu-ul-anchor">
                <li class="side-menu-ul-white-li">
                  <span class="side-menu-ul-text-4">Комунизъм</span>
                </li>
              </a>
              
            </ul>
          </div>
        </div>

        <div class="map-popup">
          <img src="img/small-test-pic2.png" class="img-responsive popup-img">
          <h2 class="popup-h2">Наименование на артефакта</h3>
          <p class="popup-p1">Населено място</p>
          <p class="popup-p2">Вид обект</p>
          <p class="popup-p3">Исторически обект</p>
          <p class="popup-p4">Текст?...</p>
          <button class="popup-btn">Научи повече</button>
        </div>

        <div id="map"></div>

        {literal}
          <script>
            var map;

            function initMap() {
              map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 2
              });

              var bounds = new google.maps.LatLngBounds();
              // var mapOptions = {
              //     mapTypeId: 'roadmap'
              // };

              var markers = [
                ['London Eye, London', 51.503454,-0.119562],
                ['Palace of Westminster, London', 51.499633,-0.124755]
              ];

              var infoWindowContent = [
                ['<div class="info_content">' + '<h3>London Eye</h3>' +
                '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>'],

                ['<div class="info_content">' + '<h3>Palace of Westminster testttt</h3>' +
                '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
                '</div>']
              ];

              var infoWindow = new google.maps.InfoWindow(), marker, i;

              for( i = 0; i < markers.length; i++ ) {
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);

                bounds.extend(position);

                marker = new google.maps.Marker({
                  position: position,
                  map: map,
                  title: markers[i][0]
                });
                
                // Allow each marker to have an info window    
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                  return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                  }
                })(marker, i));

                // Automatically center the map fitting all markers on the screen
                map.fitBounds(bounds);
              }

              var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                this.setZoom(14);
                google.maps.event.removeListener(boundsListener);
              });

            }
          </script>
        {/literal}
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuAowcIG7dCf1xiE2wRehmCSfZ29dRy1A&callback=initMap" async defer></script>

        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4062.3559569188005!2d25.61438989906971!3d43.077158379987075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40a9214b3d9491dd%3A0x400a01269bf5dc0!2z0JLQtdC70LjQutC-INCi0YrRgNC90L7QstC-!5e0!3m2!1sbg!2sbg!4v1474533632666" width="100%" height="800px" frameborder="0" style="border:0" allowfullscreen></iframe> -->

      </div>

<!-- END HOME HTML -->
{include file="templates/footer.tpl"}