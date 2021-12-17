<?php


add_action( 'admin_footer', 'tabbed_diagnostic_dash_message' );
function tabbed_diagnostic_dash_message() {
			global $current_user;
	?>
	<style>
		#footer-diagnostic {
			display: grid;
			grid-template-columns: 16% 1fr 1fr 1fr;
		}

		#footer-diagnostic pre {
		 white-space: pre-wrap;       /* css-3 */
		 white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
		 white-space: -pre-wrap;      /* Opera 4-6 */
		 white-space: -o-pre-wrap;    /* Opera 7 */
		 word-wrap: break-word;       /* Internet Explorer 5.5+ */
		}
		#footer-diagnostic .full {
			grid-column: 1 / -1;
			text-align: center;
		}
		#toplevel_page_pmpro-beta  .xdebug-error.xe-warning {
			margin-left: 12rem;
		}
	</style>
	<?php

	// if ( 'base-block-tabs.php' === $_GET['page'] ) {
			echo '<div id="footer-diagnostic">';
			echo '<div>$user <pre>';
			echo '$current_user ' . $current_user->ID . '<br>';
	if ( ! empty( $_REQUEST['user'] ) ) {
		$user_id = intval( $_REQUEST['user'] );
		$user    = get_userdata( $user_id );
		if ( empty( $user->ID ) ) {
			$user_id = false;
		}
	} else {
		$user = get_userdata( 0 );
	}

	if ( isset( $user->ID ) ) {
		echo '$user->ID  ' . $user->ID . '<br>';
	} elseif ( isset( $user_id ) ) {
		echo '$user_id ' . $user_id . '<br>';
	} else {
		echo 'wtf';
	}
	echo '</div><div>$_GET <pre>';
	print_r( $_GET );
	echo '</pre></div>';
	echo '<div>$_REQUEST <pre>';
	print_r( $_REQUEST );
	echo '</pre></div>';
	echo '<div>$_POST <pre>';
	print_r( $_POST );
	echo '</pre></div>';
	echo '<div class="full">';
	echo __FUNCTION__;
	echo '<br>Line ' . __LINE__ . '</div>';
	echo '</div>';
	// }
}
