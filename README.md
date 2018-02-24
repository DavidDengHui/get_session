# get_session

这是获取储存在服务器SESSION内容的API
使用PHP编写，现可完成三种功能——

源码中开头的`$base_folder_int`和`$auth_key`可修改适配自己主机，
其分别的含义：
`$base_folder_int` 	= '`本地主机储存SESSION文件的地址`';
`$auth_key`			= '`定义通过此API强行修改内容的密钥`';

## 根据sessionID获取session内容

## 根据键名和键值搜索session内容

## 强行更改session的指定部分内容

Copyright © 2017-2018 David Deng