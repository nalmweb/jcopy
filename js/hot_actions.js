Event.observe(window,'load',init);
// why wrong coords?
function init()
{
 	// var wrapper = $('hot_wrapper');
	var elems =document.getElementsByClassName('profile');
	var elems2=document.getElementsByClassName('profile2');
//  	alert('elems '+ elems.length);
	var id = 0;
	for(var i=0; i<elems.length; i++)
	{
      id = elems[i].getAttribute('id');
      // alert(id);
      Event.observe($(id),'mouseover',showActions);
	}
	for(var i=0; i<elems2.length; i++)
	{
      id = elems2[i].getAttribute('id');
      Event.observe($(id),'mouseover',showActions2);
	}
	// Oberve all wrappers:
	elems = '';
	elems = document.getElementsByClassName('hot_wrapper');
	elems2 = document.getElementsByClassName('hot_wrapper2');
	// alert()
	for(var i=0; i < elems.length; i++)
	{
	    id = elems[i].getAttribute('id');
	    Event.observe($(id),'mouseout',hideActions);
	}
	
	for(var i=0; i < elems2.length; i++)
	{
	    id = elems2[i].getAttribute('id');
	    Event.observe($(id),'mouseout',hideActions2);
	}
    //Event.observe(wrapper,'mouseout' ,hideActions);
}
/*
     show actions when user mouse over's 
 	 make offset if close to client's screen
*/   
function showActions (event)
{
    var event_id = '';        
    try{
		event_id =event.target.getAttribute('id'); // ff 
	}catch(e){
		event_id =  event.srcElement.getAttribute('id');
	}
	if(event_id=='null' || typeof event_id == "undefined" ) return false;
    // alert('id = ' + event_id);
	var start = event_id.indexOf('uid_');
	
	if(start!=-1){
		var item_id = event_id.substring(start+4);
		var w_id    = 'hot_wrapper' + item_id;
		// alert(" event  = " + event_id +"x = " + Event.pointerX(event) + " y = " + Event.pointerY(event));
		$( w_id ).style.left = Event.pointerX(event)-50+'px' ; 
    	$( w_id ).style.top  = Event.pointerY(event)-25+'px' ; 
    	$( w_id ).style.display = 'block';
	}
}

function showActions2 (event){
    var event_id = '';        
    try
    {
		event_id =event.target.getAttribute('id'); // ff 
	}
	catch(e)
	{
	   event_id =  event.srcElement.getAttribute('id');
	}
	if(event_id=='null' || typeof event_id == "undefined" ) return false;
    // alert('id = ' + event_id);
	var start = event_id.indexOf('uid2_');
	
	if(start!=-1)
	{
		var item_id = event_id.substring(start+5);
		var w_id    = 'hot_wrapper2_' + item_id;
//		alert("item_id="+ item_id+" item="+w_id+"event="+event_id+"x="+Event.pointerX(event)+"y="+Event.pointerY(event));
//		alert("itemid= "+w_id + " wrapper = " );
//		alert(" event  = " + event_id +"x = " + Event.pointerX(event) + " y = " + Event.pointerY(event));
		var y= Event.pointerY(event)-25;
//		alert("y="+y);
		$( w_id ).style.left = Event.pointerX(event)-50+'px' ; 
    	$( w_id ).style.top  = y+'px';
    	$( w_id ).style.display = 'block';
	}
}

function hideActions(event)
{
	var event_id = '';
	try{
		event_id =event.target.getAttribute('id'); // ff 
	}catch(e){
		event_id =  event.srcElement.getAttribute('id');
	}

	if(event_id=='null' || typeof event_id == "undefined") return false;
    // alert("out event_id =" + event_id);
	var start = event_id.indexOf ('hot_wrapper');
	if(start!=-1)
	{
    	var item_id = event_id.substring(start+11);
	    var w_id  = 'hot_wrapper'+item_id;
	    // alert("out, w_id = " + w_id);
    	if (event_id.indexOf('hot_wrapper')!=-1 /* || event_id.indexOf('hot_actions') != -1 */) 
    	{
    	  $( w_id ).style.display = 'none';
    	}
	}
}

function hideActions2(event)
{
	var event_id = '';
	
	try{
		event_id =event.target.getAttribute('id'); // ff 
	}catch(e){
		event_id =  event.srcElement.getAttribute('id');
	}
	
	if(event_id=='null' || typeof event_id == "undefined") return false;
	var start = event_id.indexOf ('hot_wrapper2_');
	
	// var start = event_id.indexOf ('profile2');
	if(start!=-1)
	{
       var item_id = event_id.substring(start+13);
	   // alert("item ="+item_id + " event_id " + event_id )
	   var w_id  = 'hot_wrapper2_'+item_id;
       if (event_id.indexOf('hot_wrapper2_')!=-1 /* || event_id.indexOf('hot_actions') != -1 */) 
       {
    	$( w_id ).style.display = 'none';
       }
	}
}

// all *.js must be loaded brfore. 
function showDialog(id){
 Dialog.window($(id).innerHTML, {className: "alphacube", width:400,height:267, id: "d12"})
}

function onAddFriend(friend_id)
{
  var message=document.getElementById('message').value;
  xajax_addFriendDo(friend_id,'message');
}

function onSendMessage(friend_id)
{
  var message=document.getElementById('message').value;
  var subject=document.getElementById('subject').value;
  xajax_sendMessageDo(friend_id,subject,message);
}