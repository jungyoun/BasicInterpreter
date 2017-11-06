<?
function in_basic($text,$err=true)
{
	unset($GLOBALS["ev_if_start"]);
	unset($GLOBALS["ev_for_start"]);
	unset($GLOBALS["ev_for_next"]);
	unset($GLOBALS["ev_gosub"]);
	unset($GLOBALS["ev_text_buf"]);
	unset($GLOBALS["loop_break"]);
	unset($GLOBALS["ev_print_start_text"]);
	unset($GLOBALS["ev_exe_line"]);
	unset($GLOBALS["ev_total_line"]);
	unset($GLOBALS["ev_error_view"]);
	unset($GLOBALS["ev_view_line"]);
	unset($GLOBALS["ev_total_line"]);
	unset($GLOBALS["ev_dim"]);
	$GLOBALS["ev_error_view"]=$err; //에러를 표시할껀지 말껀지
	$GLOBALS["ev_view_line"]= split("\n","\n".$text);
	//맨처음에 \n이 들어가야지 실행이 된다.시간이 없어서 패스-0-
	//아직 왜그런지는 모른다. 
	//괜히 첫째줄 비워놓고 테스트해오다가 말도안되는 버그만들어놨다;;
	$GLOBALS["ev_total_line"]=count($GLOBALS["ev_view_line"]);
	for($i2=0;$i2<$GLOBALS["ev_total_line"];$i2++)
		{
			$tmp_index=trim($GLOBALS["ev_view_line"][$i2]);
			if ((ord($tmp_index[0])>47 & ord($tmp_index[0])<58) & strlen($tmp_index)>0)
				{
				if (strpos($tmp_index," ")!==false)
					{
						$ib_txt_cmd_1= substr($tmp_index,0,strpos($tmp_index," "));
					}else{
						$ib_txt_cmd_1= $tmp_index;
					}
				$GLOBALS["ev_index"][$ib_txt_cmd_1]=$i2;
				$tmp_index_2=substr(trim($GLOBALS["ev_view_line"][$i2]),strlen($ib_txt_cmd_1)+1);
				$GLOBALS["ev_view_line"][$i2]=trim($tmp_index_2);
			}
		}

	for($GLOBALS["ev_exe_line"]=0;$GLOBALS["ev_exe_line"]<$GLOBALS["ev_total_line"];$GLOBALS["ev_exe_line"]++){
	if (trim($GLOBALS["ev_view_line"][$GLOBALS["ev_exe_line"]])<>""){

	ib_w_cut($GLOBALS["ev_view_line"][$GLOBALS["ev_exe_line"]]);
	}
	}
	unset($GLOBALS["ev_if_start"]);
	unset($GLOBALS["ev_for_start"]);
	unset($GLOBALS["ev_for_next"]);
	unset($GLOBALS["ev_gosub"]);
	unset($GLOBALS["ev_text_buf"]);
	unset($GLOBALS["loop_break"]);
	unset($GLOBALS["ev_print_start_text"]);
	unset($GLOBALS["ev_exe_line"]);
	unset($GLOBALS["ev_total_line"]);
	unset($GLOBALS["ev_error_view"]);
	unset($GLOBALS["ev_view_line"]);
	unset($GLOBALS["ev_total_line"]);
	unset($GLOBALS["ev_dim"]);
	//return true;

}
function ib_if_bl($ib_txt)
{


$ib_txt=trim($ib_txt);
if ($ib_txt[0]=="("){$ib_txt=substr($ib_txt,1);}
if ($ib_txt[strlen($ib_txt)-1]==")"){$ib_txt=substr($ib_txt,0,strlen($ib_txt)-1);}
$exe_chk=array('=<','>=','=','<','>',' and ',' or ');
$exe_chk_2=array(' <= ',' >= ',' = ',' < ',' > ',' & ',' | ');

$tmp_ib_txt = str_replace($exe_chk,$exe_chk_2,trim($ib_txt));

while(1){
if (strpos($tmp_ib_txt,'  ')===false){break;}
$tmp_ib_txt = str_replace('  ',' ',$tmp_ib_txt);
}

$text_sp= split(" ",trim($tmp_ib_txt));
$p=count($text_sp);
if ($text_sp!==false) {
for($i=0;$i<$p;$i++)
{	
	if ($text_sp[$i]=='=' | $text_sp[$i]=='<' | $text_sp[$i]=='>')
	{	
		$tmp_buf_2.=$text_sp[$i];
	}else{
		if (strpos($text_sp[$i],'"')===false){
			$tmp_sp=ib_exe_print_work($text_sp[$i]);
			if ($tmp_sp==""){
			$tmp_buf_2.='0';
			}else{
			$tmp_buf_2.=$tmp_sp;
			}
		}else{

			$tmp_buf_2.=ib_exe_var($text_sp[$i]);
		}
	}
}

$tmp= 'if ('.$tmp_buf_2.')
	{
	$tmp2= true;
	}else{
	$tmp2= false;
	}';
eval($tmp);
}
return $tmp2;
}
function ib_w_cut($text)
{
ib_cmd($text);
}
function ib_exe($ib_cmd,$ib_txt)
{

	$ib_cmd=strtolower($ib_cmd);
	if ($GLOBALS["ev_exe_line"]==$GLOBALS["ev_index"][$ib_cmd]){
	ib_cmd($ib_txt);
	}
	if ($ib_txt<>"")
	{
	switch($ib_cmd)
		{
		case "print":
			ib_exe_print($ib_txt);
			break;
		case "dim":

			ib_exe_dim($ib_txt);
			break;
		case "if":
			ib_exe_if($ib_txt);
			break;
		case "for":
			ib_exe_for($ib_txt);
			break;
		case "gosub":
			ib_exe_gosub($ib_txt);
			break;
		case "goto":
			ib_exe_goto($ib_txt);
			break;
		case "elseif":
			ib_exe_elseif($ib_txt);
			break;
		case "else":
			ib_exe_else();
			break;
		case "rem":
			break;
		case "end":
			if (strtolower(trim($ib_txt))=="if")
			{
			ib_exe_endif($ib_txt);
			}
			break;
		default:
			ib_cmd_2($ib_cmd,$ib_txt);
			break;
		}

	}else{
	switch($ib_cmd)
		{
		case "return":
			ib_exe_return();
			break;
		case "else":
			ib_exe_else();
			break;
		case "next":
			ib_exe_next();
			break;
		case "end":
			$GLOBALS["ev_exe_line"]=$GLOBALS["ev_total_line"];
			break;
		case "rem":
			break;
		default:
			ib_cmd_2($ib_cmd);
		break;
		}
	}
}
function ib_exe_gosub($ib_txt)
{
$GLOBALS["ev_gosub"][]=$GLOBALS["ev_exe_line"] ; //현재행을 저장
$GLOBALS["ev_exe_line"]=$GLOBALS["ev_index"][$ib_txt]-1;
}
function ib_exe_goto($ib_txt)
{
//if와 for문 안에서 goto를 사용하면 if와 for문 정보 삭제
//goto는 현재행을 저장할 필요가 없음
unset($GLOBALS["ev_if_start"]);
unset($GLOBALS["ev_for_start"]); //고투후 정보삭제
unset($GLOBALS["ev_for_next"]);
unset($GLOBALS["ev_gosub"]);
$GLOBALS["ev_exe_line"]=$GLOBALS["ev_index"][$ib_txt]-1;
}
function ib_exe_return()
{
$end_line=count($GLOBALS["ev_gosub"])-1;
$GLOBALS["ev_exe_line"]=$GLOBALS["ev_gosub"][$end_line];
@array_pop($GLOBALS["ev_gosub"]);
}


function ib_exe_for($ib_txt)
{
$tmp_ib_txt = strtolower(trim($ib_txt));
$tmp_1=trim(substr($tmp_ib_txt,0,strpos($tmp_ib_txt,"=")));
$tmp_2=ib_exe_print_work(substr($tmp_ib_txt,strpos($tmp_ib_txt,"=")+1,strpos($tmp_ib_txt," to ")-strpos($tmp_ib_txt,"=")-1));
$tmp_3=trim(substr($tmp_ib_txt,strpos($tmp_ib_txt," to ")+4));
if (strpos($tmp_3," step ")!==false){
$tmp_4=ib_exe_print_work(substr($tmp_3,strpos($tmp_3," step ")+6));
$tmp_3=trim(substr($tmp_3,0,strpos($tmp_3," step ")));
}else{
$tmp_4=1;
$tmp_3=$tmp_3;
}
$tmp_3=ib_exe_print_work($tmp_3);//
//echo "[".$tmp_1.':'.$tmp_2.":".$tmp_3.":".$tmp_4.":".$GLOBALS["ev_for_start"][count($GLOBALS["ev_for_start"])-1]."]<br>";
if ($GLOBALS["ev_exe_line"]==$GLOBALS["ev_for_start"][count($GLOBALS["ev_for_start"])-1]){
	$GLOBALS["ev_dim"][strtolower($tmp_1)]=$GLOBALS["ev_dim"][strtolower($tmp_1)]+$tmp_4;
	if ($GLOBALS["ev_dim"][strtolower($tmp_1)]>=$tmp_3){
	ib_exe_for_next();
	}
}else{
	$GLOBALS["ev_dim"][strtolower($tmp_1)]=$tmp_2;
	$GLOBALS["ev_for_start"][]=$GLOBALS["ev_exe_line"];
}
}

function ib_exe_next()
{
if ($GLOBALS["ev_for_next"][count($GLOBALS["ev_for_next"])-1]<>$GLOBALS["ev_exe_line"])
	{
	$GLOBALS["ev_for_next"][]=$GLOBALS["ev_exe_line"];
	}
	$GLOBALS["ev_exe_line"]=$GLOBALS["ev_for_start"][count($GLOBALS["ev_for_start"])-1]-1;
}
function ib_exe_for_next()
{
		
		$GLOBALS["ev_exe_line"]=$GLOBALS["ev_for_next"][count($GLOBALS["ev_for_next"])-1];

		@array_pop($GLOBALS["ev_for_start"]);
		@array_pop($GLOBALS["ev_for_next"]);
}


function ib_exe_if_next()
{
$tmp_exe_if==0;
for($i2=$GLOBALS["ev_exe_line"]+1;$i2<$GLOBALS["ev_total_line"];$i2++)
	{
$tmp_if_str=trim($GLOBALS["ev_view_line"][$i2]);

		if (strtolower(substr($tmp_if_str,0,2))=="if")
		{
		//$GLOBALS["ev_if_start"][]=$i2;

		if ( (strpos(strtolower($tmp_if_str),' then')+5)==strlen($tmp_if_str))
			{
			$tmp_exe_if++;
			}
		}elseif (strtolower(substr($tmp_if_str,0,4))=="else"){
		if ($tmp_exe_if==0){
		$GLOBALS["ev_exe_line"]=$i2;
		break; //이곳에 elseif문 처리를 해준다.-수정요
		}
		}elseif (strtolower(substr($tmp_if_str,0,6))=="end if"){
		
		if ($tmp_exe_if==0){
		$GLOBALS["ev_exe_line"]=$i2;
		ib_exe_endif();
		break;
		}
		$tmp_exe_if--;
		}
	}
	//참 거짓값에 따라서 다음 end if나 elseif나 else를 찾는다.
$GLOBALS["ev_exe_line"]=$i2;
}

function ib_exe_if($ib_txt)
{
//조건에 맞으면 else나 end if elseif 나올때까지 계속실행하다 저 새개를 만나면
//조건에 맞지 않으면 else나 elseif를 찾아간다.
//else의 경우엔 그 행부터 다음 end if elseif 가 나올때까지 무시
//※한줄에 코딩한것은 제외(따로처리)
$tmp_ib_txt = $ib_txt;
$exe_chk=array('=<','=>');
$exe_chk_2=array('<=','>=');
$tmp_ib_txt = str_replace($exe_chk,$exe_chk_2,$tmp_ib_txt);
$ib_txt_tmp_1=strpos(strtolower($tmp_ib_txt)," then")+5;

if ($ib_txt_tmp_1<strlen(trim($tmp_ib_txt))){
$tmp_ib_txt_2=trim(substr($tmp_ib_txt,$ib_txt_tmp_1));
$tmp_ib_pos=strpos(strtolower(trim($tmp_ib_txt_2)), 'else ');
if ($tmp_ib_pos!==false)
		{
		if ($tmp_ib_pos>=0){
		$tmp_ib_txt_true=trim(substr($tmp_ib_txt_2,0,$tmp_ib_pos));
		}
		$tmp_ib_txt_false=trim(substr($tmp_ib_txt_2,$tmp_ib_pos+5));
		}else{
		$tmp_ib_txt_true=trim(substr($tmp_ib_txt,$ib_txt_tmp_1,$ib_txt_tmp_1));
		}

if (ib_if_bl(substr($tmp_ib_txt,0,$ib_txt_tmp_1-5))===true) //한줄용
	{
	//실행하기
	ib_cmd($tmp_ib_txt_true);
	}else{
	//뒤에 else가 있는지 확인
	ib_cmd($tmp_ib_txt_false);
	}
}else{

$GLOBALS["ev_if_start"][]=$GLOBALS["ev_exe_line"] ; //현재행을 저장
if (ib_if_bl(substr($tmp_ib_txt,0,$ib_txt_tmp_1-5))===false)
	{
	//else,elseif,endif찾기
	ib_exe_if_next();

	}
}
}
function ib_exe_elseif($ib_txt)
{
$ib_txt_tmp_1=strpos($ib_txt,"THEN")+5;
$end_line=count($GLOBALS["ev_if_start"])-1;
if ($ib_txt_tmp_1<strlen($ib_txt)){
}else{
$GLOBALS["ev_if_start"][$end_line]=$GLOBALS["ev_exe_line"] ; //현재행을 저장 //수정필요
//elseif는 다시한번 조건을 분석한다.단,$GLOBALS["ev_if_start"]에는 마지막 정보를 담은곳에 덮어쒸운다.
//이 부분과 ib_exe_if와 다른점은 맨 마지막 정보에 덮어쒸운다는것이다. 
}
}

function ib_exe_endif()
{
@array_pop($GLOBALS["ev_if_start"]);
}
function ib_exe_else()
{
ib_exe_if_next();
}
function ib_echo($ib_txt,$run=false)
{
if ($run===true){

echo $GLOBALS["ev_text_buf"].$ib_txt;
$GLOBALS["ev_text_buf"]="";
}else{
$GLOBALS["ev_text_buf"].=$ib_txt;
}
}
function ib_exe_dim($ib_txt)
{

$text_sp= split(",",trim($ib_txt));
$line=count($text_sp);
for($i=0;$i<$line;$i++){
if (trim($text_sp[$i])<>""){
$ib_txt_tmp_1=strpos($text_sp[$i],"=");
if ($ib_txt_tmp_1!==false){
$ib_txt_cmd_1= substr($text_sp[$i],0,$ib_txt_tmp_1);
$ib_txt_cmd_2= trim(substr($text_sp[$i],strlen($ib_txt_cmd_1)+1,strlen($text_sp[$i])-strlen($ib_txt_cmd_1)-1));

$GLOBALS["ev_dim"][strtolower(trim($ib_txt_cmd_1))]=ib_exe_var($ib_txt_cmd_2);
}else{
$ib_txt_cmd_1 =$text_sp[$i];
$GLOBALS["ev_dim"][strtolower($ib_txt_cmd_1)]="";
}
}
}

}
function ib_exe_print_work($ib_txt)
{
$tmp_ib_txt = trim(str_replace("\\",'',$ib_txt));
$exe_chk=array('<','>','/','*','mod','^','-','\\','+','(',')',',',';');
$exe_chk_2=array(' ',' ',' / ',' * ',' % ',' ^ ',' - ',' \\ ',' + ',' ( ',' ) ',' ; ',' ; ');
$tmp_ib_txt = str_replace($exe_chk,$exe_chk_2,$ib_txt);
while(1){
if (strpos($tmp_ib_txt,'  ')===false){break;}
$tmp_ib_txt = str_replace('  ',' ',$tmp_ib_txt);
}
$tmp_ib_txt = trim($tmp_ib_txt);
$text_sp= split(" ",$tmp_ib_txt);
$line=count($text_sp);
if ($line>1) {
for($i=0;$i<$line;$i++)
{	

	//'<','>','/','*','mod','^','-','\\','+','(',')',',',';'
	if ((ord($text_sp[$i][0])>47 & ord($text_sp[$i][0])<58) | $text_sp[$i]=='<' | $text_sp[$i]=='>' | $text_sp[$i]=='/' | $text_sp[$i]=='*' | $text_sp[$i]=='%' | $text_sp[$i]=='^' | $text_sp[$i]=='-' | $text_sp[$i]=='\\' | $text_sp[$i]=='+' | $text_sp[$i]=='(' | $text_sp[$i]==')' | $text_sp[$i]==';')
	{

	}else{
	$text_sp[$i] = $GLOBALS["ev_dim"][strtolower($text_sp[$i])];
	}
}
$tmpz_2=join('',$text_sp);
$tmpz=ib_eval($tmpz_2);
}else{
if (ord($tmp_ib_txt[0])>47 & ord($tmp_ib_txt[0])<58){
$tmpz= $tmp_ib_txt;
}else{
if ($GLOBALS["ev_dim"][strtolower($tmp_ib_txt)]==""){
	$tmpz= "";
}else{
	$tmpz= $GLOBALS["ev_dim"][strtolower($tmp_ib_txt)];
}
}
}


return $tmpz;
}
function ib_eval($ib_txt)
{
if (trim($ib_txt)==""){return;}
$tmp=trim(stripslashes($ib_txt));
if (strpos($tmp,';')!==false)
	{
		if (trim($tmp)<>';'){

		$tmp_sp=split(";",trim($tmp));
		$tmp_line=count($tmp_sp);
		for($i3=0;$i3<$tmp_line;$i3++)
		{	
			eval("\$tmp_join[]=$tmp_sp[$i3];");
		}

		$tmp=join(' ',$tmp_join);
		}
	}else{
		
		eval("\$tmp=$tmp;");
	}
return $tmp;
}
function ib_on_errer($ib_num)
{
if ($GLOBALS["ev_error_view"]===true){
ib_echo('<br>ERROR : '.$ib_num.' <b>line '.$GLOBALS["ev_exe_line"].'</b><br>',true);
}
//0으로 나눌수 없습니다.
}
function ib_exe_var($ib_txt)
{
	//이곳에서 스트링이 아닌 부분에서 ":" 문자가 나올때 그부분을 중심으로 나눠준다.(아직안됨)


$ib_txt=trim($ib_txt);

$GLOBALS["ev_print_start_text"]=false;
if ($ib_txt=='""'){return "";}//수정 따옴표 처리 - 보충해야함 "를 제거하고 trim했을때 비어있는지 확인해야됨.
if (strpos($ib_txt," ")===false & strpos($ib_txt,'"')===false & strpos($ib_txt,'+')===false & strpos($ib_txt,'-')===false & strpos($ib_txt,'*')===false & strpos($ib_txt,'/')===false & strpos($ib_txt,'%')===false & strpos($ib_txt,';')===false & strpos($ib_txt,',')===false){
if (ord($ib_txt[0])>47 & ord($ib_txt[0])<58)
	{
		return $ib_txt;
	}else{
		return $GLOBALS["ev_dim"][strtolower($ib_txt)];
	}
}

$ib_tmp_1=strlen($ib_txt);
	for($i=0;$i<$ib_tmp_1;$i++)
	{

		if ($ib_txt[$i] == '"' & $ib_txt[$i-1].$ib_txt[$i] <> '\"')
		{
			if ($GLOBALS["ev_print_start_text"]===false)
			{	
				$ib_txt_buf_work=substr($ib_txt,$tmp_st,$tmp_strlen);
				if (trim($ib_txt_buf_work)<>""){

				$return_tmp.=ib_exe_print_work($ib_txt_buf_work);
				$ib_txt_buf_work="";
				}
				$GLOBALS["ev_print_start_text"]=$i;	
				$tmp_st=$i;
				$tmp_strlen=0;
			}else{
				$ib_txt_buf=substr($ib_txt,$GLOBALS["ev_print_start_text"]+1,$i-$GLOBALS["ev_print_start_text"]-1);
				$return_tmp.=stripslashes($ib_txt_buf);
				$GLOBALS["ev_print_start_text"]=false;
				$tmp_st=$i+1;
			}
		}else{
			if ($GLOBALS["ev_print_start_text"]===false)
			{	
				$tmp_strlen++;
			}
			
		}
	}

	if ($tmp_strlen>0){

		$return_tmp.=ib_exe_print_work(substr($ib_txt,$tmp_st,$tmp_strlen));
		$ib_txt_buf_work="";
	}
$GLOBALS["ev_print_start_text"]=false;
return $return_tmp;
}
function ib_exe_print($ib_txt)
{
ib_echo(ib_exe_var($ib_txt),true);
}
function ib_cmd_2($ib_cmd,$ib_txt="")
{

	$tmp_cmd_txt=$ib_cmd.$ib_txt;
	$ib_txt_tmp_1=strpos($tmp_cmd_txt,'=');	
		if ($ib_txt_tmp_1>0)
			{
			$ib_txt_cmd_1= substr($tmp_cmd_txt,0,$ib_txt_tmp_1);
			$tmp_txt=trim($ib_txt_cmd_1);
			//if (strpos($tmp_txt,' ')===false){
			
			//$ib_txt_cmd_2= trim(substr($ib_txt,strlen($ib_txt_cmd_1)+1,strlen($ib_txt)-strlen($ib_txt_cmd_1)));

				ib_exe('dim',$tmp_cmd_txt);
			//}
			
			}
}
function ib_cmd($ib_txt)
{
$GLOBALS["loop_break"]++;
if ($GLOBALS["loop_break"]>2000){$GLOBALS["ev_exe_line"]=$GLOBALS["ev_total_line"];echo "<br>작업이 많습니다.강제 중단!<br>";return true;}
$ib_txt=trim($ib_txt);
$ib_txt_tmp_1=strpos($ib_txt," ");
if ($ib_txt_tmp_1>0){
$ib_txt_cmd_1= substr($ib_txt,0,$ib_txt_tmp_1);
$ib_txt_cmd_2= trim(substr($ib_txt,strlen($ib_txt_cmd_1)+1,strlen($ib_txt)-strlen($ib_txt_cmd_1)));
}else{
$ib_txt_cmd_1= trim($ib_txt);
}
ib_exe($ib_txt_cmd_1,$ib_txt_cmd_2);
}
?>