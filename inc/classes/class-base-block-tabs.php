<?php
/**
 * Main class of plugin
 *
 * @since 0.1.0
 */
class Base_Block_Tabs {






	/**
	 * Main construct
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'tabbed_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'base_block' ), 11 );
		add_action( 'admin_enqueue_scripts', array( $this, 'base_block_scripts' ) );
		add_action( 'add_to_base_block_one', array( $this, 'mapping_info_for_base_block_one' ) );
		add_action( 'add_to_base_block_one', array( $this, 'upload_csv_for_base_block' ) );
		add_action( 'add_to_base_block_two', array( $this, 'something_for_base_block_two' ) );
	}

	/**
	 * Add a page to the base_block menu.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function base_block() {
		$slug  = preg_replace( '/_+/', '-', __FUNCTION__ );
		$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );

		// change the next two lines to match whichever plugin menu you want this to be under
		$plugin_data     = $this->get_tabbed_setup_data();
		$function        = 'base_block_tabs';
		$parent_dash     = preg_replace( '/_+/', '-', $function ) . '.php';
		$class_function  = array( $this, 'base_block_tabs' );
		$base_block_tabs =
			add_menu_page( __( ucwords( preg_replace( '/_+/', ' ', $function ) ), 'base-block' ), __( ucwords( preg_replace( '/_+/', ' ', $function ) ), 'base-block' ), 'manage_options', preg_replace( '/_+/', '-', $function ) . '.php', $class_function, 'dashicons-sos', 4 );

		$function       = 'base_block_tabs_one';
		$class_function = array( $this, 'base_block_tabs_one' );
		add_submenu_page( $parent_dash, __( ucwords( preg_replace( '/_+/', ' ', $function ) ), 'base-block' ), __( ucwords( preg_replace( '/_+/', ' ', $function ) ), 'base-block' ), 'manage_options', preg_replace( '/_+/', '-', $function ) . '.php', $class_function );
		$function       = 'base_block_tabs_two';
		$class_function = array( $this, 'base_block_tabs_two' );
		add_submenu_page( $parent_dash, __( ucwords( preg_replace( '/_+/', ' ', $function ) ), 'base-block' ), __( ucwords( preg_replace( '/_+/', ' ', $function ) ), 'base-block' ), 'manage_options', preg_replace( '/_+/', '-', $function ) . '.php', $class_function );

		add_action( "load-{$base_block_tabs}", array( $this, 'tabbed_load_settings_page' ) );
	}

	/**
	 * [base_block_scripts description]
	 *
	 * @since 1.0.0
	 *
	 * @return [type] [description]
	 */
	public function base_block_scripts() {
		// wp_register_script( 'grid-for-tabs', plugins_url( 'js/grid-for-tabs.js', __DIR__ ), array( 'jquery' ), time(), true );
		// wp_localize_script(
		// 'grid-for-tabs',
		// 'code_sample_object',
		// array(
		// 'local_user_id' => get_current_user_id(),
		// 'code_ajaxurl'  => admin_url( 'admin-ajax.php' ),
		// 'trigger_nonce' => wp_create_nonce( 'grid-for-tabs-nonce' ),
		// )
		// );
		// wp_enqueue_script( 'grid-for-tabs' );

		wp_register_style( 'grid-for-tabs', plugins_url( 'css/grid-for-tabs.css', __DIR__ ), time() );
		wp_enqueue_style( 'grid-for-tabs' );
	}


	/**
	 * Debug Information
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public function base_block_tabs_one() {
		global $wpdb;
		echo '<div class="wrap">';
		echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
		$screen = get_current_screen();

		echo '<div class="add-to-conditional-dash" style="background:aliceblue;padding:1rem 2rem;">';
		echo "<h4> ** <span style=\"color:salmon;\">$screen->id</span> == Screen->id</h4>";
		echo '<p class="description">On initial activation you could have been directed to this screen.</p>';
		do_action( 'add_to_base_block_one' );
		echo '</div>';

		echo '<h4 style="color:rgba(250,128,114,.7);">Current Screen is <span style="color:rgba(250,128,114,1);">' . $screen->id . '</span></h4>';

		echo '</div>';
	}

	/**
	 * [mapping_info_for_base_block_one description]
	 *
	 * @return [type] [description]
	 */
	public function mapping_info_for_base_block_one() {
		echo '<h3>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h3>';
		if ( isset( $_REQUEST['action'] ) && __FUNCTION__ === $_REQUEST['action'] ) {
			echo '<h4>To hide ' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . ' <a href="' . esc_url( remove_query_arg( 'action' ) ) . '"><button>Click Here</button></a></h4>';
			echo '<pre>base_block_mapping ';
			base_block_mapping();
			echo '</pre>';
		} else {
			echo '<h4>To show ' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . ' <a href="' . esc_url( add_query_arg( 'action', __FUNCTION__ ) ) . '"><button>Click Here</button></a></h4>';
		}
	}

	/**
	 * [upload_csv_for_base_block description]
	 *
	 * @return [type] [description]
	 */
	public function upload_csv_for_base_block() {
		echo '<h3>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h3>';
		if ( isset( $_REQUEST['action'] ) && __FUNCTION__ === $_REQUEST['action'] ) {
			echo '<h4>To hide ' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . ' <a href="' . esc_url( remove_query_arg( 'action' ) ) . '"><button>Click Here</button></a></h4>';
			echo '<script>
		const selectedFile = document.getElementById(\'csv-upload\').files[0];
		</script>';
			echo '<pre>base_block_mapping ';
			// base_block_mapping();
			echo '</pre>';
		} else {
			echo '<h4>To show ' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . ' <a href="' . esc_url( add_query_arg( 'action', __FUNCTION__ ) ) . '"><button>Click Here</button></a></h4>';
		}
	}

	/**
	 * [something_for_base_block_two description]
	 *
	 * @return [type] [description]
	 */
	public function something_for_base_block_two() {
		echo '<h3>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h3>';
		if ( isset( $_REQUEST['action'] ) && __FUNCTION__ === $_REQUEST['action'] ) {
			echo '<h4>To hide ' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . ' <a href="' . esc_url( remove_query_arg( 'action' ) ) . '"><button>Click Here</button></a></h4>';
			echo '<script>
		const selectedFile = document.getElementById(\'csv-upload\').files[0];
		</script>';
			echo '<pre>base_block_mapping ';
			base_block_mapping();
			echo '</pre>';
		} else {
			echo '<h4>To show ' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . ' <a href="' . esc_url( add_query_arg( 'action', __FUNCTION__ ) ) . '"><button>Click Here</button></a></h4>';
		}
	}

	/**
	 * [base_block_tabs_two description]
	 *
	 * @return [type] [description]
	 */
	public function base_block_tabs_two() {
		echo '<div class="wrap">';
		echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
		$screen = get_current_screen();
		echo '<div class="add-to-conditional-dash" style="background:mintcream;padding:1rem 2rem;">';
		echo "<h4> ** <span style=\"color:salmon;\">$screen->id</span> == Screen->id</h4>";
		echo '<p class="description">On initial activation you could have been directed to this screen.</p>';
		do_action( 'add_to_base_block_two' );
		echo '</div>';

		echo '</div>';
	}

	/**
	 * [base_block_mapping description]
	 *
	 * @return [type] [description]
	 */
	public function base_block_mapping() {
		echo '<h3>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h3>';
		echo ' is $key ~~ therefore<br>';
		echo '__FUNCTION__ = ' . __FUNCTION__;
		echo '<pre>';
		echo ' pairs<br>';
		echo '</pre>';
	}

	/**
	 * Tabbed Settings Page
	 *
	 * $options = get_option( 'options', array() );
$options = array_merge( array( 'toggle_hedaer' => true, 'background' => 'normal' ), $options );

// Accessing stored values here:
$toggle_header = $options['toggle_hedaer'];
$background = $options['background'];
	 */
	public function tabbed_admin_init() {
		$base_block_tabs = get_option( 'base_block_tabs' );
		if ( empty( $base_block_tabs ) ) {
			$base_block_tabs = array(
				'tabbed_intro'        => __( 'Some intro text for the home page', 'sidetrack-tabbed-login' ),
				'subscriber_redirect' => home_url(),
				'tabbed_admin_redirect'      => admin_url(),
			);
			add_option( 'base_block_tabs', $base_block_tabs, '', 'yes' );
		}
	}

	/**
	 * [tabbed_load_settings_page description]
	 *
	 * @return [type] [description]
	 */
	public function tabbed_load_settings_page() {
		if ( isset( $_POST['base-block-submit'] ) && 'Y' === $_POST['base-block-submit'] ) {
			check_admin_referer( 'base-block-tabs.php' );
			$this->tabbed_save_base_block_tabs();
			$url_parameters = isset( $_GET['tab'] ) ? 'updated=true&tab=' . $_GET['tab'] : 'updated=true';
			wp_redirect( admin_url( 'admin.php?page=base-block-tabs.php&' . $url_parameters ) );
			exit;
		}
	}

	/**
	 * [tabbed_save_base_block_tabs description]
	 *
	 * @return [type] [description]
	 */
	public function tabbed_save_base_block_tabs() {
		global $pagenow;
		$base_block_tabs = get_option( 'base_block_tabs' );

		if ( $pagenow == 'admin.php' && $_GET['page'] === 'base-block-tabs.php' ) {
			if ( isset( $_GET['tab'] ) ) {
				$tab = $_GET['tab'];
			} else {
				$tab = 'maintab';
			}

			switch ( $tab ) {
				case 'firsttab':
					$base_block_tabs['subscriber_redirect'] = $_POST['subscriber_redirect'];
					break;
				case 'secondtab':
					$base_block_tabs['tabbed_admin_redirect'] = $_POST['tabbed_admin_redirect'];
					break;
				case 'maintab':
					$base_block_tabs['tabbed_intro'] = $_POST['tabbed_intro'];
					break;
			}
		}
		if ( ! current_user_can( 'unfiltered_html' ) ) {
			if ( $base_block_tabs['tabbed_admin_redirect'] ) {
				$base_block_tabs['tabbed_admin_redirect'] = stripslashes( esc_textarea( wp_filter_post_kses( $base_block_tabs['tabbed_admin_redirect'] ) ) );
			}
			if ( $base_block_tabs['tabbed_intro'] ) {
				$base_block_tabs['tabbed_intro'] = stripslashes( esc_textarea( wp_filter_post_kses( $base_block_tabs['tabbed_intro'] ) ) );
			}
		}

		$updated = update_option( 'base_block_tabs', $base_block_tabs );
	}

	/**
	 * [tabbed_admin_tabs description]
	 *
	 * @param  string $current [description]
	 * @return [type]          [description]
	 */
	public function tabbed_admin_tabs( $current = 'maintab' ) {
		$tabs = array(
			'maintab'   => __( 'Main Tab', 'base-block' ),
			'firsttab'  => __( 'First Tab', 'base-block' ),
			'secondtab' => __( 'Second Tab', 'base-block' ),
		);
		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $tabs as $tab => $name ) {
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=base-block-tabs.php&tab=$tab'>$name</a>";
		}
		echo '</h2>';
	}

	/**
	 * [get_tabbed_setup_data description]
	 *
	 * @return [type] [description]
	 */
	public function get_tabbed_setup_data() {
		$plugin_data['Name'] = 'Base Block';
		return $plugin_data;
	}

	/**
	 * [base_block_tabs description]
	 *
	 * @return [type] [description]
	 */
	public function base_block_tabs() {
		global $pagenow;
		$base_block_tabs = get_option( 'base_block_tabs' );
		$plugin_data     = $this->get_tabbed_setup_data();
		?>
	
	<div class="wrap grid-for-tabs">
		<h2><?php echo $plugin_data['Name']; ?> Settings</h2>
		<style type="text/css">

	</style>
	<div id="poststuff">
		<?php
		if ( isset( $_GET['tab']['updated'] ) && true === esc_attr( $_GET['updated'] ) ) {
			echo '<div class="updated">
			<p>' . __( 'Settings updated.', 'base-block' ) . '</p>
			</div>';
		}

		// $_GET['tab'] = 'maintab';
		if ( isset( $_GET['tab'] ) ) {
			$this->tabbed_admin_tabs( $_GET['tab'] );
		} else {
			$_GET['tab'] = 'maintab';
			$this->tabbed_admin_tabs( 'maintab' );
		}
		?>

		<form method="post" action="<?php admin_url( 'admin.php?page=base-block-tabs.php' ); ?>">
		<?php
			wp_nonce_field( 'base-block' );
		?>
		<grid class="grid-wrapper">

			<grid-cell class="merged"><?php echo esc_html( $_GET['tab'] ); ?> tab
				<?php
				printf(
					__( 'My header for %s', 'base-block' ),
					esc_html( $_GET['tab'] )
				);
				?>
			</grid-cell>
			<?php
			if ( 'admin.php' === $pagenow && $_GET['page'] === 'base-block-tabs.php' ) {
				if ( isset( $_GET['tab'] ) ) {
					$tab = $_GET['tab'];
				} else {
					$tab = 'maintab';
				}

				switch ( $tab ) {
					case 'firsttab':
						?>

			<grid-cell class="item2">Two</grid-cell> <!-- item2 -->
			<grid-cell class="item3">
				<p>
					<input id="subscriber_redirect" name="subscriber_redirect" type="checkbox" 
						<?php
						if ( $base_block_tabs['subscriber_redirect'] ) {
							echo 'checked="checked"';
						}
						?>
						value="true" /> 
						<span class="description">Output each post tag with a specific CSS class using its slug.</span>
				</p>
			</grid-cell> <!-- item3 -->
						<?php
						break;
					case 'secondtab':
						?>
				<grid-cell><label for="tabbed_admin_redirect">Insert tracking code:</label>
				</grid-cell> <!-- item2 -->

				<grid-cell>
					<h2><?php echo esc_html( $tab ); ?></h2>
					<p>
						<textarea id="tabbed_admin_redirect" name="tabbed_admin_redirect" cols="60" rows="5"><?php echo esc_html( stripslashes( $base_block_tabs['tabbed_admin_redirect'] ) ); ?></textarea><br/>
						<span class="description">tabbed_admin_redirect</span>
					</p>
				</grid-cell> <!-- item3 -->
							<?php
						break;
					case 'maintab':
						?>
				<grid-cell>
					<label for="tabbed_intro">Introduction</label>
				</grid-cell> <!-- item2 -->                 
				<grid-cell>
					<h2>2 column, header and maintab</h2>
					<p>
						<textarea id="tabbed_intro" name="tabbed_intro" cols="60" rows="5" ><?php echo esc_html( stripslashes( $base_block_tabs['tabbed_intro'] ) ); ?></textarea><br/>
<!-- Warning: Illegal string offset 'tabbed_intro' in /app/public/wp-content/plugins/base-block/inc/classes/class-base-block-tabs.php on line 426

Notice: Uninitialized string offset: 0 in /app/public/wp-content/plugins/base-block/inc/classes/class-base-block-tabs.php on line 426 -->
						<span class="description">Enter the introductory text for the home page:</span>
					</p>
				</grid-cell> <!-- item3 -->
						<?php
						break;
				}
			}
			global $pagenow;
			?>
				<grid-cell>
					<label for="tabbed_intro"><?php echo $pagenow; ?></label>
				</grid-cell> <!-- item2 -->
				<grid-cell>
					<p class="submit" style="clear: both;">
						<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
						<input type="hidden" name="base-block-submit" value="Y" />
					</p>
				</grid-cell> <!-- item3 -->
				<grid-cell class="merged" style="text-align: left;">
					<?php
					printf( '<h4 class="your-class">' . __( '%s Footer schtuff here ' ) . '</h4>', esc_url( admin_url( $pagenow ) ) );

					echo '<pre>$base_block_tabs ';
					print_r( $base_block_tabs );
					echo '</pre>';

					echo 'show_modal ' . ( get_option( 'show_modal' ) ? 'true' : 'false' ) . '<br>';
					echo 'mbutton_color ' . ( get_option( 'mbutton_color' ) ?: 'not set' ) . '<br>';

					echo 'mpop_box ' . ( get_option( 'mpop_box' ) ?: 'not set' ) . '<br>';

					echo 'mlink_color ' . ( get_option( 'mlink_color' ) ?: 'not set' ) . '<br>';

					echo 'mbackground_color ' . ( get_option( 'mbackground_color' ) ?: 'not set' ) . '<br>';
					?>
				</grid-cell>

				</grid> <!-- grid-wrapper -->
			</form>
		</div> <!-- poststuff -->
	</div> <!-- wrap -->
		<?php
	}
}
new Base_Block_Tabs();
