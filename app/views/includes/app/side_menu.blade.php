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
  
  <!-- Admin -->
  <li class="treeview {{ $menu=='purgedata' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-male"></i> <span>Admin</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('purgedata.index') }}}"><i class="fa fa-trash-o"></i> Purge Data</a></li>
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

  <!-- Admin -->
  <li class="treeview {{ in_array($menu, [ 'group', 'user', 'company' ]) ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-gears"></i> <span>Admin</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

      <!-- Group -->
      <li>
        <a href="#">
          <i class="fa fa-group"></i> <span>Group</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu {{ $menu=='group' ? 'menu-open' : '' }}" style="display:{{ $menu=='group' ? 'block' : 'none' }};" >
          <li><a href="{{{ URL::route('groups.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
          <li><a href="{{{ URL::route('groups.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
        </ul>
      </li>

      <!-- User -->
      <li>
        <a href="#">
          <i class="fa fa-male"></i> <span>User</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu {{ $menu=='user' ? 'menu-open' : '' }}" style="display:{{ $menu=='user' ? 'block' : 'none' }};" >
          <li><a href="{{{ URL::route('user.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
          <li><a href="{{{ URL::route('user.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
        </ul>
      </li>

      <!-- Company -->
      <li>
        <a href="{{{ URL::route('customer.company') }}}">
          <i class="fa fa-building-o"></i> <span>Company</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
      </li>

    </ul>
  </li>


  <!-- Inventory -->
  <li class="treeview {{ in_array($menu, [ 'radioinv', 'carrierinv' ]) ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-tasks"></i> <span>Inventory</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

      <!-- Radio Inventory -->
      <li>
        <a href="#">
          <i class="fa fa-archive"></i> <span>Radio Inventory</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu {{ $menu=='radioinv' ? 'menu-open' : '' }}" style="display:{{ $menu=='radioinv' ? 'block' : 'none' }};" >
          <li><a href="{{{ URL::route('radioinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
          <li><a href="{{{ URL::route('radioinventory.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
          <li><a href="{{{ URL::route('radioinventory.importfromfile') }}}"><i class="fa fa-upload"></i> Import</a></li>
        </ul>
      </li>

      <!-- Carrier Inventory -->
      <li>
        <a href="#">
          <i class="fa fa-archive"></i> <span>Carrier Inventory</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu {{ $menu=='carrierinv' ? 'menu-open' : '' }}" style="display:{{ $menu=='carrierinv' ? 'block' : 'none' }};" >
          <li><a href="{{{ URL::route('carrierinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
          <li><a href="{{{ URL::route('carrierinventory.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
          <li><a href="{{{ URL::route('carrierinventory.importfromfile') }}}"><i class="fa fa-upload"></i> Import</a></li>
        </ul>
      </li>

    </ul>
  </li>


  <!-- Provisioning -->
  <li class="treeview {{ in_array($menu, [ 'template', 'provision' ]) ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-exchange"></i> <span>Provisioning</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">


      <!-- Templates -->
      <li>
        <a href="#">
          <i class="fa fa-certificate"></i> <span>Template</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu {{ $menu=='template' ? 'menu-open' : '' }}" style="display:{{ $menu=='template' ? 'block' : 'none' }};" >
          <li><a href="{{{ URL::route('templates.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
          <li><a href="{{{ URL::route('templates.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
        </ul>
      </li>

      <!-- Provision -->
      <li>
        <a href="#">
          <i class="fa fa-shield"></i> <span>Staging</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu {{ $menu=='provision' ? 'menu-open' : '' }}" style="display:{{ $menu=='provision' ? 'block' : 'none' }};" >
          <li><a href="{{{ URL::route('provision.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
          <li><a href="{{{ URL::route('provision.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
        </ul>
      </li>

    </ul>
  </li>


  <!-- Reports -->
  <li class="treeview {{ $menu=='report' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-list-alt"></i> <span>Report</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('report.radioinventory') }}}"><i class="fa fa-file-text-o"></i> Radio Inventory</a></li>
      <li><a href="{{{ URL::route('report.carrierinventory') }}}"><i class="fa fa-file-text-o"></i> Carrier Inventory</a></li>
      <li><a href="{{{ URL::route('report.groups') }}}"><i class="fa fa-file-text-o"></i> Groups</a></li>
      <li><a href="{{{ URL::route('report.user') }}}"><i class="fa fa-file-text-o"></i> User</a></li>
      <li><a href="{{{ URL::route('report.deploymentscompleted') }}}"><i class="fa fa-file-text-o"></i> Deployments Completed</a></li>
    </ul>
  </li>

@endif
<!-- Customer admin Menu -->

<!-- User as Operator Menu -->
@if(!$myApp->isCustAdmin && $myApp->utype=='USER')

  <!-- My Account -->
  <li class="treeview {{ $menu=='user' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-list-alt"></i> <span>My Account</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('user.useraccount') }}}"><i class="fa fa-list-ul"></i> View</a></li>
    </ul>
  </li>

  <!-- Radio Inventory -->
  <li class="treeview {{ $menu=='radioinv' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-list-alt"></i> <span>Radio Inventory</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('radioinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

  <!-- Carrier Inventory -->
  <li class="treeview {{ $menu=='carrierinv' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-list-alt"></i> <span>Carrier Inventory</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('carrierinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

  <!-- Templates -->
  <li class="treeview {{ $menu=='template' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-list-alt"></i> <span>Template</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('templates.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

  <!-- Provision -->
  <li class="treeview {{ $menu=='provision' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-list-alt"></i> <span>Provisioning</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('provision.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

  <!-- Reports -->
  <li class="treeview {{ $menu=='report' ? 'active' : '' }}">
    <a href="#">
      <i class="fa fa-list-alt"></i> <span>Report</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('report.radioinventory') }}}"><i class="fa fa-file-text-o"></i> Radio Inventory</a></li>
      <li><a href="{{{ URL::route('report.carrierinventory') }}}"><i class="fa fa-file-text-o"></i> Carrier Inventory</a></li>
      <li><a href="{{{ URL::route('report.deploymentscompleted') }}}"><i class="fa fa-file-text-o"></i> Deployments Completed</a></li>
    </ul>
  </li>

@endif
<!-- User as Operator Menu -->