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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HTbCCVOp6NI32eY+v5zLIOLOenRTelXzqTJd33lrlbuMX4eD7RXgHIgfshkLrhO28XO5WQ6VgNOBPzb/LaE1wg==');
define('SECURE_AUTH_KEY',  'HxKFWQVHZC8Vx1z5OkfVU5HK7ERC/81vZPh7Adj4TakCa9E6dIsHZx+Fcv3Xte3hq9BgAD+zMfMEVcfB/zE9KA==');
define('LOGGED_IN_KEY',    '2vT+i9y4EWbS7dvzYaFrvZTTyrRxM3yXhRiWLtUqcZ22M6cVvFYE07tafVxJ5ZRd/mfG8qmsjRbbGa5Di+XLAw==');
define('NONCE_KEY',        'HN5zbVUnwb3dL0epnEFPuaVsGJJAeh/FA4CYlIF2lT9xUqRSuTKFqUjHEyRuu/oWlApP0RhP0FL4zPKmjrU3pQ==');
define('AUTH_SALT',        'ifwjZU5f6TBG1i7CglHwQPWPMKktG+VdZ7O6Xtqr9HaizEYqyBVVpyDqz+86TTn3ItSCIJ+QYPKP2yW/Tbvpxg==');
define('SECURE_AUTH_SALT', '7eopUUw86QAWCYgMegtkDKWmgoDx8pHZ2Y9KJAvMpG0a9YhBfrAcD56YIYsvJUfvHVO6R2CwSzDlGa5DXAZ0Vw==');
define('LOGGED_IN_SALT',   '4QlsvMiDUNLXRFyM5Z/sEg+O2Zswu8ZsiRH3qmem7btkEvU3Qx3/wTICKVVPXnU67uOX7QJ76l6poZ68vTs9/Q==');
define('NONCE_SALT',       '/tviYwxKHxzwwNqOxJnfSyQZgaK0csNd7ICfxfeudgmc1TgcGHx/c7ZZ7Bcl/cxy831NZultpv6aqtsQLuIqQw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
