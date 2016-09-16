<?php require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/function.query_str.php'); $this->register_function("query_str", "tpl_function_query_str");  require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/block.capture.php'); $this->register_block("capture", "tpl_block_capture");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-16 12:54:44 EEST */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("templates/header.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<?php $this->_tag_stack[] = array('tpl_block_capture', array('name' => back_url)); tpl_block_capture(array('name' => back_url), null, $this); ob_start();  echo tpl_function_query_str(array('full_request_uri' => true,'ln' => ''), $this); $this->_block_content = ob_get_contents(); ob_end_clean(); $this->_block_content = tpl_block_capture($this->_tag_stack[count($this->_tag_stack) - 1][1], $this->_block_content, $this); echo $this->_block_content; array_pop($this->_tag_stack); ?>

<!-- HOME HTML -->
<div class="main-wrapper">

      <div class="map-wrapper">
        <div class="grid">
          <div class="grid-item grid-item--width5">
            <img src="img/test-picture.png">
          </div>

          <div class="grid-item grid-item--width6">
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
              <span class="social-icons-i1"></span>
              <span class="social-icons-i2"></span>
              <span class="social-icons-i3"></span>
              <span class="social-icons-i4"></span>
              <span class="social-icons-i5"></span>
            </div>

            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.

            Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, </p>

          </div>

          <div class="grid-item grid-item--width2">
            asd
          </div>

          <div class="grid-item grid-item--width3">
            asd
          </div>
          <div class="grid-item grid-item--width2">
            asd
          </div>
        </div>
      </div>

      <!-- afafaf -->
      <h2 class="inner-page-h">Интересни места да посетиш в района</h2>

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

    </div>

<!-- END HOME HTML -->
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("templates/footer.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>