function enterEvent() {
	/*if($('#quiz_input1').val() == '') {
		alert('정답을 입력해주세요.');
		$('#quiz_input1').focus();
		
		return false;
	}
	
	if($('#quiz_input2').val() == '') {
		alert('정답을 입력해주세요.');
		$('#quiz_input2').focus();
		
		return false;
	}
	
	if($('#quiz_input3').val() == '') {
		alert('정답을 입력해주세요.');
		$('#quiz_input3').focus();
		
		return false;
	}
	
	if($('#quiz_input4').val() == '') {
		alert('정답을 입력해주세요.');
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

function submitForm(popDiv, voteDiv) {
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
		alert('성명을 입력해주세요.');
		$('#name').focus();

		return false;
	}

	if($('#phone').val() == '') {
		alert('연락처를 입력해주세요.');
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
		alert('주소를 입력해주세요.');
		$('#address_detail').focus();

		return false;
	}

	$.ajax({
		cache : false,
		async : false,
		type : 'post',
		url : '/process/event_proc.php',
		data : {
			name : $('#name').val(),
			phone : $('#phone').val(),
			zipcode : $('#zipcode').val(),
			address : $('#address').val(),
			address_detail : $('#address_detail').val(),
			pop_div : popDiv,
			vote_div : voteDiv
		},
		dataType : 'text',
		success : function(result) {
			if($.trim(result) == 'success') {
				alert('정상적으로 등록되었습니다.');
				closePop('quiz');
			} else if($.trim(result) == 'overlap') {
				alert('이미 참여하셨습니다.');
				return false;
			} else {
				alert('오류가 발생했습니다. \n잠시 후 다시 시도해 주세요.');
				console.log(result);
			}
		},
		error : function(err) {
			alert('오류가 발생했습니다. \n잠시 후 다시 시도해 주세요.');
			console.log(err);
		}
	});
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

	if(div == 'quiz' || div == 'vote') {
		$('.complete-vote').removeClass('block');
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

//레이어 우편번호
var element_layer = document.getElementById('post_layer');

function closeDaumPostcode() {
	element_layer.style.display = 'none';
}

function postSearchLayer() {
	new daum.Postcode({
		oncomplete: function(data) {
			var fullAddr = data.address; // 최종 주소 변수
			var extraAddr = ''; // 조합형 주소 변수
			var addressType = data.userSelectedType; // 주소타입(도로명/지번)
			var languageType = data.userLanguageType;

			// 기본 주소가 도로명 타입일때 조합한다.
			if(data.addressType === 'R'){
				//법정동명이 있을 경우 추가한다.
				if(data.bname !== ''){
					extraAddr += data.bname;
				}
				// 건물명이 있을 경우 추가한다.
				if(data.buildingName !== ''){
					extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
				}
				// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
				fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
			}

			var korAdd = addressType == "R" ? fullAddr : data.jibunAddress;
			var engAdd = addressType == "R" ? data.roadAddressEnglish : data.jibunAddressEnglish;

			// 우편번호와 주소 정보를 해당 필드에 넣는다.
			document.getElementById('zipcode').value = data.zonecode; //5자리 새우편번호 사용
			document.getElementById('address').value = languageType == "K" ? korAdd : engAdd;

			// iframe을 넣은 element를 안보이게 한다.
			// (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
			element_layer.style.display = 'none';
		},
		width : '100%',
		height : '100%',
		maxSuggestItems : 5
	}).embed(element_layer);

	// iframe을 넣은 element를 보이게 한다.
	element_layer.style.display = 'block';

	// iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
	//initLayerPosition();
}

function initLayerPosition() {
	var width = 400; //우편번호서비스가 들어갈 element의 width
	var height = 470; //우편번호서비스가 들어갈 element의 height
	var borderWidth = 1; //샘플에서 사용하는 border의 두께

	// 위에서 선언한 값들을 실제 element에 넣는다.
	element_layer.style.width = width + 'px';
	element_layer.style.height = height + 'px';
	element_layer.style.border = borderWidth + 'px solid';
	// 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
	element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
	element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 20 + 'px';
}