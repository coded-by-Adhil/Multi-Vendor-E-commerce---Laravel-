<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin | Dashboard</title>

    <!-- Bootstrap CSS -->
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    >

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- DataTables CSS -->
    <link 
        rel="stylesheet" 
        href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css"
    >

    <!-- Google Fonts -->
    <link 
        rel="stylesheet" 
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
    >

    <!-- Main Style CSS -->
    <link 
        rel="stylesheet" 
        href="{{ asset('backend/assets/css/main.css') }}"
    >

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

</head>

<body>

    @include('admin.body.navbar')

    <div class="layout-main-container">

     <div class="layou-sub-container">

        @include('admin.body.sidebar')

        <div class="main-content">

              <div class="main-scroll-content">
                 <div class="mainContentHeading">
                    <span class="header"><i class="bi bi-claude"></i>&nbsp;&nbsp;{{ $title }}</span>
                    <span class="location">Nexihibit > {{ $title }}</span>
                </div>
                @yield('admin')
            </div>

            <footer class="dashboard-footer">
                @include('admin.body.footer')
            </footer>
            
        </div>

        
     </div>
     
    </div>


    <!-- ============================================ -->
    <!-- ALL SCRIPTS MUST LOAD BEFORE ANY jQuery CODE -->
    <!-- ============================================ -->

    <!-- jQuery (load FIRST) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <!-- NOW your custom scripts can use jQuery ($) -->
    <script>
        /** Profile Dropdown Logic */
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            const arrow = document.getElementById('profileArrow');

            menu.classList.toggle('show');
            arrow.style.transform = menu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
        }

        window.addEventListener('click', function(e) {
            const container = document.querySelector('.profile-dropdown-container');

            if (!container.contains(e.target)) {
                document.getElementById('profileMenu')?.classList.remove('show');
                document.getElementById('profileArrow').style.transform = 'rotate(0deg)';
            }
        });


       /** Sidebar Visibility (Hamburger Menu) */
        function VisibilityOfSidebar() {
            const sidebar = document.querySelector(".sidebar");
            if (!sidebar) return;

            const isOpen = sidebar.classList.contains("sidebar-open");
            const iconsWrapper = document.querySelector(".sidebar-all-icons");
            
            // Select only direct span/heading/arrow children to hide, not the whole content
            const labels = sidebar.querySelectorAll("span, .sidebar-heading, .arrow, hr");

            if (isOpen) {
                sidebar.classList.remove("sidebar-open");
                sidebar.classList.add("sidebar-close");
                sidebar.style.width = "80px"; // AdminLTE style collapsed width

                labels.forEach(el => el.style.visibility = "hidden");
                if(iconsWrapper) iconsWrapper.style.display = "flex";
            } else {
                sidebar.classList.remove("sidebar-close");
                sidebar.classList.add("sidebar-open");
                sidebar.style.width = "250px";

                labels.forEach(el => el.style.visibility = "visible");
                if(iconsWrapper) iconsWrapper.style.display = "none";
            }
        }


        /** Sidebar Dropdown */
       

        function toggleSidebarDropdown(trigger) {
          
            const dropdown = trigger.nextElementSibling;
          
            const arrow = trigger.querySelector(".arrow");

            if (!dropdown) return;

         
            dropdown.classList.toggle("dropdown");
            dropdown.classList.toggle("dropdown-close");

           
            if (arrow) {
                arrow.classList.toggle("dropdown-open-arrow");
            }
        }


        /** Datatable Init */
        $(document).ready(function () {
            if ($("#myTable").length) {
                new DataTable('#myTable');
            }
        });


        /** Toastr Helper */
        function showToast(type, message) {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
            };
            switch(type) {
                case 'success':
                    toastr.success(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
                default:
                    toastr.info(message);
            }
        }


        // Initialize Summernote
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Write your detailed content here...',
                tabsize: 2,
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        // Image Preview Logic
        function previewAbImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('ab-preview-img').src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

         function previewHsImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('hs-preview-img').src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }


        $(document).ready(function() {
            $('#imageTable').DataTable({
                responsive: true,
                order: [[1, 'desc']], // Default sort by Created At (descending)
                columnDefs: [
                    { orderable: false, targets: [0, 3] } // Disable sorting on Image and Actions columns
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search images..."
                }
            });
        });

        function confirmDelete() {
            if(confirm("Are you sure you want to delete this image? This action cannot be undone.")) {
                alert("Image deleted successfully.");

            }
        }
    </script>
    </script>

</body>
</html>