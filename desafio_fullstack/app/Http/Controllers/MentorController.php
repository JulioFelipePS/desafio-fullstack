<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{

            $params = collect($request->query());
            $query = Mentor::query();

            if($params->get('name') !== null){
                $query->where('name','LIKE',"%{$params->get('name')}%");
            }
            $mentores = $query->paginate(3);
            return response()->json(['success' => true, 'data' => $mentores],200);
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'email' => 'required',
                    'cpf' => 'required',
                    'name' => 'required'
                ],
                [
                    'required' => 'O campo :attribute é obrigatório.'
                ]
            );
            $mentor = Mentor::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'cpf'=>$request->cpf
            ]);
           
            return response()->json(['success' => true, 'msg' => 'Mentor cadastrado com sucesso!', 'data' => $mentor],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Mentor $mentor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $cpf)
    {
        try {
            $mentor =Mentor::where('cpf', $cpf)->get();
            if ($request->has('name')) {
                $mentor->name = $request->name;
            }
            if ($request->has('email')) {
                $mentor->surname = $request->email;
            }
            $mentor->save();
            return response()->json(['success' => true, 'msg' => 'Mentor alterado com sucesso!', 'data' => $mentor],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cpf)
    {
        
        try {
            $mentor =Mentor::where('cpf', $cpf)->get();
            $mentor->delete();
            return response()->json(['success' => 'true', 'msg' => 'Mentor deletado com sucesso', 'data' => $mentor],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()],400);
        }
    }
}
