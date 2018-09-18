<?php
$url = $_GET['s'];

$imgType = array(
    1 => '.gif',
    2 => '.jpg',
    3 => '.png',
    6 => '.bmp',
    18 => '.webp',
);
$imgExt = exif_imagetype($url);
$fileName = './img/' . md5($url) . $imgType[$imgExt];

if (!file_exists($fileName)) {
    $fh = fopen($fileName, 'wb');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);//设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回，而不是直接输出
    curl_setopt($curl, CURLOPT_REFERER, '');//模拟来路（如：https://mp.weixin.qq.com）
    curl_setopt($curl, CURLOPT_FILE, $fh);//保存图片
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //https请求不验证证书和hosts
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)"); //模拟浏览器代理
    $data = curl_exec($curl);
    curl_close($curl);
    fclose($fh);
}

//图片上传云存储/FTP，请自行实现


header('Location:' . $fileName);