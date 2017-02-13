<!-- ./ Superadmin Menu -->
@if($myApp->isSU)
  <!-- Master Data -->
  <li class="treeview {{ $menu=='masterdata' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Master Data</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('masterdata.vendormodelfeature') }}}"><i class="fa fa-list-ul"></i> Radio Features</a></li>
      <li><a href="{{{ URL::route('masterdata.carriermodelfeature') }}}"><i class="fa fa-plus"></i> Carrier Features</a></li>
    </ul>
  </li>

  <!-- Customer -->
  <li class="treeview {{ $menu=='customer' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Customer</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('customer.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('customer.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Vendor -->
  <li class="treeview {{ $menu=='vendor' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Vendor</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('vendors.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('vendors.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Vendor Model -->
  <li class="treeview {{ $menu=='vmodel' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Vendor Model</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('vendormodel.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('vendormodel.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Carrier -->
  <li class="treeview {{ $menu=='carrier' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Carrier</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('carrier.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('carrier.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Carrier Model -->
  <li class="treeview {{ $menu=='cmodel' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Carrier Model</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('carriermodel.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('carriermodel.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>
@endif
<!-- ./ Superadmin Menu -->

<!-- Customer admin Menu -->
@if($myApp->isCustAdmin)

  <!-- Group -->
  <li class="treeview {{ $menu=='group' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Group</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('groups.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('groups.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- User -->
  <li class="treeview {{ $menu=='user' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>User</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('user.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('user.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Company -->
  <li class="treeview {{ $menu=='company' ? 'active' : '' }}">
    <a href="{{{ URL::route('customer.company') }}}">
      <i class="fa fa-male"></i> <span>Company Information</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
  </li>

  <!-- Radio Inventory -->
  <li class="treeview {{ $menu=='radioinv' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Radio Inventory</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('radioinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('radioinventory.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
      <li><a href="{{{ URL::route('radioinventory.importfromfile') }}}"><i class="fa fa-upload"></i> Import</a></li>
    </ul>
  </li>

  <!-- Carrier Inventory -->
  <li class="treeview {{ $menu=='carrierinv' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Carrier Inventory</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('carrierinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('carrierinventory.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
      <li><a href="{{{ URL::route('carrierinventory.importfromfile') }}}"><i class="fa fa-upload"></i> Import</a></li>
    </ul>
  </li>

  <!-- Templates -->
  <li class="treeview {{ $menu=='template' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Template</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('templates.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('templates.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Provision -->
  <li class="treeview {{ $menu=='provision' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Provisioning</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('provision.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('provision.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Reports -->
  <li class="treeview {{ $menu=='report' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Report</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('report.radioinventory') }}}"><i class="fa fa-list-ul"></i> Radio Inventory</a></li>
      <li><a href="{{{ URL::route('report.carrierinventory') }}}"><i class="fa fa-list-ul"></i> Carrier Inventory</a></li>
      <li><a href="{{{ URL::route('report.groups') }}}"><i class="fa fa-list-ul"></i> Groups</a></li>
      <li><a href="{{{ URL::route('report.user') }}}"><i class="fa fa-list-ul"></i> User</a></li>
      <li><a href="{{{ URL::route('report.deploymentscompleted') }}}"><i class="fa fa-list-ul"></i> Deployments Completed</a></li>
    </ul>
  </li>

@endif
<!-- Customer admin Menu -->

<!-- User as Operator Menu -->
@if(!$myApp->isCustAdmin && $myApp->utype=='USER')

  <!-- My Account -->
  <li class="treeview {{ $menu=='user' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>My Account</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('user.useraccount') }}}"><i class="fa fa-list-ul"></i> View</a></li>
    </ul>
  </li>

  <!-- Radio Inventory -->
  <li class="treeview {{ $menu=='radioinv' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Radio Inventory</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('radioinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

  <!-- Carrier Inventory -->
  <li class="treeview {{ $menu=='carrierinv' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Carrier Inventory</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('carrierinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

  <!-- Templates -->
  <li class="treeview {{ $menu=='template' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Template</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('templates.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

  <!-- Provision -->
  <li class="treeview {{ $menu=='provision' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Provisioning</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('provision.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

@endif
<!-- User as Operator Menu -->