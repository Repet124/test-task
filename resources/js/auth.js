import './bootstrap';

let password = document.getElementById('inputPassword1'),
	passwordConfirm = document.getElementById('inputConfirmPassword1'),
	btn = document.getElementById('btnSubmitJS');

function confirm() {
	btn.disabled = (!password.value) || (password.value !== passwordConfirm.value);
}

if (passwordConfirm) {
	btn.disabled = true;
	passwordConfirm.addEventListener('input', confirm);
	password.addEventListener('input', confirm);
}
