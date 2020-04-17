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
define( 'DB_NAME', 'wordpressdb' );

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
define( 'AUTH_KEY',         '`=)Me59Kqx)SvP)mfd}*JVw01+[rTY%SaD;un;8VE-[RG6[2d>Hdrshq{OfSe.}Y' );
define( 'SECURE_AUTH_KEY',  'vJ,^$g}_5Zw6}J43]shSss7T6-/v/>Pw(a8_4|~]xa!3;nU4ya7#6A[dgKuA0-YX' );
define( 'LOGGED_IN_KEY',    'zR#HferM?;|#|NcuPD<F8]FnQe=VhA8&ahN1~@*C1|rg2,mFh!DPF[Q9|,+{h$]=' );
define( 'NONCE_KEY',        'T4:g [G[5]FitA%`9m(>?ex0TTKactJZ]J_`j$B,b1Hah@oEuNg^gj&lc8R5GGWY' );
define( 'AUTH_SALT',        'apmzqY//mIK}el8;>Fmlle]wk#g_nq|a{.X6kOGjXvoR2:b_8`0qeS9S=H6DrJ*L' );
define( 'SECURE_AUTH_SALT', '6>|-$;R-0KtQlf7PO{!W7t;3]Kru)yzHoGm%#cYW0pyR~lq= 3S@K0PpQ9WN?WVF' );
define( 'LOGGED_IN_SALT',   'mLhg*LV.TzM|:gGfVPAVZ]@BTdq,.je_wL$35<4!DBUG`PwCIx&~^dt6o>+Xe|j*' );
define( 'NONCE_SALT',       '!{OXve=G+5b0,$_!IB<s6BLGX,Vrp!}WI~nm$)6|:,~h{*DaXH_l+>CfU+eAD/.R' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
