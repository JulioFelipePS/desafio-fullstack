<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {
            try {
                $request->validate(
                    [
                        'login' => 'required|string',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required|string'
                    ],
                    [
                        'required' => 'O campo :attribute é obrigatório.',
                        'string' => 'O campo :attribute precisa ser uma string.',
                        'email' => 'O campo :attribute precisa ser um e-mail válido.',
                        'unique' => 'O :attribute já está em uso.',
    
                    ]
                );
    
                $requestData = $request->all();
    
                $requestData['password'] = Hash::make($requestData['password']);
                
                $user = User::create($requestData);
            
                // if($request->login=='admin'&& $request->password=='0101'){
                //     $user->role='admin';
                //     dd($user->role);

                // } 
                
                return response()->json([
                    'message' => 'Usuario criado com sucesso!',
                    'data' => $user
                ], Response::HTTP_CREATED);
            } catch (ValidationException $e) {
                // Tratar exceções de validação
                return response()->json([
                    'message' => $e->getMessage()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            } catch (QueryException $e) {
                // Tratar exceções de consulta ao banco de dados
                return response()->json([
                    'message' =>  $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            } catch (\Throwable $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
