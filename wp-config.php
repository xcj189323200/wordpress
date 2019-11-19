<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define( 'DB_NAME', 'app' );

/** MySQL数据库用户名 */
define( 'DB_USER', 'app' );

/** MySQL数据库密码 */
define( 'DB_PASSWORD', 'jt6dPE4m44BWdEWW' );

/** MySQL主机 */
define( 'DB_HOST', '39.96.166.71' );

/** 创建数据表时默认的文字编码 */
define( 'DB_CHARSET', 'utf8mb4' );

/** 数据库整理类型。如不确定请勿更改 */
define( 'DB_COLLATE', '' );



/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'c@_1UAk76z+&0*!L gpQ-@U`?>kGtnE<WB7Do^4su2bShu;U.k8e /ZLK7~&o[KN' );
define( 'SECURE_AUTH_KEY',  'SsVW7f-T}oEYt4faD&%1[?Jk6d[ YG27=Oo,|r j3g]E(mdzRvc5<@DnW$t_/e!q' );
define( 'LOGGED_IN_KEY',    '6o4^>h>FHG^1_*b3TS6/if7q]!%g4xXIuzc<Gu%%wl>Hc;dDxS)2jprtdRY$M%HY' );
define( 'NONCE_KEY',        '}SoAgwSS0Bg OUSS- @4~/e0)K#F#qxcJhYJC<HU7pgigc^TEJjm2d;w_N^L_.NR' );
define( 'AUTH_SALT',        'cw-*l($!A]rq|?CpV;4_vIRAV71Q6tGZ_g)Z.Hr[P*Pi/OM,[<]DK+=x9dwa4]N{' );
define( 'SECURE_AUTH_SALT', '_29AGM2Gy_9-,NKdjJJ$NFmpP/,a0V&5o/XpJC{8BL=o++w5?9Di05ApTLEinhUS' );
define( 'LOGGED_IN_SALT',   'LVvD91$h(mN&SZJaB~K<9V|!WcErP))}GRsJOO}EFurR$9zWtIeC4Qr1[y^[g|SY' );
define( 'NONCE_SALT',       'YBWBA*k,.i(x}ro}r`KZu-(Ot4/06%&R%OQ.8R~</5w=#BQDrwkx#RuQe{Dh,zE(' );

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** 设置WordPress变量和包含文件。 */
require_once( ABSPATH . 'wp-settings.php' );

