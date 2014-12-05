<?php
class MacroContentHammer__database extends MacroContentHammer__Plugin
{

	public $name = "mch__content";

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
				'name' => __( 'MCH__content' ),
				'singular_name' => __( 'MCH__content' )
			),
			'public' => false,
			'has_archive' => false,
			)
		);

		// register taxonomy


	}

	public function total__mch__content(){

		// return total content for attributing new editor ID
		$count_posts = wp_count_posts( $this->name );

	}


}