<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            padding-top: 56px; /* Để tránh navbar cố định che nội dung */
        }
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 20px 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .sidebar .nav-link {
            margin-bottom: 5px;
            color: #333;
        }
        .sidebar .nav-link.active {
            color: #007bff;
            font-weight: bold;
        }
        main {
            padding: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

      <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#dashboard">
                                <i class="fas fa-tachometer-alt"></i> Dashboard <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#products">
                                <i class="fas fa-box-open"></i> Quản lý Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#variants">
                                <i class="fas fa-swatchbook"></i> Quản lý Biến thể
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#posts">
                                <i class="fas fa-newspaper"></i> Quản lý Bài Post
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div id="dashboard">
                    <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                    <p>Chào mừng đến trang quản trị!</p>
                    </div>

                <div id="products" >
                    <h2><i class="fas fa-box-open"></i> Quản lý Sản phẩm</h2>
                    <div class="mb-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal"><i class="fas fa-plus"></i> Thêm Sản phẩm</button>
                        <div class="input-group mt-2">
                            <input type="text" class="form-control" id="searchProductName" placeholder="Tìm kiếm theo tên sản phẩm">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="searchProductButton"><i class="fas fa-search"></i> Tìm</button>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped" id="">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th>Loại</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="table_product">
                            <tr>
                                <td>1</td>
                                <td><img src="placeholder.png" alt="Sản phẩm 1" width="50"></td>
                                <td>Sản phẩm mẫu 1</td>
                                <td>100.000 VNĐ</td>
                                <td>Điện thoại</td>
                                <td>
                                    <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Sửa</button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><img src="placeholder.png" alt="Sản phẩm 2" width="50"></td>
                                <td>Sản phẩm khác</td>
                                <td>200.000 VNĐ</td>
                                <td>Máy tính</td>
                                <td>
                                    <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Sửa</button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Xóa</button>
                                </td>
                            </tr>
                            </tbody>
                    </table>

                    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addProductModalLabel">Thêm Sản phẩm Mới</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="productName">Tên sản phẩm:</label>
                                            <input type="text" class="form-control" id="productName">
                                        </div>
                                        <div class="form-group">
                                            <label for="productPrice">Giá:</label>
                                            <input type="number" class="form-control" id="productPrice">
                                        </div>
                                        <div class="form-group">
                                            <label for="productDescription">Mô tả:</label>
                                            <textarea class="form-control" id="productDescription"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="productType">Loại:</label>
                                            <select class="form-control" id="productType">
                                                <option value="dien-thoai">Điện thoại</option>
                                                <option value="may-tinh">Máy tính</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="productImage">Ảnh sản phẩm:</label>
                                            <input type="file" class="form-control-file" id="productImage">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary" id="saveProductButton">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProductModalLabel">Sửa Sản phẩm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary">Lưu Thay Đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteProductModalLabel">Xác nhận xóa sản phẩm</h5>
                                    <div id="id-delete"></div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn xóa sản phẩm này?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                    <button type="button " class="btn btn-danger" id="btnDlPrMd" >Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination-product">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trước</a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Sau</a>
            </li>
        </ul>
    </nav>
</div>
                </div>

                <div id="variants" >
                    <h2><i class="fas fa-swatchbook"></i> Quản lý Biến thể Sản phẩm</h2>
                    
                    <table class="table table-bordered table-striped" id="">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh lớn</th>
                                <th>Ảnh nhỏ</th>
                                <th>Tên</th>
                                <th>Thuộc sản phẩm</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="table_detail">
                            <tr>
                              
                            </tr>
                            </tbody>
                    </table>

                    <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addVariantModalLabel">Thêm Biến thể Mới</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="variantName">Tên biến thể:</label>
                                            <input type="text" class="form-control" id="variantName">
                                        </div>
                                        <div class="form-group">
                                            <label for="variantProductId">ID Sản Phẩm:</label>
                                            <input type="text" class="form-control" id="variantProductId">
                                        </div>
                                        <div class="form-group">
                                            <label for="variantImageLarge">Ảnh biến thể lớn:</label>
                                            <input type="file" class="form-control-file" id="variantImageLarge">
                                        </div>
                                        <div class="form-group">
                                            <label for="variantImageSmall">Ảnh biến thể nhỏ:</label>
                                            <input type="file" class="form-control-file" id="variantImageSmall">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button"  id="saveVariantButton" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
<div class="mt-3">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination-detail">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trước</a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Sau</a>
            </li>
        </ul>
    </nav>
</div>
                    </div>

                <div id="posts" >
                    <h2><i class="fas fa-newspaper"></i> Quản lý Bài Post</h2>
                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPostModal"><i class="fas fa-plus"></i> Thêm Bài Post</button>
                    <div class="input-group mt-2">
                            <input type="text" class="form-control" id="searchProductName" placeholder="Tìm kiếm theo tên bài đăng"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="searchProductButton"><i class="fas fa-search"></i> Tìm</button>
                            </div>
                        </div>
                    <table class="table table-bordered table-striped" id="">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Người đăng</th>
                                <th>Ngày đăng</th>
                                <th>Ảnh</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="table_new">
                            <tr>
                                <td>1</td>
                                <td>Bài viết mẫu 1</td>
                                <td>Admin</td>
                                <td>2023-10-26</td>
                                <td><img src="placeholder-post.png" alt="Bài viết 1" width="80"></td>
                              
                                <td>
                                    <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Sửa</button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Xóa</button>
                                </td>
                            </tr>
                            </tbody>
                    </table>

                    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPostModalLabel">Thêm Bài Post Mới</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="postTitle">Tên bài post:</label>
                                            <input type="text" class="form-control" id="postTitle">
                                        </div>
                                        <div class="form-group">
                                            <label for="postAuthor">Người đăng:</label>
                                            <input type="text" class="form-control" id="postAuthor">
                                        </div>
                                        <div class="form-group">
                                            <label for="postDate">Ngày đăng:</label>
                                            <input type="date" class="form-control" id="postDate">
                                        </div>
                                        <div class="form-group">
                                            <label for="postContent">Nội dung:</label>
                                            <textarea class="form-control" id="postContent" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="postImage">Ảnh bài post:</label>
                                            <input type="file" class="form-control-file" id="postImage">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" id="savePostButton" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination-new">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trước</a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Sau</a>
            </li>
        </ul>
    </nav>
</div>
                    </div>
            </main>
        </div>
    </div>
    <!-- jquery -->
	<script src="/ShopProject/assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="/ShopProject/assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="/ShopProject/assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="/ShopProject/assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="/ShopProject/assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="/ShopProject/assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="/ShopProject/assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="/ShopProject/assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="/ShopProject/assets/js/sticker.js"></script>
	<script src="/ShopProject/assets/js/admin.js"></script>
</body>
</html>
