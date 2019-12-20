@extends('layouts.layoutMain')
@section('content')

<div class="col-8 buscador">
  <div class="row">
    <form class="" action="/events" method="get" style="width:100%; align:center">
      <div class="inputWithIcon col-12 col-sm-12 col-md-8 col-lg-9" >
        <input type="text" name="q" value="{{request('q')}}" placeholder="Qué querés ir a ver...">
          <i class="fa fa-search fa-lg fa-fw" aria-hidden="true"></i>
      </div>
      <div class="col-12 col-sm-12 col-md-4 col-lg-3 boton">
        <input type="submit" value='Buscar' class="button"></input>
      </div>
    </form>
  </div>
</div>

    <section>
      <div class="divisor col-6 col-lg-2">
      </div>
      <h4>{{ isset($category) ? $category->name : 'Todas las categorias'}}</h4>

      <div class="row busqueda">
      @foreach ($events as $event)

      <div class="col-12 col-sm-10 col-md-6 col-lg-3 listado">
        <div class="card">

          <div class="contenedor">
            <img src="storage/imagenesevento/{{$event->image}}" alt="Foto">

          </div>


          <div class="card-body">
            <h3 class="card-title">{{ $event->name }}</h3>
            <p>Día: <b>{{\Carbon\Carbon::parse($event->initial_date)->locale('es')->isoFormat("LL")}}</b></p>
            <p>Precio unitario: <b>$ {{ $event->price }}</b></p>
            <a href="/events/{{$event->id}}" class="btn-cards"><i class="fas fa-search-plus fa-2x"></i></a>
          </div>

        </div>
      </div>

  @endforeach
</div>

@if (Route::has('login'))
@auth
@if (Auth::user()->role==1)
            <div class="row detalle">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 crear">
                    <form class="" action="/events/new" method="get">
                    <input type="hidden" name="id" value="">
                    <input class="button2" type="submit" name="" value="Crear Evento">
                    </form>
                </div>
            </div>
          @else
          <div class="col-6 col-sm-6 col-md-6 col-lg-3">
        <a class="button" href="{{ route('login') }}">
        comprar entrada</a>
        </div>
        @endif
          @endauth
          @endif

    </section>



@endsection
