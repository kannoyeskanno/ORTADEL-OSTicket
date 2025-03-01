  <div class="container">
<!--    
    <button id="burger-user-nav-btn" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->

    <div id="navbarNav">
      <ul class="navbar-nav">
        <?php
        if ($nav && ($tabs = $nav->getTabs()) && is_array($tabs)) {
          foreach ($tabs as $name => $tab) {
            if ($tab['href'][0] != '/')
              $tab['href'] = ROOT_PATH . 'scp/' . $tab['href'];

            echo sprintf(
              '<li id="main-tabs" class="nav-item %s %s"><a id="link" class="nav-link text-decoration-none fs-5 lead" href="%s">%s%s</a>',
              isset($tab['active']) ? 'active' : 'inactive',
              @$tab['class'] ?: '',
              $tab['href'],
              $tab['icon'],
              $tab['desc']
            );

            if (!isset($tab['active']) && ($subnav = $nav->getSubMenu($name))) {
              echo '<ul class="dropdown-menu">';
              foreach ($subnav as $k => $item) {
                if (isset($item['id']) && !($id = $item['id']))
                  $id = "nav$k";
                if ($item['href'][0] != '/')
                  $item['href'] = ROOT_PATH . 'scp/' . $item['href'];

                echo sprintf(
                  '<li><a class="dropdown-item %s" href="%s" title="%s" id="%s">%s</a></li>',
                  $item['iconclass'],
                  $item['href'],
                  $item['title'] ?? null,
                  $id ?? null,
                  $item['desc']
                );
              }
              echo '</ul>';
            }
            echo '</li>';
          }
        }
        ?>
      </ul>
    </div>
  </div>
