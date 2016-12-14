{include file="templates/header.tpl"}
	{capture name=back_url}{query_str full_request_uri=true ln=''}{/capture}

<!-- HOME HTML -->
<div class="main-wrapper">

      <div class="map-wrapper">

        <div class="inner-page-top-content-holder">
          <div class="inner-page-big-img">
		{if !isset($FILTER.museum.video_url)}
			<img src="../upload_images/treasure_picture_{$FILTER.museum.main_pic_id}.jpg" alt="" class="img-responsive cont-pic-3"/>
            		<!-- <img src="img/test-picture.png" class="img-responsive cont-pic-3"/>-->
		{else}
			<iframe width="100%" height="auto" src="{$FILTER.museum.video_url}" frameborder="0" allowfullscreen></iframe>
		{/if}
            <!-- <iframe width="100%" height="auto" src="https://www.youtube.com/embed/UMw3nEXTGBM" frameborder="0" allowfullscreen></iframe> -->
          </div>

          <div class="inner-page-text">
            <h2 class="inner-page-big-title">{$FILTER.museum.name}</h2>

            <h3 class="inner-page-smaller-title">{$FILTER.museum.area}</h3>

            <div class="location-wrapper">
              <div class="location-icon"></div>
              <div class="location-text">{$FILTER.museum.type}</div>
            </div>

            <p class="object-text">{$FILTER.museum.historical_period}</p>

            <div class="address-wrapper">
              <div class="inner-page-adress-holder">
                <span>Адрес:</span>
                <span>{$FILTER.museum.name}</span>
              </div>

              <div class="inner-page-time-holder">
                <span>Работно време:</span>
                <span>{$FILTER.museum.working_time}</span>
              </div>
            </div>

            <div class="social-icons">
              <a href="">
                <span class="social-icons-i1"></span>
              </a>

              <!-- <a href="">
                <span class="social-icons-i2"></span>
              </a> -->

              <!-- <a href="">
                <span class="social-icons-i3"></span>
              </a> -->

              <a href="">
                <span class="social-icons-i4"></span>
              </a>

              <!-- <a href="">
                <span class="social-icons-i5"></span>
              </a> -->
            </div>

          </div>
        </div>

        <p class="inner-page-p">{$FILTER.museum.description}</p>

        <h2 class="inner-page-h">Галерия</h2>
          {if $FILTER.museum.gallery}
  	        {foreach from=$FILTER.museum.gallery item=img}
          		<div class="inner-page-gallery-pic">
            			<a href="../upload_images/treasure_picture_{$img.picture_id}.jpg" data-lightbox="roadtrip">
            				<img src="../upload_images/treasure_picture_{$img.picture_id}.jpg" class="img-responsive cont-pic" alt="">
            			</a>
          		</div>
          	{/foreach}
          {/if}
	<!--
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
	-->
      </div>

      <h2 class="inner-page-h">Интересни места да посетиш в района</h2>

      <div class="overal-wrapper">
	{if isset($FILTER.museum.first_related_place)}
        <div class="small-section-wrapper">
          <div class="anchor-wrapper">
            <a href="{$FILTER.museum.first_related_place.link}" target="_blank">
  	  	      <img class="inner-page-small-pic" src="../upload_images/treasure_picture_{$FILTER.museum.first_related_place.picture_id}.jpg">
            	<h3 class="small-section-h">{$FILTER.museum.first_related_place.name}</h3>
            </a>
            <!-- <p class="small-section-p1">{$FILTER.museum.first_related_place.area}</p> -->
            <!-- <p class="small-section-p2">{$FILTER.museum.first_related_place.type}</p> -->
          </div>
          <p class="small-section-p4" id="suggestion-location1">{$FILTER.museum.first_related_place.description}</p>
          <button class="see-more-one">Виж повече</button>
        </div>
	{/if}
	{if isset($FILTER.museum.second_related_place)}
        <div class="small-section-wrapper">
          <div class="anchor-wrapper">
            <a href="{$FILTER.museum.second_related_place.link}" target="_blank">
  	  	      <img class="inner-page-small-pic" src="../upload_images/treasure_picture_{$FILTER.museum.second_related_place.picture_id}.jpg">
            	<h3 class="small-section-h">{$FILTER.museum.second_related_place.name}</h3>
            </a>
            <!-- <p class="small-section-p1">{$FILTER.museum.second_related_place.area}</p> -->
            <!-- <p class="small-section-p2">{$FILTER.museum.second_related_place.type}</p> -->
          </div>
          <p class="small-section-p4" id="suggestion-location2">{$FILTER.museum.second_related_place.description}</p>
          <button class="see-more-two">Виж повече</button>
        </div>
	{/if}
<!--        <div class="small-section-wrapper">
          <img class="inner-page-small-pic" src="img/small-test-pic2.png">
          <h3 class="small-section-h">Наименование на артефакта</h3>
          <p class="small-section-p1">Населено място</p>
          <p class="small-section-p2">Вид обект</p>
          <p class="small-section-p3">Исторически период</p>
          <p class="small-section-p4" id="suggestion-location2">Текст?</p>
        </div> -->
      </div>
    </div>

<!-- END HOME HTML -->
{include file="templates/footer.tpl"}