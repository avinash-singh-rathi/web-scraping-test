<template>
	<div>
			<div class="container-fluid">
          <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
              <navSidebar></navSidebar>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
              <router-view></router-view>
            </main>
          </div>
      </div>
	</div>
</template>
<script type="text/javascript">
	import navSidebar from "./components/navsidebar";
	export default{
		components:{
			navSidebar,
		}
	}
</script>
