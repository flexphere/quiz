
$(function(){
  $('[data-link]').on('click', function(){
    location.href = $(this).data('link');
  });

  $('#nick-submit').on('click', function(){
    var nickname = $("#nick").val().trim();
    if (nickname != '') {
      $.post('./api.php', {action:'set_nickname', nick:nickname});
      $('.modal-nick').fadeOut();
    }
  })
});
