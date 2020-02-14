<template>
  <div class="">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Products</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <input type="text" v-model="searchinput" name="" value="">
                <button @click.prevent="search" class="btn btn-sm btn-outline-secondary">Search</button>
              </div>
            </div>
      </div>
      <div class="row">
        <div class="col-md-10">
          <div v-if="ProductsData != undefined && ProductsData.length > 0" class="">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Price</th>
                  <th scope="col">MRP</th>
                  <th scope="col">Discount</th>
                  <th scope="col">Variants</th>
                  <th scope="col">QuoteOnly</th>
                  <th scope="col">Brand</th>
                  <th scope="col">MOQ</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="web in ProductsData">
                  <td><a :href="web.url" target="_blank">{{web.name}}</a></td>
                  <td>{{web.price}}</td>
                  <td>{{web.mrp}}</td>
                  <td>{{web.discount}}</td>
                  <td>{{web.isvariant | isQuote }}</td>
                  <td>{{web.ispricementioned | isQuote }}</td>
                  <td>{{web.brand}}</td>
                  <td>{{web.moq}}</td>
                </tr>
              </tbody>
            </table>
            <div class="row">
              <div class="col-md-6">

              </div>
              <div class="col-md-6">
                <pagination :pagedata="products" @clicked="GetProducts"></pagination>
              </div>
            </div>

          </div>
          <div v-else class="">
            No products to show.
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
  filters:{
    isQuote(value){
        return value ? 'Yes' : "No";
    }
  },
  components:{
    loader,
    pagination
  },
  computed:{
    ...mapGetters(["products"]),
    ProductsData(){
      return this.products.data
    }
  },
  methods:{
    ...mapActions(["GetProducts"]),
      search(e){
        //Action will go here
        this.GetProducts('?search='+this.searchinput);
      },

  },
  created(){
      this.GetProducts();
  }
}
</script>

<style lang="css" scoped>
</style>
