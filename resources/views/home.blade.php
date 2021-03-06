@extends('layouts.app')

@section('content')
    <v-container fluid>
        <v-layout row>
            <v-flex xs12 md12 lg12>
                @if (session('status'))
                    <v-alert :value="true" type="success" outline>{{ session('status') }}</v-alert>
                @endif
                <v-alert :value="true" type="info" outline>Benvingut a tasques!</v-alert>
            </v-flex>
            
        </v-layout>
    </container>
@endsection
