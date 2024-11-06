<?php
require_once 'config.php';

$edit_id = '';
$edit_name = '';
$edit_description = '';
$edit_price = '';
$edit_quantity = '';

// Load dữ liệu cần edit
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_result = mysqli_query($conn, "SELECT * FROM products WHERE id=$edit_id");
    $edit_data = mysqli_fetch_array($edit_result);
    if ($edit_data) {
        $edit_name = $edit_data['name'];
        $edit_description = $edit_data['description'];
        $edit_price = $edit_data['price'];
        $edit_quantity = $edit_data['quantity'];
    }
}

// Create và Update
if (isset($_POST['save'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update
        $id = $_POST['id'];
        $sql = "UPDATE products SET name='$name', description='$description', 
                price='$price', quantity='$quantity' WHERE id=$id";
    } else {
        // Create
        $sql = "INSERT INTO products (name, description, price, quantity) 
                VALUES ('$name', '$description', '$price', '$quantity')";
    }
    
    mysqli_query($conn, $sql);
    header('location: index.php');
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header('location: index.php');
}

// Get all products
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="card-title">Danh sách Sản phẩm</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                        <i class="bi bi-plus-lg"></i> Thêm Sản phẩm
                    </button>
                </div>

                <!-- Bảng danh sách sản phẩm -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td class="text-truncate" style="max-width: 200px;" title="<?php echo $row['description']; ?>">
                                        <?php echo $row['description']; ?>
                                    </td>
                                    <td class="fw-bold text-danger"><?php echo formatVND($row['price']); ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-warning" onclick="editProduct(<?php echo $row['id']; ?>)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger" onclick="deleteProduct(<?php echo $row['id']; ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Form -->
        <div class="modal fade" id="productModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <?php echo $edit_id ? 'Sửa Sản phẩm' : 'Thêm Sản phẩm Mới' ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Tên sản phẩm:</label>
                                <input type="text" class="form-control" name="name" 
                                       value="<?php echo $edit_name; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Mô tả:</label>
                                <textarea class="form-control" name="description" rows="3"><?php echo $edit_description; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Giá (VNĐ):</label>
                                <input type="number" class="form-control" name="price" 
                                       value="<?php echo $edit_price; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Số lượng:</label>
                                <input type="number" class="form-control" name="quantity" 
                                       value="<?php echo $edit_quantity; ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" name="save" class="btn btn-primary">
                                <?php echo $edit_id ? 'Cập nhật' : 'Thêm Sản phẩm' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS và Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    
    <script>
    function editProduct(id) {
        window.location.href = 'index.php?edit=' + id;
    }

    function deleteProduct(id) {
        if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
            window.location.href = 'index.php?delete=' + id;
        }
    }

    // Hiển thị modal khi có lỗi hoặc đang edit
    <?php if ($edit_id || isset($_GET['error'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('productModal'));
        modal.show();
    });
    <?php endif; ?>
    </script>
</body>
</html>