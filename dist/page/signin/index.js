$(function(){
  $('.js-validation-bootstrap').submit(function(){
    var tokenString = getToken();
    if(($('#login1-username').val()!='') && ($('#login1-password').val()!='')){
      var jqxhr = $.post('controller/authen.php', {username: $('#login1-username').val(), password: $('#login1-password').val(), token: tokenString }, function(result){ });

      jqxhr.fail(function(error){
        // console.log(error.responseJSON);
      });

      jqxhr.always(function(result){
        if(result=='Y'){
          window.location = 'controller/redirect.php';
        }else{
          console.log('Cannot access this system');
        }
      });
    }
  });
});

function getToken(){
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789{}[]*#";

  for( var i=0; i < 20; i++ ){
    text += possible.charAt(Math.floor(Math.random() * possible.length));
  }
  return text;
}
