<?php
require_once("./mvc/core/Database.php");
class ProductModel extends DataBase {
    private $tableName = 'product'; // Tên bảng sản phẩm
    private $tableNameBt = 'bt_product'; // Tên bảng sản phẩm

    /**
     * Lấy tổng số sản phẩm từ bảng.
     *
     * @return int Tổng số sản phẩm.
     */
    public function getTotalProducts(): int {
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

    /**
     * Lấy danh sách sản phẩm theo trang.
     *
     * @param int $limit Số lượng sản phẩm trên mỗi trang.
     * @param int $page  Số trang hiện tại.
     * @return array Mảng chứa danh sách sản phẩm.
     */
    public function getProductsByPage(int $limit, int $page): array {
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

    public function getProductDetailByID(int $id): array {
            try{
               // Truy vấn lấy thông tin sản phẩm theo ID
               $stmtProduct = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE id = :id");
               $stmtProduct->bindParam(':id', $id, PDO::PARAM_INT);
               $stmtProduct->execute();
               $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);
       
               if (!$product) {
                     return []; // Không tìm thấy sản phẩm với ID này
               }

                // Truy vấn lấy thông tin biến thể sản phẩm theo product_id
        $stmtVariant = $this->conn->prepare("SELECT * FROM {$this->tableNameBt} WHERE id_product = :id_product");
        $stmtVariant->bindParam(':id_product', $id, PDO::PARAM_INT);
        $stmtVariant->execute();
        $variants = $stmtVariant->fetchAll(PDO::FETCH_ASSOC);

        // Trả về một mảng chứa thông tin sản phẩm và biến thể
        return [
            'product' => $product, // Trả về đối tượng PDOStatement cho sản phẩm
            'variants' => $variants, // Trả về đối tượng PDOStatement cho biến thể
        ];
            }catch (PDOException $e) {
                // Ghi log lỗi hoặc xử lý theo cách phù hợp với ứng dụng của bạn
                error_log("Lỗi khi lấy sản phẩm theo trang: " . $e->getMessage());
                return []; // Trả về mảng rỗng trong trường hợp lỗi
            }
    }


        public function insert($name,$price,$img,$content,$id=null) {
            
        try {
            if ($id) {
                // Update existing post
                $stmt = $this->conn->prepare("UPDATE product SET name = :name, price = :price, img_src = :image, mo_ta = :content WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind the ID
            } else {
                // Insert new post
                $stmt = $this->conn->prepare("INSERT INTO product (name, price, img_src, mo_ta) VALUES (:name,:price,:image,:content)");
            }
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':image', $img, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);

            $stmt->execute();
          if ($id) {
                $stmt = $this->conn->prepare("SELECT * FROM product WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); //return a single row
            } else {
                $lastId = $this->conn->lastInsertId();
                $stmt = $this->conn->prepare("SELECT * FROM product WHERE id = :lastId");
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
                $stmt = $this->conn->prepare("SELECT img_src FROM product WHERE id = :id");
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
    public function getDetailByProductId($id) {
         try {

                // Update existing post
                $stmt = $this->conn->prepare("select * from bt_product WHERE id_product = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind the ID
        
             
          
            $stmt->execute();
             return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error : " . $e->getMessage()); // Log the error
            echo $e;
            return null;
           
        }
    }

     public function UpdateDeatailOrInsertId($name,$big_image,$small_image,$id=null) {
         try {
                if ($id) {
                    // Update existing bt_product
                    $stmt = $this->conn->prepare("UPDATE bt_product SET name = :name, img_src_big = :big_img, img_src_small = :small_img WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind the ID
                } else {
                    // Insert new bt_product
                    $stmt = $this->conn->prepare("INSERT INTO bt_product (name, img_src_big, img_src_small) VALUES (:name,:big_img,:small_img)");
                }
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':big_img', $big_image, PDO::PARAM_STR);
                $stmt->bindParam(':small_img', $small_image, PDO::PARAM_STR);
                 $stmt->execute();
          if ($id) {
                $stmt = $this->conn->prepare("SELECT * FROM bt_product WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); //return a single row
            } else {
                $lastId = $this->conn->lastInsertId();
                $stmt = $this->conn->prepare("SELECT * FROM bt_product WHERE id = :lastId");
                $stmt->bindParam(':lastId', $lastId, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); //return a single row
            }

        } catch (PDOException $e) {
            error_log("Database error : " . $e->getMessage()); // Log the error
            echo $e;
            return null;
           
        }
    }

       public function DeleteDetail($id) {
             try {
            if ($id) {
                // Fetch the image path before deleting the database record
                $stmt = $this->conn->prepare("SELECT img_src_big,img_src_small FROM bt_product WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $imagePathToDelete = null;
                if ($result && !empty($result['img_src_big'])) {
                    $imagePathToDelete = $result['img_src_big'];
                }
                if ($result && !empty($result['img_src_small'])) {
                    $imagePathToDelete = $result['img_src_small'];
                }

                // Delete the database record
                $stmt = $this->conn->prepare("DELETE FROM bt_product WHERE id = :id");
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