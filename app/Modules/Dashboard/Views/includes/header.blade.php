<nav id="globalnav" class="globalnav uk-navbar">
	<ul class="gn-logo">
		<li class="gn-hidden"><a style="font-size: 24px;" href="{{URL('/dashboard')}}">Si Emas Terpadu</a></li>
		<li><button id="toggle-side"><i class="uk-icon-navicon uk-icon-small"></i></button></li>
	</ul>
	<!-- <ul class="uk-navbar-nav gn-search">
		<li>
			<form class="uk-search" action="" data-uk-search>
				<ul>
					<li><input class="uk-search-field" type="text" placeholder="Cari Disini"></li>
				</ul>
			</form>
		</li>
	</ul> -->
	<div class="uk-navbar-flip gn-account">
		<ul class="gn-account-list">
			<li>
				<div class="link" data-uk-dropdown="{mode:'click'}">
                    <ul>
                        <li><div class="image"><img src="{{ URL('/assets/img/user_icon.png') }}" alt=""></div></li>
                        <li class="uk-hidden-medium uk-hidden-small"><span>{{ ucwords(strtolower(auth()->guard('admin')->user()->fullname)) }}</span></li>
                        <li><span><i class="uk-icon-angle-down"></i></span></li>
                    </ul>
                    <div class="uk-dropdown uk-dropdown-bottom">
                        <ul>
                            <li><a href="{{ URL('/pengaturan/pengguna') }}"><i class="uk-icon-cog"></i>Pengaturan Akun</a></li>
                            <li><a href="{{ URL('/logout') }}"><i class="uk-icon-sign-out"></i>Keluar</a></li>
                        </ul>
                    </div>
                </div>
			</li>
		</ul>
	</div>
</nav>
<div class="globalnav-placeholder"></div>
