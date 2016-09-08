$(document).ready(function(){
  $("#formArticulo").submit(function(e){

    $.post('/base/insert/' + $("#nombreArticulo").val(),{},function(){
      window.location.replace('/');      
    });

    e.preventDefault();
  });
});
