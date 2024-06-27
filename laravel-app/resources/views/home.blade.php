@extends('layouts.vue-app')

@section('content')
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
            <div id="chartdiv" style="width: 100%; height: 400px;"></div>
          </v-container>
        </v-container>
      </v-main>
    </v-app>
@endsection
