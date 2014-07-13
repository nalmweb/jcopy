


/// COMMENT MANAGER ///

var product_id = 0;/// {$product.id};
var t_pfx = '';

function CommentManager()
{
    this.container = document.getElementById('comment_container');
    this.tpl       = document.getElementById('comment_template');
    this.tpl_name  = document.getElementById('comment_template_name');
    this.tpl_msg   = document.getElementById('comment_template_msg');
    this.tpl_id    = document.getElementById('comment_template_id');

    // bind static comments
    if(this.container.firstChild!='')
    {
    var child = this.container.firstChild;
    var comments = new Array();

        while(child != null){
            if(child.id && child.id.substr(0, 11) == 'comment_id_'){
                var item = new Object();
                item['id'] = child.id.substr(11);
                item['node'] = child;
                comments.push(item);
            }
            child = child.nextSibling;
        }
    }
    this.comments = comments;
}

CommentManager.prototype.GetKnownIds = function (){
    var ids = new Array();
    for(var i = 0; i < this.comments.length; i++){
        ids.push(this.comments[i]['id']);
    }

    return ids;
}

CommentManager.prototype.AddComment = function (id, name, msg){
    var item = new Object();
    var textNode = document.createTextNode(name);
    var textNode2 = document.createTextNode(msg);

    item['id'] = id;

    this.tpl_id.value = item.id;
    this.tpl_name.appendChild(textNode);
    this.tpl_msg.appendChild(textNode2);
    item['node'] = this.tpl.cloneNode(true);
    this.tpl_name.removeChild(textNode);
    this.tpl_msg.removeChild(textNode2);

    item['node'].style.display = 'block';
    this.comments.push(item);

    this.container.insertBefore(item.node, this.container.firstChild);
}

CommentManager.prototype.DelComment = function (id){
    for(var i = 0; i < this.comments.length; i++){
        if(this.comments[i]['id'] == id){
            var node = this.comments[i]['node'];
            node.parentNode.removeChild(node);
            this.comments.splice(i, 1);
            return true;
        }
    }

    return false;
}

CommentManager.prototype.debug = function (){
    var s = new String();
    for(var i = 0; i < this.comments.length; i++){
        s += this.comments[i]['id'] + ' ';
    }
    alert(s);
}

        // FIXME: ON INIT

//// HANDLERS ////
// (me)
function handler_add_comment()
{
    var manager = new CommentManager();
    //
    var table  = document.getElementById('t_type').value + "_";
    //var news_title = document.getElementById('news_item').value;
    //alert("nt =" + news_title);
  //  var t = table + 'item';
   // alert(t);
    var item_id = document.getElementById(table + 'item').value;
    //alert(item_id);
    var title   = document.getElementById(table + 'title').value;
    //alert("t = " + title);
    var comment = document.getElementById(table + 'comment').value;
    // var comment="";
    // alert("comment = " + comment);
    xajax_addCommentsAction(item_id,title,comment, manager.GetKnownIds());

    return false;
}

function handler_remove_comment(me){
    xajax_delComments(me.id.value, product_id, manager.GetKnownIds());
    return false;
}

//###############################################


function debug_info(){
    manager.debug();
}


//###############################################

var counter = 10;
var last_update_time = new Date();

function can_ajax (){
    var now = new Date();
    return ((now.getTime() - last_update_time.getTime()) > 5000);
}

function on_timer()
{
    if(can_ajax())
    {
        var table  = document.getElementById('t_type').value + "_";
        var item_id = document.getElementById(table + 'item').value;

        xajax_updateComments(item_id, manager.GetKnownIds());

    }

    if(counter--){
        window.setTimeout("on_timer()", 5000);
    }
    else{
        counter = 10;
        window.location.reload();
    }
}

function on_load(operation)
{
    product_id = document.getElementById('product_id').value;
    window.setTimeout("on_timer()", 5000);

    if(operation=='add')
    {
        handler_add_comment();
    }
    else if (operation =='del')
    {
       // not supported yet;
       handler_remove_comment();
    }
}
// on_load();

function show()
{
  // alert('asdfasfasdf');
}



