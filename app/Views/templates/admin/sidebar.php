<aside class="app-navbar">
    <div class="sidebar-nav scrollbar">
        <ul class="metismenu" id="sidebarNav">
            <li class="nav-static-title">Navigation Panel</li>
            <li <?php if($currentpage == 'dashboard') { echo 'class="active"'; } ?>>
                <a href="/admin/dashboard" aria-expanded="false">
                    <i class="nav-icon fa fa-dashboard"></i>
                    <span class="nav-title">Dashboard</span>
                </a>
            </li>
            <li <?php if($currentpage == 'adduser' || $currentpage == 'usermasterlist') { echo 'class="active"'; } ?>>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="nav-icon ti ti-user"></i>
                    <span class="nav-title">Users</span>
                </a>
                <ul aria-expanded="false">
                    <li <?php if($currentpage == 'adduser') { echo 'class="active"'; } ?>> <a href='/admin/add-user'>Add User</a> </li>
                    <li <?php if($currentpage == 'usermasterlist') { echo 'class="active"'; } ?>> <a href='/admin/user-masterlist'>User Masterlist</a> </li>
                </ul>
            </li>
            <li <?php if($currentpage == 'messages') { echo 'class="active"'; } ?>>
                <a href="/admin/messages" aria-expanded="false">
                    <i class="nav-icon fa fa-envelope-o"></i>
                    <span class="nav-title">Messages</span>
                </a>
            </li>
            <li <?php if($currentpage == 'sendnewsletter') { echo 'class="active"'; } ?>>
                <a href="/admin/send-newsletter" aria-expanded="false">
                    <i class="nav-icon fa fa-newspaper-o"></i>
                    <span class="nav-title">Send Newsletter</span>
                </a>
            </li>
            <li <?php if($currentpage == 'addproduct' || $currentpage == 'productmasterlist') { echo 'class="active"'; } ?>>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="nav-icon fa fa-archive"></i>
                    <span class="nav-title">Product</span>
                </a>
                <ul aria-expanded="false">
                    <li <?php if($currentpage == 'addproduct') { echo 'class="active"'; } ?>> <a href='/admin/add-product'>Add Product</a> </li>
                    <li <?php if($currentpage == 'productmasterlist') { echo 'class="active"'; } ?>> <a href='/admin/product-masterlist'>Product Masterlist</a> </li>
                </ul>
            </li>
            <li <?php if($currentpage == 'addnews' || $currentpage == 'newsmasterlist') { echo 'class="active"'; } ?>>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="nav-icon fa fa-newspaper-o"></i>
                    <span class="nav-title">News</span>
                </a>
                <ul aria-expanded="false">
                    <li <?php if($currentpage == 'addnews') { echo 'class="active"'; } ?>> <a href='/admin/add-news'>Add News</a> </li>
                    <li <?php if($currentpage == 'newsmasterlist') { echo 'class="active"'; } ?>> <a href='/admin/news-masterlist'>News Masterlist</a> </li>
                </ul>
            </li>
            <li <?php if($currentpage == 'media') { echo 'class="active"'; } ?>>
                <a href="/admin/media" aria-expanded="false">
                    <i class="nav-icon fa fa-camera"></i>
                    <span class="nav-title">Media</span>
                </a>
            </li>
            <li <?php if($currentpage == 'addcommercialnetwork' || $currentpage == 'commercialnetworkmasterlist') { echo 'class="active"'; } ?>>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="nav-icon fa fa-globe"></i>
                    <span class="nav-title">Commercial Network</span>
                </a>
                <ul aria-expanded="false">
                    <li <?php if($currentpage == 'addcommercialnetwork') { echo 'class="active"'; } ?>> <a href='/admin/add-commercial-network'>Add Commercial Network</a> </li>
                    <li <?php if($currentpage == 'commercialnetworkmasterlist') { echo 'class="active"'; } ?>> <a href='/admin/commercial-network-masterlist'>Commercial Network Masterlist</a> </li>
                </ul>
            </li>
            <li <?php if($currentpage == 'adddocumentation' || $currentpage == 'documentationmasterlist') { echo 'class="active"'; } ?>>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="nav-icon fa fa-file-alt"></i>
                    <span class="nav-title">Documentations</span>
                </a>
                <ul aria-expanded="false">
                    <li <?php if($currentpage == 'adddocumentation') { echo 'class="active"'; } ?>> <a href='/admin/add-documentation'>Add Documentation</a> </li>
                    <li <?php if($currentpage == 'documentationmasterlist') { echo 'class="active"'; } ?>> <a href='/admin/documentation-masterlist'>Documentation Masterlist</a> </li>
                </ul>
            </li>
            <li <?php if($currentpage == 'subscribersmasterlist') { echo 'class="active"'; } ?>>
                <a href="/admin/subscribers-masterlist" aria-expanded="false">
                    <i class="nav-icon fa fa-users"></i>
                    <span class="nav-title">Subscribers Masterlist</span>
                </a>
            </li>
            <li class="nav-static-title">Logout</li>
            <li>
                <a href="/admin/logout" aria-expanded="false">
                    <i class="nav-icon ti ti-power-off"></i>
                    <span class="nav-title">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>