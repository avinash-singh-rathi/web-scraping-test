<template>
  <div class="">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Websites</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <router-link class="btn btn-sm btn-outline-secondary mr-2" :to="{ name: 'AddWebsite'}"> Add Website</router-link>
              <div class="btn-group mr-2">
                <input type="text" v-model="searchinput" name="" value="">
                <button @click.prevent="search" class="btn btn-sm btn-outline-secondary">Search</button>
              </div>
            </div>
      </div>
      <div class="row">
        <div class="col-md-10">
          <div v-if="WebsitesData != undefined && WebsitesData.length > 0" class="">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Website</th>
                  <th scope="col">Url</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="web in WebsitesData">
                  <td>{{web.name}}</td>
                  <td>{{web.url}}</td>
                </tr>
              </tbody>
            </table>
            <div class="row">
              <div class="col-md-6">

              </div>
              <div class="col-md-6">
                <pagination :pagedata="websites" @clicked="GetWebsites"></pagination>
              </div>
            </div>

          </div>
          <div v-else class="">
            No websites to show. <router-link class="btn btn-sm btn-outline-secondary mr-2" :to="{ name: 'AddWebsite'}"> Create</router-link> one.
          </div>

        </div>
      </div>
  </div>
</template>

<script>
import { mapActions, mapGetters} from "vuex";
import loader from "../../components/loader"
import pagination from "../../components/pagination"
export default {
  data(){
    return {
      searchinput:'',
    }
  },
  components:{
    loader,
    pagination
  },
  computed:{
    ...mapGetters(["websites"]),
    WebsitesData(){
      return this.websites.data
    }
  },
  methods:{
    ...mapActions(["GetWebsites"]),
      search(e){
        //Action will go here
        this.GetWebsites('?search='+this.searchinput);
      },

  },
  created(){
      this.GetWebsites();
  }
}
</script>

<style lang="css" scoped>
</style>
