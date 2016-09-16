{include file="templates/header.tpl"
	css1="css/library.css"
	js1="js/ckeditor/ckeditor.js"
	js2="js/ckeditor/adapters/jquery.js"
	js3="js/ajaxfileupload.js"
}
<div class="inner{if not $side_menu}Full{/if}">
	<!--[if !IE]>start section<![endif]-->	
	<div class="section">
		<!--[if !IE]>start title wrapper<![endif]-->
		<div class="title_wrapper">
			<h2>Редактирай {$FILTER.title}</h2>
			<span class="title_wrapper_left"></span>
			<span class="title_wrapper_right"></span>
		</div>
		{ math equation="(x + 1)" x=1 assign='x' }
		<!--[if !IE]>end title wrapper<![endif]-->
		<!--[if !IE]>start section content<![endif]-->
		<div class="section_content">
			<!--[if !IE]>start section content top<![endif]-->
			<div class="sct">
				<div class="sct_left">
					<div class="sct_right">
						<div class="sct_left">
							<div class="sct_right">
								
								<!--[if !IE]>start forms<![endif]-->
								<form method="post" class="search_form general_form" id="libFrm" enctype="multipart/form-data">
									<input type="hidden" name="id" id="id" value="{$FILTER.id}"/>
									<input type="hidden" name="type" id="type" value="{$FILTER.type}"/>
									<!--[if !IE]>start fieldset<![endif]-->
									<fieldset>
										<!--[if !IE]>start forms<![endif]-->
										<div class="forms">
											{if $FILTER.id==11 || $FILTER.id==12}
												<!--[if !IE]>start row<![endif]-->
												<div class="row">
													<label>Снимка:</label>
													<div class="inputs">
														<span class="input_wrapper blank"><input id="cv" type="file" size="16" name="cv" class="input"></span>
														{if $FILTER.id>0}
															<span class="button light_blue_btn"><span><span>Качи</span></span><input type="submit" id="buttonUpload" onclick="return ajaxFileUpload('cv');"></span>
															<img id="loading" src="images/loading.gif" style="display:none;">
														{/if}
													</div>
													
												</div>
												<!--[if !IE]>end row<![endif]-->
												<!--[if !IE]>end row<![endif]-->
												{if !empty($FILTER.cvphoto)}
													<!--[if !IE]>start row<![endif]-->
													<div class="row">
														<label>&nbsp;</label>
														<img src="{$FILTER.cvphoto}" alt="CV photo" />
														<span style="width: 30px;vertical-align:top;">
															<a href="del_image.php?mode=stat_page&type=stat_page&id={$FILTER.id}&field=cv&back_url=library%2Ephp%3Fmode%3Dedit%26type%3D{$FILTER.type}%26id%3D{$FILTER.id}%26e%3D{$FILTER.e}" title="изтрий"><img src="css/layout/site/tables/action4.gif" style="border:0"></a>
														</span>
													</div>
													<!--[if !IE]>end row<![endif]-->
												{/if}
											{/if}
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<label>Текст БГ:</label>
												<div class="inputs">
													<span class="input_wrapper blank">
														<textarea rows="" cols="" class="text" name="text_bg" id="text_bg">{$FILTER.text_bg}</textarea>
													</span>
													{if $errs.text_bg}<span class="system negative">{$errs.text_bg}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<label>Текст EN:</label>
												<div class="inputs">
													<span class="input_wrapper blank">
														<textarea rows="" cols="" class="text" name="text_en" id="text_en">{$FILTER.text_en}</textarea>
													</span>
													{if $errs.text_en}<span class="system negative">{$errs.text_en}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<label>Текст RO:</label>
												<div class="inputs">
													<span class="input_wrapper blank">
														<textarea rows="" cols="" class="text" name="text_ro" id="text_ro">{$FILTER.text_ro}</textarea>
													</span>
													{if $errs.text_ro}<span class="system negative">{$errs.text_ro}</span>{/if}
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
											
											<!--[if !IE]>start row<![endif]-->
											<div class="row">
												<div class="buttons">
													<ul>
														<li><span class="button send_form_btn"><span><span>Запази</span></span><input name="" type="submit" /></span></li>
														<li><span class="button cancel_btn"><a href="{query_str id=null mode=null}"><span><span>CANCEL</span></span></a></span></li>
													</ul>
												</div>
											</div>
											<!--[if !IE]>end row<![endif]-->
										</div>
										<!--[if !IE]>end forms<![endif]-->
										
									</fieldset>
									<!--[if !IE]>end fieldset<![endif]-->
								</form>
								<!--[if !IE]>end forms<![endif]-->	
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--[if !IE]>end section content top<![endif]-->
			<!--[if !IE]>start section content bottom<![endif]-->
			<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
			<!--[if !IE]>end section content bottom<![endif]-->
			
		</div>
		<!--[if !IE]>end section content<![endif]-->
	</div>
	<!--[if !IE]>end section<![endif]-->
	<script type="text/javascript">
	{literal}
		$(function(){ // jQuery DOM ready function. 
			$( 'textarea#text_bg' ).parent().css('width', '90%').parent().css('width', '90%');
		    $( 'textarea#text_bg' ).ckeditor();
		    $( 'textarea#text_en' ).parent().css('width', '90%').parent().css('width', '90%');
		    $( 'textarea#text_en' ).ckeditor();
		    $( 'textarea#text_ro' ).parent().css('width', '90%').parent().css('width', '90%');
		    $( 'textarea#text_ro' ).ckeditor();
		});
		
		function ajaxFileUpload(fileelemid) {
			$("#loading")
			.ajaxStart(function(){
				$(this).show();
			})
			.ajaxComplete(function(){
				$(this).hide();
			});
			{/literal}
				var url = 'doajaxfileupload.php?mode=stat_page&type=stat_page&id={$FILTER.id}&elem='+fileelemid;
			{literal}
			if(fileelemid=='photo2') {
				url += '&field=photo2';
			}
			$.ajaxFileUpload
			(
				{
					url: url,
					secureuri:false,
					fileElementId:fileelemid,
					dataType: 'json',
					success: function (data, status) {
						if(typeof(data.error) != 'undefined') {
							if(data.error != '') {
								alert(data.error);
								window.location.reload();
							} else {
								window.location.reload();
							}
						} else {
							window.location.reload();
						}
					},
					error: function (data, status, e) { 
						alert(e); 
					}
				}
			)
			
			return false;
	
		}
	{/literal}
	</script>
</div>
{include file="templates/footer.tpl"}