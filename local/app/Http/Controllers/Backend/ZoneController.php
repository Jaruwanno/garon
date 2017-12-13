<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Zone;

class ZoneController extends Controller
{
  public function index()
  {
    $zone = Zone::orderBy('length')->get();

    $aScript = array(
      'js/backend/category/js1.js'
    );

    return view('backend.category.zone', [
      'zone' => $zone,
      'js' => $aScript
    ]);
  }

  public function store(Request $request)
  {

    $zone = new Zone;

    $zone->length = $request->length;

    $zone->name = $request->name;

    $zone->save();

    return 'success';
  }

  public function update(Request $request, $id)
  {
    $zone = Zone::findOrFail($id);
    $zone->update($request->all());
    //Zone::where('id', $id)->update(['name' => $request->zone]);

    return 'success';
  }

  public function destroy($id){
    $zone = Zone::findOrFail($id);
    $zone->destroy($id);
    return 'success';
  }
}
