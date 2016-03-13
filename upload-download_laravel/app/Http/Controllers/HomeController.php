<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $userId = \Auth::user()->id;        

        //Pega os dados do arquivo e do usuário
        $user = \App\User::with('files')->find($userId);
        
        //Manda o user para a view
        return view('home')->with(compact('user'));
    }


    public function upload(){

        //Pega o nome do documento la da view
        $file = \Request::file('documento');

        //Pega o id do usuário logado
        $userId = \Request::get('userId');

        //Pega o nome do usuário logado
        $userName = \Request::get('userName');

        //Cria a pasta "documentos/id-nome do usuário" dentro de storage e salva o conteúdo do upload
        $storagePath = storage_path().'/documentos/'.$userId.'-'.$userName;

        //Pega o nome do arquivo de origem da maquina do cliente
        $fileName = $file->getClientOriginalName();

        //Relacionando com banco de dados
        $fileModel = new \App\File();
        $fileModel->name = $fileName;

        //Depois de criado o arquivo em memória, associa-se a um usuário por meio do relacionamento

        $user = \App\User::find($userId);
        $user->files()->save($fileModel);

        return $file->move($storagePath, $fileName);
    }

    public function download($userId, $userName, $fileId){

        //Encontra o id do arquivo
        $file = \App\File::find($fileId);

        //Encontra o arquivo na pasta documentos referente ao usuário relacionado com o arquivo        
        $storagePath = storage_path().'/documentos/'.$userId.'-'.$userName;

        //Devolve como resposta o arquivo encontrado, faz download
        return \Response::download($storagePath.'/'.$file->name);
    }

    public function destroy($userId, $userName, $fileId){

        //Encontra o id do arquivo
        $file = \App\File::find($fileId);

        //Encontra o arquivo na pasta documentos referente ao usuário relacionado com o arquivo        
        $storagePath = storage_path().'/documentos/'.$userId.'-'.$userName;

        //Deleta o arquivo do banco de dados
        $file->delete();

        //Deleta o arquivo das pastas
        unlink($storagePath.'/'.$file->name);

        //Redireciona retornando uma mensagem de sucesso ao excluir para a view
        return redirect()->back()->with('success', 'Arquivo removido com sucesso!');
    }
}
