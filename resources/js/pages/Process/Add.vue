<template>
  <div class="">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Create Process</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <router-link class="btn btn-sm btn-outline-secondary" :to="{ name: 'process'}">back to Crawl Processes</router-link>
            </div>
    </div>
    <div class="row">
      <div class="col-md-10">
        <form @submit.prevent="create">
          <div class="form-group">
            <label for="websites">Websites</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('website') }">
              <select id="websites" @change="ChangeType" name="website" class="form-control" v-model="process.website_id" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('website') }">
                <option value="">Choose...</option>
                <option v-for="web in AllWebsites" :value="web.id">{{web.name}}</option>
              </select>
            </div>
            <div v-if="submitted && errors.has('website')" class="invalid-feedback">{{ errors.first('website') }}</div>
          </div>
          <div class="form-group">
            <label for="type">Type</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('type') }">
              <select id="type" name="type" @change="ChangeType" class="form-control" v-model="process.type" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('type') }">
                <option value="">Choose...</option>
                <option value="1">Categories</option>
                <option value="2">Brands</option>
              </select>
            </div>
            <div v-if="submitted && errors.has('type')" class="invalid-feedback">{{ errors.first('type') }}</div>
          </div>
          <div v-if="process.website_id != '' && process.type == 2" class="form-group">
            <label for="brand">Brands</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('brand') }">
              <select id="brand" name="brand" class="form-control" v-model="process.brand_id" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('brand') }">
                <option value="">Choose...</option>
                <option v-for="web in AllBrands" :value="web.id">{{web.name}}</option>
              </select>
            </div>
            <div v-if="submitted && errors.has('brand')" class="invalid-feedback">{{ errors.first('brand') }}</div>
          </div>
          <div v-if="process.website_id != '' && process.type == 1" class="form-group">
            <label for="category">Categories</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('category') }">
              <select id="category" name="category" class="form-control" v-model="process.category_id" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('category') }">
                <option value="">Choose...</option>
                <option v-for="web in AllCategories" :value="web.id">{{web.name}}</option>
              </select>
            </div>
            <div v-if="submitted && errors.has('category')" class="invalid-feedback">{{ errors.first('category') }}</div>
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
        process:{
          website_id:'',
          type:'',
          category_id:'',
          brand_id:''
        }
      }
  },
  components:{
    loader
  },
  computed:{
    ...mapGetters(["allwebsites","wCategories","wBrands"]),
    AllWebsites(){
      return this.allwebsites.data;
    },
    AllCategories(){
      return this.wCategories.data;
    },
    AllBrands(){
      return this.wBrands.data;
    }
  },
  methods:{
    ...mapActions(["CreateProcess","GetAllWebsites", "GetBrandsByWebsite", "GetCategoriesByWebsite"]),
    ChangeType(){
      this.loading=true;
      this.process.category_id='';
      this.process.brand_id='';
      if(this.process.type != '' && this.process.website_id != ''){
        if(this.process.type == 1){
          this.GetCategoriesByWebsite(this.process.website_id);
        }

        if(this.process.type == 2){
          this.GetBrandsByWebsite(this.process.website_id);
        }
      }
      this.loading=false;
    },
    create(){
      this.loading=true;
      this.submitted=true;
      this.$validator.validate().then(valid => {
        if (valid) {
          this.CreateProcess(this.process).then(response => {
            this.loading=false;
            this.submitted = false;
            this.process.website_id = '';
            this.process.brand_id = '';
            this.process.category_id = '';
            this.process.type = '';
            this.$swal.fire(
                'Successful!',
                'Crawl Process initiated successfully!',
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
                'Unable to make crawl process!'+printData,
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
