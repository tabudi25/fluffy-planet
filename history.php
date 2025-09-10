<?php
// Include database connection
require_once 'db.php';

// Fetch all orders from database
$sql = "SELECT * FROM orders ORDER BY date DESC, id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluffy Planet - Order History</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff8f1;
            color: #2c2c2c;
            line-height: 1.6;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background-color: #fff;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            flex: 1;
            display: flex;
            justify-content: center;
            margin-right: 150px;
        }

        nav a {
            margin: 0 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 5px;
            border-radius: 10px;
        }

        nav a:hover {
            background-color: #7c7a78;
        }

        .order {
            text-decoration: underline;
            background-color: #eccfb2;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .box {
            background-color: #fff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        table th,
        table td {
            padding: 12px 8px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        table th {
            background-color: #eccfb2;
            color: #2c2c2c;
            font-weight: bold;
        }

        .status {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
        }

        .pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .processing {
            background-color: #cce5ff;
            color: #004085;
        }

        .completed {
            background-color: #d4edda;
            color: #155724;
        }

        .cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .actions a {
            text-decoration: none;
            color: #4caf50;
            font-weight: 500;
            margin-right: 10px;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .box {
                padding: 15px;
            }

            table {
                font-size: 14px;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">🐾 Fluffy Planet</div>
        <nav>
            <a href="petshop.php">Home</a>
            <a href="categories.php">Categories</a>
            <a href="newarrival.php">New Arrivals</a>
            <a href="order.php">Order</a>
            <a href="order_transactions.php">Order Transaction</a>
            <a href="history.php" class="order">History</a>
        </nav>
    </header>

    <div class="container">
        <div class="box">
            <h2>Order History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Gmail</th>
                        <th>Tel Number</th>
                        <th>Animal</th>
                        <th>Total</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($order = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['date']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer']); ?></td>
                                <td><?php echo htmlspecialchars($order['gmail']); ?></td>
                                <td><?php echo htmlspecialchars($order['tel_number']); ?></td>
                                <td>
                                    <?php 
                                    // Parse animal JSON data and display nicely
                                    $animals = json_decode($order['animal'], true);
                                    if ($animals && is_array($animals)) {
                                        $animalList = [];
                                        foreach ($animals as $animal) {
                                            $animalList[] = $animal['name'] . ' (x' . $animal['qty'] . ')';
                                        }
                                        echo htmlspecialchars(implode(', ', $animalList));
                                    } else {
                                        echo htmlspecialchars($order['animal']);
                                    }
                                    ?>
                                </td>
                                <td>$<?php echo number_format($order['total'], 2); ?></td>
                                <td><span class="status <?php echo strtolower($order['payment_status']); ?>"><?php echo ucfirst($order['payment_status']); ?></span></td>
                                <td><span class="status <?php echo strtolower($order['order_status']); ?>"><?php echo ucfirst($order['order_status']); ?></span></td>
                                <td class="actions"><a href="#">View</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" style="text-align:center; color:#777;">No orders found in database</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>