var Loading = {
  start:function () {
    var i = 0;
    var maxI = 100;
    var minI = 10;
    var time = 1000;

    if ($('#loaddingDiv') != undefined) {
      $('#loaddingDiv').modal();
      $('#simplemodal-container a.modalCloseImg').remove();
      var interval = setInterval(function(){
        if(i == minI){
          //$.modal.close();
          $('#messageLoadind').fadeIn(time);
        }else if(i >= maxI){
          $('.loadDeleteMessage').fadeOut(time);
          $('.loadDeleteMessage').remove();
          $('.loaddingDivClass').prepend('<p style="text-align: center">Сервер не отвечает!</p>');
          clearInterval(interval);
        }
        ++i;
      }, time);
    }
  },
  end:function () {
    $.modal.close();
  }
}

$(document).ready(function(){
  //Loading.start();
});