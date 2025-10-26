<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $chirps = Chirp::with( 'user' )
            ->latest()
            ->take( 50 )
            ->get();

        return view( 'home', [ 'chirps' => $chirps ] );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {
        $request->validate( [
                                'message' => 'required|string|max:255|min:5',
                            ] );

        Chirp::create( [
                           'message' => $request->input( 'message' ),
                       ] );

        return redirect( '/' )->with( 'success', 'Chirp created successfully!' );
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Chirp $chirp ) {
        return view( 'chirps.edit', compact( 'chirp' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, Chirp $chirp ) {
        $validated = $request->validate( [
                                             'message' => 'required|string|max:255|min:5',
                                         ] );

        $chirp->update( $validated );

        return redirect( '/' )->with( 'success', 'Chirp updated successfully!' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Chirp $chirp ) {
//        $this->authorize( 'delete', $chirp );

        $chirp->delete();

        return redirect( '/' )->with( 'success', 'Chirp deleted successfully!' );
    }
}
