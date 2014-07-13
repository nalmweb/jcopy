/* inputUi Slauta */

var slautaUi = {}
var StyleStatus = 0;

slautaUi.style = function(padding, font){
  $('.slautaUiStyle').remove();
  if(padding == 'undefined') padding = 4;
  if(font == 'undefined') font = 12;
  StyleStatus = 1;
  $('<div class="slautaUiStyle"><style type="text/css">.inputUi{border:1px solid #d9d9d9;border-top:1px solid #c0c0c0;padding: '+padding+'px !important;font-size: '+font+'px;}.inputUi:hover,.inputUi:focus{border:1px solid #4d90fe;outline:none;box-shadow:inset inset 0 1px 2px rgba(0,0,0,0.3);-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3)}</style></div>').appendTo($('body'));
}

slautaUi.input = function(id,placeholder){
  if(id == undefined) id = '';
  if(placeholder == undefined){
    var placeholder;
  }
  var padding = 4;
  var font = 14;

  this.setFont = function(fo){
    font = fo;
  }
  this.setPadding = function(pa){
    padding = pa;
  }
  this.setPlaceholder = function(pl){
    placeholder = pl;
  }
  this.getPlaceholder = function(){
    return placeholder;
  }
  this.add = function(id,placeholder){
    if(id == undefined) id = '';
    if(placeholder == undefined){
      var placeholder = '';
    }
    set(id,placeholder);
  }

  this.setG = function(id,placeholder){
    if(id == undefined) id = '';
    if(id == undefined) id = '';
    set(id,placeholder);
  }

  var set = function(id,placeholder){
    if(typeof id == 'object'){
      var idR;
      for(var i = 0; i < id.length; ++i){
        idR = id[i].replace('#','');
        $('#'+idR+':input:text').addClass('inputUi').attr({'placeholder':placeholder,'x-webkit-speech':'','speech':'','onwebkitspeechchange':'this.form.submit();'});
      }
    }else if(id != ''){
      id.replace('#','');
      $('#' + id +':input:text').addClass('inputUi').attr({'placeholder':placeholder,'x-webkit-speech':'','speech':'','onwebkitspeechchange':'this.form.submit();'});
    }else{
      $('input:text').addClass('inputUi').attr({'placeholder':placeholder,'x-webkit-speech':'','speech':'','onwebkitspeechchange':'this.form.submit();'});
    }
  }

  this.init = function(e){
      slautaUi.style(padding,font);
    //set(id,placeholder);
  }
  //$(init);
}

slautaUi.textarea = function(id){
  if(id == undefined) id = '';
  var padding = 4;
  var font = 14;

  this.setFont = function(fo){
    font = fo;
  }
  this.setPadding = function(pa){
    padding = pa;
  }
  this.add = function(id){
    if(id == undefined) id = '';
    set(id);
  }

  var set = function(id){
    if(typeof id == 'object'){
      var idR;
      for(var i = 0; i < id.length; ++i){
        idR = id[i].replace('#','');
        $('#'+idR+':textarea').addClass('inputUi');
      }
    }else if(id != ''){
      id.replace('#','');
      $('#' + id +':textarea').addClass('inputUi');
    }else{
      $('textarea').addClass('inputUi');
    }
  }

  var init = function(){
    if(StyleStatus == 0){
      slautaUi.style(padding,font);
    }
    set(id);
  }
  $(init);
}

slautaUi.select = function(id){
  if(id == undefined) id = '';
  var padding = 4;
  var font = 14;

  this.setFont = function(fo){
    font = fo;
  }
  this.setPadding = function(pa){
    padding = pa;
  }
  this.add = function(id){
    if(id == undefined) id = '';
    set(id);
  }

  var set = function(id){
    if(typeof id == 'object'){
      var idR;
      for(var i = 0; i < id.length; ++i){
        idR = id[i].replace('#','');
        $('#'+idR+':select').addClass('inputUi');
      }
    }else if(id != ''){
      id.replace('#','');
      $('#' + id +':select').addClass('inputUi');
    }else{
      $('select').addClass('inputUi');
    }
  }

  var init = function(){
    if(StyleStatus == 0){
      slautaUi.style(padding,font);
    }
    set(id);
  }
  $(init);
}

slautaUi.init = function(){
  slautaUi.input();
  slautaUi.textarea();
}

$(document).ready(function () {
  //slautaUi.input();
  slautaUi.textarea();
  slautaUi.select();
  //slautaUi.init();
  var a = new slautaUi.input();
  a.setG();
  a.init();
});