<!-- VAR Acc Menu -->
@if($myApp->utype == 'VARACC')

  <li class="active">
    <a href="{{{ URL::route('varacc.myaccount') }}}">
      <i class="fa fa-sign-in"></i> <span>My Account ttt</span>
      <i class="fa pull-right"></i>
    </a>
  </li>

@endif
<!-- /.Account Rep Menu -->

<!-- Inside Sales Menu -->
@if($myApp->utype == 'INTSALES')

  <li class="active">
    <a href="{{{ URL::route('insidesales.myaccount') }}}">
      <i class="fa fa-sign-in"></i> <span>My Account</span>
      <i class="fa pull-right"></i>
    </a>
  </li>

  <!-- Inside Sales -->
  <li class="treeview active">
    <a href="{{{ URL::route('insidesales.index') }}}">
      <i class="fa fa-male"></i> <span>Inside Sales Team</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('insidesales.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
    </ul>
  </li>

  <!-- Account Rep -->
  <li class="treeview active">
    <a href="{{{ URL::route('accountrep.index') }}}">
      <i class="fa fa-male"></i> <span>Account Rep</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('accountrep.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('accountrep.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

@endif
<!-- /.Inside Sales Menu -->

<!-- Superadmin Menu -->
@if($myApp->isSU)

  <!-- Inside Sales -->
  <li class="treeview active">
    <a href="{{{ URL::route('insidesales.index') }}}">
      <i class="fa fa-male"></i> <span>Inside Sales Team</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('insidesales.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('insidesales.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Account Rep -->
  <li class="treeview active">
    <a href="{{{ URL::route('accountrep.index') }}}">
      <i class="fa fa-male"></i> <span>Account Rep</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('accountrep.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('accountrep.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

@endif
<!-- /.Superadmin Menu -->

  <li class="header">All Menus</li>

  <!-- My Account Section -->
  <li class="active">
    <a href="{{{ URL::route('insidesales.myaccount') }}}">
      <i class="fa fa-sign-in"></i> <span>My Account</span>
      <i class="fa pull-right"></i>
    </a>
  </li>

  <li class="active">
    <a href="{{{ URL::route('varacc.myaccount') }}}">
      <i class="fa fa-sign-in"></i> <span>My Account</span>
      <i class="fa pull-right"></i>
    </a>
  </li>

  <li class="active">
    <a href="{{{ URL::route('account.myaccount') }}}">
      <i class="fa fa-sign-in"></i> <span>My Account</span>
      <i class="fa pull-right"></i>
    </a>
  </li>
  <!-- End of My Account Section -->

  <!-- Inside Sales -->
  <li class="treeview active">
    <a href="{{{ URL::route('insidesales.index') }}}">
      <i class="fa fa-male"></i> <span>Inside Sales Team</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('insidesales.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      @if($myApp->isSU)
        <li><a href="{{{ URL::route('insidesales.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
      @endif
    </ul>
  </li>

  <!-- VAR Account -->
  <li class="treeview active">
    <a href="{{{ URL::route('varacc.index') }}}">
      <i class="fa fa-users"></i> <span>VAR Accounts</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('varacc.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('varacc.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Customer Account -->
  <li class="treeview active">
    <a href="{{{ URL::route('customer.index') }}}">
      <i class="fa fa-users"></i> <span>Customer Accounts</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('customer.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('customer.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Account On-boarding -->
  <li class="treeview active">
    <a href="{{{ URL::route('onboarding.index') }}}">
      <i class="fa fa-users"></i> <span>On-Boarding</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('onboarding.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('onboarding.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>


@if($myApp->isSU)

  <!-- Account Rep -->
  <li class="treeview active">
    <a href="{{{ URL::route('accountrep.index') }}}">
      <i class="fa fa-male"></i> <span>Account Rep</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('accountrep.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('accountrep.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- Account -->
  <li class="treeview active">
    <a href="{{{ URL::route('account.index') }}}">
      <i class="fa fa-users"></i> <span>Accounts</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{{ URL::route('account.index') }}}"><i class="fa fa-list-ul"></i> List</a></li>
      <li><a href="{{{ URL::route('account.create') }}}"><i class="fa fa-plus"></i> Create</a></li>
    </ul>
  </li>

  <!-- On-Boarding -->
  <li class="active">
    <a href="{{{ URL::route('onboarding.index') }}}">
      <i class="fa fa-info-circle"></i> <span>Account On-Boarding</span>
      <i class="fa pull-right"></i>
    </a>
  </li>

  @else

  <li class="active">
    <a href="{{{ URL::route('onboarding.open') }}}">
      <i class="fa fa-info-circle"></i> <span>Account On-Boarding</span>
      <i class="fa pull-right"></i>
    </a>
  </li>

@endif