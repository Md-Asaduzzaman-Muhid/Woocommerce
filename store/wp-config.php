<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'io_store' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'KA`jRP0<qL0?zNsH/6U@jda9>tgj|#^}N_:{q<,#R:-m<qlM4#8@U!SiPg7B>5ov' );
define( 'SECURE_AUTH_KEY',  ']`NyE1 S1a4s&^MlY1-L)YhfcpT;euDDDO.9g(sH<qQIjS%dxWK(87&cV=5v. u ' );
define( 'LOGGED_IN_KEY',    'qzPTS?d%Gaz MYO)wlrm5uHJh*M~)&O#|/=&)atMxh :5/.ho4!+Gq/A(>PrV%ZC' );
define( 'NONCE_KEY',        'qhpT-Ax-%daTd/-t)rSz:qnz:$Dn3C[*NZNRWIqH;YT_:y$`y>Gqg!Sr#>sjD [?' );
define( 'AUTH_SALT',        'mVBe%*}^i-:*(a)=n0b;BVD`okCB]b&f:m)~~Ar@7?d2GOIm4C/p;V~feO.ngau?' );
define( 'SECURE_AUTH_SALT', '/M>crKF fL!Tu/UTjJ1jk+VE ==@}}Z%xJ,Ll<~HP`}RJ3mgg4K0+5qfsq669f-_' );
define( 'LOGGED_IN_SALT',   '=vBf=3yb%Vs;(pki]vW(m$oy]F$$kkS|y|f/Eb-w*a(@RxT`xD5)jF,28TS:b)&~' );
define( 'NONCE_SALT',       '[G3>]Gc0!m?9cs}pK|C03s]rRX+)u|rpL?7+x%OTPx20h{>oAtC/u4vBpK):kI:q' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'is_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

