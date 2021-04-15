<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
  <title>APAC - Agência Pernambucana de Águas e Climas</title>

  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="content-language" content="pt-BR">
    
  <!--Refresh Automatico da Pagina a cada 15 minutos (900 segundos)-->
  <meta http-equiv="refresh" content="900"> 

<!--<link rel="stylesheet" https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css>-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css/monitoramento-pluviometrosV3.css')}}" type="text/css">
<link rel="stylesheet" https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">




</head>

<body>
	<div class="container-sm">	
		<div class="content">
			<div class="row">
				<img src="{{asset('img/tira-apac-ana-governo.png')}}">
			</div>

			<div class="row ">
				<h4>Monitoramento dos Rios do Estado de Pernambuco - v2</h4>
				<div class="row ">
				<h4>Rede de Alerta</h4>
				</div>
			</div>
			<div class="row border time">
				<h6>Informações atualizadas em : <?php echo date('d M Y') . " às " . date('H:i:s')?></h6>
			
			</div>
			<div class="legenda">
				<p class="colorPreAlert">Pre-alerta</p>
				<p class="colorAlert">Alerta</p>
				<p class="colorFlood">Inundação</p>
			</div>

			<div class="listaRios">

			<div id="app">
				
				<table class="table table-sm" align="center">
				  <tbody>
				    <tr class="TituloGrid">
				      <th class="">Cód. Estação</th>
				      <th class="">Local</th>
				      <th class="">Rio</th>
				      <th class="">Data <br> (Último dado)</th>
				      <th class="">Hora <br> (Último dado)</th>
				      <th class=" colunaAtual">Nível <br> Atual (cm)</th>
				      <th class="">Nível <br> Alerta (cm) </th>
				      <th class="">Nível <br> Inundação (cm) </th>
				      <th class="">Gráfico</th>
				    </tr>

				      @foreach ($hidro_stations as  $hidro_station)

					    <tr v-bind:class="defineStatus({{$hidro_station}})">
					      <td class="gridDados" >{{$hidro_station->idStation}}</td>	
					      <td class="gridDados">{{$hidro_station->nameStation}}</td>
					      <td class="gridDados">{{$hidro_station->river}}</td>
					      <td class="gridDados">{{$hidro_station->dataColeta}}</td> 
					      <td class="gridDados">{{$hidro_station->horaColeta}}</td>       
					      <td class="gridDados">{{$hidro_station->levelNow}}</td>
					      <td class="gridDados">{{$hidro_station->alertLevel}}</td>
					      <td class="gridDados">{{$hidro_station->floodLevel}}</td>
						  <td ><button class="btn" data-toggle="modal" data-target="#meuModal" v-on:click="showGraph({{$hidro_station}})"><i class="fa fa-search"></i></button></td>							
						</tr>									
				     @endforeach


				  </tbody>
				</table>
			</div>
			</div>
		</div>
	</div>

<!--Modal -->
<div id="meuModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Conteúdo do modal-->
        <div id="modalContent"class="modal-content">

          <!-- Cabeçalho do modal -->
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Corpo do modal -->
            <div id="modalbody" class="modal-body">
				<div id='conteudomodal'></div>
              
            </div>

            <!-- Rodapé do modal-->
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    
			</div>

        </div>
      </div>
    </div>

<!-- Fim Modal -->

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>


<!--Trabalhando com Vue js para alterar as cores dos alertas -->
<script>

new Vue({		

	el: '#app',

	data: {		

		defineClass: ['gridDados','colorPreAlert','colorAlert','colorFlood'],

	},
	methods: {

		defineStatus (dados){

			if (dados.levelNow === 'PCD EM MANUTENÇÃO' || dados.levelNow === 'Dado não coletado na última atualização'){

				return this.defineClass[0]
			}else{

				if(dados.levelNow >= dados.preAlertLevel && dados.levelNow < dados.alertLevel){
					return this.defineClass[1]
				}else if(dados.levelNow >= dados.alertLevel && dados.levelNow < dados.floodLevel){
					return this.defineClass[2]
				}else if(dados.levelNow >= dados.floodLevel){
					return this.defineClass[3]
				}else{
					return this.defineClass[0]
				}
			}			
		},

		showGraph (dados2){

			return console.log(dados2.idStation)
		}	 
	}
})

</script>



<!--Trabalhando com google chart para gerar os gráficos -->
<script>

   google.load("visualization", "1", {packages:["corechart"]});
      
   google.setOnLoadCallback(drawChart);
      
      
      function drawChart() {

    //montando o array com os dados
        var data = google.visualization.arrayToDataTable([
          ['Hora', 'Nível'],
          ['18:00',  67.90],
          ['18:30',  62.90],
          ['19:00',  75.40],
          ['19:30',  72.90],
          ['20:00',  70.50],
          ['20:30',  67.90],
          ['21:00',  65.12],
          ['21:30',  59.90],
          ['22:00',  62.17],
         
        ]);
        
    //opções para o gráfico linhas
    var options = {
          title: 'Nível do Rio',

          //legenda na horizontal
          hAxis: {
          	title: 'Data/Hora',  
          	titleTextStyle: {color: 'blue'}},
          width: 450,
          height: 200	
        };

    //instanciando e desenhando o gráfico linhas
        var linhas = new google.visualization.LineChart(document.getElementById('conteudomodal'));
        linhas.draw(data, options);

      }
    </script>

</body>

</html>