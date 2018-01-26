<?php

/**
 * Class Editor_Custom_Buttons Main plugin class
 *
 * @version 0.1
 */
class AG_Html_Sitemap_Builder {
	/**
	 * Holds the option values to be used in the fields callbacks
	 *
	 * @var array $options Plugin Options
	 */
	private $options;

	/**
	 * Holds the values of registered post types to be used in the fields callbacks
	 *
	 * @var array $options Registered Post Types
	 */
	private $post_types;

	/**
	 * Editor_Custom_Buttons constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_init', [ $this, 'page_init' ] );
	}

	/**
	 * Register admin menu item
	 */
	public function admin_menu() {
		add_options_page(
			'HTML Sitemap Options',
			'HTML Sitemap Options',
			'manage_options',
			'ag_html_sitemap_generator',
			[
				$this,
				'settings_page',
			]
		);
	}


	/**
	 * Get Post types
	 *
	 * @return array post_types
	 */
	public function get_registered_post_types() {
		$this->post_types = get_post_types( [
			'public' => true,
		], 'object' );

		return apply_filters( 'aghs_post_types', $this->post_types );
	}


	/**
	 * Settings page content
	 */
	public function settings_page() {
		$this->options = get_option( 'aghs_options' );
		/**
		 * Include page template
		 */
		require_once 'admin/admin-settings-page.php';
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {

		register_setting(
			'aghs_options_group',
			'aghs_options',
			array( $this, 'sanitize' )
		);

		add_settings_section(
			'ag_html_sitemap_generator_section',
			esc_html_x( 'HTML sitemap settings', 'ag-html-sitemap' ),
			[ $this, 'print_section_info' ],
			'aghs_options_section'
		);

		add_settings_field(
			'post_types',
			'Include Post Types',
			[ $this, 'post_types_callback' ],
			'aghs_options_section',
			'ag_html_sitemap_generator_section'
		);

		add_settings_field(
			'post_exclude',
			'Exlude Posts for each post type',
			[ $this, 'exclude_posts' ],
			'aghs_options_section',
			'ag_html_sitemap_generator_section'
		);
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function post_types_callback() {
		?>
		<tr>
			<td>
				<table>
					<?php foreach ( $this->get_registered_post_types() as $slug => $object ) : ?>
						<tr>
							<td>
								<label for="check-<?php echo esc_attr( $slug ); ?>"><?php echo esc_attr( $object->label ); ?></label>
							</td>
							<td>
								<input id="check-<?php echo esc_attr( $slug ); ?>"
									<?php if ( in_array( esc_attr( $slug ), $this->options['post_type'], true ) ) {
										checked( true, true );
									} ?>
									   type="checkbox"
									   name="aghs_options[post_type][]"
									   value="<?php echo esc_attr( $slug ); ?>">
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			</td>
		</tr>
		<?php
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function exclude_posts() {

		?>
		<tr>
			<td>
				<table>
					<p>Separate post ids by comma</p>
					<tr>
						<td>
							<label for="excluded_posts">Exclude IDs</label>
						</td>
						<td>
							<input id="excluded_posts" type="text" name="aghs_options[excluded]"
								   value="<?php echo esc_attr( isset( $this->options['excluded_posts'] ) ? $this->options['excluded_posts'] : '' ); ?>">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function include_archives() {

		?>
		<tr>
			<td>
				<table>
					<tr>
						<td>
							<label for="excluded_posts">Exclude IDs</label>
						</td>
						<td>
							<input id="excluded_posts" type="text" name="aghs_options[excluded]"
								   value="<?php echo esc_attr( isset( $this->options['excluded_posts'] ) ? $this->options['excluded_posts'] : '' ); ?>">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		$text = __( 'Configure sitemap. Include/exclude your post_types, posts, pages. Change ordering and  preview changes', 'ag-html-sitemap' );
		print wp_kses_post( apply_filters( 'aghs_settins_page_description', $text ) );
	}
}
