export default {

    //Function to get websites and search query too
    GetWebsites({ commit, getters },value=''){
        return new Promise((resolve, reject) => {
            Vue.http.get(getters.apiUrl+'websites'+value).then(
                        function (response) {
                            commit('setWebsites', response.data)
                            resolve(response);
                        }, function (error) {
                            reject(error);
                        });
            });
    },

    //Function to get All websites
    GetAllWebsites({ commit, getters },value=''){
        return new Promise((resolve, reject) => {
            Vue.http.get(getters.apiUrl+'websites/all').then(
                        function (response) {
                            commit('setAllWebsites', response.data)
                            resolve(response);
                        }, function (error) {
                            reject(error);
                        });
            });
    },

    //Create Webite
    CreateWebsite({commit, getters},form){
      return new Promise((resolve, reject) => {
          Vue.http.post(getters.apiUrl+'websites',form).then(
                      function (response) {
                          //commit('setWebsites', response.data)
                          resolve(response.data);
                      }, function (error) {
                          reject(error);
                      });
        });
    },

    //Function to get categories and search query too
    GetCategories({ commit, getters },value=''){
        return new Promise((resolve, reject) => {
            Vue.http.get(getters.apiUrl+'category'+value).then(
                        function (response) {
                            commit('SetCategories', response.data)
                            resolve(response);
                        }, function (error) {
                            reject(error);
                        });
            });
    },

    //Create Webite
    CreateCategory({commit, getters},form){
      return new Promise((resolve, reject) => {
          Vue.http.post(getters.apiUrl+'category',form).then(
                      function (response) {
                          //commit('setWebsites', response.data)
                          resolve(response.data);
                      }, function (error) {
                          reject(error);
                      });
        });
    },

    //Function to get Products
    GetProducts({ commit, getters },value=''){
        return new Promise((resolve, reject) => {
            Vue.http.get(getters.apiUrl+'products'+value).then(
                        function (response) {
                            commit('SetProducts', response.data)
                            resolve(response);
                        }, function (error) {
                            reject(error);
                        });
            });
    },

    //Function to get brands and search query too
    GetBrands({ commit, getters },value=''){
        return new Promise((resolve, reject) => {
            Vue.http.get(getters.apiUrl+'brands'+value).then(
                        function (response) {
                            commit('SetBrands', response.data)
                            resolve(response);
                        }, function (error) {
                            reject(error);
                        });
            });
    },

    //Create Brand
    CreateBrand({commit, getters},form){
      return new Promise((resolve, reject) => {
          Vue.http.post(getters.apiUrl+'brands',form).then(
                      function (response) {
                          //commit('setWebsites', response.data)
                          resolve(response.data);
                      }, function (error) {
                          reject(error);
                      });
        });
    },

    //Function to get brands by the website
    GetBrandsByWebsite({ commit, getters },value=''){
        return new Promise((resolve, reject) => {
            Vue.http.get(getters.apiUrl+'brands/'+value+'/website').then(
                        function (response) {
                            commit('SetWBrands', response.data)
                            resolve(response);
                        }, function (error) {
                            reject(error);
                        });
            });
    },

    //Function to get categories by website
    GetCategoriesByWebsite({ commit, getters },value=''){
        return new Promise((resolve, reject) => {
            Vue.http.get(getters.apiUrl+'categories/'+value+'/website').then(
                        function (response) {
                            commit('SetWCategories', response.data)
                            resolve(response);
                        }, function (error) {
                            reject(error);
                        });
            });
    },


};
