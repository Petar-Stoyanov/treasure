<?php require_once('/Users/petar/Documents/lenovo transfer/Projects/treasure/inc/Smarty/plugins/function.math.php'); $this->register_function("math", "tpl_function_math");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2016-09-23 14:11:29 EEST */ ?>

<?php if (! empty ( $this->_vars['login'] )): ?>
		</div>
		<!--[if !IE]>end login wrapper<![endif]-->
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
<?php else: ?>
			</div>
			<!--[if !IE]>end page<![endif]-->
			<!--[if !IE]>start sidebar<![endif]-->
			<?php if ($this->_vars['side_menu']): ?>
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
														<?php $this->assign('cur_idx', 0); ?>
														<?php if (count((array)$this->_vars['side_menu'])): foreach ((array)$this->_vars['side_menu'] as $this->_vars['id'] => $this->_vars['link']): ?>
														 
															<?php echo tpl_function_math(array('equation' => "(x + 1)",'x' => $this->_vars['cur_idx'],'assign' => 'cur_idx'), $this);?>
															<li <?php if (count ( $this->_vars['side_menu'] ) == $this->_vars['cur_idx']): ?>class="last"<?php endif; ?>><a href="<?php echo $this->_vars['link']['href']; ?>
" <?php if (( $this->_vars['link']['active'] )): ?>class="active"<?php endif; ?>><?php echo $this->_vars['link']['title']; ?>
</a></li>
														<?php endforeach; endif; ?>
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
						
					</div>
				</div>
			<?php endif; ?>
			<!--[if !IE]>end sidebar<![endif]-->
		</div>
		<!--[if !IE]>end content<![endif]-->
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
	<!--[if !IE]>start footer<![endif]-->
	<div id="footer">
	</div>
	<!--[if !IE]>end footer<![endif]-->
<?php endif; ?>	
</body>
</html>
