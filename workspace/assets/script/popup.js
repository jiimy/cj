function showpopup(openBtn, popup){
  $(openBtn).click(function(){
    $(popup).addClass('block');
  })
}

function closepopup(closeBtn){
  $(closeBtn).click(function(){
    $(this).closest('.popup').removeClass('block');
  })
}

closepopup('.close-btn, .dim');
showpopup('.detail', '.recipe');

// $('.detail').click(function(){
//   $('.recipe').addClass('block');
// })

// $('.wrapper').click(function(){
//   console.log('바디클릭');
// })
