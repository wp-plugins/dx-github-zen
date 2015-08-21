<?php
/**
 * Plugin Name: DX GitHub Zen
 * Description: Add some Zen by GitHub to your WordPress website
 * Author: nofearinc
 * Author URI: http://devwp.eu/
 * Version: 1.1
 * Text Domain: dxgz
 * License: GPL2

 Copyright 2013 mpeshev (email : mpeshev AT devrix DOT com)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

define( 'DX_GITHUB_ZEN_API_URL', 'https://api.github.com/zen' );

/**
 * GitHub message class helper
 * 
 * Currently in use for widgets and shortcodes.
 * 
 * @author nofearinc
 *
 */
class DX_GitHub_Zen_Message {
	/**
	 * Timeout in minutes
	 * @var int $timeout in minutes
	 */
	private $timeout;
	
	/**
	 * Transient name
	 * @var string $transient_name value in database
	 */
	private $transient_name;
	
	public function __construct( $timeout = 20, $transient_name = 'dx_zen_message' ) {
		$this->timeout = $timeout;
		$this->transient_name = $transient_name;		
	}
	
/**
     * Helper function getting the Zen message from GitHub
     * and setting a transient with some timeout 
     * 
     * @return message Zen message or some placeholder
     */
    public function get_zen_message() {
		$dx_zen_message = get_transient( 'dx_zen_message' );
		$zen_message = ( false === $dx_zen_message ) ? '' : $dx_zen_message;
		
		// Set transient if not set yet
    	if( false === $dx_zen_message ) {
    		$response = wp_remote_get( DX_GITHUB_ZEN_API_URL );

    		if( ! is_wp_error( $response ) ) {
				$zen_message = $response['body'];
				
				// Get body if request went fine
				if( ! empty( $response['response'] ) 
					&& ! empty( $response['response']['code'] )
					&& $response['response']['code'] == 200 ) {

					// Get the body and store the transient
    				set_transient( 'dx_zen_message' , $zen_message, 60 * $this->timeout );
    			} 
    		} else {
    			$zen_message = $response->get_error_message();
    		}
    	}

    	$zen_message = apply_filters( 'dx_filter_zen_message', esc_html( $zen_message ) );
    	
    	return $zen_message;
    }
}

// Include widget and shortcode functions
include_once 'dx-zen-widget.class.php';
include_once 'dx-zen-shortcode.php';