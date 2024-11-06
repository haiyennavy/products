CREATE DATABASE product_management;
USE product_management;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO products (name, description, price, quantity) VALUES
('Apple Mac mini (M2 chip)', 'Máy tính để bàn nhỏ gọn, mạnh mẽ với chip M2 mới nhất của Apple.', 12990000, 15),
('iPhone 15 Pro Max (128GB)', 'Điện thoại thông minh cao cấp nhất của Apple với màn hình Super Retina XDR, hệ thống camera Pro và chip A17 Bionic.', 33990000, 20),
('Samsung Galaxy S23 Ultra', 'Điện thoại Android hàng đầu với camera 200MP, bút S Pen tích hợp và hiệu năng mạnh mẽ.', 25990000, 12),
('Sony WH-1000XM5', 'Tai nghe chống ồn chủ động cao cấp với chất lượng âm thanh tuyệt vời và thiết kế thoải mái.', 8990000, 30),
('Nintendo Switch OLED', 'Máy chơi game di động với màn hình OLED sống động, chân đế rộng hơn và bộ nhớ trong lớn hơn.', 7490000, 8);