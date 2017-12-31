<div id="user-wrap">
	
</div>
<nav id="nav">
	<ul>
		<li class="with-dropdown"><a href="#"><i class="fa fa-user"></i>Hi Admin!</a>
		<ul class="dropdown">
			@if(\Auth::check() && \Auth::user()->role == 'admin')
			<li><a href="{{url('admins')}}"><i class="fa fa-wrench"></i>Manage Admins</a></li>
			@endif
			<li><a href="{{url('passwords')}}"><i class="fa fa-lock"></i>Change Password</a></li>
			<li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout</a></li>
		</ul>
		</li><li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout</a></li><li><a href="{{url('settings')}}"><i class="fa fa-cog"></i>App Settings</a></li>
	</ul>

	<ul id="nav-mobile">
		<li class="with-dropdown"><a href="#"><i class="fa fa-user"></i></a>
		<ul class="dropdown">
			@if(\Auth::check() && \Auth::user()->role == 'god')
			<li><a href="{{url('admins')}}"><i class="fa fa-wrench"></i>Manage Admins</a></li>
			@endif
			<li><a href="{{url('passwords')}}"><i class="fa fa-lock"></i>Change Password</a></li>
			<li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout</a></li>
		</ul>
		</li><li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i></a></li><li><a href="{{url('settings')}}"><i class="fa fa-cog"></i></a></li>

	</ul>
</nav>