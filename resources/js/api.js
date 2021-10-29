import axios from 'axios'
axios.defaults.baseURL = 'api/admin'
const api = {
  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  get: (url, params) => {
    return new Promise((resolve, reject) => {
      axios.get(url, {
        params: params
      })
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          alert(error.response.data.message)
          reject(error)
        })
    })
  },

  post: (url, params) => {
    return new Promise((resolve, reject) => {
      axios.post(url, params)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          alert(error.response.data.message)
          reject(error)
        })
    })
  },

  put: (url, params) => {
    return new Promise((resolve, reject) => {
      axios.put(url, params)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          alert(error.response.data.message)
          reject(error)
        })
    })
  },

  delete: (url, params) => {
    return new Promise((resolve, reject) => {
      axios.delete(url)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          alert(error.response.data.message)
          reject(error)
        })
    })
  },
  
  patch: (url, params) => {
    return new Promise((resolve, reject) => {
      axios.patch(url, params)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          alert(error.response.data.message)
          reject(error)
        })
    })
  }

}
export default api