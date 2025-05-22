<?php
require_once("./mvc/Models/PostModel.php");
require_once("./mvc/Models/ProductModel.php");


//Trang chủ
    class Admin extends Controller {
        public static function showMainPage() {
             
             
                    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
                     // Có thể thêm tham số để biết sau khi đăng nhập thành công thì quay về trang Admin
                    header("Location: http://localhost/ShopProject/Admin/Login");
                     exit(); // Dừng thực thi script
                     
                    
                    }else{
                        $show = parent :: view("AdminPage", 
                    ["Page" => "Admin"]);
                    }
           
        }
        
            public static function Login() {
                   
                 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                     $user = $_POST['username'] ?? '';
                     $password = $_POST['password'] ?? '';
                     if($user=="admin12@"||$password=="abcD123!@"){
                         $_SESSION['logged_in']=true;
                         $response = ['status' => 'success'];
                        echo json_encode($response);
                     }else{
                         $response = ['status' => 'error', 'message' => 'Validation errors', 'errors' =>"Sai pass hoặc tên"];
                        echo json_encode($response);
                     }

              }else{
                 $show = parent :: view("Login", 
                 ["Page" => "Admin"]);
              }
           
           
        }
        public static function GetPosts() {
                header('Content-Type: application/json');
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $index = $_POST['index'] ?? 1;
                }
                $limit = 10;
                $post= new PostModel();

                $totalPosts = $post->getTotalPosts();
                $totalPages = ceil($totalPosts / $limit);
                $post = $post->getPostsByPage($limit, $index);
                $post["totalPages"]=$totalPages;
                echo json_encode($post);
        }
        public static function AddPost() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ten = $_POST['name'] ?? '';
                $content = $_POST['content'] ?? '';
                $user = $_POST['user'] ?? '';
                $date = $_POST['date'] ?? '';
                $anh = $_FILES['image'] ?? null;
                $anh_ten = '';
                $id = $_POST['id'] ?? null; // Get the ID for updates

                // Input Validation
                $errors = [];
                if (empty($ten)) {
                    $errors['name'] = 'Name is required.';
                } elseif (strlen($ten) > 255) {
                    $errors['name'] = 'Name cannot exceed 255 characters.';
                }

                if (empty($content)) {
                    $errors['content'] = 'Content is required.';
                }

                if (empty($user)) {
                    $errors['user'] = 'User is required.';
                } elseif (strlen($user) > 255) {
                    $errors['user'] = 'User cannot exceed 255 characters.';
                }

                if (empty($date)) {
                    $errors['date'] = 'Date is required.';
                } elseif (!strtotime($date)) {
                    $errors['date'] = 'Invalid date format.';
                }


                if ($anh && $anh['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($anh['type'], $allowed_types)) {
                        $errors['image'] = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                    }

                    if ($anh['size'] > 2 * 1024 * 1024) { // 2MB limit
                        $errors['image'] = 'Image size exceeds 2MB.';
                    }
                } else if ($anh && $anh['error'] !== UPLOAD_ERR_NO_FILE) {
                    $errors['image'] = 'Image upload error: ' . $anh['error'];
                }


                if (!empty($errors)) {
                    $response = ['status' => 'error', 'message' => 'Validation errors', 'errors' => $errors];
                    echo json_encode($response);
                    return;
                }
                // File upload handling
                if ($anh && $anh['error'] === UPLOAD_ERR_OK) {
                    $anh_ten = uniqid() . '_' . $anh['name'];
                    $upload_dir = "uploads/news";
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $upload_path = $upload_dir . $anh_ten;

                    if (!move_uploaded_file($anh['tmp_name'], $upload_path)) {
                        $response = ['status' => 'error', 'message' => 'Failed to upload image.'];
                        echo json_encode($response);
                        return;
                    }
                    $anh_ten = $upload_path;
                } else if ($anh && $anh['error'] !== UPLOAD_ERR_NO_FILE) {
                    $response = ['status' => 'error', 'message' => 'Image upload error: ' . $anh['error']];
                    echo json_encode($response);
                    return;
                }
                $postManager = new PostModel(); //create instance of class
                $insertedPost = $postManager->insert($ten, $user, $date, $content, $anh_ten, $id); //use insert

                if ($insertedPost) {
                    $response = ['status' => 'success', 'message' => 'Post added/updated successfully!', 'data' => $insertedPost];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to add/update post.'];
                }

                echo json_encode($response);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
            }
        }
        public static function DeletePost() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $id = $_POST['id'] ?? null; // Get the ID for deletion

                // Input Validation for ID
                if (empty($id) || !is_numeric($id)) {
                    $response = ['status' => 'error', 'message' => 'Invalid post ID.'];
                    echo json_encode($response);
                    return;
                }

                $postManager = new PostModel(); // Create instance of your model
                $deleted = $postManager->delete($id); // Use the delete method

                if ($deleted) {
                    $response = ['status' => 'success', 'message' => 'Post deleted successfully!'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to delete post.'];
                }

                echo json_encode($response);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
            }
        }
        public static function GetProducts(){
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $index = $_POST['index'] ?? 1;
                    $id = $_POST['id'] ?? 1;
                    $name = $_POST['name'] ?? "";
                    if (empty($id) || !is_numeric($id)) {
                    $response = ['status' => 'error', 'message' => 'Invalid post ID.'];
             
                   echo json_encode($response);
                    return;
                    }
                    $limit = 5;
                    $productModel= new ProductModel();
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : $index;
                    $totalProducts = $productModel->getTotalProducts($name);
                    $totalProducts = ceil($totalProducts / $limit);
                    $product = $productModel->getProductsByPage($limit, $currentPage,$name);
                    $product["totalPages"]=$totalProducts;
                    echo json_encode($product);
                    
                }
                else{
                    echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);

                }
                
        }
        public static function GetProductsByName(){
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $index = $_POST['index'] ?? 1;

                    $name = $_POST['name'] ?? "";
                    if (empty($name)) {
                    $response = ['status' => 'error', 'message' => 'Invalid product ID.'];
                    echo json_encode($response);
                    return;
                    }
                    $limit = 5;
                    $productModel= new ProductModel();
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : $index;
                    $totalProducts = $productModel->getTotalProducts($name);
                    $totalProducts = ceil($totalProducts / $limit);
                    $product = $productModel->getProductsByPage($limit, $currentPage);
                    $product["totalPages"];
                    echo json_encode($product);
                    
                }
                else{
                    echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);

                }
                
        }
        public static function AddProduct() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ten = $_POST['name'] ?? '';
                $price = $_POST['price'] ?? '';
                $content = $_POST['content'] ?? '';

                $anh = $_FILES['image'] ?? null;
                $anh_ten = '';
                $id = $_POST['id'] ?? null; // Get the ID for updates

                // Input Validation
                $errors = [];
                if (empty($ten)) {
                    $errors['name'] = 'Name is required.';
                } elseif (strlen($ten) > 255) {
                    $errors['name'] = 'Name cannot exceed 255 characters.';
                }

                if (empty($content)) {
                    $errors['content'] = 'Content is required.';
                }

                if (empty($price)) {
                    $errors['user'] = 'price is required.';
                } elseif (strlen($price) > 255) {
                    $errors['price'] = 'price cannot exceed 255 characters.';
                }

                


                if ($anh && $anh['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($anh['type'], $allowed_types)) {
                        $errors['image'] = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                    }

                    if ($anh['size'] > 2 * 1024 * 1024) { // 2MB limit
                        $errors['image'] = 'Image size exceeds 2MB.';
                    }
                } else if ($anh && $anh['error'] !== UPLOAD_ERR_NO_FILE) {
                    $errors['image'] = 'Image upload error: ' . $anh['error'];
                }


                if (!empty($errors)) {
                    $response = ['status' => 'error', 'message' => 'Validation errors', 'errors' => $errors];
                    echo json_encode($response);
                    return;
                }
                // File upload handling
                if ($anh && $anh['error'] === UPLOAD_ERR_OK) {
                    $anh_ten = uniqid() . '_' . $anh['name'];
                    $upload_dir = "uploads/products";
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $upload_path = $upload_dir . $anh_ten;

                    if (!move_uploaded_file($anh['tmp_name'], $upload_path)) {
                        $response = ['status' => 'error', 'message' => 'Failed to upload image.'];
                        echo json_encode($response);
                        return;
                    }
                    $anh_ten = $upload_path;
                } else if ($anh && $anh['error'] !== UPLOAD_ERR_NO_FILE) {
                    $response = ['status' => 'error', 'message' => 'Image upload error: ' . $anh['error']];
                    echo json_encode($response);
                    return;
                }
            $productModle = new ProductModel(); 
                $insertedProduct = $productModle->insertProduct($ten,$price,$anh_ten,$content, $id); //use insert

                if ($insertedProduct) {
                    $response = ['status' => 'success', 'message' => 'Product added/updated successfully!', 'data' => $insertedProduct];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to add or update Product.'];
                }

                echo json_encode($response);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
            }
        }
        public static function DeleteProduct() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $id = $_POST['id'] ?? null; // Get the ID for deletion

                // Input Validation for ID
                if (empty($id) || !is_numeric($id)) {
                    $response = ['status' => 'error', 'message' => 'Invalid post ID.'];
                    echo json_encode($response);
                    return;
                }

                $productModel = new ProductModel(); // Create instance of your model
                $deleted = $productModel->deleteProduct($id); // Use the delete method
                if ($deleted) {
                    $response = ['status' => 'success', 'message' => 'Post deleted successfully!'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to delete post.'];
                }

                echo json_encode($response);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
            }
        }
        public static function GetDetail() {

            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $limit=4;
                $id = $_POST['id_product'] ?? null; // Get the ID for deletion

                // Input Validation for ID
                if (empty($id) || !is_numeric($id)) {
                    $response = ['status' => 'error', 'message' => 'Invalid product ID.'];
                    echo json_encode($response);
                    return;
                }

                $productModel = new ProductModel(); // Create instance of your model
                $total=$productModel->getTotalDetails($id);
                $data = $productModel->getDetailByProductId($id); // Use the delete method

                if ($data&&$total>0) {
                    $response = ['status' => 'success', 'message' => ' successfully!'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed!'];
                }
                $totalPages=ceil($total/$limit);
                $data["totalPages"]=$totalPages;
                 echo json_encode($data);
                
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
            }
        }
        public static function DeleteDetail() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $id = $_POST['id'] ?? null; // Get the ID for deletion

                // Input Validation for ID
                if (empty($id) || !is_numeric($id)) {
                    $response = ['status' => 'error', 'message' => 'Invalid post ID.'];
                    echo json_encode($response);
                    return;
                }

                $productModel = new ProductModel(); // Create instance of your model
                $deleted = $productModel->DeleteDetail($id); // Use the delete method

                if ($deleted) {
                    $response = ['status' => 'success', 'message' => 'Detail deleted successfully!'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to delete Detail.'];
                }

                echo json_encode($response);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
            }
        }
        public static function AddDetail() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ten = $_POST['name'] ?? '';
                $big_img = $_FILES['big_img'] ?? '';
                $small_img = $_FILES['small_img'] ?? '';

                $id_product = $_POST['id_product'] ?? null;
               
                $id = $_POST['id'] ?? null; // Get the ID for updates

                // Input Validation
                $errors = [];
                if (empty($ten)) {
                    $errors['name'] = 'Name is required.';
                } elseif (strlen($ten) > 255) {
                    $errors['name'] = 'Name cannot exceed 255 characters.';
                }

                if (empty($id_product)) {
                    $errors['id_product'] = 'Id_Product is required.';
                }

      


                if ($big_img && $big_img['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($big_img['type'], $allowed_types)) {
                        $errors['image'] = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                    }

                    if ($big_img['size'] > 2 * 1024 * 1024) { // 2MB limit
                        $errors['image'] = 'Image size exceeds 2MB.';
                    }
                } else if ($big_img && $big_img['error'] !== UPLOAD_ERR_NO_FILE) {
                    $errors['image'] = 'Image upload error: ' . $big_img['error'];
                }
                if ($small_img && $small_img['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($small_img['type'], $allowed_types)) {
                        $errors['image'] = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                    }

                    if ($small_img['size'] > 2 * 1024 * 1024) { // 2MB limit
                        $errors['image'] = 'Image size exceeds 2MB.';
                    }
                } else if ($small_img && $small_img['error'] !== UPLOAD_ERR_NO_FILE) {
                    $errors['image'] = 'Image upload error: ' . $small_img['error'];
                }


                if (!empty($errors)) {
                    $response = ['status' => 'error', 'message' => 'Validation errors', 'errors' => $errors];
                    echo json_encode($response);
                    return;
                }

                // File upload handling

                if ($small_img && $small_img['error'] === UPLOAD_ERR_OK && $big_img && $big_img["error"]===UPLOAD_ERR_OK) {
                        $big_anh_ten = uniqid() . '_big_' . $big_img['name'];
                        $small_anh_ten = uniqid() . '_small_' . $small_img['name'];
                        $upload_dir = "uploads/products/color";

                        if (!is_dir($upload_dir)) {
                            mkdir($upload_dir, 0755, true);
                        }
                        $upload_path_1 = $upload_dir . $big_anh_ten;
                        $upload_path_2 = $upload_dir . $small_anh_ten;


                        if (!move_uploaded_file($big_img['tmp_name'], $upload_path_1)) {
                            $response = ['status' => 'error', 'message' => 'Failed to upload image.'];
                            echo json_encode($response);
                            return;
                        }
 
                        if (!move_uploaded_file($small_img['tmp_name'], $upload_path_2)) {
                            $response = ['status' => 'error', 'message' => 'Failed to upload image.'];
                            echo json_encode($response);
                            return;
                        }

                        $anh_ten_big = $upload_path_1;
                        $anh_ten_small = $upload_path_2;
                        $productModle = new ProductModel(); 
                        $insertedProduct = $productModle->UpdateDeatailOrInsertId($ten,$anh_ten_big,$anh_ten_small,(int)$id_product,$id); //use insert

                        if ($insertedProduct) {
                            $response = ['status' => 'success', 'message' => 'Detail added/updated successfully!', 'data' => $insertedProduct];
                        } else {
                            $response = ['status' => 'error', 'message' => 'Failed to add/update Detail.'];
                        }

                        echo json_encode($response);
                    } 
                else if ($big_img && $big_img['error'] !== UPLOAD_ERR_NO_FILE && $small_img && $small_img['error'] !== UPLOAD_ERR_NO_FILE) {
                    $response = ['status' => 'error', 'message' => 'Image upload error: '];
                    echo json_encode($response);
                    return;
                    
                }
               
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
            }
        }
      public static function UpdateDetail() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ten = $_POST['name'] ?? '';
                $big_img = $_FILES['big_img'] ?? '';
                $small_img = $_FILES['small_img'] ?? '';

                $id_product = $_POST['id_product'] ?? null;
               
                $id = $_POST['id'] ?? null; // Get the ID for updates

                // Input Validation
                $errors = [];
                if (empty($ten)) {
                    $errors['name'] = 'Name is required.';
                } elseif (strlen($ten) > 255) {
                    $errors['name'] = 'Name cannot exceed 255 characters.';
                }

                if (empty($id_product)) {
                    $errors['id_product'] = 'Id_Product is required.';
                }

      


                if ($big_img && $big_img['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($big_img['type'], $allowed_types)) {
                        $errors['image'] = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                    }

                    if ($big_img['size'] > 2 * 1024 * 1024) { // 2MB limit
                        $errors['image'] = 'Image size exceeds 2MB.';
                    }
                } else if ($big_img && $big_img['error'] !== UPLOAD_ERR_NO_FILE) {
                    $errors['image'] = 'Image upload error: ' . $big_img['error'];
                }
                if ($small_img && $small_img['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($small_img['type'], $allowed_types)) {
                        $errors['image'] = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                    }

                    if ($small_img['size'] > 2 * 1024 * 1024) { // 2MB limit
                        $errors['image'] = 'Image size exceeds 2MB.';
                    }
                } else if ($small_img && $small_img['error'] !== UPLOAD_ERR_NO_FILE) {
                    $errors['image'] = 'Image upload error: ' . $small_img['error'];
                }


                if (!empty($errors)) {
                    $response = ['status' => 'error', 'message' => 'Validation errors', 'errors' => $errors];
                    echo json_encode($response);
                    return;
                }

                // File upload handling

                if ($small_img && $small_img['error'] === UPLOAD_ERR_OK && $big_img && $big_img["error"]===UPLOAD_ERR_OK) {
                        $big_anh_ten = uniqid() . '_big_' . $big_img['name'];
                        $small_anh_ten = uniqid() . '_small_' . $small_img['name'];
                        $upload_dir = "uploads/products/color";

                        if (!is_dir($upload_dir)) {
                            mkdir($upload_dir, 0755, true);
                        }
                        $upload_path_1 = $upload_dir . $big_anh_ten;
                        $upload_path_2 = $upload_dir . $small_anh_ten;


                        if (!move_uploaded_file($big_img['tmp_name'], $upload_path_1)) {
                            $response = ['status' => 'error', 'message' => 'Failed to upload image.'];
                            echo json_encode($response);
                            return;
                        }
 
                        if (!move_uploaded_file($small_img['tmp_name'], $upload_path_2)) {
                            $response = ['status' => 'error', 'message' => 'Failed to upload image.'];
                            echo json_encode($response);
                            return;
                        }

                        $anh_ten_big = $upload_path_1;
                        $anh_ten_small = $upload_path_2;
                        $productModle = new ProductModel(); 
                        $insertedProduct = $productModle->UpdateDeatailOrInsertId($ten,$anh_ten_big,$anh_ten_small,(int)$id_product,$id); //use insert

                        if ($insertedProduct) {
                            $response = ['status' => 'success', 'message' => 'Detail added/updated successfully!', 'data' => $insertedProduct];
                        } else {
                            $response = ['status' => 'error', 'message' => 'Failed to add/update Detail.'];
                        }

                        echo json_encode($response);
                    } 
                else if ($big_img && $big_img['error'] !== UPLOAD_ERR_NO_FILE && $small_img && $small_img['error'] !== UPLOAD_ERR_NO_FILE) {
                    $response = ['status' => 'error', 'message' => 'Image upload error: '];
                    echo json_encode($response);
                    return;
                    
                }
               
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
            }
        }       

        
}

?>
