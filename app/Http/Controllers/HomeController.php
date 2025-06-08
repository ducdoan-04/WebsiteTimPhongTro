<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::with('user')
            ->where('is_available', true)
            ->latest()
            ->paginate(12);
            
        return view('home.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        return view('home.detail', compact('room'));
    }

    public function search(Request $request)
    {
        $query = Room::query()->with('user');

        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        if ($request->has('district')) {
            $query->where('district', $request->district);
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $rooms = $query->where('is_available', true)
            ->latest()
            ->paginate(12);

        return view('home.search', compact('rooms'));
    }
} 