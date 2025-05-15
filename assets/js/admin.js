$(document).ready(function() {
    // ... (phần smooth scrolling đã có) ...

    // Xử lý form thêm sản phẩm
    $('#modalThemSanPham .btn-primary').click(function() {
        const tenSanPham = $('#tenSanPham').val();
        const loaiSanPham = $('#loaiSanPham').val();
        const giaSanPham = $('#giaSanPham').val();
        const moTaSanPham = $('#moTaSanPham').val();
        const anhSanPham = $('#anhSanPham')[0].files[0]; // Lấy file ảnh

        const formData = new FormData();
        formData.append('ten', tenSanPham);
        formData.append('loai', loaiSanPham);
        formData.append('gia', giaSanPham);
        formData.append('mo_ta', moTaSanPham);
        formData.append('anh', anhSanPham);

        fetch('/api/them-san-pham.php', { // Đường dẫn đến backend script
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Thêm sản phẩm thành công!');
                $('#modalThemSanPham').modal('hide');
                // Tải lại danh sách sản phẩm hoặc thêm sản phẩm mới vào bảng
                loadProducts(); // Giả sử có hàm này để tải lại dữ liệu
            } else {
                alert('Lỗi thêm sản phẩm: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi gửi dữ liệu:', error);
            alert('Đã xảy ra lỗi khi gửi dữ liệu.');
        });
    });

    // Hàm giả định để tải lại danh sách sản phẩm (cần triển khai)
    function loadProducts() {
        console.log('Đang tải lại danh sách sản phẩm...');
        // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
    }

    // Tương tự xử lý cho các form khác (sửa sản phẩm, thêm/sửa biến thể, thêm/sửa bài đăng)
    // với các endpoint backend và dữ liệu form tương ứng.

    
});