<div id="sidebar-wrapper" class="admin-sidebar">
    <ul class="list-group rounded-0">
        <li class="list-group-item bg-dark dashboard">
            <a href="{{ route('home') }}" class="">
               <i class="menu-icon fa fa-tachometer"></i> DASHBOARD
            </a>
        </li>
    </ul>
    <div class="sidebar-nav">
        <div class="list-group">
            <a href="{{ route('categories.index') }}" class="list-group-item list-group-item-action">
                <span>
                    <i class="fa fa-cart-arrow-down"></i>
                </span>
                <span>Categories</span>
            </a>
        </div>
        <div class="list-group">
            <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">
                <span>
                    <i class="fa fa-cart-arrow-down"></i>
                </span>
                <span>Products</span>
            </a>
        </div>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
                <span>
                    <i class="fa fa-money"></i>
                </span>
                <span>Orders</span>
            </a>
        </div>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
                <span>
                    <i class="fa fa-money"></i>
                </span>
                <span>Payments</span>
            </a>
        </div>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
                <span>
                    <i class="fa fa-user"></i>
                </span>
                <span>Users</span>
            </a>
        </div>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
                <span>
                    <i class="fa fa-cogs"></i>
                </span>
                <span>Analytics</span>
            </a>
        </div>
    </div>
</div>
