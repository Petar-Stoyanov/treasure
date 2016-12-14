{include file="templates/header.tpl"}
	{capture name=back_url}{query_str full_request_uri=true ln=''}{/capture}
<nav>
  <a href="http://www.findatreasure.eu/about-the-project.php" class="nav-a">За проекта</a>
  <a href="http://www.findatreasure.eu/team.php" class="nav-a">Екип</a>
  <a href="http://www.findatreasure.eu/followers.php" class="nav-a">Съмишленици</a>
  <a href="http://www.findatreasure.eu/support-the-cause.php" class="nav-a">Подкрепи каузата</a>
</nav>

<div class="static-pages-picture-title">
  <h2 class="static-pages-picture-title-text">Съмишленици</h2>
  <img class="tatic-pages-picture-title-img" src="img/staticpg.jpg">
  <div class="static-pages-picture-title-picture-overlay"></div>
</div>

<div class="main-wrapper">
  <section class="static-page-section-content">
    followers
  </section>
</div>

{include file="templates/footer.tpl"}