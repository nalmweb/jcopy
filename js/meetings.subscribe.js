// send msg, show another button if ok 
function subscribe (value,user_id)
{
	//check that user plays with buttons:
	var uid;
	try{
		// 
		uid = F('ulid_'+user_id);
	}
	catch(Exception)
	{
	   uid = ''	;
	}
	if(uid==''){
    	xajax_subscribe(value);
	}
}
function unsubscribe (value,user_id){
   xajax_unsubscribe(value);	
}
// 
function callback_unsubscribe(res,user_id){
	if(res){
		var avatar = $('u_'+user_id);
		avatar.parentNode.removeChild(avatar);
	}
}