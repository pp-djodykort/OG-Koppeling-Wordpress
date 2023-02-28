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
define( 'DB_NAME', 'admin_og-wp' );


/** Database username */
define( 'DB_USER', 'admin_og-wp' );


/** Database password */
define( 'DB_PASSWORD', '6OMaa8GpC' );


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
define( 'AUTH_KEY',         ';i[BDn[43K[=6LfcTcRE?PZxE[16a:2N44C$.J[UKYRH$IH#y|741SptZRL3[0TW' );

define( 'SECURE_AUTH_KEY',  'cjPgmFfo/ii2@UMEl7,#3o q5%[g3?LbU[rKole)z*/unM/U|R~T$:n/k=t+2^Q~' );

define( 'LOGGED_IN_KEY',    '1]A~pHLp-lR39<oXg%CtL+9at$A`K|`NwFTfhFYl`+ud@l`PIy+BsMK%TehZZ#kI' );

define( 'NONCE_KEY',        '?41+-UdK-1&wK[{Svb=gPKD[y-NkIwx~_mYF6vL3Sqd}.c?uw>f<ogbw_^/H+|H*' );

define( 'AUTH_SALT',        '9v@rK`8c.TZ5&naT5}hw$%19?0/7GTUqDR$+ti6^6Bv{#&5~YX)D:k#=$&*-Hd&o' );

define( 'SECURE_AUTH_SALT', 'co+@e6^~NCj9_7IO4umkll#0],>O<8)};.yfYkAfWD!j5jg}LT8iFL%tso8NvfzX' );

define( 'LOGGED_IN_SALT',   'Wuc+8x8y+-JgUjZze/Uadxt.om<is7G*%Vjc]3m)F^hG~oV<T!GH}^nZx8J`]~xH' );

define( 'NONCE_SALT',       '02ty>4f*a -iPM_HVIZ77p)5[?%AZI|iGJQ7~f^gxl)x>$t-vNW|$rw0X(9Xr=<y' );


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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

// Setting the execution time to 300 seconds which hopefully is enough
set_time_limit(300);