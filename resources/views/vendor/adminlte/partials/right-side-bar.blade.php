

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
    	<a href="#SIDE_RIGHT" aria-controls="SIDE_RIGHT" role="tab" data-toggle="tab">MENU</a></li>
    <li role="presentation"><a href="#SSO_MENU" aria-controls="SSO_MENU" role="tab" data-toggle="tab">SSO</a></li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="SIDE_RIGHT">
    	<div class="menu-side-right">
		  <ul class="sidebar-menu" data-widget="tree">
		      @each('vendor.adminlte.partials.menu-item', $menu, 'item')
		  </ul>
		</div>
		<style type="text/css">
		  .menu-side-right a{
		    color: #fff;
		  }
		</style>
    </div>

    <div role="tabpanel" class="tab-pane" id="SSO_MENU">...</div>
   
</div>