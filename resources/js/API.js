import axios from 'axios';

export default class API {

	constructor(url) {
		this._url = url;
		this._method = null;
		this._data = null;
		this._callbacksForSuccess = [];
		this._callbacksForError = [];
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
			this._callbacksForSuccess.push(fn);
		}
		return this;
	}

	fail(fn) {
		if (fn typeof 'function') {
			this._callbacksForError.push(fn);
		}
		return this;
	}

	send() {
		axios.get('/sanctum/csrf-cookie').then(() => {
			axios[this._method](this._url, this._data)
				.catch(error => {
					this._callbacksForError.forEach(fn => {
						fn(error);
					})
				})
				.then(response => {
					this._callbacksForSuccess.forEach(fn => {
						fn(response);
					})
				});
		});
	}
}
