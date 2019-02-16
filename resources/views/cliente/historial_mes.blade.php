@extends('layouts.front')
@section('content')
<style>
  .btn {
    width: 100%;
  }
  .blanco {
    background-color: white;
  }
  body{ text-align: center }
  #visor_imagenes {
  text-align: center;
  }

  .blanco-rojo {
    color: black;
    background-color: white;
  }
</style>
<h2 id='visor_imagenes'><span class="blanco-rojo">{{$nombre_mes}}</span></h2>
<div class="row">
      <div class="col-lg-4 mb-4">
        <div class="card h-100">
          <h6 class="card-header text-white">GUARANIES TOTALES ACUMULADOS</h6>
          <div class="card-body">
            <p class="card-text">{{$puntos_acumulados[0]->r}} PUNTOS.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100">
          <h6 class="card-header text-white">DISCIPLINA</h6>
          <div class="card-body">
            <p class="card-text"> PUNTUALIDAD: {{$puntualidad[0]->r}}</p>
            <p class="card-text"> LLEGADAS TARDIAS: -{{$llegadas_tardias[0]->r}}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100">
          <h6 class="card-header text-white">PRODUCTIVIDAD</h6>
          <div class="card-body">
            <p class="card-text">{{$productividad[0]->r}} PUNTOS.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100">
          <h6 class="card-header text-white">BONO MENSUAL</h6>
          <div class="card-body">
            <p class="card-text">0 AUSENCIAS: {{$bono_mensual_ausencia[0]->r}}</p>
            <p class="card-text">0 APERCIBIMIENTOS Y SUSP: {{$bono_mensual_apercibimiento[0]->r}}</p>
          </div>
        </div>
      </div>
    </div>
@endsection