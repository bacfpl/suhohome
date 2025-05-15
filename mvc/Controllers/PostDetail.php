
<?php
require_once("./mvc/Models/PostModel.php");

//Trang chủ
    class PostDetail extends Controller {
        public static function showMainPage() {
            
            if($_GET[2]){
                $id=$_GET[2];
          
                $postModel=new PostModel();
                $post = $postModel->getPostByID((int)$id);
                $posts=$postModel->getNewPosts(5);
                if ($post) {


                    $show = parent :: view("MainPage", 
                    ["Page" => "NewPage",
                    "Post"=>$post,
                    "Posts"=>$posts]);

                }else{
                $show = parent :: view("MainPage", 
                ["Page" => "NewPage"]);
                    }   
            }
        }
    }

?>