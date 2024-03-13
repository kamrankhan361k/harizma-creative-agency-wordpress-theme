<?php

$priority = 1;

Kirki::add_field(
	'arts',
	array(
		'type'         => 'repeater',
		'label'        => esc_html__( 'Social Media', 'harizma' ),
		'section'      => 'social',
		'priority'     => $priority++,
		'row_label'    => array(
			'type'  => 'text',
			'value' => esc_html__( 'Social Media', 'harizma' ),
			'field' => 'social_icon',
		),
		'button_label' => esc_html__( 'Add new Social Media URL ', 'harizma' ),
		'settings'     => 'social_links',
		'fields'       => array(
			'social_icon' => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Social Icon', 'harizma' ),
				'default' => 'fa fa-facebook-f fa-fw',
				'choices' => array(
					'fa fa-facebook-f fa-fw'  => esc_html__( 'Facebook', 'harizma' ),
					'fa fa-twitter fa-fw'     => esc_html__( 'Twitter', 'harizma' ),
					'fa fa-instagram fa-fw'   => esc_html__( 'Instagram', 'harizma' ),
					'fa fa-linkedin fa-fw'    => esc_html__( 'LinkedIn', 'harizma' ),
					'fa fa-google-plus fa-fw' => esc_html__( 'Google Plus', 'harizma' ),
					'fa fa-vk fa-fw'          => esc_html__( 'VK', 'harizma' ),
					'fa fa-youtube fa-fw'     => esc_html__( 'YouTube', 'harizma' ),
					'fa fa-vimeo fa-fw'       => esc_html__( 'Vimeo', 'harizma' ),
					'fa fa-dribbble fa-fw'    => esc_html__( 'Dribbble', 'harizma' ),
					'fa fa-pinterest fa-fw'   => esc_html__( 'Pinterest', 'harizma' ),
					'fa fa-behance fa-fw'     => esc_html__( 'Behance', 'harizma' ),
					'fa fa-flickr fa-fw'      => esc_html__( 'Flickr', 'harizma' ),
					'fa fa-tumblr fa-fw'      => esc_html__( 'Tumblr', 'harizma' ),
					'fa fa-vine fa-fw'        => esc_html__( 'Vine', 'harizma' ),
					'fa fa-github fa-fw'      => esc_html__( 'Github', 'harizma' ),
					'fa fa-soundcloud fa-fw'  => esc_html__( 'SoundCloud', 'harizma' ),
				),
			),
			'social_url'  => array(
				'type'  => 'link',
				'label' => esc_html__( 'Social URL', 'harizma' ),
			),
		),
	)
);
