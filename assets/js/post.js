
$(document).ready(function(){


  $("#link").click(function(){
	
	var id=$(this).attr("value");
   post(id);
});
});

function post(id){
 $.post("/ShopProject/PostDetail", // The URL to send the request to
    {id:id
    },
	function(data, status){ 
    });
 
}

