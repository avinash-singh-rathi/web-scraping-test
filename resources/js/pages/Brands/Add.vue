<template>
  <div class="">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Add Brand</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <router-link class="btn btn-sm btn-outline-secondary" :to="{ name: 'brands'}">back to Brands</router-link>
            </div>
    </div>
    <div class="row">
      <div class="col-md-10">
        <form @submit.prevent="create">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">Brand Name</label>
              <div class="" :class="{ 'has-danger': submitted && errors.has('name') }">
                <input type="text" class="form-control" v-model="brand.name" id="name" name="name" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('name') }" placeholder="Enter Name">
              </div>
              <div v-if="submitted && errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
            </div>
            <div class="form-group col-md-6">
              <label for="url">Url</label>
              <div class="" :class="{ 'has-danger': submitted && errors.has('url') }">
                  <input type="url" class="form-control" v-model="brand.url" id="url" name="url" v-validate="'required|url'" :class="{ 'is-invalid': submitted && errors.has('url') }" placeholder="https://google.com">
              </div>
              <div v-if="submitted && errors.has('url')" class="invalid-feedback">{{ errors.first('url') }}</div>
            </div>
          </div>
          <div class="form-group">
            <label for="websites">Websites</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('website') }">
              <select id="websites" name="website" class="form-control" v-model="brand.website_id" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('website') }">
                <option value="">Choose...</option>
                <option v-for="web in AllWebsites" :value="web.id">{{web.name}}</option>
              </select>
            </div>
            <div v-if="submitted && errors.has('website')" class="invalid-feedback">{{ errors.first('website') }}</div>
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
        brand:{
          name:'',
          url:'',
          website_id:'',
        }
      }
  },
  components:{
    loader
  },
  computed:{
    ...mapGetters(["allwebsites"]),
    AllWebsites(){
      return this.allwebsites.data;
    }
  },
  methods:{
    ...mapActions(["CreateBrand","GetAllWebsites"]),
    create(){
      this.loading=true;
      this.submitted=true;
      this.$validator.validate().then(valid => {
        if (valid) {
          this.CreateBrand(this.brand).then(response => {
            this.loading=false;
            this.submitted = false;
            this.brand = {};
            this.$swal.fire(
                'Successful!',
                'Brand created successfully!',
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
                'Unable to create brand!'+printData,
                'error'
            );
          });
        }else{
          this.loading=false;
        }
      });
    }
  },
  created(){
    this.GetAllWebsites();
  }
}
</script>
