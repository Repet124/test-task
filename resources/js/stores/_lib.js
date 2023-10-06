import axios from 'axios'

function toAPI(method, url, resolveCallback = null, data = null) {
	return new Promise((resolve, reject) => {
		axios.get('/sanctum/csrf-cookie').then(() => {
			let instance = axios.create({
				validateStatus: function (status) {
					return status < 300; // Resolve only if the status code is less than 300
				}
			});
			instance[method](url, data)
				.then(response => {
					console.log(response)
					resolveCallback(response);
					resolve(response);
				}).catch(error => {
					reject(error)
				});
		});
	})
}

export { toAPI }
