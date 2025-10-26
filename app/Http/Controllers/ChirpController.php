<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ChirpController extends Controller {
    use AuthorizesRequests;

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
        $validated = $request->validate( [
                                             'message' => 'required|string|max:255',
                                         ] );

        // Use the authenticated user
        auth()->user()->chirps()->create( $validated );

        return redirect( '/' )->with( 'success', 'Your chirp has been posted!' );

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
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view( 'chirps.edit', compact( 'chirp' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, Chirp $chirp ) {
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

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
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $chirp->delete();

        return redirect( '/' )->with( 'success', 'Chirp deleted successfully!' );
    }
}
