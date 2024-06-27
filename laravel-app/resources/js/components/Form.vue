<template>
    <v-container>
      <v-form @submit.prevent="submitForm">
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
        <v-btn type="submit">Agregar</v-btn>
      </v-form>
    </v-container>
  </template>
  
  <script>
  export default {
    data() {
      return {
        date: '',
        amount: '',
      };
    },
    methods: {
      submitForm() {
        // Lógica para enviar datos al backend
      },
    },
  };
  </script>
  