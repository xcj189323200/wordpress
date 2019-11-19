<?php
/**
 * RiPro是一个优秀的主题，首页拖拽布局，高级筛选，自带会员生态系统，超全支付接口，你喜欢的样子我都有！
 * 正版唯一购买地址，全自动授权下载使用：https://vip.ylit.cc/
 * 作者唯一QQ：200933220 （油条）
 * 承蒙您对本主题的喜爱，我们愿向小三一样，做大哥的女人，做大哥网站中最想日的一个。
 * 能理解使用盗版的人，但是不能接受传播盗版，本身主题没几个钱，主题自有支付体系和会员体系，盗版风险太高，鬼知道那些人乱动什么代码，无利不起早。
 * 开发者不易，感谢支持，更好的更用心的等你来调教
 */

/**
 * payjs异步通知
 */

header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();
require_once get_stylesheet_directory() . '/inc/class/Payjs.class.php';
// 获取后台支付配置
$PayJsConfig = _cao('payjs');
// 配置通信参数
$config = [
    'mchid' => $PayJsConfig['mchid'],   // 配置商户号
    'key'   => $PayJsConfig['key'],   // 配置通信密钥
];
// 初始化 PAYJS
$payjs = new Payjs($config);

// 接收异步通知,无需关注验签动作,已自动处理
$notify_info = $payjs->notify();

if ($notify_info && is_array($notify_info) && $notify_info['attach'] == 'payjs_order_attach') {
    
    //商户本地订单号
    $out_trade_no = $notify_info['out_trade_no'];
    //交易号
    $trade_no = $notify_info['payjs_order_id'];

    // 处理本地业务逻辑
    if ($notify_info['transaction_id']) {

        // 验证通过 获取基本信息
        $ShopOrder = new ShopOrder();
        $order     = $ShopOrder->get($out_trade_no);
        // 是否有效订单 && 订单类型为充值
        if ($order && $order->order_type == 'charge') {
            // 实例化用户信息
            $CaoUser = new CaoUser($order->user_id);
            // 计算充值数量
            $charge_rate  = (int) _cao('site_change_rate'); //充值比例
            $old_money    = $CaoUser->get_balance(); //用户原来余额
            $charge_money = sprintf('%0.2f', $order->order_price * $charge_rate); // 实际充值数量

            //更新用户余额信息
            if ($CaoUser->update_balance($charge_money)) {
                // 写入记录
                $Caolog    = new Caolog();
                $new_money = $old_money + $charge_money; //充值后金额
                $note      = '支付宝-在线充值 [￥' . $order->order_price . '] +' . $charge_money;
                $Caolog->addlog($order->user_id, $old_money, $charge_money, $new_money, 'charge', $note);
                //更新订单状态
                $ShopOrder->update($out_trade_no, $trade_no);
                //发放佣金 查找推荐人
                add_to_user_bonus($order->user_id,$charge_money);
                //发送邮件
                $obj_user = get_user_by('ID', $order->user_id);
                _sendMail($obj_user->user_email, '支付成功', $note);
            }
        }
        echo 'success';exit();
    } else {
        // 输出错误日志 可以在生产环境关闭 注释即可
        echo "error";exit();
    }
    exit();


}
echo "error";exit();