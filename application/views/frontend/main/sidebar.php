

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('admin') ?>">
        <div class="sidebar-brand-icon">
          <i class="fas fa-home"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $this->config->item('title_aps'); ?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('/') ?>">
          <i class="fas fa-fw fa-archive"></i>
          <span>Base URL</span></a>
      </li>
        <?php 
            $json = file_get_contents(base_url('/category_backend'));
            $obj = json_decode($json, true);
            foreach($obj['results'] as $key => $value){
        ?>
      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('/frontend/'.$value['url']) ?>">
          <i class="fas fa-fw fa-archive"></i>
          <span><?php echo $value['text']; ?></span></a>
      </li>
        <?php } ?>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
