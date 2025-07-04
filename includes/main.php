<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("functions/functions.php");
include("includes/header.php");
?>

</head>
<div id="preloader">
    <div class="circle-container">
        <div class="circle"></div>
        <div id="loading-text">Loading...</div>
    </div>
</div>

<!-- Page content initially hidden -->
<div id="page-content" style="display:none;">
    <!-- Your entire page content goes here -->
</div>

<header>
    <a href="index.php" class="logo"><img src="images/Capture.jpg" alt=""></a>
    <ul class="navmenu">
        <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
        <li class="<?php echo ($current_page == 'shop.php') ? 'active' : ''; ?>"><a href="shop.php">Shop</a></li>

        <!-- Men -->
        <li class="dropdown">
            <a href="#">Men<i class="bx bx-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <?php getPCats(8); ?>
            </ul>
        </li>

        <!-- Women -->
        <li class="dropdown">
            <a href="#">Women<i class="bx bx-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <?php getPCats(9); ?>
            </ul>
        </li>

        <!-- Kids -->
        <li class="dropdown">
            <a href="#">Kids<i class="bx bx-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <?php getPCats(10); ?>
            </ul>
        </li>

        <!-- Accessories -->
        <li class="dropdown">
            <a href="#">Accessories<i class="bx bx-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <?php getPCats(11); ?>
            </ul>
        </li>
    </ul>
    <div class="nav-icon">
        <a href="#" id="search-icon"><i class="bx bx-search"></i></a>
         <!-- Search Bar -->
         <div id="search-bar" class="search-bar hidden">
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Search for products..." required>
                <button type="submit"><i class="bx bx-search"></i></button>
            </form>
        </div>

        <!-- User Dropdown -->
        <div class="user-dropdown">
            <a href="#" id="user-icon"><i class="bx bx-user"></i></a>
            <ul class="user-dropdown-menu">
                <?php if (isset($_SESSION['cust_email'])): ?>
                    <li><a href="wishlist.php"><i class="bx bx-heart"></i> Wishlist</a></li>
                    <li><a href="account.php?my_order"><i class="bx bx-archive"></i> Orders</a></li>
                    <li><a href="account.php?customer_refund"><i class="bx bx-rotate-left"></i> Returns</a></li>
                    <li><a href="account.php?edit_account"><i class="fa fa-user"></i> My Account</a></li>
                    <li><a href="logout.php"><i class="bx bx-log-out"></i> Logout</a></li>
                <?php else: ?>
                    <li><a href="customer_login.php"><i class="bx bx-log-in"></i> Login</a></li>
                    <li><a href="customer_registration.php"><i class="bx bx-user-plus"></i> Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <a href="cart.php"><i class="bx bx-cart"></i> <span class="cart-badge"><?php item(); ?></span></a>

        <div class="bx bx-menu" id="menu-icon"></div>
    </div>
</header>

<script>
    document.querySelector('.user-dropdown-toggle').addEventListener('click', function () {
        const dropdownMenu = document.querySelector('.user-dropdown-menu');
        dropdownMenu.classList.toggle('show');
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loadingBar = document.getElementById('loading-bar');

        // Start loading animation
        loadingBar.style.width = '100%';

        // Simulate a delay for demonstration purposes
        setTimeout(() => {
            loadingBar.classList.add('complete');

            // Remove the loading bar after animation
            setTimeout(() => {
                loadingBar.remove();
            }, 400);
        }, 1000); // Adjust time as needed for real-world scenarios
    });
</script>
<script>
    window.addEventListener('load', () => {
        // Add 'loaded' class to the body to hide the preloader
        document.body.classList.add('loaded');
    });
</script>
<script>
    // Toggle menu visibility
    const menuIcon = document.getElementById('menu-icon');
    const navMenu = document.querySelector('.navmenu');

    menuIcon.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
</script>
<script>
    document.querySelectorAll('.dropdown-toggle').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default link behavior
            const dropdown = this.closest('.dropdown');
            dropdown.classList.toggle('open'); // Toggle 'open' class to show/hide the dropdown
        });
    });

</script>
<script>
    // Toggle the visibility of the search bar
    const searchIcon = document.getElementById('search-icon');
    const searchBar = document.getElementById('search-bar');

    searchIcon.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default link behavior
        searchBar.classList.toggle('visible');
        searchBar.classList.toggle('hidden');
    });

    // Close the search bar if clicked outside
    document.addEventListener('click', (e) => {
        if (!searchBar.contains(e.target) && !searchIcon.contains(e.target)) {
            searchBar.classList.add('hidden');
            searchBar.classList.remove('visible');
        }
    });
</script>
