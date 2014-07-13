// Event.observe(window,'load',menu);
// based on controller and action
// not used anymore.
function menu()
{
    var menu  = new Array ('news','meetings','albums','board','catalog','ugon','search','myalbums');    
	var ctrl = $F('ctrl');
		
	if(ctrl=='index' || ctrl== 'users' || ctrl=='registration' ) return;
	var act  = $F('act') ;

	if(ctrl=='albums'){
		if(act=='myalbums' || act =='myphotos')
			$('myalbums').className  = 'select';
		else $('newphotos').className = 'select' ;
	}
	else
	{
		// alert($(ctrl).className);
	    //if(null != $(ctrl).className )	
		//	$(ctrl).className = 'select';
	}
}
// Better change for lightBox.
function OpenWindow(imgName,imgSRC,imgWidth,imgHeight)
{
  if( imgName && imgSRC && imgWidth && imgHeight )
  {
	str='width='+imgWidth+',height='
					+imgHeight+',left=200,top=200,status=no,toolbar=no,menubar=no,location=no,scrollbars=no,resizable=no,titlebar=no';
	wnd = window.open("",null,str);
	wnd.focus();
	wnd.document.close();
	wnd.document.open();
	wnd.document.clear();
					
	str = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"><html><head><title>"
			+ imgName
			+ "</title></head>	<body bgcolor=\"#000000\" leftmargin=\"0\" marginheight=\"0\" marginwidth=\"0\" rightmargin=\"0\" topmargin=\"0\"><img src=\""
			+ imgSRC 
			+"\" alt=\""
			+ imgName 
			+"\" width=\""
			+ imgWidth +"\" height=\""+ imgHeight +"\" border=\"0\"> </body></html>";
		wnd.document.write(str);
	  return false;
    }
    return false;
}

  function do_enable(id)
  {
     var item = document.getElementById(id);
     
    if(item.disabled)
     	item.disabled = false;
     else
       item.disabled=true;
  }
