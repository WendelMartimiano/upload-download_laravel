@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Upload de Arquivos</div>
                <!--Simples upload de arquivos -->
                <div class="panel-body">
                    
                    <span class="btn btn-info fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Selecionar arquivos...</span>

                        <input id="fileupload" type="file" name="documento" 
                        data-token="{!! csrf_token() !!}" 
                        data-user-id="{!! $user->id !!}"
                        data-user-name="{!! $user->name !!}"></input>

                        <!-- 'Auth::user()->id' serve para pegar o id do usuário logado. -->

                    </span>
                    
                    <br>
                    <br>

                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped"></div>
                    </div>

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {!! Session::get('success') !!}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Enviado em</th>
                                <th>Usuário</th>
                                <th>Ações</th>
                            </tr>
                        </thead>         
                        <tbody>
                            <!--Recebe o array de arquivos através de user -->
                            @foreach($user->files as $file)
                            <tr>
                                <th>{!! $file->name !!}</th>
                                <th>{!! $file->created_at !!}</th>
                                <th>{!! $user->name !!}</th>
                                <th>
                                    <a href="{!! route('files.download', [$user->id, $user->name, $file->id]) !!}" class="btn btn-xs btn-primary">download</a>
                                    <a href="{!! route('files.destroy', [$user->id, $user->name, $file->id]) !!}" class="btn btn-xs btn-danger">excluir</a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody> 

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    (function($){
        'use strict';
        $(document).ready(function(){

            var $fileupload = $('#fileupload');

            $fileupload.fileupload({
                url: '/upload',
                dadaType: 'json',
                formData: {_token: $fileupload.data('token'), 
                                userId: $fileupload.data('userId'), 
                                    userName: $fileupload.data('userName')},                
                
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css('width', progress + '%');
                }
            });

        });
    })(window.jQuery);
</script>
@stop