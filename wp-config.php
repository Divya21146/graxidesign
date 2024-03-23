<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'graxidesign' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'yTFTXJ.k5Eh/#U-@6&D0o2@d>.0xw{a|J} G(C~.xmj=n[z4*^71UdYn;BHeOXCR' );
define( 'SECURE_AUTH_KEY',  'veW$*MT~c3iXQyH%o~2QSP1`2Mfm_e^%{nN`+s4EINQQ ctN}w!A4}EfR7hIPNeu' );
define( 'LOGGED_IN_KEY',    '{BCQa)B8]Yf7!xRH! T,6IdnAnN^4P&/}OXc/$VX3YDhg04ps9KHMS#R_Y@J(t0|' );
define( 'NONCE_KEY',        'Nj|v3aSGBUaLNyx<ni@uUrct$g79d&q9SYwyZl}W5A0 J!Bk>ud/*g0ioV?*nzb0' );
define( 'AUTH_SALT',        'eBu>yvW@!w#DYP56s_B{`ci]qb5q|$-/@IeXA|e{9faOH$+/T>! Ga1RQ$BLM)-E' );
define( 'SECURE_AUTH_SALT', 'F(+i/dqNEH4#Y0KErO_ThV8/^&oG7:Ljvd$viIWxvecFZ+5Z`C<ExuJ,AcPi+v6{' );
define( 'LOGGED_IN_SALT',   '7iDycFpZ8pCz-#GxoFyJT0w@7k,L3HCsnuku<NZ_q82jzVwfnJ+WrbS8*&CumH/i' );
define( 'NONCE_SALT',       '854^0fue9&/]Ag})8/{4cjkWln%&@,q8)vgzut)Hgd/NSo4k_z+{oH(NqAGe-2B>' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
