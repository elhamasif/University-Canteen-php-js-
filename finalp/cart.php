<?php
session_start();
require 'dbConfig.php'; // Include database connection

// Get the user's role from the session
$role = $_SESSION['role'] ?? 'guest';

// Handle AJAX updates to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if ($itemId !== null && isset($_SESSION['cart'][$itemId])) {
        if ($quantity > 0) {
            // Update the quantity in the session
            $_SESSION['cart'][$itemId]['quantity'] = $quantity;
        } else {
            // Remove the item if the quantity is 0
            unset($_SESSION['cart'][$itemId]);
        }

        // Calculate totals
        $cart = $_SESSION['cart'] ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if (empty($cart)) {
            echo json_encode(['status' => 'redirect', 'url' => 'loghome.php']);
        } else {
            echo json_encode(['status' => 'success', 'cart' => $cart, 'subtotal' => $total, 'total' => $total]);
        }
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid item ID or quantity.']);
    exit;
}

// Display the cart for a GET request
$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="cart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="cart-container">
        <!-- Cart Items Section -->
        <div id="cart-items" class="cart-items">
            <?php if (!empty($cart)) : ?>
                <?php foreach ($cart as $id => $item) : ?>
                    <div class="cart-item" data-id="<?php echo $id; ?>">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>Price: $<span class="item-price"><?php echo number_format($item['price'], 2); ?></span></p>
                        <div class="quantity-controls">
                            <button class="decrease-quantity">-</button>
                            <input type="number" class="item-quantity" value="<?php echo $item['quantity']; ?>" min="0">
                            <button class="increase-quantity">+</button>
                        </div>
                        <p>Total: $<span class="item-total"><?php echo number_format($item['price'] * $item['quantity'], 2); ?></span></p>
                        <button class="remove-item">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>

        <!-- Cart Summary Section -->
        <div class="cart-summary">
            <?php if (!empty($cart)) : ?>
                <h2>Cart Summary</h2>

                <div class="voucher-section">
                    <label for="voucher-code">Enter Voucher Code:</label>
                    <input type="text" id="voucher-code" placeholder="Voucher Code">
                    <button id="apply-voucher">Apply</button>
                    <p id="discount-message"></p>
                </div>

                <p><strong>Subtotal:</strong> $<span id="subtotal"><?php echo number_format($total, 2); ?></span></p>
                <p><strong>Total:</strong> $<span id="total"><?php echo number_format($total, 2); ?></span></p>
                <?php if ($role === 'student') : ?>
                    <div class="delivery-section">
                        <form id="checkout-form" action="place-order.php" method="POST">
                            <input type="hidden" name="total" id="total-input" value="<?php echo number_format($total, 2); ?>">
                            <button type="submit">Check Out</button>
                        </form>
                    </div>
                <?php endif; ?>
                <!-- <button id="place-order" onclick="window.location.href='place-order.php';">Place Pickup Order</button> -->
                <!-- <form id="checkout-form" action="checkout.php" method="POST">
                    <input type="hidden" name="total" id="total-input" value="<?php echo number_format($total, 2); ?>">
                    <button type="submit">Check Out</button>
                </form> -->
                <!-- Faculty Delivery Option -->
                <?php if ($role === 'faculty') : ?>
                    <div class="delivery-section">
                    <form id="checkout-form" action="checkout.php" method="POST">
                        <input type="hidden" name="total" id="total-input" value="<?php echo number_format($total, 2); ?>">
                            <label for="room-number">Enter Room Number for Delivery:</label>
                            <input type="text" id="room-number" name="room-number" placeholder="Room Number" required>
                            <button type="submit">Check Out</button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <script>
    let discountRate = 0;

    function updateTotals() {
        let subtotal = 0;
        $('.cart-item').each(function () {
            const price = parseFloat($(this).find('.item-price').text());
            const quantity = parseInt($(this).find('.item-quantity').val());
            const itemTotal = price * quantity;

            $(this).find('.item-total').text(itemTotal.toFixed(2));
            subtotal += itemTotal;
        });
        const discountedTotal = subtotal - (subtotal * discountRate);
        $('#subtotal').text(subtotal.toFixed(2));
        $('#total').text(discountedTotal.toFixed(2));
        $('#total-input').val(discountedTotal.toFixed(2)); // Update the hidden input field
    }

    // Apply voucher
    $('#apply-voucher').on('click', function () {
        const voucherCode = $('#voucher-code').val();
        $.ajax({
            url: 'validate_voucher.php',
            type: 'POST',
            data: { code: voucherCode },
            success: function (response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    discountRate = res.discount / 100;
                    $('#discount-message').text(`Voucher applied! ${res.discount}% discount.`);
                } else {
                    discountRate = 0;
                    $('#discount-message').text(res.message);
                }
                updateTotals(); // Update totals after applying the voucher
            }
        });
    });

    // Initial calculation
    updateTotals();
</script>
    <script>
        $(document).ready(function() {
            let discountRate = 0;

function updateCartSummary() {
    let subtotal = 0;
    $('.cart-item').each(function () {
        const price = parseFloat($(this).find('.item-price').text());
        const quantity = parseInt($(this).find('.item-quantity').val());
        const itemTotal = price * quantity;

        $(this).find('.item-total').text(itemTotal.toFixed(2));
        subtotal += itemTotal;
    });
    const discountedTotal = subtotal - (subtotal * discountRate);
    $('#subtotal').text(subtotal.toFixed(2));
    $('#total').text(discountedTotal.toFixed(2));
}

// Apply voucher
$('#apply-voucher').on('click', function () {
    const voucherCode = $('#voucher-code').val();
    $.ajax({
        url: 'validate_voucher.php',
        type: 'POST',
        data: { code: voucherCode },
        success: function (response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                discountRate = res.discount / 100;
                $('#discount-message').text(`Voucher applied! ${res.discount}% discount.`);
            } else {
                discountRate = 0;
                $('#discount-message').text(res.message);
            }
            updateCartSummary();
        },
        error: function () {
            $('#discount-message').text('Failed to validate voucher.');
        }
    });
});

// Ensure no duplicate event handlers
$(document).on('click', '.increase-quantity', function () {
    const $quantityInput = $(this).siblings('.item-quantity');
    const currentQuantity = parseInt($quantityInput.val()) || 0;
    const newQuantity = currentQuantity + 1;

    $quantityInput.val(newQuantity).trigger('change');
});

$(document).on('click', '.decrease-quantity', function () {
    const $quantityInput = $(this).siblings('.item-quantity');
    const currentQuantity = parseInt($quantityInput.val()) || 0;
    const newQuantity = Math.max(0, currentQuantity - 1);

    $quantityInput.val(newQuantity).trigger('change');
});

$(document).on('change', '.item-quantity', function () {
    const $cartItem = $(this).closest('.cart-item');
    const itemId = $cartItem.data('id');
    const newQuantity = parseInt($(this).val());

    // Ensure only valid numeric quantities are processed
    if (isNaN(newQuantity) || newQuantity < 0) {
        alert('Invalid quantity!');
        return;
    }

    // Send AJAX request to update the cart on the server
    $.ajax({
        url: 'cart.php',
        type: 'POST',
        data: { id: itemId, quantity: newQuantity },
        success: function (response) {
            const res = JSON.parse(response);
            if (res.status === 'redirect') {
                window.location.href = res.url;
            } else if (res.status === 'success') {
                updateCartSummary();
                if ($('.cart-item').length === 0) {
                    window.location.href = 'loghome.php';
                }
            }
        },
        error: function () {
            console.error('Failed to update quantity.');
        }
    });
});

$(document).on('click', '.remove-item', function () {
    const $cartItem = $(this).closest('.cart-item');
    const itemId = $cartItem.data('id');

    $.ajax({
        url: 'cart.php',
        type: 'POST',
        data: { id: itemId, quantity: 0 },
        success: function (response) {
            const res = JSON.parse(response);
            if (res.status === 'redirect') {
                window.location.href = res.url;
            } else if (res.status === 'success') {
                $cartItem.remove();
                updateCartSummary();
                if ($('.cart-item').length === 0) {
                    window.location.href = 'loghome.php';
                }
            }
        },
        error: function () {
            console.error('Failed to remove item.');
        }
    });
});
        });
    </script>
</body>

</html>