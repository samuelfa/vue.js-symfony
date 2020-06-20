<template>
  <div>
    <div v-for="product in products">
      {{ product.name }}
    </div>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    data () {
      return {
        products: [],
        endpoint: 'http://flat101.localhost/product/list',
      }
    },

    created() {
      this.getAllProducts();
    },

    methods: {
      getAllProducts() {
        axios.get(this.endpoint)
          .then(response => {
            this.products = response.data;
          })
          .catch(error => {
            console.log('-----error------')
            console.log(error)
          })
      }
    }
  }
</script>
