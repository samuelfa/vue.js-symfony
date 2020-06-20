<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">List of products</h4>
      <p class="card-category">Here you can see a detailed list of products</p>
    </div>
    <div class="card-body">
      <b-alert v-model="showSuccessAlert" variant="success" dismissible>{{ this.successMessage }}</b-alert>
      <b-alert v-model="showErrorAlert" variant="danger" dismissible>
        {{ this.errorMessage }}
      </b-alert>

      <table class="table table-hover table-striped">
        <thead>
          <th>Reference</th>
          <th>Name</th>
          <th>Money</th>
          <th>Currency</th>
          <th>Stock</th>
          <th>-</th>
        </thead>
        <tbody>
          <tr v-for="product in products">
            <td>{{ product.reference }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.price.value }}</td>
            <td>{{ product.price.currency }}</td>
            <td>{{ product.stock }}</td>
            <td><a v-on:click="removeProduct(product)"><b-icon-trash></b-icon-trash></a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    data () {
      return {
        products: [],
        endpoint: 'http://localhost/product/list',
        endpoint_delete: 'http://localhost/product',
        showErrorAlert: false,
        errorMessage: '',
        showSuccessAlert: false,
        successMessage: ''
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
      },

      removeProduct(product) {
        if(!confirm('Are you sure?')){
          return;
        }

        let self = this;

        axios.delete(this.endpoint_delete + '/' + product.reference)
          .then(() => {
            let index = self.products.indexOf(product);
            self.$delete(self.products, index);
            self.successMessage = 'Product deleted!';
            self.showSuccessAlert = true;
          })
          .catch(error => {
            console.log(error);
            self.errorMessage = error.response.data.message;
            self.showDismissibleAlert = true;
          })
      }
    }
  }
</script>
