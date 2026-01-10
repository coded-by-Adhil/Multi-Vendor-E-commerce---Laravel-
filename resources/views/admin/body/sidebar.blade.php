<div class="sidebar-container">
    <aside class="sidebar sidebar-open ">

        <div class="sidebar-all-icons">
            <a href="#"><i class="bi bi-speedometer2 sidebar-icon"></i></a>
            <a href="#"><i class="bi bi-calendar-event-fill sidebar-icon"></i></a>
            <a href="#"><i class="bi bi-pencil-square sidebar-icon"></i></a>
            <a href="#"><i class="bi bi-columns sidebar-icon"></i></a>
            <a href="#"><i class="bi bi-shield sidebar-icon"></i></a>
            <a href="#"><i class="bi bi-receipt-cutoff sidebar-icon"></i></a>   
        </div>
        
    
        <span class="sidebar-heading">MAIN MENU</span><hr class="sidebar-hr">

        <a class="side-bar-link active_sidebar" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 sidebar-icon"></i> &nbsp;<span>Dashboard</span></a>
        <a class="side-bar-link" href="#"><i class="bi bi-calendar-event-fill sidebar-icon"></i>&nbsp;&nbsp;<span>Calender</span></a>

        <!-- First section -->
        <ul class="side-bar-link sidebar_menu" onclick="toggleSidebarDropdown(this)">
            <span><i class="bi bi-pencil-square sidebar-icon"></i>&nbsp;&nbsp;<span>Home page Setup</span></span>
            <i class="bi bi-caret-down circle-arrow arrow"></i>
        </ul>

        <ul class="sub_menu dropdown-close">
            <li class="sidebar_menu_list"><a href="{{ route('home.slide') }}"> <i class="bi bi-window-fullscreen sidebar-icon"></i>&nbsp;Home Slide</a></li>
        </ul>

        <!-- Second section -->
        <ul class="side-bar-link sidebar_menu" onclick="toggleSidebarDropdown(this)">
            <span><i class="bi bi-columns sidebar-icon"></i>&nbsp;&nbsp;<span>About page Setup</span></span>
            <i class="bi bi-caret-down circle-arrow arrow"></i>
        </ul>

        <ul class="sub_menu dropdown-close">
            <li class="sidebar_menu_list"><a href="{{ route('about.page') }}"><i class="bi bi-file-person sidebar-icon"></i>&nbsp;About Page</a></li>
            
        </ul>

        <span class="sidebar-heading">PAGES</span><hr class="sidebar-hr">

        <ul class="side-bar-link sidebar_menu" onclick="toggleSidebarDropdown(this)">
            <span><i class="bi bi-shield sidebar-icon"></i>&nbsp;&nbsp;<span>Authentication</span></span>
            <i class="bi bi-caret-down circle-arrow arrow"></i>
        </ul>

        <ul class="sub_menu dropdown-close">
            <li class="sidebar_menu_list">Login</li>
            <li class="sidebar_menu_list">Register</li>
            <li class="sidebar_menu_list"><a href="{{ route('admin.password.change') }}">Change Password</a></li>
            <li class="sidebar_menu_list">Lock Screen</li>
        </ul>

        <ul class="side-bar-link sidebar_menu" onclick="toggleSidebarDropdown(this)">
            <span><i class="bi bi-receipt-cutoff sidebar-icon"></i>&nbsp;&nbsp;<span>Utility</span></span>
            <i class="bi bi-caret-down circle-arrow arrow"></i>
        </ul>

        <ul class="sub_menu dropdown-close">
            <li class="sidebar_menu_list">Option6</li>
            <li class="sidebar_menu_list">Option2</li>
            <li class="sidebar_menu_list">Option3</li>
        </ul>

    </aside>
</div>
