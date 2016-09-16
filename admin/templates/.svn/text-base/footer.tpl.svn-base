{if !empty($login)}
		</div>
		<!--[if !IE]>end login wrapper<![endif]-->
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
{else}
			</div>
			<!--[if !IE]>end page<![endif]-->
			<!--[if !IE]>start sidebar<![endif]-->
			{if $side_menu}
				<div id="sidebar">
					<div class="inner">
						<!--[if !IE]>start section<![endif]-->	
						<div class="section">
							<!--[if !IE]>start title wrapper<![endif]-->
							<div class="title_wrapper">
								<h2>Избери</h2>
								<span class="title_wrapper_left"></span>
								<span class="title_wrapper_right"></span>
							</div>
							<!--[if !IE]>end title wrapper<![endif]-->
							<!--[if !IE]>start section content<![endif]-->
							<div class="section_content">
								<!--[if !IE]>start section content top<![endif]-->
								<div class="sct">
									<div class="sct_left">
										<div class="sct_right">
											<div class="sct_left">
												<div class="sct_right">
													<ul class="sidebar_menu">
														{assign var=cur_idx value=0}
														{foreach from=$side_menu item=link key=id name=men}
														 
															{ math equation="(x + 1)" x=$cur_idx assign='cur_idx' }
															<li {if count($side_menu)==$cur_idx}class="last"{/if}><a href="{$link.href}" {if ($link.active)}class="active"{/if}>{$link.title}</a></li>
														{/foreach}
													</ul>
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
						{*
						<!--[if !IE]>start section<![endif]-->	
						<div class="section">
							<!--[if !IE]>start title wrapper<![endif]-->
							<div class="title_wrapper">
								<h2>To do list</h2>
								<span class="title_wrapper_left"></span>
								<span class="title_wrapper_right"></span>
							</div>
							<!--[if !IE]>end title wrapper<![endif]-->
							<!--[if !IE]>start section content<![endif]-->
							<div class="section_content">
								<!--[if !IE]>start section content top<![endif]-->
								<div class="sct">
									<div class="sct_left">
										<div class="sct_right">
											<div class="sct_left">
												<div class="sct_right">
														
														<div class="todo_list">
															<dl>
																<dt><span class="order">1</span> View pending orders list</dt>
																<dd>
																	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sit amet elit pellentesque odio laoreet lacinia. 
																</dd>
																<dd>
																	<ul class="todo_menu">
																		<li><a href="#">Get started</a></li>
																		<li><a href="#">Check notes</a></li>
																	</ul>
																</dd>
															</dl>
														
															<dl>
																<dt><span class="order">2</span> Verify New Uploads</dt>
																<dd>
																	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sit amet elit 
																</dd>
																<dd>
																	<ul class="todo_menu">
																		<li><a href="#">Get started</a></li>
																		<li><a href="#">Approve all</a></li>
																	</ul>
																</dd>
															</dl>
														
															<dl class="last">
																<dt><span class="order">3</span>Manage Banners</dt>
																<dd>
																	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sit amet elit pellentesque odio laoreet lacinia.
																</dd>
																<dd>
																	<ul class="todo_menu">
																		<li><a href="#">Go</a></li>
																		<li><a href="#">Config. 1</a></li>
																		<li><a href="#">Config. 2</a></li>
																	</ul>
																</dd>
															</dl>
														</div>
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
						*}
					</div>
				</div>
			{/if}
			<!--[if !IE]>end sidebar<![endif]-->
		</div>
		<!--[if !IE]>end content<![endif]-->
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
	<!--[if !IE]>start footer<![endif]-->
	<div id="footer">
	</div>
	<!--[if !IE]>end footer<![endif]-->
{/if}	
</body>
</html>
