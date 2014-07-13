function check_all (id_name)
{
  // alert('p' + parent);
  var m1 =  document.getElementById('parent'); var len = m1.length;
 		
  for (var i=0; i < len; i++)
  {
  	var name = id_name +"_" + i;
    var e = document.getElementById(name);
     if( e.checked == true) 
 	   e.checked = false
     else 	
         e.checked = true;
  }
}

/*
    1) get selected elements
    2) send them - send news ids
    3) change style.className
*/
function doApprove(type)
{
   var m1=document.getElementById('parent');
   var len=m1.length;
   var news_ids = new Array();
   var rows_ids = new Array();
   var count=0;
 		
   for (var i=0; i < len; i++)
   {
  	var name = 'news' +"_"  + i;
    var e = document.getElementById(name);
    
     if( e.checked == true) 
     {
     	news_ids[count] = e.value;//set id
     	rows_ids[count]=i;
     	//alert(rows_ids[count]);
     	count++;
     	// $('row_'+i).className='okNews';
     }
   }
   var items = document.getElementById('temp_items');
      items.value=rows_ids;
     
   if(type=='approve')     
        xajax_approve(news_ids,'false');
   else if(type=='delete') xajax_approve(news_ids,'true');
}

function callback_approve(res,type)
{
    if(res!=null)
    {
	  var items = document.getElementById('temp_items').value;
	  var res = items.match(/\d+/g);
	  
	  if(type=='approve')
	  {
	    for(var i=0;i<res.length; i++)
	        document.getElementById('row_'+res[i]).className='okNews';
	  }
	  else if(type=='delete')
	  {
	       var table=document.getElementById('news_table');
	       var tb = table.getElementsByTagName('TBODY')[0];
	       
	       for(var i=0;i<res.length; i++)
	       {
  	          var row = document.getElementById('row_'+res[i]);
  	          tb.removeChild(row);
	       }
	  }
    }      
}

function doText(item_id,cat_name)
{
	alert('asdf');
	var cat = $('cat_'+item_id);
	var menu = $('text_menu');
	
	var div = document.createElement("div");
	var input = document.createElement("text");
	    input.value=cat_name;
	    div.appendChild(input);
	   
	cat.innerHTML = div.innerHTML;
}

function addCategory()
{
	var cat= $('new_category');
	
	if(cat.value!='')
	{
	   xajax_addCategory(cat.value);
	   $('new_category').value='';
	}
	else 
		alert("Введите название категории");
}

// add new node 
function callback_addCategory(text)
{
    alert(text);
	var parent = $('tab');
	var item = document.createElement('tr');
	var txt  = document.createTextNode(text);	
	item.appendChild(txt);
	parent.appendChild(item);
}

/*
     статьи, связанные с категориями, не удалеются
*/
function deleteCategory(cat_id,response)
{    
	if(response=='')
   		xajax_deleteCategory(cat_id);
   		
   	else if(response=='ok')
   	{
   	    var table = $('tab');
   	    var tr    = $('tr_'+cat_id);
   	    tr.parentNode.removeChild(tr);
   	}
}