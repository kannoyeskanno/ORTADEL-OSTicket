<?php
header("Content-Type: text/html; charset=UTF-8");
header("Content-Security-Policy: frame-ancestors ".$cfg->getAllowIframes()."; script-src 'self' 'unsafe-inline' 'unsafe-eval'; object-src 'none'");

$title = ($ost && ($title=$ost->getPageTitle()))
    ? $title : ('osTicket :: '.__('Staff Control Panel'));

if (!isset($_SERVER['HTTP_X_PJAX'])) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html<?php
if (($lang = Internationalization::getCurrentLanguage())
        && ($info = Internationalization::getLanguageInfo($lang))
        && (@$info['direction'] == 'rtl'))
    echo ' dir="rtl" class="rtl"';
if ($lang) {
    echo ' lang="' . Internationalization::rfc1766($lang) . '"';
}

// Dropped IE Support Warning
if (osTicket::is_ie())
    $ost->setWarning(__('osTicket no longer supports Internet Explorer.'));
?>>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    
    <!--  -->
    <!-- <meta http-equiv="Content-Security-Policy" content="script-src 'self' https://cdn.jsdelivr.net 'unsafe-inline' 'unsafe-eval';">
<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net;">
 -->

    <!--  -->



    <meta http-equiv="x-pjax-version" content="<?php echo GIT_VERSION; ?>">
    <title><?php echo Format::htmlchars($title); ?></title>
    <!--[if IE]>
    <style type="text/css">
        .tip_shadow { display:block !important; }
    </style>
    <![endif]-->
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/thread.css" media="all">
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>scp/css/scp.css" media="all">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css" media="screen">
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/typeahead.css" media="screen">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.13.2.custom.min.css"
         rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/jquery-ui-timepicker-addon.css" media="all">
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome-ie7.min.css">
    <![endif]--f>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH ?>scp/css/dropdown.css">
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/loadingbar.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css">
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH ?>scp/css/translatable.css"/>
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="<?php echo ROOT_PATH ?>images/oscar-favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo ROOT_PATH ?>images/oscar-favicon-16x16.png" sizes="16x16" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="<?php echo ROOT_PATH ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>/assets/one/css/_staff.css?" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>/assets/one/css/staff_users.css?" media="screen"/>
    
  


    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }
    ?>
</head>
<body>
<div id="container">
    <?php
    if($ost->getError())
        echo sprintf('<div id="error_bar">%s</div>', $ost->getError());
    elseif($ost->getWarning())
        echo sprintf('<div id="warning_bar">%s</div>', $ost->getWarning());
    elseif($ost->getNotice())
        echo sprintf('<div id="notice_bar">%s</div>', $ost->getNotice());
    ?>
    <div id="header" class="py-1 px-3 position-sticky top-0 overflow-hidden d-flex justify-content-between z-100 bg-dark">
<a id="nav-brand" class="nav-brand flex-shrink-0 text-decoration-none justify-content-center d-md-flex border-b-none mb-0 ms-3 flex-row align-items-start">
        <img src="https://ortadeltech.com/assets/images/ORTADEL_logo.png" width="35" style="margin-right: .8rem;" alt="logo">
        <span class="ml-2 text-light">
            <h1 class="h5 m-0 ls-1 text-decoration-none">ORTADEL</h1>
            <small>Technologies Corporation</small>
        </span>
    </a>

    <button class="btn btn-outline-none focus-none d-md-none d-flex flex-end" type="button" style="margin-left: auto;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
            <span class="navbar-toggler-icon"></span>
    </button>

    <p id="info" class="d-none d-md-block text-light mb-0">
        <?php echo sprintf(__('Welcome, %s.'), '<strong>'.$thisstaff->getFirstName().'</strong>'); ?>
        <?php if($thisstaff->isAdmin() && !defined('ADMINPAGE')) { ?>
            | <a href="<?php echo ROOT_PATH ?>scp/admin.php" class="no-pjax text-light"><?php echo __('Admin Panel'); ?></a>
        <?php } else { ?>
            | <a href="<?php echo ROOT_PATH ?>scp/index.php" class="no-pjax text-light"><?php echo __('Agent Panel'); ?></a>
        <?php } ?>
        | <a href="<?php echo ROOT_PATH ?>scp/profile.php" class="text-light"><?php echo __('Profile'); ?></a>
        | <a href="<?php echo ROOT_PATH ?>scp/logout.php?auth=<?php echo $ost->getLinkToken(); ?>" class="no-pjax text-light"><?php echo __('Log Out'); ?></a>
    </p>
</div>

<div id="offcanvasMenu" class="offcanvas offcanvas-end p-2" style="width: 250px;">
    <button type="button" class="btn-close btn-close-white focus-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        <div class="offcanvas-header">
        <h5 class="offcanvas-title text-white" id="offcanvasMenuLabel">Menu</h5>
    </div>
    <div class="offcanvas-body">
    <p><?php echo sprintf(__('Welcome, %s.'), '<strong>' . $thisstaff->getFirstName() . '</strong>'); ?></p>
    
    <ul id="agent-items-nav" class="list-unstyled d-flex flex-column justify-content-between h-100" 
    style="max-height: 81vh; padding: 0 10px; overflow: hidden;">
        <div>
            <?php if ($thisstaff->isAdmin() && !defined('ADMINPAGE')) { ?>
                <li class="mt-3">
                    <a class="text-light text-decoration-none no-pjax d-flex align-items-center" href="<?php echo ROOT_PATH ?>scp/admin.php">
                        <i class="bi bi-gear-fill me-2"></i> 
                        <?php echo __('Admin Panel'); ?>
                    </a>
                </li>
            <?php } else { ?>
                <li class="mt-3">
                    <a class="text-light text-decoration-none no-pjax d-flex align-items-center" href="<?php echo ROOT_PATH ?>scp/index.php">
                        <i class="bi bi-person-fill me-2"></i> 
                        <?php echo __('Agent Panel'); ?>
                    </a>
                </li>
            <?php } ?>

            <li class="mt-3">
                <a class="text-light text-decoration-none no-pjax d-flex align-items-center" href="<?php echo ROOT_PATH ?>scp/profile.php">
                    <i class="bi bi-person-circle me-2"></i> 
                    <?php echo __('Profile'); ?>
                </a>
            </li>
        </div>
        <div id="logout" class="mt-auto">
            
                <a class="text-decoration-none no-pjax d-flex align-items-center text-danger" href="<?php echo ROOT_PATH ?>scp/logout.php?auth=<?php echo $ost->getLinkToken(); ?>">
                    <i class="bi bi-box-arrow-right me-2 text-danger"></i> 
                    <?php echo __('Log Out'); ?>
                </a>
            
        </div>
       

    </ul>
</div>

</div>

    <div id="pjax-container" class="<?php if ($_POST) echo 'no-pjax'; ?>">
<?php } else {
    header('X-PJAX-Version: ' . GIT_VERSION);
    if ($pjax = $ost->getExtraPjax()) { ?>
    <script type="text/javascript">
    <?php foreach (array_filter($pjax) as $s) echo $s.";"; ?>
    </script>
    <?php }
    foreach ($ost->getExtraHeaders() as $h) {
        if (strpos($h, '<script ') !== false)
            echo $h;
    } ?>
    <title><?php echo ($ost && ($title=$ost->getPageTitle()))?$title:'osTicket :: '.__('Staff Control Panel'); ?></title><?php
} # endif X_PJAX ?>
<!-- <ul id="nav" > -->
<?php include STAFFINC_DIR . "templates/navigation.tmpl.php"; ?>
<!-- </ul> -->
    <?php include STAFFINC_DIR . "templates/sub-navigation.tmpl.php"; ?>

        <div id="content">
        <?php if(isset($errors['err'])) { ?>
            <div id="msg_error"><?php echo $errors['err']; ?></div>
        <?php }elseif($msg) { ?>
            <div id="msg_notice"><?php echo $msg; ?></div>
        <?php }elseif($warn) { ?>
            <div id="msg_warning"><?php echo $warn; ?></div>
        <?php }
        foreach (Messages::getMessages() as $M) { ?>
            <div class="<?php echo strtolower($M->getLevel()); ?>-banner"><?php
                echo (string) $M; ?></div>
<?php   } ?>
