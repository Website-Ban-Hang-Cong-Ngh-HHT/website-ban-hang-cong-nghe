<?php

/**
 * Model quản lý tài khoản người dùng (bảng `users` trong MySQL)
 */
class UserModel extends BaseModel
{
    protected $table = 'users';

    /**
     * Tìm tài khoản theo tên đăng nhập HOẶC email (dùng cho form đăng nhập)
     */
    public function findByLogin(string $login): array|false
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE username = :login OR email = :login
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['login' => $login]);

        return $stmt->fetch();
    }

    public function findByUsername(string $username): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);

        return $stmt->fetch();
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }

    /**
     * Thêm tài khoản mới, trả về ID vừa tạo
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (full_name, username, email, phone, password, role)
                VALUES (:full_name, :username, :email, :phone, :password, :role)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'full_name' => $data['full_name'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'password'  => $data['password'],
            'role'      => $data['role'] ?? 'customer',
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Danh sách khách hàng (phục vụ tab quản lý khách hàng của Admin)
     */
    public function allCustomers(): array
    {
        $sql = "SELECT id, full_name, username, email, phone, role, created_at
                FROM {$this->table}
                WHERE role = 'customer'
                ORDER BY id DESC";

        return $this->pdo->query($sql)->fetchAll();
    }
}
