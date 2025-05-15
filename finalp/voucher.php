<?php
session_start();
require 'dbConfig.php'; // Include your database connection

// Handle form submission to add a voucher
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addVoucher'])) {
    $voucherCode = trim($_POST['voucherCode']);
    $discountPercentage = intval($_POST['discountPercentage']);
    $image = $_FILES['voucherImage'] ?? null;

    // Validate inputs
    if (!empty($voucherCode) && $discountPercentage > 0 && $discountPercentage <= 100 && $image && $image['error'] === 0) {
        // Check if the voucher code already exists
        $checkStmt = $conn->prepare("SELECT id FROM vouchers WHERE code = ?");
        $checkStmt->bind_param("s", $voucherCode);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $_SESSION['message'] = "Voucher code already exists. Please use a unique code.";
        } else {
            // Handle image upload
            $uploadDir = 'uploads/vouchers/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
            }
            $imagePath = $uploadDir . basename($image['name']);
            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                // Insert voucher into the database
                $stmt = $conn->prepare("INSERT INTO vouchers (code, discount_percentage, image) VALUES (?, ?, ?)");
                $stmt->bind_param("sis", $voucherCode, $discountPercentage, $imagePath);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Voucher added successfully!";
                } else {
                    $_SESSION['message'] = "Failed to add voucher. Please try again.";
                }
            } else {
                $_SESSION['message'] = "Failed to upload the image.";
            }
        }
    } else {
        $_SESSION['message'] = "Invalid input. Please provide valid data and upload an image.";
    }
    if (isset($_SESSION['message'])): ?>
        <div class="success-popup">
        <link rel="stylesheet" href="profile-actions.css">
            <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?> Redirecting to menu...</p>
        </div>
        <script>
            // Redirect to menu.php after 3 seconds
            setTimeout(() => {
                window.location.href = "loghome.php";
            }, 500);
        </script>
    <?php endif;
    exit;
}

// Handle form submission to remove a voucher
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeVoucher'])) {
    $voucherId = intval($_POST['voucherId']);

    if ($voucherId > 0) {
        // Fetch the image path for deletion
        $stmt = $conn->prepare("SELECT image FROM vouchers WHERE id = ?");
        $stmt->bind_param("i", $voucherId);
        $stmt->execute();
        $result = $stmt->get_result();
        $voucher = $result->fetch_assoc();

        if ($voucher) {
            $imagePath = $voucher['image'];

            // Delete voucher from the database
            $stmt = $conn->prepare("DELETE FROM vouchers WHERE id = ?");
            $stmt->bind_param("i", $voucherId);

            if ($stmt->execute()) {
                // Delete the image file
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $_SESSION['message'] = "Voucher removed successfully!";
            } else {
                $_SESSION['message'] = "Failed to remove voucher.";
            }
        } else {
            $_SESSION['message'] = "Voucher not found.";
        }
    } else {
        $_SESSION['message'] = "Invalid input. Please select a valid voucher.";
    }
    if (isset($_SESSION['message'])): ?>
        <div class="success-popup">
        <link rel="stylesheet" href="profile-actions.css">
            <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?> Redirecting to menu...</p>
        </div>
        <script>
            // Redirect to menu.php after 3 seconds
            setTimeout(() => {
                window.location.href = "loghome.php";
            }, 500);
        </script>
    <?php endif;
    exit;
}

// Fetch all vouchers for display
$vouchers = [];
$result = $conn->query("SELECT * FROM vouchers ORDER BY created_at DESC");
if ($result->num_rows > 0) {
    $vouchers = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Management</title>
    <link rel="stylesheet" href="voucher.css">
</head>
<body>
    <h1>Voucher Management</h1>

    <!-- Display Session Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message">
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Add Voucher Form -->
    <form action="voucher.php" method="POST" enctype="multipart/form-data">
        <h2>Add Voucher</h2>
        <label for="voucherCode">Voucher Code:</label>
        <input type="text" id="voucherCode" name="voucherCode" required>
        
        <label for="discountPercentage">Discount Percentage:</label>
        <input type="number" id="discountPercentage" name="discountPercentage" min="1" max="100" required>
        
        <label for="voucherImage">Upload Voucher Image:</label>
        <input type="file" id="voucherImage" name="voucherImage" accept="image/*" required>

        <button type="submit" name="addVoucher">Add Voucher</button>
    </form>

    <!-- Remove Voucher Form -->
    <form action="voucher.php" method="POST">
        <h2>Remove Voucher</h2>
        <label for="voucherId">Select Voucher:</label>
        <select id="voucherId" name="voucherId" required>
            <option value="">-- Select Voucher --</option>
            <?php foreach ($vouchers as $voucher): ?>
                <option value="<?php echo $voucher['id']; ?>">
                    <?php echo htmlspecialchars($voucher['code']) . " (" . $voucher['discount_percentage'] . "%)"; ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" name="removeVoucher">Remove Voucher</button>
    </form>

    <!-- Display Existing Vouchers -->
    <h2>Existing Vouchers</h2>
    <?php if (!empty($vouchers)): ?>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Discount (%)</th>
                    <th>Image</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vouchers as $voucher): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($voucher['code']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['discount_percentage']); ?>%</td>
                        <td>
                            <img src="<?php echo htmlspecialchars($voucher['image']); ?>" alt="Voucher Image" style="width: 100px; height: auto;">
                        </td>
                        <td><?php echo htmlspecialchars($voucher['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No vouchers found.</p>
    <?php endif; ?>
</body>
</html>
