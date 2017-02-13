<a href="{{{ URL::to('/') }}}" class="logo"><b>{{ $myApp->sp_title }}</b> <!--  VAR Portal Administration Version 1.0 --></a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </a>
  <div class="top-msg">hi...</div>
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- Messages: style can be found in dropdown.less-->
     
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <!-- <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/> -->
          <span class="glyphicon glyphicon-user"></span>
          <span class="hidden-xs">{{{ $display_name }}}</span>
          <span class="glyphicon glyphicon-chevron-down" style="margin-left: 5px;"></span>
          <!-- <span class="fa fa-sort-desc"></span> -->
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" /> -->
            <p>
              {{{ $display_name }}}
              <small>
                @if($myApp->isSU) Super Admin
                @elseif($myApp->utype=='CUSTOMER') Customer
                @elseif($myApp->utype=='USER') User
                  @if($myApp->isCustAdmin)
                    (Administrator)
                  @else
                    (Operator)
                  @endif
                @endif
              </small>
            </p>
          </li>
          @if($myApp->isSU)
            <!-- Menu Body -->
            <li class="user-body">
              <div class="col-xs-6 text-center">
                <span class="fa fa-cog"></span> <a href="{{{ URL::to('appsetting/index') }}}">Settings</a>
              </div>
              <div class="col-xs-6 text-center">
                <span class="fa fa-key"></span> <a href="{{{ URL::route('saaccount.changepassword') }}}">Password</a>
              </div>
            </li>
          @elseif($myApp->utype=='CUSTOMER')
            <!-- Menu Body -->
            <li class="user-body">
              <div class="col-xs-6 text-center">
                <span class="fa fa-cog"></span> <a href="{{{ URL::route('customer.myaccount') }}}">My Account</a>
              </div>
              <div class="col-xs-6 text-center">
                <span class="fa fa-key"></span> <a href="{{{ URL::route('customer.changepassword') }}}">Password</a>
              </div>
            </li>
          @elseif($myApp->utype=='USER')
            @if($myApp->isCustAdmin)
              <!-- Menu Body -->
              <li class="user-body">
                <div class="col-xs-6 text-center">
                  <span class="fa fa-cog"></span> <a href="{{{ URL::route('user.myaccount') }}}">My Account</a>
                </div>
                <div class="col-xs-6 text-center">
                  <span class="fa fa-key"></span> <a href="{{{ URL::route('user.changepassword') }}}">Password</a>
                </div>
              </li>
            @else
              <!-- Menu Body -->
              <li class="user-body">
                <div class="col-xs-6 text-center">
                  <span class="fa fa-cog"></span> <a href="{{{ URL::route('user.useraccount') }}}">My Account</a>
                </div>
                <div class="col-xs-6 text-center">
                  <span class="fa fa-key"></span> <a href="{{{ URL::route('user.changepassword') }}}">Password</a>
                </div>
              </li>
            @endif
          @endif
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="col-xs-12 text-center">
              <a class="btn btn-default btn-block btn-flat" href="javascript:void(0);" onclick="confirmAction( '{{{ URL::to("logout") }}}' , 'Are you sure you want to logout?')">Logout</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>