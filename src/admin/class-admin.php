<?php


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 */

namespace Stop_Wp_Emails_Going_To_Spam\Admin;

class Admin {

	/**
	 * The ID of this plugin.
	 *
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 */
	private $version;

	/**
	 * @var
	 */
	private $options;

	/**
	 * @var
	 */
	private $domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 */
	public function __construct( $plugin_name, $version, $domain, $options ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->options     = $options;
		$this->domain      = $domain;

	}

	public function redirect_to_settings() {
		if ( get_option( 'stop-wp-emails-going-to-spam-activate', false ) ) {
			delete_option( 'stop-wp-emails-going-to-spam-activate' );
			if ( ! isset( $_GET['activate-multi'] ) ) {
				wp_safe_redirect( admin_url( 'options-general.php?page=stop-wp-emails-going-to-spam-settings' ) );
				exit;
			}
		}
	}

	public function settings_link( $links ) {
		$url           = admin_url( 'options-general.php?page=stop-wp-emails-going-to-spam-settings' );
		$settings_link = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings', 'stop-wp-emails-going-to-spam' ) . '</a>';
		array_push(
			$links,
			$settings_link
		);

		return $links;
	}

	function plugin_meta( $links, $file ) {

		if ( strpos( $file, 'stop-wp-emails-going-to-spam.php' ) !== false ) {
			$new_links = array(
				'<a href="https://www.paypal.com/donate/?hosted_button_id=ZG4NGLJSYX9SC" target="_blank">' . esc_html__( 'Donate to Support', 'stop-wp-emails-going-to-spam' ) . '</a>'
			);

			$links = array_merge( $links, $new_links );
		}

		return $links;
	}

	/**
	 * @param $phpmailer
	 */
	public function set_envelope_sender( $phpmailer ) {

		if ( ! is_email( $phpmailer->Sender ) ) {
			if ( 'from' === $this->options['envelope'] ) {
				$email = $phpmailer->From;
			} else {
				$email = $this->get_email();
				if ( 'envelope' === $this->options['envelope'] ) {
					$phpmailer->From = $email;
				}
			}
			$phpmailer->Sender = $email;
		}
	}

	/**
	 * gets the email that is the sender
	 *
	 * @return mixed|string|void
	 */
	private function get_email() {
		if ( 'admin' === $this->options['email'] ) {
			return get_bloginfo( 'admin_email' );
		}
		if ( 'other' === $this->options['otheremailname'] ) {
			return $this->options['otheremailname'];
		}

		return $this->options['emailname'] . '@' . $this->domain;
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function wp_mail_from_name( $name ) {
		if ( 'WordPress' === $name && isset( $this->options['wordpressname'] ) && ! empty( $this->options['wordpressname'] ) ) {   // and option has value
			return $this->options['wordpressname'];
		}

		return $name;
	}

	/**
	 * @param $email
	 *
	 * @return mixed|string|void
	 */
	public function wp_mail_from( $email ) {

		if ( 'wordpress' === strtok( $email, '@' ) ) {
			if ( isset( $this->options['wordpresschoice'] ) ) {
				if ( 'envelope' === $this->options['wordpresschoice'] ) {
					return $this->get_email();
				}
				if ( 'custom' === $this->options['wordpresschoice'] ) {
					return $this->options['wordpressemail'] . '@' . $this->domain;
				}
			}
		}

		return $email;
	}
}

