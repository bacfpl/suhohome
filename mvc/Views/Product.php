<div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>list our product</p>
                        <h1>Product</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $productData = $data["Product"];
                        $product = $productData["product"];
                        $variants = $productData["variants"];
                        ?>
                        <img id="main-product-image" src="/ShopProject/<?php echo $product["img_src"] ?>" alt="<?php echo $product["name"] ?>" class="product-image img-fluid">
                    </div>
                    <div class="col-md-6">
                        <h1><?php echo $product["name"]; ?></h1>
                        <p class="lead">Giá: <span class="font-weight-bold"><?php echo $product["price"]; ?> VND</span></p>
                        <p>Loại: <span class="badge badge-secondary">Điện tử</span></p>
                        <hr>
                        <h5>Mô tả sản phẩm:</h5>
                        <p>Đây là mô tả chi tiết về sản phẩm. Nó có thể bao gồm các tính năng nổi bật, thông số kỹ thuật, và lợi ích mà sản phẩm mang lại cho người dùng. Hãy cung cấp thông tin đầy đủ và hấp dẫn để thu hút khách hàng.</p>

                        <div class="form-group mb-4">
                            <label for="color">Màu sắc:</label><br>
                            <div id="color-options">
                                <?php foreach ($variants as $variant): ?>
                                    <div class="color-option" data-variant-image="/ShopProject/<?php echo $variant["img_src_big"] ?>" title="<?php echo $variant["name"] ?>">
                                        <span class="color-swatch">
                                            <img src="/ShopProject/<?php echo $variant["img_src_small"] ?>" alt="<?php echo $variant["name"] ?>">
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg mt-4">Contact</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="logo-carousel-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-carousel-inner">
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/1.png" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/2.png" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/3.png" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/4.png" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/5.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorOptions = document.querySelectorAll('#color-options .color-option');
            const mainProductImage = document.getElementById('main-product-image');

            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const variantImage = this.getAttribute('data-variant-image');
                    if (variantImage) {
                        mainProductImage.style.opacity = 0; // Bắt đầu hiệu ứng mờ đi
                        setTimeout(() => {
                            mainProductImage.src = variantImage;
                            mainProductImage.style.opacity = 1; // Hiển thị ảnh mới
                        }, 300); // Thời gian chờ cho hiệu ứng mờ (match với transition trong CSS)
                    }
                });
            });
        });
    </script>