<?php

namespace App\Http\Controllers;

use App\Clientes;
use Illuminate\Http\Request;
use Mail;
use Session;
use Redirect;
use App\Mail\SendMail;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Clientes::all();
        return $clientes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //devuelve una vista (formulario)
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clientes = Clientes::create($request->all());

        date_default_timezone_set('America/Lima');

        
        $email = $request['email'];
        $affair = $request['affair'];
        $fatherlastname = $request['fatherlastname'];
        $motherlastname = $request['motherlastname'];
        $names = $request['names'];
        $name = $request['name'];
        $hora = date('h:i:s A');
        $fecha = date('jS \of F Y');

        Mail::send('mail', [
                                'email' => $email, 
                                'affair' => $affair,
                                'name' => $name,
                                'fatherlastname' => $fatherlastname,
                                'motherlastname' => $motherlastname,
                                'names' => $names,
                                'hora' => $hora,
                                'fecha' => $fecha
                            ], 
                            function ($message) use($email, $affair, $name, $hora, $fecha, $names) {
                                $message->subject($affair);
                                $message->from($email, $name);
                                $message->to('brahimidiaz3@gmail.com');
                            }
        );

        Mail::send('mailresponse', [
                                'name' => $name,
                                'email' => $email, 
                                'fatherlastname' => $fatherlastname,
                                'motherlastname' => $motherlastname,
                                'hora' => $hora,
                                'fecha' => $fecha
                            ], 
                            function ($message) use($email, $name, $hora, $fecha, $fatherlastname, $motherlastname) {
                                $message->subject("Servicios");
                                $message->from('brahimidiaz3@gmail.com', "Tasty Food");
                                $message->to($email);
                            }
        );

        echo "Basic Email Sent. Check your inbox.";

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $clientes = Clientes::find($id);

        $clientes->name = $request->name;
        $clientes->fatherlastname = $request->fatherlastname;
        $clientes->motherlastname = $request->motherlastname;
        $clientes->email = $request->email;
        $clientes->affair = $request->affair;
        $clientes->names = $request->names;

        $clientes->update();

        return response()->json([
            'message' => 'Datos actualizados correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Clientes::destroy($id);
        return response()->json([
            'message' => 'Usuario eliminado correctamente !!'
        ]);
    }
}
