<?php require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/function.query_str.php'); $this->register_function("query_str", "tpl_function_query_str");  require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/block.capture.php'); $this->register_block("capture", "tpl_block_capture");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-22 11:42:12 EEST */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("templates/header.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<?php $this->_tag_stack[] = array('tpl_block_capture', array('name' => back_url)); tpl_block_capture(array('name' => back_url), null, $this); ob_start();  echo tpl_function_query_str(array('full_request_uri' => true,'ln' => ''), $this); $this->_block_content = ob_get_contents(); ob_end_clean(); $this->_block_content = tpl_block_capture($this->_tag_stack[count($this->_tag_stack) - 1][1], $this->_block_content, $this); echo $this->_block_content; array_pop($this->_tag_stack); ?>

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

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4062.3559569188005!2d25.61438989906971!3d43.077158379987075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40a9214b3d9491dd%3A0x400a01269bf5dc0!2z0JLQtdC70LjQutC-INCi0YrRgNC90L7QstC-!5e0!3m2!1sbg!2sbg!4v1474533632666" width="100%" height="800px%" frameborder="0" style="border:0" allowfullscreen></iframe>

      </div>

<!-- END HOME HTML -->
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("templates/footer.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>