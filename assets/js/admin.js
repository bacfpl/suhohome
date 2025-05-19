var pagination_product = '#pagination-product';
var pagination_detail = '#pagination-detail';
var pagination_new = '#pagination-new';
var tableProduct ="table_product";
var tableDetail = "table_detail";
var tableNew = "table_new";
var modalDelete=new bootstrap.Modal(document.getElementById('deleteProductModal'));
var 
varvar

    function updatePaginationButtons(currentPage=1, totalPages,elementName) {
        var pagination = $(pagination_product);
        pagination.empty(); // Xóa các nút phân trang cũ

        // Thêm nút "Trước"
        var prevButton = $('<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '"><a class="page-link" href="#" data-page="' + (currentPage - 1) + '" aria-disabled="' + (currentPage === 1 ? 'true' : 'false') + '">Trước</a></li>');
        pagination.append(prevButton);

        // Thêm các nút số trang (ví dụ: hiển thị tối đa 5 trang xung quanh trang hiện tại)
        var startPage = Math.max(1, currentPage - 2);
        var endPage = Math.min(totalPages, currentPage + 2);

        for (var i = startPage; i <= endPage; i++) {
            var activeClass = (i === currentPage) ? 'active' : '';
            var pageButton = $('<li class="page-item ' + activeClass + '" aria-current="' + (activeClass ? 'page' : 'false') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + (activeClass ? ' <span class="sr-only">(current)</span>' : '') + '</a></li>');
            pagination.append(pageButton);
        }

        // Thêm nút "Sau"
        var nextButton = $('<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '"><a class="page-link" href="#" data-page="' + (currentPage + 1) + '" aria-disabled="' + (currentPage === totalPages ? 'true' : 'false') + '">Sau</a></li>');
        pagination.append(nextButton);

        // Gắn lại sự kiện click cho các nút trang mới được tạo
        pagination.find('.page-link').on('click', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page) {
                loadPage(page, sectionId);
            }
        });
    }

    function updateViewTables(elementName, productsData) {
    var tableBody=document.getElementById(elementName)
      

    // Xóa các hàng cũ trong tbody (nếu có)
    tableBody.innerHTML = ''; // Cách đơn giản nhất

    // Kiểm tra xem có dữ liệu để hiển thị không
    if (!productsData || productsData.length === 0) {
        const row = tableBody.insertRow();
        const cell = row.insertCell();
        cell.colSpan = 6; // Số cột trong bảng của bạn
        cell.textContent = 'Không có sản phẩm nào để hiển thị.';
        cell.style.textAlign = 'center';
        return;
    }

    // Lặp qua dữ liệu sản phẩm và tạo hàng mới cho mỗi sản phẩm
    for (const key in productsData) {
        if (productsData.hasOwnProperty(key)) { // Kiểm tra xem thuộc tính có phải là của riêng đối tượng không
        const row = tableBody.insertRow(); // Tạo một hàng mới <tr>
        const value = productsData[key];
        console.log(value);
        // Tạo các ô <td> cho mỗi thuộc tính của sản phẩm
        const cellId = row.insertCell();
        cellId.textContent = value.id;

        const cellImage = row.insertCell();
        const img = document.createElement('img');
        img.src = value.img_src || 'placeholder.png'; // Sử dụng ảnh mặc định nếu không có
        img.alt = value.name;
        img.width = 50;
        cellImage.appendChild(img);

        const cellName = row.insertCell();
        cellName.textContent = value.name;

        const cellPrice = row.insertCell();
        cellPrice.textContent = formatCurrency(value.price); // Hàm định dạng tiền tệ (xem ví dụ bên dưới)

        const cellType = row.insertCell();
        cellType.textContent = value.type;

        const cellActions = row.insertCell();
        // Tạo nút Sửa
        const editButton = document.createElement('button');
        editButton.classList.add('btn', 'btn-sm', 'btn-info');
        editButton.innerHTML = '<i class="fas fa-edit"></i> Sửa';
        editButton.onclick = function() {
            // Thêm logic xử lý khi nhấn nút Sửa
            console.log('Sửa sản phẩm ID:', product.id);
            // Ví dụ: openEditModal(product.id);
        };
        cellActions.appendChild(editButton);

        // Tạo khoảng cách giữa các nút (tùy chọn)
        cellActions.appendChild(document.createTextNode(' ')); // Thêm một khoảng trắng

        // Tạo nút Xóa
        const deleteButton = document.createElement('button');
        deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
        deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> Xóa';
        deleteButton.onclick = function(){
        modalDelete.show();
             
            
        }
        cellActions.appendChild(deleteButton);
   
    }

    }


}
function deleteProduct() {
            $.post("/ShopProject/Admin/DeleteProduct",
                {
                    id:value.id
                },
                function(data,status){
                    if(status==="success"){
                        console.log(data);
                    }
                }
            )
           
           
            // Ví dụ: confirmDelete(product.id);
        };
// Hàm tiện ích để định dạng tiền tệ (ví dụ)
function formatCurrency(number) {
    if (typeof number !== 'number') {
        return number; // Trả về nguyên bản nếu không phải là số
    }
    return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}
    function loadProducts(index=1) {
  
        // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
        $.post("/ShopProject/Admin/GetProducts",{
            index:index
        },function(data, status){
                if (status=="success"){
                    console.log(data);
                    updatePaginationButtons(index,data["totalPages"],pagination_product);
                    delete data["totalPages"];

                    updateViewTables(tableProduct,data);
                    
                }else{
                    console.log(status);
                }
        });   

    }


    function loadPosts(index=1) {
  
        // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
        $.post("/ShopProject/Admin/GetPosts",{
            index:index
        },function(data, status){
                if (status=="success"){
                    console.log(data);
                    updatePaginationButtons(index,data["totalPages"],pagination_new);
                    delete data["totalPages"];

                    updateViewTables(pagination_new,data);
                    
                }else{
                    console.log(status);
                }
        });   

    }


$(document).ready(function() {
    // ... (phần smooth scrolling đã có) ...
  loadProducts(1);
  loadPosts(1);



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

    // xu ly load trang 
   
    function getSlProducts(){
        $.post("/suhohome/Admin/GetPosts")
    }

      // Hàm để cập nhật trạng thái của các nút phân trang



    function loadDetail() {
        console.log('Đang tải lại danh sách sản phẩm...');
        // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
    }
    function loadNews() {
        console.log('Đang tải lại danh sách sản phẩm...');
        // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
    }

    // Tương tự xử lý cho các form khác (sửa sản phẩm, thêm/sửa biến thể, thêm/sửa bài đăng)
    // với các endpoint backend và dữ liệu form tương ứng.

    
});