<?include "in_basic.php";
function mtime(){$time=explode( " ", microtime());$usec=(double)$time[0];$sec=(double)$time[1];return $sec + $usec; } 
function mtime_diff($ts,$te){return sprintf("%2.4f" ,$te - $ts);} 
//include '/home/hosting_users/hwangsho/www/mod/log/log.php';
//log_save('inbasic');
$conv_name=array('"','<','>',"\t",' ');
$conv_value=array('&quot;','&lt;','&gt;','&nbsp;&nbsp;&nbsp;&nbsp;','&nbsp;');
if ($_GET["page"]=="")
{
$_GET["page"]="index";
}
$inc_list["index"][0]	= "index.htm";
$inc_list["index"][1]	= "�����ϱ�";
$inc_list["run"][0]		= "run.htm";
//$inc_list["run"][0]		= "run_error.htm";
$inc_list["run"][1]		= "����";
$inc_list["func"][0]	= "func.htm";
$inc_list["func"][1]	= "func.htm";
$inc_list["ex"][0]		= "ex.htm";
$inc_list["ex"][1]		= "ex.htm";
include "head.htm";
if ($_POST["source"]<>"" & $_GET["page"]=="run")
{
$test_src = str_replace($conv_name,$conv_value,stripslashes($_POST["source"]));
echo "<b>������</b><br>--- �ҽ� ---<br><br>".str_replace("\n",'<br>',$test_src)."<br><br>--- ��� ---<p><b>RUN</b></p>";
$t_start = mtime();
in_basic("\n".stripslashes($_POST["source"]));
echo "<br><br>��ũ��Ʈ ���࿡ �ɸ��ð� : " .mtime_diff($t_start, mtime())."��<br>
���� ��ũ��Ʈ �ؼ��� ���� : ".basic_ver();
}else{
$fp = fopen( $inc_list[$_GET["page"]][0], "r" );
$get_page = fread( $fp, filesize( $inc_list[$_GET["page"]][0] ) );
fclose( $fp );
echo $get_page;
}
include "foot.htm";
?>