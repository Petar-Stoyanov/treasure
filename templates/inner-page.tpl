{include file="templates/header.tpl"}
	{capture name=back_url}{query_str full_request_uri=true ln=''}{/capture}

<!-- HOME HTML -->
<div class="main-wrapper">

      <div class="map-wrapper">

        <div class="inner-page-top-content-holder">
          <div class="inner-page-big-img">
            <img src="img/test-picture.png" class="img-responsive cont-pic-3">

            <!-- <iframe width="100%" height="auto" src="https://www.youtube.com/embed/UMw3nEXTGBM" frameborder="0" allowfullscreen></iframe> -->
          </div>

          <div class="inner-page-text">
            <h2 class="inner-page-big-title">Наименование на артефакта</h2>

            <h3 class="inner-page-smaller-title">Населено място</h3>

            <div class="location-wrapper">
              <div class="location-icon"></div>
              <div class="location-text">Вид обект</div>
            </div>

            <p class="object-text">Исторически обект</p>

            <div class="address-wrapper">
              <span>Адрес:</span>
              <span>address text</span>
              <span>Работно време:</span>
              <span>time text</span>
            </div>

            <div class="social-icons">
              <a href="">
                <span class="social-icons-i1"></span>
              </a>

              <a href="">
                <span class="social-icons-i2"></span>
              </a>

              <a href="">
                <span class="social-icons-i3"></span>
              </a>

              <a href="">
                <span class="social-icons-i4"></span>
              </a>

              <a href="">
                <span class="social-icons-i5"></span>
              </a>
            </div>

          </div>
        </div>

        <p class="inner-page-p">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.

        Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, </p>

        <h2 class="inner-page-h">Галерия</h2>

        <div class="inner-page-gallery-pic">
          <a href="">
            <img src="img/cont-pic.png" class="img-responsive cont-pic" alt="">
          </a>
        </div>

        <div class="inner-page-gallery-pic">
          <a href="">
            <img src="img/cont-pic.png" class="img-responsive cont-pic" alt="">
          </a>
        </div>

        <div class="inner-page-gallery-pic">
          <a href="">
            <img src="img/cont-pic.png" class="img-responsive cont-pic" alt="">
          </a>
        </div>

        <div class="inner-page-gallery-pic">
          <a href="">
            <img src="img/cont-pic.png" class="img-responsive cont-pic" alt="">
          </a>
        </div>

        <div class="inner-page-gallery-pic">
          <a href="">
            <img src="img/cont-pic.png" class="img-responsive cont-pic" alt="">
          </a>
        </div>

        <div class="inner-page-gallery-pic">
          <a href="">
            <img src="img/cont-pic.png" class="img-responsive cont-pic" alt="">
          </a>
        </div>

      </div>

      <h2 class="inner-page-h">Интересни места да посетиш в района</h2>

      <div class="overal-wrapper">
        <div class="small-section-wrapper">
          <img class="inner-page-small-pic" src="img/small-test-pic1.png">
          <h3 class="small-section-h">Наименование на артефакта</h3>
          <p class="small-section-p1">Населено място</p>
          <p class="small-section-p2">Вид обект</p>
          <p class="small-section-p3">Исторически период</p>
          <p class="small-section-p4" id="suggestion-location1">adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs adsgasgs</p>
        </div>

        <div class="small-section-wrapper">
          <img class="inner-page-small-pic" src="img/small-test-pic2.png">
          <h3 class="small-section-h">Наименование на артефакта</h3>
          <p class="small-section-p1">Населено място</p>
          <p class="small-section-p2">Вид обект</p>
          <p class="small-section-p3">Исторически период</p>
          <p class="small-section-p4" id="suggestion-location2">Текст?</p>
        </div>
      </div>
    </div>

<!-- END HOME HTML -->
{include file="templates/footer.tpl"}