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

		// create MCH taxonomy


		register_post_type( $this->name ,
			array(
				'labels' => array(
				'name' => __( 'Mch__content' ),
				'singular_name' => __( 'Mch__content' )
			),
			'public' => false,
			'has_archive' => false,
			)
		);


	}

	public function total__mch__content(){

		// return total content for attributing new editor ID
		$count_posts = wp_count_posts( $this->name );

	}


}