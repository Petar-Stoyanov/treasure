{include file="templates/header.tpl"}
	{capture name=back_url}{query_str full_request_uri=true ln=''}{/capture}

    <nav>
      <a href="http://www.findatreasure.eu/about-the-project.php" class="nav-a">За проекта</a>
      <a href="http://www.findatreasure.eu/team.php" class="nav-a">Екип</a>
      <a href="http://www.findatreasure.eu/followers.php" class="nav-a">Съмишленици</a>
      <a href="http://www.findatreasure.eu/support-the-cause.php" class="nav-a">Подкрепи каузата</a>
    </nav>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        {counter start=0 skip=1 assign="count"}
        {foreach from=$FILTER.slider item=slide}
          {if $count eq 0}
            <li data-target="#myCarousel" data-slide-to="{$count}" class="active"></li>
          {else}
            <li data-target="#myCarousel" data-slide-to="{$count}"></li>
          {/if}
          {counter}
        {/foreach}
        <!--
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        -->
      </ol>

      <div class="carousel-inner" role="listbox">
        {counter start=0 skip=1 assign="count"}
        {foreach from=$FILTER.slider item=slide}
          <div class="item {if $count eq 0}active{/if}">
            <img src="/image.php?mode=get&fl=banner&size=original&id={$slide.picture_id}" alt="" />
		
          </div>
        {counter}
        {/foreach}

        <!--
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
        -->
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

        <div id="freewall" class="free-wall">

          <div class="brick size11">
            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4062.3559569188005!2d25.61438989906971!3d43.077158379987075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40a9214b3d9491dd%3A0x400a01269bf5dc0!2z0JLQtdC70LjQutC-INCi0YrRgNC90L7QstC-!5e0!3m2!1sbg!2sbg!4v1474533632666" width="100%" height="450px" frameborder="0" style="border:0" allowfullscreen></iframe> -->
            <a href="http://www.findatreasure.eu/map.php" class="map-text-a">
              <img src="img/map-screen-shot.png">

              <div class="map-text">
                  <div class="map-text-inner">Потърси обект на картата</div>
                  <div class="map-icon"></div>
              </div>
            </a>
            
          </div>
          
          {foreach from=$FILTER.museums item=museum}

          <div class="brick size21">
           <!-- treasure/{$museum.name} -->
            <a href="/treasure/{$museum.seo_url}">
              <!-- {*<img src="/image.php?mode=get&fl=museum_main_pic&size=small&id={$museum.id}" class="img-responsive cont-pic" alt="">*} -->

		          <img src="./upload_images/treasure_picture_{$museum.main_pic_id}_cropped.jpg" class="img-responsive cont-pic" alt="" style="width:155px;"/>
            </a>

            <div class="article-text-holder">
              <h4 class="inner-h">{$museum.name}</h4>
              <p class="inner-p-1">{$museum.area}</p>
              <p class="inner-p-2">{$museum.type}</p>
              <p class="inner-p-2">{$museum.historical_period}</p>
            </div>
          </div>

        {/foreach}

        <!-- <div class="grid-item grid-item--width4">
          <a href="">
            <img src="img/bigger-pic.png" class="img-responsive cont-pic-2" alt="">
          </a>
          <h4 class="inner-h">asdas</h4>
          <p class="inner-p-1">asd</p>
          <p class="inner-p-2">sds</p>
        </div> -->

        </div>

        <button class="load-more">
          <span class="load-more-text">ЗАРЕДИ ОЩЕ</span>
          <span class="load-more-icon"></span>
        </button>

        <!-- <div class="lower-section-wrapper">
          <a href="" class="lower-section-a">Партньори</a>
          <div>
            <span class="lower-section-icon-1"></span>
            <span class="lower-section-icon-2"></span>
            <span class="lower-section-icon-3"></span>
            <span class="lower-section-icon-4"></span>
            <span class="lower-section-icon-5"></span>
          </div>
        </div> -->
      </div>
    </div>

<!-- END HOME HTML -->
{include file="templates/footer.tpl"}