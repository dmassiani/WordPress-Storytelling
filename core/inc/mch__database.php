<?php
class MacroContentHammer__database extends MacroContentHammer__kickstarter
{

	public $name = "MCH__content";

	public function __construct()
	{
		self::init();
	}


	public function init()
	{        


		// MCH__content is custom post type for post
		// MCH__parent is register in MCH__content with post parent
		// MCH__groupe is meta for groupe of mch__content

		// create MCH taxonomy

		register_post_type( $this->name ,
			array(
				'labels' => array(
				'name' => __( $this->name ),
				'singular_name' => __( $this->name )
			),
			'public' => false,
			'has_archive' => false,
			)
		);


	}

	public function total__mch__content( $post_ID ){

		$args = array(
			'post_type'  	=> 'MCH__content'
			,'order_by'		=> 'ID'
			,'order'		=> 'ASC'
			,'post_parent'	=> $post_ID
			,'meta_key'		=> 'template'
		);
		$mch_query = new WP_Query( $args );

		echo $mch_query->found_posts;

		// return total content for attributing new editor ID
		// var_dump( wp_count_posts( $this->name ) );

	}


}