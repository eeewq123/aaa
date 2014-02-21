<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/head.php');
    return;
}

// 상단 파일 경로 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($config['cf_include_head']) {
    if (!@include_once($config['cf_include_head'])) {
        die('기본환경 설정에서 상단 파일 경로가 잘못 설정되어 있습니다.');
    }
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}
?>

<!-- 상단 시작 { -->
    <div class="navbar navbar-default navbar-fixed-top">

	  <div class="container">
        <div class="navbar-header">
          <a href="<?php echo G5_URL ?>" class="navbar-brand">GNUBOARD5</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">        

          <ul class="nav navbar-nav navbar-right">
            <?php if ($is_member) {  ?>
            <?php if ($is_admin) {  ?>
            <li>
                <a href="<?php echo G5_ADMIN_URL ?>">                    
                    관리자
                </a>
            </li>
            <?php }  ?>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">                    
                    내 정보
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/logout.php">                    
                    로그아웃
                </a>
            </li>
            <?php } else {  ?>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/register.php">                    
                    회원가입
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/login.php">                    
                    로그인
                </a>
            </li>
            <?php }  ?>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/current_connect.php">                    
                    접속자 <?php echo connect(); // 현재 접속자수  ?>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/new.php">
                    새글
                </a>
            </li>
          </ul>

        </div>
      </div>
    </div>

    <div class="container add_container" >        

	<div class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-top">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo G5_URL ?>">Home</a>
			</div>
			<div class="navbar-collapse collapse navbar-inverse-collapse"  id="navbar-top">
				<ul class="nav navbar-nav">
					<!--
					<li class="active"><a href="#">Active</a></li>
					-->
					<?php
					$sql = " select * from {$g5['group_table']} where gr_show_menu = '1' and gr_device <> 'mobile' order by gr_order ";
					$result = sql_query($sql);
					for ($gi=0; $row=sql_fetch_array($result); $gi++) { // gi 는 group index
					 ?>
					<li class="dropdown">
						<a href="<?php echo G5_BBS_URL ?>/group.php?gr_id=<?php echo $row['gr_id'] ?>" class="dropdown-toggle" data-toggle="dropdown">
							<?php echo $row['gr_subject'] ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<?php
							$sql2 = " select * from {$g5['board_table']} where gr_id = '{$row['gr_id']}' and bo_show_menu = '1' and bo_device <> 'mobile' order by bo_order ";
							$result2 = sql_query($sql2);
							for ($bi=0; $row2=sql_fetch_array($result2); $bi++) { // bi 는 board index
							 ?>
							<li>
								<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row2['bo_table'] ?>">
									<?php echo $row2['bo_subject'] ?>
								</a>
							</li>
							<?php } ?>
						</ul>
					</li>
					<?php } ?>
					<?php if ($gi == 0) {  ?><li >생성된 메뉴가 없습니다.</li><?php }  ?>
					<!--
					원본 주석 참고하세요 dropdown menu
					<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li><a href="#">Action</a></li>
                          <li><a href="#">Another action</a></li>
                          <li><a href="#">Something else here</a></li>
                          <li class="divider"></li>
                          <li class="dropdown-header">Dropdown header</li>
                          <li><a href="#">Separated link</a></li>
                          <li><a href="#">One more separated link</a></li>
                        </ul>
                      </li>
					 -->
				</ul>
				<form _lpchecked="1" name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);" class="navbar-form navbar-left" _lpchecked="1">        
					<input type="hidden" name="sfl" value="wr_subject||wr_content">
					<input type="hidden" name="sop" value="and">              
					 <input type="text" name="stx" class="form-control col-lg-8" placeholder="Search">
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#">Drop No.1</a></li>
						<li><a href="#">Drop No.2</a></li>
						<li><a href="#">Drop No.3</a></li>
						<li class="divider"></li>
						<li><a href="#">Separated link</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.nav-collapse -->
		</div><!-- /.container -->
	</div>

		<!-- left -->
        <div class="col-lg-3">
            <?php echo outlogin('boot_basic'); // 외부 로그인  ?>            
			<div class="visible-lg" >
              <form class="navbar-form " _lpchecked="1" name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">        
              <div class="input-group">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <span class="input-group-addon">Total</span>
                <input type="text" name="stx" maxlength="20" class="form-control" type="text">                            
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">검색</button>
                </span>
              </div>
              </form>              
		  </div>

			<div class="visible-lg" >
			<?php include_once (G5_PATH."/bootstrap/include/new_reaction.php");?>
			<?php include_once (G5_PATH."/bootstrap/include/new_list.php");?>
			<?php include_once (G5_PATH."/bootstrap/include/new_comment.php");?>
			<?php include_once (G5_PATH."/bootstrap/include/new_topic.php");?>
            <?//php echo poll('basic'); // 설문조사  ?>
			</div>
		</div>
		<!-- body-->
		<div class="col-lg-9" >        

