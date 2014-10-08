	<div id="secondary" class="c4 fr" style="float:right !important;" role="complementary">
	
		<div id="sidebar-one">
			
			<?php
			
			// get easy-sidebar
			//if ( function_exists( 'easy_sidebars' ) ) :
			//	easy_sidebars()->sidebar();

			// get theme-generated sidebar
			//else :

				/*
$cat_id = get_query_var( 'cat' );
				$cat = ( is_category() ) ? get_category( $cat_id ) : '';
				$parent_id = ( is_category() ) ? $cat->category_parent : '';
				$parent_name = ( is_category() ) ? get_cat_name( $parent_id ) : '';
				$parent_name_plus = ( is_category() ) ? $parent_name . '-' : '';
				$sidebar_id = ( is_category() ) ? sanitize_title( $parent_name_plus . $cat->category_nicename ) . '-widget-area' : 'sidebar';
*/
				if ( ! dynamic_sidebar( 'sidebar-top' ) ) :
					if ( is_category() ) {
						dynamic_sidebar( 'sidebar-top' );
					}
				endif;
			//endif;
			?>
			
			
		</div><!-- #sidebar-one -->
		
			
	
		
		

	</div><!-- #secondary.widget-area -->