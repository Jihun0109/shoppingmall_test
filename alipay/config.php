<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017083108478465",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCLrmq1qLKvC/R9PGskpGjRcpcvQ6rHtwbXVQeHLuUATUtdnSH8eoXFMiK8mCGucrg8dd+xo3s78ayTsNIoyjzS8qOlp5ccjN5rCOQ1cWNC+Hc5UqHpINcyz0YoVlqpBRY/4Zj1tZhUbRmRYjXMFp6keZNJtDqLfOhkwTbLO8/oJXm79XtdGwOBbRn6MmLTphcssBkVyF4eKjGIjOTx6LqvoJxb6qWXQG1XYutYoBhfV1qfppjSJy9BY4Y+fwU658B3O/ZX/JiQTfjrEWULYaVthMusBRdChyN/rGkDNr4PKFFbK8DhF80H+Batb7eVuvgnZeltz8wa3lrog1syPA5DAgMBAAECggEAAQBxN3hMP8EgMb27LvoW3lmqB+a+VMxVOjob4bZOYiAryDIWSk8+ollnsl6M70lXVOergQShH57uE+kSuMQqh4DB97Ap/0RrW+0mZdO4WISbpkeXbaqUoIKoCCYGZGvq6u5dQHXa79AQfOBtbldDL/7HNaIbQWDV8dMI55A4P3vyhM9RqOtsMOvpyi7Wz6s4HflTbO1sIUjlc7rbcJHvYhTrz7UT7M+gBACAJg9jgun/QkwasyP+EjtqJIvEZ8HrWECeeolJeJ0+njIPsVWz7xlYsL50BTf1WNTToL7d0ZyuU4wpPKFG1fkoOr6+w/in5On1WW0Nw4EqKOtqLJ8zsQKBgQDzm0bxS20+UtlPzmbMfMhXEIePA3nu6tglC1o/aeTlcNDYv9AU6Ac2xl7u9pAadDHPs8qM99ZrbPqWYx02z/ZGtps7eajaUE8s8JlcOwDxwC5lRrIU9//4J9XdBEy9rJnGbKkXVoiyxbBK2gJjDcbJ2AdMujnD6VxuvIH34NItfwKBgQCSyZ8IThfsNiVgc1nAjDp2eQ64xq245FPTgEwnejGcluJXa7ACCeK0C9UPr6i8ZFVhXX//MRZeZZM3xru0iC3hJfVNTZHVLiz325jGsR2PSpj3O048NMCY8EEN3N/jzQrDdDyEEnMR89mpBQG//NSppGuKhIYiCLIJiewYIdJJPQKBgFy1MklwCBIY24ToquyVbHTd4IkHrKbFDx8B9AWAGlFLHt/uF5VtPBmXYteUVAENSUufQ61kQGC/p5oF/D8446PDqM34nc7/kzIqGmMkPVbDaaS3Q9yBCRP6rQQgt8fTYO5Hug4cq4dFfrLtxszFmGqGYTjNAmDRdZDbAqdAExynAoGBAIO9FE/d1raWueDgZdLbh7TAXSgUl+FyepE9ehuMHW6ONEGFUofh22b/n47edi/uVHp38eJUaeD6hK/wWpJiDdsduBRS4+lR8eXZXjokx4TMzJBG16ZNKfWY2qnYa9AFO/3DGnTmIgQguF5rMfDetvYxrJq66a8t4quQ7yWRZSt5AoGAEu0V+tncM1ACBaWRgO+BlntPU05Zh5KhKX6tzxv6N0YaLBIEU+U7R5VFMyKYBzTKOeZJIF0Suyj9RjRaMp9hxyCSoPPmxhtq6jhL6mduX84LBdDvVPCDz7VlY6hi2+ND3Vs3U841KoPfSxDAxiSoVyWL5sqgrKi3rt/k6GhEmxU=",
		
		//异步通知地址
		'notify_url' => "http://fyq.shengtai114.com/alipay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://fyq.shengtai114.com/alipay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnvB7UcwsxZICwoBYRBJAZMYI5p1bPeKYxHb3d86VB5T+y8sxGPimlPFfhDJqEmehFznkUd/8YKbpDDLGX7hdnNJMhODJ4mkQ+gfuHZtPqJjU7HhiLONcRUH+T6T74riAxOsB/ULT99eprBBRW0tJMSPgBkn8qevOmmhNgg1Z8uUwA9hwFUdsu63Y7yHknYSeio0HW3FUJwvmJAqVusC0wZPQ6CWCcwzUjobM9kNlsjTal9+3x+5g4P4i+RXvd1Mxnyrw9Drr7iM60yiaXe6B4HVYtx4ed5ZqYoD082fSPdxhKDYpVJVAjBU0LUmMBFzcEyWd8Kswzdrnlpf/BVAy3QIDAQAB",
		
	
);