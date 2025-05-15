<?php
//Trang chủ
    class About extends Controller {
        public static function showMainPage() {
            $show = parent :: view("MainPage", 
            ["Page" => "about"]);
        }
    }
?>