<?php
header('content-type:text/html charset:utf-8');
include("include/ImageCrop.php");
ini_set('memory_limit', '-1');
$dir_base = "upload/"; //文件上传根目录
$file_name = @$_GET['file_name'];
$file_name_p = @$_POST['file_name'];
//没有成功上传文件，报错并退出。
if(empty($_FILES)) {
	echo "{$dir_base}error.jpg";
	exit(0);
}
$index = 0;	//$_FILES 以文件name为数组下标，不适用foreach($_FILES as $index=>$file)
foreach($_FILES as $file){
	$upload_file_name = 'upload_file'.$index;//对应index.html FomData中的文件命名
	$filename = $_FILES[$upload_file_name]['name'];
	$filename = time().rand(10000,9999999).strrchr($filename,".");
	$gb_filename = iconv('utf-8','gb2312',$filename);	//名字转换成gb2312处理
	//文件不存在才上传
	if(!file_exists($dir_base.$gb_filename)) {
		$isMoved = false;  //默认上传失败
		$MAXIMUM_FILESIZE = 200 * 1024 * 1024; 	//文件大小限制	1M = 1 * 1024 * 1024 B;
		$rEFileTypes = "/^\.(jpg|jpeg|gif|png|jfif|mp4|JPG|PNG|GIF|MP4){1}$/i"; 
		if ($_FILES[$upload_file_name]['size'] <= $MAXIMUM_FILESIZE && 
			preg_match($rEFileTypes, strrchr($gb_filename, '.'))) {	
			$isMoved = move_uploaded_file ( $_FILES[$upload_file_name]['tmp_name'], $dir_base.$gb_filename);		//上传文件
		}
	}else{
		$isMoved = true;//已存在文件设置为上传成功
	}
	if($isMoved){
		//输出图片文件<img>标签
		//注：在一些系统src可能需要urlencode处理，发现图片无法显示，
		//    请尝试 urlencode($gb_filename) 或 urlencode($filename)，不行请查看HTML中显示的src并酌情解决。
		$output = "{$filename}";
	}else {
		$output = "{$dir_base}error.jpg";
	}
	$index++;
}

if ($_GET['imgtype'] == "186_106") {
	$img_width = "186";
	$img_height = "106";
}
if ($_GET['imgtype'] == "750_350") {
	$img_width = "750";
	$img_height = "350";
}
if ($_GET['imgtype'] == "300_300") {
	$img_width = "300";
	$img_height = "300";
}
if ($_GET['imgtype'] == "100_100") {
	$img_width = "100";
	$img_height = "100";
}
if ($_GET['imgtype'] == "702_200") {
	$img_width = "702";
	$img_height = "200";
}
if ($_GET['imgtype'] !== "nosize") {
	$ic=new ImageCrop("upload/".$output,"upload/compress/".$output);
	$ic->Crop($img_width,$img_height,1);
	$ic->SaveImage();
	$ic->destory();
}

echo $output;