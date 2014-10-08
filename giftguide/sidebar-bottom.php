	<div class="c4 secondary fr" style="float:right !important;" role="complementary">
		<div id="sidebar-two">
			<?php
				if ( ! dynamic_sidebar( 'sidebar-bottom'  ) ) :
					if ( is_category() ) {
						dynamic_sidebar( 'sidebar-bottom'  );
					}
				endif;
			?>
			
			
		</div><!-- #sidebar-two -->

	</div><!-- #secondary.widget-area -->