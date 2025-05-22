const ACTION_DEL_PR=0;
const ACTION_DEL_POST=1;
const ACTION_DEL_DETAI=2;
var action=ACTION_DEL_PR;
var reader = new FileReader();
var pagination_product = '#pagination-product';
var pagination_detail = '#pagination-detail';
var pagination_new = '#pagination-new';
var tableProduct = "table_product";
var tableDetail = "table_detail";
var tableNew = "table_new";

var searchNameProduct ="";
var searchNamePost="";
var serachIdProduct=0;

var ProductAddModal = new bootstrap.Modal(document.getElementById('addProductModal'));
var DetailAddModal = new bootstrap.Modal(document.getElementById('addVariantModal'));
var PostAddModal = new bootstrap.Modal(document.getElementById('addPostModal'));
var modalDelete = new bootstrap.Modal(document.getElementById('deleteProductModal'));

var idFocus =null;
var idProduct=null;
var savePostButton = document.getElementById('savePostButton');
var saveProductButton = document.getElementById('saveProductButton');
var saveDetailButton = document.getElementById('saveVariantButton');

var deleteButtonProduct = document.getElementById('btnDlPrMd');



$('#addProductModal').on('hide.bs.modal', function (event) {
    console.log('Product Add Modal is about to hide!');
    idFocus=null;
});
saveDetailButton.addEventListener("click",function(){
    var name = document.getElementById('variantName').value;
    var imgLarge = document.getElementById('variantImageLarge').files[0];
    var imgSmall = document.getElementById('variantImageSmall').files[0];
    var productId=$('#variantProductId').val();
    console.log(productId);
    const formData = new FormData();
    if(idFocus!=null){
  formData.append('id', idFocus);
    }
  
    formData.append('name', name);
    formData.append('big_img', imgLarge);
    formData.append('id_product',productId );
    formData.append('small_img', imgSmall); // <-- Đính kèm đối tượng File vào FormData

  
    // Gọi một hàm khác để xử lý dữ liệu này
$.ajax({
                    url: "/ShopProject/Admin/AddDetail", // URL API của bạn
                    type: "POST", // Phương thức POST
                    data: formData, // Truyền FormData vào đây

                    // Cực kỳ quan trọng khi gửi file với FormData:
                    processData: false, // Ngăn jQuery cố gắng chuyển đổi dữ liệu thành chuỗi query params.
                    contentType: false, // Ngăn jQuery đặt header Content-Type. FormData sẽ tự đặt là multipart/form-data.

                    success: function (response, status) {
                        console.log("Status:", status);
                        console.log("Server Response:", response);
                        if (status === "success") { // Giả sử server trả về { success: true, ... }
                         
                            idFocus = null; // Reset idFocus sau khi lưu
                            $("#addVariantModal").modal("hide");
                            loadDetails(idProduct,1);
                            
                        } 
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                         $("#addVariantModal").modal("hide");
                        console.error("Lỗi AJAX:", textStatus, errorThrown, jqXHR.responseText);
                     
                    }
                });

    // Đóng modal sau khi xử lý (tùy chọn)
    DetailAddModal.hide();
})
savePostButton.addEventListener("click",function(){

    var name=$("#postTitle").val();
    var user=$("#postAuthor").val();
    var date=$("#postDate").val();
    var content=$("#postContent").val();
    var image=$("#postImage")[0].files[0];
        const formData=new FormData();
        formData.append("name",name);
        formData.append("user",user);
        formData.append("date",date);
        formData.append("content",content);
        formData.append("image",image);
        $.ajax({
               url: "/ShopProject/Admin/AddPost", // URL API của bạn
                    type: "POST", // Phương thức POST
                    data: formData, // Truyền FormData vào đây

                    // Cực kỳ quan trọng khi gửi file với FormData:
                    processData: false, // Ngăn jQuery cố gắng chuyển đổi dữ liệu thành chuỗi query params.
                    contentType: false, // Ngăn jQuery đặt header Content-Type. FormData sẽ tự đặt là multipart/form-data.

                    success: function (response, status) {
                        console.log("Status:", status);
                        console.log("Server Response:", response);
                        if (status === "success") { // Giả sử server trả về { success: true, ... }
                         
                            idFocus = null; // Reset idFocus sau khi lưu
                            $("#addPostModal").modal("hide");
                            loadPosts(idProduct,1);
                            
                        } 
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                         $("#addPostModal").modal("hide");
                        console.error("Lỗi AJAX:", textStatus, errorThrown, jqXHR.responseText);
                     
                    }
        })

})
deleteButtonProduct.addEventListener('click', function () {

    switch(action){
        case ACTION_DEL_PR:
             $.post('/ShopProject/Admin/DeleteProduct',
        {
            id: idFocus
        }, function (data, status) {
            console.log(status);
            if (status === "success") {
              idFocus=null;
              modalDelete.hide();
              loadProducts(searchNameProduct,1)
            
            }
        })
            break;
        case ACTION_DEL_POST:

        $.post('/ShopProject/Admin/DeletePost',
        {
            id: idFocus
        }, function (data, status) {
            console.log(status);
            if (status === "success") {

              idFocus=null;
              modalDelete.hide();
              loadPosts(1)
            
            }
        })
            break;
        case ACTION_DEL_DETAI:

        $.post('/ShopProject/Admin/DeleteDetail',
        {
            id: idFocus
        }, function (data, status) {
            console.log(status);
            if (status === "success") {

              idFocus=null;
              modalDelete.hide();
              loadDetails(productId,1);
            
            }
        })
            break;
        default:
        break;
    }
  

   
})
$("#searchProductButton").on('click', function() {
      

        searchNameProduct = $("#searchProductName").val();
        console.log(searchNameProduct)
       loadProducts(searchNameProduct,1)
});
$("#searchProductIdButton").on('click', function() {
      

        serachIdProduct = $("#searchProductId").val();
        loadDetails(serachIdProduct,1);
        

});
saveProductButton.addEventListener('click', function () {
    
    var name = document.getElementById('productName').value;
    var price = document.getElementById('productPrice').value;
    var content = document.getElementById('productDescription').value;
    var image = document.getElementById('productImage').files[0];
    const formData = new FormData();

    if(idFocus!=null){

        formData.append('id', idFocus);
    }
    
    formData.append('name', name);
    formData.append('price', price);
    formData.append('content', content);
    formData.append('image', image); // <-- Đính kèm đối tượng File vào FormData
    // Bây giờ bạn có thể sử dụng các biến title, category, content

$.ajax({
                    url: "/ShopProject/Admin/AddProduct", // URL API của bạn
                    type: "POST", // Phương thức POST
                    data: formData, // Truyền FormData vào đây

                    // Cực kỳ quan trọng khi gửi file với FormData:
                    processData: false, // Ngăn jQuery cố gắng chuyển đổi dữ liệu thành chuỗi query params.
                    contentType: false, // Ngăn jQuery đặt header Content-Type. FormData sẽ tự đặt là multipart/form-data.

                    success: function (response, status) {
                        console.log("Status:", status);
                        console.log("Server Response:", response);
                        console.log("ok");
                        if (status === "success") { // Giả sử server trả về { success: true, ... }
                         
                            idFocus = null; // Reset idFocus sau khi lưu
                            loadProducts(searchNameProduct,1);
                            console.log("ok");
                            $('#addProductModal').modal('hide');
                        } 
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("Lỗi AJAX:", textStatus, errorThrown, jqXHR.responseText);
                        $('#addProductModal').modal('hide');

                        
                    }
                });

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
            loadProducts(searchNameProduct,page);
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
function updatePaginationButtonsDetail(currentPage = 1, totalPages) {
    console.log(totalPages)
    var pagination = $(pagination_detail);
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
            loadDetails(page);
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
            img.src = "../"+value.img_src || 'placeholder.png'; // Sử dụng ảnh mặc định nếu không có
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
               idFocus = value.id;
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
                idFocus = value.id;
                modalDelete.show();


            }
            cellActions.appendChild(deleteButton);
            cellActions.appendChild(document.createTextNode(' ')); // Thêm một khoảng trắng

            const showDetailButton = document.createElement('button');
            showDetailButton.classList.add('btn', 'btn-sm', 'btn-danger');
            showDetailButton.innerHTML = '<i class="fas fa-trash-alt"></i> Hiện biến thể';
            showDetailButton.value = value.id;
            showDetailButton.onclick = function () {
                idFocus = value.id;
                idProduct=value.id;
                loadDetails(value.id,1);


            }
            cellActions.appendChild(showDetailButton);

                        cellActions.appendChild(document.createTextNode(' ')); // Thêm một khoảng trắng

            const addDetailButton = document.createElement('button');
            addDetailButton.classList.add('btn', 'btn-sm', 'btn-danger');
            addDetailButton.innerHTML = '<i class="fas fa-trash-alt"></i> Thêm biến thể';
            addDetailButton.value = value.id;
            addDetailButton.onclick = function () {
                $("#addVariantModal").modal('show');
                $("#variantProductId").val(value.id);
                idProduct=value.id;

            }
            cellActions.appendChild(addDetailButton);
            

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
            img.src = "../"+value.img_src || 'placeholder.png'; // Sử dụng ảnh mặc định nếu không có
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
                
                idFocus=value.id;
                $("#postTitle").val(value.name);
                $("#postTitle").val(value.user);
                $("#postTitle").val(value.date);
                $("#postTitle").val(value.content);

                $("#addPostModal").modal("show");

            };
            cellActions.appendChild(editButton);

            // Tạo khoảng cách giữa các nút (tùy chọn)
            cellActions.appendChild(document.createTextNode(' ')); // Thêm một khoảng trắng

            // Tạo nút Xóa
            const deleteButton = document.createElement('button');
            deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
            deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> Xóa';
            deleteButton.onclick = function () {
                action=ACTION_DEL_POST;
                idFocus=value.id;
                modalDelete.show();


            }
            cellActions.appendChild(deleteButton);

        }

    }


}
function updateViewTablesDetail(elementName, productsData) {
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

            const cellImageB = row.insertCell();
            const img_big = document.createElement('img');
            img_big.src = "../"+value.img_src_big || 'placeholder.png'; // Sử dụng ảnh mặc định nếu không có
            img_big.alt = value.name;
            img_big.width = 50;
            cellImageB.appendChild(img_big);

            const cellImageM = row.insertCell();
            const img_small = document.createElement('img');
            img_small.src = "../"+value.img_src_small || 'placeholder.png'; // Sử dụng ảnh mặc định nếu không có
            img_small.alt = value.img_src_small;
            img_small.width = 50;
            cellImageM.appendChild(img_small);

            const cellName = row.insertCell();
            cellName.textContent = value.name;

            const cellProductId = row.insertCell();
            cellProductId.textContent ="ID: "+value.id_product;
            const cellActions = row.insertCell();
            

            // Tạo khoảng cách giữa các nút (tùy chọn)
            cellActions.appendChild(document.createTextNode(' ')); // Thêm một khoảng trắng

            // Tạo nút Xóa
            const deleteButton = document.createElement('button');
            deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
            deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> Xóa';
            deleteButton.onclick = function () {
                productId=value.id;
                action=ACTION_DEL_DETAI;
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
function loadProducts(name='',index = 1) {

    // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
    $.post("/ShopProject/Admin/GetProducts", {
        name:name,
        index: index
    }, function (data, status) {
        if (status == "success") {
            
            updatePaginationButtonsProduct(index, data["totalPages"]);
            delete data["totalPages"];
            console.log(data);
            updateViewTablesProduct(data);

        } else {
            console.log(status);
        }
    });

}
function loadPosts(id=null,index = 1) {

    // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
    $.post("/ShopProject/Admin/GetPosts", {
        id:id,
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
function loadDetails(id=null,index = 1) {
 
    console.log(id);
    // Gọi API backend để lấy danh sách sản phẩm mới và cập nhật bảng
    $.post("/ShopProject/Admin/GetDetail", {
        id_product:id,
        index: index
    }, function (data, status) {
        if (status == "success") {
            console.log(data["totalPages"]);
            updatePaginationButtonsDetail(index, data["totalPages"]);
            delete data["totalPages"];
            updateViewTablesDetail(tableDetail, data);

        } else {
            console.log(status);
        }
    });

}
$(document).ready(function () {
    // ... (phần smooth scrolling đã có) ...
    loadProducts(searchNameProduct,1);
        loadPosts(searchNamePost,1);




});