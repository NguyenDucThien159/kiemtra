<?php
require_once 'config.php';

// Xử lý phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 5;
$offset = ($page - 1) * $recordsPerPage;

// Truy vấn lấy danh sách nhân viên
$query = "SELECT nv.*, pb.Ten_Phong 
          FROM NHANVIEN nv 
          JOIN PHONGBAN pb ON nv.Ma_Phong = pb.Ma_Phong 
          LIMIT $offset, $recordsPerPage";
$result = $conn->query($query);

// Đếm tổng số nhân viên
$totalQuery = "SELECT COUNT(*) as total FROM NHANVIEN";
$totalResult = $conn->query($totalQuery);
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $recordsPerPage);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Nhân Viên</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { background-color: #f2f2f2; }
        .gender-icon { width: 20px; height: 20px; }
        .pagination { 
            margin-top: 20px; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1>THÔNG TIN NHÂN VIÊN</h1>
    <table>
        <thead>
            <tr>
                <th>Mã Nhân Viên</th>
                <th>Tên Nhân Viên</th>
                <th>Giới Tính</th>
                <th>Nơi Sinh</th>
                <th>Tên Phòng</th>
                <th>Lương</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Ma_NV']); ?></td>
                <td><?php echo htmlspecialchars($row['Ten_NV']); ?></td>
                <td>
                    <?php 
                    // Tạo icons giới tính
                    $genderIcon = ($row['Phai'] == 'NU') ? 'woman.jpg' : 'man.jpg';
                    echo "<img src='images/$genderIcon' class='gender-icon' alt='{$row['Phai']}'>";
                    ?>
                </td>
                <td><?php echo htmlspecialchars($row['Noi_Sinh']); ?></td>
                <td><?php echo htmlspecialchars($row['Ten_Phong']); ?></td>
                <td><?php echo number_format($row['Luong']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="pagination">
        <?php for($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>