<?php
require_once("./mvc/core/Database.php");
    class PostModel extends Database{
        private $tableName = 'new'; // Tên bảng sản phẩm
        private $tableNameBt = 'bt_product'; // Tên bảng sản phẩm
        public function getTotalPosts(): int {
            try {
                $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM {$this->tableName}");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['total'];
            } catch (PDOException $e) {
                // Ghi log lỗi hoặc xử lý theo cách phù hợp với ứng dụng của bạn
                error_log("Lỗi khi lấy tổng số sản phẩm: " . $e->getMessage());
                return 0; // Trả về 0 trong trường hợp lỗi
            }
        }  
        public function getPostsByPage(int $limit, int $page): array {
            $offset = ($page - 1) * $limit;
            try {
                $stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} LIMIT :limit OFFSET :offset");
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Ghi log lỗi hoặc xử lý theo cách phù hợp với ứng dụng của bạn
                error_log("Lỗi khi lấy sản phẩm theo trang: " . $e->getMessage());
                return []; // Trả về mảng rỗng trong trường hợp lỗi
            }
        }
        
        public function getNewPosts(int $limit, int $currentPage): array {
            try {
                // Tính toán offset dựa trên trang hiện tại và số lượng bài viết trên mỗi trang
                $offset = ($currentPage - 1) * $limit;

                $stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} ORDER BY date DESC LIMIT :limit OFFSET :offset");
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Ghi log lỗi hoặc xử lý theo cách phù hợp với ứng dụng của bạn
                error_log("Lỗi khi lấy bài viết mới nhất (trang {$currentPage}, giới hạn {$limit}): " . $e->getMessage());
                return []; // Trả về mảng rỗng trong trường hợp lỗi
            }
        }
        public function getPostByID(int $id): array {
                try{
                // Truy vấn lấy thông tin sản phẩm theo ID
                $stmtPost = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE id = :id");
                $stmtPost->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtPost->execute();
                $Post = $stmtPost->fetch(PDO::FETCH_ASSOC);
        
                
            // Trả về một mảng chứa thông tin sản phẩm và biến thể
            return $Post; // Trả về đối tượng PDOStatement cho sản phẩm
                

                }catch (PDOException $e) {
                    // Ghi log lỗi hoặc xử lý theo cách phù hợp với ứng dụng của bạn
                    error_log("Lỗi khi lấy sản phẩm theo trang: " . $e->getMessage());
                    return []; // Trả về mảng rỗng trong trường hợp lỗi
                }
        }
        public function insert($name,$user,$date,$content,$image,$id=null) {
                echo $date;
            try {
                if ($id) {
                    // Update existing post
                    $stmt = $this->conn->prepare("UPDATE new SET name = :name, user_post = :user, img_src = :image, content = :content, date = :date WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind the ID
                } else {
                    // Insert new post
                    $stmt = $this->conn->prepare("INSERT INTO new (name, user_post, img_src, content, date) VALUES (:name,:user,:image,:content,:date)");
                }
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':user', $user, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':content', $content, PDO::PARAM_STR);
                $stmt->bindParam(':image', $image, PDO::PARAM_STR);

                $stmt->execute();
            if ($id) {
                    $stmt = $this->conn->prepare("SELECT * FROM new WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    return $stmt->fetch(PDO::FETCH_ASSOC); //return a single row
                } else {
                    $lastId = $this->conn->lastInsertId();
                    $stmt = $this->conn->prepare("SELECT * FROM new WHERE id = :lastId");
                    $stmt->bindParam(':lastId', $lastId, PDO::PARAM_INT);
                    $stmt->execute();
                    return $stmt->fetch(PDO::FETCH_ASSOC); //return a single row
                }
            } catch (PDOException $e) {
                error_log("Database error in insert: " . $e->getMessage()); // Log the error
                echo $e;
                return null;
            
            }
        }
        public function delete($id) {
                try {
                    if ($id) {
                        // Fetch the image path before deleting the database record
                        $stmt = $this->conn->prepare("SELECT img_src FROM new WHERE id = :id");
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        $imagePathToDelete = null;
                        if ($result && !empty($result['img_src'])) {
                            $imagePathToDelete = $result['img_src'];
                        }

                        // Delete the database record
                        $stmt = $this->conn->prepare("DELETE FROM new WHERE id = :id");
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                        $rowsDeleted = $stmt->rowCount();

                        // If the database record was deleted and an image path exists, delete the file
                        if ($rowsDeleted > 0 && $imagePathToDelete) {
                            if (file_exists($imagePathToDelete)) {
                                unlink($imagePathToDelete); // Attempt to delete the file
                                // Optionally, you could log if the file deletion succeeded or failed
                            }
                        }

                        return $rowsDeleted > 0; // Return true if the database record was deleted

                    } else {
                        return false; // Cannot delete without an ID
                    }
                } catch (PDOException $e) {
                    error_log("Database error in delete: " . $e->getMessage());
                    echo $e; // Consider removing in production
                    return false;
                }
        }

      
    } 

?>