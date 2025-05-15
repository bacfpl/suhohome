<?php
require_once("./mvc/Models/PostModel.php");

//Trang chủ
    class PostList extends Controller {
        public static function showMainPage() {
            $limit = 6;
            $post= new PostModel();
             $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $totalPosts = $post->getTotalPosts();
            $totalPosts = ceil($totalPosts / $limit);
            $post = $post->getPostsByPage($limit, $currentPage);
            $show = parent :: view("MainPage", 
            ["Page" => "NewListPage",
            "Post"=>$post]);
        }
    }
?>
