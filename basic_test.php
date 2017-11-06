<?
include "in_basic_dev.php";
function mtime(){$time=explode( " ", microtime());$usec=(double)$time[0];$sec=(double)$time[1];return $sec + $usec; } 
function mtime_diff($ts,$te){return sprintf("%2.3f" ,$te - $ts);} 
function mtime_diff_2($ts,$te){return sprintf("%2.7f" ,$te - $ts);} 
$tmp_source2='
DIM H,e="",c,d
print "<br><b>GOTO문을 이용한 세모그리기</b><br><br>"
f=20
d=0
2000 H=H+1
d=c+1
c=0
if (H>f) then
	goto 30
else
	15 if (c>=d) then
		print "<br>"
		goto 17
	end if
		print " *"
		c=c+1
end if
	goto 15
17 END IF
goto 2000
30 print "<br>Made By <a href=http://www.story4u.co.kr>Hwang Jung-youn</a><br>"
print e
end
';
$tmp_source='
DIM i,a,i2,i3
print "<br><b>FOR문을 이용한 세모그리기</b><br><br>"
a=0
a2=0
FOR i=0 to 10
	a2=a2+1
	FOR i2=0 to a2
		print " *"
	NEXT
	PRINT "<br>"
NEXT
print "<br>Made By <a href=http://www.story4u.co.kr>Hwang Jung-youn</a><br>"
end
';
$conv_name=array('"','<','>',"\t");
$conv_value=array('&quot;','&lt;','&gt;','&nbsp;&nbsp;&nbsp;&nbsp;');


$tmp_s_2 = str_replace($conv_name,$conv_value,$tmp_source);
echo "<br><br>--- 원본소스 ---<br><br>".str_replace("\n",'<br>',$tmp_s_2)."<br><br>";
$t_start = mtime();
in_basic($tmp_source);
echo "<br><br>스크립트 실행시간 : " .mtime_diff($t_start, mtime())."초<br><br>";

$tmp_s_2 = str_replace($conv_name,$conv_value,$tmp_source2);
echo "<br><br>--- 원본소스 ---<br><br>".str_replace("\n",'<br>',$tmp_s_2)."<br><br>";
$t_start = mtime();
in_basic($tmp_source2);
echo "<br><br>스크립트 실행시간 : " .mtime_diff($t_start, mtime())."초<br><br>";
/*
DIM H,e="",c,d
f=20
2000 H=H+1
d=c+1
c=0
if (H>=f) then
	goto 30
else
	15 if (c>=d) then
		e=e "<br>"
		goto 17
	end if
		e=e " *"
		c=c+1
end if
	a=a+1
	goto 15
17 END IF
goto 2000
30 e=e "루프 : " a
e=e "<br><br>Made By <a href=http://www.story4u.co.kr>Hwang Jung-youn</a><br>"
print e
end

DIM i,a,i2
a=0
a2=0
FOR i=a to 20
a2=a2+1
FOR i2=0 to a2
print " *"
NEXT
PRINT "<br>"
NEXT
print "<br><br>Made By <a href=http://www.story4u.co.kr>Hwang Jung-youn</a><br>"
end
*/
?>