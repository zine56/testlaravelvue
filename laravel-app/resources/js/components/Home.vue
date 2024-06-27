<template>
    <v-app>
      <v-main>
        <v-container>
          <v-form @submit.prevent="handleSubmit">
            <v-text-field
              v-model="date"
              label="Fecha"
              type="date"
              required
            ></v-text-field>
            <v-text-field
              v-model="amount"
              label="Monto"
              type="number"
              required
            ></v-text-field>
            <v-btn type="submit" color="primary">Submit</v-btn>
          </v-form>
          <v-container>
            <ChartComponent ref="chartComponent" />
          </v-container>
        </v-container>
      </v-main>
    </v-app>
  </template>
  
  <script>
  import axios from 'axios';
  import ChartComponent from './Chart.vue';
  
  export default {
    components: {
      ChartComponent
    },
    data() {
      return {
        date: '',
        amount: ''
      };
    },
    methods: {
      handleSubmit() {
        axios.post('/data', { date: this.date, amount: this.amount })
          .then(response => {
                this.$refs.chartComponent.updateChart();
          })
          .catch(error => {
            console.error(error);
          });
      }
    }
  };
  </script>
  