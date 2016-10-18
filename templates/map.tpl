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

        <div id="map"></div>

        {literal}
          <script>
            var map;
            function initMap() {
              map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
              });
            }
          </script>
        {/literal}
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuAowcIG7dCf1xiE2wRehmCSfZ29dRy1A&callback=initMap" async defer></script>

        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4062.3559569188005!2d25.61438989906971!3d43.077158379987075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40a9214b3d9491dd%3A0x400a01269bf5dc0!2z0JLQtdC70LjQutC-INCi0YrRgNC90L7QstC-!5e0!3m2!1sbg!2sbg!4v1474533632666" width="100%" height="800px" frameborder="0" style="border:0" allowfullscreen></iframe> -->

      </div>

<!-- END HOME HTML -->
{include file="templates/footer.tpl"}