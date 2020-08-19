function showpopup(openBtn, popup){
  $(openBtn).click(function(){
    $(popup).addClass('block');
    $('body').addClass('is-overflow');
  })
}

function closepopup(closeBtn){
  $(closeBtn).click(function(){
    $(this).closest('.popup').removeClass('block');
    $('body').removeClass('is-overflow');
  })
}

closepopup('.close-btn, .dim');
closepopup('.btn-red');

showpopup('.btn-complete-vote', '.complete-vote');
// showpopup('.event2 .card1 .detail', '.recipe1');
showpopup('.event2 .card2 .detail', '.recipe2');
showpopup('.btn-correct-answer', '.correct-answer');
showpopup('.btn-agree', '.agree');
showpopup('.btn-false-answer', '.false-answer');


// 레시피 팝업
// $btn_idx = 0 일때 재료, 
// $btn_idx = 1 일때 첫번째
// $btn_idx = 2 일때 두번째
$btn_idx: '';
$('.event2 .card1 .detail').click(function(){
  $('.recipe1').addClass('block');
  $btn_idx = 0;
  $('.recipe1 .list').addClass('none');
  $('.recipe1 .list0').removeClass('none');
  $('.recipe1 .btn-wrap').addClass('none');
  $('.recipe1 .btn-popup-next').removeClass('none');
})


$('.recipe1 .btn-popup-next').click(function(){
  switch ($btn_idx) {
    case 0:
      $('.recipe1 .list').addClass('none');
      $('.recipe1 .list1').removeClass('none');
      $btn_idx = 1;
    break;

    case 1:
      $('.recipe1 .list').addClass('none');
      $('.recipe1 .list2').removeClass('none');
      $(this).addClass('none');
      $(this).closest('.popup__wrap').children('.btn-wrap ').removeClass('none');
    break;
    default:
      break;
  }
})

$('.recipe1 .close-btn').click(function(){
  $btn_idx = 0;
  console.log($btn_idx);
})
