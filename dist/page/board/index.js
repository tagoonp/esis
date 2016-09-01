$(function(){
  $('#btnGen').click(function(){
    window.location = 'index.php?month=' + $('#txt-month').val() + '&year=' +  $('#txt-year').val() ;
  });
});
