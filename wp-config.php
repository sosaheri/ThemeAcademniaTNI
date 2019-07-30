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
define('DB_NAME', 'academiatni');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+=y(ywp.2)_$S2O PN;DAu0|X/y&M2Dq&#IXOzAcs[%_gn8Bg@ZqG9uTSv<irc]N');
define('SECURE_AUTH_KEY',  '45@&4#[f+pt^7^%MRrsfj.0s#p0zHHRDBU>;sV*7|k?`Co? QCi#NR*`@h~^Pp(3');
define('LOGGED_IN_KEY',    '<iG;R@{>~%xw;,*yu|m82MSY%!*s2JWdVET,TbdxiR|0,u,it5lH2|91(ZA_?3vc');
define('NONCE_KEY',        '.`B>qS* &Z}(u(-:QV=(fgxwd9{TX^<YwO[c}&F!h PZ|=|eC5*_[fO;O`|LbeTT');
define('AUTH_SALT',        ' v2)!tmeuXxW@; xZWcZ*MmUjB^#+exc%)5l_qYcfg1gf_9I_2H#L/{<U3jpvS4.');
define('SECURE_AUTH_SALT', '?0dN~KAd$+#(r,NGNQ~M?:Au=KituyD 9LfFZoTv=uY@?n[xX%=0;bS!~ekImU,g');
define('LOGGED_IN_SALT',   '/=zR}!05HtO&!4kqBapljx,o`&ng4>,N20H`Tp&mWEO?j2(];$*+MM14H)Oz5AJB');
define('NONCE_SALT',       ');yXq&H09?qcN$Ap^J6-bYAP39=gj]cE2jFz9A&{adS5,_Nup&nUJ+Bg]VbS,EIu');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'law_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
