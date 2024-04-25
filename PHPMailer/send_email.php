<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 引入PHPMailer库
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// 从环境变量读取SMTP配置
$smtpUsername = getenv('SMTP_USERNAME') ?: '289170334@qq.com';
$smtpPassword = getenv('SMTP_PASSWORD') ?: 'vrxuclfsbvtubgej';

// 变量定义
$senderName = 'xulong';

// 定义函数，用于验证和清理用户输入
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// 获取并清理表单数据
$name = validateInput($_POST['name']);
$tel = validateInput($_POST['tel']);
$email = validateInput($_POST['email']);
$message = validateInput($_POST['message']);

// 创建新的PHPMailer实例
$mail = new PHPMailer(true);

try {
    // 配置SMTP
    //$mail->SMTPDebug = 2; // 启用调试模式
    $mail->isSMTP(); // 使用SMTP
    $mail->Host = 'smtp.qq.com'; // SMTP服务器
    $mail->SMTPAuth = true; // 启用SMTP认证
    $mail->Username = $smtpUsername; // SMTP用户名
    $mail->Password = $smtpPassword; // SMTP密码
    $mail->SMTPSecure = 'ssl'; // 使用SSL
    $mail->Port = 465; // SMTP端口

    // 设置发件人和收件人
    $mail->setFrom($smtpUsername, $senderName);
    $mail->addAddress($smtpUsername, $senderName); // 添加收件人
    $mail->addReplyTo($smtpUsername, $senderName); // 添加回复地址

    // 配置邮件内容
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body = "Name: $name<br>Tel: $tel<br>Email: $email<br>Message: $message";

    // 发送邮件
    $mail->send();
    $response['success'] = true;
    $response['message'] = 'Message has been sent';
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Message could not be sent. Error: ' . $e->getMessage();
}

header('Content-type: application/json');
echo json_encode($response);
?>
