<?php
class MacroContentHammer__database
{


	public function total__mch__content( $post_ID ){

		$args = array(
			'post_type'  	=> 'MCH__content'
			,'order_by'		=> 'ID'
			,'order'		=> 'ASC'
			,'post_parent'	=> $post_ID			
			,'posts_per_page'=>-1
			,'meta_key'		=> 'mch__template'
		);
		$mch_query = new WP_Query( $args );

		echo $mch_query->found_posts;

		// return total content for attributing new editor ID
		// var_dump( wp_count_posts( $this->name ) );

	}


}