<?php
require_once("./mvc/Models/ProductModel.php");
//Trang chủ
    class ProductList extends Controller {
        public static function showMainPage() {

            $product = new ProductModel();
            $limit = 6;
            $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $totalProducts = $product->getTotalProducts();
            $totalPages = ceil($totalProducts / $limit);
            $products = $product->getProductsByPage($limit, $currentPage);

            $show = parent :: view("MainPage", 
            ["Page" => "productlist",
            "products"=>$products]);
        }
    }
?>