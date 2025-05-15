<?php
session_start();
if(!isset($_SESSION['role'])){
    header("refresh: 0  ; url = login.php");
    exit();
}
// Mock session role for demonstration
$role = $_SESSION['role'] ?? 'guest'; // Default to 'guest' if not logged in
$cart = $_SESSION['cart'] ?? []; // Retrieve cart data from the session
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Canteen</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="loghome.css">
    <!-- Canteen Section CSS -->
    <link rel="stylesheet" href="canteen.css">
    <link rel="stylesheet" href="profile.css">
    <style>
        /* Add basic styling for sections */
        .content-section {
            display: none;
            /* Hide all sections by default */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
        }

        .content-section.active {
            display: block;
            /* Show the active section */
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <header class="header">
        <div class="logo">
            <h1>University Canteen</h1>
        </div>
        <nav class="navbar">
            <ul>


                <!-- Role-Specific Links -->
                <li><a href="#" onclick="showSection('menu')">Food Menu</a></li>
                <li><a href="#" onclick="showSection('Profile')">Profile</a></li>

                <?php if ($role === 'staff'): ?>
                    <li><a href="#" onclick="showSection('allOrders')">All Orders</a></li>
                <?php endif; ?>

                <?php if ($role !== 'staff' && $role !== 'guest'): ?>
                    <li><a href="cart.php" onclick="showSection('cart')">Cart</a></li>
                    <li><a href="#" onclick="showSection('Orders')">Orders</a></li>
                <?php endif; ?>

                <?php if ($role !== 'guest'): ?>
                    <li><a href="#" onclick="showSection('canteens')">Canteens</a></li>
                    <li><a href="#" onclick="showSection('specialItems')">Special Items</a></li>
                    <li><a href="logout.php" class="btn">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Content Sections -->
    <main>

        <!-- Food Menu Section -->
        <section id="menu" class="content-section active">
            <?php include 'menu.php'; ?>
        </section>
        <section id="Profile" class="content-section">
            <link rel="stylesheet" href="profile.css">
            <?php include 'profile.php'; ?>
        </section>
        <!-- Cart Section -->
        <section id="cart" class="content-section">
            <h2>Your Cart</h2>
            <div id="cart-container">

            </div>
        </section>
        <script>
            $(document).ready(function() {
                // Function to dynamically load the cart content
                function loadCart() {
                    $.ajax({
                        url: 'cart.php', // PHP script to fetch cart content
                        type: 'GET',
                        success: function(response) {
                            $('#cart-container').html(response); // Load response into the cart container
                        },
                        error: function() {
                            $('#cart-container').html('<p>Error loading cart. Please try again.</p>');
                        }
                    });
                }

                // Handle Add to Cart button click
                $(document).on('click', '.add-to-cart', function(e) {
                    e.preventDefault();

                    const itemId = $(this).data('id'); // Get item ID from the button

                    $.ajax({
                        url: 'add_to_cart.php', // PHP script to handle adding items to the cart
                        type: 'POST',
                        data: {
                            id: itemId
                        },
                        success: function(response) {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                alert(res.message); // Show success message
                                loadCart(); // Dynamically reload the cart
                            } else {
                                alert(res.message); // Show error message
                            }
                        },
                        error: function() {
                            alert('Failed to add item to cart. Please try again.');
                        }
                    });
                });

                // Handle quantity changes dynamically
                $(document).on('click', '.quantity-controls button', function() {
                    const $parent = $(this).closest('.cart-item');
                    const $quantityInput = $parent.find('.item-quantity');
                    const itemId = $parent.data('id');
                    let quantity = parseInt($quantityInput.val());

                    // Increment or decrement quantity
                    if ($(this).hasClass('increase-quantity')) {
                        quantity += 1;
                    } else if ($(this).hasClass('decrease-quantity') && quantity > 0) {
                        quantity -= 1;
                    }

                    $quantityInput.val(quantity);

                    // Update the cart in the session
                    $.ajax({
                        url: 'cart.php', // Use the same cart.php to handle updates
                        type: 'POST',
                        data: {
                            id: itemId,
                            quantity: quantity
                        },
                        success: function() {
                            loadCart(); // Refresh the cart content after updating
                        },
                        error: function() {
                            alert('Failed to update cart. Please try again.');
                        }
                    });
                });



                // Load cart content dynamically on page load
                loadCart();
            });
        </script>



        <!-- OrdersSection -->
        <section id="Orders" class="content-section">
            <?php include 'order.php'; ?>
        </section>
        <section id="canteens" class="content-section ">
            <?php include 'canteen.php'; ?>
        </section>
        <section id="specialItems" class="content-section">
            <?php include 'specialitem.php'; ?>
        </section>

        <!-- Add this new section for staff -->
        <?php if ($role === 'staff'): ?>
            <section id="allOrders" class="content-section">
                <?php include 'all_orders.php'; ?>
            </section>
        <?php endif; ?>

        <section id="about" class="content-section">
            <h2>About Us</h2>
            <p>Learn more about our mission to provide delicious meals to our students and staff.</p>
        </section>

        <section id="speciality" class="content-section">
            <h2>Our Speciality</h2>
            <p>We take pride in offering fresh, locally sourced meals with a variety of options.</p>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 University Canteen. All Rights Reserved.</p>
    </footer>

    <script>
        /**
         * Show the specified section and hide all others
         * @param {string} sectionId - The ID of the section to show
         */
        function showSection(sectionId) {
            // Get all content sections
            const sections = document.querySelectorAll('.content-section');

            // Hide all sections
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Show the selected section
            document.getElementById(sectionId).classList.add('active');
        }
    </script>
</body>

</html>