<?php
$info = $_POST;
if (!isset($info['timezone']))
    $info += array('backend' => null);

if (isset($user) && $user instanceof ClientCreateRequest) {
    $bk = $user->getBackend();
    $info = array_merge($info, array(
        'backend' => $bk->getBkId(),
        'username' => $user->getUsername(),
    ));
}
$info = Format::htmlchars(($errors && $_POST) ? $_POST : $info);
?>

<div class="container mt-4">
    <div class="row justify-content-left">
        <div class="col-md-8 col-lg-6">
            <h2 class="text-left mb-3"><?php echo __('Account Registration'); ?></h2>
            <p class="text-left text-muted">
                <?php echo __('Use the forms below to create or update the information we have on file for your account'); ?>
            </p>

            <form action="account.php" method="post" class="needs-validation" novalidate>
                <?php csrf_token(); ?>
                <input type="hidden" name="do" value="<?php echo Format::htmlchars($_REQUEST['do'] ?: ($info['backend'] ? 'import' : 'create')); ?>" />

                <!-- User Information Section -->
                <div class="card shadow-sm p-3 mb-4">
                    <div class="card-body">
                        <?php
                        $cf = $user_form ?: UserForm::getInstance();
                        $cf->render(array('staff' => false, 'mode' => 'create'));
                        ?>
                    </div>
                </div>

                <!-- Preferences Section -->
                <div class="card shadow-sm p-3 mb-4">
                    <div class="card-body">
                        <h5 class="mb-3"><?php echo __('Preferences'); ?></h5>
                        <div class="mb-3">
                            <label class="form-label"><?php echo __('Time Zone'); ?>:</label>
                            <?php
                            $TZ_NAME = 'timezone';
                            $TZ_TIMEZONE = $info['timezone'];
                            include INCLUDE_DIR . 'staff/templates/timezone.tmpl.php'; ?>
                            <div class="text-danger"><?php echo $errors['timezone']; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Access Credentials Section -->
                <div class="card shadow-sm p-3 mb-4">
                    <div class="card-body">
                        <h5 class="mb-3"><?php echo __('Access Credentials'); ?></h5>

                        <?php if ($info['backend']) { ?>
                            <div class="mb-3">
                                <label class="form-label"><?php echo __('Login With'); ?>:</label>
                                <input type="hidden" name="backend" value="<?php echo $info['backend']; ?>" />
                                <input type="hidden" name="username" value="<?php echo $info['username']; ?>" />
                                <p class="form-control-plaintext">
                                    <?php foreach (UserAuthenticationBackend::allRegistered() as $bk) {
                                        if ($bk->getBkId() == $info['backend']) {
                                            echo $bk->getName();
                                            break;
                                        }
                                    } ?>
                                </p>
                            </div>
                        <?php } else { ?>
                            <div class="mb-3">
                                <label class="form-label"><?php echo __('Create a Password'); ?>:</label>
                                <input type="password" class="form-control" name="passwd1" maxlength="128" required>
                                <div class="text-danger"><?php echo $errors['passwd1']; ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><?php echo __('Confirm New Password'); ?>:</label>
                                <input type="password" class="form-control" name="passwd2" maxlength="128" required>
                                <div class="text-danger"><?php echo $errors['passwd2']; ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="text-left">
                    <button type="submit" class="btn btn-primary px-4"><?php echo __('Register'); ?></button>
                    <button type="button" class="btn btn-secondary px-4" onclick="window.location.href='index.php';">
                        <?php echo __('Cancel'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (!isset($info['timezone'])) { ?>
    <!-- Auto detect client's timezone -->
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jstz.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var zone = jstz.determine();
            $('#timezone-dropdown').val(zone.name()).trigger('change');
        });
    </script>
<?php } ?>
