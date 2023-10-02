import axios from 'axios';

class API {

	constructor() {
		this._url = null;
		this._method = null;
		this._data = null;
		this._callbacksForSuccess = [];
		this._callbacksForError = [];
	}

	_setData(data) {
		if (typeof data === 'object') {
			this._data = data
		}
	}

	_registration(method, url, data) {
		this._url = url;
		this._method = 'get';
		this._setData(data);
	}

	get(url, data=null) {
		this._registration('get', ...arguments);
		return this;
	}

	post(url, data=null) {
		this._registration('post', ...arguments);
		return this;
	}

	delete(url, data=null) {
		this._registration('delete', ...arguments);
		return this;
	}

	then(fn) {
		if (typeof fn === 'function') {
			this._callbacksForSuccess.push(fn);
		}
		return this;
	}

	catch(fn) {
		if (typeof fn === 'function') {
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
export default API;
