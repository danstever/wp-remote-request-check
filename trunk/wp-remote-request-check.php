<?php
/*
 Plugin Name: WP Remote Request Check
 Plugin URI: http://roost.me
 Description: Checks if the WordPress HTTP API is able to be used.
 Author: danstever
 Version: 0.1
 */

class Request_Check {

	public function __construct() {
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'add_action_links' ) );
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
	}
		
	public function add_action_links ( $links ) {
	    $rlink = array(
	        '<a href="' . admin_url('tools.php?page=wp-remote-request-check') . '">WP Remote Request Check</a>',
	    );
	    return array_merge( $rlink, $links );
	}

	function remote_request($remote_url) {
		if( empty( $remote_url ) ) {
			$remote_url = 'http://google.com';
		}
	    $response = wp_remote_request( $remote_url );
	    return $response;
	}
	
    public function add_plugin_page() {
        add_submenu_page(
            'tools.php', 
            'WP Remote Request Check', 
            'Rmt Request Check', 
            'manage_options', 
            'remote-request-check', 
            array( $this, 'create_admin_page' )
        );
    }
    
    public function create_admin_page() {
        ?>
        <div class="wrap">
            <h2>WP Remote Request Check</h2>
            <p>This plugin checks if the WordPress HTTP API can be used from your website.</p>
            <p>Click <i><b>'Check'</b></i> to find out.</p>
            <hr />
            <form method="post" action="">
            <p><i>If you want to check a specific URL, enter it here. Otherwise http://google.com will be used.</i></p>
            <label for="pingURL">URL: </label><input type="text" name="pingURL" id="pingURL" value="" placeholder="http://google.com"/>
            <?php
            	submit_button( isset( $_POST['check'] ) ? 'Check Again' : 'Check', '', 'check');
            ?>
            </form>
            <hr />
			<?php
				if ( isset( $_POST['check'] ) ) {
					$ping_url = $_POST['pingURL'];
					$response = $this->remote_request( $ping_url );
					if(wp_remote_retrieve_response_code($response) === 200 ) {
						echo( '<p style="color: #00ff00; font-weight: bold; font-size: 35px;">You\'re all set!</p>' );
					} else {
						echo( '<p style="color: #ff0000; font-weight: bold; font-size: 35px;">There was a problem...</p>' );
					}
					if ( is_wp_error( $response ) ) {
						$code = $response->get_error_code();
						$message = $response->get_error_message();
					} else {
						$code = wp_remote_retrieve_response_code($response);
						$message = wp_remote_retrieve_response_message($response);
					}
					echo( '<h3>Response Code: <i>' . $code . '</i></h3>' );
					echo( '<h3>Response Message: <i>' . $message . '</i></h3>' );
					echo( '<h3>From: ' . ( empty( $ping_url ) ? "http://google.com":$ping_url ) . '</h3>' );
					if(wp_remote_retrieve_response_code($response) !== 200 ) {
						echo( '<h2><i>And for the real geek...</i></h2>' );
						var_dump($response);
					}
				}
			?>
        </div>
        <?php
    }
}

if ( is_admin() ) {
	$request_check = new Request_Check();
}

?>