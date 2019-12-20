<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Auth;

class EventsController extends Controller
{
    public function start(){
        if (Auth::user()->role==1){
        return redirect ('/events');
        }
        return redirect ('/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('q')){
          $events = Event::where('name', 'like', '%' . $request->get('q') . '%')
            ->paginate(10)
            ->appends($request ->only('q'));
        }
        else{
          $events = Event::paginate(10)->appends($request->only('q'));
        }
        return view("listado")->with("events", $events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Event::class);
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
          "name" => "required|string|min:1|max:255",
          "description" => "required|string|min:1|max:255",
          "initial_date" => "required|date",
          "ending_date" =>"required|date",
          "price"=> "required|numeric",
          "category_id"=>"required|numeric",
          "image" => "file",
        ];
        $mensaje = [
          "required" => "El campo :attribute es obligatorio.",
          "min" => "El campo :attribute no puede ser menor a :min.",
          "max" => "El campo :attribute no debe mayor a :max.",
          "numeric" => "El campo :attribute debe ser numérico.",
          "integer" => "El campo :attribute debe ser entero.",
          "date" => "El campo :attribute debe ser una fecha."
        ];

        $this->validate($request, $reglas, $mensaje);
        $eventoNuevo = new Event();

        $ruta = $request->file("image")->store("public/imagenesevento");
        $nombreArchivo = basename($ruta);

        $eventoNuevo->image=$nombreArchivo;
        $eventoNuevo->name=$request["name"];
        $eventoNuevo->description=$request["description"];
        $eventoNuevo->initial_date=$request["initial_date"];
        $eventoNuevo->ending_date=$request["ending_date"];
        $eventoNuevo->price=$request["price"];
        $eventoNuevo->category_id=$request["category_id"];
        $eventoNuevo->user_id=1;

        $eventoNuevo->save();

        return view('/detalle')->with("event", $eventoNuevo);

        /*Event::create($request->all());*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
      //$this->authorize('edit', $event);
      return view("detalle")->with("event", $event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
      $this->authorize('edit', $event);
        return view('events.edit')->with("event", $event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idevent)
    {
      $reglas = [
        "name" => "required|string|min:1|max:255",
        "description" => "required|string|min:1|max:255",
        "initial_date" => "required|date",
        "ending_date" =>"required|date",
        "price"=> "required|numeric",
        "category_id"=>"required|integer|min:1|max:5",
        "image" => "file",
      ];
      $mensaje = [
        "required" => "El campo :attribute es obligatorio.",
        "min" => "El campo :attribute no puede ser menor a :min.",
        "max" => "El campo :attribute no debe mayor a :max.",
        "numeric" => "El campo :attribute debe ser numérico.",
        "integer" => "El campo :attribute debe ser entero.",
        "date" => "El campo :attribute debe ser una fecha."
      ];

      $this->validate($request, $reglas, $mensaje);
      $eventoObjeto = new Event();

      $ruta = $request->file("image")->store("public/imagenesevento");
      $nombreArchivo = basename($ruta);

      $eventoObjeto->image=$nombreArchivo;
      $eventoObjeto->name=$request["name"];
      $eventoObjeto->description=$request["description"];
      $eventoObjeto->initial_date=$request["initial_date"];
      $eventoObjeto->ending_date=$request["ending_date"];
      $eventoObjeto->price=$request["price"];
      $eventoObjeto->category_id=$request["category_id"];
      $eventoObjeto->user_id=1;

    $eventoArray = $eventoObjeto->toArray();

        Event::find($idevent)->update($eventoArray);
        return view('/detalle')->with("event", $eventoObjeto);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
      $events=Event::find($req->get('id'));
      $this->authorize('destroy', $events);
      $events->delete();
      return redirect('/events');
    }
    }
