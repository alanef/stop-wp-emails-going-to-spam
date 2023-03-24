<?php
/**
 * Created
 * User: alan
 * Date: 04/04/18
 * Time: 13:45
 */

namespace Stop_Wp_Emails_Going_To_Spam\Admin;


use AlanEFPluginDonation\PluginDonation;

class Admin_Settings extends Admin_Pages {

	protected $settings_page;
	// protected $settings_page_id = 'toplevel_page_stop-wp-emails-going-to-spam';  // top level
	protected $settings_page_id = 'settings_page_stop-wp-emails-going-to-spam-settings';
	protected $option_group = 'stop-wp-emails-going-to-spam';
	protected $settings_title;
	protected $domain;
	protected $options;
	protected $donations;

	/**
	 * Settings constructor.
	 *
	 * @param string $plugin_name
	 * @param string $version plugin version.
	 */

	public function __construct( $plugin_name, $version, $domain, $options ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->domain      = $domain;
		$this->options     = $options;


		$this->settings_title = esc_html__( 'Stop WP Emails Going to Spam', 'stop-wp-emails-going-to-spam' );
		$this->donation       = new PluginDonation(
			'stop-wp-emails-going-to-spam',
			'settings_page_stop-wp-emails-going-to-spam-settings',
			'stop-wp-emails-going-to-spam/stop-wp-emails-going-to-spam.php',
			admin_url( 'options-general.php?page=stop-wp-emails-going-to-spam-settings' ),
			$this->settings_title
		);

		add_filter( 'plugindonation_lib_strings_stop-wp-emails-going-to-spam', array( $this, 'set_strings' ) );

		parent::__construct();
	}

	public function register_settings() {
		/* Register our setting. */
		register_setting(
			$this->option_group,                         /* Option Group */
			'stop-wp-emails-going-to-spam-settings-1',                   /* Option Name */
			array( $this, 'sanitize_settings_1' )          /* Sanitize Callback */
		);


		/* Add settings menu page */
		$this->settings_page = add_submenu_page(
			'stop-wp-emails-going-to-spam',
			'Settings', /* Page Title */
			'Settings',                       /* Menu Title */
			'manage_options',                 /* Capability */
			'stop-wp-emails-going-to-spam',                         /* Page Slug */
			array( $this, 'settings_page' )          /* Settings Page Function Callback */
		);

		register_setting(
			$this->option_group,                         /* Option Group */
			"{$this->option_group}-reset",                   /* Option Name */
			array( $this, 'reset_sanitize' )          /* Sanitize Callback */
		);

	}

	public function delete_options() {
		update_option( 'stop-wp-emails-going-to-spam-settings-1', self::option_defaults( 'stop-wp-emails-going-to-spam-settings-1' ) );

	}

	public static function option_defaults( $option ) {
		switch ( $option ) {
			case 'stop-wp-emails-going-to-spam-settings-1':
				return array(
					// set defaults
					'email'           => 'admin',
					'emailname'       => '',
					'otheremailname'  => '',
					'envelope'        => 'envelope',
					'wordpresschoice' => 'envelope',
					'wordpressname'   => 'WordPress',
					'wordpressemail'  => 'wordpress'
				);
			default:
				return false;
		}
	}

	public function add_meta_boxes() {

		add_meta_box(
			'settings-info',                  /* Meta Box ID */
			esc_html__( 'Information', 'stop-wp-emails-going-to-spam' ),               /* Title */
			array( $this, 'meta_box_info' ),  /* Function Callback */
			$this->settings_page_id,               /* Screen: Our Settings Page */
			'normal',                 /* Context */
			'default'                 /* Priority */
		);
		add_meta_box(
			'settings-2',                  /* Meta Box ID */
			esc_html__( 'Sending Health Check', 'stop-wp-emails-going-to-spam' ),               /* Title */
			array( $this, 'meta_box_2' ),  /* Function Callback */
			$this->settings_page_id,               /* Screen: Our Settings Page */
			'normal',                 /* Context */
			'default'                 /* Priority */
		);
		add_meta_box(
			'settings-1',                  /* Meta Box ID */
			esc_html__( 'Envelope Sender', 'stop-wp-emails-going-to-spam' ),               /* Title */
			array( $this, 'meta_box_1' ),  /* Function Callback */
			$this->settings_page_id,               /* Screen: Our Settings Page */
			'normal',                 /* Context */
			'default'                 /* Priority */
		);


	}

	public function meta_box_info() {
		?>
        <table class="form-table">
            <tbody>
			<?php $this->donation->display(); ?>
            <tr valign="top">
                <th scope="row"><?php _e( 'About this Plugin', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <h4>
						<?php esc_html_e( 'This plugin tries to help you stop emails being sent to spam folders when sent from your WordPress website.', 'stop-wp-emails-going-to-spam' ); ?>
                    </h4>
                    <p>
						<?php esc_html_e( 'When using the default PHP mailer on shared hosts WordPress does not correctly set the "envelope sender".', 'stop-wp-emails-going-to-spam' ); ?>
                    </p>
                    <p>
						<?php esc_html_e( 'Use the settings to select the email that you want as the "envelope sender".', 'stop-wp-emails-going-to-spam' ); ?>
                    </p>
                    <p>
						<?php esc_html_e( 'For best results the "envelope sender" domain should have a SPF record, see the SPF section, and the email address should exist.', 'stop-wp-emails-going-to-spam' ); ?>
                    </p>
                    <p>
						<?php esc_html_e( 'This plugin will only set the "envelope sender" if other plugins have not.', 'stop-wp-emails-going-to-spam' ); ?>
                    </p>
                    <p>
                        <strong>
							<?php esc_html_e( 'You do not need this plugin if you are using an SMTP email plugin or using an API based / transactional email solution', 'stop-wp-emails-going-to-spam' ); ?>
                        </strong>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
		<?php
	}

	public function meta_box_1() {
		?>
        <p>
            <span class="description"><?php esc_html_e( 'This sets envelope sender of the message, if not set by another program. This will usually be turned into a Return-Path header by the receiver, and is the address that bounces will be sent to.', 'stop-wp-emails-going-to-spam' ); ?></span>
        </p>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Use Admin Email', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <label for="stop-wp-emails-going-to-spam-settings-1[email]"><input type="radio"
                                                                                       name="stop-wp-emails-going-to-spam-settings-1[email]"
                                                                                       id="stop-wp-emails-going-to-spam-settings-1[email]"
                                                                                       value="admin"
							<?php checked( 'admin', $this->options['email'] ); ?>>
						<?php echo esc_html( get_bloginfo( 'admin_email' ) ); ?></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Use another Domain email', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <label for="stop-wp-emails-going-to-spam-settings-1[email]"><input type="radio"
                                                                                       name="stop-wp-emails-going-to-spam-settings-1[email]"
                                                                                       id="stop-wp-emails-going-to-spam-settings-1[email]"
                                                                                       value="domain"
							<?php checked( 'domain', $this->options['email'] ); ?>>
                        <input type="text"
                               style="text-align: right"
                               class="medium-text"
                               name="stop-wp-emails-going-to-spam-settings-1[emailname]"
                               id="stop-wp-emails-going-to-spam-settings-1[emailname]"
                               value="<?php echo esc_attr( $this->options['emailname'] ) ?>">@<?php echo esc_html( str_ireplace( 'www.', '', parse_url( get_site_url(), PHP_URL_HOST ) ) ); ?>
                    </label>
                    <p>
						<span class="description">
							<?php
							/* translators:  leave the @%s  as in noreply@%s */
							printf( esc_html__( 'You can use an email like noreply@%s, but make sure the email account exists.', 'stop-wp-emails-going-to-spam' ), esc_html( $this->domain ) );
							?>
						</span>
                    </p>

                </td>
            </tr>
            <tr valign="top">
				<?php
				// added new field so check to initialize 1.1.5
				if ( ! isset( $this->options['otheremailname'] ) ) {
					$this->options['otheremailname'] = '';
				}
				?>
                <th scope="row"><?php esc_html_e( 'Use another email', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <label for="stop-wp-emails-going-to-spam-settings-1[email]"><input type="radio"
                                                                                       name="stop-wp-emails-going-to-spam-settings-1[email]"
                                                                                       id="stop-wp-emails-going-to-spam-settings-1[email]"
                                                                                       value="other"
							<?php checked( 'other', $this->options['email'] ); ?>>
                        <input type="email"
                               class="medium-text"
                               name="stop-wp-emails-going-to-spam-settings-1[otheremailname]"
                               id="stop-wp-emails-going-to-spam-settings-1[otheremailname]"
                               value="<?php echo esc_attr( $this->options['otheremailname'] ) ?>">
                    </label>
                    <p>
                        <span class="description"><?php esc_html_e( 'You can use another fully qualified email, but make sure the email account exists and the domain has correct SPF set up. No point using gmail or outlook or domains you don\'t own as you will never make it work', 'stop-wp-emails-going-to-spam' ); ?></span>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'From Address', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <p>
                        <span class="description"><?php esc_html_e( 'Set the relationship between From address and Envelope address', 'stop-wp-emails-going-to-spam' ); ?></span>
                    </p>
                    <label for="stop-wp-emails-going-to-spam-settings-1[envelope]"><input type="radio"
                                                                                          name="stop-wp-emails-going-to-spam-settings-1[envelope]"
                                                                                          id="stop-wp-emails-going-to-spam-settings-1[envelope]"
                                                                                          value="envelope"
							<?php checked( 'envelope', $this->options['envelope'] ); ?>>
						<?php esc_html_e( 'Tick to set the From to the same as Envelope (above) recommended', 'stop-wp-emails-going-to-spam' ); ?>
                    </label><br>
                    <label for="stop-wp-emails-going-to-spam-settings-1[envelope]"><input type="radio"
                                                                                          name="stop-wp-emails-going-to-spam-settings-1[envelope]"
                                                                                          id="stop-wp-emails-going-to-spam-settings-1[envelope]"
                                                                                          value="from"
							<?php checked( 'from', $this->options['envelope'] ); ?>>
						<?php esc_html_e( 'Tick to set the Envelope to the From, not recommended unless all your forms use a From address of your domain, however the SPF check below is ignored', 'stop-wp-emails-going-to-spam' ); ?>
                    </label><br>
                    <label for="stop-wp-emails-going-to-spam-settings-1[envelope]"><input type="radio"
                                                                                          name="stop-wp-emails-going-to-spam-settings-1[envelope]"
                                                                                          id="stop-wp-emails-going-to-spam-settings-1[envelope]"
                                                                                          value="none"
							<?php checked( 'none', $this->options['envelope'] ); ?>>
						<?php esc_html_e( 'Tick to leave the From address alone - this may raise warnings in email clients when different from Envelope, not generally recommended', 'stop-wp-emails-going-to-spam' ); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'WordPress default mail address', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <p>
						<span class="description">
							<?php
							/* translators:  leave &lt;wordpress@%s&gt; */
							printf( esc_html__( 'WordPress default system messages come from an account WordPress &lt;wordpress@%s&gt;  you can control that with the following settings', 'stop-wp-emails-going-to-spam' ), esc_html( $this->domain ) );
							?>
			</span>
                    </p>
                    <label for="stop-wp-emails-going-to-spam-settings-1[wordpresschoice]"><input type="radio"
                                                                                                 name="stop-wp-emails-going-to-spam-settings-1[wordpresschoice]"
                                                                                                 id="stop-wp-emails-going-to-spam-settings-1[wordpresschoice]"
                                                                                                 value="envelope"
							<?php checked( 'envelope', $this->options['wordpresschoice'] ); ?>>
						<?php esc_html_e( 'Tick to set the WP default to the same as the email set above - recommended', 'stop-wp-emails-going-to-spam' ); ?>
                    </label><br>
                    <label for="stop-wp-emails-going-to-spam-settings-1[wordpresschoice]"><input type="radio"
                                                                                                 name="stop-wp-emails-going-to-spam-settings-1[wordpresschoice]"
                                                                                                 id="stop-wp-emails-going-to-spam-settings-1[wordpresschoice]"
                                                                                                 value="custom"
							<?php checked( 'custom', $this->options['wordpresschoice'] ); ?>>
                        <input type="text"
                               style="text-align: right"
                               class="medium-text"
                               name="stop-wp-emails-going-to-spam-settings-1[wordpressemail]"
                               id="stop-wp-emails-going-to-spam-settings-1[wordpressemail]"
                               value="<?php echo esc_attr( $this->options['wordpressemail'] ) ?>">@<?php echo esc_html( str_ireplace( 'www.', '', parse_url( get_site_url(), PHP_URL_HOST ) ) ); ?>
                        <br>
						<?php esc_html_e( 'Tick and set an email name on your domain for the default email', 'stop-wp-emails-going-to-spam' ); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'WordPress default name', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <input type="text"
                           class="medium-text"
                           name="stop-wp-emails-going-to-spam-settings-1[wordpressname]"
                           id="stop-wp-emails-going-to-spam-settings-1[wordpressname]"
                           value="<?php echo esc_attr( $this->options['wordpressname'] ) ?>">
                    <p>
                        <span class="description"><?php esc_html_e( 'You can change the display name associated with the default WordPress email, this is cosmetic only', 'stop-wp-emails-going-to-spam' ); ?></span>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
		<?php
	}

	public function sanitize_settings_1( $settings ) {
		$settings['email']           = sanitize_text_field( $settings['email'] );
		$settings['emailname']       = sanitize_text_field( $settings['emailname'] );
		$settings['otheremailname']  = sanitize_email( $settings['otheremailname'] );
		$settings['envelope']        = sanitize_text_field( $settings['envelope'] );
		$settings['wordpresschoice'] = sanitize_text_field( $settings['wordpresschoice'] );
		$settings['wordpressemail']  = sanitize_text_field( $settings['wordpressemail'] );
		$settings['wordpressname']   = sanitize_text_field( $settings['wordpressname'] );
		$err                         = false;
		if ( ! isset( $settings['email'] ) ) {
			$settings['email'] = 'admin';  // always set checkboxes of they dont exist
		}
		if ( 'domain' == $settings['email'] ) {

			if ( ! is_email( $settings['emailname'] . '@' . $this->domain ) ) {
				$err[] = esc_html__( 'Invalid email for Envelope', 'stop-wp-emails-going-to-spam' );
			}
		}
		if ( 'other' == $settings['email'] ) {

			if ( ! is_email( $settings['otheremailname'] ) ) {
				$err[] = esc_html__( 'Invalid email for Envelope', 'stop-wp-emails-going-to-spam' );
			}
		}

		if ( ! isset( $settings['wordpresschoice'] ) ) {
			$settings['wordpresschoice'] = 'envelope';
		}
		if ( 'custom' == $settings['wordpresschoice'] ) {

			if ( ! is_email( $settings['wordpressemail'] . '@' . $this->domain ) ) {
				$err[] = esc_html__( 'Invalid email for WordPress default', 'stop-wp-emails-going-to-spam' );
			}
		}

		if ( $err ) {
			add_settings_error(
				'pses1',
				'pses1',
				implode( '<br>', $err ),
				'error'
			);

			return $this->options;
		}


		return $settings;
	}

	public function sanitize_settings_2( $settings ) {

		return $settings;
	}

	public function meta_box_2() {
		if ( isset( $_SERVER['SERVER_ADDR'] ) ) {
			$ip = $_SERVER['SERVER_ADDR'];
		} else {
			$ip = gethostbyname( $_SERVER['SERVER_NAME'] );
		}
		if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$ip4 = true;
		} else {
			$ip4 = false;
		}
		if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) ) {
			$ip6 = true;
		} else {
			$ip6 = false;
		}
		if ( 'admin' == $this->options['email'] ) {
			$domain = substr( strrchr( get_bloginfo( 'admin_email' ), '@' ), 1 );
		} else {
			$domain = $this->domain;
		}
		$blacklist = false;
		if ( $ip4 ) {
			$rbl    = 'zen.spamhaus.org';
			$rev    = array_reverse( explode( '.', $ip ) );
			$lookup = implode( '.', $rev ) . '.' . $rbl;
			if ( $lookup !== gethostbyname( $lookup ) ) {
				$blacklist = true;
			}
		}

		$dns = @dns_get_record( $domain, DNS_TXT );
		$spf = false;
		if ( $dns ) {
			foreach ( $dns as $dnstxt ) {
				if ( 'TXT' == $dnstxt['type'] ) {
					if ( isset( $dnstxt['txt'] ) ) {
						if ( 'v=spf' == substr( $dnstxt['txt'], 0, 5 ) ) {
							$spf = $dnstxt['txt'];
							break;
						}
					}
				}
			}
		}
		?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><?php _e( '', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <p><?php esc_html_e( 'This section is for information only, if there are problems getting your IP or DNS use a third party tool' ) ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e( 'Server Info', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
					<?php if ( $ip4 || $ip6 ) {
						?>
                        <p>Server IP
                            Address: <?php echo esc_html( $ip ); ?>  <?php echo ( $ip4 ) ? esc_html__( 'IPv4', 'stop-wp-emails-going-to-spam' ) : esc_html__( 'IPv6', 'stop-wp-emails-going-to-spam' ); ?></p>
						<?php
					} else {
						?>
                        <p class="notice notice-error"><?php esc_html_e( 'Cannot identify a valid IP address - you may want to check with your hosting company', 'stop-wp-emails-going-to-spam' ); ?></p>
						<?php
					}
					if ( $blacklist ) {
						?>
                        <p class="notice notice-error"><?php esc_html_e( 'Your IP appears in one or more spam blacklists', 'stop-wp-emails-going-to-spam' ); ?>
                            &nbsp;<span
                                    style="background-color: black; color: white; padding: 8px;"><?php esc_html_e( 'spam blacklists', 'stop-wp-emails-going-to-spam' ); ?></span>&nbsp;<?php esc_html_e( 'you may want to talk to your host to resolve your IP reputation', 'stop-wp-emails-going-to-spam' ); ?>
                        </p>
						<?php
					}
					?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Domain being checked', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
                    <p><?php echo esc_html( $this->domain ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row" class="alternate"><?php _e( 'SPF Record', 'stop-wp-emails-going-to-spam' ); ?></th>
                <td>
					<?php
					if ( ! $dns ) {
						printf( esc_html__(
							'%1$sCannot get DNS records - refresh this page - if you still get this message after a few refreshes you may want to check your domain DNS control panel or check via a third part tool%2$s',
							'stop-wp-emails-going-to-spam' ),
							'<p class="notice notice-error">', '</p>'
						);
					} else {
						if ( false == $spf ) {
							printf( esc_html__(
								'%1$sNo SPF record found for %2$s, the following SPF record is recommended',
								'stop-wp-emails-going-to-spam' ),
								'<p class="notice notice-error">', $this->domain );
							echo ' <br><code>';
							if ( $ip4 || $ip6 ) {
								printf( ' v=spf1 +a +mx %s:%s ~all', ( $ip4 ) ? 'ip4' : 'ip6', esc_html( $ip ) );
							} else {
								echo 'v=spf1 +a +mx ~all';
							}
							echo '</code>';
							echo '</p>';
						} else {
							printf(
							/* translators:  leave placeholders 'Current record SPF record for domain_name: <strong>spf_record</strong>' */
								esc_html__(
									'Current record SPF record for %1$s: %2$s%3$s%4$s',
									'stop-wp-emails-going-to-spam' ), $domain, '<strong>', $spf, '</strong><br /><br />' );

							if ( strpos( strtolower( $spf ), 'redirect=' ) ) {
								printf(
								/* translators:  leave placeholders - they are just html <p> tags  with styling classes */
									esc_html__(
										'%1$sThe SPF redirects to another domain, recommend you manually check the redirected SPF%2$s',
										'stop-wp-emails-going-to-spam' ), '<p class="notice notice-success">', '</p>' );
							} elseif ( strpos( $spf, $ip ) ) {
								printf(
								/* translators:  leave placeholders - they are just html <p> tags  with styling classes */
									esc_html__(
										'%1$sGood!, this contains your server IP address%2$s',
										'stop-wp-emails-going-to-spam' ), '<p class="notice notice-success">', '</p>' );
							} elseif ( strpos( strtolower( $spf ), ' a ' ) || strpos( strtolower( $spf ), ' +a ' ) ) {
								printf(
								/* translators:  leave placeholders - they are just html <p> tags  with styling classes */
									esc_html__(
										'%1$sGood!, this contains an A record reference%2$s',
										'stop-wp-emails-going-to-spam' ), '<p class="notice notice-success">', '</p>' );
							} else {
								printf(
								/* translators:  leave placeholders - they are just html <p> tags  with styling classes */
									esc_html__(
										'%1$sRecommend you add +a to your SPF record%4$s',
										'stop-wp-emails-going-to-spam' ), '<p class="notice notice-warning">', ( $ip4 ) ? 'ip4' : 'ip6', esc_html( $ip ), '</p>' );
							}
						}
					}
					?>
                    <p>
						<?php esc_html_e( 'Note about ~all.  ~all is a soft fail and is normally used,  however some services relay emails and O365 does not like it if the originating SPF is weaker than the relay SPF. If you are  having issues with O365/Outlook/Hotmail try using -all rather than ~all', 'stop-wp-emails-going-to-spam' ); ?>
                    </p>
            </tr>
            </tbody>
        </table>
		<?php
	}

	public function set_strings( $strings ) {
		$strings = array(
			esc_html__( 'Gift a Donation', 'stop-wp-emails-going-to-spam' ),
			// 0
			esc_html__( 'Hi, I\'m Alan and I built this free plugin to solve problems I had, and I hope it solves your problem too.', 'stop-wp-emails-going-to-spam' ),
			// 1
			esc_html__( 'It would really help me know that others find it useful and a great way of doing this is to gift me a small donation', 'stop-wp-emails-going-to-spam' ),
			// 2
			esc_html__( 'Gift a donation: select your desired option', 'stop-wp-emails-going-to-spam' ),
			// 3
			esc_html__( 'My Bitcoin donation wallet', 'stop-wp-emails-going-to-spam' ),
			// 4
			esc_html__( 'Gift a donation via PayPal', 'stop-wp-emails-going-to-spam' ),
			// 5
			esc_html__( 'My Bitcoin Cash address', 'stop-wp-emails-going-to-spam' ),
			// 6
			esc_html__( 'My Ethereum address', 'stop-wp-emails-going-to-spam' ),
			// 7
			esc_html__( 'My Dogecoin address', 'stop-wp-emails-going-to-spam' ),
			// 8
			esc_html__( 'Contribute', 'stop-wp-emails-going-to-spam' ),
			// 9
			esc_html__( 'Contribute to the Open Source Project in other ways', 'stop-wp-emails-going-to-spam' ),
			// 10
			esc_html__( 'Submit a review', 'stop-wp-emails-going-to-spam' ),
			// 11
			esc_html__( 'Translate to your language', 'stop-wp-emails-going-to-spam' ),
			// 12
			esc_html__( 'SUBMIT A REVIEW', 'stop-wp-emails-going-to-spam' ),
			// 13
			esc_html__( 'If you are happy with the plugin then we would love a review. Even if you are not so happy feedback is always useful, but if you have issues we would love you to make a support request first so we can try and help.', 'stop-wp-emails-going-to-spam' ),
			// 14
			esc_html__( 'SUPPORT FORUM', 'stop-wp-emails-going-to-spam' ),
			// 15
			esc_html__( 'Providing some translations for a plugin is very easy and can be done via the WordPress system. You can easily contribute to the community and you don\'t need to translate it all.', 'stop-wp-emails-going-to-spam' ),
			// 16
			esc_html__( 'TRANSLATE INTO YOUR LANGUAGE', 'stop-wp-emails-going-to-spam' ),
			// 17
			esc_html__( 'As an open source project you are welcome to contribute to the development of the software if you can. The development plugin is hosted on GitHub.', 'stop-wp-emails-going-to-spam' ),
			// 18
			esc_html__( 'CONTRIBUTE ON GITHUB', 'stop-wp-emails-going-to-spam' ),
			// 19
			esc_html__( 'Get Support', 'stop-wp-emails-going-to-spam' ),
			// 20
			esc_html__( 'WordPress SUPPORT FORUM', 'stop-wp-emails-going-to-spam' ),
			// 21
			esc_html__( 'Hi I\'m Alan and I support the free plugin', 'stop-wp-emails-going-to-spam' ),
			// 22
			esc_html__( 'for you.  You have been using the plugin for a while now and WordPress has probably been through several updates by now. So I\'m asking if you can help keep this plugin free, by donating a very small amount of cash. If you can that would be a fantastic help to keeping this plugin updated.', 'stop-wp-emails-going-to-spam' ),
			// 23
			esc_html__( 'Donate via this page', 'stop-wp-emails-going-to-spam' ),
			// 24
			esc_html__( 'Remind me later', 'stop-wp-emails-going-to-spam' ),
			// 25
			esc_html__( 'I have already donated', 'stop-wp-emails-going-to-spam' ),
			// 26
			esc_html__( 'I don\'t want to donate, dismiss this notice permanently', 'stop-wp-emails-going-to-spam' ),
			// 27
			esc_html__( 'Hi I\'m Alan and you have been using this plugin', 'stop-wp-emails-going-to-spam' ),
			// 28
			esc_html__( 'for a while - that is awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help spread the word and boost my motivation..', 'stop-wp-emails-going-to-spam' ),
			// 29
			esc_html__( 'OK, you deserve it', 'stop-wp-emails-going-to-spam' ),
			// 30
			esc_html__( 'Maybe later', 'stop-wp-emails-going-to-spam' ),
			// 31
			esc_html__( 'Already done', 'stop-wp-emails-going-to-spam' ),
			// 32
			esc_html__( 'No thanks, dismiss this request', 'stop-wp-emails-going-to-spam' ),
			// 33
			esc_html__( 'Donate to Support', 'stop-wp-emails-going-to-spam' ),
			// 34
			esc_html__( 'Settings', 'stop-wp-emails-going-to-spam' ),
			// 35
			esc_html__( 'Help Develop', 'stop-wp-emails-going-to-spam' ),
			// 36
			esc_html__( 'Buy Me a Coffee makes supporting fun and easy. In just a couple of taps, you can donate (buy me a coffee) and leave a message. You don’t even have to create an account!', 'plugin-donation-lib' ),
			// 37
		);

		return $strings;
	}


}

