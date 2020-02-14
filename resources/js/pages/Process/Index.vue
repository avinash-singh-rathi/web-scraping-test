<template>
  <div class="">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Crawl Processes</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <router-link class="btn btn-sm btn-outline-secondary mr-2" :to="{ name: 'AddProcess'}"> Add Process</router-link>
              <div class="btn-group mr-2">
                <input type="text" v-model="searchinput" name="" value="">
                <button @click.prevent="search" class="btn btn-sm btn-outline-secondary">Search</button>
              </div>
            </div>
      </div>
      <div class="row">
        <div class="col-md-10">
          <div v-if="ProcessesData != undefined && ProcessesData.length > 0" class="">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Link</th>
                  <th scope="col">Total Products</th>
                  <th scope="col">Total Pages</th>
                  <th scope="col">Processed Pages</th>
                  <th scope="col">Products Per Page</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="proc in ProcessesData">
                  <td>{{proc.url}}</td>
                  <td>{{proc.totalitems}}</td>
                  <td>{{proc.totalpages}}</td>
                  <td>{{proc.processedpages}}</td>
                  <td>{{proc.totalitemsperpage}}</td>
                  <td>{{proc.status}}</td>
                </tr>
              </tbody>
            </table>
            <div class="row">
              <div class="col-md-6">

              </div>
              <div class="col-md-6">
                <pagination :pagedata="processes" @clicked="GetProcesses"></pagination>
              </div>
            </div>

          </div>
          <div v-else class="">
            No Processes to show. <router-link class="btn btn-sm btn-outline-secondary mr-2" :to="{ name: 'AddProcess'}"> Create</router-link> one.
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
    ...mapGetters(["processes"]),
    ProcessesData(){
      return this.processes.data
    }
  },
  methods:{
    ...mapActions(["GetProcesses"]),
      search(e){
        //Action will go here
        this.GetCategories('?search='+this.searchinput);
      },

  },
  created(){
      this.GetProcesses();
  }
}
</script>
