<?php
require '../siteConfig.php';
require '../Utils/Bootstrap.php';

Bootstrap::SetRequiredFiles();
if (Security::Authenticate()){
	header('Location: admin.php');
}

$failed = false;
if($_POST){
	$user = UserModel::FindById(trim($_POST['id']));
	if (is_object($user)){
		if (md5($_POST['password']) == $user->getPassword()){
			Security::Authenticate($user);
			header('Location: admin.php');
		}
	}
	$failed=true;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Xml Engine &middot; Login</title>
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1" />
		<link rel="stylesheet" type="text/css" href="../resources/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../resources/css/jquery-ui-1.8.17.custom.css" />
		<link rel="stylesheet" type="text/css" href="../resources/css/style.css" />
		<script type="text/javascript" src="../resources/js/libs/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../resources/js/libs/jquery-ui-1.8.17.custom.min.js"></script>
		<script type="text/javascript" src="../resources/js/utils/Ajax.js"></script>
		<script type="text/javascript" src="../resources/js/utils/Common.js"></script>
		<script type="text/javascript" src="../resources/js/utils/Form.js"></script>
		<script type="text/javascript" src="../resources/js/utils/FormValidator.js"></script>
		<script type="text/javascript" src="../resources/js/utils/Messages.js"></script>
		<script type="text/javascript" src="../resources/js/utils/Validator.js"></script>
		<script type="text/javascript" src="../resources/js/utils/Tooltip.js"></script>
		<script type="text/javascript" src="../resources/js/utils/Pagination.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Bundle.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Language.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Log.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Metadata.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Partner.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Process.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Region.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Role.js"></script>
		<script type="text/javascript" src="../resources/js/entities/State.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Type.js"></script>
		<script type="text/javascript" src="../resources/js/entities/User.js"></script>
		<script type="text/javascript" src="../resources/js/entities/Video.js"></script>
		<script type="text/javascript" src="../resources/js/models/BundleModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/LanguageModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/LogModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/MetadataModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/PartnerModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/ProcessModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/RegionModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/RoleModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/StateModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/TypeModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/UserModel.js"></script>
		<script type="text/javascript" src="../resources/js/models/VideoModel.js"></script>
		<script type="text/javascript" src="../resources/js/views/IndexView.js"></script>
		<script type="text/javascript" src="../resources/js/views/LoginView.js"></script>
		<script type="text/javascript" src="../resources/js/views/AdminView.js"></script>
		<script type="text/javascript" src="../resources/js/controllers/IndexController.js"></script>
		<script type="text/javascript" src="../resources/js/controllers/LoginController.js"></script>
		<script type="text/javascript" src="../resources/js/controllers/AdminController.js"></script>
		<script type="text/javascript" src="../resources/js/script.js"></script>
		<link rel="icon" type="image/png" href="../resources/img/mtv1.png"/>
	</head>
	<body>
		<div id="wrapper">
			<div id="js-error" class="ui-state-error ui-corner-all">
				<p class="ui-state-error-text">
					<span class="ui-icon ui-icon-alert"></span>Oops! Something went wrong. 
					<span class="thin">Make sure you have javascript turned on. Otherwise please report it. <a href="mailto:David.Curras@mtvnmix.com">Email</a></span>
				</p>
			</div>
			<div id="login-form" class="ui-dialog ui-widget ui-widget-content ui-corner-all">
				<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
					<span id="ui-dialog-title-notice" class="ui-dialog-title">Login</span>
					<img src="../resources/img/mtv1.png" width="24px" alt="MTV Logo" class="logo" />
					<a href="index.php" title="Home" class="icon"><img src="../resources/img/back.png" width="24px" alt="Bact to Home" /></a>
					<div class="clearfix"></div>
				</div>
				<form action="login.php" method="post">
					<fieldset>
						<label for="id">User</label>
						<input type="text" name="id" class="ui-widget ui-widget-content ui-corner-all" />
						<?php 
						if(isset($_POST['id'])){
							$id = trim($_POST['id']);
							if(empty($id)){
								?><p class="loginError">User required.</p><?php
							}
						}
						?>
						<label for="password">Password</label>
						<input type="password" name="password" class="ui-widget ui-widget-content ui-corner-all" />
						<?php 
						if(isset($_POST['password'])){
							$password = trim($_POST['password']);
							if(empty($password)){
								?><p class="loginError">Password required.</p><?php
							}
						}
						?>
						<input type="submit" value="Login" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" />
					</fieldset>
					<?php 
					if ($failed){
						?><p class="loginError">Wrong user or password. Try again.</p><?php
					}
					if (isset($_GET['auth']) && ($_GET['auth']==0) ){
						?><p class="loginError">Session closed.</p><?php
					}
					?>
				</form>
			</div>
		</div>
		<div id="page" title="LOGIN"></div>
	</body>
</html>