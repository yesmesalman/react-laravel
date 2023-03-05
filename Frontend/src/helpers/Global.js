class Global {

    static APP_URL = "http://127.0.0.1:8000/api";

    static netowrkRequest(path, formData, token = false) {
        formData.append("_DEFAULT_", 0);

        const header = {}
        if (token) {
            let authToken = Global.getDataFromLocalStorage("token")
            if (!authToken) return
            header.Authorization = `Bearer ${authToken}`
        }

        const requestOptions = {
            method: 'POST',
            headers: header,
            body: formData,
        };

        return fetch(`${Global.APP_URL}/${path}`, requestOptions);
    }

    static saveDataInLocalStorage(key, data) {
        localStorage.setItem(key, data);
    }

    static getDataFromLocalStorage(key) {
        return localStorage.getItem(key);
    }

    static isAuthenticated() {
        return localStorage.getItem('token') ? true : false;
    }
}


export default Global;