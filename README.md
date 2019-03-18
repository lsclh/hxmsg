##华信云短信发送

>创建对象
```
userid=>企业ID account=>发送用户帐号 password=>发送接口密码
$msg = new Postmsg(['userid'=>'12','account'=>'12','password'=>'123']);
//手机号多个用,隔开
//内容 需要在后台报备再去发送  如 '【守农庄园】您的验证码为1234，请在5分钟之内完成！'
$msg->send('手机号','内容');
```