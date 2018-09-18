<?php
$url = $_POST['url'];
if (!$url) {
    exit;
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //https请求不验证证书和hosts
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");
$data = curl_exec($curl);
curl_close($curl);


$data = str_replace("\r\n", "", $data);


preg_match_all("/id=\"js_content\">([\s\S]*?)<\/div>/i", $data, $res);
$pos_con = $res[1][0];
$pos_con = str_replace('data-src="', 'src="img.php?s=', $pos_con);

if ($_POST['zm'] == 1) {//标签替换
    $pos_con = preg_replace('/<section[^>]*>/', "<p>$2", $pos_con);
    $pos_con = preg_replace('/<\/section>/', "</p>", $pos_con);
    $pos_con = preg_replace('/<img(.*?)src="(.*?)"(.*?)>/', "<img src=\"$2\" />", $pos_con);
}


?>

<h3>源代码：</h3>
<textarea style="width:100%;height:500px;">
    <?php echo $pos_con; ?>
</textarea>

<hr/>
<h3>渲染：</h3>
<?php echo $pos_con; ?>

