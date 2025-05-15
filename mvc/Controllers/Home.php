<?php
//Trang chủ
    class Home extends Controller {
        public static function showMainPage() {
            $show = parent :: view("MainPage", 
            ["Page" => "HomePage"]);
        }
    }
?>