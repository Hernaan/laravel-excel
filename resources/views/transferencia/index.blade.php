@extends('layouts.front')
@section('content')
<div class="row">
  <div class="col-lg-12 mb-12">
      <div class="card h-100">
        <h6 class="card-header text-white">DESTINATARIO</h6>
        <div class="card-body">
          <p class="card-text">TOTAL DE CARSANIES: {{$puntos_acumulados[0]->r}} P</p>
          <form action="{{url('/transferencia/enviar')}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="number" name="monto" class="form-control" placeholder="TOTAL A TRANSFERIR" required>
            </div>
            <div class="form-group">
                <input type="number" name="cuenta" class="form-control" placeholder="CUENTA DESTINATARIO" required>
            </div>
                <input type="hidden" name="punto_acumulado" class="form-control" value="{{$puntos_acumulados[0]->r}}" required>
            <div class="form-group">
              <button type="submit" class="btn btn-info">CONFIRMAR TRANSFERENCIA</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection