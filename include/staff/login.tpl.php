<?php
include_once(INCLUDE_DIR.'staff/login.header.php');
$info = ($_POST && $errors) ? Format::htmlchars($_POST) : array();
if ($thisstaff && $thisstaff->is2FAPending())
    $msg = "2FA Pending";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>osTicket :: Staff Control Panel - Authentication Required</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
      position: relative;
    }
    /* Remove brickwall from flex flow */
    #brickwall {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
    /* Wrapper to center the login panel */
    .login-wrapper {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 10;
      width: 100%;
      max-width: 400px;
      padding: 0 1rem;
    }
    /* Login Container */
    #loginBox {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      padding: 2rem;
      text-align: center;
      position: relative;
    }
    /* Logo */
    #logo img {
      max-width: 150px;
      margin-bottom: 1rem;
    }
    /* Login Message */
    #login-message {
      margin-bottom: 1rem;
      color: #E74C3C;
      font-weight: 500;
    }
    /* Form Elements */
    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }
    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #74ebd5;
    }
    /* Reset Link */
    #reset-link-container {
      text-align: right;
    }
    #reset-link {
      color: #74ebd5;
      text-decoration: none;
      font-size: 0.9rem;
    }
    /* Updated login button */
    button.submit {
      background: #20242c;
      border: none;
      color: #fff;
      padding: 0.75rem 1.25rem;
      font-size: 1rem;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.3s;
      display: block;
      width: 100%;
      max-width: 300px;
      margin: 1rem auto 0;
    }
    button.submit:hover {
      background: #1a1e27;
    }
    /* Footer */
    #company .content, #poweredBy {
      margin-top: 1rem;
      font-size: 0.9rem;
      color: #aaa;
    }
    #poweredBy {
      text-align: center;
    }
    #poweredBy img {
      height: 20px;
      vertical-align: middle;
    }
    /* Optional Background Blur */
    #blur {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(5px);
      border-radius: 8px;
      z-index: -1;
    }
  </style>
</head>
<body>
  <div id="brickwall"></div>
  
  <!-- Wrapper to center the login panel -->
  <div class="login-wrapper">
    <div id="loginBox">
      <div id="blur"></div>
      <h1 id="logo">
        <a href="index.php">
          <img src="logo.php?login" alt="osTicket :: <?php echo __('Staff Control Panel'); ?>" />
        </a>
      </h1>
      <?php if (!empty($msg)) { ?>
        <h3 id="login-message"><?php echo Format::htmlchars($msg); ?></h3>
      <?php } ?>
      <div class="banner">
        <small><?php echo ($content) ? Format::display($content->getLocalBody()) : ''; ?></small>
      </div>
      <div id="loading" style="display:none;" class="dialog">
        <h1>
          <i class="icon-spinner icon-spin icon-large"></i> <?php echo __('Verifying'); ?>
        </h1>
      </div>
      <form action="login.php" method="post" id="login" onsubmit="attemptLoginAjax(event)">
        <?php csrf_token();
        if ($thisstaff && $thisstaff->is2FAPending() && ($bk = $thisstaff->get2FABackend()) && ($form = $bk->getInputForm($_POST))) {
          include STAFFINC_DIR . 'templates/dynamic-form-simple.tmpl.php';
        ?>
          <fieldset style="padding-top:10px;">
            <input type="hidden" name="do" value="2fa">
            <button class="submit" type="submit" name="submit">
              <i class="icon-signin"></i> <?php echo __('Verify'); ?>
            </button>
          </fieldset>
        <?php } else { ?>
          <input type="hidden" name="do" value="scplogin">
          <fieldset>
            <input type="text" name="userid" id="name" value="<?php echo $info['userid'] ?? ''; ?>" placeholder="<?php echo __('Email or Username'); ?>" autofocus autocorrect="off" autocapitalize="off">
            <input type="password" name="passwd" id="pass" maxlength="128" placeholder="<?php echo __('Password'); ?>" autocorrect="off" autocapitalize="off">
            <div id="reset-link-container">
              <a id="reset-link" class="<?php if (!$show_reset || !$cfg->allowPasswordReset()) echo 'hidden'; ?>" href="pwreset.php">
                <?php echo __('Forgot My Password'); ?>
              </a>
            </div>
            <button class="submit" type="submit" name="submit">
              <i class="icon-signin"></i> <?php echo __('Log In'); ?>
            </button>
          </fieldset>
        <?php } ?>
      </form>
      <?php if (($bks = StaffAuthenticationBackend::getExternal())) { ?>
        <div class="or"><hr/></div>
        <?php foreach ($bks as $bk) { ?>
          <div class="external-auth"><?php $bk->renderExternalLink(); ?></div>
        <?php } ?>
      <?php } ?>
      <!-- <div id="company">
        <div class="content">
          <?php echo __('Copyright'); ?> &copy; <?php echo Format::htmlchars($ost->company) ?: date('Y'); ?>
        </div>
      </div> -->
    </div>
  </div>
  
  <div id="poweredBy">
    <?php echo __('Powered by'); ?>
    <a href="http://www.osticket.com" target="_blank">
      <img alt="osTicket" src="images/osticket-grey.png" class="osticket-logo">
    </a>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (undefined === window.getComputedStyle(document.documentElement).backgroundBlendMode) {
        document.getElementById('loginBox').style.backgroundColor = '#fff';
      }
    });
    
    function attemptLoginAjax(e) {
      $('#loading').show();
      var objectifyForm = function(formArray) {
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++) {
          returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        return returnArray;
      };
      if ($.fn.effect) {
        var oldEffect = $.fn.effect;
        $.fn.effect = function (effectName) {
          if (effectName === "shake") {
            $('#loading').hide();
            var old = $.effects.createWrapper;
            $.effects.createWrapper = function (element) {
              var result;
              var oldCSS = $.fn.css;
              $.fn.css = function (size) {
                var _element = this;
                var hasOwn = Object.prototype.hasOwnProperty;
                return _element === element && hasOwn.call(size, "width") && hasOwn.call(size, "height") ? _element : oldCSS.apply(this, arguments);
              };
              result = old.apply(this, arguments);
              $.fn.css = oldCSS;
              return result;
            };
          }
          return oldEffect.apply(this, arguments);
        };
      }
      var form = $(e.target),
          data = objectifyForm(form.serializeArray());
      data.ajax = 1;
      $('button[type=submit]', form).attr('disabled', 'disabled');
      $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: data,
        cache: false,
        success: function(json) {
          $('button[type=submit]', form).removeAttr('disabled');
          if (!typeof(json) === 'object' || !json.status)
            return;
          switch (json.status) {
            case 401:
              if (json && json.redirect)
                document.location.href = json.redirect;
              if (json && json.message)
                $('#login-message').text(json.message);
              if (json && json.show_reset)
                $('#reset-link').show();
              if ($.fn.effect) {
                $('#loginBox').effect('shake');
              }
              $('#pass').val('').focus();
              break;
            case 302:
              if (json && json.redirect)
                document.location.href = json.redirect;
              break;
          }
        },
      });
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();
      return false;
    }
  </script>
  <!--[if IE]>
  <style>
    #loginBox:after { background-color: white !important; }
  </style>
  <![endif]-->
  <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.13.2.custom.min.js?53339df"></script>
</body>
</html>
