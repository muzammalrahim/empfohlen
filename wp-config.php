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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'empfohlen' );

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
define( 'AUTH_KEY',         'gc]eo$fr tN2X~+2u7NNZ@cUW,dm]N~Oxdy.R4BlR&9j <1bR&s`T)9H?sc-g(2r' );
define( 'SECURE_AUTH_KEY',  '|p?sVp#<D3C+R^Tgg>_/]>>e{i.M[W}exDgIsh,6BvDk?Ruj1+{qkLnx ,Q.baQ~' );
define( 'LOGGED_IN_KEY',    '0Po4@x|po(?*PZMyT-/Ows;:*wI$Xa$NoGh+qM#Bb!|9=tU|XcWP}~6?9|,#1du4' );
define( 'NONCE_KEY',        'b1@|e]<;JIu]^kp{k4T<`^zYxs5D8jvK|%`[,xWxjw=y?0dQqcgK3+m3b@B:j8Yi' );
define( 'AUTH_SALT',        '(^$7?.$aQhVGfS^b+KXhU+5/>,jt]w{WE7uHeZ<*FB4V_$5&3<vV#-r.2>WJ|D>k' );
define( 'SECURE_AUTH_SALT', 'q sIUgM&N;#82/Hv~/fpi$woJ6IS-= dC/5~AIGWFm_JL`>^44db4[Ro~xn->h!H' );
define( 'LOGGED_IN_SALT',   '$,P`/Us[`7JJ[sW!R$D&J5S&e|xA1V;67%I;a+}bK@yDwM)>>r^[gEPlw/l$)xL:' );
define( 'NONCE_SALT',       ':=,!y4o0~K&M;!.,!ugS1q%u3$S)=e+<A3#32t<fGVT4)TyJ{,e%gj-4r0%WbYi9' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
