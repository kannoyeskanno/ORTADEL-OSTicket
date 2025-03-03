<?php

/**
 * @file
 */

if (!defined('OSTCLIENTINC')) {
  die('Access Denied');
}

$email = Format::input($_POST['luser'] ?: $_GET['e']);
$passwd = Format::input($_POST['lpasswd'] ?: $_GET['t']);

$content = Page::lookupByType('banner-client');

if ($content) {
  list($title, $body) = $ost->replaceTemplateVariables(
        [$content->getLocalName(), $content->getLocalBody()]);
}
else {
  $title = __('Sign In');
  $body = __('To better serve you, we encourage our clients to register for an account and verify the email address we have on record.');
}

?>
<h1><?php echo Format::display($title); ?></h1>
<p><?php echo Format::display($body); ?></p>

<form action="login.php" method="post">
    <?php csrf_token(); ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron login-box p-4">
                <strong class="text-danger"><?php echo Format::htmlchars($errors['login']); ?></strong>

                <!-- Email Field -->
                <div class="form-group row align-items-center">
                    <label for="username" class="col-sm-2 col-form-label text-end"><?php echo __('Email'); ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="<?php echo __('Email or Username'); ?>"
                               name="luser" id="username" value="<?php echo $email; ?>">
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group row align-items-center mt-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label text-end"><?php echo __('Password'); ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" name="lpasswd"
                               placeholder="<?php echo __('Password'); ?>">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group row mt-4">
                    <div class="col-sm-12 text-center">
                        <input class="btn btn-primary px-4" type="submit" value="<?php echo __('Sign In'); ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Forgot Password & Registration Section -->
        <div class="col-md-6">
            <div class="jumbotron p-4">
                <?php if ($suggest_pwreset) { ?>
                    <a href="pwreset.php" class="d-block text-center"><?php echo __('Forgot My Password'); ?></a>
                <?php } ?>

                <?php
                $ext_bks = [];
                foreach (UserAuthenticationBackend::allRegistered() as $bk) {
                    if ($bk instanceof ExternalAuthentication) {
                        $ext_bks[] = $bk;
                    }
                }

                if (count($ext_bks)) {
                    foreach ($ext_bks as $bk) { ?>
                        <div class="external-auth text-center"><?php $bk->renderExternalLink(); ?></div>
                    <?php }
                }

                if ($cfg && $cfg->isClientRegistrationEnabled()) { ?>
                    <div class="text-center mt-3">
                        <i class="fas fa-chevron-right"></i>
                        <?php echo __('Not yet registered?'); ?>
                        <a href="account.php?do=create"><?php echo __('Create an account'); ?></a>
                    </div>
                <?php } ?>

                <div class="text-center mt-3">
                    <i class="fas fa-chevron-right"></i>
                    <b><?php echo __("I'm an agent"); ?></b> —
                    <a href="<?php echo ROOT_PATH; ?>scp/"><?php echo __('Sign in here'); ?></a>
                </div>
            </div>
        </div>
    </div>
</form>

<br>

<!-- Alert for Opening a New Ticket -->
<div class="alert alert-primary text-center">
    <?php
    if ($cfg->getClientRegistrationMode() != 'disabled' || !$cfg->isClientLoginRequired()) {
        echo sprintf(
            __('If this is your first time contacting us or you\'ve lost the ticket number, please %s open a new ticket %s'),
            '<a href="open.php">', '</a>'
        );
    }
    ?>
</div>


