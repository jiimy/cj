function enterEvent() {
	/*if($('#quiz_input1').val() == '') {
		alert('정답을 입력해주세요');
		$('#quiz_input1').focus();
		
		return false;
	}
	
	if($('#quiz_input2').val() == '') {
		alert('정답을 입력해주세요');
		$('#quiz_input2').focus();
		
		return false;
	}
	
	if($('#quiz_input3').val() == '') {
		alert('정답을 입력해주세요');
		$('#quiz_input3').focus();
		
		return false;
	}
	
	if($('#quiz_input4').val() == '') {
		alert('정답을 입력해주세요');
		$('#quiz_input4').focus();
		
		return false;
	}*/
	
	if($('#quiz_input1').val() != '저' && $('#quiz_input2').val() != '온' && $('#quiz_input3').val() != '압' && $('#quiz_input4').val() != '착') {
		//showPop('wrong');
		showPop('quiz');
	} else {
		showPop('quiz');
	}
}

function submitForm(mode) {
	if(!$("#agree1").is(":checked")) {
		showPop('agree');
		$('#agree1').focus();

		return false;
	}

	if(!$("#agree2").is(":checked")) {
		showPop('agree');
		$('#agree2').focus();

		return false;
	}

	if($('#name').val() == '') {
		alert('성명을 입력해주세요');
		$('#name').focus();

		return false;
	}

	if($('#phone').val() == '') {
		alert('연락처를 입력해주세요');
		$('#phone').focus();

		return false;
	}

	if($('#zipcode').val() == '') {
		alert('주소를 입력해주세요.');

		return false;
	}

	if($('#address').val() == '') {
		alert('주소를 입력해주세요.');

		return false;
	}

	if($('#address_detail').val() == '') {
		alert('주소를 입력해 주세요.');
		$('#address_detail').focus();

		return false;
	}
}

function showPop(div) {
	if(div == 'wrong') {
		$('.false-answer').addClass('block');
	}
	
	if(div == 'quiz') {
		$('#pop_div').val('quiz');
		$('#pop_text').html('정답입니다!');
		$('.complete-vote').addClass('block');
	}

	if(div == 'vote') {
		$('#pop_div').val('vote');
		$('#pop_text').html('투표가 완료되었습니다');
		$('.complete-vote').addClass('block');
	}

	if(div == 'agree') {
		$('.agree').addClass('block');
	}

	if(div != 'agree') {
		$('body').addClass('is-overflow');
	}
}

function closePop(div) {
	if(div == 'agree') {
		$('.agree').removeClass('block');
	}

	if(div != 'agree') {
		$('body').removeClass('is-overflow');
	}
}

function autoHypenPhone(str) {
	str = str.replace(/[^0-9]/g, '');
	var tmp = '';
	if(str.length < 4) {
		return str;
	} else if(str.length < 7) {
		tmp += str.substr(0, 3);
		tmp += '-';
		tmp += str.substr(3);

		return tmp;
	} else if(str.length < 11) {
		tmp += str.substr(0, 3);
		tmp += '-';
		tmp += str.substr(3, 3);
		tmp += '-';
		tmp += str.substr(6);

		return tmp;
	} else {
		tmp += str.substr(0, 3);
		tmp += '-';
		tmp += str.substr(3, 4);
		tmp += '-';
		tmp += str.substr(7);

		return tmp;
	}

	return str;
}

$(document).ready(function() {
	$('#phone').on('keyup change', function(event) {
	   event = event || window.event;
	   var keycode = event.keyCode || event.which;
	   var val = this.value.trim();
	   this.value = autoHypenPhone(val);
	});
});