/**
 * Criação do menu hamburguer para mobile
 */
function hamburguerMenu() {
  var x = document.getElementById("menuTop");
  if (x.className === "topnav") {
    x.className += " responsive";
    document.getElementById("title-mobile").style.display = "none";
  } else {
    x.className = "topnav";  
    document.getElementById("title-mobile").style.display = "block";  
  }
}

/**
 * Criação da validação de formulário
 */
var bouncer = new Bouncer('[data-validate]',{  
      messageAfterField: true, 
      messageCustom: 'data-bouncer-message',
      messageTarget: 'data-bouncer-target',
      messages: {
        missingValue: {
          default: 'Informe o valor correto!'
        },     
        fallback: 'Erro!'
      },
  })
  
$(document).ready(function () {
    //Máscaras para número inteiros e valor
    $("input[name=codigo]").inputmask('integer');
    $("input[name=preco]").inputmask('decimal', {
      'alias': 'numeric',
      'groupSeparator': '.',
      'autoGroup': true,
      'digits': 2,
      'radixPoint': ",",
      'digitsOptional': false,
      'allowMinus': false,
      'prefix': 'R$ ',
      'placeholder': '0'
  });

  //Verifica se já existe código e exibe mensagem, caso positivo no cadastro do produto
  $( "input[name=codigo]" ).focusout(function() {
      $.post( "verificador", {codigo: $('input[name=codigo]').val()}, function( data ) {
          if(data.achou === true){
            Swal.fire(
              'Atenção!',
              'Este código já existe! Utilize outro.',
              'warning'
            )
            $('input[name=codigo]').val('');                    
          }
      });
    });

    //Acionar plugin para alert estilizado
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
      });
  
    //Realizar consulta AJAX para pesquisar produto pelo código
    $( "#pesquisar" ).click(function() {
        $.post( "produto/pesquisar", {produto: $('#produto').val()}, function( data ) {
            if(data.achou === true){
                $( ".result-error" ).hide();
                $('.txt-nome').html(data.descricao);
                $('.txt-codigo').html(data.codigo);
                $('#idProduto').val(data.id);
                $('.txt-valor').html(formataValor(data.preco));
                $( ".result-success" ).show();                    
            }else{
                $( ".result-success" ).hide();
                $( ".result-error" ).show();
            }
        });
    });
    
    //Realizar consulta AJAX para adicionar produto ao carrinho
    $( "#adicionar" ).click(function() {
        swalWithBootstrapButtons.fire({
            title: 'Adicionar ao carrinho?',
            text: "Você tem certeza que deseja adicionar o produto ao carrinho?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var idProduto = $('#idProduto').val();
                    var idDocumento = $('#idDocumento').val();
                    $.post( "adicionar", {produto: idProduto, documento: idDocumento}, function( data ) {
                        if(data.achou === true){
                            //Enquanto executa o insert na tabela documento e item
                            //Se deu certo coloca o quadro dentro do quadrado
                            $( ".result-error" ).hide();
                            $( ".result-success" ).hide(); 

                            $('#idDocumento').val(data.numero);
                            $('#produto').val('');
                            $('.informe-adicionar').hide();
                            $('#confirmar').show();

                            html = '<div class=\"card linha-produto\">'+"\n";
                            html += '<div class=\"card-body\">'+"\n";
                            html += '<h5 class=\"card-title\">'+data.descricao+'</h5>'+"\n";
                            html += '<h6 class=\"card-subtitle mb-2 text-muted\">Cód.: '+data.codigo+'</h6>'+"\n";
                            html += '<p class=\"card-text\">'+formataValor(data.preco)+'</p>'+"\n";
                            html += '</div>'+"\n";
                            html += '</div>'+"\n";                           
        
                            $('.carrinho').append( html );
                                            
                        }else{                    
                            console.log('Exibir mensagem de erro.');
                        }
                    });

                } 
            })
    });

    //Realizar ação para cancelar venda
    $( "#cancelar" ).click(function() {
        swalWithBootstrapButtons.fire({
            title: 'Cancelar venda?',
            text: "Você tem certeza que deseja cancelar a venda?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var idDocumento = $('#idDocumento').val();
                    $.post( "cancelar", {documento: idDocumento}, function( data ) {
                        if(data.achou === true){
                            //Redireciona para a mesma tela
                            document.location.reload(true);                                       
                        }else{                    
                            console.log('Exibir mensagem de erro.');
                        }
                    });

                } 
            })  
        });
     //Mensagem com alert para confirmar venda
     $( "#confirmar" ).click(function() {
      swalWithBootstrapButtons.fire({
          title: 'Confirmar a venda?',
          text: "Você tem certeza que deseja confirmar a venda?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sim',
          cancelButtonText: 'Não',
          reverseButtons: true
          }).then((result) => {                    
              if (result.value) {                        
                  $('#formConfirma').submit();                        
              }
          })
     });
});

//Formatar valores para monetário BRL
function formataValor(valor) {    
  valor = valor + '';
  valor = parseInt(valor.replace(/[\D]+/g,''));
  valor = valor + '';
  valor = valor.replace(/([0-9]{2})$/g, ",$1");
  
  if (valor.length > 6) {
    valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
  }
  
  return 'R$ ' + valor;
}

  