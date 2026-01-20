<?php

namespace App\Http\Controllers;

use App\Models\Clima;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class ClimaController extends Controller
{
    public function index()
    {
        $climas = Clima::latest()->get();
        return view('clima.index', compact('climas'));
    }

    public function buscar(Request $request, WeatherService $weatherService)
    {
        $request->validate([
            'ciudad' => 'required|string|min:2',
        ]);

        $ciudad = $request->ciudad;
        $userId = Auth::id() ?? 0;

        try {
            $data = Cache::remember(
                'clima_' . strtolower($ciudad),
                now()->addMinutes(10),
                function () use ($weatherService, $ciudad, $userId) {
                    return $weatherService->getByCity($ciudad, $userId);
                }
            );

            Clima::create([
                'ciudad' => $data['name'],
                'temperatura' => $data['main']['temp'],
                'humedad' => $data['main']['humidity'],
                'condicion_clima' => $data['weather'][0]['description'],
                'fecha_consulta' => now(),
            ]);

            return redirect()->back()->with('success', 'Clima consultado correctamente');

        } catch (Exception $e) {
  
            Log::error('Error al procesar clima', [
                'user_id' => $userId,
                'ciudad' => $ciudad,
                'error' => $e->getMessage(),
                'codigo_error' => $e->getCode(),
            ]);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $clima = Clima::findOrFail($id);
        $user = Auth::user();


        Log::info('Clima eliminado', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'clima_id' => $clima->id,
            'ciudad' => $clima->ciudad,
            'accion' => 'delete'
        ]);

        $clima->delete();

        return redirect()->back()->with('success', 'Clima eliminado correctamente.');
    }

    public function update($id, WeatherService $weatherService)
    {
        $clima = Clima::findOrFail($id);
        $user = Auth::user();

        try {
            $data = $weatherService->getByCity($clima->ciudad, $clima->user_id ?? 0);

            $clima->update([
                'temperatura' => $data['main']['temp'],
                'humedad' => $data['main']['humidity'],
                'condicion_clima' => $data['weather'][0]['description'],
                'fecha_consulta' => now(),
            ]);


            Log::info('Clima actualizado', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'clima_id' => $clima->id,
                'ciudad' => $clima->ciudad,
                'accion' => 'update'
            ]);

            return redirect()->back()->with('success', 'Clima actualizado correctamente');

        } catch (Exception $e) {
            Log::error('Error al actualizar clima', [
                'clima_id' => $clima->id,
                'ciudad' => $clima->ciudad,
                'error' => $e->getMessage(),
                'codigo_error' => $e->getCode(),
            ]);

            return redirect()->back()->with('error', 'No se pudo actualizar el clima.');
        }
    }
}