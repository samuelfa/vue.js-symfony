<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Create a new product</h4>
    </div>
    <div class="card-body">
        <b-alert v-model="showDismissibleAlert" variant="danger" dismissible>
          {{ this.errorMessage }}
        </b-alert>
        <b-form @submit="onSubmit" @reset="onReset" v-if="show">
          <b-form-group
            id="input-group-1"
            label="Reference:"
            label-for="reference"
            description="Pattern 00-AAAAAAAA."
          >
            <b-form-input
              id="reference"
              v-model.trim="form.reference"
              required
              placeholder="Enter reference"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-2" label="Name:" label-for="input-2">
            <b-form-input
              id="input-2"
              v-model.trim="form.name"
              required
              placeholder="Enter name"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-3" label="Money:" label-for="input-3">
            <b-form-input
              id="money"
              v-model.number="form.money"
              step="0.01"
              type="number"
              required
              placeholder="Enter money"
              min="0.01"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-4" label="Currency:" label-for="input-4">
            <b-form-select
              id="currency"
              v-model="form.currency"
              :options="currencies"
              required
            ></b-form-select>
          </b-form-group>

          <b-form-group id="input-group-5" label="Stock:" label-for="input-5">
            <b-form-input
              id="stock"
              v-model.number="form.stock"
              type="number"
              required
              placeholder="Enter stock"
              min="0"
            ></b-form-input>
          </b-form-group>

          <b-button type="submit" variant="primary">Create</b-button>
          <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
    </div>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    data() {
      return {
        form: {
          reference: '',
          name: '',
          money: 0.0,
          currency: 'EUR',
          stock: 0
        },
        currencies: [{ text: 'Select One', value: null }, { text: 'Euro', value: 'EUR' }, { text: 'Dollar', value: 'USD' }],
        show: true,
        endpoint: 'http://localhost/product',
        showDismissibleAlert: false,
        errorMessage: ''
      }
    },
    methods: {
      onSubmit(event) {
        event.preventDefault()

        let self = this;

        axios.put(this.endpoint, this.form)
          .then(() => {
            self.$router.push('/');
          })
          .catch(error => {
            self.errorMessage = error.response.data.message;
            self.showDismissibleAlert = true;
          })
      },

      onReset(event) {
        event.preventDefault()

        this.form = this.newFormValues();

        this.show = false;
        this.$nextTick(() => {
          this.show = true;
        })
      },

      newFormValues() {
        return {
          reference: '',
          name: '',
          money: 0.0,
          currency: 'EUR',
          stock: 0
        }
      }
    }
  }
</script>
