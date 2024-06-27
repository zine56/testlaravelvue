<template>
    <v-app>
      <v-main>
        <v-container>
          <v-row class="mt-60">
            <!-- Columna para el formulario -->
            <v-col cols="12" md="4">
              <v-card>
                <v-card-title>Monto</v-card-title>
                <v-card-text>
                  <v-form @submit.prevent="handleSubmit">
                    <v-date-picker
                    v-model="date"
                    locale="es"
                ></v-date-picker>
                    <v-text-field
                      v-model="amount"
                      label="Monto"
                      type="number"
                      required
                    ></v-text-field>
                    <v-btn type="submit" color="primary">Agregar</v-btn>
                  </v-form>
                </v-card-text>
              </v-card>
            </v-col>
  
            <!-- Columna para el gráfico -->
            <v-col cols="12" md="8">
              <v-card>
                <v-card-title>Gráfico</v-card-title>
                <v-card-text>
                  <ChartComponent ref="chartComponent" />
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>

                    <!-- Modal de Error -->
            <v-dialog v-model="errorDialog" max-width="500px">
            <v-card>
                <v-card-title class="headline">Error</v-card-title>
                <v-card-text>{{ errorMessage }}</v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text @click="errorDialog = false">Cerrar</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
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
        date: new Date(),
        amount: '',
        errorDialog: false,
        errorMessage: ''
      };
    },
    methods: {
      handleSubmit() {
        axios.post('/data', { date: this.date, amount: this.amount })
          .then(response => {
            this.$refs.chartComponent.updateChart(response.data);
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
                const errors = error.response.data.errors;
                let errorMessage = 'Hubo un error. Por favor, inténtelo de nuevo.';
                if (errors.date) {
                  errorMessage = errors.date[0];
                } else if (errors.amount) {
                  errorMessage = errors.amount[0];
                }
                this.showErrorDialog(errorMessage);
            } else {
                this.showErrorDialog('Hubo un error. Por favor, inténtelo de nuevo.');
            }
          });
      },
      showErrorDialog(error) {
        this.errorMessage = error;
        this.errorDialog = true;
      },
      weekdayFormat(day) {
            const days = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
            return days[day];
        },
        monthFormat(month) {
            const months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            return months[month];
        },
        dayFormat(day) {
            return day;
        }
    }
  };
  </script>
  <style scoped>
  .mt-60 {
    margin-top: 60px;
  }
  </style>