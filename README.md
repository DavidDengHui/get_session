# get_session

这是获取储存在服务器SESSION内容的API
使用PHP编写，现可完成三种功能——

# API安装方式

主机记本需求：_`PHP`_

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

# API使用方式

* 调用地址：http(s)://{domain}/sess.php

* 测试地址：`https://sess.covear.top/sess.php`

* 请求方式：`GET`

* 返回类型：`JSON`

## 根据sessionID获取session内容

>> * 请求参数
>>
>> |  名称  |  类型  |  描述  |
>> | :-----: | :-----: | :-----: |
>> | ssid  |  string  | 要查询的sessionID  |
>
> * 请求示例(PHP)
>
> ```PHP
> <?php
>    $host = "https://sess.covear.top"; //API的域名
>    $path = "/sess.php"; //请求文件地址
>    $method = "GET"; //请求方式
>    $ssid = "u5l6pqvgpo1o43v8ksud6pq8me" //要查看的session的sessionID
>    $querys = "ssid=".$ssid;
>    $url = $host . $path . "?" . $querys;
>    $curl = curl_init();
>    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
>    curl_setopt($curl, CURLOPT_URL, $url);
>    curl_setopt($curl, CURLOPT_FAILONERROR, false);
>    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
>    curl_setopt($curl, CURLOPT_HEADER, false);
>    if (1 == strpos("$".$host, "https://")) {
>        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
>        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
>    }
>	$data = curl_exec($curl); //获取返回的json数据
>	var_dump($data);
>?>
> ```
>
> * 正常返回示例
>
> ```json
>{
>    "status": "success",
>    "mode": "view",
>    "ssid": "u5l6pqvgpo1o43v8ksud6pq8me",
>    "where": {
>        "key": null,
>        "value": null
>    },
>    "reset": {
>        "key": null,
>        "old": null,
>        "new": null
>    },
>    "data": {
>        "0": {
>            "tms_sid": [
>                "201730403122"
>            ],
>            "session_id": "u5l6pqvgpo1o43v8ksud6pq8me"
>        },
>        "size": 1
>    }
>}
> ```
>
> * 错误返回示例
>
> ```json
>{
>    "status": "error",
>    "mode": "view",
>    "ssid": "u5l6pqvgpo1o43v8ksud6pq8me",
>    "where": {
>        "key": null,
>        "value": null
>    },
>    "reset": {
>        "key": null,
>        "old": null,
>        "new": null
>    },
>    "data": {
>        "size": 0
>    }
>}
> ```

## 根据键名和键值搜索session内容


## 强行更改session的指定部分内容


Copyright © 2017-2018 David Deng