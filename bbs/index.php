<?
$type=$_GET[type];
$data=$_GET[data];
if ($type=='board'){
	if(strpos($data,'/')){ 
		$data_1 = explode('/',$data);
		$_REQUEST[bo_table] = $data_1[0];
		if(strpos($data_1[1],'@')){
			$data_2 = explode('@',$data_1[1]);
			$_REQUEST[wr_id] = $data_2[0];
			$_REQUEST[page] = $data_2[1];
		}else{
			$_REQUEST[wr_id] = $data_1[1];
		}
	}elseif(strpos($data,'@')){
		$data_1 = explode('@',$data);
		$_REQUEST[bo_table] = $data_1[0];
		$_REQUEST[page] = $data_1[1];
	}else{
		$_REQUEST[bo_table] = $data;
	}
	include_once('board.php');
} else if ($type=='group') {
	$_REQUEST[gr_id]=$data;
	include "group.php";
} else if ($type=='write') {
	if(strpos($data,'/')){ 
		$data_1 = explode('/',$data);
		$_REQUEST[bo_table] = $data_1[0];
		if(strpos($data_1[1],'@')){
			$data_2 = explode('@',$data_1[1]);
			$_REQUEST[wr_id] = $data_2[0];
			$_REQUEST[page] = $data_2[1];
		}else{
			$_REQUEST[wr_id] = $data_1[1];
		}
	}elseif(strpos($data,'@')){
		$data_1 = explode('@',$data);
		$_REQUEST[bo_table] = $data_1[0];
		$_REQUEST[page] = $data_1[1];
	}else{
		$_REQUEST[bo_table] = $data;
	}
	include "write.php";
}