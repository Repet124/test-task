import './bootstrap';

let password = document.getElementById('inputPassword1'),
	passwordConfirm = document.getElementById('inputConfirmPassword1'),
	confirmInfo = document.getElementById('confirmInfoJS'),
	btn = document.getElementById('btnSubmitJS');

function confirm() {
	btn.disabled = (!password.value) || (password.value !== passwordConfirm.value);
	if (btn.disabled && passwordConfirm.value) {
		confirmInfo.classList.remove('d-none')
	}else {
		confirmInfo.classList.add('d-none')
	}
}

if (passwordConfirm) {
	btn.disabled = true;
	passwordConfirm.addEventListener('input', confirm);
	password.addEventListener('input', confirm);
}
