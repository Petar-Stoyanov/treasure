<?php require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/function.query_str.php'); $this->register_function("query_str", "tpl_function_query_str");  require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/block.capture.php'); $this->register_block("capture", "tpl_block_capture");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-16 12:22:29 EEST */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("templates/header.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<?php $this->_tag_stack[] = array('tpl_block_capture', array('name' => back_url)); tpl_block_capture(array('name' => back_url), null, $this); ob_start();  echo tpl_function_query_str(array('full_request_uri' => true,'ln' => ''), $this); $this->_block_content = ob_get_contents(); ob_end_clean(); $this->_block_content = tpl_block_capture($this->_tag_stack[count($this->_tag_stack) - 1][1], $this->_block_content, $this); echo $this->_block_content; array_pop($this->_tag_stack); ?>

<!-- HOME HTML -->

    <nav>
      <a href="" class="nav-a">За проекта</a>
      <a href="" class="nav-a">Екип</a>
      <a href="" class="nav-a">Съмишленици</a>
      <a href="" class="nav-a">Подкрепи каузата</a>
      <a href="" class="nav-a">Контакти</a>
    </nav>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350%C3%97150&w=1650&h=350" alt="">
        </div>

        <div class="item">
          <img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350%C3%97150&w=1650&h=350" alt="">
        </div>

        <div class="item">
          <img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350%C3%97150&w=1650&h=350" alt="">
        </div>

        <div class="item">
          <img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350%C3%97150&w=1650&h=350" alt="">
        </div>
      </div>

      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left modified-arrow-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right modified-arrow-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <div class="main-wrapper">

      <div class="map-wrapper">
        <div class="grid">
          <div class="grid-item grid-item--width2">
            <a href="">
              <img src="img/cont-pic.png" alt="">
            </a>
            <h4 class="inner-h">asdas</h4>
            <p class="inner-p-1">asd</p>
            <p class="inner-p-2">sds</p>
          </div>

          <div class="grid-item grid-item--width2">
            <a href="">
              <img src="img/cont-pic.png" alt="">
            </a>
            <h4 class="inner-h">asdas</h4>
            <p class="inner-p-1">asd</p>
            <p class="inner-p-2">sds</p>
          </div>

          <div class="grid-item grid-item--width2">
            <a href="">
              <img src="img/cont-pic.png" alt="">
            </a>
            <h4 class="inner-h">asdas</h4>
            <p class="inner-p-1">asd</p>
            <p class="inner-p-2">sds</p>
          </div>

          <div class="grid-item grid-item--width3">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2933.4993014682145!2d23.393845514909447!3d42.671964723340494!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40aa866bf688b389%3A0x7fde23760601550e!2z0LHRg9C7LiDigJ7QmNGB0LrRitGA0YHQutC-INGI0L7RgdC14oCcIDcsIDE1Mjgg0KHQvtGE0LjRjw!5e0!3m2!1sbg!2sbg!4v1455800730705" width="100%" height="505" frameborder="0" style="border:0" allowfullscreen></iframe>
            <div class="map-text">
              <a href="" class="map-text-a">
                <span class="map-text-inner">Потърси обект на картата</span>
                <span class="map-icon"></span>
              </a>
            </div>
          </div>
          <div class="grid-item grid-item--width2">
            <a href="">
              <img src="img/cont-pic.png" alt="">
            </a>
            <h4 class="inner-h">asdas</h4>
            <p class="inner-p-1">asd</p>
            <p class="inner-p-2">sds</p>
          </div>
        </div>

        <button class="load-more">
          <span class="load-more-text">ЗАРЕДИ ОЩЕ</span>
          <span class="load-more-icon"></span>
        </button>

        <div class="lower-section-wrapper">
          <a href="" class="lower-section-a">Партньори</a>
          <div>
            <span class="lower-section-icon-1"></span>
            <span class="lower-section-icon-2"></span>
            <span class="lower-section-icon-3"></span>
            <span class="lower-section-icon-4"></span>
            <span class="lower-section-icon-5"></span>
          </div>
        </div>
      </div>
    </div>

<!-- END HOME HTML -->
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("templates/footer.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>