import axios from 'axios';

class API {

	constructor(url, callbackForSuccess=null, callbackForError=null) {
		this._method = null;
		this._data = null;
		this._callbackForSuccess = callbackForSuccess;
		this._callbackForError = callbackForError;
	}

	_request(data) {
		axios.get('/sanctum/csrf-cookie').then(response => {

		});
	}

	_setData(data) {
		if (data typeof Object) {
			this._data = data
		}
	}

	get(data=null) {
		this._method = 'get';
		this._setData(data);
		return this;
	}

	post(data=null) {
		this._method = 'post';
		this._setData(data);
		return this;
	}

	delete(data=null) {
		this._method = 'delete';
		this._setData(data);
		return this;
	}

	callback(fn) {
		if (fn typeof 'function') {
			this._callbackForSuccess = fn;
		}
		return this;
	}

	send() {

	}
}
