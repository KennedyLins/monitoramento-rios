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
    
  <!--Refresh Automatico da Pagina a cada 15 minutos (900 segundos)       TituloGrid  -->
  <meta http-equiv="refresh" content="900"> 

<link rel="stylesheet" https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css>
<link rel="stylesheet" href="{{asset('css/monitoramento-pluviometrosV3.css')}}" type="text/css">
<link rel="stylesheet" https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>

<style>
	.colorFlood{background-color: darkorange;}
	.colorAlert{background-color: yellow;}
	.colorPreAlert{background-color: lightyellow;}
	.legenda{

		align-self: right;
		border: solid 1.5px #c9cdca;
		width: 15%;
		height: 70%
		text-align: center;
	}

</style>

</head>

<body>
	<div class="container-sm">	
		<div class="content">
			<div class="row">
				<img src="{{asset('img/tira-apac-ana-governo.png')}}">
			</div>

			<div class="row border titulo">
			<h2>Monitoramento dos Rios do Estado de Pernambuco - v2</h2>
			<h2>Rede de Alerta<h2>
			</div>
			<div class="row border time">
			<h2>Informações atualizadas em : <?php echo date('d M Y') . " às " . date('H:i:s')?></h2>
			
			</div>
			<div class="legenda">
				<h3 class="colorPreAlert">Pre-alerta</h3>
				<h3 class="colorAlert">Alerta</h3>
				<h3 class="colorFlood">Inundação</h3>
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
						  <td class="gridDados">-</td>							
						</tr>									
				     @endforeach
				     
				  </tbody>
				</table>
			</div>
			</div>
		</div>
	</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script>


new Vue({		

	el: '#app',

	data: {		

		defineClass: ['gridDados','colorPreAlert','colorAlert','colorFlood']

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
		}		 
	}
})

</script>

</body>

</html>