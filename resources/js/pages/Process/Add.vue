<template>
  <div class="">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Create Process</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <router-link class="btn btn-sm btn-outline-secondary" :to="{ name: 'categories'}">back to Categories</router-link>
            </div>
    </div>
    <div class="row">
      <div class="col-md-10">
        <form @submit.prevent="create">
          <div class="form-group">
            <label for="websites">Websites</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('website') }">
              <select id="websites" name="website" class="form-control" v-model="category.website_id" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('website') }">
                <option value="">Choose...</option>
                <option v-for="web in AllWebsites" :value="web.id">{{web.name}}</option>
              </select>
            </div>
            <div v-if="submitted && errors.has('website')" class="invalid-feedback">{{ errors.first('website') }}</div>
          </div>
          <div class="form-group">
            <label for="websites">Websites</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('website') }">
              <select id="websites" name="website" class="form-control" v-model="category.website_id" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('website') }">
                <option value="">Choose...</option>
                <option v-for="web in AllWebsites" :value="web.id">{{web.name}}</option>
              </select>
            </div>
            <div v-if="submitted && errors.has('website')" class="invalid-feedback">{{ errors.first('website') }}</div>
          </div>
          <div class="form-group">
            <label for="websites">Websites</label>
            <div class="" :class="{ 'has-danger': submitted && errors.has('website') }">
              <select id="websites" name="website" class="form-control" v-model="category.website_id" v-validate="'required'" :class="{ 'is-invalid': submitted && errors.has('website') }">
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
        category:{
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
    ...mapActions(["CreateCategory","GetAllWebsites"]),
    create(){
      this.loading=true;
      this.submitted=true;
      this.$validator.validate().then(valid => {
        if (valid) {
          this.CreateCategory(this.category).then(response => {
            this.loading=false;
            this.submitted = false;
            this.category = {};
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
  },
  created(){
    this.GetAllWebsites();
  }
}
</script>
