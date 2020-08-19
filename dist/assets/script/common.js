$('.btn-detail').click(function(){
  $(this).closest('.agree').siblings('.agree').removeClass('is-on');
  $(this).closest('.agree').toggleClass('is-on');
});