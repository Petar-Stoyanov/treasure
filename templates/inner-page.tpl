{include file="templates/header.tpl"}
	{capture name=back_url}{query_str full_request_uri=true ln=''}{/capture}

<!-- HOME HTML -->
<div class="main-wrapper">

      <div class="map-wrapper">
<<<<<<< HEAD

          <div class="inner-page-big-img">
            <img src="img/test-picture.png" class="img-responsive cont-pic-3">

            <iframe width="100%" height="auto" src="https://www.youtube.com/embed/UMw3nEXTGBM" frameborder="0" allowfullscreen></iframe>
          </div>

          <div class="inner-page-text">
            <h2 class="inner-page-big-title">Наименование на артефакта</h2>
=======
        <div class="grid grid-2">
          <div class="grid-item grid-item--width5">
           <!-- video url -->
           <img src="/image.php?mode=get&fl=museum_main_pic&size=small&id={$FILTER.museum.id}" class="img-responsive cont-pic-3" alt="">

            <!-- <img src="/img/test-picture.png" class="img-responsive cont-pic-3"> -->
          </div>

          <div class="grid-item grid-item--width6">
            <h2 class="inner-page-big-title">{$FILTER.museum.name}</h2>
>>>>>>> origin/master

            <h3 class="inner-page-smaller-title">$FILTER.museum.area</h3>

            <div class="location-wrapper">
              <div class="location-icon"></div>
              <div class="location-text">{$FILTER.museum.type}</div>
            </div>

            <p class="object-text">Исторически обект</p>

            <div class="address-wrapper">
              <span>Адрес:</span>
              <span>{$FILTER.museum.address}</span>
              <span>Работно време:</span>
              <span>{$FILTER.museum.working_time}</span>
            </div>

            <div class="social-icons">
              <span class="social-icons-i1"></span>
              <span class="social-icons-i2"></span>
              <span class="social-icons-i3"></span>
              <span class="social-icons-i4"></span>
              <span class="social-icons-i5"></span>
            </div>

            <p class="inner-page-p">{$FILTER.museum.description}</p>

          </div>

<<<<<<< HEAD
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
=======
          <div class="grid-item grid-item--width2">
            <div class="grid-item grid-item--width2">
              <a href="">
                <img src="/img/cont-pic.png" class="img-responsive cont-pic" alt="">
              </a>
              <h4 class="inner-h">asdas</h4>
              <p class="inner-p-1">asd</p>
              <p class="inner-p-2">sds</p>
            </div>
          </div>

          <div class="grid-item grid-item--width3">
            <div class="grid-item grid-item--width2">
              <a href="">
                <img src="/img/cont-pic.png" class="img-responsive cont-pic" alt="">
              </a>
              <h4 class="inner-h">asdas</h4>
              <p class="inner-p-1">asd</p>
              <p class="inner-p-2">sds</p>
            </div>
          </div>

          <div class="grid-item grid-item--width2">
            <div class="grid-item grid-item--width2">
              <a href="">
                <img src="/img/cont-pic.png" class="img-responsive cont-pic" alt="">
              </a>
              <h4 class="inner-h">asdas</h4>
              <p class="inner-p-1">asd</p>
              <p class="inner-p-2">sds</p>
            </div>
>>>>>>> origin/master
          </div>

          <div class="inner-page-gallery-pic">
            <a href="">
              <img src="img/cont-pic.png" class="img-responsive cont-pic" alt="">
            </a>
          </div>

<<<<<<< HEAD
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

=======
      <div class="small-section-wrapper">
        <img class="inner-page-small-pic" src="/img/small-test-pic1.png">
        <h3 class="small-section-h">Наименование на артефакта</h3>
        <p class="small-section-p1">Населено място</p>
        <p class="small-section-p2">Вид обект</p>
        <p class="small-section-p3">Исторически период</p>
        <p class="small-section-p4">Текст?.........</p>
      </div>

      <div class="small-section-wrapper">
        <img class="inner-page-small-pic" src="/img/small-test-pic2.png">
        <h3 class="small-section-h">Наименование на артефакта</h3>
        <p class="small-section-p1">Населено място</p>
        <p class="small-section-p2">Вид обект</p>
        <p class="small-section-p3">Исторически период</p>
        <p class="small-section-p4">Текст?.........</p>
>>>>>>> origin/master
      </div>

      <h2 class="inner-page-h">Интересни места да посетиш в района</h2>

      <!-- <div class="overal-wrapper"> -->
        <div class="small-section-wrapper">
          <img class="inner-page-small-pic" src="img/small-test-pic1.png">
          <h3 class="small-section-h">Наименование на артефакта</h3>
          <p class="small-section-p1">Населено място</p>
          <p class="small-section-p2">Вид обект</p>
          <p class="small-section-p3">Исторически период</p>
          <p class="small-section-p4">Текст?.........</p>
        </div>

        <div class="small-section-wrapper">
          <img class="inner-page-small-pic" src="img/small-test-pic2.png">
          <h3 class="small-section-h">Наименование на артефакта</h3>
          <p class="small-section-p1">Населено място</p>
          <p class="small-section-p2">Вид обект</p>
          <p class="small-section-p3">Исторически период</p>
          <p class="small-section-p4">Текст?.........</p>
        </div>
      <!-- </div> -->
    </div>

<!-- END HOME HTML -->
{include file="templates/footer.tpl"}