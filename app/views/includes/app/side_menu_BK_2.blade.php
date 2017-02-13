  <!-- Templates -->
  <li class="treeview active">
    <a href="{{{ URL::route('templates.index') }}}">
      <i class="fa fa-male"></i> <span>Template</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('templates.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('templates.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Provision -->
  <li class="treeview active">
    <a href="{{{ URL::route('provision.index') }}}">
      <i class="fa fa-male"></i> <span>Provision</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('provision.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('provision.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Radio Inventory -->
  <li class="treeview active">
    <a href="{{{ URL::route('radioinventory.index') }}}">
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
  <li class="treeview active">
    <a href="{{{ URL::route('carrierinventory.index') }}}">
      <i class="fa fa-male"></i> <span>Carrier Inventory</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('carrierinventory.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('carrierinventory.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
      <li><a href="{{{ URL::route('carrierinventory.importfromfile') }}}"><i class="fa fa-upload"></i> Import</a></li>
    </ul>
  </li>

  <!-- Master Data -->
  <li class="treeview active">
    <a href="{{{ URL::route('masterdata.vendormodelfeature') }}}">
      <i class="fa fa-male"></i> <span>Master Data</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('masterdata.vendormodelfeature') }}}"><i class="fa fa-list-ul"></i> Model Features</a></li>
      <li><a href="{{{ URL::route('masterdata.carriermodelfeature') }}}"><i class="fa fa-plus"></i> Carrier Features</a></li>
    </ul>
  </li>

  <!-- Customer -->
  <li class="treeview active">
    <a href="{{{ URL::route('customer.index') }}}">
      <i class="fa fa-male"></i> <span>Customer</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('customer.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('customer.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Vendor -->
  <li class="treeview active">
    <a href="{{{ URL::route('vendors.index') }}}">
      <i class="fa fa-male"></i> <span>Vendor</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('vendors.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('vendors.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Model -->
  <li class="treeview active">
    <a href="{{{ URL::route('vendormodel.index') }}}">
      <i class="fa fa-male"></i> <span>Vendor Model</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('vendormodel.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('vendormodel.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Carrier -->
  <li class="treeview active">
    <a href="{{{ URL::route('carrier.index') }}}">
      <i class="fa fa-male"></i> <span>Carrier</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('carrier.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('carrier.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Carrier Model -->
  <li class="treeview active">
    <a href="{{{ URL::route('carriermodel.index') }}}">
      <i class="fa fa-male"></i> <span>Carrier Model</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('carriermodel.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('carriermodel.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Group -->
  <li class="treeview active">
    <a href="{{{ URL::route('groups.index') }}}">
      <i class="fa fa-male"></i> <span>Group</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('groups.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('groups.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- User -->
  <li class="treeview active">
    <a href="{{{ URL::route('user.index') }}}">
      <i class="fa fa-male"></i> <span>User</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('user.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('user.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li> 