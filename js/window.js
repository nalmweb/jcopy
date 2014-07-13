 
    function show_window(window_id)
    {
    	var win	  = document.getElementById(window_id);
    	var h_pos = document.body.clientWidth/2 - 402;
		var v_pos = document.body.scrollTop + 30; // document.body.clientHeight/2 - win.height/2;

		win.style.left = h_pos;
		win.style.top  = v_pos;
		//layer.style.width  = document.body.clientWidth;
		//layer.style.height = 1000;
		//img.width  = document.body.clientWidth;
		//img.height = 2900;
		//enableAlphaImages();
		win.style.display   = "block";
		//layer.style.display = "block";
	  return true;
    } 
    
    function close_window(window_id)
    {
       // var layer = document.getElementById("layerShadow");
	   var win = document.getElementById(window_id);
		
	   win.style.left = 0;
 	   win.style.top  = 0;		
		//img.width  = 0;
		//img.height = 0;
		win.style.display	= "none";
		//layer.style.display = "none";
		return false;
    }
 
	function show()
	{
		alert("asdf");
		
		var layer = document.getElementById("layerShadow");
		var win	  = document.getElementById("questionLayer");
		var img   = document.images["bg"];
		
		var h_pos = document.body.clientWidth/2 - 402;
		var v_pos = document.body.scrollTop + 30; // document.body.clientHeight/2 - win.height/2;

		win.style.left = h_pos;
		win.style.top  = v_pos;
		
		layer.style.width  = document.body.clientWidth;
		layer.style.height = 1000;		
		
		img.width  = document.body.clientWidth;
		img.height = 2900;
		
		enableAlphaImages();
		
		win.style.display   = "block";
		layer.style.display = "block";
	}
	
	function show_send()
	{
		var layer = document.getElementById("layerShadow");
		var win	   = document.getElementById("sendLayer");
		var img  = document.images["bg"];
		
		var h_pos = document.body.clientWidth/2 - 182;
		var v_pos = document.body.scrollTop + 260; // document.body.clientHeight/2 - win.height/2;

		win.style.left = h_pos;
		win.style.top  = v_pos;
		
		layer.style.width  = document.body.clientWidth;
		layer.style.height = 1000;		
		
		img.width  = document.body.clientWidth;
		img.height = 2900;
		
		enableAlphaImages();
		
		win.style.display   = "block";
		layer.style.display = "block";
		
    	setTimeout("hide_send();",5000);
	}
	
		
	function hide(){
	
		var layer = document.getElementById("layerShadow");
		var win	  = document.getElementById("questionLayer");
		
		win.style.left = 0;
		win.style.top  = 0;
		
		img.width  = 0;
		img.height = 0;
		
		win.style.display	= "none";
		layer.style.display = "none";
	}
	function hide_send(){
	
		var layer = document.getElementById("layerShadow");
		var win	  = document.getElementById("sendLayer");
		
		win.style.left = 0;
		win.style.top  = 0;	
		
		win.style.display	= "none";
		layer.style.display = "none";
	}

	function enableAlphaImages()
	{
		var rslt = navigator.appVersion.match(/MSIE (\d+\.\d+)/, '');
		var itsAllGood = (rslt != null && Number(rslt[1]) >= 5.5);
	
		var img = document.images["bg"];
	
		isDOM = document.getElementById //DOM1 browser (MSIE 5+, Netscape 6, Opera 5+)
		isOpera = isOpera5 = window.opera && isDOM //Opera 5+
		isMSIE = document.all && document.all.item && !isOpera //Microsoft Internet Explorer 4+
		isMSIE5 = isDOM && isMSIE //MSIE 5+
	
		if (isMSIE5)
		{
			img.src = "/admin/images/bg.png";
			document.getElementById("layerShadow").filters.Alpha.opacity = 30;
		}
	}

	function ON(obj)
	{
		obj.className='on';
	}
	
	function OFF(obj)
	{
		obj.className='off';
	}

	function L_ON(n)
	{
		document.getElementById('page'+n).className='logo_on';
	}

	function L_OFF(n)
	{
		document.getElementById('page'+n).className='logo_off';
	}
	
	function presubmit(f)
	{
	     reg=/[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-\.]+\.[a-zA-Z]+/;
		 result = reg.test(f.email.value);
		 
	 	 if (f.username.value == ''){
		    f.username.focus();
			return false;
		 }
		 if (!result){ 
		    f.email.focus(); 
		    return false; 
		 }
		 if (f.phone.value == '') {
		     f.phone.focus(); 
			 return false;
		 }
		 if (f.textbody.value == '') {
		    f.textbody.focus(); 
			return false;
		 }
		 hide();
		 
		 return true;
	}