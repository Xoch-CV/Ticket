@extends('layouts.layoutMain')

@section('content')

    <div class="row detalle">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
         <img src="/storage/imagenesevento/{{$event->image}}" alt="Foto">
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h4>{{$event->name}}</h4>
            @if ($event->category)
            <p>Categoria del evento <b>{{$event->category->name}}</b></p>
            <p>Desripcion: {{$event->description}}</p>
            <p>Día del evento: <b>{{\Carbon\Carbon::parse($event->initial_date)->locale('es')->isoFormat("LL")}}</b></p>
            <p>Precio Ticket: <b>{{$event->price}}</b></p>
            @endif

            @if (Route::has('login'))
            @auth
            @if (Auth::user()->role==1)
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                    <form class="" action="/events/{{$event->id}}/edit" method="get">
                    <input type="hidden" name="id" value="{{$event->id}}">
                    <input class="button2" type="submit" name="" value="Editar Evento">
                    </form>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                    <form class="" action="/events/{{$event->id}}" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id" value="{{$event->id}}">
                    <input class="button3" type="submit" name="" value="Borrar Evento">
                    </form>
                </div>
            </div>
            @else
            <div class="row">
                <form action="/compra/{{$event->id}}" method="post">
                @csrf
                <div class="">
              <label for="quantity"><b>Cantidad tickets</b></label>
              <select name="quantity">
              @for ($i = 0; $i <= 10; $i++)
              <option value="{{$i}}">{{ $i }}</option>
              @endfor

              </select>
            </div>
            <div class="row">
              <div class="col-12 col-sm-12 col-md-4 col-lg-6">
                <input type="submit" value='Agregar al carrito' class="button2" name='add'>
              </div>
            </form>
              <div class="col-12 col-sm-12 col-md-4 col-lg-6">
              {{--<a href="{{ url('/') }}">Ver más eventos</a>--}}
                <a class="button3" href="{{ url('/') }}">Ver más eventos</a>
              </div>
            </div>

            </div>
            @endif
            @else
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
          <a class="button" href="{{ route('login') }}">
          comprar entrada</a>
          </div>
            @endauth
            @endif
        </div>
    </div>

@endsection
