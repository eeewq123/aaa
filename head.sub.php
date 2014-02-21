<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = $_SERVER['REQUEST_URI'];
$g5['lo_url'] = $_SERVER['REQUEST_URI'];
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
}
?>
<title><?php echo $g5_head_title; ?></title>
	<link rel="stylesheet" href="http://bootswatch.com/spacelab/bootstrap.css" media="screen">
	<link rel="stylesheet" href="http://bootswatch.com/spacelab/bower_components/font-awesome/css/font-awesome.min.css">
	<!--
	<link rel="stylesheet" href="<?php echo G5_URL?>/bootstrap/css/bootstrap.css">
	http://bootswatch.com/spacelab/ 스킨을 사용한다
	<link rel="stylesheet" href="http://bootswatch.com/spacelab/bootstrap.css" media="screen">
	<link rel="stylesheet" href="http://bootswatch.com/spacelab/bower_components/font-awesome/css/font-awesome.min.css">	 // font관련
	bootstrap의 기본 body fontsize관계로 boot_add.css에서 폰트를 강제 설정한다.
	<link rel="stylesheet" href="<?php echo G5_URL?>/bootstrap/css/bootstrap.css">
	-->
<?php
if (defined('G5_IS_ADMIN')) {
    echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/admin.css">'.PHP_EOL;
} else {
    echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').'.css">'.PHP_EOL;
?>
	<link rel="stylesheet" href="<?php echo G5_URL?>/bootstrap/css/boot_add.css" >
<?php    
}
echo '<meta http-equiv="imagetoolbar" content="no">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge">';
?>

<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo isset($config['cf_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php
if ($is_admin) {
    echo 'var g5_admin_url = "'.G5_ADMIN_URL.'";'.PHP_EOL;
}
?>
</script>
<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery.menu.js"></script>
<script src="<?php echo G5_JS_URL ?>/common.js"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js"></script>
<?php
if(G5_IS_MOBILE) {
    echo '<script> set_cookie("device_width", screen.width, 6, g5_cookie_domain); </script>'.PHP_EOL;
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
//if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>

<!-- boot strap 추가 -->
<script src="<?php echo G5_URL?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo G5_URL?>/bootstrap/js/bootswatch.js"></script>
<!-- boot strap 끝-->

</head>
<body>
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg">'.$sr_admin_msg.$member['mb_nick'].'님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}
?>