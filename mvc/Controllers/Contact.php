<?php

//Trang chủ
    class Contact extends Controller {
        public static function showMainPage() {
            $show = parent :: view("MainPage", 
            ["Page" => "Contact"]);
        }
    }
?>