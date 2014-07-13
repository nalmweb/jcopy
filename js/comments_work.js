var timeout=-1;//param to stop it!
var c=0;
// set commented nodeID
function setItemId(node_id){
  $('prod_id').value = node_id;
}
/*
    save data to hidden form
	show progress
	send info to db ( add script call to stop progress)
	 if(OK) add data -> 
	 else  -> showError window!
*/
function doReply(node_id,prod_id){
  if(validate(node_id,'c_content'))
  {
 	$('btnAddComment').style.display = "none";
  	$('spin').style.display = 'block';
  	$('spin').style.height = '30px';
    process(); // show ajax-loader
	saveSendData(node_id,'c_content',prod_id);
  }
}

function doComment(node_id){
  if(validate(node_id,'comment_text'))
  {
// 	$('btnAddComment').style.display = "none";
  	$('spin').style.display = 'block';
  	$('spin').style.height = '30px';
    process(); // show ajax-loader
    // node_id,...,node_id = cos same
	saveSendData(node_id,'comment_text',node_id);
  }
}

// item_id - is an id of textarea in comments list
function validate(node_id,item_id){
	
	var c='';
	var node = item_id+""+node_id;
    c=$F(node);
    c=c.replace(/^\s+|\s+$/g,"");
    
    var bPassed = true;
        
    if(c.length <= 0){
       bPassed=false;
       comment.className = 'err';
    }
    if(!bPassed){
    	alert('Коментарий не может быть пустым');
       	return false;
    }       		
	return true;
}

/*
  Save comment
    child | parent 
    * disable add button, enable afterwards
*/
function saveSendData(node_id,item_id,prod_id)
{
   var c = $F(item_id+node_id);
   c = c.replace(/^\s+|\s+$/g,"");
   var comment_type = $F('type');
   // alert ("n = "+node_id  +"c = "+c);
   $type='c';
   if(node_id==$F('parent_id')) $type = 'p';
   xajax_addComment(node_id,c,$type,comment_type,prod_id);
}

// Show processing image
function process()
{
	 if(timeout > 0)
	 	 timeout = setTimeout('process()',1500);
	 else
	 {
	 	clearTimeout(timeout);
	 	$('spin').style.visibility = 'hidden';
	 	return false;
	 }
}

// *****************************************
// html - comlete html
function showButton(){
   $('btnAddComment').show();
}
function hideForm(id){
   $(id).hide();
}

function delComment(id){
	var com_t = $F('type');
	var parent_id = $F('parent_id');
    xajax_delComment(id,parent_id,com_t);
    return false;
}

function callback_delComment(type,id)
{
	//if(type=='del')
	//{
	    var node = $('comment_id_' + id);
		node.parentNode.removeChild(node); 
	//}
	//else if (type=='update')
		$('c_content_' + id).innerHTML = 'удаленный коментарий'; 
}

function replaceNode(from_id,to_id){
  var from = $('comment_id_'+from_id);
  var to   = $('comment_id_'+to_id);
  var temp = $('temp');
    temp.innerHTML = from.innerHTML;
    from.innerHTML = to.innerHTML;
    to.innerHTML   = temp.innerHTML;
}

function setTitle()
{
	$('c_content_' + 123140).innerHTML = 'удаленный коментарий'; 
}

function blind(id){
   new Effect.BlindDown('c1');
}

function shake(id){
   new Effect.Shake(id);
}


function do_rotatePhoto(path,width,height,id){
	var elem = $('photo_'+id);
	elem.style.display='none';
	xajax_rotatePhoto(path,width,height,id);
}
