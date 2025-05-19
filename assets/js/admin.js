var pagination_product = '#pagination-product';
var pagination_detail = '#pagination-detail';
var pagination_new = '#pagination-new';
var tableProduct = "table_product";
var tableDetail = "table_detail";
var tableNew = "table_new";
var ProductAddModal = new bootstrap.Modal(document.getElementById('addProductModal'));
var PostAddModal = new bootstrap.Modal(document.getElementById('addPostModal'));

var idDelete = document.getElementById('id-delete');
var savePostButton = document.getElementById('savePostButton');
var saveProductButton = document.getElementById('saveProductButton');
var deleteButtonProduct = document.getElementById('btnDlPrMd');
console.log(deleteButtonProduct);

// modal input element flast
var inputProductName = document.getElementById('btnDlPrMd');
var inputProductName = document.getElementById('btnDlPrMd');
var inputProductName = document.getElementById('btnDlPrMd');
var inputProductName = document.getElementById('btnDlPrMd');



deleteButtonProduct.addEventListener('click', function () {

    $.post('/ShopProject/Admin/DeleteProduct',
        {
            id: idDelete.value
        }, function (data, status) {
            console.log(status);
            if (status === "success") {
              loadProducts();
              modalDelete.hide();
               
            }
        })
})



var modalDelete = new bootstrap.Modal(document.getElementById('deleteProductModal'));

saveProductButton.addEventListener('click', function () {

    var name = document.getElementById('productName').value;
    var price = document.getElementById('productPrice').value;
    var content = document.getElementById('productDescription').value;
    var image = document.getElementById('productImage').value;

    // Bây giờ bạn có thể sử dụng các biến title, category, content
    // để thực hiện các hành động khác trong script của bạn, ví dụ:
    console.log("Tiêu đề:", name);
    console.log("Danh mục:", price);
    console.log("Nội dung:", content);
    console.log("Nội dung:", image);

    // Gọi một hàm khác để xử lý dữ liệu này
    $.post("/ShopProject/Admin/AddProduct",
        {
            name: name,
            price: price,
            content: content,
            image: image
        }, function (data, status) {
            console.log(status)
            if (status === "success") {

                loadProducts(1);
            }
        }
    )

    // Đóng modal sau khi xử lý (tùy chọn)
    ProductAddModal.hide();
})

function updatePaginationButtonsProduct(currentPage = 1, totalPages) {
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
    pagination.find('.page-link').on('click', function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        console.log(page);
        if (page) {
            loadProducts(page);
        }
    });
}


function updatePaginationButtonsNew(currentPage = 1, totalPages) {
    console.log(totalPages)
    var pagination = $(pagination_new);
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
    pagination.find('.page-link').on('click', function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        if (page) {
            loadPosts(page);
        }
    });
}



function updateViewTablesProduct(productsData) {
    var tableBody = document.getElementById(tableProduct)

    console.log(productsData)
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
            editButton.innerHTML = '<i class="fas fa-edit " ></i> Sửa';
            editButton.onclick = function () {
                // Thêm logic xử lý khi nhấn nút Sửa
              ProductAddModal.show();
            };
            cellActions.appendChild(editButton);

            // Tạo khoảng cách giữa các nút (tùy chọn)
            cellActions.appendChild(document.createTextNode(' ')); // Thêm một khoảng trắng

            // Tạo nút Xóa
            const deleteButton = document.createElement('button');
            deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
            deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> Xóa';
            deleteButton.value = value.id;
            deleteButton.onclick = function () {
                idDelete.value = value.id;
                modalDelete.show();


            }
            cellActions.appendChild(deleteButton);

        }

    }


}

function updateViewTablesPost(elementName, productsData) {
    var tableBody = document.getElementById(elementName)


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
            ;
            // Tạo các ô <td> cho mỗi thuộc tính của sản phẩm
            const cellId = row.insertCell();
            cellId.textContent = value.id;

            const cellName = row.insertCell();
            cellName.textContent = value.name;

            const cellUser = row.insertCell();
            cellUser.textContent = value.user_post;

            const cellDate = row.insertCell();
            cellDate.textContent = value.date;


            const cellImage = row.insertCell();
            const img = document.createElement('img');
            img.src = value.img_src || 'placeholder.png'; // Sử dụng ảnh mặc định nếu không có
            img.alt = value.name;
            img.width = 50;
            cellImage.appendChild(img);



            const cellType = row.insertCell();
            cellType.textContent = value.type;

            const cellActions = row.insertCell();
            // Tạo nút Sửa
            const editButton = document.createElement('button');
            editButton.classList.add('btn', 'btn-sm', 'btn-info');
            editButton.innerHTML = '<i class="fas fa-edit"></i> Sửa';
            editButton.onclick = function () {
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
            deleteButton.onclick = function () {
                modalDelete.show();


            }
            cellActions.appendChild(deleteButton);

        }

    }


}
function deleteProduct() {
    $.post("/ShopProject/Admin/DeleteProduct",
        {
            id: value.id
        },
        function (data, status) {
            if (status === "success") {

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
function loadProducts(index = 1) {

    // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
    $.post("/ShopProject/Admin/GetProducts", {
        index: index
    }, function (data, status) {
        if (status == "success") {

            updatePaginationButtonsProduct(index, data["totalPages"]);
            delete data["totalPages"];
            console.log(data);
            console.log("ok");
            updateViewTablesProduct(data);

        } else {
            console.log(status);
        }
    });

}



function loadPosts(index = 1) {

    // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
    $.post("/ShopProject/Admin/GetPosts", {
        index: index
    }, function (data, status) {
        if (status == "success") {
            console.log(data["totalPages"]);
            updatePaginationButtonsNew(index, data["totalPages"]);
            delete data["totalPages"];
            updateViewTablesPost(tableNew, data);

        } else {
            console.log(status);
        }
    });

}


$(document).ready(function () {
    // ... (phần smooth scrolling đã có) ...
    loadProducts(1);
    loadPosts(1);





});