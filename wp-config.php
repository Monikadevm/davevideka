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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', '' );

/** Database username */
define( 'DB_USER', '' );

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
define( 'AUTH_KEY',         'qX^@oWIVm`99UL2v6%kU3_(F(mKE|ZE,dqhrWLD]cg|Y2,Yq[B$7O:]$xAZ{hTFF' );
define( 'SECURE_AUTH_KEY',  'WV>IS6(QX>s=u6tfAW@D/q&O3Z4/(Rvm_*+xD#lg=M}F(ygR8wT=5Q[!jhXv;9%@' );
define( 'LOGGED_IN_KEY',    ' [w_R>eL~P[TE%GO!s2dq<6xwC!c&#-~7fl2+fwuY>rMdm$=2!g/yqD wPa>OzEN' );
define( 'NONCE_KEY',        'fqtZnI_`]DwO_{n<:*$B _DGuR!bf[Z[b+A[w3?u2N7DFw{xH-KHgbJ>KW4{>qTO' );
define( 'AUTH_SALT',        'Mp,.KAhRy=G.Peg;g--W>(yP#gD&~~NSo@eN%g=+GzKaG[/([{} 6=s{2qC8SsLj' );
define( 'SECURE_AUTH_SALT', '^r?)5>t8rvkOVP5g4@gl?_H%8)5s?$UMzYFf)dArcidfdpnG;SDR6<mN~Y h=n%K' );
define( 'LOGGED_IN_SALT',   '_de6]MAf~[DNlj[I]w3`SWlqdp6HZQPtL&meBVZ{}?D83YcJQ6F:g9zW<V1VCx%3' );
define( 'NONCE_SALT',       '+~[%rT~1brV%Jy5aCO&q|Zn@0H26ZcBDF^:AFRf_6J0S(.{>,JO,<bv#8(.@[_q]' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
