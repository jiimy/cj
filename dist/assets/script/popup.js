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
showpopup('.btn-recipe', '.recipe');
showpopup('.btn-correct-answer', '.correct-answer');
showpopup('.btn-agree', '.agree');
showpopup('.btn-false-answer', '.false-answer');

$btn_idx: '';
$('.event2 .card1 .detail').click(function(){
  $('.recipe1').addClass('block');
  $btn_idx = 1;
})

$('.btn-popup-next').click(function(){
  if($btn_idx = 1) {
    
  }
})


// $('.detail').click(function(){
//   $('.recipe').addClass('block');
// })

// $('.wrapper').click(function(){
//   console.log('바디클릭');
// })
