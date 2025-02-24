<?php

/**
 * @file
 */
?>
        </div>
    </div>
    <!-- <div id="footer">
        <p><?php echo __('Copyright &copy;'); ?> <?php echo date('Y'); ?> <?php
        echo Format::htmlchars((string) $ost->company ?: 'osTicket.com'); ?> - <?php echo __('All rights reserved.'); ?></p>
        <a id="poweredBy" href="https://osticket.com" target="_blank"><?php echo __('Helpdesk software - powered by osTicket'); ?></a>
    </div> -->


    <footer id="footer" class="py-2">
  <div class="container pt-md-4">
      <div class="row">
          <div class="col-12 col-md-8 col-lg-4 mb-4">
              <h6 class="px-2">Contact Info</h6>
              <p class="mb-2 px-2 text-sc pe-xl-5">Address :  Unit 114, 2nd Floor, Corinthian Executive Regency, Ortigas Ave., Brgy. San Antonio, Pasig City
              </p>
              <p class="mb-2 px-2 text-sc">Phone Number : 09952312039/277385555</p>
              <p class="mb-2 px-2 text-sc">Email : <a href="mailto:inquiries@ortadeltech.com" class="text-decoration-none text-light">inquiries@ortadeltech.com</a></p>
          </div>
          <div class="col-12 col-md-4 col-lg-2 mt-md-0 mt-4 mb-4">
              <ul class="px-2">
                  <h6 class="mb-2">Quick Links</h6>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/about">About Company</a></li>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/services">Our Services</a></li>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/contact">Contact Us</a></li>
              </ul>
          </div>
          <div class="col-12 col-md-8 col-lg-4 ps-lg-5 ps-lg-4 mt-md-0 mt-4">
              <ul class="px-2">
                  <h6 class="mb-2">What We Do</h6>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/services/cybersecurity">Cybersecurity</a></li>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/services/it_infrastructure">Infrastructure</a></li>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/services/it_professional_services">IT Professional Services</a></li>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/services/it_managed_services">IT Managed Services</a></li>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/services/software_and_application_development">Software and Application Development</a></li>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/services/surveillance">Surveillance Systems, CCTVs, PA Systems, and GPS Technologies</a></li>
              </ul>
          </div>
          <div class="col-12 col-md-4 col-lg-2 ps-lg-5 ps-lg-4 mt-md-0 mt-4">
              <ul class="px-2">
                  <h6 class="mb-2">Explore</h6>
                  <li class="mb-2"><a class="text-decoration-none text-sc" href="https://ortadeltech.com/privacy_policy">Privacy Notice</a></li>
              </ul>
          </div>
          
      </div>
      <!-- copyright -->

      <hr>
      <div class="d-flex align-items-center text-center pb-2 justify-content-between flex-sm-row">
          <img src="https://dev.ortadeltech.com/assets/images/ORTADEL_logo.png" width="55" alt="logo">
          <small>
              © 2023 ORTADEL Technologies Corporation. All rights reserved.</small>
      </div>
  </div>
</footer>


<div id="overlay"></div>
<div id="loading">
    <h4><?php echo __('Please Wait!');?></h4>
    <p><?php echo __('Please wait... it will take a second!');?></p>
</div>
<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>ajax.php/i18n/<?php
    echo $lang; ?>/js"></script>
<?php } ?>
<script type="text/javascript">
    getConfig().resolve(<?php
    include INCLUDE_DIR . 'ajax.config.php';
    $api = new ConfigAjaxAPI();
    print $api->client(FALSE);
    ?>);
</script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

        <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        </body>
</html>
