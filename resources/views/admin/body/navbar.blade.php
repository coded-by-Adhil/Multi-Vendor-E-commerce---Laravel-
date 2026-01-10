<nav class="navbar">
        <div class="nav-group left LogoAndSearchBar_div"> 
            <a class="brand-link link" href="{{ route('dashboard') }}">
                <img 
                src="{{ $adminData->profile_image 
                    ? asset('storage/' . $adminData->profile_image) 
                    : asset('backend/assets/images/Black White Logo.png') }}" 
                width="40" 
                height="40" 
                alt="">

                
                <span class="logo_name">Nexihibit</span>
            </a>
            <button class="sidebar_button" onclick="VisibilityOfSidebar(this)" ><i class="bi bi-list"></i></button>
            <input type="text" class="searchbar" placeholder="Search...">
        </div>

        <div class="nav-group right">
            <button class="fullview"><i class="bi bi-arrows-fullscreen"></i></button>

                <div class="profile-dropdown-container">
                <!-- Trigger -->
                <div class="user-profile" onclick="toggleProfileMenu()">

                    <img 
                        src="{{ $adminData->profile_image 
                            ? asset('storage/' . $adminData->profile_image) 
                            : asset('backend/assets/images/Black White Logo.png') }}" 
                        width="40" 
                        height="40" 
                        alt="">

                    <span>Admin</span>
                    <i class="bi bi-chevron-down profile-arrow" id="profileArrow"></i>
                </div>
                
                <!-- Dropdown Menu -->
                <div class="profile-menu" id="profileMenu">
                    <a href="{{ route('admin.profile') }}" class="profile-menu-item">
                        <i class="bi bi-person"></i> Profile
                    </a>
                    <a href="{{ route('admin.password.change') }}" class="profile-menu-item">
                        <i class="bi bi-shield-lock-fill"></i> Password Change
                    </a>
                    <a href="#" class="profile-menu-item">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                    <div class="divider"></div>
                    <a href="{{ route('admin.logout') }}" class="profile-menu-item text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>


        </div>
</nav>