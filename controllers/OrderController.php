<?php

class OrderController
{
    public function placeOrder(): void
    {
        header('Content-Type: application/json; charset=UTF-8');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['message' => 'Phương thức không được hỗ trợ.']);
            return;
        }

        $payload = json_decode(file_get_contents('php://input'), true);
        $token = $payload['_csrf'] ?? '';
        if (!is_string($token) || empty($_SESSION['_csrf']) || !hash_equals($_SESSION['_csrf'], $token)) {
            http_response_code(419);
            echo json_encode(['message' => 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang.']);
            return;
        }

        $items = $payload['items'] ?? null;
        $customer = $payload['customer'] ?? [];
        $method = $payload['fulfillmentMethod'] ?? '';
        $requiredCustomerFields = ['fullName', 'phone', 'fullAddress'];
        $validCustomer = is_array($customer);
        foreach ($requiredCustomerFields as $field) {
            $validCustomer = $validCustomer && !empty($customer[$field]);
        }
        if (!is_array($items) || !$items || !$validCustomer || !in_array($method, ['delivery', 'pickup'], true)) {
            http_response_code(422);
            echo json_encode(['message' => 'Thông tin đơn hàng không hợp lệ.']);
            return;
        }

        $total = 0;
        foreach ($items as $item) {
            $qty = filter_var($item['quantity'] ?? null, FILTER_VALIDATE_INT);
            $stock = filter_var($item['maxStock'] ?? null, FILTER_VALIDATE_INT);
            $price = filter_var($item['price'] ?? null, FILTER_VALIDATE_INT);
            if ($qty === false || $stock === false || $price === false || $qty < 1 || $stock < 0 || $qty > $stock) {
                http_response_code(422);
                echo json_encode(['message' => 'Số lượng sản phẩm vượt quá tồn kho. Vui lòng cập nhật giỏ hàng.']);
                return;
            }
            $total += $price * $qty;
        }

        try {
            $pdo = new PDO(
                sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME),
                DB_USERNAME,
                DB_PASSWORD,
                DB_OPTIONS
            );
            $orderId = 'DH' . strtoupper(bin2hex(random_bytes(4)));
            $statement = $pdo->prepare('INSERT INTO orders (order_code, customer_name, phone, email, address, note, fulfillment_method, payment_method, total, items, status, created_at) VALUES (:code, :customer, :phone, :email, :address, :note, :method, :payment, :total, :items, :status, NOW())');
            $statement->execute([
                ':code' => $orderId,
                ':customer' => trim((string) ($customer['fullName'] ?? '')),
                ':phone' => trim((string) ($customer['phone'] ?? '')),
                ':email' => trim((string) ($customer['email'] ?? '')),
                ':address' => trim((string) ($customer['fullAddress'] ?? '')),
                ':note' => trim((string) ($customer['note'] ?? '')),
                ':method' => $method,
                ':payment' => 'COD',
                ':total' => $total,
                ':items' => json_encode($items, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                ':status' => 'pending',
            ]);
            echo json_encode(['success' => true, 'orderId' => $orderId, 'total' => $total]);
        } catch (Throwable $exception) {
            http_response_code(500);
            echo json_encode(['message' => 'Không thể lưu đơn hàng. Vui lòng thử lại sau.']);
        }
    }
}
