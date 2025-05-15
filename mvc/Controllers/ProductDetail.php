<?php
require_once("./mvc/Models/ProductModel.php");
//Trang chủ
    class ProductDetail extends Controller {
       
        public static function showMainPage() {
            if($_GET[2]){
                $id=$_GET[2];
          
                $productModel=new ProductModel();
                $productDetail = $productModel->getProductDetailByID((int)$id);
                if ($productDetail) {


                    $show = parent :: view("MainPage", 
                    ["Page" => "Product",
                    "Product"=>$productDetail
                ]);
                
                
                
                } 
            }else{
                $show = parent :: view("MainPage", 
                ["Page" => "Product"
            ]);

            }
           





        }
    }
?>