@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
        
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalClient"> Cadastrar Cliente </button>
                    <button type="button" class="btn btn-warning" onclick="getClients()" > Listar Cliente </button>
                </div>

                <div class="card-body">
                    <table id="tb_clients" class="table mt-2">
                        <thead>
                            <tr>
                                <th scope="col">CLIENT_ID</th>
                                <th scope="col">SECRET</th>
                                <th scope="col">NOME</th>
                                <th scope="col">URL REDIRECIONAMENTO</th>
                            </tr>
                        </thead>
                        <tbody>                            
                        </tbody>
                    </table>
                </div>
            </div>
    
        </div>
    </div>

    <div class="container">
        
        <!-- Modal -->
        <div class="modal fade" id="modalClient" tabindex="-1" role="dialog" aria-labelledby="modalClientLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalClientLabel">Cadastrar Client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm-client">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" id="nome" name="name" placeholder="Nome">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" id="redirect" name="redirect" placeholder="Url de redirecionamento">
                                </div>
                            </div>                       
                        </form>                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="postClients()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')

<script>

    /**
    *
    */
    function getClients(){

        $('#painel').val("");

        $.ajax({
            method: "GET",
            url: "{{asset('/oauth/clients')}}",
            success:function(data){

                let tr = '';
                $.each(data, (i,v) => {
                    tr += `<tr>
                                <td>${v.id}</td>
                                <td>${v.secret}</td>
                                <td>${v.name}</td>
                                <td>${v.redirect}</td>
                            </tr>`;
                });

                console.log(tr);
                $('#tb_clients tbody').html(tr);

            },error:function(error){

                let text_error = 'error:' + '\n' + error;
                $('#painel').val(text_error);
            }
        });                    
    }   

    /**
    *
    */
    function postClients(){


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "Post",
            url: "{{asset('/oauth/clients')}}",
            data:$('#frm-client').serialize(),
            success:function(data){

                getClients();
                $('#modalClient').modal('hide')

            },error:function(error){
                console.log(error.responseJSON.message);
                console.log(error);
                alert('status code : ' + error.status + "\n" +"messagem : " + error.responseJSON.message);
            }
        });                    
    }
    
    $(document).ready(function() {
        getClients();
    });

</script>
    
@endsection
