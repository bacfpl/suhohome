<?php
require_once("./mvc/Models/PostModel.php");
require_once("./mvc/Models/ProductModel.php");


//Trang chủ
    class Admin extends Controller {
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
        public static function getPosts() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $index = $_POST['index'] ?? 1;
            }
            $limit = 10;
            $post= new PostModel();
             $currentPage = isset($_GET['page']) ? intval($_GET['page']) : $index;
            $totalPosts = $post->getTotalPosts();
            $totalPosts = ceil($totalPosts / $limit);
            $post = $post->getPostsByPage($limit, $currentPage);
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
            $insertedProduct = $productModle->insert($ten,$price,$anh_ten,$content, $id); //use insert

            if ($insertedProduct) {
                $response = ['status' => 'success', 'message' => 'Product added/updated successfully!', 'data' => $insertedProduct];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to add/update Product.'];
            }

            echo json_encode($response);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
        }
    }
public static function GetDetails() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null; // Get the ID for deletion

            // Input Validation for ID
            if (empty($id) || !is_numeric($id)) {
                $response = ['status' => 'error', 'message' => 'Invalid post ID.'];
                echo json_encode($response);
                return;
            }

            $productModle = new ProductModel(); // Create instance of your model
            $data = $productModle->getDetailByProductId($id); // Use the delete method

            if ($data) {
                $response = ['status' => 'success', 'message' => ' successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed!'];
            }

            echo json_encode($data);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
        }
    }
        
    }
?>
