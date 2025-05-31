<?php

namespace App\Http\Controllers;

use App\Models\Favorite; // Make sure this model exists and relates to Toilet
use App\Models\User; // Ensure User model is imported for Auth
use App\Models\Toilet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the user's favorite toilets.
     */
    public function index()
    {
        // Fetch favorites for the authenticated user and eagerly load the 'toilet' relationship
        $favorites = Auth::user()->favorites()->with('toilet')->get();
        $favorites = Auth::user()->favorites()->with(['toilet' => function($query) {
            $query->withAvg('reviews', 'rating'); // Add this to get average rating
        }])->get();

        // Pass the 'toilet' objects directly to the view for easier iteration
        // You might need to adjust the data structure for 'facilities' and 'access'
        // if they are stored as JSON strings in the database, e.g., by casting them
        // in your Toilet model or decoding them here.
        $favoriteToilets = $favorites->map(function ($favorite) {
            $toilet = $favorite->toilet;
            $toilet->rating = $toilet->reviews_avg_rating ?? 0;
            // Ensure facilities and access are arrays for JS consumption in the modal
            $toilet->facilities = is_array($toilet->facilities) 
            ? $toilet->facilities 
            : (is_string($toilet->facilities) ? json_decode($toilet->facilities, true) : []);
            
            $toilet->access = is_array($toilet->access) 
            ? $toilet->access 
            : (is_string($toilet->access) ? json_decode($toilet->access, true) : []);
            // Add a placeholder distance if not available or calculate actual distance
            // For example purposes, we'll just put 'N/A'
            $toilet->distance = 'N/A';
            $toilet->is_favorite = true; // On this page, they are all favorites

            return $toilet;
        });

        // The view expects a variable named 'favoriteToilets'
        return view('favorites', compact('favoriteToilets'));
    }

    /**
     * Toggles the favorite status for a given toilet.
     * Adds to favorites if not already, removes if it is.
     */
    public function toggle(Request $request, Toilet $toilet)
    {
        $user = Auth::user();

        // Check if the user has already favorited this toilet
        $favorite = $user->favorites()->where('toilet_id', $toilet->id)->first();

        if ($favorite) {
            // If it exists, remove it from favorites
            $favorite->delete();
            return response()->json([
                'success' => true,
                'message' => 'Toilet removed from favorites.',
                'is_favorite' => false
            ]);
        } else {
            // If it doesn't exist, add it to favorites
            $user->favorites()->create(['toilet_id' => $toilet->id]);
            return response()->json([
                'success' => true,
                'message' => 'Toilet added to favorites.',
                'is_favorite' => true
            ]);
        }
    }

    /**
     * Remove the specified favorite from storage.
     * This method seems to be for direct deletion of a Favorite record,
     * perhaps from an admin panel or a specific list.
     * The `toggle` method is generally preferred for user-facing favorite buttons.
     */
    public function destroy(Favorite $favorite)
    {
        // Authorize the action using a policy (assuming you have one, e.g., FavoritePolicy)
        // Ensure that only the owner of the favorite can delete it.
        $this->authorize('delete', $favorite);

        $favorite->delete();

        return back()->with('success', 'Removed from favorites.');
    }
}