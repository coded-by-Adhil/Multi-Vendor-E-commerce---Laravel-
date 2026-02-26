<div class="sidebar-container">
    <aside class="sidebar sidebar-open" style="padding: 20px;">
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
            <li class="sidebar_menu_list"><a href="{{ route('home.slide') }}"> <i class="bi bi-dash-lg sidebar-icon"></i>
&nbsp;Home Slide</a></li>
        </ul>

        <!-- Second section -->
        <ul class="side-bar-link sidebar_menu" onclick="toggleSidebarDropdown(this)">
            <span><i class="bi bi-columns sidebar-icon"></i>&nbsp;&nbsp;<span>About page Setup</span></span>
            <i class="bi bi-caret-down circle-arrow arrow"></i>
        </ul>
        <ul class="sub_menu dropdown-close">
            <li class="sidebar_menu_list"><a href="{{ route('about.page') }}"><i class="bi bi-dash-lg sidebar-icon"></i>
&nbsp;About Page</a></li>
             <li class="sidebar_menu_list"><a href="{{ route('about.multi_image_view') }}"><i class="bi bi-dash-lg sidebar-icon"></i>&nbsp;Multi Image Upload</a></li>
             <li class="sidebar_menu_list"><a href="{{ route('about.uploaded_multi_images') }}"><i class="bi bi-dash-lg sidebar-icon"></i>&nbsp;Multi Images</a></li>
        </ul>

        <ul class="side-bar-link sidebar_menu" onclick="toggleSidebarDropdown(this)">
            <span><i class="bi bi-columns sidebar-icon"></i>&nbsp;&nbsp;<span>Portfolio page setup</span></span>
            <i class="bi bi-caret-down circle-arrow arrow"></i>
        </ul>
        <ul class="sub_menu dropdown-close">
            <li class="sidebar_menu_list"><a href="{{ route('all.portfolio') }}"><i class="bi bi-dash-lg sidebar-icon"></i>
&nbsp;All Portfolio</a></li>
             <li class="sidebar_menu_list"><a href="{{ route('add.portfolio') }}"><i class="bi bi-dash-lg sidebar-icon"></i>&nbsp;Add Portfolio</a></li>
        </ul>

        <span class="sidebar-heading">PAGES</span><hr class="sidebar-hr">

        <ul class="side-bar-link sidebar_menu" onclick="toggleSidebarDropdown(this)">
            <span><i class="bi bi-shield sidebar-icon"></i>&nbsp;&nbsp;<span>Authentication</span></span>
            <i class="bi bi-caret-down circle-arrow arrow"></i>
        </ul>

        <ul class="sub_menu dropdown-close">
            <li class="sidebar_menu_list"><i class="bi bi-dash-lg sidebar-icon"></i>&nbsp;Login</li>
            <li class="sidebar_menu_list"><i class="bi bi-dash-lg sidebar-icon"></i>&nbsp;Register</li>
            <li class="sidebar_menu_list"><i class="bi bi-dash-lg sidebar-icon"></i>&nbsp;<a href="{{ route('admin.password.change') }}">Change Password</a></li>
            <li class="sidebar_menu_list"><i class="bi bi-dash-lg sidebar-icon"></i>&nbsp;Lock Screen</li>
        </ul>

        

        <ul class="side-bar-link sidebar_menu" onclick="toggleSidebarDropdown(this)">
            <span><i class="bi bi-receipt-cutoff sidebar-icon"></i>&nbsp;&nbsp;<span>Blogs</span></span>
            <i class="bi bi-caret-down circle-arrow arrow"></i>
        </ul>

        <ul class="sub_menu dropdown-close">

            <li class="sidebar_menu_list"><i class="bi bi-dash-lg sidebar-icon"></i>&nbsp;<a href="{{ route('Add.Blog.Category') }}">Add Blog Category</a></li>

            <li class="sidebar_menu_list"><i class="bi bi-dash-lg sidebar-icon"></i>
&nbsp;Option6</li>
            <li class="sidebar_menu_list"><i class="bi bi-dash-lg sidebar-icon"></i>
&nbsp;Option2</li>
            <li class="sidebar_menu_list"><i class="bi bi-dash-lg sidebar-icon"></i>
&nbsp;Option3</li>


        </ul>

    </aside>
</div>
