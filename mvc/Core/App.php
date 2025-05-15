<?php
    class App{
        protected $controller = "Home";
        protected $action = "showMainPage";
        protected $params = [];

        function __construct() {

            $arr = $this -> UrlProcess();
            
            //Xử lí Controller
            if ($arr != null) {
                if (file_exists("./mvc/Controllers/".$arr[0].".php")) {
                $this -> controller = $arr[0];
                unset($arr[0]);
                }
            }

            require_once("./mvc/Controllers/".$this -> controller.".php"); 
            $this -> controller = new $this -> controller;
            
            //Xử lí Action
            if(isset($arr[1])) {
                if(method_exists($this -> controller, $arr[1])) {
                    $this -> action = $arr[1];
                }
                unset($arr[1]);
            }


            //Xử lí Params
            $this->params = $arr;

            if($this->params){
                foreach($this->params as $index=>$value){
                    $_GET[$index] = $value;
                }
    
            }
          

            call_user_func_array([$this -> controller, $this -> action], $this -> params);
            

        }

        function UrlProcess() {
            if(isset($_GET["url"])) {
                return explode("/", filter_var(trim($_GET["url"], "/")));
            }
        }

		// Kiểm tra một xâu ký tự có phải là text hay không
		// Input: $s
		// Điều kiện: Chỉ bao gồm các ký tự tiếng Việt và chữ số, dấu -, dấu trắng
        public static function isText($s) {
			$c1 = preg_match("/^[0-9a-zA-Záàạảãăắằặẳẵâấầậẩẫéèẹẻẽêếềệểễíìịỉĩóòọỏõôốồộổỗơớờợởỡúùụủũưứừựửữ\s\-]*$/", $s);
			if ($c1 == 1) return true;
			else return false;
		} 
    }
?>