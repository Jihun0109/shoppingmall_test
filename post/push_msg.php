<?php 
include("../include/data_base.php");

if (isset($_POST['pushmsg_id'])) {
    $pushmsg_id = $_POST['pushmsg_id'];
} else {
    exit();
}

if (isset($_POST['title_push'])) {
    $title_push = $_POST['title_push'];
} else {
    exit();
}

if (isset($_POST['content_push'])) {
    $content_push = $_POST['content_push'];
} else {
    exit();
}

$opts = array(   
  'http'=>array(   
    'method'=>"GET",   
    'timeout'=>3,//单位秒  
   )   
);    

$cnt=0;   
while($cnt<10 && ($bb=file_get_contents("http://pushmsg.ydbimg.com/rest/weblsq/1.0/PushMsg.aspx?key=2647129d&appid=164964&users=".$pushmsg_id."&title=".$title_push."&msg=".$content_push."&url=http://fyq.shengtai114.com&soundid=0", false, stream_context_create($opts)))===FALSE) $cnt++;   

$pusharr = (explode(",",$pushmsg_id));
$pushleng=count($pusharr);

for($i=0;$i<$pushleng;$i++)
    {
        $pushmsg_id = $pusharr[$i];
        if (strstr($bb,'status:1')) {
            mysqli_query($mysqli,"INSERT INTO push_message (user, title, message, state) VALUES ('{$pushmsg_id}', '{$title_push}', '{$content_push}', '1')");
        } else {
            mysqli_query($mysqli,"INSERT INTO push_message (user, title, message, state) VALUES ('{$pushmsg_id}', '{$title_push}', '{$content_push}', '0')");
        }
    }
?>