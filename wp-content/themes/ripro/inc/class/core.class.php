<?php 
add_action("csf__caozhuti_options_save_after", "ripro_options_save_after");
/*
if( !chechkbenactivip() ) 
{
    add_action("wp_footer", "jihuo_footer_notify");
}*/

//add_action("wp_ajax_ripro_ajax_check", "ripro_ajax_check");
//add_action("wp_ajax_nopriv_ripro_ajax_check", "ripro_ajax_check");

/**
 * DB install
 */
/**
 * Theme Name: RiPro
 * Theme URI: http://www.aiqiyic.cn/
 * Author: 艾奇资源网
 */
class setupDb
{
    public function setupRefLog()
    {
        global $wpdb;
        global $ref_log_table_name;
        if( $wpdb->get_var("SHOW TABLES LIKE '" . $ref_log_table_name . "'") != $ref_log_table_name ) 
        {
            $sql = " CREATE TABLE `" . $ref_log_table_name . "` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `money` double(10,2) DEFAULT NULL COMMENT '提现金额',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '申请时间',\r\n                  `up_time` int(11) DEFAULT '0' COMMENT '审核时间',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 审核中；1已打款；-1失效',\r\n                  `note` varchar(255) DEFAULT NULL COMMENT '说明备注',\r\n                  PRIMARY KEY (`id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=" . DB_CHARSET . " COMMENT='提现记录表';";
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($sql);
        }

    }

    /**
     * [setupOrder 订单表]
     * @Author   Dadong2g
     * @DateTime 2019-05-22T11:58:46+0800
     * @return   [type]                   [null]
     */

    public function setupOrder()
    {
        global $wpdb;
        global $order_table_name;
        if( $wpdb->get_var("SHOW TABLES LIKE '" . $order_table_name . "'") != $order_table_name ) 
        {
            $sql = " CREATE TABLE `" . $order_table_name . "` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `order_trade_no` varchar(50) DEFAULT NULL COMMENT '本地订单号',\r\n                  `order_price` double(10,2) DEFAULT NULL COMMENT '订单价格',\r\n                  `order_type` enum('charge','other') NOT NULL DEFAULT 'charge' COMMENT '充值 其他',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',\r\n                  `pay_type` tinyint(3) DEFAULT '0' COMMENT '支付类型；0无；1支付宝；2微信',\r\n                  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',\r\n                  `pay_trade_no` varchar(50) DEFAULT NULL COMMENT '商户订单号',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 未支付；1已支付；-1失效',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `order_trade_no_index` (`order_trade_no`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=" . DB_CHARSET . " COMMENT='在线充值订单表';";
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($sql);
        }

    }

    public function setupPaylog()
    {
        global $wpdb;
        global $paylog_table_name;
        if( $wpdb->get_var("SHOW TABLES LIKE '" . $paylog_table_name . "'") != $paylog_table_name ) 
        {
            $sql = " CREATE TABLE `" . $paylog_table_name . "` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `post_id` int(11) DEFAULT NULL COMMENT '关联文章ID',\r\n                  `order_trade_no` varchar(50) DEFAULT NULL COMMENT '本地订单号',\r\n                  `order_price` double(10,2) DEFAULT NULL COMMENT '文章价格',\r\n                  `order_amount` double(10,2) DEFAULT NULL COMMENT '实际扣除金额',\r\n                  `order_type` enum('post','other') NOT NULL DEFAULT 'post' COMMENT '文章资源 其他',\r\n                  `order_sale` float(2,1) DEFAULT '0.0' COMMENT 'VIP折扣',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',\r\n                  `pay_type` tinyint(3) DEFAULT '0' COMMENT '支付类型；0无；1余额；2其他',\r\n                  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 无；1已购买；-1失效',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `post_id_index` (`post_id`),\r\n                  KEY `user_id_index` (`user_id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=" . DB_CHARSET . " COMMENT='文章资源购买表';";
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($sql);
        }

    }

    /**
     * [setupCoupon 优惠券-卡密表]
     * @Author   Dadong2g
     * @DateTime 2019-05-22T12:36:10+0800
     * @return   [type]                   [description]
     */

    public function setupCoupon()
    {
        global $wpdb;
        global $coupon_table_name;
        if( $wpdb->get_var("SHOW TABLES LIKE '" . $coupon_table_name . "'") != $coupon_table_name ) 
        {
            $sql = " CREATE TABLE `" . $coupon_table_name . "` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `code` varchar(32) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '优惠码',\r\n                  `code_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0 无 1 直减 2折扣',\r\n                  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',\r\n                  `end_time` int(11) DEFAULT '0' COMMENT '到期时间',\r\n                  `apply_time` int(11) DEFAULT '0' COMMENT '使用时间',\r\n                  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态：0未使用 1已使用',\r\n                  `sale_money` double(10,2) DEFAULT '0.00' COMMENT '优惠金额',\r\n                  `sale_float` float(2,1) DEFAULT '0.0' COMMENT '折扣',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `code_index` (`code`) COMMENT '优惠码索引'\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=" . DB_CHARSET . " COMMENT='优惠券';";
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($sql);
        }

    }

    /**
     * [setupBalanceLog 用户消费记录表]
     * @Author   Dadong2g
     * @DateTime 2019-06-02T15:54:14+0800
     * @return   [type]                   [description]
     */

    public function setupBalanceLog()
    {
        global $wpdb;
        global $balance_log_table_name;
        if( $wpdb->get_var("SHOW TABLES LIKE '" . $balance_log_table_name . "'") != $balance_log_table_name ) 
        {
            $sql = " CREATE TABLE `" . $balance_log_table_name . "` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `old` double(10,2) DEFAULT NULL COMMENT '原始余额',\r\n                  `apply` double(10,2) DEFAULT NULL COMMENT '操作金额',\r\n                  `new` double(10,2) DEFAULT NULL COMMENT '新余额',\r\n                  `type` enum('charge','post','cdk','other') NOT NULL DEFAULT 'charge' COMMENT '类型：充值 资源 卡密 其他',\r\n                  `time` int(11) DEFAULT '0' COMMENT '操作时间',\r\n                  `note` varchar(255) DEFAULT NULL COMMENT '说明备注',\r\n                  PRIMARY KEY (`id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=" . DB_CHARSET . " COMMENT='消费记录表';";
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($sql);
        }

    }

    /**
     * [install 创建数据库]
     * @Author   Dadong2g
     * @DateTime 2019-05-22T12:45:53+0800
     * @return   [type]                   [description]
     */

    public function install()
    {
        $this->setupOrder();
        $this->setupCoupon();
        $this->setupPaylog();
        $this->setupBalanceLog();
        $this->setupRefLog();
    }

}


/**
 * 商城类ShopOrder
 * @by dadong2g
 */

class ShopOrder
{
    /**
     * [__construct 初始化属性]
     * @Author   Dadong2g
     * @DateTime 2019-05-14T21:20:46+0800
     * @param    [type]                   $user_id [用户ID]
     */

    public function __construct()
    {
    }

    /**
     * [addOrder 添加订单充值订单]
     * @Author   Dadong2g
     * @DateTime 2019-06-03T03:42:46+0800
     * @param    [type]                   $user_id   [用户ID]
     * @param    [type]                   $trade_no  [本地订单号]
     * @param    [type]                   $type      [订单类型 ： charge,other 充值 其他]
     * @param    [type]                   $price     [订单价格]
     * @param    [type]                   $payMethod [支付方式：1支付宝；2微信]
     */

    public function add($user_id, $trade_no, $type, $price, $payMethod)
    {
        global $wpdb;
        global $order_table_name;
        $params = array( "user_id" => $user_id, "order_trade_no" => $trade_no, "order_type" => $type, "order_price" => $price, "create_time" => time(), "pay_type" => $payMethod );
        $insert = $wpdb->insert($order_table_name, $params, array( "%d", "%s", "%s", "%s", "%s", "%d" ));
        return ($insert ? true : false);
    }

    public function get($out_trade_no)
    {
        global $wpdb;
        global $order_table_name;
        $data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $order_table_name . " WHERE order_trade_no = %s AND status = 0 ", $out_trade_no));
        return $data;
    }

    /**
     * [checkOrder 检测订单状态]
     * @Author   Dadong2g
     * @DateTime 2019-05-14T21:19:22+0800
     * @param    [type]                   $orderNum [订单号]
     * @return   [type]                             [bool]
     */

    public function check($orderNum)
    {
        global $wpdb;
        global $order_table_name;
        $isPay = 0;
        if( isset($orderNum) ) 
        {
            $isPay = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $order_table_name . " WHERE order_trade_no = %s AND status = 1 ", $orderNum));
            return $isPay && 0 < $isPay;
        }

        return $isPay && 0 < $isPay;
    }

    /**
     * [updateOrder 更新订单状态]
     * @Author   Dadong2g
     * @DateTime 2019-05-14T21:19:56+0800
     * @param    [type]                   $orderNum [订单号]
     * @param    [type]                   $payNum   [支付流水号]
     * @return   [type]                             [bool]
     */

    public function update($orderNum, $payNum)
    {
        global $wpdb;
        global $order_table_name;
        $time = time();
        $update = $wpdb->update($order_table_name, array( "pay_trade_no" => $payNum, "pay_time" => $time, "status" => 1 ), array( "order_trade_no" => $orderNum ), array( "%s", "%s", "%d" ), array( "%s" ));
        return ($update ? true : false);
    }

}


/**
 * Paylog // paylog
 */

class PostPay
{
    public $user_id = NULL;
    public $post_id = NULL;

    public function __construct($user_id, $post_id)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
    }

    public function add($price, $sale)
    {
        if( !chechkBenActivip() ) 
        {
            //return false;
        }

        global $wpdb;
        global $paylog_table_name;
        $out_trade_no = date("ymdhis") . mt_rand(100, 999) . mt_rand(100, 999) . mt_rand(100, 999);
        if( $sale == 0 ) 
        {
            $amount = 0;
        }
        else
        {
            if( $sale == 1 ) 
            {
                $amount = $price;
            }
            else
            {
                if( 0 < $sale && $sale < 1 ) 
                {
                    $amount = sprintf("%0.2f", $price * $sale);
                }
                else
                {
                    $amount = $price;
                }

            }

        }

        $params = array( "user_id" => $this->user_id, "post_id" => $this->post_id, "order_trade_no" => $out_trade_no, "order_price" => $price, "order_amount" => $amount, "order_type" => "post", "order_sale" => $sale, "create_time" => time(), "pay_type" => 1 );
        $insert = $wpdb->insert($paylog_table_name, $params, array( "%d", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%d" ));
        if( $insert ) 
        {
            return $params;
        }

        return false;
    }

    public function update($orderNum)
    {
        if( !chechkBenActivip() ) 
        {
            return false;
        }

        global $wpdb;
        global $paylog_table_name;
        $time = time();
        $update = $wpdb->update($paylog_table_name, array( "pay_time" => $time, "status" => 1 ), array( "order_trade_no" => $orderNum ), array( "%s", "%d" ), array( "%s" ));
        return ($update ? true : false);
    }

    public function isPayPost()
    {
        if( !chechkBenActivip() ) 
        {
            return false;
        }

        global $wpdb;
        global $paylog_table_name;
        $isPay = 0;
        $isPay = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $paylog_table_name . " WHERE user_id = %d AND post_id = %d AND status = 1 ", $this->user_id, $this->post_id));
        return $isPay && 0 < $isPay;
    }

    public function get_pay_ids($user_id)
    {
        global $wpdb;
        global $paylog_table_name;
        $sql = "SELECT post_id FROM " . $paylog_table_name . " WHERE 1=1 ";
        $sql .= "AND user_id='" . $user_id . "' AND status =1 ";
        $sql .= "ORDER BY id DESC";
        $results = $wpdb->get_results($sql, "ARRAY_A");
        $_post_id = array(  );
        foreach( $results as $item ) 
        {
            array_push($_post_id, $item["post_id"]);
        }
        return $_post_id;
    }

}


/**
 * 卡密优惠券类库 
 */

class CaoCdk
{
    /**
     * [addCdk 添加优惠码]
     * @Author   Dadong2g
     * @DateTime 2019-05-22T11:02:47+0800
     * @param    [type]                   $sale_money [优惠金额]
     * @param    [type]                   $day        [有效天数]
     * @param    [type]                   $num        [生成数量]
     * @return   [type]                               [bool]
     */

    public function addCdk($sale_money, $day, $num)
    {
        global $wpdb;
        global $coupon_table_name;
        $i = 0;
        while( $i < $num ) 
        {
            $create_time = time();
            $end_time = $create_time + $day * 24 * 60 * 60;
            $params = array( "code" => $this->str_code_rand($length = 12), "code_type" => 1, "create_time" => $create_time, "end_time" => $end_time, "apply_time" => 0, "status" => 0, "sale_money" => sprintf("%0.2f", $sale_money), "sale_float" => 1 );
            $insCoupon = $wpdb->insert($coupon_table_name, $params, array( "%s", "%d", "%s", "%s", "%s", "%s", "%s", "%s" ));
            $i++;
        }
        return ($i ? true : false);
    }

    /**
     * [checkCdk 检测优惠码 返回价格]
     * @Author   Dadong2g
     * @DateTime 2019-05-22T11:35:10+0800
     * @param    [type]                   $code [优惠码]
     * @return   [type]                         [优惠金额]
     */

    public function checkCdk($code)
    {
        global $wpdb;
        global $coupon_table_name;
        $sale_money = 0;
        if( isset($code) ) 
        {
            $coupon = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $coupon_table_name . " WHERE code = %s ", $code));
            if( $coupon && $coupon->status == 0 && time() < $coupon->end_time && $coupon->apply_time == 0 ) 
            {
                return $coupon->sale_money;
            }

        }

        return $sale_money;
    }

    /**
     * [updataCdk 更新优惠码*使用作废优惠码]
     * @Author   Dadong2g
     * @DateTime 2019-05-22T11:13:47+0800
     * @param    [type]                   $code [优惠码]
     * @return   [type]                         [bool]
     */

    public function updataCdk($code)
    {
        global $wpdb;
        global $coupon_table_name;
        $update = $wpdb->update($coupon_table_name, array( "apply_time" => time(), "status" => 1 ), array( "code" => $code ), array( "%s", "%d" ), array( "%s" ));
        return ($update ? true : false);
    }

    /**
     * [str_code_rand 计算优惠码]
     * @Author   Dadong2g
     * @DateTime 2019-05-22T11:12:06+0800
     * @param    integer                  $length [长度]
     * @param    string                   $char   [预设字符串]
     * @return   [type]                           [生产的字符串]
     */

    public function str_code_rand($length = 12, $char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
    {
        if( !is_int($length) || $length < 0 ) 
        {
            return false;
        }

        $string = "";
        $i = $length;
        while( 0 < $i ) 
        {
            $string .= $char[mt_rand(0, strlen($char) - 1)];
            $i--;
        }
        return $string;
    }

}


/**
 * 用户VIP设置
 */

class CaoUser
{
    private $uid = NULL;

    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    /**
     * [user_status 获取用户账户状态]
     * @Author   Dadong2g
     * @DateTime 2019-05-31T20:32:56+0800
     * @return   [type]                   [description]
     */

    public function user_status()
    {
        $ban = get_user_meta($this->uid, "cao_banned", true);
        if( $ban ) 
        {
            $reason = get_user_meta($this->uid, "cao_banned_reason", true);
            return array( "banned" => true, "banned_reason" => strval($reason) );
        }

        return array( "banned" => false );
    }

    /**
     * [vip_end_time 会员到期时间]
     * @Author   Dadong2g
     * @DateTime 2019-05-31T20:33:39+0800
     * @return   [type]                   [description]
     */

    public function vip_end_time()
    {
        $end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
        if( $end_date ) 
        {
            $time = strtotime($end_date);
            return date("Y-m-d", $time);
        }

        return date("Y-m-d", time());
    }

    /**
     * [vip_status 是否会员权限]
     * @Author   Dadong2g
     * @DateTime 2019-05-31T20:12:35+0800
     * @return   [type]                   [description]
     */

    public function vip_status()
    {
        $vip_type = get_user_meta($this->uid, "cao_user_type", true);
        $vip_end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
        $this_time = time();
        $end_time = strtotime($vip_end_date);
        if( $vip_type == "vip" && $this_time < $end_time ) 
        {
            return true;
        }

        return false;
    }

    public function update_vip_pay($days)
    {
        if( empty($days) && $days < 0 ) 
        {
            return false;
        }

        $days = (int) $days;
        $vip_end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
        $the_time = time();
        $end_time = strtotime($vip_end_date);
        if( $the_time < $end_time ) 
        {
            $new_end_time = $end_time + $days * 24 * 3600;
        }
        else
        {
            $new_end_time = $the_time + $days * 24 * 3600;
        }

        $new_user_type = "vip";
        $nwe_end_data = date("Y-m-d", $new_end_time);
        update_user_meta($this->uid, "cao_vip_end_time", $nwe_end_data);
        update_user_meta($this->uid, "cao_user_type", $new_user_type);
        return true;
    }

    /**
     * [vip_name 获取当前用户级别名称]
     * @Author   Dadong2g
     * @DateTime 2019-05-31T20:26:19+0800
     * @return   [type]                   [description]
     */

    public function vip_name()
    {
        $site_no_vip_name = _cao("site_no_vip_name");
        $site_vip_name = _cao("site_vip_name");
        $vip_type = get_user_meta($this->uid, "cao_user_type", true);
        if( $vip_type && $vip_type == "vip" ) 
        {
            return $site_vip_name;
        }

        return $site_no_vip_name;
    }

    /**
     * [get_balance 获取用户的余额]
     * @Author   Dadong2g
     * @DateTime 2019-05-31T17:14:48+0800
     * @return   [type]                            [int]
     */

    public function get_balance()
    {
        return sprintf("%0.2f", get_user_meta($this->uid, "cao_balance", true));
    }

    /**
     * [get_consumed_balance 获取用户已经消费的余额]
     * @Author   Dadong2g
     * @DateTime 2019-05-31T17:27:15+0800
     * @return   [type]                   [int]
     */

    public function get_consumed_balance()
    {
        return sprintf("%0.2f", get_user_meta($this->uid, "cao_consumed_balance", true));
    }

    /**
     * [update_balance 更新用户余额(添加-消费)]
     * @Author   Dadong2g
     * @DateTime 2019-05-31T17:42:37+0800
     * @param    integer                  $amount [金额 +1 / -1]
     * @return   [type]                           [description]
     */

    public function update_balance($amount = 0)
    {
        $before_balances = $this->get_balance();
        if( 0 < $amount ) 
        {
            update_user_meta($this->uid, "cao_balance", sprintf("%0.2f", $before_balances + $amount));
        }
        else
        {
            if( $amount < 0 ) 
            {
                if( $before_balances + $amount < 0 ) 
                {
                    return false;
                }

                $before_consumed = get_user_meta($this->uid, "cao_consumed_balance", true);
                update_user_meta($this->uid, "cao_consumed_balance", sprintf("%0.2f", $before_consumed - $amount));
                update_user_meta($this->uid, "cao_balance", sprintf("%0.2f", $before_balances + $amount));
            }

        }

        return true;
    }

}


/**
 * 消费记录
 */

class Caolog
{
    /**
     * [addlog 添加新纪录]
     * @Author   Dadong2g
     * @DateTime 2019-06-02T16:07:10+0800
     * @param    [type]                   $user_id [用户ID]
     * @param    [type]                   $old     [原始金额]
     * @param    [type]                   $apply   [操作金额]
     * @param    [type]                   $new     [新金额]
     * @param    [type]                   $type    [类型：充值 资源 卡密 其他]
     * @param    [type]                   $note    [备注说明]
     */

    public function addlog($user_id, $old, $apply, $new, $type, $note)
    {
        global $wpdb;
        global $balance_log_table_name;
        $create_time = time();
        $params = array( "user_id" => $user_id, "old" => $old, "apply" => $apply, "new" => $new, "type" => $type, "time" => $create_time, "note" => $note );
        $ins = $wpdb->insert($balance_log_table_name, $params, array( "%d", "%s", "%s", "%s", "%s", "%s", "%s" ));
        return ($ins ? true : false);
    }

}


/**
 * 提现记录
 */

class Reflog
{
    private $uid = NULL;

    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    /**
     * [用户 添加提现申请 添加新纪录]
     */

    public function addlog($money, $note)
    {
        global $wpdb;
        global $ref_log_table_name;
        $money = (int) $money;
        $create_time = time();
        $params = array( "user_id" => $this->uid, "money" => $money, "create_time" => $create_time, "note" => $note );
        $ins = $wpdb->insert($ref_log_table_name, $params, array( "%d", "%s", "%s", "%s" ));
        return ($ins ? true : false);
    }

    public function updatelog($id, $status = 0)
    {
        global $wpdb;
        global $ref_log_table_name;
        $this_log = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $ref_log_table_name . " WHERE id = %d ", $id));
        if( !$this_log ) 
        {
            return false;
        }

        $update = $wpdb->update($ref_log_table_name, array( "up_time" => time(), "status" => $status ), array( "id" => $id ), array( "%s", "%d" ), array( "%d" ));
        return ($update ? true : false);
    }

    public function get_ref_num()
    {
        global $wpdb;
        global $ref_log_table_name;
        $ref_num = $wpdb->get_var($wpdb->prepare("SELECT COUNT(user_id) FROM " . $wpdb->usermeta . " WHERE meta_key=%s AND meta_value=%s", "cao_ref_from", $this->uid));
        return $_num = ($ref_num ? (int) $ref_num : 0);
    }

    public function get_total_bonus()
    {
        return sprintf("%0.2f", get_user_meta($this->uid, "cao_total_bonus", true));
    }

    public function get_ke_bonus()
    {
        global $wpdb;
        global $ref_log_table_name;
        $get_total_bonus = $this->get_total_bonus();
        $get_ing_bonus = $this->get_ing_bonus();
        $get_yi_bonus = $this->get_yi_bonus();
        return sprintf("%0.2f", $get_total_bonus - $get_ing_bonus - $get_yi_bonus);
    }

    public function get_ing_bonus()
    {
        global $wpdb;
        global $ref_log_table_name;
        $sqls = $wpdb->get_var($wpdb->prepare("SELECT SUM(money) FROM " . $ref_log_table_name . " WHERE user_id=%d AND status=0", $this->uid));
        return sprintf("%0.2f", $sqls);
    }

    public function get_yi_bonus()
    {
        global $wpdb;
        global $ref_log_table_name;
        $sqls = $wpdb->get_var($wpdb->prepare("SELECT SUM(money) FROM " . $ref_log_table_name . " WHERE user_id=%d AND status=1", $this->uid));
        return sprintf("%0.2f", $sqls);
    }

    public function add_total_bonus($amount)
    {
        $amount = sprintf("%0.2f", $amount);
        $get_total_bonus = $this->get_total_bonus();
        if( 0 < $amount ) 
        {
            update_user_meta($this->uid, "cao_total_bonus", sprintf("%0.2f", $get_total_bonus + $amount));
            return true;
        }

        return false;
    }

}

function chechkBenActivip()
{
    $token = _the_theme_name() . _cao("ripro_vip_id", "");
    $get_option = get_option($token);
    $alen = strlen($get_option);
    if( !empty($get_option) && 10 <= $alen ) 
    {
        return true;
    }

    return false;
}

function chechkToActivip()
{
	return ['status'=>1];
    $api_domain = "https://www.soku.cc";
    $api_url = "/wp-content/plugins/ripro-auth/api/v1.php";
    $url = $api_domain . $api_url;
    $body = array( "site" => get_bloginfo("name"), "version" => _the_theme_version(), "domain" => get_bloginfo("url"), "email" => get_bloginfo("admin_email"), "user_id" => _cao("ripro_vip_id", ""), "user_token" => _cao("ripro_vip_code", "") );
    $response = curlPost($url, $body);
    return json_decode($response, true);
}

function ripro_options_save_after()
{
    $token = _the_theme_name() . _cao("ripro_vip_id", "");
	update_option($token, $token);
	return true;
	/*
    $bdcheck = chechkbenactivip();
    if( $bdcheck ) 
    {
        update_option($token, $token);
    }
    else
    {
        $chechk = chechktoactivip();
        if( !empty($chechk) && $chechk["status"] == 1 ) 
        {
            update_option($token, $token);
        }
        else
        {
            echo "<script>alert('" . $chechk["msg"] . "');</script>";
        }

    }
	*/
}

function jihuo_footer_notify()
{
    ob_start();
    echo "  <script>\r\n  Swal.fire({\r\n    html: '<h3>请激活您的主题授权</h3><p>RiPro主题唯一购买授权官网为：http://www.aiqiyic.cn/，其他均为盗版，传播盗版可耻，支持作者，为开发者留最后一丝动力。<br/><h5>本通知无任何恶意，仅作为静态提醒展示。</h5></p></div>',\r\n    showConfirmButton: false,\r\n    width: 560,\r\n    padding: 20,\r\n    allowOutsideClick:false,\r\n    showCloseButton: true,\r\n  })\r\n  </script>\r\n";
    echo ob_get_clean();
}

function ripro_ajax_check()
{
    header("Content-type:application/json; Charset=utf-8");
    $chechk = chechktoactivip();
    if( !empty($chechk) && $chechk["status"] == 1 ) 
    {
        echo json_encode(array( "status" => "1", "msg" => "授权正常" ));
        exit();
    }

    $token = _the_theme_name() . _cao("ripro_vip_id", "");
    update_option($token, "");
    echo json_encode(array( "status" => "0", "msg" => "授权错误" ));
    exit();
}


