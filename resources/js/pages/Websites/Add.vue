<template>
<div class="">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Add Website</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <router-link class="btn btn-sm btn-outline-secondary" :to="{ name: 'websites'}">back to Websites</router-link>
          </div>
  </div>
  <div class="row">
    <div class="col-md-10">
      <form @submit.prevent="create">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="name">Website Name</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('name') }">
              <input type="text" class="form-control" v-model="website.name" id="name" name="name" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('name') }" placeholder="Enter Name">
            </div>
            <div v-if="submitted && errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
          </div>
          <div class="form-group col-md-6">
            <label for="url">Url</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('url') }">
                <input type="url" class="form-control" v-model="website.url" id="url" name="url" v-validate="'required|url'" :class="{ 'is-invalid': submitted && errors.has('url') }" placeholder="https://google.com">
            </div>
            <div v-if="submitted && errors.has('url')" class="invalid-feedback">{{ errors.first('url') }}</div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
      </form>
    </div>
  </div>
  <loader :showLoader="loading"></loader>
</div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import loader from "../../components/loader";
export default {
  data(){
      return {
        submitted:false,
        loading:false,
        website:{
          name:'',
          url:''
        }
      }
  },
  components:{
    loader
  },
  methods:{
    ...mapActions(["CreateWebsite"]),
    create(){
      this.loading=true;
      this.submitted=true;
      this.$validator.validate().then(valid => {
        if (valid) {
          this.CreateWebsite(this.website).then(response => {
            this.loading=false;
            this.submitted = false;
            this.website = {};
            this.$swal.fire(
                'Successful!',
                'Website created successfully!',
                'success'
            );
          }).catch(error =>{
            let printData='';
            if(error.data){
              printData ="<br /> Errors: <br />"
              printData=printData + Object.keys(error.data).map(key => `${key}: ${error.data[key]}`).join("<br />");
            }
            this.loading=false;
            this.submitted = false;
            this.$swal.fire(
                'Error!',
                'Unable to create website!'+printData,
                'error'
            );
          });
        }else{
          this.loading=false;
        }
      });
    }
  }
}
</script>
