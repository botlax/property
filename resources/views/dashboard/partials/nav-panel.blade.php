<div id="nav-panel">
	<a href="#" id="nav-button"><i class="fa fa-bars"></i></a>
	<nav id="sub-nav-mobile">
		<ul>
			<li class="{{$dbClass or ''}}"><a href="{{url('/')}}" title="Dashboard"><i class="fa fa-home"></i></a></li>
			
			<li class="with-dropdown {{$propClass or ''}}"><a href="#" title="Properties"><i class="fa fa-building"></i></a>
				<ul class="dropdown">
					<li><a href="{{url('properties')}}">Properties List</a></li>
					<li><a href="{{url('properties/add')}}">Add Property</a></li>
				</ul>
			</li>

			<li class="with-dropdown {{$userClass or ''}}"><a href="#" title="Owners"><i class="fa fa-user-circle"></i></a>
				<ul class="dropdown">
					<li><a href="{{url('users')}}">Owners List</a></li>
					<li><a href="{{url('users/add')}}">Add Owner</a></li>
				</ul>
			</li>

			<li class="with-dropdown {{$renterClass or ''}}"><a href="#" title="Renters"><i class="fa fa-users"></i></a>
				<ul class="dropdown">
					<li><a href="{{url('renters')}}">Renters List</a></li>
					<li><a href="{{url('renters/add')}}">Add Renter</a></li>
				</ul>
			</li>

			<li class="{{$furnClass or ''}}"><a href="{{url('furnitures')}}" title="Assets"><i class="fa fa-dropbox"></i></a></li>
			
		</ul>
	</nav>

	<nav id="sub-nav">
		<ul>
			<li class="{{$dbClass or ''}}"><a href="{{url('/')}}" title="Dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
			
			<li class="with-dropdown {{$propClass or ''}}"><a href="#" title="Properties"><i class="fa fa-building"></i>Properties</a>
				<ul class="dropdown">
					<li><a href="{{url('properties')}}">Properties List</a></li>
					<li><a href="{{url('properties/add')}}">Add Property</a></li>
				</ul>
			</li>

			<li class="with-dropdown {{$userClass or ''}}"><a href="#" title="Owners"><i class="fa fa-user-circle"></i>Owners</a>
				<ul class="dropdown">
					<li><a href="{{url('users')}}">Owners List</a></li>
					<li><a href="{{url('users/add')}}">Add Owner</a></li>
				</ul>
			</li>

			<li class="with-dropdown {{$renterClass or ''}}"><a href="#" title="Renters"><i class="fa fa-users"></i>Renters</a>
				<ul class="dropdown">
					<li><a href="{{url('renters')}}">Renters List</a></li>
					<li><a href="{{url('renters/add')}}">Add Renter</a></li>
				</ul>
			</li>

			<li class="{{$furnClass or ''}}"><a href="{{url('furnitures')}}" title="Assets"><i class="fa fa-dropbox"></i>Assets</a></li>
			
		</ul>
	</nav>
</div>