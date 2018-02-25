# get_session

这是获取储存在服务器SESSION内容的API，使用PHP编写。

肯定有很多人想问，这有什么用？

其实确实也没什么用，只是我自己在做web项目的时候，使用了session，调试的过程中想要看到session中实时的数据储存了些什么？是否储存正确？

于是这个API就诞生了，主要也就是用来调试的吧！在浏览器里面安装一个名为 _`JSON_handle`_ 的插件，可以非常美观地将显示在浏览器上的json转为树形，方便查看。

都知道调试网页可以用浏览器的检查源代码，里面的console功能很强大，可以在里面查看当前的sessionID，刚好可以配合这个API使用。

😜Enjoy yourself! 😝

-----

# API安装方式

运行基本环境：_`PHP`_

* Linux主机

> * 1) 若根目录完全安装，运行下面命令`clone`此代码文件：
>
> _`git clone git@github.com:DavidDengHui/get_session.git`_
>
> * 2) 若是安装到现有网站目录，`cd`定位到网站根目录，运行下面命令：
>
> _`wget https://github.com/DavidDengHui/get_session/raw/master/sess.php`_
>
>
> 看到目录下产生`sess.php`文件即可

* Windows主机

> * 1) 若根目录完全安装，下载下面文件后解压：
>
> _`https://github.com/DavidDengHui/get_session/archive/master.zip`_
>
> * 2) 若是安装到现有网站目录，下载下面文件到网站根目录：
>
> _`https://github.com/DavidDengHui/get_session/raw/master/sess.php`_
>
>
> 看到目录下产生`sess.php`文件即可

修改 _`sess.php`_ 源码中开头的`$base_folder_int`和`$auth_key`适配自己主机，其分别的含义：

`$base_folder_int` 	= '`本地主机储存SESSION文件的地址`';

`$auth_key`			= '`定义通过此API强行修改内容的密钥`';

至此完成安装，可通过域名访问 _`sess.php`_

-----

# API使用方式

* 调用地址：http(s)://{domain}/sess.php

* 测试地址：`https://sess.covear.top/sess.php`

* 请求方式：`GET`

* 返回类型：`JSON`

* 所有请求参数组合

	<table>
	<tr>
		<th style="text-align:center;">优先级</th>
		<th style="text-align:center;">名称</th>
		<th style="text-align:center;">类型</th>
		<th style="text-align:center;" colspan="3">组合</th>
	</tr>
	<tr>
		<td style="text-align:center;">1</td>
		<td style="text-align:center;">ssid</td>
		<td style="text-align:center;">string</td>
		<td style="text-align:center;">√</td>
		<td style="text-align:center;">√</td>
		<td style="text-align:center;"></td>
	</tr>
	<tr>
		<td style="text-align:center;">2</td>
		<td style="text-align:center;">reset</td>
		<td style="text-align:center;">string</td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;">√</td>
		<td style="text-align:center;"></td>
	</tr>
	<tr>
		<td style="text-align:center;">2</td>
		<td style="text-align:center;">auth</td>
		<td style="text-align:center;">string</td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;">√</td>
		<td style="text-align:center;"></td>
	</tr>
	<tr>
		<td style="text-align:center;">2</td>
		<td style="text-align:center;">old</td>
		<td style="text-align:center;">string</td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;">√</td>
		<td style="text-align:center;"></td>
	</tr>
	<tr>
		<td style="text-align:center;">2</td>
		<td style="text-align:center;">new</td>
		<td style="text-align:center;">string</td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;">√</td>
		<td style="text-align:center;"></td>
	</tr>
	<tr>
		<td style="text-align:center;">3</td>
		<td style="text-align:center;">where</td>
		<td style="text-align:center;">string</td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;">√</td>
	</tr>
	<tr>
		<td style="text-align:center;">3</td>
		<td style="text-align:center;">whval</td>
		<td style="text-align:center;">string</td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;">√</td>
	</tr>
	<tr>
		<td style="text-align:center;" colspan="3"><b>mode</b></td>
		<td style="text-align:center;">view</td>
		<td style="text-align:center;">reset</td>
		<td style="text-align:center;">search</td>
	</tr>
	<tr>
		<td style="text-align:center;" colspan="3"><b>功能</b></td>
		<td style="text-align:center;">查看</td>
		<td style="text-align:center;">修改</td>
		<td style="text-align:center;">搜索</td>
	</tr>
	</table>

## 根据sessionID获取session内容

* 请求示例(PHP)

```php
<?php
	$host = "https://sess.covear.top"; //API的域名
	$path = "/sess.php"; //请求文件地址
	$method = "GET"; //请求方式
	$ssid = "u5l6pqvgpo1o43v8ksud6pq8me" //要查看的session的sessionID
	$querys = "ssid=".$ssid;
	$url = $host . $path . "?" . $querys;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_FAILONERROR, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	if (1 == strpos("$".$host, "https://")) {
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	}
	$data = curl_exec($curl); //获取返回的json数据
	var_dump($data);
?>
```

* 请求示例(Java)

	```java
	public static void main(String[] args) {
	    String host = "https://sess.covear.top";
	    String path = "/sess.php";
	    String method = "GET";
	    Map<String, String> querys = new HashMap<String, String>();
	    querys.put("ssid", "u5l6pqvgpo1o43v8ksud6pq8me");
	    try {
	    	HttpResponse response = HttpUtils.doGet(host, path, method, querys);
	    	System.out.println(response.toString());
	    } catch (Exception e) {
	    	e.printStackTrace();
	    }
	}
	```

* 请求示例(url访问)
	
	[`https://sess.covear.top/sess.php?ssid=u5l6pqvgpo1o43v8ksud6pq8me`](https://sess.covear.top/sess.php?ssid=u5l6pqvgpo1o43v8ksud6pq8me)


* 正常返回示例

	```json
	{
		"status": "success",
		"mode": "view",
		"ssid": "u5l6pqvgpo1o43v8ksud6pq8me",
		"where": {
			"key": null,
			"value": null
		},
		"reset": {
			"key": null,
			"old": null,
			"new": null
		},
		"data": {
			"0": {
				"tms_sid": [
					"201730403122"
				],
				"session_id": "u5l6pqvgpo1o43v8ksud6pq8me"
			},
			"size": 1
		}
	}
	```

* 错误返回示例

	```json
	{
		"status": "error",
		"mode": "view",
		"ssid": "u5l6pqvgpo1o43v8ksud6pq8me",
		"where": {
			"key": null,
			"value": null
		},
		"reset": {
			"key": null,
			"old": null,
			"new": null
		},
		"data": {
			"size": 0
		}
	}
	```

## 强行更改session的指定部分内容

```php
<?php
	$host = "https://sess.covear.top"; //API的域名
	$path = "/sess.php"; //请求文件地址
	$method = "GET"; //请求方式
	$ssid = "43p7oreo1mrumraj7d9oro7u48" //要修改的session的sessionID
	$reset = "tms_phone" //要修改的键值
	$old = "18173304062"; //要修改的内容
	$new = "12345678901"; //替换的新内容
	$auth = "001000001000"; //源码中设置的鉴权密钥
	$querys = "ssid=".$ssid."&reset=".$reset."&old=".$old."&new=".$new."&auth=".$auth;
	$url = $host . $path . "?" . $querys;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_FAILONERROR, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	if (1 == strpos("$".$host, "https://")) {
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	}
	$data = curl_exec($curl); //获取返回的json数据
	var_dump($data);
?>
```

* 请求示例(url访问)
	
	[`https://sess.covear.top/sess.php?ssid=43p7oreo1mrumraj7d9oro7u48&reset=tms_phone&old=18173304062&new=12345678901&auth=001000001000`](https://sess.covear.top/sess.php?ssid=43p7oreo1mrumraj7d9oro7u48&reset=tms_phone&old=18173304062&new=12345678901&auth=001000001000)


* 正常返回示例

	```json
	{
		"status": "success",
		"mode": "reset",
		"ssid": "43p7oreo1mrumraj7d9oro7u48",
		"where": {
			"key": null,
			"value": null
		},
		"reset": {
			"key": "tms_phone",
			"old": "18173304062",
			"new": "12345678901"
		},
		"data": {
			"0": {
				"tms_sid": [
					"201700000003"
				],
				"tms_name": [
					"Test_miandmo"
				],
				"tms_college": [
					"铁道通信与信号学院"
				],
				"tms_class": [
					"铁道通信171班"
				],
				"tms_auth": [
					"7"
				],
				"tms_depart": [
					"0"
				],
				"tms_head": [
					"https://tools.hnrwi.cn/images/default_head.png"
				],
				"tms_phone": [
					"12345678901"
				],
				"history": [
					"https://tools.hnrwi.cn/",
					"https://tools.hnrwi.cn/google.php"
				],
				"session_id": "43p7oreo1mrumraj7d9oro7u48"
			},
			"size": 1
		}
	}
	```

* 错误返回示例

	```json
	{
		"status": "error",
		"mode": "reset",
		"ssid": "43p7oreo1mrumraj7d9oro7u48",
		"where": {
			"key": null,
			"value": null
		},
		"reset": {
			"key": "tms_phone",
			"old": "18173304062",
			"new": "12345678901"
		},
		"data": {
			"size": 0
		}
	}
	```

## 根据键名和键值搜索session内容

```php
<?php
	$host = "https://sess.covear.top"; //API的域名
	$path = "/sess.php"; //请求文件地址
	$method = "GET"; //请求方式
	$where = "tms_sid"; //要搜索的键名
	$whval = "201700000003"; //要搜索的键值
	$querys = "where=" . $where . '&whval=' . $whval;
	$url = $host . $path . "?" . $querys;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_FAILONERROR, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	if (1 == strpos("\$" . $host, "https://")) {
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	}
	$data = curl_exec($curl); //获取返回的json数据
	var_dump($data);
?>
```

* 请求示例(url访问)
	
	[`https://sess.covear.top/sess.php?where=tms_sid&whval=201700000003`](https://sess.covear.top/sess.php?where=tms_sid&whval=201700000003)


* 正常返回示例

	```json
	{
		"status": "success",
		"mode": "search",
		"ssid": null,
		"where": {
			"key": "tms_sid",
			"value": "201700000003"
		},
		"reset": {
			"key": null,
			"old": null,
			"new": null
		},
		"data": {
			"0": {
				"tms_sid": [
					"201700000003"
				],
				"tms_name": [
					"Test_miandmo"
				],
				"tms_college": [
					"铁道通信与信号学院"
				],
				"tms_class": [
					"铁道通信171班"
				],
				"tms_auth": [
					"7"
				],
				"tms_depart": [
					"0"
				],
				"tms_head": [
					"https://tools.hnrwi.cn/images/default_head.png"
				],
				"tms_phone": [
					"18173304062"
				],
				"history": [
					"https://tools.hnrwi.cn/",
					"https://tools.hnrwi.cn/google.php"
				],
				"session_id": "43p7oreo1mrumraj7d9oro7u48"
			},
			"size": 1
		}
	}
	```

* 错误返回示例

	```json
	{
		"status": "error",
		"mode": "search",
		"ssid": null,
		"where": {
			"key": "tms_sid",
			"value": "201700000003"
		},
		"reset": {
			"key": null,
			"old": null,
			"new": null
		},
		"data": {
			"size": 0
		}
	}
	```

-----

___Copyright © 2018 David Deng___