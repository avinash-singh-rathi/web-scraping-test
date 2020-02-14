import _ from 'lodash';
export default {
    setApiUrl(state, url) {
        state.configs.apiUrl = url;
    },
    setWebsites(state,data){
      state.websites=data;
    },
    SetCategories(state,data){
      state.categories=data;
    },
    setAllWebsites(state,data){
      state.AllWebsites=data;
    },
    SetProducts(state,data){
      state.products=data;
    },
    SetBrands(state,data){
      state.brands=data;
    },
    SetWBrands(state,data){
      state.wBrands=data;
    },
    SetWCategories(state,data){
      state.wCategories=data;
    },
    SetProcesses(state,data){
      state.processes=data;
    }
};
